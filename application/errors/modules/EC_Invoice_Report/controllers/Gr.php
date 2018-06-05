<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Gr extends MX_Controller {

    private $user;

    public function __construct() {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->user = $this->session->userdata('FULLNAME');
    }

    public function index() {
        $data['title'] = "List Approval GR";
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/Gr_report.js');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/invoice/common.css');
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');

        $this->layout->render('EC_Invoice_Report/Gr/list', $data);
    }
    public function datatable(){
  		$tmp = $this->_data();
  		$result = array();
  		$_result = array();
  		/* grouping berdasarkan no_rr */
  		if(!empty($tmp)){
  			foreach ($tmp as $k => $v) {
  				$rr = $v['NO_RR'];
  				if(!isset($result[$rr])){
  					$_result[$rr] = array();
  				}
  				array_push($_result[$rr],$v);
  			}
  		}
  		if(!empty($_result)){
  			foreach($_result as $_r){
  				$_tmp = array();
  				foreach($_r as $_s){
  					array_push($_tmp,array('GR_NO' => $_s['GR_NO'],'GR_ITEM_NO' => $_s['GR_ITEM_NO'],'GR_YEAR' => $_s['GR_YEAR']));
  				}
  				$_r[0]['DATA_ITEM'] = json_encode($_tmp);
  				array_push($result,$_r[0]);
  			}
  		}
  		$this->output
          ->set_content_type('application/json')
          ->set_output(json_encode(array('data' => $result)));
  	}
  	/* ambil semua gr bahan / spare part yang belum diapprove */
  	private function _data(){
  		$listPlant = $this->listPlantAccess();
  		$_lp = implode('\',\'',$listPlant);
  		$sql = <<<SQL
  		select EGS.PO_NO
  			,EGS.PO_ITEM_NO
  			,EGS.GR_NO
  			,EGS.GR_NO
  			,EGS.GR_ITEM_NO
  			,EGS.GR_YEAR
  			,EGS.JENISPO
  			,EG.TXZ01
  			,EG.NAME1
  			,EG.LFBNR NO_RR
  			,EGS.JENISPO
        ,case
          when EGS.STATUS = 0 then 'Belum Approve'
          when EGS.STATUS = 1 then 'Approve Kasie'
          when EGS.STATUS = 2 then 'Approve Kabiro'
          else '-'
          end STATUS
        ,EGS.CREATED_AT
  			from EC_GR_STATUS EGS
  			join EC_GR_SAP EG
  			on EG.EBELN = EGS.PO_NO
  			   AND EG.EBELP = EGS.PO_ITEM_NO
  			   AND EG.BELNR = EGS.GR_NO
  			   AND EG.BUZEI = EGS.GR_ITEM_NO
  			   AND EG.GJAHR = EGS.GR_YEAR
  			where EGS.JENISPO = 'BAHAN' and EGS.PLANT in ('{$_lp}')
  			union
  			select EGS.PO_NO
  				,EGS.PO_ITEM_NO
  				,EGS.GR_NO
  				,EGS.GR_NO
  				,EGS.GR_ITEM_NO
  				,EGS.GR_YEAR
  				,EGS.JENISPO
  				,EG.TXZ01
  				,EG.NAME1
  				,(select BELNR from EC_GR_SAP where LFBNR = EGS.GR_NO and LFPOS = EGS.GR_ITEM_NO and LFGJA = EGS.GR_YEAR AND BWART = 105) NO_RR
  				,EGS.JENISPO
          ,case
            when EGS.STATUS = 0 then 'Belum Approve'
            when EGS.STATUS = 1 then 'Approve Kasie'
            when EGS.STATUS = 2 then 'Approve Kabiro'
            else '-'
            end STATUS
          ,EGS.CREATED_AT
  			from EC_GR_STATUS EGS
  			join EC_GR_SAP EG
  			on EG.EBELN = EGS.PO_NO
  			   AND EG.EBELP = EGS.PO_ITEM_NO
  			   AND EG.BELNR = EGS.GR_NO
  			   AND EG.BUZEI = EGS.GR_ITEM_NO
  			   AND EG.GJAHR = EGS.GR_YEAR
  			where EGS.JENISPO = 'SPARE_PART' and EGS.PLANT in ('{$_lp}')
      order by CREATED_AT DESC
SQL;

  		return $this->db->query($sql)->result_array();
  	}

  	private function listPlantAccess(){
  		$this->user_email = $this->session->userdata('EMAIL'); // login pakai email tanpa semen indonesia.com
  		/* dapatkan role untuk fitur verifikasi ini */
  		$this->load->model('invoice/ec_role_user', 'role_user');
  		$email_login = explode('@', $this->user_email);
  		$plant = array();
  		$_tmp = $this->db->where(array('USERNAME' => $email_login[0], 'STATUS' => 1))->like('ROLE_AS','GUDANG','after')->get('EC_ROLE_USER')->result_array();
  		$role = array();
  		if(!empty($_tmp)){
  			foreach($_tmp as $_t){
  				array_push($role,$_t['ROLE_AS']);
  			}
  			$this->load->model('invoice/ec_role_access','era');
  			$era = $this->db->where('OBJECT_AS = \'PLANT\' AND ROLE_AS in (\''.implode('\',\'',$role).'\')')->get('EC_ROLE_ACCESS')->result_array();
  			if(!empty($era)){
  				foreach($era as $_p){
  					$plant = array_merge($plant,explode(',',$_p['VALUE']));
  				}
  			}
  		}
  		/* cari plant untuk role yang dimiliki */
  		return array_unique($plant);
  	}
}

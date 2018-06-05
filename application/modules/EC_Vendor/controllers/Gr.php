<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gr extends MX_Controller {

	private $USER;
	public function __construct() {
		parent::__construct();

		$this -> load -> helper('url');
		$this -> load -> library('Layout');
		$this -> load -> helper("security");
		// $this -> USER = explode("@", $this -> session -> userdata['USERNAME']);
	}

	public function index(){
    $this -> load -> library('Authorization');
    $data['title'] = "List GR";
        //$data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
		$this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
		$this->layout->add_js('jquery.redirect.js');
		$this->layout->add_js('pages/invoice/EC_common.js');

        $this->layout->add_css('plugins/daterangepicker/daterangepicker.css');
        $this->layout->add_js('plugins/daterangepicker/daterangepicker.js');
        
        $this->layout->add_js('pages/invoice/ec_vendor_gr.js');

        $this->layout->render('EC_Vendor/gr/list',$data);
   	}

	public function detail(){
		//var_dump($this->input->post());
		$data['title'] = "Detail GR";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/invoice/EC_common.js');
		$this->layout->add_js('bootbox.js');
		$this->layout->add_js('pages/invoice/ec_vendor_gr_detail.js');

		$this->load->model('invoice/ec_gr_status','egs');

        $data['gr_year'] = $this->input->post('year');
		$data['po_no'] = $this->input->post('po_no');
       	$data['vendor'] = $this->input->post('vendor');
        $data['act'] = $this->input->post('act');
        $data['print_type'] = $this->input->post('print_type');
		$data['lot_number'] = $this->input->post('lot_number');
        	
        $po_rr = $this->egs->as_array()->order_by('GR_NO,GR_ITEM_NO')->get_all(array('LOT_NUMBER' => $data['lot_number']));
        $gr = array();


        	$temp_lot = $this->db->select('STATUS,REJECTED_BY,NOTE_REJECT,REJECTED_GR')->where(array('LOT_NUMBER'=>$data['lot_number']))->get('EC_GR_LOT')->result_array();
        	
        	if($temp_lot[0]['STATUS'] == 4){
        		$data['reject_by'] = $temp_lot[0]['REJECTED_BY'];
        		$data['note_reject'] = $temp_lot[0]['NOTE_REJECT'];

        		$po_rr = array();
        		$i = 0;
        		foreach ($temp_lot as $value) {
        			$temp_1 = explode('-', $value['REJECTED_GR']);
        			foreach ($temp_1 as $val) {
        				$temp_2 = explode('#', $val);
        				$po_rr[$i]['PO_NO'] = $temp_2[0];
        				$po_rr[$i]['PO_ITEM_NO'] = $temp_2[1];
        				$po_rr[$i]['GR_NO'] = $temp_2[2];
        				$po_rr[$i]['GR_YEAR'] = $temp_2[3];
        				$po_rr[$i]['JENISPO'] = $temp_2[4];
        				$i++;
        			}
        		}
        		//var_dump($po_rr);die();
        	}

        	foreach ($po_rr as $val) {
        		switch ($val['JENISPO']) {
					case 'BAHAN':
						$barang = $this->egs->detailGrBahan($val['GR_NO'],$val['PO_NO'],$val['PO_ITEM_NO']);
						foreach ($barang as $value) {
							$gr[] = $value;
						}
					break;
					default:
						$no = $this->db->where(array('LFBNR'=>$val['GR_NO'],'BWART' => '105', 'LFGJA' => $val['GR_YEAR']))->get('EC_GR_SAP')->row_array();

						$sparepart = $this->egs->detailGrSparepart($no['BELNR'],$val['PO_NO'],$val['PO_ITEM_NO']);

						foreach ($sparepart as $value) {
							$gr[] = $value;
						}
					break;
				}
        	}
        	$data['detail'] = $gr;
        
		$this->layout->render('EC_Vendor/gr/detailGR',$data);
	}

	public function listGR(){
		$this->load->model('invoice/ec_gr_status','egs');
		$gr = $this->input->post('data');

		/*Get Data GR*/
		$data['detail'] = array();
		$data['gr'] = implode('#', $gr);

		$count = 0;

		foreach ($gr as $val) {
			$temp = explode(';', $val);
			//var_dump($temp);die();
			switch ($temp[3]) {
				case 'BAHAN':
					$data['detail'][$temp[1]] = $this->egs->detailGrBahan($temp[1],$temp[0]); // RR,PO
					break;
				default:
					$data['detail'][$temp[1]] = $this->egs->detailGrSparepart($temp[1],$temp[0]);
					break;
			}
			$count++;
		}
		$data['count'] = $count;
		//echo '<pre>';
		//var_dump($data);
		$this->load->view('gr/detailGR',$data);
	}

	public function data($check = null){
		$tmp = $this->_data($check);
		//echo $this->db->last_query();die();
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

	public function getGrQuery($status = null){

		$sql = <<<SQL
		select EGS.PO_NO
			,EGS.PO_ITEM_NO
			,EGS.GR_NO
			,EGS.GR_ITEM_NO
			,EGS.GR_YEAR
			,EGS.JENISPO
			,EG.TXZ01
			,EG.NAME1
			,EG.BUDAT DOC_DATE
			,EG.LFBNR NO_RR
			,EGS.LOT_NUMBER
			,EG.ERNAM
			,EG.LIFNR
			--,EGS.GR_NO
			--,EGS.JENISPO
			from EC_GR_STATUS EGS
			join EC_GR_SAP EG
			on EG.EBELN = EGS.PO_NO
			   AND EG.EBELP = EGS.PO_ITEM_NO
			   AND EG.BELNR = EGS.GR_NO
			   AND EG.BUZEI = EGS.GR_ITEM_NO
			   AND EG.GJAHR = EGS.GR_YEAR
			where EGS.JENISPO = 'BAHAN' AND EGS.STATUS = '3'
			union
			select EGS.PO_NO
				,EGS.PO_ITEM_NO
				,EGS.GR_NO
				,EGS.GR_ITEM_NO
				,EGS.GR_YEAR
				,EGS.JENISPO
				,EG.TXZ01
				,EG.NAME1
				,EG.BUDAT DOC_DATE
				,(select max(BELNR) from EC_GR_SAP where LFBNR = EGS.GR_NO and LFPOS = EGS.GR_ITEM_NO and LFGJA = EGS.GR_YEAR AND BWART = 105) NO_RR
				,EGS.LOT_NUMBER
				,EG.ERNAM
				,EG.LIFNR
				--,EGS.JENISPO
				--,EGS.GR_NO
			from EC_GR_STATUS EGS
			join EC_GR_SAP EG
			on EG.EBELN = EGS.PO_NO
			   AND EG.EBELP = EGS.PO_ITEM_NO
			   AND EG.BELNR = EGS.GR_NO
			   AND EG.BUZEI = EGS.GR_ITEM_NO
			   AND EG.GJAHR = EGS.GR_YEAR
			where EGS.JENISPO = 'SPARE_PART' AND EGS.STATUS = '3'
SQL;

		return $sql;
	}

	/* ambil semua gr bahan / spare part yang belum diapprove */
	public function _data($status = null){
		$no_vendor = $this->session->userdata('VENDOR_NO');
		$sql = 'SELECT * FROM(';
		$sql .= $this->getGrQuery($status);
		$sql .= ")A WHERE A.LIFNR = '$no_vendor'";
		//echo $sql;die();
		return $this->db->query($sql,false)->result_array();
	}

	public function data_loted($status = null){
		$data = $this->_data_loted($status);
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array('data' => $data)));
	}

	private function _data_loted($status = null){
		$no_vendor = $this->session->userdata('VENDOR_NO');
		$sql = "
			SELECT DISTINCT EGL.LOT_NUMBER
				,STATUS
				,TO_CHAR(CREATED_AT,'dd/mm/yyyy') AS CREATE_DATE
				,CREATED_BY
				,TO_CHAR(APPROVED1_AT,'dd/mm/yyyy') AS APPR1_DATE
				,APPROVED1_BY
				,TO_CHAR(APPROVED2_AT,'dd/mm/yyyy') AS APPR2_DATE
				,APPROVED2_BY
				,PO_NO
				,GR_YEAR
				,NAME1 AS VENDOR
				,GR.JENISPO
				,REJECTED_BY
				,PRINT_TYPE
			FROM EC_GR_LOT EGL
			JOIN (
			SELECT * FROM (";
		$sql .= $this->getGrQuery($status);
		$sql .= "
				)
			)GR ON EGL.LOT_NUMBER = GR.LOT_NUMBER 
			WHERE GR.LIFNR = '$no_vendor' ORDER BY EGL.LOT_NUMBER DESC";

			//echo $sql;die;
		return $this->db->query($sql)->result_array();
	}

	public function showData(){
		//$sql = "SELECT * FROM EC_GR_LOT WHERE LOT_NUMBER = 75";
		//$sql = "SELECT * FROM EC_GR_STATUS WHERE LOT_NUMBER = 66";

		//$sql = "UPDATE EC_GR_STATUS SET STATUS=1 WHERE STATUS = 4";
		//$sql = "UPDATE EC_GR_LOT SET STATUS=1 WHERE STATUS = 4";
		//$data = $this->db->query($sql);

		//$sql = "SELECT * FROM EC_ROLE_ACCESS WHERE ROLE_AS = 'APPROVAL GR LVL 1' AND OBJECT_AS = 'LEVEL'";
		//$sql = "UPDATE EC_ROLE_ACCESS SET VALUE='1,4' WHERE ROLE_AS = 'APPROVAL GR LVL 1' AND OBJECT_AS = 'LEVEL'";
		//$data = $this->db->query($sql)->result_array();
		var_dump($this->session->userdata);
	}
}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pomut extends MX_Controller {
	private $user;
	private $user_email;
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('url');
		$this -> load -> library('Layout');
		$this -> load -> helper("security");
		$this->user = $this->session->userdata('FULLNAME');
		$this->user_email = $this->session->userdata('EMAIL');
		$this->load->model('invoice/ec_pomut','pm');
	}

	public function index(){
    	$this -> load -> library('Authorization');
    	$data['title'] = "Approval BA Analisa Mutu";
    	$this->layout->set_table_js();
    	$this->layout->set_table_cs();
    	$this->layout->set_validate_css();
    	$this->layout->set_validate_js();

    	$this->layout->add_css('pages/EC_miniTable.css');
    	$this->layout->add_css('pages/invoice/common.css');

		$this->layout->add_js('bootbox.js');
		$this->layout->add_js('pages/invoice/EC_common.js');
    	$this->layout->add_js('pages/invoice/Approval_pomut.js');
    	$this->layout->render('EC_Approval/pomut/list',$data);
  	}

	public function detail(){
		$data['title'] = "Detail BERITA ACARA Analisa Mutu";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/invoice/EC_common.js');
		$this->layout->add_js('bootbox.js');
		$this->layout->add_js('pages/invoice/Approval_pomut_detail.js');


    	$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');

        $data['ba_no'] = $this->input->post('ba_no');
		$data['po_no'] = $this->input->post('po_no');
		$data['material'] = $this->input->post('material');
       	$data['vendor'] = $this->input->post('vendor');
       	
       	$act= $this->input->post('act');

       	$data['act'] = $act;

       	$data['header'] = $this->pm->getSingleHeader($data['ba_no']); 
       	$data['detail'] = $this->pm->getDataDetail($data['ba_no']);


       	$level = $this->listLevelAccess();
       	$data['status'] = $level[0] + 1;

       	if($act == 'view')$data['status'] = 2;
       	
       	$data['url'] = $data['status'] == 1 ? base_url('EC_Approval/Pomut/createBA') : base_url('EC_Approval/Pomut/approvalBA');

       	//var_dump($data);die();
		$this->layout->render('EC_Approval/pomut/detail',$data);
	}

	public function data(){
        $plant = implode("','",$this->listPlantAccess());
        $level = implode("','",$this->listLevelAccess());
		$data = $this->pm->getDataHeader($plant,$level);
		//echo $this->db->last_query();
		echo json_encode(array('data'=>$data));
	}

	public function createBA(){
		$data_update = $this->input->post();
		$no_ba = $this->input->post('NO_BA');
		$data_update['CREATED_BY'] = $this->user;
		$data_update['STATUS'] = 1;

		$this->db->set('TGL_BA','TO_DATE(\''.$data_update['TGL_BA'].'\',\'DD-MM-YYYY\')',FALSE);
		$this->db->set('CREATED_AT','SYSDATE',FALSE);
		unset($data_update['TGL_BA']);
		$act = $this->db->where('NO_BA',$no_ba)->update('EC_POMUT_HEADER_SAP',$data_update);

		if($act){
			$pesan = 'Create Berita Acara No.'.$no_ba.' BERHASIL';
			$this->session->set_flashdata('message', $pesan);
			redirect('EC_Approval/Pomut');
		}else{
			die('GAGAL');
		}
	}

	public function approvalBA(){
		$data_update = $this->input->post();

		$no_ba = $this->input->post('NO_BA');
		unset($data_update['TGL_BA']);

		$data_update['APPROVED_BY'] = $this->user;
		$data_update['STATUS'] = 2;

		$this->db->set('APPROVED_AT','SYSDATE',FALSE);

		$act = $this->db->where('NO_BA',$no_ba)->update('EC_POMUT_HEADER_SAP',$data_update);

		if($act){
			$pesan = 'Approval Berita Acara No.'.$no_ba.' BERHASIL';
			$this->session->set_flashdata('message', $pesan);
			redirect('EC_Approval/Pomut');
		}else{
			die('GAGAL');
		}
	}

	public function cetakBeritaAcara(){
        $this->load->config('ec');

        //var_dump($this->input->post());die();

        $data['no_ba'] = $this->input->post('no_ba');

        $data['header'] = $this->pm->getSingleHeader($data['no_ba']); 
       	$data['detail'] = $this->pm->getDataDetail($data['no_ba']);

        $data['kota'] = $data['header']['KOTA'] == null ? $this->input->post('kota') : $data['header']['KOTA'];
        $data['kasi'] = $data['header']['KASI_PENGADAAN'] == null ? $this->input->post('kasi') : $data['header']['KASI_PENGADAAN'];

        $tgl_ba = $data['header']['TGL_BA2'] == null ? $this->input->post('tgl_ba') :  $data['header']['TGL_BA2'];
        $data['tgl_ba'] = $this->getDetailDay($tgl_ba);

       	$company_data = $this->config->item('company_data');

       	$data['delivery'] = $this->getFromToDate($data['no_ba']);

       	$data['company'] = $company_data[$data['header']['BUKRS']];

       	$data['formula'] = $this->getFormula($data['no_ba']);

       	//var_dump($data);die();

        $html = $this->load->view('pomut/cetak',$data,TRUE);

        $this->load->library('M_pdf');
        $mpdf = new M_pdf();
        $mpdf->pdf->writeHTML($html);
        $mpdf->pdf->output('Berita Acara Analisa Mutu - '.$data['no_ba'].'.pdf','I');
    }

    private function getFormula($no_ba){
    	return $this->db->select('NO_BA,JENIS_FORMULA,MKMNR,MIC_DESC,OPERATOR,FORMULA')->where('NO_BA',$no_ba)->group_by('NO_BA,JENIS_FORMULA,MKMNR,MIC_DESC,OPERATOR,FORMULA')->get('EC_POMUT_FORMULA_SAP')->result_array();
    }

    private function getFromToDate($no_ba){
    	$sql = "
			SELECT 	min(TGL_FROM) TGL_FROM
					,max(TGL_TO) TGL_TO 
			FROM EC_POMUT_DETAIL_SAP 
			WHERE NO_BA = '$no_ba'";
		return $this->db->query($sql,false)->row_array();
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

	private function listLevelAccess(){
		$this->user_email = $this->session->userdata('EMAIL'); // login pakai email tanpa semen indonesia.com
		/* dapatkan role untuk fitur verifikasi ini */
		$this->load->model('invoice/ec_role_user', 'role_user');
		$email_login = explode('@', $this->user_email);
		$level = array();
		$_tmp = $this->db->where(array('USERNAME' => $email_login[0], 'STATUS' => 1))->like('ROLE_AS','APPROVAL ANALISA MUTU','after')->get('EC_ROLE_USER')->result_array();

		$role = array();
		if(!empty($_tmp)){
			foreach($_tmp as $_t){
				array_push($role,$_t['ROLE_AS']);
			}
			$this->load->model('invoice/ec_role_access','era');
			$era = $this->db->where('OBJECT_AS = \'LEVEL\' AND ROLE_AS in (\''.implode('\',\'',$role).'\')')->get('EC_ROLE_ACCESS')->result_array();
			if(!empty($era)){
				foreach($era as $_p){
					/* kurangkan 1 supaya menghasilkan level dibawahnya, level 1 itu menjadikan status gr menjadi 1, jadi status sebelumnya 0 ( level - 1 )*/
					$level = array_merge($level,explode(',',$_p['VALUE'] - 1));
				}
			}
		}
		/* cari plant untuk role yang dimiliki */
		return array_unique($level);
	}

	public function getDetailDay($tgl){ // DD-MM-YYYY
		$temp = substr($tgl, 6,4).'-'.substr($tgl, 3,2).'-'.substr($tgl, 0,2);

		$temp_M = substr($tgl, 3,2);
		$temp_D = substr($tgl, 0,2);
		$temp_Y = substr($tgl, 6,4);
		
		$date = strtotime($temp);
		$temp_day = date('D', $date);

		$hari = array(
			'Sun' => 'Minggu',
			'Mon' => 'Senin',
			'Tue' => 'Selasa',
			'Wed' => 'Rabu',
			'Thu' => 'Kamis',
			'Fri' => "Jum'at",
			'Sat' => 'Sabtu'
		);

		$bulan = array(
			'01'=>'Januari',
			'02'=>'Februari',
			'03'=>'Maret',
			'04'=>'April',
			'05'=>'Mei',
			'06'=>'Juni',
			'07'=>'Juli',
			'08'=>'Agustus',
			'09'=>'September',
			'10'=>'Oktober',
			'11'=>'November',
			'12'=>'Desember');
		return array(
			'tanggal_angka' => $tgl,
			'tanggal_lengkap' => $temp_D.' '.$bulan[$temp_M].' '.$temp_Y,
			'hari' => $hari[$temp_day],
			'tanggal' => $temp_D,
			'bulan' => $bulan[$temp_M],
			'tahun' => $temp_Y
		);
	}


	public function ReportBA(){
		$this -> load -> library('Authorization');
    	$data['title'] = "REPORT BA Potongan Mutu";
    	$this->layout->set_table_js();
    	$this->layout->set_table_cs();
    	$this->layout->set_validate_css();
    	$this->layout->set_validate_js();

    	$this->layout->add_css('pages/EC_miniTable.css');
    	$this->layout->add_css('pages/invoice/common.css');

		$this->layout->add_js('bootbox.js');
		$this->layout->add_js('pages/invoice/EC_common.js');
    	$this->layout->add_js('pages/invoice/Approval_pomut_report.js');
    	$this->layout->render('EC_Approval/pomut/listReport',$data);
	}

	public function dataReport($status = 3){
		$status = $status==1 ? "1','2" : $status;
		$data = $this->pm->getDataReport($status);
		echo json_encode(array('data'=>$data));
	}

	public function Test(){
		$data = $this->db->get('EC_POMUT_DETAIL_SAP')->result_array();
		var_dump($data);
	}
	
}

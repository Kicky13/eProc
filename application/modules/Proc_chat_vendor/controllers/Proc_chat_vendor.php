<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proc_chat_vendor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
	}

	public function index() {
		$data['title'] = "Klarifikasi teknis dan harga";
		$data['success'] = $this->session->flashdata('success') == 'success';
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/prc_chat_vendor.js');
		$this->layout->render('list',$data);
	}

	public function getlongtext() {
		$PPI_ID = $this->input->post('PPI_ID');
		$data['matnr'] = $this->input->post('PPI_NOMAT');
		$data['banfn'] = substr($PPI_ID, 0, 10);
		$data['bnfpo'] = sprintf("%05d", substr($PPI_ID, 10));

		$this->load->library('sap_handler');
		$data['return'] = $this->sap_handler->getlongtext(array($data));
		foreach ($data['return'] as $var) {
			$data['isi'][$var['TYPE']][] = $var['TDLINE'];
		}

		echo $this->load->view('Quotation/detail_material', $data, true);
	}

	public function get_list() {
		$this->load->model('prc_chat');

		$this->prc_chat->join_ptm();
		$this->prc_chat->join_employee_vendor();
		$this->prc_chat->order_ptm(); 
		$pc = $this->prc_chat->get(array('PRC_CHAT.VENDOR_NO'=>$this->session->userdata('VENDOR_NO'), 'NEXT_PROSES'=>0));
		$number_ptm = '';
		$pchat=array();
		foreach($pc as $p){
			if($p['PTM_NUMBER'] != $number_ptm){
				$p['TGL']=betteroracledate(oraclestrtotime($p['TGL']));
				$p['PTM']=url_encode($p['PTM_NUMBER']);
				$pchat[]=$p;
			}
			$number_ptm = $p['PTM_NUMBER'];
		}
		
		echo json_encode(array('data' => $pchat));
	}

	public function detail($id){
		$this->load->model('prc_chat');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_eval_file');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_item');
		$this->load->library('snippet');
		$ptm_number=url_decode($id);
		$vendorno = $this->session->userdata('VENDOR_NO');

		$data['title'] = "Klarifikasi Teknis Detail";
		$this->prc_chat->order_tgl();
		$this->prc_chat->join_employee_vendor();
		$data['pesan'] = $this->prc_chat->get(array('PRC_CHAT.PTM_NUMBER'=>$ptm_number,'PRC_CHAT.VENDOR_NO'=>$vendorno, 'NEXT_PROSES'=>0));
		$data['ptm']=$id;
		$data['detail_ptm'] = $this->snippet->detail_ptm($ptm_number, false, true);
		$data['dokumen_pr'] = $this->snippet->dokumen_pr($ptm_number, 0, true, true);
		
		$pqm = $this->prc_tender_quo_main->ptmptv($ptm_number, $vendorno);
		if (empty($pqm)) {
			$data['pqm_id'] = null;
		} else {
			$data['pqm'] = $pqm[0];
			$data['pqm_id'] = $data['pqm']['PQM_ID'];
			$pqi = $this->prc_tender_quo_item->get_by_pqm($data['pqm_id']);
			foreach ($pqi as $val) {
				$data['pqi'][$val['TIT_ID']] = $val;
			}
			$ef = $this->prc_eval_file->where_ptm_ptv($ptm_number, $vendorno);
			$ef = $this->prc_eval_file->get();
			$data['ef'] = array();
			foreach ((array)$ef as $val) {
				$data['ef'][$val['TIT_ID']][$val['ET_ID']] = $val;
			}
		}

		$data['ptp'] = $this->prc_tender_prep->ptm($ptm_number);
		$data['is_itemize'] = $data['ptp']['PTP_IS_ITEMIZE'];
		$data['tits'] = $this->prc_tender_item->ptm($ptm_number);
		$data['vendor_data'] = $this->prc_tender_vendor->get(array('PTM_NUMBER' => $ptm_number, 'PTV_VENDOR_CODE'=>$vendorno), '*');
		
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->add_js('pages/prc_chat_vendor.js');
		$this->layout->render('detail_vendor',$data);
	}

	function uploadAttachment() {
		$this->load->library('encrypt');
		$server_dir = str_replace("\\", "/", FCPATH);
		$upload_dir = UPLOAD_PATH."file_chat/";
		$this->load->library('file_operation');
		$this->file_operation->create_dir($upload_dir);
		$this->load->library('FileUpload');
		$uploader = new FileUpload('uploadfile');
		$ext = $uploader->getExtension(); // Get the extension of the uploaded file
		mt_srand();
		$filename = md5(uniqid(mt_rand())).".".$ext;
		$uploader->newFileName = $filename;
		$result = $uploader->handleUpload($server_dir.$upload_dir);
		if (!$result) {
			exit(json_encode(array('success' => false, 'msg' => $uploader->getErrorMsg(), 'path' => $upload_dir)));
		}
		echo json_encode(array('success' => true, 'newFileName' => $filename, 'upload_dir' => $upload_dir));
	}

	public function deleteFile($fileUpload){		
		$this->load->helper("url");

		$path = './upload/file_chat/'.$fileUpload;
	    if(file_exists(BASEPATH.'../upload/file_chat/'.$fileUpload)){
	        unlink($path);
	    }
	}

	public function save(){
		$this->load->model('prc_chat');
		$ptm = $this->input->post('ptm_number');

		$add['PTM_NUMBER'] = url_decode($ptm);
		$add['STATUS_PROSES'] = $this->input->post('ptm_status');
		$add['USER_ID'] = $this->input->post('user_id');
		$add['VENDOR_NO'] = $this->session->userdata('VENDOR_NO');
		$add['TGL'] = date('d-M-Y g.i.s A');
		$add['PESAN'] = $this->input->post('isi_pesan');
		$add['FILE_UPLOAD'] = $this->input->post('file_pesan');		
		$add['STATUS'] = 'REPLAY';
		$add['NEXT_PROSES'] = '0';
		
		$this->prc_chat->insert($add);
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
				'VENDOR','Klarifikasi Teknis','KIRIM',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Proc_chat_vendor/save','prc_chat','insert',$add);
			//--END LOG DETAIL--//

	}

}
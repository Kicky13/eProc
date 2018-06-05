<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
	}

	public function index() {
		$data['title'] = "Invoice";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('pages/invoice.js');
		$this->layout->add_js('pages/date_inv.js');
		//$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->render('list',$data);
	}

	// public function coba(){
	// 	echo phpinfo();
	// }

	public function get_data() 
	{
		$this->load->model('vnd_invoice');
		$venno = $this->session->userdata['VENDOR_NO'];
        $status = 0;
		$status1 = 1;
		$status2 = 2;
        $status3 = 3;
		$data['list_inv'] = $this->vnd_invoice->get($venno,$status,$status1,$status2,$status3);
//		$data['list_inv'] = $this->vnd_invoice->get($venno);
		$data_tabel=array();
		foreach ($data['list_inv'] as $line) {
			$data_tbl['NO_PO'] = $line['NO_PO'];
			$data_tbl['NO_INVOICE'] = $line['NO_INVOICE'];
			$data_tbl['F_PAJAK'] = $line['F_PAJAK'];
			$data_tbl['FIK_BAPP'] = $line['FIK_BAPP'];
			$data_tbl['FIK_BAST'] = $line['FIK_BAST'];
			$data_tbl['KETERANGAN'] = $line['KETERANGAN'];
			$data_tbl['STATUS'] = $line['STATUS'];
			$data_tbl['FILE_PAJAK'] = $line['FILE_PAJAK'];
			$data_tbl['FILE_BAPP'] = $line['FILE_BAPP'];
			$data_tbl['FILE_BAST'] = $line['FILE_BAST'];
			$data_tbl['ID_INVOICE'] = $line['ID_INVOICE'];
            $data_tbl['TANGGAL'] = $line['TANGGAL'];
			$data_tbl['TGL_INV'] = $line['TGL_INV'];
            $data_tbl['NO_GR'] = $line['NO_GR'];
			
			$data_tabel[]=$data_tbl;
		}
		$json_data = array('list_inv' => $data_tabel);
		echo json_encode($json_data);
	}

	public function getData() {
		// header('Content-Type: application/json');
		$this -> load -> model('vnd_invoice');
                
		$venno = $this->session->userdata['VENDOR_NO'];
        //$status = $this->session->userdata['STATUS'];
        $status = 0;
		$status1 = 1;
		$status2 = 2;
        $status3 = 3;
		$dataa = $this -> vnd_invoice -> get($venno,$status,$status1,$status2,$status3);
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['NO_PO'] = !null ? $value['NO_PO'] : "";
			$data[2] = $value['NO_GR'] = !null ? $value['NO_GR'] : "";
			$data[3] = $value['NO_INVOICE'] = !null ? $value['NO_INVOICE'] : "";
			$data[4] = $value['F_PAJAK'] = !null ? $value['F_PAJAK'] : "";
			$data[5] = $value['FIK_BAPP'] = !null ? $value['FIK_BAPP'] : "";
			$data[6] = $value['FIK_BAST'] = !null ? $value['FIK_BAST'] : "";
			$data[7] = $value['KETERANGAN'] = !null ? $value['KETERANGAN'] : "-";
			$data[8] = $value['STATUS'] = !null ? $value['STATUS'] : "";
			$data[9] = $value['FILE_PAJAK'];
			$data[10] = $value['FILE_BAPP'];
			$data[11] = $value['FILE_BAST'];
			$data[12] = $value['ID_INVOICE'];
			$data[13] = $value['TANGGAL'];
			$data[14] = $value['TGL_INV'];

			$data_tabel[] = $data;
		}
		$json_data = /*$data_tabel;*/
		array('data' => $data_tabel);
		echo json_encode($json_data);
	}

	public function add() {

		$data['title'] = "Tambah Invoice Vendor";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->add_js('plugins/jquery.maskedinput.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('pages/date_inv.js');
		$this->layout->render('tambah',$data);
	}

	public function edit($ID_INVOICE) {

		$data['title'] = "Ubah Invoice Vendor";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->add_js('plugins/jquery.maskedinput.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('pages/date_inv.js');
		$this->load->model('vnd_invoice');
		$dat = $this->vnd_invoice->detil($ID_INVOICE);
		// $dat = $this->vnd_invoice->detil(array($ID_INVOICE));
		foreach ($dat as $row) 
		$data['ver'] = $row;

		$this->layout->render('edit',$data);
		
		
	}

	public function namalain(){
		$this->load->model('vnd_invoice');
		$id_inv = $this->vnd_invoice->get_id();
		$venno = $this->session->userdata['VENDOR_NO'];
		$company = $this->session->userdata['COMPANYID'];
		$status = 3;

		$new['ID_INVOICE'] = $id_inv;
		$new['VENDOR_NO'] = $venno;
		$new['COMPANY'] = $company;
		$new['TGL_INV'] = $this->input->post('new_tgl_inv');
		$new['NO_PO'] = $this->input->post('new_po');
        $new['NO_GR'] = $this->input->post('new_gr');
		$new['NO_INVOICE'] = $this->input->post('new_invoice');
		$new['F_PAJAK'] = $this->input->post('new_pajak');
		$new['FIK_BAPP'] = $this->input->post('new_bapp');
		$new['FIK_BAST'] = $this->input->post('new_bast');
		$new['KETERANGAN'] = $this->input->post('new_ket');
		$new['FILE_PAJAK'] = $this->input->post('new_file_pajak');
		$new['FILE_BAPP'] = $this->input->post('new_file_bapp');
		$new['FILE_BAST'] = $this->input->post('new_file_bast');
		$new['STATUS'] = $status;
//                $new['TANGGAL'] = $this->input->post('new_tgl');
		$this->vnd_invoice->insert($new);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		// echo json_encode($data);
		redirect('Invoice');
	}

	public function getDetail($ID_INVOICE) 
	{
		$this->load->model('vnd_invoice');
		$data['ID_INVOICE'] = $this->vnd_invoice->getDetail($ID_INVOICE);
		//substr($MATNR, 1));
		echo json_encode($data);
	}

	public function updateInvoice() 
	{
		$this->load->model('vnd_invoice');
		$this->load->library("file_operation");
		$this->load->helper('file');
		$this->load->helper(array('form', 'url'));
		$this->layout->add_js('pages/date_inv.js');
		$where_edit['ID_INVOICE'] = $this->input->post('edit_id');

		$set_edit['TGL_INV'] = $this->input->post('new_tgl_inv');
		$set_edit['NO_PO'] = $this->input->post('new_po');
        $set_edit['NO_GR'] = $this->input->post('new_gr');
		$set_edit['NO_INVOICE'] = $this->input->post('new_invoice');
		$set_edit['F_PAJAK'] = $this->input->post('new_pajak');
		$set_edit['FIK_BAPP'] = $this->input->post('new_bapp');
		$set_edit['FIK_BAST'] = $this->input->post('new_bast');
		$set_edit['KETERANGAN'] = $this->input->post('new_ket');
		// $set_edit['FILE_PAJAK'] = $this->input->post('new_file_pajak');
		// $set_edit['FILE_BAST'] = $this->input->post('new_file_bast');
		// $set_edit['FILE_BAPP'] = $this->input->post('new_file_bapp');

		$uploaded = $this->file_operation->uploadI(UPLOAD_PATH . 'vendor'/*,        '200', 'jpg|png'*/, $_FILES);
		$data = null;
		if ($uploaded != null && $_FILES['new_file_pajak']['name']!="") {
			$data = array("ID_INVOICE" => $where_edit['ID_INVOICE'], "FILE_PAJAK" => $uploaded['new_file_pajak']['file_name']);
			if( $_FILES['new_file_bapp']['name']!=""){
				$data = array("ID_INVOICE" => $where_edit['ID_INVOICE'],"FILE_BAPP" => $uploaded['new_file_bapp']['file_name'],"FILE_PAJAK" => $uploaded['new_file_pajak']['file_name'],"FILE_BAST" => $uploaded['new_file_bast']['file_name']);
				if ($_FILES['new_file_bast']['name']!="") {
					$data = array("ID_INVOICE" => $where_edit['ID_INVOICE'],"FILE_BAST" => $uploaded['new_file_bast']['file_name'],"FILE_BAPP" => $uploaded['new_file_bapp']['file_name'],"FILE_PAJAK" => $uploaded['new_file_pajak']['file_name']);
				}
			}
		}else if ($uploaded != null && $_FILES['new_file_bapp']['name']!="") {
			$data = array("ID_INVOICE" => $where_edit['ID_INVOICE'], "FILE_BAPP" => $uploaded['new_file_bapp']['file_name']);
			if( $_FILES['new_file_pajak']['name']!=""){
				$data = array("ID_INVOICE" => $where_edit['ID_INVOICE'], "FILE_BAPP" => $uploaded['new_file_bapp']['file_name'],"FILE_PAJAK" => $uploaded['new_file_pajak']['file_name']);
				if ($_FILES['new_file_bast']['name']!="") {
					$data = array("ID_INVOICE" => $where_edit['ID_INVOICE'],"FILE_BAST" => $uploaded['new_file_bast']['file_name'],"FILE_BAPP" => $uploaded['new_file_bapp']['file_name'],"FILE_PAJAK" => $uploaded['new_file_pajak']['file_name']);
				}
			}
		}else if ($uploaded != null && $_FILES['new_file_bast']['name']!="") {
			$data = array("ID_INVOICE" => $where_edit['ID_INVOICE'], "FILE_BAST" => $uploaded['new_file_bast']['file_name']);
			if( $_FILES['new_file_pajak']['name']!=""){
				$data = array("ID_INVOICE" => $where_edit['ID_INVOICE'], "FILE_BAPP" => $uploaded['new_file_bapp']['file_name'],"FILE_PAJAK" => $uploaded['new_file_pajak']['file_name']);
				if ($_FILES['new_file_bapp']['name']!="") {
					$data = array("ID_INVOICE" => $where_edit['ID_INVOICE'],"FILE_BAST" => $uploaded['new_file_bast']['file_name'],"FILE_BAPP" => $uploaded['new_file_bapp']['file_name'],"FILE_PAJAK" => $uploaded['new_file_pajak']['file_name']);
				}
			} 
		}
		// $data = array("ID_INVOICE" => $where_edit['ID_INVOICE'], "FILE_PAJAK" => $uploaded['new_file_pajak']['file_name']);
		// $data = array("ID_INVOICE" => $where_edit['ID_INVOICE'], "FILE_BAPP" => $uploaded['new_file_bapp']['file_name']);
		// $data = array("ID_INVOICE" => $ID_INVOICE,"FILE_BAPP" => $uploaded['new_file_bast']['file_name']);
		if ($data!= null) {
			$this->vnd_invoice->upload($data);
		}
		$this->vnd_invoice->updateInvoice($set_edit, $where_edit);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		//echo json_encode($data);

		redirect('Invoice/');
	}

	public function updateStatus($ID_INVOICE) 
	{
		$this->load->helper('date');
		$this->load->model('vnd_invoice');
		$where_edit['ID_INVOICE'] = $ID_INVOICE;
		$status = 0;

		$set_edit['STATUS'] = $status;
		$set_edit['TANGGAL'] = date("d-m-Y H:i:s");

		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->to('gutamaarchie@gmail.com');
		$this->email->cc('pengadaan.semenindonesia@gmail.com');				
		$this->email->subject("Invoice Submited eProcurement PT. Semen Gresik (Persero) Tbk.");
		$content = $this->load->view('email/invoice_submited',array(),TRUE);
		$this->email->message($content);
		$this->email->send();

		$this->vnd_invoice->updateInvoice($set_edit, $where_edit);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);

		// redirect('Invoice/');
	}

	public function email() 
	{

		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from('hahaha');
		$this->email->to('gutamaarchie@gmail.com');
		$this->email->cc('pengadaan.semenindonesia@gmail.com');				
		$this->email->subject("Invoice Submited eProcurement PT. Semen Gresik (Persero) Tbk.");
		$content = $this->load->view('email/invoice_submited',array(),TRUE);
		$this->email->message($content);

		// echo "<pre>";
		// print_r($semenindonesia);die;

		$this->email->send();
		// echo json_encode($data);

		redirect('Invoice/');
	}
        
        public function updateStatusDelete($ID_INVOICE) 
	{
		$this->load->helper('date');
		$this->load->model('vnd_invoice');
		$where_edit['ID_INVOICE'] = $this->input->post('hapus_id');
//                $where_edit['ID_INVOICE'] = $ID_INVOICE;
		$status = 4;

		$set_edit['STATUS'] = $status;

		$this->vnd_invoice->updateInvoice($set_edit, $where_edit);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);

		// redirect('Invoice/');
	}

	public function delete() {
		// echo json_encode($this->input->post()); exit();
		$this->load->model('vnd_invoice');
		$where_hapus['ID_INVOICE'] = $this->input->post('hapus_id');
		$this->vnd_invoice->delete($where_hapus);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
	}

	public function viewDok($id = null){
		$url = str_replace("int-","", base_url());
		$this->load->helper('file');
		$image_path = base_url(UPLOAD_PATH).'/vendor/'.$id;	

		if (strpos($url, 'semenindonesia.com') !== false) { //server production
		$user_id=url_encode($this->session->userdata['ID_INVOICE']);
			if(empty($id)){
				die('tidak ada attachment.');
			}
			if(file_exists(BASEPATH.'../upload/vendor/'.$id)){				
				$this->output->set_content_type(get_mime_by_extension($image_path));
				return $this->output->set_output(file_get_contents($image_path));
			}else{
				redirect($url.'Invoice/viewDok/'.$id.'/'.$user_id);
			}

		}else{ //server development
			if(empty($id) || !file_exists(BASEPATH.'../upload/vendor/'.$id)){
				die('could not be found.');
			}
			
			$this->output->set_content_type(get_mime_by_extension($image_path));
			return $this->output->set_output(file_get_contents($image_path));
		}
	}

	function uploadAttachment() {
		$this->load->library('encrypt');
		$server_dir = str_replace("\\", "/", FCPATH);
		$upload_dir = UPLOAD_PATH."vendor/";
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

	public function upload($ID_INVOICE) {
		$this -> load -> library("file_operation");
		$this -> load -> helper('file');
		$this -> load -> model('vnd_invoice');
		$this -> load -> helper(array('form', 'url'));
		// header('Content-Type: application/json');
		// var_dump($_FILES);
		// if ($_FILES['picture']['size'] > 200000 && $_FILES['drawing']['size'] > 200000) {
		// }
		$uploaded = $this -> file_operation -> uploadT(UPLOAD_PATH . 'vendor'/*,        '200', 'jpg|png'*/, $_FILES);
		$data = array("ID_INVOICE" => $ID_INVOICE,"FILE_PAJAK" => $uploaded['new_file_pajak']['file_name']);
		$data = array("ID_INVOICE" => $ID_INVOICE,"FILE_BAPP" => $uploaded['new_file_bapp']['file_name']);
		$data = array("ID_INVOICE" => $ID_INVOICE,"FILE_BAPP" => $uploaded['new_file_bast']['file_name']);
		if ($uploaded != null && $_FILES['picture']['name']!="") {
			$data = array("ID_INVOICE" => $ID_INVOICE,"PICTURE" => $uploaded['picture']['file_name']);
			if( $_FILES['drawing']['name']!=""){
				$data = array("ID_INVOICE" => $ID_INVOICE, "AENAM" => $this -> USER[0], "LAEDA" => date("Ymd"),"DRAWING" => $uploaded['drawing']['file_name'], "PICTURE" => $uploaded['picture']['file_name']);
			}
		}else if ($uploaded != null && $_FILES['drawing']['name']!="") {
			$data = array("MATNR" => $MATNR, "AENAM" => $this -> USER[0], "LAEDA" => date("Ymd"),"DRAWING" => $uploaded['drawing']['file_name']);
			if( $_FILES['picture']['name']!=""){
				$data = array("MATNR" => $MATNR, "AENAM" => $this -> USER[0], "LAEDA" => date("Ymd"),"DRAWING" => $uploaded['drawing']['file_name'], "PICTURE" => $uploaded['picture']['file_name']);
			}
		}  
		$this -> vnd_invoice -> upload($data);
		// $this -> vnd_invoice -> setTAG(array('TAG' => $this -> input -> post('TAG'), "MATNR" => $MATNR));
		redirect("Invoice/");
	}


}
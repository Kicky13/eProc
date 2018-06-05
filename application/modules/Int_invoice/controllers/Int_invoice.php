<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Int_invoice extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
	}

	public function index() {
		$data['title'] = "Approval Invoice Vendor";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/invoice_int.js');
		$this->layout->render('list',$data);
	}

	public function get_data() 
	{
		$this->load->model('vnd_invoice_int');
		// $venno = $this->session->userdata['VENDOR_NO'];
		$status = 0;
		$status1 = 1;
		$status2 = 2;
		$data['list_inv'] = $this->vnd_invoice_int->get($status,$status1,$status2);
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
			$data_tbl['TGL_INV'] = $line['TGL_INV'];
            $data_tbl['TANGGAL'] = $line['TANGGAL'];
			$data_tbl['NO_GR'] = $line['NO_GR'];
                        
                        $data_tbl['VENDOR_NO'] = $line['VENDOR_NO'];
			
			$data_tabel[]=$data_tbl;
		}
		$json_data = array('list_inv' => $data_tabel);
		echo json_encode($json_data);
	}

	public function getData() {
		// header('Content-Type: application/json');
		$this -> load -> model('vnd_invoice_int');
		$status = 0;
		$status1 = 1;
		$status2 = 2;
		$dataa = $this -> vnd_invoice_int -> get($status,$status1,$status2);
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
                        
                        $data[15] = $value['VENDOR_NO'] = !null ? $value['VENDOR_NO'] : "";;

			$data_tabel[] = $data;
		}
		$json_data = /*$data_tabel;*/
		array('data' => $data_tabel);
		echo json_encode($json_data);
	}

	public function add($id) {

		$data['title'] = "Verifikasi Invoice Vendor";
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/date_inv.js');
		$this->load->model('vnd_invoice_int');
		$dat = $this->vnd_invoice_int->detil($id);
		foreach ($dat as $row) {} 
		$data['ver'] = $row;

		$this->layout->render('tambah',$data);
		
		
	}

	public function createPPL($id) {

		$data['title'] = "Create PPL";
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		// $this->layout->add_js('pages/date_inv.js');
		// $this->load->model('vnd_invoice_int');
		// $dat = $this->vnd_invoice_int->detil($id);
		// foreach ($dat as $row) {} 
		// $data['ver'] = $row;

		$this->layout->render('ppl',$data);
		
		
	}

	public function namalain(){
		$this->load->model('vnd_invoice_int');
		$id_inv = $this->vnd_invoice_int->get_id();
		$venno = $this->session->userdata['VENDOR_NO'];
		$company = $this->session->userdata['COMPANYID'];

		$new['ID_INVOICE'] = $id_inv;
		$new['VENDOR_NO'] = $venno;
		$new['COMPANY'] = $company;
//		$new['TANGGAL'] = $this->input->post('new_tgl');
        $new['TGL_INV'] = $this->input->post('new_tgl_inv');
		$new['NO_PO'] = $this->input->post('new_po');
		$new['NO_INVOICE'] = $this->input->post('new_invoice');
		$new['F_PAJAK'] = $this->input->post('new_pajak');
		$new['FIK_BAPP'] = $this->input->post('new_bapp');
		$new['FIK_BAST'] = $this->input->post('new_bast');
		$new['KETERANGAN'] = $this->input->post('new_ket');
		$new['FILE_PAJAK'] = $this->input->post('new_file_pajak');
		$new['FILE_BAPP'] = $this->input->post('new_file_bapp');
		$new['FILE_BAST'] = $this->input->post('new_file_bast');
		

		$this->vnd_invoice_int->insert($new);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		// echo json_encode($data);
		redirect('Invoice');
	}

	public function getDetail($ID_INVOICE) 
	{
		$this->load->model('vnd_invoice_int');
		$data['ID_INVOICE'] = $this->vnd_invoice_int->getDetail($ID_INVOICE);
		//substr($MATNR, 1));
		echo json_encode($data);
	}


	public function updateInvoice() 
	{
		$this->load->model('vnd_invoice_int');
		$this->load->model('vnd_header');
		$where_edit['ID_INVOICE'] = $this->input->post('edit_id');
		$vend = $this->input->post('vnd_no'); 
		$vendor_no = intval($vend);

		$set_edit['STATUS'] = $this->input->post('new_status');
		$set_edit['REASON'] = $this->input->post('revisi');
		$set_edit['TAX_TYPE'] = $this->input->post('tax_type');
		$set_edit['TEXT'] = $this->input->post('text');

		$vnd_header = $this->vnd_header->get(array('VENDOR_NO'=>$vend));

		if ($set_edit['STATUS'] == 2) {
			$this->load->library('email');
			$this->config->load('email'); 
			$semenindonesia = $this->config->item('semenindonesia'); 
			$this->email->initialize($semenindonesia['conf']);
			$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
			$this->email->to($vnd_header['EMAIL_ADDRESS']);
			$this->email->cc('pengadaan.semenindonesia@gmail.com');				
			$this->email->subject("Revisi Invoice Vendor eProcurement PT. Semen Gresik (Persero) Tbk.");
			$content = $this->load->view('email/invoice_reject',array(),TRUE);
			$this->email->message($content);
			$this->email->send();
		}else {
			$this->load->library('email');
			$this->config->load('email'); 
			$semenindonesia = $this->config->item('semenindonesia'); 
			$this->email->initialize($semenindonesia['conf']);
			$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
			$this->email->to($vnd_header['EMAIL_ADDRESS']);
			$this->email->cc('pengadaan.semenindonesia@gmail.com');				
			$this->email->subject("Invoice Approved eProcurement PT. Semen Gresik (Persero) Tbk.");
			$content = $this->load->view('email/invoice_approved',array(),TRUE);
			$this->email->message($content);
			$this->email->send();
		}
		

		$this->vnd_invoice_int->updateInvoice($set_edit, $where_edit);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		//echo json_encode($data);

		redirect('Int_invoice');
	}

	public function delete() {
		// echo json_encode($this->input->post()); exit();
		$this->load->model('vnd_invoice_int');
		$where_hapus['ID_INVOICE'] = $this->input->post('hapus_id');
		$this->vnd_invoice_int->delete($where_hapus);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
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


}
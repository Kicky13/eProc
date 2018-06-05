<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panduan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model('m_manual_book');
	}

	public function index() {
		$data['title'] = "Manual Book";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_validate_css();
		$this->layout->set_validate_js();
		$this->layout->add_js('pages/m_manual_book.js');
		$data['panduan'] = $this->m_manual_book->getall();
		// die(var_dump($data['panduan']));
		$this->layout->render('panduan', $data);
	}

	public function viewDok($id = null){
		$url = str_replace("int-","", base_url());
		$this->load->helper('file');
		$image_path = base_url(UPLOAD_PATH).'/vendor/'.$id;	

		if (strpos($url, 'semenindonesia.com') !== false) { //server production
		$user_id=url_encode($this->session->userdata['ID']);
			if(empty($id)){
				die('tidak ada attachment.');
			}
			if(file_exists(BASEPATH.'../upload/vendor/'.$id)){				
				$this->output->set_content_type(get_mime_by_extension($image_path));
				return $this->output->set_output(file_get_contents($image_path));
			}else{
				$url = str_replace("http","https", $url);
				redirect($url.'View_document_vendor/viewDok/'.$id.'/'.$user_id);
			}

		}else{ //server development	
			if(empty($id) || !file_exists(BASEPATH.'../upload/vendor/'.$id)){
				die('tidak ada attachment.');
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

	function insert_panduan() {
		$this->load->model('m_manual_book');
		$data = array(
				'NAMA' => $this->input->post('name_book'),
				'TANGGAL' => date(timeformat()),
				'TIPE' => $this->input->post('tipefile'),
				'NAMA_FILE' => $this->input->post('name_file')
			);
		$this->m_manual_book->insert($data);		

		$this->session->set_flashdata('success', "upload Success");
		$url = "Panduan/index/";
		redirect(site_url($url));
	}		

	public function delete(){
		$id = $this->input->post('id');
		// die(var_dump($id));
		if ($this->m_manual_book->delete(array("ID_MANUAL" => $id))) {
			echo 'ok';
		}
	}
	
	public function deleteFile(){
		$id = $this->input->post('id');
		$fileUpload = $this->input->post('filename');
		$this->load->model('m_manual_book');
		
		$this->load->helper("url");

		$path = './upload/vendor/'.$fileUpload;
	    if(file_exists(BASEPATH.'../upload/vendor/'.$fileUpload)){
	        unlink($path);
	    }
	    
		if(!empty($id)){
			$data['FILE_UPLOAD'] = null;
			$where = array('PRODUCT_ID' => $id);
			$this->m_manual_book->update($data,$where);			
		}
	}

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panduan_vendor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model('m_manual_book');
	}

	public function index() {
		$data['title'] = "Petunjuk Penggunaan";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_validate_css();
		$this->layout->set_validate_js();
		$data['manual_book'] = $this->m_manual_book->getforvendor();
		$this->layout->render('panduan_vendor', $data);
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

}
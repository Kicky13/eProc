<?php defined('BASEPATH') OR exit('No direct script access allowed');

class View_document_procurement extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function viewDokPpmDok($file=null, $vendor_id=null){
		$this->load->helper('file');
		$this->load->model('vnd_header');

		if(!is_numeric(url_decode($vendor_id))){
			die('<h2>Anda Harus Login !!</h2>');
		}
		$vnd = $this->vnd_header->get(array('VENDOR_ID'=>url_decode($vendor_id)));
		if(!isset($vnd) ){
			die('<h2>Anda Harus Login !!</h2>');
		}
		
		$image_path = base_url(UPLOAD_PATH).'/ppm_document/'.$file;	

		if(empty($file) || !file_exists(BASEPATH.'../upload/ppm_document/'.$file)){
			die('tidak ada attachment.');
		}
		
		$this->output->set_content_type(get_mime_by_extension($image_path));
		return $this->output->set_output(file_get_contents($image_path));
	}

	public function viewDokAddFile($file=null, $vendor_id=null){
		$this->load->helper('file');
		$this->load->model('vnd_header');

		if(!is_numeric(url_decode($vendor_id))){
			die('<h2>Anda Harus Login !!</h2>');
		}
		$vnd = $this->vnd_header->get(array('VENDOR_ID'=>url_decode($vendor_id)));
		if(!isset($vnd) ){
			die('<h2>Anda Harus Login !!</h2>');
		}
		
		$image_path = base_url(UPLOAD_PATH).'/additional_file/'.$file;	

		if(empty($file) || !file_exists(BASEPATH.'../upload/additional_file/'.$file)){
			die('tidak ada attachment.');
		}
		
		$this->output->set_content_type(get_mime_by_extension($image_path));
		return $this->output->set_output(file_get_contents($image_path));
	}

	

}
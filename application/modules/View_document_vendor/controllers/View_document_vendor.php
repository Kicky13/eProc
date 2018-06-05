<?php defined('BASEPATH') OR exit('No direct script access allowed');

class View_document_vendor extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function viewDok($file=null, $user_id=null){
		$this->load->helper('file');
		$this->load->model('adm_employee');

		if(!is_numeric(url_decode($user_id))){
			die('<h2>Anda Harus Login !!</h2>');
		}
		$employee = $this->adm_employee->get(array('ID'=>url_decode($user_id)));
		if(!isset($employee) ){
			die('<h2>Anda Harus Login !!</h2>');
		}
		
		$image_path = base_url(UPLOAD_PATH).'/vendor/'.$file;	

		if(empty($file) || !file_exists(BASEPATH.'../upload/vendor/'.$file)){
			die('tidak ada attachment.');
		}
		
		$this->output->set_content_type(get_mime_by_extension($image_path));
		return $this->output->set_output(file_get_contents($image_path));
	}

	public function viewDok_quo($file=null, $user_id=null){
		$this->load->helper('file');
		$this->load->model('adm_employee');

		if(!is_numeric(url_decode($user_id))){
			die('<h2>Anda Harus Login !!</h2>');
		}
		$employee = $this->adm_employee->get(array('ID'=>url_decode($user_id)));
		if(!isset($employee) ){
			die('<h2>Anda Harus Login !!</h2>');
		}
		
		$image_path = base_url(UPLOAD_PATH).'/quo_file/'.$file;	

		if(empty($file) || !file_exists(BASEPATH.'../upload/quo_file/'.$file)){
			die('tidak ada attachment.');
		}
		
		$this->output->set_content_type(get_mime_by_extension($image_path));
		return $this->output->set_output(file_get_contents($image_path));
	}

	public function viewDok_nego($file=null, $user_id=null){
		$this->load->helper('file');
		$this->load->model('prc_tender_nego');

		if(!is_numeric(url_decode($user_id))){
			die('<h2>Anda Harus Login !!</h2>');
		}
		$employee = $this->adm_employee->get(array('ID'=>url_decode($user_id)));
		if(!isset($employee) ){
			die('<h2>Anda Harus Login !!</h2>');
		}
		
		$image_path = base_url(UPLOAD_PATH).'/nego_file/'.$file;	

		if(empty($file) || !file_exists(BASEPATH.'../upload/nego_file/'.$file)){
			die('tidak ada attachment.');
		}
		
		$this->output->set_content_type(get_mime_by_extension($image_path));
		return $this->output->set_output(file_get_contents($image_path));
	}

	

}
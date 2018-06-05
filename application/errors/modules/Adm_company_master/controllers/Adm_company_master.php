<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adm_company_master extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model(array('adm_company'));
	}

	public function index() {
		$data['title'] = "Form Master Company";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('pages/adm_company_master.js');
		$this->layout->render('company_view', $data);
	}

	function get_data()
	{
		$this->load->model('adm_company');

		$datatable = $this->adm_company->get_company();
		$data = array('data' => $datatable);
		echo json_encode($data);
	}


	function insert() {
		$this->load->model('adm_employee');

		$opco = $this->input->post('opco');
		$company_name = $this->input->post('company_name');
		$email = $this->input->post('email');
		$alamat = $this->input->post('alamat');
		$logo = $this->input->post('file_upload');

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Master Company (Input)','SAVE',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$data = array(
				'COMPANYID' => $opco,
				'COMPANYNAME' => $company_name,
				'EMAIL_COMPANY' => $email,
				'ALAMAT_COMPANY' => $alamat,
				'LOGO_COMPANY' => $logo,
				'ISACTIVE' => 1
			);

		$this->adm_company->insert_new($data);

		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Adm_company_master/insert','adm_company','insert',$data);
		//--END LOG DETAIL--//

		echo "ok";

	}

	public function update(){
		$id = $this->input->post('id');
		//--LOG MAIN--//
			// $this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			// $this->authorization->getCurrentRole(),'Master Company','Update',$this->input->ip_address());
			// $LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		$data_company = $this->adm_company->get($id);
		$where['COMPANYID'] = $id;

		if ($data_company['ISACTIVE'] == 1) {
			$data['ISACTIVE'] = '0';
			if ($this->adm_company->update_new($data,$where)) {

				//--LOG DETAIL--//
					// $where = array("COMPANYID" => $id);
					// $this->log_data->detail($LM_ID,'Adm_company_master/update','adm_company','update',null,$where);
				//--END LOG DETAIL--//
				echo 'ok';
			} 
		} else {
			$data['ISACTIVE'] = '1';
			if ($this->adm_company->update_new($data,$where)) {

				//--LOG DETAIL--//
					// $where = array("COMPANYID" => $id);
					// $this->log_data->detail($LM_ID,'Adm_company_master/update','adm_company','update',null,$where);
				//--END LOG DETAIL--//
				echo 'ok';
			}
		}
	}	

	function uploadAttachment() {
		$this->load->library('encrypt');
		$server_dir = str_replace("\\", "/", FCPATH);	
		$upload_dir = 'static/images/logo/';
		$this->load->library('file_operation');
		$this->file_operation->create_dir($upload_dir);
		$this->load->library('FileUpload');
		$uploader = new FileUpload('uploadfile');
		$name = $uploader->getFileName();
		$filename = time()."-".$name;
		$uploader->newFileName = $filename;
		$result = $uploader->handleUpload($server_dir.$upload_dir);
		if (!$result) {
			exit(json_encode(array('success' => false, 'msg' => $uploader->getErrorMsg(), 'path' => $upload_dir)));
		}
		echo json_encode(array('success' => true, 'newFileName' => $filename, 'upload_dir' => $upload_dir));
	}

	function deleteFile(){
		$fileUpload = $this->input->post('filename');
		$this->load->helper("url");

		$path = './static/images/logo/'.$fileUpload;
	  	if(file_exists(BASEPATH.'../static/images/logo/'.$fileUpload)){
	        unlink($path);
	    }
	}

}
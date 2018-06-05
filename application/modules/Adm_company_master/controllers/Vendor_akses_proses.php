<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adm_company_master extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model(array('vendor_employe'));
	}

	public function index() {
		$data['title'] = "Hak Akses Level Vendor";
		$this->load->model('vendor_employe');
		$opco = $this->session->userdata['EM_COMPANY'];

		$this->load->model('adm_company'); 

		$data['company'] = $this->adm_company->fields('COMPANYID,COMPANYNAME')->get_all(array('ISACTIVE' => 1));
		
		$data['emplo'] = $this->vendor_employe->dataemplo($opco);

		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('pages/vnd_hak.js');
		$this->layout->render('hak_vendor', $data);
	}

	function get_data()
	{
		$this->load->model('vendor_employe');

		$datatable = $this->vendor_employe->get_ms(array('ID','EMP_NAME','NAME_LEVEL', 'COMPANYID'));
		// die(var_dump($datatable));
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	function pilih_employee(){
		$id = $this->input->post('id');
		$this->load->model('vendor_employe');
		$data = $this->vendor_employe->get_child($id);

		echo form_dropdown("data",$data,'',''); 
	}

	function insert_akses() {
		$this->load->model(array('vendor_employe', 'adm_employee'));

		$level = $this->input->post('level');
		if ($level == 1) {
			$name_level = 'KONFIGURASI PERENCANAAN';
		} else if($level == 2){
			$name_level = 'KASI PERENCANAAN';
		} else if($level == 3){
			$name_level = 'KABIRO PERENCANAAN';
		}

// var_dump($this->log_data; die();
		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Master Akses Vendor (Input)','SAVE',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$employe_id = $this->input->post('emplo_id');
		$employe_name = $this->input->post('emplo');
		$company_id = $this->input->post('company');
		// $query_emp = $this->adm_employee->get(array("ADM_EMPLOYEE.ID" => $emp_id));

		// var_dump($query_emp);

		$data = array(
				'EMP_ID' => $employe_id,
				'LEVEL' => $level,
				'NAME_LEVEL' => $name_level,
				'EMP_NAME' => $employe_name,
				'COMPANYID' => $company_id
			);
		// die(var_dump($data));
		$this->vendor_employe->insert($data);

		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_akses_proses/insert_akses','vnd_ms_proses','insert',$data);
		//--END LOG DETAIL--//

		echo "ok";

	}


	public function deleteven(){
		$id = $this->input->post('id');
		// die(var_dump($id));
		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Master Akses Vendor','Delete',$this->input->ip_address());
				$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		if ($this->vendor_employe->delete(array("ID" => $id))) {

			//--LOG DETAIL--//
				$where = array("ID" => $id);
				$this->log_data->detail($LM_ID,'Vendor_akses_proses/deleteven','vnd_ms_proses','delete',null,$where);
			//--END LOG DETAIL--//
			echo 'ok';
		} 
	}	

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class employee extends CI_Controller {


	public function __construct()
	{

		parent::__construct();

		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model('employee_model');
		$this->load->model('employee_type_model');
		$this->load->model('position_model');
		$this->load->model('jobtitle_model');
		$this->load->model('district_model');
		$this->load->model('salutation_model');
		$this->load->model('departement_model');
		$this->load->model('gender_model');
		$this->load->helper('url');
	}

	public function index()
	{
		$this->authorization->roleCheck();
		$this->layout-> _set_form_js();
		$this->layout-> _set_form_css();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$data['title'] = "employee";
		$data['employee_list_data'] = $this->employee_model->get_all();
		$data['data_all_position'] = $this->employee_model->get_all_position();
		$this->layout->render('employee_list',$data);
		
	}

	public function get_data_person()
	{
		$ID = $_GET['id'];
		$ID = (int)$ID;
		$data['data_all_position'] = $this->employee_model->get_position_person($ID);
		$this->load->view('table',$data);
	}

	public function delete()
	{
		$ID = $_GET['id'];
		$this->employee_model->delete($ID);
	}

	public function form_add()
	{
		$data['title'] = "form";
		$data['jobtitle'] = $this->jobtitle_model->get_all();
		$data['district'] = $this->district_model->get_all();
		$data['employee_type'] = $this->employee_type_model->get_all();
		$data['salutation'] = $this->salutation_model->get_all();
		$data['departement'] = $this->departement_model->get_all();
		$data['gender'] = $this->gender_model->get_all();
		$data['job_position'] = $this->position_model->get_all();
		$this->layout-> _set_form_js();
		$this->layout-> _set_form_css();
		$this->layout->render('employee_form',$data);
	}

	public function add_employee()
	{
		$npp = $_GET['npp'];
		$salutation = $_GET['salutation'];
		$salutation = (int)$salutation;
		$employee_type = $_GET['employee_type'];
		$employee_type = (int)$employee_type;
		$firstname = $_GET['firstname'];
		$lastname = $_GET['lastname'];
		$email = $_GET['email'];
		$phone = $_GET['phone'];
		$gender = $_GET['gender'];
		$gender = (int)$gender;
		$this->employee_model->add_employee($npp,$salutation,$employee_type,$firstname,$lastname,$email,$phone,$gender,$email);
	}

	public function add_employee_position()
	{
		$npp = $_GET['npp'];
		$job_position = $_GET['jobposition'];
		$job_position = (int)$job_position;
		$active = $_GET['active'];
		$main_job = $_GET['main_job'];
		$this->employee_model->add_employee_position($npp,$job_position,$active,$main_job);

	}

	public function form_edit()
	{
		$data['title'] = "form";
		$id = $this->input->post('employee_id');
		$data['id'] = $this->input->post('employee_id');
		$data['jobtitle'] = $this->jobtitle_model->get_all();
		$data['district'] = $this->district_model->get_all();
		$data['employee_type'] = $this->employee_type_model->get_all();
		$data['salutation'] = $this->salutation_model->get_all();
		$data['departement'] = $this->departement_model->get_all();
		$data['gender'] = $this->gender_model->get_all();
		$data['position_person'] = $this->employee_model->get_position_person($id);
		$data['job_position'] = $this->employee_model->position_employee();
		$this->layout-> _set_form_js();
		$this->layout-> _set_form_css();
		$this->layout->render('employee_edit',$data);
	}

}
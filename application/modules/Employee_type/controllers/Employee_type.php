<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class employee_type extends CI_Controller {


	public function __construct()
	{

		parent::__construct();

		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model('employee_type_model');
		$this->load->helper('url');
	}

	public function index()
	{
		$this->authorization->roleCheck();
		$data['title'] = "employee type";
		$data['employee_type_list_data'] = $this->employee_type_model->get_all();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('employee_type_list',$data);
	}

	public function delete()
	{
		$ID = $_GET['id'];
		$this->employee_type_model->delete($ID);
	}
	
	public function add()
	{
		$name = $_GET['type_name'];
		$this->employee_type_model->add($name);
	}

	public function edit()
	{
		$id = $_GET['type_id'];
		$name = $_GET['type_name'];
		$this->employee_type_model->edit($id,$name);
	}

	public function form_add()
	{
		$data['title'] = "form";
		$this->layout-> _set_form_js();
		$this->layout-> _set_form_css();
		$this->layout->render('employee_type_form',$data);
	}

}
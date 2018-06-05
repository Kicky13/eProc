<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class district extends CI_Controller {


	public function __construct()
	{

		parent::__construct();

		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model('district_model');
		$this->load->helper('url');
	}

	public function index()
	{
		$this->authorization->roleCheck();
		$data['title'] = "district";
		$data['district_list_data'] = $this->district_model->get_all();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('district_list',$data);
	}

	public function add()
	{
		$district_code = $_GET['code_district'];
		$district_name = $_GET['name_district'];
		$this->district_model->add($district_code,$district_name);
	}

	public function edit()
	{
		$district_id = $_GET['id_district'];
		$district_code = $_GET['code_district'];
		$district_name = $_GET['name_district'];
		$district_id = (int)$district_id;
		$this->district_model->edit($district_id,$district_code,$district_name);	
	}

	public function delete()
	{
		$district_id = $_GET['id'];
		$this->district_model->delete($district_id);
	}

}
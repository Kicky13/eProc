<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class departement extends CI_Controller {


	public function __construct()
	{

		parent::__construct();

		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model('departement_model');
		$this->load->model('district_model');
		$this->load->helper('url');
	}

	public function index()
	{
		$this->authorization->roleCheck();
		$data['title'] = "departement";
		$data['departement_list_data'] = $this->departement_model->get_all();
		$data['district_list'] = $this->district_model->get_all();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('departement_list',$data);
	}

	public function add()
	{
		$departement_code = $_GET['code_departement'];
		$departement_name = $_GET['name_departement'];
		$district_id = $_GET['id_district'];
		$district_id = (int)$district_id;
		$this->departement_model->add($departement_code,$departement_name,$district_id);
	}

	public function edit()
	{
		$departement_id = $_GET['id_departement'];
		$departement_code = $_GET['code_departement'];
		$departement_name = $_GET['name_departement'];
		$district_id = $_GET['id_district'];
		$district_id = (int)$district_id;
		$departement_id = (int)$departement_id;
		$this->departement_model->edit($departement_id,$departement_code,$departement_name,$district_id);	
	}

	public function delete()
	{
		$ID = $_GET['id'];
		$this->departement_model->delete($ID);
	}

}
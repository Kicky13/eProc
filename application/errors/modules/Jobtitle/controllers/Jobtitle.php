<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class jobtitle extends CI_Controller {


	public function __construct()
	{

		parent::__construct();

		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model('departement_model');
		$this->load->model('jobtitle_model');
		$this->load->helper('url');
	}

	public function index()
	{
		$this->authorization->roleCheck();
		$data['title'] = "job title";
		$data['jobtitle_list_data'] = $this->jobtitle_model->get_all();
		$data['departement_list'] = $this->departement_model->get_all();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('jobtitle_list',$data);
	}

	public function add()
	{
		$jobtitle_name = $_GET['name_jobtitle'];
		$departement_id = $_GET['id_departement'];
		$departement_id = (int)$departement_id;
		$this->jobtitle_model->add($jobtitle_name,$departement_id);
	}

	public function edit()
	{
		$jobtitle_id = $_GET['id_jobtitle'];
		$jobtitle_name = $_GET['name_jobtitle'];
		$departement_id = $_GET['id_departement'];
		$jobtitle_id = (int)$jobtitle_id;
		$departement_id = (int)$departement_id;
		$this->jobtitle_model->edit($jobtitle_id,$jobtitle_name,$departement_id);	
	}

	public function delete()
	{
		$ID = $_GET['id'];
		$this->jobtitle_model->delete($ID);
	}

}
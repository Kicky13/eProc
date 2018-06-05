<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class salutation extends CI_Controller {


	public function __construct()
	{

		parent::__construct();

		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model('salutation_model');
		$this->load->helper('url');
	}

	public function index()
	{
		$this->authorization->roleCheck();
		$data['title'] = "salutation";
		$data['salutation_list_data'] = $this->salutation_model->get_all();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('salutation_list',$data);
	}

	public function add()
	{
		$salutation_name = $_GET['name_salutation'];
		$data['files']=$this->salutation_model->add($salutation_name);
	}

	public function edit()
	{
		$salutation_id = $_GET['id_salutation'];
		$salutation_name = $_GET['name_salutation'];
		$salutation_id = (int)$salutation_id;
		$this->salutation_model->edit($salutation_id,$salutation_name);	
	}


	public function delete()
	{
		
		$salutation_id = $_GET['id'];
		$this->salutation_model->delete($salutation_id);
	}

}
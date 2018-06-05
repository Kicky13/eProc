<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class currency extends CI_Controller {


	public function __construct()
	{

		parent::__construct();

		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model('currency_model');
		$this->load->helper('url');
	}

	public function index()
	{
		$this->authorization->roleCheck();
		$data['title'] = "currency";
		$data['currency_list_data'] = $this->currency_model->get_all();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('currency_list',$data);
	}

	public function add()
	{
		$currency_code = $_GET['code_currency'];
		$currency_name = $_GET['name_currency'];
		$this->currency_model->add($currency_code,$currency_name);
	}

	public function edit()
	{
		$currency_id = $_GET['id_currency'];
		$currency_code = $_GET['code_currency'];
		$currency_name = $_GET['name_currency'];
		$currency_id = (int)$currency_id;
		$this->currency_model->edit($currency_id,$currency_code,$currency_name);	
	}

	public function delete()
	{
		$currency_id = $_GET['id'];
		$this->currency_model->delete($currency_id);
	}

}
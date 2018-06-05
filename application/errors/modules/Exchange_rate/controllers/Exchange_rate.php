<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class exchange_rate extends CI_Controller {


	public function __construct()
	{

		parent::__construct();

		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model('exchange_rate_model');
		$this->load->model('currency_model');
		$this->load->helper('url');
	}

	public function index()
	{
		$this->authorization->roleCheck();
		$data['title'] = "exchange rate";
		$data['exchange_rate_list_data'] = $this->exchange_rate_model->get_all();
		$data['currency_list'] = $this->currency_model->get_all();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('exchange_rate_list',$data);
	}

	public function add()
	{
		$currency_from = $_GET['from_currency'];
		$currency_to = $_GET['to_currency'];
		$currency_date = $_GET['date_currency'];
		$currency_value = $_GET['value_currency'];
		$currency_from = (int)$currency_from;
		$currency_to = (int)$currency_to;
		$this->exchange_rate_model->add($currency_from,$currency_to,$currency_date,$currency_value);
	}

	public function edit()
	{
		$exchange_rate_id = $GET['id_exchange_rate'];
		$currency_from = $_GET['from_currency'];
		$currency_to = $_GET['to_currency'];
		$currency_date = $_GET['date_currency'];
		$currency_value = $_GET['value_currency'];
		$exchange_rate_id = (int)$exchange_rate_id;
		$currency_from = (int)$currency_from;
		$currency_to = (int)$currency_to;
		$this->exchange_rate_model->edit($exchange_rate_id,$currency_from,$currency_to,$currency_date,$currency_value);
	}

	public function delete()
	{
		$exchange_rate_id = $_GET['id'];
		$this->exchange_rate_model->delete($exchange_rate_id);
	}

}
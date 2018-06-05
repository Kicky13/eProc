<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user extends CI_Controller {


	public function __construct()
	{

		parent::__construct();

		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->library('Htmllib');
		$this->load->model('user_model');
		$this->load->model('employee_model');
		$this->load->helper('url');
	}

	public function index()
	{
		$this->authorization->roleCheck();
		$data['title'] = "user";
		$data['user_list_data'] = $this->user_model->get_all();
		$this->htmllib->set_table_js();
		$this->htmllib->set_table_cs();
		$this->layout->render('user_list',$data);
	}

	public function delete()
	{
		$ID = $_GET['id'];
		$this->user_model->delete($ID);
	}

	public function reset()
	{
		$ID = $_GET['id'];
		$ID = (int)$ID;
		$this->user_model->reset($ID);
	}

	public function form_add()
	{
		$data['title'] = "form";
		$data['user_list'] = $this->user_model->get_all();
		$data['employee_list'] = $this->employee_model->get_all_non_repudation();
		$this->htmllib-> _set_form_js();
		$this->htmllib-> _set_form_css();
		$this->htmllib->set_table_js();
		$this->htmllib->set_table_cs();
		$this->layout->render('user_form',$data);
	}

	public function add()
	{
		$employee = $_GET['id'];
		$employee  = (int)$employee;
		$user= $_GET['username'];
		$pass = $_GET['password'];
		$locked = $_GET['is_locked'];
		$commo = $_GET['is_comodity'];
		$date = $_GET['date'];
		$this->user_model->add($employee,$user,$pass,$locked,$commo,$date);
	}

	public function edit()
	{
		$user = $_GET['id'];
		$user  = (int)$user;
		$comm = $_GET['comodity'];
		$lock = $_GET['locked'];
		$this->user_model->edit($user,$comm,$lock);
	}
}
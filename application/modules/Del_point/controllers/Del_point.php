<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class del_point extends CI_Controller {


	public function __construct()
	{

		parent::__construct();

		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model('del_point_model');
		$this->load->helper('url');
	}

	public function index()
	{
		$this->authorization->roleCheck();
		$data['title'] = "delivery point";
		$data['del_point_list_data'] = $this->del_point_model->get_all();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('del_point_list',$data);
	}

	public function add()
	{
		$del_point_code = $_GET['code_del_point'];
		$del_point_name = $_GET['name_del_point'];
		$this->del_point_model->add($del_point_code,$del_point_name);
	}

	public function edit()
	{
		$del_point_id = $_GET['id_del_point'];
		$del_point_code = $_GET['code_del_point'];
		$del_point_name = $_GET['name_del_point'];
		$del_point_id = (int)$del_point_id;
		$this->del_point_model->edit($del_point_id,$del_point_code,$del_point_name);	
	}

	public function delete()
	{
		$ID = $_GET['id'];
		$this->del_point_model->delete($ID);
	}

}
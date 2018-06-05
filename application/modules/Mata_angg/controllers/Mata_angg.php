<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mata_angg extends CI_Controller {


	public function __construct()
	{

		parent::__construct();

		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model('mata_angg_model');
		$this->load->helper('url');
	}

	public function index()
	{
		$this->authorization->roleCheck();
		$data['title'] = "mata anggaran";
		$data['mata_angg_list_data'] = $this->mata_angg_model->get_all();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('mata_angg_list',$data);
	}

	public function add()
	{
		$mata_angg = $_GET['mata_angg'];
		$nama_mata_angg = $_GET['nama_mata_angg'];
		$sub_mata_angg = $_GET['sub_mata_angg'];
		$nama_sub_mata_angg = $_GET['nama_sub_mata_angg'];
		$this->mata_angg_model->add($mata_angg,$nama_mata_angg,$sub_mata_angg,$nama_sub_mata_angg);
	}

	public function edit()
	{
		$mata_angg_id = $_GET['id_mata_angg'];
		$mata_angg = $_GET['mata_angg'];
		$nama_mata_angg = $_GET['nama_mata_angg'];
		$sub_mata_angg = $_GET['sub_mata_angg'];
		$nama_sub_mata_angg = $_GET['nama_sub_mata_angg'];
		$mata_angg_id = (int)$mata_angg_id;
		$this->mata_angg_model->edit($mata_angg_id,$mata_angg,$nama_mata_angg,$sub_mata_angg,$nama_sub_mata_angg);
	}

	public function delete()
	{
		$mata_angg_id = $_GET['id'];
		$this->mata_angg_model->delete($mata_angg_id);
	}

	public function get_datatable()
	{
		$data = $this->mata_angg_model->get_all();
		$json = array('data' => $data);
		echo json_encode($json);
	}

}
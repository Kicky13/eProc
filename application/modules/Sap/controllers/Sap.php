<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sap extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
	}

	public function index() {
		$data['title'] = "Daftar PR";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/list_pr.js');
		$this->layout->render('list_pr', $data);
	}

	function get_datatable() {
		$this->load->model('prc_sap_sync');
		$datatable = $this->prc_sap_sync->get_list_pr();
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	public function get_detail($pr) {
		$this->load->model('prc_sap_sync');
		$data = $this->prc_sap_sync->pr($pr);
		echo json_encode($data);
	}

}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Administrative_mrpc extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
	}

	public function index() {
		$data['title'] = "Master Administrative MRPC";
		$this->load->model('adm_employee');
		$this->load->model('adm_plant');
		$data['emp'] = $this->adm_employee->get();
		$data['plant'] = $this->adm_plant->get();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->render('show_adm_mrpc',$data);
	}

	public function get_data() {
		$this->load->model('adm_mrpc');
		$this->adm_mrpc->join_emp_plant();
		$data['adm_mrpc'] = $this->adm_mrpc->get();
		echo json_encode($data);
	}

	public function add() {
		$this->load->model('adm_mrpc');
		$id = $this->adm_mrpc->get_id();

		$new['ID'] = $id;
		$new['MRPC'] = $this->input->post('new_mrpc');
		$new['PLANT'] = $this->input->post('new_plant');
		$new['EMP_ID'] = $this->input->post('new_emp');
		$new['ESELON'] = $this->input->post('new_eselon');
		$this->adm_mrpc->insert($new);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
	}

	public function edit() {
		$this->load->model('adm_mrpc');
		$where_edit['ID'] = $this->input->post('edit_id');

		$set_edit['MRPC'] = $this->input->post('mrpc');
		$set_edit['PLANT'] = $this->input->post('plant');
		$set_edit['EMP_ID'] = $this->input->post('emp');
		$set_edit['ESELON'] = $this->input->post('eselon');

		$this->adm_mrpc->update($set_edit, $where_edit);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
	}

	public function delete() {
		// echo json_encode($this->input->post()); exit();
		$this->load->model('adm_mrpc');
		$where_hapus['ID'] = $this->input->post('hapus_id');
		$this->adm_mrpc->delete($where_hapus);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
	}

}
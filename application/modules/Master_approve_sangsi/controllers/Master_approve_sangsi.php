<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Master_approve_sangsi extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
	}

	public function index() {
		$this->load->model('adm_employee');
		$this->load->model('adm_approve_sangsi');
		$data['title'] = "Master Approval Adjustment";
		$data['app'] = $this->adm_approve_sangsi->order_by('URUTAN','ASC')->get_all();
		$data['emp'] = $this->adm_employee->get();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->render('show_approve_sangsi',$data);
	}

	public function get_data($pgrp = null) {
		if ($pgrp == null) {
			echo json_encode(array());
		}
		$this->load->model('adm_approve_kewenangan');
		$this->adm_approve_kewenangan->join_emp();
		$data['adm_approve_kewenangan'] = $this->adm_approve_kewenangan->get(array('PGRP' => $pgrp));
		echo json_encode($data);
	}

	public function add() {
		$this->load->model('adm_approve_sangsi');
		$this->load->model('adm_employee');

		$new['EMP_ID'] = $this->input->post('new_employee');
		$new['URUTAN'] = intval($this->input->post('new_urutan'));

		$emp = $this->adm_employee->get(array('ID'=>$this->input->post('new_employee')));
		$new['NAMA'] = $emp[0]['FULLNAME'];
		$new['JABATAN'] = $emp[0]['POS_NAME'];
		$this->adm_approve_sangsi->insert($new);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
	}

	public function edit() {
		$this->load->model('adm_approve_sangsi');
		$this->load->model('adm_employee');

		$new['EMP_ID'] = $this->input->post('edit_employee');
		$new['URUTAN'] = intval($this->input->post('edit_urutan'));

		$emp = $this->adm_employee->get(array('ID'=>$this->input->post('edit_employee')));
		$new['NAMA'] = $emp[0]['FULLNAME'];
		$new['JABATAN'] = $emp[0]['POS_NAME'];
		$this->adm_approve_sangsi->update($new,array('ID' => intval($this->input->post('edit_id'))));
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
	}

	public function delete() {
		$this->load->model('adm_approve_sangsi');
		$where_hapus['ID'] = $this->input->post('hapus_id');
		$this->adm_approve_sangsi->delete($where_hapus);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
	}

}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Approve_kewenangan extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
	}

	public function index() {
		$this->load->model('adm_purch_grp');
		$this->load->model('adm_employee');
		$data['title'] = "Master Persetujuan Kewenangan";
		$data['pgrp'] = $this->adm_purch_grp->get();
		$data['emp'] = $this->adm_employee->get();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->render('show_approve_kewenangan',$data);
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
		// echo json_encode($this->input->post());
		$this->load->model('adm_purch_grp');
		$this->load->model('adm_approve_kewenangan');
		$pgrp = $this->adm_purch_grp->get(array('PURCH_GRP_CODE' => $this->input->post('new_pgrp')));
		$opco = $pgrp[0]['KEL_PURCH_GRP'];

		$new['PERSETUJUAN_ID'] = $this->adm_approve_kewenangan->get_id();
		$new['PGRP'] = $this->input->post('new_pgrp');
		$new['KEL_OPCO'] = $opco;
		$new['BATAS_HARGA'] = str_replace(',', '', $this->input->post('new_harga'));
		$new['EMP_ID'] = $this->input->post('new_employee');
		$new['URUTAN'] = intval($this->input->post('new_urutan'));
		$new['REL_CODE'] = $this->input->post('new_relcode');
		$new['REL_GRP'] = $this->input->post('new_relgrp');
		$new['PRC_STATUS'] = $this->input->post('new_cat_prc');
		$new['JABATAN'] = $this->input->post('new_jabatan');

		$this->adm_approve_kewenangan->insert($new);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
	}

	public function edit() {
		// echo json_encode($this->input->post());
		$this->load->model('adm_approve_kewenangan');
		$where_edit['PERSETUJUAN_ID'] = $this->input->post('edit_id');
		$set_edit['BATAS_HARGA'] = str_replace(',', '', $this->input->post('edit_harga'));
		$set_edit['EMP_ID'] = $this->input->post('edit_employee');
		$set_edit['URUTAN'] = intval($this->input->post('edit_urutan'));
		$set_edit['REL_CODE'] = $this->input->post('edit_relcode');
		$set_edit['REL_GRP'] = $this->input->post('edit_relgrp');
		$set_edit['PRC_STATUS'] = $this->input->post('edit_cat_prc');
		$set_edit['JABATAN'] = $this->input->post('edit_jabatan');
		$pgrp = $this->input->post('edit_pgrp');

		$this->adm_approve_kewenangan->update($set_edit, $where_edit);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
	}

	public function delete() {
		// echo json_encode($this->input->post()); exit();
		$this->load->model('adm_approve_kewenangan');
		$where_hapus['PERSETUJUAN_ID'] = $this->input->post('hapus_id');
		$this->adm_approve_kewenangan->delete($where_hapus);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
	}

}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Performance_criteria extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
	}

	public function index() {
		$this->load->model('vnd_perf_criteria');
		$this->load->model('vnd_perf_m_sanction');
		$this->load->model('adm_company');
		$data['title'] = "Master Vendor Performance Criteria";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$data['t_or_v'] = array(
			'T' => "Tender",
			'V' => "Vendor"
			);
		$data['req_or_buyer'] = array(
			'R' => "Requestioner",
			'B' => "Buyer"
			);
		$data['criteria_trigger_by'] = array(
			'0' => 'System',
			'1' => 'Manual'
			);
		$data['criteria_score_sign'] = array(
			'+' => "+",
			'-' => "-",
			'=' => "="
			);
		$data['special_sanction'] = $this->vnd_perf_m_sanction->get_list('KHUSUS');

		$data['company'] = $this->adm_company->get_list();

		// $this->layout->set_table_js();
		// $this->layout->set_table_cs();
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->add_js('pages/show_perf_criteria.js');
		$this->layout->render('show_perf_criteria',$data);
	}

	public function get_data() {
		$this->load->model('vnd_perf_criteria');
		$data['vnd_perf_criteria'] = $this->vnd_perf_criteria->get();
		echo json_encode($data);
	}

	public function add() {
		$this->load->model('vnd_perf_criteria');
		$id = $this->vnd_perf_criteria->get_id();

		$new['ID_CRITERIA'] = $id;
		$new['CRITERIA_NAME'] = $this->input->post('new_criteria_name');
		$new['CRITERIA_DETAIL'] = $this->input->post('new_criteria_detail');
		$new['CRITERIA_SCORE'] = intval($this->input->post('new_criteria_score'));
		$new['CRITERIA_SCORE_SIGN'] = $this->input->post('new_criteria_score_sign');
		$new['CRITERIA_TRIGGER_BY'] = $this->input->post('new_criteria_trigger_by');
		$new['T_OR_V'] = $this->input->post('new_t_or_v');
		$new['REQ_OR_BUYER'] = $this->input->post('new_req_or_buyer');
		$new['SPECIAL_SANCTION'] = $this->input->post('new_special_sanction');
		$new['COMPANYID'] = $this->input->post('new_company');
		
		$this->vnd_perf_criteria->insert($new);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
	}

	public function edit() {
		// echo json_encode($this->input->post());
		$this->load->model('vnd_perf_criteria');
		$where_edit['ID_CRITERIA'] = $this->input->post('edit_id');

		$set_edit['CRITERIA_NAME'] = $this->input->post('criteria_name');
		$set_edit['CRITERIA_DETAIL'] = $this->input->post('criteria_detail');
		$set_edit['CRITERIA_SCORE'] = intval($this->input->post('criteria_score'));
		$set_edit['CRITERIA_SCORE_SIGN'] = $this->input->post('criteria_score_sign');
		$set_edit['CRITERIA_TRIGGER_BY'] = $this->input->post('criteria_trigger_by');
		$set_edit['T_OR_V'] = $this->input->post('t_or_v');
		$set_edit['REQ_OR_BUYER'] = $this->input->post('req_or_buyer');
		$set_edit['SPECIAL_SANCTION'] = $this->input->post('special_sanction');
		$set_edit['COMPANYID'] = $this->input->post('company');

		$this->vnd_perf_criteria->update($set_edit, $where_edit);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
	}

	public function delete() {
		// echo json_encode($this->input->post()); exit();
		$this->load->model('vnd_perf_criteria');
		$where_hapus['ID_CRITERIA'] = $this->input->post('hapus_id');
		$this->vnd_perf_criteria->delete($where_hapus);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
	}

}
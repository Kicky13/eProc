<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_ece extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->load->library("file_operation");
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
	}

	public function index() {
		$data['title'] = "Monitoring Evaluasi ECE";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/monitoring_ece.js');	
		$this->layout->render('list', $data);
	}

	public function get_holder($id) {
		$this->load->model('prc_ece_change');
		$pec = $this->prc_ece_change->id($id);
		if($pec[0]['STATUS_APPROVAL']==1 || $pec[0]['STATUS_APPROVAL']==2){
			$join = 'USER_APPROVAL';
		}else{
			$join = 'PPR_ASSIGNEE';
		}
		$data['emp'] = $this->prc_ece_change->holder($id, $join);
		echo json_encode($data);
	}

	public function get_datatable() {
		$this->load->model('prc_tender_main');
        $pgrp = $this->session->userdata('PRGRP');
		if($pgrp != "''"){
			$this->prc_tender_main->where_pgrp_in($pgrp);
			$datatable = $this->prc_tender_main->get_ece();
		}
		if(!$datatable){
			$this->prc_tender_main->ppr_assignee($this->session->userdata('ID'));
			$datatable = $this->prc_tender_main->get_ece();
		}
		
		if($datatable){
			$data1 = $datatable;
		}else{
			$data1=array();
		}
		$data = array('data' => $data1);

		echo json_encode($data);
	}

	public function detail($id,$group_id){
		$data['title'] = 'Monitoring Evaluasi ECE';
		$this->load->model('prc_tender_main');
		$this->load->model('prc_ece_change_comment');
		$this->load->model('prc_ece_change');
		$this->load->model('adm_employee');
		$this->load->model('adm_employee_atasan');

		$com['comment'] = $this->prc_ece_change_comment->get(array('PTM_NUMBER'=>$id, 'EC_ID_GROUP'=>$group_id));
		$data['ece_comment'] = $this->load->view('Ece/ece_comment', $com, true);

			$this->prc_tender_main->join_assign_employee();
		$data['ptm'] = $this->prc_tender_main->ptm($id);
		$data['ptm'] = $data['ptm'][0];
		
			$this->prc_ece_change->join_pec();
		$data['pec'] = $this->prc_ece_change->get(array('PRC_ECE_CHANGE.PTM_NUMBER'=>$id,'EC_ID_GROUP'=>$group_id));

		$emp = $this->adm_employee->get(array('ID' => $this->authorization->getEmployeeId()));
		$nopeg = $emp[0]['NO_PEG'];

		$atasan = $this->adm_employee_atasan->get(array('MK_NOPEG' => $nopeg));
		$level = $atasan[0]['ATASAN1_LEVEL'];
		$this->is_kadep = ($level == 'DIR');

		if($this->is_kadep){
			$data['next_process']['nama'] = 'Approve';
			$data['next_process']['status'] = 2;
		}else{
			$atasan = $this->adm_employee->atasan($this->authorization->getEmployeeId());
			$atasan = $atasan[0];

			$data['next_process']['nama'] = 'Lanjut Approval '.$atasan['FULLNAME'];
			$data['next_process']['status'] = 1;
		}

		$this->load->model('adm_plant');
		$plant_master = $this->adm_plant->get();
		foreach ($plant_master as $val) {
			$data['plant_master'][$val['PLANT_CODE']] = $val;
		}
		
		$this->layout->add_js('pages/ece.js');
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();	
		$this->layout->render('detail', $data);

	}

}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Update_pengadaan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->load->library("file_operation");
		$this->load->model('currency_model');
		$this->load->helper('url');
		$this->load->library('comment');
	}

	public function index() {
		$data['success'] = $this->session->flashdata('success') == 'success';
		$data['title'] = "Daftar Pengadaan";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/list_update_pengadaan.js');
		$this->layout->render('update_pengadaan_list', $data);
	}

	public function get_datatable($all = false) {
		$this->load->model('prc_tender_main');
		$this->prc_tender_main->join_latest_activity();
		if ($all != false) {
			$datatable = $this->prc_tender_main->get();
		} else {
			$kelprgrp = $this->session->userdata('KEL_PRGRP');
			$this->prc_tender_main->where_kel_plant_pro($kelprgrp);

			$pgrp = $this->session->userdata('PRGRP');
			$this->prc_tender_main->where_pgrp_in($pgrp);

			$datatable = $this->prc_tender_main->get();
		}
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	public function detail($id){
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_approve');
		$this->load->model('app_process');
		$this->load->model('prc_approve_tender');
		$this->load->library('snippet');
		$this->load->library('process');

		$data['title'] = 'Update Pengadaan';
		$data['ptm_number'] = $id;
		$temp = $this->prc_tender_main->ptm($id);
		$data['ptm_detail'] = $temp[0];
		$this->prc_tender_prep->join_eval_template();
		$data['ptp'] = $this->prc_tender_prep->ptm($id);
		$data['tit'] = $this->prc_tender_item->ptm($id);
		$data['ptv'] = $this->prc_tender_vendor->get_join(array('PTM_NUMBER' => $id));
		$counter = $this->prc_tender_approve->get_max_counter($id, $data['ptm_detail']['PTM_COUNT_RETENDER']);

		$data['ptm_comment'] = $this->snippet->ptm_comment($id);
		$data['dokumen_pr'] = $this->snippet->dokumen_pr($id);

		$pat = $this->prc_approve_tender->counter_at($counter + 2, $this->authorization->getCompanyId());

		$data['next_process'] = $this->process->get_next_process($id);

		// var_dump($data);
		$this->layout->set_datetimepicker();
		$this->layout->add_js('pages/mydatetimepicker.js');
		// $this->layout->add_js('pages/aanwijing.js');
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();			
		$this->layout->render('detail_update_pengadaan',$data);
	}

	public function submit(){
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_approve');
		$this->load->model('prc_approve_tender');
		$this->load->model('prc_tender_approve_vendor');
		$this->load->library('process');

		$id = $this->input->post('ptm_number');
		$ptp['PTP_REG_CLOSING_DATE'] = $this->input->post('ptp_reg_closing_date');
		$this->prc_tender_prep->updateByPtm($id, $ptp);		

		$this->session->set_flashdata('success', 'success'); redirect('Update_pengadaan');
	}
}

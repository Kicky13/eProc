<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Job_list extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
	}

	public function index() {
		$this->session->keep_flashdata('success');
		$this->session->keep_flashdata('retender');
		$this->session->keep_flashdata('tambahaninfo');
		$this->session->keep_flashdata('reject');
		$this->session->keep_flashdata('fail');
		$this->session->keep_flashdata('data');
		redirect('Job_list/view');
	}

	public function view($cheat = null) {
		$data['success'] = $this->session->flashdata('success') == 'success';
		$data['data'] = $this->session->flashdata('data');
		$data['tambahaninfo'] = $this->session->flashdata('tambahaninfo');
		$data['reject'] = $this->session->flashdata('reject') == 'reject';
		$data['fail'] = $this->session->flashdata('fail') == 'fail';
		$data['retender'] = $this->session->flashdata('retender') == 'retender';
		$data['title'] = "Daftar Pekerjaan";
		// var_dump($data);
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		if ($cheat == 'cheat') {
			$data['cheat'] = true;
		}
		$this->layout->add_js('pages/job_list.js?2');
		$this->layout->add_js("strTodatetime.js");
		$this->layout->render('list_job', $data);
	}

	public function holder() {
		// $this->authorization->roleCheck();
		$data['title'] = "Daftar Pekerjaan";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/job_list_holder.js');
		$this->layout->render('list_job_holder', $data);
	}

	public function get_datatable($all = false) {
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_purchase_requisition_user');
		$this->load->model('prc_pr_item');
		
		$MKCCTR = $this->session->userdata('MKCCTR');
		$pgrp = $this->session->userdata('PRGRP');
		$kd_user = $this->session->userdata('GRPAKSES');
		
		$this->prc_tender_main->join_latest_activity();
		$this->prc_tender_main->join_prep();
		
		// if ($kd_user == 42||$kd_user == 281) {
		// 	$this->prc_tender_main->join_prItem();
		// 	$this->prc_tender_main->join_pr_req();
		// 		//array_push($ppr, var)
		// 	$this->prc_tender_main->where_req_in($MKCCTR);
		// }else {
		// 	$this->prc_tender_main->where_pgrp_in($pgrp);
		// }
		
		if ($all != false) {
			$datatable = $this->prc_tender_main->get();
		} else {
			// lama
			// $kelprgrp = $this->session->userdata('KEL_PRGRP');
			// $this->prc_tender_main->where_kel_plant_pro($kelprgrp);
			// baru
			// $this->prc_tender_main->where_pgrp_in($pgrp);
			// $pgrp = $this->session->userdata('PRGRP');
			// $this->prc_tender_main->where_pgrp_in($pgrp);

			$datatable = (array) $this->prc_tender_main->get_active_job($this->authorization->getEmployeeId());
		}
		foreach ($datatable as $key => $val) {
			if($val['MASTER_ID']==15){
				$rg=array();
				$pti = $this->prc_tender_item->ptm($val['PTM_NUMBER']);
				foreach ($pti as $value) {
					$rg[]=$value['TIT_STATUS'];				
				}
				$datatable[$key]['TIT_STATUS_GROUP']=$rg;
			}
		}
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	public function get_datatable_holder() {
		$this->load->model('prc_tender_main');
		$this->prc_tender_main->join_latest_activity();
		/* filter by KEL_PRGRP */
		$kelprgrp = $this->session->userdata('KEL_PRGRP');
		$this->prc_tender_main->where_kel_plant_pro($kelprgrp);
		//*/
		$datatable = $this->prc_tender_main->get();
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	public function get_holder($ptm) {
		$this->load->model('prc_process_holder');
		$data['emp'] = $this->prc_process_holder->emp($ptm);
		echo json_encode($data);
	}

	public function next_process($ptm_number) {
		$this->load->model('prc_tender_main');
		$this->load->library('procurement_job');

		$this->procurement_job->allow_once();

		$this->prc_tender_main->with_process_url();
		$ptm = $this->prc_tender_main->ptm($ptm_number);
		// var_dump($ptm);
		if (count($ptm) > 1) {
			echo "Error, proses terdeteksi lebih dari satu. Coba cek job master process lagi.<br>\n";
			var_dump($ptm);
		}
		$ptm = $ptm[0];

		redirect($ptm['APP_URL'] . '/' . $ptm_number);
	}

	public function show($id) {
		$this->load->model('prc_tender_main');
		$data['ppm'] = $this->prc_tender_main->prc_tender_main->ptm($id);
		$data['ptm'] = $this->prc_tender_main->get(array('PTM_NUMBER' => $id));

		print_r($data);
		exit();

		$this->layout->render('show', $data);
	}

	public function get_status_uptodate(){
		// $this->load->helper('file');
		// $this->load->model('prc_tender_prep');
		// $this->load->model('prc_tender_item');
		// $ptp=$this->prc_tender_prep->ptm($ptm_number);
		// $ptp=$ptp[0];
		// $pti=$this->prc_tender_item->ptm($ptm_number);	
		// $label=$this->prc_tender_item->get_tit_status();	
		// $status=array();
		// if($ptp['PTP_IS_ITEMIZE']){
		// 	foreach ($pti as $key => $value) {
		// 		$status[$value['TIT_ID']]=$label($value['TIT_STATUS']);
		// 	}
			
		// }
		//$status='tes';
		//$output = 'data:{$status}\n\n';		
		$status = date('d M Y H:i:s');
		$output = "data: {$status}\n\n";
		
		$this->output->set_header('Content-Type: text/event-stream');
		$this->output->set_header('Cache-Control: no-cache,filename=data.php')->set_output($output);

		flush();
	}

	public function get_item_status($ptm = null){
		$this->load->model('prc_tender_item');
		$this->prc_tender_item->join_pr();
		$pti=$this->prc_tender_item->ptm($ptm);
		$text_status=$this->prc_tender_item->get_tit_status();	
		$status=array();
		foreach ($pti as $value) {
			$status[] = array('PR_NO'=>$value['PPI_PRNO'],'PR_ITEM'=>$value['PPI_PRITEM'],'NOMAT'=>$value['PPI_NOMAT'],'NAME'=>$value['PPI_DECMAT'],'STATUS'=>$text_status[$value['TIT_STATUS']]);
		}
		echo json_encode($status);
	}

}

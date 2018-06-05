<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Buat ngassign proses. yang bisa diassign ya yang di
 * setting master processnya dikasih assignable
 */
class Proc_assign_pengadaan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('procurement_job');
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->library('comment');
	}

	/**
	 * @param $id ptm_number */
	public function show($id) {
		$this->procurement_job->check_authorization();
		$this->load->library('process');
		$this->load->library('snippet');
		$this->load->model('adm_employee');
		$this->load->model('prc_process_holder');
		$this->load->model('prc_tender_main');

		$ptm = $this->prc_tender_main->ptm($id);
		$ptmain = $ptm[0];
		$kel = $ptmain['KEL_PLANT_PRO'];
		$sam = $ptmain['SAMPUL'];
		$stat = $ptmain['PTM_STATUS'] + 1;
		$jst = $ptmain['JUSTIFICATION'];
		$emp = $this->process->get_emp_by_unique($kel, $sam, $jst, $stat, true); 
		$emp_id_unique = array();
		foreach ($emp as $val) {
			$emp_id_unique[] = $val['ID'];
		}

		$this->adm_employee->where_emp_in(array_unique($emp_id_unique));
		$this->adm_employee->join_pgrp();
		$this->adm_employee->where_pgrp_in($this->session->userdata('PRGRP'));
		$emps = $this->adm_employee->get();
		foreach ($emps as $val) {
			$count = $this->prc_process_holder->get_count($val['ID']);
			$val['COUNT'] = isset($count['HITUNG']) ? $count['HITUNG'] : 0;
			
			$count_assign = $this->prc_tender_main->get_count_assign($val['ID']);
			$val['COUNT_ASSIGN'] = isset($count_assign['HITUNG']) ? $count_assign['HITUNG'] : 0;

			$data['emp'][$val['ID']] = $val;
		}

		$data['title'] = "Assign Pengadaan";

		$this->load->model('prc_doc_type_master');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_plan_doc');
		
		$data['ptm'] = $ptmain;
		$data['ptp'] = $this->prc_tender_prep->ptm($id);
		$this->prc_tender_item->join_pr();
		$data['tit'] = $this->prc_tender_item->ptm($id);
		$this->load->library('process');
		$data['next_process'] = $this->process->get_next_process($id);
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);
		$data['detail_item_ptm'] = $this->snippet->detail_item_ptm($id);
		// $data['dokumen_pr'] = $this->snippet->dokumen_pr($id);
		$data['rfq_type'] = $this->prc_doc_type_master->get();

		$dokumen = array();
		$dokumens = array();
		$privacy = null;
		$vendor = false;
		$active = true;

		$this->prc_tender_item->join_pr();
		$dokumen['items'] = $this->prc_tender_item->ptm($id);
		$dokumen['itemdoc'] = array();
		foreach ($dokumen['items'] as $val) {
			$dokumens[$val['PPI_ID']] = $val;
			if ($privacy !== null) {
				$this->prc_plan_doc->where_privacy($privacy);
			}
			if ($active) {
				$this->prc_plan_doc->where_active();
			}
			$docs = $this->prc_plan_doc->pritem($val['PPI_ID']);
			$dokumen['itemdoc'][$val['PPI_ID']] = $docs;
		}
		
		$dok = array();
		$doknames = array();
		$count = 0;
		foreach ($dokumen['itemdoc'] as $key => $value) {
			$ppi_id = $key;
			foreach ($value as $key => $val) {
				$sama = false;
				foreach ($doknames as $index => $nval) {
					if ($nval == $val['PPD_FILE_NAME']) {
						$temp['DECMAT'] = $dokumens[$ppi_id]['PPI_DECMAT'];
						$temp['NOMAT'] = $dokumens[$ppi_id]['PPI_NOMAT'];
						$dok[$index]['item'][] = $temp;
						$sama = true;
						break;
					}	
				}
				if($sama == false){
					$doknames[] = $val['PPD_FILE_NAME'];
					$dok[$count]['nama'] = $val['PPD_FILE_NAME'];
					$dok[$count]['PDC_NAME'] = $val['PDC_NAME'];
					$dok[$count]['PDC_IS_PRIVATE'] = $val['PDC_IS_PRIVATE'];
					$dok[$count]['PPD_DESCRIPTION'] = $val['PPD_DESCRIPTION'];
					$dok[$count]['IS_SHARE'] = $val['IS_SHARE'];
					$dok[$count]['item'][0]['DECMAT'] = $dokumens[$ppi_id]['PPI_DECMAT'];
					$dok[$count]['item'][0]['NOMAT'] =  $dokumens[$ppi_id]['PPI_NOMAT'];
					$count = $count + 1;
				}
				// var_dump($val);
			}
		}
		$data['dokumen'] = $dok;

		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_datetimepicker();
		$this->layout->add_js('pages/mydatetimepicker.js');
		$this->layout->add_js('pages/proc_assign_pros.js');
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->add_js('plugins/numeral/numeral.js');
		$this->layout->add_js('plugins/numeral/languages/id.js');
		$this->layout->render('proc_assign_process', $data);
		//var_dump($emp);
	}

	public function assign() {
		$this->load->model('prc_tender_main');
		$id = $this->input->post('ptm_number');
		$assign = $this->input->post('assign');

		$comment_id = $this->comment->get_new_id();
		$dataComment = array(
				"PTC_ID"       => $comment_id,
				"PTM_NUMBER"   => $id,
				"PTC_COMMENT"  => '\''.$this->input->post('comment').'\'',
				"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
				"PTC_NAME"     => '\''.$this->authorization->getCurrentName().'\'',
				"PTC_ACTIVITY" => "'Assign Pengadaan'",
			);
		$this->comment->insert_comment_tender($dataComment);

		$submit = $this->input->post('harus_pilih');
		$action = 'REJECT';
		if ($submit == "accept") {
			$action = 'OK';
		}
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Assign Kasi Pengadaan',$action,$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Proc_assign_pengadaan/assign','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		if($submit == "accept"){
			$assigny = intval($assign);
			if ($assigny <= 0) {
				$this->session->set_flashdata('fail', 'fail'); redirect('Job_list');
			}
			// $this->prc_tender_main->join_app_process();
			$this->load->library('process');
			$this->process->next_process_user($id, 'NEXT', $assign);
			$this->prc_tender_main->updateByPtm($id, array('PTM_ASSIGNMENT' => $assign));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Proc_assign_pengadaan/assign','prc_tender_main','update',array('PTM_ASSIGNMENT' => $assign),array('PTM_NUMBER' => $id));
				//--END LOG DETAIL--//

			$this->session->set_flashdata('success', 'success'); redirect('Job_list');

		} else {
			$this->load->model('prc_tender_item');
			$this->load->model('prc_pr_item');
			$this->load->model('prc_tender_main');
			$this->load->model('adm_employee');
			$this->load->library('snippet');

			$item = $this->prc_tender_item->ptm($id);
			foreach ($item as $key => $value) {
				$pr_item = $this->prc_pr_item->get(array('PPI_ID'=>$value['PPI_ID']));
				$this->prc_pr_item->update(array('PPI_QTY_USED' => $pr_item[0]['PPI_QTY_USED'] - $value['TIT_QUANTITY']), array('PPI_ID'=>$pr_item[0]['PPI_ID']));
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Proc_assign_pengadaan/assign','prc_pr_item','update',array('PPI_QTY_USED' => $pr_item[0]['PPI_QTY_USED'] - $value['TIT_QUANTITY']),array('PPI_ID'=>$pr_item[0]['PPI_ID']));
					//--END LOG DETAIL--//
			}
			$data = $this->prc_tender_main->ptm($id);
			$this->prc_tender_main->updateByPtm($id, array('PTM_STATUS' => $data['0']['PTM_STATUS'] * - 1 ));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Proc_assign_pengadaan/assign','prc_tender_main','update',array('PTM_STATUS' => $data['0']['PTM_STATUS'] * - 1 ),array('PTM_NUMBER' => $id));
				//--END LOG DETAIL--//

			$emp = $this->adm_employee->get(array('ID'=>$data[0]['PTM_REQUESTER_ID']));
			$user['EMAIL'] = $emp[0]['EMAIL'];
			$user['data']['ptm_subpratender'] = $data[0]['PTM_SUBPRATENDER'];
			$user['data']['rejector'] = $this->session->userdata['FULLNAME'];
			$user['data']['tgl_reject'] = date('d-M-Y H:i:s');
			$user['data']['komentar'] = $this->input->post('comment');
			$user['data']['detail_item']=$this->snippet->detail_item_ptm($id,false,true);
	
			require_once(APPPATH.'/modules/Procurement_pratender/controllers/Procurement_pratender.php');
            $aObj = new Procurement_pratender();
            $aObj->kirim_email_reject($user);

			$this->session->set_flashdata('reject', 'reject'); redirect('Job_list');
		}
	}

	public function index() {
		redirect('Job_list');
		// $this->authorization->roleCheck();
		$this->load->library('process');
		$this->load->model('m_global');

		$data['success'] = $this->session->flashdata('success');
		$data['title'] = "Assign Proses";
		$data["assignto"] = $this->m_global->getcombo("SELECT DISTINCT ID,FULLNAME  NAMA 
				FROM ADM_EMPLOYEE 
				WHERE ADM_POS_ID IN(
					SELECT V_APP_PROCCESS.ROLE 
					FROM V_APP_PROCCESS 
					WHERE KEL_PLANT_PRO='".$this->session->userdata('KEL_PRGRP')."')");

		// ga bisa ini ngawur
		// $this->process->get_emp_by_unique($kel, $sampul, $jst, $status);

		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/proc_assign_peng.js');
		$this->layout->render('proc_assign_pengadaan', $data);
	}

	public function update() {
		// $this->load->library('process');
		// $this->load->model('prc_process_holder');

		// $user = intval($this->input->post('assignto'));
		// if ($this->input->post('ptm_number') != false && $user > 0) {
		// 	foreach ($this->input->post('ptm_number') as $ptm_number) {
		// 		$this->process->next_process_user($ptm_number, 'NEXT', $user);

		// 		// insert and upload comment attachment
		// 		$comment_id = $this->comment->get_new_id();
		// 		$dataComment = array(
		// 				"PTC_ID" => $comment_id,
		// 				"PTM_NUMBER" => $ptm_number,
		// 				"PTC_COMMENT" => '\''.$this->input->post('comment').'\'',
		// 				"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
		// 				"PTC_NAME" => '\''.$this->authorization->getCurrentName().'\'',
		// 				"PTC_ACTIVITY" => '\''."Assign Konfigurasi Pengadaan".'\''
		// 			);
		// 		$this->comment->insert_comment_tender($dataComment);

		// 		// masukin ke history reassign
		// 	}
		// 	$this->session->set_flashdata('success', 'success');
		// } else {
			$this->session->set_flashdata('success', 'fail');
		// }
		redirect('Proc_assign_pengadaan');
	}

	/* Perlu diperbaiki lagi, ini khusus yang bisa diassign */
	public function get_datatable() {
		$this->load->model('prc_tender_main');
		$this->prc_tender_main->join_latest_activity();

		/* filter kelpgrp */
		$kelprgrp = $this->session->userdata('KEL_PRGRP');
		$this->prc_tender_main->where_kel_plant_pro($kelprgrp);

		/* filter pgrp */
		$pgrp = $this->session->userdata('PRGRP');
		$this->prc_tender_main->where_pgrp_in($pgrp);

		/* cuma buat yang bisa diassign aja */
		$this->prc_tender_main->where_assignable();

		$datatable = $this->prc_tender_main->get_active_job($this->authorization->getEmployeeId());
		// $datatable = $this->prc_tender_main->get();
		$data = array('data' => (array) $datatable);
		echo json_encode($data);
	}

}

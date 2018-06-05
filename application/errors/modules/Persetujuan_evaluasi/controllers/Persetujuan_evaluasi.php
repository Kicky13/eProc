<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Persetujuan_evaluasi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('procurement_job');
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->load->library("file_operation");
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
		$this->load->library('comment');
	}

	public function index($id = '') {
		$this->procurement_job->check_authorization();
		$this->load->model('adm_dept');
		$this->load->model('adm_employee');
		$this->load->model('app_process_master');
		$this->load->model('prc_do_evatek_uraian');
		$this->load->model('prc_eval_file');
		$this->load->model('prc_evaluasi_teknis');
		$this->load->model('prc_evaluasi_uraian');
		$this->load->model('prc_add_item_evaluasi');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_chat');

		$this->load->library('snippet');

		$data['title'] = 'Persetujuan Evaluasi';
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);
		$data['evaluator'] = $this->snippet->evaluator($id);
		$data['evaluasi'] = $this->snippet->evaluasi($id, false, false);
		$data['vendor_ptm'] = $this->snippet->vendor_ptm($id, true);
		$data['ptm_number'] = $id;
		// echo "<pre>";
		// var_dump($data['evaluasi']);die;

		$this->prc_add_item_evaluasi->where_ptm($id);
		$data['dokumentambahan'] = $this->prc_add_item_evaluasi->get();

		$ptm = $this->prc_tender_main->prc_tender_main->ptm($id);
		$ptm = $ptm[0];

		$next = $this->get_next_holder($id);
		// echo 'next = ' . $next;
		if ($next == 0) {
			$this->load->library('process');
			$data['next_process'] = $this->process->get_next_process($id);
		} else {
			$data['next_process'] = $ptm;

			$atasan = $this->adm_employee->get(array('ID' => $next));
			$atasan = $atasan[0];

			$data['next_process']['NAMA_BARU'] .=  ' (oleh '. $atasan['FULLNAME'].')'.($this->is_kadep ? '*' : '');
		}

		$this->load->model('prc_evaluator');
		$counter = $this->prc_evaluator->get_max_counter($id, $ptm['PTM_COUNT_RETENDER']);

		$this->prc_evaluator->where_status('0');
		$this->counter = $this->prc_evaluator->get_max_counter($id, $ptm['PTM_COUNT_RETENDER']);

		if ($this->counter == $counter) {
			$data['bisaevaluasi'] = true;
		} else {
			$data['bisaevaluasi'] = false;
		}
		
		/********************************************************************/
			$this->prc_tender_item->where_status_not(array(999));
		$data['tit'] = $this->prc_tender_item->ptm($id);

		$this->prc_tender_vendor->where_active();
		$data['ptv'] = $this->prc_tender_vendor->ptm($id);
		foreach ((array)$data['ptv'] as $key => $val) {
			$this->prc_eval_file->where_ptm_ptv($id, $val['PTV_VENDOR_CODE']);
			$ef = $this->prc_eval_file->get();
			if(!empty($ef[0]['EF_FILE'])){
				$data['pef'][$val['PTV_VENDOR_CODE']] = $ef[0]['EF_FILE'];
			}
		}

		/* Ngambil PQI */
		foreach ($data['ptv'] as $vnd) {
			/* Ngisi tabel buat pilih pemenang */
			foreach ($data['tit'] as $tit) {
				$this->prc_tender_quo_item->where_tit($tit['TIT_ID']);
				$pqi = $this->prc_tender_quo_item->ptm_ptv($id, $vnd['PTV_VENDOR_CODE']);
				// $data['pqis'][] = $pqi;
				if ($pqi != null) {
					$pqi = $pqi[0];
					$data['pqi'][$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']] = $pqi;
				}
			}
		}

		$this->prc_evaluasi_teknis->where_ptm($id);
		$ppd = $this->prc_evaluasi_teknis->get();
		foreach ($ppd as $val) {
			$p = $this->prc_evaluasi_uraian->get(array('ET_ID' => $val['ET_ID']));
			foreach ($p as $pe2) {
				$peuu[$pe2['ET_ID']][$pe2['TIT_ID']][$pe2['EU_NAME']]=$pe2;
				$data['peu2'][$val['ET_ID']][$pe2['TIT_ID']][$pe2['EU_NAME']][]=$pe2;
			}
		}

		foreach ($ppd as $val) {
			$pe = $this->prc_evaluasi_uraian->get(array('ET_ID' => $val['ET_ID']));
			$data['ppd2'][$pe[0]['TIT_ID']][]=$val;
			
			$pee = $this->prc_evaluasi_uraian->get_dist(array('ET_ID' => $val['ET_ID']));
			foreach ($pee as $value) {
				$eu_id = '';
				$eu_weight = '';
				if(isset($peuu[$val['ET_ID']][$pe[0]['TIT_ID']][$value['EU_NAME']])){
					$eu_id = $peuu[$val['ET_ID']][$pe[0]['TIT_ID']][$value['EU_NAME']]['EU_ID'];
					$eu_weight = $peuu[$val['ET_ID']][$pe[0]['TIT_ID']][$value['EU_NAME']]['EU_WEIGHT'];
				}
				$data['peu'][$val['ET_ID']][$pe[0]['TIT_ID']][] = array(
																		'EU_ID' => $eu_id,
																		'EU_NAME' => $value['EU_NAME'],
																		'EU_WEIGHT' => $eu_weight,
																	);
			}
		}

		$this->prc_do_evatek_uraian->where_ptm($id);
		$deu = $this->prc_do_evatek_uraian->get();
		foreach ($deu as $val) {
			$data['det'][$val['TIT_ID']][$val['ET_ID']][$val['PTV_VENDOR_CODE']] = $val;
			$data['deu'][$val['TIT_ID']][$val['ET_ID']][$val['PTV_VENDOR_CODE']][$val['EU_ID']] = $val;
			
		}

		$data['vendor_data'] = $this->prc_tender_quo_main->get_join(array('PRC_TENDER_QUO_MAIN.PTM_NUMBER' => $id));
		// var_dump($data); exit();
		/********************************************************************/

		$this->prc_chat->order_tgl();
		$this->prc_chat->join_employee_vendor();
		$ps['pesan'] = $this->prc_chat->get(array('PTM_NUMBER'=>$id));
		$ps['balas'] = false;

		$data['pesan'] = $this->load->view('Evaluasi_penawaran/history_pesan', $ps, true);

		// var_dump($data);
		$this->layout->add_js('pages/persetujuan_evaluasi.js');
		$this->layout->add_js('pages/evaluasi_teknis.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();			
		$this->layout->render('persetujuan_evaluasi',$data);
	}

	public function get_next_holder($id) {
		$this->load->model('adm_employee');
		$this->load->model('adm_employee_atasan');
		$this->load->model('prc_evaluator');
		$this->load->model('prc_tender_main');

		$emp = $this->adm_employee->get(array('ID' => $this->authorization->getEmployeeId()));
		$nopeg = $emp[0]['NO_PEG'];

		$atasan = $this->adm_employee_atasan->get(array('MK_NOPEG' => $nopeg));
		$level = $atasan[0]['ATASAN1_LEVEL'];

		$this->is_kadep = ($level == 'DIR' || $level == 'REPT'); //nyo 22022017

		if ($this->is_kadep) {
			// echo $level . ' ';
			$ptm = $this->prc_tender_main->ptm($id);
			$this->prc_evaluator->where_status('0');
			$this->counter = $this->prc_evaluator->get_max_counter($id, $ptm[0]['PTM_COUNT_RETENDER']);

			// echo $this->counter;
			if ($this->counter != 1) {
				$evaluator = $this->prc_evaluator->get(array('PE_COUNTER' => $this->counter - 1, 'PTM_NUMBER' => $id));
				return $evaluator[0]['EMP_ID'];
			} else {
				return 0;
			}
		} else {
			// echo 'bukan kadep';
			$ans = $this->adm_employee->atasan($this->authorization->getEmployeeId());
			return $ans[0]['ID'];
		}
	}

	public function save_bidding() {
		// var_dump($this->input->post());exit();
		$this->load->model('prc_tender_main');
		$this->load->model('adm_employee');
		$this->load->library('process');
		$this->load->model('prc_tender_quo_item');
		$this->load->library('penilaian_otomatis');
		
		$id = $this->input->post('ptm_number');
		$ptm = $this->prc_tender_main->ptm($id);

		$comment_id = $this->comment->get_new_id(); 
		// $this->load->library("file_operation");
		// $this->file_operation->upload(UPLOAD_PATH.'comment_attachment/'.$id."_".$comment_id, $_FILES);
		$dataComment = array(
			"PTC_ID" => $comment_id,
			"PTM_NUMBER" => $id,
			"PTC_COMMENT" => '\''.$this->input->post('ptc_comment').'\'',
			"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
			"PTC_NAME" => '\''.$this->authorization->getCurrentName().'\'',
			"PTC_ACTIVITY" => "'Approval Evaluasi'",
			"PTC_STATUS_PROSES" => $ptm[0]['MASTER_ID'],
			);
		$this->comment->insert_comment_tender($dataComment);

			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Approval Evatek','OK',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Persetujuan_evaluasi/save_bidding','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		/********************************************************************************/
		if ($this->input->post('bisaevaluasi') == 'true') {
			$this->load->model('prc_do_evatek');
			$this->load->model('prc_do_evatek_uraian');
			foreach ($this->input->post('det') as $key => $det) {
				$this->prc_do_evatek->update(array('DET_TECH_VAL' => $det), array('DET_ID' => $key));
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Persetujuan_evaluasi/save_bidding','prc_do_evatek','update',array('DET_TECH_VAL' => $det),array('DET_ID' => $key));
					//--END LOG DETAIL--//
			}

			foreach ($this->input->post('deu') as $key => $deu) {
				$this->prc_do_evatek_uraian->update(array('DEU_TECH_VAL' => $deu), array('DEU_ID' => $key));
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Persetujuan_evaluasi/save_bidding','prc_do_evatek_uraian','update',array('DEU_TECH_VAL' => $deu),array('DEU_ID' => $key));
					//--END LOG DETAIL--//
			}

			foreach ($this->input->post('total') as $key => $total) {
				$this->prc_tender_quo_item->update(array('PQI_TECH_VAL' => $total), array('PQI_ID' => $key));
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Persetujuan_evaluasi/save_bidding','prc_tender_quo_item','update',array('PQI_TECH_VAL' => $total),array('PQI_ID' => $key));
					//--END LOG DETAIL--//
			}
		}
		/********************************************************************************/

		// $next_process = $this->input->post('next_process');
		$next = $this->get_next_holder($id);
		// echo 'next = ' . $next;

		if ($next == 0) {
			$this->load->model('prc_tender_prep');

			$this->prc_tender_quo_item->join_pqm();
			$ptqi = $this->prc_tender_quo_item->get_by_ptm($id);

			$this->prc_tender_prep->join_eval_template();
			$ptp = $this->prc_tender_prep->ptm($id);

			$pembuat = $ptm[0]['PTM_REQUESTER_ID'];

			$this->penilaian_otomatis->insert('persetujuan_evaluasi', $ptqi, $ptm[0]['PTM_PRATENDER'], $ptp['EVT_PASSING_GRADE'], $LM_ID);
			
			$this->process->next_process_assignment($id, 'NEXT', $LM_ID);
		} else {
			if ($this->is_kadep) {
				$where['PE_COUNTER'] = $this->counter;
				$where['PTM_NUMBER'] = $id;
				$set = array('PE_STATUS' => 1);
				$this->prc_evaluator->update($set, $where);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Persetujuan_evaluasi/save_bidding','prc_evaluator','update',$set,$where);
					//--END LOG DETAIL--//
			}
			$this->process->next_process_user($id, 'CURRENT', $next, $LM_ID);
		}
		// var_dump($atasan);
		// exit();

		$this->session->set_flashdata('success', 'success'); redirect('Job_list');
	}

}
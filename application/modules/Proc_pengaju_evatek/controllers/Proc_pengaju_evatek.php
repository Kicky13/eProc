<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proc_pengaju_evatek extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('procurement_job');
		$this->load->library('form_validation');
		$this->load->library("file_operation");
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
		$this->load->library('comment');
	}

	public function index($id) {
		$this->procurement_job->check_authorization();
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_item');
		$this->load->model('app_process_master');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('adm_employee');
		$this->load->library('snippet');

		$data['detail_ptm_snip'] = $this->snippet->detail_ptm($id);
		$data['vendor_ptm'] = $this->snippet->vendor_ptm($id, true);
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);

		$data['title'] = 'Pengajuan Evaluasi Teknis';
		$data['ptm_number'] = $id;
		$this->prc_tender_item->join_pr();
		$data['items'] = $this->prc_tender_item->ptm($id);
		$requestioner = array();
		$data['employees'] = array();

		$opco = $this->session->userdata['EM_COMPANY'];

		foreach ($data['items'] as $val) {
			$requestioner[] = $val['PPR_REQUESTIONER'];
			$mrpc = $val['PPI_MRPC'];
			$plant = $val['PPR_PLANT'];

			if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
				$this->adm_employee->mrpc_plant($mrpc, $plant);
				$data['employees'] = $this->adm_employee->get();

			} else if ($opco == '3000' || $opco == '4000') {
				$this->adm_employee->where_mkcctr($requestioner);
				$data['employees'] = $this->adm_employee->get();
			} 

		}

		// $requestioner = array_unique($requestioner);
		// $this->adm_employee->join_dep();
		// $this->adm_employee->where_mkcctr($requestioner);

		$ptm = $this->prc_tender_main->ptm($id);
		$ptm = $ptm[0];

		$ptp = $this->prc_tender_prep->ptm($id);

		$dateNew = date('Y-m-d H:i:s');	
		$process = 0;
		
		if($ptm['MASTER_ID']=='6'){
			if(oraclestrtotime($ptp['PTP_REG_CLOSING_DATE']) < strtotime($dateNew)){
				$process = 1;
			}
		}else if($ptm['MASTER_ID'] >'6'){
			$process = 1;
		}

		$bts_vnd_hrga = 0;
		if($ptm['MASTER_ID']=='12'){
			if(strtotime($ptm['BATAS_VENDOR_HARGA_RG']) < strtotime($dateNew)){
				$bts_vnd_hrga = 1;
			}
		}else if($ptm['MASTER_ID'] >'12'){
			$bts_vnd_hrga = 1;
		}

		$data['evaluasi_harga'] = false; 
		if($ptp['PTP_IS_ITEMIZE'] != null && $ptp['PTP_EVALUATION_METHOD'] == '1 Tahap 1 Sampul' && $ptm['MASTER_ID'] >= 6 && !preg_match('/11|12/', $ptm['MASTER_ID']) && $process == 1){
			$data['evaluasi_harga'] = true;
		}
		if($ptp['PTP_IS_ITEMIZE'] != null && $ptp['PTP_EVALUATION_METHOD'] == '2 Tahap 1 Sampul' &&  $ptm['MASTER_ID'] >= 13){
			$data['evaluasi_harga'] = true;
		}
		if($ptp['PTP_IS_ITEMIZE'] != null && $ptp['PTP_EVALUATION_METHOD'] == '2 Tahap 2 Sampul' &&  $ptm['MASTER_ID'] >= 12 && $bts_vnd_hrga == 1){
			$data['evaluasi_harga'] = true;
		}
		$this->prc_tender_prep->join_eval_template();
		$data['ptp_r'] = $this->prc_tender_prep->ptm($id);
		$data['tit'] = $this->prc_tender_item->ptm($id);
		$data['ptv'] = $this->prc_tender_vendor->ptm($id);
		$data['vendor_galulus'] = array();

		$ptv = array();
		foreach ($data['ptv'] as $key => $vnd) {
			$ptv[$vnd['PTV_VENDOR_CODE']] = $vnd;
		}
		$data['ptv'] = $ptv;

		/* Ngambil PQI */
		$x = array();
		foreach ($data['ptv'] as $vnd) {
			/* Ngisi tabel buat pilih pemenang */
			foreach ($data['tit'] as $tit) {
				$this->prc_tender_quo_item->where_tit($tit['TIT_ID']);
				$pqi = $this->prc_tender_quo_item->ptm_ptv($id, $vnd['PTV_VENDOR_CODE']);
				// $data['pqis'][] = $pqi;
				if ($pqi != null) {
					$pqi = $pqi[0];
					if (intval($pqi['PQI_TECH_VAL']) < intval($data['ptp_r']['EVT_PASSING_GRADE'])) {
						$pqi['LULUS_TECH'] = false;
						$data['vendor_galulus'][] = $vnd['PTV_VENDOR_CODE'];
					} else {
						$pqi['LULUS_TECH'] = true;
					}
					$data['pqi'][$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']] = $pqi;
				}
			}
		}
		$data['vendor_galulus'] = array_unique($data['vendor_galulus']);

		if ($data['ptp_r']['PTP_IS_ITEMIZE'] == 0) {
			foreach ($data['ptv'] as $vnd) {
				/* Ngisi tabel buat pilih pemenang */
				foreach ($data['tit'] as $tit) {
					if (in_array($vnd['PTV_VENDOR_CODE'], $data['vendor_galulus'])) {
						$data['pqi'][$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['LULUS_TECH'] = false;
					}
				}
			}
		}
		if(isset($data['pqi'])){
			foreach ($data['pqi'] as $key => $value) {
				usort($data['pqi'][$key], array($this, "sort_eval"));
			}

			$arr = array();
			foreach ($data['pqi'] as $key => $value) {
				$arr2 = array();
				foreach ($value as $k => $val) {
					$arr2[$val['PTV_VENDOR_CODE']] = $val;
				}
				$arr[$key] = $arr2;
			}
			$data['pqi'] = $arr;	
		}

		$this->load->library('process');
		$data['next_process'] = $this->process->get_next_process($id);

		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->add_js('pages/verify_entry.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('det_pengaju_evatek',$data);
	}

	private function sort_eval($a, $b) {
		return ($a['LULUS_TECH'] < $b['LULUS_TECH']);
	}

	public function approval($id) {
		$this->procurement_job->check_authorization();
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_item');
		$this->load->model('app_process_master');
		$this->load->model('adm_employee');
		$this->load->model('prc_evaluator');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_quo_item');

		$data['evaluator'] = $this->prc_evaluator->ptm($id);
		$data['evaluator'] = $data['evaluator'][0];

		$data['evaluator'] = $this->adm_employee->find($data['evaluator']['EMP_ID']);
		// var_dump($data['evaluator']);
		// die();
		$this->load->library('snippet');

		$data['detail_ptm_snip'] = $this->snippet->detail_ptm($id);
		$data['vendor_ptm'] = $this->snippet->vendor_ptm($id, true);
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);

		$data['title'] = 'Pengajuan Evaluasi Teknis';
		$data['ptm_number'] = $id;
		$this->prc_tender_item->join_pr();
		$data['items'] = $this->prc_tender_item->ptm($id);
		$requestioner = array();
		foreach ($data['items'] as $val) {
			$requestioner[] = $val['PPR_REQUESTIONER'];
		}
		$data['employees'] = array();
		if($requestioner){
			$requestioner = array_unique($requestioner);
			// $this->adm_employee->join_dep();
			$this->adm_employee->where_mkcctr($requestioner);
			$data['employees'] = $this->adm_employee->get();
		}

		$ptm = $this->prc_tender_main->ptm($id);
		$ptm = $ptm[0];

		$ptp = $this->prc_tender_prep->ptm($id);

		$dateNew = date('Y-m-d H:i:s');	
		$process = 0;
		
		if($ptm['MASTER_ID']=='6'){
			if(oraclestrtotime($ptp['PTP_REG_CLOSING_DATE']) < strtotime($dateNew)){
				$process = 1;
			}
		}else if($ptm['MASTER_ID'] >'6'){
			$process = 1;
		}

		$bts_vnd_hrga = 0;
		if($ptm['MASTER_ID']=='12'){
			if(strtotime($ptm['BATAS_VENDOR_HARGA_RG']) < strtotime($dateNew)){
				$bts_vnd_hrga = 1;
			}
		}else if($ptm['MASTER_ID'] >'12'){
			$bts_vnd_hrga = 1;
		}

		$data['evaluasi_harga'] = false; 
		if($ptp['PTP_IS_ITEMIZE'] != null && $ptp['PTP_EVALUATION_METHOD'] == '1 Tahap 1 Sampul' && $ptm['MASTER_ID'] >= 6 && !preg_match('/11|12/', $ptm['MASTER_ID']) && $process == 1){
			$data['evaluasi_harga'] = true;
		}
		if($ptp['PTP_IS_ITEMIZE'] != null && $ptp['PTP_EVALUATION_METHOD'] == '2 Tahap 1 Sampul' &&  $ptm['MASTER_ID'] >= 13){
			$data['evaluasi_harga'] = true;
		}
		if($ptp['PTP_IS_ITEMIZE'] != null && $ptp['PTP_EVALUATION_METHOD'] == '2 Tahap 2 Sampul' &&  $ptm['MASTER_ID'] >= 12 && $bts_vnd_hrga == 1){
			$data['evaluasi_harga'] = true;
		}
		$this->prc_tender_prep->join_eval_template();
		$data['ptp_r'] = $this->prc_tender_prep->ptm($id);
		$data['tit'] = $this->prc_tender_item->ptm($id);
		$data['ptv'] = $this->prc_tender_vendor->ptm($id);
		$data['vendor_galulus'] = array();

		$ptv = array();
		foreach ($data['ptv'] as $key => $vnd) {
			$ptv[$vnd['PTV_VENDOR_CODE']] = $vnd;
		}
		$data['ptv'] = $ptv;

		/* Ngambil PQI */
		$x = array();
		foreach ($data['ptv'] as $vnd) {
			/* Ngisi tabel buat pilih pemenang */
			foreach ($data['tit'] as $tit) {
				$this->prc_tender_quo_item->where_tit($tit['TIT_ID']);
				$pqi = $this->prc_tender_quo_item->ptm_ptv($id, $vnd['PTV_VENDOR_CODE']);
				// $data['pqis'][] = $pqi;
				if ($pqi != null) {
					$pqi = $pqi[0];
					if (intval($pqi['PQI_TECH_VAL']) < intval($data['ptp_r']['EVT_PASSING_GRADE'])) {
						$pqi['LULUS_TECH'] = false;
						$data['vendor_galulus'][] = $vnd['PTV_VENDOR_CODE'];
					} else {
						$pqi['LULUS_TECH'] = true;
					}
					$data['pqi'][$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']] = $pqi;
				}
			}
		}
		$data['vendor_galulus'] = array_unique($data['vendor_galulus']);

		if ($data['ptp_r']['PTP_IS_ITEMIZE'] == 0) {
			foreach ($data['ptv'] as $vnd) {
				/* Ngisi tabel buat pilih pemenang */
				foreach ($data['tit'] as $tit) {
					if (in_array($vnd['PTV_VENDOR_CODE'], $data['vendor_galulus'])) {
						$data['pqi'][$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['LULUS_TECH'] = false;
					}
				}
			}
		}
		if(isset($data['pqi'])){
			foreach ($data['pqi'] as $key => $value) {
				usort($data['pqi'][$key], array($this, "sort_eval"));
			}

			$arr = array();
			foreach ($data['pqi'] as $key => $value) {
				$arr2 = array();
				foreach ($value as $k => $val) {
					$arr2[$val['PTV_VENDOR_CODE']] = $val;
				}
				$arr[$key] = $arr2;
			}
			$data['pqi'] = $arr;	
		}

		$this->load->library('process');
		$data['next_process'] = $this->process->get_next_process($id);

		$this->layout->add_js('pages/verify_entry.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('approval_evatek',$data);
	}

	public function save_approval(){
		$this->load->library('process');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_pr_item');
		$this->load->model('adm_employee');
		$this->load->model('prc_tender_main');
		$this->load->model('app_process');

		$submit = $this->input->post('next_process');
		$id = $this->input->post('ptm_number');
		// echo "<pre>";
		// print_r($id);die;
		$evaluator = $this->input->post('id_emp');

		$comment_id = $this->comment->get_new_id();
		$dataComment = array(
			"PTC_ID" => $comment_id,
			"PTM_NUMBER" => $id,
			"PTC_COMMENT" => '\''.$this->input->post('ptc_comment').'\'',
			"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
			"PTC_NAME" => '\''.$this->authorization->getCurrentName().'\'',
			"PTC_ACTIVITY" => "'Approval Pengajuan Evaluasi Teknis'",
			// "PTC_ATTACHMENT" => '\''.$_FILES["ptc_attachment"]["name"].'\''
			);

		// echo "<pre>";
		// print_r($dataComment);die;
		$this->comment->insert_comment_tender($dataComment);

		$action = 'APPROVE';
		if ($submit == 0) {
			$action = 'REJECT';
		}
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),$this->input->post('process_name'),$action,$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Proc_pengaju_evatek/save_approval','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		// $next_process = $this->input->post('next_process');
		if($submit == '1'){
			$ptm = $this->prc_tender_main->ptm($id);
			$pti = $this->prc_tender_item->get(array('PTM_NUMBER'=>$id));
			// echo "<pre>";
			// print_r($pti);die;
			$pri = $this->prc_pr_item->where_ppiId($pti[0]['PPI_ID']);
			$emp = $this->adm_employee->get(array('ID'=>$evaluator));

			$user['EMAIL'] = $emp[0]['EMAIL'];
			$user['data']['judul'] = 'Evaluasi Teknis';
			$user['data']['nama_pengadaan'] = $ptm[0]['PTM_SUBJECT_OF_WORK'];
			$user['data']['no_pengadaan'] = $ptm[0]['PTM_PRATENDER'];
			$user['data']['no_pr'] = $pri[0]['PPI_PRNO'];
			$user['data']['evaluator'] = $emp[0]['FULLNAME'];

			$klplpr = $ptm[0]['KEL_PLANT_PRO'];
			$smpl = $ptm[0]['SAMPUL'];
			$jst = $ptm[0]['JUSTIFICATION'];
			$new_status = $ptm[0]['PTM_STATUS']+1;
			$this->app_process->where_unique($klplpr, $smpl, $jst, $new_status);
			$app = $this->app_process->get();
			// echo "<pre>";
			// print_r($app);die;
			if($app[0]['PROCESS_MASTER_ID']=='Proc_pengaju_evatek/approval'){
				$this->process->next_process($id, 'NEXT', $LM_ID);
			}else{
				$this->process->next_process_user($id, 'NEXT', $evaluator, $LM_ID);
			}

			// $this->kirim_email($user);
		}
		else {
			$id_process = $this->back_current_process($id);
			$this->process->next_process_assignment($id, 'CURRENT', $LM_ID, $id_process);
		}
		$this->session->set_flashdata('success', 'success'); redirect('Job_list');
	}

	public function back_current_process($id){
		$this->load->model('prc_tender_main');
		$this->load->model('app_process');

		$ptm = $this->prc_tender_main->ptm($id);
		$ptm = $ptm[0];
		$where = array(
			'KEL_PLANT_PRO'=>$ptm['KEL_PLANT_PRO'],
			'TIPE_SAMPUL'=>$ptm['SAMPUL'],
			'JUSTIFICATION'=>$ptm['JUSTIFICATION'],
			'PROCESS_MASTER_ID'=>'Proc_pengaju_evatek/index',
			);
		$ap = $this->app_process->get($where);
		return $ap[0]['CURRENT_PROCESS'];
	}

	public function modal_ajax() {
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_quo_main');

		$ptm = $this->input->post('ptm');
		$ptv = $this->input->post('ptv');

		$this->prc_tender_item->join_pqi($ptv);
		$data['tit'] = $this->prc_tender_item->ptm($ptm);

		$data['pqm'] = $this->prc_tender_quo_main->ptmptv($ptm, $ptv);
		echo json_encode($data);
	}

	public function save_bidding() {
		$post = $this->input->post();
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_evaluasi_teknis');
		$this->load->model('prc_evaluasi_uraian');
		$this->load->model('prc_do_evatek');
		$this->load->model('prc_do_evatek_uraian');
		$this->load->model('prc_evaluator');
		$this->load->library('process');
		$id = $this->input->post('ptm_number');
		$next_process = $this->input->post('next_process');

		if ($next_process == '999') { //BATAL
			redirect('Proc_verify_entry/batal/' . $id .'/'.$this->input->post('process_name').'/Proc_pengaju_evatek/index');
		}
		
		if ($post['evaldio'] == 1) {
			$evaluator = $this->authorization->getEmployeeId();
		} else {
			if (empty($post['evaluator'])) {
				redirect('Proc_pengaju_evatek/index/' . $post['ptm_number']);
			}
			$evaluator = $post['evaluator'];
		}

		$ptm = $this->prc_tender_main->ptm($id);
		$iteration = $ptm[0]['PTM_COUNT_RETENDER'];

		if ($next_process == '0') {
			// $this->process->next_process($id, 'RETENDER');
			redirect('Tender_cleaner/retender/' . $id .'/'.$this->input->post('process_name'));
		}

			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),$this->input->post('process_name'),'OK',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		/* Hapus data orang evaluator dulu */
		$this->prc_evaluator->deleteByPtm($id);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Proc_pengaju_evatek/save_bidding','prc_evaluator','delete',null,array('PTM_NUMBER' => $id));
			//--END LOG DETAIL--//

		/* simpan data orang evaluator */
		$pe['PTM_NUMBER'] = $id;
		$pe['PE_COUNTER'] = 1;
		$pe['PE_ITERATION'] = $iteration;
		$pe['EMP_ID'] = $evaluator;
		$this->prc_evaluator->insert($pe);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Proc_pengaju_evatek/save_bidding','prc_evaluator','insert',$pe);
			//--END LOG DETAIL--//

		$ptp = $this->prc_tender_prep->ptm($id);
		$where['PPT_ID'] = $ptp['EVT_ID'];
		$this->prc_evaluasi_teknis->where_ptm($id);
		$ppd = $this->prc_evaluasi_teknis->get();
		$where = null;

		/* ini yang agak kampret */
		$this->prc_tender_quo_item->join_pqm();
		$pqis = $this->prc_tender_quo_item->get_fresh(array('PTM_NUMBER' => $id));
		foreach ($pqis as $pqi) {
			foreach ($ppd as $pp) {
				$det['DET_ID'] = $this->prc_do_evatek->get_id();
				$det['PQI_ID'] = $pqi['PQI_ID'];
				$det['ET_ID'] = $pp['ET_ID'];
				$this->prc_do_evatek->insert($det);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Proc_pengaju_evatek/save_bidding','prc_do_evatek','insert',$det);
					//--END LOG DETAIL--//

				$where['ET_ID'] = $det['ET_ID'];
				$where['TIT_ID'] = $pqi['TIT_ID'];
				$eus = $this->prc_evaluasi_uraian->get($where);
				$where = null;

				$deu['DET_ID'] = $det['DET_ID'];
				foreach ($eus as $eu) {
					$deu['DEU_ID'] = $this->prc_do_evatek_uraian->get_id();
					$deu['EU_ID'] = $eu['EU_ID'];
					$this->prc_do_evatek_uraian->insert($deu);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Proc_pengaju_evatek/save_bidding','prc_do_evatek_uraian','insert',$deu);
						//--END LOG DETAIL--//
				}
			}
		}
		//*/

		$comment_id = $this->comment->get_new_id();
		$dataComment = array(
			"PTC_ID" => $comment_id,
			"PTM_NUMBER" => $id,
			"PTC_COMMENT" => "'".str_replace("'", "''", $this->input->post('ptc_comment'))."'",
			"PTC_POSITION" => "'".$this->authorization->getCurrentRole()."'",
			"PTC_NAME" => "'".str_replace("'", "''", $this->authorization->getCurrentName())."'",
			"PTC_ACTIVITY" => "'Pengajuan Evaluasi Teknis'",
			// "PTC_ATTACHMENT" => '\''.$_FILES["ptc_attachment"]["name"].'\''
			);
		$this->comment->insert_comment_tender($dataComment);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Proc_pengaju_evatek/save_bidding','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		$this->process->next_process($id, 'NEXT', $LM_ID);

		//thithe tambahkan script email evaluasi teknis-01-11-2017
		$this->load->model('prc_tender_item');
		$this->load->model('prc_pr_item');
		$pti = $this->prc_tender_item->get(array('PTM_NUMBER'=>$id));
		if(count($pti)>0){
			$pri = $this->prc_pr_item->where_ppiId($pti[0]['PPI_ID']);
			$hasil = $pri[0]['PPI_PRNO'];
			$tipe = 'pr';
		} else {
			$hasil = $ptm[0]['PTM_SUBPRATENDER'];
			$tipe = 'slb';
		}
		$emp = $this->adm_employee->get(array('ID'=>$evaluator));
		$user['EMAIL'] = $emp[0]['EMAIL'];
		$user['data']['judul'] = 'Evaluasi Teknis';
		$user['data']['nama_pengadaan'] = $ptm[0]['PTM_SUBJECT_OF_WORK'];
		$user['data']['no_pengadaan'] = $ptm[0]['PTM_PRATENDER'];
		$user['data']['no_pr'] = $hasil;
		$user['data']['tipe'] = $tipe;
		$user['data']['evaluator'] = $emp[0]['FULLNAME'];
		$this->kirim_email_2($user);

		$this->session->set_flashdata('success', 'success'); redirect('Job_list');
	}

	public function kirim_email($user){	
		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->to($user['EMAIL']);				
		$this->email->cc('pengadaan.semenindonesia@gmail.com');				
		$this->email->subject("Evaluasi Teknis eProcurement ".$this->session->userdata['COMPANYNAME'].".");
		$content = $this->load->view('email/approval_atasan',$user['data'],TRUE);
		$this->email->message($content);
		$this->email->send();
	}

	public function kirim_email_2($user){
		// echo "user<pre>";
		// print_r($user);die;	
		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		// $this->email->to($user['EMAIL']);				
		$this->email->to('tithe.j@sisi.id');				
		// $this->email->cc('pengadaan.semenindonesia@gmail.com');				
		$this->email->subject("Evaluasi Teknis eProcurement ".$this->session->userdata['COMPANYNAME'].".");
		$content = $this->load->view('email/approval_atasan_2',$user['data'],TRUE);
		$this->email->message($content);
		$this->email->send();
	}



}
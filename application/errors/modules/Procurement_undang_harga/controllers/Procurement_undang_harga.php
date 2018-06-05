<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement_undang_harga extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('procurement_job');
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->load->library("file_operation");
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model('currency_model');
		$this->load->helper('url');
		$this->load->library('comment');
	}

	public function index($id) {
		$this->procurement_job->check_authorization();
		$this->load->library('form_validation');
		$this->load->library('snippet');		
		$this->load->library('process');
		$this->load->model('app_process_master');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_evaluation_template');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_quo_item');

		$ptm = $this->prc_tender_main->ptm($id);
		$data['ptm'] = $ptm[0];
		$this->prc_tender_prep->join_eval_template();
		$data['ptp'] = $this->prc_tender_prep->ptm($id);
		$data['title'] = "Undangan Vendor Memasukkan Harga";

		$data['detail_ptm_snip'] = $this->snippet->detail_ptm($id, false);
		$data['detail_item_ptm'] = $this->snippet->detail_item_ptm($id);
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);
		$data['pesan'] = $this->snippet->view_history_chat($id);
		
		if ($data['ptp']['PTP_IS_ITEMIZE'] == 1){
			$view_order='vendor_per_item';
		}else{
			$view_order='item_per_vendor';
		}
		$data['evaluasi'] = $this->snippet->evaluasi($id, true, true, false, true, true, false,false,false,$view_order);
		$data['dokumen_pr'] = $this->snippet->dokumen_pr($id);

		$tit = $this->prc_tender_item->ptm($id);
		$t = 2;
		foreach ($tit as $va) {
			$cekCT = $this->snippet->countTender($id,$va['PPI_ID']);
			if($cekCT == 1){
				$t = 1;
			}
		}
		$pet = $this->prc_evaluation_template->get(array('EVT_ID'=>$data['ptp']['EVT_ID']));
		$ptqm = $this->prc_tender_quo_main->get(array('PTM_NUMBER'=>$id));

		$counter = array();
		foreach ($ptqm as $val) {
			$ptqi = $this->prc_tender_quo_item->get(array('PQM_ID'=>$val['PQM_ID']));
			foreach ($ptqi as $vali) {
				if(intval($vali['PQI_TECH_VAL']) >= intval($pet[0]['EVT_PASSING_GRADE'])){
					$counter[$val['PQM_ID']]=$val['PQM_ID'];
				}
			}
		}
		$lanjut = false;
		$just = (int)$data['ptp']['PTP_JUSTIFICATION_ORI'];
		if ($just == 2 || $just >= 5) { //tunjuk langsung
			if($t >= 1 && count($counter) >= 1){
				$lanjut = true;
			}
		}else{
			if($t == 1 && count($counter) >= 2){
				$lanjut = true;
			}
			if($t == 2 && count($counter) >= 1){
				$lanjut = true;
			}
		}
		$data['can_continue'] = $lanjut;

		$data['should_continue'] = oraclestrtotime($data['ptp']['PTP_REG_CLOSING_DATE']) < strtotime('now');
		$data['vendor_ptm'] = $this->snippet->vendor_ptm($id, $data['should_continue']);

		// $data['is_staff'] = $this->is_staff();
		$data['is_staff'] = ($this->authorization->getEmployeeId() == $data['ptm']['PTM_ASSIGNMENT']);
		$data['next_process'] = $this->process->get_next_process($id);

		$this->layout->set_datetimepicker();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/mydatetimepicker.js');
		$this->layout->add_js('pages/undang_harga.js');
		$this->layout->add_js('plugins/numeral/languages/id.js');
		$this->layout->render('undang_harga', $data);
		
	}

	public function save_bidding() {
		// var_dump($this->input->post()); exit();
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_vendor');
		$this->load->library('process');
		$this->load->library('sap_handler');

		$next_process = $this->input->post('next_process');
		$ptm_number = $this->input->post('ptm_number');

		$cek_tanggal_harga = strtotime($this->input->post('batas_vendor_harga'));
		$dateNew = date('Y-m-d H:i:s');

		if($cek_tanggal_harga < strtotime($dateNew)){
			echo "<script language=\"javascript\">alert('Batas Tanggal Memasukkan Penawaran Harga sudah terlewati.'); url = 'index/$ptm_number';window.location.href = url;</script>";
			die();
		} 

		if ($next_process == 0) {
			redirect('Tender_cleaner/retender/' . $ptm_number.'/'.$this->input->post('process_name'));
			return;
		}

			//--LOG MAIN--//
		$action = 'OK';
		if($next_process==5){
			$action = 'RE-EVALUASI';
		}
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),$this->input->post('process_name'),$action,$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		if ($next_process == '5') { // re evaluasi
			$this->load->model('prc_evaluator');
			$this->load->model('prc_process_holder');
			$pe = $this->prc_evaluator->get_desc(array('PTM_NUMBER'=>$ptm_number));
			
			$h['EMP_ID']=$pe[0]['EMP_ID'];
			$this->prc_process_holder->update($h, array('PTM_NUMBER'=>$ptm_number));
				//--LOG DETAIL--//
			$hh = array_merge($h,array('PTM_NUMBER'=>$ptm_number));
			$this->log_data->detail($LM_ID,'Procurement_undang_harga/save_bidding','prc_process_holder','update',$hh,array('PTM_NUMBER'=>$ptm_number));
				//--END LOG DETAIL--//

			$t['PTM_STATUS']=11;

			$this->prc_tender_main->updateByPtm($ptm_number, $t);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_undang_harga/save_bidding','prc_tender_main','update',$t,array('PTM_NUMBER'=>$ptm_number));
				//--END LOG DETAIL--//

			$this->session->set_flashdata('success', 'success'); 
			redirect('Job_list');
		}

		$lanjut = $this->input->post('lanjut');
		if($lanjut!=false){
			$lanjut = (array) $this->input->post('lanjut');
		}else{
			$this->session->set_flashdata('error', 'Undang Harga gagal. Harus pilih vendor dahulu!'); 
			redirect('Job_list');
		}
			
		$ptv_status_eval = array();
		$batas_tanggal_harga=$this->input->post('batas_vendor_harga');
		if(!empty($batas_tanggal_harga)){
			$batas_tanggal_harga = strtotime($this->input->post('batas_vendor_harga'));
			$batas = oracledate($batas_tanggal_harga);
			$this->prc_tender_main->updateByPtm($ptm_number, array('BATAS_VENDOR_HARGA' => $batas));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_undang_harga/save_bidding','prc_tender_main','update',array('BATAS_VENDOR_HARGA' => $batas),array('PTM_NUMBER'=>$ptm_number));
				//--END LOG DETAIL--//
		}else{
			$this->session->set_flashdata('error', 'Undang Harga gagal. Harus pilih Tanggal Batas Harga Vendor!'); 
			redirect('Job_list');
		}			
		
		// ambil semua pqm, trus update semua ptqi dengan pqm tersebut dapat undangannya jadi null
		foreach ($this->prc_tender_quo_main->ptm($ptm_number) as $key => $value) {
			$this->prc_tender_quo_item->update(array('DAPAT_UNDANGAN' => null), array('PQM_ID' => $value['PQM_ID']));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_undang_harga/save_bidding','prc_tender_quo_item','update',array('DAPAT_UNDANGAN' => null),array('PQM_ID'=>$value['PQM_ID']));
				//--END LOG DETAIL--//
		}
		
		foreach ($lanjut as $tit_id => $val) {
			foreach ($val as $pqi_id => $ptv_code) {
				$ptv_status_eval[] = $ptv_code;		
				if(isset($lanjut[$ptv_code])){
					$this->prc_tender_quo_item->update(array('DAPAT_UNDANGAN' => 1), array('PQM_ID' => $pqi_id));
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Procurement_undang_harga/save_bidding','prc_tender_quo_item','update',array('DAPAT_UNDANGAN' => 1),array('PQM_ID'=>$pqi_id));
						//--END LOG DETAIL--//
				}else{
					$this->prc_tender_quo_item->update(array('DAPAT_UNDANGAN' => 1), array('PQI_ID' => $pqi_id));
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Procurement_undang_harga/save_bidding','prc_tender_quo_item','update',array('DAPAT_UNDANGAN' => 1),array('PQI_ID'=>$pqi_id));
						//--END LOG DETAIL--//
				}	
				
			}
		}		
		
		$next_id = $this->get_next_holder();

		$whereptv = array('PTM_NUMBER' => $ptm_number);
		$this->prc_tender_vendor->update(array('PTV_STATUS_EVAL' => null), $whereptv);	
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Procurement_undang_harga/save_bidding','prc_tender_vendor','update',array('DAPAT_UNDANGAN' => 1),array('PQI_ID'=>$pqi_id));
			//--END LOG DETAIL--//	
		$is_rfc_error = false;
		$hasil_rfc = array();
		foreach (array_unique($ptv_status_eval) as $val) {
			$whereptv['PTV_VENDOR_CODE'] = $val;
			$this->prc_tender_vendor->update(array('PTV_STATUS_EVAL' => 1), $whereptv);
			
			if($next_id==0){
				$ptv=$this->prc_tender_vendor->ptm_ptv($ptm_number,$whereptv['PTV_VENDOR_CODE']);
				$vendor=$ptv[0];
				$ptm = $this->prc_tender_main->ptm($ptm_number);
				$ptm = $ptm[0];

				$rfq=$vendor['PTV_RFQ_NO'];
				$quodeadline=date('Ymd', $batas_tanggal_harga);

				/*update ke SAP*/
				$datasap = $this->sap_handler->updateRfqQuodeadline($rfq,$quodeadline);
				
				if ($datasap != null) {
					foreach ($datasap['FT_RETURN'] as $ft) {
						$hasil_rfc[] = $ft;
						if ($ft['TYPE'] == 'E') {
							$is_rfc_error = true;
						}
					}
				}
				$this->session->set_flashdata('rfc_ft_return', $hasil_rfc);
				if ($is_rfc_error) {
					redirect('Job_list');
				}
				$dataemail=array(
					'norfq'=>$vendor['PTV_RFQ_NO'],
					'noptm'=>$ptm['PTM_PRATENDER'],				
					'batasdate'=>date('d M Y g.i.s A', $batas_tanggal_harga),
					);
				$vendor=array_merge($vendor,array('data'=>$dataemail));				
				// var_dump($vendor);die;
				$this->kirim_email_undangan($vendor);
			}
			
		}

		$comment_id = $this->comment->get_new_id(); 
		$dataComment = array(
				"PTC_ID"       => $comment_id,
				"PTM_NUMBER"   => $ptm_number,
				"PTC_COMMENT"  => '\''.$this->input->post('ptc_comment').'\'',
				"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
				"PTC_NAME"     => '\''.$this->authorization->getCurrentName().'\'',
				"PTC_ACTIVITY" => "'Undangan Vendor Memasukkan Harga'",
			);
		$this->comment->insert_comment_tender($dataComment);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Procurement_undang_harga/save_bidding','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		if ($next_id != 0) {
			// $this->process->next_process_user($ptm_number, 'NEXT', $next_id, $LM_ID);
			$this->process->next_process($ptm_number, 'NEXT', $next_id, $LM_ID);
		} 
		else {
			$this->prc_tender_main->updateByPtm($ptm_number, array('IS_VENDOR_CLOSED' => 2));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_undang_harga/save_bidding','prc_tender_main','update',array('IS_VENDOR_CLOSED' => 2),array('PTM_NUMBER' => $ptm_number));
				//--END LOG DETAIL--//
			// buka penawaran
			$this->process->next_process_assignment($ptm_number, 'NEXT', $LM_ID);
		}

		$this->session->set_flashdata('success', 'success'); 
		redirect('Job_list');
	}

	public function get_next_holder() {
		$this->load->model('adm_employee');
		$this->load->model('adm_employee_atasan');

		$emp = $this->adm_employee->get(array('ID' => $this->authorization->getEmployeeId()));
		$nopeg = $emp[0]['NO_PEG'];

		$atasan = $this->adm_employee_atasan->get(array('MK_NOPEG' => $nopeg));
		$level = $atasan[0]['ATASAN1_LEVEL'];

		$is_kadep = ($level == 'DEPT');

		if ($is_kadep) {
			return 0;
		} else {
			// echo 'bukan kadep';
			$ans = $this->adm_employee->atasan($this->authorization->getEmployeeId());
			return $ans[0]['ID'];
		}
	}

	public function is_staff(){
		$this->load->model('adm_employee');
		$this->load->model('adm_employee_atasan');

		$emp = $this->adm_employee->get(array('ID' => $this->authorization->getEmployeeId()));
		$nopeg = $emp[0]['NO_PEG'];

		$atasan = $this->adm_employee_atasan->get(array('MK_NOPEG' => $nopeg));
		$level = $atasan[0]['ATASAN1_LEVEL'];

		$is_staff = ($level == 'SECT');
		return $is_staff;
	}

	public function kirim_email_undangan($vendor){	
		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->to($vendor['EMAIL_ADDRESS']);
		$this->email->cc('pengadaan.semenindonesia@gmail.com');				
		$this->email->subject("Undangan Memasukkan Harga dari eProcurement ".$this->session->userdata['COMPANYNAME'].".");
		$content = $this->load->view('email/undangan_harga',$vendor['data'],TRUE);
		$this->email->message($content);
		$this->email->send();
	}

}
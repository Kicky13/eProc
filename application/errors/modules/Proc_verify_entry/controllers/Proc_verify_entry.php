<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proc_verify_entry extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('procurement_job');
		$this->load->library('form_validation');
		$this->load->library("file_operation");
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper(array('url', 'eproc_array_helper'));
		$this->load->library('comment');
	}

	public function index($id) {
		$this->procurement_job->check_authorization();
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_vendor');
		$this->load->model('app_process_master');
		$this->load->library('snippet');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_quo_item');

		$data['title'] = 'Verifikasi Penawaran Vendor';

		$data['detail_ptm_snip'] = $this->snippet->detail_ptm($id, false);
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);
		$data['dokumen_pr'] = $this->snippet->dokumen_pr($id);

		$data['ptm_number'] = $id;
		$data['vendors'] = $this->prc_tender_vendor->get_join(array('PTM_NUMBER' => $id));
		
		$ptm = $this->prc_tender_main->ptm($id);
		// $ptm = $this->prc_tender_main->ptm($id);
		// die(var_dump($ptm));
		$ptm = $ptm[0];
		$this->load->library('process');
		$data['ptp'] = $this->prc_tender_prep->ptm($id);
		$data['next_process'] = $this->process->get_next_process($id);
		
		$data['tit'] = $this->prc_tender_item->ptm($id);
		$ptp = $this->prc_tender_prep->ptm($id);
		$counter = 0;
		foreach ($data['vendors'] as $val) {
			if ($val['PTV_STATUS'] != null && intval($val['PTV_STATUS']) >= 2) {
				$counter++;
			}
		}
		$t = 2;
		foreach ($data['tit'] as $va) {
			$cekCT = $this->snippet->countTender($id,$va['PPI_ID']);
			if($cekCT == 1){
				$t = 1;
			}
		}

		$lanjut = false;
		$just = (int)$ptp['PTP_JUSTIFICATION_ORI'];
		if ($just == 2 || $just >= 5) { //tunjuk langsung
			if($t >= 1 && $counter >= 1){
				$lanjut = true;
			}
		}else{
			if($t == 1 && $counter >= 2){
				$lanjut = true;
			}
			if($t == 2 && $counter >= 1){
				$lanjut = true;
			}
		}
		$data['should_continue'] = oraclestrtotime($data['ptp']['PTP_REG_CLOSING_DATE']) < strtotime('now');
		// $data['can_continue'] = ($counter >= $batas) || (intval($ptm['PTM_COUNT_RETENDER']) > 0);
		$data['can_continue'] = $lanjut;

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
		//===========================================================

		$this->layout->add_js('pages/verify_entry.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('detail_verify_entry',$data);
	}

	public function harga($id) {
		$this->procurement_job->check_authorization();
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_prep');
		$this->load->model('app_process_master');
		$this->load->library('snippet');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_quo_item');

		$data['title'] = 'Verifikasi Penawaran Vendor';

		$data['detail_ptm_snip'] = $this->snippet->detail_ptm($id, false);
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);
		$data['dokumen_pr'] = $this->snippet->dokumen_pr($id);

		$data['ptm_number'] = $id;
		$this->prc_tender_vendor->where_in('PTV_STATUS_EVAL', array(1, 2));
		$data['vendors'] = $this->prc_tender_vendor->get_join(array('PTM_NUMBER' => $id));
		// var_dump($data);
		$ptm = $this->prc_tender_main->prc_tender_main->ptm($id);
		$ptm = $ptm[0];
		$data['ptm'] = $ptm;
		$this->load->library('process');
		$data['ptp'] = $this->prc_tender_prep->ptm($id);
		$data['next_process'] = $this->process->get_next_process($id);

		$ptp = $this->prc_tender_prep->ptm($id);
		$just = (int)$ptp['PTP_JUSTIFICATION_ORI'];
		$batas = 2;
		if ($just == 2 || $just >= 5) {
			$batas = 1;
		}
		$counter = 0;
		foreach ((array) $data['vendors'] as $val) {
			if ($val['PTV_STATUS_EVAL'] != null && intval($val['PTV_STATUS_EVAL']) >= 2) {
				$counter++;
			}
		}
		$data['should_continue'] = oraclestrtotime($data['ptm']['BATAS_VENDOR_HARGA']) < strtotime('now');
		// $data['can_continue'] = ($counter >= $batas) || (intval($ptm['PTM_COUNT_RETENDER']) > 0);

		//===========================================================
		
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

		$data['evaluasi'] = $this->snippet->evaluasi($id, false);
			$this->prc_tender_prep->join_eval_template();
		$data['ptp_r'] = $this->prc_tender_prep->ptm($id);
		$data['tit'] = $this->prc_tender_item->ptm($id);
		//$this->prc_tender_vendor->where_active();
		$data['ptv'] = $this->prc_tender_vendor->ptm($id);
		$data['vendor_galulus'] = array();

		$ptv = array();
		foreach ($data['ptv'] as $key => $vnd) {
			$ptv[$vnd['PTV_VENDOR_CODE']] = $vnd;
		}
		$data['ptv'] = $ptv;

		$vendorss = $ptv;
		$data['evaluasi_harga'] = false; 
		if($ptp['PTP_IS_ITEMIZE'] != null && $ptp['PTP_EVALUATION_METHOD'] == '1 Tahap 1 Sampul' && $ptm['MASTER_ID'] >= 6 && !preg_match('/11|12/', $ptm['MASTER_ID']) && $process == 1){
			$data['evaluasi_harga'] = true;
		}
		if($ptp['PTP_IS_ITEMIZE'] != null && $ptp['PTP_EVALUATION_METHOD'] == '2 Tahap 1 Sampul' &&  $ptm['MASTER_ID'] >= 13){
			$data['evaluasi_harga'] = true;
		}
		if($ptp['PTP_IS_ITEMIZE'] != null && $ptp['PTP_EVALUATION_METHOD'] == '2 Tahap 2 Sampul' &&  $ptm['MASTER_ID'] >= 12 && $bts_vnd_hrga == 1){
			$data['evaluasi_harga'] = true;
			$vendorss = $data['vendors'];
		}

		/* Ngambil PQI */
		foreach ($vendorss as $vnd) {
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
					$pqi['PTV_STATUS_EVAL']=$vnd['PTV_STATUS_EVAL'];
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
		//===========================================================

		$this->layout->add_js('pages/verify_entry.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('detail_verify_entry_harga',$data);
	}

	private function sort_eval($a, $b) {
		return ($a['LULUS_TECH'] < $b['LULUS_TECH']);
	}

	public function approval($ptm, $ptv, $approve) {
		$this->load->model('prc_tender_vendor');
		$where = array('PTM_NUMBER' => $ptm, 'PTV_VENDOR_CODE' => $ptv);
		$set = array('PTV_STATUS' => $approve);
		$this->prc_tender_vendor->update($set, $where);

		redirect('Proc_verify_entry/index/'.$ptm);
	}

	public function save_rfq($ptm, $ptv) {
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->library('sap_handler');
		$vendor = $this->prc_tender_vendor->ptm_ptv($ptm, $ptv);
		$pqm = $this->prc_tender_quo_main->ptmptv($ptm, $ptv);
		$ptp = $this->prc_tender_prep->ptm($ptm);
		$main = $this->prc_tender_main->ptm($ptm);
		$main = $main[0];
		// $this->prc_tender_quo_item->join_item();
		$is_jasa = $main['IS_JASA'] == 1;
		$ptqi = $this->prc_tender_quo_item->get_by_pqm($pqm[0]['PQM_ID'], $is_jasa);
		// var_dump($ptqi);die;

		$rfq = $vendor[0]['PTV_RFQ_NO'];
		$validto = date('Ymd', oraclestrtotime($pqm[0]['PQM_VALID_THRU']));
		$quodate = date('Ymd', oraclestrtotime($ptp['PTP_REG_OPENING_DATE']));
		$incoterm = $ptp['PTP_TERM_DELIVERY'];
		$incoterm_text = $ptp['PTP_DELIVERY_NOTE'].'' == '' ? '-' : $ptp['PTP_DELIVERY_NOTE'];

		$item['delivery_date'] = date('Ymd', oraclestrtotime($ptp['PTP_DELIVERY_DATE']));
		$item['price_type'] = $main['PTM_RFQ_TYPE'];
		$item['valid_to'] = $validto;
		foreach ($ptqi as $val) {
			$item['net_price'] = $val['PQI_PRICE'];
			if ($is_jasa) {
				// $item['srv_line_no'] = $val['PPI_PRITEM'];
				$item['srv_line_no'] = 10; // jika jasa maka service line di set statis 10. 
			}
			$item['item_no'] = $val['TIT_EBELP'];
			$items[] = $item;
		}
		
		if (empty($items)) return false;

		$price_type = 'ZGPN';
		// var_dump(compact('rfq', 'validto', 'quodate', 'items', 'incoterm', 'incoterm_text', 'price_type'));die;

		$return = $this->sap_handler->saveRfqMaintain($rfq, $validto, $quodate, $items, $incoterm, $incoterm_text, $price_type);
		
		// echo "<pre>";
		// var_dump($return); 
		// echo "</pre>";	
		// exit();

		return $return;
	}

	public function batal($id, $proses, $kembali, $index){
		$this->load->library('snippet');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_quo_item');

		$data['title'] = 'Pembatalan Tender';
		$data['ptm'] = $id;
		$this->prc_tender_item->join_pr();
		$data['tit'] = $this->prc_tender_item->get(array('PTM_NUMBER'=>$id,'TIT_STATUS <>'=>999));
		$data['detailptm'] = $this->snippet->detail_ptm($id, false, true);
		$data['proses'] = $proses;
		$data['kembali'] = $kembali;
		$data['index'] = $index;

		$this->layout->render('batal', $data);
	}

	public function saveBatal(){
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_item');

		$noptm = $this->input->post("ptm");
		$tit_id = $this->input->post("item");
		$prss = $this->input->post("proses");
		$proses = str_replace("%20", " ", $prss);
		
		if (!isset($tit_id) || empty($tit_id)) { //redirect lg ke batal
			$this->session->set_flashdata('error', 'Pilih Item yang akan dibatalkan.');
			redirect('Proc_verify_entry/batal/'.$noptm.'/'.$proses.'/'.$this->input->post('kembali').'/'.$this->input->post('index'));
		}

			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),$proses,'Pembatalan Tender',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		foreach ($tit_id as $val) {
			$this->prc_tender_item->update(array('TIT_STATUS'=>999),array('PRC_TENDER_ITEM.TIT_ID'=>$val)); //set status item jadi (999)'dibatalkan'
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Proc_verify_entry/saveBatal','prc_tender_item','update',array('TIT_STATUS'=>999),array('PRC_TENDER_ITEM.TIT_ID'=>$val, 'PTM_NUMBER'=>$noptm));
				//--END LOG DETAIL--//
		}

		$pti = $this->prc_tender_item->get(array('PRC_TENDER_ITEM.PTM_NUMBER'=>$noptm,'TIT_STATUS <>'=>999)); 
		if(count($pti)==0){
			$this->prc_tender_main->updateByPtm($noptm,array('PTM_STATUS'=>-999)); //set status ptm jadi (-999)'dibatalkan'
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Proc_verify_entry/saveBatal','prc_tender_main','update',array('PTM_STATUS'=>-999),array('PTM_NUMBER'=>$noptm));
				//--END LOG DETAIL--//
		}
		
		$comment_id = $this->comment->get_new_id(); 
		$dataComment = array(
			"PTC_ID" => $comment_id,
			"PTM_NUMBER" => $noptm,
			"PTC_COMMENT" => "'".str_replace("'", "''", $this->input->post('ptc_comment'))."'",
			"PTC_POSITION" => "'".$this->authorization->getCurrentRole()."'",
			"PTC_NAME" => "'".str_replace("'", "''", $this->authorization->getCurrentName())."'",
			"PTC_ACTIVITY" => "'".$proses."'",
		);
		$this->comment->insert_comment_tender($dataComment);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Proc_verify_entry/saveBatal','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		$this->session->set_flashdata('tambahaninfo', ' Tender Berhasil dibatalkan');
		$this->session->set_flashdata('success', 'success'); 
		redirect('Job_list');

	}

	public function save_bidding() {
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('adm_employee_puch_grp');
		$this->load->library('process');
		$this->load->library('penilaian_otomatis');

		$id = $this->input->post('ptm_number');
		$next_process = $this->input->post('next_process');
		if ($next_process == '0') { //RETENDER
			redirect('Tender_cleaner/retender/' . $id .'/'.$this->input->post('process_name'));
		}
		if ($next_process == '999') { //BATAL
			redirect('Proc_verify_entry/batal/' . $id .'/'.$this->input->post('process_name').'/Proc_verify_entry/index');
		}
		
		$vndSesuai = 0;
		if($this->input->post('check')){
			$vndSesuai = count($this->input->post('check'));
		}

		$t = 2;
		foreach ($this->input->post('countTender') as $va) {
			if($va == 1){
				$t = 1;
			}
			$itmT = $va;
		}
		$lanjut = false;
		$just = $this->input->post('ptp_justification');
		if ($just == 2 || $just >= 5) { //tunjuk langsung
			if($t >= 1 && $vndSesuai >= 1){
				$lanjut = true;
			}else{
				$vndPilih = 1;
			}
		}else{
			if($t == 1 && $vndSesuai >= 2){
				$lanjut = true;
			}
			if($t == 2 && $vndSesuai >= 1){
				$lanjut = true;
			}

			if($t == 1 && $vndSesuai < 2){
				$itmT = 1;
				$vndPilih = 2;
			}
			if($t == 2 && $vndSesuai < 1){
				$vndPilih = 1;
			}
		}

		if(!$lanjut){
			$this->session->set_flashdata('warning', 'Ada Item yang Tender ke-'.$itmT .', Jumlah vendor memasukkan penawaran dan lolos verifikasi minimal '.$vndPilih);
			redirect('Proc_verify_entry/index/' . $id);
		}

		// foreach ($this->prc_tender_vendor->ptm($id) as $vnd) {
		// 	$return_rfq = $this->save_rfq($id, $vnd['PTV_VENDOR_CODE']);
		// 	$this->session->set_flashdata('data', $return_rfq);
		// }die('stop');

			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),$this->input->post('process_name'),'OK',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		$this->prc_tender_main->updateByPtm($id, array('IS_VENDOR_CLOSED' => 1));
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Proc_verify_entry/save_bidding','prc_tender_main','update',array('IS_VENDOR_CLOSED' => 1),array('PTM_NUMBER'=>$id));
			//--END LOG DETAIL--//

		$ptm = $this->prc_tender_main->ptm($id);
		$ptm = $ptm[0];

		$ptp = $this->prc_tender_prep->ptm($id);
		//$ptp = $ptp[0];
		if($ptp['PTP_JUSTIFICATION_ORI']==5){//untuk RO
			$this->prc_tender_main->updateByPtm($id, array('IS_EVALUATED' => 1));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Proc_verify_entry/save_bidding','prc_tender_main','update',array('IS_EVALUATED' => 1),array('PTM_NUMBER'=>$id));
				//--END LOG DETAIL--//
			$pqm = $this->prc_tender_quo_main->ptm($id);
			$ptqi = $this->prc_tender_quo_item->get_by_pqm($pqm[0]['PQM_ID']);
			foreach ($ptqi as $v) {
				$set = array('PQI_IS_WINNER' => 1);
				$where = array('PQI_ID' => $v['PQI_ID']);
				$this->prc_tender_quo_item->update($set, $where);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Proc_verify_entry/save_bidding','prc_tender_quo_item','update',$set,$where);
					//--END LOG DETAIL--//
			}
		}

		$vendors = $this->prc_tender_vendor->ptm($id);
		foreach ($vendors as $vnd) {
			$vendor['PTV_VENDOR_CODE'] = $vnd['PTV_VENDOR_CODE'];
			$vendor['PTM_NUMBER'] = $id;
			if ($vnd['PTV_STATUS'] != 2) {
				// $set['PTV_STATUS'] = -1;
				// $this->prc_tender_vendor->update($set, $vendor);
			} else {
				if (!in_array($vendor['PTV_VENDOR_CODE'], $this->input->post('check'))) {
					$where['PTM_NUMBER'] = $id;
					$where['PTV_VENDOR_CODE'] = $vnd['PTV_VENDOR_CODE'];
					$set['PTV_STATUS'] = -1;
					$this->prc_tender_vendor->update($set, $vendor);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Proc_verify_entry/save_bidding','prc_tender_vendor','update',$set,$vendor);
						//--END LOG DETAIL--//
					$set['PQM_STOP_STATUS'] = 1;
					unset($set['PTV_STATUS']);
					$this->prc_tender_quo_main->update($set, $vendor);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Proc_verify_entry/save_bidding','prc_tender_quo_main','update',$set,$vendor);
						//--END LOG DETAIL--//
					unset($set['PQM_STOP_STATUS']);
				} else {
					$return_rfq = $this->save_rfq($id, $vnd['PTV_VENDOR_CODE']);
					$this->session->set_flashdata('data', $return_rfq);
				}
			}
		}
		// exit();

		$comment_id = $this->comment->get_new_id(); 
		// $this->file_operation->upload(UPLOAD_PATH.'comment_attachment/'.$id."_".$comment_id, $_FILES);
		$dataComment = array(
			"PTC_ID" => $comment_id,
			"PTM_NUMBER" => $id,
			"PTC_COMMENT" => "'".str_replace("'", "''", $this->input->post('ptc_comment'))."'",
			"PTC_POSITION" => "'".$this->authorization->getCurrentRole()."'",
			"PTC_NAME" => "'".str_replace("'", "''", $this->authorization->getCurrentName())."'",
			"PTC_ACTIVITY" => "'Verifikasi Penawaran Harga'",
			// "PTC_ATTACHMENT" => '\''.$_FILES["ptc_attachment"]["name"].'\''
			);

		$this->comment->insert_comment_tender($dataComment);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Proc_verify_entry/save_bidding','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		$this->penilaian_otomatis->insert('proc_verify_entry', $vendors, $ptm['PTM_PRATENDER'], null, $LM_ID);
		//die('stop');
	
		$pgrp = $ptm['PTM_PGRP'];
		$this->adm_employee_puch_grp->pgrp($pgrp);
		$this->process->next_process_assignment($id, 'NEXT', $LM_ID);

		$this->session->set_flashdata('success', 'success'); redirect('Job_list');
	}

	public function save_harga() {
		$this->load->library('process');
		$this->load->model('adm_employee_puch_grp');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_vendor');

		$id = $this->input->post('ptm_number');

		$this->prc_tender_main->updateByPtm($id, array('IS_VENDOR_CLOSED' => 1));

		$ptm = $this->prc_tender_main->ptm($id);
		$ptm = $ptm[0];

		$vendors = $this->prc_tender_vendor->ptm($id);
		foreach ($vendors as $vnd) {

		}
		// exit();

		$next_process = $this->input->post('next_process');
		
		if ($next_process == '0') {
			// $this->process->next_process($id, 'RETENDER');
			redirect('Tender_cleaner/retender/' . $id.'/Verifikasi Penawaran Harga');
		}

			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Verifikasi Penawaran Harga','OK',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		$comment_id = $this->comment->get_new_id();
		$dataComment = array(
			"PTC_ID" => $comment_id,
			"PTM_NUMBER" => $id,
			"PTC_COMMENT" => '\''.$this->input->post('ptc_comment').'\'',
			"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
			"PTC_NAME" => '\''.$this->authorization->getCurrentName().'\'',
			"PTC_ACTIVITY" => "'Verifikasi Penawaran Harga Vendor'",
			);
		$this->comment->insert_comment_tender($dataComment);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Proc_verify_entry/save_harga','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		$pgrp = $ptm['PTM_PGRP'];
		$this->adm_employee_puch_grp->pgrp($pgrp);
		$this->process->next_process_assignment($id, 'NEXT', $LM_ID);
		
		$this->session->set_flashdata('success', 'success'); 
		redirect('Job_list');
	}

}
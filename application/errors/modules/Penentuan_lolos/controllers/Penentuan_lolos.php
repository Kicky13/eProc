<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Penentuan_lolos extends CI_Controller {

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

	public function index($id) {
		$this->procurement_job->check_authorization();
		$this->load->library('snippet');
		$this->load->model('adm_dept');
		$this->load->model('app_process_master');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_quo_main');

		$data['title'] = 'Penentuan Lolos Evaluasi';
		$data['ptm_number'] = $id;

		$data['detail_ptm'] = $this->snippet->detail_ptm($id);
		$data['vendor_ptm'] = $this->snippet->vendor_ptm($id, true, true);
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);
		$data['pesan'] = $this->snippet->view_history_chat($id);
		$data['ptp'] = $this->prc_tender_prep->ptm($id);

		if ($data['ptp']['PTP_IS_ITEMIZE'] == 1){
			$view_order='vendor_per_item';
		}else{
			$view_order='item_per_vendor';
		}
		/*
		$id,
			$input = true,
			$show_harga = true,
			$where_winner = false,
			$evatek_aja = false,
			$populate = false,
			$show_nego = false,
			$table_only = false,
			$view_order = 'vendor_per_item'
		*/
		$data['evaluasi'] = $this->snippet->evaluasi($id, true, true, false, false, false, false,false,false,$view_order);


		/* VIEW HARGA */

		$ptm = $this->prc_tender_main->ptm($id);
		$ptp= $this->prc_tender_prep->ptm($id);
		$ptm = $ptm[0];

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

		// die(var_dump($data['ptv']));

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

		/* END VIEW HARGA */ 

		$this->layout->add_js('pages/penentuan_lolos.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();			
		$this->layout->render('penentuan_lolos', $data);
	}

	public function save_bidding() {
		$post = $this->input->post();
		$id = $this->input->post('ptm_number');
		// var_dump($post); exit();
		$next_process = $this->input->post('next_process');

		if ($next_process == 0) { //RETENDER
			redirect('Tender_cleaner/retender/' . $id .'/Penentuan Lolos Evaluasi');
		}

		if ($next_process == '999') { //BATAL
			redirect('Proc_verify_entry/batal/' . $id .'/Penentuan Lolos Evaluasi/Penentuan_lolos/index');
		}

		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_vendor');
		$this->load->library('process');

		if(!$this->input->post('lanjut') && $next_process=1){
			$this->session->set_flashdata('error', 'Tidak Bisa Dilakukan Metode Nego, karena nilai harga belum di isi. Hanya bisa dilakukan Retender.');
			redirect('Penentuan_lolos/index/' . $id);
		}
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Penentuan Lolos Evaluasi','OK',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		foreach ($this->input->post('lanjut') as $key => $value) {
			foreach ($value as $pqi_id => $nouse) {
				$set = array('PQI_IS_WINNER' => 1);
				$where = array('PQI_ID' => $pqi_id);
				$this->prc_tender_quo_item->update($set, $where);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Penentuan_lolos/save_bidding','prc_tender_quo_item','update',$set,$where);
					//--END LOG DETAIL--//
			}
		}

		// foreach ($this->input->post('item') as $key => $value) {
		// 	$set = array('TIT_STATUS' => $value);
		// 	$where = array('TIT_ID' => $key);
		// 	$this->prc_tender_item->update($set, $where);
		// }

		$this->prc_tender_main->updateByPtm($id, array('IS_EVALUATED' => 1));
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Penentuan_lolos/save_bidding','prc_tender_main','update',array('IS_EVALUATED' => 1),array('PTM_NUMBER' => $id));
			//--END LOG DETAIL--//

		$comment_id = $this->comment->get_new_id(); 
		$dataComment = array(
			"PTC_ID" => $comment_id,
			"PTM_NUMBER" => $id,
			"PTC_COMMENT" => "'".str_replace("'", "''", $this->input->post('ptc_comment'))."'",
			"PTC_POSITION" => "'".$this->authorization->getCurrentRole()."'",
			"PTC_NAME" => "'".str_replace("'", "''", $this->authorization->getCurrentName())."'",
			"PTC_ACTIVITY" => "'Penentuan Lolos'",
			);
		$this->comment->insert_comment_tender($dataComment);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Penentuan_lolos/save_bidding','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//


		$ptm = $this->prc_tender_main->ptm($id);
			
		$this->process->next_process_assignment($id, 'NEXT', $LM_ID);

		$this->session->set_flashdata('success', 'success'); redirect('Job_list');
	}

	private function sort_eval($a, $b) {
		return ($a['LULUS_TECH'] < $b['LULUS_TECH']);
	}

}
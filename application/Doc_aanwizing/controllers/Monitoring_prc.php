<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_prc extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model('m_global');
	}

	public function index($cheat = false) {
		$data['title'] = "Monitoring Procurement";
		$data['cheat'] = $cheat;
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_validate_css();
		$this->layout->set_validate_js();
		$this->layout->add_js('pages/monitor_prc.js');		
		$this->layout->add_js("strTodatetime.js");
		$this->layout->render('list_pr', $data);
	}

	public function detail($id){
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_prep');
		$this->load->model('app_process_master');
		$this->load->library('snippet');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_quo_item');
		// $kd_user = $this->session->userdata('GRPAKSES');

		$data['title'] = 'Monitoring Pengadaan';

		$data['detail_ptm_snip'] = $this->snippet->detail_ptm($id, false);
		$data['retender_item'] = $this->snippet->retender_item($id);
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);
		$data['dokumen_pr'] = $this->snippet->dokumen_pr($id);
		$data['pesan'] = $this->snippet->view_history_chat($id);

		$data['ptm_number'] = $id;
		$data['vendors'] = $this->prc_tender_vendor->get_join(array('PTM_NUMBER' => $id));

		$this->prc_tender_main->join_prep();
		$ptm = $this->prc_tender_main->prc_tender_main->ptm($id);
		$ptm = $ptm[0];
		$data['ptm'] = $ptm; 

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

		$just = (int)$ptp['PTP_JUSTIFICATION_ORI'];
		$batas = 2;
		if ($just == 2 || $just >= 5) {
			$batas = 1;
		}
		$counter = 0;
		if(is_array($data['vendors'])){
			foreach ($data['vendors'] as $val) {
				if ($val['PTV_STATUS'] != null && intval($val['PTV_STATUS']) >= 2) {
					$counter++;
				}
			}
		}
		$data['should_continue'] = oraclestrtotime($ptp['PTP_REG_CLOSING_DATE']) < strtotime('now');
		$data['can_continue'] = ($counter >= $batas) || (intval($ptm['PTM_COUNT_RETENDER']) > 0);

		//===========================================================	
		$EvatekHarga = true;
		$dataEvaluasiPaket = $this->snippet->evaluasi($id, false,true,false,false,false,false,false,false,'item_per_vendor');
		if(preg_match('/9|10|11|12/', $ptm['MASTER_ID'])){
			$EvatekHarga = false;
			$dataEvaluasiPaket = $this->snippet->evaluasi($id, false,false);
		}
		if($ptp['PTP_IS_ITEMIZE']==1){
			$data['evaluasi'] = $this->snippet->evaluasi($id, false,$EvatekHarga,false,false,false,false,false,false,'vendor_per_item');
		}else{
			$data['evaluasi'] = $dataEvaluasiPaket;
		}
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
		$data['thp2smpl2'] = false;
		if($ptp['PTP_IS_ITEMIZE'] != null && $ptp['PTP_EVALUATION_METHOD'] == '1 Tahap 1 Sampul' && $ptm['MASTER_ID'] >= 6 && $process == 1){
			$data['evaluasi_harga'] = true;
		}
		if($ptp['PTP_IS_ITEMIZE'] != null && $ptp['PTP_EVALUATION_METHOD'] == '2 Tahap 1 Sampul' &&  $ptm['MASTER_ID'] >= 13){
			$data['evaluasi_harga'] = true;
		}
		if($ptp['PTP_IS_ITEMIZE'] != null && $ptp['PTP_EVALUATION_METHOD'] == '2 Tahap 2 Sampul' &&  $ptm['MASTER_ID'] >= 12 && $bts_vnd_hrga == 1){
			$data['evaluasi_harga'] = true;
			$this->prc_tender_vendor->where_in('PTV_STATUS_EVAL', array(1, 2));
			$vendorss = $this->prc_tender_vendor->get_join(array('PTM_NUMBER' => $id));
			$data['thp2smpl2'] = true;
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

		$data['vendor_ptm'] = $this->snippet->vendor_ptm($id, $data['should_continue']);
		$this->layout->add_js('pages/monitor_prc_detail.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('detail',$data);
	}

	private function sort_eval($a, $b) {
		return ($a['LULUS_TECH'] < $b['LULUS_TECH']);
	}

	public function get_datatable() {
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_purchase_requisition_user');
		$this->load->model('adm_employee');
		$this->load->model('prc_pr_item');

		$MKCCTR = $this->session->userdata('MKCCTR');
		$pgrp = $this->session->userdata('PRGRP');
		$kd_user = $this->session->userdata('GRPAKSES');
		// var_dump($this->session->all_userdata()); die();
		// echo "<pre>";
		// print_r($request);die;
		
		$this->prc_tender_main->join_latest_activity();
		$this->prc_tender_main->join_prep();
		
		// echo "<pre>";
		// print_r($req);die;
		// $req = $this->prc_purchase_requisition_user->getRequisition($MKCCTR);
		//var_dump($req);
		if ($kd_user == 42||$kd_user == 281) {
			$this->prc_tender_main->join_prItem();
			$this->prc_tender_main->join_pr_req();
				//array_push($ppr, var)
			$this->prc_tender_main->where_req_in($MKCCTR);
		}else {
			$this->prc_tender_main->where_pgrp_in($pgrp);
		}

		// $kelprgrp = $this->session->userdata('KEL_PRGRP');
		// $this->prc_tender_main->where_kel_plant_pro($kelprgrp);
		
		$data = array();
		// $datatable = $this->prc_tender_main->get(null, false, null, true);
		$datatable = $this->prc_tender_main->get();
		// echo $this->db->last_query(); exit;
		foreach ((array)$datatable as $key => $val) {
			if($val['MASTER_ID']==15){
				$rg=array();
				$pti = $this->prc_tender_item->ptm($val['PTM_NUMBER']);
				foreach ($pti as $value) {
					$rg[]=$value['TIT_STATUS'];				
				}
				$datatable[$key]['TIT_STATUS_GROUP']=$rg;
			}
			$hitungPR = $this->prc_pr_item->get(array('PPI_PRNO' => $val['PPI_PRNO']));				
			$datatable[$key]['hitungPRA']=count($hitungPR);
			$buyer = $this->adm_employee->get(array('ID' => $val['PTM_ASSIGNMENT']));				
			$datatable[$key]['buyer']=$buyer[0]['FULLNAME'];
		}
		// foreach ($datatable as $key => $value) {
		// 	$this->prc_tender_item->join_pr();
		// 	$pti = $this->prc_tender_item->ptm($value['PTM_NUMBER']);
		// 	$rq = array();
		// 	foreach ($pti as $k => $v) {
		// 		$rq[] = $v['PPR_REQUESTIONER'];
		// 		if($v['PPR_REQUESTIONER'] == $request){
		// 			$dat[] = $value;
		// 		}
		// 		// break;
		// 	}
		// 	$datatable[$key]['REQUESTIONER'] = $rq;
		// }		
		// echo "<pre>";
		// print_r($datatable);die;
		$data = array('data' => isset($datatable)?$datatable:'');
		echo json_encode($data);
	}

	public function get_datatable_ub() {
		$this->load->model('prc_tender_main');

		$i=0;
		$no=0;

		$colom=array('PRC_TENDER_MAIN.PTM_NUMBER','PRC_TENDER_MAIN.PTM_SUBJECT_OF_WORK',
			'PRC_TENDER_MAIN.PTM_SUBPRATENDER','PRC_TENDER_MAIN.PTM_PRATENDER',
			'PRC_TENDER_MAIN.PTM_RFQ_TYPE','PRC_TENDER_MAIN.PTM_PGRP',
			'APP_PROCESS.NAMA_BARU');
		
		$sql="SELECT ".implode(', ', $colom)." FROM PRC_TENDER_MAIN
		LEFT JOIN APP_PROCESS ON PRC_TENDER_MAIN.PTM_STATUS = APP_PROCESS.CURRENT_PROCESS AND
		PRC_TENDER_MAIN.KEL_PLANT_PRO = APP_PROCESS.KEL_PLANT_PRO AND 
		PRC_TENDER_MAIN.SAMPUL = APP_PROCESS.TIPE_SAMPUL
		WHERE 1=1 ";

		$totalData = $this->prc_tender_main->total_row($sql);
		
		$totalFiltered = $totalData;

		$data1 = $this->m_global->grid_view($sql)->result_array();
		
		$data=array();
		foreach($data1 as $line){
			$data_tbl=array();
			$data_tbl['PTM_SUBJECT_OF_WORK']=$line['PTM_SUBJECT_OF_WORK']; 
			$data_tbl['PTM_SUBPRATENDER']=$line['PTM_SUBPRATENDER'];
			$data_tbl['PTM_PRATENDER']=$line['PTM_PRATENDER'];
			$data_tbl['PTM_RFQ_TYPE']=$line['PTM_RFQ_TYPE'];
			$data_tbl['PTM_PGRP']=$line['PTM_PGRP'];
			$data_tbl['NAMA_BARU']=$line['NAMA_BARU'];
			$data_tbl['PTM_NUMBER']=$line['PTM_NUMBER'];
			$data[]=$data_tbl;
			$i++;
			$no++;
		}
		$json_data = array(
			"data"            => $data   // total data array
			);

		echo json_encode($json_data);
	}

	public function viewDok($id = null){
		$url = "int-".base_url();
		$this->load->helper('file');
		$image_path = base_url(UPLOAD_PATH).'/additional_file/'.$id;

		if (strpos($url, 'semenindonesia.com') !== false) { //server production
			if(empty($id)){
				die('tidak ada attachment.');
			}
			if(file_exists(BASEPATH.'../upload/additional_file/'.$id)){				
				$this->output->set_content_type(get_mime_by_extension($image_path));
				return $this->output->set_output(file_get_contents($image_path));
			}else{
				if($this->session->userdata['VENDOR_ID'] == null){
					die('<h2>Anda Harus Login !!</h2>');
				}
				$vendor_id = url_encode($this->session->userdata['VENDOR_ID']);
				redirect($url.'View_document_procurement/viewDokAddFile/'.$id.'/'.$vendor_id);
			}

		}else{ //server development
			if(empty($id) || !file_exists(BASEPATH.'../upload/additional_file/'.$id)){
				die('tidak ada attachment.');
			}
			
			$this->output->set_content_type(get_mime_by_extension($image_path));
			return $this->output->set_output(file_get_contents($image_path));
		}
	}

	public function sttsNegosiasi($id){
		echo $id.' nya';
	}

}
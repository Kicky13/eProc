<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Konfigurasi pengadaan */
class Procurement_pengadaan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('procurement_job');
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->library('comment');
	}

	public function index() {
		var_dump($this->session->all_userdata());
		$this->view();
	}

	function get_detail($id) {
		$this->procurement_job->check_authorization();
		$this->load->model('app_process_master');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_vendor');
		$this->load->library('form_validation');
		$this->load->library('snippet');
		//$data['iderror'] = array();
		//$this->form_validation->set_rules('evt_id', 'Template evaluasi', 'required');
		$this->form_validation->set_rules('ptp_batas_penawaran', 'Batas Penawaran', 'numeric');
		$this->form_validation->set_rules('ptp_batas_nego', 'Batas Penawaran', 'numeric');
		
		//$this->form_validation->set_rules('ptp_evaluation_method', 'Batas Penawaran', 'required');
//		
//		$this->form_validation->set_rules('ptp_warning', 'Batas Penawaran', 'required');
//		$this->form_validation->set_rules('ptp_warning_nego', 'Batas Penawaran', 'required');
//		$this->form_validation->set_rules('batasatasnego', 'Batas Penawaran', 'required');
//		$this->form_validation->set_rules('ptm_rfq_type', 'Batas Penawaran', 'required');
//		$this->form_validation->set_rules('ptm_curr', 'Batas Penawaran', 'required');
//		$this->form_validation->set_rules('ptp_reg_opening_date', 'Batas Penawaran', 'required');
//		$this->form_validation->set_rules('ptp_reg_closing_date', 'Batas Penawaran', 'required');
//		$this->form_validation->set_rules('ptp_delivery_date', 'Batas Penawaran', 'required');
//		$this->form_validation->set_rules('ptp_validity_harga', 'Batas Penawaran', 'required');
		
		if($this->input->post('harus_pilih')=='reject'){
			$this->update($id);
		}

		if ($this->form_validation->run() === FALSE)
		{
			
		//	if(form_error('ptp_batas_penawaran')){
//				$data['ptp_batas_penawaran'] = 'ptp_batas_penawaran';
//			}
//			if(form_error('ptp_batas_nego')){
//				$data['ptp_batas_nego'] = 'ptp_batas_nego';
//			}
//			
//			if(form_error('ptp_evaluation_method')){
//				$data['ptp_evaluation_method'] = 'ptp_evaluation_method';
//			}
//			
//			if(form_error('ptp_warning')){
//				$data['ptp_warning'] = 'ptp_warning';
//				
//			}
//			
//			if(form_error('ptp_warning_nego')){
//				$data['ptp_warning_nego'] = 'ptp_warning_nego';
//				
//			}
//			if(form_error('batasatasnego')){
//				$data['batasatasnego'] = 'batasatasnego';	
//			}
//			if(form_error('ptm_rfq_type')){
//				$data['ptm_rfq_type'] = 'ptm_rfq_type';	
//			}
//			if(form_error('ptm_curr')){
//				$data['ptm_curr'] = 'ptm_curr';	
//			}
//			if(form_error('evt_id')){
//				$data['evt_id'] = 'evt_id';	
//			}
//			if(form_error('ptp_reg_opening_date')){
//				$data['ptp_reg_opening_date'] = 'ptp_reg_opening_date';	
//			}
//			if(form_error('ptp_reg_closing_date')){
//				$data['ptp_reg_closing_date'] = 'ptp_reg_closing_date';	
//			}
//			if(form_error('ptp_delivery_date')){
//				$data['ptp_delivery_date'] = 'ptp_delivery_date';	
//			}
//			if(form_error('ptp_reg_opening_date')){
//				$data['ptp_validity_harga'] = 'ptp_validity_harga';	
//			}
//			
//			if($this->input->post()){
//				echo json_encode($data);
//				exit();
//			}
			$this->load->model('adm_doctype_pengadaan');
			$this->load->model('prc_tender_main');
			$this->load->model('prc_tender_prep');
			$ptm = $this->prc_tender_main->ptm($id);
			$data['ptm'] = $ptm[0];
			$data['ptp'] = $this->prc_tender_prep->ptm($id);
			$data['title'] = "Konfigurasi pengadaan";
			// $this->prc_tender_item->join_pr();
			// $data['tit'] = $this->prc_tender_item->ptm($id);
			$this->load->library('process');
			$data['next_process'] = $this->process->get_next_process($id);

			$data['detail_item_ptm'] = $this->snippet->detail_item_ptm($id);
			$data['ptm_comment'] = $this->snippet->ptm_comment($id);
			$data['dokumen_pr'] = $this->snippet->dokumen_pr($id);

			$this->load->model('prc_plan_doc');
			$this->load->model('prc_pr_item');

			$ans = '';
			$dokumen = array();
			$dokumens = array();
			$privacy = null;
			$vendor = false;
			$active = true;
			$whatever = null;

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
			// var_dump($dokumen['itemdoc']);
			// die();
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
			$this->adm_doctype_pengadaan->where_pgrp($data['ptm']['PTM_PGRP']);
			$this->adm_doctype_pengadaan->where_cat('A');
			$data['rfq_type'] = $this->adm_doctype_pengadaan->get();

			$this->load->model('adm_cctr');
			$this->load->model('adm_employee');
			$this->load->model('com_jasa_group');

			$this->adm_cctr->where_kel_com($data['ptm']['KEL_PLANT_PRO']);
			$cctr = $this->adm_cctr->get();
			$data['cctr'] = array_build_key($cctr, 'CCTR');
			$this->prc_tender_prep->join_eval_template();
			$data['buyer'] = $this->adm_employee->find($data['ptm']['PTM_ASSIGNMENT']);

			$this->prc_tender_item->join_pr();
			$data['tit'] = $this->prc_tender_item->ptm($id);
			$data['group_jasa']=$this->com_jasa_group->get_jasa();

			$this->prc_tender_vendor->join_vnd_header();
			$data['vendor_tambahan'] = (array) $this->prc_tender_vendor->get(array('PTM_NUMBER' => $id, 'PTV_NON_DIRVEN' => 1));

			$this->layout->set_table_js();
			$this->layout->set_table_cs();
			$this->layout->set_datetimepicker();
			$this->layout->add_js('pages/mydatetimepicker.js');
			$this->layout->add_js('strTodatetime.js');
			$this->layout->add_js('pages/procurement_pengadaan_khususRO.js');
			$this->layout->add_js('pages/procurement_pengadaan.js');
			$this->layout->add_js('pages/numberic.js');
			$this->layout->add_js('plugins/numeral/numeral.js');
			$this->layout->add_js('plugins/numeral/languages/id.js');
			$this->layout->add_css('plugins/select2/select2.css');
			$this->layout->add_css('plugins/select2/select2-bootstrap.css');
			// thithe hilangkan tambah vendor dan centang tanggal 11 oktober 2017
			// echo $this->session->userdata['ID'];die;
			// if($this->session->userdata['ID']=="6227" || $this->session->userdata['ID']==6227){
			// } else {
			// 	$this->layout->add_css('hidden_vendor.css');
			// }
			$this->layout->add_css('hidden_vendor.css');
			
			$this->layout->add_js('plugins/select2/select2.js');
			$this->layout->render('detail_procurement_pratender', $data);
		} else {
			$this->update($id);
		}
	}

	public function update($id) {
		$submit = $this->input->post('harus_pilih');

		$ptm_number = $id;
		$this->load->library("file_operation");
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_main_log');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_add_item');
		$this->load->model('prc_evaluasi_teknis');
		$this->load->model('prc_tender_approve');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_approve_vendor');
		$this->load->model('adm_employee');
		$this->load->library('snippet');

		// insert and upload comment attachment
		$comment_id = $this->comment->get_new_id();
		$dataComment = array(
			"PTC_ID" => $comment_id,
			"PTM_NUMBER" => $ptm_number,
			"PTC_COMMENT" => '\''.$this->input->post('comment').'\'',
			"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
			"PTC_NAME" => '\''.$this->authorization->getCurrentName().'\'',
			"PTC_ACTIVITY" => '\''."Konfigurasi pengadaan".'\''
			);
		$this->comment->insert_comment_tender($dataComment);

		$action = 'REJECT';
		if ($submit == "accept") {
			$action = 'OK';
		}
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),$this->input->post('process_name'),$action,$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Procurement_pengadaan/update','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		if ($submit == "accept") {
			/* UPDATE PTP */
			$ptp['PTM_NUMBER'] = $ptm_number;
			//$ptp['EVT_ID'] = $this->input->post('evt_id');
			$ptp['PTP_IS_ITEMIZE'] = $this->input->post('is_itemize');
			if ($this->input->post('ptp_justification') == 5) {
				$ptp['PTP_EVALUATION_METHOD'] = 1;
			} else {
				$ptp['PTP_EVALUATION_METHOD'] = $this->input->post('ptp_evaluation_method');
			}
			$ptp['PTP_TERM_PAYMENT'] = $this->input->post('ptp_term_payment');
			$ptp['PTP_TERM_DELIVERY'] = $this->input->post('ptp_term_delivery');
			$ptp['PTP_PAYMENT_NOTE'] = $this->input->post('ptp_payment_note');
			$ptp['PTP_DELIVERY_NOTE'] = $this->input->post('ptp_delivery_note');
			$ptp['PTP_WARNING_NEGO'] = $this->input->post('ptp_warning_nego');
			$ptp['PTP_REG_OPENING_DATE'] = $this->input->post('ptp_reg_opening_date') != '' ? date('d-M-Y g.i.s A', strtotime($this->input->post('ptp_reg_opening_date'))) : '';
			$ptp['PTP_REG_CLOSING_DATE'] = $this->input->post('ptp_reg_closing_date') != '' ? date('d-M-Y g.i.s A', strtotime($this->input->post('ptp_reg_closing_date'))) : '';
			$ptp['PTP_PREBID_DATE'] = $this->input->post('ptp_prebid_date') != '' ? date('d-M-Y g.i.s A', strtotime($this->input->post('ptp_prebid_date'))) : '';
			$ptp['PTP_DELIVERY_DATE'] = $this->input->post('ptp_delivery_date') != '' ? date('d-M-Y g.i.s A', strtotime($this->input->post('ptp_delivery_date'))) : '';
			$ptp['PTP_VALIDITY_HARGA'] = $this->input->post('ptp_validity_harga') != '' ? date('d-M-Y g.i.s A', strtotime($this->input->post('ptp_validity_harga'))) : '';
			$ptp['PTP_PREBID_LOCATION'] = $this->input->post('ptp_prebid_location');

			if($this->input->post('ptp_justification') == 5){ //Penunjukan Langsung - Repeat Order (RO) 
				$ptp['PTP_BATAS_PENAWARAN'] = 0;
				$ptp['PTP_BAWAH_PENAWARAN'] = 20;
				$ptp['PTP_WARNING'] = 1;
			}else{
				$ptp['PTP_WARNING'] = $this->input->post('ptp_warning');
				$ptp['PTP_BATAS_PENAWARAN'] = $this->input->post('ptp_batas_penawaran') == '' ? 100 : intval($this->input->post('ptp_batas_penawaran'));
				$ptp['PTP_BAWAH_PENAWARAN'] = $this->input->post('ptp_batas_penawaran_bawah') == '' ? 100 : intval($this->input->post('ptp_batas_penawaran_bawah'));
			}
			$ptp['PTP_BATAS_NEGO'] = $this->input->post('ptp_batas_nego') == '' ? 100 : intval($this->input->post('ptp_batas_nego'));
			$jaminan_penawaran = intval($this->input->post('jaminan_penawaran'));
			$ptp['PTP_PERSEN_PENAWARAN'] = $jaminan_penawaran == 1 ? intval($this->input->post('persen_penawaran')) : '';
			$jaminan_pelaksanaan = intval($this->input->post('jaminan_pelaksanaan'));
			$ptp['PTP_PERSEN_PELAKSANAAN'] = $jaminan_pelaksanaan == 1 ? intval($this->input->post('persen_pelaksanaan')) : '';
			$jaminan_pemeliharaan = intval($this->input->post('jaminan_pemeliharaan'));
			$ptp['PTP_PERSEN_PEMELIHARAAN'] = $jaminan_pemeliharaan == 1 ? intval($this->input->post('persen_pemeliharaan')) : '';
			$ptp['PTP_VENDOR_NOTE'] = $this->input->post('ptp_vendor_note');

			/* Pembatasan tanggal rfq */
			$rfqdate = explode(' ', $ptp['PTP_REG_OPENING_DATE']);
			$rfqdate = strtotime($rfqdate[0]);

			$quodeadline = explode(' ', $ptp['PTP_REG_CLOSING_DATE']);
			$quodeadline = strtotime($quodeadline[0]);

			$ddate = explode(' ', $ptp['PTP_DELIVERY_DATE']);
			$ddate = strtotime($ddate[0]);

			if (($rfqdate > $quodeadline) || ($quodeadline > $ddate)) {
				$this->session->set_flashdata('error', 'Tanggal RFQ harus kurang dari quotation deadline dan tanggal quotation deadline harus kurang dari delivery date');
				redirect('Procurement_pengadaan/get_detail/' . $id);
			}
			//*/

			$this->prc_tender_prep->updateByPtm($id, $ptp);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_pengadaan/update','prc_tender_prep','update',$ptp,array('PTM_NUMBER'=>$id));
				//--END LOG DETAIL--//

			$oldptm = $this->prc_tender_main->ptm($id);
			$oldptm = $oldptm[0];
			$ptm_number = $id;

			/* UPDATE PTM */
			$ptm['PTM_NUMBER'] = $ptm_number;
			$ptm['PTM_RFQ_TYPE'] = $this->input->post('ptm_rfq_type');
			$ptm['PTM_CURR'] = $this->input->post('ptm_curr');
			if ($this->input->post('ptp_justification') == 5) {
				$ptm['SAMPUL'] = 1;
			} else {
				$ptm['SAMPUL'] = $this->input->post('ptp_evaluation_method');
			}
			$this->prc_tender_main->updateByPtm($id, $ptm);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_pengadaan/update','prc_tender_main','update',$ptm,array('PTM_NUMBER'=>$id));
				//--END LOG DETAIL--//
			//*/

			/* Create additional item */
			$nfiles = $this->input->post('numberfiles');
			for ($i = 1; $i <= $nfiles ; $i++) { 
				$uploaded = $this->file_operation->upload(UPLOAD_PATH.'additional_file', array('add_doc'.$i => $_FILES['add_doc'.$i]));

				/* upload tambahan item untuk vendor */
				if (!empty($uploaded['add_doc'.$i])) {
					$add['ADD_ID'] = $this->prc_add_item->get_id();
					$add['PTM_NUMBER'] = $ptm_number;
					$namedoc = 'name_doc' . $i;
					$add['NAME'] = $this->input->post($namedoc);
					$add['FILE'] = $uploaded['add_doc'.$i]['file_name'];
					$add['CREATED_AT'] = date('d-M-Y g.i.s A');

					$this->prc_add_item->insert($add);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Procurement_pengadaan/update','prc_add_item','insert',$add);
						//--END LOG DETAIL--//
				}
			}
			//*/

				//--insert template--//
			/* Mbuat ET */
			//save mandatory
			// $mandatory = (array)$this->input->post('mandatory');
			// $et_name = (array)$this->input->post('et_name');
			// $et_weight = (array)$this->input->post('et_weight');
			// $ppd_id = (array)$this->input->post('ppd_id');
			// $et_id = $this->prc_evaluasi_teknis->get_id();
			// foreach($et_name as $key => $each_et_name){
			// 	$IS_MANDATORY = 0;
			// 	if (in_array($each_et_name, $mandatory)) {
			// 		$IS_MANDATORY = 1;
			// 	}

			// 	$pet[] = array(
			// 		'ET_ID' => $et_id,
			// 		'PTM_NUMBER' => $id,
			// 		'ET_NAME' => $each_et_name,
			// 		'ET_WEIGHT' => $et_weight[$key],
			// 		'IS_MANDATORY' => $IS_MANDATORY,
			// 		'PPD_ID' => $ppd_id[$key],
			// 		);
			// 	$et_id++;
			// }
			// $this->prc_evaluasi_teknis->delete(array('PTM_NUMBER' => $id));
			// $this->prc_evaluasi_teknis->insert_batch($pet);
			//*/
				//--end insert template--//

			/* transaksi aproval */
			$ptm = $this->prc_tender_main->ptm($id);
			$ptm = $ptm[0];
			$counter = $this->prc_tender_approve->get_max_counter($id, $ptm['PTM_COUNT_RETENDER']);
			$counter = $counter + 1;
			$tap_id = $this->prc_tender_approve->get_id();
			$tap = array(
				'TAP_ID'         => $tap_id,
				'PTM_NUMBER'     => $id,
				'TAP_USER'       => $this->session->userdata['FULLNAME'],
				'TAP_USER_ID'    => $this->authorization->getEmployeeId(),
				'TAP_CREATED_AT' => date('d-M-Y g.i.s A'),
				'TAP_ITERATION'  => $ptm['PTM_COUNT_RETENDER'],
				'TAP_COUNTER'    => $counter,
				);
			$this->prc_tender_approve->insert($tap);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_pengadaan/update','prc_tender_approve','insert',$tap);
				//--END LOG DETAIL--//

			/* update dan simpan vendor */
			$data['PTM_NUMBER'] = $id;
			$this->prc_tender_vendor->delete($data);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_pengadaan/update','prc_tender_vendor','delete',null,$data);
				//--END LOG DETAIL--//

			$tapv['TAP_ID'] = $tap_id;
			$tapv['TAPV_ID'] = $this->prc_tender_approve_vendor->get_id();
			
			$postvendor = $this->input->post('vendor');
			$postvendor = array_unique($postvendor);
			foreach ($postvendor as $key) {
				$data['PTV_ID'] = $this->prc_tender_vendor->get_id();
				$data['PTV_VENDOR_CODE'] = $key;
				$this->prc_tender_vendor->insert_array($data);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_pengadaan/update','prc_tender_vendor','insert',$data);
					//--END LOG DETAIL--//

				$tapv['PTV_VENDOR_CODE'] = $key;
				$this->prc_tender_approve_vendor->insert($tapv);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_pengadaan/update','prc_tender_approve_vendor','insert',$tapv);
					//--END LOG DETAIL--//
				$tapv['TAPV_ID']++;
			}
				//proses insert vendor tambahan / Vendor Non Dirven
			if ($this->input->post('vendor_tambahan') != false) {
				$tapv['TAPV_ID'] = $this->prc_tender_approve_vendor->get_id();

				$postvendor = $this->input->post('vendor_tambahan');
				$postvendor = array_unique($postvendor);
				foreach ($postvendor as $key) {
					$data['PTV_ID'] = $this->prc_tender_vendor->get_id();
					$data['PTV_VENDOR_CODE'] = $key;
					$data['PTV_NON_DIRVEN'] = '1'; // 1=VENDOR NON DIRVEN
					$this->prc_tender_vendor->insert_array($data);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Procurement_pengadaan/update','prc_tender_vendor','insert',$data);
						//--END LOG DETAIL--//

					$tapv['PTV_VENDOR_CODE'] = $key;
					$this->prc_tender_approve_vendor->insert($tapv);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Procurement_pengadaan/update','prc_tender_approve_vendor','insert',$tapv);
						//--END LOG DETAIL--//
					$tapv['TAPV_ID']++;
				}
			}
			//*/
			
			$this->load->model('prc_plan_doc');
			$doc = $this->input->post('share');
			if ($doc != false) {
				foreach ((array) $doc as $key => $value) {
					$name =  str_replace("_", ".", $key);
					$this->prc_plan_doc->update(array("IS_SHARE" => $value), array('PPD_FILE_NAME' => $name));
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Procurement_pengadaan/update','prc_plan_doc','update',array('IS_SHARE' => $value),array('PPD_FILE_NAME'=>$name));
						//--END LOG DETAIL--//
				}
			}

			$this->load->library('process');
			$this->process->next_process($ptm_number, 'NEXT', $LM_ID);

			$this->session->set_flashdata('success', 'success'); 
			redirect('Job_list');

		}else{
			$data = $this->prc_tender_main->ptm($id);
			$this->prc_tender_main->updateByPtm($id, array('PTM_STATUS' => $data['0']['PTM_STATUS'] * - 1 ));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_pengadaan/update','prc_tender_main','update',array('PTM_STATUS' => $data['0']['PTM_STATUS'] * - 1 ),array('PTM_NUMBER'=>$id));
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

			$this->session->set_flashdata('reject', 'reject'); 
			redirect('Job_list');
		}

	}

	public function centang_item_mandatory($ptp_id) {
		$this->load->model('prc_preq_template_detail');
		$data['ppd'] = $this->prc_preq_template_detail->get(array('PPT_ID' => $ptp_id));
		$this->load->view('centang_mandatory', $data);
	}

	public function get_vendor($ptm_number) {
		/* Pakai SAP */
		$this->load->library('sap_handler');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_purchase_requisition');
		$this->load->model('vnd_header');
		$this->load->model('vnd_perf_hist');
		$this->load->model('vnd_perf_sanction');
		$this->load->model('vnd_perf_mst_category');

		$ptm = $this->prc_tender_main->prc_tender_main->ptm($ptm_number);
		$ptm = $ptm[0];
		$just = $ptm['JUSTIFICATION'];
		
		$this->prc_tender_item->join_item();
		$tits = $this->prc_tender_item->ptm($ptm_number);

		$matkl = array();
		$pritn = array();
		$pr = array();
		$porg = array();

		foreach ($tits as $tit) {
			$matkl[] = $tit['PPI_MATGROUP'];
			$pritn[] = $tit['PPI_PRITEM'];
			$pr[] = $tit['PPI_PRNO'];
		}
		$pr0 = $this->prc_purchase_requisition->pr($pr[0]);
		$porg = $pr0['PPR_PORG'];
		if ($porg == '') {
			$porg = pgrp_to_porg($pr0['PPR_PGRP']);
		}
		$data['pr'] = $pr;
		$data['pritn'] = $pritn;
		$data['matkl'] = $matkl;
		$data['porg'] = $porg;
		$data['vendor'] = $this->sap_handler->getVendor($pr, $pritn, $matkl, $porg);
		//*/

		$ngelist_vendor = array();

		foreach ($data['vendor'] as $key => $val) {
			if ($just == 6) {
				if ($val['JP'] == 'A' || $val['JP'] == 'M') {
					$ngelist_vendor[] = $val['LIFNR'];
					// $data['vendor'][$key]['header'] = $this->vnd_header->get(array('VENDOR_NO' => $val['LIFNR']));
				} else {
					$ngelist_vendor[] = $val['LIFNR'];
					//unset($data['vendor'][$key]);
				}
			} else {
				$ngelist_vendor[] = $val['LIFNR'];
				// $data['vendor'][$key]['header'] = $this->vnd_header->get(array('VENDOR_NO' => $val['LIFNR']));
			}
		}

		$ngelist_vendor = array_unique($ngelist_vendor);
		// var_dump($ngelist_vendor);
		$vendor_unique = $this->vnd_header->where('VENDOR_NO', $ngelist_vendor)->get_all();
		// var_dump($vendor_unique);

		foreach ((array) $vendor_unique as $key => $val) {
			$tanggal = date(timeformat());
			$cek = $this->vnd_perf_sanction->cek_sanksi_vendor($val['VENDOR_NO'],$tanggal);
			if ($cek == false) {
				$performa = $this->vnd_perf_hist->get_vendor_last_point($val['VENDOR_NO']);
				if (count($performa) <= 0) {
					$nilai = '';
					$category = '';
				} else {
					$nilai = $performa[0]['POIN_CURR'];
					$category_que = $this->vnd_perf_mst_category->getvendor($nilai);
					$category = $category_que[0]['CATEGORY_NAME'];
				}
				$val['CATEGORY'] = $category;
				$val['PERFORMA'] = $nilai;
				$vendor_by_id[$val['VENDOR_NO']] = $val;
			} else {
				$cek = '';
			}
		}

		foreach ($data['vendor'] as $key => $val) {
			if (isset($vendor_by_id[$val['LIFNR']])) {
				$data['vendor'][$key]['header'] = $vendor_by_id[$val['LIFNR']];
			}
		}

		/* dari VND_HEADER *
		$this->load->model('vnd_header');
		$data['vendor'] = $this->vnd_header->get(array('COMPANYID' => '4000', 'STATUS' => 1));
		//*/

		// die(var_dump($val['CATEGORY']));

		echo json_encode($data);
	}

	public function get_all_template($opco) {
		$this->load->model('prc_evaluation_template');
		if($opco != '99'){
			if($opco=='2000' || $opco=='5000' || $opco=='7000'){
				$opco = '2000,5000,7000';
			}
			$this->prc_evaluation_template->company($opco);
		}
		$data = array('data' => $this->prc_evaluation_template->get_w_type());
		echo json_encode($data);
		// var_dump($this->prc_evaluation_template->get_w_type());
	}



	public function get_vendor_jasa(){
		$this->load->model('prc_tender_prep');
		$this->load->model('vnd_product');
		$this->load->model('vnd_header');
		$this->load->model('vnd_perf_hist');
		$this->load->model('vnd_perf_mst_category');
		$this->load->model('vnd_perf_sanction');
		$this->load->model('vendor_detail');

		$id_ptm = $this->input->post('id_ptm');
		$ptp = $this->prc_tender_prep->ptm($id_ptm);
		if($ptp['PTP_FILTER_NAME'] == 'SUBKLASIFIKASI_ID'){
			$q = "	SELECT PRODUCT_ID,VENDOR_ID,PRODUCT_NAME,KLASIFIKASI_NAME,KUALIFIKASI_NAME,SUBKUALIFIKASI_NAME,SUBKLASIFIKASI_ID FROM(
			SELECT PRODUCT_ID,VENDOR_ID,PRODUCT_NAME,KLASIFIKASI_NAME,KUALIFIKASI_NAME,SUBKUALIFIKASI_NAME,
			trim(regexp_substr(SUBKLASIFIKASI_ID, '[^,]+', 1, lines.COLUMN_VALUE)) SUBKLASIFIKASI_ID,
			lines.column_value
			FROM VND_PRODUCT
			CROSS JOIN
			(SELECT *
			FROM TABLE (CAST (MULTISET
			(SELECT LEVEL
			FROM dual
			CONNECT BY LEVEL <= (SELECT COUNT(REPLACE(SUBKLASIFIKASI_ID, ','))  FROM VND_PRODUCT )
			) AS sys.odciNumberList ) )
			) lines
			)
			WHERE SUBKLASIFIKASI_ID IN (".$ptp['PTP_FILTER_VND_PRODUCT'].") 
			ORDER BY PRODUCT_ID ";
			$data = $this->db->query($q)->result_array();

		}else{
			$data = $this->vnd_product->order_by('PRODUCT_ID')->get_all(array($ptp['PTP_FILTER_NAME'] => $ptp['PTP_FILTER_VND_PRODUCT'], "PRODUCT_TYPE" => "SERVICES"));
		}

		$id_product=''; $arr_data=array();
		if(is_array($data)){
			foreach ($data as $key => $val) {
				$tanggal = date(timeformat());
				$veno_array = $this->vnd_header->get(array('VENDOR_ID'=>$val['VENDOR_ID']));
				if (is_numeric($veno_array['VENDOR_NO'])) {
					$cek = $this->vnd_perf_sanction->cek_sanksi_vendor($veno_array['VENDOR_NO'],$tanggal);

					/* CEK OPCO */ 
					$opco = $this->session->userdata['EM_COMPANY'];
					$cek_opco = $this->vendor_detail->get_vendor_jasa($veno_array['VENDOR_NO'],$opco);
					if (!empty($cek_opco)) {
						foreach ($cek_opco as $key => $vnd) {

							if ($cek == false) {
								if($id_product != $val['PRODUCT_ID']){
										// $vnd = $this->vnd_header->get(array('VENDOR_ID'=>$val['VENDOR_ID']));
									$performa = $this->vnd_perf_hist->get_vendor_last_point($vnd['VENDOR_NO']);					
									if (count($performa) <= 0) {
										$nilai = '';
										$category = '';
									} else {
										$nilai = $performa[0]['POIN_CURR'];
										$category_que = $this->vnd_perf_mst_category->getvendor($nilai);
										$category = $category_que[0]['CATEGORY_NAME'];

									}

									$arr_data[] = array(
										'PRODUCT_ID'=>$val['PRODUCT_ID'] ,
										'VENDOR_NO'=>$vnd['VENDOR_NO'] ,
										'VENDOR_NAME'=>$vnd['VENDOR_NAME'] ,
										'PRODUCT_NAME'=>$val['PRODUCT_NAME'] ,
										'KLASIFIKASI_NAME'=>$val['KLASIFIKASI_NAME'] ,
										'KUALIFIKASI_NAME'=>$val['KUALIFIKASI_NAME'] ,
										'SUBKUALIFIKASI_NAME'=>$val['SUBKUALIFIKASI_NAME'],
										'CATEGORY'=>$category ,
										'PERFORMA'=>$nilai 
										);	
									$id_product=$val['PRODUCT_ID'];
								}
								
							} else {
								$cek = '';
							}
						}
					}
				}
			}
		}
		$data = array('data' => $arr_data);
		echo json_encode($data);
	}

	public function get_vendor_barang(){  // proses generate vendor barang non dirven
		$this->load->model('vnd_product');
		$this->load->model('vendor_detail');
		// $this->load->model('vnd_header');
		$this->load->model('vnd_perf_sanction');

		$vendor = $this->input->post('vendor');
		$vendor_lama = array();
		if(!empty($vendor)){
			foreach ($vendor as $val) {
				$vendor_lama[$val]=0;
			}
		}

		$vendor_id=''; $arr_data=array();
		// $data = $this->vnd_product->order_by('VENDOR_ID')->get_all(array("PRODUCT_TYPE" => "GOODS"));
		// if(is_array($data)){
		// 	foreach ($data as $key => $val) {
		// 		if($vendor_id != $val['VENDOR_ID']){
		// 			$vnd = $this->vnd_header->get(array('VENDOR_ID'=>$val['VENDOR_ID']));
		// 			if(!empty($vnd['VENDOR_NO'])){
		// 				$tanggal = date(timeformat());
		// 				$cek = $this->vnd_perf_sanction->cek_sanksi_vendor($vnd['VENDOR_NO'],$tanggal);
		// 				if ($cek == false && !isset($vendor_lama[$vnd['VENDOR_NO']]) ) { 
		// 					$arr_data[] = array(
		// 						'VENDOR_NO'=>$vnd['VENDOR_NO'] ,
		// 						'VENDOR_NAME'=>$vnd['VENDOR_NAME'] 
		// 					);	
		// 				}else {
		// 					$cek= '';
		// 				}
		// 			}
		// 			$vendor_id=$val['VENDOR_ID'];
		// 		}
		// 	}
		// }
		// $data = array('data' => $arr_data);
		// echo json_encode($data);

		$opco = $this->session->userdata['EM_COMPANY'];
		if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
			$whereopco = '\'7000\',\'2000\',\'5000\'';
		} else if ($opco == '3000') {
			$whereopco = '\'3000\'';
		} else if ($opco == '4000'){
			$whereopco = '\'4000\'';
		}

		$data = $this->vendor_detail->get_vendor($whereopco);

		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$veno = $value['VENDOR_NO'];
				if ($veno != 'Postal Code') {
					if($vendor_id != $value['VENDOR_ID']){
						$tanggal = date(timeformat());
						$cek = $this->vnd_perf_sanction->cek_sanksi_vendor($value['VENDOR_NO'],$tanggal);
						if ($cek == false && !isset($vendor_lama[$value['VENDOR_NO']]) ) { 
							// echo $value['VENDOR_ID']."<pre>";
							// print_r($ambilBarang);
							// die;
							$barang = "";
							$jasa = "";
							
							// $ambilBarang = $this->vendor_detail->produk($value['VENDOR_ID']);
							// $ambilJasa = $this->vendor_detail->produk_jasa($value['VENDOR_ID']);
							// $i=0;
							// if(count($ambilBarang)>0){
							// 	foreach ($ambilBarang as $ab) {
							// 		$i++;
							// 		if($i==count($ambilBarang)){
							// 			$barang.= $i.". ".$ab['PRODUCT_NAME'];
							// 		} else {
							// 			$barang.= $i.". ".$ab['PRODUCT_NAME']."<br>";
							// 		}
							// 	}
							// } else {
							// 	$barang = "-";
							// }

							// $i=0;
							// if(count($ambilJasa)>0){
							// 	foreach ($ambilJasa as $aj) {
							// 		$i++;
							// 		if($i==count($ambilBarang)){
							// 			$jasa.= $i.". ".$aj['PRODUCT_NAME'];
							// 		} else {
							// 			$jasa.= $i.". ".$aj['PRODUCT_NAME']."<br>";
							// 		}
							// 	}
							// } else {
							// 	$jasa = "-";
							// }

							$arr_data[] = array(
								'VENDOR_NO'=>$value['VENDOR_NO'] ,
								'VENDOR_NAME'=>$value['VENDOR_NAME'],
								'BARANG'=>$barang,
								'JASA'=>$jasa 
								);	
						}else {
							$cek= '';
						}
					}
					$vendor_id=$value['VENDOR_ID'];
				}
			}
		}

		$data = array('data' => $arr_data);
		echo json_encode($data);

	}

}
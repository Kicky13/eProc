<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement_reschedule extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->load->library("file_operation");
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model('currency_model');
		$this->load->helper('url');
		$this->load->library('comment');
	}

	public function index() {
		$data['title'] = "Procurement Reschedule";
		$this->session->keep_flashdata('success');
		$data['success'] = $this->session->flashdata('success') == 'success';
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_validate_css();
		$this->layout->set_validate_js();
		$this->layout->add_js('pages/prc_reschedule.js');	
		$this->layout->add_js("strTodatetime.js");
		$this->layout->render('list_reschedule', $data);
	}

	public function detail($id){
		$this->load->model('app_process_master');
		$this->load->model('prc_tender_item');
		$this->load->library('form_validation');
		$this->load->library('snippet');
		$this->load->model('prc_doc_type_master');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$ptm = $this->prc_tender_main->ptm($id);
		$data['ptm'] = $ptm[0];
		$this->prc_tender_prep->join_eval_template();
		$data['ptp'] = $this->prc_tender_prep->ptm($id);
		$data['title'] = "Ubah Tanggal Pengadaan";
		// $this->prc_tender_item->join_pr();
		// $data['tit'] = $this->prc_tender_item->ptm($id);
		$this->load->library('process');
		$data['next_process'] = $this->process->get_next_process($id);

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
					$dok[$count]['IS_SHARE'] = $val['IS_SHARE'];
					$dok[$count]['PDC_IS_PRIVATE'] = $val['PDC_IS_PRIVATE'];
					$dok[$count]['PDC_NAME'] = $val['PDC_NAME'];
					$dok[$count]['PPD_DESCRIPTION'] = $val['PPD_DESCRIPTION'];
					$dok[$count]['item'][0]['DECMAT'] = $dokumens[$ppi_id]['PPI_DECMAT'];
					$dok[$count]['item'][0]['NOMAT'] =  $dokumens[$ppi_id]['PPI_NOMAT'];
					$count = $count + 1;
				}
				// var_dump($val);
			}
		}

		$this->load->model('prc_add_item');
		$this->prc_add_item->where_ptm($id);
		$data['dokumentambahan'] = $this->prc_add_item->get();

		$data['dokumen'] = $dok;

		$data['detail_item_ptm'] = $this->snippet->detail_item_ptm($id);
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);
		$data['rfq_type'] = $this->prc_doc_type_master->get();
		// var_dump($data['ptp']);
		// die();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_datetimepicker();
		$this->layout->add_js('pages/mydatetimepicker.js');
		$this->layout->add_js('plugins/numeral/numeral.js');
		$this->layout->add_js('plugins/numeral/languages/id.js');
		$this->layout->render('ubah_tanggal', $data);
	}

	public function save_bidding() {
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->library('sap_handler');

		/* UPDATE PTP */
		// var_dump($this->input->post());
		$id = $this->input->post('ptm_number');
		$status_krm_rfq = 8; 
		$status_ver_penawaran = 16; 

		$ptp_lama = $this->prc_tender_prep->ptm($id);
		// $REG_OPENING_DATE_LAMA = oracledate(strtotime(betteroracledate(oraclestrtotime($ptp_lama['PTP_REG_OPENING_DATE']))));
		// $REG_OPENING_DATE_BARU = oracledate(strtotime($this->input->post('ptp_reg_opening_date')));
		$REG_CLOSING_DATE_LAMA = oracledate(strtotime(betteroracledate(oraclestrtotime($ptp_lama['PTP_REG_CLOSING_DATE']))));
		$REG_CLOSING_DATE_BARU = oracledate(strtotime($this->input->post('ptp_reg_closing_date')));
		$PREBID_DATE_LAMA = oracledate(strtotime(betteroracledate(oraclestrtotime($ptp_lama['PTP_PREBID_DATE']))));
		$PREBID_DATE_BARU = oracledate(strtotime($this->input->post('ptp_prebid_date')));
		// $DELIVERY_DATE_LAMA = oracledate(strtotime(betteroracledate(oraclestrtotime($ptp_lama['PTP_DELIVERY_DATE']))));
		// $DELIVERY_DATE_BARU = oracledate(strtotime($this->input->post('ptp_delivery_date')));

		$ptm_lama = $this->prc_tender_main->ptm($id);
		$ptm_lama = $ptm_lama[0];
		$BATAS_VENDOR_HARGA_LAMA = oracledate(strtotime(betteroracledate(oraclestrtotime($ptm_lama['BATAS_VENDOR_HARGA']))));
		$BATAS_VENDOR_HARGA_BARU = oracledate(strtotime($this->input->post('ptm_batas_vendor')));

		// $reg_opening_date = $REG_OPENING_DATE_LAMA;
		// if($REG_OPENING_DATE_LAMA != $REG_OPENING_DATE_BARU){
		// 	$ptp['PTP_REG_OPENING_DATE'] = $this->input->post('ptp_reg_opening_date') != '' ? $REG_OPENING_DATE_BARU : '';
		// 	$reg_opening_date = $ptp['PTP_REG_OPENING_DATE'];
		// }
		
		$reg_closing_date = $REG_CLOSING_DATE_LAMA;
		$ptv = null;
		$ubah_hny_prebid = 'tidak';
		$prebid_date='';
		if(!empty($ptp_lama['PTP_PREBID_DATE'])){
			$prebid_date = strtotime(betteroracledate(oraclestrtotime($ptp_lama['PTP_PREBID_DATE'])));
		}
		
		if($PREBID_DATE_LAMA != $PREBID_DATE_BARU){
			$ptp['PTP_PREBID_DATE'] = $this->input->post('ptp_prebid_date') != '' ? $PREBID_DATE_BARU : '';
			$prebid_date = !empty($ptp['PTP_PREBID_DATE'])? strtotime($ptp['PTP_PREBID_DATE']) : '';
			if($this->input->post('ptm_status') == $status_krm_rfq){
				$this->prc_tender_vendor->has_rfq();
				$ptv = $this->prc_tender_vendor->ptm($id);
				$batas_tanggal = strtotime($this->input->post('ptp_reg_closing_date'));
				$judul = 'Perubahan Jadwal Penawaran';
			}
			$ubah_hny_prebid = 'iya';
		}

		if($REG_CLOSING_DATE_LAMA != $REG_CLOSING_DATE_BARU){
			$ptp['PTP_REG_CLOSING_DATE'] = $this->input->post('ptp_reg_closing_date') != '' ? $REG_CLOSING_DATE_BARU : '';
			$reg_closing_date = $ptp['PTP_REG_CLOSING_DATE'];
			if($this->input->post('ptm_status') == $status_krm_rfq){
				$this->prc_tender_vendor->has_rfq();
				$ptv = $this->prc_tender_vendor->ptm($id);
				$batas_tanggal = strtotime($this->input->post('ptp_reg_closing_date'));
				$judul = 'Perubahan Jadwal Penawaran';
			}
			$ubah_hny_prebid = 'tidak';
		}
		
		// $delivery_date = $DELIVERY_DATE_LAMA;
		// if($DELIVERY_DATE_LAMA != $DELIVERY_DATE_BARU){
		// 	$ptp['PTP_DELIVERY_DATE'] = $this->input->post('ptp_delivery_date') != '' ? $DELIVERY_DATE_BARU : '';
		// 	$delivery_date = $ptp['PTP_DELIVERY_DATE'];
		// }

		if($BATAS_VENDOR_HARGA_LAMA != $BATAS_VENDOR_HARGA_BARU){
			$ptm_baru['BATAS_VENDOR_HARGA'] = $this->input->post('ptm_batas_vendor') != '' ? $BATAS_VENDOR_HARGA_BARU : null;
			if($this->input->post('ptm_status') == $status_ver_penawaran){ 
				$this->prc_tender_quo_main->join_quo_item();
				$pqm = $this->prc_tender_quo_main->ptm($id);
				$ptv = array();
				foreach ($pqm as $val) {
					$ptv[]=$this->prc_tender_vendor->ptm_ptv($id,$val['PTV_VENDOR_CODE']);
				}
				$batas_tanggal = strtotime($this->input->post('ptm_batas_vendor'));
				$judul = 'Perubahan Jadwal Memasukkan Harga';
			}
			$ubah_hny_prebid = 'tidak';
		}

			/* Pembatasan tanggal rfq */
		// $rfqdate = explode(' ', $reg_opening_date);
		// $rfqdate = strtotime($rfqdate[0]);

		// $quodeadline = explode(' ', $reg_closing_date);
		// $quodeadline = strtotime($quodeadline[0]);

		// $ddate = explode(' ', $delivery_date);
		// $ddate = strtotime($ddate[0]);

		// if (($rfqdate > $quodeadline) || ($quodeadline > $ddate)) {
		// 	$this->session->set_flashdata('error', 'Tanggal RFQ harus kurang dari quotation deadline dan tanggal quotation deadline harus kurang dari delivery date');
		// 	redirect('Procurement_reschedule/detail/' . $id);
		// }
			/* -- */
		
			/* --- update ke SAP & kirim email-- */
		if(isset($ptv)){
			$is_rfc_error = false;
			$hasil_rfc = array();
			foreach ($ptv as $value) {
				$ptm = $this->prc_tender_main->ptm($id);
				$ptm = $ptm[0];
				if (!empty($prebid_date)) {
					$prebid_date = date('d M Y g.i.s A',$prebid_date);
				}
				
				if($ubah_hny_prebid == 'iya' && $this->input->post('ptm_status') == $status_krm_rfq){  /* perubahan hanya Tanggal Aanwijing maka hanya krm email saja */
					$rfq = $value['PTV_RFQ_NO'];
					$dataRfq = $value;
					$dataemail=array(
						'noptm'=>$ptm['PTM_PRATENDER'],
						'norfq'=>$rfq,
						'rfqdate'=>date('d M Y g.i.s A', strtotime(betteroracledate(oraclestrtotime($ptp_lama['PTP_REG_OPENING_DATE'])))),
						'quodeadline'=>date('d M Y g.i.s A', $batas_tanggal),
						'aanwizjigdate'=>$prebid_date,
						'aanwizjiglocation'=>$ptp_lama['PTP_PREBID_LOCATION']
					);
					$konten = 'email/undangan_tender';

				}else{
					if($this->input->post('ptm_status') == $status_krm_rfq){
						$rfq = $value['PTV_RFQ_NO'];
						$dataRfq = $value;
						$dataemail=array(
							'noptm'=>$ptm['PTM_PRATENDER'],
							'norfq'=>$rfq,
							'rfqdate'=>date('d M Y g.i.s A', strtotime(betteroracledate(oraclestrtotime($ptp_lama['PTP_REG_OPENING_DATE'])))),
							'quodeadline'=>date('d M Y g.i.s A', $batas_tanggal),
							'aanwizjigdate'=>$prebid_date,
							'aanwizjiglocation'=>$ptp_lama['PTP_PREBID_LOCATION']
						);
						$konten = 'email/undangan_tender';

					} else if($this->input->post('ptm_status') == $status_ver_penawaran){
						$prebid_date = '';
						$rfq = $value[0]['PTV_RFQ_NO'];
						$dataRfq = $value[0];
						$dataemail=array(
							'norfq'=>$rfq,
							'noptm'=>$ptm['PTM_PRATENDER'],				
							'batasdate'=>date('d M Y g.i.s A', $batas_tanggal),
						);
						$konten = 'email/undangan_harga';
					} 

					$quodeadline=date('Ymd', $batas_tanggal);

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
					$this->session->set_flashdata('error', $hasil_rfc);
					if ($is_rfc_error) {
						redirect('Procurement_reschedule/detail/' . $id);
					}
				}

				$vendor=array_merge($dataRfq,array('data'=>$dataemail));
				$this->kirim_email_undangan($vendor,$judul,$konten);				
			}
		}	
			/* ------- */	

		if($BATAS_VENDOR_HARGA_LAMA != $BATAS_VENDOR_HARGA_BARU){
			$this->prc_tender_main->updateByPtm($id, $ptm_baru);
		}
		if($REG_CLOSING_DATE_LAMA != $REG_CLOSING_DATE_BARU || $PREBID_DATE_LAMA != $PREBID_DATE_BARU ){
			$this->prc_tender_prep->updateByPtm($id, $ptp);
		}
		//*/

		$this->session->set_flashdata('success', 'success');
		redirect('Procurement_reschedule/index');
	}

	public function get_datatable() {
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_item');
		$this->prc_tender_main->join_latest_activity();
		$kelprgrp = $this->session->userdata('KEL_PRGRP');
		$pgrp = $this->session->userdata('PRGRP');
		
		$this->prc_tender_main->join_prep();
		$this->prc_tender_main->status('8');
		$this->prc_tender_main->where_kel_plant_pro($kelprgrp);
		$this->prc_tender_main->where_pgrp_in($pgrp);
		$dat = array();

		$datatable = $this->prc_tender_main->get(null, false, null, true);
		$data = array('data' => isset($datatable)?$datatable:'');
		// $data = array('data' => $dat);
		echo json_encode($data);
	}

	public function kirim_email_undangan($vendor,$judul,$konten){
		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->to($vendor['EMAIL_ADDRESS']);				
		$this->email->cc('pengadaan.semenindonesia@gmail.com');				
		$this->email->subject($judul." dari eProcurement PT. Semen Indonesia (Persero) Tbk.");
		$content = $this->load->view($konten,$vendor['data'],TRUE);
		$this->email->message($content);
		$this->email->send();
	}


}
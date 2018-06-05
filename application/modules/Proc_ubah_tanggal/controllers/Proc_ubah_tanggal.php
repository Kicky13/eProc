<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proc_ubah_tanggal extends CI_Controller {

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

	public function index($id) {
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
		$this->layout->render('proc_ubah_tanggal', $data);
	}

	public function save_bidding() {
		$this->load->library("file_operation");
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_main_log');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_add_item');
		$this->load->model('prc_evaluasi_teknis');
		$this->load->model('prc_tender_approve');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_approve_vendor');
		$this->load->model('prc_approve_tender');

		/* UPDATE PTP */
		// var_dump($this->input->post());
		$ptm_number = $this->input->post('ptm_number');
		$id = $ptm_number;
		$ptp['PTM_NUMBER'] = $ptm_number;
		
		$ptp['PTP_REG_OPENING_DATE'] = $this->input->post('ptp_reg_opening_date') != '' ? oracledate(strtotime($this->input->post('ptp_reg_opening_date'))) : '';
		$ptp['PTP_REG_CLOSING_DATE'] = $this->input->post('ptp_reg_closing_date') != '' ? oracledate(strtotime($this->input->post('ptp_reg_closing_date'))) : '';
		$ptp['PTP_PREBID_DATE'] = $this->input->post('ptp_prebid_date') != '' ? oracledate(strtotime($this->input->post('ptp_prebid_date'))) : '';
		$ptp['PTP_DELIVERY_DATE'] = $this->input->post('ptp_delivery_date') != '' ? oracledate(strtotime($this->input->post('ptp_delivery_date'))) : '';

		/* Pembatasan tanggal rfq */
		$rfqdate = explode(' ', $ptp['PTP_REG_OPENING_DATE']);
		$rfqdate = strtotime($rfqdate[0]);

		$quodeadline = explode(' ', $ptp['PTP_REG_CLOSING_DATE']);
		$quodeadline = strtotime($quodeadline[0]);

		$ddate = explode(' ', $ptp['PTP_DELIVERY_DATE']);
		$ddate = strtotime($ddate[0]);

		if (($rfqdate > $quodeadline) || ($quodeadline > $ddate)) {
			$this->session->set_flashdata('error', 'Tanggal RFQ harus kurang dari quotation deadline dan tanggal quotation deadline harus kurang dari delivery date');
			redirect('Proc_ubah_tanggal/index/' . $id);
		}
		//*/

		// var_dump($ptp); 
		// exit();
		$this->prc_tender_prep->updateByPtm($id, $ptp);
		//*/

		$this->session->set_flashdata('success', 'success'); redirect('Job_list');
	}
}
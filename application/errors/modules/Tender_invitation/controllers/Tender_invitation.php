<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tender_invitation extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->library('encrypt');
		$this->load->model(array('prc_tender_vendor','prc_tender_item'));
	}

	function index() {
		$data['title'] = "Tender Invitation List";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/tender_invitation.js');
		$this->layout->render('invitation_list',$data);
	}

	function detail_invitation($ptv_id) {
		$orig_ptv_id = $ptv_id;
		$ptv_id = url_decode($ptv_id);
		$this->load->model('prc_tender_prep');
		$data['title'] = "Tender Invitation Detail";
		$data['ptv_id'] = $orig_ptv_id;

		$this->prc_tender_vendor->join_prc_tender_main();
		$this->prc_tender_vendor->join_prc_tender_prep();
		$invitations = $this->prc_tender_vendor->get(array("PTV_ID" => $ptv_id));
		$data['tender_invitation'] = $invitations[0];
		$data['ptp'] = $this->prc_tender_prep->ptm($invitations[0]['PTM_NUMBER']);

		$this->load->library('snippet');
		$data['dokumen_pr'] = $this->snippet->dokumen_pr($data['tender_invitation']['PTM_NUMBER'], 0, true, true);
		$data['detail_ptm'] = $this->snippet->detail_ptm($data['tender_invitation']['PTM_NUMBER'], false, true, true, $invitations[0]['PTV_RFQ_NO']);
		$data['detail_item_ptm'] = $this->snippet->detail_item_ptm($data['tender_invitation']['PTM_NUMBER'], true);

		$items = $this->prc_tender_item->get(array('PTM_NUMBER' => $data['tender_invitation']['PTM_NUMBER']));
		$data['invitation_tender_items'] = $items;
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/detail_invitation.js');
		$this->layout->render('invitation_detail',$data);
	}

	function get_invitation_list()
	{
		$this->prc_tender_vendor->join_vnd_header('INNER');
		$this->prc_tender_vendor->join_prc_tender_main();
		$this->prc_tender_vendor->join_prc_tender_prep();
		$invitations = $this->prc_tender_vendor->get(array(
				'PTV_STATUS' => NULL, 
				'IS_VENDOR_CLOSED' => 0, 
				'PTV_VENDOR_CODE' => $this->session->userdata('VENDOR_NO'),
			));
		$count = 0;
		$invite = array();
		foreach ((array) $invitations as $key => $value) {
			$opening = $value['PTP_REG_OPENING_DATE'];
			$closing = $value['PTP_REG_CLOSING_DATE'];
			$now = strtotime('now');
			
			if(oraclestrtotime($closing) > $now && $now > oraclestrtotime($opening)) {
				$invite[$count] = $invitations[$key];
				$invite[$count]['PTV_ID'] = url_encode($invite[$count]['PTV_ID']);
				$invite[$count]['PTP_REG_OPENING_DATE'] = betteroracledate(oraclestrtotime($value['PTP_REG_OPENING_DATE']));
				$invite[$count]['PTP_REG_CLOSING_DATE'] = betteroracledate(oraclestrtotime($value['PTP_REG_CLOSING_DATE']));
				$count++;
			}
		}
		echo json_encode(array('data' => $invite));
	}

	function do_update_tender_invitation($ptv_id) {
		$ptv_id = url_decode($ptv_id);
		$alasan = $this->input->post('alasan');
		$status = $this->input->post('PTV_STATUS');
		$ptm_number = $this->input->post('ptm_number');
		if ($alasan == false) $alasan = null;
		$this->prc_tender_vendor->update(array('PTV_STATUS' => $status, 'ALASAN' => $alasan),array('PTV_ID' => $ptv_id));
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
				'VENDOR','Respon Penawaran','SIMPAN',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Tender_invitation/do_update_tender_invitation','prc_tender_vendor','update',array('PTV_STATUS' => $status, 'ALASAN' => $alasan, 'PTM_NUMBER' => $ptm_number),array('PTV_ID' => $ptv_id));
			//--END LOG DETAIL--//
		$this->session->set_flashdata('success', 'success');
		redirect('');
	}
}
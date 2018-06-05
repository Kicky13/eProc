<?php defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard_principal extends CI_Controller {
	private $user;
    private $user_email;
	public function __construct()
	{
		parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');        
        $this->load->helper("security");
        $this->user = $this->session->userdata('FULLNAME');
        $this->user_email = $this->session->userdata('EMAIL');
	}

	public function tes()
    {
        echo json_encode($this->session->userdata);
    }

	public function index()
	{
		if ($this->session->userdata('loadPrincipalDashboard') !== TRUE) {

			$this->loadGeneralDashboard();
		}
		else {
			var_dump('tes');
			$this->loadPrincipalDashboard();
		}
	}

	public function loadGeneralDashboard()
	{
		if ($this->session->userdata('update_vendor_data')) {
			redirect('Additional_document/input_summary');
			// $this->load->model('tmp_vnd_reg_progress');
			// // var_dump($this->session->all_userdata());exit();
			// $vendor_id = $this->session->userdata('VENDOR_ID');
			// $this->tmp_vnd_reg_progress->where(array('VENDOR_ID' => $vendor_id));
			// $data['ref_doc'] = $this->tmp_vnd_reg_progress->get_all();
			// $data['title'] = "Halaman Utama";
			// $this->layout->render('vendor_update_data', $data);
		}
		else {
			$data['title'] = "Halaman Utama";
			$this->layout->render('dashboard', $data);
		}

	}

	public function loadPrincipalDashboard()
	{
		$this->load->model(array('prc_tender_vendor','prc_auction_quo_header', 'vnd_header', 'prc_chat'));
		//var_dump($this->session->userdata);exit();
		$vnd_header = $this->vnd_header->get(array('VENDOR_NO'=>$this->session->userdata('VENDOR_NO')));
		//var_dump($vnd_header);exit();
		$data['title'] = "Dashboard Vendor";
		$data['needupdate'] = false;
		if($vnd_header['STATUS_PERUBAHAN']==1){
			$this->load->model(array('vnd_update_progress'));
			$update_progress = $this->vnd_update_progress->get_all(array('VENDOR_ID' => $vnd_header['VENDOR_ID']));
			if(!empty($update_progress)){
				$data['ref_doc'] = $update_progress;
			}
			$data['needupdate'] = true;
			$this->session->set_userdata('needupdate', TRUE);
		}
			$data['success'] = $this->session->flashdata('success') == 'success';

			$this->prc_tender_vendor->join_prc_tender_main();
			$this->prc_tender_vendor->join_prc_tender_prep();
			$invitations = $this->prc_tender_vendor->get(array('PTV_STATUS' => NULL, 'IS_VENDOR_CLOSED' => 0, 'PTV_VENDOR_CODE' => $this->session->userdata('VENDOR_NO')));

			$count = 0;
			$now = strtotime('now');
			foreach ((array) $invitations as $val) {
				$opening = $val['PTP_REG_OPENING_DATE'];
				$closing = $val['PTP_REG_CLOSING_DATE'];
				if(oraclestrtotime($closing) > $now && $now > oraclestrtotime($opening)) {
					$count++;
				}
			}
			$data['total_tender_invitation'] = $count;

			// $this->prc_tender_vendor->has_rfq();
			$this->prc_tender_vendor->join_prc_tender_main();
			$this->prc_tender_vendor->join_prc_tender_prep();
			$quotations1 = $this->prc_tender_vendor->get(array('PTV_VENDOR_CODE' => $this->session->userdata('VENDOR_NO'), 'PTV_STATUS >=' => 1, 'IS_VENDOR_CLOSED' => 0));

			$count = 0;
			$now = strtotime('now');
			foreach ((array) $quotations1 as $val) {
				$opening = $val['PTP_REG_OPENING_DATE'];
				$closing = $val['PTP_REG_CLOSING_DATE'];
				if(oraclestrtotime($closing) > $now && $now > oraclestrtotime($opening)) {
					$count++;
				}
			}
			$this->prc_tender_vendor->join_prc_tender_main();
			$this->prc_tender_vendor->join_prc_tender_prep();
			$this->prc_tender_vendor->where_in('PTV_STATUS_EVAL', array(1, 2));
			$quotations2 = (array) $this->prc_tender_vendor->get(array('PTV_VENDOR_CODE' => $this->session->userdata('VENDOR_NO'), 'IS_VENDOR_CLOSED' => 2));
			foreach ($quotations2 as $key => $val) {
				if (oraclestrtotime($val['BATAS_VENDOR_HARGA']) > strtotime('now')) {
					$count++;
				}
			}
			$data['total_quotation'] = $count;

			$count = 0;
			$now = strtotime('now');
			foreach ((array) $quotations1 as $val) {
				$opening = $val['PTP_REG_OPENING_DATE'];
				$closing = $val['PTP_REG_CLOSING_DATE'];
				if(oraclestrtotime($closing) < $now && $now > oraclestrtotime($opening)) {
					$count++;
				}
			}
			foreach ($quotations2 as $key => $val) {
				if (oraclestrtotime($val['BATAS_VENDOR_HARGA']) < $now) {
					$count++;
				}
			}
			$data['total_submit_quotation'] = $count;
			
			$this->load->model('prc_auction_quo_header');
			$this->prc_auction_quo_header->where_vendor($this->session->userdata('VENDOR_NO'));
			$auction_nego = $this->prc_auction_quo_header->get(array('PAQH_OPEN_STATUS' => 1));
			$dt = array();
			if(count($auction_nego)>0){
				foreach ($auction_nego as $key => $row)
				{
					$PTM_NUMBER = $row['PTM_NUMBER'];
					$PAQH_ID = $row['PAQH_ID'];
					$sql = "SELECT COUNT(PRC_TENDER_ITEM.TIT_ID) as jumlah FROM PRC_TENDER_ITEM WHERE PRC_TENDER_ITEM.TIT_STATUS = '4' AND PRC_TENDER_ITEM.PAQH_ID = ? AND PRC_TENDER_ITEM.PTM_NUMBER = ?"; 
					$query = $this->db->query($sql, array($PAQH_ID, $PTM_NUMBER));
					$count = $query->row_array();
					if($count["JUMLAH"] > 0){
						$dt[] = $row;
					}
				}
				$auction_nego = $dt;	
			}
			$data['total_auction_negotiation'] = count($auction_nego);

			$this->prc_tender_vendor->join_prc_tender_main();
			$this->prc_tender_vendor->where_nego();
			$this->prc_tender_vendor->join_nego(false, array(1, 2));
			$this->prc_tender_vendor->where_ptv_is_nego();
			$invitations = (array) $this->prc_tender_vendor->ptv($this->session->userdata('VENDOR_NO'));
			// var_dump($invitations); die();
			$ptv = array();
			foreach ($invitations as $val) {
				if ($val['NEGO_END'] != '' && oraclestrtotime($val['NEGO_END']) >= oraclestrtotime('now')) {
					$ptv[$val['PTV_ID']] = $val;
				}
			}
			$data['total_negotiaion'] = count($ptv);

				$this->prc_chat->order_ptm(); 
			$pc = $this->prc_chat->get(array('VENDOR_NO'=>$this->session->userdata('VENDOR_NO'), 'NEXT_PROSES'=>0));
			$number_ptm = '';
			$pchat=array();
			foreach($pc as $p){
				if($p['PTM_NUMBER'] != $number_ptm){
					$pchat[]=$p;
				}
				$number_ptm = $p['PTM_NUMBER'];
			}
			$data['tot_chat'] = count($pchat);

			$this->load->model('po_header');
			$this->po_header->where_vndcode($this->session->userdata('VENDOR_NO'));
			$po_header = $this->po_header->get(array('RELEASE' => 1,'PO_NUMBER is not NULL'=>NULL));
			$dt = array();
			if(count($po_header)>0){
				foreach ($po_header as $key => $row)
				{
					$PTM_NUMBER = $row['PTM_NUMBER'];					
					$dt[] = $row;
				}
				$po_header = $dt;	
			}
			$data['total_tender_awarded'] = count($po_header);

			$showInvoice = $this->isShowInvoice($this->session->userdata('COMPANYID'));
			if($showInvoice){
				/* cari jumlah invoice yang unbilled */
				$this->load->model('ec_open_inv');
				$venno = $this->session->userdata['VENDOR_NO'];
				$unbilled_gr = $this->ec_open_inv->getMan($venno);
				$data['unbilled_gr'] = count($unbilled_gr);
			}
			$data['showInvoice'] = $showInvoice;
			$this->layout->render('vendor_dashboard', $data);
	}

	private function isShowInvoice($companyid){
		$showInvoice = array(
			2000,5000,7000
		);
		return in_array($companyid,$showInvoice);
	}

}

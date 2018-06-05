<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Create_po extends CI_Controller {

	// Controller Assign Contract
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
	}

	public function index() {
		$this->session->keep_flashdata('success');
		$this->session->keep_flashdata('warning');
		redirect('Create_po/view');
	}

	public function view() {
		// $this->authorization->roleCheck();
		$data['title'] = "Assign PR to Contract";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$data['success'] = $this->session->flashdata('success');
		$data['warning'] = $this->session->flashdata('warning');
		$this->layout->add_js('pages/list_assign_contract.js');
		$this->layout->render('list_assign_contract', $data);
	}

	public function get_datatable() {
		$this->load->model('prc_pr_item');
		$this->prc_pr_item->join_pr();
		$this->prc_pr_item->where_not_closed();
		$this->prc_pr_item->where_contract(1);
		$this->prc_pr_item->where_available();
		$this->prc_pr_item->where_qty();
		$this->prc_pr_item->distinct();
		$datatable = $this->prc_pr_item->get();
		$data = array('data' => $datatable);
		echo json_encode($data);
	}
/*	
	public function update_status() {
		$this->load->model('m_global');
		$data_post=$this->input->post();
		
		$sql="UPDATE PRC_TENDER_PEMENANG SET STATUS_PEMENANG=3,TGL_ACTION_PO=SYSDATE,PETUGAS_ID_P0='".$this->session->userdata('ID')."' WHERE ID_PEMENANG='".$data_post['id_pemenang']."'";
		$this->m_global->grid_view($sql);
		redirect(base_url('Create_po'));
	}
	
	public function get_data(){
		$posdata1=$this->input->post();
		$sql="SELECT * FROM (SELECT ID_DETAIL_PEMENANG,PEMENANG_ID,NO_ITEM_NOMAT,HARGA_ITEM,ROW_NUMBER() OVER (ORDER BY HARGA_ITEM DESC) BARIS  FROM PRC_TENDER_PEMENANG_ITEM)
		WHERE PEMENANG_ID='".$posdata1['id_pemenang']."'";
		$datatable = $this->m_global->array_view($sql);
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	public function ver_pemenang($n1) {
		// $this->authorization->roleCheck();
		$data['title'] = "Ceate PO";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/create_po.js');
		$this->load->model('m_global');
		$sql="SELECT ID_PEMENANG,PTM_NUMBER,RFQ,KODE_VENDOR,HARGA_TERAKHIR,	'' NAMA_VENDOR,STATUS_PEMENANG,STATUS_WINER,TGL_ACT_PEMENANG
		FROM PRC_TENDER_PEMENANG WHERE STATUS_PEMENANG=2 AND ID_PEMENANG=".$n1;
		$data['data']=$this->m_global->array_view($sql);
		//print_r($data['data']); exit();
		$this->layout->render('ver_po', $data);
	}

	public function data_detil($ptm_number) {
		redirect('Create_po/ver_pemenang/'.$ptm_number);
	}
//*/
	public function show($id = null,$ppr_plant = null) {
		$data['title'] = 'Pemilihan Vendor';
		$this->layout->add_js('pages/show_po.js');
		$this->load->model('prc_pr_item');
		$this->load->model('prc_contract_sync');

		$this->prc_pr_item->where_id($id);
		$this->prc_pr_item->join_pr();
		$this->prc_pr_item->join_group_plant();
		$item = $this->prc_pr_item->get();
		$data['item'] = $item[0];
		$data['id'] = $id;
		$data['ppr_plant'] = $ppr_plant;
		// var_dump($data);
		$this->prc_contract_sync->where_matnr($data['item']['PPI_NOMAT']);
		$this->prc_contract_sync->where_werks($ppr_plant);
		$pcs = $this->prc_contract_sync->get();
		$data['pcs'] = $pcs;
		// var_dump($data);
		// die();

		$this->layout->render('show', $data);
	}
	public function submit($id = null,$ppr_plant = null) {
		$this->load->model('prc_pr_item');
		$this->load->model('prc_contract_sync');
		$this->load->model('prc_tender_winner');

		$this->prc_pr_item->join_pr();
		$this->prc_pr_item->where_id($id);
		$item = $this->prc_pr_item->get();
		
		$data['item'] = $item[0];
		$data['id'] = $id;
		$data['title'] = 'Pembuatan PO';
		$data['ppr_plant'] = $ppr_plant;

		$assign = $this->input->post('assign');
		$jumlah = $this->input->post("jumlah".$assign);

		$this->prc_contract_sync->where_lifnr($assign);
		$this->prc_contract_sync->where_matnr($data['item']['PPI_NOMAT']);
		$this->prc_contract_sync->where_werks($ppr_plant);
		$pcs = $this->prc_contract_sync->get();
		$contract = $pcs[0];

		$this->load->library('sap_handler');
		$ebeln = $contract['EBELN'];
		$ebelp = $contract['EBELP'];
		$banfn = $data['item']['PPI_PRNO'];
		$bnfpo = $data['item']['PPI_PRITEM'];
		$lifnr = $assign;
		// var_dump(compact('ebeln', 'ebelp', 'banfn', 'bnfpo', 'lifnr'));
		$return = $this->sap_handler->assignPrContract($ebeln, $ebelp, $banfn, $bnfpo, $lifnr);
		// var_dump($return); exit();
		if ($return['E_MESSAGESX'] == 'SUCCESS') {
			$this->session->set_flashdata('success', $return['E_DESCX']);
		} else {
			$this->session->set_flashdata('warning', $return['E_DESCX']);
			redirect('Create_po/');
		}

		$used = $data['item']['PPI_QTY_USED'] + $jumlah;
		$this->prc_pr_item->update(array('PPI_QTY_USED' => $used), array('PPI_ID' => $id));

		$ptw_id = $this->prc_tender_winner->get_id();
		$ptw = array(
			'PTW_ID' => $ptw_id,
			'PPI_ID' => $item[0]['PPI_ID'],
			'PPI_PRNO' => $item[0]['PPI_PRNO'],
			// 'TIT_QUANTITY' => $item[0]['PPI_QUANTOPEN'] - $item[0]['PPI_QTY_USED'],
			'TIT_QUANTITY' => $jumlah,
			'PTV_VENDOR_CODE' => $pcs[0]['LIFNR'],
			'VENDOR_NAME' => $pcs[0]['NAME1'],
			'PQI_PRICE' => $pcs[0]['NETPR'],
			'PTV_RFQ_NO' => $pcs[0]['EBELN'],
			'COMPANY_ID' => $this->authorization->getCompanyId(),
			'PPI_DECMAT' => $item[0]['PPI_DECMAT'],
			'PTW_CREATED_AT' => date('d-M-Y g.i.s A'),
			'PTW_CREATED_BY' => $this->authorization->getEmployeeId(),
			'PPR_PGRP' => $data['item']['PPR_PGRP'],
			'PPR_PORG' => $data['item']['PPR_PORG'],
			'PPI_NOMAT' => $data['item']['PPI_NOMAT'],
			'EBELP' => $pcs[0]['EBELP'],
			);
		$this->prc_tender_winner->insert($ptw);
		redirect('Create_po/');
	}

}

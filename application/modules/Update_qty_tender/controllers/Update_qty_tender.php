<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Update_qty_tender extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
	}

	public function index() {
		$data['title'] = 'Update Quantity Tender';
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js("strTodatetime.js");
		$this->layout->add_js('pages/update_qty_tender.js');
		$this->layout->render('list', $data);
	}

	public function get_datatable() {
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_item');
		$this->prc_tender_main->join_latest_activity();
		$this->prc_tender_main->join_prep();
		
			$this->prc_tender_main->where_pgrp_in($this->session->userdata('PRGRP'));
			$this->prc_tender_main->proses_master_id(7);
		$datatable = (array) $this->prc_tender_main->get();
	
		foreach ($datatable as $key => $val) {
			if($val['MASTER_ID']==15){
				$rg=array();
				$pti = $this->prc_tender_item->ptm($val['PTM_NUMBER']);
				foreach ($pti as $value) {
					$rg[]=$value['TIT_STATUS'];				
				}
				$datatable[$key]['TIT_STATUS_GROUP']=$rg;
			}
		}
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	public function detail($id){
		$this->load->model('prc_tender_item_updateqty');
		$this->load->library('snippet');

		$data['title'] = 'Update Quantity Tender';
		$data['detail_ptm_snip'] = $this->snippet->detail_ptm($id, false, false, false);
		$data['detail_item'] = $this->snippet->detail_item_ptm($id,false,false,true);
		$data['ptm_number'] = $id;

			$this->prc_tender_item_updateqty->join_tender_item();
			$this->prc_tender_item_updateqty->join_pr_item();
			$this->prc_tender_item_updateqty->join_employee();
		$data['tit_update'] = $this->prc_tender_item_updateqty->get(array('PRC_TENDER_ITEM_UPDATEQTY.PTM_NUMBER'=>$id));
		
		$arr = array();
		foreach ($data['tit_update'] as $val) {
			$arr[$val['TIT_ID']]=$val['TIU_ID'];
		}
		$data['boleh_hapus']=$arr;

		$this->layout->add_js('pages/update_qty_tender.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('detail',$data);
	}

	public function save_bidding(){
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_item_updateqty');
		$this->load->library("file_operation");

		$ptm = $this->input->post("ptm_number");
		$master_id = $this->input->post("master_id");
		$tit_status = $this->input->post("tit_status");
		$qtyLama = $this->input->post("qtyLama");
		$qtyUpdate = $this->input->post("qtyUpdate");
		$note = $this->input->post("note");

		$item = array();
		foreach ($_FILES['file']['name'] as $key => $value) {
			$data['name'] = $_FILES['file']['name'][$key];
			$data['type'] = $_FILES['file']['type'][$key];
			$data['tmp_name'] = $_FILES['file']['tmp_name'][$key];
			$data['error'] = $_FILES['file']['error'][$key];
			$data['size'] = $_FILES['file']['size'][$key];
			$item[$key]['file'] = $data;
		}

		foreach ($qtyUpdate as $keyy => $value) {
			if(preg_match("/^[0-9,]+$/", $value)) 
				$value = str_replace(",", "", $value);
			$_FILES = $item[$keyy];
			
			$uploaded = $this->file_operation->upload(UPLOAD_PATH.'ece', $_FILES);
			if($qtyUpdate[$keyy]){
				$newQty = array();
				$newQty['PTM_NUMBER'] = $ptm;
				$newQty['STATUS_MASTER_ID'] = $master_id;
				$newQty['TIT_ID'] = $keyy;
				$newQty['TIT_STATUS'] = $tit_status[$keyy];
				$newQty['TIT_QTY'] = $qtyLama[$keyy];
				$newQty['TIT_QTY_UPDATE'] = $qtyUpdate[$keyy];
				if(!empty($uploaded['file']['file_name'])){
					$newQty['UPLOAD_FILE'] = $uploaded['file']['file_name'];
				}
				$newQty['NOTE'] = $note[$keyy];
				$newQty['USER_ACT'] = $this->session->userdata('ID');
				$newQty['TIME_ACT'] = date(timeformat());
				$this->prc_tender_item_updateqty->insert($newQty);	

				$s['TIT_QUANTITY'] = $qtyUpdate[$keyy];
				$w = array('TIT_ID'=>$keyy);
				$this->prc_tender_item->update($s, $w);		
			}
		}

		$this->session->set_flashdata('success', 'Data Berhasil Disimpan.');
		redirect('Update_qty_tender');
	}

	public function delete(){
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_item_updateqty');

		$id = $this->input->post('id');

		$tiu = $this->prc_tender_item_updateqty->get(array('TIU_ID'=>$id));
		$tiu = $tiu[0];

		$s['TIT_QUANTITY'] = $tiu['TIT_QTY'];
		$w = array('TIT_ID'=>$tiu['TIT_ID']);
		$this->prc_tender_item->update($s, $w);

		if ($this->prc_tender_item_updateqty->delete(array("TIU_ID" => $id))) {
			echo 'ok';
		}
	}
}

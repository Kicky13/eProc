<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Release_po_edit extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model('m_global');
	}

	public function index($cheat = false) {
		$data['title'] = "List Doc aanwizing";
		$data['cheat'] = $cheat;
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_validate_css();
		$this->layout->set_validate_js();
		$this->layout->add_js('pages/doc_po.js');		
		$this->layout->add_js("strTodatetime.js");
		$this->layout->render('list_pr', $data);
	}

	public function detail($id){
		$this->load->model('po_header');
        $this->po_header->where_po($id);
        $data['data_main'] = $this->po_header->get();
        $data['title'] = "Form Upload Doc PO ".$data['data_main'][0]['PO_NUMBER'];
        $data['id'] = $id;
		// echo "<pre>";
		// print_r($data);die;
        $this->layout->render('detail', $data);	

    }

    public function doSimpan(){
        $PO_ID = $this->input->post('PO_ID');
        $this->load->model('po_header');
        $DOC_PO 			= $_FILES['DOC_PO']['tmp_name'];
        $tes 				= dirname(__FILE__);
        $pet_pat 			= str_replace('application/modules/Doc_po/controllers', '', $tes);

        if (isset($_FILES) && !empty($_FILES['DOC_PO']['name'])) {
            $type = explode('.', $_FILES['DOC_PO']['name']);
            //if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
            $this->_myFile = "DOC_PO". $PO_ID . date('YmdHms') . "." . end($type);
            $this->_path = $pet_pat . 'upload/temp/' . $this->_myFile;
            if (move_uploaded_file($DOC_PO, $this->_path)) {
                $set_edit2['DOC_PO'] 	= $this->_myFile;
                $where_edit2['PO_ID'] = $PO_ID;
                $this->po_header->update($set_edit2, $where_edit2);
            }
            //}
        }
        redirect('Doc_po/listPO');
    }

    public function get_datatable() {
        $PRGRP = $this->session->userdata('PRGRP');

        $this->load->model('po_header');
        $this->load->model('po_detail');
        $this->load->model('prc_tender_main');

        $this->po_header->join_ptm_lp3();
        $datatable = $this->po_header->get();    
        $data = array();
        foreach ($datatable as $key => $value) {
            if (strpos($PRGRP, $value['PGRP']) !== false) {
                $this->po_detail->where_po($value['PO_ID']);
                $item = $this->po_detail->get(false);
                $datatable[$key]['nitem'] = count($item);
                $datatable[$key]['item'] = $item;
                $datatable[$key]['status_po'] = $this->po_header->get_status($value['IS_APPROVE']);
            }
        }


        $data = array('data' => isset($datatable)?$datatable:'');
        echo json_encode($data);
    }


    public function listPO(){
        //FILTER PGRP UDAH tinggal filter
        $data['title'] = "List Edit PO"; 
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $PRGRP = $this->session->userdata('PRGRP');

        $this->load->model('po_header');
        $this->load->model('po_detail');
        $this->load->model('prc_tender_main');
        // $this->po_header->where_approve();
        if($this->input->post()){
            $nopo = $this->input->post('nopo');
            $nolp3 = $this->input->post('nolp3');
            $namevendor = $this->input->post('namevendor');
            $kodevendor = $this->input->post('kodevendor');
            $release = $this->input->post('release');
            $pratender = $this->input->post('pratender');
            $data['nopo'] = $nopo;
            $data['namevendor'] = $namevendor;
            $data['kodevendor'] = $kodevendor;
            $data['release'] = $release;
            $data['pratender'] = $pratender;
            if(!empty($nopo)){
                $this->po_header->where_ponumber($nopo);
            }
            if(!empty($nolp3)){
                $this->po_header->where_lp3number($nolp3);
            }
            if(!empty($namevendor)){
                $this->po_header->where_vndname($namevendor);
            }
            if(!empty($kodevendor)){
                $this->po_header->where_vndcode($kodevendor);
            }
            if($release){
                $this->po_header->where_release($release);
            }
            if(!empty($pratender)){
                $this->po_header->where_pratender($pratender);
            }
        } else {
            // $this->po_header->where_release();
        }
        $this->po_header->where_po_null();
        $this->po_header->join_ptm_lp3();
        $data['data'] = $this->po_header->get();    
        foreach ($data['data'] as $key => $value) {
            if (strpos($PRGRP, $value['PGRP']) !== false) {
                $this->po_detail->where_po($value['PO_ID']);
                $item = $this->po_detail->get(false);
                $data['data'][$key]['nitem'] = count($item);
                $data['data'][$key]['item'] = $item;
                $data['data'][$key]['status_po'] = $this->po_header->get_status($value['IS_APPROVE']);
            }
        }
        $this->layout->add_js('pages/list_po.js');
        $this->layout->add_css('pages/list_po.css');
        $this->layout->render('list_po', $data);
    }



}
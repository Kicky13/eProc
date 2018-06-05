<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Etor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->library(array('ckeditor')); //library ckeditor diload
	}

	function editor($width,$height) {
    	//configure base path of ckeditor folder
		$this->ckeditor->basePath = 'http://10.15.5.150/dev/eproc/plugins/ckeditor/';
		$this->ckeditor-> config['toolbar'] = 'Full';
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor-> config['width'] = $width;
		$this->ckeditor-> config['height'] = $height;
	}

	public function index() {
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/etor.js');
		$data['title'] = 'Daftar E-Tor';
		$this->layout->render('index', $data);
	}

	public function indexApproval() {
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/etor.js');
		$data['title'] = 'Daftar Approval E-Tor';
		$this->layout->render('indexapproval', $data);
	}

	public function indexGambar() {
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/etor.js');
		$data['title'] = 'Daftar Gambar E-Tor';
		$this->layout->render('indexgambar', $data);
	}

	public function uploadGambar() {
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/etor.js');
		$data['title'] = 'Upload Gambar E-Tor';
		$this->layout->render('upload_gbr', $data);
	}

	public function create($pr = null) {
		// error_reporting(E_ALL);
		// echo $this->session->userdata('ID');die;
		
		// PR
		$isnottor = false;
		$this->load->model('v_header_pr');
		$this->load->model('adm_cctr');
		$this->load->model('adm_doctype_pengadaan');
		$this->load->model('adm_plant');
		$this->load->model('adm_employee');
		$this->load->model('etor_m');
		$this->load->library('sap_handler');

		//baru
		$data['prno'] = $pr;
		$this->load->helper(array('form', 'url'));
		$this->load->model('prc_purchase_requisition');
		$this->load->model('prc_pr_item');
		$this->load->model('prc_plan_doc');
		$this->load->model('com_mat_group');
		$data['pr'] = $this->prc_purchase_requisition->pr($pr);
		$items = $this->prc_pr_item->pr($pr);
		foreach ($items as $item) {
			$data['itemid'][$item['PPI_ID']] = $item;
			$item['matgrp'] = $this->com_mat_group->find($item['PPI_MATGROUP']);
			$data['items'][$item['PPI_ID']] = $item;
		}
		$this->prc_plan_doc->where_active();
		$data['docs'] = $this->prc_plan_doc->pr($pr);
		$data['docs'] = array_reverse($data['docs']);
		//baru
		
		// var_dump($this->session->userdata);
		$this->adm_cctr->where_kel_com($this->session->userdata('KEL_PRGRP'));
		$cctr = $this->adm_cctr->get();
		$cctr = array_build_key($cctr, 'CCTR');
		$doctype = $this->adm_doctype_pengadaan->get();
		$doctype = array_build_key($doctype, 'TYPE');
		$plant = $this->adm_plant->get();
		$plant = array_build_key($plant, 'PLANT_CODE');
		// echo "<pre>";
		// print_r($plant);die;

		$colom = array(
			'V_HEADER_PR.PPR_PRNO',
			'V_HEADER_PR.PPR_DOCTYPE',
			'V_HEADER_PR.PPR_DOC_CAT',
			'V_HEADER_PR.PPR_DEL',
			'V_HEADER_PR.PPR_PORG',
			'V_HEADER_PR.PPR_REQUESTIONER',
			'V_HEADER_PR.PPR_CREATED_BY',
			'V_HEADER_PR.PPR_STTVER',
			'V_HEADER_PR.PPR_STT_TOR',
			'V_HEADER_PR.PPR_STT_CLOSE',
			'V_HEADER_PR.PPR_DATE_RELEASE',
			'V_HEADER_PR.PPR_LAST_UPDATE',
			'V_HEADER_PR.PPR_PGRP',
			'V_HEADER_PR.PPR_ASSIGNEE',
			'V_HEADER_PR.PPI_PR_ASSIGN_TO',
			'V_HEADER_PR.PPI_TGL_ASSIGN',
			'V_HEADER_PR.PPR_PLANT',
			'V_HEADER_PR.DOC_UPLOAD_COUNTER',
			'V_HEADER_PR.DOC_UPLOAD_DATE',
			'V_HEADER_PR.BANPR',
			);
		$select_colom = implode(', ', $colom);
		$this->v_header_pr->select($select_colom);
		$this->v_header_pr->where_close(0);
		// var_dump($isnottor);
		if ($isnottor === true) {
			$this->v_header_pr->join_adm_pucrh_grp();
			$this->v_header_pr->where_tor(1);
			$this->v_header_pr->where_sttver(array(1,2));
			$this->v_header_pr->where_pgrp_in($this->session->userdata('PRGRP'));

		} else {
			$this->v_header_pr->join_pr_item();

			if($this->session->userdata('COMPANYID')=='3000' || $this->session->userdata('COMPANYID')=='4000'){ //PADANG and TONASA
				
				$emp = $this->adm_employee->get(array('ID'=>$this->session->userdata('ID')));

				$this->v_header_pr->where_requestioner($emp[0]['MKCCTR']);
			}else if ($this->session->userdata('COMPANYID')=='2000' || $this->session->userdata('COMPANYID')=='5000' || $this->session->userdata('COMPANYID')=='7000') { // GRESIK, INDONESIA Tbk, INDONESIA VO 

				$this->v_header_pr->join_mrpc();
				$this->v_header_pr->where_emp($this->session->userdata('ID'));				
			}

			$this->v_header_pr->where_tor(0);			
			$this->v_header_pr->where_sttver(array(1,2));
		}


		$data1 = $this->v_header_pr->get();
		// echo "<pre>";
		// print_r($data1);die;

		$data_table = array();
		foreach ($data1 as $line){
			$checkAdaTidak = $this->etor_m->getTorPr($line['PPR_PRNO']);
			if($line['BANPR']=="03" && count($checkAdaTidak)==0){
				$data_tbl = array();
				$data_tbl['PPR_PRNO'] 			= $line['PPR_PRNO']; 
				$data_tbl['PPR_DOCTYPE'] 		= $line['PPR_DOCTYPE'] . ' ' . (isset($doctype[$line['PPR_DOCTYPE']]) ? $doctype[$line['PPR_DOCTYPE']]['DESC'] : '');
				$data_tbl['PPR_DOC_CAT'] 		= $line['PPR_DOC_CAT'];
				$data_tbl['PPR_DEL'] 			= $line['PPR_DEL'];
				$data_tbl['PPR_PORG'] 			= $line['PPR_PORG'];
				$data_tbl['PPR_REQUESTIONER'] 	= isset($cctr[$line['PPR_REQUESTIONER']]) ? $cctr[$line['PPR_REQUESTIONER']]['LONG_DESC'] : '';
				// $data_tbl['PPR_REQUESTIONER'] 	= $line['PPR_REQUESTIONER'];
				$data_tbl['PPR_STTVER'] 		= $line['PPR_STTVER'];
				$data_tbl['PPR_CREATED_BY'] 	= $line['PPR_CREATED_BY'];
				$data_tbl['PPR_STT_TOR'] 		= $line['PPR_STT_TOR'];
				$data_tbl['PPR_STT_CLOSE'] 		= $line['PPR_STT_CLOSE'];
				$data_tbl['PPR_DATE_RELEASE'] 	= date('d-M-y', oraclestrtotime($line['PPR_DATE_RELEASE']));
				$data_tbl['PPR_LAST_UPDATE'] 	= $line['PPR_LAST_UPDATE'];
				$data_tbl['PPR_PGRP'] 			= $line['PPR_PGRP'];
				$data_tbl['PPI_EMPLOYEE_ID'] 	= $line['PPR_ASSIGNEE'];
				$data_tbl['PPI_USER_ASSIGN'] 	= $line['PPI_PR_ASSIGN_TO'];
				$data_tbl['PPI_TGL_ASSIGN'] 	= $line['PPI_TGL_ASSIGN'];
				$data_tbl['PPR_PLANT'] 			= $line['PPR_PLANT'] . ' ' . (isset($plant[$line['PPR_PLANT']]) ? $plant[$line['PPR_PLANT']]['PLANT_NAME'] : '');
				$data_tbl['DOC_UPLOAD_COUNTER'] = $line['DOC_UPLOAD_COUNTER'];
				$data_tbl['DOC_UPLOAD_DATE'] 	= betteroracledate(oraclestrtotime($line['DOC_UPLOAD_DATE']));
				// $data_tbl['HEADER_TEXT']		= $this->sap_handler->getprheadertext($line['PPR_PRNO']);

				$data_table[] = $data_tbl;
			}
		}

		$json_data = array('data' => (array) $data_table);
		$data['data_pr'] = $json_data;
		// End PR

		// echo "<pre>";
		// print_r($json_data);die;

		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		
		// $this->layout->add_js('plugins/ckeditor/ckeditor.js');
		$this->layout->add_js('pages/etor.js');
		$this->layout->add_css('pages/etor.css');

		$this->layout->add_js('plugins/jquery.maskedinput.js');
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		//refresh PR
		// $this->layout->add_js('pages/list_pr_etor.js');

		$this->load->model('adm_employee');
		$data['emp_data'] = $this->adm_employee->get();
		// print_r($data['emp_data']);die;
		$data['title'] = 'Buat E-Tor';
		// $this->layout->add_js('pages/vnd_management_job_list.js');
		// $this->layout->add_css('pages/vendor_management.css');
		$width = '100%';
		$height = '500px';
        $this->editor($width,$height); //plugin ckeditor di defenisikan pada halaman index

        $this->layout->render('form_approve_registration', $data);
    }

    public function edit($id, $pr) {
		// error_reporting(E_ALL);
		// echo $this->session->userdata('ID');die;
    	// die;
		// PR
    	$isnottor = false;
    	$this->load->model('v_header_pr');
    	$this->load->model('adm_cctr');
    	$this->load->model('adm_doctype_pengadaan');
    	$this->load->model('adm_plant');
    	$this->load->model('adm_employee');
    	$this->load->model('etor_m');
    	$this->load->library('sap_handler');

    	//baru
    	$data['prno'] = $pr;
    	$this->load->helper(array('form', 'url'));
    	$this->load->model('prc_purchase_requisition');
    	$this->load->model('prc_pr_item');
    	$this->load->model('prc_plan_doc');
    	$this->load->model('com_mat_group');
    	$data['pr'] = $this->prc_purchase_requisition->pr($pr);
    	$items = $this->prc_pr_item->pr($pr);
    	foreach ($items as $item) {
    		$data['itemid'][$item['PPI_ID']] = $item;
    		$item['matgrp'] = $this->com_mat_group->find($item['PPI_MATGROUP']);
    		$data['items'][$item['PPI_ID']] = $item;
    	}
    	$this->prc_plan_doc->where_active();
    	$data['docs'] = $this->prc_plan_doc->pr($pr);
    	$data['docs'] = array_reverse($data['docs']);
		//baru

		// var_dump($this->session->userdata);
    	$this->adm_cctr->where_kel_com($this->session->userdata('KEL_PRGRP'));
    	$cctr = $this->adm_cctr->get();
    	$cctr = array_build_key($cctr, 'CCTR');
    	$doctype = $this->adm_doctype_pengadaan->get();
    	$doctype = array_build_key($doctype, 'TYPE');
    	$plant = $this->adm_plant->get();
    	$plant = array_build_key($plant, 'PLANT_CODE');
		// echo "<pre>";
		// print_r($plant);die;

    	$colom = array(
    		'V_HEADER_PR.PPR_PRNO',
    		'V_HEADER_PR.PPR_DOCTYPE',
    		'V_HEADER_PR.PPR_DOC_CAT',
    		'V_HEADER_PR.PPR_DEL',
    		'V_HEADER_PR.PPR_PORG',
    		'V_HEADER_PR.PPR_REQUESTIONER',
    		'V_HEADER_PR.PPR_CREATED_BY',
    		'V_HEADER_PR.PPR_STTVER',
    		'V_HEADER_PR.PPR_STT_TOR',
    		'V_HEADER_PR.PPR_STT_CLOSE',
    		'V_HEADER_PR.PPR_DATE_RELEASE',
    		'V_HEADER_PR.PPR_LAST_UPDATE',
    		'V_HEADER_PR.PPR_PGRP',
    		'V_HEADER_PR.PPR_ASSIGNEE',
    		'V_HEADER_PR.PPI_PR_ASSIGN_TO',
    		'V_HEADER_PR.PPI_TGL_ASSIGN',
    		'V_HEADER_PR.PPR_PLANT',
    		'V_HEADER_PR.DOC_UPLOAD_COUNTER',
    		'V_HEADER_PR.DOC_UPLOAD_DATE',
    		'V_HEADER_PR.BANPR',
    		);
    	$select_colom = implode(', ', $colom);
    	$this->v_header_pr->select($select_colom);
    	$this->v_header_pr->where_close(0);
		// var_dump($isnottor);
    	if ($isnottor === true) {
    		$this->v_header_pr->join_adm_pucrh_grp();
    		$this->v_header_pr->where_tor(1);
    		$this->v_header_pr->where_sttver(array(1,2));
    		$this->v_header_pr->where_pgrp_in($this->session->userdata('PRGRP'));

    	} else {
    		$this->v_header_pr->join_pr_item();

			if($this->session->userdata('COMPANYID')=='3000' || $this->session->userdata('COMPANYID')=='4000'){ //PADANG and TONASA
				
				$emp = $this->adm_employee->get(array('ID'=>$this->session->userdata('ID')));

				$this->v_header_pr->where_requestioner($emp[0]['MKCCTR']);
			}else if ($this->session->userdata('COMPANYID')=='2000' || $this->session->userdata('COMPANYID')=='5000' || $this->session->userdata('COMPANYID')=='7000') { // GRESIK, INDONESIA Tbk, INDONESIA VO 

				$this->v_header_pr->join_mrpc();
				$this->v_header_pr->where_emp($this->session->userdata('ID'));				
			}

			$this->v_header_pr->where_tor(0);			
			$this->v_header_pr->where_sttver(array(1,2));
		}


		$data1 = $this->v_header_pr->get();
		// echo "<pre>";
		// print_r($data1);die;

		$data_table = array();
		foreach ($data1 as $line){
			$checkAdaTidak = $this->etor_m->getTorPr($line['PPR_PRNO']);
			if($line['BANPR']=="03" && count($checkAdaTidak)==0){
				$data_tbl = array();
				$data_tbl['PPR_PRNO'] 			= $line['PPR_PRNO']; 
				$data_tbl['PPR_DOCTYPE'] 		= $line['PPR_DOCTYPE'] . ' ' . (isset($doctype[$line['PPR_DOCTYPE']]) ? $doctype[$line['PPR_DOCTYPE']]['DESC'] : '');
				$data_tbl['PPR_DOC_CAT'] 		= $line['PPR_DOC_CAT'];
				$data_tbl['PPR_DEL'] 			= $line['PPR_DEL'];
				$data_tbl['PPR_PORG'] 			= $line['PPR_PORG'];
				$data_tbl['PPR_REQUESTIONER'] 	= isset($cctr[$line['PPR_REQUESTIONER']]) ? $cctr[$line['PPR_REQUESTIONER']]['LONG_DESC'] : '';
				// $data_tbl['PPR_REQUESTIONER'] 	= $line['PPR_REQUESTIONER'];
				$data_tbl['PPR_STTVER'] 		= $line['PPR_STTVER'];
				$data_tbl['PPR_CREATED_BY'] 	= $line['PPR_CREATED_BY'];
				$data_tbl['PPR_STT_TOR'] 		= $line['PPR_STT_TOR'];
				$data_tbl['PPR_STT_CLOSE'] 		= $line['PPR_STT_CLOSE'];
				$data_tbl['PPR_DATE_RELEASE'] 	= date('d-M-y', oraclestrtotime($line['PPR_DATE_RELEASE']));
				$data_tbl['PPR_LAST_UPDATE'] 	= $line['PPR_LAST_UPDATE'];
				$data_tbl['PPR_PGRP'] 			= $line['PPR_PGRP'];
				$data_tbl['PPI_EMPLOYEE_ID'] 	= $line['PPR_ASSIGNEE'];
				$data_tbl['PPI_USER_ASSIGN'] 	= $line['PPI_PR_ASSIGN_TO'];
				$data_tbl['PPI_TGL_ASSIGN'] 	= $line['PPI_TGL_ASSIGN'];
				$data_tbl['PPR_PLANT'] 			= $line['PPR_PLANT'] . ' ' . (isset($plant[$line['PPR_PLANT']]) ? $plant[$line['PPR_PLANT']]['PLANT_NAME'] : '');
				$data_tbl['DOC_UPLOAD_COUNTER'] = $line['DOC_UPLOAD_COUNTER'];
				$data_tbl['DOC_UPLOAD_DATE'] 	= betteroracledate(oraclestrtotime($line['DOC_UPLOAD_DATE']));
				// $data_tbl['HEADER_TEXT']		= $this->sap_handler->getprheadertext($line['PPR_PRNO']);

				$data_table[] = $data_tbl;
			}
		}

		$json_data = array('data' => (array) $data_table);
		$data['data_pr'] = $json_data;
		// End PR

		$width = '100%';
		$height = '500px';
        $this->editor($width,$height); //plugin ckeditor di defenisikan pada halaman index

        $this->layout->set_table_js();
        $this->layout->set_table_cs();

        // $this->layout->add_js('plugins/ckeditor/ckeditor.js');
        $this->layout->add_js('pages/etor.js');
        $this->layout->add_css('pages/etor.css');

        $this->layout->add_js('plugins/jquery.maskedinput.js');
        $this->layout->add_css('plugins/selectize/selectize.css');
        $this->layout->add_js('plugins/selectize/selectize.js');
        $this->layout->add_js('plugins/select2/select2.js');
        $this->layout->add_css('plugins/select2/select2.css');
        $this->layout->add_css('plugins/select2/select2-bootstrap.css');

		//refresh PR
		// $this->layout->add_js('pages/list_pr_etor.js');

        $this->load->model('adm_employee');
        $data['emp_data'] = $this->adm_employee->get();
        $data['tor_data'] = $this->adm_employee->getDetailTor($id);
        $data['emp_evaluator'] = $this->adm_employee->get(array('ID'=>$data['tor_data'][0]['PIC']));
		// echo "<pre>";print_r($data['tor_data']);die;
		// echo "<pre>";print_r($data['emp_evaluator']);die;
        $data['title'] = 'Edit E-Tor';
        $this->layout->render('edit', $data);
    }

    public function approve($id, $pr) {
		// error_reporting(E_ALL);
		// echo $this->session->userdata('ID');die;

		//baru
    	$data['prno'] = $pr;
    	$this->load->helper(array('form', 'url'));
    	$this->load->model('prc_purchase_requisition');
    	$this->load->model('prc_pr_item');
    	$this->load->model('prc_plan_doc');
    	$this->load->model('com_mat_group');
    	$data['pr'] = $this->prc_purchase_requisition->pr($pr);
    	$items = $this->prc_pr_item->pr($pr);
    	foreach ($items as $item) {
    		$data['itemid'][$item['PPI_ID']] = $item;
    		$item['matgrp'] = $this->com_mat_group->find($item['PPI_MATGROUP']);
    		$data['items'][$item['PPI_ID']] = $item;
    	}
    	$this->prc_plan_doc->where_active();
    	$data['docs'] = $this->prc_plan_doc->pr($pr);
    	$data['docs'] = array_reverse($data['docs']);
		//baru

    	$this->layout->set_table_js();
    	$this->layout->set_table_cs();

    	$this->layout->add_js('plugins/ckeditor/ckeditor.js');
    	$this->layout->add_js('pages/etor.js');

    	$this->layout->add_js('plugins/jquery.maskedinput.js');
    	$this->layout->add_css('plugins/selectize/selectize.css');
    	$this->layout->add_js('plugins/selectize/selectize.js');
    	$this->layout->add_js('plugins/select2/select2.js');
    	$this->layout->add_css('plugins/select2/select2.css');
    	$this->layout->add_css('plugins/select2/select2-bootstrap.css');


    	$this->load->model('adm_employee');
    	$data['emp_data'] = $this->adm_employee->get();
    	$data['tor_data'] = $this->adm_employee->getDetailTor($id);
    	$data['emp_evaluator'] = $this->adm_employee->get(array('ID'=>$data['tor_data'][0]['PIC']));
		// echo "<pre>";print_r($data['tor_data']);die;
    	$data['title'] = 'Approve E-Tor';
    	$this->layout->render('approve', $data);
    }

    public function getEmpname() 
    {
    	$this->load->model('adm_employee');
    	$veno = $this->input->post('veno');
    	$emp_data = $this->adm_employee->ambilData($veno);
    	$data = $emp_data[0];
		// print_r($data);die;
    	echo json_encode($data);
    }

    public function get_datatable() {
    	$this->load->model('adm_employee');
    	$idemp = $this->session->userdata('ID');
    	$data = array();
    	$datatable = $this->adm_employee->getListApp($idemp);
    	$data = array('data' => isset($datatable)?$datatable:'');
    	echo json_encode($data);
    }

    public function get_datatable_edit($id) {
    	$this->load->model('adm_employee');
    	$data = array();
    	$datatable = $this->adm_employee->getListAppEdit($id);
    	$data = array('data' => isset($datatable)?$datatable:'');
    	echo json_encode($data);
    }

    public function get_datatable_main() {
    	$this->load->model('adm_employee');
    	$idemp = $this->session->userdata('ID');
    	$data = array();
    	$datatable = $this->adm_employee->getListAppMain($idemp);
    	$data = array('data' => isset($datatable)?$datatable:'');
    	echo json_encode($data);
    }

    public function get_datatable_approval() {
    	$this->load->model('adm_employee');
    	$this->load->model('etor_m');
    	$idemp = $this->session->userdata('ID');
    	$data = array();
    	$datatable = $this->adm_employee->getListApproval($idemp);
    	$data = array('data' => isset($datatable)?$datatable:'');
    	echo json_encode($data);
    }

    public function get_datatable_gambar() {
    	$this->load->model('adm_employee');
    	$idemp = $this->session->userdata('ID');
    	$data = array();
    	$datatable = $this->adm_employee->getListGambar($idemp);
    	$data = array('data' => isset($datatable)?$datatable:'');
    	echo json_encode($data);
    }

    public function get_datatable_komen($id) {
    	$this->load->model('adm_employee');
    	$idemp = $this->session->userdata('ID');
    	$data = array();
    	$datatable = $this->adm_employee->getListAppKomentar($id);
    	$data = array('data' => isset($datatable)?$datatable:'');
    	echo json_encode($data);
    }

    public function doInsertEmp() {
		// error_reporting(E_ALL);
    	$this->load->model('etor_m');
    	$this->load->model('adm_employee');
    	$CREATED_BY = $this->session->userdata('ID');
    	$id_emp = $this->input->post('id_emp');
    	$ID_TOR = $this->input->post('ID_TOR');
    	$getData = $this->etor_m->getLastData();
		// print_r($getData);die;
    	if(count($getData)>0){
    		$ID_APP = $getData[0]->ID_APP+1;
    	} else {
    		$ID_APP = 1;
    	}

    	$data['ID_APP'] = $ID_APP;
    	$data['ID_EMP'] = $id_emp;
    	$data['ID_TOR'] = $ID_TOR;
    	$data['CREATED_BY'] = $CREATED_BY;

    	if($ID_TOR==""){
    		$setketerangan = $this->adm_employee->getListApp($CREATED_BY);
    		$data['ORDER_APPRV'] = (count($setketerangan)+1);
    		$this->etor_m->insert($data);
    	} else {
    		$setketerangan = $this->adm_employee->getListAppEdit($ID_TOR);
    		// echo count($setketerangan);
    		// print_r($setketerangan);
    		// die;
    		if(count($setketerangan)>2){
    			$data['ORDER_APPRV'] = (count($setketerangan)+1);
    			$this->etor_m->insert($data);
    		} else {
    			for ($i=1; $i < 4; $i++) { 
    				$mengisi_kosong = $this->etor_m->cekApprovalUrutan($ID_TOR, $i);
    				if(count($mengisi_kosong)>0){
    					// echo "if";
    				} else {
    					// echo "else";
    					$data['ORDER_APPRV'] = $i;
    					$this->etor_m->insert($data);
    					break;

    				}
    			}
    			// die;
    		}
    	}

    	if($data['ORDER_APPRV']==1 || $data['ORDER_APPRV']=="1"){
    		// echo "masuk if2";die;
    		$getData = $this->etor_m->getLastDataHolder();
    		if(count($getData)>0){
    			$ID_FLOW = $getData[0]->ID_FLOW+1;
    		} else {
    			$ID_FLOW = 1;
    		}

    		$data1['ID_FLOW'] = $ID_FLOW;
    		$data1['ID_EMP'] = $id_emp;
    		$data1['ID_TOR'] = $ID_TOR;
    		$data1['CREATED_BY'] = $CREATED_BY;

    		$this->etor_m->insertHolder($data1);
    	}


    	$data['status'] = 'success';
    	echo json_encode($data);
    }

    public function doDeleteEmp() {
    	$this->load->model('etor_m');
    	$ID_APP = $this->input->post('id_emp');
    	$where_edit['ID_APP'] = $ID_APP;
    	$this->etor_m->delete($where_edit);
    	$data['status'] = 'success';
    	echo json_encode($data);
    }

    public function doInsertMain() {
    	$this->load->model('adm_employee');
		// print_r( $this->input->post());die;
		// error_reporting(E_ALL);
    	$this->load->model('etor_m');
    	$CREATED_BY = $this->session->userdata('ID');
    	$ambilUnitKerja = $this->adm_employee->ambilData($CREATED_BY);
    	$getData = $this->etor_m->getLastDataMain();
		// print_r($getData);die;
    	if(count($getData)>0){
    		$ID_TOR = $getData[0]->ID_TOR+1;
    	} else {
    		$ID_TOR = 1;
    	}
    	$NO_PR = intval($this->input->post('NO_PR'));
    	$JENIS_TOR = $this->input->post('JENIS_TOR');
    	$LATAR_BELAKANG = $this->input->post('LATAR_BELAKANG');
    	$MAKSUD_TUJUAN = $this->input->post('MAKSUD_TUJUAN');
    	$PENJELASAN_APP = $this->input->post('PENJELASAN_APP');
    	$RUANG_LINGKUP = $this->input->post('RUANG_LINGKUP');
    	$PRODUK = $this->input->post('PRODUK');
    	$KUALIFIKASI = $this->input->post('KUALIFIKASI');
    	$TIME_FRAME = $this->input->post('TIME_FRAME');
    	$PROSES_BAYAR = null;
    	$IS_SUBMIT = $this->input->post('type');
    	$CREATED_AT = date("d-m-Y h:i:s");
    	$NO_TOR = $ID_TOR.'/TOR/'.$ambilUnitKerja[0]['MKCCTR'].'/'.date("m-Y");

    	$KOMEN = $this->input->post('KOMEN');
    	$PIC = $this->input->post('PIC');

    	$IS_SHOW1 = intval($this->input->post('IS_SHOW1'));
    	$IS_SHOW2 = intval($this->input->post('IS_SHOW2'));
    	$IS_SHOW3 = intval($this->input->post('IS_SHOW3'));
    	$IS_SHOW4 = intval($this->input->post('IS_SHOW4'));
    	$IS_SHOW5 = intval($this->input->post('IS_SHOW5'));
    	$IS_SHOW6 = intval($this->input->post('IS_SHOW6'));
    	$IS_SHOW7 = intval($this->input->post('IS_SHOW7'));

    	$data['ID_TOR'] = $ID_TOR;
    	$data['NO_PR'] = $NO_PR;
    	$data['JENIS_TOR'] = $JENIS_TOR;
    	$data['NO_TOR'] = $NO_TOR;
    	$data['LATAR_BELAKANG'] = $LATAR_BELAKANG;
    	
    	$data['MAKSUD_TUJUAN'] = $MAKSUD_TUJUAN;
    	$data['PENJELASAN_APP'] = $PENJELASAN_APP;
    	$data['RUANG_LINGKUP'] = $RUANG_LINGKUP;
    	$data['PRODUK'] = $PRODUK;
    	$data['KUALIFIKASI'] = $KUALIFIKASI;
    	$data['TIME_FRAME'] = $TIME_FRAME;
    	$data['PROSES_BAYAR'] = $PROSES_BAYAR;
    	$data['IS_SUBMIT'] = $IS_SUBMIT;
		// $data['UPDATED_AT'] = $CREATED_AT;
    	$data['CREATED_BY'] = $CREATED_BY;
    	$data['KOMEN'] = $KOMEN;
    	$data['PIC'] = $PIC;
    	$data['STATUS'] = 1;

    	$data['IS_SHOW1'] = $IS_SHOW1;
    	$data['IS_SHOW2'] = $IS_SHOW2;
    	$data['IS_SHOW3'] = $IS_SHOW3;
    	$data['IS_SHOW4'] = $IS_SHOW4;
    	$data['IS_SHOW5'] = $IS_SHOW5;
    	$data['IS_SHOW6'] = $IS_SHOW6;
    	$data['IS_SHOW7'] = $IS_SHOW7;
    	$this->etor_m->insertMain($data);

    	$data1['ID_TOR'] = $ID_TOR;
    	$data1['CREATED_AT'] = $CREATED_AT;
    	$this->etor_m->editDateMain1($data1);

    	$where_edit = $CREATED_BY;
    	$set_edit['ID_TOR'] = $ID_TOR;
    	$this->etor_m->updateSaved($set_edit, $where_edit);
    	$this->etor_m->updateHolderSaved($set_edit, $where_edit);

    	$ECE 			= $_FILES['ECE']['tmp_name'];
    	$LAIN 			= $_FILES['LAIN']['tmp_name'];
    	$BQ 			= $_FILES['BQ']['tmp_name'];
    	$tes 				= dirname(__FILE__);
    	$pet_pat 			= str_replace('application/modules/Etor/controllers', '', $tes);

		//echo $pet_pat;die;
    	if (isset($_FILES) && !empty($_FILES['ECE']['name'])) {
    		$type = explode('.', $_FILES['ECE']['name']);
    		if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "ECE".$CREATED_BY . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/etor/' . $this->_myFile;
                if (move_uploaded_file($ECE, $this->_path)) {
                	$set_edit2['ECE'] 	= $this->_myFile;
                	$where_edit2['ID_TOR'] = $ID_TOR;
                	$this->etor_m->updateMain($set_edit2, $where_edit2);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['LAIN']['name'])) {
        	$type = explode('.', $_FILES['LAIN']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "LAIN".$CREATED_BY . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/etor/' . $this->_myFile;
                if (move_uploaded_file($LAIN, $this->_path)) {
                	$set_edit3['LAIN'] 	= $this->_myFile;
                	$where_edit2['ID_TOR'] = $ID_TOR;
                	$this->etor_m->updateMain($set_edit3, $where_edit2);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['BQ']['name'])) {
        	$type = explode('.', $_FILES['BQ']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "BQ".$CREATED_BY . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/etor/' . $this->_myFile;
                if (move_uploaded_file($BQ, $this->_path)) {
                	$set_edit3['BQ'] 	= $this->_myFile;
                	$where_edit2['ID_TOR'] = $ID_TOR;
                	$this->etor_m->updateMain($set_edit3, $where_edit2);
                }
            }
        }

        if($IS_SUBMIT==1 || $IS_SUBMIT=="1"){
			// store to file
			        	// $this->m_pdf->pdf->SetHTMLHeader('
        	// 	<table width="100%">
        	// 		<tr>
        	// 			<td class="text-right"><img class="logo_dark" width="100" height="20" src="http://int-eprocurement.semenindonesia.com/eproc/static/images/logo/semen_indonesia_list.png" alt="Logo eProcurement PT. Semen Gresik Tbk."></td>
        	// 		</tr>
        	// 	</table>
        	// 	');

        	// $this->m_pdf->pdf->SetHTMLFooter(
        	// 	'
        	// 	<table width="100%">
        	// 		<tr>
        	// 			<td class="text-right">Page {PAGENO}/{nb}</td>
        	// 		</tr>
        	// 	</table>
        	// 	'
        	// 	);

        	// $html = $this->load->view('print1', $data, true);
        	// $this->m_pdf->pdf->WriteHTML(utf8_encode($html));
        	// $this->m_pdf->pdf->setTitle($data['title']);
        	// $this->m_pdf->pdf->Output($pet_pat . 'upload/etor/' .$data['title'].".pdf",'F');


        	$id = $ID_TOR;
        	$this->saveprinttor($id);

        	// kirim email
        	$id = $ID_TOR;
        	$tor_data = $this->adm_employee->getDetailTor($id);
        	$tor_approval_list = $this->adm_employee->getListAppMail($tor_data[0]['CREATED_BY'], $id);
        	$user['EMAIL'] = $tor_approval_list[0]['EMAIL'];
        	$user['status'] = 1;
        	$user['data']['ID_TOR'] = $ID_TOR;
        	$user['data']['NO_PR'] = $tor_data[0]['NO_PR'];
        	$user['data']['judul'] = $tor_data[0]['JENIS_TOR'];
        	$user['data']['buatan'] = $tor_data[0]['FULLNAME'];
        	$user['data']['NO_TOR'] = $tor_data[0]['NO_TOR'];
        	$user['data']['approval'] = $tor_approval_list[0]['FULLNAME'];
        	$user['data']['komen'] = $tor_data[0]['KOMEN'];
        	$user['data']['komen_appv'] = '';
        	$this->kirim_email_2($user);
    		// end kirim email

        	// INSERT KOMENT
        	$getData = $this->etor_m->getLastDataKomen();
        	if(count($getData)>0){
        		$ID_KOM = $getData[0]->ID_KOM+1;
        	} else {
        		$ID_KOM = 1;
        	}
        	$data2['ID_KOM'] = $ID_KOM;
        	$data2['ID_TOR'] = $ID_TOR;
        	$data2['ID_EMP'] = $CREATED_BY;
        	$data2['KOMEN'] = $KOMEN;
        	$this->etor_m->insertKomen($data2);
        	// END INSERT KOMENT

        	// $this->load->library('M_pdf');
        	// $data['title'] = "E_TOR".$id;
        	// $this->load->model('etor_m');
        	// $data['data_tor'] = $this->etor_m->getDetailTorPrint($id);
        	// $data['data_tor_appv'] = $this->etor_m->getDetailTorPrintApprove($id);
        	// $tes 				= dirname(__FILE__);
        	// $pet_pat 			= str_replace('application/modules/Etor/controllers', '', $tes);

        	// $set_edit4['TOR'] 	= $data['title'].".pdf";
        	// $where_edit2['ID_TOR'] = $id;
        	// $this->etor_m->updateMain($set_edit4, $where_edit2);

        	// include_once APPPATH.'helpers/dompdf/dompdf_config.inc.php';
        	// $html = $this->load->view('print_dom', $data, true);
        	// $dompdf = new DOMPDF();
        	// $dompdf->load_html($html);
        	// $dompdf->render();
        	// $gambar = '<img class="logo_dark" src="http://int-eprocurement.semenindonesia.com/eproc/static/images/logo/semen_indonesia_list.png" alt="Logo eProcurement PT. Semen Gresik Tbk.">';
        	// $image = "http://int-eprocurement.semenindonesia.com/eproc/static/images/logo/semen_indonesia_list.png";
        	// $canvas = $dompdf->get_canvas();
        	// $font = Font_Metrics::get_font("helvetica", "bold");
        	// $canvas->page_text(500, 750, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
        	// $output = $dompdf->output();
        	// file_put_contents($pet_pat . 'upload/etor/' .$data['title'].".pdf", $output);

			// end store tor
        }

        redirect('Etor/');

    }

    public function doInsertGambar() {
		// print_r( $this->input->post());die;
		// error_reporting(E_ALL);
    	$this->load->model('etor_m');
    	$CREATED_BY = $this->session->userdata('ID');
    	$getData = $this->etor_m->getLastDataGambar();
		// print_r($getData);die;
    	if(count($getData)>0){
    		$ID_GAM = $getData[0]->ID_GAM+1;
    	} else {
    		$ID_GAM = 1;
    	}

    	$GAMBAR 			= $_FILES['GAMBAR']['tmp_name'];
    	$tes 				= dirname(__FILE__);
    	$pet_pat 			= str_replace('application/modules/Etor/controllers', '', $tes);

    	if (isset($_FILES) && !empty($_FILES['GAMBAR']['name'])) {
    		$type = explode('.', $_FILES['GAMBAR']['name']);
    		if(end($type)=="jpg" || end($type)=="jpeg" || end($type)=="png"){
                //$this->_myFile = "GAMBAR".$CREATED_BY . date('YmdHms') . "." . end($type);//get terakhir
    			$this->_myFile = "GAMBAR_". date('YmdHms').'_'. $_FILES['GAMBAR']['name'];
    			$this->_path = $pet_pat . 'upload/etor/' . $this->_myFile;
    			if (move_uploaded_file($GAMBAR, $this->_path)) {
    				$data['ID_GAM'] = $ID_GAM;
    				$data['GAMBAR'] = $this->_myFile;
    				$data['CREATED_BY'] = $CREATED_BY;
    				$this->etor_m->insertGambar($data);
    			}
    		}
    	}

    	redirect('Etor/indexGambar');

    }


    public function doUpdateMain() {
		// print_r( $this->input->post());die;
		// error_reporting(E_ALL);
    	$this->load->model('etor_m');

    	$ID_TOR = $this->input->post('ID_TOR');
    	$NO_PR = intval($this->input->post('NO_PR'));
    	$JENIS_TOR = $this->input->post('JENIS_TOR');
    	$LATAR_BELAKANG = $this->input->post('LATAR_BELAKANG');
    	$MAKSUD_TUJUAN = $this->input->post('MAKSUD_TUJUAN');
    	$PENJELASAN_APP = $this->input->post('PENJELASAN_APP');
    	$RUANG_LINGKUP = $this->input->post('RUANG_LINGKUP');
    	$PRODUK = $this->input->post('PRODUK');
    	$KUALIFIKASI = $this->input->post('KUALIFIKASI');
    	$TIME_FRAME = $this->input->post('TIME_FRAME');
    	$PROSES_BAYAR = null;
    	$IS_SUBMIT = $this->input->post('type');
    	
    	$IS_SHOW1 = intval($this->input->post('IS_SHOW1'));
    	$IS_SHOW2 = intval($this->input->post('IS_SHOW2'));
    	$IS_SHOW3 = intval($this->input->post('IS_SHOW3'));
    	$IS_SHOW4 = intval($this->input->post('IS_SHOW4'));
    	$IS_SHOW5 = intval($this->input->post('IS_SHOW5'));
    	$IS_SHOW6 = intval($this->input->post('IS_SHOW6'));
    	$IS_SHOW7 = intval($this->input->post('IS_SHOW7'));
    	
    	$CREATED_AT = date("d-m-Y h:i:s");
    	// $NO_TOR = 'TOR/'.date("Y-m-d").'/'.$ID_TOR;
    	// $NO_TOR = $ID_TOR.'/TOR/UNITKERJA/'.date("m-Y");

    	$KOMEN = $this->input->post('KOMEN');
    	$PIC = $this->input->post('PIC');

    	// untuk yang reject
    	$this->load->model('adm_employee');
    	$tor_data = $this->adm_employee->getDetailTor($ID_TOR);
    	if($tor_data[0]['STATUS']==0 || $tor_data[0]['STATUS']=="0"){
    		$cekflow = $this->etor_m->cekApprovalFlow($ID_TOR);
    		$HOLDER = $cekflow[0]['ID_EMP'];
    		$set_edit1['ID_EMP'] = $HOLDER;		
    		$where_edit1['ID_TOR'] = $ID_TOR;
    		$this->etor_m->updateHolder($set_edit1, $where_edit1);
    	}
        // untuk yang reject


		// $where_edit['ID_TOR'] = $ID_TOR;
    	$set_edit['JENIS_TOR'] = $JENIS_TOR;
    	$set_edit['NO_PR'] = $NO_PR;
		// $where_edit['NO_TOR'] = $NO_TOR;
    	$set_edit['LATAR_BELAKANG'] = $LATAR_BELAKANG;


    	$set_edit['MAKSUD_TUJUAN'] = $MAKSUD_TUJUAN;
    	$set_edit['PENJELASAN_APP'] = $PENJELASAN_APP;
    	$set_edit['RUANG_LINGKUP'] = $RUANG_LINGKUP;
    	$set_edit['PRODUK'] = $PRODUK;
    	$set_edit['KUALIFIKASI'] = $KUALIFIKASI;
    	$set_edit['TIME_FRAME'] = $TIME_FRAME;
    	$set_edit['PROSES_BAYAR'] = $PROSES_BAYAR;
    	$set_edit['IS_SUBMIT'] = $IS_SUBMIT;		
    	$set_edit['KOMEN'] = $KOMEN;
    	if(!empty($PIC)){
    		$set_edit['PIC'] = $PIC;
    	}
    	$set_edit['REJECT_BY'] = null;
    	$set_edit['STATUS'] = 1;

    	$set_edit['IS_SHOW1'] = $IS_SHOW1;
    	$set_edit['IS_SHOW2'] = $IS_SHOW2;
    	$set_edit['IS_SHOW3'] = $IS_SHOW3;
    	$set_edit['IS_SHOW4'] = $IS_SHOW4;
    	$set_edit['IS_SHOW5'] = $IS_SHOW5;
    	$set_edit['IS_SHOW6'] = $IS_SHOW6;
    	$set_edit['IS_SHOW7'] = $IS_SHOW7;
    	// $set_edit['STATUS'] = 1;
    	$where_edit['ID_TOR'] = $ID_TOR;
    	$this->etor_m->updateMain($set_edit, $where_edit);

    	$data1['ID_TOR'] = $ID_TOR;
    	$data1['UPDATED_AT'] = $CREATED_AT;
    	$this->etor_m->editDateMain1($data1);


    	$ECE 			= $_FILES['ECE']['tmp_name'];
    	$LAIN 			= $_FILES['LAIN']['tmp_name'];
    	$BQ 			= $_FILES['BQ']['tmp_name'];
    	$tes 				= dirname(__FILE__);
    	$pet_pat 			= str_replace('application/modules/Etor/controllers', '', $tes);

		//echo $pet_pat;die;
    	if (isset($_FILES) && !empty($_FILES['ECE']['name'])) {
    		$type = explode('.', $_FILES['ECE']['name']);
    		if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "ECE".$CREATED_BY . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/etor/' . $this->_myFile;
                if (move_uploaded_file($ECE, $this->_path)) {
                	$set_edit2['ECE'] 	= $this->_myFile;
                	$where_edit2['ID_TOR'] = $ID_TOR;
                	$this->etor_m->updateMain($set_edit2, $where_edit2);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['LAIN']['name'])) {
        	$type = explode('.', $_FILES['LAIN']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "LAIN".$CREATED_BY . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/etor/' . $this->_myFile;
                if (move_uploaded_file($LAIN, $this->_path)) {
                	$set_edit3['LAIN'] 	= $this->_myFile;
                	$where_edit2['ID_TOR'] = $ID_TOR;
                	$this->etor_m->updateMain($set_edit3, $where_edit2);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['BQ']['name'])) {
        	$type = explode('.', $_FILES['BQ']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "BQ".$CREATED_BY . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/etor/' . $this->_myFile;
                if (move_uploaded_file($BQ, $this->_path)) {
                	$set_edit3['BQ'] 	= $this->_myFile;
                	$where_edit2['ID_TOR'] = $ID_TOR;
                	$this->etor_m->updateMain($set_edit3, $where_edit2);
                }
            }
        }

        if($IS_SUBMIT==1 || $IS_SUBMIT=="1"){
        	$id = $ID_TOR;
        	$this->saveprinttor($id);

        	// kirim email
        	$id = $ID_TOR;
        	$this->load->model('adm_employee');
        	$tor_data = $this->adm_employee->getDetailTor($id);
        	$tor_approval_list = $this->adm_employee->getListAppMail($tor_data[0]['CREATED_BY'], $id);
        	$user['EMAIL'] = $tor_approval_list[0]['EMAIL'];
        	$user['status'] = 1;
        	$user['data']['ID_TOR'] = $ID_TOR;
        	$user['data']['NO_PR'] = $tor_data[0]['NO_PR'];
        	$user['data']['judul'] = $tor_data[0]['JENIS_TOR'];
        	$user['data']['buatan'] = $tor_data[0]['FULLNAME'];
        	$user['data']['NO_TOR'] = $tor_data[0]['NO_TOR'];
        	$user['data']['approval'] = $tor_approval_list[0]['FULLNAME'];
        	$user['data']['komen'] = $tor_data[0]['KOMEN'];
        	$user['data']['komen_appv'] = '';
        	$this->kirim_email_2($user);
    		// end kirim email

    		// INSERT KOMENT
        	$getData = $this->etor_m->getLastDataKomen();
        	if(count($getData)>0){
        		$ID_KOM = $getData[0]->ID_KOM+1;
        	} else {
        		$ID_KOM = 1;
        	}
        	$data2['ID_KOM'] = $ID_KOM;
        	$data2['ID_TOR'] = $ID_TOR;
        	$data2['ID_EMP'] = $CREATED_BY;
        	$data2['KOMEN'] = $KOMEN;
        	$this->etor_m->insertKomen($data2);
        	// END INSERT KOMENT

        	// $this->load->library('M_pdf');
        	// $data['title'] = "E_TOR".$id;
        	// $this->load->model('etor_m');
        	// $data['data_tor'] = $this->etor_m->getDetailTorPrint($id);
        	// $data['data_tor_appv'] = $this->etor_m->getDetailTorPrintApprove($id);
        	// $tes 				= dirname(__FILE__);
        	// $pet_pat 			= str_replace('application/modules/Etor/controllers', '', $tes);

        	// $set_edit4['TOR'] 	= $data['title'].".pdf";
        	// $where_edit2['ID_TOR'] = $id;
        	// $this->etor_m->updateMain($set_edit4, $where_edit2);

        	// include_once APPPATH.'helpers/dompdf/dompdf_config.inc.php';
        	// $html = $this->load->view('print_dom', $data, true);
        	// $dompdf = new DOMPDF();
        	// $dompdf->load_html($html);
        	// $dompdf->render();
        	// $gambar = '<img class="logo_dark" src="http://int-eprocurement.semenindonesia.com/eproc/static/images/logo/semen_indonesia_list.png" alt="Logo eProcurement PT. Semen Gresik Tbk.">';
        	// $image = "http://int-eprocurement.semenindonesia.com/eproc/static/images/logo/semen_indonesia_list.png";
        	// $canvas = $dompdf->get_canvas();
        	// $font = Font_Metrics::get_font("helvetica", "bold");
        	// $canvas->page_text(500, 750, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
        	// $output = $dompdf->output();
        	// file_put_contents($pet_pat . 'upload/etor/' .$data['title'].".pdf", $output);
			// end store tor
        }

        redirect('Etor/');

    }

    public function doUpdateApprove() {
		// echo "<pre>";
		// print_r( $this->input->post());die;
		// error_reporting(E_ALL);
    	$this->load->model('etor_m');

    	$ID_EMP = $this->session->userdata('ID');
    	$ID_TOR = $this->input->post('ID_TOR');
    	$IS_SUBMIT = $this->input->post('type');
    	$KOMEN = $this->input->post('KOMEN');
    	// $CREATED_AT = date("d-m-Y h:i:s");Yd-m-Y h:i:s
    	$CREATED_AT = date("d-m-Y h:i:s");
    	$cekflow = $this->etor_m->cekApprovalFlow($ID_TOR);
    	// echo "<pre>";
    	// echo $ID_TOR;
    	// echo $IS_SUBMIT;
    	// print_r($cekflow);die;
    	$where_edit['ID_TOR'] = $ID_TOR;
    	if($IS_SUBMIT==0 || $IS_SUBMIT=="0"){ //reject
    		$STATUS = 0;
    		$set_edit2['IS_SUBMIT'] = $STATUS;
    		$set_edit2['REJECT_BY'] = $ID_EMP;
    		$HOLDER = $cekflow[0]['CREATED_BY'];

    		// $set_edit1['ID_EMP'] = $HOLDER;		
    		// $where_edit1['ID_TOR'] = $ID_TOR;
    		// $this->etor_m->updateHolder($set_edit1, $where_edit1);

    		// $where_edit2['ID_TOR'] = $ID_TOR;
    		// $this->etor_m->deleteHolder($where_edit1);
    		// $this->etor_m->deleteApproval($where_edit1);

    		$set_edit['IS_APPROVE'] = null;		
    		$set_edit['KOMEN'] = $KOMEN;		
    		$set_edit['APPROVED_AT'] = null;		
    		// $where_edit2['ID_EMP'] = $ID_EMP;
    		$this->etor_m->update($set_edit, $where_edit);

    		// kirim email
    		$id = $ID_TOR;
    		$this->load->model('adm_employee');
    		$tor_data = $this->adm_employee->getDetailTor($id);
    		$tor_approval_list = $this->adm_employee->find($ID_EMP);
    		$user['EMAIL'] = $tor_data[0]['EMAIL'];
    		$user['status'] = $STATUS;
    		$user['data']['ID_TOR'] = $ID_TOR;
    		$user['data']['NO_PR'] = $tor_data[0]['NO_PR'];
    		$user['data']['judul'] = $tor_data[0]['JENIS_TOR'];
    		$user['data']['buatan'] = $tor_data[0]['FULLNAME'];
    		$user['data']['NO_TOR'] = $tor_data[0]['NO_TOR'];
    		$user['data']['approval'] = $tor_approval_list['FULLNAME'];
    		$user['data']['komen'] = $tor_data[0]['KOMEN'];
    		$user['data']['komen_appv'] = $KOMEN;
    		$this->kirim_email_2($user);
    		// end kirim email

    		// INSERT KOMENT
    		$getData = $this->etor_m->getLastDataKomen();
    		if(count($getData)>0){
    			$ID_KOM = $getData[0]->ID_KOM+1;
    		} else {
    			$ID_KOM = 1;
    		}
    		$data1['ID_KOM'] = $ID_KOM;
    		$data1['ID_TOR'] = $ID_TOR;
    		$data1['ID_EMP'] = $ID_EMP;
    		$data1['KOMEN'] = $KOMEN;
    		$this->etor_m->insertKomen($data1);
        	// END INSERT KOMENT

    		$set_edit2['REJECT_REASON'] = $KOMEN."(".$tor_approval_list['FULLNAME'].")";
    		$set_edit2['NO_PR'] = '';

    	} else { //approve
    		// echo "<pre>";
    		// print_r($cekflow);die;
    		$STATUS = $cekflow[0]['ORDER_APPRV'];
    		if(count($cekflow)>1){
    			$HOLDER = $cekflow[1]['ID_EMP'];
    		} else {
    			$HOLDER = $cekflow[0]['CREATED_BY'];    			
    		}

    		// echo $HOLDER;die;
    		$set_edit['IS_APPROVE'] = $IS_SUBMIT;		
    		$set_edit['KOMEN'] = $KOMEN;		
    		$where_edit2['ID_EMP'] = $ID_EMP;
    		$this->etor_m->update($set_edit, $where_edit2);

    		$data1['ID_TOR'] = $ID_TOR;
    		$data1['ID_EMP'] = $ID_EMP;
    		$data1['APPROVED_AT'] = $CREATED_AT;
    		$this->etor_m->editDateApprove($data1);

    		// kirim email
    		$id = $ID_TOR;
    		$this->load->model('adm_employee');
    		$tor_data = $this->adm_employee->getDetailTor($id);
    		$NO_PR = $tor_data[0]['NO_PR'];

    		$tor_approval_list = $this->adm_employee->find($HOLDER);
    		$user['EMAIL'] = $tor_approval_list['EMAIL'];
    		$user['status'] = $STATUS;
    		$user['data']['ID_TOR'] = $ID_TOR;
    		$user['data']['NO_PR'] = $tor_data[0]['NO_PR'];
    		$user['data']['judul'] = $tor_data[0]['JENIS_TOR'];
    		$user['data']['buatan'] = $tor_data[0]['FULLNAME'];
    		$user['data']['NO_TOR'] = $tor_data[0]['NO_TOR'];
    		$user['data']['approval'] = $tor_approval_list['FULLNAME'];
    		$user['data']['komen'] = $tor_data[0]['KOMEN'];
    		$user['data']['komen_appv'] = $KOMEN;
    		$this->kirim_email_2($user);
    		// end kirim email

    		if($HOLDER == $tor_data[0]['CREATED_BY']){
    			// ke sap
    			$this->load->library('sap_handler');
    			$this->sap_handler->torPr($NO_PR);
	    		// end sap

    			// matching tor approval terakhir
    			$this->doUpdateTORPR($ID_TOR, $NO_PR);
    			// matching tor approval terakhir
    		}

    		// INSERT KOMENT
    		$getData = $this->etor_m->getLastDataKomen();
    		if(count($getData)>0){
    			$ID_KOM = $getData[0]->ID_KOM+1;
    		} else {
    			$ID_KOM = 1;
    		}
    		$data2['ID_KOM'] = $ID_KOM;
    		$data2['ID_TOR'] = $ID_TOR;
    		$data2['ID_EMP'] = $ID_EMP;
    		$data2['KOMEN'] = $KOMEN;
    		$this->etor_m->insertKomen($data2);
        	// END INSERT KOMENT
    	}

    	$set_edit2['STATUS'] = $STATUS;		
    	$this->etor_m->updateMain($set_edit2, $where_edit);

    	$set_edit1['ID_EMP'] = $HOLDER;		
    	$where_edit1['ID_TOR'] = $ID_TOR;
    	$this->etor_m->updateHolder($set_edit1, $where_edit1);

    	redirect('Etor/indexApproval');

    }

    public function uploadgambarCKEeditor() {
    	$upload 			= $_FILES['upload']['name'];
    	$tes 				= dirname(__FILE__);
    	$pet_pat 			= str_replace('application/modules/Etor/controllers', '', $tes);

		//echo $pet_pat;die;
    	if (isset($_FILES) && !empty($_FILES['upload']['name'])) {
    		$type = explode('.', $_FILES['upload']['name']);
    		if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "upload".$CREATED_BY . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/etor/' . $this->_myFile;
                if (move_uploaded_file($upload, $this->_path)) {
                }
            }
        }
    }

    public function matchingPRTOR($id) {
    	// error_reporting(E_ALL);
    	$isnottor = false;
    	$this->load->model('v_header_pr');
    	$this->load->model('adm_cctr');
    	$this->load->model('adm_doctype_pengadaan');
    	$this->load->model('adm_plant');
    	$this->load->model('adm_employee');
    	$this->load->model('etor_m');
    	$this->load->library('sap_handler');

		// var_dump($this->session->userdata);
    	$this->adm_cctr->where_kel_com($this->session->userdata('KEL_PRGRP'));
    	$cctr = $this->adm_cctr->get();
    	$cctr = array_build_key($cctr, 'CCTR');
    	$doctype = $this->adm_doctype_pengadaan->get();
    	$doctype = array_build_key($doctype, 'TYPE');
    	$plant = $this->adm_plant->get();
    	$plant = array_build_key($plant, 'PLANT_CODE');
		// echo "<pre>";
		// print_r($plant);die;

    	$colom = array(
    		'V_HEADER_PR.PPR_PRNO',
    		'V_HEADER_PR.PPR_DOCTYPE',
    		'V_HEADER_PR.PPR_DOC_CAT',
    		'V_HEADER_PR.PPR_DEL',
    		'V_HEADER_PR.PPR_PORG',
    		'V_HEADER_PR.PPR_REQUESTIONER',
    		'V_HEADER_PR.PPR_CREATED_BY',
    		'V_HEADER_PR.PPR_STTVER',
    		'V_HEADER_PR.PPR_STT_TOR',
    		'V_HEADER_PR.PPR_STT_CLOSE',
    		'V_HEADER_PR.PPR_DATE_RELEASE',
    		'V_HEADER_PR.PPR_LAST_UPDATE',
    		'V_HEADER_PR.PPR_PGRP',
    		'V_HEADER_PR.PPR_ASSIGNEE',
    		'V_HEADER_PR.PPI_PR_ASSIGN_TO',
    		'V_HEADER_PR.PPI_TGL_ASSIGN',
    		'V_HEADER_PR.PPR_PLANT',
    		'V_HEADER_PR.DOC_UPLOAD_COUNTER',
    		'V_HEADER_PR.DOC_UPLOAD_DATE',
    		);
    	$select_colom = implode(', ', $colom);
    	$this->v_header_pr->select($select_colom);
    	$this->v_header_pr->where_close(0);
		// var_dump($isnottor);
    	if ($isnottor === true) {
    		$this->v_header_pr->join_adm_pucrh_grp();
    		$this->v_header_pr->where_tor(1);
    		$this->v_header_pr->where_sttver(array(1,2));
    		$this->v_header_pr->where_pgrp_in($this->session->userdata('PRGRP'));

    	} else {
    		$this->v_header_pr->join_pr_item();

			if($this->session->userdata('COMPANYID')=='3000' || $this->session->userdata('COMPANYID')=='4000'){ //PADANG and TONASA
				
				$emp = $this->adm_employee->get(array('ID'=>$this->session->userdata('ID')));

				$this->v_header_pr->where_requestioner($emp[0]['MKCCTR']);
			}else if ($this->session->userdata('COMPANYID')=='2000' || $this->session->userdata('COMPANYID')=='5000' || $this->session->userdata('COMPANYID')=='7000') { // GRESIK, INDONESIA Tbk, INDONESIA VO 

				$this->v_header_pr->join_mrpc();
				$this->v_header_pr->where_emp($this->session->userdata('ID'));				
			}

			$this->v_header_pr->where_tor(0);			
			$this->v_header_pr->where_sttver(array(1,2));
		}


		$data1 = $this->v_header_pr->get();
		// echo "<pre>";
		// print_r($data1);die;

		$data_table = array();
		foreach ($data1 as $line){
			$data_tbl = array();
			$data_tbl['PPR_PRNO'] 			= $line['PPR_PRNO']; 
			$data_tbl['PPR_DOCTYPE'] 		= $line['PPR_DOCTYPE'] . ' ' . (isset($doctype[$line['PPR_DOCTYPE']]) ? $doctype[$line['PPR_DOCTYPE']]['DESC'] : '');
			$data_tbl['PPR_DOC_CAT'] 		= $line['PPR_DOC_CAT'];
			$data_tbl['PPR_DEL'] 			= $line['PPR_DEL'];
			$data_tbl['PPR_PORG'] 			= $line['PPR_PORG'];
			$data_tbl['PPR_REQUESTIONER'] 	= isset($cctr[$line['PPR_REQUESTIONER']]) ? $cctr[$line['PPR_REQUESTIONER']]['LONG_DESC'] : '';
			// $data_tbl['PPR_REQUESTIONER'] 	= $line['PPR_REQUESTIONER'];
			$data_tbl['PPR_STTVER'] 		= $line['PPR_STTVER'];
			$data_tbl['PPR_CREATED_BY'] 	= $line['PPR_CREATED_BY'];
			$data_tbl['PPR_STT_TOR'] 		= $line['PPR_STT_TOR'];
			$data_tbl['PPR_STT_CLOSE'] 		= $line['PPR_STT_CLOSE'];
			$data_tbl['PPR_DATE_RELEASE'] 	= date('d-M-y', oraclestrtotime($line['PPR_DATE_RELEASE']));
			$data_tbl['PPR_LAST_UPDATE'] 	= $line['PPR_LAST_UPDATE'];
			$data_tbl['PPR_PGRP'] 			= $line['PPR_PGRP'];
			$data_tbl['PPI_EMPLOYEE_ID'] 	= $line['PPR_ASSIGNEE'];
			$data_tbl['PPI_USER_ASSIGN'] 	= $line['PPI_PR_ASSIGN_TO'];
			$data_tbl['PPI_TGL_ASSIGN'] 	= $line['PPI_TGL_ASSIGN'];
			$data_tbl['PPR_PLANT'] 			= $line['PPR_PLANT'] . ' ' . (isset($plant[$line['PPR_PLANT']]) ? $plant[$line['PPR_PLANT']]['PLANT_NAME'] : '');
			$data_tbl['DOC_UPLOAD_COUNTER'] = $line['DOC_UPLOAD_COUNTER'];
			$data_tbl['DOC_UPLOAD_DATE'] 	= betteroracledate(oraclestrtotime($line['DOC_UPLOAD_DATE']));
			// $data_tbl['HEADER_TEXT']		= $this->sap_handler->getprheadertext($line['PPR_PRNO']);
			
			$data_table[] = $data_tbl;
		}

		$json_data = array('data' => (array) $data_table);
		$data['title'] = "Matching E-TOR dengan PR";
		$data['data_pr'] = $json_data;
		$data['tor_data'] = $this->adm_employee->getDetailTor($id);
		$data['tor_data_appv'] = $this->etor_m->getDetailTorPrintApproved($id);
		// echo "<pre>";
		// print_r($data);die;
		$this->layout->add_js('plugins/ckeditor/ckeditor.js');
		$this->layout->add_js('pages/etor.js');

		$this->layout->add_js('plugins/jquery.maskedinput.js');
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');

		$this->layout->render('matching', $data);
	}

	public function doUpdateTORPR($ID_TOR, $NO_PR) {
		$this->saveprinttor($ID_TOR);
		$this->load->model('etor_m');

		$set_edit['NO_PR'] = $NO_PR;
		$set_edit['IS_SUBMIT_PR'] = 1;
		$where_edit['ID_TOR'] = $ID_TOR;
		$this->etor_m->updateMain($set_edit, $where_edit);


		$id = $ID_TOR;
		$data['title'] = "E_TOR".$id;
		$this->saveprinttor($id);
		$tes 				= dirname(__FILE__);
		$pet_pat 			= str_replace('application/modules/Etor/controllers', '', $tes);
		copy($pet_pat . 'upload/etor/' .$data['title'].".pdf", $pet_pat . 'upload/ppm_document/' .$data['title'].".pdf");

		// start upload file
		$this->load->library("file_operation");
		$this->load->model('adm_mrpc');

		$this->load->model('com_mat_group');
		$this->load->model('prc_item_verify');
		$this->load->model('prc_plan_doc');
		$this->load->model('prc_pr_item');
		$this->load->model('prc_pr_item');
		$this->load->model('prc_purchase_requisition');

		$this->load->model('adm_cctr');

		$this->prc_item_verify->where_is_doc(1);
		$data['verif'] = $this->prc_item_verify->pr($NO_PR);
		$this->adm_cctr->where_kel_com($this->session->userdata('KEL_PRGRP'));
		$cctr = $this->adm_cctr->get();
		$data['cctr'] = array_build_key($cctr, 'CCTR');

		$data['success'] = false;
		$data['warning'] = false;

		$this->load->model('adm_employee');
		$tor_data = $this->adm_employee->getDetailTor($id);
		//DIGANTI 0 KARENA ADA TAMBAHAN DOKUMEN BQ

		$kategori=1;
		$upload_doc = $tor_data[0]['TOR'];
		copy($pet_pat . 'upload/etor/' .$upload_doc, $pet_pat . 'upload/ppm_document/' .$upload_doc);
		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Upload Dokumen Pengadaan','UPLOAD',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$items = $this->prc_pr_item->pr($NO_PR);
		foreach ($items as $key) {
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_sap/store_tor','prc_plan_doc','update',$setppd,$whereppd);
			//--END LOG DETAIL--//

			$new_id = $this->prc_plan_doc->get_id();
			$ppd = array(
				'PPD_ID' => $new_id,
				'PPD_PRNO' => $NO_PR,
				'PPD_CATEGORY' => $kategori,
				'PPD_DESCRIPTION' => null,
				'PPD_FILE_NAME' => $upload_doc,
				'PPD_CREATED_AT' => date('d-M-Y g.i.s A'),
				'PPD_CREATED_BY' => $this->session->userdata['FULLNAME'],
				'PPI_ID' => $key['PPI_ID'],
				'PPD_STATUS' => '1',
				);
			$junk = $this->prc_plan_doc->insert($ppd);

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_sap/store_tor','prc_plan_doc','insert',$ppd);
			//--END LOG DETAIL--//
		}				
		// end upload file


		// start store_tor_submit
		$this->load->model('prc_purchase_requisition');
		$pr = $NO_PR;
		$listpr = $this->prc_purchase_requisition->pr($pr);
			// var_dump($listpr);exit();
		$counter = $listpr['DOC_UPLOAD_COUNTER'] + 1;

		$where = array('PPR_PRNO' => $pr);
		$set = array(
			'BANPR' => '05',
			'PPR_ASSIGNEE' => $this->session->userdata('ID'),
			'PPR_STT_TOR' => '1', 
			'DOC_UPLOAD_COUNTER' => $counter, 
			'DOC_UPLOAD_DATE' => date('d-M-Y g.i.s A')
			);
		$this->prc_purchase_requisition->update($set, $where);
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Upload Dokumen Pengadaan','SUBMIT',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Procurement_sap/store_tor_submit','prc_purchase_requisition','update',$set,$where);
		//--END LOG DETAIL--// 
		// end store_tor_submit
		$success = true;
		return $success;
	}

	public function printtor2($id) {
		// print_r( $this->input->post());die;
		// error_reporting(E_ALL);
		$this->load->library('M_pdf');
		$data['title'] = "E_TOR".$id;
		$this->load->model('etor_m');
		$data['data_tor'] = $this->etor_m->getDetailTorPrint($id);
		$data['data_tor_appv'] = $this->etor_m->getDetailTorPrintApprove($id);

    	// echo "<pre>";
    	// print_r($data);die;
		$this->m_pdf->pdf->SetHTMLHeader('
			<table width="100%">
				<tr>
					<td class="text-right"><img class="logo_dark" width="100" height="20" src="http://int-eprocurement.semenindonesia.com/eproc/static/images/logo/semen_indonesia_list.png" alt="Logo eProcurement PT. Semen Gresik Tbk."></td>
				</tr>
			</table>
			');

		$this->m_pdf->pdf->SetHTMLFooter(
			'
			<table width="100%">
				<tr>
					<td class="text-right">Page {PAGENO}/{nb}</td>
				</tr>
			</table>
			'
			);

		$html = $this->load->view('print1', $data, true);
		$this->m_pdf->pdf->WriteHTML(utf8_encode($html));
		$this->m_pdf->pdf->setTitle($data['title']);

		$this->m_pdf->pdf->Output($data['title'].".pdf",'I');

    	// $tes 				= dirname(__FILE__);
    	// $pet_pat 			= str_replace('application/modules/Etor/controllers', '', $tes);

    	// $this->m_pdf->pdf->Output($pet_pat . 'upload/etor/' .$data['title'].".pdf",'F');

	}

	public function savetor($id) {
		// print_r( $this->input->post());die;
		// error_reporting(E_ALL);
		$this->load->library('M_pdf');
		$data['title'] = "E_TOR".$id;
		$this->load->model('etor_m');
		$data['data_tor'] = $this->etor_m->getDetailTorPrint($id);
		$data['data_tor_appv'] = $this->etor_m->getDetailTorPrintApprove($id);

    	// echo "<pre>";
    	// print_r($data);die;
		$this->m_pdf->pdf->SetHTMLHeader('
			<table width="100%">
				<tr>
					<td class="text-right"><img class="logo_dark" width="100" height="20" src="http://int-eprocurement.semenindonesia.com/eproc/static/images/logo/semen_indonesia_list.png" alt="Logo eProcurement PT. Semen Gresik Tbk."></td>
				</tr>
			</table>
			');

		$this->m_pdf->pdf->SetHTMLFooter(
			'
			<table width="100%">
				<tr>
					<td class="text-right">Page {PAGENO}/{nb}</td>
				</tr>
			</table>
			'
			);

		$html = $this->load->view('print_dom', $data, true);
		$this->m_pdf->pdf->WriteHTML($html);
		$this->m_pdf->pdf->setTitle($data['title']);

		// $this->m_pdf->pdf->Output($data['title'].".pdf",'I');

		$set_edit2['TOR'] 	= $data['title'].".pdf";
		$where_edit2['ID_TOR'] = $id;
		$this->etor_m->updateMain($set_edit2, $where_edit2);

		$tes 				= dirname(__FILE__);
		$pet_pat 			= str_replace('application/modules/Etor/controllers', '', $tes);

		$this->m_pdf->pdf->Output($pet_pat . 'upload/etor/' .$data['title'].".pdf",'F');

		$success = true;
		return $success;

	}

	public function printtor($id) {
		// print_r( $this->input->post());die;
		// error_reporting(E_ALL);
		$this->load->model('etor_m');
		$data['data_tor'] = $this->etor_m->getDetailTorPrint($id);
		$data['data_tor_appv'] = $this->etor_m->getDetailTorPrintApprove($id);
		$data['data_company'] = $this->session->userdata('COMPANYID');
		// echo "<pre>";
		// print_r($data['data_tor']);
		// die;
		include_once APPPATH.'helpers/dompdf/dompdf_config.inc.php';
		$html = $this->load->view('print_dom_cover', $data, true);
		$html .= $this->load->view('print_dom', $data, true);
		//$html .= $this->load->view('print_dom_footer', $data, true);
		$html = preg_replace('/>\s+</', "><", $html);
		$html = str_replace("<br />","<br>",$html);
		// echo "<pre>";print_r($html);die;
		$dompdf = new DOMPDF();
		$dompdf->set_paper('A4', 'portrait');
		$dompdf->load_html($html);
		$dompdf->render();
		$gambar = '<img class="logo_dark" src="http://int-eprocurement.semenindonesia.com/eproc/static/images/logo/semen_indonesia_list.png" alt="Logo eProcurement PT. Semen Gresik Tbk.">';
		$image = "http://int-eprocurement.semenindonesia.com/eproc/static/images/logo/semen_indonesia_list.png";
		$canvas = $dompdf->get_canvas();
		// $header = $canvas->open_object();
		// $canvas->image($image, 472, 35, 85, 25);
		// $canvas->close_object();
		// $canvas->add_object($header, 'all');
		$font = Font_Metrics::get_font("helvetica", "bold");
		// $canvas->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
		// $canvas->page_text(72, 500, "__________________________________________________________________________________________________________________", $font, 6, array(0,0,0));
		$canvas->page_text(500, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
		$dompdf->stream("my_pdf.pdf", array("Attachment" => 0));

		// $output = $dompdf->output();
		// file_put_contents('Brochure.pdf', $output);

	}

	public function saveprinttor($id) {
		// print_r( $this->input->post());die;
		// error_reporting(E_ALL);
		$this->load->model('etor_m');
		$data['title'] = "E_TOR".$id;

		$set_edit4['TOR'] 	= $data['title'].".pdf";
		$where_edit2['ID_TOR'] = $id;
		$this->etor_m->updateMain($set_edit4, $where_edit2);

		$data['data_tor'] = $this->etor_m->getDetailTorPrint($id);
		$data['data_tor_appv'] = $this->etor_m->getDetailTorPrintApprove($id);
		$data['data_company'] = $this->session->userdata('COMPANYID');
		// echo "<pre>";
		// print_r($data['data_tor']);
		// die;
		include_once APPPATH.'helpers/dompdf/dompdf_config.inc.php';
		$html = $this->load->view('print_dom_cover', $data, true);
		$html .= $this->load->view('print_dom', $data, true);

		$html = preg_replace('/>\s+</', "><", $html);
		$html = str_replace("<br />","<br>",$html);
		// echo "<pre>";print_r($html);die;
		$dompdf = new DOMPDF();
		$dompdf->set_paper('A4', 'portrait');
		$dompdf->load_html($html);
		$dompdf->render();
		$gambar = '<img class="logo_dark" src="http://int-eprocurement.semenindonesia.com/eproc/static/images/logo/semen_indonesia_list.png" alt="Logo eProcurement PT. Semen Gresik Tbk.">';
		$image = "http://int-eprocurement.semenindonesia.com/eproc/static/images/logo/semen_indonesia_list.png";
		$canvas = $dompdf->get_canvas();
		// $header = $canvas->open_object();
		// $canvas->image($image, 472, 35, 85, 25);
		// $canvas->close_object();
		// $canvas->add_object($header, 'all');
		$font = Font_Metrics::get_font("helvetica", "bold");
		// $canvas->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
		// $canvas->page_text(72, 500, "__________________________________________________________________________________________________________________", $font, 6, array(0,0,0));
		$canvas->page_text(500, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
		$output = $dompdf->output();
		$tes 				= dirname(__FILE__);
		$pet_pat 			= str_replace('application/modules/Etor/controllers', '', $tes);
		file_put_contents($pet_pat . 'upload/etor/' .$data['title'].".pdf", $output);

		// $output = $dompdf->output();
		// file_put_contents('Brochure.pdf', $output);

	}

	public function kirim_email($user){	
		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->to($user['EMAIL']);				
		$this->email->cc('pengadaan.semenindonesia@gmail.com');				
		$this->email->subject("E-Tor Approval ".$this->session->userdata['COMPANYNAME'].".");
		$content = $this->load->view('email/approval_atasan_etor',$user['data'],TRUE);
		$this->email->message($content);
		$this->email->send();
	}

	public function kirim_email_2($user){
		// echo "user<pre>";
		// print_r($user);die;	

        // $this->load->library('myencryption');
        // $config['encryption_key'] = 'YOUR KEY';
        // $param = $this->myencryption->encode("{$url}");
        // $url .=$param;

        // $decode = $this->myencryption->decode($param);
        // $pecah = explode('&', $decode);
        // $pecah2 = explode('=', $pecah[0]);
        // $token = $pecah2[1];
        // $pecah3 = explode('=', $pecah[1]);
        // $email = $pecah3[1];
        // $pecah4 = explode('=', $pecah[2]);
        // $pas = $pecah4[1];
		$url_login =base_url().'Login';

		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		// $this->email->to($user['EMAIL']);				
		// $this->email->to('tithe.j@sisi.id');
		$this->email->to($user['EMAIL']);				
		$this->email->cc('pengadaan.semenindonesia@gmail.com');				
		// $this->email->cc('pengadaan.semenindonesia@gmail.com');
		if($user['status']==0){
			// $url =base_url().'Etor/edit/'.$user['data']['ID_TOR'];
			$url =base_url().'Etor/edit/'.$user['data']['ID_TOR'].'/'.$user['data']['NO_PR'];
			$user['data']['URL'] = $url;
			$user['data']['URL_LOGIN'] = $url_login;
			$this->email->subject("[REJECT] E-Tor Approval ".$this->session->userdata['COMPANYNAME'].".");
			$content = $this->load->view('email/approval_atasan_etor_reject',$user['data'],TRUE);
		} else {
			// $url =base_url().'Etor/approve/'.$user['data']['ID_TOR'];
			$url =base_url().'Etor/approve/'.$user['data']['ID_TOR'].'/'.$user['data']['NO_PR'];
			$user['data']['URL'] = $url;
			$user['data']['URL_LOGIN'] = $url_login;
			$this->email->subject("E-Tor Approval ".$this->session->userdata['COMPANYNAME'].".");
			$content = $this->load->view('email/approval_atasan_etor',$user['data'],TRUE);
		}			
		$this->email->message($content);
		$this->email->send();
	}

	public function getHolder() 
	{
		$this->load->model('etor_m');
		$this->load->model('adm_employee');
		$ID_TOR = $this->input->post('ID_TOR');
		$tor_data = $this->adm_employee->getDetailTor($ID_TOR);
		if($tor_data[0]['STATUS']==0){
			$HOLDER = $tor_data[0]['CREATED_BY'];
		} else if($tor_data[0]['IS_SUBMIT']==0){
			$HOLDER = $tor_data[0]['CREATED_BY'];
		} else {
			$cekflow = $this->etor_m->cekApprovalFlow($ID_TOR);
            // print_r($cekflow);die;
			if(count($cekflow)>0){
				$HOLDER = $cekflow[0]['ID_EMP'];
			} else {
				$HOLDER = $tor_data[0]['CREATED_BY'];
			}

		}
		$holdernya = $this->adm_employee->find($HOLDER);
		$data = $holdernya;
        // print_r($data);die;
		echo json_encode($data);
	}

	public function getRejectReason() 
	{
		$this->load->model('etor_m');
		$this->load->model('adm_employee');
		$ID_TOR = $this->input->post('ID_TOR');
		$tor_data = $this->adm_employee->getDetailTor($ID_TOR);
		$data = $tor_data[0];
        // print_r($data);die;
		echo json_encode($data);
	}

	public function store_tor($pr = NULL) {
		// error_reporting(E_ALL);
		$this->load->library("file_operation");
		$this->load->model('adm_mrpc');
		$halaman = $this->input->post('halaman');
		/* tampilin list pr, ntar pilih salah satu pr */
		if ($pr == null) {
			redirect('Etor/'.$halaman);
		}
		/* masuk ke dalam form upload dokumen pengadaan */
		else {
			$this->load->model('com_mat_group');
			$this->load->model('prc_item_verify');
			$this->load->model('prc_plan_doc');
			$this->load->model('prc_pr_item');
			$this->load->model('prc_pr_item');
			$this->load->model('prc_purchase_requisition');

			$this->prc_item_verify->where_is_doc(1);
			$data['verif'] = $this->prc_item_verify->pr($pr);
			//var_dump( $data['verif']); die();
			/* jika dia ngupload file */
			if ($this->input->post()) {
				
				$uploaded = $this->file_operation->upload(UPLOAD_PATH.'ppm_document', $_FILES);
				
				/* kalau berhasil upload */
				if (!empty($uploaded['file'])) {
					$category = $this->input->post('tipe');
					/* foreach item yang dicentang */
					if($this->input->post('items') == null) {
						$data['warning'] = true;
					}
					else {
							//--LOG MAIN--//
						$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
							$this->authorization->getCurrentRole(),'Upload Dokumen Pengadaan','UPLOAD',$this->input->ip_address()
							);
						$LM_ID = $this->log_data->last_id();
							//--END LOG MAIN--//

						foreach ($this->input->post('items') as $key) {
							$whereppd['PPD_CATEGORY'] = $category;
							$whereppd['PPI_ID'] = $key;
							$setppd['PPD_STATUS'] = '';
							$this->prc_plan_doc->update($setppd, $whereppd);

								//--LOG DETAIL--//
							$this->log_data->detail($LM_ID,'Procurement_sap/store_tor','prc_plan_doc','update',$setppd,$whereppd);
								//--END LOG DETAIL--//

							$new_id = $this->prc_plan_doc->get_id();
							$ppd = array(
								'PPD_ID' => $new_id,
								'PPD_PRNO' => $pr,
								'PPD_CATEGORY' => $category,
								'PPD_DESCRIPTION' => $this->input->post('desc'),
								'PPD_FILE_NAME' => $uploaded['file']['file_name'],
								'PPD_CREATED_AT' => date('d-M-Y g.i.s A'),
								'PPD_CREATED_BY' => $this->session->userdata['FULLNAME'],
								'PPI_ID' => $key,
								'PPD_STATUS' => '1',
								);
							$junk = $this->prc_plan_doc->insert($ppd);

								//--LOG DETAIL--//
							$this->log_data->detail($LM_ID,'Procurement_sap/store_tor','prc_plan_doc','insert',$ppd);
								//--END LOG DETAIL--//
						}

						$data['success'] = true;
					}
				}
			}
			redirect('Etor/'.$halaman.'/'.$pr);
		}
	}

	public function ambilDataSelect2() {
		$cari = $this->input->get('search');
		$this->load->model('adm_employee');
		$json = $this->adm_employee->getListCari($cari);

		if (count($json) > 0) {
			$list = array();
			$key=0;
			foreach ($json as $row) {
				$list[$key]['id'] = $row['ID'];
				$list[$key]['text'] = $row['FULLNAME']; 
				$key++;
			}
			echo json_encode($list);
		} else {
			echo "hasil kosong";
		}
	}

}
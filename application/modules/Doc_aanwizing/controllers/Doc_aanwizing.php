<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Doc_aanwizing extends CI_Controller {

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
		$this->layout->add_js('pages/doc_aanwizing.js');		
		$this->layout->add_js("strTodatetime.js");
		$this->layout->render('list_pr', $data);
	}

	public function detail($id){
		$this->load->model('prc_tender_main');
		$data_main = $this->prc_tender_main->ptm($id);
		$data['data_main'] = $data_main[0];
		$data['title'] = "Form Upload Doc aanwizing ".$data_main[0]['PTM_SUBPRATENDER'];
		$data['id'] = $id;
		// echo "<pre>";
		// print_r($data);die;
		$this->layout->render('detail', $data);	
		
	}

	public function doSimpan(){
		$PTM_NUMBER = $this->input->post('PTM_NUMBER');
		$this->load->model('prc_tender_main');
		$DOC_AANWIZ 			= $_FILES['DOC_AANWIZ']['tmp_name'];
		$tes 				= dirname(__FILE__);
		$pet_pat 			= str_replace('application/modules/Doc_aanwizing/controllers', '', $tes);

		//echo $pet_pat;die;
		if (isset($_FILES) && !empty($_FILES['DOC_AANWIZ']['name'])) {
			$type = explode('.', $_FILES['DOC_AANWIZ']['name']);
			if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_AANWIZ". $PTM_NUMBER . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/temp/' . $this->_myFile;
                if (move_uploaded_file($DOC_AANWIZ, $this->_path)) {
                	$set_edit2['DOC_AANWIZ'] 	= $this->_myFile;
                	$where_edit2['PTM_NUMBER'] = $PTM_NUMBER;
                	$this->prc_tender_main->updateByPtm($PTM_NUMBER, $set_edit2);
                }
            }
        }
        redirect('Doc_aanwizing/');
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

    	if($this->session->userdata('COMPANYID')=='3000' || $this->session->userdata('COMPANYID')=='4000'){ 
    		if ($kd_user == 42||$kd_user == 281) {
    			$this->load->model('adm_employee');
    			$emp = $this->adm_employee->get(array('ID'=>$this->session->userdata('ID')));
    			$this->prc_tender_main->join_pr_item();
    			$this->prc_tender_main->where_requestioner($emp[0]['MKCCTR']);
    		}else {
    			$this->prc_tender_main->where_pgrp_in($pgrp);
    		}

    	}else if ($this->session->userdata('COMPANYID')=='2000' || $this->session->userdata('COMPANYID')=='5000' || $this->session->userdata('COMPANYID')=='7000'){


    		if ($kd_user == 42||$kd_user == 281) {
    			$this->prc_tender_main->join_pr_item();
    			$this->prc_tender_main->join_mrpc();
    			$this->prc_tender_main->where_emp($this->session->userdata('ID'));
    		}else {
    			$this->prc_tender_main->where_pgrp_in($pgrp);
    		}

    	}

    	$data = array();
    	$this->prc_tender_main->where_app_proses();
		// $datatable = $this->prc_tender_main->get(null, false, null, true);
    	$datatable = $this->prc_tender_main->get();
		// echo $this->db->last_query(); exit;
		// echo "<pre>";
  //   	print_r($datatable);die;
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



}
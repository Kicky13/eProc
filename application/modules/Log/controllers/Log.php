<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
	}

	public function index() {
		$data['title'] = "Log";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_validate_css();
		$this->layout->set_validate_js();
		$this->layout->add_js('pages/log.js');		
		$this->layout->add_js("strTodatetime.js");
		$this->layout->render('list', $data);
	}

	public function get_datatable() {
		$this->load->model('app_process');
		$this->load->model('prc_tender_prep');
		$length = $this->input->post('length');
		$start = $this->input->post('start');				
		$draw = $this->input->post('draw');	
		$search = $this->input->post('search');	
		$rn = $start+$length;

		$da = " SELECT R NO, S.PTM_NUMBER, PTM.PTM_SUBPRATENDER, PTM.PTM_PRATENDER, PTM.PTM_SUBJECT_OF_WORK, PTC.PTC_END_DATE, PTM.PTM_PGRP, PTM.PTM_STATUS 
		FROM
		(SELECT PTM_NUMBER, ROWNUM R FROM 
		(	SELECT mdl.PTM_NUMBER FROM V_LOG_MAIN mdl 
		INNER JOIN PRC_TENDER_MAIN PTM2 ON TO_CHAR(PTM2.PTM_NUMBER)=mdl.PTM_NUMBER AND PTM2.KEL_PLANT_PRO = '".$this->session->userdata('KEL_PRGRP')."'
		GROUP BY mdl.PTM_NUMBER
		)
		)S
		INNER JOIN PRC_TENDER_MAIN PTM ON PTM.PTM_NUMBER=S.PTM_NUMBER
		INNER JOIN (
		SELECT PTM_NUMBER, MAX(PTC_END_DATE) AS PTC_END_DATE FROM PRC_TENDER_COMMENT GROUP BY PTM_NUMBER
		) PTC ON PTC.PTM_NUMBER=S.PTM_NUMBER 
		";
				 // WHERE PTM.KEL_PLANT_PRO = '".$this->session->userdata('KEL_PRGRP')."'
		$totalRecords = $this->db->query($da)->num_rows();

		if (isset($search)&&!empty($search)&&$search != '') {
			$da .= " AND (PTM_SUBPRATENDER LIKE '%".$search."%' OR PTM_PRATENDER LIKE '%".$search."%' 
			OR PTM_SUBJECT_OF_WORK LIKE '%".$search."%' OR PTM_PGRP LIKE '%".$search."%')";
		}else{
			$da .= " AND R <= {$rn} AND R > {$start} ";
		}
		$data = $this->db->query($da);
		$data2 = (array)$data->result_array();	

		$hasil = array();
		foreach ($data2 as $val) {
			$ptp = $this->prc_tender_prep->get(array('PTM_NUMBER'=>$val['PTM_NUMBER']));
			$val['PTP_REG_CLOSING_DATE'] = $ptp['PTP_REG_CLOSING_DATE'];
			$val['PTC_END_DATE'] = betteroracledate(oraclestrtotime($val['PTC_END_DATE']));
			if($val['PTM_STATUS'] > 0){
				$ap = $this->app_process->get(array('CURRENT_PROCESS'=>$val['PTM_STATUS']));
				$val['NAMA_BARU'] = $ap[0]['NAMA_BARU'];
			}
			$hasil[] = $val;
		}

		$result = array(
			"length"=>$length,
			"start"=>$start,
			"draw"            => intval($draw), 
			"recordsTotal"    => intval($totalRecords),  
			"recordsFiltered" => intval($totalRecords),
            "data"            => $hasil   // total data array
            );

		echo json_encode($result);
	}

	public function detail($ptm){
		$this->load->model('v_log_main');
		$this->load->model('log_detail');
		$this->load->model('vnd_header');
		$this->load->model('adm_employee');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_pr_item');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_evaluation_template');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_ece_change');
		$this->load->model('prc_tender_winner');
		$this->load->model('po_header');

		$data['title'] = 'Log Detail';

		$p = $this->prc_tender_main->ptm($ptm);


		$datatable = $this->prc_tender_main->join_nego(false, 2);
		$datatable = $this->prc_tender_main->get(array('PRC_TENDER_MAIN.PTM_NUMBER' => $ptm));
		$datatable = $this->prc_tender_main->filter_wherehas_titstatus($datatable, 1);

		$data['should_continue_nego'] = false;
		if (count($datatable) > 0) {
			$data['should_continue_nego'] = false;
		} else {
			$this->load->model('prc_tender_nego');
			$ptn = $this->prc_tender_nego->get(array('PTM_NUMBER'=>$ptm));
			if(count($ptn)>0){
				$data['should_continue_nego'] = true;
			}
		}


		$data['ptm_detail'] = $p[0];
		$data['ptp'] = $this->prc_tender_prep->ptm($ptm);
		
		$data['v_log_main'] = $this->v_log_main->get(array('PTM_NUMBER'=>$ptm));

		// var_dump($data['v_log_main']);

		$data['detail'] = array();
		foreach ($data['v_log_main'] as $val) {
			$dtl = $this->log_detail->get(array('LM_ID'=>$val['LM_ID']));
			$data['detail'][$val['LM_ID']] = $dtl;
		}

		$vendor=array();$vnds=array();$ass=array();$emp=array();$ppi=array();$ppi2=array();
		$data['fileVendor']=array();$reItem=array();$tmplte=array();
		foreach ($data['detail'] as $key => $val) {
			foreach ($val as $val2) {
				$enc = json_decode($val2['DATA']);
				if(isset($enc->PTV_VENDOR_CODE) && !empty($enc->PTV_VENDOR_CODE)){
					$vendor[$enc->PTV_VENDOR_CODE] = $enc->PTV_VENDOR_CODE;
				}
				if(isset($enc->PTM_ASSIGNMENT) && !empty($enc->PTM_ASSIGNMENT)){
					$ass[$enc->PTM_ASSIGNMENT] = $enc->PTM_ASSIGNMENT;
				}
				if(isset($enc->PPI_ID) && !empty($enc->PPI_ID) && isset($enc->PQM_ID) && !empty($enc->PQM_ID)){
					$ppi[] = $enc->PPI_ID;
					$ppi2[$val2['LM_ID']][$enc->PPI_ID][] = $enc;
				}
				if(isset($enc->EF_ID) && !empty($enc->EF_ID)){
					$data['fileVendor'][$enc->PTV_VENDOR_CODE][$enc->TIT_ID][] = $enc->EF_FILE;
				}
				if($val2['TABLE_AFFECTED']=='vnd_perf_hist'){
					$verVnd[$enc->VENDOR_CODE]=$enc->VENDOR_CODE;
				}
				if($val2['TABLE_AFFECTED']=='retender_item'){
					$reItem[]=$enc->PPI_ID;
				}
				if($val2['TABLE_AFFECTED']=='prc_tender_prep' && isset($enc->EVT_ID) && !empty($enc->EVT_ID)){
					$tmplte[$val2['LM_ID']][]=$enc->EVT_ID;
				}
			}
		}
		
		$data['vendors']=array();
		foreach ($vendor as $key => $val) {
			$vnd = $this->vnd_header->get(array('VENDOR_NO'=>$val));
			$vnds[$val]=$val.' - '.$vnd['VENDOR_NAME'];
		}
		$data['vendors']=$vnds;

		foreach ($ass as $key => $val) {
			$e = $this->adm_employee->get(array('ID'=>$val));
			$emp[$val]=$e[0]['FULLNAME'];
		}
		$data['assigns']=$emp;

		$data['pr_item'] = array();
		foreach (array_unique($ppi) as $value) {
			$pti = $this->prc_pr_item->where_ppiId($value);
			if(isset($pti[0])){
				$data['pr_item'][] = $pti[0];
			}
		}

		$data['pr_ppi_item'] = array();
		foreach ($ppi2 as $ky => $ppi) {
			foreach ($ppi as $pi => $val) {
				$data['pr_ppi_item'][$ky][$pi][] = $val;
			}
		}

		$data['retenderItem'] = array();
		foreach (array_unique($reItem) as $value) {
			$pti = $this->prc_pr_item->where_ppiId($value);
			if(isset($pti[0])){
				$data['retenderItem'][] = $pti[0];
			}
		}

		$this->prc_tender_vendor->join_vnd_header();
		$data['verVndLolos'] = $this->prc_tender_vendor->get(array('PTM_NUMBER'=>$ptm, 'PTV_STATUS'=>2));
		$this->prc_tender_vendor->join_vnd_header();
		$data['verVndTidak'] = $this->prc_tender_vendor->get(array('PTM_NUMBER'=>$ptm, 'PTV_STATUS'=>-1));

		$data['template'] = array();
		foreach ($tmplte as $lm_id => $va) {
			$evt = $this->prc_evaluation_template->get(array('EVT_ID'=>$va[0]));
			if(isset($evt[0])){
				$data['template'][$lm_id] = $evt[0]['EVT_NAME'];
			}
		}

		$data['ppii'] = array();
		$ptii=$this->prc_tender_item->get(array('PTM_NUMBER'=>$ptm));
		foreach ($ptii as $val) {
			$data['ppii'][$val['TIT_ID']] = $this->prc_pr_item->where_ppiId($val['PPI_ID']);	
		}

		$data['tndr_nego'] = array();
		$this->prc_tender_item->where_in('TIT_STATUS',array(1,5));
		$ptin=$this->prc_tender_item->get(array('PTM_NUMBER'=>$ptm));
		foreach ($ptin as $val) {
			$data['tndr_nego'][$val['TIT_ID']] = $this->prc_pr_item->where_ppiId($val['PPI_ID']);	
		}

		$data['analisa_harga'] = array();
		$pec = $this->prc_ece_change->ptm($ptm);
		foreach ($pec as $val) {
			$ti=$this->prc_tender_item->get(array('TIT_ID'=>$val['TIT_ID']));
			$data['analisa_harga'][$val['TIT_ID']] = $this->prc_pr_item->where_ppiId($ti[0]['PPI_ID']);
		}

		$data['tnjk_pmng'] = array();
		$this->prc_tender_item->where_in('TIT_STATUS',array(6,8));
		$ptin=$this->prc_tender_item->get(array('PTM_NUMBER'=>$ptm));
		foreach ($ptin as $val) {
			$data['tnjk_pmng'][$val['TIT_ID']] = $this->prc_pr_item->where_ppiId($val['PPI_ID']);	
		}

		$this->prc_tender_winner->where_ptm($ptm);
		$data['tndr_winner']=$this->prc_tender_winner->get();

		$data['lp3']=$this->po_header->get(array('PTM_NUMBER'=>$ptm));
		
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$companyid = $this->authorization->getCompanyId();
		if($companyid==5000){
			$this->layout->render('detail_2000',$data);
		} else {
			$this->layout->render('detail',$data);
		}
	}

}
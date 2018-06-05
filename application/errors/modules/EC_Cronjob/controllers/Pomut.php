<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pomut extends MX_Controller {

	private $USER;
	public function __construct() {
		parent::__construct();
    	$this->load->model('ec_master_inv','me');
		$this -> load -> helper('url');
		$this -> load -> library('Layout');
		// $this -> USER = explode("@", $this -> session -> userdata['USERNAME']);
	}

	public function setDataPomut($tgl){
		$this->load->library('sap_invoice');

		if($tgl < 20171121){
			$data = array('ACTION' => 'REFRESH POTONGAN MUTU (DENIED)','DATE_TRANSACTION' => $tgl);
			$this->setLog($data);
		}

		$kemarin = new DateTime();
		$kemarin->modify('-1 day');

		$tgl = !empty($tgl) ? $tgl : $kemarin->format('Ymd');

		$company = array(2000,5000,7000);

		$ListBA = $this->getDataHeader($tgl,$company);

		$period = substr($tgl,0,6); // set data period

		 // Data Company yang ditarik

		$data = array();

		foreach ($company as $val) {
			$temp = $this->sap_invoice->getDataPomut($ListBA,$period,$val);
			// foreach ($temp['HEADER1'] as $value) {
			// 	$data['HEADER1'][] = $value;
			// }
			foreach ($temp['HEADER2'] as $value) {
				$data['HEADER2'][] = $value;
			}
			foreach ($temp['DETAIL'] as $value) {
				$data['DETAIL'][] = $value;
			}
			foreach ($temp['FORMULA'] as $value) {
				$data['FORMULA'][] = $value;
			}
		}

		$header = array();
		$detail = array();
		$formula = array();
		$no_ba = array();

		//var_dump($data['FORMULA']);die();

		$i = 0;
		
		foreach($data['HEADER2'] as $value){
			$header[$i]['NO_BA'] = $value['NO_BA'];
			$header[$i]['TELFX'] = $value['TELFX'];
			$header[$i]['POT_PPH'] = $value['POT_PPH'];
			$header[$i]['KETR1'] = $value['KETR1'];
			$i++;
			
		}
		
		//var_dump($header);die();

		$i = 0;
		foreach ($data['DETAIL'] as $value) {
			$detail[$i]['NO_BA'] = $value['NO_BA'];
			$detail[$i]['MBLNR'] = $value['MBLNR'];
			$detail[$i]['PRUEFLOS'] = $value['PRUEFLOS'];
			$detail[$i]['LOTQTY'] = $value['LOTQTY'];
			$detail[$i]['HARSAT'] = $value['HARSAT'];
			$detail[$i]['POVALUE'] = $value['POVALUE'];
			$detail[$i]['POT'] = $value['POT'];
			$detail[$i]['MIC1'] = $value['MIC1'];
			$detail[$i]['MIC_DESC1'] = $value['MIC_DESC1'];
			$detail[$i]['ORI_INPUT1'] = $value['ORI_INPUT1'];
			$detail[$i]['QLTDVALT1'] = $value['QLTDVALT1'];
			$detail[$i]['MIC2'] = $value['MIC2'];
			$detail[$i]['MIC_DESC2'] = $value['MIC_DESC2'];
			$detail[$i]['ORI_INPUT2'] = $value['ORI_INPUT2'];
			$detail[$i]['QLTDVALT2'] = $value['QLTDVALT2'];
			$detail[$i]['MIC3'] = $value['MIC3'];
			$detail[$i]['MIC_DESC3'] = $value['MIC_DESC3'];
			$detail[$i]['ORI_INPUT3'] = $value['ORI_INPUT3'];
			$detail[$i]['QLTDVALT3'] = $value['QLTDVALT3'];
			$detail[$i]['JML_BAYAR'] = $value['JML_BAYAR'];
			$detail[$i]['VCODE'] = $value['VCODE'];
			$detail[$i]['KURZTEXT'] = $value['KURZTEXT'];
			$detail[$i]['ZCOND1'] = $value['ZCOND1'];
			$detail[$i]['QLTLMT1'] = $value['QLTLMT1'];
			$detail[$i]['ZGROUP'] = $value['ZGROUP'];
			$detail[$i]['TGL_FROM'] = $value['TGL_FROM'];
			$detail[$i]['TGL_TO'] = $value['TGL_TO'];
			$detail[$i]['LAST_CAL_DATE'] = $value['LAST_CAL_DATE'];
			$detail[$i]['LAST_UD_DATE'] = $value['LAST_UD_DATE'];
			$i++;
		}

		$i = 0;
		foreach ($data['FORMULA'] as $value) {
			if($value['NO_BA'] != NULL){
				$formula[$i]['NO_BA'] = $value['NO_BA'];
				$formula[$i]['JENIS_FORMULA'] = $value['JENIS_FORMULA'];
				$formula[$i]['MKMNR'] = $value['MKMNR'];
				$formula[$i]['MIC_DESC'] = $value['MIC_DESC'];
				$formula[$i]['OPERATOR'] = $value['OPERATOR'];
				$formula[$i]['FORMULA'] = $value['FORMULA'];
				$i++;
			}
		}

		
		foreach ($header as $value) {
			$this->db->where('NO_BA',$value['NO_BA'])->update('EC_POMUT_HEADER_SAP',$value);
		}

		foreach ($detail as $value) {
			$check = $this->db->where(array('NO_BA'=> $value['NO_BA'],'MBLNR' => $value['MBLNR'],'PRUEFLOS' => $value['PRUEFLOS']))->get('EC_POMUT_DETAIL_SAP')->result_array();
			if(!empty($check)){
				$this->db->where(array('NO_BA'=> $value['NO_BA'],'MBLNR' => $value['MBLNR'],'PRUEFLOS' => $value['PRUEFLOS']))->update('EC_POMUT_DETAIL_SAP',$value);
			}else{
				$this->db->set($value)->insert('EC_POMUT_DETAIL_SAP');
			}
		}

		if(!empty($ListBA)){
			$this->db->where_in('NO_BA',$ListBA)->delete('EC_POMUT_FORMULA_SAP');
		}
		
		foreach ($formula as $value) {
			$this->db->set($value)->insert('EC_POMUT_FORMULA_SAP');
			//$this->db->where('NO_BA IS NULL', NULL, FALSE)->delete('EC_POMUT_FORMULA_SAP'); 
		}
		
		$data = array('ACTION' => 'REFRESH POTONGAN MUTU','DATE_TRANSACTION' => $tgl);
		$this->setLog($data);
	}

	public function getDataHeader($tgl,$company='',$debug = 0){
  		$table = 'EC_POMUT_HEADER_SAP';
		$this->load->library('sap_invoice');

		$temp = array(2000,5000,7000);
		$company = $company == '' ? $temp : $company;

		$period = substr($tgl,0,6); // set data period

		$tahap = $this->checkTahap($tgl);

		$data = $this->sap_invoice->getDataHeader($company,$period,$tahap);
		
		$no_ba = array();

		foreach ($data as $val) {
			$no_ba[] = $val['NO_BA'];
			$check = $this->db->where('NO_BA',$val['NO_BA'])->get($table)->result_array();
			if(count($check) == 0){
				$this->db->insert($table,$val); // Jika Tidak Ada Insert
				//echo $this->db->last_query();
			}else{
				$this->db->where('NO_BA',$val['NO_BA'])->update($table,$val); // Jika Ada Update
				//echo $this->db->last_query();
			}
		}
		return $no_ba;
  	}

	public function setLog($data){
		$redirect = 0;
		if($this->session->userdata('FULLNAME')){
       		$data['DONE_BY'] = $this->session->userdata('FULLNAME');
				$redirect = 1;
    	}else{
        	$data['DONE_BY'] = "SYSTEM";
    	}
    	if($this->me->logCronjobBaru($data)){
			if($redirect){
				redirect('./EC_Cronjob');
			}else{
				echo 1;
			}
    	};
  	}


  	public function getNoBA($tgl){
		//$period = substr($tgl,4,2).substr($tgl,0,4);
  		$period = substr($tgl,0,6);
  		$tahap = $this->checkTahap($tgl);

  		$filter = array(
  			'PERIOD' => $period,
  			'TAHAP'	=> $tahap
  		);

  		return $this->db->select('NO_BA')->where($filter)->get('EC_POMUT_HEADER_SAP')->result_array();
  	}


  	private function checkTahap($tgl){
		$temp = substr($tgl,6,2);
		$tahap = 1;
		if(10 < $temp && $temp < 21){
			$tahap = 2;
		}else if($temp > 20){
			$tahap = 3;
		}
		return $tahap;
  	}

  	public function Test($data = ''){
  		if($data == 'D'){
  			$temp = $this->db->get('EC_POMUT_DETAIL_SAP')->result_array();
  			var_dump($temp);
  		}else if($data == 'F'){
  			$temp = $this->db->get('EC_POMUT_FORMULA_SAP')->result_array();
  			var_dump($temp);
  		}else{
  			$temp = $this->db->get('EC_POMUT_HEADER_SAP')->result_array();
  			var_dump($temp);
  		}
  	}
}

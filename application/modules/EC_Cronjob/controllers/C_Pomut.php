<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Pomut extends MX_Controller {

	private $USER;
	public function __construct() {
		parent::__construct();
    	$this->load->model('ec_master_inv','me');
		$this -> load -> helper('url');
		$this -> load -> library('Layout');
		// $this -> USER = explode("@", $this -> session -> userdata['USERNAME']);
	}

	public function setDataPomut($tgl,$debug = 0){
		$this->load->library('sap_invoice');

		$kemarin = new DateTime();
		$kemarin->modify('-1 day');
		$tglUD = !empty($tgl) ? $tgl : $kemarin->format('Ymd');

		$period = substr($tglUD,0,6); // set data period

		$company = array(2000,5000,7000,4000); // Data Company yang ditarik

		$data = array();

		foreach ($company as $val) {
			$temp = $this->sap_invoice->getDataPomut($tglUD,$period,$val);
			foreach ($temp['HEADER1'] as $value) {
				$data['HEADER1'][] = $value;
			}
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

		// var_dump($data);die();

		$i = 0;
		foreach ($data['HEADER1'] as $val) {
			$no_ba[] = $val['NO_BA'];
			$header[$i]['NO_BA'] = $val['NO_BA'];
			$header[$i]['BUKRS'] = $val['BUKRS'];
			$header[$i]['WERKS'] = $val['WERKS'];
			$header[$i]['EBELN'] = $val['EBELN'];
			$header[$i]['EBELP'] = $val['EBELP'];
			$header[$i]['PERIOD'] = $val['PERIOD'];
			$header[$i]['TAHAP'] = $val['TAHAP'];
			$header[$i]['LIFNR'] = $val['LIFNR'];
			$header[$i]['NAME1'] = $val['NAME1'];
			$header[$i]['MATNR'] = $val['MATNR'];
			$header[$i]['HARGA_BAHAN'] = $val['HARGA_BAHAN'];
			$header[$i]['JML_BAYAR'] = $val['JML_BAYAR'];
			$header[$i]['POVALUE'] = $val['POVALUE'];
			$header[$i]['MAKTX'] = $val['MAKTX'];
			foreach($data['HEADER2'] as $value){
				if($val['NO_BA'] === $value['NO_BA']){
					$header[$i]['TELFX'] = $value['TELFX'];
					$header[$i]['MIC1'] = $value['MIC1'];
					$header[$i]['MIC2'] = $value['MIC2'];
					$header[$i]['MIC3'] = $value['MIC3'];
					$header[$i]['WAERS'] = $value['WAERS'];
					$header[$i]['ZCOND1'] = $value['ZCOND1'];
					$header[$i]['QLTLMT1'] = $value['QLTLMT1'];
					$header[$i]['ZCOND2'] = $value['ZCOND2'];
					$header[$i]['QLTLMT2'] = $value['QLTLMT2'];
					$header[$i]['ZCOND3'] = $value['ZCOND3'];
					$header[$i]['QLTLMT3'] = $value['QLTLMT3'];
					$header[$i]['MIC_DESC1'] = $value['MIC_DESC1'];
					$header[$i]['MIC_DESC2'] = $value['MIC_DESC2'];
					$header[$i]['MIC_DESC3'] = $value['MIC_DESC3'];
					$header[$i]['ZGROUP'] = $value['ZGROUP'];
					$header[$i]['QTY_BL'] = $value['QTY_BL'];
					$header[$i]['QTY_DR'] = $value['QTY_DR'];
					$header[$i]['NOMBL'] = $value['NOMBL'];
					$header[$i]['TELF1'] = $value['TELF1'];
					$header[$i]['STRAS'] = $value['STRAS'];
					$header[$i]['MEINS'] = $value['MEINS'];
					$header[$i]['ORT01'] = $value['ORT01'];
					$header[$i]['POT_PPH'] = $value['POT_PPH'];
					$header[$i]['KETR1'] = $value['KETR1'];
					$i++;
					break;
				}
			}
		}

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
			$formula[$i]['NO_BA'] = $value['NO_BA'];
			$formula[$i]['JENIS_FORMULA'] = $value['JENIS_FORMULA'];
			$formula[$i]['MKMNR'] = $value['MKMNR'];
			$formula[$i]['MIC_DESC'] = $value['MIC_DESC'];
			$formula[$i]['OPERATOR'] = $value['OPERATOR'];
			$formula[$i]['FORMULA'] = $value['FORMULA'];
			$i++;
		}

		if($debug){
			echo "HEADER <br>";
			$temp = $this->renderTable($header);
			echo $temp;
			echo "<br> DETAIL <br>";
			$temp = $this->renderTable($detail);
			echo $temp;
			echo "<br> FORMULA <br>";
			$temp = $this->renderTable($formula);
			echo $temp;
			die();
		}

		foreach ($header as $value) {
			$check = $this->db->where('NO_BA',$value['NO_BA'])->get('EC_POMUT_HEADER_SAP')->result_array();
			if(!empty($check)){
				$this->db->where('NO_BA',$value['NO_BA'])->update('EC_POMUT_HEADER_SAP',$value);
			}else{
				$this->db->set($value)->insert('EC_POMUT_HEADER_SAP');
			}
		}

		foreach ($detail as $value) {
			$check = $this->db->where(array('NO_BA'=> $value['NO_BA'],'MBLNR' => $value['MBLNR'],'PRUEFLOS' => $value['PRUEFLOS']))->get('EC_POMUT_DETAIL_SAP')->result_array();
			if(!empty($check)){
				$this->db->where(array('NO_BA'=> $value['NO_BA'],'MBLNR' => $value['MBLNR'],'PRUEFLOS' => $value['PRUEFLOS']))->update('EC_POMUT_DETAIL_SAP',$value);
			}else{
				$this->db->set($value)->insert('EC_POMUT_DETAIL_SAP');
			}
		}

		$temp_ba_no = array_unique($no_ba);
		
		if(!empty($temp_ba_no)){
			$this->db->where_in('NO_BA',$temp_ba_no)->delete('EC_POMUT_FORMULA_SAP');
		}
		
		foreach ($formula as $value) {
			$this->db->set($value)->insert('EC_POMUT_FORMULA_SAP');
			$this->db->where('NO_BA IS NULL', NULL, FALSE)->delete('EC_POMUT_FORMULA_SAP'); 
		}

		$data = array('ACTION' => 'REFRESH POTONGAN MUTU','DATE_TRANSACTION' => $tglUD);
		$this->setLog($data);
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

  	public function getDataHeader($tgl){
		$this->load->library('sap_invoice');

		$kemarin = new DateTime();
		$kemarin->modify('-1 day');
		$tgl = !empty($tgl) ? $tgl : $kemarin->format('Ymd');

		$period = substr($tgl,0,6); // set data period

		$tahap = $this->checkTahap($tgl);

		$company = array(2000,5000,7000); // Data Company yang ditarik
		echo $temp.'---'.$tahap;
  	}

  	public function get_BA_NO($tgl){
		$period = substr($tgl,4,2).substr($tgl,0,4);
  		
  		$tahap = $this->checkTahap($tgl);


  		$filter = array(
  			'PERIOD' => $period,
  			'TAHAP'	=> $tahap
  		);

  		$data = $this->db->select('NO_BA')->where($filter)->get('EC_POMUT_HEADER_SAP')->result_array();
  		
  		echo $this->db->last_query();

  		var_dump($data);
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


  	public function renderTable($data){
    $check = 1;
    $table = "<table border='1'>";
        foreach ($data as $value) {
            if($check){
                $table .= "<tr>";
                foreach ($value as $key => $val) {
                    $table .= "<th>".$key."<th>";
                }
                $table .= "</tr>";
                $check = 0;
            }
            $table .= "<tr>";
            foreach ($value as $key => $val) {
                $table .= "<th>".$val."<th>";
            }
            $table .= "</tr>";
        }

    $table .= "</table>";
    return $table;
}
}

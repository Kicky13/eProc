<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Open_invoice extends CI_Controller {

	private $USER;

	public function __construct() {
		parent::__construct();
		$this -> load -> library('Authorization');
		$this -> load -> helper('url');
		$this -> load -> library('Layout');
		$this -> load -> helper("security");
		// $this -> USER = explode("@", $this -> session -> userdata['USERNAME']);
	}

	public function index($cheat = false) {
		$data['title'] = "Invoice Management";
		$data['cheat'] = $cheat;
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> set_validate_css();
		$this -> layout -> set_validate_js();
		$this -> layout -> add_js('pages/EC_open_inv.js');
		$this -> layout -> add_js('pages/EC_bootstrap-switch.min.js');
		$this -> layout -> add_css('pages/EC_strategic_material.css');
		$this -> layout -> add_css('pages/EC_bootstrap-switch.min.css');
		$this -> layout -> add_css('pages/EC_miniTable.css');
		$this -> layout -> add_css('pages/EC_jasny-bootstrap.min.css');

		$this -> layout -> add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this -> layout -> add_js('pages/EC-bootstrap-datepicker.min.js');
		$this -> layout -> add_js('pages/EC_jasny-bootstrap.min.js');

		$this -> layout -> render('list', $data);
	}

	public function get_data() {
		header('Content-Type: application/json');
		$this -> load -> model('ec_open_inv');
		$venno = $this -> session -> userdata['VENDOR_NO'];
		$venno = "0000112709";
		$dataa = $this -> ec_open_inv -> getMan($venno);
		$json_data = array('data' => $dataa);
		echo json_encode($json_data);
	}

	public function get_data_approved() {
		header('Content-Type: application/json');
		$this -> load -> model('ec_open_inv');
		$venno = $this -> session -> userdata['VENDOR_NO'];
		$venno = "0000112709";
		$dataa = $this -> ec_open_inv -> get_data_approved($venno);
		$json_data = array('data' => $dataa);
		echo json_encode($json_data);
	}

	public function get_data_proposal() {
		header('Content-Type: application/json');
		$this -> load -> model('ec_open_inv');
		$venno = $this -> session -> userdata['VENDOR_NO'];
		$venno = "0000112709";
		$dataa = $this -> ec_open_inv -> get_data_proposal($venno);
		$json_data = array('data' => $dataa);
		echo json_encode($json_data);
	}

	public function createINV() {
		$mat = $this -> input -> post('arrgr');
		$xpl = explode(',', $mat[0]);
		$mat = $this -> input -> post('arrgrl');
		$xpl2 = explode(',', $mat[0]);
		$this -> load -> model('ec_open_inv');
		$this -> load -> library('sap_handler');
		$this -> load -> model('ec_invoice_m');
		/*
		 "CURRENCY"=>$dataLC['CURRENCY'],"INVOICE_NO" => $dataLC['INV_NO'],"DOC_DATE" => $dataLC['INV_DATE'],"CHANGE_ON" =>date(Ymd),
		 "INVOICE_DATE" => $dataLC['INV_DATE'], "FAKTUR" => $dataLC['FAKTUR_PJK'], "TOTAL_AMOUNT" => $dataLC['TOTAL'],"NOTE" => $dataLC['NOTE'])
		 */
		$this -> load -> library("file_operation");
		$this -> load -> helper('file');
		$this -> load -> helper(array('form', 'url'));
		// header('Content-Type: application/json');
		// var_dump($_FILES);
		// if ($_FILES['picture']['size'] > 200000 && $_FILES['drawing']['size'] > 200000) {
		// }
		$uploaded = $this -> file_operation -> uploadT(UPLOAD_PATH . 'EC_invoice', $_FILES);
		if ($uploaded != null && $_FILES['fileInv']['name'] != "" && $_FILES['fileFaktur']['name'] != "" && sizeof($xpl2) != 0 && $this -> input -> post('invoice_date') != "" && $this -> input -> post('total') != "") {
			$this -> ec_open_inv -> createINV(array("INV_PIC" => $uploaded['fileInv']['file_name'], "FAKTUR_PIC" => $uploaded['fileFaktur']['file_name'], "INV_DATE" => $this -> input -> post('invoice_date'), "TOTAL" => $this -> input -> post('total'), "TAX_CODE" => $this -> input -> post('tax_type'), "CURRENCY" => $this -> input -> post('curr'), "INV_NO" => $this -> input -> post('invoice_no'), "FAKTUR_PJK" => str_replace(array('.', '-'), '', $this -> input -> post('faktur')), "NOTE" => $this -> input -> post('note')), $xpl, $xpl2);
		}

		$noinvoice = $this -> input -> post("invoice_no");
		$data = array("INVOICE_NO" => $this -> input -> post("invoice_no"), "DOC_DATE" => $this -> input -> post("PostingDate"), "POST_DATE" => $this -> input -> post("PostingDate"), "PAYMENT_BLOCK" => $this -> input -> post("PaymentBlock"), "NOTE_APPROVE" => $this -> input -> post("note"));
		$this -> ec_invoice_m -> updateHeader($data);
		$result = $this -> ec_invoice_m -> getINV($noinvoice);
		$dataINV = array("TAX_CODE" => $result[0]['TAX_CODE'], "TGL_INV" => substr($result[0]['INVOICE_DATE'], 6, 4) . substr($result[0]['INVOICE_DATE'], 3, 2) . substr($result[0]['INVOICE_DATE'], 0, 2), "TGL_POST" => substr($result[0]['POST_DATE'], 6, 4) . substr($result[0]['POST_DATE'], 3, 2) . substr($result[0]['POST_DATE'], 0, 2), "FAKTUR_PJK" => $result[0]['FAKTUR'], "CURR" => $result[0]['CURRENCY'], "TOTAL_AMOUNT" => $result[0]['TOTAL_AMOUNT'], "INV_NO" => $result[0]['INVOICE_NO'], "PAYMENT" => $result[0]['PAYMENT_BLOCK'], "NOTE_VERI" => $result[0]['NOTE_APPROVE']);
		$dataa = $this -> ec_open_inv -> getGR($noinvoice);
		foreach ($dataa as $value) {
			$dataGR[] = array("PO_NO" => $value['PO_NO'], "PO_ITEM_NO" => $value['PO_ITEM_NO'], "GR_NO" => $value['GR_NO'], "GR_YEAR" => $value['GR_YEAR'], "GR_ITEM_NO" => $value['GR_ITEM_NO'], "GR_AMOUNT_IN_DOC" => $value['GR_AMOUNT_IN_DOC'], "GR_ITEM_QTY" => $value['GR_ITEM_QTY'], "UOM" => $value['MEINS']);
		}
		// if($debug)
		// var_dump($dataGR);

		$invoice = $this -> sap_handler -> createInvEC($dataINV, $dataGR, true);
		$data = array("INVOICE_NO_SAP" => $invoice, "INVOICE_NO" => $this -> input -> post("invoice_no"));
		if ($invoice != "") {
			$this -> ec_invoice_m -> updateHeaderSukses($data);
		}
		redirect("EC_Open_invoice");
	}

	public function sapUpdate() {
		$this -> load -> library('sap_handler');
		$venno = $this -> session -> userdata['VENDOR_NO'];
		//$venno = "0000410000";
		$invoice = $this -> sap_handler -> getGR3($venno, '100', true);
	//	var_dump($invoice);
		$this -> load -> model('ec_open_inv');
		foreach ($invoice as $dataa) {
			$this -> ec_open_inv -> insert_sap($dataa, $venno);
		}

	}

        private function convertQuan($val){
            $minus = substr($val,-1);
            if($minus == '-'){
                $tmp = substr($val,0,strlen($minus) - 2);
                $val = (float)$tmp * -1;
            }else{
                $val = (float)$val;
            }
            return $val;
        }

	public function testSAP($debug = false) {
		$this -> load -> library('sap_handler');
	    //	$venno = $this -> session -> userdata['VENDOR_NO'];
                /* ambil 1 untuk barang dan 9 untuk jasa */
                $this->load->model('invoice/ec_gr_sap','gr_sap');
                $arrInsert = array();
                $arrJasa = array();
                $arrBarang = array();
                $jenisPo = 9;
								$awal = new DateTime();
		$arrJasa = $this -> sap_handler -> getALLGR('BT','20170220','20170328');
                $quanType = array(
                    'MENGE','BPMNG','WESBS','BPWES','BAMNG','MENGE_POP','BPMNG_POP','BPWEB','WESBB'
                );
                $kali100 = array('DMBTR','WRBTR');
                echo '<pre>';
								//print_r($arrJasa);
                foreach($arrJasa as $j){
                    foreach($quanType as $qq){
                        $j[$qq] = $this->convertQuan($j[$qq]);
                    }
                    if($j['WAERS'] == 'IDR'){
                        foreach($kali100 as $_k){
                            $j[$_k] = $j[$_k] * 100;
                        }
                    }
                    /* periksa di database dulu apakah sudah ada atau belum */
                    $uniqueKey = array('GJAHR' => $j['GJAHR'],'BELNR' => $j['BELNR'],'BUZEI' => $j['BUZEI']);
                    $ada = $this->gr_sap->get($uniqueKey);

                    if(!empty($ada)){
                        //echo 'update '.$this->gr_sap->update($j,$uniqueKey).'<br >';
											//	echo $this->gr_sap->update($j,$uniqueKey);
												//echo $this->db->last_query().'<br >';
                    }else{
                        echo $this->gr_sap->insert($j);
                    }

                }





            /*
            $this->load->config('ec');
            $c_header = $this->config->item('PO_ACTIVE');
            $c_detail = $this->config->item('DETAIL_PO');
            $kode_jasa = array(9);
            $this->db
                 ->select('EC_M_PO_HEADER.PO_NUMBER,PO_ITEM,ITEM_CAT')
                 ->join('EC_M_PO_DETAIL','EC_M_PO_DETAIL.PO_NUMBER = EC_M_PO_HEADER.PO_NUMBER and EC_M_PO_DETAIL.ITEM_CAT in ('.implode(',',$kode_jasa).')');
            foreach($c_header as $key => $val){
                $this->db->where_in($key,$val);
            }*/
            //$allPo = $this->db->get('EC_M_PO_HEADER');

            /* daftarkan dalam array baru untuk filter dari barang */
                /*
            $_filterArray = array();
            $semuaPo = $allPo->result_array();
            foreach($semuaPo as $_ss){
                $_key = $_ss['PO_NUMBER'].'&'.$_ss['PO_ITEM'];
                $_filterArray[$_key] = 1;
            }

            foreach($_arrBarang as $_ab){
                $_key = $_ab['EBELN'].'&'.$_ab['EBELP'];
                if(!isset($_filterArray[$key])){
                    array_push($arrBarang,$_ab);
                }
            }

            $arrInsert = array('9' => $arrJasa , '1' => $arrBarang);
            $insertGR = array();
            foreach($arrInsert as $vgabe => $_val){
                foreach($_val as $val){
                $tmp = array(
                    'PO_NO' => $val['EBELN'],
                    'PO_ITEM_NO' => $val['EBELP'],
                    'GR_NO' => $val['BELNR'],
                    'GR_ITEM_NO' => $val['BUZEI'],
                    'GR_YEAR' => $val['GJAHR'],
                    'GR_DATE' => $val['BUDAT'],
                    'GR_ITEM_QTY' => (int)$val['MENGE'],
                    'GR_AMOUNT_IN_DOC' => $val['WAERS'] == 'IDR' ? $val['WRBTR'] * 100 : $val['WRBTR'],
                    'GR_DOC_CURR' => $val['WAERS'],
                    'STATUS' => 0,
                    'MOVE_TYPE' => $val['BWART'],
                    'GR_AMOUNT_LOCAL' =>  $val['WAERS'] == 'IDR' ? $val['DMBTR'] * 100 : $val['DMBTR'],
                    'DEBET_KREDIT' => $val['SHKZG'],
                    'PLANT' => $val['WERKS'],
                    'DOC_DATE' => $val['BLDAT'],
                    'CREATE_ON' => $val['CPUDT'],
                    'CREATE_AT' => $val['CPUTM'],
                    'GR_CURR' => $val['WAERS'],
                    'VGABE' => $vgabe
                );
               // echo $this->db->insert('EC_GR',$tmp).' dari '.$tmp['GR_NO'].' dan '.$tmp['PO_NO'].'<br />';
            }
            }*/

	}

	public function get_approved() {
		$this -> load -> model('ec_open_inv');
		$datainvoice = $this -> ec_open_inv -> get_Invoince();

		// $this -> load -> model('EC_pricelist_m');
		// $dataa = $this -> EC_pricelist_m -> get($this -> input -> post('limitMin'), $this -> input -> post('limitMax'));
		//$dataPrice = $this -> EC_pricelist_m -> getPricelist($this->session->userdata['VENDOR_NO']);
		//$dataPrice = $this -> EC_pricelist_m -> getPricelist('122');
		//$page = $this -> EC_pricelist -> getAllCount();

		$json_data = array('page' => 10, 'data' => $this -> getALL($datainvoice));
		echo json_encode($json_data);
	}

	public function get_approved2() {
		$this -> load -> model('ec_open_inv');
		$datainvoice = $this -> ec_open_inv -> get_Invoince2();

		// $this -> load -> model('EC_pricelist_m');
		// $dataa = $this -> EC_pricelist_m -> get($this -> input -> post('limitMin'), $this -> input -> post('limitMax'));
		//$dataPrice = $this -> EC_pricelist_m -> getPricelist($this->session->userdata['VENDOR_NO']);
		//$dataPrice = $this -> EC_pricelist_m -> getPricelist('122');
		//$page = $this -> EC_pricelist -> getAllCount();

		$json_data = array('page' => 10, 'data' => $this -> getALL($datainvoice));
		echo json_encode($json_data);
	}

	public function get_reject() {
		$this -> load -> model('ec_open_inv');
		$datainvoice = $this -> ec_open_inv -> get_Rejected();

		// $this -> load -> model('EC_pricelist_m');
		// $dataa = $this -> EC_pricelist_m -> get($this -> input -> post('limitMin'), $this -> input -> post('limitMax'));
		//$dataPrice = $this -> EC_pricelist_m -> getPricelist($this->session->userdata['VENDOR_NO']);
		//$dataPrice = $this -> EC_pricelist_m -> getPricelist('122');
		//$page = $this -> EC_pricelist -> getAllCount();

		$json_data = array('page' => 10, 'data' => $this -> getALL($datainvoice));
		echo json_encode($json_data);
	}

	function getALL($dataa = '') {
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['INVOICE_NO'] != null ? $value['INVOICE_NO'] : "";
			$data[2] = $value['INVOICE_DATE'] != null ? $value['INVOICE_DATE'] : "";
			$data[3] = $value['FAKTUR'] != null ? $value['FAKTUR'] : "";
			$data[4] = $value['CURRENCY'] != null ? $value['CURRENCY'] : "";
			$data[5] = $value['TOTAL_AMOUNT'] != null ? $value['TOTAL_AMOUNT'] : "";
			$data[6] = $value['INV_PIC'] != null ? $value['INV_PIC'] : "";
			$data[7] = $value['FAKTUR_PIC'] != null ? $value['FAKTUR_PIC'] : "";
			$data[8] = $value['ALASAN_REJECT'] != null ? $value['ALASAN_REJECT'] : "";
			$data_tabel[] = $data;
		}
		return $data_tabel;
	}

	public function get_invoiceDetail($INVOICE_NO) {
		$this -> load -> model('ec_open_inv');
		$data = $this -> ec_open_inv -> get_InvoinceDetail($INVOICE_NO);

		// $this -> load -> model('EC_pricelist_m');
		// $dataa = $this -> EC_pricelist_m -> get($this -> input -> post('limitMin'), $this -> input -> post('limitMax'));
		//$dataPrice = $this -> EC_pricelist_m -> getPricelist($this->session->userdata['VENDOR_NO']);
		//$dataPrice = $this -> EC_pricelist_m -> getPricelist('122');
		//$page = $this -> EC_pricelist -> getAllCount();

		$json_data = array('data' => $this -> getALLDetail($data));
		echo json_encode($json_data);
	}

	function getALLDetail($dataa = '') {
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['GR_AMOUNT_IN_DOC'] != null ? $value['GR_AMOUNT_IN_DOC'] : "-";
			$data[2] = $value['GR_ITEM_QTY'] != null ? $value['GR_ITEM_QTY'] : "-";
			$data[3] = $value['PO_NO'] != null ? $value['PO_NO'] : "-";
			$data[4] = $value['PO_ITEM_NO'] != null ? $value['PO_ITEM_NO'] : "-";
			$data[5] = $value['GR_NO'] != null ? $value['GR_NO'] : "-";
			$data[6] = $value['GR_ITEM_NO'] != null ? $value['GR_ITEM_NO'] : "-";
			$data[7] = $value['FAKTUR'] != null ? $value['FAKTUR'] : "-";

			$data_tabel[] = $data;
		}
		return $data_tabel;
	}
}

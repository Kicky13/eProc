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
		$this -> layout -> add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this -> layout -> add_js('pages/EC-bootstrap-datepicker.min.js');
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
		if ($uploaded != null && $_FILES['fileInv']['name'] != "" && $_FILES['fileFaktur']['name'] != "" && sizeof($xpl2) != 0 && $this -> input -> post('invoice_date') != "") {
			$this -> ec_open_inv -> createINV(array("INV_PIC" => $uploaded['fileInv']['file_name'], "FAKTUR_PIC" => $uploaded['fileFaktur']['file_name'], "INV_DATE" => $this -> input -> post('invoice_date'), "TOTAL" => $this -> input -> post('total'), "CURRENCY" => $this -> input -> post('curr'), "INV_NO" => $this -> input -> post('invoice_no'), "FAKTUR_PJK" => $this -> input -> post('faktur'), "NOTE" => $this -> input -> post('note')), $xpl, $xpl2);
		}
		redirect("EC_Open_invoice");
	}

	public function sapUpdate() {
		$this -> load -> library('sap_handler');
		$venno = $this -> session -> userdata['VENDOR_NO'];
		$invoice = $this -> sap_handler -> getGR3($venno, false);
		$this -> load -> model('ec_open_inv');
		foreach ($invoice as $dataa) {
			$this -> ec_open_inv -> insert_sap($dataa, $venno);
		}

	}

	public function testSAP($debug = false) {
		$this -> load -> library('sap_handler');
		$venno = $this -> session -> userdata['VENDOR_NO'];
		$invoice = $this -> sap_handler -> getGR3($venno, TRUE);
		return;
		$this -> load -> model('ec_open_inv');
		$noinvoice = '002016275';
		$result = $this -> ec_open_inv -> getINV($noinvoice);
		$dataINV = array("TGL_INV" => $result[0]['INV_DATE'], "TGL_POST" => '20161010', "FAKTUR_PJK" => $result[0]['FAKTUR_PJK'], "CURR" => $result[0]['GR_DOC_CURR'], "TOTAL_AMOUNT" => $result[0]['TOTAL'], "INV_NO" => $result[0]['INV_NO'], "PAYMENT" => "3", "NOTE_VERI" => 'test aja');
		$dataa = $this -> ec_open_inv -> getGR($noinvoice);
		foreach ($dataa as $value) {//    $value['']
			$dataGR[] = array("PO_NO" => $value['PO_NO'], "PO_ITEM_NO" => $value['PO_ITEM_NO'], "GR_NO" => $value['GR_NO'], "GR_YEAR" => $value['GR_YEAR'], "GR_ITEM_NO" => $value['GR_ITEM_NO'], "GR_AMOUNT_IN_DOC" => $value['GR_AMOUNT_IN_DOC'], "GR_ITEM_QTY" => $value['GR_ITEM_QTY'], "UOM" => $value['GR_ITEM_UNIT']);
		}
		$invoice = $this -> sap_handler -> createInvEC($dataINV, $dataGR, true);

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

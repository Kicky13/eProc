<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Invoice_ver extends CI_Controller {

	private $USER;

	public function __construct() {
		parent::__construct();
		$this -> load -> library('Authorization');
		$this -> load -> helper('url');
		$this -> load -> library('Layout');
		$this -> load -> helper("security");
		//$this -> USER = explode("@", $this -> session -> userdata['USERNAME']);
	}

	public function index($kode = '-') {
		//$this -> load -> model('EC_pricelist');
		//$result = $this -> EC_pricelist -> getPebandingan($this -> session -> userdata['ID']);

		$data['title'] = "Invoice Verification";
		// $data['pc_code'] = $this -> getPC_CODE();
		// if ($kode != '') {
		// 	$data['kode'] = $kode;
		// }

		// if (!isset($_POST['tagsearch'])) {
		// 	$data['tag'] = '-';
		// } else
		// 	$data['tag'] = $_POST['tagsearch'];
		//$this -> input -> post('tagsearch');
		// echo $data['tag'];//($this -> input -> post('tagsearch'));
		// return '';

		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this -> layout -> add_js('pages/EC-bootstrap-datepicker.min.js');
		$this -> layout -> add_css('pages/EC_bootstrap-slider.min.css');
		$this -> layout -> add_js('pages/EC_bootstrap-slider.min.js');
		$this -> layout -> add_js('pages/EC-bootstrap-datepicker.min.js');
		$this -> layout -> add_js('pages/EC_invoice_head.js');
		$this -> layout -> add_css('pages/EC_menu_nav.css');
		$this -> layout -> add_js('pages/EC_nav_tree.js');
		$this -> layout -> add_css('pages/EC_nav_tree.css');
		$this -> layout -> add_css('pages/EC_style_ecatalog.css');
		$this -> layout -> render('list', $data);
	}

	public function index2($cheat = false) {
		$data['title'] = "E-Catalog";
		$data['cheat'] = $cheat;
		$data['pc_code'] = $this -> getPC_CODE();
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_js('pages/EC_pricelist.js');
		$this -> layout -> add_css('pages/EC_menu_nav.css');
		$this -> layout -> add_js('pages/EC_nav_tree.js');
		$this -> layout -> add_css('pages/EC_nav_tree.css');
		$this -> layout -> render('vendor_home', $data);
	}

	public function getPC_CODE() {
		$this -> load -> model('EC_principal_manufacturer_m');
		$nextPC_CODE = $this -> EC_principal_manufacturer_m -> getPC_CODE();
		$nextPC_CODE = "PC" . str_pad($nextPC_CODE, 8, "0", STR_PAD_LEFT);
		// echo $nextPC_CODE;
		return $nextPC_CODE;
	}

	public function get_data_tree() {
		header('Content-Type: application/json');
		$this -> load -> model('ec_master_category_m');
		$dataa = $this -> ec_master_category_m -> get();
		$i = 1;
		$data_tabel = array();
		// foreach ($dataa as $value) {
		// $data[0] = $i++;
		// $data[1] = $value['DOC_ID'];
		// $data[2] = $value['CATEGORY'] = !null ? $value['CATEGORY'] : "";
		// $data[3] = $value['TYPE'] = !null ? $value['TYPE'] : "";
		// $data[4] = $value['STATUS'];
		// $data_tabel[] = $data;
		// }
		$json_data = $dataa;
		// array('data' => $data_tabel);
		echo json_encode($json_data);
	}

	public function baru($id_parent) {
		print_r($id_parent);
		$this -> load -> model('ec_master_category_m');
		$data = array("KODE_PARENT" => $id_parent, "DESC" => $this -> input -> post("desc"), "KODE_USER" => $this -> input -> post("kode_user"), "LEVEL" => $this -> input -> post("level"));
		$this -> ec_master_category_m -> insertBaru($data);
		// $json_data = array('data' => 'sukses kah');
		// echo json_encode($json_data);
	}

	public function approve() {
		$this -> load -> library('sap_handler');
		$this -> load -> model('ec_open_inv');
		$noinvoice = $this -> input -> post("desc");

		$result = $this -> ec_open_inv -> getINV($noinvoice, $this -> input -> post("desc"), $this -> input -> post("desc"), $this -> input -> post("desc"), $this -> input -> post("desc"));
		$dataINV = array("TGL_INV" => $result[0]['INV_DATE'], "TGL_POST" => '20161010', "FAKTUR_PJK" => $result[0]['FAKTUR_PJK'], "CURR" => $result[0]['GR_DOC_CURR'], "TOTAL_AMOUNT" => $result[0]['TOTAL'], "INV_NO" => $result[0]['INV_NO'], "PAYMENT" => "3", "NOTE_VERI" => 'test aja');
		$dataa = $this -> ec_open_inv -> getGR($noinvoice);
		foreach ($dataa as $value) {//    $value['']
			$dataGR[] = array("PO_NO" => $value['PO_NO'], "PO_ITEM_NO" => $value['PO_ITEM_NO'], "GR_NO" => $value['GR_NO'], "GR_YEAR" => $value['GR_YEAR'], "GR_ITEM_NO" => $value['GR_ITEM_NO'], "GR_AMOUNT_IN_DOC" => $value['GR_AMOUNT_IN_DOC'], "GR_ITEM_QTY" => $value['GR_ITEM_QTY'], "UOM" => $value['MEINS']);
		}
		$invoice = $this -> sap_handler -> createInvEC($dataINV, $dataGR, true);
	}

	public function get_currency() {
		$this -> load -> model('EC_pricelist_m');
		$dataa = $this -> EC_pricelist_m -> get_MasterCurrency();
		//$dataPrice = $this -> EC_pricelist_m -> getPricelist($this->session->userdata['VENDOR_NO']);
		//$dataPrice = $this -> EC_pricelist_m -> getPricelist('122');
		//$page = $this -> EC_pricelist -> getAllCount();

		//$json_data = array('page' => 10, 'data' => $this -> getALL($dataa, $dataPrice));
		echo json_encode($dataa);
	}

	public function get_invoiceDetail($INVOICE_NO) {
		$this -> load -> model('ec_invoice_m');
		$data = $this -> ec_invoice_m -> get_InvoinceDetail($INVOICE_NO);

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
			//$data[8] = $value['TOTAL_AMOUNT'] != null ? $value['TOTAL_AMOUNT'] : "";

			// for ($p=0; $p < sizeof($dataPrice); $p++) {
			// 	if($data[1]==$dataPrice[$p]['MATNO']){
			// 		$data[4] = $dataPrice[$p]['PRICE_OFFER'] != null ? $dataPrice[$p]['PRICE_OFFER'] : "";
			// 		$data[5] = $dataPrice[$p]['CURR_OFFER'] != null ? $dataPrice[$p]['CURR_OFFER'] : "";
			// 		$data[6] = $dataPrice[$p]['VALID_START'] != null ? $dataPrice[$p]['VALID_START'] : "";
			// 		$data[7] = $dataPrice[$p]['VALID_END'] != null ? $dataPrice[$p]['VALID_END'] : "";
			// 		$data[8] = $dataPrice[$p]['STATUS'] != null ? $dataPrice[$p]['STATUS'] : "";
			// 		break;
			// 	}else{
			// 		$data[4] = "";
			// 		$data[5] = "";
			// 		$data[6] = "";
			// 		$data[7] = "";
			// 		$data[8] = "";
			// 	}
			// }
			//$data[3] = $value['netprice'] = !null ? $value['netprice'] : "";
			//$data[4] = "";
			//$data[5] = $value['contract_no'] = !null ? $value['contract_no'] : "";
			//$data[6] = $value['t_qty'] = !null ? $value['t_qty'] : "";
			//$data[7] = $value['vendorname'] = !null ? $value['vendorname'] : "";
			//$data[8] = $value['PC_CODE'] == null ? "-" : $value['PC_CODE'];
			//$data[9] = $value['validstart'] = !null ? $value['validstart'] : "";
			//$data[10] = $value['validend'] = !null ? $value['validend'] : "";
			//$data[11] = $value['plant'] == null ? "0" : $value['plant'];

			//$data[13] = $value['uom'] == null ? "" : $value['uom'];
			//$data[14] = $value['vendorno'] == null ? "0" : $value['vendorno'];
			//$data[15] = $value['curr'] == null ? "0" : $value['curr'];
			//$data[16] = $value['DESC'] == null ? "-" : $value['DESC'];
			$data_tabel[] = $data;
		}
		return $data_tabel;
	}

	public function get_data() {
		$this -> load -> model('ec_invoice_m');
		$datainvoice = $this -> ec_invoice_m -> get_Invoince();

		$this -> load -> model('EC_pricelist_m');
		$dataa = $this -> EC_pricelist_m -> get($this -> input -> post('limitMin'), $this -> input -> post('limitMax'));
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

			// for ($p=0; $p < sizeof($dataPrice); $p++) {
			// 	if($data[1]==$dataPrice[$p]['MATNO']){
			// 		$data[4] = $dataPrice[$p]['PRICE_OFFER'] != null ? $dataPrice[$p]['PRICE_OFFER'] : "";
			// 		$data[5] = $dataPrice[$p]['CURR_OFFER'] != null ? $dataPrice[$p]['CURR_OFFER'] : "";
			// 		$data[6] = $dataPrice[$p]['VALID_START'] != null ? $dataPrice[$p]['VALID_START'] : "";
			// 		$data[7] = $dataPrice[$p]['VALID_END'] != null ? $dataPrice[$p]['VALID_END'] : "";
			// 		$data[8] = $dataPrice[$p]['STATUS'] != null ? $dataPrice[$p]['STATUS'] : "";
			// 		break;
			// 	}else{
			// 		$data[4] = "";
			// 		$data[5] = "";
			// 		$data[6] = "";
			// 		$data[7] = "";
			// 		$data[8] = "";
			// 	}
			// }
			//$data[3] = $value['netprice'] = !null ? $value['netprice'] : "";
			//$data[4] = "";
			//$data[5] = $value['contract_no'] = !null ? $value['contract_no'] : "";
			//$data[6] = $value['t_qty'] = !null ? $value['t_qty'] : "";
			//$data[7] = $value['vendorname'] = !null ? $value['vendorname'] : "";
			//$data[8] = $value['PC_CODE'] == null ? "-" : $value['PC_CODE'];
			//$data[9] = $value['validstart'] = !null ? $value['validstart'] : "";
			//$data[10] = $value['validend'] = !null ? $value['validend'] : "";
			//$data[11] = $value['plant'] == null ? "0" : $value['plant'];

			//$data[13] = $value['uom'] == null ? "" : $value['uom'];
			//$data[14] = $value['vendorno'] == null ? "0" : $value['vendorno'];
			//$data[15] = $value['curr'] == null ? "0" : $value['curr'];
			//$data[16] = $value['DESC'] == null ? "-" : $value['DESC'];
			$data_tabel[] = $data;
		}
		return $data_tabel;
	}

	public function insertOffer() {
		$venno = $this -> session -> userdata['VENDOR_NO'];
		$harga = $this -> input -> post('harga');
		$curr = $this -> input -> post('curr');
		$matno = $this -> input -> post('matno');
		$start_date = $this -> input -> post('startdate');
		$end_date = $this -> input -> post('enddate');
		$status = $this -> input -> post('status');
		$this -> load -> model('EC_pricelist_m');
		$this -> EC_pricelist_m -> insertData($venno, $matno, $harga, $curr, $start_date, $end_date, $status);
		//echo json_encode('deleted');
	}

	public function getDetail($MATNR) {
		header('Content-Type: application/json');
		$this -> load -> model('EC_strategic_material_m');
		$data['MATNR'] = $this -> EC_strategic_material_m -> getDetail($MATNR);
		//substr($MATNR, 1));
		echo json_encode($data);
	}

	public function reject() {
		//print_r($id_parent);
		$this -> load -> model('ec_invoice_m');
		$data = array("INVOICE_NO" => $this -> input -> post("InvoiceNo"), "ALASAN_REJECT" => $this -> input -> post("reject"));
		$this -> ec_invoice_m -> updateData($data);
		// $json_data = array('data' => 'sukses kah');
		// echo json_encode($json_data);
		redirect('EC_Invoice_ver/');
	}

	public function ApproveInv() {
		//print_r($id_parent);
		$this -> load -> library('sap_handler');
		$this -> load -> model('ec_invoice_m');
		$this -> load -> model('ec_open_inv');
		$noinvoice = $this -> input -> post("InvoiceNoApp");
		$data = array("INVOICE_NO" => $this -> input -> post("InvoiceNoApp"), "DOC_DATE" => $this -> input -> post("DocumentDate"), "POST_DATE" => $this -> input -> post("PostingDate"), "PAYMENT_BLOCK" => $this -> input -> post("PaymentBlock"), "NOTE_APPROVE" => $this -> input -> post("Note"));
		$this -> ec_invoice_m -> updateHeader($data);
		$result = $this -> ec_invoice_m -> getINV($noinvoice);
		$dataINV = array("TGL_INV" => substr($result[0]['INVOICE_DATE'], 6, 4) . substr($result[0]['INVOICE_DATE'], 3, 2) . substr($result[0]['INVOICE_DATE'], 0, 2), "TGL_POST" => substr($result[0]['POST_DATE'], 6, 4) . substr($result[0]['POST_DATE'], 3, 2) . substr($result[0]['POST_DATE'], 0, 2), "FAKTUR_PJK" => $result[0]['FAKTUR'], "CURR" => $result[0]['CURRENCY'], "TOTAL_AMOUNT" => $result[0]['TOTAL_AMOUNT'], "INV_NO" => $result[0]['INVOICE_NO'], "PAYMENT" => $result[0]['PAYMENT_BLOCK'], "NOTE_VERI" => $result[0]['NOTE_APPROVE']);
		$dataa = $this -> ec_open_inv -> getGR($noinvoice);
		foreach ($dataa as $value) {
			$dataGR[] = array("PO_NO" => $value['PO_NO'], "PO_ITEM_NO" => $value['PO_ITEM_NO'], "GR_NO" => $value['GR_NO'], "GR_YEAR" => $value['GR_YEAR'], "GR_ITEM_NO" => $value['GR_ITEM_NO'], "GR_AMOUNT_IN_DOC" => $value['GR_AMOUNT_IN_DOC'], "GR_ITEM_QTY" => $value['GR_ITEM_QTY'], "UOM" => $value['MEINS']);
		}
		$invoice = $this -> sap_handler -> createInvEC($dataINV, $dataGR, false);
		$data = array("INVOICE_NO_SAP" => $invoice, "INVOICE_NO" => $this -> input -> post("InvoiceNoApp"));
		if ($invoice != "") {
			$this -> ec_invoice_m -> updateHeaderSukses($data);
		}
		redirect('EC_Invoice_ver/');
	}

}

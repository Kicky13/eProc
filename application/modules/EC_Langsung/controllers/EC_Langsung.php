<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Langsung extends CI_Controller {

	private $USER;

	public function __construct() {
		parent::__construct();
		$this -> load -> library('Authorization');
		$this -> load -> helper('url');
		$this -> load -> library('Layout');
		$this -> load -> helper("security");
		$this -> USER = explode("@", $this -> session -> userdata['USERNAME']);
	}

	public function listCatalog($kode = '-') {
		$data['title'] = "E-Catalog";
		$data['pc_code'] = $this -> getPC_CODE();
		if ($kode != '') {
			$data['kode'] = $kode;
		}

		if (!isset($_POST['tagsearch'])) {
			$data['tag'] = '-';
		} else
			$data['tag'] = $_POST['tagsearch'];
		//$this -> input -> post('tagsearch');
		// echo $data['tag'];//($this -> input -> post('tagsearch'));
		// return '';

		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_css('pages/EC_bootstrap-slider.min.css');
		$this -> layout -> add_js('pages/EC_bootstrap-slider.min.js');
		$this -> layout -> add_js('pages/EC_catalog_compare.js');
		$this -> layout -> add_css('pages/EC_menu_nav.css');
		$this -> layout -> add_js('pages/EC_nav_tree.js');
		$this -> layout -> add_css('pages/EC_nav_tree.css');
		$this -> layout -> add_css('pages/EC_style_ecatalog.css');
		$this -> layout -> render('list', $data);
	}

	public function listCatalogLsgs($kode = '-') {
		$data['title'] = "E-Catalog";
		$data['pc_code'] = $this -> getPC_CODE();
		if ($kode != '') {
			$data['kode'] = $kode;
		}

		if (!isset($_POST['tagsearch'])) {
			$data['tag'] = '-';
		} else
			$data['tag'] = $_POST['tagsearch'];
		//$this -> input -> post('tagsearch');
		// echo $data['tag'];//($this -> input -> post('tagsearch'));
		// return '';

		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_css('pages/EC_bootstrap-slider.min.css');
		$this -> layout -> add_js('pages/EC_bootstrap-slider.min.js');
		$this -> layout -> add_js('pages/EC_langsung.js');
		$this -> layout -> add_css('pages/EC_menu_nav.css');
		$this -> layout -> add_js('pages/EC_nav_tree.js');
		$this -> layout -> add_css('pages/EC_nav_tree.css');
		$this -> layout -> add_css('pages/EC_style_ecatalog.css');
		$this -> layout -> render('list_lgsg', $data);
	}

	public function index2($cheat = false) {
		$data['title'] = "E-Catalog";
		$data['cheat'] = $cheat;
		$data['pc_code'] = $this -> getPC_CODE();
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_js('pages/EC_catalog_compare.js');
		$this -> layout -> add_css('pages/EC_menu_nav.css');
		$this -> layout -> add_js('pages/EC_nav_tree.js');
		$this -> layout -> add_css('pages/EC_nav_tree.css');
		$this -> layout -> render('compare', $data);
	}

	public function history($cheat = false) {
		$data['title'] = "History PO";
		//$data['cheat'] = $cheat;
		//$data['pc_code'] = $this -> getPC_CODE();
		$data['po'] = $this -> testHistory();
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_js('pages/EC_catalog_compare.js');
		$this -> layout -> add_css('pages/EC_menu_nav.css');
		$this -> layout -> add_js('pages/EC_nav_tree.js');
		$this -> layout -> add_css('pages/EC_nav_tree.css');
		$this -> layout -> render('histori_po', $data);
	}

	public function perbandingan($cheat = false) {
		$this -> load -> model('EC_catalog_produk');
		$result = $this -> EC_catalog_produk -> getPebandingan($this -> session -> userdata['ID']);
		$datalk = array();
		for ($i = 0; $i < sizeof($result); $i++) {
			$result2 = $this -> EC_catalog_produk -> getLongteks($result[$i]['MATNR']);
			$datalk[] = $result2[0]['LNGTX'];
		}

		$data['title'] = "E-Catalog";
		$data['longteks'] = $datalk;
		$data['compare'] = $result;
		// header('Content-Type: application/json');
		// var_dump($data);
		//$data['pc_code'] = $this -> getPC_CODE();
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		//$this -> layout -> add_js('pages/EC_catalog_compare.js');
		$this -> layout -> add_css('pages/EC_menu_nav.css');
		$this -> layout -> add_js('pages/EC_affix_compare.js');
		$this -> layout -> add_js('pages/EC_nav_tree.js');
		$this -> layout -> add_css('pages/EC_nav_tree.css');
		if (sizeof($result) < 1) {
			redirect("EC_Ecatalog/listCatalog/");
		}
		$this -> layout -> render('perbandingan', $data);
	}

	public function index3($cheat = false) {
		$data['title'] = "E-Catalog";
		$data['cheat'] = $cheat;
		$data['pc_code'] = $this -> getPC_CODE();
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_js('pages/EC_catalog_compare.js');
		$this -> layout -> add_css('pages/EC_menu_nav.css');
		$this -> layout -> add_js('pages/EC_nav_tree.js');
		$this -> layout -> add_css('pages/EC_nav_tree.css');
		$this -> layout -> render('detail_produk', $data);
	}

	public function index() {
		$this -> load -> model('EC_strategic_material_m');
		$result = $this -> EC_strategic_material_m -> getRootCategory();

		$data['title'] = "E-Catalog";
		$data['kategori'] = $result;
		//$data['pc_code'] = $this -> getPC_CODE();
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_js('pages/EC_catalog_compare.js');
		$this -> layout -> add_css('pages/EC_menu_nav.css');
		$this -> layout -> add_js('pages/EC_nav_tree.js');
		$this -> layout -> add_css('pages/EC_nav_tree.css');
		$this -> layout -> render('homepage', $data);
	}

	function getALL($dataa = '') {
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['MATNR'] = !null ? $value['MATNR'] : "";
			$data[2] = $value['MAKTX'] = !null ? $value['MAKTX'] : "";
			$data[3] = $value['netprice'] = !null ? $value['netprice'] : "";
			$data[4] = "";
			$data[5] = $value['contract_no'] = !null ? $value['contract_no'] : "";
			$data[6] = $value['t_qty'] = !null ? $value['t_qty'] : "";
			$data[7] = $value['vendorname'] = !null ? $value['vendorname'] : "";
			$data[8] = $value['PC_CODE'] == null ? "-" : $value['PC_CODE'];
			$data[9] = $value['validstart'] = !null ? $value['validstart'] : "";
			$data[10] = $value['validend'] = !null ? $value['validend'] : "";
			$data[11] = $value['plant'] == null ? "0" : $value['plant'];
			$data[12] = $value['PICTURE'] == null ? "default_post_img.png" : $value['PICTURE'];
			$data[13] = $value['uom'] == null ? "" : $value['uom'];
			$data[14] = $value['vendorno'] == null ? "0" : $value['vendorno'];
			$data[15] = $value['curr'] == null ? "0" : $value['curr'];
			$data[16] = $value['DESC'] == null ? "-" : $value['DESC'];
			$data[17] = $value['inco1'] == null ? "" : $value['inco1'];
			$data[18] = $value['inco2'] == null ? "" : $value['inco2'];
			$data_tabel[] = $data;
		}
		return $data_tabel;
	}

	function get_data_tag($value) {
		$this -> load -> model('EC_catalog_produk');
		// var_dump(
		// header('Content-Type: application/json');
		$dataa = $this -> EC_catalog_produk -> get_data_tag($value, $this -> input -> post('limitMin'), $this -> input -> post('limitMax'));
		$page = $this -> EC_catalog_produk -> getAllCount('tag', $value);
		$json_data = array('page' => $page, 'data' => $this -> getALL($dataa));
		echo json_encode($json_data);
		// var_dump($dataa);
		// $this -> listCatalog($dataa);
	}

	function get_data_harga($kode) {
		$this -> load -> model('EC_catalog_produk');
		// var_dump(
		// header('Content-Type: application/json');
		$dataa = $this -> EC_catalog_produk -> get_data_harga($this -> input -> post('min'), $this -> input -> post('max'), $this -> input -> post('limitMin'), $this -> input -> post('limitMax'), $kode);
		$page = $this -> EC_catalog_produk -> getAllCount('harga', $this -> input -> post('min'), $this -> input -> post('max'));
		$json_data = array('page' => $page, 'data' => $this -> getALL($dataa));

		echo json_encode($json_data);
		// var_dump($dataa);
		// $this -> listCatalog($dataa);
	}

	function get_data_category($value) {
		$this -> load -> model('EC_catalog_produk');
		// var_dump(
		// header('Content-Type: application/json');
		$dataa = $this -> EC_catalog_produk -> get_data_category($value, $this -> input -> post('limitMin'), $this -> input -> post('limitMax'));
		$page = $this -> EC_catalog_produk -> getAllCount('cat', $value);
		$json_data = array('page' => $page, 'data' => $this -> getALL($dataa));
		echo json_encode($json_data);
		// var_dump($dataa);
		// $this -> listCatalog($dataa);
	}

	public function testi($value = '') {
		var_dump('$expression');
	}

	public function hapus_compare($matno) {
		$this -> load -> model('EC_catalog_produk');
		$this -> EC_catalog_produk -> hapus_compare($this -> session -> userdata['ID'], $matno, $this -> uri -> segment(4));
		$result = $this -> EC_catalog_produk -> getPebandingan($this -> session -> userdata['ID']);
		if (sizeof($result) == 0) {
			redirect("EC_Ecatalog/listCatalog/");
		}
		redirect("EC_Ecatalog/perbandingan");
	}

	public function confirm($cheat = false) {
		$this -> load -> model('EC_catalog_produk');
		$this -> load -> library('sap_handler');
		$dataa = $this -> EC_catalog_produk -> get_data_checkout_PO($this -> session -> userdata['ID']);
		// header('Content-Type: application/json');
		$cntr = "-";
		$kirim = array();
		for ($i = 0; $i < sizeof($dataa); $i++) {
			if ($cntr != $dataa[$i]['contract_no']) {
				// var_dump($kirim);
				if (sizeof($kirim) != 0) {
					$kmbl = $this -> sap_handler -> createPOCatalog($kirim, false);
					if (strpos($kmbl, 'PO created') != FALSE) {
						$this -> EC_catalog_produk -> POsuccess($this -> session -> userdata['ID'], $kmbl, $kirim[0]['contract_no']);
					}
				}
				$kirim = array();
				$cntr = $dataa[$i]['contract_no'];
				$kirim[] = $dataa[$i];
			} else {
				$kirim[] = $dataa[$i];
			}
		}
		// var_dump($kirim);
		$kmbl = $this -> sap_handler -> createPOCatalog($kirim, false);
		if (strpos($kmbl, 'PO created') != FALSE) {
			$this -> EC_catalog_produk -> POsuccess($this -> session -> userdata['ID'], $kmbl, $kirim[0]['contract_no']);
			// echo json_encode($kmbl);
		}
		// else {
		$dataPO = $this -> EC_catalog_produk -> get_data_checkout_after_PO($dataa);
		// var_dump($dataPO);
		echo json_encode($dataPO);
		// }
	}

	public function confirmOne() {
		$this -> load -> model('EC_catalog_produk');
		// header('Content-Type: application/json');
		$this -> EC_catalog_produk -> addCart($this -> input -> post('matno'), $this -> input -> post("contract_no"), $this -> session -> userdata['ID'], date("Ymd"), $this -> input -> post("qty"), 1, 0);
		$dataa = $this -> EC_catalog_produk -> get_data_checkout_PO_One($this -> session -> userdata['ID'], $this -> input -> post('contract_no'), $this -> input -> post('matno'));
		// var_dump($dataa);
		$this -> load -> library('sap_handler');
		$kmbl = $this -> sap_handler -> createPOCatalog($dataa, false);
		if (strpos($kmbl, 'PO created') != FALSE) {
			$this -> EC_catalog_produk -> POsuccessOne($this -> session -> userdata['ID'], $this -> input -> post('contract_no'), $this -> input -> post('matno'), $kmbl, $dataa[0]['ID_CHART']);
			$dataPO = $this -> EC_catalog_produk -> get_data_checkout_after_PO($dataa);
			echo json_encode($dataPO);
		} else {
			echo json_encode($dataPO);
		}
	}

	// public function history($cheat = false) {
	// 	$data['title'] = "E-Catalog-Check Out";
	// 	$data['cheat'] = $cheat;
	// 	$this -> layout -> set_table_js();
	// 	$this -> layout -> set_table_cs();
	// 	// $this -> layout -> add_js('pages/catalog_compare.js');
	// 	$this -> layout -> add_css('pages/EC_menu_nav.css');
	// 	$this -> layout -> add_js('pages/EC_nav_tree.js');
	// 	$this -> layout -> add_css('pages/EC_nav_tree.css');
	// 	$this -> layout -> add_css('pages/EC_checkout.css');
	// 	$this -> layout -> render('history', $data);
	// }

	public function checkout($cheat = false) {
		$data['title'] = "Check Out | E-Catalog";
		$data['cheat'] = $cheat;
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_css('pages/EC_menu_nav.css');
		$this -> layout -> add_js('pages/EC_nav_tree.js');
		$this -> layout -> add_css('pages/EC_nav_tree.css');
		$this -> layout -> add_css('pages/EC_style_ecatalog.css');
		$this -> layout -> add_css('pages/EC_checkout.css');
		$this -> layout -> add_js('pages/EC_catalog_checkout.js');
		$this -> layout -> render('checkout', $data);
	}

	function compares() {
		// header('Content-Type: application/json');
		$mat = $this -> input -> post('arr');
		$xpl = explode(',', $mat[0]);
		$mat = $this -> input -> post('arrC');
		$xpl2 = explode(',', $mat[0]);
		// print_r($xpl);
		$this -> load -> model('EC_strategic_material_m');
		// $result = $this -> EC_strategic_material_m -> getDetailCompare($xpl);
		$result = $this -> EC_strategic_material_m -> getDetailCompare($xpl, $xpl2);
		// var_dump($xpl);
		// var_dump($xpl2);
		// var_dump($result);
		// return "";
		for ($i = 0; $i < sizeof($result); $i++) {
			$result2 = $this -> EC_strategic_material_m -> getLongteks($result[$i]['MATNR']);
			$datalk[] = $result2[0]['LNGTX'];
		}
		// $data['dataCom']=$result

		$data['title'] = "Comapre Product | E-Catalog";
		//$data['cheat'] = $cheat;
		//$data['pc_code'] = $this -> getPC_CODE();
		$data['data_compare'] = $result;
		$data['longteks'] = $datalk;
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_js('pages/EC_catalog_compare.js');
		// $this -> layout -> add_css('pages/menu_nav.css');
		$this -> layout -> render('compare', $data);

		//echo json_encode($result);
	}

	public function teslgtk($ptm = '') {
		$this -> load -> model('EC_strategic_material_m');
		var_dump($this -> EC_strategic_material_m -> getDetail($ptm));

	}

	function detail_prod($contract_no) {
		// header('Content-Type: application/json');
		//$mat = $this -> input -> post('arr');
		//$no_ci = explode(',', $mat[0]);
		// print_r($xpl);
		$this -> load -> model('EC_strategic_material_m');
		$result = $this -> EC_strategic_material_m -> getDetailProduk($contract_no, $this -> uri -> segment(4));
		$result2 = $this -> EC_strategic_material_m -> getLongteks($result[0]['MATNR']);
		$data['longteks'] = $result2[0]['LNGTX'];
		$this -> load -> model('ec_catalog_produk');
		$feedback = $this -> ec_catalog_produk -> getfeedback($contract_no, $this -> uri -> segment(4));
		// str_replace('||','<br />',$result2[0]['LNGTX']) ;
		// $data['dataCom']=$result
		// var_dump($result);
		$data['title'] = "Detail Product | E-Catalog";
		//$data['cheat'] = $cheat;
		//$data['pc_code'] = $this -> getPC_CODE();
		$data['data_produk'] = $result;
		$data['feedback'] = $feedback;
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_js('pages/star-rating.min.js');
		$this -> layout -> add_css('pages/star-rating.min.css');
		//$this -> layout -> add_js('pages/ratingstar.js');
		$this -> layout -> add_js('pages/EC_catalog_compare.js');
		$this -> layout -> add_css('pages/EC_menu_nav.css');
		$this -> layout -> add_js('pages/EC_nav_tree.js');
		$this -> layout -> add_css('pages/EC_nav_tree.css');
		$this -> layout -> render('detail_produk', $data);

		//echo json_encode($result);
	}

	public function ubahStat($PC_CODE) {
		$this -> load -> model('EC_principal_manufacturer_m');
		//  date("d.m.Y")  $this->session->userdata['PRGRP']
		$data = array("PC_CODE" => $PC_CODE, "VENDOR_ID" => $this -> input -> post('VENDOR_ID'), "ID_R1" => $this -> input -> post('ID_R1'), "BY" => $this -> USER[0], "ON" => date("d-m-Y h:i:s"), "STATUS" => $this -> input -> post('checked'));
		$this -> EC_principal_manufacturer_m -> ubahStat($data);
	}

	public function get_data_checkout() {
		$this -> load -> model('EC_catalog_produk');
		$dataa = $this -> EC_catalog_produk -> get_data_checkout($this -> session -> userdata['ID']);
		$i = 1;
		$total = 0;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['MATNR'] = !null ? $value['MATNR'] : "";
			$data[2] = $value['MAKTX'] = !null ? $value['MAKTX'] : "";
			$data[3] = $value['netprice'] = !null ? $value['netprice'] : "";
			$data[4] = "";
			$data[5] = $value['contract_no'] = !null ? $value['contract_no'] : "";
			$data[6] = $value['t_qty'] = !null ? $value['t_qty'] : "";
			$data[7] = $value['vendorname'] = !null ? $value['vendorname'] : "";
			$data[8] = $value['PC_CODE'] == null ? "-" : $value['PC_CODE'];
			$data[9] = $value['validstart'] = !null ? $value['validstart'] : "";
			$data[10] = $value['validend'] = !null ? $value['validend'] : "";
			$data[11] = $value['plant'] == null ? "0" : $value['plant'];
			$data[12] = $value['PICTURE'] == null ? "default_post_img.png" : $value['PICTURE'];
			$data[13] = $value['uom'] == null ? "" : $value['uom'];
			$data[14] = $value['vendorno'] == null ? "0" : $value['vendorno'];
			$data[15] = $value['ID_CHART'] == null ? "0" : $value['ID_CHART'];
			$data[16] = $value['STATUS_CHART'] == null ? "0" : $value['STATUS_CHART'];
			$data[17] = $value['QTY'] == null ? "0" : $value['QTY'];
			if ($data[16] == 0) {
				$total += ($data[3] * $data[17]);
			}
			$data_tabel[] = $data;
		}
		$json_data = array('data' => $data_tabel, 'total' => $total);
		echo json_encode($json_data);
	}

	public function updQtyCart($ID) {
		$this -> load -> model('EC_catalog_produk');
		$this -> EC_catalog_produk -> updQtyCart($ID, $this -> input -> post("qty"));
		echo json_encode('pls min');
	}

	public function minqtyCart($ID) {
		$this -> load -> model('EC_catalog_produk');
		$this -> EC_catalog_produk -> minqtyCart($ID);
		echo json_encode('min 1');
	}

	public function plsqtyCart($ID) {
		$this -> load -> model('EC_catalog_produk');
		$this -> EC_catalog_produk -> plsqtyCart($ID);
		echo json_encode('pls 1');
	}

	public function addCart($MATNO) {
		$this -> load -> model('EC_catalog_produk');
		$jml = $this -> EC_catalog_produk -> addCart($MATNO, $this -> input -> post("contract_no"), $this -> session -> userdata['ID'], date("Ymd"));
		echo json_encode($jml);
	}

	public function addCompare($MATNO) {
		$this -> load -> model('EC_catalog_produk');
		$jml = $this -> EC_catalog_produk -> addCompare($MATNO, $this -> input -> post("contract_no"), $this -> session -> userdata['ID']);
		echo json_encode($jml);
	}

	public function geser($MATNO) {
		$this -> load -> model('EC_catalog_produk');
		$jml = $this -> EC_catalog_produk -> moveTo($MATNO, $this -> input -> post("contract_no"), $this -> session -> userdata['ID'], $this -> input -> post("kode"));
		//$jml = $this -> EC_catalog_produk -> moveTo('623-201876', '1300000033', '10164', '-1');
		echo json_encode($jml);
	}

	public function cancelCart($ID) {
		$this -> load -> model('EC_catalog_produk');
		$this -> EC_catalog_produk -> cancelCart($ID);
		echo json_encode('canceled');
	}

	public function deleteCart($ID) {
		$this -> load -> model('EC_catalog_produk');
		$this -> EC_catalog_produk -> deleteCart($ID);
		echo json_encode('deleted');
	}

	public function readdCart($ID) {
		$this -> load -> model('EC_catalog_produk');
		$this -> EC_catalog_produk -> readdCart($ID);
		echo json_encode('---');
	}

	public function rangeHarga($cat) {
		$this -> load -> model('EC_catalog_produk');
		$data = $this -> EC_catalog_produk -> rangeHarga($cat);
		echo json_encode($data);
	}

	public function baru() {
		$this -> load -> model('EC_principal_manufacturer_m');
		$this -> load -> library("file_operation");
		$this -> load -> helper('file');
		$this -> load -> helper(array('form', 'url'));
		$uploaded = $this -> file_operation -> uploadT(UPLOAD_PATH . 'principal_manufacturer', $_FILES);
		if ($uploaded != null) {
			$data = array("PC_CODE" => $this -> input -> post("PC_CODE"), "PC_NAME" => $this -> input -> post("PC_NAME"), "COUNTRY" => $this -> input -> post("COUNTRY"), "ADDRESS" => $this -> input -> post("ADDRESS"), "PHONE" => $this -> input -> post("PHONE"), "FAX" => $this -> input -> post("FAX"), "MAIL" => $this -> input -> post("MAIL"), "WEBSITE" => $this -> input -> post("WEBSITE"), "LOGO" => $uploaded['LOGO']['file_name'], "CREATEDBY" => $this -> USER[0], "CREATEDON" => date("d-m-Y h:i:s"), "CHANGEDBY" => $this -> USER[0], "CHANGEDON" => date("d-m-Y h:i:s"));
			$this -> EC_principal_manufacturer_m -> insert($data);
		} else if ($uploaded[0] == "gagal") {
			//redirect("Principal_manufacturer/");
		}
		redirect("EC_Principal_manufacturer/");

	}

	public function upload($PC_CODE) {
		$this -> load -> model('EC_principal_manufacturer_m');
		$this -> load -> library("file_operation");
		$this -> load -> helper('file');
		$this -> load -> helper(array('form', 'url'));
		$uploaded = $this -> file_operation -> uploadT(UPLOAD_PATH . 'principal_manufacturer', $_FILES);
		if ($uploaded != null) {
			$data = array("LOGO" => $uploaded['LOGO']['file_name'], "PC_CODE" => $PC_CODE, "BY" => $this -> USER[0], "ON" => date("d-m-Y h:i:s"));
			$this -> EC_principal_manufacturer_m -> upload($data);
		} else if ($uploaded[0] == "gagal") {
			//redirect("Principal_manufacturer/");
		}
		redirect("EC_Principal_manufacturer/");

	}

	public function getPC_CODE() {
		$this -> load -> model('EC_principal_manufacturer_m');
		$nextPC_CODE = $this -> EC_principal_manufacturer_m -> getPC_CODE();
		$nextPC_CODE = "PC" . str_pad($nextPC_CODE, 8, "0", STR_PAD_LEFT);
		// echo $nextPC_CODE;
		return $nextPC_CODE;
	}

	public function getVendorNo($vendorno) {
		$this -> load -> model('EC_catalog_produk');
		$vendor = $this -> EC_catalog_produk -> getVendor($vendorno);
		echo json_encode($vendor);
	}

	public function getPrincipal($pccode) {
		$this -> load -> model('EC_catalog_produk');
		$principal = $this -> EC_catalog_produk -> getPrincipal($pccode);
		$partner = $this -> EC_catalog_produk -> getPartner($pccode);
		//echo json_encode($principal);
		$json_data = array('principal' => $principal, 'partner' => $partner);
		echo json_encode($json_data);
	}

	function getCurrentBudget() {
		$this -> load -> library('sap_handler');
		return ($this -> sap_handler -> getCurrentBudget($this -> session -> userdata['ID'], true));
	}

	public function get_data_cart($debug = false) {
		if ($debug) {
			header('Content-Type: application/json');
			// var_dump($this -> session -> userdata);
		}
		$this -> load -> library('sap_handler');
		$budget = ($this -> sap_handler -> getCurrentBudget($this -> session -> userdata['ID']));
		$cost_center_desc = $this -> sap_handler -> getCurrentBudget($this -> session -> userdata['ID']);
		$this -> load -> model('EC_catalog_produk');
		$jml = $this -> EC_catalog_produk -> getCartCount($this -> session -> userdata['ID'], date("Ymd"));
		$jml2 = $this -> EC_catalog_produk -> getCompareCount($this -> session -> userdata['ID']);
		$dataa = $this -> EC_catalog_produk -> get_data_checkout($this -> session -> userdata['ID']);
		$page = $this -> EC_catalog_produk -> getAllCount();
		$total = 0;
		foreach ($dataa as $value) {
			$data[3] = $value['netprice'] = !null ? $value['netprice'] : "";
			$data[16] = $value['STATUS_CHART'] == null ? "0" : $value['STATUS_CHART'];
			$data[17] = $value['QTY'] == null ? "0" : $value['QTY'];
			if ($data[16] == 0) {
				$total += ($data[3] * $data[17]);
			}
		}
		$detailActualCommit = array();
		$budgetCommit = $budget['detailCommit'];
		$budgetActual = $budget['detailActual'];
		for ($i = 0; $i < sizeof($budgetCommit); $i++) {
			$ketemu = FALSE;
			$index = 0;
			for ($j = 0; $j < sizeof($detailActualCommit); $j++) {
				if ($budgetCommit[$i]['glItem'] == $detailActualCommit[$j]['glItem']) {
					$ketemu = TRUE;
					$index = $j;
					break;
				}
			}
			if ($ketemu) {
				$detailActualCommit[$index]['budgetCommit'] += $budgetCommit[$i]['budget'];
			} else {
				$detail['glItem'] = $budgetCommit[$i]['glItem'];
				$detail['glDesc'] = $budgetCommit[$i]['glDesc'];
				$detail['budgetCommit'] = $budgetCommit[$i]['budget'];
				$detail['budgetActual'] = '';
				$detailActualCommit[] = $detail;
			}
		}
		for ($i = 0; $i < sizeof($budgetActual); $i++) {
			$ketemu = FALSE;
			$index = 0;
			for ($j = 0; $j < sizeof($detailActualCommit); $j++) {
				if ($budgetActual[$i]['glItem'] == $detailActualCommit[$j]['glItem']) {
					$ketemu = TRUE;
					$index = $j;
					break;
				}
			}
			if ($ketemu) {
				$detailActualCommit[$index]['budgetActual'] += $budgetActual[$i]['budget'];
			} else {
				$detail['glItem'] = $budgetActual[$i]['glItem'];
				$detail['glDesc'] = $budgetActual[$i]['glDesc'];
				$detail['budgetCommit'] = '';
				$detail['budgetActual'] = $budgetActual[$i]['budget'];
				$detailActualCommit[] = $detail;
			}
		}
		if ($debug) {
			var_dump($detailActualCommit);
			return '';
		}
		$json_data = array('page' => $page, 'jumlah' => $jml, 'detailActualCommit' => $detailActualCommit, 'detailActual' => $budget['detailActual'], 'detailCommit' => $budget['detailCommit'], 'cost_center' => $budget['kostl'], 'cost_center_desc' => $budget['kostl_desc'], 'budget' => $budget['total'], 'actual_budget' => $budget['actual'], 'commit_budget' => $budget['commit'], 'current_budget' => $budget['current'], 'compare' => $jml2, 'total' => $total);
		echo json_encode($json_data);
	}

	public function get_data_lgsg() {
		if (false) {
			$search = $this -> input -> post('search');
			$kategori = $this -> input -> post('kategori');
			$harga_min = $this -> input -> post('harga_min');
			$harga_max = $this -> input -> post('harga_max');
			$limitMin = $this -> input -> post('limitMin');
			$limitMax = $this -> input -> post('limitMax');
		}

		$this -> load -> model('EC_catalog_produk');
		$dataa = $this -> EC_catalog_produk -> get($this -> input -> post('limitMin'), $this -> input -> post('limitMax'));
		$page = $this -> EC_catalog_produk -> getAllCount();

		$json_data = array('page' => $page, 'data' => $this -> getALL($dataa));
		echo json_encode($json_data);
	}

	public function get_data() {
		$this -> load -> model('EC_catalog_produk');
		$dataa = $this -> EC_catalog_produk -> get($this -> input -> post('limitMin'), $this -> input -> post('limitMax'));
		$page = $this -> EC_catalog_produk -> getAllCount();
		$json_data = array('page' => $page, 'data' => $this -> getALL($dataa));
		echo json_encode($json_data);
	}

	public function get_data_pricelist() {
		$this -> load -> model('EC_pricelist_m');
		$dataa = $this -> EC_pricelist_m -> get($this -> input -> post('limitMin'), $this -> input -> post('limitMax'));
		// $dataPrice = $this -> EC_pricelist_m -> getPricelist($this->session->userdata['VENDOR_NO']);
		$json_data = array('page' => 10, 'data' => $this -> getALL_pricelist($dataa));
		echo json_encode($json_data);
	}

	public function getTblDetail($PC_CODE) {
		$this -> load -> model('EC_principal_manufacturer_m');
		$dataa = $this -> EC_principal_manufacturer_m -> getTblDetail($PC_CODE);
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['PC_CODE'];
			$data[2] = $value['VENDOR_ID'] = !null ? $value['VENDOR_ID'] : "";
			$data[3] = $value['VENDOR_NO'] = !null ? $value['VENDOR_NO'] : "";
			$data[4] = $value['VENDOR_NAME'] = !null ? $value['VENDOR_NAME'] : "";
			$data[5] = $value['ADDRESS_COUNTRY'] = !null ? $value['ADDRESS_COUNTRY'] : "";
			$data[6] = $value['ADDRESS_PHONE_NO'] = !null ? $value['ADDRESS_PHONE_NO'] : "";
			$data[7] = $value['ADDRESS_WEBSITE'] = !null ? $value['ADDRESS_WEBSITE'] : "";
			$data[8] = $value['EMAIL_ADDRESS'] = !null ? $value['EMAIL_ADDRESS'] : "";
			$data[10] = $value['ID_R1'];
			$data_tabel[] = $data;
		}
		$json_data = /*$data_tabel;*/
		array('data' => $data_tabel);
		echo json_encode($json_data);
	}

	public function get_dataBPA($PC_CODE) {
		$this -> load -> model('EC_principal_manufacturer_m');
		$dataa = $this -> EC_principal_manufacturer_m -> get_dataBPA($PC_CODE);
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['PC_CODE'];
			$data[2] = $value['VENDOR_ID'] = !null ? $value['VENDOR_ID'] : "";
			$data[3] = $value['VENDOR_NO'] = !null ? $value['VENDOR_NO'] : "";
			$data[4] = $value['VENDOR_NAME'] = !null ? $value['VENDOR_NAME'] : "";
			$data[5] = $value['ADDRESS_COUNTRY'] = !null ? $value['ADDRESS_COUNTRY'] : "";
			$data[6] = $value['ADDRESS_PHONE_NO'] = !null ? $value['ADDRESS_PHONE_NO'] : "";
			$data[7] = $value['ADDRESS_WEBSITE'] = !null ? $value['ADDRESS_WEBSITE'] : "";
			$data[8] = $value['EMAIL_ADDRESS'] = !null ? $value['EMAIL_ADDRESS'] : "";
			$data[9] = $value['STATUS'];
			$data[10] = $value['ID_R1'];
			$data_tabel[] = $data;
		}
		$json_data = /*$data_tabel;*/
		array('data' => $data_tabel);
		echo json_encode($json_data);
	}

	public function getDetail($PC_CODE) {
		$this -> load -> model('EC_principal_manufacturer_m');
		$data['PC'] = $this -> EC_principal_manufacturer_m -> getDetail($PC_CODE);
		//substr($MATNR, 1));
		echo json_encode($data);
	}

	function getALL_pricelist($dataa = '', $dataPrice = '') {
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['MATNR'] != null ? $value['MATNR'] : "";
			$data[2] = $value['MAKTX'] != null ? $value['MAKTX'] : "";
			$data[3] = $value['PICTURE'] == null ? "default_post_img.png" : $value['PICTURE'];
			$data[4] = "";
			$data[5] = "";
			$data[6] = "";
			$data[7] = "";
			$data[8] = "";
			$data_tabel[] = $data;
		}
		return $data_tabel;
	}

	public function testFNC($value = '') {
		$this -> load -> model('EC_catalog_produk');
		// header('Content-Type: application/json');
		$dataa = $this -> EC_catalog_produk -> get_data_checkout_PO($this -> session -> userdata['ID']);
		header('Content-Type: application/json');
		var_dump($dataa);
	}

	public function testHistory() {
		$this -> load -> model('EC_catalog_produk');
		//header('Content-Type: application/json');
		$dataHeader = $this -> EC_catalog_produk -> get_history_PO_header($this -> session -> userdata['ID']);
		// var_dump($dataHeader);
		$dataMat = $this -> EC_catalog_produk -> get_history_PO($this -> session -> userdata['ID']);
		// var_dump($dataa);
		$hasil = array();
		for ($i = 0; $i < sizeof($dataHeader); $i++) {
			$data['PO_NO'] = $dataHeader[$i]['PO_NO'];
			$data['DATE_BUY'] = $dataHeader[$i]['DATE_BUY'];
			$data['contract_no'] = $dataHeader[$i]['contract_no'];
			$data['vendorname'] = $dataHeader[$i]['vendorname'];
			$data['vendorno'] = $dataHeader[$i]['vendorno'];
			$material = array();
			$total = 0;
			for ($j = 0; $j < sizeof($dataMat); $j++) {
				if ($dataMat[$j]['PO_NO'] == $data['PO_NO']) {
					$material[] = $dataMat[$j];
					$total += ($dataMat[$j]['QTY'] * $dataMat[$j]['netprice']);
				}
			}
			$data['TOTAL'] = $total;
			$data['MATERIAL'] = $material;
			$hasil[] = $data;
		}
		//var_dump($hasil);
		return $hasil;
	}

	public function testSAP($debug = false, $value = '') {
		if ($debug) {
			header('Content-Type: application/json');
			var_dump($this -> session -> userdata);
			return '';
		}
		$this -> load -> library('sap_handler');
		// return $this -> sap_handler -> getPRPricelist(array('ZBS'), true);
		return $this -> sap_handler -> getCurrentBudget($this -> session -> userdata['ID'], TRUE);
	}

	public function feedback() {
		//print_r($id_parent);
		$this -> load -> model('ec_catalog_produk');
		$data = array("ID_USER" => $this -> session -> userdata['ID'], "MATNO" => $this -> input -> post("matno"), "CONTRACT_NO" => $this -> input -> post("contract_no"), "DATETIME" => date("Y-m-d h:i:s"), "ULASAN" => $this -> input -> post("ulasan"), "RATING" => $this -> input -> post("rating-input"), "USERNAME" => $this -> session -> userdata['USERNAME']);
		$this -> ec_catalog_produk -> insertFeedback($data);
		// $json_data = array('data' => 'sukses kah');
		// echo json_encode($json_data);
		redirect('EC_Ecatalog/detail_prod/' . $this -> input -> post("contract_no") . '/' . $this -> input -> post("matno"));
	}

}

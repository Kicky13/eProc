<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Pricelist_management extends CI_Controller {

	private $USER;

	public function __construct() {
		parent::__construct();
		$this -> load -> library('Authorization');
		$this -> load -> helper('url');
		$this -> load -> library('Layout');
		$this -> load -> helper("security");
		$this -> USER = explode("@", $this -> session -> userdata['USERNAME']);
	}

	public function index($cheat = false) {
		$data['title'] = "Pricelist Management";
		$data['cheat'] = $cheat;
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> set_validate_css();
		$this -> layout -> set_validate_js();
		$this -> layout -> add_js('pages/EC_pricelist_man.js');
		$this -> layout -> add_js('pages/EC_bootstrap-switch.min.js');
		$this -> layout -> add_css('pages/EC_strategic_material.css');
		$this -> layout -> add_css('pages/EC_bootstrap-switch.min.css');
		$this -> layout -> add_css('pages/EC_miniTable.css');
		$this -> layout -> render('list', $data);
	}

	public function getDetail($MATNO = null, $VENDOR = null) {
		header('Content-Type: application/json');
		$this -> load -> model('ec_pricelist_man_m');
		$data['MATNR'] = $this -> ec_pricelist_man_m -> getDetail($MATNR);
		//substr($MATNR, 1));
		echo json_encode($data);
	}

	function getAllFilter() {
		header('Content-Type: application/json');
		$this -> load -> model('ec_pricelist_man_m');
		$data['Partner'] = $this -> ec_pricelist_man_m -> getAllVnd();
		$data['Manufacturer'] = $this -> ec_pricelist_man_m -> getAllManufacturer();
		$data['MatGroup'] = $this -> ec_pricelist_man_m -> getAllMatgroup();
		//substr($MATNR, 1));
		echo json_encode($data);
	}

	public function get_data() {
		header('Content-Type: application/json');
		$this -> load -> model('ec_pricelist_man_m');
		// $venno = $this -> session -> userdata['VENDOR_NO'];
		$dataa = $this -> ec_pricelist_man_m -> getMan();
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data['NO'] = $i++;
			$data['MATNR'] = $value['MATNR'] = !null ? $value['MATNR'] : "";
			$data['MAKTX'] = $value['MAKTX'] = !null ? $value['MAKTX'] : "";
			$data['PUBLISHED_PRICELIST'] = $value['PUBLISHED_PRICELIST'] = !null ? $value['PUBLISHED_PRICELIST'] : ""; 
			$data['START_DATE'] = $value['START_DATE'] = !null ? $value['START_DATE'] : "";
			$data['END_DATE'] = $value['END_DATE'] = !null ? $value['END_DATE'] : "";
			$data['CURR'] = $value['CURR'] = !null ? $value['CURR'] : "";
			$data['PRICE'] = $value['PRICE'] = !null ? $value['PRICE'] : "";
			$data['MEINS'] = $value['MEINS'] = !null ? $value['MEINS'] : "";
			$data['MATKL'] = $value['MATKL'] = !null ? $value['MATKL'] : "";
			
			$data_tabel[] = $data;
		}
		$json_data = /*$data_tabel;*/
		array('data' => $data_tabel);
		echo json_encode($json_data);
	}

	public function sapUpdate() {
		$this -> load -> model('ec_pricelist_man_m');
		$filter = $this -> ec_pricelist_man_m -> getFilter();
		$doc = '';
		// print_r($filter["COMPANY"][0]['TYPE']);
		// print_r($filter["COMPANY"]);
		foreach ($filter["DOC"] as $val) {
			//print_r($val['TYPE'] . "  ");
			$doc = $doc + ($val['DOC_TYPE'] . ",");
			print_r($doc);
		}
		/**/
		$this -> load -> library('sap_handler');
		// $invoice = $this -> sap_handler -> getListContract(array('2000'), array('HC01', 'SG01'), "ZMKD");
		$invoice = $this -> sap_handler -> getListContract($filter["COMPANY"], $filter["PURC_ORG"], "ZMKD");
		// print_r($invoice['GI_HEADER']);
		/**/
		$inv = array();
		foreach ($invoice['GI_HEADER'] as $value) {
			// if (strpos($doc, $value['BSART']) === false)
			$dataLC = array("contract_no" => $value['EBELN'], "contract_itm" => $value['EBELP'], "comp" => $value['BUKRS'], "cat" => $value['BSTYP'], "doctype" => $value['BSART'], "del" => $value['LOEKZ'], "createby" => $value['ERNAM'], "vendorno" => $value['LIFNR'], "vendorname" => $value['NAME1'], "porg" => $value['EKORG'], "pgrp" => $value['EKGRP'], "curr" => $value['WAERS'], "exrate" => $value['WKURS'], "docdate" => $value['BEDAT'], "validstart" => $value['KDATB'], "validend" => $value['KDATE'], "procstat" => $value['PROCSTAT'], "relind" => $value['FRGKE'], "shortext" => $value['TXZ01'], "matno" => $value['MATNR'], "plant" => $value['WERKS'], "t_qty" => $value['KTMNG'], "uom" => $value['MEINS'], "netprice" => $value['NETPR'], "per" => $value['PEINH'], "grossprice" => $value['BRTWR']);
			$this -> ec_pricelist_man_m -> insert_sap($dataLC);
		}
		/* */
		return;
	}

	public function ubahStatDraft($MATNR) {
		$this -> load -> model('ec_pricelist_man_m');
		//  date("d.m.Y")  $this->session->userdata['PRGRP']
		$data = array("MATNR" => $MATNR, "PUBLISHED_PRICELIST" => $this -> input -> post('checked'));
		$this -> ec_pricelist_man_m -> ubahStatDraft($data);
	}

}

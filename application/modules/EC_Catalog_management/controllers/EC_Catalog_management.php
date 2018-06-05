<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Catalog_management extends CI_Controller {

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
		$data['title'] = "Catalog Management";
		$data['cheat'] = $cheat;
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> set_validate_css();
		$this -> layout -> set_validate_js();
		$this -> layout -> add_js('pages/EC_catalog_man.js');
		$this -> layout -> add_js('pages/EC_bootstrap-switch.min.js');
		$this -> layout -> add_css('pages/EC_strategic_material.css');
		$this -> layout -> add_css('pages/EC_bootstrap-switch.min.css');
		$this -> layout -> add_css('pages/EC_miniTable.css');
		$this -> layout -> render('list', $data);
	}

	public function getDetail($MATNO = null, $VENDOR = null) {
		header('Content-Type: application/json');
		$this -> load -> model('EC_list_contract_m');
		$data['MATNR'] = $this -> EC_list_contract_m -> getDetail($MATNR);
		//substr($MATNR, 1));
		echo json_encode($data);
	}

	function getAllFilter() {
		header('Content-Type: application/json');
		$this -> load -> model('EC_list_contract_m');
		$data['Partner'] = $this -> EC_list_contract_m -> getAllVnd();
		$data['Manufacturer'] = $this -> EC_list_contract_m -> getAllManufacturer();
		$data['MatGroup'] = $this -> EC_list_contract_m -> getAllMatgroup();
		//substr($MATNR, 1));
		echo json_encode($data);
	}

	public function get_data() {
		header('Content-Type: application/json');
		$this -> load -> model('EC_list_contract_m');
		// $venno = $this -> session -> userdata['VENDOR_NO'];
		$dataa = $this -> EC_list_contract_m -> getMan();
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$netprice = $value['netprice'] = !null ? $value['netprice'] : "0";
			$grossprice = $value['grossprice'] = !null ? $value['grossprice'] : "0";
			if($value['curr']=='IDR'){
				$netprice = $netprice*100;
				$grossprice = $grossprice*100;
			}
			$data[0] = $i++;
			$data[1] = $value['contract_no'];
			$data[2] = $value['contract_itm'];
			$data[3] = $value['comp'] = !null ? $value['comp'] : "";
			$data[4] = $value['cat'] = !null ? $value['cat'] : "";
			$data[5] = $value['doctype'] = !null ? $value['doctype'] : "";
			$data[6] = $value['del'] = !null ? $value['del'] : "";
			$data[7] = $value['createby'] = !null ? $value['createby'] : "";
			$data[8] = $value['vendorno'] = !null ? $value['vendorno'] : "";
			$data[9] = $value['vendorname'] = !null ? $value['vendorname'] : "";
			$data[10] = $value['porg'] = !null ? $value['porg'] : "";
			$data[11] = $value['pgrp'] = !null ? $value['pgrp'] : "";
			$data[12] = $value['curr'] = !null ? $value['curr'] : "";
			$data[13] = $value['MATKL'] = !null ? $value['MATKL'] : "";
			$data[14] = $value['exrate'] = !null ? $value['exrate'] : "";
			$data[15] = $value['docdate'] = !null ? $value['docdate'] : "";
			$data[16] = $value['validstart'] = !null ? $value['validstart'] : "";
			$data[17] = $value['validend'] = !null ? $value['validend'] : "";
			$data[18] = $value['procstat'] = !null ? $value['procstat'] : "";
			$data[19] = $value['relind'] = !null ? $value['relind'] : "";
			$data[20] = $value['shortext'] = !null ? $value['shortext'] : "";
			$data[21] = $value['matno'] = !null ? $value['matno'] : "";
			$data[22] = $value['plant'] = !null ? $value['plant'] : "";
			$data[23] = $value['t_qty'] = !null ? $value['t_qty'] : "";
			$data[24] = $value['uom'] = !null ? $value['uom'] : "";
			$data[25] = $netprice;
			$data[26] = $value['per'] = !null ? $value['per'] : "";
			$data[27] = $grossprice;
			$data[28] = $value['STATUS'] = !null ? $value['STATUS'] : "0";
			$data[29] = $value['published'] = !null ? $value['published'] : "0";
			$data[30] = $value['DESC'] = !null ? $value['DESC'] : "-";
			$data_tabel[] = $data;
		}
		$json_data = /*$data_tabel;*/
		array('data' => $data_tabel);
		echo json_encode($json_data);
	}

	public function sapUpdate() {
		$this -> load -> model('EC_list_contract_m');
		$filter = $this -> EC_list_contract_m -> getFilter();
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
			$dataLC = array("contract_no" => $value['EBELN'], "contract_itm" => $value['EBELP'], "comp" => $value['BUKRS'], "cat" => $value['BSTYP'], "doctype" => $value['BSART'], "del" => $value['LOEKZ'], "createby" => $value['ERNAM'], "vendorno" => $value['LIFNR'], "vendorname" => $value['NAME1'], "porg" => $value['EKORG'], "pgrp" => $value['EKGRP'], "curr" => $value['WAERS'], "exrate" => $value['WKURS'], "docdate" => $value['BEDAT'], "validstart" => $value['KDATB'], "validend" => $value['KDATE'], "procstat" => $value['PROCSTAT'], "relind" => $value['FRGKE'], "shortext" => $value['TXZ01'], "matno" => $value['MATNR'], "plant" => $value['WERKS'], "t_qty" => $value['KTMNG'], "uom" => $value['MEINS'], "netprice" => $value['NETPR'], "per" => $value['PEINH'], "grossprice" => $value['BRTWR'], "published" => '1');
			$this -> EC_list_contract_m -> insert_sap($dataLC);
		}
		/* */
		return;
	}

	public function ubahStatDraft($PC_CODE) {
		$this -> load -> model('EC_list_contract_m');
		//  date("d.m.Y")  $this->session->userdata['PRGRP']
		$data = array("contract_no" => $PC_CODE, "contract_itm" => $this -> input -> post('contract_itm'), "published" => $this -> input -> post('checked'));
		$this -> EC_list_contract_m -> ubahStatDraft($data);
	}

}

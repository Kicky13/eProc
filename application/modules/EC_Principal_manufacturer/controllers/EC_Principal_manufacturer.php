<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Principal_manufacturer extends CI_Controller {

	private $USER;

	public function __construct() {
		parent::__construct();
		$this -> load -> library('Authorization');
		$this -> load -> helper('url');
		$this -> load -> library('Layout');
		$this -> load -> helper("security");
		$this -> USER = explode("@", $this -> session -> userdata['EMAIL']);
	}

	public function index($cheat = false) {
		$data['title'] = "Principal Manufacturer Data";
		$data['cheat'] = $cheat;
		$data['pc_code'] = $this -> getPC_CODE();
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> set_validate_css();
		$this -> layout -> set_validate_js();
		$this -> layout -> add_js('pages/EC_principal_manufacturer.js');
		$this -> layout -> add_css('pages/EC_strategic_material.css');
		$this -> layout -> render('list', $data);
	}

	public function ubahStat($PC_CODE) {
		$this -> load -> model('EC_principal_manufacturer_m');
		//  date("d.m.Y")  $this->session->userdata['PRGRP']
		$data = array("PC_CODE" => $PC_CODE, "VENDOR_ID" => $this -> input -> post('VENDOR_ID'), "ID_R1" => $this -> input -> post('ID_R1'), "BY" => $this -> USER[0], "ON" => date("d-m-Y h:i:s"), "STATUS" => $this -> input -> post('checked'));
		$this -> EC_principal_manufacturer_m -> ubahStat($data);
	}

	public function baru() {
		$this -> load -> model('EC_principal_manufacturer_m');
		$this -> load -> library("file_operation");
		$this -> load -> helper('file');
		$this -> load -> helper(array('form', 'url'));
		$uploaded = $this -> file_operation -> uploadT(UPLOAD_PATH . 'EC_principal_manufacturer', $_FILES);
		if ($uploaded != null) {
			$data = array("PC_CODE" => $this -> input -> post("PC_CODE"), "PC_NAME" => $this -> input -> post("PC_NAME"), "COUNTRY" => $this -> input -> post("COUNTRY"), "ADDRESS" => $this -> input -> post("ADDRESS"), "PHONE" => $this -> input -> post("PHONE"), "FAX" => $this -> input -> post("FAX"), "MAIL" => $this -> input -> post("MAIL"), "WEBSITE" => $this -> input -> post("WEBSITE"), "LOGO" => $uploaded['LOGO']['file_name'], "CREATEDBY" => $this -> USER[0], "CREATEDON" => date("d-m-Y h:i:s"), "CHANGEDBY" => $this -> USER[0], "CHANGEDON" => date("d-m-Y h:i:s"));
			$this -> EC_principal_manufacturer_m -> insert($data);
		} else if ($uploaded[0] == "gagal") {
			//redirect("Principal_manufacturer/");
		}
		redirect("EC_Principal_manufacturer/");

	}

	public function edit() {
		$this -> load -> model('EC_principal_manufacturer_m');
		$this -> load -> library("file_operation");
		$this -> load -> helper('file');
		$this -> load -> helper(array('form', 'url'));
		$uploaded = $this -> file_operation -> uploadT(UPLOAD_PATH . 'EC_principal_manufacturer', $_FILES);
		if ($uploaded != null) {
			$data = array("PC_CODE" => $this -> input -> post("PC_CODE_edit"), "PC_NAME" => $this -> input -> post("PC_NAME_edit"), "COUNTRY" => $this -> input -> post("COUNTRY_edit"), "ADDRESS" => $this -> input -> post("ADDRESS_edit"), "PHONE" => $this -> input -> post("PHONE_edit"), "FAX" => $this -> input -> post("FAX_edit"), "MAIL" => $this -> input -> post("MAIL_edit"), "WEBSITE" => $this -> input -> post("WEBSITE_edit"), "LOGO" => $uploaded['LOGO_edit']['file_name'], "CHANGEDBY" => $this -> USER[0], "CHANGEDON" => date("d-m-Y h:i:s"));
			$this -> EC_principal_manufacturer_m -> edit($data);
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
		$uploaded = $this -> file_operation -> uploadT(UPLOAD_PATH . 'EC_principal_manufacturer', $_FILES);
		if ($uploaded != null) {
			$data = array("LOGO" => $uploaded['LOGO']['file_name'],"PC_CODE" => $PC_CODE, "BY" => $this -> USER[0], "ON" => date("d-m-Y h:i:s"));
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

	public function get_data() {
		$this -> load -> model('EC_principal_manufacturer_m');
		$dataa = $this -> EC_principal_manufacturer_m -> get();
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['PC_CODE'];
			$data[2] = $value['PC_NAME'] = !null ? $value['PC_NAME'] : "";
			$data[3] = $value['COUNTRY'] = !null ? $value['COUNTRY'] : "";
			$data[4] = $value['PHONE'] = !null ? $value['PHONE'] : "";
			$data[5] = $value['WEBSITE'] = !null ? $value['WEBSITE'] : "";
			$data[6] = $value['MAIL'] = !null ? $value['MAIL'] : "";
			$data_tabel[] = $data;
		}
		$json_data = /*$data_tabel;*/
		array('data' => $data_tabel);
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

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Configuration_doc_type extends CI_Controller {

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
		$data['title'] = "Configuration &ndash; Document Type";
		$data['cheat'] = $cheat;
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> set_validate_css();
		$this -> layout -> set_validate_js();
		$this -> layout -> add_js('pages/EC_configuration_doc_type.js');
		$this -> layout -> add_css('pages/EC_strategic_material.css');
		$this -> layout -> render('list', $data);
	}

	public function get_data() {
		header('Content-Type: application/json');
		$this -> load -> model('EC_configuration_doc_type_m');
		$dataa = $this -> EC_configuration_doc_type_m -> get();
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['DOC_ID'];
			$data[2] = $value['DOC_CATEGORY'] = !null ? $value['DOC_CATEGORY'] : "";
			$data[3] = $value['DOC_TYPE'] = !null ? $value['DOC_TYPE'] : "";
			$data[4] = $value['DOC_STATUS'];
			$data_tabel[] = $data;
		}
		$json_data = /*$data_tabel;*/
		array('data' => $data_tabel);
		echo json_encode($json_data);
	}

	public function getDetail($MATNR) {
		header('Content-Type: application/json');
		$this -> load -> model('EC_configuration_doc_type_m');
		$data['MATNR'] = $this -> EC_configuration_doc_type_m -> getDetail($MATNR);
		//substr($MATNR, 1));
		echo json_encode($data);
	}

	public function ubahStat($MATNR) {
		$this -> load -> model('EC_configuration_doc_type_m');
		//  date("d.m.Y")  $this->session->userdata['PRGRP']
		$data = array("DOC_ID" => $MATNR, "AENAM" => $this -> USER[0], "LAEDA" => date("d-m-Y h:i:s"), "DOC_STATUS" => $this -> input -> post('checked'));
		$this -> EC_configuration_doc_type_m -> ubahStat($data);
	}

	public function baru() {
		$this -> load -> model('EC_configuration_doc_type_m');
		$data = array("DOC_CATEGORY" => $this -> input -> post("CATEGORY"), "DOC_TYPE" => $this -> input -> post("DOC_TYPE"), "CREATEDBY" => $this -> USER[0], "CREATEDON" => date("d-m-Y h:i:s"), "CHANGEDBY" => $this -> USER[0], "CHANGEDON" => date("d-m-Y h:i:s"));
		$this -> EC_configuration_doc_type_m -> insert($data);
		redirect("EC_Configuration_doc_type/");

	}

}

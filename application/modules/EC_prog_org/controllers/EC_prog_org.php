<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_prog_org extends CI_Controller {

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
		$data['title'] = "Master Purchase Organization";
		$data['cheat'] = $cheat;
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> set_validate_css();
		$this -> layout -> set_validate_js();
		$this -> layout -> add_js('pages/EC_master_ecatalog.js');
		$this -> layout -> add_css('pages/EC_strategic_material.css');
		$this -> layout -> render('list', $data);
	}

	public function get_data() {
		header('Content-Type: application/json');
		$this -> load -> model('EC_master_ecatalog');
		$dataa = $this -> EC_master_ecatalog -> getPURC_ORG();
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['DOC_ID'];
			$data[2] = $value['CATEGORY'] = !null ? $value['CATEGORY'] : "";
			$data[3] = $value['TYPE'] = !null ? $value['TYPE'] : "";
			$data[4] = $value['STATUS'];
			$data_tabel[] = $data;
		}
		$json_data = /*$data_tabel;*/
		array('data' => $data_tabel);
		echo json_encode($json_data);
	}

	public function getDetail($MATNR) {
		header('Content-Type: application/json');
		$this -> load -> model('EC_master_ecatalog');
		$data['MATNR'] = $this -> EC_master_ecatalog -> getDetail($MATNR);
		//substr($MATNR, 1));
		echo json_encode($data);
	}

	public function ubahStat($MATNR) {
		$this -> load -> model('EC_master_ecatalog');
		//  date("d.m.Y")  $this->session->userdata['PRGRP']
		$data = array("DOC_ID" => $MATNR, "STATUS" => $this -> input -> post('checked'));
		$this -> EC_master_ecatalog -> ubahStatPURC_ORG($data);
	}

	public function baru() {
		$this -> load -> model('EC_master_ecatalog');
		$data = array("CATEGORY" => $this -> input -> post("CATEGORY"), "TYPE" => $this -> input -> post("TYPE"), "CREATEDBY" => $this -> USER[0], "CREATEDON" => date("d-m-Y h:i:s"), "CHANGEDBY" => $this -> USER[0], "CHANGEDON" => date("d-m-Y h:i:s"));
		$this -> EC_master_ecatalog -> insertPURC_ORG($data);
		redirect("EC_prog_org/");

	}


}

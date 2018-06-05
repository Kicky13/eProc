<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_PR_Pricelist_management extends CI_Controller {

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
		$data['title'] = "PR Management";
		$data['cheat'] = $cheat;
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> set_validate_css();
		$this -> layout -> set_validate_js();
		$this -> layout -> add_js('pages/EC_pr_pricelist_man.js');
		$this -> layout -> add_js('pages/EC_bootstrap-switch.min.js');
		$this -> layout -> add_css('pages/EC_strategic_material.css');
		$this -> layout -> add_css('pages/EC_bootstrap-switch.min.css');
		$this -> layout -> add_css('pages/EC_miniTable.css');
		$this -> layout -> render('list', $data);
	}

	public function sapUpdate() {
		$this -> load -> model('ec_pricelist_man_m');
		$this -> load -> model('ec_pr_pricelist_man_m');
		$filter = $this -> ec_pricelist_man_m -> getFilter();
		// var_dump($filter["DOC"][0]);
		$this -> load -> library('sap_handler');
		$dataSap = $this -> sap_handler -> getPRPricelist($filter["DOC"], false);
		$this -> ec_pr_pricelist_man_m -> insert_sap($dataSap);
	}

	public function ubahStatDraft($MATNR) {
		$this -> load -> model('ec_pricelist_man_m');
		//  date("d.m.Y")  $this->session->userdata['PRGRP']
		$data = array("MATNR" => $MATNR, "PUBLISHED_PRICELIST" => $this -> input -> post('checked'));
		$this -> ec_pricelist_man_m -> ubahStatDraft($data);
	}

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Strategic_material extends CI_Controller {

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
		$data['title'] = "Strategic Material Assignment";
		$data['cheat'] = $cheat;
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> set_validate_css();
		$this -> layout -> set_validate_js();
		$this -> layout -> add_js('pages/EC_strategic_material.js');
		$this -> layout -> add_js('pages/EC_nav_tree.js');
		$this -> layout -> add_js('pages/EC_master_category.js');
		$this -> layout -> add_css('pages/EC_strategic_material.css');
		$this -> layout -> add_css('pages/EC_nav_tree.css');
		$this -> layout -> add_css('pages/EC_miniTable.css');
		$this -> layout -> render('list', $data);
	}

	public function getDetail($MATNR) {
		header('Content-Type: application/json');
		$this -> load -> model('EC_strategic_material_m');
		$data['MATNR'] = $this -> EC_strategic_material_m -> getDetail($MATNR);
		//substr($MATNR, 1));
		echo json_encode($data);
	}

	public function ubahStat($MATNR) {
		$this -> load -> model('EC_strategic_material_m');
		//  date("d.m.Y")  $this->session->userdata['PRGRP']
		$data = array("MATNR" => $MATNR, "AENAM" => $this -> USER[0], "LAEDA" => date("Ymd"), "STATUS" => $this -> input -> post('checked'));
		$this -> EC_strategic_material_m -> ubahStat($data);
	}

	public function ubahStatAll($MATNR) {
		$this -> load -> model('EC_strategic_material_m');
		$data = array("MATNR" => $MATNR, "STATUS" => $this -> input -> post('checked'));
		$this -> EC_strategic_material_m -> ubahStat($data);
	}

	public function setKategori() {
		$this -> load -> model('EC_strategic_material_m');
		$data = array("ID_CAT" => $this -> input -> post('ID_Category'), "MATNR" => $this -> input -> post('CODE_M'));
		$this -> EC_strategic_material_m -> setCategory($data);
		redirect("EC_Strategic_material/");
	}

	public function setTAG() {
		$this -> load -> model('EC_strategic_material_m');
		$data = array("TAG" => $this -> input -> post('TAG'), "MATNR" => $this -> input -> post('CODE_M'));
		$this -> EC_strategic_material_m -> setTAG($data);
		redirect("EC_Strategic_material/");
	}

	public function upload($MATNR) {
		$this -> load -> library("file_operation");
		$this -> load -> helper('file');
		$this -> load -> model('EC_strategic_material_m');
		$this -> load -> helper(array('form', 'url'));
		// header('Content-Type: application/json');
		// var_dump($_FILES);
		// if ($_FILES['picture']['size'] > 200000 && $_FILES['drawing']['size'] > 200000) {
		// }
//		var_dump(UPLOAD_PATH); 
//		var_dump($_FILES);
		$uploaded = $this -> file_operation -> uploadT(UPLOAD_PATH . 'EC_material_strategis'/*,        '200', 'jpg|png'*/, $_FILES);
//		var_dump($uploaded);
		if ($uploaded != null && $_FILES['picture']['name']!="") {
			$data = array("MATNR" => $MATNR, "AENAM" => $this -> USER[0], "LAEDA" => date("Ymd"),"PICTURE" => $uploaded['picture']['file_name']);
			if( $_FILES['drawing']['name']!=""){
				$data = array("MATNR" => $MATNR, "AENAM" => $this -> USER[0], "LAEDA" => date("Ymd"),"DRAWING" => $uploaded['drawing']['file_name'], "PICTURE" => $uploaded['picture']['file_name']);
			}
		}else if ($uploaded != null && $_FILES['drawing']['name']!="") {
			$data = array("MATNR" => $MATNR, "AENAM" => $this -> USER[0], "LAEDA" => date("Ymd"),"DRAWING" => $uploaded['drawing']['file_name']);
			if( $_FILES['picture']['name']!=""){
				$data = array("MATNR" => $MATNR, "AENAM" => $this -> USER[0], "LAEDA" => date("Ymd"),"DRAWING" => $uploaded['drawing']['file_name'], "PICTURE" => $uploaded['picture']['file_name']);
			}
		}
		$this -> EC_strategic_material_m -> upload($data);
		$this -> EC_strategic_material_m -> setTAG(array('TAG' => $this -> input -> post('TAG'), "MATNR" => $MATNR));
		redirect("EC_Strategic_material/");
	}

	/*
	 MATNR(Material number),
	 MAKTX(shortext),
	 MTART(material type),
	 MEINS(uom),
	 MATKL(material group),
	 ERNAM (creator),
	 ERSDA(create on),
	 AENAM(changed by),
	 LAEDA(last change);
	 NO (longtext item ke ...),
	 TDLINE (Long Text)
	 *
	 */
	public function get_data() {
		header('Content-Type: application/json');
		$this -> load -> model('EC_strategic_material_m');
		// $venno = $this -> session -> userdata['VENDOR_NO'];
		$dataa = $this -> EC_strategic_material_m -> get();
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['MATNR'];
			$data[2] = $value['MAKTX'] = !null ? $value['MAKTX'] : "";
			$data[3] = $value['MEINS'] = !null ? $value['MEINS'] : "";
			$data[4] = $value['MATKL'] = !null ? $value['MATKL'] : "";
			$data[5] = $value['MTART'] = !null ? $value['MTART'] : "";
			$data[7] = $value['STATUS'];
			$data[6] = $data[7] != ("0") ? "Material Strategis" : "-";
			$data[8] = $value['ID_CAT'] != null ? $value['DESC'] : "-";
			$data[9] = $value['TAG'] != null ? $value['TAG'] : "-";
			$data_tabel[] = $data;
		}
		$json_data = /*$data_tabel;*/
		array('data' => $data_tabel);
		echo json_encode($json_data);
	}

	public function sapUpdate() {
		$this -> load -> model('EC_strategic_material_m');
		/**/
		$this -> load -> library('sap_handler');
		//print_r($invoice['T_OUTPUT']);
		$invoice = $this -> sap_handler -> getStrategicMaterial(date("dmY"));
		$inv = array();
		foreach ($invoice['T_OUTPUT'] as $value) {
			$dataMSM = array("MATNR" => preg_replace('/^0+/', '', $value['MATNR']), "MAKTX" => $value['MAKTX'], "MTART" => $value['MTART'], "MEINS" => $value['MEINS'], "MATKL" => $value['MATKL'], "ERNAM" => $value['ERNAM'], "ERSDA" => $value['ERSDA'], "AENAM" => $value['AENAM'], "LAEDA" => $value['LAEDA']);
			$dataMLT = array("MATNR" => preg_replace('/^0+/', '', $value['MATNR']), "NO" => $value['NO'], "TDLINE" => $value['TDLINE']);
			$this -> EC_strategic_material_m -> insert_ecat($dataMSM, $dataMLT);
		}
		/* */
		return;
	}

}

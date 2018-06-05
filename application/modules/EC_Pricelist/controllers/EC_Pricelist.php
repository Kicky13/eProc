<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Pricelist extends CI_Controller {

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
		$this -> layout -> add_css('plugins/bootstrap-datepicker/datepicker.css');
		//$this -> layout -> add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this -> layout -> add_css('pages/EC_bootstrap-slider.min.css');
		$this -> layout -> add_js('pages/EC_bootstrap-slider.min.js');
		$this -> layout -> add_js('pages/EC-bootstrap-datepicker.min.js');
		$this -> layout -> add_js('pages/EC_pricelist.js');
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

	public function get_currency() {
		$this -> load -> model('EC_pricelist_m');
		$dataa = $this -> EC_pricelist_m -> get_MasterCurrency();
		//$dataPrice = $this -> EC_pricelist_m -> getPricelist($this->session->userdata['VENDOR_NO']);
		//$dataPrice = $this -> EC_pricelist_m -> getPricelist('122');
		//$page = $this -> EC_pricelist -> getAllCount();

		//$json_data = array('page' => 10, 'data' => $this -> getALL($dataa, $dataPrice));
		echo json_encode($dataa);
	}

	public function get_data() {
		$this -> load -> model('EC_pricelist_m');
		$dataCurr = $this -> EC_pricelist_m -> get_MasterCurrency();

		$this -> load -> model('EC_pricelist_m');
		$dataa = $this -> EC_pricelist_m -> get($this -> input -> post('limitMin'), $this -> input -> post('limitMax'));
		$dataPrice = $this -> EC_pricelist_m -> getPricelist($this->session->userdata['VENDOR_NO']);
		//$dataPrice = $this -> EC_pricelist_m -> getPricelist('122');
		//$page = $this -> EC_pricelist -> getAllCount();

		$json_data = array('curr' => $dataCurr,'page' => 10, 'data' => $this -> getALL($dataa, $dataPrice));
		echo json_encode($json_data);
	}

	function getALL($dataa = '', $dataPrice) {
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
			for ($p=0; $p < sizeof($dataPrice); $p++) { 
				if($data[1]==$dataPrice[$p]['MATNO']){
					$data[4] = $dataPrice[$p]['PRICE_OFFER'] != null ? $dataPrice[$p]['PRICE_OFFER'] : "";
					$data[5] = $dataPrice[$p]['CURR_OFFER'] != null ? $dataPrice[$p]['CURR_OFFER'] : "";
					$data[6] = $dataPrice[$p]['VALID_START'] != null ? $dataPrice[$p]['VALID_START'] : "";
					$data[7] = $dataPrice[$p]['VALID_END'] != null ? $dataPrice[$p]['VALID_END'] : "";
					$data[8] = $dataPrice[$p]['STATUS'] != null ? $dataPrice[$p]['STATUS'] : "";
					break;		
				}else{
					$data[4] = "";
					$data[5] = "";
					$data[6] = "";
					$data[7] = "";
					$data[8] = "";
				}
			}
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
		$venno = $this->session->userdata['VENDOR_NO'];
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
}

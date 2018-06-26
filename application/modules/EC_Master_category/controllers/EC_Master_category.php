<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Master_category extends CI_Controller {

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
		$data['title'] = "Master Category";
		$data['cheat'] = $cheat;
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> set_validate_css();
		$this -> layout -> set_validate_js();
		$this -> layout -> add_css('pages/EC_master_category.css');
		$this -> layout -> add_js('pages/EC_master_category.js');
		$this -> layout -> add_css('pages/EC_strategic_material.css');
		$this -> layout -> add_js('pages/EC_nav_tree.js');
		$this -> layout -> add_css('pages/EC_nav_tree.css');
		$this -> layout -> render('list', $data);
	}

	public function get_data() {
		header('Content-Type: application/json');
		$this->load->model('ec_master_category_m');
		$dataa = $this->ec_master_category_m->get();
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

	public function ubah($id_parent) {
		// print_r($id_parent);
		$this -> load -> model('ec_master_category_m');
		$data = array("ID_CAT" => $id_parent, "DESC" => $this -> input -> post("desc"));
		$this -> ec_master_category_m -> ubah($data);
	}

	public function upload($id_parent) {
		if(isset($_POST["submit"])) {
			$this -> load -> model('ec_master_category_m');
			$idupload = $_POST["idUpload"];
			$folder = "upload/EC_homepage/";
			if($_POST["submit"] == "upload") {
				if(isset($_FILES["gambar"]) && $_FILES["gambar"]["name"] != "") {
					$nama = $this -> ec_master_category_m -> nama_gambar($idupload);
					
					$ext = explode(".", $_FILES["gambar"]["name"]);
					$ext = end($ext);
					$nama_file = md5(date("YmdHis") . $_FILES["gambar"]["name"]) . "." . $ext;
					
					$q = $this -> ec_master_category_m -> ubah_gambar($idupload, $nama_file);
					
					if($q) {
						$q = move_uploaded_file($_FILES["gambar"]["tmp_name"], "{$folder}{$nama_file}");
					}
					
					if($q && $nama != "" && file_exists("{$folder}{$nama}")) {
						unlink("{$folder}{$nama}");
					}
					header("location:".base_url()."EC_Master_category?upload=berhasil");
				} else {
					header("location:".base_url()."EC_Master_category?upload=gagal");
				}
			} else if($_POST["submit"] == "hapus") {
				$nama = $this -> ec_master_category_m -> nama_gambar($idupload);
				$del = $this -> ec_master_category_m -> ubah_gambar($idupload);
				if($del && $nama != "" && file_exists("{$folder}{$nama}")) {
					unlink("{$folder}{$nama}");
				}
				header("location:".base_url()."EC_Master_category?upload=berhasil");
			}
		} else {
			header("location:".base_url()."EC_Master_category?upload=gagal");
		}
	}

	public function hapus($id_parent) {
		// print_r($id_parent);
		$this -> load -> model('ec_master_category_m');
		$data = array("ID_CAT" => $id_parent, "KODE_USER" => $this -> input -> post("kodeEdit"));
		$this -> ec_master_category_m -> hapus($data);
	}

	function testM($value = '') {
		header('Content-Type: application/json');
		$this -> load -> model('ec_master_category_m');
		// $data = array("ID_CAT" => $id_parent, "KODE_USER" => $this -> input -> post("kodeEdit"));
		$this -> ec_master_category_m -> updateKodeUser('', 'lvl0');
	}

}

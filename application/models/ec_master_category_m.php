<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_master_category_m extends CI_Model {
	protected $table = 'EC_M_CATEGORY';
	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	function insertBaru($data) {
		$this -> db -> insert($this -> table, $data);
	}

	public function get() {
		$this -> db -> from($this -> table);
		$this -> db -> order_by('DESC ASC');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	function ubah($data) {
		$this -> db -> where("ID_CAT", $data['ID_CAT'], TRUE);
		$this -> db -> update($this -> table, array('DESC' => $data['DESC']));
	}

	function hapus($data) {//MASIH ERORRRRRRRRRRRRRRRRRRRR? masihh
		$SQL = 'DELETE FROM EC_M_CATEGORY EC WHERE ID_CAT=' . $data['ID_CAT'] . ' or KODE_USER like \'' . $data['KODE_USER'] . '%\'';
		$this -> db -> query($SQL);
		if (strlen($data['KODE_USER']) == 1) {
			$this -> ec_master_category_m -> updateKodeUser('', 'lvl0');
		} else
			$this -> updateKodeUser(substr($data['KODE_USER'], 0, 1), 'lvl1');
	}

	function updateKodeUser($kode_del = '', $lvl, $parentBaru = "", $pertama = true) {
		$result = array();
		$parentBaru = $parentBaru == "" ? $kode_del . "-" : $parentBaru;
		$parentBaru = $kode_del == "" ? $kode_del : $parentBaru;
		$this -> db -> from($this -> table);
		$this -> db -> where('KODE_USER like \'' . $kode_del . '%\'');
		$this -> db -> where('LEVEL = \'' . $lvl . '\'');
		$this -> db -> order_by('KODE_USER');
		$query = $this -> db -> get();
		$result = (array)$query -> result_array();
		for ($i = 0; $i < sizeof($result); $i++) {
			$this -> db -> from($this -> table);
			$this -> db -> like('KODE_USER ', $result[$i]['KODE_USER'] . '-', 'after');
			$this -> db -> where('LEVEL', 'lvl' . (substr($lvl, 3) + 1), true);
			$this -> db -> order_by('KODE_USER');
			$query = $this -> db -> get();
			$result2 = (array)$query -> result_array();
			if ($pertama) {
				// var_dump("parent:  " . $result[$i]['KODE_USER'] . " => " . $parentBaru . ($i + 1));
				$par = $parentBaru . ($i + 1);
			} else {
				// var_dump("parent:  " . $result[$i]['KODE_USER'] . " => " . $parentBaru);
				$par = $parentBaru;
			}
			$this -> db -> where("ID_CAT", $result[$i]['ID_CAT'], TRUE);
			$this -> db -> update($this -> table, array('KODE_USER' => $par));
			if (sizeof($result2) > 0) {
				for ($j = 0; $j < sizeof($result2); $j++) {
					$this -> updateKodeUser($result2[$j]['KODE_USER'], $result2[$j]['LEVEL'], $par . "-" . ($j + 1), false);
				}
			}
		}
	}

	// $pjg2 = strlen($result[$i]['KODE_USER']);
	
	public function nama_gambar($idupload) {
		$this->db->where("ID_CAT", $idupload);
		$hasil = $this->db->get($this -> table)->result_array();
		if(count($hasil) > 0) {
			return $hasil[0]["PICTURE_CAT"];
		} else {
			return "";
		}
	} 
	
	public function ubah_gambar($idupload, $nama_baru="") {
		$this->db->where("ID_CAT", $idupload);
		return $this->db->update($this -> table, array("PICTURE_CAT"=>$nama_baru));
	} 
}

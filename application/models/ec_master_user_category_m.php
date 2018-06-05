<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_master_user_category_m extends CI_Model {
	protected $table = 'EC_M_CATEGORY';
	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	public function map_tree_map($arr) {
		//param yang harus ada [title sebagai teks child]
		$q = $this->db->query($arr);
		$data=array();
		foreach($q->result_array() as $line){
			$data_tbl=array();
			$data_tbl['id']=$line['ID']; 
			$data_tbl['title']=$line['DESC'];
			// $data_tbl['url']=$line['URL'];
			$data_tbl['nama']=$line['DESC'];
			$data_tbl['parent_id']=$line['KODE_PARENT'];
			//$data_tbl['parent_kode']=$line['PARENT_KODE'];
			$data_tbl['kode']=$line['KODE_USER'];
			$data_tbl['expand']=true;
			$data_tbl['select']=$line['SELECTED'];
			// $data_tbl['aktif']=$line['AKTIF'];
			
			$data[]=$data_tbl;
		}
		//return $this->db->last_query();
		return $data;
	}

	public function buildTree(array $elements, $parentId = 0,$checkbox=false) {
		$branch = array();
		foreach ($elements as $element) {

			if($checkbox==true){
				if($element['select']==1){
					$element['select']=true;
				}else{
					$element['select']=false;
				}
			}
			if ($element['parent_id'] == $parentId) {
				$children = $this->buildTree($elements, $element['id'],$checkbox);
				if ($children) {
					$element['children'] = $children;
				}
				$branch[] = $element;
			}
		}
		
		return $branch;
	}

	function insertBaru($data) {
		$this -> db -> insert($this -> table, $data);
	}

	public function get() {
		$this -> db -> from($this -> table);
		$this -> db -> order_by('KODE_USER ASC');
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
}

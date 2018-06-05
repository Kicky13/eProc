<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_master_ecatalog extends CI_Model {
	protected $table = 'EC_C_DOCTYPE', $tableCOMPANY = 'EC_C_COMPANY', $tablePURC_ORG = 'EC_C_PURC_ORG';
	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	} 

	function ubahStatCOMPANY($data) {
		$this -> db -> where("DOC_ID", $data['DOC_ID'], TRUE);
		$this -> db -> update($this -> tableCOMPANY, array('STATUS' => $data['STATUS']));
	}

	function ubahStatPURC_ORG($data) {
		$this -> db -> where("DOC_ID", $data['DOC_ID'], TRUE);
		$this -> db -> update($this -> tablePURC_ORG, array('STATUS' => $data['STATUS']));
	}

	public function getCOMPANY() {
		$this -> db -> from($this -> tableCOMPANY);
		$this -> db -> order_by('STATUS DESC,DOC_ID ASC');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	function getDetailCOMPANY($ptm) {
		$this -> db -> from($this -> tableCOMPANY);
		$this -> db -> where('ID', $ptm);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	function insertCOMPANY($data) {
		$this -> db -> insert($this -> tableCOMPANY, array('TYPE' => $data['TYPE']));
	}

	public function getPURC_ORG() {
		$this -> db -> from($this -> tablePURC_ORG);
		$this -> db -> order_by('STATUS DESC,DOC_ID ASC');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	function getDetailPURC_ORG($ptm) {
		$this -> db -> from($this -> tablePURC_ORG);
		$this -> db -> where('ID', $ptm);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	function insertPURC_ORG($data) {
		$this -> db -> insert($this -> tablePURC_ORG, array('TYPE' => $data['TYPE']));
	}

}

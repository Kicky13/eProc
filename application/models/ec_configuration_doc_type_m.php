<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_configuration_doc_type_m extends CI_Model {
	protected $table = 'EC_C_DOCTYPE';
	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	public function get() {
		$this -> db -> from($this -> table);
		$this -> db -> order_by('DOC_STATUS DESC, DOC_ID ASC');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	function getDetail($ptm) {
		$this -> db -> from($this -> table);
		$this -> db -> where('DOC_ID', $ptm);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	function insert($data) {
		$this -> db -> insert($this -> table, array('DOC_CATEGORY' => $data['DOC_CATEGORY'], 'DOC_TYPE' => $data['DOC_TYPE']));
	}

	function ubahStat($data) {
		$this -> db -> where("DOC_ID", $data['DOC_ID'], TRUE);
		$this -> db -> update($this -> table, array('DOC_STATUS' => $data['DOC_STATUS']));
	}

}

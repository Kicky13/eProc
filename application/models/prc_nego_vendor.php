<?php defined('BASEPATH') OR exit('No direct script access allowed');

class prc_nego_vendor extends CI_Model {

	protected $table = 'PRC_NEGO_VENDOR';
	protected $id = 'NV_ID';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		$this->is_join_pqi = false;
		return (array) $result->result_array();
	}

	public function where_id($nego_id) {
		$this->db->where(array('NEGO_ID' => $nego_id));
	}

	public function where_ptm($ptm) {
		$this->db->where(array('PTM_NUMBER' => $ptm));
	}

	public function join_vnd() {
		$this->db->join('VND_HEADER', "VND_HEADER.VENDOR_NO = $this->table.PTV_VENDOR_CODE", 'inner');
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function insert_batch($data) {
		$this->db->insert_batch($this->table, $data);
	}

	public function get_id() {
		$this->db->select_max($this->id, 'MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	public function update($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}

}
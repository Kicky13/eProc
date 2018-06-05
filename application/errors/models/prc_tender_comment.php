<?php defined('BASEPATH') OR exit('No direct script access allowed');

class prc_tender_comment extends CI_Model {

	protected $table = 'PRC_TENDER_COMMENT';
	protected $id = 'PTC_ID';
	protected $is_join_pqi = false;

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$this->db->order_by('PTC_END_DATE', 'desc');
		$result = $this->db->get();
		return (array)$result->result_array();
	}

	public function ptm($ptm) {
		return $this->get(array('PRC_TENDER_COMMENT.PTM_NUMBER' => $ptm));
	}

	public function where_activity($value) {
		$this->db->where("PRC_TENDER_COMMENT.PTC_ACTIVITY", $value);
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
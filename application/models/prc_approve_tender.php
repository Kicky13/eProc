<?php
class prc_approve_tender extends CI_Model {

	protected $table = 'PRC_APPROVE_TENDER';

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
		return $result->result_array();
	}

	public function get_id() {
		$this->db->select_max('PAT_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	public function counter_at($counter, $opco) {
		return $this->get(array('PAT_COUNTER' => $counter, 'PAT_OPCO' => $opco));
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function insert_batch($data) {
		$this->db->insert_batch($this->table, $data);
	}

	public function update($set=NULl, $where=NULL) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

}
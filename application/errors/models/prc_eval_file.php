<?php defined('BASEPATH') OR exit('No direct script access allowed');

class prc_eval_file extends CI_Model {

	protected $table = 'PRC_EVAL_FILE';
	protected $id = 'EF_ID';

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
		return (array)$result->result_array();
	}

	public function join_et() {
		$this->db->join('PRC_EVALUASI_TEKNIS', 'PRC_EVALUASI_TEKNIS.ET_ID = PRC_EVAL_FILE.ET_ID', 'inner');
	}

	public function where_ptm($ptm) {
		$this->db->where('PRC_EVAL_FILE.PTM_NUMBER', $ptm);
	}

	public function where_ptm_ptv($ptm, $ptv) {
		$this->where_ptm($ptm);
		$this->db->where('PRC_EVAL_FILE.PTV_VENDOR_CODE', $ptv);
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
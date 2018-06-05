<?php defined('BASEPATH') OR exit('No direct script access allowed');

class prc_do_evatek_uraian extends CI_Model {

	protected $table = 'PRC_DO_EVATEK_URAIAN';
	protected $id = 'DEU_ID';
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
		$result = $this->db->get();
		$this->is_join_pqi = false;
		return (array)$result->result_array();
	}

	public function join_pqi() {
		if (!$this->is_join_pqi){
			$this->db->join('PRC_DO_EVATEK', 'PRC_DO_EVATEK.DET_ID = PRC_DO_EVATEK_URAIAN.DET_ID', 'inner');
			$this->db->join('PRC_TENDER_QUO_ITEM', 'PRC_TENDER_QUO_ITEM.PQI_ID = PRC_DO_EVATEK.PQI_ID', 'inner');
			$this->is_join_pqi = true;
		}
	}

	public function where_ptm($ptm) {
		$this->join_pqi();
		$this->db->join('PRC_TENDER_QUO_MAIN', 'PRC_TENDER_QUO_MAIN.PQM_ID = PRC_TENDER_QUO_ITEM.PQM_ID', 'inner');
		$this->db->where('PRC_TENDER_QUO_MAIN.PTM_NUMBER', $ptm);
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
<?php
class prc_tender_winner extends CI_Model {

	protected $table = 'PRC_TENDER_WINNER', $tablepritem = "PRC_PR_ITEM";

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function getPRItem($PPI_ID){
		$this->db->select("*");
		$this->db->from($this->tablepritem);
		$this->db->where('PPI_ID = '.$PPI_ID, null, false);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return NULL;
		}
	}

	public function get($where = NULL) {
		if (!empty($where)) {
			$this->db->where(array('PTW_ID' => $where));
		}
		$this->db->from($this->table);
		$this->db->order_by('PTW_CREATED_AT', 'ASC');
		$result = $this->db->get();
		return $result->result_array();
	}

	public function where_status($id = null) {
		$this->db->where(array('PO_STATUS' => $id));
	}

	public function join_ptm() {
		$this->db->join('PRC_TENDER_MAIN', 'PRC_TENDER_MAIN.PTM_NUMBER = PRC_TENDER_WINNER.PTM_NUMBER', 'inner');
	}

	public function where_contract() {
		$this->db->where(array('PTM_NUMBER' => NULL));
	}

	public function where_rfq() {
		$this->db->where('PRC_TENDER_WINNER.PTM_NUMBER IS NOT NULL');
	}

	public function where_ptm($ptm) {
		$this->db->where(array('PTM_NUMBER' => $ptm));
	}

	public function where_pgrp_in($pgrp){
		$this->db->where_in('PPR_PGRP',$pgrp);
	}

	public function get_id() {
		$this->db->select_max('PTW_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function insert_batch($data) {
		$this->db->insert_batch($this->table, $data);
	}

	public function update($set = NULl, $where = NULL) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function delete($id = NULL){
		$this->db->where('PTW_ID', $id);
		$this->db->delete('PRC_TENDER_WINNER');
	}

	public function join_pr(){
		$this->db->join('PRC_PR_ITEM','PRC_PR_ITEM.PPI_ID = PRC_TENDER_WINNER.PPI_ID', 'left');
	}

}
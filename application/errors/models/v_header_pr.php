<?php defined('BASEPATH') OR exit('No direct script access allowed');

class v_header_pr extends CI_Model {

	protected $table = 'V_HEADER_PR';
	protected $id = 'PPR_PRNO';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function select($select) {
		return $this->db->select($select);
	}

	public function get($where=NULL, $statu = true) {
		if ($statu) {
			$this->where_has_item_n();
		}
		$this->db->distinct();
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		return (array) $result->result_array();
	}

	public function where_has_item_n() {
		$where = "(select count(PPI_ID) from PRC_PR_ITEM where PPI_PRNO = PPR_PRNO and STATU = 'N') > 0";
		$this->db->where($where, null, false);
	}

	public function join_pr_item() {
		$this->db->join('PRC_PR_ITEM', 'PRC_PR_ITEM.PPI_PRNO = V_HEADER_PR.PPR_PRNO', 'inner');
	}

	public function join_mrpc() {
		$this->db->join('ADM_MRPC', 'ADM_MRPC.MRPC = PRC_PR_ITEM.PPI_MRPC AND ADM_MRPC.PLANT = V_HEADER_PR.PPR_PLANT', 'inner');
	}

	public function where_mrpc($val) {
		$this->db->where('ADM_MRPC.MRPC', $val);
	}

	public function where_qty() {
		$this->db->where('PRC_PR_ITEM.PPI_QTY_USED != PRC_PR_ITEM.PPI_QUANTOPEN');
	}

	public function where_plant($val) {
		$this->db->where('V_HEADER_PR.PPR_PLANT', $val);
	}

	public function where_tor($val) {
		$this->db->where('V_HEADER_PR.PPR_STT_TOR', $val);
	}

	public function where_ver($val) {
		$this->db->where('V_HEADER_PR.PPR_STTVER <>', $val);
	}

	public function where_sttver($val){
		$this->db->where_not_in('V_HEADER_PR.PPR_STTVER', $val);
	}

	public function where_close($val) {
		$this->db->where('V_HEADER_PR.PPR_STT_CLOSE', $val);
	}

	public function where_pgrp_in($pgrp) {
		$this->db->where('V_HEADER_PR.PPR_PGRP IN (' . $pgrp . ')', null, false);
	}

	// sinyo nambah
	public function join_adm_pucrh_grp() {
		$this->db->join('ADM_EMPLOYEE_PUCH_GRP', 'ADM_EMPLOYEE_PUCH_GRP.PURC_GRP_ID = V_HEADER_PR.PPR_PGRP', 'inner');
	}
	// end nambah

	public function where_emp($val) {
		$this->db->where('ADM_MRPC.EMP_ID', $val);
	}

	public function where_requestioner($val) {
		$this->db->where('V_HEADER_PR.PPR_REQUESTIONER', $val);
	}

}
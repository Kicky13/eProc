<?php defined('BASEPATH') OR exit('No direct script access allowed');

class adm_approve_kewenangan extends CI_Model {

	protected $table = 'ADM_APPROVE_KEWENANGAN';
	protected $id = 'PERSETUJUAN_ID';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->select($this->table . '.*');
		$this->db->from($this->table);
		$this->db->order_by('ADM_APPROVE_KEWENANGAN.URUTAN', 'ASC');
		$result = $this->db->get();
		return (array)$result->result_array();
	}

	public function where_pgrp($pgrp) {
		$this->db->where('PGRP', $pgrp);
		return $this;
	}

	public function where_catprc($cat) {
		$this->db->where('PRC_STATUS', $cat);
		return $this;
	}

	public function where_pgrp_in($pgrp) {
		$this->db->where('PGRP IN (' . $pgrp . ')', null, false);
	}

	public function where_total($harga) {
		$this->db->where('BATAS_HARGA >=', $harga);
		return $this;
	}

	public function where_harga_not_null() {
		$this->db->where('BATAS_HARGA IS NOT NULL', null,false);
		return $this;
	}

	public function join_emp() {
		$this->db->select('ADM_EMPLOYEE.NO_PEG, ADM_EMPLOYEE.FULLNAME, ADM_EMPLOYEE.EM_COMPANY');
		$this->db->join('ADM_EMPLOYEE', "$this->table.EMP_ID = ADM_EMPLOYEE.ID", 'inner');

		$this->db->select('ADM_POS.POS_NAME');
		$this->db->join('ADM_POS', "ADM_EMPLOYEE.ADM_POS_ID = ADM_POS.POS_ID", 'inner');
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
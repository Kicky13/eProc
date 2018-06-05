<?php
class adm_employee_puch_grp extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "ADM_EMPLOYEE_PUCH_GRP";
	}

	function get($where = NULL) {
		$this->db->select($this->table . '.*');
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		
		$result = $this->db->get();
		return $result->result_array();
	}

	function pgrp($pgrp) {
		$this->db->where(array('PURC_GRP_ID' => $pgrp));
		$this->get();
	}

	function insert($data) {
		if($this->db->insert($this->table, $data)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function update($data, $where) {
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}
		if($this->db->update($this->table, $data)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function delete($where) {
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}
		if($this->db->delete($this->table)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function get_total_data($where = NULL) {
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$this->db->like($key, $value);
			}
		}
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	function get_total_data_without_filter() {
		return  $this->db->count_all($this->table);
	}
}
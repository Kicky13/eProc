<?php defined('BASEPATH') OR exit('No direct script access allowed');

class app_process extends CI_Model {

	protected $table = 'APP_PROCESS';
	protected $id = 'PROCESS_ID';

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

	public function get_last_query() {
		echo $this->db->last_query();
		exit();
	}

	public function where_unique($kel_plant_pro, $sampul, $justification, $current_process = NULL) {
		$where['KEL_PLANT_PRO'] = $kel_plant_pro;
		$where['TIPE_SAMPUL'] = $sampul;
		$where['JUSTIFICATION'] = $justification;
		if ($current_process != null) {
			$where['CURRENT_PROCESS'] = $current_process;
		}
		// var_dump($where); exit();
		$this->db->where($where);
	}

	public function where_pgrp($pgrp) {
		$this->db->where(array('PURC_GRP_ID' => $pgrp));
	}

	public function find($process_id) {
		$process = $this->get(array('PROCESS_ID' => $process_id));
		if (empty($process)) return null;
		return $process[0];
	}

	public function join_emp() {
		$this->db->join('APP_PROCESS_ROLE', 'APP_PROCESS_ROLE.PROCESS_ID = APP_PROCESS.PROCESS_ID', 'INNER');
		$this->db->join('ADM_EMPLOYEE', 'ADM_EMPLOYEE.ADM_POS_ID = APP_PROCESS_ROLE.ROLE', 'INNER');
	}

	public function join_pgrp() {
		// $this->db->select('PURC_GRP_ID');
		$this->db->join('ADM_EMPLOYEE_PUCH_GRP', 'ADM_EMPLOYEE.ID = ADM_EMPLOYEE_PUCH_GRP.EMPLOYEE_ID', 'inner');
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
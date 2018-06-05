<?php defined('BASEPATH') OR exit('No direct script access allowed');

class prc_evaluator extends CI_Model {

	protected $table = 'PRC_EVALUATOR';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function ptm($ptm) {
		$this->db->order_by('PE_COUNTER', 'ASC');
		return $this->get(array('PRC_EVALUATOR.PTM_NUMBER' => $ptm));
	}

	function insert($data) {
		$this->db->insert($this->table, $data);
	}

	function insert_user_ptm($users, $ptm) {
		$data = array();
		foreach ($users as $user) {
			$temp['EMP_ID'] = $user;
			$temp['PTM_NUMBER'] = $ptm;
			$data[] = $temp;
		}
		$this->insert_batch($data);
	}

	public function join_emp() {
		$this->db->join('ADM_EMPLOYEE', 'ADM_EMPLOYEE.ID = PRC_EVALUATOR.EMP_ID', 'inner');
		$this->db->join('ADM_POS', 'ADM_EMPLOYEE.ADM_POS_ID = ADM_POS.POS_ID', 'inner');
		$this->db->join('ADM_DEPT', 'ADM_DEPT.DEPT_ID = ADM_POS.DEPT_ID', 'inner');
	}

	public function where_status($status) {
		$this->db->where(array('PE_STATUS' => $status));
	}

	/* ngambil counter yang terakhir dilakukan */
	public function get_max_counter($ptm, $iter) {
		$this->db->where(array('PTM_NUMBER' => $ptm, 'PE_ITERATION' => $iter));
		$this->db->select_max('PE_COUNTER', 'MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX'];
	}

	function insert_batch($data) {
		$this->db->insert_batch($this->table, $data);
	}

	function update($set=NULl, $where=NULL) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	function deleteByPtm($ptm) {
		$this->db->where(array('PTM_NUMBER' => $ptm));
		return $this->db->delete($this->table);
	}

	function get_desc($where = NULL,$limit=NULL) {
		$this->db->select("*");
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		if (!empty($limit)) {
			$this->db->limit($limit);
		}
		$this->db->order_by('PE_COUNTER', 'desc');
		$result = $this->db->get();
		return (array) $result->result_array();
	}

}
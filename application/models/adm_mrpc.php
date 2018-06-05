<?php defined('BASEPATH') OR exit('No direct script access allowed');

class adm_mrpc extends CI_Model {

	protected $table = 'ADM_MRPC';
	protected $id = 'ID';

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

	public function join_emp_plant() {
		$this->db->select('ADM_EMPLOYEE.NO_PEG, ADM_EMPLOYEE.FULLNAME, ADM_EMPLOYEE.EM_COMPANY, ADM_PLANT.PLANT_NAME,'. $this->table . '.*');
		$this->db->join('ADM_EMPLOYEE', "$this->table.EMP_ID = ADM_EMPLOYEE.ID", 'inner');

		//$this->db->select('ADM_PLANT.PLANT_NAME');
		$this->db->join('ADM_PLANT', "$this->table.PLANT = ADM_PLANT.PLANT_CODE", 'inner');


		//$this->db->select('MRPC, ID, ESELON');
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
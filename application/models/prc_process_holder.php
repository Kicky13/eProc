<?php defined('BASEPATH') OR exit('No direct script access allowed');

class prc_process_holder extends CI_Model {

	protected $table = 'PRC_PROCESS_HOLDER';

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

	function emp($ptm) {
		$this->db->join('ADM_EMPLOYEE', 'ADM_EMPLOYEE.ID = PRC_PROCESS_HOLDER.EMP_ID', 'inner');
		$this->db->where('PRC_PROCESS_HOLDER.PTM_NUMBER', $ptm);
		return $this->db->get($this->table)->result_array();
	}

	function get_id() {
		$this->db->select_max('HOLDER_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function get_count($emp_id) {
		$this->db->select('EMP_ID');
		$this->db->select('COUNT(EMP_ID) AS HITUNG');
		$this->db->group_by('EMP_ID');
		$this->db->where('EMP_ID', $emp_id);
		$retval = $this->db->get($this->table)->row_array();
		return $retval;
	}

	function insert($data) {
		$this->db->insert($this->table, $data);
	}

	function insert_user_ptm($users, $ptm) {
		$users = (array) $users;
		$data = array();
		$id = $this->get_id();
		foreach ($users as $user) {
			$temp['EMP_ID'] = $user;
			$temp['PTM_NUMBER'] = $ptm;
			$temp['HOLDER_ID'] = $id;
			$data[] = $temp;
			$id++;
		}
		$this->insert_batch($data);
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

}
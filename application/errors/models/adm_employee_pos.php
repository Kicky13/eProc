<?php
class adm_employee_pos extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "ADM_EMPLOYEE_POS";
	}

	function get($where = NULL,$limit=NULL,$offset=NULL) {
		$this->db->select("EMPLOYEE_POS_ID, EMPLOYEE_ID, POS_ID, POS_NAME, DEPT_ID, DEPT_NAME, IS_ACTIVE, IS_MAIN_JOB");
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->from($this->table);
		if (!empty($limit)) {
			if (!empty($offset)) {
				$this->db->limit($limit,$offset);
			}
			else {
				$this->db->limit($limit);
			}
		}
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return NULL;
		}
	}

	function insert( $EMPLOYEE_POS_ID = FALSE, $EMPLOYEE_ID = FALSE, $POS_ID = FALSE, $POS_NAME = FALSE, $DEPT_ID = FALSE, $DEPT_NAME = FALSE, $IS_ACTIVE = FALSE, $IS_MAIN_JOB = FALSE ) {
		$data = array(
			'EMPLOYEE_POS_ID' => $EMPLOYEE_POS_ID,
			'EMPLOYEE_ID' => $EMPLOYEE_ID,
			'POS_ID' => $POS_ID,
			'POS_NAME' => $POS_NAME,
			'DEPT_ID' => $DEPT_ID,
			'DEPT_NAME' => $DEPT_NAME,
			'IS_ACTIVE' => $IS_ACTIVE,
			'IS_MAIN_JOB' => $IS_MAIN_JOB);
		$this->db->insert($this->table, $data); 
	}

	function insert_custom($data) {
		if($this->db->insert($this->table, $data)) {
			return TRUE;
		}
		else {
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
?>
<?php
class adm_dept extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "ADM_DEPT";
		$this->table_district = "ADM_DISTRICT";
		$this->table_company = "ADM_COMPANY";
	}

	function get_id() {
		$this->db->select_max('DEPT_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function get($where = NULL,$limit=NULL,$offset=NULL) {
		$this->db->select("DEPT_ID, DEPT_NAME, DEP_CODE, DISTRICT_ID, DISTRICT_NAME");
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

	public function getByCompanyId($company_id)
	{
		$this->db->select("DEPT_ID, DEPT_NAME, DEP_CODE, $this->table_district.DISTRICT_ID, $this->table_district.DISTRICT_NAME");
		$this->db->join($this->table_district,"$this->table.DISTRICT_ID = $this->table_district.DISTRICT_ID");
		$this->db->join($this->table_company,"$this->table_company.COMPANYID = $this->table_district.COMPANY_ID");
		$this->db->from($this->table);
		$this->db->where("$this->table_company.COMPANYID", $company_id);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return NULL;
		}
	}

	function insert( $DEPT_ID = FALSE, $DEPT_NAME = FALSE, $DEP_CODE = FALSE, $DISTRICT_ID = FALSE, $DISTRICT_NAME = FALSE ) {
		$data = array(
			'DEPT_ID' => $DEPT_ID,
			'DEPT_NAME' => $DEPT_NAME,
			'DEP_CODE' => $DEP_CODE,
			'DISTRICT_ID' => $DISTRICT_ID,
			'DISTRICT_NAME' => $DISTRICT_NAME);
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
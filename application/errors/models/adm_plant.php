<?php
class adm_plant extends CI_Model {

	protected $table = 'ADM_PLANT';
	protected $id = 'PLANT_CODE';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where = NULL,$limit=NULL,$offset=NULL) {
		$this->db->select("PLANT_CODE, PLANT_NAME, COMPANY_ID");
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

	public function find($id) {
		$retval = $this->get(array("$this->table.$this->id" => $id));
		if (count($retval) >= 0) {
			return $retval[0];
		} else {
			return null;
		}
	}

	public function insert( $PLANT_CODE = FALSE, $PLANT_NAME = FALSE, $COMPANY_ID = FALSE ) {
		$data = array(
			'PLANT_CODE' => $PLANT_CODE,
			'PLANT_NAME' => $PLANT_NAME,
			'COMPANY_ID' => $COMPANY_ID);
		$this->db->insert($this->table, $data); 
	}

	public function insert_custom($data) {
		if($this->db->insert($this->table, $data)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function update($data, $where) {
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

	public function get_total_data($where = NULL) {
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$this->db->like($key, $value);
			}
		}
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_total_data_without_filter() {
		return  $this->db->count_all($this->table);
	}
}
?>
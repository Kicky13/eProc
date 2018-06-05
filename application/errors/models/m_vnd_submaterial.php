<?php
class m_vnd_submaterial extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "M_VND_SUBMATERIAL";
		$this->table_material = "M_VND_MATERIAL";
	}

	function get($where = NULL) {
		$this->db->select("SUBMATERIAL_ID, SUBMATERIAL_CODE, SUBMATERIAL_NAME, SUBMATERIAL_DESC");
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return NULL;
		}
	}

	function get_from_material($where = NULL) {
		$this->db->_protect_identifiers=false;
		$this->db->select("SUBMATERIAL_CODE, SUBMATERIAL_NAME");
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->from($this->table.' t1');
		$this->db->join($this->table_material.' t2', 't1.SUBMATERIAL_ID = t2.SUBMATERIAL_ID');
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return NULL;
		}
	}
}
?>
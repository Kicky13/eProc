<?php
class m_vnd_subsvc extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "M_VND_SUBSVC";
		$this->table_svc = "M_VND_SVC";
	}

	function get($where = NULL) {
		$this->db->select("SUBSVC_ID, SUBSVC_CODE, SUBSVC_NAME, SUBSVC_DESC");
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

	function get_from_svc($where = NULL) {
		$this->db->_protect_identifiers=false;
		$this->db->select("SUBSVC_CODE, SUBSVC_NAME");
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->from($this->table.' t1');
		$this->db->join($this->table_svc.' t2', 't1.SUBSVC_ID = t2.SUBSVC_ID');
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
<?php
class m_vnd_sdm_type_kwn extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "M_VND_SDM_TYPE_KWN";
	}

	function get($where = NULL) {
		$this->db->select("TYPE_KWN_ID, TYPE_KWN");
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
}
?>
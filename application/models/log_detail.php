<?php
class log_detail extends CI_Model
{
	protected $table = 'LOG_DETAIL';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where = null)
	{
		$this->db->select('*', false);
		if($where != null) {
			$this->db->where($where);
		}
		$this->db->order_by('LD_ID', 'asc');
		$result = $this->db->get($this->table);
		return $result->result_array();
	}

	function insert($data) {
		return $this->db->insert($this->table, $data);
	}
}
?>
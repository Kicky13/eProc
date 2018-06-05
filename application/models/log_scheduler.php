<?php
class log_scheduler extends CI_Model
{
	protected $table = 'LOG_SCHEDULER';
	public $primary_key = 'ID';

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
		$this->db->order_by('LM_ID', 'asc');
		$result = $this->db->get($this->table);
		return $result->result_array();
	}

	function insert($data) {
		return $this->db->insert($this->table, $data);
	}

	public function get_last_id() {
        $this->db->select_max($this->primary_key, 'MAX');
        $max = $this->db->get($this->table)->row_array();
        return $max['MAX'];
    }

}
?>
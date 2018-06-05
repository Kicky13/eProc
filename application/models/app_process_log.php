<?php
class app_process_log extends CI_Model {

	protected $table = 'APP_PROCESS_LOG';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=NULL, $select = false)
	{
		if (!$select) $select = '*';
		$this->db->select($select);
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return null;
		}
	}

	function pr($prno, $select = false) {
		return $this->get(array('PRNO' => $prno), $select);
	}

	function insert($data) {
		$this->db->insert($this->table, $data);
	}

	function insert_batch($data) {
		$this->db->insert_batch($this->table, $data);
	}

	function delete($where = null) {
		if ($where != null) {
			$this->db->where($where);
			return $this->db->delete($this->table);
		} else {
			return $this->db->empty_table($this->table);
		}
	}

	function update($set, $where)
	{
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	function get_id()
	{
		$this->db->select_max('ID_LOG','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

}
<?php
class prc_preq_quo_tech extends CI_Model {

	protected $table = 'PRC_PREQ_QUO_TECH';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=NULL)
	{
		$this->db->select('*');
		$this->db->join('PRC_PREQ_EVAL', 'PRC_PREQ_QUO_TECH.PQE_ID = PRC_PREQ_EVAL.PQE_ID', 'left');
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		return $result->result_array();
	}

	function get_id()
	{
		$this->db->select_max('QQT_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	function update($set=NULl, $where=NULL)
	{
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}

}
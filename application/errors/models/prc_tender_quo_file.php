<?php
class prc_tender_quo_file extends CI_Model {

	protected $table = 'PRC_TENDER_QUO_FILE';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=NULL)
	{
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		return $result->result_array();
	}

	function pqm($pqm) {
		return $this->get(array('PQM_ID' => $pqm));
	}

	function get_id()
	{
		$this->db->select_max('PQF_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	function insert_batch($data)
	{
		$this->db->insert_batch($this->table, $data);
	}

	function update($set=NULl, $where=NULL)
	{
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	function deleteByPqm($pqm) {
		$this->db->where(array('PQM_ID' => $pqm));
		return $this->db->delete($this->table);
	}

}
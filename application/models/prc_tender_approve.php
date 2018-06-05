<?php
class prc_tender_approve extends CI_Model {

	protected $table = 'PRC_TENDER_APPROVE';

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

	function get_id()
	{
		$this->db->select_max('TAP_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	/* ngambil counter yang terakhir dilakukan */
	public function get_max_counter($ptm, $iter) {
		$this->db->where(array('PTM_NUMBER' => $ptm, 'TAP_ITERATION' => $iter));
		$this->db->select_max('TAP_COUNTER', 'MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX'];
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

}
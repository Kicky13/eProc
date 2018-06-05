<?php
class prc_preq_eval extends CI_Model {

	protected $table = 'PRC_PREQ_EVAL';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=NULL)
	{
		$this->db->select('*');
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		return $result->result_array();
	}

	function ptm($ptm) {
		return $this->get(array('PTM_NUMBER' => $ptm));
	}

	function where_ptm_ptv($ptm, $ptv) {
		$this->db->where(array('PTM_NUMBER' => $ptm, 'PTV_VENDOR_CODE' => $ptv));
	}

	function ptm_ptv($ptm, $ptv) {
		$this->where_ptm_ptv($ptm, $ptv);
		return $this->get();
	}

	function get_id()
	{
		$this->db->select_max('PQE_ID','MAX');
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

	function delete_ptm_ptv($ptm, $ptv) {
		$this->where_ptm_ptv($ptm, $ptv);
		return $this->db->delete($this->table);
	}

	function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}

}
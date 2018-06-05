<?php
class prc_tender_eval extends CI_Model {

	protected $table = 'PRC_TENDER_EVAL';

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
		$result = $this->db->get($this->table);
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return null;
		}
	}

	function join_vendor() {
		$this->db->join('VND_HEADER', 'PRC_TENDER_EVAL.PTV_VENDOR_CODE = VND_HEADER.VENDOR_ID', 'left');
	}

	function get_by_ptv($ptv) {
		return $this->get(array('PTV_VENDOR_CODE' => $ptv));
	}

	function get_id() {
		$this->db->select_max('PTE_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function insert($data) {
		$data['PTE_ID'] = $this->get_id();
		$this->db->insert($this->table, $data);
	}

	function update($set, $where)
	{
		/* cek dulu kalau ternyata datanya ga ada */
		$this->db->where($where);
		$result = $this->db->get($this->table);
		if ($result->num_rows() <= 0) {
			$this->insert($where);
		} else if ($result->num_rows() > 1) {
			return false;
		}
		
		$this->db->where($where);
		return $this->db->update($this->table, $set);
		/* ini baru ngupdate beneran */
		// $this->db->reset_query();
	}

}
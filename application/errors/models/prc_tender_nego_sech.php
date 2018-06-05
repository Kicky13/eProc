<?php
class prc_tender_nego_sech extends CI_Model {

	protected $table = 'PRC_TENDER_NEGO_SECH';

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
		$this->db->order_by('PTNS_CREATED_DATE', 'desc');
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return null;
		}
	}

	function ptm($ptm) {
		return $this->get(array('PTM_NUMBER' => $ptm));
	}

	function ptm_ptv($ptm, $ptv) {
		$this->db->where("(PTV_VENDOR_CODE = '$ptv' or PTV_VENDOR_CODE is null)" , null, false);
		return $this->get(array('PTM_NUMBER' => $ptm));
	}

	function join_vnd() {
		$this->db->join('VND_HEADER', 'PRC_TENDER_NEGO_SECH.PTV_VENDOR_CODE = VND_HEADER.VENDOR_ID', 'left');
	}

	function get_id()
	{
		$this->db->select_max('PTNS_ID', 'MAX');
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

}
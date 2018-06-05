<?php
class prc_tender_item_log extends CI_Model {

	protected $table = 'PRC_TENDER_ITEM_LOG';

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
		$this->join_item();
		$this->db->from($this->table);
		$result = $this->db->get();
		return $result->result_array();
	}

	function join_pqi($ptv) {
		$this->db->join('PRC_TENDER_QUO_ITEM', 'PRC_TENDER_QUO_ITEM.TIT_ID = PRC_TENDER_ITEM.TIT_ID', 'left');
		$this->db->join('PRC_TENDER_QUO_MAIN', 'PRC_TENDER_QUO_MAIN.PQM_ID = PRC_TENDER_QUO_ITEM.PQM_ID', 'left');
		$this->db->where(array('PRC_TENDER_QUO_MAIN.PTV_VENDOR_CODE' => $ptv));
	}

	function join_item() {
		$this->db->join('PRC_PR_ITEM', 'PRC_PR_ITEM.PPI_PRNO = PRC_TENDER_ITEM.TIT_PR_NO AND PRC_PR_ITEM.PPI_PRITEM = PRC_TENDER_ITEM.TIT_PR_ITEM_NO', 'left');
	}

	function ptm($ptm)
	{
		return $this->get(array('PRC_TENDER_ITEM.PTM_NUMBER' => $ptm));
	}

	function get_id()
	{
		$this->db->select_max('TIT_ID','MAX');
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

	function deleteByPtm($ptm) {
		$this->db->where(array('PTM_NUMBER' => $ptm));
		return $this->db->delete($this->table);
	}

}
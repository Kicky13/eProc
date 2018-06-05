<?php
class retender_item extends CI_Model {

	protected $table = 'RETENDER_ITEM';
	protected $join_item_status = false;

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->join_item_status = false;
	}

	function get($where=NULL)
	{
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->join_item();
		$this->db->from($this->table);
		$this->db->order_by('RETENDER_ITEM.TIT_ID', 'ASC');
		$result = $this->db->get();
		$this->join_item_status = false;
		return $result->result_array();
	}

	function where_status($status) {
		$this->db->where(array('TIT_STATUS' => $status));
	}

	public function get_tit_status() {
		return array(
				0 => "Belum Nego",
				1 => "Terpilih Nego Biasa",
				2 => "Sedang Nego Biasa",
				3 => "Terpilih Nego Auction",
				4 => "Sedang Nego Auction",
				5 => "Sudah Nego",
				6 => "Ditunjuk Pemenang",
				7 => "Analisa Kewajaran Harga",
				8 => "Sudah Ditunjuk Pemenang",
				9 => "Sudah Ditunjuk Pemenang",
			);
	}

	function join_pqi($ptv) {
		$this->db->join('PRC_TENDER_QUO_ITEM', 'PRC_TENDER_QUO_ITEM.TIT_ID = RETENDER_ITEM.TIT_ID', 'left');
		$this->db->join('PRC_TENDER_QUO_MAIN', 'PRC_TENDER_QUO_MAIN.PQM_ID = PRC_TENDER_QUO_ITEM.PQM_ID', 'left');
		$this->db->where(array('PRC_TENDER_QUO_MAIN.PTV_VENDOR_CODE' => $ptv));
	}

	function join_item() {
		if ($this->join_item_status == false) {
			$this->db->join('PRC_PR_ITEM', 'PRC_PR_ITEM.PPI_ID = RETENDER_ITEM.PPI_ID', 'left');
			$this->join_item_status = true;
		}
	}

	function join_pr() {
		$this->join_item();
		$this->db->join('PRC_PURCHASE_REQUISITION', 'PRC_PR_ITEM.PPI_PRNO = PRC_PURCHASE_REQUISITION.PPR_PRNO', 'left');
	}

	function ptm($ptm)
	{
		return $this->get(array('RETENDER_ITEM.PTM_NUMBER' => $ptm));
	}

	function ptm_paqh($ptm, $paqh)
	{
		return $this->get(array('RETENDER_ITEM.PTM_NUMBER' => $ptm, 'RETENDER_ITEM.PAQH_ID' => $paqh));
	}

	function ptm_auction($ptm)
	{
		return $this->get(array('RETENDER_ITEM.PTM_NUMBER' => $ptm, 'RETENDER_ITEM.TIT_STATUS' => 3, 'RETENDER_ITEM.PAQH_ID IS NULL' => null));
	}

	function get_id()
	{
		$this->db->select_max('TIT_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function insert($data)
	{
		return $this->db->insert($this->table, $data);
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
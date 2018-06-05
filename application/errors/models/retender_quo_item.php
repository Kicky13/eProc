<?php
class retender_quo_item extends CI_Model {

	protected $table = 'RETENDER_QUO_ITEM';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get_fresh($where = null) {
		$this->db->select('*');
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		// var_dump($this->db->last_query());
		return $result->result_array();
	}

	function get($where=NULL) {
		$this->join_item();
		return $this->get_fresh($where);
	}

	public function join_item() {
		$this->db->join('PRC_TENDER_ITEM', 'RETENDER_QUO_ITEM.TIT_ID = PRC_TENDER_ITEM.TIT_ID', 'left');
		$this->db->join('PRC_PR_ITEM', 'PRC_PR_ITEM.PPI_ID = PRC_TENDER_ITEM.PPI_ID', 'left');
		$this->db->join('PRC_PURCHASE_REQUISITION', 'PRC_PURCHASE_REQUISITION.PPR_PRNO = PRC_PR_ITEM.PPI_PRNO', 'left');
	}

	function get_by_pqm($pqm_id) {
		return $this->get(array('PQM_ID' => $pqm_id));
	}

	function join_pqm() {
		$this->db->join('PRC_TENDER_QUO_MAIN', 'PRC_TENDER_QUO_MAIN.PQM_ID = RETENDER_QUO_ITEM.PQM_ID', 'left');

	}

	public function where_tit($tit) {
		$this->db->where(array('RETENDER_QUO_ITEM.TIT_ID' => $tit));
	}

	public function where_tit_status($tit_status) {
		$this->db->where(array('PRC_TENDER_ITEM.TIT_STATUS' => $tit_status));
	}

	public function where_win($win = 1) {
		$this->db->where(array('RETENDER_QUO_ITEM.PQI_IS_WINNER' => $win));
	}

	function ptm_ptv($ptm, $ptv) {
		$this->join_pqm();
		return $this->get(array('PRC_TENDER_QUO_MAIN.PTM_NUMBER' => $ptm, 'PRC_TENDER_QUO_MAIN.PTV_VENDOR_CODE' => $ptv));
	}

	function ptm_ptv_paqh($ptm, $ptv,$paqh) {
		$this->join_pqm();
		return $this->get(array('PRC_TENDER_QUO_MAIN.PTM_NUMBER' => $ptm, 'PRC_TENDER_QUO_MAIN.PTV_VENDOR_CODE' => $ptv,'PRC_TENDER_ITEM.PAQH_ID' => $paqh));
	}

	function get_by_ptm($ptm){
		//$this->join_pqm();
		return $this->get(array('PRC_TENDER_QUO_MAIN.PTM_NUMBER' => $ptm));
	}

	function get_id()
	{
		$this->db->select_max('PQI_ID','MAX');
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
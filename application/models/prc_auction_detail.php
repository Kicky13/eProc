<?php
class prc_auction_detail extends CI_Model
{
	var $table = "PRC_AUCTION_DETAIL";
	var $get_id_query = 'select max(PAQD_ID) as id from PRC_AUCTION_DETAIL';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get_id() {
		// $sql = 'select max(PPD_ID) as id from PRC_PLAN_DOC';
		$result = $this->db->query($this->get_id_query);
		$id = $result->row_array();
		return $id['ID'] + 1;
	}

	public function get_min_harga($paqh_id) {
		$SQL = 'SELECT
		MIN(PAQD_FINAL_PRICE) AS MINHARGA
		FROM
		"PRC_AUCTION_DETAIL"
		WHERE
		PAQH_ID = \'' . $paqh_id . '\'';
		$result = $this -> db -> query($SQL);
		return $result -> row_array();
	}

	public function insert($data) {
		return $this->db->insert($this->table, $data);
	}

	public function update($set=NULl, $where=NULL) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function get($where = null) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->order_by('PAQD_FINAL_PRICE', 'ASC');
		$result = $this->db->get($this->table);
		return (array)$result->result_array();
	}

	public function paqh($paqh_id) {
		return $this->get(array('PRC_AUCTION_DETAIL.PAQH_ID' => $paqh_id));
	}

	public function join_paqh(){
		$this->db->join('PRC_AUCTION_QUO_HEADER', 'PRC_AUCTION_QUO_HEADER.PAQH_ID = PRC_AUCTION_DETAIL.PAQH_ID', 'inner');
	}

	public function join_vnd() {
		$this->db->join('VND_HEADER', "VND_HEADER.VENDOR_NO = PRC_AUCTION_DETAIL.PTV_VENDOR_CODE", 'left');
		$this->db->join('PRC_AUCTION_QUO_HEADER', "PRC_AUCTION_QUO_HEADER.PAQH_ID = PRC_AUCTION_DETAIL.PAQH_ID", 'inner');
		$this->db->join('PRC_TENDER_VENDOR', "PRC_AUCTION_QUO_HEADER.PTM_NUMBER = PRC_TENDER_VENDOR.PTM_NUMBER AND PRC_AUCTION_DETAIL.PTV_VENDOR_CODE = PRC_TENDER_VENDOR.PTV_VENDOR_CODE", 'left');
	}

	public function getMinBid($paqh_id) {
		$this->db->select('PTV_VENDOR_CODE');
		$this->db->from($this->table.' t1');
		$this->db->join('(SELECT MIN(PAQD_FINAL_PRICE) MIN_PRICE FROM PRC_AUCTION_DETAIL WHERE PAQH_ID = '.$paqh_id.') T2','T1.PAQD_FINAL_PRICE = T2.MIN_PRICE','inner');
		// $this->db->where(array('PAQH_ID' => $paqh_id));
		$ans = $this->db->get()->row_array();
		// var_dump($this->db->last_query());
		return $ans;
	}

	public function getVendor($paqh_id){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->join_vnd();
		$this->db->where("PRC_AUCTION_DETAIL.PAQH_ID = '$paqh_id'");
		$this->db->order_by("PRC_AUCTION_DETAIL.PAQD_FINAL_PRICE","ASC");
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getVendorSingle($paqh_id, $vendor_no){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->join_vnd();
		$this->db->where("PRC_AUCTION_DETAIL.PAQH_ID = '$paqh_id'");
		$this->db->where("PRC_AUCTION_DETAIL.PTV_VENDOR_CODE = '$vendor_no'");
		$query = $this->db->get();
		return $query->row_array();

	}

	public function delete($where) {
		return $this->db->delete($this->table, $where);
	}

	public function where_paqh_id($id) {
		$this->db->where(array('PAQH_ID' => $id));
	}

}

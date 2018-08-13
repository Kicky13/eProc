<?php
class spb extends CI_Model {

	protected $table = 'SPB', $po_det = 'PO_ITEM_SPB';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function join_po_detail() {
		$this->db->select('PO_DETAIL.*');
		$this->db->join('PO_DETAIL', 'PO_DETAIL.PO_ID = PO_HEADER.PO_ID', 'right');
	}

	public function total_qty_spb($where = NULL) {
		$this->db->select_sum('QTY');
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->join('PO_ITEM_SPB', 'PO_ITEM_SPB.POD_ID = SPB.POD_ID', 'inner');
		$this->db->from($this->table);
		$result = $this->db->get();
		// echo $this->db->last_query();
		return $result->result_array();
		
	}

	public function join_po_detail2() {
		$this->db->select('PO_ITEM_SPB.*');
		$this->db->join('PO_ITEM_SPB', 'PO_ITEM_SPB.POD_ID = SPB.POD_ID', 'right');
	}

	public function join_po_header() {
		$this->db->select('PO_HEADER_SPB.*');
		$this->db->join('PO_HEADER_SPB', 'PO_HEADER_SPB.PO_ID = SPB.PO_ID', 'right');
	}

	public function get($where = NULL) {
		$this->db->select('SPB.*');
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		// echo $this->db->last_query();
		return $result->result_array();
	}


	public function getPoDetail($where = NULL) {
		$this->db->select('PO_ITEM_SPB.*');
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->po_det);
		$result = $this->db->get();
		// echo $this->db->last_query();
		return $result->result_array();
	}

	public function join_vnd() {
		$this->db->select('VND_HEADER.VENDOR_NAME, VND_HEADER.VENDOR_NO, VND_HEADER.VENDOR_ID');
		$this->db->join('VND_HEADER', "VND_HEADER.VENDOR_NO = SPB.VND_CODE", 'inner');
	}

	public function get_id() {
		$this->db->select_max('ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function update($set = NULl, $where = NULL) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function delete($id = NULL){
		$this->db->where('ID', $id);
		$this->db->delete($this->table);
	}
}
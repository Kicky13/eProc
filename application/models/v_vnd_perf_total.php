<?php defined('BASEPATH') OR exit('No direct script access allowed');

class v_vnd_perf_total extends CI_Model {

	protected $table = 'V_VND_PERF_TOTAL';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->select($this->table . '.*');
		$this->db->from($this->table);
		$result = $this->db->get();
		return (array)$result->result_array();
	}

	public function vnd($vnd_no) {
		return $this->get(array('VENDOR_CODE' => $vnd_no));
	}

	public function search($search) {
		$search = strtoupper($search);
		$wherelike = array();
		foreach (array('VENDOR_NO', 'VENDOR_NAME') as $field) {
			$wherelike[] = "UPPER($field) LIKE '%$search' OR UPPER($field) LIKE '%$search%' OR UPPER($field) LIKE '$search%'";
		}
		$wherelike = implode(' OR ', $wherelike);
		$this->db->where("($wherelike)", null, false);
	}

	public function join_vnd_header() {
		$this->db->select('VND_HEADER.VENDOR_NO, VND_HEADER.VENDOR_NAME');
		$this->db->join('VND_HEADER', "VND_HEADER.VENDOR_NO = $this->table.VENDOR_CODE", 'right');
	}

	public function join_all_field_vnd_header() {
		$this->db->select('VND_HEADER.*');
		$this->db->where(array('VND_HEADER.STATUS_ADJ' => 0));
		$this->db->join('VND_HEADER', "VND_HEADER.VENDOR_NO = $this->table.VENDOR_CODE", 'right');
	}

	public function join_po_header(){
		$this->db->select('PO_HEADER.PO_NUMBER, PO_HEADER.VND_CODE, PO_HEADER.VND_NAME');
		$this->db->join('PO_HEADER', "PO_HEADER.VND_CODE = $this->table.VENDOR_CODE", 'right');
	}

	public function join_category() {
		$this->db->select('TBLCAT.*');
		$this->db->join("VND_PERF_MST_CATEGORY TBLCAT", 'V_VND_PERF_TOTAL.TOTAL >= TBLCAT.START_POINT AND V_VND_PERF_TOTAL.TOTAL < TBLCAT.END_POINT', 'left', FALSE);
	}

	public function get_id() {
		$this->db->select_max($this->id, 'MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	public function update($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}

}
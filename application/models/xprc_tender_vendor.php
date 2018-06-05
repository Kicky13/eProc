<?php
class xprc_tender_vendor extends CI_Model
{
	protected $table = "PRC_TENDER_VENDOR";
	protected $table_vendor = "VND_HEADER";
	protected $table_ptm = "PRC_TENDER_MAIN";
	protected $table_ptp = "PRC_TENDER_PREP";

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where = NULL, $select = '*') {
		if ($select != '*') {
			$this->db->select($select);
		}
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$result = $this->db->get($this->table);
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return NULL;
		}
	}

	public function where_in($string, $array) {
		$this->db->where_in($string, $array);
	}

	public function find($ptv_id) {
		$ans = $this->get(array('PTV_ID' => $ptv_id));
		if (empty($ans)) {
			return null;
		}
		return $ans[0];
	}

	public function where_active($status = 2) {
		$this->db->where(array('PTV_STATUS >=' => $status));
	}

	public function has_rfq() {
		$this->db->where('PRC_TENDER_VENDOR.PTV_RFQ_NO IS NOT NULL', null, false);
	}

	public function where_tit_status($tit_status) {
		$this->join_pqm();
		$this->join_pqi_item();
		$this->db->where(array('PRC_TENDER_ITEM.TIT_STATUS' => $tit_status));
		$this->db->where(array('PRC_TENDER_QUO_ITEM.PQI_IS_WINNER' => 1));
		$this->db->distinct();
		// $this->db->select('PRC_TENDER_VENDOR.*, VND_HEADER.*');
	}

	public function where_nego() {

		return $this->where_tit_status(1);
	}

	public function join_nego($nego_done = false, $nego_done_not_in = false) {
		if ($nego_done !== false) {
			// $this->db->where('PRC_TENDER_NEGO.NEGO_DONE', $nego_done);
		}
		$wherenotin = '';
		if ($nego_done_not_in !== false) {
			// $this->db->where_not_in('PRC_TENDER_NEGO.NEGO_DONE', (array) $nego_done_not_in);
			$implotan = implode(", ", (array) $nego_done_not_in);
			$wherenotin = ' where PRC_TENDER_NEGO.NEGO_DONE NOT IN ('.$implotan.')';
		}
		// $this->db->select('PRC_TENDER_NEGO.*');
		return $this->db->join('(select * FROM PRC_TENDER_NEGO '.$wherenotin.') PRC_TENDER_NEGO', 'PRC_TENDER_NEGO.PTM_NUMBER = PRC_TENDER_VENDOR.PTM_NUMBER', 'left');
	}

	public function join_pqm() {
		$where = 'PRC_TENDER_VENDOR.PTV_VENDOR_CODE = PRC_TENDER_QUO_MAIN.PTV_VENDOR_CODE AND ';
		$where .= '"PRC_TENDER_VENDOR"."PTM_NUMBER" = "PRC_TENDER_QUO_MAIN"."PTM_NUMBER"';
		$this->db->join('PRC_TENDER_QUO_MAIN', $where, 'left');
	}

	public function join_pqi_item() {
		$this->db->join('PRC_TENDER_QUO_ITEM', 'PRC_TENDER_QUO_MAIN.PQM_ID = PRC_TENDER_QUO_ITEM.PQM_ID', 'left');
		$this->db->join('PRC_TENDER_ITEM', 'PRC_TENDER_ITEM.TIT_ID = PRC_TENDER_QUO_ITEM.TIT_ID', 'left');
	}

	public function join_vnd_header($type = 'LEFT') {
		$this->db->join($this->table_vendor, "$this->table_vendor.VENDOR_NO = $this->table.PTV_VENDOR_CODE",$type);
	}

	public function join_prc_tender_main() {
		$this->db->join($this->table_ptm, "$this->table_ptm.PTM_NUMBER = $this->table.PTM_NUMBER",'INNER');
	}

	public function join_prc_tender_prep() {
		$this->db->join($this->table_ptp, "$this->table_ptm.PTM_NUMBER = $this->table_ptp.PTM_NUMBER", 'INNER');
	}

	public function ptm($ptm) {
		return $this->get_join(array('PRC_TENDER_VENDOR.PTM_NUMBER' => $ptm));
	}

	public function ptv($ptv) {
		return $this->get_join(array('PRC_TENDER_VENDOR.PTV_VENDOR_CODE' => $ptv));
	}

	public function ptm_ptv($ptm, $ptv) {
		return $this->get_join(array('PRC_TENDER_VENDOR.PTM_NUMBER' => $ptm, 'PRC_TENDER_VENDOR.PTV_VENDOR_CODE' => $ptv));
	}

	public function get_join($where = NULL, $select = '*') {
		$this->join_vnd_header();
		return $this->get($where, $select);
	}

	public function where_status($status) {
		$this->db->where(array('PTV_STATUS' => $status));
	}


	public function where_ptv($ptv) {
		$this->db->where(array('PRC_TENDER_VENDOR.PTV_VENDOR_CODE' => $ptv));
	}

	public function where_ptv_is_nego($status = 1) {
		$this->db->where(array('PRC_TENDER_VENDOR.PTV_IS_NEGO' => $status));
	}

	public function get_id() {
		$this->db->select_max('PTV_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	public function insert_array($data) {
		return $this->db->insert($this->table, $data);
	}

	public function update($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function delete($where) {
		return $this->db->delete($this->table, $where);
	}
}
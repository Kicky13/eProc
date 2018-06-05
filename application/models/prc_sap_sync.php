<?php
class prc_sap_sync extends CI_Model {

	protected $table = 'PRC_SAP_SYNC';
	protected $all_field = 'PRC_SAP_SYNC.PRNO, PRC_SAP_SYNC.PRITEM, DOCTYPE, DOC_CAT, DEL, NOMAT, PLANT, DECMAT, QUANTOPEN, POQUANTITY, PRQUANTITY, HANDQUANTITY, RATAGI, MAXGI, LASTGI, UOM, REALDATE, POSTDATE, MAX_GI_YEAR, MAX_YEAR_GI, NETPRICE, PER, CURR, MATGROUP, PORG, REQUESTIONER';
	protected $item_field = 'PRC_SAP_SYNC.PRNO, PRC_SAP_SYNC.PRITEM, NOMAT, DECMAT, QUANTOPEN, POQUANTITY, PRQUANTITY, HANDQUANTITY, RATAGI, MAXGI, LASTGI, UOM, REALDATE, POSTDATE, MAX_GI_YEAR, MAX_YEAR_GI, NETPRICE, PER, CURR, MATGROUP';
	protected $pr_field = 'PRC_SAP_SYNC.PRNO, DOCTYPE, DOC_CAT, DEL, PLANT, PORG, REQUESTIONER';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=NULL, $select = false)
	{
		if (!$select) $select = $this->all_field;
		$this->db->select($select);
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return null;
		}
	}

	function join_ppv() {
		return $this->db->join('PRC_PR_VERIFY', 'PRC_PR_VERIFY.PPV_PRNO = PRC_SAP_SYNC.PRNO', 'left');
	}

	function join_log() {
		// return $this->db->join('APP_PROCESS_LOG', 'APP_PROCESS_LOG.PRNO = PRC_SAP_SYNC.PRNO AND APP_PROCESS_LOG.PRITEM = PRC_SAP_SYNC.PRITEM', 'left');
		return $this->db->join('(SELECT * FROM (SELECT APP_PROCESS_LOG.PROCESS_NAME, APP_PROCESS_LOG.PRNO, APP_PROCESS_LOG.PRITEM, APP_PROCESS_LOG.PTM_NUMBER, APP_PROCESS_LOG.PTV_VENDOR_CODE, APP_PROCESS_LOG.STATUS, ROW_NUMBER() OVER (PARTITION BY PRITEM, PRNO, PTM_NUMBER ORDER BY CREATED_DATE DESC) ROWNO FROM APP_PROCESS_LOG WHERE PROCESS_NAME=\'VERIFIKASI\') WHERE ROWNO = 1) APP_PROCESS_LOG', 'APP_PROCESS_LOG.PRNO = PRC_SAP_SYNC.PRNO AND "APP_PROCESS_LOG"."PRITEM" = "PRC_SAP_SYNC"."PRITEM"', 'left', FALSE);
	}

	function with_verify_status() {
		$this->join_ppv();
		$this->db->select('PPV_STATUS');
		$this->db->select('TO_CHAR(PPV_DATE, \'DD-MM-YYYY\') AS PPV_DATE', false);
	}

	function with_item_verify_status() {
		$this->join_log();
		// $this->db->where(array('APP_PROCESS_LOG.PROCESS_NAME' => 'VERIFIKASI'));
		$this->db->select('APP_PROCESS_LOG.PROCESS_NAME, APP_PROCESS_LOG.STATUS');
	}

	/* Nyari item, inputnya harus berformat array of [PRNO]:[PRITEM] */
	function get_all_by_pritem($items, $select = false) {
		if (!$select) $select = $this->all_field;
		$this->db->where_in('(PRNO||\':\'||PRITEM)', $items, false);
		return $this->get(false, $select);
	}

	function get_items_by_pritem($items) {
		return $this->get_all_by_pritem($items, $this->item_field);
	}

	/* filter PR dengan status verifikasi tertetu */
	function where_verified($status = 1) {
		$this->with_verify_status();
		$this->db->where(array('PPV_STATUS' => $status));
	}

	function where_not_verified() {
		$this->where_verified(null);
	}

	function get_list_pr() {
		$this->db->distinct();
		$this->db->select($this->pr_field);
		$this->db->from($this->table);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return null;
		}
	}

	function pr($prno, $select = false) {
		return $this->get(array('PRC_SAP_SYNC.PRNO' => $prno), $select);
	}

	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	function insert_batch($data)
	{
		// echo "<pre>";
		// print_r($data);die;
		$this->db->insert_batch($this->table, $data);
	}

	function delete($where = null) {
		if ($where != null) {
			$this->db->where($where);
			return $this->db->delete($this->table);
		} else {
			return $this->db->empty_table($this->table);
		}
	}

	function update($set, $where)
	{
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

}
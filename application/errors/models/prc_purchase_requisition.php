<?php class prc_purchase_requisition extends CI_Model {

	protected $table = 'PRC_PURCHASE_REQUISITION';
	protected $all_field = 'PPR_PRNO, PPR_DOCTYPE, PPR_DOC_CAT, PPR_DEL, PPR_PLANT, PPR_PORG, PPR_REQUESTIONER, PPR_STTVER, PPR_STT_TOR, PPR_STT_CLOSE, PPR_DATE_RELEASE, PPR_LAST_UPDATE, PPR_PGRP, PPR_ASSIGNEE, PPI_TGL_ASSIGN, PPI_PR_ASSIGN_TO, DOC_UPLOAD_COUNTER,DOC_UPLOAD_DATE';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=NULL, $select = false, $statu = true) {
		if ($statu) {
			$this->where_has_item_n();
		}
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

	public function where_has_item_n() {
		$where = "(select count(PPI_ID) from PRC_PR_ITEM where PPI_PRNO = PPR_PRNO and STATU = 'N') > 0";
		$this->db->where($where, null, false);
	}

	function pr($pr) {
		$this->db->select('ADM_CCTR.LONG_DESC');
		$this->db->join('ADM_CCTR', 'ADM_CCTR.CCTR = PRC_PURCHASE_REQUISITION.PPR_REQUESTIONER', 'left');
		$result = $this->get(array('PPR_PRNO' => $pr), false, false);
		return $result[0];
	}

	function join_ppv() {
		return $this->db->join('PRC_PR_VERIFY', 'PRC_PR_VERIFY.PPV_PRNO = PRC_PURCHASE_REQUISITION.PPR_PRNO', 'left');
	}

	public function with_assignee() {
		$this->db->select('ADM_EMPLOYEE.FULLNAME');
		$this->db->join('ADM_EMPLOYEE', 'ADM_EMPLOYEE.ID = PRC_PURCHASE_REQUISITION.PPR_ASSIGNEE', 'left');
	}

	public function with_requestioner() {
		$this->db->join('(SELECT)');
	}

	function join_log() {
		// return $this->db->join('APP_PROCESS_LOG', 'APP_PROCESS_LOG.PRNO = PRC_PURCHASE_REQUISITION.PRNO AND APP_PROCESS_LOG.PRITEM = PRC_SAP_SYNC.PRITEM', 'left');
		return $this->db->join('(SELECT * FROM (SELECT APP_PROCESS_LOG.PROCESS_NAME, APP_PROCESS_LOG.PRNO, APP_PROCESS_LOG.PRITEM, APP_PROCESS_LOG.PTM_NUMBER, APP_PROCESS_LOG.PTV_VENDOR_CODE, APP_PROCESS_LOG.STATUS, ROW_NUMBER() OVER (PARTITION BY PRITEM, PRNO, PTM_NUMBER ORDER BY CREATED_DATE DESC) ROWNO FROM APP_PROCESS_LOG WHERE PROCESS_NAME=\'VERIFIKASI\') WHERE ROWNO = 1) APP_PROCESS_LOG', 'APP_PROCESS_LOG.PRNO = PRC_SAP_SYNC.PRNO AND "APP_PROCESS_LOG"."PRITEM" = "PRC_SAP_SYNC"."PRITEM"', 'left', FALSE);
	}

	/* Nyari item, inputnya harus berformat array of [PRNO]:[PRITEM] */
	function get_all_by_pritem($items, $select = false) {
		if (!$select) $select = $this->all_field;
		$this->db->where_in('(PRNO||\':\'||PRITEM)', $items, false);
		return $this->get(false, $select);
	}

	/* filter PR dengan status verifikasi tertetu */
	function where_verified($status = 1) {
		$this->db->where(array('PPR_STTVER' => $status));
	}

	function where_assignee($assignee) {
		$this->db->where(array('PPI_PR_ASSIGN_TO' => $assignee));
	}

	function where_not_verified() {
		$this->where_verified(0);
	}

	function where_not_closed($status = 0) {
		$this->db->where(array('PPR_STT_CLOSE' => $status));
	}

	function where_company_id($opco) {
		$this->db->where('PPR_PLANT >=', $opco);
		$this->db->where('PPR_PLANT <=', $opco + 999);
	}

	function get_id()
	{
		$this->db->select_max('PPR_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function insert($data)
	{
		$data['PPR_ID'] = $this->get_id();
		$this->db->insert($this->table, $data);
	}

	function insert_or_update($data) {
		$this->db->select('PPR_ID');
		$where = array('PPR_PRNO' => $data['PPR_PRNO']);
		$this->db->where($where);
		$this->db->from($this->table);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			$this->update($data, $where);
		} else {
			$this->insert($data);
		}
	}

	function update($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function for_print($pr){
		$where = "(select count(PPI_ID) from PRC_PR_ITEM where PPI_PRNO = PPR_PRNO) > 0";
		$select = $this->all_field;
		$this->db->select($select);
		$this->db->where($where);
		$this->db->where(array('PPR_PRNO' => $pr));
		$this->db->from($this->table);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return null;
		}
	}

}
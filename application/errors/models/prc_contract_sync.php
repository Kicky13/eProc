<?php

/**
 * Detail field and description: 
 *      EBELN		Purchasing Document Number
 *      BUKRS		Company Code
 *      BSTYP		Purchasing Document Category
 *      BSART		Purchasing Document Type
 *      LOEKZ		Deletion Indicator in Purchasing Document
 *      STATU		Status of Purchasing Document
 *      ERNAM		Name of Person who Created the Object
 *      LIFNR		Vendor Account Number
 *      EKORG		Purchasing Organization
 *      EKGRP		Purchasing Group
 *      WAERS		Currency Key
 *      WKURS		Exchange Rate
 *      BEDAT		Purchasing Document Date
 *      KDATB		Start of Validity Period
 *      KDATE		End of Validity Period
 *      PROCSTAT	Purchasing document processing state
 *      FRGKE		Release Indicator: Purchasing Document
 *      EBELP		Item Number of Purchasing Document
 *      TXZ01		Short Text
 *      MATNR		Material Number
 *      MAKTX		Material Description (Short Text)
 *      WERKS		Plant for individual capacity
 *      KTMNG		Target Quantity
 *      MENGE		Purchase Order Quantity
 *      MEINS		Purchase Order Unit of Measure
 *      NETPR		Net Price in Purchasing Document (in Document Currency)
 *      PEINH		Price Unit
 *      NETWR		Net Order Value in PO Currency
 *      BRTWR		Gross order value in PO currency
 *      NAME1		Vendor name
 */
class prc_contract_sync extends CI_Model {

	protected $table = 'PRC_CONTRACT_SYNC';
	protected $all_field = 'EBELN, BUKRS, BSTYP, BSART, LOEKZ, STATU, ERNAM, LIFNR, EKORG, EKGRP, WAERS, WKURS, BEDAT, KDATB, KDATE, PROCSTAT, FRGKE, EBELP, TXZ01, MATNR, MAKTX, WERKS, KTMNG, MENGE, MEINS, NETPR, PEINH, NETWR, BRTWR, NAME1';

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

	function where_matnr($MATNR = null){
		$this->db->where(array('MATNR' => $MATNR));
	}

	function where_lifnr($LIFNR = null){
		$this->db->where(array('LIFNR' => $LIFNR));
	}

	function where_werks($WERKS = null){
		$this->db->where(array('WERKS' => $WERKS));
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
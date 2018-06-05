<?php
class po_header extends CI_Model {

	protected $table = 'PO_HEADER';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function join_po_detail() {
		$this->db->select('PO_DETAIL.*');
		$this->db->join('PO_DETAIL', 'PO_DETAIL.PO_ID = PO_HEADER.PO_ID', 'right');
	}

	public function get($where = NULL) {
		$this->db->select('PO_HEADER.*');
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		// echo $this->db->last_query();
		return $result->result_array();
	}

	public function join_vnd() {
		$this->db->select('VND_HEADER.VENDOR_NAME, VND_HEADER.VENDOR_NO, VND_HEADER.VENDOR_ID');
		$this->db->join('VND_HEADER', "VND_HEADER.VENDOR_NO = PO_HEADER.VND_CODE", 'inner');
	}

	public function join_employee() {
		$this->db->select('ADM_EMPLOYEE.FULLNAME');
		$this->db->join('ADM_EMPLOYEE', "ADM_EMPLOYEE.ID = PO_HEADER.PO_CREATED_BY", 'inner');
	}

	public function get_po($whereopco) {
		$this->db->select('VND_HEADER.VENDOR_NAME, VND_HEADER.VENDOR_NO, VND_HEADER.VENDOR_ID, VND_HEADER.COMPANYID, PO_HEADER.* FROM PO_HEADER INNER JOIN VND_HEADER ON VND_HEADER.VENDOR_NO = PO_HEADER.VND_CODE WHERE VND_HEADER.COMPANYID '.$whereopco.'', false);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function where_approve() {
		$this->db->where(array('IS_APPROVE' => "0"));
	}

	public function where_po($id) {
		$this->db->where(array('PO_ID' => $id));
	}

	public function where_ponumber($id = null){
		$this->db->where(array('PO_NUMBER' => $id));
	}

	public function where_lp3number($nolp3){
		$this->db->where(array('LP3_NUMBER'=>$nolp3));
	}

	public function where_pgrp($id){
		$this->db->where(array('PGRP' => $id));
	}

	public function where_vndcode($id = null){
		$this->db->where(array('VND_CODE' => $id));
	}

	public function where_link($link){
		$this->db->where(array('LINK' => $link));
	}

	public function where_vndname($id) {
		$id = strtoupper($id);
		$this->db->where('("VND_NAME" like '. "'$id%'".' OR '.'"VND_NAME" like '. "'%$id'".' OR '.'"VND_NAME" like '. "'%$id%')", null, false);
	}

	public function where_release($data = null) {
		if($data == null){
			$this->db->where("PO_HEADER.RELEASE != REAL_STAT", null,false);
		} else {
			$this->db->where("PO_HEADER.RELEASE = REAL_STAT", null,false);
		}
	}

	public function get_id() {
		$this->db->select_max('PO_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	public function get_max_lp3_no(){
		$this->db->select_max('PO_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		$po_header = $this->get(array('PO_ID'=>$max['MAX']));
		return $po_header[0]['LP3_NUMBER'];
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function insert_batch($data) {
		$this->db->insert_batch($this->table, $data);
	}

	public function update($set = NULl, $where = NULL) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function delete($id = NULL){
		$this->db->where('PO_ID', $id);
		$this->db->delete($this->table);
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

	public function get_status($status){
		$status_name = array(
				0 => "Waiting Approval", // Normal
				1 => "Approved", // Tahap_Negosiasi				
				2 => "Rejected",
				3 => "Renego", // Tahap_Negosiasi
				4 => "Retender", // Auction
				5 => "Canceled", // Auction
				);
		return $status_name[$status];
	}

	public function join_ptm($ptm) {
		$this->db->join('PRC_TENDER_MAIN', "PRC_TENDER_MAIN.PTM_NUMBER = PO_HEADER.PTM_NUMBER", 'inner');
		$this->db->where("PO_HEADER.PTM_NUMBER", $ptm);
	}

	public function join_ptm_lp3() {
		$this->db->select('PTM_PRATENDER');
		$this->db->join('PRC_TENDER_MAIN', "PRC_TENDER_MAIN.PTM_NUMBER = PO_HEADER.PTM_NUMBER", 'left');
	}

	public function where_pratender($pratender){
		$this->db->where(array('PTM_PRATENDER'=>$pratender));
	}

	public function join_nyo() {
		$this->db->select('PO_DETAIL.*');
		$this->db->join('PO_DETAIL', 'PO_DETAIL.PO_ID = PO_HEADER.PO_ID', 'right');
	}
	public function join_tit($ptm) {
		$this->db->select('PRC_TENDER_ITEM.TIT_ID, PRC_TENDER_ITEM.PTM_NUMBER,PRC_TENDER_ITEM.PPI_ID AS PPI_ID1');
		$this->db->join('PRC_TENDER_ITEM', "PRC_TENDER_ITEM.PTM_NUMBER = PO_HEADER.PTM_NUMBER", 'inner');
		$this->db->where("PO_HEADER.PTM_NUMBER", $ptm);
	}

	public function join_ppi() {
		$this->db->select('PRC_PR_ITEM.PPI_ID, PRC_PR_ITEM.PPI_PER');
		$this->db->join('PRC_PR_ITEM', "PRC_PR_ITEM.PPI_ID = PO_DETAIL.PPI_ID", 'inner');
	}

	//thithe tambah fungsi amabil data tanggal dan header text 12 oktober 2017
	public function getDetailPo($PO_ID)
	{
		$SQL = "
		SELECT
		TO_CHAR (DDATE, 'YYYY-MM-DD') AS NEWDDATE,
		TO_CHAR (DOC_DATE, 'YYYY-MM-DD') AS NEWDOC_DATE,
		HEADER_TEXT
		FROM
		PO_HEADER
		WHERE
		PO_ID = ".$PO_ID."
		";
		$result = $this -> db -> query($SQL);
		return $result -> row_array();
	}

	//thithe tambah fungsi save data tanggal dan header text 12 oktober 2017
	public function updateDetailPo($data) {
		$this -> db -> set('DOC_DATE', "TO_DATE('" . $data['DOC_DATE'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('DDATE', "TO_DATE('" . $data['DDATE'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('HEADER_TEXT', "'".$data['HEADER_TEXT']."'", FALSE);
		$this -> db -> where('PO_ID', $data['PO_ID']);
		$this -> db -> update('PO_HEADER');
	}

}
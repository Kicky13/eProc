<?php

class prc_pr_item extends CI_Model {

	protected $table = 'PRC_PR_ITEM';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL, $select = '*', $contract = -1, $statu = true) {
		// if ($statu) {
		// 	$this->db->where('STATU', 'N');
		// }
		if ($select != null) {
			$this->db->select($select);
		}
		if (!empty($where)) {
			$this->db->where($where);
		}
		if ($contract != -1) {
			$this->db->where(array('PPI_IS_CONTRACT' => $contract));
		}
		$this->db->from($this->table);
		$this->db->order_by('PPI_PRNO', 'ASC');
		$this->db->order_by('PPI_PRITEM', 'ASC');
		$result = $this->db->get();
		// echo $this->db->last_query(); die;
		return $result->result_array();
	}

	public function join_pr_service() {
		$this->db->join('PRC_IT_SERVICE', 'PRC_PR_ITEM.PPI_PACKNO = PRC_IT_SERVICE.PACKNO', 'left');
	}


	function join_pr() {
		$this->db->join('PRC_PURCHASE_REQUISITION', 'PRC_PURCHASE_REQUISITION.PPR_PRNO = PRC_PR_ITEM.PPI_PRNO', 'left');
	}

	function join_group_plant() {
		$this->db->join('COM_MAT_GROUP', 'COM_MAT_GROUP.MAT_GROUP_CODE = PRC_PR_ITEM.PPI_MATGROUP', 'inner');
		$this->db->join('ADM_PLANT', 'ADM_PLANT.PLANT_CODE = PRC_PURCHASE_REQUISITION.PPR_PLANT', 'inner');
	} 

	public function where($key, $value) {
		$this->db->where($key, $value);
	}

	// function join_pr_verify() {
	// 	return $this->db->join('PRC_PR_VERIFY', 'PRC_PR_VERIFY.PPV_PRNO = PRC_PR_ITEM.PPI_PRNO', 'left');
	// }

	public function distinct() {
		$this->db->distinct();
	}

	function pr($ptm, $select = '*', $contract = -1) {
		return $this->get(array('PPI_PRNO' => $ptm), $select, $contract);
	}

	function where_assignee($assignee) {
		$this->db->where(array('PRC_PURCHASE_REQUISITION.PPI_PR_ASSIGN_TO' => $assignee));
	}

	/* filter PR dengan status verifikasi tertetu */
	function where_verified($status = 1) {
		$this->db->where(array('PPR_STTVER' => $status));
	}

	function where_not_verified() {
		$this->where_verified(0);
	}

	function where_company_id($opco) {
		$this->db->where('PPR_PLANT >=', $opco);
		$this->db->where('PPR_PLANT <=', $opco + 999);
	}

	function where_contract($contract) {
		$this->db->where(array('PPI_IS_CONTRACT' => $contract));
	}

	function where_not_closed($status = 0) {
		$this->db->where(array('PPR_STT_CLOSE' => $status));
		$this->db->where(array('PPI_IS_CLOSED' => $status));
	}

	function where_available() {
		$this->db->where('PPI_QUANTOPEN > PPI_QTY_USED');
	}

	function where_qty($number = 0) {
		$this->db->where('PPI_PRQUANTITY >', $number);
	}

	function where_id($id) {
		$this->db->where('PPI_ID =', $id );
	}

	/**
	 * @param String "'221','222'" | Array of PGRP
	 */
	public function where_pgrp_in($pgrp) {
		if (is_array($pgrp)) {
			$this->db->where("PPR_PGRP IN ('" .implode("', '", $pgrp). "')", null, false);
		} else if (is_string($pgrp)) {
			$this->db->where("PPR_PGRP IN ($pgrp)");
		}
	}

	function where_jasa() {
		$this->db->where('PRC_PURCHASE_REQUISITION.PPR_DOC_CAT', 9);
	}

	function where_barang() {
		$this->db->where('PRC_PURCHASE_REQUISITION.PPR_DOC_CAT !=', 9);
	}

	function get_id()
	{
		$this->db->select_max('PPI_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	function update($set, $where)
	{
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	function where_ppiId($id){
		$this->db->where('PPI_ID =', $id );
		return $this->db->get($this->table)->result_array;
	}

	function join_plant() { 
		$this->db->join('ADM_PLANT', 'ADM_PLANT.PLANT_CODE = PRC_PR_ITEM.PPI_PLANT', 'left');
	}

	public function get_dashboard_pr(){
		$query1="PPI.PPI_ID,PPI.PPI_PRITEM,AC.COMPANYNAME,PPR.PPR_PGRP,APG.KEL_PURCH_GRP,PPR.PPR_DATE_RELEASE,
		PPR.DOC_UPLOAD_DATE,PTI.PTM_NUMBER,PTM.PTM_SUBPRATENDER,
		PTP.PTP_REG_CLOSING_DATE,PTP.PTP_REG_OPENING_DATE,KONF.KONFIGURASI_DATE,APRV.RFQ_CREATED,
		EVT.EVATEK_APPROVE,EVK.EVATEK,PTI.WIN_AT,PO.PO_CREATED_AT,PO.RELEASED_AT,PTM.PTM_PRATENDER,PPR.PPR_PRNO,PPI.PPI_NOMAT,PPI.PPI_DECMAT";
		$query2="select PTM_NUMBER,PTC_END_DATE as KONFIGURASI_DATE from prc_tender_comment where PTC_ACTIVITY='Approval Perencanaan'";
		$query3="select PTM_NUMBER,PTC_END_DATE as RFQ_CREATED from prc_tender_comment where PTC_ACTIVITY='Approval Pengadaan'";
		$query4="select PTM_NUMBER,PTC_END_DATE as EVATEK_APPROVE from prc_tender_comment where PTC_ACTIVITY='Approval Pengajuan Evaluasi Teknis'";
		$query5="select PTM_NUMBER,PTC_END_DATE as EVATEK from prc_tender_comment where PTC_ACTIVITY='Evaluasi Teknis'";
		$query6="select PO.PPI_ID,PH.PO_ID,PH.PO_CREATED_AT,PH.RELEASED_AT from PO_DETAIL PO inner join PO_HEADER PH ON PH.PO_ID=PO.PO_ID";

		$this->db->select($query1);
		$this->db->join('PRC_TENDER_ITEM PTI','PTI.PPI_ID = PPI.PPI_ID','left');
		$this->db->join('PRC_TENDER_MAIN PTM', 'PTM.PTM_NUMBER = PTI.PTM_NUMBER','left');
		$this->db->join('PRC_TENDER_PREP PTP', 'PTP.PTM_NUMBER = PTM.PTM_NUMBER','left');

		$this->db->join('('.$query2.') KONF', 'KONF.PTM_NUMBER=PTM.PTM_NUMBER','left');
		$this->db->join('('.$query3.') APRV', 'APRV.PTM_NUMBER=PTM.PTM_NUMBER','left');
		$this->db->join('('.$query4.') EVT', 'EVT.PTM_NUMBER=PTM.PTM_NUMBER','left');
		$this->db->join('('.$query5.') EVK', 'EVK.PTM_NUMBER=PTM.PTM_NUMBER','left');
		$this->db->join('('.$query6.') PO', 'PO.PPI_ID = PPI.PPI_ID','left');

		$this->db->join('PRC_PURCHASE_REQUISITION PPR','PPR.PPR_PRNO = PPI.PPI_PRNO','left');
		$this->db->join('ADM_PURCH_GRP APG','APG.PURCH_GRP_CODE = PPR.PPR_PGRP','inner');
		$this->db->join('ADM_COMPANY AC', 'AC.COMPANYID = APG.COMPANY_ID','left');

		$this->db->from($this->table." PPI");
		$this->db->order_by('PPI_PRITEM', 'ASC');
		return $this->db->_compile_select();
		//$result = $this->db->get();
		
		//return $result->result_array();
	}

}
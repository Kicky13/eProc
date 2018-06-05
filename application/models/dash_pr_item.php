<?php

class dash_pr_item extends CI_Model {

	protected $table = 'DASH_PR_ITEM';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	public function empty_table() {		
		return $this->db->empty_table($this->table);
	}

	public function auto_insert($query){
		$this->db->query("insert into ".$this->table." ".$query);
	}

	public function get_list_item($filter){
		$this->db->select("*");
		$this->db->from($this->table);
		if($filter&&isset($filter)&&is_array($filter)){
			foreach ($filter as $key => $value) {
				if(isset($value)){
					if(is_array($value)){
						$this->db->where_in($key,$value);
					}else{
						$this->db->where($key,$value);
					}
				}
			}
		}
		// return $this->db->_compile_select();

		$res = $this->db->get();
		return $res->result_array();
	}


	public function get_leadtime(){
		$query="KEL_PURCH_GRP,PPR_PGRP,PPR_DATE_RELEASE,
				extract(day from (CAST(DOC_UPLOAD_DATE as timestamp)-CAST(PPR_DATE_RELEASE as timestamp))) day_upload, 
				extract(day from (CAST(RFQ_CREATED as timestamp)-CAST(DOC_UPLOAD_DATE as timestamp))) day_konfig,
				extract(day from (CAST((case when(PTP_REG_OPENING_DATE>RFQ_CREATED) then PTP_REG_OPENING_DATE else RFQ_CREATED end) as timestamp)-CAST(KONFIGURASI_DATE as timestamp))) day_rfq,
				extract(day from (CAST(PTP_REG_CLOSING_DATE as timestamp)-CAST((case when(PTP_REG_OPENING_DATE>RFQ_CREATED) then PTP_REG_OPENING_DATE else RFQ_CREATED end) as timestamp))) day_rfq_close,
				extract(day from (CAST(PTP_REG_CLOSING_DATE as timestamp)-CAST(EVATEK_APPROVE as timestamp))) day_evatek_aprv,
				extract(day from (CAST(EVATEK as timestamp)-CAST(EVATEK_APPROVE as timestamp))) day_evatek,
				extract(day from (CAST(WIN_AT as timestamp)-CAST(EVATEK as timestamp))) day_nego,
				extract(day from (CAST(PO_CREATED_AT as timestamp)-CAST(WIN_AT as timestamp))) day_po,
				extract(day from (CAST(RELEASED_AT as timestamp)-CAST(PO_CREATED_AT as timestamp))) day_po_release";
		$this->db->select($query);
		$this->db->from($this->table);
		return $this->db->_compile_select();
	}

	public function get_performance($filter=array()){
		$where = '';
		if($filter&&isset($filter)&&is_array($filter)){
			foreach ($filter as $key => $value) {
				if(isset($value)){
					if(is_array($value)&&count($value)>0){
						$values = '';
						foreach ($value as $val) {
							$values .=','.(($key=='KEL_PURCH_GRP')?$val:"'".$val."'");
						}
						$where.=" and ". $key." in (".substr($values, 1,strlen($values)).")";
					}else{
						$where.=" and ". $key." = ".$value;
					}
				}
			}
		}
		$query_filter = "SELECT PPR_PRNO FROM DASH_PR_ITEM ".(($where!='')?'WHERE ':'').substr($where, 4,strlen($where));

		$select="SUB_SUBMIT,TOTAL_SUBMIT,SUB_SUBPRATENDER,TOTAL_SUBPRATENDER,SUB_PRATENDER,TOTAL_PRATENDER,
SUB_QUOT_DEADLINE,TOTAL_QUOT_DEADLINE,SUB_EVATEK_APPROVE,TOTAL_EVATEK_APPROVE,SUB_EVATEK,TOTAL_EVATEK,
SUB_NEGO, TOTAL_NEGO, SUB_PO_CREATED, TOTAL_PO_CREATED, SUB_PO_RELEASED, TOTAL_PO_RELEASED";
		$q_submit="(select count(DISTINCT DPI.PPR_PRNO) as sub_submit, count(DPI.PPR_PRNO) as total_submit from DASH_PR_ITEM DPI inner join (".$query_filter.") f ON f.PPR_PRNO=DPI.PPR_PRNO where DOC_UPLOAD_DATE is not null)";
		$q_subpratender="(select count(DISTINCT PTM_SUBPRATENDER) as sub_subpratender, count(PTM_SUBPRATENDER) as total_subpratender from DASH_PR_ITEM DPI inner join (".$query_filter.") f ON f.PPR_PRNO=DPI.PPR_PRNO where PPI_ID is not null and PTM_SUBPRATENDER is not null)";
		$q_pratender="(select count(DISTINCT PTM_PRATENDER) as sub_pratender,count(PTM_PRATENDER) as total_pratender from DASH_PR_ITEM DPI inner join (".$query_filter.") f ON f.PPR_PRNO=DPI.PPR_PRNO where PPI_ID is not null and PTM_PRATENDER is not null)";
		$q_quot_deadline="(select count(DISTINCT PTP_REG_CLOSING_DATE) as sub_quot_deadline,count(PTP_REG_CLOSING_DATE) as total_quot_deadline from DASH_PR_ITEM DPI inner join (".$query_filter.") f ON f.PPR_PRNO=DPI.PPR_PRNO where PPI_ID is not null and PTM_PRATENDER is not null)";
		$q_evatek_approve="(select count(DISTINCT EVATEK_APPROVE) as sub_evatek_approve,count(EVATEK_APPROVE) as total_evatek_approve from DASH_PR_ITEM DPI inner join (".$query_filter.") f ON f.PPR_PRNO=DPI.PPR_PRNO where PPI_ID is not null)";
		$q_evatek="(select count(DISTINCT EVATEK) as sub_evatek,count(EVATEK) as total_evatek from DASH_PR_ITEM DPI inner join (".$query_filter.") f ON f.PPR_PRNO=DPI.PPR_PRNO where PPI_ID is not null)";
		$q_nego="(select count(DISTINCT WIN_AT) as sub_nego,count(WIN_AT) as total_nego from DASH_PR_ITEM DPI inner join (".$query_filter.") f ON f.PPR_PRNO=DPI.PPR_PRNO where PPI_ID is not null and WIN_AT is not null)";
		$q_po_created="(select count(DISTINCT PO_CREATED_AT) as sub_po_created,count(PO_CREATED_AT) as total_po_created from DASH_PR_ITEM DPI inner join (".$query_filter.") f ON f.PPR_PRNO=DPI.PPR_PRNO where PPI_ID is not null and PO_CREATED_AT is not null)";
		$q_po_released="(select count(DISTINCT RELEASED_AT) as sub_po_released,count(RELEASED_AT) as total_po_released from DASH_PR_ITEM DPI inner join (".$query_filter.") f ON f.PPR_PRNO=DPI.PPR_PRNO where PPI_ID is not null and PO_CREATED_AT is not null and RELEASED_AT is not null)";
		
		$query = "SELECT ".$select." FROM ".$q_submit.','.$q_subpratender.','.$q_pratender.','.$q_quot_deadline.
		','.$q_evatek_approve.','.$q_evatek.','.$q_nego.','.$q_po_created.','.$q_po_released;
		// return $query;
		$res = $this->db->query($query);
		//$this->db->select($select);
		//$this->db->from(array($q_submit,$q_subpratender,$q_pratender,$q_quot_deadline,$q_evatek_approve,$q_evatek,$q_nego,$q_po_created,$q_po_released));
		//return $this->db->_compile_select();
		// $res = $this->db->get();		
		return $res->result_array();
	} 

	
}
?>
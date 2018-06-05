<?php 

class prc_pr_verify extends CI_Model {

	protected $table = 'PRC_PR_VERIFY';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=NULL, $select = '*')
	{
		$this->db->select($select);
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$this->db->order_by('PPV_DATE', 'DESC');
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return null;
		}
	}

	public function join_item_verify()
	{
		$this->db->join('PRC_ITEM_VERIFY', 'PRC_ITEM_VERIFY.PPV_ID = PRC_PR_VERIFY.PPV_ID', 'inner');
	}

	public function join_pucrh_group()
	{	
		$this->db->select('ADM_PURCH_GRP.COMPANY_ID');
		$this->db->join('PRC_PURCHASE_REQUISITION', 'PRC_PURCHASE_REQUISITION.PPR_PRNO = PRC_PR_VERIFY.PPV_PRNO', 'inner');
		$this->db->join('ADM_PURCH_GRP', 'ADM_PURCH_GRP.PURCH_GRP_CODE = PRC_PURCHASE_REQUISITION.PPR_PGRP', 'inner');
	}

	function pr($pr, $select = '*') {
		return $this->get(array('PPV_PRNO' => $pr), $select);
		  
	}

	function ppv_id($pr, $select = '*') {
		return $this->get(array('PPV_ID' => $pr), $select);
	}

	public function where_ppvstatus($id) {
		$this->db->where(array('PPV_STATUS' => $id));
	}

	public function where_opco($new_opco) {
		$this->db->where('ADM_PURCH_GRP.COMPANY_ID IN ('.$new_opco.')');
	}

	function get_prReject($val) {
		$this->db->distinct();
		$select = 'PRC_PR_VERIFY.* ';
		return $this->get(array('PRC_ITEM_VERIFY.PIV_IS_ITEM' => $val), $select);		  
	}

	public function where_item_rejected() {
		$this->db->where(array('PRC_ITEM_VERIFY.PIV_IS_DOC' => 1));
	}

	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	function insert_or_update($data) {
		$this->db->select('PPV_PRNO');
		$where = array('PPV_PRNO' => $data['PPV_PRNO']);
		$this->db->where($where);
		$this->db->from($this->table);
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			$this->update($data, $where);
		} else {
			$this->insert($data);
		}
		
		//echo $this->db->last_query(); die();
	}

	function get_id()
	{
		$this->db->select_max('PPV_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function update($set, $where)
	{
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

}
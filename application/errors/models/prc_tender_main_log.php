<?php
class prc_tender_main_log extends CI_Model
{
	var $get_id_query = 'select max(PTM_NUMBER) as id from PRC_TENDER_MAIN_LOG';
	protected $table = 'PRC_TENDER_MAIN_LOG';
	protected $all_field = 'PRC_TENDER_MAIN.PTM_NUMBER, PTM_REQUESTER_NAME, TO_CHAR(PTM_CREATED_DATE, \'DD-MM-YYYY\') AS PTM_CREATED_DATE, PTM_SUBJECT_OF_WORK, PTM_STATUS, TO_CHAR(PTM_COMPLETED_DATE, \'DD-MM-YYYY\') AS PTM_COMPLETED_DATE, PTM_DEPT_NAME, PROCESS_NAME, PTM_SUBPRATENDER, PTM_PRATENDER, PTM_COUNT_RETENDER, PTM_RFQ_TYPE, PTM_REQUESTER_ID, PTM_COMPANY_ID, PTM_PGRP';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=NULL, $select = false, $role = NULL)
	{
		if (!$select) $select = $this->all_field;
		$this->db->select($select, false);
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->order_by('PTM_CREATED_DATE', 'desc');
		$this->db->from($this->table);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return null;
		}
	}

	function get_active_job($role = NULL) {
		$this->db->where('PTM_STATUS >', '0');
		return $this->get(null, false, $role);
	}

	function ptm($ptm) {
		return $this->get(array('PTM_NUMBER' => $ptm));
	}

	function get_id()
	{
		$result = $this->db->query($this->get_id_query);
		$id = $result->row_array();
		return $id['ID'] + 1;
	}

	function insert($data) {
		return $this->db->insert($this->table, $data);
	}

	function update($set,$where) {
		$this->db->where($where);
		return $this->db->update($this->table, $where);
	}

}
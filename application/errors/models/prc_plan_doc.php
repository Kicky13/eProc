<?php
class prc_plan_doc extends CI_Model
{
	protected $table = 'PRC_PLAN_DOC';
	protected $all_field = 'PPD_ID, PPD_PRNO, PPD_CATEGORY, PPD_DESCRIPTION, PPD_FILE_NAME, TO_CHAR(PPD_CREATED_AT, \'DD-MON-YY HH12.MI PM\') AS PPD_CREATED_AT, PPD_CREATED_BY, PPD_STATUS, PRC_PLAN_DOC.PPI_ID, IS_SHARE';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where = null)
	{
		$this->db->select($this->all_field, false);
		if($where != null) {
			$this->db->where($where);
		}
		$this->join_category();
		// $this->db->order_by('PPD_CATEGORY', 'desc');
		$this->db->order_by('PRC_PLAN_DOC.PPI_ID', 'desc');
		$result = $this->db->get($this->table);
		return $result->result_array();
	}

	function join_category() {
		$this->db->join('PRC_DOC_CATEGORY', 'PRC_PLAN_DOC.PPD_CATEGORY = PRC_DOC_CATEGORY.PDC_ID', 'inner');
		$this->db->select('PDC_ID, PDC_NAME, PDC_IS_PRIVATE');
	}

	public function where_privacy($privacy = 0) {
		$this->db->where(array('PDC_IS_PRIVATE' => $privacy));
		$this->db->where(array('IS_SHARE' => 1));
	}

	public function where_active($active = 1) {
		$this->db->where(array('PPD_STATUS' => $active));
	}

	function pr($pr) {
		return $this->get(array('PPD_PRNO' => $pr));
	}

	function pritem($ppiid) {
		return $this->get(array('PRC_PLAN_DOC.PPI_ID' => $ppiid));
	}

	function join_pr_item() {
		$this->db->select('PPI_NOMAT, PPI_DECMAT');
		$this->db->join('PRC_PR_ITEM', 'PRC_PR_ITEM.PPI_ID = PRC_PLAN_DOC.PPI_ID', 'inner');
	}

	function insert($data) {
		return $this->db->insert($this->table, $data);
	}

	function get_id()
	{
		$this->db->select_max('PPD_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function get_category() {
		$this->db->select('*');
		return $this->db->get('PRC_DOC_CATEGORY')->result_array();
	}

	function update($set, $where)
	{
		$this->db->where($where);
		$this->db->update($this->table, $set);
		return $this->db->affected_rows(); 
	}
}
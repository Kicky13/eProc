<?php
class prc_tender_item_updateqty extends CI_Model {

	protected $table = 'PRC_TENDER_ITEM_UPDATEQTY';
	protected $all_field = 'PRC_TENDER_ITEM_UPDATEQTY.*';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->join_item_status = false;
	}

	public function get($where=NULL) {
		$this->db->distinct();
		$this->db->select($this->all_field);
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$this->db->order_by("$this->table.TIT_ID", 'asc');
		$this->db->order_by("$this->table.TIU_ID", 'asc');
		$result = $this->db->get();
		return $result->result_array();
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function join_tender_item(){
		$this->db->join("PRC_TENDER_ITEM", "PRC_TENDER_ITEM.TIT_ID = $this->table.TIT_ID", "inner");
	}

	public function join_pr_item(){
		$this->db->select("PRC_PR_ITEM.PPI_PRNO,PRC_PR_ITEM.PPI_PRITEM,PRC_PR_ITEM.PPI_DECMAT");
		$this->db->join("PRC_PR_ITEM", "PRC_PR_ITEM.PPI_ID = PRC_TENDER_ITEM.PPI_ID", "inner");
	}

	function join_employee() {
		$this->db->select("ADM_EMPLOYEE.FULLNAME");
		$this->db->join("ADM_EMPLOYEE", "ADM_EMPLOYEE.ID = $this->table.USER_ACT", "inner");
	}

	public function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}

}
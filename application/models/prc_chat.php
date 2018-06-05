<?php defined('BASEPATH') OR exit('No direct script access allowed');

class prc_chat extends CI_Model {

	protected $table = 'PRC_CHAT';
	protected $all_field = 'PRC_CHAT.*, ADM_EMPLOYEE.FULLNAME, VND_HEADER.VENDOR_NAME';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL) {	
		$this->db->distinct();	
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		return (array)$result->result_array();
	}

	public function join_employee_vendor(){
		$this->db->select($this->all_field, false);
		$this->db->join('ADM_EMPLOYEE', 'ADM_EMPLOYEE.ID = PRC_CHAT.USER_ID', 'inner');
		$this->db->join('VND_HEADER', 'VND_HEADER.VENDOR_NO = PRC_CHAT.VENDOR_NO', 'inner');
		// $this->db->join('APP_PROCESS', 'APP_PROCESS.CURRENT_PROCESS = PRC_CHAT.STATUS_PROSES', 'inner');
	}

	public function join_ptm(){
		$this->db->select("PRC_TENDER_MAIN.*");
		$this->db->join('PRC_TENDER_MAIN', 'PRC_TENDER_MAIN.PTM_NUMBER = PRC_CHAT.PTM_NUMBER', 'inner');
	}

	function status_process_master_id($status){
		$this->db->where_in('PRC_CHAT.STATUS_PROSES', $status);	
	}

	public function order_ptm(){
		$this->db->order_by('PRC_CHAT.PTM_NUMBER', 'asc'); 
	}

	public function order_tgl(){
		$this->db->order_by('PRC_CHAT.TGL', 'asc'); 
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function update($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}

}
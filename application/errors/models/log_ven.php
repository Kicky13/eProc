<?php defined('BASEPATH') OR exit('No direct script access allowed');

class log_ven extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "LOG_MAIN";
	}

	public function get($where=NULL) {
		$this->db->distinct();
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$this->db->order_by('LM_ID', 'asc');
		$result = $this->db->get();
		return (array) $result->result_array();
	}

	public function get_log($vendorno) {
		// die(var_dump($vendorno));
		$this->db->select("L.LM_ID, L.USER_ID, L.USER_POSITION, L.PROCESS, L.LM_ACTION, D.LD_ID, D.LM_ID, D.LD_ACTION, D.DATA, D.CONDITION");
		$this->db->where(array('L.USER_ID'=>$vendorno));		
		$this->db->from('LOG_MAIN L');		
		$this->db->join('LOG_DETAIL D','D.LM_ID=L.LM_ID','INNER');
		$this->db->order_by('D.LD_ID', 'asc');
		$result = $this->db->get();
		return (array) $result->result_array();
	}

}
<?php
class app_process_master extends CI_Model {

	protected $table = 'APP_PROCESS_MASTER';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function find($id) {
		$this->db->where(array('PROCESS_MASTER_ID' => $id));
		$result = $this->db->get($this->table);
		return $result->row_array();
	}

}
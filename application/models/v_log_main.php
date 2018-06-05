<?php defined('BASEPATH') OR exit('No direct script access allowed');

class v_log_main extends CI_Model {

	protected $table = 'V_LOG_MAIN';

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
		$this->db->order_by('LM_ID', 'asc');
		$result = $this->db->get();
		return (array) $result->result_array();
	}

}
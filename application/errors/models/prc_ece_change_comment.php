<?php defined('BASEPATH') OR exit('No direct script access allowed');

class prc_ece_change_comment extends CI_Model {

	protected $table = 'PRC_ECE_CHANGE_COMMENT';
	protected $id = 'ID';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$this->db->order_by('ID', 'asc');
		$result = $this->db->get();
		return (array)$result->result_array();
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function get_id() {
		$this->db->select_max($this->id, 'MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

}
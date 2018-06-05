<?php defined('BASEPATH') OR exit('No direct script access allowed');

class com_mat_group extends CI_Model {

	protected $table = 'COM_MAT_GROUP';
	protected $id = 'MAT_GROUP_CODE';

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
		return (array)$result->result_array();
	}

	public function find($id) {
		$ans = $this->get(array($this->id => $id));
		if (empty($ans)) {
			return null;
		}
		return $ans[0];
	}

}
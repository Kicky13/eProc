<?php defined('BASEPATH') OR exit('No direct script access allowed');

class prc_auction_item extends CI_Model {

	protected $table = 'PRC_AUCTION_ITEM';
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
		$result = $this->db->get();
		return (array) $result->result_array();
	}

	public function paqh($id) {
		return $this->get(array("$this->table.PAQH_ID" => $id));
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function insert_batch($data) {
		$this->db->insert_batch($this->table, $data);
	}

	public function get_id() {
		$this->db->select_max($this->id, 'MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
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
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class po_approval extends CI_Model {

	protected $table = 'PO_APPROVAL';
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
		$this->db->order_by('ID', 'ASC');
		$result = $this->db->get();
		return (array)$result->result_array();
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function insert_batch($data) {
		$this->db->insert_batch($this->table, $data);
	}

	public function where_po($id) {
		$this->db->where(array('PO_ID' => $id));
	}

	public function where_approve() {
		$this->db->where(array('IS_APPROVE' => 0));
	}

	public function where_userid($id) {
		$this->db->where(array('APPROVE_BY' => $id));
	}

	public function where_releaseby($id) {
		$this->db->where(array('STATUS' => $id));
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

	public function delete($id = NULL){
		$this->db->where('PO_ID', $id);
		$this->db->delete($this->table);
	}

}
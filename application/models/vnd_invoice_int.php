<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class vnd_invoice_int extends CI_Model {

	protected $table = 'VND_INVOICE';
	protected $id = 'ID_INVOICE';
	
	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($status,$status1,$status2) {
		$this->db->where('STATUS',$status);
		$this->db->or_where('STATUS',$status1);
		$this->db->or_where('STATUS',$status2);
		$this->db->from($this->table);
		$result = $this->db->get();
		return (array)$result->result_array();
	}

	public function detil($id) {
		// $this->db->select("*");
		$this->db->where('ID_INVOICE', $id);
		$this->db->from($this->table);
		// $this->db->join('VND_BOARD', 'VND_BOARD.VENDOR_ID = VND_HEADER.VENDOR_ID', 'left');
		$result = $this->db->get();
		return $result->result_array();
	}

	public function get_id() {
		$this->db->select_max($this->id, 'MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	public function getDetail($email){
		$this->db->from($this->table);
		$this->db->where('ID_INVOICE', $email);
		$result = $this->db->get();
		return (array)$result->result_array();
	}

	public function updateInvoice($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}


	public function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}
}

/* End of file vnd_invoice.php */
/* Location: ./application/models/vnd_invoice.php */
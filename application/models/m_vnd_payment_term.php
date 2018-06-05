<?php defined('BASEPATH') OR exit('No direct script access allowed');

class m_vnd_payment_term extends CI_Model {

	protected $table = 'M_VND_PAYMENT_TERM';
	protected $id = 'ID_PAYMENT_TERM';
	protected $all_field = 'ID_PAYMENT_TERM,CODE_PAYMENT_TERM,EXPLANATION';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL, $select=NULL) {
		if(!empty($select)){
			$this->db->select($select);
		} else {
			$this->db->select($this->all_field);
		}
		if(!empty($where)){
			$this->db->where($where);
		}

		$this->db->from($this->table);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function get_count($where=NULL, $select=NULL){
		if(!empty($select)){
			$this->db->select($select);
		} else {
			$this->db->select($this->all_field);
		}
		if(!empty($where)){
			$this->db->where($where);
		}

		$this->db->from($this->table);
		$result = $this->db->get();
		return $result->num_rows();
	}

	public function insert($data) {
		return $this->db->insert($this->table, $data);
	}

	public function update($data, $where) {
		$this->db->where($where);
		return $this->db->update($this->table, $data);
	}

	public function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}

}
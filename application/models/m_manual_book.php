<?php defined('BASEPATH') OR exit('No direct script access allowed');

class m_manual_book extends CI_Model {

	protected $table = 'M_MANUAL_BOOK';
	protected $id = 'ID_MANUAL';

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

	public function getforvendor(){
		$this->db->select("*");
		$this->db->where("TIPE", 3);
		$this->db->from("M_MANUAL_BOOK");
		$result = $this->db->get();
		return $result->result_array();
	}

	public function getall(){
		$this->db->select("*");
		$this->db->from("M_MANUAL_BOOK");
		$result = $this->db->get();
		return $result->result_array();
	}

}
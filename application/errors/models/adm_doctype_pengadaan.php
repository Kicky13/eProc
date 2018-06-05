<?php
class adm_doctype_pengadaan extends CI_Model {

	protected $table = 'ADM_DOCTYPE_PENGADAAN';
	protected $id = 'TYPE';

	/**
	 * Field: 
	 *    CAT
	 *    TYPE
	 *    DESC
	 *    PGRP
	 *    KEL_OPCO
	 */

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL) {
		$this->db->select('*');
		if (!empty($where)) {
			$this->db->where($where);
		}
		$result = $this->db->get($this->table);
		return $result->result_array();
	}

	public function where_pgrp($val) {
		$this->db->where('PGRP', $val);
	}

	public function where_cat($val) {
		$this->db->where('CAT', $val);
	}

	public function where_opco($val) {
		$this->db->where('KEL_OPCO', $val);
	}

	public function where_opco_in($val){
		$this->db->where_in('KEL_OPCO',$val);
	}

	public function find($id) {
		$retval = $this->get(array("$this->table.$this->id" => $id));
		if (count($retval) >= 0 && $retval != false) {
			return $retval[0];
		} else {
			return null;
		}
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
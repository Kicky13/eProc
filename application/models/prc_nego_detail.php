<?php defined('BASEPATH') OR exit('No direct script access allowed');

class prc_nego_detail extends CI_Model {

	protected $table = 'PRC_NEGO_DETAIL';
	protected $id = 'MY_ID';

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

	public function ptm($ptm) {
		return $this->get(array('PRC_NEGO_DETAIL.PTM_NUMBER' => $ptm));
	}

	public function where_id($nego_id) {
		$this->db->where(array('NEGO_ID' => $nego_id));
	}

	public function where_titid($titid) {
		$this->db->where(array('TIT_ID' => $titid));
	}

	public function where_ptm($ptm) {
		$this->db->where(array('PTM_NUMBER' => $ptm));
	}

	public function join_vnd() {
		$this->db->join('VND_HEADER', 'VND_HEADER.VENDOR_NO = PRC_NEGO_DETAIL.VENDOR_NO', 'inner');
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

	public function get_count_nego($ptm,$VENDOR_NO){
		$this->db->select('count(prc_nego_detail.NEGO_ID) as N_NEGO,TIT_ID');		
		$this->db->where(array('VENDOR_NO'=>$VENDOR_NO,'PTM_NUMBER'=>$ptm,'CHANGED'=>1));
		$this->db->from($this->table);
		$this->db->group_by('TIT_ID');
		$result = $this->db->get();
		return $result->result_array();
	}

	public function get_response_vendor($NEGO_ID,$CHANGED){
		$this->db->distinct();
		$this->db->select('VENDOR_NO');		
		$this->db->where(array('NEGO_ID'=>$NEGO_ID,'CHANGED'=>$CHANGED));
		$this->db->from($this->table);		
		$result = $this->db->get();
		return $result->result_array();
	}

}
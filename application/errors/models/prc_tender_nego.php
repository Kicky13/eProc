<?php defined('BASEPATH') OR exit('No direct script access allowed');

class prc_tender_nego extends CI_Model {

	protected $table = 'PRC_TENDER_NEGO';
	protected $id = 'NEGO_ID';

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

	public function OneBeforeByPtm($ptm){
		$this->db->where(array('PTM_NUMBER' => $ptm));
		$this->where_done('1');
		$this->db->order_by('NEGO_ID','DESC');
		$ans = $this->get();
		if (empty($ans)) {
			return null;
		}
		return $ans[0];
	}

	/* return nya satu row doang */
	public function ptm($ptm) {
		$this->db->where(array('PTM_NUMBER' => $ptm));
		$ans = $this->get();
		if (empty($ans)) {
			return null;
		}
		return $ans[0];
	}

	public function id($id) {
		$this->db->where(array('NEGO_ID' => $id));
		$ans = $this->get();
		if (empty($ans)) {
			return null;
		}
		return $ans[0];
	}

	/* return nya satu row doang */
	public function ptm_many($ptm) {
		$this->db->where(array('PTM_NUMBER' => $ptm));
		$ans = $this->get();
		if (empty($ans)) {
			// $new['PTM_NUMBER'] = $ptm;
			// $new['NEGO_ID'] = $this->get_id();
			// $this->insert($new);
			return null;
		}
		return $ans;
	}

	public function where_done($val = 0) {
		if ($val == null) {
			$val = 0;
		}
		$this->db->where(array('NEGO_DONE' => $val));
	}

	public function insert($data) {
		$data['CREATED_AT'] = date(timeformat());
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
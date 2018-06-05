<?php defined('BASEPATH') OR exit('No direct script access allowed');

class prc_ece_change extends CI_Model {

	protected $table = 'PRC_ECE_CHANGE';
	protected $id = 'EC_ID';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL) {
		$this->db->distinct();
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$this->db->order_by('PRC_ECE_CHANGE.CREATED_AT', 'asc');
		$result = $this->db->get();
		return (array) $result->result_array();
	}

	public function ptm($ptm) {
		return $this->get(array("$this->table.PTM_NUMBER" => $ptm));
	}

	public function id($id) {
		return $this->get(array("$this->table.EC_ID" => $id));
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

	function holder($id, $join) {
		$this->db->join('ADM_EMPLOYEE', "ADM_EMPLOYEE.ID = PRC_ECE_CHANGE.$join", 'inner');
		$this->db->where('PRC_ECE_CHANGE.EC_ID', $id);
		return $this->db->get($this->table)->result_array();
	}

	public function join_pec(){
		$this->db->select('*');
		$this->db->join('PRC_TENDER_ITEM', 'PRC_TENDER_ITEM.TIT_ID = PRC_ECE_CHANGE.TIT_ID', 'inner');
		$this->db->join('PRC_PR_ITEM', 'PRC_PR_ITEM.PPI_ID = PRC_TENDER_ITEM.PPI_ID', 'left');
	}

	public function get_id_group() {
		$this->db->select_max('EC_ID_GROUP', 'MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	public function group_id(){
		$this->db->join('(SELECT TRIM (REGEXP_SUBSTR (PE.EC_ID, \'[^,]+\', 1)) EC_ID, PE.PTM_NUMBER
			FROM
			(
				SELECT
					LISTAGG (S.EC_ID, \', \') WITHIN GROUP (ORDER BY S.EC_ID) AS EC_ID, S.PTM_NUMBER, S.EC_ID_GROUP
					FROM
					(
						SELECT DISTINCT	EC_ID, PTM_NUMBER, EC_ID_GROUP
						FROM PRC_ECE_CHANGE
					) S GROUP BY S.PTM_NUMBER, S.EC_ID_GROUP
			) PE
		) PEC', "PRC_TENDER_MAIN.PTM_NUMBER = PEC.PTM_NUMBER", 'inner');
	}

}
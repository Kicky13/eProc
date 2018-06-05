<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class etor_m extends CI_Model {
	protected $tableHeader = 'EC_AUCTION_ITEMIZE_HEADER', $tableItem = 'EC_AUCTION_ITEMIZE_ITEM', $tablePeserta = 'EC_AUCTION_ITEMIZE_PESERTA', $tableItemTemp = 'EC_AUCTION_ITEMIZE_ITEM_temp', $tablePesertaTemp = 'EC_AUCTION_ITEMIZE_P_temp', $tableLog = 'EC_AUCTION_ITEMIZE_LOG', $tableBatch = 'EC_AUCTION_ITEMIZE_BATCH', $tableItemPrice = 'EC_AUCTION_ITEMIZE_PRICE', $tableAdmCompany = 'ADM_COMPANY', $tableVnd_header = 'VND_HEADER', $tableCurrency = 'EC_AUCTION_ITEMIZE_CURRENCY', $table = "ETOR_APPROVAL", $tableMain = "ETOR_MAIN", $tableupload = "ETOR_UPLOAD", $tableholder = "ETOR_HOLDER", $tablekomen = "ETOR_KOMENTAR";

	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	function getLastData() {
		$this->db->from($this->table);
		$this->db->order_by("ID_APP", "desc");
		$query = $this->db->get(); 
		return $query->result();
	}

	function getLastDataHolder() {
		$this->db->from($this->tableholder);
		$this->db->order_by("ID_FLOW", "desc");
		$query = $this->db->get(); 
		return $query->result();
	}

	function getLastDataMain() {
		$this->db->from($this->tableMain);
		$this->db->order_by("ID_TOR", "desc");
		$query = $this->db->get(); 
		return $query->result();
	}

	function getLastDataGambar() {
		$this->db->from($this->tableupload);
		$this->db->order_by("ID_GAM", "desc");
		$query = $this->db->get(); 
		return $query->result();
	}

	function getLastDataKomen() {
		$this->db->from($this->tablekomen);
		$this->db->order_by("ID_KOM", "desc");
		$query = $this->db->get(); 
		return $query->result();
	}

	function insert_custom($data) {
		if($this->db->insert($this->table, $data)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function insertMain($data) {
		$this->db->insert($this->tableMain, $data);
	}

	public function insertGambar($data) {
		$this->db->insert($this->tableupload, $data);
	}

	public function insertHolder($data) {
		$this->db->insert($this->tableholder, $data);
	}

	public function insertKomen($data) {
		$this->db->insert($this->tablekomen, $data);
	}

	public function update($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function updateMain($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableMain, $set);
	}

	public function updateHolder($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableholder, $set);
	}

	public function updateSaved($set, $where) {
		$this->db->where('CREATED_BY = '.$where, null, false);
		$this->db->where('ID_TOR is null', null, false);
		return $this->db->update($this->table, $set);
	}

	public function updateHolderSaved($set, $where) {
		$this->db->where('CREATED_BY = '.$where, null, false);
		$this->db->where('ID_TOR is null', null, false);
		return $this->db->update($this->tableholder, $set);
	}

	function delete($where) {
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}
		if($this->db->delete($this->table)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function deleteHolder($where) {
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}
		if($this->db->delete($this->tableholder)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function deleteApproval($where) {
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}
		if($this->db->delete($this->table)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function editDateMain1($data = '') {
		$this->db->set('CREATED_AT', "TO_DATE('" . $data['CREATED_AT'] . "', 'dd/mm/yyyy hh24:mi:ss')", FALSE);
		$this->db->where('ID_TOR', $data['ID_TOR']);
		$this->db->update('ETOR_MAIN');
	}

	public function editDateApprove($data = '') {
		$this->db->set('APPROVED_AT', "TO_DATE('" . $data['APPROVED_AT'] . "', 'dd/mm/yyyy hh24:mi:ss')", FALSE);
		$this->db->where('ID_TOR', $data['ID_TOR']);
		$this->db->where('ID_EMP', $data['ID_EMP']);
		$this->db->update('ETOR_APPROVAL');
	}

	function getDetailTorPrint($id){
		$this->db->select("ADM_EMPLOYEE.ID, FULLNAME, EMAIL, ADM_EMPLOYEE.DEPT_KODE, ETOR_MAIN.*");
		$this->db->from($this->tableMain);
		$this->db->join('ADM_EMPLOYEE', 'ETOR_MAIN.CREATED_BY = ADM_EMPLOYEE.ID', 'inner');
		// $this->db->join('ADM_POS', 'ADM_POS.DEPT_KODE = ADM_EMPLOYEE.DEPT_KODE', 'inner');
		$this->db->where('ETOR_MAIN.ID_TOR = '.$id, null, false);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return NULL;
		}
	}

	public function getTorPr($pr){
		$this->db->select("ETOR_MAIN.NO_PR");
		$this->db->from($this->tableMain);
		$this->db->where('ETOR_MAIN.NO_PR = '.$pr, null, false);
		$result = $this->db->get();
		return $result->result_array();
	}

	function getDetailTorPrintApprove($id){
		$this->db->select("ADM_EMPLOYEE.ID, FULLNAME, EMAIL, ADM_EMPLOYEE.DEPT_KODE, ETOR_APPROVAL.*");
		$this->db->from($this->table);
		$this->db->join('ADM_EMPLOYEE', 'ETOR_APPROVAL.ID_EMP = ADM_EMPLOYEE.ID', 'inner');
		// $this->db->join('ADM_POS', 'ADM_POS.DEPT_KODE = ADM_EMPLOYEE.DEPT_KODE', 'inner');
		$this->db->where('ETOR_APPROVAL.ID_TOR = '.$id, null, false);
		$this->db->order_by("ORDER_APPRV", "asc");
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return NULL;
		}
	}

	function getDetailTorPrintApproved($id){
		$this->db->select("ADM_EMPLOYEE.ID, FULLNAME, EMAIL, ADM_EMPLOYEE.DEPT_KODE, ETOR_APPROVAL.*");
		$this->db->from($this->table);
		$this->db->join('ADM_EMPLOYEE', 'ETOR_APPROVAL.ID_EMP = ADM_EMPLOYEE.ID', 'inner');
		// $this->db->join('ADM_POS', 'ADM_POS.DEPT_KODE = ADM_EMPLOYEE.DEPT_KODE', 'inner');
		$this->db->where('ETOR_APPROVAL.ID_TOR = '.$id, null, false);
		$this->db->where('ETOR_APPROVAL.IS_APPROVE = 1', null, false);
		$this->db->order_by("ORDER_APPRV", "asc");
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return NULL;
		}
	}

	function cekApprovalUrutan($id, $urutan){
		$this->db->select("ETOR_APPROVAL.*");
		$this->db->from($this->table);
		$this->db->where('ETOR_APPROVAL.ID_TOR = '.$id, null, false);
		$this->db->where('ETOR_APPROVAL.ORDER_APPRV = '.$urutan, null, false);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return NULL;
		}
	}

	function cekApprovalFlow($id){
		$this->db->select("ETOR_APPROVAL.*");
		$this->db->from($this->table);
		$this->db->where('ETOR_APPROVAL.ID_TOR = '.$id, null, false);
		$this->db->where('ETOR_APPROVAL.IS_APPROVE is null', null, false);
		$this->db->order_by("ORDER_APPRV", "asc");
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return NULL;
		}
	}

}

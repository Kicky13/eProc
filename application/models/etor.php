<?php
class etor extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "ETOR_APPROVAL";
		// $this->table_district = "ADM_DISTRICT";
	}

	function getLastData() {
		$this->db->from($this->table);
		$this->db->order_by("ID_APP", "desc");
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

	function update($data, $where) {
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}
		if($this->db->update($this->table, $data)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
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

	public function editDateMain1($data = '') {
		$this -> db -> set('CREATED_AT', "TO_DATE('" . $data['CREATED_AT'] . "', 'dd/mm/yyyy hh24:mi:ss')", FALSE);
		$this -> db -> where('ID_TOR', $data['ID_TOR']);
		$this -> db -> update('EC_AUCTION_ITEMIZE_HEADER');
	}

}
?>
<?php
class prc_tender_pemenang extends CI_Model
{
	var $table = "PRC_TENDER_PEMENANG";
	var $get_id_query = 'select max(ID_PEMENANG) as id from PRC_TENDER_PEMENANG';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get_id()
	{
		$result = $this->db->query($this->get_id_query);
		$id = $result->row_array();
		return $id['ID'] + 1;
	}

	function insert($data) {
		if($this->db->insert($this->table, $data)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function update($set=NULl, $where=NULL)
	{
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	function get($where){
		$query = $this->db->get_where($this->table, $where);
		return $query->result_array();
	}
}

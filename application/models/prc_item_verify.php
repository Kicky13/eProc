<?php
class prc_item_verify extends CI_Model {

	protected $table = 'PRC_ITEM_VERIFY';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL, $select = false) {
		if (!$select) $select = '*';
		$this->join_header();
		$this->db->select($select);
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return (array) $result->result_array();
		}
	}

	public function pr($prno, $select = false) {
		return $this->get(array('PIV_PRNO' => $prno), $select);
		
		
	}
	
	
	public function where_ppvid($id) {
		$this->db->where(array('PRC_ITEM_VERIFY.PPV_ID' => $id));
	}

	public function where_is_doc($val) {
		$this->db->where(array('PIV_IS_DOC' => $val));
	}

	public function join_header() {
		$this->db->join('PRC_PR_VERIFY', 'PRC_PR_VERIFY.PPV_ID = PRC_ITEM_VERIFY.PPV_ID', 'inner');
		$this->db->order_by('PPV_DATE');
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function insert_batch($data) {
		$this->db->insert_batch($this->table, $data);
	}

	public function delete($where = null) {
		if ($where != null) {
			$this->db->where($where);
			return $this->db->delete($this->table);
		} else {
			return $this->db->empty_table($this->table);
		}
	}

	public function update($set, $where)
	{
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function get_id()
	{
		$this->db->select_max('PIV_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

}
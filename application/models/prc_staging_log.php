<?php
class prc_staging_log extends CI_Model {

	protected $table = 'PRC_STAGING_LOG';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=NULL)
	{
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		return $result->result_array();
	}

	function get_latest() {
		$this->db->select('TO_CHAR(CREATED_AT, \'DD-MM-YYYY HH24:MI\') AS "DATE"', false);
		$this->db->from($this->table);
		$this->db->order_by('CREATED_AT', 'DESC');
		$result = $this->db->get();
		return $result->row_array();
	}

	function get_id()
	{
		$this->db->select_max('ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function insert($data)
	{
		$data['ID'] = $this->get_id();
		$this->db->insert($this->table, $data);
	}

}
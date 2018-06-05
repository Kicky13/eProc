<?php
class prc_evaluation_template extends CI_Model {

	protected $table = "PRC_EVALUATION_TEMPLATE";	

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=null)
	{
		$this->db->select('*');
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return null;
		}
	}

	function get_join($where=null)
	{
		$this->db->join('PRC_PREQ_TEMPLATE_DETAIL', 'PRC_EVALUATION_TEMPLATE.EVT_ID = PRC_PREQ_TEMPLATE_DETAIL.PPT_ID', 'inner');
		return $this->get($where);
	}

	function readable($evt) {
		switch ($evt['EVT_TYPE']) {
			case "1": $evt['EVT_TYPE_NAME'] = 'Evaluasi Kualitas Terbaik'; break;
			case "2": $evt['EVT_TYPE_NAME'] = 'Evaluasi Kualitas Teknis dan Harga'; break;
			case "3": $evt['EVT_TYPE_NAME'] = 'Evaluasi Harga Terbaik'; break;
			case "4": $evt['EVT_TYPE_NAME'] = 'Evaluasi Interchangeable (khusus Tonasa)'; break;
			case "5": $evt['EVT_TYPE_NAME'] = 'Sistem Gugur'; break;
		}
		return $evt;
	}

	function company($opco){
		$this->db->where('COMPANY in ('.$opco.')');
	}

	function get_w_type($where=null)
	{
		$ans = array();
		$evts = $this->get($where);
		foreach ((array)$evts as $value) {
			$ans[] = $this->readable($value);
		}
		return $ans;
	}

	function get_id()
	{
		$this->db->select_max('EVT_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function insert($data) {
		return $this->db->insert($this->table, $data);
	}

	function update($set='',$where='')
	{
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}
}
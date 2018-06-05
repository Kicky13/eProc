<?php
class adm_vendor_registration_news extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "ADM_VENDOR_REGISTRATION_NEWS";
	}

	function get_id() {
		$this->db->select_max('ADM_NEWS_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function get($where = NULL,$limit=NULL,$offset=NULL) {
		$this->db->select("ADM_NEWS_ID, NEWS_CONTENT, NEWS_TITLE");
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$this->db->where("$this->table.$key", $value);
			}
		}
		$this->db->from($this->table);
		if (!empty($limit)) {
			if (!empty($offset)) {
				$this->db->limit($limit,$offset);
			}
			else {
				$this->db->limit($limit);
			}
		}
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return NULL;
		}
	}

	function insert( $ADM_NEWS_ID = FALSE, $NEWS_CONTENT = FALSE, $NEWS_TITLE = FALSE ) {
		$data = array(
			'ADM_NEWS_ID' => $ADM_NEWS_ID,
			'NEWS_CONTENT' => $NEWS_CONTENT,
			'NEWS_TITLE' => $NEWS_TITLE);
		$this->db->insert($this->table, $data); 
	}

	function insert_custom($data) {
		if($this->db->insert($this->table, $data)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
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

	function get_total_data($where = NULL) {
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$this->db->like($key, $value);
			}
		}
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	function get_total_data_without_filter() {
		return  $this->db->count_all($this->table);
	}
}
?>
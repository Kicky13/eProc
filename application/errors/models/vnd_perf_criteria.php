<?php
class vnd_perf_criteria extends CI_Model {

	/**
	 * Constants for system:
	 *    QUOTATION_YES
	 *    QUOTATION_NO
	 *    NEGO_TURUN
	 *    NEGO_NAIK
	 *    NEGO_NO_RESPON
	 *    GET_PO_CONTRACT
	 *    GAGAL_PASOK
	 *    PERPANJANGAN_PO
	 *    DELIVERY_ON_TIME
	 *    DELIVERY_0_3
	 *    DELIVERY_4_7
	 *    DELIVERY_8_30
	 *    DELIVERY_31_MORE
	 */

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "VND_PERF_CRITERIA";
	}

	function get_id() {
		$this->db->select_max('ID_CRITERIA','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function get($where = NULL,$limit=NULL,$offset=NULL) {
		$this->db->select("ID_CRITERIA, CRITERIA_NAME, CRITERIA_DETAIL, CRITERIA_SCORE, CRITERIA_TRIGGER_BY, CRITERIA_SCORE_SIGN, T_OR_V, REQ_OR_BUYER,SPECIAL_SANCTION, COMPANYID, CRITERIA_TYPE");
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->from($this->table);
		$this->db->select("MS.SANCTION_NAME");
		$this->db->join('VND_PERF_M_SANCTION MS','MS.M_SANCTION_ID=SPECIAL_SANCTION','LEFT');
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

	function insert($data) {
		$this->db->insert($this->table, $data);
		return;
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

	public function cek_sanksi_khusus($criteria_id){
		$result = $this->get(array('ID_CRITERIA'=>$criteria_id));
		if($result[0]['SPECIAL_SANCTION']!=NULL){
			return $result[0];
		}else{
			return false;
		}
	}

	public function get_criteria($whereopco,$tv) {
		$this->db->select('ID_CRITERIA, CRITERIA_NAME, CRITERIA_DETAIL, CRITERIA_SCORE, CRITERIA_TRIGGER_BY, CRITERIA_SCORE_SIGN, T_OR_V, REQ_OR_BUYER, SPECIAL_SANCTION, COMPANYID, MS.SANCTION_NAME FROM VND_PERF_CRITERIA 
LEFT JOIN VND_PERF_M_SANCTION MS ON MS.M_SANCTION_ID=SPECIAL_SANCTION WHERE CRITERIA_TRIGGER_BY = 1 AND T_OR_V = '.$tv.' AND COMPANYID '.$whereopco.'', false);
		$result = $this->db->get();
		return $result->result_array();
	}
}
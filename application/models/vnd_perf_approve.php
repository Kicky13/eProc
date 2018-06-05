<?php
class vnd_perf_approve extends MY_Model
{
	public $primary_key = 'APPROVE_ID';
	public $table = 'VND_PERF_APPROVE';

	public function __construct() {
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		// $this->increments = FALSE;
		$this->soft_deletes = FALSE;
		parent::__construct();
	}

	public function get_ven($where = null, $limit = null, $offset = null) {
		$this->db->select("VND_PERF_APPROVE.APPROVE_ID,VND_PERF_APPROVE.TMP_ID,VND_PERF_APPROVE.EMP_ID,VND_PERF_APPROVE.APPROVED_DATE,VND_PERF_APPROVE.URUTAN,VND_PERF_APPROVE.STATUS_APRV AS STATUS,VND_PERF_TMP.PERF_TMP_ID,VND_PERF_TMP.VENDOR_CODE,VND_PERF_TMP.DATE_CREATED,VND_PERF_TMP.SIGN,VND_PERF_TMP.POIN,VND_PERF_TMP.CRITERIA_ID,VND_PERF_TMP.KETERANGAN,VND_PERF_TMP.STATUS,VND_PERF_TMP.EXTERNAL_CODE,VND_PERF_TMP.EMP_ID,VND_HEADER.VENDOR_ID,VND_HEADER.VENDOR_NAME,VND_HEADER.VENDOR_NO");
		if (is_array($where)) {
			$this->db->where($where);
		} else if (is_numeric($where)) {
			$this->db->where($this->primary_key, $where);
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
		if (is_numeric($where)) {
			return $result->row_array();
		}
		return $result->result_array();
	}

	public function join() {
		$this->db->join("VND_PERF_TMP","VND_PERF_APPROVE.TMP_ID = VND_PERF_TMP.PERF_TMP_ID","inner");
        $this->db->join("VND_HEADER","VND_PERF_TMP.VENDOR_CODE=VND_HEADER.VENDOR_NO","inner");
	}	

	public function where_ven($vendor_id) {

             $this->db->where("VND_HEADER.VENDOR_ID", $vendor_id);

	}

}
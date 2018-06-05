<?php
class vnd_perf_tmp extends CI_Model {

	protected $table = 'VND_PERF_TMP';
	protected $primary_key = 'PERF_TMP_ID';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "VND_PERF_TMP";
	}
    
    public function list_perencanaan($urutan, $opco)
    { 	
    	$subquery0 = "SELECT VENDOR_CODE,PERF_TMP_ID,STATUS FROM VND_PERF_TMP WHERE STATUS >-1";
        $subquery1 = "SELECT VENDOR_CODE,max(perf_tmp_id) as MAXID from (".$subquery0.") z GROUP BY VENDOR_CODE";
		$subquery2 = "SELECT T2.* FROM VND_PERF_TMP T2 INNER JOIN ( ".$subquery1." ) T1 ON T1.MAXID = T2.PERF_TMP_ID";
		$subquery4 = "SELECT ADM_PURCH_GRP.COMPANY_ID,ADM_PURCH_GRP.KEL_PURCH_GRP FROM ADM_PURCH_GRP GROUP BY ADM_PURCH_GRP.KEL_PURCH_GRP,ADM_PURCH_GRP.COMPANY_ID";
		$subquery3 = "SELECT ROWNUM RNUM, VPA.APPROVE_ID, VPA.TMP_ID, VPA.EMP_ID, VPA.APPROVED_DATE, VPA.URUTAN, VPA.STATUS_APRV, VND_HEADER.VENDOR_ID, VND_HEADER.VENDOR_NAME, VND_HEADER.EMAIL_ADDRESS, VND_HEADER.VENDOR_NO, VND_HEADER.STATUS_PERUBAHAN, VND_HEADER.STATUS, VND_HEADER.NEXT_PAGE, VND_HEADER.COMPANYID,ADM_PURCH_GRP.KEL_PURCH_GRP  FROM VND_HEADER INNER JOIN ( ".$subquery2." ) T3 ON T3.VENDOR_CODE = VND_HEADER.VENDOR_NO INNER JOIN VND_PERF_APPROVE VPA ON VPA.TMP_ID=T3.PERF_TMP_ID LEFT JOIN ( ".$subquery4." ) ADM_PURCH_GRP ON ADM_PURCH_GRP.COMPANY_ID = VND_HEADER.COMPANYID WHERE VND_HEADER.STATUS=3 AND ADM_PURCH_GRP.KEL_PURCH_GRP = ".$opco." AND VND_HEADER.VENDOR_NO IS NOT NULL AND VPA.STATUS_APRV=0 AND VPA.URUTAN = ".$urutan." ";
		
        $this->db->select("*");
        $this->db->from("(".$subquery3.")");

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

	function get_id() {
		$this->db->select_max($this->primary_key, 'MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function get($where = null, $limit = null, $offset = null) {
		$this->db->select("*");
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

	public function join_vnd() {
		$this->db->join('VND_HEADER', "VND_PERF_TMP.VENDOR_CODE = VND_HEADER.VENDOR_NO", 'inner');
	}
	
	public function join_approve() {
		$this->db->join('VND_PERF_APPROVE', "VND_PERF_TMP.PERF_TMP_ID = VND_PERF_APPROVE.TMP_ID", 'inner');
	}

	public function join_must_approve() {
		$query_join = "SELECT DISTINCT t1.*
			from VND_PERF_APPROVE t1
			join (select TMP_ID, min(URUTAN) URUTAN from VND_PERF_APPROVE where APPROVED_DATE is null group by TMP_ID) T2
			on T1.TMP_ID = T2.TMP_ID and T1.URUTAN = T2.URUTAN";
		$this->db->join("($query_join) TJ", 'TJ.TMP_ID = VND_PERF_TMP.PERF_TMP_ID', 'inner');
	}

	public function where_rekap($not = '') {
		$this->db->where("CRITERIA_ID IS $not NULL", null, false);
	}

	public function where_not_rekap() {
		$this->where_rekap('NOT');
	}

	public function where_not_approved($status = 0,$vendor_id=0) {
		$this->db->where("VND_PERF_TMP.STATUS", $status);
        if(!empty($vendor_id))
        {
             $this->db->where("VND_HEADER.VENDOR_ID", $vendor_id);
        }
       
	}

	public function where_approved() {
		$this->where_not_approved(1);
	}

	public function where_rejected() {
		$this->where_not_approved(-1);
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
		//var_dump($data);
		return;
	}

	public function update($data, $where) {
		if (is_array($where)) {
			$this->db->where($where);
		} else if (is_numeric($where)) {
			$this->db->where($this->primary_key, $where);
		}
		if($this->db->update($this->table, $data)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function delete($where) {
		if (is_array($where)) {
			$this->db->where($where);
		} else if (is_numeric($where)) {
			$this->db->where($this->primary_key, $where);
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

	public function get_last_id() {
        $this->db->select_max($this->primary_key, 'MAX');
        $max = $this->db->get($this->table)->row_array();
        return $max['MAX'] + 1 - 1;
    }

    public function get_uncek($vendor_no) {
    	$this->db->select('VND_PERF_TMP.VENDOR_CODE, VND_PERF_TMP.PERF_TMP_ID, VND_PERF_TMP.STATUS, VND_PERF_TMP.EMP_ID, VND_PERF_TMP.KETERANGAN, VND_PERF_APPROVE.APPROVE_ID, VND_PERF_APPROVE.TMP_ID, VND_PERF_APPROVE.EMP_ID, VND_PERF_APPROVE.APPROVED_DATE, VND_PERF_APPROVE.URUTAN, VND_PERF_APPROVE.STATUS_APRV ',false);
        $this->db->from("VND_PERF_TMP");
        $this->db->join("VND_PERF_APPROVE","VND_PERF_TMP.PERF_TMP_ID = VND_PERF_APPROVE.TMP_ID","inner"); 
        $this->db->where("VND_PERF_TMP.VENDOR_CODE",$vendor_no);
        $this->db->where("VND_PERF_TMP.STATUS",0);
        $this->db->where("VND_PERF_APPROVE.STATUS_APRV",0);
        
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function cek_approve($vendor_no) {
    	$this->db->select('VND_PERF_APPROVE.TMP_ID, VND_PERF_TMP.PERF_TMP_ID, VND_PERF_TMP.VENDOR_CODE, VND_PERF_TMP.DATE_CREATED, VND_PERF_TMP.SIGN, VND_PERF_TMP.POIN, VND_PERF_TMP.CRITERIA_ID, VND_PERF_TMP.KETERANGAN, VND_PERF_TMP.STATUS, VND_PERF_TMP.EXTERNAL_CODE, VND_PERF_TMP.EMP_ID, VND_PERF_APPROVE.APPROVE_ID, VND_PERF_APPROVE.EMP_ID, VND_PERF_APPROVE.APPROVED_DATE, VND_PERF_APPROVE.URUTAN, VND_PERF_APPROVE.STATUS_APRV');
        $this->db->from("VND_PERF_TMP");
        $this->db->join("VND_PERF_APPROVE","VND_PERF_TMP.PERF_TMP_ID = VND_PERF_APPROVE.TMP_ID","inner");
        $this->db->where("VND_PERF_TMP.VENDOR_CODE",$vendor_no);
        $this->db->where("VND_PERF_TMP.STATUS",0);
        $this->db->where("VND_PERF_APPROVE.URUTAN",1);
        $this->db->where("VND_PERF_APPROVE.STATUS_APRV",1);
        
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

}
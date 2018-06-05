<?php
class vnd_perf_hist extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "VND_PERF_HIST";
		$this->table_vendor = "VND_HEADER";
	}

	function get($where = NULL,$limit=NULL,$offset=NULL) {
		$this->db->select("PERF_HIST_ID, VENDOR_CODE, DATE_CREATED, KETERANGAN, POIN_ADDED, SIGN, IGNORED, POIN_PREV, POIN_CURR, CRITERIA_ID, TMP_ID, REKAP_ID");
		if (!empty($where)) {
			$this->db->where($where);
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
		$this->db->order_by('PERF_HIST_ID', 'asc');
		$result = $this->db->get();
		return (array) $result->result_array();
	}

	function getLastScoreByVendorCode($vendor_code) {
	   $hasil =	$this->db->query("SELECT POIN_ADDED FROM VND_PERF_HIST WHERE VENDOR_CODE = $vendor_code AND DATE_CREATED = (SELECT MAX(DATE_CREATED) FROM VND_PERF_HIST where VENDOR_CODE = '$vendor_code')")->row_array();
	   if(empty($hasil))
       {
        return 0;
       }
       else
       {
        return $hasil[0];
       }
        
    }

	function insert_custom($data) {
		if($this->db->insert($this->table, $data)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function insert($vnd_no, $keterangan, $poin, $sign, $criteria_id = null) {
		$this->load->model('vnd_header');
		$where_vnd = array('VENDOR_NO' => $vnd_no);
		$vnd = $this->vnd_header->get($where_vnd);
		if ($vnd == false || $vnd == null) {
			return false;
		}

		$new['VENDOR_CODE'] = $vnd_no;
		$new['KETERANGAN'] = $keterangan;
		$new['POIN_ADDED'] = $poin;
		$new['SIGN'] = $sign;
		$new['CRITERIA_ID'] = $criteria_id;

		$new['DATE_CREATED'] = date(timeformat());
		$new['IGNORED'] = '0';
		$new['POIN_PREV'] = $vnd['PERFORMANCE'];
		switch ($sign) {
			case '+':
				$new['POIN_CURR'] = $new['POIN_PREV'] + $poin;
				break;
			case '-':
				$new['POIN_CURR'] = $new['POIN_PREV'] - $poin;
				break;
			case '=':
				$new['POIN_CURR'] = $poin;
				break;
			default:
				return false;
		}
		$this->insert_custom($new);
		$this->vnd_header->update(array('PERFORMANCE' => $new['POIN_CURR']), $where_vnd);
		return true;
	}

	function update($data, $where) {
		$this->db->where($where);
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

	function get_total_data_by_vendor_performance($where = NULL) {
		$this->db->from('(SELECT VENDOR_CODE, POIN, ROW_NUMBER() OVER (PARTITION BY VENDOR_CODE ORDER BY DATE_CREATED DESC) as NUM FROM '.$this->table.') T1');
		$this->db->join($this->table_vendor." T2", "T1.VENDOR_CODE = T2.VENDOR_NO", 'right outer');
		// $this->db->where('NUM', 1);
		return $this->db->count_all_results();
	}

	function get_total_data_without_filter_by_vendor_performance() {
		$this->db->from('(SELECT VENDOR_CODE, POIN, ROW_NUMBER() OVER (PARTITION BY VENDOR_CODE ORDER BY DATE_CREATED DESC) as NUM FROM '.$this->table.') T1');
		$this->db->join($this->table_vendor." T2", "T1.VENDOR_CODE = T2.VENDOR_NO", 'left');
		// $this->db->where('NUM', 1);
		return  $this->db->count_all($this->table);
	}

	function get_desc($where = NULL,$limit=NULL) {
		$this->db->select("PERF_HIST_ID, POIN_CURR");
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		if (!empty($limit)) {
			$this->db->limit($limit);
		}
		$this->db->order_by('PERF_HIST_ID', 'desc');
		$result = $this->db->get();
		return (array) $result->result_array();
	}

	public function join_vnd_header() {
		$this->db->select('VND_HEADER.VENDOR_NO, VND_HEADER.VENDOR_NAME');
		$this->db->join('VND_HEADER', "VND_HEADER.VENDOR_NO = $this->table.VENDOR_CODE", 'left');
	}

	public function get_vendor($length=0,$start=0,$draw,$opco,$search='') { 

        $subquery1 = "SELECT VENDOR_CODE,max(PERF_HIST_ID) as MAXID FROM VND_PERF_HIST GROUP BY VENDOR_CODE";
		$subquery2 = "SELECT T2.* FROM VND_PERF_HIST T2 INNER JOIN (".$subquery1.") T1 ON T1.MAXID = T2.PERF_HIST_ID";
		$subquery4 = "SELECT ADM_PURCH_GRP.COMPANY_ID,ADM_PURCH_GRP.KEL_PURCH_GRP FROM ADM_PURCH_GRP GROUP BY ADM_PURCH_GRP.KEL_PURCH_GRP,ADM_PURCH_GRP.COMPANY_ID";
		$subquery3 = "SELECT ROWNUM RNUM, T3.PERF_HIST_ID, T3.VENDOR_CODE, T3.DATE_CREATED as DATE_CREATED, 
		T3.KETERANGAN, T3.POIN_ADDED, T3.SIGN, T3.IGNORED, T3.POIN_PREV, T3.POIN_CURR, 
		T3.CRITERIA_ID, T3.TMP_ID, T3.REKAP_ID, VND_HEADER.VENDOR_ID, VND_HEADER.VENDOR_NAME, VND_HEADER.EMAIL_ADDRESS, 
		VND_HEADER.VENDOR_NO, VND_HEADER.STATUS_PERUBAHAN, VND_HEADER.STATUS, VND_HEADER.NEXT_PAGE, VND_HEADER.COMPANYID, ADM_PURCH_GRP.KEL_PURCH_GRP FROM VND_HEADER LEFT JOIN (".$subquery2.") T3 ON T3.VENDOR_CODE = VND_HEADER.VENDOR_NO LEFT JOIN ( ".$subquery4." ) ADM_PURCH_GRP ON ADM_PURCH_GRP.COMPANY_ID = VND_HEADER.COMPANYID WHERE VND_HEADER.STATUS=3 AND ADM_PURCH_GRP.KEL_PURCH_GRP = ".$opco." AND VND_HEADER.VENDOR_NO IS NOT NULL";
		
		if (isset($search)&&!empty($search)&&$search != '') {
			$subquery3.=" AND VND_HEADER.VENDOR_NO LIKE '%".strtoupper($search)."%' OR VND_HEADER.VENDOR_NAME LIKE '%".strtoupper($search)."%'";
		}

        $this->db->select("*");
        $this->db->from("(".$subquery3.")");        
        $query = $this->db->get();
		$totalRecords = $query->num_rows();
		if(isset($length) && $start>-1){			
        	$subquery3.=' AND ROWNUM <= '.($start+$length);        	
        	$this->db->select("*");
        	$this->db->from("(".$subquery3.")");
        	$this->db->where("RNUM >",$start);
        	
        	$query = $this->db->get();
        	// $totalRecord = $query->num_rows();
        }
		
        $data = (array)$query->result_array();
        $result = array(
        	"length"=>$length,
        	"start"=>$start,
            "draw"            => intval($draw), 
            "recordsTotal"    => intval($totalRecords),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        return $result;
    }

    public function get_last_poin_by_period($start,$end,$opco) { 
    	
		$subquery1 = 'SELECT VENDOR_CODE,max(PERF_HIST_ID) as MAXID FROM VND_PERF_HIST WHERE DATE_CREATED BETWEEN \''. $start. '\' and \''. $end. '\'  GROUP BY VENDOR_CODE';
		$subquery2 = 'SELECT T2.* FROM VND_PERF_HIST T2 INNER JOIN ('.$subquery1.') T1 ON T1.MAXID = T2.PERF_HIST_ID';
		$subquery3 = 'SELECT ADM_PURCH_GRP.COMPANY_ID,ADM_PURCH_GRP.KEL_PURCH_GRP FROM ADM_PURCH_GRP GROUP BY ADM_PURCH_GRP.KEL_PURCH_GRP,ADM_PURCH_GRP.COMPANY_ID';

		
        $this->db->select("T3.PERF_HIST_ID, T3.VENDOR_CODE, to_char(T3.DATE_CREATED,'DD-MM-YYYY HH24:MI:SS') as DATE_CREATED, T3.KETERANGAN, T3.POIN_ADDED, T3.SIGN, T3.IGNORED, T3.POIN_PREV, T3.POIN_CURR, T3.CRITERIA_ID, T3.TMP_ID, T3.REKAP_ID, VND_HEADER.VENDOR_ID, VND_HEADER.VENDOR_NAME, VND_HEADER.EMAIL_ADDRESS, VND_HEADER.VENDOR_NO, VND_HEADER.STATUS_PERUBAHAN, VND_HEADER.STATUS, VND_HEADER.NEXT_PAGE, VND_HEADER.COMPANYID, ADM_PURCH_GRP.KEL_PURCH_GRP",false);
        $this->db->from('VND_HEADER');
        $this->db->join('('.$subquery2.') T3','T3.VENDOR_CODE = VND_HEADER.VENDOR_NO','right');    
      	$this->db->join('('.$subquery3.') ADM_PURCH_GRP', 'ADM_PURCH_GRP.COMPANY_ID = VND_HEADER.COMPANYID','inner');    
        $this->db->where('T3.REKAP_ID IS NULL');
        $this->db->where('VND_HEADER.STATUS',3);
        $this->db->where('VND_HEADER.VENDOR_NO IS NOT NULL');
        $this->db->where('ADM_PURCH_GRP.KEL_PURCH_GRP',$opco);
        
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function get_vendor_by_period_ordered($VENDOR_NO,$start,$end){
    	$this->db->select("PERF_HIST_ID, VENDOR_CODE, DATE_CREATED, KETERANGAN, POIN_ADDED, SIGN, IGNORED, POIN_PREV, POIN_CURR, CRITERIA_ID, TMP_ID, REKAP_ID");
		$this->db->where(array('VENDOR_CODE'=>$VENDOR_NO));
		$this->db->where('REKAP_ID IS NULL');
		$this->db->where('DATE_CREATED BETWEEN \''. $start. '\' and \''. $end. '\'');
		$this->db->from($this->table);		
		$this->db->order_by('PERF_HIST_ID', 'asc');
		$result = $this->db->get();
		return (array) $result->result_array();
    }

    public function get_rekap($id_rekap){
		$where['KETERANGAN'] = 'Rekap';
		$where['REKAP_ID'] = $id_rekap;
		return $this->get($where);
	}

	public function get_all_performance($length=0,$start=0,$draw,$opco,$search=''){
		$subquery1 = 'SELECT VENDOR_CODE,max(PERF_HIST_ID) as MAXID FROM VND_PERF_HIST GROUP BY VENDOR_CODE ORDER BY VENDOR_CODE';
		$subquery2 = 'SELECT T2.* FROM VND_PERF_HIST T2 INNER JOIN ('.$subquery1.') T1 ON T1.MAXID = T2.PERF_HIST_ID ORDER BY T2.VENDOR_CODE';
		$subquery4 = 'SELECT ADM_PURCH_GRP.COMPANY_ID,ADM_PURCH_GRP.KEL_PURCH_GRP FROM ADM_PURCH_GRP GROUP BY ADM_PURCH_GRP.KEL_PURCH_GRP,ADM_PURCH_GRP.COMPANY_ID';

		$subquery3 = "SELECT ROWNUM RNUM, T3.PERF_HIST_ID, T3.VENDOR_CODE, T3.DATE_CREATED as DATE_CREATED, T3.KETERANGAN, 
		T3.POIN_ADDED, T3.SIGN, T3.IGNORED, T3.POIN_PREV, T3.POIN_CURR, T3.CRITERIA_ID, T3.TMP_ID, T3.REKAP_ID, 
		VPR.STATUS as STATUS_APPROVAL, VPR.IS_DONE, VND_HEADER.VENDOR_ID, VND_HEADER.VENDOR_NAME, VND_HEADER.EMAIL_ADDRESS, 
		VND_HEADER.VENDOR_NO, VND_HEADER.STATUS_PERUBAHAN, VND_HEADER.STATUS, VND_HEADER.NEXT_PAGE, ADM_PURCH_GRP.KEL_PURCH_GRP FROM VND_HEADER 
		RIGHT JOIN (".$subquery2.") T3 ON T3.VENDOR_CODE = VND_HEADER.VENDOR_NO INNER JOIN ( ".$subquery4." ) ADM_PURCH_GRP ON ADM_PURCH_GRP.COMPANY_ID = VND_HEADER.COMPANYID
		LEFT JOIN VND_PERF_REKAP VPR ON VPR.ID_REKAP=T3.REKAP_ID WHERE VND_HEADER.STATUS=3 AND ADM_PURCH_GRP.KEL_PURCH_GRP = ".$opco." AND VND_HEADER.VENDOR_NO IS NOT NULL";
		
        $this->db->select("*");
        $this->db->from("(".$subquery3.")");
        $query = $this->db->get();
		$totalRecords = $query->num_rows();
		if(isset($length) && $start>-1){			
        	$subquery3.=' AND ROWNUM <= '.($start+$length);        	
        	$this->db->select("*");
        	$this->db->from("(".$subquery3.")");
        	$this->db->where("RNUM >".$start);
        	if ($search.'' != '') {
				$this->db->where("VENDOR_NO LIKE '%".$search."%'");
			}
			// echo $this->db->_compile_select(); 
        	$query = $this->db->get();
        	// $totalRecord = $query->num_rows();
        }
		
        $data = (array)$query->result_array();
        $result = array(
        	"length"=>$length,
        	"start"=>$start,
            "draw"            => intval($draw), 
            "recordsTotal"    => intval($totalRecords),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        return $result;
        
	}

	public function get_vendor_all_performance($VENDOR_NO){
		$this->db->select("H.PERF_HIST_ID, H.VENDOR_CODE, H.DATE_CREATED, H.KETERANGAN, H.POIN_ADDED, H.SIGN, H.IGNORED, H.POIN_PREV, H.POIN_CURR, H.CRITERIA_ID, H.TMP_ID, H.REKAP_ID, VPC.CRITERIA_TRIGGER_BY, VPC.T_OR_V, VPT.EXTERNAL_CODE, VPT.VENDOR_CODE");
		$this->db->where(array('H.VENDOR_CODE'=>$VENDOR_NO));		
		$this->db->from('VND_PERF_HIST H');		
		$this->db->join('VND_PERF_CRITERIA VPC','VPC.ID_CRITERIA=H.CRITERIA_ID','LEFT');
		$this->db->join('VND_PERF_TMP VPT','VPT.PERF_TMP_ID=H.TMP_ID','LEFT');
		$this->db->order_by('H.PERF_HIST_ID', 'asc');
		$result = $this->db->get();
		return (array) $result->result_array();
	}

	public function get_vendor_last_point($VENDOR_NO){
		$this->db->select("POIN_ADDED, POIN_CURR, POIN_PREV, PERF_HIST_ID");
		$this->db->where('VENDOR_CODE',$VENDOR_NO);
		$this->db->where('PERF_HIST_ID = (SELECT MAX(PERF_HIST_ID) FROM VND_PERF_HIST WHERE VENDOR_CODE = '.$VENDOR_NO.')');
		$this->db->from($this->table);
		$result = $this->db->get();
		return (array) $result->result_array();
	}

	public function get_max_id_vendor($VENDOR_NO){
		$this->db->select("max(PERF_HIST_ID) as ID");
		$this->db->from($this->table);
		$this->db->where(array("VENDOR_CODE"=>$VENDOR_NO));
		$query = $this->db->get();
		$data = (array)$query->result_array();
		return $data[0]['ID'];
	}

	public function cek_is_reset($VENDOR_NO,$TGL_CEK,$TGL_CEK_KEMARIN){
		$data_cek = array(
					'VENDOR_CODE'=>$VENDOR_NO,
					'KETERANGAN'=>'Reset Bebas Sanksi',
					'POIN_ADDED'=>0,
					'SIGN'=>'+',
					'IGNORED'=>0,
					'POIN_CURR'=>0,
					'CRITERIA_ID'=>NULL,
					'TMP_ID'=>NULL,
					'REKAP_ID'=>NULL
					);
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where($data_cek);
		$this->db->where("(DATE_CREATED=TO_DATE('".$TGL_CEK_KEMARIN."','DD-MON-YYYY') OR (DATE_CREATED=TO_DATE('".$TGL_CEK."','DD-MON-YYYY')))");
		$res=$this->db->get();
		$res=$res->result_array();
		if(count($res)>0){
			return true;
		}else{
			return false;
		}
	}
	
}
<?php
class vnd_perf_sanction extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "VND_PERF_SANCTION";
	}

	public function get($where = NULL) {	
		$this->db->select("VND_PERF_SANCTION.SANCTION_ID, VND_PERF_SANCTION.VENDOR_NO, VND_PERF_SANCTION.START_DATE, VND_PERF_SANCTION.END_DATE, VND_PERF_SANCTION.REASON, VND_PERF_SANCTION.STATUS");
		$this->db->from($this->table);
		if(isset($where)&&!empty($where)){
			$this->db->where($where);
		}
		
		$this->db->order_by('VND_PERF_SANCTION.SANCTION_ID', 'DESC');
		// die($this->db->_compile_select());
		$result = $this->db->get();
		return $result->result_array();
	}

	public function join_m_sanction(){
		$this->db->select("M.SANCTION_NAME,M.DURATION,M.CATEGORY");
		$this->db->join("VND_PERF_M_SANCTION M","M.M_SANCTION_ID=VND_PERF_SANCTION.M_SANCTION_ID","INNER");		
	}

	public function join_vnd_header(){
		$this->db->select("H.VENDOR_NO,H.VENDOR_NAME,H.COMPANYID, ADM_PURCH_GRP.KEL_PURCH_GRP");
		$this->db->join("VND_HEADER H","H.VENDOR_NO=VND_PERF_SANCTION.VENDOR_NO","LEFT");
		$subquery1 = 'SELECT ADM_PURCH_GRP.COMPANY_ID,ADM_PURCH_GRP.KEL_PURCH_GRP FROM ADM_PURCH_GRP GROUP BY ADM_PURCH_GRP.KEL_PURCH_GRP,ADM_PURCH_GRP.COMPANY_ID';
      	$this->db->join('('.$subquery1.') ADM_PURCH_GRP', 'ADM_PURCH_GRP.COMPANY_ID = H.COMPANYID','INNER');
	}

	public function get_all_vendor_sanction($opco,$status=null){
		$this->join_m_sanction();
		$this->join_vnd_header();
		if(isset($status)&&!empty($status)){
			$where['VND_PERF_SANCTION.STATUS']=$status;
		}else{
			$where=null;
		}
		$where['ADM_PURCH_GRP.KEL_PURCH_GRP']=$opco;
		return $this->get($where);
	}

	public function get_all_detail_vendor_sanction($vendor_no,$status=null){
		$this->join_m_sanction();
		$this->join_vnd_header();
		$where['H.VENDOR_NO']=$vendor_no;
		if(!empty($status)){
			$where['VND_PERF_SANCTION.STATUS']=$status;
		}
		return $this->get($where);
	}

	public function insert($data) {		
		foreach ($data as $key => $value) {
			if($key=='START_DATE'){
				$this->db->set('START_DATE',"TO_DATE('".$value."','DD-MON-YYYY HH.MI.SS AM')",FALSE);
			}
			else if($key=='END_DATE'){
				$this->db->set('END_DATE',"TO_DATE('".$value."','DD-MON-YYYY HH.MI.SS AM')",FALSE);
			}else{
				$this->db->set($key,$value,FALSE);
			}
		}
		if($this->db->insert($this->table)){
			return true;
		}else{
			return false;
		}
	}

	public function insert_batch($data) {
		$this->db->insert_batch($this->table, $data);
	}

	public function update($set = NULl, $where = NULL) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function delete($id){
		$this->db->where('SANCTION_ID', $id);
		$this->db->delete($this->table);
	}

	/* function untuk memeriksa apakah ada sanksi yang terkena sebelumnya.
	*  Kondisi: jika ada sanksi baru yang lebih lama durasinya dari sanksi yang lama maka durasi akan ditambahkan
	*			jika sanksi yang sebelumnya lebih lama maka tidak perlu ditambahkan durasinya.
	*/
	public function cek_and_insert($data){		
		$this->db->select("END_DATE,START_DATE,SANCTION_ID");
		$this->db->from($this->table);
		$this->db->where("STATUS = 1 AND START_DATE <= TO_DATE('".$data['START_DATE']."','DD-MON-YYYY HH.MI.SS AM') AND END_DATE >= TO_DATE('".$data['START_DATE']."','DD-MON-YYYY HH.MI.SS AM') AND VENDOR_NO=".$data['VENDOR_NO']);
		$res = $this->db->get();
		$res = $res->result_array();		
		if(count($res)>0){
			if(($res[0]['END_DATE']-$res[0]['START_DATE'])<($data['END_DATE']-$data['START_DATE'])){
				$data['START_DATE']=$res[0]['START_DATE'];
				$this->update(array('STATUS'=>0),array('SANCTION_ID'=>$res[0]['SANCTION_ID']));			
			}else{
				$data['STATUS']=0;		
			}
		}
		if($this->insert($data)){
			return true;
		}

	}

	public function cek_sanksi_vendor($VENDOR_NO,$TGL_ACTION){
		$this->db->select("END_DATE,START_DATE,SANCTION_ID");
		$this->db->from($this->table);
		$this->db->where("STATUS = 1 AND START_DATE <= TO_DATE('".$TGL_ACTION."','DD-MON-YYYY HH.MI.SS AM') AND END_DATE >= TO_DATE('".$TGL_ACTION."','DD-MON-YYYY HH.MI.SS AM') AND VENDOR_NO=".$VENDOR_NO);
		$res=$this->db->get();
		$res=$res->result_array();
		if(count($res)>0){
			return true;
		}else{
			return false;
		}
	}

	public function cek_bebas_sanksi($VENDOR_NO,$TGL_ACTION){		
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where("(STATUS = 0 OR (END_DATE < TO_DATE('".$TGL_ACTION."','DD-MON-YYYY'))) AND VENDOR_NO=".$VENDOR_NO);
		$res=$this->db->get();
		$res=$res->result_array();
		if(count($res)>0){
			return true;
		}else{
			return false;
		}
	}

	public function get_all_vendor($opco,$prod){
		if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
			$opco = 'IN(\'7000\',\'2000\',\'5000\')';
		} else {
			$opco = '='.$opco.'';
		}
		
		if ($prod == '1') {
			$this->db->select('M.SANCTION_NAME, M.DURATION, M.CATEGORY, H.VENDOR_NO, H.VENDOR_NAME, H.COMPANYID, VND_PERF_SANCTION.SANCTION_ID, VND_PERF_SANCTION.VENDOR_NO, VND_PERF_SANCTION.START_DATE, VND_PERF_SANCTION.END_DATE, VND_PERF_SANCTION.REASON, VND_PERF_SANCTION.STATUS 
				FROM VND_PERF_SANCTION 
				INNER JOIN VND_PERF_M_SANCTION M ON M.M_SANCTION_ID=VND_PERF_SANCTION.M_SANCTION_ID
				LEFT JOIN VND_HEADER H ON H.VENDOR_NO=VND_PERF_SANCTION.VENDOR_NO
				INNER JOIN (SELECT VENDOR_ID FROM VND_PRODUCT WHERE PRODUCT_TYPE = \'GOODS\' GROUP BY VENDOR_ID) VP ON H.VENDOR_ID=VP.VENDOR_ID
				WHERE H.VENDOR_ID NOT IN(SELECT vd.VENDOR_ID FROM VND_HEADER vd INNER JOIN (SELECT VENDOR_ID FROM VND_PRODUCT WHERE PRODUCT_TYPE = \'SERVICES\' 
				GROUP BY VENDOR_ID) VS ON VS.VENDOR_ID=vd.VENDOR_ID INNER JOIN (SELECT VENDOR_ID FROM VND_PRODUCT WHERE PRODUCT_TYPE = \'GOODS\' GROUP BY VENDOR_ID) VG ON VG.VENDOR_ID=vd.VENDOR_ID) AND H.COMPANYID '.$opco.' ORDER BY H.VENDOR_NO', false);
		} else if ($prod == '2') {
			$this->db->select('M.SANCTION_NAME, M.DURATION, M.CATEGORY, H.VENDOR_NO, H.VENDOR_NAME, H.COMPANYID, VND_PERF_SANCTION.SANCTION_ID, VND_PERF_SANCTION.VENDOR_NO, VND_PERF_SANCTION.START_DATE, VND_PERF_SANCTION.END_DATE, VND_PERF_SANCTION.REASON, VND_PERF_SANCTION.STATUS 
				FROM VND_PERF_SANCTION 
				INNER JOIN VND_PERF_M_SANCTION M ON M.M_SANCTION_ID=VND_PERF_SANCTION.M_SANCTION_ID
				LEFT JOIN VND_HEADER H ON H.VENDOR_NO=VND_PERF_SANCTION.VENDOR_NO 
				INNER JOIN (SELECT VENDOR_ID FROM VND_PRODUCT WHERE PRODUCT_TYPE = \'SERVICES\' GROUP BY VENDOR_ID) VP ON H.VENDOR_ID=VP.VENDOR_ID
				WHERE H.VENDOR_ID NOT IN(SELECT vd.VENDOR_ID FROM VND_HEADER vd INNER JOIN (SELECT VENDOR_ID FROM VND_PRODUCT WHERE PRODUCT_TYPE = \'SERVICES\' GROUP BY VENDOR_ID) VS ON VS.VENDOR_ID=vd.VENDOR_ID INNER JOIN (SELECT VENDOR_ID FROM VND_PRODUCT WHERE PRODUCT_TYPE = \'GOODS\' GROUP BY VENDOR_ID) VG ON VG.VENDOR_ID=vd.VENDOR_ID) AND H.COMPANYID '.$opco.' ORDER BY H.VENDOR_NO', false);
		} else if ($prod == '3') {
			$this->db->select('M.SANCTION_NAME, M.DURATION, M.CATEGORY, H.VENDOR_NO, H.VENDOR_NAME, H.COMPANYID, VND_PERF_SANCTION.SANCTION_ID, VND_PERF_SANCTION.VENDOR_NO, VND_PERF_SANCTION.START_DATE, VND_PERF_SANCTION.END_DATE, VND_PERF_SANCTION.REASON, VND_PERF_SANCTION.STATUS 
				FROM VND_PERF_SANCTION 
				INNER JOIN VND_PERF_M_SANCTION M ON M.M_SANCTION_ID=VND_PERF_SANCTION.M_SANCTION_ID
				LEFT JOIN VND_HEADER H ON H.VENDOR_NO=VND_PERF_SANCTION.VENDOR_NO
				INNER JOIN (SELECT VENDOR_ID FROM VND_PRODUCT WHERE PRODUCT_TYPE = \'GOODS\' GROUP BY VENDOR_ID) VP ON H.VENDOR_ID=VP.VENDOR_ID
				INNER JOIN (SELECT VENDOR_ID FROM VND_PRODUCT WHERE PRODUCT_TYPE = \'SERVICES\' GROUP BY VENDOR_ID) VP ON H.VENDOR_ID=VP.VENDOR_ID
				WHERE H.COMPANYID '.$opco.' ORDER BY H.VENDOR_NO', false);
		} else {
			$this->db->select('M.SANCTION_NAME, M.DURATION, M.CATEGORY, H.VENDOR_NO, H.VENDOR_NAME, H.COMPANYID, VND_PERF_SANCTION.SANCTION_ID, VND_PERF_SANCTION.VENDOR_NO, VND_PERF_SANCTION.START_DATE, VND_PERF_SANCTION.END_DATE, VND_PERF_SANCTION.REASON, VND_PERF_SANCTION.STATUS 
				FROM VND_PERF_SANCTION 
				INNER JOIN VND_PERF_M_SANCTION M ON M.M_SANCTION_ID=VND_PERF_SANCTION.M_SANCTION_ID
				LEFT JOIN VND_HEADER H ON H.VENDOR_NO=VND_PERF_SANCTION.VENDOR_NO
				WHERE H.COMPANYID '.$opco.' ORDER BY H.VENDOR_NO', false);
		}
		
		$result = $this->db->get();
		return $result->result_array(); 
	}
}
?>
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class prc_tender_main extends CI_Model {

	protected $table = 'PRC_TENDER_MAIN';
	protected $all_field = 'PRC_TENDER_MAIN.PTM_NUMBER,PRC_TENDER_MAIN.IS_JASA, PTM_REQUESTER_NAME, TO_CHAR(PTM_CREATED_DATE, \'DD-MM-YYYY\') AS PTM_CREATED_DATE, PTM_SUBJECT_OF_WORK, PTM_STATUS, TO_CHAR(PTM_COMPLETED_DATE, \'DD-MM-YYYY\') AS PTM_COMPLETED_DATE, PTM_DEPT_NAME, PTM_SUBPRATENDER, PTM_PRATENDER, PTM_COUNT_RETENDER, PTM_RFQ_TYPE, PTM_REQUESTER_ID, PTM_COMPANY_ID, PTM_PGRP, PTM_ASSIGNMENT, PTM_CURR, REJECTED_AT, REJECTED_BY, IS_EVALUATED, PRC_TENDER_MAIN.KEL_PLANT_PRO, SAMPUL, PRC_TENDER_MAIN.JUSTIFICATION, PRC_TENDER_MAIN.BATAS_VENDOR_HARGA, TO_CHAR(PRC_TENDER_MAIN.BATAS_VENDOR_HARGA, \'YYYY-MM-DD HH24:MI:SS\') AS BATAS_VENDOR_HARGA_RG';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL, $select = false, $role = NULL, $all = false) {
		$this->db->distinct();
		if (!$select) $select = $this->all_field;
		$this->db->select($select, false);
		if (!empty($where)) {
			$this->db->where($where);
		}
		
			//sementara ditampilkan status reject & retender rg 08062016
		//YANG DIBATALKAN GABISA DILIHAT LAGI
		// if (!$all) {
		// 	$this->db->where(array('PTM_STATUS >' => 0));
		// }

		// $this->db->order_by('PTM_CREATED_DATE', 'desc');
		$this->join_app_process();
		$this->join_app_process_master();
		$this->db->from($this->table);
		$result = $this->db->get();
		// echo $this->db->last_query();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
	}

	public function join_app_process() {
		/* Ini yang lama, masih pakai APP_PROCESS_MASTER /
		$this->db->join('APP_PROCESS_MASTER', 'PRC_TENDER_MAIN.PTM_STATUS = APP_PROCESS_MASTER.PROCESS_MASTER_ID', 'left');
		$this->db->select('PROCESS_NAME');
		//*/
		$this->db->select('APP_PROCESS.NAMA_BARU AS PROCESS_NAME', false);
		$this->db->select('APP_PROCESS.NAMA_BARU, APP_PROCESS.PROCESS_MASTER_ID');
		$this->db->select('ASSIGNMENT, IS_NEGO, IDENTITAS_PROCCESS, IS_ASSIGN, APP_PROCESS.JUSTIFICATION');
		
		$where = 'PRC_TENDER_MAIN.PTM_STATUS = APP_PROCESS.CURRENT_PROCESS';
		$where .= ' AND PRC_TENDER_MAIN.KEL_PLANT_PRO = APP_PROCESS.KEL_PLANT_PRO';
		$where .= ' AND PRC_TENDER_MAIN.SAMPUL = APP_PROCESS.TIPE_SAMPUL';
		$where .= ' AND PRC_TENDER_MAIN.JUSTIFICATION = APP_PROCESS.JUSTIFICATION';
		$this->db->join('APP_PROCESS', $where, 'left');
	}

	function get_holder($ptm) {
		$this->db->join('PRC_PROCESS_HOLDER', 'PRC_PROCESS_HOLDER.PTM_NUMBER = PRC_TENDER_MAIN.PTM_NUMBER', 'inner');
		$this->db->join('ADM_EMPLOYEE', 'ADM_EMPLOYEE.ID = PRC_PROCESS_HOLDER.EMP_ID', 'inner');
		$this->db->where('PRC_TENDER_MAIN.PTM_NUMBER', $ptm);
		return $this->db->get($this->table)->result_array();
	}

	public function get_count_assign($assignment) {
		$this->db->select('PTM_ASSIGNMENT');
		$this->db->select('COUNT(PTM_ASSIGNMENT) AS HITUNG');
		$this->db->group_by('PTM_ASSIGNMENT');
		$this->db->where('PTM_ASSIGNMENT', $assignment);
		$this->db->where('PTM_COMPLETED_DATE', null);
		$retval = $this->db->get($this->table)->row_array();
		// echo ''
		return $retval;
	}

	public function join_latest_activity($cron_job = null) {
		$this->db->select('TO_CHAR(J.PTC_END_DATE, \'YYYY-MM-DD HH24:MI:SS\') AS PTC_END_DATE, PR.PPI_PRNO', false);
		$this->db->join('(SELECT T1.PTM_NUMBER, MAX(T1.PTC_END_DATE) AS PTC_END_DATE FROM PRC_TENDER_COMMENT T1
			GROUP BY T1.PTM_NUMBER) J', "$this->table.PTM_NUMBER = J.PTM_NUMBER", 'left');
		$this->db->join('(SELECT LISTAGG(S.PPI_PRNO, \', \') WITHIN GROUP (ORDER BY S.PPI_PRNO) AS PPI_PRNO , S.PTM_NUMBER
					FROM (
						SELECT distinct PRI.PPI_PRNO, S.PTM_NUMBER
						FROM PRC_TENDER_MAIN S
						INNER JOIN PRC_TENDER_ITEM PTI on PTI.PTM_NUMBER=S.PTM_NUMBER
						INNER JOIN PRC_PR_ITEM PRI ON PTI.PPI_ID=PRI.PPI_ID
					) S GROUP BY S.PTM_NUMBER) PR', "$this->table.PTM_NUMBER = PR.PTM_NUMBER", 'left');
		if(!$cron_job){
			$this->db->order_by('PTC_END_DATE', 'desc');
		}
	}

	function get_active_job($emp_id) {
		$this->db->where('PTM_STATUS >', '0');
		$this->join_holder($emp_id);
		return $this->get();
	}

	function join_holder($emp_id) {
		$this->db->join('PRC_PROCESS_HOLDER', 'PRC_TENDER_MAIN.PTM_NUMBER = PRC_PROCESS_HOLDER.PTM_NUMBER', 'inner');
		$this->db->where(array('EMP_ID' => $emp_id));
	}


	function join_auction($paqh = null){
		$this->db->select("$this->table.*, PRC_AUCTION_QUO_HEADER.PAQH_ID, PRC_AUCTION_QUO_HEADER.PAQH_DECREMENT_VALUE, PRC_AUCTION_QUO_HEADER.PAQH_PRICE_TYPE, PRC_AUCTION_QUO_HEADER.PAQH_HPS, PRC_AUCTION_QUO_HEADER.PAQH_AUC_START, PRC_AUCTION_QUO_HEADER.PAQH_AUC_END, PRC_AUCTION_QUO_HEADER.PAQH_LOCATION, PRC_AUCTION_QUO_HEADER.PAQH_OPEN_STATUS, PRC_AUCTION_QUO_HEADER.PAQH_SUBJECT_OF_WORK ");
		$this->db->from($this->table);
		$this->db->join('PRC_AUCTION_QUO_HEADER', "$this->table.PTM_NUMBER = PRC_AUCTION_QUO_HEADER.PTM_NUMBER", 'left');
		$this->where_evaluated();
		
		$this->db->where(array('PAQH_ID' => $paqh));

		$query = $this->db->get();
		$result = $query->result_array();
		$output = array();

		foreach ($result as $key => $row) {
			$PTM_NUMBER = $row['PTM_NUMBER'];
			$sql = "SELECT COUNT(PRC_TENDER_ITEM.TIT_STATUS) as jumlah FROM PRC_TENDER_ITEM WHERE PRC_TENDER_ITEM.TIT_STATUS = 4 AND PRC_TENDER_ITEM.PTM_NUMBER = ?"; 
			$query = $this->db->query($sql, array($PTM_NUMBER));
			$count = $query->row_array();
			if($count["JUMLAH"] > 0) {
				$output[] = $result[$key];
			}
		}
		return $output;
	}

	public function join_nego($nego_done = false, $nego_done_not_in = false) {
		if ($nego_done !== false) {
			// $this->db->where('PRC_TENDER_NEGO.NEGO_DONE', $nego_done);
		}
		$wherenotin = '';
		if ($nego_done_not_in !== false) {
			// $this->db->where_not_in('PRC_TENDER_NEGO.NEGO_DONE', (array) $nego_done_not_in);
			$implotan = implode(", ", (array) $nego_done_not_in);
			$wherenotin = ' where PRC_TENDER_NEGO.NEGO_DONE NOT IN ('.$implotan.')';
		}
		$this->db->select('PRC_TENDER_NEGO.*');
		return $this->db->join('(select * FROM PRC_TENDER_NEGO '.$wherenotin.') PRC_TENDER_NEGO', 'PRC_TENDER_NEGO.PTM_NUMBER = PRC_TENDER_MAIN.PTM_NUMBER', 'left');
	}

	public function get_wherehas_titstatus($tit_status) {
		$this->db->select("$this->table.*");
		$this->db->from($this->table);
		$this->where_evaluated();

		$query = $this->db->get();
		$result = $query->result_array();

		return $this->filter_wherehas_titstatus($result, $tit_status);
	}

	public function filter_wherehas_titstatus($ptm_array, $tit_status) {
		// var_dump($this->db->last_query());
		if (count($ptm_array) <= 0) {
			return $ptm_array;
		}
		$output = array();
		foreach ($ptm_array as $key => $row) {
			$PTM_NUMBER = $row['PTM_NUMBER'];
			$sql = "SELECT COUNT(PRC_TENDER_ITEM.TIT_ID) as jumlah FROM PRC_TENDER_ITEM WHERE PRC_TENDER_ITEM.TIT_STATUS = $tit_status AND PRC_TENDER_ITEM.PTM_NUMBER = ?"; 
			$query = $this->db->query($sql, array($PTM_NUMBER));
			$count = $query->row_array();
			if($count["JUMLAH"] > 0){
				$output[] = $row;
			}
		}
		return $output;
	}

	public function where_evaluated($evaluated = null) {
		$this->db->where('IS_EVALUATED IS NOT NULL');
		if ($evaluated != null) {
			$this->db->where(array('IS_EVALUATED' => $evaluated));
		}
	}

	public function where_assignment($value) {
		$this->db->where('PTM_ASSIGNMENT', $value);
	}

	function join_assign_employee() {
		$this->db->select("ADM_EMPLOYEE.FULLNAME");
		$this->db->join('ADM_EMPLOYEE', 'ADM_EMPLOYEE.ID = PRC_TENDER_MAIN.PTM_ASSIGNMENT', 'inner');
	}

	/**
	 * @param $value = string "'221','222'"
	 */
	public function where_pgrp_in($value) {
		$this->db->where("PTM_PGRP IN ($value)");
	}

	public function where_req_in($value) {
		$this->db->where("PPR_REQUESTIONER like '%".$value."%'");
	}

	public function join_prItem($is_jasa = false) {
		$this->db->select('PRC_TENDER_ITEM.PTM_NUMBER');
		$this->db->join('PRC_TENDER_ITEM', 'PRC_TENDER_MAIN.PTM_NUMBER = PRC_TENDER_ITEM.PTM_NUMBER', 'left');
		// $this->db->group_by('PTM_NUMBER');
	}

	public function join_pr_req($is_jasa = false) {
		$this->db->select('PRC_PURCHASE_REQUISITION.PPR_PRNO');
		$this->db->join('PRC_PR_ITEM', 'PRC_TENDER_ITEM.PPI_ID = PRC_PR_ITEM.PPI_ID', 'left', null);
		$this->db->join('PRC_PURCHASE_REQUISITION', 'PRC_PR_ITEM.PPI_PRNO = PRC_PURCHASE_REQUISITION.PPR_PRNO', 'left', null);
		// $this->db->group_by('PPR_PRNO');
	}

	public function where_kel_plant_pro($kel_plant_pro) {
		$this->db->where(array('PRC_TENDER_MAIN.KEL_PLANT_PRO' => $kel_plant_pro));
	}

	public function where_assignable($is_assign = 1) {
		$this->db->where(array('APP_PROCESS.IS_ASSIGN' => $is_assign));
	}

	function with_process_url() {
		$this->db->select('APP_PROCESS.PROCESS_MASTER_ID AS APP_URL', false);
	}

	function ptm($ptm) {
		return $this->get(array('PRC_TENDER_MAIN.PTM_NUMBER' => $ptm));
	}

	function get_id() {
		$this->db->select_max('PTM_NUMBER','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function insert_single($data) {
		return $this->db->insert($this->table, $data);
	}

	function updateByPtm($ptm, $set) {
		$this->db->where(array('PTM_NUMBER' => $ptm));
		return $this->db->update($this->table, $set);
	}
	
	
	//KHUSUS MONITORING PRC
	function total_row($q) {
		$query = $this->db->query($q);
		return $query->num_rows(); 
	}
	function grid_view($q) {
		//$this->db->query($q);
		return $this->db->query($q);
	}

	function join_prep() {
		$this->db->select('TO_CHAR(PRC_TENDER_PREP.PTP_REG_CLOSING_DATE, \'YYYY-MM-DD HH24:MI:SS\') AS PTP_REG_CLOSING_DATE, TO_CHAR(PRC_TENDER_MAIN.BATAS_VENDOR_HARGA, \'YYYY-MM-DD HH24:MI:SS\') AS BATAS_VENDOR_HARGA_VER', false);
		$this->db->join('PRC_TENDER_PREP', 'PRC_TENDER_PREP.PTM_NUMBER = PRC_TENDER_MAIN.PTM_NUMBER', 'inner');
	}

	function status($statusnya){
		$this->db->where("PRC_TENDER_MAIN.PTM_STATUS >= '$statusnya' ");		
	}

	public function orderName(){
		$this->db->distinct();
		$this->db->select('ADM_EMPLOYEE.ID,ADM_EMPLOYEE.FULLNAME,ADM_EMPLOYEE.EMAIL,PRC_TENDER_MAIN.PTM_SUBPRATENDER,PRC_TENDER_MAIN.PTM_PRATENDER,PRC_TENDER_MAIN.PTM_SUBJECT_OF_WORK,PRC_TENDER_MAIN.PTM_PGRP');
		$this->db->join('PRC_PROCESS_HOLDER', 'PRC_TENDER_MAIN.PTM_NUMBER = PRC_PROCESS_HOLDER.PTM_NUMBER', 'inner');
		$this->db->join('ADM_EMPLOYEE', 'ADM_EMPLOYEE.ID = PRC_PROCESS_HOLDER.EMP_ID', 'inner');
		$this->db->where('PRC_TENDER_MAIN.PTM_STATUS >', '0');
		$this->db->order_by('ADM_EMPLOYEE.ID', 'asc');
		$this->db->order_by('PTC_END_DATE', 'desc');

		$this->join_app_process();
		$this->db->from($this->table);
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
	}

	function join_app_process_master() {
		$this->db->select("APP_PROCESS_MASTER.PROCESS_MASTER_ID AS MASTER_ID");
		$this->db->join('APP_PROCESS_MASTER', 'APP_PROCESS.PROCESS_MASTER_ID = APP_PROCESS_MASTER.APP_URL', 'left');
	}

	function proses_master_id($status){
		$this->db->where("APP_PROCESS_MASTER.PROCESS_MASTER_ID >= '$status' ");		
	}

	function master_id($status){
		$this->db->where("(APP_PROCESS_MASTER.PROCESS_MASTER_ID >= '$status' ");		
	}

	function status_ptm($status){
		$this->db->or_where("PRC_TENDER_MAIN.PTM_STATUS <= '$status' )");		
	}

	function join_evaluator() {
		$this->db->select("PRC_EVALUATOR.*");
		$this->db->join('PRC_EVALUATOR', 'PRC_EVALUATOR.PTM_NUMBER = PRC_TENDER_MAIN.PTM_NUMBER', 'left');
	}

	function where_evaluator($id){
		$this->db->where(array('PRC_EVALUATOR.EMP_ID' => $id));
	}

	function get_ece() {
		$this->db->distinct();
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('ADM_EMPLOYEE', 'ADM_EMPLOYEE.ID = PRC_TENDER_MAIN.PTM_ASSIGNMENT', 'inner');
		$this->db->join('(SELECT TRIM (REGEXP_SUBSTR (PE.EC_ID, \'[^,]+\', 1)) EC_ID, PE.PTM_NUMBER
							FROM
							(
								SELECT
									LISTAGG (S.EC_ID, \', \') WITHIN GROUP (ORDER BY S.EC_ID) AS EC_ID, S.PTM_NUMBER, S.EC_ID_GROUP
									FROM
									(
										SELECT DISTINCT	EC_ID, PTM_NUMBER, EC_ID_GROUP
										FROM PRC_ECE_CHANGE
									) S GROUP BY S.PTM_NUMBER, S.EC_ID_GROUP
							) PE
						) PEC', "PRC_TENDER_MAIN.PTM_NUMBER = PEC.PTM_NUMBER", 'inner');
		$this->db->join('PRC_ECE_CHANGE', 'PRC_ECE_CHANGE.EC_ID = PEC.EC_ID', 'inner');		
		$this->db->order_by('PRC_ECE_CHANGE.CREATED_AT', 'desc');
		$result = $this->db->get();		
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
	}

	function user_approv($id) {
		$this->db->where(array('PRC_ECE_CHANGE.USER_APPROVAL' => $id));
	}

	function ppr_assignee($id){
		$this->db->where(array('PRC_ECE_CHANGE.PPR_ASSIGNEE' => $id));
	}

	function status_ece($status){
		$this->db->where_in('STATUS_APPROVAL', $status);
	}

}
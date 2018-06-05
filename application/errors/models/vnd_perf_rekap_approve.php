<?php
class vnd_perf_rekap_approve extends MY_Model
{
	public $primary_key = 'ID_REKAP_APPROVE';
	public $table = 'VND_PERF_REKAP_APPROVE';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		parent::__construct();
	}

	function get($where = NULL,$limit=NULL,$offset=NULL) {
		$this->db->select("VPRA.ID_REKAP_APPROVE,VPRA.ID_REKAP, VPRA.APPROVED_BY, VPRA.APPROVED_DATE, VPRA.URUTAN, VPRA.STATUS");
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table." VPRA");
		if (!empty($limit)) {
			if (!empty($offset)) {
				$this->db->limit($limit,$offset);
			}
			else {
				$this->db->limit($limit);
			}
		}
		$this->db->order_by('ID_REKAP_APPROVE', 'asc');
		$result = $this->db->get();
		return (array) $result->result_array();
	}


	/*
	for insert record
	parameter:
	$data = array(column=>data)
	*/
	public function insert($data){		
		if($this->db->insert($this->table,$data)) {			
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	/*
	for update record
	parameter: 
	$data = array(column=>data)
	$where = array(column=>where data)
	*/
	function update($data, $where) {
		$this->db->where($where);
		if($this->db->update($this->table, $data)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function join_HEADER(){
		$this->db->select('VND_HEADER.VENDOR_ID, VND_HEADER.VENDOR_NAME, VND_HEADER.EMAIL_ADDRESS, VND_HEADER.VENDOR_NO, VND_HEADER.STATUS_PERUBAHAN, VND_HEADER.STATUS, VND_HEADER.NEXT_PAGE');
		$this->db->join('VND_HEADER','VND_HEADER.VENDOR_NO = VPR.VENDOR_NO','left');
	}

	public function join_VPR(){
		$this->db->select("VPR.ID_REKAP,VPR.VENDOR_NO,VPR.VALUE,VPR.REASON, VPR.STATUS, VPR.REKAP_DATE as DATE_CREATED, START_DATE, END_DATE");
		$this->db->join('VND_PERF_REKAP VPR','VPR.ID_REKAP=VPRA.ID_REKAP','RIGHT');
	}

	public function join_VPH(){
		$this->db->select("VPH.PERF_HIST_ID, VPH.VENDOR_CODE, VPH.DATE_CREATED, VPH.KETERANGAN, VPH.POIN_ADDED, VPH.SIGN, VPH.IGNORED, VPH.POIN_PREV, VPH.POIN_CURR, VPH.CRITERIA_ID, VPH.TMP_ID, VPH.REKAP_ID");
		$this->db->join('VND_PERF_HIST VPH','VPH.REKAP_ID=VPRA.ID_REKAP','INNER');
		$this->db->order_by('VPH.PERF_HIST_ID','ASC');
	}

	public function get_non_approve($employee_id){		
		$this->join_VPR();
		$this->join_HEADER();		
		return $this->get(array('APPROVED_BY'=>$employee_id,'VPRA.STATUS'=>0));
	}

	public function get_detail_by_id($ID_REKAP_APPROVE){
		$this->join_VPH();
		return $this->get(array('ID_REKAP_APPROVE'=>$ID_REKAP_APPROVE,'VPH.CRITERIA_ID IS NOT NULL'=>NULL));
	}
}
?>
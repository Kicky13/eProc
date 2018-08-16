<?php
class vnd_perf_sanction_approve extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "VND_PERF_SANCTION_APPROVE";
	}

	public function get($where = NULL) {	
		$this->db->select("VND_PERF_SANCTION_APPROVE.ID_SANCTION_APPROVE,
							VND_PERF_SANCTION_APPROVE.SANCTION_ID,
							VND_PERF_SANCTION_APPROVE.APPROVED_BY,
							VND_PERF_SANCTION_APPROVE.APPROVED_DATE,
							VND_PERF_SANCTION_APPROVE.URUTAN,
							VND_PERF_SANCTION_APPROVE.ALASAN,
							VND_PERF_SANCTION_APPROVE.STATUS");
		$this->db->from($this->table);
		if(isset($where)&&!empty($where)){
			$this->db->where($where);
		}
		$this->db->order_by('ID_SANCTION_APPROVE','ASC');
		$result = $this->db->get();
		return $result->result_array();
	}

	public function insert($data) {
		foreach ($data as $key => $value) {
			if($key=='APPROVED_DATE'){
				$this->db->set('APPROVED_DATE',"TO_DATE('".$value."','DD-MON-YYYY HH.MI.SS AM')",FALSE);			
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

	public function update($set = NULL, $where = NULL) {
		foreach ($set as $key => $value) {
			if($key=='APPROVED_DATE'){
				$this->db->set('APPROVED_DATE',"TO_DATE('".$value."','DD-MON-YYYY HH.MI.SS AM')",FALSE);			
			}else{
				$this->db->set($key,$value,FALSE);
			}
		}
		$this->db->where($where);
		return $this->db->update($this->table);
	}

	public function delete($id){
		$this->db->where('SANCTION_ID', $id);
		$this->db->delete($this->table);
	}

	public function list_sanction_approve($urutan,$opco){
		if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
			$whereopco = 'IN(2000,5000,7000)';
		} else {
			$whereopco = 'IN('.$opco.')';
		}

		$this->db->select('h.VENDOR_NO,h.VENDOR_ID,h.VENDOR_NAME,h.COMPANYID,(CASE WHEN "vpsa"."STATUS"=0 THEN \'SANCTION APPROVAL\' ELSE \'SANCTION APPROVED\' END) AS STATUS,APPROVED_DATE');
		$this->db->from($this->table.' "vpsa"');
		$this->db->where('h.COMPANYID '.$whereopco.'');
		$this->db->where(array('vpsa.URUTAN'=>$urutan,'vpsa.STATUS'=>0));
		$this->db->join('VND_PERF_SANCTION "vps"','vps.SANCTION_ID=vpsa.SANCTION_ID','inner');
		$this->db->join('VND_HEADER "h"','h.VENDOR_NO=vps.VENDOR_NO','left');
		$result = $this->db->get();
		return $result->result_array();
	}

	public function list_sanction_approve_1($urutan){

		$this->db->select('h.VENDOR_NO,h.VENDOR_ID,h.VENDOR_NAME,h.COMPANYID,(CASE WHEN "vpsa"."STATUS"=0 THEN \'SANCTION APPROVAL\' ELSE \'SANCTION APPROVED\' END) AS STATUS,APPROVED_DATE');
		$this->db->from($this->table.' "vpsa"');
		$this->db->where(array('vpsa.URUTAN'=>$urutan,'vpsa.STATUS'=>0));
		$this->db->join('VND_PERF_SANCTION "vps"','vps.SANCTION_ID=vpsa.SANCTION_ID','inner');
		$this->db->join('VND_HEADER "h"','h.VENDOR_NO=vps.VENDOR_NO','left');
		$result = $this->db->get();
		return $result->result_array();
	}

	public function join_employe(){
		$this->db->select('ADM_EMPLOYEE.FULLNAME');
		$this->db->join('ADM_EMPLOYEE', "ADM_EMPLOYEE.ID = $this->table.APPROVED_BY", 'inner');
	}
}
?>
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class vendor_employe extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "VND_MS_PROSES";
	}

	public function insert($data) {
		return $this->db->insert($this->table, $data);
	}

	public function update($data, $where) {
		$this->db->where($where);
		return $this->db->update($this->table, $data);
	}

	public function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}

	public function get_ms() {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('AKTIF','1');
		$result = $this->db->get();
		return $result->result_array();
	}

	public function join_adm_company(){
		$this->db->join('ADM_COMPANY', 'ADM_COMPANY.COMPANYID = VND_MS_PROSES.COMPANYID', 'inner');

	}

	public function getemplo($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('EMP_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function cekvendor($id) {
		$this->db->select('STATUS_PERUBAHAN');
		$this->db->from('VND_HEADER');
		$this->db->where('VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function get_nama_emplo($id){
		$this->db->select("*");
		$this->db->from('ADM_EMPLOYEE');
		$this->db->where('ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function dataemplo($opco){
		if ($opco == '7000' || '2000' || '5000') {
			$opco = 'IN(\'7000\',\'2000\',\'5000\')';
		} else {
			$opco = '='.$opco.'';
		}

		$this->db->select('ID, FULLNAME, EM_COMPANY FROM ADM_EMPLOYEE WHERE EM_COMPANY '.$opco.' ORDER BY FULLNAME ASC', false);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function get_by_level($level){
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where(array('LEVEL'=>$level,'AKTIF'=>'1'));
		$result = $this->db->get();
		return $result->result_array();
	}

	public function get_child($id){
		$this->db->where('EM_COMPANY',$id);
		$this->db->order_by('FULLNAME','ASC');
		$gsj = $this->db->get('ADM_EMPLOYEE');
		if ($gsj->num_rows()>0) {
			$result[]= 'Pilih Data';
			foreach ($gsj->result_array() as $row){
	            $result[$row['ID']]= $row['FULLNAME'];
			} 
		} else {
		   $result[]= 'Belum Ada';
		}
        return $result;
	}

	public function get_all($opco) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('ADM_EMPLOYEE', 'ADM_EMPLOYEE.ID = VND_MS_PROSES.EMP_ID', 'inner');
		$this->db->where('COMPANYID IN ('.$opco.')');
		$result = $this->db->get();
		return $result->result_array();
	}

	public function join_company($opco,$vendor_id){
		$this->db->select("*");
		$this->db->from('TMP_VND_HEADER');
		$this->db->join('ADM_COMPANY','ADM_COMPANY.COMPANYID = TMP_VND_HEADER.COMPANYID', 'inner');
		$this->db->where('TMP_VND_HEADER.VENDOR_ID', $vendor_id);
		$this->db->where('TMP_VND_HEADER.COMPANYID IN ('.$opco.')');
		$result = $this->db->get();
		return $result->result_array();
	}

	public function join_company_header($opco,$vendor_id){
		$this->db->select("*");
		$this->db->from('VND_HEADER');
		$this->db->join('ADM_COMPANY','ADM_COMPANY.COMPANYID = VND_HEADER.COMPANYID', 'inner');
		$this->db->where('VND_HEADER.VENDOR_ID', $vendor_id);
		$this->db->where('VND_HEADER.COMPANYID IN ('.$opco.')');
		$result = $this->db->get();
		return $result->result_array();
	}
}
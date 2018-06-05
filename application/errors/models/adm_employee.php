<?php
class adm_employee extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "ADM_EMPLOYEE";
		$this->table_position = "ADM_POS";
		// $this->table_district = "ADM_DISTRICT";
	}

	function get_id() {
		$this->db->select_max('ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function get($where = NULL,$limit=NULL,$offset=NULL) {
		$this->db->select("ADM_EMPLOYEE.ID, ADM_SALUTATION_ID, LASTNAME, FIRSTNAME, FULLNAME, BIRTHDATE, ADM_GENDER_ID, ADDRESS, CITY, POSTCODE, COUNTRY, PHONE, MOBILEPHONE, EMPLOYEE_TYPE_ID, EMAIL, ADM_POS_ID, JOINDATE, RESIGNDATE, STATUS, OFFICEEXTENSION, NPP, POS_NAME, ADM_EMPLOYEE.NO_PEG, ADM_EMPLOYEE.EM_COMPANY,MKCCTR");
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->from($this->table);
		$this->db->join($this->table_position,"$this->table.ADM_POS_ID = $this->table_position.POS_ID");
		// $this->db->join($this->table_district,"$this->table_position.DISTRICT_ID = $this->table_district.DISTRICT_ID");
		$this->join_dep();
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

	public function find($id) {
		$emp = $this->get(array('ID' => $id));
		return count($emp) > 0 ? $emp[0] : null;
	}

	public function atasan($emp) {
		$current = $this->get(array('ID' => $emp));
		$nopeg = $current[0]['NO_PEG'];
		$this->db->join('ADM_EMPLOYEE_ATASAN', 'ADM_EMPLOYEE_ATASAN.ATASAN1_NOPEG = ADM_EMPLOYEE.NO_PEG', 'left');
		return $this->get(array('ADM_EMPLOYEE_ATASAN.MK_NOPEG' => $nopeg));
	}

	public function join_dep() {
		$this->db->select('ADM_DEPT.DEPT_NAME');
		$this->db->join('ADM_DEPT', 'ADM_DEPT.DEPT_ID = ADM_POS.DEPT_ID', 'left');
	}

	public function mkcctr($requestioner) {
		return $this->db->where_in('MKCCTR', $requestioner)->get($this->table)->result_array();
	}

	public function mrpc_plant($mrpc, $plant) {
		$this->db->join('ADM_MRPC', 'ADM_MRPC.EMP_ID = ADM_EMPLOYEE.ID', 'inner');
		$this->db->where('ADM_MRPC.MRPC', $mrpc);
		$this->db->where('ADM_MRPC.PLANT', $plant);
	}

	public function where_mkcctr($requestioner)
	{
		$this->db->where_in('MKCCTR', $requestioner);
	}

	public function where_pgrp($pgrp) {
		$this->db->where(array('PURC_GRP_ID' => $pgrp));
	}

	/**
	 * $pgrp nya harus sama kayak yg di session
	 * 'K01', 'G01'
	 */
	public function where_pgrp_in($pgrp) {
		$this->db->where('PURC_GRP_ID IN (' . $pgrp . ')', null, false);
	}

	/**
	 * $emp nya array of employee
	 */
	public function where_emp_in($emp) {
		$this->db->where_in('ID', $emp);
	}

	public function where_company($company) {
		$this->db->where(array('EM_COMPANY' => $company));
	}

	public function join_pgrp() {
		$this->db->select('PURC_GRP_ID');
		$this->db->join('ADM_EMPLOYEE_PUCH_GRP', 'ADM_EMPLOYEE.ID = ADM_EMPLOYEE_PUCH_GRP.EMPLOYEE_ID', 'inner');
	}

	function insert( $ID = FALSE, $EMPLOYEEID = FALSE, $ADM_SALUTATION_ID = FALSE, $LASTNAME = FALSE, $FIRSTNAME = FALSE, $FULLNAME = FALSE, $BIRTHDATE = FALSE, $ADM_GENDER_ID = FALSE, $ADDRESS = FALSE, $CITY = FALSE, $POSTCODE = FALSE, $COUNTRY = FALSE, $PHONE = FALSE, $MOBILEPHONE = FALSE, $EMPLOYEE_TYPE_ID = FALSE, $EMAIL = FALSE, $ADM_POS_ID = FALSE, $JOINDATE = FALSE, $RESIGNDATE = FALSE, $STATUS = FALSE, $OFFICEEXTENSION = FALSE, $NPP = FALSE ) {
		$data = array(
			'ID' => $ID,
			'EMPLOYEEID' => $EMPLOYEEID,
			'ADM_SALUTATION_ID' => $ADM_SALUTATION_ID,
			'LASTNAME' => $LASTNAME,
			'FIRSTNAME' => $FIRSTNAME,
			'FULLNAME' => $FULLNAME,
			'BIRTHDATE' => $BIRTHDATE,
			'ADM_GENDER_ID' => $ADM_GENDER_ID,
			'ADDRESS' => $ADDRESS,
			'CITY' => $CITY,
			'POSTCODE' => $POSTCODE,
			'COUNTRY' => $COUNTRY,
			'PHONE' => $PHONE,
			'MOBILEPHONE' => $MOBILEPHONE,
			'EMPLOYEE_TYPE_ID' => $EMPLOYEE_TYPE_ID,
			'EMAIL' => $EMAIL,
			'ADM_POS_ID' => $ADM_POS_ID,
			'JOINDATE' => $JOINDATE,
			'RESIGNDATE' => $RESIGNDATE,
			'STATUS' => $STATUS,
			'OFFICEEXTENSION' => $OFFICEEXTENSION,
			'NPP' => $NPP);
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

	function get_assign($companyId, $company_name, $unit, $posisi, $pegawai){
		$this->db->select("ADM_EMPLOYEE.ID, FULLNAME, EMAIL, ADM_COMPANY.COMPANYNAME, ADM_DEPT.DEPT_NAME, ADM_POS.POS_NAME");
		$this->db->from($this->table);
		$this->db->join('ADM_POS', 'ADM_POS.POS_ID = ADM_EMPLOYEE.ADM_POS_ID', 'inner');
		$this->db->join('ADM_DEPT', 'ADM_DEPT.DEPT_ID = ADM_POS.DEPT_ID', 'inner');
		$this->db->join('ADM_COMPANY', 'ADM_COMPANY.COMPANYID = ADM_DEPT.DEPT_COMPANY', 'inner');
		$this->db->where('COMPANYID IN (' . $companyId . ')', null, false);
		$this->db->like('UPPER(ADM_COMPANY.COMPANYNAME)', strtoupper($company_name));
		$this->db->like('UPPER(ADM_DEPT.DEPT_NAME)', strtoupper($unit));
		$this->db->like('UPPER(ADM_POS.POS_NAME)', strtoupper($posisi));
		$this->db->like('UPPER(FULLNAME)', strtoupper($pegawai));

		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return NULL;
		}
	}

	function ambilData($id){
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('ID IN (' . $id . ')', null, false);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return NULL;
		}
	}

}
?>
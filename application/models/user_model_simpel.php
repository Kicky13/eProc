<?php
class User_model_simpel extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = 'ADM_EMPLOYEE';
		$this->table_role = 'APP_ROLE';
		$this->table_position = 'ADM_POS';
		$this->table_position_to_employee = 'ADM_EMPLOYEE_POS';
	}

	public function getUser($username, $password)
	{
		$this->db->select('ADM_EMPLOYEE.MKCCTR,ADM_EMPLOYEE.ID, ADM_EMPLOYEE.FIRSTNAME, ADM_EMPLOYEE.LASTNAME, ADM_EMPLOYEE.FULLNAME, ADM_EMPLOYEE.EMAIL, ADM_POS.POS_ID, ADM_POS.POS_NAME, ADM_POS.JOB_TITLE, ADM_DEPT.DEPT_ID, ADM_DEPT.DEPT_NAME, ADM_COMPANY.COMPANYID, ADM_COMPANY.COMPANYNAME, ADM_POS.GROUP_MENU, ADM_EMPLOYEE.EM_COMPANY');
		$this->db->join('ADM_POS','ADM_POS.POS_ID = ADM_EMPLOYEE.ADM_POS_ID');
		$this->db->join('ADM_DEPT','ADM_POS.DEPT_ID = ADM_DEPT.DEPT_ID');
		$this->db->join('ADM_COMPANY','ADM_EMPLOYEE.EM_COMPANY = ADM_COMPANY.COMPANYID');
		$this->db->from($this->table);
		$this->db->where('UPPER(EMAIL)', str_replace("'", "''", strtoupper($username)));
		$this->db->where('UPPER(PASS)', str_replace("'", "''", strtoupper($password)));
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else {
			return FALSE;
		}
		//$this->db->join('ADM_EMPLOYEE','ADM_USER.EMPLOYEEID = ADM_EMPLOYEE.ID');
		//$this->db->join('ADM_DISTRICT','ADM_DEPT.DISTRICT_ID = ADM_DISTRICT.DISTRICT_ID');
		//$this->db->join('ADM_PLANT','ADM_EMPLOYEE.EM_PLANT = ADM_PLANT.PLANT_CODE');
		//if (!empty($username)) {
	//	}
		//if (!empty($password)) {
		//}
		//return  $this->db->last_query();
	}

	public function getUserByEmail($email)
	{
		$this->db->select('ADM_EMPLOYEE.MKCCTR,ADM_EMPLOYEE.ID, ADM_EMPLOYEE.FIRSTNAME, ADM_EMPLOYEE.LASTNAME, ADM_EMPLOYEE.FULLNAME, ADM_EMPLOYEE.EMAIL, ADM_POS.POS_ID, ADM_POS.POS_NAME, ADM_POS.JOB_TITLE, ADM_DEPT.DEPT_ID, ADM_DEPT.DEPT_NAME, ADM_COMPANY.COMPANYID, ADM_COMPANY.COMPANYNAME, ADM_POS.GROUP_MENU, ADM_EMPLOYEE.EM_COMPANY');
		$this->db->join('ADM_POS','ADM_POS.POS_ID = ADM_EMPLOYEE.ADM_POS_ID');
		$this->db->join('ADM_DEPT','ADM_POS.DEPT_ID = ADM_DEPT.DEPT_ID');
		$this->db->join('ADM_COMPANY','ADM_EMPLOYEE.EM_COMPANY = ADM_COMPANY.COMPANYID');
		$this->db->from($this->table);
		$this->db->where('UPPER(EMAIL)', str_replace("'", "''", strtoupper($email)));
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else {
			return FALSE;
		}
	}

	public function getRolebyId($id) {
		$this->db->select('NAMA_ROLE');
		$this->db->from($this->table_role);
		$this->db->where('ID_ROLE',$id);
		$result = $this->db->get();
		if ($result->num_rows() == 1) {
			return $result->row();
		}
		else {
			return FALSE;
		}
	}

	public function getPositionById($employee_id)
	{
		$this->db->select("$this->table_position.POS_ID, $this->table_position.POS_NAME, IS_MAIN_JOB");
		$this->db->from($this->table_position);
		$this->db->join($this->table_position_to_employee,"$this->table_position_to_employee.POS_ID = $this->table_position.POS_ID");
		$this->db->where('EMPLOYEE_ID',$employee_id);
		//$this->db->last_query(); exit();
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return FALSE;
		}
	}
	
	public function kelprgrp($em_id)
	{

		
		$result = $this->db->query("SELECT ADM_PURCH_GRP.KEL_PURCH_GRP FROM ADM_PURCH_GRP WHERE ADM_PURCH_GRP.PURCH_GRP_CODE IN(".$em_id.")");
		$jml=$result->num_rows();
		$row_hasil=$result->result_array();
		
		$hasil=0;
		if ($jml > 0) {
			foreach($result->result_array() as $ub){
				$hasil=$ub['KEL_PURCH_GRP'];	
				
			}
		}
		
		return $hasil;
		
	}
	
	public function prog($em_id) {
		$this->db->select("PURC_GRP_ID");
		$this->db->from("ADM_EMPLOYEE_PUCH_GRP");
		$this->db->where('EMPLOYEE_ID', $em_id);
		//$this->db->last_query(); exit();
		$result = $this->db->get();
		$jml = $result->num_rows();
		$ii = 1;
		$hasil = '';

		if ($jml > 0) {
			$hasil = '';
			foreach ($result->result_array() as $ub){
				if ($ii == $jml){
					$hasil .= "'" . $ub['PURC_GRP_ID'] . "'";	
				} else {
					$hasil .= "'" . $ub['PURC_GRP_ID'] . "',";	
				}
				$ii++;
			}

		} else {
			$hasil = "''";
		}

		return $hasil;
		
	}
}
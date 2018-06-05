<?php
class employee_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get_all()
	{
		//$sql = "select * from M_ADM_EMPLOYEE order by FIRSTNAME asc";
		$sql = "select * from M_ADM_EMPLOYEE";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}
	public function get_all_non_repudation()
	{
		//$sql = "select * from M_ADM_EMPLOYEE order by FIRSTNAME asc";
		$sql = "select * from M_ADM_DEPARTEMENT, M_ADM_POSITION,M_ADM_JOBTITLE, M_ADM_DISTRICT,M_ADM_EMPLOYEE,M_ADM_EMPLOYEE_POSITION where 
    M_ADM_DEPARTEMENT.DISTRICT_ID = M_ADM_DISTRICT.DISTRICT_ID
    AND M_ADM_JOBTITLE.DEPARTEMENT_ID = M_ADM_DEPARTEMENT.DEPARTEMENT_ID 
		AND M_ADM_POSITION.JOBTITLE_ID = M_ADM_JOBTITLE.JOBTITLE_ID 
		AND M_ADM_EMPLOYEE_POSITION.POSITION_ID = M_ADM_POSITION.POSITION_ID
		AND M_ADM_EMPLOYEE_POSITION.EMPLOYEE_ID = M_ADM_EMPLOYEE.EMPLOYEE_ID
		AND M_ADM_EMPLOYEE_POSITION.IS_MAIN_JOB = 1
		AND M_ADM_EMPLOYEE_POSITION.IS_ACTIVE = 1
		AND not exists (select employee_id from m_adm_user where M_ADM_EMPLOYEE.EMPLOYEE_ID = m_adm_user.EMPLOYEE_ID)";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function get_position_person($ID)
	{
		$sql = "select * from M_ADM_EMPLOYEE_POSITION, M_ADM_POSITION where M_ADM_EMPLOYEE_POSITION.EMPLOYEE_ID = ".$ID."
		AND M_ADM_EMPLOYEE_POSITION.POSITION_ID= M_ADM_POSITION.POSITION_ID";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}

	public function get_employee_person($ID)
	{
		$sql = "select * from M_ADM_EMPLOYEE where EMPLOYEE_ID = ".$ID."";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}


	public function delete($ID)
	{
		$this->db->query("delete from M_ADM_EMPLOYEE_POSITION where EMPLOYEE_ID='$ID'");
		$this->db->query("delete from M_ADM_EMPLOYEE where EMPLOYEE_ID='$ID'");
	}

	public function position_employee()
	{
		$sql = "select * from M_ADM_DEPARTEMENT, M_ADM_POSITION,M_ADM_JOBTITLE, M_ADM_DISTRICT where 
		M_ADM_JOBTITLE.DEPARTEMENT_ID = M_ADM_DEPARTEMENT.DEPARTEMENT_ID AND M_ADM_DEPARTEMENT.DISTRICT_ID = M_ADM_DISTRICT.DISTRICT_ID
		AND M_ADM_POSITION.JOBTITLE_ID = M_ADM_POSITION.JOBTITLE_ID";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function get_all_position()
	{
		$sql = "select * from M_ADM_EMPLOYEE_POSITION,M_ADM_DEPARTEMENT,M_ADM_JOBTITLE, M_ADM_POSITION
		where M_ADM_EMPLOYEE_POSITION.POSITION_ID = M_ADM_POSITION.POSITION_ID AND M_ADM_JOBTITLE.JOBTITLE_ID = M_ADM_POSITION.JOBTITLE_ID
		AND M_ADM_DEPARTEMENT.DEPARTEMENT_ID = M_ADM_JOBTITLE.DEPARTEMENT_ID";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}
	public function add_employee($npp,$salutation,$employee_type,$firstname,$lastname,$email,$phone,$gender,$email)
	{
		$sql = "insert into M_ADM_EMPLOYEE (EMPLOYEE_ID,SALUTATION_ID,EMPLOYEE_TYPE_ID,GENDER_ID
			,FIRSTNAME,LASTNAME,NPP,OFFICE_EXTENSION,EMAIL) values (SEQ_EMPLOYEE.nextval,".$salutation.",
			".$employee_type.",".$gender.",'".$firstname."','".$lastname."','".$npp."','".$phone."','".$email."')";
		$query = $this->db->query($sql);
	}

	public function add_employee_position($npp,$job_position,$active,$main_job)
	{
		$sql = "insert into M_ADM_EMPLOYEE_POSITION (EMPLOYEE_POSITION_ID,EMPLOYEE_ID,POSITION_ID,IS_ACTIVE,
			IS_MAIN_JOB) values (seq_employee_position.NEXTVAL,(select employee_id from m_adm_employee where m_adm_employee.NPP='".$npp."'),".$job_position."
			,'".$active."','".$main_job."')";
		$query = $this->db->query($sql);
	} 
}
?>

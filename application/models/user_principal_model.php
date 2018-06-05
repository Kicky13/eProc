<?php
class User_principal_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->table = 'EC_PRINCIPAL_MANUFACTURER';
        $this->table_R1 = 'EC_R1';
        // $this->table_temp = 'TMP_EC_PRINCIPAL_MANUFACTURER';
        // $this->table_role = 'ROLE';
	}

	public function getUser($username, $password, $companyid)
	{
		$this->db->select('EC_PRINCIPAL_MANUFACTURER.*, ADM_COMPANY.COMPANYNAME, ADM_COMPANY.EMAIL_COMPANY, ADM_COMPANY.ALAMAT_COMPANY, ADM_COMPANY.KETERANGAN, ADM_COMPANY.LOGO_COMPANY');
		$this->db->join('ADM_COMPANY','ADM_COMPANY.COMPANYID = EC_PRINCIPAL_MANUFACTURER.COMPANYID');
		$this->db->from($this->table);
		if (!empty($username)) {
			$this->db->where('EC_PRINCIPAL_MANUFACTURER.PC_CODE', $username);
		}
		if (!empty($password)) {
			$this->db->where('EC_PRINCIPAL_MANUFACTURER.PASSWORD', md5($password));
		}
		if (!empty($companyid)) {
			$this->db->where('EC_PRINCIPAL_MANUFACTURER.COMPANYID', $companyid);
		}
		// $this->db->where('EC_PRINCIPAL_MANUFACTURER.REG_ISACTIVATE', '1');
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else {
			return FALSE;
		}
	}

	public function getTempUser($username, $password, $companyid)
	{
		$this->db->select('EC_PRINCIPAL_MANUFACTURER.*, ADM_COMPANY.COMPANYNAME, ADM_COMPANY.EMAIL_COMPANY, ADM_COMPANY.ALAMAT_COMPANY, ADM_COMPANY.KETERANGAN, ADM_COMPANY.LOGO_COMPANY');
		$this->db->join('ADM_COMPANY','ADM_COMPANY.COMPANYID = TMP_EC_PRINCIPAL_MANUFACTURER.COMPANYID');
		$this->db->from($this->table);
		if (!empty($username)) {
			$this->db->where('TMP_EC_PRINCIPAL_MANUFACTURER.LOGIN_ID', $username);
		}
		if (!empty($password)) {
			$this->db->where('TMP_EC_PRINCIPAL_MANUFACTURER.PASSWORD', md5($password));
		}
		if (!empty($companyid)) {
			$this->db->where('TMP_EC_PRINCIPAL_MANUFACTURER.COMPANYID', $companyid);
		}
		// $this->db->where('TMP_EC_PRINCIPAL_MANUFACTURER.REG_ISACTIVATE', '1');
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else {
			return FALSE;
		}
	}

	/*public function getRolebyId($id) {
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
	}*/

	public function getNewPassword($email, $companyid)
	{	

		$this->db->select('EC_PRINCIPAL_MANUFACTURER.*');
		$this->db->from($this->table); 
		$this->db->where('EMAIL_ADDRESS', $email);
		$this->db->where('COMPANYID', $companyid);
		$this->db->where('REG_ISACTIVATE', '1');
		$result_vnd = $this->db->get();

		$this->db->select('TMP_EC_PRINCIPAL_MANUFACTURER.*');
		$this->db->from($this->table_temp); 
		$this->db->where('EMAIL_ADDRESS', $email);
		$this->db->where('COMPANYID', $companyid);
		$this->db->where('REG_ISACTIVATE', '1');
		$result_tmp = $this->db->get();

		if ($result_vnd->num_rows() > 0 ) {
			
			return $result_vnd->result();

		} else if ($result_tmp->num_rows() > 0 ){
			
			return $result_tmp->result();
		
		} else {
			return FALSE;
		}
	}

	public function getVendorList($pc_code)
	{
		$this->db->select('EC_PRINCIPAL_MANUFACTURER.PC_CODE, EC_PRINCIPAL_MANUFACTURER.PC_NAME, EC_R1.VENDOR_ID, VND_HEADER.*');
		$this->db->join('EC_R1','EC_R1.PC_CODE = EC_PRINCIPAL_MANUFACTURER.PC_CODE','LEFT');
		$this->db->join('VND_HEADER','VND_HEADER.VENDOR_NO = EC_R1.VENDOR_ID','INNER');
		$this->db->from($this->table);
		$this->db->where('EC_PRINCIPAL_MANUFACTURER.PC_CODE', $pc_code);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return FALSE;
		}
	}

	public function getPrincipalList($VENDOR_NO)
	{
		$this->db->select('EC_R1.VENDOR_ID, EC_PRINCIPAL_MANUFACTURER.*');
		$this->db->join('EC_PRINCIPAL_MANUFACTURER','EC_PRINCIPAL_MANUFACTURER.PC_CODE = EC_R1.PC_CODE','INNER');
		$this->db->from($this->table_R1);
		$this->db->where('EC_R1.VENDOR_ID', $VENDOR_NO);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return FALSE;
		}
	}

}
?>
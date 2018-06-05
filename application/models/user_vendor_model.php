<?php
class User_Vendor_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->table = 'VND_HEADER';
        $this->table_temp = 'TMP_VND_HEADER';
        $this->table_role = 'ROLE';
	}

	public function getUser($username, $password, $companyid)
	{
		$this->db->select('VND_HEADER.VENDOR_ID, VND_HEADER.VENDOR_NAME, VND_HEADER.LOGIN_ID, VND_HEADER.PASSWORD, VND_HEADER.VENDOR_NO, VND_HEADER.STATUS, VND_HEADER.REG_STATUS_ID, VND_HEADER.REG_ISACTIVATE,VND_HEADER.COMPANYID, ADM_COMPANY.COMPANYNAME, ADM_COMPANY.EMAIL_COMPANY, ADM_COMPANY.ALAMAT_COMPANY, ADM_COMPANY.KETERANGAN, ADM_COMPANY.LOGO_COMPANY');
		$this->db->join('ADM_COMPANY','ADM_COMPANY.COMPANYID = VND_HEADER.COMPANYID');
		$this->db->from($this->table);
		if (!empty($username)) {
			$this->db->where('VND_HEADER.VENDOR_NO', $username);
		}
		if (!empty($password)) {
			$this->db->where('VND_HEADER.PASSWORD', md5($password));
		}
		if (!empty($companyid)) {
			$this->db->where('VND_HEADER.COMPANYID', $companyid);
		}
		$this->db->where('VND_HEADER.REG_ISACTIVATE', '1');
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
		$this->db->select('TMP_VND_HEADER.VENDOR_ID, TMP_VND_HEADER.VENDOR_NAME, TMP_VND_HEADER.LOGIN_ID, TMP_VND_HEADER.PASSWORD, TMP_VND_HEADER.VENDOR_NO, TMP_VND_HEADER.STATUS, TMP_VND_HEADER.REG_STATUS_ID, TMP_VND_HEADER.REG_ISACTIVATE, TMP_VND_HEADER.COMPANYID, ADM_COMPANY.COMPANYNAME,
			ADM_COMPANY.EMAIL_COMPANY, ADM_COMPANY.ALAMAT_COMPANY, ADM_COMPANY.KETERANGAN, ADM_COMPANY.LOGO_COMPANY');
		$this->db->join('ADM_COMPANY','ADM_COMPANY.COMPANYID = TMP_VND_HEADER.COMPANYID');
		$this->db->from($this->table_temp);
		if (!empty($username)) {
			$this->db->where('TMP_VND_HEADER.LOGIN_ID', $username);
		}
		if (!empty($password)) {
			$this->db->where('TMP_VND_HEADER.PASSWORD', md5($password));
		}
		if (!empty($companyid)) {
			$this->db->where('TMP_VND_HEADER.COMPANYID', $companyid);
		}
		$this->db->where('TMP_VND_HEADER.REG_ISACTIVATE', '1');
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

	public function getNewPassword($email, $companyid)
	{	

		$this->db->select('VND_HEADER.*');
		$this->db->from($this->table); 
		// $this->db->where('EMAIL_ADDRESS', $email);
		$this->db->like('LOWER(EMAIL_ADDRESS)', strtolower($email));
		$this->db->where('COMPANYID', $companyid);
		$this->db->where('REG_ISACTIVATE', '1');
		$result_vnd = $this->db->get();

		$this->db->select('TMP_VND_HEADER.*');
		$this->db->from($this->table_temp); 
		// $this->db->where('EMAIL_ADDRESS', $email);
		$this->db->like('LOWER(EMAIL_ADDRESS)', strtolower($email));
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

}
?>
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
		$this->db->select('VENDOR_ID, VENDOR_NAME, LOGIN_ID, PASSWORD, VENDOR_NO, STATUS, REG_STATUS_ID, REG_ISACTIVATE, COMPANYID');
		$this->db->from($this->table);
		if (!empty($username)) {
			$this->db->where('LOGIN_ID', $username);
		}
		if (!empty($password)) {
			$this->db->where('PASSWORD', md5($password));
		}
		if (!empty($companyid)) {
			$this->db->where('COMPANYID', $companyid);
		}
		$this->db->where('REG_ISACTIVATE', '1');
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
		$this->db->select('VENDOR_ID, VENDOR_NAME, LOGIN_ID, PASSWORD, VENDOR_NO, STATUS, REG_STATUS_ID, REG_ISACTIVATE, COMPANYID');
		$this->db->from($this->table_temp);
		if (!empty($username)) {
			$this->db->where('LOGIN_ID', $username);
		}
		if (!empty($password)) {
			$this->db->where('PASSWORD', md5($password));
		}
		if (!empty($companyid)) {
			$this->db->where('COMPANYID', $companyid);
		}
		$this->db->where('REG_ISACTIVATE', '1');
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
		$this->db->where('EMAIL_ADDRESS', $email);
		$this->db->where('COMPANYID', $companyid);
		$this->db->where('REG_ISACTIVATE', '1');
		$result_vnd = $this->db->get();

		$this->db->select('TMP_VND_HEADER.*');
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

}
?>
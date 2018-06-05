<?php
class User_Vendor_model_simpel extends CI_Model
{
	function __construct()
	{
		parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->table = 'EC_AUCTION_PESERTA';
	$this->table_header = 'EC_AUCTION_HEADER';        
        #$this->table_temp = 'EC_AUCTION_PESERTA';
        #$this->table_role = 'ROLE';
	}

	public function getUser($username, $password)
	{
              /*  $this->db->select('ID_HEADER, KODE_VENDOR, NAMA_VENDOR, USERID, PASS, HARGAAWAL, HARGATERKINI');
		$this->db->from($this->table);
		#$this->db->join($this->table_header,'EC_AUCTION_PESERTA.ID_HEADER = EC_AUCTION_HEADER.NO_TENDER');
		$this->db->where('IS_ACTIVE', '1');*/
		$result = $this->db->query("select * from EC_AUCTION_HEADER a
left join EC_AUCTION_PESERTA b on a.NO_TENDER = b.ID_HEADER
where a.is_active = 1 and b.USERID = '$username' and b.PASS = '$password'");
                if ($result->num_rows() > 0) {
			return $result->result();
		}
		else {
			return FALSE;
		}            
            
            
            
            
            
            
	/*	$this->db->select('ID_HEADER, KODE_VENDOR, NAMA_VENDOR, USERID, PASS, HARGAAWAL, HARGATERKINI');
		$this->db->from($this->table);
		if (!empty($username)) {
			$this->db->where('USERID', $username);
		}
		if (!empty($password)) {
			$this->db->where('PASS', $password);
		}
		/*if (!empty($companyid)) {
			$this->db->where('COMPANYID', $companyid);
		}*/
		// $this->db->where('ID_HEADER', '1');
	/*	$result = $this->db->get();
		if ($result->num_rows() > 0) {
                        #tes
                    	#$this->session->sess_destroy();
                        #$data_session = array(
			#	'nama' => $username,
			#	'status' => "login"
			#	);
			#$this->session->set_userdata($data_session);
			return $result->result();
		}
		else {
			return FALSE;
		}
        */        
	}

	public function getTempUser($username, $password)
	{
		$this->db->select('ID_HEADER, KODE_VENDOR, NAMA_VENDOR, USERID, PASS, HARGAAWAL, HARGATERKINI');
		$this->db->from($this->table);
		if (!empty($username)) {
			$this->db->where('USERID', $username);
		}
		if (!empty($password)) {
			$this->db->where('PASS', $password);
		}
		/*if (!empty($companyid)) {
			$this->db->where('COMPANYID', $companyid);
		}*/
		$this->db->where('ID_HEADER', '1');
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
	}

	public function getNewPassword($email)
	{	

		$this->db->select('VND_HEADER.*');
		$this->db->from($this->table); 
		$this->db->where('EMAIL_ADDRESS', $email);
		#$this->db->where('COMPANYID', $companyid);
		$this->db->where('REG_ISACTIVATE', '1');
		$result_vnd = $this->db->get();

		$this->db->select('TMP_VND_HEADER.*');
		$this->db->from($this->table_temp); 
		$this->db->where('EMAIL_ADDRESS', $email);
		#$this->db->where('COMPANYID', $companyid);
		$this->db->where('REG_ISACTIVATE', '1');
		$result_tmp = $this->db->get();

		if ($result_vnd->num_rows() > 0 ) {
			
			return $result_vnd->result();

		} else if ($result_tmp->num_rows() > 0 ){
			
			return $result_tmp->result();
		
		} else {
			return FALSE;
		}
	}*/

}
?>
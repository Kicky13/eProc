<?php
class User_vendor_auction_bobot extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = 'EC_AUCTION_BOBOT_PESERTA';
		$this->table_header = 'EC_AUCTION_BOBOT_HEADER';    
	}

	public function getUser($username, $password)
	{
		$result = $this->db->query("select * from EC_AUCTION_BOBOT_HEADER a
			left join EC_AUCTION_BOBOT_PESERTA b on a.NO_TENDER = b.ID_HEADER
			where a.is_active = 1 and b.USERID = '$username' and b.PASS = '$password'");
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else {
			return FALSE;
		}                  
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
		$this->db->where('ID_HEADER', '1');
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else {
			return FALSE;
		}
	}

}
?>
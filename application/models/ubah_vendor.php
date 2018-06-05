<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ubah_vendor extends CI_Model {

	protected $table = 'VND_HEADER';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($opco) {
		if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
			$whereopco = '7000,2000,5000';
		} else {
			$whereopco = $opco;
		}
		
		$this->db->select('VENDOR_ID, ADDRESS_CITY, VENDOR_NO, VENDOR_NAME, ADDRESS_CITY, VENDOR_TYPE, EMAIL_ADDRESS, COMPANYID, STATUS');
		$this->db->from($this->table);
		$this->db->join('ADM_WILAYAH', 'VND_HEADER.ADDRESS_CITY = ADM_WILAYAH.ID', 'left');
		$this->db->where('VND_HEADER.COMPANYID IN ('.$whereopco.')');
		$this->db->where('VND_HEADER.STATUS', 3);
		$this->db->where('VND_HEADER.VENDOR_NO IS NOT NULL');
		$result = $this->db->get();
		return (array)$result->result_array();
	}

	public function getDetail($email){
		$this->db->select('VENDOR_ID, ADDRESS_CITY, VENDOR_NO, VENDOR_NAME, ADDRESS_CITY, VENDOR_TYPE, EMAIL_ADDRESS, COMPANYID, STATUS');
		$this->db->from($this->table);
		$this->db->join('ADM_WILAYAH', 'VND_HEADER.ADDRESS_CITY = ADM_WILAYAH.ID', 'left');
		$this->db->where('VENDOR_ID', $email);
		$result = $this->db-> get();
		return (array)$result->result_array();
	}

	public function updateEmail($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function updateNo($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}
}

/* End of file ubah_email.php */
/* Location: ./application/models/ubah_email.php */
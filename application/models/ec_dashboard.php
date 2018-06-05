<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_dashboard extends CI_Model {
	protected $VND_HEADER = 'VND_HEADER', $ADM_COMPANY = 'ADM_COMPANY';
	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	public function get_MasterCompany($VENDOR_ID) {
		//if ($mins == 0) {
		//	$this -> db -> limit(11);
		//} else
		//	$this -> db -> where("ROWNUM <=", $max, false);

		$this -> db -> from($this -> VND_HEADER);
		$this -> db -> join($this -> ADM_COMPANY, 'VND_HEADER.COMPANYID = ADM_COMPANY.COMPANYID', 'left');
		//$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
		//$this -> db -> join('EC_PRICELIST_OFFER', 'EC_M_STRATEGIC_MATERIAL.MATNR = EC_PRICELIST_OFFER.MATNO', 'left');
		//$this -> db -> where("PUBLISHED_PRICELIST", '1', TRUE);
		$this -> db -> where("VND_HEADER.VENDOR_NO", $VENDOR_ID, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}
}

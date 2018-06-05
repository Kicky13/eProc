<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_principal_manufacturer_m extends CI_Model {
	protected $table = 'EC_PRINCIPAL_MANUFACTURER';
	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	public function get() {
		$this -> db -> from($this -> table);
		// $this -> db -> order_by('"TO_NUMBER"(published)');
		$this -> db -> order_by('PC_CODE');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_dataBPA($PC_CODE) {
		$SQL = "SELECT R1.ID_R1,R1.PC_CODE,VH.VENDOR_ID, VH.VENDOR_NO, VH.VENDOR_NAME, VH.ADDRESS_COUNTRY, VH.ADDRESS_PHONE_NO, VH.ADDRESS_WEBSITE, VH.EMAIL_ADDRESS, CASE WHEN R1.PC_CODE ='$PC_CODE' THEN '1' ELSE '0' END AS STATUS from VND_HEADER VH LEFT JOIN EC_R1 R1 on VH.VENDOR_NO=R1.VENDOR_ID ORDER BY STATUS DESC,VH.VENDOR_ID";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getTblDetail($PC_CODE) {
		$SQL = "SELECT 
					r.*, VH.VENDOR_NO,
					VH.VENDOR_NAME,
					VH.ADDRESS_COUNTRY,
					VH.ADDRESS_PHONE_NO,
					VH.ADDRESS_WEBSITE,
					VH.EMAIL_ADDRESS 
				FROM 
					EC_R1 r 
				INNER JOIN VND_HEADER vh ON r.VENDOR_ID = VH.VENDOR_NO 
				WHERE 
					PC_CODE = '$PC_CODE'";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getPC_CODE() {
		//SELECT "MAX"("TO_NUMBER"(SUBSTR(PC_CODE,3))) from PRINCIPAL_MANUFACTURER;
		$this -> db -> select_max('"TO_NUMBER"(SUBSTR(PC_CODE,3))', 'PC_CODE');
		$max = $this -> db -> get($this -> table) -> row_array();
		return $max['PC_CODE'] + 1;
	}

	function ubahStat($data) {
		if ($data['STATUS'] == "1") {
			$this -> db -> insert("EC_R1", array('ID_R1' => "triger", 'PC_CODE' => $data['PC_CODE'], 'VENDOR_ID' => $data['VENDOR_ID']));
			$this -> db -> where("PC_CODE", $data['PC_CODE'], TRUE);
			$this -> db -> update($this -> table, array('CHANGEDBY' => $data['BY'], 'CHANGEDON' => $data['ON']));
		} else {
			$this -> db -> delete("EC_R1", array('ID_R1' => $data['ID_R1']));
			$this -> db -> where("PC_CODE", $data['PC_CODE'], TRUE);
			$this -> db -> update($this -> table, array('CHANGEDBY' => $data['BY'], 'CHANGEDON' => $data['ON']));
		}
	}

	function insert($data) {
		$this -> db -> insert($this -> table, $data);
	}

	function edit($data) {
		$this -> db -> where("PC_CODE", $data['PC_CODE'], TRUE);
		$this -> db -> update($this -> table, $data);
	}

	public function upload($data) {
		$this -> db -> where("PC_CODE", $data['PC_CODE'], TRUE);
		$this -> db -> update($this -> table, array('CHANGEDBY' => $data['BY'], 'LOGO' => $data['LOGO'], 'CHANGEDON' => $data['ON']));

	}

	public function getDetail($PC_CODE) {
		$this -> db -> from($this -> table);
		$this -> db -> where("PC_CODE", $PC_CODE, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

}

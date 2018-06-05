<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_pr_pricelist_man_m extends CI_Model {
	protected $table = 'EC_PR', $tableContract = 'EC_T_CONTRACT', $tableCOMPANY = 'EC_C_COMPANY', $tablePURC_ORG = 'EC_C_PURC_ORG', $tableDOC = "EC_C_DOCTYPE";

	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}
 
	public function get() {
		// $SQL = 'SELECT TM.STATUS AS AH, TC.* FROM EC_T_CONTRACT AS TC LEFT JOIN EC_M_STRATEGIC_MATERIAL AS TM ON TC."MATNO"=TM."MATNR";';
		// $result = $this -> db -> query($SQL);
		$this -> db -> from($this -> table);
		$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getMan() {
		$this -> db -> order_by('PUBLISHED_PRICELIST desc');
		$this -> db -> from('EC_M_STRATEGIC_MATERIAL');
		// $this -> db -> limit(21);
		// $this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	function getDetail($ptm) {
		$SQL = "SELECT SUBSTR (SYS_CONNECT_BY_PATH (ES.TDLINE , '\n'), 2) LNGTX ,ES.*,SM.* FROM (SELECT ER.*, ROW_NUMBER () OVER (ORDER BY TO_NUMBER(NO)) RN, COUNT (*) OVER () CNT FROM EC_M_LONGTEXT ER WHERE ER.MATNR =  '" . $ptm . "') ES LEFT JOIN EC_M_STRATEGIC_MATERIAL SM on ES.MATNR=SM.MATNR WHERE RN = CNT START WITH RN = 1 CONNECT BY RN = PRIOR RN + 1";
		// '" . $ptm . "'
		$result = $this -> db -> query($SQL);
		// }
		return (array)$result -> result_array();
	}

	function insert_sapT($dataLC) {
		$this -> db -> select('COUNT(*)') -> from($this -> table) -> where("contract_no", $dataLC['contract_no'], TRUE) -> where("contract_itm", $dataLC['contract_itm'], TRUE);
		$query = $this -> db -> get();
		$result = $query -> row_array();
		$count = $result['COUNT(*)'];
		if ($count < 1) {
			$this -> db -> insert($this -> table, $dataLC);
		} else {
			$this -> db -> where("contract_no", $dataLC['contract_no'], TRUE);
			$this -> db -> where("contract_itm", $dataLC['contract_itm'], TRUE);
			$this -> db -> update($this -> table, array("del" => $dataLC['del'], "pgrp" => $dataLC['pgrp'], "exrate" => $dataLC['exrate'], "validstart" => $dataLC['validstart'], "validend" => $dataLC['validend'], "procstat" => $dataLC['procstat'], "relind" => $dataLC['relind'], "shortext" => $dataLC['shortext'], "t_qty" => $dataLC['t_qty'], "netprice" => $dataLC['netprice'], "grossprice" => $dataLC['grossprice']));
		}
	}

	function insert_sap($data) {
		foreach ($data as $dataLC) {
			$this -> db -> select('COUNT(*)') -> from($this -> table) -> where("PRNO", $dataLC['PRNO'], TRUE) -> where("PRITEM", $dataLC['PRITEM'], TRUE);
			$query = $this -> db -> get();
			$result = $query -> row_array();
			$count = $result['COUNT(*)'];
			if ($count < 1) {
				$this -> db -> insert($this -> table, $dataLC);
			} else {
				$this -> db -> where("PRNO", $dataLC['PRNO'], TRUE);
				$this -> db -> where("PRITEM", $dataLC['PRITEM'], TRUE);
				$this -> db -> update($this -> table, $dataLC);
			}
		}
	}

	function getFilter() {
		// $this -> db -> select('TYPE');
		$this -> db -> from($this -> tableCOMPANY);
		$this -> db -> where("STATUS", "1", TRUE);
		$result = (array)($this -> db -> get() -> result_array());

		// $this -> db -> select('TYPE');
		$this -> db -> from($this -> tablePURC_ORG);
		$this -> db -> where("STATUS", "1", TRUE);
		$result2 = (array)($this -> db -> get() -> result_array());
		$data_filter = array("COMPANY" => $result, "PURC_ORG" => $result2);

		$this -> db -> from($this -> tableDOC);
		$this -> db -> where("DOC_STATUS", "1", TRUE);
		$result3 = (array)($this -> db -> get() -> result_array());
		$data_filter = array("COMPANY" => $result, "PURC_ORG" => $result2, "DOC" => $result3);

		return $data_filter;
	}

	function getAllVnd() {
		$this -> db -> select('VENDOR_ID, VENDOR_NAME');
		$this -> db -> from('VND_HEADER');
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	function getAllManufacturer() {
		$this -> db -> select('TYPE');
		$this -> db -> from($this -> tableCOMPANY);
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	function getAllMatgroup() {
		$this -> db -> select('TYPE');
		$this -> db -> from($this -> tableCOMPANY);
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	function ubahStatDraft($data) {
		$this -> db -> where("MATNR", $data['MATNR'], TRUE);
		$this -> db -> update('EC_M_STRATEGIC_MATERIAL', array('PUBLISHED_PRICELIST' => $data['PUBLISHED_PRICELIST']));
	}

}

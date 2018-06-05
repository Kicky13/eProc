<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_strategic_material_m extends CI_Model {
	protected $table = 'EC_M_STRATEGIC_MATERIAL', $tableCategory = 'EC_M_CATEGORY';
	//protected $all_field = 'MONITORING_INVOICE.BUKRS, MONITORING_INVOICE.LIFNR, BELNR, GJAHR, BIL_NO, NAME1, BKTXT, SGTXT, XBLNR, UMSKZ, BUDAT, BLDAT, CPUDT, MONAT, ZLSPR, WAERS, HWAER, ZLSCH, ZTERM, DMBTR, WRBTR, BLART, STATUS, BYPROV, DATEPROV, DATECOL, WWERT, TGL_KIRUKP, USER_UKP, STAT_VER, TGL_VER, TGL_KIRVER, TGL_KEMB_VER, USER_VER, STAT_BEND, TGL_BEND, TGL_KIRBEND, TGL_KEMB_BEN, USER_BEN, STAT_AKU, TGL_AKU, TGL_KEMB_AKU, U_NAME, AUGDT, STAT_REJ, NO_REJECT, STATUS_UKP, NYETATUS, EBELN, EBELP, MBELNR, MGJAHR, PROJK, PRCTR, HBKID, DBAYAR, TBAYAR, UBAYAR, DGROUP, TGROUP, UGROUP, LUKP, LVER, LBEN, LAKU, AWTYPE, AWKYE, LBEN2, MWSKZ, HWBAS, FWBAS, HWSTE, FWSTE, WT_QBSHH, WT_QBSHB ';
	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	/*
	 ec.MATNR,
	 ec.MAKTX,
	 ec.MTART,
	 ec.MEINS,
	 ec.MATKL,
	 ec.ERNAM,
	 ec.ERSDA,
	 ec.AENAM,
	 ec.LAEDA,
	 ec.NO,
	 ec.TDLINE,
	 ec.STATUS,
	 ec.PICTURE,
	 ec.DRAWING
	 */

	public function get() {
		$this -> db -> from($this -> table);
		$this -> db -> join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'left');
		$this -> db -> order_by('STATUS DESC, MATNR ASC');
		// $this -> db -> limit(10);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	function getDetailCompare($xpl, $xpl2) {//mat no,contrak no
		$this -> db -> from($this -> table);
		$this -> db -> join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'left');
		$this -> db -> join('EC_T_CONTRACT', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
		$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
		$this -> db -> join('EC_PRINCIPAL_MANUFACTURER', 'EC_R1.PC_CODE = EC_PRINCIPAL_MANUFACTURER.PC_CODE', 'left');
		$whereS = '(("EC_T_CONTRACT"."matno"=\'' . $xpl[0] . '\'';
		$whereS .= ' AND "EC_T_CONTRACT"."contract_no"=\'' . $xpl2[0] . '\')';
		for ($i = 1; $i < sizeof($xpl); $i++) {
			$whereS .= ' OR ( "EC_T_CONTRACT"."matno"=\'' . $xpl[$i] . '\'';
			$whereS .= ' AND "EC_T_CONTRACT"."contract_no"=\'' . $xpl2[$i] . '\')';
		}
		$whereS .= ')';
		$this -> db -> where($whereS);
		$this -> db -> where('EC_T_CONTRACT.published', '1', TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	function getDetailCompareOLD($xpl) {
		$this -> db -> from($this -> table);
		$this -> db -> join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'left');
		$this -> db -> join('EC_T_CONTRACT', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
		$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
		$this -> db -> join('EC_PRINCIPAL_MANUFACTURER', 'EC_R1.PC_CODE = EC_PRINCIPAL_MANUFACTURER.PC_CODE', 'left');
		$whereS = '("EC_M_STRATEGIC_MATERIAL"."MATNR"=\'' . $xpl[0] . '\'';
		for ($i = 1; $i < sizeof($xpl); $i++) {
			$whereS .= ' OR "EC_M_STRATEGIC_MATERIAL"."MATNR"=\'' . $xpl[$i] . '\'';
		}
		$whereS .= ')';
		$this -> db -> where($whereS);
		$this -> db -> where('EC_T_CONTRACT.published', '1', TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	function getDetailProduk($xpl, $matno = '') {
		$this -> db -> from($this -> table);
		$this -> db -> join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'left');
		$this -> db -> join('EC_T_CONTRACT', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
		$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
		$this -> db -> join('EC_PRINCIPAL_MANUFACTURER', 'EC_R1.PC_CODE = EC_PRINCIPAL_MANUFACTURER.PC_CODE', 'left');
		$this -> db -> where('EC_T_CONTRACT.published', '1', TRUE);
		$this -> db -> where('EC_T_CONTRACT.contract_no', $xpl, TRUE);
		$this -> db -> where('EC_T_CONTRACT.matno', $matno, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	function getRootCategory() {
		$this -> db -> from($this -> tableCategory);
		//$this -> db -> where('EC_M_CATEGORY.KODE_PARENT', $root, TRUE);
		$this -> db -> order_by('EC_M_CATEGORY.KODE_USER', "ASC", TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	/*function getLevel2Category($id) {
	 $this -> db -> from($this -> tableCategory);
	 $this -> db -> where('EC_M_CATEGORY.KODE_PARENT', $id, TRUE);
	 $this -> db -> order_by('EC_M_CATEGORY.ID_CAT', "ASC", TRUE);
	 $result = $this -> db -> get();
	 return (array)$result -> result_array();
	 }*/

	function getDetail($ptm) {
		// $this -> db -> from($this -> table);
		// $this -> db -> where('MATNR', $ptm);
		// $result = $this -> db -> get();

		// if ($result -> num_rows() > 1) {
		$SQL = "SELECT SUBSTR (SYS_CONNECT_BY_PATH (ES.TDLINE , '\n'), 2) LNGTX ,ES.*,SM.* FROM (SELECT ER.*, ROW_NUMBER () OVER (ORDER BY TO_NUMBER(NO)) RN, COUNT (*) OVER () CNT FROM EC_M_LONGTEXT ER WHERE ER.MATNR =  '" . $ptm . "') ES LEFT JOIN EC_M_STRATEGIC_MATERIAL SM on ES.MATNR=SM.MATNR WHERE RN = CNT START WITH RN = 1 CONNECT BY RN = PRIOR RN + 1";
		// '" . $ptm . "'
		$result = $this -> db -> query($SQL);
		// }
		return (array)$result -> result_array();
	}

	function getLongteks($ptm) {
		// $this -> db -> from($this -> table);
		// $this -> db -> where('MATNR', $ptm);
		// $result = $this -> db -> get();

		// if ($result -> num_rows() > 1) {
		$SQL = "SELECT SUBSTR (SYS_CONNECT_BY_PATH (ES.TDLINE , '<br />&nbsp&nbsp'), 17) LNGTX FROM (SELECT ER.*, ROW_NUMBER () OVER (ORDER BY TO_NUMBER(NO)) RN, COUNT (*) OVER () CNT FROM EC_M_LONGTEXT ER WHERE ER.MATNR =  '" . $ptm . "') ES LEFT JOIN EC_M_STRATEGIC_MATERIAL SM on ES.MATNR=SM.MATNR WHERE RN = CNT START WITH RN = 1 CONNECT BY RN = PRIOR RN + 1";
		// '" . $ptm . "'
		$result = $this -> db -> query($SQL);
		// }
		return (array)$result -> result_array();
	}

	function upload($data) {
		$this -> db -> where("MATNR", $data['MATNR'], TRUE);
		$this -> db -> update($this -> table, $data);
	}

	function ubahStat($data) {
		$this -> db -> where("MATNR", $data['MATNR'], TRUE);
		$this -> db -> update($this -> table, $data);
	}

	function setCategory($data) {
		$this -> db -> where("MATNR", $data['MATNR'], TRUE);
		$this -> db -> update($this -> table, array('ID_CAT' => $data['ID_CAT']));
	}

	function setTAG($data) {
		$this -> db -> where("MATNR", $data['MATNR'], TRUE);
		$this -> db -> update($this -> table, array('TAG' => $data['TAG']));
	}

	function insert_ecat($dataMSM, $dataMLT) {
		$this -> db -> select('COUNT(*)') -> from($this -> table) -> where("MATNR", $dataMSM['MATNR'], TRUE);
		$query = $this -> db -> get();
		$result = $query -> row_array();
		$count = $result['COUNT(*)'];
		//print_r($data['MATNR']);
		if ($count < 1) {
			$this -> db -> insert($this -> table, $dataMSM);
		} else {
			$this -> db -> where("MATNR", $dataMSM['MATNR'], TRUE);
			$this -> db -> update($this -> table, $dataMSM);
		}
		//$this->db->_reset_select();
		$this -> db -> select('COUNT(*)') -> from("EC_M_LONGTEXT") -> where("MATNR", $dataMLT['MATNR'], TRUE) -> where("NO", $dataMLT['NO'], TRUE);
		$query = $this -> db -> get();
		$result = $query -> row_array();
		$count = $result['COUNT(*)'];
		//print_r($data['MATNR']);
		if ($count > 0) {
			$this -> db -> delete("EC_M_LONGTEXT", array('MATNR' => $dataMLT['MATNR'], 'NO' => $dataMLT['NO']));
		}
		$this -> db -> insert("EC_M_LONGTEXT", $dataMLT);
	}

}

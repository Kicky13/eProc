<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_konfigurasi_lansgung_m extends CI_Model {
	protected $table = 'EC_M_STRATEGIC_MATERIAL', $tableCategory = 'EC_M_CATEGORY', $tableAssign = 'EC_PL_ASSIGN', $tablVndPrd = 'VND_PRODUCT', $tableVnd = 'VND_HEADER';
	//protected $all_field = 'MONITORING_INVOICE.BUKRS, MONITORING_INVOICE.LIFNR, BELNR, GJAHR, BIL_NO, NAME1, BKTXT, SGTXT, XBLNR, UMSKZ, BUDAT, BLDAT, CPUDT, MONAT, ZLSPR, WAERS, HWAER, ZLSCH, ZTERM, DMBTR, WRBTR, BLART, STATUS, BYPROV, DATEPROV, DATECOL, WWERT, TGL_KIRUKP, USER_UKP, STAT_VER, TGL_VER, TGL_KIRVER, TGL_KEMB_VER, USER_VER, STAT_BEND, TGL_BEND, TGL_KIRBEND, TGL_KEMB_BEN, USER_BEN, STAT_AKU, TGL_AKU, TGL_KEMB_AKU, U_NAME, AUGDT, STAT_REJ, NO_REJECT, STATUS_UKP, NYETATUS, EBELN, EBELP, MBELNR, MGJAHR, PROJK, PRCTR, HBKID, DBAYAR, TBAYAR, UBAYAR, DGROUP, TGROUP, UGROUP, LUKP, LVER, LBEN, LAKU, AWTYPE, AWKYE, LBEN2, MWSKZ, HWBAS, FWBAS, HWSTE, FWSTE, WT_QBSHH, WT_QBSHB ';
	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	public function getItemOld($kode_user) {
		$this -> db -> from($this -> table);
		$this -> db -> join('EC_PL_ASSIGN', 'EC_M_STRATEGIC_MATERIAL.MATNR = EC_PL_ASSIGN.MATNO', 'left');
		$this -> db -> join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'inner');
		$this -> db -> order_by('PUBLISHED_LANGSUNG DESC');
		$this -> db -> where("EC_M_CATEGORY.KODE_USER LIKE '" . $kode_user . "%'");
		$this -> db -> or_where("EC_M_STRATEGIC_MATERIAL.PUBLISHED_LANGSUNG = 1");
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function publish($items = '', $stat = '1') {
		foreach ($items as $value) {
			$this -> db -> where("EC_M_STRATEGIC_MATERIAL.MATNR", $value, true);
			$this -> db -> update('EC_M_STRATEGIC_MATERIAL', array('PUBLISHED_LANGSUNG' => $stat));
		}
	}

	public function getVnd($matgrp = '') {
		$slc = "MATKL,PRODUCT_CODE,VND_PRODUCT.VENDOR_ID,VND_HEADER.VENDOR_NO,VENDOR_NAME";
		$this -> db -> from($this -> table);
		$this -> db -> select($slc);
		$this -> db -> join('VND_PRODUCT', 'EC_M_STRATEGIC_MATERIAL.MATKL = VND_PRODUCT.PRODUCT_CODE', 'inner');
		$this -> db -> join('VND_HEADER', 'VND_PRODUCT.VENDOR_ID = VND_HEADER.VENDOR_ID', 'left');
		// $this -> db -> join('(SELECT VENDORNO FROM EC_PL_ASSIGN GROUP BY VENDORNO) PL', 'VND_PRODUCT.VENDOR_ID = PL.VENDORNO', 'left');
		$this -> db -> where("VND_HEADER.VENDOR_NO IS NOT NULL");
		// $this -> db -> where("EC_M_STRATEGIC_MATERIAL.MATKL", $matgrp[0], true);
		$SQL=("(EC_M_STRATEGIC_MATERIAL.MATKL = '" . $matgrp[0] . "'");
		for ($i = 1; $i < sizeof($matgrp); $i++)
			$SQL .=(" OR EC_M_STRATEGIC_MATERIAL.MATKL = '" . $matgrp[$i] . "'");
		$this -> db -> where($SQL.')');
		$this -> db -> group_by($slc);
		// $this -> db -> order_by('PL.VENDORNO');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}
 
	public function getVndMatno($matno = '', $matnogrp = '') {
		$slc = "MATKL,PRODUCT_CODE,VND_PRODUCT.VENDOR_ID,VND_HEADER.VENDOR_NO,PL.VENDORNO,VENDOR_NAME";
		$this -> db -> from($this -> table);
		$this -> db -> select($slc);
		$this -> db -> join('VND_PRODUCT', 'EC_M_STRATEGIC_MATERIAL.MATKL = VND_PRODUCT.PRODUCT_CODE', 'inner');
		$this -> db -> join('VND_HEADER', 'VND_PRODUCT.VENDOR_ID = VND_HEADER.VENDOR_ID', 'left');
		$this -> db -> join("(SELECT VENDORNO FROM EC_PL_ASSIGN WHERE MATNO='" . $matno . "' GROUP BY VENDORNO) PL", 'VND_HEADER.VENDOR_NO = PL.VENDORNO', 'left');
		$this -> db -> where("VND_HEADER.VENDOR_NO IS NOT NULL"); 
		// $this -> db -> where("EC_M_STRATEGIC_MATERIAL.MATNR", $matno, true);
		$this -> db -> where("EC_M_STRATEGIC_MATERIAL.MATKL = '" . $matnogrp[0] . "'");
		// $this -> db -> where("(EC_M_STRATEGIC_MATERIAL.MATNR = '" . $matno . "' AND EC_M_STRATEGIC_MATERIAL.MATKL = '" . $matnogrp[0] . "')");
		$this -> db -> group_by($slc);
		$this -> db -> order_by('PL.VENDORNO');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

 	public function getVndMatnoOld($matno = '', $matnogrp = '') {
		$slc = "MATKL,PRODUCT_CODE,VND_PRODUCT.VENDOR_ID,VND_HEADER.VENDOR_NO,PL.VENDORNO,VENDOR_NAME";
		$this -> db -> from($this -> table);
		$this -> db -> select($slc);
		$this -> db -> join('VND_PRODUCT', 'EC_M_STRATEGIC_MATERIAL.MATKL = VND_PRODUCT.PRODUCT_CODE', 'inner');
		$this -> db -> join('VND_HEADER', 'VND_PRODUCT.VENDOR_ID = VND_HEADER.VENDOR_ID', 'left');
		$this -> db -> join("(SELECT VENDORNO FROM EC_PL_ASSIGN WHERE MATNO='" . $matno . "' GROUP BY VENDORNO) PL", 'VND_HEADER.VENDOR_NO = PL.VENDORNO', 'left');
		$this -> db -> where("VND_HEADER.VENDOR_NO IS NOT NULL"); 
		// $this -> db -> where("EC_M_STRATEGIC_MATERIAL.MATNR", $matno, true);
		$this -> db -> where("EC_M_STRATEGIC_MATERIAL.MATKL = '" . $matnogrp[0] . "'");
		// $this -> db -> where("(EC_M_STRATEGIC_MATERIAL.MATNR = '" . $matno . "' AND EC_M_STRATEGIC_MATERIAL.MATKL = '" . $matnogrp[0] . "')");
		$this -> db -> group_by($slc);
		$this -> db -> order_by('PL.VENDORNO');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	//INSERT INTO "EPROC"."EC_PL_ASSIGN"
	//("KODE_ASSIGN", "MATNO", "VENDORNO", "START_DATE", "END_DATE", "INDATE", "ROWID") VALUES
	//('3', '701-201-0409', '0000110013', TO_DATE('2017-01-11 13:48:28', 'SYYYY-MM-DD HH24:MI:SS'), TO_DATE('2017-01-13 13:48:32', 'SYYYY-MM-DD HH24:MI:SS'), TO_DATE('2017-01-11 13:48:45', 'SYYYY-MM-DD HH24:MI:SS'), 'AAB7BDABPAAAADrAAA');
	//'SYYYY-MM-DD HH24:MI:SS'
	public function insert($itms, $vnds, $startDate, $endDate) {
		$now = date("Y-m-d h:i:s");
		foreach ($itms as $value) {
			$this -> db -> where('MATNO', $value);
			$this -> db -> delete('EC_PL_ASSIGN');
			foreach ($vnds as $values) {
				$SQL = "INSERT INTO EC_PL_ASSIGN
				VALUES
					(
						'3',
						'" . $value . "',
						'" . $values . "',
						TO_DATE (
							'" . $startDate . "',
							'DD-MM-YYYY HH24:MI:SS'
						),
						TO_DATE (
							'" . $endDate . "',
							'DD-MM-YYYY HH24:MI:SS'
						),
						TO_DATE (
							'" . $now . "',
							'SYYYY-MM-DD HH24:MI:SS'
						),NULL
					)";
				$this -> db -> query($SQL);
			}
		}
		// return (array)$result -> result_array();
	}

	public function edit($itms, $vnds, $startDate, $endDate) {
		$this -> db -> where('MATNO', $itms);
		$this -> db -> delete('EC_PL_ASSIGN');
		$now = date("Y-m-d h:i:s");
		foreach ($vnds as $values) {
			$SQL = "INSERT INTO EC_PL_ASSIGN
				VALUES
					(
						'3',
						'" . $itms . "',
						'" . $values . "',
						TO_DATE (
							'" . $startDate . "',
							'DD-MM-YYYY HH24:MI:SS'
						),
						TO_DATE (
							'" . $endDate . "',
							'DD-MM-YYYY HH24:MI:SS'
						),
						TO_DATE (
							'" . $now . "',
							'SYYYY-MM-DD HH24:MI:SS'
						),NULL
					)";
			$this -> db -> query($SQL);
		}
	}

	public function getItem($kode_user) {
		$SQL = "SELECT
				EM.MATNR,
				EM.MATKL,
				EM.MAKTX,
				EM.MEINS,
				EC.KODE_USER,
				EC.ID_CAT,
				EM.ID_CAT,
				PL.MATNO,
				EM.PUBLISHED_LANGSUNG,
				TO_CHAR (PL.START_DATE,'DD/MM/YYYY') PEMBUKAAN,
				TO_CHAR (PL.END_DATE,'DD/MM/YYYY') PENUTUPAN
			FROM
				EC_M_STRATEGIC_MATERIAL EM
			LEFT JOIN (SELECT MATNO,START_DATE,END_DATE FROM EC_PL_ASSIGN GROUP BY MATNO,START_DATE,END_DATE) PL ON EM.MATNR = PL.MATNO
			INNER JOIN EC_M_CATEGORY EC ON EC.ID_CAT = EM.ID_CAT
			WHERE
				EC.KODE_USER LIKE '" . $kode_user . "%' OR
				EM.PUBLISHED_LANGSUNG=1			 
			ORDER BY
					EM.PUBLISHED_LANGSUNG DESC";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getItemPublish() {
		$SQL = "SELECT
				EM.MATNR,
				EM.MATKL,
				EM.MAKTX,
				EM.MEINS,
				EC.KODE_USER,
				EC.ID_CAT,
				EM.ID_CAT,
				PL.MATNO,
				EM.PUBLISHED_LANGSUNG,
				TO_CHAR (PL.START_DATE,'DD-MM-YYYY') PEMBUKAAN,
				TO_CHAR (PL.END_DATE,'DD-MM-YYYY') PENUTUPAN
			FROM
				EC_M_STRATEGIC_MATERIAL EM
			LEFT JOIN (SELECT MATNO,START_DATE,END_DATE FROM EC_PL_ASSIGN GROUP BY MATNO,START_DATE,END_DATE) PL ON EM.MATNR = PL.MATNO
			INNER JOIN EC_M_CATEGORY EC ON EC.ID_CAT = EM.ID_CAT
			WHERE
				EM.PUBLISHED_LANGSUNG=1			 
			ORDER BY
					EM.PUBLISHED_LANGSUNG DESC";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getItemOld2($kode_user) {
		$SQL = "SELECT
				EM.MATNR,
				EM.MATKL,
				EM.MAKTX,
				EM.MEINS,
				EC.KODE_USER,
				EC.ID_CAT,
				EM.ID_CAT,
				PL.MATNO,
				TO_CHAR (PL.START_DATE,'DD/MM/YYYY HH24:MI:SS'),
				TO_CHAR (PL.END_DATE,'DD/MM/YYYY HH24:MI:SS')
			FROM
				EC_M_STRATEGIC_MATERIAL EM
			--LEFT JOIN EC_PL_ASSIGN PL ON EM.MATNR = PL.MATNO
			INNER JOIN EC_M_CATEGORY EC ON EC.ID_CAT = EM.ID_CAT
			WHERE
				EC.KODE_USER LIKE '1-3%'
			OR --PL.KODE_ASSIGN IS NOT NULL
			EM.PUBLISHED_LANGSUNG=1
			GROUP BY
				EM.MATNR,
				EM.MATKL,
				EM.MAKTX,
				EM.MEINS,
				EC.KODE_USER,
				EC.ID_CAT,
				EM.ID_CAT,
				PL.MATNO,
				TO_CHAR (
					PL.START_DATE,
					'DD/MM/YYYY HH24:MI:SS'
				),
				TO_CHAR (
					PL.END_DATE,
					'DD/MM/YYYY HH24:MI:SS'
				)
				ORDER BY
					EM.PUBLISHED_LANGSUNG DESC";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

}

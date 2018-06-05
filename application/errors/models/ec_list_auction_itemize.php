<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_list_auction_itemize extends CI_Model {
	protected $table_aunction = 'EC_AUCTION_ITEMIZE_HEADER', $tableItem = 'EC_AUCTION_ITEMIZE_ITEM', $tablePeserta = 'EC_AUCTION_ITEMIZE_PESERTA', $tableItemTemp = 'EC_AUCTION_ITEMIZE_ITEM_temp', $tablePesertaTemp = 'EC_AUCTION_ITEMIZE_P_temp', $tableLog = 'EC_AUCTION_ITEMIZE_LOG', $tableBatch = 'EC_AUCTION_ITEMIZE_BATCH', $tableItemPrice = 'EC_AUCTION_ITEMIZE_PRICE';
	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	public function get_list_auction($KODE_VENDOR = '') {
		// $this -> db -> from($this -> table_aunction);
		// $this -> db -> where("IS_ACTIVE", '1', TRUE);
		$SQL = "SELECT DISTINCT
		AH.*,
		AP.STATUS STAT,
		COUNT (*) OVER () AS HITUNG_BATCH
		FROM
		EC_AUCTION_ITEMIZE_HEADER AH
		inner JOIN EC_AUCTION_ITEMIZE_PESERTA AP ON AH.NO_TENDER = AP.ID_HEADER
		inner join EC_AUCTION_ITEMIZE_BATCH AB ON AH.NO_TENDER = AB.ID_HEADER
		WHERE
		AP.USERID = '" . $KODE_VENDOR . "'
		AND AH.IS_ACTIVE = '2'
		ORDER BY
		AH.TGL_TUTUP DESC";
		// '" . $ptm . "'
		$result = $this -> db -> query($SQL);
		//$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_Auction($NO_TENDER,$NO_BATCH) {
		$SQL = "SELECT
		AC.COMPANYNAME, H .*, TO_CHAR (
		B .TGL_BUKA,
		'DD/MM/YYYY HH24:MI:SS' 
		) AS PEMBUKAAN,
		TO_CHAR (
		B .TGL_TUTUP,
		'DD/MM/YYYY HH24:MI:SS'
		) AS PENUTUPAN, 
		B. IS_ACTIVE AS B_IS_ACTIVE
		FROM
		EC_AUCTION_ITEMIZE_HEADER H
		INNER JOIN EC_AUCTION_ITEMIZE_BATCH B ON H.NO_TENDER = B.ID_HEADER
		INNER JOIN ADM_COMPANY AC ON AC.COMPANYID = H.COMPANYID 
		WHERE
		H.NO_TENDER = '" . $NO_TENDER . "'
		AND B.NAME = '" . $NO_BATCH . "'
		";
		$result = $this -> db -> query($SQL);

		// $this -> db -> from($this -> tableHeader);
		// $this -> db -> where("NO_TENDER", $NO_TENDER, TRUE);
		// $query = $this -> db -> get();
		return $result -> row_array();
	}

	public function setuju($notender = '', $setuju, $kodevnd) {
		$this -> db -> set('STATUS', $setuju);
		$this -> db -> where('ID_HEADER', $notender);
		$this -> db -> where('KODE_VENDOR', $kodevnd);
		$this -> db -> update($this -> tablePeserta);
	}

	public function getBatch($ID_HEADER) {
		$this -> db -> from($this -> tableBatch);
		$this -> db -> where("ID_HEADER", $ID_HEADER, TRUE);
		$this -> db -> order_by('NAME', 'ASC');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getPesertaId($NO_TENDER, $USERID) {
		$SQL = "
		SELECT DISTINCT
		(
		EPP.KODE_VENDOR
		),
		EPP.*, EPR.KONVERSI, ecur.*
		FROM
		EC_AUCTION_ITEMIZE_PESERTA epp
		LEFT JOIN EC_AUCTION_ITEMIZE_PRICE epr ON EPP.KODE_VENDOR = EPR.ID_PESERTA
		INNER JOIN ADM_CURR ecur on ecur.CURR_CODE = EPP.CURRENCY
		WHERE
		EPP.ID_HEADER = '".$NO_TENDER."'
		AND EPR.ID_HEADER = '".$NO_TENDER."'
		AND EPP.KODE_VENDOR = '".$USERID."'
		";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}


	public function get_list_auction_user() {
		// $this -> db -> from($this -> table_aunction);
		// $this -> db -> where("IS_ACTIVE", '1', TRUE);
		$SQL1 = "SELECT
		AH.*, TO_CHAR (
		AH.TGL_BUKA,
		'DD/MM/YYYY HH24:MI:SS'
		) AS PEMBUKAAN,
		TO_CHAR (
		AH.TGL_TUTUP,
		'DD/MM/YYYY HH24:MI:SS'
		) AS PENUTUPAN
		FROM
		EC_AUCTION_ITEMIZE_HEADER AH	 
		ORDER BY
		AH.NO_TENDER DESC";

		$SQL = '
		SELECT
		AH.NO_TENDER,
		MAX(TO_CHAR (
		AH.TGL_CREATE,
		\'DD/MM/YYYY\'
		)) AS CREATED,
		"MAX" (AH."DESC") AS DESC_NEW,
		"MAX" (AH.IS_ACTIVE) AS ACTIVE_NEW
		FROM
		EC_AUCTION_ITEMIZE_HEADER AH
		WHERE
		IS_ACTIVE = 1
		OR IS_ACTIVE = 2
		OR IS_ACTIVE = 0
		GROUP BY
		AH.NO_TENDER
		ORDER BY
		AH.NO_TENDER DESC
		';
		// '" . $ptm . "'
		$result = $this -> db -> query($SQL);
		//$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_detail_auction($NO_TENDER,$NO_BATCH) {
		$SQL1 = "SELECT
		H .*, TO_CHAR (
		B .TGL_BUKA,
		'DD/MM/YYYY HH24:MI:SS' 
		) AS PEMBUKAAN,
		TO_CHAR (
		B .TGL_TUTUP,
		'DD/MM/YYYY HH24:MI:SS'
		) AS PENUTUPAN
		FROM
		EC_AUCTION_ITEMIZE_HEADER H
		INNER JOIN EC_AUCTION_ITEMIZE_BATCH B ON H.NO_TENDER = B.ID_HEADER 
		WHERE
		H.NO_TENDER = '" . $NO_TENDER . "'";

		$SQL = "SELECT
		H .*, TO_CHAR (
		B .TGL_BUKA,
		'DD/MM/YYYY HH24:MI:SS' 
		) AS PEMBUKAAN,
		TO_CHAR (
		B .TGL_TUTUP,
		'DD/MM/YYYY HH24:MI:SS'
		) AS PENUTUPAN, 
		B. IS_ACTIVE AS B_IS_ACTIVE
		FROM
		EC_AUCTION_ITEMIZE_HEADER H
		INNER JOIN EC_AUCTION_ITEMIZE_BATCH B ON H.NO_TENDER = B.ID_HEADER 
		WHERE
		H.NO_TENDER = '" . $NO_TENDER . "'
		AND B.NAME = '" . $NO_BATCH . "'
		";
		$result = $this -> db -> query($SQL);

		// $this -> db -> from($this -> tableHeader);
		// $this -> db -> where("NO_TENDER", $NO_TENDER, TRUE);
		// $query = $this -> db -> get();
		return $result -> row_array();
	}

	public function get_detail_auction2($NO_TENDER,$NO_BATCH) {
		$SQL = "SELECT
		H .*, TO_CHAR (
		B .TGL_BUKA,
		'YYYY-MM-DD HH24:MI:SS' 
		) AS PEMBUKAAN,
		TO_CHAR (
		B .TGL_TUTUP,
		'YYYY-MM-DD HH24:MI:SS'
		) AS PENUTUPAN, 
		B. IS_ACTIVE AS B_IS_ACTIVE
		FROM
		EC_AUCTION_ITEMIZE_HEADER H
		INNER JOIN EC_AUCTION_ITEMIZE_BATCH B ON H.NO_TENDER = B.ID_HEADER 
		WHERE
		H.NO_TENDER = '" . $NO_TENDER . "'
		AND B.NAME = '" . $NO_BATCH . "'
		";
		$result = $this -> db -> query($SQL);

		// $this -> db -> from($this -> tableHeader);
		// $this -> db -> where("NO_TENDER", $NO_TENDER, TRUE);
		// $query = $this -> db -> get();
		return $result -> row_array();
	}

	public function get_Itemlist($NO_TENDER) {
		$this -> db -> from($this -> tableItem);
		$this -> db -> where("ID_HEADER", $NO_TENDER, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getBatchDetail($ID_HEADER, $ID_BATCH) {
		$this -> db -> from($this -> tableBatch);
		$this -> db -> where("ID_HEADER", $ID_HEADER, TRUE);
		$this -> db -> where("NAME", $ID_BATCH, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	// public function getBatchDetailItem($ID_HEADER, $ID_ITEM) {
	// 	$SQL = '
	// 	select * from EC_AUCTION_ITEMIZE_ITEM
	// 	where ID_ITEM IN ('.$ID_ITEM.')
	// 	and ID_HEADER = '.$ID_HEADER.;
	// 	// echo $SQL;die;
	// 	$result = $this -> db -> query($SQL);
	// 	return (array)$result -> result_array();
	// }

	public function get_vendor($NO_TENDER, $KODE_VENDOR) {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> where("ID_HEADER", $NO_TENDER, TRUE);
		$this -> db -> where("KODE_VENDOR", $KODE_VENDOR, TRUE);
		$result = $this -> db -> get();
		// return (array)$result -> result_array();
		return $result -> row_array();
	}

	public function get_min_bid($no_tender = '') {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> join('EC_AUCTION_ITEMIZE_LOG', 'EC_AUCTION_ITEMIZE_LOG.NO_TENDER = EC_AUCTION_ITEMIZE_PESERTA.ID_HEADER AND EC_AUCTION_ITEMIZE_LOG.VENDOR_NO = EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR', 'left');
		$this -> db -> order_by('HARGATERKINI');
		$this -> db -> order_by('CREATED_AT', 'ASC');
		$this -> db -> where('ID_HEADER', $no_tender);
		$query = $this -> db -> get();
		return $query -> row_array();
	}

	public function get_min_bid_itemize($no_tender = '', $id_item = '') {
		$this -> db -> from($this -> tableItemPrice);
		$this -> db -> order_by('HARGATERKINI', 'ASC');
		$this -> db -> where('ID_HEADER', $no_tender);
		$this -> db -> where('HARGA >', 0);
		$this -> db -> where('ID_ITEM', (string)$id_item);
		$query = $this -> db -> get();
		return $query -> row_array();
	}

	public function get_min_bid_itemize_coba($no_tender = '', $id_item = '') {
		$SQL = "
		select * from EC_AUCTION_ITEMIZE_PRICE
		where ID_HEADER = ".$no_tender."
		and HARGA > 0
		and ID_ITEM = '".$id_item."'
		order by BM_HB ASC
		";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function get_min_bid_itemize_coba2($no_tender = '', $id_item = '') {
		$SQL = "
		SELECT
		*
		FROM
		EC_AUCTION_ITEMIZE_PRICE ERP
		INNER JOIN EC_AUCTION_ITEMIZE_PESERTA EP ON EP.ID_HEADER = ERP.ID_HEADER
		AND ERP.ID_PESERTA = EP.KODE_VENDOR
		INNER JOIN (
		SELECT
		MAX (LG.CREATED_AT) AS TGL,
		LG.VENDOR_NO
		FROM
		EC_AUCTION_ITEMIZE_LOG LG
		WHERE
		LG.NO_TENDER = '".$no_tender."'
		GROUP BY
		LG.VENDOR_NO
		ORDER BY
		TGL ASC
		) TB2 ON TB2.VENDOR_NO = EP.KODE_VENDOR
		WHERE
		ERP.ID_HEADER = '".$no_tender."'
		AND EP.ID_HEADER = '".$no_tender."'
		AND ERP.HARGA > 0
		AND ERP.ID_ITEM = '".$id_item."'
		ORDER BY
		ERP.BM_HB,
		TB2.TGL
		";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function get_harga_barang($no_tender = '', $id_item = '') {
		$this -> db -> from($this -> tableItem);
		$this -> db -> where('ID_HEADER', $no_tender);
		$this -> db -> where('ID_ITEM', (string)$id_item);
		$query = $this -> db -> get();
		return $query -> row_array();
	}

	public function checkSendiri($no_tender = '', $id_item = ''){
		$SQL = "
		select * from EC_AUCTION_ITEMIZE_PRICE
		where ID_HEADER = ".$no_tender."
		and ID_ITEM = '".$id_item."'
		and HARGA > 0
		ORDER BY
		HARGATERKINI ASC
		";
		return $this -> db -> query($SQL);
	}

	public function getRanking1($no_tender = '', $id_item = '', $id_PESERTA = '') {
		$SQL = '
		select * from EC_AUCTION_ITEMIZE_PRICE
		where ID_ITEM IN (\''.$id_item.'\')
		and ID_HEADER = '.$no_tender.'
		AND RANKING = 1
		and ID_PESERTA = '.$id_PESERTA;
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function get_min_bid_itemize_gak_menang($no_tender = '', $id_item = '', $id_PESERTA = '') {
		$this -> db -> from($this -> tableItemPrice);
		$this -> db -> order_by('HARGATERKINI', 'ASC');
		$this -> db -> where('ID_HEADER', $no_tender);
		$this -> db -> where('ID_ITEM', (string)$id_item);
		$this -> db -> where('ID_PESERTA', $id_PESERTA);
		$query = $this -> db -> get();
		return $query -> row_array();
	}

	public function bid($KODE_VENDOR, $no_tender = '', $ID_ITEM = '', $HARGATERKINI = '', $KONVERSI_IDR_UBAH = '', $BM_HB = '') {
		$this -> db -> set('BM_HB', $BM_HB);
		$this -> db -> set('KONVERSI_IDR_UBAH', $KONVERSI_IDR_UBAH);
		$this -> db -> set('HARGATERKINI', $HARGATERKINI);
		$this -> db -> where('ID_HEADER', $no_tender);
		$this -> db -> where('ID_PESERTA', $KODE_VENDOR);
		$this -> db -> where('ID_ITEM', (string)$ID_ITEM);
		$this -> db -> update($this -> tableItemPrice);

		$SQL = "INSERT INTO EC_AUCTION_ITEMIZE_LOG   
		values
		('" . $KODE_VENDOR . "',TO_DATE('" . date('d/m/Y h:i:s') . "', 'dd/mm/yyyy hh24:mi:ss'),'" . $HARGATERKINI . "', 
		CASE 
		WHEN (SELECT MAX(ITER) FROM EC_AUCTION_ITEMIZE_LOG WHERE VENDOR_NO='" . $KODE_VENDOR . "' AND NO_TENDER='" . $no_tender . "')IS NULL THEN 0
		ELSE (SELECT MAX(ITER) FROM EC_AUCTION_ITEMIZE_LOG WHERE VENDOR_NO='" . $KODE_VENDOR . "' AND NO_TENDER='" . $no_tender . "')+1
		END, '0', 
		'" . $no_tender . "', 
		'" . $ID_ITEM . "')";
		$this -> db -> query($SQL);

		$SQL = "
		SELECT
		CASE
		WHEN (
		SELECT
		HARGATERKINI
		FROM
		EC_AUCTION_ITEMIZE_PESERTA
		WHERE
		ID_HEADER = '".$no_tender."'
		AND KODE_VENDOR = '".$KODE_VENDOR."'
		) < (
		SELECT
		HPS
		FROM
		EC_AUCTION_ITEMIZE_ITEM
		WHERE
		ID_HEADER = '".$no_tender."'
		AND ID_ITEM = '".$ID_ITEM."'

		) THEN
		'ece'
		ELSE
		'not'
		END status
		FROM
		dual
		";
		$query = $this -> db -> query($SQL);
		return $query -> row_array();
	}

	function test($value = '') {
		$SQL = "select CASE
		WHEN (
		SELECT
		HARGATERKINI
		FROM
		EC_AUCTION_ITEMIZE_PESERTA
		WHERE
		ID_HEADER = '1'
		AND KODE_VENDOR = '1'
		) < (
		SELECT
		HPS
		FROM
		EC_AUCTION_ITEMIZE_HEADER
		WHERE
		NO_TENDER = '1'
		) THEN
		'ece'
		ELSE
		'not'
		END status
		from dual";
		$query = $this -> db -> query($SQL);
		return $query -> row_array();
	}

}

//
// $this->db->set('field', 'field+1');
// $this->db->where('id', 2);
// $this->db->update('mytable');
// $this -> db -> where('ID_USER', $user);
// $this -> db -> delete('EC_AUCTION_ITEM_temp');
//
// $SQL = 'INSERT INTO EC_AUCTION_PESERTA
// SELECT *
// FROM "EC_AUCTION_PESERTA_temp"
// where ID_USER=\'' . $user . '\'';
// $this -> db -> query($SQL);
//
// $this -> db -> where('ID_USER', $user);
// $this -> db -> delete('EC_AUCTION_PESERTA_temp');

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ec_list_auction_bobot extends CI_Model {
	protected $table_aunction = 'EC_AUCTION_BOBOT_HEADER', $tableItem = 'EC_AUCTION_BOBOT_ITEM', $tablePeserta = 'EC_AUCTION_BOBOT_PESERTA', $tableItemTemp = 'EC_AUCTION_BOBOT_ITEM_temp', $tablePesertaTemp = 'EC_AUCTION_BOBOT_PESERTA_temp', $tableLog = 'EC_AUCTION_BOBOT_LOG';
	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	public function get_list_auction($KODE_VENDOR = '') {
		// $this -> db -> from($this -> table_aunction);
		// $this -> db -> where("IS_ACTIVE", '1', TRUE);
		$SQL = "SELECT
					AH.*,AP.STATUS STAT, TO_CHAR (
						AH.TGL_BUKA,
						'DD/MM/YYYY HH24:MI:SS'
					) AS PEMBUKAAN,
					TO_CHAR (
						AH.TGL_TUTUP,
						'DD/MM/YYYY HH24:MI:SS'
					) AS PENUTUPAN
				FROM
					EC_AUCTION_BOBOT_HEADER AH
				inner JOIN EC_AUCTION_BOBOT_PESERTA AP ON AH.NO_TENDER = AP.ID_HEADER
				WHERE
					AP.USERID = '" . $KODE_VENDOR . "'
				AND AH.IS_ACTIVE = '1'
				ORDER BY
					AH.TGL_TUTUP DESC";
		// '" . $ptm . "'
		$result = $this -> db -> query($SQL);
		//$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function setuju($notender = '', $setuju, $kodevnd) {
		$this -> db -> set('STATUS', $setuju);
		$this -> db -> where('ID_HEADER', $notender);
		$this -> db -> where('KODE_VENDOR', $kodevnd);
		$this -> db -> update($this -> tablePeserta);
	}

	public function get_list_auction_user() {
		// $this -> db -> from($this -> table_aunction);
		// $this -> db -> where("IS_ACTIVE", '1', TRUE);
		$SQL = "SELECT
					AH.*, TO_CHAR (
						AH.TGL_BUKA,
						'DD/MM/YYYY HH24:MI:SS'
					) AS PEMBUKAAN,
					TO_CHAR (
						AH.TGL_TUTUP,
						'DD/MM/YYYY HH24:MI:SS'
					) AS PENUTUPAN
				FROM
					EC_AUCTION_BOBOT_HEADER AH	 
				ORDER BY
					AH.NO_TENDER DESC";
		// '" . $ptm . "'
		$result = $this -> db -> query($SQL);
		//$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_detail_auction($NO_TENDER) {
		$SQL = "SELECT
					H .*, TO_CHAR (
						H .TGL_BUKA,
						'DD/MM/YYYY HH24:MI:SS'
					) AS PEMBUKAAN,
					TO_CHAR (
						H .TGL_TUTUP,
						'DD/MM/YYYY HH24:MI:SS'
					) AS PENUTUPAN,
					TO_CHAR (
						H .TGL_TUTUP,
						'YYYY-MM-DD HH24:MI:SS'
					) AS DATEPENUTUPAN,
					TO_CHAR (
						H .TGL_BUKA,
						'YYYY-MM-DD HH24:MI:SS'
					) AS DATEPEMBUKAAN
				FROM
					EC_AUCTION_BOBOT_HEADER H
				WHERE
					H.NO_TENDER = '" . $NO_TENDER . "'";
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

	public function get_vendor($NO_TENDER, $KODE_VENDOR) {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> where("ID_HEADER", $NO_TENDER, TRUE);
		$this -> db -> where("KODE_VENDOR", $KODE_VENDOR, TRUE);
		$result = $this -> db -> get();
		// return (array)$result -> result_array();
		return $result -> row_array();
	}

	public function get_Allvendor($NO_TENDER) {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> where("ID_HEADER", $NO_TENDER, TRUE);
		//$this -> db -> order_by("HARGATERKINI", "ASC");
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	// public function get_Allvendor($NO_TENDER) {
	// 	$this -> db -> from($this -> tablePeserta);
	// 	$this -> db -> where("ID_HEADER", $NO_TENDER);
	// 	$this -> db -> where("KODE_VENDOR", $KODE_VENDOR, TRUE);
	// 	$result = $this -> db -> get();
	// 	// return (array)$result -> result_array();
	// 	return $result -> row_array();
	// }

	// public function get_Allvendor($no_tender) {
	// 	$SQL = 'SELECT *
	// 	FROM
	// 	"EC_AUCTION_BOBOT_PESERTA"
	// 	WHERE
	// 	ID_HEADER = \'' . $no_tender . '\'';
	// 	$result = $this -> db -> query($SQL);
	// 	return $result -> row_array();
	// }

	public function get_min_harga($no_tender) {
		$SQL = 'SELECT
		MIN(HARGATERKINI) AS MINHARGA
		FROM
		"EC_AUCTION_BOBOT_PESERTA"
		WHERE
		ID_HEADER = \'' . $no_tender . '\'';
		$result = $this -> db -> query($SQL);
		return $result -> row_array();
	}

	public function get_min_bid($no_tender = '') {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> join('EC_AUCTION_BOBOT_LOG', 'EC_AUCTION_BOBOT_LOG.NO_TENDER = EC_AUCTION_BOBOT_PESERTA.ID_HEADER AND EC_AUCTION_BOBOT_LOG.VENDOR_NO = EC_AUCTION_BOBOT_PESERTA.KODE_VENDOR', 'left');
		$this -> db -> order_by('NILAI_GABUNG DESC');
		$this -> db -> order_by('CREATED_AT', 'ASC');
		$this -> db -> where('ID_HEADER', $no_tender);
		$query = $this -> db -> get();
		return $query -> row_array();
	}

	public function bid($KODE_VENDOR, $no_tender = '', $HARGATERKINI = '') {
		$this -> db -> set('HARGATERKINI', $HARGATERKINI);
		$this -> db -> where('ID_HEADER', $no_tender);
		$this -> db -> where('KODE_VENDOR', $KODE_VENDOR);
		$this -> db -> update($this -> tablePeserta);

		$SQL = "INSERT INTO EC_AUCTION_BOBOT_LOG   
				values
				('" . $KODE_VENDOR . "',TO_DATE('" . date('d/m/Y h:i:s') . "', 'dd/mm/yyyy hh24:mi:ss'),'" . $HARGATERKINI . "', 
				 CASE 
				 WHEN (SELECT MAX(ITER) FROM EC_AUCTION_BOBOT_LOG WHERE VENDOR_NO='" . $KODE_VENDOR . "' AND NO_TENDER='" . $no_tender . "')IS NULL THEN 0
				 ELSE (SELECT MAX(ITER) FROM EC_AUCTION_BOBOT_LOG WHERE VENDOR_NO='" . $KODE_VENDOR . "' AND NO_TENDER='" . $no_tender . "')+1
				 END, '0', 
				 '" . $no_tender . "')";
		$this -> db -> query($SQL);

		$SQL = "select CASE
				WHEN (
					SELECT
						HARGATERKINI
					FROM
						EC_AUCTION_BOBOT_PESERTA
					WHERE
						ID_HEADER = '" . $no_tender . "'
					AND KODE_VENDOR = '" . $KODE_VENDOR . "'
				) < (
					SELECT
						HPS
					FROM
						EC_AUCTION_BOBOT_HEADER
					WHERE
						NO_TENDER = '" . $no_tender . "'
				) THEN
					'ece'
				ELSE
					'not'
				END status
				from dual";
		$query = $this -> db -> query($SQL);
		return $query -> row_array();
	}

	public function updateNilaigabung($data, $no_tender, $value) {
		$this -> db -> set('NILAI_GABUNG' , $data['NILAI_GABUNG'] , FALSE);
		$this -> db -> where('ID_HEADER', $no_tender);
		$this -> db -> where('KODE_VENDOR' , $value['KODE_VENDOR']);
		$this -> db -> update('EC_AUCTION_BOBOT_PESERTA');
		echo "<pre>";
		print_r($this -> db -> last_query());
	}

	function test($value = '') {
		$SQL = "select CASE
				WHEN (
					SELECT
						HARGATERKINI
					FROM
						EC_AUCTION_BOBOT_PESERTA
					WHERE
						ID_HEADER = '1'
					AND KODE_VENDOR = '1'
				) < (
					SELECT
						HPS
					FROM
						EC_AUCTION_BOBOT_HEADER
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
// $this -> db -> delete('EC_AUCTION_BOBOT_ITEM_temp');
//
// $SQL = 'INSERT INTO EC_AUCTION_BOBOT_PESERTA
// SELECT *
// FROM "EC_AUCTION_BOBOT_PESERTA_temp"
// where ID_USER=\'' . $user . '\'';
// $this -> db -> query($SQL);
//
// $this -> db -> where('ID_USER', $user);
// $this -> db -> delete('EC_AUCTION_BOBOT_PESERTA_temp');

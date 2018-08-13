<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_auction_itemize_m extends CI_Model {
	protected $tableHeader = 'EC_AUCTION_ITEMIZE_HEADER', $tableItem = 'EC_AUCTION_ITEMIZE_ITEM', $tablePeserta = 'EC_AUCTION_ITEMIZE_PESERTA', $tableItemTemp = 'EC_AUCTION_ITEMIZE_ITEM_temp', $tablePesertaTemp = 'EC_AUCTION_ITEMIZE_P_temp', $tableLog = 'EC_AUCTION_ITEMIZE_LOG', $tableBatch = 'EC_AUCTION_ITEMIZE_BATCH', $tableItemPrice = 'EC_AUCTION_ITEMIZE_PRICE', $tableAdmCompany = 'ADM_COMPANY', $tableVnd_header = 'VND_HEADER', $tableCurrency = 'EC_AUCTION_ITEMIZE_CURRENCY', $tableHist = 'EC_AUCTION_ITEMIZE_HIST';

	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	public function get_no_tender() {
		$this -> db -> from($this -> tableHeader);
		$this -> db -> select_max('NO_TENDER');
		$query = $this -> db -> get();
		return $query -> row_array();
	}

	public function get_useridAll() {
		$SQL = 'SELECT
		(
		CASE
		WHEN MAX (MAXs) IS NULL THEN
		0
		ELSE
		(MAX (MAXs))+1
		END
		) maks
		FROM
		(
		SELECT
		MAX (
		TO_NUMBER (SUBSTR(USERID, 4))
		) AS MAXs
		FROM
		"EC_AUCTION_ITEMIZE_PESERTA"
		UNION
		SELECT
		MAX (
		TO_NUMBER (SUBSTR(USERID, 4))
		) AS MAXs
		FROM
		"EC_AUCTION_ITEMIZE_P_temp"
		)';
		$result = $this -> db -> query($SQL);
		return $result -> row_array();
	}

	public function get_useridTemp() {
		$this -> db -> from($this -> tablePesertaTemp);
		$this -> db -> select_max("TO_NUMBER(SUBSTR(USERID, 4))", 'USERID');
		$query = $this -> db -> get();
		return $query -> row_array();
	}

	public function excelGan() {
		$this -> db -> from($this -> tablePesertaTemp);
		$this -> db -> select_max("TO_NUMBER(SUBSTR(USERID, 4))", 'USERID');
		$query = $this -> db -> get();
		return $query->result();
	}

	public function get_userid() {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> select_max("TO_NUMBER(SUBSTR(USERID, 4))", 'USERID');
		$query = $this -> db -> get();
		return $query -> row_array();
	}

	public function get_hps() {
		$SQL = 'SELECT SUM(jumlah * price) as HPS from "EC_AUCTION_ITEMIZE_ITEM_temp"';
		$result = $this -> db -> query($SQL);
		return $result -> row_array();
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

	public function getAllPeserta($NO_TENDER) {
		$SQL = "
		SELECT DISTINCT
		(
		EPP.KODE_VENDOR
		),
		EPP.*, EPR.KONVERSI
		FROM
		EC_AUCTION_ITEMIZE_PESERTA epp
		LEFT JOIN EC_AUCTION_ITEMIZE_PRICE epr ON EPP.KODE_VENDOR = EPR.ID_PESERTA
		WHERE
		EPP.ID_HEADER = '".$NO_TENDER."'
		AND EPR.ID_HEADER = '".$NO_TENDER."'
		ORDER BY EPP.TOTAL_HARGA
		";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getAllPesertaHist($NO_TENDER) {
		$SQL = "
		SELECT DISTINCT
		(
		EPP.KODE_VENDOR
		),
		EPP.*, EPR.KONVERSI
		FROM
		EC_AUCTION_ITEMIZE_PESERTA epp
		LEFT JOIN EC_AUCTION_ITEMIZE_HIST epr ON EPP.KODE_VENDOR = EPR.ID_PESERTA
		WHERE
		EPP.ID_HEADER = '".$NO_TENDER."'
		AND EPR.ID_HEADER = '".$NO_TENDER."'
		";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getAllPesertaBatch($NO_TENDER, $ID_ITEM) {
		$SQL = "
		SELECT DISTINCT
		(
		EPP.KODE_VENDOR
		),
		EPP.*, EPR.KONVERSI
		FROM
		EC_AUCTION_ITEMIZE_PESERTA epp
		LEFT JOIN EC_AUCTION_ITEMIZE_PRICE epr ON EPP.KODE_VENDOR = EPR.ID_PESERTA
		WHERE
		EPP.ID_HEADER = '".$NO_TENDER."'
		AND EPR.ID_HEADER = '".$NO_TENDER."'
		AND EPR.ID_ITEM IN (".$ID_ITEM.")
		AND EPR.HARGA<>0
		";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getAllPesertaBatchHist($NO_TENDER, $ID_ITEM) {
		$SQL = "
		SELECT DISTINCT
		(
		EPP.KODE_VENDOR
		),
		EPP.*, EPR.KONVERSI
		FROM
		EC_AUCTION_ITEMIZE_PESERTA epp
		LEFT JOIN EC_AUCTION_ITEMIZE_HIST epr ON EPP.KODE_VENDOR = EPR.ID_PESERTA
		WHERE
		EPP.ID_HEADER = '".$NO_TENDER."'
		AND EPR.ID_HEADER = '".$NO_TENDER."'
		AND EPR.ID_ITEM IN (".$ID_ITEM.")
		AND EPR.HARGA<>0
		";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function get_Itemlist($NO_TENDER) {
		$this -> db -> from($this -> tableItem);
		$this -> db -> where("ID_HEADER", $NO_TENDER, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_Header($NO_TENDER) {
		$this -> db -> from($this -> tableHeader);
		$this -> db -> where("NO_TENDER", $NO_TENDER, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_list_Peserta($NO_TENDER) {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> where("ID_HEADER", $NO_TENDER, TRUE);
		// $this -> db -> join('EC_AUCTION_LOG', 'EC_AUCTION_LOG.NO_TENDER = EC_AUCTION_PESERTA.ID_HEADER AND EC_AUCTION_LOG.VENDOR_NO = EC_AUCTION_PESERTA.KODE_VENDOR', 'left');
		$this -> db -> join("(
			SELECT MAX(LG.CREATED_AT) AS TGL, LG.VENDOR_NO FROM EC_AUCTION_ITEMIZE_LOG LG WHERE LG.NO_TENDER='". $NO_TENDER ."' AND LG.VENDOR_NO IN(SELECT PES.KODE_VENDOR FROM EC_AUCTION_ITEMIZE_PESERTA PES WHERE PES.ID_HEADER='". $NO_TENDER ."') GROUP BY LG.VENDOR_NO ORDER BY TGL ASC) TB1", 'TB1.VENDOR_NO=EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR', 'INNER');
		// $this -> db -> join(' (Select CREATED_AT,VENDOR_NO from EC_AUCTION_LOG where NO_TENDER='.$NO_TENDER.' group by CREATED_AT,VENDOR_NO) EL ', 'EL.NO_TENDER = EC_AUCTION_PESERTA.ID_HEADER AND EL.VENDOR_NO = EC_AUCTION_PESERTA.KODE_VENDOR', 'left');
		$this -> db -> order_by('HARGATERKINI');
		$this -> db -> order_by('TB1.TGL');
		// $this -> db -> order_by('CREATED_AT', 'ASC');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function urutkanRanking($no_tender = '', $id_item = '') {
		$this -> db -> from($this -> tableItemPrice);
		$this -> db -> select('EC_AUCTION_ITEMIZE_PRICE.*, EC_AUCTION_ITEMIZE_PESERTA.NAMA_VENDOR, EC_AUCTION_ITEMIZE_PESERTA.INITIAL');
		$this -> db -> join('EC_AUCTION_ITEMIZE_PESERTA', 'EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR = EC_AUCTION_ITEMIZE_PRICE.ID_PESERTA');
		$this -> db -> where('EC_AUCTION_ITEMIZE_PRICE.ID_HEADER', $no_tender);
		$this -> db -> where('EC_AUCTION_ITEMIZE_PESERTA.ID_HEADER', $no_tender);
		$this -> db -> where('ID_ITEM', (string)$id_item);
		$this -> db -> order_by('RANKING');
		$result = $this -> db -> get();
		//echo $this->db->last_query();die;
		return (array)$result -> result_array();
	}

	public function urutkanRankingHist($no_tender = '', $id_item = '') {
		$this -> db -> from($this -> tableHist);
		$this -> db -> select('EC_AUCTION_ITEMIZE_HIST.*, EC_AUCTION_ITEMIZE_PESERTA.NAMA_VENDOR, EC_AUCTION_ITEMIZE_PESERTA.INITIAL');
		$this -> db -> join('EC_AUCTION_ITEMIZE_PESERTA', 'EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR = EC_AUCTION_ITEMIZE_HIST.ID_PESERTA');
		$this -> db -> where('EC_AUCTION_ITEMIZE_HIST.ID_HEADER', $no_tender);
		$this -> db -> where('EC_AUCTION_ITEMIZE_PESERTA.ID_HEADER', $no_tender);
		$this -> db -> where('ID_ITEM', (string)$id_item);
		$this -> db -> order_by('RANKING');
		$result = $this -> db -> get();
		//echo $this->db->last_query();die;
		return (array)$result -> result_array();
	}

	public function urutkanRankingtmp($id_user = '', $id_item = '') {
		$this -> db -> from($this -> tableItemPrice);
		$this -> db -> select('EC_AUCTION_ITEMIZE_PRICE.*, EC_AUCTION_ITEMIZE_P_temp.NAMA_VENDOR, EC_AUCTION_ITEMIZE_P_temp.INITIAL');
		$this -> db -> join('EC_AUCTION_ITEMIZE_P_temp', 'EC_AUCTION_ITEMIZE_P_temp.KODE_VENDOR = EC_AUCTION_ITEMIZE_PRICE.ID_PESERTA');
		$this -> db -> where('EC_AUCTION_ITEMIZE_PRICE.ID_USER', $id_user);
		$this -> db -> where('EC_AUCTION_ITEMIZE_PRICE.ID_HEADER', null);
		$this -> db -> where('EC_AUCTION_ITEMIZE_P_temp.ID_USER', $id_user);
		$this -> db -> where('ID_ITEM', (string)$id_item);
		$this -> db -> order_by('USERID');
		$result = $this -> db -> get();
		// echo $this->db->last_query();die;
		return (array)$result -> result_array();
	}

	public function urutkanRanking1($no_tender = '', $id_item = '') {
		$this -> db -> from($this -> tableItemPrice);
		$this -> db -> select('EC_AUCTION_ITEMIZE_PRICE.*, EC_AUCTION_ITEMIZE_PESERTA.NAMA_VENDOR, EC_AUCTION_ITEMIZE_PESERTA.INITIAL');
		$this -> db -> join('EC_AUCTION_ITEMIZE_PESERTA', 'EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR = EC_AUCTION_ITEMIZE_PRICE.ID_PESERTA');
		$this -> db -> where('EC_AUCTION_ITEMIZE_PRICE.ID_HEADER', $no_tender);
		$this -> db -> where('EC_AUCTION_ITEMIZE_PESERTA.ID_HEADER', $no_tender);
		$this -> db -> where('ID_ITEM', (string)$id_item);
		$this -> db -> order_by('USERID');
		$result = $this -> db -> get();
		// echo $this->db->last_query();die;
		return (array)$result -> result_array();
	}

	public function get_list_Peserta2($NO_TENDER, $ID_ITEM) {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> where("ID_HEADER", $NO_TENDER, TRUE);
		// $this -> db -> join('EC_AUCTION_LOG', 'EC_AUCTION_LOG.NO_TENDER = EC_AUCTION_PESERTA.ID_HEADER AND EC_AUCTION_LOG.VENDOR_NO = EC_AUCTION_PESERTA.KODE_VENDOR', 'left');
		$this -> db -> join("(
			SELECT MAX(LG.HARGA) AS HARGAAWAL, MAX(LG.BM_HB) AS TGL, LG.ID_PESERTA FROM EC_AUCTION_ITEMIZE_PRICE LG
			WHERE LG.ID_HEADER='". $NO_TENDER ."' 
			AND LG.ID_ITEM = '".$ID_ITEM."'
			AND LG.ID_PESERTA IN
			(SELECT PES.KODE_VENDOR FROM EC_AUCTION_ITEMIZE_PESERTA PES
			WHERE PES.ID_HEADER='". $NO_TENDER ."')
			GROUP BY LG.ID_PESERTA ORDER BY TGL ASC) TB1", 
			'TB1.ID_PESERTA=EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR', 'INNER');
		// $this -> db -> join(' (Select CREATED_AT,VENDOR_NO from EC_AUCTION_LOG where NO_TENDER='.$NO_TENDER.' group by CREATED_AT,VENDOR_NO) EL ', 'EL.NO_TENDER = EC_AUCTION_PESERTA.ID_HEADER AND EL.VENDOR_NO = EC_AUCTION_PESERTA.KODE_VENDOR', 'left');

		$this -> db -> join("(
			SELECT MAX(LG.CREATED_AT) AS TGL, LG.VENDOR_NO FROM EC_AUCTION_ITEMIZE_LOG LG WHERE LG.NO_TENDER='". $NO_TENDER ."' AND LG.VENDOR_NO IN(SELECT PES.KODE_VENDOR FROM EC_AUCTION_ITEMIZE_PESERTA PES WHERE PES.ID_HEADER='". $NO_TENDER ."') GROUP BY LG.VENDOR_NO ORDER BY TGL ASC) TB2", 'TB2.VENDOR_NO=EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR', 'INNER');

		$this -> db -> order_by('TB1.TGL');
		$this -> db -> order_by('TB2.TGL');
		// $this -> db -> order_by('CREATED_AT', 'ASC');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_list_PesertaHist($NO_TENDER, $ID_ITEM) {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> where("ID_HEADER", $NO_TENDER, TRUE);
		// $this -> db -> join('EC_AUCTION_LOG', 'EC_AUCTION_LOG.NO_TENDER = EC_AUCTION_PESERTA.ID_HEADER AND EC_AUCTION_LOG.VENDOR_NO = EC_AUCTION_PESERTA.KODE_VENDOR', 'left');
		$this -> db -> join("(
			SELECT MAX(LG.HARGA) AS HARGAAWAL, MAX(LG.BM_HB) AS TGL, LG.ID_PESERTA FROM EC_AUCTION_ITEMIZE_HIST LG
			WHERE LG.ID_HEADER='". $NO_TENDER ."' 
			AND LG.ID_ITEM = '".$ID_ITEM."'
			AND LG.ID_PESERTA IN
			(SELECT PES.KODE_VENDOR FROM EC_AUCTION_ITEMIZE_PESERTA PES
			WHERE PES.ID_HEADER='". $NO_TENDER ."')
			GROUP BY LG.ID_PESERTA ORDER BY TGL ASC) TB1", 
			'TB1.ID_PESERTA=EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR', 'INNER');
		// $this -> db -> join(' (Select CREATED_AT,VENDOR_NO from EC_AUCTION_LOG where NO_TENDER='.$NO_TENDER.' group by CREATED_AT,VENDOR_NO) EL ', 'EL.NO_TENDER = EC_AUCTION_PESERTA.ID_HEADER AND EL.VENDOR_NO = EC_AUCTION_PESERTA.KODE_VENDOR', 'left');

		$this -> db -> join("(
			SELECT MAX(LG.CREATED_AT) AS TGL, LG.VENDOR_NO FROM EC_AUCTION_ITEMIZE_LOG LG WHERE LG.NO_TENDER='". $NO_TENDER ."' AND LG.VENDOR_NO IN(SELECT PES.KODE_VENDOR FROM EC_AUCTION_ITEMIZE_PESERTA PES WHERE PES.ID_HEADER='". $NO_TENDER ."') GROUP BY LG.VENDOR_NO ORDER BY TGL ASC) TB2", 'TB2.VENDOR_NO=EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR', 'INNER');

		$this -> db -> order_by('TB1.TGL');
		$this -> db -> order_by('TB2.TGL');
		// $this -> db -> order_by('CREATED_AT', 'ASC');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_list_Peserta_Undur_Diri($NO_TENDER) {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> where("ID_HEADER", $NO_TENDER, TRUE);
		$this -> db -> where("STATUS",2);
		// $this -> db -> join('EC_AUCTION_LOG', 'EC_AUCTION_LOG.NO_TENDER = EC_AUCTION_PESERTA.ID_HEADER AND EC_AUCTION_LOG.VENDOR_NO = EC_AUCTION_PESERTA.KODE_VENDOR', 'left');
		$this -> db -> join("(SELECT MAX(LG.CREATED_AT) AS TGL, LG.VENDOR_NO FROM EC_AUCTION_ITEMIZE_LOG LG WHERE LG.NO_TENDER='". $NO_TENDER ."' AND LG.VENDOR_NO IN (SELECT PES.KODE_VENDOR FROM EC_AUCTION_ITEMIZE_PESERTA PES WHERE PES.ID_HEADER='". $NO_TENDER ."') GROUP BY LG.VENDOR_NO ORDER BY TGL ASC) TB1", 'TB1.VENDOR_NO=EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR', 'INNER');
		// $this -> db -> join(' (Select CREATED_AT,VENDOR_NO from EC_AUCTION_LOG where NO_TENDER='.$NO_TENDER.' group by CREATED_AT,VENDOR_NO) EL ', 'EL.NO_TENDER = EC_AUCTION_PESERTA.ID_HEADER AND EL.VENDOR_NO = EC_AUCTION_PESERTA.KODE_VENDOR', 'left');
		$this -> db -> order_by('HARGATERKINI');
		$this -> db -> order_by('TB1.TGL');
		// $this -> db -> order_by('CREATED_AT', 'ASC');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_list_Peserta0($NO_TENDER) {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> where("ID_HEADER", $NO_TENDER, TRUE); 
		$this -> db -> order_by('HARGATERKINI'); 
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_list_Peserta_temp($ID_USER) {
		$this -> db -> from($this -> tablePesertaTemp);
		$this -> db -> where("ID_USER", $ID_USER, TRUE);
		//$this -> db -> order_by("HARGATERKINI", "ASC");
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_list_PesertaEdit($NO_TENDER) {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> where("ID_HEADER", $NO_TENDER, TRUE);
		//$this -> db -> order_by("HARGATERKINI", "ASC");
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_list_Peserta_temp_id($ID_USER, $KODE_VENDOR) {
		$this -> db -> from($this -> tablePesertaTemp);
		$this -> db -> where("ID_USER", $ID_USER, TRUE);
		$this -> db -> where("KODE_VENDOR", $KODE_VENDOR, TRUE);
		//$this -> db -> order_by("HARGATERKINI", "ASC");
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_list_Peserta_id($ID_HEADER, $KODE_VENDOR) {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> where("ID_HEADER", $ID_HEADER, TRUE);
		$this -> db -> where("KODE_VENDOR", $KODE_VENDOR, TRUE);
		//$this -> db -> order_by("HARGATERKINI", "ASC");
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function edit($data = '') {
		$this -> db -> set('TGL_BUKA', "TO_DATE('" . $data['TGL_BUKA'] . "', 'dd/mm/yyyy hh24:mi:ss')", FALSE);
		$this -> db -> set('TGL_TUTUP', "TO_DATE('" . $data['TGL_TUTUP'] . "', 'dd/mm/yyyy hh24:mi:ss')", FALSE);
		$this -> db -> where('ID_HEADER', $data['NO_TENDER']);
		$this -> db -> update('EC_AUCTION_ITEMIZE_HEADER');
	}

	public function editBatch($data = '') {
		$this -> db -> set('TGL_BUKA', "TO_DATE('" . $data['TGL_BUKA'] . "', 'dd/mm/yyyy hh24:mi:ss')", FALSE);
		$this -> db -> set('TGL_TUTUP', "TO_DATE('" . $data['TGL_TUTUP'] . "', 'dd/mm/yyyy hh24:mi:ss')", FALSE);
		$this -> db -> where('ID_HEADER', $data['NO_TENDER']);
		$this -> db -> where('NAME', $data['NO_BATCH']);
		$this -> db -> update('EC_AUCTION_ITEMIZE_BATCH');
	}

	public function close($data = '') {

		$this -> db -> set('IS_ACTIVE', 0, FALSE);
		$this -> db -> where('NO_TENDER', $data['NO_TENDER']);
		$update = $this -> db -> update('EC_AUCTION_ITEMIZE_HEADER');

		if ($update){
			$SQL = 'INSERT INTO EC_AUCTION_ITEMIZE_HIST
			SELECT *
			FROM "EC_AUCTION_ITEMIZE_PRICE"
			where ID_HEADER=\'' . $data['NO_TENDER'] . '\'';
			$this -> db -> query($SQL);

			$SQL = 'DELETE from "EC_AUCTION_ITEMIZE_PRICE" where ID_HEADER=\'' . $data['NO_TENDER'] . '\'';
			$this -> db -> query($SQL);
		}
	}

	public function closebBatch($data = '') {
		$this -> db -> set('IS_ACTIVE', 0, FALSE);
		$this -> db -> where('ID_HEADER', $data['NO_TENDER']);
		$this -> db -> where('NAME', $data['NO_BATCH']);
		$this -> db -> update('EC_AUCTION_ITEMIZE_BATCH');
	}

	public function update_note($notender, $NOTE) {
		$this -> db -> set('NOTE', $NOTE, TRUE);
		$this -> db -> where('NO_TENDER', $notender);
		$this -> db -> update('EC_AUCTION_ITEMIZE_HEADER');
	}

	public function update_note_batch($notender, $nobatch, $NOTE) {
		$this -> db -> set('NOTE', $NOTE, TRUE);
		$this -> db -> where('ID_HEADER', $notender);
		$this -> db -> where('NAME', $nobatch);
		$this -> db -> update('EC_AUCTION_ITEMIZE_BATCH');
	}

	public function resetItem($data = '') {
		$this -> db -> where('ID_USER', $data);
		$this -> db -> delete('EC_AUCTION_ITEMIZE_ITEM_temp');
	}

	public function resetItemEdit($data = '') {
		$this -> db -> where('ID_HEADER', $data);
		$this -> db -> delete('EC_AUCTION_ITEMIZE_ITEM');
	}

	public function resetPesertaEdit($data = '') {
		$this -> db -> where('ID_HEADER', $data);
		$this -> db -> delete('EC_AUCTION_ITEMIZE_PESERTA');

		$SQL = '
		DELETE from "EC_AUCTION_ITEMIZE_PRICE" where ID_HEADER=\'' . $data . '\'
		';
		$this -> db -> query($SQL);
		

		// $this -> db -> where('ID_USER', $data);
		// $this -> db -> delete('EC_AUCTION_ITEMIZE_PRICE');
	}

	public function resetPesertaSelectedEdit($data = '', $KODE_VENDOR) {
		$this -> db -> where('ID_HEADER', $data);
		$this -> db -> where('KODE_VENDOR', $KODE_VENDOR);
		$this -> db -> delete('EC_AUCTION_ITEMIZE_PESERTA');

		$SQL = '
		DELETE from "EC_AUCTION_ITEMIZE_PRICE" 
		where ID_HEADER=\'' . $data . '\'
		AND ID_PESERTA =\'' . $KODE_VENDOR . '\'
		';
		$this -> db -> query($SQL);
		

		// $this -> db -> where('ID_USER', $data);
		// $this -> db -> delete('EC_AUCTION_ITEMIZE_PRICE');
	}

	public function resetPeserta($data = '') {
		$this -> db -> where('ID_USER', $data);
		$this -> db -> delete('EC_AUCTION_ITEMIZE_P_temp');

		$SQL = '
		DELETE from "EC_AUCTION_ITEMIZE_PRICE" where ID_USER=\'' . $data . '\'
		AND ID_HEADER is null
		';
		$this -> db -> query($SQL);
		

		// $this -> db -> where('ID_USER', $data);
		// $this -> db -> delete('EC_AUCTION_ITEMIZE_PRICE');
	}

	public function resetPesertaSelected($data = '', $KODE_VENDOR) {
		$this -> db -> where('ID_USER', $data);
		$this -> db -> where('KODE_VENDOR', $KODE_VENDOR);
		$this -> db -> delete('EC_AUCTION_ITEMIZE_P_temp');

		$SQL = '
		DELETE from "EC_AUCTION_ITEMIZE_PRICE" 
		where ID_USER=\'' . $data . '\'
		AND ID_PESERTA =\'' . $KODE_VENDOR . '\'
		AND ID_HEADER is null
		';
		$this -> db -> query($SQL);
		

		// $this -> db -> where('ID_USER', $data);
		// $this -> db -> delete('EC_AUCTION_ITEMIZE_PRICE');
	}

	public function resetBatch($data = '') {
		// $this -> db -> where('ID_USER', $data);
		// $this -> db -> delete('EC_AUCTION_ITEMIZE_BATCH');

		$SQL = '
		DELETE from "EC_AUCTION_ITEMIZE_BATCH" where ID_USER=\'' . $data . '\'
		AND ID_HEADER is null
		';
		$this -> db -> query($SQL);
		
	}

	public function resetBatch1($data = '',$notender) {
		// $this -> db -> where('ID_USER', $data);
		// $this -> db -> delete('EC_AUCTION_ITEMIZE_BATCH');

		$SQL = '
		DELETE from "EC_AUCTION_ITEMIZE_BATCH" where ID_USER=\'' . $data . '\'
		AND ID_HEADER = '.$notender.'
		';
		$this -> db -> query($SQL);
		
	}

	public function save($data, $user) {
		$SQL = "
		INSERT INTO EC_AUCTION_ITEMIZE_HEADER  
		values
		('" . $data['NO_TENDER'] . "',
		'" . $data['DESC'] . "', 
		'" . $data['LOCATION'] . "', 
		TO_DATE('" . $data['TGL_BUKA'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['TGL_TUTUP'] . "', 'dd/mm/yyyy hh24:mi:ss'), 
		0,
		1,
		'" . $data['NO_REF'] . "',
		'" . $data['NOTE'] . "',
		'" . $data['COMPANYID'] ."',
		TO_DATE('" . $data['TGL_CREATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'". $data['ID_USER']."',
		'". $data['TIPE_RANKING']."',
		'". $data['TOTAL_HPS']."'
		)
		";
		$this -> db -> query($SQL);

		$SQL = 'UPDATE EC_AUCTION_ITEMIZE_BATCH
		SET ID_HEADER = '.$data['NO_TENDER'].'
		WHERE ID_USER = '.$user.'
		AND ID_HEADER is null
		';
		$this -> db -> query($SQL);

		$SQL = 'UPDATE EC_AUCTION_ITEMIZE_PRICE
		SET ID_HEADER = '.$data['NO_TENDER'].'
		WHERE ID_USER = '.$user.'
		AND ID_HEADER is null
		';
		$this -> db -> query($SQL);

		// $this -> db -> insert($this -> tableHeader, $data);

		$SQL = 'INSERT INTO EC_AUCTION_ITEMIZE_ITEM
		SELECT *
		FROM "EC_AUCTION_ITEMIZE_ITEM_temp"
		where ID_USER=\'' . $user . '\'';
		$this -> db -> query($SQL);

		$SQL = 'DELETE from "EC_AUCTION_ITEMIZE_ITEM_temp" where ID_USER=\'' . $user . '\'';
		$this -> db -> query($SQL);
		$this -> db -> set('ID_HEADER', $data['NO_TENDER'], FALSE);
		$this -> db -> where('ID_HEADER', $user);
		$this -> db -> update('EC_AUCTION_ITEMIZE_ITEM');

		$SQL = 'INSERT INTO EC_AUCTION_ITEMIZE_PESERTA
		SELECT *
		FROM "EC_AUCTION_ITEMIZE_P_temp"
		where ID_USER=\'' . $user . '\'';
		$this -> db -> query($SQL);

		$SQL = 'DELETE from "EC_AUCTION_ITEMIZE_P_temp" where ID_USER=\'' . $user . '\'';
		$this -> db -> query($SQL);
		$this -> db -> set('ID_HEADER', $data['NO_TENDER'], FALSE);
		$this -> db -> where('ID_HEADER', $user);
		$this -> db -> update('EC_AUCTION_ITEMIZE_PESERTA');

		// if ($data['TIPE_RANKING'] == 2){
		// 	$SQL = 'UPDATE EC_AUCTION_ITEMIZE_HEADER
		// 	SET HPS_TOTAL = (
		// 	SELECT
		// 	SUM (HPS)
		// 	FROM
		// 	EC_AUCTION_ITEMIZE_ITEM
		// 	WHERE
		// 	ID_HEADER = '.$data['NO_TENDER'].'
		// 	)
		// 	WHERE NO_TENDER = '.$data['NO_TENDER'];
		// 	$this -> db -> query($SQL);
		// }

		$this -> db -> from($this -> tablePeserta) -> where("ID_HEADER",$data['NO_TENDER'], TRUE); 
		$result = $this -> db -> get();
		$dataa =  (array)$result -> result_array();

		for ($i=0; $i < sizeof($dataa); $i++) { 
			$SQL = "INSERT INTO EC_AUCTION_ITEMIZE_LOG   
			values
			('" . $dataa[$i]['KODE_VENDOR'] . "',TO_DATE('" . date('d/m/Y h:i:s') . "', 'dd/mm/yyyy hh24:mi:ss'),'" . $dataa[$i]['HARGAAWAL'] . "', 0, '0', 
			'" . $data['NO_TENDER']  . "', '')";
			$this -> db -> query($SQL);

			if ($data['TIPE_RANKING'] == 2){
				$SQL = 'UPDATE EC_AUCTION_ITEMIZE_PESERTA
				SET TOTAL_HARGA = (
				SELECT
				SUM (BM_HB)
				FROM
				EC_AUCTION_ITEMIZE_PRICE
				WHERE
				ID_HEADER = '.$data['NO_TENDER'].'
				AND ID_PESERTA = '. $dataa[$i]['KODE_VENDOR'] .'
				)
				WHERE
				ID_HEADER = '.$data['NO_TENDER'].'
				AND KODE_VENDOR = '. $dataa[$i]['KODE_VENDOR'];
				$this -> db -> query($SQL);
			}
		} 
	}

	public function addLogEdit($dataa) {
		$SQL = "INSERT INTO EC_AUCTION_ITEMIZE_LOG   
		values
		('" . $dataa['VENDOR_NO'] . "',TO_DATE('" . $dataa['CREATED_AT'] . "', 'dd/mm/yyyy hh24:mi:ss'),'" . $dataa['PRICE'] . "', 0, '0', 
		'" . $dataa['NO_TENDER']  . "', '')";
		$this -> db -> query($SQL);
	}

	public function addPeserta($data) {
		$this -> db -> insert($this -> tablePesertaTemp, $data);
	}

	public function addPesertaEdit($data) {
		$this -> db -> insert($this -> tablePeserta, $data);
	}

	public function addItems($data) {
		$this -> db -> insert($this -> tableItemTemp, $data);
	}

	public function addItemsEdit($data) {
		$this -> db -> insert($this -> tableItem, $data);
	}

	public function addItemsPrice($data) {
		$this -> db -> insert($this -> tableItemPrice, $data);
	}

	public function addItemsBatch($data) {
		$this -> db -> insert($this -> tableBatch, $data);
	}

	public function addCurrency($data) {
		$this -> db -> insert($this -> tableCurrency, $data);
	}

	public function updateCurrency($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableCurrency, $set);
	}

	public function getCurrency($FROM_CURR, $TO_CURRNCY) {
		$this -> db -> from($this -> tableCurrency);
		$this -> db -> where("FROM_CURR", $FROM_CURR, TRUE);
		$this -> db -> where("TO_CURRNCY", $TO_CURRNCY, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function addHPStotal($iduser) {
		$SQL = '
		SELECT SUM(HPS) AS TOT_HPS
		from "EC_AUCTION_ITEMIZE_ITEM_temp"
		where ID_USER = '.$iduser;
		//echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function addHPStotalVendor($iduser, $kd_peserta) {
		$SQL = '
		SELECT SUM(BM_HB) AS TOT_HARGA
		from "EC_AUCTION_ITEMIZE_PRICE"
		where ID_USER = '.$iduser.'
		AND ID_HEADER IS NULL
		AND ID_PESERTA = '.$kd_peserta;
		//echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getAllCurrency() {
		$SQL = '
		SELECT
		EC_AUCTION_ITEMIZE_CURRENCY.*, ADM_CURR.CURR_NAME
		FROM
		EC_AUCTION_ITEMIZE_CURRENCY
		INNER JOIN ADM_CURR ON ADM_CURR.CURR_CODE = EC_AUCTION_ITEMIZE_CURRENCY.FROM_CURR
		ORDER BY
		EC_AUCTION_ITEMIZE_CURRENCY.FROM_CURR ASC
		';
		//echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function get_items_temp($ID_USER) {
		$this -> db -> from($this -> tableItemTemp);
		$this -> db -> where("ID_USER", $ID_USER, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getBatch($ID_HEADER) {
		$this -> db -> from($this -> tableBatch);
		$this -> db -> where("ID_HEADER", $ID_HEADER, TRUE);
		$this -> db -> order_by('NAME', 'ASC');
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

	public function getBatchDetailClose($ID_HEADER) {
		$this -> db -> from($this -> tableBatch);
		$this -> db -> where("ID_HEADER", $ID_HEADER);
		$this -> db -> where("IS_ACTIVE", '1');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getBatchDetailItem($ID_HEADER, $ID_ITEM) {
		$ID_ITEM1 = str_replace(",", "','", $ID_ITEM);
		$SQL1 = '
		select * from EC_AUCTION_ITEMIZE_ITEM
		where ID_ITEM IN (\''.$ID_ITEM1.'\')
		and ID_HEADER = '.$ID_HEADER;

		$SQL = '
		select * from EC_AUCTION_ITEMIZE_ITEM
		where ID_ITEM IN ('.$ID_ITEM.')
		and ID_HEADER = '.$ID_HEADER;
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		// return $this->db->last_query();
		return (array)$result -> result_array();
	}

	public function getBatchDetailItemMerk($ID_HEADER, $ID_ITEM, $ID_PESERTA, $MERK) {
		// $ID_ITEM1 = str_replace(",", "','", $ID_ITEM);
		$SQL = '
		SELECT
		II.*, IP.*, IPP.USERID
		FROM
		EC_AUCTION_ITEMIZE_ITEM II
		INNER JOIN EC_AUCTION_ITEMIZE_PRICE IP ON II.ID_ITEM = IP.ID_ITEM
		INNER JOIN EC_AUCTION_ITEMIZE_PESERTA IPP ON IP.ID_PESERTA = IPP.KODE_VENDOR

		where II.ID_ITEM IN ('.$ID_ITEM.')
		AND IPP.USERID = \''.$ID_PESERTA.'\'
		AND IP.MERK = \''.$MERK.'\'
		and II.ID_HEADER = '.$ID_HEADER;
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		// return $this->db->last_query();
		return (array)$result -> result_array();
	}

	public function getBatchDetailItemNotIn($ID_ITEM, $ID_USER) {
		$SQL = '
		SELECT
		*
		FROM
		"EC_AUCTION_ITEMIZE_ITEM_temp"
		WHERE
		ID_ITEM NOT IN ('.$ID_ITEM.')
		AND ID_USER = '.$ID_USER;
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getBatchDetailItemNotInEdit($ID_ITEM, $NO_TENDER) {
		$SQL = '
		SELECT
		*
		FROM
		"EC_AUCTION_ITEMIZE_ITEM"
		WHERE
		ID_ITEM NOT IN ('.$ID_ITEM.')
		AND ID_HEADER = '.$NO_TENDER;
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function exportDetailItemEdit($ID_HEADER) {
		$SQL = '
		SELECT
		*
		FROM
		"EC_AUCTION_ITEMIZE_ITEM"
		WHERE
		ID_HEADER = '.$ID_HEADER;
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function exportDetailItem($ID_USER) {
		$SQL = '
		SELECT
		*
		FROM
		"EC_AUCTION_ITEMIZE_ITEM_temp"
		WHERE
		ID_USER = '.$ID_USER;
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getCurrencyExcel() {
		$SQL = '
		SELECT
		*
		FROM
		ADM_CURR';
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getCurrencyExcelID($CURR_CODE) {
		$SQL = "
		SELECT
		*
		FROM
		ADM_CURR
		WHERE CURR_CODE = '".$CURR_CODE."'
		";
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getBatchSet($ID_USER,$notender) {
		$SQL = '
		SELECT
		*
		FROM
		"EC_AUCTION_ITEMIZE_BATCH"
		WHERE
		ID_HEADER = '.$notender.'
		AND ID_USER = '.$ID_USER;
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getBatchCreate($ID_USER) {
		$SQL = '
		SELECT
		*
		FROM
		"EC_AUCTION_ITEMIZE_BATCH"
		WHERE
		ID_HEADER is null
		AND ID_USER = '.$ID_USER;
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getDetailItem($ID_ITEM){
		$this->db->from($this-> tableItemTemp);
		$this->db->where('ID_ITEM', (string)$ID_ITEM);
		$result = $this->db-> get();
		return (array)$result->result_array();
	}

	public function getDetailItem2($ID_ITEM, $ID_USER){
		$this->db->from($this-> tableItemTemp);
		$this->db->where('ID_ITEM', (string)$ID_ITEM);
		$this->db->where('ID_USER', $ID_USER);
		$result = $this->db-> get();
		return (array)$result->result_array();
	}

	public function getDetailItem3($ID_ITEM, $ID_HEADER){
		$this->db->from($this-> tableItem);
		$this->db->where('ID_ITEM', (string)$ID_ITEM);
		$this->db->where('ID_HEADER', $ID_HEADER);
		$result = $this->db-> get();
		return (array)$result->result_array();
	}

	public function getDetailItemPriceQty1($ID_HEADER,$ID_ITEM,$ID_PESERTA){

		$SQL1 = '
		SELECT
		*
		FROM
		"EC_AUCTION_ITEMIZE_PRICE"
		WHERE
		ID_HEADER = '.$ID_HEADER.'
		AND ID_ITEM = \''.$ID_ITEM.'\'';

		$SQL = "
		SELECT
		*
		FROM
		EC_AUCTION_ITEMIZE_PRICE
		WHERE
		ID_ITEM = '".$ID_ITEM."'
		and ID_PESERTA = '".$ID_PESERTA."'
		and ID_HEADER = '".$ID_HEADER."'
		";
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();

		// $this->db->from($this-> tableItemPrice);
		// $this->db->where('ID_ITEM', $ID_ITEM);
		// $this->db->where('ID_PESERTA', $ID_PESERTA);
		// $result = $this->db-> get();
		// return (array)$result->result_array();
	}

	public function getDetailItemPriceQty($ID_USER,$ID_ITEM,$ID_PESERTA){

		$SQL1 = '
		SELECT
		*
		FROM
		"EC_AUCTION_ITEMIZE_PRICE"
		WHERE
		ID_HEADER is null
		AND ID_USER = '.$ID_USER.'
		AND ID_ITEM = \''.$ID_ITEM.'\'';

		$SQL = "
		SELECT
		*
		FROM
		EC_AUCTION_ITEMIZE_PRICE
		WHERE
		ID_ITEM = '".$ID_ITEM."'
		and ID_PESERTA = '".$ID_PESERTA."'
		and ID_HEADER is null
		";
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();

		// $this->db->from($this-> tableItemPrice);
		// $this->db->where('ID_ITEM', $ID_ITEM);
		// $this->db->where('ID_PESERTA', $ID_PESERTA);
		// $result = $this->db-> get();
		// return (array)$result->result_array();
	}

	public function getDetailItemRanking($ID_USER,$ID_ITEM,$NO_TENDER){

		$SQL = '
		SELECT
		EC_AUCTION_ITEMIZE_PRICE.*, EC_AUCTION_ITEMIZE_PESERTA.NAMA_VENDOR, EC_AUCTION_ITEMIZE_PESERTA."INITIAL"
		FROM
		EC_AUCTION_ITEMIZE_PRICE
		INNER JOIN EC_AUCTION_ITEMIZE_PESERTA ON EC_AUCTION_ITEMIZE_PRICE.ID_PESERTA = EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR
		WHERE
		EC_AUCTION_ITEMIZE_PESERTA.ID_HEADER = '.$NO_TENDER.'
		AND EC_AUCTION_ITEMIZE_PRICE.ID_ITEM = \'' . $ID_ITEM . '\'
		AND EC_AUCTION_ITEMIZE_PRICE.ID_USER = '.$ID_USER.'
		ORDER BY
		EC_AUCTION_ITEMIZE_PRICE.HARGA ASC
		';
		//echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getDetailVendor($ID_USER,$ID_ITEM,$NO_TENDER){

		$SQL = "
		SELECT
		EC_AUCTION_ITEMIZE_PRICE.*, EC_AUCTION_ITEMIZE_PESERTA.NAMA_VENDOR,
		EC_AUCTION_ITEMIZE_PESERTA.USERID
		FROM
		EC_AUCTION_ITEMIZE_PRICE
		INNER JOIN EC_AUCTION_ITEMIZE_PESERTA ON EC_AUCTION_ITEMIZE_PRICE.ID_PESERTA = EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR
		WHERE
		EC_AUCTION_ITEMIZE_PESERTA.ID_HEADER = ".$NO_TENDER."
		AND EC_AUCTION_ITEMIZE_PRICE.ID_HEADER = ".$NO_TENDER."
		AND EC_AUCTION_ITEMIZE_PRICE.ID_ITEM = '".$ID_ITEM."'
		AND EC_AUCTION_ITEMIZE_PESERTA.USERID = '".$ID_USER."'
		ORDER BY
		EC_AUCTION_ITEMIZE_PRICE.HARGA ASC
		";
		//echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getReportItemRanking($ID_USER,$ID_PESERTA,$NO_TENDER){

		$SQL = "
		SELECT
		EC_AUCTION_ITEMIZE_PRICE.*, EC_AUCTION_ITEMIZE_PESERTA.NAMA_VENDOR
		FROM
		EC_AUCTION_ITEMIZE_PRICE
		INNER JOIN EC_AUCTION_ITEMIZE_PESERTA ON EC_AUCTION_ITEMIZE_PRICE.ID_PESERTA = EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR
		WHERE
		EC_AUCTION_ITEMIZE_PESERTA.ID_HEADER = ".$NO_TENDER."
		AND EC_AUCTION_ITEMIZE_PRICE.ID_PESERTA = '".$ID_PESERTA."'
		AND EC_AUCTION_ITEMIZE_PRICE.ID_USER = ".$ID_USER."
		ORDER BY
		EC_AUCTION_ITEMIZE_PRICE.HARGA ASC
		";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getItemPeserta($ID_USER,$ID_PESERTA,$NO_TENDER,$ID_ITEM){

		$SQL = "
		SELECT
		EC_AUCTION_ITEMIZE_PRICE.*, EC_AUCTION_ITEMIZE_ITEM.ID_ITEM, EC_AUCTION_ITEMIZE_ITEM.NAMA_BARANG, EC_AUCTION_ITEMIZE_ITEM.CURR, EC_AUCTION_ITEMIZE_ITEM.KODE_BARANG
		FROM
		EC_AUCTION_ITEMIZE_PRICE
		INNER JOIN EC_AUCTION_ITEMIZE_ITEM
		ON EC_AUCTION_ITEMIZE_PRICE.ID_HEADER = EC_AUCTION_ITEMIZE_ITEM.ID_HEADER
		AND EC_AUCTION_ITEMIZE_PRICE.ID_ITEM = EC_AUCTION_ITEMIZE_ITEM.ID_ITEM
		WHERE
		EC_AUCTION_ITEMIZE_PRICE.ID_HEADER = ".$NO_TENDER."
		AND EC_AUCTION_ITEMIZE_PRICE.ID_PESERTA = '".$ID_PESERTA."'
		AND EC_AUCTION_ITEMIZE_PRICE.ID_USER = ".$ID_USER."
		AND EC_AUCTION_ITEMIZE_PRICE.ID_ITEM IN (".$ID_ITEM.")
		AND EC_AUCTION_ITEMIZE_PRICE.HARGA > 0
		ORDER BY
		EC_AUCTION_ITEMIZE_PRICE.HARGA ASC
		";
		//echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getItemPesertaHist($ID_USER,$ID_PESERTA,$NO_TENDER,$ID_ITEM){

		$SQL = "
		SELECT
		EC_AUCTION_ITEMIZE_HIST.*, EC_AUCTION_ITEMIZE_ITEM.ID_ITEM, EC_AUCTION_ITEMIZE_ITEM.NAMA_BARANG, EC_AUCTION_ITEMIZE_ITEM.CURR, EC_AUCTION_ITEMIZE_ITEM.KODE_BARANG
		FROM
		EC_AUCTION_ITEMIZE_HIST
		INNER JOIN EC_AUCTION_ITEMIZE_ITEM
		ON EC_AUCTION_ITEMIZE_HIST.ID_HEADER = EC_AUCTION_ITEMIZE_ITEM.ID_HEADER
		AND EC_AUCTION_ITEMIZE_HIST.ID_ITEM = EC_AUCTION_ITEMIZE_ITEM.ID_ITEM
		WHERE
		EC_AUCTION_ITEMIZE_HIST.ID_HEADER = ".$NO_TENDER."
		AND EC_AUCTION_ITEMIZE_HIST.ID_PESERTA = '".$ID_PESERTA."'
		AND EC_AUCTION_ITEMIZE_HIST.ID_USER = ".$ID_USER."
		AND EC_AUCTION_ITEMIZE_HIST.ID_ITEM IN (".$ID_ITEM.")
		AND EC_AUCTION_ITEMIZE_HIST.HARGA > 0
		ORDER BY
		EC_AUCTION_ITEMIZE_HIST.HARGA ASC
		";
		//echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getReportItemRanking2($ID_USER,$ID_PESERTA,$NO_TENDER,$RANKING, $NO_BATCH, $ID_ITEM){

		$SQL1 = "
		SELECT DISTINCT
		(
		EC_AUCTION_ITEMIZE_PESERTA.NAMA_VENDOR
		),
		EC_AUCTION_ITEMIZE_PRICE.*, EC_AUCTION_ITEMIZE_PESERTA.NAMA_VENDOR,
		EC_AUCTION_ITEMIZE_BATCH. NAME
		FROM
		EC_AUCTION_ITEMIZE_PRICE
		INNER JOIN EC_AUCTION_ITEMIZE_PESERTA ON EC_AUCTION_ITEMIZE_PRICE.ID_PESERTA = EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR
		INNER JOIN EC_AUCTION_ITEMIZE_BATCH ON EC_AUCTION_ITEMIZE_BATCH.ID_HEADER = EC_AUCTION_ITEMIZE_PESERTA.ID_HEADER
		WHERE
		EC_AUCTION_ITEMIZE_PESERTA.ID_HEADER = ".$NO_TENDER."
		AND EC_AUCTION_ITEMIZE_PRICE.ID_PESERTA = '".$ID_PESERTA."'
		AND EC_AUCTION_ITEMIZE_PRICE.ID_USER = ".$ID_USER."
		AND EC_AUCTION_ITEMIZE_PRICE.RANKING = ".$RANKING."
		AND EC_AUCTION_ITEMIZE_BATCH. NAME = '".$NO_BATCH."'
		ORDER BY
		EC_AUCTION_ITEMIZE_PRICE.HARGA ASC
		";

		// $ID_ITEM1 = str_replace(",", "','", $ID_ITEM);
		$SQL = "
		SELECT DISTINCT
		EC_AUCTION_ITEMIZE_PRICE.*, EC_AUCTION_ITEMIZE_BATCH. NAME
		FROM
		EC_AUCTION_ITEMIZE_PRICE
		INNER JOIN EC_AUCTION_ITEMIZE_BATCH ON EC_AUCTION_ITEMIZE_BATCH.ID_HEADER = EC_AUCTION_ITEMIZE_PRICE.ID_HEADER
		INNER JOIN EC_AUCTION_ITEMIZE_PESERTA ON EC_AUCTION_ITEMIZE_PRICE.ID_PESERTA = EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR
		WHERE EC_AUCTION_ITEMIZE_PRICE.ID_HEADER = ".$NO_TENDER."
		AND EC_AUCTION_ITEMIZE_BATCH. NAME = '".$NO_BATCH."'
		AND EC_AUCTION_ITEMIZE_PRICE.ID_ITEM IN (".$ID_ITEM.")
		AND EC_AUCTION_ITEMIZE_PRICE.ID_PESERTA = '".$ID_PESERTA."'
		AND EC_AUCTION_ITEMIZE_PRICE.RANKING = ".$RANKING."
		ORDER BY
		EC_AUCTION_ITEMIZE_PRICE.ID_ITEM ASC
		";
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();

	}

	public function getReportItemRankingHist($ID_USER,$ID_PESERTA,$NO_TENDER,$RANKING, $NO_BATCH, $ID_ITEM){

		$SQL1 = "
		SELECT DISTINCT
		(
		EC_AUCTION_ITEMIZE_PESERTA.NAMA_VENDOR
		),
		EC_AUCTION_ITEMIZE_HIST.*, EC_AUCTION_ITEMIZE_PESERTA.NAMA_VENDOR,
		EC_AUCTION_ITEMIZE_BATCH. NAME
		FROM
		EC_AUCTION_ITEMIZE_HIST
		INNER JOIN EC_AUCTION_ITEMIZE_PESERTA ON EC_AUCTION_ITEMIZE_HIST.ID_PESERTA = EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR
		INNER JOIN EC_AUCTION_ITEMIZE_BATCH ON EC_AUCTION_ITEMIZE_BATCH.ID_HEADER = EC_AUCTION_ITEMIZE_PESERTA.ID_HEADER
		WHERE
		EC_AUCTION_ITEMIZE_PESERTA.ID_HEADER = ".$NO_TENDER."
		AND EC_AUCTION_ITEMIZE_HIST.ID_PESERTA = '".$ID_PESERTA."'
		AND EC_AUCTION_ITEMIZE_HIST.ID_USER = ".$ID_USER."
		AND EC_AUCTION_ITEMIZE_HIST.RANKING = ".$RANKING."
		AND EC_AUCTION_ITEMIZE_BATCH. NAME = '".$NO_BATCH."'
		ORDER BY
		EC_AUCTION_ITEMIZE_HIST.HARGA ASC
		";

		// $ID_ITEM1 = str_replace(",", "','", $ID_ITEM);
		$SQL = "
		SELECT DISTINCT
		EC_AUCTION_ITEMIZE_HIST.*, EC_AUCTION_ITEMIZE_BATCH. NAME
		FROM
		EC_AUCTION_ITEMIZE_HIST
		INNER JOIN EC_AUCTION_ITEMIZE_BATCH ON EC_AUCTION_ITEMIZE_BATCH.ID_HEADER = EC_AUCTION_ITEMIZE_HIST.ID_HEADER
		INNER JOIN EC_AUCTION_ITEMIZE_PESERTA ON EC_AUCTION_ITEMIZE_HIST.ID_PESERTA = EC_AUCTION_ITEMIZE_PESERTA.KODE_VENDOR
		WHERE EC_AUCTION_ITEMIZE_HIST.ID_HEADER = ".$NO_TENDER."
		AND EC_AUCTION_ITEMIZE_BATCH. NAME = '".$NO_BATCH."'
		AND EC_AUCTION_ITEMIZE_HIST.ID_ITEM IN (".$ID_ITEM.")
		AND EC_AUCTION_ITEMIZE_HIST.ID_PESERTA = '".$ID_PESERTA."'
		AND EC_AUCTION_ITEMIZE_HIST.RANKING = ".$RANKING."
		ORDER BY
		EC_AUCTION_ITEMIZE_HIST.ID_ITEM ASC
		";
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();

	}

	public function getDetailItemPriceHarga($ID_ITEM,$ID_PESERTA, $ID_USER){
		// $this->db->from($this-> tableItemPrice);
		// $this->db->where('ID_ITEM', $ID_ITEM);
		// $this->db->where('ID_PESERTA', $ID_PESERTA);
		// $result = $this->db-> get();
		// return (array)$result->result_array();

		$SQL = "
		SELECT
		*
		FROM
		EC_AUCTION_ITEMIZE_PRICE
		WHERE
		ID_ITEM = '".$ID_ITEM."'
		and ID_PESERTA = '".$ID_PESERTA."'
		and ID_HEADER is null
		and ID_USER = ".$ID_USER."
		";
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getDetailItemPriceHargaEdit($ID_ITEM,$ID_PESERTA, $ID_USER,$NO_TENDER){
		// $this->db->from($this-> tableItemPrice);
		// $this->db->where('ID_ITEM', $ID_ITEM);
		// $this->db->where('ID_PESERTA', $ID_PESERTA);
		// $result = $this->db-> get();
		// return (array)$result->result_array();

		$SQL = "
		SELECT
		*
		FROM
		EC_AUCTION_ITEMIZE_PRICE
		WHERE
		ID_ITEM = '".$ID_ITEM."'
		and ID_PESERTA = '".$ID_PESERTA."'
		and ID_HEADER = ".$NO_TENDER."
		and ID_USER = ".$ID_USER."
		";
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getDetailItemPrice($ID_ITEM, $ID_PESERTA){
		$this->db->from($this-> tableItemPrice);
		$this->db->where('ID_ITEM', (string)$ID_ITEM);
		$this->db->where('ID_PESERTA', $ID_PESERTA);
		$result = $this->db-> get();
		return (array)$result->result_array();
	}

	public function getDetailItemAdmin($ID_ITEM, $ID_USER){
		$this->db->from($this-> tableItemTemp);
		$this->db->where('ID_ITEM', (string)$ID_ITEM);
		$this->db->where('ID_USER', $ID_USER);
		$result = $this->db-> get();
		return (array)$result->result_array();
	}

	public function updateItembatch($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableItem, $set);
	}

	public function updateItem($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableItemTemp, $set);
	}

	public function updateStatus($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableHeader, $set);
	}

	public function updateItemPrice($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableItemPrice, $set);
	}

	public function updatePesertaTemp($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableItemPrice, $set);
	}

	public function getDetailUser($KODE_VENDOR){
		$this->db->from($this-> tablePesertaTemp);
		$this->db->where('KODE_VENDOR', $KODE_VENDOR);
		$result = $this->db-> get();
		return (array)$result->result_array();
	}

	public function updateUser($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tablePesertaTemp, $set);
	}

	public function updateUserEdit($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tablePeserta, $set);
	}

	public function getLog1($NO, $ID_PESERTA, $NO_ITEM) {
		$SQL = "
		SELECT
		PR.CURRENCY, PR.KONVERSI, H .*, P .NAMA_VENDOR,
		IT.HPS,
		TO_CHAR (
		H .CREATED_AT,
		'DD/MM/YYYY HH24:MI:SS'
		) AS TGL
		FROM
		EC_AUCTION_ITEMIZE_LOG H

		LEFT JOIN EC_AUCTION_ITEMIZE_PESERTA P ON H .VENDOR_NO = P .KODE_VENDOR
		AND H .NO_TENDER = P .ID_HEADER

		LEFT JOIN EC_AUCTION_ITEMIZE_PRICE PR ON H .VENDOR_NO = PR.ID_PESERTA
		AND H .NO_TENDER = PR.ID_HEADER
		AND PR.ID_ITEM = H .ID_ITEM

		LEFT JOIN EC_AUCTION_ITEMIZE_ITEM IT ON H .NO_TENDER = IT.ID_HEADER
		AND PR.ID_ITEM = IT.ID_ITEM

		WHERE
		H.NO_TENDER = '" . $NO . "'
		AND VENDOR_NO = '" .$ID_PESERTA. "'
		AND ITER!=0
		AND H.ID_ITEM = '" . $NO_ITEM . "'
		ORDER BY H .ITER DESC";
		$result = $this -> db -> query($SQL);
		// echo $this->db->last_query();die;
		return (array)$result -> result_array();
	}

	public function getLog($NO, $NO_ITEM) {
		$SQL = "
		SELECT
		PR.CURRENCY, PR.KONVERSI, H .*, P .NAMA_VENDOR,
		IT.HPS,
		TO_CHAR (
		H .CREATED_AT,
		'DD/MM/YYYY HH24:MI:SS'
		) AS TGL
		FROM
		EC_AUCTION_ITEMIZE_LOG H

		LEFT JOIN EC_AUCTION_ITEMIZE_PESERTA P ON H .VENDOR_NO = P .KODE_VENDOR
		AND H .NO_TENDER = P .ID_HEADER

		LEFT JOIN EC_AUCTION_ITEMIZE_PRICE PR ON H .VENDOR_NO = PR.ID_PESERTA
		AND H .NO_TENDER = PR.ID_HEADER
		AND PR.ID_ITEM = H .ID_ITEM

		LEFT JOIN EC_AUCTION_ITEMIZE_ITEM IT ON H .NO_TENDER = IT.ID_HEADER
		AND PR.ID_ITEM = IT.ID_ITEM

		WHERE
		H.NO_TENDER = '" . $NO . "'
		AND ITER!=0
		AND H.ID_ITEM = '" . $NO_ITEM . "'
		ORDER BY H .ITER DESC";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function get_peserta_temp($ID_USER) {
		$this -> db -> from($this -> tablePesertaTemp);
		$this -> db -> where("ID_USER", $ID_USER, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getCompany() {
		$this -> db -> from($this -> tableAdmCompany);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_items($ID_HEADER) {
		$this -> db -> from($this -> tableItem);
		$this -> db -> where("ID_HEADER", $ID_HEADER, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_itemset($notender) {
		$this -> db -> from($this -> tableItem);
		$this -> db -> where("ID_HEADER", $notender, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_peserta($ID_HEADER) {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> where("ID_HEADER", $ID_HEADER, TRUE);
		$this -> db -> order_by("HARGATERKINI", "ASC");
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getAllItembatch($notender, $QTY_ITEM)
	{
		$SQL = '
		SELECT
		*
		FROM
		"EC_AUCTION_ITEMIZE_ITEM"
		WHERE
		ID_HEADER = '.$notender.'
		and status is null
		and ROWNUM <= '.$QTY_ITEM.'
		ORDER BY NAMA_BARANG ASC
		';
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getAllItem($ID_USER, $QTY_ITEM)
	{
		$SQL = '
		SELECT
		*
		FROM
		"EC_AUCTION_ITEMIZE_ITEM_temp"
		WHERE
		ID_USER = '.$ID_USER.'
		and status is null
		and ROWNUM <= '.$QTY_ITEM.'
		ORDER BY NAMA_BARANG ASC
		';
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function sumAllItemBatchSet($ID_USER,$notender)
	{
		$SQL = '
		SELECT
		"SUM" (QTY_ITEM) as jml
		FROM
		"EC_AUCTION_ITEMIZE_BATCH"
		WHERE
		ID_HEADER = '.$notender.'
		AND ID_USER = '.$ID_USER;
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function sumAllItemBatch($ID_USER)
	{
		$SQL = '
		SELECT
		"SUM" (QTY_ITEM) as jml
		FROM
		"EC_AUCTION_ITEMIZE_BATCH"
		WHERE
		ID_HEADER is null
		AND ID_USER = '.$ID_USER;
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function checkMerkSama($MERK,$ID_PESERTA, $ID_USER)
	{
		$SQL = "
		SELECT
		*
		FROM
		EC_AUCTION_ITEMIZE_PRICE
		WHERE
		ID_PESERTA = '".$ID_PESERTA."'
		and ID_HEADER is null
		and ID_USER = ".$ID_USER."
		and MERK LIKE '%".$MERK."%'
		ORDER BY BM_HB DESC
		";
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		//return (array)$result -> result_array();
		return $result -> row_array();
	}

	public function checkMerkSamaEdit($MERK,$ID_PESERTA, $ID_USER, $NO_TENDER)
	{
		$SQL = "
		SELECT
		*
		FROM
		EC_AUCTION_ITEMIZE_PRICE
		WHERE
		ID_PESERTA = '".$ID_PESERTA."'
		and ID_HEADER = ".$NO_TENDER."
		and ID_USER = ".$ID_USER."
		and MERK LIKE '%".$MERK."%'
		ORDER BY BM_HB DESC
		";
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		//return (array)$result -> result_array();
		return $result -> row_array();
	}

	public function checkMerkSama3($MERK,$ID_PESERTA, $ID_USER, $ID_HEADER)
	{
		$SQL = "
		SELECT
		*
		FROM
		EC_AUCTION_ITEMIZE_PRICE
		WHERE
		ID_PESERTA = '".$ID_PESERTA."'
		and ID_HEADER = ".$ID_HEADER."
		and ID_USER = ".$ID_USER."
		and MERK LIKE '%".$MERK."%'
		ORDER BY BM_HB DESC
		";
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
		// return $result -> row_array();
	}

	public function checkMerkSama2($MERK,$ID_PESERTA, $ID_USER)
	{
		$SQL = "
		SELECT
		*
		FROM
		EC_AUCTION_ITEMIZE_PRICE
		WHERE
		ID_PESERTA = '".$ID_PESERTA."'
		and ID_HEADER is null
		and ID_USER = ".$ID_USER."
		and MERK LIKE '%".$MERK."%'
		ORDER BY BM_HB DESC
		";
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
		// return $result -> row_array();
	}

	public function checkMerkSamaBatchLain($ID_PESERTA, $NO_TENDER, $NO_BATCH, $ID_ITEM)
	{
		$SQL = "
		SELECT
		*
		FROM
		EC_AUCTION_ITEMIZE_BATCH
		WHERE
		ID_PESERTA = '".$ID_PESERTA."'
		and ID_HEADER = ".$NO_TENDER."
		and NAME = ".$NO_BATCH."
		and ID_ITEM LIKE '%".$ID_ITEM."%'
		";
		// echo $SQL;die;
		$result = $this -> db -> query($SQL);
		//return (array)$result -> result_array();
		return $result -> row_array();
	}

	public function upload_dataEdit($filename, $KODE_VENDOR, $iduser, $NO_TENDER)
	{
		$this->load->library('excel');
		ini_set('memory_limit', '-1');

		$target_file = './upload/temp/';
		$buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/temp/") : false;
		move_uploaded_file($_FILES["import_excel"]["tmp_name"], $target_file.$_FILES['import_excel']['name']);


		$inputFileName = './upload/temp/'.$_FILES['import_excel']['name'];
		try {
			$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		} catch(Exception $e) {
			die('Error loading file :' . $e->getMessage());
		}

		$worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$numRows = count($worksheet);
		// echo "<pre>";
		// print_r($worksheet);
		//die;
		$KODE_BARANG_NO_INPUT = "";
		for ($i=2; $i < ($numRows+1) ; $i++) { 
			$KODE_BARANG 	= (string)$worksheet[$i]["B"];
			$KODE_BARANG_NO_INPUT .= "'".$worksheet[$i]["B"]."'".",";
			$HARGA_BARANG 	= $worksheet[$i]["I"] != null ? str_replace(',', '', $worksheet[$i]["I"]) : 0;
			$BEA_MASUK 		= $worksheet[$i]["J"] != null ? str_replace(',', '', $worksheet[$i]["J"]) : 0;
			$DELIVERY_TIME 	= $worksheet[$i]["K"];
			$CURRENCY 		= $worksheet[$i]["H"];
			$MERK 			= strtoupper($worksheet[$i]["L"]);

			// echo $KODE_BARANG."-";
			// echo $HARGA_BARANG.".";
			// if($KODE_BARANG!="") echo "t.kosong<br>";
			// else echo "kosong<br>";
			if ($KODE_BARANG != "") {
				//echo "masuk ?";
				$checkAdaTidak = $this->getDetailItemPriceHargaEdit($KODE_BARANG, $KODE_VENDOR, $iduser, $NO_TENDER);
				//JIKA MERK KOSONG TIDAK UPDATE
				$ambilHargaMerkSama = $this->checkMerkSamaEdit($MERK, $KODE_VENDOR, $iduser, $NO_TENDER);	

				if($CURRENCY == "IDR"){
					$KONVERSI = 1;
					if(count($ambilHargaMerkSama)>0 && $MERK!=""){
						if($HARGA_BARANG<$ambilHargaMerkSama['BM_HB']){
							$KEIDR = $ambilHargaMerkSama['KONVERSI_IDR'];
							$BM_HB = $ambilHargaMerkSama['BM_HB'];							
						} else {
							$KEIDR = $HARGA_BARANG;
							$BM_HB = $HARGA_BARANG;

							$where_edit['ID_PESERTA'] 	= $KODE_VENDOR;
							$where_edit['ID_USER'] 		= $iduser;
							$where_edit['ID_HEADER'] 	= $NO_TENDER;
							$where_edit['MERK'] 		= $MERK;
							$set_edit['KONVERSI'] 		= $KONVERSI;
							$set_edit['KONVERSI_IDR'] 		= $KEIDR;
							$set_edit['KONVERSI_IDR_UBAH'] 	= $KEIDR;
							$set_edit['BM_HB'] 			= $BM_HB;
							$result 					= $this->updateItemPrice($set_edit, $where_edit);
						}

					} else {
						//$BEA_MASUK = 0;
						$KEIDR = $HARGA_BARANG;
						$BM_HB = $HARGA_BARANG;
					}
				} else {
					//$ambilCurrPeserta = $this -> ec_auction_itemize_m -> get_list_Peserta_temp_id($iduser, $KODE_VENDOR);
					//$BEA_MASUK = $ambilCurrPeserta[0]['BEA_MASUK'];
					if(count($ambilHargaMerkSama)>0 && $MERK!=""){
						if($HARGA_BARANG<$ambilHargaMerkSama['BM_HB']){
							$KONVERSI 	= $ambilHargaMerkSama['KONVERSI'];
							$KEIDR 		= $ambilHargaMerkSama['KONVERSI_IDR'];
							$BM_HB 		= $ambilHargaMerkSama['BM_HB'];							
						} else {
							$checkCurr 	= $this->getCurrency($CURRENCY, 'IDR');
							$KONVERSI 	= $checkCurr[0]['KONVERSI'];
							$KEIDR 		= $HARGA_BARANG * $checkCurr[0]['KONVERSI'];
							$BM_HB 		= (($BEA_MASUK / 100) * $KEIDR) + $KEIDR;
							$where_edit['ID_PESERTA'] 	= $KODE_VENDOR;
							$where_edit['ID_USER'] 		= $iduser;
							$where_edit['ID_HEADER'] 	= $NO_TENDER;
							$where_edit['MERK'] 		= $MERK;
							$set_edit['KONVERSI'] 		= $KONVERSI;
							$set_edit['KONVERSI_IDR'] 		= $KEIDR;
							$set_edit['KONVERSI_IDR_UBAH'] 	= $KEIDR;
							$set_edit['BM_HB'] 			= $BM_HB;
							$result 					= $this->updateItemPrice($set_edit, $where_edit);
						}
					} else {
						$checkCurr 	= $this->getCurrency($CURRENCY, 'IDR');
						$KONVERSI 	= $checkCurr[0]['KONVERSI'];
						$KEIDR 		= $HARGA_BARANG * $checkCurr[0]['KONVERSI'];
						$BM_HB 		= (($BEA_MASUK / 100) * $KEIDR) + $KEIDR;
					}
				}

				if(count($checkAdaTidak)>0){
					//echo "update ?";
					$where_edit['ID_ITEM'] 		= $KODE_BARANG;
					$where_edit['ID_PESERTA'] 	= $KODE_VENDOR;
					$where_edit['ID_HEADER'] 	= $NO_TENDER;
					$where_edit['ID_USER'] 		= $iduser;
					$set_edit['HARGA'] 			= $HARGA_BARANG;
					$set_edit['HARGATERKINI'] 	= $HARGA_BARANG;
					$set_edit['DELIVERY_TIME'] 	= $DELIVERY_TIME;
					$set_edit['CURRENCY'] 		= $CURRENCY;
					$set_edit['KONVERSI'] 		= $KONVERSI;
					$set_edit['KONVERSI_IDR'] 		= $KEIDR;
					$set_edit['KONVERSI_IDR_UBAH'] 	= $KEIDR;
					$set_edit['BEA_MASUK'] 			= $BEA_MASUK;
					$set_edit['BM_HB'] 			= $BM_HB;
					$set_edit['MERK'] 			= $MERK;
					$result 					= $this->updateItemPrice($set_edit, $where_edit);

				} else {
					//echo "indert ?";
					$data['ID_PESERTA'] = $KODE_VENDOR;
					$data['ID_ITEM'] 	= $KODE_BARANG;
					$data['HARGA'] 		= $HARGA_BARANG;
					$data['HARGATERKINI']= $HARGA_BARANG;
					$data['DELIVERY_TIME']= $DELIVERY_TIME;
					$data['ID_USER'] 	= $iduser;
					$data['ID_HEADER'] 	= $NO_TENDER;
					$data['CURRENCY'] 	= $CURRENCY;
					$data['KONVERSI'] 	= $KONVERSI;
					$data['KONVERSI_IDR'] 	= $KEIDR;
					$data['KONVERSI_IDR_UBAH'] 	= $KEIDR;
					$data['BEA_MASUK'] 		= $BEA_MASUK;
					$data['BM_HB'] 		= $BM_HB;
					$data['MERK'] 		= $MERK;
					$result 			= $this->addItemsPrice($data);
				}
				// echo $this->db->last_query();die;
				//die;
			} else {
				//echo "gagal";die;
			}
	} //ENDFOR
		//cek jika ada item yang tidak masuk (tidak lolos evaltek)
	$NEW_KODE_BARANG_NO_INPUT = rtrim($KODE_BARANG_NO_INPUT,",");
	// echo $NEW_KODE_BARANG_NO_INPUT;
	// die;
	$checkSisaItem = $this->getBatchDetailItemNotInEdit($NEW_KODE_BARANG_NO_INPUT, $NO_TENDER);
		// echo "<pre>";
		// print_r($checkSisaItem);
		// if(count($checkSisaItem)>0) echo "tidak";
		// else echo "lengkap";
		// die;
	if(count($checkSisaItem)>0){
		foreach ($checkSisaItem as $csi) {
			$data['ID_PESERTA'] = $KODE_VENDOR;
			$data['ID_ITEM'] 	= $csi['ID_ITEM'];
			$data['HARGA'] 		= 0;
			$data['HARGATERKINI']= 0;
			$data['DELIVERY_TIME']= 0;
			$data['ID_USER'] 	= $iduser;

			$set_edit['CURRENCY'] 		= 0;
			$set_edit['KONVERSI'] 		= 0;
			$set_edit['KONVERSI_IDR'] 		= 0;
			$set_edit['KONVERSI_IDR_UBAH'] 	= 0;
			$set_edit['BEA_MASUK'] 			= 0;
			$set_edit['BM_HB'] 		= 0;
			$set_edit['MERK'] 		= '';
			$result 			= $this->addItemsPrice($data);
		}
	}

	$set_edit2['STATUS_UPLOAD'] = 1;
	$where_edit2['KODE_VENDOR'] = $KODE_VENDOR;
	$where_edit2['ID_HEADER'] = $NO_TENDER;
	$result = $this->updateUserEdit($set_edit2, $where_edit2);
}

public function upload_data($filename, $KODE_VENDOR, $iduser)
{
	$this->load->library('excel');
	ini_set('memory_limit', '-1');

	$target_file = './upload/temp/';
	$buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/temp/") : false;
	move_uploaded_file($_FILES["import_excel"]["tmp_name"], $target_file.$_FILES['import_excel']['name']);


	$inputFileName = './upload/temp/'.$_FILES['import_excel']['name'];
	try {
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	} catch(Exception $e) {
		die('Error loading file :' . $e->getMessage());
	}

	$worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	$numRows = count($worksheet);
		// echo "<pre>";
		// print_r($worksheet);
		//die;
	$KODE_BARANG_NO_INPUT = "";
	for ($i=2; $i < ($numRows+1) ; $i++) { 
		$KODE_BARANG 	= (string)$worksheet[$i]["B"];
		$KODE_BARANG_NO_INPUT .= "'".$worksheet[$i]["B"]."'".",";
		$HARGA_BARANG 	= $worksheet[$i]["I"] != null ? str_replace(',', '', $worksheet[$i]["I"]) : 0;
		$BEA_MASUK 		= $worksheet[$i]["J"] != null ? str_replace(',', '', $worksheet[$i]["J"]) : 0;
		$DELIVERY_TIME 	= $worksheet[$i]["K"];
		$CURRENCY 		= $worksheet[$i]["H"];
		$MERK 			= strtoupper($worksheet[$i]["L"]);

			// echo $KODE_BARANG."-";
			// echo $HARGA_BARANG.".";
			// if($KODE_BARANG!="") echo "t.kosong<br>";
			// else echo "kosong<br>";
		if ($KODE_BARANG != "") {
				//echo "masuk ?";
			$checkAdaTidak = $this->getDetailItemPriceHarga($KODE_BARANG, $KODE_VENDOR, $iduser);
				//JIKA MERK KOSONG TIDAK UPDATE
			$ambilHargaMerkSama = $this->checkMerkSama($MERK, $KODE_VENDOR, $iduser);	

			if($CURRENCY == "IDR"){
				$KONVERSI = 1;
				if(count($ambilHargaMerkSama)>0 && $MERK!=""){
					if($HARGA_BARANG<$ambilHargaMerkSama['BM_HB']){
						$KEIDR = $ambilHargaMerkSama['KONVERSI_IDR'];
						$BM_HB = $ambilHargaMerkSama['BM_HB'];							
					} else {
						$KEIDR = $HARGA_BARANG;
						$BM_HB = $HARGA_BARANG;

						$where_edit['ID_PESERTA'] 	= $KODE_VENDOR;
						$where_edit['ID_USER'] 		= $iduser;
						$where_edit['MERK'] 		= $MERK;
						$set_edit['KONVERSI'] 		= $KONVERSI;
						$set_edit['KONVERSI_IDR'] 		= $KEIDR;
						$set_edit['KONVERSI_IDR_UBAH'] 	= $KEIDR;
						$set_edit['BM_HB'] 			= $BM_HB;
						$result 					= $this->updateItemPrice($set_edit, $where_edit);
					}

				} else {
						//$BEA_MASUK = 0;
					$KEIDR = $HARGA_BARANG;
					$BM_HB = $HARGA_BARANG;
				}
			} else {
					//$ambilCurrPeserta = $this -> ec_auction_itemize_m -> get_list_Peserta_temp_id($iduser, $KODE_VENDOR);
					//$BEA_MASUK = $ambilCurrPeserta[0]['BEA_MASUK'];
				if(count($ambilHargaMerkSama)>0 && $MERK!=""){
					if($HARGA_BARANG<$ambilHargaMerkSama['BM_HB']){
						$KONVERSI 	= $ambilHargaMerkSama['KONVERSI'];
						$KEIDR 		= $ambilHargaMerkSama['KONVERSI_IDR'];
						$BM_HB 		= $ambilHargaMerkSama['BM_HB'];							
					} else {
						$checkCurr 	= $this->getCurrency($CURRENCY, 'IDR');
						$KONVERSI 	= $checkCurr[0]['KONVERSI'];
						$KEIDR 		= $HARGA_BARANG * $checkCurr[0]['KONVERSI'];
						$BM_HB 		= (($BEA_MASUK / 100) * $KEIDR) + $KEIDR;
						$where_edit['ID_PESERTA'] 	= $KODE_VENDOR;
						$where_edit['ID_USER'] 		= $iduser;
						$where_edit['MERK'] 		= $MERK;
						$set_edit['KONVERSI'] 		= $KONVERSI;
						$set_edit['KONVERSI_IDR'] 		= $KEIDR;
						$set_edit['KONVERSI_IDR_UBAH'] 	= $KEIDR;
						$set_edit['BM_HB'] 			= $BM_HB;
						$result 					= $this->updateItemPrice($set_edit, $where_edit);
					}
				} else {
					$checkCurr 	= $this->getCurrency($CURRENCY, 'IDR');
					$KONVERSI 	= $checkCurr[0]['KONVERSI'];
					$KEIDR 		= $HARGA_BARANG * $checkCurr[0]['KONVERSI'];
					$BM_HB 		= (($BEA_MASUK / 100) * $KEIDR) + $KEIDR;
				}
			}

			if(count($checkAdaTidak)>0){
					//echo "update ?";
				$where_edit['ID_ITEM'] 		= $KODE_BARANG;
				$where_edit['ID_PESERTA'] 	= $KODE_VENDOR;
				$where_edit['ID_USER'] 		= $iduser;
				$set_edit['HARGA'] 			= $HARGA_BARANG;
				$set_edit['HARGATERKINI'] 	= $HARGA_BARANG;
				$set_edit['DELIVERY_TIME'] 	= $DELIVERY_TIME;
				$set_edit['CURRENCY'] 		= $CURRENCY;
				$set_edit['KONVERSI'] 		= $KONVERSI;
				$set_edit['KONVERSI_IDR'] 		= $KEIDR;
				$set_edit['KONVERSI_IDR_UBAH'] 	= $KEIDR;
				$set_edit['BEA_MASUK'] 			= $BEA_MASUK;
				$set_edit['BM_HB'] 			= $BM_HB;
				$set_edit['MERK'] 			= $MERK;
				$result 					= $this->updateItemPrice($set_edit, $where_edit);

			} else {
					//echo "indert ?";
				$data['ID_PESERTA'] = $KODE_VENDOR;
				$data['ID_ITEM'] 	= $KODE_BARANG;
				$data['HARGA'] 		= $HARGA_BARANG;
				$data['HARGATERKINI']= $HARGA_BARANG;
				$data['DELIVERY_TIME']= $DELIVERY_TIME;
				$data['ID_USER'] 	= $iduser;
				$data['CURRENCY'] 	= $CURRENCY;
				$data['KONVERSI'] 	= $KONVERSI;
				$data['KONVERSI_IDR'] 	= $KEIDR;
				$data['KONVERSI_IDR_UBAH'] 	= $KEIDR;
				$data['BEA_MASUK'] 		= $BEA_MASUK;
				$data['BM_HB'] 		= $BM_HB;
				$data['MERK'] 		= $MERK;
				$result 			= $this->addItemsPrice($data);
			}
				// echo $this->db->last_query();die;
				//die;
		} else {
				//echo "gagal";die;
		}
	} //ENDFOR
		//cek jika ada item yang tidak masuk (tidak lolos evaltek)
	$NEW_KODE_BARANG_NO_INPUT = rtrim($KODE_BARANG_NO_INPUT,",");
	// echo $NEW_KODE_BARANG_NO_INPUT;
	// die;
	$checkSisaItem = $this->getBatchDetailItemNotIn($NEW_KODE_BARANG_NO_INPUT, $iduser);
		// echo "<pre>";
		// print_r($checkSisaItem);
		// if(count($checkSisaItem)>0) echo "tidak";
		// else echo "lengkap";
		// die;
	if(count($checkSisaItem)>0){
		foreach ($checkSisaItem as $csi) {
			$data['ID_PESERTA'] = $KODE_VENDOR;
			$data['ID_ITEM'] 	= $csi['ID_ITEM'];
			$data['HARGA'] 		= 0;
			$data['HARGATERKINI']= 0;
			$data['DELIVERY_TIME']= 0;
			$data['ID_USER'] 	= $iduser;

			$set_edit['CURRENCY'] 		= 0;
			$set_edit['KONVERSI'] 		= 0;
			$set_edit['KONVERSI_IDR'] 		= 0;
			$set_edit['KONVERSI_IDR_UBAH'] 	= 0;
			$set_edit['BEA_MASUK'] 			= 0;
			$set_edit['BM_HB'] 		= 0;
			$set_edit['MERK'] 		= '';
			$result 			= $this->addItemsPrice($data);
		}
	}

	$set_edit2['STATUS_UPLOAD'] = 1;
	$where_edit2['KODE_VENDOR'] = $KODE_VENDOR;
	$where_edit2['ID_USER'] = $iduser;
	$result = $this->updateUser($set_edit2, $where_edit2);
}

public function uploaddatavh($filename){
	$this->load->library('excel');//Load library excelnya
	ini_set('memory_limit', '-1');

	$target_file = './upload/temp/';
	$buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/temp/") : false;
	move_uploaded_file($_FILES["import_excel"]["tmp_name"], $target_file.$_FILES['import_excel']['name']);


	$inputFileName = './upload/temp/'.$_FILES['import_excel']['name'];
	try {
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	} catch(Exception $e) {
		die('Error loading file :' . $e->getMessage());
	}

	$worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	$numRows = count($worksheet);
		// echo "<pre>";
		// print_r($worksheet);
		// echo $worksheet[$i]["A"];
		// die;
	for ($i=2; $i < ($numRows+1) ; $i++) { 
		if($worksheet[$i]["A"]!=""){
			$data['VENDOR_ID'] = $worksheet[$i]["A"];
			$data['VENDOR_NAME'] = $worksheet[$i]["B"];
			$data['LOGIN_ID'] = $worksheet[$i]["C"];
			$data['PASSWORD'] = $worksheet[$i]["D"];
			$data['EMAIL_ADDRESS'] = $worksheet[$i]["E"];
			$data['VENDOR_NO'] = $worksheet[$i]["F"];
			$data['PREFIX'] = $worksheet[$i]["G"];
			$data['PREFIX_OTHER'] = $worksheet[$i]["H"];
			$data['SUFFIX'] = $worksheet[$i]["I"];
			$data['SUFFIX_OTHER'] = $worksheet[$i]["J"];
			$data['ADDRESS_STREET'] = $worksheet[$i]["K"];
			$data['ADDRESS_CITY'] = $worksheet[$i]["L"];
			$data['ADDRES_PROP'] = $worksheet[$i]["M"];
			$data['ADDRESS_POSTCODE'] = $worksheet[$i]["N"];
			$data['ADDRESS_COUNTRY'] = $worksheet[$i]["O"];
			$data['ADDRESS_PHONE_NO'] = $worksheet[$i]["P"];
			$data['ADDRESS_WEBSITE'] = $worksheet[$i]["Q"];
			$data['ADDRESS_DOMISILI_NO'] = $worksheet[$i]["R"];
			$data['ADDRESS_DOMISILI_DATE'] = ($worksheet[$i]["S"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["S"])) : date("d/m/Y");

			$data['ADDRESS_DOMISILI_EXP_DATE'] = ($worksheet[$i]["T"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["T"])) : date("d/m/Y");
			$data['CONTACT_NAME'] = $worksheet[$i]["U"];
			$data['CONTACT_POS'] = $worksheet[$i]["V"];
			$data['CONTACT_PHONE_NO'] = $worksheet[$i]["W"];
			$data['CONTACT_EMAIL'] = $worksheet[$i]["X"];
			$data['NPP'] = $worksheet[$i]["Y"];
			$data['NPP_DATE'] = ($worksheet[$i]["Z"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["Z"])) : date("d/m/Y");
			$data['NPWP_NO'] = $worksheet[$i]["AA"];
			$data['NPWP_ADDRESS'] = $worksheet[$i]["AB"];
			$data['NPWP_CITY'] = $worksheet[$i]["AC"];
			$data['NPWP_PROP'] = $worksheet[$i]["AD"];
			$data['NPWP_POSTCODE'] = $worksheet[$i]["AE"];
			$data['NPWP_PKP'] = $worksheet[$i]["AF"];
			$data['NPWP_PKP_NO'] = $worksheet[$i]["AG"];
			$data['VENDOR_TYPE'] = $worksheet[$i]["AH"];
			$data['SIUP_IUJK_TYPE'] = $worksheet[$i]["AI"];
			$data['SIUP_ISSUED_BY'] = $worksheet[$i]["AJ"];
			$data['SIUP_NO'] = $worksheet[$i]["AK"];
			$data['SIUP_TYPE'] = $worksheet[$i]["AL"];
			$data['SIUP_FROM'] = ($worksheet[$i]["AM"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AM"])) : date("d/m/Y");
			$data['SIUP_TO'] = ($worksheet[$i]["AN"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AN"])) : date("d/m/Y");
			$data['TDP_ISSUED_BY'] = $worksheet[$i]["AO"];
			$data['TDP_NO'] = $worksheet[$i]["AP"];
			$data['TDP_FROM'] = ($worksheet[$i]["AQ"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AQ"])) : date("d/m/Y");
			$data['TDP_TO'] = ($worksheet[$i]["AR"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AR"])) : date("d/m/Y");
			$data['AGEN_ISSUED_BY'] = $worksheet[$i]["AS"];
			$data['AGEN_FROM'] = ($worksheet[$i]["AT"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AT"])) : date("d/m/Y");
			$data['AGEN_TO'] = ($worksheet[$i]["AU"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AU"])) : date("d/m/Y");
			$data['IMP_ISSUED_BY'] = $worksheet[$i]["AV"];
			$data['IMP_FROM'] = ($worksheet[$i]["AW"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AW"])) : date("d/m/Y");
			$data['IMP_TO'] = ($worksheet[$i]["AX"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AX"])) : date("d/m/Y");
			
			$data['ATT_ORG'] = $worksheet[$i]["AY"];
			$data['FIN_AKTA_MDL_DSR_CURR'] = $worksheet[$i]["AZ"];
			$data['FIN_AKTA_MDL_DSR'] = $worksheet[$i]["BA"];
			$data['FIN_AKTA_MDL_STR_CURR'] = $worksheet[$i]["BB"];
			$data['FIN_AKTA_MDL_STR'] = $worksheet[$i]["BC"];
			$data['FIN_ASSET_MDL_DSR_CUR'] = $worksheet[$i]["BD"];
			$data['FIN_ASSET_MDL_DSR'] = ($worksheet[$i]["BE"] !="") ? $worksheet[$i]["BE"] : 0;
			$data['FIN_RPT_CURRENCY'] = $worksheet[$i]["BF"];
			$data['FIN_RPT_YEAR'] = ($worksheet[$i]["BG"] !="") ? $worksheet[$i]["BG"] : date("Y");
			$data['FIN_RPT_TYPE'] = $worksheet[$i]["BH"];
			$data['FIN_RPT_ASSET_VALUE'] = ($worksheet[$i]["BI"] !="") ? $worksheet[$i]["BI"] : 0;
			$data['FIN_RPT_HUTANG'] = ($worksheet[$i]["BJ"] !="") ? $worksheet[$i]["BJ"] : 0;
			$data['FIN_RPT_REVENUE'] = ($worksheet[$i]["BK"] !="") ? $worksheet[$i]["BK"] : 0;
			$data['FIN_RPT_NETINCOME'] = ($worksheet[$i]["BL"] !="") ? $worksheet[$i]["BL"] : 0;
			$data['FIN_CLASS'] = $worksheet[$i]["BM"];
			$data['SMK_NO'] = $worksheet[$i]["BN"];
			$data['SMK_DATE'] = ($worksheet[$i]["BO"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BO"])) : date("d/m/Y");
			$data['SMK_EXPIRED'] = ($worksheet[$i]["BP"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BP"])) : date("d/m/Y");
			$data['EXPIREDFROM'] = ($worksheet[$i]["BQ"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BQ"])) : date("d/m/Y");
			$data['EXPIREDTO'] = ($worksheet[$i]["BR"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BR"])) : date("d/m/Y");
			$data['EXPIREDBY'] = $worksheet[$i]["BS"];
			$data['CREATION_DATE'] = ($worksheet[$i]["BT"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BT"])) : date("d/m/Y");
			$data['CREATED_BY'] = $worksheet[$i]["BU"];
			$data['MODIFIED_DATE'] = ($worksheet[$i]["BV"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BV"])) : date("d/m/Y");
			$data['MODIFIED_BY'] = $worksheet[$i]["BW"];
			$data['STATUS'] = $worksheet[$i]["BX"];
			$data['NEXT_PAGE'] = $worksheet[$i]["BY"];
			$data['REG_STATUS_ID'] = $worksheet[$i]["BZ"];
			$data['REG_ISACTIVATE'] = $worksheet[$i]["CA"];
			$data['REG_SESSIONID'] = $worksheet[$i]["CB"];
			$data['COMPANYID'] = $worksheet[$i]["CC"];
			$data['API_ISSUED_BY'] = '';//$worksheet[$i]["CD"];
			$data['API_NO'] = '';//$worksheet[$i]["CE"];
			$data['API_FROM'] = date("d/m/Y");//$worksheet[$i]["CF"];
			$data['API_TO'] = date("d/m/Y");//$worksheet[$i]["CG"];
			$data['CONTACT_PHONE_HP'] = '';//$worksheet[$i]["CH"];
			$data['DOMISILI_NO_DOC'] = '';//$worksheet[$i]["CI"];
			$data['NPWP_NO_DOC'] = '';//$worksheet[$i]["CJ"];
			$data['PKP_NO_DOC'] = '';//$worksheet[$i]["CK"];
			$data['SIUP_NO_DOC'] = '';//$worksheet[$i]["CL"];
			$data['TDP_NO_DOC'] = '';//$worksheet[$i]["CM"];
			$data['STATUS_PERUBAHAN'] = 0;//$worksheet[$i]["CN"];
			$data['STATUS_ADJ'] = 0;//$worksheet[$i]["CO"];
			$data['PERFORMANCE'] = 0;//$worksheet[$i]["CP"];
			$data['REQ_PASS_ID'] = '';//$worksheet[$i]["CQ"];
			$data['PRODUCT_TYPE_PROC'] = '';//$worksheet[$i]["CR"];

			$result 			= $this->addVndHeader($data);
		} else {
			echo "gagal";die;
		}

			// if($result){
			// 	echo "sukses";
			// } else {
			// 	echo "gagal";
			// }
	} //ENDFOR

		// die;
}

public function addVndHeader($data) {
		//echo "<pre>";print_r($data);die;
		//$this -> db -> insert($this -> tableVnd_header, $data);

	//error 4072
	//error 4737
	$SQL = "
	INSERT INTO VND_HEADER (
	VENDOR_ID,
	VENDOR_NAME,
	LOGIN_ID,
	PASSWORD,
	EMAIL_ADDRESS,
	VENDOR_NO,
	PREFIX,
	PREFIX_OTHER,
	SUFFIX,
	SUFFIX_OTHER,
	ADDRESS_STREET,
	ADDRESS_CITY,
	ADDRES_PROP,
	ADDRESS_POSTCODE,
	ADDRESS_COUNTRY,
	ADDRESS_PHONE_NO,
	ADDRESS_WEBSITE,
	ADDRESS_DOMISILI_NO,
	ADDRESS_DOMISILI_DATE,

	ADDRESS_DOMISILI_EXP_DATE,
	CONTACT_NAME,
	CONTACT_POS,
	CONTACT_PHONE_NO,
	CONTACT_EMAIL,
	NPP,
	NPP_DATE,
	NPWP_NO,
	NPWP_ADDRESS,
	NPWP_CITY,
	NPWP_PROP,
	NPWP_POSTCODE,
	NPWP_PKP,
	NPWP_PKP_NO,
	VENDOR_TYPE,
	SIUP_IUJK_TYPE,
	SIUP_ISSUED_BY,
	SIUP_NO,
	SIUP_TYPE,
	SIUP_FROM,
	SIUP_TO,
	TDP_ISSUED_BY,
	TDP_NO,
	TDP_FROM,
	TDP_TO,
	AGEN_ISSUED_BY,
	AGEN_FROM,
	AGEN_TO,
	IMP_ISSUED_BY,
	IMP_FROM,
	IMP_TO,

	ATT_ORG,
	FIN_AKTA_MDL_DSR_CURR,
	FIN_AKTA_MDL_DSR,
	FIN_AKTA_MDL_STR_CURR,
	FIN_AKTA_MDL_STR,
	FIN_ASSET_MDL_DSR_CUR,
	FIN_ASSET_MDL_DSR,
	FIN_RPT_CURRENCY,
	FIN_RPT_YEAR,
	FIN_RPT_TYPE,
	FIN_RPT_ASSET_VALUE,
	FIN_RPT_HUTANG,
	FIN_RPT_REVENUE,
	FIN_RPT_NETINCOME,
	FIN_CLASS,
	SMK_NO,


	SMK_DATE,
	SMK_EXPIRED,
	EXPIREDFROM,
	EXPIREDTO,
	EXPIREDBY,
	CREATION_DATE,
	CREATED_BY,
	MODIFIED_DATE,
	MODIFIED_BY,
	STATUS,
	NEXT_PAGE,
	REG_STATUS_ID,
	REG_ISACTIVATE,
	REG_SESSIONID,
	COMPANYID,
	API_ISSUED_BY,
	API_NO,
	API_FROM,
	API_TO,

	CONTACT_PHONE_HP,
	DOMISILI_NO_DOC,
	NPWP_NO_DOC,
	PKP_NO_DOC,
	SIUP_NO_DOC,
	TDP_NO_DOC,
	STATUS_PERUBAHAN,
	STATUS_ADJ,
	PERFORMANCE,
	REQ_PASS_ID,
	PRODUCT_TYPE_PROC
)  
values
(
	" . $data['VENDOR_ID'] . ",
	'" . $data['VENDOR_NAME'] . "',
	'" . $data['LOGIN_ID'] . "',
	'" . $data['PASSWORD'] . "',
	'" . $data['EMAIL_ADDRESS'] . "',
	'" . $data['VENDOR_NO'] . "',
	'" . $data['PREFIX'] . "',
	'" . $data['PREFIX_OTHER'] . "', 
	'" . $data['SUFFIX'] . "',
	'" . $data['SUFFIX_OTHER'] . "', 
	'" . $data['ADDRESS_STREET'] . "',
	'" . $data['ADDRESS_CITY'] . "',
	'" . $data['ADDRES_PROP'] . "', 
	'" . $data['ADDRESS_POSTCODE'] . "',
	'" . $data['ADDRESS_COUNTRY'] . "',
	'" . $data['ADDRESS_PHONE_NO'] . "',
	'" . $data['ADDRESS_WEBSITE'] . "', 
	'" . $data['ADDRESS_DOMISILI_NO'] . "',
	TO_DATE('" . $data['ADDRESS_DOMISILI_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),

	TO_DATE('" . $data['ADDRESS_DOMISILI_EXP_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	'" . $data['CONTACT_NAME'] . "',
	'" . $data['CONTACT_POS'] . "',
	'" . $data['CONTACT_PHONE_NO'] . "',
	'" . $data['CONTACT_EMAIL'] . "',
	'" . $data['NPP'] . "',
	TO_DATE('" . $data['NPP_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	'" . $data['NPWP_NO'] . "',
	'" . $data['NPWP_ADDRESS'] . "', 
	'" . $data['NPWP_CITY'] . "',
	'" . $data['NPWP_PROP'] . "', 
	'" . $data['NPWP_POSTCODE'] . "',
	'" . $data['NPWP_PKP'] . "',
	'" . $data['NPWP_PKP_NO'] . "',
	'" . $data['VENDOR_TYPE'] . "',
	'" . $data['SIUP_IUJK_TYPE'] . "',
	'" . $data['SIUP_ISSUED_BY'] . "',
	'" . $data['SIUP_NO'] . "',
	'" . $data['SIUP_TYPE'] . "',
	TO_DATE('" . $data['SIUP_FROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	TO_DATE('" . $data['SIUP_TO'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	'" . $data['TDP_ISSUED_BY'] . "',
	'" . $data['TDP_NO'] . "',
	TO_DATE('" . $data['TDP_FROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	TO_DATE('" . $data['TDP_TO'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	'" . $data['AGEN_ISSUED_BY'] . "',
	TO_DATE('" . $data['AGEN_FROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	TO_DATE('" . $data['AGEN_TO'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	'" . $data['IMP_ISSUED_BY'] . "',
	TO_DATE('" . $data['IMP_FROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	TO_DATE('" . $data['IMP_TO'] . "', 'dd/mm/yyyy hh24:mi:ss'),

	'" . $data['ATT_ORG'] . "',
	'" . $data['FIN_AKTA_MDL_DSR_CURR'] . "',
	" . $data['FIN_AKTA_MDL_DSR'] . ",
	'" . $data['FIN_AKTA_MDL_STR_CURR'] . "',
	" . $data['FIN_AKTA_MDL_STR'] . ",
	'" . $data['FIN_ASSET_MDL_DSR_CUR'] . "', 
	" . $data['FIN_ASSET_MDL_DSR'] . ",
	'" . $data['FIN_RPT_CURRENCY'] . "',
	" . $data['FIN_RPT_YEAR'] . ",
	'" . $data['FIN_RPT_TYPE'] . "', 
	" . $data['FIN_RPT_ASSET_VALUE'] . ",
	" . $data['FIN_RPT_HUTANG'] . ",
	" . $data['FIN_RPT_REVENUE'] . ",
	" . $data['FIN_RPT_NETINCOME'] . ",
	'" . $data['FIN_CLASS'] . "',
	'" . $data['SMK_NO'] . "',

	TO_DATE('" . $data['SMK_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	TO_DATE('" . $data['SMK_EXPIRED'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	TO_DATE('" . $data['EXPIREDFROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	TO_DATE('" . $data['EXPIREDTO'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	'" . $data['EXPIREDBY'] . "',
	TO_DATE('" . $data['CREATION_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	'" . $data['CREATED_BY'] . "',
	TO_DATE('" . $data['MODIFIED_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	'" . $data['MODIFIED_BY'] . "',
	'" . $data['STATUS'] . "',
	'" . $data['NEXT_PAGE'] . "',
	'" . $data['REG_STATUS_ID'] . "',
	'" . $data['REG_ISACTIVATE'] . "',
	'" . $data['REG_SESSIONID'] . "',
	'" . $data['COMPANYID'] . "',
	'" . $data['API_ISSUED_BY'] . "', 
	'" . $data['API_NO'] . "',
	TO_DATE('" . $data['API_FROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	TO_DATE('" . $data['API_TO'] . "', 'dd/mm/yyyy hh24:mi:ss'),


	'" . $data['CONTACT_PHONE_HP'] . "',
	'" . $data['DOMISILI_NO_DOC'] . "', 
	'" . $data['NPWP_NO_DOC'] . "',
	'" . $data['PKP_NO_DOC'] . "',
	'" . $data['SIUP_NO_DOC'] . "',
	'" . $data['TDP_NO_DOC'] . "', 
	'" . $data['STATUS_PERUBAHAN'] . "',
	'" . $data['STATUS_ADJ'] . "',
	'" . $data['PERFORMANCE'] . "',
	'" . $data['REQ_PASS_ID'] . "',
	'" . $data['PRODUCT_TYPE_PROC']."'

	)
	";
	$this -> db -> query($SQL);
}


}
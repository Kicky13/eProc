<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ec_auction_bobot_m extends CI_Model {
	protected $tableHeader = 'EC_AUCTION_BOBOT_HEADER', $tableItem = 'EC_AUCTION_BOBOT_ITEM', $tablePeserta = 'EC_AUCTION_BOBOT_PESERTA', $tableItemTemp = 'EC_AUCTION_BOBOT_ITEM_temp', $tablePesertaTemp = 'EC_AUCTION_BOBOT_PESERTA_temp', $tableLog = 'EC_AUCTION_BOBOT_LOG';

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
		"EC_AUCTION_BOBOT_PESERTA"
		UNION
		SELECT
		MAX (
		TO_NUMBER (SUBSTR(USERID, 4))
		) AS MAXs
		FROM
		"EC_AUCTION_BOBOT_PESERTA_temp"
		)';
		$result = $this -> db -> query($SQL);
		return $result -> row_array();
	}

	public function get_min_harga($user) {
		$SQL = 'SELECT
		MIN(HARGAAWAL) AS MINHARGA
		FROM
		"EC_AUCTION_BOBOT_PESERTA_temp"
		WHERE
		ID_USER = \'' . $user . '\'';
		$result = $this -> db -> query($SQL);
		return $result -> row_array();
	}

	// public function get_min_harga() {
	// 	$this -> db -> from($this -> tablePesertaTemp);
	// 	$this -> db -> select_min("HARGATERKINI");
	// 	$this -> db -> where("ID_USER");
	// 	$query = $this -> db -> get();
	// 	return $query -> row_array();
	// }

	public function get_useridTemp() {
		$this -> db -> from($this -> tablePesertaTemp);
		$this -> db -> select_max("TO_NUMBER(SUBSTR(USERID, 4))", 'USERID');
		$query = $this -> db -> get();
		return $query -> row_array();
	}

	public function get_userid() {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> select_max("TO_NUMBER(SUBSTR(USERID, 4))", 'USERID');
		$query = $this -> db -> get();
		return $query -> row_array();
	}

	public function get_hps($ID_USER) {
		$SQL = 'SELECT SUM(jumlah * price) as HPS from "EC_AUCTION_BOBOT_ITEM_temp" WHERE ID_USER=\'' . $ID_USER . '\'';
		$result = $this -> db -> query($SQL);
		return $result -> row_array();
	}

	public function get_Auction($NO_TENDER) {
		$SQL = "SELECT
		H .*, TO_CHAR (
		H .TGL_BUKA,
		'DD/MM/YYYY HH24:MI:SS' 
		) AS PEMBUKAAN,
		TO_CHAR (
		H .TGL_TUTUP,
		'DD/MM/YYYY HH24:MI:SS'
		) AS PENUTUPAN
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

	public function get_list_Peserta($NO_TENDER) {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> where("ID_HEADER", $NO_TENDER, TRUE);
		// $this -> db -> join('EC_AUCTION_BOBOT_LOG', 'EC_AUCTION_BOBOT_LOG.NO_TENDER = EC_AUCTION_BOBOT_PESERTA.ID_HEADER AND EC_AUCTION_BOBOT_LOG.VENDOR_NO = EC_AUCTION_BOBOT_PESERTA.KODE_VENDOR', 'left');
		$this -> db -> join("(SELECT MAX(LG.CREATED_AT) AS TGL, LG.VENDOR_NO FROM EC_AUCTION_BOBOT_LOG LG WHERE LG.NO_TENDER='". $NO_TENDER ."' AND LG.VENDOR_NO IN (SELECT PES.KODE_VENDOR FROM EC_AUCTION_BOBOT_PESERTA PES WHERE PES.ID_HEADER='". $NO_TENDER ."') GROUP BY LG.VENDOR_NO ORDER BY TGL ASC) TB1", 'TB1.VENDOR_NO=EC_AUCTION_BOBOT_PESERTA.KODE_VENDOR', 'INNER');
		// $this -> db -> join(' (Select CREATED_AT,VENDOR_NO from EC_AUCTION_BOBOT_LOG where NO_TENDER='.$NO_TENDER.' group by CREATED_AT,VENDOR_NO) EL ', 'EL.NO_TENDER = EC_AUCTION_BOBOT_PESERTA.ID_HEADER AND EL.VENDOR_NO = EC_AUCTION_BOBOT_PESERTA.KODE_VENDOR', 'left');
		$this -> db -> order_by('NILAI_GABUNG DESC');
		$this -> db -> order_by('TB1.TGL');
		// $this -> db -> order_by('CREATED_AT', 'ASC');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_list_Peserta_Undur_Diri($NO_TENDER) {
		$this -> db -> from($this -> tablePeserta);
		$this -> db -> where("ID_HEADER", $NO_TENDER, TRUE);
		$this -> db -> where("STATUS",2);
		// $this -> db -> join('EC_AUCTION_BOBOT_LOG', 'EC_AUCTION_BOBOT_LOG.NO_TENDER = EC_AUCTION_BOBOT_PESERTA.ID_HEADER AND EC_AUCTION_BOBOT_LOG.VENDOR_NO = EC_AUCTION_BOBOT_PESERTA.KODE_VENDOR', 'left');
		$this -> db -> join("(SELECT MAX(LG.CREATED_AT) AS TGL, LG.VENDOR_NO FROM EC_AUCTION_BOBOT_LOG LG WHERE LG.NO_TENDER='". $NO_TENDER ."' AND LG.VENDOR_NO IN (SELECT PES.KODE_VENDOR FROM EC_AUCTION_BOBOT_PESERTA PES WHERE PES.ID_HEADER='". $NO_TENDER ."') GROUP BY LG.VENDOR_NO ORDER BY TGL ASC) TB1", 'TB1.VENDOR_NO=EC_AUCTION_BOBOT_PESERTA.KODE_VENDOR', 'INNER');
		// $this -> db -> join(' (Select CREATED_AT,VENDOR_NO from EC_AUCTION_BOBOT_LOG where NO_TENDER='.$NO_TENDER.' group by CREATED_AT,VENDOR_NO) EL ', 'EL.NO_TENDER = EC_AUCTION_BOBOT_PESERTA.ID_HEADER AND EL.VENDOR_NO = EC_AUCTION_BOBOT_PESERTA.KODE_VENDOR', 'left');
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

	public function edit($data = '') {
		$this -> db -> set('TGL_BUKA', "TO_DATE('" . $data['TGL_BUKA'] . "', 'dd/mm/yyyy hh24:mi:ss')", FALSE);
		$this -> db -> set('TGL_TUTUP', "TO_DATE('" . $data['TGL_TUTUP'] . "', 'dd/mm/yyyy hh24:mi:ss')", FALSE);
		$this -> db -> where('NO_TENDER', $data['NO_TENDER']);
		$this -> db -> update('EC_AUCTION_BOBOT_HEADER');
	}

	public function close($data = '') {
		$this -> db -> set('IS_ACTIVE', 0, FALSE);
		$this -> db -> where('NO_TENDER', $data['NO_TENDER']);
		$this -> db -> update('EC_AUCTION_BOBOT_HEADER');
	}

	public function update_note($notender, $NOTE) {
		$this -> db -> set('NOTE', $NOTE, TRUE);
		$this -> db -> where('NO_TENDER', $notender);
		$this -> db -> update('EC_AUCTION_BOBOT_HEADER');
	}

	public function resetItem($data = '') {
		$this -> db -> where('ID_USER', $data);
		$this -> db -> delete('EC_AUCTION_BOBOT_ITEM_temp');
	}

	public function resetPeserta($data = '') {
		$this -> db -> where('ID_USER', $data);
		$this -> db -> delete('EC_AUCTION_BOBOT_PESERTA_temp');
	}

	public function save($data, $user) {
		$SQL = "INSERT INTO EC_AUCTION_BOBOT_HEADER  
		values
		('" . $data['NO_TENDER'] . "','" . $data['DESC'] . "', '" . $data['LOCATION'] . "', TO_DATE('" . $data['TGL_BUKA'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['TGL_TUTUP'] . "', 'dd/mm/yyyy hh24:mi:ss'), '" . $data['NILAI_PENGURANGAN'] . "', '" . $data['CURR'] . "', '" . $data['TIPE'] . "', 
		'" . $data['HPS'] . "',1,'" . $data['NO_REF'] . "','" . $data['NOTE'] . "','". $data['BOBOT_TEKNIS'] ."','". $data['BOBOT_HARGA'] ."')";
		$this -> db -> query($SQL);
		// $this -> db -> insert($this -> tableHeader, $data);

		$SQL = 'INSERT INTO EC_AUCTION_BOBOT_ITEM
		SELECT *
		FROM "EC_AUCTION_BOBOT_ITEM_temp"
		where ID_USER=\'' . $user . '\'';
		$this -> db -> query($SQL);

		$SQL = 'DELETE from "EC_AUCTION_BOBOT_ITEM_temp" where ID_USER=\'' . $user . '\'';
		$this -> db -> query($SQL);
		$this -> db -> set('ID_HEADER', $data['NO_TENDER'], FALSE);
		$this -> db -> where('ID_HEADER', $user);
		$this -> db -> update('EC_AUCTION_BOBOT_ITEM');

		$SQL = 'INSERT INTO EC_AUCTION_BOBOT_PESERTA
		SELECT *
		FROM "EC_AUCTION_BOBOT_PESERTA_temp"
		where ID_USER=\'' . $user . '\'';
		$this -> db -> query($SQL);

		$SQL = 'DELETE from "EC_AUCTION_BOBOT_PESERTA_temp" where ID_USER=\'' . $user . '\'';
		$this -> db -> query($SQL);
		$this -> db -> set('ID_HEADER', $data['NO_TENDER'], FALSE);
		$this -> db -> where('ID_HEADER', $user);
		$this -> db -> update('EC_AUCTION_BOBOT_PESERTA');
		$this -> db -> from($this -> tablePeserta) -> where("ID_HEADER",$data['NO_TENDER'], TRUE); 
		$result = $this -> db -> get();

		$dataa =  (array)$result -> result_array();

		for ($i=0; $i < sizeof($dataa); $i++) { 
			$SQL = "INSERT INTO EC_AUCTION_BOBOT_LOG   
			values
			('" . $dataa[$i]['KODE_VENDOR'] . "',TO_DATE('" . date('d/m/Y h:i:s') . "', 'dd/mm/yyyy hh24:mi:ss'),'" . $dataa[$i]['HARGAAWAL'] . "', 0, '0', 
			'" . $data['NO_TENDER']  . "')";
			$this -> db -> query($SQL);
		} 
	}

	public function updateNilaigabung($data, $value) {
		$this -> db -> set('NILAI_GABUNG' , $data['NILAI_GABUNG'] , FALSE);
		$this -> db -> where('ID_HEADER', $data['NO_TENDER']);
		$this -> db -> where('KODE_VENDOR' , $value['KODE_VENDOR']);
		$this -> db -> update('EC_AUCTION_BOBOT_PESERTA');
		// echo $this -> db -> last_query();
	}

	public function addPeserta($data) {
		$this -> db -> insert($this -> tablePesertaTemp, $data);
	}

	public function addItems($data) {
		$this -> db -> insert($this -> tableItemTemp, $data);
	}

	public function get_items_temp($ID_USER) {
		$this -> db -> from($this -> tableItemTemp);
		$this -> db -> where("ID_USER", $ID_USER, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getDetailItem($ID_ITEM){
		$this->db->from($this-> tableItemTemp);
		$this->db->where('ID_ITEM', $ID_ITEM);
		$result = $this->db-> get();
		return (array)$result->result_array();
	}

	public function updateItem($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableItemTemp, $set);
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

	public function getLog($NO) {
		$SQL = "SELECT
		H .*,P.*, TO_CHAR (
		H .CREATED_AT,
		'DD/MM/YYYY HH24:MI:SS'
		) AS TGL 
		FROM
		EC_AUCTION_BOBOT_LOG H
		LEFT JOIN
		EC_AUCTION_BOBOT_PESERTA P
		ON
		H.VENDOR_NO=P.KODE_VENDOR AND H.NO_TENDER=P.ID_HEADER 
		WHERE
		H.NO_TENDER = '" . $NO . "'
		AND ITER!=0
		ORDER BY H.CREATED_AT DESC";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function get_peserta_temp($ID_USER) {
		$this -> db -> from($this -> tablePesertaTemp);
		$this -> db -> where("ID_USER", $ID_USER, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_items($ID_HEADER) {
		$this -> db -> from($this -> tableItem);
		$this -> db -> where("ID_HEADER", $ID_HEADER, TRUE);
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

}

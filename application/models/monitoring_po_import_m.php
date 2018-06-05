<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class monitoring_po_import_m extends CI_Model {
	protected $tableItemSap = 'MON_PO_TRANS_ITEM_SAP',
	$tableItem = 'MON_PO_TRANS_ITEM',
	$tableHeaderSap = 'MON_PO_TRANS_HEADER_SAP',
	$tableHeader = 'MON_PO_TRANS_HEADER',
	$tableInco1 = 'MON_PO_TRANS_M_INCO1',
	$tableState = 'MON_PO_TRANS_M_STATE',
	$tableCountry = 'ADM_COUNTRY',
	$tableDocShip = 'MON_PO_TRANS_DOC_SHIP',
	$tableVenCus = 'MON_PO_TRANS_VEN_CUS',
	$tableVenBiaya = 'MON_PO_TRANS_VEN_BIAYA',
	$tableCustom = 'MON_PO_TRANS_CUSTOM',
	$tableM_T = 'MON_PO_TRANS_M_T';

	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	public function getInco1() {
		$this->db->from($this->tableInco1);
		$result = $this->db->get();
		return (array)$result -> result_array();
	}

	public function getState() {
		$this->db->from($this->tableState);
		$result = $this->db->get();
		return (array)$result -> result_array();
	}

	public function getCountry() {
		$this->db->from($this->tableCountry);
		$result = $this->db->get();
		return (array)$result -> result_array();
	}

	public function getCountryDetail($COUNTRY_CODE) {
		$this->db->from($this->tableCountry);
		$this->db->where("COUNTRY_CODE", $COUNTRY_CODE, TRUE);
		$result = $this->db->get();
		return $query->row_array();
		// return (array)$result -> result_array();
	}

	public function getPOHeaderSAP($COMPANY) {
		$this->db->from($this->tableHeaderSap);
		$this -> db -> where("COMPANY", $COMPANY, TRUE);
		//$this -> db -> where("ID_USER", $ID_USER, TRUE);
		$result = $this->db->get();
		return (array)$result -> result_array();
	}

	public function getTranslistSAP2($NO_PO)
	{
		$this -> db -> from($this->tableItemSap);
		$this->db->where('MON_PO_TRANS_HEADER_SAP.NO_PO NOT IN (SELECT "NO_PO" FROM MON_PO_TRANS_ITEM)', NULL, FALSE);
		$this -> db -> join('MON_PO_TRANS_HEADER_SAP', 'MON_PO_TRANS_HEADER_SAP.NO_PO = MON_PO_TRANS_ITEM_SAP.NO_PO', 'left');
		$this -> db -> join('VND_HEADER', 'VND_HEADER.VENDOR_NO = MON_PO_TRANS_ITEM_SAP.VENDOR', 'left');
		$this -> db -> where("MON_PO_TRANS_HEADER_SAP.NO_PO", $NO_PO, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getPOHeader($COMPANY) {
		$this->db->from($this->tableHeader);
		$this -> db -> where("COMPANY", $COMPANY, TRUE);
		$result = $this->db->get();
		return (array)$result -> result_array();
	}

	public function getTranslist2($NO_PO)
	{
		$this -> db -> from($this->tableItem);
		$this -> db -> join('MON_PO_TRANS_HEADER', 'MON_PO_TRANS_HEADER.NO_PO = MON_PO_TRANS_ITEM.NO_PO', 'left');
		$this -> db -> join('VND_HEADER', 'VND_HEADER.VENDOR_NO = MON_PO_TRANS_ITEM.VENDOR', 'left');
		//$this->db->where('MON_PO_TRANS_HEADER.NO_PO NOT IN (SELECT "NO_PO" FROM MON_PO_TRANS_M_T)', NULL, FALSE);
		$this -> db -> where("MON_PO_TRANS_HEADER.NO_PO", $NO_PO, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getTranslist2Vendor($NO_PO, $VENDOR_NO)
	{
		$this -> db -> from($this->tableItem);
		$this -> db -> join('MON_PO_TRANS_HEADER', 'MON_PO_TRANS_HEADER.NO_PO = MON_PO_TRANS_ITEM.NO_PO', 'left');
		$this -> db -> join('VND_HEADER', 'VND_HEADER.VENDOR_NO = MON_PO_TRANS_ITEM.VENDOR', 'left');
		//$this->db->where('MON_PO_TRANS_HEADER.NO_PO NOT IN (SELECT "NO_PO" FROM MON_PO_TRANS_M_T)', NULL, FALSE);
		$this -> db -> where("MON_PO_TRANS_HEADER.NO_PO", $NO_PO, TRUE);
		$this -> db -> where("VENDOR_NO", $VENDOR_NO, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getTranslistSAP($COMPANY)
	{
		$this -> db -> from($this->tableItemSap);
		$this->db->where('MON_PO_TRANS_HEADER_SAP.NO_PO NOT IN (SELECT "NO_PO" FROM MON_PO_TRANS_ITEM)', NULL, FALSE);
		$this -> db -> join('MON_PO_TRANS_HEADER_SAP', 'MON_PO_TRANS_HEADER_SAP.NO_PO = MON_PO_TRANS_ITEM_SAP.NO_PO', 'left');
		
		$this -> db -> where("COMPANY", $COMPANY, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getTranslist($ID_USER)
	{
		$this->db->from($this->tableItem);
		$this->db->join('MON_PO_TRANS_HEADER', 'MON_PO_TRANS_HEADER.NO_PO = MON_PO_TRANS_ITEM.NO_PO', 'left');
		
		$this -> db -> where("ID_USER", $ID_USER, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getDetailPo($NO_PO)
	{
		$this->db->from($this->tableM_T);
		$this -> db -> where("NO_PO", $NO_PO, TRUE);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function getDetailDocShip($NO_PO)
	{
		$this->db->from($this->tableDocShip);
		$this -> db -> where("NO_PO", $NO_PO, TRUE);
		$query = $this->db->get();
		return $query->row_array();
		// return (array)$query -> result_array();
	}

	public function getlistDocShip($NO_PO)
	{
		$this->db->from($this->tableDocShip);
		$this -> db -> where("NO_PO", $NO_PO, TRUE);
		$this -> db -> where("DEL_FLAG", NULL, TRUE);
		$query = $this->db->get();
		// return $query->row_array();
		return (array)$query -> result_array();
	}

	public function getDetailDocShip3($ID)
	{
		$this->db->from($this->tableDocShip);
		$this -> db -> where("ID", $ID, TRUE);
		$query = $this->db->get();
		return $query->row_array();
		// return (array)$query -> result_array();
	}

	public function getListCustom($NO_PO)
	{
		$this->db->from($this->tableCustom);
		$this -> db -> where("NO_PO", $NO_PO, TRUE);
		$this -> db -> where("DEL_FLAG", NULL, TRUE);
		$query = $this->db->get();
		// return $query->row_array();
		return (array)$query -> result_array();
	}

	public function getDetailCustom($ID)
	{
		$this->db->from($this->tableCustom);
		$this -> db -> where("ID", $ID, TRUE);
		$query = $this->db->get();
		return $query->row_array();
		// return (array)$query -> result_array();
	}

	public function getDetailVenCus($NO_PO)
	{
		$this->db->from($this->tableVenCus);
		$this -> db -> where("NO_PO", $NO_PO, TRUE);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function getListVenBiaya($NO_PO)
	{
		$this->db->from($this->tableVenBiaya);
		$this -> db -> where("NO_PO", $NO_PO, TRUE);
		$this -> db -> where("DEL_FLAG", NULL, TRUE);
		$query = $this->db->get();
		return (array)$query -> result_array();
	}

	public function getDetailVenBiaya($ID)
	{
		$this->db->from($this->tableVenBiaya);
		$this -> db -> where("ID", $ID, TRUE);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function checkPOSAP($NO_PO) {
		$this->db->from($this->tableItemSap);
		$this -> db -> where("NO_PO", $NO_PO, TRUE);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function checkPOHeaderSAP($NO_PO) {
		$this->db->from($this->tableHeaderSap);
		$this -> db -> where("NO_PO", $NO_PO, TRUE);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function checkPO($NO_PO) {
		$this->db->from($this->tableItem);
		$this -> db -> where("NO_PO", $NO_PO, TRUE);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function updatePO($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableItemSap, $set);
	}

	public function updateVenCus($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableVenCus, $set);
	}

	public function updateVenCus2($data) {
		$this -> db -> set('TGL_MAN', "TO_DATE('" . $data['TGL_MAN'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_TA', "TO_DATE('" . $data['TGL_TA'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL', "TO_DATE('" . $data['TGL'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_SPPB', "TO_DATE('" . $data['TGL_SPPB'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_PIB', "TO_DATE('" . $data['TGL_PIB'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_DO', "TO_DATE('" . $data['TGL_DO'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> where('NO_PO', $data['NO_PO']);
		$this -> db -> update('MON_PO_TRANS_VEN_CUS');
	}

	public function updateVenBiaya($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableVenBiaya, $set);
	}

	public function updatePO2($data) {
		$this -> db -> set('DELIVERY_DATE', "TO_DATE('" . $data['DELIVERY_DATE'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_RELEASE', "TO_DATE('" . $data['TGL_RELEASE'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_AMEND', "TO_DATE('" . $data['TGL_AMEND'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_NEGO', "TO_DATE('" . $data['TGL_NEGO'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('AKHIR_NEGO', "TO_DATE('" . $data['AKHIR_NEGO'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> where('NO_PO', $data['NO_PO']);
		$this -> db -> update('MON_PO_TRANS_M_T');
	}

	public function updateDetailPO($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableM_T, $set);
	}

	public function updateDocShip($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableDocShip, $set);
	}

	public function updateDocBiaya($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableVenBiaya, $set);
	}

	public function updateDocShip2($data) {
		$this -> db -> set('TGL_ETA', "TO_DATE('" . $data['TGL_ETA'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_BL', "TO_DATE('" . $data['TGL_BL'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> where('NO_PO', $data['NO_PO']);
		$this -> db -> update('MON_PO_TRANS_DOC_SHIP');
	}

	public function updateDocShip3($data) {
		$this -> db -> set('TGL_ETA', "TO_DATE('" . $data['TGL_ETA'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_BL', "TO_DATE('" . $data['TGL_BL'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> where('ID', $data['ID']);
		$this -> db -> update('MON_PO_TRANS_DOC_SHIP');
	}

	public function updateCustom($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableCustom, $set);
	}

	public function updateCustom2($data) {
		$this -> db -> set('TGL_BAYAR', "TO_DATE('" . $data['TGL_BAYAR'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_BERLAKU', "TO_DATE('" . $data['TGL_BERLAKU'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_SPTNP', "TO_DATE('" . $data['TGL_SPTNP'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_MANIFEST', "TO_DATE('" . $data['TGL_MANIFEST'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_TA', "TO_DATE('" . $data['TGL_TA'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_BERLAKU_LS', "TO_DATE('" . $data['TGL_BERLAKU_LS'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_SPPB', "TO_DATE('" . $data['TGL_SPPB'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_CERT', "TO_DATE('" . $data['TGL_CERT'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_PIB', "TO_DATE('" . $data['TGL_PIB'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('TGL_DO', "TO_DATE('" . $data['TGL_DO'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> where('ID', $data['ID']);
		$this -> db -> update('MON_PO_TRANS_CUSTOM');
	}

	public function resetPesertaSelected($data = '', $id_user) {
		$SQL = '
		DELETE from "EC_AUCTION_ITEMIZE_PRICE" 
		where ID_USER=\'' . $data . '\'
		AND ID_PESERTA =\'' . $id_user . '\'
		AND ID_HEADER is null
		';
		$this -> db -> query($SQL);
	}

	public function resetBatch($data = '') {
		$SQL = '
		DELETE from "EC_AUCTION_ITEMIZE_BATCH" where ID_USER=\'' . $data . '\'
		AND ID_HEADER is null
		';
		$this -> db -> query($SQL);
		
	}

	public function addItemSap($data) {
		$this -> db -> insert($this->tableItemSap, $data);
	}

	public function addItemSapHeader($data) {
		$this -> db -> insert($this->tableHeaderSap, $data);
	}

	public function saveSelected($no_po) {
		$SQL = 'INSERT INTO MON_PO_TRANS_ITEM
		SELECT *
		FROM "MON_PO_TRANS_ITEM_SAP"
		where NO_PO=\'' . $no_po . '\'';
		$this -> db -> query($SQL);

		$SQL = 'INSERT INTO MON_PO_TRANS_HEADER
		SELECT *
		FROM "MON_PO_TRANS_HEADER_SAP"
		where NO_PO=\'' . $no_po . '\'';
		$this -> db -> query($SQL);
	}

	public function getMasterPOTrans() {
		$this->db->from($this->tableM_T);
		$this->db->order_by('ID', 'DESC');
		$query = $this->db->get();
		return $query->row_array();
	}

	public function getMasterDocShip() {
		$this->db->from($this->tableDocShip);
		$this->db->order_by('ID', 'DESC');
		$query = $this->db->get();
		return $query->row_array();
	}

	public function getMasterCustom() {
		$this->db->from($this->tableCustom);
		$this->db->order_by('ID', 'DESC');
		$query = $this->db->get();
		return $query->row_array();
	}

	public function getMasterBiaya() {
		$this->db->from($this->tableVenBiaya);
		$this->db->order_by('ID', 'DESC');
		$query = $this->db->get();
		return $query->row_array();
	}


	public function beforeSave($ID_USER) {
		$this->db->from($this->tableItem);
		$this->db->join('MON_PO_TRANS_HEADER', 'MON_PO_TRANS_HEADER.NO_PO = MON_PO_TRANS_ITEM.NO_PO', 'left');
		$this->db->where('MON_PO_TRANS_HEADER.NO_PO NOT IN (SELECT "NO_PO" FROM MON_PO_TRANS_M_T)', NULL, FALSE);
		$this -> db -> where("ID_USER", $ID_USER, TRUE);

		$result = $this->db->get();
		return (array)$result -> result_array();
	}

	public function save($data) {
		$this -> db -> insert($this->tableM_T, $data);
	}

	public function saveDocShip($data) {
		$this -> db -> insert($this->tableDocShip, $data);
	}

	public function saveVenCus($data) {
		$this -> db -> insert($this->tableVenCus, $data);
	}

	public function saveVenBiaya($data) {
		$this -> db -> insert($this->tableVenBiaya, $data);
	}

	public function saveCustom($data) {
		$this -> db -> insert($this->tableCustom, $data);
	}


}

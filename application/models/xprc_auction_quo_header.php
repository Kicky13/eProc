<?php
class xprc_auction_quo_header extends CI_Model
{
	var $table = "PRC_AUCTION_QUO_HEADER";
	var $get_id_query = 'select max(PAQH_ID) as id from PRC_AUCTION_QUO_HEADER';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get_id()
	{
		// $sql = 'select max(PPD_ID) as id from PRC_PLAN_DOC';
		$result = $this->db->query($this->get_id_query);
		$id = $result->row_array();
		return $id['ID'] + 1;
		
	}

	function insert($data) {
		if($this->db->insert($this->table, $data)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function find($paqh_id)
	{
		$return = $this->get(array('PRC_AUCTION_QUO_HEADER.PAQH_ID' => $paqh_id));
		if (empty($return)) {
			return null;
		}
		return $return[0];
	}

	function join_detail(){
		$this->db->join('PRC_AUCTION_DETAIL', 'PRC_AUCTION_QUO_HEADER.PAQH_ID = PRC_AUCTION_DETAIL.PAQH_ID', 'inner');
	}

	function join_ptm(){
		$this->db->join('PRC_TENDER_MAIN', 'PRC_AUCTION_QUO_HEADER.PTM_NUMBER = PRC_TENDER_MAIN.PTM_NUMBER', 'inner');
		$this->db->select('PTM_PRATENDER');
	}

	function where_vendor($ptv) {
		$this->join_detail();
		$this->join_ptm();
		$this->db->where(array('PTV_VENDOR_CODE' => $ptv));
	}

	function where_breakdown($breakdown = 0) {
		$this->db->where(array('IS_BREAKDOWN' => $breakdown));
	}

	public function id($id) {
		return $this->get(array("$this->table.PAQH_ID" => $id));
	}

	function list_auction($status){
		$this->db->select("$this->table.*, PRC_TENDER_MAIN.*");
		$this->db->from($this->table);
		$this->db->join('PRC_TENDER_MAIN', "$this->table.PTM_NUMBER = PRC_TENDER_MAIN.PTM_NUMBER", 'left');
		$this->db->where('IS_EVALUATED IS NOT NULL');

		$query = $this->db->get();
		$result = $query->result_array();
		$data = array();

		foreach ($result as $key => $row)
		{
			$PTM_NUMBER = $row['PTM_NUMBER'];
			$PAQH_ID = $row['PAQH_ID'];
			$sql = "SELECT COUNT(PRC_TENDER_ITEM.TIT_ID) as jumlah FROM PRC_TENDER_ITEM WHERE PRC_TENDER_ITEM.TIT_STATUS = '4' AND PRC_TENDER_ITEM.PAQH_ID = ? AND PRC_TENDER_ITEM.PTM_NUMBER = ?"; 
			$query = $this->db->query($sql, array($PAQH_ID, $PTM_NUMBER));
			$count = $query->row_array();
			if($count["JUMLAH"] > 0){
				$data[] = $row;
			}
		}

		$datetimestamp = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
		$now = date_format($datetimestamp, 'd-m-Y H.i.s');				
		$output = array();
		
		foreach ($data as $key => $row)
		{
			if($status == 'all'){
				$output[] = $data[$key];
			}			
			// if($status == 'proses'){
			if($status == 'proses' && strtotime($now) < oraclestrtotime($row['PAQH_AUC_END'])){
					$output[] = $data[$key];
				// }												
			} else if($status == 'tutup' && strtotime($now) > oraclestrtotime($row['PAQH_AUC_END'])){
				// if(($row['PAQH_OPEN_STATUS'] == 1 || $row['PAQH_OPEN_STATUS'] == 2) && strtotime($now) > oraclestrtotime($row['PAQH_AUC_END'])){
				$output[] = $data[$key];
			} 
		}
		return $output;
	}

	function get($where=NULL)
	{
		$this->db->select('PRC_AUCTION_QUO_HEADER.PAQH_ID, PRC_AUCTION_QUO_HEADER.PTM_NUMBER, PAQH_DECREMENT_VALUE, PAQH_PRICE_TYPE, PAQH_HPS, TO_CHAR(PAQH_AUC_START, \'DD-MON-YY HH24.MI.SS\') AS PAQH_AUC_START, TO_CHAR(PAQH_AUC_END, \'DD-MON-YY HH24.MI.SS\') AS PAQH_AUC_END, PAQH_LOCATION, PAQH_OPEN_STATUS, PAQH_SUBJECT_OF_WORK, VENDOR_WINNER,IS_BREAKDOWN, BREAKDOWN_TYPE', false);
		if (!empty($where)) {
			$this->db->where($where);
		}
		$result = $this->db->get($this->table);
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return null;
		}
	}

	function update($set, $where)
	{
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function delete($where) {
		return $this->db->delete($this->table, $where);
	}
	
}
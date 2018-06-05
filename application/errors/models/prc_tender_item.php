<?php
class prc_tender_item extends CI_Model {

	protected $table = 'PRC_TENDER_ITEM';
	protected $join_item_status = false;

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->join_item_status = false;
	}

	public function get($where=NULL, $joinitem = true, $is_jasa = false) {
		$this->db->distinct();
		$this->db->select('PRC_TENDER_ITEM.*');
		if (!empty($where)) {
			$this->db->where($where);
		}
		if ($joinitem) {
			$this->join_item($is_jasa);
		}
		$this->db->from($this->table);
		// $this->db->order_by('PRC_TENDER_ITEM.TIT_ID', 'ASC');
		$result = $this->db->get();
		$this->join_item_status = false;
		// var_dump($this->db->last_query()); die();
		$retval = $result->result_array();
		usort($retval, array($this, 'sort_item'));
		return $retval;
	}

	private function sort_item($a, $b)
	{
		$itema = substr($a['PPI_ID'], 10);
		$itemb = substr($b['PPI_ID'], 10);

		$pra = substr($a['PPI_ID'], 0, 10);
		$prb = substr($b['PPI_ID'], 0, 10);

		if ($pra == $prb) {
			return intval($itema) > intval($itemb);
		} else {
			return $pra > $prb;
		}
	}

	public function where_status($status) {
		$this->db->where(array('TIT_STATUS' => $status));
	}

	public function where_titid($id) {
		$this->db->where(array('TIT_ID' => $id));
	}

	public function where_status_in($status = null) {
		if ($status == null) {
			$status = array(16, 48, 96, 112);
		}
		$this->db->where_in('TIT_STATUS', $status);
	}

	public function where_status_not($status) {
		$this->db->where_not_in('TIT_STATUS', $status);
	}


	public function where_in($kolom,$value){
		$this->db->where_in($kolom,$value);
	}

	public function get_tit_status() {
		return array(
				0 => "Belum Nego", // Normal
				1 => "Sedang Nego Biasa", // Tahap_Negosiasi				
				2 => "Sedang Nego Biasa",
				3 => "Sedang Nego Auction", // Tahap_Negosiasi
				4 => "Sedang Nego Auction", // Auction
				5 => "Sudah Nego", // Auction
				6 => "Ditunjuk Pemenang", // Tahap_Negosiasi
				7 => "Analisa Kewajaran Harga", // Tahap_Negosiasi
				8 => "Sudah Ditunjuk Pemenang", // Penunjukan_pemenang
				9 => "Lembar Persetujuan Penunjukan Pemenang (LP3)", 
				10 => "PO Release",
				16 => "Diusulkan Nego Biasa", // tahap negosiasi dikali 16
				48 => "Diusulkan Nego Auction", // tahap negosiasi dikali 16
				96 => "Diusulkan Penunjukan Pemenang", // tahap negosiasi dikali 16
				112 => "Diusulkan Analisa Kewajaran Harga", // tahap negosiasi dikali 16
				999 => "Tender Dibatalkan",// item tender dibatalkan
			);
	}

	public function join_pqi($ptv) {
		$this->db->select('PRC_TENDER_QUO_ITEM.*');
		$this->db->select('PRC_TENDER_QUO_MAIN.*');
		$this->db->join('PRC_TENDER_QUO_ITEM', 'PRC_TENDER_QUO_ITEM.TIT_ID = PRC_TENDER_ITEM.TIT_ID', 'left');
		$this->db->join('PRC_TENDER_QUO_MAIN', 'PRC_TENDER_QUO_MAIN.PQM_ID = PRC_TENDER_QUO_ITEM.PQM_ID', 'left');
		$this->db->where(array('PRC_TENDER_QUO_MAIN.PTV_VENDOR_CODE' => $ptv));
	}

	public function join_item($is_jasa = false) {
		if ($this->join_item_status == false) {
		// 	if (!$is_jasa) {
				$this->db->select('PRC_PR_ITEM.*');
				$this->db->join('PRC_PR_ITEM', 'PRC_PR_ITEM.PPI_ID = PRC_TENDER_ITEM.PPI_ID', 'left');
			// } else {
			// 	/* field yang di jasa sama kayak di pr item */
			// 	$fieldsama = array(
			// 			'PRC_PR_ITEM.PPI_PRNO',
			// 			'PRC_PR_ITEM.PPI_QUANTOPEN',
			// 			'PRC_PR_ITEM.PPI_POQUANTITY',
			// 			'PRC_PR_ITEM.PPI_PRQUANTITY',
			// 			'PRC_PR_ITEM.PPI_HANDQUANTITY',
			// 			'PRC_PR_ITEM.PPI_RATAGI',
			// 			'PRC_PR_ITEM.PPI_MAXGI',
			// 			'PRC_PR_ITEM.PPI_LASTGI',
			// 			'PRC_PR_ITEM.PPI_REALDATE',
			// 			'PRC_PR_ITEM.PPI_POSTDATE',
			// 			'PRC_PR_ITEM.PPI_MAX_GI_YEAR',
			// 			'PRC_PR_ITEM.PPI_MAX_YEAR_GI',
			// 			'PRC_PR_ITEM.PPI_PER',
			// 			'PRC_PR_ITEM.PPI_CURR',
			// 			'PRC_PR_ITEM.PPI_IS_CONTRACT',
			// 			'PRC_PR_ITEM.PPI_QTY_USED',
			// 			'PRC_PR_ITEM.PPI_IS_CLOSED',
			// 			'PRC_PR_ITEM.PPI_PLANT',
			// 			'PRC_PR_ITEM.PPI_DDATE',
			// 			'PRC_PR_ITEM.PPI_MRPC',
			// 			'PRC_PR_ITEM.COUNT_TENDER',
			// 			'PRC_PR_ITEM.PPI_ID AS PPI_ID_ORI',
			// 		);
			// 	$this->db->select(implode(', ', $fieldsama));
			// 	/* field yang di jasa beda fieldnya sama di pr item */
			// 	$fieldbeda = array(
			// 			'PPI_ID'		=> 'SERVICE_ID',
			// 			'PPI_PRITEM'	=> 'EXTROW',
			// 			'PPI_NOMAT'		=> 'SRVPOS',
			// 			'PPI_DECMAT'	=> 'KTEXT1',
			// 			'PPI_UOM'		=> 'MEINS',
			// 			'PPI_NETPRICE'	=> 'TBTWR',
			// 			'PPI_MATGROUP'	=> 'MATKL',
			// 			'PPI_PACKNO'	=> 'PACKNO',
			// 		);
			// 	foreach ($fieldbeda as $key => $val) {
			// 		$this->db->select('PRC_IT_SERVICE.' . $val . ' AS ' . $key);
			// 	}
			// 	$this->db->join('PRC_IT_SERVICE', 'PRC_IT_SERVICE.SERVICE_ID = PRC_TENDER_ITEM.SERVICE_ID', 'left');
			// 	$this->db->join('PRC_PR_ITEM', 'PRC_PR_ITEM.PPI_PACKNO = PRC_IT_SERVICE.PACKNO', 'left');
			// }
			$this->join_item_status = true;
		}
	}

	public function join_nego_item(){
		$this->db->select('PRC_NEGO_ITEM.*');
		return $this->db->join('PRC_NEGO_ITEM', "PRC_TENDER_ITEM.TIT_ID = PRC_NEGO_ITEM.TIT_ID", 'left');
	}

	public function join_pr($is_jasa = false) {
		$this->join_item($is_jasa);
		$this->db->select('PRC_PURCHASE_REQUISITION.*');
		$this->db->join('PRC_PURCHASE_REQUISITION', 'PRC_PR_ITEM.PPI_PRNO = PRC_PURCHASE_REQUISITION.PPR_PRNO', 'left');
	}

	public function ptm($ptm, $is_jasa = false) {
		return $this->get(array('PRC_TENDER_ITEM.PTM_NUMBER' => $ptm), true, $is_jasa);
	}

	public function ptm_paqh($ptm, $paqh, $is_jasa = false) {
		return $this->get(array('PRC_TENDER_ITEM.PTM_NUMBER' => $ptm, 'PRC_TENDER_ITEM.PAQH_ID' => $paqh), true, $is_jasa);
	}

	public function ptm_auction($ptm, $is_jasa = false) {
		return $this->get(array('PRC_TENDER_ITEM.PTM_NUMBER' => $ptm, 'PRC_TENDER_ITEM.TIT_STATUS' => 3), true, $is_jasa);
	}

	public function get_id() {
		$this->db->select_max('TIT_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function insert_batch($data) {
		$this->db->insert_batch($this->table, $data);
	}

	public function update($set=NULl, $where=NULL) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function deleteByPtm($ptm) {
		return $this->delete(array('PTM_NUMBER' => $ptm));
	}

	public function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}

	public function get_last_query() {
		echo $this->db->last_query();
		exit();
	}

	public function join_ptm(){
		$this->db->select('PRC_TENDER_MAIN.*');
		return $this->db->join('PRC_TENDER_MAIN', 'PRC_TENDER_MAIN.PTM_NUMBER = PRC_TENDER_ITEM.PTM_NUMBER', 'inner');
	}

	public function join_ece_change(){
		$this->db->select('PRC_ECE_CHANGE.STATUS_APPROVAL');
		$where = "(PRC_ECE_CHANGE.STATUS_APPROVAL IS NULL OR PRC_ECE_CHANGE.STATUS_APPROVAL='2')";
		$this->db->where($where);
		return $this->db->join('PRC_ECE_CHANGE', "PRC_TENDER_ITEM.TIT_ID = PRC_ECE_CHANGE.TIT_ID", 'left');
	}

}
<?php
class prc_tender_quo_item extends CI_Model {

	protected $table = 'PRC_TENDER_QUO_ITEM';

	/**
	 * detail PQI_IS_WINNER :
	 *    null => blom lolos evaluasi (atau tidak lolos)
	 *       1 => lolos evaluasi. masuk tahap negosiasi
	 *      -1 => tidak lolos auction
	 *      -2 => mengundurkan diri di negosiasi
	 */

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get_fresh($where = null) {
		$this->db->select('PRC_TENDER_QUO_ITEM.*');
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		// var_dump($this->db->last_query());
		return $result->result_array();
	}

	function get_retender($where = null) {
		$this->db->select('PQI_ID,PQM_ID,TIT_ID,PQI_DESCRIPTION,
			PQI_PRICE,PQI_CURRENCY,PQI_DELIVERY_DATE,PQI_IS_WINNER,
			PQI_TYPE,PQI_TECH_VAL,PQI_PRICE_VAL,PQI_E_VAL,PQI_FINAL_PRICE,DAPAT_UNDANGAN');
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		// var_dump($this->db->last_query());
		return $result->result_array();
	}

	function get($where=NULL, $is_jasa = false) {
		$this->join_item($is_jasa);
		return $this->get_fresh($where);
	}

	public function join_item($is_jasa = false) {
		$this->db->select('PRC_TENDER_ITEM.*');
		$this->db->join('PRC_TENDER_ITEM', 'PRC_TENDER_QUO_ITEM.TIT_ID = PRC_TENDER_ITEM.TIT_ID', 'left');

		if ($is_jasa) {
			/* field yang di jasa sama kayak di pr item */
			$fieldsama = array(
				'PRC_PR_ITEM.PPI_PRNO',
				'PRC_PR_ITEM.PPI_QUANTOPEN',
				'PRC_PR_ITEM.PPI_POQUANTITY',
				'PRC_PR_ITEM.PPI_PRQUANTITY',
				'PRC_PR_ITEM.PPI_HANDQUANTITY',
				'PRC_PR_ITEM.PPI_RATAGI',
				'PRC_PR_ITEM.PPI_MAXGI',
				'PRC_PR_ITEM.PPI_LASTGI',
				'PRC_PR_ITEM.PPI_REALDATE',
				'PRC_PR_ITEM.PPI_POSTDATE',
				'PRC_PR_ITEM.PPI_MAX_GI_YEAR',
				'PRC_PR_ITEM.PPI_MAX_YEAR_GI',
				'PRC_PR_ITEM.PPI_PER',
				'PRC_PR_ITEM.PPI_CURR',
				'PRC_PR_ITEM.PPI_IS_CONTRACT',
				'PRC_PR_ITEM.PPI_QTY_USED',
				'PRC_PR_ITEM.PPI_IS_CLOSED',
				'PRC_PR_ITEM.PPI_PLANT',
				'PRC_PR_ITEM.PPI_DDATE',
				'PRC_PR_ITEM.PPI_MRPC',
				'PRC_PR_ITEM.COUNT_TENDER',
				'PRC_PR_ITEM.PPI_ID AS PPI_ID_ORI',
				);
			$this->db->select(implode(', ', $fieldsama));
			/* field yang di jasa beda fieldnya sama di pr item */
			$fieldbeda = array(
				'PPI_ID'		=> 'SERVICE_ID',
				'PPI_PRITEM'	=> 'EXTROW',
				'PPI_NOMAT'		=> 'SRVPOS',
				'PPI_DECMAT'	=> 'KTEXT1',
				'PPI_UOM'		=> 'MEINS',
				'PPI_NETPRICE'	=> 'TBTWR',
				'PPI_MATGROUP'	=> 'MATKL',
				'PPI_PACKNO'	=> 'PACKNO',
				);
			foreach ($fieldbeda as $key => $val) {
				$this->db->select('PRC_IT_SERVICE.' . $val . ' AS ' . $key);
			}
			$this->db->join('PRC_IT_SERVICE', 'PRC_IT_SERVICE.SERVICE_ID = PRC_TENDER_ITEM.SERVICE_ID', 'left');
			$this->db->join('PRC_PR_ITEM', 'PRC_PR_ITEM.PPI_PACKNO = PRC_IT_SERVICE.PACKNO', 'left');
		} else {	
			$this->db->select('PRC_PR_ITEM.*');
			$this->db->join('PRC_PR_ITEM', 'PRC_PR_ITEM.PPI_ID = PRC_TENDER_ITEM.PPI_ID', 'left');
		}

		$this->db->select('PRC_PURCHASE_REQUISITION.*');
		$this->db->join('PRC_PURCHASE_REQUISITION', 'PRC_PURCHASE_REQUISITION.PPR_PRNO = PRC_PR_ITEM.PPI_PRNO', 'left');
	}

	function get_by_pqm($pqm_id, $is_jasa = false) {
		return $this->get(array('PRC_TENDER_QUO_ITEM.PQM_ID' => $pqm_id), $is_jasa);
	}

	function join_pqm() {
		$this->db->select('PRC_TENDER_QUO_MAIN.*');
		$this->db->join('PRC_TENDER_QUO_MAIN', 'PRC_TENDER_QUO_MAIN.PQM_ID = PRC_TENDER_QUO_ITEM.PQM_ID', 'left');
	}

	public function where_tit($tit) {
		$this->db->where(array('PRC_TENDER_QUO_ITEM.TIT_ID' => $tit));
	}

	public function where_tit_status($tit_status) {
		$this->db->where(array('PRC_TENDER_ITEM.TIT_STATUS' => $tit_status));
	}

	public function where_win($win = 1) {
		$this->db->where(array('PRC_TENDER_QUO_ITEM.PQI_IS_WINNER' => $win));
	}

	public function where_in($kolom,$value){
		$this->db->where_in($kolom,$value);
	}

	function ptm_ptv($ptm, $ptv, $is_jasa = false) {
		$this->join_pqm();
		return $this->get(array('PRC_TENDER_QUO_MAIN.PTM_NUMBER' => $ptm, 'PRC_TENDER_QUO_MAIN.PTV_VENDOR_CODE' => $ptv), $is_jasa);
	}

	function ptm_ptv_paqh($ptm, $ptv, $paqh, $is_jasa = false) {
		$this->join_pqm();
		return $this->get(array('PRC_TENDER_QUO_MAIN.PTM_NUMBER' => $ptm, 'PRC_TENDER_QUO_MAIN.PTV_VENDOR_CODE' => $ptv,'PRC_TENDER_ITEM.PAQH_ID' => $paqh), $is_jasa);
	}

	function get_ptm($ptm, $vnd, $is_jasa = false){
		$this->join_pqm();
		return $this->get(array('PRC_TENDER_QUO_MAIN.PTM_NUMBER' => $ptm, 'PRC_TENDER_QUO_MAIN.PTV_VENDOR_CODE' => $vnd), $is_jasa);
	}

	function get_by_ptm($ptm, $is_jasa = false){
		//$this->join_pqm();
		return $this->get(array('PRC_TENDER_QUO_MAIN.PTM_NUMBER' => $ptm), $is_jasa);
	}

	function get_id()
	{
		$this->db->select_max('PQI_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	function update($set=NULl, $where=NULL)
	{
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}

	function getHargaTerendah($id){
		// $this->db->select("*");
		$this->db->select_min('PQI_PRICE');
		$this->db->from($this->table);
		$this->db->where('TIT_ID = '.$id, null, false);
		// $this->db->where_in($kolom,$value);

		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
		else {
			return NULL;
		}
	}

}
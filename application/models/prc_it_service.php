<?php defined('BASEPATH') OR exit('No direct script access allowed');

class prc_it_service extends CI_Model {

	protected $table = 'PRC_IT_SERVICE';
	protected $staging = 'PRC_IT_SERVICE_SYNC';

	/**
	 * Fields:
	 * 	 PR_ITEM 			IT_SERVICE
	 * ------------------------------------
	 * 	 PPI_ID				: SERVICE_ID
	 * 	 PPI_PRNO			: 
	 * 	 PPI_PRITEM			: EXTROW
	 * 	 PPI_NOMAT			: SRVPOS
	 * 	 PPI_DECMAT			: KTEXT1
	 * 	 PPI_QUANTOPEN		: 
	 * 	 PPI_POQUANTITY		: 
	 * 	 PPI_PRQUANTITY		: 
	 * 	 PPI_HANDQUANTITY	: 
	 * 	 PPI_RATAGI			: 
	 * 	 PPI_MAXGI			: 
	 * 	 PPI_LASTGI			: 
	 * 	 PPI_UOM			: MEINS
	 * 	 PPI_REALDATE		: 
	 * 	 PPI_POSTDATE		: 
	 * 	 PPI_MAX_GI_YEAR	: 
	 * 	 PPI_MAX_YEAR_GI	: 
	 * 	 PPI_NETPRICE		: TBTWR
	 * 	 PPI_PER			: 
	 * 	 PPI_CURR			: 
	 * 	 PPI_MATGROUP		: MATKL
	 * 	 PPI_IS_CONTRACT	: 
	 * 	 PPI_QTY_USED		: 
	 * 	 PPI_IS_CLOSED		: 
	 * 	 PPI_PLANT			: 
	 * 	 PPI_DDATE			: 
	 * 	 PPI_MRPC			: 
	 * 	 PPI_PACKNO			: PACKNO
	 * 	 COUNT_TENDER		: 
	 *
	 * 		MENGE : PPI_PRQUANTITY - PPI_QUANTOPEN
	 * 		BRTWR : PPI_NETPRICE * (PPI_PRQUANTITY - PPI_QUANTOPEN)
	 * 		NETWR : PPI_NETPRICE * (PPI_PRQUANTITY - PPI_QUANTOPEN)
	 */

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		return (array)$result->result_array();
	}

	public function join_pr() {
		$this->db->join('PRC_PR_ITEM', 'PRC_PR_ITEM.PPI_PACKNO = PRC_IT_SERVICE.PACKNO', 'left');
	}

	public function ppi($ppi) {
		$this->join_pr();
		return $this->get(array('PRC_PR_ITEM.PPI_ID' => $ppi));
	}

	public function pr($pr) {
		$this->join_pr();
		return $this->get(array('PRC_PR_ITEM.PPI_PRNO' => $pr));
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function insert_batch($data) {
		$this->db->insert_batch($this->table, $data);
	}

	public function insert_staging($data) {
		$this->db->empty_table($this->staging);
		$this->db->insert_batch($this->staging, $data);
	}

	public function update($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}

}
<?php
class prc_tender_quo_main extends CI_Model
{
	protected $table = "PRC_TENDER_QUO_MAIN";

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=NULL)
	{
		$this->db->select('*');
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		return $result->result_array();
	}

	function ptmptv($ptm, $ptv) {
		return $this->get(array('PTM_NUMBER' => $ptm, 'PTV_VENDOR_CODE' => $ptv));
	}

	function ptm($ptm) {
		return $this->get(array('PTM_NUMBER' => $ptm));
	}

	function join_eval() {
		$where = 'PRC_TENDER_QUO_MAIN.PTV_VENDOR_CODE = PRC_TENDER_EVAL.PTV_VENDOR_CODE AND ';
		$where .= '"PRC_TENDER_QUO_MAIN"."PTM_NUMBER" = "PRC_TENDER_EVAL"."PTM_NUMBER"';
		$this->db->join('PRC_TENDER_EVAL', $where, 'left');
	}

	function join_item() {
		$this->db->join('PRC_TENDER_QUO_ITEM', 'PRC_TENDER_QUO_MAIN.PQM_ID = PRC_TENDER_QUO_ITEM.PQM_ID', 'left');
		$this->db->join('VND_HEADER', 'PRC_TENDER_QUO_MAIN.PTV_VENDOR_CODE = VND_HEADER.VENDOR_NO', 'left');
	}

	function join_eval_template() {
		$this->db->join('PRC_TENDER_PREP', 'PRC_TENDER_QUO_MAIN.PTM_NUMBER = PRC_TENDER_PREP.PTM_NUMBER', 'left');
		$this->db->join('PRC_EVALUATION_TEMPLATE', 'PRC_TENDER_PREP.EVT_ID = PRC_EVALUATION_TEMPLATE.EVT_ID', 'left');
	}

	function join_pqe() {
		$where = 'PRC_TENDER_QUO_MAIN.PTV_VENDOR_CODE = PRC_PREQ_EVAL.PTV_VENDOR_CODE AND ';
		$where .= '"PRC_TENDER_QUO_MAIN"."PTM_NUMBER" = "PRC_PREQ_EVAL"."PTM_NUMBER"';
		$this->db->join('PRC_PREQ_EVAL', $where, 'left');
	}

	function get_join($where=NULL)
	{
		$this->join_eval_template();
		$this->db->join('VND_HEADER', 'PRC_TENDER_QUO_MAIN.PTV_VENDOR_CODE = VND_HEADER.VENDOR_NO', 'left');
		return $this->get($where);
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

	function get_id()
	{
		$this->db->select_max('PQM_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}

	function join_quo_item() {
		$this->db->where('PRC_TENDER_QUO_ITEM.DAPAT_UNDANGAN = 1 ');
		$this->db->join('PRC_TENDER_QUO_ITEM', 'PRC_TENDER_QUO_MAIN.PQM_ID = PRC_TENDER_QUO_ITEM.PQM_ID', 'inner');
	}

	function join_vnd_header(){
		$this->db->join('VND_HEADER', 'VND_HEADER.VENDOR_NO = PRC_TENDER_QUO_MAIN.PTV_VENDOR_CODE', 'inner');
	}

}

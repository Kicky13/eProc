<?php
class prc_preq_template_uraian extends CI_Model {

	protected $table = "PRC_PREQ_TEMPLATE_URAIAN";	

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=null)
	{
		$this->db->select("PPTU_ID, $this->table.PPD_ID, PPTU_ITEM, PPTU_WEIGHT, PPTU_TYPE");
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return null;
		}
	}

	public function join_ppd()
	{
		$this->db->select('PRC_PREQ_TEMPLATE_DETAIL.PPT_ID, PPD_ITEM, PPD_WEIGHT, PPD_MODE');
		$this->db->join('PRC_PREQ_TEMPLATE_DETAIL', 'PRC_PREQ_TEMPLATE_DETAIL.PPD_ID = PRC_PREQ_TEMPLATE_URAIAN.PPD_ID', 'left');
		
		/*
		$ptp = $this->prc_tender_prep->ptm($id);
		$this->prc_preq_template_uraian->join_ppd();
		$pptu = $this->prc_preq_template_uraian->get(array('PPT_ID' => $ptp['EVT_ID']));
		*/
	}

	function get_id()
	{
		$this->db->select_max('PPTU_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function insert($data) {
		return $this->db->insert($this->table, $data);
	}

	function update($set='',$where='')
	{
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	function join_template($where=NULL)
	{
		$this->db->select("PPTU_ID,PPD_ID,PPTU_ITEM");
		$this->db->select("PPT_ID,PPD_ITEM,PPD_WEIGHT,PPD_MODE");
		$this->db->select("EVT_TYPE,EVT_NAME,EVT_PASSING_GRADE,EVT_TECH_WEIGHT,EVT_PRICE_WEIGHT");
		$this->db->from($this->table);
		$this->db->join("PRC_PREQ_TEMPLATE_DETAIL", "$this->table.PPD_ID = PRC_PREQ_TEMPLATE_DETAIL.PPD_ID", "left");
		$this->db->join("PRC_EVALUATION_TEMPLATE", "PRC_PREQ_TEMPLATE_DETAIL.PPT_ID = PRC_EVALUATION_TEMPLATE.EVT_ID", "left");
		if(!empty($where)){
			$this->db->where($where);
		}
		$result = $this->db->get();
		return $result->result_array();
		
	}
}
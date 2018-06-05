<?php
class prc_preq_template_detail extends CI_Model
{
	protected $table = "PRC_PREQ_TEMPLATE_DETAIL";

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=NULL, $select = 'PRC_PREQ_TEMPLATE_DETAIL.*')
	{
		$this->db->select($select);
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		}
	}

	function evt($evt_id) {
		return $this->get(array('PPT_ID' => $evt_id));
	}

	public function join_qqt($vendor) {
		$this->db->select('J.*');
		$this->db->join('(SELECT T1.* FROM PRC_PREQ_QUO_TECH T1
			RIGHT JOIN PRC_PREQ_EVAL T2 ON T2.PQE_ID = T1.PQE_ID
			WHERE T2.PTV_VENDOR_CODE = \''.$vendor.'\') J', "$this->table.PPD_ID = J.PPD_ID", 'left');
		// $this->db->join('PRC_PREQ_EVAL', "PRC_PREQ_EVAL.PQE_ID = PRC_PREQ_QUO_TECH.PQE_ID AND PRC_PREQ_EVAL.PTV_VENDOR_CODE = $vendor", 'left');
		// $this->db->where(array('PRC_PREQ_EVAL.PTV_VENDOR_CODE' => $vendor));
	}

	function get_id()
	{
		$this->db->select_max('PPD_ID', 'MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	function insert($data) {
		return $this->db->insert($this->table, $data);
	}

	function update($set='',$where='')
	{
		$update_query = 'update prc_preq_template_detail set ';
		$condition = '';
		if(count($set) > 1)
		{
			$condition = implode(',', $set);
		}
		else
		{
			$condition = $set[0];
		}
		$update_query .= $condition;

		if($where != '')
		{
			$update_query .= ' where '.$where;
		}

		$this->db->query($update_query);
		return;
	}
}
?>

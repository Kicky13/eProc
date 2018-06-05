<?php
class currency_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get_all()
	{
		$sql = "select * from M_ADM_CURRENCY order by CURRENCY_CODE asc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function get_all_distinct()
	{
		$sql = "select distinct CURRENCY_CODE, CURRENCY_NAME from M_ADM_CURRENCY order by CURRENCY_CODE asc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function add($currency_code,$currency_name)
	{
		$this->db->query("insert into M_ADM_CURRENCY (CURRENCY_ID,CURRENCY_CODE,CURRENCY_NAME)values (SEQ_CURRENCY.nextval,'".$currency_code."','".$currency_name."')");
	}

	public function edit($currency_id,$currency_code,$currency_name)
	{
		$this->db->query("update M_ADM_CURRENCY set CURRENCY_CODE='".$currency_code."', CURRENCY_NAME='".$currency_name."' where CURRENCY_ID=".$currency_id."");
	}

	public function delete($currency_id)
	{
		$this->db->query("delete from M_ADM_CURRENCY where CURRENCY_ID='$currency_id'");
	}

}
?>

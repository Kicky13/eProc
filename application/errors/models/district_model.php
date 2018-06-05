<?php
class district_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get_all()
	{
		$sql = "select * from M_ADM_DISTRICT order by DISTRICT_CODE asc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function add($district_code,$district_name)
	{
		$this->db->query("insert into M_ADM_DISTRICT(DISTRICT_ID,DISTRICT_CODE,DISTRICT_NAME)values (SEQ_DISTRICT.nextval,'".$district_code."','".$district_name."')");
	}

	public function edit($district_id,$district_code,$district_name)
	{
		$this->db->query("update M_ADM_DISTRICT set DISTRICT_CODE='".$district_code."', DISTRICT_NAME='".$district_name."' where DISTRICT_ID=".$district_id."");
	}

	public function delete($district_id)
	{
		$this->db->query("delete from M_ADM_DISTRICT where DISTRICT_ID='$district_id'");
	}

}
?>

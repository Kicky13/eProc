<?php
class salutation_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get_all()
	{
		$sql = "select * from M_ADM_SALUTATION order by SALUTATION_NAME asc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function add($salutation_name)
	{
		$this->db->query("insert into M_ADM_SALUTATION (SALUTATION_ID,SALUTATION_NAME) values (SEQ_SALUTATION.nextval,'".$salutation_name."')");
		//$query = $this->db->query("select SALUTATION_ID from M_ADM_SALUTATION order by SALUTATION_ID desc");
		//$data = $query->result_array();
		//return $data;
	}

	public function edit($salutation_id,$salutation_name)
	{
		$this->db->query("update M_ADM_SALUTATION set SALUTATION_NAME='".$salutation_name."' where SALUTATION_ID='".$salutation_id."'");
	}

	public function delete($salutation_id)
	{
		$this->db->query("delete from M_ADM_SALUTATION where SALUTATION_ID='$salutation_id'");

	}

}
?>

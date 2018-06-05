<?php
class employee_type_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get_all()
	{
		$sql = "select * from M_ADM_EMPLOYEE_TYPE";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function add($name)
	{
		$this->db->query("insert into M_ADM_EMPLOYEE_TYPE (EMPLOYEE_TYPE_ID,EMPLOYEE_TYPE_NAME)values (SEQ_CURRENCY.nextval,'".$name."')");
	}

	public function edit($id,$name)
	{
		$this->db->query("update M_ADM_EMPLOYEE_TYPE set EMPLOYEE_TYPE_NAME='".$name."'where EMPLOYEE_TYPE_ID=".$id."");
	}

	public function delete($ID)
	{
		$this->db->query("delete from M_ADM_EMPLOYEE_TYPE where EMPLOYEE_TYPE_ID='$ID'");
	}
}
?>

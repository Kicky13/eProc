<?php
class del_point_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get_all()
	{
		$sql = "select * from M_ADM_DEL_POINT order by DEL_POINT_CODE asc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function add($del_point_code,$del_point_name)
	{
		$this->db->query("insert into M_ADM_DEL_POINT (DEL_POINT_ID,DEL_POINT_CODE,DEL_POINT_NAME)values (SEQ_DEL_POINT.nextval,'".$del_point_code."','".$del_point_name."')");
	}

	public function edit($del_point_id,$del_point_code,$del_point_name)
	{
		$this->db->query("update M_ADM_DEL_POINT set DEL_POINT_CODE='".$del_point_code."', del_point_NAME='".$del_point_name."' where DEL_POINT_ID=".$del_point_id."");
	}

	public function delete($ID)
	{
		$this->db->query("delete from M_ADM_DEL_POINT where DEL_POINT_ID='$ID'");
	}

}
?>

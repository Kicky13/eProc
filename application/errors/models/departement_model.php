<?php
class departement_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get_all()
	{
		$sql = "select * from M_ADM_DEPARTEMENT, M_ADM_DISTRICT where M_ADM_DISTRICT.DISTRICT_ID=M_ADM_DEPARTEMENT.DISTRICT_ID order by DEPARTEMENT_CODE asc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function add($departement_code,$departement_name,$district_id)
	{
		$this->db->query("insert into M_ADM_DEPARTEMENT(DEPARTEMENT_ID,DEPARTEMENT_CODE,DEPARTEMENT_NAME,DISTRICT_ID)values (SEQ_DEPARTEMENT.nextval,'".$departement_code."','".$departement_name."',".$district_id.")");
	
	}

	public function edit($departement_id,$departement_code,$departement_name,$district_id)
	{
		$this->db->query("update M_ADM_DEPARTEMENT set DEPARTEMENT_CODE='".$departement_code."', DEPARTEMENT_NAME='".$departement_name."',DISTRICT_ID='".$district_id."' where DEPARTEMENT_ID='".$departement_id."'");
	}

	public function delete($ID)
	{
		$this->db->query("delete from M_ADM_DEPARTEMENT where DEPARTEMENT_ID='$ID'");
	}

}
?>

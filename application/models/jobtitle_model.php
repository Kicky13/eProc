<?php
class jobtitle_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get_all()
	{
		$sql = "select * from M_ADM_JOBTITLE, M_ADM_DEPARTEMENT
				where M_ADM_DEPARTEMENT.DEPARTEMENT_ID=M_ADM_JOBTITLE.DEPARTEMENT_ID 
				order by JOBTITLE_NAME asc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function add($jobtitle_name,$departement_id)
	{
		$this->db->query("insert into M_ADM_JOBTITLE(JOBTITLE_ID,JOBTITLE_NAME,DEPARTEMENT_ID)values (SEQ_JOBTITLE.nextval,'".$jobtitle_name."',".$departement_id.")");
	
	}

	public function edit($jobtitle_id,$jobtitle_name,$departement_id)
	{
		$this->db->query("update M_ADM_JOBTITLE set JOBTITLE_NAME='".$jobtitle_name."',DEPARTEMENT_ID='".$departement_id."'
			where JOBTITLE_ID='".$jobtitle_id."'");
	}

	public function delete($ID)
	{
		$this->db->query("delete from M_ADM_JOBTITLE where JOBTITLE_ID='$ID'");
	}

}
?>

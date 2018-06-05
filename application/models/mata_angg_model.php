<?php
class mata_angg_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get_all()
	{
		$sql = "select MATA_ANGGARAN, NAMA_MATA_ANGGARAN, SUB_MATA_ANGGARAN, NAMA_SUB_MATA_ANGGARAN from M_ADM_MATA_ANGG order by MATA_ANGGARAN asc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function add($mata_angg,$nama_mata_angg,$sub_mata_angg,$nama_sub_mata_angg)
	{
		$this->db->query("insert into M_ADM_MATA_ANGG (MATA_ANGG_ID,MATA_ANGGARAN,NAMA_MATA_ANGGARAN,SUB_MATA_ANGGARAN,NAMA_SUB_MATA_ANGGARAN)values (SEQ_MATA_ANGG.nextval,'".$mata_angg."','".$nama_mata_angg."','".$sub_mata_angg."','".$nama_sub_mata_angg."')");
	}

	public function edit($mata_angg_id,$mata_angg,$nama_mata_angg,$sub_mata_angg,$nama_sub_mata_angg)
	{
		$this->db->query("update M_ADM_MATA_ANGG set MATA_ANGGARAN='".$mata_angg."', NAMA_MATA_ANGGARAN='".$nama_mata_angg."', SUB_MATA_ANGGARAN='".$sub_mata_angg."', NAMA_SUB_MATA_ANGGARAN='".$nama_sub_mata_angg."' where MATA_ANGG_ID=".$mata_angg_id."");
	}

	public function delete($mata_angg_id)
	{
		$this->db->query("delete from M_ADM_MATA_ANGG where MATA_ANGG_ID='$mata_angg_id'");
	}

}
?>

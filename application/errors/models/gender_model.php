<?php
class gender_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get_all()
	{
		$sql = "select * from M_ADM_GENDER";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

}
?>

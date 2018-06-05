<?php
class vnd_perf_mst_category extends MY_Model
{
	public $primary_key = 'ID_CATEGORY';
	public $table = 'VND_PERF_MST_CATEGORY';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		
		parent::__construct();
	}

	public function getvendor($nilai){
		$this->db->select("ID_CATEGORY, START_POINT, END_POINT, CATEGORY_NAME, CAN_BE_INVITED, IS_PRIORITY, DURATION"); 
		$this->db->where('START_POINT <= '.$nilai.'');
		$this->db->where('END_POINT >= '.$nilai.'');
		$this->db->from($this->table);
		$result = $this->db->get();
		return (array) $result->result_array();
	}
}
?>
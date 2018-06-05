<?php
class adm_wilayah extends MY_Model
{
	public $primary_key = 'ID';
	public $table = 'ADM_WILAYAH';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		parent::__construct();
	}

	public function get_wilayah($ID){
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where(array('ID'=>$ID));
		$result = $this->db->get();
		return (array) $result->result_array();
	}
}
?>
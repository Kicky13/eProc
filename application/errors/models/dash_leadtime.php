<?php

class dash_leadtime extends CI_Model {

	protected $table = 'DASH_LEADTIME';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	public function empty_table() {		
		return $this->db->empty_table($this->table);
	}

	public function auto_insert($query){
		$this->db->query("insert into ".$this->table." ".$query);
	}

	public function get_list_item($filter){
		$this->db->select("*");
		$this->db->from($this->table);
		if($filter&&isset($filter)&&is_array($filter)){
			foreach ($filter as $key => $value) {
				if(isset($value)){
					if(is_array($value)){
						$this->db->where_in($key,$value);
					}else{
						$this->db->where($key,$value);
					}
				}
			}
		}
		// return $this->db->_compile_select();

		$res = $this->db->get();
		return $res->result_array();
	}


}
?>
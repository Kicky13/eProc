<?php
class m_vnd_prefix extends MY_Model
{
	public $primary_key = 'PREFIX_ID';
	public $table = 'M_VND_PREFIX';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = TRUE;
		$this->soft_deletes = FALSE;
		parent::__construct();
	}

	public function get_child($id){
		$this->db->where('PREFIX_ID IN ('.$id.')');
		$this->db->order_by('PREFIX_ID','ASC');
		$gsj = $this->db->get($this->table);
		if ($gsj->num_rows()>0) {
			$result[]= 'Pilih Data';
			foreach ($gsj->result_array() as $row){
				$result[$row['PREFIX_ID']]= $row['PREFIX_NAME'];
			} 
		} else {
			$result[]= 'Belum Ada';
		}
		return $result;
	}

	public function get($where = NULL) {
		$this->db->select('M_VND_PREFIX.*');
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		// echo $this->db->last_query();
		return $result->result_array();
	}
}
?>
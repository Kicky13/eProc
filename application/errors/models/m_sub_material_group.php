<?php
class m_sub_material_group extends MY_Model
{
	public $primary_key = 'ID';
	public $table = 'M_SUB_MATERIAL_GROUP';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		$this->has_one['material_group'] = array('m_material_group','ID','ID');
		$this->has_one['material'] = array('m_material','ID','ID');
		parent::__construct();
	}

	public function get_sub_material(){
		$this->db->order_by('DESCRIPTION','ASC');
		$gj = $this->db->get($this->table);
		if ($gj->num_rows()>0) {
			return $gj->result_array();
		}
	}

	public function get_child($id){
		$this->db->where('ID_MATERIAL_GROUP',$id);
		$this->db->order_by('DESCRIPTION','ASC');
		$gsj = $this->db->get($this->table);
		if ($gsj->num_rows()>0) {
			$result[]= 'Pilih Data';
			foreach ($gsj->result_array() as $row){
	            $result[$row['SUB_MATERIAL_GROUP']]= $row['DESCRIPTION'];
			} 
		} else {
		   $result[]= 'Belum Ada';
		}
        return $result;
	}
}
?>
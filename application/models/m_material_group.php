<?php
class m_material_group extends MY_Model
{
	public $primary_key = 'ID';
	public $table = 'M_MATERIAL_GROUP';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		$this->has_one['sub_material_group'] = array('m_sub_material_group','ID','ID');
		parent::__construct();
	}

	public function get_material(){
		$this->db->order_by('DESCRIPTION','ASC');
		$this->db->where('IS_JASA','0');
		$gj = $this->db->get($this->table);
		if ($gj->num_rows()>0) {
			return $gj->result_array();
		}
	}

}
?>
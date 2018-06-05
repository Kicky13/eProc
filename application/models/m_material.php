<?php
class m_material extends MY_Model
{
	public $primary_key = 'ID';
	public $table = 'M_MATERIAL';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		$this->has_one['sub_material_group'] = array('m_sub_material_group','ID','ID');
		parent::__construct();
	}
}
?>
<?php
class m_vnd_tools_category extends MY_Model
{
	public $primary_key = 'CATEGORY_ID';
	public $table = 'M_VND_TOOLS_CATEGORY';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		parent::__construct();
	}
}
?>
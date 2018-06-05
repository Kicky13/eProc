<?php
class m_vnd_type extends MY_Model
{
	public $primary_key = 'VENDOR_TYPE_ID';
	public $table = 'M_VND_TYPE';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		parent::__construct();
	}
}
?>
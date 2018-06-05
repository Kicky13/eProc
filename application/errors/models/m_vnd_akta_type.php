<?php
class m_vnd_akta_type extends MY_Model
{
	public $primary_key = 'AKTA_TYPE_ID';
	public $table = 'M_VND_AKTA_TYPE';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		parent::__construct();
	}
}
?>
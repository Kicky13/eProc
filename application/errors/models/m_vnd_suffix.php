<?php
class m_vnd_suffix extends MY_Model
{
	public $primary_key = 'SUFFIX_ID';
	public $table = 'M_VND_SUFFIX';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = TRUE;
		$this->soft_deletes = FALSE;
		parent::__construct();
	}
}
?>
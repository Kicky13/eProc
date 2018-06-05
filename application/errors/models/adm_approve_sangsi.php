<?php
class adm_approve_sangsi extends MY_Model
{
	public $primary_key = 'ID';
	public $table = 'ADM_APPROVE_SANGSI';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		parent::__construct();
	}
}
?>
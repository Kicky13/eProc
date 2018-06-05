<?php
class adm_curr extends MY_Model
{
	public $primary_key = 'CURR_CODE';
	public $table = 'ADM_CURR';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		parent::__construct();
	}
}
?>
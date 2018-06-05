<?php
class adm_country extends MY_Model
{
	public $primary_key = 'COUNTRY_CODE';
	public $table = 'ADM_COUNTRY';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		parent::__construct();
	}
}
?>
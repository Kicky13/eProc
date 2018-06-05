<?php
class adm_city extends MY_Model
{
	public $primary_key = 'CITY_CODE';
	public $table = 'ADM_CITY';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		parent::__construct();
	}
}
?>
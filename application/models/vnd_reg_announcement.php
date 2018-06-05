<?php
class vnd_reg_announcement extends MY_Model
{
	public $primary_key = 'COMPANYID';
	public $table = 'VND_REG_ANNOUNCEMENT';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = TRUE;
		$this->soft_deletes = FALSE;
		$this->has_one['company'] = array('adm_company','COMPANYID','COMPANYID');
		parent::__construct();
	}
}
?>
<?php
class tmp_vnd_reg_status extends MY_Model
{
	public $primary_key = 'REG_STATUS_ID';
	public $table = 'TMP_VND_REG_STATUS';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		$this->has_one['vendor'] = array('tmp_vnd_header','STATUS','REG_STATUS_CODE');
		parent::__construct();
	}
}
?>
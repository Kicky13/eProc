<?php
class tmp_vnd_equip extends MY_Model
{
	public $primary_key = 'EQUIP_ID';
	public $table = 'TMP_VND_EQUIP';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		$this->has_one['vendor'] = array('tmp_vnd_header','VENDOR_ID','VENDOR_ID');
		parent::__construct();
	}
}
?>
<?php
class vnd_equip extends MY_Model
{
	public $primary_key = 'EQUIP_ID';
	public $table = 'VND_EQUIP';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = array('DATE_CREATION','MODIFIED_DATE');
		$this->soft_deletes = FALSE;
		$this->has_one['vendor'] = array('vnd_header','VENDOR_ID','VENDOR_ID');
		parent::__construct();
	}
}
?>
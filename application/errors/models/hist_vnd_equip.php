<?php
class hist_vnd_equip extends MY_Model
{
	public $primary_key = 'EQUIP_ID';
	public $table = 'HIST_VND_EQUIP';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		$this->has_one['vendor'] = array('HIST_VND_HEADER','VENDOR_ID','VENDOR_ID');
		parent::__construct();
	}
}
?>
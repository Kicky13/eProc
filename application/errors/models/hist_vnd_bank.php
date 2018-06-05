<?php
class hist_vnd_bank extends MY_Model
{
	public $primary_key = 'BANK_ID';
	public $table = 'HIST_VND_BANK';

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
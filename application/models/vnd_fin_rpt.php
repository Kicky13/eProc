<?php
class vnd_fin_rpt extends MY_Model
{
	public $primary_key = 'FIN_RPT_ID';
	public $table = 'VND_FIN_RPT';

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
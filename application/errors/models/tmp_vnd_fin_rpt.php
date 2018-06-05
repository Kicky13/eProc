<?php
class tmp_vnd_fin_rpt extends MY_Model
{
	public $primary_key = 'FIN_RPT_ID';
	public $table = 'TMP_VND_FIN_RPT';

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
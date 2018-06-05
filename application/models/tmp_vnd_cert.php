<?php
class tmp_vnd_cert extends MY_Model
{
	public $primary_key = 'CERT_ID';
	public $table = 'TMP_VND_CERT';

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
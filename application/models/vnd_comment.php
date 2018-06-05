<?php
class vnd_comment extends MY_Model
{
	public $primary_key = 'COMMENT_ID';
	public $table = 'VND_COMMENT';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = TRUE;
		$this->soft_deletes = FALSE;
		$this->has_one['vendor'] = array('vnd_header','VENDOR_ID','VENDOR_ID');
		parent::__construct();
	}
}
?>
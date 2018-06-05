<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class vnd_vendor_comment extends MY_Model
{
	public $primary_key = 'ID';
	public $table = 'VND_VENDOR_COMMENT';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = array('DATE_COMMENT');
		$this->soft_deletes = FALSE;
		$this->has_one['vendor'] = array('vnd_header','VENDOR_ID','VENDOR_ID');
		parent::__construct();
	}

	public function get_all_status($vendor_id) {
		$all = $this->get_all(array('VENDOR_ID' => $vendor_id));
		return $all;
	}
}
?>
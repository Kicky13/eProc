<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class tmp_vnd_reg_progress extends MY_Model {

	public $primary_key = 'VND_REG_PRG_ID';
	public $table = 'TMP_VND_REG_PROGRESS';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		parent::__construct();
	}

	public function get_all_status($vendor_id) {
		$all = $this->get_all(array('VENDOR_ID' => $vendor_id));
		return $all;
	}

}
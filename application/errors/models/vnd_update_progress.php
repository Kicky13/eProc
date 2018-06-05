<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class vnd_update_progress extends MY_Model {

	public $primary_key = 'VND_UPDATE_PRG_ID';
	public $table = 'VND_UPDATE_PROGRESS';

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

	public function get_cek($vendor_id,$container) {
		$this->db->select("VND_UPDATE_PRG_ID, VENDOR_ID, STATUS, REASON, CONTAINER");
		$this->db->from("VND_UPDATE_PROGRESS");
		$this->db->where('VENDOR_ID', $vendor_id);
		$this->db->where('CONTAINER', $container);
		$result = $this->db->get();
		return $result->result_array();
	}

}
<?php
class hist_vnd_header extends MY_Model
{
	public $primary_key = 'VND_HEADER_ID';
	public $table = 'HIST_VND_HEADER';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		$this->has_many['add'] = array('hist_vnd_add','VENDOR_ID','VENDOR_ID');
		$this->has_many['akta'] = array('hist_vnd_akta','VENDOR_ID','VENDOR_ID');
		$this->has_many['address'] = array('hist_vnd_address','VENDOR_ID','VENDOR_ID');
		$this->has_many['bank'] = array('hist_vnd_bank','VENDOR_ID','VENDOR_ID');
		$this->has_many['board'] = array('hist_vnd_board','VENDOR_ID','VENDOR_ID');
		$this->has_many['cert'] = array('hist_vnd_cert','VENDOR_ID','VENDOR_ID');
		$this->has_many['cv'] = array('hist_vnd_cv','VENDOR_ID','VENDOR_ID');
		$this->has_many['equip'] = array('hist_vnd_equip','VENDOR_ID','VENDOR_ID');
		$this->has_many['fin_rpt'] = array('hist_vnd_fin_rpt','VENDOR_ID','VENDOR_ID');
		$this->has_many['product'] = array('hist_vnd_product','VENDOR_ID','VENDOR_ID');
		$this->has_many['sdm'] = array('hist_vnd_sdm','VENDOR_ID','VENDOR_ID');
		parent::__construct();
	}
}
?>
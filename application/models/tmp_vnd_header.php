<?php
class tmp_vnd_header extends MY_Model
{
	public $primary_key = 'VENDOR_ID';
	public $table = 'TMP_VND_HEADER';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = TRUE;
		$this->soft_deletes = FALSE;
		$this->has_many['add'] = array('tmp_vnd_add','VENDOR_ID','VENDOR_ID');
		$this->has_many['akta'] = array('tmp_vnd_akta','VENDOR_ID','VENDOR_ID');
		$this->has_many['address'] = array('tmp_vnd_address','VENDOR_ID','VENDOR_ID');
		$this->has_many['bank'] = array('tmp_vnd_bank','VENDOR_ID','VENDOR_ID');
		$this->has_many['board'] = array('tmp_vnd_board','VENDOR_ID','VENDOR_ID');
		$this->has_many['cert'] = array('tmp_vnd_cert','VENDOR_ID','VENDOR_ID');
		$this->has_many['cv'] = array('tmp_vnd_cv','VENDOR_ID','VENDOR_ID');
		$this->has_many['equip'] = array('tmp_vnd_equip','VENDOR_ID','VENDOR_ID');
		$this->has_many['fin_rpt'] = array('tmp_vnd_fin_rpt','VENDOR_ID','VENDOR_ID');
		$this->has_many['product'] = array('tmp_vnd_product','VENDOR_ID','VENDOR_ID');
		$this->has_many['sdm'] = array('tmp_vnd_sdm','VENDOR_ID','VENDOR_ID');
		
		$this->has_one['regcode'] = array('tmp_vnd_reg_status','REG_STATUS_CODE','STATUS');
		parent::__construct();
	}
    
    public function get_last_id() {
        $this->db->select_max($this->primary_key, 'MAX');
        $max = $this->db->get($this->table)->row_array();
        return $max['MAX'] + 1 - 1;
    }

    public function get_cek_user($username,$email) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('TMP_VND_HEADER.LOGIN_ID', $username);
		$this->db->where('TMP_VND_HEADER.EMAIL_ADDRESS', $email);
		$result = $this->db->get();
		return $result->result_array();
	}
   
}
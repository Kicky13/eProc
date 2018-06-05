<?php
class hist_vnd_product extends MY_Model
{
	public $primary_key = 'PRODUCT_ID';
	public $table = 'HIST_VND_PRODUCT';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		$this->has_one['vendor'] = array('HIST_VND_HEADER','VENDOR_ID','VENDOR_ID');
		parent::__construct();
	}

	public function get_last_id() {
        $this->db->select_max($this->primary_key, 'MAX');
        $max = $this->db->get($this->table)->row_array();
        return $max['MAX'] + 1 - 1;
    }
}
?>
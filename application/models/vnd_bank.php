<?php
class vnd_bank extends MY_Model
{
	public $primary_key = 'BANK_ID';
	public $table = 'VND_BANK';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = array('DATE_CREATION','MODIFIED_DATE');
		$this->soft_deletes = FALSE;
		$this->has_one['vendor'] = array('vnd_header','VENDOR_ID','VENDOR_ID');
		parent::__construct();
	}

	public function get($where=NULL)
	{
		$this->db->select("*");
		$this->db->from($this->table);
		if(!empty($where))
		{
			$this->db->where($where);
		}

		$this->db->order_by('BANK_ID','ASC');

		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return false;
		}
	}
}
?>
<?php
class adm_company extends MY_Model
{
	public $primary_key = 'COMPANYID';
	public $table = 'ADM_COMPANY';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = TRUE;
		$this->soft_deletes = FALSE;
		$this->has_many['announcement'] = array('vnd_reg_announcement','COMPANYID','COMPANYID');
		parent::__construct();
	}

	public function get_list(){
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where(array('ISACTIVE'=>1));
		$result = $this->db->get();
		$data = array();
		foreach ($result->result_array() as $value) {
			$data[$value['COMPANYID']] = $value['COMPANYNAME'];
		}
		return $data;
	}

	public function get_company(){
		$this->db->select("*");
		$this->db->from($this->table);
		// $this->db->where(array('ISACTIVE'=>1));
		$result = $this->db->get();
		return (array) $result->result_array();
	}

	public function insert_new($data) {
		return $this->db->insert($this->table, $data);
	}

	public function update_new($data, $where) {
		$this->db->where($where);
		return $this->db->update($this->table, $data);
	}
}
?>
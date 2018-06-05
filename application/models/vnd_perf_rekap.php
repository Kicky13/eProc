<?php
class vnd_perf_rekap extends MY_Model
{
	public $primary_key = 'ID_REKAP';
	public $table = 'VND_PERF_REKAP';
	public $id;

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->has_many['rekap_approve'] = array('vnd_perf_rekap_approve','ID_REKAP','ID_REKAP');
		parent::__construct();
	}

	function get($where = NULL,$limit=NULL,$offset=NULL) {
		$this->db->select("ID_REKAP, VENDOR_NO, VALUE, REKAP_DATE, START_DATE,END_DATE,REASON, STATUS, IS_DONE");
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		if (!empty($limit)) {
			if (!empty($offset)) {
				$this->db->limit($limit,$offset);
			}
			else {
				$this->db->limit($limit);
			}
		}
		$this->db->order_by('ID_REKAP', 'asc');
		$result = $this->db->get();
		return (array) $result->result_array();
	}

	public function get_last_id(){
		return $this->id;
	}

	/*
	for insert record
	parameter:
	$data = array(column=>data)
	*/
	public function insert($data){
		foreach ($data as $key => $value) {
			if($key=='REKAP_DATE'){
				$this->db->set('REKAP_DATE',"TO_DATE('".$value."' ,'DD-MON-YYYY HH.MI.SS AM')",FALSE);
			}
			else if($key=='START_DATE'){
				$this->db->set('START_DATE',"TO_DATE('".$value."' ,'DD-MON-YYYY HH.MI.SS AM')",FALSE);
			}
			else if($key=='END_DATE'){
				$this->db->set('END_DATE',"TO_DATE('".$value."' ,'DD-MON-YYYY HH.MI.SS AM')",FALSE);
			}else{
				$this->db->set($key,$value,FALSE);
			}
		}
		if($this->db->insert($this->table)) {
			$this->db->select('MAX(ID_REKAP) AS IDREKAP');
			$this->db->from($this->table);
			$result = $this->db->get();
			$data = $result->result_array();
			$this->id = $data[0]['IDREKAP'];
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	/*
	for update record
	parameter: 
	$data = array(column=>data)
	$where = array(column=>where data)
	*/
	function update($data, $where) {
		$this->db->where($where);
		if($this->db->update($this->table, $data)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
}
?>
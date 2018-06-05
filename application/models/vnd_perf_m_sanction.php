<?php
class vnd_perf_m_sanction extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "VND_PERF_M_SANCTION";
	}

	public function get($where = NULL) {	
		$this->db->select("*");
		$this->db->from($this->table);
		if(isset($where)){
			$this->db->where($where);
		}
		$this->db->order_by('M_SANCTION_ID','ASC');
		$result = $this->db->get();
		return $result->result_array();
	}

	public function get_list($CATEGORY){
		$this->db->select("M_SANCTION_ID,SANCTION_NAME");
		$this->db->from($this->table);
		$this->db->where(array('CATEGORY'=>$CATEGORY));
		$result = $this->db->get();
		$data = array();
		foreach ($result->result_array() as $value) {
			$data[$value['M_SANCTION_ID']] = $value['SANCTION_NAME'];
		}
		return $data;
	}

	public function get_sanction($nilai){		
		$where['LOWER <=']=$nilai;
		$where['UPPER >=']=$nilai;
		$where['STATUS']=1;
		return $this->get($where);
	}

	public function get_sanction_view($nilai){		
		$where['LOWER <=']=$nilai;
		$where['UPPER >=']=$nilai;
		$where['STATUS']=1;
		$where['CATEGORY']='UMUM';
		return $this->get($where);
	}

	public function get_by_id($id){
		$where['M_SANCTION_ID']=$id;
		return $this->get($where);
	}

	public function insert($data) {
		if($this->db->insert($this->table, $data)){
			return true;
		}
	}

	public function insert_batch($data) {
		$this->db->insert_batch($this->table, $data);
	}

	public function update($set = NULl, $where = NULL) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function delete($id){
		$this->db->where('M_SANCTION_ID', $id);
		if($this->db->delete($this->table)){
			return true;
		}
	}
}
?>
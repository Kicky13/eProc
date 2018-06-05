<?php
class po_role extends CI_Model {
	private $db2;

	protected $table = 'HMR.V_PO_ROLE_PO';

	public function __construct() {
		parent::__construct();		
		$this->db2=$this->load->database('default2',TRUE);	
	}

	public function get($where = NULL) {
		$this->db2->select('USERAD,REAL_CODE,REAL_GROUP');
		if (!empty($where)) {
			$this->db2->where($where);
		}
		$this->db2->from($this->table);
		$result = $this->db2->get();
		// echo $this->db->last_query();
		return $result->result_array();
		$this->db2->close();
	}

	public function get_realcode($userad){
		$this->where_klasPO();
		$this->where_userad($userad);
		$this->db2->select('REAL_CODE');
		if (!empty($where)) {
			$this->db2->where($where);
		}
		$this->db2->group_by('REAL_CODE');
		$this->db2->from($this->table);
		$result = $this->db2->get();	
		$realcode= array();	
		foreach ($result->result_array() as $key => $value) {
			$realcode[]=$value;
		}
		return $realcode;
		$this->db2->close();
	}

	public function get_realgroup($userad){
		$this->where_klasPO();
		$this->where_userad($userad);
		$this->db2->select('REAL_GROUP');
		if (!empty($where)) {
			$this->db2->where($where);
		}
		$this->db2->group_by('REAL_GROUP');
		$this->db2->from($this->table);
		$result = $this->db2->get();	
		$realgroup= array();	
		foreach ($result->result_array() as $key => $value) {
			$realgroup[]=$value;
		}
		return $realgroup;
		$this->db2->close();
	}


	//select USERAD,REAL_CODE,REAL_GROUP from HMR.V_PO_ROLE_PO where KLAS = 'PO' and USERAD = 'fachrur.roji'
	//select real_code from HMR.V_PO_ROLE_PO where KLAS = 'PO' and userad = 'fachrur.roji' group by real_code

	public function where_klasPO() {
		$this->db2->where(array('KLAS' => "PO"));
	}

	public function where_userad($userad = null) {
		if(!empty($userad))
			$this->db2->where(array('USERAD' => $userad));

	}



	}
?>
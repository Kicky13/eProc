<?php
class vnd_header extends MY_Model
{
	public $primary_key = 'VENDOR_ID';
	public $table = 'VND_HEADER';
	public $increments = false;

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = array('CREATION_DATE','MODIFIED_DATE');
		$this->soft_deletes = FALSE;
		$this->has_many['add'] = array('vnd_add','VENDOR_ID','VENDOR_ID');
		$this->has_many['address'] = array('vnd_address','VENDOR_ID','VENDOR_ID');
		$this->has_many['akta'] = array('vnd_akta','VENDOR_ID','VENDOR_ID');
		$this->has_many['bank'] = array('vnd_bank','VENDOR_ID','VENDOR_ID');
		$this->has_many['board'] = array('vnd_board','VENDOR_ID','VENDOR_ID');
		$this->has_many['cert'] = array('vnd_cert','VENDOR_ID','VENDOR_ID');
		$this->has_many['cv'] = array('vnd_cv','VENDOR_ID','VENDOR_ID');
		$this->has_many['equip'] = array('vnd_equip','VENDOR_ID','VENDOR_ID');
		$this->has_many['fin_rpt'] = array('vnd_fin_rpt','VENDOR_ID','VENDOR_ID');
		$this->has_many['product'] = array('vnd_product','VENDOR_ID','VENDOR_ID');
		$this->has_many['sdm'] = array('vnd_sdm','VENDOR_ID','VENDOR_ID');
		parent::__construct();
	}

	function get_total_data($where = NULL) {
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$this->db->like($key, $value);
			}
		}
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	function get_partial($start,$length,$draw){
		$subquery1 = "select ROWNUM RNUM,VND_HEADER.* from VND_HEADER where VND_HEADER.STATUS=3";
		$this->db->select('*');
		$this->db->from("(".$subquery1.")");
		$query = $this->db->get();
		$totalRecords = $query->num_rows();
		if(isset($length) && $start>-1){			
        	$subquery1.=' AND ROWNUM <= '.($start+$length);        	
        	$this->db->select("*");
        	$this->db->from("(".$subquery1.")");
        	$this->db->where("RNUM >",$start);
        	$this->db->order_by("VENDOR_NO");
        	$query = $this->db->get();
        	// $totalRecord = $query->num_rows();
        }
		
        $data = (array)$query->result_array();
        $result = array(
        	"length"=>$length,
        	"start"=>$start,
            "draw"            => intval($draw), 
            "recordsTotal"    => intval($totalRecords),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        return $result;
	}
}
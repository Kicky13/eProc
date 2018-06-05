<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Log_vendor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
	}

	public function index() {
		$data['title'] = "Log";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_validate_css();
		$this->layout->set_validate_js();
		$this->layout->add_js('pages/log_vendor.js');
		$this->layout->render('list_log_vendor', $data);
	}

	public function get_datatable() {
		$this->load->model('vnd_header');
		$length = $this->input->post('length');
		$start = $this->input->post('start');				
		$draw = $this->input->post('draw');	
		$search = $this->input->post('search');	
		$rn = $start+$length;

		$subquery1 = 'SELECT USER_ID, max(LM_ID) as MAXID FROM LOG_MAIN GROUP BY USER_ID';
		$subquery2 = 'SELECT T2.* FROM LOG_MAIN T2 INNER JOIN ('.$subquery1.') T1 ON T1.MAXID = T2.LM_ID';
		$subquery3 = "SELECT ROWNUM RNUM, T3.LM_ID, T3.USER_ID, T3.USER_POSITION, VND_HEADER.VENDOR_ID, VND_HEADER.VENDOR_NAME, VND_HEADER.EMAIL_ADDRESS, VND_HEADER.VENDOR_NO, VND_HEADER.STATUS FROM VND_HEADER INNER JOIN (".$subquery2.") T3 ON T3.USER_ID = VND_HEADER.VENDOR_NO WHERE VND_HEADER.STATUS=3 AND VND_HEADER.VENDOR_NO IS NOT NULL";
		if (isset($search)&&!empty($search)&&$search != '') {
			$subquery3.=" AND VND_HEADER.VENDOR_NO LIKE '%".strtoupper($search)."%' OR VND_HEADER.VENDOR_NAME LIKE '%".strtoupper($search)."%' OR VND_HEADER.STATUS LIKE '%".strtoupper($search)."%' OR VND_HEADER.EMAIL_ADDRESS LIKE '%".strtoupper($search)."%'";
		}
        $this->db->select("*");
        $this->db->from("(".$subquery3.")");        
        $query = $this->db->get();
		$totalRecords = $query->num_rows();
		if(isset($length) && $start>-1){			
        	$subquery3.=' AND ROWNUM <= '.($start+$length);        	
        	$this->db->select("*");
        	$this->db->from("(".$subquery3.")");
        	$this->db->where("RNUM >",$start);
        	
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

		echo json_encode($result);
	}

	public function detail_vendor($vendorno){
		$this->load->model('log_ven');

		$data['title'] = 'Log Detail';

		$data['data_log'] = $this->log_ven->get_log($vendorno);

		foreach ($data['data_log'] as $val) {
			$dtl = $this->log_detail->get(array('LM_ID'=>$val['LM_ID']));
			$data['detail'][$val['LM_ID']] = $dtl;
		}

		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('detail_log_vendor',$data);
	}

}
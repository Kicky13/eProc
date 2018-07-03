<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_master_costcenter extends CI_Model {
	
    protected $tableMaster = 'EC_PL_BUY_COSTCENTER';
    protected $employee = 'ADM_EMPLOYEE';


    public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	function simpanData($data) {
		$this->db->select('COUNT(*)');
		$this->db->from($this->tableMaster);
                $this->db->where("COSTCENTER", $data['COSTCENTER'], TRUE);
		$this->db->where("COSTCENTER_NAME", $data['COSTCENTER_NAME'], TRUE);
		$this->db->where("ID_USER", $data['USERID'], TRUE);
        $query = $this->db->get();
        $result = $query -> row_array();
		$count = $result['COUNT(*)'];
		if ($count > 0) {
			return false;
		}else{
			$this->db->insert($this->tableMaster, array('COSTCENTER' => $data['COSTCENTER'], 'COSTCENTER_NAME' => $data['COSTCENTER_NAME'], 'ID_USER' => $data['USERID'],'GUDANG'=>$data['GUDANG']));
			return true;
		}

		
		// if($this->db->_error_message()){
  //       	return $this->db->_error_message();
  //   	} else {
        	
  //   	}
	}
        
        function updateData($data) {
		$this->db->select('COUNT(*)');
		$this->db->from($this->tableMaster);
                $this->db->where("COSTCENTER", $data['COSTCENTER'], TRUE);
		$this->db->where("COSTCENTER_NAME", $data['COSTCENTER_NAME'], TRUE);
		$this->db->where("ID_USER", $data['USERID'], TRUE);
        $query = $this->db->get();
        $result = $query -> row_array();
		$count = $result['COUNT(*)'];
		if ($count > 1) {
			return false;
		}else{
                        $this->db->set('COSTCENTER', $data['COSTCENTER']);
                        $this->db->set('COSTCENTER_NAME', $data['COSTCENTER_NAME']);
                        $this->db->set('ID_USER', $data['USERID']);
                        $this->db->set('GUDANG', $data['GUDANG']);
                        $this->db->where('ID', $data['ID']);
			$this->db->update($this->tableMaster);
			return true;
		}
	}

	public function delete($ID){
        $this->db->where("ID", $ID, TRUE);
        $this->db->delete($this->tableMaster);
    }

	public function getMaster_costcenter(){
        $this->db->select($this->tableMaster.'.ID, FULLNAME, COSTCENTER, COSTCENTER_NAME, ID_USER, GUDANG');    
	$this->db->from($this->tableMaster);
        $this->db->join($this->employee, $this->tableMaster.'.ID_USER = '.$this->employee.'.ID');
        $this->db->order_by('COSTCENTER ASC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getCNF($cc){
    	$this->db->select('MAX(PROGRESS_CNF) AS CNF, MAX(VALUE_TO) AS VALUE_TO');
	$this->db->from($this->tableMaster);
	$this->db->where("UK_CODE", $cc, TRUE);
		// $this->db->group_by('UK_CODE');
        $result = $this->db->get();
        return $result->row_array();

    //     $SQL = "SELECT TB1.*, TO_CHAR (TB1.START_DATE,'DD/MM/YYYY') AS STARTDATE, TO_CHAR (TB1.END_DATE,'DD/MM/YYYY') AS ENDDATE,
			 // TB2.VENDORNO, TB2.HARGA_PENAWARAN, TB2.CURR AS CURR_PL, TB2.DELIVERY_TIME, SM.*, CAT.\"DESC\"
				// FROM (SELECT ASS.MATNO, ASS.START_DATE, ASS.END_DATE, ASS.KODE_PENAWARAN FROM EC_PL_ASSIGN ASS
				// GROUP BY ASS.MATNO, ASS.START_DATE, ASS.END_DATE, ASS.KODE_PENAWARAN) TB1
				// INNER JOIN EC_PL_PENAWARAN TB2 ON TB1.KODE_PENAWARAN=TB2.KODE_PENAWARAN
				// INNER JOIN EC_M_STRATEGIC_MATERIAL SM ON TB1.MATNO=SM.MATNR
				// INNER JOIN EC_M_CATEGORY CAT ON SM.ID_CAT=CAT.ID_CAT 
				// WHERE SM.PUBLISHED_LANGSUNG = '1' ";
    //     $result = $this->db->query($SQL);
    }
    public function getUsername(){
        $this->db->from($this->employee);
        $result = $this->db->get();
        return (array)$result->result_array();
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_master_approval_m extends CI_Model {
	protected $tableMaster = 'EC_PL_CONFIG_APPROVAL', $employee = 'ADM_EMPLOYEE', $cart = 'EC_T_CHART', $vendor = 'VND_HEADER';
	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	function simpanData($data) {
		// $user = explode(":", $data['USER']);

		$this->db->select('COUNT(*)');
		$this->db->from($this->tableMaster);
		$this->db->where("UK_CODE", $data['UK_CODE'], TRUE);
		$this->db->where("USERID", $data['USERID'], TRUE);
		$this->db->where("PROGRESS_CNF", $data['PROGRESS_CNF'], TRUE);
        $query = $this->db->get();
        $result = $query -> row_array();
		$count = $result['COUNT(*)'];
		if ($count > 0) {
			return false;
		}else{
			$this->db->insert($this->tableMaster,
                array('UK_CODE' => $data['UK_CODE'], 'VALUE_FROM' => $data['VALUE_FROM'], 'VALUE_TO' => $data['VALUE_TO'], 'USERNAME' => $data['USERNAME'], 'PROGRESS_CNF' => $data['PROGRESS_CNF'], 'USERID' => $data['USERID'], 'USER_AKSES' => $data['USER_AKSES']));
			return true;
		}

		
		// if($this->db->_error_message()){
  //       	return $this->db->_error_message();
  //   	} else {
        	
  //   	}
	}

	function updateData($data, $CC, $CNF) {
		$user = explode(":", $data['USER']);

		$this->db->where("UK_CODE", $CC, TRUE);
		$this->db->where("PROGRESS_CNF", $CNF, TRUE);
        $this->db->update($this->tableMaster, array('UK_CODE' => $data['UK_CODE'], 'VALUE_FROM' => $data['VALUE_FROM'], 'VALUE_TO' => $data['VALUE_TO'], 'USERNAME' => $user[1], 'PROGRESS_CNF' => $data['PROGRESS_CNF'], 'USERID' => $user[0]));

		// $this->db->set('EC_PL_CONFIG_APPROVAL.UK_CODE', $data['UK_CODE'], FALSE);
		// $this->db->set('EC_PL_CONFIG_APPROVAL.VALUE_FROM', $data['VALUE_FROM'], FALSE);
		// $this->db->set('EC_PL_CONFIG_APPROVAL.VALUE_TO', $data['VALUE_TO'], FALSE);
		// $this->db->set('EC_PL_CONFIG_APPROVAL.USERNAME', $user[1], FALSE);
		// $this->db->set('EC_PL_CONFIG_APPROVAL.PROGRESS_CNF', $data['PROGRESS_CNF'], FALSE);
		// $this->db->set('EC_PL_CONFIG_APPROVAL.USERID', $user[0], FALSE);
  //       $this->db->where("EC_PL_CONFIG_APPROVAL.UK_CODE", $data['UK_CODE'], TRUE);
  //       $this->db->where("EC_PL_CONFIG_APPROVAL.PROGRESS_CNF", $data['PROGRESS_CNF'], TRUE);
  //       $this->db->update($this->tableMaster);
        if ($this->db->affected_rows() == '1') {
		    return true;
		}else{
			return false;
		}

		// $this->db->select('COUNT(*)');
		// $this->db->from($this->tableMaster);
		// $this->db->where("UK_CODE", $data['UK_CODE'], TRUE);
		// $this->db->where("PROGRESS_CNF", $data['PROGRESS_CNF'], TRUE);
  //       $query = $this->db->get();
  //       $result = $query -> row_array();
		// $count = $result['COUNT(*)'];
		// if ($count > 0) {
		// 	return false;
		// }else{
		// 	$this->db->insert($this->tableMaster,
  //               array('UK_CODE' => $data['UK_CODE'], 'VALUE_FROM' => $data['VALUE_FROM'], 'VALUE_TO' => $data['VALUE_TO'], 'USERNAME' => $user[1], 'PROGRESS_CNF' => $data['PROGRESS_CNF'], 'USERID' => $user[0]));
		// 	return true;
		// }

		
		// if($this->db->_error_message()){
  //       	return $this->db->_error_message();
  //   	} else {
        	
  //   	}
	}

	public function delete($CC, $CNF){
        $this->db->where("UK_CODE", $CC, TRUE);
        $this->db->where("PROGRESS_CNF", $CNF, TRUE);
        $this->db->delete($this->tableMaster);
    }

	public function getMaster_approval(){
		$this->db->from($this->tableMaster);
		$this->db->order_by('UK_CODE', 'DESC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getActive_user($USERID)
    {
        $this->db->from($this->tableMaster);
        $this->db->where('USERID', $USERID);
        $this->db->order_by('UK_CODE', 'DESC');
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    public function getVendor_target($po)
    {
        $this->db->from($this->cart);
        $this->db->join($this->vendor, $this->cart.'.VENDORNO = '.$this->vendor.'.VENDOR_NO');
        $this->db->where('PO_NO', $po);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    public function getEmailNotif($CC, $CNF)
    {
        $this->db->from($this->tableMaster);
        $this->db->join($this->employee, $this->tableMaster.'.USERID = '.$this->employee.'.ID');
        $this->db->where('UK_CODE', $CC);
        $this->db->where('PROGRESS_CNF', $CNF);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    public function getEmailNext($CC, $CNF)
    {
        $this->db->from($this->tableMaster);
        $this->db->join($this->employee, $this->tableMaster.'.USERID = '.$this->employee.'.ID');
        $this->db->where('UK_CODE', $CC);
        $this->db->where('PROGRESS_CNF', $CNF);
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
	// $pjg2 = strlen($result[$i]['KODE_USER']);
}

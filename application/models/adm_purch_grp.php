<?php defined('BASEPATH') OR exit('No direct script access allowed');

class adm_purch_grp extends CI_Model {

	protected $table = 'ADM_PURCH_GRP';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL, $order = true) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		if ($order) {
			$this->db->order_by('PURCH_GRP_CODE');
		}
		$result = $this->db->get();
		return (array) $result->result_array();
	}

	function join_ppr() {
		$this->db->order_by('PRC_PURCHASE_REQUISITION.PPR_DATE_RELEASE','ASC');
		return $this->db->join('PRC_PURCHASE_REQUISITION', 'PRC_PURCHASE_REQUISITION.PPR_PGRP = ADM_PURCH_GRP.PURCH_GRP_CODE', 'right');
	}

	function join_opco() {
		return $this->db->join('ADM_COMPANY', 'ADM_COMPANY.COMPANYID = ADM_PURCH_GRP.COMPANY_ID', 'left');
	}

	public function where_pgrp($pgrp) {
		$word = '(';
		foreach ($pgrp as $key => $value) {
			if($key == 0){
				$word = $word . ' "PURCH_GRP_CODE" = '. "'$value'"; 
			} else {
				$word = $word . ' OR "PURCH_GRP_CODE" = '. "'$value'";
			}
		}
		$word = $word . ')';
		$this->db->where($word, null, false);
	}

	public function where_company_id($cid) {
		$word = '(';
		foreach ($cid as $key => $value) {
			if($key == 0){
				$word = $word . ' "COMPANYID" = '. "'$value'"; 
			} else {
				$word = $word . ' OR "COMPANYID" = '. "'$value'";
			}
		}
		$word = $word . ')';
		$this->db->where($word, null, false);
	}

	public function where_kel_company($cid) {
		$word = '(';
		foreach ($cid as $key => $value) {
			if($key == 0){
				$word = $word . ' "KEL_PURCH_GRP" = '. "'$value'"; 
			} else {
				$word = $word . ' OR "KEL_PURCH_GRP" = '. "'$value'";
			}
		}
		$word = $word . ')';
		$this->db->where($word, null, false);
	}

	public function get_by_opco($opco) {
		$this->db->distinct();
		$this->db->select('COMPANY_ID, KEL_PURCH_GRP');
		$this->db->where('COMPANY_ID', $opco);
		return $this->get(null, false);
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function insert_batch($data) {
		$this->db->insert_batch($this->table, $data);
	}

	public function update($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}
    
    public function get_grp_akses($user)
    {
       	$sql="SELECT APP_GRP_MENU.APP_GRP_ID FROM
    	ADM_POS INNER JOIN ADM_DEPT ON ADM_POS.DEPT_ID=ADM_DEPT.DEPT_ID INNER JOIN ADM_COMPANY ON ADM_DEPT.DEPT_COMPANY=ADM_COMPANY.COMPANYID
    	LEFT JOIN APP_GRP_MENU ON ADM_POS.GROUP_MENU=APP_GRP_MENU.APP_GRP_ID INNER JOIN ADM_EMPLOYEE ON ADM_POS.POS_ID=ADM_EMPLOYEE.ADM_POS_ID  
        WHERE ADM_EMPLOYEE.ID=$user";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(!empty($result))
        {
            foreach ($query->result() as $row)
            {
               return $row->APP_GRP_ID;
            }
        }
        else
        {
            return 0;
        }
    }

}
<?php
class prc_tender_comment_model extends CI_Model {

	var $insert_query = 'insert into PRC_TENDER_COMMENT ';
	var $query_all = "select DISTINCT PTC_ID, PTC_POSITION, PTC_NAME, PTC_ACTIVITY, PTC_COMMENT, PTC_ATTACHMENT, TO_CHAR(PTC_END_DATE, 'DD-MM-YYYY HH24.MI.SS') AS PTC_END_DATE from PRC_TENDER_COMMENT";
	var $get_id_query = 'select max(PTC_ID) as id from PRC_TENDER_COMMENT';


	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=NULL, $status=NULL)
	{
		$query = $this->query_all;
		if(!empty($where))
		{
			foreach ($where as $key => $row) {
				$query .= ' where '.$key.' = '.$row.' ';
			}
		}
		if(!empty($status)){
			$query .= ' AND (';
			foreach ($status as $ky => $val) {
				$ky = $ky+1;
				$query .= "PTC_STATUS_PROSES = $val ";
				if($ky != count($status)){
					$query .= ' OR ';
				}
			}	
			$query .= ')';
		}

		$query .= ' order by PTC_ID';

		$result = $this->db->query($query);
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return false;
		}
	}

	function get_id()
	{
		$result = $this->db->query($this->get_id_query);
		$id = $result->row_array();
		return $id['ID'] + 1;
	}

	function insert($data) {
		$insert_query = $this->insert_query;
		if (!empty($data)) {
			foreach ($data as $key => $row) {
				$column[] = $key;
			}
			foreach ($data as $key => $row) {
				$values[] = $row;
			}
			$all_column = implode(',', $column);
			$all_values = implode(',', $values);
			// echo "<pre>";
			// var_dump($all_column);
			// var_dump($all_values);
			$insert_query .= '('.$all_column.') values('.$all_values.')';
		}
		$this->db->query($insert_query);
		// echo $this->db->last_query();
		return 0;
	}

	function get_from_ptm_num($id) {
		return $this->get(array('PTM_NUMBER' => $id));
	}

	function join_ptm($id,$status){
		return $this->get(array('PTM_NUMBER' => $id), $status);
	}

}
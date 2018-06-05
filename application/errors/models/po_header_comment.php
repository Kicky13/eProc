<?php
class po_header_comment extends CI_Model {

	var $insert_query = 'insert into PO_HEADER_COMMENT ';
	var $query_all = "select PHC_POSITION, PHC_NAME, PHC_ACTIVITY, PHC_COMMENT, PHC_ATTACHMENT, TO_CHAR(PHC_END_DATE, 'DD-MM-YYYY HH24.MI.SS') AS PHC_END_DATE, TO_CHAR(PHC_START_DATE, 'DD-MM-YYYY HH24.MI.SS') AS PHC_START_DATE from PO_HEADER_COMMENT";
	var $get_id_query = 'select max(PHC_ID) as ID from PO_HEADER_COMMENT';


	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=NULL)
	{
		$query = $this->query_all;
		if(!empty($where))
		{
			foreach ($where as $key => $row) {
				$query .= ' where '.$key.' = '.$row.' ';
			}
		}

		$query .= ' order by PHC_ID';

		$result = $this->db->query($query);
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return false;
		}
	}

	function get_new_id()
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
			$insert_query .= '('.$all_column.') values('.$all_values.')';
		}
		$this->db->query($insert_query);
		return 0;
	}

	function get_from_po_id($id) {
		return $this->get(array('PO_ID' => $id));
	}

}
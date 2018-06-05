<?php
class prc_tender_doc extends CI_Model
{
	var $get_id_query = 'select max(PTD_ID) as id from PRC_TENDER_DOC';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=NULL)
	{
		$this->db->select('*');
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from('PRC_TENDER_DOC');
		$this->db->order_by('PTD_ID', 'DESC');
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return null;
		}
	}

	function get_id()
	{
		// $sql = 'select max(PPD_ID) as id from PRC_PLAN_DOC';
		$result = $this->db->query($this->get_id_query);
		$id = $result->row_array();
		return $id['ID'] + 1;
		
	}
}

/*

if($PTD_ID != false ) {$column['PTD_ID'] = 'PTD_ID'; $values['PTD_ID'] = (int)$PTD_ID;}
if($PTM_NUMBER != false ) {$column['PTM_NUMBER'] = 'PTM_NUMBER'; $values['PTM_NUMBER'] = '\''.trim($PTM_NUMBER).'\'';}
if($PTD_CATEGORY != false ) {$column['PTD_CATEGORY'] = 'PTD_CATEGORY'; $values['PTD_CATEGORY'] = '\''.trim($PTD_CATEGORY).'\'';}
if($PTD_DESCRIPTION != false ) {$column['PTD_DESCRIPTION'] = 'PTD_DESCRIPTION'; $values['PTD_DESCRIPTION'] = '\''.trim($PTD_DESCRIPTION).'\'';}
if($PTD_FILE_NAME != false ) {$column['PTD_FILE_NAME'] = 'PTD_FILE_NAME'; $values['PTD_FILE_NAME'] = '\''.trim($PTD_FILE_NAME).'\'';}
		*/
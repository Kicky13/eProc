<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment
{
	function __construct() {
		$this->ci = &get_instance();
		$this->ci->load->model(array('prc_tender_comment_model'));
	}

	function insert_comment_tender($data) {
		$data['PTC_END_DATE'] = "'" . date('d-M-Y g.i.s A') . "'";
		$this->ci->prc_tender_comment_model->insert($data);
		return 0;
	}

	function get_new_id() {
		return $this->ci->prc_tender_comment_model->get_id();
	}

	function get_comment_from_ptm_num($id) {
		return $this->ci->prc_tender_comment_model->get_from_ptm_num($id);
	}

	function join_ptm($id,$status) {
		return $this->ci->prc_tender_comment_model->join_ptm($id,$status);
	}
}
?>
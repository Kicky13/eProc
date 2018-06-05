<?php defined('BASEPATH') OR exit('No direct script access allowed');

class prc_tender_nego_vendor_doc extends CI_Model {

	protected $table = 'PRC_TENDER_NEGO_VENDOR_DOC';
	protected $id = 'PTNV_ID';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		return (array)$result->result_array();
	}

	public function nego_ptm_vendor($nego_id,$ptm,$vendor_kode) {
		return $this->get(
			array(
				'PRC_TENDER_NEGO_VENDOR_DOC.NEGO_ID'=>$nego_id,
				'PRC_TENDER_NEGO_VENDOR_DOC.PTM_NUMBER' => $ptm,
				'PRC_TENDER_NEGO_VENDOR_DOC.PTV_VENDOR_CODE'=>$vendor_kode
			));
	}

	public function get_file_upload($nego_id,$ptm,$vendor_kode){
		$data = $this->nego_ptm_vendor($nego_id,$ptm,$vendor_kode);
		return $data[0]['FILE_UPLOAD'];
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function get_id() {
		$this->db->select_max($this->id, 'MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	public function update($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}
}
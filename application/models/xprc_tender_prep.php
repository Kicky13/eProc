<?php
class xprc_tender_prep extends CI_Model {

	var $get_id_query = 'select max(PTP_ID) as id from PRC_TENDER_PREP';
	protected $table = 'PRC_TENDER_PREP';
	protected $all_field = 'PTP_ID, PRC_TENDER_PREP.PTM_NUMBER, PTP_JUSTIFICATION, PTP_JUSTIFICATION AS PTP_JUSTIFICATION_ORI, PTP_EVALUATION_METHOD, PTP_EVALUATION_METHOD AS PTP_EVALUATION_METHOD_ORI, PTP_REG_OPENING_DATE, PTP_REG_CLOSING_DATE, PTP_PREBID_DATE, PTP_PREBID_LOCATION, PRC_TENDER_PREP.EVT_ID, PTP_IS_ITEMIZE, PTP_IS_BIDBOND, PTP_MIN_BIDBOND, PTP_WARNING, PTP_WARNING_NEGO, PTP_BATAS_PENAWARAN,PTP_BAWAH_PENAWARAN, PTP_BATAS_NEGO, PTP_DELIVERY_DATE, PTP_TERM_DELIVERY, PTP_TERM_PAYMENT, PTP_DELIVERY_NOTE, PTP_PAYMENT_NOTE, PTP_WARNING AS PTP_WARNING_ORI, PTP_WARNING_NEGO AS PTP_WARNING_NEGO_ORI, PTP_PERSEN_PENAWARAN, PTP_PERSEN_PELAKSANAAN, PTP_PERSEN_PEMELIHARAAN, PTP_VALIDITY_HARGA, TO_CHAR(PTP_REG_CLOSING_DATE, \'YYYY-MM-DD HH24:MI:SS\') AS PTP_REG_CLOSING_DATE_RG,
		PTP_FILTER_VND_PRODUCT, PTP_FILTER_NAME, PTP_VENDOR_NOTE, PTP_VENDOR_NOTE, PTP_UPLOAD_USULAN_VENDOR';

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	function get($where=NULL, $select = false, $isrow = true)
	{
		if (!$select) $select = $this->all_field;
		$this->db->select($select, false);
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		if ($result->num_rows() >= 1) {
			if ($isrow) {
				return $this->readable($result->row_array());
			} else {
				foreach ($result->result_array() as $val) {
					$ans[] = $this->readable($val);
				}
				return $ans;
			}
		}
		else {
			return $isrow ? null : array();
		}
	}

	function ptm($ptm)
	{
		return $this->get(array('PTM_NUMBER' => $ptm));
	}

	function join_eval_template() {
		$this->db->select('PRC_EVALUATION_TEMPLATE.*');
		$this->db->join('PRC_EVALUATION_TEMPLATE', 'PRC_TENDER_PREP.EVT_ID = PRC_EVALUATION_TEMPLATE.EVT_ID', 'left');
	}

	function readable($ptp)
	{
		switch ($ptp['PTP_JUSTIFICATION']) {
			case "2": $ptp['PTP_JUSTIFICATION'] = 'Penunjukan Langsung'; break;
			case "1": $ptp['PTP_JUSTIFICATION'] = 'Pemilihan Langsung'; break;
			case "3": $ptp['PTP_JUSTIFICATION'] = 'Lelang Terbuka'; break;
			case "4": $ptp['PTP_JUSTIFICATION'] = 'Pembelian Langsung'; break;
			case "5": $ptp['PTP_JUSTIFICATION'] = 'Penunjukan Langsung - Repeat Order (RO)'; break;
			case "6": $ptp['PTP_JUSTIFICATION'] = 'Penunjukan Langsung - Sole Agent (ST)'; break;
			case "7": $ptp['PTP_JUSTIFICATION'] = 'Penunjukan Langsung - Task Force (TF)'; break;
			case "8": $ptp['PTP_JUSTIFICATION'] = 'Penunjukan Langsung - Other (OT)'; break;
		}

		switch ($ptp['PTP_EVALUATION_METHOD']) {
			case "1": $ptp['PTP_EVALUATION_METHOD'] = '1 Tahap 1 Sampul'; break;
			case "2": $ptp['PTP_EVALUATION_METHOD'] = '2 Tahap 1 Sampul'; break;
			case "3": $ptp['PTP_EVALUATION_METHOD'] = '2 Tahap 2 Sampul'; break;
		}

		switch ($ptp['PTP_WARNING']) {
			case "1": $ptp['PTP_WARNING'] = 'Tidak ada pesan'; break;
			case "2": $ptp['PTP_WARNING'] = 'Warning'; break;
			case "3": $ptp['PTP_WARNING'] = 'Error'; break;
		}

		switch ($ptp['PTP_WARNING_NEGO']) {
			case "1": $ptp['PTP_WARNING_NEGO'] = 'Tidak ada pesan'; break;
			case "2": $ptp['PTP_WARNING_NEGO'] = 'Warning'; break;
			case "3": $ptp['PTP_WARNING_NEGO'] = 'Error'; break;
		}
		return $ptp;
	}

	function get_id()
	{
		// $sql = 'select max(PPD_ID) as id from PRC_PLAN_DOC';
		$result = $this->db->query($this->get_id_query);
		$id = $result->row_array();
		return $id['ID'] + 1;
	}

	function insert_single($data)
	{
		$this->db->insert($this->table, $data);
	}

	function updateByPtm($ptm, $set) {
		$this->db->where(array('PTM_NUMBER' => $ptm));
		return $this->db->update($this->table, $set);
	}

	function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}

}
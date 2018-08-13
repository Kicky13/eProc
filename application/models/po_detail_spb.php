<?php
class po_detail_spb extends CI_Model {

	protected $table = 'PO_ITEM_SPB';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($join = true,$where = NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		if($join == true){
			$this->join_po();
		}
		$result = $this->db->get();
		return $result->result_array();
	}

	public function get_check_update($where = NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function where_po($id) {
		$this->db->where(array('PO_ITEM_SPB.PO_ID' => $id));
	}

	public function join_po() {
		$this->db->join('PO_HEADER_SPB', 'PO_HEADER_SPB.PO_ID = PO_ITEM_SPB.PO_ID', 'inner');
	}

	public function join_adm_plant() {
		$this->db->select('PO_DETAIL.*');
		$this->db->select('ADM_PLANT.PLANT_NAME');
		$this->db->join('ADM_PLANT', 'ADM_PLANT.PLANT_CODE = PO_DETAIL.PLANT', 'left');
	}

	public function get_id() {
		$this->db->select_max('POD_ID','MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function insert_batch($data) {
		$this->db->insert_batch($this->table, $data);
	}

	public function update($set = NULl, $where = NULL) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}
	
	public function delete($id = NULL){
		$this->db->where('PO_ID', $id);
		$this->db->delete($this->table);
	}

	public function get_item($id) {
		$this->db->where(array('PO_DETAIL.PTW_ID' => $id));
	}

	public function getDetailPo($PO_ID)
	{
		$SQL = "
		SELECT
		PO_DETAIL.*, TO_CHAR (PO_DETAIL.DDATE, 'YYYY-MM-DD') AS NEWDDATE,
		TO_CHAR (PO_DETAIL.DOC_DATE, 'YYYY-MM-DD') AS NEWDOC_DATE
		FROM
		PO_DETAIL
		WHERE
		PO_DETAIL.PO_ID = ".$PO_ID."
		";
		$result = $this -> db -> query($SQL);
		return $result->result_array();
	}

	public function updateDetailPo($data) {
		$this -> db -> set('DOC_DATE', "TO_DATE('" . $data['DOC_DATE'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('DDATE', "TO_DATE('" . $data['DDATE'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('ITEM_TEXT', "'".$data['ITEM_TEXT']."'", FALSE);
		$this -> db -> where('PO_ID', $data['PO_ID']);
		$this -> db -> where('POD_ID', $data['POD_ID']);
		$this -> db -> update('PO_DETAIL');
	}

	public function updateHeaderPo($data) {
		$this -> db -> set('DOC_DATE', "TO_DATE('" . $data['DOC_DATE'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> set('DDATE', "TO_DATE('" . $data['DDATE'] . "', 'YYYY-MM-DD HH24:MI:SS')", FALSE);
		$this -> db -> where('PO_ID', $data['PO_ID']);
		$this -> db -> update('PO_HEADER');
	}

}
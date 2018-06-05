<?php class prc_purchase_requisition_user extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}


	public function getRequisition($MKCCTR) {
		$SQL = "
		SELECT *
		FROM
		PRC_PURCHASE_REQUISITION ppr
		where ppr.PPR_REQUESTIONER = '".$MKCCTR."'
		";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function getItemRequisition($MKCCTR) {
		$SQL = "
		SELECT *
		FROM
		PRC_PURCHASE_REQUISITION ppr
		where ppr.PPR_REQUESTIONER like '%".$MKCCTR."%'
		";
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}
}
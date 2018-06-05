<?php
class M_tambahan_ub extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		
	}
	function total_ece_paket($ptm) {
		$sql="SELECT SUM(TIT_PRICE) JUMLAH_ECE FROM PRC_TENDER_MAIN INNER JOIN PRC_TENDER_ITEM ON PRC_TENDER_MAIN.PTM_NUMBER=PRC_TENDER_ITEM.PTM_NUMBER 
WHERE PRC_TENDER_ITEM.PTM_NUMBER='".$ptm."'";
		return $this->db->query($sql)->result_array();
	}
	
	function doctam($v) {
		$sql="SELECT * FROM PRC_ADD_ITEM WHERE PTM_NUMBER='".$v."'";
		return $this->db->query($sql)->result_array();
	}
	function doctambahan_eva($v) {
		$sql="SELECT * FROM PRC_ADD_ITEM_EVALUASI WHERE PTM_NUMBER='".$v."'";
		return $this->db->query($sql)->result_array();
	}
	
}
?>
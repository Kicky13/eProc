<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class monitor_invoice extends CI_Model {
	protected $table = 'MONITORING_INVOICE';
	//protected $all_field = 'MONITORING_INVOICE.BUKRS, MONITORING_INVOICE.LIFNR, BELNR, GJAHR, BIL_NO, NAME1, BKTXT, SGTXT, XBLNR, UMSKZ, BUDAT, BLDAT, CPUDT, MONAT, ZLSPR, WAERS, HWAER, ZLSCH, ZTERM, DMBTR, WRBTR, BLART, STATUS, BYPROV, DATEPROV, DATECOL, WWERT, TGL_KIRUKP, USER_UKP, STAT_VER, TGL_VER, TGL_KIRVER, TGL_KEMB_VER, USER_VER, STAT_BEND, TGL_BEND, TGL_KIRBEND, TGL_KEMB_BEN, USER_BEN, STAT_AKU, TGL_AKU, TGL_KEMB_AKU, U_NAME, AUGDT, STAT_REJ, NO_REJECT, STATUS_UKP, NYETATUS, EBELN, EBELP, MBELNR, MGJAHR, PROJK, PRCTR, HBKID, DBAYAR, TBAYAR, UBAYAR, DGROUP, TGROUP, UGROUP, LUKP, LVER, LBEN, LAKU, AWTYPE, AWKYE, LBEN2, MWSKZ, HWBAS, FWBAS, HWSTE, FWSTE, WT_QBSHH, WT_QBSHB ';
	 public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function get($venno) {
		$this->db->where('LIFNR' , $venno);
		$this->db->from($this->table);
		$result = $this->db->get();
		return (array) $result->result_array();
	}
	
	function emp($ptm,$mtp) {
		$this->db->from($this->table);
		$this->db->where('BELNR', $ptm);
		$this->db->where('GJAHR', $mtp);
		$result = $this->db->get();
		return (array)$result->result_array();
	}

	public function get_id() {
		$this->db->select_max($this->id, 'MAX');
		$max = $this->db->get($this->table)->row_array();
		return $max['MAX']+1;
	}
	
	public function insert_batch(){
		$this->db->insert_batch($this->table, $value3);
	}
	
	function insert_inv($data){
		$this->db->insert($this->table,$data);
	}
	
	function get_tahun($tahun){
		$this->db->where('GJAHR' , $tahun);
		$this->db->from($this->table);
		$result = $this->db->get();
		return (array) $result->result_array();
		
	}
	
	public function grid_view($q) {
		//$this->db->query($q);
		return $this->db->query($q);
	}
}

/* End of file modelName.php */
/* Location: ./application/models/modelName.php */
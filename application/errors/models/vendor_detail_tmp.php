<?php defined('BASEPATH') OR exit('No direct script access allowed');

class vendor_detail_tmp extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "TMP_VND_HEADER";
	}

	public function info_perusahaan($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_BOARD', 'TMP_VND_BOARD.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'left');
		$this->db->where('TMP_VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function prefix_sufix($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('M_VND_PREFIX', 'TMP_VND_HEADER.PREFIX = M_VND_PREFIX.PREFIX_ID', 'left');
		$this->db->join('M_VND_SUFFIX', 'TMP_VND_HEADER.SUFFIX = M_VND_SUFFIX.SUFFIX_ID', 'left');
		$this->db->where('TMP_VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function prefix_sufix_vnd($id) {
		$this->db->select("VENDOR_ID, PREFIX AS PREFIX_NAME, SUFFIX AS SUFFIX_NAME, EMAIL_ADDRESS");
		$this->db->from($this->table);
		$this->db->where('TMP_VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function alamat_perusahaan($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_ADDRESS', 'TMP_VND_ADDRESS.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'left');
		$this->db->where('TMP_VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function akta_pendirian($id) {
		$this->db->select('TMP_VND_AKTA.AKTA_ID, TMP_VND_AKTA.VENDOR_ID, TMP_VND_AKTA.AKTA_TYPE, TMP_VND_AKTA.AKTA_NO, TO_CHAR(TMP_VND_AKTA.DATE_CREATION, \'DD-MON-YYYY\') AS DATE_CREATION, TO_CHAR(TMP_VND_AKTA.PENGESAHAN_HAKIM, \'DD-MON-YYYY\') AS PENGESAHAN_HAKIM, TO_CHAR(TMP_VND_AKTA.BERITA_ACARA_NGR, \'DD-MON-YYYY\') AS BERITA_ACARA_NGR, TMP_VND_AKTA.NOTARIS_NAME, TMP_VND_AKTA.NOTARIS_ADDRESS, TMP_VND_AKTA.VENDOR_ID, TMP_VND_AKTA.DATE_CREATION, TMP_VND_AKTA.PENGESAHAN_HAKIM, TMP_VND_AKTA.BERITA_ACARA_NGR, TMP_VND_AKTA.AKTA_NO_DOC, TMP_VND_AKTA.PENGESAHAN_HAKIM_DOC, TMP_VND_AKTA.BERITA_ACARA_NGR_DOC', false);
		$this->db->from('TMP_VND_AKTA');
		$this->db->where('VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}


	public function domisili_perusahaan($id) {
		$this->db->select('TMP_VND_HEADER.VENDOR_ID,TMP_VND_HEADER.VENDOR_NAME,TMP_VND_HEADER.ADDRESS_STREET,TMP_VND_HEADER.ADDRESS_CITY,
							TMP_VND_HEADER.ADDRESS_POSTCODE,TMP_VND_HEADER.ADDRESS_DOMISILI_NO,TO_CHAR(TMP_VND_HEADER.ADDRESS_DOMISILI_DATE, \'DD-MON-YYYY\') AS DOMISILI_DATE,TO_CHAR(TMP_VND_HEADER.ADDRESS_DOMISILI_EXP_DATE, \'DD-MON-YYYY\') AS ADDRESS_DOMISILI_EXP_DATE,ADM_COUNTRY.COUNTRY_NAME,ADM_WILAYAH.NAMA AS PROPINSI, KOTA.NAMA AS KOTA, TMP_VND_HEADER.DOMISILI_NO_DOC, TMP_VND_HEADER.ADDRESS_COUNTRY,TMP_VND_HEADER.ADDRESS_CITY,TMP_VND_HEADER.ADDRES_PROP', false);
		$this->db->from($this->table);
		$this->db->join('ADM_COUNTRY', 'TMP_VND_HEADER.ADDRESS_COUNTRY = ADM_COUNTRY.COUNTRY_CODE', 'left');
		$this->db->join('ADM_WILAYAH', 'TMP_VND_HEADER.ADDRES_PROP = ADM_WILAYAH.ID', 'left');
		$this->db->join('ADM_WILAYAH KOTA', 'TMP_VND_HEADER.ADDRESS_CITY = KOTA.KODE', 'left');
		$this->db->where('TMP_VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function domisili_perusahaan_vnd($id) {
		$this->db->select('TMP_VND_HEADER.VENDOR_ID,TMP_VND_HEADER.VENDOR_NAME, TMP_VND_HEADER.ADDRESS_STREET, TMP_VND_HEADER.ADDRESS_CITY AS KOTA, TMP_VND_HEADER.ADDRESS_POSTCODE, TMP_VND_HEADER.ADDRES_PROP AS PROPINSI, TMP_VND_HEADER.ADDRESS_COUNTRY AS COUNTRY_NAME
			,TMP_VND_HEADER.ADDRESS_DOMISILI_NO,TO_CHAR(TMP_VND_HEADER.ADDRESS_DOMISILI_DATE, \'DD-MON-YYYY\') AS DOMISILI_DATE,TO_CHAR(TMP_VND_HEADER.ADDRESS_DOMISILI_EXP_DATE, \'DD-MON-YYYY\') AS ADDRESS_DOMISILI_EXP_DATE', false);
		$this->db->from($this->table);
		$this->db->where('TMP_VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	public function npwp($id) {
		$this->db->select('TMP_VND_HEADER.NPWP_ADDRESS,ADM_WILAYAH.NAMA AS KOTA,ADM_WILAYAH.KODE,TMP_VND_HEADER.NPWP_NO,TMP_VND_HEADER.NPWP_POSTCODE,TMP_VND_HEADER.NPWP_PROP,PRO.NAMA AS PROPINSI,TMP_VND_HEADER.NPWP_NO_DOC,TMP_VND_HEADER.NPWP_CITY');
		$this->db->from($this->table);
		$this->db->join('ADM_WILAYAH', 'TMP_VND_HEADER.NPWP_CITY = ADM_WILAYAH.KODE', 'left');
		$this->db->join('ADM_WILAYAH PRO', 'TMP_VND_HEADER.NPWP_PROP = PRO.ID', 'left');
		$this->db->where('TMP_VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function npwp_ven($id) {
		$this->db->select('TMP_VND_HEADER.NPWP_ADDRESS,TMP_VND_HEADER.NPWP_NO,TMP_VND_HEADER.NPWP_POSTCODE,TMP_VND_HEADER.NPWP_PROP AS PROPINSI, TMP_VND_HEADER.NPWP_CITY AS KOTA');
		$this->db->from($this->table);
		$this->db->where('TMP_VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	public function val_ven($id){
		$this->db->select('SIUP_NO,SIUP_TYPE,TO_CHAR(SIUP_FROM,  \'DD-MON-YYYY\') AS SIUP_FROM,TO_CHAR(SIUP_TO, \'DD-MON-YYYY\') AS SIUP_TO, SIUP_ISSUED_BY,TDP_ISSUED_BY,TO_CHAR(TDP_TO, \'DD-MON-YYYY\') AS TDP_TO, TDP_NO, TO_CHAR(TDP_FROM, \'DD-MON-YYYY\') AS TDP_FROM,API_ISSUED_BY,API_NO, TO_CHAR(API_FROM, \'DD-MON-YYYY\') AS API_FROM, TO_CHAR(API_TO, \'DD-MON-YYYY\') AS API_TO', false);
		$this->db->from($this->table);
		$this->db->where('VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	public function info_bank($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_BANK', 'TMP_VND_BANK.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('TMP_VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	public function fin($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_FIN_RPT', 'TMP_VND_FIN_RPT.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('TMP_VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function produk($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_PRODUCT', 'TMP_VND_PRODUCT.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('TMP_VND_PRODUCT.PRODUCT_TYPE LIKE \'%GOODS%\' AND TMP_VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function bahan($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_PRODUCT', 'TMP_VND_PRODUCT.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('TMP_VND_PRODUCT.PRODUCT_TYPE LIKE \'%BAHAN%\' AND TMP_VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function produk_jasa($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_PRODUCT', 'TMP_VND_PRODUCT.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('TMP_VND_PRODUCT.PRODUCT_TYPE LIKE \'%SERVICES%\' AND TMP_VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function info_komisaris($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_BOARD', 'TMP_VND_BOARD.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('TMP_VND_BOARD.TYPE LIKE \'%Commissioner%\' AND TMP_VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function info_director($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_BOARD', 'TMP_VND_BOARD.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('TMP_VND_BOARD.TYPE LIKE \'%Director%\' AND TMP_VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function sdm($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_SDM', 'TMP_VND_SDM.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('TMP_VND_SDM.TYPE LIKE \'%MAIN%\' AND TMP_VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	public function sdm_sp($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_SDM', 'TMP_VND_SDM.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('TMP_VND_SDM.TYPE LIKE \'%SUPPORT%\' AND TMP_VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function certifications($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_CERT', 'TMP_VND_CERT.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('TMP_VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function equipment($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_EQUIP', 'TMP_VND_EQUIP.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('TMP_VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function experience($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_CV', 'TMP_VND_CV.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('TMP_VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function pricipal($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_ADD', 'TMP_VND_ADD.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('TMP_VND_ADD.TYPE LIKE \'%Principal%\' AND TMP_VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function subcontractor($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_ADD', 'TMP_VND_ADD.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('TMP_VND_ADD.TYPE LIKE \'%Subcontractor%\' AND TMP_VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	public function affiliation($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('TMP_VND_ADD', 'TMP_VND_ADD.VENDOR_ID = TMP_VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('TMP_VND_ADD.TYPE LIKE \'%Affiliation Company%\' AND TMP_VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}	
}
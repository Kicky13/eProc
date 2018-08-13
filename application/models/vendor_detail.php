<?php defined('BASEPATH') OR exit('No direct script access allowed');

class vendor_detail extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = "VND_HEADER";
	}

	public function info_perusahaan($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_BOARD', 'VND_BOARD.VENDOR_ID = VND_HEADER.VENDOR_ID', 'left');
		$this->db->where('VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function get_vendor($whereopco) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('VND_HEADER.COMPANYID IN ('.$whereopco.')');
		$this->db->where('VND_HEADER.STATUS', 3);
		$this->db->where('VND_HEADER.VENDOR_NO IS NOT NULL');
		$result = $this->db->get();
		return $result->result_array();
	}


	public function prefix_sufix($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('M_VND_PREFIX', 'VND_HEADER.PREFIX = M_VND_PREFIX.PREFIX_ID', 'left');
		$this->db->join('M_VND_SUFFIX', 'VND_HEADER.SUFFIX = M_VND_SUFFIX.SUFFIX_ID', 'left');
		$this->db->where('VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function prefix_sufix_vnd($id) {
		$this->db->select("VENDOR_ID, PREFIX AS PREFIX_NAME, SUFFIX AS SUFFIX_NAME, EMAIL_ADDRESS");
		$this->db->from($this->table);
		$this->db->where('VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function alamat_perusahaan($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_ADDRESS', 'VND_ADDRESS.VENDOR_ID = VND_HEADER.VENDOR_ID', 'left');
		$this->db->where('VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function akta_pendirian($id) {
		$this->db->select('VND_AKTA.AKTA_ID, VND_AKTA.VENDOR_ID, VND_AKTA.AKTA_TYPE, VND_AKTA.AKTA_NO, TO_CHAR(VND_AKTA.DATE_CREATION, \'DD-MON-YYYY\') AS DATE_CREATION, TO_CHAR(VND_AKTA.PENGESAHAN_HAKIM, \'DD-MON-YYYY\') AS PENGESAHAN_HAKIM, TO_CHAR(VND_AKTA.BERITA_ACARA_NGR, \'DD-MON-YYYY\') AS BERITA_ACARA_NGR, VND_AKTA.NOTARIS_NAME, VND_AKTA.NOTARIS_ADDRESS, VND_AKTA.VENDOR_ID, VND_AKTA.DATE_CREATION, VND_AKTA.PENGESAHAN_HAKIM, VND_AKTA.BERITA_ACARA_NGR, VND_AKTA.AKTA_NO_DOC, VND_AKTA.PENGESAHAN_HAKIM_DOC, VND_AKTA.BERITA_ACARA_NGR_DOC, VND_AKTA.MODIFIED_DATE', false);
		$this->db->from('VND_AKTA');
		$this->db->where('VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}


	public function domisili_perusahaan($id) {
		$this->db->select('VND_HEADER.VENDOR_ID,VND_HEADER.VENDOR_NAME,VND_HEADER.ADDRESS_STREET,VND_HEADER.ADDRESS_CITY,
			VND_HEADER.ADDRESS_POSTCODE,VND_HEADER.ADDRESS_DOMISILI_NO,TO_CHAR(VND_HEADER.ADDRESS_DOMISILI_DATE, \'DD-MON-YYYY\') AS DOMISILI_DATE,TO_CHAR(VND_HEADER.ADDRESS_DOMISILI_EXP_DATE, \'DD-MON-YYYY\') AS ADDRESS_DOMISILI_EXP_DATE,ADM_COUNTRY.COUNTRY_NAME,ADM_WILAYAH.NAMA AS PROPINSI, KOTA.NAMA AS KOTA, VND_HEADER.DOMISILI_NO_DOC, VND_HEADER.ADDRESS_COUNTRY,VND_HEADER.ADDRESS_CITY,VND_HEADER.ADDRES_PROP', false);
		$this->db->from($this->table);
		$this->db->join('ADM_COUNTRY', 'VND_HEADER.ADDRESS_COUNTRY = ADM_COUNTRY.COUNTRY_CODE', 'left');
		$this->db->join('ADM_WILAYAH', 'VND_HEADER.ADDRES_PROP = ADM_WILAYAH.ID', 'left');
		$this->db->join('ADM_WILAYAH KOTA', 'VND_HEADER.ADDRESS_CITY = KOTA.KODE', 'left');
		$this->db->where('VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function domisili_perusahaan_vnd($id) {
		$this->db->select('VND_HEADER.VENDOR_ID,VND_HEADER.VENDOR_NAME, VND_HEADER.ADDRESS_STREET, VND_HEADER.ADDRESS_CITY, VND_HEADER.ADDRESS_POSTCODE, VND_HEADER.ADDRES_PROP, VND_HEADER.ADDRESS_COUNTRY
			,VND_HEADER.ADDRESS_DOMISILI_NO,TO_CHAR(VND_HEADER.ADDRESS_DOMISILI_DATE, \'DD-MON-YYYY\') AS DOMISILI_DATE,TO_CHAR(VND_HEADER.ADDRESS_DOMISILI_EXP_DATE, \'DD-MON-YYYY\') AS ADDRESS_DOMISILI_EXP_DATE', false);
		$this->db->from($this->table);
		$this->db->where('VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	public function npwp($id) {
		$this->db->select('VND_HEADER.NPWP_ADDRESS,ADM_WILAYAH.NAMA AS KOTA,ADM_WILAYAH.KODE,VND_HEADER.NPWP_NO,VND_HEADER.NPWP_POSTCODE,VND_HEADER.NPWP_PROP,PRO.NAMA AS PROPINSI,VND_HEADER.NPWP_NO_DOC,VND_HEADER.NPWP_CITY');
		$this->db->from($this->table);
		$this->db->join('ADM_WILAYAH', 'VND_HEADER.NPWP_CITY = ADM_WILAYAH.KODE', 'left');
		$this->db->join('ADM_WILAYAH PRO', 'VND_HEADER.NPWP_PROP = PRO.ID', 'left');
		$this->db->where('VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function npwp_ven($id) {
		$this->db->select('VND_HEADER.NPWP_ADDRESS,VND_HEADER.NPWP_NO,VND_HEADER.NPWP_POSTCODE,VND_HEADER.NPWP_PROP AS PROPINSI, VND_HEADER.NPWP_CITY AS KOTA');
		$this->db->from($this->table);
		$this->db->where('VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	public function val_ven($id){
		$this->db->select('SIUP_NO,SIUP_NO_DOC,SIUP_TYPE,TO_CHAR(SIUP_FROM,  \'DD-MON-YYYY\') AS SIUP_FROM,TO_CHAR(SIUP_TO, \'DD-MON-YYYY\') AS SIUP_TO, SIUP_ISSUED_BY,TDP_ISSUED_BY,TO_CHAR(TDP_TO, \'DD-MON-YYYY\') AS TDP_TO, TDP_NO, TDP_NO_DOC, TO_CHAR(TDP_FROM, \'DD-MON-YYYY\') AS TDP_FROM,API_ISSUED_BY,API_NO, TO_CHAR(API_FROM, \'DD-MON-YYYY\') AS API_FROM, TO_CHAR(API_TO, \'DD-MON-YYYY\') AS API_TO', false);
		$this->db->from($this->table);
		$this->db->where('VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function info_bank($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_BANK', 'VND_BANK.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	public function fin($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_FIN_RPT', 'VND_FIN_RPT.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function produk($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_PRODUCT', 'VND_PRODUCT.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_PRODUCT.PRODUCT_TYPE LIKE \'%GOODS%\' AND VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function produkAll($opco) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_PRODUCT', 'VND_PRODUCT.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_PRODUCT.PRODUCT_TYPE LIKE \'%GOODS%\' AND VND_HEADER.COMPANYID '.$opco);
		$result = $this->db->get();
		return $result->result_array();
	}
	public function bahanAll($opco) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_PRODUCT', 'VND_PRODUCT.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_PRODUCT.PRODUCT_TYPE LIKE \'%BAHAN%\' AND VND_HEADER.COMPANYID '.$opco);
		$result = $this->db->get();
		return $result->result_array();
	}
	public function produk_jasaAll($opco) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_PRODUCT', 'VND_PRODUCT.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_PRODUCT.PRODUCT_TYPE LIKE \'%SERVICES%\' AND VND_HEADER.COMPANYID '.$opco);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function bahan($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_PRODUCT', 'VND_PRODUCT.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_PRODUCT.PRODUCT_TYPE LIKE \'%BAHAN%\' AND VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function produk_jasa($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_PRODUCT', 'VND_PRODUCT.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_PRODUCT.PRODUCT_TYPE LIKE \'%SERVICES%\' AND VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function info_komisaris($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_BOARD', 'VND_BOARD.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_BOARD.TYPE LIKE \'%Commissioner%\' AND VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function info_director($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_BOARD', 'VND_BOARD.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_BOARD.TYPE LIKE \'%Director%\' AND VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function sdm($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_SDM', 'VND_SDM.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_SDM.TYPE LIKE \'%MAIN%\' AND VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	public function sdm_sp($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_SDM', 'VND_SDM.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_SDM.TYPE LIKE \'%SUPPORT%\' AND VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function certifications($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_CERT', 'VND_CERT.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function equipment($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_EQUIP', 'VND_EQUIP.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function experience($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_CV', 'VND_CV.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_HEADER.VENDOR_ID', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function pricipal($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_ADD', 'VND_ADD.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_ADD.TYPE LIKE \'%Principal%\' AND VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function subcontractor($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_ADD', 'VND_ADD.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_ADD.TYPE LIKE \'%Subcontractor%\' AND VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	public function affiliation($id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join('VND_ADD', 'VND_ADD.VENDOR_ID = VND_HEADER.VENDOR_ID', 'inner');
		$this->db->where('VND_ADD.TYPE LIKE \'%Affiliation Company%\' AND VND_HEADER.VENDOR_ID =', $id);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function vnd_table_prod_all($prod){
		
		if ($prod == '1') { // GOODS
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO,vh.STATUS, vh.EMAIL_ADDRESS, vh.STATUS_PERUBAHAN, vh.COMPANYID from vnd_header vh inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VP on vh.VENDOR_ID=VP.vendor_id where vh.VENDOR_ID not in(select vd.vendor_id from vnd_header vd inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.vendor_id=vd.vendor_id inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vd.vendor_id) order by vh.VENDOR_NO', false);
		} elseif ($prod == '2') { // SERVICE
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO ,vh.STATUS, vh.EMAIL_ADDRESS, vh.STATUS_PERUBAHAN, vh.COMPANYID from vnd_header vh inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VP on vh.VENDOR_ID=VP.vendor_id where vh.VENDOR_ID not in(select vd.vendor_id from vnd_header vd inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.vendor_id=vd.vendor_id inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vd.vendor_id) order by vh.VENDOR_NO', false);
		} elseif ($prod == '3') { //S N G
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO, vh.STATUS, vh.EMAIL_ADDRESS, vh.STATUS_PERUBAHAN, vh.COMPANYID from vnd_header vh inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.VENDOR_ID=vh.VENDOR_ID inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vh.VENDOR_ID order by vh.VENDOR_NO', false);
		} else{
			$this->db->select('VENDOR_ID, VENDOR_NAME, VENDOR_NO, STATUS, EMAIL_ADDRESS, STATUS_PERUBAHAN, COMPANYID FROM VND_HEADER ORDER BY VENDOR_NO', false);
		}

		
		$result = $this->db->get();
		return $result->result_array(); 
	}

	public function tmp_table_prod_all($prod){
 		
		if ($prod == '1') { // GOODS
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO,vh.STATUS, vh.EMAIL_ADDRESS, vh.COMPANYID from tmp_vnd_header vh inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VP on vh.VENDOR_ID=VP.vendor_id where vh.VENDOR_ID not in(select vd.vendor_id from tmp_vnd_header vd inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.vendor_id=vd.vendor_id inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vd.vendor_id) order by vh.VENDOR_NO', false);
		} elseif ($prod == '2') { // SERVICE
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO ,vh.STATUS, vh.EMAIL_ADDRESS, vh.COMPANYID from tmp_vnd_header vh inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VP on vh.VENDOR_ID=VP.vendor_id where vh.VENDOR_ID not in(select vd.vendor_id from tmp_vnd_header vd inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.vendor_id=vd.vendor_id inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vd.vendor_id) order by vh.VENDOR_NO', false);
		} elseif ($prod == '3') { //S N G
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO, vh.STATUS, vh.EMAIL_ADDRESS, vh.COMPANYID from tmp_vnd_header vh inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.VENDOR_ID=vh.VENDOR_ID inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vh.VENDOR_ID order by vh.VENDOR_NO', false);
		} else{
			$this->db->select('VENDOR_ID, VENDOR_NAME, VENDOR_NO, STATUS, EMAIL_ADDRESS, COMPANYID FROM TMP_VND_HEADER ORDER BY VENDOR_NO', false);
		}

		
		$result = $this->db->get();
		return $result->result_array(); 
	}	

	public function vnd_table_prod($prod,$opco){
		if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
			$opco = 'IN(\'7000\',\'2000\',\'5000\')';
		} else {
			$opco = '='.$opco.'';
		} 
		
		if ($prod == '1') { // GOODS
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO,vh.STATUS, vh.EMAIL_ADDRESS, vh.STATUS_PERUBAHAN, vh.COMPANYID from vnd_header vh inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VP on vh.VENDOR_ID=VP.vendor_id where vh.VENDOR_ID not in(select vd.vendor_id from vnd_header vd inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.vendor_id=vd.vendor_id inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vd.vendor_id) and vh.COMPANYID '.$opco.' order by vh.VENDOR_NO', false);
		} elseif ($prod == '2') { // SERVICE
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO ,vh.STATUS, vh.EMAIL_ADDRESS, vh.STATUS_PERUBAHAN, vh.COMPANYID from vnd_header vh inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VP on vh.VENDOR_ID=VP.vendor_id where vh.VENDOR_ID not in(select vd.vendor_id from vnd_header vd inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.vendor_id=vd.vendor_id inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vd.vendor_id)  and vh.COMPANYID '.$opco.' order by vh.VENDOR_NO', false);
		} elseif ($prod == '3') { //S N G
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO, vh.STATUS, vh.EMAIL_ADDRESS, vh.STATUS_PERUBAHAN, vh.COMPANYID from vnd_header vh inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.VENDOR_ID=vh.VENDOR_ID inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vh.VENDOR_ID  where vh.COMPANYID '.$opco.' order by vh.VENDOR_NO', false);
		} else{
			$this->db->select('VENDOR_ID, VENDOR_NAME, VENDOR_NO, STATUS, EMAIL_ADDRESS, STATUS_PERUBAHAN, COMPANYID FROM VND_HEADER WHERE COMPANYID '.$opco.' ORDER BY VENDOR_NO', false);
		}

		
		$result = $this->db->get();
		return $result->result_array(); 
	}

	public function tmp_table_prod($prod,$opco){

		if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
			$opco = 'IN(\'7000\',\'2000\',\'5000\')';
		}  else {
			$opco = '='.$opco.'';
		} 
		
		
		if ($prod == '1') { // GOODS
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO,vh.STATUS, vh.EMAIL_ADDRESS, vh.COMPANYID from tmp_vnd_header vh inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VP on vh.VENDOR_ID=VP.vendor_id where vh.VENDOR_ID not in(select vd.vendor_id from tmp_vnd_header vd inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.vendor_id=vd.vendor_id inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vd.vendor_id) and vh.COMPANYID '.$opco.' order by vh.VENDOR_NO', false);
		} elseif ($prod == '2') { // SERVICE
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO ,vh.STATUS, vh.EMAIL_ADDRESS, vh.COMPANYID from tmp_vnd_header vh inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VP on vh.VENDOR_ID=VP.vendor_id where vh.VENDOR_ID not in(select vd.vendor_id from tmp_vnd_header vd inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.vendor_id=vd.vendor_id inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vd.vendor_id) and vh.COMPANYID '.$opco.' order by vh.VENDOR_NO', false);
		} elseif ($prod == '3') { //S N G
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO, vh.STATUS, vh.EMAIL_ADDRESS, vh.COMPANYID from tmp_vnd_header vh inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.VENDOR_ID=vh.VENDOR_ID inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vh.VENDOR_ID  where vh.COMPANYID '.$opco.' order by vh.VENDOR_NO', false);
		} else{
			$this->db->select('VENDOR_ID, VENDOR_NAME, VENDOR_NO, STATUS, EMAIL_ADDRESS, COMPANYID FROM TMP_VND_HEADER WHERE COMPANYID '.$opco.' ORDER BY VENDOR_NO', false);
		}

		
		$result = $this->db->get();
		return $result->result_array(); 
	}

	public function cetak_vnd_table_prod($opco,$no,$name,$update,$reg,$email,$produk){
		if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
			$opco = 'IN(\'7000\',\'2000\',\'5000\')';
		}  else {
			$opco = '='.$opco.'';
		}
		
		if ($produk == '1') { // GOODS
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO,vh.STATUS, vh.EMAIL_ADDRESS, vh.STATUS_PERUBAHAN, vh.COMPANYID from vnd_header vh inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VP on vh.VENDOR_ID=VP.vendor_id where vh.VENDOR_ID not in(select vd.vendor_id from vnd_header vd inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.vendor_id=vd.vendor_id inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vd.vendor_id) and vh.COMPANYID '.$opco.' and (vh.VENDOR_NO LIKE \'%'.$no.'%\' OR vh.VENDOR_NAME LIKE \'%'.$name.'%\' OR vh.STATUS_PERUBAHAN LIKE \'%'.$update.'%\' OR vh.STATUS LIKE \'%'.$reg.'%\' OR vh.EMAIL_ADDRESS LIKE \'%'.$email.'%\') order by vh.VENDOR_NO', false);
		} elseif ($produk == '2') { // SERVICE
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO ,vh.STATUS, vh.EMAIL_ADDRESS, vh.STATUS_PERUBAHAN, vh.COMPANYID from vnd_header vh inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VP on vh.VENDOR_ID=VP.vendor_id where vh.VENDOR_ID not in(select vd.vendor_id from vnd_header vd inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.vendor_id=vd.vendor_id inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vd.vendor_id)  and vh.COMPANYID '.$opco.' and (vh.VENDOR_NO LIKE \'%'.$no.'%\' OR vh.VENDOR_NAME LIKE \'%'.$name.'%\' OR vh.STATUS_PERUBAHAN LIKE \'%'.$update.'%\' OR vh.STATUS LIKE \'%'.$reg.'%\' OR vh.EMAIL_ADDRESS LIKE \'%'.$email.'%\') order by vh.VENDOR_NO', false);
		} elseif ($produk == '3') { //S N G
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO, vh.STATUS, vh.EMAIL_ADDRESS, vh.STATUS_PERUBAHAN, vh.COMPANYID from vnd_header vh inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.VENDOR_ID=vh.VENDOR_ID inner join (select vendor_id from vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vh.VENDOR_ID  where vh.COMPANYID '.$opco.' and (vh.VENDOR_NO LIKE \'%'.$no.'%\' OR vh.VENDOR_NAME LIKE \'%'.$name.'%\' OR vh.STATUS_PERUBAHAN LIKE \'%'.$update.'%\' OR vh.STATUS LIKE \'%'.$reg.'%\' OR vh.EMAIL_ADDRESS LIKE \'%'.$email.'%\') order by vh.VENDOR_NO', false);
		} else{
			$this->db->select('VENDOR_ID, VENDOR_NAME, VENDOR_NO, STATUS, EMAIL_ADDRESS, STATUS_PERUBAHAN, COMPANYID FROM VND_HEADER WHERE COMPANYID '.$opco.' AND (VENDOR_NO LIKE \'%'.$no.'%\' OR VENDOR_NAME LIKE \'%'.$name.'%\' OR STATUS_PERUBAHAN LIKE \'%'.$update.'%\' OR STATUS LIKE \'%'.$reg.'%\' OR EMAIL_ADDRESS LIKE \'%'.$email.'%\') ORDER BY VENDOR_NO', false);
		}

		
		$result = $this->db->get();
		return $result->result_array(); 
	}

	public function cetak_tmp_table_prod($opco,$no,$name,$reg,$email,$produk){

		if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
			$opco = 'IN(\'7000\',\'2000\',\'5000\')';
		} else {
			$opco = '='.$opco.'';
		}
		
		if ($produk == '1') { // GOODS
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO,vh.STATUS, vh.EMAIL_ADDRESS, vh.COMPANYID from tmp_vnd_header vh inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VP on vh.VENDOR_ID=VP.vendor_id where vh.VENDOR_ID not in(select vd.vendor_id from tmp_vnd_header vd inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.vendor_id=vd.vendor_id inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vd.vendor_id) and vh.COMPANYID '.$opco.' and (vh.VENDOR_NO LIKE \'%'.$no.'%\' OR vh.VENDOR_NAME LIKE \'%'.$name.'%\' OR vh.STATUS LIKE \'%'.$reg.'%\' OR vh.EMAIL_ADDRESS LIKE \'%'.$email.'%\') order by vh.VENDOR_NO', false);
		} elseif ($produk == '2') { // SERVICE
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO ,vh.STATUS, vh.EMAIL_ADDRESS, vh.COMPANYID from tmp_vnd_header vh inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VP on vh.VENDOR_ID=VP.vendor_id where vh.VENDOR_ID not in(select vd.vendor_id from tmp_vnd_header vd inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.vendor_id=vd.vendor_id inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vd.vendor_id) and vh.COMPANYID '.$opco.' and (vh.VENDOR_NO LIKE \'%'.$no.'%\' OR vh.VENDOR_NAME LIKE \'%'.$name.'%\' OR vh.STATUS LIKE \'%'.$reg.'%\' OR vh.EMAIL_ADDRESS LIKE \'%'.$email.'%\') order by vh.VENDOR_NO', false);
		} elseif ($produk == '3') { //S N G
			$this->db->select('vh.VENDOR_ID,vh.VENDOR_NAME,vh.VENDOR_NO, vh.STATUS, vh.EMAIL_ADDRESS, vh.COMPANYID from tmp_vnd_header vh inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'SERVICES\' group by vendor_id) VS on VS.VENDOR_ID=vh.VENDOR_ID inner join (select vendor_id from tmp_vnd_product where PRODUCT_TYPE = \'GOODS\' group by vendor_id) VG on VG.vendor_id=vh.VENDOR_ID  where vh.COMPANYID '.$opco.' and (vh.VENDOR_NO LIKE \'%'.$no.'%\' OR vh.VENDOR_NAME LIKE \'%'.$name.'%\' OR vh.STATUS LIKE \'%'.$reg.'%\' OR vh.EMAIL_ADDRESS LIKE \'%'.$email.'%\') order by vh.VENDOR_NO', false);
		} else{
			$this->db->select('VENDOR_ID, VENDOR_NAME, VENDOR_NO, STATUS, EMAIL_ADDRESS, COMPANYID FROM TMP_VND_HEADER WHERE COMPANYID '.$opco.' AND (VENDOR_NO LIKE \'%'.$no.'%\' OR VENDOR_NAME LIKE \'%'.$name.'%\' OR STATUS LIKE \'%'.$reg.'%\' OR EMAIL_ADDRESS LIKE \'%'.$email.'%\')  ORDER BY VENDOR_NO', false);
		}

		
		$result = $this->db->get();
		return $result->result_array(); 
	}

	public function get_vendor_jasa($vendor_no,$opco) {
		if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
			$whereopco = '7000,2000,5000';
		} else {
			$whereopco = $opco;
		}

		$this->db->select("VENDOR_ID, VENDOR_NO, COMPANYID, VENDOR_NAME");
		$this->db->from($this->table);
		$this->db->where('VND_HEADER.COMPANYID IN ('.$whereopco.')');
		$this->db->where('VND_HEADER.VENDOR_NO', $vendor_no);
		$this->db->where('VND_HEADER.STATUS', 3);
		$this->db->where('VND_HEADER.VENDOR_NO IS NOT NULL');
		$result = $this->db->get();
		return $result->result_array();
	}
}
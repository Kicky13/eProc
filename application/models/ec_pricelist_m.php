<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_pricelist_m extends CI_Model {
	protected $table = 'EC_T_CONTRACT', $tableCart = 'EC_T_CHART', $tableVendor = 'VND_HEADER', $tablePrincipal = 'EC_PRINCIPAL_MANUFACTURER', $tableEC_R1 = 'EC_R1', $tableStrategic = 'EC_M_STRATEGIC_MATERIAL', $tableCompare = 'EC_T_PERBANDINGAN', $tablePricelist = 'EC_PRICELIST_OFFER', $MasterCurrency = 'ADM_CURR';
	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	public function get_data_checkout($ID_USER) {
		$this -> db -> from($this -> table);
		$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
		$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
		$this -> db -> join($this -> tableCart, 'EC_T_CHART.MATNO=EC_T_CONTRACT.matno AND EC_T_CHART.CONTRACT_NO=EC_T_CONTRACT."contract_no"', 'left');
		$this -> db -> where("published", '1', TRUE);
		$this -> db -> where("ID_USER", $ID_USER, TRUE);
		$this -> db -> where("EC_T_CHART.BUYONE !=", '1', TRUE);
		// $this -> db -> where("EC_T_CHART.STATUS_CHART !=", '9', TRUE);
		$this -> db -> where("(EC_T_CHART.STATUS_CHART ='8' OR EC_T_CHART.STATUS_CHART ='0' ) ");
		$this -> db -> order_by('"contract_no"', 'ASC');
		// $this -> db -> or_where("EC_T_CHART.STATUS_CHART ", '8', TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	function POsuccessOne($id, $cont, $mat, $kmbl) {
		$this -> db -> where("ID_USER", $id, TRUE);
		$this -> db -> where("CONTRACT_NO", $cont, TRUE);
		$this -> db -> where("MATNO", $mat, TRUE);
		$this -> db -> where("STATUS_CHART", '0', TRUE);
		$this -> db -> where("BUYONE", '1', TRUE);
		$kmbl = explode('Standard PO created under the number ', $kmbl);
		$this -> db -> update($this -> tableCart, array('STATUS_CHART' => '1', 'PO_NO' => $kmbl[1]));
	}

	function POsuccess($data, $kmbl) {
		$this -> db -> where("ID_USER", $data, TRUE);
		$this -> db -> where("STATUS_CHART", '0', TRUE);
		$kmbl = explode('Standard PO created under the number ', $kmbl);
		$this -> db -> update($this -> tableCart, array('STATUS_CHART' => '1', 'PO_NO' => $kmbl[1]));
	}

	public function get_data_checkout_PO($ID_USER) {
		$this -> db -> from($this -> table);
		//EC_T_CONTRACT
		$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
		$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
		$this -> db -> join($this -> tableCart, 'EC_T_CHART.MATNO=EC_T_CONTRACT.matno AND EC_T_CHART.CONTRACT_NO=EC_T_CONTRACT."contract_no"', 'left');
		$this -> db -> where("published", '1', TRUE);
		$this -> db -> where("ID_USER", $ID_USER, TRUE);
		$this -> db -> where("EC_T_CHART.STATUS_CHART ", '0', TRUE);
		// $this -> db -> order_by('matno', 'ASC');
		// $this -> db -> or_where("EC_T_CHART.STATUS_CHART ", '8', TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_data_checkout_PO_One($ID_USER, $contract_no, $matno) {
		$this -> db -> from($this -> table);
		//EC_T_CONTRACT
		$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
		$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
		$this -> db -> join($this -> tableCart, 'EC_T_CHART.MATNO=EC_T_CONTRACT.matno AND EC_T_CHART.CONTRACT_NO=EC_T_CONTRACT."contract_no"', 'left');
		$this -> db -> where("published", '1', TRUE);
		$this -> db -> where("ID_USER", $ID_USER, TRUE);
		$this -> db -> where('EC_T_CONTRACT."contract_no"', $contract_no, TRUE);
		$this -> db -> where('EC_T_CONTRACT.matno', $matno, TRUE);
		$this -> db -> where("EC_T_CHART.STATUS_CHART ", '0', TRUE);
		$this -> db -> where("EC_T_CHART.BUYONE ", '1', TRUE);
		// $this -> db -> order_by('matno', 'ASC');
		// $this -> db -> or_where("EC_T_CHART.STATUS_CHART ", '8', TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_data_harga($min, $max, $minLim = 0, $maxLim = 10) {
		if ($minLim == 0) {
			$this -> db -> limit(11);
		} else
			$this -> db -> where("ROWNUM <=", $maxLim, false);

		$this -> db -> from($this -> table);
		$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
		$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
		$this -> db -> join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'left');
		$this -> db -> where('published =1 and "netprice" >=' . $min . ' and "netprice" <=' . $max . '');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_data_tag($kode, $min = 0, $max = 10) {
		if ($min == 0) {
			$this -> db -> limit(11);
		} else
			$this -> db -> where("ROWNUM <=", $max, false);

		$this -> db -> from($this -> table);
		$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
		$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
		$this -> db -> join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'left');
		$this -> db -> where('published =1 and (lower(TAG) like lower(\'%' . $kode . '%\') OR lower(MAKTX) like lower(\'%' . $kode . '%\') OR lower("vendorname") like lower(\'%' . $kode . '%\'))');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_data_category($kode, $min = 0, $max = 10) {
		if ($min == 0) {
			$this -> db -> limit(11);
		} else
			$this -> db -> where("ROWNUM <=", $max, false);

		$this -> db -> from($this -> table);
		$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
		$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
		$this -> db -> join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'left');
		$this -> db -> where('published =1 and KODE_USER like \'' . $kode . '%\'');
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get_MasterCurrency() {
		//if ($mins == 0) {
		//	$this -> db -> limit(11);
		//} else
		//	$this -> db -> where("ROWNUM <=", $max, false);

		$this -> db -> from($this -> MasterCurrency);
		//$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
		//$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
		//$this -> db -> join('EC_PRICELIST_OFFER', 'EC_M_STRATEGIC_MATERIAL.MATNR = EC_PRICELIST_OFFER.MATNO', 'left');
		//$this -> db -> where("PUBLISHED_PRICELIST", '1', TRUE);
		//$this -> db -> where("PUBLISHED_PRICELIST", '1', TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function get($mins = 0, $max = 10) {
		//if ($mins == 0) {
		//	$this -> db -> limit(11);
		//} else
		//	$this -> db -> where("ROWNUM <=", $max, false);

		$this -> db -> from($this -> tableStrategic);
		//$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
		//$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
		//$this -> db -> join('EC_PRICELIST_OFFER', 'EC_M_STRATEGIC_MATERIAL.MATNR = EC_PRICELIST_OFFER.MATNO', 'left');
		$this -> db -> where("PUBLISHED_PRICELIST", '1', TRUE);
		//$this -> db -> where("PUBLISHED_PRICELIST", '1', TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getPricelist($vendorid) {
		//if ($mins == 0) {
		//	$this -> db -> limit(11);
		//} else
		//	$this -> db -> where("ROWNUM <=", $max, false);

		$this -> db -> from($this -> tablePricelist);
		//$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
		//$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
		//$this -> db -> join('EC_PRICELIST_OFFER', 'EC_M_STRATEGIC_MATERIAL.MATNR = EC_PRICELIST_OFFER.MATNO', 'left');
		$this -> db -> where("VENDOR_ID", $vendorid, TRUE);
		//$this -> db -> where("PUBLISHED_PRICELIST", '1', TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getVendor($vendorno) {
		$this -> db -> from($this -> tableVendor);
		$this -> db -> join('ADM_WILAYAH', 'VND_HEADER.ADDRESS_CITY = ADM_WILAYAH.ID', 'left');
		$this -> db -> join('ADM_COUNTRY', 'VND_HEADER.ADDRESS_COUNTRY = ADM_COUNTRY.COUNTRY_CODE', 'left');
		$this -> db -> where("VENDOR_NO", $vendorno, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getPrincipal($PC_CODE) {
		$this -> db -> from($this -> tablePrincipal);
		//$this -> db -> join('ADM_WILAYAH', 'VND_HEADER.ADDRESS_CITY = ADM_WILAYAH.ID', 'left');
		//$this -> db -> join('ADM_COUNTRY', 'VND_HEADER.ADDRESS_COUNTRY = ADM_COUNTRY.COUNTRY_CODE', 'left');
		$this -> db -> where("PC_CODE", $PC_CODE, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function hapus_compare($id = '', $matno, $kontrak) {
		$this -> db -> where("MATNO", $matno, TRUE);
		$this -> db -> where("ID_USER", $id, TRUE);
		$this -> db -> where("CONTRACT_NO", $kontrak, TRUE);
		$this -> db -> delete($this -> tableCompare);
	}

	function deleteCart($data) {
		$this -> db -> where("ID_CHART", $data, TRUE);
		$this -> db -> delete($this -> tableCart);
	}

	function cancelCart($data) {
		$this -> db -> where("ID_CHART", $data, TRUE);
		$this -> db -> update($this -> tableCart, array('STATUS_CHART' => '8'));
	}

	function plsqtyCart($data) {
		$this -> db -> set('QTY', 'QTY+1', FALSE);
		$this -> db -> where("ID_CHART", $data, TRUE);
		$this -> db -> update($this -> tableCart);
	}

	function minqtyCart($data) {
		$this -> db -> set('QTY', 'QTY+(-1)', FALSE);
		$this -> db -> where("ID_CHART", $data, TRUE);
		$this -> db -> update($this -> tableCart);
	}

	function updQtyCart($id, $qty) {
		$this -> db -> set('QTY', $qty, FALSE);
		$this -> db -> where("ID_CHART", $id, TRUE);
		$this -> db -> update($this -> tableCart);
	}

	function readdCart($data) {
		$this -> db -> where("ID_CHART", $data, TRUE);
		$this -> db -> update($this -> tableCart, array('STATUS_CHART' => '0'));
	}

	function rangeHarga($data) {
		$this -> db -> select('MAX("netprice") max,MIN("netprice") min');
		$this -> db -> where("published", "1", TRUE);
		$this -> db -> from($this -> table);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	function insert($data) {
		$this -> db -> insert($this -> table, $data);
	}



	public function getPartner($PC_CODE) {
		$this -> db -> from($this -> tableEC_R1);
		$this -> db -> join('VND_HEADER', 'VND_HEADER.VENDOR_NO = EC_R1.VENDOR_ID', 'left');
		//$this -> db -> join('ADM_COUNTRY', 'VND_HEADER.ADDRESS_COUNTRY = ADM_COUNTRY.COUNTRY_CODE', 'left');
		$this -> db -> where("PC_CODE", $PC_CODE, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getKategoriProduk($kode) {
		$this -> db -> from($this -> tableStrategic);
		$this -> db -> join('EC_T_CONTRACT', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
		$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
		$this -> db -> join('EC_M_CATEGORY', 'EC_M_STRATEGIC_MATERIAL.ID_CAT = EC_M_CATEGORY.ID_CAT', 'left');
		//$this -> db -> join('ADM_COUNTRY', 'VND_HEADER.ADDRESS_COUNTRY = ADM_COUNTRY.COUNTRY_CODE', 'left');
		$this -> db -> where("KODE_USER like '" . $kode . "%' and published='1'");
		//$this -> db -> where("published", '1', TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	public function getPebandingan($id_user) {
		$this -> db -> from($this -> tableCompare);
		$this -> db -> join('EC_T_CONTRACT', 'EC_T_CONTRACT.contract_no=EC_T_PERBANDINGAN.CONTRACT_NO AND EC_T_CONTRACT."matno"=EC_T_PERBANDINGAN.MATNO', 'left');
		$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_M_STRATEGIC_MATERIAL.MATNR = EC_T_CONTRACT.matno', 'left');
		$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
		$this -> db -> join('EC_PRINCIPAL_MANUFACTURER', 'EC_PRINCIPAL_MANUFACTURER.PC_CODE = EC_R1.PC_CODE', 'left');
		$this -> db -> where("EC_T_PERBANDINGAN.ID_USER", $id_user, TRUE);
		$this -> db -> where("EC_T_CONTRACT.published", "1", TRUE);
		//$this -> db -> where("published", '1', TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	function getLongteks($ptm) {
		// $this -> db -> from($this -> table);
		// $this -> db -> where('MATNR', $ptm);
		// $result = $this -> db -> get();

		// if ($result -> num_rows() > 1) {
		$SQL = "SELECT SUBSTR (SYS_CONNECT_BY_PATH (ES.TDLINE , '<br />&nbsp&nbsp'), 17) LNGTX FROM (SELECT ER.*, ROW_NUMBER () OVER (ORDER BY TO_NUMBER(NO)) RN, COUNT (*) OVER () CNT FROM EC_M_LONGTEXT ER WHERE ER.MATNR =  '" . $ptm . "') ES LEFT JOIN EC_M_STRATEGIC_MATERIAL SM on ES.MATNR=SM.MATNR WHERE RN = CNT START WITH RN = 1 CONNECT BY RN = PRIOR RN + 1";
		// '" . $ptm . "'
		$result = $this -> db -> query($SQL);
		// }
		return (array)$result -> result_array();
	}

	public function addCart($MATNO, $CNT, $USER, $DATE, $QTY = 0, $ONE = 0, $STS = 0) {
		if ($ONE == 0) {
			$this -> db -> select('COUNT(*)') -> from($this -> tableCart) -> where(array('CONTRACT_NO' => $CNT, 'BUYONE' => 0, 'STATUS_CHART' => 0, 'MATNO' => $MATNO, 'ID_USER' => $USER));
			$query = $this -> db -> get();
			$result = $query -> row_array();
			$count = $result['COUNT(*)'];
			if ($count > 0) {
				$this -> db -> set('QTY', 'QTY+(1)', FALSE);
				$this -> db -> where(array('CONTRACT_NO' => $CNT, 'BUYONE' => 0, 'MATNO' => $MATNO, 'ID_USER' => $USER));
				$this -> db -> update($this -> tableCart);
			} else {
				$this -> db -> insert($this -> tableCart, array('CONTRACT_NO' => $CNT, "STATUS_CHART" => $STS, 'BUYONE' => $ONE, 'MATNO' => $MATNO, 'ID_USER' => $USER, 'DATE_BUY' => $DATE));
			}
		} else {
			$this -> db -> insert($this -> tableCart, array('CONTRACT_NO' => $CNT, "STATUS_CHART" => $STS, 'BUYONE' => $ONE, 'MATNO' => $MATNO, 'ID_USER' => $USER, 'DATE_BUY' => $DATE));
		}

		$this -> db -> select('COUNT(*)') -> from($this -> tableCart) -> where("ID_USER", $USER, TRUE) -> where("(EC_T_CHART.STATUS_CHART ='8' OR EC_T_CHART.STATUS_CHART ='0' )");
		$query = $this -> db -> get();
		$result = $query -> row_array();
		$count = $result['COUNT(*)'];
		return $count;
	}

	public function getAllCount($tbl = 'EC_T_CONTRACT', $val1 = '', $val2 = '') {
		if ($tbl == 'tag') {
			$this -> db -> select('COUNT(*)');
			$this -> db -> from($this -> table);
			$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
			$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
			$this -> db -> join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'left');
			$this -> db -> where('published =1 and (lower(TAG) like lower(\'%' . $val1 . '%\') OR lower(MAKTX) like lower(\'%' . $val1 . '%\') OR lower("vendorname") like lower(\'%' . $val1 . '%\'))');
			
		} else if ($tbl == 'harga') {
			$this -> db -> select('COUNT(*)');
			$this -> db -> from($this -> table);
			$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
			$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
			$this -> db -> join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'left');
			$this -> db -> where('published =1 and "netprice" >=' . $val1 . ' and "netprice" <=' . $val2 . '');

		} else if ($tbl == 'cat') {
			$this -> db -> select('COUNT(*)');
			$this -> db -> from($this -> table);
			$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
			$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
			$this -> db -> join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'left');
			$this -> db -> where('published =1 and KODE_USER like \'' . $val1 . '%\'');
			
		} else {
			$this -> db -> select('COUNT(*)') -> from($tbl);
			$this -> db -> where("published", '1', TRUE);
		}
		$query = $this -> db -> get();
		$result = $query -> row_array();
		$count = $result['COUNT(*)'];

		return $count;
	}

	public function getCartCount($USER, $DATE) {
		$this -> db -> select('COUNT(STATUS_CHART)') -> from($this -> tableCart) -> where("ID_USER", $USER, TRUE);
		$this -> db -> join('EC_T_CONTRACT', 'EC_T_CONTRACT.contract_no=EC_T_CHART.CONTRACT_NO AND EC_T_CONTRACT."matno"=EC_T_CHART.MATNO', 'left');
		$this -> db -> where("(EC_T_CHART.STATUS_CHART ='8' OR EC_T_CHART.STATUS_CHART ='0' ) ");
		$this -> db -> where("EC_T_CONTRACT.published", "1", TRUE);
		$query = $this -> db -> get();
		$result = $query -> row_array();
		$count = $result['COUNT(STATUS_CHART)'];
		return $count;
	}

	public function getCompareCount($USER) {
		$this -> db -> select('COUNT(*)') -> from($this -> tableCompare) -> where("ID_USER", $USER, TRUE);
		$query = $this -> db -> get();
		$result = $query -> row_array();
		$count = $result['COUNT(*)'];
		return $count;
	}

	public function addCompare($MATNO, $CNT, $USER) {
		$this -> db -> insert($this -> tableCompare, array('CONTRACT_NO' => $CNT, 'MATNO' => $MATNO, 'ID_USER' => $USER));
		$this -> db -> select('COUNT(*)') -> from($this -> tableCompare) -> where("ID_USER", $USER, TRUE);
		$query = $this -> db -> get();
		$result = $query -> row_array();
		$count = $result['COUNT(*)'];
		return $count;
	}

	public function getDetail($PC_CODE) {
		$this -> db -> from($this -> table);
		$this -> db -> where("PC_CODE", $PC_CODE, TRUE);
		$result = $this -> db -> get();
		return (array)$result -> result_array();
	}

	function insertData($vendorid, $matno, $harga, $curr, $start_date, $end_date, $status) {
		$this -> db -> select('COUNT(*)') -> from($this -> tablePricelist) -> where("MATNO", $matno, TRUE) -> where("VENDOR_ID", $vendorid, TRUE);
		$query = $this -> db -> get();
		$result = $query -> row_array();
		$count = $result['COUNT(*)'];
		//print_r($data['MATNR']);
		if ($count < 1) {
			$this -> db -> insert($this -> tablePricelist, array('MATNO' => $matno, 'VENDOR_ID' => $vendorid, 'PRICE_OFFER' => $harga, 'CURR_OFFER' => $curr, 'VALID_START' => $start_date, 'VALID_END' => $end_date, 'STATUS' => $status));
		} else {
			$this -> db -> where("MATNO", $matno, TRUE);
			$this -> db -> where("VENDOR_ID", $vendorid, TRUE);
			if($status=='Y'){
				$this -> db -> update($this -> tablePricelist, array('MATNO' => $matno, 'VENDOR_ID' => $vendorid, 'PRICE_OFFER' => $harga, 'CURR_OFFER' => $curr, 'VALID_START' => $start_date, 'VALID_END' => $end_date, 'STATUS' => $status));
			}else{
				$this -> db -> update($this -> tablePricelist, array('STATUS' => $status));	
			}
			
		}
		
	}
}

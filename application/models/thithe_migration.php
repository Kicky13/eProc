<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class thithe_migration extends CI_Model {
	protected $tableVnd_header = 'VND_HEADER', $tableVnd_product = 'VND_PRODUCT', $tableHistVnd_product = 'HIST_VND_PRODUCT';

	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}


	public function uploaddatavh($filename)
	{
		$this->load->library('excel');
		ini_set('memory_limit', '-1');

		$target_file = './upload/temp/';
		$buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/temp/") : false;
		move_uploaded_file($_FILES["import_excel"]["tmp_name"], $target_file.$_FILES['import_excel']['name']);


		$inputFileName = './upload/temp/'.$_FILES['import_excel']['name'];
		try {
			$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		} catch(Exception $e) {
			die('Error loading file :' . $e->getMessage());
		}

		$worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$numRows = count($worksheet);
		// echo "<pre>";
		// print_r($worksheet);
		// echo $worksheet[$i]["A"];
		// die;
		for ($i=2; $i < ($numRows+1) ; $i++) { 
			if($worksheet[$i]["A"]!=""){
				$data['VENDOR_ID'] = $worksheet[$i]["A"];
				$data['VENDOR_NAME'] = $worksheet[$i]["B"];
				$data['LOGIN_ID'] = $worksheet[$i]["C"];
				$data['PASSWORD'] = $worksheet[$i]["D"];
				$data['EMAIL_ADDRESS'] = $worksheet[$i]["E"];
				$data['VENDOR_NO'] = $worksheet[$i]["F"];
				$data['PREFIX'] = $worksheet[$i]["G"];
				$data['PREFIX_OTHER'] = $worksheet[$i]["H"];
				$data['SUFFIX'] = $worksheet[$i]["I"];
				$data['SUFFIX_OTHER'] = $worksheet[$i]["J"];
				$data['ADDRESS_STREET'] = $worksheet[$i]["K"];
				$data['ADDRESS_CITY'] = $worksheet[$i]["L"];
				$data['ADDRES_PROP'] = $worksheet[$i]["M"];
				$data['ADDRESS_POSTCODE'] = $worksheet[$i]["N"];
				$data['ADDRESS_COUNTRY'] = $worksheet[$i]["O"];
				$data['ADDRESS_PHONE_NO'] = $worksheet[$i]["P"];
				$data['ADDRESS_WEBSITE'] = $worksheet[$i]["Q"];
				$data['ADDRESS_DOMISILI_NO'] = $worksheet[$i]["R"];
				$data['ADDRESS_DOMISILI_DATE'] = ($worksheet[$i]["S"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["S"])) : date("d/m/Y");

				$data['ADDRESS_DOMISILI_EXP_DATE'] = ($worksheet[$i]["T"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["T"])) : date("d/m/Y");
				$data['CONTACT_NAME'] = $worksheet[$i]["U"];
				$data['CONTACT_POS'] = $worksheet[$i]["V"];
				$data['CONTACT_PHONE_NO'] = $worksheet[$i]["W"];
				$data['CONTACT_EMAIL'] = $worksheet[$i]["X"];
				$data['NPP'] = $worksheet[$i]["Y"];
				$data['NPP_DATE'] = ($worksheet[$i]["Z"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["Z"])) : date("d/m/Y");
				$data['NPWP_NO'] = $worksheet[$i]["AA"];
				$data['NPWP_ADDRESS'] = $worksheet[$i]["AB"];
				$data['NPWP_CITY'] = $worksheet[$i]["AC"];
				$data['NPWP_PROP'] = $worksheet[$i]["AD"];
				$data['NPWP_POSTCODE'] = $worksheet[$i]["AE"];
				$data['NPWP_PKP'] = $worksheet[$i]["AF"];
				$data['NPWP_PKP_NO'] = $worksheet[$i]["AG"];
				$data['VENDOR_TYPE'] = $worksheet[$i]["AH"];
				$data['SIUP_IUJK_TYPE'] = $worksheet[$i]["AI"];
				$data['SIUP_ISSUED_BY'] = $worksheet[$i]["AJ"];
				$data['SIUP_NO'] = $worksheet[$i]["AK"];
				$data['SIUP_TYPE'] = $worksheet[$i]["AL"];
				$data['SIUP_FROM'] = ($worksheet[$i]["AM"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AM"])) : date("d/m/Y");
				$data['SIUP_TO'] = ($worksheet[$i]["AN"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AN"])) : date("d/m/Y");
				$data['TDP_ISSUED_BY'] = $worksheet[$i]["AO"];
				$data['TDP_NO'] = $worksheet[$i]["AP"];
				$data['TDP_FROM'] = ($worksheet[$i]["AQ"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AQ"])) : date("d/m/Y");
				$data['TDP_TO'] = ($worksheet[$i]["AR"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AR"])) : date("d/m/Y");
				$data['AGEN_ISSUED_BY'] = $worksheet[$i]["AS"];
				$data['AGEN_FROM'] = ($worksheet[$i]["AT"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AT"])) : date("d/m/Y");
				$data['AGEN_TO'] = ($worksheet[$i]["AU"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AU"])) : date("d/m/Y");
				$data['IMP_ISSUED_BY'] = $worksheet[$i]["AV"];
				$data['IMP_FROM'] = ($worksheet[$i]["AW"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AW"])) : date("d/m/Y");
				$data['IMP_TO'] = ($worksheet[$i]["AX"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AX"])) : date("d/m/Y");

				$data['ATT_ORG'] = $worksheet[$i]["AY"];
				$data['FIN_AKTA_MDL_DSR_CURR'] = $worksheet[$i]["AZ"];
				$data['FIN_AKTA_MDL_DSR'] = $worksheet[$i]["BA"];
				$data['FIN_AKTA_MDL_STR_CURR'] = $worksheet[$i]["BB"];
				$data['FIN_AKTA_MDL_STR'] = $worksheet[$i]["BC"];
				$data['FIN_ASSET_MDL_DSR_CUR'] = $worksheet[$i]["BD"];
				$data['FIN_ASSET_MDL_DSR'] = ($worksheet[$i]["BE"] !="") ? $worksheet[$i]["BE"] : 0;
				$data['FIN_RPT_CURRENCY'] = $worksheet[$i]["BF"];
				$data['FIN_RPT_YEAR'] = ($worksheet[$i]["BG"] !="") ? $worksheet[$i]["BG"] : date("Y");
				$data['FIN_RPT_TYPE'] = $worksheet[$i]["BH"];
				$data['FIN_RPT_ASSET_VALUE'] = ($worksheet[$i]["BI"] !="") ? $worksheet[$i]["BI"] : 0;
				$data['FIN_RPT_HUTANG'] = ($worksheet[$i]["BJ"] !="") ? $worksheet[$i]["BJ"] : 0;
				$data['FIN_RPT_REVENUE'] = ($worksheet[$i]["BK"] !="") ? $worksheet[$i]["BK"] : 0;
				$data['FIN_RPT_NETINCOME'] = ($worksheet[$i]["BL"] !="") ? $worksheet[$i]["BL"] : 0;
				$data['FIN_CLASS'] = $worksheet[$i]["BM"];
				$data['SMK_NO'] = $worksheet[$i]["BN"];
				$data['SMK_DATE'] = ($worksheet[$i]["BO"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BO"])) : date("d/m/Y");
				$data['SMK_EXPIRED'] = ($worksheet[$i]["BP"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BP"])) : date("d/m/Y");
				$data['EXPIREDFROM'] = ($worksheet[$i]["BQ"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BQ"])) : date("d/m/Y");
				$data['EXPIREDTO'] = ($worksheet[$i]["BR"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BR"])) : date("d/m/Y");
				$data['EXPIREDBY'] = $worksheet[$i]["BS"];
				$data['CREATION_DATE'] = ($worksheet[$i]["BT"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BT"])) : date("d/m/Y");
				$data['CREATED_BY'] = $worksheet[$i]["BU"];
				$data['MODIFIED_DATE'] = ($worksheet[$i]["BV"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BV"])) : date("d/m/Y");
				$data['MODIFIED_BY'] = $worksheet[$i]["BW"];
				$data['STATUS'] = $worksheet[$i]["BX"];
				$data['NEXT_PAGE'] = $worksheet[$i]["BY"];
				$data['REG_STATUS_ID'] = $worksheet[$i]["BZ"];
				$data['REG_ISACTIVATE'] = $worksheet[$i]["CA"];
				$data['REG_SESSIONID'] = $worksheet[$i]["CB"];
				$data['COMPANYID'] = $worksheet[$i]["CC"];

				$data['API_ISSUED_BY'] = '';//$worksheet[$i]["CD"];
				$data['API_NO'] = '';//$worksheet[$i]["CE"];
				$data['API_FROM'] = date("d/m/Y");//$worksheet[$i]["CF"];
				$data['API_TO'] = date("d/m/Y");//$worksheet[$i]["CG"];
				$data['CONTACT_PHONE_HP'] = '';//$worksheet[$i]["CH"];
				$data['DOMISILI_NO_DOC'] = '';//$worksheet[$i]["CI"];
				$data['NPWP_NO_DOC'] = '';//$worksheet[$i]["CJ"];
				$data['PKP_NO_DOC'] = '';//$worksheet[$i]["CK"];
				$data['SIUP_NO_DOC'] = '';//$worksheet[$i]["CL"];
				$data['TDP_NO_DOC'] = '';//$worksheet[$i]["CM"];
				$data['STATUS_PERUBAHAN'] = 0;//$worksheet[$i]["CN"];
				$data['STATUS_ADJ'] = 0;//$worksheet[$i]["CO"];
				$data['PERFORMANCE'] = 0;//$worksheet[$i]["CP"];
				$data['REQ_PASS_ID'] = '';//$worksheet[$i]["CQ"];
				$data['PRODUCT_TYPE_PROC'] = '';//$worksheet[$i]["CR"];

				$result 			= $this->addVndHeader($data);
			} else {
				echo "gagal";die;
			}

		} 

	// die;
	}

	public function addVndHeader($data)
	{
		$SQL = "
		INSERT INTO VND_HEADER (
		VENDOR_ID,
		VENDOR_NAME,
		LOGIN_ID,
		PASSWORD,
		EMAIL_ADDRESS,
		VENDOR_NO,
		PREFIX,
		PREFIX_OTHER,
		SUFFIX,
		SUFFIX_OTHER,
		ADDRESS_STREET,
		ADDRESS_CITY,
		ADDRES_PROP,
		ADDRESS_POSTCODE,
		ADDRESS_COUNTRY,
		ADDRESS_PHONE_NO,
		ADDRESS_WEBSITE,
		ADDRESS_DOMISILI_NO,
		ADDRESS_DOMISILI_DATE,

		ADDRESS_DOMISILI_EXP_DATE,
		CONTACT_NAME,
		CONTACT_POS,
		CONTACT_PHONE_NO,
		CONTACT_EMAIL,
		NPP,
		NPP_DATE,
		NPWP_NO,
		NPWP_ADDRESS,
		NPWP_CITY,
		NPWP_PROP,
		NPWP_POSTCODE,
		NPWP_PKP,
		NPWP_PKP_NO,
		VENDOR_TYPE,
		SIUP_IUJK_TYPE,
		SIUP_ISSUED_BY,
		SIUP_NO,
		SIUP_TYPE,
		SIUP_FROM,
		SIUP_TO,
		TDP_ISSUED_BY,
		TDP_NO,
		TDP_FROM,
		TDP_TO,
		AGEN_ISSUED_BY,
		AGEN_FROM,
		AGEN_TO,
		IMP_ISSUED_BY,
		IMP_FROM,
		IMP_TO,

		ATT_ORG,
		FIN_AKTA_MDL_DSR_CURR,
		FIN_AKTA_MDL_DSR,
		FIN_AKTA_MDL_STR_CURR,
		FIN_AKTA_MDL_STR,
		FIN_ASSET_MDL_DSR_CUR,
		FIN_ASSET_MDL_DSR,
		FIN_RPT_CURRENCY,
		FIN_RPT_YEAR,
		FIN_RPT_TYPE,
		FIN_RPT_ASSET_VALUE,
		FIN_RPT_HUTANG,
		FIN_RPT_REVENUE,
		FIN_RPT_NETINCOME,
		FIN_CLASS,
		SMK_NO,


		SMK_DATE,
		SMK_EXPIRED,
		EXPIREDFROM,
		EXPIREDTO,
		EXPIREDBY,
		CREATION_DATE,
		CREATED_BY,
		MODIFIED_DATE,
		MODIFIED_BY,
		STATUS,
		NEXT_PAGE,
		REG_STATUS_ID,
		REG_ISACTIVATE,
		REG_SESSIONID,
		COMPANYID,
		API_ISSUED_BY,
		API_NO,
		API_FROM,
		API_TO,

		CONTACT_PHONE_HP,
		DOMISILI_NO_DOC,
		NPWP_NO_DOC,
		PKP_NO_DOC,
		SIUP_NO_DOC,
		TDP_NO_DOC,
		STATUS_PERUBAHAN,
		STATUS_ADJ,
		PERFORMANCE,
		REQ_PASS_ID,
		PRODUCT_TYPE_PROC
		)  
		values
		(
		" . $data['VENDOR_ID'] . ",
		'" . $data['VENDOR_NAME'] . "',
		'" . $data['LOGIN_ID'] . "',
		'" . $data['PASSWORD'] . "',
		'" . $data['EMAIL_ADDRESS'] . "',
		'" . $data['VENDOR_NO'] . "',
		'" . $data['PREFIX'] . "',
		'" . $data['PREFIX_OTHER'] . "', 
		'" . $data['SUFFIX'] . "',
		'" . $data['SUFFIX_OTHER'] . "', 
		'" . $data['ADDRESS_STREET'] . "',
		'" . $data['ADDRESS_CITY'] . "',
		'" . $data['ADDRES_PROP'] . "', 
		'" . $data['ADDRESS_POSTCODE'] . "',
		'" . $data['ADDRESS_COUNTRY'] . "',
		'" . $data['ADDRESS_PHONE_NO'] . "',
		'" . $data['ADDRESS_WEBSITE'] . "', 
		'" . $data['ADDRESS_DOMISILI_NO'] . "',
		TO_DATE('" . $data['ADDRESS_DOMISILI_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),

		TO_DATE('" . $data['ADDRESS_DOMISILI_EXP_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['CONTACT_NAME'] . "',
		'" . $data['CONTACT_POS'] . "',
		'" . $data['CONTACT_PHONE_NO'] . "',
		'" . $data['CONTACT_EMAIL'] . "',
		'" . $data['NPP'] . "',
		TO_DATE('" . $data['NPP_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['NPWP_NO'] . "',
		'" . $data['NPWP_ADDRESS'] . "', 
		'" . $data['NPWP_CITY'] . "',
		'" . $data['NPWP_PROP'] . "', 
		'" . $data['NPWP_POSTCODE'] . "',
		'" . $data['NPWP_PKP'] . "',
		'" . $data['NPWP_PKP_NO'] . "',
		'" . $data['VENDOR_TYPE'] . "',
		'" . $data['SIUP_IUJK_TYPE'] . "',
		'" . $data['SIUP_ISSUED_BY'] . "',
		'" . $data['SIUP_NO'] . "',
		'" . $data['SIUP_TYPE'] . "',
		TO_DATE('" . $data['SIUP_FROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['SIUP_TO'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['TDP_ISSUED_BY'] . "',
		'" . $data['TDP_NO'] . "',
		TO_DATE('" . $data['TDP_FROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['TDP_TO'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['AGEN_ISSUED_BY'] . "',
		TO_DATE('" . $data['AGEN_FROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['AGEN_TO'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['IMP_ISSUED_BY'] . "',
		TO_DATE('" . $data['IMP_FROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['IMP_TO'] . "', 'dd/mm/yyyy hh24:mi:ss'),

		'" . $data['ATT_ORG'] . "',
		'" . $data['FIN_AKTA_MDL_DSR_CURR'] . "',
		" . $data['FIN_AKTA_MDL_DSR'] . ",
		'" . $data['FIN_AKTA_MDL_STR_CURR'] . "',
		" . $data['FIN_AKTA_MDL_STR'] . ",
		'" . $data['FIN_ASSET_MDL_DSR_CUR'] . "', 
		" . $data['FIN_ASSET_MDL_DSR'] . ",
		'" . $data['FIN_RPT_CURRENCY'] . "',
		" . $data['FIN_RPT_YEAR'] . ",
		'" . $data['FIN_RPT_TYPE'] . "', 
		" . $data['FIN_RPT_ASSET_VALUE'] . ",
		" . $data['FIN_RPT_HUTANG'] . ",
		" . $data['FIN_RPT_REVENUE'] . ",
		" . $data['FIN_RPT_NETINCOME'] . ",
		'" . $data['FIN_CLASS'] . "',
		'" . $data['SMK_NO'] . "',

		TO_DATE('" . $data['SMK_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['SMK_EXPIRED'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['EXPIREDFROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['EXPIREDTO'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['EXPIREDBY'] . "',
		TO_DATE('" . $data['CREATION_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['CREATED_BY'] . "',
		TO_DATE('" . $data['MODIFIED_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['MODIFIED_BY'] . "',
		'" . $data['STATUS'] . "',
		'" . $data['NEXT_PAGE'] . "',
		'" . $data['REG_STATUS_ID'] . "',
		'" . $data['REG_ISACTIVATE'] . "',
		'" . $data['REG_SESSIONID'] . "',
		'" . $data['COMPANYID'] . "',
		'" . $data['API_ISSUED_BY'] . "', 
		'" . $data['API_NO'] . "',
		TO_DATE('" . $data['API_FROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['API_TO'] . "', 'dd/mm/yyyy hh24:mi:ss'),


		'" . $data['CONTACT_PHONE_HP'] . "',
		'" . $data['DOMISILI_NO_DOC'] . "', 
		'" . $data['NPWP_NO_DOC'] . "',
		'" . $data['PKP_NO_DOC'] . "',
		'" . $data['SIUP_NO_DOC'] . "',
		'" . $data['TDP_NO_DOC'] . "', 
		'" . $data['STATUS_PERUBAHAN'] . "',
		'" . $data['STATUS_ADJ'] . "',
		'" . $data['PERFORMANCE'] . "',
		'" . $data['REQ_PASS_ID'] . "',
		'" . $data['PRODUCT_TYPE_PROC']."'

		)
		";
		$this -> db -> query($SQL);
	}


	public function uploaddatavadd($filename)
	{
		$this->load->library('excel');
		ini_set('memory_limit', '-1');

		$target_file = './upload/temp/';
		$buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/temp/") : false;
		move_uploaded_file($_FILES["import_excel"]["tmp_name"], $target_file.$_FILES['import_excel']['name']);


		$inputFileName = './upload/temp/'.$_FILES['import_excel']['name'];
		try {
			$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		} catch(Exception $e) {
			die('Error loading file :' . $e->getMessage());
		}

		$worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$numRows = count($worksheet);
		// echo "<pre>";
		// print_r($worksheet);
		// echo $worksheet[$i]["A"];
		// die;
		for ($i=2; $i < ($numRows+1) ; $i++) { 
			if($worksheet[$i]["A"]!=""){

				$data['VENDOR_ID'] = $worksheet[$i]["A"];
				$data['TYPE'] = $worksheet[$i]["B"];
				$data['ADDRESS'] = $worksheet[$i]["C"];
				$data['CITY'] = $worksheet[$i]["D"];
				$data['COUNTRY'] = $worksheet[$i]["E"];
				$data['POST_CODE'] = $worksheet[$i]["F"];
				$data['TELEPHONE1_NO'] = $worksheet[$i]["G"];
				$data['TELEPHONE2_NO'] = $worksheet[$i]["H"];
				$data['FAX'] = $worksheet[$i]["I"];
				$data['WEBSITE'] = $worksheet[$i]["J"];
				$data['PROVINCE'] = '';
				$data['DATE_CREATION'] = date("d/m/Y");
				$data['MODIFIED_DATE'] = date("d/m/Y");
				$result 			= $this->addVndAddress($data);
			} else {
				echo "gagal";die;
			}

		} 

	// die;
	}

	public function addVndAddress($data)
	{
		$SQL = "
		INSERT INTO VND_ADDRESS (
		VENDOR_ID,
		TYPE,
		ADDRESS,
		CITY,
		COUNTRY,
		POST_CODE,
		TELEPHONE1_NO,
		TELEPHONE2_NO,
		FAX,
		WEBSITE,
		PROVINCE,
		DATE_CREATION,
		MODIFIED_DATE
		)  
		values
		(
		" . $data['VENDOR_ID'] . ",
		'" . $data['TYPE'] . "',
		'" . $data['ADDRESS'] . "',
		'" . $data['CITY'] . "',
		'" . $data['COUNTRY'] . "',
		'" . $data['POST_CODE'] . "',
		'" . $data['TELEPHONE1_NO'] . "',
		'" . $data['TELEPHONE2_NO'] . "',
		'" . $data['FAX'] . "',
		'" . $data['WEBSITE'] . "',
		'" . $data['PROVINCE'] . "',
		TO_DATE('" . $data['DATE_CREATION'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['MODIFIED_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss')
		)
		";
		$this -> db -> query($SQL);
	}


	public function uploaddatavakta($filename)
	{
		$this->load->library('excel');
		ini_set('memory_limit', '-1');

		$target_file = './upload/temp/';
		$buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/temp/") : false;
		move_uploaded_file($_FILES["import_excel"]["tmp_name"], $target_file.$_FILES['import_excel']['name']);


		$inputFileName = './upload/temp/'.$_FILES['import_excel']['name'];
		try {
			$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		} catch(Exception $e) {
			die('Error loading file :' . $e->getMessage());
		}

		$worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$numRows = count($worksheet);
		// echo "<pre>";
		// print_r($worksheet);
		// echo $worksheet[$i]["A"];
		// die;
		for ($i=2; $i < ($numRows+1) ; $i++) { 
			if($worksheet[$i]["A"]!=""){
				$data['VENDOR_ID'] = $worksheet[$i]["A"];
				$data['AKTA_TYPE'] = $worksheet[$i]["B"];
				$data['AKTA_NO'] = $worksheet[$i]["C"];
				$data['DATE_CREATION'] = ($worksheet[$i]["D"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["D"])) : date("d/m/Y");
				$data['NOTARIS_NAME'] = $worksheet[$i]["E"];
				$data['NOTARIS_ADDRESS'] = $worksheet[$i]["F"];
				$data['PENGESAHAN_HAKIM'] = ($worksheet[$i]["G"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["G"])) : date("d/m/Y");
				$data['BERITA_ACARA_NGR'] = ($worksheet[$i]["H"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["H"])) : date("d/m/Y");
				$data['AKTA_NO_DOC'] = '';
				$data['PENGESAHAN_HAKIM_DOC'] ='';
				$data['BERITA_ACARA_NGR_DOC'] = '';
				$data['MODIFIED_DATE'] = date("d/m/Y");

				$result 			= $this->addVndakta($data);
			} else {
				echo "gagal";die;
			}

		} 

	// die;
	}

	public function addVndakta($data)
	{
		$SQL = "
		INSERT INTO VND_AKTA (
		VENDOR_ID,
		AKTA_TYPE,
		AKTA_NO,
		DATE_CREATION,
		NOTARIS_NAME,
		NOTARIS_ADDRESS,
		PENGESAHAN_HAKIM,
		BERITA_ACARA_NGR,
		AKTA_NO_DOC,
		PENGESAHAN_HAKIM_DOC,
		BERITA_ACARA_NGR_DOC,
		MODIFIED_DATE
		)  
		values
		(
		" . $data['VENDOR_ID'] . ",
		'" . $data['AKTA_TYPE'] . "',
		'" . $data['AKTA_NO'] . "',
		TO_DATE('" . $data['DATE_CREATION'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['NOTARIS_NAME'] . "',
		'" . $data['NOTARIS_ADDRESS'] . "',
		TO_DATE('" . $data['PENGESAHAN_HAKIM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['BERITA_ACARA_NGR'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['AKTA_NO_DOC'] . "',
		'" . $data['PENGESAHAN_HAKIM_DOC'] . "',
		'" . $data['BERITA_ACARA_NGR_DOC'] . "',
		TO_DATE('" . $data['MODIFIED_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss')
		)
		";
		$this -> db -> query($SQL);
	}


	public function uploaddatavagent($filename)
	{
		$this->load->library('excel');
		ini_set('memory_limit', '-1');

		$target_file = './upload/temp/';
		$buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/temp/") : false;
		move_uploaded_file($_FILES["import_excel"]["tmp_name"], $target_file.$_FILES['import_excel']['name']);


		$inputFileName = './upload/temp/'.$_FILES['import_excel']['name'];
		try {
			$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		} catch(Exception $e) {
			die('Error loading file :' . $e->getMessage());
		}

		$worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$numRows = count($worksheet);
		// echo "<pre>";
		// print_r($worksheet);
		// echo $worksheet[$i]["A"];
		// die;
		for ($i=2; $i < ($numRows+1) ; $i++) { 
			if($worksheet[$i]["A"]!=""){
				$data['AGENT_ID'] = $worksheet[$i]["A"];
				$data['TYPE'] = $worksheet[$i]["B"];
				$data['VENDOR_ID'] = $worksheet[$i]["C"];
				$data['ISSUED_BY'] = $worksheet[$i]["D"];
				$data['CREATED_DATE'] = ($worksheet[$i]["E"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["D"])) : date("d/m/Y");
				$data['EXPIRED_DATE'] = ($worksheet[$i]["F"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["E"])) : date("d/m/Y");
				$data['NO'] = '';
				$data['AGENT_MERK'] = '';
				$data['AGENT_COMMODITY'] = '';
				$result 			= $this->addVndagent($data);
			} else {
				echo "gagal";die;
			}

		} 

	// die;
	}

	public function addVndagent($data)
	{
		$SQL = "
		INSERT INTO VND_AGENT (
		AGENT_ID,
		TYPE,
		VENDOR_ID,
		ISSUED_BY,
		CREATED_DATE,
		EXPIRED_DATE,
		NO,
		AGENT_MERK,
		AGENT_COMMODITY
		)  
		values
		(
		" . $data['AGENT_ID'] . ",
		'" . $data['TYPE'] . "',
		" . $data['VENDOR_ID'] . ",
		'" . $data['ISSUED_BY'] . "',
		TO_DATE('" . $data['CREATED_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['EXPIRED_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['NO'] . "',
		'" . $data['AGENT_MERK'] . "',
		'" . $data['AGENT_COMMODITY'] . "'
		)
		";
		$this -> db -> query($SQL);
	}


	public function uploaddatavboard($filename)
	{
		$this->load->library('excel');
		ini_set('memory_limit', '-1');

		$target_file = './upload/temp/';
		$buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/temp/") : false;
		move_uploaded_file($_FILES["import_excel"]["tmp_name"], $target_file.$_FILES['import_excel']['name']);


		$inputFileName = './upload/temp/'.$_FILES['import_excel']['name'];
		try {
			$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		} catch(Exception $e) {
			die('Error loading file :' . $e->getMessage());
		}

		$worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$numRows = count($worksheet);
		// echo "<pre>";
		// print_r($worksheet);
		// echo $worksheet[$i]["A"];
		// die;
		for ($i=2; $i < ($numRows+1) ; $i++) { 
			if($worksheet[$i]["A"]!=""){
				
				$data['VENDOR_ID'] = $worksheet[$i]["A"];
				$data['TYPE'] = $worksheet[$i]["B"];
				$data['NAME'] = $worksheet[$i]["C"];
				$data['POS'] = $worksheet[$i]["D"];
				$data['TELEPHONE_NO'] = $worksheet[$i]["E"];
				$data['EMAIL_ADDRESS'] = $worksheet[$i]["F"];
				$data['KTP_NO'] = $worksheet[$i]["G"];
				$data['NPWP_NO'] = $worksheet[$i]["H"];
				$data['KTP_EXPIRED_DATE'] = date("d/m/Y");
				$data['DATE_CREATION'] = date("d/m/Y");
				$data['MODIFIED_DATE'] = date("d/m/Y");
				$data['KTP_FILE'] = '';

				$result 			= $this->addVndboard($data);
			} else {
				echo "gagal";die;
			}

		} 

	// die;
	}

	public function addVndboard($data)
	{
		$SQL = "
		INSERT INTO VND_BOARD (
		VENDOR_ID,
		TYPE,
		NAME,
		POS,
		TELEPHONE_NO,
		EMAIL_ADDRESS,
		KTP_NO,
		NPWP_NO,
		KTP_EXPIRED_DATE,
		DATE_CREATION,
		MODIFIED_DATE,
		KTP_FILE
		)  
		values
		(
		" . $data['VENDOR_ID'] . ",
		'" . $data['TYPE'] . "',
		'" . $data['NAME'] . "',
		'" . $data['POS'] . "',
		'" . $data['TELEPHONE_NO'] . "',
		'" . $data['EMAIL_ADDRESS'] . "',
		'" . $data['KTP_NO'] . "',
		'" . $data['NPWP_NO'] . "',
		TO_DATE('" . $data['KTP_EXPIRED_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['DATE_CREATION'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['MODIFIED_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['KTP_FILE'] . "'
		)
		";
		$this -> db -> query($SQL);
	}


	public function uploaddatavbank($filename)
	{
		$this->load->library('excel');
		ini_set('memory_limit', '-1');

		$target_file = './upload/temp/';
		$buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/temp/") : false;
		move_uploaded_file($_FILES["import_excel"]["tmp_name"], $target_file.$_FILES['import_excel']['name']);


		$inputFileName = './upload/temp/'.$_FILES['import_excel']['name'];
		try {
			$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		} catch(Exception $e) {
			die('Error loading file :' . $e->getMessage());
		}

		$worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$numRows = count($worksheet);
		// echo "<pre>";
		// print_r($worksheet);
		// echo $worksheet[$i]["A"];
		// die;
		for ($i=2; $i < ($numRows+1) ; $i++) { 
			if($worksheet[$i]["A"]!=""){
				
				$data['VENDOR_ID'] = $worksheet[$i]["A"];
				$data['ACCOUNT_NO'] = $worksheet[$i]["B"];
				$data['ACCOUNT_NAME'] = $worksheet[$i]["C"];
				$data['BANK_NAME'] = $worksheet[$i]["D"];
				$data['BANK_BRANCH'] = $worksheet[$i]["E"];;
				$data['ADDRESS'] = $worksheet[$i]["F"];
				$data['CURRENCY'] = $worksheet[$i]["G"];
				$data['SWIFT_CODE'] = '';
				$data['BANK_POSTAL_CODE'] = '';
				$data['DATE_CREATION'] = date("d/m/Y");
				$data['MODIFIED_DATE'] = date("d/m/Y");
				$data['REFERENCE_BANK'] = '';
				$data['REFERENCE_FILE'] = '';

				$result 			= $this->addVndbank($data);
			} else {
				echo "gagal";die;
			}

		} 

	// die;
	}

	public function addVndbank($data)
	{
		$SQL = "
		INSERT INTO VND_BANK (
		VENDOR_ID,
		ACCOUNT_NO,
		ACCOUNT_NAME,
		BANK_NAME,
		BANK_BRANCH,
		ADDRESS,
		CURRENCY,
		SWIFT_CODE,
		BANK_POSTAL_CODE,
		DATE_CREATION,
		MODIFIED_DATE,
		REFERENCE_BANK,
		REFERENCE_FILE
		)  
		values
		(
		" . $data['VENDOR_ID'] . ",
		'" . $data['ACCOUNT_NO'] . "',
		'" . $data['ACCOUNT_NAME'] . "',
		'" . $data['BANK_NAME'] . "',
		'" . $data['BANK_BRANCH'] . "',
		'" . $data['ADDRESS'] . "',
		'" . $data['CURRENCY'] . "',
		'" . $data['SWIFT_CODE'] . "',
		'" . $data['BANK_POSTAL_CODE'] . "',
		TO_DATE('" . $data['DATE_CREATION'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['MODIFIED_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['REFERENCE_BANK'] . "',
		'" . $data['REFERENCE_FILE'] . "'
		)
		";
		$this -> db -> query($SQL);
	}


	public function uploaddatahisheader($filename)
	{
		$this->load->library('excel');
		ini_set('memory_limit', '-1');

		$target_file = './upload/temp/';
		$buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/temp/") : false;
		move_uploaded_file($_FILES["import_excel"]["tmp_name"], $target_file.$_FILES['import_excel']['name']);


		$inputFileName = './upload/temp/'.$_FILES['import_excel']['name'];
		try {
			$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		} catch(Exception $e) {
			die('Error loading file :' . $e->getMessage());
		}

		$worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$numRows = count($worksheet);
		// echo "<pre>";
		// print_r($worksheet);
		// echo $worksheet[$i]["A"];
		// die;
		for ($i=2; $i < ($numRows+1) ; $i++) { 
			if($worksheet[$i]["A"]!=""){
				$data['VENDOR_ID'] = $worksheet[$i]["A"];
				$data['VENDOR_NAME'] = $worksheet[$i]["B"];
				$data['LOGIN_ID'] = $worksheet[$i]["C"];
				$data['PASSWORD'] = $worksheet[$i]["D"];
				$data['EMAIL_ADDRESS'] = $worksheet[$i]["E"];
				$data['VENDOR_NO'] = $worksheet[$i]["F"];
				$data['PREFIX'] = $worksheet[$i]["G"];
				$data['PREFIX_OTHER'] = $worksheet[$i]["H"];
				$data['SUFFIX'] = $worksheet[$i]["I"];
				$data['SUFFIX_OTHER'] = $worksheet[$i]["J"];
				$data['ADDRESS_STREET'] = $worksheet[$i]["K"];
				$data['ADDRESS_CITY'] = $worksheet[$i]["L"];
				$data['ADDRES_PROP'] = $worksheet[$i]["M"];
				$data['ADDRESS_POSTCODE'] = $worksheet[$i]["N"];
				$data['ADDRESS_COUNTRY'] = $worksheet[$i]["O"];
				$data['ADDRESS_PHONE_NO'] = $worksheet[$i]["P"];
				$data['ADDRESS_WEBSITE'] = $worksheet[$i]["Q"];
				$data['ADDRESS_DOMISILI_NO'] = $worksheet[$i]["R"];
				$data['ADDRESS_DOMISILI_DATE'] = ($worksheet[$i]["S"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["S"])) : date("d/m/Y");

				$data['ADDRESS_DOMISILI_EXP_DATE'] = ($worksheet[$i]["T"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["T"])) : date("d/m/Y");
				$data['CONTACT_NAME'] = $worksheet[$i]["U"];
				$data['CONTACT_POS'] = $worksheet[$i]["V"];
				$data['CONTACT_PHONE_NO'] = $worksheet[$i]["W"];
				$data['CONTACT_EMAIL'] = $worksheet[$i]["X"];
				$data['NPP'] = $worksheet[$i]["Y"];
				$data['NPP_DATE'] = ($worksheet[$i]["Z"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["Z"])) : date("d/m/Y");
				$data['NPWP_NO'] = $worksheet[$i]["AA"];
				$data['NPWP_ADDRESS'] = $worksheet[$i]["AB"];
				$data['NPWP_CITY'] = $worksheet[$i]["AC"];
				$data['NPWP_PROP'] = $worksheet[$i]["AD"];
				$data['NPWP_POSTCODE'] = $worksheet[$i]["AE"];
				$data['NPWP_PKP'] = $worksheet[$i]["AF"];
				$data['NPWP_PKP_NO'] = $worksheet[$i]["AG"];
				$data['VENDOR_TYPE'] = $worksheet[$i]["AH"];
				$data['SIUP_IUJK_TYPE'] = $worksheet[$i]["AI"];
				$data['SIUP_ISSUED_BY'] = $worksheet[$i]["AJ"];
				$data['SIUP_NO'] = $worksheet[$i]["AK"];
				$data['SIUP_TYPE'] = $worksheet[$i]["AL"];
				$data['SIUP_FROM'] = ($worksheet[$i]["AM"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AM"])) : date("d/m/Y");
				$data['SIUP_TO'] = ($worksheet[$i]["AN"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AN"])) : date("d/m/Y");
				$data['TDP_ISSUED_BY'] = $worksheet[$i]["AO"];
				$data['TDP_NO'] = $worksheet[$i]["AP"];
				$data['TDP_FROM'] = ($worksheet[$i]["AQ"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AQ"])) : date("d/m/Y");
				$data['TDP_TO'] = ($worksheet[$i]["AR"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AR"])) : date("d/m/Y");
				$data['AGEN_ISSUED_BY'] = $worksheet[$i]["AS"];
				$data['AGEN_FROM'] = ($worksheet[$i]["AT"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AT"])) : date("d/m/Y");
				$data['AGEN_TO'] = ($worksheet[$i]["AU"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AU"])) : date("d/m/Y");
				$data['IMP_ISSUED_BY'] = $worksheet[$i]["AV"];
				$data['IMP_FROM'] = ($worksheet[$i]["AW"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AW"])) : date("d/m/Y");
				$data['IMP_TO'] = ($worksheet[$i]["AX"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["AX"])) : date("d/m/Y");

				$data['ATT_ORG'] = $worksheet[$i]["AY"];
				$data['FIN_AKTA_MDL_DSR_CURR'] = $worksheet[$i]["AZ"];
				$data['FIN_AKTA_MDL_DSR'] = $worksheet[$i]["BA"];
				$data['FIN_AKTA_MDL_STR_CURR'] = $worksheet[$i]["BB"];
				$data['FIN_AKTA_MDL_STR'] = $worksheet[$i]["BC"];
				$data['FIN_ASSET_MDL_DSR_CUR'] = $worksheet[$i]["BD"];
				$data['FIN_ASSET_MDL_DSR'] = ($worksheet[$i]["BE"] !="") ? $worksheet[$i]["BE"] : 0;
				$data['FIN_RPT_CURRENCY'] = $worksheet[$i]["BF"];
				$data['FIN_RPT_YEAR'] = ($worksheet[$i]["BG"] !="") ? $worksheet[$i]["BG"] : date("Y");
				$data['FIN_RPT_TYPE'] = $worksheet[$i]["BH"];
				$data['FIN_RPT_ASSET_VALUE'] = ($worksheet[$i]["BI"] !="") ? $worksheet[$i]["BI"] : 0;
				$data['FIN_RPT_HUTANG'] = ($worksheet[$i]["BJ"] !="") ? $worksheet[$i]["BJ"] : 0;
				$data['FIN_RPT_REVENUE'] = ($worksheet[$i]["BK"] !="") ? $worksheet[$i]["BK"] : 0;
				$data['FIN_RPT_NETINCOME'] = ($worksheet[$i]["BL"] !="") ? $worksheet[$i]["BL"] : 0;
				$data['FIN_CLASS'] = $worksheet[$i]["BM"];
				$data['SMK_NO'] = $worksheet[$i]["BN"];
				$data['SMK_DATE'] = ($worksheet[$i]["BO"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BO"])) : date("d/m/Y");
				$data['SMK_EXPIRED'] = ($worksheet[$i]["BP"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BP"])) : date("d/m/Y");
				$data['EXPIREDFROM'] = ($worksheet[$i]["BQ"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BQ"])) : date("d/m/Y");
				$data['EXPIREDTO'] = ($worksheet[$i]["BR"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BR"])) : date("d/m/Y");
				$data['EXPIREDBY'] = $worksheet[$i]["BS"];
				$data['CREATION_DATE'] = ($worksheet[$i]["BT"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BT"])) : date("d/m/Y");
				$data['CREATED_BY'] = $worksheet[$i]["BU"];
				$data['MODIFIED_DATE'] = ($worksheet[$i]["BV"] !="") ? date("d/m/Y", strtotime($worksheet[$i]["BV"])) : date("d/m/Y");
				$data['MODIFIED_BY'] = $worksheet[$i]["BW"];
				$data['STATUS'] = $worksheet[$i]["BX"];
				$data['NEXT_PAGE'] = $worksheet[$i]["BY"];
				$data['REG_STATUS_ID'] = $worksheet[$i]["BZ"];
				$data['REG_ISACTIVATE'] = $worksheet[$i]["CA"];
				$data['REG_SESSIONID'] = $worksheet[$i]["CB"];
				$data['COMPANYID'] = $worksheet[$i]["CC"];

				$data['API_ISSUED_BY'] = '';//$worksheet[$i]["CD"];
				$data['API_NO'] = '';//$worksheet[$i]["CE"];
				$data['API_FROM'] = date("d/m/Y");//$worksheet[$i]["CF"];
				$data['API_TO'] = date("d/m/Y");//$worksheet[$i]["CG"];
				$data['CONTACT_PHONE_HP'] = '';//$worksheet[$i]["CH"];
				$data['DOMISILI_NO_DOC'] = '';//$worksheet[$i]["CI"];
				$data['NPWP_NO_DOC'] = '';//$worksheet[$i]["CJ"];
				$data['PKP_NO_DOC'] = '';//$worksheet[$i]["CK"];
				$data['SIUP_NO_DOC'] = '';//$worksheet[$i]["CL"];
				$data['TDP_NO_DOC'] = '';//$worksheet[$i]["CM"];
				$data['STATUS_PERUBAHAN'] = 0;//$worksheet[$i]["CN"];
				$data['STATUS_ADJ'] = 0;//$worksheet[$i]["CO"];
				$data['PERFORMANCE'] = 0;//$worksheet[$i]["CP"];
				$data['REQ_PASS_ID'] = '';//$worksheet[$i]["CQ"];
				
				$result 			= $this->addVndhisheader($data);
			} else {
				echo "gagal";die;
			}

		} 

	// die;
	}

	public function addVndhisheader($data)
	{
		$SQL = "
		INSERT INTO HIST_VND_HEADER (
		VND_TRAIL_ID,
		VENDOR_ID,
		VENDOR_NAME,
		LOGIN_ID,
		PASSWORD,
		EMAIL_ADDRESS,
		VENDOR_NO,
		PREFIX,
		PREFIX_OTHER,
		SUFFIX,
		SUFFIX_OTHER,
		ADDRESS_STREET,
		ADDRESS_CITY,
		ADDRES_PROP,
		ADDRESS_POSTCODE,
		ADDRESS_COUNTRY,
		ADDRESS_PHONE_NO,
		ADDRESS_WEBSITE,
		ADDRESS_DOMISILI_NO,
		ADDRESS_DOMISILI_DATE,

		ADDRESS_DOMISILI_EXP_DATE,
		CONTACT_NAME,
		CONTACT_POS,
		CONTACT_PHONE_NO,
		CONTACT_EMAIL,
		NPP,
		NPP_DATE,
		NPWP_NO,
		NPWP_ADDRESS,
		NPWP_CITY,
		NPWP_PROP,
		NPWP_POSTCODE,
		NPWP_PKP,
		NPWP_PKP_NO,
		VENDOR_TYPE,
		SIUP_IUJK_TYPE,
		SIUP_ISSUED_BY,
		SIUP_NO,
		SIUP_TYPE,
		SIUP_FROM,
		SIUP_TO,
		TDP_ISSUED_BY,
		TDP_NO,
		TDP_FROM,
		TDP_TO,
		AGEN_ISSUED_BY,
		AGEN_FROM,
		AGEN_TO,
		IMP_ISSUED_BY,
		IMP_FROM,
		IMP_TO,

		ATT_ORG,
		FIN_AKTA_MDL_DSR_CURR,
		FIN_AKTA_MDL_DSR,
		FIN_AKTA_MDL_STR_CURR,
		FIN_AKTA_MDL_STR,
		FIN_ASSET_MDL_DSR_CUR,
		FIN_ASSET_MDL_DSR,
		FIN_RPT_CURRENCY,
		FIN_RPT_YEAR,
		FIN_RPT_TYPE,
		FIN_RPT_ASSET_VALUE,
		FIN_RPT_HUTANG,
		FIN_RPT_REVENUE,
		FIN_RPT_NETINCOME,
		FIN_CLASS,
		SMK_NO,


		SMK_DATE,
		SMK_EXPIRED,
		EXPIREDFROM,
		EXPIREDTO,
		EXPIREDBY,
		CREATION_DATE,
		CREATED_BY,
		MODIFIED_DATE,
		MODIFIED_BY,
		STATUS,
		NEXT_PAGE,
		REG_STATUS_ID,
		REG_ISACTIVATE,
		REG_SESSIONID,
		COMPANYID,
		API_ISSUED_BY,
		API_NO,
		API_FROM,
		API_TO,

		CONTACT_PHONE_HP,
		DOMISILI_NO_DOC,
		NPWP_NO_DOC,
		PKP_NO_DOC,
		SIUP_NO_DOC,
		TDP_NO_DOC
		)  
		values
		(
		3,
		" . $data['VENDOR_ID'] . ",
		'" . $data['VENDOR_NAME'] . "',
		'" . $data['LOGIN_ID'] . "',
		'" . $data['PASSWORD'] . "',
		'" . $data['EMAIL_ADDRESS'] . "',
		'" . $data['VENDOR_NO'] . "',
		'" . $data['PREFIX'] . "',
		'" . $data['PREFIX_OTHER'] . "', 
		'" . $data['SUFFIX'] . "',
		'" . $data['SUFFIX_OTHER'] . "', 
		'" . $data['ADDRESS_STREET'] . "',
		'" . $data['ADDRESS_CITY'] . "',
		'" . $data['ADDRES_PROP'] . "', 
		'" . $data['ADDRESS_POSTCODE'] . "',
		'" . $data['ADDRESS_COUNTRY'] . "',
		'" . $data['ADDRESS_PHONE_NO'] . "',
		'" . $data['ADDRESS_WEBSITE'] . "', 
		'" . $data['ADDRESS_DOMISILI_NO'] . "',
		TO_DATE('" . $data['ADDRESS_DOMISILI_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),

		TO_DATE('" . $data['ADDRESS_DOMISILI_EXP_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['CONTACT_NAME'] . "',
		'" . $data['CONTACT_POS'] . "',
		'" . $data['CONTACT_PHONE_NO'] . "',
		'" . $data['CONTACT_EMAIL'] . "',
		'" . $data['NPP'] . "',
		TO_DATE('" . $data['NPP_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['NPWP_NO'] . "',
		'" . $data['NPWP_ADDRESS'] . "', 
		'" . $data['NPWP_CITY'] . "',
		'" . $data['NPWP_PROP'] . "', 
		'" . $data['NPWP_POSTCODE'] . "',
		'" . $data['NPWP_PKP'] . "',
		'" . $data['NPWP_PKP_NO'] . "',
		'" . $data['VENDOR_TYPE'] . "',
		'" . $data['SIUP_IUJK_TYPE'] . "',
		'" . $data['SIUP_ISSUED_BY'] . "',
		'" . $data['SIUP_NO'] . "',
		'" . $data['SIUP_TYPE'] . "',
		TO_DATE('" . $data['SIUP_FROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['SIUP_TO'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['TDP_ISSUED_BY'] . "',
		'" . $data['TDP_NO'] . "',
		TO_DATE('" . $data['TDP_FROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['TDP_TO'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['AGEN_ISSUED_BY'] . "',
		TO_DATE('" . $data['AGEN_FROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['AGEN_TO'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['IMP_ISSUED_BY'] . "',
		TO_DATE('" . $data['IMP_FROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['IMP_TO'] . "', 'dd/mm/yyyy hh24:mi:ss'),

		'" . $data['ATT_ORG'] . "',
		'" . $data['FIN_AKTA_MDL_DSR_CURR'] . "',
		" . $data['FIN_AKTA_MDL_DSR'] . ",
		'" . $data['FIN_AKTA_MDL_STR_CURR'] . "',
		" . $data['FIN_AKTA_MDL_STR'] . ",
		'" . $data['FIN_ASSET_MDL_DSR_CUR'] . "', 
		" . $data['FIN_ASSET_MDL_DSR'] . ",
		'" . $data['FIN_RPT_CURRENCY'] . "',
		" . $data['FIN_RPT_YEAR'] . ",
		'" . $data['FIN_RPT_TYPE'] . "', 
		" . $data['FIN_RPT_ASSET_VALUE'] . ",
		" . $data['FIN_RPT_HUTANG'] . ",
		" . $data['FIN_RPT_REVENUE'] . ",
		" . $data['FIN_RPT_NETINCOME'] . ",
		'" . $data['FIN_CLASS'] . "',
		'" . $data['SMK_NO'] . "',

		TO_DATE('" . $data['SMK_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['SMK_EXPIRED'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['EXPIREDFROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['EXPIREDTO'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['EXPIREDBY'] . "',
		TO_DATE('" . $data['CREATION_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['CREATED_BY'] . "',
		TO_DATE('" . $data['MODIFIED_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['MODIFIED_BY'] . "',
		'" . $data['STATUS'] . "',
		'" . $data['NEXT_PAGE'] . "',
		'" . $data['REG_STATUS_ID'] . "',
		'" . $data['REG_ISACTIVATE'] . "',
		'" . $data['REG_SESSIONID'] . "',
		'" . $data['COMPANYID'] . "',
		'" . $data['API_ISSUED_BY'] . "', 
		'" . $data['API_NO'] . "',
		TO_DATE('" . $data['API_FROM'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['API_TO'] . "', 'dd/mm/yyyy hh24:mi:ss'),


		'" . $data['CONTACT_PHONE_HP'] . "',
		'" . $data['DOMISILI_NO_DOC'] . "', 
		'" . $data['NPWP_NO_DOC'] . "',
		'" . $data['PKP_NO_DOC'] . "',
		'" . $data['SIUP_NO_DOC'] . "',
		'" . $data['TDP_NO_DOC'] . "'

		)
		";
		$this -> db -> query($SQL);
	}


	public function getVendor($VENDOR_NO) {
		$SQL = "
		SELECT * FROM VND_PRODUCT VP LEFT JOIN VND_HEADER VH
		ON VP.VENDOR_ID = VH.VENDOR_ID
		WHERE VENDOR_NO LIKE '%".$VENDOR_NO."%'
		AND COMPANYID = 4000
		AND PRODUCT_CODE LIKE '%9%'
		";
		//echo $SQL;die;
		$result = $this -> db -> query($SQL);
		return (array)$result -> result_array();
	}

	public function addVendor($data) {
		$this -> db -> insert($this -> tableVnd_product, $data);
	}

	public function addHistVendor($data) {
		$this -> db -> insert($this -> tableHistVnd_product, $data);
	}

	public function updateVendor($set, $where) {
		$this->db->where($where);
		return $this->db->update($this->tableVnd_product, $set);
	}

	public function uploaddatavproduct($filename)
	{
		$this->load->library('excel');
		ini_set('memory_limit', '-1');

		$target_file = './upload/temp/';
		$buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/temp/") : false;
		move_uploaded_file($_FILES["import_excel"]["tmp_name"], $target_file.$_FILES['import_excel']['name']);


		$inputFileName = './upload/temp/'.$_FILES['import_excel']['name'];
		try {
			$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		} catch(Exception $e) {
			die('Error loading file :' . $e->getMessage());
		}

		$worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$numRows = count($worksheet);
		// echo "<pre>";
		// print_r($worksheet);
		// echo $worksheet[$i]["A"];
		// die;
		for ($i=2; $i < ($numRows+1) ; $i++) { 
			if($worksheet[$i]["A"]!=""){
				$cekdata = $this->getVendor($worksheet[$i]["A"]);
				if(count($cekdata)>0){
					$data['VENDOR_ID'] = $cekdata[0]['VENDOR_ID'];
					$data['PRODUCT_NAME'] = $worksheet[$i]["D"];
					$data['PRODUCT_CODE'] = $worksheet[$i]["C"];
					$data['PRODUCT_SUBGROUP_NAME'] = $worksheet[$i]["F"];
					$data['PRODUCT_SUBGROUP_CODE'] = $worksheet[$i]["E"];
					$data['PRODUCT_TYPE'] = "SERVICES";
					$this ->addVendor($data);


					$data2['VND_TRAIL_ID'] = 3;
					$data2['VENDOR_ID'] = $cekdata[0]['VENDOR_ID'];
					$data2['PRODUCT_NAME'] = $worksheet[$i]["D"];
					$data2['PRODUCT_CODE'] = $worksheet[$i]["C"];
					$data2['PRODUCT_SUBGROUP_NAME'] = $worksheet[$i]["F"];
					$data2['PRODUCT_SUBGROUP_CODE'] = $worksheet[$i]["E"];
					$data2['PRODUCT_TYPE'] = "SERVICES";
					$this ->addHistVendor($data2);
				}


				// $cekdata = $this->getVendor($data);

				// if(count($cekdata)>0){
				// 	for ($i=0; $i < count($cekdata); $i++) { 
				// 		$VENDOR_NO = $worksheet[$i]["A"];
				// 		if($VENDOR_NO == $cekdata[$i]['VENDOR_NO']){
				// 			$where_edit['VENDOR_ID'] = $cekdata[$i]['VENDOR_ID'];
				// 			$set_edit['PRODUCT_NAME'] = $worksheet[$i]["D"];
				// 			$set_edit['PRODUCT_CODE'] = $worksheet[$i]["C"];
				// 			$set_edit['PRODUCT_SUBGROUP_NAME'] = $worksheet[$i]["F"];
				// 			$set_edit['PRODUCT_SUBGROUP_CODE'] = $worksheet[$i]["E"];
				// 			$this ->updateVendor($set_edit, $where_edit);
				// 		} else {
				// 			$data['VENDOR_ID'] = $cekdata[$i]['VENDOR_ID'];
				// 			$data['PRODUCT_NAME'] = $worksheet[$i]["D"];
				// 			$data['PRODUCT_CODE'] = $worksheet[$i]["C"];
				// 			$data['PRODUCT_SUBGROUP_NAME'] = $worksheet[$i]["F"];
				// 			$data['PRODUCT_SUBGROUP_CODE'] = $worksheet[$i]["E"];
				// 			$this ->addVendor($data);
				// 		}

				// 	}					
				// } else {
				// 	$data['VENDOR_ID'] = $cekdata[0]['VENDOR_ID'];
				// 	$data['PRODUCT_NAME'] = $worksheet[$i]["D"];
				// 	$data['PRODUCT_CODE'] = $worksheet[$i]["C"];
				// 	$data['PRODUCT_SUBGROUP_NAME'] = $worksheet[$i]["F"];
				// 	$data['PRODUCT_SUBGROUP_CODE'] = $worksheet[$i]["E"];
				// 	$this ->addVendor($data);
				// }

			} else {
				echo "gagal";die;
			}

		} 

	// die;
	}

	public function addVndproduct($data)
	{
		$SQL = "
		INSERT INTO VND_BANK (
		VENDOR_ID,
		ACCOUNT_NO,
		ACCOUNT_NAME,
		BANK_NAME,
		BANK_BRANCH,
		ADDRESS,
		CURRENCY,
		SWIFT_CODE,
		BANK_POSTAL_CODE,
		DATE_CREATION,
		MODIFIED_DATE,
		REFERENCE_BANK,
		REFERENCE_FILE
		)  
		values
		(
		" . $data['VENDOR_ID'] . ",
		'" . $data['ACCOUNT_NO'] . "',
		'" . $data['ACCOUNT_NAME'] . "',
		'" . $data['BANK_NAME'] . "',
		'" . $data['BANK_BRANCH'] . "',
		'" . $data['ADDRESS'] . "',
		'" . $data['CURRENCY'] . "',
		'" . $data['SWIFT_CODE'] . "',
		'" . $data['BANK_POSTAL_CODE'] . "',
		TO_DATE('" . $data['DATE_CREATION'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		TO_DATE('" . $data['MODIFIED_DATE'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['REFERENCE_BANK'] . "',
		'" . $data['REFERENCE_FILE'] . "'
		)
		";
		$this -> db -> query($SQL);
	}
}

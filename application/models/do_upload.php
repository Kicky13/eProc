<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class do_upload extends CI_Model {
	protected $tableVnd_header = 'VND_FIN_RPT';

	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}


	public function uploaddataKeuangan($filename)
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
				$data['VND_TRAIL_ID'] = '3';
				$data['VENDOR_ID'] = $worksheet[$i]["A"];
				$data['FIN_RPT_CURRENCY'] = $worksheet[$i]["B"];
				$data['FIN_RPT_YEAR'] = $worksheet[$i]["C"];
				$data['FIN_RPT_TIPE'] = $worksheet[$i]["D"];
				$data['FIN_RPT_ASSET_VALUE'] = $worksheet[$i]["E"];
				$data['FIN_RPT_HUTANG'] = $worksheet[$i]["F"];
				$data['FIN_RPT_REVENUE'] = $worksheet[$i]["G"];
				$data['FIN_RPT_NETINCOME'] = $worksheet[$i]["H"];
				$data['FIN_CLASS'] = '';
				$data['FIN_VALID_FROM'] = '';
				$data['FIN_VALID_TO'] = '';
				// $data['DATE_CREATION'] = date('Y-m-d h:i:s');
				$data['DATE_CREATION'] = date("d/m/Y");

				$data['MODIFIED_DATE'] = '';
				$data['FILE_UPLOAD'] = $_FILES['import_excel']['name'];
				
				$result 			= $this->addVndKeuangan($data);
			} else {
				echo "gagal";die;
			}

		} 

	// die;
	}


	public function addVndKeuangan($data)
	{
		$SQL = "
		INSERT INTO VND_FIN_RPT ( 
			VENDOR_ID,
			FIN_RPT_CURRENCY,
			FIN_RPT_YEAR,
			FIN_RPT_TYPE,
			FIN_RPT_ASSET_VALUE,
			FIN_RPT_HUTANG,
			FIN_RPT_REVENUE,
			FIN_RPT_NETINCOME,
			FIN_CLASS,
			FIN_VALID_FROM,
			FIN_VALID_TO,
			DATE_CREATION,
			MODIFIED_DATE, 
			FILE_UPLOAD
		)  
		values
		(
		" . $data['VENDOR_ID'] . ",
		'" . $data['FIN_RPT_CURRENCY'] . "',
		'" . $data['FIN_RPT_YEAR'] . "', 
		'" . $data['FIN_RPT_TIPE'] . "',
		'" . $data['FIN_RPT_ASSET_VALUE'] . "', 
		'" . $data['FIN_RPT_HUTANG'] . "',
		'" . $data['FIN_RPT_REVENUE'] . "',
		'" . $data['FIN_RPT_NETINCOME'] . "',
		'" . $data['FIN_CLASS'] . "',
		'" . $data['FIN_VALID_FROM'] . "',
		'" . $data['FIN_VALID_TO'] . "',
		TO_DATE('" . $data['DATE_CREATION'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['MODIFIED_DATE'] . "',
		'" . $data['FILE_UPLOAD'] . "'
		)
		";
		// echo $SQL;

		$a = $this -> db -> query($SQL); 

		$HIST = "
		INSERT INTO HIST_VND_FIN_RPT ( 
			VND_TRAIL_ID,
			VENDOR_ID,
			FIN_RPT_CURRENCY,
			FIN_RPT_YEAR,
			FIN_RPT_TYPE,
			FIN_RPT_ASSET_VALUE,
			FIN_RPT_HUTANG,
			FIN_RPT_REVENUE,
			FIN_RPT_NETINCOME,
			FIN_CLASS,
			FIN_VALID_FROM,
			FIN_VALID_TO, 
			FILE_UPLOAD
		)  
		values
		(
		" . $data['VND_TRAIL_ID'] . ",
		" . $data['VENDOR_ID'] . ",
		'" . $data['FIN_RPT_CURRENCY'] . "',
		'" . $data['FIN_RPT_YEAR'] . "', 
		'" . $data['FIN_RPT_TIPE'] . "',
		'" . $data['FIN_RPT_ASSET_VALUE'] . "', 
		'" . $data['FIN_RPT_HUTANG'] . "',
		'" . $data['FIN_RPT_REVENUE'] . "',
		'" . $data['FIN_RPT_NETINCOME'] . "',
		'" . $data['FIN_CLASS'] . "',
		'" . $data['FIN_VALID_FROM'] . "',
		'" . $data['FIN_VALID_TO'] . "', 
		'" . $data['FILE_UPLOAD'] . "'
		)
		";
		// echo $SQL;

		$a = $this -> db -> query($HIST); 
		// exit;
	}



	public function uploaddatapasok($filename)
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
				$data['VND_TRAIL_ID'] = '3';
				$data['VENDOR_ID'] = $worksheet[$i]["A"];
				$data['PRODUCT_NAME'] = $worksheet[$i]["B"];
				$data['PRODUCT_CODE'] = $worksheet[$i]["C"];
				$data['PRODUCT_SUBGROUP_NAME'] = $worksheet[$i]["D"];
				$data['PRODUCT_SUBGROUP_CODE'] = $worksheet[$i]["E"];
				$data['PRODUCT_DESCRIPTION'] = $worksheet[$i]["F"];
				$data['BRAND'] = $worksheet[$i]["G"];
				$data['SOURCE'] = $worksheet[$i]["H"];
				$data['TYPE'] = $worksheet[$i]["I"];
				$data['ISSUED_BY'] = $worksheet[$i]["J"];
				$data['NO'] = $worksheet[$i]["K"]; 
				$data['ISSUED_DATE'] = '';
				$data['EXPIRED_DATE'] = '';
				$data['GROUP_SUBGROUP'] = $worksheet[$i]["N"];
				$data['ISLISTED'] = $worksheet[$i]["O"];
				$data['PRODUCT_TYPE'] = $worksheet[$i]["P"];
				$data['DATE_CREATION'] = date("d/m/Y");
				$data['MODIFIED_DATE'] = '';
				$data['KLASIFIKASI_ID'] = $worksheet[$i]["S"];
				$data['KLASIFIKASI_NAME'] = $worksheet[$i]["T"];
				$data['SUBKLASIFIKASI_ID'] = $worksheet[$i]["U"];
				$data['SUBKLASIFIKASI_NAME'] = $worksheet[$i]["V"];
				$data['KUALIFIKASI_ID'] = $worksheet[$i]["W"];
				$data['KUALIFIKASI_NAME'] = $worksheet[$i]["X"];
				$data['SUBKUALIFIKASI_ID'] = $worksheet[$i]["Y"];
				$data['SUBKUALIFIKASI_NAME'] = $worksheet[$i]["Z"];
				$data['FILE_UPLOAD'] = $_FILES['import_excel']['name'];

				$result 			= $this->addVndPasok($data);
			} else {
				echo "gagal";die;
			}

		} 

	// die;
	}

	public function addVndPasok($data)
	{
		$SQL = "
		INSERT INTO VND_PRODUCT ( 
			VENDOR_ID,
			PRODUCT_NAME,
			PRODUCT_CODE,
			PRODUCT_SUBGROUP_NAME,
			PRODUCT_SUBGROUP_CODE,
			PRODUCT_DESCRIPTION,
			BRAND,
			SOURCE,
			TYPE,
			ISSUED_BY,
			NO,
			ISSUED_DATE,
			EXPIRED_DATE, 
			GROUP_SUBGROUP,
			ISLISTED,
			PRODUCT_TYPE,
			DATE_CREATION,
			MODIFIED_DATE,
			KLASIFIKASI_ID,
			KLASIFIKASI_NAME,
			SUBKLASIFIKASI_ID,
			SUBKLASIFIKASI_NAME,
			KUALIFIKASI_ID,
			KUALIFIKASI_NAME,
			SUBKUALIFIKASI_ID,
			SUBKUALIFIKASI_NAME,
			FILE_UPLOAD
		)  
		values
		(
		" . $data['VENDOR_ID'] . ",
		'" . $data['PRODUCT_NAME'] . "',
		'" . $data['PRODUCT_CODE'] . "', 
		'" . $data['PRODUCT_SUBGROUP_NAME'] . "',
		'" . $data['PRODUCT_SUBGROUP_CODE'] . "', 
		'" . $data['PRODUCT_DESCRIPTION'] . "',
		'" . $data['BRAND'] . "',
		'" . $data['SOURCE'] . "',
		'" . $data['TYPE'] . "',
		'" . $data['ISSUED_BY'] . "',
		'" . $data['NO'] . "',
		'" . $data['ISSUED_DATE'] . "',
		'" . $data['EXPIRED_DATE'] . "',
		'" . $data['GROUP_SUBGROUP'] . "',
		'" . $data['ISLISTED'] . "',
		'" . $data['PRODUCT_TYPE'] . "',
		TO_DATE('" . $data['DATE_CREATION'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['MODIFIED_DATE'] . "',
		'" . $data['KLASIFIKASI_ID'] . "',
		'" . $data['KLASIFIKASI_NAME'] . "',
		'" . $data['SUBKLASIFIKASI_ID'] . "',
		'" . $data['SUBKLASIFIKASI_NAME'] . "',
		'" . $data['KUALIFIKASI_ID'] . "',
		'" . $data['KUALIFIKASI_NAME'] . "',
		'" . $data['SUBKUALIFIKASI_ID'] . "',
		'" . $data['SUBKUALIFIKASI_NAME'] . "',
		'" . $data['FILE_UPLOAD'] . "'
		)
		";
		// echo $SQL;

		$this -> db -> query($SQL);

		$HIST = "
		INSERT INTO HIST_VND_PRODUCT ( 
			VND_TRAIL_ID,
			VENDOR_ID,
			PRODUCT_NAME,
			PRODUCT_CODE,
			BRAND,
			SOURCE,
			TYPE,
			ISSUED_BY,
			NO,
			ISSUED_DATE,
			EXPIRED_DATE, 
			GROUP_SUBGROUP,
			ISLISTED,
			PRODUCT_TYPE,
			PRODUCT_SUBGROUP_NAME,
			PRODUCT_SUBGROUP_CODE,
			PRODUCT_DESCRIPTION_CODE,
			PRODUCT_DESCRIPTION,
			KLASIFIKASI_ID,
			KLASIFIKASI_NAME,
			SUBKLASIFIKASI_ID,
			SUBKLASIFIKASI_NAME,
			KUALIFIKASI_ID,
			KUALIFIKASI_NAME,
			SUBKUALIFIKASI_ID,
			SUBKUALIFIKASI_NAME,
			FILE_UPLOAD
		)  
		values
		(
		" . $data['VND_TRAIL_ID'] . ",
		" . $data['VENDOR_ID'] . ",
		'" . $data['PRODUCT_NAME'] . "',
		'" . $data['PRODUCT_CODE'] . "', 
		'" . $data['BRAND'] . "',
		'" . $data['SOURCE'] . "',
		'" . $data['TYPE'] . "',
		'" . $data['ISSUED_BY'] . "',
		'" . $data['NO'] . "',
		'" . $data['ISSUED_DATE'] . "',
		'" . $data['EXPIRED_DATE'] . "',
		'" . $data['GROUP_SUBGROUP'] . "',
		'" . $data['ISLISTED'] . "',
		'" . $data['PRODUCT_TYPE'] . "',
		'" . $data['PRODUCT_SUBGROUP_NAME'] . "',
		'" . $data['PRODUCT_SUBGROUP_CODE'] . "', 
		'" . $data['PRODUCT_DESCRIPTION'] . "',
		'" . $data['PRODUCT_DESCRIPTION'] . "',
		'" . $data['KLASIFIKASI_ID'] . "',
		'" . $data['KLASIFIKASI_NAME'] . "',
		'" . $data['SUBKLASIFIKASI_ID'] . "',
		'" . $data['SUBKLASIFIKASI_NAME'] . "',
		'" . $data['KUALIFIKASI_ID'] . "',
		'" . $data['KUALIFIKASI_NAME'] . "',
		'" . $data['SUBKUALIFIKASI_ID'] . "',
		'" . $data['SUBKUALIFIKASI_NAME'] . "',
		'" . $data['FILE_UPLOAD'] . "'
		)
		";
		// exit;
		 $B = $this -> db -> query($HIST);
		//  if($B){
		// 	 echo "<script>alert('sukses');</script>";
		// }else{
		// 	 echo "<script>alert('gagal');</script>";
		// }
	}



	public function uploaddatacert($filename)
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
				$data['VND_TRAIL_ID'] = '3';
				$data['VENDOR_ID'] = $worksheet[$i]["A"];
				$data['CERT_NAME'] = $worksheet[$i]["B"];
				$data['ISSUED_BY'] = $worksheet[$i]["C"];
				$data['TYPE'] = $worksheet[$i]["D"];
				$data['TYPE_OTHER'] = $worksheet[$i]["E"];
				$data['VALID_FROM'] = '';
				$data['VALID_TO'] = '';
				// $VALID_FROM1 = explode(' ', $worksheet[$i]["F"]);
				// echo $VALID_FROM = $VALID_FROM1[0];
				// $VALID_TO1 = explode(' ', $worksheet[$i]["G"]);
				// echo $VALID_TO = $VALID_TO1[0];
				$data['CERT_NO'] = $worksheet[$i]["H"];
				$data['CERT_NO_DOC'] = $worksheet[$i]["I"];
				$data['DATE_CREATION'] = date("d/m/Y");
				$data['MODIFIED_DATE'] = ''; 

				$result 			= $this->addVndCert($data);
			} else {
				echo "gagal";die;
			}

		} 

	// die;
	}

	public function addVndCert($data)
	{
		$SQL = "
		INSERT INTO VND_CERT ( 
			VENDOR_ID,
			CERT_NAME,
			ISSUED_BY,
			TYPE,
			TYPE_OTHER,
			VALID_FROM,
			VALID_TO,
			CERT_NO,
			CERT_NO_DOC,
			DATE_CREATION,
			MODIFIED_DATE
		)  
		values
		(
			" . $data['VENDOR_ID'] . ",
			'" . $data['CERT_NAME'] . "',
			'" . $data['ISSUED_BY'] . "', 
			'" . $data['TYPE'] . "',
			'" . $data['TYPE_OTHER'] . "',  
			'" . $data['VALID_FROM'] . "',  
			'" . $data['VALID_TO'] . "',  
			'" . $data['CERT_NO'] . "',
			'" . $data['CERT_NO_DOC'] . "',
			TO_DATE('" . $data['DATE_CREATION'] . "', 'dd/mm/yyyy hh24:mi:ss'),
			'" . $data['MODIFIED_DATE'] . "'
		)
		";
		// echo $SQL;

		$this -> db -> query($SQL);
		// exit;
		$HIST = "
		INSERT INTO HIST_VND_CERT ( 
			VND_TRAIL_ID,
			VENDOR_ID,
			CERT_NAME,
			ISSUED_BY,
			TYPE,
			TYPE_OTHER,
			VALID_FROM,
			VALID_TO,
			CERT_NO,
			CERT_NO_DOC
		)  
		values
		(
			" . $data['VND_TRAIL_ID'] . ",
			" . $data['VENDOR_ID'] . ",
			'" . $data['CERT_NAME'] . "',
			'" . $data['ISSUED_BY'] . "', 
			'" . $data['TYPE'] . "',
			'" . $data['TYPE_OTHER'] . "',  
			'" . $data['VALID_FROM'] . "',  
			'" . $data['VALID_TO'] . "',  
			'" . $data['CERT_NO'] . "',
			'" . $data['CERT_NO_DOC'] . "'
		)
		";
		// echo $SQL;

		$this -> db -> query($HIST);
		// exit;
	} 



	public function uploaddatapeng($filename)
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
				$data['VND_TRAIL_ID'] = '3';
				$data['VENDOR_ID'] = $worksheet[$i]["A"];
				$data['CLIENT_NAME'] = $worksheet[$i]["B"];
				$data['PROJECT_NAME'] = $worksheet[$i]["C"];
				$data['CURRENCY'] = $worksheet[$i]["D"];
				$data['AMOUNT'] = $worksheet[$i]["E"];
				$data['START_DATE'] = '';
				$data['END_DATE'] = '';
				$data['CONTACT_PERSON'] = $worksheet[$i]["H"];
				$data['CONTACT_NO'] = $worksheet[$i]["I"];
				$data['CONTRACT_NO'] = $worksheet[$i]["J"];
				$data['DESCRIPTION'] = $worksheet[$i]["K"];
				$data['CLIENT_NAME_DOC'] = $worksheet[$i]["L"];
				$data['DATE_CREATION'] = date("d/m/Y");
				$data['MODIFIED_DATE'] = '';
				
				// $VALID_FROM1 = explode(' ', $worksheet[$i]["F"]);
				// echo $VALID_FROM = $VALID_FROM1[0];
				// $VALID_TO1 = explode(' ', $worksheet[$i]["G"]);
				// echo $VALID_TO = $VALID_TO1[0];
				// $data['CERT_NO'] = $worksheet[$i]["H"];
				// $data['CERT_NO_DOC'] = $worksheet[$i]["I"];
				// $data['DATE_CREATION'] = date("d/m/Y");
				// $data['MODIFIED_DATE'] = ''; 

				$result 			= $this->addVndpeng($data);
			} else {
				echo "gagal";die;
			}

		} 

	// die;
	}

	public function addVndpeng($data)
	{
		$SQL = "
		INSERT INTO VND_CV ( 
			VENDOR_ID,
			CLIENT_NAME,
			PROJECT_NAME,
			CURRENCY,
			AMOUNT,
			START_DATE,
			END_DATE,
			CONTACT_PERSON,
			CONTACT_NO,
			CONTRACT_NO,
			DESCRIPTION,
			CLIENT_NAME_DOC,
			DATE_CREATION,
			MODIFIED_DATE
		)  
		values
		(
			" . $data['VENDOR_ID'] . ",
			'" . $data['CLIENT_NAME'] . "',
			'" . $data['PROJECT_NAME'] . "', 
			'" . $data['CURRENCY'] . "',
			'" . $data['AMOUNT'] . "',  
			'" . $data['START_DATE'] . "',  
			'" . $data['END_DATE'] . "',  
			'" . $data['CONTACT_PERSON'] . "',
			'" . $data['CONTACT_NO'] . "',
			'" . $data['CONTRACT_NO'] . "',
			'" . $data['DESCRIPTION'] . "',
			'" . $data['CLIENT_NAME_DOC'] . "',
			TO_DATE('" . $data['DATE_CREATION'] . "', 'dd/mm/yyyy hh24:mi:ss'),
			'" . $data['MODIFIED_DATE'] . "'
		)
		";
		// echo $SQL;

		$this -> db -> query($SQL);
	

		$HIST = "
		INSERT INTO HIST_VND_CV ( 
			VND_TRAIL_ID,
			VENDOR_ID,
			CLIENT_NAME,
			PROJECT_NAME,
			CURRENCY,
			AMOUNT,
			START_DATE,
			END_DATE,
			CONTACT_PERSON,
			CONTACT_NO,
			CONTRACT_NO,
			CLIENT_NAME_DOC,
			DESCRIPTION
		)  
		values
		(
			" . $data['VND_TRAIL_ID'] . ",
			" . $data['VENDOR_ID'] . ",
			'" . $data['CLIENT_NAME'] . "',
			'" . $data['PROJECT_NAME'] . "', 
			'" . $data['CURRENCY'] . "',
			'" . $data['AMOUNT'] . "',  
			'" . $data['START_DATE'] . "',  
			'" . $data['END_DATE'] . "',  
			'" . $data['CONTACT_PERSON'] . "',
			'" . $data['CONTACT_NO'] . "',
			'" . $data['CONTRACT_NO'] . "',
			'" . $data['CLIENT_NAME_DOC'] . "',
			'" . $data['DESCRIPTION'] . "' 
		)
		";
		// echo $HIST;

		$this -> db -> query($HIST);
		// exit;
	}

	public function uploaddatasuplay($filename)
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
				$data['VND_TRAIL_ID'] = '3';
				$data['VENDOR_ID'] = $worksheet[$i]["A"];
				$data['PRODUCT_NAME'] = $worksheet[$i]["B"];
				$data['PRODUCT_CODE'] = $worksheet[$i]["C"];
				$data['PRODUCT_SUBGROUP_NAME'] = $worksheet[$i]["D"];
				$data['PRODUCT_SUBGROUP_CODE'] = $worksheet[$i]["E"];
				$data['PRODUCT_DESCRIPTION'] = $worksheet[$i]["F"];
				$data['BRAND'] = $worksheet[$i]["G"];
				$data['SOURCE'] = $worksheet[$i]["H"];
				$data['TYPE'] = $worksheet[$i]["I"];
				$data['ISSUED_BY'] = $worksheet[$i]["J"];
				$data['NO'] = $worksheet[$i]["K"]; 
				$data['ISSUED_DATE'] = '';
				$data['EXPIRED_DATE'] = '';
				$data['GROUP_SUBGROUP'] = $worksheet[$i]["N"];
				$data['ISLISTED'] = $worksheet[$i]["O"];
				$data['PRODUCT_TYPE'] = $worksheet[$i]["P"];
				$data['DATE_CREATION'] = date("d/m/Y");
				$data['MODIFIED_DATE'] = '';
				$data['KLASIFIKASI_ID'] = $worksheet[$i]["S"];
				$data['KLASIFIKASI_NAME'] = $worksheet[$i]["T"];
				$data['SUBKLASIFIKASI_ID'] = $worksheet[$i]["U"];
				$data['SUBKLASIFIKASI_NAME'] = $worksheet[$i]["V"];
				$data['KUALIFIKASI_ID'] = $worksheet[$i]["W"];
				$data['KUALIFIKASI_NAME'] = $worksheet[$i]["X"];
				$data['SUBKUALIFIKASI_ID'] = $worksheet[$i]["Y"];
				$data['SUBKUALIFIKASI_NAME'] = $worksheet[$i]["Z"];
				$data['FILE_UPLOAD'] = $_FILES['import_excel']['name'];

				$result 			= $this->addVndSuplay($data);
			} else {
				echo "gagal";die;
			}

		} 

	// die;
	}

	public function addVndSuplay($data)
	{
		$SQL = "
		INSERT INTO VND_PRODUCT ( 
			VENDOR_ID,
			PRODUCT_NAME,
			PRODUCT_CODE,
			PRODUCT_SUBGROUP_NAME,
			PRODUCT_SUBGROUP_CODE,
			PRODUCT_DESCRIPTION,
			BRAND,
			SOURCE,
			TYPE,
			ISSUED_BY,
			NO,
			ISSUED_DATE,
			EXPIRED_DATE, 
			GROUP_SUBGROUP,
			ISLISTED,
			PRODUCT_TYPE,
			DATE_CREATION,
			MODIFIED_DATE,
			KLASIFIKASI_ID,
			KLASIFIKASI_NAME,
			SUBKLASIFIKASI_ID,
			SUBKLASIFIKASI_NAME,
			KUALIFIKASI_ID,
			KUALIFIKASI_NAME,
			SUBKUALIFIKASI_ID,
			SUBKUALIFIKASI_NAME,
			FILE_UPLOAD
		)  
		values
		(
		" . $data['VENDOR_ID'] . ",
		'" . $data['PRODUCT_NAME'] . "',
		'" . $data['PRODUCT_CODE'] . "', 
		'" . $data['PRODUCT_SUBGROUP_NAME'] . "',
		'" . $data['PRODUCT_SUBGROUP_CODE'] . "', 
		'" . $data['PRODUCT_DESCRIPTION'] . "',
		'" . $data['BRAND'] . "',
		'" . $data['SOURCE'] . "',
		'" . $data['TYPE'] . "',
		'" . $data['ISSUED_BY'] . "',
		'" . $data['NO'] . "',
		'" . $data['ISSUED_DATE'] . "',
		'" . $data['EXPIRED_DATE'] . "',
		'" . $data['GROUP_SUBGROUP'] . "',
		'" . $data['ISLISTED'] . "',
		'" . $data['PRODUCT_TYPE'] . "',
		TO_DATE('" . $data['DATE_CREATION'] . "', 'dd/mm/yyyy hh24:mi:ss'),
		'" . $data['MODIFIED_DATE'] . "',
		'" . $data['KLASIFIKASI_ID'] . "',
		'" . $data['KLASIFIKASI_NAME'] . "',
		'" . $data['SUBKLASIFIKASI_ID'] . "',
		'" . $data['SUBKLASIFIKASI_NAME'] . "',
		'" . $data['KUALIFIKASI_ID'] . "',
		'" . $data['KUALIFIKASI_NAME'] . "',
		'" . $data['SUBKUALIFIKASI_ID'] . "',
		'" . $data['SUBKUALIFIKASI_NAME'] . "',
		'" . $data['FILE_UPLOAD'] . "'
		)
		";
		// echo $SQL;

		$this -> db -> query($SQL);
		// exit;
		$HIST = "
		INSERT INTO HIST_VND_PRODUCT ( 
			VND_TRAIL_ID,
			VENDOR_ID,
			PRODUCT_NAME,
			PRODUCT_CODE,
			BRAND,
			SOURCE,
			TYPE,
			ISSUED_BY,
			NO,
			ISSUED_DATE,
			EXPIRED_DATE, 
			GROUP_SUBGROUP,
			ISLISTED,
			PRODUCT_TYPE,
			PRODUCT_SUBGROUP_NAME,
			PRODUCT_SUBGROUP_CODE,
			PRODUCT_DESCRIPTION_CODE,
			PRODUCT_DESCRIPTION,
			KLASIFIKASI_ID,
			KLASIFIKASI_NAME,
			SUBKLASIFIKASI_ID,
			SUBKLASIFIKASI_NAME,
			KUALIFIKASI_ID,
			KUALIFIKASI_NAME,
			SUBKUALIFIKASI_ID,
			SUBKUALIFIKASI_NAME,
			FILE_UPLOAD
		)  
		values
		(
		" . $data['VND_TRAIL_ID'] . ",
		" . $data['VENDOR_ID'] . ",
		'" . $data['PRODUCT_NAME'] . "',
		'" . $data['PRODUCT_CODE'] . "', 
		'" . $data['BRAND'] . "',
		'" . $data['SOURCE'] . "',
		'" . $data['TYPE'] . "',
		'" . $data['ISSUED_BY'] . "',
		'" . $data['NO'] . "',
		'" . $data['ISSUED_DATE'] . "',
		'" . $data['EXPIRED_DATE'] . "',
		'" . $data['GROUP_SUBGROUP'] . "',
		'" . $data['ISLISTED'] . "',
		'" . $data['PRODUCT_TYPE'] . "',
		'" . $data['PRODUCT_SUBGROUP_NAME'] . "',
		'" . $data['PRODUCT_SUBGROUP_CODE'] . "', 
		'" . $data['PRODUCT_DESCRIPTION'] . "',
		'" . $data['PRODUCT_DESCRIPTION'] . "',
		'" . $data['KLASIFIKASI_ID'] . "',
		'" . $data['KLASIFIKASI_NAME'] . "',
		'" . $data['SUBKLASIFIKASI_ID'] . "',
		'" . $data['SUBKLASIFIKASI_NAME'] . "',
		'" . $data['KUALIFIKASI_ID'] . "',
		'" . $data['KUALIFIKASI_NAME'] . "',
		'" . $data['SUBKUALIFIKASI_ID'] . "',
		'" . $data['SUBKUALIFIKASI_NAME'] . "',
		'" . $data['FILE_UPLOAD'] . "'
		)
		";
		// echo $SQL;

		$this -> db -> query($HIST);
		// exit;
	}
 
}

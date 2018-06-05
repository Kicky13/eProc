<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_pdf extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->ci = &get_instance();
		$this->load->library('Layout');
		$this->load->library('M_pdf');
	}

	// public function index(){
	// 	$kodevendor = '0000110016';
	// 	$kodematerial = '119-200151';
	// 	$idpengiriman = '6';
	// 	$this->make_formpermintaanpengiriman($kodevendor,$kodematerial,$idpengiriman);
	// }

	function cobaSAP()
	{
		$start 	= date("20170101");					// Date start VMI apps
		$end 	= date("Ymd");						// Date Now
	
        	require_once APPPATH.'third_party/sapclasses/sap.php';
            $sap = new SAPConnection();
            $sap->Connect(APPPATH."third_party/sapclasses/logon_dataProdReal.conf");
            
            if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
            if ($sap->GetStatus() != SAPRFC_OK ) {
                echo $sap->PrintStatus();
                exit;
            }else{
            	echo "Berhasil 1<br>";
            }

        $fce = &$sap->NewFunction ("Z_ZCMM_VMI_PO_DETAILC");
		if ($fce == false) {
                $sap->PrintStatus();
                exit;
         }else{
         	echo "Berhasil 2<br>";
         }

		$opco					= '7000';
		$fce->COMPANY 			= "$opco";		// BUKRS
		// $fce->PO_TYPE 			= 'ZK17';
		// $fce->VENDOR 		= ;
		$fce->DATE['SIGN']   	= 'I';
		$fce->DATE['OPTION']	= 'BT';
		$fce->DATE['LOW']    	= $start;
		$fce->DATE['HIGH']    	= $end;
		
		$fce->PO_TYPE->row['SIGN']     	= 'I';
		$fce->PO_TYPE->row['OPTION']   	= 'EQ';
		$fce->PO_TYPE->row['LOW']    	= 'ZK10';
		$fce->PO_TYPE->row['HIGH']    	= '';
		$fce->PO_TYPE->Append($fce->PO_TYPE->row);
		
		$fce->PO_TYPE->row['SIGN']     	= 'I';
		$fce->PO_TYPE->row['OPTION']   	= 'EQ';
		$fce->PO_TYPE->row['LOW']    	= 'ZK17';
		$fce->PO_TYPE->row['HIGH']    	= '';
		$fce->PO_TYPE->Append($fce->PO_TYPE->row);
			
        $fce->call();
        echo "<pre>";
        // echo $fce->statusInfos;
       // print_r($fce);

        if ($fce->GetStatus() == SAPRFC_OK) {
            $fce->T_ITEM->Reset();
            $data=array();
            $empty=0;
            $tampildata=array();
            while ($fce->T_ITEM->Next()) {
            	$tampildata[] = $fce->T_ITEM->row;
				$matnr 		= $fce->T_ITEM->row["MATNR"];	// Kode Material
				$lifnr 		= $fce->T_ITEM->row["LIFNR"];	// Kode Vendor
				$ebeln 		= $fce->T_ITEM->row["EBELN"];	// No PO
				$menge 		= intval($fce->T_ITEM->row["MENGE"]);	// Quantity PO
				$sisaqty	= intval($fce->T_ITEM->row["DELIV_QTY"]);	// Quantity PO Open
				$werks 		= $fce->T_ITEM->row["WERKS"];	// Plant
				$vendor		= $fce->T_ITEM->row["VENDNAME"];	// Nama Vendor
				$material 	= $fce->T_ITEM->row["MAKTX"];	// Nama Material
				$potype 	= $fce->T_ITEM->row["BSART"];	// Type PO
				$mins 		= $fce->T_ITEM->row["EISBE"];	// Min
				$maxs 		= $fce->T_ITEM->row["MABST"];	// Max
				$statuspo	= $fce->T_ITEM->row["ELIKZ"];	// Max
				$start 		= date_format(date_create($fce->T_ITEM->row["BEDAT"]),'d M Y');
				$end 		= date_format(date_create($fce->T_ITEM->row["EINDT"]),'d M Y');
			}
		}

		$fce->Close();
		$sap->Close();
		print_r($tampildata);
	}

	function formSPJ($kodevendor,$kodematerial,$idpengiriman)
	{
		$month = $this->convertmonth(date('m'));
		$r['month']=$month;
		$sql = "select VMI_MASTER.KODE_VENDOR,VMI_MASTER.NAMA_VENDOR,VND_HEADER.ADDRESS_STREET,VND_HEADER.ADDRESS_CITY,VMI_MASTER.NO_PO,to_char(VMI_MASTER.CONTRACT_ACTIVE,'YYYY') as TAHUN_CONTRACT,VND_HEADER.ADDRESS_PHONE_NO
					from VMI_DELIVERY
						join VMI_MASTER on VMI_MASTER.ID_LIST=VMI_DELIVERY.ID_LIST
						join VND_HEADER on VND_HEADER.VENDOR_NO=VMI_MASTER.KODE_VENDOR
					WHERE VMI_MASTER.KODE_VENDOR='".$kodevendor."'";
		$dataVendor = $this->db->query($sql)->row_array();
		$r['dataVendor'] = $dataVendor;
		$sql = "select VMI_DELIVERY.KODE_MATERIAL,VMI_MASTER.NAMA_MATERIAL,VMI_DELIVERY.QUANTITY,VMI_MASTER.NO_PO,VMI_MASTER.QUANTITY as SISA_PO
	from VMI_DELIVERY
		join VMI_MASTER on VMI_MASTER.ID_LIST=VMI_DELIVERY.ID_LIST
	where VMI_DELIVERY.KODE_MATERIAL='".$kodematerial."' and VMI_MASTER.KODE_VENDOR='".$kodevendor."' and VMI_DELIVERY.ID_PENGIRIMAN='".$idpengiriman."' AND ROWNUM<=1
ORDER BY ID_PENGIRIMAN desc";
		$dataPengiriman =  $this->db->query($sql)->result_array();
		$r['dataPengiriman'] = $dataPengiriman;
		$html = $this->load->view('VMI/vmi_formpermintaanpengiriman',$r,true);
		$mpdf = new M_pdf();
		$mpdf->pdf->writeHTML($html);
		$mpdf->pdf->output('Form Permintaan Pengiriman '.$dataVendor['NAMA_VENDOR'].'.pdf', 'I');
	}

	function convertmonth($month)
	{
		switch ($month) {
			case '1':
				return 'Januari';
			case '2':
				return 'Februari';
			case '3':
				return 'Maret';
			case '4':
				return 'April';
			case '5':
				return 'Mei';
			case '6':
				return 'Juni';
			case '7':
				return 'Juli';
			case '8':
				return 'Agustus';				
			case '9':
				return 'September';
			case '10':
				return 'Oktober';
			case '11':
				return 'November';
			case '12':
				return 'Desember';
		}
	}

}
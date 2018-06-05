<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_invoice extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->helper('url');
		$this->load->library('Layout');
		$this->load->helper("security" );
		
	}

	public function index()
	{
		$data ['title'] = 'monitoring_invoice';
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('invoice_monitor', $data);
	}

	public function get_detail($BELNR) {
		$this->load->model('monitor_invoice');
		$this->input->get('checked');
		$data['BELNR'] = $this->monitor_invoice->emp($BELNR,$this->input->get('checked'));
		echo json_encode($data);
	}
	
	public function get_data() {
		$this->load->model('monitor_invoice');
		$venno = $this->session->userdata['VENDOR_NO'];
		$data['list_inv'] = $this->monitor_invoice->get($venno);
		$data_tabel=array();
		foreach ($data['list_inv'] as $line) {
			$data_tbl['GJAHR'] = $line['GJAHR'];
			$data_tbl['BELNR'] = $line['BELNR'];
			$data_tbl['EBELN'] = $line['EBELN'];
			$data_tbl['BKTXT'] = $line['BKTXT'];
			$data_tbl['WRBTR'] = number_format ($line['WRBTR']);
			$data_tbl['WAERS'] = $line['WAERS'];
			$data_tbl['BUDAT'] = date('d M Y', strtotime($line ['BUDAT'] ));
			$data_tbl['STATUS_UKP'] = $line['STATUS_UKP'];
			//$data_tbl['WAERS'] = $line['WAERS'];
			
			$data_tabel[]=$data_tbl;
		}
		$json_data = array('list_inv' => $data_tabel);
		echo json_encode($json_data);
	}
	
	public function sync_inv(){
		$this->load->model('monitor_invoice');
		$this->load->library('sap_handler');
		$invoice = $this->sap_handler->getInvoice();
		print_r($invoice['T_OUT']);
		$inv = array();
		foreach($invoice['T_OUT'] as $value){
			$inv=array(
				"BUKRS"=>$value['BUKRS'],
				"LIFNR"=>$value['LIFNR'],
				"BELNR"=>$value['BELNR'],
				"GJAHR"=>$value['GJAHR'],
				"BIL_NO"=>$value['BIL_NO'],
				"NAME1"=>$value['NAME1'],
				"BKTXT"=>$value['BKTXT'],
				"SGTXT"=>$value['SGTXT'], 
			 	"XBLNR"=>$value['XBLNR'],
			 	"UMSKZ"=>$value['UMSKZ'],
			 	"BUDAT"=>$value['BUDAT'],
			 	"BLDAT"=>$value['BLDAT'], 
			 	"CPUDT"=>$value['CPUDT'],
			 	"MONAT"=>$value['MONAT'],
			 	"ZLSPR"=>$value['ZLSPR'],
			 	"WAERS"=>$value['WAERS'], 
			 	"HWAER"=>$value['HWAER'],
			 	"ZLSCH"=>$value['ZLSCH'],
			 	"ZTERM"=>$value['ZTERM'],
			 	"DMBTR"=>$value['DMBTR'], 
			 	"WRBTR"=>$value['WRBTR'],
			 	"BLART"=>$value['BLART'],
			 	"STATUS"=>$value['STATUS'],
			 	"BYPROV"=>$value['BYPROV'], 
			 	"DATEPROV"=>$value['DATEPROV'],
			 	"DATECOL"=>$value['DATECOL'],
			 	"WWERT"=>$value['WWERT'],
			 	"TGL_KIRUKP"=>$value['TGL_KIRUKP'],
			 	"USER_UKP"=>$value['USER_UKP'],
			 	"STAT_VER"=>$value['STAT_VER'], 
			 	"TGL_VER"=>$value['TGL_VER'],
			 	"TGL_KIRVER"=>$value['TGL_KIRVER'],
			 	"TGL_KEMB_VER"=>$value['TGL_KEMB_VER'], 
			 	"USER_VER"=>$value['USER_VER'],
			 	"STAT_BEND"=>$value['STAT_BEND'],
			 	"TGL_BEND"=>$value['TGL_BEND'], 
			 	"TGL_KIRBEND"=>$value['TGL_KIRBEND'],
			 	"TGL_KEMB_BEN"=>$value['TGL_KEMB_BEN'],
			 	"USER_BEN"=>$value['USER_BEN'], 
			 	"STAT_AKU"=>$value['STAT_AKU'],
			 	"TGL_AKU"=>$value['TGL_AKU'],
			 	"TGL_KEMB_AKU"=>$value['TGL_KEMB_AKU'], 
			 	"U_NAME"=>$value['U_NAME'],
			 	"AUGDT"=>$value['AUGDT'],
			 	"STAT_REJ"=>$value['STAT_REJ'],
			 	"NO_REJECT"=>$value['NO_REJECT'],
			 	"STATUS_UKP"=>$value['STATUS_UKP'],
			 	"NYETATUS"=>$value['NYETATUS'],
			 	"EBELN"=>$value['EBELN'],
			 	"EBELP"=>$value['EBELP'],
			 	"MBELNR"=>$value['MBELNR'],
			 	"MGJAHR"=>$value['MGJAHR'],
			 	"PROJK"=>$value['PROJK'],
			 	"PRCTR"=>$value['PRCTR'],
			 	"HBKID"=>$value['HBKID'],
			 	"DBAYAR"=>$value['DBAYAR'],
			 	"TBAYAR"=>$value['TBAYAR'],
			 	"UBAYAR"=>$value['UBAYAR'],
			 	"DGROUP"=>$value['DGROUP'],
			 	"TGROUP"=>$value['TGROUP'],
			 	"UGROUP"=>$value['UGROUP'],
			 	"LUKP"=>$value['LUKP'],
			 	"LVER"=>$value['LVER'],
			 	"LBEN"=>$value['LBEN'],
			 	"LAKU"=>$value['LAKU'],
			 	"AWTYPE"=>$value['AWTYPE'],
			 	"AWKYE"=>$value['AWKYE'],
			 	"LBEN2"=>$value['LBEN2'],
			 	"MWSKZ"=>$value['MWSKZ'],
			 	"HWBAS"=>$value['HWBAS'],
			 	"FWBAS"=>$value['FWBAS'],
			 	"HWSTE"=>$value['HWSTE'],
			 	"FWSTE"=>$value['FWSTE'],
			 	"WT_QBSHH"=>$value['WT_QBSHH'],
			 	"WT_QBSHB"=>$value['WT_QBSHB']
					     );
			$this->monitor_invoice->insert_inv($inv);
			//exit;
		}
	
	}

	
	
}

/* End of file monitoring_invoice.php */
/* Location: ./application/controllers/monitoring_invoice.php */

 ?>
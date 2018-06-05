<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

	public function __construct() {
            parent::__construct();
            $this->ci = &get_instance();
            $this->load->library('Layout');
            // $this->load->library('Authorization');
			$this->load->model(array('vnd_header'));
            $this->load->model('model_grafik');
            $this->_lot="";
	}

    function echopre($dt){
        echo'<pre>';
            print_r($dt);
        echo'</pre>';
    }

	function index() {
	}
	
	function sendNotif(){

		$sql1 		= "SELECT EMAIL, MATERIAL, VENDOR FROM VMI_NOTIF";
		$dt 		= $this->db->query($sql1)->result_array();
		// $dt			= $this->db->query($sql1)->row();		
		// $to 		= $result->EMAIL;
		// $material 	= $result->MATERIAL;
		// $vendor		= $result->VENDOR;
		echo "<pre>";
		print_r($dt);
		foreach ($dt as $key => $value) {

			$to 		= $value['EMAIL'];
			$material 	= $value['MATERIAL'];
			$vendor 	= $value['VENDOR'];
			$from 	  	= "Tim VMI-Eproc Semen Indonesia";
			$subject  	= "Email Notifikasi untuk Peringatan Perubahan Kebutuhan";
			$cc 	  	= "imam.s@sisi.id	";
			$bcc 	  	= "m.ramzi@sisi.id";
			$message  	= '<html><body><font style = "font-family:"Cambria";size:"12px";">';
			$message 	.= 'Yth. <b>'.$vendor.'</b><br/>';
			$message 	.= 'Mohon melakukan pengecekkan terhadap perubahan nilai prognose pada material <b>'.$material.'</b><br/>';
			$message 	.= '<br/>Demikian Email Pemberitahun ini kami sampaikan<br/>';
			$message 	.= 'Terima Kasih<br/><br/>';
			$message 	.= 'NB : Email ini dikirimkan oleh system. Jangan me-reply email ini. Apabila ada pertanyaan silakan menghubungi Seksi Inventory<br/>';
			$message 	.= '</font></body></html>';

			$this->load->library('email');
			$this->config->load('email');
			$semenindonesia = $this->config->item('semenindonesia');
			$this->email->initialize($semenindonesia['conf']);
			$this->email->from($from);
			$this->email->to($to);
			// $this->email->cc('pengadaan.semenindonesia@gmail.com');
			if(!empty($cc)){
			   $this->email->cc($cc);
			}
			if(!empty($bcc)){
			   $this->email->bcc($bcc);
			}

			if(!empty($attachment)){
			  $this->email->attach($attachment);
			}

			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->send();
		}
		$sql2 		= "delete from VMI_NOTIF";
		$result2	= $this->db->query($sql2);	
	}

	function view() {
		$data['title'] = "Dashboard";
		// $data['listplantAll'] = $this->m_getSelectAllPlant();
		// $data['listplant'] = $this->GetSelectPlant();
		// $data['listcompany'] = $this->m_getSelectCompany();
		// $data['listmaterial'] = $this->m_getSelectMaterial();
		// $data['listvendor'] = $this->m_getSelectVendor();
		// $data['listpplant'] = $this->getVMIPlant();
		// $data['listnewmaterial'] = $this->getSelectMaterialNew();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_datetimepicker();
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('pages/vmi_all.js');
		$this->layout->render('vmi_company_list',$data);	// Panggil RFC --> GetAllPO
	}
	
	function filter() {
		$data['title'] = "Dashboard";
		$cawal = $this->input->post('Cawal');
		$cakhir = $this->input->post('Cakhir');
		$arrCawal = explode("/",$cawal);
		$arrCakhir = explode("/",$cakhir);
		$tglawal = $arrCawal[2].$arrCawal[1].$arrCawal[0];
		$tglakhir = $arrCakhir[2].$arrCakhir[1].$arrCakhir[0];
		
		$data['tabledata'] = $this->GetAllPOFilter($tglawal,$tglakhir);
		// echo "<pre>";
		// echo $tglawal;
		// echo "<br>";
		// echo $tglakhir;
		// print_r($data['tabledata']);

		// $data['listplantAll'] = $this->m_getSelectAllPlant();
		// $data['listplant'] = $this->GetSelectPlant();
		// $data['listcompany'] = $this->m_getSelectCompany();
		// $data['listmaterial'] = $this->m_getSelectMaterial();
		// $data['listvendor'] = $this->m_getSelectVendor();
		// $data['listpplant'] = $this->getVMIPlant();
		// $data['listnewmaterial'] = $this->getSelectMaterialNew();
		
		// $this->layout->set_table_js();
		// $this->layout->set_table_cs();
		// $this->layout->set_datetimepicker();
		// $this->layout->add_js('plugins/select2/select2.js');
		// $this->layout->add_css('plugins/select2/select2.css');
		// $this->layout->add_css('plugins/select2/select2-bootstrap.css');
		// $this->layout->add_js('pages/vmi_all.js');
		// $this->layout->render('vmi_company_list_filter',$data);	// Panggil RFC --> GetAllPOFilter
	}
	
	function income() {
		$data['title'] = "Incoming";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_datetimepicker();
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('pages/vmi_income.js');
		$this->layout->render('vmi_income_list',$data);		// GetDataDBIncome
	}
	
	function grafik(){
		// echo "HAHAHA";
		$data['title'] = "Grafik";
		$data['list'] = $this->model_grafik->get_list()->result();
		$data['value'] = $this->GetRealisasi($data['list']);
		$data['view'] = $this->model_grafik->get_prognose()->result();
		// $data['list_gi'] = $this->model_grafik->get_gi()->result();
		// $data['grgi'] = $this->model_grafik->get_gr()->result();
		// $data['deliv'] = $this->model_grafik->get_deliv()->result();
		$this->layout->render('vmi_company_grafik',$data);	// Panggil --> GetDataDB
	}
	
	function upload(){
		$data['title'] = "Upload";
		$this->layout->render('vmi_company_upload',$data);	// Panggil --> GetDataDB
	}
	
	function getstock(){
			require_once APPPATH.'third_party/sapclasses/sap.php';
            $ssap = new SAPConnection();
            $ssap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
            if ($ssap->GetStatus() == SAPRFC_OK ) $ssap->Open ();
            if ($ssap->GetStatus() != SAPRFC_OK ) {
                echo $ssap->PrintStatus();
                exit;
            }
			$fce = &$ssap->NewFunction ("ZCMM_MASTER_MATERIAL");

			if ($fce == false) {
				$ssap->PrintStatus();
				exit;
			}
			$sql = "SELECT PLANT,KODE_MATERIAL
					from VMI_MASTER 
					where STATUS = '1'
					order by id_list asc";
			$dt = $this->db->query($sql)->result_array();
			foreach ($dt as $key => $value) {
				
				$komat = $value['KODE_MATERIAL'];
				$plant = $value['PLANT'];
				
				$fce->R_MATNR->row['SIGN']     = 'I';
				$fce->R_MATNR->row['OPTION']   = 'EQ';
				$fce->R_MATNR->row['LOW']      = $komat;
				$fce->R_MATNR->row['HIGH']     = '';
				$fce->R_MATNR->Append($fce->R_MATNR->row);
				
				$plants = "7702";
				$fce->R_WERKS->row['SIGN']     = 'I';
				$fce->R_WERKS->row['OPTION']   = 'EQ';
				$fce->R_WERKS->row['LOW']      = $plants;
				$fce->R_WERKS->row['HIGH']     = '';
				$fce->R_WERKS->Append($fce->R_WERKS->row);
			
			}

			$fce->call();
			if ($fce->GetStatus() == SAPRFC_OK) {
				$fce->T_STOCK_CONSINYASI->Reset();
				$i=0;
				$idr=1;
				$temp_mat = '';
				$temp_stok= '';
				$stok_intransit = array();
				while ($fce->T_STOCK_CONSINYASI->Next()) {
					$material 	= $fce->T_STOCK_CONSINYASI->row["MATNR"];
					$plant 		= $fce->T_STOCK_CONSINYASI->row["WERKS"];
					$slocs	 	= $fce->T_STOCK_CONSINYASI->row["LGORT"];
					$vendor 	= $fce->T_STOCK_CONSINYASI->row["LIFNR"];
					$stock	 	= intval($fce->T_STOCK_CONSINYASI->row["SLABS"]);
					
					// if($temp_mat == $material){
						// if($temp_stok < $stock)
						// {
							// $stok_total = $stock;
						// }
						// else
						// {
							// $stok_total = $temp_stok;							
						// }
						// echo "$material dan $stock <br/>";
					// }
					// else{
						// $stok_total = $stock;
						// echo "$material dan $stock <br/>";
					// }
					if($stock >= 1)
					{
						$stok_intransit[] = array(
											"MATERIAL"=>$material,
											"PLANT"=>$plant,
											"SLOCS"=>$slocs,
											"VENDOR"=>$vendor,
											"STOCK"=>$stock);
					}
					// echo "$material dan $stock <br/>";
				}
				$fce->Close();
				$ssap->Close();
			}
			// echo "<pre>";
				// print_r($stok_intransit);
			// echo "</pre>";
			return $stok_intransit;
			
			
			// $sql = "SELECT PLANT,KODE_MATERIAL
					// from VMI_MASTER 
					// where STATUS = '1'
					// order by id_list asc";
			// $dt = $this->db->query($sql)->result_array();
			// foreach ($dt as $key => $value) {
				
			// }
			
			/* require_once APPPATH.'third_party/sapclasses/sap.php';
            $ssap = new SAPConnection();
            $ssap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
            if ($ssap->GetStatus() == SAPRFC_OK ) $ssap->Open ();
            if ($ssap->GetStatus() != SAPRFC_OK ) {
                echo $ssap->PrintStatus();
                exit;
            }
			$fce = &$ssap->NewFunction ("ZCMM_TRANSAKSI_MATERIAL");

			if ($fce == false) {
				$ssap->PrintStatus();
				exit;
			}

			$fce->LR_BUDAT->row['SIGN']     = 'I';
			$fce->LR_BUDAT->row['OPTION']   = 'BT';
			$fce->LR_BUDAT->row['LOW']      = '20170101';
			$fce->LR_BUDAT->row['HIGH']     = '20171030';
			$fce->LR_BUDAT->Append($fce->LR_BUDAT->row);

			$fce->LR_BUKRS->row['SIGN']     = 'I';
			$fce->LR_BUKRS->row['OPTION']   = 'EQ';
			// $fce->LR_BUKRS->row['LOW']      = $comp;
			$fce->LR_BUKRS->row['LOW']      = '7000';
			$fce->LR_BUKRS->row['HIGH']     = '';
			$fce->LR_BUKRS->Append($fce->LR_BUKRS->row);
			
			
			// $fce->LR_BWART->row['SIGN']     = 'I';
			// $fce->LR_BWART->row['OPTION']   = 'EQ';
			// $fce->LR_BWART->row['LOW']      = '101';
			// $fce->LR_BWART->row['HIGH']     = '';
			// $fce->LR_BWART->Append($fce->LR_BWART->row);
			// $fce->LR_BWART->row['SIGN']     = 'I';
			// $fce->LR_BWART->row['OPTION']   = 'EQ';
			// $fce->LR_BWART->row['LOW']      = '102';
			// $fce->LR_BWART->row['HIGH']     = '';
			// $fce->LR_BWART->Append($fce->LR_BWART->row);
			// $fce->LR_BWART->row['SIGN']     = 'I';
			// $fce->LR_BWART->row['OPTION']   = 'EQ';
			// $fce->LR_BWART->row['LOW']      = '961';
			// $fce->LR_BWART->row['HIGH']     = '';
			// $fce->LR_BWART->Append($fce->LR_BWART->row);
			// $fce->LR_BWART->row['SIGN']     = 'I';
			// $fce->LR_BWART->row['OPTION']   = 'EQ';
			// $fce->LR_BWART->row['LOW']      = '962';
			// $fce->LR_BWART->row['HIGH']     = '';
			// $fce->LR_BWART->Append($fce->LR_BWART->row);
			
			
			$fce->LR_WERKS->row['SIGN']     = 'I';
			$fce->LR_WERKS->row['OPTION']   = 'EQ';
			// $fce->LR_WERKS->row['LOW']      = $plant;
			$fce->LR_WERKS->row['LOW']      = '7702';
			$fce->LR_WERKS->row['HIGH']     = '';
			$fce->LR_WERKS->Append($fce->LR_WERKS->row);
			
			$sql = "SELECT DISTINCT KODE_MATERIAL
					from VMI_MASTER 
					where STATUS = '1'
					";
			$dt = $this->db->query($sql)->result_array();
			foreach ($dt as $key => $value) {
				
				$komat 							= $value['KODE_MATERIAL'];
				$fce->LR_MATNR->row['SIGN']     = 'I';
				$fce->LR_MATNR->row['OPTION']   = 'EQ';
				$fce->LR_MATNR->row['LOW']      = $komat;
				$fce->LR_MATNR->row['HIGH']     = '';
				$fce->LR_MATNR->Append($fce->LR_MATNR->row);
				
			
			}

			$fce->call();
			if ($fce->GetStatus() == SAPRFC_OK) {
				$fce->T_DATA->Reset();
				$i=0;
				$idr=1;
				$temp_mat = '';
				$temp = array();
				$tempx = '';
				$mat_temp = '';
				while ($fce->T_DATA->Next()) {
					$jenis	 	= $fce->T_DATA->row["BWART"];
					$material 	= $fce->T_DATA->row["MATNR"];
					$stock	 	= intval($fce->T_DATA->row["SLABS"]);
					
					// if($jenis == '961')										// 
					// {
						// $jum_gi1[] = $fce->T_DATA->row["MENGE"];
						$tampildata1[] = array(
							"NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
							"NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
							"PLANT"=>			$fce->T_DATA->row["WERKS"],
							"VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
							"KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
							"PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
							"SLOC"=>			$fce->T_DATA->row["LGORT"],
							"DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
							"Jenis"=>			$fce->T_DATA->row["BLART"],
							"Doc_Type"=>		$fce->T_DATA->row["BWART"],
							"Quantity"=>		$fce->T_DATA->row["MENGE"],
							"Transaction"=>		$fce->T_DATA->row["SHKZG"],
							"UNIT"=>			$fce->T_DATA->row["MEINS"]
						);
						// $idr++; 
					// }
					// if($jenis == '962')										// 
					// {
						// $jum_gi2[] = $fce->T_DATA->row["MENGE"];
						// $tampildata1[] = array(
							// "NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
							// "NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
							// "PLANT"=>			$fce->T_DATA->row["WERKS"],
							// "VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
							// "KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
							// "PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
							// "SLOC"=>			$fce->T_DATA->row["LGORT"],
							// "DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
							// "Jenis"=>			$fce->T_DATA->row["BLART"],
							// "Doc_Type"=>		$fce->T_DATA->row["BWART"],
							// "Quantity"=>		$fce->T_DATA->row["MENGE"],
							// "UNIT"=>			$fce->T_DATA->row["MEINS"]
						// );
						// $idr++; 
					// }
					// if($jenis == '101')
					// {
						// $jum_gr1[] = $fce->T_DATA->row["MENGE"];
						// $tampildata1[] = array(
							// "NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
							// "NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
							// "PLANT"=>			$fce->T_DATA->row["WERKS"],
							// "VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
							// "KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
							// "PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
							// "SLOC"=>			$fce->T_DATA->row["LGORT"],
							// "DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
							// "Jenis"=>			$fce->T_DATA->row["BLART"],
							// "Doc_Type"=>		$fce->T_DATA->row["BWART"],
							// "Quantity"=>		$fce->T_DATA->row["MENGE"],
							// "UNIT"=>			$fce->T_DATA->row["MEINS"]
						// );
						// $idr++;  
					// }
					// if($jenis == '102')
					// {
						// $jum_gr2[] = $fce->T_DATA->row["MENGE"];
						// $tampildata1[] = array(
							// "NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
							// "NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
							// "PLANT"=>			$fce->T_DATA->row["WERKS"],
							// "VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
							// "KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
							// "PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
							// "SLOC"=>			$fce->T_DATA->row["LGORT"],
							// "DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
							// "Jenis"=>			$fce->T_DATA->row["BLART"],
							// "Doc_Type"=>		$fce->T_DATA->row["BWART"],
							// "Quantity"=>		$fce->T_DATA->row["MENGE"],
							// "UNIT"=>			$fce->T_DATA->row["MEINS"]
						// );
						// $idr++;  
					// }
						// $hitung	 = count($tampildata1);
						// if($hitung == 0)
						// {
							// $quan_gr = 0;
							// $quan_gi = 0;
						// }
						// else
						// {
							// $quan_gr = array_sum($jum_gr1)-array_sum($jum_gr2);
							// $quan_gi = array_sum($jum_gi1)-array_sum($jum_gi2);
						// }					
				}
				echo "<pre>";
					print_r($tampildata1);
				echo "</pre>";
				$fce->Close();
				$ssap->Close();
			}
			// echo "$material = $quan_gr dan $quan_gi <br/>"; */
	}
	
    function GetDataDBIncome(){
        $empty = "0";
        // $sql = "select VMI_DELIVERY.*,VMI_MASTER.LEAD_TIME,VMI_VENDOR.VENDOR_NAME,VMI_MASTER.ID_LIST,
				// VMI_MASTER.NAMA_MATERIAL,ADM_PLANT.PLANT_NAME,VMI_MASTER.ID_PLANT,VMI_MASTER.NO_PO, VMI_MASTER.KODE_MATERIAL,
				// TO_CHAR(VMI_DELIVERY.TANGGAL_KIRIM+VMI_MASTER.LEAD_TIME,'DD-MM-YYYY') as DT_EST_COME, TO_CHAR(VMI_DELIVERY.TANGGAL_KIRIM,'DD-MM-YYYY') TANGGAL_KIRIM2
                // from VMI_DELIVERY
                // join VMI_MASTER on VMI_MASTER.ID_LIST=VMI_DELIVERY.ID_LIST
                // join VMI_VENDOR on VMI_VENDOR.ID_VENDOR=VMI_MASTER.KODE_VENDOR
                // join ADM_PLANT on  ADM_PLANT.PLANT_CODE = VMI_MASTER.ID_PLANT
                // where VMI_DELIVERY.STATUS_KEDATANGAN=0
                // ";
        $sql = "SELECT
					VMI_DELIVERY.*, 
					VMI_MASTER.LEAD_TIME,
					VMI_MASTER.ID_LIST,
					VMI_MASTER.NAMA_MATERIAL,
					VMI_MASTER.PLANT,
					VMI_MASTER.NO_PO,
					VMI_MASTER.NAMA_VENDOR,
					VMI_MASTER.NAMA_MATERIAL,
					VMI_MASTER.KODE_MATERIAL,
					TO_CHAR (
						VMI_DELIVERY.TANGGAL_KIRIM,
						'DD-MM-YYYY'
					) TANGGAL_KIRIM2
				FROM
					VMI_DELIVERY
				JOIN VMI_MASTER ON VMI_MASTER.ID_LIST = VMI_DELIVERY.ID_LIST
				JOIN ADM_PLANT ON ADM_PLANT.PLANT_CODE = VMI_MASTER.PLANT
				WHERE
					VMI_DELIVERY.STATUS_KEDATANGAN = 0
                ";
        $datadb = $this->db->query($sql)->result_array();
        $tampildata = array();
        $i=0;
        foreach ($datadb as $key => $value) {
            $id = "text".$i;
            $tampildata[] = array(
                $value['NO_PO'],
                $value['PLANT'],
                $value['NAMA_VENDOR'],
                $value['NAMA_MATERIAL'],
                $value['TANGGAL_KIRIM2'],
                // ($value['TANGGAL_DATANG']==null?$value['DT_EST_COME']:$value['TANGGAL_DATANG']),
                // $value['LEAD_TIME'],
                ($value['QUANTITY']==null?$empty:number_format($value['QUANTITY'],0,',','.')),
                '<div class="checkbox">
                <label>
					<center>
						<input type = "hidden" id="'.$id.'" name= "quantityReceive" size = "3px" value = "'.$value['QUANTITY'].'">
						<input type="checkbox" class="cbox" data-nopo="'.$value['NO_PO'].'" data-plant_id="'.$value['PLANT'].'" data-no="'.$i.'" data-id_material="'.$value['KODE_MATERIAL'].'" data-id_list="'.$value['ID_LIST'].'" data-id_pengiriman="'.$value['ID_PENGIRIMAN'].'">
					</center>
                </label>
                </div>'
            );
//            id="cbox'.$i.'" onclick="UpdateTglTerima('.$value["ID_LIST"].','.$value["ID_PENGIRIMAN"].',"cbox'.$i.'")"
            $i++;
        }
            $data = array("data"=>$tampildata);
            echo json_encode($data);
    }
	
	/* public function coba(){
		$first_day_this_month = date('Ym01'); // hard-coded '01' for first day
		$last_day_this_month  = date('Ymt');
		echo "$first_day_this_month - $last_day_this_month";
	} */
	function SchedullerPO(){
		require_once APPPATH.'third_party/sapclasses/sap.php';
		$sap = new SAPConnection();
		$sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
		if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
		if ($sap->GetStatus() != SAPRFC_OK ) {
			echo $sap->PrintStatus();
			exit;
		}

		$fce = &$sap->NewFunction ("Z_ZCMM_VMI_PO_DETAILC");
		
		if ($fce == false) {
			$sap->PrintStatus();
			exit;
		}
		
		$start 	= date("20170101");					// Date start VMI apps
		$end 	= date("Ymd");						// Date Now
		$opco					= '7000';
		$fce->COMPANY 			= "$opco";		// BUKRS
		// $fce->PO_TYPE 		= 'ZK17';
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

        if ($fce->GetStatus() == SAPRFC_OK) {
            $fce->T_ITEM->Reset();
            $data=array();
            $empty=0;
            $tampildata=array();
            while ($fce->T_ITEM->Next()) {
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
				
				if($statuspo == 'X' || $statuspo == 'x')
				{
					$sts = 0;					
				}
				else
				{
					$sts = 1;
				}
				$sqlread= "SELECT count(id_list) ADA
							FROM VMI_MASTER 
							where NO_PO = '$ebeln' and
							KODE_MATERIAL = '$matnr' and 
							KODE_VENDOR = '$lifnr' and
							PLANT = '$werks' 
							";
							//and QUANTITY = '$menge'
				$jum 	= $this->db->query($sqlread)->row();
				$nilai 	= $jum->ADA;
				// echo $nilai."->".$matnr." | ".$lifnr." | ".$ebeln." | ".$menge." | ".$werks." | ".$vendor." | ".$material." | ".$start." | ".$end." ==> ".$potype;
				// $ebeln == "6310000038" || $ebeln == "6310000039" || $ebeln == "6310000040" || $ebeln == "6310000041" || $ebeln == "6310000042" || $ebeln == "6310000043")
				
				if($nilai < 1){
					if($ebeln == "6310000038" || $ebeln == "6310000039" || $ebeln == "6310000040" || $ebeln == "6310000041" || $ebeln == "6310000042" || $ebeln == "6310000043"
						|| $lifnr == "0000113004" || $lifnr == "0000110091" || $lifnr == "0000110253" || $lifnr == "0000110015" || $lifnr == "0000112369" || $lifnr == "0000110016"){						
						$sqlcount 	= "SELECT max(ID_LIST) MAXX FROM VMI_MASTER";
						$maxid 		= $this->db->query($sqlcount)->row();		
						$max_list 	= $maxid->MAXX+1;
						$insert		= "insert into VMI_MASTER(ID_LIST,
														PLANT,
														KODE_MATERIAL,
														NAMA_MATERIAL,
														UNIT,
														KODE_VENDOR,
														NAMA_VENDOR,
														NO_PO,
														PO_ITEM,
														CONTRACT_ACTIVE,
														CONTRACT_END,
														DOC_DATE,
														SLOC,
														MIN_STOCK,
														MAX_STOCK,
														STOCK_AWAL,
														STOCK_VMI,
														QUANTITY,
														ID_COMPANY,
														STATUS)
												values('$max_list',
														'$werks',
														'$matnr',
														'$material',
														'".$fce->T_ITEM->row["MEINS"]."',
														'$lifnr',
														'$vendor',
														'$ebeln',
														'".$fce->T_ITEM->row["EBELP"]."',
														TO_DATE('".date_format(date_create($start),'Y-m-d')."','YYYY-MM-DD'),
														TO_DATE('".date_format(date_create($end),'Y-m-d')."','YYYY-MM-DD'),
														TO_DATE('".date_format(date_create($start),'Y-m-d')."','YYYY-MM-DD'),
														'".$fce->T_ITEM->row["LGORT"]."',
														'".$fce->T_ITEM->row["EISBE"]."',
														'".$fce->T_ITEM->row["MABST"]."',
														'0',
														'0',
														'$sisaqty',
														'$opco',
														'$sts'
														)";
						$save 	= $this->db->query($insert);
						echo "Baru ==> $ebeln | $material | $vendor | $opco | $werks | $potype<br/>";
					}
					else
					{
						echo "Skip ==> $ebeln | $material | $vendor | $opco | $werks | $potype<br/>";
					}
				}
				elseif($nilai >= 1){
					$sqlread1 = "SELECT ID_LIST
							FROM VMI_MASTER 
							where NO_PO = '$ebeln' and
							KODE_MATERIAL = '$matnr' and 
							KODE_VENDOR = '$lifnr' and
							PLANT = '$werks' 
							";
							//and QUANTITY = '$menge'
					$getlist= $this->db->query($sqlread1)->row();
					$idlist = $getlist->ID_LIST;
					$update		= "update VMI_MASTER set quantity = '$sisaqty',
														min_stock = '$mins',
														max_stock = '$maxs',
														STATUS = '$sts'
													where ID_LIST = '$idlist'
								";
					$update_data	= $this->db->query($update);
						echo "$update <br/>";
				}
				else{
						echo "Skip ==> $ebeln | $material | $vendor | $opco| $werks | $potype<br/>";
				}
				echo "<hr/>";
			}
        $fce->Close();
		}
    }
	
	function GetRealisasi($list){
		// echo "<pre>";
		// echo "HAHAHA";
		$all_data = array();
		foreach ($list as $key => $value) {
			$date_awal 		= date_format(date_create($value->TANGGAL_AWAL),'Ymd');
			$date_akhir		= date_format(date_create($value->TANGGAL_AKHIR),'Ymd');
			$matnr 			= $value->KODE_MATERIAL;
			$quan_prognose 	= $value->QUANTITY;
			$plant 			= $value->PLANT;
			$idcom 			= substr($value->PLANT,0,1)."000";
			// echo $matnr." - ";
			// echo $plant." - ";
			// echo $idcom." - ";
			// echo $date_awal." - ";
			// echo $quan_prognose." - ";
			// echo $date_akhir."<br>";
			
			require_once APPPATH.'third_party/sapclasses/sap.php';
            $sap = new SAPConnection();
            $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
            if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
            if ($sap->GetStatus() != SAPRFC_OK ) {
                echo $sap->PrintStatus();
                exit;
            }

            $fce = &$sap->NewFunction ("Z_ZCMM_MAT_CONSUMP_DETAIL");

            if ($fce == false) {
                $sap->PrintStatus();
                exit;
            }
			
			
			
            $fce->R_BUDAT->row['SIGN']     = 'I';
            $fce->R_BUDAT->row['OPTION']   = 'BT';
            $fce->R_BUDAT->row['LOW']      = $date_awal;
            $fce->R_BUDAT->row['HIGH']     = $date_akhir;
            $fce->R_BUDAT->Append($fce->R_BUDAT->row);
			
            $fce->R_BUKRS->row['SIGN']     = 'I';
            $fce->R_BUKRS->row['OPTION']   = 'EQ';
            $fce->R_BUKRS->row['LOW']      = $idcom;
            $fce->R_BUKRS->row['HIGH']     = '';
            $fce->R_BUKRS->Append($fce->R_BUKRS->row);
			
            $fce->R_MATNR->row['SIGN']     = 'I';
            $fce->R_MATNR->row['OPTION']   = 'EQ';
            $fce->R_MATNR->row['LOW']      = $matnr;
            $fce->R_MATNR->row['HIGH']     = '';
            $fce->R_MATNR->Append($fce->R_MATNR->row);
			
            $fce->R_WERKS->row['SIGN']     = 'I';
            $fce->R_WERKS->row['OPTION']   = 'EQ';
            $fce->R_WERKS->row['LOW']      = $plant;
            $fce->R_WERKS->row['HIGH']     = '';
            $fce->R_WERKS->Append($fce->R_WERKS->row);
			// echo "<pre>";
			// print_r($fce);
            $fce->call();
            if ($fce->GetStatus() == SAPRFC_OK) {
                $fce->T_DATA->Reset();
                $i=0;
				$idr=1;
                $tampildata1=array();
                $jum_gr1 = array();
                $jum_gr2 = array();
                $jum_gi1 = array();
                $jum_gi2 = array();
				$quan_gr = 0;
				$quan_gi = 0;
				$quantity_pr = $quan_prognose;
                while ($fce->T_DATA->Next()) {
					
					$vendor_no = $fce->T_DATA->row["LIFNR"];
					$rsnum = $fce->T_DATA->row["RSNUM"];
					$nopo  = $fce->T_DATA->row["EBELN"];
					$jenis = $fce->T_DATA->row["BWART"];					// Jenis GR(101 / 102) atau GI(961)
					// (961)Barang Issued		(962)Barang Cancel Issued
					// (101)Barang Masuk		(102)Barang Reject
						if($jenis == '961')										// 
						{
							$jum_gi1[] = $fce->T_DATA->row["MENGE"];
							$tampildata1[] = array(
								"NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
								"NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
								"PLANT"=>			$fce->T_DATA->row["WERKS"],
								"VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
								"KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
								"PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
								"SLOC"=>			$fce->T_DATA->row["LGORT"],
								"DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
								"Jenis"=>			$fce->T_DATA->row["BLART"],
								"Doc_Type"=>		$fce->T_DATA->row["BWART"],
									"Quantity"=>		intval($fce->T_DATA->row["MENGE"]),
								"UNIT"=>			$quantity_pr." - ".$date_awal." - ".$date_akhir
							);
							$idr++; 
						}
						if($jenis == '962')										// 
						{
							$jum_gi2[] = $fce->T_DATA->row["MENGE"];
							$tampildata1[] = array(
								"NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
								"NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
								"PLANT"=>			$fce->T_DATA->row["WERKS"],
								"VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
								"KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
								"PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
								"SLOC"=>			$fce->T_DATA->row["LGORT"],
								"DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
								"Jenis"=>			$fce->T_DATA->row["BLART"],
								"Doc_Type"=>		$fce->T_DATA->row["BWART"],
									"Quantity"=>		intval($fce->T_DATA->row["MENGE"]),
								"UNIT"=>			$quantity_pr." - ".$date_awal." - ".$date_akhir
							);
							$idr++; 
						}
						if($jenis == '101')
						{
							$jum_gr1[] = $fce->T_DATA->row["MENGE"];
							$tampildata1[] = array(
								"NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
								"NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
								"PLANT"=>			$fce->T_DATA->row["WERKS"],
								"VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
								"KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
								"PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
								"SLOC"=>			$fce->T_DATA->row["LGORT"],
								"DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
								"Jenis"=>			$fce->T_DATA->row["BLART"],
								"Doc_Type"=>		$fce->T_DATA->row["BWART"],
								"Quantity"=>		intval($fce->T_DATA->row["MENGE"]),
							"UNIT"=>			$quantity_pr." - ".$date_awal." - ".$date_akhir
							);
							$idr++;  
						}
						if($jenis == '102')
						{
							$jum_gr2[] = $fce->T_DATA->row["MENGE"];
							$tampildata1[] = array(
								"NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
								"NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
								"PLANT"=>			$fce->T_DATA->row["WERKS"],
								"VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
								"KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
								"PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
								"SLOC"=>			$fce->T_DATA->row["LGORT"],
								"DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
								"Jenis"=>			$fce->T_DATA->row["BLART"],
								"Doc_Type"=>		$fce->T_DATA->row["BWART"],
									"Quantity"=>		intval($fce->T_DATA->row["MENGE"]),
							"UNIT"=>			$quantity_pr." - ".$date_awal." - ".$date_akhir
							);
							$idr++;  
						}
						$quan_gr = array_sum($jum_gr1)-array_sum($jum_gr2);
						$quan_gi = array_sum($jum_gi1)-array_sum($jum_gi2);
                }
				$date 	= date_format(date_create($date_awal),'Y-M-d');
				$all_data[] = array(
								"TANGGAL"=>	$date,
								"Quan_Prognose"=>	$quan_prognose,
								"Quan_Realisasi"=>	$quan_gi
					);
				// echo "<pre>";
					// print_r($all_data);
					// print_r($tampildata1);
				// echo "</pre>";
				// echo "$matnr($date_awal) = $quan_prognose dan $quan_gi <br/>";
                $fce->Close();
                $sap->Close();
            }
        }
        $data = array("data"=>$all_data);
        return $data; 
	}
	
	function GetAllPO($cawal,$cakhir){
        $input = $this->input->post(null,true);
		$awal  = $input['Cawal'];
		$akhir = $input['Cakhir'];
        $empty = "0";
		$sql = "SELECT KODE_VENDOR,ID_LIST,NO_PO,NAMA_VENDOR,NAMA_MATERIAL,UNIT,PLANT,QUANTITY,STOCK_VMI,STOCK_AWAL,MIN_STOCK,MAX_STOCK,CONTRACT_ACTIVE,CONTRACT_END,STATUS,KODE_MATERIAL,TO_CHAR(LAST_UPDATED, 'DD-MM-YYYY') LAST_UPDATED, QUANTITY, NO_PO,PO_ITEM, ID_COMPANY, PLANT
				from VMI_MASTER 
				where STATUS = '1'
				order by id_list asc";
		$dt = $this->db->query($sql)->result_array();
		$tampildata=array();
		$empty=0;
		foreach ($dt as $key => $value) {
			
			require_once APPPATH.'third_party/sapclasses/sap.php';
            $sap = new SAPConnection();
            $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
            if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
            if ($sap->GetStatus() != SAPRFC_OK ) {
                echo $sap->PrintStatus();
                exit;
            }

            $fce = &$sap->NewFunction ("Z_ZCMM_MAT_CONSUMP_DETAIL");

            if ($fce == false) {
                $sap->PrintStatus();
                exit;
            }
			
			$date_awal 	= date_format(date_create($value['CONTRACT_ACTIVE']),'Ymd');
			$date_akhir	= date_format(date_create($value['CONTRACT_END']),'d M Y');
			
			$vnddb 	= $value['KODE_VENDOR'];
			$matnr 	= $value['KODE_MATERIAL'];
			$idcom 	= $value['ID_COMPANY'];
			$plant 	= $value['PLANT'];
			$nopodb	= $value['NO_PO'];
            $now 	= date("Ymd");
			
            $fce->R_BUDAT->row['SIGN']     = 'I';
            $fce->R_BUDAT->row['OPTION']   = 'BT';
            $fce->R_BUDAT->row['LOW']      = $date_awal;
            $fce->R_BUDAT->row['HIGH']     = $date_akhir;
            $fce->R_BUDAT->Append($fce->R_BUDAT->row);
			
            $fce->R_BUKRS->row['SIGN']     = 'I';
            $fce->R_BUKRS->row['OPTION']   = 'EQ';
            $fce->R_BUKRS->row['LOW']      = $idcom;
            $fce->R_BUKRS->row['HIGH']     = '';
            $fce->R_BUKRS->Append($fce->R_BUKRS->row);
			
            $fce->R_MATNR->row['SIGN']     = 'I';
            $fce->R_MATNR->row['OPTION']   = 'EQ';
            $fce->R_MATNR->row['LOW']      = $matnr;
            $fce->R_MATNR->row['HIGH']     = '';
            $fce->R_MATNR->Append($fce->R_MATNR->row);
			
            $fce->R_WERKS->row['SIGN']     = 'I';
            $fce->R_WERKS->row['OPTION']   = 'EQ';
            $fce->R_WERKS->row['LOW']      = $plant;
            $fce->R_WERKS->row['HIGH']     = '';
            $fce->R_WERKS->Append($fce->R_WERKS->row);

            $fce->call();
            if ($fce->GetStatus() == SAPRFC_OK) {
                $fce->T_DATA->Reset();
                $i=0;
				$idr=1;
                $tampildata1=array();
                $jum_gr1 = array();
                $jum_gr2 = array();
                $jum_gi1 = array();
                $jum_gi2 = array();
				$quan_gr = 0;
				$quan_gi = 0;
                while ($fce->T_DATA->Next()) {
					
					$vendor_no = $fce->T_DATA->row["LIFNR"];
					$rsnum = $fce->T_DATA->row["RSNUM"];
					$nopo  = $fce->T_DATA->row["EBELN"];
					$jenis = $fce->T_DATA->row["BWART"];					// Jenis GR(101 / 102) atau GI(961)
					// (961)Barang Issued		(962)Barang Cancel Issued
					// (101)Barang Masuk		(102)Barang Reject
					if($nopo == $nopodb || $vendor_no == $vnddb)									// Karena per list PO untuk GR dan GInya, bukan per materialnya
					{
						if($jenis == '961')										// 
						{
							$jum_gi1[] = $fce->T_DATA->row["MENGE"];
							$tampildata1[] = array(
								"NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
								"NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
								"PLANT"=>			$fce->T_DATA->row["WERKS"],
								"VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
								"KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
								"PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
								"SLOC"=>			$fce->T_DATA->row["LGORT"],
								"DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
								"Jenis"=>			$fce->T_DATA->row["BLART"],
								"Doc_Type"=>		$fce->T_DATA->row["BWART"],
								"Quantity"=>		$fce->T_DATA->row["MENGE"],
								"UNIT"=>			$fce->T_DATA->row["MEINS"]
							);
							$idr++; 
						}
						if($jenis == '962')										// 
						{
							$jum_gi2[] = $fce->T_DATA->row["MENGE"];
							$tampildata1[] = array(
								"NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
								"NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
								"PLANT"=>			$fce->T_DATA->row["WERKS"],
								"VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
								"KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
								"PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
								"SLOC"=>			$fce->T_DATA->row["LGORT"],
								"DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
								"Jenis"=>			$fce->T_DATA->row["BLART"],
								"Doc_Type"=>		$fce->T_DATA->row["BWART"],
								"Quantity"=>		$fce->T_DATA->row["MENGE"],
								"UNIT"=>			$fce->T_DATA->row["MEINS"]
							);
							$idr++; 
						}
						if($nopo == $nopodb)
						{
							if($jenis == '101')
							{
								$jum_gr1[] = $fce->T_DATA->row["MENGE"];
								$tampildata1[] = array(
									"NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
									"NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
									"PLANT"=>			$fce->T_DATA->row["WERKS"],
									"VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
									"KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
									"PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
									"SLOC"=>			$fce->T_DATA->row["LGORT"],
									"DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
									"Jenis"=>			$fce->T_DATA->row["BLART"],
									"Doc_Type"=>		$fce->T_DATA->row["BWART"],
									"Quantity"=>		$fce->T_DATA->row["MENGE"],
									"UNIT"=>			$fce->T_DATA->row["MEINS"]
								);
								$idr++;  
							}
							if($jenis == '102')
							{
								$jum_gr2[] = $fce->T_DATA->row["MENGE"];
								$tampildata1[] = array(
									"NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
									"NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
									"PLANT"=>			$fce->T_DATA->row["WERKS"],
									"VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
									"KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
									"PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
									"SLOC"=>			$fce->T_DATA->row["LGORT"],
									"DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
									"Jenis"=>			$fce->T_DATA->row["BLART"],
									"Doc_Type"=>		$fce->T_DATA->row["BWART"],
									"Quantity"=>		$fce->T_DATA->row["MENGE"],
									"UNIT"=>			$fce->T_DATA->row["MEINS"]
								);
								$idr++;  
							}
						}
						// $hitung	 = count($tampildata1);
						// if($hitung == 0)
						// {
							// $quan_gr = 0;
							// $quan_gi = 0;
						// }
						// else
						// {
							$quan_gr = array_sum($jum_gr1)-array_sum($jum_gr2);
							$quan_gi = array_sum($jum_gi1)-array_sum($jum_gi2);
						// }
					}
                }
				// echo "<pre>";
					// print_r($tampildata1);
				// echo "</pre>";
				// echo "$matnr = $quan_gr dan $quan_gi <br/>";
                $fce->Close();
                $sap->Close();
            }
			
			require_once APPPATH.'third_party/sapclasses/sap.php';
            $ssap = new SAPConnection();
            $ssap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
            if ($ssap->GetStatus() == SAPRFC_OK ) $ssap->Open ();
            if ($ssap->GetStatus() != SAPRFC_OK ) {
                echo $ssap->PrintStatus();
                exit;
            }
			$fce = &$ssap->NewFunction ("ZCMM_MASTER_MATERIAL");

			if ($fce == false) {
				$ssap->PrintStatus();
				exit;
			}
			
			$fce->R_MATNR->row['SIGN']     = 'I';
			$fce->R_MATNR->row['OPTION']   = 'EQ';
			$fce->R_MATNR->row['LOW']      = $matnr;
			$fce->R_MATNR->row['HIGH']     = '';
			$fce->R_MATNR->Append($fce->R_MATNR->row);
			
			$plants = "7702";
			$fce->R_WERKS->row['SIGN']     = 'I';
			$fce->R_WERKS->row['OPTION']   = 'EQ';
			$fce->R_WERKS->row['LOW']      = $plants;
			$fce->R_WERKS->row['HIGH']     = '';
			$fce->R_WERKS->Append($fce->R_WERKS->row);
			
			// $slocs = "W201";
			// $fce->R_LGORT->row['SIGN']     = 'I';
			// $fce->R_LGORT->row['OPTION']   = 'EQ';
			// $fce->R_LGORT->row['LOW']      = $slocs;
			// $fce->R_LGORT->row['HIGH']     = '';
			// $fce->R_LGORT->Append($fce->R_LGORT->row);
			
			// $year = date("Y");
			// $fce->R_LFGJA->row['SIGN']     = 'I';
			// $fce->R_LFGJA->row['OPTION']   = 'EQ';
			// $fce->R_LFGJA->row['LOW']      = $year;
			// $fce->R_LFGJA->row['HIGH']     = '';
			// $fce->R_LFGJA->Append($fce->R_LFGJA->row);
			
			// $month = date("m");
			// $fce->R_LFMON->row['SIGN']     = 'I';
			// $fce->R_LFMON->row['OPTION']   = 'EQ';
			// $fce->R_LFMON->row['LOW']      = $month;
			// $fce->R_LFMON->row['HIGH']     = '';
			// $fce->R_LFMON->Append($fce->R_LFMON->row);

			$fce->call();
			if ($fce->GetStatus() == SAPRFC_OK) {
				$fce->T_STOCK_CONSINYASI->Reset();
				$i=0;
				$idr=1;
				while ($fce->T_STOCK_CONSINYASI->Next()) {
					$stock_onhand = $fce->T_STOCK_CONSINYASI->row["SLABS"];
				}
				$fce->Close();
				$ssap->Close();
			}
			// echo "$stock_onhand <hr/>";
				
			$update = "UPDATE VMI_M_PROGNOSE set realisasi = '$quan_gi' 
						where KODE_MATERIAL = '$matnr'
						and tanggal_awal  = TO_DATE('$start','yyyy-mm-dd')
						and tanggal_akhir = TO_DATE('$end','yyyy-mm-dd')";
			$this->db->query($update);
			// echo "$update <br/>";
			// echo "$matnr - $quan_gi <br/>";
			// echo "<hr/>";
			
			
			$IDL = $value['ID_LIST'];
			$sql1 = "SELECT sum(quantity) DELIV from VMI_DELIVERY where ID_LIST = '$IDL' and STATUS_KEDATANGAN = 0";
			$maxid 	= $this->db->query($sql1)->row();		
			$deliv = $maxid->DELIV;
            $tampildata[] = array(
                        // ($value['T_STOCKGRGI']==null?$empty:number_format($value['T_STOCKGRGI'],0,',','.')),
                        $value['NO_PO'],
                        $value['NAMA_VENDOR'],
                        $value['NAMA_MATERIAL'],
                        ($value['UNIT']==null?$empty:$value['UNIT']),
                        $value['PLANT'],
                        ($value['QUANTITY']==null?$empty:number_format($value['QUANTITY'],0,',','.')),
						($quan_gr==null?$empty:number_format($quan_gr,0,',','.')),
						($quan_gi==null?$empty:number_format($quan_gi,0,',','.')), 
						// $empty,
						// $empty,
                        ($stock_onhand==null?$empty:number_format($stock_onhand,0,',','.')),
                        $deliv==null?$empty:number_format($deliv,0,',','.'),
						"<span title = 'Last Updated on ".$value['LAST_UPDATED']."'>".$value['STOCK_AWAL']."</span>",
                        ($value['MIN_STOCK']==null?$empty:number_format($value['MIN_STOCK'],0,',','.')),
                        ($value['MAX_STOCK']==null?$empty:number_format($value['MAX_STOCK'],0,',','.')),
                        $value['CONTRACT_ACTIVE'],
                        $value['CONTRACT_END'],
						"<a href='".base_url('VMI/Company/Grafik/')."/".$value['ID_LIST']."'><span class='label-success label label-success'>Show Grafik</span></a>"
            );
        }
        $data = array("data"=>$tampildata);
		// echo "<hr/>";
		// echo "<pre>";
			// print_r($data);
		// echo "</pre>";
        echo json_encode($data);
    }
	
	function GetAllPOFilter($cawal,$cakhir){
			require_once APPPATH.'third_party/sapclasses/sap.php';
			$sap = new SAPConnection();
			$sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
			if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
			
			/* if ($sap->GetStatus() != SAPRFC_OK ) {
				echo $sap->PrintStatus();
				exit;
			}
			if ($fce == false) {
				$sap->PrintStatus();
				exit;
			} */
			
			// $start 					= date("20170901");					// Date start VMI apps
			// $end 					= date("Ymd");						// Date Now
			
			// =====================================
			// ========= List PO Konsinyasi ========
			// =====================================
						// 6310000038
						// 6310000039
						// 6310000040
						// 6310000041
						// 6310000042
						// 6310000043​
			// =====================================
			// ========= List PO Konsinyasi ========
			// =====================================
			$fce 					= &$sap->NewFunction ("Z_ZCMM_VMI_PO_DETAILC");
			$opco					= '7000';
			$fce->COMPANY 			= "$opco";		// BUKRS
			// $fce->PO_TYPE 			= '';
			// $fce->VENDOR 		= ;
			$fce->DATE['SIGN']   	= 'I';
			$fce->DATE['OPTION']	= 'BT';
			// $fce->DATE['LOW']    	= $cawal;
			// $fce->DATE['HIGH']    	= $cakhir;
			$fce->DATE['LOW']    	= '20170101';
			$fce->DATE['HIGH']    	= '20170928';
			
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

	//        echo $fce;

			if ($fce->GetStatus() == SAPRFC_OK) {
				$fce->T_ITEM->Reset();

				$data=array();

				$empty=0;
				$tampildata=array();
					while ($fce->T_ITEM->Next()) {
						$matnr 		= $fce->T_ITEM->row["MATNR"];	// Kode Material
						$lifnr 		= $fce->T_ITEM->row["LIFNR"];	// Kode Vendor
						$ebeln 		= $fce->T_ITEM->row["EBELN"];	// No PO
						$menge 		= intval($fce->T_ITEM->row["MENGE"]);	// Quantity PO
						$werks 		= $fce->T_ITEM->row["WERKS"];	// Plant
						$vendor		= $fce->T_ITEM->row["VENDNAME"];	// Nama Vendor
						$material 	= $fce->T_ITEM->row["MAKTX"];	// Nama Material
						$potype 	= $fce->T_ITEM->row["BSART"];	// Type PO
						$start 		= date_format(date_create($fce->T_ITEM->row["BEDAT"]),'d M Y');
						$end 		= date_format(date_create($fce->T_ITEM->row["EINDT"]),'d M Y');
						
						$sqlread = "SELECT count(id_list) ADA
									FROM VMI_MASTER 
									where NO_PO = '$ebeln' and
									KODE_MATERIAL = '$matnr' and 
									KODE_VENDOR = '$lifnr' and
									PLANT = '$werks' and
									QUANTITY = '$menge'
									";
						$jum 	= $this->db->query($sqlread)->row();
						$nilai = $jum->ADA;
						if($nilai == 1 || $ebeln == "6310000038" || $ebeln == "6310000039" || $ebeln == "6310000040" || $ebeln == "6310000041" || $ebeln == "6310000042" || $ebeln == "6310000043")
						{
							echo $nilai."->".$matnr." | ".$lifnr." | ".$ebeln." | ".$menge." | ".$werks." | ".$vendor." | ".$material." | ".$start." | ".$end." ==> ".$potype;
						}
						else
						{
							// echo $nilai."->".$matnr." | ".$lifnr." | ".$ebeln." | ".$menge." | ".$werks." | ".$vendor." | ".$material." | ".$start." | ".$end." ==> ".$potype;
						}
						echo "<br/>";
						
						$empty++;
					}
				$fce->Close();
				// echo "<pre>";
					// print_r($fce->T_ITEM);
				// echo "</pre>";
				// echo "Total = $empty";
				// echo json_encode($data);
			}
        // $data = array("data"=>$tampildata);
        // echo json_encode($data);
        // return $tampildata;
    }

	function GetAllPOFilter_OLD(){
		// $input = $this->input->post(null,true);
		// $awal  = $this->input->post("Cawal");
		// $akhir = $this->input->post("Cakhir");
		// $awal  = $input['Cawal'];
		// $akhir = $input['Cakhir'];
		// echo "|| $awal dan $akhir ||";
        $empty = "0";
        $sql = "SELECT ID_LIST,NO_PO,NAMA_VENDOR,NAMA_MATERIAL,UNIT,PLANT,QUANTITY,STOCK_VMI,STOCK_AWAL,MIN_STOCK,MAX_STOCK,CONTRACT_ACTIVE,CONTRACT_END,STATUS,KODE_MATERIAL,TO_CHAR(LAST_UPDATED, 'DD-MM-YYYY') LAST_UPDATED
				FROM VMI_MASTER";
        $datadb = $this->db->query($sql)->result_array();
        $tampildata = array();
        foreach ($datadb as $key => $value) {
			
            require_once APPPATH.'third_party/sapclasses/sap.php';
            $sap = new SAPConnection();
            $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
            if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
            if ($sap->GetStatus() != SAPRFC_OK ) {
                echo $sap->PrintStatus();
                exit;
            }

            $fce = &$sap->NewFunction ("Z_ZCMM_MAT_CONSUMP_DETAIL");

            if ($fce == false) {
                $sap->PrintStatus();
                exit;
            }
			$matnr 	= $value['KODE_MATERIAL'];
			// $start 	= date("Ym01");
			$start 	= date("20170701");
            // $now 	= date("Ymd");
            $now 	= date("20170730");
            $end 	= date("Ymt");
			
			
			
            $fce->R_BUDAT->row['SIGN']     = 'I';
            $fce->R_BUDAT->row['OPTION']   = 'BT';
            $fce->R_BUDAT->row['LOW']      = $start;
            $fce->R_BUDAT->row['HIGH']     = $now;
            $fce->R_BUDAT->Append($fce->R_BUDAT->row);
			
            $fce->R_MATNR->row['SIGN']     = 'I';
            $fce->R_MATNR->row['OPTION']   = 'EQ';
            $fce->R_MATNR->row['LOW']      = $matnr;
            $fce->R_MATNR->row['HIGH']     = '';
            $fce->R_MATNR->Append($fce->R_MATNR->row);

            $fce->call();
            if ($fce->GetStatus() == SAPRFC_OK) {
                $fce->T_DATA->Reset();
                $i=0;
				$idr=1;
                $tampildata1=array();
                $jum_gr = array();
                $jum_gi = array();
                while ($fce->T_DATA->Next()) {
					
					$rsnum = $fce->T_DATA->row["RSNUM"];
					if($rsnum == '0052100475')
					{
						$jum_gi[] = $fce->T_DATA->row["MENGE"];
						$tampildata1[] = array(
							"NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
							"NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
							"PLANT"=>			$fce->T_DATA->row["WERKS"],
							"VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
							"KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
							"PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
							"SLOC"=>			$fce->T_DATA->row["LGORT"],
							"DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
							"UNIT"=>			$fce->T_DATA->row["MEINS"]
						);
						$idr++; 
					}
					$nopo = $fce->T_DATA->row["EBELN"];
					if($nopo == '6310000008')
					{
						$jum_gr[] = $fce->T_DATA->row["MENGE"];
						$tampildata1[] = array(
							"NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
							"NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
							"PLANT"=>			$fce->T_DATA->row["WERKS"],
							"VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
							"KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
							"PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
							"SLOC"=>			$fce->T_DATA->row["LGORT"],
							"DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
							"UNIT"=>			$fce->T_DATA->row["MEINS"]
						);
						$idr++;  
					}
                }
				$quan_gr = array_sum($jum_gr);
				$quan_gi = array_sum($jum_gi);
                $fce->Close();
                $sap->Close();
            }
			
			
			require_once APPPATH.'third_party/sapclasses/sap.php';
            $ssap = new SAPConnection();
            $ssap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
            if ($ssap->GetStatus() == SAPRFC_OK ) $ssap->Open ();
            if ($ssap->GetStatus() != SAPRFC_OK ) {
                echo $ssap->PrintStatus();
                exit;
            }
			$fce = &$ssap->NewFunction ("ZCMM_MASTER_STOCK_MATERIAL");

			if ($fce == false) {
				$ssap->PrintStatus();
				exit;
			}
			
			$fce->R_MATNR->row['SIGN']     = 'I';
			$fce->R_MATNR->row['OPTION']   = 'EQ';
			$fce->R_MATNR->row['LOW']      = $matnr;
			$fce->R_MATNR->row['HIGH']     = '';
			$fce->R_MATNR->Append($fce->R_MATNR->row);
			
			$plants = "7702";
			$fce->R_WERKS->row['SIGN']     = 'I';
			$fce->R_WERKS->row['OPTION']   = 'EQ';
			$fce->R_WERKS->row['LOW']      = $plants;
			$fce->R_WERKS->row['HIGH']     = '';
			$fce->R_WERKS->Append($fce->R_WERKS->row);
			
			$slocs = "W201";
			$fce->R_LGORT->row['SIGN']     = 'I';
			$fce->R_LGORT->row['OPTION']   = 'EQ';
			$fce->R_LGORT->row['LOW']      = $slocs;
			$fce->R_LGORT->row['HIGH']     = '';
			$fce->R_LGORT->Append($fce->R_LGORT->row);
			
			$year = date("Y");
			$fce->R_LFGJA->row['SIGN']     = 'I';
			$fce->R_LFGJA->row['OPTION']   = 'EQ';
			$fce->R_LFGJA->row['LOW']      = $year;
			$fce->R_LFGJA->row['HIGH']     = '';
			$fce->R_LFGJA->Append($fce->R_LFGJA->row);
			
			$month = date("m");
			$fce->R_LFMON->row['SIGN']     = 'I';
			$fce->R_LFMON->row['OPTION']   = 'EQ';
			$fce->R_LFMON->row['LOW']      = $month;
			$fce->R_LFMON->row['HIGH']     = '';
			$fce->R_LFMON->Append($fce->R_LFMON->row);

			$fce->call();
			if ($fce->GetStatus() == SAPRFC_OK) {
				$fce->T_STOCK->Reset();
				$i=0;
				$idr=1;
				while ($fce->T_STOCK->Next()) {
					$stock_onhand = $fce->T_STOCK->row["KLABS"];
				}
				$fce->Close();
				$ssap->Close();
			}
            // echo "<pre>";
            // print_r($ArrKembali);
            // echo "</pre>";
			// echo "<hr/> $idr";
			
			
			// for($i=1;$i<=2;$i++)
			// {
				
			$update = "UPDATE VMI_M_PROGNOSE set realisasi = '$quan_gi' 
						where KODE_MATERIAL = '$matnr'
						and tanggal_awal  = TO_DATE('$start','yyyy-mm-dd')
						and tanggal_akhir = TO_DATE('$end','yyyy-mm-dd')";
			$this->db->query($update);
			// echo "$update <br/>";
			// echo "$matnr - $quan_gi <br/>";
			// echo "<hr/>";
			
			
			$IDL = $value['ID_LIST'];
			$sql1 = "SELECT sum(quantity) DELIV from VMI_DELIVERY where ID_LIST = '$IDL' and STATUS_KEDATANGAN = 0";
			$maxid 	= $this->db->query($sql1)->row();		
			$deliv = $maxid->DELIV;
            $tampildata[] = array(
                        // ($value['T_STOCKGRGI']==null?$empty:number_format($value['T_STOCKGRGI'],0,',','.')),
                        $value['NO_PO'],
                        $value['NAMA_VENDOR'],
                        $value['NAMA_MATERIAL'],
                        ($value['UNIT']==null?$empty:$value['UNIT']),
                        $value['PLANT'],
                        ($value['QUANTITY']==null?$empty:number_format($value['QUANTITY'],0,',','.')),
						$quan_gr,
						$quan_gi,
						// $empty,
						// $empty,
                        ($stock_onhand==null?$empty:number_format($stock_onhand,0,',','.')),
                        $deliv==null?$empty:number_format($deliv,0,',','.'),
						"<span title = 'Last Updated on ".$value['LAST_UPDATED']."'>".$value['STOCK_AWAL']."</span>",
                        ($value['MIN_STOCK']==null?$empty:number_format($value['MIN_STOCK'],0,',','.')),
                        ($value['MAX_STOCK']==null?$empty:number_format($value['MAX_STOCK'],0,',','.')),
                        $value['CONTRACT_ACTIVE'],
                        $value['CONTRACT_END'],
						"<a href='".base_url('VMI/Company/Grafik/')."/".$value['ID_LIST']."'><span class='label-success label label-success'>Show Grafik</span></a>"
            );
			// }
        }
        $data = array("data"=>$tampildata);
        echo json_encode($data);
    }
	
    function testing(){
        $sql = "SELECT * from vmi_delivery";
        $datadb = $this->db->query($sql)->result_array();
        $tampildata = array();
        foreach ($datadb as $key => $value) {
			$IDL = $value['ID_LIST'];
            $tampildata[] = array(
                        $value['ID_PENGIRIMAN'],
                        $value['ID_LIST'],
                        $value['QUANTITY'],
                        $value['TANGGAL_KIRIM'],
                        $value['STATUS_KEDATANGAN'],
                        $value['TANGGAL_DATANG'],
                        $value['KODE_VENDOR'],
                        $value['NO_PO'],
                        $value['KODE_MATERIAL']
            );
        }
        $data = array("data"=>$tampildata);
        echo json_encode($data);
    }
	
    function GetDataDB(){
        $empty = "0";
        $sql = "SELECT
                    (SELECT sum(quantity) qty1 from VMI_DELIVERY where VMI_DELIVERY.ID_LIST=VMI_MASTER.ID_LIST and STATUS_KEDATANGAN=1) T_STOCKVMI,
                    (SELECT sum(quantity) qty2 from VMI_DELIVERY where VMI_DELIVERY.ID_LIST=VMI_MASTER.ID_LIST and STATUS_KEDATANGAN=0) T_STOCKDELIV,
                            VMI_MASTER.ID_LIST ID_LISTVENDOR,
                            VMI_MASTER.*, VMI_VENDOR.*, VMI_MATERIAL.*
                    FROM
                            VMI_MASTER
                    JOIN VMI_MATERIAL ON VMI_MATERIAL.KODE_MATERIAL = VMI_MASTER.KODE_MATERIAL
                    JOIN VMI_VENDOR ON VMI_VENDOR.ID_VENDOR = VMI_MASTER.KODE_VENDOR";
        $datadb = $this->db->query($sql)->result_array();
        $tampildata = array();
        foreach ($datadb as $key => $value) {
			// for($i=1;$i<=2;$i++)
			// {
			$IDL = $value['ID_LIST'];
            $tampildata[] = array(
                        // ($value['T_STOCKGRGI']==null?$empty:number_format($value['T_STOCKGRGI'],0,',','.')),
                        $value['NO_PO'],
                        $value['VENDOR_NAME'],
                        $value['NAMA_MATERIAL'],
                        ($value['UNIT']==null?$empty:$value['UNIT']),
                        $value['ID_PLANT'],
						$empty,
                        ($value['STOCK_VMI']==null?$empty:number_format($value['STOCK_VMI'],0,',','.')),
                        ($value['T_STOCKDELIV']==null?$empty:number_format($value['T_STOCKDELIV'],0,',','.')),
                        ($value['STOCK_AWAL']==null?$empty:number_format($value['STOCK_AWAL'],0,',','.')),
                        ($value['MIN_STOCK']==null?$empty:number_format($value['MIN_STOCK'],0,',','.')),
                        ($value['MAX_STOCK']==null?$empty:number_format($value['MAX_STOCK'],0,',','.')),
                        $value['LEAD_TIME'],
                        $value['CONTRACT_ACTIVE'],
                        $value['CONTRACT_END'],
						"<a href='".base_url('VMI/Company/Grafik/')."/".$value['ID_LIST']."'><span class='label-success label label-success'>Show Grafik</span></a>"
            );
			// }
        }
        $data = array("data"=>$tampildata);
        echo json_encode($data);
    }
        
    function getGRList(){
            $ArrKembali = array();
            require_once APPPATH.'third_party/sapclasses/sap.php';
            $sap = new SAPConnection();
            $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
            if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
            if ($sap->GetStatus() != SAPRFC_OK ) {
                echo $sap->PrintStatus();
                exit;
            }

            $fce = &$sap->NewFunction ("Z_ZCMM_MAT_CONSUMP_DETAIL");

            if ($fce == false) {
                $sap->PrintStatus();
                exit;
            }
            $now = date("Ymd");
            $fce->R_BUDAT->row['SIGN']     = 'I';
            $fce->R_BUDAT->row['OPTION']   = 'BT';
            $fce->R_BUDAT->row['LOW']      = '20170901';
            $fce->R_BUDAT->row['HIGH']     = $now;
            $fce->R_BUDAT->Append($fce->R_BUDAT->row);
			
            $fce->R_MATNR->row['SIGN']     = 'I';
            $fce->R_MATNR->row['OPTION']   = 'EQ';
            $fce->R_MATNR->row['LOW']      = '119-200137';
            $fce->R_MATNR->row['HIGH']     = '';
            $fce->R_MATNR->Append($fce->R_MATNR->row);

            $fce->call();
            if ($fce->GetStatus() == SAPRFC_OK) {
                $fce->T_DATA->Reset();
                $i=0;
				$idr=1;
                $tampildata=array();
                while ($fce->T_DATA->Next()) {
					$nopo = $fce->T_DATA->row["EBELN"];
					if($nopo == '6310000008')
					{
						$tampildata[] = array(
							"NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
							"NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
							"PLANT"=>			$fce->T_DATA->row["WERKS"],
							"VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
							"KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
							"PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
							"SLOC"=>			$fce->T_DATA->row["LGORT"],
							"DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
							"UNIT"=>			$fce->T_DATA->row["MEINS"]
						);
						$idr++;  
					}
                }
                $fce->Close();
                $sap->Close();
                $ArrKembali = $tampildata;
            }
            echo "<pre>";
            print_r($ArrKembali);
            echo "</pre>";
			echo "<hr/> $idr";
    }    
	
    function getGIList(){
            $ArrKembali = array();
            require_once APPPATH.'third_party/sapclasses/sap.php';
            $sap = new SAPConnection();
            $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
            if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
            if ($sap->GetStatus() != SAPRFC_OK ) {
                echo $sap->PrintStatus();
                exit;
            }

            $fce = &$sap->NewFunction ("Z_ZCMM_MAT_CONSUMP_DETAIL");

            if ($fce == false) {
                $sap->PrintStatus();
                exit;
            }
            $now = date("Ymd");
            $fce->R_BUDAT->row['SIGN']     = 'I';
            $fce->R_BUDAT->row['OPTION']   = 'BT';
            $fce->R_BUDAT->row['LOW']      = '20170901';
            $fce->R_BUDAT->row['HIGH']     = $now;
            $fce->R_BUDAT->Append($fce->R_BUDAT->row);
			
            $fce->R_MATNR->row['SIGN']     = 'I';
            $fce->R_MATNR->row['OPTION']   = 'EQ';
            $fce->R_MATNR->row['LOW']      = '119-200137';
            $fce->R_MATNR->row['HIGH']     = '';
            $fce->R_MATNR->Append($fce->R_MATNR->row);

            $fce->call();
            if ($fce->GetStatus() == SAPRFC_OK) {
                $fce->T_DATA->Reset();
                $i=0;
				$idr=1;
                $tampildata=array();
                $jums=array();
                while ($fce->T_DATA->Next()) {
                    // $tampildata[] = $fce->T_DATA->row;
					$fce->T_DATA->row["EBELN"];
					$rsnum = $fce->T_DATA->row["RSNUM"];
					if($rsnum == '0052100475')
					{
						$jums[] = $fce->T_DATA->row["MENGE"];
						$tampildata[] = array(
							"NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
							"NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
							"PLANT"=>			$fce->T_DATA->row["WERKS"],
							"VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
							"KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
							"PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
							"SLOC"=>			$fce->T_DATA->row["LGORT"],
							"DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
							"QUANTITY"=>		$fce->T_DATA->row["MENGE"],
							"UNIT"=>			$fce->T_DATA->row["MEINS"]
						);
						$idr++;  
					}
                }
				$quan = array_sum($jums);
                $fce->Close();
                $sap->Close();
                $ArrKembali = $tampildata;
            }
            echo "<pre>";
            print_r($ArrKembali);
            echo "</pre>";
			echo "<hr/> $idr || $quan";
    }
	
	function send_mail($from,$to,$subject,$cc,$bcc,$message){
		// $from 	= "muhammad.ramzi20@gmail.com";
		// $to 	= "m.ramzi@sisi.id";
		// $subject= "Coba mail";
		// $cc 	= "muhammad.ramzi20@gmail.com";
		// $bcc 	= "evilstar7@gmail.com";
		// $message= "Nyoba email buat VMI bro --> Sudah dari VMI";
		$this->load->library('email');
		$this->config->load('email');
		$semenindonesia = $this->config->item('semenindonesia');
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($from);
		$this->email->to($to);
		// $this->email->cc('pengadaan.semenindonesia@gmail.com');
		if(!empty($cc)){
		   $this->email->cc($cc);
		}
		if(!empty($bcc)){
		   $this->email->bcc($bcc);
		}

		if(!empty($attachment)){
		  $this->email->attach($attachment);
		}

		$this->email->subject($subject);
		$this->email->message($message);
		return $this->email->send();
	}
	
	function tes_mail(){

		$sql = "SELECT * FROM VMI_MASTER";
        $datadb = $this->db->query($sql)->result_array();
        foreach ($datadb as $key => $value) {
			$kode = $value['KODE_MATERIAL'];
			$min  = $value['MIN_STOCK'];
			$stock= $value['STOCK_AWAL'];
			
			if($stock <= $min)
			{
				echo $value['KODE_MATERIAL'] ."==>". $value['MIN_STOCK'] ."==". $value['STOCK_AWAL']. "<br/>";
				$sql1 	= "SELECT EMAIL_ADDRESS FROM VND_HEADER where VENDOR_NO = '".$value['KODE_VENDOR']."'";
				$result	= $this->db->query($sql1)->row();		
				$email 	= $result->EMAIL_ADDRESS;
				// echo "$sql1";
				$from 	  = "Tim VMI-Eproc Semen Indonesia";
				$to 	  = "$email";
				$subject  = "Email Notifikasi untuk melakukan Replenishment";
				$cc 	  = "imam.s@sisi.id	";
				$bcc 	  = "m.ramzi@sisi.id";
				$message  = '<html><body><font style = "font-family:"Cambria";size:"12px";">';
				$message .= 'Yth. <b>'.$value['NAMA_VENDOR'].'</b><br/>';
				$message .= 'Mohon melakukan replanishment untuk material berikut : <br/><br/>';
				$message .= '<table border = 2>';
				$message .= '<tr>
								<th>Material</th>
								<th>Stock</th>
								<th>Min Stock</th>
							</tr>';
				$message .= '<tr>
								<td>'.$value['NAMA_MATERIAL'].'</td>
								<td align = "center">'.$value['STOCK_AWAL'].'</td>
								<td align = "center">'.$value['MIN_STOCK'].'</td>
							</tr>';
				$message .= '</table>';
				$message .= '<br/>Demikian Email Pemberitahun ini kami sampaikan<br/>';
				$message .= 'Terima Kasih<br/><br/>';
				$message .= 'NB : Email ini dikirimkan oleh system. Jangan me-reply email ini. Apabila ada pertanyaan silakan menghubungi Seksi Inventory<br/>';
				$message .= '</font></body></html>';
				$sender	  = $this->send_mail($from,$to,$subject,$cc,$bcc,$message);
				// echo "$from,$to,$subject,$cc,$bcc,$message <br/>";
			}
        }	
		
	}
//    MJAHR	Material Document Year
//    MBLNR	Number of Material Document
//    ZEILE	Item in Material Document
//    BUKRS	Company Code
//    BLART	Document Type
//    BLDAT	Document Date in Document
//    BUDAT	Posting Date in the Document
//    CPUDT	Day On Which Accounting Document Was Entered
//    BWART	Movement Type (Inventory Management)
//    MATNR	Material Number
//    WERKS	Plant
//    LGORT	Storage Location
//    SOBKZ	Special Stock Indicator
//    LIFNR	Account Number of Vendor or Creditor
//    SHKZG	Debit/Credit Indicator
//    WAERS	Currency Key
//    DMBTR	Amount in Local Currency
//    MEINS	Base Unit of Measure
//    MENGE	Quantity
//    QTY_TON	Quantity
//    EBELN	Purchasing Document Number
//    EBELP	Item Number of Purchasing Document
//    FISTL	Funds Center
//    AUFNR	Order Number
//    RSNUM	Number of Reservation/Dependent Requirement
//    RSPOS	Item Number of Reservation/Dependent Requirement
//===================================================================================================================================================================================================================================================================
//===================================================================================================================================================================================================================================================================
//============================================================================================================== BATAS SUCI =========================================================================================================================================
//===================================================================================================================================================================================================================================================================
//===================================================================================================================================================================================================================================================================
	public function GetData(){
		require_once APPPATH.'third_party/sapclasses/sap.php';
            $sap = new SAPConnection();
            $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
            if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
            if ($sap->GetStatus() != SAPRFC_OK ) {
                echo $sap->PrintStatus();
                exit;
            }

            $fce = &$sap->NewFunction ("Z_ZCMM_MAT_CONSUMP_DETAIL");

            if ($fce == false) {
                $sap->PrintStatus();
                exit;
            }
			$matnr 	= '119-200137';
			$start 	= date("Ym01");
			// $start 	= date("20170701");
            $now 	= date("Ymd");
            // $now 	= date("20171230");
            $end 	= date("Ymt");
			
			
			
            $fce->R_BUDAT->row['SIGN']     = 'I';
            $fce->R_BUDAT->row['OPTION']   = 'BT';
            $fce->R_BUDAT->row['LOW']      = $start;
            $fce->R_BUDAT->row['HIGH']     = $now;
            $fce->R_BUDAT->Append($fce->R_BUDAT->row);
			
            $fce->R_MATNR->row['SIGN']     = 'I';
            $fce->R_MATNR->row['OPTION']   = 'EQ';
            $fce->R_MATNR->row['LOW']      = $matnr;
            $fce->R_MATNR->row['HIGH']     = '';
            $fce->R_MATNR->Append($fce->R_MATNR->row);

            $fce->call();
            if ($fce->GetStatus() == SAPRFC_OK) {
                $fce->T_DATA->Reset();
                $i=0;
				$idr=1;
                $tampildata1=array();
                $jum_gr = array();
                $jum_gi = array();
                while ($fce->T_DATA->Next()) {
					
					// $rsnum = $fce->T_DATA->row["RSNUM"];
					// if($rsnum == '0052100475')
					// {
						// $jum_gi[] = $fce->T_DATA->row["MENGE"];
						$tampildata1[] = array(
							"NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
							"NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
							"PLANT"=>			$fce->T_DATA->row["WERKS"],
							"VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
							"KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
							"PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
							"SLOC"=>			$fce->T_DATA->row["LGORT"],
							"DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
							"UNIT"=>			$fce->T_DATA->row["MEINS"]
						);
						// $idr++; 
					// }
					// $nopo = $fce->T_DATA->row["EBELN"];
					// if($nopo == '6310000008')
					// {
						// $jum_gr[] = $fce->T_DATA->row["MENGE"];
						// $tampildata1[] = array(
							// "NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
							// "NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
							// "PLANT"=>			$fce->T_DATA->row["WERKS"],
							// "VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
							// "KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
							// "PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
							// "SLOC"=>			$fce->T_DATA->row["LGORT"],
							// "DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
							// "UNIT"=>			$fce->T_DATA->row["MEINS"]
						// );
						// $idr++;  
					// }
                }
                $fce->Close();
                $sap->Close();
            }
			$quan_gr = array_sum($jum_gr);
			$quan_gi = array_sum($jum_gi);
			echo "<pre>";
				print_r($tampildata1);
			echo "</pre>";
	}
	
    public function getDataDBVendorByMaterial($material)
        {
            $sql="select ID_COMPANY,NO_PO,KODE_VENDOR from VMI_MASTER
                  where KODE_MATERIAL = '".$material."'";
            $data = $this->db->query($sql)->row(); 
//            echo "<pre>";
//            print_r($data);
            return $data;
        }
        
        public function getDataRFCVendorByNOPO($company,$nopo,$material)
        {
            require_once APPPATH.'third_party/sapclasses/sap.php';
            $sap = new SAPConnection();
            $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
            if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
            if ($sap->GetStatus() != SAPRFC_OK ) {
                echo $sap->PrintStatus();
                exit;
            }
            $fce = &$sap->NewFunction ("Z_ZCMM_PO_DETAILC");

            if ($fce == false) {
                $sap->PrintStatus();
                exit;
            }

            // $fce->COMPANY = '7000';
            // $fce->EBELN = '6310000006';
            $fce->COMPANY = $company;		// BUKRS
            $fce->EBELN = $nopo;
//            $fce->PLANT = $plant;			// WERKS
            // $fce->VENDOR = $vendor_no;		// LIFNR
            $fce->DATE['SIGN']     = 'I';
            $fce->DATE['OPTION']     = 'BT';
            $fce->DATE['LOW']     = '20170101';
            $fce->DATE['HIGH']    = '20170912';
            
             $fce->MATERIAL->row['SIGN']    = 'I';
             $fce->MATERIAL->row['OPTION']    = 'EQ';
             $fce->MATERIAL->row['LOW']    = $material;
             $fce->MATERIAL->row['HIGH']    = '';
             $fce->MATERIAL->Append($fce->MATERIAL->row);
             
            $fce->call();
            $tampildata=array();
            if ($fce->GetStatus() == SAPRFC_OK) {
                $fce->T_ITEM->Reset();
                $data=array();
                $i=0;
                while ($fce->T_ITEM->Next()) {
//                    if ($material==$fce->T_ITEM->row["MATNR"]){
                        // if ($fce->T_ITEM->row["EKORG"]=='KS01'){
                       $tampildata[] = array("NOMER_PO"=>
                            $fce->T_ITEM->row["EBELN"],
                            "PLANT"=>$fce->T_ITEM->row["WERKS"],
                            "VENDOR_NO"=>$fce->T_ITEM->row["LIFNR"],
                            "KODE_MATERIAL"=>$fce->T_ITEM->row["MATNR"],
                            "PO_ITEM"=>$fce->T_ITEM->row["EBELP"],
                            "SLOC"=>$fce->T_ITEM->row["LGORT"],
                            "DOC_DATE"=>$fce->T_ITEM->row["BEDAT"],
                            "UNIT"=>$fce->T_ITEM->row["MEINS"]
                        );
                    // }
//                    }
                }
//                     echo "<pre>";
//                     print_r($tampildata);
//                     echo "</pre>";
//          echo $fce->MESSAGE['MESSAGE'];
                $fce->Close();
                $sap->Close();
            }
            return $tampildata;
        }
        
        public function getDataByNOPO()
        {
            $nopo    = $this->input->post('NOPO');
            $company = $this->input->post('OPCO');
            $material = $this->input->post('MATERIAL');
            require_once APPPATH.'third_party/sapclasses/sap.php';
            $sap = new SAPConnection();
            $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
            if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
            if ($sap->GetStatus() != SAPRFC_OK ) {
                echo $sap->PrintStatus();
                exit;
            }
            $fce = &$sap->NewFunction ("Z_ZCMM_PO_DETAILC");

            if ($fce == false) {
                $sap->PrintStatus();
                exit;
            }

            // $fce->COMPANY = '7000';
            // $fce->EBELN = '6310000006';
            $fce->COMPANY = $company;		// BUKRS
            $fce->EBELN = $nopo;
//            $fce->PLANT = $plant;			// WERKS
            // $fce->VENDOR = $vendor_no;		// LIFNR
            $fce->DATE['SIGN']     = 'I';
            $fce->DATE['OPTION']     = 'BT';
            $fce->DATE['LOW']     = '20170101';
            $fce->DATE['HIGH']    = '20170912';
            $fce->call();
            if ($fce->GetStatus() == SAPRFC_OK) {
                $fce->T_ITEM->Reset();
                $data=array();
                $i=0;
                $tampildata=array();
                while ($fce->T_ITEM->Next()) {
                    if ($material==$fce->T_ITEM->row["MATNR"]){
                        // if ($fce->T_ITEM->row["EKORG"]=='KS01'){
                       $tampildata[] = array("NOMER_PO"=>
                            $fce->T_ITEM->row["EBELN"],
                            "PLANT"=>$fce->T_ITEM->row["WERKS"],
                            "VENDOR_NO"=>$fce->T_ITEM->row["LIFNR"],
                            "KODE_MATERIAL"=>$fce->T_ITEM->row["MATNR"],
                            "PO_ITEM"=>$fce->T_ITEM->row["EBELP"],
                            "SLOC"=>$fce->T_ITEM->row["LGORT"],
                            "DOC_DATE"=>$fce->T_ITEM->row["BEDAT"],
                            "UNIT"=>$fce->T_ITEM->row["MEINS"]
                        );
                    // }
                    }
                }
				// echo "<pre>";
				// print_r($tampildata);
				// echo "</pre>";
//          echo $fce->MESSAGE['MESSAGE'];
                $fce->Close();
                $sap->Close();
                $data=array();
                if (count($tampildata)>0){
                    $sql = "select VENDOR_NAME,ID_VENDOR from VMI_VENDOR where ID_VENDOR='".$tampildata[count($tampildata)-1]["VENDOR_NO"]."'";
                    $datavendor = $this->db->query($sql)->row();
                    $sql = "select DESCRIPTION,KODE_MATERIAL from vmi_material where KODE_MATERIAL='".$tampildata[count($tampildata)-1]["KODE_MATERIAL"]."'";
                    $datamaterial = $this->db->query($sql)->row();
                    $sql = "select * from ADM_PLANT where PLANT_CODE='".$tampildata[count($tampildata)-1]["PLANT"]."'";
                    $dataplant = $this->db->query($sql)->row();
                    $data[] = array("NOMER_PO"=>$tampildata[count($tampildata)-1]["VENDOR_NO"],
                                  "PLANT"=>$tampildata[count($tampildata)-1]["PLANT"],
                                  "PLANT_NAME"=>$dataplant->PLANT_NAME,
                                  "VENDOR_NAME"=>$datavendor->VENDOR_NAME,
                                  "VENDOR_NO"=>$tampildata[count($tampildata)-1]["VENDOR_NO"],
                                  "VENDOR_ID"=>$$datavendor->VENDOR_ID,
                                  "KODE_MATERIAL"=>$tampildata[count($tampildata)-1]["KODE_MATERIAL"],
                                  "ID_MATERIAL"=>$datamaterial->ID_MATERIAL,
                                  "MATERIAL_NAME"=>$datamaterial->DESCRIPTION,
                                  "PO_ITEM"=>$tampildata[count($tampildata)-1]["PO_ITEM"],
                                  "SLOC"=>$tampildata[count($tampildata)-1]["SLOC"],
                                  "DOC_DATE"=>$tampildata[count($tampildata)-1]["DOC_DATE"],
                                  "UNIT"=>$tampildata[count($tampildata)-1]["UNIT"],
                            );
                }
//                $data = $tampildata;
//                print_r($tampildata);
                echo json_encode($data);
                }
        }

        public function getMINMAX(){
            $idmaterial = $this->input->post('ID_MATERIAL');
            $sql = "select MIN_STOCK,MAX_STOCK from VMI_MATERIAL
                    where ID_MATERIAL='".$idmaterial."'";
            $data = $this->db->query($sql)->result();
            echo json_encode($data);
        }

        public function getMINMAX_NEW(){
            $idmaterial = $this->input->post('KODE_MATERIAL');
            $sql = "select MIN_STOCK,MAX_STOCK from VMI_MATERIAL
                    where KODE_MATERIAL='".$idmaterial."'";
            $data = $this->db->query($sql)->result();
            echo json_encode($data);
        }

        function  getMINMAXRFCbyMaterial()
        {
            $kode_material = $this->input->post('KODE_MATERIAL');
            $ArrKembali = array();
            require_once APPPATH.'third_party/sapclasses/sap.php';
            $sap = new SAPConnection();
            $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
            if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
            if ($sap->GetStatus() != SAPRFC_OK ) {
                echo $sap->PrintStatus();
                exit;
            }

            $fce = &$sap->NewFunction ("ZCMM_MASTER_MATERIAL");

            if ($fce == false) {
                $sap->PrintStatus();
                exit;
            }

            $fce->R_MATNR->row['SIGN']     = 'I';
            $fce->R_MATNR->row['OPTION']     = 'EQ';
            $fce->R_MATNR->row['LOW']     = $kode_material;
            $fce->R_MATNR->row['HIGH']    = '';
            $fce->R_MATNR->Append($fce->R_MATNR->row);

            $fce->call();
//            echo "<pre>";
//            print_r($fce);
//            print_r($fce->GetStatus());
            if ($fce->GetStatus() == SAPRFC_OK) {
                $fce->T_DATA1->Reset();
                $i=0;
                $tampildata=array();
                while ($fce->T_DATA1->Next()) {
//                    $tampildata[] = $fce->T_DATA1->row();
                    $max =     $fce->T_DATA1->row["MABST"];
                    $min  =    $fce->T_DATA1->row["EISBE"];
                    $satuan =  $fce->T_DATA1->row["MEINS"];
                }
                $fce->Close();
                $sap->Close();
                $ArrKembali[] = array("MIN"=>intval($min),"MAX"=>intval($max),"SATUAN"=>$satuan);
//                echo "MIN ".intval($min);
//                echo "<br>";
//                echo "MAX ".intval($max);
//                echo "<br>";
//                echo "SATUAN ".$satuan;
                   
            }
            echo json_encode($ArrKembali);

        }

        public function getMINMAXPrognose(){
            $idmaterial = $this->input->post('ID_MATERIAL');
            $sql = "select KODE_MATERIAL from VMI_MATERIAL
                    where ID_MATERIAL='".$idmaterial."'";
            $dataKodeMaterial = $this->db->query($sql)->row();
            $sql = "select KODE_MATERIAL,MIN,MAX,max(TANGGAL_AKHIR) from VMI_M_PROGNOSE
                    where KODE_MATERIAL='".$dataKodeMaterial->KODE_MATERIAL."'"
                    ." GROUP BY KODE_MATERIAL,MIN,MAX ";
            $data = $this->db->query($sql)->result();
            echo json_encode($data);
        }

        public function SavePerencanaan(){
            // $input = $this->input->post(null,true);
            $plant 		= $this->input->post('PselectPlant');
            $idm 		= $this->input->post('NselectMaterial');
            $quantity 	= $this->input->post('quantity');
            $tgl_awal 	= $this->input->post('ptglawal');
			$tgl 		= explode('-',$tgl_awal);
			$tgl_input	= $tgl[1].'-'.$tgl[2];
            $tgl_akhir 	= $this->input->post('ptglakhir');
            $sqlread = "select kode_material, unit, min_stock, max_stock from VMI_MATERIAL
                        where ID_MATERIAL='$idm' and ROWNUM=1";
            $dataidlist = $this->db->query($sqlread)->row_array();
            $sql = "INSERT INTO VMI_M_PROGNOSE
                    (ID_PROGNOSE, KODE_MATERIAL, UNIT, TANGGAL_AWAL, TANGGAL_AKHIR, PLANT, QUANTITY)
                    VALUES (
					(SELECT nvl(max(ID_PROGNOSE)+1,1) ID_PROGNOSE from VMI_M_PROGNOSE),
					'".$dataidlist['KODE_MATERIAL']."',
					'".$dataidlist['UNIT']."',
					TO_DATE('".date_format(date_create($tgl_awal),'Y-m-d')."','YYYY-MM-DD'),
					TO_DATE('".date_format(date_create($tgl_akhir),'Y-m-d')."','YYYY-MM-DD'),
					'$plant',
					'$quantity'
				)";
					// '".$dataidlist['MIN_STOCK']."',
					// '".$dataidlist['MAX_STOCK']."',
            $this->db->query($sql);
            // $sqlread1 = "select TANGGAL_AWAL from VMI_M_PROGNOSE where TANGGAL_AWAL = TO_DATE('".date_format(date_create($tgl_awal),'Y-m-d')."','YYYY-MM-DD') and kode_material = '".$dataidlist['KODE_MATERIAL']."'";
            // $ini = $this->db->query($sqlread1)->row_array();
			// $tgl_db = date('m-Y',strtotime($ini['TANGGAL_AWAL']));
			// echo "$tgl_db == $tgl_input <hr/>$sqlread1";
			// if($tgl_db == $tgl_input)
			// {
				// echo "<br/> satu";
			// }
             redirect('VMI/Company/View');
        }
	function reqReservasi()
	{
		$data['title'] = "View";
		// $data['grgi'] = $this->model_grafik->get_gr()->result();
		// $data['deliv'] = $this->model_grafik->get_deliv()->result();
		$this->layout->render('vmi_req_reservasi',$data);	// Panggil --> GetDataDB
	}
	function appReservasi()
	{
        $RSNUM = $this->input->post('No_reservasi');
        $data['title'] = "View";
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_datetimepicker();
        $this->layout->add_js('plugins/select2/select2.js');
        $this->layout->add_css('plugins/select2/select2.css');
        $this->layout->add_css('plugins/select2/select2-bootstrap.css');
        $this->layout->add_js('pages/vmi_grgi.js');
		$this->layout->render('vmi_approve_reservasi',$data);	// Panggil --> GetDataDB
	}


	function reservasi()
	{
            $data['title'] = "View";
            $data['list'] = $this->GetDataReservasi();
            // $this->layout->set_table_js();
            // $this->layout->set_table_cs();
            // $this->layout->set_datetimepicker();
            // $this->layout->add_js('plugins/select2/select2.js');
            // $this->layout->add_css('plugins/select2/select2.css');
            // $this->layout->add_css('plugins/select2/select2-bootstrap.css');
             $this->layout->add_js('pages/vmi_reservasi.js');
            $this->layout->render('vmi_approve_reservasi',$data);	// Panggil --> GetDataReservasi
	}
	
	public function prognose() {
		$data['title'] = "View";
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_datetimepicker();
        $this->layout->add_js('plugins/select2/select2.js');
        $this->layout->add_css('plugins/select2/select2.css');
        $this->layout->add_css('plugins/select2/select2-bootstrap.css');
        $this->layout->add_js('pages/vmi_grgi.js');
        $this->layout->render('vmi_gr_list',$data);		// GetDataDBGr
	}

	

	public function historyGR() {
		$data['title'] = "View";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_datetimepicker();
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('pages/vmi_list_gr.js');
		$this->layout->render('vmi_list_gr',$data);		// GetListGR
	}

    public function updateStatusKirim()
    {
        $idlist = $this->input->post('idlist');
        $idpengiriman = $this->input->post('idpengiriman');
        $sqlread = "select QUANTITY from VMI_DELIVERY where ID_PENGIRIMAN='{$idpengiriman}' and ID_LIST='{$idlist}'";
        $dtQty = $this->db->query($sqlread)->row_array();
        $sql = "update VMI_DELIVERY set status_kedatangan = 1 ,TANGGAL_DATANG= SYSDATE
                where ID_PENGIRIMAN='{$idpengiriman}' and ID_LIST='{$idlist}'";
        $result = $this->db->query($sql);
        $sql2 = "update VMI_MASTER SET STOCK_VMI=NVL(STOCK_VMI,0)+".$dtQty['QUANTITY']." WHERE ID_LIST='{$idlist}'";
        $result = $this->db->query($sql2);
        echo $result;
    }

    public function GetListGR()
    {
        $empty = "0";
        $sql = "select VMI_DELIVERY.*,VMI_MASTER.LEAD_TIME,VMI_VENDOR.VENDOR_NAME,VMI_MASTER.ID_LIST,
				VMI_MASTER.NAMA_MATERIAL,ADM_PLANT.PLANT_NAME,VMI_MASTER.ID_PLANT,VMI_MASTER.NO_PO, VMI_MASTER.KODE_MATERIAL,
				TO_CHAR(VMI_DELIVERY.TANGGAL_KIRIM+VMI_MASTER.LEAD_TIME,'DD-MM-YYYY') as DT_EST_COME, TO_CHAR(VMI_DELIVERY.TANGGAL_KIRIM,'DD-MM-YYYY') TANGGAL_KIRIM2
                from VMI_DELIVERY
                join VMI_MASTER on VMI_MASTER.ID_LIST=VMI_DELIVERY.ID_LIST
                join VMI_VENDOR on VMI_VENDOR.ID_VENDOR=VMI_MASTER.KODE_VENDOR
                join ADM_PLANT on  ADM_PLANT.PLANT_CODE = VMI_MASTER.ID_PLANT
                where VMI_DELIVERY.STATUS_KEDATANGAN=1
                ";
        $datadb = $this->db->query($sql)->result_array();
        $tampildata = array();
        $i=0;
        foreach ($datadb as $key => $value) {
            $id = "text".$i;
            $tampildata[] = array(
                $value['NO_PO'],
                $value['MAT_DOC'],
                $value['PLANT_NAME'],
                $value['VENDOR_NAME'],
                $value['KODE_MATERIAL'],
                $value['NAMA_MATERIAL'],
                $value['TANGGAL_KIRIM2'],
                ($value['TANGGAL_DATANG']==null?$value['DT_EST_COME']:$value['TANGGAL_DATANG']),
                $value['LEAD_TIME'],
                ($value['QUANTITY']==null?$empty:number_format($value['QUANTITY'],0,',','.')),
            );
                // '<input type = "text" id="'.$id.'" name= "quantityReceive" size = "3px" value = "'.$value['QUANTITY'].'">'
//            id="cbox'.$i.'" onclick="UpdateTglTerima('.$value["ID_LIST"].','.$value["ID_PENGIRIMAN"].',"cbox'.$i.'")"
            $i++;
        }
            $data = array("data"=>$tampildata);
            echo json_encode($data);
    }
    public function historyGI()
    {
        $data['title'] = "View";
        $data['data_gi'] = $this->getManualdataGI();
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_datetimepicker();
        $this->layout->add_js('plugins/select2/select2.js');
        $this->layout->add_css('plugins/select2/select2.css');
        $this->layout->add_css('plugins/select2/select2-bootstrap.css');
        $this->layout->add_js('pages/vmi_list_gi.js');
        $this->layout->render('vmi_list_gi',$data);		// GetListGR
    }
    
    public function getManualdataGI()
    {
        $sql = "select VMI_MATERIAL.DESCRIPTION,VMI_GI.* from VMI_GI
                join VMI_MATERIAL on VMI_MATERIAL.KODE_MATERIAL=VMI_GI.KODE_MATERIAL";
        $dataGI = $this->db->query($sql)->result();
        return $dataGI;
    }
    
    public function GetListGI()
    {
        $empty = "0";
        $sql = "select VMI_DELIVERY.*,VMI_MASTER.LEAD_TIME,VMI_VENDOR.VENDOR_NAME,VMI_MASTER.ID_LIST,
				VMI_MASTER.NAMA_MATERIAL,ADM_PLANT.PLANT_NAME,VMI_MASTER.ID_PLANT,VMI_MASTER.NO_PO, VMI_MASTER.KODE_MATERIAL,
				TO_CHAR(VMI_DELIVERY.TANGGAL_KIRIM+VMI_MASTER.LEAD_TIME,'DD-MM-YYYY') as DT_EST_COME, TO_CHAR(VMI_DELIVERY.TANGGAL_KIRIM,'DD-MM-YYYY') TANGGAL_KIRIM2
                from VMI_DELIVERY
                join VMI_MASTER on VMI_MASTER.ID_LIST=VMI_DELIVERY.ID_LIST
                join VMI_VENDOR on VMI_VENDOR.ID_VENDOR=VMI_MASTER.KODE_VENDOR
                join ADM_PLANT on  ADM_PLANT.PLANT_CODE = VMI_MASTER.ID_PLANT
                where VMI_DELIVERY.STATUS_KEDATANGAN=1
                ";
        $datadb = $this->db->query($sql)->result_array();
        $tampildata = array();
        $i=0;
        foreach ($datadb as $key => $value) {
            $id = "text".$i;
            $tampildata[] = array(
                $value['NO_PO'],
                $value['MAT_DOC'],
                $value['PLANT_NAME'],
                $value['VENDOR_NAME'],
                $value['KODE_MATERIAL'],
                $value['NAMA_MATERIAL'],
                $value['TANGGAL_KIRIM2'],
                ($value['TANGGAL_DATANG']==null?$value['DT_EST_COME']:$value['TANGGAL_DATANG']),
                $value['LEAD_TIME'],
                ($value['QUANTITY']==null?$empty:number_format($value['QUANTITY'],0,',','.')),
            );
                // '<input type = "text" id="'.$id.'" name= "quantityReceive" size = "3px" value = "'.$value['QUANTITY'].'">'
//            id="cbox'.$i.'" onclick="UpdateTglTerima('.$value["ID_LIST"].','.$value["ID_PENGIRIMAN"].',"cbox'.$i.'")"
            $i++;
        }
            $data = array("data"=>$tampildata);
            echo json_encode($data);
    }
    
    public function  addNewVMI(){
         $data = $this->input->post();
         $tgl1 = date_format(date_create($data['NActiveContract']), 'Y-m-d');
         $tgl2 = date_format(date_create($data['NEndContract']), 'Y-m-d');
         $tgldocdate = date_format(date_create($data['Ndocdate']), 'Y-m-d');

         $sql = "INSERT INTO VMI_MASTER(ID_LIST, ID_COMPANY, ID_PLANT, NO_PO, CONTRACT_ACTIVE, CONTRACT_END, TYPE_VENDOR, MIN_STOCK, MAX_STOCK, LEAD_TIME, STOCK_AWAL, KODE_MATERIAL, NAMA_MATERIAL, PO_ITEM,SLOC,DOC_DATE,UNIT,KODE_VENDOR,STATUS) "
                . "VALUES ((select nvl(max(ID_LIST),0)+1 from VMI_MASTER), "
                // . "'".$data['NidMaterial']."', "
//				. "'".$data['NidVendor']."', "
				. "'".$data['NselectCompany']."', "
				. "'".$data['NkodePlant']."',"
				. "'".$data['NNOPO']."', "
				. "to_date('".$tgl1."','YYYY-MM-DD'), "
				. "to_date('".$tgl2."','YYYY-MM-DD'), "
				. "'".$data['NselectType']."',"
				. "'".$data['Nmin']."',"
				. "'".$data['Nmax']."',"
				. "'".$data['NLeadTime']."',"
				. "'".$data['Nstock']."',"
				. "'".$data['NkodeMaterial']."',"
				 . "'".$data['Nnamamaterial']."',"
				. "'".substr('0000'.$data['Npoitem'], -5)."',"
				. "'".$data['Nsloc']."',"
				. "to_date('".$tgldocdate."','YYYY-MM-DD'), "
				. "'".$data['Nunit']."',"
				. "'".$data['NkodeVendor']."',"
				. "'".$data['Nrop']."')";
      $a =  $this->db->query($sql);
	if ($a){
            redirect('VMI/Company/View');
        }else{
            redirect('VMI/Company/View');
        }
     }

     public function  m_getSelectCompany(){
//         $sql = "select COMPANYID,COMPANYNAME from ADM_COMPANY where ISACTIVE=1";
         $sql = "select COMPANYID,COMPANYNAME from ADM_COMPANY";
         $data = $this->db->query($sql)->result();
         return $data;
     }

     public function  m_getSelectMaterial(){
         $sql="select * from VMI_MATERIAL";
         $data = $this->db->query($sql)->result();
         return $data;
     }

     public function  m_getSelectVendor(){
         $sql="select id_vendor,vendor_name from VMI_VENDOR";
         $data = $this->db->query($sql)->result();
         return $data;
     }

     public function  m_getSelectAllPlant(){
         $idcomp = $this->input->post('idcomp');
         $sql = "select * from ADM_PLANT";
         $data = $this->db->query($sql)->result();
         return $data;
     }
     public function  m_getSelectPlant(){
         $idcomp = $this->input->post('idcomp');
         $sql = "select * from ADM_PLANT where COMPANY_ID='{$idcomp}'";
         $data = $this->db->query($sql)->result();
         echo json_encode($data);
     }

	public function GetDataReservasi()
    {
        $RSNUM = $this->input->post('NO_RESERVASI');
        require_once APPPATH.'third_party/sapclasses/sap.php';
        $sap = new SAPConnection();
        $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
        if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
        if ($sap->GetStatus() != SAPRFC_OK ) {
            echo $sap->PrintStatus();
            exit;
        }
        $fce = &$sap->NewFunction ("ZCMM_RESERVATION_GETDETAIL");

        if ($fce == false) {
            $sap->PrintStatus();
            exit;
        }

       $fce->I_RSNUM = $RSNUM;
       // $fce->I_RSNUM = '0051563002'; // Buat Tes Data
        // $fce->COMPANY = $company;
        // $fce->PLANT = $plant;
        // $fce->VENDOR = $vendor_no;
        // $fce->DATE['SIGN']     = 'I';
        // $fce->DATE['OPTION']     = 'BT';
        // $fce->DATE['LOW']     = '20100101';
        // $fce->DATE['HIGH']    = '20170731';
        $fce->call();
        if ($fce->GetStatus() == SAPRFC_OK) {
            $fce->RESERVATION_ITEMS->Reset();

            $list_reser=array();

            $i=0;
            $rtampildata=array();
            while ($fce->RESERVATION_ITEMS->Next()) {
                // $data[] = ($fce->RESERVATION_ITEMS->row);
                // echopre($data);

                $list_reser[$i]["RES_NO"] 	= $fce->RESERVATION_ITEMS->row["RES_NO"];
                $list_reser[$i]["MATERIAL"] 	= $fce->RESERVATION_ITEMS->row["MATERIAL"];
                $list_reser[$i]["PLANT"] 	= $fce->RESERVATION_ITEMS->row["PLANT"];
                $list_reser[$i]["REQ_DATE"] 	= $fce->RESERVATION_ITEMS->row["REQ_DATE"];
                $list_reser[$i]["UNIT"] 	= $fce->RESERVATION_ITEMS->row["UNIT"];
                $list_reser[$i]["QUANTITY"] 	= intval($fce->RESERVATION_ITEMS->row["QUANTITY"]);
                $list_reser[$i]["REQ_QUAN"] 	= intval($fce->RESERVATION_ITEMS->row["REQ_QUAN"]);
                $list_reser[$i]["MOVE_TYPE"] 	= $fce->RESERVATION_ITEMS->row["MOVE_TYPE"];
                $list_reser[$i]["G_L_ACCT"] 	= $fce->RESERVATION_ITEMS->row["G_L_ACCT"];
                $list_reser[$i]["SHORT_TEXT"] 	= $fce->RESERVATION_ITEMS->row["SHORT_TEXT"];
                $list_reser[$i]["MAT_GRP"] 	= $fce->RESERVATION_ITEMS->row["MAT_GRP"];
                $list_reser[$i]["PO_NUMBER"] 	= $fce->RESERVATION_ITEMS->row["PO_NUMBER"];
                $list_reser[$i]["PO_ITEM"] 	= $fce->RESERVATION_ITEMS->row["PO_ITEM"];
                $list_reser[$i]["STORE_LOC"] 	= $fce->RESERVATION_ITEMS->row["STORE_LOC"];
                $list_reser[$i]["ORDER_NO"] 	= $fce->RESERVATION_ITEMS->row["ORDER_NO"];
                $list_reser[$i]["RES_ITEM"] 	= $fce->RESERVATION_ITEMS->row["RES_ITEM"];
                $list_reser[$i]["VENDOR"] 	= $fce->RESERVATION_ITEMS->row["VENDOR"];
                // $tampildata[] = $fce->RESERVATION_ITEMS->row["WERKS"];
                $i++;
            }

            $fce->Close();
            $sap->Close();
            // echo '<pre>';
            // print_r($list_reser);
            // echo '<pre>';
            // echopre($list_po);
            $uniquetampildata = array_unique($list_reser);
            $urut = asort($uniquetampildata);
            $showdata = array_values($uniquetampildata);
            // $data = array("data"=>$showdata);
            // echo json_encode($data);
            return $showdata;
        }
    }

    public function GetDataRfc()
    {
        require_once APPPATH.'third_party/sapclasses/sap.php';
        $sap = new SAPConnection();
        $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");

        if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
        if ($sap->GetStatus() != SAPRFC_OK ) {
            echo $sap->PrintStatus();
            exit;
        }
        $fce = &$sap->NewFunction ("ZCMM_MASTER_MATERIAL");

        if ($fce == false) {
            $sap->PrintStatus();
            exit;
        }

        $fce->call();

//        echo $fce;

        if ($fce->GetStatus() == SAPRFC_OK) {
            $fce->T_STOCK_CONSINYASI->Reset();

            $data=array();

            $i=0;
            $tampildata=array();
            while ($fce->T_STOCK_CONSINYASI->Next() && $i<=5) {
                // $data[] = ($fce->T_STOCK_CONSINYASI->row);
                // echopre($data);

                /*$list_po[$i]["MATNR"] = $fce->T_STOCK_CONSINYASI->row["MATNR"];
                $list_po[$i]["MAKTX"] = $fce->T_STOCK_CONSINYASI->row["MAKTX"];
                $list_po[$i]["WERKS"] = $fce->T_STOCK_CONSINYASI->row["WERKS"];
                $list_po[$i]["LGORT"] = $fce->T_STOCK_CONSINYASI->row["LGORT"];
                $list_po[$i]["LIFNR"] = $fce->T_STOCK_CONSINYASI->row["LIFNR"];
                $list_po[$i]["NAME1"] = $fce->T_STOCK_CONSINYASI->row["NAME1"];
                $list_po[$i]["SLABS"] = $fce->T_STOCK_CONSINYASI->row["SLABS"];
                $list_po[$i]["MEINS"] = $fce->T_STOCK_CONSINYASI->row["MEINS"];
                $list_po[$i]["EISBE"] = $fce->T_STOCK_CONSINYASI->row["EISBE"];
                $list_po[$i]["MABST"] = $fce->T_STOCK_CONSINYASI->row["MABST"];
                $list_po[$i]["MINBE"] = $fce->T_STOCK_CONSINYASI->row["MINBE"];*/

                $tampildata[] = array(
                            $fce->T_STOCK_CONSINYASI->row["WERKS"],
                            $fce->T_STOCK_CONSINYASI->row["NAME1"],
                            $fce->T_STOCK_CONSINYASI->row["MAKTX"],
                            $fce->T_STOCK_CONSINYASI->row["MEINS"],
                            "NONE",
                            (int)$fce->T_STOCK_CONSINYASI->row["SLABS"],
                            (int)$fce->T_STOCK_CONSINYASI->row["EISBE"],
                            (int)$fce->T_STOCK_CONSINYASI->row["MABST"],
                            (int)$fce->T_STOCK_CONSINYASI->row["MINBE"],
                            "NONE");
                $i++;
                if ($i>=5){
                break;
                }
            }

            $fce->Close();
            $sap->Close();
            // echo '<pre>';
            //     print_r($list_po);
            // echo '<pre>';
            // echopre($list_po);
            $data = array("data"=>$tampildata);
            echo json_encode($data);
        }
    }


    public function GetNomerPo()
    {
        $company 	= $this->input->post('company');
        $plant 		= $this->input->post('plant');
        $vendor 	= $this->input->post('vendor');
        $sql = "select VENDOR_NO from VND_HEADER where VENDOR_ID='".$vendor."'";
        $result = $this->db->query($sql)->row();
        $vendor_no = $result->VENDOR_NO;
        require_once APPPATH.'third_party/sapclasses/sap.php';
        $sap = new SAPConnection();
        $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
        if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
        if ($sap->GetStatus() != SAPRFC_OK ) {
            echo $sap->PrintStatus();
            exit;
        }
        $fce = &$sap->NewFunction ("Z_ZCMM_PO_DETAILC");

        if ($fce == false) {
            $sap->PrintStatus();
            exit;
        }

		$fce->COMPANY = '2000';
        // $fce->COMPANY = $company;		// BUKRS
        // $fce->PLANT = $plant;			// WERKS
        // $fce->VENDOR = $vendor_no;		// LIFNR
        $fce->DATE['SIGN']     = 'I';
        $fce->DATE['OPTION']     = 'BT';
        $fce->DATE['LOW']     = '20100101';
        $fce->DATE['HIGH']    = '20170731';
        $fce->call();
        if ($fce->GetStatus() == SAPRFC_OK) {
            $fce->T_ITEM->Reset();
            $data=array();
            $i=0;
            $tampildata=array();
            while ($fce->T_ITEM->Next()) {
                // if ($fce->T_ITEM->row["EKORG"]=='KS01'){
                   $tampildata[] = array("NOMER_PO"=>
                    $fce->T_ITEM->row["EBELN"]
                  );
                // }
            }
//          echo $fce->MESSAGE['MESSAGE'];
            $fce->Close();
            $sap->Close();
            $data = $tampildata;
            echo json_encode($data);
        }
    }

    public function GetDataPrognose()
    {
        $empty = "0";
//        $datadb = $this->db->from('VMI_MASTER')
////                    ->select('VMI_MASTER.LEAD_TIME LEAD_TIME_VENDOR,VMI_MASTER.*,M_VND_SUBMATERIAL.*,VMI_DATA.*,VND_HEADER.*')
//                    ->join('M_VND_SUBMATERIAL','M_VND_SUBMATERIAL.SUBMATERIAL_CODE=VMI_MASTER.ID_MATERIAL')
//                    ->join('VMI_DATA','VMI_DATA.ID_LIST=VMI_MASTER.ID_LIST','left')
//                    ->join('VND_HEADER','VND_HEADER.VENDOR_ID=VMI_MASTER.ID_VENDOR')
//                    ->get()
//                   ->result_array();
        $sql = "SELECT
                    (SELECT sum(quantity) qty1 from VMI_DELIVERY where VMI_DELIVERY.ID_LIST=VMI_MASTER.ID_LIST and STATUS_KEDATANGAN=1) T_STOCKVMI,
                    (SELECT sum(quantity) qty2 from VMI_DELIVERY where VMI_DELIVERY.ID_LIST=VMI_MASTER.ID_LIST and STATUS_KEDATANGAN=0) T_STOCKDELIV,
                    (SELECT sum(quantity) qty3 from VMI_GR_GI where VMI_GR_GI.ID_LIST=VMI_MASTER.ID_LIST and STATUS_APPROVE=1) T_STOCKGRGI,
                            VMI_MASTER.ID_LIST ID_LISTVENDOR,
                            VMI_MASTER.*, VMI_VENDOR.*, VMI_MATERIAL.*
                    FROM
                            VMI_MASTER
                    JOIN VMI_MATERIAL ON VMI_MATERIAL.ID_MATERIAL = VMI_MASTER.ID_MATERIAL
                    JOIN VMI_VENDOR ON VMI_VENDOR.ID_VENDOR = VMI_MASTER.KODE_VENDOR";
        $datadb = $this->db->query($sql)->result_array();

        foreach ($datadb as $key => $value) {
			$IDL = $value['ID_LIST'];
            $tampildata[] = array(
                        $value['ID_PLANT'],
                        $value['VENDOR_NAME'],
                        $value['NAMA_MATERIAL'],
                        ($value['UNIT']==null?$empty:$value['UNIT']),
                        ($value['T_STOCKGRGI']==null?$empty:number_format($value['T_STOCKGRGI'],0,',','.')),
                        ($value['STOCK_VMI']==null?$empty:number_format($value['STOCK_VMI'],0,',','.')),
                        ($value['T_STOCKDELIV']==null?$empty:number_format($value['T_STOCKDELIV'],0,',','.')),
                        ($value['STOCK_AWAL']==null?$empty:number_format($value['STOCK_AWAL'],0,',','.')),
                        ($value['MIN_STOCK']==null?$empty:number_format($value['MIN_STOCK'],0,',','.')),
                        ($value['MAX_STOCK']==null?$empty:number_format($value['MAX_STOCK'],0,',','.')),
                        $value['LEAD_TIME'],
                        $value['NO_PO'],
                        $value['CONTRACT_ACTIVE'],
                        $value['CONTRACT_END'],
						"<a href='".base_url('VMI/Company/Grafik/')."/".$value['ID_LIST']."'><span class='label-success label label-success'>Show Grafik</span></a>"
            );
        }
            $data = array("data"=>$tampildata);
             echo json_encode($data);
//
//			echo"<pre>";
//			print_r($datadb);
//			echo"</pre>";
    }

    public function getSelectMaterialNew(){
        $datadb = $this->db->from('VMI_MATERIAL')
                   ->get()
                   ->result();
        return $datadb;
    }


    public function getVMIMaterial(){
        $idplant = $this->input->post('ID_PLANT');
        $datadb = $this->db->from('VMI_MASTER')
                    ->select('VMI_MASTER.KODE_MATERIAL KODE_MATERIAL,VMI_MATERIAL.DESCRIPTION NAMA_MATERIAL')
                    ->join('VMI_MATERIAL','VMI_MATERIAL.KODE_MATERIAL=VMI_MASTER.KODE_MATERIAL')
                    ->where('VMI_MASTER.ID_PLANT',$idplant)
                    ->get()
                   ->result();
        echo json_encode($datadb);
    }

    public function getVMIPlant(){
        $datadb = $this->db->from('VMI_MASTER')
                    ->select('VMI_MASTER.ID_PLANT ID_PLANT,ADM_PLANT.PLANT_NAME PLANT_NAME')
                    ->join('ADM_PLANT','ADM_PLANT.PLANT_CODE=VMI_MASTER.ID_PLANT')
                    ->distinct()
                    ->get()
                   ->result();
        return $datadb;
    }

    public function GetSelectPlant()
    {
        require_once APPPATH.'third_party/sapclasses/sap.php';
        $sap = new SAPConnection();
        $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");

        if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
        if ($sap->GetStatus() != SAPRFC_OK ) {
            echo $sap->PrintStatus();
            exit;
        }
        $fce = &$sap->NewFunction ("ZCMM_MASTER_MATERIAL");

        if ($fce == false) {
            $sap->PrintStatus();
            exit;
        }

        $fce->call();

        echo $fce;

        if ($fce->GetStatus() == SAPRFC_OK) {
            $fce->T_STOCK_CONSINYASI->Reset();

            $data=array();

            $i=0;
            $rtampildata=array();
            while ($fce->T_STOCK_CONSINYASI->Next()) {
                // $data[] = ($fce->T_STOCK_CONSINYASI->row);
                // echopre($data);

                /*$list_po[$i]["MATNR"] = $fce->T_STOCK_CONSINYASI->row["MATNR"];
                $list_po[$i]["MAKTX"] = $fce->T_STOCK_CONSINYASI->row["MAKTX"];
                $list_po[$i]["WERKS"] = $fce->T_STOCK_CONSINYASI->row["WERKS"];
                $list_po[$i]["LGORT"] = $fce->T_STOCK_CONSINYASI->row["LGORT"];
                $list_po[$i]["LIFNR"] = $fce->T_STOCK_CONSINYASI->row["LIFNR"];
                $list_po[$i]["NAME1"] = $fce->T_STOCK_CONSINYASI->row["NAME1"];
                $list_po[$i]["SLABS"] = $fce->T_STOCK_CONSINYASI->row["SLABS"];
                $list_po[$i]["MEINS"] = $fce->T_STOCK_CONSINYASI->row["MEINS"];
                $list_po[$i]["EISBE"] = $fce->T_STOCK_CONSINYASI->row["EISBE"];
                $list_po[$i]["MABST"] = $fce->T_STOCK_CONSINYASI->row["MABST"];
                $list_po[$i]["MINBE"] = $fce->T_STOCK_CONSINYASI->row["MINBE"];*/
                $tampildata[] = $fce->T_STOCK_CONSINYASI->row["WERKS"];
                $i++;
            }

            $fce->Close();
            $sap->Close();
            // echo '<pre>';
            //     print_r($list_po);
            // echo '<pre>';
            // echopre($list_po);
            $uniquetampildata = array_unique($tampildata);
            $urut = asort($uniquetampildata);
            $showdata = array_values($uniquetampildata);
            // $data = array("data"=>$showdata);
            // echo json_encode($data);
            return $showdata;
        }
    }

    public function GetSelectMaterial()
    {
        $plant = $this->input->post('plant');
        require_once APPPATH.'third_party/sapclasses/sap.php';
        $sap = new SAPConnection();
        $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");

        if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
        if ($sap->GetStatus() != SAPRFC_OK ) {
            echo $sap->PrintStatus();
            exit;
        }
        $fce = &$sap->NewFunction ("ZCMM_MASTER_MATERIAL");

        if ($fce == false) {
            $sap->PrintStatus();
            exit;
        }

        $fce->call();

        echo $fce;

        if ($fce->GetStatus() == SAPRFC_OK) {
            $fce->T_STOCK_CONSINYASI->Reset();

            $data=array();

            $i=0;
            $rtampildata=array();
            while ($fce->T_STOCK_CONSINYASI->Next()) {
                // $data[] = ($fce->T_STOCK_CONSINYASI->row);
                // echopre($data);

                /*$list_po[$i]["MATNR"] = $fce->T_STOCK_CONSINYASI->row["MATNR"];
                $list_po[$i]["MAKTX"] = $fce->T_STOCK_CONSINYASI->row["MAKTX"];
                $list_po[$i]["WERKS"] = $fce->T_STOCK_CONSINYASI->row["WERKS"];
                $list_po[$i]["LGORT"] = $fce->T_STOCK_CONSINYASI->row["LGORT"];
                $list_po[$i]["LIFNR"] = $fce->T_STOCK_CONSINYASI->row["LIFNR"];
                $list_po[$i]["NAME1"] = $fce->T_STOCK_CONSINYASI->row["NAME1"];
                $list_po[$i]["SLABS"] = $fce->T_STOCK_CONSINYASI->row["SLABS"];
                $list_po[$i]["MEINS"] = $fce->T_STOCK_CONSINYASI->row["MEINS"];
                $list_po[$i]["EISBE"] = $fce->T_STOCK_CONSINYASI->row["EISBE"];
                $list_po[$i]["MABST"] = $fce->T_STOCK_CONSINYASI->row["MABST"];
                $list_po[$i]["MINBE"] = $fce->T_STOCK_CONSINYASI->row["MINBE"];*/
                if ($fce->T_STOCK_CONSINYASI->row["WERKS"]==$plant){
                    $tampildata[] = array('KODE_MATERIAL' => $fce->T_STOCK_CONSINYASI->row["MATNR"],
                                          'NAMA_MATERIAL' => $fce->T_STOCK_CONSINYASI->row["MAKTX"]
                                        );
                }
                $i++;
            }

            $fce->Close();
            $sap->Close();
            $uniquetampildata = array_unique($tampildata);
            $urut = asort($uniquetampildata);
            $showdata = array_values($uniquetampildata);
            echo json_encode($showdata);
        }
    }

    public function GetSelectVendor()
    {
        $kodematerial = $this->input->post('material');
        require_once APPPATH.'third_party/sapclasses/sap.php';
        $sap = new SAPConnection();
        $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");

        if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
        if ($sap->GetStatus() != SAPRFC_OK ) {
            echo $sap->PrintStatus();
            exit;
        }
        $fce = &$sap->NewFunction ("ZCMM_MASTER_MATERIAL");

        if ($fce == false) {
            $sap->PrintStatus();
            exit;
        }

        $fce->call();

        echo $fce;

        if ($fce->GetStatus() == SAPRFC_OK) {
            $fce->T_STOCK_CONSINYASI->Reset();

            $data=array();

            $i=0;
            $rtampildata=array();
            while ($fce->T_STOCK_CONSINYASI->Next()) {
                // $data[] = ($fce->T_STOCK_CONSINYASI->row);
                // echopre($data);

                /*$list_po[$i]["MATNR"] = $fce->T_STOCK_CONSINYASI->row["MATNR"];
                $list_po[$i]["MAKTX"] = $fce->T_STOCK_CONSINYASI->row["MAKTX"];
                $list_po[$i]["WERKS"] = $fce->T_STOCK_CONSINYASI->row["WERKS"];
                $list_po[$i]["LGORT"] = $fce->T_STOCK_CONSINYASI->row["LGORT"];
                $list_po[$i]["LIFNR"] = $fce->T_STOCK_CONSINYASI->row["LIFNR"];
                $list_po[$i]["NAME1"] = $fce->T_STOCK_CONSINYASI->row["NAME1"];
                $list_po[$i]["SLABS"] = $fce->T_STOCK_CONSINYASI->row["SLABS"];
                $list_po[$i]["MEINS"] = $fce->T_STOCK_CONSINYASI->row["MEINS"];
                $list_po[$i]["EISBE"] = $fce->T_STOCK_CONSINYASI->row["EISBE"];
                $list_po[$i]["MABST"] = $fce->T_STOCK_CONSINYASI->row["MABST"];
                $list_po[$i]["MINBE"] = $fce->T_STOCK_CONSINYASI->row["MINBE"];*/
                if ($fce->T_STOCK_CONSINYASI->row["MATNR"]==$kodematerial){
                    $tampildata[] = array('KODE_VENDOR' => $fce->T_STOCK_CONSINYASI->row["LIFNR"],
                                          'NAMA_VENDOR' => $fce->T_STOCK_CONSINYASI->row["NAME1"]
                                        );
                }
                $i++;
            }

            $fce->Close();
            $sap->Close();
            $uniquetampildata = array_unique($tampildata);
            $urut = asort($uniquetampildata);
            $showdata = array_values($uniquetampildata);
            echo json_encode($showdata);
        }
    }
    public function GrGi()
    {
        $data['title'] = "View";
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_datetimepicker();
        $this->layout->add_js('plugins/select2/select2.js');
        $this->layout->add_css('plugins/select2/select2.css');
        $this->layout->add_css('plugins/select2/select2-bootstrap.css');
        $this->layout->add_js('pages/vmi_grgi.js');
        $this->layout->render('vmi_gr_list',$data);
    }

    public function updateTglApproveGR()
    {
        $idlist = $this->input->post('idlist');
        $idgr = $this->input->post('idgr');
        $sqlread = "SELECT QUANTITY FROM VMI_GR_GI where ID_GR='{$idgr}' and ID_LIST='{$idlist}'";
        $dtQty = $this->db->query($sqlread)->row_array();
        $sql = "update VMI_GR_GI set status_approve = 1 ,TANGGAL_APPROVE= SYSDATE
                where ID_GR='{$idgr}' and ID_LIST='{$idlist}'";
        $result = $this->db->query($sql);
        $sql2 = "update VMI_MASTER SET STOCK_VMI=NVL(STOCK_VMI,0)-".$dtQty['QUANTITY']." WHERE ID_LIST='{$idlist}'";
        $result = $this->db->query($sql2);
        echo $result;
    }

    public function GetDataDBGr()
    {
        $empty = "0";
        $sql = "select * from VMI_GR_GI where status_approve = 0";
        $id_list = $this->db->query($sql)->row_array();

        $sql1 = "select a.plant, b.nama_material, a.unit, a.quantity, a.min, a.max,
				a.tanggal_awal, a.tanggal_akhir, a.kode_material
				from VMI_M_PROGNOSE a, VMI_MATERIAL b
				where a.kode_material = b.kode_material
				order by id_prognose asc";
		$datadb = $this->db->query($sql1)->result_array();

        $tampildata = array();
		foreach ($datadb as $key => $value) {
				$tampildata[] = array(
                $value['PLANT'],
                $value['NAMA_MATERIAL'],
                $value['UNIT'],
                $value['QUANTITY'],
                $value['MIN'],
                $value['MAX'],
                $value['TANGGAL_AWAL'],
                $value['TANGGAL_AKHIR'],
                $value['KODE_MATERIAL']
                // '<div class="checkbox">
                // <label>
                  // <input type="checkbox" onclick="UpdateTglApproveGR('.$value["ID_LIST"].','.$value["ID_LIST"].')">
                // </label>
                // </div>'
            );
        }
            $data = array("data"=>$tampildata);
            echo json_encode($data);
    }

    public function Testdata()
    {
        require_once APPPATH.'third_party/sapclasses/sap.php';
        $sap = new SAPConnection();
        $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");

        if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
        if ($sap->GetStatus() != SAPRFC_OK ) {
            echo $sap->PrintStatus();
            exit;
        }
        $fce = &$sap->NewFunction ("ZCMM_MASTER_MATERIAL");

        if ($fce == false) {
            $sap->PrintStatus();
            exit;
        }

        $fce->call();

        echo $fce;

        if ($fce->GetStatus() == SAPRFC_OK) {
            $fce->T_STOCK_CONSINYASI->Reset();

            $data=array();

            $i=0;
            $tampildata=array();
            while ($fce->T_STOCK_CONSINYASI->Next()) {
                // $data[] = ($fce->T_STOCK_CONSINYASI->row);
                // echopre($data);

                $list_po[$i]["MATNR"] = $fce->T_STOCK_CONSINYASI->row["MATNR"];
                $list_po[$i]["MAKTX"] = $fce->T_STOCK_CONSINYASI->row["MAKTX"];
                $list_po[$i]["WERKS"] = $fce->T_STOCK_CONSINYASI->row["WERKS"];
                $list_po[$i]["LGORT"] = $fce->T_STOCK_CONSINYASI->row["LGORT"];
                $list_po[$i]["LIFNR"] = $fce->T_STOCK_CONSINYASI->row["LIFNR"];
                $list_po[$i]["NAME1"] = $fce->T_STOCK_CONSINYASI->row["NAME1"];
                $list_po[$i]["SLABS"] = $fce->T_STOCK_CONSINYASI->row["SLABS"];
                $list_po[$i]["MEINS"] = $fce->T_STOCK_CONSINYASI->row["MEINS"];
                $list_po[$i]["EISBE"] = $fce->T_STOCK_CONSINYASI->row["EISBE"];
                $list_po[$i]["MABST"] = $fce->T_STOCK_CONSINYASI->row["MABST"];
                $list_po[$i]["MINBE"] = $fce->T_STOCK_CONSINYASI->row["MINBE"];

                // $tampildata[] = array(
                //             $fce->T_STOCK_CONSINYASI->row["WERKS"],
                //             $fce->T_STOCK_CONSINYASI->row["NAME1"],
                //             $fce->T_STOCK_CONSINYASI->row["MAKTX"],
                //             "NONE",
                //             "NONE",
                //             "NONE",
                //             (int)$fce->T_STOCK_CONSINYASI->row["EISBE"],
                //             (int)$fce->T_STOCK_CONSINYASI->row["MABST"],
                //             (int)$fce->T_STOCK_CONSINYASI->row["MINBE"],
                //             "NONE");
                $i++;
            }

            $fce->Close();
            $sap->Close();
            echo '<pre>';
                print_r($list_po);
            echo '<pre>';
            echopre($list_po);
            // $data = array("data"=>$tampildata);
            // echo json_encode($data);
        }
    }

    public function GRMaterialTesting(){
//            $input = $this->input->post();
//            $listgr = json_decode($input['listreservasi'],true);
            require_once APPPATH.'third_party/sapclasses/sap.php';
            $sap = new SAPConnection();
            $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");

            if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
            if ($sap->GetStatus() != SAPRFC_OK ) {
                    echo $sap->PrintStatus();
                    exit;
            }

            $fce = $sap->NewFunction("BAPI_GOODSMVT_CREATE");
            if ($fce == false ) {
               $sap->PrintStatus();
               exit;
            }

            $fce->GOODSMVT_HEADER["PSTNG_DATE"]     = '20170918';
            $fce->GOODSMVT_HEADER["DOC_DATE"]       = '20170918';
            $fce->GOODSMVT_CODE["GM_CODE"] 			= '01';		// GR
            $fce->GOODSMVT_ITEM->row["STGE_LOC"] 	= 'W201';
            $fce->GOODSMVT_ITEM->row["MOVE_TYPE"] 	= '101';		// GR
            $fce->GOODSMVT_ITEM->row["ENTRY_QNT"] 	= '1';
            $fce->GOODSMVT_ITEM->row["PO_NUMBER"] 	= '6310000006';
            $fce->GOODSMVT_ITEM->row["PO_ITEM"] 	= '00040';
            $fce->GOODSMVT_ITEM->row["MVT_IND"] 	= 'B';
            $fce->GOODSMVT_ITEM->row["MATERIAL"] 	= '119-200157';
            $fce->GOODSMVT_ITEM->row["PLANT"]       = '7702';
            $fce->GOODSMVT_ITEM->row["ENTRY_UOM"] 	= 'DR';

            $fce->GOODSMVT_ITEM->Append($fce->GOODSMVT_ITEM->row);
            $laporan = '';
            $fce->Call();
			
					// echo "<pre>";
                   // print_r($fce->GOODSMVT_ITEM->row);
					// echo "</pre>";
				//baca return value
				if ($fce->GetStatus() == SAPRFC_OK) {
							$fce->RETURN->Reset();
					//Display Tables
					$ada_error=false;
					while ( $fce->RETURN->Next() ){
									if(trim($fce->RETURN->row["TYPE"])=='E')$ada_error=true;
						if($ada_error) $laporan .= $i.". ".$fce->RETURN->row["ID"]." : ".$fce->RETURN->row["MESSAGE"]."<br>";
					}
				}

				if ($fce->GetStatus() == SAPRFC_OK and !$ada_error) {
					$doc_num=$fce->GOODSMVT_HEADRET["MAT_DOC"];
					if(strlen(trim($doc_num))>0)$laporan .= "Good Receipt telah ter-create dg mat-document :".$doc_num."<br>";

					//Commit Transaction
					$fce = $sap->NewFunction ("BAPI_TRANSACTION_COMMIT");
					$fce->Call();
				}
						// echo $laporan;
				
           echo "<pre>";
           print_r($laporan);
           echo "</pre>";
           echo "<pre>";
           print_r($doc_num);
           echo "</pre>";
		$fce->Close();
		$sap->Close();
        }


      public function GRMaterial(){
            $input = $this->input->post();
			// require_once APPPATH.'third_party/sapclasses/sap.php';
            // $matdoc = array();
            if ($input['listreceive']!=""){
                $listgr = json_decode($input['listreceive'],true);
//                print_r($listgr);
                foreach ($listgr as $key => $value) {
                    /* $sql = "select PO_ITEM,SLOC,DOC_DATE,UNIT from VMI_MASTER where id_list='".$value['ID_LIST']."'";
                    $datavmimaster = $this->db->query($sql)->row_array();
                    $sap = new SAPConnection();
                    $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");

                    if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
                    if ($sap->GetStatus() != SAPRFC_OK ) {
                            echo $sap->PrintStatus();
                            exit;
                    }

                    $fce = $sap->NewFunction("BAPI_GOODSMVT_CREATE");
                    if ($fce == false ) {
                       $sap->PrintStatus();
                       exit;
                    }
					// $date = date("Ymd");
                    // $fce->GOODSMVT_HEADER["PSTNG_DATE"]     	= '20170918';		// date now
                    // $fce->GOODSMVT_HEADER["DOC_DATE"] 	      	= '20170918';	// date now
					// $fce->GOODSMVT_ITEM->row["PO_ITEM"]      = $datavmimaster['PO_ITEM'];		// rfc
                    $fce->GOODSMVT_HEADER["PSTNG_DATE"] 	 = $value['POSTING_DATE'];	// date now
                    $fce->GOODSMVT_HEADER["DOC_DATE"] 	     = $value['POSTING_DATE'];	// date now
                    $fce->GOODSMVT_CODE["GM_CODE"] 	     	 = '01';		// GR			// hardcode
                    $fce->GOODSMVT_ITEM->row["STGE_LOC"]     = $datavmimaster['SLOC'];		// rfc
                    $fce->GOODSMVT_ITEM->row["MOVE_TYPE"]    = '101';		// GR		// hardcode
                    $fce->GOODSMVT_ITEM->row["ENTRY_QNT"]    = $value['QTY_RECEIVE'];		// input
                    $fce->GOODSMVT_ITEM->row["PO_NUMBER"]    = $value['NOPO'];		// db
                    $fce->GOODSMVT_ITEM->row["PO_ITEM"]      = substr('0000'.$datavmimaster['PO_ITEM'], -5);		// rfc
                    // $fce->GOODSMVT_ITEM->row["PO_ITEM"]      = '00040';		// rfc
                    $fce->GOODSMVT_ITEM->row["MVT_IND"]      = 'B';						// hardcode
                    $fce->GOODSMVT_ITEM->row["MATERIAL"]     = $value['ID_MATERIAL'];		// db
                    $fce->GOODSMVT_ITEM->row["PLANT"]        = $value['PLANT'];			// db
                    $fce->GOODSMVT_ITEM->row["ENTRY_UOM"]    = $datavmimaster['UNIT'];			// db
					
					$fce->GOODSMVT_ITEM->Append($fce->GOODSMVT_ITEM->row);
					$laporan = '';
					$fce->Call();
					echo "<pre>";
						print_r($fce->GOODSMVT_HEADER);
					echo "</pre>";
					echo "<hr/>";
					echo "<pre>";
						print_r($fce->GOODSMVT_ITEM);
					echo "</pre>";
					
                        //baca return value
                        if ($fce->GetStatus() == SAPRFC_OK) {
									$fce->RETURN->Reset();
							//Display Tables
							$ada_error=false;
							while ( $fce->RETURN->Next() ){
											if(trim($fce->RETURN->row["TYPE"])=='E')$ada_error=true;
								if($ada_error) $laporan .= $i.". ".$fce->RETURN->row["ID"]." : ".$fce->RETURN->row["MESSAGE"]."<br>";
							}
						}

						if ($fce->GetStatus() == SAPRFC_OK and !$ada_error) {
							$doc_num=$fce->GOODSMVT_HEADRET["MAT_DOC"];
							if(strlen(trim($doc_num))>0)$laporan .= "Good Receipt telah ter-create dg mat-document :".$doc_num."<br>";

							//Commit Transaction
							$fce = $sap->NewFunction ("BAPI_TRANSACTION_COMMIT");
							$fce->Call();
						}
						// echo "<pre>";
						// print_r($doc_num);
						// echo "</pre>";
                        $fce->Close();
                        $sap->Close(); */

                        $sql = "update VMI_DELIVERY set status_kedatangan = 1 ,TANGGAL_DATANG = SYSDATE
                                where ID_PENGIRIMAN='{$value['ID_PENGIRIMAN']}' and ID_LIST='{$value['ID_LIST']}'";
                        $result = $this->db->query($sql);
                        $sql2 = "update VMI_MASTER SET STOCK_VMI=NVL(STOCK_VMI,0)+".$value['QTY_RECEIVE']." WHERE ID_LIST='{$value['ID_LIST']}'";
                        $result = $this->db->query($sql2);
				}
            }
        redirect('VMI/Company/income');
        }

       public function GIReserveTesting(){
//            $input = $this->input->post();
//            $listgr = $input['listreservasi'];
            require_once APPPATH.'third_party/sapclasses/sap.php';
		$sap = new SAPConnection();
		$sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");

		if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
		if ($sap->GetStatus() != SAPRFC_OK ) {
			echo $sap->PrintStatus();
			exit;
		}

		$fce = $sap->NewFunction("BAPI_GOODSMVT_CREATE");
		if ($fce == false ) {
		   $sap->PrintStatus();
		   exit;
		}

            $fce->GOODSMVT_HEADER["PSTNG_DATE"]     = '20170907';
            $fce->GOODSMVT_HEADER["DOC_DATE"] 		= '20170907';
            $fce->GOODSMVT_CODE["GM_CODE"] 			= '03';		// GI
            $fce->GOODSMVT_ITEM->row["PLANT"]       = '7702';
            $fce->GOODSMVT_ITEM->row["STGE_LOC"] 	= 'W201';
            $fce->GOODSMVT_ITEM->row["MOVE_TYPE"] 	= '961';		// GI
            $fce->GOODSMVT_ITEM->row["SPEC_STOCK"] 	= 'K';
            $fce->GOODSMVT_ITEM->row["VENDOR"]      = '0000110016';
            $fce->GOODSMVT_ITEM->row["ENTRY_QNT"] 	= '1';
            $fce->GOODSMVT_ITEM->row["RESERV_NO"] 	= '0052100475';
            $fce->GOODSMVT_ITEM->row["RES_ITEM"] 	= '0001';
            // $fce->GOODSMVT_ITEM->row["VAL_TYPE"] 	= 'C1';
            // $fce->GOODSMVT_ITEM->row["WITHDRAWN"]   = 'X';
			// $fce->GOODSMVT_ITEM->row["MVT_IND"] 	= 'B';
			// $fce->GOODSMVT_ITEM->row["MATERIAL"] 	= $listgr['MATERIAL'];
			// $fce->GOODSMVT_ITEM->row["PLANT"]           = $listgr['PLANT'];
			// $fce->GOODSMVT_ITEM->row["STGE_LOC"] 	= $listgr['STORE_LOC'];
			// $fce->GOODSMVT_ITEM->row["ENTRY_UOM"] 	= $listgr['OUM'];
			// $fce->GOODSMVT_ITEM->row["PO_NUMBER"] 	= $listgr['PO_NUMBER'];
			// $fce->GOODSMVT_ITEM->row["PO_ITEM"] 	= $listgr['PO_ITEM'];

            $fce->GOODSMVT_ITEM->Append($fce->GOODSMVT_ITEM->row);
            $laporan = '';
            $fce->Call();
			
			echo "<pre>";
				print_r($fce->GOODSMVT_HEADER);
			echo "</pre>";
			echo "<hr/>";
			echo "<pre>";
				print_r($fce->GOODSMVT_ITEM);
			echo "</pre>";
			
				//baca return value
				if ($fce->GetStatus() == SAPRFC_OK) {
							$fce->RETURN->Reset();
					//Display Tables
					$ada_error=false;
					while ( $fce->RETURN->Next() ){
							if(trim($fce->RETURN->row["TYPE"])=='E')$ada_error=true;
						if($ada_error) $laporan .= $i.". ".$fce->RETURN->row["ID"]." : ".$fce->RETURN->row["MESSAGE"]."<br>";
					}
				}else{
				}
				echo "<hr/>";
				print_r($fce->RETURN);
				// print_r($fce->RETURN->row["MESSAGE"]);

				if ($fce->GetStatus() == SAPRFC_OK and !$ada_error) {
				$doc_num=$fce->GOODSMVT_HEADRET["MAT_DOC"];
				if(strlen(trim($doc_num))>0)$laporan .= "Good Receipt telah ter-create dg mat-document :".$doc_num."<br>";

				//Commit Transaction
				$fce = $sap->NewFunction ("BAPI_TRANSACTION_COMMIT");
				$fce->Call();
				echo "<br>matdoc created";
				}else {
					echo "<br>matdoc not create";
				}
				echo "<hr/>";
				print_r($laporan);

		$fce->Close();
		$sap->Close();

       }

       public function GIReserve(){
           require_once APPPATH.'third_party/sapclasses/sap.php';
           $input = $this->input->post();
           $matdoc = array();
            if ($input['listreservasi']!=""){
                $listgr = json_decode($input['listreservasi'],true);
//                print_r($listgr);
                    $i=1;
                    foreach ($listgr as $key => $value) {
                    $dataVendor = $this->getDataDBVendorByMaterial($value['MATERIAL']);
                    $kodeVendor = $dataVendor->KODE_VENDOR;
                    $sap = new SAPConnection();
                    $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");

                    if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
                    if ($sap->GetStatus() != SAPRFC_OK ) {
                            echo $sap->PrintStatus();
                            exit;
                    }

                    $fce = $sap->NewFunction("BAPI_GOODSMVT_CREATE");
                    if ($fce == false ) {
                       $sap->PrintStatus();
                       exit;
                    }
					// header[PSTNG_DATE]=20170905
					// &header[DOC_DATE]=20170905
					// &header[HEADER_TXT]=INI
					// &detail[0][MOVE_TYPE]=961
					// &detail[0][ENTRY_QNT]=2
					// &detail[0][RESERV_NO]=0051557346
					// &detail[0][RES_ITEM]=0001

                    // $fce->GOODSMVT_HEADER["PSTNG_DATE"]     = $value['POSTING_DATE'];
                    // $fce->GOODSMVT_HEADER["DOC_DATE"] 		= $value['DOC_DATE'];
                    // $fce->GOODSMVT_ITEM->row["MATERIAL"]     = $value['MATERIAL'];
                    // $fce->GOODSMVT_ITEM->row["SPEC_STOCK"] 	= 'K';		// GI
                    // $fce->GOODSMVT_ITEM->row["ENTRY_QNT"] 	= str_replace(".", "", $value['REQ_QUAN']);
                    // $fce->GOODSMVT_ITEM->row["RESERV_NO"] 	= $value['RES_NO'];
                    // $fce->GOODSMVT_ITEM->row["RES_ITEM"] 	= '00010';
					// $fce->GOODSMVT_ITEM->row["VAL_TYPE"] 	= 'C1';
                    // $fce->GOODSMVT_ITEM->row["STGE_LOC"] 	= $value['STORE_LOC'];
//                    $fce->GOODSMVT_ITEM->row["VENDOR"]       = $kodeVendor;
                    
                    // $fce->GOODSMVT_ITEM->row["RESERV_NO"] 	= '0051557346';
                    $fce->GOODSMVT_HEADER["PSTNG_DATE"]     = '20170915';
                    $fce->GOODSMVT_HEADER["DOC_DATE"] 		= '20170915';
                    $fce->GOODSMVT_CODE["GM_CODE"] 			= '03';		// GI
                    // $fce->GOODSMVT_CODE["GM_CODE"] 			= '06';		// GI
                    // $fce->GOODSMVT_ITEM->row["RESERV_NO"] 	= '0052100475';
                    $fce->GOODSMVT_ITEM->row["RESERV_NO"] 	= '001847476';		// Reservasi Clon
                    $fce->GOODSMVT_ITEM->row["RES_ITEM"] 	= '0001';
                    $fce->GOODSMVT_ITEM->row["MOVE_TYPE"] 	= '961';		// GI
                    $fce->GOODSMVT_ITEM->row["ENTRY_QNT"] 	= '1000';
                    $fce->GOODSMVT_ITEM->row["PLANT"]       = '7702';
                    $fce->GOODSMVT_ITEM->row["STGE_LOC"] 	= 'W201';
					$fce->GOODSMVT_ITEM->row["SPEC_STOCK"] 	= 'K';
					$fce->GOODSMVT_ITEM->row["VENDOR"]      = '0000110016';
					// $fce->GOODSMVT_ITEM->row["WITHDRAWN"] 	= 'X';

                    echo "INPUT PARAMETER<br>";
                    echo "==========================<br>";
                    echo "<pre>";
                    echo "GOODSMVT_HEADER<br>";
                    print_r($fce->GOODSMVT_HEADER);
                    echo "GOODSMVT_CODE<br>";
                    print_r($fce->GOODSMVT_CODE);
                    echo "GOODSMVT_ITEM<br>";
                    print_r($fce->GOODSMVT_ITEM->row);
                    echo "</pre>";
                    echo "==========================<br>";

                    echo "OUTPUT<br>";
                    echo "==========================<br>";
                    $fce->GOODSMVT_ITEM->Append($fce->GOODSMVT_ITEM->row);
                    $laporan = '';
                    $fce->Call();
                        //baca return value
                        if ($fce->GetStatus() == SAPRFC_OK) {
                                $fce->RETURN->Reset();
                                //Display Tables
                                $ada_error=false;
                                while ( $fce->RETURN->Next() ){
                                    if(trim($fce->RETURN->row["TYPE"])=='E')$ada_error=true;
                                        if($ada_error) $laporan .= $i.". ".$fce->RETURN->row["ID"]." : ".$fce->RETURN->row["MESSAGE"]."<br>";
                                }
                        }ELSE{
                            ECHO "EROR ".$fce->RETURN->row["MESSAGE"]." ".$fce->RETURN->row["TYPE"]."<BR>";
                        }
						echo '<pre>';
						print_r($fce->RETURN);
						echo '</pre>';

                        if ($fce->GetStatus() == SAPRFC_OK and !$ada_error) {
                                $doc_num=$fce->GOODSMVT_HEADRET["MAT_DOC"];
                                if(strlen(trim($doc_num))>0)$laporan .= "Good Receipt telah ter-create dg mat-document :".$doc_num."<br>";
                                $matdoc[] = $doc_num;
                                //Commit Transaction
                                $fce = $sap->NewFunction ("BAPI_TRANSACTION_COMMIT");
                                $fce->Call();
                        }ELSE{
                            // ECHO "EROR COMMIT ".$fce->RETURN->row["MESSAGE"]." ".$fce->RETURN->row["TYPE"]."<BR>";;
                        }

                        // echo $laporan."<BR>";
                        $fce->Close();
                        $sap->Close();
                        $i++;
						$res_item = substr('000'.$value['RES_ITEM'], -4);
                            // "insert into VMI_GI(NO_RESERVASI,GM_CODE,MOVE_TYPE,QUANTITY,ITEM_RESERVASI,MAT_DOC,POSTING_DATE,DOC_DATE)
                                                    // VALUES('".$value['RES_NO']."','03','961','".$value['REQ_QUAN']."','$res_item','$doc_num','".$value['POSTING_DATE']."','".$value['DOC_DATE']."')"
                            $sql = "insert into VMI_GI(NO_RESERVASI,GM_CODE,MOVE_TYPE,QUANTITY,ITEM_RESERVASI,MAT_DOC,POSTING_DATE,DOC_DATE)
                                                                    VALUES('".$value['RES_NO']."','03','961','".$value['REQ_QUAN']."','$res_item','$doc_num',
                                                                    TO_DATE('".date_format(date_create($value['POSTING_DATE']),'Y-m-d')."','YYYY-MM-DD'),
                                                                    TO_DATE('".date_format(date_create($value['DOC_DATE']),'Y-m-d')."','YYYY-MM-DD')
                                                                    )";
                            $result = $this->db->query($sql);
//                            echo "$sql";
                }
                print_r($matdoc);
            }
        }

	public function bapiExecute(){
		require_once APPPATH.'third_party/sapclasses/sap.php';
		$sap = new SAPConnection();
		$sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");

		if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
		if ($sap->GetStatus() != SAPRFC_OK ) {
			echo $sap->PrintStatus();
			exit;
		}

		$fce = $sap->NewFunction("BAPI_GOODSMVT_CREATE");
		if ($fce == false ) {
		   $sap->PrintStatus();
		   exit;
		}

		$laporan = '';

//     	$tgldoc		= explode("-",$this->tgldoc->Date);
//		$tgldoc		= $tgldoc[2]."".$tgldoc[1]."".$tgldoc[0];
//		$tglpost	= explode("-",$this->tglpost->Date);
//		$tglpost	= $tglpost[2]."".$tglpost[1]."".$tglpost[0];
//     	$datenow 	= date('Ymd');

		$fce->GOODSMVT_HEADER["PSTNG_DATE"]             = '20170809';
		$fce->GOODSMVT_HEADER["DOC_DATE"] 		= '20170808';

		$fce->GOODSMVT_CODE["GM_CODE"] 			= '01';		// GR
		// $fce->GOODSMVT_CODE["GM_CODE"] 		= '03';		// GI

		//detail gr entri
//		foreach($this->Repeater->Items as $item){
//			if($item->pilih->Checked) {
						// ========================= GR ======================
                        $fce->GOODSMVT_ITEM->row["MATERIAL"] 	= '7702';
                        $fce->GOODSMVT_ITEM->row["PLANT"] 	= '';
                        // $fce->GOODSMVT_ITEM->row["STGE_LOC"] = 'w201';
                        $fce->GOODSMVT_ITEM->row["STGE_LOC"] 	= 'w208';
                        $fce->GOODSMVT_ITEM->row["MOVE_TYPE"] 	= '101';		// GR

                        /*$qty=str_replace(",",".",$item->NETTO->Text);
                        $qty=floatval($item->NETTO->Text);*/

                        $fce->GOODSMVT_ITEM->row["ENTRY_QNT"] 	= '2200';
                        $fce->GOODSMVT_ITEM->row["ENTRY_UOM"] 	= '';
                        $fce->GOODSMVT_ITEM->row["PO_NUMBER"] 	= '4500000824';
                        $fce->GOODSMVT_ITEM->row["PO_ITEM"] 	= '00001';
                        $fce->GOODSMVT_ITEM->row["MVT_IND"] 	= 'B';
//                        $fce->GOODSMVT_ITEM->row["VENDRBATCH"] 	= '';
                        $fce->GOODSMVT_ITEM->Append($fce->GOODSMVT_ITEM->row);
						// ========================= GR ======================

						// ========================= GI ======================
                        // $fce->GOODSMVT_ITEM->row["MATERIAL"] 	= '7702';
                        // $fce->GOODSMVT_ITEM->row["PLANT"] 		= '';
                        // $fce->GOODSMVT_ITEM->row["STGE_LOC"] 	= 'w201';
                        // $fce->GOODSMVT_ITEM->row["STGE_LOC"] 	= 'w208';
                        // $fce->GOODSMVT_ITEM->row["MOVE_TYPE"] 	= '961';		// GI

                        /*$qty=str_replace(",",".",$item->NETTO->Text);
						$qty=floatval($item->NETTO->Text);*/
						// butuh production_orderid	untuk melakukan GI
                        // $fce->GOODSMVT_ITEM->row["ENTRY_QNT"] 	= '2200';
                        // $fce->GOODSMVT_ITEM->row["ENTRY_UOM"] 	= '';		// nggak wajib
                        // $fce->GOODSMVT_ITEM->row["PO_NUMBER"] 	= '4500000824';
                        // $fce->GOODSMVT_ITEM->row["PO_ITEM"] 		= '00001';
                        // $fce->GOODSMVT_ITEM->row["MVT_IND"] 		= '';		// nggak wajib
                        // $fce->GOODSMVT_ITEM->row["VENDRBATCH"] 	= '';
                        // $fce->GOODSMVT_ITEM->Append($fce->GOODSMVT_ITEM->row);
						// ========================= GI ======================
//			}
//		}

		$fce->Call();

		//baca return value
		if ($fce->GetStatus() == SAPRFC_OK) {
			//Tables
			//echo "<table><tr><td>Kolom1</td><td>Kolom2</td></tr>";
                	$fce->RETURN->Reset();
			//Display Tables
			$ada_error=false;
			while ( $fce->RETURN->Next() ){
                            if(trim($fce->RETURN->row["TYPE"])=='E')$ada_error=true;
				if($ada_error) $laporan .= $i.". ".$fce->RETURN->row["ID"]." : ".$fce->RETURN->row["MESSAGE"]."<br>";
			}
		}

		if ($fce->GetStatus() == SAPRFC_OK and !$ada_error) {
			$doc_num=$fce->GOODSMVT_HEADRET["MAT_DOC"];
			if(strlen(trim($doc_num))>0)$laporan .= "Good Receipt telah ter-create dg mat-document :".$doc_num."<br>";

			//Commit Transaction
			$fce = $sap->NewFunction ("BAPI_TRANSACTION_COMMIT");
			$fce->Call();

			//UPDATE STATUS ON TIMBANGAN TABLE
//			if ($fce->GetStatus() == SAPRFC_OK ) {
//				try{
//					$fce = $sap->NewFunction ("Z_ZAPPIC_UPDATE_TIMB_BYLOT");
//					if ($fce == false ) {
//					   $sap->PrintStatus();
//					   exit;
//					}
//
//					$fce->XDATA_UPD["STATUS_DESC"]="RECEIPT";
//					$fce->XDATA_UPD["LAST_UPDATED_BY"]=$this->User->ID;
//					$fce->XDATA_UPD["UPDT_DATE"]=date('Ymd');
//					$fce->XDATA_UPD["UPDT_TIME"]=date('H:i:s');
//					$fce->XDATA_UPD["GR_NUM"]=$doc_num;
//					$fce->XDATA_UPD["NAMA_KAPAL"]=strtoupper($this->kapal->Text);
//
//					$fce->XDATA_APP["NMORG"]=$this->User->Org;
//					$fce->XDATA_APP["NMPLAN"]=$this->User->Plant;
//
//					foreach($this->Repeater->Items as $item){
//						if($item->pilih->Checked) {
//							$fce->GR_LOT->row["SIGN"] ='I';
//							$fce->GR_LOT->row["OPTION"] ='EQ';
//							$fce->GR_LOT->row["LOW"] = $item->LOT_ID->Text;
//							$fce->GR_LOT->Append($fce->GR_LOT->row);
//						}
//					}
//
//					$fce->Call();
//				}catch(Exception $e){
//					echo $e;
//				}
//			}//else $fce->PrintStatus();

		}//else $fce->PrintStatus();

		echo $laporan;

		$fce->Close();
		$sap->Close();
  	}

            public function NewgoodIssue(){
		$this->load->library('sap_invoice');
		$input = $this->input->post();
                $matdoc = array();
                if ($input['listreservasi']!=""){
                    $listgr = json_decode($input['listreservasi'],true);
                    $i=1;
//                    // $fce->GOODSMVT_HEADER["PSTNG_DATE"]     = $value['POSTING_DATE'];
//                    $fce->GOODSMVT_HEADER["PSTNG_DATE"]     = '20170905';
//                    // $fce->GOODSMVT_HEADER["DOC_DATE"] 		= $value['DOC_DATE'];
//                    $fce->GOODSMVT_HEADER["DOC_DATE"] 		= '20170905';
//                    $fce->GOODSMVT_CODE["GM_CODE"] 			= '03';		// GI
//                    $fce->GOODSMVT_ITEM->row["MOVE_TYPE"] 	= '961';		// GI
//                    // $fce->GOODSMVT_ITEM->row["ENTRY_QNT"] 	= str_replace(".", "", $value['REQ_QUAN']);
//					$fce->GOODSMVT_ITEM->row["ENTRY_QNT"] = '2';
//                    // $fce->GOODSMVT_ITEM->row["RESERV_NO"] 	= $value['RES_NO'];
//                    $fce->GOODSMVT_ITEM->row["RESERV_NO"] 	= '0051557346';
//                    // $fce->GOODSMVT_ITEM->row["RES_ITEM"] 	= substr('000'.$value['RES_ITEM'], -4);
//                    $fce->GOODSMVT_ITEM->row["RES_ITEM"] 	= '0001';
////                    $fce->GOODSMVT_ITEM->row["VAL_TYPE"] 	= 'C1';
//                    // $fce->GOODSMVT_ITEM->row["PLANT"]       = $value['PLANT'];
//                    // $fce->GOODSMVT_ITEM->row["STGE_LOC"] 	= $value['STORE_LOC'];
////                    $fce->GOODSMVT_ITEM->row["SPEC_STOCK"] 	= 'K';
////                    $fce->GOODSMVT_ITEM->row["VENDOR"]          = $value['VENDOR'];
////                    $fce->GOODSMVT_ITEM->row["WITHDRAWN"]       = 'X';

                        foreach ($listgr as $key => $value) {
                            $inputData = array(
				'GOODSMVT_HEADER' => array(
					'PSTNG_DATE' 	=> $value['POSTING_DATE'],
					'DOC_DATE' 	=> $value['DOC_DATE'],
					'HEADER_TXT' 	=> '',
				),
                                    'GOODSMVT_ITEM' => array(
                                            array(
                                                    'MOVE_TYPE' => '961',
                                                    'ENTRY_QNT' => '1',
                                                    // 'RESERV_NO' => '0051560038',		// Mas Affandi Not Allowed
                                                    // 'RESERV_NO' => '0051563002',		// Mas Affandi Not Allowed
                                                    'RESERV_NO' => $value['RES_NO'],		// Mas Affandi Sukses
                                                    // 'RESERV_NO' => '0051554956',		// For reservation 0051554956 0001, no movements can be posted
                                                    // 'RESERV_NO' => '0051557345',		// Mas Samsu Not Allowed
                                                    // 'RESERV_NO' => '0051566201',		// Enter Sloc
                                                    'RES_ITEM' => substr('000'.$value['RES_ITEM'], -4),
                                            )
                                    )
                            );
                              $input = array(
                              'EXPORT_PARAM_ARRAY' => array(
                                'GOODSMVT_CODE' => array('GM_CODE' => '03')
                              ),
                              'EXPORT_PARAM_TABLE' => array()
                            );
                            if(isset($inputData['GOODSMVT_HEADER'])){
                               $input['EXPORT_PARAM_ARRAY']['GOODSMVT_HEADER'] = $inputData['GOODSMVT_HEADER'];
                            }
                            if(isset($inputData['GOODSMVT_ITEM'])){
                               $input['EXPORT_PARAM_TABLE']['GOODSMVT_ITEM'] = $inputData['GOODSMVT_ITEM'];
                            }
                            $output = array(
                              'EXPORT_PARAM_TABLE' => array('RETURN'),
                              'EXPORT_PARAM_ARRAY' => array('GOODSMVT_HEADRET')
                            );

                                              // print_r($input);
                            $t = $this->sap_invoice->callFunction('BAPI_GOODSMVT_CREATE',$input,$output,0);
                                      echo "<pre>";
                                      print_r($t);
                        }
                }
      //array('error' => $t['EXPORT_PARAM_TABLE']['RETURN'], 'success' => $t['EXPORT_PARAM_ARRAY']['GOODSMVT_HEADRET']);
    }

		function goodIssue(){
			//header[PSTNG_DATE]=20170905
			// &header[DOC_DATE]=20170905
			// &header[HEADER_TXT]=INI
			// &detail[0][MOVE_TYPE]=961
			// &detail[0][ENTRY_QNT]=2
			// &detail[0][RESERV_NO]=0051557346
			// &detail[0][RES_ITEM]=0001
			$this->load->library('sap_invoice');
			// $inputData = array(
				// 'GOODSMVT_HEADER' => array(
					// 'PSTNG_DATE' => '20170905',
					// 'DOC_DATE' => '20170905',
					// 'HEADER_TXT' => 'COba',
				// ),
				// 'GOODSMVT_ITEM' => array(
					// array(
						// 'ENTRY_QNT' => '2',
						// 'RESERV_NO' => '0051557346',
						// 'RES_ITEM' => '0001',
						// ''
					// )
				// )
			// );		// Data mas Affandi ==> Sukses
			$inputData = array(
				'GOODSMVT_HEADER' => array(
					'PSTNG_DATE' 	=> '20170905',
					'DOC_DATE' 		=> '20170905',
					'HEADER_TXT' 	=> 'COba',
				),
				'GOODSMVT_ITEM' => array(
					array(
						'MOVE_TYPE' 	=> '961',
						'ENTRY_QNT' => '1',
						'STGE_LOC' => 'W201',
						// 'RESERV_NO' => '0051560038',		// Mas Affandi Not Allowed
						// 'RESERV_NO' => '0051563002',		// Mas Affandi Not Allowed
						'RESERV_NO' => '0052100475',		// Mas Affandi Sukses
						// 'RESERV_NO' => '0051554956',		// For reservation 0051554956 0001, no movements can be posted
						// 'RESERV_NO' => '0051557345',		// Mas Samsu Not Allowed
						// 'RESERV_NO' => '0051566201',		// Enter Sloc
						'RES_ITEM' => '0001',
						''
					)
				)
			);
      $input = array(
        'EXPORT_PARAM_ARRAY' => array(
          'GOODSMVT_CODE' => array('GM_CODE' => '03')
        ),
        'EXPORT_PARAM_TABLE' => array()
      );
      if(isset($inputData['GOODSMVT_HEADER'])){
         $input['EXPORT_PARAM_ARRAY']['GOODSMVT_HEADER'] = $inputData['GOODSMVT_HEADER'];
      }
      if(isset($inputData['GOODSMVT_ITEM'])){
         $input['EXPORT_PARAM_TABLE']['GOODSMVT_ITEM'] = $inputData['GOODSMVT_ITEM'];
      }
      $output = array(
        'EXPORT_PARAM_TABLE' => array('RETURN'),
        'EXPORT_PARAM_ARRAY' => array('GOODSMVT_HEADRET')
      );

			// print_r($input);
      $t = $this->sap_invoice->callFunction('BAPI_GOODSMVT_CREATE',$input,$output,0);
		echo "<pre>";
		print_r($t);
      //array('error' => $t['EXPORT_PARAM_TABLE']['RETURN'], 'success' => $t['EXPORT_PARAM_ARRAY']['GOODSMVT_HEADRET']);
    }

}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

	public function __construct(){
            parent::__construct();
            $this->ci = &get_instance();
            $this->load->library('Layout');
            $this->load->library('Authorization');
			$this->load->model(array('vnd_header'));
            $this->load->model('model_grafik');
            $this->_lot="";
	}

    function echopre($dt){
        echo'<pre>';
            print_r($dt);
        echo'</pre>';
    }

	function index(){
	}
	
	function view(){
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
	
	/* function UserGuide(){
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
		// $this->layout->set_datetimepicker();
		// $this->layout->add_js('plugins/select2/select2.js');
		// $this->layout->add_css('plugins/select2/select2.css');
		// $this->layout->add_css('plugins/select2/select2-bootstrap.css');
		// $this->layout->add_js('pages/vmi_all.js');
		$this->layout->render('vmi_manual_list',$data);	// Panggil RFC --> GetAllPO
	} */
	
	function filter(){
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
	
	function income(){
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
				'
					<input type = "hidden" id="'.$id.'" name= "quantityReceive" size = "3px" value = "'.$value['QUANTITY'].'">
					<input type = "text" id="'.$id.'asd" name= "quantityReceiveAsd" size = "3px" value = "'.$value['QUANTITY'].'">
				',
                '<div class="checkbox">
                <label>
					<center>
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
	// Butuh Direvisi
	function GetRealisasi($list){
		// echo "<pre>";
		// print_r($list);
		// echo "</pre>";
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

            $fce = &$sap->NewFunction ("ZCMM_TRANSAKSI_MATERIAL");

            if ($fce == false) {
                $sap->PrintStatus();
                exit;
            }
			
			$fce->LR_BUDAT->row['SIGN']     = 'I';
			$fce->LR_BUDAT->row['OPTION']   = 'BT';
			$fce->LR_BUDAT->row['LOW']      = $date_awal;
			$fce->LR_BUDAT->row['HIGH']     = $date_akhir;
			$fce->LR_BUDAT->Append($fce->LR_BUDAT->row);

			$fce->LR_BUKRS->row['SIGN']     = 'I';
			$fce->LR_BUKRS->row['OPTION']   = 'EQ';
			$fce->LR_BUKRS->row['LOW']      = $idcom;
			$fce->LR_BUKRS->row['HIGH']     = '';
			$fce->LR_BUKRS->Append($fce->LR_BUKRS->row);
			
			$fce->LR_WERKS->row['SIGN']     = 'I';
			$fce->LR_WERKS->row['OPTION']   = 'EQ';
			$fce->LR_WERKS->row['LOW']      = $plant;
			$fce->LR_WERKS->row['HIGH']     = '';
			$fce->LR_WERKS->Append($fce->LR_WERKS->row);
			
			$fce->LR_MATNR->row['SIGN']     = 'I';
			$fce->LR_MATNR->row['OPTION']   = 'EQ';
			$fce->LR_MATNR->row['LOW']      = $matnr;
			$fce->LR_MATNR->row['HIGH']     = '';
			$fce->LR_MATNR->Append($fce->LR_MATNR->row);
			
			$ArrMovementtype = array('101','102','105','106','961','962');
			foreach ($ArrMovementtype as $key => $Movementtype) {
				$fce->LR_BWART->row['SIGN']     = 'I';
				$fce->LR_BWART->row['OPTION']   = 'EQ';
				$fce->LR_BWART->row['LOW']      = $Movementtype;
				$fce->LR_BWART->row['HIGH']     = '';
				$fce->LR_BWART->Append($fce->LR_BWART->row);
			}
			// echo "
				// $date_awal - $date_akhir<br/>
				// $idcom<br/>
				// $plant<br/>
				// $matnr<br/>
				// <hr/>
			// ";
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
		$tampildata = array();
        // $input = $this->input->post(null,true);
		$awal  = str_replace(".","-", $cawal);
		$akhir = str_replace(".","-", $cakhir);
		
		if($awal == '' && $akhir == ''){
			$tglawal 	= date('Ym01');
			$tglakhir	= date('Ymt');
			// $tglawal1 	= date('Y-m-01');	// Klo bisa diganti tanggal minimal PO Active aja
			$tglawal1 	= date('Y-01-01');	// Klo bisa diganti tanggal minimal PO Active aja
			$tglakhir1	= date('Y-m-t');
		}
		elseif($akhir == ''){
			$tglawal 	= date('Ym01');
			$tglakhir	= date('Ymt');
			$tglawal1 	= date('Y-m-01');	// Klo bisa diganti tanggal minimal PO Active aja
			$tglakhir1	= date('Y-m-t');
		}
		else{
			$tglawal 	= date_format(date_create($awal),'Ymd');
			$tglakhir 	= date_format(date_create($akhir),'Ymd');
			$tglawal1 	= date_format(date_create($awal),'Y-m-d');
			$tglakhir1 	= date_format(date_create($akhir),'Y-m-d');
		}

		$arrDataConsumption = $this->getAllConsumption($tglawal,$tglakhir);
		$ArrGI = array();
		$ArrGR = array();
		$AllGI = array();
		$AllGR = array();
		$listGI = array();
		$listGR = array();
		$totalGR=0;
		$totalGI=0;

		foreach ($arrDataConsumption as $key2 => $value2) {
			$qty=0;
			  if ($value2['Transaction']=='S')
	           {
	           		$qty = intval($value2['Quantity']);
	           }elseif($value2['Transaction']=='H'){
	           		$qty = intval($value2['Quantity'])*-1;
	           }
			if ($value2['Jenis']=='WA')
			{
					if (array_key_exists($value2['VENDOR_NO'].",".$value2['KODE_MATERIAL'], $ArrGI))
					{
						$totalGI = $ArrGI[$value2['VENDOR_NO'].",".$value2['KODE_MATERIAL']];
						$totalGI+= $qty;
						$ArrGI[$value2['VENDOR_NO'].",".$value2['KODE_MATERIAL']] = $totalGI;
					}else{
						$totalGI = $qty;
						$ArrGI[$value2['VENDOR_NO'].",".$value2['KODE_MATERIAL']] = $totalGI;	
					}
				$listGI[$value2['VENDOR_NO'].",".$value2['KODE_MATERIAL']][] = $value2['Transaction']."/".$qty;
				$AllGI[] = $value2;
			}elseif($value2['Jenis']=='WE')
			{
				if (array_key_exists($value2['NOMER_PO'].",".$value2['VENDOR_NO'].",".$value2['KODE_MATERIAL'], $ArrGR))
					{
						$totalGR = $ArrGR[$value2['NOMER_PO'].",".$value2['VENDOR_NO'].",".$value2['KODE_MATERIAL']];
						$totalGR+= $qty;
						$ArrGR[$value2['NOMER_PO'].",".$value2['VENDOR_NO'].",".$value2['KODE_MATERIAL']] = $totalGR;
					}else{
						$totalGR = $qty;
						$ArrGR[$value2['NOMER_PO'].",".$value2['VENDOR_NO'].",".$value2['KODE_MATERIAL']] = $totalGR;	
					}
					$listGR[$value2['NOMER_PO'].",".$value2['VENDOR_NO'].",".$value2['KODE_MATERIAL']][] = $value2['Transaction']."/".$qty;
				$AllGR[] = $value2;
			}
		}
		
		// echo "<pre>";
		// print_r($ArrGI);
		// print_r($listGI);
		// print_r($ArrGI);
		// exit();
		// print_r($AllGI);
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		///
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$sql = "SELECT KODE_VENDOR,ID_LIST,NO_PO,NAMA_VENDOR,NAMA_MATERIAL,UNIT,PLANT,QUANTITY,STOCK_VMI,STOCK_AWAL,MIN_STOCK,MAX_STOCK,CONTRACT_ACTIVE,CONTRACT_END,STATUS,KODE_MATERIAL,TO_CHAR(LAST_UPDATED, 'DD-MM-YYYY') LAST_UPDATED, QUANTITY, NO_PO,PO_ITEM, ID_COMPANY, PLANT
				from VMI_MASTER 
				where STATUS = '1'
				AND TO_CHAR (CONTRACT_ACTIVE,'YYYY-MM-DD') BETWEEN '$tglawal1' AND '$tglakhir1' OR TO_CHAR (CONTRACT_END,'YYYY-MM-DD') BETWEEN '$tglawal1' AND '$tglakhir1'
				order by id_list asc";
				// AND TO_CHAR (CONTRACT_END, 'YYYY-MM-DD') 	BETWEEN '$tglakhir1' 							AND TO_CHAR (CONTRACT_END, 'YYYY-MM-DD')
				// and TO_CHAR(CONTRACT_ACTIVE, 'YYYY-MM-DD') >= '$tglawal1'
				// and TO_CHAR(CONTRACT_END, 'YYYY-MM-DD') <= '$tglakhir1'
		$dt = $this->db->query($sql)->result_array();
		$empty = 0;
		foreach ($dt as $key => $value) {

			$IDL 	= $value['ID_LIST'];
			$minim 	= $value['MIN_STOCK'];
			$sql1 	= "SELECT sum(quantity) DELIV from VMI_DELIVERY where ID_LIST = '$IDL' and STATUS_KEDATANGAN = 0";
			$maxid 	= $this->db->query($sql1)->row();		
			$deliv 	= $maxid->DELIV;
			$ArrGetstock = $this->getstock();
			$idxfind = $this->searchForId($value['KODE_MATERIAL'], $ArrGetstock,'MATERIAL');
			$Arrstock_onhand =  $ArrGetstock[$idxfind];
			$stock_onhand = $Arrstock_onhand['STOCK'];
			$quan_gr=abs($ArrGR[$value['NO_PO'].",".$value['KODE_VENDOR'].",".$value['KODE_MATERIAL']]);
			$quan_gi=abs($ArrGI[$value['KODE_VENDOR'].",".$value['KODE_MATERIAL']]);
			// echo $ArrGI[$value['KODE_VENDOR'].",".$value['KODE_MATERIAL']]."<br>";
			// echo $value['KODE_VENDOR'].",".$value['KODE_MATERIAL'];
			if($stock_onhand <= $minim){
				$color = "red";
			}
			else{
				$color = "";
			}
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
                        "<font color = '$color'>".($stock_onhand==null?$empty:number_format($stock_onhand,0,',','.'))."</font>",
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
        // echo "<pre>";
        echo json_encode($data);
	}

	function getAllConsumption($tglawal,$tglakhir){
			$tampildata1 = array();
			require_once APPPATH.'third_party/sapclasses/sap.php';
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
			$fce->LR_BUDAT->row['LOW']      = $tglawal;
			$fce->LR_BUDAT->row['HIGH']     = $tglakhir;
			$fce->LR_BUDAT->Append($fce->LR_BUDAT->row);

			$fce->LR_BUKRS->row['SIGN']     = 'I';
			$fce->LR_BUKRS->row['OPTION']   = 'EQ';
			$fce->LR_BUKRS->row['LOW']      = '7000';
			$fce->LR_BUKRS->row['HIGH']     = '';
			$fce->LR_BUKRS->Append($fce->LR_BUKRS->row);
			
			$fce->LR_WERKS->row['SIGN']     = 'I';
			$fce->LR_WERKS->row['OPTION']   = 'EQ';
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
			
			$ArrMovementtype = array('101','102','105','106','961','962');
			foreach ($ArrMovementtype as $key => $Movementtype) {
				$fce->LR_BWART->row['SIGN']     = 'I';
				$fce->LR_BWART->row['OPTION']   = 'EQ';
				$fce->LR_BWART->row['LOW']      = $Movementtype;
				$fce->LR_BWART->row['HIGH']     = '';
				$fce->LR_BWART->Append($fce->LR_BWART->row);
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
							"UNIT"=>			$fce->T_DATA->row["MEINS"],
							"Funds_Center"=>			$fce->T_DATA->row["FISTL"],
							"Special_Stock_Indicator"=>			$fce->T_DATA->row["SOBKZ"],
						);
				}
				$fce->Close();
				$ssap->Close();
			}
				// echo "<pre>";
				return $tampildata1;
				// echo "</pre>";
	}

	function searchForId($id, $array,$kolom) {
		   foreach ($array as $key => $val) {
		       if ($val[$kolom] === $id) {
		           return $key;
		       }
		   }
		   return null;
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
					if($stock >= 1)
					{
						$stok_intransit[] = array(
											"MATERIAL"=>$material,
											"PLANT"=>$plant,
											"SLOCS"=>$slocs,
											"VENDOR"=>$vendor,
											"STOCK"=>$stock);
					}
				}
				$fce->Close();
				$ssap->Close();
			}
			return $stok_intransit;
	}
	
	function GRMaterial(){
		$input = $this->input->post();
		if ($input['listreceive']!=""){
			$listgr = json_decode($input['listreceive'],true);
			foreach ($listgr as $key => $value) {
				$sql = "update VMI_DELIVERY set status_kedatangan = 1 ,TANGGAL_DATANG = SYSDATE
						where ID_PENGIRIMAN='{$value['ID_PENGIRIMAN']}' and ID_LIST='{$value['ID_LIST']}'";
				$result = $this->db->query($sql);
				// echo "$sql <br/>";
				$sql2 = "update VMI_MASTER SET STOCK_VMI=NVL(STOCK_VMI,0)+".$value['QTY_RECEIVE']." WHERE ID_LIST='{$value['ID_LIST']}'";
				$result = $this->db->query($sql2);
				// echo "$sql2 <br/>";
			}
		}
	// redirect('VMI/Company/income');
	}
	
//==============================================================================================================================================================================
//=========================================================================== Batas Scheduller =================================================================================
//==============================================================================================================================================================================

	function SchedullerPO(){																	// Cek  --> Update PO List, Update Quantity PO Open
		// echo "hahah";		
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
				// $mins 		= $fce->T_ITEM->row["EISBE"];	// Safety Stock
				$mins 		= $fce->T_ITEM->row["MINBE"];	// Re Order Point
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
				// echo $nilai."->".$matnr." | ".$lifnr." | ".$ebeln." | ".$menge." | ".$werks." | ".$vendor." | ".$material." | ".$start." | ".$end." ==> ".$potype."<br/>";
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
				// echo "<hr/>"; 
			}
		// echo "<pre>";
		// print_r($fce);
		// echo "hahaha";
        $fce->Close();
		}
    }
	
	function SchedullerMail(){																	// Cek  --> Warning Stock Minimal
		$i=1;
		$sql = "SELECT * FROM VMI_MASTER";
        $datadb = $this->db->query($sql)->result_array();
        foreach ($datadb as $key => $value) {
			$kode = $value['KODE_MATERIAL'];
			$min  = $value['MIN_STOCK'];
			$stock= $value['STOCK_AWAL'];
			
			if($stock <= $min)
			{
				// echo $value['KODE_MATERIAL'] ."==>". $value['MIN_STOCK'] ."==". $value['STOCK_AWAL']. "<br/>";
				$sql1 	= "SELECT EMAIL_ADDRESS FROM VND_HEADER where VENDOR_NO = '".$value['KODE_VENDOR']."'";
				$result	= $this->db->query($sql1)->row();		
				$email 	= $result->EMAIL_ADDRESS;
				// echo "$sql1";
				$from 	  = "Tim VMI-Eproc Semen Indonesia";
				$to 	  = "$email";
				$subject  = "Email Notifikasi untuk melakukan Replenishment";
				$bcc 	  = "m.ramzi@sisi.id";
				// $bcc1 	  = "imam.s@sisi.id";
				// $bcc2 	  = "HUSNI.BAHASUAN@SEMENINDONESIA.COM";
				$bcc3 	  = "KASIYAN@SEMENINDONESIA.COM";
				$bcc4 	  = "SETYAWAN.ADI@SEMENINDONESIA.COM";
				$bcc5 	  = "CHOLIQ.SAIFULLAH@SEMENINDONESIA.COM";
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
				$sender	  = $this->send_mail($from,$to,$subject,$cc,$bcc,$bcc1,$bcc2,$bcc3,$bcc4,$bcc5,$message);
				// echo "$from,$to,$subject,$cc,$bcc,$bcc2,$message <br/>";
				// echo "$i. $to <br/> $message <hr/>";
				$i++;
			}
        }	
		
	}

	function send_mail($from,$to,$subject,$cc,$bcc,$bcc1,$bcc2,$bcc3,$bcc4,$bcc5,$message){		// Send --> Warning Stock Minimal
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
		   $this->email->bcc($bcc1);
		   $this->email->bcc($bcc2);
		   $this->email->bcc($bcc3);
		   $this->email->bcc($bcc4);
		   $this->email->bcc($bcc5);
		}

		if(!empty($attachment)){
		  $this->email->attach($attachment);
		}

		$this->email->subject($subject);
		$this->email->message($message);
		return $this->email->send();
	}

	function sendNotif(){																		// Send --> Warning Perubahan Nilai Prognose
		$sql1 		= "SELECT EMAIL, MATERIAL, VENDOR FROM VMI_NOTIF";
		$dt 		= $this->db->query($sql)->result_array();
		// $dt			= $this->db->query($sql1)->row();		
		// $to 		= $result->EMAIL;
		// $material 	= $result->MATERIAL;
		// $vendor		= $result->VENDOR;
		foreach ($dt as $key => $value) {
			$to 		= $value['EMAIL'];
			$material 	= $value['MATERIAL'];
			$vendor 	= $value['VENDOR'];
			$from 	  	= "Tim VMI-Eproc Semen Indonesia";
			$subject  	= "Email Notifikasi untuk melakukan Replenishment";
			// $cc 	  	= "imam.s@sisi.id	";
			$bcc 	  	= "m.ramzi@sisi.id";
			$bcc2 	  = "HUSNI.BAHASUAN@SEMENINDONESIA.COM";
			$bcc3 	  = "KASIYAN@SEMENINDONESIA.COM";
			$bcc4 	  = "SETYAWAN.ADI@SEMENINDONESIA.COM";
			$bcc5 	  = "CHOLIQ.SAIFULLAH@SEMENINDONESIA.COM";
			$message  	= '<html><body><font style = "font-family:"Cambria";size:"12px";">';
			$message 	.= 'Yth. <b>'.$vendor.'</b><br/>';
			$message 	.= 'Mohon melakukan pengecekkan terhadap perubahan nilai prognose pada material '.$material.' : <br/><br/>';
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
			   $this->email->bcc($bcc2);
			   $this->email->bcc($bcc3);
			   $this->email->bcc($bcc4);
			   $this->email->bcc($bcc5);
			}

			if(!empty($attachment)){
			  $this->email->attach($attachment);
			}

			$this->email->subject($subject);
			$this->email->message($message);
			return $this->email->send();
		}
		$sql2 		= "DELETE table VMI_NOTIF";
		$result2	= $this->db->query($sql2)->row();	
	}
	
//==============================================================================================================================================================================
//=========================================================================== Batas Scheduller =================================================================================
//==============================================================================================================================================================================
}

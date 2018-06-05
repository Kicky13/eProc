<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->ci = &get_instance();
		$this->load->library('Layout');
            $this->load->model('model_grafik');
		$this->load->library('Authorization');
		// $this->load->model(array('adm_employee','app_process','adm_company'));
	}

        function echopre($dt){
            echo'<pre>';
             print_r($dt);
            echo'</pre>';
         }
        
	public function index() {
		// redirect(base_url());
		// echo "coba123";
	}

	public function view() {
            // $this->authorization->roleCheck();
            $data['title'] = "Dashboard";
            // $this->load->view('vmi_vendor_list');
            // echo "Masuk View";
            $data['listvendor'] = $this->m_getSelectVendor();
            $data['listmaterial'] = $this->m_getSelectMaterial();
            $this->layout->set_table_js();
            $this->layout->set_table_cs();
            $this->layout->set_datetimepicker();
            $this->layout->add_js('pages/vmi_vendor.js');
            $this->layout->render('vmi_inventory_list',$data);	// GetDataDB
	}
	
	public function detail() {
            // $this->authorization->roleCheck();
            $data['title'] = "Dashboard";
            // $this->load->view('vmi_vendor_list');
            // echo "Masuk View";
            $data['listvendor'] = $this->m_getSelectVendor();
            $data['listmaterial'] = $this->m_getSelectMaterial();
            $this->layout->set_table_js();
            $this->layout->set_table_cs();
            $this->layout->set_datetimepicker();
            $this->layout->add_js('pages/vmi_vendor.js');
            $this->layout->render('vmi_vendor_detail',$data);	// GetDataDB
	}
	
	function grafik()
	{
		$data['title'] = "Grafik";
		$data['list'] = $this->model_grafik->get_list()->result();
		$data['view'] = $this->model_grafik->get_prognose()->result();
		$data['list_gi'] = $this->model_grafik->get_gi()->result();
		// $data['grgi'] = $this->model_grafik->get_gr()->result();
		// $data['deliv'] = $this->model_grafik->get_deliv()->result();
		$this->layout->render('vmi_company_grafik',$data);	// Panggil --> GetDataDB
	}
	
	function delivery() {
		$data['title'] = "Delivery";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_datetimepicker();
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('pages/vmi_deliv.js');
		$this->layout->render('vmi_delivery_list',$data);		// GetDataDBDeliv
	}
	
	function GetDataDBDeliv(){
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
                "
				<a href = ".base_url('VMI/Vendor_pdf/formSPJ/'.$value['KODE_VENDOR'].'/'.$value['KODE_MATERIAL'].'/'.$value['ID_PENGIRIMAN']).">
					<img src = ".base_url('static/images/pdf.png')." width = '25px' height = '25px'>
				</a>
				"
            );
//            id="cbox'.$i.'" onclick="UpdateTglTerima('.$value["ID_LIST"].','.$value["ID_PENGIRIMAN"].',"cbox'.$i.'")"
            $i++;
        }
            $data = array("data"=>$tampildata);
            echo json_encode($data);
    }
	
	public function GetDataDB()
	{
		$idvendor = $this->session->userdata("VENDOR_NO");
		$sql = "select id_list, nama_material, unit, stock_awal, stock_vmi, min_stock, max_stock, KODE_MATERIAL, TO_CHAR(LAST_UPDATED, 'DD-MM-YYYY') LAST_UPDATED, QUANTITY, NO_PO,PO_ITEM, ID_COMPANY, PLANT
				from VMI_MASTER 
				where KODE_VENDOR = '$idvendor'
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
			$matnr 	= $value['KODE_MATERIAL'];
			$idcom 	= $value['ID_COMPANY'];
			$plant 	= $value['PLANT'];
			$nopodb	= $value['NO_PO'];
            $now 	= date("Ymd");
			
            $fce->R_BUDAT->row['SIGN']     = 'I';
            $fce->R_BUDAT->row['OPTION']   = 'BT';
            $fce->R_BUDAT->row['LOW']      = '20170101';
            $fce->R_BUDAT->row['HIGH']     = $now;
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
                while ($fce->T_DATA->Next()) {
					
					$sisaqty= $fce->T_DATA->row["DELIV_QTY"];
					$rsnum = $fce->T_DATA->row["RSNUM"];
					$nopo  = $fce->T_DATA->row["EBELN"];
					$jenis = $fce->T_DATA->row["BWART"];					// Jenis GR(101 / 102) atau GI(961)
					// (961)Barang Issued		(962)Barang Cancel Issued
					// (101)Barang Masuk		(102)Barang Reject
					// if($nopo == $nopodb)									// Karena per list PO untuk GR dan GInya, bukan per materialnya
					// {
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
					// }
                }
				$hitung	 = count($tampildata1);
				if($hitung == 0)
				{
					$quan_gr = 0;
					$quan_gi = 0;
				}
				else
				{
					$quan_gr = array_sum($jum_gr1)-array_sum($jum_gr2);
					$quan_gi = array_sum($jum_gi1)-array_sum($jum_gi2);
				}
				// echo "<pre>";
					// print_r($tampildata1);
				// echo "</pre>";
				// echo "$matnr = $quan_gr dan $quan_gi <hr/>";
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
				$stock_onhand = 0;
				while ($fce->T_STOCK_CONSINYASI->Next()) {
					$stock_onhand = $fce->T_STOCK_CONSINYASI->row["SLABS"];
				}
				$fce->Close();
				$ssap->Close();
			}
			
			$stock_vendor = $value['STOCK_AWAL'];
			if($stock_vendor == 0)
			{
				$button = "<center><span align = 'center' class='label-success label label-danger'>Re - Stock</span></center>";
			}
			else
			{
				$button = "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modal_maintenanceStock' data-idlist='".$value['ID_LIST']."'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span> Add Stock</button>";
			}
			
			$sql1 = "SELECT sum(quantity) DELIV from VMI_DELIVERY where ID_LIST = '".$value['ID_LIST']."' and STATUS_KEDATANGAN = 0";
			$maxid 	= $this->db->query($sql1)->row();		
			$deliv = $maxid->DELIV;
			// $sql2 = "SELECT sum(quantity) VMI from VMI_DELIVERY where ID_LIST = '".$value['ID_LIST']."' and STATUS_KEDATANGAN = 1";
			// $maxid2 = $this->db->query($sql2)->row();		
			// $vmi = $maxid2->VMI;
			
			$tampildata[] = array(
			// $value['ID_PLANT'], 
			$value['NO_PO'], 
			$value['PO_ITEM'], 
			$value['NAMA_MATERIAL'], 
			// $value['KODE_MATERIAL'], 
			($value['UNIT']==null?$empty:$value['UNIT']), 
			// ($value['T_STOCKGRGI']==null?$empty:number_format($value['T_STOCKGRGI'],0,',','.')), 
			// $empty,
			($value['QUANTITY']==null?$empty:number_format($value['QUANTITY'],0,',','.')), 
            ($quan_gr==null?$empty:number_format($quan_gr,0,',','.')),
			($quan_gi==null?$empty:number_format($quan_gi,0,',','.')), 
            ($stock_onhand==null?$empty:number_format($stock_onhand,0,',','.')),
			// ($value['STOCK_VMI']==null?$empty:number_format($value['STOCK_VMI'],0,',','.')), 
			// ($value['T_STOCKDELIV']==null?$empty:number_format($value['T_STOCKDELIV'],0,',','.')), 
			number_format($deliv,0,',','.'),
			"<span title = 'Last Updated on ".$value['LAST_UPDATED']."'>".$value['STOCK_AWAL']."</span>",
			// ($value['STOCK_AWAL']==null?$empty:number_format($value['STOCK_AWAL'],0,',','.')), 
			$value['MIN_STOCK'], 
			$value['MAX_STOCK'], 
			"<center><a href='".base_url('VMI/Vendor/Detail/')."/".$value['ID_LIST']."'><span class='label-success label label-success'>Detail</span></a></center>",
			$button,
			// '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_maintenanceStock" data-idlist="'.$value['ID_LIST'].'"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Stock</button>',
			'<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_maintenanceStock2" data-idlist="'.$value['ID_LIST'].'"><center><span align = "center" class="glyphicon glyphicon-cog" aria-hidden="true"></span> Update Stock</button></center>'
			);
		}
		$data = array("data"=>$tampildata);
		echo json_encode($data);
	}
	
	public function GetDetail()
	{
		$variabel = $this->uri->segment(4);
		// $variabel = 21;
		$sqlread 	= "SELECT KODE_MATERIAL, KODE_VENDOR, ID_COMPANY, PLANT, NAMA_MATERIAL, NO_PO, UNIT, NAMA_VENDOR
						from VMI_MASTER
						where id_list = '$variabel'";
		$kodemat 	= $this->db->query($sqlread)->result_array();
		// $dt = $this->db->query($sql)->result_array();
		$tampildata=array();
		$empty=0;
		// echo "$variabel";
		foreach ($kodemat as $key => $value) {
			
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
			$idcom 	= $value['ID_COMPANY'];
			$plant 	= $value['PLANT'];
			$nopodb	= $value['NO_PO'];
            $now 	= date("Ymd");
			// echo "$matnr $idcom $plant $nopodb $now";
            $fce->R_BUDAT->row['SIGN']     = 'I';
            $fce->R_BUDAT->row['OPTION']   = 'BT';
            $fce->R_BUDAT->row['LOW']      = '20170101';
            $fce->R_BUDAT->row['HIGH']     = $now;
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
                while ($fce->T_DATA->Next()) {
					$sisaqty= $fce->T_DATA->row["DELIV_QTY"];
					$rsnum = $fce->T_DATA->row["RSNUM"];
					$nopo  = $fce->T_DATA->row["EBELN"];
					$jenis1 = $fce->T_DATA->row["BWART"];					// Jenis GR(101 / 102) atau GI(961)
					if($jenis1 == '961')
					{
						$jenis = "Issued";
					}
					elseif($jenis1 == '962')
					{
						$jenis = "Cancel Issued";
					}
					elseif($jenis1 == '101')
					{
						$jenis = "Receipt";
					}
					elseif($jenis1 == '102')
					{
						$jenis = "Cancel Receipt";
					}
					else
					{
						$jenis = "Lho..?";
					}
					// (961)Barang Issued		(962)Barang Cancel Issued
					// (101)Barang Masuk		(102)Barang Reject
					// if($nopo == $nopodb)									// Karena per list PO untuk GR dan GInya, bukan per materialnya
					// {
						if($jenis1 == '961')										// 
						{
							$tampildata1[] = array(
								$value['NO_PO'], 
								$value['NAMA_MATERIAL'], 
								($value['UNIT']==null?$empty:$value['UNIT']), 
								$jenis,
								(int)$fce->T_DATA->row["MENGE"],
							);
						}
						if($jenis1 == '962')										// 
						{
							$tampildata1[] = array(
								$value['NO_PO'], 
								$value['NAMA_MATERIAL'], 
								($value['UNIT']==null?$empty:$value['UNIT']), 
								$jenis,
								(int)$fce->T_DATA->row["MENGE"],
							);
						}
						if($jenis1 == '101')
						{
							$tampildata1[] = array(
								$value['NO_PO'], 
								$value['NAMA_MATERIAL'], 
								($value['UNIT']==null?$empty:$value['UNIT']), 
								$jenis,
								(int)$fce->T_DATA->row["MENGE"],
							);
						}
						if($jenis1 == '102')
						{
							$tampildata1[] = array(
								$value['NO_PO'], 
								$value['NAMA_MATERIAL'], 
								($value['UNIT']==null?$empty:$value['UNIT']), 
								$jenis,
								(int)$fce->T_DATA->row["MENGE"],
							);  
						}
					// }
                }
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
				// echo "<pre>";
					// print_r($tampildata1);
				// echo "</pre>";
				// echo "$matnr = $quan_gr dan $quan_gi <hr/>";
                $fce->Close();
                $sap->Close();
            }
			
			// $tampildata[] = array(
				// $value['NO_PO'], 
				// $value['NAMA_MATERIAL'], 
				// $value['NAMA_VENDOR'], 
				// ($value['UNIT']==null?$empty:$value['UNIT']), 
				// ($value['QUANTITY']==null?$empty:number_format($value['QUANTITY'],0,',','.')), 
				// ($quan_gr==null?$empty:number_format($quan_gr,0,',','.')),
				// ($quan_gi==null?$empty:number_format($quan_gi,0,',','.')), 
                // '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_maintenanceStock" data-idlist="'.$value['NO_PO'].'"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Stock</button>'
			// );
		}
		$data = array("data"=>$tampildata1);
		echo json_encode($data);
	}

	public function list_gi() {
            // $this->authorization->roleCheck();
            $data['title'] = "View";
            // $this->load->view('vmi_vendor_list');
            // echo "Masuk View";
            // $data['listvendor'] = $this->m_getSelectVendor();
            $data['listmaterial'] = $this->m_getSelectMaterial();
            $this->layout->set_table_js();
            $this->layout->set_table_cs();
            $this->layout->set_datetimepicker();
            $this->layout->add_js('pages/vmi_vendor.js');
            $this->layout->render('vmi_gi_list',$data);	// GetDataDB
	}      
    
        public function GetDataDBByVendor($idvendor)
        {
//            $this->db->select('VMI_MASTER.ID_LIST ID_LISTVENDOR,VMI_MASTER.*,VND_HEADER.*,M_VND_SUBMATERIAL.*,VMI_DATA.*');
//            $this->db->from('VMI_MASTER');
//            $this->db->where('ID_VENDOR',$idvendor);  
//            $this->db->join('VMI_DATA','VMI_DATA.ID_LIST=VMI_MASTER.ID_LIST','left')
//                    ->join('M_VND_SUBMATERIAL','M_VND_SUBMATERIAL.SUBMATERIAL_CODE=VMI_MASTER.ID_MATERIAL')
//                    ->join('VND_HEADER','VND_HEADER.VENDOR_ID=VMI_MASTER.ID_VENDOR');
//            $dt = $this->db->get()->result_array();
            $sql = "SELECT
					(SELECT sum(quantity) qty1 from VMI_DELIVERY where VMI_DELIVERY.ID_LIST=VMI_MASTER.ID_LIST and STATUS_KEDATANGAN=1) T_STOCKVMI,
					(SELECT sum(quantity) qty2 from VMI_DELIVERY where VMI_DELIVERY.ID_LIST=VMI_MASTER.ID_LIST and STATUS_KEDATANGAN=0) T_STOCKDELIV,
					VMI_MASTER.ID_LIST ID_LISTVENDOR,
					VMI_MASTER.*, VMI_VENDOR.*, VMI_MATERIAL.*
					FROM
					VMI_MASTER
					JOIN VMI_MATERIAL ON VMI_MATERIAL.KODE_MATERIAL = VMI_MASTER.KODE_MATERIAL
					JOIN VMI_VENDOR ON VMI_VENDOR.ID_VENDOR = VMI_MASTER.KODE_VENDOR
					where VMI_MASTER.KODE_VENDOR='".$idvendor."'";
            $dt = $this->db->query($sql)->result_array();
            $tampildata=array();
            $empty="NONE";
            
            foreach ($dt as $key => $value) {
                $tampildata[] = array(
                // $value['ID_PLANT'], 
                $value['DESCRIPTION'], 
                ($value['UNIT']==null?$empty:$value['UNIT']), 
                ($value['T_STOCKGRGI']==null?$empty:number_format($value['T_STOCKGRGI'],0,',','.')), 
                ($value['STOCK_VMI']==null?$empty:number_format($value['STOCK_VMI'],0,',','.')), 
                ($value['T_STOCKDELIV']==null?$empty:number_format($value['T_STOCKDELIV'],0,',','.')), 
                ($value['STOCK_AWAL']==null?$empty:number_format($value['STOCK_AWAL'],0,',','.')), 
                $value['MIN_STOCK'], 
                $value['MAX_STOCK'], 
                '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_maintenanceStock" data-idlist="'.$value['ID_LISTVENDOR'].'"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Stock</button>',
                '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_maintenanceStock2" data-idlist="'.$value['ID_LISTVENDOR'].'"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Update Stock</button>'
                );
            }
            $data = array("data"=>$tampildata);
            echo json_encode($data);
        }
        
        public function getDataByIdVendor()
        {
            $idlist = $this->input->post('idlist');
            $sql = "SELECT
						VMI_MASTER.ID_COMPANY,
						VMI_MASTER.NAMA_VENDOR,
						VMI_MASTER.PLANT,
						VMI_MASTER.NO_PO,
						VMI_MASTER.STOCK_AWAL,
						VMI_MASTER.KODE_MATERIAL,
						VMI_MASTER.KODE_VENDOR,
						ADM_COMPANY.COMPANYNAME,
						ADM_PLANT.PLANT_NAME,
						VMI_MASTER.NAMA_MATERIAL
					FROM
						VMI_MASTER
					JOIN ADM_COMPANY ON ADM_COMPANY.COMPANYID = VMI_MASTER.ID_COMPANY
					JOIN ADM_PLANT ON ADM_PLANT.PLANT_CODE = VMI_MASTER.PLANT
					WHERE
						VMI_MASTER.ID_LIST = '".$idlist."'";
            $result = $this->db->query($sql)->row();
            echo json_encode($result);
        }
        
        public function InsertStock(){
            $input = $this->input->post(null,true);
            $stock = (int) $input['Nstock'];
            $quant = (int) $input['Nquantity'];
            $idm = $input['NkodeMaterial'];
            $idv = $input['idVendor'];
			if($quant > $stock){
				echo "<script>
						alert (\"Stock Kurang\");
						location.href=\"javascript:history.go(-1)\";
					</script>
					";
			}
			else{
				$sql = "select LEAD_TIME from VMI_MASTER where ID_LIST='".$input['Nid_list']."'";
				$data = $this->db->query($sql)->row();
				$lead_time = $data->LEAD_TIME;
				$tglkirim = "TO_DATE('".date_format(date_create($input['NTanggalKirim']), "Y-m-d")."','YYYY-MM-DD')";
				$sql = "INSERT INTO VMI_DELIVERY(ID_PENGIRIMAN, ID_LIST, QUANTITY, TANGGAL_KIRIM, STATUS_KEDATANGAN, NO_PO, KODE_MATERIAL, KODE_VENDOR)"
						. "VALUES ((select nvl(max(ID_PENGIRIMAN),0)+1 from VMI_DELIVERY), '".$input['Nid_list']."', '".$input['Nquantity']."',".$tglkirim.",'0', '".$input['Npo']."', '".$input['NkodeMaterial']."', '".$idv."')";
				$insert = $this->db->query($sql);		   
				$sql2 = "update VMI_MASTER SET STOCK_AWAL=NVL(STOCK_AWAL,0)-".$input['Nquantity']."  WHERE KODE_MATERIAL='".$idm."' and KODE_VENDOR='".$idv."'";
				$result = $this->db->query($sql2);
				// echo "$sql2 dan $result";
				if($insert && $result){
					redirect('VMI/Vendor/view');
				}else{
					redirect();
				}
			}
        }
        
        public function m_getSelectVendor(){
            $this->db->select('VMI_MASTER.KODE_VENDOR,VMI_VENDOR.VENDOR_NAME');
            $this->db->from('VMI_MASTER');
            $this->db->join('VMI_MATERIAL','VMI_MATERIAL.KODE_MATERIAL=VMI_MASTER.KODE_MATERIAL')
                    ->join('VMI_VENDOR','VMI_VENDOR.ID_VENDOR=VMI_MASTER.KODE_VENDOR')
                    ->distinct();
            $dt = $this->db->get()->result();
            return $dt;
        }
		
		public function  m_getSelectMaterial(){
			 $sql="select * from VMI_MATERIAL";
			 $data = $this->db->query($sql)->result();
			 return $data;
		 }
		
		public function UpdateStockPusat()
		{
			$idlist 	= $this->input->post('Nid_list');
			$qty 		= $this->input->post('Nquantity');
			$idv 		= $this->input->post('idVendor2');
			$idm 		= $this->input->post('idMaterial2');
			$now 		= date("Y-m-d");
			$sql 		= "UPDATE VMI_MASTER set STOCK_AWAL = STOCK_AWAL+$qty, LAST_UPDATED = TO_DATE('".date_format(date_create($now),'Y-m-d')."','YYYY-MM-DD') 
							where KODE_VENDOR='{$idv}' and KODE_MATERIAL='{$idm}'";
			$result 	= $this->db->query($sql);
			// echo $result;
            redirect('VMI/Vendor/view');
		}

//	public function GetDataRfc()
//       {
//        require_once APPPATH.'third_party/sapclasses/sap.php';
//        $sap = new SAPConnection();
//        $sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
//        
//        if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
//        if ($sap->GetStatus() != SAPRFC_OK ) {
//            echo $sap->PrintStatus();
//            exit;
//        }
//        $fce = &$sap->NewFunction ("ZCMM_MASTER_MATERIAL");
//                
//        if ($fce == false) {
//            $sap->PrintStatus();
//            exit;
//        }
//        
//        // $fce->R_AEDAT->row['SIGN']   = 'I';
//        // $fce->R_AEDAT->row['OPTION'] = 'EQ';
//        // $fce->R_AEDAT->row['LOW']    = $tgl;
//        // $fce->R_AEDAT->row['HIGH']    = '20170314';
//
//        $fce->call();
//
//        echo $fce;
//
//        if ($fce->GetStatus() == SAPRFC_OK) {
//            $fce->T_STOCK_CONSINYASI->Reset();
//
//            $data=array();
//
//            $i=0;
//            $tampildata=array();
//            while ($fce->T_STOCK_CONSINYASI->Next()) {
//                // $data[] = ($fce->T_STOCK_CONSINYASI->row);
//                // echopre($data);
//                // $list_po[$i]["MATNR"] = $fce->T_STOCK_CONSINYASI->row["MATNR"];
//                // $list_po[$i]["MAKTX"] = $fce->T_STOCK_CONSINYASI->row["MAKTX"];
//                // $list_po[$i]["WERKS"] = $fce->T_STOCK_CONSINYASI->row["WERKS"];
//                // $list_po[$i]["LGORT"] = $fce->T_STOCK_CONSINYASI->row["LGORT"];
//                // $list_po[$i]["LIFNR"] = $fce->T_STOCK_CONSINYASI->row["LIFNR"];
//                // $list_po[$i]["NAME1"] = $fce->T_STOCK_CONSINYASI->row["NAME1"];
//                // $list_po[$i]["SLABS"] = $fce->T_STOCK_CONSINYASI->row["SLABS"];
//                // $list_po[$i]["MEINS"] = $fce->T_STOCK_CONSINYASI->row["MEINS"];
//                // $list_po[$i]["EISBE"] = $fce->T_STOCK_CONSINYASI->row["EISBE"];
//                // $list_po[$i]["MABST"] = $fce->T_STOCK_CONSINYASI->row["MABST"];
//                // $list_po[$i]["MINBE"] = $fce->T_STOCK_CONSINYASI->row["MINBE"];
//
//                if ($fce->T_STOCK_CONSINYASI->row["LIFNR"]=="1200000"){
//                	$tampildata[] = array(
//                					$fce->T_STOCK_CONSINYASI->row["WERKS"],
//                					$fce->T_STOCK_CONSINYASI->row["MAKTX"],
//                					"NONE",
//                					$fce->T_STOCK_CONSINYASI->row["MEINS"],
//                					"NONE",
//                					(int)$fce->T_STOCK_CONSINYASI->row["EISBE"],
//                					(int)$fce->T_STOCK_CONSINYASI->row["MABST"],
//                					"Add Stock");
//                }
//                $i++;
//            }
//
//            $fce->Close();
//            $sap->Close();
//            // echo '<pre>';
//            //     print_r($list_po);
//            // echo '<pre>';
//            // echopre($list_po);
//            $data = array("data"=>$tampildata);
//            echo json_encode($data);
//        }
//    }

}
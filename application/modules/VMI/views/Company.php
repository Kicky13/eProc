<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->ci = &get_instance();
		$this->load->library('Layout');
		// $this->load->library('Authorization');
		 $this->load->model('model_grafik');
	}

    function echopre($dt){
        echo'<pre>';
            print_r($dt);
        echo'</pre>';
    }

	public function index() {
	}
        
        public function SavePerencanaan(){
            $input = $this->input->post(null,true);
            $sqlread = "select * from VMI_MASTER
                        where ID_MATERIAL='".$input['NselectMaterial']."' and ROWNUM=1";
            $dataidlist = $this->db->query($sqlread)->row_array();
            $sql = "INSERT INTO VMI_GR_GI 
                    (ID_GR, ID_LIST, QUANTITY, TANGGAL_AWAL, TANGGAL_AKHIR, STATUS_APPROVE) 
                    VALUES (
					(SELECT nvl(max(ID_GR)+1,1) ID_GR from VMI_GR_GI),
					'".$dataidlist['ID_LIST']."', 
					'{$input['quantity']}',
					TO_DATE('".date_format(date_create($input['ptglawal']),'Y-m-d')."','YYYY-MM-DD'),
					TO_DATE('".date_format(date_create($input['ptglakhir']),'Y-m-d')."','YYYY-MM-DD'),
					'0')";
             $this->db->query($sql);  
             redirect('VMI/Company/View');
        }
		
	function grafik()
	{
		/* // $data['judul'] = "Tampilan Awal";
		$data['report'] = $this->model_grafik->get_list()->result();
        // $this->load->view('perpus/form',$data);		
        $this->load->view('report',$data); */
		
		// $this->authorization->roleCheck();
		$data['title'] = "View";
		$data['grgi'] = $this->model_grafik->get_gr()->result();		
		$data['deliv'] = $this->model_grafik->get_deliv()->result();		
		
		// $this->load->view('vmi_vendor_list');
		// echo "Masuk View";
		// $data['listplantAll'] = $this->m_getSelectAllPlant();
		// $data['listplant'] = $this->GetSelectPlant();
		// $data['listcompany'] = $this->m_getSelectCompany();
		// $data['listmaterial'] = $this->m_getSelectMaterial();
		// $data['listvendor'] = $this->m_getSelectVendor();
		// $data['listpplant'] = $this->getVMIPlant();
		// $this->layout->set_table_js();
		// $this->layout->set_table_cs();
		// $this->layout->set_datetimepicker();
        // $this->layout->add_js('plugins/select2/select2.js');
		// $this->layout->add_css('plugins/select2/select2.css');
		// $this->layout->add_css('plugins/select2/select2-bootstrap.css');
		// $this->layout->add_js('pages/vmi_all.js');
		$this->layout->render('vmi_company_grafik',$data);	// Panggil RFC --> GetDataDB
	}
	
		
	
	public function view() {
		// $this->authorization->roleCheck();
		$data['title'] = "View";
		// $data['report'] = $this->model_grafik->get_list()->result();		
		
		// $this->load->view('vmi_vendor_list');
		// echo "Masuk View";
		$data['listplantAll'] = $this->m_getSelectAllPlant();
		$data['listplant'] = $this->GetSelectPlant();
		$data['listcompany'] = $this->m_getSelectCompany();
		$data['listmaterial'] = $this->m_getSelectMaterial();
		$data['listvendor'] = $this->m_getSelectVendor();
                $data['listpplant'] = $this->getVMIPlant();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_datetimepicker();
                $this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('pages/vmi_all.js');
		$this->layout->render('vmi_company_list',$data);	// Panggil RFC --> GetDataDB
	}
	
	public function income() {
		// $this->authorization->roleCheck();
		$data['title'] = "View";
		
		// $this->load->view('vmi_vendor_list');
		// echo "Masuk View";
                
//		$data['listplantAll'] 	= $this->m_getSelectAllPlant();
//		$data['listplant'] 		= $this->GetSelectPlant();
//		$data['listcompany'] 	= $this->m_getSelectCompany();
//		$data['listmaterial'] 	= $this->m_getSelectMaterial();
//		$data['listvendor'] 	= $this->m_getSelectVendor();
//                $data['listpplant'] 	= $this->getVMIPlant();
		
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_datetimepicker();
                $this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('pages/vmi_income.js');
		$this->layout->render('vmi_income_list',$data);
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

    public function GetDataDBIncome()
    {
        $empty = "0";
        $sql = "select VMI_DELIVERY.*,VMI_MASTER.LEAD_TIME,VND_HEADER.VENDOR_NAME,
M_VND_SUBMATERIAL.SUBMATERIAL_NAME,ADM_PLANT.PLANT_NAME, 
TO_CHAR(VMI_DELIVERY.TANGGAL_KIRIM+VMI_MASTER.LEAD_TIME,'DD-MM-YYYY') as DT_EST_COME, TO_CHAR(VMI_DELIVERY.TANGGAL_KIRIM,'DD-MM-YYYY') TANGGAL_KIRIM2
                from VMI_DELIVERY
                join VMI_MASTER on VMI_MASTER.ID_LIST=VMI_DELIVERY.ID_LIST
                join VND_HEADER on VND_HEADER.VENDOR_ID=VMI_MASTER.ID_VENDOR
                join ADM_PLANT on  ADM_PLANT.PLANT_CODE = VMI_MASTER.ID_PLANT
                join M_VND_SUBMATERIAL on M_VND_SUBMATERIAL.SUBMATERIAL_CODE=VMI_MASTER.ID_MATERIAL
                where VMI_DELIVERY.STATUS_KEDATANGAN=0
                ";
        $datadb = $this->db->query($sql)->result_array();
        $tampildata = array(); 
        foreach ($datadb as $key => $value) {
            $tampildata[] = array(
                $value['PLANT_NAME'], 
                $value['VENDOR_NAME'], 
                $value['SUBMATERIAL_NAME'], 
                ($value['QUANTITY']==null?$empty:number_format($value['QUANTITY'],0,',','.')), 
                $value['TANGGAL_KIRIM2'], 
                ($value['TANGGAL_DATANG']==null?$value['DT_EST_COME']:$value['TANGGAL_DATANG']), 
                $value['LEAD_TIME'],
                '<div class="checkbox">
                <label>
                  <input type="checkbox" onclick="UpdateTglTerima('.$value["ID_LIST"].','.$value["ID_PENGIRIMAN"].')">
                </label>
                </div>'
            );
        }
            $data = array("data"=>$tampildata);
            echo json_encode($data);
    }

    public function  addNewVMI(){
         $data = $this->input->post();
         $tgl1 = date_format(date_create($data['NActiveContract']), 'Y-m-d');
         $tgl2 = date_format(date_create($data['NEndContract']), 'Y-m-d');
         $sql = "INSERT INTO VMI_MASTER(ID_LIST, ID_MATERIAL, ID_VENDOR, ID_COMPANY, ID_PLANT, NO_PO, CONTRACT_ACTIVE, CONTRACT_END, TYPE_VENDOR, MIN_STOCK, MAX_STOCK, LEAD_TIME, STOCK_AWAL) "
                . "VALUES ((select nvl(max(ID_LIST)+1,0) from VMI_MASTER), "
                . "'".$data['NselectMaterial']."', "
                        . "'".$data['NselectVendor']."', "
                        . "'".$data['NselectCompany']."', "
                        . "'".$data['NselectPlant']."',"
                        . "'".$data['NNOPO']."', "
                        . "to_date('".$tgl1."','YYYY-MM-DD'), "
                        . "to_date('".$tgl2."','YYYY-MM-DD'), "
                        . "'".$data['NselectType']."',"
                        . "'".$data['Nmin']."',"
                        . "'".$data['Nmax']."',"
                        . "'".$data['NLeadTime']."',"
                        . "'".$data['Nstock']."')";
      $a =  $this->db->query($sql);
	if ($a){
            redirect('VMI/Company/View');
        }else{
//            echo "Transkasi Gagal" ;
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
         $sql="select vendor_id,vendor_name from VND_HEADER";
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

        echo $fce;

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
    
    public function GetDataDB()
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
                            VMI_MASTER.*, VND_HEADER.*, M_VND_SUBMATERIAL.*
                    FROM
                            VMI_MASTER
                    JOIN M_VND_SUBMATERIAL ON M_VND_SUBMATERIAL.SUBMATERIAL_CODE = VMI_MASTER.ID_MATERIAL
                    JOIN VND_HEADER ON VND_HEADER.VENDOR_ID = VMI_MASTER.ID_VENDOR";
        $datadb = $this->db->query($sql)->result_array();
        
        foreach ($datadb as $key => $value) {
			$IDL = $value['ID_LIST'];
            $tampildata[] = array(
                        $value['ID_PLANT'], 
                        $value['VENDOR_NAME'], 
                        $value['SUBMATERIAL_NAME'], 
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
    
    public function getVMIMaterial(){
        $idplant = $this->input->post('ID_PLANT');
        $datadb = $this->db->from('VMI_MASTER')
                    ->select('VMI_MASTER.ID_MATERIAL ID_MATERIAL,M_VND_SUBMATERIAL.SUBMATERIAL_NAME SUBMATERIAL_NAME')
                    ->join('M_VND_SUBMATERIAL','M_VND_SUBMATERIAL.SUBMATERIAL_CODE=VMI_MASTER.ID_MATERIAL')
                    ->join('VMI_DATA','VMI_DATA.ID_LIST=VMI_MASTER.ID_LIST','left')
                    ->join('VND_HEADER','VND_HEADER.VENDOR_ID=VMI_MASTER.ID_VENDOR')
                    ->where('VMI_MASTER.ID_PLANT',$idplant)
                    ->get()
                   ->result();
        echo json_encode($datadb);
    }
    
    public function getVMIPlant(){
        $datadb = $this->db->from('VMI_MASTER')
                    ->select('VMI_MASTER.ID_PLANT ID_PLANT,ADM_PLANT.PLANT_NAME PLANT_NAME')
                    ->join('M_VND_SUBMATERIAL','M_VND_SUBMATERIAL.SUBMATERIAL_CODE=VMI_MASTER.ID_MATERIAL')
                    ->join('VMI_DATA','VMI_DATA.ID_LIST=VMI_MASTER.ID_LIST','left')
                    ->join('VND_HEADER','VND_HEADER.VENDOR_ID=VMI_MASTER.ID_VENDOR')
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
        $sql = "select VMI_GR_GI.*, VND_HEADER.VENDOR_NAME, ADM_PLANT.PLANT_NAME, M_VND_SUBMATERIAL.SUBMATERIAL_NAME 
from VMI_GR_GI
		join VMI_MASTER on VMI_MASTER.ID_LIST=VMI_GR_GI.ID_LIST
		join VND_HEADER on VND_HEADER.VENDOR_ID=VMI_MASTER.ID_VENDOR
		join ADM_PLANT on  ADM_PLANT.PLANT_CODE = VMI_MASTER.ID_PLANT
		join M_VND_SUBMATERIAL on M_VND_SUBMATERIAL.SUBMATERIAL_CODE=VMI_MASTER.ID_MATERIAL
		where VMI_GR_GI.STATUS_APPROVE=0
                ";
        $datadb = $this->db->query($sql)->result_array();
        $tampildata = array(); 
        foreach ($datadb as $key => $value) {
            $tampildata[] = array(
                $value['PLANT_NAME'], 
                $value['VENDOR_NAME'], 
                $value['SUBMATERIAL_NAME'], 
                ($value['QUANTITY']==null?$empty:number_format($value['QUANTITY'],0,',','.')), 
                $value['TANGGAL_AWAL'], 
                '<div class="checkbox">
                <label>
                  <input type="checkbox" onclick="UpdateTglApproveGR('.$value["ID_LIST"].','.$value["ID_GR"].')">
                </label>
                </div>'
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

}
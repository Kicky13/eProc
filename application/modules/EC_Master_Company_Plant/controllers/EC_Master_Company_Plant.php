<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Master_Company_Plant extends CI_Controller
{

    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->user = $this->session->userdata('FULLNAME');
    }

    public function index($brhasil = false)
    {
        $data['title'] = "Master Akses Company Plant";
        // $data['brhasil'] = $brhasil;
//        $data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');

        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/EC_master_complant.js');

        $this->load->model('ec_company_plant');
        $data['company'] = $this->ec_company_plant->getCompany();

        $this->layout->render('list', $data);
    }

    public function getPlant($value = '')
    {
        $this->load->model('ec_company_plant');
        $result = $this->ec_company_plant->getPlant($value);
        echo json_encode(array('data' => $result));
    }

    public function syncPlant($value = '')
    {
        $this->load->library('sap_handler'); 
        $data=($this->sap_handler->getECPlant(false));
        $this->load->model('ec_company_plant');
        // var_dump($data);
        $dataAll = array();
        foreach ($data as $datum) {
            // $this->ec_company_plant->syncPlant(array('PLANT'=>$datum['WERKS'],'PLANT_NAME'=>$datum['NAME1']));
//            if($datum['WERKS']==='2901'){
//                $dataAll[] = array('PLANT'=>$datum['WERKS'],'PLANT_NAME'=>'Pengambilan Langsung');
//            }else if($datum['WERKS']==='2701'){
//                $dataAll[] = array('PLANT'=>$datum['WERKS'],'PLANT_NAME'=>'Kantor Gresik');
//            }else if($datum['WERKS']==='2702'){
//                $dataAll[] = array('PLANT'=>$datum['WERKS'],'PLANT_NAME'=>'Kantor Tuban');
//            }else if($datum['WERKS']==='7701'){
//                $dataAll[] = array('PLANT'=>$datum['WERKS'],'PLANT_NAME'=>'Kantor Gresik');
//            }else if($datum['WERKS']==='7702'){
//                $dataAll[] = array('PLANT'=>$datum['WERKS'],'PLANT_NAME'=>'Kantor Tuban');
//            }else{
//                $dataAll[] = array('PLANT'=>$datum['WERKS'],'PLANT_NAME'=>$datum['NAME1']); 
//            }            
            $dataAll[] = array('PLANT'=>$datum['WERKS'],'PLANT_NAME'=>$datum['NAME1']);
        }
//         var_dump($dataAll); die();
        $this->ec_company_plant->syncPlant($dataAll);
        // print_r($data);
    }

    public function InsertPlant($value = '')
    {
        $this->load->model('ec_company_plant');
        $PLANT = $this->input->post('plant');
        $COMAPANY = $this->input->post('company');
        $mode = $this->input->post('mode');
        $this->ec_company_plant->insertPlant(array('PLANT'=>$PLANT, 'COMPANY'=>$COMAPANY, 'SELECTED' => 1), $mode);
    }

    public function tesgetPORelease($cheat = false)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
        $result = $this->ec_shipment_m->getPORelease($this->session->userdata['VENDOR_NO']);
        var_dump(count($result));
        //echo json_encode(array('data' => $this->ec_shipment_m->getPORelease($this->session->userdata['VENDOR_NO'])));
    }

    public function getPOReport($cheat = false)
    {
        $dataAll = array();
        header('Content-Type: application/json');
        $this->load->model('ec_reporting');
        $data1 = $this->ec_reporting->getPOReport();

        for ($j = 0; $j < sizeof($data1); $j++) {
            $qty = $this->ec_reporting->getQtyIntransit($data1[$j]['ID_CHART']);

            $dataAll[$j]["GR_ID"] = $data1[$j]["GR_ID"];
            $dataAll[$j]["PO_NO"] = $data1[$j]["PO_NO"];
            $dataAll[$j]["MATNO"] = $data1[$j]["MATNO"];
            $dataAll[$j]["LINE_ITEM"] = $data1[$j]["LINE_ITEM"];
            $dataAll[$j]["QTY_ORDER"] = $data1[$j]["QTY_ORDER"];
            $dataAll[$j]["QTY_SHIPMENT"] = $data1[$j]["QTY_SHIPMENT"];
            $dataAll[$j]["QTY_INTRANSIT"] = ($qty["QTY_INTRANSIT"]==null?'0':$qty["QTY_INTRANSIT"]);
            $dataAll[$j]["STATUS"] = $data1[$j]["STATUS"];
            $dataAll[$j]["ID_CHART"] = $data1[$j]["ID_CHART"];
            $dataAll[$j]["MAKTX"] = $data1[$j]["MAKTX"];
            $dataAll[$j]["MEINS"] = $data1[$j]["MEINS"];
            $dataAll[$j]["PLANT"] = $data1[$j]["PLANT"];
            $dataAll[$j]["PRICE"] = $data1[$j]["PRICE"];
            $dataAll[$j]["DELIVERY_TIME"] = $data1[$j]["DELIVERY_TIME"];
            $dataAll[$j]["CURRENCY"] = $data1[$j]["CURRENCY"];
            $dataAll[$j]["EXPIRED_DATE"] = $data1[$j]["EXPIRED_DATE"];
            $dataAll[$j]["DOC_DATE"] = $data1[$j]["DOC_DATE"];
            $dataAll[$j]["PLANT_NAME"] = $data1[$j]["PLANT_NAME"];
            $dataAll[$j]["VALUE_ITEM"] = $data1[$j]["VALUE_ITEM"];
            $dataAll[$j]["VENDOR_NAME"] = $data1[$j]["VENDOR_NAME"];
        }
        echo json_encode(array('data' => $dataAll));
        // echo json_encode(array('data' => $this->ec_reporting->getPOReport()));
    }

    public function getPOorder($cheat = false)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
        echo json_encode(array('data' => $this->ec_shipment_m->getPOorder($this->session->userdata['VENDOR_NO'])));
    }

    public function getPODetail($po)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
        echo json_encode($this->ec_shipment_m->getPODetail($po));
    }

    public function detailHistory($po)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
        echo json_encode($this->ec_shipment_m->detailHistory($po));
    }

    public function detailIntransit()
    {
        header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
        echo json_encode(array('data' => $this->ec_shipment_m->detailIntransit()));
        // echo json_encode($this->ec_shipment_m->detailIntransit());
    }

    public function send($kode_shipment)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
        $this->ec_shipment_m->updateStatus($kode_shipment);
        //echo json_encode(array('data' => $this->ec_shipment_m->getPORelease($this->session->userdata['VENDOR_NO'])));;
        redirect('EC_Shipment/index/');
    }
	
	public function simpan_shipment()
    {
        //header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
		$qtyShipment=$this->input->post('qtyShipment');
		$tglShipment=$this->input->post('tglShipment');
		$kodeShipment=$this->input->post('kodeShipment');
		
        $this->ec_shipment_m->updateStatus_qty($qtyShipment,$tglShipment,$kodeShipment);
        //echo json_encode(array('data' => $this->ec_shipment_m->getPORelease($this->session->userdata['VENDOR_NO'])));;
       // redirect('EC_Shipment/index/');
    }
	
    public function cekQty($kode_shipment)
    {
        //header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
        // $qtyShipment=$this->input->post('qtyShipment');
        // $tglShipment=$this->input->post('tglShipment');
        // $kodeShipment=$this->input->post('kodeShipment');
        
        echo json_encode($this->ec_shipment_m->cekQty($kode_shipment));
        //return $this->ec_shipment_m->cekQty($kode_shipment);
        //echo json_encode(array('data' => $this->ec_shipment_m->getPORelease($this->session->userdata['VENDOR_NO'])));;
       // redirect('EC_Shipment/index/');
    }

    //public function approve($PO = '4500000452')
    public function approve($PO)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_po_pl_approval_m');
        $data2=0;
        if ($this->ec_po_pl_approval_m->approve($PO)) {
            $this->load->library('sap_handler');
            $data = $this->ec_po_pl_approval_m->detailCart($PO);
            $data2 = $this->sap_handler->PO_CHANGE($PO, $data, false);
            //var_dump($data);
            if($data2==1){
                $this->ec_po_pl_approval_m->insertToShipment($data, $PO);
            }
            redirect('EC_PO_PL_Approval/index/'.$data2.'/'.$PO);
        }
        redirect('EC_PO_PL_Approval/index/'.$data2);
    }

    public function approveTes($PO = '4500000496')
    {
//        header('Content-Type: application/json');
        $this->load->model('ec_po_pl_approval_m');
//        if (!$this->ec_po_pl_approval_m->approve($PO)) {
        $this->load->library('sap_handler');
        $data = $this->ec_po_pl_approval_m->detailCart($PO);
//        $data2 = $this->sap_handler->PO_CHANGE($PO, $data,true);
//        echo json_encode($data);
//        echo json_encode($data2);
//        }
//        redirect('EC_PO_PL_Approval');
    }

    public function reject($PO = '4500000452')
    {
        $data2=0;
//        header('Content-Type: application/json');
        $this->load->model('ec_po_pl_approval_m');
        $this->ec_po_pl_approval_m->reject($PO);
        $this->load->library('sap_handler');
        $data = $this->ec_po_pl_approval_m->detailCart($PO);
        $data2 = $this->sap_handler->PO_CHANGE_REJECT($PO, $data, false);
//        var_dump($data2);
        redirect('EC_PO_PL_Approval/index/'.$data2.'/'.$PO);
    }

    public function detail($kdshipment = '4500000452')
    {
        header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
        echo json_encode($this->ec_shipment_m->detail($kdshipment));
    }

    public function history($PO = '4500000452')
    {
        header('Content-Type: application/json');
        $this->load->model('ec_po_pl_approval_m');
        echo json_encode($this->ec_po_pl_approval_m->history($PO));
    }

    public function save()
    {
    	header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
    	$itms = json_decode($this->input->post('dataall'));
    	$noShip = ($this->input->post('nomor'));
        $tglShipment = ($this->input->post('tanggal'));
        
        for ($i=0; $i < sizeof($itms); $i++) { 
        	$tes = explode("_", $itms[$i]);
        	$tes = $this->ec_shipment_m->insertDetailShipment($noShip, $tglShipment, $tes[3], $tes[4], $tes[2]);
        }

        if($tes>0){
        	echo json_encode(array('sukses' => '1', 'nomor' => $noShip));
        }
        //var_dump('tesss: '.$tes);
        // echo "<script>window.location.href = 'EC_Shipment/index/".$sukses."/".$noShip."</script>";

//        echo '<script>window.location.href = $("#base-url").val() + 'EC_Shipment/index/'+$sukses</script>';
       // redirect('EC_Shipment/index/'.$sukses.'/'.$noShip);
    	//var_dump($tes);
    }

    public function deleteShipment()
    {
    	header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
    	$itms = json_decode($this->input->post('dataship'));

        for ($i=0; $i < sizeof($itms); $i++) { 
        	$this->ec_shipment_m->deleteShipment($itms[$i]);
        }

        
    	//var_dump($tes);
    }
}
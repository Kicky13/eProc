<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Report_Penawaran extends CI_Controller
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
        $data['title'] = "Report Penawaran Harga Vendor";
        // $data['brhasil'] = $brhasil;
//        $data['cheat'] = $cheat;
        $this->load->model('ec_report_pen_harga');
        $result = $this->ec_report_pen_harga->getMaterial();
        $data['material'] = $result;

        $plant = $this->ec_report_pen_harga->getPlant();
        $data['plant'] = $plant;  


        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_js('plugins/select2/select2.js');
        $this->layout->add_css('plugins/select2/select2.css');
        $this->layout->add_css('plugins/select2/select2-bootstrap.css');
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/EC_report_penharga.js');

        $this->layout->render('list', $data);
    }

    public function tesgetPORelease($cheat = false)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
        $result = $this->ec_shipment_m->getPORelease($this->session->userdata['VENDOR_NO']);
        var_dump(count($result));
        //echo json_encode(array('data' => $this->ec_shipment_m->getPORelease($this->session->userdata['VENDOR_NO'])));
    }

    public function getReport($cheat = false)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_report_pen_harga');
        // $matno=$this->input->post('matno');
        // $plant=$this->input->post('plant');
        $priority = array();
        $data1 = $this->ec_report_pen_harga->getPenawaran();
        // var_dump($data1);
        $matno = '';
        $plant = '';
        $row = 1;

        /*for ($i = 0; $i < sizeof($data1); $i++) {
        	if($matno==$data1[$i]['MATNO'] && $plant==$data1[$i]['PLANT']){
        		$row = $row+1;
        		$priority[] = $row;
        	}else{
        		$row = 1;
        		$matno = $data1[$i]['MATNO'];
        		$plant = $data1[$i]['PLANT'];
        		$priority[] = $row;
        	}
        }*/

        for ($j = 0; $j < sizeof($data1); $j++) {
        	if($matno==$data1[$j]['MATNO'] && $plant==$data1[$j]['PLANT']){
        		$row = $row+1;
        		$dataAll[$j]["PRIORITY"] = $row;
        	}else{
        		$row = 1;
        		$matno = $data1[$j]['MATNO'];
        		$plant = $data1[$j]['PLANT'];
        		$dataAll[$j]["PRIORITY"] = $row;
        	}
        	$dataAll[$j]["MATNO"] = $data1[$j]["MATNO"];
        	$dataAll[$j]["MAKTX"] = $data1[$j]["MAKTX"];
        	$dataAll[$j]["MEINS"] = $data1[$j]["MEINS"];
        	$dataAll[$j]["MATKL"] = $data1[$j]["MATKL"];
        	$dataAll[$j]["STOK"] = $data1[$j]["STOK"];
        	$dataAll[$j]["VENDORNO"] = $data1[$j]["VENDORNO"];
        	$dataAll[$j]["PLANT"] = $data1[$j]["PLANT"];
        	$dataAll[$j]["NAMA_PLANT"] = $data1[$j]["NAMA_PLANT"];
        	$dataAll[$j]["KODE_DETAIL_PENAWARAN"] = $data1[$j]["KODE_DETAIL_PENAWARAN"];
        	$dataAll[$j]["DELIVERY_TIME"] = $data1[$j]["DELIVERY_TIME"];
        	$dataAll[$j]["INDATE"] = $data1[$j]["INDATE"];
        	$dataAll[$j]["PRICE"] = $data1[$j]["PRICE"];
        	$dataAll[$j]["CURRENCY"] = $data1[$j]["CURRENCY"];
        	$dataAll[$j]["VENDOR_NAME"] = $data1[$j]["VENDOR_NAME"];
        	$dataAll[$j]["LAST_UPDATE"] = $data1[$j]["LAST_UPDATE"];
        	// $dataAll[$j]["PRIORITY"] = $priority[$j];
        }
        echo json_encode(array('data' => $dataAll));
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
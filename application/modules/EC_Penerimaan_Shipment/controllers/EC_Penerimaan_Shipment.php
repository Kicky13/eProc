<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Penerimaan_Shipment extends CI_Controller
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
        $this->load->model('ec_pen_shipment_m');
        $data['title'] = "GR Pembelian Langsung";
        $data['brhasil'] = $brhasil;
        $data['count'] = $this->ec_pen_shipment_m->countShipment($this->session->userdata['ID']);;
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
        $this->layout->add_js('pages/EC_penerimaan_shipment.js');

        $this->layout->render('list', $data);
    }

    public function getItemShipment($cheat = false)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_pen_shipment_m');
        echo json_encode(array('data' => $this->ec_pen_shipment_m->getItemShipment($this->session->userdata['ID'])));;
    }

    public function Accepted($kode_shipment)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_pen_shipment_m');
        $this->load->library('sap_handler'); 
		
		$data = $this->ec_pen_shipment_m->getItemShipment_sap($kode_shipment);
		for ($i = 0; $i < sizeof($data); $i++) {
		  $return = $this->sap_handler->creategr($data[$i]['KODE_DETAIL_SHIPMENT'],$data[$i]['PO_NO'],$data[$i]['MATNO'],$data[$i]['QTY'],$this->session->userdata['ID']);
		 }
         //echo json_encode($return);

         if($return['RETURN']!=null){
            echo json_encode('kosong');
         }else{
            // echo json_encode($return['GR']);
            // echo json_encode($return['GR_YEAR']);
            $this->ec_pen_shipment_m->updateStatus($kode_shipment, $return['GR'], $return['GR_YEAR']);
         }
		/*$gr_no=""; 
		$sukses = false;
		
		//var_dump($return);
		foreach ($return as $value) {
                if ($value['TYPE'] == 'S') {
                    $gr_no = $value['MATERIALDOCUMENT'];
                    $sukses = true;
                }
        }
        echo json_encode($gr_no);
        //echo json_encode($return['MATERIALDOCUMENT']);
        //echo json_encode($return['MATERIALDOCUMENT']);
		if ($sukses) {
			//$this->ec_pen_shipment_m->updateStatus_GR($kode_shipment,$gr_no);
			$this->ec_pen_shipment_m->updateStatus($kode_shipment,$gr_no);
			
		}*/
		 
		//echo json_encode($return);
        //echo json_encode(array('data' => $this->ec_shipment_m->getPORelease($this->session->userdata['VENDOR_NO'])));;
        redirect('EC_Penerimaan_Shipment/index/');
    }

    public function getPO_pl_approval($cheat = false)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_po_pl_approval_m');
        echo json_encode(array('data' => $this->ec_po_pl_approval_m->getPo_pl_approval($this->session->userdata['ID'])));;
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

    public function reject($kode_shipment = '4500000452')
    {
        $data2=0;
//        header('Content-Type: application/json');
        $this->load->model('ec_pen_shipment_m');
        $this->ec_pen_shipment_m->reject($kode_shipment);
        //$this->load->library('sap_handler');
       // $data = $this->ec_pen_shipment_m->detailCart($kode_shipment);
       // $data2 = $this->sap_handler->PO_CHANGE_REJECT($kode_shipment, $data, false);
//        var_dump($data2);
        redirect('EC_Penerimaan_Shipment/index');
    }

    public function detail($PO = '4500000452')
    {
        header('Content-Type: application/json');
        $this->load->model('ec_po_pl_approval_m');
        echo json_encode($this->ec_po_pl_approval_m->detail($PO));
    }

    public function history($PO = '4500000452')
    {
        header('Content-Type: application/json');
        $this->load->model('ec_po_pl_approval_m');
        echo json_encode($this->ec_po_pl_approval_m->history($PO));
    }
}
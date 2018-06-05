<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Shipment extends CI_Controller
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
        $data['title'] = "Shipment";
        $data['brhasil'] = $brhasil;
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
        $this->layout->add_js('pages/EC_shipment.js');

        $this->layout->render('list', $data);
    }

    public function getPORelease($cheat = false)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
        echo json_encode(array('data' => $this->ec_shipment_m->getPORelease($this->session->userdata['VENDOR_NO'])));;
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
        redirect('EC_Shipment/index/');
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
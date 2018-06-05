<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Good_Receipt_PL extends CI_Controller
{

    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
//         $this->load->library('session');
        $this->load->helper("security");  
        $this->user = $this->session->userdata('FULLNAME');
    }

    public function index()
    {
        // $this->load->library('session');
        $data['title'] = "Good Receipt Pembelian Langsung";
        // $data['brhasil'] = $brhasil;
//        $data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();

        $this->layout->add_js('pages/star-rating.min.js');
        $this->layout->add_css('pages/star-rating.min.css');

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');

        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/EC_good_receipt.js');

        $this->layout->render('list', $data);
    }

    public function getPOShipment($cheat = false)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_goodreceipt_m');
        echo json_encode(array('data' => $this->ec_goodreceipt_m->getPOShipment()));
    }

    public function getPOShipmentReview()
    {
        header('Content-Type: application/json');
        $this->load->model('ec_goodreceipt_m');


        $itms = json_decode($this->input->post('kode_shipment'));
        // var_dump($itms);
        for ($j=0; $j < sizeof($itms); $j++) {
        	$hasil = $this->ec_goodreceipt_m->getPOShipmentReview($itms[$j]);

        	$dataAll[$j]["VENDOR_NAME"] = $hasil["VENDOR_NAME"];
        	$dataAll[$j]["PO_NO"] = $hasil["PO_NO"];
        	$dataAll[$j]["LINE_ITEM"] = $hasil["LINE_ITEM"];
        	$dataAll[$j]["MAKTX"] = $hasil["MAKTX"];
        	$dataAll[$j]["QTY"] = $hasil["QTY"];
        	$dataAll[$j]["MEINS"] = $hasil["MEINS"];
        	$dataAll[$j]["PLANT"] = $hasil["PLANT"];
        	$dataAll[$j]["PLANT_NAME"] = $hasil["PLANT_NAME"];
        }

        echo json_encode($dataAll);
    }

    public function insertGrTES()
    {
          $url = site_url('EC_Good_Receipt_PL/');
          $gr = '535345345353';
          $this->session->set_flashdata('data', 'informasi server nomer grnya '.$gr);
          $this->session->set_flashdata('sukses' , 1);

          echo json_encode(array('status' => 1, 'url' => $url));
    //    redirect("EC_Good_Receipt_PL/index/");
    }

    public function tesData()
    {
        var_dump($this->session->userdata);
    }

    public function insertGr()
    {
        $url = site_url('EC_Good_Receipt_PL/');
        $gagalReturn = array();
        $suksesReturn = array();
        $sukses = 0;
        // header('Content-Type: application/json');
        $this->load->model('ec_goodreceipt_m');
        $this->load->library('sap_handler');

        $itms = json_decode($this->input->post('kodeshipment'));
        $itmqty = json_decode($this->input->post('qtyreceipt'));
        $docdate = $this->input->post('docdate');
        $postdate = $this->input->post('postdate');
        $rating = $this->input->post('rating');
        $comment = $this->input->post('comment');
        // var_dump($itms);

		$newdocdate = date('Ymd',strtotime($docdate));
		$newpostdate = date('Ymd',strtotime($postdate));
		// var_dump($newpostdate);

        for ($j=0; $j < sizeof($itms); $j++) {
        	$hasil = $this->ec_goodreceipt_m->getPOShipmentReview($itms[$j]);

        	$return = $this->sap_handler->creategr($newpostdate, $newdocdate, $hasil['NO_SHIPMENT'], $hasil['PO_NO'], $hasil['LINE_ITEM'], $itmqty[$j],$this->session->userdata['ID']);

			// var_dump($return);
		 	if($return['RETURN']!=null){
                $sukses = 2;
            	$gagalReturn[] = $return['RETURN'];
         	}else{
                $sukses = 1;
            // echo json_encode($return['GR']);
            // echo json_encode($return['GR_YEAR']);
            	$this->ec_goodreceipt_m->insertGoodReceipt($hasil, $itmqty[$j], $return['GR'], $return['GR_YEAR'], $docdate, $postdate, $rating, $comment, $this->session->userdata['FULLNAME']);
                $this->ec_goodreceipt_m->updateDetailShipment($itms[$j], $itmqty[$j], $return['GR'], $return['GR_YEAR']);
                $this->ec_goodreceipt_m->updateheaderGr($hasil['ID_CHART'], $itmqty[$j], $hasil['PO_NO']);

                $suksesReturn[] = array("PO_NO" => $hasil["PO_NO"], "LINE_ITEM" => $hasil["LINE_ITEM"], "GR" => $return['GR'], "GR_YEAR" => $return['GR_YEAR']);

                // $dataAll[$j]["PO_NO"] = $hasil["PO_NO"];
                // $dataAll[$j]["LINE_ITEM"] = $hasil["LINE_ITEM"];
                // $dataAll[$j]["GR"] = $return['GR'];
         	}
        }
        // var_dump(site_url('EC_Good_Receipt_PL/'));
        // $this->load->helper('url');
        // redirect("EC_Good_Receipt_PL/index/");
        // header('Location: '.site_url('EC_Good_Receipt_PL/'));
        // echo json_encode(array("suksesReturn" => $suksesReturn, "gagalReturn" => $gagalReturn));

        // $this->load->library('session');
        // $this->load->helper('url');
        if($sukses==1){ 
            // $this->load->helper('url');
            $this->session->set_flashdata('data', $suksesReturn);
            $this->session->set_flashdata('sukses', $sukses);
            // redirect(site_url('EC_Good_Receipt_PL/index/'));
            echo json_encode(array('status' => $sukses, 'url' => $url, 'suksesReturn' => $suksesReturn, 'gagalReturn' => $gagalReturn));
        }else{
            $this->session->set_flashdata('data', $gagalReturn);
            $this->session->set_flashdata('sukses', $sukses);
            // redirect(site_url('EC_Good_Receipt_PL/index/'));
            echo json_encode(array('status' => $sukses, 'url' => $url, 'suksesReturn' => $suksesReturn, 'gagalReturn' => $gagalReturn));
        }

        // echo json_encode($suksesReturn);
        // echo json_encode(array("suksesReturn" => $suksesReturn, "gagalReturn" => $gagalReturn));
        // echo json_encode(array('suksesReturn' => $suksesReturn, 'gagalReturn' => $gagalReturn));
        // echo json_encode($dataAll);
    }

    public function rejectShipment()
    {
        $url = site_url('EC_Good_Receipt_PL/');
        $suksesReturn = array();
        $sukses = 3;
        header('Content-Type: application/json');
        $this->load->model('ec_goodreceipt_m');

        $itms = json_decode($this->input->post('kodeshipment'));
        $itmqty = json_decode($this->input->post('qtyreceipt'));
        $rating = $this->input->post('rating');
        $alasan = $this->input->post('alasan');
//        var_dump($itms);die();
        for ($j=0; $j < sizeof($itms); $j++) {
            $hasil = $this->ec_goodreceipt_m->getPOShipmentReview($itms[$j]);
            $this->ec_goodreceipt_m->insertGoodReceiptReject($hasil, $itmqty[$j], $rating, $alasan, $this->session->userdata['FULLNAME']);
            $this->ec_goodreceipt_m->updateDetailShipmentReject($itms[$j], $itmqty[$j], $alasan);

            $suksesReturn[] = array("PO_NO" => $hasil["PO_NO"], "LINE_ITEM" => $hasil["LINE_ITEM"], "NO_SHIPMENT" => $hasil["NO_SHIPMENT"]);
        }

        $this->session->set_flashdata('data', $suksesReturn);
        $this->session->set_flashdata('sukses', $sukses);
            // redirect(site_url('EC_Good_Receipt_PL/index/'));
        echo json_encode(array('status' => $sukses, 'url' => $url, 'suksesReturn' => $suksesReturn));
    }

    public function getPOorder($cheat = false)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_goodreceipt_m');
        echo json_encode(array('data' => $this->ec_goodreceipt_m->getPOorder()));
    }

    public function getDescItem($MATNR)
    {
        header('Content-Type: application/json');
        $this->load->model('EC_strategic_material_m');
        $data['MATNR'] = $this->EC_strategic_material_m->getDetail($MATNR);
        //substr($MATNR, 1));
        echo json_encode($data);
    }

    public function getPODetail($po)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');        
        echo json_encode($this->ec_shipment_m->getPODetail($po));
    }

    public function detailHistoryGR($po)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_goodreceipt_m');
        $lineitem = $this->input->post('line_item');
        echo json_encode(array('data' => $this->ec_goodreceipt_m->detailHistoryGR($po, $lineitem)));
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
        $today = date("YmdHi");
        // var_dump($today);

        for ($i=0; $i < sizeof($itms); $i++) {
        	$tes = explode("_", $itms[$i]);
        	$tes = $this->ec_shipment_m->insertDetailShipment($today, $tglShipment, $tes[3], $tes[4], $tes[2]);
        }

        if($tes>0){
        	echo json_encode(array('sukses' => '1', 'nomor' => $today));
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
    
    public function cetakLaporan($periode){
        $this->load->model('ec_goodreceipt_m','eg');
        $this->load->config('ec');
        $company_data = $this->config->item('company_data');        
        $newformat = date('m-Y',strtotime($periode));
        $data['company_data']=$company_data[$this->session->userdata('EM_COMPANY')];
        $data['data']=$this->eg->getCetakLaporan($newformat);
        $data['user']=$this->session->userdata('FULLNAME');
        $data['periode']=$newformat;
        $this->load->library('M_pdf');
        $mpdf = new M_pdf();
        $html = $this->load->view('EC_Good_Receipt_PL/cetakLaporan', $data, TRUE);

        $mpdf->pdf->writeHTML($html);
        $footer_rr = $this->load->view('EC_Good_Receipt_PL/cetakLaporanFooter', $data, TRUE);
        $mpdf->pdf->SetHTMLFooter($footer_rr);        
        $mpdf->pdf->output('Laporan Bulan' . $periode . '.pdf', 'I');
//        var_dump($data);
    }
    
    public function CetakPO(){                    
        $this->load->model('ec_shipment_m');
        $this->load->config('ec');
        $this->load->library('M_pdf');
        $company_data = $this->config->item('company_data');        
        $data['vendor']=$this->ec_shipment_m->get_vendor_detail($this->input->post('vendor'));
        $data['po']=$this->ec_shipment_m->get_shipment_detail($this->input->post('po_no'),$this->input->post('shipment'),$this->input->post('vendor'));
        $data['detail']=$this->ec_shipment_m->get_order($this->input->post('po_no'),$this->input->post('shipment'));
        $data['company']=$company_data[$data['detail'][0]['EM_COMPANY']];
        $mpdf = new M_pdf();
        $html = $this->load->view('EC_Shipment/cetakPO', $data, TRUE);

        $mpdf->pdf->writeHTML($html);
        $footer_rr = $this->load->view('EC_Shipment/cetakPOFooter', $data['po'], TRUE);
        $mpdf->pdf->SetHTMLFooter($footer_rr);        
        $mpdf->pdf->output('Cetak PO Pembelian Langsung ' . $data['detail'][0]['PO_NO'] . '.pdf', 'I');
    }
}

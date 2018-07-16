<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Shipment extends MX_Controller
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
        $data['title'] = "Pembelian Langsung";
        $data['brhasil'] = $brhasil;
//        $data['cheat'] = $cheat;
        $this->layout->set_table_js2();
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
        $this->layout->add_js('pages/rowsgroup.js');
        $this->layout->add_js('pages/EC_shipment.js');
//        $this->layout->add_js('pages/jquery.rowspanizer.js');        
        $this->layout->render('list', $data);
    }

    public function setShipment()
    {
        header('Content-Type: application/json');
        $this->load->model();
        $this->load->model('ec_shipment_m');
        $data = array();
        $kode = $this->input->post('kode_shipment');
        for ($i = 0; $i < count($kode); $i++){
            $data1 = $this->ec_shipment_m->getPODetail($kode[$i]);
            for ($j = 0; $j < sizeof($data1); $j++) {
                $qtyIntransit = $this->ec_shipment_m->getQtyIntransit($data1[$j]['ID_CHART']);
                $qtyReject = $this->ec_shipment_m->getQtyReject($data1[$j]['ID_CHART']);
                $datax[$j]["KODE_SHIPMENT"] = $data1[$j]["KODE_SHIPMENT"];
                $datax[$j]["PO_NO"] = $data1[$j]["PO_NO"];
                $datax[$j]["VENDORNO"] = $data1[$j]["VENDORNO"];
                $datax[$j]["STATUS"] = $data1[$j]["STATUS"];
                $datax[$j]["STOCK_COMMIT"] = $data1[$j]["STOCK_COMMIT"];
                $datax[$j]["QTY"] = $data1[$j]["QTY"];
                $datax[$j]["LINE_ITEM"] = $data1[$j]["LINE_ITEM"];
                $datax[$j]["MAKTX"] = $data1[$j]["MAKTX"];
                $datax[$j]["ID_CHART"] = $data1[$j]["ID_CHART"];
                $datax[$j]["MEINS"] = $data1[$j]["MEINS"];
                $datax[$j]["PLANT"] = $data1[$j]["PLANT"];
                $datax[$j]["PLANT_NAME"] = $data1[$j]["PLANT_NAME"];
                $datax[$j]["PRICE"] = $data1[$j]["PRICE"];
                $datax[$j]["DELIVERY_TIME"] = $data1[$j]["DELIVERY_TIME"];
                $datax[$j]["CURRENCY"] = $data1[$j]["CURRENCY"];
                $datax[$j]["EXPIRED_DATE"] = $data1[$j]["EXPIRED_DATE"];
                $datax[$j]["TOTAL"] = $data1[$j]["TOTAL"];
                $datax[$j]["QTY_RECEIPT"] = $data1[$j]["QTY_RECEIPT"];
                $datax[$j]["QTY_INTRANSIT"] = ($qtyIntransit["QTY_INTRANSIT"]==null?'0':$qtyIntransit["QTY_INTRANSIT"]);
                $datax[$j]["QTY_REJECT"] = ($qtyReject["QTY_REJECT"]==null?'0':$qtyReject["QTY_REJECT"]);
            }
            $data[$i] = $datax;
        }
        echo json_encode($data);
    }

    public function tesgetPORelease($cheat = false)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
        $result = $this->ec_shipment_m->getPORelease($this->session->userdata['VENDOR_NO']);
        var_dump(count($result));
        //echo json_encode(array('data' => $this->ec_shipment_m->getPORelease($this->session->userdata['VENDOR_NO'])));
    }

    public function getPORelease($cheat = false)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
        echo json_encode(array('data' => $this->compilePORelease($this->ec_shipment_m->getPORelease($this->session->userdata['VENDOR_NO']))));
    }

    public function compilePORelease($data)
    {
        $po = '';
        for ($i = 0; $i < count($data); $i++){
            if ($data[$i]['PO_NO'] == $po){
                $data[$i]['ROWSPAN'] = 'NO';
            } else {
                $data[$i]['ROWSPAN'] = 'YES';
            }
            $po = $data[$i]['PO_NO'];
        }
        return $data;
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
        $data1 = $this->ec_shipment_m->getPODetail($po);

        for ($j = 0; $j < sizeof($data1); $j++) {
            $qtyIntransit = $this->ec_shipment_m->getQtyIntransit($data1[$j]['ID_CHART']);
            $qtyReject = $this->ec_shipment_m->getQtyReject($data1[$j]['ID_CHART']);

            $dataAll[$j]["KODE_SHIPMENT"] = $data1[$j]["KODE_SHIPMENT"];
            $dataAll[$j]["PO_NO"] = $data1[$j]["PO_NO"];
            $dataAll[$j]["VENDORNO"] = $data1[$j]["VENDORNO"];
            $dataAll[$j]["STATUS"] = $data1[$j]["STATUS"];
            $dataAll[$j]["STOCK_COMMIT"] = $data1[$j]["STOCK_COMMIT"];
            $dataAll[$j]["QTY"] = $data1[$j]["QTY"];
            $dataAll[$j]["LINE_ITEM"] = $data1[$j]["LINE_ITEM"];
            $dataAll[$j]["MAKTX"] = $data1[$j]["MAKTX"];
            $dataAll[$j]["ID_CHART"] = $data1[$j]["ID_CHART"];
            $dataAll[$j]["MEINS"] = $data1[$j]["MEINS"];
            $dataAll[$j]["PLANT"] = $data1[$j]["PLANT"];
            $dataAll[$j]["PLANT_NAME"] = $data1[$j]["PLANT_NAME"];
            $dataAll[$j]["PRICE"] = $data1[$j]["PRICE"];
            $dataAll[$j]["DELIVERY_TIME"] = $data1[$j]["DELIVERY_TIME"];
            $dataAll[$j]["CURRENCY"] = $data1[$j]["CURRENCY"];
            $dataAll[$j]["EXPIRED_DATE"] = $data1[$j]["EXPIRED_DATE"];
            $dataAll[$j]["TOTAL"] = $data1[$j]["TOTAL"];
            $dataAll[$j]["QTY_RECEIPT"] = $data1[$j]["QTY_RECEIPT"];
            $dataAll[$j]["QTY_INTRANSIT"] = ($qtyIntransit["QTY_INTRANSIT"]==null?'0':$qtyIntransit["QTY_INTRANSIT"]);
            $dataAll[$j]["QTY_REJECT"] = ($qtyReject["QTY_REJECT"]==null?'0':$qtyReject["QTY_REJECT"]);

        }
        echo json_encode($dataAll);
        // echo json_encode($this->ec_shipment_m->getPODetail($po));
    }

    public function detailHistory($po)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
        echo json_encode($this->ec_shipment_m->detailHistory($po));
    }

    public function getDescItem($MATNR)
    {
        header('Content-Type: application/json');
        $this->load->model('EC_strategic_material_m');
        $data['MATNR'] = $this->EC_strategic_material_m->getDetail($MATNR);
        //substr($MATNR, 1));
        echo json_encode($data);
    }
    
    public function detailIntransit()
    {
        header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
        echo json_encode(array('data' => $this->compileIntransit($this->ec_shipment_m->detailIntransit($this->session->userdata['VENDOR_NO']))));
        // echo json_encode($this->ec_shipment_m->detailIntransit());
    }

    public function compileIntransit($data)
    {
        $shipment = '';
        for ($i = 0; $i < count($data); $i++){
            if ($data[$i]['NO_SHIPMENT'] == $shipment){
                $data[$i]['ROWSPAN_STATUS'] = 'NO';
                $data[$i]['ROWSPAN_ROW'] = 1;
            } else {
                $data[$i]['ROWSPAN_STATUS'] = 'YES';
            }
            if ($data[$i]['ROWSPAN_STATUS'] == 'YES'){
                $rowspan = 1;
                $j = $i+1;
                while ($j < count($data)){
                    if ($data[$i]['NO_SHIPMENT'] == $data[$j]['NO_SHIPMENT']){
                        $rowspan++;
                        $j++;
                    } else {
                        break;
                    }
                }
                $data[$i]['ROWSPAN_ROW'] = $rowspan;
            }
            $shipment = $data[$i]['NO_SHIPMENT'];
        }
        return $data;
    }

    public function approveVendor($po)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
        if ($this->ec_shipment_m->approveVendor($po)){
            $this->userNotification('Approve', $po);
        }
        redirect('EC_Shipment/index/');
    }

    public function rejectVendor($po)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_shipment_m');
        if ($this->ec_shipment_m->rejectVendor($po)){
            $this->userNotification('Reject', $po);
        }
        redirect('EC_Shipment/index/');
    }

    public function userNotification($action, $po)
    {
        $this->load->model('ec_shipment_m');
        $info = $this->ec_shipment_m->getPOHistory($po);
        $vendor = $this->ec_shipment_m->getVendorInfo($po);
        $tableData = $this->ec_shipment_m->detailHistory($po);
        $send = 'kicky120@gmail.com';
        if (isset($tableData)){
            $table = $this->buildTableNotification($tableData, $vendor);
            $data = array(
                'content' => '<h2 style="text-align:center;">DETAIL PO PEMBELIAN LANGSUNG</h2>'.$table.'<br/>',
                'title' => 'Nomor PO ' . $po . ' Telah '.$action.' Oleh Vendor '.$vendor['VENDOR_NAME'].' Fwd To : '.$info['EMAIL'],
                'title_header' => 'Nomor PO ' . $po . ' Telah di '.$action.' Oleh Vendor '.$vendor['VENDOR_NAME'],
            );
            $message = $this->load->view('EC_Notifikasi/ECatalog', $data, true);
            $subject = 'PO No. '.$po.' Berhasil di '.$action.'.[E-Catalog Semen Indonesia] Fwd To : '.$info['EMAIL'];
            Modules::run('EC_Notifikasi/Email/ecatalogNotifikasi', $send, $message, $subject);
        }
    }

    private function buildTableNotification($tableData, $vendor) {
        $tableGR = array(
            '<table border=1 style="font-size:10px;width:1000px;margin:auto;">'
        );
        $thead = '<thead>
            <tr>
                <th style="font-weight:600;" class="text-center"> No.</th>
                <th style="font-weight:600;"> No. PO</th>
                <th style="font-weight:600;"> Nama Vendor</th>
                <th style="font-weight:600;"> No. Material</th>
                <th style="font-weight:600;"> Nama Material</th>
                <th style="font-weight:600;"> Jumlah Order</th>
                <th style="font-weight:600;"> Plant</th>                
              </tr>        
              </thead>';
        $tbody = array();
        $no=1;
        foreach ($tableData as $d) {
            if (isset($d['MATNO'])){
                $_tr = '<tr>
                    <td> '.$no++.'</td>
                    <td> '.$vendor['PO_NO'].'</td>                      
                    <td> '.$vendor['VENDOR_NAME'].'</td>
                    <td> '.$d['MATNO'].'</td>
                    <td> '.$d['MAKTX'].'</td>                   
                    <td> '.$d['QTY'].'</td>                      
                    <td> '.$d['PLANT'].' - '.$d['PLANT_NAME'].'</td>                            
                  </tr>';
                array_push($tbody, $_tr);
            }
        }
        array_push($tableGR, $thead);
        array_push($tableGR, implode(' ', $tbody));
        array_push($tableGR, '</table>');
        return implode(' ', $tableGR);
    }

    public function testQuery()
    {
        $userid = '833';
        $po = '4500001192';
        $this->db->select('APR.*, VEN.VENDOR_NAME, VEN.EMAIL_ADDRESS');
        $this->db->from('EC_PL_APPROVAL APR');
        $this->db->join('VND_HEADER VEN', 'APR.VENDORNO = VEN.VENDOR_NO');
        $this->db->where('APR.PO_NO', $po);
        $result = $this->db->get();
        echo json_encode($this->session->userdata);
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
            var_dump($data);die();
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
        	$hasil = $this->ec_shipment_m->insertDetailShipment($today, $tglShipment, $tes[3], $tes[4], $tes[2]);
        }

        if($hasil>0){
            for ($i=0; $i < sizeof($itms); $i++) { 
                $tes = explode("_", $itms[$i]);
                $this->ec_shipment_m->updateGRmaterial($tes[2]);
            }
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
}
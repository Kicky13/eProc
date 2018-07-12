<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_PO_PL_Approval extends MX_Controller
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

    public function sendNotif($email, $tableData)
    {
        $send = 'kicky120@gmail.com';
        if (isset($tableData)){
            $po = $tableData['PO_NO'];
            $table = $this->buildTableUser($tableData);
            $data = array(
                'content' => '<h2 style="text-align:center;">DETAIL PO PEMBELIAN LANGSUNG</h2>'.$table.'<br/>',
                'title' => 'Nomor PO ' . $po . ' Mohon Anda Approve Fwd To : '.$email,
                'title_header' => 'Nomor PO ' . $po . ' Berhasil di Approve',
            );
            $message = $this->load->view('EC_Notifikasi/ECatalog', $data, true);
            $subject = 'PO No. '.$po.' Berhasil dibuat.[E-Catalog Semen Indonesia] Fwd To : '.$email;
            Modules::run('EC_Notifikasi/Email/ecatalogNotifikasi', $send, $message, $subject);
        }
    }

    private function buildTableUser($tableData) {
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
                <th style="font-weight:600;"> Satuan</th>
                <th style="font-weight:600;"> Jumlah Order</th>
                <th style="font-weight:600;"> Harga per Satuan</th>
                <th style="font-weight:600;"> Total</th>                
              </tr>        
              </thead>';
        $tbody = array();
        $no=1;
        foreach ($tableData['ITEM'] as $d) {
            if (isset($tableData['VENDORNO'])){
                $_tr = '<tr>
                    <td> '.$no++.'</td>
                    <td> '.$tableData['PO_NO'].'</td>                      
                    <td> '.$tableData['VENDOR_NAME'].'</td>
                    <td> '.$d['MATNO'].'</td>
                    <td> '.$d['MAKTX'].'</td>
                    <td> '.$d['MEINS'].'</td>                      
                    <td> '.$d['QTY'].'</td>
                    <td> Rp. '.number_format($d['PRICE'], "00", ",", ".").'</td>                      
                    <td> Rp. '.number_format($d['TOTAL'], "00", ",", ".").'</td>                            
                  </tr>';
                array_push($tbody, $_tr);
            }
        }
        array_push($tableGR, $thead);
        array_push($tableGR, implode(' ', $tbody));
        array_push($tableGR, '</table>');
        return implode(' ', $tableGR);
    }

    private function buildTableVendor($tableData) {
        $tableGR = array(
            '<table border=1 style="font-size:10px;width:1000px;margin:auto;">'
        );
        $thead = '<thead>
            <tr>
                <th style="font-weight:600;" class="text-center"> No.</th>
                <th style="font-weight:600;"> No. PO</th>
                <th style="font-weight:600;"> No. Material</th>
                <th style="font-weight:600;"> Nama Material</th>
                <th style="font-weight:600;"> Satuan</th>
                <th style="font-weight:600;"> Jumlah Order</th>
                <th style="font-weight:600;"> Harga per Satuan</th>
                <th style="font-weight:600;"> Total</th>                
              </tr>        
              </thead>';
        $tbody = array();
        $no=1;
        foreach ($tableData['ITEM'] as $d) {
            if (isset($tableData['VENDORNO'])){
                $_tr = '<tr>
                    <td> '.$no++.'</td>
                    <td> '.$tableData['PO_NO'].'</td>
                    <td> '.$d['MATNO'].'</td>
                    <td> '.$d['MAKTX'].'</td>
                    <td> '.$d['MEINS'].'</td>                      
                    <td> '.$d['QTY'].'</td>
                    <td> Rp. '.number_format($d['PRICE'], "00", ",", ".").'</td>                      
                    <td> Rp. '.number_format($d['TOTAL'], "00", ",", ".").'</td>                            
                  </tr>';
                array_push($tbody, $_tr);
            }
        }
        array_push($tableGR, $thead);
        array_push($tableGR, implode(' ', $tbody));
        array_push($tableGR, '</table>');
        return implode(' ', $tableGR);
    }

    public function index($brhasil = false)
    {
        $data['title'] = "Approval PO";
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
        $this->layout->add_js('pages/EC_po_pl_approval.js');

        $this->layout->render('list', $data);
    }

    public function getPO_pl_approval($cheat = false)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_po_pl_approval_m');
        echo json_encode(array('data' => $this->ec_po_pl_approval_m->getPo_pl_approval($this->session->userdata['ID'])));
    }

    //public function approve($PO = '4500000452')
    public function approve($PO)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_po_pl_approval_m');
        $data2=0;
        $this->notifToNext($PO);
        if ($this->ec_po_pl_approval_m->approve($PO)) {
            $this->load->library('sap_handler');
            $data = $this->ec_po_pl_approval_m->detailCart($PO);
            $data2 = $this->sap_handler->PO_CHANGE($PO, $data, false);
            //var_dump($data);
            if($data2==1){
                $this->ec_po_pl_approval_m->insertToShipment($data, $PO);
                $this->ec_po_pl_approval_m->insertHeaderGR($data);
            }
            redirect('EC_PO_PL_Approval/index/'.$data2.'/'.$PO);
        }
        redirect('EC_PO_PL_Approval/index/'.$data2);
    }

    public function notifToNext($po)
    {
        $data = $this->getDetailPO($po);
        $this->load->model('ec_master_approval_m');
        $user = $this->session->userdata['ID'];
        $active = $this->ec_master_approval_m->getActive_user($po, $user);
        $vnd = $this->ec_master_approval_m->getVendor_target($po);
        $cc = $active['UK_CODE'];
        $akses = $active['USER_AKSES'];
        $gudang = $active['STATUS_GUDANG'];
        $progress_gudang = $active['PROGRESS_APP_GUDANG'];
        $progress_CNF = $active['PROGRESS_CNF'];
        $notif = 'Failed to Send';
        switch ($progress_CNF){
            case 0:
                switch ($gudang){
                    case 1:
                        if ($progress_gudang == 1){
                            $next = $this->ec_master_approval_m->getEmailNext($cc, '0');
                            foreach ($next as $x){
                                $this->sendNotif($x['EMAIL'], $data);
                                $notif = 'Email Sent';
                            }
                            $this->sendVendor($vnd['EMAIL_ADDRESS'], $data, $akses);
                        } else {
                            $notif = 'Email Sent';
                            $this->sendVendor($vnd['EMAIL_ADDRESS'], $data, $akses);
                        }
                        break;
                    default:
                        $notif = 'Email Sent';
                        $this->sendVendor($vnd['EMAIL_ADDRESS'], $data, $akses);
                        break;
                }
                break;
            default:
                if ($this->ec_master_approval_m->checkNext_CNF($cc, $progress_CNF + 1)){
                    $next = $this->ec_master_approval_m->getEmailNext($cc, $progress_CNF + 1);
                    foreach ($next as $x){
                        $this->sendNotif($x['EMAIL'], $data);
                        $notif = 'Email Sent';
                    }
                    $this->sendVendor($vnd['EMAIL_ADDRESS'], $data, $akses);
                } else {
                    $notif = 'Email Sent';
                    $this->sendVendor($vnd['EMAIL_ADDRESS'], $data, $akses);
                }
                break;
        }
        return $notif;
    }

    public function sendVendor($vendor, $tableData, $user)
    {
        if (isset($tableData)){
            $table = $this->buildTableVendor($tableData);
            $data = array(
                'content' => '<h2 style="text-align:center;">DETAIL PO PEMBELIAN LANGSUNG</h2>'.$table.'<br/>',
                'title' => 'Nomor PO ' . $tableData[0]['PO_NO'] . ' Berhasil di Approve Oleh '.$user,
                'title_header' => 'Nomor PO ' . $tableData[0]['PO_NO'] . ' Berhasil di Approve',
            );
            $message = $this->load->view('EC_Notifikasi/ECatalog', $data, true);
            $subject = 'PO No. '.$tableData[0]['PO_NO'].' Berhasil dibuat.[E-Catalog Semen Indonesia]';
            Modules::run('EC_Notifikasi/Email/ecatalogNotifikasi', $vendor, $message, $subject);
        }
    }

    public function testSql()
    {
        $userid = $this->session->userdata['ID'];
        $this->db->select('CT.PO_NO NOMERPO,TO_CHAR ((TO_DATE(CT.DATE_BUY, \'dd-mm-yyyy hh24:mi:ss\')+7), \'dd-mm-yyyy hh24:mi:ss\' ) COMMIT_DATE, CT.DATE_BUY,EC_PL_APPROVAL.CURR, VND_HEADER.VENDOR_NAME,  EC_PL_APPROVAL."VALUE",TDP.STOK_COMMIT, EC_PL_APPROVAL.VENDORNO,  EC_TRACKING_PO.*,TDP.DELIVERY_TIME',
            false);
        $this->db->from('(SELECT  PO_NO,  DATE_BUY FROM EC_T_CHART  WHERE CONTRACT_NO =  \'PL2018\' AND PO_NO IS NOT NULL GROUP BY  PO_NO, DATE_BUY ) CT');
        $this->db->join('(SELECT P1.* FROM EC_TRACKING_PO P1 INNER JOIN (SELECT PO_NO,MAX(INDATE) DATE1 FROM EC_TRACKING_PO GROUP BY PO_NO) P2 ON P1.PO_NO=P2.PO_NO AND P1.INDATE=P2.DATE1 )EC_TRACKING_PO',
            'EC_TRACKING_PO.PO_NO = CT.PO_NO', 'left');
        $this->db->join('EC_PL_APPROVAL', 'CT.PO_NO = EC_PL_APPROVAL.PO_NO', 'inner');
        $this->db->join('VND_HEADER', 'VND_HEADER.VENDOR_NO = EC_PL_APPROVAL.VENDORNO', 'left');
        $this->db->join('EC_PL_CONFIG_APPROVAL', 'EC_PL_APPROVAL.PROGRESS_APP = EC_PL_CONFIG_APPROVAL.PROGRESS_CNF AND EC_PL_APPROVAL.COSCENTER = EC_PL_CONFIG_APPROVAL.UK_CODE', 'inner');
        $this->db->join('(SELECT SUM(PRICE) PRICE,SUM(STOK_COMMIT) STOK_COMMIT,PO_NO,DELIVERY_TIME FROM EC_T_DETAIL_PENAWARAN 
                            INNER JOIN EC_T_CHART CT ON CT.KODE_PENAWARAN = EC_T_DETAIL_PENAWARAN.KODE_DETAIL_PENAWARAN 
                            GROUP BY PO_NO,DELIVERY_TIME) TDP ', 'CT.PO_NO = TDP.PO_NO', 'inner');
        $this->db->where('EC_PL_CONFIG_APPROVAL.USERID', $userid, TRUE);
        //        $this->db->where('EC_PL_CONFIG_APPROVAL.UK_CODE', $userid, TRUE);
        $this->db->where('EC_PL_APPROVAL.STATUS', '1', TRUE);
        $this->db->where('EC_PL_APPROVAL.PROGRESS_APP_GUDANG', '0', TRUE);
        // $this->db->where('EC_PL_APPROVAL.PROGRESS_APP<=', 'EC_PL_APPROVAL.MAX_APPROVE', false);
        $this->db->where('(TO_DATE(CT.DATE_BUY, \'dd-mm-yyyy hh24:mi:ss\')+7) >=', '(SELECT SYSDATE FROM DUAL)', false);
        $this->db->order_by('CT.PO_NO DESC');
        $result = $this->db->get();
        echo $this->db->last_query();
        die();
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

    public function getDetailPO($po)
    {
        $this->load->model('ec_po_pl_approval_m');
        $user = $this->session->userdata['ID'];
        $data = $this->ec_po_pl_approval_m->getDetailPO($user, $po);
        $data['ITEM'] = $this->ec_po_pl_approval_m->detail($po);
        return $data;
    }
}
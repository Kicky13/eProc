<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Approval_Material_Assign extends MX_Controller
{

    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->model('ec_approval_material_assign_m');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->user = $this->session->userdata('FULLNAME');
    }

    public function index($brhasil = false)
    {
        $data['title'] = "Approval Cataloging";
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
        $this->layout->add_js('pages/EC_Approval_Material_Assign.js');

        $this->layout->render('list', $data);
    }

    public function getMaterial_approval()
    {
        $result = $this->ec_approval_material_assign_m->getMaterial_approval();
        echo json_encode(array('data' => $result));
    }

    public function test()
    {
        print_r($this->ec_approval_material_assign_m->currentLvl());
    }

    public function approve($kode)
    {
        $this->ec_approval_material_assign_m->approve($kode);
        $this->sendNotif($this->ec_approval_material_assign_m->notificationGateway($kode, 1));
        return $this->index();
    }

    public function reject($kode)
    {
        $this->ec_approval_material_assign_m->reject($kode);
        $this->sendNotif($this->ec_approval_material_assign_m->notificationGateway($kode, 2));
        return $this->index();
    }

    public function sendNotif($tableData)
    {
        $send = 'kicky120@gmail.com';
        if ($tableData['ACTIVITY'] == 1) {
            $msg = 'di Approve. Menunggu Approve selanjutnya dari Anda.';
        } elseif ($tableData['ACTIVITY'] == 2) {
            $msg = 'Selesai proses Approval.';
        } elseif ($tableData['ACTIVITY'] == 3) {
            $msg = 'di Reject.';
        } else {
            $msg = 'di Assign. Menunggu Approve dari Anda';
        }
        if (isset($tableData)) {
            $matno = $tableData['DATA']['MATNO'];
            $table = $this->buildTableUser($tableData['DATA']);
            $data = array(
                'content' => '<h2 style="text-align:center;">DETAIL INFO VENDOR ASSIGN</h2>' . $table . '<br/>',
                'title' => 'Nomor Material ' . $matno . ' Telah dipropose untuk penambahan material Pembelian Langsung Fwd To : ' . $tableData['EMAIL'],
                'title_header' => 'Nomor Material ' . $matno . ' Telah ' . $msg,
            );
            $message = $this->load->view('EC_Notifikasi/ECatalog', $data, true);
            $subject = 'Matno ' . $matno . ' Berhasil di Assign.[E-Catalog Semen Indonesia] Fwd To : ' . $tableData['EMAIL'];
            Modules::run('EC_Notifikasi/Email/ecatalogNotifikasi', $send, $message, $subject);
        }
    }

    private function buildTableUser($tableData)
    {
        $tableGR = array(
            '<table border=1 style="font-size:10px;width:1000px;margin:auto;">'
        );
        $thead = '<thead>
            <tr>
                <th style="font-weight:600;"> No. Material</th>
                <th style="font-weight:600;"> Nama Material</th>
                <th style="font-weight:600;"> Kategori</th>
                <th style="font-weight:600;"> Indate</th>               
              </tr>        
              </thead>';
        $tbody = array();
        if (isset($tableData)) {
            $_tr = '<tr>
                    <td> ' . $tableData['MATNO'] . '</td>                      
                    <td> ' . $tableData['MAKTX'] . '</td>
                    <td> ' . $tableData['ID_CAT'] . ' - ' . $tableData['DESC'] . '</td>
                    <td> ' . $tableData['DATE'] . '</td>                            
                  </tr>';
            array_push($tbody, $_tr);
        }
        array_push($tableGR, $thead);
        array_push($tableGR, implode(' ', $tbody));
        array_push($tableGR, '</table>');
        return implode(' ', $tableGR);
    }
}

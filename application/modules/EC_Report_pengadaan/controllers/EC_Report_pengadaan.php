<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Report_pengadaan extends CI_Controller
{

    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->model('ec_report_publish_m');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->user = $this->session->userdata('FULLNAME');
    }

    public function index($brhasil = false)
    {
        $data['title'] = "Report Assign Vendor";
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
        $this->layout->add_js('pages/EC_report_pengadaan.js');

        $this->layout->render('list', $data);
    }

    public function getReport_approval()
    {
        header('Content-Type: application/json');
        $result = $this->ec_report_publish_m->getReport_approval();
        echo json_encode(array('data' => $this->compiled($result)));
    }

    public function getDetail_approval()
    {
        header('Content-Type: application/json');
        $result = $this->ec_report_publish_m->getDetail_approval($this->input->post('matno'), $this->input->post('vendorno'));
        echo json_encode($result);
    }

    public function compiled($data)
    {
        for ($i = 0; $i < count($data); $i++){
            $temp = $this->ec_report_publish_m->getStatus($data[$i]['MATNO'], $data[$i]['VENDORNO']);
            if ($temp['LOG_ACTIVITY'] == 1) {
                $status = 'Waiting for Approve on Approval '.$temp['LEVEL'];
            } elseif ($temp['LOG_ACTIVITY'] == 2){
                $status = 'Approved by Approval '.$temp['LEVEL'];
            } elseif ($temp['LOG_ACTIVITY'] == 3){
                $status = 'Rejected by Approval '.$temp['LEVEL'];
            }
            $data[$i]['STATUS'] = $status;
        }
        return $data;
    }

    public function test()
    {
        $select = 'MATNO, VENDORNO, KODE_UPDATE, MEINS, VENDOR_NAME, MAKTX';
        $this->db->select($select);
        $this->db->from('EC_REPORT_VENDOR_ASSIGN');
        $this->db->join('VND_HEADER', 'VND_HEADER.VENDOR_NO = EC_REPORT_VENDOR_ASSIGN.VENDORNO');
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_M_STRATEGIC_MATERIAL.MATNR = EC_REPORT_VENDOR_ASSIGN.MATNO');
        $this->db->group_by($select);
        $result = $this->db->get();
        echo $this->db->last_query();
    }
}

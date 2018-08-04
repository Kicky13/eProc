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
        echo json_encode(array('data' => $result));
    }

    public function getDetail_approval()
    {
        header('Content-Type: application/json');
        $result = $this->ec_report_publish_m->getDetail_approval($this->input->post('matno'), $this->input->post('vendorno'));
        echo json_encode($result);
    }

    public function test()
    {
        $test2 = $this->ec_report_publish_m->currentLvl();
        $test = $this->ec_report_publish_m->getNext(1);
        print_r(array('test' => $test, 'test2' => $test2));
    }
}

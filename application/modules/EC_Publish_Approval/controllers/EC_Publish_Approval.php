<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Publish_Approval extends CI_Controller
{

    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->model('ec_publish_approval_m');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->user = $this->session->userdata('FULLNAME');
    }

    public function index($brhasil = false)
    {
        $data['title'] = "Approval Propose Assign";
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
        $this->layout->add_js('pages/EC_publish_approval.js');

        $this->layout->render('list', $data);
    }

    public function getPublish_approval()
    {
        header('Content-Type: application/json');
        $result = $this->ec_publish_approval_m->getPublish_approval();
        echo json_encode(array('data' => $result));
    }

    public function test()
    {
        $test = $this->ec_publish_approval_m->findNext(1);
        print_r($test);
    }

    public function approve()
    {
        header('Content-Type: application/json');
        $data = json_decode($this->input->post('kode'));
        foreach ($data as $kode){
            $this->ec_publish_approval_m->approve($kode);
        }
        echo json_encode($data);
    }

    public function reject()
    {
        header('Content-Type: application/json');
        $data = json_decode($this->input->post('kode'));
        foreach ($data as $kode){
            $this->ec_publish_approval_m->reject($kode);
        }
        echo json_encode($data);
    }
}

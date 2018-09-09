<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Negosiasi_Ecatalog extends MX_Controller
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
        $data['title'] = "Negosiasi Pembelian Langsung";
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
        $this->layout->add_js('pages/EC_PL_negosiasi.js');
        $this->layout->render('list', $data);
    }

    public function getChat()
    {
        header('Content-Type: application/json');
        $this->load->model('ec_pl_negosiasi_m');
        $id = $this->input->post('negoID');
        $data = $this->ec_pl_negosiasi_m->getChat($id);
        echo json_encode(array('data' => $data));
    }

    public function getArchiveNego()
    {
        header('Content-Type: application/json');
        $this->load->model('ec_pl_negosiasi_m');
        $data = $this->ec_pl_negosiasi_m->compileLastChat($this->ec_pl_negosiasi_m->getArchiveNego());
        echo json_encode(array('data' => $data));
    }

    public function getActiveNego()
    {
        header('Content-Type: application/json');
        $this->load->model('ec_pl_negosiasi_m');
        $data = $this->ec_pl_negosiasi_m->compileLastChat( $this->ec_pl_negosiasi_m->getActiveNego());
        echo json_encode(array('data' => $data));
    }

    public function openChat()
    {
        header('Content-Type: application/json');
        $this->load->model('ec_pl_negosiasi_m');
        $negoid = $this->input->post('negoId');
        $data = $this->ec_pl_negosiasi_m->getChat($negoid);
        echo json_encode(array('data' => $data));
    }

    public function sendMessage()
    {
        header('Content-Type: application/json');
        $this->load->model('ec_pl_negosiasi_m');
        $msg = $this->input->post('message');
        $negoid = $this->input->post('negoId');
        $this->ec_pl_negosiasi_m->sendChat(2, $msg, $this->ec_pl_negosiasi_m->getNegoByID($negoid));
        echo json_encode('Sent');
    }

    public function openLock()
    {
        header('COntent-Type: application/json');
        $this->load->model('ec_pl_negosiasi_m');
        $matno = $this->input->post('matno');
        $plant = $this->input->post('plant');
        $vendorno = $this->input->post('vendorno');
        $this->ec_pl_negosiasi_m->openLock($vendorno, $matno, $plant);
        echo json_encode('True');
    }

    public function test()
    {
        echo json_encode($this->session->userdata);
    }
}
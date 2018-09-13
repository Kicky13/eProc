<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Report_Chat extends CI_Controller
{

    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->model('ec_report_chat_m');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->user = $this->session->userdata('FULLNAME');
    }

    public function index($brhasil = false)
    {
        $data['title'] = "Report Chat Negosiasi";
        $data['brhasil'] = $brhasil;
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
        $this->layout->add_js('pages/EC_report_chat.js');

        $this->layout->render('list', $data);
    }

    public function getDataNego()
    {
        header('Content-Type: application/json');
        $data = $this->ec_report_chat_m->addLastChat($this->ec_report_chat_m->dataNego());
        echo json_encode(array('data' => $data));
    }

    public function getDataChat()
    {
        header('Content-Type: application/json');
        $negoid = $this->input->post('negoId');
        $data = $this->ec_report_chat_m->dataChatByNegoID($negoid);
        echo json_encode(array('data' => $data));
    }
}

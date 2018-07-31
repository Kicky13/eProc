<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Approval_Material_Assign extends CI_Controller
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
        return $this->index();
    }

    public function reject($kode)
    {
        $this->ec_approval_material_assign_m->reject($kode);
        return $this->index();
    }
}

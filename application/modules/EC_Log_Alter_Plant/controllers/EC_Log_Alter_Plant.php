<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Log_Alter_Plant extends CI_Controller
{

    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->model('ec_log_alter_plant_m');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->user = $this->session->userdata('FULLNAME');
    }

    public function index($brhasil = false)
    {
        $data['title'] = "Plant Changing Log";
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
        $this->layout->add_js('pages/EC_log_alter_plant.js');

        $this->layout->render('list', $data);
    }

    public function getReport()
    {
        header('Content-Type: application/json');
        $result = $this->ec_log_alter_plant_m->getReport();
        echo json_encode(array('data' => $result));
    }

    public function test()
    {
        $cat = '461';
        $matno = '503-200312';
        $this->db->from('EC_REPORT_APPROVAL_STRATEGIC_M');
        $this->db->join('EC_M_KONFIGURASI_MATERIAL', 'EC_M_KONFIGURASI_MATERIAL.USER_ID = EC_REPORT_APPROVAL_STRATEGIC_M.USER_ID', 'left');
        $this->db->join('ADM_EMPLOYEE', 'ADM_EMPLOYEE.ID = EC_REPORT_APPROVAL_STRATEGIC_M.USER_ID', 'left');
        $this->db->where('MATNO', $matno);
        $this->db->where('CAT_ID', $cat);
        $this->db->order_by('CONF_LEVEL');
        $result = $this->db->get();
        echo $this->db->last_query();
    }
}

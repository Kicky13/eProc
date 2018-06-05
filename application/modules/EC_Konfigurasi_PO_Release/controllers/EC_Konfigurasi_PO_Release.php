<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class EC_Konfigurasi_PO_Release extends CI_Controller
{
    private $user;
    private $user_email;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');        
        $this->load->helper("security");
        $this->user = $this->session->userdata('FULLNAME');
        $this->user_email = $this->session->userdata('EMAIL');
    }

    public function tes()
    {
        echo json_encode($this->session->userdata);
    }

    public function index()
    {
        $data['title'] = "Konfigurasi PO Release";
        $data['tanggal'] = date("d-m-Y");
        $this->load->model('ec_konfigurasi_lansgung_m');
        $data['master_update'] = $this->ec_konfigurasi_lansgung_m->get_M_update();
        $data['currency'] = $this->ec_konfigurasi_lansgung_m->get_MasterCurrency();
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_datetimepicker();
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
        $this->layout->add_css('plugins/bootstrap-select/bootstrap-select.css');
        $this->layout->add_js('plugins/bootstrap-select/bootstrap-select.js');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_nav_tree.js');
        $this->layout->add_css('pages/EC_nav_tree.css');
        $this->layout->add_js('pages/EC_konfigurasi_po_release.js');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_style_ecatalog.css');
        $this->layout->render('po_release', $data);
    }
}

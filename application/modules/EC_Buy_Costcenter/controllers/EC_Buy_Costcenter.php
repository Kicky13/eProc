<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class EC_Buy_Costcenter extends CI_Controller
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
        $data['title'] = "Master CostCenter";
        $data['brhasil'] = $brhasil;
//        $data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();
        $this->layout->add_js('pages/EC_autocomplete.js');
        $this->layout->add_css('pages/EC_autocomplete.css');
        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/EC_master_costcenter.js');
        $this->layout->add_js('plugins/select2/select2.js');
        $this->layout->add_css('plugins/select2/select2.css');
        $this->layout->add_css('plugins/select2/select2-bootstrap.css');
        $data['CC'] = $this->COSTCENTER_GETLIST();
        $this->load->model('ec_master_costcenter');
        $data['USER'] = $this->ec_master_costcenter->getUsername();
        //$data['ccc'] = $this->EC_catalog_produk->getCC($this->session->userdata['ID']);
        $this->layout->render('index', $data);
    }
    
    function COSTCENTER_GETLIST()
    {
        //        header('Content-Type: application/json');
        $this->load->library('sap_handler');
        $data = $this->sap_handler->COSTCENTER_GETLIST($this->session->userdata, false);
        //        echo json_encode($data);
        return $data;
    }
    
    public function getMaster_costcenter($cheat = false) 
    {
        header('Content-Type: application/json');
        $this->load->model('ec_master_costcenter');
        echo json_encode(array('data' => $this->ec_master_costcenter->getMaster_costcenter()));
    }
    
    public function simpan()
    {
    	header('Content-Type: application/json');
        $this->load->model('ec_master_costcenter');
        $CC = explode('-', $this->input->post('cc'));
        $ccVal = $CC[0];
        $ccName = $CC[1];
        $detail = array('COSTCENTER' => $ccVal, 'COSTCENTER_NAME' => $ccName, 'USERID' => $this->input->post('userid'), 'GUDANG'=>$this->input->post('gudang'));
        $query = $this->ec_master_costcenter->simpanData($detail);
        if($query){
            echo "Success";
        }else{
            echo "Username Sudah Ada";
        }
    }
    
    public function delete($ID)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_master_costcenter');
        $this->ec_master_costcenter->delete($ID);
        
        redirect('EC_Buy_Costcenter/');
    }
    
    public function update()
    {
    	header('Content-Type: application/json'); 
        $this->load->model('ec_master_costcenter');
        $CC = explode(':', $this->input->post('costCenter'));
        $detail = array('ID' => $this->input->post('id'), 'COSTCENTER' => $CC[0], 'COSTCENTER_NAME' => $CC[1], 'USERID' => $this->input->post('userid'),'GUDANG' => $this->input->post('gudang'));
        $query = $this->ec_master_costcenter->updateData($detail);
        if($query){
        	echo "Success"; 
        	//redirect("EC_Master_Approval/");
        }else{
        	echo "Username Sudah Ada";
        }        
        //echo json_encode($query);
        //redirect("EC_Master_Approval/");
    }
    
}


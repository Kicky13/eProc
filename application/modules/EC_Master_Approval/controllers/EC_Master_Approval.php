<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Master_Approval extends CI_Controller
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
        $data['title'] = "Approval Configuration";
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
        $this->layout->add_js('pages/EC_master_approval.js');
        $this->layout->add_js('plugins/select2/select2.js');
        $this->layout->add_css('plugins/select2/select2.css');
        $this->layout->add_css('plugins/select2/select2-bootstrap.css');
        $data['CC'] = $this->COSTCENTER_GETLIST();
        $this->load->model('EC_catalog_produk');
        //$data['ccc'] = $this->EC_catalog_produk->getCC($this->session->userdata['ID']);
        $this->layout->render('list', $data);
    }

    function COSTCENTER_GETLIST()
    {
        //        header('Content-Type: application/json');
        $this->load->library('sap_handler');
        $data = $this->sap_handler->COSTCENTER_GETLIST($this->session->userdata, false);
        //        echo json_encode($data);
        return $data;
    }

    public function simpan()
    {
    	header('Content-Type: application/json');
        $this->load->model('ec_master_approval_m');
        $detail = array('UK_CODE' => $this->input->post('cc'), 'VALUE_FROM' => $this->input->post('valueFrom'),
            'VALUE_TO' => $this->input->post('valueTo'), 'USERNAME' => $this->input->post('username'), 'USERID' => $this->input->post('userid'), 'USER_AKSES' => $this->input->post('userakses'), 'PROGRESS_CNF' => $this->input->post('cnf'));
        $query = $this->ec_master_approval_m->simpanData($detail);
        if($query){
        	echo "Success"; 
        	//redirect("EC_Master_Approval/");
        }else{
        	echo "Username Sudah Ada";
        }        
        //echo json_encode($query);
        //redirect("EC_Master_Approval/");
    }

    public function update()
    {
    	header('Content-Type: application/json'); 
        $this->load->model('ec_master_approval_m');
        $detail = array('UK_CODE' => $this->input->post('cc'), 'VALUE_FROM' => $this->input->post('valueFrom'),
            'VALUE_TO' => $this->input->post('valueTo'), 'USER' => $this->input->post('username'), 'PROGRESS_CNF' => $this->input->post('cnf'));
        $query = $this->ec_master_approval_m->updateData($detail, $this->input->post('costCenter'), $this->input->post('setCnf'));
        if($query){
        	echo "Success"; 
        	//redirect("EC_Master_Approval/");
        }else{
        	echo "Username Sudah Ada";
        }        
        //echo json_encode($query);
        //redirect("EC_Master_Approval/");
    }

    public function getMaster_approval($cheat = false) 
    {
        header('Content-Type: application/json');
        $this->load->model('ec_master_approval_m');
        echo json_encode(array('data' => $this->ec_master_approval_m->getMaster_approval()));
    }

    public function checkCNF($cheat = false) 
    {
        header('Content-Type: application/json');
        $this->load->model('ec_master_approval_m');
        echo json_encode($this->ec_master_approval_m->getCNF($this->input->post('costCenter')));
    }

    public function delete($CC)
    {
        $data2=0;
//        header('Content-Type: application/json');
        $this->load->model('ec_master_approval_m');
        $this->ec_master_approval_m->delete($CC, $this->uri->segment(4));
        // $this->load->library('sap_handler');
        // $data = $this->ec_po_pl_approval_m->detailCart($PO);
        // $data2 = $this->sap_handler->PO_CHANGE_REJECT($PO, $data, false);
//        var_dump($data2);
        redirect('EC_Master_Approval/');
    }

    public function search_nama()
    {
    // tangkap variabel keyword dari URL
    $keyword = $this->uri->segment(3);

    // cari di database
    $data = $this->db->query("SELECT EMP.*
                          FROM ADM_EMPLOYEE EMP where EMP.FULLNAME like '%".strtoupper($keyword)."%'");

    // format keluaran di dalam array
    foreach($data->result() as $row)
    {
      $arr['query'] = $keyword;
      $arr['suggestions'][] = array(
        'value' =>$row->FULLNAME,
        'ID_USER' =>$row->ID
      );
    }
    // minimal PHP 5.2
    echo json_encode($arr);
  }
}
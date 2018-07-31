<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Konfigurasi_Material_Approval extends CI_Controller
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
        $data['title'] = "Assign Configuration";
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
        $this->layout->add_js('pages/EC_konfigurasi_material_approval.js');
        $this->layout->add_js('plugins/select2/select2.js');
        $this->layout->add_css('plugins/select2/select2.css');
        $this->layout->add_css('plugins/select2/select2-bootstrap.css');
        $data['CC'] = $this->COSTCENTER_GETLIST();
        $this->load->model('ec_master_approval_m');
        $data['EMP'] = $this->ec_master_approval_m->getUser_employee();
//        $this->load->model('EC_catalog_produk');
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
        $this->load->model('ec_konfigurasi_material_approval_m');
        $detail = array('USER_ID' => $this->input->post('userid'), 'LEVEL' => $this->input->post('lvl'), 'MATGROUP' => $this->input->post('matgrp'));
        $query = $this->ec_konfigurasi_material_approval_m->simpanData($detail);
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
        $this->load->model('ec_konfigurasi_material_approval_m');
        $detail = array('ID' => $this->input->post('id'), 'USER_ID' => $this->input->post('userid'), 'LEVEL' => $this->input->post('lvl'), 'MATGROUP' => $this->input->post('matgrp'));
        $query = $this->ec_konfigurasi_material_approval_m->updateData($detail);
        if($query){
            echo "Success";
            //redirect("EC_Master_Approval/");
        }else{
            echo "Username Sudah Ada";
        }
        //echo json_encode($query);
        //redirect("EC_Master_Approval/");
    }

    public function getMaster_data($cheat = false)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_konfigurasi_material_approval_m');
        echo json_encode(array('data' => $this->ec_konfigurasi_material_approval_m->getMaster_data()));
    }

    public function checkCNF($cheat = false)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_master_approval_m');
        echo json_encode($this->ec_master_approval_m->getCNF($this->input->post('costCenter')));
    }

    public function delete($ID)
    {
        $this->load->model('ec_konfigurasi_material_approval_m');
        $this->ec_konfigurasi_material_approval_m->delete($ID);
        redirect('EC_Konfigurasi_Material_Approval/');
    }

    public function search_nama()
    {
        $keyword = $this->uri->segment(3);
        $data = $this->db->query("SELECT EMP.*
                          FROM ADM_EMPLOYEE EMP where EMP.FULLNAME like '%".strtoupper($keyword)."%'");
        foreach($data->result() as $row)
        {
            $arr['query'] = $keyword;
            $arr['suggestions'][] = array(
                'value' =>$row->FULLNAME,
                'ID_USER' =>$row->ID
            );
        }
        echo json_encode($arr);
    }

    public function test()
    {
        $text = '623, 524, 01, 342, 77, 55, 44, 32';
        $this->load->model('ec_konfigurasi_material_approval_m');
        echo $this->ec_konfigurasi_material_approval_m->compileMatGroup($text);
    }
}
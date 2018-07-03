<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_List_Canceled extends MX_Controller {

    private $user;
    public function __construct() {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->load->model("invoice/ec_log_invoice_cancel",'cancel');
        $this->user = $this->session->userdata('FULLNAME');
    }

    public function index() {
        $data['title'] = "List Invoice Canceled";
        //$data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/EC_List_Canceled.js');

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');

        $this->layout->render('listInvoiceCanceled',$data);
    }


    public function getCanceledInvoice($status_task,$status_reinvoice){
        //$status = '1';
        $role_user = $this->getUserRole();
        $company = $this->getCompany($role_user);
        //$str_company = implode(',',$company);
        $data = $this->cancel->getInvoiceCanceled($company,$status_task,$status_reinvoice);
        /*if(count($company)>0){
            $res = $this->nova->get_Enofa("WHERE E.STATUS = '1' AND COMPANY IN($str_company)",'ORDER BY CREATE_DATE');
            $json_data = array('data' => $res);
        }else{
            $json_data = array('data' => array());
        }*/
        //echo $this->db->last_query();die();
        //var_dump($data);
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }


    public function getUserRole(){
        $this->load->model('invoice/ec_role_user', 'role_user');
        $user_email = explode('@', $this->session->userdata('EMAIL'));
        $username = $user_email[0];
        $temp = $this->role_user->get_all(array('USERNAME' => $user_email[0], 'STATUS' => 1));
        $role_user = array();
        if(!empty($temp)){
            foreach($temp as $_t){
                array_push($role_user,$_t->ROLE_AS);
            }
        }
        return $role_user;
    }

    public function getCompany($role_user){
        $this->load->model('invoice/ec_role_access', 'role_access');
        $company = array();
        if(count($role_user)>0){
            $fil = 'SEKSI PAJAK';
            foreach($role_user as $r){
                $result = 0;
                if (strpos($r, $fil) !== false) {
                    $result = 1;
                }
                if($result){
                    $_company = $this->role_access->as_array()->get(array('OBJECT_AS' => 'COMPANY_CODE','ROLE_AS' => $r));
                    if(!empty($_company)){
                        array_push($company,$_company['VALUE']);
                    }
                }
            }
        }
        return $company;
    }
}
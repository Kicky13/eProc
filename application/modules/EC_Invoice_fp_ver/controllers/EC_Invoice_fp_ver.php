<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Invoice_fp_ver extends MX_Controller {
    private $user;
    private $user_email;
    private $roles_user;
    private $current_roles;
    public function __construct() {
        parent::__construct();
//error_reporting(0);
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->user_email = $this->session->userdata('EMAIL');
        $this->user = $this->session->userdata('FULLNAME');
        /* dapatkan role untuk fitur verifikasi ini */
        $this->roles_user = $this->getRoleVerifikasi();
        $this->load->model('invoice/ec_role_user', 'role_user');
        $email_login = explode('@', $this->user_email);
        $this->current_roles = array();
        $_tmp = $this->role_user->get_all(array('USERNAME' => $email_login[0], 'STATUS' => 1));
        if(!empty($_tmp)){
            foreach($_tmp as $_t){
                array_push($this->current_roles,$_t->ROLE_AS);
            }
        }
    }

    public function index($kode = '-') {
        $data['title'] = "Ekspedisikan Faktur";
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_css('pages/EC_bootstrap-slider.min.css');
        $this->layout->add_js('pages/EC_bootstrap-slider.min.js');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_Invoice_fp_ver.js?4');
        $this->layout->add_css('pages/EC_style_ecatalog.css');
        $this->layout->render('list', $data);
    }

    public function get_invoice_lanjut(){
// error_reporting(E_ALL);
        $this->load->model('ec_open_inv','eo');
        $this->load->model('invoice/ec_role_access','era');
        $this->load->model('invoice/ec_faktur_ekspedisi','fe');

        $role = array();
        $era = $this->db->where('ROLE_AS in (\''.implode('\',\'',$this->current_roles).'\') and ROLE_AS like \'VERIFIKASI%\'')->get('EC_ROLE_ACCESS')->result_array();

        $era_group = $this->groupingByColumn($era, 'ROLE_AS');
        $datainvoice = array();

        foreach($era_group as $eg){
            $where_str = array();
            foreach($eg as $val){
                if($val['OBJECT_AS'] == 'ITEM_CAT'){
                    $where_str[] = $val['OBJECT_AS'] .' in ('.$val['VALUE'].')';
                }else{
                    $where_str[] = $val['OBJECT_AS'] .' in (\''.$val['VALUE'].'\')';
                }
            }
            $order = ' order by EIH.CHDATE desc';
            $_tmp = $this->eo->get_Invoice('where '.implode(' AND ',$where_str).' AND EIH.ID_INVOICE NOT IN ( SELECT ID_INVOICE FROM EC_LOG_INVOICE_CANCEL WHERE STATUS_REINVOICE = 0 and STATUS_DOCUMENT = 5 ) ',$order);
            if(!empty($_tmp)){
                $i = 0;
                foreach($_tmp as $t){
                    if(!empty($t['FAKTUR_PJK'])){
                        if($t['STATUS_HEADER']==3 || $t['STATUS_HEADER']=="3"){
                            $ambilnofaktur = str_replace('-', '', $t['FAKTUR_PJK']);
                            $ambilnofaktur = str_replace('.', '', $ambilnofaktur);
                            $status_ekspedisi = "";
                            $cekfaktur = $this->fe->getFakturByFaktur($ambilnofaktur);
                            if(count($cekfaktur)>0){
                                $cekfakturheader = $this->fe->getDataEkspedisi($cekfaktur[0]['NO_EKSPEDISI']);
                                $status_ekspedisi = $cekfakturheader[0]['STATUS_SETOR'];
                            }
                            $t['STATUS_SETOR'] = $status_ekspedisi;
                            $t['FAKTUR_FULL'] = $ambilnofaktur;
                            $i++;
                            array_push($datainvoice,$t);
                        }
                    }
                }
            }
        }
        // echo "<pre>";
        // print_r($datainvoice);die;
        $json_data = array('page' => 25, 'data' => $datainvoice);
        echo json_encode($json_data);
    }

    public function ekspedisiFaktur(){
        error_reporting(E_ALL);   
        $this->load->library('sap_invoice');
        $this->load->model('invoice/ec_invoice_header','eo');

        $email = $this->session->userdata('EMAIL');
        $nama = $this->session->userdata('FULLNAME');
        $company = $this->session->userdata('COMPANYID');

        $jumlah=count($this->input->post('STATUS_SETOR'));
        $no_faktur=$this->input->post('STATUS_SETOR');


        $pesan = "";
        // echo "<pre>";
        // print_r($this->input->post());
        // print_r($no_faktur);
        // print_r($vendor_faktur);
        // die;
        // echo "a";echo json_encode($no_faktur);
        // echo $jumlah;die;

        if($no_faktur==false){
            $pesan .= '[ERROR] Belum Memilih Faktur '."<br>";
            $this->session->set_flashdata('message', $pesan);
            redirect('EC_Invoice_fp_ver');
        }


        // ambil vendor dulu
        $vendor_semua=array();
        foreach ($no_faktur as $i => $a) {
            $ambil_faktur_header = $this->eo->get_faktur($no_faktur[$i]);
            // echo "<pre>";
            // print_r($ambil_faktur_header);
            $ambilnofaktur = str_replace('-', '', $no_faktur[$i]);
            $ambilnofaktur = str_replace('.', '', $ambilnofaktur);
            $vendor=$this->db->select('VENDOR_NO, VENDOR_NAME, VENDOR_TYPE, EMAIL_ADDRESS')->from('VND_HEADER')->where('VENDOR_NO', $ambil_faktur_header['VENDOR_NO'])->get()->result_array();
            $input_vendor = array(
                'VENDOR_NAME' => $vendor[0]['VENDOR_NAME'],
                'VENDOR_NO' => $vendor[0]['VENDOR_NO'],
                'VENDOR_TYPE' => $vendor[0]['VENDOR_TYPE']
            );       
            array_push($vendor_semua, $input_vendor);
        }
        $vendor_semua = array_unique($vendor_semua);
        // echo "<pre>";
        // print_r($vendor_semua);die;
        // selesai


        foreach ($vendor_semua as $vs) {
            $input_param=array(        
                'BUKRS' => $company,
                'LIFNR' => $vs['VENDOR_NO'],
                'EMAIL' => $email,
                'PERSON' => $nama
            );  

            $input=array();
            foreach ($no_faktur as $i => $a) {
                $ambil_faktur_header = $this->eo->get_faktur($no_faktur[$i]);
                $ambilnofaktur = str_replace('-', '', $no_faktur[$i]);
                $ambilnofaktur = str_replace('.', '', $ambilnofaktur);
                if($vs['VENDOR_NO']==$ambil_faktur_header['VENDOR_NO']){   
                    $input_sap = array(
                        'XBLNR' => $ambilnofaktur,
                        'BLDAT' => date('Ymd', oraclestrtotime($ambil_faktur_header['FAKTUR_PJK_DATE'])), 
                        'BEDAT' => date('Ymd', oraclestrtotime($ambil_faktur_header['INVOICE_DATE'])), 
                        'HWBAS' => $ambil_faktur_header['TOTAL_AMOUNT'], 
                        'EBELN' => $ambil_faktur_header['NO_SP_PO']            
                    );       
                    array_push($input, $input_sap);
                }
            }    


            $act=$this->sap_invoice->setEkspedisiFaktur($input_param, $input);     
            if($act){
                $tgl_sekarang=date("Ymd");
                if($act['pesan']['TYPE']==='S'){
                    $data = array(        
                        'NO_EKSPEDISI'  => $act['noeks'],
                        'COMPANY'       => $company,
                        'VENDORNO'      => $vs['VENDOR_NO'],
                        'NATION'        => $vs['VENDOR_TYPE'],
                        'NAMA_SETOR'    => $nama,
                        'STATUS_SETOR'  => 2,
                    );    
                    $this->db->trans_start();
                    $this->db->set('TGL_EKSPEDISI',"to_date('".$tgl_sekarang."','YYYYMMDD')",false);  
                    $this->db->insert('EC_FAKTUR_EAEA', $data);       
                    foreach ($act['output'] as $i => $a) {
                        $data_detail = array(
                            'NO_EKSPEDISI' => $act['noeks'],
                            'NO_FAKTUR' => $act['output'][$i]['XBLNR'],
                            'TGL_FAKTUR' => $act['output'][$i]['BLDAT'],
                            'NPWP'=>$act['output'][$i]['STCD1'],
                            'DPP'=>$act['output'][$i]['HWBAS'],
                            'PPN'=>$act['output'][$i]['HWSTE'],
                            'TGL_BAST'=>date('Ymd', oraclestrtotime($ambil_faktur_header['INVOICE_DATE'])),
                            'PO'=>$ambil_faktur_header['NO_SP_PO']
                        );       
                        $this->db->insert('EC_FAKTUR_DETAILS', $data_detail);
                    }
                    $this->db->trans_complete();
                    $pesan .= $act['pesan']['MESSAGE'].' ['.$vs['VENDOR_NAME'].'] '.' Dengan Ekspedisi No.'.$act['noeks']."<br>";
                    $this->session->set_flashdata('message', $pesan);
                } else {
                    $pesan .= '[ERROR] '.$act['pesan']['MESSAGE'].' ['.$vs['VENDOR_NAME'].'] '."<br>";
                    $this->session->set_flashdata('message', $pesan);
                }                 
            }else{
                $pesan .= '[ERROR_SAP] '.$act['pesan']['MESSAGE'].' ['.$no_faktur[$i].'] '."<br>";
                $this->session->set_flashdata('message', $pesan);
            }

        }

        // echo "<pre>";
        // print_r($input_param);
        // print_r($input);
        // die;

        redirect('EC_Invoice_fp_ver');
    }

    public function getRoleVerifikasi(){
        $this->load->model('invoice/ec_role','er');
        $roles = $this->er->get_all('where ROLE_AS like \'VERIFIKASI%\'');
        $tmp = array();
        foreach($roles as $r){
            array_push($tmp,$r->ROLE_AS);
        }
        return $tmp;
    }

    private function groupingByColumn($arr, $colum){
        $result = array();
        foreach($arr as $r){
            if(!isset($result[$r[$colum]])){
                $result[$r[$colum]] = array();
            }
            array_push($result[$r[$colum]],$r);
        }
        return $result;
    }
}

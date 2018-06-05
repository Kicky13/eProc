<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Global_Message extends MX_Controller {

    private $user;
    private $email;
    public function __construct() {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->user = $this->session->userdata('FULLNAME');
        $this->email = $this->session->userdata('EMAIL');
    }

    public function index() {
        $data['title'] = "General Message";
        //$data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/Global_Message.js');

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/invoice/common.css');
        $this->layout->add_css('plugins/select2/select2.css');
        $this->layout->add_css('plugins/trumbowyg/trumbowyg.css');


        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('plugins/select2/select2.js');
        $this->layout->add_js('plugins/trumbowyg/trumbowyg.js');
        $this->layout->add_js('bootstrap-filestyle-1.2.1.min.js');
        $this->layout->add_js('bootbox.js');

        $data['vendor'] = $this->getVendor();   
        $data['employee'] = $this->getEmployee();
        $data['sender']['FULLNAME'] = $this->user; 
        $data['sender']['EMAIL'] = $this->email;   

        $this->layout->render('GlobalMessage/form',$data);
    }

    public function getVendor(){
        $sql = "
            SELECT
                VENDOR_NAME,
                VENDOR_NO||' - '||VENDOR_NAME AS VENDOR,
                TRIM(' '  FROM  EMAIL_ADDRESS||';'||CONTACT_EMAIL) AS EMAIL  
            FROM VND_HEADER
            ORDER BY VENDOR_NAME
        ";
        $data = $this->db->query($sql)->result_array();
        //var_dump($data);
        return $data;
    }

    public function getEmployee(){
        $sql = "SELECT FULLNAME, LOWER(EMAIL) AS EMAIL FROM ADM_EMPLOYEE WHERE STATUS = 'Active' ORDER BY FULLNAME";
        $data = $this->db->query($sql)->result_array();
        //var_dump($data);
        return $data;
    }

    /*SEND NOTIFICATION*/
    public function sendNotif(){
        $s_to = $this->input->post('send_to');
        $_cc = $this->input->post('cc') == '' ? '' : implode(',', $this->input->post('cc'));
        $_bcc = $this->input->post('bcc') == '' ? '' : implode(',', $this->input->post('bcc'));
        $content = $this->input->post('message');
        $subject = $this->input->post('subject');
        //var_dump($_FILES);die();
        /*Get Valid Email Vendor*/
        $valid_email = array();
        for ($i=0; $i < count($s_to); $i++) { 
            $clear_email = str_replace(' ', '', $s_to[$i]);
            $email = array_unique(explode(';',$clear_email));
            for ($ii=0; $ii < count($email); $ii++) { 
                if(filter_var($email[$ii],FILTER_VALIDATE_EMAIL)){
                    $valid_email[] = $email[$ii];
                }
            }
        }

        /*Record Log*/
        $this->load->library("file_operation");
        
        $_to = implode(',', $valid_email);
        $msg = array(
                'content' => $content,
                'title' => $subject,
                'title_header' => $subject,
            );

        $data = array(
                'SENDER'=> $this->user,
                'RECEIVER'=> $_to,
                'CC'=> $_cc,
                'BCC'=> $_bcc,
                'SUBJECT' => $subject,
                'MESSAGE'=> $content
                );

        $uploaded = array();
        if (!empty($_FILES['attachment']['name'])){
            $uploaded = $this->file_operation->uploadL(UPLOAD_PATH . 'EC_invoice/Attachment_message/', $_FILES);
            $data ['ATTACHMENT'] = $uploaded['attachment']['file_name'];
        }

        $attachment = !empty($attachment) ? $uploaded['attachment']['full_path'] : '';

        $this->db->insert('EC_LOG_GENERAL_MESSAGE',$data);

        $message = $this->load->view('EC_Notifikasi/rejectInvoice',$msg,TRUE);
        $subject = $subject.' [E-Invoice Semen Indonesia]';
        Modules::run('EC_Notifikasi/Email/invoiceNotifikasi',$_to,$message,$subject,'',$_cc,$_bcc,$attachment);

        $this->session->set_flashdata('msg','Pesan berhasil dikirim');
        redirect('EC_Notifikasi/Global_Message');
    }


    public function Log(){
        $data['title'] = "Log General Message";
        //$data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/EC_Log_General_Notif.js');

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');

        $this->layout->render('GlobalMessage/log',$data);
    }

    public function getLog(){
        $sql = "
            SELECT 
                GM.*,
                TO_CHAR(GM.SENT_DATE,'DD-MM-YYYY') AS SENT_DATE2
            FROM EC_LOG_GENERAL_MESSAGE GM
            ORDER BY GM.SENT_DATE DESC";
        
        $result = $this->db->query($sql)->result_array();
        
        for ($i=0; $i < count($result); $i++) { 
            $result[$i]['RECEIVER'] = implode('</br>',explode(',',$result[$i]['RECEIVER']));
            $result[$i]['CC'] = $result[$i]['CC']==NULL ? '-':implode('</br>',explode(',',$result[$i]['CC']));
            $result[$i]['BCC'] = $result[$i]['BCC']==NULL ? '-':implode('</br>',explode(',',$result[$i]['BCC']));    
        }
        
        $data['data'] = $result;
        echo json_encode($data);
    }

    public function Test(){
        /*$bcc = 'smi.einvoicegmail.com';

        if(filter_var($bcc,FILTER_VALIDATE_EMAIL)){
            echo 'email :'.$bcc.' Valid';
        }else{
            echo 'email :'.$bcc.' Tidak Valid';
        }*/
        var_dump($this->session->userdata);
    }
}
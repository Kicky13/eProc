<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Vendor extends  MX_Controller {

    private $user;
    private $user_email;
    private $vendor_no;
    public function __construct() {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->load->model("invoice/ec_e_nova",'nova');
        $this->user = $this->session->userdata('FULLNAME');
        $this->vendor_no = $this->session->userdata('VENDOR_NO');
        $this->user_email = $this->session->userdata('EMAIL');
    }

    public function index($cheat = false) {
        $data['title'] = "Module Vendor";
        $data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('bootbox.js');

        $this->layout->render('Vendor_module', $data);
    }

    public function List_Enofa() {
        $data['title'] = "List E-nofa";
        //$data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/EC_List_Enofa.js');

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('bootbox.js');

        $this->layout->render('List_Enofa',$data);
    }

    public function Form_Enofa($id = '') {
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/EC_Form_Enofa.js');
        $this->layout->add_js('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-filestyle/1.2.1/bootstrap-filestyle.min.js',TRUE);

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('bootbox.js');

        $data = array();

        if ($id == '') {
            $data['title'] = "Create E-Nofa";
            $data['url'] = 'EC_Vendor/createEno/';
        }else{
            $data['title'] = "Update E-Nofa";
            $data['url'] = 'EC_Vendor/createEno/'.$id;
            $data['value'] =$this->nova->get_Enofa("WHERE ID = $id",'');
        }

        $data['company'] = $this->session->userdata('COMPANYID');

        $this->layout->render('Create_enofa', $data);
    }

    public function createEno($id = ''){
      //$result = $this->input->post();
      $this->load->library("file_operation");
      //$uploaded ['img_enova']['file_name']= 'ads';
      
      $data = array(
          'START_NO' => $this->input->post('no_awal'),
          'END_NO' => $this->input->post('no_akhir'),
          'START_DATE' => $this->input->post('startDate'),
          'END_DATE' => $this->input->post('endDate'),
          'COMPANY' => $this->input->post('company'),
          'CREATE_BY' => $this->session->userdata('VENDOR_NO'),
        );

      if (!empty($_FILES['img_enova']['name'])){
            $uploaded = $this->file_operation->uploadL(UPLOAD_PATH . 'EC_invoice/E_Nova', $_FILES);
            $data ['IMAGE'] = $uploaded['img_enova']['file_name'];
        }

      if($id == ''){
        $this->nova->insert($data);
        $this->sendNotif($data);
      }else{
        $res = $this->nova->get_Enofa("WHERE ID = $id AND E.STATUS = 3",'');
        if(count($res)>0){
            $data['STATUS'] = 1;
            $res = $this->nova->update($data,$id);
            $this->sendNotif($data);
            redirect('EC_Vendor/List_Enofa');
        }else{
            $this->session->set_flashdata('error','Update Data Gagal, E-Nofa sudah diapprove oleh Seksi Pajak');
            redirect('EC_Vendor/List_Enofa');
        }
      }
      redirect('EC_Vendor/List_Enofa');
    }

    public function getEmail($company){
        $query = "
            SELECT USERNAME FROM EC_ROLE_USER  RU
            INNER JOIN EC_ROLE_ACCESS RA
                ON RU.ROLE_AS = RA.ROLE_AS
            WHERE RU.ROLE_AS LIKE '%SEKSI PAJAK%' 
            AND STATUS = 1
            AND OBJECT_AS = 'COMPANY_CODE'
            AND VALUE IN($company)
        ";

        $data = $this->db->query($query)->result_array();
        $email = array();
        for ($i=0; $i < count($data); $i++) { 
            $email[$i]=strtolower($data[$i]['USERNAME'].'@SEMENINDONESIA.COM');
        }
        //var_dump(array_unique($email));
        return array_unique($email);
    }

    /*SEND NOTIFICATION*/
    public function sendNotif($data = ''){
        $msg = array(
            'content' => '
                        E-Nofa Requested on '.date('d M Y H:i:s').'<br>
                        Vendor        : '.$this->vendor_no.' - '.$this->user.'<br>
                        Number Range    : '.$data['START_NO'].' - '.$data['END_NO'].'<br>
                        Validity Date     : '.$data['START_DATE'].' - '.$data['END_DATE'].'<br>',

                'title' => 'E-Nofa Registration - '.$this->vendor_no.' '.$this->user,
                'title_header' => 'Vendor '.$this->vendor_no.' - '.$this->user.' Request E-Nofa',
                'url' => 'https://int-'.str_replace('http://','',str_replace('https://', '', base_url()))
            );
        $message = $this->load->view('EC_Notifikasi/rejectInvoice',$msg,TRUE);
        $subject = 'E-Nofa Registration - '.$this->vendor_no.' '.$this->user.' [E-Invoice Semen Indonesia]';
        
        $_to = $this->getEmail($data['COMPANY']);
        Modules::run('EC_Notifikasi/Email/invoiceNotifikasi',$_to,$message,$subject);
    }

    /*
    public function sendMessage(){
        $data = $this->getRequest();
        for ($i=0; $i < count($data); $i++) {
        $msg = array(
            'content' => '
                        E-Nofa Requested on '.$data[$i]['CREATE_DATE'].'<br>
                        Vendor        : '.$data[$i]['CREATE_BY'].' - '.$data[$i]['VENDOR_NAME'].'<br>
                        Number Range    : '.$data[$i]['START_NO'].' - '.$data[$i]['END_NO'].'<br>
                        Validity Date     : '.$data[$i]['START_DATE'].' - '.$data[$i]['END_DATE'].'<br>',

                'title' => 'E-Nofa Registration - '.$data[$i]['CREATE_BY'].' '.$data[$i]['VENDOR_NAME'],
                'title_header' => 'Vendor '.$data[$i]['CREATE_BY'].' - '.$data[$i]['VENDOR_NAME'].' Request E-Nofa',
            );
        $message = $this->load->view('EC_Notifikasi/rejectInvoice',$msg,TRUE);
        $subject = 'E-Nofa Registration - '.$data[$i]['CREATE_BY'].' '.$data[$i]['VENDOR_NAME'].' [E-Invoice Semen Indonesia]';
        
        $_to = $this->getEmail();
        Modules::run('EC_Notifikasi/Email/invoiceNotifikasi',$_to,$message,$subject);
        }
    }

    public function getRequest(){
        $query = "
            SELECT 
                TO_CHAR(START_DATE,'DD-MM-YY') AS START_DATE,
                TO_CHAR(END_DATE,'DD-MM-YY') AS END_DATE,
                START_NO,
                END_NO,
                CREATE_BY,
                VENDOR_NAME,
                TO_CHAR(CREATE_DATE,'DD-MM-YY hh24:mi:ss') AS CREATE_DATE
            FROM EC_E_NOFA EN
            INNER JOIN VND_HEADER VH
                ON EN.CREATE_BY = VH.VENDOR_NO
            WHERE EN.STATUS = 1
        ";
        $data =  $this->db->query($query,false)->result_array();
        return $data;
        //var_dump($data);
    }
    */

    public function getAllEnofa(){
        $res = $this->nova->get_Enofa("WHERE CREATE_BY = $this->vendor_no AND E.STATUS IN('1','3')",'ORDER BY UPDATE_DATE DESC');
        $json_data = array('data' => $res);
        echo json_encode($json_data);
    }

    public function getApprovedEnofa(){
        $this->load->library('sap_invoice');
        $venno = array('VENDOR_NO' => $this->vendor_no);
        $res = $this->sap_invoice->getRangeFakturNo($venno);
        
        $data = array();
        for ($i=0; $i < count($res); $i++) { 
            $data['data'][$i] = array(
                'START_DATE' => stringDate($res[$i]['BEGDA']),
                'END_DATE' => stringDate($res[$i]['ENNDA']),
                'START_NO' => formatEnofa($res[$i]['FPNUML']),
                'END_NO' => formatEnofa($res[$i]['FPNUMH']),
                'APPROVED_BY' => $res[$i]['UNAME'] );
        }
        echo json_encode($data);
    }

    public function getEnofaById($id){
        $res = $this->nova->get_Enofa("WHERE ID = $id",'');

        if(count($res)>0){
            echo json_encode($res);
        }else{
            $res = array('ID' => 1 );
            echo json_encode($res);
        }        
    }

    public function deleteEnofa(){
        $id = $this->input->post('id_enofa');
        $ret['status'] = 0;
        if($this->nova->delete($id)){
            $ret['status'] = 1;
        }
        echo json_encode($ret);
    }

    public function Test(){
        //var_dump($this->session->userdata);
        echo 'https://int-'.str_replace('http://','',str_replace('https://', '', base_url()));
    }
}

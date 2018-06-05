<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class E_Nofa extends MX_Controller {

    private $user;
    public function __construct() {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->load->model("invoice/ec_e_nova",'nova');
        $this->user = $this->session->userdata('FULLNAME');
    }

    public function index() {
        $data['title'] = "List E-nofa";
        //$data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/EC_Ver_Enofa.js');

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-filestyle/1.2.1/bootstrap-filestyle.min.js',TRUE);

        $this->layout->render('enofa/list_enofa',$data);
    }


    public function getAllEnofa(){
        $role_user = $this->getUserRole();
        $company = $this->getCompany($role_user);
        $str_company = implode(',',$company);

        if(count($company)>0){
            $res = $this->nova->get_Enofa("WHERE E.STATUS = '1' AND COMPANY IN($str_company)",'ORDER BY CREATE_DATE');
            $json_data = array('data' => $res);
        }else{
            $json_data = array('data' => array());
        }
        //echo $this->db->last_query();die();
        echo json_encode($json_data);
    }

    public function verENofa(){
        $this->load->library('file_operation');
        $data = array(
            'ID' => $this->input->post('id_enova'),
            'STATUS' => $this->input->post('status'),
            'NOTE_REJECT' => $this->input->post('msg')==false ? '' : $this->input->post('msg'),
            'UPDATE_BY' => $this->user
            );
        if(!empty($_FILES['img']['name'])){
            $uploaded = $this->file_operation->uploadL(UPLOAD_PATH . 'EC_invoice/E_Nova/', $_FILES);
            $data ['PIC_REJECT'] = $uploaded['img']['file_name'];
        }

        $where = "WHERE ID = ".$data['ID']." AND E.STATUS = 1";
        $cek = $this->nova->get_Enofa($where,'');
        $ret = array('msg' => '');

        if (count($cek)>0) {
            $res = $this->nova->update_ver($data);
            if($res){

                /*Cek action. Di Approve (2) atau Direject (3)*/
                if($data['STATUS'] == 2){
                    $data_sap = array(
                        'BUKRS' => $cek[0]['COMPANYID'],
                        'LIFNR' => $cek[0]['CREATE_BY'],
                        'FPNUML' => preg_replace('/[^\p{L}\p{N}\s]/u', '', $cek[0]['START_NO']),
                        'FPNUMH' => preg_replace('/[^\p{L}\p{N}\s]/u', '', $cek[0]['END_NO']),
                        'BEGDA' => $cek[0]['START_DATE3'],
                        'ENDDA' => $cek[0]['END_DATE3'],
                        'UNAME' => $this->session->userdata('FULLNAME')
                    );
                    
                    /*Ambil data E-Nofa vedor yang sudah terdaftar*/
                    $this->load->library('sap_invoice');
                    $val = $this->sap_invoice->getRangeFakturNo(array('VENDOR_NO' => $cek[0]['CREATE_BY']));
                    
                    /*Set default Status*/
                    $status = 1;

                    /*Cek apakah no faktur yang akan diapprove sudah terdaftar*/
                    for ($i=0; $i < count($val); $i++) { 
                        if($val[$i]['FPNUML'] == $data_sap['FPNUML']){
                            $status = 0;
                        }
                    }

                    /*Ketika belum terdaftar maka akan lanjut ke proses berikutnya*/
                    if($status == 1){
                        $return = $this->sap_invoice->setEnofa($data_sap);
                        if($return[0]['TYPE'] == 'S'){
                            //$ret['status'] = 1;
                            $ret['msg'] = 'E-Nofa berhasil di Approve';
                            $this->sendNotif($cek[0],'Approved');
                        }else{
                            $data['STATUS'] = 1;
                            $this->nova->update_ver($data);
                            $ret['msg'] = 'E-Nofa gagal di Approve';
                        }
                    }else{ //Ketika sudah terdaftar maka akan memberi keterangan
                        $data['STATUS'] = 1;
                        $this->nova->update_ver($data);
                        $ret['msg'] = 'E-Nofa gagal di Approve, No Faktur sudah terdaftar di SAP';
                    }
                }else{
                    //$ret['status'] = 1;
                    $ret['msg'] = 'E-Nofa berhasil di Reject';
                    $this->sendNotif($cek[0],'Rejected',$data['NOTE_REJECT']);
                }
            }
        }else{
            $ret['msg'] = 'E-Nofa Telah Dihapus Oleh Vendor';
        }
        echo json_encode($ret);
    }

    public function getApprovedEnofa(){
        $this->load->library('sap_invoice');
        $res = $this->sap_invoice->getRangeFakturNo();
        $data = array();
        $today = date('Ymd');
        $role_user = $this->getUserRole();
        $company = $this->getCompany($role_user);
        if(count($company)>0){
            for ($i=0; $i < count($res); $i++) {
                if($today <= clean($res[$i]['ENNDA'])){
                    $in = isset($data['data']) ? count($data['data']) : 0;
                    $data['data'][$in] = array(
                        'START_DATE' => stringDate($res[$i]['BEGDA']),
                        'END_DATE' => stringDate($res[$i]['ENNDA']),
                        'START_NO' => formatEnofa($res[$i]['FPNUML']),
                        'END_NO' => formatEnofa($res[$i]['FPNUMH']),
                        'VENDOR' => $res[$i]['LIFNR'].' - '.$res[$i]['NAME1']);
                }
            }
        }else{$data['data']=array();}
        echo json_encode($data);
    }

    /*SEND NOTIFICATION*/
    public function sendNotif($data = '',$status = '',$note = ''){
        $msg = array(
            'content' => '
                        E-Nofa Verified on '.date('d M Y H:i:s').'<br>
                        Request on      : '.$data['CREATE_DATE2'].'<br>
                        Number Range    : '.$data['START_NO'].' - '.$data['END_NO'].'<br>
                        Validity Date   : '.$data['START_DATE2'].' - '.$data['END_DATE2'].'<br>',
                'title' => 'E-Nofa Registration '.$status.' By '.$this->user,
                'title_header' => 'E-Nofa Registration '.$status.' By '.$this->user,
            );

        if($note!=''){
            $msg['content'] .= 'Note       : "<b style="color:red">'.$note.'</b>"';
        }

        $message = $this->load->view('EC_Notifikasi/rejectInvoice',$msg,TRUE);
        $subject = 'E-Nofa Registration '.$status.' By '.$this->user.' [E-Invoice Semen Indonesia]';
        
        $_to = $data['EMAIL_ADDRESS'];
        Modules::run('EC_Notifikasi/Email/invoiceNotifikasi',$_to,$message,$subject);
    }

    /*LIST FAKTUR PAJAK INVOICE APPROVED*/
    public function listFaktur(){
        $data['title'] = "List Faktur Pajak";

        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/EC_List_Faktur.js');

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->add_css('plugins/daterangepicker/daterangepicker.css');
        $this->layout->add_js('plugins/daterangepicker/daterangepicker.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('bootbox.js');

        $role_user = $this->getUserRole();
        $company = $this->getCompany($role_user);
        $str_company = implode(',',$company);

        $data['company'] = $str_company;
        $this->layout->render('enofa/list_faktur',$data);
    }

    public function getDataFakturApproved($status = ''){
        $filter_data = $this->input->post('columns');
        $order = $this->input->post('order');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $field = array('CREATE_ON'
                ,'FAKTUR_PJK'
                ,'F_FKT_DATE'
                ,'UP_NO_INV'
                ,'MIR'
                ,'VENDOR'
                ,'AMOUNT'
                ,'F_CRE_ON'
                );
        $where = array();
        if($status != ''){
            $where['F_STAT'] = $status;
        }
        $order_by = '';
        $limit = array('limit' => $length, 'offset' => $start);

        for ($i=0; $i < count($filter_data) ; $i++) {
            if($filter_data[$i]['search']['value'] != '' ){
                if($i == 2 || $i == 7){
                    $basic = $filter_data[$i]['search']['value'];
                    $all = explode(' - ',$basic);
                    
                    /*Mengubah Format DD-MM-YY menjadi YYYYMMDD*/
                    $rDate = array(
                        implode(array_reverse(explode('-',$all[0]))),
                        implode(array_reverse(explode('-',$all[1])))
                        );
                    $where[$field[$i]]['data'][0] = $rDate[0];
                    $where[$field[$i]]['data'][1] = $rDate[1];
                    $where[$field[$i]]['id'] = 'dRange';
                }else{
                    $where[$field[$i]] = strtoupper($filter_data[$i]['search']['value']);
                }
            }
        }

        if(isset($order[0]['column'])){
            $col = $order[0]['column'];
            $order_by[] = $field[$col];
            $order_by[] = $order[0]['dir'];
        }

        $role_user = $this->getUserRole();
        $company = $this->getCompany($role_user);
        $str_company = implode(',',$company);

        $res = $this->nova->getListFaktur($where,$order_by,$limit,$str_company);

        $data = array();
        if(!empty($res)){
            for ($i=0; $i < count($res); $i++) {
                $url = base_url('upload/EC_invoice').'/'.$res[$i]['FAKPJK_PIC'];
                $url = str_replace('https://int-', '', $url);
                $url = str_replace('http://int-', '', $url);
                $url = 'https://'.$url;
                $row = array();
                
                $l_report = $res[$i]['F_STATUS']=='UNREPORTED' ? "&nbsp;&nbsp;<a href='javascript:void(0)' data-id_invoice='".$res[$i]['ID_INVOICE']."' onClick='reportFaktur(this)' title='Laporkan Faktur'><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span></a>" : '';
                
                $no_faktur = $res[$i]['FAKTUR_PJK'];
                $row[] = $res[$i]['RNUM'];
                $row[] = "<a href = $url target=_blank>$no_faktur</a>";
                $row[] = $res[$i]['FKT_DATE'];
                $row[] = $res[$i]['NO_INVOICE'];
                $row[] = $res[$i]['MIR'];
                $row[] = $res[$i]['VENDOR'];
                $row[] = $res[$i]['CURRENCY'].' '.ribuan($res[$i]['AMOUNT']);
                $row[] = $res[$i]['CREATE_ON'];

                $row[] = "<div class='col-md-12 text-center'> <a href='javascript:void(0)' data-id_invoice='".$res[$i]['ID_INVOICE']."' data-toggle=\"modal\" data-target=\"#detailFaktur\" title='Detail Faktur'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></a>".$l_report."&nbsp;&nbsp;<input type='checkbox' data-id_invoice='".$res[$i]['ID_INVOICE']."'></div>";

                $data[] = $row;
            }
        }
        $output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $this->nova->countAllData('',$str_company),
                "recordsFiltered" => $this->nova->countAllData($where,$str_company),
                "data" => $data
            );
        //echo $this->db->last_query();
        echo json_encode($output);
    }


    public function getDetailItem($id_invoice){
        $where = array('ID_INVOICE'=>$id_invoice);

        $role_user = $this->getUserRole();
        $company = $this->getCompany($role_user);
        $str_company = implode(',',$company);

        /*SET DATA HEADER*/
        $res = $this->nova->getFaktur($where,$str_company);

        $role_user = $this->getUserRole();
        $company = $this->getCompany($role_user);
        $str_company = implode(',',$company);

        $data = array('H' => $res[0]);
        $data['H']['AMOUNT'] = $data['H']['CURRENCY'].' '.ribuan($data['H']['AMOUNT']);
        $data['H']['XML'] = $data['H']['XML_FAKTUR'].$data['H']['XML_FAKTUR2'];

        /*SET DATA ITEM*/
        $where = array('IH.ID_INVOICE'=>$id_invoice);
        $data['I'] = $this->nova->getItemDetail($where);
        for ($i=0; $i < count($data['I']); $i++) {
            $data['I'][$i]['AMOUNTS'] = $data['I'][$i]['GR_CURRENCY'].' '.ribuan($data['I'][$i]['AMOUNTS']);
        }

        echo json_encode($data);
    }

    public function reportFaktur(){
        $id_invoice = $this->input->post('id_invoice');

        $this->load->model('ec_open_inv');
        $invoice = $this->ec_open_inv->get_Invoice('WHERE EIH.ID_INVOICE='.$id_invoice,'');

        

        $data = array(
            'FAKTUR_NO' => $invoice[0]['FAKTUR_PJK'],
            'REPORTED_BY' => $this->session->userdata('FULLNAME'));

        $res = $this->db->insert('EC_FAKTUR_REPORT',$data);
        $ret['status'] = 0;
        $ret['faktur'] = $data['FAKTUR_NO'];

        if($res){
            $ret['status'] = 1;
        }

        echo json_encode($ret);
    }

    public function printFaktur(){
        $this->load->library('M_pdf');
        
        $where = array('F_STAT' => $this->input->post('tab'));
        $id = $this->input->post('id_invoice');

        $id_inv = implode(',',$id);
        $company = $this->input->post('company');

        // get data dari database
        $res = $this->nova->getListDownload($where,$id_inv,$company);

        $data = array();
        for ($i=0; $i < count($res); $i++) { 
            $data['image'][] = $res[$i]['FAKPJK_PIC'];
            $data['list_faktur'][$i][] = $res[$i]['FAKTUR_PJK'];
            $data['list_faktur'][$i][] = $res[$i]['FKT_DATE'];
            $data['list_faktur'][$i][] = $res[$i]['NO_INVOICE'];
            $data['list_faktur'][$i][] = $res[$i]['MIR'];
            $data['list_faktur'][$i][] = $res[$i]['VENDOR'];
            $data['list_faktur'][$i][] = $res[$i]['CURRENCY'].' '.ribuan($res[$i]['AMOUNT']);
            $data['list_faktur'][$i][] = $res[$i]['CREATE_ON'];
            $data['list_faktur'][$i][] = $res[$i]['URL_FAKTUR'];
        }
        //var_dump($data);die();
        //mengambil dan menentukan data yang akan didownload
        $act = $this->input->post('act');
        if($act == 'I'){ // download image
            $mpdf = new M_pdf();
            $mpdf->pdf->SetImportUse();
            $pdfExt = array('pdf');
            foreach($data['image'] as $s){
                $mpdf->pdf->AddPage();
                $f = 'upload/EC_invoice/'.$s;
                $ext = pathinfo($f, PATHINFO_EXTENSION);

                if(in_array(strtolower($ext),$pdfExt)){
                    $pagecount = $mpdf->pdf->SetSourceFile($f);
                    $tplId = $mpdf->pdf->ImportPage($pagecount);
                    $mpdf->pdf->UseTemplate($tplId);
                }else{
                    $html = '<img src="'.$f.'" />';
                    $mpdf->pdf->WriteHTML($html);
                }
            }
            $mpdf->pdf->Output();
        }else if($act == 'F'){ // download faktur
            $this->load->library('Excel');
            $excel = new PHPExcel();
            $excel->setActiveSheetIndex(0)
                ->setCellValue('B2', 'NO.')
                ->setCellValue('C2', 'NO. Faktur')
                ->setCellValue('D2', 'Tanggal Faktur')
                ->setCellValue('E2', 'NO. Invoice')
                ->setCellValue('F2', 'NO. MIR')
                ->setCellValue('G2', 'Vendor')
                ->setCellValue('H2', 'Amount')
                ->setCellValue('I2', 'Approved On')
                ->setCellValue('J2', 'URL Faktur');
            $excel->getActiveSheet()->setTitle('List Faktur Pajak');

            $no = 3;
            foreach ($data['list_faktur'] as $value) {
                $nomer = $no-2;
                for ($i=0; $i < count($value); $i++) { 
                    $excel->setActiveSheetIndex(0)
                        ->setCellValue("B$no","$nomer")
                        ->setCellValue("C$no",$value[0])
                        ->setCellValue("D$no",$value[1])
                        ->setCellValue("E$no",$value[2])
                        ->setCellValue("F$no",$value[3])
                        ->setCellValue("G$no",$value[4])
                        ->setCellValue("H$no",$value[5])
                        ->setCellValue("I$no",$value[6])
                        ->setCellValue("J$no",$value[7]);
                }
                $no++;
            }

            $no--;
            // Mengatur Align Header
            $align = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
            );

            $border = array(
              'borders' => array(
                'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
                )
              )
            );

            foreach(range('B','J') as $columnID) {
                $excel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }

            $excel->getActiveSheet()->getStyle("B2:J2")->applyFromArray($align);
            $excel->getActiveSheet()->getStyle("B2:B$no")->applyFromArray($align);
            $excel->getActiveSheet()->getStyle("B2:J$no")->applyFromArray($border);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Data Faktur Pajak.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
        }else{
            echo 'Anda tidak memiliki hak akses disini';
        }
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

    public function Test(){
        $data = array('','A',NULL,'123',FALSE,'OK',TRUE,'96');

        var_dump($data);
        var_dump(count($data));

        var_dump(array_filter($data));
        var_dump(count(array_filter($data)));
    }
}
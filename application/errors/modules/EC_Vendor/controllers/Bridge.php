<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class E_Nofa extends CI_Controller {

    private $user;
    public function __construct() {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        //$this->load->library('Layout');
        //$this->load->helper("security");
        $this->load->model("invoice/ec_e_nova",'nova');
        $this->user = $this->session->userdata('FULLNAME');
    }

    /*LIST FAKTUR PAJAK INVOICE APPROVED*/
     public function printFaktur(){
        $this->load->library('M_pdf');
        $filter_data = $this->input->post('filter');
        /*Inisialisasi Field yang Di Filter*/
        $field = array('F_STAT'
                ,'FAKTUR_PJK'
                ,'F_FKT_DATE'
                ,'UP_NO_INV'
                ,'MIR'
                ,'VENDOR'
                ,'AMOUNT'
                ,'F_CRE_ON'
                );
        //Inisialisasi Array untuk filter
        $where = array();
        for ($i=0; $i < count($filter_data) ; $i++) {
            if($filter_data[$i] != '' ){
                if($i == 2 || $i == 7){
                    $basic = $filter_data[$i];
                    $all = explode(' - ',$basic);
                    
                    $rDate = array(
                        implode(array_reverse(explode('-',$all[0]))), 
                        implode(array_reverse(explode('-',$all[1])))
                        );
                    $where[$field[$i]]['data'][0] = $rDate[0];
                    $where[$field[$i]]['data'][1] = $rDate[1];
                    $where[$field[$i]]['id'] = 'dRange';
                }else{
                    $where[$field[$i]] = strtoupper($filter_data[$i]);
                }
            }
        }

        //mendapatkan code company untuk filter berdasarkan hak akses user
        $role_user = $this->getUserRole();
        $company = $this->getCompany($role_user);
        $str_company = implode(',',$company);

        // get data dari database
        $res = $this->nova->getListDownload($where,$str_company);

        //mengambil data nama image 'image' dan no faktur 'list_faktur'
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
        }

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
                ->setCellValue('I2', 'Approved On');
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
                        ->setCellValue("I$no",$value[6]);
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

            $excel->getActiveSheet()->getStyle("B2:C2")->applyFromArray($align);
            $excel->getActiveSheet()->getStyle("B2:I$no")->applyFromArray($border);

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
        $xmls = simplexml_load_file('http://svc.efaktur.pajak.go.id/validasi/faktur/704105535648000/0091705731332/93a2bc05e7e4bd0311a3bcb504e1e1eaa3b1949ed6040939f8cb6c8b47e6625b');


        $db = $this->db->get('EC_XML_PAJAK')->result_array();

        var_dump($db);

        $xml = simplexml_load_string($db[0]['XML_FAKTUR']);

        echo $xml->kdJenisTransaksi.'<br><br><br><br>';
        echo $xml->detailTransaksi[0]->nama.'<br>'.count($xml->detailTransaksi).'<br><br><br>';

        var_dump($xml);

        /* 
                    PHP EXCEL MERGE CELL
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:B1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Swapnesh');
    
                    PHP EXCEL AUTO COLUMN SIZE
        foreach(range('B','G') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

                    PHP EXCEL

        */
    }
}

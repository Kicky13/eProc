<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bridge extends CI_Controller {

    private $user;
    public function __construct() {
        parent::__construct();
        //$this->load->library('Authorization');
        $this->load->helper('url');
        //$this->load->library('Layout');
        //$this->load->helper("security");
        $this->load->model("invoice/ec_e_nova",'nova');
        $this->user = $this->session->userdata('FULLNAME');
    }

    public function index(){
        echo 'HERE';
    }

    public function printFaktur(){
        $this->load->library('M_pdf');

        $where = array('F_STAT' => $this->input->post('tab'));
        $id = $this->input->post('id_invoice');

        $id_inv = implode(',',$id);
        $company = $this->input->post('company');

        echo $where['F_STAT'].' = '.$id_inv;
        // get data dari database
        $res = $this->nova->getListDownload($where,$id_inv,$company);
        //var_dump($res);die();

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

            foreach(range('B','I') as $columnID) {
                $excel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }

            $excel->getActiveSheet()->getStyle("B2:I2")->applyFromArray($align);
            $excel->getActiveSheet()->getStyle("B2:B$no")->applyFromArray($align);
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
        $data = array('image'=>array('7b8b9f68fa8637a5e3303f81fc94c4c9.pdf','92c9eb9f643a8e7362febbb7adca73eb.pdf'));
        //92c9eb9f643a8e7362febbb7adca73eb.pdf
        //7b8b9f68fa8637a5e3303f81fc94c4c9.pdf
        $mpdf = new M_pdf();
            $mpdf->pdf->SetImportUse();
            $pdfExt = array('pdf');
            foreach($data['image'] as $s){
                $mpdf->pdf->AddPage();
                $f = 'upload/EC_invoice/Test/'.$s;
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
    }

    function check_pdf(){
        $part = base_url('upload/EC_invoice/Test/92c9eb9f643a8e7362febbb7adca73eb.pdf');
        echo $part;
        $escPath = str_replace( " ", "\\ ", escapeshellcmd( $part ) );
        $out = shell_exec( 'pdfinfo ' . $escPath . ' 2>&1' );
        if( $out != null && !preg_match( '~Error~i', $out ) )
            echo "GOOD: $part\n";
        else
            echo "CORRUPT: $part\n";
    }

    function pdf_recreate($f = '')
    {
        $f = '92c9eb9f643a8e7362febbb7adca73eb.pdf';
        rename($f,str_replace('.pdf','_.pdf',$f));

        $fileArray=array(str_replace('.pdf','_.pdf',$f));
        $outputName=$f;
        $cmd = "gs -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=$outputName ";

        foreach($fileArray as $file)
        {
          $cmd .= $file." ";
        }
        $result = shell_exec($cmd);
        unlink(str_replace('.pdf','_.pdf',$f));

    }
}

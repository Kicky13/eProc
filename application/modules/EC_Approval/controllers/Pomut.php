<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pomut extends MX_Controller {

    private $user;
    private $user_email;

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->user = $this->session->userdata('FULLNAME');
        $this->user_email = $this->session->userdata('EMAIL');
        $this->load->model('invoice/ec_pomut', 'pm');
    }

    public function index() {
        $this->load->library('Authorization');
        $data['title'] = "Approval BA Analisa Mutu";
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();

        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/invoice/common.css');        

        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/EC_List_Cronjob.js');
        $this->layout->add_js('pages/invoice/Approval_pomut.js');
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->render('EC_Approval/pomut/list', $data);
    }
    
    public function data() {
        $plant = implode("','", $this->listPlantAccess());
        $level = implode("','", $this->listLevelAccess());
        $data = $this->pm->getDataHeader($plant, $level);
        //echo $this->db->last_query();
        echo json_encode(array('data' => $data));
    }

    public function detail() {
        $data['title'] = "Detail BERITA ACARA Analisa Mutu";
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/invoice/Approval_pomut_detail.js');


        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');

        $data['ba_no'] = $this->input->post('ba_no');
        $data['po_no'] = $this->input->post('po_no');
        $data['material'] = $this->input->post('material');
        $data['vendor'] = $this->input->post('vendor');

        $act = $this->input->post('act');

        $data['act'] = $act;

        $data['header'] = $this->pm->getSingleHeader($data['ba_no']);
        $data['detail'] = $this->pm->getDataDetail($data['ba_no']);


        $level = $this->listLevelAccess();
        $data['status'] = $level[0] + 1;

        if ($act == 'view')
            $data['status'] = 2;

        $data['url'] = $data['status'] == 1 ? base_url('EC_Approval/Pomut/createBA') : base_url('EC_Approval/Pomut/approvalBA');

        //var_dump($data);die();
        $this->layout->render('EC_Approval/pomut/detail', $data);
    }

    public function createBA() {
        $data_update = $this->input->post();
        $no_ba = $this->input->post('NO_BA');
        $data_update['CREATED_BY'] = $this->user;
        $data_update['STATUS'] = 1;        
        $data_BA = $this->db->where(array('NO_BA' => $no_ba))->get('EC_POMUT_HEADER_SAP')->result_array();
        $data_BA['1'] = $data_update;
        $data_BA['header'] = $this->pm->getSingleHeader($no_ba);
        $data_BA['detail'] = $this->pm->getDataDetail($no_ba);
        $data_BA['personal']=$this->db->where(array('FULLNAME'=>$data_BA['1']['KASI_PENGADAAN']))->get('ADM_EMPLOYEE')->row_array();
//        var_dump($data_BA);die();          
        $this->db->set('TGL_BA', 'TO_DATE(\'' . $data_update['TGL_BA'] . '\',\'DD-MM-YYYY\')', FALSE);
        $this->db->set('CREATED_AT', 'SYSDATE', FALSE);
        unset($data_update['TGL_BA']);
        $act = $this->db->where('NO_BA', $no_ba)->update('EC_POMUT_HEADER_SAP', $data_update);
//        $this->notifikasiCreateBA($data_BA);   
        if ($act) {
            $pesan = 'Create Berita Acara No.' . $no_ba . ' BERHASIL';
            $data_BA = $this->db->where(array('NO_BA' => $no_ba))->get('EC_POMUT_HEADER_SAP')->result_array();
            $this->notifikasiCreateBA($data_BA);            
            $this->session->set_flashdata('message', $pesan);
            redirect('EC_Approval/Pomut');
        } else {
            die('GAGAL');
        }
    }

    public function approvalBA() {
        $this->load->library('sap_invoice');
        $data_update = $this->input->post();
        // var_dump($this->input->post());die();
        $no_ba = $this->input->post('NO_BA');
        $printApproval=$this->sap_invoice->setPrintBA($no_ba);
//        var_dump($printApproval);die();
        unset($data_update['TGL_BA']);

        $data_update['APPROVED_BY'] = $this->user;
        $data_update['STATUS'] = 2;
        $data['header'] = $this->pm->getSingleHeader($no_ba);
        $data['detail'] = $this->pm->getDataDetail($no_ba);
        $data['info_vendor']=$this->db->where(array('VENDOR_NO'=>$data['header']['LIFNR']))->get('VND_HEADER')->row_array();   
        // var_dump($data);die();     
//        var_dump($data);  
        $jumlahGr=count($data['detail']);
        // $this->notifikasiApprovalBA($data); die();
        for($i=0;$i<$jumlahGr;$i++){            
             $data['gr'][$i]=$this->db->where(array('PO_NO'=>$data['header']['EBELN'], 'GR_NO'=>$data['detail'][$i]['MBLNR'], 'PO_ITEM_NO'=>$data['detail'][$i]['LOTQTY']))->get('EC_GR_STATUS')->row_array();            
             if($data['gr'][$i]['STATUS']==2){
                 $data['gr'][$i]['KETERANGAN_STATUS']='Sudah Approve Kasi';
             }else if($data['gr'][$i]['STATUS']==3){
                 $data['gr'][$i]['KETERANGAN_STATUS']='Sudah Approve Kabiro';
             }else if($data['gr'][$i]['STATUS']==1){
                 $data['gr'][$i]['KETERANGAN_STATUS']='Lot Telah dibuat';
             }else {
                 $data['gr'][$i]['KETERANGAN_STATUS']='Lot Belum dibuat';
             }
        }                  
//        var_dump($data);die();
        $this->db->set('APPROVED_AT', 'SYSDATE', FALSE);

        $act = $this->db->where('NO_BA', $no_ba)->update('EC_POMUT_HEADER_SAP', $data_update);

        if ($act) {
            $this->notifikasiApprovalBA($data); 
            $pesan = 'Approval Berita Acara No.' . $no_ba . ' BERHASIL';
            $this->session->set_flashdata('message', $pesan);
            redirect('EC_Approval/Pomut');
        } else {
            die('GAGAL');
        }
    }

    public function cetakBeritaAcara() {
        $this->load->config('ec');

        //var_dump($this->input->post());die();

        $data['no_ba'] = $this->input->post('no_ba');

        $data['header'] = $this->pm->getSingleHeader($data['no_ba']);
//        var_dump($data['header']);die();
        $data['detail'] = $this->pm->getDataDetail($data['no_ba']);

        $data['kota'] = $data['header']['KOTA'] == null ? $this->input->post('kota') : $data['header']['KOTA'];
        $data['kasi'] = $data['header']['KASI_PENGADAAN'] == null ? $this->input->post('kasi') : $data['header']['KASI_PENGADAAN'];

        $tgl_ba = $data['header']['TGL_BA2'] == null ? $this->input->post('tgl_ba') : $data['header']['TGL_BA2'];
        $data['tgl_ba'] = $this->getDetailDay($tgl_ba);

        $company_data = $this->config->item('company_data');

        $data['delivery'] = $this->getFromToDate($data['no_ba']);
        $date=$data['header']['TGL_BA2'];
        $newformat = explode("-",$date);
        if($data['header']['BUKRS']=='7000' && $newformat[2]=='2017'){
            $data['company'] = $company_data['7kso'];
        }else{
            $data['company'] = $company_data[$data['header']['BUKRS']];
        }

        $data['formula'] = $this->getFormula($data['no_ba']);
        $data['harga_satuan']=$data_BA['personal']=$this->db->where(array('NO_BA'=>$data['no_ba']))->get('EC_POMUT_HEADER_SAP')->row_array();                
//        var_dump($data['detail']);die();
        
        $html = $this->load->view('pomut/cetak', $data, TRUE);

        $this->load->library('M_pdf');
        $mpdf = new M_pdf();
        $mpdf->pdf->writeHTML($html);
        $mpdf->pdf->output('Berita Acara Analisa Mutu - ' . $data['no_ba'] . '.pdf', 'I');
    }

    private function getFormula($no_ba) {
        return $this->db->select('NO_BA,JENIS_FORMULA,MKMNR,MIC_DESC,OPERATOR,FORMULA')->where('NO_BA', $no_ba)->group_by('NO_BA,JENIS_FORMULA,MKMNR,MIC_DESC,OPERATOR,FORMULA')->get('EC_POMUT_FORMULA_SAP')->result_array();
    }

    private function getFromToDate($no_ba) {
        $sql = "
			SELECT 	min(TGL_FROM) TGL_FROM
					,max(TGL_TO) TGL_TO 
			FROM EC_POMUT_DETAIL_SAP 
			WHERE NO_BA = '$no_ba'";
        return $this->db->query($sql, false)->row_array();
    }

    private function listPlantAccess() {
        $this->user_email = $this->session->userdata('EMAIL'); // login pakai email tanpa semen indonesia.com
        /* dapatkan role untuk fitur verifikasi ini */
        $this->load->model('invoice/ec_role_user', 'role_user');
        $email_login = explode('@', $this->user_email);
        $plant = array();
        $_tmp = $this->db->where(array('USERNAME' => $email_login[0], 'STATUS' => 1))->like('ROLE_AS', 'GUDANG', 'after')->get('EC_ROLE_USER')->result_array();
        $role = array();
        if (!empty($_tmp)) {
            foreach ($_tmp as $_t) {
                array_push($role, $_t['ROLE_AS']);
            }
            $this->load->model('invoice/ec_role_access', 'era');
            $era = $this->db->where('OBJECT_AS = \'PLANT\' AND ROLE_AS in (\'' . implode('\',\'', $role) . '\')')->get('EC_ROLE_ACCESS')->result_array();
            if (!empty($era)) {
                foreach ($era as $_p) {
                    $plant = array_merge($plant, explode(',', $_p['VALUE']));
                }
            }
        }
        /* cari plant untuk role yang dimiliki */
        return array_unique($plant);
    }

    private function listLevelAccess() {
        $this->user_email = $this->session->userdata('EMAIL'); // login pakai email tanpa semen indonesia.com
        /* dapatkan role untuk fitur verifikasi ini */
        $this->load->model('invoice/ec_role_user', 'role_user');
        $email_login = explode('@', $this->user_email);
        $level = array();
        $_tmp = $this->db->where(array('USERNAME' => $email_login[0], 'STATUS' => 1))->like('ROLE_AS', 'APPROVAL ANALISA MUTU', 'after')->get('EC_ROLE_USER')->result_array();

        $role = array();
        if (!empty($_tmp)) {
            foreach ($_tmp as $_t) {
                array_push($role, $_t['ROLE_AS']);
            }
            $this->load->model('invoice/ec_role_access', 'era');
            $era = $this->db->where('OBJECT_AS = \'LEVEL\' AND ROLE_AS in (\'' . implode('\',\'', $role) . '\')')->get('EC_ROLE_ACCESS')->result_array();
            if (!empty($era)) {
                foreach ($era as $_p) {
                    /* kurangkan 1 supaya menghasilkan level dibawahnya, level 1 itu menjadikan status gr menjadi 1, jadi status sebelumnya 0 ( level - 1 ) */
                    $level = array_merge($level, explode(',', $_p['VALUE'] - 1));
                }
            }
        }
        /* cari plant untuk role yang dimiliki */
        return array_unique($level);
    }

    public function getDetailDay($tgl) { // DD-MM-YYYY
        $temp = substr($tgl, 6, 4) . '-' . substr($tgl, 3, 2) . '-' . substr($tgl, 0, 2);

        $temp_M = substr($tgl, 3, 2);
        $temp_D = substr($tgl, 0, 2);
        $temp_Y = substr($tgl, 6, 4);

        $date = strtotime($temp);
        $temp_day = date('D', $date);

        $hari = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => "Jum'at",
            'Sat' => 'Sabtu'
        );

        $bulan = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember');
        return array(
            'tanggal_angka' => $tgl,
            'tanggal_lengkap' => $temp_D . ' ' . $bulan[$temp_M] . ' ' . $temp_Y,
            'hari' => $hari[$temp_day],
            'tanggal' => $temp_D,
            'bulan' => $bulan[$temp_M],
            'tahun' => $temp_Y
        );
    }

    public function ReportBA() {
        $this->load->library('Authorization');
        $data['title'] = "REPORT BA Potongan Mutu";
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();

        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/invoice/common.css');        

        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/invoice/EC_common.js');        
        $this->layout->add_js('pages/invoice/Approval_pomut_report.js');
        $this->layout->render('EC_Approval/pomut/listReport', $data);        
    }

    public function dataReport($status = 3) {
        $status = $status == 1 ? "1','2" : $status;
        $data = $this->pm->getDataReport($status);
        echo json_encode(array('data' => $data));
    }

    public function Test() {
        $data = $this->db->get('EC_POMUT_DETAIL_SAP')->result_array();
        var_dump($data);
    }
    
    public function notifikasiCreateBA($data_BA) {                
        $table = '';
        if (!empty($data_BA)) {
            $table = $this->buildTable($data_BA);
        }
        $data = array(
            'content' => '					
                                        <table border=1 width="700" style="font-size:10px;border-style:none;" class="tanpa-border">
                                            <tr>
                                                <td>VENDOR</td>
                                                <td>:</td>
                                                <td> '.$data_BA[0]['NAME1'].'</td>
                                            </tr>
                                            <tr>
                                                <td>NO.PO</td>
                                                <td>:</td>
                                                <td> '.$data_BA[1]['PO'].'</td>
                                            </tr>
                                            <tr>
                                                <td>NO.BA</td>
                                                <td>:</td>
                                                <td> '.$data_BA[1]['NO_BA'].'</td>
                                            </tr>
                                            <tr>
                                                <td>TANGGAL BA</td>
                                                <td>:</td>
                                                <td> '.$data_BA[1]['TGL_BA'].'</td>
                                            </tr>
                                            <tr>
                                                <td>MATERIAL</td>
                                                <td>:</td>
                                                <td> '.$data_BA[1]['MATERIAL'].'</td>
                                            </tr>                                                                                        
                                        </table>
                                        <br>
                                        <h2 style="text-align:center;">DETAIL BERITA ACARA ANALISA MUTU</h2>'.$table.'<br><hr>',
            'title' => 'BA Analisa Mutu ' . $data_BA[0]['NO_BA'] . ' Menunggu Approval Anda',
            'title_header' => 'NO. BA Analisa Mutu ' . $data_BA[0]['NO_BA'] . ' Berhasil di Create',
        );         
        $message = $this->load->view('EC_Notifikasi/BAmutu', $data, TRUE);
//        $message = $this->load->view('EC_Notifikasi/BAmutu', $data);
        $_to = $data_BA['personal']['EMAIL'];        
//        $_to ='yuwaka33@gmail.com';
        $subject = 'BA Analisa Mutu dengan NO. BA: ' .  $data_BA[0]['NO_BA'] . ' [E-Invoice Semen Indonesia]';
        Modules::run('EC_Notifikasi/Email/invoiceNotifikasi', $_to, $message, $subject);
    }
    
    public function notifikasiApprovalBA($data_BA) {  
//        var_dump($data_BA);die();
        $table = '';
        $tableGr='';
        if (!empty($data_BA)) {
            $table = $this->buildTable($data_BA);
            $tableGr = $this->buildTableStatus($data_BA);
        }
        $data = array(
            'content' => '<h2 style="text-align:center;">DETAIL BERITA ACARA ANALISA MUTU</h2>'.$table.'<br/>'
            . '<h2 style="text-align:center;">STATUS GR</h2>'.$tableGr.'<hr>',
            'title' => 'BA Analisa Mutu ' . $data_BA['header']['NO_BA'] . ' Menunggu Approval Anda',
            'title_header' => 'BA Analisa Mutu ' . $data_BA['header']['NO_BA'] . ' Berhasil di Approve',            
        );                
        $message = $this->load->view('EC_Notifikasi/BAmutu', $data, TRUE);
        $_to = 'yuwaka33@gmail.com';
//        $_to =$data_BA['info_vendor']['EMAIL_ADDRESS'];
        $subject = 'BA Analisa Mutu: ' .  $data_BA['header']['NO_BA'] . ' [E-Invoice Semen Indonesia]';
        Modules::run('EC_Notifikasi/Email/invoiceNotifikasi', $_to, $message, $subject);
    }
    
    private function buildTable($dataBA) {        
        $tableGR = array(
            '<table border=1 style="font-size:10px;width:100%;border-style:solid;text-align:center;">'
        );        
        $thead = '<thead>
            <tr>
                <th rowspan="2"> Insp. Lot / No. Gr</th>
                <th rowspan="2"> Qty</th>
                <th rowspan="2"> Harga Satuan</th>
                <th rowspan="2"> Total Harga</th>
                <th colspan="3"> Hasil Analisa</th>
                <th colspan="3"> Jumlah Potongan</th>
                <th rowspan="2"> Harga Satuan / Stl Potongan</th>
                <th rowspan="2"> Jumlah Pembayaran</th>
                <th rowspan="2"> Status</th>
              </tr>                              ';
        $dataBA['header']['MIC1'] == NULL ? $satu='-' : $satu=$dataBA['header']['MIC1'];
        $dataBA['header']['MIC2'] == NULL ? $dua='-' : $dua=$dataBA['header']['MIC2'];
        $dataBA['header']['MIC3'] == NULL ? $tiga='-' : $tiga=$dataBA['header']['MIC3'];
        $dataBA['header']['MIC1'] == NULL ? $satur='-' : $satur=$dataBA['header']['MIC1'];
        $dataBA['header']['MIC2'] == NULL ? $duar='-' : $duar=$dataBA['header']['MIC2'];
        $dataBA['header']['MIC3'] == NULL ? $tigar='-' : $tigar=$dataBA['header']['MIC3'];
        $thead2='<tr>
                    <th> '.$satu.'</th>
                    <th> '.$dua.'</th>
                    <th> '.$tiga.'</th>
                    <th> '.$satur.'</th>
                    <th> '.$duar.'</th>
                    <th> '.$tigar.'</th>
              </tr>
              </thead>';
        $tbody = array();        
        $total_harga = 0;
        $total_Bayar = 0;
        $total_qty = 0;
        foreach ($dataBA['detail'] as $d) {
            $_tr = '<tr>
                            <td> '.$d['PRUEFLOS'].'/'.$d['MBLNR'].'</td>
                            <td> '.$d['LOTQTY'].'</td>
                            <td> '.ribuan($d['HARSAT']).'</td>
                            <td> '.ribuan($d['POVALUE']).'</td>
                            <td> '.$d['ORI_INPUT1'].'</td>
                            <td> '.$d['ORI_INPUT2'].'</td>
                            <td> '.$d['ORI_INPUT3'].'</td>
                            <td> '.ribuan($d['QLTDVALT1']).'</td>
                            <td> '.ribuan($d['QLTDVALT2']).'</td>
                            <td> '.ribuan($d['QLTDVALT3']).'</td>
                            <td> '.ribuan($d['POT']).'</td>
                            <td> '.ribuan($d['JML_BAYAR']).'</td>
                            <td> '.$d['KURZTEXT'].'</td>
                          </tr>';
                        $total_qty += $d['LOTQTY'];
                        $total_harga += $d['POVALUE'];
                        $total_Bayar += $d['JML_BAYAR'];
          '</tr>';
            array_push($tbody, $_tr);
        }
        $total='<tr>
                <td></td>
                <td class="r bold"> '.ribuan($total_qty).'</td>
                <td></td>
                <td class="r bold"> '.ribuan($total_harga).'</td>
                <td colspan="7"></td>
                <td class="r bold"> '.ribuan($total_Bayar).'</td>
                <td></td>
              </tr>';
        array_push($tableGR, $thead);
        array_push($tableGR, $thead2);        
        array_push($tableGR, implode(' ', $tbody));
        array_push($tableGR, $total);
        array_push($tableGR, '</table>');
        return implode(' ', $tableGR);
    }
    
    private function buildTableStatus($dataBA) {        
        $tableGR = array(
            '<table border=1 style="font-size:10px;width:600px;margin:auto;">'
        );        
        $thead = '<thead>
            <tr>
                <th style="font-weight:600;" class="text-center"> No.</th>
                <th style="font-weight:600;"> No. Gr</th>
                <th style="font-weight:600;"> Status Gr</th>                
              </tr>        
              </thead>';
        $tbody = array();        
        $total_harga = 0;
        $total_Bayar = 0;
        $total_qty = 0;
        $no=1;
        foreach ($dataBA['gr'] as $d) {
            $_tr = '<tr>
                    <td> '.$no++.'</td>
                    <td> '.$d['GR_NO'].'</td>                      
                    <td> '.$d['KETERANGAN_STATUS'].'</td>                            
                  </tr>';                     
            array_push($tbody, $_tr);
        }        
        array_push($tableGR, $thead);        
        array_push($tableGR, implode(' ', $tbody));        
        array_push($tableGR, '</table>');
        return implode(' ', $tableGR);
    }

}

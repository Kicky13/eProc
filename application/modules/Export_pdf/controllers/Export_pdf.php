<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export_pdf extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Layout');
    }

    public function index(){
        $data['fungsi'][0]= "Pratender_Penunjukan_Langsung";
        $data['fungsi'][1]= "Pratender_pemilihan_langsung";
        $data['fungsi'][2]= "Rekap_penawaran";
        $data['fungsi'][3]= "Rekap_nego";
        $data['fungsi'][4]= "Penunjukan_pemenang";
        $data['fungsi'][5]= "Usulan_persetujuan_negosiasi";
        $data['fungsi'][6]= "Cetak_usulan_pemenang";
        $this->layout->render('index',$data);
    }

    public function Print_pdf($id){
        $this->load->model('prc_tender_main');
        $ptm = $this->prc_tender_main->ptm($id);
        $just = $ptm[0]['JUSTIFICATION'];

        if($just == 1){ 
// Pemilihan Langsung
            $this->Pratender_pemilihan_langsung($id, $ptm);
        }else if (preg_match('/5|6|8/', $just)) { 
// Penunjukan Langsung
            $this->Pratender_penunjukan_langsung($id, $ptm);
        }else{
            die('data not found.');
        }
    }

    public function Pratender_penunjukan_langsung($id, $ptm)
    {
        $this->load->model('prc_tender_item');
        $this->load->model('prc_tender_main');
        $this->load->model('prc_pr_item');
        $this->load->model('com_mat_group');
        $this->load->model('adm_plant');
        $this->load->model('prc_purchase_requisition');
        $this->load->model('prc_tender_vendor');
        $this->load->model('adm_approve_kewenangan');
        $this->load->model('adm_employee');
        $this->load->model('adm_cctr');

        $this->load->library('snippet');

        $data['ptm'] = $ptm[0];
        $this->prc_tender_item->join_pr();
        $data['pti'] = $this->prc_tender_item->ptm($id);

        $ppi_r=array(); $ppi=array(); $pr_item='';
        foreach ($data['pti'] as $val) {
            $this->prc_pr_item->where_id($val['PPI_ID']);
            $r = $this->prc_pr_item->get(null, '*', false, false);

            if($pr_item <> $r[0]['PPI_PRNO']){
                $ppi_r[]=$r[0];
            }
            $pr_item = $r[0]['PPI_PRNO'];
            $ppi[]=$r[0];
        }

        $mg=array();
        foreach ($ppi_r as $v) {
            $mg[] = $this->com_mat_group->find($v['PPI_MATGROUP']);
        }
        $data['matgrp']=$mg;
        $data['ppi']=$ppi;
        $ptm_pg = $this->prc_tender_main->ptm($id);

        $pr = $this->prc_purchase_requisition->for_print($ppi_r[0]['PPI_PRNO']);
        $data['plant'] = $this->adm_plant->find($pr[0]['PPR_PLANT']);

        $this->adm_cctr->where_kel_com($data['ptm']['KEL_PLANT_PRO']);
        $cctr = $this->adm_cctr->get();
        $data['cctr'] = array_build_key($cctr, 'CCTR');       

// $plant_master = $this->adm_plant->get();
// foreach ($plant_master as $val) {
//     $data['plant_master'][$val['PLANT_CODE']] = $val;
// }        
// if ($data['ptm']['IS_JASA'] == 1) {
//     $this->prc_tender_item->join_pr(true);
// } else {
//     $this->prc_tender_item->join_pr();
// }
// $data['tit'] = $this->prc_tender_item->ptm($id);


        $this->prc_tender_vendor->join_vnd_header('inner');
        $data['vendor'] = (array) $this->prc_tender_vendor->get(array('PTM_NUMBER' => $id));

        $cat_prc = 'PL';
        $this->adm_approve_kewenangan->join_emp();
        $this->adm_approve_kewenangan->where_pgrp($ptm_pg[0]['PTM_PGRP']);
        $this->adm_approve_kewenangan->where_harga_not_null();
        $this->adm_approve_kewenangan->where_catprc($cat_prc);
        $data['kewenangan'] = $this->adm_approve_kewenangan->get();

        $this->adm_approve_kewenangan->where_pgrp($ptm_pg[0]['PTM_PGRP']);
        $this->adm_approve_kewenangan->where_catprc($cat_prc);
        $data['diajukan'] = $this->adm_approve_kewenangan->get();

// die(var_dump($data['diajukan']));

        $arr_akw = array();
        foreach ($data['diajukan'] as $akw) {
            $emp = $this->adm_employee->find($akw['EMP_ID']);
            $arr_akw[$emp['ID']] = $emp['FULLNAME'];
        }
        $data['emp_kewenangan'] = $arr_akw;
        $data['ptm_comment'] = $this->snippet->ptm_comment_pdf($id);

        $this->load->helper(array('dompdf', 'file'));
        $html = $this->load->view('Pratender_Penunjukan_Langsung', $data, true);
        $filename = 'Export';
        $paper = 'A4';
        $orientation = 'potrait';
        pdf_create($html, $filename, $paper, $orientation,false);
    }

    public function Pratender_pemilihan_langsung($id, $ptm)
    {
        $this->load->model('prc_tender_item');
        $this->load->model('prc_pr_item');
        $this->load->model('com_mat_group');
        $this->load->model('adm_plant');
        $this->load->model('prc_purchase_requisition');
        $this->load->model('prc_tender_vendor');
        $this->load->model('adm_cctr');
        $this->load->model('adm_approve_kewenangan');
        $this->load->model('adm_employee');

        $data['ptm'] = $ptm[0];
        $this->prc_tender_item->join_pr();
        $data['pti'] = $this->prc_tender_item->ptm($id);

        $ppi_r=array(); $ppi=array(); $pr_item='';
        foreach ($data['pti'] as $val) {
            $this->prc_pr_item->where_id($val['PPI_ID']);
            $r = $this->prc_pr_item->get(null, '*', false, false);

            if($pr_item <> $r[0]['PPI_PRNO']){
                $ppi_r[]=$r[0];
            }
            $pr_item = $r[0]['PPI_PRNO'];
            $ppi[]=$r[0];
        }

        $mg=array();
        foreach ($ppi_r as $v) {
            $mg[] = $this->com_mat_group->find($v['PPI_MATGROUP']);
        }
        $data['matgrp']=$mg;
        $data['ppi']=$ppi;

        $pr = $this->prc_purchase_requisition->for_print($ppi_r[0]['PPI_PRNO']);
        $data['plant'] = $this->adm_plant->find($pr[0]['PPR_PLANT']);

        $this->adm_cctr->where_kel_com($data['ptm']['KEL_PLANT_PRO']);
        $cctr = $this->adm_cctr->get();
        $data['cctr'] = array_build_key($cctr, 'CCTR');  

        $this->prc_tender_vendor->join_vnd_header('inner');
        $data['vendor'] = (array) $this->prc_tender_vendor->get(array('PTM_NUMBER' => $id));

        $cat_prc = 'PL';
        $this->adm_approve_kewenangan->join_emp();
        $this->adm_approve_kewenangan->where_pgrp($pr[0]['PPR_PGRP']);
        $this->adm_approve_kewenangan->where_harga_not_null();
        $this->adm_approve_kewenangan->where_catprc($cat_prc);
        $data['kewenangan'] = $this->adm_approve_kewenangan->get();

        $this->adm_approve_kewenangan->where_pgrp($pr[0]['PPR_PGRP']);
        $this->adm_approve_kewenangan->where_catprc($cat_prc);
        $data['diajukan'] = $this->adm_approve_kewenangan->get();

        $arr_akw = array();
        foreach ($data['diajukan'] as $akw) {
            $emp = $this->adm_employee->find($akw['EMP_ID']);
            $arr_akw[$emp['ID']] = $emp['FULLNAME'];
        }
        $data['emp_kewenangan'] = $arr_akw;

        $this->load->helper(array('dompdf', 'file'));
        $html = $this->load->view('Pratender_Pemilihan_Langsung', $data, true);
        $filename = 'Export';
        $paper = 'A4';
        $orientation = 'potrait';
        pdf_create($html, $filename, $paper, $orientation,false);
    }

    public function Rekap_penawaran()
    {
        $data = array();
// $data['Date'] = "02.01.2016 / 02.01.2018";
        $this->load->helper(array('dompdf', 'file'));
        $html = $this->load->view('rekap_penawaran', $data, true);
        $filename = 'Export';
        $paper = 'A4';
        $orientation = 'landscape';
        pdf_create($html, $filename, $paper, $orientation,false);
    }

    public function Rekap_nego()
    {
        $data = array();
// $data['Date'] = "02.01.2016 / 02.01.2018";
        $this->load->helper(array('dompdf', 'file'));
        $html = $this->load->view('rekap_nego', $data, true);
        $filename = 'Export';
        $paper = 'A4';
        $orientation = 'landscape';
        pdf_create($html, $filename, $paper, $orientation,false);
    }

    public function Penunjukan_pemenang()
    {
        $data = array();
// $data['Date'] = "02.01.2016 / 02.01.2018";
        $this->load->helper(array('dompdf', 'file'));
        $html = $this->load->view('lembar_penunjukan_pemenang', $data, true);
        $filename = 'Export';
        $paper = 'A4';
        $orientation = 'potrait';
        pdf_create($html, $filename, $paper, $orientation,false);
    }

    public function Usulan_persetujuan_negosiasi()
    {
        $data = array();
// $data['Date'] = "02.01.2016 / 02.01.2018";
        $this->load->helper(array('dompdf', 'file'));
        $html = $this->load->view('Usulan_persetujuan_negosiasi', $data, true);
        $filename = 'Export';
        $paper = 'A4';
        $orientation = 'landscape';
        pdf_create($html, $filename, $paper, $orientation,false);
    }

    public function Cetak_usulan_pemenang()
    {
        $data = array();
// $data['Date'] = "02.01.2016 / 02.01.2018";
        $this->load->helper(array('dompdf', 'file'));
        $html = $this->load->view('Cetak_usulan_pemenang', $data, true);
        $filename = 'Export';
        $paper = 'A4';
        $orientation = 'landscape';
        pdf_create($html, $filename, $paper, $orientation,false);
    }

    public function evaluasi_teknis($id)
    {
// error_reporting(E_ALL);
        $this->load->model('prc_tender_item');
        $this->load->model('prc_tender_main');
        $this->load->model('prc_tender_vendor');
        $this->load->model('prc_tender_prep');
        $this->load->model('retender_item');

        $this->load->model('prc_pr_item');
        $this->load->model('prc_purchase_requisition');
        $this->load->model('v_log_main');


        if ($this->session->userdata('COMPANYID') == '7000' || $this->session->userdata('COMPANYID') == '2000' || $this->session->userdata('COMPANYID') == '5000') { 
            $lo = 'PT. Semen Indonesia (Persero) Tbk.';
            $logo = '<img class="logo_dark" src="'.base_url().'static/images/logo/semenindonesia.png" alt="Logo eProcurement PT. Semen Indonesia (Tbk)" weight="50" height="50">';
        } else if ($this->session->userdata('COMPANYID') == '3000') { 
            $lo = 'PT. Semen Padang Tbk.';
            $logo = '<img class="logo_dark" src="'.base_url().'static/images/logo/'.$this->session->userdata('LOGO_COMPANY').'" alt="Logo eProcurement '.$this->session->userdata('COMPANYNAME').'" weight="50" height="50">';
        } else if ($this->session->userdata('COMPANYID') == '4000') {
            $lo = 'PT. Semen Tonasa Tbk';
            $logo = '<img class="logo_dark" src="'.base_url().'static/images/logo/'.$this->session->userdata('LOGO_COMPANY').'" alt="Logo eProcurement '.$this->session->userdata('COMPANYNAME').'" weight="50" height="50">';
        }
// echo $logo;die;

        $data['company'] = $lo;
        $data['logo'] = $logo;

        $data['tit'] = $this->prc_tender_item->get(array('PTM_NUMBER'=>$id));
        $data['ret'] = $this->retender_item->get(array('PTM_NUMBER'=>$id));
// echo "<pre>";
// print_r($retender);die;
        $retender = "";
        if ($data['tit'][0]['PPI_ID'] != ''){
            $ppiID = $data['tit'][0]['PPI_ID'];
        } else {
            $retender = "tidak kosong";
            $ppiID = $data['ret'][0]['PPI_ID'];
        }
// echo "<pre>";
// print_r($ppiID);die;
        $ppi = $this->prc_pr_item->where_ppiId($ppiID);
        $data['ppr'] = $this->prc_purchase_requisition->pr($ppi[0]['PPI_PRNO']);

        $data['v_log_main'] = $this->v_log_main->get(array('PTM_NUMBER'=>$id));
// echo "<pre>";
// print_r($data['v_log_main']);die;

        $data['detail'] = array();
        $id_pegawai = "";
        foreach ($data['v_log_main'] as $val) {
            $dtl = $this->log_detail->get(array('LM_ID'=>$val['LM_ID']));
            $data['detail'][$val['LM_ID']] = $dtl;

            if($val['PROCESS']=='Evatek' && $val['LM_ACTION']=="OK" && $id_pegawai == ""){
                $id_pegawai = $val['USER_ID'];
            }
        }

// petugas evatek
        $this->load->model('adm_employee');
        $this->load->model('adm_pos');
        $data['emp'] = $this->adm_employee->get(array('ID' => $id_pegawai));
        $data['posisi'] = $this->adm_pos->get(array('POS_ID' => $data['emp'][0]['ADM_POS_ID']));
// petugas evatek

// ambil atasan
        $this->load->model('adm_employee_atasan');
        $data['hasil_atasan'] = $this->adm_employee_atasan->get_atasan_baru($id_pegawai);
// echo "<pre>";
// print_r($data['hasil_atasan']);die;
// ambil atasan

        $vendor=array();$vnds=array();$ass=array();$emp=array();$ppi=array();$ppi2=array();
        $data['fileVendor']=array();$reItem=array();$tmplte=array();
        foreach ($data['detail'] as $key => $val) {
            foreach ($val as $val2) {
                $enc = json_decode($val2['DATA']);
                if(isset($enc->PTV_VENDOR_CODE) && !empty($enc->PTV_VENDOR_CODE)){
                    $vendor[$enc->PTV_VENDOR_CODE] = $enc->PTV_VENDOR_CODE;
                }
                if(isset($enc->PTM_ASSIGNMENT) && !empty($enc->PTM_ASSIGNMENT)){
                    $ass[$enc->PTM_ASSIGNMENT] = $enc->PTM_ASSIGNMENT;
                }
                if(isset($enc->PPI_ID) && !empty($enc->PPI_ID) && isset($enc->PQM_ID) && !empty($enc->PQM_ID)){
                    $ppi[] = $enc->PPI_ID;
                    $ppi2[$val2['LM_ID']][$enc->PPI_ID][] = $enc;
                }
                if(isset($enc->EF_ID) && !empty($enc->EF_ID)){
                    $data['fileVendor'][$enc->PTV_VENDOR_CODE][$enc->TIT_ID][] = $enc->EF_FILE;
                }
                if($val2['TABLE_AFFECTED']=='vnd_perf_hist'){
                    $verVnd[$enc->VENDOR_CODE]=$enc->VENDOR_CODE;
                }
                if($val2['TABLE_AFFECTED']=='retender_item'){
                    $reItem[]=$enc->PPI_ID;
                }
                if($val2['TABLE_AFFECTED']=='prc_tender_prep' && isset($enc->EVT_ID) && !empty($enc->EVT_ID)){
                    $tmplte[$val2['LM_ID']][]=$enc->EVT_ID;
                }
            }
        }

        if($retender==""){
            $this->prc_tender_item->join_item();
            $data['pti'] = $this->prc_tender_item->ptm($id);
        } else {
            $this->retender_item->join_item();
            $data['pti'] = $this->retender_item->ptm($id);
        }

        $data['ptm'] = $this->prc_tender_main->ptm($id);

        $this->prc_tender_vendor->join_vnd_header();
        $data['ptv'] = $this->prc_tender_vendor->ptm($id);
        foreach ($data['ptv'] as $key) {
            $data['ptv_vendor_data'][$key['PTV_VENDOR_CODE']] = $key;
        }
// echo "<pre>";
// print_r($data['ptv_vendor_data']);die;
        $this->prc_tender_vendor->join_pqm();
        if($retender==""){
            $this->prc_tender_vendor->join_pqi_item(); 
        } else {
            $this->prc_tender_vendor->join_pqi_item_retender(); 
        }
        if ($this->session->userdata('COMPANYID') == '7000' || $this->session->userdata('COMPANYID') == '5000') { 
            $this->prc_tender_vendor->order_by_pqi_tech_val(); 
        }       
        $ptv = $this->prc_tender_vendor->ptm($id);
// echo "<pre>";
// print_r($ptv);die;
        $i = 0;
        foreach ($ptv as $val) {
            $data['ptv_tit'][$val['TIT_ID']][$val['PTV_VENDOR_CODE']]=$val;
// $data['ptv_tit_t'][$val['TIT_ID']][$i]=$val;
            $i++;
        }

// echo "<pre>";
// print_r($data['ptv_tit']);die;
        $this->load->model('prc_evaluasi_teknis');
        $this->load->model('prc_preq_template_detail');
        $this->load->model('prc_evaluation_template');
        $this->prc_evaluasi_teknis->where_ptm($id);
        $data['ppd'] = $this->prc_evaluasi_teknis->get();
        // echo "<pre>";
        // print_r($data['ppd']);die;
        if($data['ppd']){
            // echo "masuk";die;
            $pptd = $this->prc_preq_template_detail->get(array('PPD_ID' => $data['ppd'][0]['PPD_ID']));
            $da = $this->prc_evaluation_template->get(array('EVT_ID' => $pptd[0]['PPT_ID']));
            $data['template_name'] = $da[0];
            $data['template_update'] = $this->template_update($id, $pptd[0]['PPT_ID']);
            // echo "<pre>";
            // print_r($data['template_update']);die;
        }

        /* NILAI DARI TEMPLATE */ 
        $this->prc_tender_prep->join_eval_template();
        $temp_evatek = $this->prc_tender_prep->get(array("PTM_NUMBER" => $id));
        $data['evatek_t'] = $temp_evatek['EVT_PASSING_GRADE'];

        $this->load->helper(array('dompdf', 'file'));

        $html = $this->load->view('cetak_evaluasi_teknis', $data, true);
        $filename = 'Export';
        $paper = 'folio';
        $orientation = 'landscape';
        pdf_create($html, $filename, $paper, $orientation,false);
    }

    private function template_update($id, $ppt_id){
        $this->load->model('prc_tender_item');
        $this->load->model('prc_tender_quo_item');
        $this->load->model('prc_preq_template_detail');
        $this->load->model('prc_evaluasi_teknis');
        $this->load->model('prc_eval_file');
        $this->load->model('prc_preq_template_uraian');
        $this->load->model('prc_do_evatek_uraian');
        $this->load->model('prc_evaluasi_uraian');
        $this->load->model('prc_tender_quo_main');
        $this->load->model('prc_tender_main');
        $this->load->model('retender_quo_item');
        $this->load->model('retender_item');

        $ptm = $this->prc_tender_main->ptm($id);
        $ptm = $ptm[0];

        if ($ptm['IS_JASA'] == 1) {
            $this->prc_tender_item->join_pr(true);
        }   
        $cek_retender = "";
        $data['tit'] = $this->prc_tender_item->get(array('PTM_NUMBER'=>$id, 'TIT_STATUS <>'=>999));
        if(count($data['tit'])==0){
            $cek_retender = "tidak kosong";
            $data['tit'] = $this->retender_item->get(array('PTM_NUMBER'=>$id, 'TIT_STATUS <>'=>999));
        }
        $this->prc_tender_vendor->where_active();
        $data['ptv'] = $this->prc_tender_vendor->ptm($id);
        foreach ((array)$data['ptv'] as $key => $val) {
            $this->prc_eval_file->where_ptm_ptv($id, $val['PTV_VENDOR_CODE']);
            $ef = $this->prc_eval_file->get();
            foreach ($ef as $e) {
                $data['pef'][$val['PTV_VENDOR_CODE']][$e['TIT_ID']] = $e['EF_FILE'];
            }
        }

        /* Ngambil PQI */
        foreach ($data['ptv'] as $vnd) {
            /* Ngisi tabel buat pilih pemenang */
            $i=0;
            foreach ($data['tit'] as $tit) {
                if($cek_retender==""){
                    $this->prc_tender_quo_item->where_tit($tit['TIT_ID']);
                    $pqi = $this->prc_tender_quo_item->ptm_ptv($id, $vnd['PTV_VENDOR_CODE']);
// $data['pqis'][] = $pqi;
                    $pqi = $pqi[0];
                    $data['pqi'][$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']] = $pqi;
                    
                } else {
                    $this->retender_quo_item->where_tit($tit['TIT_ID']);
                    $pqi = $this->retender_quo_item->ptm_ptv($id, $vnd['PTV_VENDOR_CODE']);
                    $pqi = $pqi[0];
                    $data['pqi'][$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']] = $pqi;
                }
// asli
// if ($pqi != null) {
//     $pqi = $pqi[0];
//     $data['pqi'][$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']] = $pqi;
// }

                $data['matnr'] = $tit['PPI_NOMAT'];
                $data['banfn'] = substr($tit['PPI_ID'], 0, 10);
                $data['bnfpo'] = sprintf("%05d", substr($tit['PPI_ID'], 10));

                $data['user_vendor'] = $this->session->userdata('VENDOR_ID');

                $this->load->library('sap_handler');
                $data['return'] = $this->sap_handler->getlongtext(array($data));
                $isi = "";
                foreach ($data['return'] as $var) {
                    $isi.=$var['TDLINE']." ";
// $data['isi'][$var['TYPE']][] = $var['TDLINE'];
                }
                $data['tit'][$i]['longtext'][] = $isi;
                $i++;
            }
        }

        $this->prc_evaluasi_teknis->where_ptm($id);
        $ppd = $this->prc_evaluasi_teknis->get();
        $data['ppd2']=array();
        foreach ($ppd as $val) {
            $pe = $this->prc_evaluasi_uraian->get(array('ET_ID' => $val['ET_ID']));
            if(isset($pe[0])){
                $data['ppd2'][$val['PPD_ID']][$pe[0]['TIT_ID']]=$val;
            }
            foreach ($pe as $value) {
                $data['peu'][$val['ET_ID']][$value['TIT_ID']][$value['EU_NAME']] = $value;
                $data['peu2'][$val['ET_ID']][$value['TIT_ID']][$value['EU_NAME']][]=$value;
            }
        }

// die(var_dump($data['peu']['534']['541']['Spek 1']));//534 - 541 - Spek 1
        $data['ptd'] = $this->prc_preq_template_detail->get(array('PPT_ID' => $ppt_id));
        foreach ((array)$data['ptd'] as $key => $val) {
            $ur = $this->prc_preq_template_uraian->get(array('PPD_ID' => $val['PPD_ID']));
            $data['uraian'][$val['PPD_ID']] = $ur;
        }

        $this->prc_do_evatek_uraian->where_ptm($id);
        $deu = $this->prc_do_evatek_uraian->get();
        foreach ($deu as $val) {
            $data['det'][$val['TIT_ID']][$val['ET_ID']][$val['PTV_VENDOR_CODE']] = $val;
            $data['deu'][$val['TIT_ID']][$val['ET_ID']][$val['PTV_VENDOR_CODE']][$val['EU_ID']] = $val;
        }
//die(var_dump($data['deu']['541']['534']['0000110021']['1298']));
        $data['vendor_data'] = $this->prc_tender_quo_main->get_join(array('PRC_TENDER_QUO_MAIN.PTM_NUMBER' => $id));

        // echo "<pre>";
        // print_r($data);die;

        $ansi = $this->load->view('Evaluasi_penawaran/evaluasi_template_update_cetak', $data, true);
        return $ansi;
    }

    public function print_evaluasi($id){
        $this->load->model('prc_tender_main');
        $this->load->model('prc_evaluator');
        $this->load->model('prc_tender_vendor');
        $this->load->model('prc_tender_item');
        $this->load->model('prc_evaluasi_teknis');
        $this->load->model('prc_preq_template_detail');
        $this->load->model('prc_preq_template_uraian');
        $this->load->model('prc_evaluasi_uraian');
        $this->load->model('prc_do_evatek_uraian');
        $this->load->model('prc_tender_quo_item');
        $this->load->model('prc_tender_quo_main');

        $ptm=$this->prc_tender_main->ptm($id);
        $data['ptm_pratender']=$ptm[0]['PTM_PRATENDER'];

        $this->prc_evaluator->join_emp();
        $eva = $this->prc_evaluator->get_desc(array('PTM_NUMBER'=>$id));
        $data['evaluator'] = $eva[0];

        $data['tit'] = $this->prc_tender_item->get(array('PTM_NUMBER'=>$id, 'TIT_STATUS <>'=>999));

        $this->prc_tender_vendor->where_active();
        $data['ptv'] = $this->prc_tender_vendor->ptm($id);

        $this->prc_evaluasi_teknis->where_ptm($id);
        $ppd = $this->prc_evaluasi_teknis->get();

        $data['ppd2']=array();
        foreach ($ppd as $val) {
            $pe = $this->prc_evaluasi_uraian->get(array('ET_ID' => $val['ET_ID']));
            if(isset($pe[0])){
                $data['ppd2'][$val['PPD_ID']][$pe[0]['TIT_ID']]=$val;
            }
            foreach ($pe as $value) {
                $data['peu'][$val['ET_ID']][$value['TIT_ID']][$value['EU_NAME']] = $value;
                $data['peu2'][$val['ET_ID']][$value['TIT_ID']][$value['EU_NAME']][]=$value;
            }
        }

        $ppt = $this->prc_preq_template_detail->get(array('PPD_ID' => $ppd[0]['PPD_ID']));
        $data['ptd'] = $this->prc_preq_template_detail->get(array('PPT_ID' => $ppt[0]['PPT_ID']));
        foreach ((array)$data['ptd'] as $key => $val) {
            $ur = $this->prc_preq_template_uraian->get(array('PPD_ID' => $val['PPD_ID']));
            $data['uraian'][$val['PPD_ID']] = $ur;
        }

        $this->prc_do_evatek_uraian->where_ptm($id);
        $deu = $this->prc_do_evatek_uraian->get();
        foreach ($deu as $val) {
            $data['det'][$val['TIT_ID']][$val['ET_ID']][$val['PTV_VENDOR_CODE']] = $val;
            $data['deu'][$val['TIT_ID']][$val['ET_ID']][$val['PTV_VENDOR_CODE']][$val['EU_ID']] = $val;
        }

        /* Ngambil PQI */
        foreach ($data['ptv'] as $vnd) {
            /* Ngisi tabel buat pilih pemenang */
            foreach ($data['tit'] as $tit) {
                $this->prc_tender_quo_item->where_tit($tit['TIT_ID']);
                $pqi = $this->prc_tender_quo_item->ptm_ptv($id, $vnd['PTV_VENDOR_CODE']);
// $data['pqis'][] = $pqi;
                if ($pqi != null) {
                    $pqi = $pqi[0];
                    $data['pqi'][$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']] = $pqi;
                }
            }
        }

        $data['vendor_data'] = $this->prc_tender_quo_main->get_join(array('PRC_TENDER_QUO_MAIN.PTM_NUMBER' => $id));

        $this->load->helper(array('dompdf', 'file'));
        $html = $this->load->view('template_evaluasi', $data, true);
        $filename = 'Export';
        $paper = 'A4';
        $orientation = 'landscape';
        pdf_create($html, $filename, $paper, $orientation,false);

    }

}
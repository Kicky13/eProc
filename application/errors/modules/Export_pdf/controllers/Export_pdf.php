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

        if($just == 1){ // Pemilihan Langsung
            $this->Pratender_pemilihan_langsung($id, $ptm);
        }else if (preg_match('/5|6|8/', $just)) { // Penunjukan Langsung
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
        $this->load->model('prc_tender_item');
        $this->load->model('prc_tender_main');
        $this->load->model('prc_tender_vendor');
        $this->load->model('prc_tender_prep');

        if ($this->session->userdata('COMPANYID') == '7000' || $this->session->userdata('COMPANYID') == '2000' || $this->session->userdata('COMPANYID') == '5000') { 
            $lo = 'PT. Semen Gresik Tbk.';
        } else if ($this->session->userdata('COMPANYID') == '3000') { 
            $lo = 'PT. Semen Padang Tbk.';
        } else if ($this->session->userdata('COMPANYID') == '4000') {
            $lo = 'PT. Semen Tonasa Tbk';
        }

        $data['company'] = $lo;

        $this->prc_tender_item->join_item();
        $data['pti'] = $this->prc_tender_item->ptm($id);
        $data['ptm'] = $this->prc_tender_main->ptm($id);

        $this->prc_tender_vendor->join_vnd_header();
        $data['ptv'] = $this->prc_tender_vendor->ptm($id);
        $this->prc_tender_vendor->join_pqm();
        $this->prc_tender_vendor->join_pqi_item();        
        $ptv = $this->prc_tender_vendor->ptm($id);
        foreach ($ptv as $val) {
            $data['ptv_tit'][$val['TIT_ID']][$val['PTV_VENDOR_CODE']]=$val;
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
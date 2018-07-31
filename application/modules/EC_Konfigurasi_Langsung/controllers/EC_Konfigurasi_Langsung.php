<?php defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Konfigurasi_Langsung extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('procurement_job');
        $this->load->library('Authorization');
        $this->load->library('Layout');
        $this->load->library('comment');
    }

    public function index()
    {
        $data['title'] = "Konfigurasi Pembelian Langsung";
        $data['tanggal'] = date("d-m-Y");
        $this->load->model('ec_konfigurasi_lansgung_m');
        $data['master_update'] = $this->ec_konfigurasi_lansgung_m->get_M_update();
        $data['currency'] = $this->ec_konfigurasi_lansgung_m->get_MasterCurrency();
        $this->layout->set_table_js();
        $this->layout->set_table_cs(); 
        $this->layout->set_datetimepicker();
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_nav_tree.js');
        $this->layout->add_css('pages/EC_nav_tree.css');  
        $this->layout->add_js('pages/EC_konfigurasi_langsung.js'); 
        $this->layout->add_css('pages/EC_miniTable.css'); 
        $this->layout->add_css('pages/EC_style_ecatalog.css');
        $this->layout->render('detail_procurement_pratender', $data);
        // $this->get_detail();
    }

    public function getItem($value = '')
    {
        // header('Content-Type: application/json');
        $this->load->model('ec_konfigurasi_lansgung_m');
        $result = $this->ec_konfigurasi_lansgung_m->getItem($value);
        for ($i = 0; $i < 0; $i++) {
            $data[$i]["MATNR"] = $result[$i]["MATNR"];
            $data[$i]["MATKL"] = $result[$i]["MATKL"];
            $data[$i]["MAKTX"] = $result[$i]["MAKTX"];
            $data[$i]["MEINS"] = $result[$i]["MEINS"];
            $data[$i]["KODE_USER"] = $result[$i]["KODE_USER"];
            $data[$i]["ID_CAT"] = $result[$i]["ID_CAT"];
            $data[$i]["MATNO"] = $result[$i]["MATNO"];
            $data[$i]["KODE_UPDATE"] = $result[$i]["KODE_UPDATE"];
            $data[$i]["DAYS_UPDATE"] = $result[$i]["DAYS_UPDATE"];
            $data[$i]["CURRENCY"] = $result[$i]["CURRENCY"];
            $data[$i]["PUBLISHED_LANGSUNG"] = $result[$i]["PUBLISHED_LANGSUNG"];
            $data[$i]["PEMBUKAAN"] = $result[$i]["TO_CHAR(PL.START_DATE,'DD/MM/YYYYHH24:MI:SS')"];
            $data[$i]["PENUTUPAN"] = $result[$i]["TO_CHAR(PL.END_DATE,'DD/MM/YYYYHH24:MI:SS')"];
        }
        // var_dump($data);
        echo json_encode(array('data' => $result));
    }

    public function getItemPublish($value = '')
    {
        // header('Content-Type: application/json');
        $this->load->model('ec_konfigurasi_lansgung_m');
        $result = $this->ec_konfigurasi_lansgung_m->getItemPublish($value);
        for ($i = 0; $i < 0; $i++) {
            $data[$i]["MATNR"] = $result[$i]["MATNR"];
            $data[$i]["MATKL"] = $result[$i]["MATKL"];
            $data[$i]["MAKTX"] = $result[$i]["MAKTX"];
            $data[$i]["MEINS"] = $result[$i]["MEINS"];
            $data[$i]["KODE_USER"] = $result[$i]["KODE_USER"];
            $data[$i]["ID_CAT"] = $result[$i]["ID_CAT"];
            $data[$i]["MATNO"] = $result[$i]["MATNO"];
            $data[$i]["KODE_UPDATE"] = $result[$i]["KODE_UPDATE"];
            $data[$i]["DAYS_UPDATE"] = $result[$i]["DAYS_UPDATE"];
            $data[$i]["CURRENCY"] = $result[$i]["CURRENCY"];
            $data[$i]["PUBLISHED_LANGSUNG"] = $result[$i]["PUBLISHED_LANGSUNG"];
            $data[$i]["PUBLISH"] = $result[$i]["PUBLISH"];
            $data[$i]["PEMBUKAAN"] = $result[$i]["TO_CHAR(PL.START_DATE,'DD/MM/YYYYHH24:MI:SS')"];
            $data[$i]["PENUTUPAN"] = $result[$i]["TO_CHAR(PL.END_DATE,'DD/MM/YYYYHH24:MI:SS')"];
        }
        // var_dump($data);
        echo json_encode(array('data' => $result));
    }

    public function publish($value = '')
    {
        $this->load->model('ec_konfigurasi_lansgung_m');
        $itms = json_decode($this->input->post('items'));                        
        $item_publish=$this->ec_konfigurasi_lansgung_m->getPublish($itms, $value);                
        $this->ec_konfigurasi_lansgung_m->publish($itms, $value);          
        for ($i = 0; $i < sizeof($item_publish); $i++){         
            $suksesReturn[] = array("MATNR" => $item_publish[$i]['MATNR'], "MAKTX" => $item_publish[$i]['MAKTX'],
                            "MEINS" => $item_publish[$i]['MEINS']);
        }         
        echo json_encode(array('suksesReturn' => $suksesReturn,'gagalReturn' => $gagalReturn));
    }

    public function getVnd($value = '')
    {
//        $this->load->model('ec_konfigurasi_lansgung_m');
//        $xpl = json_decode($this->input->post('items'));
//        $result = $this->ec_konfigurasi_lansgung_m->getVnd($xpl);
//        echo json_encode(array('data' => $result));

        $this->load->library('sap_handler');
        $item = json_decode($this->input->post('items'));
        $temp = '';
        $matkl = array();
        foreach ($item as $value){
            if ($temp == $value) {
                $temp = $value;
            } else {
                $temp = $value;
                array_push($matkl, $value);
            }
        }
        $data = $this->sap_handler->getDirven($this->session->userdata['COMPANYID'], $matkl);
        echo json_encode(array('data' => $this->compileDirven($data), 'matkl' => $matkl));
//        echo json_encode(array('data' => $this->compileDirven($data)));
    }

    private function compileDirven($data)
    {
        $temp = array();
        $vnd = array();
        foreach ($data['IT_DATA'] as $value){
            $temp['VENDOR_NO'] = $value['LIFNR'];
            $temp['VENDOR_NAME'] = $value['NAME1'];
            $temp['MATKL'] = $value['MATKL'];
            array_push($vnd, $temp);
        }
        return $vnd;
    }

    public function getPlant($value = '')
    {
        $this->load->model('ec_konfigurasi_lansgung_m');
        $plant=array('2701','2702','2703','2901','7701','7702');
        $result = $this->ec_konfigurasi_lansgung_m->getPlant($plant);
        echo json_encode(array('data' => $result));
    }

    public function getMasterUpdate($value = '')
    {
        $this->load->model('ec_konfigurasi_lansgung_m');
        // $xpl = explode(',', str_replace(array('[', ']'), '', $this -> input -> post('items')));
        //$xpl = json_decode($this -> input -> post('items'));
        $result = $this->ec_konfigurasi_lansgung_m->get_M_update();
        //var_dump($result);
        echo json_encode(array('data' => $result));
    }

    public function getVndAssign()
    {
        $this->load->model('ec_konfigurasi_lansgung_m');
        echo json_encode(array('data' => $this->ec_konfigurasi_lansgung_m->getVndAssign()));
    }

    public function getVndMatno($value = '')
    {
        $this->load->model('ec_konfigurasi_lansgung_m');
        $xpl = ($this->input->post('items'));
        $xpl2 = json_decode($this->input->post('itemsgrp'));
        $result = $this->ec_konfigurasi_lansgung_m->getVndMatno($xpl, $xpl2);
        // var_dump($xpl);
        echo json_encode(array('data' => $result));
    }

    public function getMatVnd_assign()
    {
        $this->load->model('ec_konfigurasi_lansgung_m');
        $vendorno = $this->input->post('items');
        $result = $this->ec_konfigurasi_lansgung_m->getMatVnd_assign($vendorno);
        echo json_encode(array('data' => $this->compileMatVnd($result, $vendorno)));
    }

    public function getVndMatno_propose($value = '')
    {
        $this->load->model('ec_konfigurasi_lansgung_m');
        $xpl = ($this->input->post('items'));
        $xpl2 = json_decode($this->input->post('itemsgrp'));
        $result = $this->ec_konfigurasi_lansgung_m->getVndMatno_propose($xpl, $xpl2);
        // var_dump($xpl);
        echo json_encode(array('data' => $result));
    }

    public function compileMatVnd($propose, $vendorno)
    {
        $this->load->model('ec_konfigurasi_lansgung_m');
        for ($i = 0; $i < count($propose); $i++){
            if ($this->ec_konfigurasi_lansgung_m->getAssignedItem($vendorno, $propose[$i]['MATNO'])){
                $propose[$i]['CHECK'] = 'YES';
            } else {
                $propose[$i]['CHECK'] = 'NO';
            }
        }
        return $propose;
    }

    public function insert($value = '')
    {
        $this->load->model('ec_konfigurasi_lansgung_m');
        $itms = json_decode($this->input->post('items'));
        $vnds = json_decode($this->input->post('vnds'));
        $startDate = ($this->input->post('startDate'));
        $endDate = ($this->input->post('endDate'));
        $kode_update = ($this->input->post('kode'));
        $lamahari = ($this->input->post('days'));
        $currency = ($this->input->post('currency'));
        // var_dump($itms);
        // var_dump($vnds);
        $result = $this->ec_konfigurasi_lansgung_m->insert($itms, $vnds, $startDate, $endDate, $kode_update, $lamahari, $currency);
        echo json_encode(array('data' => $result));
    }

    public function insertPropose($value = '')
    {
        $this->load->model('ec_konfigurasi_lansgung_m');
        $itms = json_decode($this->input->post('items'));
        $vnds = json_decode($this->input->post('vnds'));
        $startDate = ($this->input->post('startDate'));
        $endDate = ($this->input->post('endDate'));
        $kode_update = ($this->input->post('kode'));
        $lamahari = ($this->input->post('days'));
        $currency = ($this->input->post('currency'));
        // var_dump($itms);
        // var_dump($vnds);
        $result = $this->ec_konfigurasi_lansgung_m->insertPropose($itms, $vnds, $startDate, $endDate, $kode_update, $lamahari, $currency);
        echo json_encode(array('data' => $result));
    }

    public function edit($value = '')
    {
        $this->load->model('ec_konfigurasi_lansgung_m');
        $itms = ($this->input->post('items'));
        $vnds = json_decode($this->input->post('vnds'));
        //$startDate = ($this->input->post('startDate'));
        //$endDate = ($this->input->post('endDate'));
        //var_dump($itms);
        //var_dump($vnds);
        $kode_update = ($this->input->post('kode_update'));
        $hari = ($this->input->post('hari'));
        $currency = ($this->input->post('currency'));
        $result = $this->ec_konfigurasi_lansgung_m->edit($itms, $vnds, $kode_update, $hari, $currency);
        echo json_encode(array('data' => $result));
    }

    public function editPropose($value = '')
    {
        $this->load->model('ec_konfigurasi_lansgung_m');
        $itms = ($this->input->post('items'));
        $vnds = json_decode($this->input->post('vnds'));
        //$startDate = ($this->input->post('startDate'));
        //$endDate = ($this->input->post('endDate'));
        //var_dump($itms);
        //var_dump($vnds);
        $kode_update = ($this->input->post('kode_update'));
        $hari = ($this->input->post('hari'));
        $currency = ($this->input->post('currency'));
        $result = $this->ec_konfigurasi_lansgung_m->editPropose($itms, $vnds, $kode_update, $hari, $currency);
        echo json_encode(array('data' => $result));
    }

    public function editAssign($value = '')
    {
        $this->load->model('ec_konfigurasi_lansgung_m');
        $vnd = ($this->input->post('vnds'));
        $itms = json_decode($this->input->post('items'));
        $result = $this->ec_konfigurasi_lansgung_m->editAssign($itms, $vnd);
        echo json_encode(array('data' => $result));
    }

    public function tess($value = '')
    {
        header('Content-Type: application/json');
        $this->load->model('ec_konfigurasi_lansgung_m');
        $result = $this->ec_konfigurasi_lansgung_m->getVnd(array('401-118', '101-100'));
        var_dump($result);
    }

    public function syncPlant($value = '')
    {
        $this->load->library('sap_handler');
        $data=($this->sap_handler->getECPlant(false));
        $this->load->model('ec_konfigurasi_lansgung_m');
//        var_dump($data);die();
//        $dataAll = array();  
        foreach ($data as $datum) {
            if($datum['WERKS']==='2901'){
                $this->ec_konfigurasi_lansgung_m->syncPlant(array('PLANT'=>$datum['WERKS'],'COMPANY'=>$datum['BUKRS'],'DESC'=>'Pengambilan Sendiri','STATUS'=>0, 'ALAMAT'=>$datum['STRAS'],'KODEPOS'=>$datum['PSTLZ'],'KOTA'=>$datum['ORT01']));                        
            }else if($datum['WERKS']==='2701'){
                $this->ec_konfigurasi_lansgung_m->syncPlant(array('PLANT'=>$datum['WERKS'],'COMPANY'=>$datum['BUKRS'],'DESC'=>'Kantor Gresik','STATUS'=>0, 'ALAMAT'=>$datum['STRAS'],'KODEPOS'=>$datum['PSTLZ'],'KOTA'=>$datum['ORT01']));                        
            }else if($datum['WERKS']==='2702'){
                $this->ec_konfigurasi_lansgung_m->syncPlant(array('PLANT'=>$datum['WERKS'],'COMPANY'=>$datum['BUKRS'],'DESC'=>'Kantor Tuban','STATUS'=>0, 'ALAMAT'=>$datum['STRAS'],'KODEPOS'=>$datum['PSTLZ'],'KOTA'=>$datum['ORT01']));                        
            }else if($datum['WERKS']==='2703'){
                $this->ec_konfigurasi_lansgung_m->syncPlant(array('PLANT'=>$datum['WERKS'],'COMPANY'=>$datum['BUKRS'],'DESC'=>'Kantor Jakarta','STATUS'=>0, 'ALAMAT'=>$datum['STRAS'],'KODEPOS'=>$datum['PSTLZ'],'KOTA'=>$datum['ORT01']));                        
            }else if($datum['WERKS']==='7701'){
                $this->ec_konfigurasi_lansgung_m->syncPlant(array('PLANT'=>$datum['WERKS'],'COMPANY'=>$datum['BUKRS'],'DESC'=>'Gudang Gresik','STATUS'=>0, 'ALAMAT'=>$datum['STRAS'],'KODEPOS'=>$datum['PSTLZ'],'KOTA'=>$datum['ORT01']));                        
            }else if($datum['WERKS']==='7702'){
                $this->ec_konfigurasi_lansgung_m->syncPlant(array('PLANT'=>$datum['WERKS'],'COMPANY'=>$datum['BUKRS'],'DESC'=>'Gudang Tuban','STATUS'=>0, 'ALAMAT'=>$datum['STRAS'],'KODEPOS'=>$datum['PSTLZ'],'KOTA'=>$datum['ORT01']));                        
            }else{
                $this->ec_konfigurasi_lansgung_m->syncPlant(array('PLANT'=>$datum['WERKS'],'COMPANY'=>$datum['BUKRS'],'DESC'=>$datum['NAME1'],'STATUS'=>0, 'ALAMAT'=>$datum['STRAS'],'KODEPOS'=>$datum['PSTLZ'],'KOTA'=>$datum['ORT01']));
            }               
        }
//        var_dump($dataAll);die();        
        // print_r($data);
    }
    public function publishPlant($plant = '')
    {
        $this->load->model('ec_konfigurasi_lansgung_m');
        $result = $this->ec_konfigurasi_lansgung_m->publishPlant($plant, $this->uri->segment(4));
    }

    public function test()
    {
        $this->load->library('sap_handler');
        $matkl = '623';
        $company = $this->session->userdata['COMPANYID'];
        $sapReturn = $this->sap_handler->getDirven($company, $matkl);
        print json_encode($sapReturn);
    }

}

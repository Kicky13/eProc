<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_PL_Monitoring_Penawaran extends CI_Controller
{

    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->model('ec_pl_monitoring_penawaran_m');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->user = $this->session->userdata('FULLNAME');
    }

    public function index($brhasil = false)
    {
        $data['title'] = "Monitoring Penawaran Pembelian Langsung";
        $data['brhasil'] = $brhasil;
//        $data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');

        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/EC_monitoring_penawaran.js');

        $this->layout->render('list', $data);
    }

    public function detail_penawaran($vendor)
    {
        $this->load->model('ec_penawaran_vnd_test');
        $data['plant'] = $this->ec_penawaran_vnd_test->getPlant();
        $data['vendor'] = $vendor;
        $vnd = $this->ec_pl_monitoring_penawaran_m->getVendor_info($vendor);
        $data['title'] = "Monitoring Penawaran<br/>".$vnd['VENDOR_NAME'];
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('jquery.form.min.js');
        $this->layout->add_css('pages/EC_menu_nav.css');
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_detail_monitoring.js');
        $this->layout->add_css('pages/EC_style_ecatalog.css');
        $this->layout->render('detail_penawaran', $data);
    }

    public function getData_vendor()
    {
        header('Content-Type: application/json');
        $result = $this->ec_pl_monitoring_penawaran_m->getData_Vendor();
        echo json_encode(array('data' => $result));
    }

    public function getDetail_penawaran()
    {
        header('Content-Type: application/json');
        $this->load->model('ec_penawaran_vnd_test');
        $dataCurr = $this->ec_penawaran_vnd_test->get_MasterCurrency();
        $dataProduk = $this->ec_penawaran_vnd_test->get_data_produk($this->input->post('vendor'), $this->input->post('limitMin'), $this->input->post('limitMax'));
        $dataCount = $this->ec_penawaran_vnd_test->get_Count_produk($this->input->post('vendor'));
        $json_data = array('curr' => $dataCurr, 'data' => $this->getALL($dataProduk), 'page' => count($dataCount));
        echo json_encode($json_data);
    }

    function getALL($dataProduk)
    {
        $i = 1;
        $data_tabel = array();
        $venno = $this->session->userdata['VENDOR_NO'];
        $this->load->model('ec_penawaran_vnd_test');
        $commit = '';
        foreach ($dataProduk as $value) {
            /*if ($value['KODE_UPDATE'] == '510') {
                $LASTUPDATE = strtotime(date($value['LASTUPDATE']));
                $dateAfter = date('d-m-Y', strtotime('+' . $value['DAYS_UPDATE'] . ' day', $LASTUPDATE));
            } else if ($value['KODE_UPDATE'] == '511') {
                //$LASTUPDATE = strtotime(date("01-m-Y"));
                $LASTUPDATE = strtotime(date("01-" . substr($value['LASTUPDATE'], 3,
                        2) . "-" . substr($value['LASTUPDATE'], 6, 9)));
                //var_dump('tesdate'.substr($value['LASTUPDATE'], 3, 2).'-'.substr($value['LASTUPDATE'], 6, 9));
                $dateAfter = date('d-m-Y', strtotime('+1 month', $LASTUPDATE));
            } else if ($value['KODE_UPDATE'] == '521') {
                $LASTUPDATE = strtotime(date($value['LASTUPDATE']));
                $dateAfter = date('d-m-Y', strtotime('next monday', $LASTUPDATE));
            }*/

            $data[0] = $i++;
            $data['MATNO'] = $value['MATNO'] != null ? $value['MATNO'] : "";
            $data['MAKTX'] = $value['MAKTX'] != null ? $value['MAKTX'] : "";
            $data['PICTURE'] = $value['PICTURE'] == null ? "default_post_img.png" : $value['PICTURE'];
            //$data['TGL_MULAI'] = $value['TGL_MULAI'] != null ? $value['TGL_MULAI'] : "";
            //$data[5] = $value['TGL_AKHIR'] != null ? $value['TGL_AKHIR'] : "";
            // $data[6] = $value['HARGA_PENAWARAN'] != null ? $value['HARGA_PENAWARAN'] : "";
            // if ($value['HARGA_PENAWARAN'] == "0") {
            //     $dateAfter = "-";
            // }
            $data['VENDORNO'] =$value['VENDORNO'];
            $data['MEINS'] = $value['MEINS'];
            $data['CURRENCY'] = $value['CURRENCY'] != null ? $value['CURRENCY'] : "";
            //$data[8] = $value['DELIVERY_TIME'] != null ? $value['DELIVERY_TIME'] : "";
            $data['STOK'] = $value['STOK'] != null ? $value['STOK'] : "";
            $commit = $this->ec_penawaran_vnd_test->get_stok_commit($venno, $value['MATNO']);
            $data['STOK_COMMIT'] = $commit != null ? $commit : "";
            $data[13] = $value['KODE_PENAWARAN'] != null ? $value['KODE_PENAWARAN'] : "";
            $data['DESKRIPSI'] = $value['DESKRIPSI'] != null ? $value['DESKRIPSI'] : "";
            $data['LONGTEXT'] = $value['TDLINE'] != null ? $value['TDLINE'] : "";
            $isi = $this->ec_penawaran_vnd_test->getDetail($value['MATNO'], $venno);
            $data['ISI'] = array();
            foreach($isi as $s) {
                $data['ISI'][] = array(
                    "PLANT"			=> $s["PLANT"],
                    "DESC"			=> $s["DESC"],
                    "CURRENCY"		=> $s["CURRENCY"] != null ? $s["CURRENCY"] : "",
                    "PRICE"			=> $s["PRICE"] != null ? $s["PRICE"] : "",
                    "DELIVERY_TIME"	=> $s["DELIVERY_TIME"] != null ? $s["DELIVERY_TIME"] : "",
                    "KODE_UPDATE"	=> $s["KODE_UPDATE"] != null ? $s["KODE_UPDATE"] : "-",
                    "DAYS_UPDATE"	=> $s["DAYS_UPDATE"] != null ? $s["DAYS_UPDATE"] : "-",
                    "LASTUPDATE"	=> $s["LASTUPDATE"] != null ? $s["LASTUPDATE"] : "-",
                );
            }
            //$data['LASTUPDATE'] = $value['LASTUPDATE'] != null ? $value['LASTUPDATE'] : "-";
            // if ($value['LASTUPDATE'] == null) {
            //     $dateAfter = "-";
            // }
            //$data[10] = $dateAfter;
            $data_tabel[] = $data;
        }
        return $data_tabel;
    }
}

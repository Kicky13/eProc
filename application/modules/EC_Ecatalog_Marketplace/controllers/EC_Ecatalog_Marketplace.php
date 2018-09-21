<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Ecatalog_Marketplace extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper('security');
    }

    public function tes()
    {
        echo json_encode($this->session->userdata);
    }

    public function index()
    {
        $this->load->model('EC_strategic_material_m');
        $result = $this->EC_strategic_material_m->getRootCategory();

        $data['title'] = "E-Catalog";
        $data['kategori'] = $result;
        //$data['pc_code'] = $this -> getPC_CODE();
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_pembelian_langsung.js');
        $this->layout->add_css('pages/EC_menu_nav.css');
        $this->layout->add_js('pages/EC_nav_tree.js');
        $this->layout->add_css('pages/EC_nav_tree.css');
        $this->layout->render('homepage', $data);
    }

    public function pembelian_kontrak()
    {
        $this->load->model('EC_strategic_material_m');
        $result = $this->EC_strategic_material_m->getRootCategory();
        $data['title'] = "E-Catalog | Pembelian Kontrak";
        $data['kategori'] = $result;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_css('pages/EC_menu_nav.css');
        $this->layout->add_js('pages/EC_nav_tree.js');
        $this->layout->add_css('pages/EC_nav_tree.css');
        $this->layout->add_js('pages/EC_pembelian_langsung.js');
        $this->layout->render('homepage_kontrak', $data);
    }

    public function pembelian_langsung()
    {
        $this->load->model('EC_strategic_material_m');
        $result = $this->EC_strategic_material_m->getRootCategory();

        $data['title'] = "E-Catalog | Pembelian Langsung";
        $data['kategori'] = $result;
        //$data['pc_code'] = $this -> getPC_CODE();
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_pembelian_langsung.js');
        $this->layout->add_css('pages/EC_menu_nav.css');
        $this->layout->add_js('pages/EC_nav_tree.js');
        $this->layout->add_css('pages/EC_nav_tree.css');
        $this->layout->render('homepage_langsung', $data);
    }

    public function listCatalog($kode = '-')
    {
        $data['title'] = "E-Catalog | Pembelian Kontraks";
        $data['pc_code'] = $this->getPC_CODE();
        if ($kode != '') {
            $data['kode'] = $kode;
        }

        if (!isset($_POST['tagsearch'])) {
            $data['tag'] = '-';
        } else {
            $data['tag'] = $_POST['tagsearch'];
        }
        //$this -> input -> post('tagsearch');
        // echo $data['tag'];//($this -> input -> post('tagsearch'));
        // return '';

        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_js('bootbox.js');
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_css('pages/EC_bootstrap-slider.min.css');
        $this->layout->add_js('pages/EC_bootstrap-slider.min.js');
        $this->layout->add_js('pages/EC_pembelian_langsung.js');
        $this->layout->add_css('pages/EC_menu_nav.css');
        $this->layout->add_js('pages/EC_nav_tree.js');
        $this->layout->add_css('pages/EC_nav_tree.css');
        $this->layout->add_css('pages/EC_style_ecatalog.css');
        $this->layout->render('list', $data);
    }

    public function listCatalogLsgs($kode = '-')
    {
        $data['title'] = "E-Catalog | Pembelian Langsung";
        $data['pc_code'] = $this->getPC_CODE();
        if ($kode != '') {
            $data['kode'] = $kode;
        }

        if (!isset($_POST['tagsearch'])) {
            $data['tag'] = '-';
        } else
            $data['tag'] = $_POST['tagsearch'];
        //$this -> input -> post('tagsearch');
        // echo $data['tag'];//($this -> input -> post('tagsearch'));
        // return '';

        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_js('bootbox.js');
        $this->layout->add_css('pages/EC_bootstrap-slider.min.css');
        $this->layout->add_js('pages/EC_bootstrap-slider.min.js');
        $this->layout->add_js('pages/EC_list_langsung.js');
        $this->layout->add_css('pages/EC_menu_nav.css');
        $this->layout->add_js('pages/EC_nav_tree.js');
        $this->layout->add_css('pages/EC_nav_tree.css');
        $this->layout->add_css('pages/EC_style_ecatalog.css');
        $this->layout->add_js('plugins/select2/select2.js');
        $this->layout->add_css('plugins/select2/select2.css');
        $this->layout->add_css('plugins/select2/select2-bootstrap.css');
        $data['CC'] = $this->COSTCENTER_GETLIST();
        $this->load->model('ec_ecatalog_m');
        $data['ccc'] = $this->ec_ecatalog_m->getCC($this->session->userdata['ID']);
        $this->layout->render('list_lgsg', $data);
    }

    public function history($cheat = false)
    {
        $data['title'] = "History PO Kontrak";
        //$data['cheat'] = $cheat;
        //$data['pc_code'] = $this -> getPC_CODE();
        $data['po'] = $this->testHistory();
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_pembelian_langsung.js');
        $this->layout->add_css('pages/EC_menu_nav.css');
        $this->layout->add_js('pages/EC_nav_tree.js');
        $this->layout->add_css('pages/EC_nav_tree.css');
        $this->layout->render('histori_po', $data);
    }

    public function perbandingan($cheat = false)
    {
        $this->load->model('ec_ecatalog_m');
        $result = $this->ec_ecatalog_m->getPebandingan($this->session->userdata['ID']);
        $datalk = array();
        for ($i = 0; $i < sizeof($result); $i++) {
            $result2 = $this->ec_ecatalog_m->getLongteks($result[$i]['MATNR']);
            $datalk[] = $result2[0]['LNGTX'];
        }

        $data['title'] = "E-Catalog";
        $data['longteks'] = $datalk;
        $data['compare'] = $result;
        // header('Content-Type: application/json');
        // var_dump($data);
        //$data['pc_code'] = $this -> getPC_CODE();
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        //$this -> layout -> add_js('pages/EC_pembelian_langsung.js');
        $this->layout->add_css('pages/EC_menu_nav.css');
        $this->layout->add_js('pages/EC_affix_compare.js');
        $this->layout->add_js('pages/EC_nav_tree.js');
        $this->layout->add_css('pages/EC_nav_tree.css');
        if (sizeof($result) < 1) {
            redirect("EC_Ecatalog_Marketplace/listCatalog/");
        }
        $this->layout->render('perbandingan', $data);
    }

    public function perbandingan_pl($cheat = false)
    {
        $this->load->model('ec_ecatalog_m');
        $result = $this->ec_ecatalog_m->getPebandingan_lgsg($this->session->userdata['ID'], 'PL2017');
        $datalk = array();
        for ($i = 0; $i < sizeof($result); $i++) {
            $result2 = $this->ec_ecatalog_m->getLongteks($result[$i]['MATNO']);
            $datalk[] = $result2[0]['LNGTX'];
        }

        $data['title'] = "E-Catalog";
        $data['longteks'] = $datalk;
        $data['compare'] = $result;
        // header('Content-Type: application/json');
        // var_dump($data);
        //$data['pc_code'] = $this -> getPC_CODE();
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        //$this -> layout -> add_js('pages/EC_pembelian_langsung.js');
        $this->layout->add_css('pages/EC_menu_nav.css');
        $this->layout->add_js('pages/EC_affix_compare2.js');
        $this->layout->add_js('pages/EC_nav_tree.js');
        $this->layout->add_css('pages/EC_nav_tree.css');
        if (sizeof($result) < 1) {
            redirect("EC_Ecatalog_Marketplace/listCatalogLsgs/");
        }
        $this->layout->render('perbandingan_lgsg', $data);
    }

    function getALL($dataa = '')
    {
        $i = 1;
        $data_tabel = array();
        foreach ($dataa as $value) {
            $netprice = $value['netprice'] = !null ? $value['netprice'] : "0";
            if ($value['curr'] == 'IDR') {
                $netprice = $netprice * 100;
            }
            $data[0] = $i++;
            $data[1] = $value['MATNR'] = !null ? $value['MATNR'] : "";
            $data[2] = $value['MAKTX'] = !null ? $value['MAKTX'] : "";
            $data[3] = $netprice;
            $data[4] = "";
            $data[5] = $value['contract_no'] = !null ? $value['contract_no'] : "";
            $data[6] = $value['t_qty'] = !null ? $value['t_qty'] : "";
            $data[7] = $value['vendorname'] = !null ? $value['vendorname'] : "";
            $data[8] = $value['PC_CODE'] == null ? "" : $value['PC_CODE'];
            $data[9] = $value['validstart'] = !null ? $value['validstart'] : "";
            $data[10] = $value['validend'] = !null ? $value['validend'] : "";
            $data[11] = $value['plant'] == null ? "0" : $value['plant'];
            $data[12] = $value['PICTURE'] == null ? "default_post_img.png" : $value['PICTURE'];
            $data[13] = $value['uom'] == null ? "" : $value['uom'];
            $data[14] = $value['vendorno'] == null ? "0" : $value['vendorno'];
            $data[15] = $value['curr'] == null ? "0" : $value['curr'];
            $data[16] = $value['DESC'] == null ? "-" : $value['DESC'];
            $data[17] = $value['inco1'] == null ? "" : $value['inco1'];
            $data[18] = $value['inco2'] == null ? "" : $value['inco2'];
            $data[19] = $value['ID_CAT'] == null ? "" : $value['ID_CAT'];
            $data[20] = $value['PC_NAME'] == null ? "" : $value['PC_NAME'];
            $data_tabel[] = $data;
        }
        return $data_tabel;
    }

    function get_data_tag($value)
    {
        $this->load->model('ec_ecatalog_m');
        // var_dump(
        // header('Content-Type: application/json');
        $dataa = $this->ec_ecatalog_m->get_data_tag($value, $this->input->post('limitMin'), $this->input->post('limitMax'));
        $page = $this->ec_ecatalog_m->getAllCount('tag', $value);
        $json_data = array('page' => $page, 'data' => $this->getALL($dataa));
        echo json_encode($json_data);
        // var_dump($dataa);
        // $this -> listCatalog($dataa);
    }

    function get_data_harga($kode)
    {
        $this->load->model('ec_ecatalog_m');
        // var_dump(
        // header('Content-Type: application/json');
        $dataa = $this->ec_ecatalog_m->get_data_harga($this->input->post('min'), $this->input->post('max'),
            $this->input->post('limitMin'), $this->input->post('limitMax'), $kode);
        $page = $this->ec_ecatalog_m->getAllCount('harga', $this->input->post('min'), $this->input->post('max'));
        $json_data = array('page' => $page, 'data' => $this->getALL($dataa));

        echo json_encode($json_data);
        // var_dump($dataa);
        // $this -> listCatalog($dataa);
    }

    function get_data_category($value)
    {
        $this->load->model('ec_ecatalog_m');
        // var_dump(
        // header('Content-Type: application/json');
        $dataa = $this->ec_ecatalog_m->get_data_category($value, $this->input->post('limitMin'), $this->input->post('limitMax'), $this->session->userdata['COMPANYID']);
        $page = $this->ec_ecatalog_m->getAllCount('cat', $value);
        $json_data = array('page' => $page, 'data' => $this->getALL($dataa));
        echo json_encode($json_data);
        // var_dump($dataa);
        // $this -> listCatalog($dataa);
    }

    public function testi($value = '')
    {
        header('Content-Type: application/json');
        echo(json_encode($this->session->userdata));
    }

    public function simpanCC()
    {
        $this->load->model('ec_ecatalog_m');
        $this->ec_ecatalog_m->simpanCC($this->session->userdata['ID'], $this->input->post('cc'));
        redirect("EC_Ecatalog_Marketplace/" . $this->input->post('menu'));
    }

    public function simpanCCBeforeBuy()
    {
        //var_dump($this->input->post('cc'));
        $this->load->model('ec_ecatalog_m');
        $this->ec_ecatalog_m->simpanCC($this->session->userdata['ID'], $this->input->post('cc'));
        //redirect("EC_Ecatalog_Marketplace/" . $this->input->post('menu'));
    }

    public function hapus_compare($matno)
    {
        $this->load->model('ec_ecatalog_m');
        $this->ec_ecatalog_m->hapus_compare($this->session->userdata['ID'], $matno, $this->uri->segment(4));
        $result = $this->ec_ecatalog_m->getPebandingan($this->session->userdata['ID']);
        if (sizeof($result) == 0) {
            redirect("EC_Ecatalog_Marketplace/listCatalog/");
        }
        redirect("EC_Ecatalog_Marketplace/perbandingan");
    }

    public function hapus_compare_pl($matno)
    {
        $this->load->model('ec_ecatalog_m');
        $this->ec_ecatalog_m->hapus_compare_pl($this->session->userdata['ID'], $matno, $this->uri->segment(4));
        $result = $this->ec_ecatalog_m->getPebandingan($this->session->userdata['ID']);
        if (sizeof($result) == 0) {
            redirect("EC_Ecatalog_Marketplace/listCatalogLsgs/");
        }
        redirect("EC_Ecatalog_Marketplace/perbandingan_pl");
    }

    public function confirm($cheat = false)
    {
        $gagalReturn = array();
        $dataPO = '';
        $this->load->model('ec_ecatalog_m');
        $this->load->library('sap_handler');
        $dataa = $this->ec_ecatalog_m->get_data_checkout_PO($this->session->userdata['ID']);
        // header('Content-Type: application/json');
        $cntr = "-";
        $kirim = array();
        $sukses = 0;
        for ($i = 0; $i < sizeof($dataa); $i++) {
            if ($cntr != $dataa[$i]['contract_no']) {
                // var_dump($kirim);
                if (sizeof($kirim) != 0) {
                    $kmbl = $this->sap_handler->createPOCatalog($this->input->post('company'), $this->session->userdata['ID'], $kirim, $this->input->post('docdate'), $this->input->post('doctype'), $this->input->post('deliverydate'), $this->input->post('purcorg'), $this->input->post('purcgroup'), false);
                    /*$kmbl = $this->sap_handler->createPOCatalog($this->session->userdata['COMPANYID'], $this->session->userdata['ID'],
                        $kirim, false);*/
                    // if (strpos($kmbl, 'PO created') != FALSE) {
                    if ($kmbl['RETURN'][0]['TYPE'] == 'S') {
                        $sukses = 1;
                        $this->ec_ecatalog_m->POsuccess($this->session->userdata['ID'], $kmbl['RETURN'][0]['MESSAGE_V2'], $kirim[0]['contract_no']);
                    }/*else{
                    	for ($i=0; $i < sizeof($kmbl['RETURN']); $i++) { 
			            	if($kmbl['RETURN'][$i]['TYPE'] == 'E'){
			            		$gagalReturn[$i] = $kmbl['RETURN'][$i]['MESSAGE'];
			            	}
			            }
                    }*/
                }
                $kirim = array();
                $cntr = $dataa[$i]['contract_no'];
                $kirim[] = $dataa[$i];
            } else {
                $kirim[] = $dataa[$i];
            }
        }
        // var_dump($kirim);
        $kmbl = $this->sap_handler->createPOCatalog($this->input->post('company'), $this->session->userdata['ID'], $kirim, $this->input->post('docdate'), $this->input->post('doctype'), $this->input->post('deliverydate'), $this->input->post('purcorg'), $this->input->post('purcgroup'), false);
        // var_dump($kmbl);
        // if (strpos($kmbl, 'PO created') != FALSE) {
        if ($kmbl['RETURN'][0]['TYPE'] == 'S') {
            $sukses = 1;
            $this->ec_ecatalog_m->POsuccess($this->session->userdata['ID'], $kmbl['RETURN'][0]['MESSAGE_V2'], $kirim[0]['contract_no']);
            // echo json_encode($kmbl);
        } else {
            for ($i = 0; $i < sizeof($kmbl['RETURN']); $i++) {
                if ($kmbl['RETURN'][$i]['TYPE'] == 'E') {
                    $gagalReturn[$i] = $kmbl['RETURN'][$i]['MESSAGE'];
                    // $gagalReturn[$i] = 'a';
                }
            }
        }
        // else {
        if ($sukses == 1) {
            $dataPO = $this->ec_ecatalog_m->get_data_checkout_after_PO($dataa);
        }

        // var_dump($dataPO);
        // echo json_encode($dataPO);
        // }
        echo json_encode(array('suksesReturn' => $dataPO, 'gagalReturn' => $gagalReturn));
    }

    public function confirm_plOLD2($cheat = false)
    {
        $this->load->model('ec_ecatalog_m');
        $this->load->library('sap_handler');
        $dataa = $this->ec_ecatalog_m->get_data_checkout_PO_PL($this->session->userdata['ID']);
        header('Content-Type: application/json');
//        echo json_encode($dataa);
//        return;
        $suksesReturn = array();
        $gagalReturn = array();
        for ($i = 0; $i < sizeof($dataa); $i++) {
            $return =
                $this->sap_handler->createPOLangsung($this->session->userdata['COMPANYID'], $this->session->userdata['ID'], array($dataa[$i]), null,
                    false);
            $kmbl = "";
            $sukses = false;
            foreach ($return as $value) {
                if ($value['TYPE'] == 'S') {
                    $kmbl = $value['MESSAGE'];
                    $sukses = true;
                }
            }
            if ($sukses) {
                $this->ec_ecatalog_m->POsuccessPL($dataa[$i]['ID_CHART'], $kmbl, $dataa[$i]['QTY']);
                $dataPO = $this->ec_ecatalog_m->get_data_checkout_after_PO_PL($dataa);
                $kmbl2 = explode('Pembelian Langsung created under the number ', $kmbl);
                $suksesReturn[] = array("PO" => $kmbl2[1], "MATNO" => $dataa[$i]['MATNR'], "MAKTX" => $dataa[$i]['MAKTX'],
                    "PLANT" => $dataa[$i]['PLANT'], "NAMA_PLANT" => $dataa[$i]['NAMA_PLANT']);
            } else {
                $this->ec_ecatalog_m->POfailedPL($dataa[$i]['ID_CHART']);
                $gagalReturn[] = $return;
            }
        }
        echo json_encode(array('suksesReturn' => $suksesReturn, 'gagalReturn' => $gagalReturn));
    }

    public function confirm_pl($cheat = false)
    {
        $now = date("d-m-Y H:i:s");
        $this->load->model('ec_ecatalog_m');
        $this->load->library('sap_handler');
        $suksesReturn = array();
        $gagalReturn = array();
        $item_data = $this->ec_ecatalog_m->get_item_checkout_PL($this->session->userdata['ID']);
        for ($a = 0; $a < sizeof($item_data); $a++) {
            $stock_qty = $item_data[$a]['QTY'];
            $stock_data_in = $this->ec_ecatalog_m->getVnd_cek_stok_in($item_data[$a]['MATNO'], $item_data[$a]['PLANT'], $item_data[$a]['VENDORNO'], $item_data[$a]['KODE_PENAWARAN']);
            if ($stock_data_in['STOK'] < $stock_qty) {
                $stock_lebih = $stock_qty - $stock_data_in['STOK'];
                $stock_data = $this->ec_ecatalog_m->getVnd_cek_stok($item_data[$a]['MATNO'], $item_data[$a]['PLANT'], $item_data[$a]['VENDORNO']);
                $this->ec_ecatalog_m->update_qty_in($item_data[$a]['ID_CHART'], $stock_data_in['STOK']);
                for ($b = 0; $b < sizeof($stock_data); $b++) {
                    if ($stock_lebih > $stock_data[$b]['STOK']) {
                        $stock_lebih = $stock_lebih - $stock_data[$b]['STOK'];

                        $this->ec_ecatalog_m->addCart($item_data[$a]['MATNO'], 'PL2017', $this->session->userdata['ID'],
                            date("d-m-Y H:i:s"), $stock_data[$b]['KODE_DETAIL_PENAWARAN'], $item_data[$a]['COSCENTER'], $stock_data[$b]['STOK'], 0, 0);
                    } else {
                        $this->ec_ecatalog_m->addCart($item_data[$a]['MATNO'], 'PL2017', $this->session->userdata['ID'],
                            date("d-m-Y H:i:s"), $stock_data[$b]['KODE_DETAIL_PENAWARAN'], $item_data[$a]['COSCENTER'], $stock_lebih, 0, 0);
                        break;
                    }
                }
            }
        }

        /*for ($j = 0; $j < sizeof($item_data); $j++) {
            
            $stock_data_in = $this->ec_ecatalog_m->getVnd_cek_stok_in($item_data[$j]['MATNO'],$item_data[$j]['PLANT'],$item_data[$j]['VENDORNO']);
            $stock_sisa=$item_data[$j]['QTY'];
            for ($m=0;$m < sizeof($stock_data_in);$m++)
            {
            //  var_dump($stock_sisa);
                
                if ($stock_data_in[$m]['STOK'] < $stock_sisa)
                {
                    $stock_data = $this->ec_ecatalog_m->getVnd_cek_stok($item_data[$j]['MATNO'],$item_data[$j]['PLANT'],$item_data[$j]['VENDORNO']);
            
                    //update QTY
                    //$this->ec_ecatalog_m->update_qty_in($item_data[$j]['MATNO'],$item_data[$j]['KODE_DETAIL_PENAWARAN'], $this->session->userdata['ID'], $stock_data_in[$m]['STOK']);
                    $this->ec_ecatalog_m->update_qty_in($item_data[$j]['ID_CHART'], $stock_data_in[$m]['STOK']);
                    //var_dump($stock_data);
                    //var_dump($stock_sisa);
                    $stock_sisa =$stock_sisa - $stock_data_in[$m]['STOK'];
                    for ($k = 0; $k < sizeof($stock_data); $k++)
                    {
                    //var_dump($stock_data[$k]['STOK']);
                        if ($stock_data[$k]['STOK'] < $stock_sisa )
                        {
                            $stock_sisa =$stock_sisa - $stock_data[$k]['STOK'];
                            //var_dump ($stock_sisa);
                                $this->ec_ecatalog_m->addCart($item_data[$j]['MATNO'],'PL2017', $this->session->userdata['ID'],
                    date("d-m-Y H:i:s"),$stock_data[$k]['KODE_DETAIL_PENAWARAN'],$item_data[$j]['COSCENTER'], $stock_data[$k]['STOK'], 0, 0);   
                            //$item_data[$j]['COSCENTER']
                                
                        }else
                        {
                            //header('Content-Type: application/json');
                            //var_dump('cost_center'+$item_data[$j]['COSCENTER']);
                            $this->ec_ecatalog_m->addCart($item_data[$j]['MATNO'],'PL2017', $this->session->userdata['ID'],
                    date("d-m-Y H:i:s"),$stock_data[$k]['KODE_DETAIL_PENAWARAN'],$item_data[$j]['COSCENTER'], $stock_sisa, 0, 0);
                            break;
                        }
                    }
                }
                else
                {
                    break;
                }
            }*/

        $po_number = array();
        $cc = $this->ec_ecatalog_m->getCC($this->session->userdata['ID']);
        // var_dump($cc);
        //header('Content-Type: application/json');
        $data_vendor_header = $this->ec_ecatalog_m->get_data_checkout_GROUP_H_vnd($this->session->userdata['ID']);
        // var_dump($data_vendor_header);
        for ($l = 0; $l < sizeof($data_vendor_header); $l++) {

            $dataa = $this->ec_ecatalog_m->get_data_checkout_PO_PL_vendor($this->session->userdata['ID'], $data_vendor_header[$l]['VENDORNO']);
            //header('Content-Type: application/json');
//        echo json_encode($dataa);
//        return;
            // var_dump($dataa);

            $vnd = '-';
            $cart = array();
            for ($i = 0; $i < sizeof($dataa); $i++) {
                if ($vnd != $dataa[$i]['VENDORNO']) {
                    // var_dump($cart);
                    if (sizeof($cart) != 0) {
                        $return = $this->sap_handler->createPOLangsung(
                            $this->session->userdata['COMPANYID'], $this->session->userdata['ID'], $cart, null, false);
                        $kmbl = "";
                        $sukses = false;
                        foreach ($return as $value) {
                            if ($value['TYPE'] == 'S') {
                                $kmbl = $value['MESSAGE'];
                                $sukses = true;
                            }
                        }
                        foreach ($cart as $val) {
                            if ($sukses) {
                                $this->ec_ecatalog_m->POsuccessPL($val['ID_CHART'], $kmbl, $val['QTY'], $val['COSCENTER'], $cart, 'IDR', $now);
                                $kmbl2 = explode('Pembelian Langsung created under the number ', $kmbl);
                                $suksesReturn[] = array("PO" => $kmbl2[1], "MATNO" => $val['MATNR'], "MAKTX" => $val['MAKTX'],
                                    "PLANT" => $val['PLANT'], "NAMA_PLANT" => $val['NAMA_PLANT']);
                                //$po_number[] = $kmbl2[1];
                                // var_dump('tes1');
                            } else {
                                $this->ec_ecatalog_m->POfailedPL($val['ID_CHART']);
                                $gagalReturn[] = $return;
                            }
                        }
                        // $po_number[] = $kmbl2[1];
                    }
                    $vnd = $dataa[$i]['VENDORNO'];
                    $cart = array();
                    $cart[] = $dataa[$i];
                } else if ($vnd == $dataa[$i]['VENDORNO']) {
                    $cart[] = $dataa[$i];
//                continue;
                }
//            $vnd = $dataa[$i]['VENDORNO'];
//            $cart = array();
//            $cart[] = $dataa[$i];
            }
            // var_dump($cart);
            $return =
                $this->sap_handler->createPOLangsung($this->session->userdata['COMPANYID'], $this->session->userdata['ID'], $cart, null, false);
            $kmbl = "";
            $sukses = false;
            // var_dump($return);
            foreach ($return as $value) {
                if ($value['TYPE'] == 'S') {
                    $kmbl = $value['MESSAGE'];
                    $sukses = true;
                }
            }
            foreach ($cart as $val) {
                if ($sukses) {
                    $this->ec_ecatalog_m->POsuccessPL($val['ID_CHART'], $kmbl, $val['QTY'], $val['COSCENTER'], $cart, 'IDR', $now);
                    $kmbl2 = explode('Pembelian Langsung created under the number ', $kmbl);
                    $suksesReturn[] = array("PO" => $kmbl2[1], "MATNO" => $val['MATNR'], "MAKTX" => $val['MAKTX'],
                        "PLANT" => $val['PLANT'], "NAMA_PLANT" => $val['NAMA_PLANT']);
                    //$po_number[] = $kmbl2[1];
                    // var_dump('tes2');
                } else {
                    $this->ec_ecatalog_m->POfailedPL($val['ID_CHART']);
                    $gagalReturn[] = $return;
                }
            }
            // var_dump('insert-end');
            if ($sukses) {
                $po_number[] = $kmbl2[1];

                $this->ec_ecatalog_m->InsertApproval($kmbl2[1], $cc['COSTCENTER'], $now);
                //INSERT FOR LINE_ITEM
                // for ($d = 0; $d < sizeof($po_number); $d++) {
                $return = $this->sap_handler->getDetailPO($kmbl2[1]);
                for ($e = 0; $e < sizeof($return); $e++) {
                    $itempo = $this->ec_ecatalog_m->getItemforLinePO($kmbl2[1]);
                    for ($f = 0; $f < sizeof($itempo); $f++) {
                        if ($return[$e]['MATERIAL'] == $itempo[$f]['MATNO'] && $return[$e]['PO_NUMBER'] == $itempo[$f]['PO_NO']) {
                            $this->ec_ecatalog_m->updateLineItemPO($itempo[$f]['ID_CHART'], $return[$e]['PO_ITEM']);
                        }
                    }
                }
                // }
                //INSERT FOR HEADER GR
                // for ($d = 0; $d < sizeof($po_number); $d++) {
                $itempo = $this->ec_ecatalog_m->getItemforLinePO($kmbl2[1]);
                for ($f = 0; $f < sizeof($itempo); $f++) {
                    $this->ec_ecatalog_m->insertHeaderGR($itempo[$f]['PO_NO'], $itempo[$f]['MATNO'], $itempo[$f]['LINE_ITEM'], $itempo[$f]['QTY'], $now, $itempo[$f]['ID_CHART']);
                }
                // }
            }
        }
        /*var_dump($po_number);
        if ($sukses) {
            // var_dump($po_number);
            for ($c = 0; $c < sizeof($po_number); $c++) {
            	$this->ec_ecatalog_m->InsertApproval($po_number[$c], $cc['COSTCENTER'], $now);
            }
            //INSERT FOR LINE_ITEM
            for ($d = 0; $d < sizeof($po_number); $d++) {
                $return = $this->sap_handler->getDetailPO($po_number[$d]);
                for ($e = 0; $e < sizeof($return); $e++) {
                    $itempo = $this->ec_ecatalog_m->getItemforLinePO($po_number[$d]);
                    for ($f = 0; $f < sizeof($itempo); $f++) {
                        if($return[$e]['MATERIAL']==$itempo[$f]['MATNO'] && $return[$e]['PO_NUMBER']==$itempo[$f]['PO_NO']){
                            $this->ec_ecatalog_m->updateLineItemPO($itempo[$f]['ID_CHART'], $return[$e]['PO_ITEM']);
                        }
                    }
                }
            }

            //INSERT FOR HEADER GR
            for ($d = 0; $d < sizeof($po_number); $d++) {
                $itempo = $this->ec_ecatalog_m->getItemforLinePO($po_number[$d]);
                for ($f = 0; $f < sizeof($itempo); $f++) {
                    $this->ec_ecatalog_m->insertHeaderGR($itempo[$f]['PO_NO'], $itempo[$f]['MATNO'], $itempo[$f]['LINE_ITEM'], $itempo[$f]['QTY'], $now, $itempo[$f]['ID_CHART']);
                }
            }
        }*/
        echo json_encode(array('suksesReturn' => $suksesReturn, 'gagalReturn' => $gagalReturn));
    }

    public function confirm_pl_OLD1($cheat = false)
    {
        $now = date("d-m-Y H:i:s");
        $this->load->model('ec_ecatalog_m');
        $this->load->library('sap_handler');
        $suksesReturn = array();
        $gagalReturn = array();
        $item_data = $this->ec_ecatalog_m->get_data_checkout_PO_PL($this->session->userdata['ID']);
        for ($j = 0; $j < sizeof($item_data); $j++) {

            $stock_data_in = $this->ec_ecatalog_m->getVnd_cek_stok_in($item_data[$j]['MATNO'], $item_data[$j]['PLANT'], $item_data[$j]['VENDORNO']);
            $stock_sisa = $item_data[$j]['QTY'];
            for ($m = 0; $m < sizeof($stock_data_in); $m++) {
                //	var_dump($stock_sisa);

                if ($stock_data_in[$m]['STOK'] < $stock_sisa) {
                    $stock_data = $this->ec_ecatalog_m->getVnd_cek_stok($item_data[$j]['MATNO'], $item_data[$j]['PLANT'], $item_data[$j]['VENDORNO']);

                    //update QTY
                    //$this->ec_ecatalog_m->update_qty_in($item_data[$j]['MATNO'],$item_data[$j]['KODE_DETAIL_PENAWARAN'], $this->session->userdata['ID'], $stock_data_in[$m]['STOK']);
                    $this->ec_ecatalog_m->update_qty_in($item_data[$j]['ID_CHART'], $stock_data_in[$m]['STOK']);
                    //var_dump($stock_data);
                    //var_dump($stock_sisa);
                    $stock_sisa = $stock_sisa - $stock_data_in[$m]['STOK'];
                    for ($k = 0; $k < sizeof($stock_data); $k++) {
                        //var_dump($stock_data[$k]['STOK']);
                        if ($stock_data[$k]['STOK'] < $stock_sisa) {
                            $stock_sisa = $stock_sisa - $stock_data[$k]['STOK'];
                            //var_dump ($stock_sisa);
                            $this->ec_ecatalog_m->addCart($item_data[$j]['MATNO'], 'PL2017', $this->session->userdata['ID'],
                                date("d-m-Y H:i:s"), $stock_data[$k]['KODE_DETAIL_PENAWARAN'], $item_data[$j]['COSCENTER'], $stock_data[$k]['STOK'], 0, 0);
                            //$item_data[$j]['COSCENTER']

                        } else {
                            //header('Content-Type: application/json');
                            //var_dump('cost_center'+$item_data[$j]['COSCENTER']);
                            $this->ec_ecatalog_m->addCart($item_data[$j]['MATNO'], 'PL2017', $this->session->userdata['ID'],
                                date("d-m-Y H:i:s"), $stock_data[$k]['KODE_DETAIL_PENAWARAN'], $item_data[$j]['COSCENTER'], $stock_sisa, 0, 0);
                            break;
                        }
                    }
                } else {
                    break;
                }
            }


            $data_vendor_header = $this->ec_ecatalog_m->get_data_checkout_GROUP_H_vnd($this->session->userdata['ID']);
            for ($l = 0; $l < sizeof($data_vendor_header); $l++) {

                $dataa = $this->ec_ecatalog_m->get_data_checkout_PO_PL_vendor($this->session->userdata['ID'], $data_vendor_header[$l]['VENDORNO']);
                //header('Content-Type: application/json');
//        echo json_encode($dataa);
//        return;
                $cc = $this->ec_ecatalog_m->getCC($this->session->userdata['ID']);

                $vnd = '-';
                $cart = array();
                for ($i = 0; $i < sizeof($dataa); $i++) {
                    if ($vnd != $dataa[$i]['VENDORNO']) {
//                var_dump($cart);
                        if (sizeof($cart) != 0) {
                            $return = $this->sap_handler->createPOLangsung(
                                $this->session->userdata['COMPANYID'], $this->session->userdata['ID'], $cart, null, false);
                            $kmbl = "";
                            $sukses = false;
                            foreach ($return as $value) {
                                if ($value['TYPE'] == 'S') {
                                    $kmbl = $value['MESSAGE'];
                                    $sukses = true;
                                }
                            }
                            foreach ($cart as $val)
                                if ($sukses) {
                                    $this->ec_ecatalog_m->POsuccessPL($val['ID_CHART'], $kmbl, $val['QTY'], $val['COSCENTER'], $cart, 'IDR', $now);
                                    $kmbl2 = explode('Pembelian Langsung created under the number ', $kmbl);
                                    $suksesReturn[] = array("PO" => $kmbl2[1], "MATNO" => $val['MATNR'], "MAKTX" => $val['MAKTX'],
                                        "PLANT" => $val['PLANT'], "NAMA_PLANT" => $val['NAMA_PLANT']);
                                } else {
                                    $this->ec_ecatalog_m->POfailedPL($val['ID_CHART']);
                                    $gagalReturn[] = $return;
                                }
                        }
                        $vnd = $dataa[$i]['VENDORNO'];
                        $cart = array();
                        $cart[] = $dataa[$i];
                    } else if ($vnd == $dataa[$i]['VENDORNO']) {
                        $cart[] = $dataa[$i];
//                continue;
                    }
//            $vnd = $dataa[$i]['VENDORNO'];
//            $cart = array();
//            $cart[] = $dataa[$i];
                }
                $return =
                    $this->sap_handler->createPOLangsung($this->session->userdata['COMPANYID'], $this->session->userdata['ID'], $cart, null, false);
                $kmbl = "";
                $sukses = false;
                foreach ($return as $value) {
                    if ($value['TYPE'] == 'S') {
                        $kmbl = $value['MESSAGE'];
                        $sukses = true;
                    }
                }
                foreach ($cart as $val)
                    if ($sukses) {
                        $this->ec_ecatalog_m->POsuccessPL($val['ID_CHART'], $kmbl, $val['QTY'], $val['COSCENTER'], $cart, 'IDR', $now);
                        $kmbl2 = explode('Pembelian Langsung created under the number ', $kmbl);
                        $suksesReturn[] = array("PO" => $kmbl2[1], "MATNO" => $val['MATNR'], "MAKTX" => $val['MAKTX'],
                            "PLANT" => $val['PLANT'], "NAMA_PLANT" => $val['NAMA_PLANT']);
                    } else {
                        $this->ec_ecatalog_m->POfailedPL($val['ID_CHART']);
                        $gagalReturn[] = $return;
                    }

            }
        }
        echo json_encode(array('suksesReturn' => $suksesReturn, 'gagalReturn' => $gagalReturn));
    }

    public function confirm_pl_duplicate($cheat = false)
    {
        $now = date("d-m-Y H:i:s");
        $this->load->model('ec_ecatalog_m');
        $this->load->library('sap_handler');
        $dataa = $this->ec_ecatalog_m->get_data_checkout_PO_PL($this->session->userdata['ID']);
        header('Content-Type: application/json');
//        echo json_encode($dataa);
//        return;
        $cc = $this->ec_ecatalog_m->getCC($this->session->userdata['ID']);
        $suksesReturn = array();
        $gagalReturn = array();
        $vnd = '-';
        $cart = array();
        for ($i = 0; $i < sizeof($dataa); $i++) {
            if ($vnd != $dataa[$i]['VENDORNO']) {
//                var_dump($cart);
                if (sizeof($cart) != 0) {
                    $return = $this->sap_handler->createPOLangsung(
                        $this->session->userdata['COMPANYID'], $this->session->userdata['ID'], $cart, null, false);
                    $kmbl = "";
                    $sukses = false;
                    foreach ($return as $value) {
                        if ($value['TYPE'] == 'S') {
                            $kmbl = $value['MESSAGE'];
                            $sukses = true;
                        }
                    }
                    foreach ($cart as $val)
                        if ($sukses) {
                            $this->ec_ecatalog_m->POsuccessPL($val['ID_CHART'], $kmbl, $val['QTY'], $val['COSCENTER'], $cart, 'IDR', $now);
                            $kmbl2 = explode('Pembelian Langsung created under the number ', $kmbl);
                            $suksesReturn[] = array("PO" => $kmbl2[1], "MATNO" => $val['MATNR'], "MAKTX" => $val['MAKTX'],
                                "PLANT" => $val['PLANT'], "NAMA_PLANT" => $val['NAMA_PLANT']);
                        } else {
                            $this->ec_ecatalog_m->POfailedPL($val['ID_CHART']);
                            $gagalReturn[] = $return;
                        }
                }
                $vnd = $dataa[$i]['VENDORNO'];
                $cart = array();
                $cart[] = $dataa[$i];
            } else if ($vnd == $dataa[$i]['VENDORNO']) {
                $cart[] = $dataa[$i];
//                continue;
            }
//            $vnd = $dataa[$i]['VENDORNO'];
//            $cart = array();
//            $cart[] = $dataa[$i];
        }
        $return =
            $this->sap_handler->createPOLangsung($this->session->userdata['COMPANYID'], $this->session->userdata['ID'], $cart, null, false);
        $kmbl = "";
        $sukses = false;
        foreach ($return as $value) {
            if ($value['TYPE'] == 'S') {
                $kmbl = $value['MESSAGE'];
                $sukses = true;
            }
        }
        foreach ($cart as $val)
            if ($sukses) {
                $this->ec_ecatalog_m->POsuccessPL($val['ID_CHART'], $kmbl, $val['QTY'], $val['COSCENTER'], $cart, 'IDR', $now);
                $kmbl2 = explode('Pembelian Langsung created under the number ', $kmbl);
                $suksesReturn[] = array("PO" => $kmbl2[1], "MATNO" => $val['MATNR'], "MAKTX" => $val['MAKTX'],
                    "PLANT" => $val['PLANT'], "NAMA_PLANT" => $val['NAMA_PLANT']);
            } else {
                $this->ec_ecatalog_m->POfailedPL($val['ID_CHART']);
                $gagalReturn[] = $return;
            }
        echo json_encode(array('suksesReturn' => $suksesReturn, 'gagalReturn' => $gagalReturn));
    }

    public function confirm_plOLD($cheat = false)
    {
        $this->load->model('ec_ecatalog_m');
        $this->load->library('sap_handler');
        $dataa = $this->ec_ecatalog_m->get_data_checkout_PO_PL($this->session->userdata['ID']);
        // header('Content-Type: application/json');
        // var_dump($dataa);return;
        $cntr = "-";
        $kirim = array();
        for ($i = 0; $i < sizeof($dataa); $i++) {
            if ($cntr != $dataa[$i]['VENDORNO']) {
                // var_dump($kirim);
                if (sizeof($kirim) != 0) {
                    $kmbl = $this->sap_handler->createPOLangsung($this->session->userdata['COMPANYID'], $this->session->userdata['ID'],
                        $kirim, false);
                    if (strpos($kmbl, 'PO created') != FALSE) {
                        $this->ec_ecatalog_m->POsuccess($this->session->userdata['ID'], $kmbl, $kirim[0]['VENDORNO']);
                    }
                }
                $kirim = array();
                $cntr = $dataa[$i]['VENDORNO'];
                $kirim[] = $dataa[$i];
            } else {
                $kirim[] = $dataa[$i];
            }
        }
        // var_dump($kirim);
        $kmbl = $this->sap_handler->createPOCatalog($this->session->userdata['COMPANYID'], $this->session->userdata['ID'], $kirim, false);
        if (strpos($kmbl, 'PO created') != FALSE) {
            $this->ec_ecatalog_m->POsuccess($this->session->userdata['ID'], $kmbl, $kirim[0]['contract_no']);
            // echo json_encode($kmbl);
        }
        // else {
        $dataPO = $this->ec_ecatalog_m->get_data_checkout_after_PO($dataa);
        // var_dump($dataPO);
        echo json_encode($dataPO);
        // }
    }

    public function confirmOne()
    {
        $gagalReturn = array();
        $dataPO = '';
        $this->load->model('ec_ecatalog_m');
        // header('Content-Type: application/json');
        $qty = $this->input->post("qty");
        $this->ec_ecatalog_m->addCart($this->input->post('matno'), $this->input->post("contract_no"), $this->session->userdata['ID'],
            date("d-m-Y H:i:s"), $this->input->post("kode_penawaran"), 0, $qty, 1, 0);

        $dataa = $this->ec_ecatalog_m->get_data_checkout_PO_One($this->session->userdata['ID'], $this->input->post('contract_no'),
            $this->input->post('matno'));
        // var_dump($dataa);
        $this->load->library('sap_handler');
        $kmbl = $this->sap_handler->createPOCatalog($this->input->post('company'), $this->session->userdata['ID'], $dataa, $this->input->post('docdate'), $this->input->post('doctype'), $this->input->post('deliverydate'), $this->input->post('purcorg'), $this->input->post('purcgroup'), false);
        // var_dump($kmbl);
        if ($kmbl['RETURN'][0]['TYPE'] == 'S') {
            // if (strpos($kmbl, 'Pembelian Kontrak created under the number') != FALSE) {
            $this->ec_ecatalog_m->POsuccessOne($this->session->userdata['ID'], $this->input->post('contract_no'),
                $this->input->post('matno'), $kmbl['RETURN'][0]['MESSAGE_V2'], $dataa[0]['ID_CHART']);
            $dataPO = $this->ec_ecatalog_m->get_data_checkout_after_PO($dataa);
            // echo json_encode($dataPO);
        } else {
            $this->ec_ecatalog_m->POfailedOne($this->session->userdata['ID'], $this->input->post('contract_no'),
                $this->input->post('matno'), $dataa[0]['ID_CHART']);
            // var_dump($kmbl);
            for ($i = 0; $i < sizeof($kmbl['RETURN']); $i++) {
                if ($kmbl['RETURN'][$i]['TYPE'] == 'E') {
                    $gagalReturn[$i] = $kmbl['RETURN'][$i]['MESSAGE'];
                }
            }
            /*foreach ($kmbl as $value) {
            	// var_dump($value);
            	if($value['RETURN'][0]['TYPE']=='E'){
            		$gagalReturn[] = $value['RETURN'][0]['MESSAGE'];
            	}            	
            }*/
            // echo json_encode('gagal');
        }
        echo json_encode(array('suksesReturn' => $dataPO, 'gagalReturn' => $gagalReturn));
    }

    public function tesvn($value = '603-200850')
    {
        $this->load->model('ec_ecatalog_m');
        //         header('Content-Type: application/json');
        $dataa = $this->ec_ecatalog_m->getVndConfirm2($value);
        //         var_dump($dataa);
        $qty = $this->uri->segment(4);
        $i = 0;
        echo "beli: " . $qty . "<br/>";
        while ($qty > 0 && $i < sizeof($dataa)) {
            $stok = $dataa[$i]['STOK'];
            if ($stok - $qty >= 0) {
                echo "<br/> kode: " . $dataa[$i]['KODE_DETAIL_PENAWARAN'] . " vnd: " . $dataa[$i]['VENDORNO'] . " stok: " . $stok . " ambil: " . ($qty) . " sisa stok: " . ($stok - $qty) . "<br/>";
//                $qty -= $stok;
                if (($i + 1) < sizeof($dataa) && ($stok - $qty) == 0)
                    echo "<br/> kode: " . $dataa[$i + 1]['KODE_DETAIL_PENAWARAN'] . " vnd: " . $dataa[$i + 1]['VENDORNO'] . " stok: " . $dataa[$i + 1]['STOK'] . " ambil: 0 sisa stok: " . ($dataa[$i + 1]['STOK']) . "<br/>";
                $qty = 0;
            } else {
                $qty -= $stok;
                echo "<br/> kode: " . $dataa[$i]['KODE_DETAIL_PENAWARAN'] . " vnd: " . $dataa[$i]['VENDORNO'] . " stok: " . $stok . " ambil: " . $stok . " sisa stok: 0 blm: " . $qty . "<br/>";
                $i++;
            }
        }
        echo "<br/>qty " . $qty;
        // echo json_encode($dataa);
    }

    /*public function tesconfirmOneLgsg()
    {
        $this->load->model('ec_ecatalog_m');
        $datachart = $this->ec_ecatalog_m->get_data_checkout_PO_One_PL($this->session->userdata['ID'], 'PL2017', '603-200850');
        echo json_encode($datachart);
    }*/

    public function confirmOneLgsg($value = '')
    {
        $now = date("d-m-Y H:i:s");
        $suksesReturn = array();
        $gagalReturn = array();
        $po_number = array();
        $this->load->model('ec_ecatalog_m');
        $this->load->library('sap_handler');
        $dataa = $this->ec_ecatalog_m->getVndConfirm2($this->input->post("matno"), $this->input->post("plant"), $this->input->post("kode_penawaran"));
//        var_dump($dataa);die();
        $costc = explode(':', $this->input->post("cc"));
        $kd_funcloc = explode(':', $this->input->post("funcloc"));
        // $cc = $this->ec_ecatalog_m->getCC($this->session->userdata['ID']);
        $cc = $costc[0];
        // var_dump($costc);
        // var_dump($kd_funcloc);
        $qty = $this->input->post("qty");
        $i = 0;
        while ($qty > 0 && $i < sizeof($dataa)) {
            $stok = $dataa[$i]['STOK'];
            if ($stok - $qty >= 0) {
//                echo "<br/> kode: " . $dataa[$i]['KODE_DETAIL_PENAWARAN'] . " vnd: " . $dataa[$i]['VENDORNO'] . " stok: " . $stok . " ambil: " . ($qty) . " sisa stok: " . ($stok - $qty) . "<br/>";
                $this->ec_ecatalog_m->addCart($dataa[$i]['MATNO'], $this->input->post("contract_no"), $this->session->userdata['ID'],
                    date("d-m-Y H:i:s"), $dataa[$i]['KODE_DETAIL_PENAWARAN'], $cc, $qty, 1, 0, $this->input->post("alasan"), $kd_funcloc[0], $this->input->post("keterangan"), $this->input->post("filename"));
                $cart = $this->ec_ecatalog_m->get_data_checkout_PO_One_PL($this->session->userdata['ID'], $this->input->post('contract_no'), $dataa[$i]['MATNO']);
//                var_dump($cart);die();                
                $return = $this->sap_handler->createPOLangsung($this->input->post("company"), $this->session->userdata['ID'], $cart, null,
                    false);
                $kmbl = "";
                $sukses = false;
                foreach ($return as $value) {
                    if ($value['TYPE'] == 'S') {
                        $kmbl = $value['MESSAGE'];
                        $sukses = true;
                    }
                }

                if ($sukses) {
                    $this->ec_ecatalog_m->POsuccessOnePL($this->session->userdata['ID'], $this->input->post('contract_no'),
                        $dataa[$i]['MATNO'], $kmbl, $cart[0]['ID_CHART'], $qty, $cc, $dataa[$i], $this->input->post('curr'), $this->input->post('alasan'));
                    $kmbl2 = explode('Pembelian Langsung created under the number ', $kmbl);
                    $suksesReturn[] = array("PO" => $kmbl2[1], "MATNO" => $dataa[$i]['MATNO'], "MAKTX" => $dataa[$i]['MAKTX'],
                        "PLANT" => $dataa[$i]['PLANT'], "NAMA_PLANT" => $dataa[$i]['NAMA_PLANT'], "VENDOR_NAME" => $dataa[$i]['VENDOR_NAME']);
                    //echo json_encode($suksesReturn);
                    $sk = 1;
                } else {
                    $this->ec_ecatalog_m->POfailedOne($this->session->userdata['ID'], $this->input->post('contract_no'),
                        $dataa[$i]['MATNO'], $cart[0]['ID_CHART']);
                    $gagalReturn[] = $return;
                    $sk = 0;
//                        echo json_encode($return);
                }

                if (($i + 1) < sizeof($dataa) && ($stok - $qty) == 0) {
//                    echo "<br/> kode: " . $dataa[$i + 1]['KODE_DETAIL_PENAWARAN'] . " vnd: " . $dataa[$i + 1]['VENDORNO'] . " stok: " . $dataa[$i + 1]['STOK'] . " ambil: 0 sisa stok: " . ($dataa[$i + 1]['STOK']) . "<br/>";
                    $this->ec_ecatalog_m->addCart($dataa[$i + 1]['MATNO'], $this->input->post("contract_no"), $this->session->userdata['ID'],
                        date("d-m-Y H:i:s"), $dataa[$i + 1]['KODE_DETAIL_PENAWARAN'], $cc, $qty, 1, 0, $this->input->post("alasan"), $kd_funcloc[0], $this->input->post("keterangan"), $this->input->post("filename"));
                    $cart = $this->ec_ecatalog_m->get_data_checkout_PO_One_PL($this->session->userdata['ID'], $this->input->post('contract_no'),
                        $dataa[$i + 1]['MATNO']);
                    $return = $this->sap_handler->createPOLangsung($this->input->post("company"), $this->session->userdata['ID'], $cart,
                        null, false);
                    $kmbl = "";
                    $sukses = false;
                    foreach ($return as $value) {
                        if ($value['TYPE'] == 'S') {
                            $kmbl = $value['MESSAGE'];
                            $sukses = true;
                        }
                    }
                    if ($sukses) {
                        $this->ec_ecatalog_m->POsuccessOnePL($this->session->userdata['ID'], $this->input->post('contract_no'),
                            $dataa[$i + 1]['MATNO'], $kmbl, $cart[0]['ID_CHART'], $qty, $cc, $dataa[$i], $this->input->post('curr'), $this->input->post('alasan'));
                        $kmbl2 = explode('Pembelian Langsung created under the number ', $kmbl);
                        $suksesReturn[] = array("PO" => $kmbl2[1], "MATNO" => $dataa[$i + 1]['MATNO'], "MAKTX" => $dataa[$i + 1]['MAKTX'],
                            "PLANT" => $dataa[$i + 1]['PLANT'], "NAMA_PLANT" => $dataa[$i + 1]['NAMA_PLANT'], "VENDOR_NAME" => $dataa[$i + 1]['VENDOR_NAME']);
                        $sk = 1;
//                        echo json_encode($kmbl);
                    } else {
                        $this->ec_ecatalog_m->POfailedOne($this->session->userdata['ID'], $this->input->post('contract_no'),
                            $dataa[$i + 1]['MATNO'], $cart[0]['ID_CHART']);
                        $gagalReturn[] = $return;
                        $sk = 0;
//                        echo json_encode($return);
                    }
                }
                $qty = 0;
            } else {
//                echo "<br/> kode: " . $dataa[$i]['KODE_DETAIL_PENAWARAN'] . " vnd: " . $dataa[$i]['VENDORNO'] . " stok: " . $stok . " ambil: " . $stok . " sisa stok: 0 blm: " . $qty . "<br/>";
                $this->ec_ecatalog_m->addCart($dataa[$i]['MATNO'], $this->input->post("contract_no"), $this->session->userdata['ID'],
                    date("d-m-Y H:i:s"), $dataa[$i]['KODE_DETAIL_PENAWARAN'], $cc, $stok, 1, 0, $this->input->post("alasan"), $kd_funcloc[0], $this->input->post("keterangan"), $this->input->post("filename"));
                $cart = $this->ec_ecatalog_m->get_data_checkout_PO_One_PL($this->session->userdata['ID'], $this->input->post('contract_no'),
                    $dataa[$i]['MATNO']);
                $return = $this->sap_handler->createPOLangsung($this->input->post("company"), $this->session->userdata['ID'], $cart, null,
                    false);
                $kmbl = "";
                $sukses = false;
                foreach ($return as $value) {
                    if ($value['TYPE'] == 'S') {
                        $kmbl = $value['MESSAGE'];
                        $sukses = true;
                    }
                }
                if ($sukses) {
                    $this->ec_ecatalog_m->POsuccessOnePL($this->session->userdata['ID'], $this->input->post('contract_no'),
                        $dataa[$i]['MATNO'], $kmbl, $cart[0]['ID_CHART'], $stok, $cc, $dataa[$i], $this->input->post('curr'), $this->input->post('alasan'));
                    $kmbl2 = explode('Pembelian Langsung created under the number ', $kmbl);
                    $suksesReturn[] = array("PO" => $kmbl2[1], "MATNO" => $dataa[$i]['MATNO'], "MAKTX" => $dataa[$i]['MAKTX'],
                        "PLANT" => $dataa[$i]['PLANT'], "NAMA_PLANT" => $dataa[$i]['NAMA_PLANT'], "VENDOR_NAME" => $dataa[$i]['VENDOR_NAME']);
//                        echo json_encode($kmbl);
                    $sk = 1;
                } else {
                    $this->ec_ecatalog_m->POfailedOne($this->session->userdata['ID'], $this->input->post('contract_no'),
                        $dataa[$i]['MATNO'], $cart[0]['ID_CHART']);
                    $gagalReturn[] = $return;
                    $sk = 0;
//                        echo json_encode($return);
                }
                $qty -= $stok;
                $i++;
            }

            if ($sk == 1) {
                $po_number[] = $kmbl2[1];
            }
        }
        //INSERT FOR LINE_ITEM
        for ($d = 0; $d < sizeof($po_number); $d++) {
            $return = $this->sap_handler->getDetailPO($po_number[$d]);
            for ($e = 0; $e < sizeof($return); $e++) {
                $itempo = $this->ec_ecatalog_m->getItemforLinePO($po_number[$d]);
                for ($f = 0; $f < sizeof($itempo); $f++) {
                    if ($return[$e]['MATERIAL'] == $itempo[$f]['MATNO'] && $return[$e]['PO_NUMBER'] == $itempo[$f]['PO_NO']) {
                        $this->ec_ecatalog_m->updateLineItemPO($itempo[$f]['ID_CHART'], $return[$e]['PO_ITEM']);
                    }
                }
            }
        }

        //INSERT FOR HEADER GR
        for ($d = 0; $d < sizeof($po_number); $d++) {
            $itempo = $this->ec_ecatalog_m->getItemforLinePO($po_number[$d]);
            for ($f = 0; $f < sizeof($itempo); $f++) {
                $this->ec_ecatalog_m->insertHeaderGR($itempo[$f]['PO_NO'], $itempo[$f]['MATNO'], $itempo[$f]['LINE_ITEM'], $itempo[$f]['QTY'], $now, $itempo[$f]['ID_CHART']);
            }
        }
        echo json_encode(array('suksesReturn' => $suksesReturn, 'gagalReturn' => $gagalReturn));
    }

    public function emailNotif()
    {
        $this->load->model('ec_master_approval_m');
        $result = $this->ec_master_approval_m->getEmailNotif($this->input->post('CC'), 1);
        echo $result['EMAIL'];
    }

    public function confirmOneLgsgOLD2($value = '')
    {
        // $kmbl = $this -> sap_handler -> createPOLangsung(array('ZBS'), false);  $COSCENTER
        $this->load->model('ec_ecatalog_m');
        // header('Content-Type: application/json');
        $cc = $this->ec_ecatalog_m->getCC($this->session->userdata['ID']);
        //$cc['COSTCENTER']
        $this->ec_ecatalog_m->addCart($this->input->post('matno'), $this->input->post("contract_no"), $this->session->userdata['ID'],
            date("d-m-Y H:i:s"), $this->input->post("kode_penawaran"), $cc, $this->input->post("qty"), 1, 0);
        $detail = array('ID' => $this->session->userdata['ID'], 'PLANT' => $this->input->post('plant'),
            'ALAMAT' => $this->input->post('alamat'), 'CP' => $this->input->post('cp'), 'GL' => $this->input->post('gl'));
        $this->ec_ecatalog_m->addDetail_PL($detail);

        $dataa = $this->ec_ecatalog_m->get_data_checkout_PO_One_PL($this->session->userdata['ID'], $this->input->post('contract_no'),
            $this->input->post('matno'));
        $this->load->library('sap_handler');
        //COMPANYID
        $return = $this->sap_handler->createPOLangsung($this->session->userdata['COMPANYID'], $this->session->userdata['ID'], $dataa,
            $detail, false);
        $kmbl = "";
        $sukses = false;
        foreach ($return as $value) {
            if ($value['TYPE'] == 'S') {
                $kmbl = $value['MESSAGE'];
                $sukses = true;
            }
        }
        // var_dump($kmbl);
        // if (strpos($kmbl, 'created under the number') != FALSE) {
        if ($sukses) {
            $this->ec_ecatalog_m->POsuccessOnePL($this->session->userdata['ID'], $this->input->post('contract_no'),
                $this->input->post('matno'), $kmbl, $dataa[0]['ID_CHART'], $this->input->post("qty"));
            $dataPO = $this->ec_ecatalog_m->get_data_checkout_after_PO_PL($dataa);
            echo json_encode($kmbl);
        } else {
            $this->ec_ecatalog_m->POfailedOne($this->session->userdata['ID'], $this->input->post('contract_no'),
                $this->input->post('matno'), $dataa[0]['ID_CHART']);
            echo json_encode($return);
        }
    }

    public function checkout($cheat = false)
    {
        $data['title'] = "Check Out | E-Catalog";
        $data['cheat'] = $cheat;
        $data['tanggal'] = date("d-m-Y");
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_css('pages/EC_menu_nav.css');
        $this->layout->add_js('pages/EC_nav_tree.js');
        $this->layout->add_css('pages/EC_nav_tree.css');
        $this->layout->add_css('pages/EC_style_ecatalog.css');
        $this->layout->add_css('pages/EC_checkout.css');
        $this->layout->add_js('pages/EC_catalog_checkout_pl.js');
        $this->load->model('ec_company_plant');
        $data['company'] = $this->ec_company_plant->getCompany();
        $data['companyID'] = $this->ec_company_plant->getCompanySpek($this->session->userdata('EM_COMPANY'));
        $this->load->model('ec_ecatalog_m');
        $data['CC'] = $this->COSTCENTER_GETLIST();
        $data['CCC'] = $this->ec_ecatalog_m->getCC($this->session->userdata['ID']);
        $result = $this->sap_handler->GET_REPORTBUDGET(substr($this->session->userdata['EM_COMPANY'], 0, 1), $data['CCC']["COSTCENTER"], false);
        for ($i = 0; $i < sizeof($result); $i++) {
            if ($result[$i]['FIPEX'] == $data['CCC']['GL_ACCOUNT']) {
                $data["AVAILBUDGET"] = $result[$i]["AVAILBUDGET"];
            }
        }
        $this->layout->render('checkout', $data);
    }

    public function checkout_lgsg($cheat = false)
    {
        $data['title'] = "Check Out | E-Catalog";
        $data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_js('plugins/select2/select2.js');
        $this->layout->add_css('plugins/select2/select2.css');
        $this->layout->add_css('plugins/select2/select2-bootstrap.css');
        $this->layout->add_css('pages/EC_menu_nav.css');
        $this->layout->add_js('pages/EC_nav_tree.js');
        $this->layout->add_css('pages/EC_nav_tree.css');
        $this->layout->add_css('pages/EC_style_ecatalog.css');
        $this->layout->add_css('pages/EC_checkout.css');
        $this->layout->add_js('pages/EC_catalog_checkout_pl.js');

        $data['company'] = array(array('COMPANYID' => '2000', 'COMPANYNAME' => 'Semen Indonesia'),
            array('COMPANYID' => '3000', 'COMPANYNAME' => 'Semen Padang'),
            array('COMPANYID' => '4000', 'COMPANYNAME' => 'Semen Tonasa'),
            array('COMPANYID' => '5000', 'COMPANYNAME' => 'Semen Gresik'),
            array('COMPANYID' => '6000', 'COMPANYNAME' => 'Thang Long Cement'),
            array('COMPANYID' => '7000', 'COMPANYNAME' => 'KSO'));
        $this->load->model('ec_ecatalog_m');
        $data['CC'] = $this->COSTCENTER_GETLIST();
        $data['ccc'] = $this->ec_ecatalog_m->getCC($this->session->userdata['ID']);

        $this->layout->render('checkout_lgsg', $data);
    }

    function compares()
    {
        // header('Content-Type: application/json');
        $mat = $this->input->post('arr');
        $xpl = explode(',', $mat[0]);
        $mat = $this->input->post('arrC');
        $xpl2 = explode(',', $mat[0]);
        // print_r($xpl);
        $this->load->model('EC_strategic_material_m');
        // $result = $this -> EC_strategic_material_m -> getDetailCompare($xpl);
        $result = $this->EC_strategic_material_m->getDetailCompare($xpl, $xpl2);
        // var_dump($xpl);
        // var_dump($xpl2);
        // var_dump($result);
        // return "";
        for ($i = 0; $i < sizeof($result); $i++) {
            $result2 = $this->EC_strategic_material_m->getLongteks($result[$i]['MATNR']);
            $datalk[] = $result2[0]['LNGTX'];
        }
        // $data['dataCom']=$result

        $data['title'] = "Comapre Product | E-Catalog";
        //$data['cheat'] = $cheat;
        //$data['pc_code'] = $this -> getPC_CODE();
        $data['data_compare'] = $result;
        $data['longteks'] = $datalk;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_js('pages/EC_pembelian_langsung.js');
        // $this -> layout -> add_css('pages/menu_nav.css');
        $this->layout->render('compare', $data);

        //echo json_encode($result);
    }

    public function teslgtk($ptm = '')
    {
        $this->load->model('EC_strategic_material_m');
        var_dump($this->EC_strategic_material_m->getDetail($ptm));

    }

    function detail_prod($contract_no)
    {
        // header('Content-Type: application/json');
        //$mat = $this -> input -> post('arr');
        //$no_ci = explode(',', $mat[0]);
        // print_r($xpl);
        $this->load->model('EC_strategic_material_m');
        $result = $this->EC_strategic_material_m->getDetailProduk($contract_no, $this->uri->segment(4));
        $result2 = $this->EC_strategic_material_m->getLongteks($result[0]['MATNR']);
        $data['longteks'] = $result2[0]['LNGTX'];
        $this->load->model('ec_ecatalog_m');
        $feedback = $this->ec_ecatalog_m->getfeedback($contract_no, $this->uri->segment(4));
        // str_replace('||','<br />',$result2[0]['LNGTX']) ;
        // $data['dataCom']=$result
        // var_dump($result);
        $data['title'] = "Detail Product | E-Catalog";
        //$data['cheat'] = $cheat;
        //$data['pc_code'] = $this -> getPC_CODE();
        $data['data_produk'] = $result;
        $data['feedback'] = $feedback;
        $data['tanggal'] = date("d-m-Y");
        $data['company'] = array(array('COMPANYID' => '2000', 'COMPANYNAME' => 'Semen Indonesia'),
            array('COMPANYID' => '3000', 'COMPANYNAME' => 'Semen Padang'),
            array('COMPANYID' => '4000', 'COMPANYNAME' => 'Semen Tonasa'),
            array('COMPANYID' => '5000', 'COMPANYNAME' => 'Semen Gresik'),
            array('COMPANYID' => '6000', 'COMPANYNAME' => 'Thang Long Cement'),
            array('COMPANYID' => '7000', 'COMPANYNAME' => 'KSO'));
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/star-rating.min.js');
        $this->layout->add_css('pages/star-rating.min.css');
        //$this -> layout -> add_js('pages/ratingstar.js');
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_pembelian_langsung.js');
        $this->layout->add_css('pages/EC_menu_nav.css');
        $this->layout->add_js('pages/EC_nav_tree.js');
        $this->layout->add_css('pages/EC_nav_tree.css');
        $this->layout->render('detail_produk', $data);

        //echo json_encode($result);
    }

    function teshr()
    {
        header('Content-Type: application/json');
        $this->load->model('ec_ecatalog_m');
        echo json_encode($this->ec_ecatalog_m->getDetailHarga_pl('52'));
    }

    public function testQueryStok($matno, $plant, $comp = '2000')
    {
        $SQL = "SELECT VEN.VENDOR_NAME,TW.*
        FROM (SELECT DT.VENDORNO,DT.KODE_DETAIL_PENAWARAN,DT.PRICE HARGA,DT.PLANT,DT.DELIVERY_TIME,DT.NAMA_PLANT
        ,TB3.STOK,TB3.DESKRIPSI_ITEM, TO_CHAR (
                            TB1.START_DATE,
                            'DD/MM/YYYY'
                        ) AS STARTDATE,
                        TO_CHAR (TB1.END_DATE, 'DD/MM/YYYY') AS ENDDATE,
                        SM.MATNR,SM.PICTURE,SM.MAKTX,SM.MEINS,SM.ID_CAT, CAT.\"DESC\",TB1.*
                        FROM (SELECT ASS.MATNO, ASS.START_DATE,CURRENCY, ASS.END_DATE, ASS.KODE_PENAWARAN FROM EC_PL_ASSIGN
         ASS
                        GROUP BY ASS.MATNO, ASS.START_DATE, ASS.END_DATE, ASS.KODE_PENAWARAN,CURRENCY) TB1
                        INNER JOIN EC_M_STRATEGIC_MATERIAL SM ON TB1.MATNO=SM.MATNR
                        INNER JOIN EC_M_CATEGORY CAT ON SM.ID_CAT=CAT.ID_CAT
                        INNER JOIN (SELECT T1.*,PL.\"DESC\" NAMA_PLANT FROM EC_T_DETAIL_PENAWARAN T1
                            INNER JOIN
                            (SELECT  T1.PRICE HARGA,T1.* FROM EC_T_DETAIL_PENAWARAN
         T1 
                            INNER JOIN (SELECT MATNO,PLANT,VENDORNO,\"MAX\" (INDATE) INDATE FROM EC_T_DETAIL_PENAWARAN
        
                                                    GROUP BY MATNO,PLANT,VENDORNO ORDER BY PLANT,MATNO,VENDORNO
        ) T2 
                                                    ON T1.MATNO = T2.MATNO AND T1.VENDORNO = T2.VENDORNO AND
         T1.PLANT = T2.PLANT AND T1.INDATE = T2.INDATE 
                             WHERE T1.PRICE>0
                             ) T2 ON T1.MATNO = T2.MATNO AND T1.VENDORNO = T2.VENDORNO AND T1.PLANT = T2.PLANT
         AND T1.INDATE = T2.INDATE AND T1.PRICE=T2.HARGA
                            INNER JOIN EC_M_PLANT PL ON PL.PLANT=T1.PLANT 
                            WHERE T1.PLANT IN (SELECT RL.PLANT FROM EC_M_ROLE_PLANT RL WHERE RL.COMPANY='" . $comp . "')) DT
                        ON SM.MATNR = DT.MATNO  
                        INNER JOIN (SELECT TB2.* FROM
                            (
                                SELECT
                                    PEN.VENDORNO,
                                    PEN.MATNO,
                                    MAX (PEN.INDATE) AS DATE1
                                FROM
                                    EC_PL_PENAWARAN PEN 
                                GROUP BY
                                    PEN.VENDORNO,
                                    PEN.MATNO
                            ) TB1
                        INNER JOIN EC_PL_PENAWARAN TB2 ON TB1.VENDORNO = TB2.VENDORNO
                        AND TB1.MATNO = TB2.MATNO
                        AND TB1.DATE1 = TB2.INDATE ) TB3 ON TB3.VENDORNO=DT.VENDORNO AND TB3.MATNO=DT.MATNO
        
                        WHERE SM.PUBLISHED_LANGSUNG = '1'  
        ORDER BY ROWNUM ASC, SM.MATNR ASC)TW
        INNER JOIN VND_HEADER VEN ON TW.VENDORNO=VEN.VENDOR_NO
        WHERE TW.MATNR = '" . $matno . "' AND TW.PLANT='" . $plant . "'
        ORDER BY TW.HARGA ASC";

        $result = $this->db->query($SQL);
//        $this->db->get();
        echo $this->db->last_query();
    }

    function detail_prod_langsung($matno, $plant, $penawaran)
    {
        if ($plant >= 7000 && $plant < 8000) {
            $plantBaru = '7000';
        } else if ($plant >= 6000 && $plant < 7000) {
            $plantBaru = '6000';
        } else if ($plant >= 5000 && $plant < 6000) {
            $plantBaru = '5000';
        } else if ($plant >= 4000 && $plant < 5000) {
            $plantBaru = '4000';
        } else if ($plant >= 3000 && $plant < 4000) {
            $plantBaru = '3000';
        } else if ($plant >= 2000 && $plant < 3000) {
            $plantBaru = '2000';
        }
        $this->load->model('EC_strategic_material_m');
        $result = $this->EC_strategic_material_m->getDetail($matno);
        $result2 = $this->EC_strategic_material_m->getLongteks($result[0]['MATNR']);
        $data['longteks'] = $result2[0]['LNGTX'];
        $this->load->model('ec_ecatalog_m');
        $feedback = $this->ec_ecatalog_m->getfeedback('PL2018', $matno);
        $data['title'] = "Detail Product | E-Catalog";
        $data['data_produk'] = $result;
        $data['matno'] = $matno;
        $data['penawaran'] = $penawaran;
        $data['feedback'] = $feedback;
        $data['plantHide'] = $plant;
        $this->load->model('ec_company_plant');
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_js('pages/star-rating.min.js');
        $this->layout->add_css('pages/star-rating.min.css');
        $this->layout->add_js('plugins/select2/select2.js');
        $this->layout->add_css('plugins/select2/select2.css');
        $this->layout->add_css('plugins/select2/select2-bootstrap.css');
        $this->layout->add_css('plugins/bootstrap-select/bootstrap-select.css');
        $this->layout->add_js('plugins/bootstrap-select/bootstrap-select.js');
        $this->layout->add_css('pages/EC_checkout.css');
        $this->layout->add_js('pages/EC_list_langsung.js');
        $this->layout->add_css('pages/EC_menu_nav.css');
        $this->layout->add_js('pages/EC_nav_tree.js');
        //bentrok javascript
        $this->layout->add_js('pages/EC_pembelian_langsung.js');
        $this->layout->add_css('pages/EC_nav_tree.css');
//        $CC = $this->COSTCENTER_GETLIST();        
        $user_costcenter = $this->ec_ecatalog_m->getCC($this->session->userdata['ID']);
        $CC = $this->COSTCENTER_GETLIST($plantBaru);
        foreach ($CC as $c => $d) {
            if ($d['COSTCENTER'] == $user_costcenter['COSTCENTER']) {
                $data['CCS'] = $user_costcenter['COSTCENTER'];
            }
        }
        $data['CC'] = $CC;

//        var_dump($data['CCS']);die();
        $CCC = $this->ec_ecatalog_m->getCC($this->session->userdata['ID']);
        $data['ccc'] = $CCC;
//        var_dump($CCC);DIE();
        $data['company'] = $this->ec_company_plant->getCompany();
        $data['companyID'] = $this->ec_company_plant->getCompanySpek($this->session->userdata('EM_COMPANY'));
//                var_dump($data['companyID']);die();
        $this->load->library('sap_handler');
        // $dt = ($this->sap_handler->GET_MATERIALGLACCOUNT($this->session->userdata, $matno, $dataHarga[0]['PLANTT'], false));
        $result = $this->sap_handler->GET_REPORTBUDGET($this->session->userdata, $CCC["COSTCENTER"], false);
//         var_dump($result);
        // $dataa = array();
        for ($i = 0; $i < sizeof($result); $i++) {
            $data["GJAHR"] = $result[$i]["GJAHR"];
            $data["FICTR"] = $result[$i]["FICTR"];
            $data["BESCHR"] = $result[$i]["BESCHR"];
            $data["FIPEX"] = $result[$i]["FIPEX"];
            $data["BEZEI"] = $result[$i]["BEZEI"];
            $data["FKBTR_CB"] = $result[$i]["FKBTR_CB"];
            $data["FKBTR_AB"] = $result[$i]["FKBTR_AB"];
            $data["WLJHR"] = $result[$i]["WLJHR"];
            $data["AVAILBUDGET"] = $result[$i]["AVAILBUDGET"];
            // $dataa[] = $data;
        }
        $data['deals'] = $this->ec_ecatalog_m->getDealsVendor($matno, $plant, $this->session->userdata['COMPANYID']);
//        var_dump($data['deals_raw']);die();
//        $data['deals']=$this->unique_multidim_array($data['deals_raw'], 'VENDORNO');
        $data['deals2'] = array();
//        var_dump(count($data['deals']));die();
//        var_dump($data['deals']);die();
        for ($j = 0; $j < count($data['deals']); $j++) {
            $stok_konfirmasi = $this->ec_ecatalog_m->get_stok_konfirmasi($this->session->userdata['ID'], $data['deals'][$j]['MATNO'], $data['deals'][$j]['VENDORNO']);
            $nego = $this->ec_ecatalog_m->getNegoData($matno, $plant, $data['deals'][$j]['VENDORNO']);
            if (count($nego) > 0){
                $chat = $this->ec_ecatalog_m->getUnreadChat($nego['ID'], 2);
                if ($chat > 0){
                    $data['deals'][$j]['NEGO'] = 1;
                    $data['deals'][$j]['UNREAD'] = $chat;
                } else {
                    $data['deals'][$j]['NEGO'] = 1;
                    $data['deals'][$j]['UNREAD'] = 0;
                }
            } else {
                $data['deals'][$j]['NEGO'] = 0;
                $data['deals'][$j]['UNREAD'] = 0;
            }
            if (!isset($stok_konfirmasi['STOK_KONFIRMASI'])) {
                $data['deals'][$j]['STOK_KONFIRMASI'] = $stok_konfirmasi[0]['STOK_KONFIRMASI'];
            } else {
                $data['deals'][$j]['STOK_KONFIRMASI'] = 0;
            }
        }
        $data['plant'] = $this->ec_ecatalog_m->get_m_plant($plant);
        $data['cart'] = count($this->ec_ecatalog_m->get_data_checkout_pl($this->session->userdata['ID']));
        $this->layout->render('detail_produk_langsung', $data);
        //echo json_encode($result);
    }

    function getDataPenawaran()
    {
        $this->load->model('ec_ecatalog_m');
        $plant = $this->input->post('plant');
        $matno = $this->input->post('matno');
        $result = $this->getProdukPenawaran($matno);
        $data = $this->ec_ecatalog_m->getDealsVendor($matno, $plant, $this->session->userdata['COMPANYID']);
        for ($j = 0; $j < count($data); $j++) {
            $stok_konfirmasi = $this->ec_ecatalog_m->get_stok_konfirmasi($this->session->userdata['ID'], $data[$j]['MATNO'], $data[$j]['VENDORNO']);
            $nego = $this->ec_ecatalog_m->getNegoData($matno, $plant, $data[$j]['VENDORNO']);
            if (count($nego) > 0){
                $chat = $this->ec_ecatalog_m->getUnreadChat($nego['ID'], 2);
                if ($chat > 0){
                    $data[$j]['NEGO'] = 1;
                    $data[$j]['UNREAD'] = $chat;
                } else {
                    $data[$j]['NEGO'] = 1;
                    $data[$j]['UNREAD'] = 0;
                }
            } else {
                $data[$j]['NEGO'] = 0;
                $data[$j]['UNREAD'] = 0;
            }
            if (!isset($stok_konfirmasi['STOK_KONFIRMASI'])) {
                $data[$j]['STOK_KONFIRMASI'] = $stok_konfirmasi[0]['STOK_KONFIRMASI'];
            } else {
                $data[$j]['STOK_KONFIRMASI'] = 0;
            }
        }
        echo json_encode(array('data' => $data, 'produk' => $result));
    }

    function getProdukPenawaran($matno)
    {
        $this->load->model('EC_strategic_material_m');
        $result = $this->EC_strategic_material_m->getDetail($matno);
        return $result;
    }

    function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                array_push($temp_array, $val);
            }
            $i++;
        }
        return $temp_array;
    }

    function detail_HargaProd_langsung($matno)
    {
        $this->load->model('ec_ecatalog_m');
        $result = $this->ec_ecatalog_m->getDetailHarga_pl($matno);
        header('Content-Type: application/json');
        var_dump($result);
    }

    public function ubahStat($PC_CODE)
    {
        $this->load->model('EC_principal_manufacturer_m');
        //  date("d.m.Y")  $this->session->userdata['PRGRP']
        $data = array("PC_CODE" => $PC_CODE, "VENDOR_ID" => $this->input->post('VENDOR_ID'), "ID_R1" => $this->input->post('ID_R1'),
            "BY" => $this->USER[0], "ON" => date("d-m-Y H:i:s"), "STATUS" => $this->input->post('checked'));
        $this->EC_principal_manufacturer_m->ubahStat($data);
    }

    public function get_data_checkout()
    {
        $this->load->model('ec_ecatalog_m');
        $dataa = $this->ec_ecatalog_m->get_data_checkout($this->session->userdata['ID']);
        $i = 1;
        $total = 0;
        $data_tabel = array();
        foreach ($dataa as $value) {
            $netprice = $value['netprice'] = !null ? $value['netprice'] : "0";
            if ($value['curr']) {
                $netprice = $netprice * 100;
            }
            $data[0] = $i++;
            $data[1] = $value['MATNR'] = !null ? $value['MATNR'] : "";
            $data[2] = $value['MAKTX'] = !null ? $value['MAKTX'] : "";
            $data[3] = $netprice;
            $data[4] = "";
            $data[5] = $value['contract_no'] = !null ? $value['contract_no'] : "";
            $data[6] = $value['t_qty'] = !null ? $value['t_qty'] : "";
            $data[7] = $value['vendorname'] = !null ? $value['vendorname'] : "";
            $data[8] = $value['PC_CODE'] == null ? "" : $value['PC_CODE'];
            $data[9] = $value['validstart'] = !null ? $value['validstart'] : "";
            $data[10] = $value['validend'] = !null ? $value['validend'] : "";
            $data[11] = $value['plant'] == null ? "0" : $value['plant'];
            $data[12] = $value['PICTURE'] == null ? "default_post_img.png" : $value['PICTURE'];
            $data[13] = $value['uom'] == null ? "" : $value['uom'];
            $data[14] = $value['vendorno'] == null ? "0" : $value['vendorno'];
            $data[15] = $value['ID_CHART'] == null ? "0" : $value['ID_CHART'];
            $data[16] = $value['STATUS_CHART'] == null ? "0" : $value['STATUS_CHART'];
            $data[17] = $value['QTY'] == null ? "0" : $value['QTY'];
            if ($data[16] == 0) {
                $total += ($data[3] * $data[17]);
            }
            $data_tabel[] = $data;
        }
        $json_data = array('data' => $data_tabel, 'total' => $total);
        echo json_encode($json_data);
    }

    //
    public function get_data_checkout_pl()
    {
        $this->load->model('ec_ecatalog_m');
        $dataa = $this->ec_ecatalog_m->get_data_checkout_pl($this->session->userdata['ID']);
//        $stok_konfirmasi = $this->ec_ecatalog_m->get_stok_konfirmasi($this->session->userdata['ID'],'503-200434','0000110003');
//        var_dump($stok_konfirmasi);die();
        $i = 1;
        $total = 0;
        $data_tabel = array();
        for ($j = 0; $j < count($dataa); $j++) {
            $deals = $this->ec_ecatalog_m->getStokPL($dataa[$j]['VENDORNO'], $dataa[$j]['MATNO'], $dataa[$j]['PLANT']);
            $data[0] = $i++;
            $data['MATNO'] = $dataa[$j]['MATNO'] = !null ? $dataa[$j]['MATNO'] : "-";
            $data['MAKTX'] = $dataa[$j]['MAKTX'] = !null ? $dataa[$j]['MAKTX'] : "-";
            $data['HARGA_PENAWARAN'] = $dataa[$j]['PRICE'] = !null ? $dataa[$j]['PRICE'] : "-";
            $dataa[$j]['STOK'] = $deals[0]['STOK'];
            $stok_konfirmasi = $this->ec_ecatalog_m->get_stok_konfirmasi($this->session->userdata['ID'], $dataa[$j]['MATNO'], $dataa[$j]['VENDORNO']);
            if ($stok_konfirmasi[0]['STOK_KONFIRMASI'] == null) {
                $stok_konfirmasi[0]['STOK_KONFIRMASI'] = 0;
            }
            $dataa[$j]['STOK_KONFIRMASI'] = $stok_konfirmasi[0]['STOK_KONFIRMASI'];
            //$data[4] = "";
            if ($dataa[$j]['KODE_PARENT'] == 0) {
                $dataa[$j]['NAMA_PARENT'] = $dataa[$j]['DESC'];
            } else {
                $parent = $this->ec_ecatalog_m->get_parent_category($dataa[$j]['KODE_PARENT']);
                $dataa[$j]['NAMA_PARENT'] = $parent['DESC'];
            }
            $data[4] = $dataa[$j]['CURR'] = !null ? $dataa[$j]['CURR'] : "-";
            $data[5] = $dataa[$j]['DELIVERY_TIME'] = !null ? $dataa[$j]['DELIVERY_TIME'] : "-";
            $data[6] = $dataa[$j]['MEINS'] = !null ? $dataa[$j]['MEINS'] : "-";
            //$data[8] = $value['PC_CODE'] == null ? "-" : $value['PC_CODE'];
            //$data[9] = $value['validstart'] = !null ? $value['validstart'] : "";
            //$data[10] = $value['validend'] = !null ? $value['validend'] : "";
            //$data[11] = $value['plant'] == null ? "0" : $value['plant'];
            $data[12] = $dataa[$j]['PICTURE'] == null ? "default_post_img.png" : $dataa[$j]['PICTURE'];
            //$data[13] = $value['uom'] == null ? "" : $value['uom'];
            $data[14] = $dataa[$j]['DESC'] == null ? "-" : $dataa[$j]['DESC'];
            $data[15] = $dataa[$j]['ID_CHART'] == null ? "0" : $dataa[$j]['ID_CHART'];
            $data[16] = $dataa[$j]['STATUS_CHART'] == null ? "0" : $dataa[$j]['STATUS_CHART'];
            $data[17] = $dataa[$j]['QTY'] == null ? "0" : $dataa[$j]['QTY'];
            if ($data[16] == 0) {
                $total += ($data['HARGA_PENAWARAN'] * $data[17]);
            }
            $data_tabel[] = $data;
        }
        //        $json_data = array('data' => $data_tabel, 'total' => $total);
        $json_data = array('data' => $dataa, 'total' => $total);
        header('Content-Type: application/json');
        // var_dump($dataa);
        echo json_encode($json_data);
    }

    public function updQtyCart($ID)
    {
        $this->load->model('ec_ecatalog_m');
        $this->ec_ecatalog_m->updQtyCart($ID, $this->input->post("qty"));
        echo json_encode('pls min');
    }

    public function minqtyCart($ID)
    {
        $this->load->model('ec_ecatalog_m');
        $this->ec_ecatalog_m->minqtyCart($ID);
        echo json_encode('min 1');
    }

    public function plsqtyCart($ID)
    {
        $this->load->model('ec_ecatalog_m');
        $this->ec_ecatalog_m->plsqtyCart($ID);
        echo json_encode('pls 1');
    }

    public function addCart($MATNO)
    {
        $this->load->model('ec_ecatalog_m');
        $cc = $this->ec_ecatalog_m->getCC($this->session->userdata['ID']);
        //$cc['COSTCENTER']
        $jml = $this->ec_ecatalog_m->addCart_pl($MATNO, $this->input->post("vendor"), $this->session->userdata['ID'], date("d-m-Y H:i:s"), $this->input->post("kode_penawaran"), null);
        echo json_encode($jml);
    }

    public function addCompare($MATNO)
    {
        $this->load->model('ec_ecatalog_m');
        $jml = $this->ec_ecatalog_m->addCompare($MATNO, $this->input->post("contract_no"), $this->session->userdata['ID']);
        echo json_encode($jml);
    }

    public function addCompare_pl($MATNO)
    {
        $this->load->model('ec_ecatalog_m');
        $jml = $this->ec_ecatalog_m->addCompare_pl($MATNO, $this->input->post("contract_no"), $this->session->userdata['ID'],
            $this->input->post("kode"));
        echo json_encode($jml);
    }

    public function geser($MATNO)
    {
        $this->load->model('ec_ecatalog_m');
        $jml = $this->ec_ecatalog_m->moveTo($MATNO, $this->input->post("contract_no"), $this->session->userdata['ID'],
            $this->input->post("kode"));
        //$jml = $this -> ec_ecatalog_m -> moveTo('623-201876', '1300000033', '10164', '-1');
        echo json_encode($jml);
        //header('Content-Type: application/json');
        //var_dump($jml);
    }

    public function geser_lgsg($MATNO)
    {
        $this->load->model('ec_ecatalog_m');
        $jml = $this->ec_ecatalog_m->moveTo_pl($MATNO, $this->input->post("contract_no"), $this->session->userdata['ID'],
            $this->input->post("kode"), $this->input->post("kode_detail"));
        //$jml = $this -> ec_ecatalog_m -> moveTo('623-200631', 'PL2017', '10164', '-1');
        echo json_encode($jml);
        //header('Content-Type: application/json');
        //var_dump($jml);
    }

    public function cancelCart($ID)
    {
        $this->load->model('ec_ecatalog_m');
        $this->ec_ecatalog_m->cancelCart($ID);
        echo json_encode('canceled');
    }

    public function deleteCart($ID)
    {
        $this->load->model('ec_ecatalog_m');
        $this->ec_ecatalog_m->deleteCart($ID);
        echo json_encode('deleted');
    }

    public function readdCart($ID)
    {
        $this->load->model('ec_ecatalog_m');
        $this->ec_ecatalog_m->readdCart($ID);
        echo json_encode('---');
    }

    public function rangeHarga($cat)
    {
        $this->load->model('ec_ecatalog_m');
        $data = $this->ec_ecatalog_m->rangeHarga($cat);
        echo json_encode($data);
    }

    public function rangeHargaLgsg($cat)
    {
        $this->load->model('ec_ecatalog_m');
        $data = $this->ec_ecatalog_m->rangeHargaLgsg($cat);
        echo json_encode($data);
    }

    public function baru()
    {
        $this->load->model('EC_principal_manufacturer_m');
        $this->load->library("file_operation");
        $this->load->helper('file');
        $this->load->helper(array('form', 'url'));
        $uploaded = $this->file_operation->uploadT(UPLOAD_PATH . 'principal_manufacturer', $_FILES);
        if ($uploaded != null) {
            $data = array("PC_CODE" => $this->input->post("PC_CODE"), "PC_NAME" => $this->input->post("PC_NAME"),
                "COUNTRY" => $this->input->post("COUNTRY"), "ADDRESS" => $this->input->post("ADDRESS"),
                "PHONE" => $this->input->post("PHONE"), "FAX" => $this->input->post("FAX"), "MAIL" => $this->input->post("MAIL"),
                "WEBSITE" => $this->input->post("WEBSITE"), "LOGO" => $uploaded['LOGO']['file_name'], "CREATEDBY" => $this->USER[0],
                "CREATEDON" => date("d-m-Y H:i:s"), "CHANGEDBY" => $this->USER[0], "CHANGEDON" => date("d-m-Y H:i:s"));
            $this->EC_principal_manufacturer_m->insert($data);
        } else if ($uploaded[0] == "gagal") {
            //redirect("Principal_manufacturer/");
        }
        redirect("EC_Principal_manufacturer/");

    }

    public function upload($PC_CODE)
    {
        $this->load->model('EC_principal_manufacturer_m');
        $this->load->library("file_operation");
        $this->load->helper('file');
        $this->load->helper(array('form', 'url'));
        $uploaded = $this->file_operation->uploadT(UPLOAD_PATH . 'principal_manufacturer', $_FILES);
        if ($uploaded != null) {
            $data = array("LOGO" => $uploaded['LOGO']['file_name'], "PC_CODE" => $PC_CODE, "BY" => $this->USER[0],
                "ON" => date("d-m-Y H:i:s"));
            $this->EC_principal_manufacturer_m->upload($data);
        } else if ($uploaded[0] == "gagal") {
            //redirect("Principal_manufacturer/");
        }
        redirect("EC_Principal_manufacturer/");

    }

    public function getPC_CODE()
    {
        $this->load->model('EC_principal_manufacturer_m');
        $nextPC_CODE = $this->EC_principal_manufacturer_m->getPC_CODE();
        $nextPC_CODE = "PC" . str_pad($nextPC_CODE, 8, "0", STR_PAD_LEFT);
        // echo $nextPC_CODE;
        return $nextPC_CODE;
    }

    public function getVendorNo($vendorno)
    {
        $this->load->model('ec_ecatalog_m');
        $vendor = $this->ec_ecatalog_m->getVendor($vendorno);
        echo json_encode($vendor);
    }

    public function getPrincipal($pccode)
    {
        $this->load->model('ec_ecatalog_m');
        $principal = $this->ec_ecatalog_m->getPrincipal($pccode);
        $partner = $this->ec_ecatalog_m->getPartner($pccode);
        //echo json_encode($principal);
        $json_data = array('principal' => $principal, 'partner' => $partner);
        echo json_encode($json_data);
    }

    function GET_REPORTBUDGET($CC = '7204142000')
    {
        //        header('Content-Type: application/json');
        // var_dump($CC);
        $this->load->library('sap_handler');
        $result = $this->sap_handler->GET_REPORTBUDGET($this->session->userdata, $CC, false);
        $dataa = array();
        for ($i = 0; $i < sizeof($result); $i++) {
            $data["GJAHR"] = $result[$i]["GJAHR"];
            $data["FICTR"] = $result[$i]["FICTR"];
            $data["BESCHR"] = $result[$i]["BESCHR"];
            $data["FIPEX"] = $result[$i]["FIPEX"];
            $data["BEZEI"] = $result[$i]["BEZEI"];
            $data["FKBTR_CB"] = $result[$i]["FKBTR_CB"];
            $data["FKBTR_AB"] = $result[$i]["FKBTR_AB"];
            $data["WLJHR"] = $result[$i]["WLJHR"];
            $data["AVAILBUDGET"] = $result[$i]["AVAILBUDGET"];
            $dataa[] = $data;
        }
        // var_dump($dataa);
        echo json_encode(array('data' => $dataa));
    }

    function GET_MATERIALGLACCOUNT($matno = '603-200850', $plant = '7702')
    {
        header('Content-Type: application/json');
        $this->load->library('sap_handler');
        $data = ($this->sap_handler->GET_MATERIALGLACCOUNT($this->session->userdata, $matno, $this->uri->segment(4), false));
        // var_dump($data);
        if ($data == "" || $data == null) {
            $data[0] = array('MATNR' => $matno, 'BWKEY' => $plant);
        }
        echo json_encode($data);
    }

    function getFuncLoc()
    {
        // header('Content-Type: application/json');
        $this->load->library('sap_handler');
        $data = $this->sap_handler->getFuncLoc($this->session->userdata['COMPANYID']);
        // $data = $this->sap_handler->getFuncLoc('4000');
        return $data;
        // var_dump($data);
        // if ($data == "" || $data == null){
        //     $data[0] = array('MATNR' => $matno, 'BWKEY' => $plant);
        // }
        // echo json_encode($data);
    }

    function getFuncLocation()
    {
        header('Content-Type: application/json');
        $this->load->library('sap_handler');
        $data = $this->sap_handler->getFuncLocation($this->input->post("keyword"));
        // $data = $this->sap_handler->getFuncLoc('4000');
        // return $data;
        // var_dump($data);
        // if ($data == "" || $data == null){
        //     $data[0] = array('MATNR' => $matno, 'BWKEY' => $plant);
        // }
        echo json_encode($data);
    }

    function COSTCENTER_GETLIST($plant)
    {
        // header('Content-Type: application/json');
        $this->load->library('sap_handler');
        $data = $this->sap_handler->COSTCENTER_GETLIST($plant, false);
        // echo json_encode($data);
        return $data;
    }

    function COSTCENTER_GETLIST1()
    {
        header('Content-Type: application/json');
        $this->load->library('sap_handler');
        $data = $this->sap_handler->COSTCENTER_GETLIST($this->session->userdata, false);
        echo json_encode($data);
        // return $data;
    }

    public function get_data_cart($debug = false)
    {
        if ($debug) {
            header('Content-Type: application/json');
            // var_dump($this -> session -> userdata);
        }
        $this->load->library('sap_handler');
        $budget = ($this->sap_handler->getCurrentBudget($this->session->userdata['ID'], false));
        // $cost_center_desc = $this->sap_handler->getCurrentBudget($this->session->userdata['ID']);
        $this->load->model('ec_ecatalog_m');
        $jml = count($this->ec_ecatalog_m->get_data_checkout_pl($this->session->userdata['ID']));
        $jml2 = $this->ec_ecatalog_m->getCompareCount($this->session->userdata['ID']);
        $dataa = $this->ec_ecatalog_m->get_data_checkout_pl($this->session->userdata['ID']);
        $page = $this->ec_ecatalog_m->getAllCount();
        $total = 0;
        foreach ($dataa as $value) {
            $data[3] = $value['netprice'] = !null ? $value['netprice'] : "";
            $data[16] = $value['STATUS_CHART'] == null ? "0" : $value['STATUS_CHART'];
            $data[17] = $value['QTY'] == null ? "0" : $value['QTY'];
            if ($data[16] == 0) {
                $total += ($data[3] * $data[17]);
            }
        }
        $detailActualCommit = array();
        $budgetCommit = $budget['detailCommit'];
        $budgetActual = $budget['detailActual'];
        for ($i = 0; $i < sizeof($budgetCommit); $i++) {
            $ketemu = FALSE;
            $index = 0;
            for ($j = 0; $j < sizeof($detailActualCommit); $j++) {
                if ($budgetCommit[$i]['glItem'] == $detailActualCommit[$j]['glItem']) {
                    $ketemu = TRUE;
                    $index = $j;
                    break;
                }
            }
            if ($ketemu) {
                $detailActualCommit[$index]['budgetCommit'] += $budgetCommit[$i]['budget'];
            } else {
                $detail['glItem'] = $budgetCommit[$i]['glItem'];
                $detail['glDesc'] = $budgetCommit[$i]['glDesc'];
                $detail['budgetCommit'] = $budgetCommit[$i]['budget'];
                $detail['budgetActual'] = '';
                $detailActualCommit[] = $detail;
            }
        }
        for ($i = 0; $i < sizeof($budgetActual); $i++) {
            $ketemu = FALSE;
            $index = 0;
            for ($j = 0; $j < sizeof($detailActualCommit); $j++) {
                if ($budgetActual[$i]['glItem'] == $detailActualCommit[$j]['glItem']) {
                    $ketemu = TRUE;
                    $index = $j;
                    break;
                }
            }
            if ($ketemu) {
                $detailActualCommit[$index]['budgetActual'] += $budgetActual[$i]['budget'];
            } else {
                $detail['glItem'] = $budgetActual[$i]['glItem'];
                $detail['glDesc'] = $budgetActual[$i]['glDesc'];
                $detail['budgetCommit'] = '';
                $detail['budgetActual'] = $budgetActual[$i]['budget'];
                $detailActualCommit[] = $detail;
            }
        }
        if ($debug) {
            var_dump($detailActualCommit);
            return '';
        }
        $json_data = array('page' => $page, 'jumlah' => $jml, 'detailActualCommit' => $detailActualCommit,
            'detailActual' => $budget['detailActual'], 'detailCommit' => $budget['detailCommit'], 'cost_center' => $budget['kostl'],
            'cost_center_desc' => $budget['kostl_desc'], 'budget' => $budget['total'], 'actual_budget' => $budget['actual'],
            'commit_budget' => $budget['commit'], 'current_budget' => $budget['current'], 'compare' => $jml2, 'total' => $total);
        echo json_encode($json_data);
    }

    public function get_data_cart_langsg($debug = false)
    {
        if ($debug) {
            header('Content-Type: application/json');
            // var_dump($this -> session -> userdata);
        }
        $this->load->library('sap_handler');
        $budget = ($this->sap_handler->getCurrentBudget($this->session->userdata['ID']));
        $cost_center_desc = $this->sap_handler->getCurrentBudget($this->session->userdata['ID']);
        $this->load->model('ec_ecatalog_m');
        $jml = $this->ec_ecatalog_m->getCartCount_pl($this->session->userdata['ID'], date("Ymd"), 'PL2017');
        $jml2 = $this->ec_ecatalog_m->getCompareCount_pl($this->session->userdata['ID'], 'PL2017');
        $dataa = $this->ec_ecatalog_m->get_data_checkout_pl($this->session->userdata['ID']);
        $page = $this->ec_ecatalog_m->getAllCount();
        //var_dump($dataa);
        $total = 0;
        foreach ($dataa as $value) {
            $data[3] = '0';
            // $value['netprice'] = !null ? $value['netprice'] : "";
            $data[16] = $value['STATUS_CHART'] == null ? "0" : $value['STATUS_CHART'];
            $data[17] = '0';
            $value['QTY'] == null ? "0" : $value['QTY'];
            if ($data[16] == 0) {
                $total += ($data[3] * $data[17]);
            }
        }
        $detailActualCommit = array();
        $budgetCommit = $budget['detailCommit'];
        $budgetActual = $budget['detailActual'];
        for ($i = 0; $i < sizeof($budgetCommit); $i++) {
            $ketemu = FALSE;
            $index = 0;
            for ($j = 0; $j < sizeof($detailActualCommit); $j++) {
                if ($budgetCommit[$i]['glItem'] == $detailActualCommit[$j]['glItem']) {
                    $ketemu = TRUE;
                    $index = $j;
                    break;
                }
            }
            if ($ketemu) {
                $detailActualCommit[$index]['budgetCommit'] += $budgetCommit[$i]['budget'];
            } else {
                $detail['glItem'] = $budgetCommit[$i]['glItem'];
                $detail['glDesc'] = $budgetCommit[$i]['glDesc'];
                $detail['budgetCommit'] = $budgetCommit[$i]['budget'];
                $detail['budgetActual'] = '';
                $detailActualCommit[] = $detail;
            }
        }
        for ($i = 0; $i < sizeof($budgetActual); $i++) {
            $ketemu = FALSE;
            $index = 0;
            for ($j = 0; $j < sizeof($detailActualCommit); $j++) {
                if ($budgetActual[$i]['glItem'] == $detailActualCommit[$j]['glItem']) {
                    $ketemu = TRUE;
                    $index = $j;
                    break;
                }
            }
            if ($ketemu) {
                $detailActualCommit[$index]['budgetActual'] += $budgetActual[$i]['budget'];
            } else {
                $detail['glItem'] = $budgetActual[$i]['glItem'];
                $detail['glDesc'] = $budgetActual[$i]['glDesc'];
                $detail['budgetCommit'] = '';
                $detail['budgetActual'] = $budgetActual[$i]['budget'];
                $detailActualCommit[] = $detail;
            }
        }
        if ($debug) {
            var_dump($detailActualCommit);
            return '';
        }
        $json_data = array('page' => $page, 'jumlah' => $jml, 'detailActualCommit' => $detailActualCommit,
            'detailActual' => $budget['detailActual'], 'detailCommit' => $budget['detailCommit'], 'cost_center' => $budget['kostl'],
            'cost_center_desc' => $budget['kostl_desc'], 'budget' => $budget['total'], 'actual_budget' => $budget['actual'],
            'commit_budget' => $budget['commit'], 'current_budget' => $budget['current'], 'compare' => $jml2, 'total' => $total);
        //header('Content-Type: application/json');
        //var_dump($json_data);
        echo json_encode($json_data);
    }

    public function get_data_lgsg()
    {
        if (false) {
            $search = $this->input->post('search');
            $kategori = $this->input->post('kategori');
            $harga_min = $this->input->post('harga_min');
            $harga_max = $this->input->post('harga_max');
            $limitMin = $this->input->post('limitMin');
            $limitMax = $this->input->post('limitMax');
        }

        $this->load->model('ec_ecatalog_m');
        $dataa = $this->ec_ecatalog_m->get($this->input->post('limitMin'), $this->input->post('limitMax'));
        $page = $this->ec_ecatalog_m->getAllCount();

        $json_data = array('page' => $page, 'data' => $this->getALL($dataa));
        echo json_encode($json_data);
    }

    public function get_data()
    {
        $this->load->model('ec_ecatalog_m');

        $dataa = $this->ec_ecatalog_m->get($this->input->post('limitMin'), $this->input->post('limitMax'), $this->session->userdata['COMPANYID']);
        // var_dump($dataa);
        $page = $this->ec_ecatalog_m->getPage($this->session->userdata['COMPANYID']);

        $json_data = array('page' => count($page), 'data' => $this->getALL($dataa));
        // var_dump($json_data);
        echo json_encode($json_data);
    }

    public function cekAuthorize()
    {
        $this->load->model('ec_ecatalog_m');
        $category = $this->ec_ecatalog_m->getUserCategory($this->session->userdata['ID'], $this->input->post('id_category'));
        if ($category > 0) {
            echo json_encode(array('sukses' => true));
        } else {
            echo json_encode(array('sukses' => false));
        }
    }

    public function get_data_pricelist()
    {
        $this->load->model('EC_pricelist_m');
        $dataa = $this->EC_pricelist_m->get($this->input->post('limitMin'), $this->input->post('limitMax'));
        // $dataPrice = $this -> EC_pricelist_m -> getPricelist($this->session->userdata['VENDOR_NO']);
        $json_data = array('page' => 10, 'data' => $this->getALL_pricelist($dataa));
        echo json_encode($json_data);
    }

    public function getTblDetail($PC_CODE)
    {
        $this->load->model('EC_principal_manufacturer_m');
        $dataa = $this->EC_principal_manufacturer_m->getTblDetail($PC_CODE);
        $i = 1;
        $data_tabel = array();
        foreach ($dataa as $value) {
            $data[0] = $i++;
            $data[1] = $value['PC_CODE'];
            $data[2] = $value['VENDOR_ID'] = !null ? $value['VENDOR_ID'] : "";
            $data[3] = $value['VENDOR_NO'] = !null ? $value['VENDOR_NO'] : "";
            $data[4] = $value['VENDOR_NAME'] = !null ? $value['VENDOR_NAME'] : "";
            $data[5] = $value['ADDRESS_COUNTRY'] = !null ? $value['ADDRESS_COUNTRY'] : "";
            $data[6] = $value['ADDRESS_PHONE_NO'] = !null ? $value['ADDRESS_PHONE_NO'] : "";
            $data[7] = $value['ADDRESS_WEBSITE'] = !null ? $value['ADDRESS_WEBSITE'] : "";
            $data[8] = $value['EMAIL_ADDRESS'] = !null ? $value['EMAIL_ADDRESS'] : "";
            $data[10] = $value['ID_R1'];
            $data_tabel[] = $data;
        }
        $json_data = /*$data_tabel;*/
            array('data' => $data_tabel);
        echo json_encode($json_data);
    }

    public function get_dataBPA($PC_CODE)
    {
        $this->load->model('EC_principal_manufacturer_m');
        $dataa = $this->EC_principal_manufacturer_m->get_dataBPA($PC_CODE);
        $i = 1;
        $data_tabel = array();
        foreach ($dataa as $value) {
            $data[0] = $i++;
            $data[1] = $value['PC_CODE'];
            $data[2] = $value['VENDOR_ID'] = !null ? $value['VENDOR_ID'] : "";
            $data[3] = $value['VENDOR_NO'] = !null ? $value['VENDOR_NO'] : "";
            $data[4] = $value['VENDOR_NAME'] = !null ? $value['VENDOR_NAME'] : "";
            $data[5] = $value['ADDRESS_COUNTRY'] = !null ? $value['ADDRESS_COUNTRY'] : "";
            $data[6] = $value['ADDRESS_PHONE_NO'] = !null ? $value['ADDRESS_PHONE_NO'] : "";
            $data[7] = $value['ADDRESS_WEBSITE'] = !null ? $value['ADDRESS_WEBSITE'] : "";
            $data[8] = $value['EMAIL_ADDRESS'] = !null ? $value['EMAIL_ADDRESS'] : "";
            $data[9] = $value['STATUS'];
            $data[10] = $value['ID_R1'];
            $data_tabel[] = $data;
        }
        $json_data = /*$data_tabel;*/
            array('data' => $data_tabel);
        echo json_encode($json_data);
    }

    public function getDetail($PC_CODE)
    {
        $this->load->model('EC_principal_manufacturer_m');
        $data['PC'] = $this->EC_principal_manufacturer_m->getDetail($PC_CODE);
        //substr($MATNR, 1));
        echo json_encode($data);
    }

    function getALL_pricelist($dataa = '', $dataPrice = '')
    {
        $i = 1;
        $data_tabel = array();
        foreach ($dataa as $value) {
            $data[0] = $i++;
            $data[1] = $value['MATNR'] != null ? $value['MATNR'] : "";
            $data[2] = $value['MAKTX'] != null ? $value['MAKTX'] : "";
            $data[3] = $value['PICTURE'] == null ? "default_post_img.png" : $value['PICTURE'];
            $data[4] = "";
            $data[5] = "";
            $data[6] = "";
            $data[7] = "";
            $data[8] = "";
            $data_tabel[] = $data;
        }
        return $data_tabel;
    }

    public function testFNC($value = '')
    {
        $this->load->model('ec_ecatalog_m');
        // header('Content-Type: application/json');
        $dataa = $this->ec_ecatalog_m->get_data_checkout_PO($this->session->userdata['ID']);
        header('Content-Type: application/json');
        var_dump($dataa);
    }

    public function testHistory()
    {
        $this->load->model('ec_ecatalog_m');
        // header('Content-Type: application/json');
        $dataHeader = $this->ec_ecatalog_m->get_history_PO_header($this->session->userdata['ID']);
        // var_dump($dataHeader);
        $dataMat = $this->ec_ecatalog_m->get_history_PO($this->session->userdata['ID']);
        // var_dump($dataa);
        $hasil = array();
        for ($i = 0; $i < sizeof($dataHeader); $i++) {
            $data['PO_NO'] = $dataHeader[$i]['PO_NO'];
            // $data['DATE_BUY'] = $dataHeader[$i]['DATE_BUY'];
            // $data['contract_no'] = $dataHeader[$i]['contract_no'];
            // $data['vendorname'] = $dataHeader[$i]['vendorname'];
            // $data['vendorno'] = $dataHeader[$i]['vendorno'];
            $material = array();
            $total = 0;
            for ($j = 0; $j < sizeof($dataMat); $j++) {
                if ($dataMat[$j]['PO_NO'] == $data['PO_NO']) {
                    $data['DATE_BUY'] = $dataMat[$j]['DATE_BUY'];
                    $data['contract_no'] = $dataMat[$j]['contract_no'];
                    $data['vendorname'] = $dataMat[$j]['vendorname'];
                    $data['vendorno'] = $dataMat[$j]['vendorno'];
                    if ($dataMat[$j]['curr'] == 'IDR') {
                        $material[] = $dataMat[$j];
                        $total += ($dataMat[$j]['QTY'] * ($dataMat[$j]['netprice'] * 100));
                    } else {
                        $material[] = $dataMat[$j];
                        $total += ($dataMat[$j]['QTY'] * $dataMat[$j]['netprice']);
                    }

                }
            }
            $data['TOTAL'] = $total;
            $data['MATERIAL'] = $material;
            $hasil[] = $data;
        }
        // var_dump($hasil);
        return $hasil;
    }

    public function testSAP($debug = false, $value = '')
    {
        if ($debug) {
            header('Content-Type: application/json');
            var_dump($this->session->userdata);
            return '';
        }
        $this->load->library('sap_handler');
        // return $this -> sap_handler -> getPRPricelist(array('ZBS'), true);
        // return $this -> sap_handler -> getCurrentBudget($this -> session -> userdata['ID'], TRUE);
        return $this->sap_handler->createPOLangsung(array('ZBS'), true);
    }

    public function feedback()
    {
        //print_r($id_parent);
        $this->load->model('ec_ecatalog_m');
        $data = array("ID_USER" => $this->session->userdata['ID'], "MATNO" => $this->input->post("matno"),
            "CONTRACT_NO" => $this->input->post("contract_no"), "DATETIME" => date("Y-m-d H:i:s"), "ULASAN" => $this->input->post("ulasan"),
            "RATING" => $this->input->post("rating-input"), "USERNAME" => $this->session->userdata['USERNAME']);
        $this->ec_ecatalog_m->insertFeedback($data);
        // $json_data = array('data' => 'sukses kah');
        // echo json_encode($json_data);
        redirect('EC_Ecatalog_Marketplace/detail_prod/' . $this->input->post("contract_no") . '/' . $this->input->post("matno"));
    }

    public function feedback_pl()
    {
        //print_r($id_parent);
        $this->load->model('ec_ecatalog_m');
        $data = array("ID_USER" => $this->session->userdata['ID'], "MATNO" => $this->input->post("matno"), "CONTRACT_NO" => 'PL2017',
            "DATETIME" => date("Y-m-d H:i:s"), "ULASAN" => $this->input->post("ulasan"), "RATING" => $this->input->post("rating-input"),
            "USERNAME" => $this->session->userdata['USERNAME']);
        $this->ec_ecatalog_m->insertFeedback($data);
        // $json_data = array('data' => 'sukses kah');
        // echo json_encode($json_data);
        redirect('EC_Ecatalog_Marketplace/detail_prod_langsung/' . $this->input->post("matno"));
    }

    public function get_data_pembelian_lgsg()
    {

        $search = $this->input->post('search');
        $kategori = $this->input->post('kategori');
        $harga_min = $this->input->post('harga_min');
        $harga_max = $this->input->post('harga_max');
        $limitMin = $this->input->post('limitMin');
        $limitMax = $this->input->post('limitMax');

        $temp = $harga_min;
        if ($harga_max < $harga_min) {
            $harga_min = $harga_max;
            $harga_max = $temp;
        }

        $this->load->model('ec_ecatalog_m');
        // var_dump($search);
        $dataa = $this->ec_ecatalog_m->get_data_pembelian_lgsg($search, $kategori, $harga_min, $harga_max, $limitMin, $limitMax, $this->session->userdata['COMPANYID']);
        // header('Content-Type: application/json');
        // var_dump($dataa);
        $page = 0;
        if ($kategori == '-' || $search == '-') {
            $dataall = $this->ec_ecatalog_m->get_count_pembelian_lgsg($search, $kategori, $harga_min, $harga_max, $limitMin, $limitMax, $this->session->userdata['COMPANYID']);
            $page = count($dataall);
        } else {
            $page = count($dataa);
        }
        //$page = $this -> ec_ecatalog_m -> getAllCount();
//        if (isset($dataa)){
//            $json_data = array('page' => $page, 'data' => $this->compileDataPage_PL($dataa, $limitMin, $limitMax));
//        } else {
        $json_data = array('page' => count($this->testPaging($this->compileDataPage_PL($dataa), $limitMin, $limitMax)), 'data' => $this->testPaging($this->compileDataPage_PL($dataa), $limitMin, $limitMax), 'data1' => $this->compileDataPage_PL($dataa), 'totalItem' => count($this->compileDataPage_PL($dataa)));
//        }

        //$this->getALL_lgsg($dataa));
        echo json_encode($json_data);
    }

    function getALL_lgsg($dataa = '')
    {
        $i = 1;
        $data_tabel = array();
        foreach ($dataa as $value) {
            if ($value['HARGA_PENAWARAN'] != null) {
                $data[0] = $i++;
                $data[1] = $value['MATNR'] = !null ? $value['MATNR'] : "";
                $data[2] = $value['MAKTX'] = !null ? $value['MAKTX'] : "";
                $data[3] = $value['HARGA_PENAWARAN'] = !null ? $value['HARGA_PENAWARAN'] : "-";
                //$data[4] = "";
                $data[4] = $value['KODE_PENAWARAN'] = !null ? $value['KODE_PENAWARAN'] : "-";
                //$data[6] = $value['t_qty'] = !null ? $value['t_qty'] : "";
                //$data[7] = $value['vendorname'] = !null ? $value['vendorname'] : "";
                //$data[8] = $value['PC_CODE'] == null ? "-" : $value['PC_CODE'];
                $data[9] = $value['STARTDATE'] = !null ? $value['STARTDATE'] : "";
                $data[10] = $value['ENDDATE'] = !null ? $value['ENDDATE'] : "";
                //$data[11] = $value['plant'] == null ? "0" : $value['plant'];
                $data[12] = $value['PICTURE'] == null ? "default_post_img.png" : $value['PICTURE'];
                $data[13] = $value['MEINS'] = !null ? $value['MEINS'] : "";
                //$data[14] = $value['vendorno'] == null ? "0" : $value['vendorno'];
                $data[15] = $value['CURR_PL'] == null ? "-" : $value['CURR_PL'];
                $data[16] = $value['DESC'] == null ? "-" : $value['DESC'];
                $data[17] = $value['DELIVERY_TIME'] == null ? "-" : $value['DELIVERY_TIME'];
                //$data[18] = $value['ENDDATE'] == null ? "" : $value['ENDDATE'];
                $data_tabel[] = $data;
            }

        }
        return $data_tabel;
    }

    public function history_pl($cheat = false)
    {
        $data['title'] = "History PO Pembelian Langsung";
        $data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();
        $this->layout->add_js('pages/EC_history_pl.js');

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');

        $this->layout->render('history_pl', $data);
    }

    public function compileDataPage_PL($data = array())
    {
        $matno = '';
        $plant = '';
        $item = array();
        for ($i = 0; $i < count($data); $i++) {
            if ($matno == $data[$i]['MATNO']) {
                if ($plant !== $data[$i]['PLANT']) {
                    array_push($item, $data[$i]);
                }
            } else {
                array_push($item, $data[$i]);
            }
            $plant = $data[$i]['PLANT'];
            $matno = $data[$i]['MATNO'];
        }
        return $item;
    }

    public function testPaging($data = array(), $min, $max)
    {
        $item = array();
        if ($max > count($data)) {
            $max = count($data);
        }
        for ($i = $min; $i < $max; $i++) {
            array_push($item, $data[$i]);
        }
        return $item;
    }

    public function getHistory_pl($cheat = false)
    {
        header('Content-Type: application/json');
        $this->load->model('ec_ecatalog_m');
        echo json_encode(array('data' => $this->ec_ecatalog_m->history_pl($this->session->userdata['ID'])));;
    }

    public function tracking_po_pl($pono = '4500000462')
    {
        header('Content-Type: application/json');
        $this->load->model('ec_ecatalog_m');
        echo json_encode($this->ec_ecatalog_m->tracking_po_pl($pono));
    }

    public function tesUplaod()
    {
        $this->load->library("file_operation");
        $this->load->helper('file');
        $this->load->helper(array('form', 'url'));
        // header('Content-Type: application/json');
        // var_dump($_FILES);
        // if ($_FILES['picture']['size'] > 200000 && $_FILES['drawing']['size'] > 200000) {
        // }
        // var_dump(UPLOAD_PATH);
        // var_dump($_FILES);
        $uploaded = $this->file_operation->uploadTPL(UPLOAD_PATH . 'EC_korin', $_FILES);
        // var_dump($uploaded['korin']['file_name']);
        echo json_encode($uploaded['korin']);
    }

    public function openChat()
    {
        header('Content-Type: application/json');
        $this->load->model('ec_pl_negosiasi_m');
        $plant = $this->input->post('plant');
        $matno = $this->input->post('matno');
        $vendorno = $this->input->post('vendorno');
        $data = $this->ec_pl_negosiasi_m->requestChat($vendorno, $matno, $plant);
        echo json_encode(array('data' => $data));

    }

    public function sendChat()
    {
        header('Content-Type: application/json');
        $this->load->model('ec_pl_negosiasi_m');
        $plant = $this->input->post('plant');
        $matno = $this->input->post('matno');
        $vendorno = $this->input->post('vendorno');
        $msg = $this->input->post('message');
        $this->ec_pl_negosiasi_m->sendChat(1, $msg, $this->ec_pl_negosiasi_m->findNego($vendorno, $matno, $plant));
        echo json_encode('true');
    }

    public function closeNego()
    {
        header('Content-Type: application/json');
        $this->load->model('ec_pl_negosiasi_m');
        $plant = $this->input->post('plant');
        $matno = $this->input->post('matno');
        $vendorno = $this->input->post('vendorno');
        $this->ec_pl_negosiasi_m->closeNego($this->ec_pl_negosiasi_m->findNego($vendorno, $matno, $plant));
        echo json_encode('true');
    }
}
//
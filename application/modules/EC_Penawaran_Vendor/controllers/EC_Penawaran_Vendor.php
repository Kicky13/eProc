<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Penawaran_Vendor extends CI_Controller 
{

    private $USER;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        //$this -> USER = explode("@", $this -> session -> userdata['USERNAME']);
    }

    public function index($kode = '-')
    {
        $data['title'] = "Penawaran Produk";

        $this->load->model('ec_penawaran_vnd_test');
        $data['plant'] = $this->ec_penawaran_vnd_test->getPlant();

        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('jquery.form.min.js');
        $this->layout->add_css('pages/EC_menu_nav.css');
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_penawaran_ven_test.js');
        $this->layout->add_css('pages/EC_style_ecatalog.css');
        $this->layout->render('list', $data);
    }

    public function indexTest($kode = '-')
    {
        $data['title'] = "Penawaran Produk";

        $this->load->model('ec_penawaran_vnd_test');
        $data['plant'] = $this->ec_penawaran_vnd_test->getPlant();

        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('jquery.form.min.js');
        $this->layout->add_css('pages/EC_menu_nav.css');
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_penawaran_ven_test.js');
        $this->layout->add_css('pages/EC_style_ecatalog.css');
        $this->layout->render('list', $data);
    }

    public function get_data()
    {
//        var_dump($this->input->post('limitMax'));die();
        $this->load->model('ec_penawaran_vnd_test');        
        $dataCurr = $this->ec_penawaran_vnd_test->get_MasterCurrency();
        $dataProduk = $this->ec_penawaran_vnd_test->get_data_produk($this->session->userdata['VENDOR_NO'], $this->input->post('limitMin'), $this->input->post('limitMax'));
        $dataCount = $this->ec_penawaran_vnd_test->get_Count_produk($this->session->userdata['VENDOR_NO']);        
//        var_dump($dataProduk);die(); 
        $json_data = array('curr' => $dataCurr, 'data' => $this->getALL($dataProduk), 'page' => count($dataCount));
        echo json_encode($json_data); 
    }

    public function getPlant()
    {
        $this->load->model('ec_penawaran_vnd_test');
        $dataPlant = $this->ec_penawaran_vnd_test->getPlant();

        echo json_encode($dataPlant);
    }

    //08-02-2017
    function getALL($dataProduk)
    {
        $i = 1;
        $data_tabel = array();
		$venno = $this->session->userdata['VENDOR_NO'];
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
            $data['STOK_COMMIT'] = $value['STOK_COMMIT'] != null ? $value['STOK_COMMIT'] : "";
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

    // $d1 = new DateTime('2008-08-03 14:52:10');
    // $d2 = new DateTime('2008-01-03 11:11:10');
    // var_dump($d1 == $d2);
    // var_dump($d1 > $d2);
    // var_dump($d1 < $d2);
    public function insertHarga($matno)
    {
        $venno = $this->session->userdata['VENDOR_NO'];
        $this->load->model('ec_penawaran_vnd_test');
        $tglAssign = $this->ec_penawaran_vnd_test->getData($venno, $matno);

        $dateserver = date("Y-m-d H:i:s");
        $dateAssign = $tglAssign['ENDDATE'];

        $d1 = new DateTime($dateserver);
        $d2 = new DateTime($dateAssign);

        // var_dump($d1 == $d2);
        // var_dump($d1 > $d2);
        // var_dump($d1 < $d2);

//		if ($d1 <= $d2) {
        $harga = $this->input->post('harga');
        $curr = $this->input->post('curr');
        $matno = $this->input->post('matno');
        $deliverytime = $this->input->post('deliverytime');
        $stok = $this->input->post('stok');
        $in_date = date("Y-m-d H:i:s");
        $this->load->model('ec_penawaran_vnd_test');
        $this->ec_penawaran_vnd_test->insertData($venno, $matno, $harga, $curr, $deliverytime, $stok, $in_date);
//			echo "ya";
//		}
//		echo "tdk";
        //echo json_encode($tglAssign);
    }

    public function insertStok($matno)
    {
        $venno = $this->session->userdata['VENDOR_NO'];
        $this->load->model('ec_penawaran_vnd_test');
        $tglAssign = $this->ec_penawaran_vnd_test->getData($venno, $matno);

        $dateserver = date("Y-m-d H:i:s");
        $dateAssign = $tglAssign['ENDDATE'];

        $d1 = new DateTime($dateserver);
        $d2 = new DateTime($dateAssign);

        // var_dump($d1 == $d2);
        // var_dump($d1 > $d2);
        // var_dump($d1 < $d2);

//		if ($d1 <= $d2) {
        $harga = $this->input->post('harga');
        $curr = $this->input->post('curr');
        $matno = $this->input->post('matno');
        $deliverytime = $this->input->post('deliverytime');
        $stok = $this->input->post('stok');
        $stokc = $this->input->post('stokc');
//        $deskripsi = $this->input->post('deskripsi');
        $in_date = date("Y-m-d H:i:s");
        $this->load->model('ec_penawaran_vnd_test');
//        $this->ec_penawaran_vnd_test->insertStok($venno, $matno, $harga, $curr, $deliverytime, $stok, $in_date, $stokc, $deskripsi);
        $this->ec_penawaran_vnd_test->insertStok($venno, $matno, $harga, $curr, $deliverytime, $stok, $in_date, $stokc);
//			echo "ya";
//		}
//		echo "tdk";
        //echo json_encode($tglAssign);
    }

    public function getDescItem($MATNR)
    {
        header('Content-Type: application/json');
        $this->load->model('EC_strategic_material_m');
        $data['MATNR'] = $this->EC_strategic_material_m->getDetail($MATNR);
        //substr($MATNR, 1));
        echo json_encode($data);
    }

    public function getDetail($MATNR)
    {
        $venno = $this->session->userdata['VENDOR_NO'];
        header('Content-Type: application/json');
        $this->load->model('ec_penawaran_vnd_test');
        $data = $this->ec_penawaran_vnd_test->getDetail($MATNR, $venno);
        echo json_encode(array('data' => $data));
    }

    public function getDetail_old($MATNR)
    {
        $venno = $this->session->userdata['VENDOR_NO'];
        header('Content-Type: application/json');
        $this->load->model('ec_penawaran_vnd_test');
        $data = $this->ec_penawaran_vnd_test->getDetail($MATNR, $venno);
        echo json_encode($data);
    }

    public function saveDetail()
    {
        $venno = $this->session->userdata['VENDOR_NO'];
        $matno = $this->input->post('matno');
        header('Content-Type: application/json');
        $this->load->model('ec_penawaran_vnd_test');
//        var_dump($this->input->post());
        foreach ($this->input->post() as $plant => $val) {
//            var_dump($plant . " harga:" . $val[0] . " deliv:" . $val[1]);
//            var_dump($matno);
            if (is_array($val) && $val[0] != "" && $val[1] != "")
                $data = $this->ec_penawaran_vnd_test->saveDetail($matno, $plant, $val[0], $val[1], $venno);
        }
        redirect("EC_Penawaran_Vendor");
    }

    public function SaveHarga($matno)
    {
        $venno = $this->session->userdata['VENDOR_NO'];
        $plant = $this->input->post('plant');
        $harga = $this->input->post('harga');
        $deliverytime = $this->input->post('deliverytime');
        $curr = $this->input->post('curr');
        header('Content-Type: application/json');
        $this->load->model('ec_penawaran_vnd_test');
        $data = $this->ec_penawaran_vnd_test->saveDetail($matno, $plant, $harga, $deliverytime, $venno, $curr);
//        var_dump($this->input->post());
//         foreach ($this->input->post() as $plant => $val) {
// //            var_dump($plant . " harga:" . $val[0] . " deliv:" . $val[1]);
// //            var_dump($matno);
//             if (is_array($val) && $val[0] != "" && $val[1] != "")
//                 $data = $this->ec_penawaran_m->saveDetail($matno, $plant, $val[0], $val[1], $venno);
//         }
        //redirect("EC_Penawaran");
    }
	
	// ajax datatable
	// function getDest() {
		// $p = isset($_POST["start"]) && $_POST["start"] != "" && is_numeric($_POST["start"]) ? intval($_POST["start"]) : 0;
		// $e = isset($_POST["length"]) && $_POST["length"] != "" && is_numeric($_POST["length"]) ? intval($_POST["length"]) : 10;
		// $c = array("TBL.MATNO", "MAT.MAKTX", "PT.\"DESC\"", "TBL.CURRENCY", "TBL.PRICE", "TBL.DELIVERY_TIME", "TBL.LASTUPDATE");
		// $o = isset($_POST["order"]) ? array($c[intval($_POST["order"][0]["column"])], strtoupper($_POST["order"][0]["dir"])) : array($c[0], "ASC");
		
		// $e += $p;
		// $p++;
		
		// $this->load->model('ec_penawaran_vnd_test');
		// $data = $this->ec_penawaran_vnd_test->getDest($p, $e, $c, $o, $this->session->userdata['VENDOR_NO']);
		
		// $result["draw"] = isset($_POST["draw"]) ? intval($_POST["draw"]) : 1;
		// $result["recordsTotal"] = intval($data[0]);
		// $result["recordsFiltered"] = intval($data[1]);
		
		// $result["data"] = array();
		
		// foreach($data[2] as $r) {
			// $result["data"][] = array(
				// htmlspecialchars($r["MATNO"]),
				// htmlspecialchars($r["MAKTX"]),
				// htmlspecialchars($r["DESC"]),
				// htmlspecialchars($r["CURRENCY"] . " " . $this->session->userdata['VENDOR_NO']),
				// htmlspecialchars($r["PRICE"]),
				// htmlspecialchars($r["DELIVERY_TIME"]),
				// htmlspecialchars($r["LASTUPDATE"]),
				// htmlspecialchars($r["MATNO"])
			// );
		// }
		
		// echo json_encode($result);
	// }
	
	public function simpanHarga() {
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		$venno = $this->session->userdata['VENDOR_NO'];
		$this->load->model('ec_penawaran_vnd_test');
		
		$pesan = "";
		
		foreach($_POST["cb"] as $cb) {
			if($_POST["price"][$cb] != "" && $_POST["dlvtime"][$cb] != "") {
				$q = $this->ec_penawaran_vnd_test->saveDetail($_POST["matno"][$cb], $_POST["plant"][$cb], $_POST["price"][$cb], $_POST["dlvtime"][$cb], $venno, $_POST["currency"][$cb]);
				if($q) {
					$pesan .= "Berhasil menyimpan data untuk matno = \"".$_POST["nama_material"][$cb]."\" &amp; plant = \"".$_POST["desc"][$cb]."\"<br/>";
				} else {
					$pesan .= "Gagal menyimpan data untuk matno = \"".$_POST["nama_material"][$cb]."\" &amp; plant = \"".$_POST["desc"][$cb]."\"<br/>";
				}
			}
			// if($_POST["price"][$cb] != "" && $_POST["dlvtime"][$cb] != "") {
				// $pesan .= "{$_POST["matno"][$cb]}, {$_POST["plant"][$cb]}, {$_POST["price"][$cb]}, {$_POST["dlvtime"][$cb]}, {$venno}, {$_POST["currency"][$cb]}<br/><br/><br/><br/>";
			// }
		}
		
		echo $pesan;
	}
}

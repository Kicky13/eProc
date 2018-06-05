<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Publik extends CI_Controller {

	public function __construct() {
		parent::__construct();
		// $this->load->library('Layout');
	}

	public function terbilang($angka) {
        $angka = (float)$angka;
        $bilangan = array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan','Sepuluh','Sebelas');
        if ($angka < 12) {
            return $bilangan[$angka];
        } else if ($angka < 20) {
            return $bilangan[$angka - 10] . ' Belas';
        } else if ($angka < 100) {
            $hasil_bagi = (int)($angka / 10);
            $hasil_mod = $angka % 10;
            return trim(sprintf('%s Puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
        } else if ($angka < 200) {
            return sprintf('Seratus %s', $this->terbilang($angka - 100));
        } else if ($angka < 1000) {
            $hasil_bagi = (int)($angka / 100);
            $hasil_mod = $angka % 100;
            return trim(sprintf('%s Ratus %s', $bilangan[$hasil_bagi], $this->terbilang($hasil_mod)));
        } else if ($angka < 2000) {
            return trim(sprintf('Seribu %s', $this->terbilang($angka - 1000)));
        } else if ($angka < 1000000) {
            $hasil_bagi = (int)($angka / 1000); 
            $hasil_mod = $angka % 1000;
            return sprintf('%s Ribu %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod));
        } else if ($angka < 1000000000) {
            $hasil_bagi = (int)($angka / 1000000);
            $hasil_mod = $angka % 1000000;
            return trim(sprintf('%s Juta %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
        } else if ($angka < 1000000000000) {
            $hasil_bagi = (int)($angka / 1000000000);
            $hasil_mod = fmod($angka, 1000000000);
            return trim(sprintf('%s Milyar %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
        } else if ($angka < 1000000000000000) {
            $hasil_bagi = $angka / 1000000000000;
            $hasil_mod = fmod($angka, 1000000000000);
            return trim(sprintf('%s Triliun %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
        } else {
            return 'Data Salah';
        }
    }

    function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	public function releasePO($link){
		$this->load->model('po_header');
		$this->load->model('po_detail');
		$this->load->model('po_approval');
		$this->load->model('vnd_address');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_pr_item');


		$data['title'] = "Release PO";

		$this->po_header->where_link($link);
		$po = $this->po_header->get();
		$id = $po[0]['PO_ID'];
		$data['po'] = $po[0];

		$ptm = $this->prc_tender_main->ptm($po[0]['PTM_NUMBER']);
		$data['ptm'] = $ptm[0];
		$this->po_detail->where_po($id);
		$po_detail = $this->po_detail->get(false);
		$data['item'] = $po_detail;

		$data['PRNO'] = $data['item'][0]['PPR_PRNO'];
		$ptv = $this->prc_tender_vendor->ptv($data['po']['VND_CODE']);
		$data['ptv'] = $ptv[0];
		$data['RFQ_NO'] = $data['ptv']['PTV_RFQ_NO'];

		$data['PTM_PRATENDER'] = $data['ptm']['PTM_PRATENDER'];
		$vnd_id = $data['ptv']['VENDOR_ID'];

		$vnd_address = $this->vnd_address->get_all(array('VENDOR_ID'=>$vnd_id));

		foreach ($vnd_address as $key => $value) {
			if($value['TYPE'] == "Kantor Pusat"){
				$data['vnd'] = $value;
				break;
			}
		}

		$total = 0;
		foreach ($data['item'] as $key => $value) {
			$total  = $total + (intval($value['POD_PRICE'])*intval($value['POD_QTY']));
		}
		$data['total'] = $total;
		$data['terbilang'] = $this->terbilang($total);

		$rilis = $po[0]['RELEASE'] - 1;
		$this->po_approval->where_po($po[0]['PO_ID']);
		$this->po_approval->where_releaseby($rilis);
		$approval = $this->po_approval->get();
		$data['approval'] = $approval[0];

		$filename = $this->generateRandomString(20);

		$this->load->library('ci_qr_code');

		$params['data'] = base_url()."Tender_winner/releasePO/".$id;
		$params['level'] = 'H';
		$params['size'] = 4;
		$params['savename'] = FCPATH . 'static/images/captcha/'.$filename.".png";
		$a = $this->ci_qr_code->generate($params);
		$data['qrpath'] = base_url().'static/images/captcha/'.$filename.".png";

		$this->load->view('release_barang', $data);
	}
}
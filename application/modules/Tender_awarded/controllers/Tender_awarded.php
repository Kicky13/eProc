<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tender_awarded extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->library('encrypt');
		$this->load->model(array('prc_tender_vendor','prc_tender_item','po_header','po_detail'));
	}

	function index() {
		$data['title'] = "Tender Awarded List";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/tender_awarded.js?2');
		$this->layout->add_js('plugins/dataTables.rowsGroup.js');
		$this->layout->render('tender_awarded_list',$data);
	}

	function cetak_po($id) {
		$id=url_decode($id);
		// $this->load->helper(array('tcpdf'));
		$this->load->library('M_pdf');
		$this->load->library('encrypt');
		$this->load->model('po_header');
		$this->load->model('po_detail');
		$this->load->model('po_approval');
		$this->load->model('vnd_header');
		$this->load->model('vnd_bank');
		$this->load->model('vnd_address');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_pr_item');
		$this->load->model('adm_purch_grp');
		$this->load->model('adm_employee');
		$this->load->model('vendor_detail');

		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_it_service');

		$this->load->model('prc_tender_prep');
		$this->load->model('prc_purchase_requisition');

		$this->load->model('adm_wilayah');

		$data['title'] = "Release PO";

		$this->po_header->where_po($id);
		$po = $this->po_header->get();
		$data['po'] = $po[0];

		$ptm = $this->prc_tender_main->ptm($po[0]['PTM_NUMBER']);
		$data['ptm'] = $ptm[0];
		$this->po_detail->where_po($data['po']['PO_ID']);
		$po_detail = $this->po_detail->get(false);
		$data['item'] = $po_detail;
		$this->prc_pr_item->join_pr();
		$this->prc_pr_item->join_group_plant();
		$this->prc_pr_item->join_pr_service();
		$ppi = $this->prc_pr_item->get(array('PPI_ID'=>$po_detail[0]['PPI_ID']),"*",-1,false);
		$data['ppi']=$ppi[0];

		$data['PRNO'] = $data['item'][0]['PPR_PRNO'];
		$ptv = $this->prc_tender_vendor->ptv($data['po']['VND_CODE']);
		$data['ptv'] = $ptv[0];
		$data['RFQ_NO'] = $data['ptv']['PTV_RFQ_NO'];

		$data['PTM_PRATENDER'] = $data['ptm']['PTM_PRATENDER'];
		$vnd_id = $data['ptv']['VENDOR_ID'];

		$vnd_address = $this->vnd_address->get_all(array('VENDOR_ID'=>$vnd_id));
		$vnd_header = $this->vnd_header->get_all(array("VENDOR_ID"=>$vnd_id));
		$data['vendor'] = $vnd_header[0];
		$vnd_bank = $this->vnd_bank->get(array("VENDOR_ID"=>$data['vendor']['VENDOR_ID']));
		$data['bank'] =$vnd_bank[0];

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

		$params['data'] = base_url()."Publik/releasePO/".$data['po']['LINK'];
		$params['level'] = 'H';
		$params['size'] = 2;
		$params['savename'] = FCPATH . 'static/images/captcha/'.$filename.".png";
		$a = $this->ci_qr_code->generate($params);
		$data['qrpath'] = base_url().'static/images/captcha/'.$filename.".png";
		
		$data['is_print'] = true;
		$form_print = array(
			1 => 'si',
			2 => 'si',
			3 => 'pa',
			4 => 'to'
			);
		$barang_or_jasa = $data['ptm']['IS_JASA']==1?'jasa':'barang';
		$apg = $this->adm_purch_grp->get(array("PURCH_GRP_CODE"=>$data['po']['PGRP']));	
		$data['apg'] = $apg[0];
		$kel_purch_grp = $apg[0]['KEL_PURCH_GRP'];

		$ptqm = $this->prc_tender_quo_main->ptmptv($po[0]['PTM_NUMBER'], $data['po']['VND_CODE']);
		$ptqi = $this->prc_tender_quo_item->get_by_pqm($ptqm[0]['PQM_ID']);
		$data['ptqi'] = $ptqi;

		$npwp = $this->vendor_detail->npwp_ven($vnd_id);
		$data['city'] = $this->adm_wilayah->get_wilayah($npwp[0]['KOTA']);
		$data['prop'] = $this->adm_wilayah->get_wilayah($npwp[0]['PROPINSI']);
		$data['npwp'] = $npwp;

		$vnd_address = $this->vnd_address->get_all(array('VENDOR_ID'=>$vnd_id));
		$data['vnd_address'] = $vnd_address;

		$html = $this->load->view('po_'.$barang_or_jasa.'_'.$form_print[$kel_purch_grp], $data, true);      

		$this->m_pdf->pdf->WriteHTML($html);
		$this->m_pdf->pdf->setTitle($data['title']);

		$cekfile = 'po_'.$barang_or_jasa.'_'.$form_print[$kel_purch_grp];
		if($cekfile=="po_jasa_si" || $cekfile=="po_jasa_to" || $cekfile=="po_barang_to"){
			$footer = $this->load->view('po_footer_'.$barang_or_jasa.'_'.$form_print[$kel_purch_grp], $data, true);      
			$this->m_pdf->pdf->SetHTMLFooter($footer);
		}

		$this->m_pdf->pdf->Output($data['title'].".pdf",'I'); 
	}

	function get_tender_awarded_list()
	{

		$this->po_header->join_vnd();
		$po = $this->po_header->get(array('VND_CODE'=>$this->session->userdata('VENDOR_NO'),'RELEASE <>'=>0,'PO_NUMBER is not null'=>NULL));
		$count = 0;
		$data = array();
		foreach ((array) $po as $key => $value) {	
			$this->po_detail->where_po($value['PO_ID']);
			$pod = $this->po_detail->get();
			foreach ($pod as $key_pod => $value_pod) {
				$data[$count] = $po[$key];
				$this->prc_tender_vendor->join_vnd_header('INNER');		
				$ptv = $this->prc_tender_vendor->ptm_ptv($value['PTM_NUMBER'],$this->session->userdata('VENDOR_NO'));
				$data[$count]['ECT_PO_ID'] = url_encode($value['PO_ID']);
				$data[$count]['PTV_RFQ_NO'] = $ptv[0]['PTV_RFQ_NO'];
				$data[$count]['DDATE'] = betteroracledate(oraclestrtotime($value['DDATE']));
				$data[$count]['DOC_DATE'] = betteroracledate(oraclestrtotime($value['DOC_DATE']));
				$data[$count]['RELEASED_AT'] = betteroracledate(oraclestrtotime($value['RELEASED_AT']));
				$data[$count]['POD_NOMAT'] = $value_pod['POD_NOMAT'];
				$data[$count]['POD_DECMAT'] = $value_pod['POD_DECMAT'];
				$data[$count]['POD_QTY'] = $value_pod['POD_QTY'];
				$data[$count]['UOM'] = $value_pod['UOM'];
				$data[$count]['POD_PRICE'] = $value_pod['POD_PRICE'];
				$data[$count]['TOTAL_HARGA'] = $value['TOTAL_HARGA'];
				$data[$count]['CURR'] = $value_pod['CURR'];

				$DOC_PO = "";
				if(!empty($value_pod['DOC_PO'])){
					//$DOC_PO = $value_pod['DOC_PO'];
					$DOC_PO .= '<a href="'.base_url().'upload/temp/'.$value_pod['DOC_PO'].'"><span class="glyphicon glyphicon-file"></span>'.$value_pod['DOC_PO'].'</a><br>';
				}

				$this->load->model('prc_add_item_evaluasi');
				$ptv_doc_nego = $this->prc_add_item_evaluasi->get(array('PTM_NUMBER'=>$value['PTM_NUMBER'],'IS_SHARE'=>1));
				$doc_nego = '';
				if(!empty($ptv_doc_nego)){
					foreach ($ptv_doc_nego as $pdn) {
						$doc_nego .= '<a href="'.base_url().'upload/additional_file/'.$pdn['FILE'].'"><span class="glyphicon glyphicon-file"></span>'.($pdn['NAMA']==""?$pdn['FILE'] : $pdn['NAMA']).'</a><br>';
					}
				} 

				// if(!empty($value_pod['DOC_ANALISA_HARGA'])){
				// 	$DOC_ANALISA_HARGA = '<a href="'.base_url().'upload/temp/'.$value_pod['DOC_ANALISA_HARGA'].'"><span class="glyphicon glyphicon-file"></span>'.$value_pod['DOC_ANALISA_HARGA'].'</a><br>';
				// } else {
				// 	//$DOC_ANALISA_HARGA = 'Tidak Ada Dokumen';
				// }
				$gabung_doc = $DOC_PO.$doc_nego;
				if(empty($gabung_doc)){
					$gabung_doc = 'Tidak Ada Dokumen';
				}
				$data[$count]['DOC_ANALISA_HARGA'] = $gabung_doc;

				$count++;
			}
		}
		echo json_encode(array('data' => $data));
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
}
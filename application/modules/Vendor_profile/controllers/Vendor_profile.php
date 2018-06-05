<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_Profile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->load->library('Authorization');
		$this->load->library('Layout');
	}

	public function index() {
		$data['title'] = "Almost Expired Document";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_validate_css();
		$this->layout->set_validate_js();
		$this->layout->add_js('pages/Vendor_profile.js');
		$this->layout->render('vendor_profile_list', $data);
	}
	public function tes123(){
		echo json_encode($this->list_vendor_almost_expired());
	}
	function list_vendor_almost_expired(){ // function untuk menampilkan vendor mana saja yang memiliki data expired
		$this->load->model(array('vnd_header', 'vnd_board', 'vnd_product', 'vnd_cert'));
		$date_now = date('d-m-Y');
		$vendor_temp = array();
		$vendor_list = array();
		$list_panel = array();
		$vnd_headers = $this->vnd_header->fields('VENDOR_ID,SIUP_TO,ADDRESS_DOMISILI_EXP_DATE,TDP_TO,API_TO')->get_all();
		$vnd_boards = $this->vnd_board->fields('BOARD_ID,VENDOR_ID,KTP_EXPIRED_DATE')->get_all();
		$vnd_products = $this->vnd_product->fields('PRODUCT_ID,VENDOR_ID,EXPIRED_DATE')->get_all();
		$vnd_certs = $this->vnd_cert->fields('CERT_ID,VENDOR_ID,VALID_TO')->get_all();

		$list_panel = array('Akta Pendirian', 'Alamat Perusahaan', 'Info Perusahaan', 'Informasi Laporan Keuangan', 'Keterangan Tentang Fasilitas dan Peralatan', 'Kontak Perusahaan',
							'Modal Sesuai Dengan Akta Terakhir', 'NPWP', 'PKP', 'Pekerjaan', 'Perusahaan Afiliasi', 'Principal',
							'Rekening Bank', 'Subkontraktor', 'Tenaga Ahli Pendukung', 'Tenaga Ahli Utama');
		
		foreach ($vnd_headers as $key => $val) {
			$vnd_siup = day_difference(oraclestrtotime($val['SIUP_TO']),strtotime($date_now), false);
			$vnd_addrs = day_difference(oraclestrtotime($val['ADDRESS_DOMISILI_EXP_DATE']),strtotime($date_now), false);
			$vnd_tdp = day_difference(oraclestrtotime($val['TDP_TO']),strtotime($date_now), false);
			$vnd_api = day_difference(oraclestrtotime($val['API_TO']),strtotime($date_now), false);


		/* Model Lama
	 		if ((!empty($val['SIUP_TO']) && $vnd_siup == 90 || $vnd_siup == 60 || $vnd_siup == 30 || $vnd_siup < 1) || (!empty($val['ADDRESS_DOMISILI_EXP_DATE']) && $vnd_addrs == 90 || $vnd_addrs == 60 || $vnd_addrs == 30 || $vnd_addrs < 1)|| (!empty($val['TDP_TO']) && $vnd_tdp == 90 || $vnd_tdp == 60 || $vnd_tdp == 30 || $vnd_tdp < 1) || (!empty($val['API_TO']) && $vnd_api == 90 || $vnd_api == 60 || $vnd_api == 30 || $vnd_api < 1)) {
	 			
	 			//var_dump($val['VENDOR_ID'] .','. $vnd_siup);
				array_push($vendor_temp, $val['VENDOR_ID']);
	 		}
		*/ 

	 		if (!empty($val['SIUP_TO']) || !empty($val['ADDRESS_DOMISILI_EXP_DATE']) || !empty($val['TDP_TO']) || !empty($val['API_TO'])) {
	 			if (($vnd_siup == 90 || $vnd_siup == 60 || $vnd_siup == 30 || $vnd_siup < 0) || ($vnd_addrs == 90 || $vnd_addrs == 60 || $vnd_addrs == 30 || $vnd_addrs < 0) || ($vnd_tdp == 90 || $vnd_tdp == 60 || $vnd_tdp == 30 || $vnd_tdp < 0) || ($vnd_api == 90 || $vnd_api == 60 || $vnd_api == 30 || $vnd_api < 0)) {
				array_push($vendor_temp, $val['VENDOR_ID']);
	 			}
	 		}
		}


		if (!empty($vnd_boards)) {
			foreach ($vnd_boards as $key => $val) {
				if (!empty($val['KTP_EXPIRED_DATE'])) {
					$vnd_ktp = day_difference(oraclestrtotime($val['KTP_EXPIRED_DATE']),strtotime($date_now), false);

					if($vnd_ktp == 90 || $vnd_ktp == 60 || $vnd_ktp == 30 || $vnd_ktp < 0) {
						array_push($vendor_temp, $val['VENDOR_ID']);
					} 
				}
			}
		}

		if (!empty($vnd_products)) {
			foreach ($vnd_products as $key => $val) {
				if (!empty($val['EXPIRED_DATE'])) {
					$vnd_exprd = day_difference(oraclestrtotime($val['EXPIRED_DATE']),strtotime($date_now), false);

					if($vnd_exprd == 90 || $vnd_exprd == 60 || $vnd_exprd == 30 || $vnd_exprd < 0){
						array_push($vendor_temp, $val['VENDOR_ID']);
					} 
				}
			}
		}
		
		if (!empty($vnd_certs)) {
			foreach ($vnd_certs as $key => $val) {
				if (!empty($val['VALID_TO'])) { 
					$vnd_cert = day_difference(oraclestrtotime($val['VALID_TO']),strtotime($date_now), false);

					if($vnd_cert == 90 || $vnd_cert == 60 || $vnd_cert == 30 || $vnd_cert < 0){
						array_push($vendor_temp, $val['VENDOR_ID']);
					} 

				} 
				else {
					array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>'Keterangan Sertifikat'));
				}
			}
		}
		// 'Domisili Perusahaan','SIUP','TDP','Angka Pengenal Importir','Dewan Komisaris','Dewan direksi','Barang dan bahan yang bisa dipasok','Jasa yang bisa dipasok','Keterangan Sertifikat',

		// die(var_dump(count($vendor_temp)));

		$vendor_temp = array_unique($vendor_temp); 
		foreach ($vendor_temp as $key => $vnd_id) { 
		$vnd = $this->vnd_header->fields('VENDOR_ID,VENDOR_NO,VENDOR_NAME,VENDOR_TYPE')->where(array("VENDOR_ID"=>$vnd_id))->where("STATUS_PERUBAHAN",array(0,1))->get();

			if(!empty($vnd))
			array_push($vendor_list, $vnd);
		}
		// 'panel' => $panel_temp
 
		$data = array('data' => $vendor_list);
		return $data;
	}

	function list_panel_expired($vendors){ // function untuk menyimpan nilai detail data vendor yang expired
		$this->load->model(array('vnd_header', 'vnd_board', 'vnd_product', 'vnd_cert', 'vnd_update_progress'));
		$date_now = date('d-m-Y');
		$vendor_temp = array();
		$vendor_list = array();
		$list_panel = array();
		
		$panel_title = array(
			'Akta Pendirian', 
			'Alamat Perusahaan', 
			'Info Perusahaan', 
			'Informasi Laporan Keuangan',
			'Keterangan Tentang Fasilitas dan Peralatan',
			'Kontak Perusahaan',

			'Modal Sesuai Dengan Akta Terakhir',
			'NPWP',
			'PKP',
			 'Pekerjaan',
			 'Perusahaan Afiliasi',
			 'Principal',

			'Rekening Bank',
			 'Subkontraktor',
			 'Tenaga Ahli Pendukung',
			 'Tenaga Ahli Utama'
			 );

		foreach ($vendors as $key => $vendor) {
			$vnd_headers = $this->vnd_header->fields('VENDOR_ID,SIUP_TO,ADDRESS_DOMISILI_EXP_DATE,TDP_TO,API_TO')->get_all(array('VENDOR_ID'=>$vendor['VENDOR_ID']));
			foreach ($vnd_headers as $key => $val) {
				/* SIUP */ 
				if (!empty($val['SIUP_TO'])) {
					$vnd_siup = day_difference(oraclestrtotime($val['SIUP_TO']),strtotime($date_now), false);

					if($vnd_siup == 90 || $vnd_siup == 60 || $vnd_siup == 30 || $vnd_siup < 0){
						$jon = array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Rejected', 'REASON'=>'Dokumen Hampir Expired', 'CONTAINER'=>'SIUP', 'EXPIRED_DAYS'=>$vnd_siup));
					}
				} else{
					$jon = array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>'SIUP'));
				}

				// die(var_dump($jon));

				/* ADDRESS */ 
				if (!empty($val['ADDRESS_DOMISILI_EXP_DATE'])) {
					$vnd_addrs = day_difference(oraclestrtotime($val['ADDRESS_DOMISILI_EXP_DATE']),strtotime($date_now), false);

					if($vnd_addrs == 90 || $vnd_addrs == 60 || $vnd_addrs == 30 || $vnd_addrs < 0){
						array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Rejected', 'REASON'=>'Dokumen Hampir Expired', 'CONTAINER'=>'Domisili Perusahaan', 'EXPIRED_DAYS'=>$vnd_addrs));
					}
				} else {
					array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>'Domisili Perusahaan'));
				}

				/* TDP */ 
				if (!empty($val['TDP_TO'])) {
					$vnd_tdp = day_difference(oraclestrtotime($val['TDP_TO']),strtotime($date_now), false);

					if($vnd_tdp == 90 || $vnd_tdp == 60 || $vnd_tdp == 30 || $vnd_tdp < 0){
						array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Rejected', 'REASON'=>'Dokumen Hampir Expired', 'CONTAINER'=>'TDP', 'EXPIRED_DAYS'=>$vnd_tdp));
					}
				} else {
					array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>'TDP'));
				}

				/* API */ 
				if (!empty($val['TDP_TO'])) {
					$vnd_api = day_difference(oraclestrtotime($val['API_TO']),strtotime($date_now), false);

					if($vnd_api == 90 || $vnd_api == 60 || $vnd_api == 30 || $vnd_api < 0){
						array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Rejected', 'REASON'=>'Dokumen Hampir Expired', 'CONTAINER'=>'Angka Pengenal Importir', 'EXPIRED_DAYS'=>$vnd_api));
					}
				}else {
					array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>'Angka Pengenal Importir'));
				}
			}

			$vnd_boards = $this->vnd_board->fields('BOARD_ID,VENDOR_ID,KTP_EXPIRED_DATE,TYPE')->get_all(array('VENDOR_ID'=>$vendor['VENDOR_ID']));

			// $commissioner_expired = false; 
			// $director_expired = false;
			if (!empty($vnd_boards)) {
				foreach ($vnd_boards as $key => $val) {
					
					if (!empty($val['KTP_EXPIRED_DATE'])) {
						$vnd_ktp = day_difference(oraclestrtotime($val['KTP_EXPIRED_DATE']),strtotime($date_now), false);

						if($vnd_ktp == 90 || $vnd_ktp == 60 || $vnd_ktp == 30 || $vnd_ktp < 0 ) {
							if($val['TYPE']=='Commissioner'){
								// $commissioner_expired = true;
								array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Rejected', 'REASON'=>'Dokumen Hampir Expired', 'CONTAINER'=>'Dewan Komisaris', 'EXPIRED_DAYS'=>$vnd_ktp));
							} else if($val['TYPE']=='Director'){
								// $director_expired = true;
								array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Rejected', 'REASON'=>'Dokumen Hampir Expired', 'CONTAINER'=>'Dewan Direksi', 'EXPIRED_DAYS'=>$vnd_ktp));
							} 
						}
					} else {
						array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>'Dewan Direksi dan Komisaris'));
					}
				}
			}

			$vnd_products = $this->vnd_product->fields('PRODUCT_ID,VENDOR_ID,EXPIRED_DATE,PRODUCT_TYPE')->get_all(array('VENDOR_ID'=>$vendor['VENDOR_ID']));
			// $good_expired = false;
			// $service_expired = false;
			if (!empty($vnd_products)) {
				foreach ($vnd_products as $key => $val) {

					if (!empty($val['EXPIRED_DATE'])) {
						$vnd_exp = day_difference(oraclestrtotime($val['EXPIRED_DATE']),strtotime($date_now), false);
						if($vnd_exp == 90 || $vnd_exp == 60 || $vnd_exp == 30 || $vnd_exp < 0){
							if($val['PRODUCT_TYPE']=='GOODS'){
								array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Rejected', 'REASON'=>'Dokumen Hampir Expired', 'CONTAINER'=>'Barang dan bahan yang bisa dipasok', 'EXPIRED_DAYS'=>$vnd_exp));

							} else if($val['PRODUCT_TYPE']=='SERVICES'){
								array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Rejected', 'REASON'=>'Dokumen Hampir Expired', 'CONTAINER'=>'Jasa yang bisa dipasok', 'EXPIRED_DAYS'=>$vnd_exp));
							}
						}

					} else {
						array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>'Barang dan Jasa yang bisa dipasok'));
					}
				}
			}

/* cara lama 
			if (!empty($vnd_products)) {
				foreach ($vnd_products as $key => $val) {

					if (!empty($val['EXPIRED_DATE'])) {
						$vnd_exp = day_difference(oraclestrtotime($val['EXPIRED_DATE']),strtotime($date_now), false);
						if($vnd_exp == 90 || $vnd_exp == 60 || $vnd_exp == 30 || $vnd_exp < 0){
							if($val['PRODUCT_TYPE']=='GOODS'){
								$good_expired = true;
							} else if($val['PRODUCT_TYPE']=='SERVICES'){
								$service_expired = true;
								
							}
						}
					}
				}
			}

			if ($good_expired == true){
				array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Rejected', 'REASON'=>'Dokumen Hampir Expired', 'CONTAINER'=>'Barang dan bahan yang bisa dipasok', 'EXPIRED_DAYS'=>$vnd_exp));
			} else {
				array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>'Barang dan bahan yang bisa dipasok'));
			}
			if ($service_expired == true){
				array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Rejected', 'REASON'=>'Dokumen Hampir Expired', 'CONTAINER'=>'Jasa yang bisa dipasok', 'EXPIRED_DAYS'=>$vnd_exp));
			} else {
				array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>'Jasa yang bisa dipasok'));
			}
*/


			$vnd_certs = $this->vnd_cert->fields('CERT_ID,VENDOR_ID,VALID_TO')->get_all(array('VENDOR_ID'=>$vendor['VENDOR_ID']));
			// $cert_expired = false;
			if (!empty($vnd_certs)) {
				foreach ($vnd_certs as $key => $val) {
					if (!empty($val['VALID_TO'])) { 
						$vnd_vld = day_difference(oraclestrtotime($val['VALID_TO']),strtotime($date_now), false);
							if($vnd_vld == 90 || $vnd_vld == 60 || $vnd_vld == 30 || $vnd_vld < 0){
								// $cert_expired = true;
								array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Rejected', 'REASON'=>'Dokumen Hampir Expired', 'CONTAINER'=>'Keterangan Sertifikat', 'EXPIRED_DAYS'=>$vnd_vld));
							}
					} else {
						array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>'Keterangan Sertifikat'));
					}
				}
			}

			// if($cert_expired == true){
			// 	array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Rejected', 'REASON'=>'Dokumen Hampir Expired', 'CONTAINER'=>'Keterangan Sertifikat', 'EXPIRED_DAYS'=>$vnd_vld));
			// } else {
			// 	array_push($list_panel, array('VENDOR_ID'=>$val['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>'Keterangan Sertifikat'));
			// }
			
			array_push($list_panel, array('VENDOR_ID'=>$vendor['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>$panel_title[0]));
			array_push($list_panel, array('VENDOR_ID'=>$vendor['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>$panel_title[1]));
			array_push($list_panel, array('VENDOR_ID'=>$vendor['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>$panel_title[2]));
			array_push($list_panel, array('VENDOR_ID'=>$vendor['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>$panel_title[3]));
			array_push($list_panel, array('VENDOR_ID'=>$vendor['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>$panel_title[4]));
			array_push($list_panel, array('VENDOR_ID'=>$vendor['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>$panel_title[5]));
			array_push($list_panel, array('VENDOR_ID'=>$vendor['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>$panel_title[6]));
			array_push($list_panel, array('VENDOR_ID'=>$vendor['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>$panel_title[7]));
			array_push($list_panel, array('VENDOR_ID'=>$vendor['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>$panel_title[8]));
			array_push($list_panel, array('VENDOR_ID'=>$vendor['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>$panel_title[9]));
			array_push($list_panel, array('VENDOR_ID'=>$vendor['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>$panel_title[10]));
			array_push($list_panel, array('VENDOR_ID'=>$vendor['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>$panel_title[11]));
			array_push($list_panel, array('VENDOR_ID'=>$vendor['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>$panel_title[12]));
			array_push($list_panel, array('VENDOR_ID'=>$vendor['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>$panel_title[13]));
			array_push($list_panel, array('VENDOR_ID'=>$vendor['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>$panel_title[14]));
			array_push($list_panel, array('VENDOR_ID'=>$vendor['VENDOR_ID'], 'STATUS'=>'Approved', 'REASON'=>'', 'CONTAINER'=>$panel_title[15]));
		}

		// 'Domisili Perusahaan','SIUP','TDP','Angka Pengenal Importir','Dewan Komisaris','Dewan direksi','Barang dan bahan yang bisa dipasok','Jasa yang bisa dipasok','Keterangan Sertifikat',
		// var_dump($list_panel); die();
		$panel_temp = array_unique($list_panel);
		// 'panel' => $panel_temp
		return $panel_temp;
	}

	public function reminder(){ // function untuk melakukan peringatan (tombol peringatan) dengan mengrimim email ke vendor
		$this->load->model(array(
				'vnd_header',
				'vnd_akta',
				'vnd_address',
				'vnd_board',
				'vnd_fin_rpt',
				'vnd_bank',
				'vnd_product',
				'vnd_sdm',
				'vnd_cert',
				'vnd_equip',
				'vnd_cv',
				'vnd_add',
				'vnd_update_progress',

				'hist_vnd_header',
				'hist_vnd_akta',
				'hist_vnd_address',
				'hist_vnd_board',
				'hist_vnd_fin_rpt',
				'hist_vnd_bank',
				'hist_vnd_product',
				'hist_vnd_sdm',
				'hist_vnd_cert',
				'hist_vnd_equip',
				'hist_vnd_cv',
				'hist_vnd_add',
				));

		$input = $this->list_vendor_almost_expired();
		$input = $input['data'];
		// die(var_dump($input));
		$panels = $this->list_panel_expired($input);	

		foreach ($input as $key => $vendor) {
			$this->vnd_update_progress->delete(array('VENDOR_ID' => $vendor['VENDOR_ID']));
		}

		foreach ($panels as $key => $vnd_panel) {
			$this->vnd_update_progress->insert($vnd_panel);
		}

		foreach ($input as $key => $value) {
			$id = $value['VENDOR_ID'];
			$emailvnd = $this->vnd_header->get(array('VENDOR_ID' => $id));
			$data['exp'] = $this->vnd_update_progress->get_all(array('VENDOR_ID' => $id));
			$this->load->library('email');
			$this->config->load('email'); 
			$semenindonesia = $this->config->item('semenindonesia'); 
			$this->email->initialize($semenindonesia['conf']);
			$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
			$this->email->to($emailvnd['EMAIL_ADDRESS']);
			$this->email->cc('pengadaan.semenindonesia@gmail.com');

			$this->load->model('vendor_employe');
			$opco = $emailvnd['COMPANYID'];

			$nama_company = $this->vendor_employe->join_company_header($opco,$id);
			$this->email->subject("Expired Document for eProcurement ".$nama_company[0]['COMPANYNAME'].".");

			$content = $this->load->view('email/expired_document',$data,TRUE);
			$this->email->message($content);
			$this->email->send();

			$this->vnd_header->update(array('STATUS_PERUBAHAN' => 1), array('VENDOR_ID' => $value['VENDOR_ID']));

		}
		redirect('Vendor_profile');
	}

	public function get_new_vendor_need_update() { // function untuk menampilakan data vendor yang expired
		$data = $this->list_vendor_almost_expired();
		echo json_encode($data);
	}

	public function vnd_document_update($vnd_id){  // function untuk lihat detail data vendor yang expired
		$this->load->model(array('vnd_header', 'vnd_board', 'vnd_product', 'vnd_cert'));
		$data['PANEL_TITLE'] = array('ADDRESS'=>'DOMISILI PERUSAHAAN', 'SIUP'=>'SIUP', 'TDP'=>'TDP', 'API'=>'ANGKA PENGENAL IMPORTIR', 'KOMISIONER'=>'DEWAN KOMISARIS', 'DIRECTOR'=>'DEWAN DIREKSI', 'BARANG'=>'BARANG DAN JASA YANG BISA DIPASOK', 'JASA'=>'JASA YANG BISA DIPASOK', 'SERTIFIKAT'=>'KETERANGAN SERTIFIKAT');
		$data['DATE_EXPIRED'] = array();
		$data['PANELS'] = array('ADDRESS', 'SIUP', 'TDP', 'API', 'KOMISIONER', 'DIRECTOR', 'BARANG', 'JASA', 'SERTIFIKAT');

		$vnd_headers = $this->vnd_header->get(array('VENDOR_ID'=>$vnd_id));
		$vnd_boards = $this->vnd_board->get(array('VENDOR_ID'=>$vnd_id));
		$vnd_products = $this->vnd_product->get(array('VENDOR_ID'=>$vnd_id));
		$vnd_certs = $this->vnd_cert->get(array('VENDOR_ID'=>$vnd_id));
		
		$date_now = date('d-m-Y');

		$siup = false;
		$tdp = false;
		$api = false;
		$address = false;
		if(!empty($vnd_headers)){

			if ($vnd_headers['SIUP_TO'] != '') {
				$vn_siup = day_difference(oraclestrtotime($vnd_headers['SIUP_TO']),strtotime($date_now), false);
				if($vn_siup == 90 || $vn_siup == 60 || $vn_siup == 30 || $vn_siup < 0){
					$siup = true;
					$data['DATE_EXPIRED']['SIUP'] = $vnd_headers['SIUP_TO'];
				} 
			}

			if ($vnd_headers['ADDRESS_DOMISILI_EXP_DATE'] != '') { 
				$vn_addrs = day_difference(oraclestrtotime($vnd_headers['ADDRESS_DOMISILI_EXP_DATE']),strtotime($date_now), false);
				if($vn_addrs == 90 || $vn_addrs == 60 || $vn_addrs == 30 || $vn_addrs < 0){
					$address = true;
					$data['DATE_EXPIRED']['ADDRESS'] = $vnd_headers['ADDRESS_DOMISILI_EXP_DATE'];
				}
			}

			if ($vnd_headers['TDP_TO'] != '') { 
				$vn_tdp = day_difference(oraclestrtotime($vnd_headers['TDP_TO']),strtotime($date_now), false);
				if($vn_tdp == 90 || $vn_tdp == 60 || $vn_tdp == 30 || $vn_tdp < 0){
					$tdp = true;
					$data['DATE_EXPIRED']['TDP'] = $vnd_headers['TDP_TO'];
				}
			}
			
			if ($vnd_headers['API_TO'] != '') { 
				$vn_api = day_difference(oraclestrtotime($vnd_headers['API_TO']),strtotime($date_now), false);
				if(!$vn_api == 90 || $vn_api == 60 || $vn_api == 30 || $vn_api < 0){
					$api = true;
					$data['DATE_EXPIRED']['API'] = $vnd_headers['API_TO'];
				}	
			}
		}
		$data['DOC_EXPIRED']['SIUP'] = $siup;
		$data['DOC_EXPIRED']['ADDRESS'] = $address;
		$data['DOC_EXPIRED']['TDP'] = $tdp;
		$data['DOC_EXPIRED']['API'] = $api;

		$ktp_director = false;
		$ktp_komisioner = false;
		if(!empty($vnd_boards)){

			if ($vnd_boards['KTP_EXPIRED_DATE'] != '') { 
				$vnd_ktp = day_difference(oraclestrtotime($vnd_boards['KTP_EXPIRED_DATE']),strtotime($date_now), false);
				if($vnd_ktp == 90 || $vnd_ktp == 60 || $vnd_ktp == 30 || $vnd_ktp < 0){
					if($vnd_boards['TYPE']=="Director"){
						$ktp_director = true;
						$data['DATE_EXPIRED']['DIRECTOR'] = $vnd_boards['KTP_EXPIRED_DATE'];
					} else if($vnd_boards['TYPE']=="Commissioner"){
						$ktp_komisioner = true;
						$data['DATE_EXPIRED']['KOMISIONER'] = $vnd_boards['KTP_EXPIRED_DATE'];
					} 	
				}
			}
		}
		$data['DOC_EXPIRED']['DIRECTOR'] = $ktp_director;
		$data['DOC_EXPIRED']['KOMISIONER'] = $ktp_komisioner;

		$product_good = false;
		$product_jasa = false;
		if(!empty($vnd_products)){

			if ($vnd_products['EXPIRED_DATE'] != '') {
				$vnd_exprd = day_difference(oraclestrtotime($vnd_products['EXPIRED_DATE']),strtotime($date_now), false);
				if($vnd_exprd == 90 || $vnd_exprd == 60 || $vnd_exprd == 30 || $vnd_exprd < 0){
					if($vnd_products['PRODUCT_TYPE']=='GOODS'){
						$product_good = true; 
						$data['DATE_EXPIRED']['BARANG'] = $vnd_products['EXPIRED_DATE'];
					} else if($vnd_products['PRODUCT_TYPE']=='SERVICES'){
						$product_jasa = true; 
						$data['DATE_EXPIRED']['JASA'] = $vnd_products['EXPIRED_DATE'];
					}
				}
			}
		}
		$data['DOC_EXPIRED']['BARANG'] = $product_good;
		$data['DOC_EXPIRED']['JASA'] = $product_jasa;

		$cert = false;
		if(!empty($vnd_certs)){
			
			if ($vnd_certs['VALID_TO'] != '') {
				$vnd_vld = day_difference(oraclestrtotime($vnd_certs['VALID_TO']),strtotime($date_now), false);
				if($vnd_vld == 90 || $vnd_vld == 60 || $vnd_vld == 30 || $vnd_vld < 0){
					$cert = true;
					$data['DATE_EXPIRED']['SERTIFIKAT'] = $vnd_certs['VALID_TO'];
				}
			}
		}
		$data['DOC_EXPIRED']['SERTIFIKAT'] = $cert;

		$data['title'] = "Detail Expired Document";
		$this->layout->render('vendor_doc_expired', $data);
		//var_dump($data);
	}

	public function tes_day(){
		$date_dummyy = date('d-m-Y', strtotime('09-04-2016'));
		$date_now = date('d-m-Y');
		var_dump(day_difference(strtotime($date_dummyy), strtotime($date_now)));
	}
}
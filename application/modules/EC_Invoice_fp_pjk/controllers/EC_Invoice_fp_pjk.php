<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Invoice_fp_pjk extends MX_Controller {
	private $user;
	private $user_email;
	private $roles_user;
	private $current_roles;
	public function __construct() {

		parent::__construct();
//error_reporting(0);
		$this->load->library('Authorization');
		$this->load->helper('url');
		$this->load->library('Layout');
		$this->load->helper("security");
		$this->user_email = $this->session->userdata('EMAIL');
		$this->user = $this->session->userdata('FULLNAME');
		/* dapatkan role untuk fitur verifikasi ini */
		$this->roles_user = $this->getRolePajak();
		$this->load->model('invoice/ec_role_user', 'role_user');
		$email_login = explode('@', $this->user_email);
		$this->current_roles = array();
		$_tmp = $this->role_user->get_all(array('USERNAME' => $email_login[0], 'STATUS' => 1));
		if(!empty($_tmp)){
			foreach($_tmp as $_t){
				array_push($this->current_roles,$_t->ROLE_AS);
			}
		}
	}

	public function index($kode = '-') {
		$data['title'] = "Approval Faktur Pajak";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
		$this->layout->add_css('pages/EC_bootstrap-slider.min.css');
		$this->layout->add_js('pages/EC_bootstrap-slider.min.js');
		$this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
		$this->layout->add_js('pages/EC_Invoice_fp_pjk.js?18');
		$this->layout->add_css('pages/EC_style_ecatalog.css');
		$this->layout->render('list', $data);
	}

	public function ekspedisiFaktur(){
		// error_reporting(E_ALL);   
		$this->load->library('sap_invoice');
		$this->load->model('invoice/ec_invoice_header','eo');

		$email = $this->session->userdata('EMAIL');
		$nama = $this->session->userdata('FULLNAME');
		$company = $this->session->userdata('COMPANYID');

		$jumlah=count($this->input->post('STATUS_SETOR'));
		$no_faktur=$this->input->post('STATUS_SETOR');

		if($no_faktur==false){
			$pesan .= '[ERROR] Belum Memilih Faktur '."<br>";
			$this->session->set_flashdata('message', $pesan);
			redirect('EC_Invoice_fp_pjk');
		}


        // ambil vendor dulu
		$vendor_semua=array();
		foreach ($no_faktur as $i => $a) {
			$ambil_faktur_header = $this->eo->get_faktur($no_faktur[$i]);
            // echo "<pre>";
            // print_r($ambil_faktur_header);
			$ambilnofaktur = str_replace('-', '', $no_faktur[$i]);
			$ambilnofaktur = str_replace('.', '', $ambilnofaktur);
			$vendor=$this->db->select('VENDOR_NO, VENDOR_NAME, VENDOR_TYPE, EMAIL_ADDRESS')->from('VND_HEADER')->where('VENDOR_NO', $ambil_faktur_header['VENDOR_NO'])->get()->result_array();
			$input_vendor = array(
				'VENDOR_NAME' => $vendor[0]['VENDOR_NAME'],
				'VENDOR_NO' => $vendor[0]['VENDOR_NO'],
				'VENDOR_TYPE' => $vendor[0]['VENDOR_TYPE']
			);       
			array_push($vendor_semua, $input_vendor);
		}
		$vendor_semua = array_unique($vendor_semua);
        // echo "<pre>";
        // print_r($vendor_semua);die;
        // selesai


		foreach ($vendor_semua as $vs) {
			$input_param=array(        
				'BUKRS' => $company,
				'LIFNR' => $vs['VENDOR_NO'],
				'EMAIL' => $email,
				'PERSON' => $nama
			);  

			$input=array();
			foreach ($no_faktur as $i => $a) {
				$ambil_faktur_header = $this->eo->get_faktur($no_faktur[$i]);
				$ambilnofaktur = str_replace('-', '', $no_faktur[$i]);
				$ambilnofaktur = str_replace('.', '', $ambilnofaktur);
				if($vs['VENDOR_NO']==$ambil_faktur_header['VENDOR_NO']){   
					$input_sap = array(
						'XBLNR' => $ambilnofaktur,
						'BLDAT' => date('Ymd', oraclestrtotime($ambil_faktur_header['FAKTUR_PJK_DATE'])), 
						'BEDAT' => date('Ymd', oraclestrtotime($ambil_faktur_header['INVOICE_DATE'])), 
						'HWBAS' => $ambil_faktur_header['TOTAL_AMOUNT'], 
						'EBELN' => $ambil_faktur_header['NO_SP_PO']            
					);       
					array_push($input, $input_sap);
				}
			}    


			$act=$this->sap_invoice->setEkspedisiFaktur($input_param, $input);     
			if($act){
				$tgl_sekarang=date("Ymd");
				if($act['pesan']['TYPE']==='S'){
					$data = array(        
						'NO_EKSPEDISI'  => $act['noeks'],
						'COMPANY'       => $company,
						'VENDORNO'      => $vs['VENDOR_NO'],
						'NATION'        => $vs['VENDOR_TYPE'],
						'NAMA_SETOR'    => $nama,
						'STATUS_SETOR'  => 2,
					);    
					$this->db->trans_start();
					$this->db->set('TGL_EKSPEDISI',"to_date('".$tgl_sekarang."','YYYYMMDD')",false);  
					$this->db->insert('EC_FAKTUR_EAEA', $data);       
					foreach ($act['output'] as $i => $a) {
						$data_detail = array(
							'NO_EKSPEDISI' => $act['noeks'],
							'NO_FAKTUR' => $act['output'][$i]['XBLNR'],
							'TGL_FAKTUR' => $act['output'][$i]['BLDAT'],
							'NPWP'=>$act['output'][$i]['STCD1'],
							'DPP'=>$act['output'][$i]['HWBAS'],
							'PPN'=>$act['output'][$i]['HWSTE'],
							'TGL_BAST'=>date('Ymd', oraclestrtotime($ambil_faktur_header['INVOICE_DATE'])),
							'PO'=>$ambil_faktur_header['NO_SP_PO']
						);       
						$this->db->insert('EC_FAKTUR_DETAILS', $data_detail);
					}
					$this->db->trans_complete();
					$pesan .= $act['pesan']['MESSAGE'].' ['.$vs['VENDOR_NAME'].'] '.' Dengan Ekspedisi No.'.$act['noeks']."<br>";
					$this->session->set_flashdata('message', $pesan);
				} else {
					$pesan .= '[ERROR] '.$act['pesan']['MESSAGE'].' ['.$vs['VENDOR_NAME'].'] '."<br>";
					$this->session->set_flashdata('message', $pesan);
				}                 
			}else{
				$pesan .= '[ERROR] '.$act['pesan']['MESSAGE'].' ['.$no_faktur[$i].'] '."<br>";
				$this->session->set_flashdata('message', $pesan);
			}

		}

        // echo "<pre>";
        // print_r($input_param);
        // print_r($input);
        // die;

		redirect('EC_Invoice_fp_pjk');
	}

	public function approveFaktur() {
		// error_reporting(E_ALL);   
		$this->load->library('sap_invoice');
		$this->load->model('invoice/ec_invoice_header','eo');

		$email = $this->session->userdata('EMAIL');
		$nama = $this->session->userdata('FULLNAME');
		$company = $this->session->userdata('COMPANYID');

		$jumlah=count($this->input->post('NOFAK'));
		$no_faktur=$this->input->post('NOFAK');
		$company = $this->input->post('COMPANYCODE');
		echo "<pre>";
		print_r($company);die();

		$pesan = "";

		if($no_faktur==false){
			$pesan .= '[ERROR] Belum Memilih Faktur '."<br>";
			$this->session->set_flashdata('message', $pesan);
			redirect('EC_Invoice_fp_pjk');
		}

		$act=$this->sap_invoice->getFakturPajakPerCompany($era);
	}

	public function rejectFaktur() {
		error_reporting(E_ALL);   
		$this->load->library('sap_invoice');
		$this->load->model('invoice/ec_invoice_header','eo');

		$email = $this->session->userdata('EMAIL');
		$nama = $this->session->userdata('FULLNAME');
		$company = $this->session->userdata('COMPANYID');

		$jumlah=count($this->input->post('STATUS_SETOR'));
		$no_faktur=$this->input->post('STATUS_SETOR');


		$pesan = "";

		if($no_faktur==false){
			$pesan .= '[ERROR] Belum Memilih Faktur '."<br>";
			$this->session->set_flashdata('message', $pesan);
			redirect('EC_Invoice_fp_pjk');
		}
	}

	public function get_invoice_lanjut() {
        // error_reporting(E_ALL)
		$this->load->model('ec_open_inv','eo');
		$this->load->library('sap_invoice');
		$this->load->model('invoice/ec_role_access','era');
		$this->load->model('invoice/ec_faktur_ekspedisi','ef');

		$role = array();
		$era = $this->db->where('ROLE_AS in (\''.implode('\',\'',$this->current_roles).'\') and ROLE_AS like \'%PAJAK%\'')->get('EC_ROLE_ACCESS')->result_array();

        // $AuthCompany = array();

        //     foreach($era as $val){
        //         $AuthCompany[] = $val['VALUE'];
        //     }
        // print_r($AuthCompany);
        // echo "string";die();
		$act=$this->sap_invoice->getFakturPajakPerCompany($era);
		$data = array();
		// echo "<pre>";
		// print_r($act);die;
		for ($i=0; $i < count($act['output']) ; $i++) {
			$XBLNR = $act['output'][$i]['XBLNR'];
			$file_fp = "";
			$ambil_faktur_header = $this->ef->getFakturByFaktur($XBLNR);
			// echo "<pre>";
			// print_r($ambil_faktur_header);
			if(count($ambil_faktur_header)>0){
				if(!empty($ambil_faktur_header[0]['FILE_FP'])){
					$file_fp = $ambil_faktur_header[0]['FILE_FP'];
				}
			}
			// $XBLNR = substr($XBLNR, 0,3) .'.'. substr($XBLNR, 3,3 ) .'-'. substr($XBLNR, 6,2) .'.'. substr($XBLNR, 8,8);

			$TGL_EKSP = $act['output'][$i]['TGL_EKSP'];
			$TGL_EKSP = substr($TGL_EKSP, 6,2).'-'.substr($TGL_EKSP, 4,2).'-'.substr($TGL_EKSP, 0,4);

			$TGL_TRIMA = $act['output'][$i]['TGL_TRIMA'];
			$TGL_TRIMA = substr($TGL_TRIMA, 6,2).'-'.substr($TGL_TRIMA, 4,2).'-'.substr($TGL_TRIMA, 0,4); 
			if($act['output'][$i]['KET']=="Belum diterima"){
				if(strtotime($TGL_EKSP) >= strtotime(date('25-07-2018'))){
					$cuk = array(
						'NOMOR' => $i,
						'COMPANYCODE' => $act['output'][$i]['BUKRS'],
						'TGL_EKSPEDISI' => $TGL_EKSP,
						'NO_EKSPEDISI' => $act['output'][$i]['EKSPNO'],
						'NO_FAKTUR' => $XBLNR,
						'NO_FAKTUR_LOS' => $act['output'][$i]['XBLNR'],
						'NO_VENDOR' => $act['output'][$i]['LIFNR'],
						'NAMA_VENDOR' => $act['output'][$i]['NAME1'],
						'NPWP'=>$act['output'][$i]['STCD1'],
						'TGL_FAKTUR' => date('d-m-Y', strtotime($act['output'][$i]['BLDAT'])),
						'TGL_BAST'=> $act['output'][$i]['BLDAT'],
						'DPP'=> "Rp " . number_format(str_replace('-', '', $act['output'][$i]['HWBAS']),0,',','.'),
						'PPN'=> "Rp " . number_format(str_replace('-', '', $act['output'][$i]['HWSTE']),0,',','.'),
						'PO'=> $act['output'][$i]['EBELN'],
						'EMAIL'=> $act['output'][$i]['EMAIL'],
						'EMVENDOR'=> $act['output'][$i]['EMVENDOR'],
						'NAMA'=> $act['output'][$i]['PERSON'],
						'TGL_TERIMA' => $TGL_TRIMA,
						'POSISI'=>$act['output'][$i]['POS'],
						'KET'=>$act['output'][$i]['KET'],
						'FILE_FP'=>$file_fp,
						'LINK_FILE_FP'=>$act['output'][$i]['LFILE'],
					);
					array_push($data, $cuk);
				}
			}
		}

		// foreach ($data as $tel => $cuk) {
		// 	if ($cuk['KET'] = 'Dikembalikan') {
		// 		unset($cuk);
		// 	}
		// }

  //       echo "<pre>";
  //       print_r($data);die();
		echo json_encode(array('page' => '25', 'data'=>$data));

	}


	public function get_invoice_lanjut2() {
        // error_reporting(E_ALL)
		$this->load->model('ec_open_inv','eo');
		$this->load->library('sap_invoice');
		$this->load->model('invoice/ec_role_access','era');
		$this->load->model('invoice/ec_faktur_ekspedisi','ef');

		$role = array();
		$era = $this->db->where('ROLE_AS in (\''.implode('\',\'',$this->current_roles).'\') and ROLE_AS like \'%PAJAK%\'')->get('EC_ROLE_ACCESS')->result_array();

        // $AuthCompany = array();

        //     foreach($era as $val){
        //         $AuthCompany[] = $val['VALUE'];
        //     }
        // print_r($AuthCompany);
        // echo "string";die();
		$act=$this->sap_invoice->getFakturPajakPerCompany($era);
		$data = array();
		// echo "<pre>";
		// print_r($act);die;
		for ($i=0; $i < count($act['output']) ; $i++) {
			$XBLNR = $act['output'][$i]['XBLNR'];
			$file_fp = "";
			$ambil_faktur_header = $this->ef->getFakturByFaktur($XBLNR);
			// echo "<pre>";
			// print_r($ambil_faktur_header);
			if(count($ambil_faktur_header)>0){
				if(!empty($ambil_faktur_header[0]['FILE_FP'])){
					$file_fp = $ambil_faktur_header[0]['FILE_FP'];
				}
			}
			// $XBLNR = substr($XBLNR, 0,3) .'.'. substr($XBLNR, 3,3 ) .'-'. substr($XBLNR, 6,2) .'.'. substr($XBLNR, 8,8);

			$TGL_EKSP = $act['output'][$i]['TGL_EKSP'];
			$TGL_EKSP = substr($TGL_EKSP, 6,2).'-'.substr($TGL_EKSP, 4,2).'-'.substr($TGL_EKSP, 0,4);

			$TGL_TRIMA = $act['output'][$i]['TGL_TRIMA'];
			$TGL_TRIMA = substr($TGL_TRIMA, 6,2).'-'.substr($TGL_TRIMA, 4,2).'-'.substr($TGL_TRIMA, 0,4); 
			if($act['output'][$i]['KET']=="Diterima"){
				if(strtotime($TGL_EKSP) >= strtotime(date('25-07-2018'))){
					$cuk = array(
						'NOMOR' => $i,
						'COMPANYCODE' => $act['output'][$i]['BUKRS'],
						'TGL_EKSPEDISI' => $TGL_EKSP,
						'NO_EKSPEDISI' => $act['output'][$i]['EKSPNO'],
						'NO_FAKTUR' => $XBLNR,
						'NO_FAKTUR_LOS' => $act['output'][$i]['XBLNR'],
						'NO_VENDOR' => $act['output'][$i]['LIFNR'],
						'NAMA_VENDOR' => $act['output'][$i]['NAME1'],
						'NPWP'=>$act['output'][$i]['STCD1'],
						'TGL_FAKTUR' => date('d-m-Y', strtotime($act['output'][$i]['BLDAT'])),
						'TGL_BAST'=> $act['output'][$i]['BLDAT'],
						'DPP'=> "Rp " . number_format(str_replace('-', '', $act['output'][$i]['HWBAS']),0,',','.'),
						'PPN'=> "Rp " . number_format(str_replace('-', '', $act['output'][$i]['HWSTE']),0,',','.'),
						'PO'=> $act['output'][$i]['EBELN'],
						'EMAIL'=> $act['output'][$i]['EMAIL'],
						'EMVENDOR'=> $act['output'][$i]['EMVENDOR'],
						'NAMA'=> $act['output'][$i]['PERSON'],
						'TGL_TERIMA' => $TGL_TRIMA,
						'POSISI'=>$act['output'][$i]['POS'],
						'KET'=>$act['output'][$i]['KET'],
						'FILE_FP'=>$file_fp,
						'LINK_FILE_FP'=>$act['output'][$i]['LFILE'],
					);
					array_push($data, $cuk);
				}
			}
		}

		// foreach ($data as $tel => $cuk) {
		// 	if ($cuk['KET'] = 'Dikembalikan') {
		// 		unset($cuk);
		// 	}
		// }

  //       echo "<pre>";
  //       print_r($data);die();
		echo json_encode(array('page' => '25', 'data'=>$data));

	}


	public function get_invoice_lanjut3() {
        // error_reporting(E_ALL)
		$this->load->model('ec_open_inv','eo');
		$this->load->library('sap_invoice');
		$this->load->model('invoice/ec_role_access','era');
		$this->load->model('invoice/ec_faktur_ekspedisi','ef');

		$role = array();
		$era = $this->db->where('ROLE_AS in (\''.implode('\',\'',$this->current_roles).'\') and ROLE_AS like \'%PAJAK%\'')->get('EC_ROLE_ACCESS')->result_array();

        // $AuthCompany = array();

        //     foreach($era as $val){
        //         $AuthCompany[] = $val['VALUE'];
        //     }
        // print_r($AuthCompany);
        // echo "string";die();
		$act=$this->sap_invoice->getFakturPajakPerCompany($era);
		$data = array();
		// echo "<pre>";
		// print_r($act);die;
		for ($i=0; $i < count($act['output']) ; $i++) {
			$XBLNR = $act['output'][$i]['XBLNR'];
			$file_fp = "";
			$ambil_faktur_header = $this->ef->getFakturByFaktur($XBLNR);
			// echo "<pre>";
			// print_r($ambil_faktur_header);
			if(count($ambil_faktur_header)>0){
				if(!empty($ambil_faktur_header[0]['FILE_FP'])){
					$file_fp = $ambil_faktur_header[0]['FILE_FP'];
				}
			}
			// $XBLNR = substr($XBLNR, 0,3) .'.'. substr($XBLNR, 3,3 ) .'-'. substr($XBLNR, 6,2) .'.'. substr($XBLNR, 8,8);

			$TGL_EKSP = $act['output'][$i]['TGL_EKSP'];
			$TGL_EKSP = substr($TGL_EKSP, 6,2).'-'.substr($TGL_EKSP, 4,2).'-'.substr($TGL_EKSP, 0,4);

			$TGL_TRIMA = $act['output'][$i]['TGL_TRIMA'];
			$TGL_TRIMA = substr($TGL_TRIMA, 6,2).'-'.substr($TGL_TRIMA, 4,2).'-'.substr($TGL_TRIMA, 0,4); 
			if(strtotime($TGL_EKSP) >= strtotime(date('25-07-2018'))){
				$cuk = array(
					'NOMOR' => $i,
					'COMPANYCODE' => $act['output'][$i]['BUKRS'],
					'TGL_EKSPEDISI' => $TGL_EKSP,
					'NO_EKSPEDISI' => $act['output'][$i]['EKSPNO'],
					'NO_FAKTUR' => $XBLNR,
					'NO_FAKTUR_LOS' => $act['output'][$i]['XBLNR'],
					'NO_VENDOR' => $act['output'][$i]['LIFNR'],
					'NAMA_VENDOR' => $act['output'][$i]['NAME1'],
					'NPWP'=>$act['output'][$i]['STCD1'],
					'TGL_FAKTUR' => date('d-m-Y', strtotime($act['output'][$i]['BLDAT'])),
					'TGL_BAST'=> $act['output'][$i]['BLDAT'],
					'DPP'=> "Rp " . number_format(str_replace('-', '', $act['output'][$i]['HWBAS']),0,',','.'),
					'PPN'=> "Rp " . number_format(str_replace('-', '', $act['output'][$i]['HWSTE']),0,',','.'),
					'PO'=> $act['output'][$i]['EBELN'],
					'EMAIL'=> $act['output'][$i]['EMAIL'],
					'EMVENDOR'=> $act['output'][$i]['EMVENDOR'],
					'NAMA'=> $act['output'][$i]['PERSON'],
					'TGL_TERIMA' => $TGL_TRIMA,
					'POSISI'=>$act['output'][$i]['POS'],
					'KET'=>$act['output'][$i]['KET'],
					'FILE_FP'=>$file_fp,
					'LINK_FILE_FP'=>$act['output'][$i]['LFILE'],
				);
				array_push($data, $cuk);
			}
		}

		// foreach ($data as $tel => $cuk) {
		// 	if ($cuk['KET'] = 'Dikembalikan') {
		// 		unset($cuk);
		// 	}
		// }

  //       echo "<pre>";
  //       print_r($data);die();
		echo json_encode(array('page' => '25', 'data'=>$data));

	}

	public function getRolePajak(){
		$this->load->model('invoice/ec_role','er');
		$roles = $this->er->get_all('where ROLE_AS like \'PAJAK%\'');
		$tmp = array();
		foreach($roles as $r){
			array_push($tmp,$r->ROLE_AS);
		}
		return $tmp;
	}

	private function groupingByColumn($arr, $colum){
		$result = array();
		foreach($arr as $r){
			if(!isset($result[$r[$colum]])){
				$result[$r[$colum]] = array();
			}
			array_push($result[$r[$colum]],$r);
		}
		return $result;
	}


	public function approvePajak(){
				// error_reporting(E_ALL);
		$this->load->config('ec');
		$this->load->library('sap_invoice');
		$this->load->model('invoice/ec_faktur_ekspedisi','ef');

		// echo "<pre>";
		// print_r($this->input->post());die;

		$pesan = "";

		$NOFAK =  $this->input->post('NOFAK');
		$COMPANYCODE =  $this->input->post('COMPANYCODE');
		$NOEKS =  $this->input->post('NOEKS');
		$NO_VENDOR =  $this->input->post('NO_VENDOR');
		$NO_FAKTUR =  $this->input->post('NO_FAKTUR');

		$NAMA =  $this->input->post('NAMA');
		$EMAIL =  $this->input->post('EMAIL');
		$EMVENDOR =  $this->input->post('EMVENDOR');
		
		$jumlah=count($this->input->post('NOFAK'));

		foreach ($NOFAK as $i => $a) {
			$fp = $NOFAK[$i];
			$company = $COMPANYCODE[$i];
			$vn = $NO_VENDOR[$i];
			$ekspedisi = $NOEKS[$i];
			$faktur = $NO_FAKTUR[$i];

			$nama_s = $NAMA[$i];
			$email_s = $EMAIL[$i];
			$email_v = $EMVENDOR[$i];

			$act=$this->sap_invoice->approveFakturPajak($company, $ekspedisi, $fp, $vn);

			// echo "<pre>";
			// print_r($act);die;
			if($act){
				if($act['pesan']['TYPE']==='S'){
					$pesan .= '[SUCCESS] '.$act['pesan']['MESSAGE'].' [ Faktur No.'.$faktur." ]<br>";

					// email
					$vendor=$this->db->select('VENDOR_NAME, VENDOR_TYPE, EMAIL_ADDRESS')->from('VND_HEADER')->where('VENDOR_NO', $vn)->get()->result_array(); 
					$data_email = array(
						'EMAIL_ADDRESS1'=>$email_s,
						'EMAIL_ADDRESS2'=>$email_v,
						'SUBJECT'=>"[APPROVED] Ekspedisi ".$ekspedisi." dengan Faktur Pajak ".$fp.".",
						'data'=>array(
							'VENDOR_NAME'	=> $vendor[0]['VENDOR_NAME'],
							'NO_EKSPEDISI'	=> $ekspedisi,
							'NO_FAKTUR'		=> $fp,
							'VENDORNO'      => $vn,
							'NATION'        => $vendor[0]['VENDOR_TYPE'],
							'NAMA_SETOR'    => $nama_s,
							'EMAIL_SETOR'   => $email_s,
							'HEADER'   		=> 'Faktur Pajak Telah Diterima',
							'PESAN_KEMBALI'   => "",
						)
					);
					$this->kirim_email_po($data_email);
					// email

				} else {
					$pesan .= '[ERROR] '.$act['pesan']['MESSAGE'].' [ Faktur No.'.$faktur." ]<br>";
				}
			} else {
				$pesan .= '[ERROR] '.$act['pesan']['MESSAGE'].' [ Faktur No.'.$faktur." ]<br>";
			}
		}

		$this->session->set_flashdata('message', $pesan);
		redirect('EC_Invoice_fp_pjk');
	}

	public function rejectPajak(){
				// error_reporting(E_ALL);
		$this->load->config('ec');
		$this->load->library('sap_invoice');
		$this->load->model('invoice/ec_faktur_ekspedisi','ef');

		// echo "<pre>";
		// print_r($this->input->post());die;

		$pesan = "";

		$NOFAK =  $this->input->post('NOFAK');
		$COMPANYCODE =  $this->input->post('COMPANYCODE');
		$NOEKS =  $this->input->post('NOEKS');
		$NO_VENDOR =  $this->input->post('NO_VENDOR');
		$NO_FAKTUR =  $this->input->post('NO_FAKTUR');
		$PESAN_REJECT =  $this->input->post('PESAN');

		$NAMA =  $this->input->post('NAMA');
		$EMAIL =  $this->input->post('EMAIL');
		$EMVENDOR =  $this->input->post('EMVENDOR');

		$jumlah=count($this->input->post('NOFAK'));

		foreach ($NOFAK as $i => $a) {
			$fp = $NOFAK[$i];
			$company = $COMPANYCODE[$i];
			$vn = $NO_VENDOR[$i];
			$ekspedisi = $NOEKS[$i];
			$faktur = $NO_FAKTUR[$i];

			$nama_s = $NAMA[$i];
			$email_s = $EMAIL[$i];
			$email_v = $EMVENDOR[$i];

			$act=$this->sap_invoice->rejectFakturPajak($company, $ekspedisi, $fp, $vn, $PESAN_REJECT);
			// echo "<pre>";
			// print_r($act);die;
			if($act){
				if($act['pesan']['TYPE']==='S'){
					$pesan .= '[SUCCESS] '.$act['pesan']['MESSAGE'].' [ Faktur No.'.$faktur." ]<br>";

					// email
					$vendor=$this->db->select('VENDOR_NAME, VENDOR_TYPE, EMAIL_ADDRESS')->from('VND_HEADER')->where('VENDOR_NO', $vn)->get()->result_array(); 
					$data_email = array(
						'EMAIL_ADDRESS1'=>$email_s,
						'EMAIL_ADDRESS2'=>$email_v,
						'SUBJECT'=>"[REJECT] Ekspedisi ".$ekspedisi." dengan Faktur Pajak ".$fp.".",
						'data'=>array(
							'VENDOR_NAME'	=> $vendor[0]['VENDOR_NAME'],
							'NO_EKSPEDISI'	=> $ekspedisi,
							'NO_FAKTUR'		=> $fp,
							'VENDORNO'      => $vn,
							'NATION'        => $vendor[0]['VENDOR_TYPE'],
							'NAMA_SETOR'    => $nama_s,
							'EMAIL_SETOR'   => $email_s,
							'HEADER'   		=> 'Faktur Pajak Telah Dikembalikan',
							'PESAN_KEMBALI'   => $PESAN_REJECT,
						)
					);
					$this->kirim_email_po($data_email);
					// email

				} else {
					$pesan .= '[ERROR] '.$act['pesan']['MESSAGE'].' [ Faktur No.'.$faktur." ]<br>";
				}
			} else {
				$pesan .= '[ERROR] '.$act['pesan']['MESSAGE'].' [ Faktur No.'.$faktur." ]<br>";
			}
		}

		$this->session->set_flashdata('message', $pesan);
		redirect('EC_Invoice_fp_pjk');
	}


	public function kirim_email_po($data_email){		
		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		// dev
		// $this->email->to('tithe.j@sisi.id');  
		// dev

		// prod
    	$this->email->to($data_email['EMAIL_ADDRESS1']);
		if($data_email['EMAIL_ADDRESS2']!=""){
			$this->email->cc($data_email['EMAIL_ADDRESS2']);
		}
		// prod

		$this->email->subject($data_email['SUBJECT']);
		$content = $this->load->view('email/approve_pjk',$data_email['data'],TRUE);
		$this->email->message($content);
		$this->email->send();
	}


}

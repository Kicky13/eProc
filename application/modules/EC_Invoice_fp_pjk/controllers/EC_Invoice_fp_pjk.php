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
		$this->layout->add_js('pages/EC_Invoice_fp_pjk.js?4');
		$this->layout->add_css('pages/EC_style_ecatalog.css');
		$this->layout->render('list', $data);
	}

	public function ekspedisiFaktur(){
		error_reporting(E_ALL);   
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
				$pesan .= '[ERROR_SAP] '.$act['pesan']['MESSAGE'].' ['.$no_faktur[$i].'] '."<br>";
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
		error_reporting(E_ALL);   
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

		for ($i=0; $i < count($act['output']) ; $i++) {
			$cuk99 = $act['output'][$i]['XBLNR'];
			$file_fp = " - ";
			$ambil_faktur_header = $this->ef->getFakturByFaktur($cuk99);
			// echo "<pre>";
			// print_r($ambil_faktur_header);
			if(count($ambil_faktur_header)>0){
				if(!empty($ambil_faktur_header[0]['FILE_FP'])){
					$file_fp = $ambil_faktur_header[0]['FILE_FP'];
				}
			}
			$cuk99 = substr($cuk99, 0,3) .'.'. substr($cuk99, 3,3 ) .'-'. substr($cuk99, 6,2) .'.'. substr($cuk99, 8,8);

			$cuk1 = $act['output'][$i]['BLDAT'];
			$cuk1 = substr($cuk1, 6,2).'-'.substr($cuk1, 4,2).'-'.substr($cuk1, 0,4);

			$cuk2 = $act['output'][$i]['TGL_TRIMA'];
			$cuk2 = substr($cuk2, 6,2).'-'.substr($cuk2, 4,2).'-'.substr($cuk2, 0,4); 
			$cuk = array(
				'COMPANYCODE' => $act['output'][$i]['BUKRS'],
				'TGL_EKSPEDISI' => $cuk1,
				'NO_EKSPEDISI' => $act['output'][$i]['EKSPNO'],
				'NO_FAKTUR' => $cuk99,
				'NO_VENDOR' => $this->session->userdata('VENDOR_NO'),
				'NAMA_VENDOR' => $act['output'][$i]['NAME1'],
				'NPWP'=>$act['output'][$i]['STCD1'],
				'TGL_FAKTUR' => $act['output'][$i]['BLDAT'],
				'TGL_BAST'=> $act['output'][$i]['BLDAT'],
				'DPP'=> "Rp " . number_format($act['output'][$i]['HWBAS'],2,',','.'),
				'PPN'=> "Rp " . number_format($act['output'][$i]['HWSTE'],2,',','.'),
				'PO'=> $act['output'][$i]['EBELN'],
				'EMAIL'=> $act['output'][$i]['EMAIL'],
				'NAMA'=> $act['output'][$i]['PERSON'],
				'TGL_TERIMA' => $cuk2,
				'POSISI'=>$act['output'][$i]['POS'],
				'KET'=>$act['output'][$i]['KET'],
				'FILE_FP'=>$file_fp,
			);
			array_push($data, $cuk);
		}
        // echo "<pre>";
        // print_r($data);die();
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
}
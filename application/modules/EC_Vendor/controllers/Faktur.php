<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Faktur extends MX_Controller {
	private $user;
	private $user_email;
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('url');
		$this -> load -> library('Layout');
		$this -> load -> helper("security");
		$this->vendor_no = $this->session->userdata('VENDOR_NO');
		$this->load->model('invoice/ec_faktur_ekspedisi','fe');
	}

	public function index(){
		$this -> load -> library('Authorization');
		$data['title'] = "List Ekspedisi Faktur Pajak";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_validate_css();
		$this->layout->set_validate_js();

		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');

		$this->layout->add_css('pages/EC_miniTable.css');
		$this->layout->add_css('pages/invoice/common.css');

		$this->layout->add_js('bootbox.js');
		$this->layout->add_js('pages/invoice/EC_common.js');
		$this->layout->add_js('pages/invoice/ec_vendor_faktur.js?2');
		$this->layout->render('EC_Vendor/faktur/list', $data);
	}

	public function data(){
//YANG LAMA START-------------        
        // $data = $this->fe->getData($this->session->userdata('VENDOR_NO'));
        // // echo "<pre>";
        // echo json_encode(array('data'=>$data));
        // print_r($data);   
// YANG LAMA END -------------
		$this->load->library('sap_invoice');
		$this->load->model('invoice/ec_faktur_ekspedisi','ef');
		$vendor_id = $this->session->userdata('VENDOR_NO');
		$act=$this->sap_invoice->getFakturPajakAll($vendor_id);
		$data = array();
		// echo "<pre>";
		// print_r($act);die;
		$key = array();
		for ($i = 0; $i < count($act['output']); $i++) {
			$no_faktur = $act['output'][$i]['XBLNR'];

			$file_fp = "";
			$ambil_faktur_header = $this->ef->getFakturByFaktur($no_faktur);
			// echo "<pre>";
			// print_r($ambil_faktur_header);
			if(count($ambil_faktur_header)>0){
				if(!empty($ambil_faktur_header[0]['FILE_FP'])){
					$file_fp = $ambil_faktur_header[0]['FILE_FP'];
				}
			}

			$no_faktur = substr($no_faktur, 0,3) .'.'. substr($no_faktur, 3,3 ) .'-'. substr($no_faktur, 6,2) .'.'. substr($no_faktur, 8,8);

			$tgl_eksp = $act['output'][$i]['TGL_EKSP'];
			$tgl_eksp = substr($tgl_eksp, 6,2).'-'.substr($tgl_eksp, 4,2).'-'.substr($tgl_eksp, 0,4);

			$tgl_terima = $act['output'][$i]['TGL_TRIMA'];
			$tgl_terima = substr($tgl_terima, 6,2).'-'.substr($tgl_terima, 4,2).'-'.substr($tgl_terima, 0,4);

			$data2 = array (
				'COMPANYCODE' => $act['output'][$i]['BUKRS'],
				'TGL_EKSPEDISI' => $tgl_eksp,
				'NO_EKSPEDISI' => $act['output'][$i]['EKSPNO'],
				'NO_FAKTUR' => $no_faktur,
				'NO_VENDOR' => $this->session->userdata('VENDOR_NO'),
				'NAMA_VENDOR' => $act['output'][$i]['NAME1'],
				'NPWP'=>$act['output'][$i]['STCD1'],
				'TGL_FAKTUR' => $act['output'][$i]['BLDAT'],
				'TGL_BAST'=> $act['output'][$i]['BLDAT'],
				'DPP'=> "Rp " . number_format(str_replace('-', '', $act['output'][$i]['HWBAS']),2,',','.'),
				'PPN'=> "Rp " . number_format(str_replace('-', '', $act['output'][$i]['HWSTE']),2,',','.'),
				'PO'=> $act['output'][$i]['EBELN'],
				'EMAIL'=> $act['output'][$i]['EMAIL'],
				'NAMA'=> $act['output'][$i]['PERSON'],
				'TGL_TERIMA' => $tgl_terima,
				'POSISI'=>$act['output'][$i]['POS'],
				'KET'=>$act['output'][$i]['KET'],
				'FILE_FP'=>$file_fp,
				'LINK_FILE_FP'=>$act['output'][$i]['LFILE'],
				'PESAN'=>$act['output'][$i]['NOTE'],
			);
			// fungsi @ untuk mematikan error jika variable belum di deklarasi sebelumnya
			$key[$data2['NO_EKSPEDISI']] = ($data2['KET'] == 'Diterima' ? (@$key[$data2['NO_EKSPEDISI']] == 'false' ? 'false' : 'true') : 'false');
			array_push($data, $data2);	
			
		}

		foreach ($data as $k=> $v) {
			$data[$k]['STATUS_PRINT']  = $key[$v['NO_EKSPEDISI']];
		}

		// echo "<pre>";
		// print_r($data);die;

		echo json_encode(array('data'=>$data));	        
	}

	public function ekspedisiFaktur(){   
		// error_reporting(E_ALL);
		$this->load->library('sap_invoice');

// print_r($this->input->post('no_faktur'));
// die();

		$vendor=$this->db->select('VENDOR_NAME, VENDOR_TYPE, EMAIL_ADDRESS')->from('VND_HEADER')->where('VENDOR_NO', $this->session->userdata('VENDOR_NO'))->get()->result_array();                          
		$email=$this->input->post('email');
		$email=$email[0];

		$nama=$this->input->post('nama');
		$nama=$nama[0];
		$jumlah=count($this->input->post('no_faktur'));
		$company=$this->input->post('company');
		$no_faktur=$this->input->post('no_faktur');
		$tgl_faktur=$this->input->post('tgl_faktur');    

		$dpp=$this->input->post('dasar_pajak');
		$dpp = str_replace(',', '', $dpp);
		$bast=$this->input->post('tgl_bast');
		$po=$this->input->post('po');  
		$file_gambar=$this->input->post('file_gambar');  
		$link_file_gambar=$this->input->post('link_file_gambar');  
        // $input_param=array(        
        //     'BUKRS' => $company,
        //     'LIFNR' => $this->session->userdata('VENDOR_NO'),
        //     'EMAIL' => $vendor[0]['EMAIL_ADDRESS']
        //     );
		$input_param=array(        
			'BUKRS' => $company,
			'LIFNR' => $this->session->userdata('VENDOR_NO'),
			'EMAIL' => $email,
			'PERSON' =>	$nama
		);  

		$input=array();

		foreach ($no_faktur as $i => $a) {
			$input_sap = array(
				'XBLNR' => $no_faktur[$i],
				'BLDAT' => $tgl_faktur[$i],
				'BEDAT' => $bast[$i],
				'HWBAS'=>$dpp[$i],
				'EBELN'=>$po[$i],            
				'LFILE'=>$link_file_gambar[$i]            
			);       
			array_push($input, $input_sap);
		}

		$act=$this->sap_invoice->setEkspedisiFaktur($input_param, $input);

		if($act){
			$tgl_sekarang=date("Ymd");
			if($act['pesan']['TYPE']==='S'){
				$data = array(        
					'NO_EKSPEDISI'  => $act['noeks'],
					'COMPANY'       => $this->input->post('company'),
					'VENDORNO'      => $this->session->userdata('VENDOR_NO'),
					'NATION'        => $vendor[0]['VENDOR_TYPE'],
					'NAMA_SETOR'    => $nama,
					'EMAIL_SETOR'   => $email,
					'STATUS_SETOR'  => 1,
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
						'TGL_BAST'=>$act['output'][$i]['BLDAT'],
						'PO'=>$act['output'][$i]['EBELN'],
						'FILE_FP'=>$file_gambar[$i]
					);
			//echo "<pre>";
            //        print_r($data_detail);
            // echo "</pre>";     

					$this->db->insert('EC_FAKTUR_DETAILS', $data_detail);
				}
				$this->db->trans_complete();
				$pesan = $act['pesan']['MESSAGE'].' Dengan Ekspedisi No.'.$act['noeks'];
				$this->session->set_flashdata('message', $pesan);

				// email
				$data_email = array(
					'EMAIL_ADDRESS'=>'approved.pajak@semenindonesia.com',
					'data'=>array(
						'VENDOR_NAME'	=>$vendor[0]['VENDOR_NAME'],
						'NO_EKSPEDISI'	=>$act['noeks'],
						'VENDORNO'      => $this->session->userdata('VENDOR_NO'),
						'NATION'        => $vendor[0]['VENDOR_TYPE'],
						'NAMA_SETOR'    => $nama,
						'EMAIL_SETOR'   => $email,
					)
				);
				$this->kirim_email_po($data_email);
				// email

				redirect('EC_Vendor/Faktur');
			} else {
				$pesan = '[ERROR] '.$act['pesan']['MESSAGE'];
				$this->session->set_flashdata('message', $pesan);
				redirect('EC_Vendor/Faktur/ekspedisi');
			}                 
		}else{
			die('GAGAL');
		}
	}  

	public function cetakDocument() {
        //KODINGAN LAMA - START
        // $this->load->config('ec');
        // $kirim['ekspedisi'] = $this->input->post('id');
        // $company_code = $this->input->post('company_code');
        // $kirim['company_code'] = $this->input->post('company');
        // $kirim['vendor_name']=$this->session->userdata('VENDOR_NAME');
        // $kirim['vendor_no']=$this->session->userdata('VENDOR_NO');
        // // print_r($kirim);die();
        // $this->load->library('M_pdf');
        // $mpdf = new M_pdf();
        // $kirim['nation']=$this->db->select('VENDOR_TYPE')->from('VND_HEADER')->where('VENDOR_NO', $this->session->userdata('VENDOR_NO'))->get()->result_array();            
        // $company_data = $this->config->item('company_data');                
        // $kirim['company_data'] = $company_data[$company_code];  
        // $kirim['data']=$this->fe->getFaktur($kirim['ekspedisi']);            
        // $kirim['data_header']=$this->fe->getDataEkspedisi($kirim['ekspedisi']); 

        // // echo "<pre>";
        // // print_r($kirim['data_header']);die;  

        // $html = $this->load->view('EC_Vendor/faktur/cetak', $kirim, TRUE);

        // $mpdf->pdf->writeHTML($html);
        // $footer_rr = $this->load->view('EC_Vendor/faktur/footer', $kirim, TRUE);
        // $mpdf->pdf->SetHTMLFooter($footer_rr);
        // $mpdf->pdf->output('Ekspedisi Faktur Pajak No. ' . $kirim['ekspedisi'] . '.pdf', 'I');
        //KODINGAN LAMA - END

		$this->load->config('ec');
		$this->load->library('sap_invoice');
		$this->load->library('M_pdf');

		$kirim['ekspedisi'] = $this->input->post('id');
		$kirim['company_code'] = $this->input->post('company');
		$kirim['vendor_name']=$this->session->userdata('VENDOR_NAME');
		$kirim['vendor_no']=$this->session->userdata('VENDOR_NO');
		$kirim['nation']=$this->db->select('VENDOR_TYPE')->from('VND_HEADER')->where('VENDOR_NO', $this->session->userdata('VENDOR_NO'))->get()->result_array(); 
		$company_data = $this->config->item('company_data');
		$kirim['company_data'] = $company_data[$company_code];
		$mpdf = new M_pdf();

		$no_eks =  $this->input->post('id');
		$vendor_id = $this->session->userdata('VENDOR_NO');
		$company_code = $this->input->post('company');

		$act=$this->sap_invoice->getFakturPajakCetak($no_eks, $vendor_id, $company_code);
		$kirim['sap'] = array();

        // echo "<pre>";print_r($act);die();

		for ($i=0; $i < count($act['output']) ; $i++) {
			if ($act['output'][$i]['KET'] == 'Diterima') {
				$status = 'APPROVED';

				$kirim3 = array(
					'COMPANY_CODE' => $act['output'][$i]['BUKRS'],
					'NO_EKSPEDISI' => $act['output'][$i]['EKSPNO'],
					'NO_FAKTUR' => $act['output'][$i]['XBLNR'],
					'NO_VENDOR' => $this->session->userdata('VENDOR_NO'),
					'NAMA_VENDOR' => $act['output'][$i]['NAME1'],
					'NPWP'=>$act['output'][$i]['STCD1'],
					'TGL_FAKTUR' => $act['output'][$i]['BLDAT'],
					'DPP'=> number_format($act['output'][$i]['HWBAS'],2,',','.'),
					'PPN'=> number_format($act['output'][$i]['HWSTE'],2,',','.'),  
					'EMAIL'=> $act['output'][$i]['EMAIL'],
					'NAMA'=> $act['output'][$i]['PERSON'],
					'TGL_TRIMA'=> date("d.m.Y", strtotime($act['output'][$i]['TGL_TRIMA'])),
					'STATUS' => $status,
				);
				array_push($kirim['sap'], $kirim3);
			} 
			else {
				$status = '';
			}
		}

        // echo json_encode(array('kirim'=>$kirim));die(); echo "<pre>";
        // echo "<pre>";print_r($kirim);die();

		$html = $this->load->view('EC_Vendor/faktur/cetak', $kirim, TRUE);
		$mpdf->pdf->writeHTML($html);
		$footer_rr = $this->load->view('EC_Vendor/faktur/footer', $kirim, TRUE);
		$mpdf->pdf->SetHTMLFooter($footer_rr);
		$mpdf->pdf->output('Ekspedisi Faktur Pajak No. ' . $kirim['ekspedisi'] . '.pdf', 'I');

	}



	public function ekspedisi($id = '') {
		$this->layout->set_table_js();
		$this->layout->set_table_cs();  
		$data['title'] = "Form Faktur Pajak";
		$this->layout->add_js('bootbox.js');
		$this->layout->add_js('pages/invoice/EC_common.js');
		$this->layout->add_js('jquery.priceFormat.min.js');
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
		$this->layout->add_js('pages/invoice/ec_vendor_faktur.js?1');      

		$data['urlAction'] = site_url('EC_Vendor/Faktur/ekspedisiFaktur/');

		$this->layout->render('faktur/form', $data);
	}      

	
	public function doInsertFp() {
        // print_r( $this->input->post());die;
		// error_reporting(E_ALL);
		$GAMBAR             = $_FILES['GAMBAR']['tmp_name'];
		$tes                = dirname(__FILE__);
		$pet_pat            = str_replace('application/modules/EC_Vendor/controllers', '', $tes);

		if (isset($_FILES) && !empty($_FILES['GAMBAR']['name'])) {
			$type = explode('.', $_FILES['GAMBAR']['name']);
			if(end($type)=="jpg" || end($type)=="jpeg" || end($type)=="png" || end($type)=="pdf" || end($type)=="PDF"){
				// $this->_myFile = "FP_". date('YmdHms').'_'. $_FILES['GAMBAR']['name'];
				$this->_myFile = "FP_". date('YmdHms').'_'.$this->session->userdata('VENDOR_NO').'.'. end($type);
				$this->_path = $pet_pat . 'upload/fp_ekspedisi/' . $this->_myFile;
				if (move_uploaded_file($GAMBAR, $this->_path)) {
					echo json_encode(array('success'=>true, 'pesan'=>'Faktur Pajak Berhasil Di Upload', 'gambar'=>$this->_myFile));
				} else {
					echo json_encode(array('success'=>false, 'pesan'=>'Faktur Pajak GAGAL Di Upload', 'gambar'=>''));
				}
			} else {
				echo json_encode(array('success'=>false, 'pesan'=>'File yang support hanya jpg, jpeg, png, pdf, doc, dan docx', 'gambar'=>''));
			}
		} else {
			echo json_encode(array('success'=>false, 'pesan'=>'Error', 'gambar'=>''));

		}
	}


	public function batalDocument() {
		// error_reporting(E_ALL);
		$this->load->config('ec');
		$this->load->library('sap_invoice');
		// echo "<pre>";
		// print_r($this->input->post());die;
		$company = $this->input->post('company');
		$ekspedisi =  $this->input->post('id');
		$fp = str_replace(".", "", $this->input->post('fp'));
		$fp = str_replace("-", "", $fp);
		$vn = $this->input->post('vn');

		$act=$this->sap_invoice->batalFakturPajak($company, $ekspedisi, $fp, $vn);
		// echo "<pre>";
		// print_r($act);die;
		if($act){
			if($act['pesan']['TYPE']==='S'){
				$pesan = '[SUCCESS] '.$act['pesan']['MESSAGE'];
				echo json_encode(array('success'=>true, 'pesan'=>$pesan));
			} else {
				$pesan = '[ERROR] '.$act['pesan']['MESSAGE'];
				echo json_encode(array('success'=>false, 'pesan'=>$pesan));
			}
		} else {
			$pesan = '[ERROR] '.$act['pesan']['MESSAGE'];
			echo json_encode(array('success'=>false, 'pesan'=>$pesan));
		}
	}

	public function tes1() {
		$this->load->library('sap_invoice');
		$this->load->config('ec');

		echo "print";
		$act = $this->sap_invoice->teskoneksi();
		echo "pre";
		print_r($act);die();

	}


	public function kirim_email_po($data_email){		
		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		
		// dev
		$this->email->to('tithe.j@sisi.id');  
		// dev

		// prod
  //   	$this->email->to($data_email['EMAIL_ADDRESS1']);
		// prod
		
		$this->email->subject("Permohonan Approve Ekspedisi ".$data_email['data']['NO_EKSPEDISI'].".");
		$content = $this->load->view('email/mohon_approve_pjk',$data_email['data'],TRUE);
		$this->email->message($content);
		$this->email->send();
	}

}

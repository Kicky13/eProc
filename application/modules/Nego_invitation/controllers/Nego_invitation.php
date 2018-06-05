<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Nego_invitation extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model(array(
			'prc_tender_vendor',
			'prc_tender_item',
			'prc_tender_quo_item',
			'prc_tender_nego_sech',
			'prc_tender_nego',
			'adm_employee',
			'prc_tender_nego_vendor_doc'
		));
	}

	function index() {
		$data['title'] = "Daftar Negosiasi";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/nego_invitation.js');
		$this->layout->render('invitation_list',$data);
	}

	function detail_invitation($ptv_id) {
		$ptv_id = url_decode($ptv_id);
		$this->load->model('prc_nego_detail');
		$data['title'] = "Nego Invitation Detail";
		$data['success'] = $this->session->flashdata('success') == 'success';
		$this->prc_tender_vendor->join_prc_tender_main();
		$this->prc_tender_vendor->join_prc_tender_prep();
		$invitations = $this->prc_tender_vendor->get(array("PTV_ID" => $ptv_id));
		$data['tender_invitation'] = $invitations[0];

		$this->prc_tender_nego->where_done(null);
		$ptm = $data['tender_invitation']['PTM_NUMBER'];
		$vendor_kode = $data['tender_invitation']['PTV_VENDOR_CODE'];
		$data['detail_nego'] = $this->prc_tender_nego->ptm($ptm);
		$nego_id = $data['detail_nego']['NEGO_ID'];
		$n_nego = $this->prc_nego_detail->get_count_nego($ptm,$vendor_kode);

		if(!empty($n_nego)){
		foreach ($n_nego as $value) {			
				$data['n_nego'][$value['TIT_ID']]=$value['N_NEGO'];
		}
		}
		$ptnv = $this->prc_tender_nego_vendor_doc->nego_ptm_vendor($nego_id,$ptm,$vendor_kode);		
		if(!empty($ptnv)){
			$data['ptnv_id'] = $ptnv[0]['PTNV_ID'];
			$data['FILE_UPLOAD'] = $ptnv[0]['FILE_UPLOAD'];			
			$server_dir = str_replace("\\", "/", FCPATH);	
			$upload_dir = UPLOAD_PATH."nego_file".DIRECTORY_SEPARATOR;	
		
			if(!file_exists($server_dir.$upload_dir.$data['FILE_UPLOAD'])){			
				$data['FILE_UPLOAD']="";
			}
		}
		$data['is_jasa']=$invitations[0]['IS_JASA'];	
		
		$prc_nego_detail = $this->prc_nego_detail->get(array('NEGO_ID'=>$nego_id,'VENDOR_NO'=>$this->session->userdata('VENDOR_NO')));
		foreach ($prc_nego_detail  as $nego_detail) {
			$data['harga_nego'][$nego_detail['TIT_ID']]=$nego_detail['HARGA'];
		}
		
		$this->prc_tender_quo_item->where_win();
		$this->prc_tender_quo_item->where_tit_status(1);
		$items = $this->prc_tender_quo_item->ptm_ptv($data['tender_invitation']['PTM_NUMBER'], $this->session->userdata('VENDOR_NO'));
		//echo $items; die;
		$data['negos'] = $this->prc_tender_nego_sech->ptm_ptv($data['tender_invitation']['PTM_NUMBER'], $this->session->userdata('VENDOR_NO'));

		$data['invitation_tender_items'] = $items;
		$data['iniptm']=$data['tender_invitation']['PTM_NUMBER'];
		//$this->layout->set_validate_css();
		$this->layout->set_table_js();
		$this->layout->add_js('pages/nego_invitation.js');
		$this->layout->add_js('pages/nego_invitation_detail.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->add_js('strTodatetime.js');
		$this->layout->render('invitation_detail',$data);
	}

	function get_invitation_list() {
		$this->prc_tender_vendor->join_prc_tender_main();
		$this->prc_tender_vendor->where_ptv_is_nego();
		$this->prc_tender_vendor->join_nego(false, array(1, 2));
		$invitations = $this->prc_tender_vendor->ptv($this->session->userdata('VENDOR_NO'));
		// var_dump($invitations); die();
		$ptv = array();
		$skrg=time();
		foreach ((array)$invitations as $val) {
			$val['ECT_PTV_ID'] = url_encode($val['PTV_ID']);
			if ($val['NEGO_END'] != '' && oraclestrtotime($val['NEGO_END']) >= oraclestrtotime('now')) {
				$negoend=oraclestrtotime($val['NEGO_END']);
				$val['NEGO_END'] = betteroracledate(oraclestrtotime($val['NEGO_END']));				
				if($negoend>$skrg){
					$val['STATUS'] = 'Negosiasi Sudah Dibuka';
				}else if($negoend<$skrg){
					$val['STATUS'] = 'Negosiasi Selesai';
				}				
				$ptv[$val['PTV_ID']] = $val;				 
			}
			else{
				$val['STATUS'] = 'Negosiasi Belum Dibuka';
			}
		}
		$retval = array();
		foreach ($ptv as $val) {
			$retval[] = $val;
		}
		echo json_encode(array('data' => $retval));
	}

	function do_update_tender_invitation($ptv_id) {
		//print_r($this->input->post()); exit();
		$this->load->model('prc_tender_nego_sech');
		$this->load->model('prc_tender_nego');
		$this->load->model('prc_nego_detail');
		$this->load->model('prc_nego_vendor');
		// $this->prc_tender_nego_sech->
		$ptv = $this->prc_tender_vendor->get(array('PTV_ID' => $ptv_id));
		$ptm_number = $ptv[0]['PTM_NUMBER'];
		$vendor_kode = $ptv[0]['PTV_VENDOR_CODE'];
		$ptn_id=$this->input->post('nego_id');		

		//checking time nego
		$negoend_time = $this->prc_tender_nego->id($ptn_id);
		$negoend_time = (oraclestrtotime($negoend_time['NEGO_END']));		
		if(strtotime(date('d-M-Y g.i.s A'))>$negoend_time){
			$this->session->set_flashdata('error', json_encode(array('Gagal Simpan Data, Waktu Negosiasi Telah Habis')));
			redirect('Nego_invitation/detail_invitation/' . url_encode($ptv_id));
			exit();
		}
		
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata('VENDOR_NO'),$this->session->userdata('VENDOR_NAME'),
				'VENDOR','Nego Invitation','Update',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		$nego = trim($this->input->post('nego'));
		
		$ptns['PTNS_ID'] = $this->prc_tender_nego_sech->get_id();
		$ptns['PTM_NUMBER'] = $ptm_number;
		$ptns['PTNS_NEGO_MESSAGE'] = $nego;
		$ptns['PTNS_CREATED_DATE'] = date('d-M-Y g.i.s A');
		$ptns['PTV_VENDOR_CODE'] = $ptv[0]['PTV_VENDOR_CODE'];
		$this->prc_tender_nego_sech->insert($ptns);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Negosiasi/save_bidding','prc_tender_nego_sech','insert',$ptns);
			//--END LOG DETAIL--//
		
		
		if(!empty($_FILES['file_negosiasi']['name'])){
			$this->load->library('encrypt');
			$server_dir = str_replace("\\", "/", FCPATH);		
			$upload_dir = UPLOAD_PATH."nego_file/";
			$this->load->library('file_operation');
			$this->file_operation->create_dir($upload_dir);
			$this->load->library('FileUpload');
			$uploader = new FileUpload('file_negosiasi');
			$ext = $uploader->getExtension(); // Get the extension of the uploaded file	
			$filename = $uploader->getFileName();	
			$filename = trim(addslashes($filename));		
			$filename = str_replace(' ', '_', $filename);
			$filename = preg_replace('/\s+/', '_', $filename);
			$new_ptnv_id = $this->prc_tender_nego_vendor_doc->get_id();			
			$uploader->newFileName = $filename;
			$file_exist=glob($server_dir.$upload_dir.$filename);
			if(count($file_exist)>0){
				foreach ($file_exist as $value) {
					unlink($value);
				}
			}
			$result = $uploader->handleUpload($server_dir.$upload_dir);
			if (!$result) {
				$this->session->set_flashdata('error', json_encode(array('msg'=>$uploader->getErrorMsg())));
				redirect('Nego_invitation/detail_invitation/'.url_encode($ptv_id));
			}

			$ptnvd = array(
						'PTNV_ID'=>$new_ptnv_id,
						'NEGO_ID'=>$ptn_id,
						'PTM_NUMBER'=>$ptm_number,
						'PTV_VENDOR_CODE'=>$vendor_kode,
						'FILE_UPLOAD'=>$filename
					);
			$this->prc_tender_nego_vendor_doc->insert($ptnvd);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Nego_invitation/do_update_tender_invitation','prc_tender_nego_vendor_doc','insert',$ptnvd);
				//--END LOG DETAIL--//
		}
		
		//*/

		/* Update Harga */
		
		foreach ($this->input->post('pqi') as $val) {
			$where['PQI_ID'] = $val['pqi'];
			$pqiobj = $this->prc_tender_quo_item->get($where);
			$pqiobj = $pqiobj[0];
			$valfinalprice = str_replace(',', '', $val['value']);

			$this->prc_tender_nego->where_done(0);
			$datanego = $this->prc_tender_nego->ptm($ptv[0]['PTM_NUMBER']); // ud dpt single

			$wherenegodetail['TIT_ID'] = $pqiobj['TIT_ID'];
			$wherenegodetail['NEGO_ID'] = $datanego['NEGO_ID'];
			$wherenegodetail['VENDOR_NO'] = $ptv[0]['PTV_VENDOR_CODE'];
			$negodetail = $this->prc_nego_detail->get($wherenegodetail);
			/* ngupdate cuma kalau berubah nilai aja */
			//if ($negodetail[0]['HARGA'] != $valfinalprice) {

				/* nganu detail nego */
				

				$setnegodetail['HARGA'] = $valfinalprice;
				$setnegodetail['CHANGED'] = 1;

				$this->prc_nego_detail->update($setnegodetail, $wherenegodetail);
					//--LOG DETAIL--//
				$setnegodetail2 = array_merge($setnegodetail, array('PTM_NUMBER'=>$ptv[0]['PTM_NUMBER']));
				$this->log_data->detail($LM_ID,'Nego_invitation/do_update_tender_invitation','prc_nego_detail','update',$setnegodetail2,$wherenegodetail);
					//--END LOG DETAIL--//
			//}
		}
		//*/

		// exit();
		$this->session->set_flashdata('success', 'success');
		redirect('Nego_invitation/detail_invitation/' . url_encode($ptv_id));
	}

	public function download_file($ptnv_id = null, $vendorKode = null){
		$this->load->helper('file');
		$this->load->model('prc_tender_nego');
		if($vendorKode != null){
			$ptnv = $this->prc_tender_nego_vendor_doc->get(array('PTNV_ID'=>$ptnv_id,'PTV_VENDOR_CODE'=>$vendorKode));
		}else{
			$ptnv = $this->prc_tender_nego_vendor_doc->get(array('PTNV_ID'=>$ptnv_id,'PTV_VENDOR_CODE'=>$this->session->userdata('VENDOR_NO')));
		}
		if(!empty($ptnv)){
			$filename = $ptnv[0]['FILE_UPLOAD'];		
			$image_path = base_url(UPLOAD_PATH).'/nego_file/'.$filename;			
			$server_dir = str_replace("\\", "/", FCPATH);

			$url = str_replace("int-","", base_url());
			if (strpos($url, 'semenindonesia.com') !== false) { //server production
				$user_id=url_encode($this->session->userdata['ID']);
				if(empty($filename)){
					die('tidak ada attachment.');
				}
				$url = str_replace("http","https", $url);
				redirect($url.'View_document_vendor/viewDok_nego/'.$filename.'/'.$user_id);

			}else{	// server development
				if(empty($ptnv_id) || !file_exists($server_dir.'upload/nego_file/'.$filename)){
					die('file tidak ditemukan');
				}
			}
		}else{
			die('Tidak punya hak akses');
		}
		$this->output->set_content_type(get_mime_by_extension($image_path));
		$this->output->set_header('Content-Disposition: inline; filename="'.$filename.'";');
		return $this->output->set_output(file_get_contents($image_path));

	}

	public function delete_file(){
		$ptnv_id = $this->input->post('ptnv_id');
		$this->load->helper('file');
		$this->load->model('prc_tender_nego');
		$ptnv = $this->prc_tender_nego_vendor_doc->get(array('PTNV_ID'=>$ptnv_id));
		$filename = $ptnv[0]['FILE_UPLOAD'];	
		$image_path = base_url(UPLOAD_PATH).'/nego_file/'.$filename;			
		$server_dir = str_replace("\\", "/", FCPATH);		
		if(empty($ptnv_id) || !file_exists($server_dir.'upload/nego_file/'.$filename)){
			$msg = 'file tidak ditemukan';
			$sts = false;
		}else{
			// if(unlink($server_dir.'upload/nego_file/'.$filename)){			
				$ptnv = $this->prc_tender_nego_vendor_doc->delete(array('PTNV_ID'=>$ptnv_id));
				$msg = "file sudah terhapus";
				$sts = true;
			// }else{
			// 	$msg = "file gagal terhapus";
			// 	$sts = false;
			// }
		}
		echo json_encode(array('msg'=>$msg,'sts'=>$sts));
	}

	public function cek_toleransi($tit_id, $harga) {
		$harga = str_replace(',', '', $harga);
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_prep');
		$item = $this->prc_tender_item->get(array('TIT_ID' => $tit_id));
		$item = $item[0];
		$ptp = $this->prc_tender_prep->ptm($item['PTM_NUMBER']);
		
		if ($ptp['PTP_WARNING_ORI'] == 1) {
			echo json_encode(array('status' => true));
		} else if ($ptp['PTP_WARNING_ORI'] >= 2) {
			if (intval($harga) > intval($item['TIT_PRICE'] * (100 + intval($ptp['PTP_BATAS_NEGO'])) / 100)) {
				$data['atas'] = 'atas';
				$data['status'] = false;
			} else {
				$data['atas'] = '';
				$data['status'] = true;
			}
			$data['warning'] = $ptp['PTP_WARNING_ORI'] == 2 ? 'warning' : 'error';
			echo json_encode($data);
		}
	}
	
	public function cek_toleransi_ub() {
		$this->load->model('prc_tender_prep');
		$this->load->model('m_tambahan_ub');
		$ub=$this->input->post();
		$ptp = $this->prc_tender_prep->ptm($ub['iniptm']);
		$ptp_warning=$ptp['PTP_WARNING_NEGO_ORI'];
		$ptp_batas_nego=$ptp['PTP_BATAS_NEGO'];
		$ptp_is_itemis=$ptp['PTP_IS_ITEMIZE'];
		$totalharga_ece=0;
		
		if($ptp_is_itemis==1)//itemise
		{
			foreach ($this->input->post('pqi') as $val) {
				if($ub['nego_done']==0){
					$nilai_awal_ub=intval($val['pen']);
					}else{
						$nilai_awal_ub=intval($val['lm']);
						}
				
				$valfinalprice = intval(str_replace(',', '', $val['value']));
				$item = $this->prc_tender_item->get(array('TIT_ID' => $val['tit']));
				$item = $item[0];
				$nilai_batas_ece= intval($item['TIT_PRICE'])  + ($ptp_batas_nego/100 * intval($item['TIT_PRICE']));
				
				if($valfinalprice>$nilai_awal_ub){
					if($ub['nego_done']==0){
						echo json_encode(array('id'=>$val['idku'],'st'=>'0','jns'=>4,'msg'=>'Harga Yang Dimasukkan Melebihi<br>Harga Penawaran','isitemis'=>$ptp_is_itemis));
						die();
					}else{
						echo json_encode(array('id'=>$val['idku'],'st'=>'0','jns'=>4,'msg'=>'Harga Yang Dimasukkan Melebihi<br>Harga Nego Sebelumnya','isitemis'=>$ptp_is_itemis));
						die();
						}
					}
				
				if($valfinalprice>$nilai_batas_ece){
					//if($val['lm']=='')
					
					if($ptp_warning==2){
						echo json_encode(array('id'=>$val['idku'],'st'=>'0','jns'=>2,'msg'=>'Harga Yang Dimasukkan Melebihi<br>Toleransi Harga Kami','isitemis'=>$ptp_is_itemis,'nilai_batas_ece'=>$nilai_batas_ece,'tit_price'=>$item['TIT_PRICE'],'ptp_batas_nego'=>$ptp_batas_nego));
						die();
					}else if($ptp_warning==3){
						echo json_encode(array('id'=>$val['idku'],'st'=>'0','jns'=>3,'msg'=>'Harga Yang Dimasukkan Melebihi Toleransi Harga Kami<br>Data Tidak Bisa Disimpan !!!','isitemis'=>$ptp_is_itemis));
						die();
					}
				}
				
			
			}
			echo json_encode(array('id'=>$val['idku'],'st'=>'1','jns'=>$ptp_warning,'msg'=>'','isitemis'=>$ptp_is_itemis));
			die();
		}else{//paket
				
				$totalharga_ece=$this->m_tambahan_ub->total_ece_paket($ub['iniptm']);
				$totalharga_ece=$totalharga_ece[0]['JUMLAH_ECE'];
				
				$nilai_batas_ece= $totalharga_ece  + ($ptp_batas_nego/100 * $totalharga_ece);
				$valfinalprice=0;
				foreach ($this->input->post('pqi') as $val) {
				$valfinalprice += intval(str_replace(',', '', $val['value']));
					//echo $valfinalprice ." - ".$nilai_batas_ece;
					if($valfinalprice>$nilai_batas_ece){
						if($ptp_warning==2){
							echo json_encode(array('id'=>$val['idku'],'st'=>'0','jns'=>2,'msg'=>'Harga Yang Dimasukkan Melebihi<br>Toleransi Harga Kami','isitemis'=>$ptp_is_itemis));
							die();
						}else if($ptp_warning==3){
							echo json_encode(array('id'=>$val['idku'],'st'=>'0','jns'=>3,'msg'=>'Harga Yang Dimasukkan Melebihi Toleransi Harga Kami<br>Data Tidak Bisa Disimpan !!!','isitemis'=>$ptp_is_itemis));
							die();
						}
					}
					
				
				}
				echo json_encode(array('id'=>$val['idku'],'st'=>'1','jns'=>$ptp_warning,'msg'=>'','isitemis'=>$ptp_is_itemis));
				die();
			}
			
			
		
	}

}
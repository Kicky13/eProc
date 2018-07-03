<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tahap_negosiasi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('procurement_job');
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->load->library("file_operation");
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
		$this->load->library('comment');
	}

	public function index($id) {
		$this->procurement_job->check_authorization();
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('app_process_master');
		$this->load->model('adm_dept');
		$this->load->library('snippet');
		$data['success'] = $this->session->flashdata('success') == 'success';

		$data['title'] = 'Tahap Negosiasi';
		$data['ptm_number'] = $id;

		$this->load->model('v_log_main');
		$data['v_log_main'] = $this->v_log_main->get(array('PTM_NUMBER'=>$id));
		$data['detail'] = array();
		foreach ($data['v_log_main'] as $val) {
			$dtl = $this->log_detail->get(array('LM_ID'=>$val['LM_ID']));
			$data['detail'][$val['LM_ID']] = $dtl;
		}

		$this->prc_tender_quo_main->join_eval();
		$this->prc_tender_quo_main->join_pqe();
		$data['vendor_data'] = $this->prc_tender_quo_main->get_join(array('PRC_TENDER_QUO_MAIN.PTM_NUMBER' => $id));

		$data['status'] = $this->prc_tender_item->get_tit_status();
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);		
		$data['detail_ptm_snip'] = $this->snippet->detail_ptm($id, false);
		$data['vendor_ptm'] = $this->snippet->vendor_ptm($id, true, true);
		$data['pesan'] = $this->snippet->view_history_chat($id);
		
		$ptp = $this->prc_tender_prep->ptm($id);		
		if($ptp['PTP_IS_ITEMIZE']==1){
			$data['evaluasi'] = $this->snippet->evaluasi($id, false, true, false, false, false, true,false,false,'vendor_per_item');
		}else{
			$data['evaluasi'] = $this->snippet->evaluasi($id, false, true, false, false, false, true,false,false,'item_per_vendor');
		}
		
		$po = $this->prc_tender_item->ptm($id);
		$data['tit_po'] = $this->load->view('panel_po', $po, true);

		// var_dump($data['status']); exit();
		$this->layout->add_js('pages/tahap_negosiasi.js');		
		$this->layout->set_table_js();
		$this->layout->set_table_cs();			
		$this->layout->render('tahap_negosiasi', $data);
	}

	public function save_bidding() {
		error_reporting(E_ALL);
		$id = $this->input->post('ptm_number');
		$this->load->library('process');
		$this->load->model('adm_employee');
		$this->load->model('adm_employee_atasan');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_purchase_requisition');

		$next_process =	$this->input->post('next_process');
		if ($next_process == 0) {
			redirect('Tender_cleaner/retender/' . $id .'/'.$this->input->post('process_name'));
		}
		if ($next_process == '999') { //BATAL
			redirect('Proc_verify_entry/batal/' . $id .'/'.$this->input->post('process_name').'/Tahap_negosiasi/index');
		}
		$gagal = true;
		foreach ($this->input->post('metode') as $key => $value) {
			if(!empty($value)){
				$gagal = false;
			}
		}
		if($gagal){
			if(!$this->input->post('lanjut') && $next_process=1){
				$this->session->set_flashdata('error', 'Metode Negosiasi tidak boleh kosong.');
				redirect('Tahap_negosiasi/index/' . $id);
			}
		}

		$comment_id = $this->comment->get_new_id(); 
		$dataComment = array(
			"PTC_ID" => $comment_id,
			"PTM_NUMBER" => $id,
			"PTC_COMMENT" => "'".str_replace("'", "''", $this->input->post('ptc_comment'))."'",
			"PTC_POSITION" => "'".$this->authorization->getCurrentRole()."'",
			"PTC_NAME" => "'".str_replace("'", "''", $this->authorization->getCurrentName())."'",
			"PTC_ACTIVITY" => "'Tahap Negosiasi'",
			);
		$this->comment->insert_comment_tender($dataComment);		

			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Tahap Negosiasi','OK',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Tahap_negosiasi/save_bidding','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		$with_apv=false;
		$tit_note = $this->input->post('tit_note');
		$ece_assign = $this->input->post('ece_assign');
		foreach ($this->input->post('metode') as $key => $value) {
			if ($value != '') {
				$where = array('TIT_ID' => $key);
				$set['TIT_STATUS']=$value;
				if(!empty($tit_note[$key])){
					$set['TIT_NOTE']=$tit_note[$key];
					// $set['PPR_ASSIGNEE']=$ece_assign[$key];
				}
				$this->prc_tender_item->update($set, $where);

				$this->prc_tender_item->join_pr();
				$this->prc_tender_item->where_in('TIT_ID',$where);
				$ambil = $this->prc_tender_item->get(array('PRC_TENDER_ITEM.PTM_NUMBER' => $id));
				$no_pr = $ambil[0]['PPI_PRNO'];
				$where1['PPR_PRNO'] = $no_pr;
				$set1['ECE_ASSIGN'] = $ece_assign;

				$this->prc_purchase_requisition->update($set1, $where1);
				// echo "<pre>";die;
				// echo $this->db->last_query();die;
				// print_r($ambil);die;
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Tahap_negosiasi/save_bidding','prc_tender_item','update',$set,$where);
					//--END LOG DETAIL--//
				if($value==6){
					$with_apv=$with_apv||false;
				}else{
					$with_apv=$with_apv||true;
				}
			}

		}

		/*Negosiasi*/
		$postvendornego = $this->input->post('vendor_ikut_nego');
		if (is_array($postvendornego)) {
			foreach ($postvendornego as $key => $v) {				
				$set_PTV['PTV_IS_NEGO'] = 1;
				$where_PTV['PTV_VENDOR_CODE'] = $key;
				$where_PTV['PTM_NUMBER'] = $id;
				$this->prc_tender_vendor->update($set_PTV, $where_PTV);
					//--LOG DETAIL--//
				$st_ptv = array_merge($set_PTV, array('TIT_ID'=>$v));
				$this->log_data->detail($LM_ID,'Tahap_negosiasi/save_bidding','prc_tender_vendor','update',$st_ptv,$where_PTV);
					//--END LOG DETAIL--//
			}
		}

		/*Auction*/
		$postvendorauction = $this->input->post('vendor_ikut_auction');
		$postvendoritem = $this->input->post('vendor_item');

		if (is_array($postvendorauction)) {
			foreach ($postvendorauction as $no_vendor => $items) {			
				foreach ($items as $key => $item) {
					foreach ($postvendoritem[$no_vendor] as $k => $v) {
						if($v==$item){
							$PQM=$this->prc_tender_quo_main->ptmptv($id,$no_vendor);
							$PQM=$PQM[0];
							/*update PQI_IS_WINNER menjadi 1 untuk menandakan bahwa vendor pada item tsb tetap lolos dan ikut auction*/
							$set_pqi['PQI_IS_WINNER'] = 1;
							$where_pqi['PQM_ID']=$PQM['PQM_ID'];
							$where_pqi['TIT_ID']=$v;
							$this->prc_tender_quo_item->update($set_pqi, $where_pqi);
								//--LOG DETAIL--//
							$st_pqi = array_merge($set_pqi, array('PTV_VENDOR_CODE'=>$no_vendor));
							$this->log_data->detail($LM_ID,'Tahap_negosiasi/save_bidding','prc_tender_quo_item','update',$st_pqi,$where_pqi);
								//--END LOG DETAIL--//
							unset($postvendoritem[$no_vendor][$k]);
						}
					}					
				}
			}
			foreach ($postvendoritem as $noven => $valu) {				
				foreach ($valu as $val) {
					if(isset($val)){
						$pqm=$this->prc_tender_quo_main->ptmptv($id,$noven);
						$pqm=$pqm[0];
						/*update PQI_IS_WINNER menjadi -2 untuk menandakan bahwa vendor pada item tsb gagal ikut auction*/
						$set_PQI['PQI_IS_WINNER'] = -2;
						$where_PQI['PQM_ID']=$pqm['PQM_ID'];
						$where_PQI['TIT_ID']=$val;
						$this->prc_tender_quo_item->update($set_PQI, $where_PQI);
							//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Tahap_negosiasi/save_bidding','prc_tender_quo_item','update',$set_PQI,$where_PQI);
							//--END LOG DETAIL--//
					}
				}
				
			}
		}

		// penunjukan pemenang langsung untuk RO
		$this->penunjukan_pemenang_untuk_ro($id, $LM_ID);

		/* Approval Negosiasi */
		// $emp = $this->adm_employee->get(array('ID' => $this->authorization->getEmployeeId()));
		// $nopeg = $emp[0]['NO_PEG'];

		// $atasan = $this->adm_employee_atasan->get(array('MK_NOPEG' => $nopeg));
		// $level = $atasan[0]['ATASAN1_LEVEL']; // get level atasan

		$ans = $this->adm_employee->atasan($this->authorization->getEmployeeId());
		$id_atasan = $ans[0]['ID']; // get atasan
		$nama_atasan = $ans[0]['FULLNAME']; // get atasan
		//*/
		if($with_apv){
			// $this->process->next_process_user($id, 'NEXT', $id_atasan, $LM_ID);
			$this->process->next_process($id, 'NEXT', $id_atasan, $LM_ID);
		}
		$this->session->set_flashdata('success', 'success'); 
		redirect('Job_list');
	}

	public function approval($id) {
		$this->procurement_job->check_authorization();
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('app_process_master');
		$this->load->model('adm_dept');
		$this->load->library('snippet');
		$data['success'] = $this->session->flashdata('success') == 'success';

		$data['title'] = 'Approval Tahap Negosiasi';
		$data['ptm_number'] = $id;

		$this->prc_tender_quo_main->join_eval();
		$this->prc_tender_quo_main->join_pqe();
		$data['vendor_data'] = $this->prc_tender_quo_main->get_join(array('PRC_TENDER_QUO_MAIN.PTM_NUMBER' => $id));


		$data['status'] = $this->prc_tender_item->get_tit_status();
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);		
		$data['detail_ptm_snip'] = $this->snippet->detail_ptm($id, false);
		$data['vendor_ptm'] = $this->snippet->vendor_ptm($id, true, true);

		$ptp = $this->prc_tender_prep->ptm($id);	
		if($ptp['PTP_IS_ITEMIZE']==1){
			$data['evaluasi'] = $this->snippet->evaluasi($id, false, true, false, false, false, true,false,false,'vendor_per_item');
		}else{
			$data['evaluasi'] = $this->snippet->evaluasi($id, false, true, false, false, false, true,false,false,'item_per_vendor');
		}

		$po = $this->prc_tender_item->ptm($id);
		$data['tit_po'] = $this->load->view('panel_po', $po, true);

		// var_dump($data); exit();
		$this->layout->add_js('pages/tahap_negosiasi.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();			
		$this->layout->render('approval_negosiasi', $data);
	}

	public function save_approval() {
		// var_dump($this->input->post()); exit();
		$id = $this->input->post('ptm_number');

		$this->load->model('adm_employee');
		$this->load->model('adm_employee_atasan');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_nego');		
		$this->load->model('prc_nego_detail');		
		$this->load->library('process');

		$next_process = $this->input->post('next_process');
		$process_name = $this->input->post('process_name');
		$id_process = $this->back_current_process($id);

		$comment_id = $this->comment->get_new_id(); 
		$dataComment = array(
			"PTC_ID" => $comment_id,
			"PTM_NUMBER" => $id,
			"PTC_COMMENT" => '\''.$this->input->post('ptc_comment').'\'',
			"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
			"PTC_NAME" => '\''.$this->authorization->getCurrentName().'\'',
			"PTC_ACTIVITY" => '\''.$process_name.'\'',
			);
		$this->comment->insert_comment_tender($dataComment);
			//--LOG MAIN--//
		$action = 'APPROVE';
		if ($next_process == 0) {
			$action = 'REJECT';
		}
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),$process_name,$action,$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Tahap_negosiasi/save_approval','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		if ($next_process== 0) {// reject
			$postvendornego = $this->input->post('ikut_nego');
			if (is_array($postvendornego)) {
				foreach ($postvendornego as $key => $v) {				
					$set_PTV['PTV_IS_NEGO'] = 0;
					$where_PTV['PTV_VENDOR_CODE'] = $v;
					$where_PTV['PTM_NUMBER'] = $id;
					$this->prc_tender_vendor->update($set_PTV, $where_PTV);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Tahap_negosiasi/save_approval','prc_tender_vendor','update',$set_PTV,$where_PTV);
						//--END LOG DETAIL--//
				}
			}

			$item = $this->input->post('item');
			$item_status = $this->input->post('item_status');
			if(isset($item)){
				foreach ($item as $tit) {
					if($item_status[$tit]>10){
						$ptn = $this->prc_tender_nego->get(array('PTM_NUMBER'=>$id,'NEGO_DONE'=>1));//cek sudah pernah nego
						if(count($ptn)>0){
							$pnd = $this->prc_nego_detail->get(array('NEGO_ID'=>$ptn[0]['NEGO_ID']),array('TIT_ID'=>$tit));
							if(count($pnd)>0){
								$this->prc_tender_item->update(array('TIT_STATUS'=>'5'),array('TIT_ID'=>$tit));// item di set status sudah nego								
									//--LOG DETAIL--//
								$this->log_data->detail($LM_ID,'Tahap_negosiasi/save_approval','prc_tender_item','update',array('TIT_STATUS'=>'5'),array('TIT_ID'=>$tit));
									//--END LOG DETAIL--//
							}else{
								$this->prc_tender_item->update(array('TIT_STATUS'=>'0'),array('TIT_ID'=>$tit));// item di set status belum nego
									//--LOG DETAIL--//
								$this->log_data->detail($LM_ID,'Tahap_negosiasi/save_approval','prc_tender_item','update',array('TIT_STATUS'=>'0'),array('TIT_ID'=>$tit));
									//--END LOG DETAIL--//
							}				
						}else{
							$this->prc_tender_item->update(array('TIT_STATUS'=>'0'),array('TIT_ID'=>$tit));// item di set status belum nego
								//--LOG DETAIL--//
							$this->log_data->detail($LM_ID,'Tahap_negosiasi/save_approval','prc_tender_item','update',array('TIT_STATUS'=>'0'),array('TIT_ID'=>$tit));
								//--END LOG DETAIL--//
						}

						if($item_status[$tit]==48){
							$PQM=$this->prc_tender_quo_main->ptm($id);
							foreach ($PQM as $value_pqm) {
								/*mengembalikan PQI_IS_WINNER menjadi 1 agar vendor pada item tsb bisa dipilih lagi pada tahap negosiasi*/
								$set_pqi['PQI_IS_WINNER'] = 1;
								$where_pqi['PQM_ID']=$value_pqm['PQM_ID'];
								$where_pqi['TIT_ID']=$tit;
								$where_pqi['PQI_IS_WINNER']=-2;								
								$this->prc_tender_quo_item->update($set_pqi, $where_pqi);
									//--LOG DETAIL--//
								$this->log_data->detail($LM_ID,'Tahap_negosiasi/save_approval','prc_tender_quo_item','update',$set_pqi, $where_pqi);
									//--END LOG DETAIL--//		
							}
							
						}
						
					}
				}
			}
			$this->process->next_process_assignment($id, 'CURRENT', $LM_ID, $id_process);
			$this->session->set_flashdata('success', 'success'); 
			redirect('Job_list');
		} else {// ACC
			/* Approval Negosiasi */
			$emp = $this->adm_employee->get(array('ID' => $this->authorization->getEmployeeId()));
			$nopeg = $emp[0]['NO_PEG'];

			$atasan = $this->adm_employee_atasan->get(array('MK_NOPEG' => $nopeg));
			$level = $atasan[0]['ATASAN1_LEVEL']; // get level atasan

			$ans = $this->adm_employee->atasan($this->authorization->getEmployeeId());
			$id_atasan = $ans[0]['ID']; // get atasan
			$nama_atasan = $ans[0]['FULLNAME']; // get atasan

			if ($level == 'DEPT' || $level == 'REPT') {
				// statusnya where status in, semuanya statusnya dibagi 16
				$this->accept_pilih_status_item($id, $LM_ID);				

				// prosesnya kembali , ke assignment
				$this->process->next_process_assignment($id, 'CURRENT', $LM_ID, $id_process);
			} else {
				// kasihkan process holdernya ke orang yg didapet ini. trus kabur seaman amannya
				// $this->process->next_process_user($id, 'CURRENT', $id_atasan, $LM_ID);
				$this->process->next_process($id, 'NEXT', $id_atasan, $LM_ID);
			}
			//*/
		}
		$this->session->set_flashdata('success', 'success'); 
		redirect('Job_list');
	}

	public function back_current_process($id){
		$this->load->model('prc_tender_main');
		$this->load->model('app_process');

		$ptm = $this->prc_tender_main->ptm($id);
		$ptm = $ptm[0];
		$where = array(
			'KEL_PLANT_PRO'=>$ptm['KEL_PLANT_PRO'],
			'TIPE_SAMPUL'=>$ptm['SAMPUL'],
			'JUSTIFICATION'=>$ptm['JUSTIFICATION'],
			'PROCESS_MASTER_ID'=>'Tahap_negosiasi/index',
			);
		$ap = $this->app_process->get($where);
		return $ap[0]['CURRENT_PROCESS'];
	}

	public function accept_pilih_status_item($id, $LM_ID) {
		$this->load->model('prc_tender_item');
		$this->load->model('prc_ece_change');

		// ngambil item item yang masih terpilih metode nego (belom di ACC)
		$this->prc_tender_item->where_status_in();
		$this->prc_tender_item->join_pr();
		$items = (array) $this->prc_tender_item->ptm($id);

		$nego = array();
		$ec_id_group = $this->prc_ece_change->get_id_group();
		foreach ($items as $tit) {
			$status = intval($tit['TIT_STATUS']);
			if ($status == 16) {
				$nego[] = $tit['TIT_ID'];
			}
			$stts = $status/16;
			if($status>10){
				$titset = array('TIT_STATUS' => $stts);
				$titwhere = array('TIT_ID' => $tit['TIT_ID']);
				$this->prc_tender_item->update($titset, $titwhere);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Tahap_negosiasi/accept_pilih_status_item','prc_tender_item','update',$titset, $titwhere);
					//--END LOG DETAIL--//
			}

			if($stts == 7){ //analisa kewajaran harga
				$id_ece = $this->prc_ece_change->get_id();
				$data = array(
					'EC_ID' => $id_ece,
					'PTM_NUMBER' => $id,
					'TIT_ID' => $tit['TIT_ID'],
					'PRICE_BEFORE' => $tit['TIT_PRICE'],
					'CREATED_AT' => date(timeformat()),
					'STATUS_APPROVAL' => 0,
					'PPR_ASSIGNEE' => $tit['ECE_ASSIGN'],
					'EC_ID_GROUP' => $ec_id_group,
					);
				$this->prc_ece_change->insert($data);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Tahap_negosiasi/accept_pilih_status_item','prc_ece_change','insert',$data);
					//--END LOG DETAIL--//
			}
			
		}
		
		if (!empty($nego)) { // jika ada yg negosiasi
			$this->load->model('prc_nego_detail');
			$this->load->model('prc_nego_item');
			$this->load->model('prc_nego_vendor');
			$this->load->model('prc_tender_nego');
			$this->load->model('prc_tender_quo_item');

			$newnego['PTM_NUMBER'] = $id;
			$newnego['NEGO_ID'] = $this->prc_tender_nego->get_id();
			$newnego['APPROVED_AT'] = date(timeformat());
			$this->prc_tender_nego->insert($newnego);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Tahap_negosiasi/accept_pilih_status_item','prc_tender_nego','insert',$newnego);
				//--END LOG DETAIL--//
			unset($newnego['APPROVED_AT']);

			foreach ($nego as $val) {
				$this->prc_tender_quo_item->join_pqm();
				$this->prc_tender_quo_item->where_win(true);
				$this->prc_tender_quo_item->where_tit($val);
				$ptqi = $this->prc_tender_quo_item->get();
				
				foreach ($ptqi as $var) {
					$newpnv = $newnego;
					$newpnv['PTV_VENDOR_CODE'] = $var['PTV_VENDOR_CODE'];
					$newpnv['NV_ID'] = $this->prc_nego_vendor->get_id();
					$this->prc_nego_vendor->insert($newpnv);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Tahap_negosiasi/accept_pilih_status_item','prc_nego_vendor','insert',$newpnv);
						//--END LOG DETAIL--//
				}
				$newpni = $newnego;
				$newpni['TIT_ID'] = $val;
				$newpni['NI_ID'] = $this->prc_nego_item->get_id();
				$this->prc_nego_item->insert($newpni);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Tahap_negosiasi/accept_pilih_status_item','prc_nego_item','insert',$newpni);
					//--END LOG DETAIL--//
			}

			// $this->prc_tender_nego->where_done(0);
			// $data['nego'] = $this->prc_tender_nego->ptm($id);

			$this->prc_tender_quo_item->join_pqm();
			$ptqi = $this->prc_tender_quo_item->get_by_ptm($id);
			// var_dump($ptqi); exit();
			foreach ($ptqi as $val) {
				$newnego['VENDOR_NO'] = $val['PTV_VENDOR_CODE'];
				$newnego['TIT_ID'] = $val['TIT_ID'];
				$newnego['HARGA'] = intval($val['PQI_FINAL_PRICE']) == 0 ? $val['PQI_PRICE'] : $val['PQI_FINAL_PRICE'];
				$newnego['MY_ID'] = $this->prc_nego_detail->get_id();
				$this->prc_nego_detail->insert($newnego);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Tahap_negosiasi/accept_pilih_status_item','prc_nego_detail','insert',$newnego);
					//--END LOG DETAIL--//
			}
			// echo 'masuk';
		}
		// exit();
	}

	public function penunjukan_pemenang_untuk_ro($id, $LM_ID){
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_prep');

		$ptp = $this->prc_tender_prep->ptm($id);
		if($ptp['PTP_JUSTIFICATION_ORI']==5){
			$this->prc_tender_item->where_status(6);// pilih item yang ditunjuk pemenang
			$items = (array) $this->prc_tender_item->ptm($id);
			foreach ($items as $tit) {
				$this->prc_tender_quo_item->join_pqm();
				$this->prc_tender_quo_item->where_tit($tit['TIT_ID']);
				$ptqi = $this->prc_tender_quo_item->get_by_ptm($id);
				foreach ($ptqi as $var) {					
					$pqm = $this->prc_tender_quo_main->ptmptv($id,$var['PTV_VENDOR_CODE']);
					$pqm_id = $pqm[0]['PQM_ID'];
					$where_quo['PQM_ID'] = $pqm_id;
					$where_quo['PRC_TENDER_QUO_ITEM.TIT_ID'] = intval($tit['TIT_ID']);
					if($var['PQI_FINAL_PRICE']==0){
						$set_final_price['PQI_FINAL_PRICE'] = $var['PQI_PRICE'];	
					} else {
						$set_final_price['PQI_FINAL_PRICE'] = $var['PQI_FINAL_PRICE'];
					}
					$this->prc_tender_quo_item->update($set_final_price,$where_quo);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Tahap_negosiasi/penunjukan_pemenang_untuk_ro','prc_tender_quo_item','update',$set_final_price,$where_quo);
						//--END LOG DETAIL--//
				}	
			}
		}
	}

	public function get_rekap(){

		$id = $this->input->post('ptm_number');
		$nego_tit_id = $this->input->post('nego_tit_id');
		$auction_tit_id = $this->input->post('auction_tit_id');
		$title = $this->input->post('title');
		$ece_tit_id = $this->input->post('ece_tit_id');
		if(count($nego_tit_id)>0){//diusulkan nego
			$this->get_rekap_nego($id,$nego_tit_id,$title);
		}
		if(count($auction_tit_id)>0){//diusulkan auction
			$this->get_rekap_auction($id,$auction_tit_id,$title);
		}
		if(count($ece_tit_id)>0){//diusulkan auction
			$this->get_analisa_kewajaran($id,$ece_tit_id,$title);
		}
	}

	public function get_rekap_nego($id,$tit_id,$title){
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_quo_item');

		$where = array('PRC_TENDER_ITEM.PTM_NUMBER' => $id);	
		
		$this->prc_tender_item->where_in('TIT_ID',$tit_id);
		if($title=='Tahap Negosiasi'){
			$this->prc_tender_item->where_in('TIT_STATUS',array(0,5));			
		}
		else if($title=='Approval Tahap Negosiasi'){
			$this->prc_tender_item->where_in('TIT_STATUS',array(16));
		}

		$data['titems'] = $this->prc_tender_item->get($where);

		$data['ptp'] = $this->prc_tender_prep->ptm($id);
		
		$data['title'] = $title;
		
		$this->prc_tender_quo_item->where_win();			
		$this->prc_tender_quo_item->join_pqm();
		$ptquoitem = $this->prc_tender_quo_item->get_by_ptm($id);
		// die(var_dump($ptquoitem));
		$data['ptquoitem'] = array();
		$data['vendors'] = array();
		foreach ((array)$ptquoitem as $val) {			
			$data['ptquoitem'][$val['TIT_ID']][$val['PTV_VENDOR_CODE']] = $val;
			
			$this->prc_tender_vendor->where_active();
			$this->prc_tender_vendor->where_ptv($val['PTV_VENDOR_CODE']);
			$vendorss = $this->prc_tender_vendor->ptm($id);
			foreach ((array) $vendorss as $ptv) {
				$data['vendors'][$val['PTV_VENDOR_CODE']] = $ptv;			
			}
		}	
		// var_dump($data['ptquoitem']);  
		$data = $this->load->view('rekap_nego', $data, FALSE);
		
		echo $data;

		
	}

	public function get_rekap_auction($id,$tit_id,$title){
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_quo_item');

		$where = array('PRC_TENDER_ITEM.PTM_NUMBER' => $id);	
		
		$this->prc_tender_item->where_in('TIT_ID',$tit_id);
		if($title=='Tahap Negosiasi'){
			$this->prc_tender_item->where_in('TIT_STATUS',array(0,5));
		}
		else if($title=='Approval Tahap Negosiasi'){
			$this->prc_tender_item->where_in('TIT_STATUS',array(48));
		}
		
		$data['titems'] = $this->prc_tender_item->get($where);

		$data['ptp'] = $this->prc_tender_prep->ptm($id);
		
		$data['title'] = $title;
		
		$this->prc_tender_quo_item->where_in('PRC_TENDER_QUO_ITEM.PQI_IS_WINNER',array(1,-2));		
		$this->prc_tender_quo_item->join_pqm();
		$ptquoitem = $this->prc_tender_quo_item->get_by_ptm($id);
		$data['ptquoitem'] = array();
		$data['vendors'] = array();
		foreach ((array)$ptquoitem as $val) {			
			$data['ptquoitem'][$val['TIT_ID']][$val['PTV_VENDOR_CODE']] = $val;
			$data['pqi_auction'][$val['PTV_VENDOR_CODE']] = $val;

			$this->prc_tender_vendor->where_active();
			$this->prc_tender_vendor->where_ptv($val['PTV_VENDOR_CODE']);
			$vendorss = $this->prc_tender_vendor->ptm($id);
			foreach ((array) $vendorss as $ptv) {
				$data['vendors'][$val['PTV_VENDOR_CODE']] = $ptv;			
			}
		}	
		$data = $this->load->view('rekap_auction', $data, FALSE);
		echo $data;
		
	}

	public function get_analisa_kewajaran($id,$tit_id,$title){
		$this->load->model('prc_tender_item');
		$this->load->model('adm_employee');

		$this->prc_tender_item->join_pr();
		$this->prc_tender_item->where_in('TIT_ID',$tit_id);
		$data['titems'] = $this->prc_tender_item->get(array('PRC_TENDER_ITEM.PTM_NUMBER' => $id));
		$data['ece_tit_id'] = $this->input->post('ece_tit_id');
		$data['ece_tit_id'] = $data['ece_tit_id'][0];
		// echo "<pre>";
		// print_r($data['titems']);die;
		$data['title'] = $title;
		$requestioner = array();
		$data['employees'] = array();
		$opco = $this->session->userdata['EM_COMPANY'];

		foreach ($data['titems'] as $val) {
			$requestioner[] = $val['PPR_REQUESTIONER'];
			$mrpc = $val['PPI_MRPC'];
			$plant = $val['PPR_PLANT'];

			if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
				$this->adm_employee->mrpc_plant($mrpc, $plant);
				$data['employees'] = $this->adm_employee->get();

			} else if ($opco == '3000' || $opco == '4000') {
				$this->adm_employee->where_mkcctr($requestioner);
				$data['employees'] = $this->adm_employee->get();
			} 

		}


		$data['evaluator_ece'] = $data['titems'][0];
		$data['evaluator_ece'] = $this->adm_employee->find($data['evaluator_ece']['ECE_ASSIGN']);
		// echo "<pre>";
		// print_r($data['evaluator_ece']);die;

		$data = $this->load->view('analisa_kewajaran', $data, FALSE);
		echo $data;		
	}

}
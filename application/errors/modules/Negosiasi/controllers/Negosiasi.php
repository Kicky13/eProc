<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Negosiasi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->load->library("file_operation");
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model('currency_model');
		$this->load->helper('url');
		$this->load->library('comment');
	}

	public function showall() {
		$data['title'] = "Daftar Pekerjaan Negosiasi";
		$data['success'] = $this->session->flashdata('success') == 'success';
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/list_nego.js');
		$this->layout->render('list_nego', $data);
	}

	public function get_datatable($all = false) {
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_nego_approve');
		$datatable = $this->prc_tender_main->join_nego(false, 2);
		$datatable = $this->prc_tender_main->get();
		$datatable = $this->prc_tender_main->filter_wherehas_titstatus($datatable, 1);
		// var_dump($datatable); exit();
		$result = array();
		if (count($datatable) > 0) {
			foreach ($datatable as $key => $value) {
				/* Filter user */
				if ($value['NEGO_DONE'] == 1) {
					// $this->prc_tender_nego_approve->where_ptm($value['PTM_NUMBER']);
					// $this->prc_tender_nego_approve->where_done(0);
					// $negoaprove = $this->prc_tender_nego_approve->get();
					// $negoaprove = $negoaprove[0];
					
					// if ($this->authorization->getEmployeeId() != $negoaprove['APPROVAL_ID']) {
						unset($datatable[$key]);
						continue;
					// }
				} else {
					// var_dump($value['NEGO_DONE']);
					// var_dump($this->authorization->getEmployeeId() != $value['PTM_ASSIGNMENT']);
					// exit();
					if ($this->authorization->getEmployeeId() != $value['PTM_ASSIGNMENT']) {
						// var_dump($this->authorization->getEmployeeId() != $value['PTM_ASSIGNMENT']); //exit();
						unset($datatable[$key]);
						continue;
					}
				}
				//*/
				if ($datatable[$key]['NEGO_END'].'' != '') {
					$datatable[$key]['NEGO_END'] = betteroracledate(oraclestrtotime($value['NEGO_END']));
				}

				$skrg=time();

				if($datatable[$key]['NEGO_END']==""){
					$datatable[$key]['STATUS'] = 'Negosiasi Belum Dibuka';
				}else{
					$negoend=oraclestrtotime($value['NEGO_END']);
					if($negoend>$skrg){
						$datatable[$key]['STATUS'] = 'Negosiasi Sudah Dibuka';
					}else if($negoend<$skrg){
						$datatable[$key]['STATUS'] = 'Negosiasi Selesai';
					}
				} 
				
				
				$result[] = $datatable[$key];
			}
		}
		$data = array('data' => $result);
		echo json_encode($data);
	}

	public function index($id = '',$id_nego = '') {
		if ($id == '') {
			return $this->showall();
		}
		$this->load->model('adm_employee');
		$this->load->model('app_process_master');
		$this->load->model('prc_nego_detail');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_nego');
		$this->load->model('prc_tender_nego_sech');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_vendor');
		$this->load->library('snippet');

		$data['success'] = $this->session->flashdata('success') == 'success';

		$ptmain = $this->prc_tender_main->ptm($id);
		$ptmain = $ptmain[0];
		if ($ptmain['IS_EVALUATED'] == '2') {
			// redirect('Penunjukan_pemenang/index/' . $id);
		}

		$data['title'] = 'Negosiasi';
		$data['ptm_number'] = $id;
		$data['ptm_detail'] = $this->prc_tender_main->ptm($id);
		$data['ptm_detail'] = $data['ptm_detail'][0];
		$data['ptp'] = $this->prc_tender_prep->ptm($id);
		$data['comments'] = $this->comment->get_comment_from_ptm_num($id);
		// $data['negos'] = $this->prc_tender_nego_sech->get(array('PTM_NUMBER' => $id));

		$data['detail_ptm_snip'] = $this->snippet->detail_ptm($id,true,true,false);
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);
		if ($data['ptp']['PTP_IS_ITEMIZE'] == 1){
			$view_order='vendor_per_item';
		}else{
			$view_order='item_per_vendor';
		}
			$data['evaluasi'] = $this->snippet->evaluasi($id, false, true, false, false, false, true,false,false,$view_order);
		
		$data['show_harga'] = true;
		$data['show_nego'] = true;
		$data['input'] = false;
		$data['lulus_evatek_aja'] = false;
		$data['table_only'] = false;
		$data['view_order'] = $view_order;

		$this->prc_tender_nego->where_done(0);				
		$data['nego'] = $this->prc_tender_nego->id($id_nego);

		$skrg=time();
		$negoend=oraclestrtotime($data['nego']['NEGO_END']);
		$data['status_nego']='';
		if(empty($negoend)){
			$data['status_nego']='belum';
		}else if($negoend>$skrg){
			$data['status_nego']='process';
			//die('Negosiasi Sudah Dibuka Dan Belum Selesai');
		}else{
			$data['status_nego']='selesai';
		}
		$data['NEGO_END']=$data['nego']['NEGO_END'];
		$data['IS_EVALUASI_HARGA']=$data['nego']['IS_PRICE_EVAL'];

		/**
		 * [IMPORTANT] ini saat belum ada row di nego dgn ptm yg itu. 
		 * di blok ini bisa dikoding settingan awal negosiasi.
		 */
		if (empty($data['nego'])) {
			//*/
		}

		/* Ngambil item yang statusnya diset ke negosiasi */
		$this->prc_tender_item->join_nego_item();
		$where = array('TIT_STATUS' => 1,'PRC_TENDER_ITEM.PTM_NUMBER' => $id,'PRC_NEGO_ITEM.NEGO_ID'=>$id_nego);		
		$data['tits'] = $this->prc_tender_item->get($where);
		$tits = $data['tits'];
		
		/* Yang baru */
		$this->prc_tender_vendor->where_active();
		$this->prc_tender_vendor->where_tit_status(1);
		$this->prc_tender_vendor->where_ptv_is_nego();		
		$vendorss = $this->prc_tender_vendor->ptm($id);
		// echo "<pre>";
		// print_r($vendorss);die;
		$data['ptv'] = $vendorss;
		$data['vendors'] = array();
		foreach ((array) $vendorss as $val) {
			$vendors[$val['PTV_VENDOR_CODE']] = $val;			
		}

		$data['nego_msg'] = $this->prc_tender_nego_sech->ptm($id);
		$this->prc_tender_quo_item->where_win();
		$this->prc_tender_quo_item->join_pqm();
		$ptqi = $this->prc_tender_quo_item->get_by_ptm($id);		
		foreach ((array)$ptqi as $val) {	
			if(isset($vendors[$val['PTV_VENDOR_CODE']])){
				$data['vendors'][$val['PTV_VENDOR_CODE']]=$vendors[$val['PTV_VENDOR_CODE']];
				// $data['negos'][$val['PTV_VENDOR_CODE']] = $this->prc_tender_nego_sech->ptm_ptv($id, $val['PTV_VENDOR_CODE']);
				$data['ptqi'][$val['TIT_ID']][$val['PTV_VENDOR_CODE']] = $val;				
				$data['ptqi_eva'][$val['TIT_ID']][$val['PTV_VENDOR_CODE']] = $val;				
				$harneg = $this->prc_nego_detail->get(array('NEGO_ID'=>$id_nego,'VENDOR_NO'=>$val['PTV_VENDOR_CODE'],'TIT_ID'=>$val['TIT_ID']));
				
				$harneg = @$harneg[0];
				if($harneg['CHANGED']==1){
					$data['status_vendor'][$val['TIT_ID']][$val['PTV_VENDOR_CODE']] = 'sudah';//vendor sudah input nego
				}else{
					$data['status_vendor'][$val['TIT_ID']][$val['PTV_VENDOR_CODE']] = 'belum';//vendor belum input nego
				}
			}
			
			
		}
		//*/


		// /* SINYO */

		// 	foreach ($data['ptqi_eva'] as $tit => $val) {
		// 		$minfinalprice = INF;           
	 //            $vndfinalwin = '';  
		// 		foreach ($val as $k => $value) {
		// 			if(!empty($value['PQI_FINAL_PRICE'])){  
	 //                    if ($value['PQI_FINAL_PRICE'] < $minfinalprice) {
	 //                        $minfinalprice = $value['PQI_FINAL_PRICE'];
	 //                        $vndfinalwin = $value['PTV_VENDOR_CODE'];
	 //                    }
	                    
	 //                }
		// 		}
		// 		usort($val, array($this, 'sort_pemenang'));
		// 		$newval = array();
				
		// 		foreach ($val as $key => $vnd) {				
		// 			$newval[$vnd['PTV_VENDOR_CODE']] = $vnd;	
		// 			$newval[$vnd['PTV_VENDOR_CODE']]['FINALWIN'] = $vndfinalwin;
		// 		}
				
		// 		$data['ptqi_eva'][$tit] = $newval;
		// 	}

		// 	$this->prc_tender_prep->join_eval_template();
		// 	$data['ptp'] = $this->prc_tender_prep->ptm($id);

		// 	switch ($data['ptp']['EVT_TYPE']) {
		// 		case "1": $data['ptp']['EVT_TYPE_NAME'] = 'Evaluasi Kualitas Terbaik'; break;
		// 		case "2": $data['ptp']['EVT_TYPE_NAME'] = 'Evaluasi Kualitas Teknis dan Harga'; break;
		// 		case "3": $data['ptp']['EVT_TYPE_NAME'] = 'Evaluasi Harga Terbaik'; break;
		// 		case "4": $data['ptp']['EVT_TYPE_NAME'] = 'Evaluasi Interchangeable (khusus Tonasa)'; break;
		// 		case "5": $data['ptp']['EVT_TYPE_NAME'] = 'Sistem Gugur'; break;
		// 	}

		// 	foreach ($data['ptqi_eva'] as $key => $value) { # $key is TIT_ID
		// 		$max = -INF;
		// 		$min = INF;
		// 		$minprice = INF;
		// 		$minfinalprice = INF;
		// 		$vndwin = '';
		// 		$vndfinalwin = '';
		// 		foreach ($value as $keyy => $valuee) { # $keyy is VENDOR_NO
		// 			$total = 0;
		// 			$total += intval($valuee['PQI_TECH_VAL']) * intval($data['ptp']['EVT_TECH_WEIGHT']);
		// 			$total += intval($valuee['PQI_PRICE_VAL']) * intval($data['ptp']['EVT_PRICE_WEIGHT']);
		// 			$data['ptqi_eva'][$key][$keyy]['NILAI_TOTAL'] = $total;
					
		// 			$data['ptqi_eva'][$key][$keyy]['EVT_TECH_WEIGHT'] = intval($data['ptp']['EVT_TECH_WEIGHT']);
		// 			$data['ptqi_eva'][$key][$keyy]['EVT_PRICE_WEIGHT'] = intval($data['ptp']['EVT_PRICE_WEIGHT']);

		// 			$lulus = intval($valuee['PQI_TECH_VAL']) >= intval($data['ptp']['EVT_PASSING_GRADE']);
		// 			$data['ptqi_eva'][$key][$keyy]['LULUS_TECH'] = $lulus;

		// 			if ($data['ptp']['EVT_TYPE'] == '4') {
		// 				if ($lulus) {
		// 					if (intval($valuee['PQI_TECH_VAL']) > $max) {
		// 						$max = intval($valuee['PQI_TECH_VAL']);
		// 					}
		// 					if (intval($valuee['PQI_TECH_VAL']) < $min) {
		// 						$min = intval($valuee['PQI_TECH_VAL']);
		// 					}
		// 				}
		// 			}

		// 			if(!empty($valuee['PQI_PRICE_VAL'])){
		// 				if ($valuee['PQI_PRICE'] < $minprice) {
		// 					$vndwin = $keyy;
		// 					$minprice = $valuee['PQI_PRICE'];
		// 				}
		// 				if ($valuee['PQI_FINAL_PRICE'] < $minfinalprice) {
		// 					$vndfinalwin = $keyy;
		// 					$minfinalprice = $valuee['PQI_FINAL_PRICE'];
		// 				}
		// 			}
		// 		}

		// 		$data['ptqi_eva'][$key]['WIN'] = $vndwin;
		// 		$data['ptqi_eva'][$key]['FINALWIN'] = $vndfinalwin;

		// 		if ($data['ptp']['EVT_TYPE'] == '4' && $data['ptm_detail']['MASTER_ID'] >= 13) { // khusus tonasa & evaluasi harga
		// 			$selisih = $max - $min;
		// 			if ($selisih <= 5) {
		// 				$bobotharga = 100;
		// 			} else if ($selisih <= 10) {
		// 				$bobotharga = 90;
		// 			} else if ($selisih <= 15) {
		// 				$bobotharga = 80;
		// 			} else if ($selisih <= 20) {
		// 				$bobotharga = 70;
		// 			} else {
		// 				$bobotharga = 0;
		// 			}
		// 			$boboteknis = 100 - $bobotharga;

		// 			foreach ($value as $keyy => $valuee) {
		// 				$data['ptqi_eva'][$key][$keyy]['NILAI_TOTAL_B'] = $data['ptqi_eva'][$key][$keyy]['NILAI_TOTAL'];
		// 				$data['ptqi_eva'][$key][$keyy]['EVT_TECH_WEIGHT_B'] = $data['ptqi_eva'][$key][$keyy]['EVT_TECH_WEIGHT'];
		// 				$data['ptqi_eva'][$key][$keyy]['EVT_PRICE_WEIGHT_B'] = $data['ptqi_eva'][$key][$keyy]['EVT_PRICE_WEIGHT'];
						
		// 					$weight = empty($valuee['TIT_TECH_WEIGHT'])?$boboteknis:$valuee['TIT_TECH_WEIGHT'];
		// 					$price = empty($valuee['TIT_PRICE_WEIGHT'])?$bobotharga:$valuee['TIT_PRICE_WEIGHT'];

		// 					$total = 0;
		// 					$total += intval($valuee['PQI_TECH_VAL']) * $weight;
		// 					$total += intval($valuee['PQI_PRICE_VAL']) * $price;
		// 					$data['ptqi_eva'][$key][$keyy]['NILAI_TOTAL'] = $total;

		// 					$data['ptqi_eva'][$key][$keyy]['EVT_TECH_WEIGHT'] = $boboteknis;
		// 					$data['ptqi_eva'][$key][$keyy]['EVT_PRICE_WEIGHT'] = $bobotharga;
						
		// 			}
		// 		}
		// 	}


		// 		if ($data['ptp']['EVT_TYPE'] == '4' && $data['ptm_detail']['MASTER_ID'] >= 13) {
		// 			unset($tit);
		// 			$tits_b = array();		
		// 			foreach ($data['tits'] as $valtit) {			
		// 				$tit_b = $valtit;
		// 				$ptv_b = array();			
		// 				foreach ($vendorss as $valptv) {					
		// 					if (isset($data['ptqi_eva'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']])) {
		// 						if ($data['ptqi_eva'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']]['LULUS_TECH'] && $data['ptqi_eva'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']]['PQI_PRICE'] != 0) {
		// 							$valptv['pqi'] = $data['ptqi_eva'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']];
		// 							$ptv_b[] = $valptv;							
		// 						}
		// 						else{
		// 							if($data['ptqi_eva'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']]['LULUS_TECH']){
		// 								$valptv['pqi'] = $data['ptqi_eva'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']];
		// 								$ptv_b[] = $valptv;
		// 							}else{
		// 								$valptv['pqi'] = array_merge($data['ptqi_eva'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']], array('NILAI_TOTAL_B'=>0));
		// 								$ptv_b[] = $valptv;							
		// 							}
		// 						}
		// 					}
		// 				}
		// 				$tit_b['ptv_b'] = $ptv_b;
		// 				usort($tit_b['ptv_b'], array($this, 'sort_eval_b'));
		// 				$tits_b[] = $tit_b;
		// 			}	
		// 			$data['tits_b'] = $tits_b;
		// 		}


		// 		unset($tits);
		// 		unset($tit);
		// 		/* Ngerapihkan */
		// 		$tits = array();		
		// 		foreach ($data['tits'] as $valtit) {			
		// 			$tit = $valtit;
		// 			$ptv = array();			
		// 			foreach ($data['ptv'] as $valptv) {					
		// 				if (isset($data['ptqi_eva'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']])) {
		// 					if ($data['ptqi_eva'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']]['LULUS_TECH'] && $data['ptqi_eva'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']]['PQI_PRICE'] != 0) {
		// 						$valptv['pqi'] = $data['ptqi_eva'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']];
		// 						$ptv[] = $valptv;							
		// 					} else{
		// 						if($data['ptqi_eva'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']]['LULUS_TECH']){
		// 							$valptv['pqi'] = $data['ptqi_eva'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']];
		// 							$ptv[] = $valptv;
		// 						}else{
		// 							$valptv['pqi'] = array_merge($data['ptqi_eva'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']], array('NILAI_TOTAL'=>0));
		// 							$ptv[] = $valptv;							
		// 						}
		// 					}
		// 				}
		// 			}
		// 			$tit['ptv'] = $ptv;
		// 			usort($tit['ptv'], array($this, 'sort_eval'));
		// 			$tits[] = $tit;
		// 		}
		// 		$data['tit_new'] = $tits;

		// 		$data['batas_penawaran'] = false;
		// 		$dateNew = date('Y-m-d H:i:s');	
		// 		if(!empty($data['ptm_detail']['BATAS_VENDOR_HARGA_RG'])){
		// 			$data['batas_penawaran'] = true;
		// 			if(strtotime($data['ptm_detail']['BATAS_VENDOR_HARGA_RG']) > strtotime($dateNew)) {
		// 				$data['batas_penawaran'] = false;
		// 			}
		// 		}

		// /* END SINYO */

		$po['tits'] = $this->prc_tender_item->ptm($id);
		$data['tit_po'] = $this->load->view('Tahap_negosiasi/panel_po', $po, true);
		// echo "<pre>";
		// print_r($data);
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_datetimepicker();
		$this->layout->add_js('pages/mydatetimepicker.js');
		$this->layout->add_js('pages/update_tanggal_nego.js');
		$this->layout->render('negosiasi',$data);
	}

	private function sort_eval($a, $b) {
		return ($a['pqi']['NILAI_TOTAL'] < $b['pqi']['NILAI_TOTAL']);
	}

	private function sort_eval_b($a, $b) {
		return ($a['pqi']['NILAI_TOTAL_B'] < $b['pqi']['NILAI_TOTAL_B']);
	}

	private function sort_pemenang($a, $b) {
		return $a['PQI_FINAL_PRICE'] > $b['PQI_FINAL_PRICE'];
	}

	public function update_tanggal_nego(){
		$this->load->model('prc_tender_nego');

		$id = $this->input->post('ptm_number');
		$nego_id = $this->input->post('nego_id');
		// echo "<pre>";
		// print_r($id);
		// print_r($nego_id);
		// die;

		$nego_where['PTM_NUMBER'] = $id;
		$nego_where['NEGO_DONE'] = '0';
		$nego_where['NEGO_ID'] = $nego_id;
		$nego_end = $this->input->post('nego_end');
		$nego_set['NEGO_END'] = oracledate(strtotime($nego_end));

		$this->prc_tender_nego->update($nego_set, $nego_where);
		$data['status'] = 'success';
		echo json_encode($data);

		// redirect('Negosiasi/index/' . $id . '/'.$nego_id);
	}

	public function save_bidding() {
		$this->load->library('process');
		$this->load->library('Penilaian_otomatis');
		$this->load->model('adm_employee');
		$this->load->model('adm_employee_atasan');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_nego');
		$this->load->model('prc_nego_detail');
		$this->load->model('prc_tender_nego_approve');
		$this->load->model('prc_tender_nego_sech');
		$this->load->model('prc_tender_vendor');

		$id = $this->input->post('ptm_number');
		$nego_id = $this->input->post('nego_id');

		$this->prc_tender_nego->ptm($id);
		$nego_where['PTM_NUMBER'] = $id;
		$nego_where['NEGO_DONE'] = '0';
		$nego_where['NEGO_ID'] = $nego_id;
		$nego_end = $this->input->post('nego_end');
		$is_evaluasi_harga = $this->input->post('is_evaluasi_harga');

		
		$next_process = $this->input->post('next_process');
		$ptm = $this->prc_tender_main->ptm($id);
		$pembuat = $ptm[0]['PTM_REQUESTER_ID'];

		if ($next_process == 0 && empty($nego_end)) {
			$this->session->set_flashdata('error', 'Tanggal Selesai harus di isi.');
			redirect('Negosiasi/index/' . $id . '/'.$nego_id);
		}

			//--LOG MAIN--//
		$proses = 'Buka Negosiasi';
		if ($next_process == 1) {
			$proses = 'Tutup Negosiasi';
		}
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),$proses,'OK',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		/* Message Nego */
		// if (trim($this->input->post('pesan_nego')) != '') {
			$ptns['PTM_NUMBER'] = $id;
			$ptns['PTNS_ID'] = $this->prc_tender_nego_sech->get_id();
			// $ptns['PTV_VENDOR_CODE'] = $v['vnd'];
			$ptns['PTNS_CREATED_DATE'] = date('d-M-Y g.i.s A');
			$ptns['PTNS_CREATED_BY'] = $this->authorization->getEmployeeId();
			$ptns['PTNS_NEGO_MESSAGE'] = $this->input->post('pesan_nego');
			$this->prc_tender_nego_sech->insert($ptns);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Negosiasi/save_bidding','prc_tender_nego_sech','insert',$ptns);
				//--END LOG DETAIL--//
		// }
		
		if ($next_process == '0') {
			//nyo16032017
			$dateNew = date('Y-m-d H:i:s');	
			if(strtotime($nego_end) < strtotime($dateNew)){
				$this->session->set_flashdata('error', 'Tanggal-Jam Selesai harus melewati tanggal jam sekarang.');
				redirect('Negosiasi/index/' . $id . '/'.$nego_id);
			}

			if (!empty($nego_end)) {
				$nego_set['NEGO_END'] = oracledate(strtotime($nego_end));
				if($is_evaluasi_harga!=false){
					$nego_set['IS_PRICE_EVAL'] = intval($is_evaluasi_harga);
				}
				$this->prc_tender_nego->update($nego_set, $nego_where);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Negosiasi/save_bidding','prc_tender_nego','update',$nego_set,$nego_where);
					//--END LOG DETAIL--//
			}
			
			$this->prc_tender_vendor->where_active();
			$this->prc_tender_vendor->where_tit_status(1);
			$this->prc_tender_vendor->where_ptv_is_nego();
			$vendor= $this->prc_tender_vendor->ptm($id);			
			$ptm=$this->prc_tender_main->ptm($id);		
			foreach ($vendor as $key => $value) {				
				$dataemail=array(
					'EMAIL_ADDRESS'=>$value['EMAIL_ADDRESS'],
					'data'=>array(
						'norfq'=>$value['PTV_RFQ_NO'],
						'closingdate'=>date('d M Y g.i.s A', strtotime($nego_end)),
						'noptm'=>$ptm[0]['PTM_PRATENDER'])
					);				
				// var_dump($vendor);die;
				$this->kirim_email_nego($dataemail);			
			}
		}
		
		if ($next_process != '0') {

			$vendornego=array();
			$this->prc_tender_vendor->where_active();
			$this->prc_tender_vendor->where_tit_status(1);
			// $this->prc_tender_vendor->where_ptv_is_nego(1);
			$vendor_ternego=$this->prc_tender_vendor->ptm($id);			
			if(!empty($vendor_ternego)){
				foreach ($vendor_ternego as $vendor_nego) {
					$vendornego[]=$vendor_nego['PTV_VENDOR_CODE'];
				}
			}			
			

			//penilaian vendor berdasarkan tidak respon terhadap nego			
			$vndrs = array();
			$vendor_noresponse = $this->prc_nego_detail->get_response_vendor($nego_id,0);
			foreach ($vendor_noresponse as $vendornya) {
				if(in_array($vendornya['VENDOR_NO'], $vendornego)){
					$vndrs[]=array('PTV_VENDOR_CODE'=>$vendornya['VENDOR_NO'],'respon'=>'no');				
				}
			}
			
			//memasukkan nilai final nego_detail ke prc_tender_quo_item kolom pqi_final_price
			$hargarespon=array();
			$nego_detail = $this->prc_nego_detail->get(array('NEGO_ID'=>$nego_id,'CHANGED'=>1));
			if(!empty($nego_detail)){				
				$terendah = INF;
				foreach ($nego_detail as $value_nego) {					
					if($terendah>$value_nego['HARGA']){
						$terendah = $value_nego['HARGA'];
					}
				}

				foreach ($nego_detail as $value_nego) {
					$pqm = $this->prc_tender_quo_main->ptmptv($id,$value_nego['VENDOR_NO']);
					$pqm_id = $pqm[0]['PQM_ID'];
					$where_quo['PQM_ID'] = $pqm_id;
					$where_quo['PRC_TENDER_QUO_ITEM.TIT_ID'] = $value_nego['TIT_ID'];
					$set_final_price['PQI_FINAL_PRICE'] = $value_nego['HARGA'];

					$nego_where['NEGO_ID'] = $nego_id;
					$negobj = $this->prc_tender_nego->get($nego_where);
					$negobj = $negobj[0];
					//untuk memasukkan nilai harga nego ke nilai evaluasi harga
					if($negobj['IS_PRICE_EVAL']==1){
						$set_final_price['PQI_PRICE_VAL'] = ceil($terendah/$value_nego['HARGA']*100);
					}
					
					// penilaian vendor terhadap harga akhir nego (turun atau tetap)
					$hargarespon[$value_nego['VENDOR_NO']] = 'tetap';
					$pqitem = $this->prc_tender_quo_item->get(array('PQM_ID'=>$pqm_id));
					foreach ($pqitem as $pqitem_v) {
						if(empty($pqitem_v['PQI_FINAL_PRICE'])){
							if($pqitem_v['PQI_PRICE']>$value_nego['HARGA']){
								$hargarespon[$value_nego['VENDOR_NO']] = 'turun';
							}
						}
						else{
							if($pqitem_v['PQI_FINAL_PRICE']>$value_nego['HARGA']){
								$hargarespon[$value_nego['VENDOR_NO']] = 'turun';
							}
						}
					}
					$this->prc_tender_quo_item->update($set_final_price,$where_quo);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Negosiasi/save_bidding','prc_tender_quo_item','update',$set_final_price, $where_quo);
						//--END LOG DETAIL--//					
				}
			}

			$is_rfc_error = false;
			$hasil_rfc = array();
			foreach ($this->prc_tender_vendor->ptm($id) as $val) {
				$set['PTV_IS_NEGO'] = 0;
				$where['PTV_VENDOR_CODE'] = $val['PTV_VENDOR_CODE'];
				$where['PTM_NUMBER'] = $id;
				$this->prc_tender_vendor->update($set, $where);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Negosiasi/save_bidding','prc_tender_vendor','update',$set, $where);
					//--END LOG DETAIL--//
				
				$retrfq = $this->save_rfq($id, $val['PTV_VENDOR_CODE']);
				if ($retrfq != null) {
					foreach ($retrfq['FT_RETURN'] as $ft) {
						$hasil_rfc[] = $ft;
						if ($ft['TYPE'] == 'E') {
							$is_rfc_error = true;
						}
					}
				}
				// var_dump($retrfq); exit();
			}

			// $this->session->set_flashdata('rfc_ft_return', $hasil_rfc);
			$this->session->set_flashdata('rfc_ft_return', json_encode($hasil_rfc));
			if ($is_rfc_error) {
				// var_dump($this->session->flashdata('rfc_ft_return')); exit();							
				redirect('Negosiasi/index/'.$id);
			}

			
			if(!empty($hargarespon)){
				foreach ($hargarespon as $novendor => $respon) {
					if(in_array($novendor, $vendornego)){
						$vndrs[]=array('PTV_VENDOR_CODE'=>$novendor,'respon'=>$respon);
					}
				}				
			}

			$this->penilaian_otomatis->insert('negosiasi', $vndrs, $ptm[0]['PTM_PRATENDER'], null, $LM_ID);

			/* Tutup Negosiasi */
			// set item nya ke 5
			$this->prc_tender_item->join_nego_item();
			$where = array('TIT_STATUS' => 1,'PRC_TENDER_ITEM.PTM_NUMBER' => $id,'PRC_NEGO_ITEM.NEGO_ID'=>$nego_id);	
			$tits = $this->prc_tender_item->get($where);

			$itset = array('TIT_STATUS' => 5);
			foreach ($tits as $value) {
				$itwhere=array('TIT_ID'=>$value['TIT_ID']);
				$this->prc_tender_item->update($itset, $itwhere);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Negosiasi/save_bidding','prc_tender_item','update',$itset, $itwhere);
					//--END LOG DETAIL--//
			}
			

			// set nego done to 2
			$nego_where['PTM_NUMBER'] = $id;
			$nego_where['NEGO_DONE'] = 0;
			$nego_where['NEGO_ID'] = $nego_id;
			$negobj = $this->prc_tender_nego->get($nego_where);
			$negobj = $negobj[0];
			$this->prc_tender_nego->update(array('NEGO_DONE' => 1), $nego_where);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Negosiasi/save_bidding','prc_tender_nego','update',array('NEGO_DONE' => 1), $nego_where);
				//--END LOG DETAIL--//
			//*/

			$comment_id = $this->comment->get_new_id();
			$dataComment = array(
				"PTC_ID" => $comment_id,
				"PTM_NUMBER" => $id,
				"PTC_COMMENT" => '\''.$this->input->post('ptc_comment').'\'',
				"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
				"PTC_NAME" => '\''.$this->authorization->getCurrentName().'\'',
				"PTC_ACTIVITY" => "'Negosiasi'",
				);
			$this->comment->insert_comment_tender($dataComment);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Negosiasi/save_bidding','prc_tender_comment','insert',$dataComment);
				//--END LOG DETAIL--//

			/* History Negosiasi */
			$this->load->model('prc_nego_hist');

			$newhist['HIST_ID'] = $this->prc_nego_hist->get_id();
			$newhist['NEGOSIASI_ID'] = $negobj['NEGO_ID'];
			$newhist['PTM_NUMBER'] = $id;
			$newhist['NEGOSIASI'] = 1;
			$newhist['CREATED_AT'] = date(timeformat());
			$this->prc_nego_hist->insert($newhist);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Negosiasi/save_bidding','prc_nego_hist','insert',$newhist);
				//--END LOG DETAIL--//
			//*/

			$this->session->set_flashdata('success', 'success');
			redirect('Negosiasi');
		} else {			
		
			$this->session->set_flashdata('success', 'success');
			redirect('Negosiasi');
		}
	}

	public function save_rfq($ptm, $ptv) {
		$this->load->library('sap_handler');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_vendor');
		$vendor = $this->prc_tender_vendor->ptm_ptv($ptm, $ptv);
		$pqm = $this->prc_tender_quo_main->ptmptv($ptm, $ptv);
		$pqmbaru = $pqm;
		if (count($pqmbaru) <= 0) {
			return;
		}
		$pqm_id = $pqmbaru[0]['PQM_ID'];
		$pqm_valid_thru = $pqmbaru[0]['PQM_VALID_THRU'];
		// var_dump($pqm); exit();
		$ptp = $this->prc_tender_prep->ptm($ptm);
		$main = $this->prc_tender_main->ptm($ptm);
		$main = $main[0];
		$is_jasa = $main['IS_JASA'] == 1;

		$this->prc_tender_quo_item->where_tit_status(1);
		$this->prc_tender_quo_item->where_win();
		$ptqi = $this->prc_tender_quo_item->get_by_pqm($pqm_id, $is_jasa);

		$rfq = $vendor[0]['PTV_RFQ_NO'];
		$validto = '99991231';//date('Ymd', oraclestrtotime($pqm_valid_thru));
		$quodate = date('Ymd', oraclestrtotime($ptp['PTP_REG_OPENING_DATE']));
		$incoterm = $ptp['PTP_TERM_DELIVERY'];
		$incoterm_text = $ptp['PTP_DELIVERY_NOTE'];

		$item['delivery_date'] = date('Ymd', oraclestrtotime($ptp['PTP_DELIVERY_DATE']));
		$item['price_type'] = $main['PTM_RFQ_TYPE'];
		$item['valid_to'] = $validto;
		foreach ($ptqi as $val) {
			$item['net_price'] = $val['PQI_FINAL_PRICE'];
			if ($item['net_price'] == '0') {
				continue;
			}
			if ($is_jasa) {
				// $item['srv_line_no'] = $val['PPI_PRITEM'];
				$item['srv_line_no'] = 10;
			}
			$item['item_no'] = $val['TIT_EBELP'];
			$items[] = $item;
		}
		if (empty($items)) return false;

		$price_type = 'ZGPP';
		// var_dump(compact('rfq', 'validto', 'quodate', 'items', 'incoterm', 'incoterm_text', 'price_type'));

		$return = $this->sap_handler->saveRfqMaintain($rfq, $validto, $quodate, $items, $incoterm, $incoterm_text, $price_type);

		// echo "<pre>";
		// var_dump($return); 
		// echo "</pre>";	
		// exit();

		return $return;
	}

	public function kirim_email_nego($vendor){		
		$this->load->library('email');
		$this->config->load('email');
		$company_name = $this->session->userdata['COMPANYNAME']; 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->to($vendor['EMAIL_ADDRESS']);
		$this->email->cc('pengadaan.semenindonesia@gmail.com');				
		$this->email->subject("Undangan Negosiasi dari eProcurement ".$company_name.".");
		$content = $this->load->view('email/undangan_negosiasi',$vendor['data'],TRUE);
		$this->email->message($content);
		$this->email->send();
		
		
	}

}
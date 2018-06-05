<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Penunjukan_pemenang extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Authorization');
		$this->load->library('comment');
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->load->library('Layout');
	}

	public function show_all() {
		$data['title'] = "Daftar Penunjukan Pemenang";
		$data['success'] = $this->session->flashdata('success') == 'success';
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/list_pemenang_baru.js');
		$this->layout->render('list_pemenang', $data);
	}

	public function get_datatable($all = false) {
		$this->load->model('prc_tender_main');
		// $this->load->model('prc_tender_menang_approve');
		// $datatable = $this->prc_tender_main->join_nego(false, 2);
		$this->prc_tender_main->where_assignment($this->authorization->getEmployeeId());
		$datatable = $this->prc_tender_main->get();
		$datatable = $this->prc_tender_main->filter_wherehas_titstatus($datatable, 6);
		// if (count($datatable) > 0) {
			// foreach ($datatable as $key => $value) {
				/* Filter user */
				// if ($this->authorization->getEmployeeId() != $value['PTM_ASSIGNMENT']) {
					// unset($datatable[$key]);
					// continue;
				// }
				//*/
			// }
		// }
		$data = array('data' => isset($datatable)?$datatable:'');
		echo json_encode($data);
	}

	public function index($id = null) {
		if (empty($id)) {
			return $this->show_all();
		}
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_item');
		$this->load->library('snippet');

		// $data['evaluasi'] = $this->snippet->evaluasi($id, false, true, false, false, false, true);

		$data['title'] = 'Penunjukan Pemenang Negosiasi';
		$data['show_harga'] = true;
		$data['show_nego'] = false;
		$data['input'] = false;
		$data['lulus_evatek_aja'] = false;
		$data['table_only'] = false;
		$data['view_order'] = 'vendor_per_item';
		$data['ptm_number'] = $id;


		$data['ptm_detail'] = $this->prc_tender_main->ptm($id);
		$data['ptm_detail'] = $data['ptm_detail'][0];
		$this->prc_tender_item->where_status(6);
		$data['tits'] = $this->prc_tender_item->ptm($id);
		$tits= $this->prc_tender_item->ptm($id);

		$this->prc_tender_prep->join_eval_template();
		$data['ptp'] = $this->prc_tender_prep->ptm($id);

		$this->prc_tender_quo_item->join_pqm();
		$this->prc_tender_quo_item->where_win();
		$pqiall = $this->prc_tender_quo_item->get_by_ptm($id);
		foreach ($pqiall as $val) {
			$data['pqiall'][$val['TIT_ID']][$val['PTV_VENDOR_CODE']] = $val;			
			$data['ptqi'][$val['TIT_ID']][$val['PTV_VENDOR_CODE']] = $val;			
		}
		
		foreach ($data['pqiall'] as $tit => $val) {
			$minfinalprice = INF;           
            $vndfinalwin = '';  
			foreach ($val as $k => $value) {
				if(!empty($value['PQI_FINAL_PRICE'])){  
                    if ($value['PQI_FINAL_PRICE'] < $minfinalprice) {
                        $minfinalprice = $value['PQI_FINAL_PRICE'];
                        $vndfinalwin = $value['PTV_VENDOR_CODE'];
                    }
                    
                }
			}
			usort($val, array($this, 'sort_pemenang'));
			$newval = array();
			
			foreach ($val as $key => $vnd) {				
				$newval[$vnd['PTV_VENDOR_CODE']] = $vnd;	
				$newval[$vnd['PTV_VENDOR_CODE']]['FINALWIN'] = $vndfinalwin;
			}
			
			// var_dump($newval); exit();
			$data['pqiall'][$tit] = $newval;
		}
		
		$this->prc_tender_vendor->where_active();
		$vendor_data = $this->prc_tender_vendor->ptm($id);
		$data['ptv'] = $vendor_data;
		$data['vendor_data'] = array();
		foreach ($vendor_data as $val) {			
			foreach ($data['pqiall'] as $tit => $newvalue) {
				if(isset($newvalue[$val['PTV_VENDOR_CODE']])){
					$data['vendor_data'][$val['PTV_VENDOR_CODE']] = $val;
					$data['vendor_data'][$val['PTV_VENDOR_CODE']]['PQI_FINAL_PRICE'] = $newvalue[$val['PTV_VENDOR_CODE']]['PQI_FINAL_PRICE'];	
				}
			}
		}
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);

		/* SINYO */
			foreach ($data['ptqi'] as $tit => $val) {
				$minfinalprice = INF;           
	            $vndfinalwin = '';  
				foreach ($val as $k => $value) {
					if(!empty($value['PQI_FINAL_PRICE'])){  
	                    if ($value['PQI_FINAL_PRICE'] < $minfinalprice) {
	                        $minfinalprice = $value['PQI_FINAL_PRICE'];
	                        $vndfinalwin = $value['PTV_VENDOR_CODE'];
	                    }
	                    
	                }
				}
				usort($val, array($this, 'sort_pemenang'));
				$newval = array();
				
				foreach ($val as $key => $vnd) {				
					$newval[$vnd['PTV_VENDOR_CODE']] = $vnd;	
					$newval[$vnd['PTV_VENDOR_CODE']]['FINALWIN'] = $vndfinalwin;
				}
				
				$data['ptqi'][$tit] = $newval;
			}

			switch ($data['ptp']['EVT_TYPE']) {
				case "1": $data['ptp']['EVT_TYPE_NAME'] = 'Evaluasi Kualitas Terbaik'; break;
				case "2": $data['ptp']['EVT_TYPE_NAME'] = 'Evaluasi Kualitas Teknis dan Harga'; break;
				case "3": $data['ptp']['EVT_TYPE_NAME'] = 'Evaluasi Harga Terbaik'; break;
				case "4": $data['ptp']['EVT_TYPE_NAME'] = 'Evaluasi Interchangeable (khusus Tonasa)'; break;
				case "5": $data['ptp']['EVT_TYPE_NAME'] = 'Sistem Gugur'; break;
			}

			foreach ($data['ptqi'] as $key => $value) { # $key is TIT_ID
				$max = -INF;
				$min = INF;
				$minprice = INF;
				$minfinalprice = INF;
				$vndwin = '';
				$vndfinalwin = '';
				foreach ($value as $keyy => $valuee) { # $keyy is VENDOR_NO
					$total = 0;
					$total += intval($valuee['PQI_TECH_VAL']) * intval($data['ptp']['EVT_TECH_WEIGHT']);
					$total += intval($valuee['PQI_PRICE_VAL']) * intval($data['ptp']['EVT_PRICE_WEIGHT']);
					$data['ptqi'][$key][$keyy]['NILAI_TOTAL'] = $total;
					
					$data['ptqi'][$key][$keyy]['EVT_TECH_WEIGHT'] = intval($data['ptp']['EVT_TECH_WEIGHT']);
					$data['ptqi'][$key][$keyy]['EVT_PRICE_WEIGHT'] = intval($data['ptp']['EVT_PRICE_WEIGHT']);

					$lulus = intval($valuee['PQI_TECH_VAL']) >= intval($data['ptp']['EVT_PASSING_GRADE']);
					$data['ptqi'][$key][$keyy]['LULUS_TECH'] = $lulus;

					if ($data['ptp']['EVT_TYPE'] == '4') {
						if ($lulus) {
							if (intval($valuee['PQI_TECH_VAL']) > $max) {
								$max = intval($valuee['PQI_TECH_VAL']);
							}
							if (intval($valuee['PQI_TECH_VAL']) < $min) {
								$min = intval($valuee['PQI_TECH_VAL']);
							}
						}
					}

					if(!empty($valuee['PQI_PRICE_VAL'])){
						if ($valuee['PQI_PRICE'] < $minprice) {
							$vndwin = $keyy;
							$minprice = $valuee['PQI_PRICE'];
						}
						if ($valuee['PQI_FINAL_PRICE'] < $minfinalprice) {
							$vndfinalwin = $keyy;
							$minfinalprice = $valuee['PQI_FINAL_PRICE'];
						}
					}
				}

				$data['ptqi'][$key]['WIN'] = $vndwin;
				$data['ptqi'][$key]['FINALWIN'] = $vndfinalwin;

				if ($data['ptp']['EVT_TYPE'] == '4' && $data['ptm_detail']['MASTER_ID'] >= 13) { // khusus tonasa & evaluasi harga
					$selisih = $max - $min;
					if ($selisih <= 5) {
						$bobotharga = 100;
					} else if ($selisih <= 10) {
						$bobotharga = 90;
					} else if ($selisih <= 15) {
						$bobotharga = 80;
					} else if ($selisih <= 20) {
						$bobotharga = 70;
					} else {
						$bobotharga = 0;
					}
					$boboteknis = 100 - $bobotharga;

					foreach ($value as $keyy => $valuee) {
						$data['ptqi'][$key][$keyy]['NILAI_TOTAL_B'] = $data['ptqi'][$key][$keyy]['NILAI_TOTAL'];
						$data['ptqi'][$key][$keyy]['EVT_TECH_WEIGHT_B'] = $data['ptqi'][$key][$keyy]['EVT_TECH_WEIGHT'];
						$data['ptqi'][$key][$keyy]['EVT_PRICE_WEIGHT_B'] = $data['ptqi'][$key][$keyy]['EVT_PRICE_WEIGHT'];
						
							$weight = empty($valuee['TIT_TECH_WEIGHT'])?$boboteknis:$valuee['TIT_TECH_WEIGHT'];
							$price = empty($valuee['TIT_PRICE_WEIGHT'])?$bobotharga:$valuee['TIT_PRICE_WEIGHT'];

							$total = 0;
							$total += intval($valuee['PQI_TECH_VAL']) * $weight;
							$total += intval($valuee['PQI_PRICE_VAL']) * $price;
							$data['ptqi'][$key][$keyy]['NILAI_TOTAL'] = $total;

							$data['ptqi'][$key][$keyy]['EVT_TECH_WEIGHT'] = $boboteknis;
							$data['ptqi'][$key][$keyy]['EVT_PRICE_WEIGHT'] = $bobotharga;
						
					}
				}
			}

				if ($data['ptp']['EVT_TYPE'] == '4' && $data['ptm_detail']['MASTER_ID'] >= 13) {
					unset($tit);
					$tits_b = array();		
					foreach ($data['tits'] as $valtit) {			
						$tit_b = $valtit;
						$ptv_b = array();			
						foreach ($vendor_data as $valptv) {					
							if (isset($data['ptqi'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']])) {
								if ($data['ptqi'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']]['LULUS_TECH'] && $data['ptqi'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']]['PQI_PRICE'] != 0) {
									$valptv['pqi'] = $data['ptqi'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']];
									$ptv_b[] = $valptv;							
								}
								else{
									if($data['ptqi'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']]['LULUS_TECH']){
										$valptv['pqi'] = $data['ptqi'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']];
										$ptv_b[] = $valptv;
									}else{
										$valptv['pqi'] = array_merge($data['ptqi'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']], array('NILAI_TOTAL_B'=>0));
										$ptv_b[] = $valptv;							
									}
								}
							}
						}
						$tit_b['ptv_b'] = $ptv_b;
						usort($tit_b['ptv_b'], array($this, 'sort_eval_b'));
						$tits_b[] = $tit_b;
					}	
					$data['tits_b'] = $tits_b;
				}

				unset($tits);
				unset($tit);
				/* Ngerapihkan */
				$tits = array();		
				foreach ($data['tits'] as $valtit) {			
					$tit = $valtit;
					$ptv = array();			
					foreach ($data['ptv'] as $valptv) {					
						if (isset($data['ptqi'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']])) {
							if ($data['ptqi'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']]['LULUS_TECH'] && $data['ptqi'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']]['PQI_PRICE'] != 0) {
								$valptv['pqi'] = $data['ptqi'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']];
								$ptv[] = $valptv;							
							}
							else{
								if($data['ptqi'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']]['LULUS_TECH']){
									$valptv['pqi'] = $data['ptqi'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']];
									$ptv[] = $valptv;
								}else{
									$valptv['pqi'] = array_merge($data['ptqi'][$valtit['TIT_ID']][$valptv['PTV_VENDOR_CODE']], array('NILAI_TOTAL'=>0));
									$ptv[] = $valptv;							
								}
							}
						}
					}
					// die(var_dump($ptv));
					$tit['ptv'] = $ptv;
					usort($tit['ptv'], array($this, 'sort_eval'));
					$tits[] = $tit;
				}
				$data['tit_new'] = $tits;

				$data['batas_penawaran'] = false;
				$dateNew = date('Y-m-d H:i:s');	
				if(!empty($data['ptm_detail']['BATAS_VENDOR_HARGA_RG'])){
					$data['batas_penawaran'] = true;
					if(strtotime($data['ptm_detail']['BATAS_VENDOR_HARGA_RG']) > strtotime($dateNew)) {
						$data['batas_penawaran'] = false;
					}
				}

		/* END SINYO */ 
		$this->layout->add_js('pages/penunjukan_pemenang.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('penunjukan_pemenang',$data);
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

	public function win() {
		$this->load->model('adm_employee');
		$this->load->model('adm_employee_atasan');
		$this->load->model('prc_tender_eval');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_winner');
		
		// var_dump($this->input->post()); exit();
		$id = $this->input->post('ptm_number');
		$ptm = $this->prc_tender_main->ptm($id);
		$ptm = $ptm['0'];

		if ($this->input->post('next_process') == '999') { //BATAL
			redirect('Proc_verify_entry/batal/' . $id .'/Penunjukan Pemenang/Penunjukan_pemenang/index');
		}

		if ($this->input->post('next_process') == '0') { //retender
			redirect('Tender_cleaner/retender/' . $id .'/Penunjukan Pemenang');
		}

		$where['PTM_NUMBER'] = $id;
		$ptw['PTM_NUMBER'] = $id;
		$ptw['PTW_CREATED_BY'] = $this->authorization->getEmployeeId();
		$ptw['PTW_CREATED_AT'] = date('d-M-Y g.i.s A');
		$ptw['COMPANY_ID'] = $this->authorization->getCompanyId();
		$ptw['PPR_PGRP'] = $ptm['PTM_PGRP'];

		/* Masukan rfc dulu maintain terakhir, kalau berhasil baru next */
		$is_rfc_error = false;
		$hasil_rfc = array();

		foreach ($this->input->post('win') as $key => $value) {
			$retrfq = $this->save_rfq($id, $value, $key);
			if ($retrfq != null) {
				foreach ($retrfq['FT_RETURN'] as $ft) {
					$hasil_rfc[] = $ft;
					if ($ft['TYPE'] == 'E') {
						$is_rfc_error = true;
					}
				}
			}
		}

		// var_dump($hasil_rfc); die();
		$this->session->set_flashdata('rfc_ft_return', $hasil_rfc);
		if ($is_rfc_error) {
			redirect('Penunjukan_pemenang/index/'.$id);
		}
		//*/

			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Penunjukan Pemenang','OK',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//
		
		foreach ($this->input->post('win') as $key => $value) {
			$ptw['PTW_ID'] = $this->prc_tender_winner->get_id();
			$ptw['PTV_VENDOR_CODE'] = $value;
			$where['PTV_VENDOR_CODE'] = $value;

			$this->prc_tender_vendor->join_vnd_header();
			$ptv = $this->prc_tender_vendor->get($where);
			$ptv = $ptv[0];
			$ptw['PTV_RFQ_NO'] = $ptv['PTV_RFQ_NO'];
			$ptw['VENDOR_NAME'] = $ptv['VENDOR_NAME'];

			$this->prc_tender_quo_item->where_tit($key);
			$pqi = $this->prc_tender_quo_item->ptm_ptv($id, $value);
			$pqi = $pqi[0];
			$ptw['PPI_ID'] = $pqi['PPI_ID'];
			$ptw['PPI_PRNO'] = $pqi['PPI_PRNO'];
			$ptw['PPI_DECMAT'] = $pqi['PPI_DECMAT'];
			$ptw['TIT_QUANTITY'] = $pqi['PQI_QTY'];
			$ptw['PQI_PRICE'] = $pqi['PQI_FINAL_PRICE'];
			$ptw['PPI_NOMAT'] = $pqi['PPI_NOMAT'];
			$ptw['PPR_PGRP'] = $pqi['PPR_PGRP'];
			$ptw['PPR_PORG'] = $pqi['PPR_PORG'];
			$ptw['EBELP'] = $pqi['TIT_EBELP'];
			$ptw['SERVICE_ID'] = $pqi['SERVICE_ID'];

			$update_item = array('PEMENANG' => $value, 'TIT_STATUS' => 8, 'WIN_AT' => date(timeformat()));
			$this->prc_tender_item->update($update_item, array('TIT_ID' => $key));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Penunjukan_pemenang/win','prc_tender_item','update',$update_item,array('TIT_ID' => $key));
				//--END LOG DETAIL--//

			$this->prc_tender_winner->insert($ptw);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Penunjukan_pemenang/win','prc_tender_winner','insert',$ptw);
				//--END LOG DETAIL--//
		}

		/* Approval Negosiasi *
		$emp = $this->adm_employee->get(array('ID' => $this->authorization->getEmployeeId()));
		$nopeg = $emp[0]['NO_PEG'];

		$atasan = $this->adm_employee_atasan->get(array('MK_NOPEG' => $nopeg));
		$level = $atasan[0]['ATASAN1_LEVEL']; // get level atasan

		$ans = $this->adm_employee->atasan($this->authorization->getEmployeeId());
		$id_atasan = $ans[0]['ID']; // get atasan
		$nama_atasan = $ans[0]['FULLNAME']; // get atasan

		/* bikin approval *
		// var_dump($negodata); exit();
		$idaprove = $this->prc_tender_menang_approve->get_id();
		$dataaprove = array(
				'TMA_ID' => $idaprove,
				'PTM_NUMBER' => $id,
				'APPROVAL_ID' => $id_atasan,
				'APPROVAL_FULLNAME' => $nama_atasan,
				// 'NEGO_ID' => $negodata['NEGO_ID'],
				'CREATED_AT' => date(timeformat()),
			);
		$this->prc_tender_menang_approve->insert($dataaprove);
		//*/

		// var_dump($ptws);
		// exit();

		$comment_id = $this->comment->get_new_id(); 
		$dataComment = array(
			"PTC_ID" => $comment_id,
			"PTM_NUMBER" => $id,
			"PTC_COMMENT" => '\''.str_replace("'", "", $this->input->post('ptc_comment')).'\'',
			"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
			"PTC_NAME" => '\''.str_replace("'","",$this->authorization->getCurrentName()).'\'',
			"PTC_ACTIVITY" => "'Penunjukan Pemenang'",
			);
		$this->comment->insert_comment_tender($dataComment);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Penunjukan_pemenang/win','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		$this->session->set_flashdata('success', 'success'); 
		redirect('Penunjukan_pemenang');
	}

	public function save_rfq($ptm, $ptv, $tit_id) {
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
			// echo 'ba';
			return;
		}
		// echo 'yes';
		$pqm_id = $pqmbaru[0]['PQM_ID'];
		$pqm_valid_thru = $pqmbaru[0]['PQM_VALID_THRU'];
		// var_dump($pqm); exit();
		$ptp = $this->prc_tender_prep->ptm($ptm);
		$main = $this->prc_tender_main->ptm($ptm);
		$main = $main[0];
		$is_jasa = $main['IS_JASA'] == 1;

		// $this->prc_tender_quo_item->where_tit_status(1);
		$this->prc_tender_quo_item->where_win();
		$this->prc_tender_quo_item->where_tit($tit_id);
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
		// var_dump(compact('item', 'ptqi'));
		if (empty($items)) return false;

		if($is_jasa==1){
			$is_winner = 'X';
			$price_type = '';
		}else{
			$is_winner = '';
			$price_type = 'PB00';
		}

		// var_dump(compact('rfq', 'validto', 'quodate', 'items', 'incoterm', 'incoterm_text', 'price_type','is_winner'));
		// exit();
		$return = $this->sap_handler->saveRfqMaintain($rfq, $validto, $quodate, $items, $incoterm, $incoterm_text, $price_type, $is_winner);
		// var_dump($return);
		
		// echo "<pre>";
		// var_dump($return); 
		// echo "</pre>";	
		// exit();
		
		return $return;
	}
	// public function approval($id) {
	// 	$this->load->model('prc_tender_item');
	// 	$this->load->model('prc_tender_main');
	// 	$this->load->model('prc_tender_quo_item');
	// 	$this->load->model('prc_tender_quo_main');
	// 	$this->load->model('prc_tender_vendor');
	// 	$this->load->library('snippet');

	// 	$data['title'] = 'Penunjukan Pemenang Negosiasi';
	// 	$data['ptm_number'] = $id;
	// 	$data['ptm_detail'] = $this->prc_tender_main->ptm($id);
	// 	$data['ptm_detail'] = $data['ptm_detail'][0];
	// 	$this->prc_tender_item->where_status(6);
	// 	$data['tits'] = $this->prc_tender_item->ptm($id);

	// 	$this->prc_tender_quo_item->join_pqm();
	// 	$this->prc_tender_quo_item->where_win();
	// 	$pqiall = $this->prc_tender_quo_item->get_by_ptm($id);
	// 	foreach ($pqiall as $val) {
	// 		$data['pqiall'][$val['PTV_VENDOR_CODE']][$val['TIT_ID']] = $val;
	// 	}
	// 	$this->prc_tender_vendor->where_active();
	// 	$data['vendor_data'] = $this->prc_tender_vendor->ptm($id);

	// 	$data['ptm_comment'] = $this->snippet->ptm_comment($id);
	// 	$data['evaluasi'] = $this->snippet->evaluasi($id, false, true, true);

	// 	// $this->layout->add_js('pages/penunjukan_pemenang.js');
	// 	$this->layout->set_table_js();
	// 	$this->layout->set_table_cs();
	// 	// var_dump($data); exit();
	// 	$this->layout->render('approval_pemenang', $data);
	// }

	// public function winner($id = '') {
	// 	$this->load->model('prc_tender_eval');
	// 	$this->load->model('prc_tender_winner');
	// 	$this->load->library('snippet');
	// 	$where['PTM_NUMBER'] = $id;
	// 	$data['winner'] = $this->prc_tender_winner->get($where);
	// 	$data['title'] = 'Tender Sudah Dimenangkan';
	// 	$data['ptm_comment'] = $this->snippet->ptm_comment($id);
	// 	$this->layout->render('winner', $data);
	// }

	// public function save_approval() {
	// 	$this->load->model('adm_employee');
	// 	$this->load->model('adm_employee_atasan');
	// 	$this->load->model('prc_tender_eval');
	// 	$this->load->model('prc_tender_item');
	// 	$this->load->model('prc_tender_main');
	// 	$this->load->model('prc_tender_menang_approve');
	// 	$this->load->model('prc_tender_quo_item');
	// 	$this->load->model('prc_tender_vendor');
	// 	$this->load->model('prc_tender_winner');
	// 	// $this->load->library('process');
		
	// 	// var_dump($_POST); exit();
	// 	$id = $this->input->post('ptm_number');
	// 	$ptm = $this->prc_tender_main->ptm($id);
	// 	$ptm = $ptm['0'];

	// 	$setapr = array();
	// 	$setapr['APPROVED_AT'] = date(timeformat());
	// 	$setapr['IS_DONE'] = 1;
	// 	if ($this->input->post('submit') == 2) {
	// 		$setapr['IS_REJECT'] = 1;
	// 	} else {
	// 		$where['PTM_NUMBER'] = $id;
	// 		$ptw['PTM_NUMBER'] = $id;
	// 		$ptw['PTW_CREATED_BY'] = $this->authorization->getEmployeeId();
	// 		$ptw['PTW_CREATED_AT'] = date('d-M-Y g.i.s A');
	// 		$ptw['COMPANY_ID'] = $this->authorization->getCompanyId();
	// 		$ptw['PPR_PGRP'] = $ptm['PTM_PGRP'];

	// 		$this->prc_tender_item->where_status(6);
	// 		$items = $this->prc_tender_item->ptm($id);
	// 		foreach ($items as $keyitem => $value) {
	// 			$ptw['PTW_ID'] = $this->prc_tender_winner->get_id();
	// 			$ptw['PTV_VENDOR_CODE'] = $value['PEMENANG'];
	// 			$where['PTV_VENDOR_CODE'] = $value['PEMENANG'];

	// 			$this->prc_tender_vendor->join_vnd_header();
	// 			$ptv = $this->prc_tender_vendor->get($where);
	// 			$ptv = $ptv[0];
	// 			$ptw['PTV_RFQ_NO'] = $ptv['PTV_RFQ_NO'];
	// 			$ptw['VENDOR_NAME'] = $ptv['VENDOR_NAME'];

	// 			$this->prc_tender_quo_item->where_tit($value['TIT_ID']);
	// 			$pqi = $this->prc_tender_quo_item->ptm_ptv($id, $value['PEMENANG']);
	// 			$pqi = $pqi[0];
	// 			$ptw['PPI_ID'] = $pqi['PPI_ID'];
	// 			$ptw['PPI_PRNO'] = $pqi['PPI_PRNO'];
	// 			$ptw['PPI_DECMAT'] = $pqi['PPI_DECMAT'];
	// 			$ptw['TIT_QUANTITY'] = $pqi['TIT_QUANTITY'];
	// 			$ptw['PQI_PRICE'] = $pqi['PQI_FINAL_PRICE'];
	// 			$ptw['PPI_NOMAT'] = $pqi['PPI_NOMAT'];
	// 			$ptw['PPR_PGRP'] = $pqi['PPR_PGRP'];
	// 			$ptw['PPR_PORG'] = $pqi['PPR_PORG'];
	// 			$ptw['EBELP'] = $pqi['TIT_EBELP'];

	// 			$this->prc_tender_item->update(array('TIT_STATUS' => 8), array('TIT_ID' => $value['TIT_ID']));

	// 			$this->prc_tender_winner->insert($ptw);
	// 		}
	// 	}
	// 	$this->prc_tender_menang_approve->update($setapr, array('PTM_NUMBER' => $id));


	// 	$comment_id = $this->comment->get_new_id(); 
	// 	$dataComment = array(
	// 		"PTC_ID" => $comment_id,
	// 		"PTM_NUMBER" => $id,
	// 		"PTC_COMMENT" => '\''.$this->input->post('ptc_comment').'\'',
	// 		"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
	// 		"PTC_NAME" => '\''.$this->authorization->getCurrentName().'\'',
	// 		"PTC_ACTIVITY" => "'Approval Penunjukan Pemenang'",
	// 		);
	// 	$this->comment->insert_comment_tender($dataComment);

	// 	$this->session->set_flashdata('success', 'success'); redirect('Job_list');
	// }

}
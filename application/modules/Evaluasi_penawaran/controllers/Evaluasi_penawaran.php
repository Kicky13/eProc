<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluasi_Penawaran extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('procurement_job');
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->load->library("file_operation");
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model('currency_model');
		$this->load->helper('url');
		$this->load->library('comment');
	}

	public function index($id = '') {
		$this->procurement_job->check_authorization();
		$this->load->library('snippet');
		$this->load->model('adm_dept');
		$this->load->model('adm_employee');
		$this->load->model('app_process_master');
		$this->load->model('prc_add_item_evaluasi');
		$this->load->model('prc_do_evatek_uraian');
		$this->load->model('prc_eval_file');
		$this->load->model('prc_evaluasi_teknis');
		$this->load->model('prc_evaluasi_uraian');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_vendor');
		$this->load->model('m_tambahan_ub');
		$this->load->model('prc_preq_template_detail');
		$this->load->model('prc_evaluation_template');

		$data['title'] = 'Evaluasi Teknis';
		$data['ptp'] = $this->prc_tender_prep->ptm($id);
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);
		//$data['evaluasi'] = $this->snippet->evaluasi($id, false, false);
		$data['detail_ptm'] = $this->snippet->detail_ptm($id);
		$data['evaluator'] = $this->snippet->evaluator($id);
		$show_harga = $data['ptp']['PTP_EVALUATION_METHOD_ORI'] == 0;
		$data['vendor_ptm'] = $this->snippet->vendor_ptm($id, true, $show_harga);
		$data['ptm_number'] = $id;
		$this->prc_tender_quo_main->join_eval();
		$this->prc_tender_quo_main->join_pqe();
		$data['vendor_data'] = $this->prc_tender_quo_main->get_join(array('PRC_TENDER_QUO_MAIN.PTM_NUMBER' => $id));

		/********************************************************************/
		
		$data['dokumen_pr_tam'] = $this->m_tambahan_ub->doctam($id);
		$data['dokumentambahan'] = $this->m_tambahan_ub->doctambahan_eva($id);
		
		$this->prc_evaluasi_uraian->where_ptm($id);
		$eu = $this->prc_evaluasi_uraian->get();
		//echo $eu; die;
		foreach ($eu as $val) {
			$data['eu'][$val['TIT_ID']][$val['ET_ID']][] = $val;
		}

		$this->prc_do_evatek_uraian->where_ptm($id);
		$deu = $this->prc_do_evatek_uraian->get();
		foreach ($deu as $val) {
			$data['det'][$val['TIT_ID']][$val['ET_ID']][$val['PTV_VENDOR_CODE']] = $val;
			$data['deu'][$val['TIT_ID']][$val['ET_ID']][$val['PTV_VENDOR_CODE']][$val['EU_ID']] = $val;
			
		}

		$this->prc_eval_file->where_ptm($id);
		$ef = $this->prc_eval_file->get();
		$data['ef'] = array();
		foreach ($ef as $val) {
			$data['ef'][$val['TIT_ID']][$val['ET_ID']][$val['PTV_VENDOR_CODE']] = $val;
		}

		$this->prc_evaluasi_teknis->where_ptm($id);
		$data['ppd'] = $this->prc_evaluasi_teknis->get();
		if($data['ppd']){
			$pptd = $this->prc_preq_template_detail->get(array('PPD_ID' => $data['ppd'][0]['PPD_ID']));
			$da = $this->prc_evaluation_template->get(array('EVT_ID' => $pptd[0]['PPT_ID']));
			$data['template_name'] = $da[0];
			$data['template_update'] = $this->template_update($id, $pptd[0]['PPT_ID']);
		}

		$data['pesan'] = $this->viewHistoryPesan($id);
		// var_dump($data); exit();
		/********************************************************************/

		$companyId = $this->authorization->getCompanyId();
		$data['dept'] = $this->adm_dept->get(array('DEPT_COMPANY' => $companyId));
		$this->prc_tender_vendor->where_active();
		$this->prc_tender_vendor->join_vnd_header();
		$data['vendor'] = $this->prc_tender_vendor->ptm($id);

		$ptm = $this->prc_tender_main->prc_tender_main->ptm($id);
		$data['ptm'] = $ptm[0];
		$this->load->library('process');
		$data['next_process'] = $this->process->get_next_process($id);

		$atasan = $this->adm_employee->atasan($this->authorization->getEmployeeId());
		$atasan = $atasan[0];
		
		$data['next_process']['NAMA_BARU'] .= ' (oleh '. $atasan['FULLNAME'].')';

		// var_dump($data);
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->add_js('pages/evaluasi_teknis.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();			
		$this->layout->render('evaluasi_teknis',$data);
	}

	private function template_update($id, $ppt_id){
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_preq_template_detail');
		$this->load->model('prc_evaluasi_teknis');
		$this->load->model('prc_eval_file');
		$this->load->model('prc_preq_template_uraian');
		$this->load->model('prc_do_evatek_uraian');
		$this->load->model('prc_evaluasi_uraian');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_main');

		$ptm = $this->prc_tender_main->ptm($id);
		$ptm = $ptm[0];

		if ($ptm['IS_JASA'] == 1) {
			$this->prc_tender_item->join_pr(true);
		}	
		$data['tit'] = $this->prc_tender_item->get(array('PTM_NUMBER'=>$id, 'TIT_STATUS <>'=>999));

		$this->prc_tender_vendor->where_active();
		$data['ptv'] = $this->prc_tender_vendor->ptm($id);
		foreach ((array)$data['ptv'] as $key => $val) {
			$this->prc_eval_file->where_ptm_ptv($id, $val['PTV_VENDOR_CODE']);
			$ef = $this->prc_eval_file->get();
			foreach ($ef as $e) {
				$data['pef'][$val['PTV_VENDOR_CODE']][$e['TIT_ID']] = $e['EF_FILE'];
			}
		}

		/* Ngambil PQI */
		foreach ($data['ptv'] as $vnd) {
			/* Ngisi tabel buat pilih pemenang */
			foreach ($data['tit'] as $tit) {
				$this->prc_tender_quo_item->where_tit($tit['TIT_ID']);
				$pqi = $this->prc_tender_quo_item->ptm_ptv($id, $vnd['PTV_VENDOR_CODE']);
				// $data['pqis'][] = $pqi;
				if ($pqi != null) {
					$pqi = $pqi[0];
					$data['pqi'][$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']] = $pqi;
				}
			}
		}

		$this->prc_evaluasi_teknis->where_ptm($id);
		$ppd = $this->prc_evaluasi_teknis->get();
		$data['ppd2']=array();
		foreach ($ppd as $val) {
			$pe = $this->prc_evaluasi_uraian->get(array('ET_ID' => $val['ET_ID']));
			if(isset($pe[0])){
				$data['ppd2'][$val['PPD_ID']][$pe[0]['TIT_ID']]=$val;
			}
			foreach ($pe as $value) {
				$data['peu'][$val['ET_ID']][$value['TIT_ID']][$value['EU_NAME']] = $value;
				$data['peu2'][$val['ET_ID']][$value['TIT_ID']][$value['EU_NAME']][]=$value;
			}
		}
		
		// die(var_dump($data['peu']['534']['541']['Spek 1']));//534 - 541 - Spek 1
		$data['ptd'] = $this->prc_preq_template_detail->get(array('PPT_ID' => $ppt_id));
		foreach ((array)$data['ptd'] as $key => $val) {
			$ur = $this->prc_preq_template_uraian->get(array('PPD_ID' => $val['PPD_ID']));
			$data['uraian'][$val['PPD_ID']] = $ur;
		}

		$this->prc_do_evatek_uraian->where_ptm($id);
		$deu = $this->prc_do_evatek_uraian->get();
		foreach ($deu as $val) {
			$data['det'][$val['TIT_ID']][$val['ET_ID']][$val['PTV_VENDOR_CODE']] = $val;
			$data['deu'][$val['TIT_ID']][$val['ET_ID']][$val['PTV_VENDOR_CODE']][$val['EU_ID']] = $val;
		}
		//die(var_dump($data['deu']['541']['534']['0000110021']['1298']));
		$data['vendor_data'] = $this->prc_tender_quo_main->get_join(array('PRC_TENDER_QUO_MAIN.PTM_NUMBER' => $id));

		$ansi = $this->load->view('Evaluasi_penawaran/evaluasi_template_update', $data, true);
		return $ansi;
	}

	public function save_bidding() {
		// echo "<pre>";
		// echo $this->db->last_query();die;
		// var_dump($_POST);die;
		//print_r($this->input->post('det')); die();
		$this->load->model('prc_evaluasi_uraian');
		$this->load->model('prc_do_evatek');
		$this->load->model('prc_add_item_evaluasi');
		$this->load->model('prc_do_evatek_uraian');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('adm_employee');
		$this->load->model('prc_evaluasi_teknis');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_preq_template_uraian');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_chat');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_pr_item');
		$this->load->model('prc_evaluator');
		$this->load->library('process');

		$id = $this->input->post('ptm_number');
		$template_uraian = $this->input->post('template_uraian');
		$next_process = $this->input->post('next_process');

			// jika ga ada yg dicentang
		if ($template_uraian == false) {
			$this->session->set_flashdata('error', 'Template Evaluasi Harus di isi');
			redirect('Evaluasi_penawaran/index/' . $id);
		}

			//--LOG MAIN--//
		$action = 'OK';
		if ($next_process == 2) {
			$action = 'SIMPAN DRAFT';
		}
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),$this->input->post('process_name'),$action,$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		/* Create additional item */
		$nfiles = $this->input->post('numberfiles');
		for ($i = 1; $i <= $nfiles ; $i++) { 
			$uploaded = $this->file_operation->upload(UPLOAD_PATH.'additional_file', array('add_doc'.$i => $_FILES['add_doc'.$i]));

			/* upload tambahan item untuk vendor */
			if (!empty($uploaded['add_doc'.$i])) {
				$add['ADD_ID'] = $this->prc_add_item_evaluasi->get_id();
				$add['PTM_NUMBER'] = $id;
				$namedoc = 'name_doc' . $i;
				$add['NAME'] = $this->input->post($namedoc);
				$add['FILE'] = $uploaded['add_doc'.$i]['file_name'];
				$add['CREATED_AT'] = date('d-M-Y g.i.s A');

				$this->prc_add_item_evaluasi->insert($add);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_bidding','prc_add_item_evaluasi','insert',$add);
					//--END LOG DETAIL--//
			}
		}

		$ptp['EVT_ID'] = $this->input->post('evt_id');
		$this->prc_tender_prep->updateByPtm($id, $ptp);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_bidding','prc_tender_prep','update',$ptp,array('PTM_NUMBER'=>$id));
			//--END LOG DETAIL--//

		$eu_name = (array)$this->input->post('eu_item');
		foreach ($this->input->post('eu_weight') as $tit_no => $data) {
			foreach ($data as $k => $val) {
				if(!empty($val)){
					$eu_weight[$tit_no][$eu_name[$k]] = $val;					
				}
			}
		}

		foreach ($template_uraian as $ky => $x) {
			foreach ($x as $p => $z) {
				$tmplt[] = array(
					'TIT_ID' => $ky,
					'PPD_ID' => $p,
					'PPTU_ID' => $z[0]
					);
			}
		}

		$valPerParent = array();
		foreach ($this->input->post('det') as $kyvnd => $det) {
			foreach ($det as $kytit => $tit) {
				foreach ($tit as $kyppd => $valParent) {
					foreach ($tmplt as $data) {
						if($kytit==$data['TIT_ID'] && $kyppd==$data['PPD_ID']){
							$valPerParent[$kyvnd][$kytit][$kyppd]=$valParent[0];  //nilai per parent
						}
					}
				}
			}
		}

		$valPerChild = array();
		foreach ($this->input->post('deu') as $vndno => $isi) {
			foreach ($isi as $tit_id => $isi2) {
				foreach ($isi2 as $ppd_id => $isi3) {
					foreach ($isi3 as $pptu_id => $isi4) {
						$valPerChild[$vndno][$tit_id][$ppd_id][$pptu_id]=$isi4[0]; // nilai per child
					}
				}
			}
		}	
		// echo "<pre>";
		// var_dump($valPerChild);

			//-- Delete data sebelumnya --//
		$dpet =  $this->prc_evaluasi_teknis->get(array('PTM_NUMBER' => $id));
		foreach ($dpet as $dval1) {
			$dpde = $this->prc_do_evatek->get(array('ET_ID' => $dval1['ET_ID']));
			foreach ($dpde as $dval2) {
				$this->prc_do_evatek_uraian->delete(array('DET_ID' => $dval2['DET_ID']));
				$this->prc_tender_quo_item->update(array('PQI_TECH_VAL' => 0), array('PQI_ID' => $dval2['PQI_ID']));

					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_bidding','prc_do_evatek_uraian','delete',null,array('DET_ID' => $dval2['DET_ID']));
				// $this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_bidding','prc_tender_quo_item','update',array('PQI_TECH_VAL' => 0),array('PQI_ID' => $dval2['PQI_ID']));
					//--END LOG DETAIL--//
			}
			$this->prc_do_evatek->delete(array('ET_ID' => $dval1['ET_ID']));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_bidding','prc_do_evatek','delete',null,array('ET_ID' => $dval1['ET_ID']));
				//--END LOG DETAIL--//
		}
		$this->prc_evaluasi_uraian->delete(array('PTM_NUMBER' => $id));
		$this->prc_evaluasi_teknis->delete(array('PTM_NUMBER' => $id));
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_bidding','prc_evaluasi_uraian','delete',null,array('PTM_NUMBER' => $id));
		$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_bidding','prc_evaluasi_teknis','delete',null,array('PTM_NUMBER' => $id));
			//--END LOG DETAIL--//
			//-- end Delete --//

			//-- insert nilai template --//
		$et_name = (array)$this->input->post('et_name');
		$et_weight = (array)$this->input->post('et_weight');
		$ppd_id = (array)$this->input->post('ppd_id');
		$et_tit_id = (array)$this->input->post('et_tit_id');
		$et_id = $this->prc_evaluasi_teknis->get_id();
		foreach ($et_name as $key => $val) {
			foreach ($tmplt as $data) {
				if($et_tit_id[$key]==$data['TIT_ID'] && $ppd_id[$key]==$data['PPD_ID']){
						//utk proses looping
					$pet[] = array(
						'ET_ID' => $et_id,
						'PTM_NUMBER' => $id,
						'ET_NAME' => $val,
						'ET_WEIGHT' => $et_weight[$key],
						'PPD_ID' => $ppd_id[$key],
						'TIT_ID' => $et_tit_id[$key],
						);
						//utk insert
					$petInsert[] = array(
						'ET_ID' => $et_id,
						'PTM_NUMBER' => $id,
						'ET_NAME' => $val,
						'ET_WEIGHT' => $et_weight[$key],
						'PPD_ID' => $ppd_id[$key],
						);
					$et_id++;
				}
			}
		}

		$this->prc_evaluasi_teknis->insert_batch($petInsert); 
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_bidding','prc_evaluasi_teknis','insert',$petInsert);
			//--END LOG DETAIL--//
		$pqm = $this->prc_tender_quo_main->get(array('PTM_NUMBER'=>$id, 'PQM_STOP_STATUS'=>0));
		foreach ($pet as $yk => $val) { //proses insert total nilai per parent
			foreach ($pqm as $d) { 
				$noVnd = $d['PTV_VENDOR_CODE'];
				$pqi = $this->prc_tender_quo_item->get(array('PQM_ID'=>$d['PQM_ID'], 'PRC_TENDER_QUO_ITEM.TIT_ID'=>$val['TIT_ID']));
				if(!empty($pqi[0]['PQI_ID'])){
					$pqi_id = $pqi[0]['PQI_ID'];

					$id_det = $this->prc_do_evatek->get_id();
					$pdet['DET_ID'] = $id_det;
					$pdet['PQI_ID'] = $pqi_id;
					$pdet['ET_ID'] = $val['ET_ID'];
					$pdet['DET_TECH_VAL'] = ($valPerParent[$noVnd][$val['TIT_ID']][$val['PPD_ID']] == '')? 0 : $valPerParent[$noVnd][$val['TIT_ID']][$val['PPD_ID']];
					// echo $noVnd.'<br/>';
					// echo 'prc_do_evatek =>  '.$val['TIT_ID'].' - '.$id_det.' - '.$pqi_id.' - '.$val['ET_ID'].' => ';
					// echo ($valPerParent[$noVnd][$val['TIT_ID']][$val['PPD_ID']] == '')? '0<br/>' : $valPerParent[$noVnd][$val['TIT_ID']][$val['PPD_ID']].'<br/>';
					$this->prc_do_evatek->insert($pdet);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_bidding','prc_do_evatek','insert',$pdet);
						//--END LOG DETAIL--//

					$new_eu['PTM_NUMBER'] = $id;
					$new_eu['IS_ACTIVE'] = 1;					
					$new_eu['TIT_ID'] = $val['TIT_ID'];
					$new_eu['ET_ID'] = $val['ET_ID'];
					$pptu = $this->prc_preq_template_uraian->get(array('PPD_ID' => $val['PPD_ID']));
					
					// echo "<pre>";
					// var_dump($pptu);
					// var_dump(array_unique($pptu));
					foreach ($pptu as $uraian) { //proses insert nilai child
						// echo $novnd.'-'.$val['TIT_ID'].'-'.$val['PPD_ID'].'-'.$uraian['PPTU_ID'];
						if(isset($valPerChild[$noVnd][$val['TIT_ID']][$val['PPD_ID']][$uraian['PPTU_ID']])){ 
							// echo 'okee<br>';
							$id_eu = $this->prc_evaluasi_uraian->get_id();
							$new_eu['EU_ID'] = $id_eu;
							$new_eu['EU_NAME'] = $uraian['PPTU_ITEM'];
							$new_eu['EU_WEIGHT'] = isset($eu_weight[$val['TIT_ID']][$uraian['PPTU_ITEM']])? $eu_weight[$val['TIT_ID']][$uraian['PPTU_ITEM']] : '';
							// echo 'prc_evaluasi_uraian =>  '.$new_eu['TIT_ID'].' - '.$new_eu['ET_ID'].' - '.$new_eu['EU_NAME'].' - '.$new_eu['EU_WEIGHT'].' => ';
							// echo $eu_weight[$val['TIT_ID']][$uraian['PPTU_ITEM']].'<br/>';
							$this->prc_evaluasi_uraian->insert($new_eu);
							// echo "<pre>";
							// var_dump($new_eu);
								//--LOG DETAIL--//
							$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_bidding','prc_evaluasi_uraian','insert',$new_eu);
								//--END LOG DETAIL--//

							$pdeu['DEU_ID'] = $this->prc_do_evatek_uraian->get_id();
							$pdeu['DET_ID'] = $id_det;
							$pdeu['EU_ID'] = $id_eu;
							$pdeu['DEU_TECH_VAL'] = ($valPerChild[$noVnd][$val['TIT_ID']][$val['PPD_ID']][$uraian['PPTU_ID']] == '')? 0 : $valPerChild[$noVnd][$val['TIT_ID']][$val['PPD_ID']][$uraian['PPTU_ID']];
							// echo 'prc_do_evatek_uraian =>  '.$id_det.' - '.$id_eu.' - '.$noVnd.' - '.$val['TIT_ID'].' - '.$val['PPD_ID'].' - '.$uraian['PPTU_ID'].' => ';
							// echo $valPerChild[$noVnd][$val['TIT_ID']][$val['PPD_ID']][$uraian['PPTU_ID']].'<br/>';
							$this->prc_do_evatek_uraian->insert($pdeu);
								//--LOG DETAIL--//
							$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_bidding','prc_do_evatek_uraian','insert',$pdeu);
								//--END LOG DETAIL--//
						}
					}	
				}
			}
		}
		// die('stop');
			//-- End Insert template-- //

			//fix
		foreach ($this->input->post('total') as $key => $total) {
			$this->prc_tender_quo_item->update(array('PQI_TECH_VAL' => $total), array('PQI_ID' => $key));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_bidding','prc_tender_quo_item','update',array('PQI_TECH_VAL' => $total),array('PQI_ID' => $key));
				//--END LOG DETAIL--//
		}

		foreach ($this->input->post('pqi_note') as $key => $note) {
			$this->prc_tender_quo_item->update(array('PQI_NOTE' => $note), array('PQI_ID' => $key));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_bidding','prc_tender_quo_item','update',array('PQI_NOTE' => $note),array('PQI_ID' => $key));
				//--END LOG DETAIL--//
		}

		$ptm = $this->prc_tender_main->prc_tender_main->ptm($id);
		$ptm = $ptm[0];
		
		$comment_id = $this->comment->get_new_id(); 
		$dataComment = array(
			"PTC_ID" => $comment_id,
			"PTM_NUMBER" => $id,
			"PTC_COMMENT" => "'".str_replace("'", "''", $this->input->post('ptc_comment'))."'",
			"PTC_POSITION" => "'".$this->authorization->getCurrentRole()."'",
			"PTC_NAME" => "'".str_replace("'", "''", $this->authorization->getCurrentName())."'",
			"PTC_ACTIVITY" => "'Evaluasi Teknis'",
			"PTC_STATUS_PROSES" => $ptm['MASTER_ID'],
			);
		$this->comment->insert_comment_tender($dataComment);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_bidding','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		if ($next_process == '1') {
			foreach ($this->input->post('deu') as $vndno => $isi) {
				foreach ($isi as $tit_id => $isi2) {
					foreach ($isi2 as $ppd_id => $isi3) {
						foreach ($isi3 as $pptu_id => $isi4) {
							if ($isi4[0]=='') {
								$this->session->set_flashdata('error', 'Ada Vendor yang belum dilakukan penilaian.');
								redirect('Evaluasi_penawaran/index/' . $id);
							}
						}
					}
				}
			}
			/******* cek dulu ini orangnya biro apa nggak *******/
			$atasan = $this->adm_employee->atasan($this->authorization->getEmployeeId());
			$atasan = $atasan[0];	

			$this->process->next_process_user($id, 'NEXT', $atasan['ID'], $LM_ID);
			
			$ptm_status = $ptm['PTM_STATUS'];
			if($ptm_status != '11'){//status proses EVATEK
				$set['NEXT_PROSES'] = '1';		
				$this->prc_chat->update($set, array('PTM_NUMBER'=>$id));
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_bidding','prc_chat','update',$set,array('PTM_NUMBER'=>$id));
					//--END LOG DETAIL--//
			}

			$pti = $this->prc_tender_item->get(array('PTM_NUMBER'=>$id));
			$pri = $this->prc_pr_item->where_ppiId($pti[0]['PPI_ID']);
			$evl = $this->prc_evaluator->get_desc(array('PTM_NUMBER'=>$id));
			$emp = $this->adm_employee->get(array('ID'=>$evl[0]['EMP_ID']));

			$user['EMAIL'] = $atasan['EMAIL'];
			$user['data']['judul'] = 'Approval Evaluasi Teknis';
			$user['data']['nama_pengadaan'] = $ptm['PTM_SUBJECT_OF_WORK'];
			$user['data']['no_pengadaan'] = $ptm['PTM_PRATENDER'];
			$user['data']['no_pr'] = $pri[0]['PPI_PRNO'];
			$user['data']['evaluator'] = $emp[0]['FULLNAME'];
			
			// $this->kirim_email($user);

		}
		$this->session->set_flashdata('success', 'success'); 
		redirect('Job_list');
	}

	// public function coba(){
	// 	echo phpinfo();
	// }

	public function index_harga($id = '') {
		$this->procurement_job->check_authorization();
		$this->load->library('snippet');
		$this->load->model('adm_dept');
		$this->load->model('app_process_master');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_evaluation_template');

		$data['title'] = 'Evaluasi Harga';
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);
		$data['vendor_ptm'] = $this->snippet->vendor_ptm($id, true, true);
		$data['pesan'] = $this->viewHistoryPesan($id);
		$data['ptm_number'] = $id;
		$this->prc_tender_prep->join_eval_template();
		$data['ptp'] = $this->prc_tender_prep->ptm($id);

		if($data['ptp']['PTP_IS_ITEMIZE']==1){
			$data['evaluasi'] = $this->snippet->evaluasi($id, false,true,false,false,false,false,false,false,'vendor_per_item');
		}else{
			$data['evaluasi'] = $this->snippet->evaluasi($id, false,true,false,false,false,false,false,false,'item_per_vendor');
		}
		$data['detail_ptm'] = $this->snippet->detail_ptm($id);
		// $this->prc_tender_quo_main->join_eval();
		// $this->prc_tender_quo_main->join_pqe();
		// $data['vendor_data'] = $this->prc_tender_quo_main->get_join(array('PRC_TENDER_QUO_MAIN.PTM_NUMBER' => $id));

		/********************************************************************/
		$data['tit'] = $this->prc_tender_item->get(array('PTM_NUMBER'=>$id,'TIT_STATUS <>'=>999));

		$this->prc_tender_vendor->where_active();
		$data['ptv'] = $this->prc_tender_vendor->ptm($id);

		$data['vendor_galulus'] = array();

		$ptv = array();
		foreach ($data['ptv'] as $key => $vnd) {
			$ptv[$vnd['PTV_VENDOR_CODE']] = $vnd;
		}

		$data['ptv'] = $ptv;

		/* Ngambil PQI */
		foreach ($data['ptv'] as $vnd) {
			/* Ngisi tabel buat pilih pemenang */
			foreach ($data['tit'] as $tit) {
				$this->prc_tender_quo_item->where_tit($tit['TIT_ID']);
				$pqi = $this->prc_tender_quo_item->ptm_ptv($id, $vnd['PTV_VENDOR_CODE']);
				// $data['pqis'][] = $pqi;
				if ($pqi != null) {
					$pqi = $pqi[0];
					if (intval($pqi['PQI_TECH_VAL']) < intval($data['ptp']['EVT_PASSING_GRADE'])) {
						$pqi['LULUS_TECH'] = false;
						$data['vendor_galulus'][] = $vnd['PTV_VENDOR_CODE'];
					} else {
						$pqi['LULUS_TECH'] = true;
					}
					$data['pqi'][$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']] = $pqi;
				}
			}
		}
		$data['vendor_galulus'] = array_unique($data['vendor_galulus']);

		if ($data['ptp']['PTP_IS_ITEMIZE'] == 0) {
			foreach ($data['ptv'] as $vnd) {
				/* Ngisi tabel buat pilih pemenang */
				foreach ($data['tit'] as $tit) {
					if (in_array($vnd['PTV_VENDOR_CODE'], $data['vendor_galulus'])) {
						$data['pqi'][$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['LULUS_TECH'] = false;
					}
				}
			}
		}

		// var_dump($data['pqi']);

		foreach ($data['pqi'] as $key => $value) {
			usort($data['pqi'][$key], array($this, "sort_eval"));
		}

		$arr = array();
		foreach ($data['pqi'] as $key => $value) {
			$arr2 = array();
			foreach ($value as $k => $val) {
				$arr2[$val['PTV_VENDOR_CODE']] = $val;
			}
			$arr[$key] = $arr2;
		}
		$data['pqi'] = $arr;
		// echo "====================================================";
		// var_dump($data['pqi']);
		// die();
		/********************************************************************/

		$companyId = $this->authorization->getCompanyId();
		$data['dept'] = $this->adm_dept->get(array('DEPT_COMPANY' => $companyId));

		$this->prc_tender_vendor->where_active();
		$this->prc_tender_vendor->join_vnd_header();
		$data['vendor'] = $this->prc_tender_vendor->ptm($id);

		$ptm = $this->prc_tender_main->prc_tender_main->ptm($id);
		$data['ptm'] = $ptm[0];
		$this->load->library('process');
		$data['next_process'] = $this->process->get_next_process($id);

		if($data['ptp']['PTP_EVALUATION_METHOD_ORI']==3){//2 tahap 2 sampul
			$counter = 0;
			foreach ($data['ptv'] as $val) {
				if ($val['PTV_STATUS_EVAL'] != null && intval($val['PTV_STATUS_EVAL']) >= 2) {
					$counter++;
				}
			}
		}else{
			$pet = $this->prc_evaluation_template->get(array('EVT_ID'=>$data['ptp']['EVT_ID']));
			$ptqm = $this->prc_tender_quo_main->get(array('PTM_NUMBER'=>$id));
			$counter = array();
			foreach ($ptqm as $val) {
				$ptqi = $this->prc_tender_quo_item->get(array('PQM_ID'=>$val['PQM_ID']));
				foreach ($ptqi as $vali) {
					if(intval($vali['PQI_TECH_VAL']) >= intval($pet[0]['EVT_PASSING_GRADE'])){
						$counter[$val['PQM_ID']]=$val['PQM_ID'];
					}
				}
			}
			$counter = count($counter);
		}
		$t = 2;
		foreach ($data['tit'] as $va) {
			$cekCT = $this->snippet->countTender($id,$va['PPI_ID']);
			if($cekCT == 1){
				$t = 1;
			}
		}

		$lanjut = false;
		$just = (int)$data['ptp']['PTP_JUSTIFICATION_ORI'];
		if ($just == 2 || $just >= 5) { //tunjuk langsung
			if($t >= 1 && $counter >= 1){
				$lanjut = true;
			}
		}else{
			if($t == 1 && $counter >= 2){
				$lanjut = true;
			}
			if($t == 2 && $counter >= 1){
				$lanjut = true;
			}
		}
		$data['can_continue'] = $lanjut;
		
		$this->layout->add_js('pages/evaluasi_harga.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		if($data['ptp']['PTP_IS_ITEMIZE'] == 1){
			$this->layout->render('evaluasi_harga',$data);
		}else{
			$this->layout->render('evaluasi_harga_paket',$data);
		}
	}

	private function sort_eval($a, $b) {
		return ($a['LULUS_TECH'] < $b['LULUS_TECH']);
	}

	public function get_emp($dept) {
		$this->load->model('adm_employee');
		$emps = $this->adm_employee->get(array('ADM_POS.DEPT_ID' => $dept));
		echo json_encode(compact('emps'));
	}

	public function assign() {
		// $post = $this->input->post();
		// var_dump($post);
		// exit();
		$this->load->model('prc_evaluator');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_pr_item');
		$this->load->library('process');

		$ptm_number = $this->input->post('ptm_number');

		$user = $this->input->post('user');
		if (empty($user)) {
			redirect('Evaluasi_penawaran/index/' . $ptm_number);
		}
		$ptm = $this->prc_tender_main->ptm($ptm_number);
		$retender = $ptm[0]['PTM_COUNT_RETENDER'];

		$counter = $this->prc_evaluator->get_max_counter($ptm_number, $retender);
		if ($counter == 3) {
			$this->session->set_flashdata('error', 'Assign sudah maksimal.');
			redirect('Evaluasi_penawaran/index/' . $ptm_number);
		}

		$pe['PTM_NUMBER'] = $ptm_number;
		$pe['PE_COUNTER'] = $counter + 1;
		$pe['PE_ITERATION'] = $retender;
		$pe['EMP_ID'] = $user;
		$this->prc_evaluator->insert($pe);
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Evatek','ASSIGN',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Evaluasi_Penawaran/assign','prc_evaluator','insert',$pe);
			//--END LOG DETAIL--//

		$this->process->next_process_user($ptm_number, 'CURRENT', $user, $LM_ID);

			// -- proses kirim email -- //
		$pti = $this->prc_tender_item->get(array('PTM_NUMBER'=>$ptm_number));
		$pri = $this->prc_pr_item->where_ppiId($pti[0]['PPI_ID']);

		$dataUser['EMAIL'] = $this->input->post('email');
		$dataUser['data']['judul'] = 'Evaluasi Teknis';
		$dataUser['data']['nama_pengadaan'] = $ptm[0]['PTM_SUBJECT_OF_WORK'];
		$dataUser['data']['no_pengadaan'] = $ptm[0]['PTM_PRATENDER'];
		$dataUser['data']['no_pr'] = $pri[0]['PPI_PRNO'];
		$dataUser['data']['evaluator'] = 'delegasi';
		
		// $this->kirim_email($dataUser);
			// -- end kirim email -- //

		$this->session->set_flashdata('success', 'success'); 
		redirect('Job_list');
	}

	public function save_harga() {
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_chat');
		$this->load->library('process');

		$id = $this->input->post('ptm_number');
		$next_process = $this->input->post('next_process');

		if ($next_process == '999') { //BATAL
			redirect('Proc_verify_entry/batal/' . $id .'/'.$this->input->post('process_name').'/Evaluasi_penawaran/');
		}

		if ($next_process == '0') { //retender
			redirect('Tender_cleaner/retender/' . $id .'/'.$this->input->post('process_name'));
		}

		$comment_id = $this->comment->get_new_id(); 
		$dataComment = array(
			"PTC_ID" => $comment_id,
			"PTM_NUMBER" => $id,
			"PTC_COMMENT" => '\''.$this->input->post('ptc_comment').'\'',
			"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
			"PTC_NAME" => '\''.$this->authorization->getCurrentName().'\'',
			"PTC_ACTIVITY" => "'Evaluasi Harga'",
			);
		$this->comment->insert_comment_tender($dataComment);
		if ($next_process == 1) {
			$action = 'OK';
		}else if ($next_process == 2) {
			$action = 'SIMPAN DRAFT';
		}else if ($next_process == 5) {
			$action = 'RE EVALUASI';
		}
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),$this->input->post('process_name'),$action,$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_harga','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		if ($next_process == '5') { // re evaluasi
			$this->load->model('prc_evaluator');
			$this->load->model('prc_process_holder');

			$action = 'RE EVALUASI';
			$set['NEXT_PROSES'] = '1';		
			$this->prc_chat->update($set, array('PTM_NUMBER'=>$id));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_harga','prc_chat','update',$set,array('PTM_NUMBER'=>$id));
				//--END LOG DETAIL--//

			$pe = $this->prc_evaluator->get_desc(array('PTM_NUMBER'=>$id));
			
			$h['EMP_ID']=$pe[0]['EMP_ID'];
			$this->prc_process_holder->update($h, array('PTM_NUMBER'=>$id));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_harga','prc_process_holder','update',$h,array('PTM_NUMBER'=>$id));
				//--END LOG DETAIL--//

			$t['PTM_STATUS']=11;
			$this->prc_tender_main->updateByPtm($id, $t);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_harga','prc_tender_main','update',$t,array('PTM_NUMBER'=>$id));
				//--END LOG DETAIL--//

			$this->session->set_flashdata('success', 'success'); 
			redirect('Job_list');
		}

		$tit_weight= (array)$this->input->post('tit_tech_weight');
		$tit_price = (array)$this->input->post('tit_price_weight');
		foreach ($tit_weight as $key => $val) {
			$set['TIT_TECH_WEIGHT']=$val[0];
			$set['TIT_PRICE_WEIGHT']=$tit_price[$key][0];
			$whe = array('TIT_ID'=>$key);
			$this->prc_tender_item->update($set, $whe);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_harga','prc_tender_item','update',$set,$whe);
				//--END LOG DETAIL--//
		}

		foreach ($this->input->post('pqi') as $pqi_id => $value) {
			unset($set);
			$set['PQI_PRICE_VAL'] = $value['priceval'];
			$set['PRICE_NOTE'] = $value['note'];
			$this->prc_tender_quo_item->update($set, array('PQI_ID' => $pqi_id));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_harga','prc_tender_quo_item','update',$set,array('PQI_ID' => $pqi_id));
				//--END LOG DETAIL--//
		}	

		if ($next_process == '1') {
			$set2['NEXT_PROSES'] = '1';		
			$this->prc_chat->update($set2, array('PTM_NUMBER'=>$id));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_harga','prc_chat','update',$set,array('PTM_NUMBER'=>$id));
				//--END LOG DETAIL--//

			$this->process->next_process_assignment($id, 'NEXT', $LM_ID);
		}
		$this->session->set_flashdata('success', 'success'); 
		redirect('Job_list');
	}

	public function save_harga_paket() {
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_chat');
		$this->load->library('process');

		$id = $this->input->post('ptm_number');
		$next_process = $this->input->post('next_process');

		if ($next_process == '999') { //BATAL
			redirect('Proc_verify_entry/batal/' . $id .'/'.$this->input->post('process_name').'/Evaluasi_penawaran/index_harga');
		}

		if ($next_process == '0') { // retender
			redirect('Tender_cleaner/retender/' . $id .'/'.$this->input->post('process_name'));
		}


		$comment_id = $this->comment->get_new_id(); 
		$dataComment = array(
			"PTC_ID" => $comment_id,
			"PTM_NUMBER" => $id,
			"PTC_COMMENT" => '\''.$this->input->post('ptc_comment').'\'',
			"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
			"PTC_NAME" => '\''.$this->authorization->getCurrentName().'\'',
			"PTC_ACTIVITY" => "'Evaluasi Harga'",
			);
		$this->comment->insert_comment_tender($dataComment);
		if ($next_process == 1) {
			$action = 'OK';
		}else if ($next_process == 2) {
			$action = 'SIMPAN DRAFT';
		}else if ($next_process == 5) {
			$action = 'RE EVALUASI';
		}else if ($next_process == 4){
			$action = 'PENAWARAN ULANG';
		}

		//PENAWARAN ULANG ARCHIE
		if ($next_process == '4'){
			$stts = 2;
			$proses = 'Penawaran Kedua';
			$ptm = $this->prc_tender_main->ptm($id);
			$ptm = $ptm[0];
			if ($ptm['PENAWARAN_KE']!=''){
				$this->prc_tender_main->updateByPtm($id, array('PENAWARAN_KE' => $stts+1));
			}else{
				$this->prc_tender_main->updateByPtm($id, array('PENAWARAN_KE' => $stts));
			}
			//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),$proses,$action,$this->input->ip_address()
				);
			$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//
		}else{
			//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),$this->input->post('process_name'),$action,$this->input->ip_address()
				);
			$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//
		}			

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_harga_paket','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		if ($this->input->post('next_process') == '5') { // re evaluasi
			$this->load->model('prc_evaluator');
			$this->load->model('prc_process_holder');

			$set['NEXT_PROSES'] = '1';		
			$this->prc_chat->update($set, array('PTM_NUMBER'=>$id));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_harga_paket','prc_chat','update',$set,array('PTM_NUMBER'=>$id));
				//--END LOG DETAIL--//

			$pe = $this->prc_evaluator->get_desc(array('PTM_NUMBER'=>$id));
			
			$h['EMP_ID']=$pe[0]['EMP_ID'];
			$this->prc_process_holder->update($h, array('PTM_NUMBER'=>$id));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_harga_paket','prc_process_holder','update',$h,array('PTM_NUMBER'=>$id));
				//--END LOG DETAIL--//

			$t['PTM_STATUS']=11;
			$this->prc_tender_main->updateByPtm($id, $t);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_harga_paket','prc_tender_main','update',$t,array('PTM_NUMBER'=>$id));
				//--END LOG DETAIL--//
			$this->session->set_flashdata('success', 'success'); 
			redirect('Job_list');
		}

		$tit_weight= (array)$this->input->post('tit_tech_weight');
		$tit_price = (array)$this->input->post('tit_price_weight');
		foreach ($tit_weight as $key => $val) {
			$set['TIT_TECH_WEIGHT']=$val[0];
			$set['TIT_PRICE_WEIGHT']=$tit_price[$key][0];
			$whe = array('TIT_ID'=>$key);
			$this->prc_tender_item->update($set, $whe);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_harga_paket','prc_tender_item','update',$set,$whe);
				//--END LOG DETAIL--//
		}

		foreach ($this->input->post('pqi') as $pqm_id => $value) {
			unset($set);
			$set['PQI_PRICE_VAL'] = $value['priceval'];
			$set['PRICE_NOTE'] = $value['note'];
			// var_dump($value['priceval']);
			// var_dump($pqm_id);
			$this->prc_tender_quo_item->update($set, array('PQM_ID' => $pqm_id));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_harga_paket','prc_tender_quo_item','update',$set,array('PQM_ID'=>$pqm_id));
				//--END LOG DETAIL--//
			// var_dump($this->prc_tender_quo_item->get(array('PQM_ID' => $pqm_id))); exit();
		}

		if ($next_process == '1') {
			$set2['NEXT_PROSES'] = '1';		
			$this->prc_chat->update($set2, array('PTM_NUMBER'=>$id));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_harga_paket','prc_chat','update',$set,array('PTM_NUMBER'=>$id));
				//--END LOG DETAIL--//

			$this->process->next_process_assignment($id, 'NEXT', $LM_ID);
		}
		$this->session->set_flashdata('success', 'success'); 
		redirect('Job_list');
	}

	public function get_evaluasi_detail(){
		$this->load->model('prc_evaluation_template');
		$this->load->model('prc_preq_template_detail');
		$this->load->model('prc_preq_template_uraian');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_eval_file');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_main');

		$id = $this->input->post('id');
		$id_ptm = $this->input->post('id_ptm');

		$data['ptd'] = $this->prc_preq_template_detail->get(array('PPT_ID' => $id));
		foreach ((array)$data['ptd'] as $key => $val) {
			$ur = $this->prc_preq_template_uraian->get(array('PPD_ID' => $val['PPD_ID']));
			$data['uraian'][$val['PPD_ID']] = $ur;
		}
		$data['pet'] = $this->prc_evaluation_template->get_w_type(array('EVT_ID' => $id));

		$this->prc_tender_vendor->where_active();
		$data['ptv'] = $this->prc_tender_vendor->ptm($id_ptm);
		foreach ((array)$data['ptv'] as $key => $val) {
			$this->prc_eval_file->where_ptm_ptv($id_ptm, $val['PTV_VENDOR_CODE']);
			$ef = $this->prc_eval_file->get();
			foreach ($ef as $e) {
				$data['pef'][$val['PTV_VENDOR_CODE']][$e['TIT_ID']] = $e['EF_FILE'];	
			}		
		}	

		$ptm = $this->prc_tender_main->ptm($id_ptm);
		$ptm = $ptm[0];

		if ($ptm['IS_JASA'] == 1) {
			$this->prc_tender_item->join_pr(true);
		}	

		$data['tit'] = $this->prc_tender_item->get(array('PTM_NUMBER'=>$id_ptm, 'TIT_STATUS <>'=>999));


		/* Ngambil PQI */
		foreach ($data['ptv'] as $vnd) {
			/* Ngisi tabel buat pilih pemenang */
			$i=0;
			foreach ($data['tit'] as $tit) {
				$this->prc_tender_quo_item->where_tit($tit['TIT_ID']);
				$pqi = $this->prc_tender_quo_item->ptm_ptv($id_ptm, $vnd['PTV_VENDOR_CODE']);
				// $data['pqis'][] = $pqi;
				if ($pqi != null) {
					$pqi = $pqi[0];
					$data['pqi'][$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']] = $pqi;
				}

				$data['matnr'] = $tit['PPI_NOMAT'];
				$data['banfn'] = substr($tit['PPI_ID'], 0, 10);
				$data['bnfpo'] = sprintf("%05d", substr($tit['PPI_ID'], 10));

				$data['user_vendor'] = $this->session->userdata('VENDOR_ID');

				$this->load->library('sap_handler');
				$data['return'] = $this->sap_handler->getlongtext(array($data));
				$isi = "";
				foreach ($data['return'] as $var) {
					$isi.=$var['TDLINE']." ";
					// $data['isi'][$var['TYPE']][] = $var['TDLINE'];
				}
				$data['tit'][$i]['longtext'][] = $isi;
				$i++;
			}
		}
		
		$ans = $this->load->view('Evaluasi_penawaran/evaluasi_teknis_template', $data, true);

		echo $ans;
	}

	function uploadAttachment() {
		$this->load->library('encrypt');
		$server_dir = str_replace("\\", "/", FCPATH);
		$upload_dir = UPLOAD_PATH."file_chat/";
		$this->load->library('file_operation');
		$this->file_operation->create_dir($upload_dir);
		$this->load->library('FileUpload');
		$uploader = new FileUpload('uploadfile');
		$ext = $uploader->getExtension(); // Get the extension of the uploaded file
		mt_srand();
		$filename = md5(uniqid(mt_rand())).".".$ext;
		$uploader->newFileName = $filename;
		$result = $uploader->handleUpload($server_dir.$upload_dir);
		if (!$result) {
			exit(json_encode(array('success' => false, 'msg' => $uploader->getErrorMsg(), 'path' => $upload_dir)));
		}
		echo json_encode(array('success' => true, 'newFileName' => $filename, 'upload_dir' => $upload_dir));
	}

	public function deleteFile($fileUpload){		
		$this->load->helper("url");

		$path = './upload/file_chat/'.$fileUpload;
		if(file_exists(BASEPATH.'../upload/file_chat/'.$fileUpload)){
			unlink($path);
		}
	}

	public function save_pesan(){
		$this->load->model('prc_chat');
		$this->load->model('prc_tender_main');
		$this->load->model('vnd_header');
		$ptm = $this->input->post('ptm_number');
		$no_vendor = $this->input->post('vendor');

		$add['PTM_NUMBER'] = $ptm;
		$add['STATUS_PROSES'] = $this->input->post('ptm_status');
		$add['USER_ID'] = $this->session->userdata('ID');
		$add['VENDOR_NO'] = $no_vendor;
		$add['TGL'] = date('d-M-Y g.i.s A');
		$add['PESAN'] = $this->input->post('isi_pesan');
		$add['FILE_UPLOAD'] = $this->input->post('file_pesan');		
		$add['STATUS'] = 'SENT';
		$add['NEXT_PROSES'] = '0';

			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Klarifikasi Teknis dan Harga','KIRIM PESAN',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//
		
		$this->prc_chat->insert($add);
		$tndr_main = $this->prc_tender_main->ptm($ptm);
		$tndr_main = $tndr_main[0];

		$th =' Teknis ';
		if($tndr_main['MASTER_ID']==13){ //evaluasi harga
			$th =' Harga ';
			$set['NEXT_PROSES'] = '0';		
			$this->prc_chat->update($set, array('VENDOR_NO'=>$no_vendor, 'PTM_NUMBER' => $ptm));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Evaluasi_penawaran/save_pesan','prc_chat','update',$set,array('PTM_NUMBER'=>$ptm));
				//--END LOG DETAIL--//
		}

			//--LOG DETAIL--//
		// $this->log_data->detail($LM_ID,'Evaluasi_Penawaran/save_pesan','prc_chat','insert',$add);
			//--END LOG DETAIL--//
		$data['th']=$th;
		$data['nomor_pengadaan']=$tndr_main['PTM_PRATENDER'];
		$data['nama_pengadaan']=$tndr_main['PTM_SUBJECT_OF_WORK'];
		$data['pesan'] = $this->input->post('isi_pesan');
		$vnd = $this->vnd_header->get(array('VENDOR_NO'=>$no_vendor));
		if(!empty($vnd['EMAIL_ADDRESS'])){
			$this->load->library('email');
			$this->config->load('email'); 
			$semenindonesia = $this->config->item('semenindonesia'); 
			$company_name = $this->session->userdata['COMPANY_NAME'];			

			$this->email->initialize($semenindonesia['conf']);
			$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
			$this->email->to($vnd['EMAIL_ADDRESS']);				
			$this->email->cc('pengadaan.semenindonesia@gmail.com');				
			$this->email->subject("Klarifikasi ".$th." eProcurement ".$company_name.".");
			$content = $this->load->view('email/pesan_klarifikasi',$data,TRUE);
			$this->email->message($content);
			$this->email->send();
		}

		echo $this->viewHistoryPesan($ptm);
	}

	public function replay_pesan(){
		$this->load->model('prc_chat');

		$pc = $this->prc_chat->get(array('ID'=>$this->input->post('id')));
		
		echo json_encode($pc[0]);
	}

	public function filter_chat_vendor(){
		$ptm = $this->input->post('ptm_number');
		$vendor_no = $this->input->post('vendor_no');

		echo $this->viewHistoryPesan($ptm, $vendor_no);
	}

	public function viewHistoryPesan($ptm, $vendor_no=null){
		$this->load->model('prc_chat');

		$this->prc_chat->order_tgl();
		$this->prc_chat->join_employee_vendor();
		if($vendor_no){
			$data1 = $this->prc_chat->get(array('PTM_NUMBER'=>$ptm, 'PRC_CHAT.VENDOR_NO'=>$vendor_no));
		}else{
			$data1 = $this->prc_chat->get(array('PTM_NUMBER'=>$ptm));
		}
		$data['pesan']=$data1;
		// die(var_dump($data['pesan']));
		$data['balas'] = true;
		$ans = $this->load->view('Evaluasi_penawaran/history_pesan', $data, true);

		return $ans;
	}

	public function viewDok($file = null){
		$url = str_replace("int-","", base_url());
		$this->load->helper('file');
		$image_path = base_url(UPLOAD_PATH).'/file_chat/'.$file;	

		if (strpos($url, 'semenindonesia.com') !== false) { //server production
			$user_id=url_encode($this->session->userdata['ID']);
			if(empty($file)){
				die('tidak ada attachment.');
			}
			if(file_exists(BASEPATH.'../upload/file_chat/'.$file)){				
				$this->output->set_content_type(get_mime_by_extension($image_path));
				return $this->output->set_output(file_get_contents($image_path));
			}else{
				redirect($url.'View_document_vendor/viewDok_chat/'.$file.'/'.$user_id);
			}

		}else{ //server development
			if(empty($file) || !file_exists(BASEPATH.'../upload/file_chat/'.$file)){
				die('could not be found.');
			}
			
			$this->output->set_content_type(get_mime_by_extension($image_path));
			return $this->output->set_output(file_get_contents($image_path));
		}
	}

	public function search_assign(){
		$this->load->model('adm_employee');
		$company_name = $this->input->post('company');
		$unit = $this->input->post('unit');
		$posisi = $this->input->post('posisi');
		$pegawai = $this->input->post('pegawai');
		
		$compId = $this->session->userdata['EM_COMPANY'];
		if($compId == '2000' || $compId == '5000' || $compId == '7000'){
			$companyId = '2000, 5000, 7000';
		}else{
			$companyId = $compId;
		}

		$data['hasil'] = $this->adm_employee->get_assign($companyId, $company_name, $unit, $posisi, $pegawai);

		echo $this->load->view('Evaluasi_penawaran/view_assign', $data, true);
	}

	public function kirim_email($user){	
		$this->load->library('email');
		$this->config->load('email'); 
		$company_name = $this->session->userdata['COMPANY_NAME'];			
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->to($user['EMAIL']);				
		$this->email->cc('pengadaan.semenindonesia@gmail.com');
		$this->email->subject("Evaluasi Teknis eProcurement ".$company_name.".");
		$content = $this->load->view('email/approval_atasan',$user['data'],TRUE);
		$this->email->message($content);
		$this->email->send();
	}

}
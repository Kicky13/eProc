<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement_release extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library("file_operation");
		$this->load->library('Authorization');
		$this->load->library('comment');
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->load->library('Layout');
		$this->load->library('procurement_job');
		$this->load->model('currency_model');
	}

	public function index($id) {
		$this->procurement_job->check_authorization();
		$this->load->library('form_validation');
		$this->load->library('snippet');
		$this->load->model('app_process_master');
		$this->load->model('adm_doctype_pengadaan');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$ptm = $this->prc_tender_main->ptm($id);
		$data['ptm'] = $ptm[0];
		$this->prc_tender_prep->join_eval_template();
		$data['ptp'] = $this->prc_tender_prep->ptm($id);
		$data['title'] = "Approval Pengadaan";
		// $this->prc_tender_item->join_pr();
		// $data['tit'] = $this->prc_tender_item->ptm($id);
		$this->load->library('process');
		$data['next_process'] = $this->process->get_next_process($id);

		$this->load->model('prc_plan_doc');
		$this->load->model('prc_pr_item');
		
		$ans = '';
		$dokumen = array();
		$dokumens = array();
		$privacy = null;
		$vendor = false;
		$active = true;
		$whatever = null;

		$this->prc_tender_item->join_pr();
		$dokumen['items'] = $this->prc_tender_item->ptm($id);
		$dokumen['itemdoc'] = array();
		foreach ($dokumen['items'] as $val) {
			$dokumens[$val['PPI_ID']] = $val;
			if ($privacy !== null) {
				$this->prc_plan_doc->where_privacy($privacy);
			}
			if ($active) {
				$this->prc_plan_doc->where_active();
			}
			$docs = $this->prc_plan_doc->pritem($val['PPI_ID']);
			$dokumen['itemdoc'][$val['PPI_ID']] = $docs;
		}

		$dok = array();
		$doknames = array();
		$count = 0;
		foreach ($dokumen['itemdoc'] as $key => $value) {
			$ppi_id = $key;
			foreach ($value as $key => $val) {
				$sama = false;
				foreach ($doknames as $index => $nval) {
					if ($nval == $val['PPD_FILE_NAME']) {
						$temp['DECMAT'] = $dokumens[$ppi_id]['PPI_DECMAT'];
						$temp['NOMAT'] = $dokumens[$ppi_id]['PPI_NOMAT'];
						$dok[$index]['item'][] = $temp;
						$sama = true;
						break;
					}	
				}
				if($sama == false){
					$doknames[] = $val['PPD_FILE_NAME'];
					$dok[$count]['nama'] = $val['PPD_FILE_NAME'];
					$dok[$count]['IS_SHARE'] = $val['IS_SHARE'];
					$dok[$count]['PDC_IS_PRIVATE'] = $val['PDC_IS_PRIVATE'];
					$dok[$count]['PDC_NAME'] = $val['PDC_NAME'];
					$dok[$count]['PPD_DESCRIPTION'] = $val['PPD_DESCRIPTION'];
					$dok[$count]['item'][0]['DECMAT'] = $dokumens[$ppi_id]['PPI_DECMAT'];
					$dok[$count]['item'][0]['NOMAT'] =  $dokumens[$ppi_id]['PPI_NOMAT'];
					$count = $count + 1;
				}
				// var_dump($val);
			}
		}

		$this->load->model('prc_add_item');
		$this->prc_add_item->where_ptm($id);
		$data['dokumentambahan'] = $this->prc_add_item->get();

		$data['dokumen'] = $dok;

		$data['detail_item_ptm'] = $this->snippet->detail_item_ptm($id);
		$data['ptm_comment'] = $this->snippet->ptm_comment($id);
		$this->adm_doctype_pengadaan->where_pgrp($data['ptm']['PTM_PGRP']);
		$this->adm_doctype_pengadaan->where_cat('A');
		$data['rfq_type'] = $this->adm_doctype_pengadaan->get();
		
		$this->load->model('adm_cctr');
		$this->load->model('adm_employee');
		$this->load->model('com_jasa_group');
		$this->load->model('prc_tender_vendor');

		$this->adm_cctr->where_kel_com($data['ptm']['KEL_PLANT_PRO']);
		$cctr = $this->adm_cctr->get();
		$data['cctr'] = array_build_key($cctr, 'CCTR');

		$this->prc_tender_prep->join_eval_template();

		$data['buyer'] = $this->adm_employee->find($data['ptm']['PTM_ASSIGNMENT']);

		$this->prc_tender_item->join_pr();
		$data['tit'] = $this->prc_tender_item->ptm($id);
		$data['group_jasa']=$this->com_jasa_group->get_jasa();
		$this->prc_tender_vendor->join_vnd_header();
		$data['vendor_tambahan'] = (array) $this->prc_tender_vendor->get(array('PTM_NUMBER' => $id, 'PTV_NON_DIRVEN' => 1));

		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_datetimepicker();
		$this->layout->add_js('strTodatetime.js');		
		$this->layout->add_js('pages/mydatetimepicker.js');
		$this->layout->add_js('pages/procurement_pengadaan.js');
		$this->layout->add_js('pages/procurement_pengadaan_khususRO.js');
		$this->layout->add_js('plugins/numeral/numeral.js');
		$this->layout->add_js('plugins/numeral/languages/id.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		// thithe hilangkan tambah vendor dan centang tanggal 11 oktober 2017
		$this->layout->add_css('hidden_vendor.css');
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->render('procurement_release', $data);
	}

	public function populate_vendor($ptm_number) { //Vendor Terpilih
		$this->load->model('prc_tender_vendor');
		$data['vendor'] = (array) $this->prc_tender_vendor->get(array('PTM_NUMBER' => $ptm_number, 'PTV_NON_DIRVEN' => NULL));
		echo json_encode($data);
	}

	public function save_bidding() {
		$this->load->library("file_operation");
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_main_log');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_add_item');
		$this->load->model('prc_evaluasi_teknis');
		$this->load->model('prc_tender_approve');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_approve_vendor');
		$this->load->model('prc_approve_tender');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_pr_item');

		$comment_id = $this->comment->get_new_id(); 
		$dataComment = array(
			"PTC_ID"       => $comment_id,
			"PTM_NUMBER"   => $this->input->post('ptm_number'),
			"PTC_COMMENT"  => '\''.$this->input->post('comment').'\'',
			"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
			"PTC_NAME"     => '\''.$this->authorization->getCurrentName().'\'',
			"PTC_ACTIVITY" => "'Approval Pengadaan'",
			);
		$this->comment->insert_comment_tender($dataComment);

		$submit = $this->input->post('harus_pilih');
		$action = 'REJECT';
		if ($submit == "accept") {
			$action = 'OK';
		}
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),$this->input->post('process_name'),$action,$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Procurement_release/save_bidding','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		if ($submit == "accept") {				
			/* UPDATE PTP */
			$ptm_number = $this->input->post('ptm_number');
			$id = $ptm_number;
			$ptp['PTM_NUMBER'] = $ptm_number;
			$ptp['PTP_IS_ITEMIZE'] = $this->input->post('is_itemize');
			if ($this->input->post('ptp_justification') == 5) {
				$ptp['PTP_EVALUATION_METHOD'] = 1;
			} else {
				$ptp['PTP_EVALUATION_METHOD'] = $this->input->post('ptp_evaluation_method');
			}
			$ptp['PTP_PAYMENT_NOTE'] = $this->input->post('ptp_payment_note');
			$ptp['PTP_DELIVERY_NOTE'] = $this->input->post('ptp_delivery_note');
			$ptp['PTP_WARNING_NEGO'] = $this->input->post('ptp_warning_nego');
			$ptp['PTP_REG_OPENING_DATE'] = $this->input->post('ptp_reg_opening_date') != '' ? oracledate(strtotime($this->input->post('ptp_reg_opening_date'))) : '';
			$ptp['PTP_REG_CLOSING_DATE'] = $this->input->post('ptp_reg_closing_date') != '' ? oracledate(strtotime($this->input->post('ptp_reg_closing_date'))) : '';
			$ptp['PTP_PREBID_DATE'] = $this->input->post('ptp_prebid_date') != '' ? oracledate(strtotime($this->input->post('ptp_prebid_date'))) : '';
			$ptp['PTP_DELIVERY_DATE'] = $this->input->post('ptp_delivery_date') != '' ? oracledate(strtotime($this->input->post('ptp_delivery_date'))) : '';
			$ptp['PTP_VALIDITY_HARGA'] = $this->input->post('ptp_validity_harga') != '' ? oracledate(strtotime($this->input->post('ptp_validity_harga'))) : '';
			$ptp['PTP_PREBID_LOCATION'] = $this->input->post('ptp_prebid_location');
			
			if($this->input->post('ptp_justification') == 5){ //Penunjukan Langsung - Repeat Order (RO) 
				$ptp['PTP_BATAS_PENAWARAN'] = 0;
				$ptp['PTP_BAWAH_PENAWARAN'] = 20;
				$ptp['PTP_WARNING'] = 1;
			}else{
				$ptp['PTP_WARNING'] = $this->input->post('ptp_warning');
				$ptp['PTP_BATAS_PENAWARAN'] = $this->input->post('ptp_batas_penawaran') == '' ? 100 : intval($this->input->post('ptp_batas_penawaran'));
				$ptp['PTP_BAWAH_PENAWARAN'] = $this->input->post('ptp_batas_penawaran_bawah') == '' ? 100 : intval($this->input->post('ptp_batas_penawaran_bawah'));
			}

			$ptp['PTP_BATAS_NEGO'] = $this->input->post('ptp_batas_nego') == '' ? 100 : intval($this->input->post('ptp_batas_nego'));
			$jaminan_penawaran = intval($this->input->post('jaminan_penawaran'));
			$ptp['PTP_PERSEN_PENAWARAN'] = $jaminan_penawaran == 1 ? intval($this->input->post('persen_penawaran')) : '';
			$jaminan_pelaksanaan = intval($this->input->post('jaminan_pelaksanaan'));
			$ptp['PTP_PERSEN_PELAKSANAAN'] = $jaminan_pelaksanaan == 1 ? intval($this->input->post('persen_pelaksanaan')) : '';
			$jaminan_pemeliharaan = intval($this->input->post('jaminan_pemeliharaan'));
			$ptp['PTP_PERSEN_PEMELIHARAAN'] = $jaminan_pemeliharaan == 1 ? intval($this->input->post('persen_pemeliharaan')) : '';
			$ptp['PTP_TERM_PAYMENT'] = $this->input->post('ptp_term_payment');
			$ptp['PTP_TERM_DELIVERY'] = $this->input->post('ptp_term_delivery');
			$ptp['PTP_PAYMENT_NOTE'] = $this->input->post('ptp_payment_note');
			$ptp['PTP_DELIVERY_NOTE'] = $this->input->post('ptp_delivery_note');
			$ptp['PTP_VENDOR_NOTE'] = $this->input->post('ptp_vendor_note');

			/* Pembatasan tanggal rfq */
			$rfqdate = oraclestrtotime($ptp['PTP_REG_OPENING_DATE']);
			$quodeadline = oraclestrtotime($ptp['PTP_REG_CLOSING_DATE']);
			$ddate = oraclestrtotime($ptp['PTP_DELIVERY_DATE']);
			$pricedate = oraclestrtotime($ptp['PTP_VALIDITY_HARGA']);
			
			if (($rfqdate > $quodeadline) || ($quodeadline > $ddate)) {
				$this->session->set_flashdata('error', 'Tanggal RFQ harus kurang dari quotation deadline dan tanggal quotation deadline harus kurang dari delivery date');
				redirect('Procurement_release/index/' . $id);
			}
			//*/

			$this->prc_tender_prep->updateByPtm($id, $ptp);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_release/save_bidding','prc_tender_prep','update',$ptp,array('PTM_NUMBER'=>$id));
				//--END LOG DETAIL--//
			
			$oldptm = $this->prc_tender_main->ptm($id);
			$oldptm = $oldptm[0];
			$ptm_number = $id;

			/* UPDATE PTM */
			$ptm['PTM_NUMBER'] = $ptm_number;
			$ptm['PTM_RFQ_TYPE'] = $this->input->post('ptm_rfq_type');
			$ptm['PTM_CURR'] = $this->input->post('ptm_curr');
			if ($this->input->post('ptp_justification') == 5) {
				$ptm['SAMPUL'] = 1;
			} else {
				$ptm['SAMPUL'] = $this->input->post('ptp_evaluation_method');
			}
			$this->prc_tender_main->updateByPtm($id, $ptm);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_release/save_bidding','prc_tender_main','update',$ptm,array('PTM_NUMBER'=>$id));
				//--END LOG DETAIL--//
			//*/

			if ($oldptm['PTM_PRATENDER'] == '') {
				/* transaksi aproval */
				$ptm = $this->prc_tender_main->ptm($id);
				$ptm = $ptm[0];
				$counter = $this->prc_tender_approve->get_max_counter($id, $ptm['PTM_COUNT_RETENDER']);
				$counter = $counter + 1;
				$tap_id = $this->prc_tender_approve->get_id();
				$tap = array(
					'TAP_ID'         => $tap_id,
					'PTM_NUMBER'     => $id,
					'TAP_USER'       => $this->session->userdata['FULLNAME'],
					'TAP_USER_ID'    => $this->authorization->getEmployeeId(),
					'TAP_CREATED_AT' => date('d-M-Y g.i.s A'),
					'TAP_ITERATION'  => $ptm['PTM_COUNT_RETENDER'],
					'TAP_COUNTER'    => $counter,
					);
				$this->prc_tender_approve->insert($tap);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_release/save_bidding','prc_tender_approve','insert',$tap);
					//--END LOG DETAIL--//

				$po = (array)$this->input->post('no_po');
				$net = (array)$this->input->post('netpr');
				$tgl = (array)$this->input->post('tgl');
				
				if($this->input->post('no_po')){
					foreach ($po as $vnd => $dat) {
						foreach ($dat as $ppi_id1 => $no_po) {
							$ponya[$vnd][$ppi_id1]=$no_po[0];
						}
						foreach ($net[$vnd] as $ppi_id2 => $netpr) {
							$netnya[$vnd][$ppi_id2]=$netpr[0];
						}
						foreach ($tgl[$vnd] as $ppi_id3 => $tgl_po) {
							$tglnya[$vnd][$ppi_id3]=$tgl_po[0];
						}
					}
				}
				
				/* update dan simpan vendor */
				$data['PTM_NUMBER'] = $id;
				$this->prc_tender_vendor->delete($data);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_release/save_bidding','prc_tender_vendor','delete',null,$data);
					//--END LOG DETAIL--//
				$tapv['TAP_ID'] = $tap_id;
				$tapv['TAPV_ID'] = $this->prc_tender_approve_vendor->get_id();
				$postvendor = $this->input->post('vendor');
				$postvendor = array_unique($postvendor);
				foreach ($postvendor as $key) {
					$data['PTV_ID'] = $this->prc_tender_vendor->get_id();
					$data['PTV_VENDOR_CODE'] = $key;
					$this->prc_tender_vendor->insert_array($data);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Procurement_release/save_bidding','prc_tender_vendor','insert',$data);
						//--END LOG DETAIL--//

					$tapv['PTV_VENDOR_CODE'] = $key;
					$this->prc_tender_approve_vendor->insert($tapv);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Procurement_release/save_bidding','prc_tender_approve_vendor','insert',$tapv);
						//--END LOG DETAIL--//
					$tapv['TAPV_ID']++;

					if($this->input->post('ptp_justification') == 5){ //Penunjukan Langsung - Repeat Order (RO) 
						$tnd_itm = $this->prc_tender_item->ptm($id);
						foreach ($tnd_itm as $val) {
							$item = array(
								'NO_PO'=>$ponya[$key][$val['PPI_ID']],
								'NETPR'=>intval($netnya[$key][$val['PPI_ID']])*100,
								'TGL_PO'=>$tglnya[$key][$val['PPI_ID']]
								);
							$wher = array('PTM_NUMBER' => $id, 'PPI_ID'=>$val['PPI_ID']);
							$this->prc_tender_item->update($item, $wher);
								//--LOG DETAIL--//
							$this->log_data->detail($LM_ID,'Procurement_release/save_bidding','prc_tender_item','update',$item,$wher);
								//--END LOG DETAIL--//
						}
					}

				}

				//proses insert vendor tambahan / Vendor Non Dirven
				if ($this->input->post('vendor_tambahan') != false) {
					$tapv['TAPV_ID'] = $this->prc_tender_approve_vendor->get_id();
					
					$postvendor = $this->input->post('vendor_tambahan');
					$postvendor = array_unique($postvendor);
					foreach ($postvendor as $key) {
						$data['PTV_ID'] = $this->prc_tender_vendor->get_id();
						$data['PTV_VENDOR_CODE'] = $key;
						$data['PTV_NON_DIRVEN'] = '1'; // 1=VENDOR NON DIRVEN
						$this->prc_tender_vendor->insert_array($data);
							//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Procurement_release/save_bidding','prc_tender_vendor','insert',$data);
							//--END LOG DETAIL--//

						$tapv['PTV_VENDOR_CODE'] = $key;
						$this->prc_tender_approve_vendor->insert($tapv);
							//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Procurement_release/save_bidding','prc_tender_approve_vendor','insert',$tapv);
							//--END LOG DETAIL--//
						$tapv['TAPV_ID']++;
					}
				}
				//*/
			}

			$this->load->model('prc_plan_doc');
			$doc = $this->input->post('share');
			if ($doc != false) {
				foreach ((array) $doc as $key => $value) {
					$name =  str_replace("_", ".", $key);
					$this->prc_plan_doc->update(array("IS_SHARE" => $value), array('PPD_FILE_NAME' => $name));
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Procurement_release/save_bidding','prc_plan_doc','update',array("IS_SHARE" => $value), array('PPD_FILE_NAME' => $name));
						//--END LOG DETAIL--//
				}
			}

			// $this->prc_tender_main->join_app_process();
			$this->load->library('process');
			$process = $this->prc_tender_main->ptm($id);
			$process = $process[0];
			if ($process['IDENTITAS_PROCCESS'] == 2) {
				$this->generate_rfq($id,$LM_ID);
				$this->prc_tender_main->updateByPtm($id, array('IS_VENDOR_CLOSED' => 0));
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_release/save_bidding','prc_tender_main','update',array('IS_VENDOR_CLOSED' => 0), array('PTM_NUMBER' => $id));
					//--END LOG DETAIL--//

				$tnd_itm = $this->prc_tender_item->ptm($id);
				foreach ($tnd_itm as $t) {					
					$ppri = $this->prc_pr_item->where_ppiId($t['PPI_ID']);
					$count_tender = (int) $ppri[0]['COUNT_TENDER'];

					/* Ngeset count tender */
					$setpritem = array('COUNT_TENDER' => $count_tender + 1);
					$wherepritem = array('PPI_ID' => $t['PPI_ID']);
					$this->prc_pr_item->update($setpritem, $wherepritem);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Procurement_release/save_bidding','prc_pr_item','update',$setpritem,$wherepritem);
						//--END LOG DETAIL--//
						//*/
				}

				$this->process->next_process_assignment($id, 'NEXT', $LM_ID);

				return $this->create_uraian($id, $LM_ID);
			} else {
				$this->process->next_process($id, 'NEXT', $LM_ID);
			}

			$this->session->set_flashdata('success', 'success'); redirect('Job_list');

		}else{
			$id=$this->input->post('ptm_number');
			$this->load->model('prc_tender_item');
			$this->load->model('prc_pr_item');
			$this->load->model('prc_tender_main');
			$this->load->model('adm_employee');
			$this->load->library('snippet');
			
			$item = $this->prc_tender_item->ptm($id);
			foreach ($item as $key => $value) {
				$pr_item = $this->prc_pr_item->get(array('PPI_ID'=>$value['PPI_ID']));
				$this->prc_pr_item->update(array('PPI_QTY_USED' => $pr_item[0]['PPI_QTY_USED'] - $value['TIT_QUANTITY']), array('PPI_ID'=>$pr_item[0]['PPI_ID']));
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_release/save_bidding','prc_pr_item','update',array('PPI_QTY_USED' => $pr_item[0]['PPI_QTY_USED'] - $value['TIT_QUANTITY']), array('PPI_ID'=>$pr_item[0]['PPI_ID']));
					//--END LOG DETAIL--//
			}
			$data = $this->prc_tender_main->ptm($id);
			$this->prc_tender_main->updateByPtm($id, array('PTM_STATUS' => $data['0']['PTM_STATUS'] * - 1 ));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_release/save_bidding','prc_tender_main','update',array('PTM_STATUS' => $data['0']['PTM_STATUS'] * - 1 ), array('PTM_NUMBER' => $id));
				//--END LOG DETAIL--//

			$emp = $this->adm_employee->get(array('ID'=>$data[0]['PTM_REQUESTER_ID']));
			$user['EMAIL'] = $emp[0]['EMAIL'];
			$user['data']['ptm_subpratender'] = $data[0]['PTM_SUBPRATENDER'];
			$user['data']['rejector'] = $this->session->userdata['FULLNAME'];
			$user['data']['tgl_reject'] = date('d-M-Y H:i:s');
			$user['data']['komentar'] = $this->input->post('comment');
			$user['data']['detail_item']=$this->snippet->detail_item_ptm($id,false,true);
			
			require_once(APPPATH.'/modules/Procurement_pratender/controllers/Procurement_pratender.php');
			$aObj = new Procurement_pratender();
			$aObj->kirim_email_reject($user);

			$this->session->set_flashdata('reject', 'reject'); redirect('Job_list');
		}

	}

	public function save_bidderlist($id) {
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_purchase_requisition');
		$this->load->library('sap_handler');

		$ptm = $this->prc_tender_main->ptm($id);
		$ptm = $ptm[0];
		$ptp = $this->prc_tender_prep->ptm($id);
		$this->prc_tender_item->join_item();
		$tit = $this->prc_tender_item->ptm($id);
		$ptv = $this->prc_tender_vendor->get_join(array('PTM_NUMBER' => $id));
		
		$matkl = $tit[0]['PPI_MATGROUP'];
		$desc = $ptm['PTM_SUBJECT_OF_WORK'];
		$just = $ptp['PTP_JUSTIFICATION_ORI'];
		foreach ($tit as $val) {
			$pritem[] = array(
				'prno' => $val['PPI_PRNO'],
				'pritem' => $val['PPI_PRITEM'],
				'qty' => $val['TIT_QUANTITY'],
				'uom' => $val['PPI_UOM'],
				);
		}
		foreach ($ptv as $val) {
			$tab[] = array('vendor_no' => $val['PTV_VENDOR_CODE'], 'vendor_name' => $val['VENDOR_NAME'], 'matkl' => $matkl);
		}
		$pr0 = $this->prc_purchase_requisition->pr($pritem[0]['prno']);
		$ekorg = $pr0['PPR_PORG'];
		$ekgrp = $pr0['PPR_PGRP'];
		if ($ekorg == '') {
			$ekorg = pgrp_to_porg($ekgrp);
		}
		// var_dump(compact('matkl', 'desc', 'just', 'pritem', 'tab', 'ekorg', 'ekgrp')); exit();

		return $this->sap_handler->save_bidderlist($matkl, $desc, $just, $pritem, $tab, $ekorg, $ekgrp);
	}

	public function generate_rfq($ptm_number, $LM_ID) {
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_purchase_requisition');

		$ptm = $this->prc_tender_main->ptm($ptm_number);
		$ptm = $ptm[0];
		$ptp = $this->prc_tender_prep->ptm($ptm_number);

		//var_dump($ptp);die;
		$this->prc_tender_item->join_item();
		$tit = $this->prc_tender_item->ptm($ptm_number);
		$pr0 = $this->prc_purchase_requisition->pr($tit[0]['PPI_PRNO']);

		$error = false;

		$rfqdate = oraclestrtotime($ptp['PTP_REG_OPENING_DATE']);
		$quodeadline = oraclestrtotime($ptp['PTP_REG_CLOSING_DATE']);
		$ddate = oraclestrtotime($ptp['PTP_DELIVERY_DATE']);
		$pricedate = oraclestrtotime($ptp['PTP_VALIDITY_HARGA']);

		$termdelivery = $ptp['PTP_TERM_DELIVERY'];
		$deliverynote = $ptp['PTP_DELIVERY_NOTE'];
		
		if (($rfqdate > $quodeadline) || ($quodeadline > $ddate)) {
			$this->session->set_flashdata('error', 'Tanggal RFQ harus kurang dari quotation deadline dan tanggal quotation deadline harus kurang dari delivery date');
			redirect('Procurement_release/index/' . $ptm_number);
		}

		$rfqdate = date('Ymd', $rfqdate);
		$quodeadline = date('Ymd', $quodeadline);
		$ddate = date('Ymd', $ddate);
		$pricedate = date('Ymd', $pricedate);

		$rfqtype = $ptm['PTM_RFQ_TYPE'];
		$ekorg = $pr0['PPR_PORG'];
		$ekgrp = $pr0['PPR_PGRP'];
		
		$ekorg = pgrp_to_porg($ekgrp);
		$tambahaninfo = '';

		if ($ptm['PTM_PRATENDER'] != null) {
			$bidderlist = null;
			$bidnumber = $ptm['PTM_PRATENDER'];
		} else {
			$bidderlist = $this->save_bidderlist($ptm_number);
			$bidnumber = '';
		}
		if (empty($bidderlist)) {
			// do nothing
		} else {
			$bidnumber = $bidderlist[0]['MESSAGE'];
			$new_update['PTM_PRATENDER'] = $bidnumber;
			$this->prc_tender_main->updateByPtm($ptm_number, $new_update);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_release/generate_rfq','prc_tender_main','update',$new_update,array('PTM_NUMBER' => $ptm_number));
				//--END LOG DETAIL--//
			$tambahaninfo .= ' Nomor Pratender: '.$bidnumber.'.';
			$this->session->set_flashdata('tambahaninfo', $tambahaninfo);
		}
		
		$this->load->library('sap_handler');
		// var_dump(compact('rfqtype', 'rfqdate', 'quodeadline', 'ddate', 'ekorg', 'ekgrp', 'bidnumber','pricedate','termdelivery','deliverynote'));die;
		$data = $this->sap_handler->getRfq($rfqtype, $rfqdate, $quodeadline, $ddate, $ekorg, $ekgrp, $bidnumber, $pricedate,$termdelivery,$deliverynote);
		$rfq = $data['rfq'];
		$error = false;
		if (isset($data['O_ANGDT']) && $data['O_ANGDT'] != '00000000') {
			list($y, $m, $d) = sscanf($data['O_ANGDT'], '%04d%02d%02d');
			$newdate = date('d-M-y', strtotime($d .'-'.$m .'-'.$y));
			$newdate = $newdate .' '. date('g.i.s A', oraclestrtotime($ptp['PTP_REG_CLOSING_DATE']));
			$updateptp['PTP_REG_CLOSING_DATE'] = $newdate;
			$tambahaninfo .= ' Updated Quotation Deadline from SAP: '.$newdate.'.';
			$this->session->set_flashdata('tambahaninfo', $tambahaninfo);
		}
		if (isset($data['O_PRICEDATE']) && $data['O_PRICEDATE'] != '00000000') {
			list($y, $m, $d) = sscanf($data['O_PRICEDATE'], '%04d%02d%02d');
			$newdate = date('d-M-y', strtotime($d .'-'.$m .'-'.$y));
			$newdate = $newdate .' '. date('g.i.s A', oraclestrtotime($ptp['PTP_VALIDITY_HARGA']));
			$updateptp['PTP_VALIDITY_HARGA'] = $newdate;
			$tambahaninfo .= ' Updated Validity Date from SAP: '.$newdate.'.';
			$this->session->set_flashdata('tambahaninfo', $tambahaninfo);
		}
		if (isset($updateptp)) {
			$this->prc_tender_prep->updateByPtm($ptm_number, $updateptp);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_release/generate_rfq','prc_tender_prep','update',$updateptp,array('PTM_NUMBER' => $ptm_number));
				//--END LOG DETAIL--//
		}
		if (!empty($rfq)) {
			foreach ($rfq as $val) {
				$rfq = $val['EBELN'];
				if (empty($rfq)) {
					$error = true;
					continue;
				}
				$where['PTV_VENDOR_CODE'] = $val['LIFNR'];
				$where['PTM_NUMBER'] = $ptm_number;
				$set['PTV_RFQ_NO'] = $rfq;
				$this->prc_tender_vendor->update($set, $where);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_release/generate_rfq','prc_tender_vendor','update',$set,$where);
					//--END LOG DETAIL--//
				// $error = true;
			}

			//proses menyiapkan data dan mengirimkan email
			$ptv=$this->prc_tender_vendor->ptm($ptm_number);
			
			/*/catatan:
			jika ada 1 vendor terpilih saja yang tidak mendapatkan nomor RFQ 
			maka seluruh vendor pada tender tidak jadi dikirimi email.
			/*/
			$jadiemail=true;
			$error_message="";
			foreach ($ptv as $value) {
				if(empty($value['PTV_RFQ_NO'])){
					$jadiemail=false;
					$error = true;
					$error_message.=$value['VENDOR_NAME'].", ";
				}
			}
			// var_dump($ptv);die;
			if($jadiemail){
				foreach ($ptv as $value) {
					$prebid_date = '';
					$prebid_loc = '';
					if (!empty($ptp['PTP_PREBID_DATE'])) {
						$prebid_date = date('d M Y g.i.s A',oraclestrtotime($ptp['PTP_PREBID_DATE']));
						$prebid_loc = $ptp['PTP_PREBID_LOCATION'];
					}
					$vendor['EMAIL_ADDRESS']=$value['EMAIL_ADDRESS'];
					$dataemail=array('noptm'=>$bidnumber,
						'norfq'=>$value['PTV_RFQ_NO'],
						'rfqdate'=>date('d M Y g.i.s A', oraclestrtotime($ptp['PTP_REG_OPENING_DATE'])),
						'quodeadline'=>isset($updateptp)?$updateptp['PTP_REG_CLOSING_DATE']:date('d M Y g.i.s A',oraclestrtotime($ptp['PTP_REG_CLOSING_DATE'])),
						'aanwizjigdate'=>$prebid_date,
						'aanwizjiglocation'=>$prebid_loc );
					$vendor=array_merge($vendor,array('data'=>$dataemail));				
					// var_dump($vendor);die;
					$this->kirim_email_rfq($vendor);
				}
			}else{
				$tambahaninfo .= "<br>Vendor belum mendapatkan nomor RFQ: ".$error_message;
				$this->session->set_flashdata('tambahaninfo', $tambahaninfo);
			}
			
		} else {
			$error = true;
		}

		// echo "<pre>";
		// print_r($data);die;

		if ($error) {
			// echo 'gagal membuat rfq<br>';die;
			// var_dump($data);
			$buat_rfq = compact('rfqtype', 'rfqdate', 'quodeadline', 'ddate', 'ekorg', 'ekgrp', 'bidnumber', 'pricedate','termdelivery','deliverynote');
			// var_dump($buat_rfq);
			$this->session->set_flashdata('create_rfq', $buat_rfq);
			$this->session->set_flashdata('hasil_rfq', $data);
			redirect('Procurement_release/index/' . $ptm_number);
			exit();
		} else {
			// echo 'tidak gagal membuat rfq<br>';die;
			$tambahaninfo .= ' Berhasil membuat RFQ.';
			$this->session->set_flashdata('tambahaninfo', $tambahaninfo);
		}
	}

	public function create_uraian($id, $LM_ID) {
		$this->load->model('prc_evaluasi_teknis');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_preq_template_uraian');
		$this->load->model('prc_evaluasi_uraian');

		$pet = $this->prc_evaluasi_teknis->get(array('PTM_NUMBER' => $id));
		$tit = $this->prc_tender_item->ptm($id);

		$new_eu['PTM_NUMBER'] = $id;
		foreach ($pet as $val) {
			foreach ($tit as $item) {
				$new_eu['TIT_ID'] = $item['TIT_ID'];
				$new_eu['ET_ID'] = $val['ET_ID'];
				$pptu = $this->prc_preq_template_uraian->get(array('PPD_ID' => $val['PPD_ID']));
				foreach ($pptu as $uraian) {
					$new_eu['EU_ID'] = $this->prc_evaluasi_uraian->get_id();
					$new_eu['EU_NAME'] = $uraian['PPTU_ITEM'];
					$this->prc_evaluasi_uraian->insert($new_eu);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Procurement_release/create_uraian','prc_evaluasi_uraian','insert',$new_eu);
						//--END LOG DETAIL--//
				}
			}
		}

		$this->session->set_flashdata('success', 'success'); redirect('Job_list');
	}

	public function kirim_email_rfq($vendor){	
		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->to($vendor['EMAIL_ADDRESS']);				
		$this->email->cc('pengadaan.semenindonesia@gmail.com');				
		$this->email->subject("Undangan Penawaran dari eProcurement ".$this->session->userdata['COMPANYNAME'].".");
		$content = $this->load->view('email/undangan_tender',$vendor['data'],TRUE);
		$this->email->message($content);
		$this->email->send();
	}

}
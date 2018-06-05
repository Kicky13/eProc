<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement_sap extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model('adm_cctr');
		$this->load->model('adm_doctype_pengadaan');
		$this->load->model('adm_plant');
	}

	public function index() {
		$data['title'] = "Verifikasi PR";
		$data['istor'] = 'false';
		$data['success'] = $this->session->flashdata('success') == 'success';
		$data['reject'] = $this->session->flashdata('success') == 'reject';
		$data['terverifikasi'] = $this->session->flashdata('success') == 'terverifikasi';
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/list_pr.js?1');
		$this->layout->render('list_pr', $data);
	}

	public function rejectPR($id = null) {
		if($id === null){
			$this->load->model(array('prc_pr_verify'));
			$data['title'] = "Rejected PR";
			$this->layout->set_table_js();
			$this->layout->set_table_cs();
			$this->layout->add_js('pages/reject_pr.js');
			$this->layout->render('list_reject', $data);
		} else {
			$data['title'] = "Detail Rejected PR" . $id;
			$this->load->model(array('prc_item_verify','prc_pr_verify'));

			$data['pr'] = $this->prc_pr_verify->ppv_id($id);
			$data['pr'] = $data['pr']['0'];

			$this->prc_item_verify->where_ppvid($id);
			$data['item'] = $this->prc_item_verify->get();
			
			// $desc = $data["data"]["0"]["PIV_DESCRIPTION"];
			// $des = explode(";",$desc);

			// $pritem = explode(":",$des[0]);
			// $kode = explode(":",$des[1]);
			// $nama = explode(":",$des[2]);
			// $harga = explode(":",$des[3]);
			// $prqty = explode(":",$des[4]);
			// $openqty = explode(":",$des[5]);
			// $poqty = explode(":",$des[6]);
			// $handqty = explode(":",$des[7]);

			// $data['pritem'] = $pritem;
			// $data['kode'] = $kode;
			// $data['nama'] = $nama;
			// $data['harga'] = $harga;
			// $data['prqty'] = $prqty;
			// $data['openqty'] = $openqty;
			// $data['poqty'] = $poqty;
			// $data['handqty'] = $handqty;


			$this->layout->set_table_js();
			$this->layout->set_table_cs();
			$this->layout->render('detail_reject', $data);
		}
	}

	public function get_datatablereject($status = null) {
		$this->load->model(array('prc_pr_verify'));
		$opco = $this->session->userdata['COMPANYID'];
		if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
			$new_opco = '7000,2000,5000';
		} else {
			$new_opco = $opco;
		}
		$this->prc_pr_verify->join_item_verify();
		$this->prc_pr_verify->join_pucrh_group();
		$this->prc_pr_verify->where_ppvstatus("0");
		$this->prc_pr_verify->where_opco($new_opco);
		$datatable = $this->prc_pr_verify->get_prReject("1");
		if(isset($datatable)){
			foreach ($datatable as $key => $val) {
				$datatable[$key]['PPV_DATE'] = betteroracledate(oraclestrtotime($val['PPV_DATE']));
			}
		}
		$data['data']='';
		if(!empty($datatable)){
			$data['data'] = $datatable;
		}

		echo json_encode($data);
		//var_dump($datatable);;
	}

	public function get_datatable($isnottor = true) {
		$this->load->model('v_header_pr');
		$this->load->library('sap_handler');
		

		$this->adm_cctr->where_kel_com($this->session->userdata('KEL_PRGRP'));
		$cctr = $this->adm_cctr->get();
		$cctr = array_build_key($cctr, 'CCTR');
		$doctype = $this->adm_doctype_pengadaan->get();
		$doctype = array_build_key($doctype, 'TYPE');
		$plant = $this->adm_plant->get();
		$plant = array_build_key($plant, 'PLANT_CODE');
		// var_dump($cctr);
		// echo 'abcdasdasd';

		$colom = array(
					'V_HEADER_PR.PPR_PRNO',
					'V_HEADER_PR.PPI_DECMAT',
					'V_HEADER_PR.PPR_DOCTYPE',
					'V_HEADER_PR.PPR_DOC_CAT',
					'V_HEADER_PR.PPR_DEL',
					'V_HEADER_PR.PPR_PORG',
					'V_HEADER_PR.PPR_REQUESTIONER',
					'V_HEADER_PR.PPR_CREATED_BY',
					'V_HEADER_PR.PPR_STTVER',
					'V_HEADER_PR.PPR_STT_TOR',
					'V_HEADER_PR.PPR_STT_CLOSE',
					'V_HEADER_PR.PPR_DATE_RELEASE',
					'V_HEADER_PR.PPR_LAST_UPDATE',
					'V_HEADER_PR.PPR_PGRP',
					'V_HEADER_PR.PPR_ASSIGNEE',
					'V_HEADER_PR.PPI_PR_ASSIGN_TO',
					'V_HEADER_PR.PPI_TGL_ASSIGN',
					'V_HEADER_PR.PPR_PLANT',
					'V_HEADER_PR.DOC_UPLOAD_COUNTER',
					'V_HEADER_PR.DOC_UPLOAD_DATE',
			);
		$select_colom = implode(', ', $colom);
		$this->v_header_pr->select($select_colom);
		$this->v_header_pr->where_close(0);
		
		if ($isnottor === true) {
			$this->v_header_pr->join_adm_pucrh_grp();
			$this->v_header_pr->where_tor(1);
			$this->v_header_pr->where_sttver(array(1,2));
			$this->v_header_pr->where_pgrp_in($this->session->userdata('PRGRP'));

		} else {
			$this->v_header_pr->join_pr_item();

			if($this->session->userdata('COMPANYID')=='3000' || $this->session->userdata('COMPANYID')=='4000'){ //PADANG and TONASA
				$this->load->model('adm_employee');
				$emp = $this->adm_employee->get(array('ID'=>$this->session->userdata('ID')));

				$this->v_header_pr->where_requestioner($emp[0]['MKCCTR']);
			}else if ($this->session->userdata('COMPANYID')=='2000' || $this->session->userdata('COMPANYID')=='5000' || $this->session->userdata('COMPANYID')=='7000') { // GRESIK, INDONESIA Tbk, INDONESIA VO 

				$this->v_header_pr->join_mrpc();
				$this->v_header_pr->where_emp($this->session->userdata('ID'));				
			}

			$this->v_header_pr->where_tor(0);			
			$this->v_header_pr->where_sttver(array(1,2));
		}


		$data1 = $this->v_header_pr->get();

		$data_table = array();
		foreach ($data1 as $line){
			$data_tbl = array();
			$data_tbl['PPR_PRNO'] 			= $line['PPR_PRNO']; 
			$data_tbl['PPI_DECMAT'] 			= $line['PPI_DECMAT']; 
			$data_tbl['PPR_DOCTYPE'] 		= $line['PPR_DOCTYPE'] . ' ' . (isset($doctype[$line['PPR_DOCTYPE']]) ? $doctype[$line['PPR_DOCTYPE']]['DESC'] : '');
			$data_tbl['PPR_DOC_CAT'] 		= $line['PPR_DOC_CAT'];
			$data_tbl['PPR_DEL'] 			= $line['PPR_DEL'];
			$data_tbl['PPR_PORG'] 			= $line['PPR_PORG'];
			$data_tbl['PPR_REQUESTIONER'] 	= isset($cctr[$line['PPR_REQUESTIONER']]) ? $cctr[$line['PPR_REQUESTIONER']]['LONG_DESC'] : '';
			// $data_tbl['PPR_REQUESTIONER'] 	= $line['PPR_REQUESTIONER'];
			$data_tbl['PPR_STTVER'] 		= $line['PPR_STTVER'];
			$data_tbl['PPR_CREATED_BY'] 	= $line['PPR_CREATED_BY'];
			$data_tbl['PPR_STT_TOR'] 		= $line['PPR_STT_TOR'];
			$data_tbl['PPR_STT_CLOSE'] 		= $line['PPR_STT_CLOSE'];
			$data_tbl['PPR_DATE_RELEASE'] 	= date('d-M-y', oraclestrtotime($line['PPR_DATE_RELEASE']));
			$data_tbl['PPR_LAST_UPDATE'] 	= $line['PPR_LAST_UPDATE'];
			$data_tbl['PPR_PGRP'] 			= $line['PPR_PGRP'];
			$data_tbl['PPI_EMPLOYEE_ID'] 	= $line['PPR_ASSIGNEE'];
			$data_tbl['PPI_USER_ASSIGN'] 	= $line['PPI_PR_ASSIGN_TO'];
			$data_tbl['PPI_TGL_ASSIGN'] 	= $line['PPI_TGL_ASSIGN'];
			$data_tbl['PPR_PLANT'] 			= $line['PPR_PLANT'] . ' ' . (isset($plant[$line['PPR_PLANT']]) ? $plant[$line['PPR_PLANT']]['PLANT_NAME'] : '');
			$data_tbl['DOC_UPLOAD_COUNTER'] = $line['DOC_UPLOAD_COUNTER'];
			$data_tbl['DOC_UPLOAD_DATE'] 	= betteroracledate(oraclestrtotime($line['DOC_UPLOAD_DATE']));
			// $data_tbl['HEADER_TEXT']		= $this->sap_handler->getprheadertext($line['PPR_PRNO']);
			
			$data_table[] = $data_tbl;
		}

		$json_data = array('data' => (array) $data_table); 

		echo json_encode($json_data);
	}

	/* Tampilkan view verifikasi PR */
	public function detail_pr($pr = null)
	{
		if ($pr == null) redirect('Procurement_sap');
		$this->load->helper(array('form', 'url'));
		$this->load->model('prc_purchase_requisition');
		$this->load->model('prc_pr_item');
		$this->load->model('app_process_log');

		$data['pr'] = $this->prc_purchase_requisition->pr($pr);
		$data['items'] = $this->prc_pr_item->pr($pr);
		$data['prno'] = $pr;
		$data['title'] = 'Verifikasi Item';

		$this->adm_cctr->where_kel_com($this->session->userdata('KEL_PRGRP'));
		$cctr = $this->adm_cctr->get();
		$data['cctr'] = array_build_key($cctr, 'CCTR');

		$this->load->model('prc_plan_doc');
		$this->load->model('com_mat_group');

		$data['doctype'] = $this->adm_doctype_pengadaan->find($data['pr']['PPR_DOCTYPE']);

		$data['plant'] = $this->adm_plant->find($data['pr']['PPR_PLANT']);

		foreach ($data['items'] as $key => $value) {
			$this->prc_plan_doc->where_active();
			if(count($this->prc_plan_doc->pritem($value['PPI_ID'])) <= null){
				$data['items'][$key]['doc'] = false;
			} else {
				$data['items'][$key]['doc'] = true;
			}
			$data['items'][$key]['matgrp'] = $this->com_mat_group->find($value['PPI_MATGROUP']);
		}
		// var_dump($data['items']);
		// die();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/detail_pr.js');
		$this->layout->render('detail_pr',$data);
	}

	/* Verifikasi PR */
	public function store() {
		$this->load->model('prc_pr_verify');
		$this->load->model('prc_pr_item');
		$this->load->model('prc_item_verify');
		$this->load->model('app_process_log');
		$this->load->model('prc_purchase_requisition');
		$this->load->model('adm_employee');
		// var_dump($this->input->post()); exit();

		/* ngecek apakah udah diverif atau belom */
		$prwhere = array('PPR_PRNO' => $this->input->post('prno')); 
		$prcek = $this->prc_purchase_requisition->get($prwhere);
		$prcek = $prcek[0];
		if ($prcek['PPR_STTVER'] == 1 || $prcek['PPR_STTVER'] == 2) {
			$this->session->set_flashdata('success', 'terverifikasi');
			redirect('Procurement_sap/index');
		}

		/* Ngeverifikasi PR nya */
		$ppr['PPV_ID'] = $this->prc_pr_verify->get_id();
		$ppr['PPV_PRNO'] = $this->input->post('prno');
		$ppr['PPV_STATUS'] = $this->input->post('isverify'); // 0 reject 1 accept
		$ppr['PPV_DATE'] = date('d-M-Y g.i.s A');
		$ppr['PPV_USER'] = $this->session->userdata['FULLNAME'];
		
		$this->prc_pr_verify->insert_or_update($ppr);

			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Verifikasi Item','SUBMIT',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Procurement_sap/store','prc_pr_verify','insert_or_update',$ppr,array('PPV_PRNO'=>$this->input->post('prno')));
			//--END LOG DETAIL--//

		$method = (array)$this->input->post('metode');
		foreach ((array)$this->input->post('items') as $key => $val) {
			$set['METODE']=$method[$key];
			$where = array('PPI_ID'=>$val);
			if($method[$key]){
				$this->prc_pr_item->update($set, $where);	
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_sap/store','prc_pr_item','update',$set,$where);
					//--END LOG DETAIL--//			
			}
			unset($set);
			unset($where);
		}

		/* ngereject, kalau ada yg direject */

		$status_reject = 2; // 2 untuk sukses, 1 untuk doc, 0 untuk item
		$comment_all = '';
		if (($this->input->post('itemreject'))) {
			$log = array();
			$pivs = array();
			// $temp['PRNO'] = $this->input->post('prno');
			// $temp['CREATED_BY'] = $this->session->userdata['FULLNAME'];
			// $temp['CREATED_DATE'] = date('d-M-Y g.i.s A');
			// $temp['ID_LOG'] = $this->app_process_log->get_id();
			// $temp['PROCESS_NAME'] = 'REJECTPR';
			$piv['PPV_ID'] = $ppr['PPV_ID'];
			$piv['PIV_PRNO'] = $ppr['PPV_PRNO'];
			$piv['PIV_ID'] = $this->prc_item_verify->get_id();

			$arr_rject = array();
			$status_reject = 2; // 2 untuk sukses, 1 untuk doc, 0 untuk item
			for ($i=0; $i < count($this->input->post('itemreject')); $i++) {
				$itemreject = $this->input->post('itemreject');
				$itemreject = $itemreject[$i];
				$detailreject = $this->input->post('detailreject');
				$detailreject = $detailreject[$i];
				$commentreject = $this->input->post('commentreject');
				$commentreject = $commentreject[$i];
				////////////////////////////////// tambahin is_doc sama is_item
				$radio = $this->input->post('reject');
				$radio = intval($radio[$itemreject]);
				$piv['PIV_IS_DOC'] = $radio == 1 ? '1' : '0';
				$piv['PIV_IS_ITEM'] = $radio == 0 ? '1' : '0';
				// if ($radio < $status_reject) {
				// 	$status_reject = $radio;
				// }
				$arr_rject[] = $radio;

				// $temp['PRITEM'] = $itemreject;
				// $temp['STATUS'] = $detailreject.$commentreject;
				$piv['PIV_PRITEM'] = $itemreject;
				$piv['PPI_ID'] = $ppr['PPV_PRNO'].$itemreject;
				$piv['PIV_DESCRIPTION'] = $detailreject;
				$piv['PIV_NOTE'] = $commentreject;

				$comment_all .= $commentreject . '\n';
				// $log[] = $temp;
				$pivs[] = $piv;
				$piv['PIV_ID']++;
				// $temp['ID_LOG']++;
			}
			$status_reject = 1;
			foreach ($arr_rject as $val) {
				if($val == '0'){
					$status_reject = 0;
				}				
			}			
	
			// $this->app_process_log->insert_batch($log);
			$this->prc_item_verify->insert_batch($pivs);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_sap/store','prc_item_verify','insert',$pivs);
				//--END LOG DETAIL--//	
		}
		//*/
	
		/**
		 * ngeset status dari PR nya itu. select(status_reject)
		 *   (0)(0) direject item,     maka sttver = 2, sttor = 0
		 *   (1)(0) direject document, maka sttver = 0, sttor = 0
		 *   (2)(1) accept,            maka sttver = 1, sttor = 1
		 */
		$isverify = $this->input->post('isverify');
		$prwhere = array('PPR_PRNO' => $this->input->post('prno')); 
		$prcek = $this->prc_purchase_requisition->get($prwhere);
		$prcek = $prcek[0];

		$emp['EMAIL']='';
		if($prcek['PPR_ASSIGNEE']){
			$emp = $this->adm_employee->get(array('ID' => $prcek['PPR_ASSIGNEE']));
			$emp = $emp[0];
		}
		$item_pr = $this->prc_pr_item->pr($ppr['PPV_PRNO']);
		if ($status_reject == 0 || $status_reject == 1) { //jika di reject, mencari komentar
			$piv = $this->prc_item_verify->get(array('PIV_PRNO'=>$ppr['PPV_PRNO']));
			foreach ($piv as $v) {
				$dataPiv[$v['PPI_ID']]=$v;
			}
		}
		
		if ($status_reject == 0) {
			$prset = array('PPR_STTVER' => 2, 'PPR_STT_TOR' => 0);
			$this->load->library('sap_handler');
			$this->sap_handler->rejectPr($ppr['PPV_PRNO'], $comment_all);

			if(!empty($emp['EMAIL'])){
				$user['EMAIL'] = $emp['EMAIL'];
				$user['data']['header']['NO_PR'] = $ppr['PPV_PRNO'];
				$user['data']['header']['JENIS_REJECT'] = 'REJECT Item';
				$user['data']['header']['TGL_SUBMIT'] = date('d M Y g.i.s A',oraclestrtotime($prcek['DOC_UPLOAD_DATE']));
				$user['data']['detail_pr']=$item_pr;
				$user['data']['detail_piv']=$dataPiv;
				
				$this->kirim_email($user);				
			}
		}
		else if ($status_reject == 1) {
			$prset = array('PPR_STTVER' => 0, 'PPR_STT_TOR' => 0);

			if(!empty($emp['EMAIL'])){
				$user['EMAIL'] = $emp['EMAIL'];
				$user['data']['header']['NO_PR'] = $ppr['PPV_PRNO'];
				$user['data']['header']['JENIS_REJECT'] = 'REJECT Document';
				$user['data']['header']['TGL_SUBMIT'] = date('d M Y g.i.s A',oraclestrtotime($prcek['DOC_UPLOAD_DATE']));
				$user['data']['detail_pr']=$item_pr;
				$user['data']['detail_piv']=$dataPiv;
				
				$this->kirim_email($user);				
			}
		}
		else if ($status_reject == 2) {
			$prset = array('PPR_STTVER' => 1, 'PPR_STT_TOR' => 1);
		}
		$this->prc_purchase_requisition->update($prset, $prwhere);
				//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Procurement_sap/store','prc_purchase_requisition','update',$prset,$prwhere);
				//--END LOG DETAIL--//
		//*/

        if($status_reject == 2) $this->session->set_flashdata('success', 'success');
        else $this->session->set_flashdata('success', 'reject');
        redirect('Procurement_sap/index');
	}

	public function store_tor($pr = NULL) {
		$this->load->library("file_operation");
		$this->load->model('adm_mrpc');
		/* tampilin list pr, ntar pilih salah satu pr */
		if ($pr == null) {
			$data['title'] = "Unggah Dokumen";
			$data['istor'] = 'true';
			$data['mrp'] = $this->adm_mrpc->get(array('EMP_ID' => $this->session->userdata('ID')));
			$data['request'] = $this->session->userdata('MKCCTR');
			$data['success'] = $this->session->flashdata('success') == 'success';
			$this->layout->set_table_js();
			$this->layout->set_table_cs();
			$this->layout->add_js('pages/list_pr_tor.js');
			$this->layout->render('list_pr_tor', $data);
		}

		/* masuk ke dalam form upload dokumen pengadaan */
		else {
			$this->load->model('com_mat_group');
			$this->load->model('prc_item_verify');
			$this->load->model('prc_plan_doc');
			$this->load->model('prc_pr_item');
			$this->load->model('prc_pr_item');
			$this->load->model('prc_purchase_requisition');

			$this->prc_item_verify->where_is_doc(1);
			$data['verif'] = $this->prc_item_verify->pr($pr);
			//var_dump( $data['verif']); die();
			$this->adm_cctr->where_kel_com($this->session->userdata('KEL_PRGRP'));
			$cctr = $this->adm_cctr->get();
			$data['cctr'] = array_build_key($cctr, 'CCTR');

			$data['success'] = false;
			$data['warning'] = false;
			/* jika dia ngupload file */
			if ($this->input->post()) {
				
				$uploaded = $this->file_operation->upload(UPLOAD_PATH.'ppm_document', $_FILES);
				
				/* kalau berhasil upload */
				if (!empty($uploaded['file'])) {
					$category = $this->input->post('tipe');
					/* foreach item yang dicentang */
					if($this->input->post('items') == null) {
						$data['warning'] = true;
					}
					else {
							//--LOG MAIN--//
						$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
								$this->authorization->getCurrentRole(),'Upload Dokumen Pengadaan','UPLOAD',$this->input->ip_address()
							);
						$LM_ID = $this->log_data->last_id();
							//--END LOG MAIN--//

						foreach ($this->input->post('items') as $key) {
							$whereppd['PPD_CATEGORY'] = $category;
							$whereppd['PPI_ID'] = $key;
							$setppd['PPD_STATUS'] = '';
							$this->prc_plan_doc->update($setppd, $whereppd);

								//--LOG DETAIL--//
							$this->log_data->detail($LM_ID,'Procurement_sap/store_tor','prc_plan_doc','update',$setppd,$whereppd);
								//--END LOG DETAIL--//

							$new_id = $this->prc_plan_doc->get_id();
							$ppd = array(
									'PPD_ID' => $new_id,
									'PPD_PRNO' => $pr,
									'PPD_CATEGORY' => $category,
									'PPD_DESCRIPTION' => $this->input->post('desc'),
									'PPD_FILE_NAME' => $uploaded['file']['file_name'],
									'PPD_CREATED_AT' => date('d-M-Y g.i.s A'),
									'PPD_CREATED_BY' => $this->session->userdata['FULLNAME'],
									'PPI_ID' => $key,
									'PPD_STATUS' => '1',
								);
							$junk = $this->prc_plan_doc->insert($ppd);

								//--LOG DETAIL--//
							$this->log_data->detail($LM_ID,'Procurement_sap/store_tor','prc_plan_doc','insert',$ppd);
								//--END LOG DETAIL--//
						}

						$listpr = $this->prc_purchase_requisition->pr($pr);
						// var_dump($listpr);exit();
						
						$data['success'] = true;
					}
				}
			}

			/* nampilin viewnya form upload file */
			$this->load->helper(array('form', 'url'));
			$data['pr'] = $this->prc_purchase_requisition->pr($pr);
			$data['doctype'] = $this->adm_doctype_pengadaan->find($data['pr']['PPR_DOCTYPE']);
			$items = $this->prc_pr_item->pr($pr);
			$data['plant'] = $this->adm_plant->find($data['pr']['PPR_PLANT']);
			// usort($data['items'], array($this, 'sortingPrItem'));

			foreach ($items as $item) {
				$data['itemid'][$item['PPI_ID']] = $item;
				$item['matgrp'] = $this->com_mat_group->find($item['PPI_MATGROUP']);
				$data['items'][$item['PPI_ID']] = $item;
			}
			$data['prno'] = $pr;
			$data['title'] = 'Upload Dokumen Pengadaan';
			$this->prc_plan_doc->where_active();
			$data['docs'] = $this->prc_plan_doc->pr($pr);
			$data['docs'] = array_reverse($data['docs']);

			$this->layout->set_table_js();
			$this->layout->set_table_cs();
			$this->layout->add_js('pages/detail_pr.js');
			$this->layout->add_js('pages/detail_pr_tor.js');
			$this->layout->render('detail_pr_tor',$data);
		}
	}

	public function store_tor_submit($pr) {
		$this->load->model('prc_purchase_requisition');

		$listpr = $this->prc_purchase_requisition->pr($pr);
		// var_dump($listpr);exit();
		$counter = $listpr['DOC_UPLOAD_COUNTER'] + 1;

		$where = array('PPR_PRNO' => $pr);
		$set = array(
				'PPR_ASSIGNEE' => $this->session->userdata('ID'),
				'PPR_STT_TOR' => '1', 
				'DOC_UPLOAD_COUNTER' => $counter, 
				'DOC_UPLOAD_DATE' => date('d-M-Y g.i.s A')
			);
		$this->prc_purchase_requisition->update($set, $where);
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Upload Dokumen Pengadaan','SUBMIT',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Procurement_sap/store_tor_submit','prc_purchase_requisition','update',$set,$where);
			//--END LOG DETAIL--//

		$this->session->set_flashdata('success', 'success');
		redirect('Procurement_sap/store_tor');
	}

	public function tor_status() {
		$this->load->model('prc_plan_doc');
		$where = array('PPD_ID' => $this->input->post('id'));
		$set = array('PPD_STATUS' => $this->input->post('status'));
		$this->prc_plan_doc->update($set, $where);
		echo "'success'";
	}

	public function get_detail_doc($pr) {
		$this->load->model('prc_plan_doc');
		$data['docs'] = $this->prc_plan_doc->pr($pr);
		echo json_encode($data);
	}

	public function get_category() {
		$this->load->model('prc_plan_doc');
		$data = $this->prc_plan_doc->get_category();
		echo json_encode($data);
	}

	public function get_detail($pr) {
		$this->load->model('prc_purchase_requisition');
		$data = $this->prc_purchase_requisition->pr($pr);
		echo json_encode($data);
	}

	public function get_history($nomat) {
		$this->load->model('prc_pr_item');
		$items = $this->prc_pr_item->get(array('PPI_NOMAT' => $nomat));
		echo json_encode($items);
	}

	public function sync_pr() {
		$this->load->model('prc_sap_sync');
		$this->load->model('prc_staging_log');
		$this->load->model('prc_it_service');
		$this->load->library('sap_handler');
		$this->load->model('adm_purch_grp');

		if ($this->input->post('by') == 'all') {
			$filter = $this->session->userdata('COMPANYID');
		} else {
			$filter = $this->input->post('filter');
			if($filter == "request"){
				$data = $this->session->userdata('ID');
				$this->load->model('adm_employee');
				$by = $this->adm_employee->find($data);
			} else {
				$by = $this->input->post('by');
			}
		}
		$return = $this->sap_handler->getPROpen($filter, $by);

		$pr = $return['IT_DATA']; 
		$prg = array();
		// echo "<pre>";
		// die(print_r($pr));

		if (!empty($pr)) {
			$this->prc_sap_sync->delete();
			
			foreach ($pr as $key => $value) {
				if ($value['PGRP'] == '') {
					unset($pr[$key]);
					continue;
				}
				// foreach ($value as $key2 => $value2) {
				// 	// $pr[$key][$key2] = str_replace(array("&"),array("\"&\""), $value2);
				// }
				$cek = $this->adm_purch_grp->get(array('PURCH_GRP_CODE' => $value['PGRP']));
				if(!isset($cek[0])){
					unset($pr[$key]);
					continue;
				}
			}
			$this->prc_sap_sync->insert_batch($pr);
		}
		$service = $return['IT_SERVICE'];
		if (isset($service) && !empty($service)) {
			$this->prc_it_service->insert_staging($service);
		}
		$this->prc_staging_log->insert(array(
				'TABLE_NAME' => 'PRC_SAP_SYNC',
				'CREATED_AT' => date('d-M-Y g.i.s A'),
				'CREATED_BY' => $this->session->userdata['FULLNAME']
			));
		
		$post = $this->input->post();
		// var_dump($return);

		echo json_encode(compact('post', 'pr', 'service'));
	}

	public function get_latest_pr_sync() {
		$this->load->model('prc_staging_log');
		echo json_encode($this->prc_staging_log->get_latest());
	}

	public function sync_contract() {
		$this->load->model('prc_contract_sync');
		$this->load->library('sap_handler');
		$contract = $this->sap_handler->getContractOpen();
		$this->prc_contract_sync->delete();
		foreach ($contract as $key => $value) {
			foreach ($value as $key2 => $value2) {
				$contract[$key][$key2] = str_replace(array("'", "&"),array("''", "\"&\""), $value2);
			}
		}
		$this->prc_contract_sync->insert_batch($contract);
		// var_dump($contract);
		redirect('');
	}

	public function sortingPrItem($a, $b)
	{
	    return $a['PPI_PRITEM'] - $b['PPI_PRITEM'];
	}
	
	function nodoc_upload($pr){
		$this->load->model('prc_purchase_requisition');

		$listpr = $this->prc_purchase_requisition->pr($pr);
		// var_dump($listpr);exit();
		$counter = $listpr['DOC_UPLOAD_COUNTER'] + 1;

		$where = array('PPR_PRNO' => $pr);
		$set = array(
				'PPR_ASSIGNEE' => $this->session->userdata('ID'),
				'PPR_STT_TOR' => '1', 
				'DOC_UPLOAD_COUNTER' => $counter, 
				'DOC_UPLOAD_DATE' => date('d-M-Y g.i.s A')
			);
		$this->prc_purchase_requisition->update($set, $where);

			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Unggah Dokumen','PR Tanpa Document',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Procurement_sap/nodoc_upload','prc_purchase_requisition','update',$set,$where);
			//--END LOG DETAIL--//

		//$this->session->set_flashdata('success', 'success');
		//redirect('Procurement_sap/store_tor');
		
		echo json_encode(array('nilai'=>$pr));
	}

	public function viewDok($id = null){
		$url = "int-".base_url();
		$this->load->helper('file');
		$image_path = base_url(UPLOAD_PATH).'/ppm_document/'.$id;

		if (strpos($url, 'semenindonesia.com') !== false) { //server production
			if(empty($id)){
				die('tidak ada attachment.');
			}
			if(file_exists(BASEPATH.'../upload/ppm_document/'.$id)){				
				$this->output->set_content_type(get_mime_by_extension($image_path));
				return $this->output->set_output(file_get_contents($image_path));
			}else{
				if($this->session->userdata['VENDOR_ID'] == null){
					die('<h2>Anda Harus Login !!</h2>');
				}
				$vendor_id = url_encode($this->session->userdata['VENDOR_ID']); 
				redirect($url.'View_document_procurement/viewDokPpmDok/'.$id.'/'.$vendor_id);
			}

		}else{ //server development
			if(empty($id) || !file_exists(BASEPATH.'../upload/ppm_document/'.$id)){
				die('tidak ada attachment.');
			}
			
			$this->output->set_content_type(get_mime_by_extension($image_path));
			return $this->output->set_output(file_get_contents($image_path));
		}

	}

	public function kirim_email($user){	
		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->to($user['EMAIL']);				
		$this->email->cc('pengadaan.semenindonesia@gmail.com');				
		$this->email->subject("Reject PR eProcurement ".$this->session->userdata['COMPANYNAME'].".");
		$content = $this->load->view('email/reject_pr',$user['data'],TRUE);
		$this->email->message($content);
		$this->email->send();
	}

}
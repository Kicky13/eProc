<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tender_winner extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('encrypt');
		$this->load->library('Layout');

		$this->load->library(array('ckeditor')); //library ckeditor diload
	}

	function editor($width,$height) {
    	//configure base path of ckeditor folder
		$this->ckeditor->basePath = 'http://10.15.5.150/dev/eproc/plugins/ckeditor/';
		$this->ckeditor-> config['toolbar'] = 'Full';
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor-> config['width'] = $width;
		$this->ckeditor-> config['height'] = $height;
	}

	public function index() {

		$data['title'] = "Pembuatan LP3";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/prc_tender_winner_list.js');
		$this->layout->render('tender_winner_list', $data);
		//$sesUser = $this->session->all_userdata();
	}

	public function listPO(){
		//FILTER PGRP UDAH tinggal filter
		$data['title'] = "List LP3 / PO"; 
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$PRGRP = $this->session->userdata('PRGRP');

		$this->load->model('po_header');
		$this->load->model('po_detail');
		$this->load->model('prc_tender_main');
		// $this->po_header->where_approve();
		if($this->input->post()){
			$nopo = $this->input->post('nopo');
			$nolp3 = $this->input->post('nolp3');
			$namevendor = $this->input->post('namevendor');
			$kodevendor = $this->input->post('kodevendor');
			$release = $this->input->post('release');
			$pratender = $this->input->post('pratender');
			$data['nopo'] = $nopo;
			$data['namevendor'] = $namevendor;
			$data['kodevendor'] = $kodevendor;
			$data['release'] = $release;
			$data['pratender'] = $pratender;
			if(!empty($nopo)){
				$this->po_header->where_ponumber($nopo);
			}
			if(!empty($nolp3)){
				$this->po_header->where_lp3number($nolp3);
			}
			if(!empty($namevendor)){
				$this->po_header->where_vndname($namevendor);
			}
			if(!empty($kodevendor)){
				$this->po_header->where_vndcode($kodevendor);
			}
			if($release){
				$this->po_header->where_release($release);
			}
			if(!empty($pratender)){
				$this->po_header->where_pratender($pratender);
			}
		} else {
			// $this->po_header->where_release();
		}
		$this->po_header->join_ptm_lp3();
		$data['data'] = $this->po_header->get();	
		foreach ($data['data'] as $key => $value) {
			if (strpos($PRGRP, $value['PGRP']) !== false) {
				$this->po_detail->where_po($value['PO_ID']);
				$item = $this->po_detail->get(false);
				$data['data'][$key]['nitem'] = count($item);
				$data['data'][$key]['item'] = $item;
				$data['data'][$key]['status_po'] = $this->po_header->get_status($value['IS_APPROVE']);
			}
		}
		$this->layout->add_js('pages/list_po.js');
		$this->layout->add_css('pages/list_po.css');
		$this->layout->render('list_po', $data);
	}

	public function listapprovalPO(){ //udah ada filter user.
		$data['title'] = "List Approval LP3";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();

		$this->load->model('po_header');
		$this->load->model('po_detail');
		$this->load->model('po_approval');
		//$this->load->model('po_role');
		$this->load->model('adm_employee');

		// $userdata=$this->adm_employee->get(array('ADM_EMPLOYEE.ID'=>$this->authorization->getEmployeeId()));
		// $useremail=strtolower($userdata[0]['EMAIL']);		
		// $useremail=substr($useremail,0,strpos($useremail, '@'));	
		// $relcode=$this->po_role->get_realcode($useremail);		
		// $relgroup=$this->po_role->get_realgroup($useremail);	
		// var_dump($relcode);die;	
		// $relcode =  array("REAL_CODE"=>array('DL', 'DU', 'S1', 'K1', 'B1', 'E1'));	
		// $this->load->library('sap_handler');	
		// $data['from_sap']=array();
		// $data['reversed_item']=array();
		// if(!empty($relcode)||!empty($relgroup)){
		// 	$data['from_sap'] = $this->sap_handler->get_po_approval($relcode,$relgroup);
		// 	$data['reversed_item'] = array_build_key($data['from_sap']['PO_ITEM'], 'PO_NUMBER', true);
		// }		
		// var_dump($data); exit();

		if($this->input->post()){
			$nolp3 = $this->input->post('nolp3');
			$namevendor = $this->input->post('namevendor');
			$kodevendor = $this->input->post('kodevendor');
			$release = $this->input->post('release');
			$pratender = $this->input->post('pratender');
			$data['nolp3'] = $nolp3;
			$data['namevendor'] = $namevendor;
			$data['kodevendor'] = $kodevendor;
			$data['release'] = $release;
			$data['pratender'] = $pratender;
			
			if(!empty($nolp3)){
				$this->po_header->where_lp3number($nolp3);
			}
			if(!empty($namevendor)){
				$this->po_header->where_vndname($namevendor);
			}
			if(!empty($kodevendor)){
				$this->po_header->where_vndcode($kodevendor);
			}
			if($release){
				$this->po_header->where_release($release);
			}
			if(!empty($pratender)){
				$this->po_header->where_pratender($pratender);
			}
		}
		

		$this->po_header->where_approve();
		$this->po_header->join_ptm_lp3();
		$where_submit = array("IS_SUBMIT" => 1);
		$data['data'] = $this->po_header->get($where_submit);	
		// echo "<pre>";
		// print_r($data['data']);die;	
		$header = array();
		foreach ($data['data'] as $key => $value) {
			$id_nganu = $this->authorization->getEmployeeId();
			$this->po_approval->where_po($value['PO_ID']);
			$this->po_approval->where_approve();
			$this->po_approval->where_userid($id_nganu);
			$approval = $this->po_approval->get();
			// echo "<pre>";
			// print_r($approval);die;
			// var_dump($approval);die();
			// var_dump($value); //die();

			if(!empty($approval)){
				$approval = $approval[0];
				if($approval['STATUS'] == $value['REAL_STAT']){
					// var_dump('a');
					$this->po_detail->where_po($value['PO_ID']);
					$item = $this->po_detail->get(false);
					$data['data'][$key]['nitem'] = count($item);
					$data['data'][$key]['item'] = $item;

					$isi = $value;
					$isi['nitem'] = count($item);
					$isi['item'] = $item;
					$isi['approval']=$approval;
					$isi['REL_CODE'] = $approval['REL_CODE'];
					$header[] = $isi;
				}
			}
		}
		$data['data']=$header;	
		// echo "<pre>";
		// print_r($header);die;
		$this->layout->add_js('pages/list_po.js');
		$this->layout->render('list_approval_po', $data);
	}

	/*
	*	approve po
	*	parameter:
	*	$is_approve = 1 for approve
	*	$is_approve = 2 for reject
	*/
	public function approve() {
		
		/*************approval ke eproc***********/
		// $id_nganu = $this->authorization->getEmployeeId();
		$this->load->model('po_header');
		$this->load->model('po_approval');
		$this->load->model('po_detail');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_pr_item');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_process_holder');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_purchase_requisition');
		$is_approve = $this->input->post('is_approve');	
		$max_approve = $this->input->post('max_approve');
		$is_contract = $this->input->post('is_contract');
		$real_stat = $this->input->post('real_stat');	
		$id = $this->input->post('po_id');		
		$po_no = $this->input->post('po_no');
		$note = $this->input->post('note');
		$is_ajax = $this->input->post('is_ajax');
		$this->po_header->where_po($id);
		$data = $this->po_header->get();

		$where_poapprove = array("PO_ID" => $id, "STATUS" => $data[0]['REAL_STAT']);
		$approval = $this->po_approval->get($where_poapprove);

			//--LOG MAIN--//
		$action = 'APPROVE';
		if($is_approve==2){//reject
			$action = 'REJECT';
		}
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Approval LP3',$action,$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		if($is_approve==1){//approve
			
			if($max_approve == $real_stat){
				$this->po_detail->where_po($id);
				$po_detail = $this->po_detail->get();
				foreach ($po_detail as $value) {
					$ptw[] = $value['PTW_ID'];
				}
				$ret = $this->create_po($is_contract,$ptw);
				// die(var_dump($ret));
				$sukses = false;
				$tbody='';
				if(count($ret['RETURN']) > 0) {
					for ($i = 0; $i < count($ret['RETURN']); $i++) {
						$val = $ret['RETURN'][$i];
						$tr = '<tr>';
						$tr .= '<td>' . $val['ID'] . '</td>';
						$tr .= '<td>' . $val['TYPE'] . '</td>';
						$tr .= '<td>' . $val['MESSAGE'] . '</td>';
						$tr .= '</tr>';
						$tbody.=$tr;
						if ($val['TYPE'] == 'S') {
							$po_no = $val['MESSAGE_V2'];                            
							$sukses = true;
						}                        
					}                    
				}

				if($sukses){
					$this->po_approval->update(array('IS_APPROVE' => $is_approve,"CREATED_DATE" => date('d-M-Y g.i.s A')), $where_poapprove);
                		//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Tender_winner/approve','po_approval','update',array('IS_APPROVE' => $is_approve,"CREATED_DATE" => date('d-M-Y g.i.s A')),$where_poapprove);
						//--END LOG DETAIL--//

					$this->po_header->update(array('PO_NUMBER' => $po_no,'IS_APPROVE'=>$is_approve,'RELEASED_AT' => date('d-M-Y g.i.s A'),'REAL_STAT' => intval($data[0]['REAL_STAT']) + 1 ), array("PO_ID" => $id));			
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Tender_winner/approve','po_header','update',array('PO_NUMBER' => $po_no,'IS_APPROVE'=>$is_approve,'RELEASED_AT' => date('d-M-Y g.i.s A'),'REAL_STAT' => intval($data[0]['REAL_STAT']) + 1, 'PTM_NUMBER'=>$data[0]['PTM_NUMBER']), array("PO_ID" => $id));
						//--END LOG DETAIL--//

					$po_header = $data[0];
					
					foreach ($po_detail as $key_po => $value_po) {
						$where_tit = array('PRC_TENDER_ITEM.PPI_ID'=>$value_po['PPI_ID'],'PRC_TENDER_ITEM.PTM_NUMBER'=>$po_header['PTM_NUMBER']);
						$this->prc_tender_item->update(array('TIT_STATUS'=>10),$where_tit);
							//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Tender_winner/approve','prc_tender_item','update',array('TIT_STATUS'=>10),$where_tit);
							//--END LOG DETAIL--//

						$tit = $this->prc_tender_item->get($where_tit);
						$ppi = $this->prc_pr_item->get(array('PPI_ID'=>$value_po['PPI_ID']),'*', -1, false);
						$this->prc_pr_item->update(array('PPI_QTY_USED'=>($ppi[0]['PPI_QTY_USED']-($tit[0]['TIT_QUANTITY']-$value_po['POD_QTY'])),'PPI_POQUANTITY'=>$value_po['POD_QTY']),array('PPI_ID'=>$value_po['PPI_ID']));
							//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Tender_winner/approve','prc_pr_item','update',array('PPI_QTY_USED'=>($ppi[0]['PPI_QTY_USED']-($tit[0]['TIT_QUANTITY']-$value_po['POD_QTY'])),'PPI_POQUANTITY'=>$value_po['POD_QTY']),array('PPI_ID'=>$value_po['PPI_ID']));
							//--END LOG DETAIL--//
					}

					//tangal 8 feb 2018
					//tambah nama pekerjaan
					$data_ptm = $this->prc_tender_main->ptm($data[0]['PTM_NUMBER']);
					//ambil pr
					$data_tit = $this->prc_tender_item->get(array('PTM_NUMBER'=>$data[0]['PTM_NUMBER']));
					$ppi = $this->prc_pr_item->where_ppiId($data_tit[0]['PPI_ID']);
					$data_ppr = $this->prc_purchase_requisition->pr($ppi[0]['PPI_PRNO']);
					//end

					$vnd = $this->prc_tender_vendor->ptv($data[0]['VND_CODE']);
					$data_email = array(
						'EMAIL_ADDRESS'=>$vnd[0]['EMAIL_ADDRESS'],
						'data'=>array(
							'PTM_SUBJECT_OF_WORK'=>'',
							'PPR_PRNO'=>'',
							'vendorno'=>$data[0]['VND_CODE'],
							'no_po'=>$po_no,
							'doc_date'=>date('d M Y', oraclestrtotime($data[0]['DOC_DATE'])),
							'ddate'=>date('d M Y', oraclestrtotime($data[0]['DDATE'])),
							'total'=>number_format($data[0]['TOTAL_HARGA'],2,",",".")." ".$po_detail[0]['CURR'],
							)
						);
					$this->kirim_email_po($data_email);

					// kriim ke evaluator 31 januari
					$this->load->model('prc_evaluator');
					$this->prc_evaluator->join_emp();
					$evaluator = $this->prc_evaluator->ptm($data[0]['PTM_NUMBER']);
					// echo $evaluator[0]['EMAIL'];
					// print_r($evaluator);die;
					$data_email = array(
						'EMAIL_ADDRESS'=>$evaluator[0]['EMAIL'],
						'data'=>array(
							'PTM_SUBJECT_OF_WORK'=>$data_ptm[0]['PTM_SUBJECT_OF_WORK'],
							'PPR_PRNO'=>$data_ppr['PPR_PRNO'],
							'vendorno'=>$data[0]['VND_CODE'],
							'no_po'=>$po_no,
							'doc_date'=>date('d M Y', oraclestrtotime($data[0]['DOC_DATE'])),
							'ddate'=>date('d M Y', oraclestrtotime($data[0]['DDATE'])),
							'total'=>number_format($data[0]['TOTAL_HARGA'],2,",",".")." ".$po_detail[0]['CURR'],
							)
						);
					$this->kirim_email_po($data_email);

					echo json_encode(array('state'=>true,'data'=>$tbody));
					exit();
				}else{
					echo json_encode(array('state'=>false,'data'=>$tbody));
					exit();
				}
			}else{
				$this->po_header->update(array('REAL_STAT' => intval($data[0]['REAL_STAT']) + 1), array("PO_ID" => $id));
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Tender_winner/approve','po_header','update',array('REAL_STAT' => intval($data[0]['REAL_STAT']) + 1, 'PTM_NUMBER'=>$data[0]['PTM_NUMBER']), array("PO_ID" => $id));
					//--END LOG DETAIL--//

				$this->po_approval->update(array('IS_APPROVE' => $is_approve,"CREATED_DATE" => date('d-M-Y g.i.s A')), $where_poapprove);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Tender_winner/approve','po_approval','update',array('IS_APPROVE' => $is_approve,"CREATED_DATE" => date('d-M-Y g.i.s A')), $where_poapprove);
					//--END LOG DETAIL--//
			}
		}else if($is_approve==2){//reject
			$this->po_header->update(array('IS_APPROVE'=>$is_approve), array("PO_ID" => $id));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Tender_winner/approve','po_header','update',array('IS_APPROVE'=>$is_approve,'PTM_NUMBER'=>$data[0]['PTM_NUMBER']), array("PO_ID" => $id));
				//--END LOG DETAIL--//

			$this->po_approval->update(array('IS_APPROVE' => $is_approve,"CREATED_DATE" => date('d-M-Y g.i.s A')), $where_poapprove);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Tender_winner/approve','po_approval','update',array('IS_APPROVE' => $is_approve,"CREATED_DATE" => date('d-M-Y g.i.s A')), $where_poapprove);
				//--END LOG DETAIL--//

			$ptm = $this->prc_tender_main->ptm($data[0]['PTM_NUMBER']);
			$s['EMP_ID']=$ptm[0]['PTM_ASSIGNMENT'];
			$w['PTM_NUMBER']=$data[0]['PTM_NUMBER'];
			$this->prc_process_holder->update($s,$w);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Tender_winner/approve','prc_process_holder','update',$s,$w);
				//--END LOG DETAIL--//
		}
		
		
		$this->load->model('po_header_comment');
		$comment_id = $this->po_header_comment->get_new_id(); 
		// $this->file_operation->upload(UPLOAD_PATH.'comment_attachment/'.$id."_".$comment_id, $_FILES);
		$current_date = oracledate(strtotime(date("d-m-Y H:i:s")));
		$dataComment = array(
			"PHC_ID" => $comment_id,
			"PO_ID" => $id,
			"PHC_COMMENT" => "'".str_replace("'", "''", $note)."'",
			"PHC_POSITION" => "'".$this->authorization->getCurrentRole()."'",
			"PHC_NAME" => "'".str_replace("'", "''", $this->authorization->getCurrentName())."'",
			"PHC_ACTIVITY" => "'Pembuatan LP3'",
			"PHC_START_DATE" => "'".$current_date."'",
			// "PTC_ATTACHMENT" => '\''.$_FILES["ptc_attachment"]["name"].'\''
			);
		$this->po_header_comment->insert($dataComment);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Tender_winner/approve','po_header_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		
		// if(isset($is_ajax)&&($is_ajax==1)){
		// 	echo json_encode(array('state'=>true));
		// }

		if($is_ajax==1){
			echo json_encode(array('state'=>true));
		} else {
			redirect('Tender_winner/listapprovalPO');
		}
		

		/***********release PO ke SAP************/
		// $po_no = url_decode($po_no);
		// $relcode = url_decode($relcode);
		// $this->load->library('sap_handler');
		// $retval = $this->sap_handler->approve_po($po_no, $relcode);
		
		// $this->session->set_flashdata('ret_approve_po_dump', $retval);
		// if (!isset($retval['REL_INDICATOR_NEW']) || $retval['REL_INDICATOR_NEW'] == '') {
		// 	$this->session->set_flashdata('success', 'warning');
		// 	// $retval = array_merge(array($data[0]['PO_NUMBER'], $approval[0]['REL_CODE']), $retval);
		// 	// $this->session->set_flashdata('ret_approve_po', $retval);
		// 	redirect('Tender_winner/listapprovalPO');
		// }
		// if ($retval['REL_INDICATOR_NEW'] == 'G') {
		// 	redirect('Tender_winner/releasePO/'.$po_no);
		// }

		
	}


	public function terbilang($angka) {
		$angka = (float)$angka;
		$bilangan = array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan','Sepuluh','Sebelas');
		if ($angka < 12) {
			return $bilangan[$angka];
		} else if ($angka < 20) {
			return $bilangan[$angka - 10] . ' Belas';
		} else if ($angka < 100) {
			$hasil_bagi = (int)($angka / 10);
			$hasil_mod = $angka % 10;
			return trim(sprintf('%s Puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
		} else if ($angka < 200) {
			return sprintf('Seratus %s', $this->terbilang($angka - 100));
		} else if ($angka < 1000) {
			$hasil_bagi = (int)($angka / 100);
			$hasil_mod = $angka % 100;
			return trim(sprintf('%s Ratus %s', $bilangan[$hasil_bagi], $this->terbilang($hasil_mod)));
		} else if ($angka < 2000) {
			return trim(sprintf('Seribu %s', $this->terbilang($angka - 1000)));
		} else if ($angka < 1000000) {
			$hasil_bagi = (int)($angka / 1000); 
			$hasil_mod = $angka % 1000;
			return sprintf('%s Ribu %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod));
		} else if ($angka < 1000000000) {
			$hasil_bagi = (int)($angka / 1000000);
			$hasil_mod = $angka % 1000000;
			return trim(sprintf('%s Juta %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
		} else if ($angka < 1000000000000) {
			$hasil_bagi = (int)($angka / 1000000000);
			$hasil_mod = fmod($angka, 1000000000);
			return trim(sprintf('%s Milyar %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
		} else if ($angka < 1000000000000000) {
			$hasil_bagi = $angka / 1000000000000;
			$hasil_mod = fmod($angka, 1000000000000);
			return trim(sprintf('%s Triliun %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
		} else {
			return 'Data Salah';
		}
	}

	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function releasePO($id){
		$data['id'] = $id;			
		$this->load->library('encrypt');
		$this->load->model('po_header');
		$this->load->model('po_detail');
		$this->load->model('po_approval');
		$this->load->model('vnd_address');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_pr_item');

		$data['title'] = "Release PO";

		$this->po_header->where_po($id);
		$po = $this->po_header->get();
		$data['po'] = $po[0];

		$ptm = $this->prc_tender_main->ptm($po[0]['PTM_NUMBER']);
		$data['ptm'] = $ptm[0];
		$this->po_detail->where_po($data['po']['PO_ID']);
		$po_detail = $this->po_detail->get(false);
		$data['item'] = $po_detail;

		$data['PRNO'] = $data['item'][0]['PPR_PRNO'];
		$ptv = $this->prc_tender_vendor->ptv($data['po']['VND_CODE']);
		$data['ptv'] = $ptv[0];
		$data['RFQ_NO'] = $data['ptv']['PTV_RFQ_NO'];

		$data['PTM_PRATENDER'] = $data['ptm']['PTM_PRATENDER'];
		$vnd_id = $data['ptv']['VENDOR_ID'];

		$vnd_address = $this->vnd_address->get_all(array('VENDOR_ID'=>$vnd_id));

		foreach ($vnd_address as $key => $value) {
			if($value['TYPE'] == "Kantor Pusat"){
				$data['vnd'] = $value;
				break;
			}
		}

		$total = 0;
		foreach ($data['item'] as $key => $value) {
			$total  = $total + (intval($value['POD_PRICE'])*intval($value['POD_QTY']));
		}
		$data['total'] = $total;
		$data['terbilang'] = $this->terbilang($total);

		$rilis = $po[0]['RELEASE'] - 1;
		$this->po_approval->where_po($po[0]['PO_ID']);
		$this->po_approval->where_releaseby($rilis);
		$approval = $this->po_approval->get();
		$data['approval'] = $approval[0];

		$filename = $this->generateRandomString(20);

		$this->load->library('ci_qr_code');

		$params['data'] = base_url()."Publik/releasePO/".$data['po']['LINK'];
		$params['level'] = 'H';
		$params['size'] = 4;
		$params['savename'] = FCPATH . 'static/images/captcha/'.$filename.".png";
		$a = $this->ci_qr_code->generate($params);
		$data['qrpath'] = base_url().'static/images/captcha/'.$filename.".png";

		//tambah fungsi javascript tanggal, save, ambil data PO thithe 12 oktober 2017
		$this->layout->add_js('pages/prc_tender_winner_edit.js');
		$this->layout->add_js('jquery.maskedinput.js');
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js('pages/mydatepicker.js');

		$this->layout->render('release_barang', $data);


	}


//tambah fungsi ambil semua data PO thithe 16 oktober 2017
	public function editListPO(){
		//FILTER PGRP UDAH tinggal filter
		$data['title'] = "Edit PO"; 
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$PRGRP = $this->session->userdata('PRGRP');

		$this->load->model('po_header');
		$this->load->model('po_detail');
		$this->load->model('prc_tender_main');
		// $this->po_header->where_approve();
		if($this->input->post()){
			$nopo = $this->input->post('nopo');
			$nolp3 = $this->input->post('nolp3');
			$namevendor = $this->input->post('namevendor');
			$kodevendor = $this->input->post('kodevendor');
			$release = $this->input->post('release');
			$pratender = $this->input->post('pratender');
			$data['nopo'] = $nopo;
			$data['namevendor'] = $namevendor;
			$data['kodevendor'] = $kodevendor;
			$data['release'] = $release;
			$data['pratender'] = $pratender;
			if(!empty($nopo)){
				$this->po_header->where_ponumber($nopo);
			}
			if(!empty($nolp3)){
				$this->po_header->where_lp3number($nolp3);
			}
			if(!empty($namevendor)){
				$this->po_header->where_vndname($namevendor);
			}
			if(!empty($kodevendor)){
				$this->po_header->where_vndcode($kodevendor);
			}
			if($release){
				$this->po_header->where_release($release);
			}
			if(!empty($pratender)){
				$this->po_header->where_pratender($pratender);
			}
		} else {
			// $this->po_header->where_release();
		}
		$this->po_header->join_ptm_lp3();
		$data['data'] = $this->po_header->get();	
		foreach ($data['data'] as $key => $value) {
			if (strpos($PRGRP, $value['PGRP']) !== false) {
				$this->po_detail->where_po($value['PO_ID']);
				$item = $this->po_detail->get(false);
				$data['data'][$key]['nitem'] = count($item);
				$data['data'][$key]['item'] = $item;
				$data['data'][$key]['status_po'] = $this->po_header->get_status($value['IS_APPROVE']);
			}
		}
		$this->layout->add_js('pages/list_po.js');
		$this->layout->add_css('pages/list_po.css');
		$this->layout->render('edit_list_po', $data);
	}

	//tambah fungsi ambil data detail PO thithe 16 oktober 2017
	public function editReleasePO($id){	
		$data['id'] = $id;	
		$this->load->library('encrypt');
		$this->load->model('po_header');
		$this->load->model('po_detail');
		$this->load->model('po_approval');
		$this->load->model('vnd_address');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_pr_item');

		$data['title'] = "Release PO";

		$this->po_header->where_po($id);
		$po = $this->po_header->get();
		$data['po'] = $po[0];

		$ptm = $this->prc_tender_main->ptm($po[0]['PTM_NUMBER']);
		$data['ptm'] = $ptm[0];
		
		$po_detail = $this->po_detail->getDetailPo($data['po']['PO_ID']);
		// echo "<pre>";
		// print_r($po_detail);die;
		$data['item'] = $po_detail;

		$data['PRNO'] = $data['item'][0]['PPR_PRNO'];
		$ptv = $this->prc_tender_vendor->ptv($data['po']['VND_CODE']);
		$data['ptv'] = $ptv[0];
		$data['RFQ_NO'] = $data['ptv']['PTV_RFQ_NO'];

		$data['PTM_PRATENDER'] = $data['ptm']['PTM_PRATENDER'];
		$vnd_id = $data['ptv']['VENDOR_ID'];

		$vnd_address = $this->vnd_address->get_all(array('VENDOR_ID'=>$vnd_id));

		foreach ($vnd_address as $key => $value) {
			if($value['TYPE'] == "Kantor Pusat"){
				$data['vnd'] = $value;
				break;
			}
		}

		$total = 0;
		foreach ($data['item'] as $key => $value) {
			$total  = $total + (intval($value['POD_PRICE'])*intval($value['POD_QTY']));
		}
		$data['total'] = $total;
		$data['terbilang'] = $this->terbilang($total);

		$rilis = $po[0]['RELEASE'] - 1;
		$this->po_approval->where_po($po[0]['PO_ID']);
		$this->po_approval->where_releaseby($rilis);
		$approval = $this->po_approval->get();
		$data['approval'] = $approval[0];

		$filename = $this->generateRandomString(20);

		$this->load->library('ci_qr_code');

		$params['data'] = base_url()."Publik/releasePO/".$data['po']['LINK'];
		$params['level'] = 'H';
		$params['size'] = 4;
		$params['savename'] = FCPATH . 'static/images/captcha/'.$filename.".png";
		$a = $this->ci_qr_code->generate($params);
		$data['qrpath'] = base_url().'static/images/captcha/'.$filename.".png";

		//tambah fungsi javascript tanggal, save, ambil data PO thithe 12 oktober 2017
		// $this->layout->add_js('pages/prc_tender_winner_edit.js');
		$this->layout->add_js('jquery.maskedinput.js');
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js('pages/mydatepicker.js');
		$this->layout->render('edit_release_barang', $data);


	}

	//tambah fungsi ambil data PO thithe 12 oktober 2017
	public function getReleasePO($id){		
		$this->load->library('encrypt');
		$this->load->model('po_header');

		$data = $this->po_header->getDetailPo($id);
		$data['NEW_DDATE'] = date('Y-m-d', strtotime($data['NEWDDATE']));
		$data['NEW_DOC_DATE'] = date('Y-m-d', strtotime($data['NEWDOC_DATE']));

		$data = array(
			'data' 	=> $data
			);
		echo json_encode($data);
	}

	//tambah fungsi save data PO thithe 12 oktober 2017
	public function saveReleasePO(){		
		// echo "<pre>";
		// print_r($this->input->post());
		// die;
		$this->load->library('encrypt');
		$this->load->model('po_header');
		$this->load->model('po_detail');

		$data1['PO_ID'] 	= $this->input->post('id');
		$data1['HEADER_TEXT'] 	= $this->input->post('HEADER_TEXT');
		
		$result = $this->po_header->updateDetailPo($data1);
		
		$i = 0;
		$DOC_DATE 	= $this->input->post('DOC_DATE');
		$DDATE 		= $this->input->post('DDATE');
		$id_item 	= $this->input->post('id_item');
		$item_text 	= $this->input->post('item_text');
		foreach ($id_item as $key) {
			$data1['DOC_DATE'] 	= $DOC_DATE[$i];
			$data1['DDATE'] 	= $DDATE[$i];
			$data1['ITEM_TEXT']	= $item_text[$i];
			$data1['POD_ID'] 	= $id_item[$i];
			$result = $this->po_detail->updateDetailPo($data1);
			$i++;
		}

		$data['success'] = TRUE;

		// echo json_encode($data);
		redirect('Tender_winner/editReleasePO/'.$data1['PO_ID']);
	}


	public function deletePO($id){
		$this->load->model('po_header');
		$this->load->model('po_detail');
		$this->load->model('po_approval');
		$this->po_header->delete($id);
		$this->po_detail->delete($id);
		$this->po_approval->delete($id);
		return true;
	}

	public function renego($id){
		$this->load->model('po_header');
		$this->load->model('po_detail');
		$this->load->model('prc_tender_item');
		$this->po_header->where_po($id);
		$data = $this->po_header->get();
		$ptm = $data[0]['PTM_NUMBER'];

			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Rejected LP3','RENEGO',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		$this->po_header->update(array('IS_APPROVE'=>3),array('PO_ID'=>$id));
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Tender_winner/renego','po_header','update',array('IS_APPROVE' => 3,'PTM_NUMBER'=>$ptm),array('PO_ID'=>$id));
			//--END LOG DETAIL--//

		$this->po_detail->where_po($id);
		$po_detail = $this->po_detail->get();
		foreach ($po_detail as $key_po => $value_po) {
			$where_tit = array('PRC_TENDER_ITEM.PPI_ID'=>$value_po['PPI_ID'],'PRC_TENDER_ITEM.PTM_NUMBER'=>$ptm);
			$this->prc_tender_item->update(array('TIT_STATUS'=>5),$where_tit);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Tender_winner/renego','prc_tender_item','update',array('TIT_STATUS'=>5),$where_tit);
				//--END LOG DETAIL--//
			$tit = $this->prc_tender_item->get($where_tit);			
		}
		redirect('Tender_winner/listPO');

	}

	public function retender($id){
		$this->load->model('po_header');
		$this->po_header->where_po($id);
		$data = $this->po_header->get();
		if(!empty($data)){
			$ptm = $data[0]['PTM_NUMBER'];
		}else{
			$this->session->set_flashdata('success', 'error');
			redirect('Tender_winner/listPO');
		}		
			//--LOG MAIN--//
		// $this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				// $this->authorization->getCurrentRole(),'Rejected LP3','RETENDER',$this->input->ip_address()
			// );
		// $LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		// $this->po_header->update(array('IS_APPROVE'=>4),array('PO_ID'=>$id));
			//--LOG DETAIL--//
		// $this->log_data->detail($LM_ID,'Tender_winner/retender','po_header','update',array('IS_APPROVE' => 4,'PTM_NUMBER'=>$ptm),array('PO_ID'=>$id));
			//--END LOG DETAIL--//

		redirect('Tender_cleaner/retender/' . $ptm . '/Rejected LP3/'.$id);
	}

	public function cancel($id){
		$this->load->model('po_header');
		$this->load->model('po_detail');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_process_holder');

		$this->po_header->where_po($id);
		$data = $this->po_header->get();
		if(!empty($data)){
			$ptm = $data[0]['PTM_NUMBER'];
		}else{
			$this->session->set_flashdata('error','PTM NUMBER tidak ditemukan');
			redirect('Tender_winner/listPO');
		}
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Rejected LP3','BATAL',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		$this->po_header->update(array('IS_APPROVE'=>5),array('PO_ID'=>$id));
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Tender_winner/cancel','po_header','update',array('IS_APPROVE' => 5,'PTM_NUMBER'=>$ptm),array('PO_ID'=>$id));
			//--END LOG DETAIL--//

		$this->po_detail->where_po($id);
		$po_detail = $this->po_detail->get();
		foreach ($po_detail as $key_po => $value_po) {
			$where_tit = array('PRC_TENDER_ITEM.PPI_ID'=>$value_po['PPI_ID'],'PRC_TENDER_ITEM.PTM_NUMBER'=>$ptm);
			$this->prc_tender_item->update(array('TIT_STATUS'=>999),$where_tit); //set status item jadi (999)'dibatalkan'
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Tender_winner/cancel','prc_tender_item','update',array('TIT_STATUS'=>999),$where_tit);
				//--END LOG DETAIL--//
			$tit = $this->prc_tender_item->get($where_tit);			
		}
		$pti = $this->prc_tender_item->get(array('PRC_TENDER_ITEM.PTM_NUMBER'=>$ptm,'TIT_STATUS <>'=>999)); 
		if(count($pti)==0){
			$this->prc_tender_main->update(array('PTM_STATUS'=>-999),array('PTM_NUMBER'=>$ptm)); //set status ptm jadi (-999)'dibatalkan'
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Tender_winner/cancel','prc_tender_main','update',array('PTM_STATUS'=>-999),array('PTM_NUMBER'=>$ptm));
				//--END LOG DETAIL--//
		}

		$item = $this->prc_tender_item->ptm($ptm);
		$holder = true;
		foreach ($item as $val) {
			if($val['TIT_STATUS']!='9' && $val['TIT_STATUS']!='10' && $val['TIT_STATUS']!='999'){
				$holder = false;
			}				
		}
		if($holder){
			$s['EMP_ID']=null;
			$w['PTM_NUMBER']=$ptm;
			$this->prc_process_holder->update($s,$w);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Tender_winner/submit','prc_process_holder','update',$s,$w);
				//--END LOG DETAIL--//
		}
		$this->session->set_flashdata('success','Berhasil dibatalkan (cancel)');
		redirect('Tender_winner/listPO');

	}

	public function printPO($id)
	{
		// error_reporting(E_ALL);
    	// $this->load->helper(array('tcpdf'));
		$this->load->library('M_pdf');
		$this->load->library('encrypt');
		$this->load->model('po_header');
		$this->load->model('po_detail');
		$this->load->model('po_approval');
		$this->load->model('vnd_header');
		$this->load->model('vnd_bank');
		$this->load->model('vnd_address');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_pr_item');
		$this->load->model('adm_purch_grp');
		$this->load->model('adm_employee');
		$this->load->model('vendor_detail');

		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_it_service');

		$this->load->model('prc_tender_prep');
		$this->load->model('prc_purchase_requisition');

		$this->load->model('adm_wilayah');

		$this->load->model('m_vnd_prefix');

		$data['title'] = "Release PO";

		$this->po_header->where_po($id);
		$po = $this->po_header->get();
		
		$dataprefix = $this->m_vnd_prefix->get();
		foreach ($dataprefix as $key => $value) {
			$prefix_list[$value['PREFIX_ID']] = $value['PREFIX_NAME'];
		}

		$data['po'] = $po[0];
		$ptm = $this->prc_tender_main->ptm($po[0]['PTM_NUMBER']);
		$data['prc_tender_prep'] = $this->prc_tender_prep->ptm($po[0]['PTM_NUMBER']);

		$data['data_em_jab_code'] = '';
		$requestioner_data = $this->adm_employee->ambilData($ptm[0]['PTM_REQUESTER_ID']);
		$data['buyer'] = $this->adm_employee->ambilData($po[0]['PO_CREATED_BY']);
		if(count($requestioner_data)>0){
			$data['data_em_jab_code'] = $requestioner_data[0]['NO_PEG'];
		}
		
		$data['ptm'] = $ptm[0];
		$this->po_detail->where_po($data['po']['PO_ID']);
		$po_detail = $this->po_detail->get(false);
		$data['item'] = $po_detail;
		$this->prc_pr_item->join_pr();
		$this->prc_pr_item->join_group_plant();
		$this->prc_pr_item->join_pr_service();
		$ppi = $this->prc_pr_item->get(array('PPI_ID'=>$po_detail[0]['PPI_ID']),"*",-1,false);
		$data['ppi']=$ppi[0];
		$data['PRNO'] = $data['item'][0]['PPR_PRNO'];
		$data['ppr'] = $this->prc_purchase_requisition->pr($data['item'][0]['PPR_PRNO']);
		$data['LONG_DESC'] = $data['ppr']['LONG_DESC'];
		$ptv = $this->prc_tender_vendor->ptm_ptv($po[0]['PTM_NUMBER'], $data['po']['VND_CODE']);
		$data['ptv'] = $ptv[0];
		$data['RFQ_NO'] = $data['ptv']['PTV_RFQ_NO'];

		$ptqm = $this->prc_tender_quo_main->ptmptv($po[0]['PTM_NUMBER'], $data['po']['VND_CODE']);
		$ptqi = $this->prc_tender_quo_item->get_by_pqm($ptqm[0]['PQM_ID']);
		$data['ptqi'] = $ptqi;

		$data['PTM_PRATENDER'] = $data['ptm']['PTM_PRATENDER'];
		$vnd_id = $data['ptv']['VENDOR_ID'];

		$vnd_address = $this->vnd_address->get_all(array('VENDOR_ID'=>$vnd_id));
		$data['vnd_address'] = $vnd_address;
		// print_r($vnd_address);die;
		$vnd_header = $this->vnd_header->get_all(array("VENDOR_ID"=>$vnd_id));
		$npwp = $this->vendor_detail->npwp_ven($vnd_id);
		$data['city'] = $this->adm_wilayah->get_wilayah($npwp[0]['KOTA']);
		$data['prop'] = $this->adm_wilayah->get_wilayah($npwp[0]['PROPINSI']);
		$data['npwp'] = $npwp;

		$data['vendor'] = $vnd_header[0];
		$prefixkonversi = intval($vnd_header[0]['PREFIX']);
		if(filter_var($prefixkonversi, FILTER_VALIDATE_INT)){
			$vendorPrefix = $prefix_list[$prefixkonversi];
		} else if($prefixkonversi<0){
			$vendorPrefix = '';
		} else {
			$vendorPrefix = $vnd_header[0]['PREFIX'];
		}
		$data['vendorPrefix'] = $vendorPrefix;
		$vnd_bank = $this->vnd_bank->get(array("VENDOR_ID"=>$data['vendor']['VENDOR_ID']));
		$data['bank'] =$vnd_bank[0];

		foreach ($vnd_address as $key => $value) {
			if($value['TYPE'] == "Kantor Pusat"){
				$data['vnd'] = $value;
				break;
			}
		}

		$total = 0;
		foreach ($data['item'] as $key => $value) {
			$total  = $total + (intval($value['POD_PRICE'])*intval($value['POD_QTY']));
		}
		$data['total'] = $total;
		$data['terbilang'] = $this->terbilang($total);

		$rilis = $po[0]['RELEASE'] - 1;
		$this->po_approval->where_po($po[0]['PO_ID']);
		$this->po_approval->where_releaseby($rilis);
		$approval = $this->po_approval->get();
		$data['approval'] = $approval[0];

		$filename = $this->generateRandomString(20);

		$this->load->library('ci_qr_code');

		$params['data'] = base_url()."Publik/releasePO/".$data['po']['LINK'];
		$params['level'] = 'H';
		$params['size'] = 2;
		$params['savename'] = FCPATH . 'static/images/captcha/'.$filename.".png";
		$a = $this->ci_qr_code->generate($params);
		$data['qrpath'] = base_url().'static/images/captcha/'.$filename.".png";

		$data['is_print'] = true;
		$form_print = array(
			1 => 'si',
			2 => 'sg',
			3 => 'pa',
			4 => 'to'
			);
		$barang_or_jasa = $data['ptm']['IS_JASA']==1?'jasa':'barang';
		$apg = $this->adm_purch_grp->get(array("PURCH_GRP_CODE"=>$data['po']['PGRP']));	
		$data['apg'] = $apg[0];
		$kel_purch_grp = $apg[0]['KEL_PURCH_GRP'];

		$cekfile = 'po_'.$barang_or_jasa.'_'.$form_print[$kel_purch_grp];
		
		if($cekfile=="po_barang_si" || $cekfile=="po_barang_sg"){
			$i=0;
			foreach ($data['item'] as $key => $value) {
				$data['matnr'] = $value['POD_NOMAT'];
				$data['banfn'] = substr($value['PPI_ID'], 0, 10);
				$data['bnfpo'] = sprintf("%05d", substr($value['PPI_ID'], 10));

				$data['user_vendor'] = $vnd_id;

				$this->load->library('sap_handler');
				$data['return'] = $this->sap_handler->getlongtext(array($data));
				foreach ($data['return'] as $var) {
					$data['item'][$i]['ISI'][] = $var['TDLINE'];
				}
				$i++;
			}
		}

		$html = $this->load->view('po_'.$barang_or_jasa.'_'.$form_print[$kel_purch_grp], $data, true);      
		
		if($cekfile=="po_barang_si" || $cekfile=="po_barang_sg"){
			$this->m_pdf->pdf->SetHTMLHeader('
				<table>
					<tr>
						<td class="text-right"><b>Halaman {PAGENO} dari {nb}</b></td>
					</tr>
				</table>
				');
		}
		
		$this->m_pdf->pdf->WriteHTML($html);
		$this->m_pdf->pdf->setTitle($data['title']);


		// $this->m_pdf->pdf->setFooter('{PAGENO}');
		// echo "<pre>";
		// print_r($data);
		// die;
		// echo $cekfile;die;

		if($cekfile=="po_jasa_si" || 
			$cekfile=="po_barang_si" || 
			$cekfile=="po_barang_sg" || 
			$cekfile=="po_jasa_sg" || 
			$cekfile=="po_jasa_to" || 
			$cekfile=="po_barang_to")
		{
			$footer = $this->load->view('po_footer_'.$barang_or_jasa.'_'.$form_print[$kel_purch_grp], $data, true);      
			$this->m_pdf->pdf->SetHTMLFooter($footer);
		}

		$file = ' ';
		if($cekfile=="po_jasa_si"){
			$file = 'KETENTUAN.pdf';
		} else if($cekfile=="po_barang_si"){
			$file = 'KETENTUAN_BAR_SI4.pdf';
		} else if($cekfile=="po_barang_sg"){
			$file = 'KETENTUAN_BAR_SI3.pdf';
		}

		// echo "<pre>";
		// print_r($data['item']);die;
		// print_r($data);die;
		$target_file = './upload/temp/';			
		$this->m_pdf->pdf->AddPage();
		$this->m_pdf->pdf->SetImportUse();
		if($cekfile=="po_jasa_si" || $cekfile=="po_barang_si" || $cekfile=="po_barang_sg"){
			$pagecount = $this->m_pdf->pdf->SetSourceFile($target_file.$file);
			$tplId = $this->m_pdf->pdf->ImportPage($pagecount,2);
			$this->m_pdf->pdf->UseTemplate($tplId);
		} //untuk kebutuhan tonasa
		$this->m_pdf->pdf->SetHTMLFooter();

		$this->m_pdf->pdf->Output($data['title'].".pdf",'I');    
	}

	function romanic_number($integer, $upcase = true) 
	{ 
		$table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1); 
		$return = ''; 
		while($integer > 0) 
		{ 
			foreach($table as $rom=>$arb) 
			{ 
				if($integer >= $arb) 
				{ 
					$integer -= $arb; 
					$return .= $rom; 
					break; 
				} 
			} 
		} 

		return $return; 
	} 

	private function sort_item_pr($a, $b) {
		return ($a['EBELP'] > $b['EBELP']);
	}

	public function detailPO($id,$is_approval = false,$is_print='false'){
		if($is_print){
			$this->load->helper(array('tcpdf'));
		}
		$data['title'] = "Lembar Persetujuan Penunjukan Pemenang";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->load->library('snippet');
		$this->load->model('po_header');
		$this->load->model('po_header_comment');
		$this->load->model('po_detail');
		$this->load->model('prc_evaluator');
		$this->load->model('po_approval');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_nego');
		$this->load->model('prc_tender_winner');
		$this->load->model('prc_nego_vendor');
		$this->load->model('prc_nego_detail');
		$this->load->model('prc_nego_hist');
		$this->load->model('prc_ece_change');

		$this->load->model('prc_auction_quo_header');
		$this->load->model('prc_auction_detail');
		$this->load->model('prc_auction_item');

		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_purchase_requisition');
		$this->load->model('prc_tender_comment');


		$this->load->model('adm_purch_grp');

		$po_id = $id;
		$this->po_header->where_po($po_id);
		$this->po_header->join_employee();
		$po_header = $this->po_header->get();
		$data['po_header'] = $po_header[0];
		$data['status_po'] = $this->po_header->get_status($po_header[0]['IS_APPROVE']);

		$ptm = $this->prc_tender_main->ptm($data['po_header']['PTM_NUMBER']);
		$data['ptm'] = $ptm[0];
		$data['ptp'] = $this->prc_tender_prep->ptm($data['po_header']['PTM_NUMBER']);

		$this->po_detail->where_po($po_id);
		$this->po_detail->join_adm_plant();
		$po_detail = $this->po_detail->get(false);
		$data['item'] = $po_detail;

		usort($data['item'], array($this, 'sort_item_pr'));

		$data['winner'] = array();
		$count=0;
		foreach ($po_detail as $kolom => $nilai) {
			$count++;
			$winner = $this->prc_tender_winner->get($nilai['PTW_ID']);
			$data['winner'][$count] = $winner[0];
		}

		$ppr_prno = $data['item'][0]['PPR_PRNO'];
		$data['ppr'] = $this->prc_purchase_requisition->pr($ppr_prno);

		$data['PTM_PRATENDER'] = $data['ptm']['PTM_PRATENDER'];
		$data['PTP_JUSTIFICATION'] = $data['ptp']['PTP_JUSTIFICATION'];
		$data['PPR_REQUESTIONER'] = $data['ppr']['PPR_REQUESTIONER'];
		$data['LONG_DESC'] = $data['ppr']['LONG_DESC'];
		$data['PLANT'] = $data['item'][0]['PLANT'];
		$data['PLANT_NAME'] = $data['item'][0]['PLANT_NAME'];
		$data['NO_PO'] = $data['po_header']['PO_NUMBER'];

		$data['COMMENT'] = $this->po_header_comment->get_from_po_id($po_id);

		$this->load->library('authorization');
		$this->load->model('adm_employee');
		$this->load->model('adm_employee_atasan');

		$this->po_approval->where_po($po_id);
		$app = $this->po_approval->get();
		$data['approval'] = $app;
		$data['is_approval'] = $is_approval;

		/* MULAI LAMPIRAN KRONOLOGI LEMBAR PERSETUJUAN PENUNJUKAN PEMENANG */
		// I. Undangan Penawaran
		$this->prc_tender_comment->where_activity("Approval Pengadaan");
		$data['ptc'] = $this->prc_tender_comment->ptm($data['po_header']['PTM_NUMBER']);
		$releaseComplete =  @$data['ptc'][0];
		$data['releaseComplete'] = oraclestrtotime($releaseComplete['PTC_END_DATE']);

		$data['pesertavendor'] = $this->prc_tender_vendor->ptm($data['po_header']['PTM_NUMBER']);
		$vendor = array();
		foreach ($data['pesertavendor'] as $key => $value) {
			$vendor[$value['PTV_VENDOR_CODE']] = $value;
		}

		// II. Rekap Penawaran Yang Respon
		$this->prc_tender_comment->where_activity("Verifikasi Penawaran Vendor");
		$data['ptc'] = $this->prc_tender_comment->ptm($data['po_header']['PTM_NUMBER']);
		$releaseComplete =  @$data['ptc'][0];
		$data['verifikasiPenawaran'] = oraclestrtotime($releaseComplete['PTC_END_DATE']);

		$pti = $this->prc_tender_item->ptm($data['po_header']['PTM_NUMBER']);
		$data['pti'] = $pti;

		$item = array();
		foreach ($data['pti'] as $key => $value) {
			$item[$value['TIT_ID']] = $value;
		}

		$this->prc_tender_quo_item->join_pqm();
		$ptqi = $this->prc_tender_quo_item->get_by_ptm($data['po_header']['PTM_NUMBER']);
		foreach ($ptqi as $val) {
			$data['ptqi'][$val['TIT_ID']][$val['PTV_VENDOR_CODE']] = $val;
		}

		$itemvendor = array();
		foreach ($ptqi as $key => $val) {
			$itemvendor[$val['TIT_ID']][$val['PTV_VENDOR_CODE']] = $val['PQI_PRICE'];
		}

		$this->prc_tender_quo_main->join_vnd_header();
		$data['nyo'] = $this->prc_tender_quo_main->ptm($data['po_header']['PTM_NUMBER']);

		// die(var_dump($data['nyo']));
		// III. Evaluasi Teknis
		$this->prc_tender_comment->where_activity("Approval Pengajuan Evaluasi Teknis");
		$data['ptc'] = $this->prc_tender_comment->ptm($data['po_header']['PTM_NUMBER']);
		$appevatek =  @$data['ptc'][0];
		$data['appevatek'] = oraclestrtotime($appevatek['PTC_END_DATE']);

		$this->prc_tender_comment->where_activity("Approval Evaluasi");
		$data['ptc'] = $this->prc_tender_comment->ptm($data['po_header']['PTM_NUMBER']);
		$appeval =  @$data['ptc'][0];
		$data['appeval'] = oraclestrtotime($appeval['PTC_END_DATE']);

		$this->prc_evaluator->join_emp();
		$evaluator = $this->prc_evaluator->ptm($data['po_header']['PTM_NUMBER']);
		$data['evaluator'] = @$evaluator[count($evaluator)-1];

		$data['evaluasi'] = $this->snippet->evaluasi($data['po_header']['PTM_NUMBER'],false,false,false,true,false,false,true,$is_print,'vendor_per_item',$id);

		// tahap nego atau apapun deh
		$his = $this->prc_nego_hist->ptm($data['po_header']['PTM_NUMBER']);
		$history = array();
		$romawi = 4;
		$myCompany = $this->session->userdata('COMPANYID');
		if($myCompany==5000){
			$romawi = 6;
		}
		foreach ($his as $key => $value) {
			$datahistory = array();
			$datahistory['DATE'] = oraclestrtotime($value['CREATED_AT']);
			$datahistory['ROMAWI'] = $this->romanic_number($romawi);
			$romawi++;
			$datahistory['NEGOSIASI'] = $value['NEGOSIASI'];
			if($value['NEGOSIASI'] == "1"){
				$datahistory['ROMAWI_II'] = $this->romanic_number($romawi);
				$romawi++;
				$nego = $this->prc_tender_nego->id($value['NEGOSIASI_ID']);
				$negoheader['NEGO_END'] = oraclestrtotime($nego['NEGO_END']);
				$negoheader['CREATED_AT'] = oraclestrtotime($nego['CREATED_AT']);
				$this->prc_nego_vendor->where_ptm($data['po_header']['PTM_NUMBER']);
				$this->prc_nego_vendor->where_id($nego['NEGO_ID']);
				$negohead = $this->prc_nego_vendor->get();
				foreach ($negohead as $id => $val) {
					$this->prc_tender_vendor->where_ptv($val['PTV_VENDOR_CODE']);
					$ven = $this->prc_tender_vendor->ptm($data['po_header']['PTM_NUMBER']);	
					$negoheader['VENDOR_CODE'][] = $val['PTV_VENDOR_CODE'];
					$negoheader['VENDOR_NAME'][] = $ven[0]['VENDOR_NAME'];
				}
				foreach ($item as $k => $val) {
					$this->prc_nego_detail->where_titid($val['TIT_ID']);
					$this->prc_nego_detail->where_ptm($data['po_header']['PTM_NUMBER']);
					$this->prc_nego_detail->where_id($nego['NEGO_ID']);
					$negodetail = $this->prc_nego_detail->get();
					foreach ($negodetail as $id => $v) {
						$negoiv[$val['TIT_ID']][$v['VENDOR_NO']] = $v['HARGA'];
					}
				}
				$negoheader['ITEM'] = $negoiv;
				$datahistory['DATA'] = $negoheader;
				$datahistory['M_ITEM'] = $item;
				foreach ($negoheader['ITEM'] as $key => $value) {
					foreach ($value as $k => $val) {
						$itemvendor[$key][$k] = $val;
					}
				}
			} else if($value['NEGOSIASI'] == "3"){
				$ece = $this->prc_ece_change->id($value['NEGOSIASI_ID']);
				$item[$ece[0]['TIT_ID']]['TIT_PRICE'] = $ece[0]['PRICE_AFTER'];
				$datahistory['DATA'] = $ece[0];
				$datahistory['M_ITEM'] = $item;
			} else if($value['NEGOSIASI'] == "2"){
				$datahistory['ROMAWI_II'] = $this->romanic_number($romawi);
				$romawi++;
				$auction = $this->prc_auction_quo_header->id($value['NEGOSIASI_ID']);
				$auction[0]['PAQH_AUC_END'] = strtotime($auction[0]['PAQH_AUC_END']);
				$auction[0]['PAQH_AUC_START'] = strtotime($auction[0]['PAQH_AUC_START']);
				$auction_detail = $this->prc_auction_detail->paqh($value['NEGOSIASI_ID']);
				foreach ($auction_detail as $k => $val) {
					$auction[0]['ITEM'][$val['PTV_VENDOR_CODE']] = $val['PAQD_FINAL_PRICE'];
					$auction[0]['VENDOR_NAME'][] = $vendor[$val['PTV_VENDOR_CODE']]['VENDOR_NAME'];
				}
				$datahistory['DATA'] = $auction[0];
				$datahistory['M_ITEM'] = $item;
			}
			$history[] = $datahistory;
		}
		$data['history'] = $history;

		$data['is_print']=$is_print;		

		// thithe nambah rekap nego 06 november 2017
		/* Yang baru */
		$this->prc_tender_vendor->where_active();
		$this->prc_tender_vendor->where_tit_status(10);
		$this->prc_tender_vendor->where_ptv_is_nego();		
		$vendorss = $this->prc_tender_vendor->ptm($data['po_header']['PTM_NUMBER']);
		$data['vendorss'] = $vendorss;
		// echo "<pre>";
		// echo $data['po_header']['PTM_NUMBER'];
		// print_r($vendorss);die;
		$form_print = array(
			1 => 'si',
			2 => 'sg',
			3 => 'pa',
			4 => 'to'
			);
		$apg = $this->adm_purch_grp->get(array("PURCH_GRP_CODE"=>$data['po_header']['PGRP']));	
		// echo "<pre>";
		// print_r($apg);die;
		$data['apg'] = $apg[0];
		$kel_purch_grp = $apg[0]['KEL_PURCH_GRP'];
		if($form_print[$kel_purch_grp]=='to'){
			$data['file1']= 'print_lp3_'.$form_print[$kel_purch_grp].'1';
			$data['file2']= 'print_lp3_'.$form_print[$kel_purch_grp].'2';
		} else if($form_print[$kel_purch_grp]=='sg'){
			$data['file1']= 'print_lp3_sg1';
			if($data['ptp']['PTP_EVALUATION_METHOD'] != "2 Tahap 2 Sampul" ){
				$data['file2']= 'print_lp3_sg2';
			} else {
				$data['file2']= 'print_lp3_sg2_22';
			}

		} else {
			$data['file1']= 'print_lp3_si1';
			$data['file2']= 'print_lp3_si2';
		}

		if($is_print=='true'){

			$this->cetak_evatek($data);

		}else{
			$this->load->model('prc_pr_item');
			$i=0;
			foreach ($data['item'] as $id => $val){
				$this->prc_pr_item->where_id($val['PPI_ID']);
				$pritem = $this->prc_pr_item->get();
				// print_r($pritem);die;
				$data['item'][$i]['PR_ITEM'] = $pritem[0]['PPI_PRITEM'];
				$i++;
			}
			
			$this->layout->add_js('pages/detail_po_approve.js');		
			$this->layout->render('detail_po', $data);
		}

	}

	public function cetak_evatek($data){
		// echo $data['file1'];die;
		// echo "<pre>";
		// print_r($data);
		// die;
		$this->load->library('M_pdf');

		$this->mpdf = new mPDF();
		$html = $this->load->view($data['file1'], $data, true);
		$this->mpdf->AddPage('P',
			'', '', '', '',
	            10, // margin_left
	            10, // margin right
	            20, // margin top
	            15, // margin bottom
	            18, // margin header
	            12); // margin footer
		$this->mpdf->WriteHTML($html);
		$this->mpdf->setFooter('{PAGENO}');

		$html2 = $this->load->view($data['file2'], $data, true);
		$this->mpdf->AddPage('L',
			'', '', '', '',
	            10, // margin_left
	            10, // margin right
	            10, // margin top
	            15, // margin bottom
	            18, // margin header
	            5); // margin footer
		$this->mpdf->WriteHTML($html2);

	    $this->mpdf->Output('LP3', 'I'); // view in the explorer

		// $this->load->helper(array('dompdf', 'file'));
  //       $html = $this->load->view('print_lp3_sg_l', $data, true);
  //       $filename = 'Export';
  //       $paper = 'A4';
  //       $orientation = 'potrait';
  //       pdf_create($html, $filename, $paper, $orientation,false);
	}

	public function get_datatable_po() {
		$this->load->model('po_header');
		$this->load->model('po_detail');
		$this->po_header->where_approve();
		$datatable = $this->po_header->get();
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	public function get_datatablecontract() {
		$PRGRP = $this->session->userdata('PRGRP');
		$PRGRP = explode(",",str_replace("'", "", $PRGRP));
		$this->load->model('prc_tender_winner');
		$this->prc_tender_winner->where_status();
		$this->prc_tender_winner->where_contract();
		$this->prc_tender_winner->join_pr();
		$this->prc_tender_winner->where_pgrp_in($PRGRP);
		$datatable = $this->prc_tender_winner->get();
		//print_r($datatable);
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	public function get_datatablerfq() {
		$PRGRP = $this->session->userdata('PRGRP');
		$PRGRP = explode(",",str_replace("'", "", $PRGRP));
		$this->load->model('prc_tender_winner');
		$this->prc_tender_winner->where_status();
		$this->prc_tender_winner->join_ptm();
		$this->prc_tender_winner->where_rfq();		
		$this->prc_tender_winner->where_pgrp_in($PRGRP);
		$datatable = $this->prc_tender_winner->get();
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	public function get_datatable_po_header() {
		$this->load->model('po_header');
		$datatable = $this->po_header->get();
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	public function get_no_LP3($PGRP){
		$this->load->model('adm_purch_grp');
		$this->load->model('po_header');
		$max_no_lp3 = $this->po_header->get_max_lp3_no();
		$max_no_lp3 = empty($max_no_lp3)?0:$max_no_lp3;
		$no_urut_lp3 = intval(substr($max_no_lp3, 6))+1;
		$company_id = $this->adm_purch_grp->get(array('PURCH_GRP_CODE'=>$PGRP));
		$company_id = $company_id[0]['KEL_PURCH_GRP'];
		$gen_code = "LP3".$company_id.sprintf("%'.07d", $no_urut_lp3);
		return $gen_code;
	}

	public function submit() {	
		$this->load->model('po_detail');
		$this->load->model('po_header');
		$this->load->model('po_approval');
		$this->load->model('po_delivery');
		$this->load->model('prc_pr_item');		
		$this->load->model('adm_approve_kewenangan');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_winner');
		$this->load->model('prc_process_holder');
		$winner = $this->input->post('winner');
		$doctype = $this->input->post('doctype');
		$docdate = $this->input->post('docdate');
		$ddate = $this->input->post('ddate');
		$headertext = $this->input->post('headertext');
		$itemtext = $this->input->post('itemtext');
		$fixddate = $this->input->post('fixddate');
		$desc = $this->input->post('desc');
		$time = $this->input->post('time');
		$no_po = $this->input->post('no_po');
		$po_id = $this->input->post('po_id');
		$note = $this->input->post('note');	

		$IS_SUBMIT = $this->input->post('IS_SUBMIT');

		$DOC_ANALISA_HARGA 			= $_FILES['DOC_ANALISA_HARGA']['tmp_name'];
		$newDOC_ANALISA_HARGA = "";
		$tes 				= dirname(__FILE__);
		$pet_pat 			= str_replace('application/modules/Tender_winner/controllers', '', $tes);
		if (isset($_FILES) && !empty($_FILES['DOC_ANALISA_HARGA']['name'])) {
			$type = explode('.', $_FILES['DOC_ANALISA_HARGA']['name']);
			// if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
			$this->_myFile = "DOC_ANALISA_HARGA". $po_id . date('YmdHms') . "." . end($type);
			$this->_path = $pet_pat . 'upload/temp/' . $this->_myFile;
			if (move_uploaded_file($DOC_ANALISA_HARGA, $this->_path)) {
				$newDOC_ANALISA_HARGA = $this->_myFile;
			}
			// }
		}

		// die(var_dump($this->input->post()));
			//--LOG MAIN--//
		$prosess = 'Create LP3';
		$action = 'SIMPAN';
		if(!empty($po_id)){
			$prosess = 'Rejected LP3';
			$action = 'EDIT';
		}
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),$prosess,$action,$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//
		$satu = 0;
		$pod_number = 10;
		$total = 0;
		if($po_id == null){
			$po_id = 0;
			foreach ($winner as $key => $each_winner) {
				$data = array (
					'PO_STATUS' => '1',
					);
				$this->prc_tender_winner->update($data, array('PTW_ID' => $each_winner));
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Tender_winner/submit','prc_tender_winner','update',$data,array('PTW_ID' => $each_winner));
					//--END LOG DETAIL--//

				$data = $this->prc_tender_winner->get($each_winner);
				$ptm_number = $data[0]['PTM_NUMBER'];
				$lp3no = $this->get_no_LP3($data[0]['PPR_PGRP']);
				if($satu == 0){
					$po_id = $this->po_header->get_id();
					$idhash = $this->encrypt->sha1($po_id);

					$po = array(
						'DOC_ANALISA_HARGA' => $newDOC_ANALISA_HARGA,
						'IS_SUBMIT' => $IS_SUBMIT,
						'PO_ID' => $po_id,
						'PO_NUMBER' => $no_po, // NOMOR PO DARI SAP
						'LP3_NUMBER' => $lp3no,
						'REL_IND' => 'B', // RETURN REL_IND DARI SAP
						'REAL_STAT' => '0', // RETURN REL_IND DARI SAP
						'PTM_NUMBER' => $data[0]['PTM_NUMBER'],
						'PO_CREATED_BY' => $this->authorization->getEmployeeId(),
						'PO_CREATED_AT' => date('d-M-Y g.i.s A'),
						'VND_CODE' => $data[0]['PTV_VENDOR_CODE'],
						'VND_NAME' => $data[0]['VENDOR_NAME'],
						'PGRP' => $data[0]['PPR_PGRP'],
						'PORG' => pgrp_to_porg($data[0]['PPR_PGRP']),
						'DOC_TYPE' => $doctype,
						'DDATE' => oracledate(strtotime($ddate)),
						'DOC_DATE' => oracledate(strtotime($docdate)),
						'HEADER_TEXT' => $headertext,
						'FIX_DDATE' => $fixddate,
						'IS_APPROVE' => 0,
						'LINK' => $idhash
						);
					$this->po_header->insert($po);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Tender_winner/submit','po_header','insert',strip_tags($po));
						//--END LOG DETAIL--//

					$satu++;
					if(isset($desc)&&$desc!=''){
						foreach ($desc as $key => $dsc) {
							$id = $this->po_delivery->get_id();
							$datas = array(
								'ID' => $id,
								'PO_ID' => $po_id,
								'DESC' => $dsc,
								'TIME' => $time[$key]
								);
							$this->po_delivery->insert($datas);
								//--LOG DETAIL--//
							$this->log_data->detail($LM_ID,'Tender_winner/submit','po_delivery','insert',$datas);
								//--END LOG DETAIL--//
						}
					}
				}
				$pod_id = $this->po_detail->get_id();
				$this->prc_pr_item->where_id($data[0]['PPI_ID']);
				$pritem = $this->prc_pr_item->get();
				if(count($pritem)>0){
					$pritem = $pritem[0];
				}else{
					$pritem = array('PPI_UOM'=>null,'PPI_PLANT'=>null,'PPI_CURR'=>null);
				}

				$tit = $this->prc_tender_item->get(array('PRC_TENDER_ITEM.PTM_NUMBER'=>$data[0]['PTM_NUMBER'],'PRC_TENDER_ITEM.PPI_ID'=>$data[0]['PPI_ID']));

				$this->prc_tender_quo_item->join_pqm();
				$this->prc_tender_quo_item->where_tit($tit[0]['TIT_ID']);
				$pqi = $this->prc_tender_quo_item->get_by_ptm($data[0]['PTM_NUMBER']);
				
				$pod = array(
					'POD_NUMBER' => $pod_number,
					'POD_ID' => $pod_id,
					'PO_ID' => $po_id,
					'POD_DECMAT' => $data[0]['PPI_DECMAT'],
					'POD_NOMAT' => $data[0]['PPI_NOMAT'],
					'POD_QTY' => $data[0]['TIT_QUANTITY'],
					'POD_PRICE' => $data[0]['PQI_PRICE'],
					'PPI_ID' => $data[0]['PPI_ID'],
					'PPR_PRNO' => $data[0]['PPI_PRNO'],
					'EBELP' => $data[0]['EBELP'],
					'RFQ_NO' => $data[0]['PTV_RFQ_NO'],
					'ITEM_TEXT' =>str_replace("\n",'&#10;',$itemtext[$data[0]['PTW_ID']]),
					'PTW_ID' => $data[0]['PTW_ID'],
					'UOM' => $pritem['PPI_UOM'],
					'PLANT' => $pritem['PPI_PLANT'],
					'CURR' => $pqi[0]['PQI_CURRENCY'],
					'SERVICE_ID' => $data[0]['SERVICE_ID'],
					);
				$subtot = intval($data[0]['PQI_PRICE']) * intval($data[0]['TIT_QUANTITY']);
				$total = $total + $subtot;
				$this->po_detail->insert($pod);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Tender_winner/submit','po_detail','insert',strip_tags($pod));
					//--END LOG DETAIL--//
				$pod_number = $pod_number + 10;

				$data_tit = array('TIT_STATUS'=>9); //update status jadi 9 (LP3)
				$where_tit = array('PTM_NUMBER'=>$data[0]['PTM_NUMBER'],'PPI_ID'=>$data[0]['PPI_ID']);
				$this->prc_tender_item->update($data_tit,$where_tit);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Tender_winner/submit','prc_tender_item','update',$data_tit,$where_tit);
					//--END LOG DETAIL--//
			}

			$ptm = $this->prc_tender_main->ptm($data[0]['PTM_NUMBER']);
			$data['ptm'] = $ptm[0];

			$cat_prc = 'PO';
			$PRGRP = $this->session->userdata('PRGRP');
			$this->adm_approve_kewenangan->join_emp();		
			$this->adm_approve_kewenangan->where_pgrp($po['PGRP']);
			$this->adm_approve_kewenangan->where_harga_not_null();
			$this->adm_approve_kewenangan->where_catprc($cat_prc);			
			$data['hasil'] = $this->adm_approve_kewenangan->get();
			
			$count = 0;
			foreach ($data['hasil'] as $key => $value) {			
				//BATASAN APPROVAL SEMENTARA NO FILTER
				if(!empty($value['BATAS_HARGA']) && $value['BATAS_HARGA']!='NULL'){
					if($total <= $value['BATAS_HARGA']){				
						$id = $this->po_approval->get_id();
						$datas = array(
							'ID' => $id,
							'PO_ID' => $po_id,
							'APPROVE_BY' => $value['EMP_ID'],
							'JABATAN' => $value['POS_NAME'],
							'STATUS' => $key,
							'NAMA' => $value['FULLNAME'],
							'IS_APPROVE' => 0,
							'REL_CODE' => $value['REL_CODE'],
							);
						$this->po_approval->insert($datas);
							//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Tender_winner/submit','po_approval','insert',$datas);
							//--END LOG DETAIL--//
						$count = $count + 1;
						break;
					} else if($total > $value['BATAS_HARGA']){
						$id = $this->po_approval->get_id();
						$datas = array(
							'ID' => $id,
							'PO_ID' => $po_id,
							'APPROVE_BY' => $value['EMP_ID'],
							'JABATAN' => $value['POS_NAME'],
							'STATUS' => $key,
							'NAMA' => $value['FULLNAME'],
							'IS_APPROVE' => 0,
							'REL_CODE' => $value['REL_CODE'],
							);
						$this->po_approval->insert($datas);
							//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Tender_winner/submit','po_approval','insert',$datas);
							//--END LOG DETAIL--//
						$count = $count + 1;
					} else {
						break;
					}
				}
			}

			$this->po_header->update(array("TOTAL_HARGA" => $total,"RELEASE" => $count),array('PO_ID' => $po_id));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Tender_winner/submit','po_header','update',array("TOTAL_HARGA" => $total,"RELEASE" => $count),array('PO_ID' => $po_id));
				//--END LOG DETAIL--//

		}else{ //update data LP3 dari proses edit
			$po_update = array(
				'DOC_ANALISA_HARGA' => $newDOC_ANALISA_HARGA,
				'IS_SUBMIT' => $IS_SUBMIT,
				'DOC_TYPE' => $doctype,
				'DDATE' => oracledate(strtotime($ddate)),
				'DOC_DATE' => oracledate(strtotime($docdate)),
				'HEADER_TEXT' => $headertext,
				'FIX_DDATE' => $fixddate,
				'REAL_STAT' => 0,
				'IS_APPROVE' => 0						
				);
			$this->po_header->update($po_update,array('PO_ID'=>$po_id));
			
			$ph = $this->po_header->get(array('PO_ID'=>$po_id));
			$lp3no = $ph[0]['LP3_NUMBER'];
			$ptm_number = $ph[0]['PTM_NUMBER'];

				//--LOG DETAIL--//
			if(strlen($headertext)>4000){
				$po_update = array(
					'DOC_ANALISA_HARGA' => $newDOC_ANALISA_HARGA,
					'IS_SUBMIT' => $IS_SUBMIT,
					'DOC_TYPE' => $doctype,
					'DDATE' => oracledate(strtotime($ddate)),
					'DOC_DATE' => oracledate(strtotime($docdate)),
					'HEADER_TEXT' => '',
					'FIX_DDATE' => $fixddate,
					'REAL_STAT' => 0,
					'IS_APPROVE' => 0						
					);
			}
			$poUpdate = array_merge($po_update, array('PTM_NUMBER'=>$ph[0]['PTM_NUMBER']));
			$this->log_data->detail($LM_ID,'Tender_winner/submit','po_header','update',strip_tags($poUpdate),array('PO_ID' => $po_id));
				//--END LOG DETAIL--//
			
			$this->po_detail->where_po($po_id);
			$po_detail = $this->po_detail->get();
			$total=0;
			foreach ($po_detail as $key_pod => $value_pod) {			
				$pod = array(
					'ITEM_TEXT' => str_replace("\n",'&#10;',$itemtext[$value_pod['PTW_ID']])					
					);				
				$this->po_detail->update($pod,array('POD_ID'=>$value_pod['POD_ID']));	
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Tender_winner/submit','po_detail','update',strip_tags($pod),array('POD_ID' => $value_pod['POD_ID']));
					//--END LOG DETAIL--//
				$subtot = intval($value_pod['POD_PRICE']) * intval($value_pod['POD_QTY']);
				$total += $subtot;
			}
				// ini kondisi ketika revisi LP3 di kembalikan ke pejabat yg mereject
			// $this->po_approval->where_po($po_id);
			// $po_approval = $this->po_approval->get(array('IS_APPROVE'=>2));
			// foreach ($po_approval as $value_po_app) {
			// 	$this->po_approval->update(array('IS_APPROVE'=>0),array('ID'=>$value_po_app['ID']));
			// 		//--LOG DETAIL--//
			// 	$this->log_data->detail($LM_ID,'Tender_winner/submit','po_approval','update',array('IS_APPROVE'=>0),array('ID'=>$value_po_app['ID']));
			// 		//--END LOG DETAIL--//
			// }

				//ini ketika edit maka petugas approval insert kembali
			$cat_prc = 'PO';
			$PRGRP = $this->session->userdata('PRGRP');
			$this->adm_approve_kewenangan->join_emp();		
			$this->adm_approve_kewenangan->where_pgrp($ph[0]['PGRP']);
			$this->adm_approve_kewenangan->where_harga_not_null();
			$this->adm_approve_kewenangan->where_catprc($cat_prc);
			$data['hasil'] = $this->adm_approve_kewenangan->get();
			
			$count = 0;
			$this->po_approval->delete($po_id);
			foreach ($data['hasil'] as $key => $value) {			
				//BATASAN APPROVAL SEMENTARA NO FILTER
				if(!empty($value['BATAS_HARGA']) && $value['BATAS_HARGA']!='NULL'){
					if($total <= $value['BATAS_HARGA']){				
						$id = $this->po_approval->get_id();
						$datas = array(
							'ID' => $id,
							'PO_ID' => $po_id,
							'APPROVE_BY' => $value['EMP_ID'],
							'JABATAN' => $value['POS_NAME'],
							'STATUS' => $key,
							'NAMA' => $value['FULLNAME'],
							'IS_APPROVE' => 0,
							'REL_CODE' => $value['REL_CODE'],
							);
						$this->po_approval->insert($datas);
							//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Tender_winner/submit','po_approval','insert',$datas);
							//--END LOG DETAIL--//
						$count = $count + 1;
						break;
					} else if($total > $value['BATAS_HARGA']){
						$id = $this->po_approval->get_id();
						$datas = array(
							'ID' => $id,
							'PO_ID' => $po_id,
							'APPROVE_BY' => $value['EMP_ID'],
							'JABATAN' => $value['POS_NAME'],
							'STATUS' => $key,
							'NAMA' => $value['FULLNAME'],
							'IS_APPROVE' => 0,
							'REL_CODE' => $value['REL_CODE'],
							);
						$this->po_approval->insert($datas);
							//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Tender_winner/submit','po_approval','insert',$datas);
							//--END LOG DETAIL--//
						$count = $count + 1;
					} else {
						break;
					}
				}
			}
		}
		$this->load->model('po_header_comment');
		$comment_id = $this->po_header_comment->get_new_id(); 
		// $this->file_operation->upload(UPLOAD_PATH.'comment_attachment/'.$id."_".$comment_id, $_FILES);
		$current_date = oracledate(strtotime(date("d-m-Y H:i:s")));
		$dataComment = array(
			"PHC_ID" => $comment_id,
			"PO_ID" => $po_id,
			"PHC_COMMENT" => "'".str_replace("'", "''", $note)."'",
			"PHC_POSITION" => "'".$this->authorization->getCurrentRole()."'",
			"PHC_NAME" => "'".str_replace("'", "''", $this->authorization->getCurrentName())."'",
			"PHC_ACTIVITY" => "'Pembuatan LP3'",
			"PHC_START_DATE" => "'".$current_date."'",
			// "PTC_ATTACHMENT" => '\''.$_FILES["ptc_attachment"]["name"].'\''
			);

		$this->po_header_comment->insert($dataComment);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Tender_winner/submit','po_header_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		$pti = $this->prc_tender_item->ptm($ptm_number);
		$holder = true;
		foreach ($pti as $val) {
			if($val['TIT_STATUS']!='9' && $val['TIT_STATUS']!='10' && $val['TIT_STATUS']!='999'){
				$holder = false;
			}				
		}
		if($holder){
			$s['EMP_ID']=null;
			$w['PTM_NUMBER']=$ptm_number;
			$this->prc_process_holder->update($s,$w);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Tender_winner/submit','prc_process_holder','update',$s,$w);
				//--END LOG DETAIL--//
		}

		$this->session->set_flashdata('success', 'Create LP3 Berhasil. '.$lp3no);
		redirect('Tender_winner');
	}

	public function detail($po_id = null) {
		$this->load->model('po_detail');
		$this->load->model('po_header');
		$this->load->model('po_header_comment');
		$this->load->model('prc_tender_winner');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('adm_doctype_pengadaan');
		$this->load->library('sap_handler');

		$width = '100%';
		$height = '500px';
        $this->editor($width,$height); //plugin ckeditor di defenisikan pada halaman index


        $winner = $this->input->post('winner');
        $myCompany = $this->session->userdata('COMPANYID');
        if (empty($winner) && ($po_id == null)) {
        	redirect('Tender_winner');
        }
        $satu = 0;
        $data['title']= "Form LP3";
        $count = 0;
        if($po_id!==null){
        	$this->po_header->where_po($po_id);
        	$po_header = $this->po_header->get();
        	$po_header = $po_header[0];
        	$this->po_detail->where_po($po_id);
        	$po_detail = $this->po_detail->get();
        	$phc = $this->po_header_comment->get_from_po_id($po_id);
        	foreach ($po_detail as $key_po => $value_po) {
        		$winner[]=$value_po['PTW_ID'];
        		$itemtext[$value_po['PTW_ID']]=$value_po['ITEM_TEXT'];
        	}
        	$data['po_id'] = $po_id;
        	$data['DOC_TYPE'] = $po_header['DOC_TYPE'];
        	$data['docdate'] = date('Y-m-d',oraclestrtotime($po_header['DOC_DATE']));
        	$data['ddate'] = date('Y-m-d',oraclestrtotime($po_header['DDATE']));
        	$data['fixddate'] = $po_header['FIX_DDATE'];
        	$data['HEADER_TEXT'] = $po_header['HEADER_TEXT'];
        	$data['itemtext'] = $itemtext;
        	$data['COMMENT'] = $phc;

        }

		// die(print_r(explode('\n',$itemtext[167])));

        foreach ($winner as $key => $each_winner) {
        	$count++;
        	$this->prc_tender_winner->join_pr();
        	$twin = $this->prc_tender_winner->get($each_winner);
        	$twin = $twin[0];
        	$ptm = $twin['PTM_NUMBER'];
        	$vcode = $twin['PTV_VENDOR_CODE'];
        	$finalDate =  date('Y-m-d',strtotime($twin['PPI_DDATE']));
        	$twin['PPI_DDATE'] = $finalDate;
        	if($ptm != NULL){
        		$ptqm = $this->prc_tender_quo_main->ptmptv($ptm,$vcode);
        		$ptqm = $ptqm[0];
        		if($ptqm['PQM_DELIVERY_UNIT'] == "1"){
        			$twin['PQM_DELIVERY_TIME'] = $ptqm['PQM_DELIVERY_TIME'];
        		} else if ($ptqm['PQM_DELIVERY_UNIT'] == '2') {
        			$twin['PQM_DELIVERY_TIME'] = intval($ptqm['PQM_DELIVERY_TIME']) * intval(30);
        		} else if ($ptqm['PQM_DELIVERY_UNIT'] == '3'){
        			$twin['PQM_DELIVERY_TIME'] = intval($ptqm['PQM_DELIVERY_TIME']) * intval(7);
        		}
        	} else{
        		$twin['PQM_DELIVERY_TIME'] = 0;
        	}


        	$kode_rfq = $twin['PTV_RFQ_NO'];
        	$item_rfq = $twin['EBELP'];

        	$data['return_sap'][$count] = $this->sap_handler->getitemtext($kode_rfq, $item_rfq);
        	$data['winner'][$count] = $twin;
        }

        $fDoctype = array();
        if($myCompany == 2000 || $myCompany == 7000){
        	$fDoctype = array(2000,7000);
        }else{
        	$fDoctype = array($myCompany);
        }
        $this->adm_doctype_pengadaan->where_opco_in($fDoctype);
        $data['doctype'] = $this->adm_doctype_pengadaan->get(array('CAT' => 'F'));
        $this->layout->set_datetimepicker();
		// $this->layout->set_table_js();
		// $this->layout->set_table_cs();
        $this->layout->add_js('pages/tender_winner.js');
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
        $this->layout->add_css('plugins/selectize/selectize.css');
        $this->layout->add_js('plugins/selectize/selectize.js');
        $this->layout->add_js('pages/mydatepicker.js');
        $this->layout->render('detail', $data);
    }

    public function delete(){
    	$this->load->model('prc_tender_winner');
    	$id = $this->input->post('submit');
    	$this->prc_tender_winner->delete($id);
    	redirect('Tender_winner/');
    }

    public function create_po_sap($po_id) {
    	$this->load->model('po_detail');

    	$this->po_detail->where_po($po_id);
    	$po = $this->po_detail->get();

    	foreach ($po as $val) {
    		$poheader['doc_type'] = $val['DOC_TYPE'];
    		$poheader['purch_org'] = $val['PGRP'];
    		$poheader['pur_group'] = $val['PORG'];

    		$poitem['po_item'] = $val['POD_NUMBER'];
    		$poitem['rfq_no'] = $val['RFQ_NO'];
    		$poitem['rfq_item'] = $val['EBELP'];
			// $poitem['preq_no'] = substr($val['PPI_ID'], 0, 10);
			// $poitem['preq_item'] = substr($val['PPI_ID'], 10);
    	}

    	$this->load->library('sap_handler');
    	$return = $this->sap_handler->createporfq($poheader, $poitem);
    	var_dump($return);
    }

    public function ajax_get_po_detail(){
    	$this->load->model('po_header');
    	$this->load->model('po_detail');
    	$this->load->model('po_approval');
    	$this->load->model('po_header_comment');
    	$po_id = $this->input->post('po_id');
    	$this->po_header->where_po($po_id);
    	$po_header = $this->po_header->get();
    	$po_header = $po_header[0];
    	$this->po_detail->where_po($po_id);
    	$po_detail = $this->po_detail->get();
    	$phc = $this->po_header_comment->get_from_po_id($po_id);
    	$this->po_approval->where_po($po_id);
    	$approval = $this->po_approval->get();
    	
    	echo json_encode(array('po_header'=>$po_header,'po_detail'=>$po_detail, 'phc'=>$phc, 'approval'=>$approval));        
    }

    public function ajax_create_po_ptm() {
    	$this->load->model('prc_tender_winner');
    	$this->load->library('sap_handler');
    	$po_id = 0;
    	$pod_number = 10;
    	$poitem = array();
    	$is_contract = $this->input->post('is_contract');
    	foreach ($this->input->post('winner') as $key => $each_winner) {
    		$data = $this->prc_tender_winner->get($each_winner);
    		$doc_type = $this->input->post('doctype');
    		$po_item = $pod_number;
    		$ptm = $data[0]['PTM_NUMBER'];
    		$pur_group = $data[0]['PPR_PGRP'];
    		$purch_org = pgrp_to_porg($pur_group);

    		$poheader = compact('doc_type', 'pur_group', 'purch_org');

    		$pecah = explode($data[0]['PPI_PRNO'], $data[0]['PPI_ID']);
    		$item_pr = $pecah[1];
    		$rfq_no = $data[0]['PTV_RFQ_NO'];
    		$rfq_item = $data[0]['EBELP'];
    		$pr = $data[0]['PPI_PRNO'];
    		$poitem[] = compact('po_item', 'rfq_no', 'rfq_item','item_pr','pr');

    		$pod_number += 10;
    	}
    	if($is_contract == 1){
    		$retval = $this->sap_handler->create_po_contract($poheader,$poitem);
    	}else{
    		$retval = $this->sap_handler->createporfq($poheader, $poitem);
    	}
    	
    	echo json_encode($retval);
    }

    public function create_po($is_contract,$ptw){
    	$this->load->model('prc_tender_winner');
    	$this->load->model('po_detail');
    	$this->load->library('sap_handler');
    	$po_id = 0;
    	$pod_number = 10;
    	$poitem = array();		
    	foreach ($ptw as $key => $each_winner) {			
    		$data = $this->prc_tender_winner->get($each_winner);
    		$doc_type = $this->input->post('doctype');
    		$po_item = $pod_number;
    		$ptm = $data[0]['PTM_NUMBER'];
    		$pur_group = $data[0]['PPR_PGRP'];
    		$purch_org = pgrp_to_porg($pur_group);

    		$poheader = compact('doc_type', 'pur_group', 'purch_org');

    		$pecah = explode($data[0]['PPI_PRNO'], $data[0]['PPI_ID']);
			// $data_pr_item = $this->prc_tender_winner->getPRItem($data[0]['PPI_ID']);
			// // print_r($data_pr_item);die;
			// if(count($data_pr_item)>0){
			// 	$EBELP = $data_pr_item[0]['PPI_PRITEM'];
			// } else {
			// 	$EBELP = $data[0]['EBELP'];
			// }
    		$EBELP = $data[0]['EBELP'];
    		$item_pr = $pecah[1];
    		$rfq_no = $data[0]['PTV_RFQ_NO'];
    		$rfq_item = $EBELP;
    		$pr = $data[0]['PPI_PRNO'];
    		$this->po_detail->get_item($each_winner);
    		$data_item = $this->po_detail->get();
    		$item_text = strip_tags($data_item[0]['ITEM_TEXT']);
    		$poitem[] = compact('po_item', 'rfq_no', 'rfq_item','item_pr','pr','item_text');

    		$pod_number += 10;
    	}

		// die(var_dump($poitem));
		// echo "<pre>";
		// // echo $is_contract;
		// print_r($poheader);
		// print_r($poitem);
		// die;
    	
    	if($is_contract == 1){
    		$retval = $this->sap_handler->create_po_contract($poheader,$poitem);
    	}else{
    		$retval = $this->sap_handler->createporfq($poheader, $poitem);
    	}
    	
    	return $retval;
    }

    public function kirim_email_po($data_email){		
    	$this->load->library('email');
    	$this->config->load('email'); 
    	$semenindonesia = $this->config->item('semenindonesia'); 
    	$this->email->initialize($semenindonesia['conf']);
    	$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
    	
    	$this->email->to($data_email['EMAIL_ADDRESS']);
    	$this->email->cc('pengadaan.semenindonesia@gmail.com');

    	$this->email->subject("Pemberitahuan Tender Awarded / PO Released dari eProcurement ".$this->session->userdata['COMPANYNAME'].".");
    	$content = $this->load->view('email/tender_awarded',$data_email['data'],TRUE);
    	$this->email->message($content);
    	$this->email->send();
    }
    
}
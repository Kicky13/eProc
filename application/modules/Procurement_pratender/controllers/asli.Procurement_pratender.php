<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement_pratender extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('procurement_job');
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->library('comment');
	}

	public function index() {
		$this->get_detail();
	}

	public function get_detail($id = null,$cegatan = false) {
		// echo "<pre>";
		// print_r($this->input->post());
		// die;
		if ($id != null) {
			redirect('Procurement_pratender/attempt/' . $id);
		}
		$this->load->model('app_process_master');
		$this->load->model('prc_pr_item');
		$this->load->library('form_validation');
		$this->load->library('snippet');
		$this->load->model('com_jasa_group');

		$this->form_validation->set_rules('item', 'Item', 'required');
		//$this->form_validation->set_rules('vendor', 'Vendor', 'required');
		$this->form_validation->set_rules('ptp_batas_penawaran_atas', 'Batas Penawaran', 'numeric');
		$this->form_validation->set_rules('ptp_batas_penawaran_bawah', 'Batas Penawaran', 'numeric');

		$postvendor = (array) $this->input->post('vendor');
		$vndT = (array) $this->input->post('coba_vnd_terpilih_tambahan');
		$postVnd = count($postvendor);
		$postvndT = count($vndT);
		if ($this->form_validation->run() == FALSE && $postvendor[0]=="" && $vndT[0]=="") {
			// echo "masuk";
			$this->load->model('prc_doc_type_master');
			
			$data['title'] = "Pembuatan Sub Pratender";
			$this->prc_pr_item->where_verified();
			// $data['items'] = $this->prc_pr_item->get();
			$this->load->library('process');
			// $data['next_process'] = $this->process->get_next_process($id);
			$data['next_process']['NAMA_BARU'] = 'Approval Perencanaan';

			$data['ptm_comment'] = '';
			
			$data['rfq_type'] = $this->prc_doc_type_master->get();
			if($cegatan == true){
				// echo "true";
				$data['cegatan'] = true;
			} else {
				// echo "false";
				$data['cegatan'] = false;
			}
			$data['group_jasa']=$this->com_jasa_group->get_jasa();

			// die;

			$this->layout->set_table_js();
			$this->layout->set_table_cs();
			$this->layout->set_datetimepicker();
			$this->layout->add_js('pages/mydatetimepicker.js');
			$this->layout->add_js('pages/procurement_pratender.js?3');
			$this->layout->add_js('plugins/numeral/numeral.js');
			$this->layout->add_js('plugins/numeral/languages/id.js');
			$this->layout->add_css('plugins/select2/select2.css');
			$this->layout->add_css('plugins/select2/select2-bootstrap.css');
			$this->layout->add_js('plugins/select2/select2.js');
			$this->layout->render('detail_procurement_pratender', $data);
		} else {
			// echo "masuk2";
			// die;
			$this->update();
		}
	}

	public function update() {
		// $this->input->post('vendor_tambahan') diganti $this->input->post('coba_vnd_terpilih_tambahan')
		/* Batasan vendor lagi -_- */
		$postvendor = (array) $this->input->post('vendor');
		$postVnd = count($postvendor);
		// echo $postVnd;
		// die;
		if($this->input->post('coba_vnd_terpilih_tambahan')){
			$vndT = (array) $this->input->post('coba_vnd_terpilih_tambahan');
			$postVnd = $postVnd + count($vndT);
		}

		$ptp_justification = $this->input->post('ptp_justification');
		// $postvendor = array_unique($postvendor);
		// echo $ptp_justification;die;
		if($ptp_justification == "2") {
			// if($postVnd != 1){
			if($postVnd == 0){
				// echo "$postVnd";
				// echo "masuk";die;
				$this->get_detail(null, true);
			}
		}

		// echo "<pre>";
		// print_r($_POST);
		// die;

		//*/

		$this->load->library("file_operation");
		$this->load->model('prc_it_service');
		$this->load->model('prc_pr_item');
		$this->load->model('prc_purchase_requisition');
		$this->load->model('prc_tender_approve');
		$this->load->model('prc_tender_approve_vendor');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_item_log');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_main_log');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_vendor');

		$ptm_number = $this->prc_tender_main->get_id();
		/* maksa ngambil pgrp */
		for ($i=0; $i < count($_POST['item']); $i++) {
			$penam = explode(':', $_POST['item'][$i]);

			$ppi_id = $penam[0]; // 
			$qty = $_POST['qty'][$i]; // titqty

			// get ppi by ppi id, trus if (titqty > openqty - tenderqty) maka gagal

			$ppi = $this->prc_pr_item->get(array('PPI_ID' => $ppi_id));
			$ppi = $ppi[0];
			if ($qty > $ppi['PPI_QUANTOPEN'] - $ppi['PPI_QTY_USED']) {
				redirect('Procurement_pratender/get_detail');
			}
		}

		$penam = explode(':', $_POST['item'][0]);

		$rand = $this->prc_pr_item->get(array('PPI_ID' => $penam[0]));
		$rand = $rand[0];

		// ambil pgrp
		$pr0 = $this->prc_purchase_requisition->pr($rand['PPI_PRNO']);
		$ekgrp = $pr0['PPR_PGRP'];
		$ptm['PTM_PGRP'] = $ekgrp;
		//*/

		$kel_plant_pro = $this->session->userdata('KEL_PRGRP');
		if (empty($kel_plant_pro)) {
			// echo "Anda tidak punya KEL_PLANT_PRO"; exit();
			$kel_plant_pro = 2;
		}

		$justification = $this->input->post('ptp_justification');
		if ($justification == 2) {
			$justification += $this->input->post('detail_justification');
		}

		$newTits = array();
		for ($i=0; $i < count($_POST['item']); $i++) {
			$penam = explode(':', $_POST['item'][$i]);
			$this->prc_pr_item->where_id($ppi_id);
			$pritemset = $this->prc_pr_item->get();
			$primat = $pritemset[0]['PPI_MATGROUP'];
			$pritem[] = array(
				'prno' => $pritemset[0]['PPI_PRNO'],
				'pritem' => $pritemset[0]['PPI_PRITEM'],
				'qty' => $_POST['qty'][$i],
				'uom' => $pritemset[0]['PPI_UOM'],
				);
		}

		if ($this->input->post('coba_vnd_terpilih_tambahan')) {
			$postvendor = (array) $this->input->post('vendor');
			$postvendor = array_unique($postvendor);
			$postVendorTmbn = $this->input->post('coba_vnd_terpilih_tambahan');
			$postVendorTmbn = array_unique($postVendorTmbn);
			$vendor = array_merge($postvendor,$postVendorTmbn);
		} else {
			$postvendor = (array) $this->input->post('vendor');
			$postvendor = array_unique($postvendor);
			$vendor = $postvendor;
		}


		$this->load->model('vnd_header');
		$this->load->library('sap_handler');

		foreach ($vendor as $key => $value) {
			if($value!=""){
				$paramven = $this->vnd_header->where("VENDOR_NO",$value)->get_all();
				$vendorpilih[] = array('vendor_no' => $paramven[0]['VENDOR_NO'], 'vendor_name' => $paramven[0]['VENDOR_NAME'], 'matkl' => $primat);
			}
		}
		// print_r($vendorpilih);die;
		$ekorg = $pr0['PPR_PORG'];

		$cekmatkl = $primat;
		$cekdesc = $this->input->post('subject');
		$cekjust = $justification;
		$cekpritem = $pritem;
		$cekvendorpilih = $vendorpilih;
		$cekekorg = $ekorg;
		$cekekgrp = $ekgrp;

		$subpratender = $this->sap_handler->save_subpratender($cekmatkl, $cekdesc, $cekjust, $cekpritem, $cekvendorpilih, $cekekorg, $cekekgrp);

		// CEK SLB
		if ($subpratender[0]['TYPE'] == 'E') {
			// $subpratender[0]['MESSAGE'] = "Empty $subpratender. Are you connected to SAP?";
			// $this->session->set_flashdata('gagal_subpratender', $subpratender[0]);
			// $this->session->set_flashdata('detail_gagal_subpratender', $subpratender);
			// redirect('Procurement_pratender/get_detail/');
			$this->session->set_flashdata('warning_slb', 'Tidak bisa create nomor Subpratender');
			redirect('Procurement_pratender/get_detail/');
		} else {
			if (!isset($subpratender[0]['MESSAGE']) || $subpratender[0]['MESSAGE'] == '') {
				$this->session->set_flashdata('gagal_subpratender', $subpratender[0]);
				$this->session->set_flashdata('detail_gagal_subpratender', $subpratender);
				redirect('Procurement_pratender/attempt/' . $ptm_number);
			}

			/* Create PTM */
			$ptm['PTM_NUMBER'] = $ptm_number;
			$ptm['PTM_STATUS'] = 1;
			$ptm['PTM_REQUESTER_NAME'] = $this->session->userdata['FULLNAME'];
			$ptm['PTM_SUBJECT_OF_WORK'] = $this->input->post('subject');
			$ptm['PTM_CREATED_DATE'] = date('d-M-Y g.i.s A');
			$ptm['PTM_COUNT_RETENDER'] = 0;
			$ptm['PTM_RFQ_TYPE'] = $this->input->post('ptm_rfq_type');
			$ptm['PTM_REQUESTER_ID'] = $this->authorization->getEmployeeId();
			$ptm['PTM_COMPANY_ID'] = $this->authorization->getCompanyId();
			$ptm['SAMPUL'] = 1;
			$ptm['KEL_PLANT_PRO'] = $kel_plant_pro;
			$ptm['IS_JASA'] = $this->input->post('jenis_perencanaan');
			$ptm['JUSTIFICATION'] = $justification;

			$this->prc_tender_main->insert_single($ptm);
					//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Konfigurasi Staf Perencanaan','OK',$this->input->ip_address()
				);
			$LM_ID = $this->log_data->last_id();
					//--END LOG MAIN--//
					//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_pratender/update','prc_tender_main','insert',$ptm);
					//--END LOG DETAIL--//

			$new_update['PTM_SUBPRATENDER'] = $subpratender[0]['MESSAGE'];
			$this->prc_tender_main->updateByPtm($ptm_number, $new_update);
					//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_pratender/update','prc_tender_main','update',$new_update,array('PTM_NUMBER'=>$ptm_number));
					//--END LOG DETAIL--//

			/* INSERT TITS */
				// harusnya hapus semua tits yang ada dulu
			$newTits = array();
			$temp['TIT_ID'] = $this->prc_tender_item->get_id();
			$ebelp = 10;
			for ($i=0; $i < count($_POST['item']); $i++) {
				$penam = explode(':', $_POST['item'][$i]);
				$this->prc_pr_item->where_id($ppi_id);
				$pritemset = $this->prc_pr_item->get();
				$pritemset = $pritemset[0];

					// jika pengadaan jasa
					// if ($this->input->post('jenis_perencanaan') == 1) {
					// 	$ppi_id = $penam[0];

					// 	/* Set manual quantopen because fuck trigger */
					// 	$used = $pritemset['PPI_PRQUANTITY'] - $pritemset['PPI_QUANTOPEN'];
					// 	$this->prc_pr_item->update(array('PPI_QTY_USED' => $used), array('PPI_ID' => $ppi_id));
					// 		//--LOG DETAIL--//
					// 	$this->log_data->detail($LM_ID,'Procurement_pratender/update','prc_pr_item','update',array('PPI_QTY_USED' => $used), array('PPI_ID' => $ppi_id));
					// 		//--END LOG DETAIL--//
					// 	//*/

					// 	$services = $this->prc_it_service->ppi($ppi_id);
					// 	foreach ($services as $val) {
					// 		$temp['PPI_ID'] = $ppi_id;
					// 		$temp['SERVICE_ID'] = $val['SERVICE_ID'];
					// 		$temp['TIT_PRICE'] = $val['TBTWR'] * 100;
					// 		$temp['TIT_QUANTITY'] = $val['MENGE'];

					// 		$temp['PTM_NUMBER'] = $ptm_number;
					// 		$temp['TIT_EBELP'] = $ebelp;
					// 		$newTits[] = $temp;
					// 		$temp['TIT_ID']++;
					// 		$ebelp += 10;
					// 	}
					// } 
					// // Jika pengadaan barang
					// else {
				$temp['PPI_ID'] = $penam[0];
				$temp['TIT_PRICE'] = $penam[1];
				$temp['TIT_QUANTITY'] = $_POST['qty'][$i];

				$temp['PTM_NUMBER'] = $ptm_number;
				$temp['TIT_EBELP'] = $ebelp;
				$newTits[] = $temp;
				$temp['TIT_ID']++;
				$ebelp += 10;
					// }

				/* Ngeset count tender */ 
						// --> di oper ke controller procurement_release jika sudah create rfq =>rg
					// $setpritem = array('COUNT_TENDER' => $pritemset['COUNT_TENDER'] + 1);
					// $wherepritem = array('PPI_ID' => $penam[0]);
					// $this->prc_pr_item->update($setpritem, $wherepritem);
					//*/
			}
				// $this->prc_tender_item->deleteByPtm($ptm_number);
			$this->prc_tender_item->insert_batch($newTits);
					//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_pratender/update','prc_tender_item','insert',$newTits);
					//--END LOG DETAIL--//
				// $this->prc_tender_item_log->insert_batch($newTits);

				//*/

			/* transaksi aproval */
			$tap_id = $this->prc_tender_approve->get_id();
			$tap = array(
				'TAP_ID' => $tap_id,
				'PTM_NUMBER' => $ptm_number,
				'TAP_USER' => $this->session->userdata['FULLNAME'],
				'TAP_USER_ID' => $this->authorization->getEmployeeId(),
				'TAP_CREATED_AT' => date('d-M-Y g.i.s A'),
				'TAP_ITERATION' => $ptm['PTM_COUNT_RETENDER'],
				'TAP_COUNTER' => 0,
				);
			$this->prc_tender_approve->insert($tap);
					//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Procurement_pratender/update','prc_tender_approve','insert',$tap);
					//--END LOG DETAIL--//

			/* Generate vendor */
			$data['PTM_NUMBER'] = $ptm_number;
			$this->prc_tender_vendor->delete($data);
			$tapv['TAP_ID'] = $tap_id;
			$tapv['TAPV_ID'] = $this->prc_tender_approve_vendor->get_id();

			$postvendor = (array) $this->input->post('vendor');
			$postvendor = array_unique($postvendor);
			foreach ($postvendor as $key) {
				if($key!=""){
					$data['PTV_ID'] = $this->prc_tender_vendor->get_id();
					$data['PTV_VENDOR_CODE'] = $key;
					$this->prc_tender_vendor->insert_array($data);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Procurement_pratender/update','prc_tender_vendor','insert',$data);
						//--END LOG DETAIL--//

					$tapv['PTV_VENDOR_CODE'] = $key;
					$this->prc_tender_approve_vendor->insert($tapv);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Procurement_pratender/update','prc_tender_approve_vendor','insert',$tapv);
						//--END LOG DETAIL--//
					$tapv['TAPV_ID']++;
				}
			}
				//*/

				//proses insert vendor tambahan / Vendor Non Dirven
			if ($this->input->post('coba_vnd_terpilih_tambahan') != false) {		
				$postVendorTmbn = $this->input->post('coba_vnd_terpilih_tambahan');
				$postVendorTmbn = array_unique($postVendorTmbn);
				foreach ($postVendorTmbn as $key) {
					$dataT['PTM_NUMBER'] = $ptm_number;
					$dataT['PTV_ID'] = $this->prc_tender_vendor->get_id();
					$dataT['PTV_VENDOR_CODE'] = $key;
						$dataT['PTV_NON_DIRVEN'] = '1'; // 1=VENDOR NON DIRVEN
						$this->prc_tender_vendor->insert_array($dataT);
							//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Procurement_pratender/update','prc_tender_vendor','insert',$dataT);
							//--END LOG DETAIL--//

						$tapvT['TAPV_ID'] = $this->prc_tender_approve_vendor->get_id();
						$tapvT['PTV_VENDOR_CODE'] = $key;
						$this->prc_tender_approve_vendor->insert($tapvT);
							//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Procurement_pratender/update','prc_tender_approve_vendor','insert',$tapvT);
							//--END LOG DETAIL--//
					}
				}
				//*/

				/* UPDATE PTP */
				$ptp_id = $this->prc_tender_prep->get_id();

				$ptp['PTP_ID'] = $ptp_id;
				// $ptp['PTP_IS_ITEMIZE'] = $this->input->post('is_itemize');
				$ptp['PTP_JUSTIFICATION'] = $justification;
				$ptp['PTP_EVALUATION_METHOD'] = 1;
				
				$ptp['PTM_NUMBER'] = $ptm_number;
				$ptp['PTP_WARNING'] = $this->input->post('ptp_warning');
				$ptp['PTP_BATAS_PENAWARAN'] = $this->input->post('ptp_batas_penawaran_atas') == '' ? 0 : intval($this->input->post('ptp_batas_penawaran_atas'));
				$ptp['PTP_BAWAH_PENAWARAN'] = $this->input->post('ptp_batas_penawaran_bawah') == '' ? 100 : intval($this->input->post('ptp_batas_penawaran_bawah'));
				if($this->input->post('ptp_filter_name') != false){
					$ptp['PTP_FILTER_VND_PRODUCT'] = $this->input->post('ptp_filter_vnd_product');
					$ptp['PTP_FILTER_NAME'] = $this->input->post('ptp_filter_name');
				}
				// var_dump($ptp); exit();
				$this->prc_tender_prep->insert_single($ptp);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_pratender/update','prc_tender_prep','insert',$ptp);
					//--END LOG DETAIL--//

				// insert and upload comment attachment
				$comment_id = $this->comment->get_new_id();
				$dataComment = array(
					"PTC_ID" => $comment_id,
					"PTM_NUMBER" => $ptm_number,
					"PTC_COMMENT" => '\''.$this->input->post('comment').'\'',
					"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
					"PTC_NAME" => '\''.$this->authorization->getCurrentName().'\'',
					"PTC_ACTIVITY" => '\''."Konfigurasi Perencanaan".'\''
					);
				$this->comment->insert_comment_tender($dataComment);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_pratender/update','prc_tender_comment','insert',$dataComment);
					//--END LOG DETAIL--//

				$this->session->set_flashdata('tambahaninfo', ' Nomor Subpratender: '.$subpratender[0]['MESSAGE'].'.');
			}
		// END CEK SLB
			$this->load->library('process');
			$this->process->next_process($ptm_number, 'NEXT', $LM_ID);

			$this->session->set_flashdata('success', 'success'); redirect('Job_list');
		}

		public function approval($id) {
			// error_reporting(E_ALL);
			$this->procurement_job->check_authorization();
			$this->load->library('form_validation');
			// echo "<pre>";
			// print_r($this->input->post());
			// die;

			$postvendor = (array) $this->input->post('vendor');
			$vndT = (array) $this->input->post('vendor_tambahan');
			$postVnd = count($postvendor);
			$postvndT = count($vndT);
			// echo $postVnd."<br>";
			// echo $postvndT."<br>";
			// echo $postvendor[0]."<br>";
			// echo $vndT[0]."<br>";
			// if ($this->form_validation->run() == FALSE && $postvendor[0]=="" && $vndT[0]=="") {
			// die;
			// $this->form_validation->set_rules('vendor', 'Vendor', 'required');
			$this->form_validation->set_rules('ptp_batas_penawaran_atas', 'Batas Penawaran', 'numeric');
			$this->form_validation->set_rules('ptp_batas_penawaran_bawah', 'Batas Penawaran', 'numeric');
			if ($this->form_validation->run() == FALSE && $this->input->post('harus_pilih') != 'reject' && $postvendor[0]=="" && $vndT[0]=="")
			{
				//echo "if";die;
				$data['title'] = "Approval Perencanaan";
				$this->layout->set_table_js();
				$this->layout->set_table_cs();
				$this->layout->set_datetimepicker();
				$this->load->model('prc_doc_type_master');
				$this->load->model('prc_tender_vendor');
				$this->load->library('snippet');
				$this->load->model('prc_plan_doc');
				$this->load->model('prc_tender_main');
				$this->load->model('prc_tender_item');
				$this->load->model('prc_tender_prep');
				$ptm = $this->prc_tender_main->ptm($id);
				$data['ptm'] = $ptm[0];
				$data['ptp'] = $this->prc_tender_prep->ptm($id);

				$data['ptv'] = $this->prc_tender_vendor->ptm($id);
			// $this->prc_tender_item->join_pr();
			// $data['tit'] = $this->prc_tender_item->ptm($id);
				// echo "<pre>";
				// print_r($data['ptm']);die;
				
				//HANYA UNTUK 2000
				$companyid = $this->authorization->getCompanyId();
				$this->prc_tender_item->join_pr();
				$tit_e = $this->prc_tender_item->get(array('PTM_NUMBER'=>$id));
				$total = 0;
				foreach ($tit_e as $val){
					$total += $val['TIT_PRICE'] * $val['TIT_QUANTITY'];
				}
				// echo $total;die;
				// echo "<pre>";
				// print_r($data['tit']);die;
				//JUSTIFICATION
				// 1:pemilihan_langsung
				// 3:lelang_terbuka
				// 4:pembelian_langsung
				// 5:RO
				// 6:SA
				// 7:TF
				// 8:OT

				if($data['ptm']['PTM_STATUS']==3 && $companyid==5000){
					if($data['ptm']['JUSTIFICATION']==1){
						$status_kewenangan = "DC";
					} else if($data['ptm']['JUSTIFICATION']>=4 && $data['ptm']['JUSTIFICATION']<=8){
						$status_kewenangan = "PL";
					}
					$purchase_grp = $data['ptm']['PTM_PGRP'];

					$this->load->model('adm_approve_kewenangan');
					$this->adm_approve_kewenangan->join_emp();
					$this->adm_approve_kewenangan->where_pgrp($purchase_grp);
					$this->adm_approve_kewenangan->where_catprc($status_kewenangan);
					$cek_kewenangan = $this->adm_approve_kewenangan->get();
					// echo "<pre>";
					// print_r($cek_kewenangan);die;
					if(count($cek_kewenangan)>0){
						$count = 0;
						foreach ($cek_kewenangan as $key => $value) {			
							if(!empty($value['BATAS_HARGA']) && $value['BATAS_HARGA']!='NULL'){
								if($total <= $value['BATAS_HARGA']){				
									$count = $count + 1;
									break;
								} else if($total > $value['BATAS_HARGA']){
									$count = $count + 1;
								} else {
									break;
								}
							}
						}
						if($count>1){
							if($data['ptm']['TAMBAHAN_APPROVAL']==""){
								$posisi = 1;
								$data['next_process']['NAMA_BARU'] = $cek_kewenangan[$posisi]['FULLNAME'];
							} else if (intval($data['ptm']['TAMBAHAN_APPROVAL'])!==intval($count)){
								$posisi = $data['ptm']['TAMBAHAN_APPROVAL']+1;
								$data['next_process']['NAMA_BARU'] = $cek_kewenangan[$posisi]['FULLNAME'];
							} else {
								$this->load->library('process');
								$data['next_process'] = $this->process->get_next_process($id);	
							}
						} else {
							$this->load->library('process');
							$data['next_process'] = $this->process->get_next_process($id);
						}
					} else {
						$this->load->library('process');
						$data['next_process'] = $this->process->get_next_process($id);
					}
				} else {
					$this->load->library('process');
					$data['next_process'] = $this->process->get_next_process($id);
				}
				//HANYA UNTUK 2000

				// echo $this->authorization->getCompanyId();
				// echo "<pre>";
				// print_r($cek_kewenangan);
				// print_r($data['next_process']);die;
				// $data['next_process']['NAMA_BARU'] = 'Pilih Vendor';

				$data['detail_item_ptm'] = $this->snippet->detail_item_ptm($id);
				$data['ptm_comment'] = $this->snippet->ptm_comment($id);
				$data['rfq_type'] = $this->prc_doc_type_master->get();

				$this->load->model('adm_cctr');
				$this->load->model('adm_employee');
				$this->adm_cctr->where_kel_com($data['ptm']['KEL_PLANT_PRO']);
				$cctr = $this->adm_cctr->get();
				$data['cctr'] = array_build_key($cctr, 'CCTR');

				$this->prc_tender_prep->join_eval_template();

				$data['buyer'] = $this->adm_employee->find($data['ptm']['PTM_ASSIGNMENT']);

				$this->prc_tender_item->join_pr();
				$data['tit'] = $this->prc_tender_item->ptm($id);

				$dokumen = array();
				$dokumens = array();
				$privacy = null;
				$active = true;

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
				// var_dump($dokumen['itemdoc']);
				// die();
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
							$dok[$count]['PDC_NAME'] = $val['PDC_NAME'];
							$dok[$count]['PDC_IS_PRIVATE'] = $val['PDC_IS_PRIVATE'];
							$dok[$count]['PPD_DESCRIPTION'] = $val['PPD_DESCRIPTION'];
							$dok[$count]['item'][0]['DECMAT'] = $dokumens[$ppi_id]['PPI_DECMAT'];
							$dok[$count]['item'][0]['NOMAT'] =  $dokumens[$ppi_id]['PPI_NOMAT'];
							$count = $count + 1;
						}
					// var_dump($val);
					}
				}
				$data['dokumen'] = $dok;

				$this->prc_tender_vendor->join_vnd_header();
				$data['vendor_tambahan'] = (array) $this->prc_tender_vendor->get(array('PTM_NUMBER' => $id, 'PTV_NON_DIRVEN' => 1));

				$this->layout->set_table_js();
				$this->layout->set_table_cs();
				$this->layout->set_datetimepicker();
				$this->layout->add_js('pages/mydatetimepicker.js');
				$this->layout->add_js('pages/procurement_pengadaan.js?2');
				$this->layout->add_js('plugins/numeral/numeral.js');
				$this->layout->add_js('plugins/numeral/languages/id.js');
				$this->layout->add_css('plugins/select2/select2.css');
				$this->layout->add_css('plugins/select2/select2-bootstrap.css');
				$this->layout->add_js('plugins/select2/select2.js');
			// var_dump($data);
			// die();
				// echo "<pre>";
				// print_r($data);die;
				$this->layout->render('approval_procurement_pratender', $data);
			} else {
				//echo "else";die;
				$this->submit_approval($id);
			}
		}

		public function submit_approval($id) {
			$ptm_number = $id;

			/* UPDATE PTP */
			$submit = $this->input->post('harus_pilih');
			if($submit == "accept"){
				$this->load->model('prc_tender_prep');
				$this->load->model('prc_tender_approve');
				$this->load->model('prc_tender_vendor');
				$this->load->model('prc_tender_approve_vendor');
				$this->load->model('prc_tender_main');

				$ptp['PTM_NUMBER'] = $ptm_number;
				$ptp['PTP_WARNING'] = $this->input->post('ptp_warning');
				$ptp['PTP_BATAS_PENAWARAN'] = $this->input->post('ptp_batas_penawaran_atas') == '' ? 0 : intval($this->input->post('ptp_batas_penawaran_atas'));
				$ptp['PTP_BAWAH_PENAWARAN'] = $this->input->post('ptp_batas_penawaran_bawah') == '' ? 100 : intval($this->input->post('ptp_batas_penawaran_bawah'));
				if($this->input->post('file_upload')){
					$ptp['PTP_UPLOAD_USULAN_VENDOR']=$this->input->post('file_upload');
				}

				$ptm = $this->prc_tender_main->ptm($id);
				$ptm = $ptm[0];

				//HANYA UNTUK 2000
				$companyid = $this->authorization->getCompanyId();
				$JABATAN = null;
				$this->prc_tender_item->join_pr();
				$tit_e = $this->prc_tender_item->get(array('PTM_NUMBER'=>$id));
				$total = 0;
				foreach ($tit_e as $val){
					$total += $val['TIT_PRICE'] * $val['TIT_QUANTITY'];
				}

				if($ptm['PTM_STATUS']==3 && $companyid==5000){
					if($ptm['JUSTIFICATION']==1){
						$status_kewenangan = "DC";
					} else if($ptm['JUSTIFICATION']>=4 && $ptm['JUSTIFICATION']<=8){
						$status_kewenangan = "PL";
					}
					$purchase_grp = $ptm['PTM_PGRP'];

					$this->load->model('adm_approve_kewenangan');
					$this->adm_approve_kewenangan->join_emp();
					$this->adm_approve_kewenangan->where_pgrp($purchase_grp);
					$this->adm_approve_kewenangan->where_catprc($status_kewenangan);
					$cek_kewenangan = $this->adm_approve_kewenangan->get();

					if(count($cek_kewenangan)>0){
						$count = 0;
						foreach ($cek_kewenangan as $key => $value) {			
							if(!empty($value['BATAS_HARGA']) && $value['BATAS_HARGA']!='NULL'){
								if($total <= $value['BATAS_HARGA']){				
									$count = $count + 1;
									break;
								} else if($total > $value['BATAS_HARGA']){
									$count = $count + 1;
								} else {
									break;
								}
							}
						}

						$this->load->model('prc_process_holder');
						if($count>1){
							if($ptm['TAMBAHAN_APPROVAL']==""){
								$posisi = 1;
								$EMP_ID = $cek_kewenangan[$posisi]['EMP_ID'];
								$JABATAN = $cek_kewenangan[$posisi]['JABATAN'];
								$this->prc_tender_main->updateByPtm($id, array('TAMBAHAN_APPROVAL' => $posisi, 'TAMBAHAN_APPROVAL_NAME' => 'Approval '.$JABATAN));
								$this->prc_process_holder->update(array('EMP_ID' => $EMP_ID), array('PTM_NUMBER'=>$ptm_number));
							} else if (intval($ptm['TAMBAHAN_APPROVAL'])!==intval($count)){
								$posisi = $ptm['TAMBAHAN_APPROVAL']+1;
								$JABATAN = $cek_kewenangan[$posisi]['JABATAN'];
								$EMP_ID = $cek_kewenangan[$posisi]['EMP_ID'];
								$this->prc_tender_main->updateByPtm($id, array('TAMBAHAN_APPROVAL' => $posisi, 'TAMBAHAN_APPROVAL_NAME' => 'Approval '.$JABATAN));
								$this->prc_process_holder->update(array('EMP_ID' => $EMP_ID), array('PTM_NUMBER'=>$ptm_number));
							} else {
								$this->load->library('process');
								$this->process->next_process($ptm_number, 'NEXT', $LM_ID);	
							}
						} else {
							$this->load->library('process');
							$this->process->next_process($ptm_number, 'NEXT', $LM_ID);	
						}
					} else {
						$this->load->library('process');
						$this->process->next_process($ptm_number, 'NEXT', $LM_ID);
					}
				} else {
					$this->load->library('process');
					$this->process->next_process($ptm_number, 'NEXT', $LM_ID);
				}
				//HANYA UNTUK 2000

				//--LOG MAIN--//
				//lama
				// $this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				// 	$this->authorization->getCurrentRole(),$this->input->post('process_name'),'OK',$this->input->ip_address()
				// 	);
				if($JABATAN == null){
					$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
						$this->authorization->getCurrentRole(),$this->input->post('process_name'),'OK',$this->input->ip_address()
						);
				} else {
					$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
						$JABATAN,'Approval '.$JABATAN,'OK',$this->input->ip_address()
						);
				}
				$LM_ID = $this->log_data->last_id();
				//--END LOG MAIN--//

				$this->prc_tender_prep->updateByPtm($id, $ptp);
				//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_pratender/submit_approval','prc_tender_prep','update',$ptp,array('PTM_NUMBER'=>$id));
				//--END LOG DETAIL--//

				/* transaksi aproval */
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
				$this->log_data->detail($LM_ID,'Procurement_pratender/submit_approval','prc_tender_approve','insert',$tap);
				//--END LOG DETAIL--//

				/* update dan simpan vendor */
				$data['PTM_NUMBER'] = $ptm_number;
				$this->prc_tender_vendor->delete($data);
				//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_pratender/submit_approval','prc_tender_vendor','delete',null,$data);
				//--END LOG DETAIL--//
				$tapv['TAP_ID'] = $tap_id;
				$tapv['TAPV_ID'] = $this->prc_tender_approve_vendor->get_id();

				$postvendor = $this->input->post('vendor');
				$postvendor = array_unique($postvendor);
				foreach ($postvendor as $key) {
					if($key!=""){
						$data['PTV_ID'] = $this->prc_tender_vendor->get_id();
						$data['PTV_VENDOR_CODE'] = $key;
						$this->prc_tender_vendor->insert_array($data);
						//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Procurement_pratender/submit_approval','prc_tender_vendor','insert',$data);
						//--END LOG DETAIL--//

						$tapv['PTV_VENDOR_CODE'] = $key;
						$this->prc_tender_approve_vendor->insert($tapv);
						//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Procurement_pratender/submit_approval','prc_tender_approve_vendor','insert',$tapv);
						//--END LOG DETAIL--//
						$tapv['TAPV_ID']++;
					}
				}

				//proses insert vendor tambahan / Vendor Non Dirven
				if ($this->input->post('vendor_tambahan') != false) {		
					$postVendorTmbn = $this->input->post('vendor_tambahan');
					$postVendorTmbn = array_unique($postVendorTmbn);

					foreach ($postVendorTmbn as $key) {
						$dataT['PTM_NUMBER'] = $ptm_number;
						$dataT['PTV_ID'] = $this->prc_tender_vendor->get_id();
						$dataT['PTV_VENDOR_CODE'] = $key;
						$dataT['PTV_NON_DIRVEN'] = '1'; // 1=VENDOR NON DIRVEN
						$this->prc_tender_vendor->insert_array($dataT);
						//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Procurement_pratender/submit_approval','prc_tender_vendor','insert',$dataT);
						//--END LOG DETAIL--//

						$tapvT['TAPV_ID'] = $this->prc_tender_approve_vendor->get_id();
						$tapvT['PTV_VENDOR_CODE'] = $key;
						$this->prc_tender_approve_vendor->insert($tapvT);
						//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Procurement_pratender/submit_approval','prc_tender_approve_vendor','insert',$tapvT);
						//--END LOG DETAIL--//
					}
				}
				//*/
				
			// insert and upload comment attachment
				$comment_id = $this->comment->get_new_id();
				$dataComment = array(
					"PTC_ID" => $comment_id,
					"PTM_NUMBER" => $ptm_number,
					"PTC_COMMENT" => '\''.$this->input->post('comment').'\'',
					"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
					"PTC_NAME" => '\''.$this->authorization->getCurrentName().'\'',
					"PTC_ACTIVITY" => '\''."Approval Perencanaan".'\''
					);
				$this->comment->insert_comment_tender($dataComment);
				//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_pratender/submit_approval','prc_tender_comment','insert',$dataComment);
				//--END LOG DETAIL--//

				$this->session->set_flashdata('success', 'success'); redirect('Job_list');
			} else {
				$this->load->model('prc_tender_item');
				$this->load->model('prc_pr_item');
				$this->load->model('prc_tender_main');
				$this->load->model('adm_employee');
				$this->load->library('snippet');			

				//--LOG MAIN--//
				$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
					$this->authorization->getCurrentRole(),$this->input->post('process_name'),'REJECT',$this->input->ip_address()
					);
				$LM_ID = $this->log_data->last_id();
				//--END LOG MAIN--//

				$item = $this->prc_tender_item->ptm($id);
				foreach ($item as $key => $value) {
					$pr_item = $this->prc_pr_item->get(array('PPI_ID'=>$value['PPI_ID']));
					$this->prc_pr_item->update(array('PPI_QTY_USED' => $pr_item[0]['PPI_QTY_USED'] - $value['TIT_QUANTITY']), array('PPI_ID'=>$pr_item[0]['PPI_ID']));
					//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Procurement_pratender/submit_approval','prc_pr_item','update',array('PPI_QTY_USED' => $pr_item[0]['PPI_QTY_USED'] - $value['TIT_QUANTITY']),array('PPI_ID'=>$pr_item[0]['PPI_ID']));
					//--END LOG DETAIL--//
				}
				
				$data = $this->prc_tender_main->ptm($id);
				$this->prc_tender_main->updateByPtm($id, array('PTM_STATUS' => $data['0']['PTM_STATUS'] * - 1 ));
				//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_pratender/submit_approval','prc_tender_main','update',array('PTM_STATUS' => $data['0']['PTM_STATUS'] * - 1 ),array('PTM_NUMBER'=>$id));
				//--END LOG DETAIL--//

			// insert comment
				$comment_id = $this->comment->get_new_id();
				$dataComment = array(
					"PTC_ID" => $comment_id,
					"PTM_NUMBER" => $ptm_number,
					"PTC_COMMENT" => '\''.$this->input->post('comment').'\'',
					"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
					"PTC_NAME" => '\''.$this->authorization->getCurrentName().'\'',
					"PTC_ACTIVITY" => '\''."Approval Perencanaan".'\''
					);
				$this->comment->insert_comment_tender($dataComment);
				//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_pratender/submit_approval','prc_tender_comment','insert',$dataComment);
				//--END LOG DETAIL--//

				$emp = $this->adm_employee->get(array('ID'=>$data[0]['PTM_REQUESTER_ID']));
				$user['EMAIL'] = $emp[0]['EMAIL'];
				$user['data']['ptm_subpratender'] = $data[0]['PTM_SUBPRATENDER'];
				$user['data']['rejector'] = $this->session->userdata['FULLNAME'];
				$user['data']['tgl_reject'] = date('d-M-Y H:i:s');
				$user['data']['komentar'] = $this->input->post('comment');
				$user['data']['detail_item']=$this->snippet->detail_item_ptm($id,false,true);

				$this->kirim_email_reject($user);

				$this->session->set_flashdata('reject', 'reject'); redirect('Job_list');

			}
		}

		public function attempt($id) {
			$this->procurement_job->check_authorization();
			$this->load->library('form_validation');

		// die(var_dump($this->input->post()));
			$this->form_validation->set_rules('vendor', 'Vendor', 'required');
			$this->form_validation->set_rules('ptp_batas_penawaran_atas', 'Batas Penawaran', 'numeric');
			$this->form_validation->set_rules('ptp_batas_penawaran_bawah', 'Batas Penawaran', 'numeric');
			if ($this->form_validation->run() == FALSE) {
				$data['title'] = "Konfigurasi Perencanaan";
				$this->layout->set_table_js();
				$this->layout->set_table_cs();
				$this->layout->set_datetimepicker();
				$this->load->model('prc_doc_type_master');
				$this->load->model('prc_tender_vendor');
				$this->load->library('snippet');
				$this->load->model('prc_plan_doc');


				$this->load->model('prc_tender_main');
				$this->load->model('prc_tender_item');
				$this->load->model('prc_tender_prep');
				$ptm = $this->prc_tender_main->ptm($id);
				$data['ptm'] = $ptm[0];
				$data['ptp'] = $this->prc_tender_prep->ptm($id);

				$data['ptv'] = $this->prc_tender_vendor->ptm($id);
			// $this->prc_tender_item->join_pr();
			// $data['tit'] = $this->prc_tender_item->ptm($id);
				$this->load->library('process');
				$data['next_process'] = $this->process->get_next_process($id);
			// $data['next_process']['NAMA_BARU'] = 'Pilih Vendor';

				$data['detail_item_ptm'] = $this->snippet->detail_item_ptm($id);
				$data['ptm_comment'] = $this->snippet->ptm_comment($id);
				$data['rfq_type'] = $this->prc_doc_type_master->get();
				$data['buyer'] = '';

				$dokumen = array();
				$dokumens = array();
				$privacy = null;
				$active = true;

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
			// var_dump($dokumen['itemdoc']);
			// die();
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
							$dok[$count]['PDC_NAME'] = $val['PDC_NAME'];
							$dok[$count]['PDC_IS_PRIVATE'] = $val['PDC_IS_PRIVATE'];
							$dok[$count]['PPD_DESCRIPTION'] = $val['PPD_DESCRIPTION'];
							$dok[$count]['item'][0]['DECMAT'] = $dokumens[$ppi_id]['PPI_DECMAT'];
							$dok[$count]['item'][0]['NOMAT'] =  $dokumens[$ppi_id]['PPI_NOMAT'];
							$count = $count + 1;
						}
					// var_dump($val);
					}
				}
				$data['dokumen'] = $dok;

				$this->layout->set_table_js();
				$this->layout->set_table_cs();
				$this->layout->set_datetimepicker();
				$this->layout->add_js('pages/mydatetimepicker.js');
				$this->layout->add_js('pages/procurement_pengadaan.js');
				$this->layout->add_css('plugins/select2/select2.css');
				$this->layout->add_css('plugins/select2/select2-bootstrap.css');
				$this->layout->add_js('plugins/select2/select2.js');
				$this->layout->add_js('plugins/numeral/numeral.js');
				$this->layout->add_js('plugins/numeral/languages/id.js');
			// var_dump($data);
			// die();
				$this->layout->render('approval_procurement_pratender', $data);
			} else {
				$this->do_attempt($id);
			}
		}

		public function do_attempt($id) {
			$ptm_number = $id;

			/* UPDATE PTP */
			$submit = $this->input->post('harus_pilih');
			if ($submit == "accept") {
				$this->load->model('prc_tender_prep');
				$this->load->model('prc_tender_approve');
				$this->load->model('prc_tender_vendor');
				$this->load->model('prc_tender_approve_vendor');
				$this->load->model('prc_tender_main');

				$ptp['PTM_NUMBER'] = $ptm_number;
				$ptp['PTP_WARNING'] = $this->input->post('ptp_warning');
				$ptp['PTP_BATAS_PENAWARAN'] = $this->input->post('ptp_batas_penawaran_atas') == '' ? 0 : intval($this->input->post('ptp_batas_penawaran_atas'));
				$ptp['PTP_BAWAH_PENAWARAN'] = $this->input->post('ptp_batas_penawaran_bawah') == '' ? 100 : intval($this->input->post('ptp_batas_penawaran_bawah'));

			// var_dump($ptp); exit();
				$this->prc_tender_prep->updateByPtm($id, $ptp);
			//*/

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

				/* update dan simpan vendor */
				$data['PTM_NUMBER'] = $id;
				$this->prc_tender_vendor->delete($data);
				$tapv['TAP_ID'] = $tap_id;
				$tapv['TAPV_ID'] = $this->prc_tender_approve_vendor->get_id();
				foreach ($this->input->post('vendor') as $key) {
					$data['PTV_ID'] = $this->prc_tender_vendor->get_id();
					$data['PTV_VENDOR_CODE'] = $key;
					$this->prc_tender_vendor->insert_array($data);

					$tapv['PTV_VENDOR_CODE'] = $key;
					$this->prc_tender_approve_vendor->insert($tapv);
					$tapv['TAPV_ID']++;
				}
			//*/
			// insert and upload comment attachment
				$comment_id = $this->comment->get_new_id();
				$dataComment = array(
					"PTC_ID" => $comment_id,
					"PTM_NUMBER" => $ptm_number,
					"PTC_COMMENT" => '\''.$this->input->post('comment').'\'',
					"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
					"PTC_NAME" => '\''.$this->authorization->getCurrentName().'\'',
					"PTC_ACTIVITY" => '\''."Approval Perencanaan".'\''
					);
				$this->comment->insert_comment_tender($dataComment);
				
				/* save subpratender if in dev */
				$subpratender = $this->save_subpratender($ptm_number);
				if (empty($subpratender)) {
				// do nothing
				} else {
					if ($subpratender[0]['MESSAGE'] == '') {
					// var_dump($subpratender); exit();
						$this->session->set_flashdata('gagal_subpratender', $subpratender[0]);
						redirect('Procurement_pratender/attempt/' . $ptm_number);
					}
					$new_update['PTM_SUBPRATENDER'] = $subpratender[0]['MESSAGE'];
					$this->prc_tender_main->updateByPtm($ptm_number, $new_update);
					$this->session->set_flashdata('tambahaninfo', ' Nomor Subpratender: '.$subpratender[0]['MESSAGE'].'.');
				}

				$this->load->library('process');
				$this->process->next_process($ptm_number, 'NEXT');

				$this->session->set_flashdata('success', 'success'); redirect('Job_list');
			} else {

				$this->load->model('prc_tender_item');
				$this->load->model('prc_pr_item');
				$this->load->model('prc_tender_main');
				$this->load->library('snippet');			

				//--LOG MAIN--//
				$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
					$this->authorization->getCurrentRole(),$this->input->post('process_name'),'REJECT',$this->input->ip_address()
					);
				$LM_ID = $this->log_data->last_id();
				//--END LOG MAIN--//

				$item = $this->prc_tender_item->ptm($id);
				foreach ($item as $key => $value) {
					$pr_item = $this->prc_pr_item->get(array('PPI_ID'=>$value['PPI_ID']));
					$this->prc_pr_item->update(array('PPI_QTY_USED' => $pr_item[0]['PPI_QTY_USED'] - $value['TIT_QUANTITY']), array('PPI_ID'=>$pr_item[0]['PPI_ID']));
					//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Procurement_pratender/do_attempt','prc_pr_item','update',array('PPI_QTY_USED' => $pr_item[0]['PPI_QTY_USED'] - $value['TIT_QUANTITY']),array('PPI_ID'=>$pr_item[0]['PPI_ID']));
					//--END LOG DETAIL--//
				}
				
				$data = $this->prc_tender_main->ptm($id);
				$this->prc_tender_main->updateByPtm($id, array('PTM_STATUS' => $data['0']['PTM_STATUS'] * - 1 ));
				//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_pratender/do_attempt','prc_tender_main','update',array('PTM_STATUS' => $data['0']['PTM_STATUS'] * - 1 ),array('PTM_NUMBER'=>$id));
				//--END LOG DETAIL--//

			// insert comment
				$comment_id = $this->comment->get_new_id();
				$dataComment = array(
					"PTC_ID" => $comment_id,
					"PTM_NUMBER" => $ptm_number,
					"PTC_COMMENT" => '\''.$this->input->post('comment').'\'',
					"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
					"PTC_NAME" => '\''.$this->authorization->getCurrentName().'\'',
					"PTC_ACTIVITY" => '\''."Approval Perencanaan".'\''
					);
				$this->comment->insert_comment_tender($dataComment);
				//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Procurement_pratender/do_attempt','prc_tender_comment','insert',$dataComment);
				//--END LOG DETAIL--//

				$this->session->set_flashdata('reject', 'reject'); redirect('Job_list');
			}
		}

		public function get_datatable() {
			$this->load->model('prc_pr_item');
			$this->prc_pr_item->join_pr();
			$this->prc_pr_item->where_verified();
			$this->prc_pr_item->where_not_closed();
			$this->prc_pr_item->where_available();
			$jenis =$this->input->post('jenis_perencanaan');
			if ($jenis == '1'){
				$this->prc_pr_item->where_jasa();
			}
			else
			{
				$this->prc_pr_item->where_barang();
			}
		//$this->prc_pr_item->		
			$this->prc_pr_item->where_pgrp_in($this->session->userdata('PRGRP'));
			$this->prc_pr_item->distinct();
		$data['data'] = (array) $this->prc_pr_item->get(null, '*', 0, true); // yang tampil STATU nya hanya N (15-12-2016)
		echo json_encode($data);
	}

	public function get_po() {
		// error_reporting(E_ALL);
		$this->load->model('prc_pr_item');

		$tits = $this->input->post('tits');
		// if (count($tits) != 1) {
		// 	echo 'gagal, harus pilih cuma 1!';
		// } else {
		$this->load->library('sap_handler');

		$nomat = array();
		$tit = array();
		$opco = '';
		foreach ($tits as $val) {
			$ppiid = $val;
			$ppid = explode(':', $ppiid);
			$ppiid = $ppid[0];

				// var_dump($ppiid);die();
			$this->prc_pr_item->where_id($ppiid);
			$this->prc_pr_item->join_pr();
			$this->prc_pr_item->join_plant();
			$ppi = $this->prc_pr_item->get();
				 // var_dump($ppi); exit();
			if(isset($ppi[0])){
				$ppi = $ppi[0];
				$tit[] = $ppi;

				$nomat[] = array(
					'nomat' => $ppi['PPI_NOMAT']
					);

				$opco = $ppi['COMPANY_ID'];
			}
		}

			// $plant = $ppi['PPR_PLANT'];

			// die(var_dump($nomat." - ".$opco));

		/* return is ['IT_DATA' => array(...)] */
		$retval = $this->sap_handler->getPOEproc($nomat, $opco); 

		foreach ($retval['IT_DATA'] as $key => $value) {
			if ($value['LIFNR'] == '') {

			} else {
				foreach ($value as $k => $val) {
					$hasil[$value['LIFNR']][$k] = $val;
				}
				if (isset($hasil[$value['LIFNR']]['count'])) {
					$hasil[$value['LIFNR']]['count']++;
				} else {
					$hasil[$value['LIFNR']]['count'] = 1;
				}
			}
		}
			// var_dump($tit);
			// echo "<pre>";
			// die(print_r($retval));

		$data['detail']=array();
		foreach ($retval['IT_DATA'] as $va) {
			$data['detail'][$va['MATNR']][$va['LIFNR']][]=$va;
		}

		foreach ($data['detail'] as $key => $vnd) {
			foreach ($vnd as $val) {
				foreach ($val as $v) {
					$cek[$v['LIFNR']][] = $v;
				}
			}
		}

		$data['it_data']=array();
		if(isset($hasil) && isset($tit[0])){
				// $data['it_data'] = $hasil;
			foreach ($hasil as $h) {
				if(count($cek[$h['LIFNR']]) == count($tit)){
					$data['it_data'][$h['LIFNR']] = $h;				
				}
			}
		}else{
			die('<td colspan="8">Gagal mendapatkan data dari SAP.</td>');
		}

			// var_dump($retval['IT_DATA']);
			// echo "<pre>";
			// die(print_r($retval['IT_DATA']));

		$data['tit'] = $tit;
		$data['asli'] = $retval;

		// echo "<pre>";
		// die(print_r($data['detail']));
		$ans = $this->load->view('Procurement_pratender/detail_po', $data, true);


		echo $ans;
		// }
	}

	public function get_po_from_ptm($id) {
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_vendor');

		$this->prc_tender_item->join_pr();
		$tits = $this->prc_tender_item->ptm($id);
		// if (count($tits) != 1) {
		// 	echo 'gagal, harus pilih cuma 1!';
		// } else {
		$this->load->library('sap_handler');

		foreach ($tits as $val) {
			$this->prc_pr_item->where_id($val['PPI_ID']);
			$this->prc_pr_item->join_pr();
			$this->prc_pr_item->join_plant();
			$ppi = $this->prc_pr_item->get();
				 // var_dump($ppi); exit();
			if(isset($ppi[0])){
				$ppi = $ppi[0];
				$tit[] = $ppi;

				$nomat[] = array(
					'nomat' => $ppi['PPI_NOMAT']
					);

				$opco = $ppi['COMPANY_ID'];
			}
		}

		/* return is ['IT_DATA' => array(...)] */
		$retval = $this->sap_handler->getPOEproc($nomat, $opco);

			// var_dump($retval); exit();
		foreach ($retval['IT_DATA'] as $key => $value) {
			if ($value['LIFNR'] == '') {

			} else {
				foreach ($value as $k => $val) {
					$hasil[$value['LIFNR']][$k] = $val;
				}
				if (isset($hasil[$value['LIFNR']]['count'])) {
					$hasil[$value['LIFNR']]['count']++;
				} else {
					$hasil[$value['LIFNR']]['count'] = 1;
				}
			}
		}

		$data['detail']=array();
		foreach ($retval['IT_DATA'] as $va) {
			$data['detail'][$va['MATNR']][$va['LIFNR']][]=$va;
		}

		foreach ($data['detail'] as $key => $vnd) {
			foreach ($vnd as $val) {
				foreach ($val as $v) {
					$cek[$v['LIFNR']][] = $v;
				}
			}
		}

		$data['it_data']=array();
		if(isset($hasil)){
				// $data['it_data'] = $hasil;
			foreach ($hasil as $h) {
				if(count($cek[$h['LIFNR']]) == count($tit)){
					$data['it_data'][$h['LIFNR']] = $h;				
				}
			}				
		}else{
			die('<td colspan="8">Gagal mendapatkan data dari SAP.</td>');
		}

		$vendor = (array) $this->prc_tender_vendor->get(array('PTM_NUMBER' => $id, 'PTV_NON_DIRVEN' => NULL));
		foreach ($vendor as $vnd) {
			$data['vendor'][$vnd['PTV_VENDOR_CODE']]=$vnd['PTV_VENDOR_CODE'];
		}

		$data['tit'] = $tit;
		$data['asli'] = $retval;

		$result['detail'] = $this->load->view('Procurement_pratender/approval_detail_po', $data, true);

		$result['vnd_terpilih'] = $this->load->view('Procurement_pratender/approval_vendor_terpilih', $data, true);

			 // die(var_dump($hahasil));

		echo json_encode($result);
		// }
	}

	public function get_vendor() {
		$tits = $this->input->post('tits');
		$just = $this->input->post('just');
		// var_dump($this->input->post()); exit();

		$data['post'] = $this->input->post();
		/* Pakai SAP */
		$this->load->library('sap_handler');
		$this->load->model('prc_pr_item');
		$this->load->model('vnd_header');
		$this->load->model('vnd_perf_hist');
		$this->load->model('vnd_perf_sanction');
		$this->load->model('vnd_perf_mst_category');

		$this->load->model('vendor_detail');


		// $this->load->model('v_vnd_perf_total');

		$matkl = array();
		$pritn = array();
		$pr = array();
		$porg = '';
		
		foreach ($tits as $ppiid) {
			$ppid = explode(':', $ppiid);
			$ppiid = $ppid[0];

			$this->prc_pr_item->where_id($ppiid);
			$this->prc_pr_item->join_pr();
			$ppi = $this->prc_pr_item->get();
			$ppi = $ppi[0];
			// var_dump($ppi); exit();
			$matkl[] = $ppi['PPI_MATGROUP'];
			$pritn[] = $ppi['PPI_PRITEM'];
			$pr[] = $ppi['PPI_PRNO'];
			$porg = $ppi['PPR_PORG'];
			if ($porg == '') {
				$porg = pgrp_to_porg($ppi['PPR_PGRP']);
			}
		}
		
		$data['pr'] = $pr;
		$data['pritn'] = $pritn;
		$data['matkl'] = $matkl;
		$data['porg'] = $porg;
		$data['vendor'] = $this->sap_handler->getVendor($pr, $pritn, $matkl, $porg);
		// kalau data vendornya ga ada, dikasih pesan aja aatau gimana gitu

		$ngelist_vendor = array();

		foreach ($data['vendor'] as $key => $val) {
			// if ($just == 6) {
			// 	if ($val['JP'] == 'A' || $val['JP'] == 'M') {
			// 		$ngelist_vendor[] = $val['LIFNR'];
			// 	} else {
			// 		$data['terbuang'][] = $val;
			// 	}
			// } else {
			$ngelist_vendor[] = $val['LIFNR'];
			// }
		}

		$ngelist_vendor = array_unique($ngelist_vendor);
		$vendor_unique = $this->vnd_header->where('VENDOR_NO', $ngelist_vendor)->get_all();

		foreach ((array) $vendor_unique as $key => $val) {
			$tanggal = date(timeformat());
			$cek = $this->vnd_perf_sanction->cek_sanksi_vendor($val['VENDOR_NO'],$tanggal);
			if ($cek == false) {
				$performa = $this->vnd_perf_hist->get_vendor_last_point($val['VENDOR_NO']);					
				if (count($performa) <= 0) {
					$nilai = '';
					$category = '';
				} else {
					$nilai = $performa[0]['POIN_CURR'];
					$category_que = $this->vnd_perf_mst_category->getvendor($nilai);
					$category = $category_que[0]['CATEGORY_NAME'];

				}

				$val['CATEGORY'] = $category;
				$val['PERFORMA'] = $nilai;
				$vendor_by_id[$val['VENDOR_NO']] = $val;
			} else {
				$cek = '';
			}
		}


		foreach ($data['vendor'] as $key => $val) {
			if (isset($vendor_by_id[$val['LIFNR']])) {
				$data['vendor'][$key]['header'] = $vendor_by_id[$val['LIFNR']];
				$vendor_unique = $this->vnd_header->where('VENDOR_NO', $val['LIFNR'])->get_all();
				$barang = "";

				// $ambilBarang = $this->vendor_detail->produk($vendor_unique[0]['VENDOR_ID']);
				// $i=0;
				// if(count($ambilBarang)>0){
				// 	foreach ($ambilBarang as $ab) {
				// 		$i++;
				// 		if($i==count($ambilBarang)){
				// 			$barang.= $i.". ".$ab['PRODUCT_NAME'];
				// 		} else {
				// 			$barang.= $i.". ".$ab['PRODUCT_NAME']."<br>";
				// 		}
				// 	}
				// } else {
				// 	$barang = "-";
				// }
				$data['vendor'][$key]['header']['barang'] = $barang;
			}
		}

		//*/

		/* dari VND_HEADER *
		$this->load->model('vnd_header');
		$data['vendor'] = $this->vnd_header->get(array('COMPANYID' => '4000', 'STATUS' => 1));
		//*/

		echo json_encode($data);
	}

	public function save_subpratender($id) {
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_purchase_requisition');
		$this->load->library('sap_handler');

		$ptm = $this->prc_tender_main->ptm($id);
		$ptm = $ptm[0];
		$ptp = $this->prc_tender_prep->ptm($id);
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
		// var_dump(compact('matkl'));
		// var_dump(compact('desc'));
		// var_dump(compact('just'));
		// var_dump(compact('pritem'));
		// var_dump(compact('tab'));
		// var_dump(compact('ekorg'));
		// var_dump(compact('ekgrp'));
		// exit();
		return $this->sap_handler->save_subpratender($matkl, $desc, $just, $pritem, $tab, $ekorg, $ekgrp);
	}

	function pilih_child(){
		$id = $this->input->post('id');
		$this->load->model('com_jasa_group');

		$data=$this->com_jasa_group->get_child($id);

		echo form_dropdown("data",$data,'','');
	}

	function pilih_sub_klasifikasi() {
		$id = $this->input->post('id');
		$this->load->model('com_jasa_group');

		$data=$this->com_jasa_group->get_sub_klasifikasi($id);

		echo json_encode($data);
	}

	public function get_vendor_jasa(){
		$this->load->model('vnd_product');
		$this->load->model('vnd_header');
		$this->load->model('vnd_perf_hist');
		$this->load->model('vnd_perf_mst_category');
		$this->load->model('vnd_perf_sanction');
		$this->load->model('vendor_detail');

		if($this->input->post('subKlasifikasi_jasa_id') != false){
			$subKlasiId = $this->input->post('subKlasifikasi_jasa_id');
			$va = json_encode($subKlasiId);
			$a=explode('[', $va);
			$e=explode(']', $a[1]);
			$p=str_replace('"', '\'', $e[0]);
			$subKlaId=$p;
			$id=$p=str_replace('"', '', $e[0]);
			$field = "SUBKLASIFIKASI_ID";

			$q = "	SELECT PRODUCT_ID,VENDOR_ID,PRODUCT_NAME,KLASIFIKASI_NAME,KUALIFIKASI_NAME,SUBKUALIFIKASI_NAME,SUBKLASIFIKASI_ID FROM(
			SELECT PRODUCT_ID,VENDOR_ID,PRODUCT_NAME,KLASIFIKASI_NAME,KUALIFIKASI_NAME,SUBKUALIFIKASI_NAME,
			trim(regexp_substr(SUBKLASIFIKASI_ID, '[^,]+', 1, lines.COLUMN_VALUE)) SUBKLASIFIKASI_ID,
			lines.column_value
			FROM VND_PRODUCT
			CROSS JOIN
			(SELECT *
			FROM TABLE (CAST (MULTISET
			(SELECT LEVEL
			FROM dual
			CONNECT BY LEVEL <= (SELECT COUNT(REPLACE(SUBKLASIFIKASI_ID, ','))  FROM VND_PRODUCT )
			) AS sys.odciNumberList ) )
			) lines
			)
			WHERE SUBKLASIFIKASI_ID IN ($subKlaId) 
			ORDER BY PRODUCT_ID ";
			$data = $this->db->query($q)->result_array();

		}else{
			if($this->input->post('klasifikasi_jasa_id') != 0){
				$id = $this->input->post('klasifikasi_jasa_id');
				$field = "KLASIFIKASI_ID";

			}else if($this->input->post('subGroup_jasa_id') != 0){
				$id = $this->input->post('subGroup_jasa_id');
				$field = "PRODUCT_SUBGROUP_CODE";

			}else if($this->input->post('group_jasa_id') != 0){
				$id = $this->input->post('group_jasa_id');
				$field = "PRODUCT_CODE";
			}

			$data = $this->vnd_product->order_by('PRODUCT_ID')->get_all(array($field => $id, "PRODUCT_TYPE" => "SERVICES"));
		}

		$id_product=''; $arr_data=array();
		if(is_array($data)){

			foreach ($data as $key => $val) {

				$tanggal = date(timeformat());
				$veno_array = $this->vnd_header->get(array('VENDOR_ID'=>$val['VENDOR_ID']));
				if (is_numeric($veno_array['VENDOR_NO'])) {
					$cek = $this->vnd_perf_sanction->cek_sanksi_vendor($veno_array['VENDOR_NO'],$tanggal);

					/* CEK OPCO */ 
					$opco = $this->session->userdata['EM_COMPANY'];
					$cek_opco = $this->vendor_detail->get_vendor_jasa($veno_array['VENDOR_NO'],$opco);
					if (!empty($cek_opco)) {
						foreach ($cek_opco as $key => $vnd) {
							if ($cek == false) {
								if($id_product != $val['PRODUCT_ID']){
									// $vnd = $this->vnd_header->get(array('VENDOR_ID'=>$val['VENDOR_ID']));
									$performa = $this->vnd_perf_hist->get_vendor_last_point($vnd['VENDOR_NO']);					
									if (count($performa) <= 0) {
										$nilai = '';
										$category = '';
									} else {
										$nilai = $performa[0]['POIN_CURR'];
										$category_que = $this->vnd_perf_mst_category->getvendor($nilai);
										$category = $category_que[0]['CATEGORY_NAME'];

									}

									$jasa = "";
									
									// $ambilJasa = $this->vendor_detail->produk_jasa($vnd['VENDOR_ID']);
									// $i=0;
									// if(count($ambilJasa)>0){
									// 	foreach ($ambilJasa as $aj) {
									// 		$i++;
									// 		if($i==count($ambilBarang)){
									// 			$jasa.= $i.". ".$aj['PRODUCT_NAME'];
									// 		} else {
									// 			$jasa.= $i.". ".$aj['PRODUCT_NAME']."<br>";
									// 		}
									// 	}
									// } else {
									// 	$jasa = "-";
									// }

									$arr_data[] = array(
										'PTP_FILTER_VND_PRODUCT'=>$id ,
										'PTP_FILTER_NAME'=>$field ,
										'PRODUCT_ID'=>$val['PRODUCT_ID'] ,
										'VENDOR_NO'=>$vnd['VENDOR_NO'] ,
										'VENDOR_NAME'=>$vnd['VENDOR_NAME'] ,
										'PRODUCT_NAME'=>$val['PRODUCT_NAME'] ,
										'KLASIFIKASI_NAME'=>$val['KLASIFIKASI_NAME'] ,
										'KUALIFIKASI_NAME'=>$val['KUALIFIKASI_NAME'] ,
										'SUBKUALIFIKASI_NAME'=>$val['SUBKUALIFIKASI_NAME'],
										'CATEGORY'=>$category ,
										'PERFORMA'=>$nilai ,
										'JASA'=>$jasa 
										);	
								}
								$id_product=$val['PRODUCT_ID'];
								
							} else {
								$cek = '';
							}
						}
					}
				}
			}
		}

		$data = array('data' => $arr_data);
		echo json_encode($data);		
	}

	function uploadAttachment() {
		$this->load->library('encrypt');
		$server_dir = str_replace("\\", "/", FCPATH);
		$upload_dir = UPLOAD_PATH."additional_file/";
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

	public function deleteFile(){
		$fileUpload = $this->input->post('filename');
		
		$this->load->helper("url");

		$path = './upload/additional_file/'.$fileUpload;
		if(file_exists(BASEPATH.'../upload/additional_file/'.$fileUpload)){
			unlink($path);
		}
	}

	public function search_dokumenPR(){
		$ppi_id = $this->input->post('ppi_id');
		$this->load->model('prc_plan_doc');

		$this->prc_plan_doc->join_pr_item();
		$this->prc_plan_doc->pritemDoc();
		$data['dokumen'] = $this->prc_plan_doc->pritem($ppi_id);

		echo $this->load->view('Procurement_pratender/dokumen_pr', $data, true);
	}

	function vendor_expired() {
		$date_now = date('d-m-Y');
		$no_vendor = $this->input->post('no_vendor');
		$this->load->model('vnd_header');
		$vnd_header = $this->vnd_header->get(array('VENDOR_NO'=>$no_vendor));
		$vnd_siup = day_difference(oraclestrtotime($vnd_header['SIUP_TO']),strtotime($date_now), false);
		$vnd_addrs = day_difference(oraclestrtotime($vnd_header['ADDRESS_DOMISILI_EXP_DATE']),strtotime($date_now), false);
		$vnd_tdp = day_difference(oraclestrtotime($vnd_header['TDP_TO']),strtotime($date_now), false);

		if (!empty($vnd_header['SIUP_TO']) || !empty($vnd_header['ADDRESS_DOMISILI_EXP_DATE']) || !empty($vnd_header['TDP_TO'])) {
			if (($vnd_siup <= 60) || ($vnd_addrs <= 60) || ($vnd_tdp <= 60)) {
				$data = array('stt'=>'warning', 'siup'=>$vnd_siup, 'domisili'=>$vnd_addrs, 'tdp'=>$vnd_tdp);
			}else{
				$data = array('stt'=>'sukses');
			}

		}else{
			$data = array('stt'=>'sukses');
		}

		echo json_encode($data);
	}

	public function kirim_email_reject($user){	
		$this->load->library('email');
		$this->config->load('email'); 
		$company_name = $this->session->userdata['COMPANYNAME'];
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->to($user['EMAIL']);				
		$this->email->cc('pengadaan.semenindonesia@gmail.com');					
		$this->email->subject("Reject Konfigurasi eProcurement ".$company_name.".");
		$content = $this->load->view('email/reject_konfigurasi',$user['data'],TRUE);
		$this->email->message($content);
		$this->email->send();
	}

}

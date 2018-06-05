<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->load->library("file_operation");
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
		$this->load->library('comment');
	}

	public function getlongtext() {
		$PPI_ID = $this->input->post('PPI_ID');
		$data['matnr'] = $this->input->post('PPI_NOMAT');
		$data['banfn'] = substr($PPI_ID, 0, 10);
		$data['bnfpo'] = sprintf("%05d", substr($PPI_ID, 10));

		$this->load->library('sap_handler');
		$data['return'] = $this->sap_handler->getlongtext(array($data));
		foreach ($data['return'] as $var) {
			$data['isi'][$var['TYPE']][] = $var['TDLINE'];
		}

		echo $this->load->view('detail_material', $data, true);
	}

	public function index() {
		$data['title'] = "Quotation List";
		$data['success'] = $this->session->flashdata('success') == 'success';
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/quotation.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->render('quotation_list',$data);
	}

	public function view_submittedQuotation() {
		$data['title'] = "Quotation List";
		$data['success'] = $this->session->flashdata('success') == 'success';
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/quotation.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->add_js("strTodatetime.js");
		$this->layout->render('quotation_list_submitted',$data);
	}

	public function get_quotation_list($from=null) {
		$this->load->model('prc_tender_vendor');

		/* Normal quotation */
		$this->prc_tender_vendor->join_vnd_header();
		$this->prc_tender_vendor->join_prc_tender_main();
		$this->prc_tender_vendor->join_prc_tender_prep();
		$this->prc_tender_vendor->join_app_proses();
		$quotations = $this->prc_tender_vendor->get(array(
				'PTV_VENDOR_CODE' => $this->session->userdata('VENDOR_NO'), 
				'PTV_STATUS >=' => 1,
				'IS_VENDOR_CLOSED' => 0,
			));

		$count = 0;
		$quote = array();
		/*var_dump($this->session->userdata('VENDOR_NO'));
		die();*/
		foreach ((array) $quotations as $key => $val) {
			$opening = $val['PTP_REG_OPENING_DATE'];
			$closing = $val['PTP_REG_CLOSING_DATE'];
			$now = strtotime('now');
			if(!empty($from) && $from=='submitted'){
				if(oraclestrtotime($closing) < $now && $now > oraclestrtotime($opening)) {
					$quote[$count] = $val;
					$quote[$count]['PTM_NUMBER'] = url_encode($val['PTM_NUMBER']);
					$quote[$count]['PTP_REG_OPENING_DATE'] = betteroracledate(oraclestrtotime($val['PTP_REG_OPENING_DATE']));
					$quote[$count]['PTP_REG_CLOSING_DATE'] = betteroracledate(oraclestrtotime($val['PTP_REG_CLOSING_DATE']));
					$count++;
				}

			}else{
				if(oraclestrtotime($closing) > $now && $now > oraclestrtotime($opening)) {
					$quote[$count] = $val;
					$quote[$count]['PTM_NUMBER'] = url_encode($val['PTM_NUMBER']);
					$quote[$count]['PTP_REG_OPENING_DATE'] = betteroracledate(oraclestrtotime($val['PTP_REG_OPENING_DATE']));
					$quote[$count]['PTP_REG_CLOSING_DATE'] = betteroracledate(oraclestrtotime($val['PTP_REG_CLOSING_DATE']));
					$count++;
				}				
			}
		}
		//*/

		/* Quotation input harga */
		$this->prc_tender_vendor->join_vnd_header();
		$this->prc_tender_vendor->join_prc_tender_main();
		$this->prc_tender_vendor->join_prc_tender_prep();
		$this->prc_tender_vendor->join_app_proses();
		$this->prc_tender_vendor->where_in('PTV_STATUS_EVAL', array(1, 2));
		$quotations = (array) $this->prc_tender_vendor->get(array(
			'PTV_VENDOR_CODE' => $this->session->userdata('VENDOR_NO'),
			'IS_VENDOR_CLOSED' => 2
		));
		foreach ($quotations as $key => $val) {
			if(!empty($from) && $from=='submitted'){
				if (oraclestrtotime($val['BATAS_VENDOR_HARGA']) < strtotime('now')) {
					$quotations[$key]['PTM_NUMBER'] = url_encode($val['PTM_NUMBER']);
					$quotations[$key]['PTP_REG_OPENING_DATE'] = betteroracledate(oraclestrtotime($val['PTP_REG_OPENING_DATE']));
					$quotations[$key]['PTP_REG_CLOSING_DATE'] = betteroracledate(oraclestrtotime($val['BATAS_VENDOR_HARGA']));
				} else {
					unset($quotations[$key]);
				}

			}else{
				if (oraclestrtotime($val['BATAS_VENDOR_HARGA']) > strtotime('now')) {
					$quotations[$key]['PTM_NUMBER'] = url_encode($val['PTM_NUMBER']);
					$quotations[$key]['PTP_REG_OPENING_DATE'] = betteroracledate(oraclestrtotime($val['PTP_REG_OPENING_DATE']));
					$quotations[$key]['PTP_REG_CLOSING_DATE'] = betteroracledate(oraclestrtotime($val['BATAS_VENDOR_HARGA']));
				} else {
					unset($quotations[$key]);
				}				
			}
		}
		$ans = array_merge($quote, $quotations);

		//*/
		echo json_encode(array('data' => $ans));
	}

	public function get_vendor($id) {
		echo json_encode(array()); die();
		$this->load->model('prc_tender_vendor');
		$this->prc_tender_vendor->join_pqm();
		$where = array('PRC_TENDER_VENDOR.PTM_NUMBER' => $id);
		$select = 'PRC_TENDER_VENDOR.*, VND_HEADER.VENDOR_NAME, PRC_TENDER_QUO_MAIN.PQM_ID';
		$result = $this->prc_tender_vendor->get_join($where, $select);
		echo json_encode($result);
	}

	public function inputQuotation($id, $viewSubmitted=null) {
		$id = url_decode($id);
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_evaluation_template');
		$this->load->model('prc_evaluasi_teknis');
		$this->load->model('prc_evaluasi_uraian');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_pr_item');
		$this->load->model('prc_eval_file');
		$this->load->model('vnd_header');
		$this->load->library('snippet');

		$this->load->model('prc_tender_nego_sech');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_nego');
		$this->load->model('prc_nego_detail');
		$this->load->model('prc_tender_nego_vendor_doc');
		$this->load->model('po_header');
		$this->load->model('po_detail');

		//////////////////////////////////////////////////////////////////////
		$vendorno = $this->session->userdata('VENDOR_NO');
		$data['vendorno']=$vendorno;
		$pqm = $this->prc_tender_quo_main->ptmptv($id, $vendorno);
		if (empty($pqm)) {
			$data['pqm_id'] = null;
		} else {
			$data['pqm'] = $pqm[0];
			$data['pqm_id'] = $data['pqm']['PQM_ID'];
			$pqi = $this->prc_tender_quo_item->get_by_pqm($data['pqm_id']);
			foreach ($pqi as $val) {
				$data['pqi'][$val['TIT_ID']] = $val;
			}
			$ef = $this->prc_eval_file->where_ptm_ptv($id, $vendorno);
			$ef = $this->prc_eval_file->get();
			$data['ef'] = array();
			foreach ((array)$ef as $val) {
				$data['ef'][$val['TIT_ID']][$val['ET_ID']] = $val;
			}
		}
		// var_dump($data); exit();
		//////////////////////////////////////////////////////////////////////

		$data['title'] = 'Input Quotation';
		$data['ptm_number'] = $id;
		$data['ptm_detail'] = $this->prc_tender_main->ptm($id);
		$data['ptm_detail'] = $data['ptm_detail'][0];
		$data['ptp'] = $this->prc_tender_prep->ptm($id);
		$data['ptv'] = $this->prc_tender_vendor->ptm_ptv($id, $vendorno);
		// var_dump($data['ptv']);
		$data['is_itemize'] = $data['ptp']['PTP_IS_ITEMIZE'];
		$data['evaluasi'] =$this->prc_evaluation_template->get_join(array('EVT_ID' => $data['ptp']['EVT_ID']));
		// if ($data['ptm_detail']['IS_JASA'] == 1) {
		// 	$data['tits'] = $this->prc_tender_item->ptm($id, true);
		// } else {
			$data['tits'] = $this->prc_tender_item->get(array('PTM_NUMBER'=>$id,'TIT_STATUS <>'=>999));
		// }
		// knp ko ga dikasih wher ptm? coba ah ntar
		$eu = $this->prc_evaluasi_uraian->get();
		foreach ($eu as $val) {
			$data['eu'][$val['TIT_ID']][$val['ET_ID']][] = $val;
		}

		$this->prc_evaluasi_teknis->where_ptm($id);
		// $data['ppd'] = $this->prc_evaluasi_teknis->get();
		$pef = $this->prc_eval_file->get(array('PTM_NUMBER' => $id, 'PTV_VENDOR_CODE' => $vendorno));
		foreach ($pef as $p) {
			$data['pef'][$p['TIT_ID']]=$p['EF_FILE'];
		}

		$data['dokumen_pr'] = $this->snippet->dokumen_pr($id, 0, true, true);
		$data['detail_ptm'] = $this->snippet->detail_ptm($id, false, true, true, $data['ptv'][0]['PTV_RFQ_NO']);
		$data['history_chat'] = $this->snippet->view_history_chat($id, $vendorno);
		$data['viewSubmitted']=$viewSubmitted;

		$data['vendor'] = $this->vnd_header->get(array('VENDOR_NO' => $vendorno));

		// NEGO
		$data['negos'] = $this->prc_tender_nego_sech->ptm_ptv($id, $vendorno);
		$data['detail_nego'] = $this->prc_tender_nego->ptm($id);
		$nego_id = $data['detail_nego']['NEGO_ID'];
		$prc_nego_detail = $this->prc_nego_detail->get(array('NEGO_ID'=>$nego_id,'VENDOR_NO'=>$vendorno));
			foreach ($prc_nego_detail  as $nego_detail) {
				$data['harga_nego'][$nego_detail['TIT_ID']]=$nego_detail['HARGA'];
			}

		if (count($prc_nego_detail) == 0) {
			$data['harga_nego'] = '';
		}
		$ptnv = $this->prc_tender_nego_vendor_doc->nego_ptm_vendor($nego_id,$id,$vendorno);		
		if(!empty($ptnv)){
			$data['ptnv_id'] = $ptnv[0]['PTNV_ID'];
			$data['FILE_UPLOAD'] = $ptnv[0]['FILE_UPLOAD'];			
			$server_dir = str_replace("\\", "/", FCPATH);	
			$upload_dir = UPLOAD_PATH."nego_file".DIRECTORY_SEPARATOR;	
		
			if(!file_exists($server_dir.$upload_dir.$data['FILE_UPLOAD'])){			
				$data['FILE_UPLOAD']="";
			}
		}

		$items_nego = $this->prc_tender_quo_item->ptm_ptv($id, $vendorno);
		$data['invitation_tender_items'] = $items_nego;
		// END NEGO

		// PO
		$this->po_header->join_po_detail();
		$this->po_header->join_ptm($id);
		$from_poh = $this->po_header->get();
		if (count($from_poh) != 0) {
			$data['po_header'] = $from_poh[0];
			$po_id = $from_poh[0]['PO_ID'];
		}else{
			$po_id = '';
			$data['po_header'] = '';
		}

		$this->po_detail->where_po($po_id);
		$this->po_detail->join_adm_plant();
		$po_detail = $this->po_detail->get(false);
		$data['item'] = $po_detail;

		// var_dump($data['item']); die();
		// END PO
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/input_quotation.js');
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js('pages/mydatepicker.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();            
		$this->layout->render('input_quotation',$data);
	}

	public function harga($id, $ptv_id=null, $viewSubmitted=null) {
		$id = url_decode($id);

		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_evaluation_template');
		$this->load->model('prc_evaluasi_teknis');
		$this->load->model('prc_evaluasi_uraian');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_eval_file');
		$this->load->library('snippet');

		$this->load->model('prc_tender_nego_sech');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_nego');
		$this->load->model('prc_nego_detail');
		$this->load->model('prc_tender_nego_vendor_doc');
		$this->load->model('po_header');
		$this->load->model('po_detail');

		//////////////////////////////////////////////////////////////////////
		$vendorno = $this->session->userdata('VENDOR_NO');
		$data['vendorno']=$vendorno;
		$pqm = $this->prc_tender_quo_main->ptmptv($id, $vendorno);
		if (empty($pqm)) {
			$data['pqm_id'] = null;
		} else {
			$data['pqm'] = $pqm[0];
			$data['pqm_id'] = $data['pqm']['PQM_ID'];
			$pqi = $this->prc_tender_quo_item->get_by_pqm($data['pqm_id']);
			foreach ($pqi as $val) {
				$data['pqi'][$val['TIT_ID']] = $val;
			}
			$ef = $this->prc_eval_file->where_ptm_ptv($id, $vendorno);
			$ef = $this->prc_eval_file->get();
			$data['ef'] = array();
			foreach ((array)$ef as $val) {
				$data['ef'][$val['TIT_ID']][$val['ET_ID']] = $val;
			}
		}
		// var_dump($data); exit();
		//////////////////////////////////////////////////////////////////////

		$data['title'] = 'Input Quotation';
		$data['ptm_number'] = $id;
		$data['vendor_data'] = $this->prc_tender_vendor->get(array('PTV_ID' => $ptv_id), '*');
		$data['ptm_detail'] = $this->prc_tender_main->ptm($id);
		$data['ptm_detail'] = $data['ptm_detail'][0];
		$data['ptp'] = $this->prc_tender_prep->ptm($id);
		$data['is_itemize'] = $data['ptp']['PTP_IS_ITEMIZE'];
		$data['evaluasi'] =$this->prc_evaluation_template->get_join(array('EVT_ID' => $data['ptp']['EVT_ID']));
		$data['tits'] = $this->prc_tender_item->ptm($id);
		// knp ko ga dikasih wher ptm? coba ah ntar
		$eu = $this->prc_evaluasi_uraian->get();
		foreach ($eu as $val) {
			$data['eu'][$val['TIT_ID']][$val['ET_ID']][] = $val;
		}

		$this->prc_evaluasi_teknis->where_ptm($id);
		$data['ppd'] = $this->prc_evaluasi_teknis->get();

		$data['dokumen_pr'] = $this->snippet->dokumen_pr($id, 0, true, true);
		$data['detail_ptm'] = $this->snippet->detail_ptm($id, false, true);
		$data['history_chat'] = $this->snippet->view_history_chat($id, $vendorno);
		$data['viewSubmitted']=$viewSubmitted;

		// NEGO
		$data['negos'] = $this->prc_tender_nego_sech->ptm_ptv($id, $vendorno);
		$data['detail_nego'] = $this->prc_tender_nego->ptm($id);
		$nego_id = $data['detail_nego']['NEGO_ID'];
		$prc_nego_detail = $this->prc_nego_detail->get(array('NEGO_ID'=>$nego_id,'VENDOR_NO'=>$vendorno));
			foreach ($prc_nego_detail  as $nego_detail) {
				$data['harga_nego'][$nego_detail['TIT_ID']]=$nego_detail['HARGA'];
			}

		if (count($prc_nego_detail) == 0) {
			$data['harga_nego'] = '';
		}
		$ptnv = $this->prc_tender_nego_vendor_doc->nego_ptm_vendor($nego_id,$id,$vendorno);		
		if(!empty($ptnv)){
			$data['ptnv_id'] = $ptnv[0]['PTNV_ID'];
			$data['FILE_UPLOAD'] = $ptnv[0]['FILE_UPLOAD'];			
			$server_dir = str_replace("\\", "/", FCPATH);	
			$upload_dir = UPLOAD_PATH."nego_file".DIRECTORY_SEPARATOR;	
		
			if(!file_exists($server_dir.$upload_dir.$data['FILE_UPLOAD'])){			
				$data['FILE_UPLOAD']="";
			}
		}

		$items_nego = $this->prc_tender_quo_item->ptm_ptv($id, $vendorno);
		$data['invitation_tender_items'] = $items_nego;
		// END NEGO

		// PO
		$this->po_header->join_po_detail();
		$this->po_header->join_ptm($id);
		$from_poh = $this->po_header->get();
		if (count($from_poh) != 0) {
			$data['po_header'] = $from_poh[0];
			$po_id = $from_poh[0]['PO_ID'];
		}else{
			$po_id = '';
			$data['po_header'] = '';
		}

		$this->po_detail->where_po($po_id);
		$this->po_detail->join_adm_plant();
		$po_detail = $this->po_detail->get(false);
		$data['item'] = $po_detail;
		// END PO

		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/input_quotation.js');
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js('pages/mydatepicker.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();            
		$this->layout->render('input_harga', $data);
	}

	public function save_bidding() {
		$tgl_batasPenawaran = $this->input->post('tgl_batasPenawaran');	
		$dateNew = date('Y-m-d H:i:s');		 
		if (strtotime($tgl_batasPenawaran) < strtotime($dateNew)) {
			$this->session->set_flashdata('error', ' Melebihi Tgl Batas Quotation Deadline.');
			redirect('Quotation');
		}

		$this->load->model('prc_eval_file');
		$this->load->model('prc_preq_eval');
		$this->load->model('prc_preq_quo_tech');
		$this->load->model('prc_tender_quo_file');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_vendor');

		$this->form_validation->set_rules('ptm_number', 'ptm_number', 'required');
		// $this->form_validation->set_rules('pqm_local_content', 'Kandungan Lokal', 'required|numeric');
		$this->form_validation->set_rules('pqm_delivery_time', 'Waktu Pengiriman', 'required|numeric');
		$this->form_validation->set_rules('pqm_delivery_unit', 'Waktu Pengiriman', 'required');
		$this->form_validation->set_rules('pqm_valid_thru', 'Berlaku Hingga', 'required');

		if ($this->form_validation->run() == FALSE) {
			$error = $this->form_validation->error_string();
			$error = str_replace("<p>", "", $error);
			$error = str_replace("</p>", "", $error);
			// echo $error;
			redirect('Quotation/inputQuotation/'.$this->input->post('ptm_number'));
			return;
		} else {
			$id = $this->input->post('ptm_number');
			$id = url_decode($id);

			$vendorno = $this->session->userdata('VENDOR_NO');
			
			/* Buang yang itemnya ga dicek */
			// foreach ($this->input->post('ptqi') as $tit_id => $val) {
			// 	if (!in_array($tit_id, (array)$this->input->post('check'))) {
			// 		// $evalitem = $this->input->post('evalitem');
			// 		// foreach ($evalitem[$tit_id] as $ppd) {
			// 		// 	unset($_FILES[$tit_id . '|' . $ppd]);
			// 		// }
			// 		unset($_POST['ptqi'][$tit_id]);

			// 		unset($where);
			// 		$where['PTM_NUMBER'] = $id;
			// 		$where['PTV_VENDOR_CODE'] = $vendorno;
			// 		$where['TIT_ID'] = $tit_id;
			// 		$this->prc_eval_file->delete($where);
			// 	}
			// }

			$uploaded = $this->file_operation->upload(UPLOAD_PATH.'quo_file', $_FILES);
			
			// var_dump($this->input->post()); var_dump($uploaded); exit();

			$pqm = $this->prc_tender_quo_main->ptmptv($id, $vendorno);
			if (empty($pqm)) {
				$pqm_id = null;
				$newid = $this->prc_tender_quo_main->get_id();
			} else {
				$pqm_id = $pqm[0]['PQM_ID'];
				$newid = $pqm_id;
			}

				//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
					'VENDOR','Input Penawaran','SIMPAN PENAWARAN',$this->input->ip_address()
				);
			$LM_ID = $this->log_data->last_id();
				//--END LOG MAIN--//

			/* Hapus file yng ada */
			$delete = $this->input->post('deletejaminan');
			unset($where);
			unset($set);
			$where['PQM_ID'] = $pqm_id;
			$set = $where;
			foreach ((array)$delete as $key => $value) {
				if ($value == '1') {
					$set['PQM_FILE_'.$key] = '';
				}
			}
			if ($pqm_id != null) {
				$this->prc_tender_quo_main->update($set, $where);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Quotation/save_bidding','prc_tender_quo_main','update',$set,$where);
					//--END LOG DETAIL--//
			}
			unset($where);
			unset($set);
			//*/

			$file_penawaran = isset($uploaded['file_penawaran']['file_name']) ? $uploaded['file_penawaran']['file_name'] : '';
			$file_pelaksanaan = isset($uploaded['file_pelaksanaan']['file_name']) ? $uploaded['file_pelaksanaan']['file_name'] : '';
			$file_pemeliharaan = isset($uploaded['file_pemeliharaan']['file_name']) ? $uploaded['file_pemeliharaan']['file_name'] : '';

			/* Insert into PRC_TENDER_QUO_MAIN */
			$where['PTV_VENDOR_CODE'] = $vendorno;
			$where['PTM_NUMBER'] = $id;
			// $this->prc_tender_quo_main->delete($where);
			$pqmnew['PQM_ID'] = $newid;
			if(isset($uploaded['file_surat'])){
				$pqmnew['FILE_SURAT'] = $uploaded['file_surat']['file_name'];
			}
			$pqmnew['PTM_NUMBER'] = $id;
			$pqmnew['PTV_VENDOR_CODE'] = $vendorno;
			$pqmnew['PQM_NUMBER'] = $this->input->post('pqm_number');
			$pqmnew['PQM_LOCAL_CONTENT'] = $this->input->post('pqm_local_content');
			$pqmnew['PQM_DELIVERY_TIME'] = $this->input->post('pqm_delivery_time');
			$pqmnew['PQM_DELIVERY_UNIT'] = $this->input->post('pqm_delivery_unit');
			$pqmnew['PQM_VALID_THRU'] = date('d-M-Y g.i.s A', strtotime($this->input->post('pqm_valid_thru')));
			$pqmnew['PQM_NOTES'] = $this->input->post('pqm_notes');
			$pqmnew['PQM_CREATED_DATE'] = date('d-M-Y g.i.s A');
			$pqmnew['PQM_INCOTERM'] = $this->input->post('pqm_incoterm');
			$pqmnew['PQM_CURRENCY'] = 'IDR';
			$pqmnew['PQM_FILE_PENAWARAN'] = intval($this->input->post('pqm_penawaran')) == 0 ? '' : $file_penawaran;
			$pqmnew['PQM_FILE_PELAKSANAAN'] = intval($this->input->post('pqm_pelaksanaan')) == 0 ? '' : $file_pelaksanaan;
			$pqmnew['PQM_FILE_PEMELIHARAAN'] = intval($this->input->post('pqm_pemeliharaan')) == 0 ? '' : $file_pemeliharaan;
			if ($pqmnew['PQM_FILE_PENAWARAN'] == '') {
				unset($pqmnew['PQM_FILE_PENAWARAN']);
			}
			if ($pqmnew['PQM_FILE_PELAKSANAAN'] == '') {
				unset($pqmnew['PQM_FILE_PELAKSANAAN']);
			}
			if ($pqmnew['PQM_FILE_PEMELIHARAAN'] == '') {
				unset($pqmnew['PQM_FILE_PEMELIHARAAN']);
			}
			if ($pqm_id == null) {
				$this->prc_tender_quo_main->insert($pqmnew);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Quotation/save_bidding','prc_tender_quo_main','insert',$pqmnew);
					//--END LOG DETAIL--//
				$newid = $this->prc_tender_quo_main->get_id() - 1;
			} else {
				$this->prc_tender_quo_main->update($pqmnew, $where);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Quotation/save_bidding','prc_tender_quo_main','update',$pqmnew,$where);
					//--END LOG DETAIL--//
			}

			/* Insert into PRC_TENDER_QUO_ITEM */
			unset($where);
			$where['PQM_ID'] = $newid;
			$this->prc_tender_quo_item->delete($where);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Quotation/save_bidding','prc_tender_quo_item','delete',null,$where);
				//--END LOG DETAIL--//

			$inputanqty = $this->input->post('qty');
			if(isset($inputanqty)){
				$qty = $this->input->post('qty');
			}

			if ($this->input->post('ptqi') != null) {
				foreach ($this->input->post('ptqi') as $tit_id => $ptqi) {
					if (in_array($tit_id, (array)$this->input->post('check'))) {
						$newptqi['PQM_ID'] = $newid;
						$newptqi['TIT_ID'] = $ptqi['tit_id'];
						// $newptqi['PQI_TYPE'] = $ptqi['pqi_type'];
						$newptqi['PQI_DESCRIPTION'] = $ptqi['pqi_description'];
						$newptqi['PQI_PRICE'] = intval(str_replace(',', '', $ptqi['pqi_price']));
						$newptqi['PQI_CURRENCY'] = $ptqi['pqi_currency'];
						$newptqi['PQI_ID'] = $this->prc_tender_quo_item->get_id();
						$newptqi['PQI_QTY'] = $qty[$ptqi['tit_id']];
						$this->prc_tender_quo_item->insert($newptqi);
							//--LOG DETAIL--//
						$log_ptqi = array_merge($newptqi, array('PPI_ID'=>$ptqi['ppi_id']));
						$this->log_data->detail($LM_ID,'Quotation/save_bidding','prc_tender_quo_item','insert',$log_ptqi);
							//--END LOG DETAIL--//
					}
				}
			}
			//*/

			/* Hapus file yng ada */
			// $delete = $this->input->post('delete');
			// unset($where);
			// $where['PTM_NUMBER'] = $id;
			// $where['PTV_VENDOR_CODE'] = $vendorno;
			// foreach ((array)$delete as $key => $value) {
			// 	foreach ((array)$value as $keyy => $valuee) {
			// 		if ($valuee == '1') {
			// 			$where['TIT_ID'] = $key;
			// 			$where['ET_ID'] = $keyy;
			// 			$this->prc_eval_file->delete($where);
			// 		}
			// 	}
			// }
			// unset($where);
			//*/

			/* Insert into PRC_EVAL_FILE */
			// $ef['PTM_NUMBER'] = $id;
			// $ef['PTV_VENDOR_CODE'] = $vendorno;
			// $delete_ef['PTM_NUMBER'] = $id;
			// $delete_ef['PTV_VENDOR_CODE'] = $vendorno;
			// foreach ($uploaded as $key => $value) {
			// 	if (substr($key, 0, 4) != 'file') {
			// 		$ef['EF_FILE'] = $value['file_name'];
			// 		$explodes = explode('|', $key);
			// 		$ef['TIT_ID'] = $explodes[0];
			// 		$ef['ET_ID'] = $explodes[1];
			// 		$delete_ef['TIT_ID'] = $explodes[0];
			// 		$delete_ef['ET_ID'] = $explodes[1];
			// 		$this->prc_eval_file->delete($delete_ef);
			// 		$ef['EF_ID'] = $this->prc_eval_file->get_id();
			// 		$this->prc_eval_file->insert($ef);
			// 	}
			// }
			$tit_id = (array)$this->input->post('id_tit');
			$file_upload = (array)$this->input->post('file_upload');
			foreach ($file_upload as $key => $val) {
				if(!empty($val)){
					$pef['EF_ID'] = $this->prc_eval_file->get_id();
					$pef['PTM_NUMBER'] = $id;
					$pef['PTV_VENDOR_CODE'] = $vendorno;
					$pef['EF_FILE'] = $val;
					$pef['TIT_ID'] = $tit_id[$key];
					$this->prc_eval_file->insert($pef);	
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Quotation/save_bidding','prc_eval_file','insert',$pef);
						//--END LOG DETAIL--//
				}			
			}

			$where = array();
			$where['PTV_VENDOR_CODE'] = $vendorno;
			$where['PTM_NUMBER'] = $id;
			$set['PTV_STATUS'] = 2;
			$this->prc_tender_vendor->update($set, $where);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Quotation/save_bidding','prc_tender_vendor','update',$set, $where);
				//--END LOG DETAIL--//

			$this->session->set_flashdata('success', 'success');
			redirect('Quotation');
		}
	}

	public function save_harga() {
		$tgl_batasPenawaran = $this->input->post('tgl_batasPenawaran');	
		$dateNew = date('Y-m-d H:i:s');
		if (strtotime($tgl_batasPenawaran) < strtotime($dateNew)) {
			$this->session->set_flashdata('error', ' Melebihi Tgl Batas Penawaran Harga.');
			redirect('Quotation');
		}

		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_preq_quo_tech');
		$this->load->model('prc_preq_eval');
		$this->load->model('prc_tender_quo_file');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_eval_file');

		$id = $this->input->post('ptm_number');		
		$vendorno = $this->session->userdata('VENDOR_NO');
		
		$pqm = $this->prc_tender_quo_main->ptmptv($id, $vendorno);
		$pqm_id = $pqm[0]['PQM_ID'];
		$newid = $pqm_id;

			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
				'VENDOR','Input Penawaran Harga','SIMPAN PENAWARAN',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		/* Insert into PRC_TENDER_QUO_ITEM */
		// unset($where);
		// $where['PQM_ID'] = $newid;
		// $this->prc_tender_quo_item->delete($where);
		foreach($this->input->post('ptqi') as $ptqi) {
			$where_ptqi['PQI_ID'] = $ptqi['pqi_id'];

			// $newptqi['PQI_PRICE'] = intval(str_replace(',', '', $ptqi['pqi_price']));
			$newptqi['PQI_PRICE'] = str_replace(',', '', $ptqi['pqi_price']);
			$newptqi['PQI_CURRENCY'] = $ptqi['pqi_currency'];
			$this->prc_tender_quo_item->update($newptqi, $where_ptqi);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Quotation/save_harga','prc_tender_quo_item','update',$newptqi, $where_ptqi);
				//--END LOG DETAIL--//
		}
		//*/
		$file_harga = $this->input->post('file_harga');
		$where = array();
		$where['PTV_VENDOR_CODE'] = $vendorno;
		$where['PTM_NUMBER'] = $id;
		$set_ptv['PTV_STATUS_EVAL'] = 2;
		if(!empty($file_harga)){
			$set_ptv['FILE_HARGA'] = $file_harga;			
		}
		$this->prc_tender_vendor->update($set_ptv, $where);
			//--LOG DETAIL--//
		$set_ptv2 = array_merge($set_ptv, array('PTM_NUMBER'=>$id));
		$this->log_data->detail($LM_ID,'Quotation/save_harga','prc_tender_vendor','update',$set_ptv2, $where);
			//--END LOG DETAIL--//

		$this->session->set_flashdata('success', 'success');
		redirect('Quotation');
	}

	public function deleteFile(){
		$id = $this->input->post('id');
		$fileHarga = $this->input->post('filename');
		$this->load->model('prc_tender_vendor');
		
		$this->load->helper("url");

		$path = './upload/vendor/'.$fileHarga;
	    if(file_exists(BASEPATH.'../upload/vendor/'.$fileHarga)){
	        unlink($path);
	    }
	    
		$where['PTV_ID'] = $id;
		$set_ptv['FILE_HARGA'] = null;
		$this->prc_tender_vendor->update($set_ptv, $where);		
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
			// if($ptp['PTP_JUSTIFICATION_ORI'] == 5){
			// 	die(json_encode(array('warning' => 'error')));
			// }
			if (intval($harga) > intval($item['TIT_PRICE'] * (100 + intval($ptp['PTP_BATAS_PENAWARAN'])) / 100)) {
				$data['atas'] = 'atas';
				$data['status'] = false;
			} else if (intval($harga) < intval($item['TIT_PRICE'] * (100 - intval($ptp['PTP_BAWAH_PENAWARAN'])) / 100)) {
				$data['atas'] = 'bawah';
				$data['status'] = false;
			} else {
				$data['atas'] = '';
				$data['status'] = true;
			}
			$data['warning'] = $ptp['PTP_WARNING_ORI'] == 2 ? 'warning' : 'error';
			echo json_encode($data);
		}
	}

	function uploadAttachment() {
		$this->load->library('encrypt');
		$server_dir = str_replace("\\", "/", FCPATH);
		$upload_dir = UPLOAD_PATH."quo_file/";
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

	public function viewDok($file = null){
		$url = str_replace("int-","", base_url());
		$this->load->helper('file');
		$image_path = base_url(UPLOAD_PATH).'/quo_file/'.$file;

		if (strpos($url, 'semenindonesia.com') !== false) { //server production
			$user_id=url_encode($this->session->userdata['ID']);
			if(empty($file)){
				die('tidak ada attachment.');
			}
			if(file_exists(BASEPATH.'../upload/quo_file/'.$file)){				
				$this->output->set_content_type(get_mime_by_extension($image_path));
				return $this->output->set_output(file_get_contents($image_path));
			}else{
				$url = str_replace("http","https", $url);
				redirect($url.'View_document_vendor/viewDok_quo/'.$file.'/'.$user_id);
			}

		}else{ //server development
			if(empty($file) || !file_exists(BASEPATH.'../upload/quo_file/'.$file)){
				die('tidak ada attachment.');
			}
			
			$this->output->set_content_type(get_mime_by_extension($image_path));
			return $this->output->set_output(file_get_contents($image_path));
		}

	}

	public function deleteQuoFile(){
		$id = $this->input->post('id');
		$id = url_decode($id);
		$vendor_no = $this->input->post('vendor_no');
		$tit_id = $this->input->post('tit_id');
		$file = $this->input->post('filename');
		$this->load->model('prc_eval_file');
		
		$this->load->helper("url");

		$path = './upload/quo_file/'.$file;
		if(file_exists(BASEPATH.'../upload/quo_file/'.$file)){
	        unlink($path);
	    }
		$where['PTM_NUMBER'] = $id;
		$where['PTV_VENDOR_CODE'] = $vendor_no;
		$where['TIT_ID'] = $tit_id;
		$this->prc_eval_file->delete($where);	    
	}

}
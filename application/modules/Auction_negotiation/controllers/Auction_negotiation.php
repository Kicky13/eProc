<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auction_negotiation extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
	}

	function index() {
		$data['title'] = "Daftar Auction";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/auction_negotiation_list.js');
		$this->layout->render('negotiation_list',$data);
	}

	function save_breakdown() {
		$this->load->model(array(
			'prc_auction_quo_header', 
			'prc_tender_item', 
			'prc_tender_main',
			'prc_tender_vendor', 
			'prc_tender_quo_item', 
			'prc_auction_detail',));
		

		$price = $this->input->post('price');
		$qty = $this->input->post('qty');
		$paqh = $this->input->post('paqh');
		$paqh_decrement_value = $this->input->post('paqh_decrement_value');
		$data_paqh = $this->prc_auction_quo_header->get(array('PAQH_ID' => $paqh));
		
		$this->load->library('encrypt');
		$server_dir = str_replace("\\", "/", FCPATH);		
		$upload_dir = UPLOAD_PATH."paqh_file/";
		$this->load->library('file_operation');
		$this->file_operation->create_dir($upload_dir);
		$this->load->library('FileUpload');
		$uploader = new FileUpload('file_breakdown');
		$ext = $uploader->getExtension(); // Get the extension of the uploaded file		
		$filename = 'paqh_file_'.$paqh.".".$ext;
		$uploader->newFileName = $filename;
		$file_exist=glob($server_dir.$upload_dir.'paqh_file_'.$paqh.".*");
		// echo '<pre>';var_dump($file_exist);echo '<pre>'; exit();
		if(count($file_exist)>0){
			foreach ($file_exist as $value) {
				unlink($value);
			}
		}
		
		$result = $uploader->handleUpload($server_dir.$upload_dir);
		if (!$result) {
			$this->session->set_flashdata('error', 'Dokumen gagal diupload, silahkan masukkan dokumen.');
			redirect('Auction_negotiation/breakdown/'.url_encode($paqh));
		}
		
			//--LOG MAIN--//
		if(isset($this->session->userdata['ID'])){
			$user_id = $this->session->userdata['ID'];	
			$user_name = $this->session->userdata['FULLNAME'];
			$position = $this->authorization->getCurrentRole();
		}else{
			$user_id = $this->session->userdata['VENDOR_NO'];	
			$user_name = $this->session->userdata['VENDOR_NAME'];
			$position = 'VENDOR';
		}
		$this->log_data->main($user_id,$user_name,$position,'Breakdown Auction','SUBMIT',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		foreach ($price as $key => $value) {
			$this->prc_tender_quo_item->update(array('PQI_FINAL_PRICE' => $value), array('PQI_ID' => $key));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Auction_negotiation/save_breakdown','prc_tender_quo_item','update',array('PQI_FINAL_PRICE' => $value),array('PQI_ID' => $key));
				//--END LOG DETAIL--//
		}

		$vendor = $this->input->post('vendor');
		$ptm_number = $this->input->post('ptm_number');

		$this->prc_tender_item->update(array('TIT_STATUS' => 5), array('PTM_NUMBER' => $ptm_number, 'PAQH_ID' => $paqh));
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Auction_negotiation/save_breakdown','prc_tender_item','update',array('TIT_STATUS' => 5, 'PTM_NUMBER' => $ptm_number),array('PTM_NUMBER' => $ptm_number, 'PAQH_ID' => $paqh));
			//--END LOG DETAIL--//

		$this->prc_auction_quo_header->update(array('IS_BREAKDOWN' => 1,'FILE_UPLOAD' => $filename), array('PAQH_ID' => $paqh));
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Auction_negotiation/save_breakdown','prc_auction_quo_header','update',array('IS_BREAKDOWN' => 1,'FILE_UPLOAD' => $filename),array('PAQH_ID' => $paqh));
			//--END LOG DETAIL--//

		$is_rfc_error = false;
		$hasil_rfc = array();
		$retrfq = $this->save_rfq($ptm_number, $vendor);
		if ($retrfq != null) {
			foreach ($retrfq['FT_RETURN'] as $ft) {
				$hasil_rfc[] = $ft;
				if ($ft['TYPE'] == 'E') {
					$is_rfc_error = true;
				}
			}
		}
		$this->session->set_flashdata('rfc_ft_return', json_encode($hasil_rfc));
		if ($is_rfc_error) {
			// var_dump($this->session->flashdata('rfc_ft_return')); exit();							
			redirect('Auction_negotiation/breakdown/'.url_encode($paqh));
		}

		if($data_paqh[0]['BREAKDOWN_TYPE']=='S'){
			redirect('Auction/monitor/'.$paqh);
		}else{
			redirect('Auction_negotiation/index');
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

		return $return;
	}

	function breakdown($paqh_id) {
		$paqh_id = url_decode($paqh_id);
		$this->load->model(array('prc_auction_quo_header','prc_tender_main', 'prc_tender_item', 'prc_tender_vendor', 'prc_tender_quo_item', 'prc_auction_detail'));
		$data['title'] = 'Breakdown Auction Price';

		if($this->prc_auction_quo_header->get(array('PAQH_ID' => $paqh_id)) != NULL)
		{
			$this->prc_auction_quo_header->join_ptm();
			$data_paqh = $this->prc_auction_quo_header->get(array('PAQH_ID' => $paqh_id));
			$data['ptm_number'] = $data_paqh[0]['PTM_NUMBER'];
			$data['paqh'] = $data_paqh[0];
			if($data_paqh[0]['BREAKDOWN_TYPE']=='S'){
				$data['item'] = $this->prc_tender_quo_item->ptm_ptv_paqh($data['ptm_number'], $data_paqh[0]['VENDOR_WINNER'] ,$data_paqh[0]['PAQH_ID']);
				$data_vendor = $this->prc_auction_detail->getVendorSingle($data_paqh[0]['PAQH_ID'], $data_paqh[0]['VENDOR_WINNER']);
				$breakdown['PAQD_INIT_PRICE'] = $data_vendor['PAQD_INIT_PRICE'];
				$breakdown['PAQD_FINAL_PRICE'] = $data_vendor['PAQD_FINAL_PRICE'];
				foreach ($data['item'] as $item) {
					if($data_paqh[0]['PAQH_PRICE_TYPE']=='S'){
						$breakdown[$item['PQI_ID']] = round(($item['PQI_PRICE']/$breakdown['PAQD_INIT_PRICE'])*$breakdown['PAQD_FINAL_PRICE']);
					}else{
						$breakdown[$item['PQI_ID']] = round(((($item['TIT_QUANTITY']*$item['PQI_PRICE'])/$breakdown['PAQD_INIT_PRICE'])*$breakdown['PAQD_FINAL_PRICE'])/$item['TIT_QUANTITY']);
					}
				}
				$data['breakdown']=$breakdown;
			}else{
				$data['item'] = $this->prc_tender_quo_item->ptm_ptv_paqh($data['ptm_number'], $this->session->userdata('VENDOR_NO'),$data['paqh']['PAQH_ID']);			
				$data_vendor = $this->prc_auction_detail->getVendorSingle($data_paqh[0]['PAQH_ID'], $this->session->userdata('VENDOR_NO'));
				$breakdown['PAQD_INIT_PRICE'] = $data_vendor['PAQD_INIT_PRICE'];
				$breakdown['PAQD_FINAL_PRICE'] = $data_vendor['PAQD_FINAL_PRICE'];
				$data['breakdown']=$breakdown;
			}
			$ptm = $this->prc_tender_main->ptm($data_paqh[0]['PTM_NUMBER']);
			$data['is_jasa']=$ptm[0]['IS_JASA'];
			$data['vendor'] = $data_vendor;
			$datetimestamp = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
			$now = date_format($datetimestamp, 'd-m-Y H.i.s');

			$auction_start = substr($data_paqh[0]['PAQH_AUC_START'], 0, 19);
			$auction_end = substr($data_paqh[0]['PAQH_AUC_END'], 0, 19);

			if(strtotime($auction_end) < strtotime($now)) {
				$data['status_auction'] = 'auction sudah selesai';
			}
			else if(strtotime($auction_start) > strtotime($now))
			{
				$data['status_auction'] = 'auction belum mulai';
			}
			else{
				$data['status_auction'] = 'proses';
			}

			$this->layout->set_table_js();
			date_default_timezone_set('Asia/Jakarta');
			$data['timenow'] = date('d M Y H:i:s');
			$this->layout->add_js("swal.js");
			$this->layout->add_js("sweetalert2.min.js");
			$this->layout->add_js('plugins/autoNumeric.js');
			$this->layout->add_js('pages/negotiation_breakdown.js');
			$this->layout->render('negotiation_breakdown', $data);
		}
	}

	function detail_negotiation($paqh_id) {
		$paqh_id = url_decode($paqh_id);
		$this->load->model(array('prc_auction_quo_header', 'prc_tender_item', 'prc_tender_vendor', 'prc_tender_quo_item', 'prc_auction_detail','prc_tender_quo_item'));
		$data['title'] = 'Auction Negotiation Detail';

		if($this->prc_auction_quo_header->get(array('PAQH_ID' => $paqh_id)) != NULL)
		{	
			$this->prc_auction_quo_header->join_ptm();
			$data_paqh = $this->prc_auction_quo_header->get(array('PAQH_ID' => $paqh_id));
			$data['ptm_number'] = $data_paqh[0]['PTM_NUMBER'];
			$data['paqh'] = $data_paqh[0];			
			$data['item'] = $this->prc_tender_item->ptm_paqh($data['ptm_number'], $data_paqh[0]['PAQH_ID']);

			$vnd = $this->session->userdata['VENDOR_NO'];
			$tit_id = $data['item'][0]['TIT_ID'];
			$vendor1= $this->prc_tender_quo_item->get_ptm_tit($data['ptm_number'],$vnd,$tit_id);
			$data['nilai_teknis'] = $vendor1[0]['PQI_TECH_VAL'];
			// echo"<pre>";
			// print_r($tit_id);die;

			$datetimestamp = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
			$now = date_format($datetimestamp, 'd-m-Y H.i.s');

			$auction_start = substr($data_paqh[0]['PAQH_AUC_START'], 0, 19);
			$auction_end = substr($data_paqh[0]['PAQH_AUC_END'], 0, 19);

			if(strtotime($auction_end) < strtotime($now)) {
				$data['status_auction'] = 'auction sudah selesai';
			}
			else if(strtotime($auction_start) > strtotime($now))
			{
				$data['status_auction'] = 'auction belum mulai';
			}
			else{
				$data['status_auction'] = 'proses';
			}
			$data_vendor = $this->prc_auction_detail->getVendorSingle($data_paqh[0]['PAQH_ID'], $this->session->userdata('VENDOR_NO'));
			
			$data['vendor'] = $data_vendor;
			$this->layout->set_table_js();
			date_default_timezone_set('Asia/Jakarta');
			$data['timenow'] = date('d M Y H:i:s');
			$this->layout->add_js('pages/auction_negotiation.js');
			$this->layout->render('negotiation_detail', $data);
		}
	}

	function get_negotiation_list()
	{
		$this->load->model('prc_auction_quo_header');				
		$this->prc_auction_quo_header->where_vendor($this->session->userdata('VENDOR_NO'));				
		$auction_nego = $this->prc_auction_quo_header->get(array('PAQH_OPEN_STATUS' => 1));	
		$data = array();
		if(count($auction_nego)>0){
			foreach ($auction_nego as $key => $row)
			{
				$PTM_NUMBER = $row['PTM_NUMBER'];
				$PAQH_ID = $row['PAQH_ID'];				
				$sql = "SELECT COUNT(PRC_TENDER_ITEM.TIT_ID) as jumlah FROM PRC_TENDER_ITEM WHERE PRC_TENDER_ITEM.TIT_STATUS = '4' AND PRC_TENDER_ITEM.PAQH_ID = ? AND PRC_TENDER_ITEM.PTM_NUMBER = ?"; 
				$query = $this->db->query($sql, array($PAQH_ID, $PTM_NUMBER));
				$count = $query->row_array();
				if($count["JUMLAH"] > 0){
					$data[] = $row;
				}
			}
			$auction_nego = $data;	
		}


		$datetimestamp = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
		$now = date_format($datetimestamp, 'd-m-Y H.i.s');
		foreach ((array)$auction_nego as $key => $value) {
			$end = substr($value["PAQH_AUC_END"], 0, 19);
			$start = substr($value["PAQH_AUC_START"], 0, 19);
			if (strtotime($end) < strtotime($now)) { // cek kalo datenya in range
				$auction_nego[$key]['STATUS'] = 'out Auction';
			} else if(strtotime($end) > strtotime($now) && strtotime($start) < strtotime($now)) {
				$auction_nego[$key]['STATUS'] = 'in Auction';
			} else {
				$auction_nego[$key]['STATUS'] = 'prepare Auction';
			}
			$auction_nego[$key]['ECT_PAQH_ID'] = url_encode($value['PAQH_ID']);
		}
		echo json_encode(array('data' => $auction_nego));
	}

	function get_auction_closed_list()
	{
		$this->load->model('prc_auction_quo_header');
		$this->prc_auction_quo_header->where_vendor($this->session->userdata('VENDOR_NO'));
		$this->prc_auction_quo_header->where_breakdown();
		$auction_nego = (array) $this->prc_auction_quo_header->get(array('PAQH_OPEN_STATUS' => 2,'BREAKDOWN_TYPE'=>'V','VENDOR_WINNER' => $this->session->userdata('VENDOR_NO')));
		$datetimestamp = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
		$now = date_format($datetimestamp, 'd-m-Y H.i.s');
		foreach ($auction_nego as $key => $value) {
			$auction_nego[$key]['STATUS'] = 'out Auction';
			$auction_nego[$key]['ECT_PAQH_ID'] = url_encode($value['PAQH_ID']);
		}
		echo json_encode(array('data' => $auction_nego));
	}

	function update_bid() {
		$this->load->model(array('prc_auction_detail','prc_auction_quo_header','prc_auction_log','prc_tender_quo_item'));
		$id = $this->input->post('paqh');
		$tit_id = $this->input->post('tit_id');

		$data_paqh = $this->prc_auction_quo_header->get(array('PAQH_ID' => $id));
		$paqh = $data_paqh[0];
		$id_ptm = $paqh['PTM_NUMBER'];
		$bt = $paqh['BOBOT_TEKNIS'];
		$bh = $paqh['BOBOT_HARGA'];
		// echo "<pre>";
		// print_r($tit_id);die;

		$datetimestamp = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
		$now = strtotime(date_format($datetimestamp, 'd-m-Y H.i.s'));

		$auction_start = strtotime($paqh['PAQH_AUC_START']);
		$auction_end = strtotime($paqh['PAQH_AUC_END']);

		if ($auction_end < $now) {
			echo 'Ended, auction end = '.oracledate($auction_end).', now = '.oracledate($now);
			return;
		} else if ($auction_start > $now) {
			echo 'Not Started, auction start = '.oracledate($auction_start).', now = '.oracledate($now);
			return;
		}

		$ptv_vendor_code = $this->input->post('ptv_vendor_code');
		$iterasi_temp = $this->prc_auction_detail->get(array('PAQH_ID' => $this->input->post('paqh'), 'PTV_VENDOR_CODE' => $ptv_vendor_code));
		$iterasi = $iterasi_temp[0]['PAQD_ITER'];

		$data = array (
			'PAQD_FINAL_PRICE' => $this->input->post('bid'),
			'PAQD_ITER' => $iterasi+1
			);
		$this->prc_auction_detail->update($data, array('PAQH_ID' => $this->input->post('paqh'), 'PTV_VENDOR_CODE' => $ptv_vendor_code));

		//penambahan bobot ARCHIE//
		if (!empty($paqh['BOBOT_TEKNIS'])){
			$vnd_detail = $this->prc_auction_detail->get(array('PAQH_ID' => $this->input->post('paqh')));
		// echo "<pre>";
		// print_r($vnd_detail);die;
			foreach ($vnd_detail as $value) {
				$vnd_code = $value['PTV_VENDOR_CODE'];
				$vnd_price = $value['PAQD_FINAL_PRICE'];
				$vendor1= $this->prc_tender_quo_item->get_ptm_tit($id_ptm,$vnd_code,$tit_id);
				$min_harga = $this->prc_auction_detail->get_min_harga($id);

				$bobot_teknis = $vendor1[0]['PQI_TECH_VAL'] * $bt / 100;
				$bobot_harga = $min_harga['MINHARGA'] / $vnd_price * $bh;
				$nilai_gabung = $bobot_teknis + $bobot_harga;
				$dataa['NILAI_GABUNG'] = number_format($nilai_gabung,2);
				$where1['PAQH_ID']= $id;
				$where1['PTV_VENDOR_CODE']= $vnd_code;
			// echo "<pre>";
			// print_r($where1);
			# code...
				$this->prc_auction_detail->update($dataa, $where1);
			}
		}
		//end penambahan bobot archie//

			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Auction Negotiation','SUBMIT',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$data_log = array_merge($data,array('PTM_NUMBER'=>$paqh['PTM_NUMBER'])); // nambah data ptm_number di log detail untuk query view
		$this->log_data->detail($LM_ID,'Auction_negotiation/update_bid','prc_auction_detail','update',$data_log, array('PAQH_ID' => $this->input->post('paqh'), 'PTV_VENDOR_CODE' => $ptv_vendor_code)); 
			//--END LOG DETAIL--//

		$data = array (
			'VENDOR_NO' => $ptv_vendor_code,
			'CREATED_AT' => date('d-M-Y g.i.s A'),
			'PRICE' => $this->input->post('bid'),
			'ITER' => $iterasi+1,
			'PAQH_ID' => $this->input->post('paqh')
			);
		$this->prc_auction_log->insert($data);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Auction_negotiation/update_bid','prc_auction_log','insert',$data);
			//--END LOG DETAIL--//
		echo 'true';
		return true;
	}

	function get_min_bid() {
		$this->load->model(array('prc_auction_detail','prc_auction_quo_header'));
		$paqh = $this->input->post('paqh');
		$bobot = $this->prc_auction_quo_header->get(array('PAQH_ID' => $paqh));
		if (!empty($bobot[0]['BOBOT_TEKNIS'])) {
			$vendorWinner = $this->prc_auction_detail->getMinBidBobot($paqh);
		} else {
			$vendorWinner = $this->prc_auction_detail->getMinBid($paqh);
		}
		// echo "<pre>";
		// print_r($vendorWinner);die;
		echo json_encode($vendorWinner);
	}

	function getOpeningTime() {
		$this->load->model(array('prc_auction_quo_header'));
		$paqh = $this->input->post('paqh');
		$time = $this->prc_auction_quo_header->get(array('PAQH_ID' => $paqh));
		echo json_encode(substr($time[0]['PAQH_AUC_START'],0,19));
	}

	function getCurrentTime() {
		date_default_timezone_set('Asia/Jakarta');
		echo json_encode(date('d M Y H:i:s'));
	}

	function uploadAttachment() {
		$this->load->library('encrypt');
		$server_dir = str_replace("\\", "/", FCPATH);
		$upload_dir = UPLOAD_PATH."paqh_file/";
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
}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auction extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->load->library("file_operation");
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
	}

	/* nampilin list */
	public function index($status = null) {
		$data['title'] = 'Daftar Auction';
		$data['status'] = $status;
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		if($status == null){
			$this->layout->add_js('pages/auction_list_stat_null.js');
			$this->layout->render('auction_list_stat_null', $data);
		} else {
			$this->layout->add_js('pages/auction_index.js');
			$this->layout->render('auction_list', $data);
		}
	}

	/* create auction by ptm */
	public function create($id) {
		$data['title'] = 'Konfigurasi Auction';
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_quo_item');


		$ptm = $this->prc_tender_main->ptm($id);
		$data['ptm'] = $ptm[0];

		$this->prc_tender_item->join_item();
		$data['item'] = $this->prc_tender_item->ptm_auction($id, $data['ptm']['IS_JASA'] == 1);

		$ptp = $this->prc_tender_prep->ptm($id);
		$is_itemize = $ptp['PTP_IS_ITEMIZE'];

		$this->prc_tender_vendor->where_active();
		$vendors = $this->prc_tender_vendor->ptm($id);
		$data['vendor'] = $vendors;

		$data['vendors'] = array();
		foreach ($data['vendor'] as $key => $value) {
			$totpqm = 0;
			foreach ($data['item'] as $k => $val) {
				$this->prc_tender_quo_item->where_tit($val['TIT_ID']);
				$this->prc_tender_quo_item->where_win();
				$ptqm = $this->prc_tender_quo_item->ptm_ptv($id,$value['PTV_VENDOR_CODE']);
				$totpqm += count($ptqm);
			}
			$data['vendors'][] = $value;
		}


		$this->prc_tender_quo_item->join_pqm();
		$this->prc_tender_quo_item->where_win();
		$ptqi = $this->prc_tender_quo_item->get_by_ptm($id);
		$harga_vendor_sebagian = array();
		$harga_vendor_total = array();
		foreach ($vendors as $vnd) {
			$harga_vendor_total[$vnd['PTV_VENDOR_CODE']] = 0;
			$harga_vendor_sebagian[$vnd['PTV_VENDOR_CODE']] = 0;
		}
		foreach ($ptqi as $val){
			$data['vendor_item'][$val['TIT_ID']][$val['PTV_VENDOR_CODE']] = $val;
			$harga_vendor_sebagian[$val['PTV_VENDOR_CODE']] = $harga_vendor_sebagian[$val['PTV_VENDOR_CODE']] + $val['PQI_PRICE'];
			$harga_vendor_total[$val['PTV_VENDOR_CODE']] = $harga_vendor_total[$val['PTV_VENDOR_CODE']] + ($val['PQI_PRICE'] * $val['PQI_QTY']);
		}

		$data['harga_vendor_sebagian'] = $harga_vendor_sebagian;
		$data['harga_vendor_total'] = $harga_vendor_total;

		$this->layout->set_datetimepicker();

		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->add_js("swal.js");
		$this->layout->add_js("sweetalert2.min.js");
		$this->layout->add_js("strTodatetime.js");		
		if($is_itemize == "1"){
			$this->layout->add_js('pages/auction_create.js');
			$this->layout->render('auction_create', $data);
		} else {
			$this->layout->add_js('pages/auction_create_paket.js');
			$this->layout->render('auction_create_paket', $data);
		}
	}

	/* save create auction */
	public function save() {
		$this->load->model('prc_auction_quo_header');
		$this->load->model('prc_auction_detail');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_auction_item');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_quo_item');

		// $id=$this->input->post('ptm_number');
		// $vnd=$this->input->post('vendor_ikut');
		// foreach ($vnd as $value) {
		// 	$vendor= $this->prc_tender_quo_item->get_ptm($id,$value);
		// }
		$paqh_id = $this->prc_auction_quo_header->get_id();

		//penambahan bobot archie//
		$bobot = $this -> input -> post('bobot_type');
		
		// echo "<pre>";
		// print_r($vendor);die;

		if($bobot=="1"){
			$bt = 60;
			$bh = 40;
		} else if($bobot=="2"){
			$bt = 70;
			$bh = 30;
		} else if($bobot=="3"){
			$bt = 80;
			$bh = 20;
		} else if($bobot=="4"){
			$bt = 90;
			$bh = 10;
		}
		//end penambahan bobot//

		// echo "<pre>";
		// print_r($bt);
		// print_r($bh);
		// die;

		$data = array(
			'PAQH_ID' => $paqh_id,
			'PTM_NUMBER' => $this->input->post('ptm_number'),
			'PAQH_DECREMENT_VALUE' => str_replace(',', '', $this->input->post('paqh_decrement_value')),
			'PAQH_PRICE_TYPE' => $this->input->post('paqh_price_type'),
			'PAQH_HPS' => $this->input->post('paqh_hps'),
			'PAQH_AUC_START' => oracledate(strtotime($this->input->post('paqh_auc_start'))),
			'PAQH_AUC_END' => oracledate(strtotime($this->input->post('paqh_auc_end'))),
			'PAQH_LOCATION' => $this->input->post('paqh_location'),
			'PAQH_OPEN_STATUS' => 0,
			'PAQH_SUBJECT_OF_WORK' => $this->input->post('paqh_subject_of_work'),
			//penambahan bobot archie//
			'BOBOT_TEKNIS' => $bt,
			'BOBOT_HARGA' => $bh
			//end penambahan bobot//
			);

		$harus_ada=array(
			'PAQH_DECREMENT_VALUE'=>'Nilai Pengurangan',
			'PAQH_AUC_START'=>'Tanggal Pembukaan',
			'PAQH_AUC_END'=>'Tanggal Penutupan');
		$err='';
		foreach ($harus_ada as $kunci => $nilai) {
			if(empty($data[$kunci])||trim($data[$kunci])==""){
				$err.=$nilai.",";
			}
		}
		if(!empty($err)){
			$this->session->set_flashdata('error', $err.' Harus diisi'); redirect('Auction/index');
		}

		$this->prc_auction_quo_header->insert($data);
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Konfigurasi Auction','SIMPAN',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Auction/save','prc_auction_quo_header','insert',$data);
			//--END LOG DETAIL--//

		$vnd_ikut = $this->input->post('vendor_ikut');
		$harga_vendor = $this->input->post('total');
		$id_ptm = $data['PTM_NUMBER'];

		$tmp_id = $this->prc_auction_detail->get_id();
		if(!empty($vnd_ikut)){
			foreach ($vnd_ikut as $vnd) {
				$tmp_harga = 0;
				if(!empty($vnd)){

					$data_vendor = array(
						'PAQD_ID' => $tmp_id++,
						'PAQH_ID' => $paqh_id,
						'PTV_VENDOR_CODE' => $vnd,
						'PAQD_INIT_PRICE' => $harga_vendor[$vnd],
						'PAQD_ITER' => 0,
						'PAQD_FINAL_PRICE' => $harga_vendor[$vnd]
						);

					$this->prc_auction_detail->insert($data_vendor);
					
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Auction/save','prc_auction_detail','insert',$data_vendor);
						//--END LOG DETAIL--//
				}
			}
			//penambahan bobot archie//
			foreach ($vnd_ikut as $vnd) {
				$vendor1= $this->prc_tender_quo_item->get_ptm($id_ptm,$vnd);
				$min_harga = $this->prc_auction_detail->get_min_harga($paqh_id);
					// echo "<pre>";
					// print_r($min_harga);die;
				foreach ($vendor1 as $nilai) {
					$bobot_teknis = $nilai['PQI_TECH_VAL'] * $data['BOBOT_TEKNIS'] / 100;
					$bobot_harga = $min_harga['MINHARGA'] / $harga_vendor[$vnd] * $data['BOBOT_HARGA'];
					$nilai_gabung = $bobot_teknis + $bobot_harga;
					$dataa['NILAI_GABUNG'] = number_format($nilai_gabung,2);
					$where1['PAQH_ID']= $paqh_id;
					$where1['PTV_VENDOR_CODE']= $vnd;
						// echo "<pre>";
						// print_r($nilai_gabung);
				}
					// echo "<pre>";
					// print_r($vendor1);
				$this->prc_auction_detail->update($dataa, $where1);
			}
						//end penambahan bobot//
		}

		

		$cek_ikut = $this->input->post('item_ikut');

		if(!empty($cek_ikut)){
			foreach ($this->input->post('tender_item') as $key => $tit) {
				if(!empty($cek_ikut[$tit]))
				{
					$data_item_tender = array(
						'PAQH_ID' => $paqh_id,
						'TIT_STATUS' => 4
						);

					$this->prc_tender_item->update($data_item_tender, array('TIT_ID' => $tit));
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Auction/save','prc_tender_item','update',$data_item_tender, array('TIT_ID' => $tit));
						//--END LOG DETAIL--//

					$id = $this->prc_auction_item->get_id();
					$auction_item = array(
						'ID' => $id,
						'PAQH_ID' => $paqh_id,
						'TIT_ID' => $tit
						);
					$this->prc_auction_item->insert($auction_item);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Auction/save','prc_auction_item','insert',$auction_item);
						//--END LOG DETAIL--//
				}
			}
		}

		$id=$data['PTM_NUMBER'];
		$this->prc_tender_vendor->where_active();
		$vendor= $this->prc_tender_vendor->ptm($id);			
		$ptm=$this->prc_tender_main->ptm($id);		
		foreach ($vendor as $key => $value) {	
			if(in_array($value['VENDOR_NO'], $vnd_ikut)){
				$dataemail=array(
					'EMAIL_ADDRESS'=>$value['EMAIL_ADDRESS'],
					'data'=>array(
						'norfq'=>$value['PTV_RFQ_NO'],
						'noptm'=>$ptm[0]['PTM_PRATENDER'],
						'location'=>$data['PAQH_LOCATION'],
						'openingdate' => date('d M Y H:i:s',strtotime($this->input->post('paqh_auc_start'))),
						'closingdate' => date('d M Y H:i:s',strtotime($this->input->post('paqh_auc_end')))
						)
					);				
				//var_dump($dataemail);die;
				$this->kirim_email_auction($dataemail);
			}
		}

		// redirect('Auction/show/'.$paqh_id);
		redirect('Auction/index');
	}

	/* edit auction config by paqh */
	public function edit_konfig($paqh){
		$this->load->model(array('prc_auction_quo_header', 'prc_tender_prep','prc_tender_item', 'prc_tender_vendor', 'prc_tender_quo_item', 'prc_tender_main', 'prc_auction_detail'));
		$data['title'] = 'Edit Konfigurasi Auction';

		$data_auction = $this->prc_tender_main->join_auction();
		$this->prc_auction_quo_header->join_ptm();
		$data_paqh = $this->prc_auction_quo_header->get(array('PAQH_ID' => $paqh));

		$ptp = $this->prc_tender_prep->ptm($data_paqh[0]['PTM_NUMBER']);
		$is_itemize = $ptp['PTP_IS_ITEMIZE'];

		$data['paqh'] = $data_paqh[0];
		$data['item'] = $this->prc_tender_item->ptm_paqh($data_paqh[0]['PTM_NUMBER'], $data_paqh[0]['PAQH_ID']);
		if($data['item'] == NULL){
			$data['item'] = $this->prc_tender_item->ptm_auction($data_paqh[0]['PTM_NUMBER']);
		}

		$this->prc_tender_vendor->where_active();
		$vendors = $this->prc_tender_vendor->ptm($data_paqh[0]['PTM_NUMBER']);
		$data['vendor'] = $vendors;
		$data['vendors'] = array();
		foreach ($data['vendor'] as $key => $value) {
			$totpqm = 0;
			foreach ($data['item'] as $k => $val) {
				$this->prc_tender_quo_item->where_tit($val['TIT_ID']);
				$this->prc_tender_quo_item->where_win();
				$ptqm = $this->prc_tender_quo_item->ptm_ptv($data_paqh[0]['PTM_NUMBER'],$value['PTV_VENDOR_CODE']);
				$totpqm += count($ptqm);
			}
			if($totpqm == count($data['item']))
				$data['vendors'][] = $value;
		}

		$this->prc_tender_quo_item->join_pqm();
		$ptqi = $this->prc_tender_quo_item->get_by_ptm($data_paqh[0]['PTM_NUMBER']);

		$harga_vendor_sebagian = array();
		$harga_vendor_total = array();
		foreach ($vendors as $vnd) {
			$harga_vendor_total[$vnd['PTV_VENDOR_CODE']] = 0;
			$harga_vendor_sebagian[$vnd['PTV_VENDOR_CODE']] = 0;
		}

		foreach ($ptqi as $val){
			if(isset($harga_vendor_sebagian[$val['PTV_VENDOR_CODE']])){
				$data['vendor_item'][$val['TIT_ID']][$val['PTV_VENDOR_CODE']] = $val;
				$harga_vendor_sebagian[$val['PTV_VENDOR_CODE']] = $harga_vendor_sebagian[$val['PTV_VENDOR_CODE']] + $val['PQI_PRICE'];
				$harga_vendor_total[$val['PTV_VENDOR_CODE']] = $harga_vendor_total[$val['PTV_VENDOR_CODE']] + ($val['PQI_PRICE'] * $val['TIT_QUANTITY']);
			}
		}

		$data['harga_vendor_sebagian'] = $harga_vendor_sebagian;
		$data['harga_vendor_total'] = $harga_vendor_total;

		$this->layout->set_datetimepicker();

		$this->layout->add_js('plugins/autoNumeric.js');		
		$this->layout->add_js("swal.js");
		$this->layout->add_js("sweetalert2.min.js");
		$this->layout->add_js("strTodatetime.js");		
		if($is_itemize == "1"){
			$this->layout->add_js('pages/auction_edit.js');
			$this->layout->render('edit_konfigurasi', $data);
		} else {
			$this->layout->add_js('pages/auction_edit_paket.js');
			$this->layout->render('edit_konfigurasi_paket', $data);
		}
	}

	/* save new auction config */
	public function simpan_edit() {
		$this->load->model(array('prc_auction_quo_header','prc_auction_detail','prc_tender_item','prc_tender_vendor','prc_tender_main','prc_tender_quo_item'));
		
		$where = array('PAQH_ID' => $this->input->post('paqh_id'));
		$paqh=$this->prc_auction_quo_header->get($where);
		
		//penambahan bobot archie//
		$paqhID = $this->input->post('paqh_id');
		$bobot = $this -> input -> post('bobot_type');
		
		// echo "<pre>";
		// print_r($bobot);die;

		if($bobot=="1"){
			$bt = 60;
			$bh = 40;
		} else if($bobot=="2"){
			$bt = 70;
			$bh = 30;
		} else if($bobot=="3"){
			$bt = 80;
			$bh = 20;
		} else if($bobot=="4"){
			$bt = 90;
			$bh = 10;
		}
		//end penambahan bobot//

		if($paqh[0]['PAQH_OPEN_STATUS']==0){
			$data = array(
				'PAQH_DECREMENT_VALUE' => str_replace(',', '', $this->input->post('paqh_decrement_value')),
				'PAQH_PRICE_TYPE' => $this->input->post('paqh_price_type'),
				'PAQH_HPS' => $this->input->post('paqh_hps'),
				'PAQH_AUC_START' => oracledate(strtotime($this->input->post('paqh_auc_start'))),
				'PAQH_AUC_END' => oracledate(strtotime($this->input->post('paqh_auc_end'))),
				'PAQH_LOCATION' => $this->input->post('paqh_location'),
				//penambahan bobot archie//
				'BOBOT_TEKNIS' => $bt,
				'BOBOT_HARGA' => $bh
				//end penambahan bobot//
				);
		}else if($paqh[0]['PAQH_OPEN_STATUS']==1){
			$data = array(
				'PAQH_DECREMENT_VALUE' => str_replace(',', '', $this->input->post('paqh_decrement_value')),						
				'PAQH_AUC_START' => oracledate(strtotime($this->input->post('paqh_auc_start'))),
				'PAQH_AUC_END' => oracledate(strtotime($this->input->post('paqh_auc_end'))),
				'PAQH_LOCATION' => $this->input->post('paqh_location'),
				'BOBOT_TEKNIS' => $bt,
				'BOBOT_HARGA' => $bh
				);
		}

		$harus_ada=array(
			'PAQH_DECREMENT_VALUE'=>'Nilai Pengurangan',
			'PAQH_AUC_START'=>'Tanggal Pembukaan',
			'PAQH_AUC_END'=>'Tanggal Penutupan');
		$err='';
		foreach ($harus_ada as $kunci => $nilai) {
			if(empty($data[$kunci])||trim($data[$kunci])==""){
				$err.=$nilai.",";
			}
		}
		if(!empty($err)){
			$this->session->set_flashdata('error', $err.' Harus diisi'); redirect('Auction/index');
		}

		// echo "<pre>";
		// print_r($data['BOBOT_TEKNIS']);die;
		$this->prc_auction_quo_header->update($data, $where);
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Edit Konfigurasi Auction','SIMPAN',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$data2=array_merge($data, array('PTM_NUMBER' => $this->input->post('ptm')));
		$this->log_data->detail($LM_ID,'Auction/simpan_edit','prc_auction_quo_header','update',$data2, $where);
			//--END LOG DETAIL--//
		
		
		/*edit ketika sebelum open auction*/
		if($paqh[0]['PAQH_OPEN_STATUS']==0){

			$vnd_ikut = $this->input->post('vendor_ikut');
			$harga_vendor = $this->input->post('total');
			$id_ptm = $this->input->post('ptm');

			$arr = $this->prc_auction_detail->delete(array('PAQH_ID' => $this->input->post('paqh_id')));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Auction/simpan_edit','prc_auction_detail','delete',null, array('PAQH_ID' => $this->input->post('paqh_id')));
				//--END LOG DETAIL--//

			$tmp_id = $this->prc_auction_detail->get_id();

			if(!empty($vnd_ikut)){
				foreach ($vnd_ikut as $vnd) {
					$tmp_harga = 0;
					if(!empty($vnd)){
						$data_vendor = array(
							'PAQD_ID' => $tmp_id++,
							'PAQH_ID' => $this->input->post('paqh_id'),
							'PTV_VENDOR_CODE' => $vnd,
							'PAQD_INIT_PRICE' => $harga_vendor[$vnd],
							'PAQD_ITER' => 0,
							'PAQD_FINAL_PRICE' => $harga_vendor[$vnd]
							);
						$this->prc_auction_detail->insert($data_vendor);

							//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Auction/simpan_edit','prc_auction_detail','insert',$data_vendor);
							//--END LOG DETAIL--//
					}

				}
				//penambahan bobot archie//
				foreach ($vnd_ikut as $vnd) {
					$vendor1= $this->prc_tender_quo_item->get_ptm($id_ptm,$vnd);
					$min_harga = $this->prc_auction_detail->get_min_harga($paqhID);
					// echo "<pre>";
					// print_r($min_harga);die;
					foreach ($vendor1 as $nilai) {
						$bobot_teknis = $nilai['PQI_TECH_VAL'] * $data['BOBOT_TEKNIS'] / 100;
						$bobot_harga = $min_harga['MINHARGA'] / $harga_vendor[$vnd] * $data['BOBOT_HARGA'];
						$nilai_gabung = $bobot_teknis + $bobot_harga;
						$data3['NILAI_GABUNG'] = number_format($nilai_gabung,2);
						$where1['PAQH_ID']= $paqhID;
						$where1['PTV_VENDOR_CODE']= $vnd;
						// echo "<pre>";
						// print_r($nilai_gabung);
					}
					// echo "<pre>";
					// print_r($vendor1);
					$this->prc_auction_detail->update($data3, $where1);
				}
						//end penambahan bobot//
			}

			

			$this->prc_tender_item->update(array('PAQH_ID' => NULL,'TIT_STATUS' => 3), array('PTM_NUMBER' => $this->input->post('ptm'),'PAQH_ID' => $this->input->post('paqh_id')));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Auction/simpan_edit','prc_tender_item','update',array('PAQH_ID' => NULL,'TIT_STATUS' => 3), array('PTM_NUMBER' => $this->input->post('ptm'),'PAQH_ID' => $this->input->post('paqh_id')));
				//--END LOG DETAIL--//
			$cek_ikut = $this->input->post('item_ikut');
			if(!empty($cek_ikut)){
				foreach ($this->input->post('tender_item') as $key => $tit) {
					if(!empty($cek_ikut[$tit]))
					{
						$data_item_tender = array(
							'PAQH_ID' => $this->input->post('paqh_id'),
							'TIT_STATUS' => 4
							);
						$this->prc_tender_item->update($data_item_tender, array('TIT_ID' => $tit));
							//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Auction/simpan_edit','prc_tender_item','update',$data_item_tender, array('TIT_ID' => $tit));
							//--END LOG DETAIL--//
					}
				}
			} else {
				$arr = $this->prc_auction_quo_header->delete(array('PAQH_ID' => $this->input->post('paqh_id')));
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Auction/simpan_edit','prc_auction_quo_header','delete',null, array('PAQH_ID' => $this->input->post('paqh_id')));
					//--END LOG DETAIL--//
			}

			$id=$this->input->post('ptm');
			$this->prc_tender_vendor->where_active();
			$vendor= $this->prc_tender_vendor->ptm($id);			
			$ptm=$this->prc_tender_main->ptm($id);		
			foreach ($vendor as $key => $value) {	
				if(in_array($value['VENDOR_NO'], $vnd_ikut)){
					$dataemail=array(
						'EMAIL_ADDRESS'=>$value['EMAIL_ADDRESS'],
						'data'=>array(
							'norfq'=>$value['PTV_RFQ_NO'],
							'noptm'=>$ptm[0]['PTM_PRATENDER'],
							'location'=>$data['PAQH_LOCATION'],
							'openingdate' => date('d M Y H:i:s',strtotime($this->input->post('paqh_auc_start'))),
							'closingdate' => date('d M Y H:i:s',strtotime($this->input->post('paqh_auc_end')))
							)
						);				
					// var_dump($dataemail);die;				
					$this->kirim_email_auction($dataemail);
				}
			}

		}
		redirect('Auction/index/proses');
	}

	/* tampilkan buka auction atau tutup auction */
	public function show($paqh) {
		$this->load->model(array('prc_auction_quo_header', 'prc_tender_item', 'prc_tender_vendor', 'prc_tender_quo_item', 'prc_tender_main', 'prc_auction_detail', 'prc_auction_log'));
		$data['title'] = 'Detail Auction';

		$data_auction = $this->prc_tender_main->join_auction($paqh);
		$this->prc_auction_quo_header->join_ptm();
		$data_paqh = $this->prc_auction_quo_header->get(array('PAQH_ID' => $paqh));
		$data['ptm_number'] = $data_paqh[0]['PTM_NUMBER'];
		$data['paqh'] = $data_paqh[0];
		$data['item'] = $this->prc_tender_item->ptm_paqh($data_paqh[0]['PTM_NUMBER'], $data_paqh[0]['PAQH_ID']);
		// echo "<pre>";
		// print_r($data_paqh);die;

		$datetimestamp = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
		$now = date_format($datetimestamp, 'd-m-Y H.i.s');

		//penambahan bobot ARCHIE//
		if (!empty($data_paqh[0]['BOBOT_TEKNIS'])){
			$vendor = $this->prc_auction_detail->getVendorBobot($data_paqh[0]['PAQH_ID']);
		} else {
			$vendor = $this->prc_auction_detail->getVendor($data_paqh[0]['PAQH_ID']);	
		}
		//end bobot archie//

		$data['vendor'] = $vendor;
		// echo "<pre>";
		// print_r($data['vendor']);
		// die();

		if (!empty($data_paqh[0]['BOBOT_TEKNIS'])){
			$min = $data['vendor'][0]['NILAI_GABUNG'];
		// echo "<pre>";
		// print_r($min);die;
			$minvendor = $data['vendor'][0]['PTV_VENDOR_CODE'];
			for ($i=1; $i < count($data['vendor']) ; $i++) { 
				if(intval($min) < intval($data['vendor'][$i]['NILAI_GABUNG'])){
					$min = $data['vendor'][$i]['NILAI_GABUNG'];
					$minvendor = $data['vendor'][$i]['PTV_VENDOR_CODE'];
				}
			}
		} else {
			$min = $data['vendor'][0]['PAQD_FINAL_PRICE'];
		// echo "<pre>";
		// print_r($min);die;
			$minvendor = $data['vendor'][0]['PTV_VENDOR_CODE'];
			for ($i=1; $i < count($data['vendor']) ; $i++) { 
				if(intval($min) > intval($data['vendor'][$i]['PAQD_FINAL_PRICE'])){
					$min = $data['vendor'][$i]['PAQD_FINAL_PRICE'];
					$minvendor = $data['vendor'][$i]['PTV_VENDOR_CODE'];
				}
			}	
		}

		
		// echo "<pre>";
		// print_r($min);die;

		$data['min'] = $minvendor;
		$this->prc_auction_log->join_vnd();
		$data['log'] = $this->prc_auction_log->paqh($paqh);

		if (isset($data_auction[0])) {			
			// var_dump($data_auction[0]['PAQH_AUC_END'].'|'.oraclestrtotime($data_auction[0]['PAQH_AUC_END'])."|".$now.'|'.strtotime($now));
			// if(oraclestrtotime($data_auction[0]['PAQH_AUC_END']) > strtotime($now)){
			// 	echo 'ok';
			// }else{
			// 	echo 'no';
			// }
			//die;
			if($data_auction[0]['PAQH_OPEN_STATUS']==0){
				$data['status'] = 'belum';
				$this->layout->render('auction_show', $data);
			}
			else if($data_auction[0]['PAQH_OPEN_STATUS']==1 && (oraclestrtotime($data_auction[0]['PAQH_AUC_END']) > strtotime($now))){
				$this->layout->add_js('pages/auction_detail_admin.js');
				$data['status'] = 'proses';
				$this->layout->render('auction_monitor', $data);
			}
			else if ($data_auction[0]['PAQH_OPEN_STATUS']==1 && (oraclestrtotime($data_auction[0]['PAQH_AUC_END']) < strtotime($now))) {
				$this->layout->add_js('pages/auction_detail_admin.js');
				$data['status'] = 'selesai';
				$this->layout->render('auction_close', $data);
			}
		} else {
			$this->layout->render('auction_show', $data);
		}
	}

	/* do open auction */
	public function open() {
		$this->load->model('prc_auction_quo_header');
		$ptm_number = $this->input->post('ptm_number');
		$paqh_id = $this->input->post('paqh_id');
		$set = array(
			'PAQH_OPEN_STATUS' => 1
			);
		$where = array(
			'PTM_NUMBER' => $ptm_number,
			'PAQH_ID' => $paqh_id
			);
		$this->prc_auction_quo_header->update($set, $where);

			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Detail Auction','OPEN',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$set2 = array_merge($set, array('PTM_NUMBER'=>$ptm_number));
		$this->log_data->detail($LM_ID,'Auction/open','prc_auction_quo_header','update',$set2, $where);
			//--END LOG DETAIL--//
		
		redirect('Auction/index/proses');
	}

	public function final_price($paqh_id, $ptm_number) {
		$this->load->model(array(
			'prc_auction_quo_header',
			'prc_auction_detail',
			'prc_tender_pemenang',
			'prc_tender_pemenang_item',
			'prc_tender_vendor',
			'prc_tender_quo_item',
			'prc_tender_item',
			'prc_tender_main',
			'prc_tender_winner',
			));

		$paqh = $this->prc_auction_quo_header->find($paqh_id);

		$items = $this->prc_tender_item->ptm_paqh($ptm_number, $paqh_id);
		foreach ($items as $val) {
			$xitem[$val['TIT_ID']] = $val;
		}

		$paqd = $this->prc_auction_detail->paqh($paqh_id);
		foreach ($paqd as $val) {
			$xpaqd[$val['PTV_VENDOR_CODE']] = $val;
			$xpaqd[$val['PTV_VENDOR_CODE']]['PROSENTASE'] = $val['PAQD_FINAL_PRICE'] / $val['PAQD_INIT_PRICE'];
		}

		$pqi = array();
		foreach ($paqd as $val) {
			foreach ($items as $vall) {
				$this->prc_tender_quo_item->where_tit($vall['TIT_ID']);
				$pqi = array_merge($pqi, $this->prc_tender_quo_item->ptm_ptv($ptm_number, $val['PTV_VENDOR_CODE']));
			}
		}
		foreach ($pqi as $key => $val) {
			$ptv = $val['PTV_VENDOR_CODE'];
			$tit = $val['TIT_ID'];
			// $xpqi[$ptv][$tit] = $val;
			$pqi[$key]['NEW_PRICE'] = $xpaqd[$ptv]['PROSENTASE'] * $val['PQI_PRICE'];
			$wherepqi['PQI_ID'] = $val['PQI_ID'];
			$setpqi['PQI_FINAL_PRICE'] = $pqi[$key]['NEW_PRICE'];
			$this->prc_tender_quo_item->update($setpqi, $wherepqi);
		}

		// var_dump(compact('items', 'xitem', 'paqd', 'xpaqd', 'pqi')); exit();
	}

	/* do close auction */
	public function close(){
		$this->load->model('prc_auction_quo_header');
		$this->load->model('prc_auction_detail');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_nego_hist');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_auction_item');

		$ptm_number = $this->input->post('ptm_number');
		$paqh_id = $this->input->post('paqh_id');
		$vendor = $this->input->post('vendorwinner');
		$breakdown_type = $this->input->post('breakdown_type');

		if(!isset($breakdown_type)||empty($breakdown_type)){
			$this->session->set_flashdata('error', 'Tipe Breakdown Harus Diisi');
			redirect('Auction/show/'.$paqh_id);
		}

		$set = array(
			'PAQH_OPEN_STATUS' => 2,
			'VENDOR_WINNER' => $vendor,
			'BREAKDOWN_TYPE' => $breakdown_type
			);
		$where = array(
			'PTM_NUMBER' => $ptm_number,
			'PAQH_ID' => $paqh_id
			);
		$this->prc_auction_quo_header->update($set, $where);

			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Detail Auction','CLOSE',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Auction/close','prc_auction_quo_header','update',$set,$where);
			//--END LOG DETAIL--//

		/* Ngegugurin yang kalah. PQI vendor dan item yang kalah, 
		 * PQI_IS_WINNER nya diganti jadi -1 ()
		 */
		$pad = $this->prc_auction_detail->paqh($paqh_id);
		foreach ($pad as $val) {
			$valvnd = $val['PTV_VENDOR_CODE'];
			if ($valvnd != $vendor) {
				// ngambil pqm dulu, ptmptv
				$pqm = $this->prc_tender_quo_main->ptmptv($ptm_number, $valvnd);
				$pqm = $pqm[0];

				$aucitem = $this->prc_auction_item->paqh($paqh_id);
				foreach ($aucitem as $itm) {
					$setpqi = array('PQI_IS_WINNER' => -1);
					$wherepqi = array('PQM_ID' => $pqm['PQM_ID'], 'TIT_ID' => $itm['TIT_ID']);
					$this->prc_tender_quo_item->update($setpqi, $wherepqi);
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Auction/close','prc_tender_quo_item','update',$setpqi,$wherepqi);
						//--END LOG DETAIL--//
				}
			}
		}
		//*/

		$newhist['HIST_ID'] = $this->prc_nego_hist->get_id();
		$newhist['NEGOSIASI_ID'] = $this->input->post('paqh_id');
		$newhist['PTM_NUMBER'] = $this->input->post('ptm_number');
		$newhist['NEGOSIASI'] = '2';
		$newhist['CREATED_AT'] = date(timeformat());
		$this->prc_nego_hist->insert($newhist);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Auction/close','prc_nego_hist','insert',$newhist);
			//--END LOG DETAIL--//

		redirect('Auction/index/tutup');
	}

	/* monitor current running auction */
	public function monitor($paqh, $print=false){
		$data['title'] = 'Monitor Auction';

		$this->load->model(array('prc_auction_quo_header', 'prc_tender_item', 'prc_auction_detail','prc_auction_log', 'prc_tender_main'));
		$this->prc_auction_quo_header->join_ptm();
		/*hanya menampilkan data monitor untuk auction yang statusnya masih terbuka (belum tutup)*/
		// $paqh = $this->prc_auction_quo_header->get(array('PAQH_OPEN_STATUS' => 1, 'PAQH_ID'=>$paqh));
		/*menampilkan semua data monitor untuk semua status*/
		$this->prc_auction_log->join_vnd();
		$data['log'] = $this->prc_auction_log->paqh($paqh);
		$paqh = $this->prc_auction_quo_header->id($paqh);
		// echo "<pre>";
		// print_r($paqh);die;
		$data['paqh'] = $paqh[0];
		$data['item'] = $this->prc_tender_item->ptm_paqh($paqh[0]['PTM_NUMBER'], $paqh[0]['PAQH_ID']);

		//penambahan bobot ARCHIE//
		if (!empty($paqh[0]['BOBOT_TEKNIS'])){
			$vendor = $this->prc_auction_detail->getVendorBobot($paqh[0]['PAQH_ID']);
		} else {
			$vendor = $this->prc_auction_detail->getVendor($paqh[0]['PAQH_ID']);	
		}
		//end bobot archie//
		// $vendor = $this->prc_auction_detail->getVendor($paqh[0]['PAQH_ID']);
		$data['vendor'] = $vendor;
		
		
		$datetimestamp = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
		$now = date_format($datetimestamp, 'd-m-Y H.i.s');
		$start = $data['paqh']['PAQH_AUC_START'];
		$end = $data['paqh']['PAQH_AUC_END'];
		$start = strtotime($start);
		$end = strtotime($end);
		$now = strtotime($now);
		if($now < $start){
			$data['status'] = "belum";
		} else if($now > $end){
			if($paqh[0]['IS_BREAKDOWN']==1){
				$data['status'] = "sudah";
			}else{
				$data['status'] = "selesai";	
			}
		} else {
			$data['status'] = "sedang";
		}

		if($print){ 
			$data['ptm'] = $this->prc_tender_main->ptm($paqh[0]['PTM_NUMBER']);
			return $data;
		}

		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/auction_detail_admin.js');
		$this->layout->render('auction_monitor', $data);
	}

	public function get_datatable_stat_null() {
		$this->load->model(array('prc_tender_main'));
		$datatable = $this->prc_tender_main->get_wherehas_titstatus(3);
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	public function get_datatable($status = null) {
		$this->load->model(array('prc_tender_main', 'prc_auction_quo_header', 'prc_tender_vendor'));
		if($status == 'proses' || $status == 'tutup'  || $status == 'all' || $status == 'history'){
			$datatable = $this->prc_auction_quo_header->list_auction($status);
		}
		$data = array('data'=>"");
		if(!empty($datatable)){
			foreach ($datatable as $key => $dtable) {
				if($dtable['PAQH_AUC_START'] != NULL){
					$start = oraclestrtotime($dtable['PAQH_AUC_START']);
					$end = oraclestrtotime($dtable['PAQH_AUC_END']);
					$datatable[$key]['strPAQH_AUC_END'] = betteroracledate($end);
					$datatable[$key]['strPAQH_AUC_START'] = betteroracledate($start);
				}
			}
			$data = array('data' => $datatable);
		}
		echo json_encode($data);
	}

	public function getCurrentPrice($paqh_id) {
		$this->load->model('prc_auction_detail');
		$this->load->model('prc_auction_quo_header');
		$paqd = $this->prc_auction_detail->paqh($paqh_id);
		$paqh = $paqd[0]['PAQH_ID'];
		$bobot = $this->prc_auction_quo_header->get(array('PAQH_ID' => $paqh));
		$paqd['bobot'] = $bobot[0]['BOBOT_TEKNIS'];
		// echo "<pre>";
		// print_r($bobot);die;
		foreach ($paqd as $key => $value) {
			$paqd[$key]['PAQD_INIT_PRICE'] = number_format($value['PAQD_INIT_PRICE']);
			$paqd[$key]['PAQD_FINAL_PRICE'] = number_format($value['PAQD_FINAL_PRICE']);
		}
		echo json_encode(compact('paqd'));
	}

	public function getCurrentTime() {
		date_default_timezone_set('Asia/Jakarta');
		echo json_encode(date('d M Y H:i:s'));
	}

	public function pushCurrentTime(){
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');

		$time = date('d M Y H:i:s');
		echo "data: {$time}\n\n";
		flush();
	}

	public function kirim_email_auction($vendor){	
		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->to($vendor['EMAIL_ADDRESS']);
		$this->email->cc('pengadaan.semenindonesia@gmail.com');

		$opco = $this->session->userdata['COMPANYNAME'];
		$this->email->subject("Undangan Auction dari eProcurement ".$opco." ");

		$content = $this->load->view('email/undangan_auction',$vendor['data'],TRUE);
		$this->email->message($content);
		$this->email->send();
		
		
	}

	public function print_auction($paqh){
		$data = $this->monitor($paqh, $print=true);
		$this->load->helper(array('dompdf', 'file'));
		$html = $this->load->view('cetak_auction', $data, true);
		$filename = 'Auction';
		$paper = 'A4';
		$orientation = 'potrait';
		pdf_create($html, $filename, $paper, $orientation,false);      
	}

}

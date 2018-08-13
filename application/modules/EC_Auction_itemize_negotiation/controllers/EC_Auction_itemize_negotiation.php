<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class EC_Auction_itemize_negotiation extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library('Layout');
		$this -> load -> library('Authorization');
	}

	function index() {
		$this -> load -> model('ec_list_auction_itemize');
		$data['auction'] = $this -> ec_list_auction_itemize -> get_list_auction($this -> session -> userdata['USERID']);
		//print_r($data);exit;
		//print_r($this -> session -> userdata['KODE_VENDOR']);exit;
//        var_dump($this -> session -> userdata);
		$data['title'] = "Auction List";
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_js('plugins/select2/select2.js');
		$this -> layout -> add_css('plugins/select2/select2.css');
		$this -> layout -> add_css('plugins/select2/select2-bootstrap.css');
		$this -> layout -> add_js('pages/EC_auction_itemize_list.js');
		$this -> layout -> render2('list_auction', $data);
	}

	function indexBatch($notender) {
		$this -> load -> model('ec_list_auction_itemize');
		$data['batch'] = $this -> ec_list_auction_itemize -> getBatch($notender);
		$data['title'] = 'Daftar Auction Batch';
		$data['notender'] = $notender;

		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();

		$this -> layout -> add_js('pages/auction_list_stat_null.js');
		$this -> layout -> render('auction_list_batch', $data);

	}

	public function setuju() {
		$this -> load -> model('ec_list_auction_itemize');
		$setuju = $this -> input -> post('setuju');
		$notender = $this -> input -> post('notender');
		$this -> ec_list_auction_itemize -> setuju($notender, $setuju, $this -> session -> userdata['KODE_VENDOR']);
		if ($setuju == 1)
			redirect('EC_Auction_itemize_negotiation/indexBatch/'.$notender);
		else{
			//$this -> index();
			$result = array(
				'success' => true
				);
			echo json_encode($result);
		}
	}

	public function getLog($NO_TENDER,$ID_PESERTA,$ID_ITEM) {
		// $tes = array('no_tender'=>$NO_TENDER,
		// 			 'id_peserta'=>$ID_PESERTA,
		// 			 'id_item'=>$ID_ITEM);
		// echo json_encode($tes);
		$this -> load -> model('ec_auction_itemize_m');
		$data = $this -> ec_auction_itemize_m -> getLog1($NO_TENDER, $ID_PESERTA, $ID_ITEM);
		echo json_encode($data);
		// echo "<pre>";
		// print_r($data);die;
		// if(count($data)>0){
		// 	$hasil = array('status'=>false,
		// 				   'data'=>null);
		// }else{
		// 	$index=0; foreach ($data as $val) { $index++;
		// 		$table_content .= "<tr>";
		// 		$table_content .= "<td>".$index."</td>";
		// 		$table_content .= "</tr>";
		// 	}
		// 	$hasil = array('status'=>true,
		// 				   'data'=>$data);
		// }
		// echo json_encode($this->db->last_query());
		// echo json_encode(array('tes'=>"asfegehryteqw"));
	}

	function detail_auction($no_tender = '', $nobatch) {
		$this -> load -> model('ec_list_auction_itemize');
		$data['nobatch'] = $nobatch;
		$data['Detail_Auction'] = $this -> ec_list_auction_itemize -> get_Auction($no_tender, $nobatch);
		$data['auction'] = $this -> ec_list_auction_itemize -> get_detail_auction($no_tender, $nobatch);
		// print_r($data['auction']);die;
		$data['ketBatch'] = $this -> ec_list_auction_itemize -> getBatchDetail($no_tender, $nobatch);
		// $data['itemBatch'] = $this -> ec_list_auction_itemize -> getBatchDetailItem($notender, $data['ketBatch'][0]['ITEM']);
		$data['item'] = $this -> ec_list_auction_itemize -> get_Itemlist($no_tender);
		$data['vendor'] = $this -> ec_list_auction_itemize -> get_vendor($no_tender, $this -> session -> userdata['KODE_VENDOR']);
		$data['curr'] = $this -> ec_list_auction_itemize -> getPesertaId($no_tender, $this -> session -> userdata['KODE_VENDOR']);
		$data['title'] = "Auction Negotiation Detail";
		$data['tanggal'] = date("Y/m/d H:i:s");
		$data['tanggal2'] = date("d/m/Y H:i:s");
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();

		//gawe swal
		$this -> layout -> add_js('plugins/select2/select2.js');
		$this -> layout -> add_css('plugins/select2/select2.css');
		$this -> layout -> add_css('plugins/select2/select2-bootstrap.css');

		$this -> layout -> add_js('pages/EC_flipclock.min.js');
		$this -> layout -> add_js('jquery.checkboxes-1.2.0.js');
		$this -> layout -> add_js('jquery.checkboxes-1.2.0.min.js');
		$this -> layout -> add_css('pages/EC_flipclock.css');
		$this -> layout -> add_css('pages/EC_auction_itemize.css');
		$this -> layout -> add_js('pages/EC_detail_auction_itemize.js');
		$this -> layout -> render('detail_auction', $data);
	}

	public function get_data($NO_TENDER, $NO_BATCH) {
		header('Content-Type: application/json');
		$this -> load -> model('ec_auction_itemize_m');
		// $venno = $this -> session -> userdata['VENDOR_NO'];
		$ketBatch = $this -> ec_auction_itemize_m -> getBatchDetail($NO_TENDER, $NO_BATCH);
		$dataItem = $this -> ec_auction_itemize_m -> getBatchDetailItem($NO_TENDER, $ketBatch[0]['ITEM']);
		// $dataa = $this -> EC_strategic_material_m -> get();
		// print_r($dataItem);die;
		$i = 1;
		$data_tabel = array();
		foreach ($dataItem as $value) {
			$ambilQty = $this->ec_auction_itemize_m->getDetailVendor($this->session->userdata['USERID'], $value['ID_ITEM'], $NO_TENDER);
			// print_r($ambilQty);die;
			if($ambilQty[0]['HARGA'] > 0){
				$data[0] = $i++;
				$data[1] = $value['NAMA_BARANG'];
				$data[2] = $ambilQty[0]['HARGA'] = !null ? $ambilQty[0]['HARGA'] : "";
				$data[3] = $ambilQty[0]['HARGATERKINI'] = !null ? $ambilQty[0]['HARGATERKINI'] : "";
				$data[4] = $ambilQty[0]['HARGATERKINI'] = !null ? $ambilQty[0]['HARGATERKINI'] : "";
				$data[5] = $value['ID_ITEM'] = !null ? $value['ID_ITEM'] : "";
				$data[6] = $ambilQty[0]['CURRENCY'];
				$data[7] = $value['UNIT'];
				$data[8] = '<div style=" visibility: hidden;">'.$ambilQty[0]['RANKING'].'</div>';
				if($ambilQty[0]['RANKING']==1){ //jika juara 1
					$data[9] = '<img src="'.base_url().'upload/EC_auction/piala.gif'.'" width="50" height="50">';
				} else { //tidak juara 1
					$data[9] = '';
				}
				$data[10] = $ambilQty[0]['MERK'];
				$data[11] = $value['KODE_BARANG'];

				$data[12] = "";
				if($ambilQty[0]['MERK']!=""){
					//echo "masuk";
					$NEW_NO_BATCH = intval($NO_BATCH)-1;
					for($i=$NEW_NO_BATCH;$i>0;$i--){
						$ketBatch1 = $this -> ec_auction_itemize_m -> getBatchDetail($NO_TENDER, $NEW_NO_BATCH);
						$dataItem1 = $this -> ec_auction_itemize_m -> getBatchDetailItemMerk($NO_TENDER, $ketBatch1[0]['ITEM'], $this->session->userdata['USERID'], $ambilQty[0]['MERK']);
						// print_r($dataItem1);die;
						if(count($dataItem1)>0){
							$data[12] = "ADA";
							break;
						} else {
						}
					}
					 
				} else {
					//echo "tidak";
				}
				$data[13] = $ambilQty[0]['KONVERSI_IDR_UBAH'] = !null ? $ambilQty[0]['KONVERSI_IDR_UBAH'] : "";
				$data[14] = $ambilQty[0]['ID_PESERTA'] = !null ? $ambilQty[0]['ID_PESERTA'] : "";
				
				// $data[5] = $value['MTART'] = !null ? $value['MTART'] : "";
				// $data[7] = $value['STATUS'];
				// $data[6] = $data[7] != ("0") ? "Material Strategis" : "-";
				// $data[8] = $value['ID_CAT'] != null ? $value['DESC'] : "-";
				// $data[9] = $value['TAG'] != null ? $value['TAG'] : "-";
				$data_tabel[] = $data;
			}
		}
		$json_data = /*$data_tabel;*/
		array('data' => $data_tabel);
		echo json_encode($json_data);
	}

	public function getTimeServer() {
		echo json_encode(date("Y/m/d H:i:s"));
	}

	function piala($no_tender = '') {
		$this -> load -> model('ec_list_auction_itemize');
		$data = $this -> ec_list_auction_itemize -> get_min_bid($no_tender);
		// echo "<pre>";
		// print_r($data);die;
		// var_dump($this -> session -> userdata);
		if ($data['KODE_VENDOR'] == $this -> session -> userdata['KODE_VENDOR']) {
			echo json_encode(TRUE);
		} else
		echo json_encode(FALSE);
	}

	function getPialaItemize($no_tender = '', $no_batch = '') {
		
		$this -> load -> model('ec_list_auction_itemize');
		$this -> load -> model('ec_auction_itemize_m');
		
		$ketBatch = $this -> ec_auction_itemize_m -> getBatchDetail($no_tender, $no_batch);
		$dataItem = $this -> ec_auction_itemize_m -> getBatchDetailItem($no_tender, $ketBatch[0]['ITEM']);
		//$dataRanking = $this -> ec_list_auction_itemize -> getRanking1($no_tender, $ketBatch[0]['ITEM'], $this -> session -> userdata['KODE_VENDOR']);
		$totalPiala = 0;
		foreach ($dataItem as $value) {
			$data = $this -> ec_list_auction_itemize -> get_min_bid_itemize_coba2($no_tender, $value['ID_ITEM']);
			//print_r($data);
			if(count($data) == 1){
			//echo "if pertama";
				if ($data[0]['ID_PESERTA'] == $this -> session -> userdata['KODE_VENDOR']) {
					$checkHPS = $this -> ec_list_auction_itemize -> get_harga_barang($no_tender, $value['ID_ITEM']);
					$auction = $this -> ec_list_auction_itemize -> get_detail_auction2($no_tender, $no_batch);
					$dateserver = date("Y-m-d H:i:s");
					$dateauction = date("Y-m-d H:i:s", strtotime($auction['PENUTUPAN']));
					$dateauction2 = date("Y-m-d H:i:s", strtotime($auction['PEMBUKAAN']));
					$d1 = strtotime($dateserver);
					$d2 = strtotime($dateauction);
					$d3 = strtotime($dateauction2);
						//echo "aaaaa".$auction['PENUTUPAN'];
					if($data[0]['BM_HB'] <= $checkHPS['HPS']){
						$totalPiala = $totalPiala + 1;
					} else if(!empty($auction['PENUTUPAN'])){
						if($d1 >= $d2){ //waktu sudah habis
							$totalPiala = $totalPiala + 1;
						} else { //waktu habis
						}
					} else {
					}
				}
			} else {
				if ($data[0]['ID_PESERTA'] == $this -> session -> userdata['KODE_VENDOR']) {
				//echo "masuk sini if";
					$totalPiala = $totalPiala + 1;
				} else {
				//echo "masuk sini else";
				}
			}
		}

		$result = array(
			'piala_gmbr' => base_url().'upload/EC_auction/piala.gif',
			'RANKING' => $totalPiala
			);

		echo json_encode($result);
	}

	function pialaItemize($no_tender = '', $no_batch = '') {

		$this -> load -> model('ec_list_auction_itemize');
		$this -> load -> model('ec_auction_itemize_m');

		$ketBatch = $this -> ec_auction_itemize_m -> getBatchDetail($no_tender, $no_batch);
		$dataItem = $this -> ec_auction_itemize_m -> getBatchDetailItem($no_tender, $ketBatch[0]['ITEM']);

		foreach ($dataItem as $value) {
			//$ambilQty = $this->ec_auction_itemize_m->getDetailVendor($this->session->userdata['USERID'], $value['ID_ITEM'], $NO_TENDER);
			$data = $this -> ec_list_auction_itemize -> get_min_bid_itemize_coba2($no_tender, $value['ID_ITEM']);
			// echo count($data);
			// print_r($data);
			// die;
			if(count($data) == 1){
				$checkHPS = $this -> ec_list_auction_itemize -> get_harga_barang($no_tender, $value['ID_ITEM']);
				//print_r($checkHPS);
				$auction = $this -> ec_list_auction_itemize -> get_detail_auction2($no_tender, $no_batch);
				$dateserver = date("Y-m-d H:i:s");
				$dateauction = date("Y-m-d H:i:s", strtotime($auction['PENUTUPAN']));
				$dateauction2 = date("Y-m-d H:i:s", strtotime($auction['PEMBUKAAN']));
				$d1 = strtotime($dateserver);
				$d2 = strtotime($dateauction);
				$d3 = strtotime($dateauction2);
				//echo "aaaaa".$auction['PENUTUPAN'];
				//$data[0]['HARGATERKINI'] DIGANTI $data[0]['KONVERSI_IDR_UBAH']
				if($data[0]['BM_HB'] <= $checkHPS['HPS']){
					$result[] = array(
						'ID_ITEM' => $value['ID_ITEM'],
						'CURR' => $data[0]['CURRENCY'],
						'piala' => TRUE,
						'piala_gmbr' => base_url().'upload/EC_auction/piala.gif',
						'HARGAAKHIR' => $data[0]['HARGATERKINI'],
						'HARGATERKINI' => $data[0]['HARGATERKINI'],
						'RANKING' => '<div style=" visibility: hidden;">'.$data[0]['RANKING'].'</div>'
						);
				} else if(!empty($auction['PENUTUPAN'])){
					if($d1 >= $d2){ //waktu sudah habis
						$result[] = array(
							'ID_ITEM' => $value['ID_ITEM'],
							'CURR' => $data[0]['CURRENCY'],
							'piala' => TRUE,
							'piala_gmbr' => base_url().'upload/EC_auction/piala.gif',
							'HARGAAKHIR' => $data[0]['HARGATERKINI'],
							'HARGATERKINI' => $data[0]['HARGATERKINI'],
							'RANKING' => '<div style=" visibility: hidden;">'.$data[0]['RANKING'].'</div>'
							);
					} else { //waktu habis
						$result[] = array(
							'ID_ITEM' => $value['ID_ITEM'],
							'CURR' => $data[0]['CURRENCY'],
							'piala' => FALSE,
							'piala_gmbr' => '',
							'HARGAAKHIR' => $data[0]['HARGATERKINI'],
							'HARGATERKINI' => $data[0]['HARGATERKINI'],
							'RANKING' => '<div style=" visibility: hidden;">'.$data[0]['RANKING'].'</div>'
							);
					}
				} else {
					$result[] = array(
						'ID_ITEM' => $value['ID_ITEM'],
						'CURR' => $data[0]['CURRENCY'],
						'piala' => FALSE,
						'piala_gmbr' => '',
						'HARGAAKHIR' => $data[0]['HARGATERKINI'],
						'HARGATERKINI' => $data[0]['HARGATERKINI'],
						'RANKING' => '<div style=" visibility: hidden;">'.$data[0]['RANKING'].'</div>'
						);
				}
			} else {
				if ($data[0]['ID_PESERTA'] == $this -> session -> userdata['KODE_VENDOR']) {
					$result[] = array(
						'ID_ITEM' => $value['ID_ITEM'],
						'CURR' => $data[0]['CURRENCY'],
						'piala' => TRUE,
						'piala_gmbr' => base_url().'upload/EC_auction/piala.gif',
						'HARGAAKHIR' => $data[0]['HARGATERKINI'],
						'HARGATERKINI' => $data[0]['HARGATERKINI'],
						'RANKING' => '<div style=" visibility: hidden;">'.$data[0]['RANKING'].'</div>'
						);
					//echo json_encode(TRUE);
				} else {
					$dataGakMenang = $this -> ec_list_auction_itemize -> get_min_bid_itemize_gak_menang($no_tender, $value['ID_ITEM'], $this -> session -> userdata['KODE_VENDOR']);
					//print_r($dataGakMenang);
					$result[] = array(
						'ID_ITEM' => $value['ID_ITEM'],
						'CURR' => $dataGakMenang['CURRENCY'],
						'piala' => FALSE,
						'piala_gmbr' => '',
						'HARGAAKHIR' => $data[0]['HARGATERKINI'],
						'HARGATERKINI' => $dataGakMenang['HARGATERKINI'],
						'RANKING' => '<div style=" visibility: hidden;">'.$dataGakMenang['RANKING'].'</div>'
						);
					//echo json_encode(FALSE);
				}
			}
		}
		//print_r($result);die;
		echo json_encode($result);
		// var_dump($this -> session -> userdata);		
	}

	// $d1 = new DateTime('2008-08-03 14:52:10');
	// $d2 = new DateTime('2008-01-03 11:11:10');
	// var_dump($d1 == $d2);
	// var_dump($d1 > $d2);
	// var_dump($d1 < $d2);
	function bid() {
		$vals = $this -> input -> post('vals');
		$hargas = $this -> input -> post('hargas');
		$merks = $this -> input -> post('merks');
		$NO_TENDER = $this -> input -> post('NO_TENDER');
		$NO_BATCH = $this -> input -> post('NO_BATCH');

		$this -> load -> model('ec_list_auction_itemize');
		$this -> load -> model('ec_auction_itemize_m');

		$auction = $this -> ec_list_auction_itemize -> get_detail_auction2($NO_TENDER, $NO_BATCH);
		// print_r($auction['TIPE_RANKING']);
		// die;
		$dateserver = date("Y-m-d H:i:s");
		$dateauction = date("Y-m-d H:i:s", strtotime($auction['PENUTUPAN']));
		$dateauction2 = date("Y-m-d H:i:s", strtotime($auction['PEMBUKAAN']));
		// $d1 = new DateTime($dateserver);
		// $d2 = new DateTime(strtotime($dateauction));
		// $d3 = new DateTime(strtotime($dateauction2));
		$d1 = strtotime($dateserver);
		$d2 = strtotime($dateauction);
		$d3 = strtotime($dateauction2);

		// echo $d1."<br>";
		// echo $d2."<br>";
		// echo $d3."<br>";


		//batas waktu
		$data = "";
		$data0 = "";
		if ($d1 < $d2 && $d1 > $d3) {
			if(!empty($vals)){
				$newVals   = explode(',',$vals);
			}

			if(!empty($hargas)){
				$newHargas   = explode(',',$hargas);
			}

			if(!empty($merks)){
				$newMerks   = explode(',',$merks);
			}

			// print_r($newVals);
			// print_r($newHargas);
			// echo $newVals[0];
			// echo $newVals[1];
			// echo count($vals);
			// die;
			
			if (strpos($vals, ',') != false) { //ada koma
				for ($i=0; $i < count($newVals); $i++) {
					if($newHargas[$i]>0){
						$ambilQty = $this->ec_auction_itemize_m->getDetailVendor($this->session->userdata['USERID'], $newVals[$i], $NO_TENDER);
						$CURRENCY = $ambilQty[0]['CURRENCY'];
						$HARGA_BARANG = $newHargas[$i];
						if($CURRENCY == "IDR"){
							$KONVERSI = 1;
							$KEIDR = $HARGA_BARANG;
							$BM_HB = $KEIDR;
						} else {
							$checkCurr = $this->ec_auction_itemize_m->getCurrency($CURRENCY, 'IDR');
							$KONVERSI = $checkCurr[0]['KONVERSI'];
							$KEIDR = $HARGA_BARANG * $checkCurr[0]['KONVERSI'];
							$BEA_MASUK = $ambilQty[0]['BEA_MASUK'];
							$BM_HB = (($BEA_MASUK / 100) * $KEIDR) + $KEIDR;
						}

						//JIKA MERK KOSONG TIDAK UPDATE
						if($newMerks[$i]!=""){
							//UPDATE DENGAN MERK YANG SAMA
							$where_edit['ID_PESERTA'] 	= $this -> session -> userdata['KODE_VENDOR'];
							$where_edit['ID_HEADER'] 	= $NO_TENDER;
							$where_edit['MERK'] 		= $newMerks[$i];
							$set_edit['HARGATERKINI'] 	= $newHargas[$i];
							$set_edit['KONVERSI_IDR_UBAH'] 	= $KEIDR;
							$set_edit['BM_HB'] 			= $BM_HB;
							$result 					= $this->ec_auction_itemize_m->updateItemPrice($set_edit, $where_edit);
						}

						$data = $this -> ec_list_auction_itemize -> bid($this -> session -> userdata['KODE_VENDOR'], $NO_TENDER, $newVals[$i], $newHargas[$i], $KEIDR, $BM_HB, $auction);
					} else {
						$data0 .= $newVals[$i];
					}
				}
			} else {
				if($hargas>0){
					//print_r($newVals);
					$ambilQty = $this->ec_auction_itemize_m->getDetailVendor($this->session->userdata['USERID'], $vals, $NO_TENDER);
					//print_r($ambilQty);die;
					$CURRENCY = $ambilQty[0]['CURRENCY'];
					$HARGA_BARANG = $hargas;
					if($CURRENCY == "IDR"){
						$KONVERSI = 1;
						$KEIDR = $HARGA_BARANG;
						$BM_HB = $HARGA_BARANG;
					} else {
						$checkCurr = $this->ec_auction_itemize_m->getCurrency($CURRENCY, 'IDR');
						$KONVERSI = $checkCurr[0]['KONVERSI'];
						$KEIDR = $HARGA_BARANG * $checkCurr[0]['KONVERSI'];
						$BEA_MASUK = $ambilQty[0]['BEA_MASUK'];
						$BM_HB = (($BEA_MASUK / 100) * $KEIDR) + $KEIDR;
					}

					//JIKA MERK KOSONG TIDAK UPDATE
					if($merks!=""){
						//UPDATE DENGAN MERK YANG SAMA
						$where_edit['ID_PESERTA'] 	= $this -> session -> userdata['KODE_VENDOR'];
						$where_edit['ID_HEADER'] 	= $NO_TENDER;
						$where_edit['MERK'] 		= $merks;
						$set_edit['HARGATERKINI'] 	= $hargas;
						$set_edit['KONVERSI_IDR_UBAH'] 	= $KEIDR;
						$set_edit['BM_HB'] 			= $BM_HB;
						$result 					= $this->ec_auction_itemize_m->updateItemPrice($set_edit, $where_edit);
					}

					$data = $this -> ec_list_auction_itemize -> bid($this -> session -> userdata['KODE_VENDOR'], $NO_TENDER, $vals, $hargas, $KEIDR, $BM_HB, $auction);
				} else {
					$data0 .= $vals;
				}
			}

			$result = array(
				'data' => $data,
				'data0' => $data0
				);
			echo json_encode($result);
		} else {
			$result = array(
				'data' => $data,
				'data0' => $data0
				);
			echo json_encode($result);
		}
	}

	function test($value = '') {
		$this -> load -> model('ec_list_auction_itemize');
		$data = $this -> ec_list_auction_itemize -> test();
		var_dump($data);
	}

}

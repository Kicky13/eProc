<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  -== Snippet ==-
 * Ini bukan cuma nampung snippet html, tapi juga fungsi fungsi
 * kecil jika banyak controller yg butuh. Bingung mau taruh mana lagi.
 * Lha model ga boleh diisi fungsi buat panggil model lain sih.
 *
 * Update 14-Jan-2016
 * tetep harus snippet html tok disini. hush!
 */
class Snippet {

	public function __construct() {
		$this->ci = &get_instance();
		$this->ci->load->library('Authorization');
	}

	/**
	 * Nampilin detail ptm meliputi
	 *  Detail pengadaan
	 *  Item pengadaan
	 *  Vendor
	 *
	 * @param int ptm_number
	 * @param boolean include_vendor
	 * @param boolean for_vendor
	 * @param boolean withitem
	 * @param String RFQ No
	 * @return string html snippet
	 */
	public function detail_ptm($id, $include_vendor = true, $for_vendor = false, $withitem = true, $rfq = null, $retender = true) {
		$this->ci->load->model('adm_doctype_pengadaan');
		$this->ci->load->model('adm_cctr');
		$this->ci->load->model('adm_employee');
		$this->ci->load->model('app_process_master');
		$this->ci->load->model('prc_approve_tender');
		$this->ci->load->model('prc_tender_approve');
		$this->ci->load->model('prc_tender_item');
		$this->ci->load->model('prc_tender_main');
		$this->ci->load->model('prc_tender_prep');
		$this->ci->load->model('prc_tender_vendor');
		$this->ci->load->model('retender_item');

		$ans = '';
		$data = array();
		$data['for_vendor'] = $for_vendor;
		$data['rfq'] = $rfq;

		$this->ci->prc_tender_main->join_prep();
		$temp = $this->ci->prc_tender_main->ptm($id);
		$dateNew = date('Y-m-d H:i:s');	
		//nyo 22022017
		if($temp[0]['MASTER_ID']=='6'){
			if(strtotime($temp[0]['PTP_REG_CLOSING_DATE']) < strtotime($dateNew)){
				$temp[0]['PROCESS_NAME'] = 'Verifikasi Penawaran';
			}
		}
		if($temp[0]['MASTER_ID']=='12'){
			if(strtotime($temp[0]['BATAS_VENDOR_HARGA_VER']) > strtotime($dateNew)){
				$temp[0]['PROCESS_NAME'] = 'Kirim Penawaran Harga';
			}
		}
		if($temp[0]['MASTER_ID']==15){
			$temp[0]['PROCESS_NAME'] = $this->statusNego($id);
		}

			//rg 08062016 //nyo 22022017(edit)
		if ($temp[0]['PTM_COMPANY_ID'] == '4000') {
			if ($temp[0]['PTM_STATUS'] <= -1 && $temp[0]['PTM_STATUS'] >= -8){
				$temp[0]['PROCESS_NAME'] =  'Reject';
			}
			if($temp[0]['PTM_STATUS'] <= -9){
				$temp[0]['PROCESS_NAME'] =  'Retender';
			} 
		} else {
			if ($temp[0]['PTM_STATUS'] <= -1 && $temp[0]['PTM_STATUS'] >= -7){
				$temp[0]['PROCESS_NAME'] =  'Reject';
			}
			if($temp[0]['PTM_STATUS'] <= -8){
				$temp[0]['PROCESS_NAME'] =  'Retender';
			} 
		}
		
		$data['ptm_detail'] = $temp[0];

		$data['doctype'] = $this->ci->adm_doctype_pengadaan->find($data['ptm_detail']['PTM_RFQ_TYPE'],$data['ptm_detail']['PTM_PGRP']);

		$this->ci->adm_cctr->where_kel_com($data['ptm_detail']['KEL_PLANT_PRO']);
		$cctr = $this->ci->adm_cctr->get();
		$data['cctr'] = array_build_key($cctr, 'CCTR');

		$this->ci->prc_tender_prep->join_eval_template();
		$data['ptp'] = $this->ci->prc_tender_prep->ptm($id);

		$data['buyer'] = $this->ci->adm_employee->find($data['ptm_detail']['PTM_ASSIGNMENT']);

		if ($withitem){
			$data['detail_item_ptm'] = $this->detail_item_ptm($id);
			if($retender){
				$data['retender_item'] = $this->retender_item($id);
			}
			$data['batal_item'] = $this->batal_item($id);
		}

		$this->ci->prc_tender_item->join_pr();
		$data['tit'] = $this->ci->prc_tender_item->ptm($id);

		$ans .= $this->ci->load->view('snippets/detail_ptm', $data, true);

		// var_dump($data); exit();
		return $ans;
	}

	public function statusNego($id){
		$rg=array();
		$pti = $this->ci->prc_tender_item->ptm($id);
		foreach ($pti as $val) {
			$stts = $val['TIT_STATUS'];
			$status = $stts;
			if($stts==0 || $stts==1 || $stts==2 || $stts==3 || $stts==4 || $stts==5 || $stts==7 || $stts==16 || $stts==48 || $stts==96 || $stts==112){
				if($stts==7){
					foreach ($pti as $va1) {
						$status = 'Tahap Negosiasi';
						$stts1 = $va1['TIT_STATUS'];
						if($stts1!=0 && $stts1!=1 && $stts1!=2 && $stts1!=3 && $stts1!=4 && $stts1!=5 && $stts1!=16 && $stts1!=48 && $stts1!=96 && $stts1!=112){
							$status = 'Evaluasi ECE';						
						}
					}
					return $status;
				}
				return 'Tahap Negosiasi';

			}else if($stts==6){
				$st2=true;
				foreach ($pti as $va2) {
					$stts2 = $va2['TIT_STATUS'];
					if($stts2==0 || $stts2==1 || $stts2==2 || $stts2==3 || $stts2==4 || $stts2==5 || $stts2==7 || $stts2==16 || $stts2==48 || $stts2==96 || $stts2==112){
						$st2 = false;
					}
				}
				if($st2){
					return 'Penunjukan Pemenang';                
				}

			}else if($stts==8){
				$st3=true;
				foreach ($pti as $va3) {
					$stts3 = $va3['TIT_STATUS'];
					if($stts3==0 || $stts3==1 || $stts3==2 || $stts3==3 || $stts3==4 || $stts3==5 || $stts3==7 || $stts3==16 || $stts3==48 || $stts3==96 || $stts3==112 || $stts3==6){
						$st3 = false;
					}
				}
				if($st3){
					return 'Pembuatan LP3';                
				}

			}else if($stts==9){
				$st4=true;
				foreach ($pti as $va4) {
					$stts4 = $va4['TIT_STATUS'];
					if($stts4==0 || $stts4==1 || $stts4==2 || $stts4==3 || $stts4==4 || $stts4==5 || $stts4==7 || $stts4==16 || $stts4==48 || $stts4==96 || $stts4==112 || $stts4==6 || $stts4==8){
						$st4 = false;
					}
				}
				if($st4){
					return 'Approval LP3';                
				}

			}else if($stts==10){
				$st5=true;
				foreach ($pti as $va5) {
					$stts5 = $va5['TIT_STATUS'];
					if($stts5==0 || $stts5==1 || $stts5==2 || $stts5==3 || $stts5==4 || $stts5==5 || $stts5==7 || $stts5==16 || $stts5==48 || $stts5==96 || $stts5==112 || $stts5==6 || $stts5==8 || $stts5==9){
						$st5 = false;
					}
				}
				if($st5){
					return 'PO Release';                
				}
			}
		}
		return $stts;
	}

	// // public function sort_item($a, $b) {
	// 	return ($a["PPI_PRITEM"] > $b["PPI_PRITEM"]);
	// }

	public function detail_item_ptm($id, $for_vendor=false, $reject_konfigurasi=false, $for_update_qty=false) {
		$this->ci->load->model('adm_plant');
		$this->ci->load->model('prc_tender_item');
		$this->ci->load->model('prc_tender_main');
		$this->ci->load->model('prc_pr_item');

		$ans = '';
		$data = array();

		$ptm = $this->ci->prc_tender_main->ptm($id);
		$ptm = $ptm[0];

		$data['for_vendor'] = $for_vendor;
		$data['for_update_qty'] = $for_update_qty;
		$plant_master = $this->ci->adm_plant->get();
		foreach ($plant_master as $val) {
			$data['plant_master'][$val['PLANT_CODE']] = $val;
		}
		
		// if ($ptm['IS_JASA'] == 1) {
		// 	$this->ci->prc_tender_item->join_pr(true);
		// } else {
		$this->ci->prc_tender_item->join_pr();
		// }
		$data['tit'] = $this->ci->prc_tender_item->get(array('PTM_NUMBER'=>$id,'TIT_STATUS <>'=>999));
		$arr_ppi = array();
		foreach ($data['tit'] as $val){
			$ppi = $this->ci->prc_pr_item->where_ppiId($val['PPI_ID']);
			$arr_ppi[$ppi[0]['PPI_ID']] = $ppi[0]['COUNT_TENDER'];
			$data['ct'][$val['PPI_ID']] = $this->countTender($id,$val['PPI_ID']);
		}
		$data['ppi']=$arr_ppi;

		$data['is_jasa']=$ptm['IS_JASA'];

		// var_dump($data['tit']); die();
		// usort($data['tit'], array($this, "sort_item"));

		if($reject_konfigurasi){
			return $data;
		}

		$ans .= $this->ci->load->view('snippets/detail_item_ptm', $data, true);

		return $ans;
	}

	public function retender_item($id){
		$this->ci->retender_item->join_pr();
		$data['tit'] = $this->ci->retender_item->ptm($id);
		foreach ($data['tit'] as $va) {
			$data['ct'][$va['PPI_ID']] = $this->countTender($id,$va['PPI_ID']);
		}
		$ans = $this->ci->load->view('snippets/item_retender',$data,true);
		return $ans;
	}

	public function batal_item($id){
		$this->ci->load->model('prc_tender_item');
		$this->ci->prc_tender_item->join_pr();
		$data['tit'] = $this->ci->prc_tender_item->get(array('PTM_NUMBER'=>$id,'TIT_STATUS'=>999));
		foreach ($data['tit'] as $va) {
			$data['ct'][$va['PPI_ID']] = $this->countTender($id,$va['PPI_ID']);
		}
		$ans = $this->ci->load->view('snippets/item_batal',$data,true);
		return $ans;
	}

	/**
	 * Nampilin vendor ptm meliputi
	 *  Detail pengadaan
	 *  Item pengadaan
	 *  Vendor
	 *
	 * @param int ptm_number
	 * @return string html snippet
	 */
	public function vendor_ptm($id, $show_detail = true, $show_harga = false, $whatever = null) {
		$this->ci->load->model('prc_tender_main');
		$this->ci->load->model('prc_tender_vendor');
		$this->ci->load->model('prc_tender_prep');

		$ans = '';
		$data = array();
		$data['ptm_number'] = $id;
		$data['show_detail'] = $show_detail;
		$data['show_harga'] = $show_harga;

		$data['ptp'] = $this->ci->prc_tender_prep->ptm($id);
		$data['ptm'] = $this->ci->prc_tender_main->ptm($id);
		$data['ptv'] = $this->ci->prc_tender_vendor->get_join(array('PTM_NUMBER' => $id));
		$ans .= $this->ci->load->view('snippets/vendor_ptm', $data, true);

		return $ans;
	}

	/**
	 * Nampilin dokumen ptm meliputi
	 *  Dokumen pengadaan tiap item
	 *
	 * @param int ptm_number
	 * @return string html snippet
	 */
	public function dokumen_pr($id, $privacy = null, $vendor = false, $active = true, $whatever = null) {
		$this->ci->load->model('prc_tender_main');
		$this->ci->load->model('prc_tender_item');
		$this->ci->load->model('prc_plan_doc');
		$this->ci->load->model('prc_pr_item');
		$this->ci->load->model('prc_add_item');

		$this->ci->load->model('po_header');

		$ans = '';
		$data = array();
		$dokumen = array();
		$dokumens = array();
		$privacy = null;
		$active = true;

		$this->ci->prc_tender_item->join_pr();
		$dokumen['items'] = $this->ci->prc_tender_item->ptm($id);
		$dokumen['itemdoc'] = array();
		foreach ($dokumen['items'] as $key => $val) {
			$dokumens[$val['PPI_ID']] = $val;
			if ($privacy !== null) {
				$this->ci->prc_plan_doc->where_privacy($privacy);
			}
			if ($active) {
				$this->ci->prc_plan_doc->where_active();
			}
			$docs = $this->ci->prc_plan_doc->pritem($val['PPI_ID']);
			$dokumen['itemdoc'][$val['PPI_ID']] = $docs;
		}

		$newdoc = array();
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
						$newdoc[$index]['item'][] = $temp;
						$sama = true;
						break;
					}	
				}
				if($sama == false){
					$doknames[] = $val['PPD_FILE_NAME'];
					$newdoc[$count]['nama'] = $val['PPD_FILE_NAME'];
					$newdoc[$count]['PDC_NAME'] = $val['PDC_NAME'];
					$newdoc[$count]['IS_SHARE'] = $val['IS_SHARE'];
					$newdoc[$count]['PDC_IS_PRIVATE'] = $val['PDC_IS_PRIVATE'];
					$newdoc[$count]['PPD_DESCRIPTION'] = $val['PPD_DESCRIPTION'];
					$newdoc[$count]['item'][0]['DECMAT'] = $dokumens[$ppi_id]['PPI_DECMAT'];
					$newdoc[$count]['item'][0]['NOMAT'] =  $dokumens[$ppi_id]['PPI_NOMAT'];
					$count = $count + 1;
				}
			}
		}
		$data['newdoc'] = $newdoc;

		$this->ci->prc_add_item->where_ptm($id);
		$data['dokumentambahan'] = $this->ci->prc_add_item->get();

		$data['dokumentambahan_aanwijing'] = $this->ci->prc_tender_main->ptm($id);

		$data['dokumentambahan_docpo'] = $this->ci->po_header->ptm($id);

		// echo "<pre>";
		// print_r($data);die;
		$data['vendor'] = $vendor;

		$ans .= $this->ci->load->view('snippets/dokumen_pr', $data, true);
		return $ans;
	}

	/**
	 * Nampilin detail pr meliputi
	 *  Item pengadaan
	 *
	 * @param int pr_no
	 * @return string html snippet
	 */
	public function dokumen_by_pr($id, $privacy = null, $vendor = false, $active = true, $whatever = null) {
		$this->ci->load->model('prc_plan_doc');
		$this->ci->load->model('prc_pr_item');

		$ans = '';
		$data = array();

		// var_dump($id); exit();
		$this->ci->prc_pr_item->where_id($id);
		$data['items'] = $this->ci->prc_pr_item->get();

		if ($privacy !== null) {
			$this->ci->prc_plan_doc->where_privacy($privacy);
		}
		if ($active) {
			$this->ci->prc_plan_doc->where_active();
		}
		$data['itemdoc'][$id] = $this->ci->prc_plan_doc->pritem($id);

		$data['vendor'] = $vendor;

		// var_dump($data); exit();

		$ans .= $this->ci->load->view('snippets/dokumen_by_pr', $data, true);
		return $ans;
	}

	/**
	 * Nampilin evaluasi ptm
	 *
	 * @param int ptm_number
	 * @param boolean bisa sebagai input
	 * @param boolean ngeliatin harga penawarannya juga
	 * @param boolean hanya yang terpilih lolos evaluasi
	 * @param boolean input, tapi yg ga lulus evatek aja yang di-disabled
	 * @param boolean populate checkbox yang DAPAT_UNDANGAN nya nilainya 1
	 *
	 * @return string html snippet
	 */
	public function evaluasi(
		$id,
		$input = true,
		$show_harga = true,
		$where_winner = false,
		$evatek_aja = false,
		$populate = false,
		$show_nego = false,
		$table_only = false,
		$print_evatek = false,
		$view_order = 'vendor_per_item',
		$no_po = false
		)
	{
		$this->ci->load->model('prc_tender_item');
		$this->ci->load->model('prc_tender_main');
		$this->ci->load->model('prc_tender_prep');
		$this->ci->load->model('prc_tender_vendor');
		$this->ci->load->model('prc_tender_quo_item');

		$data['input'] = $input;
		$data['show_harga'] = $show_harga;
		$data['show_nego'] = $show_nego;
		$data['lulus_evatek_aja'] = $evatek_aja;
		$data['populate'] = $populate;
		$data['table_only'] = $table_only;
		$data['view_order'] = $view_order;

		if ($no_po) {
			$this->ci->po_detail->where_po($no_po);
			$this->ci->po_detail->join_adm_plant();
			$po_detail = $this->ci->po_detail->get(false);
			$data['item'] = $po_detail;
		}

		$data['ptm'] = $this->ci->prc_tender_main->ptm($id);
		$data['ptm'] = $data['ptm'][0];
		$is_jasa = $data['ptm']['IS_JASA'] == 1;
		$this->ci->prc_tender_item->where_status_not(array(999));
		$this->ci->prc_tender_item->join_pr();
		$tits = $this->ci->prc_tender_item->ptm($id, $is_jasa);		
		// var_dump($tits[0]['PPR_DOCTYPE']);
		$data['tits']=array();
		foreach ($tits as $key => $value) {
			$data['tits'][$value['TIT_ID']] = $value;
		}		
		
		if($tits[0]['PPR_DOCTYPE']=='ZBS'){
			$this->ci->prc_tender_prep->join_eval_template_zbs();
			$data['ptp'] = $this->ci->prc_tender_prep->ptm($id);
		}else{
			// usort($data['tits'], array($this, "sort_item"));
			$this->ci->prc_tender_prep->join_eval_template();
			$data['ptp'] = $this->ci->prc_tender_prep->ptm($id);


			switch ($data['ptp']['EVT_TYPE']) {
				case "1": $data['ptp']['EVT_TYPE_NAME'] = 'Evaluasi Kualitas Terbaik'; break;
				case "2": $data['ptp']['EVT_TYPE_NAME'] = 'Evaluasi Kualitas Teknis dan Harga'; break;
				case "3": $data['ptp']['EVT_TYPE_NAME'] = 'Evaluasi Harga Terbaik'; break;
				case "4": $data['ptp']['EVT_TYPE_NAME'] = 'Evaluasi Interchangeable (khusus Tonasa)'; break;
				case "5": $data['ptp']['EVT_TYPE_NAME'] = 'Sistem Gugur'; break;
			}	
		}
		
		// var_dump($data['ptp']);
		$data['ptv'] = $this->ci->prc_tender_vendor->ptm($id);
		$this->ci->prc_tender_quo_item->join_pqm();
		if ($where_winner !== false) {
			$this->ci->prc_tender_quo_item->where_win($where_winner);
		}
		$ptqi = $this->ci->prc_tender_quo_item->get_by_ptm($id);
		$data['ptqi'] = array();
		foreach ($ptqi as $val) {
			$data['ptqi'][$val['TIT_ID']][$val['PTV_VENDOR_CODE']] = $val;
		}
		// var_dump($data['ptqi']);
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
					// klo ini di buka maka Nilai total nambah 1
				// if($data['ptp']['PTP_JUSTIFICATION_ORI']!=5){
					// $total += intval($data['ptp']['EVT_TECH_WEIGHT']) + intval($data['ptp']['EVT_PRICE_WEIGHT']);
				// }
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

			if ($data['ptp']['EVT_TYPE'] == '4' && $data['ptm']['MASTER_ID'] >= 13) { // khusus tonasa & evaluasi harga
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
					
					// if ($data['ptqi'][$key][$keyy]['LULUS_TECH']) {
					$weight = empty($valuee['TIT_TECH_WEIGHT'])?$boboteknis:$valuee['TIT_TECH_WEIGHT'];
					$price = empty($valuee['TIT_PRICE_WEIGHT'])?$bobotharga:$valuee['TIT_PRICE_WEIGHT'];

					$total = 0;
					$total += intval($valuee['PQI_TECH_VAL']) * $weight;
					$total += intval($valuee['PQI_PRICE_VAL']) * $price;
						// $total /= intval($data['ptp']['EVT_TECH_WEIGHT']) + intval($data['ptp']['EVT_PRICE_WEIGHT']);
					$data['ptqi'][$key][$keyy]['NILAI_TOTAL'] = $total;

					$data['ptqi'][$key][$keyy]['EVT_TECH_WEIGHT'] = $boboteknis;
					$data['ptqi'][$key][$keyy]['EVT_PRICE_WEIGHT'] = $bobotharga;
					// }
					// else {
					// 	$data['ptqi'][$key][$keyy]['NILAI_TOTAL'] = $data['ptqi'][$key][$keyy]['NILAI_TOTAL_B'];
					// 	$data['ptqi'][$key][$keyy]['EVT_TECH_WEIGHT'] = $data['ptqi'][$key][$keyy]['EVT_TECH_WEIGHT_B'];
					// 	$data['ptqi'][$key][$keyy]['EVT_PRICE_WEIGHT'] = $data['ptqi'][$key][$keyy]['EVT_PRICE_WEIGHT_B'];
					// }
				}
			}
		}

		if ($data['ptp']['EVT_TYPE'] == '4' && $data['ptm']['MASTER_ID'] >= 13) { // proses pengurutan khusus tonasa & evaluasi harga
			unset($tits);
			$tits_b = array();		
			foreach ($data['tits'] as $valtit) {			
				$tit_b = $valtit;
				$ptv_b = array();			
				foreach ($data['ptv'] as $valptv) {					
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
			$tit['ptv'] = $ptv;
			usort($tit['ptv'], array($this, 'sort_eval'));
			$tits[] = $tit;
		}
		$data['tits'] = $tits;
		//*/

		$data['batas_penawaran'] = false;
		$dateNew = date('Y-m-d H:i:s');	
		if(!empty($data['ptm']['BATAS_VENDOR_HARGA_RG'])){
			$data['batas_penawaran'] = true;
			if(strtotime($data['ptm']['BATAS_VENDOR_HARGA_RG']) > strtotime($dateNew)) {
				$data['batas_penawaran'] = false;
			}
		}	

		// echo "<pre>";
		// var_dump($tits[0]['ptv']);
		// echo "</pre>";
		// die();				 

		if ($print_evatek == 'true') {
			$ans = $this->ci->load->view('snippets/print_evatek', $data, true);
		} else {
			$ans = $this->ci->load->view('snippets/evaluasi', $data, true);
		}
		// var_dump($data['ptqi']);
		return $ans;
	}

	private function sort_eval($a, $b) {
		return ($a['pqi']['NILAI_TOTAL'] < $b['pqi']['NILAI_TOTAL']);
	}

	private function sort_eval_b($a, $b) {
		return ($a['pqi']['NILAI_TOTAL_B'] < $b['pqi']['NILAI_TOTAL_B']);
	}

	/**
	 * Nampilin detail penawaran vendor. Meliputi
	 *     - PRC_TENDER_VENDOR
	 *     - PRC_TENDER_QUO_MAIN
	 *     - PRC_TENDER_QUO_ITEM
	 *     - PRC_EVAL_FILE
	 *
	 * @param int PTV_ID
	 * @return string html snippet
	 */
	public function tender_vendor($ptv_id, $show_harga = false) {
		$this->ci->load->model('prc_tender_main');
		$this->ci->load->model('prc_tender_prep');
		$this->ci->load->model('prc_tender_vendor');
		$this->ci->load->model('prc_tender_quo_main');
		$this->ci->load->model('prc_tender_quo_item');
		$this->ci->load->model('prc_eval_file');
		$this->ci->load->model('prc_evaluasi_uraian');

		$ptv = $this->ci->prc_tender_vendor->find($ptv_id);
		if (empty($ptv)) {
			return 'Cannot find PTV_ID(' . $ptv_id . ').';
		}

		$data['show_harga'] = $show_harga;

		$ptm = $this->ci->prc_tender_main->ptm($ptv['PTM_NUMBER']);
		$data['ptm'] = $ptm[0];
		$ptm = $data['ptm']['PTM_NUMBER'];

		$data['ptp'] = $this->ci->prc_tender_prep->ptm($ptm);

		$data['ptv'] = $ptv;
		$ptv = $data['ptv']['PTV_VENDOR_CODE'];

		$pqm = $this->ci->prc_tender_quo_main->ptmptv($ptm, $ptv);
		$data['pqm'] = $pqm[0];
		$pqm = $data['pqm']['PQM_ID'];

		$ptqi = $this->ci->prc_tender_quo_item->get_by_pqm($pqm);
		$data['pqi'] = $ptqi;

		// $this->ci->prc_eval_file->join_et();
		$this->ci->prc_eval_file->where_ptm_ptv($ptm, $ptv);
		$ef = $this->ci->prc_eval_file->get();
		$data['ef'] = array();
		foreach ((array)$ef as $val) {
			$data['ef'][$val['TIT_ID']][] = $val;
		}

		$this->ci->prc_evaluasi_uraian->where_ptm($ptm);
		$eu = (array)$this->ci->prc_evaluasi_uraian->get();
		$data['eu'] = array();
		foreach ($eu as $val) {
			$data['eu'][$val['TIT_ID']][$val['ET_ID']][] = $val;
		}

		$data['batas_penawaran'] = false;
		$dateNew = date('Y-m-d H:i:s');	
		if(!empty($data['ptm']['BATAS_VENDOR_HARGA_RG'])){
			$data['batas_penawaran'] = true;
			if(strtotime($data['ptm']['BATAS_VENDOR_HARGA_RG']) > strtotime($dateNew)) {
				$data['batas_penawaran'] = false;
			}
		}	 

		return $this->ci->load->view('snippets/tender_vendor', $data, true);
	}

	/**
	 * Nampilin assignment jika sesuatu. sesuatu.
	 *
	 * @param int ptm_number
	 * @return string html snippet
	 */
	public function assignment($id, $whatever = null) {
		$this->ci->load->model('prc_tender_main');

		$ptm = $this->ci->prc_tender_main->ptm($id);
		$ptm = $ptm[0];
		if ($ptm['IS_ASSIGN'] == '1') {
			$data = array();
			return $this->ci->load->view('snippets/assignment', $data, true);
		} else {
			return '';
		}
	}

	/**
	 * Nampilin detail ptm comment
	 *
	 * @param int ptm_number
	 * @return string html snippet
	 */
	public function ptm_comment($id, $whereStatus = null) {
		$this->ci->load->library('comment');
		if($whereStatus != null){
			$data['comments'] = $this->ci->comment->join_ptm($id,$whereStatus);
		}else{
			$data['comments'] = $this->ci->comment->get_comment_from_ptm_num($id);
		}
		return $this->ci->load->view('snippets/ptm_comment', $data, true);
	}

	public function ptm_comment_pdf($id, $whereStatus = null) {
		$this->ci->load->library('comment');
		if($whereStatus != null){
			$data['comments'] = $this->ci->comment->join_ptm($id,$whereStatus);
		}else{
			$data['comments'] = $this->ci->comment->get_comment_from_ptm_num($id);
		}
		return $this->ci->load->view('snippets/ptm_comment_pdf', $data, true);
	}

	public function evaluator($id) {
		$this->ci->load->model('prc_evaluator');

		$this->ci->prc_evaluator->join_emp();
		$evaluator = $this->ci->prc_evaluator->ptm($id);
		$data = compact('evaluator');

		return $this->ci->load->view('snippets/evaluator', $data, true);
	}

	/**
	 * Nampilin view history klarifikasi teknis
	 *
	 * @param int ptm_number
	 * @param int vendor_no
	 * @return string html snippet
	 */
	public function view_history_chat($ptm, $vendor_no=null){
		$this->ci->load->model('prc_chat');

		$this->ci->prc_chat->order_tgl();
		$this->ci->prc_chat->join_employee_vendor();
		if($vendor_no){
			$data1 = $this->ci->prc_chat->get(array('PTM_NUMBER'=>$ptm, 'PRC_CHAT.VENDOR_NO'=>$vendor_no));
		}else{
			$data1 = $this->ci->prc_chat->get(array('PTM_NUMBER'=>$ptm));
		}
		$data['pesan']=$data1;
		return $this->ci->load->view('snippets/history_chat', $data, true);
	}

	public function countTender($id,$ppi_id){
		// $this->session->userdata['COMPANYID']
		$this->ci->load->model('prc_tender_main');
		$m = $this->ci->prc_tender_main->ptm($id);
		$ptm=$m[0];

		$count2=0;
		if ($this->ci->session->userdata['COMPANYID'] == '4000') { //tonasa
			if ($ptm['PTM_STATUS'] <= -2 && $ptm['PTM_STATUS'] >= -8){ //reject
				$count2 = 1;
			}
	        	//yg di count hanya retender dan lolos, reject gk di count
			$qr = " AND tm.PTM_STATUS NOT IN (-2,-3,-4,-5,-6,-7,-8)";
			$qrr = " AND ttm.PTM_STATUS NOT IN (-2,-3,-4,-5,-6,-7,-8)";
		} else {
			if ($ptm['PTM_STATUS'] <= -2 && $ptm['PTM_STATUS'] >= -7){//reject
				$count2 = 1;
			}
	        	//yg di count hanya retender dan lolos, reject gk di count
			$qr = " AND tm.PTM_STATUS NOT IN (-2,-3,-4,-5,-6,-7)";
			$qrr = " AND ttm.PTM_STATUS NOT IN (-2,-3,-4,-5,-6,-7)";
		}

		$da = " SELECT rt.PTM_NUMBER,tm.PTM_STATUS from retender_item  rt
		INNER JOIN prc_tender_main tm ON tm.PTM_NUMBER=rt.PTM_NUMBER {$qr}
		WHERE rt.PPI_ID='".$ppi_id."' AND rt.PTM_NUMBER <= ".$id."
		UNION ALL
		SELECT tt.PTM_NUMBER,ttm.PTM_STATUS from prc_tender_item  tt
		INNER JOIN prc_tender_main ttm ON ttm.PTM_NUMBER=tt.PTM_NUMBER {$qrr}
		WHERE tt.PPI_ID='".$ppi_id."' AND tt.PTM_NUMBER <= ".$id."
		ORDER BY PTM_NUMBER ";
		$data = $this->ci->db->query($da);
		$data = $data->result_array();

		return count($data)+intval($count2);
	}

	public function viewDokppm($id = null){
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

}
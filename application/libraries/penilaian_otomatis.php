<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian_otomatis {

	public function __construct() {
		$this->ci = &get_instance();
		$this->ci->load->library('log_data');
	}

	public function insert($param, $vendors, $no_LB, $evt_passing_grade=null, $lm_id=null) {
		$this->ci->load->model('vnd_perf_criteria');
		$this->ci->load->model('vnd_perf_tmp');
		$this->ci->load->model('vnd_perf_hist');
		$this->ci->load->model('vnd_header');

		if ($vendors != null){
			foreach ($vendors as $v) {
				$vnd_header = $this->ci->vnd_header->get(array('VENDOR_NO'=>strval($v['PTV_VENDOR_CODE'])));
				switch ($param) {
					case 'proc_verify_entry':
							/* Status prc_tender_vendor */
		 						// null = Belum merespon, -1 = Tidak diikutkan, 0 = Merespon tidak ikut, 1 = Merespon Ikut, 2 = Sudah memasukkan penawaran
							/* Apakah merespon Penawaran ? */
						if ($v['PTV_STATUS']==null) {

							$cri = $this->ci->vnd_perf_criteria->get(array('CRITERIA_TYPE'=>'RPT','COMPANYID'=>$vnd_header['COMPANYID'])); // 2 = Tidak Merespon Penawaran
							$criteria = $cri[0];
							$sign = $criteria['CRITERIA_SCORE_SIGN'];
							$poin = $criteria['CRITERIA_SCORE'];
							$criteria_id = $criteria['ID_CRITERIA'];
							$keterangan = $criteria['CRITERIA_NAME']." (".$criteria['CRITERIA_DETAIL'].")";
							$criteria_id2 = null;

						} else if ($v['PTV_STATUS']==0 || $v['PTV_STATUS']==1 || $v['PTV_STATUS']==2 || $v['PTV_STATUS']==-1) {
							$cri = $this->ci->vnd_perf_criteria->get(array('CRITERIA_TYPE'=>'RPY','COMPANYID'=>$vnd_header['COMPANYID'])); // 1 = Merespon Penawaran
							$criteria = $cri[0];
							$sign = $criteria['CRITERIA_SCORE_SIGN'];
							$poin = $criteria['CRITERIA_SCORE'];
							$criteria_id = $criteria['ID_CRITERIA'];
							$keterangan = $criteria['CRITERIA_NAME']." (".$criteria['CRITERIA_DETAIL'].")";
							$criteria_id2 = null;
						}
							/* Apakah memasukkan penawaran ? */
						if ($v['PTV_STATUS']==1) {
							$cri = $this->ci->vnd_perf_criteria->get(array('CRITERIA_TYPE'=>'MPT','COMPANYID'=>$vnd_header['COMPANYID'])); // 39 = Tidak Memasukkan Penawaran
							$criteria = $cri[0];
							$sign2 = $criteria['CRITERIA_SCORE_SIGN'];
							$poin2 = $criteria['CRITERIA_SCORE'];
							$criteria_id2 = $criteria['ID_CRITERIA'];
							$keterangan2 = $criteria['CRITERIA_NAME']." (".$criteria['CRITERIA_DETAIL'].")";
						
						}else if($v['PTV_STATUS']==2 || $v['PTV_STATUS']==-1){
							$cri = $this->ci->vnd_perf_criteria->get(array('CRITERIA_TYPE'=>'MPY','COMPANYID'=>$vnd_header['COMPANYID'])); // 38 = Memasukkan Penawaran
							$criteria = $cri[0];
							$sign2 = $criteria['CRITERIA_SCORE_SIGN'];
							$poin2 = $criteria['CRITERIA_SCORE'];
							$criteria_id2 = $criteria['ID_CRITERIA'];
							$keterangan2 = $criteria['CRITERIA_NAME']." (".$criteria['CRITERIA_DETAIL'].")";
						}
						break;

					case 'persetujuan_evaluasi':
						if(intval($v['PQI_TECH_VAL']) >= intval($evt_passing_grade)){ //jika Lulus
							$cri = $this->ci->vnd_perf_criteria->get(array('CRITERIA_TYPE'=>'LTY','COMPANYID'=>$vnd_header['COMPANYID'])); // 58 = Lulus Evaluasi Teknis
							$criteria = $cri[0];
							$sign = $criteria['CRITERIA_SCORE_SIGN'];
							$poin = $criteria['CRITERIA_SCORE'];
							$criteria_id = $criteria['ID_CRITERIA'];
							$keterangan = $criteria['CRITERIA_NAME']." (".$criteria['CRITERIA_DETAIL'].")";
							$criteria_id2 = null;
						
						}else{
							$cri = $this->ci->vnd_perf_criteria->get(array('CRITERIA_TYPE'=>'LTY','COMPANYID'=>$vnd_header['COMPANYID'])); // 58 = Tidak Lulus Evaluasi Teknis
							$criteria = $cri[0];
							$sign = $criteria['CRITERIA_SCORE_SIGN'];
							$poin = $criteria['CRITERIA_SCORE'];
							$criteria_id = $criteria['ID_CRITERIA'];
							$keterangan = $criteria['CRITERIA_NAME']." (".$criteria['CRITERIA_DETAIL'].")";
							$criteria_id2 = null;
						}
						break;
					
					case 'negosiasi':
						$cri_type=0;
						if($v['respon']=='turun'){
							$cri_type='NHT';
						}else if($v['respon']=='tetap'){
							$cri_type='NHP';
						}else if($v['respon']=='no'){
							$cri_type='NTR';
						}
						$cri = $this->ci->vnd_perf_criteria->get(array('CRITERIA_TYPE'=>$cri_type,'COMPANYID'=>$vnd_header['COMPANYID'])); 
						$criteria = $cri[0];
						$sign = $criteria['CRITERIA_SCORE_SIGN'];
						$poin = $criteria['CRITERIA_SCORE'];
						$criteria_id = $criteria['ID_CRITERIA'];
						$keterangan = $criteria['CRITERIA_NAME']." (".$criteria['CRITERIA_DETAIL'].")";
						$criteria_id2 = null;
						break;
					default:
						return false;
				}

				$lmId=null;
				if($lm_id){
					$lmId=$lm_id;
				}
				//untuk memeriksa apakah vendor telah bebas dari sanksi dan untuk mereset nilai apabila nilai sisa negatif.
				$this->cek_bebas_reset($v['PTV_VENDOR_CODE'], $lmId);

				$cek_tmp = $this->ci->vnd_perf_tmp->get(array('CRITERIA_ID'=>$criteria_id, 'EXTERNAL_CODE'=>$no_LB, 'VENDOR_CODE'=>$v['PTV_VENDOR_CODE']));
				if(!isset($cek_tmp[0]) || $param=='negosiasi'){
					$tmp['VENDOR_CODE'] = $v['PTV_VENDOR_CODE'];
					$tmp['DATE_CREATED'] = date(timeformat());
					$tmp['SIGN'] = $sign;
					$tmp['POIN'] = $poin;
					$tmp['CRITERIA_ID'] = $criteria_id;
					$tmp['KETERANGAN'] = $keterangan;			
					$tmp['STATUS'] = '1';
					$tmp['EXTERNAL_CODE'] = $no_LB;
					$this->ci->vnd_perf_tmp->insert($tmp);
					if($lm_id){
							//--LOG DETAIL--//
						$this->ci->log_data->detail($lm_id,'Penilaian_otomatis/insert','vnd_perf_tmp','insert',$tmp);
							//--END LOG DETAIL--//
					}

					$hist_lama = $this->ci->vnd_perf_hist->get_desc(array('VENDOR_CODE'=>$v['PTV_VENDOR_CODE']), 2);
					$poin_lama = 0;
					if(isset($hist_lama[0])){
						$poin_lama = $hist_lama[0]["POIN_CURR"];						
					}

					if($sign == '-'){
						$poin = $sign.$poin;
					}
					$hist['VENDOR_CODE'] = $v['PTV_VENDOR_CODE'];
					$hist['DATE_CREATED'] = date(timeformat());
					$hist['KETERANGAN'] = $keterangan;
					$hist['POIN_ADDED'] = $poin;
					$hist['SIGN'] = $sign;
					$hist['POIN_PREV'] = (int)$poin_lama;			
					$hist['POIN_CURR'] = (int)$poin_lama + (int)$poin;
					$hist['CRITERIA_ID'] = $criteria_id;
					$hist['TMP_ID'] =  $this->ci->vnd_perf_tmp->get_last_id();
					$this->ci->vnd_perf_hist->insert_custom($hist);
					if($lm_id){
							//--LOG DETAIL--//
						$this->ci->log_data->detail($lm_id,'Penilaian_otomatis/insert','vnd_perf_hist','insert',$hist);
							//--END LOG DETAIL--//
					}
				}
				if($param=='proc_verify_entry' && $criteria_id2!=null){
					$cek_tmp2 = $this->ci->vnd_perf_tmp->get(array('CRITERIA_ID'=>$criteria_id2, 'EXTERNAL_CODE'=>$no_LB, 'VENDOR_CODE'=>$v['PTV_VENDOR_CODE']));
					if( !isset($cek_tmp2[0]) && ($v['PTV_STATUS']==1 || $v['PTV_STATUS']==2) ){
						$tmp2['VENDOR_CODE'] = $v['PTV_VENDOR_CODE'];
						$tmp2['DATE_CREATED'] = date(timeformat());
						$tmp2['SIGN'] = $sign2;
						$tmp2['POIN'] = $poin2;
						$tmp2['CRITERIA_ID'] = $criteria_id2;
						$tmp2['KETERANGAN'] = $keterangan2;			
						$tmp2['STATUS'] = '1';
						$tmp2['EXTERNAL_CODE'] = $no_LB;
						$this->ci->vnd_perf_tmp->insert($tmp2);
						if($lm_id){
								//--LOG DETAIL--//
							$this->ci->log_data->detail($lm_id,'Penilaian_otomatis/insert','vnd_perf_tmp','insert',$tmp2);
								//--END LOG DETAIL--//
						}

						$hist_lama2 = $this->ci->vnd_perf_hist->get_desc(array('VENDOR_CODE'=>$v['PTV_VENDOR_CODE']), 2);
						$poin_lama2 = 0;
						if(isset($hist_lama2[0])){
							$poin_lama2 = $hist_lama2[0]["POIN_CURR"];						
						}

						if($sign2 == '-'){
							$poin2 = $sign2.$poin2;
						}

						$hist2['VENDOR_CODE'] = $v['PTV_VENDOR_CODE'];
						$hist2['DATE_CREATED'] = date(timeformat());
						$hist2['KETERANGAN'] = $keterangan2;
						$hist2['POIN_ADDED'] = $poin2;
						$hist2['SIGN'] = $sign2;
						$hist2['POIN_PREV'] = (int)$poin_lama2;			
						$hist2['POIN_CURR'] = (int)$poin_lama2 + (int)$poin2;
						$hist2['CRITERIA_ID'] = $criteria_id2;
						$hist2['TMP_ID'] =  $this->ci->vnd_perf_tmp->get_last_id();
						$this->ci->vnd_perf_hist->insert_custom($hist2); 
						if($lm_id){
								//--LOG DETAIL--//
							$this->ci->log_data->detail($lm_id,'Penilaian_otomatis/insert','vnd_perf_hist','insert',$hist2);
								//--END LOG DETAIL--//
						}
					}
				}

			}
		}

	}

	public function cek_bebas_reset($VENDOR_NO, $lm_id=null){
		$this->ci->load->model('vnd_perf_hist');
		$this->ci->load->model('vnd_perf_sanction');		
		$current_date = date("d-M-y");
		$yesterday = date("d-M-y",strtotime($current_date."-1 days"));
		if($this->ci->vnd_perf_sanction->cek_bebas_sanksi($VENDOR_NO,$current_date))
		{
			if($this->ci->vnd_perf_hist->cek_is_reset($VENDOR_NO,$current_date,$yesterday)==false)
			{
				$id = $this->ci->vnd_perf_hist->get_max_id_vendor($VENDOR_NO);
				$data = $this->ci->vnd_perf_hist->get(array('PERF_HIST_ID'=>$id));
				if($data[0]['POIN_CURR']<0){
					$data_new_hist = array(
							'VENDOR_CODE'=>$VENDOR_NO,
							'DATE_CREATED'=>$current_date,
							'KETERANGAN'=>'Reset Bebas Sanksi',
							'POIN_ADDED'=>0,
							'SIGN'=>'+',
							'IGNORED'=>0,
							'POIN_PREV'=>$data[0]['POIN_CURR'],
							'POIN_CURR'=>0,
							'CRITERIA_ID'=>NULL,
							'TMP_ID'=>NULL,
							'REKAP_ID'=>NULL
							);
					try{
						$this->ci->vnd_perf_hist->insert_custom($data_new_hist);
						if($lm_id){
								//--LOG DETAIL--//
							$this->ci->log_data->detail($lm_id,'Penilaian_otomatis/cek_bebas_reset','vnd_perf_hist','insert',$data_new_hist);
								//--END LOG DETAIL--//
						}
					}catch(Exception $e){
						return $e;
					}
				}
			}
		}
		
	}
}
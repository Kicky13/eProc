<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_Performance_Management extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
	}

	public function index() {
		redirect('Vendor_performance_management/vendor_performance_list');
	}

	public function vendor_performance_list() {
		$this->load->model(array('vnd_perf_hist'));
		$data['title'] = "Form Nilai Vendor non Procurement";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/vnd_perf_management.js');
		$this->layout->render('vendor_performance_list', $data);
	}

	public function get_all_vendor_performance(){ 
		$this->load->model(array('vnd_perf_hist'));
		$length = $this->input->post('length');
		$start = $this->input->post('start');				
		$draw = $this->input->post('draw');	
		$search = $this->input->post('search');
		$opco = $this->session->userdata['KEL_PRGRP'];
		
		$datatable = $this->vnd_perf_hist->get_vendor($length,$start,$draw,$opco,$search); 
		echo json_encode($datatable);
	}

	public function form_approval($vendor_id) {
		$this->load->model(array('vnd_header','vnd_perf_criteria','vnd_perf_tmp', 'vnd_perf_approve','vendor_employe', 'vnd_perf_hist'));
		$id = $this->session->userdata['ID']; 
		$data_emp = $this->vendor_employe->getemplo($id);

		$data['title'] = 'Form Approval Penilaian Vendor';
		$this->vnd_perf_approve->join();
		$this->vnd_perf_approve->where("STATUS_APRV", 0);
		$this->vnd_perf_approve->where("APPROVED_DATE is not null");
		$this->vnd_perf_approve->where_ven($vendor_id);

		if($data_emp[0]['LEVEL'] == 1){ //bagian Perencanaan

			$this->vnd_perf_approve->where("URUTAN", 1);
		
		}elseif ($data_emp[0]['LEVEL'] == 2) { //bagian Kasi
		
			$this->vnd_perf_approve->where("URUTAN", 2);
		
		}elseif ($data_emp[0]['LEVEL'] == 3) { //bagian kabiro
		
			$this->vnd_perf_approve->where("URUTAN", 3);
		
		}

		$data['non_proc'] = $this->vnd_perf_approve->get_ven();
		$vendor_no = $data['non_proc'][0]['VENDOR_NO'];
		$data['hist_vendor'] = $this->vnd_perf_hist->get_vendor_last_point($vendor_no); 
		$data['emplo'] = $this->vendor_employe->getemplo($id);
		$data['vendor_detail'] = $this->vnd_header->where("VENDOR_ID", $vendor_id)->get_all();

		// die(var_dump($data['vendor_detail']));

		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('pages/vnd_perf_management.js');
		$this->layout->render('form_approval', $data);
	}

	public function detail_vendor_performance($vendor_id) {
		if ($vendor_id) {
			$id = $this->session->userdata['ID'];
			$opco = $this->session->userdata['EM_COMPANY'];

			if ($opco == '7000' || '2000' || '5000') {
				$whereopco = 'IN(\'7000\',\'2000\',\'5000\')';
			} else {
				$whereopco = '='.$opco.'';
			}

			$data['title'] = "Detail Penilaian Vendor";
			$this->load->model(array('vnd_perf_hist','vnd_header','vnd_perf_criteria','vnd_perf_tmp'));
			$vendor = $this->vnd_header->get(array('VENDOR_ID' => $vendor_id));
			
			 // var_dump($vendor);
			$vendor_no = $vendor['VENDOR_NO'];
			$tmp = $this->vnd_perf_tmp->get(array('VENDOR_CODE' => $vendor_no, 'STATUS' => 0));

			$cek_vendor = $this->vnd_perf_tmp->cek_approve($vendor_no);

			$vendors = $this->vnd_header->get(array('VENDOR_ID' => $vendor_id));
			// var_dump($vendors); var_dump($vendor_code);
			$data['vendor_performance']  = $tmp;
			$data['vendor_information'] = $vendors;
			$data['cek_approval'] = $cek_vendor;
			
            $grpakses = $this->session->userdata('GRPAKSES'); 
			$data['point_vendor'] = $this->vnd_perf_hist->get_vendor_last_point($vendor_no);

			$tv = '\'V\'';
      		$data['performance_criteria'] = $this->vnd_perf_criteria->get_criteria($whereopco, $tv);
            
			$this->layout->set_table_js();
			$this->layout->set_table_cs();
			$this->layout->add_js('plugins/select2/select2.js');
			$this->layout->add_css('plugins/select2/select2.css');
			$this->layout->add_css('plugins/select2/select2-bootstrap.css');
			$this->layout->add_js('pages/vnd_perf_management.js');
			$this->layout->render('detail_vendor_performance', $data);
		}
		else {
			redirect(site_url('Vendor_performance_management/vendor_performance_list'));
		}
	}

	public function do_insert_performance()
	{
		$this->load->model(array('vnd_perf_hist', 'vnd_perf_tmp', 'vnd_perf_approve', 'vnd_header'));		
		// $lastScore = isset($lastScore["POIN"]) ? intval($lastScore["POIN"]) : 0;
		$poin_added = intval($this->input->post('VALUE'));
		$vendor_no = $this->input->post('VENDOR_NO');

		$vendor = $this->vnd_header->get(array('VENDOR_NO' => $vendor_no));

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Penilaan Vendor Manual (Input Nilai)','SAVE',$this->input->ip_address());
				$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$data = array(
				'VENDOR_CODE' => $vendor_no,
				'DATE_CREATED' => date(timeformat()),
				'SIGN' => $this->input->post('SIGN'),
				'POIN' => $this->input->post('VALUE'),
				'CRITERIA_ID' => $this->input->post('criteria'),
				'KETERANGAN' => $this->input->post('KETERANGAN'),
				'STATUS' => 0,
				'EMP_ID' => $this->session->userdata('ID'),
			);
		$this->vnd_perf_tmp->insert($data);
		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_performance_management/do_insert_performance','vnd_perf_tmp','insert',$data);
		//--END LOG DETAIL--//

		$tmp_id= $this->vnd_perf_tmp->get_last_id();

		$data2 = array(
				'TMP_ID' => $tmp_id,
				'EMP_ID' => $this->session->userdata('ID'),
				'APPROVED_DATE' => date(timeformat()),
				'URUTAN' => 1,
				'STATUS_APRV' => 0,
			);
		$this->vnd_perf_approve->insert($data2);
		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_performance_management/do_insert_performance','vnd_perf_approve','insert',$data);
		//--END LOG DETAIL--//		

		$this->session->set_flashdata('success', "Performance for Vendor <strong>".$vendor_no."</strong> added");
		$url = "Vendor_performance_management/detail_vendor_performance/".$vendor['VENDOR_ID'];
		redirect(site_url($url));
	}

	public function do_delete_vendor_performance($perf_tmp_id, $vendor_id) {
		$this->load->model('vnd_perf_tmp');
		$status = $this->vnd_perf_tmp->delete(array("PERF_TMP_ID" => $perf_tmp_id));
		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Penilaan Vendor Manual (Delete Nilai)','Delete',$this->input->ip_address());
				$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		//--LOG DETAIL--//
			$where = array("PERF_TMP_ID" => $perf_tmp_id);
			$this->log_data->detail($LM_ID,'Vendor_performance_management/do_delete_vendor_performance','vnd_perf_tmp','delete',null,$where);
		//--END LOG DETAIL--//
		if ($status) {
			$this->session->set_flashdata('success', "Item Performance for Vendor <strong>".$this->input->post('VENDOR_NO')."</strong> deleted");
			$url = "Vendor_performance_management/detail_vendor_performance/".$vendor_id;
			redirect(site_url($url));
		};
	}

	public function approve_manual() {
		$this->load->model(array('vnd_perf_approve','vnd_perf_tmp', 'vendor_employe', 'vnd_perf_hist','vnd_perf_criteria','vnd_perf_sanction','vnd_perf_m_sanction'));
		$this->load->library('Penilaian_otomatis');
		$idem = $this->session->userdata['ID'];
		$employ = $this->vendor_employe->getemplo($idem);
		$tgl= date(timeformat());


		$temp = $this->input->post('perf_tmp_id'); 
		if ($employ[0]['LEVEL'] == 1) { // perencanaan 
		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Penilaan Vendor Manual (Approve Perencanaan)','APPROVAL',$this->input->ip_address());
				$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
			if ($temp > 1) {

				foreach ($temp as $val) { 
					$this->vnd_perf_approve->update(array("STATUS_APRV" => '1', "APPROVED_DATE" => $tgl),array("TMP_ID" => intval($val['value']), "STATUS_APRV" => '0')); 

						//--LOG DETAIL--//
							$data = array("STATUS_APRV" => '1', "APPROVED_DATE" => $tgl);
							$where = array("TMP_ID" => intval($val['value']), "STATUS_APRV" => '0');
							$this->log_data->detail($LM_ID,'Vendor_performance_management/approve_manual','vnd_perf_approve','update',$data,$where);
						//--END LOG DETAIL--//
				}
			}
			// update nilai vendor yg uncentang
			$vendor_no = $this->input->post('vendor_no'); 
			$valu = $this->vnd_perf_tmp->get_uncek($vendor_no);

			// die(var_dump($valu));
			if (!empty($valu)) {
				foreach ($valu as $val) {
					$this->vnd_perf_approve->update(array("STATUS_APRV" => '-1', "APPROVED_DATE" => $tgl), array("TMP_ID" => $val['TMP_ID'], "STATUS_APRV" => '0'));
						
						//--LOG DETAIL--//
							$data = array("STATUS_APRV" => '-1', "APPROVED_DATE" => $tgl);
							$where = array("TMP_ID" => $val['TMP_ID'], "STATUS_APRV" => '0');
							$this->log_data->detail($LM_ID,'Vendor_performance_management/approve_manual','vnd_perf_approve','update',$data,$where);
						//--END LOG DETAIL--//

					$this->vnd_perf_tmp->update(array("STATUS" => '-1'),array("PERF_TMP_ID" => $val['TMP_ID'], "STATUS" => '0')); 	
						//--LOG DETAIL--//
							$dataa = array("STATUS" => '-1');
							$wheree = array("PERF_TMP_ID" => $val['TMP_ID'], "STATUS" => '0');
							$this->log_data->detail($LM_ID,'Vendor_performance_management/approve_manual','vnd_perf_tmp','update',$dataa,$wheree);
						//--END LOG DETAIL--//

				 }
			}

			//insert
			foreach ($temp as $val) {
				if ($val['value'] != $vendor_no) {
					$aprvs = $this->vnd_perf_approve
							->where('TMP_ID', $val['value'])
							->where('URUTAN', 1)
							->get_all();

					$tmp_add["TMP_ID"] = $aprvs[0]['TMP_ID'];
					$tmp_add["EMP_ID"] = $aprvs[0]['EMP_ID'];
					$tmp_add["APPROVED_DATE"] = $tgl;
					$tmp_add["URUTAN"] = 2;
					$this->vnd_perf_approve->insert($tmp_add);
					//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Vendor_performance_management/approve_manual','vnd_perf_approve','insert',$tmp_add);
					//--END LOG DETAIL--//
				}
			}
			

		} elseif ($employ[0]['LEVEL'] == 2) { // kasi
		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Penilaan Vendor Manual (Approve Kasi)','APPROVAL',$this->input->ip_address());
				$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
			if ($temp > 1) {
				foreach ($temp as $val) { 
					$this->vnd_perf_approve->update(array("STATUS_APRV" => '1', "APPROVED_DATE" => $tgl),array("TMP_ID" => intval($val['value']), "STATUS_APRV" => '0')); 

					//--LOG DETAIL--//
						$data = array("STATUS_APRV" => '1', "APPROVED_DATE" => $tgl);
						$where = array("TMP_ID" => intval($val['value']), "STATUS_APRV" => '0');
						$this->log_data->detail($LM_ID,'Vendor_performance_management/approve_manual','vnd_perf_approve','update',$data,$where);
					//--END LOG DETAIL--//
				}
			}

			// update nilai vendor yg uncentang
			$vendor_no = $this->input->post('vendor_no'); 
			$valu = $this->vnd_perf_tmp->get_uncek($vendor_no);

			// die(var_dump($valu));
			if (!empty($valu)) {
				foreach ($valu as $val) {
					$this->vnd_perf_approve->update(array("STATUS_APRV" => '-1', "APPROVED_DATE" => $tgl), array("TMP_ID" => $val['TMP_ID'], "STATUS_APRV" => '0'));

					//--LOG DETAIL--//
						$data = array("STATUS_APRV" => '-1', "APPROVED_DATE" => $tgl);
						$where = array("TMP_ID" => $val['TMP_ID'], "STATUS_APRV" => '0');
						$this->log_data->detail($LM_ID,'Vendor_performance_management/approve_manual','vnd_perf_approve','update',$data,$where);
					//--END LOG DETAIL--//

					$this->vnd_perf_tmp->update(array("STATUS" => '-1'),array("PERF_TMP_ID" => $val['TMP_ID'], "STATUS" => '0')); 	

					//--LOG DETAIL--//
						$dkasi = array("STATUS" => '-1');
						$wkasi = array("PERF_TMP_ID" => $val['TMP_ID'], "STATUS" => '0');
						$this->log_data->detail($LM_ID,'Vendor_performance_management/approve_manual','vnd_perf_tmp','update',$dkasi,$wkasi);
					//--END LOG DETAIL--//
				 }
			}

			foreach ($temp as $val) {
				if ($val['value'] != $vendor_no) {
					$aprvs = $this->vnd_perf_approve
							->where('TMP_ID', $val['value'])
							->where('URUTAN', 2)
							->get_all();

					$tmp_add["TMP_ID"] = $aprvs[0]['TMP_ID'];
					$tmp_add["EMP_ID"] = $aprvs[0]['EMP_ID'];
					$tmp_add["APPROVED_DATE"] = $tgl;
					$tmp_add["URUTAN"] = 3;

					$this->vnd_perf_approve->insert($tmp_add); 
					//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Vendor_performance_management/approve_manual','vnd_perf_approve','insert',$tmp_add);
					//--END LOG DETAIL--//
				}
			}

		} elseif ($employ[0]['LEVEL'] == 3) { // kabiro 
		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Penilaan Vendor Manual (Approve Kabiro)','APPROVAL',$this->input->ip_address());
				$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

			$vendor_no = $this->input->post('vendor_no'); 
			foreach ($temp as $val) {
				if ($val['value'] != $vendor_no) {
					
					$this->vnd_perf_approve->update(array("STATUS_APRV" => '1', "APPROVED_DATE" => $tgl),
						array("TMP_ID" => intval($val['value']), "STATUS_APRV" => '0'));

					//--LOG DETAIL--//
						$data = array("STATUS_APRV" => '1', "APPROVED_DATE" => $tgl);
						$where = array("TMP_ID" => intval($val['value']), "STATUS_APRV" => '0');
						$this->log_data->detail($LM_ID,'Vendor_performance_management/approve_manual','vnd_perf_approve','update',$data,$where);
					//--END LOG DETAIL--//

					$this->vnd_perf_tmp->update(array("STATUS" => '1'),array("PERF_TMP_ID" => intval($val['value']), "STATUS" => '0'));

					//--LOG DETAIL--//
						$datak = array("STATUS" => '1');
						$wherek = array("PERF_TMP_ID" => intval($val['value']), "STATUS" => '0');
						$this->log_data->detail($LM_ID,'Vendor_performance_management/approve_manual','vnd_perf_tmp','update',$datak,$wherek);
					//--END LOG DETAIL--//
									
				} 
			}
			// update nilai vendor yg uncentang
			$valu = $this->vnd_perf_tmp->get_uncek($vendor_no); 
			//die(var_dump($valu));

			if (!empty($valu)) {
				foreach ($valu as $value) {
					// if ($value['value'] != $vendor_no) {
						$this->vnd_perf_approve->update(array("STATUS_APRV" => '-1', "APPROVED_DATE" => $tgl), array("TMP_ID" => $value['TMP_ID'], "STATUS_APRV" => '0'));
						//--LOG DETAIL--//
							$data = array("STATUS_APRV" => '-1', "APPROVED_DATE" => $tgl);
							$where = array("TMP_ID" => $value['TMP_ID'], "STATUS_APRV" => '0');
							$this->log_data->detail($LM_ID,'Vendor_performance_management/approve_manual','vnd_perf_approve','update',$data,$where);
						//--END LOG DETAIL--//
						$this->vnd_perf_tmp->update(array("STATUS" => '-1'),array("PERF_TMP_ID" => $value['TMP_ID'], "STATUS" => '0')); 

						//--LOG DETAIL--//
							$dat = array("STATUS" => '-1');
							$wher = array("PERF_TMP_ID" => $value['TMP_ID'], "STATUS" => '0');
							$this->log_data->detail($LM_ID,'Vendor_performance_management/approve_manual','vnd_perf_tmp','update',$dat,$wher);
						//--END LOG DETAIL--//	
					// }
				 }
			}

			foreach ($temp as $val) {
				if ($val['value'] != $vendor_no) {
					$aprvs = $this->vnd_perf_approve
							->where('TMP_ID', $val['value'])
							->where('URUTAN', 3)
							->get_all();
							
						//get nomer vendor dari vnd_perf_tmp
						$get_vendor_tmp = $this->vnd_perf_tmp->get(array("PERF_TMP_ID" => $aprvs[0]['TMP_ID']));

						$keterangan = $get_vendor_tmp[0]['KETERANGAN'];
						$poin = $get_vendor_tmp[0]['POIN'];
						$sign = $get_vendor_tmp[0]['SIGN'];
						$criteria = $get_vendor_tmp[0]['CRITERIA_ID'];

						//untuk memeriksa apakah vendor telah bebas dari sanksi dan untuk mereset nilai apabila nilai sisa negatif.
						$this->penilaian_otomatis->cek_bebas_reset($vendor_no);

						//cek vendor di vnd_perf_hist
						$hist_lama = $this->vnd_perf_hist->get_desc(array('VENDOR_CODE'=>$vendor_no), 2);
						$poin_lama = 0;
						if(isset($hist_lama[0])){
							$poin_lama = $hist_lama[0]["POIN_CURR"];						
						}

						if($sign == '-'){
							$poin = $sign.$poin;
						}
						$hist['VENDOR_CODE'] = $vendor_no;
						$hist['DATE_CREATED'] = date(timeformat());
						$hist['KETERANGAN'] = $keterangan;
						$hist['POIN_ADDED'] = $poin;
						$hist['SIGN'] = $sign;
						$hist['POIN_PREV'] = (int)$poin_lama;			
						$hist['POIN_CURR'] = (int)$poin_lama + (int)$poin;
						$hist['CRITERIA_ID'] = $criteria;
						$hist['TMP_ID'] =  $val['value'];
						$this->vnd_perf_hist->insert_custom($hist);
						//--LOG DETAIL--//
							$this->log_data->detail($LM_ID,'Vendor_performance_management/approve_manual','vnd_perf_hist','insert',$hist);
						//--END LOG DETAIL--//

						/*
						cek criteria apakah ada sanksi khusus
						if(sanksi_khusus){
							insert_sanksi
						}
						*/
						$sanksi_khusus=$this->vnd_perf_criteria->cek_sanksi_khusus($criteria);
						if($sanksi_khusus!=false){
							$current_date = oracledate(strtotime(date("d-m-Y H:i:s")));
							$sanksi=$this->vnd_perf_m_sanction->get_by_id($sanksi_khusus['SPECIAL_SANCTION']);
							$sanksi=$sanksi[0];
							$data_sanksi=array(
								'VENDOR_NO'=>"'".$vendor_no."'",
								'START_DATE'=>$current_date,
								'END_DATE'=>oracledate(strtotime(date("d-m-Y H:i:s",strtotime("+ ".$sanksi['DURATION']." days")))),
								'REASON'=>"'".$sanksi_khusus['CRITERIA_NAME']."'",
								'M_SANCTION_ID'=>$sanksi['M_SANCTION_ID'],
								'STATUS'=>1
								);
							$this->vnd_perf_sanction->cek_and_insert($data_sanksi);
							//--LOG DETAIL--//
								$this->log_data->detail($LM_ID,'Vendor_performance_management/approve_manual','vnd_perf_sanction','insert',$data_sanksi);
							//--END LOG DETAIL--//
						}
				}
			}

		} else{
			echo json_encode('Tidak Mempunyai Akses !');
		} 
		
		echo json_encode('OK');
	}

	public function form_nilai_tender() {
		$this->load->model('po_header');
		$this->load->model('vnd_header');
		$this->load->model('vnd_perf_criteria');
		$id = $this->session->userdata['ID'];
		$opco = $this->session->userdata['EM_COMPANY'];

		if ($opco == '7000' || $opco == '2000' || $opco =='5000') {
			$whereopco = 'IN(\'7000\',\'2000\',\'5000\')';
			$v_opco = array(7000,2000,5000);
		} else {
			$whereopco = '='.$opco.'';
			$v_opco = $opco;
		}
		$data['po'] = $this->po_header->get_po($whereopco);

		$data['vendor_data'] = $this->vnd_header->where(array("STATUS"=>3))->where("COMPANYID",$v_opco)->get_all();

		$data['title'] = 'Form Nilai Vendor Procurement';
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$tv = '\'T\'';
		$data['penilaian'] = $this->vnd_perf_criteria->get_criteria($whereopco,$tv);
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('pages/form_nilai_tender.js');
		$this->layout->render('form_nilai_tender', $data);
	}

	public function insert_nilai_tender() {   
		$this->load->model(array('vnd_perf_hist', 'vnd_perf_tmp', 'vnd_perf_approve', 'vnd_header'));
		$cek_eproc = $this->input->post('cek_eproc');
		if ($cek_eproc == 1) {
			$vendor_no = $this->input->post('vendor_no_man');
			$po_no = $this->input->post('po_no_man');
		} else {
			$vendor_no = $this->input->post('vendor_no');
			$po_no = $this->input->post('po_no');
		}

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Input Penilaain Tender','SAVE',$this->input->ip_address());
				$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		foreach ($this->input->post('criteria') as $row) {
			$data = array(
					'VENDOR_CODE' => $vendor_no,
					'DATE_CREATED' => date(timeformat()),
					'SIGN' => $row['sign'],
					'POIN' => $row['skor'],
					'CRITERIA_ID' => $row['criteria_id'],
					'KETERANGAN' => $row['keterangan'],
					'STATUS' => 0,
					'EMP_ID' => $this->session->userdata('ID'),
					'EXTERNAL_CODE' => $po_no
				);
			$this->vnd_perf_tmp->insert($data);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_performance_management/insert_nilai_tender','vnd_perf_tmp','insert',$data);
			//--END LOG DETAIL--//

			$tmp_id= $this->vnd_perf_tmp->get_last_id();
			$data2 = array(
					'TMP_ID' => $tmp_id,
					'EMP_ID' => $this->session->userdata('ID'),
					'APPROVED_DATE' => date(timeformat()),
					'URUTAN' => 1,
					'STATUS_APRV' => 0,
				);
			$this->vnd_perf_approve->insert($data2);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_performance_management/insert_nilai_tender','vnd_perf_approve','insert',$data2);
			//--END LOG DETAIL--//
		}

		$this->session->set_flashdata('success', 'success');
		redirect('Vendor_performance_management/form_nilai_tender');
	}


	public function list_bad_performance(){
		$this->load->model(array('v_vnd_perf_total','vnd_perf_mst_category','vnd_perf_hist'));
		$data['title'] = "List Bad Performance Vendor";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();

		$category = $this->vnd_perf_mst_category->where('DURATION >', '0')->order_by('START_POINT','DESC')->get_all();
		$min_poin = $category[0]['START_POINT'];
		$this->v_vnd_perf_total->join_all_field_vnd_header();
		$vnd_perf_total = $this->v_vnd_perf_total->get(array('TOTAL <'=> $min_poin));
		
		usort($vnd_perf_total, array($this, 'sort_total'));

		$data['vendor'] = $vnd_perf_total;
		$this->layout->add_js(base_url().'Assets/Vendor_performance_management/assets/vnd_perf_management.js', TRUE);
		$this->layout->render('list_bad_performance', $data);
	}

	public function list_approval(){
		$data['title'] = "Approval Adjustment";
		$this->load->model(array('v_vnd_perf_total','vnd_perf_mst_category','vnd_perf_hist','vnd_perf_rekap_approve','vnd_perf_rekap'));
		$id = $this->session->userdata('ID');
		$list = $this->vnd_perf_rekap_approve->get_all(array('APPROVED_BY' => $id));
		$list_vendor = array();
		foreach ($list as $key => $value) {
			$rekap = $this->vnd_perf_rekap->where('ID_REKAP',$value['ID_REKAP'])->where('STATUS',intval($value['URUTAN']))->get();
			// $rekap['VENDOR_NO'] = $this->vnd_perf_hist->get_all(array('VENDOR_CODE',)
			$list_vendor[] = $rekap;
		}
		
	}

	public function submit_adj(){
		$this->load->model(array('adm_approve_sangsi','vnd_perf_rekap','vnd_perf_rekap_approve','vnd_header'));
		$list_app = $this->adm_approve_sangsi->order_by('URUTAN','ASC')->get_all();
		$poin = $this->input->post('poin_adj');
		$reason = $this->input->post('reason_adj');

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Submit adj','SUMBIT',$this->input->ip_address());
				$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		foreach ($poin as $key => $value) {
			$this->vnd_header->update(array('STATUS_ADJ' => 1), array('VENDOR_NO' => $key));
			$data['VENDOR_NO'] = $key;
			$data['VALUE'] = $value;
			$data['REASON'] = $reason[$key];
			$data['STATUS'] = 1;
			$data['IS_DONE'] = count($list_app)+1;
			$id_rekap =$this->vnd_perf_rekap->insert($data);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_performance_management/submit_adj','vnd_perf_rekap','insert',$data);
			//--END LOG DETAIL--//
			foreach ($list_app as $key => $value) {
				$data['ID_REKAP'] = $id_rekap;
				$data['APPROVED_BY'] = $value['EMP_ID'];
				$data['URUTAN'] = $key+1;
				$this->vnd_perf_rekap_approve->insert($data);
				//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Vendor_performance_management/submit_adj','vnd_perf_rekap_approve','insert',$data);
				//--END LOG DETAIL--//
			}
		}
		redirect('Vendor_performance_management/list_bad_performance');
	}

	private function sort_total($a, $b)
	{
		return intval($a['TOTAL']) > intval($b['TOTAL']);
	}


	public function list_good_performance(){
		$this->load->model(array('v_vnd_perf_total','vnd_perf_mst_category','vnd_perf_hist'));
		$data['title'] = "List Good Performance Vendor";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();

		$category = $this->vnd_perf_mst_category->where('DURATION >', '0')->order_by('START_POINT','DESC')->get_all();
		$min_poin = $category[0]['START_POINT'];
		$this->v_vnd_perf_total->join_all_field_vnd_header();
		$vnd_perf_total = $this->v_vnd_perf_total->get(array('TOTAL >'=> $min_poin));
		
		usort($vnd_perf_total, array($this, 'sort_total'));

		$data['vendor'] = $vnd_perf_total;
		$this->layout->add_js(base_url().'Assets/Vendor_performance_management/assets/vnd_perf_management.js', TRUE);
		$this->layout->render('list_good_performance', $data);
	}



	public function submit_rekap_vendor(){
		$vendor_no = $this->input->post('VENDOR_NO');
		$criteria_name = $this->input->post('criteria_name');
		$sign = $this->input->post('sign');
		$value = $this->input->post('value');
		$Reason = $this->input->post('Reason');
		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Rekap Vendor','SUBMIT',$this->input->ip_address());
				$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$this->load->model(array('vnd_header','vnd_perf_rekap','vnd_perf_rekap_approve'));
		$this->vnd_header->update(array('STATUS_SANGSI' => 1), array('VENDOR_NO' => $vendor_no));
		//--LOG DETAIL--//
			$dat = array('STATUS_SANGSI' => 1);
			$wher = array('VENDOR_NO' => $vendor_no);
			$this->log_data->detail($LM_ID,'Vendor_performance_management/submit_rekap_vendor','vnd_header','update',$dat,$wher);
		//--END LOG DETAIL--//
		$data['VENDOR_NO'] = $vendor_no;
		$data['CRITERIA'] = $criteria_name;
		$data['SIGN'] = $sign;
		$data['VALUE'] = $value;
		$data['REASON'] = $Reason;
		$this->vnd_perf_rekap->insert($data);
		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_performance_management/submit_rekap_vendor','vnd_perf_rekap','insert',$data);
		//--END LOG DETAIL--//

	}

	public function rekap_vendor($vendor_code){
		$this->load->model(array('vnd_perf_hist','vnd_header','vnd_perf_criteria','v_vnd_perf_total'));
		$vnd_no = $vendor_code;

		$data['title'] = "Rekap Penilaian Vendor";

		$vendors = $this->vnd_header->get(array('VENDOR_NO' => $vnd_no));
		$tot = $this->v_vnd_perf_total->get(array('VENDOR_CODE' => $vnd_no));

		$data['vendor_information'] = $vendors;
		$data['vendor_performance']  = $this->vnd_perf_hist->get(array("VENDOR_CODE" => $vnd_no));
		$data['performance_criteria'] = $this->vnd_perf_criteria->get(array("CRITERIA_TRIGGER_BY !=" => '0'));

		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js(base_url().'Assets/Vendor_performance_management/assets/vnd_perf_management.js', TRUE);
		$this->layout->render('rekap_vendor_performance', $data);
	}





	private function sort_item($a, $b)
	{
		return intval($a['TOTAL']) > intval($b['TOTAL']);
	}

	public function form_nilai_vendor($vnd_no = null) {
		$this->load->model('vnd_header');
		$this->load->model('vnd_perf_criteria');
		$this->load->model('vnd_perf_tmp');

		$data['title'] = 'Form Nilai Vendor non Procurement';
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();

		if ($vnd_no == null) {
			$data['vendor'] = $this->vnd_header->get_all(array('VENDOR_NO is not null' => null));
			$this->layout->render('form_nilai_vendor', $data);
		} else {
			$this->vnd_perf_tmp->join_vnd();
			$data['penilaian'] = $this->vnd_perf_criteria->get(array('CRITERIA_TRIGGER_BY' => 1, 'T_OR_V' => 'V'));
			$data['vendor'] = $this->vnd_header->get(array('VENDOR_NO' => $vnd_no));
			$this->layout->render('form_nilai_vendor_detail', $data);
		}
	}

	public function insert_nilai_vendor() {
		$this->load->model('vnd_perf_tmp');
		$vendor_code = $this->input->post('vendor_no');

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Input Penilaian Vendor','SAVE',$this->input->ip_address());
				$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		foreach ($this->input->post('criteria') as $row) {
			$data = array(
				'PERF_TMP_ID' => $this->vnd_perf_tmp->get_id(),
				'VENDOR_CODE' => $vendor_code,
				'DATE_CREATED' => date(timeformat()),
				'SIGN' => $row['sign'],
				'POIN' => $row['skor'],
				'CRITERIA_ID' => $row['criteria_id'] ,
				'KETERANGAN'=> $row['keterangan'] ,
				'STATUS' => 0 ,
				'EXTERNAL_CODE' => NULL
			);
			$this->vnd_perf_tmp->insert($data);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_performance_management/submit_rekap_vendor','vnd_perf_tmp','insert',$data);
			//--END LOG DETAIL--//
			$this->create_approval($data['PERF_TMP_ID']);
		}
		$this->session->set_flashdata('success', 'success');
		redirect('Vendor_performance_management/form_nilai_vendor');
	}

	public function delete_nilai_vendor() {
		var_dump($this->input->post());
	}

	public function form_rekap($vnd_no = null) {
		$this->load->model('vnd_header');
		$this->load->model('vnd_perf_criteria');
		$this->load->model('vnd_perf_tmp');

		$data['title'] = 'Form Rekap';
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();

		if ($vnd_no == null) {
			$data['vendor'] = $this->vnd_header->get_all(array('VENDOR_NO is not null' => null, 'VENDOR_ID <' => 200));
			$this->layout->render('form_rekap', $data);
		} else {
			$this->vnd_perf_tmp->join_vnd();
			$data['penilaian'] = $this->vnd_perf_criteria->get(array('CRITERIA_TRIGGER_BY' => 1, 'T_OR_V' => 'V'));
			$data['vendor'] = $this->vnd_header->get(array('VENDOR_NO' => $vnd_no));
			$this->layout->render('form_rekap_detail', $data);
		}
	}

	public function insert_rekap() {
		//var_dump($this->input->post());
		$this->load->model('vnd_perf_tmp');
		$vendor_code = $this->input->post('vendor_no');

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'], $this->authorization->getCurrentRole(),'Input Rekap Penilaian','SAVE',$this->input->ip_address());
				$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		$data = array(
				'PERF_TMP_ID' => $this->vnd_perf_tmp->get_id(),
				'VENDOR_CODE' => $vendor_code,
				'DATE_CREATED' => date(timeformat()),
				'SIGN' => $this->input->post('sign'),
				'POIN' => $this->input->post('skor'),
				'CRITERIA_ID' => $this->input->post('criteria_id') ,
				'KETERANGAN'=> $this->input->post('keterangan') ,
				'STATUS' => 0 ,
				'EXTERNAL_CODE' => NULL
		);
		$this->vnd_perf_tmp->insert($data);
		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_performance_management/insert_rekap','vnd_perf_tmp','insert',$data);
		//--END LOG DETAIL--//
		$this->create_approval($data['PERF_TMP_ID']);
		$this->session->set_flashdata('success', 'success');
		redirect('Vendor_performance_management/form_rekap');
	}



	public function approve_rekap() {
		var_dump($this->input->post());
	}

	private function create_approval($tmp_id) {
		$this->load->model('adm_employee_atasan');
		$this->load->model('vnd_perf_approve');

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'], $this->authorization->getCurrentRole(),'Create Approval Penilaian','OK',$this->input->ip_address());
				$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$atasans = $this->adm_employee_atasan->get_atasan($this->authorization->getEmployeeId(), 'BIRO');
		$urutan = 1;
		$new_apprv['TMP_ID'] = $tmp_id;
		$new_apprv['STATUS_APRV'] = 0;
		foreach ($atasans as $atasan) {
			$new_apprv['APPROVE_ID'] = $this->vnd_perf_approve->get_last_id() + 1;
			$new_apprv['EMP_ID'] = $atasan['id_atasan'];
			$new_apprv['URUTAN'] = $urutan++;
			$this->vnd_perf_approve->insert($new_apprv);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_performance_management/create_approval','vnd_perf_tmp','insert',$data);
			//--END LOG DETAIL--//
		}

	}

	public function reload(){
		redirect('Vendor_management/job_list');
	}

	/*
	*fungsi untuk menampilkan monitor penilaian vendor
	*
	*/
	public function monitor(){
		$this->load->model(array('vnd_perf_hist'));
		$begin_month = date('1 M y H:i:s');
		$current_date = date('d M y H:i:s');
		$data['title'] = "Monitor Penilaian Vendor";
		$data['start'] = $begin_month;
		$data['end'] = $current_date;
		$this->layout->set_datetimepicker();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();		
		$this->layout->add_js("strTodatetime.js");	
		$this->layout->add_js('pages/monitor_vendor_performance.js');
		$this->layout->render('monitor_vendor_performance', $data);
	}

	public function get_monitor_vendor(){
		$this->load->model(array('vnd_perf_hist'));
		$length = $this->input->post('length');
		$start = $this->input->post('start');				
		$draw = $this->input->post('draw');	
		$opco = $this->session->userdata['KEL_PRGRP'];

		$datatable = $this->vnd_perf_hist->get_all_performance($length,$start,$draw,$opco); 		
		echo json_encode($datatable);
	}

	public function detail_monitor(){
		$vendor_no = $this->input->post('VENDOR_NO');
		if(!empty($vendor_no)){			
			$data['title'] = "Detail Monitor Penilaian Vendor";
			$this->load->model(array('vnd_perf_hist','vnd_header','vnd_perf_criteria','vnd_perf_tmp'));
			$vendor = $this->vnd_header->get(array('VENDOR_NO' => $vendor_no));
			$hist = $this->vnd_perf_hist->get_vendor_all_performance($vendor_no);			
			$data['vendor_performance']  = $hist;
			$data['vendor_information'] = $vendor;			            
			$this->layout->set_table_js();
			$this->layout->set_table_cs();				
			$this->layout->render('detail_monitor_vendor', $data);
		}
		else {
			redirect(site_url('Vendor_performance_management/monitor'));
		}
	}
}
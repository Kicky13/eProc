<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_Performance_Freeze extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index() {
		redirect('Vendor_performance_freeze/vendor_freeze_list');
	}

	public function vendor_freeze_list() {
		$this->load->model(array('vnd_perf_hist'));
		$begin_month = date('1 M y H:i:s');
		$current_date = date('d M y H:i:s');
		$data['title'] = "Form Rekap Penilaian Vendor";
		$data['start'] = $begin_month;
		$data['end'] = $current_date;
		$this->layout->set_datetimepicker();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();		
		$this->layout->add_js("strTodatetime.js");	
		$this->layout->add_js('pages/vendor_performance_freeze.js');
		$this->layout->render('vendor_freeze_list', $data);
	}

	public function get_all_vendor_freeze(){
		$this->load->model(array('vnd_perf_hist'));
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');		
		$periode_awal = oracledate(strtotime($this->input->post('awal')));
		$periode_akhir = oracledate(strtotime($this->input->post('akhir')));

		$opco = $this->session->userdata['KEL_PRGRP'];

		$datatable = $this->vnd_perf_hist->get_last_poin_by_period($periode_awal,$periode_akhir,$opco); 
		$data = array(
				'data' => $datatable,
			);
		echo json_encode($data);
	}

	public function get_all_vendor_freeze_excel($awal=0,$akhir=0){
		$this->load->model(array('vnd_perf_hist'));		

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=rekap_penilaian_vendor.xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		$kel_opco = $this->session->userdata['KEL_PRGRP'];
		$opco = $this->session->userdata['EM_COMPANY'];
		if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
			$opco = '7000,2000,5000';
			$idop = '1';
			$name_opco = 'PT. SEMEN INDONESIA';
			$addres = 'Jl. Veteran, Gresik 61122, Jawa Timur, Indonesia';
		} else if ($opco == '3000') {
			$opco = '3000';
			$idop = '2';
			$name_opco = 'PT. SEMEN PADANG';
			$addres = 'Indarung Padang 25237, Sumatera Barat';
		} else if ($opco == '4000'){
			$opco = '4000';
			$idop = '3';
			$name_opco = 'PT. SEMEN TONASA';
			$addres = 'Biringere, Pangkep, Sulawesi Selatan, 90651';
		}	

		$periode_awal = oracledate(strtotime($awal));
		$periode_akhir = oracledate(strtotime($akhir));

		$data_vendor = $this->vnd_perf_hist->get_last_poin_by_period($periode_awal,$periode_akhir,$kel_opco); 

		$data['data_his'] = $data_vendor;
		$data['name_opco'] = $name_opco;
		$data['idopco'] = $idop;
		$data['alamat'] = $addres;
        $this->load->view('excel_penilaian', $data);
	}

	public function detail_vendor_freeze(){
		$vendor_no=$this->input->post('VENDOR_NO');
		$start=$this->input->post('START');
		$end=$this->input->post('END');
		// die(var_dump($vendor_no."|".oracledate(strtotime($start))."|".oracledate(strtotime($end))));
		if(!empty($vendor_no)&&!empty($start)&&!empty($end)){
			$start=oracledate(strtotime($start));
			$end=oracledate(strtotime($end));
			$data['title'] = "Detail Rekap Penilaian Vendor";
			$this->load->model(array('vnd_perf_hist','vnd_header','vnd_perf_criteria','vnd_perf_tmp'));
			$vendor = $this->vnd_header->get(array('VENDOR_NO' => $vendor_no));
			$hist = $this->vnd_perf_hist->get_vendor_by_period_ordered($vendor_no,$start,$end);
			$data['start'] = $start;
			$data['end'] = $end;
			$data['vendor_performance']  = $hist;
			$data['vendor_information'] = $vendor;
			            
			$this->layout->set_table_js();
			$this->layout->set_table_cs();				
			$this->layout->add_js("swal.js");
			$this->layout->add_js("sweetalert2.min.js");
			$this->layout->add_js('pages/detail_vendor_freeze.js');
			$this->layout->render('detail_vendor_freeze', $data);
		}
		else {
			$this->session->set_flashdata('start', date('d M y H:i:s',strtotime($start)));
			$this->session->set_flashdata('end', date('d M y H:i:s',strtotime($end)));				
			redirect(site_url('Vendor_performance_freeze/vendor_freeze_list'));
		}
	}

	public function freeze(){
		$this->load->model(array('vnd_perf_hist','vnd_perf_rekap','vnd_perf_rekap_approve','vendor_employe'));
		
		$current_date = oracledate(strtotime(date("d-m-Y H:i:s")));

		//--LOG MAIN NYO --//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Perfomance Freeze ( Input Adjusment )','SAVE',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		
		$post=$this->input->post();
		$start = date('d M y H:i:s',strtotime($post['start']));
		$end = date('d M y H:i:s',strtotime($post['end']));
		$data['VENDOR_NO'] = "'".$post['VENDOR_NO']."'";
		$data['VALUE'] = $post['adj_point'];
		$data['REKAP_DATE'] = $current_date;
		$data['START_DATE'] = oracledate(strtotime($post['start']));
		$data['END_DATE'] = oracledate(strtotime($post['end']));
		$data['REASON'] = "'".$post['Reason']."'";
		$data['STATUS'] = 0;
		$data['IS_DONE'] = 0;


		$ada_yg_blm_apv = $this->vnd_perf_rekap->get(array('VENDOR_NO'=>$post['VENDOR_NO'],'IS_DONE'=>0));		
		if(count($ada_yg_blm_apv)>0){
			//ada rekap yang belum diapprove
			$this->session->set_flashdata('failed', 'Rekap Gagal, ada rekap sebelumnya yg belum di-Approve');
			redirect(site_url('Vendor_performance_freeze/vendor_freeze_list'));
		}
		
		if($this->vnd_perf_rekap->insert($data)){
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_performance_freeze/freeze','vnd_perf_rekap','insert',$data);
			//--END LOG DETAIL--//
			$rekap_id=$this->vnd_perf_rekap->get_last_id();
			$data_hist['REKAP_ID']=$rekap_id;
			$where_hist['VENDOR_CODE']=$post['VENDOR_NO'];
			$where_hist['VENDOR_CODE']=$post['VENDOR_NO'];
			$where_hist['DATE_CREATED >=']=$data['START_DATE'];
			$where_hist['REKAP_ID']=null;
			if($this->vnd_perf_hist->update($data_hist,$where_hist)){
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_performance_freeze/freeze','vnd_perf_hist','update',$data_hist,$where_hist);
			//--END LOG DETAIL--//				
				$data_new_hist = array(
					'VENDOR_CODE'=>$post['VENDOR_NO'],
					'DATE_CREATED'=>$current_date,
					'KETERANGAN'=>'Rekap',
					'POIN_ADDED'=>$post['value'],
					'SIGN'=>$post['sign'],
					'IGNORED'=>0,
					'POIN_PREV'=>$post['total_point'],
					'POIN_CURR'=>$post['adj_point'],
					'CRITERIA_ID'=>NULL,
					'TMP_ID'=>NULL,
					'REKAP_ID'=>$rekap_id
					);
				if($this->vnd_perf_hist->insert_custom($data_new_hist)){
					//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Vendor_performance_freeze/freeze','vnd_perf_rekap','insert',$data_new_hist);
					//--END LOG DETAIL--//
					$atasan = $this->vendor_employe->get_by_level(2);					
					$data_approve = array(
						'ID_REKAP'=>$rekap_id,
						'APPROVED_BY'=>$atasan[0]['EMP_ID'],
						'APPROVED_DATE'=>NULL,
						'URUTAN'=>2, 
						'STATUS'=>0
						);  
					if($this->vnd_perf_rekap_approve->insert($data_approve)){
						//--LOG DETAIL--//
							$this->log_data->detail($LM_ID,'Vendor_performance_freeze/freeze','vnd_perf_rekap_approve','insert',$data_approve);
						//--END LOG DETAIL--//
						$this->session->set_flashdata('success', 'Freeze success');
						$this->session->set_flashdata('start', $start);
						$this->session->set_flashdata('end', $end);
						redirect(site_url('Vendor_performance_freeze/vendor_freeze_list'));
					}
				}else{
					//insert hist failed
					$this->session->set_flashdata('failed', 'insert hist failed');
					redirect(site_url('Vendor_performance_freeze/vendor_freeze_list'));
				}
				
			}else{
				//update hist failed
				$this->session->set_flashdata('failed', 'update hist failed');
				redirect(site_url('Vendor_performance_freeze/vendor_freeze_list'));
			}
		}else{
			//insert rekap failed
			$this->session->set_flashdata('failed', 'insert rekap failed');
			redirect(site_url('Vendor_performance_freeze/vendor_freeze_list'));
		}
	}
	public function rekap_approval(){
		//$this->load->model(array('vnd_perf_hist'));
		$data['title'] = "Persetujuan Rekap Penilaian Vendor";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();		
		$this->layout->add_js("strTodatetime.js");				
		$this->layout->add_js("swal.js");
		$this->layout->add_js("sweetalert2.min.js");	
		$this->layout->add_js('pages/vendor_performance_freeze_approval.js');
		$this->layout->render('vendor_freeze_approval', $data);
	}

	public function get_all_freeze_approval(){
		$this->load->model(array('vnd_perf_hist','vnd_perf_rekap','vnd_perf_rekap_approve','adm_employee'));
		$emp_id = $this->authorization->getEmployeeId();
		//$emp_id = 2;//ini di hardcode dulu 
		$datatable = $this->vnd_perf_rekap_approve->get_non_approve($emp_id); 
		$data = array(
				'data' => $datatable,
			);
		echo json_encode($data);
	}

	public function get_value_sanction(){
		$nilai = $this->input->post('nilai');
		// die(var_dump($nilai));
		$this->load->model('vnd_perf_m_sanction');
		$sanksi=$this->vnd_perf_m_sanction->get_sanction_view($nilai);

		if (count($sanksi) != '') {
			$sanksi=$sanksi[0];
	  		$value = 'Suspend '.$sanksi['DURATION'].' hari ('.$sanksi['SANCTION_NAME'].')';
	  		$data = $value;
			
			echo json_encode($data);
		}else{
			echo json_encode('0');
		}
	}

	public function detail_freeze_approval(){
		$id_approve = $this->input->post('ID_REKAP_APPROVE');
		$data['title'] = "Detail Persetujuan Rekap Penilaian Vendor";
		$this->load->model(array('vnd_header','vnd_perf_hist','vnd_perf_rekap_approve'));
		$approve = $this->vnd_perf_rekap_approve->get_detail_by_id($id_approve);
		$vendor = $this->vnd_header->get(array('VENDOR_NO' => $approve[0]['VENDOR_CODE']));
		$rekap_hist = $this->vnd_perf_hist->get_rekap($approve[0]['ID_REKAP']);
		$data['vendor_performance']  = $approve;
		$data['vendor_information'] = $vendor;
		$data['rekap'] = $rekap_hist[0];
		$data['id_rekap_approve'] = $id_approve;		
		$data['id_rekap'] = $approve[0]['ID_REKAP'];
		$data['id_hist'] = $rekap_hist[0]['PERF_HIST_ID'];

		$this->layout->set_table_js();
		$this->layout->set_table_cs();				
		$this->layout->add_js("swal.js");
		$this->layout->add_js("sweetalert2.min.js");		
		$this->layout->add_js("strTodatetime.js");	
		$this->layout->add_js('pages/detail_vendor_freeze.js');
		$this->layout->render('detail_freeze_approval', $data);
	}

	public function approve(){
		$this->load->model(array('vnd_perf_rekap','vnd_perf_hist','vnd_perf_rekap_approve','vendor_employe','vnd_perf_m_sanction','vnd_perf_sanction'));

		//--LOG MAIN NYO --//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Perfomance Freeze ( Appove performance )','APPROVAL',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$post = $this->input->post();
		$id_rekap_approve = $post['id_rekap_approve'];
		$id_rekap = $post['id_rekap'];
		$id_hist = $post['id_hist'];
		$current_date = oracledate(strtotime(date("d-m-Y H:i:s")));
		$data_update = array(
			'APPROVED_DATE'=>$current_date,
			'STATUS'=>1
			);
		$where_update['ID_REKAP_APPROVE'] = $id_rekap_approve;
		if($this->vnd_perf_rekap_approve->update($data_update,$where_update)){
			$emp_id = $this->authorization->getEmployeeId();
			$employee = $this->vendor_employe->getemplo($emp_id);
			$level = $employee[0]['LEVEL']+1;
			if($level==3){
				$atasan = $this->vendor_employe->get_by_level($level);					
				$data_approve = array(
					'ID_REKAP'=>$id_rekap,
					'APPROVED_BY'=>$atasan[0]['EMP_ID'],
					'APPROVED_DATE'=>NULL,
					'URUTAN'=>3, 
					'STATUS'=>0
					);  
					$this->vnd_perf_rekap_approve->insert($data_approve);
					//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Vendor_performance_freeze/approve','vnd_perf_rekap_approve','insert',$data_approve);
					//--END LOG DETAIL--//
			}
			if($level==4){
				$nilai = $post['adj_point'];
				$sanksi=$this->vnd_perf_m_sanction->get_sanction($nilai);
				if(count($sanksi)>0){
					$sanksi=$sanksi[0];
					$rekap=$this->vnd_perf_rekap->get(array('ID_REKAP'=>$id_rekap));				
					$rekap=$rekap[0];
					$data_sanksi=array(
						'VENDOR_NO'=>"'".$rekap['VENDOR_NO']."'",
						'START_DATE'=>$current_date,
						'END_DATE'=>oracledate(strtotime(date("d-m-Y H:i:s",strtotime("+ ".$sanksi['DURATION']." days")))),
						'REASON'=>"'Poin telah mencapai (".$nilai.")'",
						'M_SANCTION_ID'=>$sanksi['M_SANCTION_ID'],
						'STATUS'=>1
						);
					if(!$this->vnd_perf_sanction->cek_and_insert($data_sanksi)){
						//--LOG DETAIL--//
							$this->log_data->detail($LM_ID,'Vendor_performance_freeze/approve','vnd_perf_sanction','insert',$data_sanksi);
						//--END LOG DETAIL--//
						$this->session->set_flashdata('failed', 'Insert Sanksi failed');						
						redirect(site_url('Vendor_performance_freeze/rekap_approval'));
					}
				}				
			}
			$data_rekap = array('STATUS'=>1,'VALUE'=>$post['adj_point'],'IS_DONE'=>($level==4?1:0));
			$where_rekap['ID_REKAP']=$id_rekap;
			if($this->vnd_perf_rekap->update($data_rekap,$where_rekap)){
				//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Vendor_performance_freeze/approve','vnd_perf_rekap','update',$data_rekap,$where_rekap);
				//--END LOG DETAIL--//	
				$data_hist = array(					
					'POIN_ADDED'=>$post['value'],
					'SIGN'=>$post['sign'],
					'IGNORED'=>0,
					'POIN_PREV'=>$post['total_point'],
					'POIN_CURR'=>$post['adj_point'],
					'CRITERIA_ID'=>NULL,
					'TMP_ID'=>NULL,
					'REKAP_ID'=>$id_rekap
					);
				$where_hist['PERF_HIST_ID']=$id_hist;
				if($this->vnd_perf_hist->update($data_hist,$where_hist)){
					//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Vendor_performance_freeze/approve','vnd_perf_hist','update',$data_hist,$where_hist);
					//--END LOG DETAIL--//	
					$freeze=$this->vnd_perf_rekap->get(array('ID_REKAP'=>$id_rekap));
					$freeze=$freeze[0];
					$after_rekap = $this->vnd_perf_hist->get(array('VENDOR_CODE'=>$freeze['VENDOR_NO'],'PERF_HIST_ID >'=>$id_hist));
					$jml_after_rekap=count($after_rekap);
					if($jml_after_rekap>0){
						$tampung=0;
						for ($i=0;$i<$jml_after_rekap;$i++) {
							if($i==0){
								$data_updt['POIN_PREV']=$post['adj_point'];
							}else{
								$nilai_sebelumnya = $this->vnd_perf_hist->get(array('VENDOR_CODE'=>$freeze['VENDOR_NO'],'PERF_HIST_ID'=>$after_rekap[$i-1]['PERF_HIST_ID']));
								$data_updt['POIN_PREV']=$nilai_sebelumnya[0]['POIN_CURR'];
							}
							if($after_rekap[$i]['SIGN']=='+'){
								$data_updt['POIN_CURR']=$data_updt['POIN_PREV']+$after_rekap[$i]['POIN_ADDED'];	
							}
							if($after_rekap[$i]['SIGN']=='-'){
								$data_updt['POIN_CURR']=$data_updt['POIN_PREV']-$after_rekap[$i]['POIN_ADDED'];	
							}
							$where_updt['PERF_HIST_ID']=$after_rekap[$i]['PERF_HIST_ID'];
							$this->vnd_perf_hist->update($data_updt,$where_updt);
							//--LOG DETAIL--//
								$this->log_data->detail($LM_ID,'Vendor_performance_freeze/approve','vnd_perf_hist','update',$data_updt,$where_updt);
							//--END LOG DETAIL--//	
						}
					}
					$this->session->set_flashdata('success', 'Approve Freeze success');						
					redirect(site_url('Vendor_performance_freeze/rekap_approval'));
				}else{
					$this->session->set_flashdata('failed', 'Update Hist failed');						
					redirect(site_url('Vendor_performance_freeze/rekap_approval'));
				}
			}else{
				$this->session->set_flashdata('failed', 'Update Rekap failed');						
				redirect(site_url('Vendor_performance_freeze/rekap_approval'));
			}
				
			
		}else{
			$this->session->set_flashdata('failed', 'Approved failed');						
			redirect(site_url('Vendor_performance_freeze/rekap_approval'));
		}
	}

	public function approve_selected(){
		$this->load->model(array('vnd_perf_rekap','vnd_perf_hist','vnd_perf_rekap_approve','vendor_employe','vnd_perf_m_sanction','vnd_perf_sanction'));

		//--LOG MAIN NYO --//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Perfomance Freeze ( Appove Selected )','APPROVAL',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$post=$this->input->post();
		$status_error=false;
		if(!isset($post['check_freeze'])){
			$this->session->set_flashdata('failed', 'No Selected Data to Approve');
			redirect(site_url('Vendor_performance_freeze/rekap_approval'));
		}
		foreach ($post['check_freeze'] as $key => $value) {
			$id_rekap_approve = $value;
			$current_date = oracledate(strtotime(date("d-m-Y H:i:s")));
			$data_update = array(
				'APPROVED_DATE'=>$current_date,
				'STATUS'=>1
				);
			$where_update['ID_REKAP_APPROVE'] = $id_rekap_approve;
			$id_rekap = $this->vnd_perf_rekap_approve->get($where_update);
			$id_rekap = $id_rekap[0]['ID_REKAP'];
			if($this->vnd_perf_rekap_approve->update($data_update,$where_update)){
				//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Vendor_performance_freeze/approve_selected','vnd_perf_rekap_approve','update',$data_update,$where_update);
				//--END LOG DETAIL--//	
				$emp_id = $this->authorization->getEmployeeId();
				$employee = $this->vendor_employe->getemplo($emp_id);
				$level = $employee[0]['LEVEL']+1;
				if($level==3){
					$atasan = $this->vendor_employe->get_by_level($level);					
					$data_approve = array(
						'ID_REKAP'=>$id_rekap,
						'APPROVED_BY'=>$atasan[0]['EMP_ID'],
						'APPROVED_DATE'=>NULL,
						'URUTAN'=>3, 
						'STATUS'=>0
						);  
						if(!$this->vnd_perf_rekap_approve->insert($data_approve)){
							//--LOG DETAIL--//
								$this->log_data->detail($LM_ID,'Vendor_performance_freeze/approve_selected','vnd_perf_rekap_approve','insert',$data_approve);
							//--END LOG DETAIL--//
							$status_error=true;
						}
				}
				if($level==4){				
				$rekap=$this->vnd_perf_rekap->get(array('ID_REKAP'=>$id_rekap));				
				$rekap=$rekap[0];				
				$nilai = $rekap['VALUE'];
				$sanksi=$this->vnd_perf_m_sanction->get_sanction($nilai);
				if(count($sanksi)>0){
					$sanksi=$sanksi[0];
					$data_sanksi=array(
						'VENDOR_NO'=>"'".$rekap['VENDOR_NO']."'",
						'START_DATE'=>$current_date,
						'END_DATE'=>oracledate(strtotime(date("d-m-Y H:i:s",strtotime("+ ".$sanksi['DURATION']." days")))),
						'REASON'=>"'Poin telah mencapai (".$nilai.")'",
						'M_SANCTION_ID'=>$sanksi['M_SANCTION_ID'],
						'STATUS'=>1
						);
					if(!$this->vnd_perf_sanction->cek_and_insert($data_sanksi)){
						//--LOG DETAIL--//
							$this->log_data->detail($LM_ID,'Vendor_performance_freeze/approve_selected','vnd_perf_sanction','insert',$data_sanksi);
						//--END LOG DETAIL--//
						$status_error=true;
					}
				}
			}

				$data_rekap = array('STATUS'=>1,'IS_DONE'=>($level==4?1:0));
				$where_rekap['ID_REKAP']=$id_rekap;
				if(!$this->vnd_perf_rekap->update($data_rekap,$where_rekap)){
					//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Vendor_performance_freeze/approve_selected','vnd_perf_rekap','update',$data_rekap,$where_rekap);
					//--END LOG DETAIL--//	
					$status_error=true;
				}
			}else{
				$status_error=true;
			}
		}

		if(!$status_error){
			$this->session->set_flashdata('success', 'Approve Freeze success');						
			redirect(site_url('Vendor_performance_freeze/rekap_approval'));
		}else{
			$this->session->set_flashdata('failed', 'Approved failed');						
			redirect(site_url('Vendor_performance_freeze/rekap_approval'));
		}
		
	}
}
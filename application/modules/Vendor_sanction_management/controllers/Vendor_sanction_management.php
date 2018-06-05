<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_Sanction_Management extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
	}

	public function index() {				
		redirect('Vendor_sanction_management/vendor_sanction');
	}

	public function vendor_sanction(){
		$data['title'] = "Monitoring Sanksi Vendor";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js("swal.js");
		$this->layout->add_js("sweetalert2.min.js");
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('pages/vendor_sanction.js');
		$this->layout->render('vnd_vendor_sanction', $data);
	}

	public function get_vendor_sanction(){
		$this->load->model(array('vnd_perf_sanction'));	
		$opco = $this->session->userdata['EM_COMPANY'];
		$prod = $this->input->post('item');

		$data = $this->vnd_perf_sanction->get_all_vendor($opco,$prod);
		echo json_encode(array('data'=>$data));
	}

	public function get_detail_vendor_sanction(){
		$vendor_no=$this->input->post('vendor_no');
		$this->load->model(array('vnd_perf_sanction'));		
		$data = $this->vnd_perf_sanction->get_all_detail_vendor_sanction($vendor_no); 
		echo json_encode(array('data'=>$data));
	}

	public function detail_sanction($vendor_no){
		$this->load->model(array('vnd_header','vnd_perf_sanction','vnd_perf_m_sanction','vnd_perf_sanction_approve','vendor_employe'));
		$data['title'] = "Detail Sanksi Vendor";
		$data['vendor_information']=$this->vnd_header->get(array('VENDOR_NO'=>$vendor_no));
		
		$emp_id = $this->authorization->getEmployeeId();
		$employee = $this->vendor_employe->getemplo($emp_id);
		$level = $employee[0]['LEVEL']+1;
		$data['level']=$level;
		
		$data_sanction = $this->vnd_perf_sanction->get_all_detail_vendor_sanction($vendor_no,1);		
		
		$data['SANCTION_ID'] = 0;
		if(count($data_sanction)>0){
			$data_sanction = $data_sanction[0];
			$data['SANCTION_ID']=$data_sanction['SANCTION_ID'];
			if($level>2){
				$data_approve = $this->vnd_perf_sanction_approve->get(array('APPROVED_BY'=>$emp_id,'SANCTION_ID'=>$data_sanction['SANCTION_ID']));
				if(count($data_approve)>0){
					$data_approve = $data_approve[0];
					if($data_approve['STATUS']==1){
						$data['APPROVED'] = false;	
						$data['is_approving'] = true;	
					}else{
						$data['APPROVED'] = false;	
						$data['is_approving'] = false;	
					}
					$data['alasan'] = $data_approve['ALASAN'];			
				}else{					
					$data['APPROVED'] = false;
					$data['is_approving'] = false;
				}

			}else{			
				$data_approve = $this->vnd_perf_sanction_approve->get(array('SANCTION_ID'=>$data_sanction['SANCTION_ID']));			
				if(count($data_approve)>0){
					$data['APPROVED'] = false;
					$data['is_approving'] = false;	
					foreach ($data_approve as $key => $value) {					
						if($value['STATUS']==0){
							$data['APPROVED'] = false;
							$data['is_approving'] = true;	
						}
					}
					
				}else{
					$data['APPROVED'] = false;
					$data['is_approving'] = false;
				}
				
			}
		}else{
			$data['APPROVED'] = true;
			$data['is_approving'] = false;
		}

		$this->vnd_perf_sanction_approve->join_employe();
		$data['santion_comment'] = $this->vnd_perf_sanction_approve->get(array('SANCTION_ID'=>$data_sanction['SANCTION_ID']));

		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js("swal.js");
		$this->layout->add_js("sweetalert2.min.js");
		$this->layout->add_js('pages/detail_sanction.js');
		$this->layout->render('vnd_detail_sanction', $data);
	}

	public function master_sanction($id=null){
		$this->load->model(array('vnd_perf_m_sanction'));
		if(!empty($id)){
			$data = $this->edit_master_sanction($id);
		}

		$data['title'] = "Master Sanksi Vendor";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js("swal.js");
		$this->layout->add_js("sweetalert2.min.js");
		$this->layout->add_js('pages/vendor_master_sanction.js');
		$this->layout->render('vnd_master_sanction', $data);
	}

	
	public function save_master_sanction() {
		$this->load->model(array('vnd_perf_m_sanction'));
		$data['M_SANCTION_ID']=$this->input->post('id_master_sanksi');
		$data['SANCTION_NAME']=$this->input->post('nama_sanksi');
		$data['CATEGORY']=$this->input->post('jenis_sanksi');
		$data['LOWER']=$this->input->post('batas_bawah');
		$data['UPPER']=$this->input->post('batas_atas');
		$data['DURATION']=$this->input->post('lama_sanksi');
		$data['STATUS']=$this->input->post('status');
		$ada = $this->vnd_perf_m_sanction->get_by_id($data['M_SANCTION_ID']);		
		//--LOG MAIN NYO --//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Vendor Sanction ( Input Sanction )','SAVE',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
			
		if(count($ada)>0){
			try{
				if($this->vnd_perf_m_sanction->update($data,array('M_SANCTION_ID'=>$data['M_SANCTION_ID']))){
					//--LOG DETAIL--//
						$where = array('M_SANCTION_ID'=>$data['M_SANCTION_ID']);
						$this->log_data->detail($LM_ID,'Vendor_sanction_management/save_master_sanction','vnd_perf_m_sanction','update',$data,$where);
					//--END LOG DETAIL--//
					$this->session->set_flashdata('success', 'Berhasil disimpan');	
				}
			}
			catch(Exception $e){
				$this->session->set_flashdata('failed', $e->getMessage());						
			}	
		}else{
			try{				
				if($this->vnd_perf_m_sanction->insert($data)){
					//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Vendor_sanction_management/save_master_sanction','vnd_perf_m_sanction','insert',$data);
					//--END LOG DETAIL--//
					$this->session->set_flashdata('success', 'Berhasil disimpan');	
				}
				
			}
			catch(Exception $e){
				$this->session->set_flashdata('failed', $e->getMessage());						
			}
		}
		redirect('Vendor_sanction_management/master_sanction');
	}

	public function get_master_sanction(){
		$this->load->model(array('vnd_perf_m_sanction'));		
		$data = $this->vnd_perf_m_sanction->get(); 
		echo json_encode(array('data'=>$data));
	}

	public function edit_master_sanction($id){
		$this->load->model(array('vnd_perf_m_sanction'));
		$data = $this->vnd_perf_m_sanction->get_by_id($id);
		return $data[0];
	}

	public function delete_master_sanction($id){
		$this->load->model(array('vnd_perf_m_sanction'));
		//--LOG MAIN NYO --//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Vendor Sanction ( Delete Sanction )','Delete',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		if($this->vnd_perf_m_sanction->delete($id)){
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_sanction_management/delete_master_sanction','vnd_perf_m_sanction','delete',null,$id);
			//--END LOG DETAIL--//
			$this->session->set_flashdata('success', 'Berhasil dihapus');	
			redirect('Vendor_sanction_management/master_sanction');
		}
	}

	/*
	*	function ini digunakan untuk memeriksa sisa nilai setelah pembebasan sangsi
	*	kondisi: jika sisa bernilai negatif (-) maka nilai direset menjadi 0,
	*			 lainnya tidak direset.
	*/
	public function cek_reset_sisa_nilai($VENDOR_NO){
		$this->load->model(array('vnd_perf_sanction','vnd_perf_sanction_approve','vendor_employe','vnd_perf_hist'));
		$current_date = oracledate(strtotime(date("d-m-Y H:i:s")));
		$id = $this->vnd_perf_hist->get_max_id_vendor($VENDOR_NO);
		$data = $this->vnd_perf_hist->get(array('PERF_HIST_ID'=>$id));
		//--LOG MAIN NYO --//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Vendor Sanction ( Cek Reset Sisa Nilai )','OK',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
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
				$this->vnd_perf_hist->insert_custom($data_new_hist);
				//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Vendor_sanction_management/cek_reset_sisa_nilai','vnd_perf_hist','insert',$data_new_hist);
				//--END LOG DETAIL--//
			}catch(Exception $e){
				return $e;
			}
		}
	}


	public function free_sanction(){		
		$this->load->model(array('vnd_perf_sanction','vnd_perf_sanction_approve','vendor_employe','vnd_perf_hist'));
		$vendor_no = $this->input->post('vendor_no');
		$alasan = $this->input->post('alasan');
		$SANCTION_ID = $this->input->post('SANCTION_ID');
		//--LOG MAIN NYO --//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Vendor Sanction ( Free Sanction )','OK',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		$current_date = oracledate(strtotime(date("d-m-Y H:i:s")));
		$emp_id = $this->authorization->getEmployeeId();
		$employee = $this->vendor_employe->getemplo($emp_id);
		$level = $employee[0]['LEVEL']+1;
		// $atasan = $this->vendor_employe->get_by_level($level);
		// $id_user = $this->session->userdata['ID'];

		if($level>2){
			$where_approve=array(
				'SANCTION_ID'=>$SANCTION_ID,
				'STATUS'=>0
				);
			$data_update=array(			
				'APPROVED_DATE'=>$current_date,
				'STATUS'=>1
				);
		// die(var_dump($where_approve));

				if(!$this->vnd_perf_sanction_approve->update($data_update,$where_approve)){
					//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Vendor_sanction_management/free_sanction','vnd_perf_sanction_approve','update',$data_update,$where_approve);
					//--END LOG DETAIL--//
					$this->session->set_flashdata('failed', 'Free Sanction failed');
					redirect(site_url('Vendor_management/job_list'));
				}
		}
		if($level<4){
		$data_approve=array(
			'SANCTION_ID'=>$SANCTION_ID,
			'APPROVED_BY'=>$emp_id,
			'APPROVED_DATE'=>$current_date,
			'URUTAN'=>$level,
			'ALASAN'=>"'".$alasan."'",
			'STATUS'=>0
			);

		// die(var_dump($data_approve));
			if($this->vnd_perf_sanction_approve->insert($data_approve)){
				//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Vendor_sanction_management/free_sanction','vnd_perf_sanction_approve','insert',$data_approve);
				//--END LOG DETAIL--//
				$this->session->set_flashdata('success', 'Free Sanction success, waiting approval');		
				if($level<3){					
					redirect(site_url('Vendor_sanction_management/vendor_sanction'));
				}else{					
					redirect(site_url('Vendor_management/job_list'));					
				}
			}
		}
		if($level==4){
			if($this->vnd_perf_sanction->update(array('STATUS'=>0),array('SANCTION_ID'=>$SANCTION_ID))){

			$data_approve=array(
			'SANCTION_ID'=>$SANCTION_ID,
			'APPROVED_BY'=>$emp_id,
			'APPROVED_DATE'=>$current_date,
			'URUTAN'=>$level,
			'ALASAN'=>"'".$alasan."'",
			'STATUS'=>1
			);
				$this->vnd_perf_sanction_approve->insert($data_approve);

			//--LOG DETAIL--//
				$data = array('STATUS'=>0);
				$where = array('SANCTION_ID'=>$SANCTION_ID);
				$this->log_data->detail($LM_ID,'Vendor_sanction_management/free_sanction','vnd_perf_sanction','update',$data,$where);
			//--END LOG DETAIL--//				
				if($e=$this->cek_reset_sisa_nilai($vendor_no)){
					$this->session->set_flashdata('success', 'Free Sanction success');	
				}else{
					$this->session->set_flashdata('success', $e);
				}				
				redirect(site_url('Vendor_management/job_list'));
			}
		}
		
	}
}
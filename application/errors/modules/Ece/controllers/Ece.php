<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ece extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->load->library("file_operation");
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
	}

	public function index() {
		$data['title'] = 'Evaluasi ECE';
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/ece.js');
		$this->layout->render('ece_list', $data);
	}

	public function change($id, $group_id){
		$data['title'] = 'Evaluasi ECE';
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_ece_change_comment');
		$this->load->model('prc_ece_change');
		$this->load->model('adm_employee');
		$this->load->model('adm_employee_atasan');

		$com['comment'] = $this->prc_ece_change_comment->get(array('PTM_NUMBER'=>$id, 'EC_ID_GROUP'=>$group_id));
		$data['ece_comment'] = $this->load->view('Ece/ece_comment', $com, true);

		$data['pec']=NULL;
		$tit_id=0;
		$pec = $this->prc_ece_change->get(array('PTM_NUMBER'=>$id, 'EC_ID_GROUP'=>$group_id));
		foreach ($pec as $val) {
			$data['pec'][$val['TIT_ID']]=$val;
			if($val['TIT_ID'] != $tit_id){
				$tit[]=$val['TIT_ID'];
			}
			$tit_id = $val['TIT_ID'];
		}

		$emp = $this->adm_employee->get(array('ID' => $this->authorization->getEmployeeId()));
		$nopeg = $emp[0]['NO_PEG'];

		$atasan = $this->adm_employee_atasan->get(array('MK_NOPEG' => $nopeg));
		$level = $atasan[0]['ATASAN1_LEVEL'];
		$this->is_kadep = ($level == 'DIR');

		if($this->is_kadep){
			$data['next_process']['nama'] = 'Approve';
		}else{
			$atasan = $this->adm_employee->atasan($this->authorization->getEmployeeId());
			$atasan = $atasan[0];

			$data['next_process']['nama'] = 'Lanjut Approval '.$atasan['FULLNAME'];
		}

			$this->prc_tender_main->join_assign_employee();
		$data['ptm'] = $this->prc_tender_main->ptm($id);
		$data['ptm'] = $data['ptm'][0];

			$this->prc_tender_item->where_in('TIT_ID',$tit);
			$this->prc_tender_item->where_status(7);
		$data['pti'] = $this->prc_tender_item->ptm($id);

		$data['ec_id_group']=$group_id;
		
		$this->load->model('adm_plant');
		$plant_master = $this->adm_plant->get();
		foreach ($plant_master as $val) {
			$data['plant_master'][$val['PLANT_CODE']] = $val;
		}

		$this->layout->add_js('pages/ece.js');
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();	
		$this->layout->add_js('plugins/autoNumeric.js');
		$data['id'] = $id;
		$this->layout->render('ece_detail', $data);

	}

	public function save(){
		$this->load->model(array('prc_tender_main','prc_tender_item','prc_ece_change','prc_nego_hist','prc_ece_change_comment','adm_employee','adm_employee_atasan'));
		$ptm = $this->input->post("ptm");
		$price = $this->input->post("price");
		$ece_id = $this->input->post("ece_id");
		$group_id = $this->input->post("ec_id_group");
		$this->load->library("file_operation");
		
		$item = array();
		foreach ($_FILES['file']['name'] as $key => $value) {
			$data['name'] = $_FILES['file']['name'][$key];
			$data['type'] = $_FILES['file']['type'][$key];
			$data['tmp_name'] = $_FILES['file']['tmp_name'][$key];
			$data['error'] = $_FILES['file']['error'][$key];
			$data['size'] = $_FILES['file']['size'][$key];
			$item[]['file'] = $data;
		}

			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Evaluasi ECE','OK',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		// cek is kadep 
			$emp = $this->adm_employee->get(array('ID' => $this->authorization->getEmployeeId()));
			$nopeg = $emp[0]['NO_PEG'];

			$atasan = $this->adm_employee_atasan->get(array('MK_NOPEG' => $nopeg));
			$level = $atasan[0]['ATASAN1_LEVEL'];
			$this->is_kadep = ($level == 'DIR');

		//end cek is kadep

		$count = 0;
		foreach ($price as $key => $value) {
			if(preg_match("/^[0-9,]+$/", $value)) 
				$value = str_replace(",", "", $value);
			$_FILES = $item[$count];
			$count++;
			$uploaded = $this->file_operation->upload(UPLOAD_PATH.'ece', $_FILES);

			$atasan = $this->adm_employee->atasan($this->authorization->getEmployeeId());
			$atasan = $atasan[0];

			if($this->input->post("ece_update")){
				if ($this->is_kadep) { // approve kadep
					$ece = $this->prc_ece_change->get(array('PTM_NUMBER'=>$ptm, 'EC_ID_GROUP'=>$group_id));
					foreach ($ece as $val) {
						$s = array();
						$s['TIT_STATUS'] = 5;
						$s['TIT_PRICE'] = $val['PRICE_AFTER'];
						$w = array('TIT_ID'=>$val['TIT_ID']);
						$this->prc_tender_item->update($s, $w);
						
						$newhist = array();
						$newhist['HIST_ID'] = $this->prc_nego_hist->get_id();
						$newhist['NEGOSIASI_ID'] = $val['EC_ID'];
						$newhist['PTM_NUMBER'] = $ptm;
						$newhist['NEGOSIASI'] = '3';
						// $newhist['CREATED_AT'] = date(timeformat());
						$this->prc_nego_hist->insert($newhist);
							//--LOG DETAIL--//
						$this->log_data->detail($LM_ID,'Ece/save','prc_nego_hist','insert',$newhist);
							//--END LOG DETAIL--//
					}
					$this->prc_ece_change->update(array('STATUS_APPROVAL'=>1), array('PTM_NUMBER'=>$ptm, 'EC_ID_GROUP'=>$group_id));
						//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Ece/save','prc_ece_change','update',array('STATUS_APPROVAL'=>1), array('PTM_NUMBER'=>$ptm, 'EC_ID_GROUP'=>$group_id));
						//--END LOG DETAIL--//
				} else {	
					$set = array();
					$set['PRICE_AFTER'] = $value;
					// $set['CREATED_AT'] = date(timeformat());
					if(!empty($uploaded['file']['file_name'])){
						$set['DOKUMEN'] = $uploaded['file']['file_name'];
					}
					$set['STATUS_APPROVAL'] = 1;
					$set['USER_APPROVAL'] = $atasan['ID'];
					$where = array('EC_ID'=>$ece_id[$key]);
					$this->prc_ece_change->update($set, $where);
						//--LOG DETAIL--//
					$set2 = array_merge($set, array('TIT_ID'=>$key));
					$this->log_data->detail($LM_ID,'Ece/save','prc_ece_change','update',$set2,$where);
						//--END LOG DETAIL--//
				}

			}else {
				$id = $this->prc_ece_change->get_id();
				$this->prc_tender_item->where_titid($key);
				$pti = $this->prc_tender_item->get();
				$data = array(
					'PRICE_AFTER' => $value,
					// 'CREATED_AT' => date(timeformat()),
					'DOKUMEN' => $uploaded['file']['file_name'],
					'STATUS_APPROVAL' => 1,
					'USER_APPROVAL' => $atasan['ID'],
				);
				$this->prc_ece_change->update($data, array('PTM_NUMBER'=>$ptm, 'EC_ID_GROUP'=>$group_id));
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Ece/save','prc_ece_change','update',$data,array('PTM_NUMBER'=>$ptm, 'EC_ID_GROUP'=>$group_id));
					//--END LOG DETAIL--//
			}
		}

		$comment_id = $this->prc_ece_change_comment->get_id();
		$dataComment = array(
				"ID" => $comment_id,
				"PTM_NUMBER" => $ptm,
				"PEC_COMMENT" => $this->input->post('comment'),
				"PEC_POSITION" => $this->authorization->getCurrentRole(),
				"PEC_NAME" => $this->authorization->getCurrentName(),
				"PEC_START_DATE" => oracledate(strtotime(date("d-m-Y H:i:s"))),
				"EC_ID_GROUP"=>$group_id,
			);
		$this->prc_ece_change_comment->insert($dataComment);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Ece/save','prc_ece_change_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		$this->session->set_flashdata('success', 'Data Berhasil Disimpan.');
		redirect('Ece');
	}

	public function get_datatable() {
		// $this->load->model(array('prc_tender_main', 'adm_mrpc','prc_tender_item', 'adm_employee'));
		// $this->prc_tender_main->join_assign_employee();
		// $datatable = $this->prc_tender_main->get_wherehas_titstatus(7);
		// $user_mrpc = $this->adm_mrpc->get(array('EMP_ID'=>$this->session->userdata('ID')));
		// $byrequsner = $this->adm_employee->get(array('ADM_EMPLOYEE.ID'=>$this->session->userdata('ID')));
		// $company_id = $this->session->userdata('EM_COMPANY');

		// $data = array('data' => '');
		// $data1 = array();

		// if ($company_id == '4000' || $company_id == '3000') {
		// 	foreach ($datatable as $val) {
		// 		$this->prc_tender_item->join_ece_change();
		// 		$this->prc_tender_item->join_pr();
		// 		$requst = $this->prc_tender_item->get(array('PRC_TENDER_ITEM.PTM_NUMBER'=>$val['PTM_NUMBER'], 'PRC_TENDER_ITEM.TIT_STATUS'=>7));
		// 			foreach($byrequsner as $us){
		// 				if($requst){
		// 					if ($requst[0]['PPR_REQUESTIONER'] == $us['MKCCTR']) {
		// 						$val['STATUS_APPROVAL'] = $requst[0]['STATUS_APPROVAL'];
		// 						$data1[]=$val;
		// 					}
		// 				}
		// 			}
		// 		}
		// } else {
		// 	if($user_mrpc){
		// 		foreach ($datatable as $val) {
		// 				$this->prc_tender_item->join_ece_change();
		// 				$pti = $this->prc_tender_item->get(array('PRC_TENDER_ITEM.PTM_NUMBER'=>$val['PTM_NUMBER'], 'PRC_TENDER_ITEM.TIT_STATUS'=>7));
		// 				foreach($user_mrpc as $us){
		// 					if($pti){
		// 						if ($pti[0]['PPI_MRPC'] == $us['MRPC'] && $pti[0]['PPI_PLANT'] == $us['PLANT']) {
		// 							$val['STATUS_APPROVAL'] = $pti[0]['STATUS_APPROVAL'];
		// 							$data1[]=$val;
		// 						}
		// 					}
		// 				}
		// 		}

		// 	}
		// }

		$this->load->model('prc_tender_main');
			$this->prc_tender_main->ppr_assignee($this->session->userdata('ID'));
			$this->prc_tender_main->status_ece(array(0,-1));
		$datatable = $this->prc_tender_main->get_ece();
		if($datatable){
			$data1 = $datatable;
		}else{
			$data1=array();
		}
		$data = array('data' => $data1);

		echo json_encode($data);
	}

	public function viewDok($file = null){
		$this->load->helper('file');
		$image_path = base_url(UPLOAD_PATH).'/ece/'.$file;	
		
		if(empty($file) || !file_exists(BASEPATH.'../upload/ece/'.$file)){
			die('tidak ada attachment.');
		}
		
		$this->output->set_content_type(get_mime_by_extension($image_path));
		return $this->output->set_output(file_get_contents($image_path));
	}

	public function approval() {
		$data['title'] = 'APPROVAL ECE';
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/ece_approval.js');

		$this->layout->render('ece_list_approval', $data);
	}

	public function get_datatable_approval() {
		$this->load->model(array('prc_tender_main','prc_ece_change'));
			// $this->prc_tender_main->join_assign_employee();
			$this->prc_tender_main->user_approv($this->session->userdata('ID'));
		$datatable = $this->prc_tender_main->get_ece();

		$data1 = array();
		foreach ($datatable as $val) {
			$pec = $this->prc_ece_change->get(array('PTM_NUMBER'=>$val['PTM_NUMBER'], 'STATUS_APPROVAL'=>1, 'USER_APPROVAL'=>$this->session->userdata('ID')));
			if($pec){
				$data1[]=$val;
			}
		}
		$data = array('data' => $data1);		

		echo json_encode($data);
	}

	public function approv($id, $group_id){
		$data['title'] = 'APPROVAL ECE';
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_ece_change_comment');
		$this->load->model('prc_ece_change');
		$this->load->model('adm_employee');
		$this->load->model('adm_employee_atasan');

		$com['comment'] = $this->prc_ece_change_comment->get(array('PTM_NUMBER'=>$id, 'EC_ID_GROUP'=>$group_id));
		$data['ece_comment'] = $this->load->view('Ece/ece_comment', $com, true);

			$this->prc_tender_main->join_assign_employee();
		$data['ptm'] = $this->prc_tender_main->ptm($id);
		$data['ptm'] = $data['ptm'][0];
		$this->prc_tender_item->where_status(7);
		
		$pec = $this->prc_ece_change->get(array('PTM_NUMBER'=>$id, 'USER_APPROVAL'=>$this->session->userdata('ID'), 'EC_ID_GROUP'=>$group_id));
		foreach ($pec as $val) {
			$data['pec'][$val['TIT_ID']]=$val;
		}

		$pti = $this->prc_tender_item->ptm($id);
		foreach ($pti as $value) {
			if(isset($data['pec'][$value['TIT_ID']])){
				$data['pti'][] = $value;				
			}
		}

		$emp = $this->adm_employee->get(array('ID' => $this->authorization->getEmployeeId()));
		$nopeg = $emp[0]['NO_PEG'];

		$atasan = $this->adm_employee_atasan->get(array('MK_NOPEG' => $nopeg));
		$level = $atasan[0]['ATASAN1_LEVEL'];
		$this->is_kadep = ($level == 'DIR');

		if($this->is_kadep){
			$data['next_process']['nama'] = 'Approve';
			$data['next_process']['status'] = 2;
		}else{
			$atasan = $this->adm_employee->atasan($this->authorization->getEmployeeId());
			$atasan = $atasan[0];

			$data['next_process']['nama'] = 'Lanjut Approval '.$atasan['FULLNAME'];
			$data['next_process']['status'] = 1;
		}
		$data['ec_id_group']=$group_id;

		$this->load->model('adm_plant');
		$plant_master = $this->adm_plant->get();
		foreach ($plant_master as $val) {
			$data['plant_master'][$val['PLANT_CODE']] = $val;
		}
		
		$this->layout->add_js('pages/ece.js');
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();	
		$this->layout->render('ece_detail_aproval', $data);

	}

	public function save_approval(){
		$this->load->model(array('prc_ece_change','prc_ece_change_comment','prc_tender_item','prc_nego_hist','adm_employee'));
		$ptm = $this->input->post("ptm");
		$next_process = $this->input->post("next_process");
		$group_id = $this->input->post("ec_id_group");

		$action = 'Approval ECE';
		if($next_process == -1){
			$action = 'Reject ECE';
		}
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),$action,'OK',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		$comment_id = $this->prc_ece_change_comment->get_id();
		$dataComment = array(
				"ID" => $comment_id,
				"PTM_NUMBER" => $ptm,
				"PEC_COMMENT" => $this->input->post('comment'),
				"PEC_POSITION" => $this->authorization->getCurrentRole(),
				"PEC_NAME" => $this->authorization->getCurrentName(),
				"PEC_START_DATE" => oracledate(strtotime(date("d-m-Y H:i:s"))),
				"EC_ID_GROUP" => $group_id,
			);
		$this->prc_ece_change_comment->insert($dataComment);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Ece/save_approval','prc_ece_change_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		$atasan = $this->adm_employee->atasan($this->authorization->getEmployeeId());
		$atasan = $atasan[0];

		if($next_process == 1){
			$this->prc_ece_change->update(array('USER_APPROVAL'=>$atasan['ID']), array('PTM_NUMBER'=>$ptm, 'EC_ID_GROUP'=>$group_id));	
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Ece/save_approval','prc_ece_change','update',array('USER_APPROVAL'=>$atasan['ID']), array('PTM_NUMBER'=>$ptm, 'EC_ID_GROUP'=>$group_id));
				//--END LOG DETAIL--//		
		
		}else if($next_process == 2){ //approval kadep
			$ece = $this->prc_ece_change->get(array('PTM_NUMBER'=>$ptm, 'EC_ID_GROUP'=>$group_id));
			foreach ($ece as $val) {
				$s = array();
				$s['TIT_STATUS'] = 5;
				$s['TIT_PRICE'] = $val['PRICE_AFTER'];
				$w = array('TIT_ID'=>$val['TIT_ID']);
				$this->prc_tender_item->update($s, $w);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Ece/save_approval','prc_tender_item','update',$s, $w);
					//--END LOG DETAIL--//
				
				$newhist = array();
				$newhist['HIST_ID'] = $this->prc_nego_hist->get_id();
				$newhist['NEGOSIASI_ID'] = $val['EC_ID'];
				$newhist['PTM_NUMBER'] = $ptm;
				$newhist['NEGOSIASI'] = '3';
				$newhist['CREATED_AT'] = date(timeformat());
				$this->prc_nego_hist->insert($newhist);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Ece/save_approval','prc_nego_hist','insert',$newhist);
					//--END LOG DETAIL--//
			}

			$this->prc_ece_change->update(array('STATUS_APPROVAL'=>2), array('PTM_NUMBER'=>$ptm, 'EC_ID_GROUP'=>$group_id));
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Ece/save_approval','prc_ece_change','update',array('STATUS_APPROVAL'=>2), array('PTM_NUMBER'=>$ptm, 'EC_ID_GROUP'=>$group_id));
				//--END LOG DETAIL--//
		
		}else{ //reject -1
			$pec = $this->prc_ece_change->get(array('PTM_NUMBER'=>$ptm, 'EC_ID_GROUP'=>$group_id));
			$set = array();
			$set['STATUS_APPROVAL'] = -1;
			$set['USER_APPROVAL'] = $pec[0]['PPR_ASSIGNEE'];
			$where = array('PTM_NUMBER'=>$ptm, 'EC_ID_GROUP'=>$group_id);
			$this->prc_ece_change->update($set, $where);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Ece/save_approval','prc_ece_change','update',$set, $where);
				//--END LOG DETAIL--//
		}

		$this->session->set_flashdata('success', 'Data Berhasil Disimpan.');
		redirect('Ece/approval');
	}


}

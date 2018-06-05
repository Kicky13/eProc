<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class buat nangani perpindahan process dari PTM.
 */
class Process {

	/* Load all dependencies */
	function __construct() {
		$this->ci = &get_instance();
		$this->ci->load->model('prc_tender_main');
		$this->ci->load->model('prc_process_holder');
		$this->ci->load->model('adm_employee');
		$this->ci->load->model('app_process');
		$this->ci->load->library('log_data');


		$this->ci->load->model('prc_tender_item');
		$this->ci->load->model('prc_pr_item');
		$this->ci->load->library('email');
		$this->ci->config->load('email'); 

	}

// 	public function nambah_berapa($value = '') {
// 		CURRENT
// NEXT
// BACK
// RETENDER
// 	}

	/**
	 * buat ditampilin di 'Lanjut ke'
	 * @param PTM_NUMBER
	 * @return satu row app process next nya
	 */
	public function get_next_process($ptm) {
		$ptmain = $this->ci->prc_tender_main->ptm($ptm);
		$ptmain = $ptmain[0];
		$kel_plant_pro = $ptmain['KEL_PLANT_PRO'];
		$sampul = $ptmain['SAMPUL'];
		$ptm_status = $ptmain['PTM_STATUS'];
		$jst = $ptmain['JUSTIFICATION'];
		$this->ci->app_process->where_unique($kel_plant_pro, $sampul, $jst, $ptm_status + 1);
		$nextprocess = $this->ci->app_process->get();
		return $nextprocess[0];
	}

	/**
	 * ptm next process, jika tergantung users
	 *
	 * @param PTM Number
	 * @param Next Status, ga tau ini ngambil dr mana
	 * @param array of users
	 * @param Company ID
	 */
	public function next_process_user($ptm, $status, $users, $lm_id=null, $id_current_process=null) {
		$users = ((array) $users);
		$this->delete_previous_holder($ptm);

		$data = $this->ci->prc_tender_main->ptm($ptm);
		$current_status = $data[0]['PTM_STATUS'];
		if($id_current_process){
			$current_status = $id_current_process;
		}
		if ($status == 'CURRENT') {
			$new_status = $current_status;
		} else if ($status == 'NEXT') {
			$new_status = $current_status + 1;
		} else if ($status == 'BACK') {
			$new_status = $current_status - 1;
		} else if ($status == 'RETENDER') {
			$new_status = $current_status - 1;
		}
		$this->ci->prc_tender_main->updateByPtm($ptm, array("PTM_STATUS" => $new_status));
		if($lm_id){
				//--LOG DETAIL--//
			$this->ci->log_data->detail($lm_id,'process/next_process_user','prc_tender_main','update',array("PTM_STATUS" => $new_status),array('PTM_NUMBER'=>$ptm));
				//--END LOG DETAIL--//
		}

		$lmId=null;
		if($lm_id){
			$lmId=$lm_id;
		}
		return $this->assign_holder_by_user($users, $ptm, $lmId);
	}

	/**
	 * ptm next process, yg ribet, ngambil dr app_process
	 *
	 * @param PTM Number
	 * @param Next Status, ga tau ini ngambil dr mana
	 * @param Company ID
	 */
	public function next_process_assignment($ptm, $status, $lm_id=null, $id_current_process=null) {
		$data = $this->ci->prc_tender_main->ptm($ptm);
		$data = $data[0];
		$user = intval($data['PTM_ASSIGNMENT']);
		if ($user <= 0) {
			echo 'Tidak ada user yg terassign di PTM ' . $ptm;
			exit();
		}
		$lmId=null;
		if($lm_id){
			$lmId=$lm_id;
		}
		$idCurrent_process=null;
		if($id_current_process){
			$idCurrent_process=$id_current_process;
		}
		return $this->next_process_user($ptm, $status, $user, $lmId, $idCurrent_process);
	}

	/**
	 * ptm next process, yg ribet, ngambil dr app_process
	 *
	 * @param PTM Number
	 * @param Next Status, ga tau ini ngambil dr mana
	 * @param Company ID
	 */
	public function next_process($ptm, $status, $lm_id=null) {
		/* Ngambil ptm dulu */
		$tender = $this->ci->prc_tender_main->ptm($ptm);
		$tender = $tender[0];  // lihaaattt ini PRC_TENDER_MAIN

		/* Next Statusnya */
		$current_status = $tender['PTM_STATUS'];
		if ($status == 'CURRENT') {
			$new_status = $current_status;
		} else if ($status == 'NEXT') {
			$new_status = $current_status + 1;
		} else if ($status == 'BACK') {
			$new_status = $current_status - 1;
		} else if ($status == 'RETENDER') {
			$new_status = $current_status - 1;
		}

		/* Ngambil nextprocess */
		$klplpr = $tender['KEL_PLANT_PRO'];
		$smpl = $tender['SAMPUL'];
		$jst = $tender['JUSTIFICATION'];
		$this->ci->app_process->where_unique($klplpr, $smpl, $jst, $new_status);
		// $this->ci->app_process->join_pgrp();
		$nextprocess = $this->ci->app_process->get();
		if (empty($nextprocess)) {
			echo 'Tidak bisa dapat APP_PROCESS<br>\n';
			// echo $error;
			exit();
		} else if (count($nextprocess) > 1) {
			echo 'APP_PROCESS dapat banyak<br>\n';
			// echo $error;
			// exit();
			var_dump($nextprocess); exit();
		}
		$nextprocess = $nextprocess[0];

		$emp = $this->get_emp_by_unique($klplpr, $smpl, $jst, $new_status, false, $tender['PTM_PGRP']);

		if (count($emp) <= 0) {
			echo 'tidak ada user yang dapat melanjutkan proses, silahkan cek setting master_process';
			exit();
		}
		
		$lmId=null;
		if($lm_id){
			$lmId=$lm_id;
		}

		return $this->next_process_user($ptm, $status, $emp, $lmId);
	}

	public function kirim_email_2($user){
		// echo "user<pre>";
		$semenindonesia = $this->ci->config->item('semenindonesia'); 
		$this->ci->email->initialize($semenindonesia['conf']);
		$this->ci->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		// $this->email->to($user['EMAIL']);				
		$this->ci->email->to('tithe.j@sisi.id');				
		// $this->email->cc('pengadaan.semenindonesia@gmail.com');				
		$this->ci->email->subject($user['data']['judul'].' '.$this->session->userdata['COMPANYNAME'].".");
		//print_r($user);die;	
		$content = $this->ci->load->view('email/approval_atasan_per_flow',$user['data'],TRUE);
		$this->ci->email->message($content);
		$this->ci->email->send();
	}

	/**
	 * Ngambil PROCESS->PROCESS_ROLE->ADM_EMPLOYEE->ID
	 *
	 * @param KEL_PLANT_PRO
	 * @param JENIS_SAMPUL
	 * @param CURRENT_PROCESS
	 * @param JUSTIFICATION
	 */
	public function get_emp_by_unique($kel, $sampul, $jst, $status, $full = false, $pgrp = false) {
		$this->ci->app_process->join_emp();
		if ($pgrp != false) {
			$this->ci->app_process->join_pgrp();
			$this->ci->app_process->where_pgrp($pgrp);
		}
		$this->ci->app_process->where_unique($kel, $sampul, $jst, $status);
		$all = $this->ci->app_process->get();
		// var_dump($pgrp); exit();
		if ($full) {
			//return array_unique($all);
			return array_values(array_unique($all, SORT_REGULAR));
		} else {
			$emp = array();
			foreach ($all as $val) {
				$emp[] = $val['ID'];
			}
			return array_unique($emp);
		}
	}

	/**
	 * ptm next process, default dilanjutin sama orang yang buat PTM
	 *
	 * @param PTM Number
	 * @param Next Status, ga tau ini ngambil dr mana
	 * @param Company ID
	 */
	public function next_process_easy($ptm, $status) {
		$tender = $this->ci->prc_tender_main->ptm($ptm);
		$tender = $tender[0];
		$emp = $tender['PTM_REQUESTER_ID'];
		return $this->next_process_user($ptm, $status, $emp);
	}

	/**
	 * ptm next process, jika tergantung roles
	 *
	 * @param PTM Number
	 * @param Next Status, ga tau ini ngambil dr mana
	 * @param role | array of role
	 * @param Company ID
	 */
	public function next_process_role($ptm, $status, $roles) {
		if (!is_array($roles)) {
			$roles = array($roles);
		}
		$users = $this->get_user_by_role($roles);
		return $this->next_process_user($ptm, $status, $users);
	}

	/* hapus PROCESS_HOLDER dengan ptm number */
	public function delete_previous_holder($ptm) {
		return $this->ci->prc_process_holder->deleteByPtm($ptm);
	}

	/** 
	 * Get users from given roles
	 *
	 * @param array of role. [28, 31, 123]
	 */
	public function get_user_by_role($roles) {
		$roles = ((array) $roles);
		foreach ($roles as $role) {
			$emps = $this->ci->adm_employee->get(array('ADM_EMPLOYEE.ADM_POS_ID' => $role));
			foreach ($emps as $emp) {
				$users[] = $emp['ID'];
			}
		}
		return $users;
	}

	/** 
	 * Assign user pos by array of users
	 *
	 * @param array of EMPLOYEE_ID. [28, 31, 123]
	 */
	public function assign_holder_by_user($users, $ptm, $lm_id=null) {
		$users = ((array) $users);
		$users = array_unique($users);
		if($lm_id){
				//--LOG DETAIL--//
			$this->ci->log_data->detail($lm_id,'process/assign_holder_by_user','prc_process_holder','update',array('EMP_ID'=>$users),array('PTM_NUMBER'=>$ptm));
				//--END LOG DETAIL--//
		}

		$tender = $this->ci->prc_tender_main->ptm($ptm);
		$tender = $tender[0];  // lihaaattt ini PRC_TENDER_MAIN

		/* Next Statusnya */
		$current_status = $tender['PTM_STATUS'];
		$status = 'CURRENT';
		if ($status == 'CURRENT') {
			$new_status = $current_status;
		} else if ($status == 'NEXT') {
			$new_status = $current_status + 1;
		} else if ($status == 'BACK') {
			$new_status = $current_status - 1;
		} else if ($status == 'RETENDER') {
			$new_status = $current_status - 1;
		}

		/* Ngambil nextprocess */
		$klplpr = $tender['KEL_PLANT_PRO'];
		$smpl = $tender['SAMPUL'];
		$jst = $tender['JUSTIFICATION'];
		$this->ci->app_process->where_unique($klplpr, $smpl, $jst, $new_status);
		$all = $this->ci->app_process->get();
		// echo "sini";die;
		$pti = $this->ci->prc_tender_item->get(array('PTM_NUMBER'=>$ptm));
		if(count($pti)>0){
			$pri = $this->ci->prc_pr_item->where_ppiId($pti[0]['PPI_ID']);
			$hasil = $pri[0]['PPI_PRNO'];
			$tipe = 'pr';
		} else {
			$hasil = $tender['PTM_SUBPRATENDER'];
			$tipe = 'slb';
		}
		
		$emp = $this->ci->adm_employee->get(array('ID'=>$users[0]));
		// echo "<pre>";
		// print_r($holder);
		// print_r($emp);
		// die;

		$user['EMAIL'] = $emp[0]['EMAIL'];
		$user['data']['judul'] = 'eProcurement '.$all[0]['NAMA_BARU'];
		$user['data']['nama_pengadaan'] = $tender['PTM_SUBJECT_OF_WORK'];
		$user['data']['no_pengadaan'] = $tender['PTM_PRATENDER'];
		$user['data']['no_pratender'] = $tender['PTM_SUBPRATENDER'];
		$user['data']['no_pr'] = $hasil;
		$user['data']['evaluator'] = $emp[0]['FULLNAME'];
		$user['data']['tipe'] = $tipe;
		//print_r($user);die;
		// $this->kirim_email_2($user);

		return $this->ci->prc_process_holder->insert_user_ptm($users, $ptm);
	}

}
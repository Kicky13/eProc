<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Log_data {

	public function __construct() {
		$this->ci = &get_instance();
		$this->ci->load->model('log_main');
		$this->ci->load->model('log_detail');
	}

	public function main($userID=null,$user,$position,$process,$lmAction,$ipAddredd) {
		$dataLM = array(
				'USER_ID'=> !empty($userID)?$userID:'',
				'USER'=> $user,
				'USER_POSITION'=>$position,
				'PROCESS'=>$process,
				'LM_ACTION'=>$lmAction,
				'IP_ADDRESS'=>$ipAddredd,
				'LM_DATETIME'=>date('d-M-Y H:i:s'),
			);
		$this->ci->log_main->insert($dataLM);
	}

	public function last_id() {
		return $this->ci->log_main->get_last_id();
	}

	public function detail($idLM,$actionLocation,$affected,$ldAction,$data=null,$condition=null) {
		$dataLD = array(
				'LM_ID'=> $idLM,
				'CONTROLLER_ACTION_LOCATION'=> $actionLocation,
				'TABLE_AFFECTED'=>$affected,
				'LD_ACTION'=>$ldAction,
				'DATA'=>!empty($data)?json_encode($data):'',
				'CONDITION'=>!empty($condition)?json_encode($condition):'',
				'LD_DATETIME'=>date('d-M-Y H:i:s'),
			);
		$this->ci->log_detail->insert($dataLD);
	}

}
?>
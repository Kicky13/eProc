<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class buat nangani Retender.
 */
class Retender {

	/* Load all dependencies */
	function __construct() {
		$this->ci = &get_instance();
		$this->ci->load->model('adm_employee');
		$this->ci->load->model('prc_pr_item');
		$this->ci->load->model('prc_process_holder');
		$this->ci->load->model('prc_tender_item');
		$this->ci->load->model('prc_tender_main');
		$this->ci->load->model('retender_item');
		$this->ci->load->model('retender_quo_item');
		$this->ci->load->library('log_data');
	}

	/**
	 * buat ditampilin di 'Lanjut ke'
	 * @param PTM_NUMBER
	 * @return satu row app process next nya
	 */
	public function return_item($tit_id) {
		$state = true;

		$tit = $this->ci->prc_tender_item->get(array('TIT_ID' => $tit_id));
		$tit = $tit[0];
		// var_dump($tit['PPI_ID']);die;

		$ppi = $this->ci->prc_pr_item->get(array('PPI_ID'=>$tit['PPI_ID']));
		// var_dump($ppi);die;
		if(count($ppi)==0){
			$state = false;
		}else{
			$ppi = $ppi[0];
			// var_dump($ppi);die;

			$setppi = array('PPI_QTY_USED' => $ppi['PPI_QTY_USED'] - $tit['TIT_QUANTITY']);
			$whereppi = array('PPI_ID' => $tit['PPI_ID']);

			// die(var_dump($setppi));
			$this->ci->prc_pr_item->update($setppi, $whereppi);
		}
		
		return $state;
		
	}

	public function throw_item($tit_id, $stat, $lm_id) {
		
		$pti = $this->ci->prc_tender_item->get(array('TIT_ID' => $tit_id),false);
		$pti = $pti[0];

		$ptqi = $this->ci->prc_tender_quo_item->get_retender(array('TIT_ID' => $tit_id));
		
		foreach ($ptqi as $key => $value) {
			$this->ci->retender_quo_item->insert($value);
				//--LOG DETAIL--//
			$this->ci->log_data->detail($lm_id,'Retender/throw_item','retender_quo_item','insert',$value);
				//--END LOG DETAIL--//
		}
		$ret_item = array(
				"TIT_ID"=>$pti['TIT_ID'],
		    "PTM_NUMBER"=>$pti['PTM_NUMBER'],
		    "TIT_QUANTITY"=>$pti['TIT_QUANTITY'],
		    "TIT_PRICE"=>$pti['TIT_PRICE'],
		    "PPI_ID"=>$pti['PPI_ID'],
		    "TIT_STATUS"=>$pti['TIT_STATUS'],
		    "PAQH_ID"=>$pti['PAQH_ID'],
		    "TIT_EBELP"=>$pti['TIT_EBELP'],
		    "PEMENANG"=>$pti['PEMENANG'],
		    "SERVICE_ID"=>$pti['SERVICE_ID'],
		    "WIN_AT"=>$pti['WIN_AT'],
		    "STATUS"=>$stat
			);		

			//--LOG DETAIL--//
		$this->ci->log_data->detail($lm_id,'Retender/throw_item','retender_item','insert',$ret_item);
			//--END LOG DETAIL--//

		if($this->ci->retender_item->insert($ret_item)){			
			if($this->return_item($tit_id)){
				/*dua baris di bawah ini untuk menghapus item*/
				$this->ci->prc_tender_item->delete(array('TIT_ID' => $tit_id));
					//--LOG DETAIL--//
				$this->ci->log_data->detail($lm_id,'Retender/throw_item','prc_tender_item','delete',null,array('TIT_ID' => $tit_id));
					//--END LOG DETAIL--//

				$this->ci->prc_tender_quo_item->delete(array('TIT_ID' => $tit_id));	
					//--LOG DETAIL--//
				$this->ci->log_data->detail($lm_id,'Retender/throw_item','prc_tender_quo_item','delete',null,array('TIT_ID' => $tit_id));
					//--END LOG DETAIL--//		
			}
		}		
	}

}
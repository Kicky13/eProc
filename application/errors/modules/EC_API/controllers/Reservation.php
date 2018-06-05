<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions

class Reservation extends REST_Controller
{
	private $enableLog;
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        $this->load->library('sap_invoice');
				$this->load->config('warehouse');
				$this->enableLog = $this->config->item('log_api_enable');
    }

    function list_post()
    {
			$this->load->model('Reservation_model','rm');
      $resno = $this->post('resno');
      $material = $this->post('material');
      $plant = $this->post('plant');
      $req_date = $this->post('req_date');
      $store_loc = $this->post('store_loc');

      $reservations = $this->rm->getItems($resno,$material,$plant,$req_date,$store_loc);
      /* cari yang store loc sama dengan inputan */
      $result = array();
      foreach($reservations as $res){
        if($res['STORE_LOC'] == $store_loc){
          array_push($result,$res);
        }
      }
			$this->response($result, 200);
    }


    function list_get()
    {
			$this->load->model('Reservation_model','rm');
      $resno = $this->get('resno');
      if(empty($resno)){
        $this->response(array(
            'status' => FALSE,
            'message' => 'Nomer reservasi harus diisi'
        ), REST_Controller::HTTP_BAD_REQUEST);
      }
      $t = $this->rm->detailByReservationNumber($resno);
      $this->response($t, 200);
    }
    function checkstock_get()
    {
			$this->load->model('Stockwm_model','swm');
      $matnr = $this->get('matnr');
			$werks = $this->get('werks');
			$lgort = $this->get('lgort');
			$t = $this->swm->checkstock($matnr,$werks,$lgort);
			$this->response($t, 200); // 200 being the HTTP response code
    }

    function stockwm_get()
    {
			$this->load->model('Stockwm_model','swm');
			$inputData = array(
				'text' => $this->get('text'),
				'lgnum' => $this->get('lgnum'),
				'lgtyp' => $this->get('lgtyp'),
				'lgpla' => $this->get('lgpla'),
				'plant' => $this->get('plant'),
				'sloc' => $this->get('sloc')
			);
      $t = $this->swm->data($inputData);
      $this->response($t, 200);
    }

		function reservasi_get()
    {
			$this->load->model('Reservation_model','rm');
			$result = array('status' => 1, 'content' => '');
			$showDetail = 0;
			$rsnum_p = $this->get('rsnum');
			$rwerks_p = $this->get('rwerks');
			$rmatnr_p = $this->get('rmatnr');
			$rbwart_p = $this->get('rbwart');
			$mvtind_p = $this->get('mvtind');
			$lgort_p = $this->get('rlgort');
			$final_p = $this->get('final');
			$delete_p = $this->get('delete');
			$bdter_awal = $this->get('bdter_awal');
			$bdter_akhir = $this->get('bdter_akhir');
			$detail = $this->get('detail');
			$includeUnapprove = $this->get('includeUnapprove');
			$input = array(
				'rsnum_p' => $rsnum_p,
				'rwerks_p' => $rwerks_p,
				'rmatnr_p' => $rmatnr_p,
				'rbwart_p' => $rbwart_p,
				'rlgort_p' => $lgort_p,
				'mvtind_p' => $mvtind_p,
				'final_p' => $final_p,
				'delete_p' => $delete_p,
				'bdter_awal' => $bdter_awal,
				'bdter_akhir' => $bdter_akhir,
				'detail' => $detail,
				'includeUnapprove' => $includeUnapprove
			);
			if(!empty($rsnum_p)){
				$input = array(
					'rsnum_p' => $rsnum_p,
					'rwerks_p' => $rwerks_p,
					'detail' => $detail,
					'includeUnapprove' => $includeUnapprove
				);
			}
			$t = $this->rm->detailData($input);
			//$t = $this->rm->detail($rsnum_p,$rwerks_p,$rmatnr_p,$rbwart_p,$mvtind_p,$final_p,$delete_p,$bdter_awal,$bdter_akhir,$detail);
			if($this->enableLog){
				log_message('error',' Detail reservasi '.json_encode($input));
			}
			$_tmp = $this->filterBasedQtyIssue($t);
			$result['content'] = $_tmp;
			//log_message('error',json_encode($input));
      $this->response($result, 200); // 200 being the HTTP response code
    }

		function resumeReservasi_get(){
			$this->load->model('Reservation_model','rm');
			$result = array('status' => 1, 'content' => '');
			$_rwerks = $this->input->get('werks');
			if($this->enableLog){
				log_message('error',' Resume reservasi '.json_encode($_rwerks));
			}
			$t = $this->rm->resume($_rwerks);
			$result['content'] = count($t);

			$this->response($result,200);
		}

		function _reservasiData($input){
			$this->load->model('Reservation_model','rm');
			$t = $this->rm->data($input);
			return $t;
		}

		function resumeLog_get(){
			$result = array('status' => 1, 'content' => '');
			$_rwerks = $this->input->get('werks');
			$_rcpudt = $this->input->get('cpudt');
			$t = $this->_logData($_rcpudt,$_rwerks);
			$result['content'] = count($t['EXPORT_PARAM_TABLE']['T_DATA']);

			$this->response($result,200);
		}

		function detailLog_get(){
			$result = array('status' => 1, 'content' => '');
			$_rwerks = $this->input->get('werks');
			$_rcpudt = $this->input->get('cpudt');
			$t = $this->_logData($_rcpudt,$_rwerks);
			$result['content'] = $t;

			$this->response($result,200);
		}


		function _logData($_rcpudt = NULL,$_rwerks = NULL){
			$this->load->model('Logdata_model','ldm');
			$t = $this->ldm->datalog($_rcpudt,$_rwerks);
			return $t;
		}

		function resumeInterim_get(){
			$result = array('status' => 1, 'content' => '');
			$_rwerks = $this->input->get('werks');
			$_rlgtyp = $this->input->get('lgtyp');
			$input = array(
				'rwerks' => $_rwerks,
				'rlgtyp' => $_rlgtyp
			);
			if($this->enableLog){
				log_message('error',' Resume interim '.json_encode($input));
			}
			$t = $this->_interimData($input);
			$result['content'] = count($t['EXPORT_PARAM_TABLE']['T_DATA']);

			$this->response($result,200);
		}

		function _interimData($input = array()){
			$this->load->model('Interim_model','im');
			$t = $this->im->data($input);
			return $t;
		}

		function resumeOpname_get(){
			$result = array('status' => 1, 'content' => '');
			$_rwerks = $this->input->get('werks');
			if($this->enableLog){
				log_message('error',' Resume Opname '.json_encode($_rwerks));
			}
			if(!empty($_rwerks)){
				$t = $this->_opnameData($_rwerks);
				$tmp = $t['EXPORT_PARAM_TABLE']['HEADERS'];
			//	$result['content'] = $this->_countOpenOpname($tmp);
				$result['content'] = count($tmp);
			}
			$this->response($result,200);
		}

		function _opnameData($_rwerks = NULL){
			$this->load->model('Opname_model','om');
			$t = $this->om->opnameData($_rwerks);
			return $t;
		}

		function listBonSementara_get(){
			$result = array('status' => 1, 'content' => '');
			$_error = 0;
			$_message = array();
			$this->load->model('Reservation_model','rm');
			$_werks = $this->input->get('rwerks');
			$_sortf = $this->input->get('rsortf');
			$_detail = $this->input->get('rdetail');
			$inputData = array(
				'werks' => $_werks,
				'sortf' => $_sortf
			);
			if($this->enableLog){
					log_message('error',' List bon sementara '.json_encode($inputData));
			}
			$t = $this->rm->listBonSementara($inputData);
			if(!$_detail){
				$result['content'] = count($t['EXPORT_PARAM_TABLE']['T_DATA']);
			}else{
				$result['content'] = $t['EXPORT_PARAM_TABLE']['T_DATA'];
			}
			$this->response($result,200);
		}

		function bonSementara_get(){
			$result = array('status' => 1, 'content' => '');
			$_error = 0;
			$_message = array();
			$this->load->model('Reservation_model','rm');
			$_rsnum = $this->input->get('rsnum');
			$_rspos = $this->input->get('rspos');
			$_flag = $this->input->get('flag');
			$inputData = array('P_FLAG' => '', 'R_INPUT' => array());

			if(!empty($_rsnum)){
				if(!empty($_rspos)){
					foreach($_rsnum as $_index => $_tmp){
						$tmp = array(
							'RSNUM' => str_pad($_tmp,10,'0',STR_PAD_LEFT),
							'RSPOS' => isset($_rspos[$_index]) ? str_pad($_rspos[$_index],4,'0',STR_PAD_LEFT) : '0000'
						);
						array_push($inputData['R_INPUT'],$tmp);
					}
				}
			}else{
				$_error++;
				array_push($_message,'Nomer reservasi harus diisi');
			}
			if(!empty($_flag)){
				$inputData['P_FLAG'] = $_flag;
			}else{
				$_error++;
				array_push($_message,'Flag harus diisi');
			}
			if(!$_error){
				$t = $this->rm->flagBonSementara($inputData);
				if($this->enableLog){
						log_message('error','Data Bon Sementara '.json_encode($inputData));
						log_message('error','Hasil Bon Sementara '.json_encode($t));
				}
				$result['content'] = $t;
				$this->response($result,200);
			}else{
				$result['status'] = 0;
				$result['content'] = $_message;
				$this->response($result,200);
			}
		}

		function goodIssue_post(){
			$result = array('status' => 1, 'content' => '');
			$_error = 0;
			$_message = array();
			$this->load->model('Reservation_model','rm');
			$_header = $this->input->post('header');
			$_detail = $this->input->post('detail');
			$inputData = array(
				'GOODSMVT_ITEM' => array()
			);
			if(!empty($_header)){
				$inputData['GOODSMVT_HEADER'] = $_header;
			}else{
				$_error++;
				array_push($_message,'Header data harus diisi');
			}
			if(!empty($_detail)){
				/* ubah RESERV_NO menjadi 0051557860 dan RES_ITEM 0001 */
				foreach($_detail as $_d){
					$_d['RES_ITEM'] = str_pad($_d['RES_ITEM'],4,'0',STR_PAD_LEFT);
					$_d['RESERV_NO'] = str_pad($_d['RESERV_NO'],10,'0',STR_PAD_LEFT);
					if(strtoupper($_d['SPEC_STOCK']) == 'Q'){
						$_d['VAL_WBS_ELEM'] = $_d['WBS_ELEM'];
					}
					if(strtoupper($_d['SPEC_STOCK']) == 'K'){
						$_d['VENDOR'] = str_pad(substr($_d['WBS_ELEM'],-10),10,'0',STR_PAD_LEFT);
					}
					unset($_d['WBS_ELEM']);
					array_push($inputData['GOODSMVT_ITEM'],$_d);
				}

			}else{
				$_error++;
				array_push($_message,'Detail harus diisi');
			}
			if(!$_error){
				if($this->enableLog){
					log_message('error',' Good issue  '.json_encode($inputData));
				}
				$t = $this->rm->goodIssue($inputData);
				$result['content'] = $t;
				$this->response($result,200);
			}else{
				$result['status'] = 0;
				$result['content'] = $_message;
				$this->response($result,200);
			}
		}

		public function stockMaterial_get(){
			$result = array('status' => 1, 'content' => '');
			$_error = 0;
			$_message = array();
			$this->load->model('Material_model','mm');
			$werks = $this->input->get('werks');
			$matnr = $this->input->get('matnr');
			$inputData = array(
				'R_MATNR' => $matnr,
				'R_WERKS' => $werks
			);
			$t = $this->mm->stock($inputData);
			$s = $this->filterHeaderWM($t['success']);
			$t['success'] = $this->msort($s,array('SLOC','STYPE'));
			$result['content'] = $t;
			$this->response($result,200);
		}

		private function filterHeaderWM($t){
			/* untuk W213 dan W217, hilangkan yang headernya WHN kosong */
			$hilangkanHeader = array('W213','W217');
			$result = array();
			if(!empty($t)){
				foreach ($t as $_t) {
          /* jika STYPE beerawalan 9 maka skip */
					if(substr($_t['STYPE'],0,1) == '9'){
						continue;
					}
					if(in_array($_t['SLOC'],$hilangkanHeader)){
						if(empty($_t['WHN'])){
				 			continue;
						}
					}
					$result[] = $_t;
				}
			}
			return $result;
		}

		private function filterBasedQtyIssue($t){
			/* jika qty issue >= qty requirement, maka hilangkan dari list */
			$result = array();
			if(!empty($t)){
				foreach ($t as $_t) {
          /* jika STYPE beerawalan 9 maka skip */
					if(intval($_t['ENMNG']) >= intval($_t['BDMNG']) ){
						continue;
					}
					$result[] = $_t;
				}
			}
			return $result;
		}

		/**
		 * Sort a 2 dimensional array based on 1 or more indexes.
		 *
		 * msort() can be used to sort a rowset like array on one or more
		 * 'headers' (keys in the 2th array).
		 *
		 * @param array        $array      The array to sort.
		 * @param string|array $key        The index(es) to sort the array on.
		 * @param int          $sort_flags The optional parameter to modify the sorting
		 *                                 behavior. This parameter does not work when
		 *                                 supplying an array in the $key parameter.
		 *
		 * @return array The sorted array.
		 */
		function msort($array, $key, $sort_flags = SORT_REGULAR) {
		    if (is_array($array) && count($array) > 0) {
		        if (!empty($key)) {
		            $mapping = array();
		            foreach ($array as $k => $v) {
		                $sort_key = '';
		                if (!is_array($key)) {
		                    $sort_key = $v[$key];
		                } else {
		                    // @TODO This should be fixed, now it will be sorted as string
		                    foreach ($key as $key_key) {
		                        $sort_key .= $v[$key_key];
		                    }
		                    $sort_flags = SORT_STRING;
		                }
		                $mapping[$k] = $sort_key;
		            }
		            asort($mapping, $sort_flags);
		            $sorted = array();
		            foreach ($mapping as $k => $v) {
		                $sorted[] = $array[$k];
		            }
		            return $sorted;
		        }
		    }
		    return $array;
		}
}

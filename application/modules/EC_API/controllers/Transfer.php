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

class Transfer extends REST_Controller
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

		function sloc_post(){
			$result = array('status' => 1, 'content' => '');
			$_error = 0;
			$_message = array();
			$this->load->model('Reservation_model','rm');
			$_header = $this->input->post('header');
			$_detail = $this->input->post('detail');
			$inputData = array(
        'GOODSMVT_CODE' => array('GM_CODE' => '04')
      );
			if(!empty($_header)){
				$inputData['GOODSMVT_HEADER'] = $_header;
			}else{
				$_error++;
				array_push($_message,'Header data harus diisi');
			}
			if(!empty($_detail)){
				$detailnya = array();
				foreach($_detail as $_d){
					$_d['MOVE_VAL_TYPE'] = $_d['VAL_TYPE'];

					if(strtoupper($_d['SPEC_STOCK']) == 'Q'){
						$_d['VAL_WBS_ELEM'] = $_d['WBS_ELEM'];
					}

					if(strtoupper($_d['SPEC_STOCK']) == 'K'){
						$_d['VENDOR'] = $_d['WBS_ELEM'];
					}
					
					unset($_d['WBS_ELEM']);
					$detailnya[] = $_d;
				}
				$inputData['GOODSMVT_ITEM'] = $detailnya;
			}else{
				$_error++;
				array_push($_message,'Detail harus diisi');
			}
			if(!$_error){
				if($this->enableLog){
					log_message('error',' Transfer  '.json_encode($inputData));
				}

				$t = $this->rm->transfer($inputData);
				$result['content'] = $t;
				$this->response($result,200);
			}else{
				$result['status'] = 0;
				$result['content'] = $_message;
				$this->response($result,200);
			}
		}
}

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

class Interim extends REST_Controller
{
	private $enableLog;
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        $this->load->library('sap_invoice');
				$this->load->config('warehouse');
				$this->load->model('Interim_model','im');
				$this->enableLog = $this->config->item('log_api_enable');
    }

		function detail_get(){
			$result = array('status' => 1, 'content' => '');
			$_rwerks = $this->input->get('werks');
			$_rlgtyp = $this->input->get('lgtyp');
			$_rlgnum = $this->input->get('lgnum');
			$_rlqnum = $this->input->get('lqnum');
			$_rmatnr = $this->input->get('matnr');
			$_rlgpla = $this->input->get('lgpla');

			$input = array(
				'rwerks' => $_rwerks,
				'rlgtyp' => $_rlgtyp,
				'rlgnum' => $_rlgnum,
				'rlqnum' => $_rlqnum,
				'rmatnr' => $_rmatnr,
				'rlgpla' => $_rlgpla
			);
			if($this->enableLog){
				log_message('error',' Detail interim '.json_encode($input));
			}
			$t = $this->_interimData($input);

			$result['content'] = $t['EXPORT_PARAM_TABLE']['T_DATA'];
			$this->response($result,200);
		}

		function clearInterim_get(){
			$result = array('status' => 0, 'content' => 'Clear interim failed');
			$data = $this->input->get('data');
			$r = $this->im->clearInterim($data);
			if($this->enableLog){
				log_message('error',' Clear interim '.json_encode($data));
			}

			if(isset($r['EXPORT_PARAM_SINGLE'])){
				if(isset($r['EXPORT_PARAM_SINGLE']['E_TANUM'])){
					$nomerTanum = $r['EXPORT_PARAM_SINGLE']['E_TANUM'];
					if(!empty($nomerTanum)){
						$result['status'] = 1;
						$result['content'] = 'Clear interim success with document '.$nomerTanum;
					}
				}
			}
			if(isset($r['EXPORT_PARAM_ARRAY'])){
				if(isset($r['EXPORT_PARAM_ARRAY']['T_MESSAGE'])){
					if(!empty($r['EXPORT_PARAM_ARRAY']['T_MESSAGE']['MESSAGE'])){
						$result['content'] = $r['EXPORT_PARAM_ARRAY']['T_MESSAGE'];
					}
				}
			}
			
			$this->response($result,200);
		}

		function _interimData($input = array()){
			$t = $this->im->data($input);
			return $t;
		}
}

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

class Opname extends REST_Controller
{
	private $enableLog;
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        $this->load->model('Opname_model','om');
				$this->load->config('warehouse');
				$this->enableLog = $this->config->item('log_api_enable');
    }

		function list_get(){
			$result = array('status' => 1, 'content' => '');
			$_rwerks = $this->input->get('werks');
			$_stge = $this->input->get('stge');
			$input = array();
			if(!empty($_rwerks)){
				$input['PLANT_RA'] = $_rwerks;
				$input['STGE_LOC_RA'] = $_stge;
				if($this->enableLog){
					log_message('error',' List opname '.json_encode($_rwerks));
				}
				$t = $this->_opnameData($input);
				$tmp = $t['EXPORT_PARAM_TABLE']['HEADERS'];
			//	$result['content'] = $this->_countOpenOpname($tmp);
				$result['content'] = $tmp;
			}else{
        $result['status'] = 0;
        $result['content'] = 'Parameter pencarian harus diisi';
      }

			$this->response($result,200);
		}

    function detail_get(){
			$result = array('status' => 1, 'content' => '');
			$_pid = $this->input->get('pid');
      $_fiscalyear = $this->input->get('fiscalyear');
      $_error = 0;
      $_message = array();
      if(empty($_pid)){
        $_error++;
        array_push($_message,'PID harus diisi');
      }
      if(empty($_fiscalyear)){
        $_error++;
        array_push($_message,'Fiscal year harus diisi');
      }
			if(!$_error){
				$t = $this->_detailData($_pid,$_fiscalyear);
				$head = $t['EXPORT_PARAM_ARRAY']['HEAD'];
				$tmp = $t['EXPORT_PARAM_TABLE']['ITEMS'];
        /* tambahkan description material */
        if(!empty($tmp)){
          $tmp = $this->addMaterialDescription($tmp);
        }
				if($this->enableLog){
					log_message('error',' Detail opname '.json_encode($_pid).' tahun '.json_encode($_fiscalyear));
				}
				$result['content'] = array('head' => $head, 'items' => $tmp);
			}else{
        $result['status'] = 0;
        $result['content'] = 'Parameter pencarian harus diisi';
      }

			$this->response($result,200);
		}

		function count_get(){
			$result = array('status' => 1, 'content' => '');
			$_pid = $this->input->get('pid');
      $_fiscalyear = $this->input->get('fiscalyear');
			$_date = $this->input->get('date');
			$_items =  $this->input->get('items');
      $_error = 0;
      $_message = array();
      if(empty($_pid)){
        $_error++;
        array_push($_message,'PID harus diisi');
      }
      if(empty($_fiscalyear)){
        $_error++;
        array_push($_message,'Fiscal year harus diisi');
      }
			if(!$_error){
				$inputan = array(
					'PHYSINVENTORY' => $_pid,
					'FISCALYEAR' => $_fiscalyear,
					'COUNT_DATE' => $_date,
					'ITEMS' => $_items
				);
				$t = $this->om->countOpname($inputan);

				$tmp = $t['EXPORT_PARAM_TABLE']['RETURN'];

				if($this->enableLog){
					log_message('error',' Count opname '.json_encode($inputan));
				}
				$result['content'] = $tmp[0];
			}else{
        $result['status'] = 0;
        $result['content'] = 'Parameter pencarian harus diisi';
      }

			$this->response($result,200);
		}

		function recount_get(){
			$result = array('status' => 1, 'content' => '');
			$_pid = $this->input->get('pid');
      $_fiscalyear = $this->input->get('fiscalyear');
			$_items =  $this->input->get('items');
      $_error = 0;
      $_message = array();
      if(empty($_pid)){
        $_error++;
        array_push($_message,'PID harus diisi');
      }
      if(empty($_fiscalyear)){
        $_error++;
        array_push($_message,'Fiscal year harus diisi');
      }
			if(!$_error){
				$inputan = array(
					'PHYSINVENTORY' => $_pid,
					'FISCALYEAR' => $_fiscalyear,
					'ITEMS' => $_items
				);
				$t = $this->om->recountOpname($inputan);

				$tmp = $t['EXPORT_PARAM_TABLE']['RETURN'];

				if($this->enableLog){
					log_message('error',' Recount opname '.json_encode($inputan));
				}
				$result['content'] = $tmp[0];
			}else{
        $result['status'] = 0;
        $result['content'] = 'Parameter pencarian harus diisi';
      }

			$this->response($result,200);
		}

		function posting_get(){
			$result = array('status' => 1, 'content' => '');
			$_pid = $this->input->get('pid');
      $_fiscalyear = $this->input->get('fiscalyear');
			$_date = $this->input->get('date');
      $_error = 0;
      $_message = array();
      if(empty($_pid)){
        $_error++;
        array_push($_message,'PID harus diisi');
      }
      if(empty($_fiscalyear)){
        $_error++;
        array_push($_message,'Fiscal year harus diisi');
      }
			if(!$_error){
				$inputan = array(
					'PHYSINVENTORY' => $_pid,
					'FISCALYEAR' => $_fiscalyear,
					'PSTNG_DATE' => $_date
				);
				$t = $this->om->postingOpname($inputan);
				$tmp = $t['EXPORT_PARAM_TABLE']['RETURN'];

				if($this->enableLog){
					log_message('error',' Posting opname '.json_encode($inputan));
				}
				$result['content'] = $tmp[0];
			}else{
        $result['status'] = 0;
        $result['content'] = 'Parameter pencarian harus diisi';
      }

			$this->response($result,200);
		}

		function _opnameData($input = NULL){
			$t = $this->om->opnameData($input);
			return $t;
		}

    function _detailData($pid,$fiscalyear){
			$t = $this->om->detailData($pid,$fiscalyear);
			return $t;
		}

    private function addMaterialDescription($tmp){
      $_material = array();
      $result = array();
      foreach($tmp as $t){
        array_push($_material,$t['MATERIAL']);
      }
      $material = array_unique($_material);
      $this->load->model('Material_model','mm');
      $_dm = $this->mm->detailData($material);
      $descriptionMaterial = $_dm['EXPORT_PARAM_TABLE']['MATNRLIST'];
      $nameMaterial = $this->groupingMaterial($descriptionMaterial);

      foreach($tmp as $_t){
        $_t['MATNR_DESCRIPTION'] = $nameMaterial[$_t['MATERIAL']];
        array_push($result,$_t);
      }
      return $result;
    }

    private function groupingMaterial($tmp){
      $result = array();
      foreach($tmp as $_t){
        $matnr = $_t['MATERIAL'];
        if(!isset($result[$matnr])){
          $result[$matnr] = $_t['MATL_DESC'];
        }
      }
      return $result;
    }
}

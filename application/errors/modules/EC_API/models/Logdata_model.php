<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Logdata_model extends CI_Model {
  function __construct()
    {
        // Construct our parent class
        parent::__construct();
        $this->load->library('sap_invoice');
    }

    function datalog($_rcpudt = NULL,$_rwerks = NULL){
      $rcpudt = array();
			$rwerks = array();

			if(!empty($_rcpudt)){
				foreach($_rcpudt as $_rp){
					array_push($rcpudt,array(
							'SIGN' => 'I',
							'OPTION' => 'EQ',
							'LOW' => $_rp
						)
					);
				}
			}

			if(!empty($_rwerks)){
				foreach($_rwerks as $_rp){
					array_push($rwerks,array(
							'SIGN' => 'I',
							'OPTION' => 'EQ',
							'LOW' => $_rp
						)
					);
				}
			}

      $input = array(
				'EXPORT_PARAM_SINGLE' => array(),
        'EXPORT_PARAM_TABLE' => array(),
      );

			if(!empty($rcpudt)){
				$input['EXPORT_PARAM_TABLE']['R_CPUDT'] = $rcpudt;
			}
			if(!empty($rwerks)){
				$input['EXPORT_PARAM_TABLE']['R_WERKS'] = $rwerks;
			}

      $output = array(
        'EXPORT_PARAM_TABLE' => array('T_DATA')
      );
			$t = $this->sap_invoice->callFunction('ZCMM_GOODSMVT_HIST',$input,$output);
			return $t;
    }
}

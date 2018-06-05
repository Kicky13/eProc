<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Opname_model extends CI_Model {
  function __construct()
    {
        // Construct our parent class
        parent::__construct();
        $this->load->library('sap_invoice');
    }

    function detailData($pid,$fiscalyear){
      $input = array(
				'EXPORT_PARAM_SINGLE' => array(
          'PHYSINVENTORY' => $pid,
          'FISCALYEAR' => $fiscalyear
        ),
      );
      $output = array(
        'EXPORT_PARAM_ARRAY' => array('HEAD'),
        'EXPORT_PARAM_TABLE' => array('ITEMS')
      );
			$t = $this->sap_invoice->callFunction('BAPI_MATPHYSINV_GETDETAIL',$input,$output);
			return $t;
		}

    function opnameData($inputan = NULL){
			$rwerks = array();
      $_rwerks = isset($inputan['PLANT_RA']) ? $inputan['PLANT_RA'] : array();
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
      $stge = array();
      $_stge = isset($inputan['STGE_LOC_RA']) ? $inputan['STGE_LOC_RA'] : array();
			if(!empty($_stge)){
				foreach($_stge as $_rp){
					array_push($stge,array(
							'SIGN' => 'I',
							'OPTION' => 'EQ',
							'LOW' => $_rp
						)
					);
				}
			}

      $input = array(
				'EXPORT_PARAM_SINGLE' => array(),
        'EXPORT_PARAM_TABLE' => array(
					'ADJUST_STATUS_RA' => array(
						array(
							'SIGN' => 'I',
							'OPTION' => 'EQ',
							'LOW' => ''
						)
					)
				),
      );

			if(!empty($rwerks)){
				$input['EXPORT_PARAM_TABLE']['PLANT_RA'] = $rwerks;
			}

      if(!empty($stge)){
				$input['EXPORT_PARAM_TABLE']['STGE_LOC_RA'] = $stge;
			}

      $output = array(
        'EXPORT_PARAM_TABLE' => array('HEADERS')
      );
			$t = $this->sap_invoice->callFunction('BAPI_MATPHYSINV_GETLIST',$input,$output);
			return $t;
		}

    function countOpname($inputan){
      $input = array(
				'EXPORT_PARAM_SINGLE' => array(
          'PHYSINVENTORY' => $inputan['PHYSINVENTORY'],
          'FISCALYEAR' => $inputan['FISCALYEAR'],
          'COUNT_DATE' => $inputan['COUNT_DATE'],
        ),
        'EXPORT_PARAM_TABLE' => array(
          'ITEMS' => $inputan['ITEMS']
        ),
      );

      $output = array(
        'EXPORT_PARAM_TABLE' => array('RETURN')
      );
      $commit = 1;
			$t = $this->sap_invoice->callFunction('BAPI_MATPHYSINV_COUNT',$input,$output,$commit);
			return $t;
    }

    function recountOpname($inputan){
      $input = array(
				'EXPORT_PARAM_SINGLE' => array(
          'PHYSINVENTORY' => $inputan['PHYSINVENTORY'],
          'FISCALYEAR' => $inputan['FISCALYEAR']
        ),
        'EXPORT_PARAM_TABLE' => array(
          'ITEMS' => $inputan['ITEMS']
        ),
      );

      $output = array(
        'EXPORT_PARAM_TABLE' => array('RETURN')
      );
      $commit = 1;
			$t = $this->sap_invoice->callFunction('BAPI_MATPHYSINV_CHANGECOUNT',$input,$output,$commit);
			return $t;
    }

    function postingOpname($inputan){
      $input = array(
				'EXPORT_PARAM_SINGLE' => array(
          'PHYSINVENTORY' => $inputan['PHYSINVENTORY'],
          'FISCALYEAR' => $inputan['FISCALYEAR'],
          'PSTNG_DATE' => $inputan['PSTNG_DATE']
        ),
        'EXPORT_PARAM_TABLE' => array(
          'ITEMS' => $inputan['ITEMS']
        ),
      );

      $output = array(
        'EXPORT_PARAM_TABLE' => array('RETURN')
      );
      $commit = 1;
			$t = $this->sap_invoice->callFunction('BAPI_MATPHYSINV_POSTDIFF',$input,$output,$commit);
			return $t;
    }

}

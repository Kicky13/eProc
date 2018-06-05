<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Movementtype_model extends CI_Model {
  function __construct()
    {
        // Construct our parent class
        parent::__construct();
        $this->load->library('sap_invoice');
    }

    function listMovementType($_rbwart,$_rsobkz){
      $rsobkz = array();
      $rbwart = array();
      $rspras = array();
      if(!empty($_rbwart)){
				foreach($_rbwart as $_rp){
					array_push($rbwart,array(
							'SIGN' => 'I',
							'OPTION' => 'CP',
							'LOW' => $_rp
						)
					);
				}
			}
      if(!empty($_rsobkz)){
				foreach($_rsobkz as $_rp){
					array_push($rsobkz,array(
							'SIGN' => 'I',
							'OPTION' => 'EQ',
							'LOW' => $_rp
						)
					);
				}
			}
      $_rspras = array('EN');
      if(!empty($_rspras)){
				foreach($_rspras as $_rp){
					array_push($rspras,array(
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

			if(!empty($rspras)){
				$input['EXPORT_PARAM_TABLE']['R_SPRAS'] = $rspras;
			}
			if(!empty($rbwart)){
				$input['EXPORT_PARAM_TABLE']['R_BWART'] = $rbwart;
			}
			if(!empty($rsobkz)){
				$input['EXPORT_PARAM_TABLE']['R_SOBKZ'] = $rsobkz;
			}
      $output = array(
          'EXPORT_PARAM_TABLE' => array('T_DATA')
      );
      $t = $this->sap_invoice->callFunction('ZCMM_MVT_LIST',$input,$output);
      return $t;
    }
}

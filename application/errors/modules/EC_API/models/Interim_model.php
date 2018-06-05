<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Interim_model extends CI_Model {
  function __construct()
    {
        // Construct our parent class
        parent::__construct();
        $this->load->library('sap_invoice');
    }

    function data($input){
      $rlgtyp = array();
			$rwerks = array();
      $rlgnum = array();
      $rlqnum = array();
      $rmatnr = array();
      $rlgpla = array();
      $_rlgtyp = isset($input['rlgtyp']) ? $input['rlgtyp'] : array();
      $_rwerks = isset($input['rwerks']) ? $input['rwerks'] : array();
      $_rlgnum = isset($input['rlgnum']) ? $input['rlgnum'] : array();
      $_rlqnum = isset($input['rlqnum']) ? $input['rlqnum'] : array();
      $_rmatnr = isset($input['rmatnr']) ? $input['rmatnr'] : array();
      $_rlgpla = isset($input['rlgpla']) ? $input['rlgpla'] : array();

			if(!empty($_rlgtyp)){
				foreach($_rlgtyp as $_rp){
					array_push($rlgtyp,array(
							'SIGN' => 'I',
							'OPTION' => 'CP',
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

      if(!empty($_rlgnum)){
				foreach($_rlgnum as $_rp){
					array_push($rlgnum,array(
							'SIGN' => 'I',
							'OPTION' => 'EQ',
							'LOW' => $_rp
						)
					);
				}
			}

      if(!empty($_rlqnum)){
        foreach($_rlqnum as $_rp){
          array_push($rlqnum,array(
              'SIGN' => 'I',
              'OPTION' => 'EQ',
              'LOW' => $_rp
            )
          );
        }
      }

      if(!empty($_rmatnr)){
        foreach($_rmatnr as $_rp){
          array_push($rmatnr,array(
              'SIGN' => 'I',
              'OPTION' => 'EQ',
              'LOW' => $_rp
            )
          );
        }
      }

      if(!empty($_rlgpla)){
        foreach($_rlgpla as $_rp){
          array_push($rlgpla,array(
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

			if(!empty($rlgtyp)){
				$input['EXPORT_PARAM_TABLE']['R_LGTYP'] = $rlgtyp;
			}
			if(!empty($rwerks)){
				$input['EXPORT_PARAM_TABLE']['R_WERKS'] = $rwerks;
			}
      if(!empty($rlgnum)){
				$input['EXPORT_PARAM_TABLE']['R_LGNUM'] = $rlgnum;
			}
			if(!empty($rlqnum)){
				$input['EXPORT_PARAM_TABLE']['R_LQNUM'] = $rlqnum;
			}
      if(!empty($rmatnr)){
				$input['EXPORT_PARAM_TABLE']['R_MATNR'] = $rmatnr;
			}
			if(!empty($rlgpla)){
				$input['EXPORT_PARAM_TABLE']['R_LGPLA'] = $rlgpla;
			}

      $output = array(
        'EXPORT_PARAM_TABLE' => array('T_DATA')
      );
			$t = $this->sap_invoice->callFunction('ZCMM_GET_STOCK_WM_LLST',$input,$output);
			return $t;
    }

    public function clearInterim($data){
      $input = array(
				'EXPORT_PARAM_SINGLE' => array(),
      );
			if(!empty($data)){
				$input['EXPORT_PARAM_SINGLE'] = $data;
			}

      $output = array(
        'EXPORT_PARAM_SINGLE' => array('E_TANUM'),
        'EXPORT_PARAM_ARRAY' => array('T_MESSAGE')
      );
      
			$t = $this->sap_invoice->callFunction('ZRMM_L_TO_CREATE_SINGLE',$input,$output);
      return $t;
    }
}

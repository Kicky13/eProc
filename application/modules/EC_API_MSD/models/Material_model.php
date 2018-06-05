<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Material_model extends CI_Model {
  function __construct()
    {
        // Construct our parent class
        parent::__construct();
        $this->load->library('sap_invoice');
    }

    function detailData($_materialNumber = array()){
      $materialNumber = array();
			if(!empty($_materialNumber)){
				foreach($_materialNumber as $_rp){
					array_push($materialNumber,array(
							'SIGN' => 'I',
							'OPTION' => 'EQ',
							'MATNR_LOW' => $_rp
						)
					);
				}
			}

      $input = array(
				'EXPORT_PARAM_TABLE' => array(
          'MATNRSELECTION' => $materialNumber
        ),
      );
      $output = array(
        'EXPORT_PARAM_TABLE' => array('MATNRLIST')
      );

			$t = $this->sap_invoice->callFunction('BAPI_MATERIAL_GETLIST',$input,$output);
			return $t;
		}

    function longtext($_matnr){
      $input = array(
				'EXPORT_PARAM_SINGLE' => array()
      );

      if(!empty($_matnr)){
        $input['EXPORT_PARAM_SINGLE']['FI_MATERIAL'] = $_matnr;
      }

      $output = array(
          'EXPORT_PARAM_TABLE' => array('FT_LONG_TEXT')
      );

      $t = $this->sap_invoice->callFunction('Z_ZCMM_MATERIAL_LONG_TEXT',$input,$output);
      return $t;
    }

    function list_material($_rmatnr,$_rmaktg,$_rrow){
      $rmatnr = array();
      $rmaktg = array();
      $rspras = array();
      if(!empty($_rmatnr)){
        foreach($_rmatnr as $_rp){
          array_push($rmatnr,array(
              'SIGN' => 'I',
              'OPTION' => 'CP',
              'LOW' => $_rp
            )
          );
        }
      }
      if(!empty($_rmaktg)){
        foreach($_rmaktg as $_rp){
          array_push($rmaktg,array(
              'SIGN' => 'I',
              'OPTION' => 'CP',
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
      if(!empty($_rrow)){
        $input['EXPORT_PARAM_SINGLE']['I_ROW'] = $_rrow;
      }

      if(!empty($rspras)){
        $input['EXPORT_PARAM_TABLE']['R_SPRAS'] = $rspras;
      }
      if(!empty($rmaktg)){
        $input['EXPORT_PARAM_TABLE']['R_MAKTG'] = $rmaktg;
      }
      if(!empty($rmatnr)){
        $input['EXPORT_PARAM_TABLE']['R_MATNR'] = $rmatnr;
      }
      $output = array(
          'EXPORT_PARAM_TABLE' => array('T_DATA')
      );
      $t = $this->sap_invoice->callFunction('ZCMM_MATERIALMAKT_LIST',$input,$output);
      return $t;
    }

    function stock($inputData){
      $matnr = array();
      $werks = array();
      $_matnr = $inputData['R_MATNR'];
      $_werks = $inputData['R_WERKS'];

      if(!empty($_matnr)){
        foreach($_matnr as $_rp){
          array_push($matnr,array(
              'SIGN' => 'I',
              'OPTION' => 'EQ',
              'LOW' => $_rp
            )
          );
        }
      }

      if(!empty($_werks)){
        foreach($_werks as $_rp){
          array_push($werks,array(
              'SIGN' => 'I',
              'OPTION' => 'EQ',
              'LOW' => $_rp
            )
          );
        }
      }
      $input = array(
        'EXPORT_PARAM_TABLE' => array()
      );
      if(!empty($matnr)){
         $input['EXPORT_PARAM_TABLE']['R_MATNR'] = $matnr;
      }
      if(!empty($werks)){
         $input['EXPORT_PARAM_TABLE']['R_WERKS'] = $werks;
      }
      $output = array(
        'EXPORT_PARAM_TABLE' => array('T_DATA'),
        'EXPORT_PARAM_ARRAY' => array('RETURN')
      );

      $t = $this->sap_invoice->callFunction('ZCMM_COLLECT_STOCK',$input,$output);
      // return array('error' => $t['EXPORT_PARAM_ARRAY']['RETURN'], 'success' => $t['EXPORT_PARAM_TABLE']['T_DATA']);
      return($t['EXPORT_PARAM_TABLE']['T_DATA']);
    }
}

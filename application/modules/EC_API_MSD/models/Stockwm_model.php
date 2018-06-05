<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Stockwm_model extends CI_Model {
  function __construct()
    {
        // Construct our parent class
        parent::__construct();
        $this->load->library('sap_invoice');
    }

    function data($inputData = array()){

      //$text,$lgnum,$lgtyp,$lgpla,$plant,$sloc
      $input = array(
        'EXPORT_PARAM_SINGLE' => array(
          	'I_TEXT' => isset($inputData['text']) ? $inputData['text'] : '',
						'I_LGNUM' => isset($inputData['lgnum']) ? $inputData['lgnum'] : '',
						'I_LGTYP' => isset($inputData['lgtyp']) ? $inputData['lgtyp'] : '',
						'I_LGPLA' => isset($inputData['lgpla']) ? $inputData['lgpla'] : '',
						'I_PLANT' => isset($inputData['plant']) ? $inputData['plant'] : '',
						'I_SLOC' => isset($inputData['sloc']) ? $inputData['sloc'] : '',
        ),
      );

      $output = array(
        'EXPORT_PARAM_TABLE' => array('T_LQUA')
      );

      $t = $this->sap_invoice->callFunction('ZCMM_GET_STOCK_WM',$input,$output);
      return $t;
    }

    function checkstock($matnr,$werks,$lgort){
      $input = array(
        'EXPORT_PARAM_ARRAY' => array(
          'XPARAM' => array(
						'MATNR' => $matnr,
						'WERKS' => $werks,
						'LGORT' => $lgort
					)
        ),
      );

      $output = array(
        'EXPORT_PARAM_TABLE' => array('RETURN_DATA')
      );
      $t = $this->sap_invoice->callFunction('Z_ZAPPSD_STOCK_INV',$input,$output);
      return $t;
    }
}

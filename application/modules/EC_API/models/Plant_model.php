<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Plant_model extends CI_Model {
  function __construct()
    {
        // Construct our parent class
        parent::__construct();
        $this->load->library('sap_invoice');
    }

    function listPlant($_werks,$_vkorg,$_name1){
      $input = array(
        'EXPORT_PARAM_SINGLE' => array(
          'I_WERKS' => $_werks,
          'I_VKORG' => $_vkorg,
          'I_NAME1' => $_name1
        ),
      );

      $output = array(
          'EXPORT_PARAM_TABLE' => array('T_PLANT')
      );
      $t = $this->sap_invoice->callFunction('Z_ZAPPSD_PLANT_SEL',$input,$output);
      return $t;
    }
}

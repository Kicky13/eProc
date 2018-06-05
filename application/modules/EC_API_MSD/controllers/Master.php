<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends REST_Controller
{
  protected $result = array('status' => 0, 'content' => '');
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        $this->load->library('sap_invoice');
    }

    function plant_get()
    {
      $this->load->model('Plant_model','pm');
      $_werks = $this->get('werks');
      $_vkorg = $this->get('vkorg');
      $_name1 = $this->get('name1');

      $t = $this->pm->listPlant($_werks,$_vkorg,$_name1);
      $this->result['status'] = 1;
      $this->result['content'] = $t['EXPORT_PARAM_TABLE']['T_PLANT'];
      $this->response($this->result, 200); // 200 being the HTTP response code
    }

    function material_get()
    {
      $this->load->model('Material_model','mm');
      $_rmatnr = $this->get('matnr');
      $_rmaktg = $this->get('maktg');
      $_rrow = $this->get('row');

      $t = $this->mm->list_material($_rmatnr,$_rmaktg,$_rrow);
      $this->result['status'] = 1;
      $this->result['content'] = $t['EXPORT_PARAM_TABLE']['T_DATA'];
      $this->response($this->result, 200); // 200 being the HTTP response code
    }

    function movementType_get()
    {
      $this->load->model('Movementtype_model','mtm');
      $_rbwart = $this->get('bwart');
      $_rsobkz = $this->get('sobkz');

      $t = $this->mtm->listMovementType($_rbwart,$_rsobkz);
      $this->result['status'] = 1;
      $this->result['content'] = $t['EXPORT_PARAM_TABLE']['T_DATA'];
      $this->response($this->result, 200); // 200 being the HTTP response code
    }

    function longtext_get()
    {
      $this->load->model('Material_model','mm');
      $_matnr = $this->get('matnr');
      if(!empty($_matnr)){
        $t = $this->mm->longtext($_matnr);
        $this->result['status'] = 1;
        $this->result['content'] = $t;
      }else{
        $this->result['content'] = 'Parameter matnr harus diisi';
      }

      $this->response($this->result, 200); // 200 being the HTTP response code
    }

    function spesialStok_get(){
      $t = array(
        '0' => 'No Special Stock',
        'E' => 'Orders on hand',
        'K' => 'Consignment(vendor)',
        'M' => 'Ret.trans.pkg vendor',
        'O' => 'Partsprov. vendor',
        'P' => 'Pipeline material',
        'Q' => 'Project stock',
        'V' => 'Ret. pkgw. customer',
        'W' => 'Consignment (cust.)',
        'Y' => 'Shipping unit (whse)'
      );
      $this->result['status'] = "1";
      $this->result['content'] = array(array('code'=>'0','name'=>'No Special Stock'), array('code'=>'E','name'=>'Orders on hand'), array('code'=>'K','name'=>'Consignment(vendor)'), 
        array('code'=>'M','name'=>'Ret.trans.pkg vendor'),array('code'=>'O','name'=>'Partsprov. vendor'),array('code'=>'P','name'=>'Pipeline material'),
        array('code'=>'Q','name'=>'Project stock'),array('code'=>'V','name'=>'Ret. pkgw. customer'),array('code'=>'W','name'=>'Consignment (cust.)'),
        array('code'=>'Y','name'=>'Shipping unit (whse)'));
      //$this->result['content'] = $con;
      $this->response($this->result, 200); // 200 being the HTTP response code
    }
}

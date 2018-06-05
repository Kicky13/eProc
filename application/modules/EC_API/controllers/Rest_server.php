<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rest_server extends MX_Controller {

    public function index()
    {
        $this->load->helper('url');
        $this->load->view('rest_server');
      //  $r = $this->db->get('EC_KEYS')->result_array();
      //  print_r($r);
    }

    public function apikey()
    {
        $this->load->helper('url');
        $api_keys = $this->db->order_by('ID')->get('EC_KEYS')->result_array();
        $this->load->view('api_key',array('keys' => $api_keys));
      //  $r = $this->db->get('EC_KEYS')->result_array();
      //  print_r($r);
    }

    
}

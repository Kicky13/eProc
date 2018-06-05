<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_Performance_Who_App extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
	}

	public function index() {
		redirect('Vendor_performance_who_app/list_who_app');
	}

	public function list_who_app(){
		$this->load->model(array('vnd_perf_who_app'));
		$this->layout->set_table_cs();
		$data['title'] = "List Who App";
        $data['list_tahap_1']=$this->vnd_perf_who_app->show_list_tahap1();
		$data['list_tahap_2']=$this->vnd_perf_who_app->show_list_tahap2();
		$this->layout->render('form_set_app', $data);
	}
    
    public function save_who_app(){
       
        $this->load->model(array('vnd_perf_who_app'));
        $data = array('VND_EMP_ID' => $_POST['tahap-1']);
        $this->vnd_perf_who_app->update_who_app($data,1);
        $data = array('VND_EMP_ID' => $_POST['tahap-2']);
        $this->vnd_perf_who_app->update_who_app($data,2);
        
        
         
       
        $this->session->set_flashdata('success', "Role App For Vendor updated");
        redirect(site_url('Vendor_performance_who_app/list_who_app'));
    }

	

}
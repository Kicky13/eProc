<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Thithe_migrasi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> library('email');
		$this -> load -> library('form_validation');
		$this -> load -> library("file_operation");
		$this -> load -> library('Layout');
		$this -> load -> library('Authorization');
		$this -> load -> helper('url');
		$this->kolom_xl = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	}

	public function index() {
		$data['title'] = 'Halaman Migrasi e-Procurement';
		$this->layout->render('thithe_migrasi/thithe_migrasi',$data);
	}

	public function do_upload()
	{
		
		$config['upload_path'] = './assets/uploads/';
		$config['allowed_types'] = 'xlsx|xls';
		$p = $this->input->post();
		
		$this->load->library('upload', $config);
		$this -> load -> model('thithe_migration');

		$data = array('upload_data' => $this->upload->data());
        $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
        $filename = $upload_data['file_name'];//Nama File
        if($p['table_gan']=="VND_HEADER"){
        	$this -> thithe_migration ->uploaddatavh($filename);
        } else if($p['table_gan']=="VND_ADDRESS"){
        	$this -> thithe_migration ->uploaddatavadd($filename);
        } else if($p['table_gan']=="VND_AKTA"){
        	$this -> thithe_migration ->uploaddatavakta($filename);
        } else if($p['table_gan']=="VND_AGENT"){
        	$this -> thithe_migration ->uploaddatavagent($filename);
        } else if($p['table_gan']=="VND_BOARD"){
        	$this -> thithe_migration ->uploaddatavboard($filename);
        } else if($p['table_gan']=="VND_BANK"){
        	$this -> thithe_migration ->uploaddatavbank($filename);
        } else if($p['table_gan']=="HIST_VND_HEADER"){
        	$this -> thithe_migration ->uploaddatahisheader($filename);
        } else if($p['table_gan']=="VND_PRODUCT_UPDATE"){
        	$this -> thithe_migration ->uploaddatavproduct($filename);
        } 

        redirect('Thithe_migrasi/index/');
    }
}

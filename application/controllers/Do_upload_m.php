<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Do_upload_m extends CI_Controller {

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
		$this->layout->render('upload/upload_fajar',$data);
	}

	public function do_upload()
	{
		
		$config['upload_path'] = './assets/uploads/';
		$config['allowed_types'] = 'xlsx|xls';
		$p = $this->input->post();
		
		$this->load->library('upload', $config);
		$this -> load -> model('do_upload');

		$data = array('upload_data' => $this->upload->data());
        $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
        $filename = $upload_data['file_name'];//Nama File 
        // if($p['table_gan']=="VND_FIN_RPT"){
        	// $this -> do_upload ->uploaddataKeuangan($filename); 
        // }

        if($p['table_gan']=="LAP_KEU"){
        	$this -> do_upload ->uploaddataKeuangan($filename); 
        } else if($p['table_gan']=="BARANG_DIPASOK"){
        	$this -> do_upload ->uploaddatapasok($filename);
        } else if($p['table_gan']=="JASA_DISUPLAI"){
        	$this -> do_upload ->uploaddatasuplay($filename);
        } else if($p['table_gan']=="SERTIFIKASI"){
        	$this -> do_upload ->uploaddatacert($filename);
        } else if($p['table_gan']=="PENGALAMAN"){
        	$this -> do_upload ->uploaddatapeng($filename);
        } 

        redirect('Do_upload_m/index/');
    }
}

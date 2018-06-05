<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		
        class Menu extends CI_Controller {

        public function __construct() {
                parent::__construct();
               
        $this->db = $this->load->database('default', TRUE);
        $this->load->helper("security" ); 
		$this->load->library(array('form_validation','session'));
        $this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model('m_global');
		
            
        }

		function index(){
		
		
		$data['title'] = "Master Menu";
		//$this->layout->set_table_js();
		//$this->layout->set_table_cs();
		
		//$this->layout->set_table_selected_css();
		$this->layout->set_validate_css();
		$this->layout->set_tree_css();
		$this->layout->set_tree_js();
		$this->layout->set_validate_js();
		
		//
		$this->layout->render('v_ms_menu', $data);
        //$this->load->view('v_adm_plant',$data);
        
    }  
	function load_data_tree(){
		
		$this->load->view('v_menu_tree');
		}
	
	function getTree(){
		
		    	//$data_post=$this->security->xss_clean($_REQUEST);
				$da="SELECT m1.ID_MENU ID,m1.KODE_MENU||' ' ||m1.NAMA_MENU AS TITLE,m1.CONTROLLER_PATH AS URL,m1.MENU_PARENT PARENT_ID,m1.NAMA_MENU NAMA,
m1.KODE_MENU KODE, m2.KODE_MENU AS PARENT_KODE,m1.aktif_menu AKTIF 	FROM APP_MENU m1 LEFT JOIN APP_MENU m2 ON m2.ID_MENU =m1.MENU_PARENT WHERE m1.MENU_VENDOR=0 ORDER BY m1.KODE_MENU ASC";
		    	$data['dataTree'] = $this->m_global->mapTree($da);
		 				
				$dtree = $this->m_global->buildTree($data['dataTree']);
				echo json_encode($dtree);
	}

		function crud() {
			
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		
	    $data_post=$this->input->post();
		$this->form_validation->set_rules('kode31', 'Kode', 'required');
		$this->form_validation->set_rules('nama31', 'Nama', 'required');
		$this->form_validation->set_rules('url31', 'Url', 'required');
		$this->form_validation->set_rules('aktif31', 'Aktif', 'required');
		$data['title'] = "Master Menu";
		if ($this->form_validation->run() == FALSE) {
			
			if(form_error('kode31')){
				
				$data['inputerror'][] = 'kode31';
				$data['error_string'][] = 'First name is required';
				$data['status'] = FALSE;
				
				}
			if(form_error('nama31')){
				
				$data['inputerror'][] = 'nama31';
				$data['error_string'][] = 'First name is required';
				$data['status'] = FALSE;
				
				}
			if(form_error('url31')){
				
				$data['inputerror'][] = 'url31';
				$data['error_string'][] = 'First name is required';
				$data['status'] = FALSE;
				
				}
				
			echo json_encode(array('dt'=>$data));
			exit();
			
		}
		
		$new_menu=array();
		$new_menu['MENU_PARENT'] = $data_post['parent_id31'];
		$new_menu['NAMA_MENU'] = $data_post['nama31'];
		$new_menu['CONTROLLER_PATH'] = $data_post['url31'];
		$new_menu['MENU_VENDOR'] = '0';
		$new_menu['KODE_MENU'] = $data_post['kode31'];
		$new_menu['AKTIF_MENU'] = $data_post['aktif31'];
	    switch ($data_post['act']) {
			
	        case 'Simpan':
			
				$new_menu['ID_MENU'] = $this->m_global->get_id('ID_MENU','APP_MENU');
				
				if($this->m_global->insert_custom('APP_MENU',$new_menu)){
					echo json_encode(array('ket'=>"Penambahan Data Berhasil",'dt'=>$data)) ;
					
					}else{
						echo json_encode(array('ket'=>"Gagal Insert",'dt'=>$data)) ;
						}
				
				break;
	        case 'Ubah':
				$where=array();
				$where['ID_MENU']=$data_post['id31'];
				if($this->m_global->update('APP_MENU',$new_menu,$where)){
				echo json_encode(array('ket'=>"Update Data Berhasil",'dt'=>$data)) ;
				}
				else{
					echo json_encode(array('ket'=>"Gagal Update",'dt'=>$data)) ;
				}
			 
	          
	            break;
	        case 'Hapus':
				$sql=array();
				$sql[]="DELETE FROM APP_MENU WHERE ID_MENU='".$data_post['id31']."'";
				$sql[]="DELETE FROM APP_MENU WHERE MENU_PARENT='".$data_post['id31']."'";
				
				 if($this->m_global->delete($sql)){
				echo json_encode(array('ket'=>"Hapus Data Berhasil",'dt'=>$data)) ;
				}
				else{
					echo json_encode(array('ket'=>"Batal Hapus",'dt'=>$data)) ;
				}
			//echo json_encode(array('ket'=>"Hapus Data Berhasil",'dt'=>$data)) ;
	           
	        break;
		}
	} 
		}
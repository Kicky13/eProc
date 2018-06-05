<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		
        class Tree_unit extends CI_Controller {

        public function __construct() {
                parent::__construct();
               
       // $this->db = $this->load->database('default', TRUE);
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
		$this->layout->render('v_tunit', $data);
        //$this->load->view('v_adm_plant',$data);
        
    }  
	
	
	function getTree(){
		
		    	//$data_post=$this->security->xss_clean($_REQUEST);
				$da="SELECT DEPT_ID ID, DEP_CODE||' '|| DEPT_NAME||' '||DEPT_LEVEL  TITLE,DEPT_KODE_PARENT PARENT_ID,DEPT_NAME NAMA, DEPT_COMPANY,DEP_CODE KODE FROM ADM_DEPT WHERE DEPT_KODE_PARENT=0";// WHERE COMPANY=2000";
				//$da="SELECT m1.ID_MENU ID,m1.KODE_MENU||' ' ||m1.NAMA_MENU AS TITLE,m1.CONTROLLER_PATH AS URL,m1.MENU_PARENT PARENT_ID,m1.NAMA_MENU NAMA,
//m1.KODE_MENU KODE, m2.KODE_MENU AS PARENT_KODE,m1.aktif_menu AKTIF 	FROM APP_MENU m1 LEFT JOIN APP_MENU m2 ON m2.ID_MENU =m1.MENU_PARENT  ORDER BY m2.KODE_MENU ASC";
		    	$data['dataTree'] = $this->m_global->mapTree_unit($da);
		 		
				$dtree = $this->m_global->buildTree($data['dataTree']);
				echo json_encode($dtree);
				
	}
	
	function getTree_lazy(){
		
		    	$data_post=$this->input->get();
				$da="SELECT ADM_DEPT.DEPT_ID ID, DEP_CODE||' '|| DEPT_NAME||' '||DEPT_LEVEL TITLE,DEPT_KODE_PARENT PARENT_ID,DEPT_NAME NAMA, DEPT_COMPANY,DEP_CODE KODE FROM ADM_DEPT
				 WHERE DEPT_KODE_PARENT='".$data_post['key']."'";
				//$da="SELECT ADM_DEPT.DEPT_ID ID, DEP_CODE||' '|| DEPT_NAME||' '||DEPT_LEVEL||' '||POS_NAME  TITLE,DEPT_KODE_PARENT PARENT_ID,DEPT_NAME NAMA, DEPT_COMPANY,DEP_CODE KODE FROM ADM_DEPT
				//INNER JOIN ADM_POS ON ADM_DEPT.DEP_CODE=ADM_POS.DEPT_KODE WHERE POS_AKTIF=1 AND DEPT_KODE_PARENT='".$data_post['key']."'";
				//$da="SELECT  M_UB_UNIT_KERJA.MUK_KODE ID, M_UB_UNIT_KERJA.MUK_KODE||' '||M_UB_UNIT_KERJA.MUK_NAMA||' '||M_UB_UNIT_KERJA.MUK_LEVEL||' POSISI '||M_UB_JABATAN.MJAB_NAMA||' NAMA KARYAWAN '||M_UB_KARYAWAN.MK_NAMA ||' NO PEG '||M_UB_KARYAWAN.MK_NOPEG  TITLE,
//M_UB_UNIT_KERJA.MUK_PARENT PARENT_ID,M_UB_UNIT_KERJA.MUK_NAMA NAMA, M_UB_UNIT_KERJA.COMPANY,M_UB_UNIT_KERJA.MUK_KODE KODE FROM M_UB_UNIT_KERJA LEFT JOIN
//M_UB_JABATAN ON M_UB_UNIT_KERJA.MUK_KODE=M_UB_JABATAN.MUK_KODE LEFT JOIN
//M_UB_KARYAWAN ON M_UB_JABATAN.MJAB_KODE =M_UB_KARYAWAN.MJAB_KODE WHERE M_UB_KARYAWAN.MJAB_KODE<>'999999999'AND M_UB_UNIT_KERJA.MUK_PARENT='".$data_post['key']."' ORDER BY M_UB_UNIT_KERJA.MUK_KODE,M_UB_KARYAWAN.MJAB_KODE";// WHERE COMPANY=2000";
////				
				//$da="SELECT MUK_KODE ID, MUK_KODE||' '|| MUK_NAMA||' '||MUK_LEVEL  TITLE,MUK_PARENT PARENT_ID,MUK_NAMA NAMA, COMPANY,MUK_KODE KODE FROM M_UB_UNIT_KERJA WHERE MUK_PARENT='".$data_post['key']."'";
				//$da="SELECT MUK_KODE ID, MUK_KODE||' '|| MUK_NAMA||' '||MUK_LEVEL  TITLE,MUK_PARENT PARENT_ID,MUK_NAMA NAMA, COMPANY,MUK_KODE KODE FROM M_UB_UNIT_KERJA WHERE M_UB_UNIT_KERJA.MUK_PARENT='".$data_post['key']."'";
				
		    	$data['dataTree'] = $this->m_global->mapTree_unit($da);
		 		//print_r($data['dataTree']); exit();	
				$dtree = $this->m_global->buildTree($data['dataTree'],$data_post['key']);
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
			
				$sql="DELETE FROM APP_MENU WHERE ID_MENU='".$data_post['id31']."';";
				$this->db->query($sql);
				//$sql="DELETE FROM APP_MENU WHERE MENU_PARENT='".$data_post['id31']."';";
				//$this->db->query($sql);
				 
			echo json_encode(array('ket'=>"Hapus Data Berhasil",'dt'=>$data)) ;
	           
	        break;
		}
	} 
		}
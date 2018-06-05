<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		
        class Group_akses extends CI_Controller {

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
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		//$this->layout->set_table_selected_css();
		$this->layout->set_validate_css();
		$this->layout->set_tree_css();
		$this->layout->set_tree_js();
		$this->layout->set_validate_js();
		$this->layout->add_js('pages/group_akses.js');
		$data["fk_ms_group_id03"]=$this->m_global->getcombo("SELECT APP_GRP_ID ID, NAMA_GRP NAMA FROM APP_GRP_MENU");
		//;
		
		$this->layout->render('v_ms_menu', $data);
        //$this->load->view('v_adm_plant',$data);
        
    }  
	function load_data_tree(){
		
		$this->load->view('v_menu_tree');
		}
	
	
	
	function getTree(){
    	$data_post=$this->input->post();
	   	$data['dataTree'] = $this->m_global->map_tree_map("SELECT m1.ID_MENU ID,m1.KODE_MENU||' ' ||m1.NAMA_MENU AS TITLE,m1.CONTROLLER_PATH AS URL,m1.MENU_PARENT PARENT_ID,m1.NAMA_MENU NAMA,
m1.KODE_MENU KODE, m1.AKTIF_MENU AKTIF,(CASE WHEN m2.APP_MENU_ID IS NOT NULL THEN '1' ELSE '0' END ) SLC
FROM APP_MENU m1 LEFT JOIN APP_GRP_AKSES_MENU m2 ON m1.ID_MENU =m2.APP_MENU_ID AND APP_GRP_MENU_ID ='".$data_post['fk_ms_group_id']."' WHERE m1.AKTIF_MENU=1 ORDER BY m1.KODE_MENU ASC");
		
		//print_r($data['dataTree']); exit();
		$dtree = $this->m_global->buildTree($data['dataTree'],0,true);
		
		echo json_encode($dtree);

    }


    function crud(){
    	$data_post=$this->input->post();
	    switch ($data_post['action']) {
	    	case 'Simpan':
	    		$arr_insr_['APP_GRP_MENU_ID']=$data_post['fk_ms_group_id'];
				$arr_insr_['APP_MENU_ID']=$data_post['fk_ms_menu_id'];
				//$arr_insr_['AKTIF']=1;
				//$sql_q[0]= $this->db->insert_string('k_ms_group_akses', $arr_insr_); 
				 
			 	
				if($this->m_global->insert_custom('APP_GRP_AKSES_MENU',$arr_insr_)){
					//echo json_encode(array('ket'=>"Penambahan Data Berhasil",'dt'=>$data)) ;
					
				}else{
					echo json_encode(array('ket'=>"Gagal Insert")) ;
				}
				
			 	
	    	break;
	    	case 'Hapus':
	    		$this->db->where('APP_GRP_MENU_ID', $data_post['fk_ms_group_id']);
	    		$this->db->where('APP_MENU_ID', $data_post['fk_ms_menu_id']);
				$this->db->delete('APP_GRP_AKSES_MENU');
				 
				// echo json_encode(array('ket'=>"Hapus Data Berhasil")) ;
	    	break;
	    }
    }
	
	
	
	function get_datatable_ub(){
		$this->load->model('m_global');
		$data_post=$this->security->xss_clean($_POST);
		$panjang=10; $mulai=0; $akhir=0;
		if(isset($data_post['length']) && $data_post['length']!='' && $data_post['length']!='0'){
			$panjang=$data_post['length'];
			}
		if(isset($data_post['start']) && $data_post['start']!='' ){
			$mulai=$data_post['start'];
			}
		$akhir=$panjang+$mulai;
		 $filter_data='';
		//if($data_post['caridata1']!='') $filter_data.=" and UPPER(ADM_DEPT.DEP_CODE) like '%". str_replace("'", "''", strtoupper($data_post['caridata1']))."%' "; 
		//if($data_post['caridata2']!='') $filter_data.=" and UPPER(ADM_DEPT.DEPT_NAME) like '%".str_replace("'", "''", strtoupper($data_post['caridata2']))."%' "; 
		//if($data_post['caridata3']!='') $filter_data.=" and UPPER(ADM_DEPT.DISTRICT_NAME) like '%".str_replace("'", "''", strtoupper($data_post['caridata3']))."%' "; 
			
		$i=0;
		$no=0;
		
		$colom=array('NAMA_GRP', 'APP_GRP_ID');
		
		$sql="SELECT ".implode(', ', $colom).",ROW_NUMBER() OVER (ORDER BY ".$colom[$data_post ['order'][0]['column']]." ".$data_post ['order'][0]['dir'].") BARIS FROM APP_GRP_MENU"; //$filter_data
		
		$totalData =$this->m_global->total_row($sql);
		$totalFiltered = $totalData;
		$sql= " SELECT * FROM (".$sql.") WHERE BARIS BETWEEN ".$mulai." AND ".$akhir ;
		//echo $sql; exit();
		$data1 = $this->m_global->grid_view($sql)->result_array();
		
		$data=array();
		foreach($data1 as $line){
			$data_tbl=array();
			$data_tbl['BARIS']=$line['BARIS']; 
			$data_tbl['NAMA_GRP']=$line['NAMA_GRP']; 
			$data_tbl['APP_GRP_ID']=$line['APP_GRP_ID'];
	    	$data[]=$data_tbl;
			$i++;
			$no++;
		}
		$json_data = array(
			"draw"            => intval( $data_post['draw'] ),
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ),
			"data"            => $data   // total data array
			);

			echo json_encode($json_data);
		
		
		}
	
	
	function simdata() {
			
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		
	    $data_post=$this->input->post();
		$this->form_validation->set_rules('namagroup', 'Nama Proup', 'required');
		
	//	$data['title'] = "Master Menu";
		if ($this->form_validation->run() == FALSE) {
			
			if(form_error('namagroup')){
				
				$data['inputerror'][] = 'namagroup';
				$data['error_string'][] = 'First name is required';
				$data['status'] = FALSE;
				
				}
			
				
			echo json_encode(array('dt'=>$data));
			exit();
			
		}
		
		$new_menu=array();
		$new_menu['NAMA_GRP'] = $data_post['namagroup'];
		
	    switch ($data_post['act']) {
			
	        case 'Simpan':
			
				//$new_menu['NAMA_GRP'] = $this->m_global->get_id('NAMA_GRP');
				
				if($this->m_global->insert_custom('APP_GRP_MENU',$new_menu)){
					echo json_encode(array('ket'=>"Penambahan Data Berhasil",'dt'=>$data)) ;
					
					}else{
						echo json_encode(array('ket'=>"Gagal Insert",'dt'=>$data)) ;
						}
				
				break;
	        case 'Ubah':
				$where=array();
				$where['APP_GRP_ID']=$data_post['app_grp_id'];
				if($this->m_global->update('APP_GRP_MENU',$new_menu,$where)){
				echo json_encode(array('ket'=>"Update Data Berhasil",'dt'=>$data)) ;
				}
				else{
					echo json_encode(array('ket'=>"Gagal Update",'dt'=>$data)) ;
				}
			 
	          
	            break;
	        case 'Hapus':
				$sql=array();
				$sql[]="DELETE FROM APP_GRP_MENU WHERE APP_GRP_ID='".$data_post['app_grp_id']."'";
				//$sql[]="DELETE FROM APP_MENU WHERE MENU_PARENT='".$data_post['id31']."'";
				
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
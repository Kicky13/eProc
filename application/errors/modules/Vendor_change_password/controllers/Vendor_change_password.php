<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_change_password extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->helper(array('captcha'));
	}

	public function change_password()
	{
		$this->load->model('vnd_header');
		$companyid = $this->input->post('Company');
		$this->load->model(array('vnd_reg_announcement', 'm_vnd_type'));
		$date = $this->vnd_reg_announcement->with('company')->get(array('COMPANYID' => $companyid));
		$companyname = $date["company"]["COMPANYNAME"];
		$session_id=$this->session->userdata("session_id");
		$vendor_id=$this->session->userdata('VENDOR_ID');
		$vnd = $this->vnd_header->get(array('VENDOR_ID'=>$vendor_id));
		// echo '<pre>'; var_dump($vnd); echo '</pre>';die;
		if (isset($session_id) && isset($vendor_id)) {			
			$data['title'] = 'Perubahan Password Vendor';
			$img_url = base_url()."static/images/captcha/";
			$vals = array(
				'img_path' => './static/images/captcha/',
				'img_url' => $img_url,
				'img_width' => '150',
				'img_height' => 40,
				'expiration' => 3600
			);
			$data['captcha'] = create_captcha($vals);
			$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
			$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
			$this->layout->add_js('pages/registration.js');
			$this->session->set_userdata('captchaWord', $data['captcha']['word']);
			$this->layout->render('form_change_password',$data);
		}
		else {
			redirect(base_url(),'refresh');
		}
	}

	function do_change_password() {
		$this->load->model('vnd_header');
		$this->load->model('adm_company');
		$vendor_id=$this->session->userdata('VENDOR_ID');//from session
		$password_old = $this->input->post('password_old');
		$vnd_id = $this->input->post('vendor_id');//from form submited
		$password = $this->input->post('password');
		$password2 = $this->input->post('password2');
		$captcha = $this->input->post('captcha');
		$vnd = $this->vnd_header->get(array('VENDOR_ID'=>$vendor_id,'PASSWORD'=>(md5($password_old))));
		// echo '<pre>'; var_dump($vnd); echo '</pre>';die;

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
					'VENDOR','Change Password Vendor','SAVE',$this->input->ip_address()
				);
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		
		if($password==$password2){
			if(count($vnd)>0){
				if($vnd['VENDOR_ID']==$vnd_id){
					$data = array(			
					"PASSWORD" => md5($password)
					);
					$where = array(
						"VENDOR_ID" => $vendor_id
					);

					if($this->vnd_header->update($data,$where)){
						//--LOG DETAIL--//
							$this->log_data->detail($LM_ID,'Vendor_change_password/do_change_password','vnd_header','update',$data,$where);
						//--END LOG DETAIL--//
						$data['title'] = 'Berhasil Mengubah Password Vendor';
						$this->layout->render('success_change_password',$data);
					}else{
						$msg = 'Gagal Mengubah Password Vendor';
						$this->session->set_flashdata('error',$msg);
						redirect('Vendor_change_password/change_password');
					}
				}else{
					$msg = 'Password Lama Salah';
					$this->session->set_flashdata('error',$msg);
					redirect('Vendor_change_password/change_password');
				}	
			}
			else{
				$msg = 'Password Lama Salah';
				$this->session->set_flashdata('error',$msg);
				redirect('Vendor_change_password/change_password');
			}	
		}else{
			$msg = 'Password Ulangan tidak sama';
			$this->session->set_flashdata('error',$msg);
			redirect('Vendor_change_password/change_password');
		}
		
	}
}
?>
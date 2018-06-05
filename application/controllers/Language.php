<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Controller {

	public function setLanguage($lang='id',$panjang = NULL, $current = NULL) {
		$url = substr(current_url(), strlen(current_url()) - intval($panjang),strlen(current_url()));
		$this->input->set_cookie('lang', $lang, 86500);
		if(isset($_SERVER['HTTP_REFERER'])) {
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			redirect(base_url($url));
		}
	}
}
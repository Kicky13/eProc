<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
	private $header_js = array();
	private $js = array();
	private $css = array();
	private $ci;
	private $available_language = array(
		'id' => 'Bahasa Indonesia',
		'en' => 'English',
		'vn' => 'Vietnamese'
		);

	function __construct() {
		$this->ci = &get_instance();
		$this->_set_header_js();
		$this->_set_default_css();
		$this->_set_default_js();
		$this->ci->load->model(array('m_global'));
		$this->ci->load->helper('language','url');
		$temp = $this->getLangFromCookie();
		$temp = empty($temp);
		if ($temp) {
			redirect(base_url('Language/setLanguage/id/'.strlen(uri_string())."/".uri_string()));
		}
	}
	public function set_table_selected_js(){
		$this->add_js("dtjs/dt/js/jquery.dataTables.min.js");
		//$this->add_js("dtjs/dt/js/dataTables.jqueryui.min.js");
		$this->add_js("dtjs/dtslc/js/dataTables.select.min.js");
	}

	public function set_table_selected_css(){
		$this->add_css("dtcss/dt/css/jquery.dataTables.min.css");
		$this->add_css("girlly/jquery-ui-1.10.3.custom.min.css");
		$this->add_css("dtcss/dtslc/css/select.dataTables.min.css");
	}

	public function set_validate_css(){
		$this->add_css("dtcss/ve/css/validationEngine.jquery.css");
	}

	public function set_validate_js(){
		$this->add_js("dtjs/ve/js/languages/jquery.validationEngine-en.js");
		$this->add_js("dtjs/ve/js/jquery.validationEngine.js");
	}

	public function set_tree_css(){
		$this->add_css("dtcss/tree/ui.dynatree.css");
	}

	public function set_tree_js(){
		$this->add_js("dtjs/tree/jquery-ui.custom.min.js");
		$this->add_js("dtjs/tree/jquery.dynatree.min.js");
		$this->add_js("dtjs/tree/jquery.cookie.js");
	}

	private function _set_header_js() {
		$this->header_js[] = 'jquery.js';
		$this->header_js[] = 'plugins.js';
	}

	private function _set_default_js() {
		$this->add_js('functions.js');
		$this->add_js('pages/public.js');
		$this->add_js("plugins/bootstrap-datetimepicker/moment.js");
		$this->add_js("showServerTime.js");
		// $this->add_js('checkfunctional.js');
	}
	
	private function _set_default_css() {
		$this->add_css("bootstrap.css");
		$this->add_css("style.css");
		$this->add_css("settings.css");
		$this->add_css("animate.min.css");
		$this->add_css("magnific-popup.css");
		$this->add_css("icon-fonts.css");
		$this->add_css("eproc.css");
		if (($this->ci->uri->segment(2)=='store_tor' && $this->ci->uri->segment(3)==NULL)||$this->ci->uri->segment(2)=='detail_invitation') {
			$this->add_css("sweetalert2ub.css");
		}else{
			$this->add_css("sweetalert2.css");
		}
	}
	//133
	

	public function set_table_js()
	{
		$this->add_js("plugins/datatables/jquery.dataTables.js");
		$this->add_js("plugins/datatables/jquery.dataTables-conf.js");
		$this->add_js("plugins/datatables/DT_bootstrap.js");
		$this->add_js("plugins/jquery.redirect.js");
		$this->add_js("plugins/simple_ajax_uploader.js");
		$this->add_js("plugins/simple_ajax_uploader.min.js");
		$this->add_js("plugins/jquery.ajaxfileupload.js");
		
		if (($this->ci->uri->segment(2)=='store_tor' && $this->ci->uri->segment(3)==NULL)||$this->ci->uri->segment(2)=='detail_invitation'){
			$this->add_js("sweetalert2.minub.js");
		}else{
			$this->add_js("sweetalert2.min.js");
			$this->add_js("swal.js");
		}
		
	}

    public function set_table_js2()
    {
        $this->add_js("pages/dataTable.js");
        $this->add_js("plugins/datatables/jquery.dataTables-conf.js");
        $this->add_js("plugins/datatables/DT_bootstrap.js");
        $this->add_js("plugins/jquery.redirect.js");
        $this->add_js("plugins/simple_ajax_uploader.js");
        $this->add_js("plugins/simple_ajax_uploader.min.js");
        $this->add_js("plugins/jquery.ajaxfileupload.js");

        if (($this->ci->uri->segment(2)=='store_tor' && $this->ci->uri->segment(3)==NULL)||$this->ci->uri->segment(2)=='detail_invitation'){
            $this->add_js("sweetalert2.minub.js");
        }else{
            $this->add_js("sweetalert2.min.js");
            $this->add_js("swal.js");
        }

    }
	
	public function set_table_cs()
	{
		$this->add_css("plugins/datatables/jquery.dataTables.css");
	}

	public function _set_form_css()
	{
		$this->add_css("plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css");
		$this->add_css('plugins/bootstrap-validator/bootstrap-validator.css');
	}

	public function _set_form_js()
	{
		$this->add_js('plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js');
		$this->add_js('plugins/bootstrap-validator/bootstrapValidator-conf.js');
		$this->add_js('plugins/bootstrap-validator/bootstrapValidator.min.js');
	}

	public function set_datetimepicker() {
		$this->add_css("plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css");
		$this->add_js("plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js");
	}
	
	private function getLangFromCookie() {
		return $this->ci->input->cookie('lang', TRUE);
	}

	private function getLanguageData() {
		$language = array();
		$langData = $this->ci->lang->language;
		if (!empty($langData)) {
			foreach ($langData as $languageItem) {
				$language[] = $languageItem;
			}
		}
		else {
			$language = NULL;
		}
		return $langData;
	}

	public function add_js($js, $from_url = FALSE) {
		if ($from_url) {
			$this->js[] = $js;
		}
		else {
			$this->js[] = base_url().'static/js/'.$js;
		}
	}
	
	public function add_css($css, $from_url = false) {
		if ($from_url) {
			$this->css[] = $css;
		} else {
			$this->css[] = 'static/css/'.$css;
		}
	}
	
	public function declare__header_js() {
		$min_script = array();
		$tag = "";
		foreach ($this->header_js as $url) {
			$script[] = '<script type="text/javascript" src="' .base_url().'static/js/'.$url. '"></script>';
		}

		foreach ($script as $tag_html) {
			$tag.="
	".$tag_html;
		}
		return $tag;
	}

	public function declare_js() {
		$min_script = array();
		$tag = "";
		foreach ($this->js as $url) {
			$script[] = '<script type="text/javascript" src="' .$url. '"></script>';
		}

		foreach ($script as $tag_html) {
			$tag.="
	".$tag_html;
		}
		return $tag;
	}
	
	public function declare_css() {
		$min_script = array();
		$tag = "";
		foreach ($this->css as $url) {
			$script[] = '<link rel="stylesheet" href="' .base_url().$url. '" />';
		}

		foreach ($script as $tag_html) {
			$tag.="
	".$tag_html;
		}
		return $tag;
	}

	function render($url, $data=NULL, $as_data = false) {
		$this->ci->lang->load('default',$this->available_language[$this->getLangFromCookie()]);
		$data['baseLanguage'] = $this->ci->lang;
		$data['baseLanguage'] = $this->getLanguageData();
		if (!empty($data["languageData"])) {
			$this->ci->lang->load($data["languageData"],$this->available_language[$this->getLangFromCookie()]);
		}
		$data['languageItem'] = $this->ci->lang;
		$data['languageItem'] = $this->getLanguageData();
		$data['styles'] = $this->declare_css();
		$data['lang'] = $this->getLangFromCookie();
		if(strpos($url,'auth') === false && strpos($url,'register') === false)
		{
			$data['menuBar'] = $this->ci->m_global->tampil_header($data['baseLanguage']);//$this->getMenuBar();
			$data['nama_pengguna'] = $this->ci->session->userdata('FULLNAME');
			if ($this->ci->session->userdata('is_vendor')) {
				$data['role'] = $this->ci->session->userdata('STATUS');
			}
			else {
				$data['role'] = $this->ci->session->userdata('POS_NAME');
			}
		}
		$data['available_language'] = $this->available_language;
		$data['header_scripts'] = $this->declare__header_js();

		$this->ci->load->model('adm_company');
		$data['company'] = $this->ci->adm_company->get_company();

		$retval = '';
		$retval .= $this->ci->load->view('plain/default_header', $data, $as_data);
		$retval .= $this->ci->load->view($url, $data, $as_data);

		$data['scripts'] = $this->declare_js();
		$retval .= $this->ci->load->view('plain/default_footer', $data, $as_data);
		return $retval;
	}

	function render2($url, $data=NULL, $as_data = false) {
		$this->ci->lang->load('default',$this->available_language[$this->getLangFromCookie()]);
		$data['baseLanguage'] = $this->ci->lang;
		$data['baseLanguage'] = $this->getLanguageData();
		if (!empty($data["languageData"])) {
			$this->ci->lang->load($data["languageData"],$this->available_language[$this->getLangFromCookie()]);
		}
		$data['languageItem'] = $this->ci->lang;
		$data['languageItem'] = $this->getLanguageData();
		$data['styles'] = $this->declare_css();
		$data['lang'] = $this->getLangFromCookie();
		if(strpos($url,'auth') === false && strpos($url,'register') === false)
		{
			$data['menuBar'] = $this->ci->m_global->tampil_header($data['baseLanguage']);//$this->getMenuBar();
			$data['nama_pengguna'] = $this->ci->session->userdata('FULLNAME');
			if ($this->ci->session->userdata('is_vendor')) {
				$data['role'] = $this->ci->session->userdata('STATUS');
			}
			else {
				$data['role'] = $this->ci->session->userdata('POS_NAME');
			}
		}
		$data['available_language'] = $this->available_language;
		$data['header_scripts'] = $this->declare__header_js();

		$this->ci->load->model('adm_company');
		$data['company'] = $this->ci->adm_company->get_company();
		
		$retval = '';
		$retval .= $this->ci->load->view('plain/default_header2', $data, $as_data);
		$retval .= $this->ci->load->view($url, $data, $as_data);

		$data['scripts'] = $this->declare_js();
		$retval .= $this->ci->load->view('plain/default_footer', $data, $as_data);
		return $retval;
	}

	function render_body_only($url, $data=NULL, $as_data = false) {
		$this->ci->lang->load('default',$this->available_language[$this->getLangFromCookie()]);
		$data['baseLanguage'] = $this->ci->lang;
		$data['baseLanguage'] = $this->getLanguageData();
		if (!empty($data["languageData"])) {
			$this->ci->lang->load($data["languageData"],$this->available_language[$this->getLangFromCookie()]);
		}
		$data['languageItem'] = $this->ci->lang;
		$data['languageItem'] = $this->getLanguageData();
		$data['styles'] = $this->declare_css();
		$data['lang'] = $this->getLangFromCookie();
		if(strpos($url,'auth') === false && strpos($url,'register') === false)
		{
			$data['menuBar'] = $this->ci->m_global->tampil_header($data['baseLanguage']);//$this->getMenuBar();
			$data['nama_pengguna'] = $this->ci->session->userdata('FULLNAME');
			if ($this->ci->session->userdata('is_vendor')) {
				$data['role'] = $this->ci->session->userdata('STATUS');
			}
			else {
				$data['role'] = $this->ci->session->userdata('POS_NAME');
			}
		}
		$data['available_language'] = $this->available_language;
		$data['header_scripts'] = $this->declare__header_js();
		$retval = '';
		$retval .= $this->ci->load->view('plain/plain_header', $data, $as_data);
		$retval .= $this->ci->load->view($url, $data, $as_data);

		$data['scripts'] = $this->declare_js();
		return $retval;
	}

	function getMenuBar() {
		if ($this->ci->session->userdata('is_vendor')) {
			$menuBar = $this->ci->menu_model->getMenuByRole($this->ci->session->userdata('STATUS'),1);
		}
		else {
			$menuBar = $this->ci->menu_model->getMenuByRole($this->ci->session->userdata('POS_ID'),0);
		}
		return $menuBar;
	}
}

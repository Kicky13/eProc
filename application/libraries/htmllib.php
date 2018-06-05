<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Htmllib {

    private $js = array();
	private $css = array();

    public function __construct() {
		$this->_set_default_css();
		$this->_set_default_js();
    }
	
	private function _set_default_js()
	{
		$this->js[] = 'plugins.js';
		$this->js[] = 'functions.js';
	}
	
	private function _set_default_css()
	{
		$this->css[] = "style.css";
		$this->css[] = "settings.css";
		$this->css[] = "bootstrap.css";
		$this->css[] = "animate.min.css";
		$this->css[] = "magnific-popup.css";
		$this->css[] = "icon-fonts.css";
	}

	public function add_js($js)
	{
		$this->js[] = $js;	
	}
	
	public function add_css($css)
	{
		$this->css[] = $css;	
	}
	
	public function declare_js()
	{		
		$min_script = array();

		foreach ($this->js as $url) {
			$script[] = '<script type="text/javascript" src="' .base_url().'static/js/'.$url. '"></script>';
		}

		foreach ($script as $tag_html) {
			echo $tag_html;
		}
	}
	
	public function declare_css()
	{
		$min_script = array();

		foreach ($this->css as $url) {
			$script[] = '<link rel="stylesheet" href="' .base_url().'static/css/'.$url. '" />';
		}

		foreach ($script as $tag_html) {
			echo $tag_html;
		}
	}

}

?>
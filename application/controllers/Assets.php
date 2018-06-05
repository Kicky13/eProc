<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$current_path = $this->uri->segments;
		unset($current_path[1]);
		$file = getcwd() . '/application/modules/' . implode('/', $current_path);
		$path_parts = pathinfo( $file);
		$file_type=  strtolower($path_parts['extension']);
		if (is_file($file)) {
			switch ($file_type) {
				case 'css':
				header('Content-type: text/css');
				break;

				case 'js':
				header('Content-type: text/javascript');
				break;

				case 'json':
				header('Content-type: application/json');
				break;

				case 'xml':
				header('Content-type: text/xml');
				break;

				case 'pdf':
				header('Content-type: application/pdf');
				break;

				case 'jpg' || 'jpeg' || 'png' || 'gif':
				header('Content-type: image/'.$file_type);
				break;
			}

			include $file;
		} else {
			show_404();
		}
		exit;
	}

}

/* End of file assets.php */
/* Location: ./application/controllers/assets.php */
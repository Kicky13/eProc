<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class File {

	public function __construct() {
		$this->ci = &get_instance();
	}

	function upload($dir_path, $files) {
		// var_dump($files);
		// exit();

		$config['upload_path'] = $dir_path;
		$config['allowed_types'] = '*';
		$config['max_size'] = '0';
		$config['max_filename'] = '255';
		$config['encrypt_name'] = FALSE;

		$path = explode('/', $dir_path);
		$upload_path = '.';
		for ($i=1; $i < count($path) ; $i++) {
			$upload_path .= '/'.$path[$i];
			if(!is_dir($upload_path))
			{
				mkdir($upload_path, 0777, true);
			}
		}

		$i=0;
		$j=0;

		foreach ($files as $key => $value) {
			if (!empty($value['name'])) {
				$this->ci->load->library('upload', $config);
				if (!$this->ci->upload->do_upload($key)) {
					var_dump($this->ci->upload->display_errors());
					$is_file_error = TRUE;
				} else {
					// var_dump($key);
					$this->ci->upload->data();
					$files[$i] = $this->ci->upload->data();
					++$i;
				}
			}
		}
		return true;
	}

}
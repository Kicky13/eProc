<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class File_operation {

	public function __construct() {
		$this->ci = &get_instance();
	}

	/**
	 * Do upload. Harus dari input file. Misal
	 *   <input type="file" name="file1">
	 * name nya itu ntar jadi key outputnya.
	 * !!! Cannot accept from single input multiple files !!!
	 *
	 * @param string lokasi penyimpanan file
	 * @param Array, dari $_FILES. sebenarnya yang
	 *		dibutuhkan cuma key nya dan value['name'] exist.
	 * @param bool apakah lanjut kalau ada error. default false
	 *
	 * @return Array 2 dimensi. Dimensi pertama, key nya adalah
	 *		property name nya di tag input. Dimensi keduanya
	 *		detail dari file yg diupload. Yang penting adalah
	 *		'file_name' yang harus disimpen di database.
	 */
	public function upload($dir_path, $files, $ignore_error = false) {
		$data=array();
		$dir_path = getcwd().'/'.$dir_path;
		$config['upload_path'] = $dir_path;
		$config['allowed_types'] = '*';
		$config['max_size'] = '14196';
		$config['max_filename'] = '255';
		$config['encrypt_name'] = true;
		$config['remove_spaces'] = true;
		$this->ci->load->library('upload', $config);

		$this->create_dir($dir_path);

		foreach ($files as $key => $value) {
			if (!empty($value['name'])) {
				if (!$this->ci->upload->do_upload($key)) {
					if (!$ignore_error) {
						echo "File upload error:<br>\n";
						var_dump($this->ci->upload->display_errors());
						var_dump(compact('dir_path', 'files', 'ignore_error'));
						exit();
					}
				} else {
					$data[$key] = $this->ci->upload->data();
				}
			}
		}
		return $data;
	}

	public function uploadTPL($dir_path, $files, $ignore_error = false) {
		$data = array();
		$dir_path = getcwd() . '/' . $dir_path;
		$config['upload_path'] = $dir_path;
		$config['allowed_types'] = 'doc|docx|jpeg|jpg|png|pdf';
		$config['max_size'] = '5000';// dalam kilobyte
		$config['max_filename'] = '255';
		$config['encrypt_name'] = true;
		$config['remove_spaces'] = true;
		$this -> ci -> load -> library('upload', $config);

		$this -> create_dir($dir_path);

		foreach ($files as $key => $value) {
			if (!empty($value['name'])&&$value['name']!="") {
				if (!$this -> ci -> upload -> do_upload($key)) {
					if (!$ignore_error) {
						echo "File upload error:<br>\n";
						var_dump($this -> ci -> upload -> display_errors());
						//var_dump(compact('dir_path', 'files', 'ignore_error'));
						//return array("gagal",$this -> ci -> upload -> display_errors());
						exit();
					}
				} else {
					$data[$key] = $this -> ci -> upload -> data();
				}
			}
		}
		return $data;
	}

	public function uploadI($dir_path, $files, $ignore_error = false) {
		$data = array();
		$dir_path = getcwd() . '/' . $dir_path;
		$config['upload_path'] = $dir_path;
		$config['allowed_types'] = 'jpeg|jpg|png|pdf|doc';
		$config['max_size'] = '2000';// dalam kilobyte
		$config['max_filename'] = '255';
		$config['encrypt_name'] = true;
		$config['remove_spaces'] = true;
		$this -> ci -> load -> library('upload', $config);

		$this -> create_dir($dir_path);

		foreach ($files as $key => $value) {
			if (!empty($value['name'])&&$value['name']!="") {
				if (!$this -> ci -> upload -> do_upload($key)) {
					if (!$ignore_error) {
						echo "File upload error:<br>\n";
						var_dump($this -> ci -> upload -> display_errors());
						//var_dump(compact('dir_path', 'files', 'ignore_error'));
						//return array("gagal",$this -> ci -> upload -> display_errors());
						exit();
					}
				} else {
					$data[$key] = $this -> ci -> upload -> data();
				}
			}
		}
		return $data;
	}

	public function uploadL($dir_path, $files, $ignore_error = false) {
		$data = array();
		$dir_path = getcwd() . '/' . $dir_path;
		$config['upload_path'] = $dir_path;
		$config['allowed_types'] = 'jpeg|jpg|png|pdf|doc';
		$config['max_size'] = '4096';// dalam kilobyte
		$config['max_filename'] = '255';
		$config['encrypt_name'] = true;
		$config['remove_spaces'] = true;
		$this -> ci -> load -> library('upload', $config);

		$this -> create_dir($dir_path);

		foreach ($files as $key => $value) {
			if (!empty($value['name'])&&$value['name']!="") {
				if (!$this -> ci -> upload -> do_upload($key)) {					
					if (!$ignore_error) {
						echo "File upload error:<br>\n";
						var_dump($this -> ci -> upload -> display_errors());
						//var_dump(compact('dir_path', 'files', 'ignore_error'));
						//return array("gagal",$this -> ci -> upload -> display_errors());
						exit();
					}
				} else {
					$data[$key] = $this -> ci -> upload -> data();
				}
			}
		}
		return $data;
	}

	/**
	 * Create dir path if not exist
	 *
	 * @param string dir path
	 */
	public function create_dir($dir_path) {
		$path = explode('/', $dir_path);
		$upload_path = '.';
		for ($i = 0; $i < count($path) ; $i++) {
			$upload_path .= '/' . $path[$i];
			if(!is_dir($upload_path))
			{
				@mkdir($upload_path, 0777, true);
			}
		}
	}

}

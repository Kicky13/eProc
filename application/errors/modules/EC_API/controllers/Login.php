<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions

class Login extends REST_Controller
{
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        $this->load->library('active_directory');
    }

		/* contoh memanggil
      http://10.15.5.150/dev/eproc/EC_API/Reservation/list/X-API-KEY/80ccwwsk44ko4k8ko0wgw0sog484s8kg44ooc8s8/plant/7702/store_loc/W213
      http://10.15.5.150/dev/eproc/EC_API/Reservation/list/X-API-KEY/80ccwwsk44ko4k8ko0wgw0sog484s8kg44ooc8s8/plant/7702/store_loc/W213/format/xml
			 nilai X-API-KEY didapatkan dari database atau dari url http://10.15.5.150/dev/eproc/EC_API/Rest_server/apikey

		*/
    function index_post()
    {
      $username = $this->post('username');
      $password = $this->post('password');
      $loginldap = $this->active_directory->test($username, $password);

      $result = array('status' => 0, 'message' => '');
			if($loginldap===false){
				$msg='Email tidak terdaftar di LDAP. Hubungi admin manage service call ext 51 ';
				$result['message'] = $msg;
				//die('Tidak punya user LDAP');
			}else{
				$result['status'] = 1;
        $result['message'] = 'Berhasil login';
			}

      $this->response($result, 200); // 200 being the HTTP response code
    }
}

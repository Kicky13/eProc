<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Keys Controller
 * This is a basic Key Management REST controller to make and delete keys
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Key extends REST_Controller {

    protected $methods = array(
            'index_put' => array('level' => 0, 'limit' => 10),
            'index_delete' => array('level' => 0),
            'level_post' => array('level' => 10),
            'regenerate_post' => array('level' => 10),
        );

        public function index_get()
        {
            // Build a new key
            $key = $this->_generate_key();
            $level = 1;
            $this->_insert_key($key, array('LEVEL_API' => $level));
            $this->response(
            array(
              'key' => $key
            ),REST_Controller::HTTP_OK
          );
        }
    /**
     * Insert a key into the database
     *
     * @access public
     * @return void
     */
    public function index_put()
    {
        // Build a new key
        $key = $this->_generate_key();

        // If no key level provided, provide a generic key
        $level = $this->put('level') ? $this->put('level') : 1;
        $ignore_limits = ctype_digit($this->put('ignore_limits')) ? (int) $this->put('ignore_limits') : 1;

        // Insert the new key
        if ($this->_insert_key($key, array('LEVEL_API' => $level)))
        {
            $this->response(array(
                'status' => TRUE,
                'key' => $key
            ), REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
        }
        else
        {
            $this->response(array(
                'status' => FALSE,
                'message' => 'Could not save the key'
            ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR); // INTERNAL_SERVER_ERROR (500) being the HTTP response code
        }
    }

    /**
     * Remove a key from the database to stop it working
     *
     * @access public
     * @return void
     */
    public function index_delete()
    {
        $key = $this->delete('key');

        // Does this key exist?
        if (!$this->_key_exists($key))
        {
            // It doesn't appear the key exists
            $this->response(array(
                'status' => FALSE,
                'message' => 'Invalid API key'
            ), REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Destroy it
        $this->_delete_key($key);

        // Respond that the key was destroyed
        $this->response(array(
            'status' => TRUE,
            'message' => 'API key was deleted'
            ), REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

    /**
     * Change the level
     *
     * @access public
     * @return void
     */
    public function level_post()
    {
        $key = $this->post('key');
        $new_level = $this->post('level');

        // Does this key exist?
        if (!$this->_key_exists($key))
        {
            // It doesn't appear the key exists
            $this->response(array(
                'status' => FALSE,
                'message' => 'Invalid API key'
            ), REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Update the key level
        if ($this->_update_key($key, array('level' => $new_level)))
        {
            $this->response(array(
                'status' => TRUE,
                'message' => 'API key was updated'
            ), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->response(array(
                'status' => FALSE,
                'message' => 'Could not update the key level'
            ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR); // INTERNAL_SERVER_ERROR (500) being the HTTP response code
        }
    }

    /**
     * Suspend a key
     *
     * @access public
     * @return void
     */
    public function suspend_post()
    {
        $key = $this->post('key');

        // Does this key exist?
        if (!$this->_key_exists($key))
        {
            // It doesn't appear the key exists
            $this->response(array(
                'status' => FALSE,
                'message' => 'Invalid API key'
            ), REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Update the key level
        if ($this->_update_key($key, array('level' => 0)))
        {
            $this->response(array(
                'status' => TRUE,
                'message' => 'Key was suspended'
            ), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->response(array(
                'status' => FALSE,
                'message' => 'Could not suspend the user'
            ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR); // INTERNAL_SERVER_ERROR (500) being the HTTP response code
        }
    }

    /**
     * Regenerate a key
     *
     * @access public
     * @return void
     */
    public function regenerate_post()
    {
        $old_key = $this->post('key');
        $key_details = $this->_get_key($old_key);

        // Does this key exist?
        if (!$key_details)
        {
            // It doesn't appear the key exists
            $this->response(array(
                'status' => FALSE,
                'message' => 'Invalid API key'
            ), REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Build a new key
        $new_key = $this->_generate_key();

        // Insert the new key
        if ($this->_insert_key($new_key, array('level' => $key_details->level, 'ignore_limits' => $key_details->ignore_limits)))
        {
            // Suspend old key
            $this->_update_key($old_key, array('level' => 0));

            $this->response(array(
                'status' => TRUE,
                'key' => $new_key
            ), REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
        }
        else
        {
            $this->response(array(
                'status' => FALSE,
                'message' => 'Could not save the key'
            ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR); // INTERNAL_SERVER_ERROR (500) being the HTTP response code
        }
    }

    /* Helper Methods */
    /**
 * Get random bytes
 *
 * @param	int	$length	Output length
 * @return	string
 */
  private function get_random_bytes($length)
  {
    if (empty($length) OR ! ctype_digit((string) $length))
    {
      return FALSE;
    }

    if (function_exists('random_bytes'))
    {
      try
      {
        // The cast is required to avoid TypeError
        return random_bytes((int) $length);
      }
      catch (Exception $e)
      {
        // If random_bytes() can't do the job, we can't either ...
        // There's no point in using fallbacks.
        log_message('error', $e->getMessage());
        return FALSE;
      }
    }

    // Unfortunately, none of the following PRNGs is guaranteed to exist ...
    if (defined('MCRYPT_DEV_URANDOM') && ($output = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM)) !== FALSE)
    {
      return $output;
    }


    if (is_readable('/dev/urandom') && ($fp = fopen('/dev/urandom', 'rb')) !== FALSE)
    {
      // Try not to waste entropy ...
      is_php('5.4') && stream_set_chunk_size($fp, $length);
      $output = fread($fp, $length);
      fclose($fp);
      if ($output !== FALSE)
      {
        return $output;
      }
    }

    if (function_exists('openssl_random_pseudo_bytes'))
    {
      return openssl_random_pseudo_bytes($length);
    }

    return FALSE;
  }

    private function _generate_key()
    {
        do
        {
            // Generate a random salt
            $salt = base_convert(bin2hex($this->get_random_bytes(64)), 16, 36);

            // If an error occurred, then fall back to the previous method
            if ($salt === FALSE)
            {
                $salt = hash('sha256', time() . mt_rand());
            }
            $rest_key_length = config_item('rest_key_length');
            $new_key = substr($salt, 0, $rest_key_length);
        }
        while ($this->_key_exists($new_key));

        return $new_key;
    }

    /* Private Data Methods */

    private function _get_key($key)
    {
        $rest_key_column = config_item('rest_key_column');
        $rest_keys_table = config_item('rest_keys_table');
        return $this->rest->db
            ->where($rest_key_column, $key)
            ->get($rest_keys_table)
            ->row();
    }

    private function _key_exists($key)
    {
        $rest_key_column = config_item('rest_key_column');
        $rest_keys_table = config_item('rest_keys_table');
        return $this->rest->db
            ->where($rest_key_column, $key)
            ->count_all_results($rest_keys_table) > 0;
    }

    private function _insert_key($key, $data)
    {
        $key_column = config_item('rest_key_column');
        $data[$key_column] = $key;
        // $data['date_created'] = function_exists('now') ? now() : time();

        $rest_keys_table = config_item('rest_keys_table');
        return $this->rest->db
            ->set($data)
            ->insert($rest_keys_table);
    }

    private function _update_key($key, $data)
    {
        $rest_key_column = config_item('rest_key_column');
        $rest_keys_table = config_item('rest_keys_table');
        return $this->rest->db
            ->where($rest_key_column, $key)
            ->update($rest_keys_table, $data);
    }

    private function _delete_key($key)
    {
        $rest_key_column = config_item('rest_key_column');
        $rest_keys_table = config_item('rest_keys_table');
        return $this->rest->db
            ->where($rest_key_column, $key)
            ->delete($rest_keys_table);
    }

}

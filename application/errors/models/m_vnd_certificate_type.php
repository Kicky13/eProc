<?php
class m_vnd_certificate_type extends MY_Model
{
	public $primary_key = 'NO_CERTIFICATE_TYPE';
	public $table = 'M_VND_CERTIFICATE_TYPE';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		parent::__construct();
	}
}
?>
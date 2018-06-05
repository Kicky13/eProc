<?php defined('BASEPATH') OR exit('No direct script access allowed');

class adm_employee_atasan extends CI_Model {

	protected $table = 'ADM_EMPLOYEE_ATASAN';

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function get($where=NULL) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from($this->table);
		$result = $this->db->get();
		return $result->result_array();
	}

	/**
	 * @return array of 
	 *    id_atasan
	 *    nama_atasan
	 *    level
	 */
	public function get_atasan($emp_id, $max_eselon = null) {
		$this->load->model('adm_employee');

		$id_nganu = $emp_id;
		$hasil = array();
		do {
			$emp = $this->adm_employee->get(array('ID' => $id_nganu));
			$nopeg = $emp[0]['NO_PEG'];

			$atasan = $this->adm_employee_atasan->get(array('MK_NOPEG' => $nopeg));
			$level = $atasan[0]['ATASAN1_LEVEL']; // get level atasan

			$ans = $this->adm_employee->atasan($id_nganu);
			$id_atasan = $ans[0]['ID']; // get atasan
			$nama_atasan = $ans[0]['FULLNAME']; // get atasan
			if ($id_atasan == null) {
				break;
			}
			$hasil[] = compact('id_atasan', 'nama_atasan', 'level');

			$id_nganu = $id_atasan;
		} while ($level != $max_eselon);

		return $hasil;
	}

	public function get_atasan_baru($emp_id, $max_eselon = null) {
		$this->load->model('adm_employee');
		$this->load->model('adm_pos');

		$id_nganu = $emp_id;
		$hasil = array();
		do {
			$emp = $this->adm_employee->get(array('ID' => $id_nganu));
			$nopeg = $emp[0]['NO_PEG'];

			$atasan = $this->adm_employee_atasan->get(array('MK_NOPEG' => $nopeg));
			$level = $atasan[0]['ATASAN1_LEVEL']; // get level atasan

			$ans = $this->adm_employee->atasan($id_nganu);
			$posisi = $this->adm_pos->get(array('POS_ID' => $ans[0]['ADM_POS_ID']));
			$id_atasan = $ans[0]['ID']; // get atasan
			$nama_atasan = $ans[0]['FULLNAME']; // get atasan
			$email_atasan = $ans[0]['EMAIL']; // get atasan
			$posisi_atasan = $posisi[0]['POS_NAME']; // get POSISI atasan
			if ($id_atasan == null) {
				break;
			}
			$hasil[] = compact('id_atasan', 'email_atasan', 'nama_atasan', 'level', 'posisi_atasan');

			$id_nganu = $id_atasan;
		} while ($level != $max_eselon);

		return $hasil;
	}


	public function get_atasan_baru_evatek($emp_id, $max_eselon = null, $ambil_atasan) {
		$this->load->model('adm_employee');
		$this->load->model('adm_pos');

		$id_nganu = $emp_id;
		$hasil = array();
		do {
			$emp = $this->adm_employee->get(array('ID' => $id_nganu));
			$nopeg = $emp[0]['NO_PEG'];

			$atasan = $this->adm_employee_atasan->get(array('MK_NOPEG' => $nopeg));
			$level = $atasan[0]['ATASAN1_LEVEL']; // get level atasan

			$ans = $this->adm_employee->atasan($id_nganu);
			$posisi = $this->adm_pos->get(array('POS_ID' => $ans[0]['ADM_POS_ID']));
			$id_atasan = $ans[0]['ID']; // get atasan
			$nama_atasan = $ans[0]['FULLNAME']; // get atasan
			$email_atasan = $ans[0]['EMAIL']; // get atasan
			$posisi_atasan = $posisi[0]['POS_NAME']; // get POSISI atasan
			if ($id_atasan == null) {
				break;
			}
			if($ambil_atasan==$level){
				$hasil[] = compact('id_atasan', 'email_atasan', 'nama_atasan', 'level', 'posisi_atasan');
			}

			$id_nganu = $id_atasan;
		} while ($level != $max_eselon);

		return $hasil;
	}

	public function insert($data) {
		$this->db->insert($this->table, $data);
	}

	public function insert_batch($data) {
		$this->db->insert_batch($this->table, $data);
	}

	public function update($set=NULl, $where=NULL) {
		$this->db->where($where);
		return $this->db->update($this->table, $set);
	}

	public function delete($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}

}
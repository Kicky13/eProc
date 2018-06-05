<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Update_data extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	function index() {
		// $sql_mg="INSERT INTO ADM_POS_MG SELECT ADM_EMPLOYEE.NO_PEG, ADM_POS.GROUP_MENU, ADM_POS.POS_ID FROM ADM_POS INNER JOIN ADM_EMPLOYEE ON ADM_EMPLOYEE.ADM_POS_ID = ADM_POS.POS_ID where GROUP_MENU<>0";
		// $this->db->query($sql_mg);

		$sql="SELECT ADM_POS_MG.GROUP_MENU,ADM_POS_MG.POS_ID POS_ID_LAMA,ADM_POS.POS_ID POS_ID_BARU,ADM_EMPLOYEE.NO_PEG FROM ADM_POS_MG INNER JOIN ADM_EMPLOYEE ON ADM_EMPLOYEE.NO_PEG = ADM_POS_MG.NOPEG INNER JOIN ADM_POS ON ADM_EMPLOYEE.ADM_POS_ID = ADM_POS.POS_ID";
		$datarow=$this->db->query($sql)->result_array();
		$no = 1;
		foreach ($datarow as $row) {
			$sql="UPDATE ADM_POS SET GROUP_MENU=".$row['GROUP_MENU']." WHERE POS_ID=".$row['POS_ID_BARU'];
			$this->db->query($sql);
			$sql1="UPDATE APP_PROCESS_ROLE SET ROLE=".$row['POS_ID_BARU']." WHERE ROLE=".$row['POS_ID_LAMA'];
			$this->db->query($sql1);

			echo $no++;
			echo "<br>";
			echo $sql1;
		}
		echo "Berhasil";

		
	}

	
}
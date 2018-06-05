<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Bikin koneksi ke SAP. coba perhatikan fungsi getVendor.
 * Input dan return dari sap bisa macemmacem, bisa cuma satu
 * data, bisa tabel, bisa banyak tabel, gabungan keduanya, dll.
 */
class sap_handler_cloning {
	protected $sap;
	protected $fce;

	public function __construct() {
		$this->ci = &get_instance();
		include_once(FCPATH . 'sapclasses/sap.php');
		$this->sap = new SAPConnection();
		$conf = FCPATH . 'sapclasses/logon_dataclon.conf';
		$this->sap->Connect($conf);
		if ($this->sap->GetStatus() == SAPRFC_OK) {
			$this->sap->Open();
		} else {
			$this->sap->PrintStatus();
			exit;
		}
	}

	protected function openFunction($functionName) {
		$this->fce = $this->sap->NewFunction($functionName);
		if ($this->fce == false) {
			$this->sap->PrintStatus();
			exit;
		}
	}


    public function getDataMigration7KSO() {
        $this->openFunction('ZCFI_GR_IR_3103_CP');

        $this->fce->P_GR_IR = 'X';
        $this->fce->P_MWSKZ = 'WN';

        $this->fce->R_EBELN->row['SIGN'] = 'I';
        $this->fce->R_EBELN->row['OPTION'] = 'EQ';
        $this->fce->R_EBELN->row['LOW'] = '6*';
        $this->fce->R_EBELN->Append($this->fce->R_EBELN->row);

        $this->fce->call();

        // echo '<pre>';
        // var_dump($this->fce);die();

        $i = 0;
        $itTampung = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
            $this->fce->T_DATA->Reset();
            while ($this->fce->T_DATA->Next()) {
                $itTampung[] = $this->fce->T_DATA->row;
            }
        }
        return $itTampung;
    }

    public function getDetailVendor() {
        $this->openFunction('Z_ZCMM_VENDOR_DETAIL');
        $this->fce->FI_VENDOR_NO = '0000112733';
        $this->fce->call();
        $i = 0;
        $itTampung = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
            $this->fce->FT_VENDOR->Reset();
            while ($this->fce->FT_VENDOR->Next()) {
              //  print_r($this->fce->T_DATA->row);
                $itTampung[] = $this->fce->FT_VENDOR->row;
            }
        }
        return $itTampung;
    }

}

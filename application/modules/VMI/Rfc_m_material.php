<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rfc_m_material extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        // $this->load->library('Authorization');
        $this->ci = &get_instance();
        // $this->load->library('Layout');
        // $this->load->library('Htmllib');
        // $this->load->library('FPDF');
        // $this->load->model('Prematching_model');
        // $this->load->model('Expeditur_model');
    }

    function echopre($dt){
        echo'<pre>';
            print_r($dt);
        echo'</pre>';
    }

    public function index()
    {
        require_once APPPATH.'third_party/sapclasses/sap.php';
        $sap = new SAPConnection();
        $sap->Connect(APPPATH."third_party/sapclasses/logon_dataProd.conf");
        
        if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
        if ($sap->GetStatus() != SAPRFC_OK ) {
            echo $sap->PrintStatus();
            exit;
        }
        $fce = &$sap->NewFunction ("ZCMM_MASTER_MATERIAL");
                
        if ($fce == false) {
            $sap->PrintStatus();
            exit;
        }
        
        $fce->call();

        echo $fce;

        if ($fce->GetStatus() == SAPRFC_OK) {
            $fce->T_STOCK_CONSINYASI->Reset();

            $data=array();

            $i=0;
            
            while ($fce->T_STOCK_CONSINYASI->Next()) {
                // $data[] = ($fce->T_STOCK_CONSINYASI->row);

                // echopre($data);
                $list_po[$i]["MATNR"] = $fce->T_STOCK_CONSINYASI->row["MATNR"];
                $list_po[$i]["MAKTX"] = $fce->T_STOCK_CONSINYASI->row["MAKTX"];
                $list_po[$i]["WERKS"] = $fce->T_STOCK_CONSINYASI->row["WERKS"];
                $list_po[$i]["LGORT"] = $fce->T_STOCK_CONSINYASI->row["LGORT"];
                $list_po[$i]["LIFNR"] = $fce->T_STOCK_CONSINYASI->row["LIFNR"];
                $list_po[$i]["NAME1"] = $fce->T_STOCK_CONSINYASI->row["NAME1"];
                $list_po[$i]["SLABS"] = $fce->T_STOCK_CONSINYASI->row["SLABS"];
                $list_po[$i]["MEINS"] = $fce->T_STOCK_CONSINYASI->row["MEINS"];
                $list_po[$i]["EISBE"] = $fce->T_STOCK_CONSINYASI->row["EISBE"];
                $list_po[$i]["MABST"] = $fce->T_STOCK_CONSINYASI->row["MABST"];
                $list_po[$i]["MINBE"] = $fce->T_STOCK_CONSINYASI->row["MINBE"];

                $i++;
            }

            $fce->Close();
            $sap->Close();
            echo '<pre>';
                print_r($list_po);
            echo '<pre>';
            
            // echopre($list_po);


        }
    }
}
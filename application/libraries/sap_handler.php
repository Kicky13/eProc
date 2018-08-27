<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Bikin koneksi ke SAP. coba perhatikan fungsi getVendor.
 * Input dan return dari sap bisa macemmacem, bisa cuma satu
 * data, bisa tabel, bisa banyak tabel, gabungan keduanya, dll.
 */
class sap_handler {
	protected $sap;
	protected $fce;

	public function __construct() {
		$this->ci = &get_instance();
		include_once(FCPATH . 'sapclasses/sap.php');
		$this->sap = new SAPConnection();
		$conf = FCPATH . 'sapclasses/logon_datadev.conf';
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

	public function getCurrencyConversion() {
		$this->openFunction('BAPI_EXCHRATE_GETCURRENTRATES');

		$this->fce->DATE = date('Ymd');
		$this->fce->DATE_TYPE = 'V';
		$this->fce->RATE_TYPE = 'M';

		$this->fce->TO_CURRNCY_RANGE->row['SIGN'] = 'I';
		$this->fce->TO_CURRNCY_RANGE->row['OPTION'] = 'EQ';
		$this->fce->TO_CURRNCY_RANGE->row['LOW'] = 'IDR';
		$this->fce->TO_CURRNCY_RANGE->Append($this->fce->TO_CURRNCY_RANGE->row);

		$this->fce->call();

		$itTampung = array();
		if ($this->fce->GetStatus() == SAPRFC_OK) {
			$this->fce->EXCH_RATE_LIST->Reset();
			while ($this->fce->EXCH_RATE_LIST->Next()) {
				$itTampung[] = $this->fce->EXCH_RATE_LIST->row;
			}
		}
		$return['EXCH_RATE_LIST'] = $itTampung;

		return $return;
	}

	public function getStrategicMaterial($NOW) {
		$this->openFunction('ZCMM_MAT_MASTER');

        $this->fce->S_MATNR->row['SIGN'] = 'I';
        $this->fce->S_MATNR->row['OPTION'] = 'BT';
        $this->fce->S_MATNR->row['LOW'] = '503-000000';
        $this->fce->S_MATNR->row['HIGH'] = '504-999999';                
        $this->fce->S_MATNR->Append($this->fce->S_MATNR->row);
//		$this->fce->S_ERSDA->row['SIGN'] = 'I';
//		$this->fce->S_ERSDA->row['OPTION'] = 'BT';
//		$this->fce->S_ERSDA->row['LOW'] = '20161208';
//		$this->fce->S_ERSDA->row['HIGH'] = date('Ymd');
//		$this->fce->S_ERSDA->Append($this->fce->S_ERSDA->row);

        $this->fce->call();
        $i = 0;
        $itTampung = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
         $this->fce->T_OUTPUT->Reset();
         while ($this->fce->T_OUTPUT->Next()) {
            $itTampung[] = $this->fce->T_OUTPUT->row;
                // if ($itTampung[$i]['MATNR'] == "222"||$itTampung[$i++]['MAKTX'] == ("S_RAJALELE") )
                // print_r($itTampung[$i++]);
                // $itTampung['MATNR'] = "S_RAJALELEEEEEEEE";
        }
    }
    $return['T_OUTPUT'] = $itTampung;
        //var_dump($itTampung);
    return $return;
}

public function getDoctype() {
  $this->openFunction('Z_MST_DOCINV');

  $this->fce->R_SPRAS->row['SIGN'] = 'I';
  $this->fce->R_SPRAS->row['OPTION'] = 'EQ';
  $this->fce->R_SPRAS->row['LOW'] = 'EN';
  $this->fce->R_SPRAS->Append($this->fce->R_SPRAS->row);

  $this->fce->call();
  $i = 0;
  $itTampung = array();
  if ($this->fce->GetStatus() == SAPRFC_OK) {
     $this->fce->T_DATA->Reset();
     while ($this->fce->T_DATA->Next()) {
        $itTampung[] = $this->fce->T_DATA->row;
                // if ($itTampung[$i]['MATNR'] == "222"||$itTampung[$i++]['MAKTX'] == ("S_RAJALELE") )
                // print_r($itTampung[$i++]);
                // $itTampung['MATNR'] = "S_RAJALELEEEEEEEE";
    }
}
$return['T_DATA'] = $itTampung;
        //var_dump($itTampung);
return $return;
}

public function getPayblock() {
  $this->openFunction('Z_MST_PMNT_BLOCK');

  $this->fce->R_SPRAS->row['SIGN'] = 'I';
  $this->fce->R_SPRAS->row['OPTION'] = 'EQ';
  $this->fce->R_SPRAS->row['LOW'] = 'EN';
  $this->fce->R_SPRAS->Append($this->fce->R_SPRAS->row);

  $this->fce->call();
  $i = 0;
  $itTampung = array();
  if ($this->fce->GetStatus() == SAPRFC_OK) {
     $this->fce->T_DATA->Reset();
     while ($this->fce->T_DATA->Next()) {
        $itTampung[] = $this->fce->T_DATA->row;
                // if ($itTampung[$i]['MATNR'] == "222"||$itTampung[$i++]['MAKTX'] == ("S_RAJALELE") )
                // print_r($itTampung[$i++]);
                // $itTampung['MATNR'] = "S_RAJALELEEEEEEEE";
    }
}
$return['T_DATA'] = $itTampung;
        // var_dump($itTampung);
return $return;
}

public function getPaymeth() {
  $this->openFunction('Z_MST_PYMT_METH');

  $this->fce->R_LAND1->row['SIGN'] = 'I';
  $this->fce->R_LAND1->row['OPTION'] = 'EQ';
  $this->fce->R_LAND1->row['LOW'] = 'ID';
  $this->fce->R_LAND1->Append($this->fce->R_LAND1->row);

  $this->fce->call();
  $i = 0;
  $itTampung = array();
  if ($this->fce->GetStatus() == SAPRFC_OK) {
     $this->fce->T_DATA->Reset();
     while ($this->fce->T_DATA->Next()) {
        $itTampung[] = $this->fce->T_DATA->row;
                // if ($itTampung[$i]['MATNR'] == "222"||$itTampung[$i++]['MAKTX'] == ("S_RAJALELE") )
                // print_r($itTampung[$i++]);
                // $itTampung['MATNR'] = "S_RAJALELEEEEEEEE";
    }
}
$return['T_DATA'] = $itTampung;
        // var_dump($itTampung);
return $return;
}

public function getTax() {
  $this->openFunction('Z_MST_TAX');

  $this->fce->R_ZTERM->row['SIGN'] = 'I';
  $this->fce->R_ZTERM->row['OPTION'] = 'EQ';
  $this->fce->R_ZTERM->row['LOW'] = 'EN';
        // $this->fce->R_ZTERM->Append($this->fce->R_ZTERM->row);

  $this->fce->R_KALSM->row['SIGN'] = 'I';
  $this->fce->R_KALSM->row['OPTION'] = 'EQ';
  $this->fce->R_KALSM->row['LOW'] = 'TAXID';
  $this->fce->R_KALSM->Append($this->fce->R_KALSM->row);

  $this->fce->call();
  $i = 0;
  $itTampung = array();
  if ($this->fce->GetStatus() == SAPRFC_OK) {
     $this->fce->T_DATA->Reset();
     while ($this->fce->T_DATA->Next()) {
        $itTampung[] = $this->fce->T_DATA->row;
    }
}
$return['T_DATA'] = $itTampung;
        //	var_dump($itTampung);
return $return;
}
public function getECPlant($debug) {
  $this->openFunction('Z_ZCMM_PLANT_GETLIST');

  $this->fce->call();
  $i = 0;
  $itTampung = array();
  if ($this->fce->GetStatus() == SAPRFC_OK) {
     $this->fce->FT_PLANT->Reset();
     while ($this->fce->FT_PLANT->Next()) {
        $itTampung[] = $this->fce->FT_PLANT->row;
    }
}
if ($debug) {
 header('Content-Type: application/json');
 echo json_encode($itTampung);
}
return $itTampung;
}

public function createPOCatalog($comp, $id = '10164', $chart, $DOC_DATE, $DOC_TYPE, $DELIVERY_DATE, $purch_org, $PUR_GROUP, $debug = true) {
  $this->openFunction('ZCMM_GET_USERATTRIBUTE');
  $this->fce->R_PERNR->row['SIGN'] = 'I';
  $this->fce->R_PERNR->row['OPTION'] = 'EQ';
        // $this->fce->R_PERNR->row['LOW'] =10164;// $id; //
        $this->fce->R_PERNR->row['LOW'] = $id; //
        $this->fce->R_PERNR->Append($this->fce->R_PERNR->row);

        $newdocdate = date('Ymd',strtotime($DOC_DATE));
        $newdelivdate = date('Ymd',strtotime($DELIVERY_DATE));

        $KOSTL = $i = 0;
        if ($debug) {
        	header('Content-Type: application/json');
        	var_dump($this->fce->R_PERNR->row);
        	print_r('<br>');
        }
        $this->fce->call();
        $itTampung = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->T_DATA->Reset();
        	$this->fce->T_DATA->Next();
        	while ($this->fce->T_DATA->Next()) {
        		$itTampung[] = $this->fce->T_DATA->row;
        		if (strpos($itTampung[$i]['ENDDA'], '9999') == 0) {
        			$KOSTL = $itTampung[$i]['KOSTL'];
        		}$i++;
        	}
        }

        $this->openFunction('BAPI_PO_CREATE1');

        if ($debug) {
        	header('Content-Type: application/json');
        	var_dump($chart);
        	print_r('<br>');
        }
        $this->fce->POHEADER['COMP_CODE'] = $comp;
        $this->fce->POHEADER['DOC_TYPE'] = $DOC_TYPE;
        $this->fce->POHEADER['VENDOR'] = $chart[0]['vendorno'];
        $this->fce->POHEADER['PURCH_ORG'] = $purch_org;
        $this->fce->POHEADER['PUR_GROUP'] = $PUR_GROUP;
        $this->fce->POHEADER['CURRENCY'] = $chart[0]['curr'];
        $this->fce->POHEADER['DOC_DATE'] = $newdocdate;

        $this->fce->POHEADERX['COMP_CODE'] = 'X';
        $this->fce->POHEADERX['DOC_TYPE'] = 'X';
        $this->fce->POHEADERX['VENDOR'] = 'X';
        $this->fce->POHEADERX['PURCH_ORG'] = 'X';
        $this->fce->POHEADERX['PUR_GROUP'] = 'X';
        $this->fce->POHEADERX['CURRENCY'] = 'X';
        $this->fce->POHEADERX['DOC_DATE'] = 'X'; //'20161110';
        $po = 10;
        for ($i = 0; $i < sizeof($chart); $i++) {
        	$this->fce->POITEM->row['PO_ITEM'] = '000' . $po;
        	$this->fce->POITEM->row['MATERIAL'] = $chart[$i]['MATNR'];
        	$this->fce->POITEM->row['PLANT'] = $chart[$i]['plant'];
        	$this->fce->POITEM->row['QUANTITY'] = $chart[$i]['QTY'];
            // $this->fce->POITEM->row['ACCTASSCAT'] = $chart[$i]['cat']; // 'K';
        	$this->fce->POITEM->row['AGREEMENT'] = $chart[$i]['contract_no'];
        	$this->fce->POITEM->row['AGMT_ITEM'] = $chart[$i]['contract_itm'];
            // $this->fce->POITEM->row['NET_PRICE'] = '10000';
        	$this->fce->POITEM->Append($this->fce->POITEM->row);

        	$this->fce->POITEMX->row['PO_ITEM'] = $po;
        	$this->fce->POITEMX->row['PO_ITEMX'] = 'X';
        	$this->fce->POITEMX->row['MATERIAL'] = 'X';
        	$this->fce->POITEMX->row['PLANT'] = 'X';
        	$this->fce->POITEMX->row['QUANTITY'] = 'X';
            // $this->fce->POITEMX->row['ACCTASSCAT'] = 'X';
        	$this->fce->POITEMX->row['AGREEMENT'] = 'X';
        	$this->fce->POITEMX->row['AGMT_ITEM'] = 'X';
            // $this->fce->POITEMX->row['NET_PRICE'] = 'X';
        	$this->fce->POITEMX->Append($this->fce->POITEMX->row);

        	$this->fce->POSCHEDULE->row['PO_ITEM'] = $po;
        	$this->fce->POSCHEDULE->row['DELIVERY_DATE'] = $newdelivdate;
        	$this->fce->POSCHEDULE->Append($this->fce->POSCHEDULE->row);

        	$this->fce->POSCHEDULEX->row['PO_ITEM'] = $po;
        	$this->fce->POSCHEDULEX->row['PO_ITEMX'] = 'X';
        	$this->fce->POSCHEDULEX->row['DELIVERY_DATE'] = 'X';
        	$this->fce->POSCHEDULEX->Append($this->fce->POSCHEDULEX->row);

            // $this->fce->POACCOUNT->row['PO_ITEM'] = $po;
            // $this->fce->POACCOUNT->row['COSTCENTER'] = $KOSTL; // '7204142000' pak icuk;//'7104200000';
            // $this->fce->POACCOUNT->Append($this->fce->POACCOUNT->row);

            // $this->fce->POACCOUNTX->row['PO_ITEM'] = $po;
            // $this->fce->POACCOUNTX->row['PO_ITEMX'] = 'X';
            // $this->fce->POACCOUNTX->row['COSTCENTER'] = 'X';
            // $this->fce->POACCOUNTX->Append($this->fce->POACCOUNTX->row);
        	$po+=10;
        }
        $berhasil = false;
        $this->fce->call();
        $data['RETURN'] = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->RETURN->Reset();
        	while ($this->fce->RETURN->Next()) {
        		$data['RETURN'][] = $this->fce->RETURN->row;
        	}
        	if ($data['RETURN'][0]['TYPE'] == 'S')
        		$berhasil = true;
        }
        if ($debug) {
        	var_dump($this->fce->EXPPURCHASEORDER);
        	var_dump($data);
        	print_r('<br>');
        }

        $this->openFunction('BAPI_TRANSACTION_COMMIT');
        $this->fce->call();
        if ($debug) {
        	print_r('<br>');
        }
        return $data;
        // return $data['RETURN'][0]['MESSAGE'];
    }

    public function createPOLangsung($comp = '7000', $id = '10164', $chart, $detail, $debug = true) {        
    	$this->openFunction('ZCMM_GET_USERATTRIBUTE');
    	$this->fce->R_PERNR->row['SIGN'] = 'I';
    	$this->fce->R_PERNR->row['OPTION'] = 'EQ';
        $this->fce->R_PERNR->row['LOW'] = $id; //10164
        $this->fce->R_PERNR->Append($this->fce->R_PERNR->row);

        $KOSTL = $i = 0;
        if ($debug) {
        	header('Content-Type: application/json');
        	var_dump($chart);
        	var_dump($this->fce->R_PERNR->row);
        	print_r('<br>');
        	var_dump($comp);
        }
        $this->fce->call();
        $itTampung = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->T_DATA->Reset();
        	$this->fce->T_DATA->Next();
        	while ($this->fce->T_DATA->Next()) {
        		$itTampung[] = $this->fce->T_DATA->row;
        		if (strpos($itTampung[$i]['ENDDA'], '9999') == 0) {
        			$KOSTL = $itTampung[$i]['KOSTL'];
        		}$i++;
        	}
        }
        $this->openFunction('BAPI_PO_CREATE1');
        $porg = 'HC01';
        if ($comp == '3000')
        	$porg = 'SP01';
        else if ($comp == '4000')
        	$porg = 'ST01';
        else if ($comp == '5000')
        	$porg = 'OP01';
        else if ($comp == '6000')
        	$porg = 'TL01';
        else if ($comp == '7000')
        	$porg = 'KS01';
        $this->fce->POHEADER['COMP_CODE'] = $comp;
        $this->fce->POHEADER['DOC_TYPE'] = 'ZPL'; //
        $this->fce->POHEADER['VENDOR'] = $chart[0]['VENDORNO'];
        $this->fce->POHEADER['PURCH_ORG'] = $porg; // 'KS01';//$chart[0]['porg'];
        $this->fce->POHEADER['PUR_GROUP'] = '100'; // $chart[0]['pgrp'];
        $this->fce->POHEADER['CURRENCY'] = $chart[0]['CURRENCY'];
        //$this->fce->POHEADER['CURRENCY'] = "IDR";
        $this->fce->POHEADER['DOC_DATE'] = date("Ymd"); //'17.01.2017';// date("d.m.Y");

        $this->fce->POHEADERX['COMP_CODE'] = "X";
        $this->fce->POHEADERX['DOC_TYPE'] = "X";
        $this->fce->POHEADERX['VENDOR'] = "X";
        $this->fce->POHEADERX['PURCH_ORG'] = "X";
        $this->fce->POHEADERX['PUR_GROUP'] = "X";
        $this->fce->POHEADERX['CURRENCY'] = "X";
        $this->fce->POHEADERX['DOC_DATE'] = "X";
        $po = 1;
        //funtion pertama kali
        for ($i = 0; $i < sizeof($chart); $i++) {
            //var_dump('PRICE: '.$chart[$i]['PRICE']);
        	$this->fce->POITEM->row['PO_ITEM'] = '' . $po;
        	$this->fce->POITEM->row['MATERIAL'] = $chart[$i]['MATNR'];
            $this->fce->POITEM->row['PLANT'] = $chart[$i]['PLANT']; //'7702';// $chart[$i]['plant']; $chart[$i]['PLANT']; //
            $this->fce->POITEM->row['QUANTITY'] = $chart[$i]['QTY'];
            $this->fce->POITEM->row['ACCTASSCAT'] = 'K'; // $chart[$i]['cat']; //'K';
            // $this->fce->POITEM->row['AGREEMENT'] = $chart[$i]['contract_no'];
            // $this->fce->POITEM->row['AGMT_ITEM'] = $chart[$i]['contract_itm'];
            $this->fce->POITEM->row['NET_PRICE'] =  $chart[$i]['PRICE'];
            //$this->fce->POITEM->row['NET_PRICE'] =  '3500';
            $this->fce->POITEM->row['INFO_REC'] =  '';
            $this->fce->POITEM->Append($this->fce->POITEM->row);

            $this->fce->POITEMX->row['PO_ITEM'] = $po;
            $this->fce->POITEMX->row['PO_ITEMX'] = 'X';
            $this->fce->POITEMX->row['MATERIAL'] = 'X';
            $this->fce->POITEMX->row['PLANT'] = 'X';
            $this->fce->POITEMX->row['QUANTITY'] = 'X';
            $this->fce->POITEMX->row['ACCTASSCAT'] = 'X';
            $this->fce->POITEMX->row['INFO_REC'] = 'X';
            // $this->fce->POITEMX->row['AGREEMENT'] = 'X';
            // $this->fce->POITEMX->row['AGMT_ITEM'] = 'X';
            $this->fce->POITEMX->row['NET_PRICE'] = 'X';
            $this->fce->POITEMX->Append($this->fce->POITEMX->row);

            $this->fce->POSCHEDULE->row['PO_ITEM'] = $po;
            $this->fce->POSCHEDULE->row['DELIVERY_DATE'] = date("Ymd", strtotime("+" . $chart[$i]['DELIVERY_TIME'] . " day", strtotime(date('Y-m-d'))));//'02.04.2017'; //'20161231';
            $this->fce->POSCHEDULE->Append($this->fce->POSCHEDULE->row);

            $this->fce->POSCHEDULEX->row['PO_ITEM'] = $po;
            $this->fce->POSCHEDULEX->row['PO_ITEMX'] = 'X';
            $this->fce->POSCHEDULEX->row['DELIVERY_DATE'] = 'X';
            $this->fce->POSCHEDULEX->Append($this->fce->POSCHEDULEX->row);

            $this->fce->POACCOUNT->row['PO_ITEM'] = $po;
            $this->fce->POACCOUNT->row['COSTCENTER'] = $chart[$i]['COSCENTER'];//$KOSTL; //'7104200000';//$KOSTL;
            // $this->fce->POACCOUNT->row['GL_ACCOUNT'] = $detail['GL']; //'67430001';
            $this->fce->POACCOUNT->Append($this->fce->POACCOUNT->row);

            $this->fce->POACCOUNTX->row['PO_ITEM'] = $po;
            $this->fce->POACCOUNTX->row['PO_ITEMX'] = 'X';
            $this->fce->POACCOUNTX->row['COSTCENTER'] = 'X';
            // $this->fce->POACCOUNTX->row['GL_ACCOUNT'] = 'X';
            $this->fce->POACCOUNTX->Append($this->fce->POACCOUNTX->row);
            $po+=10;

        }      

        $berhasil = false;
        $this->fce->call();
        $data['RETURN'] = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->RETURN->Reset();
        	while ($this->fce->RETURN->Next()) {
        		$data['RETURN'][] = $this->fce->RETURN->row;
        	}
        	if ($data['RETURN'][0]['TYPE'] == 'S')
        		$berhasil = true;
        }
        if ($debug) {
        	var_dump($this->fce->RETURN->row);
        	var_dump($this->fce->EXPPURCHASEORDER);
        	var_dump($data);
        	print_r('<br>');
        }

        $this->openFunction('BAPI_TRANSACTION_COMMIT');
        $this->fce->call();
        if ($debug) {
        	print_r('<br>');
        }
        return $data['RETURN'];
    }

    public function createPOLangsungCart($comp = '7000', $id = '10164', $cart, $costcenter, $gl_account, $debug = true) {        
//        var_dump($cart);die();

    	$this->openFunction('ZCMM_GET_USERATTRIBUTE');
    	$this->fce->R_PERNR->row['SIGN'] = 'I';
    	$this->fce->R_PERNR->row['OPTION'] = 'EQ';
        $this->fce->R_PERNR->row['LOW'] = $id; //10164
        $this->fce->R_PERNR->Append($this->fce->R_PERNR->row);

        $KOSTL = $i = 0;
        if ($debug) {
        	header('Content-Type: application/json');
        	var_dump($cart);
        	var_dump($this->fce->R_PERNR->row);
        	print_r('<br>');
        	var_dump($comp);
        }
        $this->fce->call();
        $itTampung = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->T_DATA->Reset();
        	$this->fce->T_DATA->Next();
        	while ($this->fce->T_DATA->Next()) {
        		$itTampung[] = $this->fce->T_DATA->row;
        		if (strpos($itTampung[$i]['ENDDA'], '9999') == 0) {
        			$KOSTL = $itTampung[$i]['KOSTL'];
        		}$i++;
        	}
        }
        $this->openFunction('BAPI_PO_CREATE1');
        $porg = 'HC01';
        if ($comp == '3000')
        	$porg = 'SP01';
        else if ($comp == '4000')
        	$porg = 'ST01';
        else if ($comp == '5000')
        	$porg = 'OP01';
        else if ($comp == '6000')
        	$porg = 'TL01';
        else if ($comp == '7000')
        	$porg = 'KS01';        
        $this->fce->POHEADER['COMP_CODE'] = $comp;
        $this->fce->POHEADER['DOC_TYPE'] = 'ZPL'; 
        $this->fce->POHEADER['VENDOR'] = $cart[0]['VENDORNO'];
        $this->fce->POHEADER['PURCH_ORG'] = $porg; 
        $this->fce->POHEADER['PUR_GROUP'] = '100'; 
        $this->fce->POHEADER['CURRENCY'] = $cart[0]['CURRENCY'];        
        $this->fce->POHEADER['DOC_DATE'] = date("Ymd"); 

        $this->fce->POHEADERX['COMP_CODE'] = "X";
        $this->fce->POHEADERX['DOC_TYPE'] = "X";
        $this->fce->POHEADERX['VENDOR'] = "X";
        $this->fce->POHEADERX['PURCH_ORG'] = "X";
        $this->fce->POHEADERX['PUR_GROUP'] = "X";
        $this->fce->POHEADERX['CURRENCY'] = "X";
        $this->fce->POHEADERX['DOC_DATE'] = "X";
        $po = 10;
        //funtion pertama kali
        for ($i = 0; $i < sizeof($cart); $i++) {
            //var_dump('PRICE: '.$chart[$i]['PRICE']);
            $this->fce->POITEM->row['PO_ITEM'] = $po;
            $this->fce->POITEM->row['MATERIAL'] = $cart[$i]['MATNR'];
            $this->fce->POITEM->row['PLANT'] = $cart[$i]['PLANT']; //'7702';// $chart[$i]['plant']; $chart[$i]['PLANT']; //
            $this->fce->POITEM->row['QUANTITY'] = $cart[$i]['QTY'];
            $this->fce->POITEM->row['ACCTASSCAT'] = 'K'; // $chart[$i]['cat']; //'K';            
            $this->fce->POITEM->row['NET_PRICE'] =  $cart[$i]['PRICE'];            
            $this->fce->POITEM->row['INFO_REC'] =  '';
            $this->fce->POITEM->Append($this->fce->POITEM->row);

            $this->fce->POITEMX->row['PO_ITEM'] = $po;
            $this->fce->POITEMX->row['PO_ITEMX'] = 'X';
            $this->fce->POITEMX->row['MATERIAL'] = 'X';
            $this->fce->POITEMX->row['PLANT'] = 'X';
            $this->fce->POITEMX->row['QUANTITY'] = 'X';
            $this->fce->POITEMX->row['ACCTASSCAT'] = 'X';
            $this->fce->POITEMX->row['INFO_REC'] = 'X';
            // $this->fce->POITEMX->row['AGREEMENT'] = 'X';
            // $this->fce->POITEMX->row['AGMT_ITEM'] = 'X';
            $this->fce->POITEMX->row['NET_PRICE'] = 'X';
            $this->fce->POITEMX->Append($this->fce->POITEMX->row);

            $this->fce->POSCHEDULE->row['PO_ITEM'] = $po;
            $this->fce->POSCHEDULE->row['DELIVERY_DATE'] = date("Ymd", strtotime("+" . $cart[$i]['DELIVERY_TIME'] . " day", strtotime(date('Y-m-d'))));//'02.04.2017'; //'20161231';
            $this->fce->POSCHEDULE->Append($this->fce->POSCHEDULE->row);

            $this->fce->POSCHEDULEX->row['PO_ITEM'] = $po;
            $this->fce->POSCHEDULEX->row['PO_ITEMX'] = 'X';
            $this->fce->POSCHEDULEX->row['DELIVERY_DATE'] = 'X';
            $this->fce->POSCHEDULEX->Append($this->fce->POSCHEDULEX->row);

            $this->fce->POACCOUNT->row['PO_ITEM'] = $po;
            $this->fce->POACCOUNT->row['GL_ACCOUNT'] = $gl_account;
            $this->fce->POACCOUNT->row['COSTCENTER'] = $costcenter;
            $this->fce->POACCOUNT->Append($this->fce->POACCOUNT->row); 

            $this->fce->POACCOUNTX->row['PO_ITEM'] = $po;
            $this->fce->POACCOUNTX->row['PO_ITEMX'] = 'X';
            $this->fce->POACCOUNTX->row['COSTCENTER'] = 'X';            
            $this->fce->POACCOUNTX->Append($this->fce->POACCOUNTX->row);
            $po+=10;

        }       

        $berhasil = false;
        $this->fce->call();
        $data['RETURN'] = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->RETURN->Reset();
        	while ($this->fce->RETURN->Next()) {
        		$data['RETURN'][] = $this->fce->RETURN->row;
        	}
        	if ($data['RETURN'][0]['TYPE'] == 'S')
        		$berhasil = true;
        }
        if ($debug) {
        	var_dump($this->fce->RETURN->row);
        	var_dump($this->fce->EXPPURCHASEORDER);
        	var_dump($data);
        	print_r('<br>');
        }

        $this->openFunction('BAPI_TRANSACTION_COMMIT');
        $this->fce->call();
        if ($debug) {
        	print_r('<br>');
        }
        return $data['RETURN'];
    }
    
    public function createPOLangsungOld($chart, $debug = true) {
    	$this->openFunction('BAPI_PO_CREATE1');

    	if ($debug) {
    		header('Content-Type: application/json');
    		var_dump($chart);
    		print_r('<br>');
    	}
        $this->fce->POHEADER['COMP_CODE'] = '7000'; //$chart[0]['comp'];
        $this->fce->POHEADER['DOC_TYPE'] = 'ZPL'; //
        $this->fce->POHEADER['VENDOR'] = '0000220021'; //$chart[0]['vendorno'];
        $this->fce->POHEADER['PURCH_ORG'] = 'KS01'; // $chart[0]['porg'];
        $this->fce->POHEADER['PUR_GROUP'] = 'K02'; // $chart[0]['pgrp'];
        $this->fce->POHEADER['CURRENCY'] = 'IDR'; // $chart[0]['curr'];
        $this->fce->POHEADER['DOC_DATE'] = date("Ymd"); //'17.01.2017';// date("d.m.Y");

        $this->fce->POHEADERX['COMP_CODE'] = "X";
        $this->fce->POHEADERX['DOC_TYPE'] = "X";
        $this->fce->POHEADERX['VENDOR'] = "X";
        $this->fce->POHEADERX['PURCH_ORG'] = "X";
        $this->fce->POHEADERX['PUR_GROUP'] = "X";
        $this->fce->POHEADERX['CURRENCY'] = "X";
        $this->fce->POHEADERX['DOC_DATE'] = "X";
        $po = 10;
        for ($i = 0; $i < sizeof($chart); $i++) {
        	$this->fce->POITEM->row['PO_ITEM'] = '000' . $po;
            $this->fce->POITEM->row['MATERIAL'] = '623-000005'; // $chart[$i]['MATNR'];
            $this->fce->POITEM->row['PLANT'] = '7702'; // $chart[$i]['plant'];
            $this->fce->POITEM->row['QUANTITY'] = '2'; // $chart[$i]['QTY'];
            $this->fce->POITEM->row['ACCTASSCAT'] = 'K'; // $chart[$i]['cat']; //'K';
            // $this->fce->POITEM->row['AGREEMENT'] = $chart[$i]['contract_no'];
            // $this->fce->POITEM->row['AGMT_ITEM'] = $chart[$i]['contract_itm'];
            // $this->fce->POITEM->row['NET_PRICE'] = '10000';
            $this->fce->POITEM->Append($this->fce->POITEM->row);

            $this->fce->POITEMX->row['PO_ITEM'] = $po;
            $this->fce->POITEMX->row['PO_ITEMX'] = 'X';
            $this->fce->POITEMX->row['MATERIAL'] = 'X';
            $this->fce->POITEMX->row['PLANT'] = 'X';
            $this->fce->POITEMX->row['QUANTITY'] = 'X';
            $this->fce->POITEMX->row['ACCTASSCAT'] = 'X';
            $this->fce->POITEMX->row['AGREEMENT'] = 'X';
            $this->fce->POITEMX->row['AGMT_ITEM'] = 'X';
            // $this->fce->POITEMX->row['NET_PRICE'] = 'X';
            $this->fce->POITEMX->Append($this->fce->POITEMX->row);

            $this->fce->POSCHEDULE->row['PO_ITEM'] = $po;
            $this->fce->POSCHEDULE->row['DELIVERY_DATE'] = '31.01.2017'; //'20161231';
            $this->fce->POSCHEDULE->Append($this->fce->POSCHEDULE->row);

            $this->fce->POSCHEDULEX->row['PO_ITEM'] = $po;
            $this->fce->POSCHEDULEX->row['PO_ITEMX'] = 'X';
            $this->fce->POSCHEDULEX->row['DELIVERY_DATE'] = 'X';
            $this->fce->POSCHEDULEX->Append($this->fce->POSCHEDULEX->row);

            $this->fce->POACCOUNT->row['PO_ITEM'] = $po;
            $this->fce->POACCOUNT->row['COSTCENTER'] = '7104200000';
            $this->fce->POACCOUNT->row['GL_ACCOUNT'] = '67430001';
            $this->fce->POACCOUNT->Append($this->fce->POACCOUNT->row);

            $this->fce->POACCOUNTX->row['PO_ITEM'] = $po;
            $this->fce->POACCOUNTX->row['PO_ITEMX'] = 'X';
            $this->fce->POACCOUNTX->row['COSTCENTER'] = 'X';
            $this->fce->POACCOUNTX->Append($this->fce->POACCOUNTX->row);
            $po+=10;
        }
        $berhasil = false;
        $this->fce->call();
        $data['RETURN'] = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->RETURN->Reset();
        	while ($this->fce->RETURN->Next()) {
        		$data['RETURN'][] = $this->fce->RETURN->row;
        	}
        	if ($data['RETURN'][0]['TYPE'] == 'S')
        		$berhasil = true;
        }
        if ($debug) {
        	var_dump($this->fce->RETURN->row);
        	var_dump($this->fce->EXPPURCHASEORDER);
        	var_dump($data);
        	print_r('<br>');
        }

        $this->openFunction('BAPI_TRANSACTION_COMMIT');
        $this->fce->call();
        if ($debug) {
        	print_r('<br>');
        }
        return $data['RETURN'];
    }

    public function getGlDesc($comp, $glacc) {
    	$this->openFunction('ZBAPI_GL_ACC_GETDETAIL');
    	$this->fce->COMPANYCODE = $comp;
    	$this->fce->GLACCT = $glacc;
    	$this->fce->LANGUAGE = 'EN';
    	$this->fce->call();
        // $KOSTL_DESC=$this->fce->ACCOUNT_DETAIL;
    	return $this->fce->ACCOUNT_DETAIL;
    }

    public function createInvEC($dataINV, $item, $pajakPosting, $GLAccount,$taxData, $debug = false) {
    	$this->openFunction('BAPI_INCOMINGINVOICE_PARK');

        $this->fce->HEADERDATA['INVOICE_IND'] = $dataINV['INVOICE_IND']; //"X";
        $this->fce->HEADERDATA['DOC_TYPE'] = $dataINV['DOC_TYPE']; //"RE";
        $this->fce->HEADERDATA['DOC_DATE'] = $dataINV['TGL_INV']; //inputan default tgl inv
        $this->fce->HEADERDATA['PSTNG_DATE'] = $dataINV['TGL_POST']; //inputan default skrg
        $this->fce->HEADERDATA['REF_DOC_NO'] = $dataINV['FAKTUR_PJK']; // $dataINV['']
        $this->fce->HEADERDATA['COMP_CODE'] = $dataINV['COMP_CODE']; //'7000';//sementara harcode
        $this->fce->HEADERDATA['CURRENCY'] = $dataINV['CURR'];
        $this->fce->HEADERDATA['GROSS_AMOUNT'] = $dataINV['TOTAL_AMOUNT'];
        $this->fce->HEADERDATA['CALC_TAX_IND'] = $dataINV['CALC_TAX_IND']; //"X";
        $this->fce->HEADERDATA['PMNTTRMS'] = $dataINV['PMNTTRMS']; //"X";
        $this->fce->HEADERDATA['BLINE_DATE'] = $dataINV['BLINE_DATE']; //"X";
        $this->fce->HEADERDATA['PARTNER_BK'] = $dataINV['PARTNER_BK']; //"X";

        $this->fce->HEADERDATA['HEADER_TXT'] = $dataINV['INV_NO'];
        $this->fce->HEADERDATA['PMNT_BLOCK'] = $dataINV['PMNT_BLOCK']; // 3;//$dataINV['PAYMENT'];//default 3
        $this->fce->HEADERDATA['PYMT_METH'] = $dataINV['PYMT_METH']; //"T";
        //	$this->fce->HEADERDATA['PARTNER_BK']= "IDR1";
        $this->fce->HEADERDATA['ITEM_TEXT'] = $dataINV['NOTE_VERI']; //inputan

        for ($i = 0; $i < count($item); $i++) {
        	$this->fce->ITEMDATA->row['INVOICE_DOC_ITEM'] = $i + 1;
        	$this->fce->ITEMDATA->row['PO_NUMBER'] = $item[$i]['PO_NO'];
        	$this->fce->ITEMDATA->row['PO_ITEM'] = $item[$i]['PO_ITEM_NO'];
        	if($dataINV['ITEM_CAT'] == '9'){
        		$this->fce->ITEMDATA->row['SHEET_NO'] = $item[$i]['GR_NO'];
        		$this->fce->ITEMDATA->row['SHEET_ITEM'] = str_pad($item[$i]['GR_ITEM_NO'] * 10, 10, '0', STR_PAD_LEFT);
        		$this->fce->ITEMDATA->row['PO_UNIT'] = !empty($item[$i]['UOM']) ? $item[$i]['UOM'] : 'AU';
                //$this->fce->ITEMDATA->row['PO_UNIT'] = 'EA';
        	}else{
        		$this->fce->ITEMDATA->row['REF_DOC'] = $item[$i]['GR_NO'];
        		$this->fce->ITEMDATA->row['REF_DOC_YEAR'] = empty($item[$i]['GR_YEAR']) ? date('Y') : $item[$i]['GR_YEAR'];
        		$this->fce->ITEMDATA->row['REF_DOC_IT'] = str_pad($item[$i]['GR_ITEM_NO'], 4, '0', STR_PAD_LEFT);
        		$this->fce->ITEMDATA->row['PO_UNIT'] = !empty($item[$i]['UOM']) ? $item[$i]['UOM'] : 'TO';
        	}

            $this->fce->ITEMDATA->row['TAX_CODE'] = $item[$i]['TAX_CODE']; //$dataINV['TAX_CODE']; //'VZ';
            $this->fce->ITEMDATA->row['ITEM_AMOUNT'] = $item[$i]['GR_AMOUNT_IN_DOC'];
            $this->fce->ITEMDATA->row['QUANTITY'] = $item[$i]['GR_ITEM_QTY'];

            $this->fce->ITEMDATA->Append($this->fce->ITEMDATA->row);
        }
        if (!empty($pajakPosting)) {
        	foreach ($pajakPosting as $pp) {
        		$this->fce->WITHTAXDATA->row['WI_TAX_CODE'] = $pp['TAX_CODE'];
        		$this->fce->WITHTAXDATA->row['WI_TAX_TYPE'] = $pp['WTAX_TYPE'];
        		$this->fce->WITHTAXDATA->row['WI_TAX_BASE'] = $pp['AMOUNT'];
        		$this->fce->WITHTAXDATA->Append($this->fce->WITHTAXDATA->row);
        	}
        }

        if (!empty($GLAccount)) {
        	$i = 1;
        	foreach ($GLAccount as $kodegl => $gl) {
        		$this->fce->GLACCOUNTDATA->row['INVOICE_DOC_ITEM'] = $i++;
        		$this->fce->GLACCOUNTDATA->row['GL_ACCOUNT'] = $gl['GLACCOUNT'];
        		$this->fce->GLACCOUNTDATA->row['ITEM_AMOUNT'] = $gl['AMOUNT'];
        		$this->fce->GLACCOUNTDATA->row['DB_CR_IND'] = $gl['DB_CR_IND'];
        		$this->fce->GLACCOUNTDATA->row['COMP_CODE'] = $dataINV['COMP_CODE'];
        		$this->fce->GLACCOUNTDATA->row['TAX_CODE'] = $gl['TAX_CODE'];
        		$this->fce->GLACCOUNTDATA->row['PROFIT_CTR'] = $gl['PROFIT_CTR'];
                //    $this->fce->GLACCOUNTDATA->row['ITEM_TEXT'] = ' ';
        		$this->fce->GLACCOUNTDATA->Append($this->fce->GLACCOUNTDATA->row);
        	}
        }

        if (!empty($taxData)) {
        	$i = 1;
        	foreach ($taxData as $tax ) {
        		$this->fce->TAXDATA->row['TAX_CODE'] = $tax['TAX_CODE'];
        		$this->fce->TAXDATA->row['TAX_AMOUNT'] = $tax['TAX_AMOUNT'];
        		$this->fce->TAXDATA->row['TAX_BASE_AMOUNT'] = $tax['TAX_BASE_AMOUNT'];
        		$this->fce->TAXDATA->Append($this->fce->TAXDATA->row);
        	}
        }

        $this->fce->call();

        if ($debug) {
        	header('Content-Type: application/json');
        	var_dump($this->fce->HEADERDATA);
            //var_dump($this->fce->ITEMDATA);
        	var_dump($this->fce->GLACCOUNTDATA);
            //var_dump($this->fce->WITHTAXDATA);
        	$this->fce->RETURN->Reset();
        	while ($this->fce->ITEMDATA->Next()) {
        		var_dump($this->fce->ITEMDATA->row);
        	}
        	$this->fce->RETURN->Reset();
        	while ($this->fce->RETURN->Next()) {
        		var_dump($this->fce->RETURN->row);
        	}

        	$this->fce->TAXDATA->Reset();
        	while ($this->fce->TAXDATA->Next()) {
        		var_dump($this->fce->TAXDATA->row);
        	}
        }

        $invoicenumber = $this->fce->INVOICEDOCNUMBER;
        $fiscalyear = $this->fce->FISCALYEAR;

        $error = array();
        $this->fce->RETURN->Reset();
        while($this->fce->RETURN->next()){
        	array_push($error,$this->fce->RETURN->row);
        }
        $this->openFunction('BAPI_TRANSACTION_COMMIT');
        $this->fce->call();
        if(!empty($invoicenumber)){
        	return array(
        		'data' => array('invoicenumber' => $invoicenumber, 'fiscalyear' => $fiscalyear),
        		'status' => 1,
          );
        } else {
        	return array(
        		'data' => $error,
        		'status' => 0,
          );
        }
    }

    public function changeParkInvoice($dataINV,$item,$GLAccount,$pajakPosting,$taxData, $debug){
    	$this->openFunction('BAPI_INCOMINGINVOICE_CHANGE');
    	$this->fce->INVOICEDOCNUMBER = $dataINV['INVOICE_SAP'];
    	$this->fce->FISCALYEAR = $dataINV['FISCALYEAR_SAP'];
    	$this->fce->TABLE_CHANGE['WITHTAXDATA'] = 'X';
    	$this->fce->TABLE_CHANGE['ITEMDATA'] = 'X';
    	$this->fce->TABLE_CHANGE['GLACCOUNTDATA'] = 'X';

    	if(!empty($taxData)){
            // $this->fce->TABLE_CHANGE['TAXDATA'] = 'X';
    	}
    	$this->fce->HEADERDATA_CHANGE['PSTNG_DATE'] = $dataINV['TGL_POST'];
    	$this->fce->HEADERDATA_CHANGE['PMNT_BLOCK'] = $dataINV['PMNT_BLOCK'];
    	$this->fce->HEADERDATA_CHANGE['GROSS_AMOUNT'] = $dataINV['TOTAL_AMOUNT'];
    	$this->fce->HEADERDATA_CHANGE['CALC_TAX_IND'] = $dataINV['CALC_TAX_IND'];

    	$this->fce->HEADERDATA_CHANGEX['PSTNG_DATE'] = 'X';
    	$this->fce->HEADERDATA_CHANGEX['PMNT_BLOCK'] = 'X';
    	$this->fce->HEADERDATA_CHANGEX['GROSS_AMOUNT'] = 'X';
    	$this->fce->HEADERDATA_CHANGEX['CALC_TAX_IND'] = 'X';

    	for ($i = 0; $i < count($item); $i++) {
    		$this->fce->ITEMDATA->row['INVOICE_DOC_ITEM'] = $item[$i]['INVOICE_DOC_ITEM'];
    		$this->fce->ITEMDATA->row['PO_NUMBER'] = $item[$i]['PO_NUMBER'];
    		$this->fce->ITEMDATA->row['PO_ITEM'] = $item[$i]['PO_ITEM'];

    		$this->fce->ITEMDATA->row['SHEET_NO'] = $item[$i]['SHEET_NO'];
    		$this->fce->ITEMDATA->row['SHEET_ITEM'] = $item[$i]['SHEET_ITEM'];
    		$this->fce->ITEMDATA->row['PO_UNIT'] = $item[$i]['PO_UNIT'];

    		$this->fce->ITEMDATA->row['REF_DOC'] = $item[$i]['REF_DOC'];
    		$this->fce->ITEMDATA->row['REF_DOC_YEAR'] = $item[$i]['REF_DOC_YEAR'];
    		$this->fce->ITEMDATA->row['REF_DOC_IT'] = $item[$i]['REF_DOC_IT'];

            $this->fce->ITEMDATA->row['TAX_CODE'] = $item[$i]['TAX_CODE']; //$dataINV['TAX_CODE']; //'VZ';
            $this->fce->ITEMDATA->row['ITEM_AMOUNT'] = $item[$i]['ITEM_AMOUNT'];
            $this->fce->ITEMDATA->row['QUANTITY'] = $item[$i]['QUANTITY'];

            $this->fce->ITEMDATA->Append($this->fce->ITEMDATA->row);
        }

        if (!empty($pajakPosting)) {
        	foreach ($pajakPosting as $pp) {
        		$this->fce->WITHTAXDATA->row['SPLIT_KEY'] = '000001';
        		$this->fce->WITHTAXDATA->row['WI_TAX_TYPE'] = $pp['WTAX_TYPE'];
        		$this->fce->WITHTAXDATA->row['WI_TAX_CODE'] = '';
        		$this->fce->WITHTAXDATA->row['WI_TAX_BASE'] = '';
        		if(!empty($pp['AMOUNT'])){
        			$this->fce->WITHTAXDATA->row['WI_TAX_CODE'] = $pp['TAX_CODE'];
        			$this->fce->WITHTAXDATA->row['WI_TAX_BASE'] = $pp['AMOUNT'];
        		}
        		$this->fce->WITHTAXDATA->Append($this->fce->WITHTAXDATA->row);
        	}
        }


        if (!empty($GLAccount)) {
        	$i = 1;
        	foreach ($GLAccount as $kodegl => $gl) {
        		$this->fce->GLACCOUNTDATA->row['INVOICE_DOC_ITEM'] = $i++;
        		$this->fce->GLACCOUNTDATA->row['GL_ACCOUNT'] = $gl['GLACCOUNT'];
        		$this->fce->GLACCOUNTDATA->row['ITEM_AMOUNT'] = $gl['AMOUNT'];
        		$this->fce->GLACCOUNTDATA->row['DB_CR_IND'] = $gl['DB_CR_IND'];
        		$this->fce->GLACCOUNTDATA->row['COMP_CODE'] = $dataINV['COMP_CODE'];
        		$this->fce->GLACCOUNTDATA->row['PROFIT_CTR'] = $gl['PROFIT_CTR'];
        		$this->fce->GLACCOUNTDATA->row['TAX_CODE'] = $gl['TAX_CODE'];
        		$this->fce->GLACCOUNTDATA->row['COSTCENTER'] = $gl['COSTCENTER'];
        		$this->fce->GLACCOUNTDATA->Append($this->fce->GLACCOUNTDATA->row);
        	}
        }

        if (!empty($taxData)) {
        	$i = 1;
        	foreach ($taxData as $tax ) {
        		$this->fce->TAXDATA->row['TAX_CODE'] = $tax['TAX_CODE'];
        		$this->fce->TAXDATA->row['TAX_AMOUNT'] = $tax['TAX_AMOUNT'];
        		$this->fce->TAXDATA->row['TAX_BASE_AMOUNT'] = $tax['TAX_BASE_AMOUNT'];
        		$this->fce->TAXDATA->Append($this->fce->TAXDATA->row);
        	}
        }

        $this->fce->call();
        if ($debug) {
        	header('Content-Type: application/json');
        	echo 'headerdata_change';
        	var_dump($this->fce->HEADERDATA_CHANGE);
        	echo 'table_change';
        	var_dump($this->fce->TABLE_CHANGE);
        	var_dump($this->fce->GLACCOUNTDATA);
        	var_dump($this->fce->HEADERDATA_CHANGEX);
            // var_dump($this->fce->WITHTAXDATA);
        	$this->fce->WITHTAXDATA->Reset();
        	while ($this->fce->WITHTAXDATA->Next()) {
        		var_dump($this->fce->WITHTAXDATA->row);
        	}
        	$this->fce->RETURN->Reset();
        	while ($this->fce->ITEMDATA->Next()) {
        		var_dump($this->fce->ITEMDATA->row);
        	}
        	$this->fce->RETURN->Reset();
        	while ($this->fce->RETURN->Next()) {
        		var_dump($this->fce->RETURN->row);
        	}

        	$this->fce->TAXDATA->Reset();
        	while ($this->fce->TAXDATA->Next()) {
        		var_dump($this->fce->TAXDATA->row);
        	}

        }
        $error = array();
        $this->fce->RETURN->Reset();
        $gagal = 0;
        while($this->fce->RETURN->next()){
        	array_push($error,$this->fce->RETURN->row);
        	if($this->fce->RETURN->row['TYPE'] == 'E'){
        		$gagal++;
        	}
        }
        $this->openFunction('BAPI_TRANSACTION_COMMIT');
        $this->fce->call();

        $pesan = '';
        if(!$gagal){
        	$noinvoice = $dataINV['INVOICE_SAP'];
        	$tahun = $dataINV['FISCALYEAR_SAP'];
        	return array(
        		'data' => 'Nomer mir '.$noinvoice.' tahun '.$tahun.' changed',
        		'status' => 1,
          );
        }else{
        	return array(
        		'data' => $error,
        		'status' => 0,
          );
        }

    }

    public function postingInvoice($noinvoice,$tahun){
    	/* posting data sekarang */
    	$this->openFunction('BAPI_INCOMINGINVOICE_POST');
    	$this->fce->INVOICEDOCNUMBER = $noinvoice;
    	$this->fce->FISCALYEAR = $tahun;
    	$this->fce->call();
    	$error = array();
    	$gagal = 0;
    	$this->fce->RETURN->Reset();
    	while($this->fce->RETURN->next()){
    		array_push($error,$this->fce->RETURN->row);
    		if($this->fce->RETURN->row['TYPE'] == 'E'){
    			$gagal++;
    		}
    	}

    	$this->openFunction('BAPI_TRANSACTION_COMMIT');
    	$this->fce->call();
    	if(!$gagal){
    		$pesan = 'Nomer mir '.$noinvoice.' tahun '.$tahun.' posted';
    		return array(
    			'data' => $pesan,
    			'status' => 1,
           );
    	}else{
    		return array(
    			'data' => $error,
    			'status' => 0,
           );
    	}
    }

    public function getGetGR2($PO_NO, $VND_NO, $debug = false) {
    	$this->openFunction('Z_ZCMM_GET_GR');
        $this->fce->FT_PO_NO->row['PO_NO'] = "6910000013"; //$PO_NO;
        $this->fce->FT_PO_NO->row['VENDOR_NO'] = "0000112709"; // $VND_NO;
        $this->fce->FT_PO_NO->Append($this->fce->FT_PO_NO->row);
        $this->fce->call();
        // $itTampung = array();
        // if ($this->fce->GetStatus() == SAPRFC_OK) {
        // $this->fce->FT_GR_LIST->Reset();
        // $this->fce->FT_GR_LIST->Next();
        // while ($this -> fce -> FT_GR_LIST  -> Next()) {
        // $itTampung[] = $this -> fce -> FT_GR_LIST  -> row;
        // }
        // }
        if ($debug) {
        	header('Content-Type: application/json');
            // var_dump($this -> fce -> FT_RETURN);
        	var_dump($this->fce->FT_GR_LIST->row);
            // var_dump($this -> fce -> FT_GR_LIST);
        	var_dump($this->fce->FT_PO_HEADER);
            // var_dump($itTampung);
        }
        // return $itTampung;
    }

    public function getGET_PO_OPENINV($VND_NO, $debug = false) {
    	$this->openFunction('Z_ZCMM_GET_PO_OPENINV');
    	$this->fce->FI_VENDOR_NO = $VND_NO;

    	$this->fce->call();
        // $availabledata = array('EBELN', 'EBELP', 'GJAHR', 'BELNR', 'BUZEI', 'BWART', 'MENGE', 'DMBTR', 'WRBTR', 'WAERS', 'SHKZG', 'ELIKZ', 'XBLNR', 'LFGJA', 'LFBNR', 'LFPOS', 'MATNR', 'WERKS', 'BLDAT', 'BUDAT', 'CPUDT', 'CPUTM', 'ERNAM');
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->FT_PO_HEADER->Reset();
    		while ($this->fce->FT_PO_HEADER->Next()) {
    			$hold = $this->fce->FT_PO_HEADER->row;
                // $hold = array_intersect_key($hold, array_flip((array) $availabledata));
    			$itTampung[] = $hold['PO_NO'];
    		}
    	}
    	if ($debug) {
    		header('Content-Type: application/json');
    		var_dump($itTampung);
    	}
    	return $itTampung;
    }

    public function getGR3($VND_NO, $hari, $debug = false) {
    	$this->openFunction('Z_ZCMM_EKBE');
    	$this->fce->FI_VGABE = "1";
    	$this->fce->FI_GJAHR = date('Y');
    	$this->fce->FI_CPUDT_FROM = date("Ymd", strtotime("-" . $hari . " day", strtotime(date('Y-m-d'))));
    	$this->fce->FI_CPUDT_TO = date('Ymd');

    	$this->fce->call();
    	$availabledata = array('EBELN', 'EBELP', 'GJAHR', 'BELNR', 'BUZEI', 'BWART', 'MENGE', 'DMBTR', 'WRBTR', 'WAERS', 'SHKZG', 'ELIKZ', 'XBLNR', 'LFGJA', 'LFBNR', 'LFPOS', 'MATNR', 'WERKS', 'BLDAT', 'BUDAT', 'CPUDT', 'CPUTM', 'ERNAM');
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->FT_DATA->Reset();
    		while ($this->fce->FT_DATA->Next()) {
    			$hold = $this->fce->FT_DATA->row;
    			$hold = array_intersect_key($hold, array_flip((array) $availabledata));
    			$itTampung[] = $hold;
    		}
    	}
    	if ($debug) {
    		header('Content-Type: application/json');
            // var_dump( $this->fce->FT_DATA->row);
    		var_dump($itTampung);
    	}
    	$this->openFunction('Z_ZCMM_GET_PO_OPENINV');
    	$this->fce->FI_VENDOR_NO = $VND_NO;
    	$this->fce->call();
    	$PO = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->FT_PO_HEADER->Reset();
    		while ($this->fce->FT_PO_HEADER->Next()) {
    			$hold = $this->fce->FT_PO_HEADER->row;
    			$PO[] = $hold['PO_NO'];
    		}
    	}
    	$hasil = array();
    	foreach ($itTampung as $data) {
    		$ada = false;
    		foreach ($PO as $val) {
    			if ($data['EBELN'] == $val) {
    				$ada = true;
    				break;
    			}
    		}
    		if ($ada) {
    			$hasil[] = $data;
    		}
    	}
    	if ($debug) {
    		var_dump($PO);
    		var_dump($hasil);
    	}
    	return $hasil;
    }

    public function getGR2($PO_NO, $VND_NO, $debug = false) {
    	$this->openFunction('BAPI_GOODSMVT_GETITEMS');

    	$this->fce->PLANT_RA->row['SIGN'] = 'I';
    	$this->fce->PLANT_RA->row['OPTION'] = 'EQ';
    	$this->fce->PLANT_RA->row['LOW'] = '7702';
    	$this->fce->PLANT_RA->Append($this->fce->PLANT_RA->row);

    	$this->fce->MOVE_TYPE_RA->row['SIGN'] = 'I';
    	$this->fce->MOVE_TYPE_RA->row['OPTION'] = 'EQ';
    	$this->fce->MOVE_TYPE_RA->row['LOW'] = '01012009';
        // $this->fce->MOVE_TYPE_RA->Append($this->fce->MOVE_TYPE_RA->row);

    	$this->fce->TR_EV_TYPE_RA->row['SIGN'] = 'I';
    	$this->fce->TR_EV_TYPE_RA->row['OPTION'] = 'EQ';
    	$this->fce->TR_EV_TYPE_RA->row['LOW'] = 'WE';
        // $this->fce->PLANT_RA->row['HIGH'] = $NOW;
    	$this->fce->TR_EV_TYPE_RA->Append($this->fce->TR_EV_TYPE_RA->row);
    	$this->fce->PSTNG_DATE_RA->row['SIGN'] = 'I';
    	$this->fce->PSTNG_DATE_RA->row['OPTION'] = 'BT';
    	if (strpos('01,02,03', date("d")) !== false) {
    		$this->fce->PSTNG_DATE_RA->row['LOW'] = date("Ymd");
    		$this->fce->PSTNG_DATE_RA->row['HIGH'] = date("Ymd");
    	} else {
    		$this->fce->PSTNG_DATE_RA->row['LOW'] = date("Ymd");
    		$this->fce->PSTNG_DATE_RA->row['HIGH'] = date("Ymd");
    	}
        // $this->fce->PSTNG_DATE_RA->Append($this->fce->PSTNG_DATE_RA->row);

    	$this->fce->call();
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->GOODSMVT_HEADER->Reset();
    		while ($this->fce->GOODSMVT_HEADER->Next()) {
    			$itTampung[] = $this->fce->GOODSMVT_HEADER->row;
    		}
    		$this->fce->GOODSMVT_ITEMS->Reset();
    		while ($this->fce->GOODSMVT_ITEMS->Next()) {
    			$itTampung2[] = $this->fce->GOODSMVT_ITEMS->row;
    		}
    	}
    	if ($debug) {
    		header('Content-Type: application/json');
    		var_dump($itTampung);
    		print_r('\n Items');
    		var_dump($itTampung2);
    	}
    	return $itTampung;
    }

    public function getGR($PO_NO, $VND_NO, $debug = false) {
    	$this->openFunction('Z_ZCMM_GET_GR');
        $this->fce->FT_PO_NO->row['PO_NO'] = "6910000013"; //$PO_NO;
        $this->fce->FT_PO_NO->row['VENDOR_NO'] = "0000112709"; // $VND_NO;
        $this->fce->FT_PO_NO->Append($this->fce->FT_PO_NO->row);
        $this->fce->call();
        $itTampung = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->FT_GR_LIST->Reset();
        	while ($this->fce->FT_GR_LIST->Next()) {
        		$itTampung[] = $this->fce->FT_GR_LIST->row;
        	}
        }
        if ($debug) {
        	header('Content-Type: application/json');
        	var_dump($itTampung);
        }
        return $itTampung;
    }


    public function GET_MATERIALGLACCOUNT ($user,$matno='603-200850',$plant='7702', $debug = false) {
    	$this->openFunction('ZCMM_GET_MATERIALGLACCOUNT');
    	$this->fce->R_MATNR ->row['SIGN'] = 'I';
    	$this->fce->R_MATNR ->row['OPTION'] = 'EQ';
    	$this->fce->R_MATNR ->row['LOW'] = $matno;
    	$this->fce->R_MATNR ->Append($this->fce->R_MATNR ->row);

    	$this->fce->R_BWKEY ->row['SIGN'] = 'I';
    	$this->fce->R_BWKEY ->row['OPTION'] = 'EQ';
    	$this->fce->R_BWKEY ->row['LOW'] = $plant;
    	$this->fce->R_BWKEY ->Append($this->fce->R_BWKEY ->row);

    	$this->fce->R_KTOPL->row['SIGN'] = 'I';
    	$this->fce->R_KTOPL->row['OPTION'] = 'EQ';
    	$this->fce->R_KTOPL->row['LOW'] = 'SGG';
    	$this->fce->R_KTOPL->Append($this->fce->R_KTOPL->row);

    	$this->fce->R_KTOSL ->row['SIGN'] = 'I';
    	$this->fce->R_KTOSL ->row['OPTION'] = 'EQ';
    	$this->fce->R_KTOSL ->row['LOW'] = 'GBB';
    	$this->fce->R_KTOSL ->Append($this->fce->R_KTOSL ->row);

    	$this->fce->R_BWMOD->row['SIGN'] = 'I';
    	$this->fce->R_BWMOD->row['OPTION'] = 'EQ';
    	$this->fce->R_BWMOD->row['LOW'] = '0002';
    	$this->fce->R_BWMOD->Append($this->fce->R_BWMOD->row);

    	$this->fce->R_KOMOK->row['SIGN'] = 'I';
    	$this->fce->R_KOMOK->row['OPTION'] = 'EQ';
    	$this->fce->R_KOMOK->row['LOW'] = 'VBR';
    	$this->fce->R_KOMOK->Append($this->fce->R_KOMOK->row);

    	$this->fce->call();
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->T_DATA->Reset();
    		while ($this->fce->T_DATA->Next()) {
    			$itTampung[] = $this->fce->T_DATA->row;
    		}
    	}
    	if ($debug) {
    		header('Content-Type: application/json');

    		var_dump($itTampung);
    		print_r('<br>');

    	}
    	return $itTampung;
    }
    public function PO_CHANGE ($PO,$data, $debug = false) {
//        $PO='60021';                     
    	$this->openFunction('BAPI_PO_GETDETAIL1');
        $this->fce->PURCHASEORDER  = $PO;//'4500000496';//
        $this->fce->call();
        $itTampung = array();
        $dt = array();
        $dt2 = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->POITEM->Reset();
        	while ($this->fce->POITEM->Next()) {
        		$itTampung[] = $this->fce->POITEM->row;
        		$itemp = $this->fce->POITEM->row;
        		$dt[$itemp['MATERIAL'].$itemp['PLANT']]=$itemp['PO_ITEM'];
        	}
        }
        foreach ($data as $val){
        	$dt2[$val['MATNO'].$val['PLANT']]=$val['EST_DELIV'];
            //$dt2['603-200850'.$val['PLANT']]=$val['EST_DELIV'];
        }
        if ($debug) {
        	header('Content-Type: application/json');
        	var_dump($itTampung);
        	var_dump($dt);
        	var_dump($dt2);
        }

        $this->openFunction('BAPI_PO_CHANGE');
        $this->fce->PURCHASEORDER  = $PO;
        foreach($dt as $key=>$value){
            $this->fce->POSCHEDULE->row['PO_ITEM'] = $dt[$key];
            $this->fce->POSCHEDULE->row['SCHED_LINE'] =  '1';
            $this->fce->POSCHEDULE->row['DELIVERY_DATE'] = $dt2[$key];
            $this->fce->POSCHEDULE->Append($this->fce->POSCHEDULE->row);

            $this->fce->POSCHEDULEX->row['PO_ITEM'] = $dt[$key];
            $this->fce->POSCHEDULEX->row['PO_ITEMX'] = 'X';
            $this->fce->POSCHEDULEX->row['SCHED_LINE'] = '1';
            $this->fce->POSCHEDULEX->row['SCHED_LINEX'] = 'X';
            $this->fce->POSCHEDULEX->row['DELIVERY_DATE'] = 'X';
            $this->fce->POSCHEDULEX->Append($this->fce->POSCHEDULEX->row);

        }        
        $this->fce->call();
        $data['RETURN'] = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->RETURN->Reset();
        	while ($this->fce->RETURN->Next()) {
        		$data['RETURN'][] = $this->fce->RETURN->row;
        	}
        	if ($data['RETURN'][0]['TYPE'] == 'S')
        		$berhasil = true;
        }
        if ($debug) {
        	var_dump($data['RETURN']);
        }
        return $berhasil?1:0;
    }

    public function PO_CHANGE_REJECT ($PO,$data, $debug = false) {
    	$this->openFunction('BAPI_PO_GETDETAIL1');
        $this->fce->PURCHASEORDER  = $PO;//'4500000496';//
        $this->fce->call();
        $itTampung = array();
        $dt = array();
        $dt2 = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->POITEM->Reset();
        	while ($this->fce->POITEM->Next()) {
        		$itTampung[] = $this->fce->POITEM->row;
        		$itemp = $this->fce->POITEM->row;
        		$dt[$itemp['MATERIAL'].$itemp['PLANT']]=$itemp['PO_ITEM'];
        	}
        }
        foreach ($data as $val){
        	$dt2[$val['MATNO'].$val['PLANT']]=$val['EST_DELIV'];
        }
        if ($debug) {
        	header('Content-Type: application/json');
        	var_dump($itTampung);
        	var_dump($dt);
        	var_dump($dt2);
        }

        $this->openFunction('BAPI_PO_CHANGE');
        $this->fce->PURCHASEORDER  = $PO;
        foreach($dt as $key=>$value){
        	$this->fce->POSCHEDULE->row['PO_ITEM'] = $dt[$key];
        	$this->fce->POSCHEDULE->row['DELETE_IND'] =  'L';
        	$this->fce->POSCHEDULE->Append($this->fce->POSCHEDULE->row);

        	$this->fce->POSCHEDULEX->row['PO_ITEM'] = $dt[$key];
        	$this->fce->POSCHEDULEX->row['PO_ITEMX'] = 'X';
        	$this->fce->POSCHEDULEX->row['DELETE_IND'] = 'X';
        	$this->fce->POSCHEDULEX->Append($this->fce->POSCHEDULEX->row);

        }
        $this->fce->call();
        $data['RETURN'] = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->RETURN->Reset();
        	while ($this->fce->RETURN->Next()) {
        		$data['RETURN'][] = $this->fce->RETURN->row;
        	}
        	if ($data['RETURN'][0]['TYPE'] == 'S')
        		$berhasil = true;
        }
        if ($debug) {
        	var_dump($data['RETURN']);
        }
        return $berhasil?2:0;
    }

    public function GET_REPORTBUDGET ($user,$CC= '2104200000', $debug = false) {        
    	$this->openFunction('ZCMM_GET_REPORTBUDGET');        
    	$this->fce->P_GJAHR = date('Y');        

    	$this->fce->R_FIKRS->row['SIGN'] = 'I';
    	$this->fce->R_FIKRS->row['OPTION'] = 'EQ'; 
        $this->fce->R_FIKRS->row['LOW'] ='SGG'.$user;
        $this->fce->R_FIKRS->Append($this->fce->R_FIKRS->row);

        $this->fce->R_FICTR->row['SIGN'] = 'I';
        $this->fce->R_FICTR->row['OPTION'] = 'EQ';
        $this->fce->R_FICTR->row['LOW'] = $CC; //
        $this->fce->R_FICTR->Append($this->fce->R_FICTR->row);

        $this->fce->call();
        $itTampung = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->T_DATA->Reset();
        	while ($this->fce->T_DATA->Next()) {
        		$itTampung[] = $this->fce->T_DATA->row;
        	}
        }
        if ($debug) {
        	header('Content-Type: application/json');

        	var_dump($itTampung);
        	print_r('<br>');

        }
        return $itTampung;
    }

    public function COSTCENTER_GETLIST ($plant, $debug = false) {
    	$this->openFunction('BAPI_COSTCENTER_GETLIST1');
    	$this->fce->CONTROLLINGAREA = 'SGG';
    	$this->fce->COMPANYCODE_FROM = $plant;
//        $this->fce->COMPANYCODE_FROM = $user['COMPANYID'];
//         $this->fce->COMPANYCODE_FROM = '3000';
    	$this->fce->call();
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->COSTCENTERLIST->Reset();
    		while ($this->fce->COSTCENTERLIST->Next()) {
    			$itTampung[] = $this->fce->COSTCENTERLIST->row;
    		}
    	}
    	if ($debug) {
    		// header('Content-Type: application/json');
//            var_dump($user);
    		var_dump($itTampung);
    		print_r('<br>');
    	}
    	return $itTampung;
    }
    public function getCurrentBudget($id, $debug = false) {
    	$this->openFunction('ZCMM_GET_USERATTRIBUTE');
    	$this->fce->R_PERNR->row['SIGN'] = 'I';
    	$this->fce->R_PERNR->row['OPTION'] = 'EQ';
        $this->fce->R_PERNR->row['LOW'] = $id; //10164
        $this->fce->R_PERNR->Append($this->fce->R_PERNR->row);

        $KOSTL = $i = 0;
        if ($debug) {
        	header('Content-Type: application/json');
        	var_dump($this->fce->R_PERNR->row);
        	print_r('<br>');
        }
        $this->fce->call();
        $itTampung = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->T_DATA->Reset();
        	$this->fce->T_DATA->Next();
        	while ($this->fce->T_DATA->Next()) {
        		$itTampung[] = $this->fce->T_DATA->row;
        		if (strpos($itTampung[$i]['ENDDA'], '9999') == 0) {
        			$KOSTL = $itTampung[$i]['KOSTL'];
        		}$i++;
        	}
        }
        if ($debug) {
        	var_dump($itTampung);
        	print_r($KOSTL . '<br>');
        }
        $this->openFunction('ZBAPI_COSTCENTER_GETDETAIL');
        $this->fce->CONTROLLINGAREA = 'SGG';
        $this->fce->COSTCENTER = $KOSTL; //'7204142000';//
        $this->fce->DATE = date("Ymd"); // date("d.m.Y");//'28.11.2016';//

        $this->fce->call();
        $KOSTL_DESC = $this->fce->DESCRIPTION;

        if ($debug) {
        	print_r('KOSTL_DESC<br>');
        	var_dump($KOSTL_DESC);
        	print_r('<br>');
        }
        $this->openFunction('ZCMM_GET_CURRENTBUDGET');
        $this->fce->P_FICTR = $KOSTL;
        $this->fce->P_FIKRS = 'SGG7';

        $this->fce->S_GJAHR->row['SIGN'] = 'I';
        $this->fce->S_GJAHR->row['OPTION'] = 'EQ';
        $this->fce->S_GJAHR->row['LOW'] = date("Y"); //NOW
        $this->fce->S_GJAHR->Append($this->fce->S_GJAHR->row);

        $budget = 0;
        $i = 0;
        $this->fce->call();
        $itTampung = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->T_DATA->Reset();
        	while ($this->fce->T_DATA->Next()) {
        		$itTampung[] = $this->fce->T_DATA->row;
        		$budget+=$itTampung[$i]['WLJHR'];
        		$i++;
        	}
        }
        $budget*=100;
        $budgetCur = $budget;
        if ($debug) {
        	var_dump($itTampung);
        	$this->fce->T_DATA->Reset();
        	while ($this->fce->T_DATA->Next())
        		var_dump($this->fce->T_DATA->row);
        	print_r('budget current' . $budgetCur);
        }
        $this->openFunction('ZCMM_GET_COMMITBUDGET');

        $this->fce->S_FISTL->row['SIGN'] = 'I';
        $this->fce->S_FISTL->row['OPTION'] = 'EQ';
        $this->fce->S_FISTL->row['FISTL_LOW'] = $KOSTL; //NOW
        $this->fce->S_FISTL->Append($this->fce->S_FISTL->row);

        $this->fce->S_FIKRS->row['SIGN'] = 'I';
        $this->fce->S_FIKRS->row['OPTION'] = 'EQ';
        $this->fce->S_FIKRS->row['FIKRS_LOW'] = 'SGG7'; //NOW
        $this->fce->S_FIKRS->Append($this->fce->S_FIKRS->row);

        $this->fce->S_GJAHR->row['SIGN'] = 'I';
        $this->fce->S_GJAHR->row['OPTION'] = 'EQ';
        $this->fce->S_GJAHR->row['LOW'] = date("Y"); //NOW
        $this->fce->S_GJAHR->Append($this->fce->S_GJAHR->row);

        // $this->fce->S_FIPEX->row['SIGN'] = 'I';
        // $this->fce->S_FIPEX->row['OPTION'] = 'EQ';
        // $this->fce->S_FIPEX->row['LOW'] = date("Y");//NOW
        // $this->fce->S_FIPEX->Append($this->fce->S_FIPEX->row);


        $budget = 0;
        $i = 0;
        $this->fce->call();
        $itTampung = array();
        $detailCommit = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->T_DATA->Reset();
        	while ($this->fce->T_DATA->Next()) {
        		$itTampung[] = $this->fce->T_DATA->row;
        		if (strpos($itTampung[$i]['FKBTR'], '-') > 0) {
        			$detail['budget'] = $itTampung[$i]['FKBTR'] * (-1);
        			$budget-=$itTampung[$i]['FKBTR'];
        		} else {
        			$detail['budget'] = $itTampung[$i]['FKBTR'];
        			$budget+=$itTampung[$i]['FKBTR'];
        		}
        		$detail['glItem'] = '00' . $itTampung[$i]['FIPEX'];
        		$detail['comp'] = $itTampung[$i]['BUKRS'];
        		$detail['return'] = '';
        		$detail['glDesc'] = '';
                // $detail['glDesc']=$this-> getGlDesc($itTampung[$i]['BUKRS'], $itTampung[$i]['FIPEX']);
        		$detailCommit[] = $detail;
        		$i++;
        	}
        }
        $budget*=100;
        $budgetCom = $budget;
        if ($debug) {
        	print_r('commit<br>');
        	var_dump($itTampung);
        	print_r('<br>');
        	print_r('budget commit ' . $budgetCom);
        }

        $this->openFunction('ZCMM_GET_ACTUALBUDGET');

        $this->fce->S_FISTL->row['SIGN'] = 'I';
        $this->fce->S_FISTL->row['OPTION'] = 'EQ';
        $this->fce->S_FISTL->row['FISTL_LOW'] = $KOSTL; //NOW
        $this->fce->S_FISTL->Append($this->fce->S_FISTL->row);

        $this->fce->S_FIKRS->row['SIGN'] = 'I';
        $this->fce->S_FIKRS->row['OPTION'] = 'EQ';
        $this->fce->S_FIKRS->row['FIKRS_LOW'] = 'SGG7'; //NOW
        $this->fce->S_FIKRS->Append($this->fce->S_FIKRS->row);

        $this->fce->S_GJAHR->row['SIGN'] = 'I';
        $this->fce->S_GJAHR->row['OPTION'] = 'EQ';
        $this->fce->S_GJAHR->row['LOW'] = date("Y"); //NOW
        $this->fce->S_GJAHR->Append($this->fce->S_GJAHR->row);

        $budget = 0;
        $i = 0;
        $this->fce->call();
        $itTampung = array();
        $detailActual = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->T_DATA->Reset();
        	while ($this->fce->T_DATA->Next()) {
        		$itTampung[] = $this->fce->T_DATA->row;
        		if (strpos($itTampung[$i]['FKBTR'], '-') > 0) {
        			$detail['budget'] = $itTampung[$i]['FKBTR'] * (-1);
        			$budget-=$itTampung[$i]['FKBTR'];
        		} else {
        			$detail['budget'] = $itTampung[$i]['FKBTR'];
        			$budget+=$itTampung[$i]['FKBTR'];
        		}
                $detail['glItem'] = '00' . $itTampung[$i]['FIPEX']; //'0000000000000000'.
                $detail['comp'] = $itTampung[$i]['BUKRS'];
                $detail['return'] = '';
                $detail['glDesc'] = '';
                // $detail['glDesc']=$this-> getGlDesc($itTampung[$i]['BUKRS'], $itTampung[$i]['FIPEX']);
                $detailActual[] = $detail;
                $i++;
            }
        }
        $budget*=100;
        $budgetAct = $budget;
        for ($i = 0; $i < sizeof($detailCommit); $i++) {
        	$this->openFunction('ZBAPI_GL_ACC_GETDETAIL');
        	$this->fce->COMPANYCODE = $detailCommit[$i]['comp'];
        	$this->fce->GLACCT = $detailCommit[$i]['glItem'];
            // $this->fce->LANGUAGE='EN';
        	$this->fce->call();
        	$detailCommit[$i]['budget']*=100;
        	$detailCommit[$i]['return'] = $this->fce->RETURN;
        	;
        	$detailCommit[$i]['glDesc'] = $this->fce->ACCOUNT_DETAIL;
        }
        for ($i = 0; $i < sizeof($detailActual); $i++) {
        	$this->openFunction('ZBAPI_GL_ACC_GETDETAIL');
        	$this->fce->COMPANYCODE = $detailActual[$i]['comp'];
            $this->fce->GLACCT = $detailActual[$i]['glItem']; //'F0000623';//
            // $this->fce->LANGUAGE='EN';
            $this->fce->call();
            $detailActual[$i]['budget']*=100;
            $detailActual[$i]['return'] = $this->fce->RETURN;
            ;
            $detailActual[$i]['glDesc'] = $this->fce->ACCOUNT_DETAIL;
        }
        if ($debug) {
        	print_r('<br>');
        	var_dump($itTampung);
        	print_r('<br>');
        	print_r('budget actual ' . $budgetAct);
        	print_r('<br><br>');
        	print_r('<br>detail commit<br>');
        	var_dump($detailCommit);
        	print_r('<br>detail actual<br>');
        	var_dump($detailActual);
        	print_r('<br>budget Total ' . ($budgetAct + $budgetCom + $budgetCur));
        }

        // $return['T_OUTPUT'] = $itTampung;
        return array('total' => ($budgetAct + $budgetCom + $budgetCur), 'detailCommit' => $detailCommit, 'detailActual' => $detailActual, 'kostl' => $KOSTL, 'kostl_desc' => $KOSTL_DESC, 'actual' => $budgetAct, 'commit' => $budgetCom, 'current' => $budgetCur);
    }

    public function getListContract($R_BUKRSarr, $R_EKORGarr, $DOC) {
    	$this->openFunction('ZCMM_LISTCONTRACT');

    	foreach ($R_BUKRSarr as $val) {
    		$this->fce->R_BUKRS->row['SIGN'] = 'I';
    		$this->fce->R_BUKRS->row['OPTION'] = 'EQ';
    		$this->fce->R_BUKRS->row['LOW'] = $val['TYPE'];
    		$this->fce->R_BUKRS->Append($this->fce->R_BUKRS->row);
    	}
    	foreach ($R_EKORGarr as $val) {
    		$this->fce->R_EKORG->row['SIGN'] = 'I';
    		$this->fce->R_EKORG->row['OPTION'] = 'EQ';
    		$this->fce->R_EKORG->row['LOW'] = $val['TYPE'];
    		$this->fce->R_EKORG->Append($this->fce->R_EKORG->row);
    	}
        // foreach ($DOC as $val) {
        // $this -> fce -> R_DOCTYPE -> row['SIGN'] = 'I';
        // $this -> fce -> R_DOCTYPE -> row['OPTION'] = 'EQ';
        // $this -> fce -> R_DOCTYPE -> row['LOW'] = $val['DOC_TYPE'];
        // $this -> fce -> R_DOCTYPE -> Append($this -> fce -> R_DOCTYPE -> row);
        // }
//
    	$this->fce->call();
    	$i = 0;
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->GI_HEADER->Reset();
    		while ($this->fce->GI_HEADER->Next()) {
    			$itTampung[] = $this->fce->GI_HEADER->row;
    		}
    	}
    	$return['GI_HEADER'] = $itTampung;
        // var_dump($itTampung);
    	return $return;
    }

    public function getPRPricelist($I_DOCTYPE, $debug = false) {
    	$this->openFunction('ZCMM_GET_PR_OPEN');

    	$this->fce->I_SREAL = '05';
    	$this->fce->I_DOCTYPE = $I_DOCTYPE[0]['DOC_TYPE'];
        // foreach ($I_DOCTYPE as $val) {
        // $this -> fce -> I_DOCTYPE -> row['SIGN'] = 'I';
        // $this -> fce -> I_DOCTYPE -> row['OPTION'] = 'EQ';
        // $this -> fce -> I_DOCTYPE -> row['LOW'] = $val['TYPE'];
        // $this -> fce -> I_DOCTYPE -> Append($this -> fce -> I_DOCTYPE -> row);
        // }
    	$this->fce->call();
    	$availabledata = array('PRNO', 'PRITEM', 'DOCTYPE', 'NOMAT', 'PLANT', 'DECMAT', 'QUANTOPEN', 'POQUANTITY', 'PRQUANTITY', 'UOM', 'NETPRICE', 'PER', 'CURR', 'REQUESTIONER', 'NAME_TEXT', 'PGRP', 'MRPC', 'KNTTP', 'STATU');
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->IT_DATA->Reset();
    		while ($this->fce->IT_DATA->Next()) {
    			$hold = $this->fce->IT_DATA->row;
    			$hold = array_intersect_key($hold, array_flip((array) $availabledata));
    			$itTampung[] = $hold;
    		}
    	}
    	if ($debug) {
    		header('Content-Type: application/json');
    		var_dump($itTampung);
    	}
    	return $itTampung;
    }

    public function getInv($bukrs, $gjahr) {
    	$this->openFunction('ZCFIFM_DISPLAY_APPROVE');

    	$this->fce->P_BUKRS = $bukrs;
    	$this->fce->P_GJAHR = $gjahr;
    	$thus->fce->X_GET_PARK_DOC = 'X';
    	$thus->fce->X_GET_CLEAR_DAT = 'X';
    	$this->fce->call();

    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->T_OUT->Reset();
    		while ($this->fce->T_OUT->Next()) {
    			$itTampung[] = $this->fce->T_OUT->row;
    		}
    	}
    	$return['T_OUT'] = $itTampung;

    	return $return;
    }

    public function getInvoice($bukrs = '2000', $gjahr = '2015') {
    	$this->openFunction('ZCFIFM_DISPLAY_APPROVE');

    	$this->fce->P_BUKRS = $bukrs;
    	$this->fce->P_GJAHR = $gjahr;
    	$thus->fce->X_GET_PARK_DOC = 'X';
    	$thus->fce->X_GET_CLEAR_DAT = 'X';
    	$this->fce->call();

    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->T_OUT->Reset();
    		while ($this->fce->T_OUT->Next()) {
    			$itTampung[] = $this->fce->T_OUT->row;
    		}
    	}
    	$return['T_OUT'] = $itTampung;

    	return $return;
    }

    public function getPROpen($data = false, $by = 'plant') {
    	$this->openFunction('ZCMM_GET_PR_OPEN');

    	$this->fce->I_SREAL = '05';
    	$this->fce->I_DEL = '';
    	switch ($by) {
    		case 'pr':
    		$this->fce->S_PR->row['SIGN'] = 'I';
    		$this->fce->S_PR->row['OPTION'] = 'EQ';
    		$this->fce->S_PR->row['LOW'] = $data;
    		$this->fce->S_PR->row['HIGH'] = '';
    		$this->fce->S_PR->Append($this->fce->S_PR->row);
    		echo $data;
    		break;
    		case 'request':
    		$this->fce->S_REQUESTIONER->row['SIGN'] = 'I';
    		$this->fce->S_REQUESTIONER->row['OPTION'] = 'EQ';
    		$this->fce->S_REQUESTIONER->row['LOW'] = $data;
    		$this->fce->S_REQUESTIONER->row['HIGH'] = '';
    		$this->fce->S_REQUESTIONER->Append($this->fce->S_REQUESTIONER->row);
    		break;
    		case 'all':
    		$data = intval(intval($data) / 1000) * 1000;
    		$this->fce->S_PLANT->row['SIGN'] = 'I';
    		$this->fce->S_PLANT->row['OPTION'] = 'BT';
    		$this->fce->S_PLANT->row['LOW'] = $data;
    		$this->fce->S_PLANT->row['HIGH'] = $data + 999;
    		$this->fce->S_PLANT->Append($this->fce->S_PLANT->row);
    		break;
    		case 'mrp':
    		foreach ($data as $val) {
    			$this->fce->S_MRP->row['SIGN'] = 'I';
    			$this->fce->S_MRP->row['OPTION'] = 'EQ';
    			$this->fce->S_MRP->row['LOW'] = $val['mrp'];
    			$this->fce->S_MRP->row['HIGH'] = '';
    			$this->fce->S_MRP->Append($this->fce->S_MRP->row);

    			$this->fce->S_PLANT->row['SIGN'] = 'I';
    			$this->fce->S_PLANT->row['OPTION'] = 'EQ';
    			$this->fce->S_PLANT->row['LOW'] = $val['plant'];
    			$this->fce->S_PLANT->row['HIGH'] = '';
    			$this->fce->S_PLANT->Append($this->fce->S_PLANT->row);
    		}
    		break;
    		case 'plant':
    		if (empty($data)) {
    			$data = 2702;
    		}
    		$this->fce->S_PLANT->row['SIGN'] = 'I';
    		$this->fce->S_PLANT->row['OPTION'] = 'EQ';
    		$this->fce->S_PLANT->row['LOW'] = $data;
    		$this->fce->S_PLANT->row['HIGH'] = '';
    		$this->fce->S_PLANT->Append($this->fce->S_PLANT->row);
    		break;
    	}
    	$return['S_PR'] = $this->fce->S_PR;
    	$return['S_REQUESTIONER'] = $this->fce->S_REQUESTIONER;
    	$return['S_PLANT'] = $this->fce->S_PLANT;
    	$return['S_MRP'] = $this->fce->S_MRP;

    	$this->fce->call();

    	$availabledata = array('PRNO', 'PRITEM', 'DOCTYPE', 'DOC_CAT', 'DEL', 'NOMAT', 'PLANT', 'DECMAT', 'QUANTOPEN', 'POQUANTITY', 'PRQUANTITY', 'HANDQUANTITY', 'RATAGI', 'MAXGI', 'LASTGI', 'UOM', 'REALDATE', 'POSTDATE', 'MAX_GI_YEAR', 'MAX_YEAR_GI', 'NETPRICE', 'PER', 'CURR', 'MATGROUP', 'PORG', 'REQUESTIONER', 'PGRP', 'MRPC', 'DDATE', 'BSMNG', 'PACKNO', 'STATU','CREATED_BY');
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->IT_DATA->Reset();
    		while ($this->fce->IT_DATA->Next()) {
    			$hold = $this->fce->IT_DATA->row;
    			$hold = array_intersect_key($hold, array_flip((array) $availabledata));
    			$itTampung[] = $hold;
    		}
    	}
    	$return['IT_DATA'] = $itTampung;

    	$availableservice = array('PACKNO', 'EXTROW', 'SRVPOS', 'MENGE', 'MEINS', 'SUB_PACKNO', 'MATKL', 'BRTWR', 'NETWR', 'TBTWR', 'KTEXT1');
    	$it_service = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->IT_SERVICE->Reset();
    		while ($this->fce->IT_SERVICE->Next()) {
    			$hold = $this->fce->IT_SERVICE->row;
    			$hold = array_intersect_key($hold, array_flip((array) $availableservice));
    			$it_service[] = $hold;
    		}
    	}
    	$return['IT_SERVICE'] = $it_service;

    	return $return;
    }

    public function getPROpenEtor($data = false, $by = 'plant') {
        $this->openFunction('ZCMM_GET_PR_OPEN');

        $this->fce->I_SREAL = '03';
        $this->fce->I_DEL = '';
        switch ($by) {
            case 'pr':
            $this->fce->S_PR->row['SIGN'] = 'I';
            $this->fce->S_PR->row['OPTION'] = 'EQ';
            $this->fce->S_PR->row['LOW'] = $data;
            $this->fce->S_PR->row['HIGH'] = '';
            $this->fce->S_PR->Append($this->fce->S_PR->row);
            echo $data;
            break;
            case 'request':
            $this->fce->S_REQUESTIONER->row['SIGN'] = 'I';
            $this->fce->S_REQUESTIONER->row['OPTION'] = 'EQ';
            $this->fce->S_REQUESTIONER->row['LOW'] = $data;
            $this->fce->S_REQUESTIONER->row['HIGH'] = '';
            $this->fce->S_REQUESTIONER->Append($this->fce->S_REQUESTIONER->row);
            break;
            case 'all':
            $data = intval(intval($data) / 1000) * 1000;
            $this->fce->S_PLANT->row['SIGN'] = 'I';
            $this->fce->S_PLANT->row['OPTION'] = 'BT';
            $this->fce->S_PLANT->row['LOW'] = $data;
            $this->fce->S_PLANT->row['HIGH'] = $data + 999;
            $this->fce->S_PLANT->Append($this->fce->S_PLANT->row);
            break;
            case 'mrp':
            foreach ($data as $val) {
                $this->fce->S_MRP->row['SIGN'] = 'I';
                $this->fce->S_MRP->row['OPTION'] = 'EQ';
                $this->fce->S_MRP->row['LOW'] = $val['mrp'];
                $this->fce->S_MRP->row['HIGH'] = '';
                $this->fce->S_MRP->Append($this->fce->S_MRP->row);

                $this->fce->S_PLANT->row['SIGN'] = 'I';
                $this->fce->S_PLANT->row['OPTION'] = 'EQ';
                $this->fce->S_PLANT->row['LOW'] = $val['plant'];
                $this->fce->S_PLANT->row['HIGH'] = '';
                $this->fce->S_PLANT->Append($this->fce->S_PLANT->row);
            }
            break;
            case 'plant':
            if (empty($data)) {
                $data = 2702;
            }
            $this->fce->S_PLANT->row['SIGN'] = 'I';
            $this->fce->S_PLANT->row['OPTION'] = 'EQ';
            $this->fce->S_PLANT->row['LOW'] = $data;
            $this->fce->S_PLANT->row['HIGH'] = '';
            $this->fce->S_PLANT->Append($this->fce->S_PLANT->row);
            break;
        }
        $return['S_PR'] = $this->fce->S_PR;
        $return['S_REQUESTIONER'] = $this->fce->S_REQUESTIONER;
        $return['S_PLANT'] = $this->fce->S_PLANT;
        $return['S_MRP'] = $this->fce->S_MRP;

        $this->fce->call();

        $availabledata = array('PRNO', 'PRITEM', 'DOCTYPE', 'DOC_CAT', 'DEL', 'NOMAT', 'PLANT', 'DECMAT', 'QUANTOPEN', 'POQUANTITY', 'PRQUANTITY', 'HANDQUANTITY', 'RATAGI', 'MAXGI', 'LASTGI', 'UOM', 'REALDATE', 'POSTDATE', 'MAX_GI_YEAR', 'MAX_YEAR_GI', 'NETPRICE', 'PER', 'CURR', 'MATGROUP', 'PORG', 'REQUESTIONER', 'PGRP', 'MRPC', 'DDATE', 'BSMNG', 'PACKNO', 'STATU','CREATED_BY','BANPR');
        $itTampung = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
            $this->fce->IT_DATA->Reset();
            while ($this->fce->IT_DATA->Next()) {
                $hold = $this->fce->IT_DATA->row;
                $hold = array_intersect_key($hold, array_flip((array) $availabledata));
                $itTampung[] = $hold;
            }
        }
        $return['IT_DATA'] = $itTampung;

        $availableservice = array('PACKNO', 'EXTROW', 'SRVPOS', 'MENGE', 'MEINS', 'SUB_PACKNO', 'MATKL', 'BRTWR', 'NETWR', 'TBTWR', 'KTEXT1');
        $it_service = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
            $this->fce->IT_SERVICE->Reset();
            while ($this->fce->IT_SERVICE->Next()) {
                $hold = $this->fce->IT_SERVICE->row;
                $hold = array_intersect_key($hold, array_flip((array) $availableservice));
                $it_service[] = $hold;
            }
        }
        $return['IT_SERVICE'] = $it_service;

        return $return;
    }

    public function getMaterial($material, $submaterial) {
    	$this->openFunction('Z_EPROC_GET_MATERIAL');

    	$this->fce->I_MATKL = $material;
    	$this->fce->I_SUBMATKL = $submaterial;
    	$this->fce->call();

    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->T_DATA->Reset();
    		while ($this->fce->T_DATA->Next()) {
    			$itTampung[] = $this->fce->T_DATA->row;
    		}
    	}
    	$return['T_DATA'] = $itTampung;

    	return $return;
    }

    public function getPOEproc($matnr, $bukrs) {
    	$this->openFunction('Z_ZCMM_GET_PO_EPROC');

    	foreach ($matnr as $value) {
    		$this->fce->P_MATNR->row['SIGN'] = 'I';
    		$this->fce->P_MATNR->row['OPTION'] = 'EQ';
    		$this->fce->P_MATNR->row['LOW'] = $value['nomat'];

    		$this->fce->P_MATNR->Append($this->fce->P_MATNR->row);
    	}

    	$this->fce->P_BUKRS = $bukrs;
        //die(var_dump($this->fce));
    	$this->fce->call();

    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->IT_DATA->Reset();
    		while ($this->fce->IT_DATA->Next()) {
    			$itTampung[] = $this->fce->IT_DATA->row;
    		}
    	}
    	$return['IT_DATA'] = $itTampung;

    	return $return;
    }

    public function rejectPr($zbanfn, $tmessage = '') {
    	$this->openFunction('ZCMM_REJECT_PR');

    	$this->fce->ZBANFN = $zbanfn;

    	$enter = explode('\n', $tmessage);
    	$total = array();
    	foreach ($enter as $val) {
    		$total = array_merge($total, str_split($val, 20));
    	}

        // var_dump($total);

    	foreach ($total as $val) {
    		$this->fce->REJECTION_NOTE->row['TDLINE'] = $val;
    		$this->fce->REJECTION_NOTE->Append($this->fce->REJECTION_NOTE->row);
    	}

    	$this->fce->call();
    	return '';
    }

    public function getContractOpen($bstyp = 'K', $procstat = '05') {
    	$this->openFunction('ZCMM_GET_CONTRACT_OPEN');

    	$this->fce->P_BSTYP = $bstyp;
    	$this->fce->P_PROCSTAT = $procstat;

    	$this->fce->call();
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->GI_HEADER->Reset();
    		while ($this->fce->GI_HEADER->Next()) {
    			$itTampung[] = $this->fce->GI_HEADER->row;
    		}
    	}

    	return $itTampung;
    }

    /**
     * @param $matnr material number (100-001-0001)
     * @param $plant kode plant (3406)
     *
     * @return array of
     *    MATNR material number
     *    WERKS plant
     *    GJAHR Fiscal year
     *    GSV01 quantity
     *    MEINS uom
     */
    public function getMatConsumtion($matnr, $plant) {
    	$this->openFunction('ZCMM_EPROC_MAT_CONSUMTION');

    	$this->fce->I_MATNR = $matnr;
    	$this->fce->I_PLANT = $plant;

    	$this->fce->call();
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->T_DATA->Reset();
    		while ($this->fce->T_DATA->Next()) {
    			$itTampung[] = $this->fce->T_DATA->row;
    		}
    	}

    	return $itTampung;
    }

    /**
     * @param array of PR
     * @param array of PR_ITEM (size harus sama
     *         dengan pr)
     * @param array of material group
     * @param string purchasing organization
     *
     * @return array of vendors. example:
     *   EKGRP: ""
     *   EKORG: "SP01"
     *   JP: ""
     *   JU: ""
     *   JUX: ""
     *   LIFNR: "0001200257"
     *   MATKL: "401-402"
     *   NAME1: "PT ADI BANGUN"
     *   SUB_MATKL: ""
     *   ZIU: ""
     */
    public function getVendor($pr, $pritem, $matkl, $ekorg) {
    	$this->openFunction('Z_EPROC_VENDOR_SUBPRATENDER');

    	$this->fce->I_EKORG = $ekorg;
    	$this->fce->I_JP = '';
    	$this->fce->I_ZIU = '';
    	$this->fce->I_JU = '';
    	for ($i = 0; $i < count($pr); $i++) {
    		$this->fce->PR->row['BANFN'] = $pr[$i];
    		$this->fce->PR->row['BNFPO'] = $pritem[$i];
    		$this->fce->PR->Append($this->fce->PR->row);
    	}
    	foreach ($matkl as $val) {
    		$this->fce->MATKL->row['SIGN'] = 'I';
    		$this->fce->MATKL->row['OPTION'] = 'EQ';
    		$this->fce->MATKL->row['LOW'] = $val;
    		$this->fce->MATKL->row['HIGH'] = '';
    		$this->fce->MATKL->Append($this->fce->MATKL->row);
    	}

    	$this->fce->call();
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->T_TAB->Reset();
    		while ($this->fce->T_TAB->Next()) {
    			$itTampung[] = $this->fce->T_TAB->row;
    		}
    	}

    	return $itTampung;
    }

    public function getDirven($company, $matkl){
        $this->openFunction('ZCMM_GET_DIRVEN');

        if ($company == '2000'){
            $ekorg = 'HC01';
        } elseif ($company == '3000'){
            $ekorg = 'SP01';
        } elseif ($company == '4000'){
            $ekorg = 'ST01';
        } elseif ($company == '5000'){
            $ekorg = 'OP01';
        } elseif ($company == '6000'){
            $ekorg = 'TL01';
        } elseif ($company == '7000'){
            $ekorg = 'KS01';
        } else {
            $ekorg = 'HC01';
        }

        $this->fce->T_EKORG->row['SIGN'] = 'I';
        $this->fce->T_EKORG->row['OPTION'] = 'EQ';
        $this->fce->T_EKORG->row['LOW'] = $ekorg;
        $this->fce->T_EKORG->row['HIGH'] = '';
//        $this->fce->T_EKORG->Append($this->fce->T_EKORG->row);

        foreach ($matkl as $item){
            $this->fce->T_MATKL->row['SIGN'] = 'I';
            $this->fce->T_MATKL->row['OPTION'] = 'EQ';
            $this->fce->T_MATKL->row['LOW'] = $item;
            $this->fce->T_MATKL->row['HIGH'] = '';
            $this->fce->T_MATKL->Append($this->fce->T_MATKL->row);
        }

        $this->fce->call();
        $itTampung = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
            $this->fce->IT_DATA->Reset();
            while ($this->fce->IT_DATA->Next()) {
                $itTampung[] = $this->fce->IT_DATA->row;
            }
        }
        $return['IT_DATA'] = $itTampung;

        return $return;
    }

    /**
     * Ndapetin long text, bisa dibuat ngasih tau vendor
     *
     * @param $items array(
     *     banfn nomor PR
     *     bnfpo nomor PR item
     *     matnr kode material
     *   )
     */
    public function getlongtext($items) {
    	$this->openFunction('ZCMM_EPROC_GETLONGTEXT');

    	foreach ($items as $val) {
    		$this->fce->T_INPUT->row['BANFN'] = $val['banfn'];
    		$this->fce->T_INPUT->row['BNFPO'] = $val['bnfpo'];
    		$this->fce->T_INPUT->row['MATNR'] = $val['matnr'];
    		$this->fce->T_INPUT->Append($this->fce->T_INPUT->row);
    	}

    	$this->fce->call();
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->T_DATA->Reset();
    		while ($this->fce->T_DATA->Next()) {
    			$itTampung[] = $this->fce->T_DATA->row;
    		}
    	}

    	return $itTampung;
    }

    public function getitemtext($kode_rfq,$item_rfq) {
    	$this->openFunction('ZREAD_TEXT');

    	$this->fce->ID = 'A01';
    	$this->fce->NAME = $kode_rfq.sprintf("%05d", $item_rfq);
    	$this->fce->OBJECT = 'EKPO';
    	$this->fce->LANGUAGE = 'E';

    	$this->fce->call();
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->T_LINES->Reset();
    		while ($this->fce->T_LINES->Next()) {
    			$itTampung[] = $this->fce->T_LINES->row['TDLINE'];
    		}
    	}

    	return implode('&#10;', $itTampung);
    }

    public function getprheadertext($pr_no) {
    	$this->openFunction('ZREAD_TEXT');

    	$this->fce->ID = 'B01';
    	$this->fce->NAME = $pr_no;
    	$this->fce->OBJECT = 'EBANH';
    	$this->fce->LANGUAGE = 'E';

    	$this->fce->call();
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->T_LINES->Reset();
    		while ($this->fce->T_LINES->Next()) {
    			$itTampung[] = $this->fce->T_LINES->row['TDLINE'];
    		}
    	}

    	return implode('<br/>', $itTampung);
    }

    /**
     * Create subpratender. !
     *
     * @param int|string $matkl nomor material group
     * @param string $desc deskripsi pengadaan
     * @param string nomor justifikasi, dari ptp_justification. liat model ptp
     * @param Array pritem dan pr nya array(['prno', 'pritem'])
     * @param Array isinya ini array(['matkl', 'vendor_no', 'vendor_name'])
     * @param string purchasing organization
     * @param string purchasing group
     */
    public function save_subpratender($matkl, $desc, $just, $pritem, $tab, $ekorg = '', $ekgrp = '', $isbidlist = false) {
    	if ($isbidlist) {
    		$this->openFunction('Z_EPROC_SAVE_BIDDERLIST');
    	} else {
    		$this->openFunction('Z_EPROC_SAVE_SUBPRATENDER');
    	}

    	$this->fce->I_EKORG = empty($ekorg) ? 'KS01' : $ekorg;
    	$this->fce->I_EKGRP = empty($ekgrp) ? 'K01' : $ekgrp;
    	$this->fce->I_MATKL = $matkl;
    	$this->fce->I_DESCR = $desc;
        // $this->fce->I_PRTY = 'M';

    	switch ($just) {
    		case '1': $this->fce->RB_LB = 'X';
    		break;
    		case '5': case '6':
    		case '7': case '8':
    		case '2': $this->fce->RB_TL = 'X';
    		break;
    		case '3': $this->fce->RB_LT = 'X';
    		break;
    		case '4': $this->fce->RB_PL = 'X';
    		break;
    		default: $this->fce->RB_TL = 'X';
    		break;
    	}

    	foreach ($pritem as $value) {
    		$this->fce->T_PR->row['BANFN'] = $value['prno'];
    		$this->fce->T_PR->row['BNFPO'] = $value['pritem'];
    		if ($isbidlist) {
    			$this->fce->T_PR->row['MENGE'] = $value['qty'];
    			$this->fce->T_PR->row['MEINS'] = $value['uom'];
    		}
    		$this->fce->T_PR->Append($this->fce->T_PR->row);
    	}

    	foreach ($tab as $value) {
    		$this->fce->T_TAB->row['EKORG'] = $ekorg;
            // $this->fce->T_TAB->row['EKGRP'] = $ekgrp;
    		$this->fce->T_TAB->row['MATKL'] = empty($value['matkl']) ? $matkl : $value['matkl'];
    		$this->fce->T_TAB->row['LIFNR'] = $value['vendor_no'];
            // $this->fce->T_TAB->row['SUB_MATKL'] = '';
            // $this->fce->T_TAB->row['JU'] = '';
            // $this->fce->T_TAB->row['JP'] = '';
            // $this->fce->T_TAB->row['ZIU'] = '';
    		$this->fce->T_TAB->row['NAME1'] = $value['vendor_name'];
    		$this->fce->T_TAB->Append($this->fce->T_TAB->row);
    	}
    	// echo "<pre>";
    	// print_r($tab);
    	// die;
    	$this->fce->call();
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->T_RETURN->Reset();
    		while ($this->fce->T_RETURN->Next()) {
    			$itTampung[] = $this->fce->T_RETURN->row;
    		}
    	} else {
    		$itTampung = $this->fce->GetStatus();
    	}

    	return $itTampung;
    }

    public function save_bidderlist($matkl, $desc, $just, $pritem, $tab, $ekorg = '', $ekgrp = '') {
    	return $this->save_subpratender($matkl, $desc, $just, $pritem, $tab, $ekorg, $ekgrp, true);
    }

    /**
     * Create RFQ!
     *
     * @param string $bsart RFQ type (misalnya ZSC2)
     * @param string $anfdt RFQ date (dd.mm.yyyy)
     * @param string $angdt Quotation Deadline (dd.mm.yyyy)
     * @param string $eindt Item Delivery Date (dd.mm.yyyy)
     * @param string $ekorg Purch Organization
     * @param string $ekgrp Purch Group
     * @param string $submi Collective Number (nomor pratender bidderlist)
     * @param string $pricedate Item Price Date (dd.mm.yyyy)
     * @param string $termdelivery (misal FRC)
     * @param string $deliverynote (misal GUDANG TUBAN)
     */
    public function getRfq($bsart, $anfdt, $angdt, $eindt, $ekorg, $ekgrp, $submi, $pricedate, $termdelivery, $deliverynote) {
    	$this->openFunction('Z_EPROC_CREATE_RFQ');

    	$this->fce->I_BSART = $bsart;
        $this->fce->I_ANFDT = $anfdt; // ini harus dalam bentuk dd.mm.yyyy
        $this->fce->I_ANGDT = $angdt; // ini harus dalam bentuk dd.mm.yyyy
        $this->fce->I_EINDT = $eindt; // ini harus dalam bentuk dd.mm.yyyy
        $this->fce->I_EKORG = $ekorg;
        $this->fce->I_EKGRP = $ekgrp;
        $this->fce->I_SUBMI = $submi;
        $this->fce->I_PRICEDATE = $pricedate;
        $this->fce->I_INCO1 = $termdelivery;
        $this->fce->I_INCO2 = $deliverynote;

        $this->fce->call();
        $itTampung = array();
        $t_return = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->T_DATA->Reset();
        	while ($this->fce->T_DATA->Next()) {
        		$itTampung[] = $this->fce->T_DATA->row;
        	}
        	$data['O_PRICEDATE'] = $this->fce->O_PRICEDATE;
        	$data['O_ANGDT'] = $this->fce->O_ANGDT;

            // $this->fce->T_RETURN->Reset();
            // while ($this->fce->T_RETURN->Next()) {
            //     $t_return[] = $this->fce->T_RETURN->row;
            // }
        }
        $ereturn = @$this->fce->E_RETURN;
        $data['return'] = $ereturn;
        $data['rfq'] = $itTampung;
        // $data['return_t'] = $t_return;

        return $data;
    }

    /**
     * Assign PR yang ada kontraknya
     *
     * @param string $ebeln
     * @param string $ebelp
     * @param string $banfn
     * @param string $bnfpo
     * @param string $lifnr
     */
    public function assignPrContract($ebeln, $ebelp, $banfn, $bnfpo, $lifnr) {
    	$this->openFunction('ZCMM_EPROC_ASSIGN_K_PURCHASE');

    	$this->fce->T_INPUT['EBELN'] = $ebeln;
    	$this->fce->T_INPUT['EBELP'] = $ebelp;
    	$this->fce->T_INPUT['BANFN'] = $banfn;
    	$this->fce->T_INPUT['BNFPO'] = $bnfpo;
    	$this->fce->T_INPUT['LIFNR'] = $lifnr;
        // var_dump($this->fce); exit();

    	$this->fce->call();
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$itTampung['E_MESSAGESX'] = $this->fce->E_MESSAGESX;
    		$itTampung['E_DESCX'] = $this->fce->E_DESCX;
    	}
    	return $itTampung;
    }

    /**
     * SaveRfqMaintain, yang bagian quotation
     *
     * @param $rfq ptv.rfq
     * @param $validto DATE*** pqm.validthru
     * @param $quodate DATE*** ptp.
     * @param $items array(
     *     @param item_no ptqi
     *     @param delivery_date DATE*** ptp
     *     @param net_price ptqi
     *     @param valid_to DATE*** pqm.validthru
     */
    public function saveRfqMaintain($rfq, $validto, $quodate, $items, $incoterm, $incoterm_text, $price_type, $is_winner = '') {
    	$this->openFunction('Z_ZCMM_RFQ_MAINTAIN');

    	$this->fce->FI_RFQ_NO = $rfq;
    	$this->fce->FI_CURRENCY = 'IDR';
    	$this->fce->FI_QUO_VALIDFROM = date('Ymd');
    	$this->fce->FI_QUO_VALIDTO = $validto;
    	$this->fce->FI_EXCRATE = '1,00000';
    	$this->fce->FI_INCOTERM = $incoterm;
    	$this->fce->FI_INCOTERM_TEXT = $incoterm_text;
    	$this->fce->FI_QUO_DATE = $quodate;
    	$this->fce->FI_REFF = '';
    	$this->fce->FI_QUO_NO = '';
    	foreach ($items as $value) {
    		$this->fce->FT_ITEM_QUO->row['ITEM_NO'] = $value['item_no'];
            // $this->fce->FT_ITEM_QUO->row['ITEM_CODE'] = $itemcode;
    		if (isset($value['srv_line_no'])) {
    			$this->fce->FT_ITEM_QUO->row['SRV_LINE_NO'] = str_pad($value['srv_line_no'], 10, '0', STR_PAD_LEFT);
    		} else {
    			$this->fce->FT_ITEM_QUO->row['SRV_LINE_NO'] = '0000000000';
    		}
    		$this->fce->FT_ITEM_QUO->row['DELIVERY_DATE'] = $value['delivery_date'];
    		$this->fce->FT_ITEM_QUO->row['NET_PRICE'] = $value['net_price'];
    		$this->fce->FT_ITEM_QUO->row['CURRENCY'] = 'IDR';
    		$this->fce->FT_ITEM_QUO->row['VALID_FROM'] = date('Ymd');
    		$this->fce->FT_ITEM_QUO->row['VALID_TO'] = $value['valid_to'];
    		$this->fce->FT_ITEM_QUO->row['PRICE_TYPE'] = $price_type;
    		$this->fce->FT_ITEM_QUO->row['IS_WINNER'] = $is_winner;
    		$this->fce->FT_ITEM_QUO->Append($this->fce->FT_ITEM_QUO->row);
    	}

    	$this->fce->call();
    	$data['FT_RETURN'] = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->FT_RETURN->Reset();
    		while ($this->fce->FT_RETURN->Next()) {
    			$data['FT_RETURN'][] = $this->fce->FT_RETURN->row;
    		}
    		$this->fce->FT_ITEM_QUO->Reset();
    		while ($this->fce->FT_ITEM_QUO->Next()) {
    			$data['FT_ITEM_QUO'][] = $this->fce->FT_ITEM_QUO->row;
    		}
    	}

    	return $data;
    }

    /**
     * Retender
     *
     * @param string $submi : nomer ptm
     */
    public function retenderPaket($submi) {
    	$this->openFunction('Z_ZCMM_DEL_BDLIST_RFQ');
    	$this->fce->P_SUBMI = $submi;
    	$this->fce->call();
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->T_MESSAGE->Reset();
    		while ($this->fce->T_MESSAGE->Next()) {
    			$itTampung['T_MESSAGE'] = $this->fce->T_MESSAGE->row;
    		}
    	}
    	return $itTampung;
    }

    public function retenderItemize($items) {
    	$this->openFunction('Z_EPRO_RETENDER_ITEMIZE');


    	foreach ($items as $value) {
    		$this->fce->T_INPUT->row['BANFN'] = $value['PPI_PRNO'];
    		$this->fce->T_INPUT->row['BNFPO'] = $value['PPI_PRITEM'];
    		$this->fce->T_INPUT->Append($this->fce->T_INPUT->row);
    	}
        // var_dump($this->fce); exit();
    	$this->fce->call();
    	$data['FT_RETURN'] = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->FT_RETURN->Reset();
    		while ($this->fce->FT_RETURN->Next()) {
    			$data['FT_RETURN'][] = $this->fce->FT_RETURN->row;
    		}
    	}
    	return $data;
    }

    /*
     * update rfq quotation deadline
     * parameter:
     * $rfq : nomor rfq
     * $quodeadline : tanggal deadline penawaran harga
     */

    public function updateRfqQuodeadline($rfq, $quodeadline) {
    	$this->openFunction('Z_ZCMM_RFQ_UPDATE_QUODEADLINE');

    	$this->fce->FI_RFQ_NO = $rfq;
    	$this->fce->FI_QUODEADLINE = $quodeadline;

    	$this->fce->call();
    	$data['FT_RETURN'] = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->FT_RETURN->Reset();
    		while ($this->fce->FT_RETURN->Next()) {
    			$data['FT_RETURN'][] = $this->fce->FT_RETURN->row;
    		}
    	}

    	return $data;
    }

    /**
     * Create PO!
     *
     * @param $poheader array
     *     @param doc_type
     *     @param purch_org
     *     @param pur_group
     * @param $poitem array
     *     @param po_item
     *     @param preq_no
     *     @param preq_item
     */
    public function createpo($poheader, $poitem) {
    	$this->openFunction('ZBAPI_PO_CREATE1');

    	foreach ($poheader as $value) {
    		$this->fce->POHEADER['DOC_TYPE'] = $value['doc_type'];
    		$this->fce->POHEADER['PURCH_ORG'] = $value['purch_org'];
    		$this->fce->POHEADER['PUR_GROUP'] = $value['pur_group'];

    		$this->fce->POHEADERX['DOC_TYPE'] = 'X';
    		$this->fce->POHEADERX['PURCH_ORG'] = 'X';
    		$this->fce->POHEADERX['PUR_GROUP'] = 'X';
    	}

    	foreach ($poitem as $value) {
    		$this->fce->POITEM['PO_ITEM'] = $value['po_item'];
    		$this->fce->POITEM['PREQ_NO'] = $value['preq_no'];
    		$this->fce->POITEM['PREQ_ITEM'] = $value['preq_item'];

    		$this->fce->POITEMX['PO_ITEM'] = $value['po_item'];
    		$this->fce->POITEMX['PO_ITEMX'] = 'X';
    		$this->fce->POITEMX['PREQ_NO'] = 'X';
    		$this->fce->POITEMX['PREQ_ITEM'] = 'X';
    	}

    	$this->fce->call();
    	$data['RETURN'] = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->RETURN->Reset();
    		while ($this->fce->RETURN->Next()) {
    			$data['RETURN'][] = $this->fce->RETURN->row;
    		}
    		$this->fce->FT_ITEM_QUO->Reset();
    		while ($this->fce->FT_ITEM_QUO->Next()) {
    			$data['FT_ITEM_QUO'][] = $this->fce->FT_ITEM_QUO->row;
    		}
    	}

    	return $data;
    }

    /**
     * Create PO!
     *
     * @param $poheader array
     *     @param doc_type
     *     @param purch_org
     *     @param pur_group
     * @param $poitem array
     *     @param po_item
     *     @param rfq_no
     *     @param rfq_item
     */
    public function createporfq($poheader, $poitem) {
    	$this->openFunction('ZBAPI_PO_CREATE1');

        // foreach ($poheader as $value) {
    	$this->fce->POHEADER['DOC_TYPE'] = $poheader['doc_type'];
    	$this->fce->POHEADER['PO_REL_IND'] = 'B';
        // $this->fce->POHEADER['PUR_GROUP'] = $poheader['pur_group'];

    	$this->fce->POHEADERX['DOC_TYPE'] = 'X';
    	$this->fce->POHEADERX['PO_REL_IND'] = 'X';
        // $this->fce->POHEADERX['PUR_GROUP'] = 'X';
        // }

    	foreach ($poitem as $value) {
    		$this->fce->POITEM->row['PO_ITEM'] = $value['po_item'];
    		$this->fce->POITEM->row['RFQ_NO'] = $value['rfq_no'];
    		$this->fce->POITEM->row['RFQ_ITEM'] = $value['rfq_item'];
    		$this->fce->POITEM->Append($this->fce->POITEM->row);

    		$this->fce->POITEMX->row['PO_ITEM'] = $value['po_item'];
    		$this->fce->POITEMX->row['PO_ITEMX'] = 'X';
    		$this->fce->POITEMX->row['RFQ_NO'] = 'X';
    		$this->fce->POITEMX->row['RFQ_ITEM'] = 'X';
    		$this->fce->POITEMX->Append($this->fce->POITEMX->row);
            // ada itemtext
            //jika item ada isisnya maka
            //POTEXTITEM -> PO_ITEM,TEXT_ID(F01)
            //TEXT_FORM(*)
            //TEXT_LINE(ARRAY DARI ITEM TEXT DARI TABEL EPROC)
    		if ($value['item_text']) {
    			$data_item = str_replace("\n",'<br/>',$value['item_text']);
    			$new = explode('&#10;', $data_item);
    			foreach ($new as $key => $item_text) {
    				$this->fce->POTEXTITEM->row['PO_ITEM'] = $value['po_item'];
    				$this->fce->POTEXTITEM->row['TEXT_ID'] = 'F01';
    				$this->fce->POTEXTITEM->row['TEXT_FORM'] = '*';
    				$this->fce->POTEXTITEM->row['TEXT_LINE'] = $item_text;
    				$this->fce->POTEXTITEM->Append($this->fce->POTEXTITEM->row);
    			}
    		}
    	}

    	$this->fce->call();
    	$data['RETURN'] = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->RETURN->Reset();
    		while ($this->fce->RETURN->Next()) {
    			$data['RETURN'][] = $this->fce->RETURN->row;
    		}
            // $this->fce->FT_ITEM_QUO->Reset();
            // while ($this->fce->FT_ITEM_QUO->Next() ){
            // 	$data['FT_ITEM_QUO'][] = $this->fce->FT_ITEM_QUO->row;
            // }
    	}

    	return $data;
    }

    public function create_po_contract($poheader, $poitem) {
    	$this->openFunction('ZBAPI_PO_CREATE1');
        // foreach ($poheader as $value) {
    	$this->fce->POHEADER['DOC_TYPE'] = $poheader['doc_type'];
    	$this->fce->POHEADER['PO_REL_IND'] = 'B';
    	$this->fce->POHEADER['PUR_GROUP'] = $poheader['pur_group'];
    	$this->fce->POHEADER['PURCH_ORG'] = $poheader['purch_org'];

    	$this->fce->POHEADERX['DOC_TYPE'] = 'X';
    	$this->fce->POHEADERX['PO_REL_IND'] = 'X';
    	$this->fce->POHEADERX['PUR_GROUP'] = 'X';
    	$this->fce->POHEADERX['PURCH_ORG'] = 'X';
        // }
        //DOC_TYPE

    	foreach ($poitem as $value) {
    		$this->fce->POITEM->row['PO_ITEM'] = $value['po_item'];
    		$this->fce->POITEM->row['PREQ_NO'] = $value['pr'];
    		$this->fce->POITEM->row['PREQ_ITEM'] = $value['item_pr'];
    		$this->fce->POITEM->Append($this->fce->POITEM->row);

    		$this->fce->POITEMX->row['PO_ITEM'] = $value['po_item'];
    		$this->fce->POITEMX->row['PO_ITEMX'] = 'X';
    		$this->fce->POITEMX->row['PREQ_NO'] = 'X';
    		$this->fce->POITEMX->row['PREQ_ITEM'] = 'X';
    		$this->fce->POITEMX->Append($this->fce->POITEMX->row);
    	}
        //print_r($this->fce);exit;
    	$this->fce->call();
    	$data['RETURN'] = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->RETURN->Reset();
    		while ($this->fce->RETURN->Next()) {
    			$data['RETURN'][] = $this->fce->RETURN->row;
    		}
    	}
        //	echo 'testing return';
    	return $data;
    }

    public function approve_po($po_no, $rel_code) {
    	$this->openFunction('BAPI_PO_RELEASE');

    	$this->fce->PURCHASEORDER = $po_no;
    	$this->fce->PO_REL_CODE = $rel_code;
    	$this->fce->USE_EXCEPTIONS = 'X';

    	$this->fce->call();
    	$retval = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->RETURN->Reset();
    		$retval['REL_INDICATOR_NEW'] = $this->fce->REL_INDICATOR_NEW;
    		while ($this->fce->RETURN->Next()) {
    			$retval[] = $this->fce->RETURN->row;
    		}
    	} else {
    		$retval[] = $this->fce->GetStatus();
    		$retval[] = $this->fce->GetStatusText();
    		$retval[] = $this->fce->getStatusTextLong();
            // echo 'not okay';
    	}

    	return $retval;
    }

    public function createVendor($data_vendor) {
    	$this->openFunction('Z_EPROC_CREATE_VENDOR');

        $data_vendor['SPRAS'] = 'EN'; //Language Key (default EN)
        $data_vendor['ZUAWA'] = '001'; //Key for sorting according to assignment numbers (DEFAULT 001)
        $data_vendor['ZWELS'] = 'CET'; //List of the Payment Methods to be Considered (coba CET)
        $data_vendor['REPRF'] = 'X'; //Check Flag for Double Invoices or Credit Memos (pakai X)
        $data_vendor['WEBRE'] = 'X'; //Indicator: GR-Based Invoice Verification
        $data_vendor['LEBRE'] = 'X'; //Indicator for Service-Based Invoice Verification
        // $data_vendor['WITHT(01)'] = NULL;
        // $data_vendor['WITHT(02)'] = NULL;
        // $data_vendor['WITHT(03)'] = NULL;
        // $data_vendor['WITHT(04)'] = NULL;
        // $data_vendor['WT_SUBJCT(01)'] = NULL;
        // $data_vendor['WT_SUBJCT(02)'] = NULL;
        // $data_vendor['WT_SUBJCT(03)'] = NULL;
        // $data_vendor['WT_SUBJCT(04)'] = NULL;

        $this->fce->T_INPUT['BUKRS'] = $data_vendor['BUKRS'];
        $this->fce->T_INPUT['EKORG'] = $data_vendor['EKORG'];
        $this->fce->T_INPUT['KTOKK'] = $data_vendor['KTOKK'];
        $this->fce->T_INPUT['ANRED'] = $data_vendor['ANRED'];
        $this->fce->T_INPUT['NAME1'] = $data_vendor['NAME1'];
        $this->fce->T_INPUT['STRAS'] = $data_vendor['STRAS'];
        $this->fce->T_INPUT['ORT01'] = $data_vendor['ORT01'];
        $this->fce->T_INPUT['PSTLZ'] = $data_vendor['PSTLZ'];
        $this->fce->T_INPUT['PFORT'] = $data_vendor['PFORT'];
        $this->fce->T_INPUT['LAND1'] = $data_vendor['LAND1'];
        $this->fce->T_INPUT['SPRAS'] = $data_vendor['SPRAS'];
        $this->fce->T_INPUT['TELF1'] = $data_vendor['TELF1'];
        $this->fce->T_INPUT['STCD1'] = $data_vendor['STCD1'];
        $this->fce->T_INPUT['STCEG'] = $data_vendor['STCEG'];
        $this->fce->T_INPUT['BANKS'] = $data_vendor['BANKS'];
        $this->fce->T_INPUT['BANKL'] = $data_vendor['BANKL'];
        $this->fce->T_INPUT['BANKN'] = $data_vendor['BANKN'];
        $this->fce->T_INPUT['KOINH'] = $data_vendor['KOINH'];
        $this->fce->T_INPUT['BVTYP'] = $data_vendor['BVTYP'];
        $this->fce->T_INPUT['AKONT'] = $data_vendor['AKONT'];
        $this->fce->T_INPUT['ZUAWA'] = $data_vendor['ZUAWA'];
        $this->fce->T_INPUT['ZTERM'] = $data_vendor['ZTERM'];
        $this->fce->T_INPUT['REPRF'] = $data_vendor['REPRF'];
        $this->fce->T_INPUT['ZWELS'] = $data_vendor['ZWELS'];
        $this->fce->T_INPUT['QLAND'] = $data_vendor['QLAND'];
        // $this->fce->T_INPUT['WITHT(01)'] = $data_vendor['WITHT(01)'];
        // $this->fce->T_INPUT['WITHT(02)'] = $data_vendor['WITHT(02)'];
        // $this->fce->T_INPUT['WITHT(03)'] = $data_vendor['WITHT(03)'];
        // $this->fce->T_INPUT['WITHT(04)'] = $data_vendor['WITHT(04)'];
        // $this->fce->T_INPUT['WT_SUBJCT(01)'] = $data_vendor['WT_SUBJCT(01)'];
        // $this->fce->T_INPUT['WT_SUBJCT(02)'] = $data_vendor['WT_SUBJCT(02)'];
        // $this->fce->T_INPUT['WT_SUBJCT(03)'] = $data_vendor['WT_SUBJCT(03)'];
        // $this->fce->T_INPUT['WT_SUBJCT(04)'] = $data_vendor['WT_SUBJCT(04)'];
        $this->fce->T_INPUT['WAERS'] = $data_vendor['WAERS'];
        $this->fce->T_INPUT['WEBRE'] = $data_vendor['WEBRE'];
        $this->fce->T_INPUT['LEBRE'] = $data_vendor['LEBRE'];

        // Tambahan kondisi waktu UAT Tonasa
        $this->fce->T_INPUT['TELF2'] = $data_vendor['TELF2'];
        $this->fce->T_INPUT['TELFX'] = $data_vendor['TELFX'];
        $this->fce->T_INPUT['SMTP_ADDR'] = $data_vendor['SMTP_ADDR'];

        $this->fce->call();
        $retval = array();
        $retval['T_INPUT'] = $this->fce->T_INPUT;
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$retval['E_MESSAGESX'] = $this->fce->E_MESSAGESX;
        	$retval['E_DESCX'] = $this->fce->E_DESCX;
        	$this->fce->MESSTAB->Reset();
        	while ($this->fce->MESSTAB->Next()) {
        		$retval['MESSTAB'][] = $this->fce->MESSTAB->row;
        	}
        }
        return $retval;
    }

    public function updateVendor($data_vendor) {
        // echo "ini sap handler";
        // echo "<pre>";print_r($data_vendor);die;
    	$this->openFunction('Z_ZCMM_VENDOR_CHANGE');

        $data_vendor['SPRAS'] = 'EN'; //Language Key (default EN)
        $data_vendor['ZUAWA'] = '001'; //Key for sorting according to assignment numbers (DEFAULT 001)
        $data_vendor['ZWELS'] = 'CET'; //List of the Payment Methods to be Considered (coba CET)
        $data_vendor['REPRF'] = 'X'; //Check Flag for Double Invoices or Credit Memos (pakai X)
        $data_vendor['WEBRE'] = 'X'; //Indicator: GR-Based Invoice Verification
        $data_vendor['LEBRE'] = 'X'; //Indicator for Service-Based Invoice Verification
        // $data_vendor['WITHT(01)'] = NULL;
        // $data_vendor['WITHT(02)'] = NULL;
        // $data_vendor['WITHT(03)'] = NULL;
        // $data_vendor['WITHT(04)'] = NULL;
        // $data_vendor['WT_SUBJCT(01)'] = NULL;
        // $data_vendor['WT_SUBJCT(02)'] = NULL;
        // $data_vendor['WT_SUBJCT(03)'] = NULL;
        // $data_vendor['WT_SUBJCT(04)'] = NULL;

        $this->fce->T_INPUT['BUKRS'] = $data_vendor['BUKRS'];
        $this->fce->T_INPUT['EKORG'] = $data_vendor['EKORG'];
        $this->fce->T_INPUT['KTOKK'] = $data_vendor['KTOKK'];
        $this->fce->T_INPUT['ANRED'] = $data_vendor['ANRED'];
        $this->fce->T_INPUT['NAME1'] = $data_vendor['NAME1'];
        $this->fce->T_INPUT['STRAS'] = $data_vendor['STRAS'];
        $this->fce->T_INPUT['ORT01'] = $data_vendor['ORT01'];
        $this->fce->T_INPUT['PSTLZ'] = $data_vendor['PSTLZ'];
        $this->fce->T_INPUT['PFORT'] = $data_vendor['PFORT'];
        $this->fce->T_INPUT['LAND1'] = $data_vendor['LAND1'];
        $this->fce->T_INPUT['SPRAS'] = $data_vendor['SPRAS'];
        $this->fce->T_INPUT['TELF1'] = $data_vendor['TELF1'];
        $this->fce->T_INPUT['STCD1'] = $data_vendor['STCD1'];
        $this->fce->T_INPUT['STCEG'] = $data_vendor['STCEG'];
        $this->fce->T_INPUT['BANKS'] = $data_vendor['BANKS'];
        $this->fce->T_INPUT['BANKL'] = $data_vendor['BANKL'];
        $this->fce->T_INPUT['BANKN'] = $data_vendor['BANKN'];
        $this->fce->T_INPUT['KOINH'] = $data_vendor['KOINH'];
        $this->fce->T_INPUT['BVTYP'] = $data_vendor['BVTYP'];
        $this->fce->T_INPUT['AKONT'] = $data_vendor['AKONT'];
        $this->fce->T_INPUT['ZUAWA'] = $data_vendor['ZUAWA'];
        $this->fce->T_INPUT['ZTERM'] = $data_vendor['ZTERM'];
        $this->fce->T_INPUT['REPRF'] = $data_vendor['REPRF'];
        $this->fce->T_INPUT['ZWELS'] = $data_vendor['ZWELS'];
        $this->fce->T_INPUT['QLAND'] = $data_vendor['QLAND'];
        // $this->fce->T_INPUT['WITHT(01)'] = $data_vendor['WITHT(01)'];
        // $this->fce->T_INPUT['WITHT(02)'] = $data_vendor['WITHT(02)'];
        // $this->fce->T_INPUT['WITHT(03)'] = $data_vendor['WITHT(03)'];
        // $this->fce->T_INPUT['WITHT(04)'] = $data_vendor['WITHT(04)'];
        // $this->fce->T_INPUT['WT_SUBJCT(01)'] = $data_vendor['WT_SUBJCT(01)'];
        // $this->fce->T_INPUT['WT_SUBJCT(02)'] = $data_vendor['WT_SUBJCT(02)'];
        // $this->fce->T_INPUT['WT_SUBJCT(03)'] = $data_vendor['WT_SUBJCT(03)'];
        // $this->fce->T_INPUT['WT_SUBJCT(04)'] = $data_vendor['WT_SUBJCT(04)'];
        $this->fce->T_INPUT['WAERS'] = $data_vendor['WAERS'];
        $this->fce->T_INPUT['WEBRE'] = $data_vendor['WEBRE'];
        $this->fce->T_INPUT['LEBRE'] = $data_vendor['LEBRE'];

        // Tambahan kondisi waktu UAT Tonasa
        $this->fce->T_INPUT['TELF2'] = $data_vendor['TELF2'];
        $this->fce->T_INPUT['TELFX'] = $data_vendor['TELFX'];
        $this->fce->T_INPUT['SMTP_ADDR'] = $data_vendor['SMTP_ADDR'];

        $this->fce->call();
        $retval = array();
        $retval['T_INPUT'] = $this->fce->T_INPUT;
        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$retval['E_MESSAGESX'] = $this->fce->E_MESSAGESX;
        	$retval['E_DESCX'] = $this->fce->E_DESCX;
        	$this->fce->MESSTAB->Reset();
        	while ($this->fce->MESSTAB->Next()) {
        		$retval['MESSTAB'][] = $this->fce->MESSTAB->row;
        	}
        }
        return $retval;
    }

    public function get_po_approval($relcode, $relgroup) {
    	$retval['PO_HEADER'] = array();
    	$retval['PO_ITEM'] = array();
    	if (is_array($relgroup)) {
    		foreach ($relgroup as $valgroup) {
    			if (is_array($relcode)) {
    				foreach ($relcode as $val) {
    					$subretval = $this->get_po_approval($val, $valgroup);
    					if (isset($subretval['PO_HEADER']) && !empty($subretval['PO_HEADER'])) {
    						$retval['PO_HEADER'] = array_merge($retval['PO_HEADER'], $subretval['PO_HEADER']);
    					}
    					if (isset($subretval['PO_ITEM']) && !empty($subretval['PO_ITEM'])) {
    						$retval['PO_ITEM'] = array_merge($retval['PO_ITEM'], $subretval['PO_ITEM']);
    					}
    				}
    				return $retval;
    			}
    		}
    	}


    	$this->openFunction('ZCMM_LIST_APPROVAL_PO');

    	$this->fce->I_REL_GROUP = $relgroup;
    	$this->fce->I_REL_CODE = $relcode;
    	$this->fce->I_ITEMS_FOR_RELEASE = 'X';

    	$this->fce->call();
    	$retval = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$retval['RETURN'] = $this->fce->RETURN;

    		$this->fce->PO_HEADER->Reset();
    		while ($this->fce->PO_HEADER->Next()) {
    			$temp = $this->fce->PO_HEADER->row;
    			$temp['REL_CODE'] = $relcode;
    			$retval['PO_HEADER'][] = $temp;
    		}

    		$this->fce->PO_ITEM->Reset();
    		while ($this->fce->PO_ITEM->Next()) {
    			$retval['PO_ITEM'][] = $this->fce->PO_ITEM->row;
    		}
    	}
    	return $retval;
    }

    public function getGRFilter($jenisPo, $hari = 0, $tahun = FALSE, $debug = false) {
    	$this->openFunction('Z_ZCMM_EKBE');
    	$this->fce->FI_VGABE = $jenisPo;
    	if ($tahun) {
    		$this->fce->FI_GJAHR = date('Y');
    	}

    	$this->fce->FI_CPUDT_FROM = date("Ymd", strtotime("-" . $hari . " day", strtotime(date('Y-m-d'))));
    	$this->fce->FI_CPUDT_TO = date('Ymd');

    	$this->fce->call();
    	$availabledata = array('EBELN', 'EBELP', 'GJAHR', 'BELNR', 'BUZEI', 'BWART', 'MENGE', 'DMBTR', 'WRBTR', 'WAERS', 'SHKZG', 'ELIKZ', 'XBLNR', 'LFGJA', 'LFBNR', 'LFPOS', 'MATNR', 'WERKS', 'BLDAT', 'BUDAT', 'CPUDT', 'CPUTM', 'ERNAM');
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->FT_DATA->Reset();
    		while ($this->fce->FT_DATA->Next()) {
    			$hold = $this->fce->FT_DATA->row;
    			$hold = array_intersect_key($hold, array_flip((array) $availabledata));
    			$itTampung[] = $hold;
    		}
    	}
    	if ($debug) {
    		header('Content-Type: application/json');
            // var_dump( $this->fce->FT_DATA->row);
    		var_dump($itTampung);
    	}

    	return $itTampung;
    }

    public function getALLGR($op,$low,$high, $debug = false) {
    	$this->openFunction('ZCFI_PO_HISTORY');
/*
        $this->fce->R_EBELN->row['SIGN'] = 'I';
        $this->fce->R_EBELN->row['OPTION'] = 'EQ';
        $this->fce->R_EBELN->row['LOW'] = '6610000061';
        // $this->fce->R_EBELN->row['HIGH'] = $high;
        $this->fce->R_EBELN->Append($this->fce->R_EBELN->row);
*/
        $this->fce->R_CPUDT->row['SIGN'] = 'I';
        $this->fce->R_CPUDT->row['OPTION'] = $op;
        $this->fce->R_CPUDT->row['LOW'] = $low;
        $this->fce->R_CPUDT->row['HIGH'] = $high;
        $this->fce->R_CPUDT->Append($this->fce->R_CPUDT->row);
        $jenisOP = array(1,2,3,4,5,7,9,'A','C','Q','R','P','V');
        foreach($jenisOP as $p){
        	$this->fce->R_VGABE->row['SIGN'] = 'I';
        	$this->fce->R_VGABE->row['OPTION'] = 'EQ';
        	$this->fce->R_VGABE->row['LOW'] = $p;
        	$this->fce->R_VGABE->Append($this->fce->R_VGABE->row);
        }


        $this->fce->call();
        $i = 0;
        $itTampung = array();

        if ($this->fce->GetStatus() == SAPRFC_OK) {
        	$this->fce->T_DATA->Reset();
        	while ($this->fce->T_DATA->Next()) {
        //        print_r($this->fce->T_DATA->row);
        		$itTampung[] = $this->fce->T_DATA->row;
        	}
        }
        // var_dump($itTampung);
        return $itTampung;
    }

    public function getListBankVendor($noVendor) {
    	$this->openFunction('Z_ZCMM_VENDOR_DETAIL');
    	$this->fce->FI_VENDOR_NO = $noVendor;
    	$this->fce->call();
    	$i = 0;
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->FT_VENDOR_BANK->Reset();
    		while ($this->fce->FT_VENDOR_BANK->Next()) {
              //  print_r($this->fce->T_DATA->row);
    			$itTampung[] = $this->fce->FT_VENDOR_BANK->row;
    		}
    	}
    	return $itTampung;
    }

    public function getAccountingInvoice($invoicepark,$tahun){
    	$this->openFunction('BAPI_ACC_DOCUMENT_RECORD');
    	$this->fce->OBJ_TYPE = 'RMRP';
    	$this->fce->OBJ_KEY = $invoicepark.$tahun;
    	$this->fce->call();
    	$i = 0;
    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->RECEIVER->Reset();
    		while ($this->fce->RECEIVER->Next()) {
            //  print_r($this->fce->T_DATA->row);
    			$itTampung[] = $this->fce->RECEIVER->row;
    		}
    	}
    	return $itTampung;
    }

    public function kirimDokumenEkspedisi($header,$item){
    	$this->openFunction('ZCFI_DOC_EXPEDITION');
    	$this->fce->P_EXPDS_TYPE = 	1;
    	$this->fce->T_EXPDS_HEADER->row['BUKRS'] = $header['company'];
    	$this->fce->T_EXPDS_HEADER->row['GJAHR'] = date('Y');
    	$this->fce->T_EXPDS_HEADER->row['STATUS'] = 2;
    	$this->fce->T_EXPDS_HEADER->row['CPUDT'] = date('Ymd');
    	$this->fce->T_EXPDS_HEADER->row['USNAM'] = $header['vendor'];
    	$this->fce->T_EXPDS_HEADER->Append($this->fce->T_EXPDS_HEADER->row);

    	foreach($item as $_t){
    		$this->fce->T_EXPDS_ITEM->row['BUKRS'] = $header['company'];
    		$this->fce->T_EXPDS_ITEM->row['GJAHR'] = date('Y');
    		$this->fce->T_EXPDS_ITEM->row['BELNR'] = $_t['invoice'];
    		$this->fce->T_EXPDS_ITEM->row['CPUDT'] = date('Ymd');
      	$this->fce->T_EXPDS_ITEM->row['BUDAT'] = $header['posting_date']; // posting date
      	$this->fce->T_EXPDS_ITEM->row['BLDAT'] = $header['invoice_date']; // invoice date
      	$this->fce->T_EXPDS_ITEM->row['WAERS'] = $_t['currency'];
      	$this->fce->T_EXPDS_ITEM->row['USNAM'] = $header['vendor'];
      	$this->fce->T_EXPDS_ITEM->row['WRBTR'] = $_t['amount'];
      	$this->fce->T_EXPDS_ITEM->row['ZLSPR'] = $_t['payment_block'];
      	$this->fce->T_EXPDS_ITEM->row['DMBTR'] = $_t['amount'];
      	$this->fce->T_EXPDS_ITEM->row['EBELN'] = $_t['po'];
      	$this->fce->T_EXPDS_ITEM->row['EBELP'] = $_t['item_po'];
      	$this->fce->T_EXPDS_ITEM->Append($this->fce->T_EXPDS_ITEM->row);
      }

      $this->fce->call();
      $itTampung = array();
      if ($this->fce->GetStatus() == SAPRFC_OK) {
      	$this->fce->T_RETURN->Reset();
      	while ($this->fce->T_RETURN->Next()) {
          //  print_r($this->fce->T_DATA->row);
      		$itTampung[] = $this->fce->T_RETURN->row;
      	}

      }
      $this->openFunction('BAPI_TRANSACTION_COMMIT');
      $this->fce->call();
      return $itTampung;
  }
  public function verifikasiTerimaDokumenSAP($header){
  	$this->openFunction('ZCFI_DOC_EXPEDITION');
  	$this->fce->P_EXPDS_TYPE = 	2;
  	$this->fce->T_UPDATE_EXPDS->row['BUKRS'] = $header['company'];
  	$this->fce->T_UPDATE_EXPDS->row['NO_EKSPEDISI'] = $header['no_ekspedisi'];
  	$this->fce->T_UPDATE_EXPDS->row['GJAHR'] = $header['tahun'];
  	$this->fce->T_UPDATE_EXPDS->row['BELNR'] = $header['accounting_invoice'];
  	$this->fce->T_UPDATE_EXPDS->row['TGL_VER'] = date('Ymd');
  	$this->fce->T_UPDATE_EXPDS->row['USER_VER'] = substr($header['username'],0,10);
  	$this->fce->T_UPDATE_EXPDS->Append($this->fce->T_UPDATE_EXPDS->row);

  	$this->fce->call();
  	$itTampung = array();
  	if ($this->fce->GetStatus() == SAPRFC_OK) {
  		$this->fce->T_RETURN->Reset();
  		while ($this->fce->T_RETURN->Next()) {
          //  print_r($this->fce->T_DATA->row);
  			$itTampung[] = $this->fce->T_RETURN->row;
  		}
  	}
  	$this->openFunction('BAPI_TRANSACTION_COMMIT');
  	$this->fce->call();
  	return $itTampung;
  }

  public function verifikasiRejectDokumenSAP($header){
  	$this->openFunction('ZCFI_DOC_EXPEDITION');
  	$this->fce->P_EXPDS_TYPE = 	3;
  	$this->fce->T_UPDATE_EXPDS->row['BUKRS'] = $header['company'];
  	$this->fce->T_UPDATE_EXPDS->row['NO_EKSPEDISI'] = $header['no_ekspedisi'];
  	$this->fce->T_UPDATE_EXPDS->row['GJAHR'] = $header['tahun'];
  	$this->fce->T_UPDATE_EXPDS->row['BELNR'] = $header['accounting_invoice'];
  	$this->fce->T_UPDATE_EXPDS->row['TGL_KEMB_VER'] = date('Ymd');
  	$this->fce->T_UPDATE_EXPDS->row['USER_VER'] = substr($header['username'],0,10);
  	$this->fce->T_UPDATE_EXPDS->Append($this->fce->T_UPDATE_EXPDS->row);

  	$this->fce->call();
  	$itTampung = array();
  	if ($this->fce->GetStatus() == SAPRFC_OK) {
  		$this->fce->T_RETURN->Reset();
  		while ($this->fce->T_RETURN->Next()) {
          //  print_r($this->fce->T_DATA->row);
  			$itTampung[] = $this->fce->T_RETURN->row;
  		}
  	}
  	$this->openFunction('BAPI_TRANSACTION_COMMIT');
  	$this->fce->call();
  	return $itTampung;
  }

    /*Z_ZCMM_VENDOR_WITHTAXTYPE = ambil jenis pajak
      Z_ZCMM_VENDOR_WITHOLDINGTAX = ambil list detail pajaknya
    */
      public function getListTaxVendor($noVendor,$company) {
      	$this->openFunction('Z_ZCMM_VENDOR_WITHTAXTYPE');
      	$this->fce->FI_LIFNR = $noVendor;
      	$this->fce->FI_BUKRS = $company;
      	$this->fce->call();
      	$i = 0;
      	$itTampung = array();
      	if ($this->fce->GetStatus() == SAPRFC_OK) {
      		$this->fce->FT_WITH_TAX->Reset();
      		while ($this->fce->FT_WITH_TAX->Next()) {
      			$itTampung[] = $this->fce->FT_WITH_TAX->row;
      		}
      	}
      	return $itTampung;
      }

      public function getVendorWitholdingTax($witht) {
      	$this->openFunction('Z_ZCMM_VENDOR_WITHOLDINGTAX');
      	$this->fce->FI_WITHT = $witht;
      	$this->fce->call();
      	$i = 0;
      	$itTampung = array();
      	if ($this->fce->GetStatus() == SAPRFC_OK) {
      		$this->fce->FT_WITHTAX_CODE->Reset();
      		while ($this->fce->FT_WITHTAX_CODE->Next()) {
      			$itTampung[] = $this->fce->FT_WITHTAX_CODE->row;
      		}
      	}
      	return $itTampung;
      }

      public function getCostCenter($data) {
      	$this->openFunction('BAPI_COSTCENTER_GETLIST1');
      	$this->fce->CONTROLLINGAREA = 'SGG';
      	$this->fce->COMPANYCODE_FROM = $data['COMPANYCODE_FROM'];
      	$this->fce->call();
      	$i = 0;
      	$itTampung = array();
      	if ($this->fce->GetStatus() == SAPRFC_OK) {
      		$this->fce->COSTCENTERLIST->Reset();
      		while ($this->fce->COSTCENTERLIST->Next()) {
      			$itTampung[] = $this->fce->COSTCENTERLIST->row;
      		}
      	}
      	return $itTampung;
      }

      public function creategr($postdate, $docdate, $KODE_DETAIL_SHIPMENT, $PO_NO, $lineitem, $QTY, $user) {
      	$debug = true;
      	$itm = $this->getDetailPO($PO_NO);

      	$this->openFunction('BAPI_GOODSMVT_CREATE');

        //foreach ($grheader as $value) {
            //$this->fce->GOODSMVT_HEADER['PSTNG_DATE'] = '20170210';
      	$this->fce->GOODSMVT_HEADER['PSTNG_DATE'] = $postdate;
      	$this->fce->GOODSMVT_HEADER['DOC_DATE'] = $docdate;
      	$this->fce->GOODSMVT_HEADER['REF_DOC_NO'] = $KODE_DETAIL_SHIPMENT;
      	$this->fce->GOODSMVT_HEADER['HEADER_TXT'] = 'GR';

      	$this->fce->GOODSMVT_CODE['GM_CODE'] = '01';
            //$this->fce->GOODSMVT_CODE['PURCH_ORG'] = 'X';
            //$this->fce->GOODSMVT_CODE['PUR_GROUP'] = 'X';
        //}

        //foreach ($poitem as $value) {
      	$this->fce->GOODSMVT_ITEM->row['MOVE_TYPE'] ='101';
      	$this->fce->GOODSMVT_ITEM->row['ENTRY_QNT'] = $QTY;
      	$this->fce->GOODSMVT_ITEM->row['PO_NUMBER'] = $PO_NO;


            //var_dump($itm);
            //var_dump($itm[0]['PO_ITEM']);
      	// $this->fce->GOODSMVT_ITEM->row['PO_ITEM'] = $itm[0]['PO_ITEM'];
      	$this->fce->GOODSMVT_ITEM->row['PO_ITEM'] = $lineitem;
      	$this->fce->GOODSMVT_ITEM->row['MVT_IND'] = 'B';
      	$this->fce->GOODSMVT_ITEM->row['NO_MORE_GR'] = '';
      	$this->fce->GOODSMVT_ITEM->row['GR_RCPT'] = $user;
      	$this->fce->GOODSMVT_ITEM->Append($this->fce->GOODSMVT_ITEM->row);
            //$this->fce->GOODSMVT_ITEM['PREQ_ITEM'] = 'X';
        //}


      	$this->fce->call();
      	$data['RETURN'] = array();
      	if ($this->fce->GetStatus() == SAPRFC_OK) {
      		$this->fce->RETURN->Reset();
      		while ($this->fce->RETURN->Next()) {
      			$data['RETURN'][] = $this->fce->RETURN->row;
                //var_dump($this->fce->EXPPURCHASEORDER);
      		}
            /*$this->fce->FT_ITEM_QUO->Reset();
            while ($this->fce->FT_ITEM_QUO->Next()) {
                $data['FT_ITEM_QUO'][] = $this->fce->FT_ITEM_QUO->row;
            }*/
        }
        $data['GR'] = $this->fce->MATERIALDOCUMENT;
        $data['GR_YEAR'] = $this->fce->MATDOCUMENTYEAR;
        /*if ($debug) {
            var_dump($this->fce->RETURN->row);
            var_dump($this->fce->MATERIALDOCUMENT);
            var_dump($this->fce->MATDOCUMENTYEAR);
            var_dump($data);
            print_r('<br>');
        }*/
        $this->openFunction('BAPI_TRANSACTION_COMMIT');
        $this->fce->call();
        return $data;
    }

    public function getDetailPO($po_no) {
    	$debug = false;
    	$this->openFunction('BAPI_PO_GETDETAIL');
    	$this->fce->PURCHASEORDER = $po_no;
    	$this->fce->ITEMS = 'X';
    	$this->fce->HISTORY = 'X';
    	$this->fce->call();

    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->PO_ITEMS ->Reset();
    		while ($this->fce->PO_ITEMS ->Next()) {
    			$itTampung[] = $this->fce->PO_ITEMS ->row;
    		}
    	}
    	if ($debug) {
    		var_dump($itTampung);
    		print_r('<br>');
    	}
    	return $itTampung;
    }

    public function getPoImport($company) {
    	$debug = false;
    	$this->openFunction('ZCMM_GET_PO_LIST');
    	$this->fce->I_BSTYP = 'F';
    	//2000 -> ZG03
    	//5000 -> ZO03

    	//UNTUK NO_PPL DIAMBIL YANG FIELD VGABE NYA 2

    	if($company=="2000" || $company==2000){
    		$var_low_bsart = 'ZG03';
    	} else {
    		$var_low_bsart = 'ZO03';
    	}
    	$this->fce->S_BUKRS->row['SIGN'] = 'I';
    	$this->fce->S_BUKRS->row['OPTION'] = 'EQ';
    	$this->fce->S_BUKRS->row['LOW'] = $company;
    	$this->fce->S_BUKRS->Append($this->fce->S_BUKRS->row);

    	$this->fce->S_BSART->row['SIGN'] = 'I';
    	$this->fce->S_BSART->row['OPTION'] = 'EQ';
    	$this->fce->S_BSART->row['LOW'] = $var_low_bsart;
    	$this->fce->S_BSART->Append($this->fce->S_BSART->row);

    	$this->fce->call();

    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {

            //AMBIL TRANSAKSI
    		$this->fce->T_EKKO->Reset();
    		while ($this->fce->T_EKKO->Next()) {
    			$itTampung['T_EKKO'][] = $this->fce->T_EKKO->row;
    		}

            //AMBIL NAMA VENDOR
    		$this->fce->T_DATA->Reset();
    		while ($this->fce->T_DATA->Next()) {
    			$itTampung['T_DATA'][] = $this->fce->T_DATA->row;
    		}

            //AMBIL MATERIAL
    		$this->fce->T_EKPO->Reset();
    		while ($this->fce->T_EKPO->Next()) {
    			$itTampung['T_EKPO'][] = $this->fce->T_EKPO->row;
    		}

    		//AMBIL MATERIAL
    		$this->fce->T_HISTORY->Reset();
    		while ($this->fce->T_HISTORY->Next()) {
    			$itTampung['T_HISTORY'][] = $this->fce->T_HISTORY->row;
    		}
    	}
    	if ($debug) {
    		var_dump($itTampung);
    		print_r('<br>');
    	}
    	return $itTampung;
    }

    public function torPr($PR) {
    	$debug = false;
    	$this->openFunction('ZEPROC_APPROVAL_PR');
    	$this->fce->P_BANFN = $PR;
    	$this->fce->call();

    	$itTampung = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		//AMBIL MATERIAL
    		$this->fce->T_RETURN->Reset();
    		while ($this->fce->T_RETURN->Next()) {
    			$itTampung['T_RETURN'][] = $this->fce->T_RETURN->row;
    		}
    	}
    	if ($debug) {
    		echo "<pre>";
    		var_dump($itTampung);
    		print_r($itTampung);
    		print_r('<br>');
    	}
    	return $itTampung;
    }

    public function getFuncLoc($comp) {
    	$debug = false;
    	$this->openFunction('Z_ZCPH_RFC_SHGETFUNCLOC_1');
        // var_dump($comp);
    	$numbers = array();
    	if($comp=='3000'){
    		$numbers[] = '3*';
    	}else if($comp=='4000'){
    		$numbers[] = '4*';
    	}else{
    		$numbers[] = '2*';
    		$numbers[] = '5*';
    		$numbers[] = '7*';
    	}
        // var_dump(sizeof($numbers));
        // var_dump($numbers);
    	$itTampung = array();
    	for ($i=0; $i < sizeof($numbers); $i++) { 
    		$this->fce->R_PPLANT->row['SIGN'] = 'I';
    		$this->fce->R_PPLANT->row['OPTION'] = 'CP';
    		$this->fce->R_PPLANT->row['LOW'] = $numbers[$i];
    		$this->fce->R_PPLANT->Append($this->fce->R_PPLANT->row);

    	}
    	$this->fce->call();

    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->T_FUNCLOC ->Reset();
    		while ($this->fce->T_FUNCLOC->Next()) {
    			$itTampung[] = $this->fce->T_FUNCLOC ->row;
    		}
    	}

    	if ($debug) {
    		var_dump($itTampung);
    		print_r('<br>');
    	}
    	return $itTampung;
    }

    public function getFuncLocation($keyword) {
    	$debug = false;
    	$this->openFunction('Z_ZCPH_RFC_SHGETFUNCLOC_1');

    	$this->fce->R_STRNO->row['SIGN'] = 'I';
    	$this->fce->R_STRNO->row['OPTION'] = 'CP';
    	$this->fce->R_STRNO->row['LOW'] = $keyword.'*';
    	$this->fce->R_STRNO->Append($this->fce->R_STRNO->row);


    	$this->fce->call();

    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->T_FUNCLOC ->Reset();
    		while ($this->fce->T_FUNCLOC->Next()) {
    			$itTampung[] = $this->fce->T_FUNCLOC ->row;
    		}
    	}

    	if ($debug) {
    		var_dump($itTampung);
    		print_r('<br>');
    	}
    	return $itTampung;
    }

    public function create_contract_strategis($poheader, $poitem) {
        // var_dump($poheader);
    	$debug = false;
    	$this->openFunction('BAPI_CONTRACT_CREATE');
        // foreach ($poheader as $value) {
    	$this->fce->HEADER['DOC_TYPE'] = 'ZMKS';
    	$this->fce->HEADER['DOC_DATE'] = $poheader['docdate'];
    	$this->fce->HEADER['VPER_START'] = $poheader['startdate'];
    	$this->fce->HEADER['VPER_END'] = $poheader['enddate'];

    	$this->fce->HEADERX['DOC_TYPE'] = 'X';
    	$this->fce->HEADERX['DOC_DATE'] = 'X';
    	$this->fce->HEADERX['VPER_START'] = 'X';
    	$this->fce->HEADERX['VPER_END'] = 'X';
        // }
        //DOC_TYPE

    	foreach ($poitem as $value) {
    		$this->fce->ITEM->row['ITEM_NO'] = $value['po_item'];
    		$this->fce->ITEM->row['RFQ_NO'] = $value['rfq_no'];
    		$this->fce->ITEM->row['RFQ_ITEM'] = $value['rfq_item'];
    		$this->fce->ITEM->row['PREQ_NO'] = $value['pr'];
    		$this->fce->ITEM->row['PREQ_ITEM'] = $value['item_pr'];
    		$this->fce->ITEM->Append($this->fce->ITEM->row);

    		$this->fce->ITEMX->row['ITEM_NO'] = $value['po_item'];
    		$this->fce->ITEMX->row['ITEM_NOX'] ='X';
    		$this->fce->ITEMX->row['RFQ_NO'] = 'X';
    		$this->fce->ITEMX->row['RFQ_ITEM'] = 'X';
    		$this->fce->ITEMX->row['PREQ_NO'] = 'X';
    		$this->fce->ITEMX->row['PREQ_ITEM'] = 'X';
    		$this->fce->ITEMX->Append($this->fce->ITEMX->row);
    	}
        // print_r($this->fce);exit;
    	$this->openFunction('BAPI_TRANSACTION_COMMIT');
    	$this->fce->call();
    	$data['RETURN'] = array();
    	if ($this->fce->GetStatus() == SAPRFC_OK) {
    		$this->fce->RETURN->Reset();
    		while ($this->fce->RETURN->Next()) {
    			$data['RETURN'][] = $this->fce->RETURN->row;
    		}
    	}
        //  echo 'testing return';
    	if ($debug) {
    		var_dump($data['RETURN']);
    		print_r('<br>');
    	}
    	return $data;
    }

    public function getPOSpb($COMPANYID, $VENDOR_NO, $NO_PO) {

        $debug = false;
        $this->openFunction('ZCMM_GET_DATA_TIMB_PO');
        if($COMPANYID == '2000' || $COMPANYID == '7000' || $COMPANYID == '5000'){
            $this->fce->LR_BUKRS->row['SIGN'] = 'I';
            $this->fce->LR_BUKRS->row['OPTION'] = 'BT';
            $this->fce->LR_BUKRS->row['LOW'] = '2000';
            $this->fce->LR_BUKRS->row['HIGH'] = '7000';
        } else {
            $this->fce->LR_BUKRS->row['SIGN'] = 'I';
            $this->fce->LR_BUKRS->row['OPTION'] = 'EQ';
            $this->fce->LR_BUKRS->row['LOW'] = $COMPANYID;
        }
        $this->fce->LR_BUKRS->Append($this->fce->LR_BUKRS->row);

        $this->fce->LR_LIFNR->row['SIGN'] = 'I';
        $this->fce->LR_LIFNR->row['OPTION'] = 'EQ';
        $this->fce->LR_LIFNR->row['LOW'] = $VENDOR_NO;
        $this->fce->LR_LIFNR->Append($this->fce->LR_LIFNR->row);

        $this->fce->LR_EBELN->row['SIGN'] = 'I';
        $this->fce->LR_EBELN->row['OPTION'] = 'EQ';
        $this->fce->LR_EBELN->row['LOW'] = $NO_PO;
        $this->fce->LR_EBELN->Append($this->fce->LR_EBELN->row);
        
        $this->fce->call();
        
        $itTampung = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
            $this->fce->T_DATA ->Reset();
            while ($this->fce->T_DATA->Next()) {
                $itTampung[] = $this->fce->T_DATA ->row;
            }
        }

        if ($debug) {
            var_dump($itTampung);
            print_r('<br>');
        }
        return $itTampung;
    }

    public function changeDeliveryDateRfq($poitem) {
        // echo "<pre>";
        // print_r($poitem);die;
        $this->openFunction('ZCMM_CHANGE_RFQ');
        // foreach ($poitem as $val) {
        $this->fce->T_INPUT->row['EBELN'] = $poitem['rfq_no'];
        $this->fce->T_INPUT->row['EBELP'] = $poitem['rfq_item'];
        $this->fce->T_INPUT->row['DEL_DATE'] = $poitem['delivery_date'];
        $this->fce->T_INPUT->Append($this->fce->T_INPUT->row);
        // }

        // echo "<pre>";
        // print_r($poitem);
        // print_r($this->fce->T_INPUT);die;
        $this->fce->call();
        
        $itTampung = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
            $this->fce->T_RETURN->Reset();
            while ($this->fce->T_RETURN->Next()) {
                $itTampung[] = $this->fce->T_RETURN->row;
            }
        }
        // echo "<pre>";
        // print_r($poitem);
        // print_r($itTampung);
        // print_r($this->fce);
        // print_r($this->fce->T_RETURN);
        // die;
        return $itTampung;
    }
}

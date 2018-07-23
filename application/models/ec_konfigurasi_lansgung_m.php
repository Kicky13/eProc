<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_konfigurasi_lansgung_m extends CI_Model
{
    protected $table = 'EC_M_STRATEGIC_MATERIAL', $tablePlant = "EC_M_PLANT", $tableCategory = 'EC_M_CATEGORY', $tableAssign = 'EC_PL_ASSIGN', $tablVndPrd = 'VND_PRODUCT', $tableVnd = 'VND_HEADER', $tableUpdateHarga = 'EC_M_UPDATE_HARGA', $MasterCurrency = 'ADM_CURR';

    //protected $all_field = 'MONITORING_INVOICE.BUKRS, MONITORING_INVOICE.LIFNR, BELNR, GJAHR, BIL_NO, NAME1, BKTXT, SGTXT, XBLNR, UMSKZ, BUDAT, BLDAT, CPUDT, MONAT, ZLSPR, WAERS, HWAER, ZLSCH, ZTERM, DMBTR, WRBTR, BLART, STATUS, BYPROV, DATEPROV, DATECOL, WWERT, TGL_KIRUKP, USER_UKP, STAT_VER, TGL_VER, TGL_KIRVER, TGL_KEMB_VER, USER_VER, STAT_BEND, TGL_BEND, TGL_KIRBEND, TGL_KEMB_BEN, USER_BEN, STAT_AKU, TGL_AKU, TGL_KEMB_AKU, U_NAME, AUGDT, STAT_REJ, NO_REJECT, STATUS_UKP, NYETATUS, EBELN, EBELP, MBELNR, MGJAHR, PROJK, PRCTR, HBKID, DBAYAR, TBAYAR, UBAYAR, DGROUP, TGROUP, UGROUP, LUKP, LVER, LBEN, LAKU, AWTYPE, AWKYE, LBEN2, MWSKZ, HWBAS, FWBAS, HWSTE, FWSTE, WT_QBSHH, WT_QBSHB ';
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    public function getItemOld($kode_user)
    {
        $this->db->from($this->table);
        $this->db->join('EC_PL_ASSIGN', 'EC_M_STRATEGIC_MATERIAL.MATNR = EC_PL_ASSIGN.MATNO', 'left');
        $this->db->join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'inner');
        $this->db->order_by('PUBLISHED_LANGSUNG DESC');
        $this->db->where("EC_M_CATEGORY.KODE_USER LIKE '" . $kode_user . "%'");
        $this->db->or_where("EC_M_STRATEGIC_MATERIAL.PUBLISHED_LANGSUNG = 1");
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function publish($items = '', $stat = '1')
    {
        date_default_timezone_set('Asia/Jakarta');  
        
//        var_dump(date("Y-m-d H:i:s"));die();
        $date=date("Y-m-d H:i:s");
        foreach ($items as $value) {            
            $this->db->where("EC_M_STRATEGIC_MATERIAL.MATNR", $value, true);
            $this->db->set('PUBLISHED_LANGSUNG',"1");
            $this->db->set('DATEUP',"to_date('$date','yyyy/mm/dd hh24:mi:ss')",false);
            $this->db->update('EC_M_STRATEGIC_MATERIAL');
            if($stat==0){
                $this->db->where('MATNO', $value);
                $this->db->delete('EC_PL_ASSIGN');
            }
        }
    }
    public function getPublish($items = '', $stat = '1'){
        $this->db->from('EC_M_STRATEGIC_MATERIAL');        
        $SQL = ("(MATNR = '" . $items[0] . "'");
        for ($i = 1; $i < sizeof($items); $i++)
            $SQL .= (" OR MATNR = '" . $items[$i] . "'");
        $this->db->where($SQL.")");
        $this->db->order_by('DATEUP', 'DESC NULLS LAST ');        
        $result = $this->db->get();
        return (array)$result->result_array();
        
    }
    
    public function get_MasterCurrency()
    {
        $this->db->from($this->MasterCurrency);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getVnd($matgrp = '')
    {
        $SQL = ("EC_M_STRATEGIC_MATERIAL.MATKL = '" . $matgrp[0] . "'");
        for ($i = 1; $i < sizeof($matgrp); $i++) 
            $SQL .= (" OR EC_M_STRATEGIC_MATERIAL.MATKL = '" . $matgrp[$i] . "'");

        $result = $this->db->query("SELECT MATKL,VND_HEADER.VENDOR_ID,VND_HEADER.VENDOR_NO,VENDOR_NAME
FROM EC_M_STRATEGIC_MATERIAL
JOIN VND_PRODUCT ON EC_M_STRATEGIC_MATERIAL.MATKL = VND_PRODUCT.PRODUCT_CODE
LEFT JOIN VND_HEADER ON VND_PRODUCT.VENDOR_ID = VND_HEADER.VENDOR_ID
WHERE VND_HEADER.VENDOR_NO IS NOT NULL AND $SQL
GROUP BY MATKL,VND_HEADER.VENDOR_ID,VND_HEADER.VENDOR_NO,VENDOR_NAME
UNION
SELECT listagg(VP.PRODUCT_CODE,', ') within group( order by VP.PRODUCT_CODE ) as MATKL,VH.VENDOR_ID,VH.VENDOR_NO,VH.VENDOR_NAME 
FROM VND_PRODUCT VP RIGHT JOIN VND_HEADER VH ON VP.VENDOR_ID=VH.VENDOR_ID 
WHERE VP.VENDOR_ID IS NOT NULL AND VH.VENDOR_NO IS NOT NULL
GROUP BY VH.VENDOR_ID,VH.VENDOR_NO,VENDOR_NAME
ORDER BY MATKL,VENDOR_NO");
//$this->db->last_query();die();
        // $this -> db -> order_by('PL.VENDORNO');        
        return (array)$result->result_array();
    }

    public function getAllVnd($matgrp = '')
    {
//        $SQL = ("EC_M_STRATEGIC_MATERIAL.MATKL = '" . $matgrp[0] . "'");
//        for ($i = 1; $i < sizeof($matgrp); $i++)
//            $SQL .= (" OR EC_M_STRATEGIC_MATERIAL.MATKL = '" . $matgrp[$i] . "'");

        $result = $this->db->query("SELECT MATKL,VND_HEADER.VENDOR_ID,VND_HEADER.VENDOR_NO,VENDOR_NAME
FROM EC_M_STRATEGIC_MATERIAL
JOIN VND_PRODUCT ON EC_M_STRATEGIC_MATERIAL.MATKL = VND_PRODUCT.PRODUCT_CODE
LEFT JOIN VND_HEADER ON VND_PRODUCT.VENDOR_ID = VND_HEADER.VENDOR_ID
WHERE VND_HEADER.VENDOR_NO IS NOT NULL
GROUP BY MATKL,VND_HEADER.VENDOR_ID,VND_HEADER.VENDOR_NO,VENDOR_NAME
UNION
SELECT listagg(VP.PRODUCT_CODE,', ') within group( order by VP.PRODUCT_CODE ) as MATKL,VH.VENDOR_ID,VH.VENDOR_NO,VH.VENDOR_NAME 
FROM VND_PRODUCT VP RIGHT JOIN VND_HEADER VH ON VP.VENDOR_ID=VH.VENDOR_ID 
WHERE VP.VENDOR_ID IS NOT NULL AND VH.VENDOR_NO IS NOT NULL
GROUP BY VH.VENDOR_ID,VH.VENDOR_NO,VENDOR_NAME
ORDER BY MATKL,VENDOR_NO");
//$this->db->last_query();die();
        // $this -> db -> order_by('PL.VENDORNO');
        return (array)$result->result_array();
    }
    
    public function getVndAsli($matgrp = '')
    {
        $slc = "MATKL,PRODUCT_CODE,VND_PRODUCT.VENDOR_ID,VND_HEADER.VENDOR_NO,VENDOR_NAME";
        $this->db->from($this->table);
        $this->db->select($slc);
        $this->db->join('VND_PRODUCT', 'EC_M_STRATEGIC_MATERIAL.MATKL = VND_PRODUCT.PRODUCT_CODE', 'inner');
        $this->db->join('VND_HEADER', 'VND_PRODUCT.VENDOR_ID = VND_HEADER.VENDOR_ID', 'left');
        // $this -> db -> join('(SELECT VENDORNO FROM EC_PL_ASSIGN GROUP BY VENDORNO) PL', 'VND_PRODUCT.VENDOR_ID = PL.VENDORNO', 'left');
        $this->db->where("VND_HEADER.VENDOR_NO IS NOT NULL");
        // $this -> db -> where("EC_M_STRATEGIC_MATERIAL.MATKL", $matgrp[0], true);
        $SQL = ("(EC_M_STRATEGIC_MATERIAL.MATKL = '" . $matgrp[0] . "'");
        for ($i = 1; $i < sizeof($matgrp); $i++)
            $SQL .= (" OR EC_M_STRATEGIC_MATERIAL.MATKL = '" . $matgrp[$i] . "'");
        $this->db->where($SQL . ')');
        $this->db->group_by($slc);
        // $this -> db -> order_by('PL.VENDORNO');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getPlant($plant)
    {
        $this->db->from($this->tablePlant);
        $this->db->where_in('PLANT',$plant);
        $this->db->order_by('PLANT', "ASC");
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function publishPlant($plant, $stat)
    {
        $this->db->where("PLANT", $plant);
        $this->db->update($this->tablePlant, array('STATUS' => $stat));
    }

    public function syncPlant($data)
    {
//         var_dump($data);die();
        $uniqueKey = array('PLANT' => $data['PLANT']);
        $ada = $this->db->where($uniqueKey)->get($this->tablePlant)->num_rows();
//         var_dump($ada);die();

        // $this->db->where($data);
        // $query = $this->db->get($this->tablePlant);
        // $num = $query->num_rows();

        // var_dump($num); 
        if ($ada>0) {
            $this->db->where("PLANT", $data['PLANT']);
            $this->db->update($this->tablePlant, $data);
        }else{
            $this->db->insert($this->tablePlant, $data);    
        }
        
    }

    public function getVndMatno($matno = '', $matnogrp = '')
    {        
        $slc = "VND_PRODUCT.VENDOR_ID,VND_HEADER.VENDOR_NO,PL.VENDORNO,VENDOR_NAME";
        $slcg = "VND_PRODUCT.VENDOR_ID,VND_HEADER.VENDOR_NO,PL.VENDORNO,VENDOR_NAME";
        $this->db->from("(SELECT VENDORNO FROM EC_PL_ASSIGN WHERE MATNO='" . $matno . "' GROUP BY VENDORNO) PL");
        $this->db->select($slc);
        $this->db->join('VND_HEADER', 'VND_HEADER.VENDOR_NO = PL.VENDORNO', 'RIGHT');
        $this->db->join('VND_PRODUCT', 'VND_PRODUCT.VENDOR_ID = VND_HEADER.VENDOR_ID');        
        $this->db->join($this->table, 'EC_M_STRATEGIC_MATERIAL.MATKL = VND_PRODUCT.PRODUCT_CODE', 'inner');        
        $this->db->where("VND_HEADER.VENDOR_NO IS NOT NULL");        
        $this->db->where("EC_M_STRATEGIC_MATERIAL.MATKL = '" . $matnogrp[0] . "'");        
        $this->db->or_where("VND_HEADER.VENDOR_NO IS NOT NULL");        
        $this->db->group_by($slcg);
        $this->db->order_by('PL.VENDORNO');
//        $this->db->get();
//        echo $this->db->last_query();die(); 
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getVndMatnoOld($matno = '', $matnogrp = '')
    {
        $slc = "MATKL,PRODUCT_CODE,VND_PRODUCT.VENDOR_ID,VND_HEADER.VENDOR_NO,PL.VENDORNO,VENDOR_NAME";
        $this->db->from($this->table);
        $this->db->select($slc);
        $this->db->join('VND_PRODUCT', 'EC_M_STRATEGIC_MATERIAL.MATKL = VND_PRODUCT.PRODUCT_CODE', 'inner');
        $this->db->join('VND_HEADER', 'VND_PRODUCT.VENDOR_ID = VND_HEADER.VENDOR_ID', 'left');
        $this->db->join("(SELECT VENDORNO FROM EC_PL_ASSIGN WHERE MATNO='" . $matno . "' GROUP BY VENDORNO) PL", 'VND_HEADER.VENDOR_NO = PL.VENDORNO', 'left');
        $this->db->where("VND_HEADER.VENDOR_NO IS NOT NULL");
        // $this -> db -> where("EC_M_STRATEGIC_MATERIAL.MATNR", $matno, true);
        $this->db->where("EC_M_STRATEGIC_MATERIAL.MATKL = '" . $matnogrp[0] . "'");
        // $this -> db -> where("(EC_M_STRATEGIC_MATERIAL.MATNR = '" . $matno . "' AND EC_M_STRATEGIC_MATERIAL.MATKL = '" . $matnogrp[0] . "')");
        $this->db->group_by($slc);
        $this->db->order_by('PL.VENDORNO');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    //INSERT INTO "EPROC"."EC_PL_ASSIGN"
    //("KODE_ASSIGN", "MATNO", "VENDORNO", "START_DATE", "END_DATE", "INDATE", "ROWID") VALUES
    //('3', '701-201-0409', '0000110013', TO_DATE('2017-01-11 13:48:28', 'SYYYY-MM-DD HH24:MI:SS'), TO_DATE('2017-01-13 13:48:32', 'SYYYY-MM-DD HH24:MI:SS'), TO_DATE('2017-01-11 13:48:45', 'SYYYY-MM-DD HH24:MI:SS'), 'AAB7BDABPAAAADrAAA');
    //'SYYYY-MM-DD HH24:MI:SS'
    public function insert($itms, $vnds, $startDate, $endDate, $kode_update, $lamahari = '0', $currency)
    {
        $now = date("Y-m-d H:i:s");
        foreach ($itms as $value) {
            $this->db->where('MATNO', $value);
            $this->db->delete('EC_PL_ASSIGN');
            foreach ($vnds as $values) {
                $SQL = "INSERT INTO EC_PL_ASSIGN
				VALUES
					(
						'',
						'" . $value . "',
						'" . $values . "',
						TO_DATE (
							'" . $startDate . "',
							'DD-MM-YYYY'
						),
						TO_DATE (
							'" . $endDate . "',
							'DD-MM-YYYY'
						),
						TO_DATE (
							'" . $now . "',
							'YYYY-MM-DD HH24:MI:SS'
						),NULL,'" . $kode_update . "','" . $lamahari . "','" . $currency . "'
					)";
                $this->db->query($SQL);
            }
        }
        // return (array)$result -> result_array();
    }

    public function edit($itms, $vnds, $kode_update = '511', $lamahari = '10', $currency = 'IDR')
    {
        $this->deleteUncheck($itms, $vnds);
        $assign = $this->existAssign($itms);
        for ($i = 0; $i < count($vnds); $i++){
            for ($j = 0; $j < count($assign); $j++){
                if ($vnds[$i] == $assign[$j]['VENDORNO']){
                    unset($vnds[$i]);
                }
            }
        }
//        $this->db->where('MATNO', $itms);
//        $this->db->delete('EC_PL_ASSIGN');
        $now = date("Y-m-d H:i:s");
        $startDate = date("d-m-Y");
        $endDate = null;
        $query = array();
        foreach ($vnds as $values) {
//            if ($this->cekAssign($itms, $values) == 2){
            $SQL = "INSERT INTO EC_PL_ASSIGN
				VALUES
					(
						'',
						'" . $itms . "',
						'" . $values . "',
						TO_DATE (
							'" . $startDate . "',
							'DD-MM-YYYY'
						),
						TO_DATE (
							'" . $endDate . "',
							'DD-MM-YYYY'
						),
						TO_DATE (
							'" . $now . "',
							'YYYY-MM-DD HH24:MI:SS'
						),NULL,'" . $kode_update . "','" . $lamahari . "','" . $currency . "'
					)";
            $this->db->query($SQL);
            array_push($query, $SQL);
//            } else {
//                break;
//            }
        }
    }

    public function deleteUncheck($matno, $check)
    {
        $data = $this->existAssign($matno);
        for ($i = 0; $i < count($data); $i++){
            $x = 0;
            for ($j = 0; $j < count($check); $j++){
                if ($data[$i]['VENDORNO'] == $check[$j]){
                    $x++;
                } else {
                    break;
                }
            }
            if ($x == 0){
                $this->db->where('MATNO', $matno);
                $this->db->where('VENDORNO', $data[$i]['VENDORNO']);
                $this->db->delete('EC_PL_ASSIGN');
            }
        }
    }

    public function existAssign($matno)
    {
        $this->db->from('EC_PL_ASSIGN');
        $this->db->where('MATNO', $matno);
//        $this->db->where('VENDORNO', $vnd);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getItem($kode_user)
    {
        $SQL = "SELECT
				EM.MATNR,
				EM.MATKL,
				EM.MAKTX,
				EM.MEINS,
				EC.KODE_USER,
				EC.ID_CAT,
				KODE_UPDATE,
				DAYS_UPDATE,
				CURRENCY,
				EM.ID_CAT,
				PL.MATNO,
				EM.PUBLISHED_LANGSUNG,
				TO_CHAR (PL.START_DATE,'DD/MM/YYYY') PEMBUKAAN,
				TO_CHAR (PL.END_DATE,'DD/MM/YYYY') PENUTUPAN
			FROM
				EC_M_STRATEGIC_MATERIAL EM
			LEFT JOIN (SELECT MATNO,START_DATE,END_DATE,KODE_UPDATE,DAYS_UPDATE,CURRENCY FROM EC_PL_ASSIGN GROUP BY MATNO,START_DATE,END_DATE,KODE_UPDATE,DAYS_UPDATE,CURRENCY) PL ON EM.MATNR = PL.MATNO
			INNER JOIN EC_M_CATEGORY EC ON EC.ID_CAT = EM.ID_CAT
			WHERE
				EC.KODE_USER LIKE '" . $kode_user . "%'	 AND EM.PUBLISHED_LANGSUNG != 1
			ORDER BY
					EM.PUBLISHED_LANGSUNG DESC";
        $result = $this->db->query($SQL);
        return (array)$result->result_array();
    }
    //OR EM.PUBLISHED_LANGSUNG=1
    //AND EM.PUBLISHED_LANGSUNG != 1

    public function getItemPublish($kode_user)
    {
        $SQL = "SELECT
				EM.MATNR,
				EM.MATKL,
				EM.MAKTX,
				EM.MEINS,
				EC.KODE_USER,
				EC.ID_CAT,
				KODE_UPDATE,
				DAYS_UPDATE,
				CURRENCY,
				EM.ID_CAT,
				PL.MATNO,
				EM.PUBLISHED_LANGSUNG,
				TO_CHAR (PL.START_DATE,'DD-MM-YYYY') PEMBUKAAN,
				TO_CHAR (PL.END_DATE,'DD-MM-YYYY') PENUTUPAN,
                                TO_CHAR (DATEUP,'YYYY-MM-DD HH24:MI:SS') PUBLISH                                
			FROM
				EC_M_STRATEGIC_MATERIAL EM
			LEFT JOIN (SELECT MATNO,START_DATE,END_DATE,KODE_UPDATE,DAYS_UPDATE,CURRENCY FROM EC_PL_ASSIGN GROUP BY MATNO,START_DATE,END_DATE,KODE_UPDATE,DAYS_UPDATE,CURRENCY) PL ON EM.MATNR = PL.MATNO
			INNER JOIN EC_M_CATEGORY EC ON EC.ID_CAT = EM.ID_CAT
			WHERE
				EC.KODE_USER LIKE '" . $kode_user . "'	and EM.PUBLISHED_LANGSUNG=1			 
			ORDER BY
					EM.DATEUP DESC NULLS LAST, EM.PUBLISHED_LANGSUNG DESC";
        $result = $this->db->query($SQL);
        return (array)$result->result_array();
    }

    public function getItemOld2($kode_user)
    {
        $SQL = "SELECT
				EM.MATNR,
				EM.MATKL,
				EM.MAKTX,
				EM.MEINS,
				EC.KODE_USER,
				EC.ID_CAT,
				EM.ID_CAT,
				PL.MATNO,
				TO_CHAR (PL.START_DATE,'DD/MM/YYYY HH24:MI:SS'),
				TO_CHAR (PL.END_DATE,'DD/MM/YYYY HH24:MI:SS')
			FROM
				EC_M_STRATEGIC_MATERIAL EM
			--LEFT JOIN EC_PL_ASSIGN PL ON EM.MATNR = PL.MATNO
			INNER JOIN EC_M_CATEGORY EC ON EC.ID_CAT = EM.ID_CAT
			WHERE
				EC.KODE_USER LIKE '1-3%'
			OR --PL.KODE_ASSIGN IS NOT NULL
			EM.PUBLISHED_LANGSUNG=1
			GROUP BY
				EM.MATNR,
				EM.MATKL,
				EM.MAKTX,
				EM.MEINS,
				EC.KODE_USER,
				EC.ID_CAT,
				EM.ID_CAT,
				PL.MATNO,
				TO_CHAR (
					PL.START_DATE,
					'DD/MM/YYYY HH24:MI:SS'
				),
				TO_CHAR (
					PL.END_DATE,
					'DD/MM/YYYY HH24:MI:SS'
				)
				ORDER BY
					EM.PUBLISHED_LANGSUNG DESC";
        $result = $this->db->query($SQL);
        return (array)$result->result_array();
    }


    public function get_M_update()
    {
        $this->db->from($this->tableUpdateHarga);
        $this->db->order_by('KODE_UPDATE ASC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }
}

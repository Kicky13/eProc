<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_konfigurasi_lansgung_m extends CI_Model
{
    protected $table = 'EC_M_STRATEGIC_MATERIAL', $tablePlant = "EC_M_PLANT", $tableCategory = 'EC_M_CATEGORY', $tableAssign = 'EC_PL_ASSIGN', $tablVndPrd = 'VND_PRODUCT', $tableVnd = 'VND_HEADER', $tableUpdateHarga = 'EC_M_UPDATE_HARGA', $MasterCurrency = 'ADM_CURR', $tableVndAss = 'EC_PL_VENDOR_ASSIGN', $log = 'EC_ADM_VENDOR_ASSIGN_LOG', $tableConf = 'EC_PL_KONFIGURASI_ASSIGN', $employee = 'ADM_EMPLOYEE', $plantLog = 'EC_LOG_PLANT_CHANGE';

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

    public function getVndAssign()
    {
        $userid = $this->session->userdata['ID'];
        $select = $this->tableVndAss.'.VENDORNO, '.$this->tableVnd.'.VENDOR_NAME';
        $this->db->select($select);
        $this->db->from($this->tableVndAss);
        $this->db->join($this->tableVnd, $this->tableVndAss.'.VENDORNO = '.$this->tableVnd.'.VENDOR_NO');
        $this->db->where($this->tableVndAss.'.USERID', $userid);
        $this->db->where($this->tableVndAss.'.LEVEL_APP', 0);
        $this->db->group_by($select);
        $result = $this->db->get();
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
        $userid = $this->session->userdata['ID'];
        $now = $now = date("Y-m-d H:i:s");

        $this->db->where("PLANT", $plant);
        $this->db->update($this->tablePlant, array('STATUS' => $stat));

        $this->db->insert($this->plantLog, array('PLANT' => $plant, 'USER_ID' => $userid, 'LOG_DATE' => $now, 'LOG_ACTIVITY' => $stat));
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

    public function getMatVnd_assign($vendorno)
    {
        $userid = $this->session->userdata['ID'];
        $select = $this->tableVndAss.'.MATNO, '.$this->table.'.MAKTX, '.$this->table.'.MEINS, '.$this->tableVndAss.'.INDATE, '.$this->tableVndAss.'.CURRENCY';
        $this->db->select($select);
        $this->db->from($this->tableVndAss);
        $this->db->join($this->table, $this->tableVndAss.'.MATNO = '.$this->table.'.MATNR');
        $this->db->where($this->tableVndAss.'.VENDORNO', $vendorno);
        $this->db->where($this->tableVndAss.'.LEVEL_APP', 0);
        $this->db->where($this->tableVndAss.'.USERID', $userid);
        $this->db->group_by($select);
        $this->db->order_by($this->tableVndAss.'.MATNO');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getAssignedItem($vendorno, $item)
    {
        $this->db->from($this->tableAssign);
        $this->db->where('VENDORNO', $vendorno);
        $this->db->where('MATNO', $item);
        $result = $this->db->get();
        if (count($result->result_array()) > 0){
            return true;
        } else {
            return false;
        }
    }

    public function getVndMatno_propose($matno = '', $matnogrp = '')
    {
        $slc = "VND_PRODUCT.VENDOR_ID,VND_HEADER.VENDOR_NO,PL.VENDORNO,VENDOR_NAME";
        $slcg = "VND_PRODUCT.VENDOR_ID,VND_HEADER.VENDOR_NO,PL.VENDORNO,VENDOR_NAME";
        $this->db->from("(SELECT VENDORNO FROM EC_PL_VENDOR_ASSIGN WHERE MATNO='" . $matno . "' GROUP BY VENDORNO) PL");
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

    public function insertPropose($itms, $vnds, $startDate, $endDate, $kode_update, $lamahari = '0', $currency)
    {
        $userid = $this->session->userdata['ID'];
        $next = $this->getNextApp();
        $now = date("Y-m-d H:i:s");
        foreach ($itms as $value) {
            $this->db->where('MATNO', $value);
            $this->db->where('USERID', $userid);
            $this->db->delete('EC_PL_VENDOR_ASSIGN');
            foreach ($vnds as $values) {
                $SQL = "INSERT INTO EC_PL_VENDOR_ASSIGN
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
						),NULL,'" . $kode_update . "','" . $lamahari . "','" . $currency . "','" . $userid . "','" . 1 . "','" . 1 . "'
					)";
                $this->db->query($SQL);
                $this->insertLog($value, $values, $kode_update, $userid, 0, 0);
                $this->insertLog($value, $values, $kode_update, $next['USER_ID'], 1, 1);
            }
        }
    }

    function getNextApp()
    {
        $comp = $this->session->userdata['COMPANYID'];
        $this->db->from('EC_PL_KONFIGURASI_ASSIGN');
        $this->db->where('COMPANY', $comp);
        $this->db->where('LEVEL', 1);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function insertLog($matno, $vendorno, $kode_update, $userid, $level, $activity)
    {
        $this->db->where('MATNO', $matno);
        $this->db->where('VENDORNO', $vendorno);
        $this->db->where('USERID', $userid);
        $this->db->delete('EC_REPORT_VENDOR_ASSIGN');
        $now = date("Y-m-d H:i:s");
        $this->db->insert('EC_REPORT_VENDOR_ASSIGN', array('MATNO' => $matno, 'VENDORNO' => $vendorno, 'KODE_UPDATE' => $kode_update, 'USERID' => $userid, 'LOG_DATE' => $now, 'LOG_ACTIVITY' => $activity));
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

    public function editPropose($itms, $vnds, $kode_update = '511', $lamahari = '10', $currency = 'IDR')
    {
        $userid = $this->session->userdata['ID'];
        $this->uncheckPropose($itms, $vnds);
        $assign = $this->existVenAssign($itms);
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
            $SQL = "INSERT INTO EC_PL_VENDOR_ASSIGN
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
						),NULL,'" . $kode_update . "','" . $lamahari . "','" . $currency . "','" . $userid . "','" . 1 . "','" . 1 . "'
					)";
            $this->db->query($SQL);
            array_push($query, $SQL);
//            } else {
//                break;
//            }
        }
    }

    function notificationGateway($item, $vendor, $kode, $days, $currency)
    {
        $data = array();
        $item = $this->getMaterial($item);
        $vendor = $this->getVendor($vendor);
        $curr = $this->currentLvl();
        $now = date("Y-m-d H:i:s");
        $userdata = $this->getEmail($this->getNext($curr['LEVEL']));
        $data['DATA']['MATNO'] = $item['MATNR'];
        $data['DATA']['MAKTX'] = $item['MAKTX'];
        $data['DATA']['VENDORNO'] = $vendor['VENDOR_NO'];
        $data['DATA']['VENDORNAME'] = $vendor['VENDOR_NAME'];
        $data['DATA']['KODE_UPDATE'] = $kode;
        $data['DATA']['DAYS_UPDATE'] = $days;
        if ($kode == '510'){
            $data['DATA']['UPDATE'] = $days.' Hari';
        } elseif ($kode == '511'){
            $data['DATA']['UPDATE'] = 'Perbulan';
        } elseif ($kode == '521'){
            $data['DATA']['UPDATE'] = 'Perminggu';
        } else {
            $data['DATA']['UPDATE'] = 'Null';
        }
        $data['DATA']['CURRENCY'] = $currency;
        $data['DATA']['INDATE'] = $now;
        $data['EMAIL'] = $userdata['EMAIL'];
        $data['ACTIVITY'] = 0;
        $data['FULLNAME'] = $userdata['FULLNAME'];

        return $data;
    }

    function getMaterial($matno)
    {
        $this->db->from($this->table);
        $this->db->where('MATNR', $matno);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function getVendor($vendorno)
    {
        $this->db->from($this->tableVnd);
        $this->db->where('VENDOR_NO', $vendorno);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function currentLvl()
    {
        $this->db->from($this->tableConf);
        $this->db->where('USER_ID', $this->session->userdata['ID']);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function getNext($lvl)
    {
        $company = $this->session->userdata['COMPANYID'];
        $this->db->from($this->tableConf);
        $this->db->where('COMPANY', $company);
        $this->db->where('LEVEL', $lvl+1);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function getEmail($userdata)
    {
        $this->db->from($this->employee);
        $this->db->where('ID', $userdata['USER_ID']);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    public function editAssign($itms, $vnds, $kode_update = '511', $lamahari = '10', $currency = 'IDR')
    {
        $this->deleteUncheck($vnds, $itms);
        $assign = $this->existAssign($vnds);
        for ($i = 0; $i < count($itms); $i++){
            for ($j = 0; $j < count($assign); $j++){
                if ($itms[$i] == $assign[$j]['MATNO']){
                    unset($itms[$i]);
                }
            }
        }
        $now = date("Y-m-d H:i:s");
        $startDate = date("d-m-Y");
        $endDate = null;
        $query = array();
        foreach ($itms as $values) {
            $item = $this->getInserted($vnds, $values);
            $this->insertVendorLog($values, $vnds, 1);
            $SQL = "INSERT INTO EC_PL_ASSIGN
				VALUES
					(
						'',
						'" . $values . "',
						'" . $vnds . "',
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
						),NULL,'" . $item['KODE_UPDATE'] . "','" . $item['DAYS_UPDATE'] . "','" . $item['CURRENCY'] . "'
					)";
            $this->db->query($SQL);
            array_push($query, $SQL);
//            } else {
//                break;
//            }
        }
    }

    public function deleteUncheck($vendorno, $check)
    {
        $data = $this->existAssign($vendorno);
        for ($i = 0; $i < count($data); $i++){
            $x = 0;
            for ($j = 0; $j < count($check); $j++){
                if ($data[$i]['MATNO'] == $check[$j]){
                    $x++;
                } else {
                    break;
                }
            }
            if ($x == 0){
                $this->db->where('VENDORNO', $vendorno);
                $this->db->where('MATNO', $data[$i]['MATNO']);
                $this->db->delete('EC_PL_ASSIGN');
                $this->insertVendorLog($data[$i]['MATNO'], $vendorno, 2);
            }
        }
    }

    public function uncheckPropose($matno, $check)
    {
        $userid = $this->session->userdata['ID'];
        $data = $this->existVenAssign($matno);
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
                if ($data[$i]['LEVEL_APP'] == 1){
                    $this->db->where('MATNO', $matno);
                    $this->db->where('VENDORNO', $data[$i]['VENDORNO']);
                    $this->db->where('USERID', $userid);
                    $this->db->delete('EC_PL_VENDOR_ASSIGN');
                }
            }
        }
    }

    public function existAssign($vendorno)
    {
        $this->db->from('EC_PL_ASSIGN');
        $this->db->where('VENDORNO', $vendorno);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getInserted($vendorno, $matno)
    {
        $userid = $this->session->userdata['ID'];
        $this->db->from($this->tableVndAss);
        $this->db->where('USERID', $userid);
        $this->db->where('VENDORNO', $vendorno);
        $this->db->where('MATNO', $matno);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    public function existVenAssign($matno)
    {
        $userid = $this->session->userdata['ID'];
        $this->db->from('EC_PL_VENDOR_ASSIGN');
        $this->db->where('MATNO', $matno);
        $this->db->where('USERID', $userid);
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

    public function insertVendorLog($matno, $vendorno, $activity)
    {
        $now = date("Y-m-d H:i:s");
        $userid = $this->session->userdata['ID'];
        $this->db->insert($this->log, array('MATNO' => $matno, 'VENDORNO' => $vendorno, 'USERID' => $userid, 'LOG_ACTIVITY' => $activity, 'LOG_DATE' => $now));
        return true;
    }
}

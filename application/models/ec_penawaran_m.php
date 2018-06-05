<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_penawaran_m extends CI_Model
{
    protected $tablePenawaran = 'EC_PL_PENAWARAN', $tablePlant = 'EC_M_PLANT', $tableDtlPenawar = 'EC_T_DETAIL_PENAWARAN', $tableCart = 'EC_T_CHART', $tableStrategic = 'EC_M_STRATEGIC_MATERIAL', $tableASSIGN = 'EC_PL_ASSIGN', $MasterCurrency = 'ADM_CURR';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    public function get_data_produk($vendorno)
    {
        $SQL = "SELECT  DT.STOK_COMMIT, SM.MAKTX, SM.MEINS, SM.PICTURE, SM.DRAWING, ASS.*,
                    (SELECT TB1.STOK FROM EC_PL_PENAWARAN TB1 WHERE TB1.KODE_PENAWARAN=(SELECT MAX(TB2.KODE_PENAWARAN) FROM EC_PL_PENAWARAN TB2 WHERE TB2.VENDORNO='" . $vendorno . "' AND TB2.MATNO IN ASS.MATNO) ) AS STOK
                FROM EC_PL_ASSIGN ASS
                INNER JOIN EC_M_STRATEGIC_MATERIAL SM ON SM.MATNR=ASS.MATNO
                LEFT JOIN (SELECT SUM(CRT.STOK_COMMIT) STOK_COMMIT,CRT.MATNO FROM EC_T_CHART CRT 
                                        INNER JOIN (SELECT KODE_DETAIL_PENAWARAN FROM EC_T_DETAIL_PENAWARAN WHERE VENDORNO='" . $vendorno . "') DT 
                                        ON DT.KODE_DETAIL_PENAWARAN=CRT.KODE_PENAWARAN GROUP BY CRT.MATNO) DT
                        ON DT.MATNO=ASS.MATNO
                WHERE ASS.VENDORNO='" . $vendorno . "'";

        $result = $this->db->query($SQL);

        return (array)$result->result_array();
    }

    public function get_data_produk_old2($vendorno)
    {
        $SQL = "SELECT PA.*, MAT.MAKTX, MAT.MEINS, MAT.PICTURE, MAT.DRAWING, PEN.STOK, STK.STOK_COMMIT
                FROM EC_PL_ASSIGN PA
                INNER JOIN EC_M_STRATEGIC_MATERIAL MAT ON MAT.MATNR=PA.MATNO
                LEFT JOIN EC_PL_PENAWARAN PEN ON PEN.MATNO=PA.MATNO AND PEN.VENDORNO=PA.VENDORNO
                LEFT JOIN (SELECT SUM(CRT.STOK_COMMIT) STOK_COMMIT,CRT.MATNO FROM EC_T_CHART CRT 
                INNER JOIN (SELECT KODE_DETAIL_PENAWARAN FROM EC_T_DETAIL_PENAWARAN WHERE VENDORNO='" . $vendorno . "') DT 
                ON DT.KODE_DETAIL_PENAWARAN=CRT.KODE_PENAWARAN GROUP BY CRT.MATNO) STK ON STK.MATNO=PA.MATNO
                WHERE PA.VENDORNO = '" . $vendorno . "'";

        $result = $this->db->query($SQL);

        return (array)$result->result_array();
    }

    public function get_data_produk_old($vendorno)
    {
        $SQL = "SELECT TO_CHAR (
						ASS.START_DATE,
						'DD/MM/YYYY'
					) AS TGL_MULAI,
					TO_CHAR (
						ASS.END_DATE,
						'DD/MM/YYYY'
					) AS TGL_AKHIR, DT.STOK_COMMIT, SM.*, ASS.*, (SELECT TB1.HARGA_PENAWARAN FROM EC_PL_PENAWARAN TB1 WHERE TB1.KODE_PENAWARAN=(SELECT MAX(TB2.KODE_PENAWARAN) FROM EC_PL_PENAWARAN TB2 WHERE TB2.VENDORNO='" . $vendorno . "' AND TB2.MATNO IN ASS.MATNO) ) AS HARGA_PENAWARAN,
					(SELECT TO_CHAR (TB1.INDATE, 'DD-MM-YYYY') FROM EC_PL_PENAWARAN TB1 WHERE TB1.KODE_PENAWARAN=(SELECT MAX(TB2.KODE_PENAWARAN) FROM EC_PL_PENAWARAN TB2 WHERE TB2.VENDORNO='" . $vendorno . "' AND TB2.MATNO IN ASS.MATNO) ) AS LASTUPDATE,
					(SELECT TB1.DELIVERY_TIME FROM EC_PL_PENAWARAN TB1 WHERE TB1.KODE_PENAWARAN=(SELECT MAX(TB2.KODE_PENAWARAN) FROM EC_PL_PENAWARAN TB2 WHERE TB2.VENDORNO='" . $vendorno . "' AND TB2.MATNO IN ASS.MATNO) ) AS DELIVERY_TIME,
					(SELECT TB1.STOK FROM EC_PL_PENAWARAN TB1 WHERE TB1.KODE_PENAWARAN=(SELECT MAX(TB2.KODE_PENAWARAN) FROM EC_PL_PENAWARAN TB2 WHERE TB2.VENDORNO='" . $vendorno . "' AND TB2.MATNO IN ASS.MATNO) ) AS STOK
			FROM EC_PL_ASSIGN ASS
			INNER JOIN EC_M_STRATEGIC_MATERIAL SM ON SM.MATNR=ASS.MATNO
			LEFT JOIN 
			(SELECT SUM(CRT.STOK_COMMIT) STOK_COMMIT,CRT.MATNO FROM EC_T_CHART CRT INNER JOIN (SELECT KODE_DETAIL_PENAWARAN FROM EC_T_DETAIL_PENAWARAN WHERE VENDORNO='" . $vendorno . "') DT ON DT.KODE_DETAIL_PENAWARAN=CRT.KODE_PENAWARAN GROUP BY CRT.MATNO) DT
			ON DT.MATNO=ASS.MATNO
			WHERE ASS.VENDORNO='" . $vendorno . "'";

        $result = $this->db->query($SQL);

        return (array)$result->result_array();
    }

    public function get_data_produkOLD($vendorno)
    {
        $SQL = "SELECT TO_CHAR (
						ASS.START_DATE,
						'DD/MM/YYYY'
					) AS TGL_MULAI,
					TO_CHAR (
						ASS.END_DATE,
						'DD/MM/YYYY'
					) AS TGL_AKHIR, SM.*, ASS.*, (SELECT TB1.HARGA_PENAWARAN FROM EC_PL_PENAWARAN TB1 WHERE TB1.KODE_PENAWARAN=(SELECT MAX(TB2.KODE_PENAWARAN) FROM EC_PL_PENAWARAN TB2 WHERE TB2.VENDORNO='" . $vendorno . "' AND TB2.MATNO IN ASS.MATNO) ) AS HARGA_PENAWARAN,
					(SELECT TO_CHAR (TB1.INDATE, 'DD-MM-YYYY') FROM EC_PL_PENAWARAN TB1 WHERE TB1.KODE_PENAWARAN=(SELECT MAX(TB2.KODE_PENAWARAN) FROM EC_PL_PENAWARAN TB2 WHERE TB2.VENDORNO='" . $vendorno . "' AND TB2.MATNO IN ASS.MATNO) ) AS LASTUPDATE,
					(SELECT TB1.DELIVERY_TIME FROM EC_PL_PENAWARAN TB1 WHERE TB1.KODE_PENAWARAN=(SELECT MAX(TB2.KODE_PENAWARAN) FROM EC_PL_PENAWARAN TB2 WHERE TB2.VENDORNO='" . $vendorno . "' AND TB2.MATNO IN ASS.MATNO) ) AS DELIVERY_TIME,
					(SELECT TB1.STOK FROM EC_PL_PENAWARAN TB1 WHERE TB1.KODE_PENAWARAN=(SELECT MAX(TB2.KODE_PENAWARAN) FROM EC_PL_PENAWARAN TB2 WHERE TB2.VENDORNO='" . $vendorno . "' AND TB2.MATNO IN ASS.MATNO) ) AS STOK,
					(SELECT TB1.STOK_COMMIT FROM EC_PL_PENAWARAN TB1 WHERE TB1.KODE_PENAWARAN=(SELECT MAX(TB2.KODE_PENAWARAN) FROM EC_PL_PENAWARAN TB2 WHERE TB2.VENDORNO='" . $vendorno . "' AND TB2.MATNO IN ASS.MATNO) ) AS STOK_COMMIT
			FROM EC_PL_ASSIGN ASS
			INNER JOIN EC_M_STRATEGIC_MATERIAL SM ON SM.MATNR=ASS.MATNO
			WHERE ASS.VENDORNO='" . $vendorno . "'";

        $result = $this->db->query($SQL);

        return (array)$result->result_array();
    }

    public function getPlant()
    {
        $this->db->from($this->tablePlant);
        $this->db->where('STATUS', "1");
        $result = $this->db->get();
        return (array)$result->result_array();
    }


    public function getData($vendorno, $matno)
    {
        $SQL = "SELECT ASS.*, TO_CHAR (
						ASS.START_DATE,
						'YYYY-MM-DD HH24:MI:SS'
					) AS STARTDATE,
					TO_CHAR (
						ASS.END_DATE,
						'YYYY-MM-DD HH24:MI:SS'
					) AS ENDDATE FROM EC_PL_ASSIGN ASS				
				WHERE ASS.VENDORNO='" . $vendorno . "' AND ASS.MATNO='" . $matno . "'";
        $result = $this->db->query($SQL);
        return $result->row_array();
    }

    public function get_MasterCurrency()
    {
        $this->db->from($this->MasterCurrency);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function insertData($venno, $matno, $harga, $curr, $deliverytime, $stok, $in_date)
    {
        $SQL = "INSERT INTO \"EC_PL_PENAWARAN\" (\"VENDORNO\", \"MATNO\", \"HARGA_PENAWARAN\", \"DELIVERY_TIME\", \"INDATE\", \"CURR\", \"STOK\",STOK_COMMIT) 
                VALUES ('" . $venno . "', '" . $matno . "', '" . $harga . "', '" . $deliverytime . "', TO_DATE('" . $in_date . "', 'yyyy-mm-dd hh24:mi:ss'), '" . $curr . "', '" . $stok . "',0)";
        $this->db->query($SQL);

        $this->db->select('max(KODE_PENAWARAN) KODE_PENAWARAN');
        $this->db->where("VENDORNO", $venno, TRUE);
        $this->db->where("MATNO", $matno, TRUE);
        $query = $this->db->get('EC_PL_PENAWARAN');
        $result = (array)$query->result_array();
        $kodeBaru = $result[0]['KODE_PENAWARAN'];//kode insert terbaru

        $this->db->select('KODE_PENAWARAN,HARGA_PENAWARAN');
        $this->db->where("HARGA_PENAWARAN >", "0", TRUE);
        $this->db->order_by('HARGA_PENAWARAN,INDATE', 'ASC');
        $this->db->join('EC_PL_PENAWARAN TB2',
            'TB1.VENDORNO=TB2.VENDORNO AND TB1.MATNO=TB2.MATNO AND TB1.DATE1=TB2.INDATE', 'INNER');
        $query = $this->db->get("(SELECT PEN.VENDORNO, PEN.MATNO, MAX(PEN.INDATE) AS DATE1 FROM EC_PL_PENAWARAN PEN WHERE MATNO='" . $matno . "' GROUP BY PEN.VENDORNO, PEN.MATNO ) TB1");
        $result = (array)$query->result_array();
        $hargaA = 0;
        $kode3 = 0;
        if (sizeof($result) > 0) {
            $kode3 = $result[0]['KODE_PENAWARAN'];
            $hargaA = $result[0]['HARGA_PENAWARAN'];//harga terbaru dan termurah
        }
        $this->db->select('HARGA_PENAWARAN,EC_PL_ASSIGN.VENDORNO');
        $this->db->join('EC_PL_PENAWARAN', 'EC_PL_ASSIGN.KODE_PENAWARAN = EC_PL_PENAWARAN.KODE_PENAWARAN', 'left');
        $query = $this->db->get('EC_PL_ASSIGN');
        $result = $query->row_array();
        $hargaB = $result['HARGA_PENAWARAN'];//harga dari table assign
        $vndMin = $result['VENDORNO'];//vnd harga dari table assign


        if (($harga < $hargaA || $hargaB == '' || $vndMin == $venno) && $harga > 0) {
            $this->db->where("MATNO", $matno, TRUE);
            $this->db->update('EC_PL_ASSIGN', array('KODE_PENAWARAN' => $kodeBaru));

            $this->db->set('KODE_PENAWARAN', $kodeBaru, FALSE);
            // $this -> db -> where("ID_USER", $ID_USER, TRUE);
            $this->db->where("EC_T_CHART.BUYONE", '0', TRUE);
            $this->db->where('EC_T_CHART.MATNO', $matno, TRUE);
            $this->db->where('EC_T_CHART.CONTRACT_NO', 'PL2017', TRUE);
            $this->db->where("(EC_T_CHART.STATUS_CHART ='8' OR EC_T_CHART.STATUS_CHART ='0' ) ");
            $this->db->update($this->tableCart);
        } else {
            $this->db->where("MATNO", $matno, TRUE);
            $this->db->update('EC_PL_ASSIGN', array('KODE_PENAWARAN' => $kode3));

            $this->db->set('KODE_PENAWARAN', $kodeBaru, FALSE);
            // $this -> db -> where("ID_USER", $ID_USER, TRUE);
            $this->db->where("EC_T_CHART.BUYONE", '0', TRUE);
            $this->db->where('EC_T_CHART.MATNO', $matno, TRUE);
            $this->db->where('EC_T_CHART.CONTRACT_NO', 'PL2017', TRUE);
            $this->db->where("(EC_T_CHART.STATUS_CHART ='8' OR EC_T_CHART.STATUS_CHART ='0' ) ");
            $this->db->update($this->tableCart);
        }
    }

    function insertStok($venno, $matno, $harga, $curr, $deliverytime, $stok, $in_date, $stokc)
    {
        $this->db->select('MAX(STOK_COMMIT)')->from('EC_T_CHART');
        $this->db->join('EC_T_DETAIL_PENAWARAN', 'EC_T_CHART.KODE_PENAWARAN = EC_T_DETAIL_PENAWARAN.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->where("EC_T_DETAIL_PENAWARAN.VENDORNO", $venno, TRUE);
        $this->db->where("EC_T_DETAIL_PENAWARAN.MATNO", $matno, TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $count = $result['MAX(STOK_COMMIT)'];
        if ($stok >= $count) 
            $SQL = "INSERT INTO \"EC_PL_PENAWARAN\" (\"VENDORNO\", \"MATNO\", \"HARGA_PENAWARAN\", \"DELIVERY_TIME\", \"INDATE\", \"CURR\", \"STOK\",\"STOK_COMMIT\") 
                VALUES ('" . $venno . "', '" . $matno . "', '" . $harga . "', '" . $deliverytime . "', TO_DATE('" . $in_date . "', 'yyyy-mm-dd hh24:mi:ss'), '" . $curr . "', '" . $stok . "','" . $count . "')";
        $this->db->query($SQL);
    }

    public function getDetail($matno, $venno)
    {
        $SQL = "SELECT PT.*, TBL.MATNO, TBL.KODE_DETAIL_PENAWARAN, TBL.DELIVERY_TIME, TBL.PRICE, TBL.VENDORNO, TBL.KODE_UPDATE, TBL.DAYS_UPDATE, TBL.LASTUPDATE
            FROM EC_M_PLANT PT 
            LEFT JOIN (SELECT T1.*, T3.KODE_UPDATE, T3.DAYS_UPDATE, TO_CHAR(T1.INDATE, 'DD-MM-YYYY') AS LASTUPDATE
                            FROM EC_T_DETAIL_PENAWARAN T1
                            INNER JOIN (Select MATNO,VENDORNO,PLANT,MAX(INDATE) INDATE from EC_T_DETAIL_PENAWARAN GROUP BY MATNO,VENDORNO,PLANT) T2 
                            ON T1.MATNO=T2.MATNO and T1.VENDORNO=T2.VENDORNO AND T1.PLANT=T2.PLANT AND T1.INDATE=T2.INDATE
                            LEFT JOIN (SELECT PA.* FROM EC_PL_ASSIGN PA WHERE PA.MATNO='" . $matno . "' AND PA.VENDORNO='" . $venno . "') T3 ON T3.MATNO=T1.MATNO AND T3.VENDORNO=T1.VENDORNO
                            
                WHERE T1.MATNO =  '" . $matno . "'
                AND T1.VENDORNO =  '" . $venno . "') TBL ON TBL.PLANT=PT.PLANT
            WHERE PT.STATUS='1'";
        $result = $this->db->query($SQL);
        return (array)$result->result_array();
    }

    public function getDetail_OLD3($matno, $venno)
    {
    	$SQL = "SELECT T1.*, T3.KODE_UPDATE, T3.DAYS_UPDATE, TO_CHAR(T1.INDATE, 'DD-MM-YYYY') AS LASTUPDATE
				FROM EC_T_DETAIL_PENAWARAN T1
				INNER JOIN (Select MATNO,VENDORNO,PLANT,MAX(INDATE) INDATE from EC_T_DETAIL_PENAWARAN GROUP BY MATNO,VENDORNO,PLANT) T2 
				ON T1.MATNO=T2.MATNO and T1.VENDORNO=T2.VENDORNO AND T1.PLANT=T2.PLANT AND T1.INDATE=T2.INDATE
				LEFT JOIN (SELECT PA.* FROM EC_PL_ASSIGN PA WHERE PA.MATNO='" . $matno . "' AND PA.VENDORNO='" . $venno . "') T3 ON T3.MATNO=T1.MATNO AND T3.VENDORNO=T1.VENDORNO
				WHERE T1.MATNO =  '" . $matno . "'
				AND T1.VENDORNO =  '" . $venno . "'";
        $result = $this->db->query($SQL);
        return (array)$result->result_array();
    }

  	public function getDetail_old2($matno, $venno)
    {
    	//$DATE = 'DD/MM/YYYY';
    	$this->db->select('T1.*, T3.KODE_UPDATE, T3.DAYS_UPDATE');
    	//$this->db->select("TO_CHAR(\"T1\".INDATE,'DD/MM/YYYY') AS LASTUPDATE");
        $this->db->from("EC_T_DETAIL_PENAWARAN T1");
        $this->db->join('(Select MATNO,VENDORNO,PLANT,"MAX"(INDATE) INDATE from EC_T_DETAIL_PENAWARAN  GROUP BY MATNO,VENDORNO,PLANT) T2',
            'T1.MATNO=T2.MATNO and T1.VENDORNO=T2.VENDORNO AND T1.PLANT=T2.PLANT AND T1.INDATE=T2.INDATE', 'INNER');
        $this->db->join("(SELECT PA.* FROM EC_PL_ASSIGN PA WHERE PA.MATNO='" . $venno . "' AND PA.VENDORNO='" . $matno . "') T3",
            'T3.MATNO=T1.MATNO AND T3.VENDORNO=T1.VENDORNO', 'left');
        $this->db->where('T1.MATNO', $matno);
        $this->db->where('T1.VENDORNO', $venno);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getDetail_old($matno, $venno)
    {
        $this->db->from("EC_T_DETAIL_PENAWARAN T1");
        $this->db->join('(Select MATNO,VENDORNO,PLANT,"MAX"(INDATE) INDATE from EC_T_DETAIL_PENAWARAN  GROUP BY MATNO,VENDORNO,PLANT) T2',
            'T1.MATNO=T2.MATNO and T1.VENDORNO=T2.VENDORNO AND T1.PLANT=T2.PLANT AND T1.INDATE=T2.INDATE', 'INNER');
        $this->db->where('T1.MATNO', $matno);
        $this->db->where('T1.VENDORNO', $venno);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function saveDetail($matno, $plant, $harga, $deliv, $venno, $curr)
    {
        if($harga==0){
            $SQL = "INSERT INTO \"EC_T_DETAIL_PENAWARAN\"
                VALUES ('" . $plant . "', '" . $matno . "', 0, '0', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'), " . $harga . ", '" . $venno . "', '" . $curr . "')";
        }else{
            $SQL = "INSERT INTO \"EC_T_DETAIL_PENAWARAN\"
                VALUES ('" . $plant . "', '" . $matno . "', 0, " . $deliv . ", TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'), " . $harga . ", '" . $venno . "', '" . $curr . "')";
        }        
        $this->db->query($SQL);

    }

    public function getInfoCountItem($matno, $venno)
    {
        $SQL = "SELECT TB1.*
                FROM (SELECT PT.*, TBL.MATNO, TBL.KODE_DETAIL_PENAWARAN, TBL.DELIVERY_TIME, TBL.PRICE, TBL.VENDORNO, TBL.KODE_UPDATE, TBL.DAYS_UPDATE, TBL.LASTUPDATE
            FROM EC_M_PLANT PT 
            LEFT JOIN (SELECT T1.*, T3.KODE_UPDATE, T3.DAYS_UPDATE, TO_CHAR(T1.INDATE, 'DD-MM-YYYY') AS LASTUPDATE
                            FROM EC_T_DETAIL_PENAWARAN T1
                            INNER JOIN (Select MATNO,VENDORNO,PLANT,MAX(INDATE) INDATE from EC_T_DETAIL_PENAWARAN GROUP BY MATNO,VENDORNO,PLANT) T2 
                            ON T1.MATNO=T2.MATNO and T1.VENDORNO=T2.VENDORNO AND T1.PLANT=T2.PLANT AND T1.INDATE=T2.INDATE
                            LEFT JOIN (SELECT PA.* FROM EC_PL_ASSIGN PA WHERE PA.MATNO='" . $matno . "' AND PA.VENDORNO='" . $venno . "') T3 ON T3.MATNO=T1.MATNO AND T3.VENDORNO=T1.VENDORNO
                            
                WHERE T1.MATNO =  '" . $matno . "'
                AND T1.VENDORNO =  '" . $venno . "') TBL ON TBL.PLANT=PT.PLANT
            WHERE PT.STATUS='1') TB1
            WHERE TB1.PRICE IS NULL OR TB1.PRICE=0";
        $result = $this->db->query($SQL);
        return (array)$result->result_array();
    }
}
//SELECT TB2.* FROM
//(SELECT PEN.VENDORNO, PEN.MATNO, MAX(PEN.INDATE) AS DATE1 FROM EC_PL_PENAWARAN PEN GROUP BY PEN.VENDORNO, PEN.MATNO) TB1
//INNER JOIN EC_PL_PENAWARAN TB2 ON TB1.VENDORNO=TB2.VENDORNO AND TB1.MATNO=TB2.MATNO AND TB1.DATE1=TB2.INDATE
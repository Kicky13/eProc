<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_catalog_produk extends CI_Model
{
    protected $table = 'EC_T_CONTRACT', $tableCC = 'EC_M_COSTCENTER', $tableCart = 'EC_T_CHART', $tableVendor = 'VND_HEADER', $tablePrincipal = 'EC_PRINCIPAL_MANUFACTURER', $tableEC_R1 = 'EC_R1', $tableStrategic = 'EC_M_STRATEGIC_MATERIAL', $tableCompare = 'EC_T_PERBANDINGAN', $tableFeedback = 'EC_FEEDBACK', $tableAssign = 'EC_PL_ASSIGN', $tablePenawaran = 'EC_PL_PENAWARAN', $tablegr = 'EC_GR_MATERIAL';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    public function get_data_checkout($ID_USER)
    {
        $this->db->from($this->table);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        $this->db->join($this->tableCart,
            'EC_T_CHART.MATNO=EC_T_CONTRACT.matno AND EC_T_CHART.CONTRACT_NO=EC_T_CONTRACT."contract_no"', 'left');
        $this->db->where("published", '1', TRUE);
        $this->db->where("ID_USER", $ID_USER, TRUE);
        $this->db->where("EC_T_CHART.BUYONE !=", '1', TRUE);
        // $this -> db -> where("EC_T_CHART.STATUS_CHART !=", '9', TRUE);
        $this->db->where("(EC_T_CHART.STATUS_CHART ='8' OR EC_T_CHART.STATUS_CHART ='0' ) ");
        $this->db->order_by('"contract_no"', 'ASC');
        // $this -> db -> or_where("EC_T_CHART.STATUS_CHART ", '8', TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function get_data_checkout_pl($ID_USER)
    {
        $this->db->from($this->tableCart);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CHART.MATNO=EC_M_STRATEGIC_MATERIAL.MATNR', 'inner');
        $this->db->join('EC_T_DETAIL_PENAWARAN', 'EC_T_CHART.KODE_PENAWARAN=EC_T_DETAIL_PENAWARAN.KODE_DETAIL_PENAWARAN', 'left');
        $this->db->join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'inner');
        $this->db->join('EC_M_COSTCENTER', 'EC_M_COSTCENTER.ID_USER = EC_T_CHART.ID_USER', 'left');
        $this->db->join('(SELECT PLANT,"DESC" NAMA_PLANT FROM EC_M_PLANT) PLN', 'PLN.PLANT = EC_T_DETAIL_PENAWARAN.PLANT', 'inner');
        $this->db->join('(SELECT MATNO,CURRENCY FROM EC_PL_ASSIGN GROUP BY MATNO,CURRENCY) PL', 'PL.MATNO= EC_M_STRATEGIC_MATERIAL.MATNR',
            'inner');
        $this->db->where("EC_T_CHART.ID_USER", $ID_USER, TRUE);
        $this->db->where("EC_T_CHART.BUYONE", '0', TRUE);
        $this->db->where('EC_T_CHART.CONTRACT_NO', 'PL2017', TRUE);
        $this->db->where("(EC_T_CHART.STATUS_CHART ='8' OR EC_T_CHART.STATUS_CHART ='0' ) ");
        $this->db->order_by('EC_T_CHART.STATUS_CHART', 'ASC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function POsuccessOld($data, $kmbl)
    {
        $this->db->where("ID_USER", $data, TRUE);
        $this->db->where("STATUS_CHART", '0', TRUE);
        $kmbl = explode('Standard PO created under the number ', $kmbl);
        $this->db->update($this->tableCart, array('STATUS_CHART' => '1', 'PO_NO' => $kmbl[1]));
    }

    function POfailedOne($id, $cont, $mat, $idcart)
    {
        //$this->db->where("ID_USER", $id, TRUE);
        //$this->db->where("CONTRACT_NO", $cont, TRUE);
        $this->db->where("ID_CHART", $idcart, TRUE);
        //$this->db->where("MATNO", $mat, TRUE);
        //$this->db->where("STATUS_CHART", '0', TRUE);
        //$this->db->where("BUYONE", '1', TRUE);
        $this->db->update($this->tableCart, array('STATUS_CHART' => '7'));
    }

    function POsuccessOne($id, $cont, $mat, $kmbl, $idcart)
    {
        $SQL = "UPDATE EC_T_CONTRACT set \"t_qty\"=\"t_qty\"-(SELECT QTY FROM EC_T_CHART ch WHERE ID_CHART='" . $idcart . "') where \"contract_no\"='" . $cont . "' and \"matno\"='" . $mat . "'";
        $this->db->query($SQL);

        $this->db->where("ID_USER", $id, TRUE);
        $this->db->where("CONTRACT_NO", $cont, TRUE);
        $this->db->where("MATNO", $mat, TRUE);
        $this->db->where("STATUS_CHART", '0', TRUE);
        $this->db->where("BUYONE", '1', TRUE);
        // $kmbl = explode('PO NonStock Lokal SI created under the number ', $kmbl);
        $this->db->update($this->tableCart, array('STATUS_CHART' => '1', 'PO_NO' => $kmbl));
    }

    function InsertApproval($po, $CC, $now)
    {
        $SQL = "SELECT SUM(HARGA) AS TOTAL
                    FROM (SELECT TC.*, PEN.*, (TC.QTY*PEN.PRICE) AS HARGA
                            FROM EC_T_CHART TC
                            INNER JOIN EC_T_DETAIL_PENAWARAN PEN ON TC.KODE_PENAWARAN=PEN.KODE_DETAIL_PENAWARAN
                            WHERE TC.PO_NO='" . $po . "')";
        $result = $this->db->query($SQL);
        $total = $result->row_array();

        $this->db->select('PROGRESS_CNF')->from("EC_PL_CONFIG_APPROVAL");
        $this->db->where("VALUE_FROM<=", $total['TOTAL'], false);
        $this->db->where("VALUE_TO>=", $total['TOTAL'], false);
        //$this->db->where("UK_CODE", $CC['COSTCENTER'], TRUE);
        $this->db->where("UK_CODE", $CC, TRUE);
        $query = $this->db->get();
        $cnf = $query->row_array();
        $PROGRESS_CNF = $cnf['PROGRESS_CNF'];

        $SQL = "SELECT TC.*, PEN.*, (TC.QTY*PEN.PRICE) AS HARGA
                            FROM EC_T_CHART TC
                            INNER JOIN EC_T_DETAIL_PENAWARAN PEN ON TC.KODE_PENAWARAN=PEN.KODE_DETAIL_PENAWARAN
                            WHERE TC.PO_NO='" . $po . "'";

        $data = $this->db->query($SQL);
        $dataa = (array)$data->result_array();

        //$CC['COSTCENTER'];
        $SQL = "INSERT INTO EC_PL_APPROVAL VALUES ( 
            '" . $po . "', '" . $CC . "', '" . $dataa[0]['VENDORNO'] . "', '" . $total['TOTAL'] .
            "', '" . $dataa[0]['CURRENCY'] . "', TO_DATE('" . $now . "', 'dd-mm-yyyy hh24:mi:ss'), " .
            " TO_DATE('" . $now . "', 'dd-mm-yyyy hh24:mi:ss'), 1, 1,'" . $PROGRESS_CNF . "')";
        $this->db->query($SQL);

        $SQL = "INSERT INTO EC_TRACKING_PO VALUES ( 
            '" . $po . "', TO_DATE('" . $now . "', 'dd-mm-yyyy hh24:mi:ss'), 1,null,'" . $this->session->userdata['ID'] . "', '" .
            $this->session->userdata['FULLNAME'] . "')";
        $this->db->query($SQL);

    }

    function insertHeaderGR($pono, $matno,  $line_item,  $qty, $now, $idcart)
    {
        // $this->db->where("ID_CHART", $id_cart, TRUE);
        // $this->db->update($this->tableCart, array('LINE_ITEM' => $line_item));

            $SQL = "INSERT INTO EC_GR_MATERIAL VALUES ( 
            '','" . $pono . "', '" . $matno . "', '" . $line_item . "', '" . $qty .
            "', '0', '1', TO_DATE('" . $now . "', 'dd-mm-yyyy hh24:mi:ss'), " .
            " TO_DATE('" . $now . "', 'dd-mm-yyyy hh24:mi:ss'), '" . $idcart . "')";
        $this->db->query($SQL);

        // $this->db->insert($this->tablegr,
        //         array('PO_NO' => $QTY, 'MATNO' => $CNT, "LINE_ITEM" => $STS, 'QTY_ORDER' => $ONE, 'QTY_SHIPMENT' => $MATNO,
        //             'STATUS' => $USER, 'INDAT' => $DATE, 'KODE_PENAWARAN' => $KODE_PENAWARAN,
        //             'COSCENTER' => $COSCENTER['COSTCENTER']));
    }

    function updateLineItemPO($id_cart, $line_item)
    {
        $this->db->where("ID_CHART", $id_cart, TRUE);
        $this->db->update($this->tableCart, array('LINE_ITEM' => $line_item));
    }

    function getItemforLinePO($po)
    {
        $SQL = "SELECT TC.*, PEN.*, (TC.QTY*PEN.PRICE) AS HARGA
                            FROM EC_T_CHART TC
                            INNER JOIN EC_T_DETAIL_PENAWARAN PEN ON TC.KODE_PENAWARAN=PEN.KODE_DETAIL_PENAWARAN
                            WHERE TC.PO_NO='" . $po . "'";

        $data = $this->db->query($SQL);
        return (array)$data->result_array();
    }

    function POsuccessPL($idc, $kmbl, $qty, $CC = "", $dt = "", $curr = "IDR", $now = "")
    {//'STOK_COMMIT' => $qty,
//        $this->db->trans_start();
        $this->db->where("ID_CHART", $idc, TRUE);
        $kmbl = explode('Pembelian Langsung created under the number ', $kmbl);
        $this->db->update($this->tableCart, array('STATUS_CHART' => '1', 'DATE_BUY' => $now, 'STOK_COMMIT' => $qty, 'PO_NO' => $kmbl[1]));

        /*$this->db->select('PO_NO')->from("EC_PL_APPROVAL");
        $this->db->where("PO_NO", $kmbl[1], false);
        $query = $this->db->get();
        $result = $query->row_array();
        if (isset($result['PO_NO']))
            return "";
        $PRICE = 0;
        $qty = 0;
        foreach ($dt as $val) {
            $PRICE += $val['PRICE'];
            $VENDORNO = $val['VENDORNO'];
            $qty += $val['QTY'];
        }
//        print_r($PRICE);
//        print_r($VENDORNO);
//        print_r($qty);

        $this->db->select('PROGRESS_CNF')->from("EC_PL_CONFIG_APPROVAL");
        $this->db->where("VALUE_FROM<=", $PRICE * $qty, false);
        $this->db->where("VALUE_TO>=", $PRICE * $qty, false);
        //$this->db->where("UK_CODE", $CC['COSTCENTER'], TRUE);
		$this->db->where("UK_CODE", $CC, TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $PROGRESS_CNF = $result['PROGRESS_CNF'];

        //$CC['COSTCENTER'];
        $SQL = "INSERT INTO EC_PL_APPROVAL VALUES ( 
            '" . $kmbl[1] . "', '" . $CC . "', '" . $VENDORNO . "', '" . ($PRICE * $qty) .
            "', '" . $curr . "', TO_DATE('" . $now . "', 'dd-mm-yyyy hh24:mi:ss'), " .
            " TO_DATE('" . $now . "', 'dd-mm-yyyy hh24:mi:ss'), 1, 1,'" . $PROGRESS_CNF . "')";
        $this->db->query($SQL);

        $SQL = "INSERT INTO EC_TRACKING_PO VALUES ( 
            '" . $kmbl[1] . "', TO_DATE('" . $now . "', 'dd-mm-yyyy hh24:mi:ss'), 1,null,'" . $this->session->userdata['ID'] . "', '" .
            $this->session->userdata['FULLNAME'] . "')";
        $this->db->query($SQL);
//        $this->db->trans_complete();*/
    }

    function POfailedPL($idc)
    {
        $this->db->where("ID_CHART", $idc, TRUE);
        $this->db->update($this->tableCart, array('STATUS_CHART' => '7'));
    }

    function POsuccessOnePL($id, $cont, $mat, $kmbl, $idcart, $qty, $CC = "", $data = "", $curr)
    {
//        $qty *= 300000;
        $this->db->where("ID_USER", $id, TRUE);
        $this->db->where("CONTRACT_NO", $cont, TRUE);
        $this->db->where("MATNO", $mat, TRUE);
        $this->db->where("STATUS_CHART", '0', TRUE);
        $this->db->where("BUYONE", '1', TRUE);
        $kmbl = explode('Pembelian Langsung created under the number ', $kmbl);
        $this->db->update($this->tableCart, array('STATUS_CHART' => '1', 'STOK_COMMIT' => $qty, 'PO_NO' => $kmbl[1]));

        $this->db->select('PROGRESS_CNF')->from("EC_PL_CONFIG_APPROVAL");
        $this->db->where("VALUE_FROM<=", $data['PRICE'] * $qty, false);
        $this->db->where("VALUE_TO>=", $data['PRICE'] * $qty, false);
        $this->db->where("UK_CODE", $CC['COSTCENTER'], TRUE);
        $query = $this->db->get();
        // var_dump($query);
        $result = $query->row_array();
        $PROGRESS_CNF = $result['PROGRESS_CNF'];

        $SQL = "INSERT INTO EC_PL_APPROVAL VALUES ( 
            '" . $kmbl[1] . "', '" . $CC['COSTCENTER'] . "', '" . $data['VENDORNO'] . "', '" . ($data['PRICE'] * $qty) .
            "', '" . $curr . "', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'), " .
            " TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'), 1, 1,'" . $PROGRESS_CNF . "')";
        $this->db->query($SQL);

        $SQL = "INSERT INTO EC_TRACKING_PO VALUES ( 
            '" . $kmbl[1] . "', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'), 1,null,'" . $id . "', '" .
            $this->session->userdata['FULLNAME'] . "')";
        $this->db->query($SQL);
    }

    function POsuccess($data, $kmbl, $cntrk)
    {
        $this->db->from($this->tableCart);
        $this->db->where("ID_USER", $data, TRUE);
        $this->db->where("STATUS_CHART", '0', TRUE);
        $this->db->where("CONTRACT_NO", $cntrk, TRUE);

        $result = $this->db->get();
        $hasil = (array)$result->result_array();
        if ($cntrk != 'PL2017')
            foreach ($hasil as $value) {
                $SQL = "UPDATE EC_T_CONTRACT set \"t_qty\"=\"t_qty\"-(SELECT QTY FROM EC_T_CHART ch WHERE ID_CHART='" . $value['ID_CHART'] . "') where \"contract_no\"='" . $value['CONTRACT_NO'] . "' and \"matno\"='" . $value['MATNO'] . "'";
                $this->db->query($SQL);
            }

        $this->db->where("ID_USER", $data, TRUE);
        $this->db->where("STATUS_CHART", '0', TRUE);
        $this->db->where("CONTRACT_NO", $cntrk, TRUE);
        // $kmbl = explode('Standard PO created under the number ', $kmbl);
        $this->db->update($this->tableCart, array('STATUS_CHART' => '1', 'PO_NO' => $kmbl));
    }

    public function get_data_checkout_PO($ID_USER)
    {
        $this->db->from($this->table);
        //EC_T_CONTRACT
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        $this->db->join($this->tableCart,
            'EC_T_CHART.MATNO=EC_T_CONTRACT.matno AND EC_T_CHART.CONTRACT_NO=EC_T_CONTRACT."contract_no"', 'left');
        $this->db->where("published", '1', TRUE);
        $this->db->where("ID_USER", $ID_USER, TRUE);
        $this->db->where("EC_T_CHART.STATUS_CHART ", '0', TRUE);
        $this->db->where("EC_T_CHART.BUYONE ", '0', TRUE);
        // $this -> db -> order_by('matno', 'ASC');get_data_checkout_pl
        // $this -> db -> or_where("EC_T_CHART.STATUS_CHART ", '8', TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getVndConfirm($matno = '623-202883')
    {
        $SQL = "SELECT
			TB2.*
		FROM
			(
				SELECT
					PEN.VENDORNO,
					PEN.MATNO,
					MAX (PEN.INDATE) AS DATE1
				FROM
					EC_PL_PENAWARAN PEN
				GROUP BY
					PEN.VENDORNO,
					PEN.MATNO
			) TB1
		INNER JOIN EC_PL_PENAWARAN TB2 ON TB1.VENDORNO = TB2.VENDORNO
		AND TB1.MATNO = TB2.MATNO
		AND TB1.DATE1 = TB2.INDATE
		WHERE
			TB2.MATNO = '" . $matno . "'
		AND HARGA_PENAWARAN > 0
		AND STOK > 0
		ORDER BY HARGA_PENAWARAN DESC";
        $result = $this->db->query($SQL);
        return (array)$result->result_array();
    }

    public function getVndConfirm2($matno = '603-200850', $plant = '2702')
    {
        $SQL = "SELECT
                TB2.MATNO,
                SM.MAKTX,
                TB2.STOK,
                TB2.VENDORNO,
                TB2.STOK_COMMIT,
                DT3.PLANT,
                PLN.NAMA_PLANT,
                DT3.KODE_DETAIL_PENAWARAN,
                DT3.DELIVERY_TIME,
                DT3.INDATE,
                DT3.PRICE,
                VND.VENDOR_NAME
            FROM
                (
                    SELECT
                        PEN.VENDORNO,
                        PEN.MATNO,
                        MAX (PEN.INDATE) AS DATE1
                    FROM
                        EC_PL_PENAWARAN PEN
                    WHERE
                        MATNO = '" . $matno . "'
                    GROUP BY
                        PEN.VENDORNO,
                        PEN.MATNO
                ) TB1
            INNER JOIN EC_PL_PENAWARAN TB2 ON TB1.VENDORNO = TB2.VENDORNO
            AND TB1.MATNO = TB2.MATNO
            AND TB1.DATE1 = TB2.INDATE 
            LEFT JOIN (
                SELECT
                    DT2.*
                FROM
                    (
                        SELECT
                            PEN.VENDORNO,
                            PEN.MATNO,
                            PEN.PLANT,
                            MAX (PEN.INDATE) AS DATE1
                        FROM
                            EC_T_DETAIL_PENAWARAN PEN
                        WHERE
                            MATNO = '" . $matno . "'
                        AND PLANT = '" . $plant . "'
                        GROUP BY
                            PEN.VENDORNO,
                            PEN.MATNO,
                            PEN.PLANT
                    ) DT1
                INNER JOIN EC_T_DETAIL_PENAWARAN DT2 ON DT1.VENDORNO = DT2.VENDORNO
                AND DT1.MATNO = DT2.MATNO
                AND DT1.DATE1 = DT2.INDATE
                WHERE
                    DT2.MATNO = '" . $matno . "'
                AND DT2.PLANT = '" . $plant . "'
            ) DT3 ON DT3.MATNO = TB2.MATNO
            AND DT3.VENDORNO = TB2.VENDORNO
            INNER JOIN EC_M_STRATEGIC_MATERIAL SM ON TB1.MATNO=SM.MATNR
            INNER JOIN (SELECT PLANT,\"DESC\" NAMA_PLANT FROM EC_M_PLANT) PLN ON PLN.PLANT = DT3.PLANT
            INNER JOIN VND_HEADER VND ON TB2.VENDORNO=VND.VENDOR_NO
            WHERE
                TB2.MATNO = '" . $matno . "'
                AND TB2.STOK > 0
            ORDER BY
                DT3.PRICE ASC";
        $result = $this->db->query($SQL);
        return (array)$result->result_array();
    }

    public function get_data_checkout_PO_PL($ID_USER)
    {
        $this->db->from($this->tableCart);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CHART.MATNO = EC_M_STRATEGIC_MATERIAL.MATNR', 'inner');
        $this->db->join('EC_T_DETAIL_PENAWARAN', 'EC_T_CHART.KODE_PENAWARAN = EC_T_DETAIL_PENAWARAN.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->join('(SELECT PLANT,"DESC" NAMA_PLANT FROM EC_M_PLANT) PLN', 'PLN.PLANT = EC_T_DETAIL_PENAWARAN.PLANT', 'inner');
        $this->db->where("PUBLISHED_LANGSUNG", '1', TRUE);
        $this->db->where("ID_USER", $ID_USER, TRUE);
        $this->db->where("EC_T_CHART.STATUS_CHART ", '0', TRUE);
        $this->db->where("EC_T_CHART.BUYONE ", '0', TRUE);
        $this->db->order_by('VENDORNO', 'ASC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function get_item_checkout_PL($ID_USER)
    {
        $this->db->from($this->tableCart);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CHART.MATNO = EC_M_STRATEGIC_MATERIAL.MATNR', 'inner');
        $this->db->join('EC_T_DETAIL_PENAWARAN', 'EC_T_CHART.KODE_PENAWARAN = EC_T_DETAIL_PENAWARAN.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->join('(SELECT PLANT,"DESC" NAMA_PLANT FROM EC_M_PLANT) PLN', 'PLN.PLANT = EC_T_DETAIL_PENAWARAN.PLANT', 'inner');
        $this->db->where("PUBLISHED_LANGSUNG", '1', TRUE);
        $this->db->where("ID_USER", $ID_USER, TRUE);
        $this->db->where("EC_T_CHART.STATUS_CHART ", '0', TRUE);
        $this->db->where("EC_T_CHART.BUYONE ", '0', TRUE);
        $this->db->order_by('ID_CHART', 'ASC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }
	
    public function get_data_checkout_PO_One($ID_USER, $contract_no, $matno)
    {
        $this->db->from($this->table);
        //EC_T_CONTRACT
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        $this->db->join($this->tableCart,
            'EC_T_CHART.MATNO=EC_T_CONTRACT.matno AND EC_T_CHART.CONTRACT_NO=EC_T_CONTRACT."contract_no"', 'left');
        $this->db->where("published", '1', TRUE);
        $this->db->where("ID_USER", $ID_USER, TRUE);
        $this->db->where('EC_T_CONTRACT."contract_no"', $contract_no, TRUE);
        $this->db->where('EC_T_CONTRACT.matno', $matno, TRUE);
        $this->db->where("EC_T_CHART.STATUS_CHART ", '0', TRUE);
        $this->db->where("EC_T_CHART.BUYONE ", '1', TRUE);
        // $this -> db -> order_by('matno', 'ASC');
        // $this -> db -> or_where("EC_T_CHART.STATUS_CHART ", '8', TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function get_data_checkout_PO_One_PL($ID_USER, $contract_no, $matno)
    {
        //EC_PL_PENAWARAN KODE_PENAWARAN
        $this->db->from($this->tableCart);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CHART.MATNO = EC_M_STRATEGIC_MATERIAL.MATNR', 'inner');
        // $this->db->join('EC_PL_PENAWARAN', 'EC_T_CHART.KODE_PENAWARAN = EC_PL_PENAWARAN.KODE_PENAWARAN', 'inner');
        $this->db->join('EC_T_DETAIL_PENAWARAN', 'EC_T_CHART.KODE_PENAWARAN = EC_T_DETAIL_PENAWARAN.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->where("PUBLISHED_LANGSUNG", '1', TRUE);
        $this->db->where("ID_USER", $ID_USER, TRUE);
        $this->db->where("EC_T_CHART.STATUS_CHART ", '0', TRUE);
        $this->db->where("EC_T_CHART.BUYONE ", '1', TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function get_data_checkout_after_PO($data)
    {
        $this->db->from($this->table);
        $this->db->select('"EC_T_CONTRACT"."contract_no" contract_no, "EC_T_CONTRACT"."matno" MATNO,"curr","netprice", MAKTX, PO_NO,"EC_T_CHART"."QTY" QTY',
            false);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        $this->db->join($this->tableCart,
            'EC_T_CHART.MATNO=EC_T_CONTRACT.matno AND EC_T_CHART.CONTRACT_NO=EC_T_CONTRACT."contract_no"', 'left');
        for ($i = 0; $i < sizeof($data); $i++) {
            $this->db->or_where("EC_T_CHART.ID_CHART", $data[$i]['ID_CHART'], TRUE);
        }
        $this->db->order_by('"EC_T_CONTRACT"."contract_no" ASC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function get_data_checkout_after_PO_PL($data)
    {
        $this->db->from($this->table);
        $this->db->select('"EC_T_CONTRACT"."contract_no" contract_no, "EC_T_CONTRACT"."matno" MATNO,"curr","netprice", MAKTX, PO_NO',
            false);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        $this->db->join($this->tableCart,
            'EC_T_CHART.MATNO=EC_T_CONTRACT.matno AND EC_T_CHART.CONTRACT_NO=EC_T_CONTRACT."contract_no"', 'left');
        for ($i = 0; $i < sizeof($data); $i++) {
            $this->db->or_where("EC_T_CHART.ID_CHART", $data[$i]['ID_CHART'], TRUE);
        }
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function get_data_harga($min, $max, $minLim = 0, $maxLim = 12, $kode = '')
    {
        if ($minLim == 0) {
            $this->db->limit(13);
        } else
            $this->db->where("ROWNUM <=", $maxLim, false);

        $temp = $min;
        if ($max < $min) {
            $min = $max;
            $max = $temp;
        }

        $this->db->from($this->table);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        $this->db->join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'left');
        $this->db->where('published =1 and "netprice" >=' . $min . ' and "netprice" <=' . $max . '');
        $this->db->where('(KODE_USER like \'' . $kode . '%\'  OR (lower(TAG) like lower(\'%' . $kode . '%\') OR lower(MAKTX) like lower(\'%' . $kode . '%\') OR lower(MATNR) like \'%' . $kode . '%\' OR lower("vendorname") like lower(\'%' . $kode . '%\') ) )');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function get_data_tag($kode, $min = 0, $max = 12)
    {
        if ($min == 0) {
            $this->db->limit(13);
        } else
            $this->db->where("ROWNUM <=", $max, false);

        $this->db->from($this->table);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        $this->db->join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'left');
        $this->db->join('EC_PRINCIPAL_MANUFACTURER', 'EC_PRINCIPAL_MANUFACTURER.PC_CODE = EC_R1.PC_CODE', 'left');
        $this->db->where('published =1 and "plant" IN (SELECT RL.PLANT FROM EC_M_ROLE_PLANT RL WHERE RL.COMPANY= \''. $this->session->userdata['COMPANYID'] .'\') and (lower(TAG) like lower(\'%' . $kode . '%\') OR lower(MAKTX) like lower(\'%' . $kode . '%\') OR lower(MATNR) like lower(\'%' . $kode . '%\') OR lower("vendorname") like lower(\'%' . $kode . '%\'))');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function get_history_PO_header($USER_ID = '')
    {
        // $tableCart
        $this->db->select('PO_NO', false);
        $this->db->from($this->tableCart);
        $this->db->where("ID_USER", $USER_ID, TRUE);
        $this->db->where("PO_NO IS NOT NULL");
        $this->db->where('CONTRACT_NO !=', 'PL2017', true);
        $this->db->group_by(array("PO_NO"));
        $this->db->order_by("PO_NO DESC");
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function get_history_PO_headerOLD($USER_ID = '')
    {
        // $tableCart
        $this->db->from($this->tableCart);
        $this->db->select('PO_NO,DATE_BUY,"contract_no","vendorno","vendorname"', false);
        $this->db->join("EC_T_CONTRACT",
            'EC_T_CHART.MATNO=EC_T_CONTRACT.matno AND EC_T_CHART.CONTRACT_NO=EC_T_CONTRACT."contract_no"', 'left');
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CHART.MATNO = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->where("ID_USER", $USER_ID, TRUE);
        $this->db->where("PO_NO IS NOT NULL");
        $this->db->group_by(array("PO_NO", "DATE_BUY", "contract_no", "vendorno", "vendorname"));
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getPlant($company = '')
    {
        $this->db->from('ADM_PLANT');
        $this->db->where("COMPANY_ID", $company, TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function get_history_PO($USER_ID = '')
    {
        // $tableCart
        $this->db->from($this->tableCart);
        $this->db->join("EC_T_CONTRACT",
            'EC_T_CHART.MATNO=EC_T_CONTRACT.matno AND EC_T_CHART.CONTRACT_NO=EC_T_CONTRACT."contract_no"', 'left');
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CHART.MATNO = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->where("ID_USER", $USER_ID, TRUE);
        $this->db->where("PO_NO IS NOT NULL");
        $this->db->where('CONTRACT_NO !=', 'PL2017', true);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function get_data_category($kode, $min = 0, $max = 12, $COMPANY_ID)
    {
        if ($min == 0) {
            $this->db->limit(13);
        } else
            $this->db->where("ROWNUM <=", $max, false);

        $this->db->from($this->table);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        $this->db->join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'left');
        $this->db->join('EC_PRINCIPAL_MANUFACTURER', 'EC_PRINCIPAL_MANUFACTURER.PC_CODE = EC_R1.PC_CODE', 'left');
        $this->db->where('published =1 and "plant" IN (SELECT RL.PLANT FROM EC_M_ROLE_PLANT RL WHERE RL.COMPANY= \''. $COMPANY_ID .'\') and KODE_USER like \'' . $kode . '%\'');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getPage($COMPANY_ID)
    {
        $this->db->from($this->table);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        $this->db->join('EC_M_CATEGORY', 'EC_M_STRATEGIC_MATERIAL.ID_CAT = EC_M_CATEGORY.ID_CAT', 'left');
        $this->db->where("published = 1 and \"plant\" IN (SELECT RL.PLANT FROM EC_M_ROLE_PLANT RL WHERE RL.COMPANY= ". $COMPANY_ID .")");
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getVendor($vendorno)
    {
        $this->db->from($this->tableVendor);
        $this->db->join('ADM_WILAYAH', 'VND_HEADER.ADDRESS_CITY = ADM_WILAYAH.ID', 'left');
        $this->db->join('ADM_COUNTRY', 'VND_HEADER.ADDRESS_COUNTRY = ADM_COUNTRY.COUNTRY_CODE', 'left');
        $this->db->where("VENDOR_NO", $vendorno, TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getPrincipal($PC_CODE)
    {
        $this->db->from($this->tablePrincipal);
        //$this -> db -> join('ADM_WILAYAH', 'VND_HEADER.ADDRESS_CITY = ADM_WILAYAH.ID', 'left');
        //$this -> db -> join('ADM_COUNTRY', 'VND_HEADER.ADDRESS_COUNTRY = ADM_COUNTRY.COUNTRY_CODE', 'left');
        $this->db->where("PC_CODE", $PC_CODE, TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function hapus_compare($id = '', $matno, $kontrak)
    {
        $this->db->where("MATNO", $matno, TRUE);
        $this->db->where("ID_USER", $id, TRUE);
        $this->db->where("CONTRACT_NO", $kontrak, TRUE);
        $this->db->delete($this->tableCompare);
    }

    public function hapus_compare_pl($id = '', $matno, $kode)
    {
        $this->db->where("MATNO", $matno, TRUE);
        $this->db->where("ID_USER", $id, TRUE);
        $this->db->where("CONTRACT_NO", 'PL2017', TRUE);
        $this->db->where("KODE_DETAIL_PENAWARAN", $kode, TRUE);
        $this->db->delete($this->tableCompare);
    }

    function deleteCart($data)
    {
        $this->db->where("ID_CHART", $data, TRUE);
        $this->db->delete($this->tableCart);
    }

    function cancelCart($data)
    {
        $this->db->where("ID_CHART", $data, TRUE);
        $this->db->update($this->tableCart, array('STATUS_CHART' => '8'));
    }

    function plsqtyCart($data)
    {
        $this->db->set('QTY', 'QTY+1', FALSE);
        $this->db->where("ID_CHART", $data, TRUE);
        $this->db->update($this->tableCart);
    }

    function minqtyCart($data)
    {
        $this->db->set('QTY', 'QTY+(-1)', FALSE);
        $this->db->where("ID_CHART", $data, TRUE);
        $this->db->update($this->tableCart);
    }

    function updQtyCart($id, $qty)
    {
        $this->db->set('QTY', $qty, FALSE);
        $this->db->where("ID_CHART", $id, TRUE);
        $this->db->update($this->tableCart);
    }

    function readdCart($data)
    {
        $this->db->where("ID_CHART", $data, TRUE);
        $this->db->update($this->tableCart, array('STATUS_CHART' => '0'));
    }

    function rangeHarga($data)
    {
        $this->db->select('MAX("netprice") max,MIN("netprice") min');
        $this->db->where("published", "1", TRUE);
        $this->db->from($this->table);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    public function getPartner($PC_CODE)
    {
        $this->db->from($this->tableEC_R1);
        $this->db->join('VND_HEADER', 'VND_HEADER.VENDOR_NO = EC_R1.VENDOR_ID', 'left');
        //$this -> db -> join('ADM_COUNTRY', 'VND_HEADER.ADDRESS_COUNTRY = ADM_COUNTRY.COUNTRY_CODE', 'left');
        $this->db->where("PC_CODE", $PC_CODE, TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function history_pl($userid)
    {
        $this->db->select('EC_T_CHART.PO_NO NOMERPO,EC_T_CHART.*,EC_M_STRATEGIC_MATERIAL.MAKTX,EC_TRACKING_PO.*,TO_CHAR(INDATE , \'DD/MM/YYYY hh24:mi:ss\' ) AS LAST_UPD',
            false);
        $this->db->from($this->tableCart);
        $this->db->join('(SELECT P1.* FROM EC_TRACKING_PO P1 INNER JOIN (SELECT PO_NO,MAX(INDATE) DATE1 FROM EC_TRACKING_PO GROUP BY PO_NO) P2 ON P1.PO_NO=P2.PO_NO AND P1.INDATE=P2.DATE1)EC_TRACKING_PO',
            'EC_TRACKING_PO.PO_NO = EC_T_CHART.PO_NO', 'left');
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CHART.MATNO = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->where("EC_T_CHART.ID_USER", $userid, TRUE);
        $this->db->where("STATUS_CHART", "1", TRUE);
        $this->db->where("EC_T_CHART.PO_NO IS NOT NULL");
        $this->db->where("CONTRACT_NO", "PL2017", TRUE);
        $this->db->order_by('ID_CHART DESC,INDATE DESC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function tracking_po_pl($pono)
    {
        $this->db->select('EC_TRACKING_PO.*,TO_CHAR(INDATE , \'DD/MM/YYYY hh24:mi:ss\' ) AS LAST_UPD', false);
        $this->db->from('EC_TRACKING_PO');
        $this->db->where("PO_NO", $pono, TRUE);
        $this->db->order_by('INDATE ASC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getKategoriProduk($kode)
    {
        $this->db->from($this->tableStrategic);
        $this->db->join('EC_T_CONTRACT', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        $this->db->join('EC_M_CATEGORY', 'EC_M_STRATEGIC_MATERIAL.ID_CAT = EC_M_CATEGORY.ID_CAT', 'left');
        //$this -> db -> join('ADM_COUNTRY', 'VND_HEADER.ADDRESS_COUNTRY = ADM_COUNTRY.COUNTRY_CODE', 'left');
        $this->db->where("KODE_USER like '" . $kode . "%' and published='1'");
        //$this -> db -> where("published", '1', TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getPebandingan($id_user)
    {
        $this->db->from($this->tableCompare);
        $this->db->join('EC_T_CONTRACT',
            'EC_T_CONTRACT.contract_no=EC_T_PERBANDINGAN.CONTRACT_NO AND EC_T_CONTRACT."matno"=EC_T_PERBANDINGAN.MATNO',
            'left');
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_M_STRATEGIC_MATERIAL.MATNR = EC_T_CONTRACT.matno', 'left');
        $this->db->join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        $this->db->join('EC_PRINCIPAL_MANUFACTURER', 'EC_PRINCIPAL_MANUFACTURER.PC_CODE = EC_R1.PC_CODE', 'left');
        $this->db->where("EC_T_PERBANDINGAN.ID_USER", $id_user, TRUE);
        $this->db->where("EC_T_CONTRACT.published", "1", TRUE);
        $this->db->order_by('NO_URUT ASC');
        //$this -> db -> where("published", '1', TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getPebandingan_lgsg($id_user, $CONTRACT_NO)
    {
        /*$SQL = "SELECT BD.*, SM.*, (SELECT MIN (PEN.HARGA_PENAWARAN)
					FROM EC_PL_PENAWARAN PEN
					WHERE PEN.MATNO = BD.MATNO
				) AS HARGA_PENAWARAN,
				(SELECT PEN.CURR
					FROM EC_PL_PENAWARAN PEN
					WHERE PEN.MATNO = BD.MATNO GROUP BY PEN.CURR
				) AS PENAWARAN_CURR,
				(SELECT PEN.KODE_PENAWARAN
					FROM EC_PL_ASSIGN PEN
					WHERE PEN.MATNO = BD.MATNO
					GROUP BY KODE_PENAWARAN
				) AS KODE_PENAWARAN
			FROM EC_T_PERBANDINGAN BD
			INNER JOIN EC_M_STRATEGIC_MATERIAL SM ON BD.MATNO=SM.MATNR
			WHERE BD.CONTRACT_NO='" . $CONTRACT_NO . "' AND BD.ID_USER='" . $id_user . "' ORDER BY BD.NO_URUT";*/
        // '" . $ptm . "'
        $SQL = "SELECT BD.*,DP.DELIVERY_TIME,DP.PRICE,PL.\"DESC\",SM.PICTURE,SM.MAKTX,SM.MEINS,TB1.CURRENCY
                    FROM EC_T_PERBANDINGAN BD
                    INNER JOIN EC_T_DETAIL_PENAWARAN DP ON BD.KODE_DETAIL_PENAWARAN=DP.KODE_DETAIL_PENAWARAN
                    INNER JOIN EC_M_STRATEGIC_MATERIAL SM ON BD.MATNO=SM.MATNR
                    INNER JOIN EC_M_PLANT PL ON DP.PLANT=PL.PLANT
                    INNER JOIN (SELECT PEN.CURRENCY, PEN.MATNO FROM EC_PL_ASSIGN PEN GROUP BY PEN.CURRENCY,PEN.MATNO) TB1 ON BD.MATNO=TB1.MATNO
                    WHERE BD.CONTRACT_NO='" . $CONTRACT_NO . "' AND BD.ID_USER='" . $id_user . "'
                    ORDER BY BD.NO_URUT ASC";
        $result = $this->db->query($SQL);
        return (array)$result->result_array();

        // $this -> db -> from($this -> tableCompare);
        // //$this -> db -> join('EC_T_CONTRACT', 'EC_T_CONTRACT.contract_no=EC_T_PERBANDINGAN.CONTRACT_NO AND EC_T_CONTRACT."matno"=EC_T_PERBANDINGAN.MATNO', 'left');
        // $this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_M_STRATEGIC_MATERIAL.MATNR = EC_T_PERBANDINGAN.MATNO', 'left');
        // //$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        // //$this -> db -> join('EC_PRINCIPAL_MANUFACTURER', 'EC_PRINCIPAL_MANUFACTURER.PC_CODE = EC_R1.PC_CODE', 'left');
        // $this -> db -> where("EC_T_PERBANDINGAN.ID_USER", $id_user, TRUE);
        // $this -> db -> where("EC_T_PERBANDINGAN.CONTRACT_NO", $CONTRACT_NO, TRUE);
        // //$this -> db -> where("EC_T_CONTRACT.published", "1", TRUE);
        // $this -> db -> order_by('NO_URUT ASC');
        // //$this -> db -> where("published", '1', TRUE);
        // $result = $this -> db -> get();
        // return (array)$result -> result_array();
    }

    function getLongteks($ptm)
    {
        // $this -> db -> from($this -> table);
        // $this -> db -> where('MATNR', $ptm);
        // $result = $this -> db -> get();

        // if ($result -> num_rows() > 1) {
        $SQL = "SELECT SUBSTR (SYS_CONNECT_BY_PATH (ES.TDLINE , '<br />&nbsp&nbsp'), 17) LNGTX FROM (SELECT ER.*, ROW_NUMBER () OVER (ORDER BY TO_NUMBER(NO)) RN, COUNT (*) OVER () CNT FROM EC_M_LONGTEXT ER WHERE ER.MATNR =  '" . $ptm . "') ES LEFT JOIN EC_M_STRATEGIC_MATERIAL SM on ES.MATNR=SM.MATNR WHERE RN = CNT START WITH RN = 1 CONNECT BY RN = PRIOR RN + 1";
        // '" . $ptm . "'
        $result = $this->db->query($SQL);
        // }
        return (array)$result->result_array();
    }

    function simpanCC($USER, $CC)
    {
        $this->db->select('COSTCENTER')->from($this->tableCC)->where(array('ID_USER' => $USER));
        $query = $this->db->get();
        $result = $query->row_array();
        $xpl = explode(":", $CC);
        if (isset ($result['COSTCENTER'])) {
            $this->db->set('COSTCENTER', $xpl[0]);
            $this->db->set('CC_NAME', $xpl[1]);
            $this->db->where(array('ID_USER' => $USER));
            $this->db->update($this->tableCC);
        } else {
            $this->db->insert($this->tableCC,
                array('ID_USER' => $USER, 'COSTCENTER' => $xpl[0], "CC_NAME" => $xpl[1]));
        }
    }

    function getCC($USER)
    {
        $this->db->select('COSTCENTER,CC_NAME')->from($this->tableCC)->where(array('ID_USER' => $USER));
        $query = $this->db->get();
        $result = $query->row_array();
        return isset ($result) ? $result : "";
    }

    public function addCart($MATNO, $CNT, $USER, $DATE, $KODE_PENAWARAN, $COSCENTER, $QTY = 0, $ONE = 0, $STS = 0)
    {
        if ($ONE == 0) {
            $this->db->select('COUNT(*)')->from($this->tableCart)->where(array('CONTRACT_NO' => $CNT, 'BUYONE' => 0,
                'MATNO' => $MATNO, 'ID_USER' => $USER));
            $this->db->where("(STATUS_CHART = 0 or STATUS_CHART = 8 )");
            if ($CNT == 'PL2017')
			{
				$this->db->where("KODE_PENAWARAN", $KODE_PENAWARAN);
				//$this->db->where("PO_NO is null");
			}
                
            $query = $this->db->get();
            $result = $query->row_array();
            $count = $result['COUNT(*)'];
            if ($count > 0) {
                $this->db->set('QTY', 'QTY+(1)', FALSE); 
                if ($CNT == 'PL2017')
                    $this->db->where(array('CONTRACT_NO' => $CNT, 'BUYONE' => 0, 'MATNO' => $MATNO, 'ID_USER' => $USER,'PO_NO'=>'NULL',
                        'KODE_PENAWARAN' => $KODE_PENAWARAN));
                else
                    $this->db->where(array('CONTRACT_NO' => $CNT, 'BUYONE' => 0, 'MATNO' => $MATNO, 'ID_USER' => $USER));
                $this->db->update($this->tableCart);
            } else {
                $this->db->insert($this->tableCart,
                    array('CONTRACT_NO' => $CNT, "STATUS_CHART" => $STS, 'BUYONE' => $ONE, 'MATNO' => $MATNO,'QTY' => $QTY,
                        'ID_USER' => $USER, 'DATE_BUY' => $DATE, 'KODE_PENAWARAN' => $KODE_PENAWARAN,
                        'COSCENTER' => $COSCENTER));
            }
        } else {
            $this->db->insert($this->tableCart,
                array('QTY' => $QTY, 'CONTRACT_NO' => $CNT, "STATUS_CHART" => $STS, 'BUYONE' => $ONE, 'MATNO' => $MATNO,
                    'ID_USER' => $USER, 'DATE_BUY' => $DATE, 'KODE_PENAWARAN' => $KODE_PENAWARAN,
                    'COSCENTER' => $COSCENTER['COSTCENTER']));
        }
        if ($CNT != 'PL2017')
            $this->db->join('EC_T_CONTRACT',
                'EC_T_CHART.MATNO=EC_T_CONTRACT.matno AND EC_T_CHART.CONTRACT_NO="EC_T_CONTRACT"."contract_no"',
                'left');
        $this->db->select('COUNT(*)')->from($this->tableCart)->where("ID_USER", $USER,
            TRUE)->where("(EC_T_CHART.STATUS_CHART ='8' OR EC_T_CHART.STATUS_CHART ='0' )");
        if ($CNT != 'PL2017')
            $this->db->where("EC_T_CONTRACT.published", "1", TRUE);
        $this->db->where("EC_T_CHART.BUYONE !=", '1', TRUE);
        if ($CNT == 'PL2017')
            $this->db->where("EC_T_CHART.CONTRACT_NO", 'PL2017', TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $count = $result['COUNT(*)'];
        return $count;
    }

    public function getAllCount($tbl = 'EC_T_CONTRACT', $val1 = '', $val2 = '')
    {
        if ($tbl == 'tag') {
            $this->db->select('COUNT(*)');
            $this->db->from($this->table);
            $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
            $this->db->join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
            $this->db->join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'left');
            $this->db->where('published =1 and "plant" IN (SELECT RL.PLANT FROM EC_M_ROLE_PLANT RL WHERE RL.COMPANY= \''. $this->session->userdata['COMPANYID'] .'\') and (lower(TAG) like lower(\'%' . $val1 . '%\') OR lower(MAKTX) like lower(\'%' . $val1 . '%\') OR lower("vendorname") like lower(\'%' . $val1 . '%\'))');

        } else if ($tbl == 'harga') {
            $this->db->select('COUNT(*)');
            $this->db->from($this->table);
            $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
            $this->db->join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
            $this->db->join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'left');
            $this->db->where('published =1 and "netprice" >=' . $val1 . ' and "netprice" <=' . $val2 . '');

        } else if ($tbl == 'cat') {
            $this->db->select('COUNT(*)');
            $this->db->from($this->table);
            $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
            $this->db->join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
            $this->db->join('EC_M_CATEGORY', 'EC_M_CATEGORY.ID_CAT = EC_M_STRATEGIC_MATERIAL.ID_CAT', 'left');
            $this->db->where('published =1 and "plant" IN (SELECT RL.PLANT FROM EC_M_ROLE_PLANT RL WHERE RL.COMPANY= \''. $this->session->userdata['COMPANYID'] .'\') and KODE_USER like \'' . $val1 . '%\'');

        } else {
            $this->db->select('COUNT(*)')->from($tbl);
            $this->db->where("published", '1', TRUE);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        $count = $result['COUNT(*)'];

        return $count;
    }

    public function getUserCategory($USER, $idcat)
    {
        $this->db->select('EC_USER_CATEGORY.ID_CAT', false);
        $this->db->from('EC_USER_CATEGORY');
        $this->db->where("ID_USER", $USER, TRUE);
        $this->db->where("ID_CAT", $idcat, TRUE);
        // $this->db->order_by('INDATE ASC');
        $result = $this->db->get();
        // return (array)$result->result_array();
        return $result->num_rows;
    }

    public function getCartCount($USER, $DATE)
    {
        $this->db->select('COUNT(STATUS_CHART)')->from($this->tableCart)->where("ID_USER", $USER, TRUE);
        $this->db->join('EC_T_CONTRACT',
            'EC_T_CONTRACT.contract_no=EC_T_CHART.CONTRACT_NO AND EC_T_CONTRACT."matno"=EC_T_CHART.MATNO', 'left');
        $this->db->where("(EC_T_CHART.STATUS_CHART ='8' OR EC_T_CHART.STATUS_CHART ='0' ) ");
        $this->db->where("EC_T_CONTRACT.published", "1", TRUE);
        $this->db->where("BUYONE", "0", TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $count = $result['COUNT(STATUS_CHART)'];
        return $count;
    }

    public function getCartCount_pl($USER, $DATE, $CONTRACT_NO)
    {
        $this->db->select('COUNT(STATUS_CHART)')->from($this->tableCart)->where("ID_USER", $USER, TRUE);
        // $this -> db -> join('EC_T_CONTRACT', 'EC_T_CONTRACT.contract_no=EC_T_CHART.CONTRACT_NO AND EC_T_CONTRACT."matno"=EC_T_CHART.MATNO', 'left');
        $this->db->where("(EC_T_CHART.STATUS_CHART ='8' OR EC_T_CHART.STATUS_CHART ='0' ) ");
        // $this -> db -> where("EC_T_CONTRACT.published", "1", TRUE);
        $this->db->where("CONTRACT_NO", $CONTRACT_NO, TRUE);
        $this->db->where("BUYONE", "0", TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $count = $result['COUNT(STATUS_CHART)'];
        return $count;
    }

    public function getCompareCount($USER)
    {
        $this->db->select('COUNT(*)')->from($this->tableCompare)->where("ID_USER", $USER, TRUE);
        $this->db->join('EC_T_CONTRACT',
            'EC_T_CONTRACT.contract_no=EC_T_PERBANDINGAN.CONTRACT_NO AND EC_T_CONTRACT."matno"=EC_T_PERBANDINGAN.MATNO',
            'left');
        $this->db->where("EC_T_CONTRACT.published", "1", TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $count = $result['COUNT(*)'];
        return $count;
    }

    public function getCompareCount_pl($USER, $CONTRACT_NO)
    {
        $this->db->select('COUNT(*)')->from($this->tableCompare)->where("ID_USER", $USER, TRUE);
        $this->db->where("CONTRACT_NO", $CONTRACT_NO, TRUE);
        //$this -> db -> join('EC_T_CONTRACT', 'EC_T_CONTRACT.contract_no=EC_T_PERBANDINGAN.CONTRACT_NO AND EC_T_CONTRACT."matno"=EC_T_PERBANDINGAN.MATNO', 'left');
        //$this -> db -> where("EC_T_CONTRACT.published", "1", TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $count = $result['COUNT(*)'];
        return $count;
    }

    public function addDetail_PL($data)
    {
        $this->db->select('MAX(ID_CHART)')->from($this->tableCart)->where("ID_USER", $data['ID'], TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $count = $result['MAX(ID_CHART)'];

        $this->db->insert('EC_PL_DETAIL',
            array('ID_CART' => $count, 'PLANT' => $data['PLANT'], 'ALAMAT' => $data['ALAMAT'], 'CP' => $data['CP'],
                'GL' => $data['GL']));
    }

    public function addCompare($MATNO, $CNT, $USER)
    {
        $this->db->select('MAX(NO_URUT)')->from($this->tableCompare)->where("ID_USER", $USER, TRUE);
        //$this -> db -> join('EC_T_CONTRACT', 'EC_T_CONTRACT."contract_no"=EC_T_PERBANDINGAN.CONTRACT_NO AND EC_T_CONTRACT."matno"=EC_T_PERBANDINGAN.MATNO', 'left');
        //$this -> db -> where("EC_T_PERBANDINGAN.ID_USER", $USER, TRUE);
        //$this -> db -> where("EC_T_CONTRACT.published", "1", TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $count = $result['MAX(NO_URUT)'] + 1;

        $this->db->insert($this->tableCompare,
            array('CONTRACT_NO' => $CNT, 'MATNO' => $MATNO, 'ID_USER' => $USER, 'NO_URUT' => $count));
        $this->db->select('COUNT(*)')->from($this->tableCompare)->where("ID_USER", $USER, TRUE);
        $this->db->join('EC_T_CONTRACT',
            'EC_T_CONTRACT.contract_no=EC_T_PERBANDINGAN.CONTRACT_NO AND EC_T_CONTRACT."matno"=EC_T_PERBANDINGAN.MATNO',
            'left');
        $this->db->where("EC_T_CONTRACT.published", "1", TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $count = $result['COUNT(*)'];
        return $count;
    }

    public function addCompare_pl($MATNO, $CNT, $USER, $kd)
    {
        $this->db->select('MAX(NO_URUT)')->from($this->tableCompare)->where("ID_USER", $USER, TRUE);
        $this->db->where("CONTRACT_NO", $CNT, TRUE);
        //$this -> db -> join('EC_T_CONTRACT', 'EC_T_CONTRACT."contract_no"=EC_T_PERBANDINGAN.CONTRACT_NO AND EC_T_CONTRACT."matno"=EC_T_PERBANDINGAN.MATNO', 'left');
        //$this -> db -> where("EC_T_PERBANDINGAN.ID_USER", $USER, TRUE);
        //$this -> db -> where("EC_T_CONTRACT.published", "1", TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $count = $result['MAX(NO_URUT)'] + 1;

        $this->db->insert($this->tableCompare,
            array('CONTRACT_NO' => $CNT, 'MATNO' => $MATNO, 'ID_USER' => $USER, 'NO_URUT' => $count, "KODE_DETAIL_PENAWARAN" => $kd));
        $this->db->select('COUNT(*)')->from($this->tableCompare)->where("ID_USER", $USER, TRUE);
        $this->db->where("CONTRACT_NO", $CNT, TRUE);
        //$this -> db -> join('EC_T_CONTRACT', 'EC_T_CONTRACT.contract_no=EC_T_PERBANDINGAN.CONTRACT_NO AND EC_T_CONTRACT."matno"=EC_T_PERBANDINGAN.MATNO', 'left');
        //$this -> db -> where("EC_T_CONTRACT.published", "1", TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $count = $result['COUNT(*)'];
        return $count;
    }

    public function moveTo($MATNO, $contract_no, $USER, $kode)
    {
        $this->db->from($this->tableCompare)->where("ID_USER", $USER, TRUE);
        $this->db->join('EC_T_CONTRACT',
            'EC_T_CONTRACT.contract_no=EC_T_PERBANDINGAN.CONTRACT_NO AND EC_T_CONTRACT."matno"=EC_T_PERBANDINGAN.MATNO',
            'left');
        $this->db->where("EC_T_CONTRACT.published", "1", TRUE);
        $this->db->order_by('NO_URUT');
        $query = $this->db->get();
        // $result = $query -> row_array();
        $result = (array)$query->result_array();
        //var_dump($result);
        for ($i = 0; $i < sizeof($result); $i++) {
            if ($result[$i]['MATNO'] == $MATNO && $result[$i]['ID_USER'] == $USER && $result[$i]['CONTRACT_NO'] == $contract_no) {
                //$temp = $result[$i]['NO_URUT'];
                $this->db->where("MATNO", $result[$i]['MATNO'], TRUE);
                $this->db->where("ID_USER", $result[$i]['ID_USER'], TRUE);
                $this->db->where("CONTRACT_NO", $result[$i]['CONTRACT_NO'], TRUE);
                $this->db->update($this->tableCompare, array('NO_URUT' => $result[$i + ($kode)]['NO_URUT']));

                $this->db->where("MATNO", $result[$i + ($kode)]['MATNO'], TRUE);
                $this->db->where("ID_USER", $result[$i + ($kode)]['ID_USER'], TRUE);
                $this->db->where("CONTRACT_NO", $result[$i + ($kode)]['CONTRACT_NO'], TRUE);
                $this->db->update($this->tableCompare, array('NO_URUT' => $result[$i]['NO_URUT']));
                break;
            }
        }
    }

    public function moveTo_pl($MATNO, $contract_no, $USER, $kode, $kode_detail)
    {
        $this->db->from($this->tableCompare)->where("ID_USER", $USER, TRUE);
        $this->db->where("CONTRACT_NO", $contract_no, TRUE);
        //$this->db->where("KODE_DETAIL_PENAWARAN", $kode_detail, TRUE);
        //$this -> db -> join('EC_T_CONTRACT', 'EC_T_CONTRACT.contract_no=EC_T_PERBANDINGAN.CONTRACT_NO AND EC_T_CONTRACT."matno"=EC_T_PERBANDINGAN.MATNO', 'left');
        //$this -> db -> where("EC_T_CONTRACT.published", "1", TRUE);
        $this->db->order_by('NO_URUT');
        $query = $this->db->get();
        // $result = $query -> row_array();
        $result = (array)$query->result_array();
        var_dump('tesss' . $result);
        for ($i = 0; $i < sizeof($result); $i++) {
            if ($result[$i]['MATNO'] == $MATNO && $result[$i]['ID_USER'] == $USER && $result[$i]['CONTRACT_NO'] == $contract_no && $result[$i]['KODE_DETAIL_PENAWARAN'] == $kode_detail) {
                //$temp = $result[$i]['NO_URUT'];
                var_dump('masuk');
                $this->db->where("MATNO", $result[$i]['MATNO'], TRUE);
                $this->db->where("ID_USER", $result[$i]['ID_USER'], TRUE);
                $this->db->where("CONTRACT_NO", $result[$i]['CONTRACT_NO'], TRUE);
                $this->db->where("KODE_DETAIL_PENAWARAN", $result[$i]['KODE_DETAIL_PENAWARAN'], TRUE);
                $this->db->update($this->tableCompare, array('NO_URUT' => $result[$i + ($kode)]['NO_URUT']));

                $this->db->where("MATNO", $result[$i + ($kode)]['MATNO'], TRUE);
                $this->db->where("ID_USER", $result[$i + ($kode)]['ID_USER'], TRUE);
                $this->db->where("CONTRACT_NO", $result[$i + ($kode)]['CONTRACT_NO'], TRUE);
                $this->db->where("KODE_DETAIL_PENAWARAN", $result[$i + ($kode)]['KODE_DETAIL_PENAWARAN'], TRUE);
                $this->db->update($this->tableCompare, array('NO_URUT' => $result[$i]['NO_URUT']));
                break;
            }
        }
    }

    public function getDetail($PC_CODE)
    {
        $this->db->from($this->table);
        $this->db->where("PC_CODE", $PC_CODE, TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getDetail_pl($matno)
    {
        $this->db->from($this->tableStrategic);
        $this->db->where("MATNR", $matno, TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function insertFeedback($data)
    {
        // $this -> db -> insert($this -> tableFeedback, array('ID_USER' => $data['ID_USER'], 'MATNO' => $data['MATNO'], 'CONTRACT_NO' => $data['CONTRACT_NO'], 'DATETIME' => $data['DATETIME'], 'ULASAN' => $data['ULASAN'], 'RATING' => $data['RATING'], 'NAME_USER' => $data['USERNAME']));
        $SQL = "INSERT INTO \"EC_FEEDBACK\" (\"ID_USER\", \"MATNO\", \"CONTRACT_NO\", \"DATETIME\", \"ULASAN\", \"RATING\", \"NAME_USER\") VALUES ('" . $data['ID_USER'] . "', '" . $data['MATNO'] . "', '" . $data['CONTRACT_NO'] . "', TO_DATE('" . $data['DATETIME'] . "', 'yyyy-mm-dd hh24:mi:ss'), '" . $data['ULASAN'] . "', '" . $data['RATING'] . "', '" . $data['USERNAME'] . "')";
        // '" . $ptm . "'
        $this->db->query($SQL);
    }

    public function getfeedback($contract_no, $MATNO)
    {
        $this->db->select('EC_FEEDBACK.*,TO_CHAR (EC_FEEDBACK.DATETIME, \'DD Month YYYY\') AS TANGGAL', false);
        $this->db->from($this->tableFeedback);
        $this->db->where("MATNO", $MATNO, TRUE);
        $this->db->where("CONTRACT_NO", $contract_no, TRUE);
        $this->db->order_by('DATETIME', 'DESC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function get($mins = 0, $max = 12, $COMPANY_ID)
    {
        if ($mins == 0) {
            $this->db->limit(13);
        } else{
            $this->db->where("ROWNUM <=", $max, false);
        }

        $this->db->from($this->table);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        $this->db->join('EC_M_CATEGORY', 'EC_M_STRATEGIC_MATERIAL.ID_CAT = EC_M_CATEGORY.ID_CAT', 'left');
        $this->db->join('EC_PRINCIPAL_MANUFACTURER', 'EC_PRINCIPAL_MANUFACTURER.PC_CODE = EC_R1.PC_CODE', 'left');
        $this->db->where("published = 1 and \"plant\" IN (SELECT RL.PLANT FROM EC_M_ROLE_PLANT RL WHERE RL.COMPANY= ". $COMPANY_ID .")");
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    //$search, $kategori, $harga_min, $harga_max, $limitMin, $limitMax
    public function get_data_pembelian_lgsg($search = '-', $kategori = '-', $harga_min = '-', $harga_max = '-',
                                            $limitMin = '0', $limitMax = '12', $comp = '2000')
    {
        $SQL = "SELECT 
                ROWNUM, DT.KODE_DETAIL_PENAWARAN,DT.PRICE HARGA,DT.PLANT,DT.DELIVERY_TIME,DT.NAMA_PLANT,TB3.STOK, TO_CHAR (
                    TB1.START_DATE,
                    'DD/MM/YYYY'
                ) AS STARTDATE,
                TO_CHAR (TB1.END_DATE, 'DD/MM/YYYY') AS ENDDATE, 
                DT.DELIVERY_TIME,
                SM.MATNR,SM.PICTURE,SM.MAKTX,SM.MEINS,SM.ID_CAT, CAT.\"DESC\",TB1.*
				FROM (SELECT ASS.MATNO, ASS.START_DATE,CURRENCY, ASS.END_DATE, ASS.KODE_PENAWARAN FROM EC_PL_ASSIGN ASS
				GROUP BY ASS.MATNO, ASS.START_DATE, ASS.END_DATE, ASS.KODE_PENAWARAN,CURRENCY) TB1
				INNER JOIN EC_M_STRATEGIC_MATERIAL SM ON TB1.MATNO=SM.MATNR
				INNER JOIN EC_M_CATEGORY CAT ON SM.ID_CAT=CAT.ID_CAT
				INNER JOIN (SELECT T1.*,PL.\"DESC\" NAMA_PLANT FROM EC_T_DETAIL_PENAWARAN T1
                    INNER JOIN
                    (SELECT  \"MIN\"(T1.PRICE) OVER (PARTITION BY T1.PLANT,T1.MATNO) HARGA,T1.* FROM EC_T_DETAIL_PENAWARAN T1 
                    INNER JOIN (SELECT MATNO,PLANT,VENDORNO,\"MAX\" (INDATE) INDATE FROM EC_T_DETAIL_PENAWARAN
                                            GROUP BY MATNO,PLANT,VENDORNO ORDER BY PLANT,MATNO,VENDORNO) T2 
                                            ON T1.MATNO = T2.MATNO AND T1.VENDORNO = T2.VENDORNO AND T1.PLANT = T2.PLANT AND T1.INDATE = T2.INDATE 
                     WHERE T1.PRICE>0
                     ) T2 ON T1.MATNO = T2.MATNO AND T1.VENDORNO = T2.VENDORNO AND T1.PLANT = T2.PLANT AND T1.INDATE = T2.INDATE AND T1.PRICE=T2.HARGA
                    INNER JOIN EC_M_PLANT PL ON PL.PLANT=T1.PLANT 
                    WHERE PL.COMPANY ='" . $comp . "') DT
                ON SM.MATNR = DT.MATNO  
                INNER JOIN (SELECT TB2.* FROM
                    (
                        SELECT
                            PEN.VENDORNO,
                            PEN.MATNO,
                            MAX (PEN.INDATE) AS DATE1
                        FROM
                            EC_PL_PENAWARAN PEN 
                        GROUP BY
                            PEN.VENDORNO,
                            PEN.MATNO
                    ) TB1
                INNER JOIN EC_PL_PENAWARAN TB2 ON TB1.VENDORNO = TB2.VENDORNO
                AND TB1.MATNO = TB2.MATNO
                AND TB1.DATE1 = TB2.INDATE ) TB3 ON TB3.VENDORNO=DT.VENDORNO AND TB3.MATNO=DT.MATNO
				WHERE SM.PUBLISHED_LANGSUNG = '1' AND DT.PLANT IN (SELECT RL.PLANT FROM EC_M_ROLE_PLANT RL WHERE RL.COMPANY='".$this->session->userdata['COMPANYID']."')";// AND T1.STOK > 0
        if($limitMin==0){
            $SQL .= " AND ROWNUM < 13 ";
        }else{
            $SQL .= " AND ROWNUM <= '".$limitMax."'";
        }

        if ($kategori != '-'){
            $SQL .= " AND CAT.KODE_USER LIKE '" . $kategori . "%' ";
        }
        if ($search != '-' && $search != '-'){
            $SQL .= " AND (lower(SM.TAG) LIKE lower('%" . $search . "%') OR lower(DT.PLANT) LIKE lower('%" . $search . "%') OR lower(DT.NAMA_PLANT) LIKE lower('%" . $search . "%') OR lower(SM.MAKTX) LIKE lower('%" . $search . "%') ) ";
        }
        if ($harga_min != '-' && $harga_max != '-'){
            $SQL .= " AND DT.PRICE >= " . $harga_min . " AND DT.PRICE <= " . $harga_max;
        }
        $SQL .= " ORDER BY ROWNUM ASC, SM.MATNR ASC";
        $result = $this->db->query($SQL);
        return (array)$result->result_array();
    }

    public function get_count_pembelian_lgsg($search = '-', $kategori = '-', $harga_min = '-', $harga_max = '-',
                                            $limitMin = '0', $limitMax = '12', $comp = '2000')
    {
        $SQL = "SELECT 
                ROWNUM, DT.KODE_DETAIL_PENAWARAN,DT.PRICE HARGA,DT.PLANT,DT.DELIVERY_TIME,DT.NAMA_PLANT,TB3.STOK, TO_CHAR (
                    TB1.START_DATE,
                    'DD/MM/YYYY'
                ) AS STARTDATE,
                TO_CHAR (TB1.END_DATE, 'DD/MM/YYYY') AS ENDDATE, 
                DT.DELIVERY_TIME,
                SM.MATNR,SM.PICTURE,SM.MAKTX,SM.MEINS,SM.ID_CAT, CAT.\"DESC\",TB1.*
                FROM (SELECT ASS.MATNO, ASS.START_DATE,CURRENCY, ASS.END_DATE, ASS.KODE_PENAWARAN FROM EC_PL_ASSIGN ASS
                GROUP BY ASS.MATNO, ASS.START_DATE, ASS.END_DATE, ASS.KODE_PENAWARAN,CURRENCY) TB1
                INNER JOIN EC_M_STRATEGIC_MATERIAL SM ON TB1.MATNO=SM.MATNR
                INNER JOIN EC_M_CATEGORY CAT ON SM.ID_CAT=CAT.ID_CAT
                INNER JOIN (SELECT T1.*,PL.\"DESC\" NAMA_PLANT FROM EC_T_DETAIL_PENAWARAN T1
                    INNER JOIN
                    (SELECT  \"MIN\"(T1.PRICE) OVER (PARTITION BY T1.PLANT,T1.MATNO) HARGA,T1.* FROM EC_T_DETAIL_PENAWARAN T1 
                    INNER JOIN (SELECT MATNO,PLANT,VENDORNO,\"MAX\" (INDATE) INDATE FROM EC_T_DETAIL_PENAWARAN
                                            GROUP BY MATNO,PLANT,VENDORNO ORDER BY PLANT,MATNO,VENDORNO) T2 
                                            ON T1.MATNO = T2.MATNO AND T1.VENDORNO = T2.VENDORNO AND T1.PLANT = T2.PLANT AND T1.INDATE = T2.INDATE 
                     WHERE T1.PRICE>0
                     ) T2 ON T1.MATNO = T2.MATNO AND T1.VENDORNO = T2.VENDORNO AND T1.PLANT = T2.PLANT AND T1.INDATE = T2.INDATE AND T1.PRICE=T2.HARGA
                    INNER JOIN EC_M_PLANT PL ON PL.PLANT=T1.PLANT 
                    WHERE PL.COMPANY ='" . $comp . "') DT
                ON SM.MATNR = DT.MATNO  
                INNER JOIN (SELECT TB2.* FROM
                    (
                        SELECT
                            PEN.VENDORNO,
                            PEN.MATNO,
                            MAX (PEN.INDATE) AS DATE1
                        FROM
                            EC_PL_PENAWARAN PEN 
                        GROUP BY
                            PEN.VENDORNO,
                            PEN.MATNO
                    ) TB1
                INNER JOIN EC_PL_PENAWARAN TB2 ON TB1.VENDORNO = TB2.VENDORNO
                AND TB1.MATNO = TB2.MATNO
                AND TB1.DATE1 = TB2.INDATE ) TB3 ON TB3.VENDORNO=DT.VENDORNO AND TB3.MATNO=DT.MATNO
                WHERE SM.PUBLISHED_LANGSUNG = '1' AND DT.PLANT IN (SELECT RL.PLANT FROM EC_M_ROLE_PLANT RL WHERE RL.COMPANY='".$this->session->userdata['COMPANYID']."')";// AND T1.STOK > 0

        if ($kategori != '-'){
            $SQL .= " AND CAT.KODE_USER LIKE '" . $kategori . "%' ";
        }
        if ($search != '-' && $search != '-'){
            $SQL .= " AND (lower(SM.TAG) LIKE lower('%" . $search . "%') OR lower(DT.PLANT) LIKE lower('%" . $search . "%') OR lower(DT.NAMA_PLANT) LIKE lower('%" . $search . "%') OR lower(SM.MAKTX) LIKE lower('%" . $search . "%') ) ";
        }
        if ($harga_min != '-' && $harga_max != '-'){
            $SQL .= " AND DT.PRICE >= " . $harga_min . " AND DT.PRICE <= " . $harga_max;
        }
        $SQL .= " ORDER BY ROWNUM ASC, SM.MATNR ASC";
        $result = $this->db->query($SQL);
        return (array)$result->result_array();
    }

    public function get_data_pembelian_lgsgOLD($search = '-', $kategori = '-', $harga_min = '-', $harga_max = '-',
                                               $limitMin = '0', $limitMax = '12')
    {
        $SQL = "SELECT TB1.*, TO_CHAR (TB1.START_DATE,'DD/MM/YYYY') AS STARTDATE, TO_CHAR (TB1.END_DATE,'DD/MM/YYYY') AS ENDDATE,
			 TB2.VENDORNO, TB2.HARGA_PENAWARAN, TB2.CURR AS CURR_PL, TB2.DELIVERY_TIME, SM.*, CAT.\"DESC\"
				FROM (SELECT ASS.MATNO, ASS.START_DATE, ASS.END_DATE, ASS.KODE_PENAWARAN FROM EC_PL_ASSIGN ASS
				GROUP BY ASS.MATNO, ASS.START_DATE, ASS.END_DATE, ASS.KODE_PENAWARAN) TB1
				INNER JOIN EC_PL_PENAWARAN TB2 ON TB1.KODE_PENAWARAN=TB2.KODE_PENAWARAN
				INNER JOIN EC_M_STRATEGIC_MATERIAL SM ON TB1.MATNO=SM.MATNR
				INNER JOIN EC_M_CATEGORY CAT ON SM.ID_CAT=CAT.ID_CAT 
				WHERE SM.PUBLISHED_LANGSUNG = '1' ";
        if ($kategori != '-')
            $SQL .= " AND CAT.KODE_USER LIKE '" . $kategori . "%' ";
        if ($search != '-')
            $SQL .= " AND (SM.TAG LIKE lower('%" . $search . "%') OR SM.MAKTX LIKE lower('%" . $search . "%') ) ";
        if ($harga_min != '-' && $harga_max != '-')
            $SQL .= " AND TB2.HARGA_PENAWARAN >= " . $harga_min . " AND TB2.HARGA_PENAWARAN <= " . $harga_max;
        $result = $this->db->query($SQL);
        return (array)$result->result_array();
    }

    public function getDetailHarga_pl($kode_pnwrn)
    {
        $this->db->select('EC_T_DETAIL_PENAWARAN.*,EC_PL_ASSIGN.*,PLN.NAMA_PLANT, EC_T_DETAIL_PENAWARAN.PLANT PLANTT');
        $this->db->from('EC_T_DETAIL_PENAWARAN');
        $this->db->where("KODE_DETAIL_PENAWARAN", $kode_pnwrn, TRUE);
        $this->db->join('(SELECT MATNO,CURRENCY FROM EC_PL_ASSIGN GROUP BY MATNO,CURRENCY)EC_PL_ASSIGN',
            'EC_PL_ASSIGN.MATNO=EC_T_DETAIL_PENAWARAN.MATNO', 'left');
        $this->db->join('(SELECT PLANT,"DESC" NAMA_PLANT FROM EC_M_PLANT) PLN', 'PLN.PLANT = EC_T_DETAIL_PENAWARAN.PLANT', 'inner');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getDetailHarga_plOLD($MATNO)
    {
        $SQL = "SELECT * FROM (SELECT ASG.MATNO, ASG.KODE_PENAWARAN
				FROM EC_PL_ASSIGN ASG
				WHERE ASG.MATNO='" . $MATNO . "'
				GROUP BY ASG.MATNO, ASG.KODE_PENAWARAN) TB1
				INNER JOIN EC_PL_PENAWARAN PEN ON PEN.KODE_PENAWARAN=TB1.KODE_PENAWARAN";
        $result = $this->db->query($SQL);
        return (array)$result->result_array();
    }
	
	public function get_data_checkout_PO_PL_vendor($ID_USER,$VENDOR_NO)
    {
        $this->db->from($this->tableCart);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CHART.MATNO = EC_M_STRATEGIC_MATERIAL.MATNR', 'inner');
        $this->db->join('EC_T_DETAIL_PENAWARAN', 'EC_T_CHART.KODE_PENAWARAN = EC_T_DETAIL_PENAWARAN.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->join('(SELECT PLANT,"DESC" NAMA_PLANT FROM EC_M_PLANT) PLN', 'PLN.PLANT = EC_T_DETAIL_PENAWARAN.PLANT', 'inner');
        $this->db->where("PUBLISHED_LANGSUNG", '1', TRUE);
        $this->db->where("ID_USER", $ID_USER, TRUE);
		$this->db->where("VENDORNO", $VENDOR_NO, TRUE);
        $this->db->where("EC_T_CHART.STATUS_CHART ", '0', TRUE);
        $this->db->where("EC_T_CHART.BUYONE ", '0', TRUE);
        $this->db->order_by('VENDORNO', 'ASC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }
	public function get_data_checkout_GROUP_H_vnd($ID_USER)
    {
		$this->db->select('VENDORNO');
        $this->db->from('EC_T_CHART');       
        $this->db->join('EC_T_DETAIL_PENAWARAN', 'EC_T_CHART.KODE_PENAWARAN = EC_T_DETAIL_PENAWARAN.KODE_DETAIL_PENAWARAN', 'inner');
         //$this->db->where("PUBLISHED_LANGSUNG", '1', TRUE);
        $this->db->where("ID_USER", $ID_USER, TRUE);
		//$this->db->where("VENDORNO", $VENDOR_NO, TRUE);
        $this->db->where("EC_T_CHART.STATUS_CHART ", '0', TRUE);
        $this->db->where("EC_T_CHART.BUYONE ", '0', TRUE);
        $this->db->group_by('VENDORNO');
		 $this->db->order_by('VENDORNO');
        $result = $this->db->get();
        return (array)$result->result_array();
    }
	
	public function getVnd_cek_stok($matno, $plant,$vendorno)
    {
        $SQL = "SELECT
                TB2.MATNO,
                SM.MAKTX,
                TB2.STOK,
                TB2.VENDORNO,
                TB2.STOK_COMMIT,
                DT3.PLANT,
                PLN.NAMA_PLANT,
                DT3.KODE_DETAIL_PENAWARAN,
                DT3.DELIVERY_TIME,
                DT3.INDATE,
                DT3.PRICE
            FROM
                (
                    SELECT
                        PEN.VENDORNO,
                        PEN.MATNO,
                        MAX (PEN.INDATE) AS DATE1
                    FROM
                        EC_PL_PENAWARAN PEN
                    WHERE
                        MATNO = '" . $matno . "'
                    GROUP BY
                        PEN.VENDORNO,
                        PEN.MATNO
                ) TB1
            INNER JOIN EC_PL_PENAWARAN TB2 ON TB1.VENDORNO = TB2.VENDORNO
            AND TB1.MATNO = TB2.MATNO
            AND TB1.DATE1 = TB2.INDATE 
            LEFT JOIN (
                SELECT
                    DT2.*
                FROM
                    (
                        SELECT
                            PEN.VENDORNO,
                            PEN.MATNO,
                            PEN.PLANT,
                            MAX (PEN.INDATE) AS DATE1
                        FROM
                            EC_T_DETAIL_PENAWARAN PEN
                        WHERE
                            MATNO = '" . $matno . "'
                        AND PLANT = '" . $plant . "'
                        GROUP BY
                            PEN.VENDORNO,
                            PEN.MATNO,
                            PEN.PLANT
                    ) DT1
                INNER JOIN EC_T_DETAIL_PENAWARAN DT2 ON DT1.VENDORNO = DT2.VENDORNO
                AND DT1.MATNO = DT2.MATNO
                AND DT1.DATE1 = DT2.INDATE
                WHERE
                    DT2.MATNO = '" . $matno . "'
                AND DT2.PLANT = '" . $plant . "'
            ) DT3 ON DT3.MATNO = TB2.MATNO
            AND DT3.VENDORNO = TB2.VENDORNO
            INNER JOIN EC_M_STRATEGIC_MATERIAL SM ON TB1.MATNO=SM.MATNR
            INNER JOIN (SELECT PLANT,\"DESC\" NAMA_PLANT FROM EC_M_PLANT) PLN ON PLN.PLANT = DT3.PLANT
            WHERE
                TB2.MATNO = '" . $matno . "'
				AND TB2.VENDORNO != '". $vendorno ."'	
                AND TB2.STOK > 0
            ORDER BY
                DT3.PRICE ASC";
        $result = $this->db->query($SQL);
        return (array)$result->result_array();
    }
	
    public function getVnd_cek_stok_in($matno, $plant,$vendorno, $KODE_PENAWARAN)
    {
        $SQL = "SELECT
                TB2.MATNO,
                SM.MAKTX,
                TB2.STOK,
                TB2.VENDORNO,
                TB2.STOK_COMMIT,
                DT3.PLANT,
                PLN.NAMA_PLANT,
                DT3.KODE_DETAIL_PENAWARAN,
                DT3.DELIVERY_TIME,
                DT3.INDATE,
                DT3.PRICE
            FROM
                (
                    SELECT
                        PEN.VENDORNO,
                        PEN.MATNO,
                        MAX (PEN.INDATE) AS DATE1
                    FROM
                        EC_PL_PENAWARAN PEN
                    WHERE
                        MATNO = '" . $matno . "'
                    GROUP BY
                        PEN.VENDORNO,
                        PEN.MATNO 
                ) TB1
            INNER JOIN EC_PL_PENAWARAN TB2 ON TB1.VENDORNO = TB2.VENDORNO
            AND TB1.MATNO = TB2.MATNO
            AND TB1.DATE1 = TB2.INDATE 
            LEFT JOIN ( SELECT PEN.* FROM EC_T_DETAIL_PENAWARAN PEN WHERE PEN.KODE_DETAIL_PENAWARAN = '" . $KODE_PENAWARAN . "') DT3 ON DT3.MATNO = TB2.MATNO AND DT3.VENDORNO = TB2.VENDORNO
            INNER JOIN EC_M_STRATEGIC_MATERIAL SM ON TB1.MATNO=SM.MATNR
            INNER JOIN (SELECT PLANT,\"DESC\" NAMA_PLANT FROM EC_M_PLANT) PLN ON PLN.PLANT = DT3.PLANT
            WHERE
                TB2.MATNO = '" . $matno . "'    
                AND TB2.VENDORNO ='". $vendorno ."' 
                AND TB2.STOK > 0
            ORDER BY
                DT3.PRICE ASC";
        $result = $this->db->query($SQL);
        //return (array)$result->result_array();
        return $result->row_array();
    }

	public function getVnd_cek_stok_in_old1($matno, $plant,$vendorno)
    {
        $SQL = "SELECT
                TB2.MATNO,
                SM.MAKTX,
                TB2.STOK,
                TB2.VENDORNO,
                TB2.STOK_COMMIT,
                DT3.PLANT,
                PLN.NAMA_PLANT,
                DT3.KODE_DETAIL_PENAWARAN,
                DT3.DELIVERY_TIME,
                DT3.INDATE,
                DT3.PRICE
            FROM
                (
                    SELECT
                        PEN.VENDORNO,
                        PEN.MATNO,
                        MAX (PEN.INDATE) AS DATE1
                    FROM
                        EC_PL_PENAWARAN PEN
                    WHERE
                        MATNO = '" . $matno . "'
                    GROUP BY
                        PEN.VENDORNO,
                        PEN.MATNO
                ) TB1
            INNER JOIN EC_PL_PENAWARAN TB2 ON TB1.VENDORNO = TB2.VENDORNO
            AND TB1.MATNO = TB2.MATNO
            AND TB1.DATE1 = TB2.INDATE 
            LEFT JOIN (
                SELECT
                    DT2.*
                FROM
                    (
                        SELECT
                            PEN.VENDORNO,
                            PEN.MATNO,
                            PEN.PLANT,
                            MAX (PEN.INDATE) AS DATE1
                        FROM
                            EC_T_DETAIL_PENAWARAN PEN
                        WHERE
                            MATNO = '" . $matno . "'
                        AND PLANT = '" . $plant . "'
                        GROUP BY
                            PEN.VENDORNO,
                            PEN.MATNO,
                            PEN.PLANT
                    ) DT1
                INNER JOIN EC_T_DETAIL_PENAWARAN DT2 ON DT1.VENDORNO = DT2.VENDORNO
                AND DT1.MATNO = DT2.MATNO
                AND DT1.DATE1 = DT2.INDATE
                WHERE
                    DT2.MATNO = '" . $matno . "'
                AND DT2.PLANT = '" . $plant . "'
            ) DT3 ON DT3.MATNO = TB2.MATNO
            AND DT3.VENDORNO = TB2.VENDORNO
            INNER JOIN EC_M_STRATEGIC_MATERIAL SM ON TB1.MATNO=SM.MATNR
            INNER JOIN (SELECT PLANT,\"DESC\" NAMA_PLANT FROM EC_M_PLANT) PLN ON PLN.PLANT = DT3.PLANT
            WHERE
                TB2.MATNO = '" . $matno . "'	
				AND TB2.VENDORNO ='". $vendorno ."'	
                AND TB2.STOK > 0
            ORDER BY
                DT3.PRICE ASC";
        $result = $this->db->query($SQL);
        return (array)$result->result_array();
    }
	
    //public function update_qty_in($matno, $kode, $id_user, $stok)
    public function update_qty_in($ID_CHART, $stok)
    {
        $this->db->set('QTY', $stok);
        $this->db->where(array('ID_CHART' => $ID_CHART));
        $this->db->update($this->tableCart);
    }
    
    public function get_vendor_PO_PL($ID_USER)
    {
        $this->db->select('EC_T_DETAIL_PENAWARAN.VENDORNO,VENDOR_NAME');
        $this->db->from($this->tableCart);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CHART.MATNO = EC_M_STRATEGIC_MATERIAL.MATNR', 'inner');
        $this->db->join('EC_T_DETAIL_PENAWARAN', 'EC_T_CHART.KODE_PENAWARAN = EC_T_DETAIL_PENAWARAN.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->join('(SELECT PLANT,"DESC" NAMA_PLANT FROM EC_M_PLANT) PLN', 'PLN.PLANT = EC_T_DETAIL_PENAWARAN.PLANT', 'inner');
        $this->db->join('VND_HEADER','VND_HEADER.VENDOR_NO=EC_T_DETAIL_PENAWARAN.VENDORNO');
        $this->db->where("PUBLISHED_LANGSUNG", '1', TRUE);
        $this->db->where("ID_USER", $ID_USER, TRUE);
        $this->db->where("EC_T_CHART.STATUS_CHART ", '0', TRUE);
        $this->db->where("EC_T_CHART.BUYONE ", '0', TRUE);        
        $this->db->group_by('EC_T_DETAIL_PENAWARAN.VENDORNO, VENDOR_NAME');             
        $this->db->order_by('EC_T_DETAIL_PENAWARAN.VENDORNO', 'ASC');        
        $result = $this->db->get();
        return (array)$result->result_array();
    }
    
    public function get_cart_PO_PL($ID_USER,$VENDORNO)
    {        
        $this->db->from($this->tableCart);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CHART.MATNO = EC_M_STRATEGIC_MATERIAL.MATNR', 'inner');
        $this->db->join('EC_T_DETAIL_PENAWARAN', 'EC_T_CHART.KODE_PENAWARAN = EC_T_DETAIL_PENAWARAN.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->join('(SELECT PLANT,"DESC" NAMA_PLANT FROM EC_M_PLANT) PLN', 'PLN.PLANT = EC_T_DETAIL_PENAWARAN.PLANT', 'inner');
        $this->db->where("PUBLISHED_LANGSUNG", '1', TRUE);
        $this->db->where("ID_USER", $ID_USER, TRUE);
        $this->db->where("EC_T_CHART.STATUS_CHART ", '0', TRUE);
        $this->db->where("EC_T_CHART.BUYONE ", '0', TRUE);        
        $this->db->where('EC_T_DETAIL_PENAWARAN.VENDORNO', $VENDORNO);                
        $result = $this->db->get();
        return (array)$result->result_array();
    }
	
}

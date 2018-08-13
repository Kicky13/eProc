<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_po_pl_approval_m extends CI_Model
{
    protected $table = 'EC_T_CONTRACT', $tableTrackingPO = 'EC_TRACKING_PO', $tableApproval = 'EC_PL_APPROVAL', $tableCC = 'EC_M_COSTCENTER', $tableCart = 'EC_T_CHART', $tableVendor = 'VND_HEADER', $tablePrincipal = 'EC_PRINCIPAL_MANUFACTURER', $tableEC_R1 = 'EC_R1', $tableStrategic = 'EC_M_STRATEGIC_MATERIAL', $tableCompare = 'EC_T_PERBANDINGAN', $tableFeedback = 'EC_FEEDBACK', $tableAssign = 'EC_PL_ASSIGN', $tablePenawaran = 'EC_PL_PENAWARAN', $tableHeaderGr = 'EC_GR_MATERIAL', $tableConfigApp = 'EC_PL_CONFIG_APPROVAL';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

//730
    public function getPo_pl_approval($userid)
    {
        $this->db->select('USER_AKSES');
        $this->db->from($this->tableConfigApp);
        $this->db->where("USERID", $userid, TRUE);
        $query = $this->db->get();
        $resultAkses = $query->row_array();
        $uakses = $resultAkses['USER_AKSES'];

        if ($uakses == 'KA') {
            $this->db->select('CT.PO_NO NOMERPO,TO_CHAR ((TO_DATE(CT.DATE_BUY, \'dd-mm-yyyy hh24:mi:ss\')+7), \'dd-mm-yyyy hh24:mi:ss\' ) COMMIT_DATE, CT.DATE_BUY,EC_PL_APPROVAL.CURR, VND_HEADER.VENDOR_NAME,  EC_PL_APPROVAL."VALUE",TDP.STOK_COMMIT, EC_PL_APPROVAL.VENDORNO,  EC_TRACKING_PO.*,TDP.DELIVERY_TIME',
                false);
            $this->db->from('(SELECT  PO_NO,  DATE_BUY FROM EC_T_CHART  WHERE CONTRACT_NO =  \'PL2018\' AND PO_NO IS NOT NULL GROUP BY  PO_NO, DATE_BUY ) CT');
            $this->db->join('(SELECT P1.* FROM EC_TRACKING_PO P1 INNER JOIN (SELECT PO_NO,MAX(INDATE) DATE1 FROM EC_TRACKING_PO GROUP BY PO_NO) P2 ON P1.PO_NO=P2.PO_NO AND P1.INDATE=P2.DATE1 )EC_TRACKING_PO',
                'EC_TRACKING_PO.PO_NO = CT.PO_NO', 'left');
            $this->db->join('EC_PL_APPROVAL', 'CT.PO_NO = EC_PL_APPROVAL.PO_NO', 'inner');
            $this->db->join('VND_HEADER', 'VND_HEADER.VENDOR_NO = EC_PL_APPROVAL.VENDORNO', 'left');
            $this->db->join('EC_PL_CONFIG_APPROVAL', 'EC_PL_APPROVAL.PROGRESS_APP = EC_PL_CONFIG_APPROVAL.PROGRESS_CNF AND EC_PL_APPROVAL.COSCENTER = EC_PL_CONFIG_APPROVAL.UK_CODE', 'inner');
            $this->db->join('(SELECT SUM(PRICE) PRICE,SUM(STOK_COMMIT) STOK_COMMIT,PO_NO,DELIVERY_TIME FROM EC_T_DETAIL_PENAWARAN 
                            INNER JOIN EC_T_CHART CT ON CT.KODE_PENAWARAN = EC_T_DETAIL_PENAWARAN.KODE_DETAIL_PENAWARAN 
                            GROUP BY PO_NO,DELIVERY_TIME) TDP ', 'CT.PO_NO = TDP.PO_NO', 'inner');
            $this->db->where('EC_PL_CONFIG_APPROVAL.USERID', $userid, TRUE);
            //        $this->db->where('EC_PL_CONFIG_APPROVAL.UK_CODE', $userid, TRUE);
            $this->db->where('EC_PL_APPROVAL.STATUS', '1', TRUE);
            $this->db->where('EC_PL_APPROVAL.PROGRESS_APP_GUDANG', '0', TRUE);
            // $this->db->where('EC_PL_APPROVAL.PROGRESS_APP<=', 'EC_PL_APPROVAL.MAX_APPROVE', false);
            $this->db->where('(TO_DATE(CT.DATE_BUY, \'dd-mm-yyyy hh24:mi:ss\')+7) >=', '(SELECT SYSDATE FROM DUAL)', false);
            $this->db->order_by('CT.PO_NO DESC');
        } else if ($uakses == 'GUDANG') {
            $this->db->select('CT.PO_NO NOMERPO,TO_CHAR ((TO_DATE(CT.DATE_BUY, \'dd-mm-yyyy hh24:mi:ss\')+7), \'dd-mm-yyyy hh24:mi:ss\' ) COMMIT_DATE, CT.DATE_BUY,EC_PL_APPROVAL.CURR, VND_HEADER.VENDOR_NAME,  EC_PL_APPROVAL."VALUE",TDP.STOK_COMMIT, EC_PL_APPROVAL.VENDORNO,  EC_TRACKING_PO.*,TDP.DELIVERY_TIME',
                false);
            $this->db->from('(SELECT  PO_NO,  DATE_BUY FROM EC_T_CHART  WHERE CONTRACT_NO =  \'PL2018\' AND PO_NO IS NOT NULL GROUP BY  PO_NO, DATE_BUY ) CT');
            $this->db->join('(SELECT P1.* FROM EC_TRACKING_PO P1 INNER JOIN (SELECT PO_NO,MAX(INDATE) DATE1 FROM EC_TRACKING_PO GROUP BY PO_NO) P2 ON P1.PO_NO=P2.PO_NO AND P1.INDATE=P2.DATE1 )EC_TRACKING_PO',
                'EC_TRACKING_PO.PO_NO = CT.PO_NO', 'left');
            $this->db->join('EC_PL_APPROVAL', 'CT.PO_NO = EC_PL_APPROVAL.PO_NO', 'inner');
            $this->db->join('VND_HEADER', 'VND_HEADER.VENDOR_NO = EC_PL_APPROVAL.VENDORNO', 'left');
            $this->db->join('EC_PL_CONFIG_APPROVAL', 'EC_PL_APPROVAL.PROGRESS_APP = EC_PL_CONFIG_APPROVAL.PROGRESS_CNF AND EC_PL_APPROVAL.COSCENTER = EC_PL_CONFIG_APPROVAL.UK_CODE', 'inner');
            $this->db->join('(SELECT SUM(PRICE) PRICE,SUM(STOK_COMMIT) STOK_COMMIT,PO_NO,KODE_PENAWARAN,DELIVERY_TIME FROM EC_T_DETAIL_PENAWARAN 
                            INNER JOIN EC_T_CHART CT ON CT.KODE_PENAWARAN = EC_T_DETAIL_PENAWARAN.KODE_DETAIL_PENAWARAN 
                            GROUP BY PO_NO,KODE_PENAWARAN,DELIVERY_TIME) TDP ', 'CT.PO_NO = TDP.PO_NO', 'inner');
            $this->db->where('EC_PL_CONFIG_APPROVAL.USERID', $userid, TRUE);
            //        $this->db->where('EC_PL_CONFIG_APPROVAL.UK_CODE', $userid, TRUE);
            $this->db->where('EC_PL_APPROVAL.STATUS', '1', TRUE);
            $this->db->where('EC_PL_APPROVAL.PROGRESS_APP_GUDANG', '1', TRUE);
            // $this->db->where('EC_PL_APPROVAL.PROGRESS_APP<=', 'EC_PL_APPROVAL.MAX_APPROVE', false);
            $this->db->where('(TO_DATE(CT.DATE_BUY, \'dd-mm-yyyy hh24:mi:ss\')+7) >=', '(SELECT SYSDATE FROM DUAL)', false);
            $this->db->order_by('CT.PO_NO DESC');
        }
        $sql = $this->db->get();
        $result = $sql->result_array();
        $data = array();
        $PO = 0;
        for($i = 0; $i < count($result); $i++){
            if($PO != $result[$i]['PO_NO']){
                array_push($data, $result[$i]);
            }
            $PO = $result[$i]['PO_NO'];
        }
        return $data;
    }

    function approve($PO)
    {
        $this->db->trans_start();

        $this->db->select('STATUS_GUDANG,PROGRESS_APP_GUDANG')->from($this->tableApproval);
        $this->db->where("PO_NO", $PO, TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $PROGRESS_APP_GUDANG = $result['PROGRESS_APP_GUDANG'];
        if ($PROGRESS_APP_GUDANG != 1) {
            $this->db->where("PO_NO", $PO, TRUE);
            $this->db->set('PROGRESS_APP', 'PROGRESS_APP+1', FALSE);
            $this->db->update($this->tableApproval);
        }

        $this->db->select('PROGRESS_APP,MAX_APPROVE,STATUS_GUDANG,PROGRESS_APP_GUDANG')->from($this->tableApproval);
        $this->db->where("PO_NO", $PO, TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $PROGRESS_APP = $result['PROGRESS_APP'];
        $PROGRESS_APP_GUDANG = $result['PROGRESS_APP_GUDANG'];
        $MAX_APPROVE = $result['MAX_APPROVE'];
        $GUDANG = $result['STATUS_GUDANG'];

        if ($GUDANG == 1) {
            if ($PROGRESS_APP == $MAX_APPROVE + 1) {
                $this->db->where("PO_NO", $PO, TRUE);
                // $this->db->set('PROGRESS_APP_GUDANG', '1', FALSE);
                // $this->db->set('PROGRESS_APP', '0', FALSE);
                // $this->db->update($this->tableApproval);
                $this->db->update($this->tableApproval, array('PROGRESS_APP_GUDANG' => '1', 'PROGRESS_APP' => '0'));

                $SQL = "INSERT INTO EC_TRACKING_PO VALUES ( 
                '" . $PO . "', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'), 2,1,'" . $this->session->userdata['ID'] . "', '" .
                    $this->session->userdata['FULLNAME'] . "')";
            } else {
                $SQL = "INSERT INTO EC_TRACKING_PO VALUES ( 
                '" . $PO . "', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'), 1,null,'" . $this->session->userdata['ID'] . "', '" .
                    $this->session->userdata['FULLNAME'] . "')";
            }
            $this->db->query($SQL);

            $this->db->trans_complete();
            if ($PROGRESS_APP_GUDANG != 0) {
                $this->db->where("PO_NO", $PO, TRUE);
                $this->db->update($this->tableApproval, array('PROGRESS_APP_GUDANG' => '0'));
                return (($PROGRESS_APP == 0) && $PROGRESS_APP_GUDANG != 0);
            } else {
                return (($PROGRESS_APP == $MAX_APPROVE + 1) && $PROGRESS_APP_GUDANG != 0);
            }

        } else {
            if ($PROGRESS_APP == $MAX_APPROVE + 1) {
                $SQL = "INSERT INTO EC_TRACKING_PO VALUES ( 
                '" . $PO . "', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'), 2,1,'" . $this->session->userdata['ID'] . "', '" .
                    $this->session->userdata['FULLNAME'] . "')";
            } else {
                $SQL = "INSERT INTO EC_TRACKING_PO VALUES ( 
                '" . $PO . "', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'), 1,null,'" . $this->session->userdata['ID'] . "', '" .
                    $this->session->userdata['FULLNAME'] . "')";
            }
            $this->db->query($SQL);

            $this->db->trans_complete();

            return $PROGRESS_APP == $MAX_APPROVE + 1;
        }
    }

    public function getDetailPO($userid, $po)
    {
        $this->db->select('USER_AKSES');
        $this->db->from($this->tableConfigApp);
        $this->db->where("USERID", $userid, TRUE);
        $query = $this->db->get();
        $resultAkses = $query->row_array();
        $uakses = $resultAkses['USER_AKSES'];

        if ($uakses == 'KA') {
            $this->db->select('CT.PO_NO NOMERPO,TO_CHAR ((TO_DATE(CT.DATE_BUY, \'dd-mm-yyyy hh24:mi:ss\')+7), \'dd-mm-yyyy hh24:mi:ss\' ) COMMIT_DATE, CT.DATE_BUY,EC_PL_APPROVAL.CURR, VND_HEADER.VENDOR_NAME,  EC_PL_APPROVAL."VALUE",TDP.STOK_COMMIT, EC_PL_APPROVAL.VENDORNO,  EC_TRACKING_PO.*,TDP.DELIVERY_TIME',
                false);
            $this->db->from('(SELECT  PO_NO,  DATE_BUY FROM EC_T_CHART  WHERE CONTRACT_NO =  \'PL2018\' AND PO_NO IS NOT NULL GROUP BY  PO_NO, DATE_BUY ) CT');
            $this->db->join('(SELECT P1.* FROM EC_TRACKING_PO P1 INNER JOIN (SELECT PO_NO,MAX(INDATE) DATE1 FROM EC_TRACKING_PO GROUP BY PO_NO) P2 ON P1.PO_NO=P2.PO_NO AND P1.INDATE=P2.DATE1 )EC_TRACKING_PO',
                'EC_TRACKING_PO.PO_NO = CT.PO_NO', 'left');
            $this->db->join('EC_PL_APPROVAL', 'CT.PO_NO = EC_PL_APPROVAL.PO_NO', 'inner');
            $this->db->join('VND_HEADER', 'VND_HEADER.VENDOR_NO = EC_PL_APPROVAL.VENDORNO', 'left');
            $this->db->join('EC_PL_CONFIG_APPROVAL', 'EC_PL_APPROVAL.PROGRESS_APP = EC_PL_CONFIG_APPROVAL.PROGRESS_CNF AND EC_PL_APPROVAL.COSCENTER = EC_PL_CONFIG_APPROVAL.UK_CODE', 'inner');
            $this->db->join('(SELECT SUM(PRICE) PRICE,SUM(STOK_COMMIT) STOK_COMMIT,PO_NO,DELIVERY_TIME FROM EC_T_DETAIL_PENAWARAN 
                            INNER JOIN EC_T_CHART CT ON CT.KODE_PENAWARAN = EC_T_DETAIL_PENAWARAN.KODE_DETAIL_PENAWARAN 
                            GROUP BY PO_NO,DELIVERY_TIME) TDP ', 'CT.PO_NO = TDP.PO_NO', 'inner');
            $this->db->where('EC_PL_CONFIG_APPROVAL.USERID', $userid, TRUE);
            $this->db->where('CT.PO_NO', $po, TRUE);
            //        $this->db->where('EC_PL_CONFIG_APPROVAL.UK_CODE', $userid, TRUE);
            $this->db->where('EC_PL_APPROVAL.STATUS', '1', TRUE);
            $this->db->where('EC_PL_APPROVAL.PROGRESS_APP_GUDANG', '0', TRUE);
            // $this->db->where('EC_PL_APPROVAL.PROGRESS_APP<=', 'EC_PL_APPROVAL.MAX_APPROVE', false);
            $this->db->where('(TO_DATE(CT.DATE_BUY, \'dd-mm-yyyy hh24:mi:ss\')+7) >=', '(SELECT SYSDATE FROM DUAL)', false);
            $this->db->order_by('CT.PO_NO DESC');
        } else if ($uakses == 'GUDANG') {
            $this->db->select('CT.PO_NO NOMERPO,TO_CHAR ((TO_DATE(CT.DATE_BUY, \'dd-mm-yyyy hh24:mi:ss\')+7), \'dd-mm-yyyy hh24:mi:ss\' ) COMMIT_DATE, CT.DATE_BUY,EC_PL_APPROVAL.CURR, VND_HEADER.VENDOR_NAME,  EC_PL_APPROVAL."VALUE",TDP.STOK_COMMIT, EC_PL_APPROVAL.VENDORNO,  EC_TRACKING_PO.*,TDP.DELIVERY_TIME',
                false);
            $this->db->from('(SELECT  PO_NO,  DATE_BUY FROM EC_T_CHART  WHERE CONTRACT_NO =  \'PL2017\' AND PO_NO IS NOT NULL GROUP BY  PO_NO, DATE_BUY ) CT');
            $this->db->join('(SELECT P1.* FROM EC_TRACKING_PO P1 INNER JOIN (SELECT PO_NO,MAX(INDATE) DATE1 FROM EC_TRACKING_PO GROUP BY PO_NO) P2 ON P1.PO_NO=P2.PO_NO AND P1.INDATE=P2.DATE1 )EC_TRACKING_PO',
                'EC_TRACKING_PO.PO_NO = CT.PO_NO', 'left');
            $this->db->join('EC_PL_APPROVAL', 'CT.PO_NO = EC_PL_APPROVAL.PO_NO', 'inner');
            $this->db->join('VND_HEADER', 'VND_HEADER.VENDOR_NO = EC_PL_APPROVAL.VENDORNO', 'left');
            $this->db->join('EC_PL_CONFIG_APPROVAL', 'EC_PL_APPROVAL.PROGRESS_APP = EC_PL_CONFIG_APPROVAL.PROGRESS_CNF AND EC_PL_APPROVAL.COSCENTER = EC_PL_CONFIG_APPROVAL.UK_CODE', 'inner');
            $this->db->join('(SELECT SUM(PRICE) PRICE,SUM(STOK_COMMIT) STOK_COMMIT,PO_NO,KODE_PENAWARAN,DELIVERY_TIME FROM EC_T_DETAIL_PENAWARAN 
                            INNER JOIN EC_T_CHART CT ON CT.KODE_PENAWARAN = EC_T_DETAIL_PENAWARAN.KODE_DETAIL_PENAWARAN 
                            GROUP BY PO_NO,KODE_PENAWARAN,DELIVERY_TIME) TDP ', 'CT.PO_NO = TDP.PO_NO', 'inner');
            $this->db->where('EC_PL_CONFIG_APPROVAL.USERID', $userid, TRUE);
            $this->db->where('CT.PO_NO', $po, TRUE);
            //        $this->db->where('EC_PL_CONFIG_APPROVAL.UK_CODE', $userid, TRUE);
            $this->db->where('EC_PL_APPROVAL.STATUS', '1', TRUE);
            $this->db->where('EC_PL_APPROVAL.PROGRESS_APP_GUDANG', '1', TRUE);
            // $this->db->where('EC_PL_APPROVAL.PROGRESS_APP<=', 'EC_PL_APPROVAL.MAX_APPROVE', false);
            $this->db->where('(TO_DATE(CT.DATE_BUY, \'dd-mm-yyyy hh24:mi:ss\')+7) >=', '(SELECT SYSDATE FROM DUAL)', false);
            $this->db->order_by('CT.PO_NO DESC');
        }
        $sql = $this->db->get();
        $result = (array)$sql->row_array();
        return $result;
    }

    function reject($PO)
    {
        $this->db->where("PO_NO", $PO, TRUE);
        $this->db->update($this->tableApproval, array('STATUS' => '0'));

        $SQL = "INSERT INTO EC_TRACKING_PO VALUES ( 
            '" . $PO . "', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'), 1,null,'" . $this->session->userdata['ID'] . "', '" .
            $this->session->userdata['FULLNAME'] . "')";
        $this->db->query($SQL);
    }


    function detail($PO)
    {
        $this->db->select('EC_T_CHART.MATNO,EC_T_CHART.FILE_KORIN,SM.MAKTX,EC_T_CHART.QTY,SM.MEINS, EC_T_CHART.LINE_ITEM, DP.PRICE,(EC_T_CHART.QTY*DP.PRICE) TOTAL,DP.PLANT,PL.PLANT_NAME,DP.DELIVERY_TIME',
            false);
        $this->db->from($this->tableCart);
        $this->db->join('EC_M_STRATEGIC_MATERIAL SM', 'SM.MATNR = EC_T_CHART.MATNO', 'left');
        $this->db->join('EC_T_DETAIL_PENAWARAN DP', 'DP.KODE_DETAIL_PENAWARAN = EC_T_CHART.KODE_PENAWARAN', 'inner');
        $this->db->join('ADM_PLANT PL', 'PL.PLANT_CODE = DP.PLANT', 'left');
        $this->db->where("EC_T_CHART.PO_NO", $PO, TRUE);
        $this->db->order_by("EC_T_CHART.LINE_ITEM ASC");
        $result = $this->db->get();
        return (array)$result->result_array();
    }


    function detailCart($PO)
    {
        $this->db->select(' CT.*,DT.VENDORNO,
                            DT.PLANT,
                            DT.DELIVERY_TIME,
                            TO_CHAR(TP.APPROVED , \'DD.MM.YYYY\' ) AS APPROVED	,
                            TO_CHAR((TP.APPROVED+DT.DELIVERY_TIME) , \'DD.MM.YYYY\' ) AS EST_DELIV,
                            to_char(TP.APPROVED+DT.DELIVERY_TIME+1,\'YYYY-MM-DD HH24:MI:SS\') AS EST_DELIV2',
            false);
        $this->db->from('EC_T_CHART CT');
        $this->db->join('EC_T_DETAIL_PENAWARAN DT', 'DT.KODE_DETAIL_PENAWARAN = CT.KODE_PENAWARAN', 'inner');
        $this->db->join('(SELECT MAX(INDATE) APPROVED,PO_NO FROM EC_TRACKING_PO GROUP BY PO_NO) TP',
            'TP.PO_NO = CT.PO_NO', 'inner');
        $this->db->where("CT.PO_NO", $PO, TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();
    }


    function history($PO)
    {
        $this->db->select('TO_CHAR(INDATE , \'DD/MM/YYYY hh24:mi:ss\' ) AS TANGGAL,EC_TRACKING_PO.*', false);
        $this->db->from($this->tableTrackingPO);
        $this->db->where("PO_NO", $PO, TRUE);
        $this->db->order_by('INDATE ASC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function insertToShipment($data, $PO)
    {
        $this->db->trans_start();
        $this->db->select('SUM(CT.STOK_COMMIT) AS STOK', false);
        $this->db->from('EC_T_CHART CT');
        $this->db->join('EC_T_DETAIL_PENAWARAN DT', 'DT.KODE_DETAIL_PENAWARAN = CT.KODE_PENAWARAN', 'inner');
        $this->db->join('(SELECT MAX(INDATE) APPROVED,PO_NO FROM EC_TRACKING_PO GROUP BY PO_NO) TP',
            'TP.PO_NO = CT.PO_NO', 'inner');
        $this->db->where("CT.PO_NO", $PO, TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        //$result = (array)$query->result_array();

        $SQL = "INSERT INTO EC_T_SHIPMENT VALUES ( 
            '','" . $PO . "','" . $data[0]['VENDORNO'] . "','1', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'),'" . $result['STOK'] . "','0')";
        $this->db->query($SQL);

        $this->db->trans_complete();
    }

    function insertToShipment_OLD($data, $PO)
    {
        $this->db->trans_start();
        $this->db->select(' CT.MATNO,DT.VENDORNO, CT.STOK_COMMIT,
                            DT.PLANT,
                            DT.DELIVERY_TIME,
                            TO_CHAR(TP.APPROVED , \'DD.MM.YYYY\' ) AS APPROVED  ,
                            TO_CHAR((TP.APPROVED+DT.DELIVERY_TIME) , \'DD.MM.YYYY\' ) AS EST_DELIV',
            false);
        $this->db->from('EC_T_CHARTc CT');
        $this->db->join('EC_T_DETAIL_PENAWARAN DT', 'DT.KODE_DETAIL_PENAWARAN = CT.KODE_PENAWARAN', 'inner');
        $this->db->join('(SELECT MAX(INDATE) APPROVED,PO_NO FROM EC_TRACKING_PO GROUP BY PO_NO) TP',
            'TP.PO_NO = CT.PO_NO', 'inner');
        $this->db->where("CT.PO_NO", $PO, TRUE);
        $query = $this->db->get();
        //$result = $query->row_array();
        $result = (array)$query->result_array();

        $SQL = "INSERT INTO EC_T_SHIPMENT VALUES ( 
            '','" . $PO . "','" . $result['MATNO'] . "','" . $result['VENDORNO'] . "','1','','', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'),'','','" . $result['STOK_COMMIT'] . "','0')";
        $this->db->query($SQL);

        $this->db->trans_complete();
    }

    function insertHeaderGR($data)
    {
        foreach ($data as $value) {

            $est=$value['EST_DELIV'];
            $this->db->where("PO_NO", $value['PO_NO'], TRUE);
            $this->db->where("MATNO", $value['MATNO'], TRUE);
            $this->db->where("LINE_ITEM", $value['LINE_ITEM'], TRUE);
            $this->db->set('STATUS', '2', FALSE);
            $this->db->set("CHDATE", "TO_DATE('$est', 'yyyy/mm/dd hh24:mi:ss')", FALSE);
            $this->db->update($this->tableHeaderGr);

            /*$SQL = "INSERT INTO EC_GR_MATERIAL VALUES ( 
                    '','" . $value['PO_NO'] . "', '" . $value['MATNO'] . "', '" . $value['LINE_ITEM'] . "', '" . $value['QTY'] .
                    "', '0', '1', TO_DATE('" . date("d-m-Y H:i:s") . "', 'dd-mm-yyyy hh24:mi:ss'), " .
                    " TO_DATE('" . date("d-m-Y H:i:s") . "', 'dd-mm-yyyy hh24:mi:ss'), '" . $value['ID_CHART'] . "')";
            
            $this->db->query($SQL);*/
        }
    }
    
    function historyHarga($po,$matno)
    {
        $this->db->select('HO.VENDOR_NO, VH.VENDOR_NAME, HO.STOK, HO.DELIVERY, HO.HARGA, HO.SATUAN',
            false);
        $this->db->from('EC_HISTORY_HARGA_PO HO');
        $this->db->join('VND_HEADER VH', 'HO.VENDOR_NO = VH.VENDOR_NO');                
        $this->db->where("HO.PO_HISTORY", $po, TRUE);
        $this->db->where("HO.MATNO", $matno, TRUE);
        $this->db->order_by("HO.HARGA ASC");
        $result = $this->db->get();
        return (array)$result->result_array();
    }
}

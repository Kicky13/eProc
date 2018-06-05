<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_e_nova extends MY_Model {	
    public $table = 'EC_E_NOFA';
    public $primary_key = 'ID';	                                                
    
    public function insert($data){ 
        $this->db->set('UPDATE_DATE','sysdate',FALSE);
        $this->db->set('START_DATE','TO_DATE(\''.$data['START_DATE'].'\',\'DD-MM-YYYY\')',FALSE);
        $this->db->set('END_DATE','TO_DATE(\''.$data['END_DATE'].'\',\'DD-MM-YYYY\')',FALSE);
        unset($data['START_DATE']);
        unset($data['END_DATE']);

        $res = $this->db->insert($this->table,$data);
    }

    public function delete($id){
        $this->db->where('ID', $id);
        return $this->db->delete($this->table); 
    }

    public function get_Enofa($where_str = '', $order = '') {
        $select = ' E.* 
                      ,TO_CHAR (CREATE_DATE,\'DD-MM-YYYY\') AS CREATE_DATE2
                      ,TO_CHAR (UPDATE_DATE,\'DD-MM-YYYY\') AS UPDATE_DATE2
                      ,TO_CHAR (START_DATE,\'DD-MM-YYYY\') AS START_DATE2
                      ,TO_CHAR (END_DATE,\'DD-MM-YYYY\') AS END_DATE2
                      ,TO_CHAR (START_DATE,\'YYYYMMDD\') AS START_DATE3
                      ,TO_CHAR (END_DATE,\'YYYYMMDD\') AS END_DATE3
                      ,V.VENDOR_NAME
                      ,V.COMPANYID 
                      ,V.EMAIL_ADDRESS
                    FROM '.$this->table.' E 
                      JOIN VND_HEADER V 
                      ON E.CREATE_BY = V.VENDOR_NO '.
                    $where_str.' '. $order;
                
        $this->db->select($select,FALSE);

        return $this->db->get()->result_array();
    }

    public function update($data,$id){

        $this->db->set('UPDATE_DATE','sysdate',FALSE);
        $this->db->set('START_DATE','TO_DATE(\''.$data['START_DATE'].'\',\'DD-MM-YYYY\')',FALSE);
        unset($data['START_DATE']);
        $this->db->set('END_DATE','TO_DATE(\''.$data['END_DATE'].'\',\'DD-MM-YYYY\')',FALSE);
        unset($data['END_DATE']);

        $this->db->where('ID',$id);
        $res = $this->db->update($this->table,$data);
        return $res;
    }

    public function update_ver($data){
        $this->db->set('UPDATE_DATE','sysdate',FALSE);
        $this->db->where('ID',$data['ID']);
        $res = $this->db->update($this->table,$data);
        return $res;
    }

    /* LIST FAKTUR APPROVED VERIFIKASI 1*/
    public function _baseItemQuery($where = ''){
        $date = '"DATE"';
        $user = '"USER"';
        $query = "
                SELECT
                    /*HEADER*/
                    IH.ID_INVOICE
                    ,IH.FAKTUR_PJK
                    ,IH.FAKPJK_PIC
                    ,IH.NO_INVOICE
                    ,UPPER(IH.NO_INVOICE) AS UP_NO_INV
                    ,IH.INVOICE_SAP AS MIR
                    ,IH.VENDOR_NO||' - '|| VH.VENDOR_NAME AS VENDOR
                    ,VH.VENDOR_NO
                    ,IH.NOTE
                    ,GS.EBELP PO_LINE
                    ,IH.CURRENCY
                    ,TO_CHAR(TI.$date,'DD-MM-YYYY') AS CREATE_ON
                    ,TO_CHAR(TI.$date,'DD-MM-YYYY hh24:mi:ss') AS CREATE_ON2
                    ,TI.$user AS CREATE_BY
                    ,CASE
                        WHEN FR.STATUS = 1 THEN 'REPORTED'
                        ELSE 'UNREPORTED' END F_STATUS
                    ,REPORTED_BY||' - '||TO_CHAR (FR.CDATE,'DD-MM-YYYY hh24:mi:ss')  AS F_REPORT_DATE
                    ,TO_CHAR(FAKTUR_PJK_DATE,'DD-MM-YYYY') AS FKT_DATE
                    
                    /*Filter */
                    ,CASE
                        WHEN FR.STATUS = 1 THEN 'R'
                        ELSE 'U' END F_STAT
                    ,TO_CHAR(TI.$date,'YYYYMMDD') AS F_CRE_ON
                    ,TO_CHAR(FAKTUR_PJK_DATE,'YYYYMMDD') AS F_FKT_DATE
                    
                    /*HEADER & DETAIL*/
                    ,GR.GR_AMOUNT_IN_DOC AS AMOUNTS
                    ,GS.EBELN AS NO_PO
                    ,IH.COMPANY_CODE
                    
                    /*DETAIL ITEM*/
                    ,GS.TXZ01 AS GR_DESCRIPTION
                    ,GS.LFBNR AS GR_DOC
                    ,GS.MENGE AS GR_ITEM_QTY
                    ,GS.EBELP AS GR_ITEM_NO
                    ,GS.WAERS AS GR_CURRENCY
                    ,TO_CHAR(TO_DATE(GS.BLDAT,'YYYYMMDD'),'DD-MM-YYYY') AS GR_DATE
                    ,TO_CHAR(TO_DATE(GS.CPUDT,'YYYYMMDD'),'DD-MM-YYYY') AS GR_CREATE_ON
                    ,XP.URL_FAKTUR
                    ,XP.XML_FAKTUR
                    ,XP.XML_FAKTUR2

                FROM EC_INVOICE_HEADER IH 
                INNER JOIN EC_TRACKING_INVOICE TI 
                    ON IH.ID_INVOICE = TI.ID_INVOICE
                INNER JOIN VND_HEADER VH 
                    ON IH.VENDOR_NO = VH.VENDOR_NO
                INNER JOIN EC_GR_SAP GS -- Awalnya INNER namun bermasalah ketika parcial, dan left bermasalah karena amount = 0
                    ON IH.ID_INVOICE = GS.INV_NO
                LEFT JOIN EC_FAKTUR_REPORT FR
                    ON IH.FAKTUR_PJK = FR.FAKTUR_NO
                LEFT JOIN EC_GR GR
                    ON IH.ID_INVOICE = GR.INV_NO AND GR.GR_NO = GS.LFBNR AND GR.GR_ITEM_NO = GS.LFPOS AND GR.GR_YEAR = GS.LFGJA
                LEFT JOIN EC_XML_PAJAK XP
                    ON IH.FAKTUR_PJK = XP.NO_FAKTUR
                WHERE IH.STATUS_HEADER NOT IN (1,2,4)
                    AND IH.FAKTUR_PJK IS NOT NULL
                    AND TI.STATUS_TRACK = 3 
                    AND TI.POSISI = 'VENDOR'
                    AND TI.STATUS_DOC = 'BELUM KIRIM'
                    $where
        ";
        return $query;
    }

    public function _baseQueryFakturHeader($where = "",$order = "",$company = ''){
        $item_query = $this->_baseItemQuery();
        $order = $order == "" ? "ORDER BY CREATE_ON DESC" : $order;
        $company = $company == "" ? "WHERE COMPANY_CODE IN (0000)" : "WHERE COMPANY_CODE IN ($company)";
        $query = "
        SELECT A.*
        FROM(
            SELECT TO_CHAR(SUM(AMOUNTS)) AS AMOUNT
                ,ID_INVOICE
                ,FAKTUR_PJK
                ,FAKPJK_PIC
                ,NO_INVOICE
                ,UP_NO_INV
                ,MIR
                ,VENDOR_NO
                ,VENDOR
                ,NO_PO
                ,NOTE
                ,CURRENCY
                ,CREATE_ON
                ,CREATE_BY
                ,COMPANY_CODE
                ,F_STATUS
                ,F_REPORT_DATE
                ,CREATE_ON2
                ,F_STAT
                ,URL_FAKTUR
                ,XML_FAKTUR
                ,XML_FAKTUR2
                ,FKT_DATE
                ,F_FKT_DATE
                ,F_CRE_ON
            FROM(
                $item_query
            ) GROUP BY ID_INVOICE
                ,FAKTUR_PJK
                ,FAKPJK_PIC
                ,NO_INVOICE
                ,UP_NO_INV
                ,MIR
                ,VENDOR_NO
                ,VENDOR       
                ,NO_PO
                ,NOTE
                ,CURRENCY
                ,CREATE_ON
                ,CREATE_BY
                ,COMPANY_CODE
                ,F_STATUS
                ,F_REPORT_DATE
                ,CREATE_ON2
                ,F_STAT
                ,URL_FAKTUR
                ,XML_FAKTUR
                ,XML_FAKTUR2
                ,FKT_DATE
                ,F_FKT_DATE
                ,F_CRE_ON
        ) A
        $company
        $where
        $order
        ";
    return $query;
    }

    public function _whereQuery($where = '',$a = ''){
        $query = '';
        $i = 1;
        if($where != ''){
            foreach ($where as $key => $value) {
                if(count($where[$key])>1){
                    if($value['id']=='dRange'){
                        $date1 = $value['data'][0];
                        $date2 = $value['data'][1];
                        $query .= "AND $key >= $date1
                                   AND $key <= $date2";
                    }
                }else{    
                    if($a == '1'){
                        $query .= "AND $key = $value";
                    }else{
                        $query .= "AND $key LIKE '%$value%'";
                    }
                }
            }
        }
        return $query;
    }

    public function getListFaktur($where = '', $order = '', $limit = '', $company = ''){
        
        $w_query = $this->_whereQuery($where,0);
        $o_query = $order == '' ? 'ORDER BY CREATE_ON DESC' : "ORDER BY $order[0] $order[1]";

        $query = 'SELECT * FROM (select inner_query.*, rownum rnum FROM ( ';
        $query .= $this->_baseQueryFakturHeader($w_query,$o_query,$company);
        $min = $limit['offset'] + 1;
        $max = $limit['limit'] + $min;
        $query .= " ) inner_query WHERE rownum < $max) WHERE rnum >= $min";
        return $this->db->query($query,false)->result_array();
    }

    public function getFaktur($where,$company){
        $w_query = $this->_whereQuery($where,'1');
        $query = $this->_baseQueryFakturHeader($w_query,'',$company);
        return $this->db->query($query,false)->result_array();
    }

    public function getItemDetail($where){
        $w_query = $this->_whereQuery($where,'1');
        $query = $this->_baseItemQuery($w_query);
        return $this->db->query($query,false)->result_array();
    }

    public function countAllData($where = '', $company = ''){
        $w_query = $this->_whereQuery($where);
        $query = $this->_baseQueryFakturHeader($w_query,'',$company);
        return count($this->db->query($query,false)->result_array());
    }

    public function getListDownload($where = '', $id_invoice = '', $company = ''){
        
        $w_query = $this->_whereQuery($where);
        $w_query .= " AND ID_INVOICE IN ($id_invoice)";
        $query = $this->_baseQueryFakturHeader($w_query,'',$company);
        return $this->db->query($query,false)->result_array();

    }

    function Test(){
        $query = $this->_baseQueryFakturHeader();
        return count($this->db->query($query,false)->result_array());
    }
}

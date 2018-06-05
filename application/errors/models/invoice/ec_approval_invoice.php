<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_approval_invoice extends MY_Model {	
    public $table = 'EC_APPROVAL_INVOICE';
    public $primary_key = 'ID_INVOICE';	                                                
    
    public function insert($data){ 
        $this->db->set('CHDATE','sysdate',FALSE);
        $res = $this->db->insert($this->table,$data);
    }

    public function update($data,$id){
        $this->db->set('CHDATE','sysdate',FALSE);

        if(isset($data['APPROVAL'])){
            if ($data['APPROVAL'] == 1) {
                $this->db->set('APPROVAL_1_DATE','sysdate',FALSE);
            }else if ($data['APPROVAL'] == 2){
                $this->db->set('APPROVAL_2_DATE','sysdate',FALSE);
            }else{
                $this->db->set('APPROVAL_3_DATE','sysdate',FALSE);
            }
            unset($data['APPROVAL']);
        }else{
            $data['APPROVAL_1'] = '';
            $data['APPROVAL_1_DATE'] = '';
            $data['APPROVAL_2'] = '';
            $data['APPROVAL_2_DATE'] = '';
            $data['APPROVAL_3'] = '';
            $data['APPROVAL_3_DATE'] = '';
            $data['REJECT_NOTE'] = '';
        }

        $this->db->where('ID_INVOICE',$id);
        $res = $this->db->update($this->table,$data);
        return $res;
    }

    public function getDataApproval($array,$id_invoice){
        $res = array();
        foreach ($array as $key => $value) {
            $this->db->select('AE.FULLNAME,AP.POS_NAME');
            $this->db->from('EC_APPROVAL_INVOICE AI');
            $this->db->join('ADM_EMPLOYEE AE',"AI.$key = AE.ID");
            $this->db->join('ADM_POS AP','AE.ADM_POS_ID = AP.POS_ID');
            $this->db->where(array("AI.ID_INVOICE"=>$id_invoice));
            $hasil = $this->db->get()->result_array();

            if($hasil){
                $res[$key] = $hasil[0];
            }else{
                //echo $this->db->last_query();
                die('Invoice Ini Approval masih dilakukan secara manual sehingga lembar verifikasi belum bisa dicetak melalui E-Invoice');
            }
        }
        return $res;
    }

    public function getData($role){
        $sql = "
            SELECT AI.*,IH.*,VH.VENDOR_NAME,TO_CHAR(IH.INDATE,'DD-MM-YYYY') AS CREATE_DATE 
            FROM EC_APPROVAL_INVOICE AI    
            INNER JOIN EC_INVOICE_HEADER IH
                ON AI.ID_INVOICE = IH.ID_INVOICE AND IH.STATUS_HEADER = 5
            LEFT JOIN VND_HEADER VH
                ON IH.VENDOR_NO = VH.VENDOR_NO 
        ";

        $query = array();
        $i = 0;
        for ($i=0; $i < count($role); $i++) { 
            $query[$i] = $sql.'
                WHERE AI.STATUS = '.$role[$i]['STATUS'].'
                AND IH.COMPANY_CODE = '.$role[$i]['COMPANY'];
        }

        if(empty($role)){
            return array();
        }else{
            $query = implode(' UNION ', $query);
            $data = $this->db->query($query)->result_array();
            return $data;
        } 
    }

    public function get_Invoice($where_str = '', $order = '') {
        $sql = "SELECT distinct EIH.*
                ,TO_CHAR (EIH.INVOICE_DATE,'DD/MM/YYYY') AS INVOICE_DATE2
                ,TO_CHAR (EIH.FAKTUR_PJK_DATE,'DD/MM/YYYY') AS FAKTUR_PJK_DATE2
                ,TO_CHAR (EIH.CHDATE,'DD/MM/YYYY') AS CHDATE2
                ,ETI.STATUS_DOC
                ,ETI.POSISI
                ,AI.STATUS AS STATUS_APPROVAL
                ,AI.CHDATE AS TGL_APPROVAL
                ,VH.VENDOR_NAME AS VEND_NAME
                ,AI.APPROVAL_1 AS APPROVAL 
                FROM EC_APPROVAL_INVOICE AI
                JOIN EC_INVOICE_HEADER EIH
                    ON AI.ID_INVOICE = EIH.ID_INVOICE AND STATUS_HEADER = 5
                JOIN (SELECT max(".'"DATE"'.") LAST_UPDATE,ID_INVOICE FROM EC_TRACKING_INVOICE GROUP BY ID_INVOICE) TT
                        ON TT.ID_INVOICE = EIH.ID_INVOICE
                JOIN EC_TRACKING_INVOICE ETI
                    ON ETI.ID_INVOICE = EIH.ID_INVOICE AND POSISI = 'VERIFIKASI' AND STATUS_DOC = 'BELUM KIRIM' AND ETI.".'"DATE"'." = TT.LAST_UPDATE
                LEFT JOIN VND_HEADER VH 
                    ON EIH.VENDOR_NO = lpad(VH.VENDOR_NO,10,0)
                $where_str
                $order 
        ";

        $result = $this->db->query($sql);

        return (array) $result->result_array();
    }

}

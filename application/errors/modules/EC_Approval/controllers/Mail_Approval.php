<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mail_Approval extends MX_Controller {

    private $user;
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->load->model("invoice/ec_approval_invoice",'ai');
        $this->user = $this->session->userdata('FULLNAME');
    }

    public function emailApproval($id_invoice,$action,$id_user){
        $temp_user = $this->db->select('FULLNAME')->where('ID',$id_user)->get('ADM_EMPLOYEE')->row_array();
        $user = $temp_user['FULLNAME'];
        
        $data_invoice = $this->db->where('ID_INVOICE',$id_invoice)->get('EC_APPROVAL_INVOICE')->row_array();

        $status = $data_invoice['STATUS'] + 1;
        $more_1m = $data_invoice['TOTAL_PAYMENT'] >= 1000000000 ? 1:0;

        /*
            Jika nilai invoice <1M dan approval 2 maka status langsung diubah menjadi 3 
            Karena tidak membutuhkan approval 3 (Kadep)
        */
        $new_status = 0;

        if(!$more_1m && $status == 2){
            $new_status = 3;
        }else{$new_status = $status;}

        $data = array('STATUS' => $new_status,'APPROVAL' => $status);

        if($status == 1){
            $data['APPROVAL_1'] = $this->session->userdata('ID');
        }else if ($status == 2){
            $data['APPROVAL_2'] = $this->session->userdata('ID');
        }else{
            $data['APPROVAL_3'] = $this->session->userdata('ID');
        }
        $pesan = '';
        if($action == 'approve'){
            $res = $this->ai->update($data,$id_invoice);
            if($res){
                $pesan = 'Invoice Berhasil di Approve';
            }else{
                $pesan = 'Invoice Gagal di Approve';
            }
        }elseif($action == 'reject'){
            $data['STATUS'] = 4; // REJECT
            $data['REJECT_NOTE'] = 'REJECTED FROM E-MAIL';
            $res = $this->ai->update($data,$id_invoice);
            if($res){
                $pesan = 'Invoice Berhasil di Reject';
            }else{
                $pesan = 'Invoice Gagal di Reject';
            }
        }else{
            die("You  Don't Have Authorization To Take This Action");
        }
        echo "<script type='javascript'>alert('".$pesan."');</script>";
        die($pesan);
    }

    public function resumeRequestNotifikasi(){
        $sql = "SELECT USERNAME FROM EC_ROLE_USER WHERE ROLE_AS LIKE '%APPROVAL INVOICE%' AND STATUS = 1 GROUP BY USERNAME";
        $data = $this->db->query($sql)->result_array();

        foreach ($data as $value) {
            $roleAccess = $this->ai->getRoleUser($value['USERNAME']);
            $data_appr = $this->ai->getData($roleAccess);
            $email = $value['USERNAME'].'@SEMENINDONESIA.COM';
            $this->sendRequsetApprovalNotification($email,$data_appr);
           // var_dump($data_appr);
        }
    }

    public function sendRequsetApprovalNotification($email,$data){
            $fullname = $this->db->select('ID')->where('EMAIL',$email)->get('ADM_EMPLOYEE')->row_array();
            
            $table = $this->buildTable($data,$fullname['ID']);
        
            $data = array(
                'content' => '
                        List Invoice yang membutuhkan approval Per Tanggal '.date('d M Y H:i:s').' : <br>'
                        .$table,

                'title' => 'List Invoice Membutuhkan Approval Per '.date('d M Y H:i:s'),
                'title_header' => 'List Invoice Membutuhkan Approval Per '.date('d M Y H:i:s'),
                'url' => site_url('Login')
            );
            
            $message = $this->load->view('EC_Notifikasi/approveInvoice',$data,TRUE);
            $_to = $emailnya;

            $subject = 'List Invoice Membutuhkan Approval Per '.date('d M Y H:i:s').' [E-Invoice Semen Indonesia]';
            Modules::run('EC_Notifikasi/Email/invoiceNotifikasi',$_to,$message,$subject);
    }
    
    private function buildTable($listData,$fullname){
        $tableGR = array(
            '<table border=1 width="650" style="font-size:10px">'
        );
        $thead = '<thead>
                                <tr>
                                        <th style="text-align: center">NO</th>
                                        <th style="text-align: center">NO INVOICE</th>
                                        <th style="text-align: center">TGL DIBUAT</th>
                                        <th style="text-align: center">NO FAKTUR</th>
                                        <th style="text-align: center">JUMLAH AMOUNT</th>
                                        <th style="text-align: center">VENDOR</th>
                                        <th style="text-align: center">AKSI</th>
                                </tr>
                        </thead>
                ';
        $tbody = array();
        $no = 1;
        foreach($listData as $inv){
            $fp = $inv['FAKTUR_PJK'] == null ? '-' : $inv['FAKTUR_PJK'];
            $_tr = '<tr>
                    <td style="text-align: center">'.$no++.'</td>
                    <td>'.$inv['NO_INVOICE'].'</td>
                    <td style="text-align: center">'.$inv['INVOICE_DATE'].'</td>
                    <td style="text-align: center">'.$fp.'</td>
                    <td>'.$inv['CURRENCY'].' '.ribuan($inv['TOTAL_PAYMENT']).'</td>
                    <td>'.$inv['VENDOR_NAME'].'</td>
                    <td style="text-align: center">
                        <a target="_blank" href="'.base_url('EC_Approval/Mail_Approval/emailApproval').'/'.$inv['ID_INVOICE'].'/approve/'.$fullname.'" class="btn btn-sucess"><button type="button" style="background-color:lightgreen">Approve</button></a>
                        <a target="_blank" href="'.base_url('EC_Approval/Mail_Approval/emailApproval').'/'.$inv['ID_INVOICE'].'/reject/'.$fullname.'" class="btn btn-danger"><button type="button" style="background-color:red">Reject</button></a>
                    </td>
            </tr>';
            array_push($tbody,$_tr);
        }
        array_push($tableGR,$thead);
        array_push($tableGR,implode(' ',$tbody));
        array_push($tableGR,'</table>');
        return implode(' ',$tableGR);
    }

    public function test(){
        var_dump($this->session->userdata);
    }
}
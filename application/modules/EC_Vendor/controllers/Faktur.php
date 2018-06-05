<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Faktur extends MX_Controller {
    private $user;
    private $user_email;
    public function __construct() {
        parent::__construct();
        $this -> load -> helper('url');
        $this -> load -> library('Layout');
        $this -> load -> helper("security");
        $this->vendor_no = $this->session->userdata('VENDOR_NO');
        $this->load->model('invoice/ec_faktur_ekspedisi','fe');
    }

    public function index(){
        $this -> load -> library('Authorization');
        $data['title'] = "Ekspedisi Faktur Pajak";
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();

        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/ec_vendor_faktur.js?5');
        $this->layout->render('EC_Vendor/faktur/list', $data);
    }

    public function data(){
        $data = $this->fe->getData($this->session->userdata('VENDOR_NO'));    
        echo json_encode(array('data'=>$data));    

        // foreach ($data as $key => $val) {
        //     $no_po = "-";
        //     $ambilPO = $this->fe->getFaktur($val['NO_EKSPEDISI']);    
        //     if(!empty($ambilPO[0]['PO'])){
        //         $no_po = $ambilPO[0]['PO'];
        //     }
        //     $data[$key]['NOPO']=$no_po;
        // }
        // $data = array('data' => $data);
        // echo json_encode($data);
    }

    public function ekspedisiFaktur(){   
        $this->load->library('sap_invoice');
        $vendor=$this->db->select('VENDOR_TYPE, EMAIL_ADDRESS')->from('VND_HEADER')->where('VENDOR_NO', $this->session->userdata('VENDOR_NO'))->get()->result_array();                          
        $email=$this->input->post('email');
        // print_r($email);die;
        $email=$email[1];

        $nama=$this->input->post('nama');
        $nama=$nama[1];
        // echo $email;die;

        $jumlah=count($this->input->post('no_faktur'));
        $company=$this->input->post('company');
        $no_faktur=$this->input->post('no_faktur');
        $tgl_faktur=$this->input->post('tgl_faktur');    
        $dpp=$this->input->post('dasar_pajak');    
        $bast=$this->input->post('tgl_bast');
        $po=$this->input->post('po');  
        // $input_param=array(        
        //     'BUKRS' => $company,
        //     'LIFNR' => $this->session->userdata('VENDOR_NO'),
        //     'EMAIL' => $vendor[0]['EMAIL_ADDRESS']
        //     );
        $input_param=array(        
            'BUKRS' => $company,
            'LIFNR' => $this->session->userdata('VENDOR_NO'),
            'EMAIL' => $email,
            'PERSON' => $nama
            );  
        $input=array();
        foreach ($no_faktur as $i => $a) {
            $input_sap = array(
                'XBLNR' => $no_faktur[$i],
                'BLDAT' => $tgl_faktur[$i],
                'BEDAT' => $bast[$i],
                'HWBAS'=>$dpp[$i],
                'EBELN'=>$po[$i]            
                );       
            array_push($input, $input_sap);
        }    
        $act=$this->sap_invoice->setEkspedisiFaktur($input_param, $input);     
// var_dump($act);
// echo "<pre>";
// print_r($act);
// die();
        if($act){
            $tgl_sekarang=date("Ymd");
            if($act['pesan']['TYPE']==='S'){
                $data = array(        
                    'NO_EKSPEDISI'  => $act['noeks'],
                    'COMPANY'       => $this->input->post('company'),
                    'VENDORNO'      => $this->session->userdata('VENDOR_NO'),
                    'NATION'        => $vendor[0]['VENDOR_TYPE'],
                    'NAMA_SETOR'    => $nama,
                    'STATUS_SETOR'  => 1,
                    );    
                $this->db->trans_start();
                $this->db->set('TGL_EKSPEDISI',"to_date('".$tgl_sekarang."','YYYYMMDD')",false);  
                $this->db->insert('EC_FAKTUR_EAEA', $data);       
                foreach ($act['output'] as $i => $a) {
                    $data_detail = array(
                        'NO_EKSPEDISI' => $act['noeks'],
                        'NO_FAKTUR' => $act['output'][$i]['XBLNR'],
                        'TGL_FAKTUR' => $act['output'][$i]['BLDAT'],
                        'NPWP'=>$act['output'][$i]['STCD1'],
                        'DPP'=>$act['output'][$i]['HWBAS'],
                        'PPN'=>$act['output'][$i]['HWSTE'],
                        'TGL_BAST'=>$bast[$i],
                        'PO'=>$po[$i]
                        );       
                    $this->db->insert('EC_FAKTUR_DETAILS', $data_detail);
                }
                $this->db->trans_complete();
                $pesan = $act['pesan']['MESSAGE'].' Dengan Ekspedisi No.'.$act['noeks'];
                $this->session->set_flashdata('message', $pesan);
                redirect('EC_Vendor/Faktur');
            } else {
                $pesan = '[ERROR] '.$act['pesan']['MESSAGE'];
                $this->session->set_flashdata('message', $pesan);
                redirect('EC_Vendor/Faktur/ekspedisi');
            }                 
        }else{
            die('GAGAL');
        }
    }  

    public function cetakDocument() {
        $this->load->config('ec');
        $kirim['ekspedisi'] = $this->input->post('id');
        $company_code = $this->input->post('company');
        $kirim['vendor_name']=$this->session->userdata('VENDOR_NAME');
        $kirim['vendor_no']=$this->session->userdata('VENDOR_NO');
        $this->load->library('M_pdf');
        $mpdf = new M_pdf();

        $kirim['nation']=$this->db->select('VENDOR_TYPE')->from('VND_HEADER')->where('VENDOR_NO', $this->session->userdata('VENDOR_NO'))->get()->result_array();            
        $company_data = $this->config->item('company_data');                
        $kirim['company_data'] = $company_data[$company_code];  
        $kirim['data']=$this->fe->getFaktur($kirim['ekspedisi']);            
        $kirim['data_header']=$this->fe->getDataEkspedisi($kirim['ekspedisi']);            
        $html = $this->load->view('EC_Vendor/faktur/cetak', $kirim, TRUE);

        $mpdf->pdf->writeHTML($html);
        $footer_rr = $this->load->view('EC_Vendor/faktur/footer', $kirim, TRUE);
        $mpdf->pdf->SetHTMLFooter($footer_rr);
        $mpdf->pdf->output('Ekspedisi Faktur Pajak No. ' . $kirim['ekspedisi'] . '.pdf', 'I');
    }

    public function ekspedisi($id = '') {
        $this->layout->set_table_js();
        $this->layout->set_table_cs();  
        $data['title'] = "Form Faktur Pajak";
        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('jquery.priceFormat.min.js');
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/invoice/ec_vendor_faktur.js?2');      

        $data['urlAction'] = site_url('EC_Vendor/Faktur/ekspedisiFaktur/');

        $this->layout->render('faktur/form', $data);
    }      
}

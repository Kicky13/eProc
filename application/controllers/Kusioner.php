<?php defined('BASEPATH') OR exit('No direct script access allowed');

// class Kusioner extends CI_Controller {
class Kusioner extends MX_Controller {

	public function __construct()
	{
		// parent::__construct();
		// $this->load->database('default', TRUE);

        parent::__construct();
        $this -> load -> helper('url');
        $this -> load -> library('Layout');
        $this -> load -> helper("security");
	}

	function index(){
        if ($this->session->userdata("logged_in")==1) {
            $has_done = $this->db->select_max("YEARS")->where("COMPANY",$this->session->userdata("COMPANYID"))->where("VENDOR_NO",$this->session->userdata("VENDOR_NO"))
                        ->from("SV_IDENTITY")->get()->row()->YEARS;
            if(date('Y',strtotime($has_done)) == date("Y")){
                $data['title'] = "Kuisioner";
                $this->layout->render("kusioner/has_done",$data);
            }else{
                $data['title'] = "Kuisioner";
                $data['responden'] = $this->db->select("CONTACT_NAME, CONTACT_POS, ADDRESS_STREET")->where("VENDOR_NO",$this->session->userdata("VENDOR_NO"))
                                    ->from("VND_HEADER")->get()->result_array();
                $this->layout->render("kusioner/main_page",$data);
            }
        }else{
            redirect(base_url()."Login_vendor");
        }
	}

	function save_form(){
		$identity = array("NM_PERUSAHAAN"=>  $this->input->post("nm_perusahaan"),
                            "NAMA"=>  $this->input->post("nm"),
                            "UMUR"=> $this->input->post("umur"),
                            "JNS_KEL"=>  $this->input->post("jns_kel"),
                            "ALAMAT"=> $this->input->post("alamat"),
                            "JABATAN"=>  $this->input->post("jabatan"),
                            "COMPANY"=> $this->session->userdata("COMPANYID"),
                            "VENDOR_NO"=> $this->session->userdata("VENDOR_NO"),"YEARS"=> date('d-M-Y g.i.s A'));
        $ask2a = array("ASK_2A1"=>  $this->input->post("a1"),"ASK_2A2"=>  $this->input->post("a2"),
                        "ASK_2A3"=>  $this->input->post("a3"),"ASK_2A4"=>  $this->input->post("a4"),
                        "ASK_2A5"=>  $this->input->post("a5"),"ASK_2A6"=>  $this->input->post("a6"),
                        "ASK_2A7"=>  $this->input->post("a7"),"ASK_2A8"=>  $this->input->post("a8"),
                        "ASK_2A9"=>  $this->input->post("a9"),"ASK_2A10"=>  $this->input->post("a10"),
                        "VENDOR_NO"=> $this->session->userdata("VENDOR_NO"),"YEARS"=> $identity["YEARS"]);
        $ask2b = array("ASK_2B1"=>  $this->input->post("b1"),"ASK_2B2"=>  $this->input->post("b2"),
                        "ASK_2B3"=>  $this->input->post("b3"),"ASK_2B4"=>  $this->input->post("b4"),
                        "ASK_2B5"=>  $this->input->post("b5"),"VENDOR_NO"=> $this->session->userdata("VENDOR_NO"),
                        "YEARS"=> $identity["YEARS"]);
        $ask2c = array("ASK_2C1"=>  $this->input->post("c1"),"ASK_2C2"=>  $this->input->post("c2"),
                        "ASK_2C3"=>  $this->input->post("c3"),"ASK_2C4"=>  $this->input->post("c4"),
                        "ASK_2C5"=>  $this->input->post("c5"),"VENDOR_NO"=> $this->session->userdata("VENDOR_NO"),
                        "YEARS"=> $identity["YEARS"]);
        
        $this->db->insert("SV_IDENTITY",$identity);
        $this->db->insert("SV_TB_ASK2_A",$ask2a);
        $this->db->insert("SV_TB_ASK2_B",$ask2b);
        $this->db->insert("SV_TB_ASK2_C",$ask2c);

        echo json_encode(array("status"=> true));
	}

	function success(){
        // $data['title'] = "Kuisioner";
        $this->load->view("kusioner/success");
		// $this->layout->render("kusioner/success");
	}

    // mail broadcast vendor
    function temp_invite($link,$email,$pass){
            return '<p><img src="http://sementonasa.co.id/registrasi_ulang/assets_reg/img/logo.png" alt="" width="59" height="59" /></p>
<p>Dear Peserta Talent Scouting D3 PT Semen Tonasa tahun 2017,</p>
<p>&nbsp;</p>
<p>Sebagai tindak lanjut Sosialisasi Talent Scouting D3 PT Semen Tonasa tahun 2017, silahkan Saudara/i melakukan registrasi peserta melalui link berikut :</p>
<p>&nbsp;</p>
<table>
<tbody>
<tr>
<td width="184">
<p>Link Registrasi</p>
</td>
<td width="29">
<p>:</p>
</td>
<td width="723">
<p><a href="'.$link.'">Registrasi Talent Scouting D3</a></p>
</td>
</tr>
<tr>
<td width="184">
<p>Username</p>
</td>
<td width="29">
<p>:</p>
</td>
<td width="723">
<p>'.$email.'</p>
</td>
</tr>
<tr>
<td width="184">
<p>Password</p>
</td>
<td width="29">
<p>:</p>
</td>
<td width="723">
<p>'.$pass.'</p>
</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<p>Browser yang direkomendasikan untuk membuka link registrasi : <strong>Google Chrome</strong></p>
<p>Batas akhir registrasi pada tanggal <strong>19 Oktober 2017 </strong>jam<strong> 23.59 WITA.</strong></p>
<p>Apabila mengalami kendala pada saat melakukan Login/registrasi/cetak kartu tes silahkan menghubungi : <strong>talentscoutingd3.st@semenindonesia.com</strong></p>
<p>&nbsp;</p>
<p>Besar harapan kami untuk dapat menyeleksi kandidat terbaik untuk menjadi bagian dari Keluarga Besar PT Semen Tonasa.</p>
<p>Demikian kami sampaikan, atas perhatiannya diucapkan terima kasih.</p>
<p>&nbsp;</p>
<p>Pangkep, 16 Oktober 2017</p>
<p>PT Semen Tonasa</p>
<p>&nbsp;</p>
<p>Ttd.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><strong><u>Tim Talent Scouting D3</u></strong></p>';
        }
        
        function email_invite(){
         // $receptor = $this->Modpeg_st->get_email()->result_array();
            $receptor = array();
            array_push($receptor, array("EMAIL"=>"amin.erfandy@sisi.id"));
            array_push($receptor, array("EMAIL"=>"amin.erfandy@sisi.id"));
            echo "<pre>";
            print_r($receptor);
            exit();
         $total = 0;
         $isi = array();
         for($i=0;$i<count($receptor);$i++){
         $mailer = 'talentscoutingd3.st@semenindonesia.com';    
         $config = Array(        
                'protocol' => 'smtp',
                'smtp_host' => 'mail.sisi.id',
                'smtp_port' => 25, //465,
                'smtp_user' => 'yoseph.lake@sisi.id',
                'smtp_pass' => 'blink182',
                'smtp_crypto' => 'tls',
                'smtp_timeout' => '20',
                'mailtype'  => 'html', 
                'charset'   => 'iso-8859-1'
            );  
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->clear(TRUE);
            $this->email->from($mailer, 'Tim Talent Scouting D3 PT Semen Tonasa');
            $this->email->to($receptor[$i]["EMAIL"]);
            $this->email->subject('Talent Scouting D3 PT Semen Tonasa 2017');
            $link = "http://sementonasa.co.id/registrasi_ulang/index.php/Cpeg_st/register_ulang/".$receptor[$i]["ID_CODE"];  
            $password = $this->random_password();
            $new_user_pass = array("ID_CODE"=>$receptor[$i]["ID_CODE"],"PASSWD"=>$password);
            $this->Modpeg_st->save_pass($new_user_pass);
            $message= $this->temp_invite($link,$receptor[$i]["EMAIL"],$password);
            $this->email->message($message);
            $this->email->send();
            array_push($isi, $receptor[$i]["EMAIL"]);
            $total++;
        }
        echo '<pre>';
        echo 'Email Sukses Terkirim ke '.$total.' Email';
        print_r($isi);
        }


}
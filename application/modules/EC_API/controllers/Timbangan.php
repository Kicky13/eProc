<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions

class Timbangan extends REST_Controller
{
  protected $_timbangan = 'TIMBANGAN';
  protected $_transaksiBlok = 'TRANSAKSI_BLOK';
  protected $_timbanganSAP = 'TIMBANGAN_SAP';
  protected $_timbanganError = 'TIMBANGAN_ERROR';
  protected $_homeFolder = '/home/ftpuser/';
  protected $ftpServer = array(
  /*  'host' => 'ftp.epizy.com',
    'user' => 'epiz_20116704',
    'pass' => 'k2jik3r3n' */
    'hostname' => '10.15.2.88',
    'username' => 'ftpuser',
    'password' => 'indonesia17#'
  );
	function __construct()
    {
        // Construct our parent class
        parent::__construct('rest_ptpn');
        $this->load->library('ftp');
        // Configure limits on our controller methods. Ensure
        // you have created the 'limits' table and enabled 'limits'
        // within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; //500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key
    }
		/* contoh memanggil http://10.15.5.150/dev/eproc/EC_API/Api/users/X-API-KEY/0sgkkkcogggwg8gs8kwgswcggw0gko4c4wws0wc8
			 nilai X-API-KEY didapatkan dari database
		*/
    /* yang dikirim sudah dalam bentuk array saja
    *
    */
    function index_post()
    {
        $result = array('status' => 0, 'message' => array());
        $data = $this->post('data');
        $multipleValue = array(
          $this->_transaksiBlok
        );
        if(empty($data))
        {
        	$this->response(NULL, 400);
        }
        $this->db->trans_begin();
        foreach($data as $key => $val){
          $key = strtoupper($key);
          if(in_array($key,$multipleValue)){
            foreach($val as $_val){
              $result['message'][] = $this->save($_val,$key);
            }
          }else{
            $result['message'][] = $this->save($val,$key);
          }

        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->response($result, 200); // 200 being the HTTP response code
        } else {
            $this->db->trans_commit();
            $result['status'] = 1;
            $this->response($result, 200); // 200 being the HTTP response code
        }
    }

    function index_get()
    {
        $data = $this->db->get($this->_timbangan)->result_array();

        /* isi data ke tabel, periksa dulu  */
        $result = array(
          'status' => 0,
          'content' => 'Data tidak ditemukan'
        );

        if(!empty($data)){
          $result['status'] = 1;
          $result['content'] = $data;
        }

    	  //$result = $this->save($data);
        $this->response($result, 200); // 200 being the HTTP response code
    }

    function schema_get(){
      $tables = array(
        $this->_timbangan, $this->_transaksiBlok
      );
      $result = array('status' => 1, 'message' => array());
      foreach($tables as $t){
        $result['message'][$t] = $this->db->list_fields($t);
      }
      $this->response($result, 200); // 200 being the HTTP response code
    }

    function save($data,$tabel){
      /* periksa dulu jika sudah ada maka update*/
      $result = array('status' => 0, 'message' => '', 'key' => '');
      $tabel = strtoupper($tabel);
      $data = array_change_key_case($data,CASE_UPPER);
      //log_message('error',$this->convertArrToString($data));
      /* awal ==> kolom yang mengandung tanggal untuk tabel timbangan, nanti kalau sudah dibetulkan sumber datanya  nanti dihapus aja */
/*
      $kolomTanggal = array(
        $this->_timbangan => array('TGLMASUK','TGLBRONDOLAN','TGLKELUAR','CREATEDATE','LASTUPDATEDATE')
      );
      $kolomWaktu = array(
        $this->_timbangan => array('CREATETIME','LASTUPDATETIME')
      );
      $defaultValue = array(
        $this->_timbangan => array('UOM' => 'KG')
      );
      if(isset($kolomTanggal[$tabel])){
        foreach($kolomTanggal[$tabel] as $_fieldTgl){
          if(isset($data[$_fieldTgl])){
              if(!empty($data[$_fieldTgl])){
                  $data[$_fieldTgl] = $this->betulkanFormatTgl($data[$_fieldTgl]);
              }
          }
        }
      }

      if(isset($kolomWaktu[$tabel])){
        foreach($kolomWaktu[$tabel] as $_fieldWaktu){
          if(isset($data[$_fieldWaktu])){
              if(!empty($data[$_fieldWaktu])){
                  $data[$_fieldWaktu] = $this->betulkanFormatWaktu($data[$_fieldWaktu]);
              }
          }
        }
      }

      if(isset($defaultValue[$tabel])){
        $_keyDefaultValue = array_keys($defaultValue[$tabel]);
        foreach($_keyDefaultValue as $_fieldDef){
          if(isset($data[$_fieldDef])){
              if(empty($data[$_fieldDef])){
                  $data[$_fieldDef] = $defaultValue[$tabel][$_fieldDef];
              }
          }
        }
      }
      */
        /* akhir ==> kolom yang mengandung tanggal untuk tabel timbangan, nanti kalau sudah dibetulkan sumber datanya  nanti dihapus aja */

      $Fieldkey = array(
        $this->_timbangan => array('CHITNO'),
        $this->_transaksiBlok => array('CHITNO','LOKASICODE','AFDELINGCODE','BLOKCODE'),
        $this->_timbanganSAP => array('CHITNO','MAT_DOC','DOC_YEAR','MVT'),
        $this->_timbanganError => array()
      );
      $key = array();
      foreach($Fieldkey[$tabel] as $_f){
        $key[$_f] = $data[$_f];
      }
      $ada = array();
      if(!empty($key)){
        $ada = $this->db->where($key)->get($tabel)->row();
      }
      if(!empty($ada)){
        if($this->db->where($key)->update($tabel,$data)){
          $result['status'] = 1;
          $result['message'] = 'Berhasil Update '.$tabel;
          $result['key'] = $key;

        }
      }else{
        if($this->db->insert($tabel,$data)){
          $result['status'] = 1;
          $result['message'] = 'Berhasil Insert '.$tabel;
          $result['key'] = $key;
        }
      }
      return $result;
    }
    function listRemoteFile($remoteFolder){
      $result = array('status' => 0, 'content' => array());
      $this->ftp->connect($this->ftpServer);
      $this->ftp->changedir($remoteFolder);
      $files = $this->ftp->list_files();
      return $files;
    }

    function listRemoteFileReceive_get(){
      $remoteFolder = 'sharing/receive';
      $files = $this->listRemoteFile($remoteFolder);
      $result = array('status' => 1, 'content' => $files);
      $this->response($result,200);
    }

    function listRemoteFileError_get(){
      $remoteFolder = 'sharing/error';
      $files = $this->listRemoteFile($remoteFolder);
      $result = array('status' => 1, 'content' => $files);
      $this->response($result,200);
    }

    function listRemoteFileSend_get(){
      $remoteFolder = 'sharing/send';
      $files = $this->listRemoteFile($remoteFolder);
      $result = array('status' => 1, 'content' => $files);
      $this->response($result,200);
    }

    function listRemoteFileArchiveReceive_get(){
      $remoteFolder = 'sharing/archive/receive';
      $files = $this->listRemoteFile($remoteFolder);
      $result = array('status' => 1, 'content' => $files);
      $this->response($result,200);
    }

    function listRemoteFileArchiveSend_get(){
      $remoteFolder = 'sharing/archive/send';
      $files = $this->listRemoteFile($remoteFolder);
      $result = array('status' => 1, 'content' => $files);
      $this->response($result,200);
    }

    function listRemoteFileArchiveError_get(){
      $remoteFolder = 'sharing/archive/error';
      $files = $this->listRemoteFile($remoteFolder);
      $result = array('status' => 1, 'content' => $files);
      $this->response($result,200);
    }



    /* update status di SAP dan pindahkan file yang sudah dibaca di folder receive*/
    function bacaFile_get(){
      $this->load->library('CSVReader');
      $remoteFolder = 'sharing/receive';
      $files = $this->listRemoteFile($remoteFolder);
      $fileRemote = array();
      $remoteFolder = $this->_homeFolder.$remoteFolder;
      $_result = array();
      $result= array('status' => 0, 'message' => '');
      if(!empty($files)){
        $this->db->trans_begin();
        foreach($files as $f){
          $filename = "ftp://".$this->ftpServer['username'].":".$this->ftpServer['password']."@".$this->ftpServer['hostname'].$remoteFolder."/".$f;
          $csvData = $this->csvreader->parse_file($filename);
          if(!empty($csvData)){
            foreach($csvData as $item){
               $_tmp = $this->save($item,$this->_timbanganSAP);
               array_push($_result,$_tmp['message']);
               /* update status SAP */
               $this->updateStatusSAP($item['CHITNO']);
            }
          }
          $this->moveFileReceive($f);
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $result['message'] = 'Data gagal insert';
            $this->response($result, 200); // 200 being the HTTP response code
        } else {
            $this->db->trans_commit();
            $result['message'] = $_result;
            $result['status'] = 1;
            $this->response($result, 200); // 200 being the HTTP response code
        }
      }else{
        $result['message'] = 'File tidak ditemukan';
        $this->response($result, 200);
      }
    }

    /* update status di SAP dan pindahkan file yang sudah dibaca di folder receive*/
    function bacaFileError_get(){
      $this->load->library('CSVReader');
      $remoteFolder = 'sharing/error';
      $files = $this->listRemoteFile($remoteFolder);
      $fileRemote = array();
      $remoteFolder = $this->_homeFolder.$remoteFolder;
      $_result = array();
      $result= array('status' => 0, 'message' => '');
      if(!empty($files)){
        $this->db->trans_begin();
        foreach($files as $f){
          $filename = "ftp://".$this->ftpServer['username'].":".$this->ftpServer['password']."@".$this->ftpServer['hostname'].$remoteFolder."/".$f;
          $csvData = $this->csvreader->parse_file($filename);
          if(!empty($csvData)){
            foreach($csvData as $item){
               $_tmp = $this->save($item,$this->_timbanganError);
               array_push($_result,$_tmp['message']);
            }
          }
          $this->moveFileError($f);
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $result['message'] = 'Data gagal insert';
            $this->response($result, 200); // 200 being the HTTP response code
        } else {
            $this->db->trans_commit();
            $result['message'] = $_result;
            $result['status'] = 1;
            $this->response($result, 200); // 200 being the HTTP response code
        }
      }else{
        $result['message'] = 'File tidak ditemukan';
        $this->response($result, 200);
      }
    }


    function updateStatusSAP($chitno){
      $key = array('CHITNO' => $chitno);
      $dataUpdate = array('STATUSSAP' => 1);
      $this->db->where($key)->update($this->_timbangan,$dataUpdate);
    }

    /* jika sudah dibaca maka, pindahkan file tersebut ke folder archive */
    function moveFile($filename,$folder){
      $receiveFolder = 'sharing/'.$folder.'/';
      $archiveReceiveFolder = 'sharing/archive/'.$folder.'/';
      $this->ftp->connect($this->ftpServer);
      $this->ftp->move($receiveFolder.$filename,$archiveReceiveFolder.$filename);
      //$this->ftp->move($sendFolder.$filename,$archiveSendFolder.$filename);
    }

    /* jika sudah dibaca maka, pindahkan file tersebut ke folder archive */
    function moveFileReceive($filename){
      $this->moveFile($filename,'receive');
      //$this->ftp->move($sendFolder.$filename,$archiveSendFolder.$filename);
    }

    /* jika sudah dibaca maka, pindahkan file tersebut ke folder archive */
    function moveFileError($filename){
      $this->moveFile($filename,'error');
    }

    function moveFileSend($filename){
      $this->moveFile($filename,'send');
    }

    function readRemoteFile_get(){
      $this->load->helper('download');
      $_filename = $this->get('filename');
      $_location = $this->get('location');
      $_mode = $this->get('mode');
      $location = $_mode == 'archive' ? 'archive/'.$_location : $_location;
      $remoteFolder = $this->_homeFolder."sharing/".$location.'/'.$_filename;
      $filename = "ftp://".$this->ftpServer['username'].":".$this->ftpServer['password']."@".$this->ftpServer['hostname'].$remoteFolder;

      $handle = fopen($filename, "r");
      $contents = fread($handle, filesize($filename));

      fclose($handle);
      force_download($_filename, $contents);
    }



    function generateCsv_get(){
      $this->load->library('CSVReader');
      /* update counter_send +1 */
      $updateCounter = $this->updateCounterSend();
      $data = $this->db->where(array('STATUSSAP' => 0))->get($this->_timbangan)->result_array();

      $filename = date('YmdHis').'.txt';
      //log_message('error',$filename);
      /* pindahkan ke folder archive */
      $remoteFolderSend = 'sharing/send';
      $files = $this->listRemoteFile($remoteFolderSend);
      if(!empty($files)){
        foreach($files as $f){
          $this->moveFileSend($f);
        }
      }

      $remote_folder ='sharing/send';
      $result = $this->csvreader->data_to_csv_ftp($this->ftpServer,$data,TRUE,$remote_folder,$filename);
      $this->response($result,200);
    }

    function updateCounterSend(){
      $sql = <<<SQL
        update TIMBANGAN set COUNTER_SEND = COUNTER_SEND + 1 where STATUSSAP = 0
SQL;
      $this->db->query($sql);
    }

    function copyFile_get(){
      $conn_id = ftp_connect($this->ftpServer['host']);
      $login_result = ftp_login($conn_id, $this->ftpServer['user'], $this->ftpServer['pass']);
      $remote_folder ='sharing/send';
      if($login_result){
        ftp_chdir($conn_id,$remote_folder);
        ftp_rename($conn_id,'mv *.txt ../receive');
      }
      ftp_close($conn_id);
    }

    function _mappingFile($arrFile){

      $map = array(
        'NO_TIMBANG','TGL_TIMBANG','NO_PO','PETUGAS'
      );
      $result = array();
      foreach($arrFile as $k => $v){
        $result[$map[$k]] = $v;
      }
      return $result;
    }
    /* rubah format indonesia ke fromat sap */
    private function betulkanFormatTgl($tgl){
      //list($d, $m, $y) = sscanf($tgl, '%02d%02d%04d');
      $r = explode('/',$tgl);
      $result = $r[2].str_pad($r[0],2,0,STR_PAD_LEFT).str_pad($r[1],2,0,STR_PAD_LEFT);
      return $result;
    }

    /* rubah format indonesia ke fromat sap */
    private function betulkanFormatWaktu($waktu){
      return str_pad(str_replace(':','',$waktu),6,0,STR_PAD_RIGHT);
    }

    private function convertArrToString($input){
      $result = array();
      foreach($input as $k => $v){
        array_push($result,$k.' => '.$v);
      }
      return implode(' \n ',$result);
    }
}

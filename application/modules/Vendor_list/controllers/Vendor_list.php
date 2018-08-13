<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_List extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model(array('vnd_header'));
	}

	public function index() {
		$data['title'] = "List All Vendor";
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('pages/vnd_list.js?5');
		// $this->layout->add_js(base_url().'Assets/Vendor_list/assets/vnd_list.js', TRUE);
		$this->layout->render('list_vendor', $data);
	}

	public function komoditi() {
		$data['title'] = "List Komoditi Barang All Vendor";
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('pages/vnd_list.js?5');
		// $this->layout->add_js(base_url().'Assets/Vendor_list/assets/vnd_list.js', TRUE);
		$this->layout->render('list_vendor_komoditi', $data);
	}

	public function komoditi_bahan() {
		$data['title'] = "List Komoditi Bahan All Vendor";
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('pages/vnd_list.js?5');
		// $this->layout->add_js(base_url().'Assets/Vendor_list/assets/vnd_list.js', TRUE);
		$this->layout->render('list_vendor_komoditi_bahan', $data);
	}

	public function komoditi_jasa() {
		$data['title'] = "List Komoditi Jasa All Vendor";
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('pages/vnd_list.js?5');
		// $this->layout->add_js(base_url().'Assets/Vendor_list/assets/vnd_list.js', TRUE);
		$this->layout->render('list_vendor_komoditi_jasa', $data);
	}

	function get_vendor() {
		$opco = $this->session->userdata['EM_COMPANY'];
        $role = $this->session->userdata['GRPAKSES'];

        $this->load->model('vendor_detail');
        $data_vendor = array();

        $prod = $this->input->post('item');

        if ($role == 501){
            $datatable_vnd = $this->vendor_detail->vnd_table_prod_all($prod);
            if(!empty($datatable_vnd)){
                foreach ($datatable_vnd as $key => $val) {
                    array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_ID'],"VENDOR_NO" =>$val['VENDOR_NO'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS'], "EMAIL_ADDRESS"=>$val['EMAIL_ADDRESS'], "STATUS_PERUBAHAN"=>$val['STATUS_PERUBAHAN']));
                }
            }

            $datatable_tmp = $this->vendor_detail->tmp_table_prod_all($prod);
            if(!empty($datatable_tmp)){
                foreach ($datatable_tmp as $key => $val) {
                    array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_ID'],"VENDOR_NO" =>$val['VENDOR_NO'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS'], "EMAIL_ADDRESS"=>$val['EMAIL_ADDRESS']));
                }
            }

        }else {
            $datatable_vnd = $this->vendor_detail->vnd_table_prod($prod,$opco);
            if(!empty($datatable_vnd)){
                foreach ($datatable_vnd as $key => $val) {
                    array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_ID'],"VENDOR_NO" =>$val['VENDOR_NO'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS'], "EMAIL_ADDRESS"=>$val['EMAIL_ADDRESS'], "STATUS_PERUBAHAN"=>$val['STATUS_PERUBAHAN']));
                }
            }

            $datatable_tmp = $this->vendor_detail->tmp_table_prod($prod,$opco);
            if(!empty($datatable_tmp)){
                foreach ($datatable_tmp as $key => $val) {
                    array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_ID'],"VENDOR_NO" =>$val['VENDOR_NO'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS'], "EMAIL_ADDRESS"=>$val['EMAIL_ADDRESS']));
                }
            }

        }

        $data = array('data' => $data_vendor); 
        echo json_encode($data);
    }

    public function exportKomoditi($item){
      $opco = $this->session->userdata['EM_COMPANY'];
      if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
         $opco = 'IN(\'7000\',\'2000\',\'5000\')';
     } else {
         $opco = '='.$opco.'';
     } 
        //membuat objek
    	$this->load->library('excel');//Load library excelnya
    	$this->load->model('vendor_detail');
    	// $this->load->model('adm_wilayah');
    	// $iduser = $this -> session -> userdata['ID'];
    	// $KODE_VENDOR = $this -> input -> get('KODE_VENDOR');
    	$objPHPExcel = new PHPExcel();
        // Nama Field Baris Pertama
    	// $prod = $this->input->post('item');
    	// $prod = $item;
    	// echo "<pre>";
    	// print_r($prod);
    	// die;
    	if($item=="list_vendor_komoditi"){
    		$ambilBarang = $this->vendor_detail->produkAll($opco);
    	} else if($item=="list_vendor_komoditi_bahan"){
    		$ambilBarang = $this->vendor_detail->bahanAll($opco);
    	} else if($item=="list_vendor_komoditi_jasa"){
    		$ambilBarang = $this->vendor_detail->produk_jasaAll($opco);
    	}
    	// echo "<pre>";
    	// print_r($ambilBarang);
    	// die;

    	//SET AUTO WIDTH
    	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
    	// $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true);
    	// echo "<pre>";
    	// print_r($colString);
    	// die;

    	$col = 0;
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "No");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "Group Barang");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, "Sub Group");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, "Nama Produk");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, "Merk");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, "Sumber");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, "Tipe");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, "No. Agent");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, "Sampai");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, "Vendor No");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, "Vendor Name");
    	

    	// Mengambil Data
    	$row = 2;
    	$i = 1;
    	// $in = 0;
    	foreach ($ambilBarang as $value){
    		// echo"<pre>";
    		// print_r($value['PRODUCT_NAME']);die;
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, ($i));
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value['PRODUCT_NAME']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $value['PRODUCT_SUBGROUP_NAME']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $value['PRODUCT_DESCRIPTION']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $value['BRAND']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $value['SOURCE']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $value['TYPE']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $value['NO']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $value['EXPIRED_DATE']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $value['VENDOR_NO']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $value['VENDOR_NAME']);
    		$i++;
    		$row++;
    		// $in++;
    	}

    	$objPHPExcel->setActiveSheetIndex(0);

        //Set Title
    	$objPHPExcel->getActiveSheet()->setTitle('Komoditi vendor');
    	
    	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        //Header
    	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    	header("Cache-Control: no-store, no-cache, must-revalidate");
    	header("Cache-Control: post-check=0, pre-check=0", false);
    	header("Pragma: no-cache");
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        //Nama File
    	header('Content-Disposition: attachment;filename="Komoditi_vendor.xlsx"');

        //Download
    	$objWriter->save("php://output");

    }

    function get_vendor_komoditi() {
    	$opco = $this->session->userdata['EM_COMPANY'];
    	if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
    		$opco = 'IN(\'7000\',\'2000\',\'5000\')';
    	} else {
    		$opco = '='.$opco.'';
    	}
    	$this->load->model('vendor_detail');
    	$this->load->model('adm_wilayah');
    	$data_vendor = array();

    	$prod = $this->input->post('item');
    	if($prod=="list_vendor_komoditi"){
    		$ambilBarang = $this->vendor_detail->produkAll($opco);
    	} else if($prod=="list_vendor_komoditi_bahan"){
    		$ambilBarang = $this->vendor_detail->bahanAll($opco);
    	} else if($prod=="list_vendor_komoditi_jasa"){
    		$ambilBarang = $this->vendor_detail->produk_jasaAll($opco);
    	}
		// echo "<pre>";
		// print_r($ambilBarang);die;
    	if(!empty($ambilBarang)){
    		foreach ($ambilBarang as $key => $val) {

    			if (!empty($val['FILE_UPLOAD'])){
    				$LINK = '<a href="'.base_url('Vendor_list').'/viewDok/'.$val['FILE_UPLOAD'].'" class="previousfile" target="_blank" >'.$val['NO'].'</a>'; 
    			} else {  
    				$LINK = $val['NO']; 
    			}

    			if($val['ISSUED_DATE']==""){
    				$ISSUED_DATE = "-";
    			} else {
    				$ISSUED_DATE = Date("d M Y",oraclestrtotime($val['ISSUED_DATE']));
    			}

    			if($val['EXPIRED_DATE']==""){
    				$EXPIRED_DATE = "-";
    			} else {
    				$EXPIRED_DATE = Date("d M Y",oraclestrtotime($val['EXPIRED_DATE']));
    			}
    			$city = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'KOTA')));
    			$city_list = array();
    			foreach ($city as $key => $value) {
    				$city_list[$key] = $value;
    			}
    			$data['city_list'] = $city_list;
    			$dom = $this->vendor_detail->domisili_perusahaan($val['VENDOR_ID']);
    			foreach ($dom as $key) {}
    				$data['domisili'] = $key;
    			$ADDRESS_CITY = $city_list[$data['domisili']["ADDRESS_CITY"]];

    			array_push($data_vendor, array(
    				"VENDOR_ID"=>$val['VENDOR_ID'],
    				"VENDOR_NO" =>$val['VENDOR_NO'],
    				"VENDOR_NAME"=>$val['VENDOR_NAME'],
    				"STATUS"=>$val['STATUS'],
    				"PRODUCT_NAME"=>$val['PRODUCT_NAME'],
    				"PRODUCT_SUBGROUP_NAME"=>$val['PRODUCT_SUBGROUP_NAME'],
    				"KLASIFIKASI_NAME"=>$val['KLASIFIKASI_NAME'],
    				"SUBKUALIFIKASI_NAME"=>$val['SUBKUALIFIKASI_NAME'],
    				"NO"=>$LINK,
    				"ISSUED_BY"=>$val['ISSUED_BY'],
    				"ISSUED_DATE"=>$ISSUED_DATE,
    				"EXPIRED_DATE"=>$EXPIRED_DATE,

    				"PRODUCT_DESCRIPTION"=>$val['PRODUCT_DESCRIPTION'],
    				"SOURCE"=>$val['SOURCE'],
    				"TYPE"=>$val['TYPE'],

    				"BRAND"=>$val['BRAND'],

    				"ADDRESS_CITY"=>$ADDRESS_CITY,
    				)
    			);
    		}
    	}		
    	$data = array('data' => $data_vendor); 
    	echo json_encode($data);
    }

    function get_vendor_exp($no=0,$name=0,$update=0,$reg=0,$email=0,$produk=0){ 
    	$this->load->model('vendor_detail');
    	$op = $this->session->userdata['EM_COMPANY'];

    	if ($op == '7000' || $op == '2000' || $op == '5000') {
    		$idop = '1';
    		$name_opco = 'PT. SEMEN INDONESIA';
    		$addres = 'Jl. Veteran, Gresik 61122, Jawa Timur, Indonesia';
    	} else if ($op == '3000') {
    		$idop = '2';
    		$name_opco = 'PT. SEMEN PADANG';
    		$addres = 'Indarung Padang 25237, Sumatera Barat';
    	} else if ($op == '4000'){
    		$idop = '3';
    		$name_opco = 'PT. SEMEN TONASA';
    		$addres = 'Biringere, Pangkep, Sulawesi Selatan, 90651';
    	}

    	if($no=='0'){
    		$vn="";
    	}else{
    		$vn=$no;
    	}

    	if($name=='0'){
    		$vm="";
    	}else{
    		$vm=$name;
    	}

    	if($update=='0'){
    		$up="";
    	}else{
    		$up=$update;
    	}

    	if($reg=='0'){
    		$rg="";
    	}else{
    		$rg=$reg;
    	}

    	if($email=='0'){
    		$eml="";
    	}else{
    		$eml=$email;
    	}

    	if($produk!='0'){
    		if ($produk == '1') {
    			$pd = $produk;
    			$produk_type = 'GOODS';
    		} elseif ($produk == '2') {
    			$pd = $produk;
    			$produk_type='SERVICES';
    		} elseif ($produk == '3') {
    			$pd = $produk;
    			$produk_type='GOODS AND SERVICES';
    		}
    	}else{
    		$pd="";
    		$produk_type='';
    	}

    	$opco = $this->session->userdata['EM_COMPANY'];

    	header("Content-type: application/octet-stream");
    	header("Content-Disposition: attachment; filename=daftar_seluruh_vendor.xls");
    	header("Pragma: no-cache");
    	header("Expires: 0");


    	$data_vendor = array();
    	$datatable_vnd = $this->vendor_detail->cetak_vnd_table_prod($opco,$vn,$vm,$up,$rg,$eml,$pd);
    	if(!empty($datatable_vnd)){
    		foreach ($datatable_vnd as $key => $val) {
    			array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_ID'],"VENDOR_NO" =>$val['VENDOR_NO'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS'], "EMAIL_ADDRESS"=>$val['EMAIL_ADDRESS'], "STATUS_PERUBAHAN"=>$val['STATUS_PERUBAHAN']));
    		}
    	}
    	$datatable_tmp = $this->vendor_detail->cetak_tmp_table_prod($opco,$vn,$vm,$rg,$eml,$pd);
    	if(!empty($datatable_tmp)){
    		foreach ($datatable_tmp as $key => $val) {
    			array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_ID'],"VENDOR_NO" =>$val['VENDOR_NO'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS'], "EMAIL_ADDRESS"=>$val['EMAIL_ADDRESS']));
    		}
    	}

    	$data['data_vendor'] = $data_vendor;
    	$data['opco'] = $name_opco;
    	$data['idopco'] = $idop;
    	$data['produk_type'] = $produk_type;
    	$data['alamat'] = $addres;
    	$this->load->view('exel', $data);
    }

    public function viewDok($file=null){
    	$url = str_replace("int-","", base_url());
    	$this->load->helper('file');
    	$image_path = base_url(UPLOAD_PATH).'/vendor/'.$file;

if (strpos($url, 'semenindonesia.com') !== false) { //server production
	$user_id=url_encode($this->session->userdata['ID']);
	if(empty($file)){
		die('tidak ada attachment.');
	}
	if(file_exists(BASEPATH.'../upload/vendor/'.$file)){				
		$this->output->set_content_type(get_mime_by_extension($image_path));
		return $this->output->set_output(file_get_contents($image_path));
	}else{
		if (strpos($url, 'https')) {
			$url = $url;
		} else {
			$url = str_replace("http","https", $url);					
		}

		redirect($url.'View_document_vendor/viewDok/'.$file.'/'.$user_id);
	}

}else{ //server development
	if(empty($file) || !file_exists(BASEPATH.'../upload/vendor/'.$file)){
		die('tidak ada attachment.');
	}

	$this->output->set_content_type(get_mime_by_extension($image_path));
	return $this->output->set_output(file_get_contents($image_path));
}
}

public function vendor_approved($id){

	$this->load->model(array('vendor_detail','adm_wilayah','adm_country','m_vnd_tools_category','m_vnd_certificate_type'));

	$dat = $this->vendor_detail->info_perusahaan($id);
	foreach ($dat as $row) {} 
		$data['ven'] = $row;

	if (is_numeric($row['PREFIX']) == true) {
		$presuf = $this->vendor_detail->prefix_sufix($id);
// var_dump($presuf);
	}else{
		$presuf = $this->vendor_detail->prefix_sufix_vnd($id);
	}
	foreach ($presuf as $rg) {} 
		$data['presuf'] = $rg;

	$data['company_address'] = $this->vendor_detail->alamat_perusahaan($id);

	$data['akta'] = $this->vendor_detail->akta_pendirian($id);

// if (is_numeric($row['ADDRESS_COUNTRY']) == true || is_numeric($row['ADDRES_PROP']) == true) {
	$dom = $this->vendor_detail->domisili_perusahaan($id);
// }else{
// 	$dom = $this->vendor_detail->domisili_perusahaan_vnd($id);
// 	// die(var_dump($dom));
// }
	foreach ($dom as $key) {}
		$data['domisili'] = $key;


// if (is_numeric($row['NPWP_PROP']) == true) {
	$np = $this->vendor_detail->npwp($id);
// }else{
// 	$np = $this->vendor_detail->npwp_ven($id);
// }

	foreach ($np as $wp) {}
		$data['npwp'] = $wp;

	$val = $this->vendor_detail->val_ven($id);
	foreach ($val as $ven) {}
		$data['valven'] = $ven;

	$data['country'] = $this->adm_country->as_dropdown('COUNTRY_NAME')->get_all();

	$province = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'PROVINSI')));
	$city = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'KOTA')));
	$city_list = array();
	foreach ($city as $key => $value) {
		$city_list[$key] = $value;
	}
	$data['city_list'] = $city_list;

	$province_list = array();
	foreach ($province as $key => $value) {
		$province_list[$key] = $value;
	}
	$data['province_list'] = $province_list;

	$data['info_komisaris'] = $this->vendor_detail->info_komisaris($id);
	$data['info_director'] = $this->vendor_detail->info_director($id);
	$data['bank_vendor'] = $this->vendor_detail->info_bank($id);
	$data['fin'] = $this->vendor_detail->fin($id);
	$data['product'] = $this->vendor_detail->produk($id);
	$data['bahan'] = $this->vendor_detail->bahan($id);
	$data['jasa'] = $this->vendor_detail->produk_jasa($id);
	$data['main_sdm'] = $this->vendor_detail->sdm($id);
	$data['sdm_support'] = $this->vendor_detail->sdm_sp($id);
	$data['certifications'] = $this->vendor_detail->certifications($id);
	$data['equipments'] = $this->vendor_detail->equipment($id);
	$data['experience'] = $this->vendor_detail->experience($id);
	$data['pricipal'] = $this->vendor_detail->pricipal($id);
	$data['subcontractors'] = $this->vendor_detail->subcontractor($id);
	$data['affiliation'] = $this->vendor_detail->affiliation($id);
	$data['certificate_type'] = $this->m_vnd_certificate_type->as_dropdown('CERTIFICATE_TYPE')->get_all();
	$data['tools_category'] = $this->m_vnd_tools_category->as_dropdown('CATEGORY')->get_all();


// die(var_dump($data['subcontractor']));

	$data['title'] = "Detail Ringkasan Vendor";
	$this->layout->render('detail_vendor', $data);
}

public function new_regisration($id){

	$this->load->model(array('vendor_detail_tmp','adm_wilayah','adm_country','m_vnd_tools_category','m_vnd_certificate_type'));

	$dat = $this->vendor_detail_tmp->info_perusahaan($id);
	foreach ($dat as $row) {} 
		$data['ven'] = $row;

	if (is_numeric($row['PREFIX']) == true) {
		$presuf = $this->vendor_detail_tmp->prefix_sufix($id);
// var_dump($presuf);
	}else{
		$presuf = $this->vendor_detail_tmp->prefix_sufix_vnd($id);
	}
	foreach ($presuf as $rg) {} 
		$data['presuf'] = $rg;

	$data['company_address'] = $this->vendor_detail_tmp->alamat_perusahaan($id);

// die(var_dump($data['company_address']));

	$data['akta'] = $this->vendor_detail_tmp->akta_pendirian($id);

// if (is_numeric($row['ADDRESS_COUNTRY']) == true || is_numeric($row['ADDRES_PROP']) == true) {
	$dom = $this->vendor_detail_tmp->domisili_perusahaan($id);
// }else{
// $dom = $this->vendor_detail_tmp->domisili_perusahaan_vnd($id);
// }
	foreach ($dom as $key) {}
		$data['domisili'] = $key;

	if (is_numeric($row['NPWP_PROP']) == true) {
		$np = $this->vendor_detail_tmp->npwp($id);
	}else{
		$np = $this->vendor_detail_tmp->npwp_ven($id);
	}

	foreach ($np as $wp) {}
		$data['npwp'] = $wp;

	$val = $this->vendor_detail_tmp->val_ven($id);
	foreach ($val as $ven) {}
		$data['valven'] = $ven;

	$data['country'] = $this->adm_country->as_dropdown('COUNTRY_NAME')->get_all();

	$province = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'PROVINSI')));
	$city = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'KOTA')));
	$city_list = array();
	foreach ($city as $key => $value) {
		$city_list[$key] = $value;
	}
	$data['city_list'] = $city_list;

	$province_list = array();
	foreach ($province as $key => $value) {
		$province_list[$key] = $value;
	}
	$data['province_list'] = $province_list;

	$data['info_komisaris'] = $this->vendor_detail_tmp->info_komisaris($id);
	$data['info_director'] = $this->vendor_detail_tmp->info_director($id);
	$data['bank_vendor'] = $this->vendor_detail_tmp->info_bank($id);
	$data['fin'] = $this->vendor_detail_tmp->fin($id);
	$data['product'] = $this->vendor_detail_tmp->produk($id);
	$data['bahan'] = $this->vendor_detail_tmp->bahan($id);
	$data['jasa'] = $this->vendor_detail_tmp->produk_jasa($id);
	$data['main_sdm'] = $this->vendor_detail_tmp->sdm($id);
	$data['sdm_support'] = $this->vendor_detail_tmp->sdm_sp($id);
	$data['certifications'] = $this->vendor_detail_tmp->certifications($id);
	$data['equipments'] = $this->vendor_detail_tmp->equipment($id);
	$data['experience'] = $this->vendor_detail_tmp->experience($id);
	$data['pricipal'] = $this->vendor_detail_tmp->pricipal($id);
	$data['subcontractors'] = $this->vendor_detail_tmp->subcontractor($id);
	$data['affiliation'] = $this->vendor_detail_tmp->affiliation($id);
	$data['certificate_type'] = $this->m_vnd_certificate_type->as_dropdown('CERTIFICATE_TYPE')->get_all();
	$data['tools_category'] = $this->m_vnd_tools_category->as_dropdown('CATEGORY')->get_all();

// die(var_dump($data['subcontractor']));

	$data['title'] = "Detail Ringkasan Vendor";
	$this->layout->render('detail_vendor', $data);
}

public function vendor_rejected($id){
	$this->new_regisration($id);
}

public function road_to_vendor($id){
	$this->new_regisration($id);
}

public function approve_regisration($id){
	$this->new_regisration($id);
}

}
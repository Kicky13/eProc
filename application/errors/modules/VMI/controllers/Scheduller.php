<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Scheduller extends CI_Controller {

	public function __construct(){
            parent::__construct();
            $this->ci = &get_instance();
            $this->load->library('Layout');
            // $this->load->library('Authorization');
			$this->load->model(array('vnd_header'));
            $this->load->model('model_grafik');
            $this->_lot="";
	}

    function echopre($dt){
        echo'<pre>';
            print_r($dt);
        echo'</pre>';
    }

	function index(){
	}
	
	function getAllConsumption($tglawal,$tglakhir){
			$tampildata1 = array();
			require_once APPPATH.'third_party/sapclasses/sap.php';
            $ssap = new SAPConnection();
            $ssap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
            if ($ssap->GetStatus() == SAPRFC_OK ) $ssap->Open ();
            if ($ssap->GetStatus() != SAPRFC_OK ) {
                echo $ssap->PrintStatus();
                exit;
            }
			$fce = &$ssap->NewFunction ("ZCMM_TRANSAKSI_MATERIAL");

			if ($fce == false) {
				$ssap->PrintStatus();
				exit;
			}

			$fce->LR_BUDAT->row['SIGN']     = 'I';
			$fce->LR_BUDAT->row['OPTION']   = 'BT';
			$fce->LR_BUDAT->row['LOW']      = $tglawal;
			$fce->LR_BUDAT->row['HIGH']     = $tglakhir;
			$fce->LR_BUDAT->Append($fce->LR_BUDAT->row);

			$fce->LR_BUKRS->row['SIGN']     = 'I';
			$fce->LR_BUKRS->row['OPTION']   = 'EQ';
			$fce->LR_BUKRS->row['LOW']      = '7000';
			$fce->LR_BUKRS->row['HIGH']     = '';
			$fce->LR_BUKRS->Append($fce->LR_BUKRS->row);
			
			$fce->LR_WERKS->row['SIGN']     = 'I';
			$fce->LR_WERKS->row['OPTION']   = 'EQ';
			$fce->LR_WERKS->row['LOW']      = '7702';
			$fce->LR_WERKS->row['HIGH']     = '';
			$fce->LR_WERKS->Append($fce->LR_WERKS->row);
			
			$sql = "SELECT DISTINCT KODE_MATERIAL
					from VMI_MASTER 
					where STATUS = '1'
					";
			$dt = $this->db->query($sql)->result_array();
			foreach ($dt as $key => $value) {
				$komat 							= $value['KODE_MATERIAL'];
				$fce->LR_MATNR->row['SIGN']     = 'I';
				$fce->LR_MATNR->row['OPTION']   = 'EQ';
				$fce->LR_MATNR->row['LOW']      = $komat;
				$fce->LR_MATNR->row['HIGH']     = '';
				$fce->LR_MATNR->Append($fce->LR_MATNR->row);
			}
			
			// $sql = "SELECT DISTINCT KODE_VENDOR
					// from VMI_MASTER 
					// where STATUS = '1'
					// ";
			// $dt = $this->db->query($sql)->result_array();
			// foreach ($dt as $key => $value) {
				// $koven 							= $value['KODE_VENDOR'];
				// $fce->LR_LIFNR->row['SIGN']     = 'I';
				// $fce->LR_LIFNR->row['OPTION']   = 'EQ';
				// $fce->LR_LIFNR->row['LOW']      = $koven;
				// $fce->LR_LIFNR->row['HIGH']     = '';
				// $fce->LR_LIFNR->Append($fce->LR_LIFNR->row);
			// }

			$ArrMovementtype = array('101','102','105','106','961','962');
			foreach ($ArrMovementtype as $key => $Movementtype) {
				$fce->LR_BWART->row['SIGN']     = 'I';
				$fce->LR_BWART->row['OPTION']   = 'EQ';
				$fce->LR_BWART->row['LOW']      = $Movementtype;
				$fce->LR_BWART->row['HIGH']     = '';
				$fce->LR_BWART->Append($fce->LR_BWART->row);
			}

			$fce->call();
			if ($fce->GetStatus() == SAPRFC_OK) {
				$fce->T_DATA->Reset();
				$i=0;
				$idr=1;
				$temp_mat = '';
				$temp = array();
				$tempx = '';
				$mat_temp = '';
				while ($fce->T_DATA->Next()) {
					$jenis	 	= $fce->T_DATA->row["BWART"];
					$material 	= $fce->T_DATA->row["MATNR"];
					$stock	 	= intval($fce->T_DATA->row["SLABS"]);
						$tampildata1[] = array(
							"NOMER_PO"=>		$fce->T_DATA->row["EBELN"],
							"NOMER_Res"=>		$fce->T_DATA->row["RSNUM"],
							"PLANT"=>			$fce->T_DATA->row["WERKS"],
							"VENDOR_NO"=>		$fce->T_DATA->row["LIFNR"],
							"KODE_MATERIAL"=>	$fce->T_DATA->row["MATNR"],
							"PO_ITEM"=>			$fce->T_DATA->row["EBELP"],
							"SLOC"=>			$fce->T_DATA->row["LGORT"],
							"DOC_DATE"=>		$fce->T_DATA->row["BUDAT"],
							"Jenis"=>			$fce->T_DATA->row["BLART"],
							"Doc_Type"=>		$fce->T_DATA->row["BWART"],
							"Quantity"=>		$fce->T_DATA->row["MENGE"],
							"Transaction"=>		$fce->T_DATA->row["SHKZG"],
							"UNIT"=>			$fce->T_DATA->row["MEINS"],
							"Funds_Center"=>			$fce->T_DATA->row["FISTL"],
							"Special_Stock_Indicator"=>			$fce->T_DATA->row["SOBKZ"],
						);
				}
				$fce->Close();
				$ssap->Close();
			}
				// echo "<pre>";
				return $tampildata1;
				// echo "</pre>";
	}

	function searchForId($id, $array,$kolom) {
		   foreach ($array as $key => $val) {
		       if ($val[$kolom] === $id) {
		           return $key;
		       }
		   }
		   return null;
		}

	function getstock(){
			require_once APPPATH.'third_party/sapclasses/sap.php';
            $ssap = new SAPConnection();
            $ssap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
            if ($ssap->GetStatus() == SAPRFC_OK ) $ssap->Open ();
            if ($ssap->GetStatus() != SAPRFC_OK ) {
                echo $ssap->PrintStatus();
                exit;
            }
			$fce = &$ssap->NewFunction ("ZCMM_MASTER_MATERIAL");

			if ($fce == false) {
				$ssap->PrintStatus();
				exit;
			}
			$sql = "SELECT PLANT,KODE_MATERIAL
					from VMI_MASTER 
					where STATUS = '1'
					order by id_list asc";
			$dt = $this->db->query($sql)->result_array();
			foreach ($dt as $key => $value) {
				
				$komat = $value['KODE_MATERIAL'];
				$plant = $value['PLANT'];
				
				$fce->R_MATNR->row['SIGN']     = 'I';
				$fce->R_MATNR->row['OPTION']   = 'EQ';
				$fce->R_MATNR->row['LOW']      = $komat;
				$fce->R_MATNR->row['HIGH']     = '';
				$fce->R_MATNR->Append($fce->R_MATNR->row);
				
				$plants = "7702";
				$fce->R_WERKS->row['SIGN']     = 'I';
				$fce->R_WERKS->row['OPTION']   = 'EQ';
				$fce->R_WERKS->row['LOW']      = $plants;
				$fce->R_WERKS->row['HIGH']     = '';
				$fce->R_WERKS->Append($fce->R_WERKS->row);
			
			}

			$fce->call();
			if ($fce->GetStatus() == SAPRFC_OK) {
				$fce->T_STOCK_CONSINYASI->Reset();
				$i=0;
				$idr=1;
				$temp_mat = '';
				$temp_stok= '';
				$stok_intransit = array();
				while ($fce->T_STOCK_CONSINYASI->Next()) {
					$material 	= $fce->T_STOCK_CONSINYASI->row["MATNR"];
					$plant 		= $fce->T_STOCK_CONSINYASI->row["WERKS"];
					$slocs	 	= $fce->T_STOCK_CONSINYASI->row["LGORT"];
					$vendor 	= $fce->T_STOCK_CONSINYASI->row["LIFNR"];
					$stock	 	= intval($fce->T_STOCK_CONSINYASI->row["SLABS"]);
					
					if($stock >= 1)
					{
						$stok_intransit[] = array(
											"MATERIAL"=>$material,
											"PLANT"=>$plant,
											"SLOCS"=>$slocs,
											"VENDOR"=>$vendor,
											"STOCK"=>$stock);
					}
					// echo "$material dan $stock <br/>";
				}
				$fce->Close();
				$ssap->Close();
			}
			// echo "<pre>";
				// print_r($stok_intransit);
			// echo "</pre>";
			return $stok_intransit;
	}
	
//==============================================================================================================================================================================
//=========================================================================== Batas Scheduller =================================================================================
//==============================================================================================================================================================================

	function SchedullerPO(){										// Cek  --> Update PO List, Update Quantity PO Open
		// echo "hahah";		
		require_once APPPATH.'third_party/sapclasses/sap.php';
		$sap = new SAPConnection();
		$sap->Connect(APPPATH."third_party/sapclasses/logon_dataDev.conf");
		if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
		if ($sap->GetStatus() != SAPRFC_OK ) {
			echo $sap->PrintStatus();
			exit;
		}

		$fce = &$sap->NewFunction ("Z_ZCMM_VMI_PO_DETAILC");
		
		if ($fce == false) {
			$sap->PrintStatus();
			exit;
		}
		
		$start 	= date("20170101");					// Date start VMI apps
		$end 	= date("Ymd");						// Date Now
		$opco					= '7000';
		$fce->COMPANY 			= "$opco";		// BUKRS
		// $fce->PO_TYPE 		= 'ZK17';
		// $fce->VENDOR 		= ;
		$fce->DATE['SIGN']   	= 'I';
		$fce->DATE['OPTION']	= 'BT';
		$fce->DATE['LOW']    	= $start;
		$fce->DATE['HIGH']    	= $end;
		
		$fce->PO_TYPE->row['SIGN']     	= 'I';
		$fce->PO_TYPE->row['OPTION']   	= 'EQ';
		$fce->PO_TYPE->row['LOW']    	= 'ZK10';
		$fce->PO_TYPE->row['HIGH']    	= '';
		$fce->PO_TYPE->Append($fce->PO_TYPE->row);
		
		$fce->PO_TYPE->row['SIGN']     	= 'I';
		$fce->PO_TYPE->row['OPTION']   	= 'EQ';
		$fce->PO_TYPE->row['LOW']    	= 'ZK17';
		$fce->PO_TYPE->row['HIGH']    	= '';
		$fce->PO_TYPE->Append($fce->PO_TYPE->row);
			
        $fce->call();

        if ($fce->GetStatus() == SAPRFC_OK) {
            $fce->T_ITEM->Reset();
            $data=array();
            $empty=0;
            $tampildata=array();
            while ($fce->T_ITEM->Next()) {
				$matnr 		= $fce->T_ITEM->row["MATNR"];	// Kode Material
				$lifnr 		= $fce->T_ITEM->row["LIFNR"];	// Kode Vendor
				$ebeln 		= $fce->T_ITEM->row["EBELN"];	// No PO
				$menge 		= intval($fce->T_ITEM->row["MENGE"]);	// Quantity PO
				$sisaqty	= intval($fce->T_ITEM->row["DELIV_QTY"]);	// Quantity PO Open
				$werks 		= $fce->T_ITEM->row["WERKS"];	// Plant
				$vendor		= $fce->T_ITEM->row["VENDNAME"];	// Nama Vendor
				$material 	= $fce->T_ITEM->row["MAKTX"];	// Nama Material
				$potype 	= $fce->T_ITEM->row["BSART"];	// Type PO
				// $mins 		= $fce->T_ITEM->row["EISBE"];	// Safety Stock
				$mins 		= $fce->T_ITEM->row["MINBE"];	// Re Order Point
				$maxs 		= $fce->T_ITEM->row["MABST"];	// Max
				$statuspo	= $fce->T_ITEM->row["ELIKZ"];	// Max
				$start 		= date_format(date_create($fce->T_ITEM->row["BEDAT"]),'d M Y');
				$end 		= date_format(date_create($fce->T_ITEM->row["EINDT"]),'d M Y');
				
				if($statuspo == 'X' || $statuspo == 'x')
				{
					$sts = 0;					
				}
				else
				{
					$sts = 1;
				}
				$sqlread= "SELECT count(id_list) ADA
							FROM VMI_MASTER 
							where NO_PO = '$ebeln' and
							KODE_MATERIAL = '$matnr' and 
							KODE_VENDOR = '$lifnr' and
							PLANT = '$werks' 
							";
							//and QUANTITY = '$menge'
				$jum 	= $this->db->query($sqlread)->row();
				$nilai 	= $jum->ADA;
				// echo $nilai."->".$matnr." | ".$lifnr." | ".$ebeln." | ".$menge." | ".$werks." | ".$vendor." | ".$material." | ".$start." | ".$end." ==> ".$potype."<br/>";
				// $ebeln == "6310000038" || $ebeln == "6310000039" || $ebeln == "6310000040" || $ebeln == "6310000041" || $ebeln == "6310000042" || $ebeln == "6310000043")
				
				if($nilai < 1){
					if($ebeln == "6310000038" || $ebeln == "6310000039" || $ebeln == "6310000040" || $ebeln == "6310000041" || $ebeln == "6310000042" || $ebeln == "6310000043"
						|| $lifnr == "0000113004" || $lifnr == "0000110091" || $lifnr == "0000110253" || $lifnr == "0000110015" || $lifnr == "0000112369" || $lifnr == "0000110016"){						
						$sqlcount 	= "SELECT max(ID_LIST) MAXX FROM VMI_MASTER";
						$maxid 		= $this->db->query($sqlcount)->row();		
						$max_list 	= $maxid->MAXX+1;
						$insert		= "insert into VMI_MASTER(ID_LIST,
														PLANT,
														KODE_MATERIAL,
														NAMA_MATERIAL,
														UNIT,
														KODE_VENDOR,
														NAMA_VENDOR,
														NO_PO,
														PO_ITEM,
														CONTRACT_ACTIVE,
														CONTRACT_END,
														DOC_DATE,
														SLOC,
														MIN_STOCK,
														MAX_STOCK,
														STOCK_AWAL,
														STOCK_VMI,
														QUANTITY,
														ID_COMPANY,
														STATUS)
												values('$max_list',
														'$werks',
														'$matnr',
														'$material',
														'".$fce->T_ITEM->row["MEINS"]."',
														'$lifnr',
														'$vendor',
														'$ebeln',
														'".$fce->T_ITEM->row["EBELP"]."',
														TO_DATE('".date_format(date_create($start),'Y-m-d')."','YYYY-MM-DD'),
														TO_DATE('".date_format(date_create($end),'Y-m-d')."','YYYY-MM-DD'),
														TO_DATE('".date_format(date_create($start),'Y-m-d')."','YYYY-MM-DD'),
														'".$fce->T_ITEM->row["LGORT"]."',
														'".$fce->T_ITEM->row["EISBE"]."',
														'".$fce->T_ITEM->row["MABST"]."',
														'0',
														'0',
														'$sisaqty',
														'$opco',
														'$sts'
														)";
						$save 	= $this->db->query($insert);
						echo "Baru ==> $ebeln | $material | $vendor | $opco | $werks | $potype<br/>\n";
					}
					else
					{
						echo "Skip ==> $ebeln | $material | $vendor | $opco | $werks | $potype<br/>\n";
					}
				}
				elseif($nilai >= 1){
					$sqlread1 = "SELECT ID_LIST
							FROM VMI_MASTER 
							where NO_PO = '$ebeln' and
							KODE_MATERIAL = '$matnr' and 
							KODE_VENDOR = '$lifnr' and
							PLANT = '$werks' 
							";
							//and QUANTITY = '$menge'
					$getlist= $this->db->query($sqlread1)->row();
					$idlist = $getlist->ID_LIST;
					$update		= "update VMI_MASTER set quantity = '$sisaqty',min_stock = '$mins',max_stock = '$maxs',STATUS = '$sts' where ID_LIST = '$idlist'";
					$update_data	= $this->db->query($update);
					echo "$update <br/>\n";
				}
				else{
						echo "Skip ==> $ebeln | $material | $vendor | $opco| $werks | $potype<br/>\n";
				}
				// echo "<hr/>"; 
			}
		// echo "<pre>";
		// print_r($fce);
		// echo "hahaha";
        $fce->Close();
		}
    }
	
	function SchedullerMail(){										// Cek  --> Warning Stock Minimal
		$no = 1;
		$ArrGetstock = $this->getstock();
		foreach ($ArrGetstock as $asd => $value) {
			$sql1 	= "SELECT MIN_STOCK, NAMA_VENDOR, NAMA_MATERIAL FROM VMI_MASTER WHERE KODE_VENDOR = '".$value['VENDOR']."' AND KODE_MATERIAL = '".$value['MATERIAL']."'";
			$maxid 	= $this->db->query($sql1)->row();		
			$minims = $maxid->MIN_STOCK;
			$nm_vnd = $maxid->NAMA_VENDOR;
			$nm_mtr = $maxid->NAMA_MATERIAL;
			
			$sql2 	= "SELECT EMAIL_ADDRESS FROM VND_HEADER where VENDOR_NO = '".$value['VENDOR']."'";
			$result	= $this->db->query($sql2)->row();		
			$email 	= $result->EMAIL_ADDRESS;
			
			if($value['STOCK'] <= $minims)
			{
				echo "$no. ".$value['MATERIAL']."<br/>".$value['PLANT']."<br/>".$value['SLOCS']."<br/>".$value['VENDOR']."<br/>".$value['STOCK'].">".$minims."<br/>".$email."<hr/>\n";
				
				$from 	  = "Tim VMI-Eproc Semen Indonesia";
				$subject  = "Email Notifikasi untuk melakukan Replenishment";
				$to 	  = "$email";
				// $to 	  = "evilstar7@gmail.com";
				$bcc 	  = "muhammad.ramzi20@gmail.com";
				$bcc1 	  = "imam.s@sisi.id	";
				$bcc2 	  = "m.ramzi@sisi.id";
				// $bcc2 	  = "muhammad.ramzi20@gmail.com";
				$message  = '<html><body><font style = "font-family:"Cambria";size:"12px";">';
				$message .= 'Yth. <b>'.$nm_vnd.'</b><br/>';
				$message .= 'Mohon melakukan replanishment untuk material berikut : <br/><br/>';
				$message .= '<table border = 2>';
				$message .= '<tr>
								<th>Material</th>
								<th>Stock Material</th>
								<th>Minimal Stock</th>
							</tr>';
				$message .= '<tr>
								<td>'.$nm_mtr.'</td>
								<td align = "center">'.$value['STOCK'].'</td>
								<td align = "center">'.$minims.'</td>
							</tr>';
				$message .= '</table>';
				$message .= '<br/>Demikian Email Pemberitahun ini kami sampaikan<br/>';
				$message .= 'Terima Kasih<br/><br/>';
				$message .= 'NB : Email ini dikirimkan oleh system. Jangan me-reply email ini. Apabila ada pertanyaan silakan menghubungi Seksi Inventory<br/>';
				$message .= '</font></body></html>';
				$sender	  = $this->send_mail($from,$to,$subject,$bcc,$bcc1,$bcc2,$message);
				$no++;
			}
		}
	}

	function send_mail($from,$to,$subject,$bcc,$bcc1,$bcc2,$message){		// Send --> Warning Stock Minimal
		// $to 	= "muhammad.ramzi20@gmail.com";
		// $from 	= "muhammad.ramzi20@gmail.com";
		// $to 	= "m.ramzi@sisi.id";
		// $subject= "Coba mail";
		// $cc 	= "muhammad.ramzi20@gmail.com";
		// $bcc 	= "evilstar7@gmail.com";
		// $message= "Nyoba email buat VMI bro --> Sudah dari VMI";
		$this->load->library('email');
		$this->config->load('email');
		$semenindonesia = $this->config->item('semenindonesia');
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($from);
		$this->email->to($to);
		// $this->email->cc('pengadaan.semenindonesia@gmail.com');
		if(!empty($cc)){
		   $this->email->cc($cc);
		}
		if(!empty($bcc)){
		   $this->email->bcc($bcc);
		   $this->email->bcc($bcc1);
		   $this->email->bcc($bcc2);
		}

		if(!empty($attachment)){
		  $this->email->attach($attachment);
		}

		$this->email->subject($subject);
		$this->email->message($message);
		return $this->email->send();
	}

	function sendNotif(){											// Send --> Warning Perubahan Nilai Prognose
		$sql1 		= "SELECT EMAIL, MATERIAL, VENDOR FROM VMI_NOTIF";
		$dt 		= $this->db->query($sql)->result_array();
		// $dt			= $this->db->query($sql1)->row();		
		// $to 		= $result->EMAIL;
		// $material 	= $result->MATERIAL;
		// $vendor		= $result->VENDOR;
		foreach ($dt as $key => $value) {
			$to 		= $value['EMAIL'];
			$material 	= $value['MATERIAL'];
			$vendor 	= $value['VENDOR'];
			$from 	  	= "Tim VMI-Eproc Semen Indonesia";
			$subject  	= "Email Notifikasi untuk melakukan Replenishment";
			$cc 	  	= "imam.s@sisi.id	";
			$bcc 	  	= "m.ramzi@sisi.id";
			$message  	= '<html><body><font style = "font-family:"Cambria";size:"12px";">';
			$message 	.= 'Yth. <b>'.$vendor.'</b><br/>';
			$message 	.= 'Mohon melakukan pengecekkan terhadap perubahan nilai prognose pada material '.$material.' : <br/><br/>';
			$message 	.= '<br/>Demikian Email Pemberitahun ini kami sampaikan<br/>';
			$message 	.= 'Terima Kasih<br/><br/>';
			$message 	.= 'NB : Email ini dikirimkan oleh system. Jangan me-reply email ini. Apabila ada pertanyaan silakan menghubungi Seksi Inventory<br/>';
			$message 	.= '</font></body></html>';

			$this->load->library('email');
			$this->config->load('email');
			$semenindonesia = $this->config->item('semenindonesia');
			$this->email->initialize($semenindonesia['conf']);
			$this->email->from($from);
			$this->email->to($to);
			// $this->email->cc('pengadaan.semenindonesia@gmail.com');
			if(!empty($cc)){
			   $this->email->cc($cc);
			}
			if(!empty($bcc)){
			   $this->email->bcc($bcc);
			}

			if(!empty($attachment)){
			  $this->email->attach($attachment);
			}

			$this->email->subject($subject);
			$this->email->message($message);
			return $this->email->send();
		}
		$sql2 		= "DELETE table VMI_NOTIF";
		$result2	= $this->db->query($sql2)->row();	
	}
	
//==============================================================================================================================================================================
//=========================================================================== Batas Scheduller =================================================================================
//==============================================================================================================================================================================

//    MJAHR	Material Document Year
//    MBLNR	Number of Material Document
//    ZEILE	Item in Material Document
//    BUKRS	Company Code
//    BLART	Document Type
//    BLDAT	Document Date in Document
//    BUDAT	Posting Date in the Document
//    CPUDT	Day On Which Accounting Document Was Entered
//    BWART	Movement Type (Inventory Management)
//    MATNR	Material Number
//    WERKS	Plant
//    LGORT	Storage Location
//    SOBKZ	Special Stock Indicator
//    LIFNR	Account Number of Vendor or Creditor
//    SHKZG	Debit/Credit Indicator
//    WAERS	Currency Key
//    DMBTR	Amount in Local Currency
//    MEINS	Base Unit of Measure
//    MENGE	Quantity
//    QTY_TON	Quantity
//    EBELN	Purchasing Document Number
//    EBELP	Item Number of Purchasing Document
//    FISTL	Funds Center
//    AUFNR	Order Number
//    RSNUM	Number of Reservation/Dependent Requirement
//    RSPOS	Item Number of Reservation/Dependent Requirement

}

<?php
/**
 * ListPost class file
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.pradosoft.com/
 * @copyright Copyright &copy; 2006 PradoSoft
 * @license http://www.pradosoft.com/license/
 * @version $Id: ListPost.php 1398 2006-09-08 19:31:03Z xue $
 */

/**
 * ListPost class
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.pradosoft.com/
 * @copyright Copyright &copy; 2006 PradoSoft
 * @license http://www.pradosoft.com/license/
 */
class clpb_gs extends SAPPage
{
	private $_data;
	private $_lot;
	protected function getData(){
		$dsap = $this->DataAccess->ConnSAP;

		$fce = $dsap->NewFunction ("Z_ZAPPIC_GROUP_LOT_GT_TGL");
		if ($fce == false ) {
		   $dsap->PrintStatus();
		   exit;
		}
		//filter
		$fce->XPARAM=$this->PO_NUM->Text;
		
		$fce->XDATA_APP["NMORG"]=$this->User->Org;
		$fce->XDATA_APP["NMPLAN"]=$this->User->Plant;
		
		$laporan = '';
		$fce->Call();
		
		//baca return value
		$laporan .= "<br><br><b>RETURN :</b><br>";
		if ($fce->GetStatus() == SAPRFC_OK) {
			$fce->RETURN_DATA->Reset();
			//to Display Tables
			$i=0;
			while ( $fce->RETURN_DATA->Next() ){	
				$this->_lot[$i]["ATTRIBUTE1"]=$fce->RETURN_DATA->row["ATTRIBUTE1"];
				$this->_lot[$i]["LOT_ID"]=$fce->RETURN_DATA->row["LOT_ID"];
				$this->_lot[$i]["MAT_NUM"]=$fce->RETURN_DATA->row["MAT_NUM"];
				$this->_lot[$i]["MAT_DESC"]=$fce->RETURN_DATA->row["MAT_DESC"];
				//$this->_lot[$i]["WGH1"]=number_format($fce->RETURN_DATA->row["WGH1"]);
				//$this->_lot[$i]["WGH2"]=number_format($fce->RETURN_DATA->row["WGH2"]);
				//$this->_lot[$i]["NETTO"]=number_format(($fce->RETURN_DATA->row["WGH1"]-$fce->RETURN_DATA->row["WGH2"]),3,",",".");
				$this->_lot[$i]["NETTO"]=($fce->RETURN_DATA->row["WGH1"]-$fce->RETURN_DATA->row["WGH2"]);

				$this->_lot[$i]["STO_NUM"]=$fce->RETURN_DATA->row["STO_NUM"];
				$this->_lot[$i]["VEND_DSC"]=$fce->RETURN_DATA->row["VEND_DSC"];
				$this->_lot[$i]["WGH_PO"]=$fce->RETURN_DATA->row["WGH_PO"];
                                $tgltrans = substr($fce->RETURN_DATA->row["TGL"],6,2)."-".
                                            substr($fce->RETURN_DATA->row["TGL"],4,2)."-".
                                            substr($fce->RETURN_DATA->row["TGL"],0,4);
                                 
                                
                                $this->_lot[$i]["TGL"]=$tgltrans;
				
				$i++;
			}				
		} 
		$fce->Close(); 
		
		$dsap->Close();
		if(trim($fce->RETURN["TYPE"])=='E')return false;
			else return $this->_lot;
	}
	
	public function onLoad($param){
		parent::onInit($param);
		if(!$this->IsPostBack){
			$this->buttonExecute->Attributes->onclick='if(!confirm(\'Are you sure?\')) return false;';
		}
  	}

	public function showClick(){
		$sto=array(array('value'=>'1','text'=>'STO_01'),array('value'=>'2','text'=>'STO_02'),array('value'=>'3','text'=>'STO_03'));
		$this->Repeater->DataSource="";
                $this->Repeater->dataBind();
		
		$this->report->Text="";

		if($this->Data)$this->buttonExecute->Visible=true;
                else $this->buttonExecute->Visible=false;

                if($this->Data)$this->kapal->visible = true;
                else $this->kapal->visible =false;
                         	
                if($this->Data)$this->tgldoc->visible = true;
                else $this->tgldoc->visible =false;

                if($this->Data)$this->tglpost->visible = true;
                else $this->tglpost->visible =false;

		$this->vendor->Text=$this->_lot[0]["VEND_DSC"];
		$this->qty_po->Text=number_format($this->_lot[0]["WGH_PO"]);
		$this->Repeater->DataSource=$this->_lot;

                $this->kapal->text = "";
                $this->tgldoc->text = "";
                $this->tglpost->text = "";
               
        $this->Repeater->dataBind();
  	}
	
	public function bapiExecute($param){
		$dsap = $this->DataAccess->ConnSAP;
		$fce = $dsap->NewFunction("BAPI_GOODSMVT_CREATE");
		if ($fce == false ) {
		   $dsap->PrintStatus();
		   exit;
		}
		
		$laporan = '';
		
                $tgldoc=explode("-",$this->tgldoc->Date);
		$tgldoc=$tgldoc[2]."".$tgldoc[1]."".$tgldoc[0];

		$tglpost=explode("-",$this->tglpost->Date);
		$tglpost=$tglpost[2]."".$tglpost[1]."".$tglpost[0];

                $fce->GOODSMVT_HEADER["PSTNG_DATE"] = $tglpost;
		$fce->GOODSMVT_HEADER["DOC_DATE"] = $tgldoc;
		
                $fce->GOODSMVT_CODE["GM_CODE"] = '01';
			
		//detail gr entri
		foreach($this->Repeater->Items as $item){
			if($item->pilih->Checked) {
				$fce->GOODSMVT_ITEM->row["MATERIAL"] = $item->MAT_NUM->Text;
				$fce->GOODSMVT_ITEM->row["PLANT"] = $this->User->Plant;
				$fce->GOODSMVT_ITEM->row["STGE_LOC"] = $item->STO_NUM->Text;
				$fce->GOODSMVT_ITEM->row["MOVE_TYPE"] = '101';
				
				//$qty=str_replace(",",".",$item->NETTO->Text);
				$qty=floatval($item->NETTO->Text);
				
				$fce->GOODSMVT_ITEM->row["ENTRY_QNT"] = $qty;
				$fce->GOODSMVT_ITEM->row["ENTRY_UOM"] = 'TO';
				$fce->GOODSMVT_ITEM->row["PO_NUMBER"] = $this->PO_NUM->Text;
				$fce->GOODSMVT_ITEM->row["PO_ITEM"] = $item->ATTRIBUTE1->Text;
				$fce->GOODSMVT_ITEM->row["MVT_IND"] = 'B';
				$fce->GOODSMVT_ITEM->row["VENDRBATCH"] = $item->LOT_ID->Text;
				$fce->GOODSMVT_ITEM->Append($fce->GOODSMVT_ITEM->row);
			}
		}
		
		$fce->Call();
		
		//baca return value
		if ($fce->GetStatus() == SAPRFC_OK) {
			//Tables
			//echo "<table><tr><td>Kolom1</td><td>Kolom2</td></tr>";
                	$fce->RETURN->Reset();
			//Display Tables
			$ada_error=false;
			while ( $fce->RETURN->Next() ){
				if(trim($fce->RETURN->row["TYPE"])=='E')$ada_error=true;
				if($ada_error) $laporan .= $i.". ".$fce->RETURN->row["ID"]." : ".$fce->RETURN->row["MESSAGE"]."<br>";
			}						
		} 
		
		if ($fce->GetStatus() == SAPRFC_OK and !$ada_error) {
			$doc_num=$fce->GOODSMVT_HEADRET["MAT_DOC"];
			if(strlen(trim($doc_num))>0)$laporan .= "Good Receipt telah ter-create dg mat-document :".$doc_num."<br>";
			
			//Commit Transaction
			$fce = $dsap->NewFunction ("BAPI_TRANSACTION_COMMIT");
			$fce->Call();
			
			//UPDATE STATUS ON TIMBANGAN TABLE
			if ($fce->GetStatus() == SAPRFC_OK ) {
				try{
					$fce = $dsap->NewFunction ("Z_ZAPPIC_UPDATE_TIMB_BYLOT");
					if ($fce == false ) {
					   $dsap->PrintStatus();
					   exit;
					}
					
					$fce->XDATA_UPD["STATUS_DESC"]="RECEIPT";
					$fce->XDATA_UPD["LAST_UPDATED_BY"]=$this->User->ID;
					$fce->XDATA_UPD["UPDT_DATE"]=date('Ymd');
					$fce->XDATA_UPD["UPDT_TIME"]=date('H:i:s');
					$fce->XDATA_UPD["GR_NUM"]=$doc_num;
					$fce->XDATA_UPD["NAMA_KAPAL"]=strtoupper($this->kapal->Text);
					
					$fce->XDATA_APP["NMORG"]=$this->User->Org;
					$fce->XDATA_APP["NMPLAN"]=$this->User->Plant;
					
					foreach($this->Repeater->Items as $item){
						if($item->pilih->Checked) {
							$fce->GR_LOT->row["SIGN"] ='I';
							$fce->GR_LOT->row["OPTION"] ='EQ';
							$fce->GR_LOT->row["LOW"] = $item->LOT_ID->Text;
							$fce->GR_LOT->Append($fce->GR_LOT->row);
						}
					}
					
					$fce->Call();
				}catch(Exception $e){
					echo $e;
				}			
			}//else $fce->PrintStatus();
			
		}//else $fce->PrintStatus();
		
		$this->report->Text = $laporan;
		
		$fce->Close();
		$dsap->Close();

                $this->kapal->text = "";
                $this->tgldoc->text = "";
                $this->tglpost->text = "";
		
		$this->Repeater->DataSource="";
                $this->Repeater->dataBind();

		$this->Repeater->DataSource=$this->Data;
                $this->Repeater->dataBind();
		
		if(count($this->Repeater->Items)>0)$this->buttonExecute->Visible=true;
			else $this->buttonExecute->Visible=false;
		
		//$this->showClick();
  	}

	public function checkQty($sender,$param){
		$jml=0;
		foreach($this->Repeater->Items as $item){
			if($item->pilih->Checked) {
				$jml = $jml + $item->NETTO->Text;
			}
		}
		$this->report->Text="Berat bersih lot = ".$jml." Ton";
	}

}

?>
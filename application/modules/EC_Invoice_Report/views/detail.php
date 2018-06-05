
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-lg-12">
                    <?php echo form_open_multipart('EC_Invoice_Management/editInvoice/', array('method' => 'POST', 'class' => 'form-horizontal formEdit')); ?>

                    <div class="form-group" style="visibility:<?php echo $invoice[0]['STATUS_HEADER'] != '4' ? "hidden" : ''; ?>">
                        <label for="Invoice No" class="col-sm-2 control-label">Alasan Reject</label>
                        <div class="col-sm-7">
                            <textarea  readonly class="form-control" rows="2"><?php echo $invoice[0]['ALASAN_REJECT'] ?></textarea>
                        </div>
                    </div>
                    <?php 
                        if($approval[0]['STATUS'] == '4'){
                    echo '
                    <div class="form-group">
                        <label for="Invoice No" class="col-sm-2 control-label">Alasan Reject Approval</label>
                        <div class="col-sm-7">
                            <textarea  readonly class="form-control" rows="2">'.$approval[0]['REJECT_NOTE'].'</textarea>
                        </div>
                    </div>';

                    }?>

                    <div class="form-group">
                        <label for="Invoice Date" class="col-sm-2 control-label">Tanggal Invoice</label>
                        <div class="col-sm-3 tgll">
                            <div class="input-group date startDate">
                                <input readonly="" id="startdate" required="" value="<?php echo $invoice[0]['INVOICE_DATE2'] ?>"  class="form-control start-date" name="invoice_date"  type="text">
                                <span class="input-group-addon">
                                    <a href="javascript:void(0)">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Invoice No" class="col-sm-2 control-label">No. Invoice</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $invoice[0]['NO_INVOICE'] ?>" required="" id="invoice_no" name="invoice_no" maxlength="50">
                        </div>
                        <div class="col-sm-2">
                            <a href="<?php echo base_url(UPLOAD_PATH) . '/EC_invoice/' . $invoice[0]['INVOICE_PIC']; ?>"" target="_blank"><u>File Attachment</u></a>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="Invoice No" class="col-sm-2 control-label">Bank Transfer*</label>
                        <div class="col-sm-3">
                            <select name="partner_bank" required >
                              <?php $bankTerpilih = $invoice[0]['PARTNER_BANK'];
                              foreach($listBank as $lb){
                                $selected = $bankTerpilih == $lb['PARTNER_TYPE'] ? 'selected' : '';
                                echo '<option value="'.$lb['PARTNER_TYPE'].'" '.$selected.'>'.$lb['ACCOUNT_NO'].' - '.$lb['BANK_NAME'].' - '.$lb['ACCOUNT_HOLDER'].'</option>';
                              } ?>
                            </select>
                        </div>
                        <div class="col-sm-1">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Invoice Date" class="col-sm-2 control-label">Tanggal Faktur Pajak</label>
                        <div class="col-sm-3 tgll">
                            <div class="input-group date startDate">
                                <input readonly="" id="FakturDate" value="<?php echo $invoice[0]['FAKTUR_PJK_DATE2'] ?>" class="form-control start-date" name="FakturDate" type="text">
                                <span class="input-group-addon">
                                    <a href="javascript:void(0)">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="faktur" class="col-sm-2 control-label">Faktur Pajak</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control format-pajak" value="<?php echo $invoice[0]['FAKTUR_PJK'] ?>" id="faktur" data-mask="999.999-99.9999999" name="faktur_no" >
                        </div>
                        <div class="col-sm-2">
                            <?php if(!empty($invoice[0]['FAKPJK_PIC'])){ ?>
                                <a href="<?php echo base_url(UPLOAD_PATH) . '/EC_invoice/' . $invoice[0]['FAKPJK_PIC']; ?>"" target="_blank"><u>File Attachment</u></a>
                            <?php } ?>
                        </div>
                    </div>

                    <?php
                            if($parcial['status']){
                            echo'
                            <div class="form-group">
                                <label for="faktur" class="col-sm-2 control-label">Referensi No. Faktur Pajak</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control format-pajak" value="'.$parcial['ref_fp'].'" readonly="" data-mask="999.999-99.99999999" name="ref_faktur_no" >
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label"><a href="'.base_url(UPLOAD_PATH).'/EC_invoice/'.$parcial['ref_fp_pic'].'" target="_blank"><u>File Attachment</u></a></label>
                                </div>
                            </div>
                            ';
                            }
                            ?>

                    <div class="form-group">
                        <label for="faktur" class="col-sm-2 control-label">Jenis Pajak</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="pajak" id="pajak" onchange="setRequiredPajak(this,'VZ')">
                                <?php
                                $nilaiPajakLama = 0;
                                for ($i = 0; $i < sizeof($pajak); $i++) {
                                    if($pajak[$i]['ID_JENIS'] == $invoice[0]['PAJAK']){
                                        $nilaiPajakLama = $pajak[$i]['PAJAK'];
                                    }

                                    if ($pajak[$i]['STATUS'] == "1")

                                        ?>
                                    <option <?php if ($pajak[$i]['ID_JENIS'] == $invoice[0]['PAJAK']) echo "selected" ?> value="<?php echo $pajak[$i]['ID_JENIS'] ?>" data-pajak="<?php echo $pajak[$i]['PAJAK'] ?>"><?php echo $pajak[$i]['JENIS'] ?></option>
    <?php }
?>
                            </select>
                        </div>
                        <div class="col-sm-3">

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Invoice No" class="col-sm-2 control-label">No. SP/PO</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $invoice[0]['NO_SP_PO'] ?>" required="" readonly id="invoice_no" name="sppo_no" >
                        </div>
                        <div class="col-sm-2">
                            <?php if(!empty($invoice[0]['PO_PIC'])){ ?>
                            <a href="<?php echo base_url(UPLOAD_PATH) . '/EC_invoice/' . $invoice[0]['PO_PIC']; ?>"" target="_blank"><u>File Attachment</u></a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bapp no" class="col-sm-2 control-label">No. BAPP</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $invoice[0]['NO_BAPP'] ?>" onchange="setRequired(this,'fileBapp')" id="bapp_no" name="bapp_no" >
                        </div>
                        <div class="col-sm-2">
                            <?php if(!empty($invoice[0]['BAPP_PIC'])){ ?>
                            <a href="<?php echo base_url(UPLOAD_PATH) . '/EC_invoice/' . $invoice[0]['BAPP_PIC']; ?>"" target="_blank"><u>File Attachment</u></a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bapp no" class="col-sm-2 control-label">No. BAST / RR / PP</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $invoice[0]['NO_BAST'] ?>" onchange="setRequired(this,'fileBast')" id="bapp_no" name="bast_no" >
                        </div>
                        <div class="col-sm-2">
                            <?php 
                            if(!empty($invoice[0]['BAST_PIC'])){
                                    if(preg_match('/(\.jpg|\.png|\.pdf|\.jpeg)$/i',$invoice[0]['BAST_PIC'])){
                                      echo '<label class="control-label"><a href="'.base_url(UPLOAD_PATH) . '/EC_invoice/' . $invoice[0]['BAST_PIC'].'" target="_blank">File attachment</a></label>';
                                    }else{/*
                                      $link = explode(',',$invoice[0]['BAST_PIC']);
                                      $_link = array();
                                      $_tipeDocument = $invoice[0]['ITEM_CAT'] == '9' ?  'BAST' : 'RR';
                                      foreach($link as $_l){
                                        if($_tipeDocument == 'RR'){
                                          array_push($_link,'<div class="link"><a href="#" data-iddokumen="'.$_l.'" data-url="'.site_url('EC_Invoice_Management/showDocument').'"  data-nopo="'.$invoice[0]['NO_SP_PO'].'" data-tipe="'.$_tipeDocument.'" onclick="return showDocument(this)">'.$_l.'</a></div>');
                                        }else{
                                          array_push($_link,'<div class="link"><a href="'.site_url('EC_Vendor/Bast/showDocument?bast='.$_l).'"  target="_blank">'.$_l.'</a></div>');
                                        }
                                      }
                                      echo implode(' ',$_link);*/
                                      if(!empty($lot)){
                                        $link = '';
                                        foreach ($lot as $value) {
                                            $link .= '
                                            <div class="link"><a href="#" data-nopo="'.$invoice[0]['NO_SP_PO'].'" data-tipe="RR" data-iddokumen="'.$value['LOT_NUMBER'].'" data-url="'.base_url('EC_Invoice_Management/showDocument').'" data-print_type="'.$value['PRINT_TYPE'].'" onclick="return showDocument(this)">Lot Number '.$value['LOT_NUMBER'].'</a></div>';
                                        }
                                        echo $link;
                                      }
                                    }
                                  } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bapp no" class="col-sm-2 control-label">No. Kwitansi</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $invoice[0]['NO_KWITANSI'] ?>" onchange="setRequired(this,'fileKwitansi')" id="bapp_no" name="kwitansi_no" >
                        </div>
                        <div class="col-sm-2">
                            <?php if(!empty($invoice[0]['KWITANSI_PIC'])){ ?>
                            <a href="<?php echo base_url(UPLOAD_PATH) . '/EC_invoice/' . $invoice[0]['KWITANSI_PIC']; ?>"" target="_blank"><u>File Attachment</u></a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bapp no" class="col-sm-2 control-label">K3</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" onchange="setRequired(this,'fileK3')" id="K3" name="K3" value="<?php echo $invoice[0]['K3'] ?>" >
                        </div>
                        <div class="col-sm-2">
                            <?php if(!empty($invoice[0]['K3_PIC'])){ ?>
                            <a href="<?php echo base_url(UPLOAD_PATH) . '/EC_invoice/' . $invoice[0]['K3_PIC']; ?>"" target="_blank"><u>File Attachment</u></a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bapp no" class="col-sm-2 control-label">Potongan Mutu</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" onchange="setRequired(this,'filePotMutu')" value="<?php echo $invoice[0]['POT_MUTU'] ?>" id="bapp_no" name="potmut_no" >
                        </div>
                        <div class="col-sm-2">
                            <?php 
                            if(!empty($invoice[0]['POTMUT_PIC'])){ 

                            if(preg_match('/(\.jpg|\.png|\.pdf|\.jpeg)$/i',$invoice[0]['POTMUT_PIC'])){
                              echo '<div class="col-sm-2">';
                                    if(!empty($invoice[0]['POTMUT_PIC'])){
                                      echo '<a href="'.base_url(UPLOAD_PATH) . '/EC_invoice/' . $invoice[0]['POTMUT_PIC'].'" target="_blank"><u>File Attachment</u></a>';
                                    }
                              echo  '</div>';
                            }
                            } 

                            $arr_ba = explode(',', $invoice[0]['POT_MUTU']);
                            $arr_ba = array_unique($arr_ba);

                            if(!empty($pomut)){
                                echo "<a href='#' data-no_ba='".$arr_ba[0]."'onclick='showDocumentBA(this)'><u>File Attachment</u></a>";
                            }

                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bapp no" class="col-sm-2 control-label">Surat Permohonan Pembayaran</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $invoice[0]['SURAT_PRMHONAN_BYR'] ?>" onchange="setRequired(this,'filespbyr')" id="bapp_no" name="spbyr_no" >
                        </div>
                        <div class="col-sm-2">
                            <?php if(!empty($invoice[0]['SPMHONBYR_PIC'])){ ?>
                            <a href="<?php echo base_url(UPLOAD_PATH) . '/EC_invoice/' . $invoice[0]['SPMHONBYR_PIC']; ?>"" target="_blank"><u>File Attachment</u></a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bapp no" class="col-sm-2 control-label">Denda</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="denda">
                                <?php for ($i = 0; $i < sizeof($denda); $i++) {
                                    if ($denda[$i]['STATUS'] == "1")

                                        ?>
                                    <option value="<?php echo $denda[$i]['ID_JENIS'] ?>"><?php echo $denda[$i]['JENIS'] ?></option>
    <?php }
?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" id="Nominal" name="Nominal" placeholder="1234567890">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <table class="table table-bordered tableDenda">
                                <thead>
                                    <tr>
                                        <th class="text-center">Jenis Denda</th>
                                        <th class="text-center">Nominal</th>
                                        <th class="text-center">File</th>
                                        <th class="text-center">Edit</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-denda">
<?php $count = 0;
for ($i = 0; $i < sizeof($Tdenda); $i++, $count++) { ?>
                                        <tr id="ke<?php echo $count ?>" class="dnd">
                                            <td class="text-center"><input type="hidden" name="idDenda[]" value="<?php echo $Tdenda[$i]['ID_JENIS'] ?>"><?php echo $Tdenda[$i]['JENIS'] ?></td>
                                            <td class="text-center"><input type="hidden" name="Nominal[]" value="<?php echo $Tdenda[$i]['NOMINAL'] ?>" readonly> <?php echo ribuan($Tdenda[$i]['NOMINAL']) ?></td>
                                            <td class="text-center"><input name="oldFileDenda<?php echo $i + 1 ?>" value="<?php echo $Tdenda[$i]['PIC'] ?>" type="hidden"><a href="<?php echo base_url(UPLOAD_PATH) . '/EC_invoice/' . $Tdenda[$i]['PIC']; ?>" target="_blank"><u>File Attachment</u></a></td>
                                            <td><input name="fileDenda<?php echo $i + 1 ?>" type="file"></td>
                                            <td class="text-center"><a onclick="hapusBarisDenda(this);return false" href="#"><span class="glyphicon glyphicon-trash" data-iddoc="-"" data-iddenda="<?php echo $Tdenda[$i]['ID_JENIS'] ?>" aria-hidden="true"></span></a></td>
                                        </tr>
    <?php }
?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bapp no" class="col-sm-2 control-label">Dokumen Tambahan</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="doc">
<?php for ($i = 0; $i < sizeof($doc); $i++) {
    if ($doc[$i]['STATUS'] == "1")

        ?>
                                    <option value="<?php echo $doc[$i]['ID_JENIS'] ?>"><?php echo $doc[$i]['JENIS'] ?></option>
    <?php }
?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="Nomor_Dokumen" name="Nomor_Dokumen" placeholder="Nomor Dokumen">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <table class="table table-bordered tableDoc">
                                <thead>
                                    <tr>
                                        <th class="text-center">Jenis Dokumen</th>
                                        <th class="text-center">Nomor Dokumen</th>
                                        <th class="text-center">File</th>
                                        <th class="text-center">Edit</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-doc">
                                    <?php for ($i = 0; $i < sizeof($Tdoc); $i++, $count++) { ?>
                                        <tr id="ke<?php echo $count ?>" class="dc">
                                            <td class="text-center"><input type="hidden" name="idDoc[]" value="<?php echo $Tdoc[$i]['ID_JENIS'] ?>"><?php echo $Tdoc[$i]['JENIS'] ?></td>
                                            <td class="text-center"><input type="text" name="noDoc[]" value="<?php echo $Tdoc[$i]['NO_DOC'] ?>"></td>
                                            <td class="text-center"><input name="oldFileDoc<?php echo $i + 1 ?>" value="<?php echo $Tdoc[$i]['PIC'] ?>" type="hidden"><a href="<?php echo base_url(UPLOAD_PATH) . '/EC_invoice/' . $Tdoc[$i]['PIC']; ?>"" target="_blank"><u>File Attachment</u></a></td>
                                            <td><input multiple="multiple"  name="fileDoc<?php echo $i + 1 ?>" type="file"></td>
                                            <td class="text-center"><a href="javascript:hapuss(this,'tableDoc','<?php echo $count ?>',0)"><span class="glyphicon glyphicon-trash" data-iddenda="-" data-iddoc="<?php echo $Tdoc[$i]['ID_DOC'] ?>" aria-hidden="true"></span></a></td>
                                        </tr>
    <?php }
?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                    $baseAmount = 0;
                    if(!empty($GR)){
                        foreach($GR as $_gr){
                            $baseAmount += $_gr['GR_AMOUNT_IN_DOC'];
                        }
                    }

                    ?>
                    <div class="form-group">
                        <label for="faktur" class="col-sm-2 control-label">Base Amount</label>
                        <div class="col-sm-3">
                            <input type="text" id="totalview" class="form-control" name="BaseAmount" required="" readonly="" value="<?php echo ribuan($baseAmount) ?>" data-baseamount="<?php echo $baseAmount ?>" data-pajaklama="<?php echo $nilaiPajakLama; ?>"  >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="faktur" class="col-sm-2 control-label">Total Amount</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo ribuan($invoice[0]['TOTAL_AMOUNT']) ?>" name="totalAmount" required="" id="totalAmount" readonly="">
                            <input type="hidden" id="total" name="total" value="<?php echo $invoice[0]['TOTAL_AMOUNT'] ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="note" class="col-sm-2 control-label">Note</label>
                        <div class="col-sm-6">
                            <textarea name="note" class="form-control" rows="2"><?php echo $invoice[0]['NOTE'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="status" name="status" value="<?php echo $status; ?>"/>
                        <input type="hidden" id="ID_INVOICE" name="id_invoice" value="<?php echo $invoice[0]['ID_INVOICE'] ?>"/>
                        <input type="hidden" id="VENDOR_NO" name="id_invoice" value="<?php echo $invoice[0]['VENDOR_NO'] ?>"/>    
                        <?php if($status_approval){ ?>

                        <div class="col-md-offset-2 col-md-1">
                            <a class="btn btn-success" onclick="approvalInvoice(this)" data-action='approve' data-status="<?php echo $status_approval;?>" data-t_payment = "<?php echo $total_payment;?>">Approve</a>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-danger" onclick="approvalInvoice(this)" data-action='reject' data-status="<?php echo $status_approval;?>">Reject</a>
                        </div>

                        <?php } ?>

                    </div>
                </div>
            </div>
            <div id="documentAccounting">
              <?php echo $accountingDocument ?>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table id="tableMT" class="table table-striped nowrap" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center ts0"><a href="javascript:void(0)">GR Documnet</a></th>
                                <th class="text-center ts1"><a href="javascript:void(0)">GR Line</a></th>
                                <th class="text-center ts2"><a href="javascript:void(0)">GR's Date</a></th>
                                <th class="text-center ts3"><a href="javascript:void(0)">Posting Date</a></th>
                                <th class="text-center ts4"><a href="javascript:void(0)">Description</a></th>
                                <th class="text-center ts5"><a href="javascript:void(0)">QTY</a></th>
                                <th class="text-center ts6"><a href="javascript:void(0)">UoM</a></th>
                                <th class="text-center ts7"><a href="javascript:void(0)">Value</a></th>
                                <th class="text-center ts8"><a href="javascript:void(0)">Curr</a></th>
                                <th class="text-center ts9"><a href="javascript:void(0)">PO</a></th>
                                <th class="text-center ts10"><a href="javascript:void(0)">PO LIne</a></th>
                                <th class="text-center ts11"><a href="javascript:void(0)">Check</a></th>
                            </tr>
                            <tr class="sear">
                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div >
    </div >
</section>

<div id="rejectInvoice" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reject Note</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart(base_url('EC_Approval/E_Nofa/verEnofa'), array('method' => 'POST', 'class' => 'form-horizontal formEdit')); ?>
        <div class='row'>
            <div class="form-group">
                <label for="Invoice No" class="col-sm-3 control-label">Alasan Reject</label>
                <div class="col-sm-8">
                    <textarea class="form-control" required="" id="msg" name="msg"></textarea>
                </div>
            </div>
            <div class="col-sm-12"></div>
            <div class="form-group">
                <div class="col-sm-12 text-center">
                    <a href="#" id='reject' class="btn btn-success" onclick="rejectInvoice(this)">Submit</a>
                    <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>
                </div>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php
            $pesannya = $this->session->flashdata('message');
            if (!empty($pesannya)) {
                echo '<div class="alert alert-danger">' . $pesannya . '</div>';
            }
            ?>
          <?php echo form_open_multipart('EC_Invoice_ver/'.$form_submit.'/', array('method' => 'POST', 'class' => 'form-horizontal formEdit', 'id' => 'formDetailInvoice', 'data-urlcheckpajak' => site_url('EC_Invoice_ver/checkPajak'))); ?>
            <div class="panel panel-default">
                <div class="panel-heading">Data Invoice <span style="font-size:120%;margin-left:30%"><?php echo $invoice[0]['VEND_NAME'] .' PO '.$invoice[0]['NO_SP_PO'] ?></span></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12 col-lg-12">
                            <div class="form-group">
                                <?php
                                if (isset($pesan) && !empty($pesan)) {
                                    echo '<div class="col-md-12" style="text-align:center;margin:2px auto"><span class="col-md-12 alert alert-danger">' . $pesan . '</span></div>';
                                }
                                ?>
                            </div>
                            <?php
                                if(isset($form_approve) && !empty($form_approve)){
                                    echo $form_approve;
                                    echo '<hr>';
                                }
                            ?>
                            <div class="form-group">
                                <label for="Invoice Date" class="col-sm-2 control-label">Invoice Date</label>
                                <div class="col-sm-3 tgll">
                                    <div class="input-group date startDate">
                                        <input ="" id="startdate" required value="<?php echo $invoice[0]['INVOICE_DATE2'] ?>"  class="form-control" name="invoice_date"  type="text" readonly />
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
                                    <input type="text" class="form-control" value="<?php echo $invoice[0]['NO_INVOICE'] ?>" required="" id="invoice_no" name="invoice_no"  >
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label"><a href="<?php echo base_url(UPLOAD_PATH) . '/EC_invoice/' . $invoice[0]['INVOICE_PIC']; ?>"" target="_blank">File attachment</a></label>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="Invoice No" class="col-sm-2 control-label">Bank Transfer</label>
                                <div class="col-sm-3">
                                    <select name="partner_bank" required class="col-md-12" >
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
                                <label for="faktur" class="col-sm-2 control-label">Jenis Pajak</label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="pajak" id="pajak" onchange="Invoice.setPajak(this)" >
                                        <?php
                                        $nilaiPajakNonWapu = 0;
                                        foreach ($pajak as $key => $value) {
                                            $selected = '';
                                            if($invoice[0]['PAJAK'] == $value['ID_JENIS']){
                                                $selected = 'selected';
                                                $nilaiPajakNonWapu = $value['PAJAK'];
                                            }

                                            echo "<option ".$selected." value='".$value['ID_JENIS']."' data-pajak='".$value['PAJAK']."' >".$value['ID_JENIS']." - ". $value['JENIS']."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Invoice Date" class="col-sm-2 control-label">Tanggal Faktur Pajak</label>
                                <div class="col-sm-3 tgll">
                                    <div class="input-group date startDate">
                                        <input ="" id="FakturDate" value="<?php echo $invoice[0]['FAKTUR_PJK_DATE2'] ?>" class="form-control start-date" name="FakturDate" type="text">
                                        <span class="input-group-addon">
                                            <a href="javascript:void(0)">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="faktur" class="col-sm-2 control-label">No. Faktur Pajak</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control format-pajak" value="<?php echo $invoice[0]['FAKTUR_PJK'] ?>" id="faktur" data-mask="999.999-99.99999999" name="faktur_no" >
                                </div>
                                <div class="col-sm-3">
                                    <?php if(!empty($invoice[0]['FAKPJK_PIC'])){ ?>
                                    <label class="control-label scan_faktur"><a data-get_xml_pajak="<?php echo site_url('EC_Invoice_ver/getXmlPajak')?>" data-nofaktur="<?php echo $invoice[0]['FAKTUR_PJK'] ?>" data-url="<?php echo site_url('EC_Invoice_ver/scan_faktur') ?>" data-filepath="<?php  echo 'EC_invoice/' . $invoice[0]['FAKPJK_PIC']; ?>" href="<?php echo base_url(UPLOAD_PATH) . '/EC_invoice/' . $invoice[0]['FAKPJK_PIC']; ?>"" target="_blank">File attachment</a></label>
                                    <?php  } ?>
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
                                <label for="Invoice No" class="col-sm-2 control-label">No. SP/PO</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" value="<?php echo $invoice[0]['NO_SP_PO'] ?>" required="" id="sppo_no" name="sppo_no" readonly >
                                </div>
                                <div class="col-sm-3">
                                  <?php if(!empty($invoice[0]['PO_PIC'])){ ?>
                                    <label class="control-label"><a href="<?php echo base_url(UPLOAD_PATH) . '/EC_invoice/' . $invoice[0]['PO_PIC']; ?>"" target="_blank">File attachment</a></label>
                                  <?php } ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="bapp no" class="col-sm-2 control-label">No. BAPP</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" value="<?php echo $invoice[0]['NO_BAPP'] ?>" id="bapp_no" name="bapp_no"  >
                                </div>
                                <?php
                                if(!empty($invoice[0]['BAPP_PIC'])){
                                  if(preg_match('/(\.jpg|\.png|\.pdf|\.jpeg)$/i',$invoice[0]['BAPP_PIC'])){
                                    echo '<div class="col-sm-2">';
                                          if(!empty($invoice[0]['BAPP_PIC'])){
                                            echo '<a href="'.base_url(UPLOAD_PATH) . '/EC_invoice/' . $invoice[0]['BAPP_PIC'].'" target="_blank"><u>File Attachment</u></a>';
                                          }
                                    echo  '</div>';
                                  }else{
                                    $link = explode(',',$invoice[0]['BAPP_PIC']);
                                    $_link = array();
                                    foreach($link as $_l){
                                      array_push($_link,'<div class="link"><a href="'.site_url('EC_Vendor/Bapp/showDocument?bapp='.$_l).'"  target="_blank">'.$_l.'</a></div>');
                                    }
                                    echo '<div class="col-sm-3">'.implode(' ',$_link).'</div>';
                                  }
                                }
                                ?>

                            </div>
                            <div class="form-group">
                                <label for="bapp no" class="col-sm-2 control-label">No. BAST / RR</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" value="<?php echo $invoice[0]['NO_BAST'] ?>" id="bapp_no" name="bast_no"  >
                                </div>
                                <div class="col-sm-3">
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
                                        echo '
                                            <div class="link"><a href="#" data-nopo="'.$invoice[0]['NO_SP_PO'].'" data-tipe="RR" data-iddokumen="'.$lot[0]['LOT_NUMBER'].'" data-url="'.base_url('EC_Invoice_Management/showDocument').'" data-print_type="'.$lot[0]['PRINT_TYPE'].'" onclick="return showDocument(this)">File Attachment</a></div>';
                                      }
                                    }
                                  }
                                  ?>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="bapp no" class="col-sm-2 control-label">No. Kwitansi</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" value="<?php echo $invoice[0]['NO_KWITANSI'] ?>" name="kwitansi_no"  >
                                </div>
                                <div class="col-sm-3">
                                  <?php if(!empty($invoice[0]['KWITANSI_PIC'])){ ?>
                                    <label class="control-label"><a href="<?php echo base_url(UPLOAD_PATH) . '/EC_invoice/' . $invoice[0]['KWITANSI_PIC']; ?>"" target="_blank">File attachment</a></label>
                                    <?php } ?>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="bapp no" class="col-sm-2 control-label">K3</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="K3" name="K3" value="<?php echo $invoice[0]['K3'] ?>" >
                                </div>
                                <div class="col-sm-3">
                                  <?php if(!empty($invoice[0]['K3_PIC'])){ ?>
                                    <label class="control-label"><a href="<?php echo base_url(UPLOAD_PATH) . '/EC_invoice/' . $invoice[0]['K3_PIC']; ?>"" target="_blank">File attachment</a></label>
                                  <?php } ?>
                                </div>
                            </div>

                           <div class="form-group">
                        <label for="bapp no" class="col-sm-2 control-label">Lampiran Mutu</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"  maxlength="20" onchange="setRequired(this,'filePotMutu')" value="<?php echo $invoice[0]['POT_MUTU'] ?>" id="bapp_no" name="potmut_no" >
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
                                    <input type="text" class="form-control" value="<?php echo $invoice[0]['SURAT_PRMHONAN_BYR'] ?>" id="bapp_no" name="spbyr_no"  >
                                </div>
                                <div class="col-sm-3">
                                  <?php if(!empty($invoice[0]['SPMHONBYR_PIC'])){ ?>
                                    <label class="control-label"><a href="<?php echo base_url(UPLOAD_PATH) . '/EC_invoice/' . $invoice[0]['SPMHONBYR_PIC']; ?>"" target="_blank">File attachment</a></label>
                                  <?php } ?>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="bapp no" class="col-sm-2 control-label">Denda</label>
                                <div class="col-sm-2">
                                <?php $_company = isset($companyCode) ? $companyCode : 0;  ?>
                                    <select class="form-control" id="denda" data-company="<?php echo $_company ?>">
                                        <?php
                                        foreach($mdenda as $md) {
                                          if(empty($md['GL_ACCOUNT'])){
                                        ?>
                                        <option data-glaccount="<?php echo $md['GL_ACCOUNT'] ?>" value="<?php echo $md['ID_JENIS'] ?>"><?php echo $md['JENIS'] ?></option>
                                        <?php }
                                          }
                                        ?>

                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="Nominal" name="Nominal" placeholder="1234567890">
                                </div>
                                <div class="col-sm-3">
                                    <button type="button" class="btn btn-primary" onclick="Invoice.addDenda(this)">Tambah</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-2">
                                    <table class="table table-striped table-condensed table-bordered text-center tdenda">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Jenis</th>
                                                <th class="text-center">Nominal</th>
                                                <th class="text-center">File</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody id="tbody-denda">
                                            <?php
                                            $jmlDenda = 0;
                                            //$denda =array();
                                            if(!empty($denda)){
                                            $i = 1;
                                            foreach($denda as $_d){
                                                $jmlDenda += $_d['NOMINAL'];
                                                $_styleDirectDpp = empty($_d['GL_ACCOUNT']) ? '<sup style="color:blue;font-size:80%">(Dpp)</sup>' : '';
                                                echo '<tr>'
                                                . '<td><input type="hidden" name="idDenda[]" value="'.$_d['ID_DENDA'].'" />'.$_styleDirectDpp.' '.$_d['JENIS'].'</td>'
                                                . '<td><input data-glaccount="'.$_d['GL_ACCOUNT'].'" type="hidden" name="Nominal[]" value="'.$_d['NOMINAL'].'" />'.ribuan($_d['NOMINAL']).'</td>'
                                                . '<td><input class="hide" name="fileDenda'.$i.'" type="file"><input name="oldFileDenda'.$i++.'" value="'.$_d['PIC'].'" type="hidden"><a href="'.base_url(UPLOAD_PATH). '/EC_invoice/'.$_d['PIC'].'" target="_blank">File attachment</a></td>'
                                                . '<td class="text-center"></td>'
                                                . '</tr>';
                                            }
                                            }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                              <label for="bapp no" class="col-sm-2 control-label">GL Account</label>
                              <div class="col-sm-3">
                                <select class="form-control col-md-12" name="glaccount_option" id="glaccount_option"  data-company="<?php echo $_company ?>" >
                                  <?php
                                    foreach($allgl as $_gl){
                                      echo '<option value="'.$_gl['GL_ACCOUNT'].'">'.$_gl['GL_ACCOUNT'].' - '.$_gl['LONG_TEXT'].'</option>';
                                    }
                                  ?>
                                </select>
                              </div>
                              <div class="col-sm-2">
                                <select class="form-control col-md-12" name="dk" id="dk">
                                  <option value="">Debet/Kredit</option>
                                  <option value="S">S - Debet</option>
                                  <option value="H">H - Kredit</option>
                                </select>
                              </div>
                              <div class="col-sm-2">
                                <input type="text" name="nominal_glaccount" placeholder="jumlah"/>
                              </div>
                              <div class="col-sm-2">
                                <input type="text" name="text_glaccount" placeholder="keterangan"/>
                              </div>
                              <div class="col-sm-1">
                                <span class="btn btn-primary" onclick="Invoice.addGLAccount(this)">Tambah</span>
                              </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <table class="table table-striped table-condensed table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th class="text-center">GL Account</th>
                                                <th class="text-center" style="width:120px">Description</th>
                                                <th class="text-center">Nominal</th>
                                                <th class="text-center">Debet / Kredit</th>
                                                <th class="text-center">Tax Code</th>
                                                <th class="text-center">Keterangan</th>
                                                <th class="text-center">Cost Center</th>
                                                <th class="text-center">Profit Center</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-GL">
                                          <?php
                                          $_company = isset($companyCode) ? $companyCode : 0;
                                          $_tombolProfitCenter = '';
                                            if(isset($dendaGLAccount)){
                                              if(!empty($dendaGLAccount)){
                                                $i = 1;
                                                foreach($dendaGLAccount as $dgl){
                                                  if($tombolProfitCenter){
                                                      $_tombolProfitCenter =  '<span onclick="Invoice.setProfitCenter(this)" data-baris="'.$i.'" data-company="'.$_company.'" data-glaccount="'.$dgl['GL_ACCOUNT'].'" class="btn btn-default pull-right"><i class="glyphicon glyphicon-check"></i></span>';
                                                  }
                                                  $list_pajakGL = '<select class="form-control" name="pajakGL[]" style="width:100px" >';
                                                  $list_pajakGL .= '<option value="">Pilih Jenis Pajak</option>';

                                                      foreach ($pajak as $key => $value) {
                                                          $selected = $dgl['TAX_CODE'] == $value['ID_JENIS'] ? 'selected' : '';

                                                          $list_pajakGL .= '<option '.$selected.' value="'.$value['ID_JENIS'].'">'.$value['ID_JENIS'].' - '. $value['JENIS'].'</option>';
                                                      }

                                                  $list_pajakGL .= '</select>';
                                                  echo '<tr data-baris="'.$i.'">
                                                    <td><input type="text" name="noglaccount[]" style="border:none;width:100px" value="'.$dgl['GL_ACCOUNT'].'" readonly></td>
                                                    <td>'.$keyGl[$dgl['GL_ACCOUNT']].'</td>
                                                    <td><input type="hidden" value="'.$dgl['NOMINAL'].'" name="nilai_glaccount[]">'.ribuan($dgl['NOMINAL']).'</td>
                                                    <td><input class="hide" name="fileGL[]" value="'.$dgl['DB_CR_IND'].'" type="hidden">'.($dgl['DB_CR_IND'] == 'H' ? 'Kredit' : 'Debet').'</td>
                                                    <td>'.$list_pajakGL.'</td>
                                                    <td class="cost_center"><input type="text" style="border:none;width:100px" name="textline[]" value="'.$dgl['ITEM_TEXT'].'" /></td>
                                                    <td class="cost_center"><input type="text" style="border:none;width:100px" name="costcenter[]" value="'.$dgl['COSTCENTER'].'" readonly /></td>
                                                    <td class="profit_center"><input type="text" style="border:none;width:100px" name="profit_ctr[]" value="'.($dgl['PROFIT_CTR'] != 'DUMMY' ? substr($dgl['PROFIT_CTR'],-4) : $dgl['PROFIT_CTR']).'" readonly />'.$_tombolProfitCenter.'</td>
                                                    <td class="text-center"><a onclick="Invoice.hapusGLAccount(this);return false" href="#"><span class="glyphicon glyphicon-trash"></span></a></td>
                                                  </tr>';
                                                  $i++;
                                                }
                                              }
                                            }
                                          ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bapp no" class="col-sm-2 control-label">Dokumen Tambahan</label>
                                <div class="col-sm-6">
                                    <table class="table table-striped table-condensed table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Jenis</th>
                                                <th class="text-center">Nomer Doc</th>
                                                <th class="text-center">File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(!empty($doc)){
                                            $i = 0;
                                            foreach($doc as $_d){
                                                echo '<tr>'
                                                . '<td><input type="hidden" name="idDoc[]" value="'.$_d->ID_DOC.'" >'.$_d->ID_DOC.'</td>'
                                                . '<td><input type="hidden" name="noDoc[]" value="'.$_d->NO_DOC.'" >'.$_d->NO_DOC.'</td>'
                                                . '<td><input name="oldFileDoc'.$i++.'" value="'.$_d->PIC.'" type="hidden"><a href="'.base_url(UPLOAD_PATH). '/EC_invoice/'.$_d->PIC.'" target="_blank">File attachment</a></td>'
                                                . '</tr>';
                                            }
                                            }
                                           ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="faktur" class="col-sm-2 control-label">DPP</label>
                                <?php
                                $baseAmount = 0;
                                foreach($GR as $g){
                                    if(!isset($itemData[$g['GR_NO']])){
                                      $itemData[$g['GR_NO']] = $invoice[0]['PAJAK'];
                                    }
                                    $baseAmount += $g['GR_AMOUNT_IN_DOC'];
                                }

                                ?>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="Amount" value="<?php echo ribuan($baseAmount) ?>" data-baseamount="<?php echo $baseAmount ?>" readonly>
                                </div>
                                <div class="col-sm-3">
                                  <!-- <input type="file" required name="fileAmount" /> -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="faktur" class="col-sm-2 control-label">PPN</label>
                                <div class="col-sm-3">
                                    <input type="text" name="ppn_readonly" class="form-control" value="<?php echo ribuan($nilaiPajakNonWapu * $baseAmount) ?>"  readonly>
                                </div>
                                <div class="col-sm-3">
                                  <div class="checkbox">
                                    <?php $checked = $invoice[0]['CALC_TAX'] ? 'checked' : ''; ?>
                                    <label><input type="checkbox" name="calc_tax" <?php echo $checked ?> value="calc" onclick="Invoice.setCalculateTax(this)" >Calculate Tax</label>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="faktur" class="col-sm-2 control-label">PPN Wapu</label>
                                <div class="col-sm-3">
                                    <input type="text" name="ppnwapu_readonly" class="form-control" value="<?php echo '0' ?>" readonly >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="faktur" class="col-sm-2 control-label">Denda dan GL Account</label>
                                <div class="col-sm-3">
                                    <input type="text" name="denda_readonly" class="form-control" value="<?php echo ribuan($jmlDenda) ?>" readonly >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="faktur" class="col-sm-2 control-label">Total Amount</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" value="<?php echo ribuan($invoice[0]['TOTAL_AMOUNT']) ?>" name="totalAmount" id="totalview" />
                                </div>
                                <div class="col-sm-3">

                                </div>

                            </div>
                            <div class="form-group">
                                <label for="note" class="col-sm-2 control-label">Note</label>
                                <div class="col-sm-6">
                                    <textarea name="note" class="form-control" rows="2" readonly="true"><?php echo $invoice[0]['NOTE'] ?></textarea>
                                </div>
                            </div>
                        <?php if($approve_reject && $reverse != 'create') { ?>
                            <div class="form-group">
                                <label for="note" class="col-sm-2 control-label"></label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="next_action">
                                        <option value="1">Approve</option>
                                        <option value="0">Reject</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" style="display:none">
                                <div class="col-sm-12">
                                    <textarea maxlength="255" name="alasan_reject" class="form-control" rows="3"><?php echo $invoice[0]['ALASAN_REJECT'] ?></textarea>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($invoice[0]['STATUS_HEADER'] < 5 && $reverse != 'create'){ ?>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-sm-4">
                                    <input type="hidden" id="ID_INVOICE" name="ID_INVOICE" value="<?php echo $invoice[0]['ID_INVOICE'] ?>"/>
                                    <button class="btn btn-info" type="submit">Simpan</button>
                                    <?php

                                        echo $tombolPosting;

                                    ?>
                                    <a href="<?php echo site_url('EC_Invoice_ver') ?>" class="btn btn-info">Kembali</a>
                                </div>
                                <div class='col-sm-6'>
                                    <?php echo $tombolSimulate;?>
                                </div>
                            </div>
                        <?php }
                        if($reverse == 'create'){?>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-sm-4">
                                    <input type="hidden" id="ID_INVOICE" name="ID_INVOICE" value="<?php echo $invoice[0]['ID_INVOICE'] ?>"/>
                                    <input type="hidden" id="REVERSE" name="REVERSE" value="<?php echo $reverse;?>"/>
                                    <input type="hidden" id="next_action" name="next_action" value="1"/>
                                    <button class="btn btn-info" type="submit">Create Invoice</button>
                                </div>
                            </div>
                        <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Detail Item<span class="pull-right accordian-panel"><i class="glyphicon glyphicon-plus"></i></span></div>
                <div class="panel-body" style="display:none">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
                            <table id="tableMT" class="table table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center ts1"><a href="javascript:void(0)">No</a></th>
                                        <th class="text-center ts0"><a href="javascript:void(0)">System No</a></th>
                                        <th class="text-center ts0"><a href="javascript:void(0)">No. GR</a></th>
                                        <th class="text-center ts4"><a href="javascript:void(0)">Description</a></th>
                                        <th class="text-center ts5"><a href="javascript:void(0)">QTY</a></th>
                                        <th class="text-center ts6"><a href="javascript:void(0)">UoM</a></th>
                                        <th class="text-center ts7"><a href="javascript:void(0)">Value</a></th>
                                        <th class="text-center ts7"><a href="javascript:void(0)">Amount (DPP)</a></th>
                                        <th class="text-center ts7"><a href="javascript:void(0)">Tax Base Amount</a></th>
                                        <th class="text-center ts7"><a href="javascript:void(0)">Tax Amount</a></th>
                                        <th class="text-center ts8"><a href="javascript:void(0)">Curr</a></th>
                                        <th class="text-center ts9"><a href="javascript:void(0)">PO</a></th>
                                        <th class="text-center ts9"><a href="javascript:void(0)">PO Item</a></th>
                                        <th class="text-center ts9"><a href="javascript:void(0)">GL Account</a></th>
                                        <th class="text-center ts9"><a href="javascript:void(0)">Pajak</a></th>
                                    </tr>

                                </thead>
                                <tbody class="tbodyGRItem">
<?php
for ($i = 0; $i < sizeof($GR); $i++) {
    $no = $i + 1;
    ?>
                                        <tr>
                                            <?php
                                            $grKeyItem = $GR[$i]['GR_NO'].'-'.$GR[$i]['GR_ITEM_NO'];
                                            $nilaiBaseAmount  = ribuan($GR[$i]['GR_AMOUNT_IN_DOC']) ;
                                            if(isset($itemData[$grKeyItem])){
                                              if(is_array($itemData[$grKeyItem])){
                                                $nilaiBaseAmount = ribuan($itemData[$grKeyItem]['ITEM_AMOUNT']);
                                              }
                                            }

                                            ?>
                                            <td class="text-center"><?php echo $no ?></td>
                                            <td class="text-center"><?php echo $GR[$i]['GR_NO'] ?></td>
                                            <td class="text-center" data-key='<?php echo $grKeyItem;?>'><?php echo isset($GR[$i]['RR_NO']) ? $GR[$i]['RR_NO'] : $GR[$i]['GR_NO'] ?></td>
                                            <td class="text-center"><?php echo $GR[$i]['DESCRIPTION'] ?></td>
                                            <td class="text-center"><?php echo number_format($GR[$i]['GR_ITEM_QTY'],2,',','.') ?></td>
                                            <td class="text-center"><?php echo $GR[$i]['GR_ITEM_UNIT'] ?></td>
                                            <td class="text-center amount" data-amount="<?php echo $GR[$i]['GR_AMOUNT_IN_DOC'] ?>"><?php echo ribuan($GR[$i]['GR_AMOUNT_IN_DOC']) ?></td>
                                            <td class="text-center adjustAmount"><input name="amountSAP[<?php echo $grKeyItem ?>]" type="text" value="<?php echo $nilaiBaseAmount ?>" style="border:none;width:100px" onchange="Invoice.hitungAmount(this)"></td>
                                            <?php
                                              $taxBaseAmountSAP = $nilaiBaseAmount;
                                              $taxAmountSAP = 0;
                                              if(!empty($taxdata) && !$invoice[0]['CALC_TAX']){
                                                if(isset($taxdata[$grKeyItem])){
                                                  $taxAmountSAP = ribuan($taxdata[$grKeyItem]['TAX_AMOUNT']);
                                                }
                                              }
                                              /* periksa apakah calculate tax tercentang atau tidak */
                                              $_readonly_tax = $invoice[0]['CALC_TAX'] ? 'readonly' : '';
                                            ?>
                                            <td class="text-center taxBaseAmount"><input class="angka form-control" name="taxBaseAmountSAP[<?php echo $grKeyItem ?>]" type="text" value="<?php echo $taxBaseAmountSAP ?>" style="border:none;width:100px" onchange="Invoice.hitungAmount(this)" <?php echo $_readonly_tax ?> ></td>
                                            <td class="text-center taxAmount"><input class="angka form-control" name="taxAmountSAP[<?php echo $grKeyItem ?>]" type="text" value="<?php echo $taxAmountSAP ?>" style="border:none;width:100px" onchange="Invoice.hitungAmount(this)" <?php echo $_readonly_tax ?> ></td>
                                            <td class="text-center"><?php echo $GR[$i]['GR_CURR'] ?></td>
                                            <td class="text-center"><?php echo $GR[$i]['PO_NO'] ?></td>
                                            <td class="text-center"><?php echo $GR[$i]['PO_ITEM_NO'] ?></td>

                                            <td class="text-center"><?php echo (isset($referenceGL[$grKeyItem]) ? $referenceGL[$grKeyItem] : '') ?></td>
                                            <td class="text-center">
                                              <select class="form-control" name="pajak_gr[<?php echo $grKeyItem ?>]" onchange="Invoice.setPajakHeader(this)" style="min-width:60px">
                                                  <?php
                                                  foreach($pajak as $key => $value){
                                                    $selected = $invoice[0]['PAJAK'] == $value['ID_JENIS'] ? 'selected' : '';
                                                    if(isset($itemData[$grKeyItem])){
                                                      if(is_array($itemData[$grKeyItem])){
                                                        $selected  = $itemData[$grKeyItem]['TAX_CODE'] == $value['ID_JENIS'] ? 'selected' : '';
                                                      }
                                                    }
                                                      echo "<option data-pajak='".$value['PAJAK']."' ".$selected." value='".$value['ID_JENIS']."' >".$value['ID_JENIS']." - ". $value['JENIS']."</option>";
                                                  }
                                                  ?>
                                              </select>
                                            </td>
                                        </tr>
<?php }
?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
          <?php echo form_close() ?>
        </div>
    </div>
</section>

<div id="simulateInvoice" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Simulate Invoice</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger hide" id="alert"></div>
        <table class="table table-responsive" id="tabelSimulate">

        </table>
        <table class="table table-responsive" id="tabelDK">

        </table>
      </div>
      <div class="modal-footer text-center">
      </div>
    </div>

  </div>
</div>

<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-lg-12">
                    <?php echo form_open_multipart('EC_Invoice_um_ver/update_invoice/', array('method' => 'POST', 'class' => 'form-horizontal formCreate')); ?>
                    <input type="hidden" name="id_um" value="<?php echo $noinvoice; ?>">
                    <input type="hidden" name="status" value="<?php echo $status; ?>">
                    <div class="form-group">
                        <label for="Invoice Date" class="col-sm-3 control-label">Tanggal Invoice *</label>
                        <div class="col-sm-4 tgll">
                            <div class="input-group date startDate">
                                <input readonly="" id="startdate" required=""  class="form-control start-date" name="invoice_date"  type="text" value="<?php echo date('d-m-Y', strtotime($detail_um['INVOICE_DATE'])) ?>">
                                <span class="input-group-addon">
                                    <a href="javascript:void(0)">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Invoice No" class="col-sm-3 control-label">Bank Transfer*</label>
                        <div class="col-sm-4">
                            <select name="partner_bank" required class="col-md-12">
                                <?php foreach($listBank as $lb){
                                    $selected = "";
                                    if($detail_um['PARTNER_BANK']==$lb['PARTNER_TYPE']){
                                        $selected = "selected";
                                    }
                                    echo '<option '.$selected.' value="'.$lb['PARTNER_TYPE'].'">'.$lb['ACCOUNT_NO'].' - '.$lb['BANK_NAME'].' - '.$lb['ACCOUNT_HOLDER'].'</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-3">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="faktur" class="col-sm-3 control-label">Jenis Pajak</label>
                        <div class="col-sm-4">
                            <select required="" class="form-control" name="pajak" id="pajak" onchange="setRequiredPajak(this,'VZ')">
                                <option value="">Pilih Jenis Pajak</option>
                                <?php
                                $nilaiPajakLama = 0;
                                for ($i = 0; $i < sizeof($pajak); $i++) { 
                                    $selected = "";
                                    if($detail_um['PAJAK']==$pajak[$i]['ID_JENIS']){
                                        $selected = "selected";
                                    }
                                    ?>
                                    <option <?php echo $selected; ?> value="<?php echo $pajak[$i]['ID_JENIS'] ?>" data-pajak="<?php echo $pajak[$i]['PAJAK'] ?>">
                                        <?php
                                        if($pajak[$i]['ID_JENIS'] == "VN"){
                                            echo "PPN";
                                        }else{ echo "Tanpa PPN";} }?>

                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Invoice Date" class="col-sm-3 control-label">Tanggal Faktur Pajak </label>
                            <div class="col-sm-4 tgll">
                                <div class="input-group date startDate">
                                    <input readonly="" id="FakturDate"  class="form-control start-date" name="FakturDate" required="" type="text" value="<?php echo date('d-m-Y', strtotime($detail_um['FAKTUR_PJK_DATE'])) ?>">
                                    <span class="input-group-addon">
                                        <a href="javascript:void(0)">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="faktur" class="col-sm-3 control-label">No. Faktur Pajak </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control format-pajak" id="faktur" data-mask="999.999-99.99999999"  name="faktur_no" value="<?php echo $detail_um['FAKTUR_PJK']; ?>">
                            </div>
                            <div class="col-sm-4">
                                <a href="<?php echo base_url(UPLOAD_PATH) . '/EC_um/'.$detail_um['FAKPJK_PIC']; ?>"><span class="glyphicon glyphicon-file"></span> File</a>
                            </div>
                            <?php 
                            if ($status != 1 && $status != 4) {
                            } else {
                                ?>
                                <div class="col-sm-3">
                                    <input type="file" id="file_faktur" name="fileFaktur" />
                                </div>
                                <?php
                            }
                            ?>
                        </div>


                        <div class="form-group">
                            <label for="Invoice No" class="col-sm-3 control-label">No. SP/PO *</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" readonly="" id="sppo_no" name="sppo_no" value="<?php echo $detail_um['NO_SP_PO']; ?>">
                            </div>
                            <div class="col-sm-4">
                                <a href="<?php echo base_url(UPLOAD_PATH) . '/EC_um/'.$detail_um['PO_PIC']; ?>"><span class="glyphicon glyphicon-file"></span> File</a>
                            </div>
                            <?php 
                            if ($status != 1 && $status != 4) {
                            } else {
                                ?>
                                <div class="col-sm-3">
                                    <input type="file" required name="filePO" />
                                </div>
                                <?php
                            }
                            ?>

                        </div>

                        <div class="form-group">
                            <label for="bapp no" class="col-sm-3 control-label">No. Kwitansi</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" maxlength="50" onchange="setRequired(this,'fileKwitansi')" id="kwitansi_no" name="kwitansi_no" value="<?php echo $detail_um['NO_KWITANSI']; ?>">
                            </div>
                            <div class="col-sm-4">
                                <a href="<?php echo base_url(UPLOAD_PATH) . '/EC_um/'.$detail_um['KWITANSI_PIC']; ?>"><span class="glyphicon glyphicon-file"></span> File</a>
                            </div>
                            <?php 
                            if ($status != 1 && $status != 4) {
                            } else {
                                ?>
                                <div class="col-sm-3">
                                    <input type="file" name="fileKwitansi" />
                                </div>
                                <?php
                            }
                            ?>
                        </div>

                        <div class="form-group">
                            <label for="bapp no" class="col-sm-3 control-label">No LPB</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="K3" maxlength="20" name="K3" onchange="setRequired(this,'fileK3')" value="<?php echo $detail_um['LPB']; ?>">
                            </div>
                            <div class="col-sm-4">
                                <a href="<?php echo base_url(UPLOAD_PATH) . '/EC_um/'.$detail_um['LPB_PIC']; ?>"><span class="glyphicon glyphicon-file"></span> File</a>
                            </div>
                            <?php 
                            if ($status != 1 && $status != 4) {
                            } else {
                                ?>
                                <div class="col-sm-3">
                                    <input type="file" name="fileK3" />
                                </div>
                                <?php
                            }
                            ?>
                        </div>


                        <div class="form-group">
                            <label for="faktur" class="col-sm-3 control-label">Base Amount</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="Amount" required="" id="totalview" readonly="" value="<?php echo number_format($detail_um['BASE_AMOUNT']); ?>">
                                <input type="hidden" id="base_amount" name="base_amount" value="<?php echo $detail_um['BASE_AMOUNT']; ?>"/>
                            </div>
                            <div class="col-sm-3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="note" class="col-sm-3 control-label">DP Req Amount</label>
                            <div class="col-sm-4">
                                <input name="dp_req_amount_tampil" id="dp_req_amount" class="form-control" value="<?php echo number_format($detail_um['DP_REQ_AMOUNT']); ?>"/>
                                <input type="hidden" name="dp_req_amount" id="dp_req_amount" class="form-control" value="<?php echo $detail_um['DP_REQ_AMOUNT']; ?>"/>
                            </div>
                        </div>
                        <?php 
                        if ($status == 2) {
                            ?>
                            <div class="form-group">
                                <label for="note" class="col-sm-2 control-label"></label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="next_action">
                                        <option value="3">Approve</option>
                                        <option value="4">Reject</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" style="display:none">
                                <div class="col-sm-6">
                                    <textarea maxlength="255" name="alasan_reject" class="form-control" rows="3"></textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-6">
                                    <input type="hidden" id="arrGR" name="arrgr" />
                                    <input type="hidden" id="curr" name="curr" />
                                    <input type="hidden" id="itemCat" name="itemCat" />
                                    <input type="hidden" id="jmlDenda" name="jmlDenda" />
                                    <input type="hidden" id="jmlDoc" name="jmlDoc" />
                                    <button class="btn btn-info pull-right btn-simpan" type="submit">Simpan</button>
                                </div>
                            </div>                            
                            <?php
                        } else if ($status == 3) {
                            ?>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <button class="btn btn-info pull-right btn-simpan" type="submit">Posting</button>
                                </div>
                            </div>
                            <?php
                        } else if ($status == 5) {
                            ?>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <button class="btn btn-info pull-right btn-simpan" type="submit">Ekspedisi Ke Bendahara</button>
                                </div>
                            </div>
                            <?php
                        } 
                        ?>

                    </form>
                </div>
            </div>

            
        </div >
    </div >
</section>

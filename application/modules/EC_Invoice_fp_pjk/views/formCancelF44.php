<div>

      <?php echo form_open_multipart('EC_Invoice_ver/EC_Reverse_Invoice/saveCancelF44/', array('method' => 'POST', 'class' => 'form-horizontal formEdit', 'id' => 'formDetailInvoice')); ?>

                        <div class="form-group">
                            <label for="Invoice Date" class="col-sm-3 control-label">Nomer Document</label>
                            <div class="col-sm-6">
                                    <input type="hidden" name="DOCUMENT_ID" value="<?php echo $invoice['documentid'] ?>" />
                                    <input  class="form-control" name="P_BELNR1"  type="text" required value="<?php echo $invoice['fiNumberLama'] ?>"  readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Invoice No" class="col-sm-3 control-label">Document Reversal</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="P_BELNR2" required value="<?php echo $invoice['fiNumberReversal'] ?>" readonly />
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="Invoice No" class="col-sm-3 control-label">Vendor</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="P_ACCOUNT" required value="<?php echo $invoice['vendorNo'] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Invoice No" class="col-sm-3 control-label">Company</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="P_BUKRS" required value="<?php echo $invoice['companyCode'] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Invoice No" class="col-sm-3 control-label">Currency</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="P_WAERS" required value="<?php echo $invoice['currency'] ?>" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Invoice No" class="col-sm-3 control-label">Tanggal Posting</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control tgl" name="P_BUDAT" required value="<?php echo date('d/m/Y') ?>" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Invoice No" class="col-sm-3 control-label">Bulan Posting</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" maxlength="2" name="P_MONAT" required value="<?php echo date('m') ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-offset-3">
                            <input type="submit" class="btn btn-primary" value="Simpan" >
                            <span class="btn btn-danger" onclick="bootbox.hideAll()" >Batal</span>
                          </div>
                        </div>



      <?php echo form_close() ?>
    </div>

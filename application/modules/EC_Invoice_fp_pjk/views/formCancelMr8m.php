    <div>

          <?php echo form_open_multipart('EC_Invoice_ver/EC_Reverse_Invoice/saveCancelMr8m/', array('method' => 'POST', 'class' => 'form-horizontal formEdit', 'id' => 'formDetailInvoice')); ?>

                            <div class="form-group">
                                <label for="Invoice Date" class="col-sm-3 control-label">Nomer Mir</label>
                                <div class="col-sm-6">
                                        <input type="hidden" name="DOCUMENT_ID" value="<?php echo $invoice['documentid'] ?>" />
                                        <input  class="form-control" name="INVOICEDOCNUMBER"  type="text" required value="<?php echo $invoice['mir7'] ?>"  readonly/>


                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Invoice No" class="col-sm-3 control-label">Tahun</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" maxlength="4" name="FISCALYEAR" required value="<?php echo $invoice['tahun'] ?>" readonly />
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="Invoice No" class="col-sm-3 control-label">Tanggal Posting</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control tgl" name="POSTINGDATE" required value="<?php echo date('d/m/Y') ?>" readonly />
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Alasan</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="REASONREVERSAL" required>
                                      <?php
                                        foreach($reason as $_k => $_rs){
                                          echo '<option value="'.$_k.'">'.$_k.' - '.$_rs.'</option>';
                                        }
                                      ?>
                                    </select>
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
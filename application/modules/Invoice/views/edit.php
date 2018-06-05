<section>
<div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel">
                                <div class="panel-heading">Invoice Vendor</div>
                                <input type="text" class="hidden" name="vendor_id">
                                <div class="panel-body">
                                <?php echo form_open_multipart('Invoice/updateInvoice/', array('method' => 'POST', 'class' => 'form-horizontal')); ?>
                                 <input type="text" class="hidden" name="edit_id" value="<?php echo set_value('edit_id', $ver['ID_INVOICE']); ?>">
                                <?php if ($ver['STATUS'] == 2) {?>
                                        <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="alert alert-warning" role="alert"><strong>Keterangan Revisi! </strong><?php echo $ver['REASON']; ?></div> 
                                                </div>
                                            </div>
                                <?php }?>
                                    <!-- <div class="col-md-12 hidden">
                                        <input type="hidden" class="form-control" id="edit_id" name="edit_id" value="<?php echo $ver['ID_INVOICE']?>">
                                    </div> -->

                                <div class="form-group" style="display: flex; margin-top: 15px;">
                                        <label for="new_tgl" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">Tanggal Invoice</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="new_tgl_inv" id="new_tgl_inv" class="form-control" value="<?php echo $ver['TGL_INV']?>" ><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="new_po" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">No. PO</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" maxlength="10" id="new_po" name="new_po" value="<?php echo $ver['NO_PO']?>" >
                                        </div>
                                    </div>

                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="new_po" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">No. GR</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" maxlength="10" id="new_gr" name="new_gr" value="<?php echo $ver['NO_GR']?>" >
                                        </div>
                                    </div>

                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="new_invoice" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">No. Invoice</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_invoice" name="new_invoice" value="<?php echo $ver['NO_INVOICE']?>" >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="new_pajak" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">Faktur Pajak</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_pajak" name="new_pajak" value="<?php echo $ver["F_PAJAK"]?>" >
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="new_file_pajak" class="hidden" name="new_file_pajak" value="<?php echo set_value('new_file_pajak', $ver["FILE_PAJAK"]); ?>">
                                            <?php
                                            if (!empty($ver["FILE_PAJAK"])) { ?>
                                                <span class="messageUpload"><a style="color: #666; text-decoration: underline" href="<?php echo base_url('Invoice')."/viewDok/".$ver["FILE_PAJAK"]; ?>" title="File Attachment" target="_blank">File Attachment</a>&nbsp;&nbsp;</span>&nbsp;&nbsp;
                                            <?php
                                            }
                                            else { ?>
                                                <span class="messageUpload" style="display:none"></span>&nbsp;&nbsp;
                                            <?php }
                                            ?>
                                            <?php if (!empty($ver["FILE_PAJAK"])) { ?>
                                                <input type="file" name="new_file_pajak" id="new_file_pajak" class="uploadfile" style="display: table-column;">
                                            <?php
                                            }
                                            else { ?>
                                                <input type="file" name="new_file_pajak" id="new_file_pajak" class="uploadfile" style="display: table-column;">
                                            <?php }
                                            ?>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="new_bapp" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">BAPP</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_bapp" name="new_bapp" value="<?php echo $ver['FIK_BAPP']?>" >
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="new_file_bapp" class="hidden" name="new_file_bapp" value="<?php echo set_value('new_file_bapp', $ver["FILE_BAPP"]); ?>">
                                            <?php
                                            if (!empty($ver["FILE_BAPP"])) { ?>
                                                <span class="messageUpload"><a style="color: #666; text-decoration: underline" href="<?php echo base_url('Invoice')."/viewDok/".$ver["FILE_BAPP"]; ?>" title="File Attachment" target="_blank">File Attachment</a>&nbsp;&nbsp;</span>&nbsp;&nbsp;
                                            <?php
                                            }
                                            else { ?>
                                                <span class="messageUpload" style="display:none"></span>&nbsp;&nbsp;
                                            <?php }
                                            ?>
                                            <?php if (!empty($ver["FILE_BAPP"])) { ?>
                                                <input type="file" name="new_file_bapp" id="new_file_bapp" class="uploadfile" style="display: table-column;">
                                            <?php
                                            }
                                            else { ?>
                                                <input type="file" name="new_file_bapp" id="new_file_bapp" class="uploadfile" style="display: table-column;">
                                            <?php }
                                            ?>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="new_bast" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">BAST</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_bast" name="new_bast" value="<?php echo $ver['FIK_BAST']?>" >
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="new_file_bast" class="hidden" name="new_file_bast" value="<?php echo set_value('new_file_bast', $ver["FILE_BAST"]); ?>">
                                            <?php
                                            if (!empty($ver["FILE_BAST"])) { ?>
                                                <span class="messageUpload"><a style="color: #666; text-decoration: underline" href="<?php echo base_url('Invoice')."/viewDok/".$ver["FILE_BAST"]; ?>" title="File Attachment" target="_blank">File Attachment</a>&nbsp;&nbsp;</span>&nbsp;&nbsp;
                                            <?php
                                            }
                                            else { ?>
                                                <span class="messageUpload" style="display:none"></span>&nbsp;&nbsp;
                                            <?php }
                                            ?>
                                            <?php if (!empty($ver["FILE_BAST"])) { ?>
                                                <input type="file" name="new_file_bast" id="new_file_bast" class="uploadfile" style="display: table-column;">
                                            <?php
                                            }
                                            else { ?>
                                                <input type="file" name="new_file_bast" id="new_file_bast" class="uploadfile" style="display: table-column;">
                                            <?php }
                                            ?>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="new_ket" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">Keterangan</label>
                                        <div class="col-sm-3">
                                            <textarea name="new_ket" style="margin: 0px; width: 440px; height: 96px;"><?php echo $ver['KETERANGAN']?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button color1 small_btn" type="submit">Simpan</button>
                                    <a href="<?php echo base_url('Invoice') ?>" class="main_button color7 small_btn">Batal</a>
                                </div>
                                </form>
                            </div>
                            </section>
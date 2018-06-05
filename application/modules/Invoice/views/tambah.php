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
                                <?php echo form_open_multipart('Invoice/namalain/', array('method' => 'POST', 'class' => 'form-horizontal')); ?>
                                    <div class="col-md-12 hidden">
                                        <input type="hidden" class="form-control" id="edit_id" name="edit_id">
                                    </div>

                                <div class="form-group" style="display: flex; margin-top: 15px;">
                                        <label for="new_tgl" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">Tanggal Invoice</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="new_tgl_inv" id="new_tgl_inv" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="new_po" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">No. PO</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" maxlength="10" id="new_po" name="new_po">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="new_gr" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">No. GR</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" maxlength="10" id="new_gr" name="new_gr">
                                        </div>
                                    </div>

                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="new_invoice" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">No. Invoice</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_invoice" name="new_invoice">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="new_pajak" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">Nomor Faktur Pajak</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_pajak" name="new_pajak">
                                        </div>
                                        <div class="colm-sm-6">
                                            <input type="text" id="akta_no_doc" class="hidden" name="new_file_pajak">
                                            <button type="button" class="uploadAttachment btn btn-default">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="new_bapp" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">BAPP</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_bapp" name="new_bapp">
                                        </div>
                                        <div class="colm-sm-6">
                                            <input type="text" id="akta_no_doc" class="hidden" name="new_file_bapp">
                                            <button type="button" class="uploadAttachment btn btn-default">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="new_bast" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">BAST</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_bast" name="new_bast">
                                        </div>
                                        <div class="colm-sm-6">
                                            <input type="text" id="akta_no_doc" class="hidden" name="new_file_bast">
                                            <button type="button" class="uploadAttachment btn btn-default">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="new_ket" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">Keterangan</label>
                                        <div class="col-sm-3">
                                            <textarea name="new_ket" style="margin: 0px; width: 440px; height: 96px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button id="save_new" class="main_button color1 small_btn" type="submit">Simpan</button>
                                    <a href="<?php echo base_url('Invoice') ?>" class="main_button color7 small_btn">Batal</a>
                                </div>
                                </form>
                            </div>
                            </section>
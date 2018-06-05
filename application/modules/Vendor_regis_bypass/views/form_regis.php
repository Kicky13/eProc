        <section class="content_section">
            <div class="zoom-anim-dialog large-dialog mfp-hide" id="finish-popup">
                <div class="modal-header">
                    <h4 class="modal-title">Perhatian!</h4>
                </div>
                <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
                   <p class="text-justify">Apakah Anda yakin untuk menyelesaikan proses pendaftaran vendor ini ? <br>
                    Jika tidak anda bisa melakukan review data vendor ini.</p>
                </div>
                <div class="modal-footer text-center">
                    <!-- <form action="do_finish_register" method="POST"> -->
                        <?php echo form_open('Vendor_regis_bypass/do_finish_register', array('class' => 'form-horizontal')); ?>
                        <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                        <input type="button" id="closeModal" class="main_button small_btn bottom_space" value="Tidak">
                        <button type="submit" class="main_button color1 small_btn bottom_space" id="finish_registration_button">Ya</button>
                        <?php echo form_close(); ?>
                    <!-- </form> -->
                </div>
            </div>

            <input type="text" class="hidden" id="vendor_type" name="vendor_type" value="<?php echo set_value('vendor_type', $vendor_detail["VENDOR_TYPE"]); ?>">
            <div class="modal fade" id="updateLegalDataModal" tabindex="-1" role="dialog" aria-labelledby="updateLegalData">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Akta Perusahaan Vendor</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Vendor_regis_bypass/do_insert_akta_pendirian',array('class' => 'form-horizontal current_edited_akta')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="text" class="hidden" name="akta_id" id="akta_id">
                                <div class="form-group">
                                    <label for="akta_no" class="col-sm-3 control-label">
                                        No. Akta
                                        <?php if($vendor_detail["VENDOR_TYPE"] == "NASIONAL"): ?>
                                            <span style="color: #E74C3C">*</span>
                                        <?php elseif($vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL"):?>
                                            
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "PERORANGAN"):?>
                                            
                                        <?php endif ?>
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="akta_no" name="akta_no">
                                    </div>
                                    <div class="colm-sm-6">
                                        <input type="text" id="akta_no_doc" class="hidden" name="akta_no_doc" value="<?php echo set_value('npwp_no_doc', $vendor_detail["NPWP_NO_DOC"]); ?>">
                                        <button type="button" required class="uploadAttachment btn btn-default">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                        <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                            <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="akta_type" class="col-sm-3 control-label">Jenis Akta
                                        <?php if($vendor_detail["VENDOR_TYPE"] == "NASIONAL"): ?>
                                            <span style="color: #E74C3C">*</span>
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL"):?>
                                            
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "PERORANGAN"):?>
                                            
                                        <?php endif ?>
                                    </label>
                                    <div class="col-sm-3 end">
                                        <label for="akta_type" class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="akta_type" id="akta_type" required="">
                                                <?php foreach ($akta_type as $key => $value) { ?>
                                                    <option value="<?php echo $value["AKTA_TYPE"]; ?>"><?php echo $value["AKTA_TYPE"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="date_creation" class="col-sm-3 control-label">Tanggal Akta
                                        <?php if($vendor_detail["VENDOR_TYPE"] == "NASIONAL"): ?>
                                            <span style="color: #E74C3C">*</span>
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL"):?>
                                            
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "PERORANGAN"):?>
                                            
                                        <?php endif ?>
                                    </label>
                                    <div class="col-sm-3 end">
                                        <div class="input-group date">
                                            <input type="text" id="tgl_akta" name="date_creation" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="notaris_name" class="col-sm-3 control-label">Nama Notaris
                                        <?php if($vendor_detail["VENDOR_TYPE"] == "NASIONAL"): ?>
                                            <span style="color: #E74C3C">*</span>
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL"):?>
                                             
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "PERORANGAN"):?>
                                            
                                        <?php endif ?>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="notaris_name" name="notaris_name" value="<?php echo set_value('notaris_name'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="notaris_address" class="col-sm-3 control-label">Alamat Notaris
                                        <?php if($vendor_detail["VENDOR_TYPE"] == "NASIONAL"): ?>
                                            <span style="color: #E74C3C">*</span>
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL"):?>
                                             
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "PERORANGAN"):?>
                                            
                                        <?php endif ?>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="notaris_address" name="notaris_address" value="<?php echo set_value('notaris_address'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pengesahan_hakim" class="col-sm-3 control-label">Pengesahan Kehakiman</label>
                                    <div class="col-sm-3">
                                        <div class="input-group date">
                                            <input type="text" id="pengesahan_hakim" name="pengesahan_hakim" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                    <div class="colm-sm-6">
                                        <input type="text" id="pengesahan_hakim_doc" class="hidden" name="pengesahan_hakim_doc" value="<?php echo set_value('npwp_no_doc', $vendor_detail["NPWP_NO_DOC"]); ?>">
                                        <button type="button" required class="uploadAttachment btn btn-default">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                        <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                            <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="berita_acara_ngr" class="col-sm-3 control-label">Berita Negara</label>
                                    <div class="col-sm-3">
                                        <div class="input-group date">
                                            <input type="text" id="berita_acara_ngr" name="berita_acara_ngr" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                    <div class="colm-sm-6">
                                        <input type="text" id="berita_acara_ngr_doc" class="hidden" name="berita_acara_ngr_doc" value="<?php echo set_value('npwp_no_doc', $vendor_detail["NPWP_NO_DOC"]); ?>">
                                        <button type="button" required class="uploadAttachment btn btn-default">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                        <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                            <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_legal_data_button">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="updateRekeningModal" tabindex="-1" role="dialog" aria-labelledby="updateRekening">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Rekening Data</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Vendor_regis_bypass/do_insert_akta_pendirian',array('class' => 'form-horizontal current_edited_bank_financial')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="text" class="hidden" name="bank_id" id="bank_id">
                                <div class="form-group">
                                    <label for="account_no" class="col-sm-3 control-label">No. Rekening<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="account_no_edit" name="account_no">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="account_name" class="col-sm-3 control-label">Pemegang Rekening<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control text-uppercase" id="account_name_edit" name="account_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bank_name" class="col-sm-3 control-label">Nama Bank<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control text-uppercase" id="bank_name_edit" name="bank_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bank_branch" class="col-sm-3 control-label">Cabang Bank<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control text-uppercase" id="bank_branch_edit" name="bank_branch">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="swift_code" class="col-sm-3 control-label">Swift Code<?php if ($vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="swift_code_edit" name="swift_code">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="col-sm-3 control-label">Alamat Bank<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control text-uppercase" id="address_edit" name="address">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bank_postal_code" class="col-sm-3 control-label">Kode Pos Bank<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="bank_postal_code_edit" name="bank_postal_code" maxlength="5">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="currency" class="col-sm-3 control-label">Mata Uang<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-3">
                                        <?php
                                        echo form_dropdown('currency', $currency, '', 'id="currency_edit" class="form-control"'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label for="reference" class="col-sm-3 control-label">Reference Bank</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="reference_bank_edit" name="reference_bank">
                                        </div>

                                        <div class="colm-sm-5">
                                            <input type="text" id="filename" class="hidden" name="file_bank">
                                            <button type="button" required class="uploadAttachment btn btn-default file">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                                &nbsp;&nbsp;<a class="btn btn-default delete_upload_file_ba glyphicon glyphicon-trash"></a>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="col-sm-3 progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_rekening_data_button">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Registration Vendor By Operator</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open('Vendor_regis_bypass/do_insert_akta_pendirian',array('class' => 'form-horizontal insert_akta', 'autocomplete'=>'off')); ?>
                            <?php $container = 'Akta Pendirian'; ?>
                            <div class="panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'hidden') ?>">
                                <div class="panel-heading">Akta Perusahaan</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <?php if(isset($progress_status[$container]) && $progress_status[$container]['STATUS'] == 'Rejected'):?>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="alert alert-warning" role="alert"><strong>Keterangan Revisi! </strong><?php echo $progress_status[$container]['REASON']; ?></div> 
                                            </div>
                                        </div>
                                        <hr>
                                    <?php endif ?>
                                    <div class="form-group">
                                        <label for="akta_no" class="col-sm-3 control-label">No. Akta<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="akta_no" name="akta_no">
                                        </div>
                                        <div class="colm-sm-6">
                                            <input type="text" id="akta_no_doc" class="hidden" name="akta_no_doc" value="<?php echo set_value('npwp_no_doc', $vendor_detail["NPWP_NO_DOC"]); ?>">
                                            <button type="button" required class="uploadAttachment akta_upload btn btn-default">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="akta_type" class="col-sm-3 control-label">Jenis Akta<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3 end">
                                            <label for="akta_type" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="akta_type" id="akta_type" required="">
                                                    <?php foreach ($akta_type as $key => $value) { ?>
                                                        <option value="<?php echo $value["AKTA_TYPE"]; ?>"><?php echo $value["AKTA_TYPE"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="date_creation" class="col-sm-3 control-label">Tanggal Akta<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" ) { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" name="date_creation" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="notaris_name" class="col-sm-3 control-label">Nama Notaris<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" ) { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control text-uppercase" id="notaris_name" name="notaris_name" value="<?php echo set_value('notaris_name'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="notaris_address" class="col-sm-3 control-label">Alamat Notaris<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-uppercase" id="notaris_address" name="notaris_address" value="<?php echo set_value('notaris_address'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pengesahan_hakim" class="col-sm-3 control-label">Pengesahan Kehakiman</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="pengesahan_hakim" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                        <div class="colm-sm-6">
                                            <input type="text" id="pengesahan_hakim_doc" class="hidden" name="pengesahan_hakim_doc" value="<?php echo set_value('npwp_no_doc', $vendor_detail["NPWP_NO_DOC"]); ?>">
                                            <button type="button" required class="uploadAttachment btn btn-default">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="berita_acara_ngr" class="col-sm-3 control-label">Berita Negara</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="berita_acara_ngr" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                        <div class="colm-sm-6">
                                            <input type="text" id="berita_acara_ngr_doc" class="hidden" name="berita_acara_ngr_doc" value="<?php echo set_value('npwp_no_doc', $vendor_detail["NPWP_NO_DOC"]); ?>">
                                            <button type="button" required class="uploadAttachment btn btn-default">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addAkta" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <table class="table table-hover margin-bottom-20 <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : '' ?>" id="vendor_akta">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">No. Akta</th>
                                        <th class="text-center">Jenis Akta</th>
                                        <th class="text-center">Tanggal Akta</th>
                                        <th class="text-center">Nama Notaris</th>
                                        <th class="text-center">Alamat Notaris</th>
                                        <th class="text-center">Pengesahan Kehakiman</th>
                                        <th class="text-center">Berita Negara</th>
                                        <th class="text-center" style="min-width: 86px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableItem">
                                    <?php if (empty($vendor_akta)) { ?>
                                    <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                    </tr>
                                    <?php
                                    }
                                    else {
                                        $no = 1;
                                        foreach ($vendor_akta as $key => $akta) { ?>
                                    <tr id="<?php echo $akta['AKTA_ID']; ?>">
                                        <td class="text-center"><?php echo $no++; ?></td>
                                        <td class="text-center"><?php if (!empty($akta['AKTA_NO_DOC'])){ ?><a target="_blank" href="<?php echo base_url('Vendor_regis_bypass') ?>/viewDok/<?php echo $akta['AKTA_NO_DOC']; ?>"><?php echo $akta['AKTA_NO']; ?></a><?php } else {echo $akta['AKTA_NO']; } ?></td>
                                        <td class="text-center"><?php echo $akta['AKTA_TYPE']; ?></td>
                                        <td class="text-center"><?php echo vendorfromdate($akta['DATE_CREATION']); ?></td>
                                        <td class="text-center"><?php echo $akta['NOTARIS_NAME']; ?></td>
                                        <td class="text-center"><?php echo $akta['NOTARIS_ADDRESS']; ?></td>
                                        <td class="text-center"><?php if (!empty($akta['PENGESAHAN_HAKIM_DOC'])){ ?><a target="_blank" href="<?php echo base_url('Vendor_regis_bypass') ?>/viewDok/<?php echo $akta['PENGESAHAN_HAKIM_DOC']; ?>"><?php echo vendorfromdate($akta['PENGESAHAN_HAKIM']); ?></a><?php } else {  echo vendorfromdate($akta['PENGESAHAN_HAKIM']); }?></td>
                                        <td class="text-center"><?php if (!empty($akta['BERITA_ACARA_NGR_DOC'])){ ?><a target="_blank" href="<?php echo base_url('Vendor_regis_bypass') ?>/viewDok/<?php echo $akta['BERITA_ACARA_NGR_DOC']; ?>"><?php echo vendorfromdate($akta['BERITA_ACARA_NGR']); ?></a><?php } else { echo vendorfromdate($akta['BERITA_ACARA_NGR']); }?></td>
                                        <td><button type="button" class="main_button small_btn update_legal_data"><i class="ico-edit no_margin_right"></i></button><button class="main_button small_btn delete_akta"><i class="ico-remove no_margin_right"></i></button>
                                        </td>
                                    </tr>
                                        <?php } } ?>
                                </tbody>
                            </table>

                            <?php echo form_open('Vendor_regis_bypass',array('class' => 'form-horizontal insert_bank_data', 'autocomplete'=>'off')); ?>
                            <?php $container = 'Rekening Bank' ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">Rekening Bank</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <?php if(isset($progress_status[$container]) && $progress_status[$container]['STATUS'] == 'Rejected'):?>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="alert alert-warning" role="alert"><strong>Keterangan Revisi! </strong><?php echo $progress_status[$container]['REASON']; ?></div> 
                                            </div>
                                        </div>
                                        <hr>
                                    <?php endif ?>
                                    <div class="form-group">
                                        <label for="account_no" class="col-sm-3 control-label">No. Rekening<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="account_no" name="account_no">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="account_name" class="col-sm-3 control-label">Pemegang Rekening<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control text-uppercase" id="account_name" name="account_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="bank_name" class="col-sm-3 control-label">Nama Bank<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control text-uppercase" id="bank_name" name="bank_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="bank_branch" class="col-sm-3 control-label">Cabang Bank<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control text-uppercase" id="bank_branch" name="bank_branch">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="swift_code" class="col-sm-3 control-label">Swift Code<?php if ($vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="swift_code" name="swift_code">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-3 control-label">Alamat Bank<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control text-uppercase" id="address" name="address">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="bank_postal_code" class="col-sm-3 control-label">Kode Pos Bank<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="bank_postal_code" name="bank_postal_code" maxlength="5">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="currency" class="col-sm-3 control-label">Mata Uang<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                            <?php
                                            echo form_dropdown('currency', $currency, '', 'id="currency" class="form-control"'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="reference" class="col-sm-3 control-label">Reference Bank</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="reference_bank" name="reference_bank">
                                        </div>

                                        <div class="colm-sm-5">
                                            <input type="text" id="filename" class="hidden" name="file_bank">
                                            <button type="button" required class="uploadAttachment btn btn-default file">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                                &nbsp;&nbsp;<a class="btn btn-default delete_upload_file_ba glyphicon glyphicon-trash"></a>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addBankData" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <table class="table table-hover margin-bottom-20 <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : '' ?>" id="vendor_bank">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">No. Rekening</th>
                                        <th class="text-center">Pemegang Rekening</th>
                                        <th class="text-center">Nama Bank</th>
                                        <th class="text-center">Cabang Bank</th>
                                        <th class="text-center">Swift Code</th>
                                        <th class="text-center">Alamat Bank</th>
                                        <th class="text-center">Kode Pos Bank</th>
                                        <th class="text-center">Mata Uang</th>
                                        <th class="text-center">Reference Bank</th>
                                        <th class="text-center" style="width: 86px">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="bankItem">
                                    <?php if (empty($vendor_bank)) { ?>
                                    <tr id="empty_row">
                                        <td colspan="11" class="text-center">- Belum ada data -</td>
                                    </tr>
                                    <?php
                                    }
                                    else {
                                        $no = 1;
                                        foreach ($vendor_bank as $key => $bank) { ?>
                                    <tr id="<?php echo $bank['BANK_ID']; ?>">
                                        <td class="text-center"><?php echo $no++; ?></td>
                                        <td class="text-center"><?php echo $bank['ACCOUNT_NO']; ?></td>
                                        <td class="text-center"><?php echo $bank['ACCOUNT_NAME']; ?></td>
                                        <td class="text-center"><?php echo $bank['BANK_NAME']; ?></td>
                                        <td class="text-center"><?php echo $bank['BANK_BRANCH']; ?></td>
                                        <td class="text-center"><?php echo $bank['SWIFT_CODE']; ?></td>
                                        <td class="text-center"><?php echo $bank['ADDRESS']; ?></td>
                                        <td class="text-center"><?php echo $bank['BANK_POSTAL_CODE']; ?></td>
                                        <td class="text-center"><?php echo $bank['CURRENCY']; ?></td>
                                        <td class="text-center"><?php if (!empty($bank['REFERENCE_FILE'])){ ?> <a href="<?php echo base_url('Vendor_regis_bypass'); ?>/viewDok/<?php echo $bank['REFERENCE_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $bank['REFERENCE_BANK']; ?></a> <?php } else {  echo $bank['REFERENCE_BANK']; } ?></td>
                                        <td><button type="button" class="main_button small_btn update_bank_data"><i class="ico-edit no_margin_right"></i></button><button class="main_button small_btn delete_bank"><i class="ico-remove no_margin_right"></i></button></td>
                                    </tr>
                                        <?php }
                                    ?>

                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php echo form_open('Vendor_regis_bypass/do_update_legal_data',array('class' => 'form-horizontal legal_form legal_form_all domisili')); ?>
                            <?php $container = 'Domisili Perusahaan'; ?>
                            <div class="panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'hidden') ?>">
                                <div class="panel-heading" role="button" data-toggle="collapse" href="#domisili_perusahaan" aria-expanded="false" aria-controls="domisili_perusahaan">
                                    Domisili Perusahaan
                                </div>
                                <div class="panel-body collapse" id="domisili_perusahaan">
                                    <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                    <div class="form-group">
                                        <?php if(isset($progress_status[$container]) && $progress_status[$container]['STATUS'] == 'Rejected'):?>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="alert alert-warning" role="alert"><strong>Keterangan Revisi! </strong><?php echo $progress_status[$container]['REASON']; ?></div> 
                                                </div>
                                            </div>
                                            <hr>
                                        <?php endif ?>
                                        <label for="address_domisili_no" class="col-sm-3 control-label">Nomor Domisili<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="address_domisili_no" name="address_domisili_no" value="<?php echo set_value('address_domisili_no', $vendor_detail["ADDRESS_DOMISILI_NO"]); ?>">
                                        </div>
                                        <div class="colm-sm-6">
                                            <input type="text" id="domisili_no_doc" class="namafile hidden" name="domisili_no_doc" value="<?php echo set_value('domisili_no_doc', $vendor_detail["DOMISILI_NO_DOC"]); ?>">
                                            <?php
                                            if (!empty($vendor_detail["DOMISILI_NO_DOC"])) { ?>
                                                <span class="messageUpload"><a style="color: #666; text-decoration: underline" href="<?php echo base_url('Vendor_regis_bypass')."/viewDok/".$vendor_detail["DOMISILI_NO_DOC"]; ?>" title="File Attachment" target="_blank">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_doc">Delete</a></span>&nbsp;&nbsp;

                                            <?php
                                            }
                                            else { ?>
                                                <span class="messageUpload" style="display:none"></span>
                                            <?php }
                                            ?>
                                            <input type="text" class="hidden" id="attachment_1" name="attachment_1" value="">
                                            <?php if (!empty($vendor_detail["DOMISILI_NO_DOC"])) { ?>
                                                <button type="button" required class="uploadAttachment btn btn-default" data-uploaded="true">Change File (2MB Max)</button>
                                            <?php
                                            }
                                            else { ?>
                                                <button type="button" required class="uploadAttachment btn btn-default">Upload File (2MB Max)</button>
                                            <?php }
                                            ?>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_domisili_date" class="col-sm-3 control-label">Mulai Berlaku<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL" ) { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" name="address_domisili_date" id="address_domisili_date" class="form-control" value="<?php echo set_value('address_domisili_date', vendorfromdate($vendor_detail["ADDRESS_DOMISILI_DATE"])); ?>" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_domisili_exp_date" class="col-sm-3 control-label">Berlaku Sampai<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL" ) { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" name="address_domisili_exp_date" class="form-control" value="<?php echo set_value('address_domisili_exp_date', vendorfromdate($vendor_detail["ADDRESS_DOMISILI_EXP_DATE"])); ?>" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_street" class="col-sm-3 control-label">Alamat Perusahaan<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL" ) { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-uppercase" id="address_street" name="address_street" value="<?php echo set_value('address_street', $vendor_detail["ADDRESS_STREET"]); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="city" class="col-sm-3 control-label">Negara<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL" ) { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <select name="address_country" class="form-control" id="address_country" name="country">
                                                <option value=""></option>
                                                <?php foreach ($country as $key => $value): ?>
                                                    <?php if ($key != '" disabled=""disabled" selected="selected'): ?>
                                                        <?php if ($vendor_detail['ADDRESS_COUNTRY'] == $key): ?>
                                                            <option value="<?php echo $key ?>" selected><?php echo $value ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                                        <?php endif ?>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="addres_prop" class="col-sm-3 control-label">Provinsi<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                        <?php if($vendor_detail['ADDRESS_COUNTRY'] == "ID"): ?>
                                            <?php echo form_dropdown('addres_prop', $province, $vendor_detail["ADDRES_PROP"], 'class="form-control" id="address_prop"')?>
                                        <?php else: ?>
                                            <?php echo form_dropdown('addres_prop', $province,'', 'class="form-control" id="address_prop" disabled')?>
                                        <?php endif ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_city" class="col-sm-3 control-label">Kota<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            
                                            <?php if($vendor_detail['ADDRESS_COUNTRY'] == "ID"): ?>
                                                <?php echo form_dropdown('city_select',  $city_list, $vendor_detail["ADDRESS_CITY"], 'class="form-control" id="city_select" required')?>
                                                <input type="text" class="form-control hidden" id="address_city" name="address_city" value="">
                                            <?php else: ?>
                                                <?php echo form_dropdown('city_select',  $city_list,'', 'class="form-control hidden" id="city_select"' )?>
                                                <input type="text" class="form-control" id="address_city" name="address_city" value="<?php echo set_value('address_city', $vendor_detail["ADDRESS_CITY"]); ?>"  required>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="address_postcode" class="col-sm-3 control-label">Kode Pos<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="address_postcode" name="address_postcode" maxlength="5" value="<?php echo set_value('address_postcode', $vendor_detail["ADDRESS_POSTCODE"]); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_regis_bypass/do_update_legal_data',array('class' => 'form-horizontal legal_form legal_form_all npwp')); ?>
                            <?php $container = 'NPWP'; ?>
                            <div class="panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'hidden') ?>">
                                <div class="panel-heading" role="button" data-toggle="collapse" href="#npwp" aria-expanded="false" aria-controls="npwp">
                                    NPWP
                                </div>
                                <div class="panel-body collapse" id="npwp">
                                    <?php if(isset($progress_status[$container]) && $progress_status[$container]['STATUS'] == 'Rejected'):?>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="alert alert-warning" role="alert"><strong>Keterangan Revisi! </strong><?php echo $progress_status[$container]['REASON']; ?></div> 
                                            </div>
                                        </div>
                                        <hr>
                                    <?php endif ?>
                                    <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                    <div class="form-group">
                                        <label for="npwp_no" class="col-sm-3 control-label">No.<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "PERORANGAN") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control npwp_no" id="npwp_no" name="npwp_no" value="<?php echo set_value('npwp_no', $vendor_detail["NPWP_NO"]); ?>">
                                        </div>
                                        <div class="colm-sm-6">
                                            <input type="text" id="npwp_no_doc" class="namafile hidden" name="npwp_no_doc" value="<?php echo set_value('npwp_no_doc', $vendor_detail["NPWP_NO_DOC"]); ?>">
                                            <?php
                                            if (!empty($vendor_detail["NPWP_NO_DOC"])) { ?>
                                                <span class="messageUpload"><a style="color: #666; text-decoration: underline" href="<?php echo base_url('Vendor_regis_bypass')."/viewDok/".$vendor_detail["NPWP_NO_DOC"]; ?>" title="File Attachment" target="_blank">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_doc">Delete</a></span>&nbsp;&nbsp;
                                            <?php
                                            }
                                            else { ?>
                                                <span class="messageUpload" style="display:none"></span>&nbsp;&nbsp;
                                            <?php }
                                            ?>
                                            <input type="text" class="hidden" id="attachment_1" name="attachment_1" value="">
                                            <?php if (!empty($vendor_detail["NPWP_NO_DOC"])) { ?>
                                                <button type="button" required class="uploadAttachment btn btn-default" data-uploaded="true">Change File (2MB Max)</button>
                                            <?php
                                            }
                                            else { ?>
                                                <button type="button" required class="uploadAttachment btn btn-default">Upload File (2MB Max)</button>
                                            <?php }
                                            ?>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_address" class="col-sm-3 control-label">Alamat (Sesuai NPWP)<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "PERORANGAN" ) { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-uppercase" id="npwp_address" name="npwp_address" value="<?php echo set_value('npwp_address', $vendor_detail["NPWP_ADDRESS"]); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_prop" class="col-sm-3 control-label">Propinsi<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "PERORANGAN") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <?php echo form_dropdown('npwp_prop', $province, $vendor_detail["NPWP_PROP"], 'class="form-control" id="npwp_prop"')?>
                                            <!-- <input type="text" class="form-control" id="npwp_prop" name="npwp_prop" value="<?php //echo set_value('npwp_prop', $vendor_detail["NPWP_PROP"]); ?>"> -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_city" class="col-sm-3 control-label">Kota<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "PERORANGAN") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <?php  echo form_dropdown('npwp_city', $city_list_npwp, $vendor_detail["NPWP_CITY"], 'id="npwp_city" class="form-control city_select"');?>
                                            <!-- <input type="text" class="form-control" id="npwp_city" name="npwp_city" value="<?php //echo set_value('npwp_city', $vendor_detail["NPWP_CITY"]); ?>"> -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_postcode" class="col-sm-3 control-label">Kode Pos<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "PERORANGAN" ) { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="npwp_postcode" name="npwp_postcode" maxlength="5" value="<?php echo set_value('npwp_postcode', $vendor_detail["NPWP_POSTCODE"]); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_regis_bypass/do_update_legal_data',array('class' => 'form-horizontal legal_form_pkp legal_form_all')); ?>
                            <?php $container = 'PKP'; ?>
                            <div class="panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'hidden') ?>">
                                <div class="panel-heading" role="button" data-toggle="collapse" href="#pkp" aria-expanded="false" aria-controls="pkp">
                                    PKP
                                </div>
                                <div class="panel-body collapse" id="pkp">
                                    <div class="form-group">
                                        <?php if(isset($progress_status[$container]) && $progress_status[$container]['STATUS'] == 'Rejected'):?>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="alert alert-warning" role="alert"><strong>Keterangan Revisi! </strong><?php echo $progress_status[$container]['REASON']; ?></div> 
                                            </div>
                                        </div>
                                        <hr>
                                        <?php endif ?>
                                        <label for="city" class="col-sm-3 control-label">PKP<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "PERORANGAN") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <label for="npwp_pkp" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="npwp_pkp" id="npwp_pkp" required="">
                                                    <option>- Pilih PKP -</option>
                                                    <option value="Bukan PKP" <?php echo "Bukan PKP"==$vendor_detail["NPWP_PKP"] ? 'selected="selected"' : '';?>>Bukan PKP</option>
                                                    <option value="PKP" <?php echo "PKP"==$vendor_detail["NPWP_PKP"] ? 'selected="selected"' : '';?>>Ya</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_pkp_no" class="col-sm-3 control-label">Nomor PKP<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "PERORANGAN") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="npwp_pkp_no" name="npwp_pkp_no" value="<?php echo set_value('npwp_pkp_no', $vendor_detail["NPWP_PKP_NO"]); ?>">
                                        </div>
                                        <div class="colm-sm-6">
                                            <input type="text" id="pkp_no_doc" class="namafile hidden" name="pkp_no_doc" value="<?php echo set_value('pkp_no_doc', $vendor_detail["PKP_NO_DOC"]); ?>">
                                            <?php
                                            if (!empty($vendor_detail["PKP_NO_DOC"])) { ?>
                                                <span class="messageUpload"><a style="color: #666; text-decoration: underline" href="<?php echo base_url('Vendor_regis_bypass')."/viewDok/".$vendor_detail["PKP_NO_DOC"]; ?>" title="File Attachment" target="_blank">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_doc">Delete</a></span>&nbsp;&nbsp;
                                            <?php
                                            }
                                            else { ?>
                                                <span class="messageUpload" style="display:none"></span>&nbsp;&nbsp;
                                            <?php }
                                            ?>
                                            <input type="text" class="hidden" id="attachment_1" name="attachment_1" value="">
                                            <?php if (!empty($vendor_detail["PKP_NO_DOC"])) { ?>
                                                <button type="button" required class="uploadAttachment btn btn-default" data-uploaded="true">Change File (2MB Max)</button>
                                            <?php
                                            }
                                            else { ?>
                                                <button type="button" required class="uploadAttachment btn btn-default">Upload File (2MB Max)</button>
                                            <?php }
                                            ?>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>

                            <?php echo form_open('Vendor_regis_bypass/do_update_legal_data',array('class' => 'form-horizontal legal_form legal_form_all siup')); ?>
                            <?php $container = 'SIUP'; ?>
                            <div class="panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'hidden') ?>">
                                <div class="panel-heading" role="button" data-toggle="collapse" href="#siup" aria-expanded="false" aria-controls="siup">
                                    SIUP
                                </div>
                                <div class="panel-body collapse" id="siup">
                                    <?php if(isset($progress_status[$container]) && $progress_status[$container]['STATUS'] == 'Rejected'):?>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="alert alert-warning" role="alert"><strong>Keterangan Revisi! </strong><?php echo $progress_status[$container]['REASON']; ?></div> 
                                            </div>
                                        </div>
                                        <hr>
                                    <?php endif ?>
                                    <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                    <div class="form-group">
                                        <label for="siup_issued_by" class="col-sm-3 control-label">Dikeluarkan Oleh<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control text-uppercase" id="siup_issued_by" name="siup_issued_by" value="<?php echo set_value('siup_issued_by', $vendor_detail["SIUP_ISSUED_BY"]); ?>">
                                        </div>
                                        <div class="colm-sm-6">
                                            <input type="text" id="siup_no_doc" class="namafile hidden" name="siup_no_doc" value="<?php echo set_value('siup_no_doc', $vendor_detail["SIUP_NO_DOC"]); ?>">
                                            <?php
                                            if (!empty($vendor_detail["SIUP_NO_DOC"])) { ?>
                                                <span class="messageUpload"><a style="color: #666; text-decoration: underline" href="<?php echo base_url('Vendor_regis_bypass')."/viewDok/".$vendor_detail["SIUP_NO_DOC"]; ?>" title="File Attachment" target="_blank">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_doc">Delete</a></span>&nbsp;&nbsp;
                                            <?php
                                            }
                                            else { ?>
                                                <span class="messageUpload" style="display:none"></span>&nbsp;&nbsp;
                                            <?php }
                                            ?>
                                            <input type="text" class="hidden" id="attachment_1" name="attachment_1" value="">
                                            <?php if (!empty($vendor_detail["SIUP_NO_DOC"])) { ?>
                                                <button type="button" required class="uploadAttachment btn btn-default" data-uploaded="true">Change File (2MB Max)</button>
                                            <?php
                                            }
                                            else { ?>
                                                <button type="button" required class="uploadAttachment btn btn-default">Upload File (2MB Max)</button>
                                            <?php }
                                            ?>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="siup_no" class="col-sm-3 control-label">Nomor<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="siup_no" name="siup_no" value="<?php echo set_value('siup_no', $vendor_detail["SIUP_NO"]); ?>">
                                        </div>
                                        <label for="postcode" class="col-sm-2 control-label">SIUP<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <label for="siup_type" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="siup_type" id="siup_type" required="">
                                                    <option value="SIUP Kecil" <?php echo "SIUP Kecil"==$vendor_detail["SIUP_TYPE"] ? 'selected="selected"' : '';?>>SIUP Kecil</option>
                                                    <option value="SIUP Menengah" <?php echo "SIUP Menengah"==$vendor_detail["SIUP_TYPE"] ? 'selected="selected"' : '';?>>SIUP Menengah</option>
                                                    <option value="SIUP Besar" <?php echo "SIUP Besar"==$vendor_detail["SIUP_TYPE"] ? 'selected="selected"' : '';?>>SIUP Besar</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="siup_from" class="col-sm-3 control-label">Berlaku Mulai<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="siup_from" class="form-control" value="<?php echo set_value('siup_from', vendorfromdate($vendor_detail["SIUP_FROM"])); ?>" value="<?php echo set_value('siup_from', $vendor_detail["SIUP_FROM"]); ?>" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                        <label for="siup_to" class="col-sm-3 control-label">Sampai<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="siup_to" class="form-control" value="<?php echo set_value('siup_to', vendorfromdate($vendor_detail["SIUP_TO"])); ?>" value="<?php echo set_value('siup_to', $vendor_detail["SIUP_TO"]); ?>" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_regis_bypass/do_update_legal_data',array('class' => 'form-horizontal legal_form legal_form_all tdp')); ?>
                            <?php $container = 'TDP'; ?>
                            <div class="panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'hidden') ?>">
                                <div class="panel-heading" role="button" data-toggle="collapse" href="#tdp" aria-expanded="false" aria-controls="tdp">
                                    TDP
                                </div>
                                <div class="panel-body collapse" id="tdp">
                                    <?php if(isset($progress_status[$container]) && $progress_status[$container]['STATUS'] == 'Rejected'):?>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="alert alert-warning" role="alert"><strong>Keterangan Revisi! </strong><?php echo $progress_status[$container]['REASON']; ?></div> 
                                            </div>
                                        </div>
                                        <hr>
                                    <?php endif ?>
                                    <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                    <div class="form-group">
                                        <label for="tdp_issued_by" class="col-sm-3 control-label">Dikeluarkan Oleh<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control text-uppercase" id="tdp_issued_by" name="tdp_issued_by" value="<?php echo set_value('tdp_issued_by', $vendor_detail["TDP_ISSUED_BY"]); ?>">
                                        </div>
                                        <div class="colm-sm-6">
                                            <input type="text" id="tdp_no_doc" class="namafile hidden" name="tdp_no_doc" value="<?php echo set_value('tdp_no_doc', $vendor_detail["TDP_NO_DOC"]); ?>">
                                            <?php
                                            if (!empty($vendor_detail["TDP_NO_DOC"])) { ?>
                                                <span class="messageUpload"><a style="color: #666; text-decoration: underline" href="<?php echo base_url('Vendor_regis_bypass')."/viewDok/".$vendor_detail["TDP_NO_DOC"]; ?>" title="File Attachment" target="_blank">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_doc">Delete</a></span>&nbsp;&nbsp;
                                            <?php
                                            }
                                            else { ?>
                                                <span class="messageUpload" style="display:none"></span>&nbsp;&nbsp;
                                            <?php }
                                            ?>
                                            <input type="text" class="hidden" id="attachment_1" name="attachment_1" value="">
                                            <?php if (!empty($vendor_detail["TDP_NO_DOC"])) { ?>
                                                <button type="button" required class="uploadAttachment btn btn-default" data-uploaded="true">Change File (2MB Max)</button>
                                            <?php
                                            }
                                            else { ?>
                                                <button type="button" required class="uploadAttachment btn btn-default">Upload File (2MB Max)</button>
                                            <?php }
                                            ?>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tdp_no" class="col-sm-3 control-label">Nomor<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="tdp_no" name="tdp_no" value="<?php echo set_value('tdp_no', $vendor_detail["TDP_NO"]); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tdp_from" class="col-sm-3 control-label">Berlaku Mulai<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="tdp_from" class="form-control" value="<?php echo set_value('tdp_from', vendorfromdate($vendor_detail["TDP_FROM"])); ?>" value="<?php echo set_value('tdp_from', $vendor_detail["TDP_FROM"]); ?>" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                </div>
                                        </div>
                                        <label for="tdp_to" class="col-sm-3 control-label">Sampai<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="tdp_to" class="form-control" value="<?php echo set_value('tdp_to', vendorfromdate($vendor_detail["TDP_TO"])); ?>" value="<?php echo set_value('tdp_to', $vendor_detail["TDP_TO"]); ?>" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>         
                                <div class="panel panel-default">
                                    <div class="panel-body text-center"> 
                                        <button id="save_legal" class="main_button color2" type="button">Save</button>
                                         <?php 

                                        $legal = $vendor_detail['ADDRESS_DOMISILI_NO'];

                                        if (!empty($vendor_akta) && !empty($legal) && !empty($vendor_bank)) { ?>
                                            <a href="#finish-popup" class="main_button color6 popup-with-move-anim" type="button">Send & Finish</a>
                                        <?php }?>
                                    </div>
                                </div>                            
                        </div>
                    </div>
				</div>
			</div>
		</section>
        <section class="content_section">
            <input type="text" class="hidden" id="vendor_type" name="vendor_type" value="<?php echo set_value('vendor_type', $vendor_detail["VENDOR_TYPE"]); ?>">
            <div class="modal fade" id="updateLegalDataModal" tabindex="-1" role="dialog" aria-labelledby="updateLegalData">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Akta Perusahaan Vendor</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Vendor_update_profile/do_insert_akta_pendirian',array('class' => 'form-horizontal current_edited_akta')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Akta Pendirian">
                                <input type="text" class="hidden" name="akta_id" id="akta_id">
                                <div class="form-group">
                                    <label for="akta_no" class="col-sm-3 control-label">
                                        No. Akta
                                        <?php if($vendor_detail["VENDOR_TYPE"] == "NASIONAL"): ?>
                                            <span style="color: #E74C3C">*</span>
                                        <?php elseif($vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL"):?>
                                            
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "EXPEDITURE"):?>
                                            <span style="color: #E74C3C">*</span>
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "PERORANGAN"):?>
                                            
                                        <?php endif ?>
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-uppercase" id="akta_no" name="akta_no">
                                    </div>
                                        <input type="hidden" name="file_akta_lama" id="file_akta_upload">
                                    <div class="col-sm-6">
                                        <input type="hidden" id="akta_no_doc_edit" class="file_akta" name="file_upload">
                                        <button type="button" id="akta_edit1" required class="uploadAttachment u_akta btn btn-default">Upload File (2MB Max)</button><span class="filenamespan f_akta"></span>&nbsp;&nbsp;
                                        <a id="e_del_akta" class="btn btn-default delete_file_akta_edit glyphicon glyphicon-trash"></a>
                                        <div class="progress progress-striped p_akta active" style="margin: 10px 0px 0px; display: none;">
                                            <div class="progress-bar b_akta progress-bar-success"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="akta_type" class="col-sm-3 control-label">Jenis Akta
                                        <?php if($vendor_detail["VENDOR_TYPE"] == "NASIONAL"): ?>
                                            <span style="color: #E74C3C">*</span>
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL"):?>
                                            
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "EXPEDITURE"):?>
                                            <span style="color: #E74C3C">*</span>
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
                                            
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "EXPEDITURE"):?>
                                            <span style="color: #E74C3C">*</span>
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
                                            
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "EXPEDITURE"):?>
                                            <span style="color: #E74C3C">*</span>
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
                                            
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "EXPEDITURE"):?>
                                            <span style="color: #E74C3C">*</span>
                                        <?php elseif ($vendor_detail["VENDOR_TYPE"] == "PERORANGAN"):?>
                                            
                                        <?php endif ?>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="notaris_address" name="notaris_address" value="<?php echo set_value('notaris_address'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Pengesahan Kehakiman</label>
                                    <div class="col-sm-3">
                                        <div class="input-group date">
                                            <input type="text" id="pengesahan_hakim_edit" name="pengesahan_hakim_edit" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                        <input type="hidden" name="file_hakim_lama" id="file_hakim_upload">
                                    <div class="col-sm-6">
                                        <input type="hidden" id="pengesahan_hakim_doc_edit" class="file_hakim" name="file_upload">
                                        <button type="button" id="akta_edit2" required class="uploadAttachment u_hakim btn btn-default">Upload File (2MB Max)</button><span class="filenamespan f_hakim"></span>
                                        <a id="e_del_hakim" class="btn btn-default delete_file_akta_edit glyphicon glyphicon-trash"></a>
                                        <div class="progress progress-striped p_kehakiman active" style="margin: 10px 0px 0px; display: none;">
                                            <div class="progress-bar b_kehakiman progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Berita Negara</label>
                                    <div class="col-sm-3">
                                        <div class="input-group date">
                                            <input type="text" id="berita_acara_ngr_edit" name="berita_acara_ngr_edit" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                        <input type="hidden" name="file_negara_lama" id="file_negara_upload">
                                    <div class="col-sm-6">
                                        <input type="hidden" id="berita_acara_ngr_doc_edit" class="file_negara" name="file_upload">
                                        <button type="button" id="akta_edit3" required class="uploadAttachment u_negara btn btn-default">Upload File (2MB Max)</button><span class="filenamespan f_negara"></span>
                                        <a id="e_del_negara" class="btn btn-default delete_file_akta_edit glyphicon glyphicon-trash"></a>
                                        <div class="progress progress-striped p_berita_negara active" style="margin: 10px 0px 0px; display: none;">
                                            <div class="progress-bar b_berita_negara progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
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
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Data Legal</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open('Vendor_update_profile/do_insert_akta_pendirian',array('class' => 'form-horizontal insert_akta', 'autocomplete'=>'off')); ?>
                            <?php $container = 'Akta Pendirian';?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">Akta Perusahaan</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Akta Pendirian">
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
                                        <label for="akta_no" class="col-sm-3 control-label">No. Akta<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="akta_no" name="akta_no">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="hidden" id="akta_no_doc" name="file_upload">
                                            <button type="button" id="akta1" required class="uploadAttachment akta_upload btn btn-default">Upload File (2MB Max)</button><span class="filenamespan akta"></span>
                                                &nbsp;&nbsp;<a id="del_akta" class="btn btn-default delete_upload_file glyphicon glyphicon-trash"></a>
                                            <div class="progress progress-striped akta active" style="margin: 10px 0px 0px; display:none;">
                                                <div class="progress-bar akta progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="akta_type" class="col-sm-3 control-label">Jenis Akta<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
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
                                        <label for="date_creation" class="col-sm-3 control-label">Tanggal Akta<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" name="date_creation" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="notaris_name" class="col-sm-3 control-label">Nama Notaris<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control text-uppercase" id="notaris_name" name="notaris_name" value="<?php echo set_value('notaris_name'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="notaris_address" class="col-sm-3 control-label">Alamat Notaris<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
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
                                        <div class="col-sm-6">
                                            <input type="hidden" id="pengesahan_hakim_doc" name="file_upload" >
                                            <button type="button" id="akta2" required class="uploadAttachment hakim btn btn-default">Upload File (2MB Max)</button><span class="filenamespan hakim"></span>
                                                &nbsp;&nbsp;<a id="del_hakim" class="btn btn-default delete_upload_file glyphicon glyphicon-trash"></a>
                                            <div class="progress progress-striped kehakiman active" style="margin: 10px 0px 0px; display:none;">
                                                <div class="progress-bar kehakiman progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
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
                                        <div class="col-sm-6">
                                            <input type="hidden" id="berita_acara_ngr_doc" name="file_upload" >
                                            <button type="button" id="akta3" required class="uploadAttachment negara btn btn-default">Upload File (2MB Max)</button><span class="filenamespan negara"></span>
                                                &nbsp;&nbsp;<a id="del_negara" class="btn btn-default delete_upload_file glyphicon glyphicon-trash"></a>
                                            <div class="progress progress-striped berita_negara active" style="margin: 10px 0px 0px; display:none;">
                                                <div class="progress-bar berita_negara progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button id="addAkta" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="panel panel-default">
                                <div class="table-responsive">
                                    <table class="table table-hover margin-bottom-20 <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'panel-success') ?>" id="vendor_akta">
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
                                                <th class="text-center hidden"></th>
                                                <th class="text-center hidden"></th>
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
                                                <td><?php if (!empty($akta['AKTA_NO_DOC'])){ ?><a target="_blank" href="<?php echo base_url('Vendor_update_profile') ?>/viewDok/<?php echo $akta['AKTA_NO_DOC']; ?>"><?php echo $akta['AKTA_NO']; ?></a><?php } else {echo $akta['AKTA_NO']; } ?></td>
                                                <td><?php echo $akta['AKTA_TYPE']; ?></td>
                                                <td class="text-center ak_date"><?php echo vendorfromdate($akta['DATE_CREATION']); ?></td>
                                                <td><?php echo $akta['NOTARIS_NAME']; ?></td>
                                                <td><?php echo $akta['NOTARIS_ADDRESS']; ?></td>
                                                <td class="text-center">
                                                    <?php if (!empty($akta['PENGESAHAN_HAKIM_DOC'])){ ?><a target="_blank" href="<?php echo base_url('Vendor_update_profile') ?>/viewDok/<?php echo $akta['PENGESAHAN_HAKIM_DOC']; ?>"><?php echo vendorfromdate($akta['PENGESAHAN_HAKIM']); ?></a><?php } else {  echo vendorfromdate($akta['PENGESAHAN_HAKIM']); }?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (!empty($akta['BERITA_ACARA_NGR_DOC'])){ ?><a target="_blank" href="<?php echo base_url('Vendor_update_profile') ?>/viewDok/<?php echo $akta['BERITA_ACARA_NGR_DOC']; ?>"><?php echo vendorfromdate($akta['BERITA_ACARA_NGR']); ?></a><?php } else { echo vendorfromdate($akta['BERITA_ACARA_NGR']); }?>
                                                </td>
                                                <td><button type="button" class="main_button small_btn update_legal_data"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_legal_akta/'.$akta['AKTA_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                                <td class="hk_date hidden" type="hidden"><?php echo vendorfromdate($akta['PENGESAHAN_HAKIM']); ?></td>
                                                <td class="ngr_date hidden" type="hidden"><?php echo vendorfromdate($akta['BERITA_ACARA_NGR']); ?></td>
                                            </tr>
                                                <?php }
                                            ?>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php echo form_open('Vendor_update_profile/do_update_legal_data',array('class' => 'form-horizontal legal_form_all legal_form domisili')); ?>
                            <?php $container = 'Domisili Perusahaan'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
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
                                        <label for="address_domisili_no" class="col-sm-3 control-label">Nomor Domisili<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="address_domisili_no" name="address_domisili_no" value="<?php echo set_value('address_domisili_no', $vendor_detail["ADDRESS_DOMISILI_NO"]); ?>">
                                            <span id="dom1"></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="domisili_no_doc" class="namafile hidden" name="domisili_no_doc" value="<?php echo set_value('domisili_no_doc', $vendor_detail["DOMISILI_NO_DOC"]); ?>">
                                            <?php
                                            if (!empty($vendor_detail["DOMISILI_NO_DOC"])) { ?>
                                                <span class="messageUpload"><a style="color: #666; text-decoration: underline" href="<?php echo base_url('Vendor_update_profile')."/viewDok/".$vendor_detail["DOMISILI_NO_DOC"]; ?>" title="File Attachment" target="_blank">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_doc glyphicon glyphicon-trash"></a></span>&nbsp;&nbsp;

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
                                                <button type="button" id="domisil" required class="uploadAttachment btn btn-default">Upload File (2MB Max)</button>
                                            <?php }
                                            ?>
                                            <div class="progress progress-striped dmsl active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar dmsl progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_domisili_date" class="col-sm-3 control-label">Mulai Berlaku<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" name="address_domisili_date" id="address_domisili_date" class="form-control" value="<?php echo set_value('address_domisili_date', vendorfromdate($vendor_detail["ADDRESS_DOMISILI_DATE"])); ?>" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                <span id="dom2"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_domisili_exp_date" class="col-sm-3 control-label">Berlaku Sampai<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" name="address_domisili_exp_date" class="form-control" value="<?php echo set_value('address_domisili_exp_date', vendorfromdate($vendor_detail["ADDRESS_DOMISILI_EXP_DATE"])); ?>" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                <span id="dom3"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_street" class="col-sm-3 control-label">Alamat Perusahaan<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-uppercase" id="address_street" name="address_street" value="<?php echo set_value('address_street', $vendor_detail["ADDRESS_STREET"]); ?>">
                                            <span id="dom4"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="city" class="col-sm-3 control-label">Negara<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-4">
                                            <select name="address_country" class="form-control select2" id="address_country" name="country" style="width : 300px">
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
                                            <span id="dom5"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="addres_prop" class="col-sm-3 control-label">Provinsi<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                        <?php if($vendor_detail['ADDRESS_COUNTRY'] == "ID"): ?>
                                            <?php echo form_dropdown('addres_prop', $province, $vendor_detail["ADDRES_PROP"], 'class="form-control select2" id="address_prop" style="width : 300px"')?>
                                        <?php else: ?>
                                            <?php echo form_dropdown('addres_prop', $province,'', 'class="form-control select2" id="address_prop" style="width : 300px" disabled')?>
                                        <?php endif ?>
                                        <span id="dom6"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_city" class="col-sm-3 control-label">Kota<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            
                                            <?php if($vendor_detail['ADDRESS_COUNTRY'] == "ID"): ?>
                                                <?php echo form_dropdown('city_select',  $city_list, $vendor_detail["ADDRESS_CITY"], 'class="form-control select2" style="width : 300px" id="city_select" required')?>
                                                <input type="text" class="form-control hidden" id="address_city" name="address_city" value="">
                                            <?php else: ?>
                                                <?php echo form_dropdown('city_select',  $city_list,'', 'class="form-control select2 hidden" style="width : 300px" id="city_select"' )?>
                                                <input type="text" class="form-control" id="address_city" name="address_city" value="<?php echo set_value('address_city', $vendor_detail["ADDRESS_CITY"]); ?>"  required>
                                            <?php endif ?>
                                            <span id="dom7"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="address_postcode" class="col-sm-3 control-label">Kode Pos<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="address_postcode" name="address_postcode" maxlength="5" value="<?php echo set_value('address_postcode', $vendor_detail["ADDRESS_POSTCODE"]); ?>">
                                            <span id="dompos"></span>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button class="main_button color1 small_btn save_panel" value="Domisili Perusahaan" type="button">Save</button>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_update_legal_data',array('class' => 'form-horizontal legal_form_all legal_form npwp')); ?>
                            <?php $container = 'NPWP'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
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
                                        <label for="npwp_no" class="col-sm-3 control-label">No.<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "PERORANGAN" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control npwp_no" id="npwp_no" name="npwp_no" value="<?php echo set_value('npwp_no', $vendor_detail["NPWP_NO"]); ?>">
                                            <span id="npwp1"></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="npwp_no_doc" class="namafile hidden" name="npwp_no_doc" value="<?php echo set_value('npwp_no_doc', $vendor_detail["NPWP_NO_DOC"]); ?>">
                                            <?php
                                            if (!empty($vendor_detail["NPWP_NO_DOC"])) { ?>
                                                <span class="messageUpload"><a style="color: #666; text-decoration: underline" href="<?php echo base_url('Vendor_update_profile')."/viewDok/".$vendor_detail["NPWP_NO_DOC"]; ?>" title="File Attachment" target="_blank">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_doc glyphicon glyphicon-trash"></a></span>&nbsp;&nbsp;
                                            <?php
                                            }
                                            else { ?>
                                                <span class="messageUpload" style="display:none"></span>&nbsp;&nbsp;
                                            <?php }
                                            ?>
                                            <input type="text" class="hidden" id="attachment_1" name="attachment_1" value="">
                                            <?php if (!empty($vendor_detail["NPWP_NO_DOC"])) { ?>
                                                <button type="button" id="npwp_up" required class="uploadAttachment btn btn-default" data-uploaded="true">Change File (2MB Max)</button>
                                            <?php
                                            }
                                            else { ?>
                                                <button type="button" id="npwp_up" required class="uploadAttachment btn btn-default">Upload File (2MB Max)</button>
                                            <?php }
                                            ?>
                                            <div class="progress progress-striped npwp_prog active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar npwp_prog progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_address" class="col-sm-3 control-label">Alamat (Sesuai NPWP)<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "PERORANGAN" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-uppercase" id="npwp_address" name="npwp_address" value="<?php echo set_value('npwp_address', $vendor_detail["NPWP_ADDRESS"]); ?>">
                                            <span id="npwp2"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_prop" class="col-sm-3 control-label">Propinsi<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "PERORANGAN" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <?php echo form_dropdown('npwp_prop', $province, $vendor_detail["NPWP_PROP"], 'class="form-control select2" style="width : 300px" id="npwp_prop"')?>
                                            <span id="npwp3"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_city" class="col-sm-3 control-label">Kota<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "PERORANGAN" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <?php  echo form_dropdown('npwp_city', $city_list_npwp, $vendor_detail["NPWP_CITY"], 'id="npwp_city" class="form-control city_select select2" style="width : 300px"');?>
                                            <span id="npwp4"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_postcode" class="col-sm-3 control-label">Kode Pos<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "PERORANGAN" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="npwp_postcode" name="npwp_postcode" maxlength="5" value="<?php echo set_value('npwp_postcode', $vendor_detail["NPWP_POSTCODE"]); ?>">
                                            <span id="npwp5"></span>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button class="main_button color1 small_btn save_panel" value="NPWP" type="button">Save</button>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_update_legal_data',array('class' => 'form-horizontal legal_form_pkp legal_form_all')); ?>
                            <?php $container = 'PKP'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
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
                                        <label for="city" class="col-sm-3 control-label">PKP<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "PERORANGAN" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <label for="npwp_pkp" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="npwp_pkp" id="npwp_pkp" required="">
                                                    <option>- Pilih PKP -</option>
                                                    <option value="PKP" <?php echo "PKP"==$vendor_detail["NPWP_PKP"] ? 'selected="selected"' : '';?>>PKP</option>
                                                    <option value="BUKAN PKP" <?php echo "BUKAN PKP"==$vendor_detail["NPWP_PKP"] ? 'selected="selected"' : '';?>>BUKAN PKP</option>
                                                </select>
                                            </label>
                                            <span class="pkpspan"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_pkp_no" class="col-sm-3 control-label">Nomor PKP<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "PERORANGAN" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="npwp_pkp_no" name="npwp_pkp_no" value="<?php echo set_value('npwp_pkp_no', $vendor_detail["NPWP_PKP_NO"]); ?>">
                                            <span class="mySpan"></span>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" id="pkp_no_doc" class="namafile hidden" name="pkp_no_doc" value="<?php echo set_value('pkp_no_doc', $vendor_detail["PKP_NO_DOC"]); ?>">
                                            <?php
                                            if (!empty($vendor_detail["PKP_NO_DOC"])) { ?>
                                                <span class="messageUpload"><a style="color: #666; text-decoration: underline" href="<?php echo base_url('Vendor_update_profile')."/viewDok/".$vendor_detail["PKP_NO_DOC"]; ?>" title="File Attachment" target="_blank">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_doc glyphicon glyphicon-trash"></a></span>&nbsp;&nbsp;
                                            <?php
                                            }
                                            else { ?>
                                                <span class="messageUpload" style="display:none"></span>&nbsp;&nbsp;
                                            <?php }
                                            ?>
                                            <input type="text" class="hidden" id="attachment_1" name="attachment_1" value="">
                                            <?php if (!empty($vendor_detail["PKP_NO_DOC"])) { ?>
                                                <button type="button" id="pkp_up" required class="uploadAttachment btn btn-default" data-uploaded="true">Change File (2MB Max)</button>
                                            <?php
                                            }
                                            else { ?>
                                                <button type="button" id="pkp_up" required class="uploadAttachment btn btn-default">Upload File (2MB Max)</button>
                                            <?php }
                                            ?>
                                            <div class="progress progress-striped pkp_prog active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar pkp_prog progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button class="main_button color1 small_btn save_panel" value="PKP" type="button">Save</button>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>

                            <?php echo form_open('Vendor_update_profile/do_update_legal_data',array('class' => 'form-horizontal legal_form_all legal_form siup')); ?>
                            <?php $container = 'SIUP'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
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
                                        <label for="siup_issued_by" class="col-sm-3 control-label">Dikeluarkan Oleh<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control text-uppercase" id="siup_issued_by" name="siup_issued_by" value="<?php echo set_value('siup_issued_by', $vendor_detail["SIUP_ISSUED_BY"]); ?>">
                                            <span id="siup1"></span>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" id="siup_no_doc" class="namafile hidden" name="siup_no_doc" value="<?php echo set_value('siup_no_doc', $vendor_detail["SIUP_NO_DOC"]); ?>">
                                            <?php
                                            if (!empty($vendor_detail["SIUP_NO_DOC"])) { ?>
                                                <span class="messageUpload"><a style="color: #666; text-decoration: underline" href="<?php echo base_url('Vendor_update_profile')."/viewDok/".$vendor_detail["SIUP_NO_DOC"]; ?>" title="File Attachment" target="_blank">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_doc glyphicon glyphicon-trash"></a></span>&nbsp;&nbsp;
                                            <?php
                                            }
                                            else { ?>
                                                <span class="messageUpload" style="display:none"></span>&nbsp;&nbsp;
                                            <?php }
                                            ?>
                                            <input type="text" class="hidden" id="attachment_1" name="attachment_1" value="">
                                            <?php if (!empty($vendor_detail["SIUP_NO_DOC"])) { ?>
                                                <button type="button" id="siup_up" required class="uploadAttachment btn btn-default" data-uploaded="true">Change File (2MB Max)</button>
                                            <?php
                                            }
                                            else { ?>
                                                <button type="button" id="siup_up" required class="uploadAttachment btn btn-default">Upload File (2MB Max)</button>
                                            <?php }
                                            ?>
                                            <div class="progress progress-striped siup_prog active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar siup_prog progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="siup_no" class="col-sm-3 control-label">Nomor<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="siup_no" name="siup_no" value="<?php echo set_value('siup_no', $vendor_detail["SIUP_NO"]); ?>">
                                            <span id="siup2"></span>
                                        </div>
                                        <label for="postcode" class="col-sm-3 control-label">SIUP<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <label for="siup_type" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="siup_type" id="siup_type" required="">
                                                    <option value="SIUP KECIL" <?php echo "SIUP KECIL"==$vendor_detail["SIUP_TYPE"] ? 'selected="selected"' : '';?>>SIUP KECIL</option>
                                                    <option value="SIUP MENENGAH" <?php echo "SIUP MENENGAH"==$vendor_detail["SIUP_TYPE"] ? 'selected="selected"' : '';?>>SIUP MENENGAH</option>
                                                    <option value="SIUP BESAR" <?php echo "SIUP BESAR"==$vendor_detail["SIUP_TYPE"] ? 'selected="selected"' : '';?>>SIUP BESAR</option>
                                                </select>
                                            </label>
                                                <span id="siup3"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="siup_from" class="col-sm-3 control-label">Berlaku Mulai<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="siup_from" class="form-control" value="<?php echo set_value('siup_from', vendorfromdate($vendor_detail["SIUP_FROM"])); ?>" value="<?php echo set_value('siup_from', $vendor_detail["SIUP_FROM"]); ?>" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                <span id="siup4"></span>
                                            </div>
                                        </div>
                                        <label for="siup_to" class="col-sm-3 control-label">Sampai<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="siup_to" class="form-control" value="<?php echo set_value('siup_to', vendorfromdate($vendor_detail["SIUP_TO"])); ?>" value="<?php echo set_value('siup_to', $vendor_detail["SIUP_TO"]); ?>" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                <span id="siup5"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button id="" class="main_button color1 small_btn save_panel" value="SIUP" type="button">Save</button>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_update_legal_data',array('class' => 'form-horizontal legal_form_all legal_form tdp')); ?>
                            <?php $container = 'TDP'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
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
                                        <label for="tdp_issued_by" class="col-sm-3 control-label">Dikeluarkan Oleh<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control text-uppercase" id="tdp_issued_by" name="tdp_issued_by" value="<?php echo set_value('tdp_issued_by', $vendor_detail["TDP_ISSUED_BY"]); ?>">
                                            <span id="tdp1"></span>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" id="tdp_no_doc" class="namafile hidden" name="tdp_no_doc" value="<?php echo set_value('tdp_no_doc', $vendor_detail["TDP_NO_DOC"]); ?>">
                                            <?php
                                            if (!empty($vendor_detail["TDP_NO_DOC"])) { ?>
                                                <span class="messageUpload"><a style="color: #666; text-decoration: underline" href="<?php echo base_url('Vendor_update_profile')."/viewDok/".$vendor_detail["TDP_NO_DOC"]; ?>" title="File Attachment" target="_blank">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_doc glyphicon glyphicon-trash"></a></span>&nbsp;&nbsp;
                                            <?php
                                            }
                                            else { ?>
                                                <span class="messageUpload" style="display:none"></span>&nbsp;&nbsp;
                                            <?php }
                                            ?>
                                            <input type="text" class="hidden" id="attachment_1" name="attachment_1" value="">
                                            <?php if (!empty($vendor_detail["TDP_NO_DOC"])) { ?>
                                                <button type="button" id="tdp_up" required class="uploadAttachment btn btn-default" data-uploaded="true">Change File (2MB Max)</button>
                                            <?php
                                            }
                                            else { ?>
                                                <button type="button" id="tdp_up" required class="uploadAttachment btn btn-default">Upload File (2MB Max)</button>
                                            <?php }
                                            ?>
                                            <div class="progress progress-striped tdp_prog active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar tdp_prog progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tdp_no" class="col-sm-3 control-label">Nomor<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="tdp_no" name="tdp_no" value="<?php echo set_value('tdp_no', $vendor_detail["TDP_NO"]); ?>">
                                            <span id="tdp2"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tdp_from" class="col-sm-3 control-label">Berlaku Mulai<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="tdp_from" class="form-control" value="<?php echo set_value('tdp_from', vendorfromdate($vendor_detail["TDP_FROM"])); ?>" value="<?php echo set_value('tdp_from', $vendor_detail["TDP_FROM"]); ?>" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                <span id="tdp3"></span>
                                            </div>
                                        </div>
                                        <label for="tdp_to" class="col-sm-3 control-label">Sampai<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="tdp_to" class="form-control" value="<?php echo set_value('tdp_to', vendorfromdate($vendor_detail["TDP_TO"])); ?>" value="<?php echo set_value('tdp_to', $vendor_detail["TDP_TO"]); ?>" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                                <span id="tdp4"></span>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button id="" class="main_button color1 small_btn save_panel" value="TDP" type="button">Save</button>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_update_legal_data',array('class' => 'form-horizontal legal_form_all legal_form api')); ?>
                            <?php $container = 'Angka Pengenal Importir'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading" role="button" data-toggle="collapse" href="#api" aria-expanded="false" aria-controls="api">
                                    Angka Pengenal Importir
                                </div>
                                <div class="panel-body collapse" id="api">
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
                                        <label for="api_issued_by" class="col-sm-3 control-label">Dikeluarkan Oleh</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control text-uppercase" id="api_issued_by" name="api_issued_by" value="<?php echo set_value('api_issued_by', $vendor_detail["API_ISSUED_BY"]); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="api_no" class="col-sm-3 control-label">Nomor</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="api_no" name="api_no" value="<?php echo set_value('api_no', $vendor_detail["API_NO"]); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="api_from" class="col-sm-3 control-label">Berlaku Mulai</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="api_from" class="form-control" value="<?php echo set_value('api_from', vendorfromdate($vendor_detail["API_FROM"])); ?>" value="<?php echo set_value('api_from', $vendor_detail["API_FROM"]); ?>" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                </div>
                                        </div>
                                        <label for="api_to" class="col-sm-3 control-label">Sampai</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="api_to" class="form-control" value="<?php echo set_value('api_to', vendorfromdate($vendor_detail["API_TO"])); ?>" value="<?php echo set_value('api_to', $vendor_detail["API_TO"]); ?>" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button id="" class="main_button color1 small_btn save_panel" value="Angka Pengenal Importir" type="button">Save</button>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>

                                <div class="panel panel-default">
                                    <div class="panel-body text-right"> 
                                        <button id="save_legal" class="main_button color2 small_btn" type="button">Save & Back</button>
                                    </div>
                                </div>
                        </div>
                    </div>
				</div>
			</div>
		</section>
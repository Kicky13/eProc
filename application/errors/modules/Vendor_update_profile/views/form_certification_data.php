
		<section class="content_section">

            <div class="modal fade" id="updateCertificationModal" tabindex="-1" role="dialog" aria-labelledby="updateCertification">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Data Sertifikasi</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Vendor_update_profile',array('class' => 'form-horizontal current_edited_certificate','autocomplete'=>'off')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Keterangan Sertifikat">
                                <input type="text" class="hidden" name="cert_id" id="cert_id">
                                <div class="form-group">
                                    <label for="type" class="col-sm-3 control-label">Jenis Sertifikat</label>
                                    <div class="col-sm-3">
                                        <?php
                                        echo form_dropdown('type', $certificate_type, '', 'id="type_edit_certificate" class="form-control"'); ?>
                                    </div>
                                    <label for="type_other" class="col-sm-3 control-label">Lainnya</label>
                                    <div class="col-sm-3 end">
                                        <input type="text" class="form-control text-uppercase" id="type_other_edit_certificate" name="type_other">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cert_name" class="col-sm-3 control-label">Nama Sertifikat</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="cert_name_edit" name="cert_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cert_no" class="col-sm-3 control-label">Nomor Sertifikat</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="cert_no_edit" name="cert_no">
                                    </div>
                                    <div class="colm-sm-6">
                                        <input type="text" id="cert_no_doc_edit" class="hidden" name="cert_no_doc">
                                        <button id="id_upcert_e" type="button" class="uploadAttachment btn btn-default">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                        <div class="progress progress-striped p_cert_e active" style="margin: 10px 0px 0px; display: none;">
                                            <div class="progress-bar p_cert_e progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="issued_by" class="col-sm-3 control-label">Dikeluarkan Oleh</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="issued_by_edit" name="issued_by">
                                    </div>
                                </div>
                                <!-- <div class="row"> -->
                                <div class="form-group">
                                    <label for="valid_from" class="col-sm-3 control-label">Berlaku Mulai</label>
                                    <div class="col-sm-3">
                                        <div class="input-group date">
                                            <input type="text" name="valid_from" class="form-control" id="valid_from_edit" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="main_skill" class="col-sm-3 control-label">Sampai</label>
                                    <div class="col-sm-3 end">
                                        <div class="input-group date">
                                            <input type="text" name="valid_to" class="form-control" id="valid_to_edit" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_certification_data_button">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Data Sertifikasi</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open('Vendor_update_profile/do_insert_certifications',array('class' => 'form-horizontal insert_certifications', 'autocomplete'=>'off')); ?>
                            <?php $container = 'Keterangan Sertifikat'; ?>
                           <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">Keterangan Sertifikat</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Keterangan Sertifikat">
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
                                        <label for="type" class="col-sm-3 control-label">Jenis Sertifikat</label>
                                        <div class="col-sm-3">
                                            <?php
                                            echo form_dropdown('type', $certificate_type, '', 'id="type_certificate" class="form-control"'); ?>
                                        </div>
                                        <label for="type_other" class="col-sm-3 control-label">Lainnya</label>
                                        <div class="col-sm-3 end">
                                            <input type="text" class="form-control text-uppercase" id="type_other_certificate" name="type_other" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cert_name" class="col-sm-3 control-label">Nama Sertifikat</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-uppercase" id="cert_name" name="cert_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cert_no" class="col-sm-3 control-label">Nomor Sertifikat</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="cert_no" name="cert_no">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="cert_no_doc" class="hidden" name="cert_no_doc">
                                            <button id="id_upcert" type="button" class="uploadAttachment btn btn-default">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                            <div class="progress progress-striped p_cert active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar b_cert progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="issued_by" class="col-sm-3 control-label">Dikeluarkan Oleh</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-uppercase" id="issued_by" name="issued_by">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="valid_from" class="col-sm-3 control-label">Berlaku Mulai</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="valid_from" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="main_skill" class="col-sm-3 control-label">Sampai</label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" name="valid_to" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addCertifications" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="table-responsive">
                                <table class="table table-hover margin-bottom-20 panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'panel-success') ?>" id="certifications">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-left">Jenis</th>
                                            <th class="text-left">Nama Sertifikat</th>
                                            <th class="text-center">Nomor Sertifikat</th>
                                            <th class="text-left">Dikeluarkan Oleh</th>
                                            <th class="text-center">Berlaku Mulai</th>
                                            <th class="text-center">Sampai</th>
                                            <th class="text-center" style="width: 86px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                        <?php if (empty($certifications)) { ?>
                                        <tr id="empty_row">
                                            <td colspan="8" class="text-center">- Belum ada data -</td>
                                        </tr>
                                        <?php
                                        }
                                        else {
                                            $no = 1;
                                            foreach ((array)$certifications as $key => $certifications) { ?>
                                        <tr id="<?php echo $certifications['CERT_ID']; ?>">
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td>
                                                <?php
                                                if ($certifications['TYPE'] != '') {
                                                    if (!empty($certifications['TYPE_OTHER'])) {
                                                        echo $certifications['TYPE_OTHER'];
                                                    }
                                                    else {
                                                        echo $certificate_type[$certifications['TYPE']];
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $certifications['CERT_NAME']; ?></td>
                                            <td class="text-center"><?php if (isset($certifications['CERT_NO_DOC'])) { ?><a href="<?php echo base_url('Vendor_update_profile') ?>/viewDok/<?php echo $certifications['CERT_NO_DOC']; ?>" target="_blank"><?php echo $certifications['CERT_NO']; ?></a><?php } else { echo $certifications['CERT_NO'];} ?></td>
                                            <td><?php echo $certifications['ISSUED_BY']; ?></td>
                                            <td class="text-center f_valid_from"><?php echo vendorfromdate($certifications['VALID_FROM']); ?></td>
                                            <td class="text-center f_valid_to"><?php echo vendorfromdate($certifications['VALID_TO']); ?></td>
                                            <td><button type="button" class="main_button small_btn update_vendor_certifications"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_vendor_certifications/'.$certifications['CERT_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                        </tr>
                                            <?php }
                                        ?>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                                <div class="panel panel-default">
                                    <div class="panel-body text-right">
                                        <button id="save_certifications" class="main_button color2 small_btn" type="button">Save & Back</button>
                                    </div>
                                </div>
                        </div>
                    </div>
				</div>
			</div>
		</section>
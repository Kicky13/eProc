        <section class="content_section">
            <input type="text" class="hidden" id="vendor_type" name="vendor_type" value="<?php echo set_value('vendor_type', $vendor_detail["VENDOR_TYPE"]); ?>">

            <div class="modal fade" id="updateKomisarisDataModal" tabindex="-1" role="dialog" aria-labelledby="updateKomisarisData">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Dewan Komisaris</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Vendor_update_profile',array('class' => 'form-horizontal komisaris_board')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="text" class="hidden" name="komisaris_id" id="komisaris_id">
                                <input type="text" class="hidden" name="type" value="Commissioner">
                                <input type="hidden" id="container" name="container" value="Dewan Komisaris">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Nama Lengkap (Sesuai KTP)</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pos" class="col-sm-3 control-label">Jabatan</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-uppercase" id="pos" name="pos">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="telephone_no" class="col-sm-3 control-label">Nomor Telepon</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="telephone_no" name="telephone_no">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email_address" class="col-sm-3 control-label">Email</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control text-uppercase" id="email_address" name="email_address">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ktp_no" class="col-sm-3 control-label">Nomor KTP/Passport/KITAS</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="ktp_no" name="ktp_no">
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="hidden" id="kom_upload_e" name="file_upload">
                                        <button id="id_komisaris_e" type="button" required class="uploadAttachment u_komisaris_e btn btn-default">Upload File (2MB Max)</button><span class="filenamespan f_komisaris_e"></span>&nbsp;&nbsp;<a id="del_komisaris_e" class="btn btn-default delete_upload_file_ba glyphicon glyphicon-trash"></a>
                                        <div class="progress progress-striped p_komisaris_e active" style="margin: 10px 0px 0px; display: none;">
                                            <div class="col-sm-3 progress-bar b_komisaris_e progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label for="ktp_no" class="col-sm-3 control-label">Masa Berlaku</label>
                                    <div class="col-sm-3 end">
                                        <div class="input-group date">
                                            <input type="text" name="ktp_expired_date" id="ktp_expired_date" class="form-control" readonly=""><span class="input-group-addon" ><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="npwp_no" class="col-sm-3 control-label">NPWP</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control npwp_no" id="npwp_no" name="npwp_no">
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_komisaris">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="updateDireksiDataModal" tabindex="-1" role="dialog" aria-labelledby="updateDireksiData">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Dewan Direksi</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Vendor_update_profile',array('class' => 'form-horizontal current_edited_board')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="text" class="hidden" name="direksi_id" id="direksi_id">
                                <input type="text" class="hidden" name="type" value="Director">
                                <input type="hidden" id="container" name="container" value="Dewan Direksi">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Nama Lengkap (Sesuai KTP)<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="direksi_name" name="name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pos" class="col-sm-3 control-label">Jabatan<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-uppercase" id="direksi_pos" name="pos">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="telephone_no" class="col-sm-3 control-label">Nomor Telepon<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-uppercase" id="direksi_telephone_no" name="telephone_no">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email_address" class="col-sm-3 control-label">Email<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control text-uppercase" id="direksi_email_address" name="email_address">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ktp_no" class="col-sm-3 control-label">Nomor KTP/Passport/KITAS<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="direksi_ktp_no" name="ktp_no">
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="hidden" id="dir_upload_e" name="file_upload">
                                        <button id="id_direktur_e" type="button" required class="uploadAttachment dir_upload_e btn btn-default">Upload File (2MB Max)</button><span class="filenamespan f_direktur_e"></span>
                                            &nbsp;&nbsp;<a id="del_direktur_e" class="btn btn-default delete_upload_file_ba glyphicon glyphicon-trash"></a>
                                        <div class="progress progress-striped p_direktur_e active" style="margin: 10px 0px 0px; display: none;">
                                            <div class="col-sm-3 progress-bar b_direktur_e progress-bar-success"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ktp_no" class="col-sm-3 control-label">Masa Berlaku<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                    <div class="col-sm-3 end">
                                        <div class="input-group date">
                                            <input type="text" id="direksi_ktp_expired_date" name="ktp_expired_date" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="npwp_no" class="col-sm-3 control-label">NPWP<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control npwp_no" id="direksi_npwp_no" name="npwp_no">
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_direksi">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open('Vendor_update_profile',array('class' => 'form-horizontal insert_commissioner', 'autocomplete'=>'off')); ?>
                            <?php $container = 'Dewan Komisaris' ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">Dewan Komisaris (Opsional)</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="text" class="hidden" name="type" value="Commissioner">
                                <input type="hidden" id="container" name="container" value="Dewan Komisaris">
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
                                        <label for="name" class="col-sm-3 control-label">Nama Lengkap (Sesuai KTP)</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control text-uppercase" id="name" name="name">
                                        </div>
                                         
                                    </div>
                                    <div class="form-group">
                                        <label for="pos" class="col-sm-3 control-label">Jabatan</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="pos" name="pos">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="telephone_no" class="col-sm-3 control-label">Nomor Telepon</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="telephone_no" name="telephone_no">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email_address" class="col-sm-3 control-label">Email</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control text-uppercase" id="email_address" name="email_address">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ktp_no" class="col-sm-3 control-label">Nomor KTP/Passport/KITAS</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="ktp_no" name="ktp_no">
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="hidden" id="kom_upload" name="file_upload">
                                            <button id="id_komisaris" type="button" required class="uploadAttachment u_komisaris btn btn-default">Upload File (2MB Max)</button><span class="filenamespan f_komisaris"></span>
                                                &nbsp;&nbsp;<a id="del_komisaris" class="btn btn-default delete_upload_file_ba glyphicon glyphicon-trash"></a>
                                            <div class="progress progress-striped p_komisaris active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="col-sm-3 progress-bar b_komisaris progress-bar-success"   role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    <div class="form-group">
                                         <label for="ktp_no" class="col-sm-3 control-label">Masa Berlaku</label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" name="ktp_expired_date" id="ktp_expired_date" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_no" class="col-sm-3 control-label">NPWP</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control npwp_no" id="npwp_no" name="npwp_no">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addCommissioner" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="table-responsive">
                                <table class="table table-hover margin-bottom-20 panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'panel-success') ?>" id="vendor_board_commissioner">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Nama Lengkap</th>
                                            <th class="text-center">Jabatan</th>
                                            <th class="text-center">Nomor Telepon</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Nomor KTP</th>
                                            <th class="text-center">Masa Berlaku</th>
                                            <th class="text-center">NPWP</th>
                                            <th class="text-center" style="width: 86px">Action</th>
                                            <th class="hidden"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                        <?php if (empty($vendor_board_commissioner)) { ?>
                                        <tr id="empty_row">
                                            <td colspan="8" class="text-center">- Belum ada data -</td>
                                        </tr>
                                        <?php
                                        }
                                        else {
                                            $no = 1;
                                            foreach ($vendor_board_commissioner as $key => $board) { ?>
                                        <tr id="<?php echo $board['BOARD_ID']; ?>">
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td><?php echo $board['NAME']; ?></td>
                                            <td><?php echo $board['POS']; ?></td>
                                            <td class="text-center"><?php echo $board['TELEPHONE_NO']; ?></td>
                                            <td><?php echo $board['EMAIL_ADDRESS']; ?></td>
                                            <td class="text-center"><?php if (!empty($board['KTP_FILE'])){ ?> <a href="<?php echo base_url('Vendor_update_profile'); ?>/viewDok/<?php echo $board['KTP_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $board['KTP_NO']; ?></a> <?php } else {  echo $board['KTP_NO']; } ?></td>
                                            <td class="text-center"><?php echo vendorfromdate($board['KTP_EXPIRED_DATE']); ?></td>
                                            <td class="text-center"><?php echo $board['NPWP_NO']; ?></td>
                                            <td><button type="button" class="main_button small_btn update_komisaris_data"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_company_board/'.$board['BOARD_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                            <td class="hidden ktp_date"><?php echo vendorfromdate($board['KTP_EXPIRED_DATE']); ?></td>
                                        </tr>
                                            <?php }
                                        ?>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                    <?php echo form_open('Vendor_update_profile',array('class' => 'form-horizontal insert_director', 'autocomplete'=>'off')); ?>
                    <?php $container = 'Dewan Direksi' ?>
                    <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                        <div class="panel-heading">Dewan Direksi</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="text" class="hidden" name="type" value="Director">
                                <input type="hidden" id="container" name="container" value="Dewan Direksi">
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
                                        <label for="name" class="col-sm-3 control-label">Nama Lengkap (Sesuai KTP)<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control text-uppercase" id="name" name="name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pos" class="col-sm-3 control-label">Jabatan<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="pos" name="pos">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="telephone_no" class="col-sm-3 control-label">Nomor Telepon<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="telephone_no" name="telephone_no">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email_address" class="col-sm-3 control-label">Email<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control text-uppercase" id="email_address" name="email_address">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ktp_no" class="col-sm-3 control-label">Nomor KTP/Passport/KITAS<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="ktp_no" name="ktp_no">
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="hidden" id="dir_upload" name="file_upload">
                                            <button id="id_direktur" type="button" required class="uploadAttachment u_direktur btn btn-default">Upload File (2MB Max)</button><span class="filenamespan f_direktur"></span>
                                                &nbsp;&nbsp;<a id="del_direktur" class="btn btn-default delete_upload_file_ba glyphicon glyphicon-trash"></a>
                                            <div class="progress progress-striped p_direktur active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="col-sm-3 progress-bar b_direktur progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ktp_no" class="col-sm-3 control-label">Masa Berlaku<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" name="ktp_expired_date" id="ktp_expired_date" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_no" class="col-sm-3 control-label">NPWP<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE" or $vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control npwp_no" id="npwp_no" name="npwp_no">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addDirector" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="table-responsive">
                                <table class="table table-hover margin-bottom-20 panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'panel-success') ?>" id="vendor_board_director">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Nama Lengkap</th>
                                            <th class="text-center">Jabatan</th>
                                            <th class="text-center">Nomor Telepon</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Nomor KTP</th>
                                            <th class="text-center">Masa Berlaku</th>
                                            <th class="text-center">NPWP</th>
                                            <th class="text-center" style="width: 86px">Action</th>
                                            <th class="hidden"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                        <?php if (empty($vendor_board_director)) { ?>
                                        <tr id="empty_row">
                                            <td colspan="8" class="text-center">- Belum ada data -</td>
                                        </tr>
                                        <?php
                                        }
                                        else {
                                            $no = 1;
                                            foreach ($vendor_board_director as $key => $board) { ?>
                                        <tr id="<?php echo $board['BOARD_ID']; ?>">
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td><?php echo $board['NAME']; ?></td>
                                            <td><?php echo $board['POS']; ?></td>
                                            <td class="text-center"><?php echo $board['TELEPHONE_NO']; ?></td>
                                            <td><?php echo $board['EMAIL_ADDRESS']; ?></td>
                                            <td class="text-center"><?php if (!empty($board['KTP_FILE'])){ ?> <a href="<?php echo base_url('Vendor_update_profile'); ?>/viewDok/<?php echo $board['KTP_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $board['KTP_NO']; ?></a> <?php } else {  echo $board['KTP_NO']; } ?></td>
                                            <td class="text-center"><?php echo vendorfromdate($board['KTP_EXPIRED_DATE']); ?></td>
                                            <td class="text-center"><?php echo $board['NPWP_NO']; ?></td>
                                            <td><button type="button" class="main_button small_btn update_direktur_data"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_company_board/'.$board['BOARD_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                            <td class="hidden dir_ktp_date"><?php echo vendorfromdate($board['KTP_EXPIRED_DATE']); ?></td>
                                        </tr>
                                            <?php }
                                        ?>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div> 

                                <div class="panel panel-default">
                                    <div class="panel-body text-right">
                                       <!--  <a href="<?php echo base_url('Vendor_update_profile'); ?>" class="main_button small_btn">Back</a> -->
                                        <button id="save_company_board" class="main_button color2 small_btn" type="button">Save & Back</button>
                                    </div>
                                </div>
                        </div>
                    </div>
				</div>
			</div>
		</section>
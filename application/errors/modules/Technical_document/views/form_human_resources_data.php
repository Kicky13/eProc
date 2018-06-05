		<section class="content_section">
            <div class="modal fade" id="updateTenagaUtamaModal" tabindex="-1" role="dialog" aria-labelledby="updateTenagaUtama">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Tenaga Ahli Utama</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Administrative_document/do_insert_akta_pendirian',array('class' => 'form-horizontal current_edited_utama')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="text" class="hidden" name="sdm_id" id="sdm_id_main">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Nama</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="name_edit" name="name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="last_education" class="col-sm-3 control-label">Pendidikan Terakhir</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="last_education_edit" name="last_education">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="main_skill" class="col-sm-3 control-label">Keahlian Utama</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control text-uppercase" id="main_skill_edit" name="main_skill" style="resize: vertical"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="year_exp" class="col-sm-3 control-label">Pengalaman</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control text-uppercase" id="year_exp_edit" name="year_exp">
                                    </div>
                                    <label for="year_exp" class="col-sm-8 text-left no_padding_left control-label">Tahun</label>
                                </div>
                                <div class="form-group">
                                    <label for="emp_status" class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-3">
                                        <label for="emp_status" class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="emp_status" id="emp_status_edit" required="">
                                                <?php foreach ($type_work as $key => $value) { ?>
                                                    <option value="<?php echo $value["TYPE_WORK"]; ?>"><?php echo $value["TYPE_WORK"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="emp_type" class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="emp_type" id="emp_type_edit" required="">
                                                <?php foreach ($type_kwn as $key => $value) { ?>
                                                    <option value="<?php echo $value["TYPE_KWN"]; ?>"><?php echo $value["TYPE_KWN"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_utama_data_button">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="updateTenagaPendukungModal" tabindex="-1" role="dialog" aria-labelledby="updateTenagaPendukung">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Tenaga Ahli Pendukung</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Administrative_document/do_insert_akta_pendirian',array('class' => 'form-horizontal current_edited_ahli')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="text" class="hidden" name="sdm_id" id="sdm_id_support">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Nama</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control  text-uppercase" id="name_edit_pendukung" name="name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="last_education" class="col-sm-3 control-label">Pendidikan Terakhir</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control  text-uppercase" id="last_education_edit_pendukung" name="last_education">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="main_skill" class="col-sm-3 control-label">Keahlian Utama</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control  text-uppercase" id="main_skill_edit_pendukung" name="main_skill" style="resize: vertical"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="year_exp" class="col-sm-3 control-label">Pengalaman</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control  text-uppercase" id="year_exp_edit_pendukung" name="year_exp">
                                    </div>
                                    <label for="year_exp" class="col-sm-8 text-left no_padding_left control-label">Tahun</label>
                                </div>
                                <div class="form-group">
                                    <label for="emp_status" class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-3">
                                        <label for="emp_status" class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="emp_status" id="emp_status_edit_pendukung" required="">
                                                <?php foreach ($type_work as $key => $value) { ?>
                                                    <option value="<?php echo $value["TYPE_WORK"]; ?>"><?php echo $value["TYPE_WORK"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="emp_type" class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="emp_type" id="emp_type_edit_pendukung" required="">
                                                <?php foreach ($type_kwn as $key => $value) { ?>
                                                    <option value="<?php echo $value["TYPE_KWN"]; ?>"><?php echo $value["TYPE_KWN"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_ahli_data_button">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Data SDM</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open('Technical_document/do_insert_sdm',array('class' => 'form-horizontal insert_main_sdm', 'autocomplete'=>'off')); ?>
                            <?php $container = 'Tenaga Ahli Utama'; ?>
                            <div class="panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'hidden') ?>">
                                <div class="panel-heading">Tenaga Ahli Utama</div>
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
                                        <label for="name" class="col-sm-3 control-label">Nama</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-uppercase" id="name" name="name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_education" class="col-sm-3 control-label">Pendidikan Terakhir</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control  text-uppercase" id="last_education" name="last_education">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="main_skill" class="col-sm-3 control-label">Keahlian Utama</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control  text-uppercase" id="main_skill" name="main_skill" style="resize: vertical"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="year_exp" class="col-sm-3 control-label">Pengalaman</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control  text-uppercase" id="year_exp" name="year_exp">
                                        </div>
                                        <label for="year_exp" class="col-sm-8 text-left no_padding_left control-label">Tahun</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="emp_status" class="col-sm-3 control-label">Status</label>
                                        <div class="col-sm-3">
                                            <label for="emp_status" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="emp_status" id="emp_status" required="">
                                                    <?php foreach ($type_work as $key => $value) { ?>
                                                        <option value="<?php echo $value["TYPE_WORK"]; ?>"><?php echo $value["TYPE_WORK"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </label>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="emp_type" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="emp_type" id="emp_type" required="">
                                                    <?php foreach ($type_kwn as $key => $value) { ?>
                                                        <option value="<?php echo $value["TYPE_KWN"]; ?>"><?php echo $value["TYPE_KWN"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addMainSDM" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="table-responsive">
                                <table class="table table-hover margin-bottom-20 <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : '' ?>" id="main_sdm">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Pendidikan Terakhir</th>
                                            <th class="text-center">Keahlian Utama</th>
                                            <th class="text-center">Pengalaman</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Kewarganegaraan</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                        <?php if (empty($main_sdm)) { ?>
                                        <tr id="empty_row">
                                            <td colspan="8" class="text-center">- Belum ada data -</td>
                                        </tr>
                                        <?php
                                        }
                                        else {
                                            $no = 1;
                                            foreach ($main_sdm as $key => $sdm) { ?>
                                        <tr id="<?php echo $sdm['SDM_ID']; ?>">
                                            <td><?php echo $no++; ?></td>
                                            <td class="name_utama"><?php echo $sdm['NAME']; ?></td>
                                            <td class="last_education_utama text-center"><?php echo $sdm['LAST_EDUCATION']; ?></td>
                                            <td class="main_skill_utama text-center"><?php echo $sdm['MAIN_SKILL']; ?></td>
                                            <td class="year_exp_utama text-center"><?php echo $sdm['YEAR_EXP']; ?></td>
                                            <td class="emp_status_utama text-center"><?php echo $sdm['EMP_STATUS']; ?></td>
                                            <td class="emp_type_utama text-center"><?php echo $sdm['EMP_TYPE']; ?></td>
                                            <td><button type="button" class="main_button small_btn update_main_sdm"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_vendor_sdm/'.$sdm['SDM_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                        </tr>
                                            <?php }
                                        ?>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php echo form_open('Technical_document/do_insert_sdm',array('class' => 'form-horizontal insert_support_sdm', 'autocomplete'=>'off')); ?>
                            <?php $container = 'Tenaga Ahli Pendukung'; ?>
                            <div class="panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'hidden') ?>">
                                <div class="panel-heading">Tenaga Ahli Pendukung</div>
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
                                        <label for="name" class="col-sm-3 control-label">Nama</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-uppercase" id="name" name="name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_education" class="col-sm-3 control-label">Pendidikan Terakhir</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-uppercase" id="last_education" name="last_education">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="main_skill" class="col-sm-3 control-label">Keahlian Utama</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control text-uppercase" id="main_skill" name="main_skill" style="resize: vertical"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="year_exp" class="col-sm-3 control-label">Pengalaman</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control text-uppercase" id="year_exp" name="year_exp">
                                        </div>
                                        <label for="year_exp" class="col-sm-8 text-left no_padding_left control-label">Tahun</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="emp_status" class="col-sm-3 control-label">Status</label>
                                        <div class="col-sm-3">
                                            <label for="emp_status" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="emp_status" id="emp_status" required="">
                                                    <?php foreach ($type_work as $key => $value) { ?>
                                                        <option value="<?php echo $value["TYPE_WORK"]; ?>"><?php echo $value["TYPE_WORK"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </label>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="emp_type" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="emp_type" id="emp_type" required="">
                                                    <?php foreach ($type_kwn as $key => $value) { ?>
                                                        <option value="<?php echo $value["TYPE_KWN"]; ?>"><?php echo $value["TYPE_KWN"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addSupportSDM" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <table class="table table-hover margin-bottom-20 <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : '' ?>" id="support_sdm">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Pendidikan Terakhir</th>
                                        <th class="text-center">Keahlian Utama</th>
                                        <th class="text-center">Pengalaman</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Kewarganegaraan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableItem">
                                    <?php if (empty($support_sdm)) { ?>
                                    <tr id="empty_row">
                                        <td colspan="8" class="text-center">- Belum ada data -</td>
                                    </tr>
                                    <?php
                                    }
                                    else {
                                        $no = 1;
                                        foreach ($support_sdm as $key => $sdm) { ?>
                                    <tr id="<?php echo $sdm['SDM_ID']; ?>">
                                        <td><?php echo $no++; ?></td>
                                        <td class="name_pendukung"><?php echo $sdm['NAME']; ?></td>
                                        <td class="last_education_pendukung text-center"><?php echo $sdm['LAST_EDUCATION']; ?></td>
                                        <td class="main_skill_pendukung text-center"><?php echo $sdm['MAIN_SKILL']; ?></td>
                                        <td class="year_exp_pendukung text-center"><?php echo $sdm['YEAR_EXP']; ?></td>
                                        <td class="emp_status_pendukung text-center"><?php echo $sdm['EMP_STATUS']; ?></td>
                                        <td class="emp_type_pendukung text-center"><?php echo $sdm['EMP_TYPE']; ?></td>
                                        <td><button type="button" class="main_button small_btn update_support_sdm"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_vendor_sdm/'.$sdm['SDM_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                    </tr>
                                        <?php }
                                    ?>

                                    <?php } ?>
                                </tbody>
                            </table>
                            
                            <?php if($this->session->userdata('STATUS')=='99' || $this->session->userdata('needupdate')==true){?>
                                <div class="panel panel-default">
                                    <div class="panel-body text-right">
                                        <a href="<?php echo base_url(); ?>Additional_document/input_summary" class="main_button small_btn color1">Back</a>
                                        <button id="save" class="main_button color1 small_btn" type="button">Save</button>
                                    </div>
                                </div>
                            <?php 
                            } else {
                            ?>
                                <div class="panel panel-default">
                                    <div class="panel-body text-right">
                                        <a href="<?php echo base_url(); ?>" class="main_button small_btn">Cancel</a>
                                        <a href="<?php echo base_url('Technical_document/good_and_service_data') ?>" class="main_button color7 small_btn">Back</a>
                                        <button id="saveandcont_sdm" class="main_button color1 small_btn" type="button">Save & Continue</button>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
				</div>
			</div>
		</section>
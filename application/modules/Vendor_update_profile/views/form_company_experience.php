		<section class="content_section">
            <div class="modal fade" id="updateExperienceModal" tabindex="-1" role="dialog" aria-labelledby="updateExperience">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Pengalaman Perusahaan</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Vendor_update_profile',array('class' => 'form-horizontal current_edited_experience')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Pekerjaan">
                                <input type="text" class="hidden" name="cv_id" id="cv_id">
                                <div class="form-group">
                                    <label for="client_name" class="col-sm-3 control-label">Nama Pelanggan</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-uppercase" id="client_name_edit" name="client_name">
                                    </div>
                                    <div class="colm-sm-6">
                                        <input type="text" id="client_name_doc" class="hidden" name="client_name_doc">
                                        <button id="up_peng_p" type="button" class="uploadAttachment btn btn-default">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                        <div class="progress progress-striped active p_peng_p" style="margin: 10px 0px 0px; display: none;">
                                            <div class="progress-bar progress-bar-success b_peng_p"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="project_name" class="col-sm-3 control-label">Nama Proyek</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="project_name_edit" name="project_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="col-sm-3 control-label">Keterangan Proyek</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control text-uppercase" id="description_edit" name="description" style="resize: vertical"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="category" class="col-sm-3 control-label">Nilai Proyek (Termasuk PPN)</label>
                                    <div class="col-sm-3">
                                        <?php echo form_dropdown('currency', $currency, '', 'class="form-control select2" id="currency_edit" style="width : 200px"'); ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control must_autonumeric" id="amount_edit" name="amount">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="category" class="col-sm-3 control-label">Nomor Kontrak</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-uppercase" id="contract_no_edit" name="contract_no">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="start_date" class="col-sm-3 control-label">Tanggal Dimulai</label>
                                    <div class="col-sm-3 end">
                                        <div class="input-group date">
                                            <input type="text" name="start_date" class="form-control" id="start_date_edit" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                    <label for="end_date" class="col-sm-3 control-label">Tanggal Selesai</label>
                                    <div class="col-sm-3 end">
                                        <div class="input-group date">
                                            <input type="text" name="end_date" class="form-control" id="end_date_edit" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="contact_person" class="col-sm-3 control-label">Contact Person</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="contact_person_edit" name="contact_person">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="contact_no" class="col-sm-3 control-label">No. Contact</label>
                                    <div class="col-sm-3 end">
                                        <input type="text" class="form-control text-uppercase" id="contact_no_edit" name="contact_no">
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_company_experience_button">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Pengalaman Perusahaan</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open('Vendor_update_profile/do_insert_experiences',array('class' => 'form-horizontal insert_experiences', 'autocomplete'=>'off')); ?>
                            <?php $container = 'Pekerjaan'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">Pengalaman Perusahaan</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Pekerjaan">
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
                                        <label for="client_name" class="col-sm-3 control-label">Nama Pelanggan</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="client_name" name="client_name">
                                        </div>
                                        <div class="colm-sm-6">
                                            <input type="text" id="client_name_doc" class="hidden" name="client_name_doc">
                                            <button id="up_peng_p" type="button" class="uploadAttachment btn btn-default">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                            <div class="progress progress-striped active p_peng_p" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success b_peng_p"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="project_name" class="col-sm-3 control-label">Nama Proyek</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-uppercase" id="project_name" name="project_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="col-sm-3 control-label">Keterangan Proyek</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control text-uppercase" id="description" name="description" style="resize: vertical"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="category" class="col-sm-3 control-label">Nilai Proyek (Termasuk PPN)</label>
                                        <div class="col-sm-3">
                                            <?php echo form_dropdown('currency', $currency, '', 'class="form-control select2" style="width: 250px"'); ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control must_autonumeric" id="amount" name="amount">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="category" class="col-sm-3 control-label">Nomor Kontrak</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="contract_no" name="contract_no">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="start_date" class="col-sm-3 control-label">Tanggal Dimulai</label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" name="start_date" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                        <label for="end_date" class="col-sm-3 control-label">Tanggal Selesai</label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" name="end_date" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_person" class="col-sm-3 control-label">Contact Person</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-uppercase" id="contact_person" name="contact_person">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_no" class="col-sm-3 control-label">No. Contact</label>
                                        <div class="col-sm-3 end">
                                            <input type="text" class="form-control text-uppercase" id="contact_no" name="contact_no">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addExperiences" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="table-responsive">
                                <table class="table table-hover margin-bottom-20 panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'panel-success') ?>" id="experiences">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Pelanggan</th>
                                            <th class="text-center">Nama Proyek</th>
                                            <th class="text-center">Keterangan Proyek</th>
                                            <th class="text-center">Mata Uang</th>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">No. Kontrak</th>
                                            <th class="text-center">Tanggal Dimulai</th>
                                            <th class="text-center">Tanggal Selesai</th>
                                            <th class="text-center">Contact Person</th>
                                            <th class="text-center">No. Contact</th>
                                            <th class="text-center" style="width: 86px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                        <?php if (empty($experiences)) { ?>
                                        <tr id="empty_row">
                                            <td colspan="12" class="text-center">- Belum ada data -</td>
                                        </tr>
                                        <?php
                                        }
                                        else {
                                            $no = 1;
                                            foreach ($experiences as $key => $experience) { ?>
                                        <tr id="<?php echo $experience['CV_ID']; ?>">
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td class="f_client_name hidden text-center"><?php echo $experience['CLIENT_NAME']; ?></td>
                                            <td><?php if (isset($experience['CLIENT_NAME_DOC'])) { ?><a href="<?php echo base_url('Vendor_update_profile') ?>/viewDok/<?php echo $experience['CLIENT_NAME_DOC']; ?>" target="_blank"><?php echo $experience['CLIENT_NAME']; ?></a><?php } else {  echo $experience['CLIENT_NAME'];  } ?></td>
                                            <td class="f_project_name text-center"><?php echo $experience['PROJECT_NAME']; ?></td>
                                            <td class="f_description text-center"><?php echo $experience['DESCRIPTION']; ?></td>
                                            <td class="text-center f_currency"><?php echo $experience['CURRENCY']; ?></td>
                                            <td class="must_autonumeric f_amount text-center"><?php echo $experience['AMOUNT']; ?></td>
                                            <td class="f_contract_no text-center"><?php echo $experience['CONTRACT_NO']; ?></td>
                                            <td class="f_start_date text-center"><?php echo vendorfromdate($experience['START_DATE']); ?></td>
                                            <td class="f_end_date text-center"><?php echo vendorfromdate($experience['END_DATE']); ?></td>
                                            <td class="f_contact_person text-center"><?php echo $experience['CONTACT_PERSON']; ?></td>
                                            <td class="f_contact_no text-center"><?php echo $experience['CONTACT_NO']; ?></td>
                                            <td class="text-center"><button type="button" class="main_button small_btn update_vendor_experiences"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_vendor_experiences/'.$experience['CV_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                        </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            
                                <div class="panel panel-default">
                                    <div class="panel-body text-right"> 
                                        <button id="save_experiences" class="main_button color2 small_btn" type="button">Save & Back</button>
                                    </div>
                                </div>
                        </div>
                    </div>
				</div>
			</div>
		</section>
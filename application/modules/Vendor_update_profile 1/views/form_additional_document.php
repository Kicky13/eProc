		<section class="content_section">
            <div class="modal fade" id="updatePrincipalModal" tabindex="-1" role="dialog" aria-labelledby="updatePrincipal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Principal Dokumen</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Vendor_update_profile/do_insert_akta_pendirian',array('class' => 'form-horizontal current_edited_principal')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Principal">
                                <input type="text" class="hidden" name="add_id" id="add_principal_id">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Nama</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control text-uppercase" id="name_edit_p" name="name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="col-sm-3 control-label">Alamat</label>
                                    <div class="col-sm-7">
                                        <textarea class="form-control text-uppercase" id="address_edit_p" name="address" style="resize: vertical"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="city" class="col-sm-3 control-label">Kota</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-uppercase" id="city_edit_p" name="city">
                                    </div>
                                    <label for="post_code" class="col-sm-2 control-label">Kode Pos</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-uppercase" id="post_code_edit_p" name="post_code" maxlength="5">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="country" class="col-sm-3 control-label">Negara</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-uppercase" id="country_edit_p" name="country">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="qualification" class="col-sm-3 control-label">Kualifikasi</label>
                                    <div class="col-sm-5">
                                        <textarea class="form-control text-uppercase" id="qualification_edit_p" name="qualification" style="resize: vertical"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="relationship" class="col-sm-3 control-label">Hubungan Kerjasama</label>
                                    <div class="col-sm-5">
                                        <textarea class="form-control text-uppercase" id="relationship_edit_p" name="relationship" style="resize: vertical"></textarea>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_doc_principal">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="updateSubkontraktorModal" tabindex="-1" role="dialog" aria-labelledby="updateSubkontraktor">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Subkontraktor Dokumen</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Vendor_update_profile/do_insert_akta_pendirian',array('class' => 'form-horizontal current_edited_subkontraktor')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Subkontraktor">
                                <input type="text" class="hidden" name="add_id" id="add_subkontraktor_id">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Nama</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control text-uppercase" id="name_edit_s" name="name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="col-sm-3 control-label">Alamat</label>
                                    <div class="col-sm-7">
                                        <textarea class="form-control text-uppercase" id="address_edit_s" name="address" style="resize: vertical"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="city" class="col-sm-3 control-label">Kota</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-uppercase" id="city_edit_s" name="city">
                                    </div>
                                    <label for="post_code" class="col-sm-2 control-label">Kode Pos</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-uppercase" id="post_code_edit_s" name="post_code" maxlength="5">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="country" class="col-sm-3 control-label">Negara</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-uppercase" id="country_edit_s" name="country">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="qualification" class="col-sm-3 control-label">Kualifikasi</label>
                                    <div class="col-sm-5">
                                        <textarea class="form-control text-uppercase" id="qualification_edit_s" name="qualification" style="resize: vertical"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="relationship" class="col-sm-3 control-label">Hubungan Kerjasama</label>
                                    <div class="col-sm-5">
                                        <textarea class="form-control text-uppercase" id="relationship_edit_s" name="relationship" style="resize: vertical"></textarea>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_doc_subkontraktor">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="updateAffiliasiModal" tabindex="-1" role="dialog" aria-labelledby="updateAffiliasi">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Affiliasi Dokumen</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Vendor_update_profile/do_insert_akta_pendirian',array('class' => 'form-horizontal current_edited_affiliasi')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Perusahaan Afiliasi">
                                <input type="text" class="hidden" name="add_id" id="add_affiliasi_id">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Nama</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control text-uppercase" id="name_edit_a" name="name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="col-sm-3 control-label">Alamat</label>
                                    <div class="col-sm-7">
                                        <textarea class="form-control text-uppercase" id="address_edit_a" name="address" style="resize: vertical"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="city" class="col-sm-3 control-label">Kota</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-uppercase" id="city_edit_a" name="city">
                                    </div>
                                    <label for="post_code" class="col-sm-2 control-label">Kode Pos</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-uppercase" id="post_code_edit_a" name="post_code" maxlength="5">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="country" class="col-sm-3 control-label">Negara</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-uppercase" id="country_edit_a" name="country">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="qualification" class="col-sm-3 control-label">Kualifikasi</label>
                                    <div class="col-sm-5">
                                        <textarea class="form-control text-uppercase" id="qualification_edit_a" name="qualification" style="resize: vertical"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="relationship" class="col-sm-3 control-label">Hubungan Kerjasama</label>
                                    <div class="col-sm-5">
                                        <textarea class="form-control text-uppercase" id="relationship_edit_a" name="relationship" style="resize: vertical"></textarea>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_doc_affiliasi">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Dokumen Tambahan</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open('Vendor_update_profile/do_insert_principal',array('class' => 'form-horizontal insert_principal', 'autocomplete'=>'off')); ?>
                            <?php $container = 'Principal'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">Principal</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Principal">
                                <div class="panel-body">
                                    <?php if(isset($progress_status[$container]) && $progress_status[$container]['STATUS'] == 'Rejected'):?>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="alert alert-warning" role="alert"><strong>Keterangan Revisi! </strong><?php echo $progress_status[$container]['REASON']; ?></div> 
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    <?php endif ?>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-3 control-label">Nama</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control text-uppercase" id="name" name="name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-3 control-label">Alamat</label>
                                        <div class="col-sm-7">
                                            <textarea class="form-control text-uppercase" id="address" name="address" style="resize: vertical"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="city" class="col-sm-3 control-label">Kota</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="city" name="city">
                                        </div>
                                        <label for="post_code" class="col-sm-1 control-label">Kode Pos</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control text-uppercase" id="post_code" name="post_code" maxlength="5">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="country" class="col-sm-3 control-label">Negara</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="country" name="country">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="qualification" class="col-sm-3 control-label">Kualifikasi</label>
                                        <div class="col-sm-5">
                                            <textarea class="form-control text-uppercase" id="qualification" name="qualification" style="resize: vertical"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="relationship" class="col-sm-3 control-label">Hubungan Kerjasama</label>
                                        <div class="col-sm-5">
                                            <textarea class="form-control text-uppercase" id="relationship" name="relationship" style="resize: vertical"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addPrincipal" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="table-responsive">
                                <table class="table table-hover margin-bottom-20 panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'panel-success') ?>" id="principals">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Kota</th>
                                            <th>Negara</th>
                                            <th>Kode Pos</th>
                                            <th>Kualifikasi</th>
                                            <th>Hubungan Kerjasama</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                        <?php if (empty($principals)) { ?>
                                        <tr id="empty_row">
                                            <td colspan="9" class="text-center">- Belum ada data -</td>
                                        </tr>
                                        <?php
                                        }
                                        else {
                                            $no = 1;
                                            foreach ($principals as $key => $principal) { ?>
                                        <tr id="<?php echo $principal['ADD_ID']; ?>">
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td class="name"><?php echo $principal['NAME']; ?></td>
                                            <td class="address"><?php echo $principal['ADDRESS']; ?></td>
                                            <td class="city"><?php echo $principal['CITY']; ?></td>
                                            <td class="country"><?php echo $principal['COUNTRY']; ?></td>
                                            <td class="post_code"><?php echo $principal['POST_CODE']; ?></td>
                                            <td class="qualification"><?php echo $principal['QUALIFICATION']; ?></td>
                                            <td class="relationship"><?php echo $principal['RELATIONSHIP']; ?></td>
                                            <td><button type="button" class="main_button small_btn update_add_principal"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_vendor_add/'.$principal['ADD_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                        </tr>
                                            <?php }
                                        ?>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php echo form_open('Vendor_update_profile/do_insert_subcontractor',array('class' => 'form-horizontal insert_subcontractor', 'autocomplete'=>'off')); ?>
                            <?php $container = 'Subkontraktor'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">Subkontraktor</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Subkontraktor">
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
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control text-uppercase" id="name" name="name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-3 control-label">Alamat</label>
                                        <div class="col-sm-7">
                                            <textarea class="form-control text-uppercase" id="address" name="address" style="resize: vertical"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="city" class="col-sm-3 control-label">Kota</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="city" name="city">
                                        </div>
                                        <label for="post_code" class="col-sm-1 control-label">Kode Pos</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control text-uppercase" id="post_code" name="post_code" maxlength="5">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="country" class="col-sm-3 control-label">Negara</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="country" name="country">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="qualification" class="col-sm-3 control-label">Kualifikasi</label>
                                        <div class="col-sm-5">
                                            <textarea class="form-control text-uppercase" id="qualification" name="qualification" style="resize: vertical"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="relationship" class="col-sm-3 control-label">Hubungan Kerjasama</label>
                                        <div class="col-sm-5">
                                            <textarea class="form-control text-uppercase" id="relationship" name="relationship" style="resize: vertical"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addSubcontractor" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="table-responsive">
                                <table class="table table-hover margin-bottom-20 panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'panel-success') ?>" id="subcontractors">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Kota</th>
                                            <th>Negara</th>
                                            <th>Kode Pos</th>
                                            <th>Kualifikasi</th>
                                            <th>Hubungan Kerjasama</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                        <?php if (empty($subcontractors)) { ?>
                                        <tr id="empty_row">
                                            <td colspan="9" class="text-center">- Belum ada data -</td>
                                        </tr>
                                        <?php
                                        }
                                        else {
                                            $no = 1;
                                            foreach ($subcontractors as $key => $subcontractor) { ?>
                                        <tr id="<?php echo $subcontractor['ADD_ID']; ?>">
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td class="name"><?php echo $subcontractor['NAME']; ?></td>
                                            <td class="address"><?php echo $subcontractor['ADDRESS']; ?></td>
                                            <td class="city"><?php echo $subcontractor['CITY']; ?></td>
                                            <td class="country"><?php echo $subcontractor['COUNTRY']; ?></td>
                                            <td class="post_code"><?php echo $subcontractor['POST_CODE']; ?></td>
                                            <td class="qualification"><?php echo $subcontractor['QUALIFICATION']; ?></td>
                                            <td class="relationship"><?php echo $subcontractor['RELATIONSHIP']; ?></td>
                                            <td><button type="button" class="main_button small_btn update_add_subcontractor"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_vendor_add/'.$subcontractor['ADD_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                        </tr>
                                            <?php }
                                        ?>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php echo form_open('Vendor_update_profile/do_insert_affiliation_company',array('class' => 'form-horizontal insert_affiliation_company', 'autocomplete'=>'off')); ?>
                            <?php $container = 'Perusahaan Afiliasi'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">Perusahaan Afiliasi</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Perusahaan Afiliasi">
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
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control text-uppercase" id="name" name="name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-3 control-label">Alamat</label>
                                        <div class="col-sm-7">
                                            <textarea class="form-control text-uppercase" id="address" name="address" style="resize: vertical"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="city" class="col-sm-3 control-label">Kota</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="city" name="city">
                                        </div>
                                        <label for="post_code" class="col-sm-1 control-label">Kode Pos</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control text-uppercase" id="post_code" name="post_code" maxlength="5">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="country" class="col-sm-3 control-label">Negara</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="country" name="country">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="qualification" class="col-sm-3 control-label">Kualifikasi</label>
                                        <div class="col-sm-5">
                                            <textarea class="form-control text-uppercase" id="qualification" name="qualification" style="resize: vertical"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="relationship" class="col-sm-3 control-label">Hubungan Kerjasama</label>
                                        <div class="col-sm-5">
                                            <textarea class="form-control text-uppercase" id="relationship" name="relationship" style="resize: vertical"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addAffiliation_company" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="table-responsive">
                                <table class="table table-hover margin-bottom-20 panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'panel-success') ?>" id="affiliation_companies">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Kota</th>
                                            <th>Negara</th>
                                            <th>Kode Pos</th>
                                            <th>Kualifikasi</th>
                                            <th>Hubungan Kerjasama</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                        <?php if (empty($affiliation_companies)) { ?>
                                        <tr id="empty_row">
                                            <td colspan="9" class="text-center">- Belum ada data -</td>
                                        </tr>
                                        <?php
                                        }
                                        else {
                                            $no = 1;
                                            foreach ($affiliation_companies as $key => $affiliation_company) { ?>
                                        <tr id="<?php echo $affiliation_company['ADD_ID']; ?>">
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td class="name"><?php echo $affiliation_company['NAME']; ?></td>
                                            <td class="address"><?php echo $affiliation_company['ADDRESS']; ?></td>
                                            <td class="city"><?php echo $affiliation_company['CITY']; ?></td>
                                            <td class="country"><?php echo $affiliation_company['COUNTRY']; ?></td>
                                            <td class="post_code"><?php echo $affiliation_company['POST_CODE']; ?></td>
                                            <td class="qualification"><?php echo $affiliation_company['QUALIFICATION']; ?></td>
                                            <td class="relationship"><?php echo $affiliation_company['RELATIONSHIP']; ?></td>
                                            <td><button type="button" class="main_button small_btn update_add_affiliation"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_vendor_add/'.$affiliation_company['ADD_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                        </tr>
                                            <?php }
                                        ?>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                                <div class="panel panel-default">
                                    <div class="panel-body text-right">
                                        <button id="saveandcont_additional_document" class="main_button color2 small_btn" type="button">Save & Back</button>
                                    </div>
                                </div>
                        </div>
                    </div>
				</div>
			</div>
		</section>
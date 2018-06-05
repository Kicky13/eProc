		<section class="content_section">
            <div class="modal fade" id="updateeEquipmentModal" tabindex="-1" role="dialog" aria-labelledby="updateeEquipment">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Fasilitas/Peralatan</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Vendor_update_profile',array('class' => 'form-horizontal current_edited_facility')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Keterangan Tentang Fasilitas dan Peralatan">
                                <input type="text" class="hidden" name="equip_id" id="equip_id">
                                <div class="form-group">
                                    <label for="category" class="col-sm-3 control-label">Kategori</label>
                                    <div class="col-sm-3">
                                        <?php echo form_dropdown('category', $tools_category, '', 'id="category_edit_peralatan" class="form-control"'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="equip_name" class="col-sm-3 control-label">Nama Peralatan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="equip_name_edit_peralatan" name="equip_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="spec" class="col-sm-3 control-label">Spesifikasi</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="spec_edit_peralatan" name="spec">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="quantity" class="col-sm-3 control-label">Kuantitas</label>
                                    <div class="col-sm-2 end">
                                        <input type="text" class="form-control text-uppercase" id="quantity_edit_peralatan" name="quantity">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="year_made" class="col-sm-3 control-label">Tahun Pembuatan</label>
                                    <div class="col-sm-2 end">
                                        <div class="input-group date year">
                                            <input type="text" name="year_made" class="form-control " id="year_made_edit_peralatan" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_equip_data_button">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Fasilitas/Peralatan</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12"> 
                            <?php echo form_open('Vendor_update_profile/do_insert_equipments',array('class' => 'form-horizontal insert_equipments','autocomplete'=>'off')); ?>
                            <?php $container = 'Keterangan Tentang Fasilitas dan Peralatan'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">Keterangan Tentang Fasilitas dan Peralatan</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Keterangan Tentang Fasilitas dan Peralatan">
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
                                        <label for="category" class="col-sm-3 control-label">Kategori</label>
                                        <div class="col-sm-3">
                                            <?php echo form_dropdown('category', $tools_category, '', 'id="category" class="form-control"'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="equip_name" class="col-sm-3 control-label">Nama Peralatan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-uppercase" id="equip_name" name="equip_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="spec" class="col-sm-3 control-label">Spesifikasi</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control text-uppercase" id="spec" name="spec">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity" class="col-sm-3 control-label">Kuantitas</label>
                                        <div class="col-sm-2 end">
                                            <input type="text" class="form-control text-uppercase" id="quantity" name="quantity">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="year_made" class="col-sm-3 control-label">Tahun Pembuatan</label>
                                        <div class="col-sm-2 end">
                                            <div class="input-group date year">
                                                <input type="text" name="year_made" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addEquipments" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="table-responsive">
                                <table class="table table-hover margin-bottom-20 panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'panel-success') ?>" id="equipments">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Kategori</th>
                                            <th class="text-center">Nama Peralatan</th>
                                            <th class="text-center">Spesifikasi</th>
                                            <th class="text-center">Kuantitas</th>
                                            <th class="text-center">Tahun Pembuatan</th>
                                            <th class="text-center" style="width: 86px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                        <?php if (empty($equipments)) { ?>
                                        <tr id="empty_row">
                                            <td colspan="7" class="text-center">- Belum ada data -</td>
                                        </tr>
                                        <?php
                                        }
                                        else {
                                            $no = 1;
                                            foreach ($equipments as $key => $equipment) { ?>
                                        <tr id="<?php echo $equipment['EQUIP_ID']; ?>">
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td hidden class="category_code_peralatan text-center"><?php echo $equipment['CATEGORY']; ?></td>
                                            <td class="category_peralatan text-center"><?php if ($equipment['CATEGORY'] != '') { echo $tools_category[$equipment['CATEGORY']]; } ?></td>
                                            <td class="equp_name_peralatan text-center"><?php echo $equipment['EQUIP_NAME']; ?></td>
                                            <td class="spec_peralatan text-center"><?php echo $equipment['SPEC']; ?></td>
                                            <td class="quantity_peralatan text-center"><?php echo $equipment['QUANTITY']; ?></td>
                                            <td class="year_made_peralatan text-center"><?php echo $equipment['YEAR_MADE']; ?></td>
                                            <td class="text-center"><button type="button" class="main_button small_btn update_vendor_equipments"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_vendor_equipments/'.$equipment['EQUIP_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                        </tr>
                                            <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                            
                                <div class="panel panel-default">
                                    <div class="panel-body text-right"> 
                                        <button id="save_equipments" class="main_button color2 small_btn" type="button">Save & Back</button>
                                    </div>
                                </div>
                        </div>
                    </div>
				</div>
			</div>
		</section>
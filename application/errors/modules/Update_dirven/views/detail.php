<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Data Jasa</h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-horizontal">
                        <div class="panel panel-default">
                            <div class="panel-heading">Vendor Information</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="NPP" class="col-sm-3 control-label">Vendor No</label>
                                    <label for="NPP" class="col-sm-9 control-label text-left"><strong><?php echo $panel_header[0]['VENDOR_NO']; ?></strong></label>
                                </div>

                                <div class="form-group">
                                    <label for="FIRSTNAME" class="col-sm-3 control-label">Vendor Name</label>
                                    <label for="FIRSTNAME" class="col-sm-9 control-label text-left"><strong><?php echo $panel_header[0]['VENDOR_NAME']; ?></strong></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_open('Update_dirven/insert',array('class' => 'form-horizontal insert_service','autocomplete'=>'off')); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Jasa yang Bisa Dipasok</div>
                        <input type="hidden" name="vendor_id" id="vendor_id" value="<?php echo $vendor_id; ?>">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Group Jasa<span style="color: #E74C3C">*</span></label>
                                <div class="col-sm-5">
                                    <label class="custom_select">
                                        <span class="lfc_alert"></span>
                                        <select name="group_jasa_id" id="group_jasa_id" required="" class="form-control select2">
                                            <option value="" selected="">Pilih Grup Jasa</option>
                                            <?php foreach ($group_jasa as $key => $value) { ?>
                                                <option value="<?php echo $value["ID"]; ?>"><?php echo $value["NAMA"]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </label>
                                </div>  
                                <input type="text" class="hidden" name="svc" id="svc">                                      
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Sub Group Jasa<span style="color: #E74C3C">*</span></label>
                                <div class="col-sm-5">
                                    <label class="custom_select">
                                        <span class="lfc_alert"></span>
                                        <select name="subGroup_jasa_id" id="subGroup_jasa_id" required="" class="form-control select2">
                                            <option value="" selected="">Pilih Sub Grup Jasa</option>
                                        </select>
                                    </label>
                                </div>
                                <input type="text" class="hidden" name="subsvc" id="subsvc">
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Klasifikasi</label>
                                <div class="col-sm-5">
                                    <label class="custom_select">
                                        <span class="lfc_alert"></span>
                                        <select name="klasifikasi_jasa_id" id="klasifikasi_jasa_id" class="form-control select2">
                                            <option value="" selected="">Pilih Klasifikasi</option>
                                        </select>
                                    </label>
                                </div>
                                <input type="text" class="hidden" name="klasf" id="klasf">
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Sub Klasifikasi</label>
                                <div class="col-sm-9">
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <span class="lfc_alert"></span>
                                                <div id="subKlasifikasi_ganjil" ></div>
                                            </div>
                                            <!-- <div class="col-sm-4">
                                                <div id="subKlasifikasi_genal"></div>
                                            </div> -->
                                        </div>                                                
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Kualifikasi<span style="color: #E74C3C">*</span></label>
                                <div class="col-sm-3">
                                    <label class="custom_select">
                                        <span class="lfc_alert"></span>
                                        <select name="kualifikasi_jasa_id" id="kualifikasi_jasa_id" required="" class="form-control select2">
                                            <option value="" selected="">Pilih Kualifikasi</option>
                                            <?php foreach ($kualifikasi_jasa as $key => $value) { ?>
                                                <option value="<?php echo $value["ID"]; ?>"><?php echo $value["NAMA"]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </label>
                                </div>
                                <input type="text" class="hidden" name="kualifi" id="kualifi">                                        
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Sub Kualifikasi<span style="color: #E74C3C">*</span></label>
                                <div class="col-sm-3">
                                    <label class="custom_select">
                                        <span class="lfc_alert"></span>
                                        <select name="subKualifikasi_jasa_id" id="subKualifikasi_jasa_id" required="" class="form-control select2">
                                            <option value="" selected="">Pilih Sub Kualifikasi</option>
                                        </select>
                                    </label>
                                </div>
                                <input type="text" class="hidden" name="subKualifi" id="subKualifi"> 
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No. Ijin<span style="color: #E74C3C">*</span></label>
                                <div class="col-sm-9">
                                <span class="lfc_alert"></span>
                                    <input type="text" class="form-control" id="no" name="no" required="">
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="issued_by" class="col-sm-3 control-label">Dikeluarkan Oleh<span style="color: #E74C3C">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="issued_by" name="issued_by">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="issued_date" class="col-sm-3 control-label">Berlaku Mulai<span style="color: #E74C3C">*</span></label>
                                <div class="col-sm-3">
                                    <div class="input-group date">
                                        <input type="text" name="issued_date" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="expired_date" class="col-sm-3 control-label">Sampai<span style="color: #E74C3C">*</span></label>
                                <div class="col-sm-3 end">
                                    <div class="input-group date">
                                        <input type="text" name="expired_date" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">File Upload<span style="color: #E74C3C">*</span></label>
                                <div class="col-sm-8">
                                    <input type="hidden" name="file_upload" class="file_jasa" id="file_jasa">  
                                    <button type="button" required class="uploadAttachment btn btn-default jasa">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                        &nbsp;&nbsp;<a class="btn btn-default delete_upload_file_ja glyphicon glyphicon-trash"></a>
                                    <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                        <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-center">
                            <a href="<?php echo base_url('Update_dirven') ?>" class="main_button color2 small_btn" type="button">Back</a>
                            <button class="main_button small_btn reset_button">Reset</button>
                            <button id="addServices" class="main_button color1 small_btn" type="button">Add Data</button>
                        </div>
                    </div>
                    <div class="panel panel-default">
                    <?php echo form_close(); ?>
                    <table class="list table table-hover margin-bottom-20 panel" id="services">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Group Jasa</th>
                                <th>Nama Jasa</th>
                                <th>No. Ijin</th>
                                <th>Dikelurkan</th>
                                <th>Berlaku</th>
                                <th>Sampai</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($services)) { ?>
                            <tr id="empty_row">
                                <td colspan="12" class="text-center">- Belum ada data -</td>
                            </tr>
                            <?php
                            }
                            else {
                                $no = 1;
                                foreach ($services as $key => $service) { ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td class="f_product_name"><?php echo $service['PRODUCT_NAME']; ?></td> 
                                <td class="f_type"><?php echo $service['SUBKLASIFIKASI_NAME']; ?></td>
                                <td class="f_no"><a href="<?php echo base_url('Update_dirven'); ?>/viewDok/<?php echo $service['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $service['NO']; ?></a></td>
                                <td class="f_issued_by"><?php echo $service['ISSUED_BY']; ?></td>
                                <td class="f_issued_date"><?php echo vendorfromdate($service['ISSUED_DATE']); ?></td>
                                <td class="f_expired_date"><?php echo vendorfromdate($service['EXPIRED_DATE']); ?></td>
                                <td>
                                    <?php if(!empty($service['ISLISTED'])) { ?>
                                        <a class="btn btn-default btn-sm glyphicon glyphicon-trash" onclick="del(<?php echo $service['PRODUCT_ID'];?>);"></a>
                                    <?php } ?>
                                </td>
                            </tr>
                                <?php }
                            ?>

                            <?php } ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
		</div>
	</div>
</section>
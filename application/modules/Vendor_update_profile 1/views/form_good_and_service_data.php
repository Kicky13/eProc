		<section class="content_section">
            <input type="text" class="hidden" id="vendor_type" name="vendor_type" value="<?php echo set_value('vendor_type', $vendor_detail["VENDOR_TYPE"]); ?>">

            <div class="modal fade" id="updateGoodModal" tabindex="-1" role="dialog" aria-labelledby="updateGood">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Barang</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Vendor_update_profile',array('class' => 'form-horizontal current_edited_good')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Barang dan bahan yang bisa dipasok">
                                <input type="text" class="hidden" name="good_id" id="good_id">
                                <div class="form-group">
                                    <label for="material_code" class="col-sm-3 control-label">Group barang<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-5">
                                        <label for="material_code" class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="material_code_edit" id="material_code_edit" class="sap_material_edit form-control select3" required="">
                                                <option value="" disabled="">Pilih Grup Barang</option>
                                                <?php foreach ($material as $key => $value) { ?>
                                                    <option value="<?php echo $value["MATERIAL_GROUP"]; ?>"><?php echo $value["DESCRIPTION_2"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </label>
                                    </div>
                                    <input type="text" class="hidden" name="material_edit" id="material_edit">
                                </div>
                                <div class="form-group">
                                    <label for="submaterial_code" class="col-sm-3 control-label">Sub Group barang</label>
                                    <div class="col-sm-5">
                                        <label for="submaterial_code" class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="submaterial_code_edit" id="submaterial_code_edit" class="sap_material_edit form-control select3"  required="">
                                            </select>
                                        </label>
                                    </div>
                                    <input type="text" class="hidden" name="submaterial_edit" id="submaterial_edit">
                                </div>
                                <div class="form-group">
                                    <label for="product_description" class="col-sm-3 control-label">Nama Barang<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-7"> 
                                            <input type="text" class="form-control text-uppercase" id="product_description_edit" name="product_description_edit">
                                    </div>
                                    <!-- <div class="col-sm-9">
                                            <span class="lfc_alert"></span>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div id="product_description_ganjil_edit">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div id="product_description_genap_edit">
                                                    </div>
                                                </div>
                                            </div>
                                    </div> -->
                                </div>
                                <div class="form-group">
                                    <label for="brand" class="col-sm-3 control-label">Merk / Brand</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control text-uppercase" id="brand_edit" name="brand_edit">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="source" class="col-sm-3 control-label">Sumber<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-3">
                                        <label for="source" class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="source_edit" id="source_edit" required="" class="form-control select3">
                                                <option value="Lokal">Lokal</option>
                                                <option value="Import">Import</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="type" class="col-sm-3 control-label">Tipe<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-3">
                                        <label for="type" class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="type_edit" id="type_edit" required="" class="form-control select3">
                                                <option value="AGENT">AGENT</option>
                                                <option value="SOLE AGENT">SOLE AGENT</option>
                                                <option value="DISTRIBUTOR">DISTRIBUTOR</option>
                                                <option value="NON AGENT">NON AGENT</option>
                                                <option value="MANUFACTURE">MANUFACTURE</option>
                                                <option value="SUPPORTING LETTER">SUPPORTING LETTER</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="no" class="col-sm-3 control-label mandatory_barang_edit">No. Surat</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control text-uppercase" id="no_edit" name="no_edit">
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label for="issued_by" class="col-sm-3 control-label mandatory_barang_edit">Dikeluarkan Oleh</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control text-uppercase" id="issued_by_edit" name="issued_by_edit">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="issued_date" class="col-sm-3 control-label mandatory_barang_edit">Berlaku Mulai</label>
                                    <div class="col-sm-3 end">
                                        <div class="input-group date">
                                            <input type="text" name="issued_date_edit" id="issued_date_edit" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="expired_date" class="col-sm-3 control-label mandatory_barang_edit">Sampai</label>
                                    <div class="col-sm-3 end">
                                        <div class="input-group date">
                                            <input type="text" name="expired_date_edit" id="expired_date_edit" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                        <input type="hidden" name="file_upload_lama_ba" id="file_upload_lama_ba">
                                    <label class="col-sm-3 control-label">File Upload<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="file_upload" id="fil_barang_edit">  
                                        <button id="up_good_e" required class="uploadAttachment btn btn-default barang md_barang">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                            &nbsp;&nbsp;
                                            <a class="btn btn-default delete_upload_file_edit_ba glyphicon glyphicon-trash"></a>
                                        <div class="progress progress-striped active p_good_e" style="margin: 10px 0px 0px; display: none;">
                                            <div class="progress-bar progress-bar-success b_good_e"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" id="close_update_barang" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_good_data_button">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="updateBahanModal" tabindex="-1" role="dialog" aria-labelledby="updateBahan">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Bahan</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Vendor_update_profile',array('class' => 'form-horizontal current_edited_bahan')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Bahan yang bisa dipasok">
                                <input type="text" class="hidden" name="bahan_id" id="bahan_id">
                                <div class="form-group">
                                    <label for="material_code" class="col-sm-3 control-label">Group Bahan<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-5">
                                        <label for="material_code" class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="material_code_edit_bahan" id="material_code_edit_bahan" class="sap_material_edit form-control select3" required="">
                                                <option value="" disabled="">Pilih Grup Bahan</option>
                                                <?php foreach ($material as $key => $value) { ?>
                                                    <option value="<?php echo $value["MATERIAL_GROUP"]; ?>"><?php echo $value["DESCRIPTION_2"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </label>
                                    </div>
                                    <input type="text" class="hidden" name="material_edit_bahan" id="material_edit_bahan">
                                </div>
                                <div class="form-group">
                                    <label for="submaterial_code" class="col-sm-3 control-label">Sub Group Bahan</label>
                                    <div class="col-sm-5">
                                        <label for="submaterial_code" class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="submaterial_code_edit_bahan" id="submaterial_code_edit_bahan" class="sap_material_edit form-control select3"  required=""> 
                                            </select>
                                        </label>
                                    </div>
                                    <input type="text" class="hidden" name="submaterial_edit_bahan" id="submaterial_edit_bahan">
                                </div>
                                <div class="form-group">
                                    <label for="product_description" class="col-sm-3 control-label">Nama Bahan<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-9"> 
                                            <input type="text" class="form-control text-uppercase" id="product_description_edit_bahan" name="product_description_edit_bahan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="source" class="col-sm-3 control-label">Sumber<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-3">
                                        <label for="source" class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="source_edit_bahan" id="source_edit_bahan" required="" class="form-control select3">
                                                <option value="LOKAL">LOKAL</option>
                                                <option value="IMPORT">IMPORT</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="type" class="col-sm-3 control-label">Tipe<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-3">
                                        <label for="type" class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="type_bahan_edit" id="type_bahan_edit" required="" class="form-control select3">
                                                <option value="TREADER">TREADER</option>
                                                <option value="PENAMBANG">PENAMBANG</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="no" class="col-sm-3 control-label mandatory_barang_edit">No. Dokumen</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="no_edit_bahan" name="no_edit_bahan">
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label for="type" class="col-sm-3 control-label">Tipe Dokumen<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                            <label for="type" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="type_dokumen_edit" id="type_dokumen_edit" required="" class="form-control select3">
                                                    <option value="IUO-OP">IUO-OP</option>
                                                    <option value="IUP-OPK PP">IUP-OPK PP</option>
                                                    <option value="KERJASAMA IUO-OP">KERJASAMA IUO-OP</option>
                                                    <option value="CnC">CnC</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                 <div class="form-group">
                                    <label for="issued_by" class="col-sm-3 control-label mandatory_barang_edit">Dikeluarkan Oleh</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="issued_by_edit_bahan" name="issued_by_edit_bahan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="issued_date" class="col-sm-3 control-label mandatory_barang_edit">Berlaku Mulai</label>
                                    <div class="col-sm-3 end">
                                        <div class="input-group date">
                                            <input type="text" name="issued_date_edit_bahan" id="issued_date_edit_bahan" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="expired_date" class="col-sm-3 control-label mandatory_barang_edit">Sampai</label>
                                    <div class="col-sm-3 end">
                                        <div class="input-group date">
                                            <input type="text" name="expired_date_edit_bahan" id="expired_date_edit_bahan" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                        <input type="hidden" name="file_upload_lama_ba_bahan" id="file_upload_lama_ba_bahan">
                                    <label class="col-sm-3 control-label">File Upload<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="file_upload" id="fil_barang_edit">  
                                        <button id="up_bahan_e" required class="uploadAttachment btn btn-default barang md_bahan">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                            &nbsp;&nbsp;
                                            <a class="btn btn-default delete_upload_file_edit_ba glyphicon glyphicon-trash"></a>
                                        <div class="progress progress-striped active p_bahan_e" style="margin: 10px 0px 0px; display: none;">
                                            <div class="progress-bar progress-bar-success b_bahan_e"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" id="close_update_barang" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_edit_bahan">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="updateServiceModal" tabindex="-1" role="dialog" aria-labelledby="updateService">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Jasa</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Vendor_update_profile',array('class' => 'form-horizontal current_edited_jasa')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Jasa yang bisa dipasok">
                                <input type="text" class="hidden" name="service_id" id="service_id">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Group Jasa<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-5">
                                        <label class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="group_jasa_id" id="group_jasa_id_edit" required="" class="form-control select3 cek_mandatory_update" disabled>
                                                <option value="" selected="">Pilih Grup Jasa</option>
                                                <?php foreach ($group_jasa as $key => $value) { ?>
                                                    <option value="<?php echo $value["ID"]; ?>"><?php echo $value["NAMA"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </label>
                                    </div> 
                                    <input type="text" class="hidden" name="svc" id="svc_edit">
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Sub Group Jasa<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-5">
                                        <label class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="subGroup_jasa_id" id="subGroup_jasa_id_edit" required="" class="form-control select3" disabled>
                                                <option value="" selected="">Pilih Sub Grup Jasa</option>
                                            </select>
                                        </label>
                                    </div>
                                    <input type="text" class="hidden" name="subsvc" id="subsvc_edit">
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Klasifikasi</label>
                                    <div class="col-sm-5">
                                        <label class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="klasifikasi_jasa_id" id="klasifikasi_jasa_id_edit" class="form-control select3" disabled>
                                                <option value="" selected="">Pilih Klasifikasi</option>
                                            </select>
                                        </label>
                                    </div>
                                    <input type="text" class="hidden" name="klasf" id="klasf_edit">
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Sub Klasifikasi<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-14">
                                            <span class="lfc_alert"></span>
                                            <div class="row">
                                                <div class="col-sm-14">
                                                    <div id="subKlasifikasi_edit"></div>
                                                </div>
                                            </div>                                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Kualifikasi<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-3">
                                        <label class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="kualifikasi_jasa_id" id="kualifikasi_jasa_id_edit" required="" class="form-control select3">
                                                <option value="" selected="">Pilih Kualifikasi</option>
                                                <?php foreach ($kualifikasi_jasa as $key => $value) { ?>
                                                    <option value="<?php echo $value["ID"]; ?>"><?php echo $value["NAMA"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </label>
                                    </div>
                                    <input type="text" class="hidden" name="kualifi" id="kualifi_edit">                                        
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Sub Kualifikasi<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-3">
                                        <label class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="subKualifikasi_jasa_id" id="subKualifikasi_jasa_id_edit" required="" class="form-control select3">
                                                <option value="" selected="">Pilih Sub Kualifikasi</option>
                                            </select>
                                        </label>
                                    </div>
                                    <input type="text" class="hidden" name="subKualifi" id="subKualifi_edit"> 
                                </div>
                                <div class="form-group">
                                    <label for="no" class="col-sm-2 control-label">No. Ijin<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-uppercase" id="no_jasa_edit" name="no">
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label for="issued_by" class="col-sm-2 control-label">Dikeluarkan Oleh<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="issued_by_jasa_edit" name="issued_by">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="issued_date" class="col-sm-2 control-label">Berlaku Mulai<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-3">
                                        <div class="input-group date">
                                            <input type="text" name="issued_date" class="form-control" id="issued_date_jasa_edit" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="expired_date" class="col-sm-2 control-label">Sampai<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-3 end">
                                        <div class="input-group date">
                                            <input type="text" name="expired_date" class="form-control" id="expired_date_jasa_edit" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                        <input type="hidden" name="file_upload_lama" id="file_upload_lama_ja">
                                    <label class="col-sm-2 control-label">File Upload</label>
                                    <div class="col-sm-8"> 
                                        <input type="hidden" name="file_upload" class="file_jasa" id="file_jasa_edit">  
                                        <button id="up_jasa_e" required class="uploadAttachment btn btn-default jasa md_jasa">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                            &nbsp;&nbsp;
                                            <a class="btn btn-default delete_upload_file_edit_ja glyphicon glyphicon-trash"></a>
                                        <div class="progress progress-striped active p_jasa_e" style="margin: 10px 0px 0px; display: none;">
                                            <div class="progress-bar progress-bar-success b_jasa_e"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_jasa_data_button">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Data Barang dan Jasa</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open('Vendor_update_profile/do_insert_good',array('class' => 'form-horizontal insert_good', 'autocomplete'=>'off')); ?>
                            <?php $container = 'Barang dan bahan yang bisa dipasok'; ?>
                             <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">Barang dan Bahan yang Bisa Dipasok</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Barang dan bahan yang bisa dipasok">

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
                                        <label for="material_code" class="col-sm-3 control-label">Group barang<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-5">
                                            <label for="material_code" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="material_code" id="material_code" class="sap_material form-control select2">
                                                    <option value="" selected="" disabled="">Pilih Grup Barang</option>
                                                    <?php foreach ($material as $key => $value) { ?>
                                                        <option value="<?php echo $value["MATERIAL_GROUP"]; ?>"><?php echo $value["DESCRIPTION_2"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </label>
                                        </div>
                                        <input type="text" class="hidden" name="material" id="material">
                                    </div>
                                    <div class="form-group">
                                        <label for="submaterial_code" class="col-sm-3 control-label">Sub Group barang</label>
                                        <div class="col-sm-5">
                                            <label for="submaterial_code" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="submaterial_code" id="submaterial_code" class="sap_material form-control select2"> 
                                                </select>
                                            </label>
                                        </div>
                                        <input type="text" class="hidden" name="submaterial" id="submaterial">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_description" class="col-sm-3 control-label">Nama Barang<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-7"> 
                                                <input type="text" class="form-control text-uppercase" id="product_description" name="product_description">
                                        </div>
                                        <!-- Material jika ambil dari SAP -->
                                        <!-- <div class="col-sm-9">
                                            <span class="lfc_alert"></span>
                                            <div class="row">
                                                 <div class="col-sm-6">
                                                    <div id="product_description_ganjil">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div id="product_description_genap">

                                                    </div>
                                                </div> 
                                            </div>
                                        </div> -->

                                    </div>
                                    <div class="form-group">
                                        <label for="brand" class="col-sm-3 control-label">Merk / Brand</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="brand" name="brand">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="source" class="col-sm-3 control-label">Sumber<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                            <label for="source" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="source" id="source" required="" class="form-control select2">
                                                    <option value="LOKAL">LOKAL</option>
                                                    <option value="IMPORT">IMPORT</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="type" class="col-sm-3 control-label">Tipe<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                            <label for="type" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="type" id="type_barang" required="" class="form-control select2">
                                                    <option value="AGENT">AGENT</option>
                                                    <option value="SOLE AGENT">SOLE AGENT</option>
                                                    <option value="DISTRIBUTOR">DISTRIBUTOR</option>
                                                    <option value="NON AGENT">NON AGENT</option>
                                                    <option value="MANUFACTURE">MANUFACTURE</option>
                                                    <option value="SUPPORTING LETTER">SUPPORTING LETTER</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="no" class="col-sm-3 control-label mandatory_barang">No. Surat</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control text-uppercase" id="no_barang" name="no">
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label for="issued_by" class="col-sm-3 control-label mandatory_barang">Dikeluarkan Oleh</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control text-uppercase" id="issued_by_barang" name="issued_by">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="issued_date" class="col-sm-3 control-label mandatory_barang">Berlaku Mulai</label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" name="issued_date" class="form-control" id="issued_date_barang" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="expired_date" class="col-sm-3 control-label mandatory_barang">Sampai</label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" name="expired_date" class="form-control" id="expired_date_barang" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="expired_date" class="col-sm-3 control-label">File Upload</label>
                                            <!--span style="color: #E74C3C">*</span-->
                                        <div class="col-sm-8">
                                            <input type="hidden" name="file_upload" id="file_upload_ba">  
                                            <button id="up_good" type="button" required class="uploadAttachment u_good btn btn-default barang">Upload File (2MB Max)</button><span class="filenamespan f_good"></span>
                                                &nbsp;&nbsp;<a id="del_good" class="btn btn-default delete_upload_file_ba glyphicon glyphicon-trash"></a>
                                            <div class="progress progress-striped p_good active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar b_good progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addGoods" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="table-responsive">
                                <table class="table table-hover margin-bottom-20 panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'panel-success') ?>" id="goods">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Group Barang</th>
                                            <th class="text-center">Sub Group</th>
                                            <th class="text-center">Nama Produk</th>
                                            <th class="text-center">Merk</th>
                                            <th class="text-center">Sumber</th>
                                            <th class="text-center">Tipe</th>
                                            <th class="text-center">No. Agent</th>
                                            <th class="text-center">Dikeluarkan</th>
                                            <th class="text-center">Berlaku</th>
                                            <th class="text-center">Sampai</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                        <?php if (empty($goods)) { ?>
                                        <tr id="empty_row">
                                            <td colspan="12" class="text-center">- Belum ada data -</td>
                                        </tr>
                                        <?php
                                        }
                                        else {
                                            $no = 1;
                                            foreach ($goods as $key => $good) { ?>
                                        <tr id="<?php echo $good['PRODUCT_ID']; ?>">
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td><?php echo $good['PRODUCT_NAME']; ?></td>
                                            <td><?php echo $good['PRODUCT_SUBGROUP_NAME']; ?></td>
                                            <td><?php echo $good['PRODUCT_DESCRIPTION']; ?></td>
                                            <td><?php echo $good['BRAND']; ?></td>
                                            <td><?php echo $good['SOURCE']; ?></td>
                                            <td><?php echo $good['TYPE']; ?></td>
                                            <td><?php if (!empty($good['FILE_UPLOAD'])){ ?><a href="<?php echo base_url('Vendor_update_profile'); ?>/viewDok/<?php echo $good['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $good['NO']; ?></a><?php } else {  echo $good["NO"]; } ?></td>
                                            <td><?php echo $good['ISSUED_BY']; ?></td>
                                            <td class="issued_date"><?php echo vendorfromdate($good['ISSUED_DATE']); ?></td>
                                            <td class="expired_date"><?php echo vendorfromdate($good['EXPIRED_DATE']); ?></td>
                                            <td><button type="button" class="main_button small_btn update_vendor_product"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_vendor_product/'.$good['PRODUCT_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                        </tr>
                                            <?php }
                                        ?>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>


                            <?php echo form_open('Vendor_update_profile/do_insert_bahan',array('class' => 'form-horizontal insert_bahan', 'autocomplete'=>'off')); ?>
                            <?php $container = 'Bahan yang bisa dipasok'; ?>
                             <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">Bahan yang Bisa Dipasok</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Bahan yang bisa dipasok">

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
                                        <label for="material_code_bahan" class="col-sm-3 control-label">Group Bahan<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-5">
                                            <label for="material_code_bahan" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="material_code_bahan" id="material_code_bahan" class="sap_material form-control select2">
                                                    <option value="" selected="" disabled="">Pilih Grup Bahan</option>
                                                    <?php foreach ($material as $key => $value) { ?>
                                                        <option value="<?php echo $value["MATERIAL_GROUP"]; ?>"><?php echo $value["DESCRIPTION_2"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </label>
                                        </div>
                                        <input type="text" class="hidden" name="material_bahan" id="material_bahan">
                                    </div>
                                    <div class="form-group">
                                        <label for="submaterial_code_bahan" class="col-sm-3 control-label">Sub Group barang</label>
                                        <div class="col-sm-5">
                                            <label for="submaterial_code_bahan" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="submaterial_code_bahan" id="submaterial_code_bahan" class="sap_material form-control select2"> 
                                                </select>
                                            </label>
                                        </div>
                                        <input type="text" class="hidden" name="submaterial_bahan" id="submaterial_bahan">
                                    </div>
                                    <div class="form-group">
                                        <label for="bahan_description" class="col-sm-3 control-label">Nama Barang<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-7"> 
                                                <input type="text" class="form-control text-uppercase" id="bahan_description" name="bahan_description">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="bahan_source" class="col-sm-3 control-label">Sumber<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                            <label for="bahan_source" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="bahan_source" id="bahan_source" required="" class="form-control select2">
                                                    <option value="LOKAL">LOKAL</option>
                                                    <option value="IMPORT">IMPORT</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="type" class="col-sm-3 control-label">Tipe<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                            <label for="type" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="type_bahan" id="type_bahan" required="" class="form-control select2">
                                                    <option value="TREADER">TREADER</option>
                                                    <option value="PENAMBANG">PENAMBANG</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="no" class="col-sm-3 control-label mandatory_bahan">No. Dokumen</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control text-uppercase" id="no_dokumen" name="no_dokumen">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="type" class="col-sm-3 control-label">Tipe Dokumen<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                            <label for="type" class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="type_dokumen" id="type_dokumen" required="" class="form-control select2">
                                                    <option value="IUO-OP">IUO-OP</option>
                                                    <option value="IUP-OPK PP">IUP-OPK PP</option>
                                                    <option value="KERJASAMA IUO-OP">KERJASAMA IUO-OP</option>
                                                    <option value="CnC">CnC</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label for="issued_by_bahan" class="col-sm-3 control-label mandatory_barang">Dikeluarkan Oleh</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control text-uppercase" id="issued_by_bahan" name="issued_by_bahan">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="issued_date_bahan" class="col-sm-3 control-label mandatory_barang">Berlaku Mulai</label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" name="issued_date_bahan" class="form-control" id="issued_date_bahan" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="expired_date_bahan" class="col-sm-3 control-label mandatory_barang">Sampai</label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" name="expired_date_bahan" class="form-control" id="expired_date_bahan" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="file" class="col-sm-3 control-label">File Upload</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" name="file_upload" id="file_upload_bahan">  
                                            <button id="up_bahan" type="button" required class="uploadAttachment u_bahan btn btn-default barang">Upload File (2MB Max)</button><span class="filenamespan f_bahan"></span>
                                                &nbsp;&nbsp;<a id="del_bahan" class="btn btn-default delete_upload_file_ba glyphicon glyphicon-trash"></a>
                                            <div class="progress progress-striped p_bahan active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar b_bahan progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addBahan" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="table-responsive">
                                <table class="table table-hover margin-bottom-20 panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'panel-success') ?>" id="goods">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Group Barang</th>
                                            <th class="text-center">Sub Group</th>
                                            <th class="text-center">Nama Produk</th>
                                            <th class="text-center">Sumber</th>
                                            <th class="text-center">Tipe</th>
                                            <th class="text-center">Tipe Dokumen</th>
                                            <th class="text-center">No. Dokumen</th>
                                            <th class="text-center">Dikeluarkan</th>
                                            <th class="text-center">Berlaku</th>
                                            <th class="text-center">Sampai</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                        <?php if (empty($bahan)) { ?>
                                        <tr id="empty_row">
                                            <td colspan="12" class="text-center">- Belum ada data -</td>
                                        </tr>
                                        <?php
                                        }
                                        else {
                                            $no = 1;
                                            foreach ($bahan as $key => $bhn) { ?>
                                        <tr id="<?php echo $bhn['PRODUCT_ID']; ?>">
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td><?php echo $bhn['PRODUCT_NAME']; ?></td>
                                            <td><?php echo $bhn['PRODUCT_SUBGROUP_NAME']; ?></td>
                                            <td><?php echo $bhn['PRODUCT_DESCRIPTION']; ?></td>
                                            <td><?php echo $bhn['SOURCE']; ?></td>
                                            <td><?php echo $bhn['TYPE']; ?></td>
                                            <td><?php echo $bhn['KLASIFIKASI_NAME']; ?></td>
                                            <td><?php if (!empty($bhn['FILE_UPLOAD'])){ ?><a href="<?php echo base_url('Vendor_update_profile'); ?>/viewDok/<?php echo $bhn['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $bhn['NO']; ?></a><?php } else {  echo $bhn["NO"]; } ?></td>
                                            <td><?php echo $bhn['ISSUED_BY']; ?></td>
                                            <td class="issued_date_bahan"><?php echo vendorfromdate($bhn['ISSUED_DATE']); ?></td>
                                            <td class="expired_date_bahan"><?php echo vendorfromdate($bhn['EXPIRED_DATE']); ?></td>
                                            <td><button type="button" class="main_button small_btn update_bahan"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_vendor_product/'.$bhn['PRODUCT_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                        </tr>
                                            <?php }
                                        ?>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>


                            <?php echo form_open('Vendor_update_profile/do_insert_service',array('class' => 'form-horizontal insert_service','autocomplete'=>'off')); ?>
                            <?php $container = 'Jasa yang bisa dipasok'; ?>
                             <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">Jasa yang Bisa Dipasok</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="hidden" id="container" name="container" value="Jasa yang bisa dipasok">
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
                                        <label class="col-sm-2 control-label">Group Jasa<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-5">
                                            <label class="custom_select">
                                                <span class="lfc_alert"></span>
                                                <select name="group_jasa_id" id="group_jasa_id" required="" class="form-control select2 cek_mandatory">
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
                                        <label class="col-sm-2 control-label">Sub Group Jasa<span style="color: #E74C3C">*</span></label>
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
                                        <label class="col-sm-2 control-label">Klasifikasi</label>
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
                                        <label class="col-sm-2 control-label">Sub Klasifikasi<span hidden="hidden" class="js_mandatory" style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-9">
                                            <div class="col-sm-14">
                                                <div class="row">
                                                    <div class="col-sm-14">
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
                                        <label class="col-sm-2 control-label">Kualifikasi<span hidden="hidden" class="js_mandatory" style="color: #E74C3C">*</span></label>
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
                                        <label class="col-sm-2 control-label">Sub Kualifikasi<span hidden="hidden" class="js_mandatory" style="color: #E74C3C">*</span></label>
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
                                        <label class="col-sm-2 control-label">No. Ijin<span hidden="hidden" class="js_mandatory" style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                        <span class="lfc_alert"></span>
                                            <input type="text" class="form-control text-uppercase" id="no" name="no" required="">
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label for="issued_by" class="col-sm-2 control-label">Dikeluarkan Oleh<span hidden="hidden" class="js_mandatory" style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control text-uppercase" id="issued_by" name="issued_by">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="issued_date" class="col-sm-2 control-label">Berlaku Mulai<span hidden="hidden" class="js_mandatory" style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="issued_date" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="expired_date" class="col-sm-2 control-label">Sampai<span hidden="hidden" class="js_mandatory" style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" name="expired_date" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">File Upload</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" name="file_upload" class="file_jasa" id="file_jasa">  
                                            <button id="up_jasa" required class="uploadAttachment btn btn-default jasa">Upload File (2MB Max)</button><span class="filenamespan f_jasa"></span>
                                                &nbsp;&nbsp;<a class="btn btn-default delete_upload_file_ja glyphicon glyphicon-trash"></a>
                                            <div class="progress progress-striped active p_jasa" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success b_jasa"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addServices" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="table-responsive">
                                <table class="table table-hover margin-bottom-20 panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'panel-success') ?>" id="services">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Group Jasa</th>
                                            <th>Subgroup Jasa</th>
                                            <th>Klasifikasi</th>
                                            <th>SubKualifikasi</th>
                                            <th>No. Ijin</th>
                                            <th>Dikeluarkan</th>
                                            <th>Berlaku</th>
                                            <th>Sampai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                        <?php if (empty($services)) { ?>
                                        <tr id="empty_row">
                                            <td colspan="12" class="text-center">- Belum ada data -</td>
                                        </tr>
                                        <?php
                                        }
                                        else {
                                            $no = 1;
                                            foreach ($services as $key => $service) { ?>
                                        <tr id="<?php echo $service['PRODUCT_ID']; ?>">
                                            <td><?php echo $no++; ?></td>
                                            <td class="f_product_name"><?php echo $service['PRODUCT_NAME']; ?></td> 
                                            <td class="f_product_subgroup_name"><?php echo $service['PRODUCT_SUBGROUP_NAME']; ?></td>
                                            <td class="f_klasifikasi_name"><?php echo $service['KLASIFIKASI_NAME']; ?></td>
                                            <td class="f_subkualifikasi_name text-center"><?php echo $service['SUBKUALIFIKASI_NAME']; ?></td>
                                            <td class="f_no"><?php if (!empty($service['FILE_UPLOAD'])){ ?> <a href="<?php echo base_url('Vendor_update_profile'); ?>/viewDok/<?php echo $service['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $service['NO']; ?></a> <?php } else {  echo $service['NO']; } ?></td>
                                            <td class="f_issued_by"><?php echo $service['ISSUED_BY']; ?></td>
                                            <td class="f_issued_date"><?php echo vendorfromdate($service['ISSUED_DATE']); ?></td>
                                            <td class="f_expired_date"><?php echo vendorfromdate($service['EXPIRED_DATE']); ?></td>
                                            <td><button type="button" class="main_button small_btn update_vendor_service"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_vendor_product/'.$service['PRODUCT_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                        </tr>
                                            <?php }
                                        ?>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                                <div class="panel panel-default">
                                    <div class="panel-body text-right">
                                        <button id="save_good_and_service" class="main_button color2 small_btn" type="button">Save & Back</button>
                                    </div>
                                </div>
                    </div>
				</div>
			</div>
		</section>
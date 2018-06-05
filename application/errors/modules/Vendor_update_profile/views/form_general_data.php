    <section class="content_section">
            <input type="text" class="hidden" id="vendor_type" name="vendor_type" value="<?php echo set_value('vendor_type', $vendor_detail["VENDOR_TYPE"]); ?>">
            <div class="modal fade" id="updateVendorAddressModal" tabindex="-1" role="dialog" aria-labelledby="UpdateVendorAddress">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Vendor Address</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Vendor_update_profile/do_update_general_address',array('class' => 'form-horizontal current_edited_address')); ?>
                                <input type="text" class="hidden" name="address_id" id="address_id">
                                <input type="hidden" id="container" name="container" value="Alamat Perusahaan">
                                <input type="text" class="hidden" id="vendor_id" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="contact_phone_no" class="col-sm-6 control-label">Kantor</label>
                                            <div class="col-sm-6">
                                                <?php
                                                    $cabang = array (
                                                    "KANTOR PUSAT" => "KANTOR PUSAT",
                                                    "KANTOR CABANG" => "KANTOR CABANG"
                                                );
                                                echo form_dropdown('cabang', $cabang, '', 'class="form-control" id="cabang_edit"'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat" class="col-sm-3 control-label">Alamat<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control text-uppercase" rows="3" name="alamat" id="alamat_edit" value="<?php echo set_value('company_name', $vendor_detail["ADDRESS_STREET"]); ?>" style="resize: vertical"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="country" class="col-sm-6 control-label">Negara<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-6">
                                                <?php
                                                    echo form_dropdown('country', $country, '', 'class="form-control" id="country_edit"'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="telp1" class="col-sm-6 control-label">No. Telp-1<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="telp1_edit" name="telp1" value="<?php echo set_value('telp1'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="province" class="col-sm-6 control-label">Provinsi</label>
                                            <div class="col-sm-6">
                                                <?php
                                                echo form_dropdown('province', $province, '', 'id="province_edit" class="form-control"'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="telp2" class="col-sm-6 control-label">No. Hp</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="telp2_edit" name="telp2" value="<?php echo set_value('telp2'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group" id="city_wrapper">
                                            <label for="city" class="col-sm-6 control-label">Kota<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-6">
                                                <?php  echo form_dropdown('city_select', $city_select, '', 'id="city_select_edit" class="form-control city_select"');?>
                                                <input type="text" class="form-control hidden" id="city_edit" name="city">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="fax" class="col-sm-6 control-label">Fax</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="fax_edit" name="fax" value="<?php echo set_value('fax'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="postcode" class="col-sm-3 control-label">Kode Pos<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="postcode_edit" name="postcode" maxlength="5" value="<?php echo set_value('postcode', $vendor_detail["ADDRESS_POSTCODE"]); ?>">
                                    </div>
                                    <label for="website" class="col-sm-3 control-label">Website</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-uppercase" id="website_edit" name="website" value="<?php echo set_value('website'); ?>">
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_general_address_button">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Data Umum</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open('Vendor_update_profile/do_update_general_data',array('class' => 'form-horizontal general_form')); ?>
                            <?php $container = 'Info Perusahaan' ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">Info Perusahaan</div>
                                <input type="hidden" id="info_perusahaan" name="info_perusahaan" value="Info Perusahaan">
                                <div class="panel-body">
                                    <?php if(isset($progress_status[$container]) && $progress_status[$container]['STATUS'] == 'Rejected'):?>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="alert alert-warning" role="alert"><strong>Keterangan Revisi! </strong><?php echo $progress_status[$container]['REASON']; ?></div> 
                                            </div>
                                        </div>
                                        <hr>
                                    <?php endif ?>
                                    <input type="text" class="hidden" id="vendor_id" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                	<div class="form-group">
                                		<label for="prefix" class="col-sm-3 control-label">Awalan (Prefix)</label>
                                		<div class="col-sm-3">
											<?php
                                            $prefix_vnd = 0;
                                            if($vendor_detail["PREFIX"]){
                                                $prefix_vnd = $vendor_detail["PREFIX"];
                                            }
                                            echo form_dropdown('prefix', $prefix, $prefix_vnd, 'class="form-control"'); ?>
                                		</div>
                                	</div>
                                	<div class="form-group">
                                		<label for="company_name" class="col-sm-3 control-label">Nama Perusahaan<span style="color: #E74C3C">*</span></label>
                                		<div class="col-sm-9">
                                			<input type="text" class="form-control text-uppercase" id="company_name" name="company_name" value="<?php echo set_value('company_name', $vendor_detail["VENDOR_NAME"]); ?>">
                                		</div>
                                	</div>
                                	<div class="form-group">
                                		<label for="suffix" class="col-sm-3 control-label">Akhiran (Suffix)</label>
                                		<div class="col-sm-3">
                                            <?php
                                            echo form_dropdown('suffix', $suffix, $vendor_detail["SUFFIX"], 'class="form-control"'); ?>
                                		</div>
                                	</div>
                                    <div class="form-group">
                                        <label for="vendor_type" class="col-sm-3 control-label">Tipe Vendor<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                        <?php
                                        $options = array(
                                                'NASIONAL' => 'NASIONAL',
                                                'INTERNASIONAL' => 'INTERNASIONAL',
                                                'EXPEDITURE' => 'EXPEDITURE',
                                                'PERORANGAN' => 'PERORANGAN'
                                            );
                                            echo form_dropdown('vendor_type', $options, $vendor_detail["VENDOR_TYPE"], 'class="form-control"'); ?>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button id="save_panel_info_perusahaan" class="main_button color1 small_btn" type="button">Save</button>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_insert_general_address',array('class' => 'form-horizontal insert_address')); ?>
                            <?php $container = 'Alamat Perusahaan' ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">Alamat Perusahaan</div>
                                <input type="hidden" id="container" name="container" value="Alamat Perusahaan">
                                <div class="panel-body">
                                    <?php if(isset($progress_status[$container]) && $progress_status[$container]['STATUS'] == 'Rejected'):?>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="alert alert-warning" role="alert"><strong>Keterangan Revisi! </strong><?php echo $progress_status[$container]['REASON']; ?></div> 
                                            </div>
                                        </div>
                                        <hr>
                                    <?php endif ?>
                                    <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="contact_phone_no" class="col-sm-4 control-label">Kantor</label>
                                                <div class="col-sm-6">
                                                    <?php
                                                        $cabang = array (
                                                        "KANTOR PUSAT" => "KANTOR PUSAT",
                                                        "KANTOR CABANG" => "KANTOR CABANG"
                                                    );
                                                    echo form_dropdown('cabang', $cabang, '', 'class="form-control"'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat" class="col-sm-2 control-label">Alamat<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control text-uppercase" rows="3" name="alamat" id="alamat" style="resize: vertical"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="country" class="col-sm-4 control-label">Negara<span style="color: #E74C3C">*</span></label>
                                                <div class="col-sm-6">
                                                    <select name="country" class="form-control" id="country_select" name="country">
                                                        <option></option>
                                                        <?php foreach ($country as $key => $value): ?>
                                                            <?php if ($key != '" disabled=""disabled" selected="selected'): ?>
                                                            <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                                            <?php endif ?>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="telp1" class="col-sm-3 control-label">No. Telp-1<span style="color: #E74C3C">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="telp1" name="telp1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label id="province_mandatory" for="province" class="col-sm-4 control-label">Provinsi</label>
                                                <div class="col-sm-6">
                                                    <?php
                                                    echo form_dropdown('province', $province, '', 'id="province" class="form-control" disabled'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="telp2" class="col-sm-3 control-label">No. Hp</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="telp2" name="telp2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group" id="city_wrapper">
                                                <label for="city" class="col-sm-4 control-label">Kota<span style="color: #E74C3C">*</span></label>
                                                <div class="col-sm-6">
                                                    <select id="city_select" class="form-control city_select" disabled name="city_select">
                                                    </select>
                                                    <input type="text" class="form-control hidden" id="city" name="city">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="fax" class="col-sm-3 control-label">Fax</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="fax" name="fax">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="postcode" class="col-sm-4 control-label">Kode Pos<span style="color: #E74C3C">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="postcode" name="postcode" maxlength="5">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="website" class="col-sm-3 control-label">Website</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control text-uppercase" id="website" name="website">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        
                                        
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button id="addAddress" class="main_button color1 small_btn" type="submit">Add Data
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="panel panel-default">
                                <div class="table-responsive">
                                    <table class="table table-hover margin-bottom-20 <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'panel-success') ?>" id="company_address">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Branch Type</th>
                                                <th class="text-center">Address</th>
                                                <th class="text-center">City</th>
                                                <th class="text-center">Country</th>
                                                <th class="text-center">Zip Code</th>
                                                <th class="text-center">Phone 1</th>
                                                <th class="text-center">No Hp</th>
                                                <th class="text-center">Fax</th>
                                                <th class="text-center">Website</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableItem">
                                            <?php if (empty($company_address)) { ?>
                                            <tr id="empty_row">
                                                <td colspan="11" class="text-center">- Belum ada data -</td>
                                            </tr>
                                            <?php 
                                            }
                                            else {
                                                $no = 1;
                                                foreach ($company_address as $key => $address) {?>

                                            <tr id="<?php echo $address['ADDRESS_ID']; ?>">
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $address['TYPE']; ?></td>
                                                <td><?php echo $address['ADDRESS']; ?></td>
                                                <td><?php 
                                                    if (is_numeric($address['CITY'])){ 
                                                         echo $city_list[$address['CITY']]; 
                                                    } else {
                                                        echo ucwords(strtolower($address['CITY'])); 
                                                    } ?>
                                                </td>
                                                <td><?php if ($address['COUNTRY'] == 'ID') {echo $country_list[$address['COUNTRY']];} else { echo $address['COUNTRY']; } ?></td>
                                                <td><?php echo $address['POST_CODE']; ?></td>
                                                <td><?php echo $address['TELEPHONE1_NO']; ?></td>
                                                <td><?php echo $address['TELEPHONE2_NO']; ?></td>
                                                <td><?php echo $address['FAX']; ?></td>
                                                <td><?php echo $address['WEBSITE']; ?></td>
                                                <td><button type="button" class="main_button small_btn update_general_address"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_general_address/'.$address['ADDRESS_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                            </tr>
                                                <?php }
                                            ?>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php echo form_open('Vendor_update_profile/do_update_general_data',array('class' => 'form-horizontal general_form')); ?>
                            <?php $container = 'Kontak Perusahaan' ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">Kontak Perusahaan</div>
                                <input type="hidden" id="kontak_perusahaan" name="kontak_perusahaan" value="Kontak Perusahaan">
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
                                        <label for="contact_name" class="col-sm-3 control-label">Nama Lengkap<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control text-uppercase" id="contact_name" name="contact_name" value="<?php echo set_value('contact_name', $vendor_detail["CONTACT_NAME"]); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_pos" class="col-sm-3 control-label">Jabatan<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="contact_pos" name="contact_pos" value="<?php echo set_value('contact_pos', $vendor_detail["CONTACT_POS"]); ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="contact_phone_no" class="col-sm-6 control-label">No. Telp<span style="color: #E74C3C">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="contact_phone_no" name="contact_phone_no" value="<?php echo set_value('contact_phone_no', $vendor_detail["CONTACT_PHONE_NO"]); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="contact_phone_no" class="col-sm-3 control-label">No. HP<span style="color: #E74C3C">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="contact_phone_hp" name="contact_phone_hp" value="<?php echo set_value('contact_phone_no', $vendor_detail["CONTACT_PHONE_HP"]); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_email" class="col-sm-3 control-label">Email<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="contact_email" name="contact_email" value="<?php echo set_value('contact_email', $vendor_detail["CONTACT_EMAIL"]); ?>">
                                        </div>
                                    </div>
                                    <div class="alert alert-danger" role="alert">Note : Kontak Perusahaan harus sama dengan Surat Pernyataan</div>

                                    <div class="text-center">
                                        <button id="save_panel_kontak_perusahaan" class="main_button color1 small_btn" type="button">Save</button>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                                <div class="panel panel-default">
                                    <div class="panel-body text-right">
                                        <!--a href="<?php echo base_url('Vendor_update_profile'); ?>" class="main_button small_btn">Back</a-->
                                        <button id="save" class="main_button color2 small_btn" type="button">Save & Back</button>
                                    </div>
                                </div>
                        </div>
                    </div>
				</div>
			</div>
		</section>
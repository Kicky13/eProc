        <section class="content_section">
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title.' '.$vendor_detail["VENDOR_NAME"];?></h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open('Vendor_update_profile/do_update_general_data',array('class' => 'form-horizontal general_form')); ?>
                            <?php $container = 'Info Perusahaan'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Info Perusahaan
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                    <?php foreach ($cek_vend as $ck_vendor) {
                                    if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                        <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/general_data'); ?>">Edit Data</a>
                                    <?php } else { ?>
                                        <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                    <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                    <div class="form-group">
                                        <label for="prefix" class="col-sm-3 control-label">Awalan (Prefix)</label>
                                        <div class="col-sm-3">
                                            <?php
                                            $prefix_vnd = 0;
                                            if($vendor_detail["PREFIX"]){
                                                $prefix_vnd = $vendor_detail["PREFIX"];
                                            }
                                            echo form_dropdown('prefix', $prefix, $prefix_vnd, 'disabled="disabled" class="form-control"'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_name" class="col-sm-3 control-label">Nama Perusahaan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="company_name" disabled="disabled" name="company_name" value="<?php echo set_value('company_name', $vendor_detail["VENDOR_NAME"]); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="suffix" class="col-sm-3 control-label">Akhiran (Suffix)</label>
                                        <div class="col-sm-3">
                                            <?php
                                            $suffix_vnd = 0;
                                            if($vendor_detail["SUFFIX"]){
                                                $suffix_vnd = $vendor_detail["SUFFIX"];
                                            }
                                            echo form_dropdown('suffix', $suffix, $suffix_vnd, 'disabled="disabled" class="form-control"'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="vendor_type" class="col-sm-3 control-label">Tipe Vendor</label>
                                        <div class="col-sm-3">
                                        <?php
                                        $options = array(
                                                'NASIONAL' => 'NASIONAL',
                                                'INTERNASIONAL' => 'INTERNASIONAL',
                                                'EXPEDITURE' => 'EXPEDITURE',
                                                'PERORANGAN' => 'PERORANGAN'
                                            );
                                            echo form_dropdown('vendor_type', $options, $vendor_detail["VENDOR_TYPE"], 'disabled="disabled" class="form-control"'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Username</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo set_value('company_name', $vendor_detail["LOGIN_ID"]); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Email</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" disabled="disabled" value="<?php echo set_value('company_name', $vendor_detail["EMAIL_ADDRESS"]); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_insert_general_address',array('class' => 'form-horizontal insert_address')); ?>
                            <?php $container = 'Alamat Perusahaan'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Alamat Perusahaan
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                    <?php foreach ($cek_vend as $ck_vendor) {
                                    if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?> 
                                           <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/general_data'); ?>">Edit Data</a>
                                    <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                    <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="company_address">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Branch Type</th>
                                                    <th class="text-center">Address</th>
                                                    <th class="text-center">City</th>
                                                    <th class="text-center">Country</th>
                                                    <th class="text-center">Zip Code</th>
                                                    <th class="text-center">Phone 1</th>
                                                    <th class="text-center">Phone 2</th>
                                                    <th class="text-center">Fax</th>
                                                    <th class="text-center">Website</th>
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
                                                    foreach ($company_address as $key => $address) { ?>
                                                <tr id="<?php echo $address['ADDRESS_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $address['TYPE']; ?></td>
                                                    <td class="text-center"><?php echo $address['ADDRESS']; ?></td>
                                                    <td class="text-center"><?php  if (!is_numeric($address['CITY']) || $address['CITY'] == '') {  echo $address['CITY']; } else { echo $city_list[$address['CITY']]; }?></td>
                                                    <td class="text-center"><?php if ($address['COUNTRY'] == 'ID') {echo $country[$address['COUNTRY']];} else { echo $address['COUNTRY']; } ?></td>
                                                    <td class="text-center"><?php echo $address['POST_CODE']; ?></td>
                                                    <td class="text-center"><?php echo $address['TELEPHONE1_NO']; ?></td>
                                                    <td class="text-center"><?php echo $address['TELEPHONE2_NO']; ?></td>
                                                    <td class="text-center"><?php echo $address['FAX']; ?></td>
                                                    <td class="text-center"><?php echo $address['WEBSITE']; ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_update_general_data',array('class' => 'form-horizontal general_form')); ?>
                            <?php $container = 'Kontak Perusahaan'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Kontak Perusahaan
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                    <?php foreach ($cek_vend as $ck_vendor) {
                                    if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                        <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/general_data'); ?>">Edit Data</a>
                                    <?php } else { ?>
                                        <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                    <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="contact_name" class="col-sm-3 control-label">Nama Lengkap</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="contact_name" disabled="disabled" name="contact_name" value="<?php echo set_value('contact_name', $vendor_detail["CONTACT_NAME"]); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_pos" class="col-sm-3 control-label">Jabatan</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="contact_pos" disabled="disabled" name="contact_pos" value="<?php echo set_value('contact_pos', $vendor_detail["CONTACT_POS"]); ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="contact_phone_no" class="col-sm-6 control-label">No. Telp</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="contact_phone_no" disabled="disabled" name="contact_phone_no" value="<?php echo set_value('contact_phone_no', $vendor_detail["CONTACT_PHONE_NO"]); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="contact_phone_no" class="col-sm-6 control-label">No. HP</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="contact_phone_hp" disabled="disabled" name="contact_phone_hp" value="<?php echo set_value('contact_phone_no', $vendor_detail["CONTACT_PHONE_HP"]); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_email" class="col-sm-3 control-label">Email</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="contact_email" disabled="disabled" name="contact_email" value="<?php echo set_value('contact_email', $vendor_detail["CONTACT_EMAIL"]); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_insert_akta_pendirian',array('class' => 'form-horizontal insert_akta')); ?>
                            <?php $container = 'Akta Pendirian'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Akta Perusahaan
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                    <?php foreach ($cek_vend as $ck_vendor) {
                                    if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                        <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/legal_data'); ?>">Edit Data</a>
                                    <?php } else { ?>
                                        <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                    <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="vendor_akta">
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
                                                    <td class="text-center"><?php if (!empty($akta['AKTA_NO_DOC'])){ ?><a target="_blank" href="<?php echo base_url('Vendor_update_profile') ?>/viewDok/<?php echo $akta['AKTA_NO_DOC']; ?>"><?php echo $akta['AKTA_NO']; ?></a><?php } else {echo $akta['AKTA_NO']; } ?></td>
                                                    <td class="text-center"><?php echo $akta['AKTA_TYPE']; ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($akta['DATE_CREATION']); ?></td>
                                                    <td class="text-center"><?php echo $akta['NOTARIS_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $akta['NOTARIS_ADDRESS']; ?></td>
                                                    <td class="text-center"><?php if (!empty($akta['PENGESAHAN_HAKIM_DOC'])){ ?><a target="_blank" href="<?php echo base_url('Vendor_update_profile') ?>/viewDok/<?php echo $akta['PENGESAHAN_HAKIM_DOC']; ?>"><?php echo vendorfromdate($akta['PENGESAHAN_HAKIM']); ?></a><?php } else {  echo vendorfromdate($akta['PENGESAHAN_HAKIM']); }?></td>
                                                    <td class="text-center"><?php if (!empty($akta['BERITA_ACARA_NGR_DOC'])){ ?><a target="_blank" href="<?php echo base_url('Vendor_update_profile') ?>/viewDok/<?php echo $akta['BERITA_ACARA_NGR_DOC']; ?>"><?php echo vendorfromdate($akta['BERITA_ACARA_NGR']); ?></a><?php } else { echo vendorfromdate($akta['BERITA_ACARA_NGR']); }?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_update_legal_data',array('class' => 'form-horizontal legal_form')); ?>
                            <?php $container = 'Domisili Perusahaan'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Domisili Perusahaan
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                    <?php foreach ($cek_vend as $ck_vendor) {
                                    if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                        <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/legal_data'); ?>">Edit Data</a>
                                    <?php } else { ?>
                                        <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                    <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                    <div class="form-group">
                                        <label for="address_domisili_no" class="col-sm-3 control-label">Nomor Domisili</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="address_domisili_no" disabled="disabled" name="address_domisili_no" value="<?php echo set_value('address_domisili_no', $vendor_detail["ADDRESS_DOMISILI_NO"]); ?>">
                                        </div>
                                        <div class="col-sm-3">
                                            <?php
                                            if (!empty($vendor_detail["DOMISILI_NO_DOC"])) { ?>
                                                <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Vendor_update_profile')."/viewDok/".$vendor_detail["DOMISILI_NO_DOC"]; ?>" title="File Attachment">File Attachment</a></span></label>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_domisili_date" class="col-sm-3 control-label">Tanggal Domisili</label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" disabled="disabled" name="address_domisili_date" class="form-control" value="<?php echo set_value('address_domisili_date', vendorfromdate($vendor_detail["ADDRESS_DOMISILI_DATE"])); ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_domisili_exp_date" class="col-sm-3 control-label">Domisili Kadaluarsa</label>
                                        <div class="col-sm-3 end">
                                            <div class="input-group date">
                                                <input type="text" disabled="disabled" name="address_domisili_exp_date" class="form-control" value="<?php echo set_value('address_domisili_exp_date', vendorfromdate($vendor_detail["ADDRESS_DOMISILI_EXP_DATE"])); ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_street" class="col-sm-3 control-label">Alamat Perusahaan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="address_street" disabled="disabled" name="address_street" value="<?php echo set_value('address_street', $vendor_detail["ADDRESS_STREET"]); ?>">
                                        </div>
                                    </div>
                                    <?php if($vendor_detail["ADDRESS_COUNTRY"] == "ID"): ?>
                                        <div class="form-group">
                                            <label for="address_city" class="col-sm-3 control-label">Kota</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="address_city" disabled="disabled" name="address_city" value="<?php if(is_numeric($vendor_detail["ADDRESS_CITY"])){ echo $city_list[$vendor_detail["ADDRESS_CITY"]]; } else { echo $vendor_detail["ADDRESS_CITY"]; } ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="addres_prop" class="col-sm-3 control-label">Propinsi</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="addres_prop" disabled="disabled" name="addres_prop" value="<?php if(is_numeric($vendor_detail["ADDRES_PROP"])){ echo $province_list[$vendor_detail["ADDRES_PROP"]];} else { echo $vendor_detail["ADDRES_PROP"];} ?>">
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="form-group">
                                            <label for="address_city" class="col-sm-3 control-label">Kota</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="address_city" disabled="disabled" name="address_city" value="<?php echo $vendor_detail["ADDRESS_CITY"] ?>">
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    <div class="form-group">
                                        <label for="address_postcode" class="col-sm-3 control-label">Kode Pos</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="address_postcode" disabled="disabled" name="address_postcode" value="<?php echo set_value('address_postcode', $vendor_detail["ADDRESS_POSTCODE"]); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="city" class="col-sm-3 control-label">Negara</label>
                                        <div class="col-sm-3">
                                            <?php echo form_dropdown('address_country', $country, $vendor_detail["ADDRESS_COUNTRY"], 'disabled="disabled" class="form-control"'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_update_legal_data',array('class' => 'form-horizontal legal_form')); ?>
                            <?php $container = 'NPWP'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    NPWP
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                    <?php foreach ($cek_vend as $ck_vendor) {
                                    if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                        <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/legal_data'); ?>">Edit Data</a>
                                    <?php } else { ?>
                                        <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                    <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                    <div class="form-group">
                                        <label for="npwp_no" class="col-sm-3 control-label">No.</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="npwp_no" disabled="disabled" name="npwp_no" value="<?php echo set_value('npwp_no', $vendor_detail["NPWP_NO"]); ?>">
                                        </div>
                                        <div class="col-sm-3">
                                            <?php
                                            if (!empty($vendor_detail["NPWP_NO_DOC"])) { ?>
                                                <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Vendor_update_profile')."/viewDok/".$vendor_detail["NPWP_NO_DOC"]; ?>" title="File Attachment">File Attachment</a></span></label>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_address" class="col-sm-3 control-label">Alamat (Sesuai NPWP)</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="npwp_address" disabled="disabled" name="npwp_address" value="<?php echo set_value('npwp_address', $vendor_detail["NPWP_ADDRESS"]); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="npwp_prop" class="col-sm-3 control-label">Propinsi</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="npwp_prop" disabled="disabled" name="npwp_prop" value="<?php if(is_numeric($vendor_detail["NPWP_PROP"])){echo $province_list[$vendor_detail["NPWP_PROP"]];}else{echo $vendor_detail["NPWP_PROP"];}  ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_city" class="col-sm-3 control-label">Kota</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="npwp_city" disabled="disabled" name="npwp_city" value="<?php if(!is_numeric($vendor_detail["NPWP_CITY"]) || $vendor_detail["NPWP_CITY"] == '0'){ echo $vendor_detail["NPWP_CITY"];} else { echo $city_list[$vendor_detail["NPWP_CITY"]]; } ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_postcode" class="col-sm-3 control-label">Kode Pos</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="npwp_postcode" disabled="disabled" name="npwp_postcode" value="<?php echo set_value('npwp_postcode', $vendor_detail["NPWP_POSTCODE"]); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_update_legal_data',array('class' => 'form-horizontal legal_form')); ?>
                            <?php $container = 'PKP'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    PKP
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/legal_data'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                    <div class="form-group">
                                        <label for="city" class="col-sm-3 control-label">PKP</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="npwp_pkp" disabled="disabled" name="npwp_pkp" value="<?php echo set_value('npwp_pkp', $vendor_detail["NPWP_PKP"]); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_pkp_no" class="col-sm-3 control-label">Nomor PKP</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="npwp_pkp_no" disabled="disabled" name="npwp_pkp_no" value="<?php echo set_value('npwp_pkp_no', $vendor_detail["NPWP_PKP_NO"]); ?>">
                                        </div>
                                        <div class="col-sm-3">
                                            <?php
                                            if (!empty($vendor_detail["PKP_NO_DOC"])) { ?>
                                                <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Vendor_update_profile')."/viewDok/".$vendor_detail["PKP_NO_DOC"]; ?>" title="File Attachment">File Attachment</a></span></label>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_update_legal_data',array('class' => 'form-horizontal legal_form')); ?>
                            <?php $container = 'SIUP'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    SIUP
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/legal_data'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                    <div class="form-group">
                                        <label for="siup_issued_by" class="col-sm-3 control-label">Dikeluarkan Oleh</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="siup_issued_by" disabled="disabled" name="siup_issued_by" value="<?php echo set_value('siup_issued_by', $vendor_detail["SIUP_ISSUED_BY"]); ?>">
                                        </div>
                                        <div class="col-sm-3">
                                            <?php
                                            if (!empty($vendor_detail["SIUP_NO_DOC"])) { ?>
                                                <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Vendor_update_profile')."/viewDok/".$vendor_detail["SIUP_NO_DOC"]; ?>" title="File Attachment">File Attachment</a></span></label>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="siup_no" class="col-sm-3 control-label">Nomor</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="siup_no" disabled="disabled" name="siup_no" value="<?php echo set_value('siup_no', $vendor_detail["SIUP_NO"]); ?>">
                                        </div>
                                        <label for="postcode" class="col-sm-2 control-label">SIUP</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="siup_type" disabled="disabled" name="siup_type" value="<?php echo set_value('siup_type', $vendor_detail["SIUP_TYPE"]); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="siup_from" class="col-sm-3 control-label">Berlaku Mulai</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" disabled="disabled" name="siup_from" class="form-control" value="<?php echo set_value('siup_from', vendorfromdate($vendor_detail["SIUP_FROM"])); ?>" value="<?php echo set_value('siup_from', $vendor_detail["SIUP_FROM"]); ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                        <label for="siup_to" class="col-sm-3 control-label">Sampai</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" disabled="disabled" name="siup_to" class="form-control" value="<?php echo set_value('siup_to', vendorfromdate($vendor_detail["SIUP_TO"])); ?>" value="<?php echo set_value('siup_to', $vendor_detail["SIUP_TO"]); ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_update_legal_data',array('class' => 'form-horizontal legal_form')); ?>
                            <?php $container = 'TDP'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    TDP
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/legal_data'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                    <div class="form-group">
                                        <label for="tdp_issued_by" class="col-sm-3 control-label">Dikeluarkan Oleh</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="tdp_issued_by" disabled="disabled" name="tdp_issued_by" value="<?php echo set_value('tdp_issued_by', $vendor_detail["TDP_ISSUED_BY"]); ?>">
                                        </div>
                                        <div class="col-sm-3">
                                            <?php
                                            if (!empty($vendor_detail["TDP_NO_DOC"])) { ?>
                                                <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Vendor_update_profile')."/viewDok/".$vendor_detail["TDP_NO_DOC"]; ?>" title="File Attachment">File Attachment</a></span></label>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tdp_no" class="col-sm-3 control-label">Nomor</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="tdp_no" disabled="disabled" name="tdp_no" value="<?php echo set_value('tdp_no', $vendor_detail["TDP_NO"]); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tdp_from" class="col-sm-3 control-label">Berlaku Mulai</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" disabled="disabled" name="tdp_from" class="form-control" value="<?php echo set_value('tdp_from', vendorfromdate($vendor_detail["TDP_FROM"])); ?>" value="<?php echo set_value('tdp_from', $vendor_detail["TDP_FROM"]); ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                </div>
                                        </div>
                                        <label for="tdp_to" class="col-sm-3 control-label">Sampai</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" disabled="disabled" name="tdp_to" class="form-control" value="<?php echo set_value('tdp_to', vendorfromdate($vendor_detail["TDP_TO"])); ?>" value="<?php echo set_value('tdp_to', $vendor_detail["TDP_TO"]); ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_update_legal_data',array('class' => 'form-horizontal legal_form api')); ?>
                            <?php $container = 'Angka Pengenal Importir'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Angka Pengenal Importir
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/legal_data'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                    <div class="form-group">
                                        <label for="api_issued_by" class="col-sm-3 control-label">Dikeluarkan Oleh</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="api_issued_by" disabled="disabled" name="api_issued_by" value="<?php echo set_value('api_issued_by', $vendor_detail["API_ISSUED_BY"]); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="api_no" class="col-sm-3 control-label">Nomor</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="api_no" disabled="disabled" name="api_no" value="<?php echo set_value('api_no', $vendor_detail["API_NO"]); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="api_from" class="col-sm-3 control-label">Berlaku Mulai</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" disabled="disabled" name="api_from" class="form-control" value="<?php echo set_value('api_from', vendorfromdate($vendor_detail["API_FROM"])); ?>" value="<?php echo set_value('api_from', $vendor_detail["API_FROM"]); ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                </div>
                                        </div>
                                        <label for="api_to" class="col-sm-3 control-label">Sampai</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" disabled="disabled" name="api_to" class="form-control" value="<?php echo set_value('api_to', vendorfromdate($vendor_detail["API_TO"])); ?>" value="<?php echo set_value('api_to', $vendor_detail["API_TO"]); ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_insert_akta_pendirian',array('class' => 'form-horizontal insert_commissioner')); ?>
                            <?php $container = 'Dewan Komisaris'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Dewan Komisaris
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/company_board'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="text" class="hidden" disabled="disabled" name="type" value="Commissioner">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="vendor_board_commissioner">
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
                                                    <td class="text-center"><?php echo $board['NAME']; ?></td>
                                                    <td class="text-center"><?php echo $board['POS']; ?></td>
                                                    <td class="text-center"><?php echo $board['TELEPHONE_NO']; ?></td>
                                                    <td class="text-center"><?php echo $board['EMAIL_ADDRESS']; ?></td>
                                                    <td class="text-center"><?php if (!empty($board['KTP_FILE'])){ ?> <a href="<?php echo base_url('Vendor_update_profile'); ?>/viewDok/<?php echo $board['KTP_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $board['KTP_NO']; ?></a> <?php } else {  echo $board['KTP_NO']; } ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($board['KTP_EXPIRED_DATE']); ?></td>
                                                    <td class="text-center"><?php echo $board['NPWP_NO']; ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_insert_akta_pendirian',array('class' => 'form-horizontal insert_director')); ?>
                            <?php $container = 'Dewan Direksi'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Dewan Direksi
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/company_board'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="text" class="hidden" disabled="disabled" name="type" value="Director">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="vendor_board_director">
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
                                                    <td class="text-center"><?php echo $board['NAME']; ?></td>
                                                    <td class="text-center"><?php echo $board['POS']; ?></td>
                                                    <td class="text-center"><?php echo $board['TELEPHONE_NO']; ?></td>
                                                    <td class="text-center"><?php echo $board['EMAIL_ADDRESS']; ?></td>
                                                    <td class="text-center"><?php if (!empty($board['KTP_FILE'])){ ?> <a href="<?php echo base_url('Vendor_update_profile'); ?>/viewDok/<?php echo $board['KTP_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $board['KTP_NO']; ?></a> <?php } else {  echo $board['KTP_NO']; } ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($board['KTP_EXPIRED_DATE']); ?></td>
                                                    <td class="text-center"><?php echo $board['NPWP_NO']; ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile',array('class' => 'form-horizontal insert_bank_data')); ?>
                            <?php $container = 'Rekening Bank'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Rekening Bank
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/bank_and_financial_data'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="vendor_bank">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No.</th>
                                                    <th class="text-center">No. Rekening</th>
                                                    <th class="text-center">Pemegang Rekening</th>
                                                    <th class="text-center">Nama Bank</th>
                                                    <th class="text-center">Cabang Bank</th>
                                                    <th class="text-center">Swift Code</th>
                                                    <th class="text-center">Alamat Bank</th>
                                                    <th class="text-center">Kode Pos Bank</th>
                                                    <th class="text-center">Mata Uang</th>
                                                    <th class="text-center">Reference Bank</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bankItem">
                                                <?php if (empty($vendor_bank)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="10" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($vendor_bank as $key => $bank) { ?>
                                                <tr id="<?php echo $bank['BANK_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $bank['ACCOUNT_NO']; ?></td>
                                                    <td class="text-center"><?php echo $bank['ACCOUNT_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $bank['BANK_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $bank['BANK_BRANCH']; ?></td>
                                                    <td class="text-center"><?php echo $bank['SWIFT_CODE']; ?></td>
                                                    <td class="text-center"><?php echo $bank['ADDRESS']; ?></td>
                                                    <td class="text-center"><?php echo $bank['BANK_POSTAL_CODE']; ?></td>
                                                    <td class="text-center"><?php echo $bank['CURRENCY']; ?></td>
                                                    <td><?php if (!empty($bank['REFERENCE_FILE'])){ ?> <a href="<?php echo base_url('Vendor_update_profile'); ?>/viewDok/<?php echo $bank['REFERENCE_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $bank['REFERENCE_BANK']; ?></a> <?php } else {  echo $bank['REFERENCE_BANK']; } ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile',array('class' => 'form-horizontal update_financial_data')); ?>
                            <?php $container = 'Modal Sesuai Dengan Akta Terakhir'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Modal Sesuai Dengan Akta Terakhir
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/bank_and_financial_data'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="fin_akta_mdl_dsr_curr" class="col-sm-3 control-label">Modal Dasar</label>
                                        <div class="col-sm-3">
                                            <?php if (!empty($vendor_detail["FIN_AKTA_MDL_DSR_CURR"])) { echo form_dropdown('fin_akta_mdl_dsr_curr', $currency, $vendor_detail["FIN_AKTA_MDL_DSR_CURR"], 'disabled="disabled" class="form-control"'); } else { echo '<input type=text disabled="disabled" class="form-control">';}?>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control text-right" id="fin_akta_mdl_dsr" disabled="disabled" name="fin_akta_mdl_dsr" value="<?php if (!empty($vendor_detail["FIN_AKTA_MDL_DSR"])) { echo set_value('fin_akta_mdl_dsr', number_format($vendor_detail["FIN_AKTA_MDL_DSR"]));} else {  echo ''; } ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fin_akta_mdl_str_curr" class="col-sm-3 control-label">Modal Disetor</label>
                                        <div class="col-sm-3">
                                            <?php if (!empty($vendor_detail["FIN_AKTA_MDL_STR_CURR"])) { echo form_dropdown('fin_akta_mdl_str_curr', $currency, $vendor_detail["FIN_AKTA_MDL_STR_CURR"], 'disabled="disabled" class="form-control"'); } else { echo '<input type=text disabled="disabled" class="form-control">';}?>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control text-right" id="fin_akta_mdl_str" disabled="disabled" name="fin_akta_mdl_str" value="<?php if(!empty($vendor_detail["FIN_AKTA_MDL_STR"])){ echo set_value('fin_akta_mdl_str', number_format($vendor_detail["FIN_AKTA_MDL_STR"]));} else{ echo ''; } ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile',array('class' => 'form-horizontal insert_financial_report')); ?>
                            <?php $container = 'Informasi Laporan Keuangan'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Informasi Laporan Keuangan
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/bank_and_financial_data'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="vendor_fin_report">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No.</th>
                                                    <th class="text-center">Tahun Laporan</th>
                                                    <th class="text-center">Jenis Laporan</th>
                                                    <th class="text-center">Valuta</th>
                                                    <th class="text-center">Nilai Aset</th>
                                                    <th class="text-center">Hutang Perusahaan</th>
                                                    <th class="text-center">Pendapatan Kotor</th>
                                                    <th class="text-center">Laba Bersih</th>
                                                </tr>
                                            </thead>
                                            <tbody id="finReportItem">
                                                <?php if (empty($vendor_fin_report)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($vendor_fin_report as $key => $report) { ?>
                                                <tr id="<?php echo $report['FIN_RPT_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $report['FIN_RPT_YEAR']; ?></td>
                                                    <td class="text-center"><?php echo $report['FIN_RPT_TYPE']; ?></td>
                                                    <td class="text-center"><?php echo $report['FIN_RPT_CURRENCY']; ?></td>
                                                    <td class="text-center"><?php echo number_format($report['FIN_RPT_ASSET_VALUE']); ?></td>
                                                    <td class="text-center"><?php echo number_format($report['FIN_RPT_HUTANG']); ?></td>
                                                    <td class="text-center"><?php echo number_format($report['FIN_RPT_REVENUE']); ?></td>
                                                    <td class="text-center"><?php echo number_format($report['FIN_RPT_NETINCOME']); ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_insert_good',array('class' => 'form-horizontal insert_good')); ?>
                            <?php $container = 'Barang dan bahan yang bisa dipasok'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Barang yang Bisa Dipasok
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/good_and_service_data'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="goods">
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
                                                </tr>
                                            </thead>
                                            <tbody id="tableItem">
                                                <?php if (empty($goods)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="11" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($goods as $key => $good) { ?>
                                                <tr id="<?php echo $good['PRODUCT_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $good['PRODUCT_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $good['PRODUCT_SUBGROUP_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $good['PRODUCT_DESCRIPTION']; ?></td>
                                                    <td class="text-center"><?php echo $good['BRAND']; ?></td>
                                                    <td class="text-center"><?php echo $good['SOURCE']; ?></td>
                                                    <td class="text-center"><?php echo $good['TYPE']; ?></td>
                                                    <td class="text-center"><?php if (!empty($good['FILE_UPLOAD'])){ ?><a href="<?php echo base_url('Vendor_update_profile'); ?>/viewDok/<?php echo $good['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $good['NO']; ?></a><?php } else {  echo $good["NO"]; } ?> </td>
                                                    <td class="text-center"><?php echo $good['ISSUED_BY']; ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($good['ISSUED_DATE']); ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($good['EXPIRED_DATE']); ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile',array('class' => 'form-horizontal insert_good')); ?>
                            <?php $container = 'Bahan yang bisa dipasok'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Bahan yang Bisa Dipasok
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/good_and_service_data'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="bahan">
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
                                                </tr>
                                            </thead>
                                            <tbody id="tableItem">
                                                <?php if (empty($bahan)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="11" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($bahan as $key => $bhn) { ?>
                                                <tr id="<?php echo $bhn['PRODUCT_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $bhn['PRODUCT_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $bhn['PRODUCT_SUBGROUP_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $bhn['PRODUCT_DESCRIPTION']; ?></td>
                                                    <td class="text-center"><?php echo $bhn['SOURCE']; ?></td>
                                                    <td class="text-center"><?php echo $bhn['TYPE']; ?></td>
                                                    <td class="text-center"><?php echo $bhn['KLASIFIKASI_NAME']; ?></td>
                                                    <td class="text-center"><?php if (!empty($bhn['FILE_UPLOAD'])){ ?><a href="<?php echo base_url('Vendor_update_profile'); ?>/viewDok/<?php echo $bhn['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $bhn['NO']; ?></a><?php } else {  echo $bhn["NO"]; } ?> </td>
                                                    <td class="text-center"><?php echo $bhn['ISSUED_BY']; ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($bhn['ISSUED_DATE']); ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($bhn['EXPIRED_DATE']); ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_insert_good',array('class' => 'form-horizontal insert_good')); ?>
                            <?php $container = 'Jasa yang bisa dipasok'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Jasa yang Bisa Dipasok
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/good_and_service_data'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="services">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Group Jasa</th>
                                                    <th class="text-center">Subgroup Jasa</th>
                                                    <th class="text-center">Klasifikasi</th>
                                                    <th class="text-center">SubKualifikasi</th>
                                                    <th class="text-center">No. Ijin</th>
                                                    <th class="text-center">Dikeluarkan</th>
                                                    <th class="text-center">Berlaku</th>
                                                    <th class="text-center">Sampai</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableItem">
                                                <?php if (empty($services)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="11" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($services as $key => $service) { ?>
                                                <tr id="<?php echo $service['PRODUCT_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $service['PRODUCT_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $service['PRODUCT_SUBGROUP_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $service['KLASIFIKASI_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $service['SUBKUALIFIKASI_NAME']; ?></td> 
                                                    <td class="text-center"><?php if (!empty($service['FILE_UPLOAD'])){ ?> <a href="<?php echo base_url('Vendor_update_profile'); ?>/viewDok/<?php echo $service['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $service['NO']; ?></a> <?php } else {  echo $service['NO']; } ?> </td>
                                                    <td class="text-center"><?php echo $service['ISSUED_BY']; ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($service['ISSUED_DATE']); ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($service['EXPIRED_DATE']); ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_insert_sdm',array('class' => 'form-horizontal insert_main_sdm')); ?>
                            <?php $container = 'Tenaga Ahli Utama'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Tenaga Ahli Utama
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/human_resources_data'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="main_sdm">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Nama</th>
                                                    <th class="text-center">Pendidikan Terakhir</th>
                                                    <th class="text-center">Keahlian Utama</th>
                                                    <th class="text-center">Pengalaman</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Kewarganegaraan</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableItem">
                                                <?php if (empty($main_sdm)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="7" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($main_sdm as $key => $sdm) { ?>
                                                <tr id="<?php echo $sdm['SDM_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $sdm['NAME']; ?></td>
                                                    <td class="text-center"><?php echo $sdm['LAST_EDUCATION']; ?></td>
                                                    <td class="text-center"><?php echo $sdm['MAIN_SKILL']; ?></td>
                                                    <td class="text-center"><?php echo $sdm['YEAR_EXP']; ?></td>
                                                    <td class="text-center"><?php echo $sdm['EMP_STATUS']; ?></td>
                                                    <td class="text-center"><?php echo $sdm['EMP_TYPE']; ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_insert_sdm',array('class' => 'form-horizontal insert_support_sdm')); ?>
                            <?php $container = 'Tenaga Ahli Pendukung'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Tenaga Ahli Pendukung
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/human_resources_data'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="support_sdm">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Nama</th>
                                                    <th class="text-center">Pendidikan Terakhir</th>
                                                    <th class="text-center">Keahlian Utama</th>
                                                    <th class="text-center">Pengalaman</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Kewarganegaraan</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableItem">
                                                <?php if (empty($support_sdm)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="7" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($support_sdm as $key => $sdm) { ?>
                                                <tr id="<?php echo $sdm['SDM_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $sdm['NAME']; ?></td>
                                                    <td class="text-center"><?php echo $sdm['LAST_EDUCATION']; ?></td>
                                                    <td class="text-center"><?php echo $sdm['MAIN_SKILL']; ?></td>
                                                    <td class="text-center"><?php echo $sdm['YEAR_EXP']; ?></td>
                                                    <td class="text-center"><?php echo $sdm['EMP_STATUS']; ?></td>
                                                    <td class="text-center"><?php echo $sdm['EMP_TYPE']; ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_insert_certifications',array('class' => 'form-horizontal insert_certifications')); ?>
                            <?php $container = 'Keterangan Sertifikat'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Keterangan Sertifikat
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/certification_data'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="certifications">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Jenis</th>
                                                    <th class="text-center">Nama Sertifikat</th>
                                                    <th class="text-center">Nomor Sertifikat</th>
                                                    <th class="text-center">Dikeluarkan Oleh</th>
                                                    <th class="text-center">Berlaku Mulai</th>
                                                    <th class="text-center">Sampai</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableItem">
                                                <?php if (empty($certifications[0]['CERT_NAME'])) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($certifications as $key => $certifications) { ?>
                                                <tr id="<?php echo $certifications['CERT_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center">
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
                                                    <td class="text-center"><?php echo $certifications['CERT_NAME']; ?></td>
                                                    <td class="text-center">
                                                        <?php if (isset($certifications['CERT_NO_DOC'])) { ?>
                                                        <a target="_blank" href="<?php echo base_url('Vendor_update_profile') ?>/viewDok/<?php echo $certifications['CERT_NO_DOC']; ?>"><?php echo $certifications['CERT_NO']; ?></a>
                                                        <?php } else {?>
                                                        <?php echo $certifications['CERT_NO']; ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-center"><?php echo $certifications['ISSUED_BY']; ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($certifications['VALID_FROM']); ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($certifications['VALID_TO']); ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_insert_equipments',array('class' => 'form-horizontal insert_equipments')); ?>
                            <?php $container = 'Keterangan Tentang Fasilitas dan Peralatan'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Keterangan Tentang Fasilitas dan Peralatan
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/facility_and_equipment'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="equipments">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Kategori</th>
                                                    <th class="text-center">Nama Peralatan</th>
                                                    <th class="text-center">Spesifikasi</th>
                                                    <th class="text-center">Kuantitas</th>
                                                    <th class="text-center">Tahun Pembuatan</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableItem">
                                                <?php 
                                                if (empty($equipments[0]['CATEGORY'])) { ?>
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
                                                    <td class="text-center"><?php
                                                            if ($equipment['CATEGORY'] != '') {
                                                                echo $tools_category[$equipment['CATEGORY']]; 
                                                            }
                                                     ?></td>
                                                    <td class="text-center"><?php echo $equipment['EQUIP_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $equipment['SPEC']; ?></td>
                                                    <td class="text-center"><?php echo $equipment['QUANTITY']; ?></td>
                                                    <td class="text-center"><?php echo $equipment['YEAR_MADE']; ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_insert_experiences',array('class' => 'form-horizontal insert_experiences')); ?>
                            <?php $container = 'Pekerjaan'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Pengalaman Perusahaan
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/company_experience'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="experiences">
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
                                                </tr>
                                            </thead>
                                            <tbody id="tableItem">
                                                <?php if (empty($experiences[0]['CLIENT_NAME'])) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="12" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($experiences as $key => $experience) { ?>
                                                <tr id="<?php echo $experience['CV_ID']; ?>">
                                                    <td><?php echo $no++; ?></td>
                                                    <td>
                                                        <?php if (isset($experience['CLIENT_NAME_DOC'])) { ?>
                                                        <a target="_blank" href="<?php echo base_url('Vendor_update_profile') ?>/viewDok/<?php echo $experience['CLIENT_NAME_DOC']; ?>"><?php echo $experience['CLIENT_NAME']; ?></a>
                                                        <?php } else {?>
                                                        <?php echo $experience['CLIENT_NAME']; ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-center"><?php echo $experience['PROJECT_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $experience['DESCRIPTION']; ?></td>
                                                    <td class="text-center"><?php echo $experience['CURRENCY']; ?></td>
                                                    <td class="text-center"><?php echo number_format($experience['AMOUNT']); ?></td>
                                                    <td class="text-center"><?php echo $experience['CONTRACT_NO']; ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($experience['START_DATE']); ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($experience['END_DATE']); ?></td>
                                                    <td class="text-center"><?php echo $experience['CONTACT_PERSON']; ?></td>
                                                    <td class="text-center"><?php echo $experience['CONTACT_NO']; ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_insert_principal',array('class' => 'form-horizontal insert_principal')); ?>
                            <?php $container = 'Principal'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Principal
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/additional_document'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="principals">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Nama</th>
                                                    <th class="text-center">Alamat</th>
                                                    <th class="text-center">Kota</th>
                                                    <th class="text-center">Negara</th>
                                                    <th class="text-center">Kode Pos</th>
                                                    <th class="text-center">Kualifikasi</th>
                                                    <th class="text-center">Hubungan Kerjasama</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableItem">
                                                <?php if (empty($principals)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($principals as $key => $principal) { ?>
                                                <tr id="<?php echo $principal['ADD_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $principal['NAME']; ?></td>
                                                    <td class="text-center"><?php echo $principal['ADDRESS']; ?></td>
                                                    <td class="text-center"><?php echo $principal['CITY']; ?></td>
                                                    <td class="text-center"><?php echo $principal['COUNTRY']; ?></td>
                                                    <td class="text-center"><?php echo $principal['POST_CODE']; ?></td>
                                                    <td class="text-center"><?php echo $principal['QUALIFICATION']; ?></td>
                                                    <td class="text-center"><?php echo $principal['RELATIONSHIP']; ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            
                            <?php echo form_open('Vendor_update_profile/do_insert_subcontractor',array('class' => 'form-horizontal insert_subcontractor')); ?>
                            <?php $container = 'Subkontraktor'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Subkontraktor
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/additional_document'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="subcontractors">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Nama</th>
                                                    <th class="text-center">Alamat</th>
                                                    <th class="text-center">Kota</th>
                                                    <th class="text-center">Negara</th>
                                                    <th class="text-center">Kode Pos</th>
                                                    <th class="text-center">Kualifikasi</th>
                                                    <th class="text-center">Hubungan Kerjasama</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableItem">
                                                <?php if (empty($subcontractors)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($subcontractors as $key => $subcontractor) { ?>
                                                <tr id="<?php echo $subcontractor['ADD_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $subcontractor['NAME']; ?></td>
                                                    <td class="text-center"><?php echo $subcontractor['ADDRESS']; ?></td>
                                                    <td class="text-center"><?php echo $subcontractor['CITY']; ?></td>
                                                    <td class="text-center"><?php echo $subcontractor['COUNTRY']; ?></td>
                                                    <td class="text-center"><?php echo $subcontractor['POST_CODE']; ?></td>
                                                    <td class="text-center"><?php echo $subcontractor['QUALIFICATION']; ?></td>
                                                    <td class="text-center"><?php echo $subcontractor['RELATIONSHIP']; ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo form_open('Vendor_update_profile/do_insert_affiliation_company',array('class' => 'form-horizontal insert_affiliation_company')); ?>
                            <?php $container = 'Perusahaan Afiliasi'; ?>
                            <div class="panel <?php if (!isset($progress_status[$container])) { echo 'panel-default'; } else if ($progress_status[$container]['STATUS'] == 'Rejected') { echo 'panel-danger'; } else if ($progress_status[$container]['STATUS'] == 'Edited') {  echo 'panel-warning'; } else { echo 'panel-success'; } ?>">
                                <div class="panel-heading">
                                    Perusahaan Afiliasi
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right">
                                        <strong>
                                        <?php foreach ($cek_vend as $ck_vendor) {
                                        if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                            <a class="btn btn-default btn-sm <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : ''?>" href="<?php echo site_url('Vendor_update_profile/additional_document'); ?>">Edit Data</a>
                                        <?php } else { ?>
                                            <a class="btn btn-default btn-sm hidden" href="#">Edit Data</a>
                                        <?php } } ?>
                                        </strong>
                                    </span>
                                </div>
                                <input type="text" class="hidden" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="affiliation_companies">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Nama</th>
                                                    <th class="text-center">Alamat</th>
                                                    <th class="text-center">Kota</th>
                                                    <th class="text-center">Negara</th>
                                                    <th class="text-center">Kode Pos</th>
                                                    <th class="text-center">Kualifikasi</th>
                                                    <th class="text-center">Hubungan Kerjasama</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableItem">
                                                <?php if (empty($affiliation_companies)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($affiliation_companies as $key => $affiliation_company) { ?>
                                                <tr id="<?php echo $affiliation_company['ADD_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $affiliation_company['NAME']; ?></td>
                                                    <td class="text-center"><?php echo $affiliation_company['ADDRESS']; ?></td>
                                                    <td class="text-center"><?php echo $affiliation_company['CITY']; ?></td>
                                                    <td class="text-center"><?php echo $affiliation_company['COUNTRY']; ?></td>
                                                    <td class="text-center"><?php echo $affiliation_company['POST_CODE']; ?></td>
                                                    <td class="text-center"><?php echo $affiliation_company['QUALIFICATION']; ?></td>
                                                    <td class="text-center"><?php echo $affiliation_company['RELATIONSHIP']; ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-group">
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                          <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#collapse1">Komentar Vendor</a>
                                          </h4>
                                    </div>
                                    <div id="collapse1" class="panel-collapse collapse"> 
                                        <div class="table-responsive">
                                            <table class="table table-hover margin-bottom-20" id="id_comment">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <!-- <th class="text-center">Nama</th> -->
                                                        <th class="text-center">Aktivitas</th>
                                                        <th class="text-center">Tanggal</th>
                                                        <th class="text-center">Komentar</th>
                                                    </tr>
                                                </thead>
                                                    <tbody id="tableItem">
                                                        <?php
                                                         if (empty($ven_comment)) { ?>
                                                            <tr id="empty_row">
                                                                <td colspan="8" class="text-center">- Belum ada komentar -</td>
                                                            </tr>
                                                        <?php } else { $no = 1; foreach ($ven_comment as $key => $ven_com) { ?>
                                                            <tr id="<?php echo $ven_com['ID']; ?>">
                                                                <td class="text-center"><?php echo $no++; ?></td>
                                                                <!-- <td class="text-center"><?php echo $ven_com['EMP_NAMA']; ?></td> -->
                                                                <td class="text-center"><?php echo $ven_com['STATUS_ACTIVITY']; ?></td>
                                                                <td class="text-center"><?php echo vendorfromdate($ven_com['DATE_COMMENT']); ?></td>
                                                                <td class="text-center"><?php echo $ven_com['COMMENT']; ?></td>
                                                            </tr>
                                                                <?php } } ?>
                                                    </tbody>
                                            </table>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="panel panel-warning">
                                <div class="panel-heading">Komentar Anda</div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <tr>
                                            <td class="col-md-3">Komentar</td>
                                            <td class="col-md-1 text-right">:</td>
                                            <td><textarea class="form-control" name="comment" id="comment" /></textarea></td>

                                        </tr> 
                                    </table>
                                </div>
                            </div>
                            <hr>
                    <div class="col-sm-12 alert alert-info" role="alert">
                        <strong>Pernyataan Keabsahan Data.</strong> Kami menyatakan bahwa data yang kami input adalah benar data perusahaan kami, dan apabila di kemudian hari kami mengingkari pernyataan di atas atau ditemui bahwa keterangan/data perusahaan yang kami berikan tidak benar, maka kami bersedia dituntut di muka pengadilan dan bersedia dikeluarkan dari daftar vendor serta dimasukkan dalam daftar hitam (black list) eProcurement PT Semen Indonesia (Persero) Tbk.
                    </div> 
                            <?php echo form_close(); ?>
                            <div class="panel panel-info">
                                <div class="panel-body text-center">
                                    <a href="<?php echo base_url(); ?>" class="main_button small_btn">Cancel</a>
                                    <?php foreach ($cek_vend as $ck_vendor) {
                                    if ($ck_vendor['STATUS_PERUBAHAN'] == 0 || $ck_vendor['STATUS_PERUBAHAN'] == 1 || $ck_vendor['STATUS_PERUBAHAN'] == 10) { ?>
                                        <a href="#finish-popup" class="main_button color1 small_btn popup-with-move-anim" type="button">Save & Finish</a>
                                    <?php } else { ?>
                                        <a href="#alert_save" class="main_button color1 small_btn popup-with-move-anim" type="button">Save & Finish</a>
                                    <?php } } ?>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>

            <div class="zoom-anim-dialog large-dialog mfp-hide" id="finish-popup">
                <div class="modal-header">
                    <h4 class="modal-title">Perhatian!</h4>
                </div>
                <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
                    <p class="text-justify">Apakah anda yakin data sudah benar?</p>
                   
                </div>
                <div class="modal-footer text-center">
                    <!-- <form action="" method="POST"> -->
                        <input type="button" id="closeModal" class="main_button small_btn bottom_space" value="Tidak">
                        <button class="main_button color1 small_btn bottom_space" id="finish_registration_button">Ya</button>
                        <input type="text" class="hidden" disabled="disabled" name="vendor_id" class="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                    <!-- </form> -->
                </div>
            </div>
            <div class="zoom-anim-dialog large-dialog mfp-hide" id="alert_save">
                <div class="modal-header">
                    <h4 class="modal-title">Perhatian!</h4>
                </div>
                <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
                    <p class="text-justify">Anda sudah melakukan perubahan data.</p>
                    <p class="text-justify">Data anda sedang proses approval oleh pihak Semen Indonesia Group (SIG)</p>
                   
                </div>
                <div class="modal-footer text-center">
                        <input type="button" id="closeModal2" class="main_button color2 small_btn bottom_space" value="Tutup">
                </div>
            </div>
		</section>
        <script type="text/javascript">
            $('#closeModal').on( "click", function() {
                $.magnificPopup.close();
            });

            $('#closeModal2').on( "click", function() {
                $.magnificPopup.close();
            });

            $('#finish_registration_button').on( "click", function() {
                var cm = $('#comment').val();
                // alert(cm);
                $.ajax({
                    url : 'do_finish_register',
                    method : 'post',
                    data : "comment="+cm,
                    success : function(result)
                    {
                        url = 'data_vendor';
                        window.location.href = url;
                    }
                });
                
            });

        </script>
        <section class="content_section">
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title;?></h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-horizontal">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Info Perusahaan 
                                        <span class="pull-right"></span>
                                    </div>
                                    <div class="panel-body">
                                        <input type="hidden" class="hidden" readonly="" name="vendor_id" value="">
                                        <div class="form-group">
                                            <label for="prefix" class="col-sm-3 control-label">Awalan (Prefix)</label>
                                            <div class="col-sm-2">
                                                 <input type="text" class="form-control" id="company_name" readonly="" name="company_name" value="<?php echo $presuf['PREFIX_NAME'];?>">
                                            </div>
                                        </div>
                                
                                        <div class="form-group">
                                            <label for="company_name" class="col-sm-3 control-label">Nama Perusahaan</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="company_name" readonly="" name="company_name" value="<?php echo $ven['VENDOR_NAME']?>">
                                            </div>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="suffix" class="col-sm-3 control-label">Akhiran (Suffix)</label>
                                            <div class="col-sm-2">
                                             <input type="text" class="form-control" id="company_name" readonly="" name="company_name" value="<?php echo $presuf['SUFFIX_NAME']?>">
                                               
                                            </div>
                                        </div>
                                   
                                        <div class="form-group">
                                            <label for="vendor_type" class="col-sm-3 control-label">Tipe Vendor</label>
                                            <div class="col-sm-4">
                                                 <input type="text" class="form-control" id="company_name" readonly="" name="company_name" value="<?php echo $ven['VENDOR_TYPE']?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="vendor_type" class="col-sm-3 control-label">Username Vendor</label>
                                            <div class="col-sm-4">
                                                 <input type="text" class="form-control" id="company_name" readonly="" name="company_name" value="<?php echo $ven['LOGIN_ID']?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="vendor_type" class="col-sm-3 control-label">Email Vendor</label>
                                            <div class="col-sm-4">
                                                 <input type="text" class="form-control" id="company_name" readonly="" name="company_name" value="<?php echo $presuf['EMAIL_ADDRESS']?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           <div cass="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Alamat Perusahaan
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"></span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value="">
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
                                              <?php if ($company_address[0]['ADDRESS_ID'] == '') { ?>
                                                <tr id="empty_row">
                                                    <td colspan="11" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($company_address as $key => $address) { 
                                                    if ($address['COUNTRY'] == 'INDONESIA') {
                                                        $ngr = 'INDONESIA';
                                                    } else {
                                                        $ngr = $country[$address['COUNTRY']];
                                                    }
                                                        ?>
                                                <tr id="<?php echo $address['ADDRESS_ID']; ?>">
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $address['TYPE']; ?></td>
                                                    <td><?php echo $address['ADDRESS']; ?></td>
                                                    <td><?php if (is_numeric($address['CITY'])){  echo $city_list[$address['CITY']];} else { echo ucwords(strtolower($address['CITY']));  } ?></td>
                                                    <td><?php echo $ngr; ?></td>
                                                    <td><?php echo $address['POST_CODE']; ?></td>
                                                    <td><?php echo $address['TELEPHONE1_NO']; ?></td>
                                                    <td><?php echo $address['TELEPHONE2_NO']; ?></td>
                                                    <td><?php echo $address['FAX']; ?></td>
                                                    <td><?php echo $address['WEBSITE']; ?></td>
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
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Kontak Perusahaan
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"></span>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="contact_name">Nama Lengkap</label>
                                            <div class="col-sm-7">
                                                <input id="contact_name" class="form-control" type="text" value="<?php echo $ven['CONTACT_NAME']?>" name="contact_name" readonly="">
                                            </div>
                                    </div>
                                
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="contact_pos">Jabatan</label>
                                            <div class="col-sm-4">
                                                <input id="contact_pos" class="form-control" type="text" value="<?php echo $ven['CONTACT_POS'] ?>" name="contact_pos" readonly="">
                                            </div>
                                    </div>
                               
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-sm-6 control-label" for="contact_phone_no">No. Telp</label>
                                                <div class="col-sm-6">
                                                    <input id="contact_phone_no" class="form-control" type="text" value="<?php echo $ven['CONTACT_PHONE_NO']?>" name="contact_phone_no" readonly="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="contact_phone_no">No. HP</label>
                                                <div class="col-sm-6">
                                                    <input id="contact_phone_hp" class="form-control" type="text" value="<?php echo $ven['CONTACT_PHONE_HP']?>" name="contact_phone_hp" readonly="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="contact_email">Email</label>
                                            <div class="col-sm-6">
                                                <input id="contact_email" class="form-control" type="text" value="<?php echo $ven['CONTACT_EMAIL'] ?>" name="contact_email" readonly="">
                                            </div>
                                    </div>
                                </div>
                            </div>
                                                           
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Akta Pendirian
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"></span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value="">
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
                                                <?php if (empty($akta)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="11" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php } else { $no = 1;
                                                foreach ($akta as $key => $akta) { ?>
                                                <tr id="<?php echo $akta['AKTA_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center">
                                                        <?php if (!empty($akta["AKTA_NO_DOC"])){ ?>
                                                          <a target="_blank" href="<?php echo base_url('Vendor_list') ?>/viewDok/<?php echo $akta['AKTA_NO_DOC']; ?>"><?php echo $akta['AKTA_NO']; ?> </a>
                                                        <?php } else { ?>
                                                            <?php echo $akta["AKTA_NO"];?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-center"><?php echo $akta['AKTA_TYPE']; ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($akta['DATE_CREATION']); ?></td>
                                                    <td class="text-center"><?php echo $akta['NOTARIS_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $akta['NOTARIS_ADDRESS']; ?></td>
                                                    <td class="text-center">
                                                        <?php if (!empty($akta["PENGESAHAN_HAKIM_DOC"])){ ?>
                                                            <a target="_blank" href="<?php echo base_url('Vendor_list') ?>/viewDok/<?php echo $akta['PENGESAHAN_HAKIM_DOC']; ?>"><?php echo vendorfromdate($akta['PENGESAHAN_HAKIM']); ?></a>
                                                         <?php } else {   echo vendorfromdate($akta['PENGESAHAN_HAKIM']); } ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if (!empty($akta["BERITA_ACARA_NGR_DOC"])){ ?>
                                                            <a target="_blank" href="<?php echo base_url('Vendor_list') ?>/viewDok/<?php echo $akta['BERITA_ACARA_NGR_DOC']; ?>"><?php echo vendorfromdate($akta['BERITA_ACARA_NGR']); ?></a>
                                                         <?php } else {  echo vendorfromdate($akta['BERITA_ACARA_NGR']); } ?>
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

                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Domisili Perusahaan
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"></span>
                                </div>
                                <div class="panel-body">
                                    <input type="text" class="hidden" readonly="" name="vendor_id" value="">
                                        <div class="form-group">
                                            <label for="address_domisili_no" class="col-sm-3 control-label">Nomor Domisili</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="address_domisili_no" readonly="" name="address_domisili_no" value="<?php echo $domisili['ADDRESS_DOMISILI_NO']?>">
                                            </div>
                                            <div class="col-sm-3">
                                                <?php
                                                if (!empty($domisili["DOMISILI_NO_DOC"])) { ?>
                                                    <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Vendor_list')."/viewDok/".$domisili["DOMISILI_NO_DOC"]; ?>" title="File Attachment">File Attachment</a></span></label>
                                                <?php
                                                } ?>
                                            </div>
                                        </div>
                                 
                                        <div class="form-group">
                                            <label for="address_domisili_date" class="col-sm-3 control-label">Tanggal Domisili</label>
                                            <div class="col-sm-3 date">
                                                <div class="input-group date">
                                                    <input type="text" readonly="" name="address_domisili_date" class="form-control" value="<?php echo $domisili['DOMISILI_DATE']?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                   
                                        <div class="form-group">
                                            <label for="address_domisili_exp_date" class="col-sm-3 control-label">Domisili Kadaluarsa</label>
                                            <div class="col-sm-3 end">
                                                <div class="input-group date">
                                                    <input type="text" readonly="" name="address_domisili_exp_date" class="form-control" value="<?php echo $domisili['ADDRESS_DOMISILI_EXP_DATE']?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                     
                                        <div class="form-group">
                                            <label for="address_street" class="col-sm-3 control-label">Alamat Perusahaan</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="address_street" readonly="" name="address_street" value="<?php echo $domisili['ADDRESS_STREET']?>">
                                            </div>
                                        </div>
                               
                                    <?php if($domisili["ADDRESS_COUNTRY"] == "ID"): ?>
                                        <div class="form-group">
                                            <label for="address_city" class="col-sm-3 control-label">Kota</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="address_city" readonly="" name="address_city" value="<?php echo $city_list[$domisili["ADDRESS_CITY"]] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="addres_prop" class="col-sm-3 control-label">Propinsi</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="addres_prop" readonly="" name="addres_prop" value="<?php if($domisili["ADDRES_PROP"] != ''){ echo $province_list[$domisili["ADDRES_PROP"]];} else { echo $domisili["ADDRES_PROP"];} ?>">
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="form-group">
                                            <label for="address_city" class="col-sm-3 control-label">Kota</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="address_city" readonly="" name="address_city" value="<?php echo $domisili["ADDRESS_CITY"] ?>">
                                            </div>
                                        </div>
                                    <?php endif ?>

                                    <div class="form-group">
                                        <label for="address_postcode" class="col-sm-3 control-label">Kode Pos</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="address_postcode" readonly="" name="address_postcode" value="<?php echo $domisili['ADDRESS_POSTCODE']?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="country" class="col-sm-3 control-label">Negara</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="country" readonly="" name="country" value="<?php echo $domisili['COUNTRY_NAME']?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    NPWP
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"></span>
                                </div>
                                <div class="panel-body">
                                    <input type="text" class="hidden" readonly="" name="vendor_id" value="">
                                    <div class="form-group">
                                        <label for="npwp_no" class="col-sm-3 control-label">No.</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="npwp_no" readonly="" name="npwp_no" value="<?php echo $npwp['NPWP_NO']?>">
                                        </div>
                                        <div class="col-sm-3">
                                            <?php
                                            if (!empty($npwp["NPWP_NO_DOC"])) { ?>
                                                <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Vendor_list')."/viewDok/".$npwp["NPWP_NO_DOC"]; ?>" title="File Attachment">File Attachment</a></span></label>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_address" class="col-sm-3 control-label">Alamat (Sesuai NPWP)</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="npwp_address" readonly="" name="npwp_address" value="<?php echo $npwp['NPWP_ADDRESS']?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="npwp_city" class="col-sm-3 control-label">Kota</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="npwp_city" readonly="" name="npwp_city" value="<?php if($npwp["NPWP_CITY"] != ''){ echo $city_list[$npwp["NPWP_CITY"]];} else { echo $npwp["NPWP_CITY"];} ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp_prop" class="col-sm-3 control-label">Propinsi</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="npwp_prop" readonly="" name="npwp_prop" value="<?php if($npwp["NPWP_PROP"] != ''){echo $province_list[$npwp["NPWP_PROP"]];}else{echo $npwp["NPWP_PROP"];}  ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="npwp_postcode" class="col-sm-3 control-label">Kode Pos</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="npwp_postcode" readonly="" name="npwp_postcode" value="<?php echo $npwp['NPWP_POSTCODE']?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-horizontal">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        PKP
                                        <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                        <span class="pull-right"></span>
                                    </div>
                                    <div class="panel-body">
                                        <input type="text" class="hidden" readonly="" name="vendor_id" value="">
                                        <div class="form-group">
                                            <label for="city" class="col-sm-3 control-label">PKP<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="pkp_id" readonly="" name="pkp_id" value="<?php echo $ven['NPWP_PKP']?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="npwp_pkp_no" class="col-sm-3 control-label">Nomor PKP<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="npwp_pkp_no" readonly="" name="npwp_pkp_no" value="<?php echo $ven['NPWP_PKP_NO']?>">
                                            </div>
                                            <div class="col-sm-3">
                                                <?php
                                                if (!empty($ven["PKP_NO_DOC"])) { ?>
                                                    <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Vendor_list')."/viewDok/".$ven["PKP_NO_DOC"]; ?>" title="File Attachment">File Attachment</a></span></label>
                                                <?php
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    SIUP 
                                    <span class="pull-right"></span>
                                </div>
                                <div class="panel-body">
                                    <input type="text" class="hidden" readonly="" name="vendor_id" value="">
                                    <div class="form-group">
                                        <label for="siup_issued_by" class="col-sm-3 control-label">Dikeluarkan Oleh</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="siup_issued_by" readonly="" name="siup_issued_by" value="<?php echo $valven['SIUP_ISSUED_BY']?>">
                                        </div>
                                        <div class="col-sm-3">
                                           <?php
                                            if (!empty($valven["SIUP_NO_DOC"])) { ?>
                                                <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Vendor_list')."/viewDok/".$valven["SIUP_NO_DOC"]; ?>" title="File Attachment">File Attachment</a></span></label>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="siup_no" class="col-sm-3 control-label">Nomor</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="siup_no" readonly="" name="siup_no" value="<?php echo $valven['SIUP_NO']?>">
                                        </div>
                                        <label for="postcode" class="col-sm-3 control-label">SIUP</label>
                                        <div class="col-sm-3">
                                             <input type="text" class="form-control" id="siup" readonly="" name="siup" value="<?php echo $valven['SIUP_TYPE']?>">
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="siup_from" class="col-sm-3 control-label">Berlaku Mulai</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" readonly="" name="siup_from" class="form-control" value="<?php echo $valven['SIUP_FROM']?>" ><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                        <label for="siup_to" class="col-sm-3 control-label">Sampai</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" readonly="" name="siup_to" class="form-control" value="<?php echo $valven['SIUP_TO']?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    TDP
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"></span>
                                </div>
                                <div class="panel-body">
                                    <input type="text" class="hidden" readonly="" name="vendor_id" value="">
                                    <div class="form-group">
                                        <label for="tdp_issued_by" class="col-sm-3 control-label">Dikeluarkan Oleh</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="tdp_issued_by" readonly="" name="tdp_issued_by" value="<?php echo $valven['TDP_ISSUED_BY']?>">
                                        </div>
                                        <div class="col-sm-3">
                                          <?php
                                            if (!empty($valven["TDP_NO_DOC"])) { ?>
                                                <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Vendor_list')."/viewDok/".$valven["TDP_NO_DOC"]; ?>" title="File Attachment">File Attachment</a></span></label>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tdp_no" class="col-sm-3 control-label">Nomor</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="tdp_no" readonly="" name="tdp_no" value="<?php echo $valven['TDP_NO']?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tdp_from" class="col-sm-3 control-label">Berlaku Mulai</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" readonly="" name="tdp_from" class="form-control" value="<?php echo $valven['TDP_FROM']?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                </div>
                                        </div>
                                        <label for="tdp_to" class="col-sm-3 control-label">Sampai</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" readonly="" name="tdp_to" class="form-control" value="<?php echo $valven['TDP_TO']?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Angka Pengenal Importir
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"> </span>
                                </div>
                                <div class="panel-body">
                                    <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
                                    <div class="form-group">
                                        <label for="api_issued_by" class="col-sm-3 control-label">Dikeluarkan Oleh</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="api_issued_by" readonly="" name="api_issued_by" value="<?php echo $valven['API_ISSUED_BY']?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="api_no" class="col-sm-3 control-label">Nomor</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="api_no" readonly="" name="api_no" value="<?php echo $valven['API_NO']?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="api_from" class="col-sm-3 control-label">Berlaku Mulai</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" readonly="" name="api_from" class="form-control" value="<?php echo $valven['API_FROM']?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                </div>
                                        </div>
                                        <label for="api_to" class="col-sm-3 control-label">Sampai</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" readonly="" name="api_to" class="form-control" value="<?php echo $valven['API_TO']?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Dewan Komisaris
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"></span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
                                <input type="text" class="hidden" readonly="" name="type" value="Commissioner">
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
                                                    <?php if (empty($info_komisaris)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                    <?php } else { $no = 1;
                                                    foreach ($info_komisaris as $key => $dewankom) { ?>
                                                <tr id="<?php echo $dewankom['BOARD_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $dewankom['NAME']; ?></td>
                                                    <td class="text-center"><?php echo $dewankom['POS']; ?></td>
                                                    <td class="text-center"><?php echo $dewankom['TELEPHONE_NO']; ?></td>
                                                    <td class="text-center"><?php echo $dewankom['EMAIL_ADDRESS']; ?></td>
                                                    <td class="text-center"><?php echo $dewankom['KTP_NO']; ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($dewankom['KTP_EXPIRED_DATE']); ?></td>
                                                    <td class="text-center"><?php echo $dewankom['NPWP_NO']; ?></td>
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
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Dewan Direksi
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"> </span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
                                <input type="text" class="hidden" readonly="" name="type" value="Director">
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
                                              <?php if (empty($info_director)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($info_director as $key => $board) { ?>
                                                <tr id="<?php echo $board['BOARD_ID']; ?>">
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $board['NAME']; ?></td>
                                                    <td><?php echo $board['POS']; ?></td>
                                                    <td><?php echo $board['TELEPHONE_NO']; ?></td>
                                                    <td><?php echo $board['EMAIL_ADDRESS']; ?></td> 
                                                    <td><?php if (!empty($board['KTP_FILE'])){ ?> <a href="<?php echo base_url('Vendor_list'); ?>/viewDok/<?php echo $board['KTP_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $board['KTP_NO']; ?></a> <?php } else {  echo $board['KTP_NO']; } ?></td>

                                                    <td class="text-center"><?php echo vendorfromdate($board['KTP_EXPIRED_DATE']); ?></td>
                                                    <td><?php echo $board['NPWP_NO']; ?></td>
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
                           
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Rekening Bank
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"> </span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
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
                                              <?php if (empty($bank_vendor)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($bank_vendor as $key => $bank) { ?>
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
                                                    <td class="text-center"><?php if (!empty($bank['REFERENCE_FILE'])){ ?> <a href="<?php echo base_url('Vendor_list'); ?>/viewDok/<?php echo $bank['REFERENCE_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $bank['REFERENCE_BANK']; ?></a> <?php } else {  echo $bank['REFERENCE_BANK']; } ?></td>

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
                        <div cass=""></div>
                            <div class="panel panel-default ">
                                <div class="panel-heading">
                                    Modal Sesuai Dengan Akta Terakhir
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right" </span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="fin_akta_mdl_dsr_curr" class="col-sm-3 control-label">Modal Dasar</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-right" id="fin_akta_mdl_dsr_curr" readonly="" name="fin_akta_mdl_dsr_curr" value="<?php echo $ven['FIN_AKTA_MDL_DSR_CURR']?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control text-right" id="fin_akta_mdl_dsr" readonly="" name="fin_akta_mdl_dsr" value="<?php echo number_format($ven['FIN_AKTA_MDL_DSR'])?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fin_akta_mdl_str_curr" class="col-sm-3 control-label">Modal Disetor</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-right" id="fin_akta_mdl_str_curr" readonly="" name="fin_akta_mdl_str_curr" value="<?php echo $ven['FIN_AKTA_MDL_STR_CURR']?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control text-right" id="fin_akta_mdl_str" readonly="" name="fin_akta_mdl_str" value="<?php echo number_format($ven['FIN_AKTA_MDL_STR'])?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Informasi Laporan Keuangan
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"> </span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
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
                                                <?php if (empty($fin)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($fin as $key => $report) { ?>
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
                        </div>
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Barang yang Bisa Dipasok
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"> </span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
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
                                                 <?php if (empty($product)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="11" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($product as $key => $good) { ?>
                                                <tr id="<?php echo $good['PRODUCT_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $good['PRODUCT_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $good['PRODUCT_SUBGROUP_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $good['PRODUCT_DESCRIPTION']; ?></td>
                                                    <td class="text-center"><?php echo $good['BRAND']; ?></td>
                                                    <td class="text-center"><?php echo $good['SOURCE']; ?></td>
                                                    <td class="text-center"><?php echo $good['TYPE']; ?></td>
                                                    <td class="text-center"><?php if (!empty($good['FILE_UPLOAD'])){ ?><a href="<?php echo base_url('Vendor_list'); ?>/viewDok/<?php echo $good['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $good['NO']; ?></a><?php } else {  echo $good["NO"]; } ?></td>
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
                        </div>

                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Bahan yang Bisa Dipasok
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"> </span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
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
                                                    <td class="text-center"><?php if (!empty($bhn['FILE_UPLOAD'])){ ?><a href="<?php echo base_url('Vendor_list'); ?>/viewDok/<?php echo $bhn['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $bhn['NO']; ?></a><?php } else {  echo $bhn["NO"]; } ?></td>
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
                        </div>
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Jasa yang Bisa Dipasok
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"> </span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
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
                                                    <th class="text-center">Dikelurkan</th>
                                                    <th class="text-center">Berlaku</th>
                                                    <th class="text-center">Sampai</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableItem">
                                                 <?php if (empty($jasa)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="11" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($jasa as $key => $service) { ?>
                                                <tr id="<?php echo $service['PRODUCT_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $service['PRODUCT_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $service['PRODUCT_SUBGROUP_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $service['KLASIFIKASI_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $service['SUBKUALIFIKASI_NAME']; ?></td> 
                                                    <td class="text-center"><?php if (!empty($service['FILE_UPLOAD'])){ ?> <a href="<?php echo base_url('Vendor_list'); ?>/viewDok/<?php echo $service['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $service['NO']; ?></a> <?php } else {  echo $service['NO']; } ?> </td>
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
                        </div>
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Tenaga Ahli Utama
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"> </span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
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
                                                    <td class="text-center"><?php echo $sdm['YEAR_EXP']; ?> Tahun</td>
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
                        </div>
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Tenaga Ahli Pendukung
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"> </span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
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
                                               <?php if (empty($sdm_support)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="7" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($sdm_support as $key => $sdm) { ?>
                                                <tr id="<?php echo $sdm['SDM_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $sdm['NAME']; ?></td>
                                                    <td class="text-center"><?php echo $sdm['LAST_EDUCATION']; ?></td>
                                                    <td class="text-center"><?php echo $sdm['MAIN_SKILL']; ?></td>
                                                    <td class="text-center"><?php echo $sdm['YEAR_EXP']; ?> Tahun</td>
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
                        </div>
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Keterangan Sertifikat
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"> </span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
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
                                             <?php if (empty($certifications)) { ?>
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
                                                        <a target="_blank" href="<?php echo base_url('Vendor_list') ?>/viewDok/<?php echo $certifications['CERT_NO_DOC']; ?>"><?php echo $certifications['CERT_NO']; ?></a>
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
                        </div>
                        <div class="form-horizontal"> 
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Keterangan Tentang Fasilitas dan Peralatan
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"> </span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
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
                        </div>
                         <div class="form-horizontal">
                            <div class="panel panel-default ">
                                <div class="panel-heading">
                                    Pengalaman Perusahaan
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"> </span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="experience">
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
                                                 <?php if (empty($experience)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="12" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($experience as $key => $experience) { ?>
                                                <tr id="<?php echo $experience['CV_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $experience['CLIENT_NAME']; ?></td>
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
                         </div>
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Principal
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"></span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
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
                        </div>
                        <div class="form-horizontal">
                            <div class="panel panel-default ">
                                <div class="panel-heading">
                                    Subkontraktor
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"> </span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
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
                        </div>
                        <div class="form-horizontal">
                            <div class="panel panel-default ">
                                <div class="panel-heading">
                                    Perusahaan Afiliasi
                                    <a href="#!" class="btn btn-sm btn-default invisible">a</a>
                                    <span class="pull-right"> </span>
                                </div>
                                <input type="text" class="hidden" readonly="" name="vendor_id" value=" ">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="affiliation">
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
                                               <?php if (empty($affiliation)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($affiliation as $key => $affiliations) { ?>
                                                <tr id="<?php echo $affiliations['ADD_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $affiliations['NAME']; ?></td>
                                                    <td class="text-center"><?php echo $affiliations['ADDRESS']; ?></td>
                                                    <td class="text-center"><?php echo $affiliations['CITY']; ?></td>
                                                    <td class="text-center"><?php echo $affiliations['COUNTRY']; ?></td>
                                                    <td class="text-center"><?php echo $affiliations['POST_CODE']; ?></td>
                                                    <td class="text-center"><?php echo $affiliations['QUALIFICATION']; ?></td>
                                                    <td class="text-center"><?php echo $affiliations['RELATIONSHIP']; ?></td>
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
                           
                           
                            <div class="panel panel-default">
                                <div class="panel-body text-center">
                                    <a href="<?php echo base_url('Vendor_list') ?>" class="main_button color2 small_btn" type="button">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>                
		</section>
        
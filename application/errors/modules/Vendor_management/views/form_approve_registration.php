<section class="content_section">
                  <style type="text/css" media="screen">
                        .acc_content {
                              padding-bottom: 5px;
                        }
                  </style>

                  <!-- flag penanda approved semua atau belum -->
                  <?php $flag_panel = array(
                              'infoperusahaan' => 'Info Perusahaan',
                              'alamatperusahaan' => 'Alamat Perusahaan',
                              'kontakperusahaan' => 'Kontak Perusahaan',
                              'aktapendirian' => 'Akta Pendirian',
                              'domisiliperusahaan' => 'Domisili Perusahaan',
                              'npwp' => 'NPWP',
                              'pkp' => 'PKP',
                              'siup' => 'SIUP',
                              'tdp' => 'TDP',
                              'angkapengenalimportir' => 'Angka Pengenal Importir',
                              'dewankomisaris' => 'Dewan Komisaris',
                              'dewandireksi' => 'Dewan Direksi',
                              'rekeningbank' => 'Rekening Bank',
                              'modalsesuaidenganaktaterakhir' => 'Modal Sesuai Dengan Akta Terakhir',
                              'informasilaporankeuangan' => 'Informasi Laporan Keuangan',
                              'barangdanbahanyangbisadipasok' => 'Barang dan bahan yang bisa dipasok',
                              'bahanyangbisadipasok' => 'Bahan yang bisa dipasok',
                              'jasayangbisadipasok' => 'Jasa yang bisa dipasok',
                              'tenagaahliutama' => 'Tenaga Ahli Utama',
                              'tenagaahlipendukung' => 'Tenaga Ahli Pendukung',
                              'keterangansertifikat' => 'Keterangan Sertifikat',
                              'keterangantentangfasilitasdanperalatan' => 'Keterangan Tentang Fasilitas dan Peralatan',
                              'pekerjaan' => 'Pekerjaan',
                              'principal' => 'Principal',
                              'subkontraktor' => 'Subkontraktor',
                              'perusahaanafiliasi' => 'Perusahaan Afiliasi',
                        ); ?>

                  <?php foreach ($flag_panel as $key => $value): ?>
                        <?php 
                        if (!empty($vendor_progress)):
                              if (isset($vendor_progress[$value])):
                                    if ($vendor_progress[$value]['STATUS'] == 'Approved'):?>
                                          <input type="hidden" class="flag_panel" id="<?php echo $key ?>" value="true">
                                    <?php  else: ?>             
                                          <input type="hidden" class="flag_panel" id="<?php echo $key ?>" value="false">
                                    <?php  endif ?>             
                              <?php  else: ?>             
                                    <input type="hidden" class="flag_panel" id="<?php echo $key ?>" value="empty">
                              <?php endif ?>
                        <?php  else: ?>
                              <input type="hidden" class="flag_panel" id="<?php echo $key ?>" value="empty">
                        <?php  endif ?>             
                  <?php endforeach ?>

	<div class="content_spacer">
	     <div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span>Data Vendor Baru Yang Perlu Persetujuan</h2>
			</div>
                  <div class="row">
                        <div class="col-md-12">
                              <div class="enar_accordion plus_minus" data-type="toggle">
                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Info Perusahaan"])) {
                                                      if ($vendor_progress["Info Perusahaan"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Info Perusahaan"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Info Perusahaan</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                      <?php echo form_open('Administrative_document/do_update_general_data',array('class' => 'form-horizontal general_form')); ?>
                                                      <?php
                                                      if (!empty($vendor_progress)) {
                                                            if (isset($vendor_progress["Info Perusahaan"])) {
                                                                  if ($vendor_progress["Info Perusahaan"]['STATUS'] == 'Approved') {
                                                                        
                                                                  };
                                                                  if ($vendor_progress["Info Perusahaan"]['STATUS'] == 'Rejected') {
                                                                        echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Info Perusahaan"]['REASON'] . "</div>";
                                                                  };
                                                            }
                                                      }
                                                      ?>
                                                      <div class="form-group">
                                                            <label for="prefix" class="col-sm-3 control-label">Awalan (Prefix)</label>
                                                            <div class="col-sm-3">
                                                                  <?php
                                                                  $prefix_vendor = empty($vendor_detail["PREFIX"]) ? '0' : $vendor_detail["PREFIX"];
                                                                  echo form_dropdown('prefix', $prefix, $prefix_vendor, 'disabled="disabled" class="form-control"'); ?>
                                                            </div>
                                                      </div>
                                                      <div class="form-group">
                                                            <label for="company_name" class="col-sm-3 control-label">Nama Perusahaan</label>
                                                            <div class="col-sm-5">
                                                                  <input type="text" class="form-control" id="company_name" disabled="disabled" name="company_name" value="<?php echo set_value('company_name', $vendor_detail["VENDOR_NAME"]); ?>">
                                                            </div>
                                                      </div>
                                                      <div class="form-group">
                                                            <label for="suffix" class="col-sm-3 control-label">Akhiran (Suffix)</label>
                                                            <div class="col-sm-3">
                                                                  <?php
                                                                  $suffix_vendor = empty($vendor_detail["SUFFIX"]) ? '0' : $vendor_detail["SUFFIX"];
                                                                  echo form_dropdown('suffix', $suffix, $suffix_vendor, 'disabled="disabled" class="form-control"'); ?>
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
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Info Perusahaan"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Info Perusahaan']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Info Perusahaan">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Info Perusahaan", $vendor_progress)) {
                                                            $reason = $vendor_progress["Info Perusahaan"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Alamat Perusahaan"])) {
                                                      if ($vendor_progress["Alamat Perusahaan"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Alamat Perusahaan"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Alamat Perusahaan</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                      <?php
                                                      if (!empty($vendor_progress)) {
                                                            if (isset($vendor_progress["Alamat Perusahaan"])) {
                                                                  if ($vendor_progress["Alamat Perusahaan"]['STATUS'] == 'Approved') {
                                                                  };
                                                                  if ($vendor_progress["Alamat Perusahaan"]['STATUS'] == 'Rejected') {
                                                                        echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Alamat Perusahaan"]['REASON'] . "</div>";
                                                                  };
                                                            }
                                                      }
                                                      ?>
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
                                                                        <td><?php echo $no++; ?></td>
                                                                        <td><?php echo $address['TYPE']; ?></td>
                                                                        <td><?php echo $address['ADDRESS']; ?></td>
                                                                        <td><?php echo $address['CITY']; ?></td>
                                                                        <td><?php echo $country[$address['COUNTRY']]; ?></td>
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
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Alamat Perusahaan"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Alamat Perusahaan']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Alamat Perusahaan">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Alamat Perusahaan", $vendor_progress)) {
                                                            $reason = $vendor_progress["Alamat Perusahaan"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Kontak Perusahaan"])) {
                                                      if ($vendor_progress["Kontak Perusahaan"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Kontak Perusahaan"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Kontak Perusahaan</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                      <?php echo form_open('Administrative_document/do_update_general_data',array('class' => 'form-horizontal general_form')); ?>
                                                      <?php
                                                      if (!empty($vendor_progress)) {
                                                            if (isset($vendor_progress["Kontak Perusahaan"])) {
                                                                  if ($vendor_progress["Kontak Perusahaan"]['STATUS'] == 'Approved') {
                                                                  };
                                                                  if ($vendor_progress["Kontak Perusahaan"]['STATUS'] == 'Rejected') {
                                                                        echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Kontak Perusahaan"]['REASON'] . "</div>";
                                                                  };
                                                            }
                                                      }
                                                      ?>
                                                      <div class="form-group">
                                                            <label for="contact_name" class="col-sm-3 control-label">Nama Lengkap</label>
                                                            <div class="col-sm-6">
                                                                  <input type="text" class="form-control" id="contact_name" disabled="disabled" name="contact_name" value="<?php echo set_value('contact_name', $vendor_detail["CONTACT_NAME"]); ?>">
                                                            </div>
                                                      </div>
                                                      <div class="form-group">
                                                            <label for="contact_pos" class="col-sm-3 control-label">Jabatan</label>
                                                            <div class="col-sm-3">
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
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Kontak Perusahaan"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Kontak Perusahaan']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Kontak Perusahaan">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Kontak Perusahaan", $vendor_progress)) {
                                                            $reason = $vendor_progress["Kontak Perusahaan"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Akta Pendirian"])) {
                                                      if ($vendor_progress["Akta Pendirian"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Akta Pendirian"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Akta Pendirian</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                      <?php echo form_open('Administrative_document/do_update_general_data',array('class' => 'form-horizontal general_form')); ?>
                                                      <?php
                                                      if (!empty($vendor_progress)) {
                                                            if (isset($vendor_progress["Akta Pendirian"])) {
                                                                  if ($vendor_progress["Akta Pendirian"]['STATUS'] == 'Approved') {
                                                                        
                                                                  };
                                                                  if ($vendor_progress["Akta Pendirian"]['STATUS'] == 'Rejected') {
                                                                        echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Akta Pendirian"]['REASON'] . "</div>";
                                                                  };
                                                            }
                                                      }
                                                      ?>
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
                                                                        <td><?php echo $no++; ?></td>
                                                                        <td><?php if (!empty($akta["AKTA_NO_DOC"])){ ?><a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $akta['AKTA_NO_DOC']; ?>"><?php echo $akta['AKTA_NO']; ?> </a><?php } else {  echo $akta["AKTA_NO"];  } ?></td>
                                                                        <td><?php echo $akta['AKTA_TYPE']; ?></td>
                                                                        <td class="text-center"><?php echo vendorfromdate($akta['DATE_CREATION']); ?></td>
                                                                        <td><?php echo $akta['NOTARIS_NAME']; ?></td>
                                                                        <td><?php echo $akta['NOTARIS_ADDRESS']; ?></td>
                                                                        <td class="text-center"> <?php if (!empty($akta["PENGESAHAN_HAKIM_DOC"])){ ?><a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $akta['PENGESAHAN_HAKIM_DOC']; ?>"><?php echo vendorfromdate($akta['PENGESAHAN_HAKIM']); ?></a><?php } else {   echo vendorfromdate($akta['PENGESAHAN_HAKIM']); } ?></td>
                                                                        <td class="text-center"><?php if (!empty($akta["BERITA_ACARA_NGR_DOC"])){ ?><a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $akta['BERITA_ACARA_NGR_DOC']; ?>"><?php echo vendorfromdate($akta['BERITA_ACARA_NGR']); ?></a><?php } else {  echo vendorfromdate($akta['BERITA_ACARA_NGR']); } ?></td>
                                                                  </tr>
                                                                  <?php }
                                                                  ?>

                                                                  <?php } ?>
                                                            </tbody>
                                                      </table>
                                                      </div>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Akta Pendirian"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Akta Pendirian']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Akta Pendirian">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Akta Pendirian", $vendor_progress)) {
                                                            $reason = $vendor_progress["Akta Pendirian"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Domisili Perusahaan"])) {
                                                      if ($vendor_progress["Domisili Perusahaan"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Domisili Perusahaan"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Domisili Perusahaan</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Domisili Perusahaan"])) {
                                                            if ($vendor_progress["Domisili Perusahaan"]['STATUS'] == 'Approved') {
                                                            };
                                                            if ($vendor_progress["Domisili Perusahaan"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Domisili Perusahaan"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_update_legal_data',array('class' => 'form-horizontal general_form')); ?>
                                                <input type="text" class="hidden vendor_id" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                                <div class="form-group">
                                                    <label for="address_domisili_no" class="col-sm-3 control-label">Nomor Domisili</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="address_domisili_no" disabled="disabled" name="address_domisili_no" value="<?php echo set_value('address_domisili_no', $vendor_detail["ADDRESS_DOMISILI_NO"]); ?>">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <?php
                                                        if (!empty($vendor_detail["DOMISILI_NO_DOC"])) { ?>
                                                            <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Vendor_management')."/viewDok/".$vendor_detail["DOMISILI_NO_DOC"]; ?>" title="File Attachment">File Attachment</a></span></label>
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
                                                         <input type="text" class="form-control" id="address_city" disabled="disabled" name="address_city" value="<?php if (empty($vendor_detail["ADDRESS_CITY"]) || $vendor_detail["ADDRESS_CITY"] == 0) { echo $vendor_detail["ADDRESS_CITY"]; } else { echo $city_list[$vendor_detail["ADDRESS_CITY"]]; }?>">
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                      <label for="addres_prop" class="col-sm-3 control-label">Propinsi</label>
                                                      <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="addres_prop" disabled="disabled" name="addres_prop" value="<?php if (empty($vendor_detail["ADDRES_PROP"]) || $vendor_detail["ADDRES_PROP"] == 0) { echo $vendor_detail["ADDRES_PROP"]; } else { echo $province_list[$vendor_detail["ADDRES_PROP"]]; } ?>">
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
                                                    <div class="col-sm-4">
                                                      <?php
                                                      if(!empty($vendor_detail["ADDRESS_COUNTRY"])){
                                                            echo form_dropdown('address_country', $country, $vendor_detail["ADDRESS_COUNTRY"], 'disabled="disabled" class="form-control"'); 
                                                      } else {
                                                            echo "<input type='text' class='form-control' disabled='disabled'>";
                                                      }?>
                                                    </div>
                                                </div>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Domisili Perusahaan"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Domisili Perusahaan']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Domisili Perusahaan">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Domisili Perusahaan", $vendor_progress)) {
                                                            $reason = $vendor_progress["Domisili Perusahaan"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                                $color = '';
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["NPWP"])) {
                                                            if ($vendor_progress["NPWP"]['STATUS'] == 'Approved') {
                                                                  $color = 'green';
                                                            };
                                                            if ($vendor_progress["NPWP"]['STATUS'] == 'Rejected') {
                                                                  $color = 'red';
                                                            };
                                                      }
                                                }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">NPWP</span>

                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                      <?php
                                                            if (!empty($vendor_progress)) {
                                                                  if (isset($vendor_progress["NPWP"])) {
                                                                        if ($vendor_progress["NPWP"]['STATUS'] == 'Approved') {
                                                                        };
                                                                        if ($vendor_progress["NPWP"]['STATUS'] == 'Rejected') {
                                                                              echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["NPWP"]['REASON'] . "</div>";
                                                                        };
                                                                  }
                                                            }
                                                      ?>

                                                      <?php echo form_open('Administrative_document/do_update_legal_data',array('class' => 'form-horizontal general_form')); ?>
                                                      <div class="form-group">
                                                            <label for="npwp_no" class="col-sm-3 control-label">No.</label>
                                                            <div class="col-sm-3">
                                                                  <input type="text" class="form-control" id="npwp_no" disabled="disabled" name="npwp_no" value="<?php echo set_value('npwp_no', $vendor_detail["NPWP_NO"]); ?>">
                                                            </div>

                                                            <div class="col-sm-3">
                                                            <?php
                                                                  if (!empty($vendor_detail["NPWP_NO_DOC"])) { ?>
                                                                        <label class="control-label">
                                                                              <span class="messageUpload">
                                                                                    <a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Vendor_management')."/viewDok/".$vendor_detail["NPWP_NO_DOC"]; ?>" title="File Attachment" target="_blank">File Attachment</a>
                                                                              </span>
                                                                        </label>
                                                            <?php } ?>
                                                            </div>
                                                      </div>
                                                      <div class="form-group">
                                                            <label for="npwp_address" class="col-sm-3 control-label">Alamat (Sesuai NPWP)</label>
                                                            <div class="col-sm-9">
                                                                  <input type="text" class="form-control" id="npwp_address" disabled="disabled" name="npwp_address" value=" <?php if(empty($vendor_detail["NPWP_ADDRESS"]) || $vendor_detail["NPWP_ADDRESS"] == 0 ) { echo $vendor_detail["NPWP_ADDRESS"]; } else { echo set_value('npwp_address', $vendor_detail["NPWP_ADDRESS"]); } ?>">
                                                            </div>
                                                       </div>

                                                      <div class="form-group">
                                                            <label for="npwp_city" class="col-sm-3 control-label">Kota</label>
                                                            <div class="col-sm-4">
                                                                  <input type="text" class="form-control" id="npwp_city" disabled="disabled" name="npwp_city" value="<?php if (empty($vendor_detail["NPWP_CITY"]) || $vendor_detail["NPWP_CITY"] == 0) {  echo $vendor_detail["NPWP_CITY"];  } else {  echo $city_list[$vendor_detail["NPWP_CITY"]]; }?>">
                                                            </div>
                                                      </div>

                                                      <div class="form-group">
                                                            <label for="npwp_prop" class="col-sm-3 control-label">Propinsi</label>
                                                            <div class="col-sm-3">
                                                                  <input type="text" class="form-control" id="npwp_prop" disabled="disabled" name="npwp_prop" value="<?php if (empty($vendor_detail["NPWP_PROP"]) || $vendor_detail["NPWP_PROP"] == 0) { echo $vendor_detail["NPWP_PROP"]; } else { echo $province_list[$vendor_detail["NPWP_PROP"]]; } ?>">
                                                            </div>
                                                      </div>

                                                      <div class="form-group">
                                                            <label for="npwp_postcode" class="col-sm-3 control-label">Kode Pos</label>
                                                            <div class="col-sm-2">
                                                                  <input type="text" class="form-control" id="npwp_postcode" disabled="disabled" name="npwp_postcode" value="<?php echo set_value('npwp_postcode', $vendor_detail["NPWP_POSTCODE"]); ?>">
                                                            </div>
                                                      </div>
                                                      <?php echo form_close(); ?>

                                                      <div class="panel-body text-center">
                                                            <form class="form-inline">
                                                                  <div class="form-group">
                                                                        <select class="form-control action-option">
                                                                              <?php
                                                                              if (!empty($vendor_progress)) {
                                                                                    if (isset($vendor_progress["NPWP"])) { ?>
                                                                                          <option value="Infor Perusahaan">Approve</option>
                                                                                          <option value="Infor Perusahaan" <?php echo ($vendor_progress['NPWP']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                                    
                                                                              <?php } else { ?>
                                                                                          <option value="Infor Perusahaan">Approve</option>
                                                                                          <option value="Infor Perusahaan">Revisi</option>
                                                                              <?php }
                                                                              } else {
                                                                              ?>
                                                                                          <option value="Infor Perusahaan">Approve</option>
                                                                                          <option value="Infor Perusahaan">Revisi</option>
                                                                              <?php }?>
                                                                        </select>
                                                                  </div>
                                                                  <button class="main_button color4 small_btn action-button" type="button" value="NPWP">Submit</button>
                                                            </form>
                                                            <?php
                                                                  $reason = "";
                                                                  if(array_key_exists("NPWP", $vendor_progress)) {
                                                                        $reason = $vendor_progress["NPWP"]["REASON"];
                                                                  }
                                                            ?>
                                                            <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["PKP"])) {
                                                      if ($vendor_progress["PKP"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["PKP"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">PKP</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                      <?php
                                                      
                                                      if (!empty($vendor_progress)) {
                                                            if (isset($vendor_progress["PKP"])) {
                                                                  if ($vendor_progress["PKP"]['STATUS'] == 'Approved') {
                                                      
                                                                  };
                                                                  if ($vendor_progress["PKP"]['STATUS'] == 'Rejected') {
                                                                        echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["PKP"]['REASON'] . "</div>";
                                                                  };
                                                            }
                                                      }
                                                      ?>
                                                            <?php echo form_open('Administrative_document/do_insert_akta_pendirian',array('class' => 'form-horizontal general_form')); ?>
                                                      <input type="text" class="hidden vendor_id" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                                      <div class="form-group">
                                                          <label for="city" class="col-sm-3 control-label">PKP<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "PERORANGAN" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                                          <div class="col-sm-3">
                                                              <input type="text" class="form-control" id="npwp_pkp" disabled="disabled" name="npwp_pkp" value="<?php echo set_value('npwp_pkp', $vendor_detail["NPWP_PKP"]); ?>">
                                                          </div>
                                                      </div>
                                                      <div class="form-group">
                                                          <label for="npwp_pkp_no" class="col-sm-3 control-label">Nomor PKP<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "PERORANGAN" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                                          <div class="col-sm-5">
                                                              <input type="text" class="form-control" id="npwp_pkp_no" disabled="disabled" name="npwp_pkp_no" value="<?php echo set_value('npwp_pkp_no', $vendor_detail["NPWP_PKP_NO"]); ?>">
                                                          </div>
                                                          <div class="col-sm-3">
                                                              <?php
                                                              if (!empty($vendor_detail["PKP_NO_DOC"])) { ?>
                                                                  <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Vendor_management')."/viewDok/".$vendor_detail["PKP_NO_DOC"]; ?>" title="File Attachment">File Attachment</a></span></label>
                                                              <?php
                                                              } ?>
                                                          </div>
                                                      </div>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["PKP"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['PKP']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="PKP">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("PKP", $vendor_progress)) {
                                                            $reason = $vendor_progress["PKP"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["SIUP"])) {
                                                      if ($vendor_progress["SIUP"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["SIUP"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">SIUP</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["SIUP"])) {
                                                            if ($vendor_progress["SIUP"]['STATUS'] == 'Approved') {
                                                                  
                                                            };
                                                            if ($vendor_progress["SIUP"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["SIUP"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_insert_akta_pendirian',array('class' => 'form-horizontal general_form')); ?>
                                                <input type="text" class="hidden vendor_id" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                                <div class="form-group">
                                                    <label for="siup_issued_by" class="col-sm-3 control-label">Dikeluarkan Oleh</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="siup_issued_by" disabled="disabled" name="siup_issued_by" value="<?php echo set_value('siup_issued_by', $vendor_detail["SIUP_ISSUED_BY"]); ?>">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <?php
                                                        if (!empty($vendor_detail["SIUP_NO_DOC"])) { ?>
                                                            <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Vendor_management')."/viewDok/".$vendor_detail["SIUP_NO_DOC"]; ?>" title="File Attachment">File Attachment</a></span></label>
                                                        <?php
                                                        } ?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="siup_no" class="col-sm-3 control-label">Nomor</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="siup_no" disabled="disabled" name="siup_no" value="<?php echo set_value('siup_no', $vendor_detail["SIUP_NO"]); ?>">
                                                    </div>
                                                    <label for="postcode" class="col-sm-3 control-label">SIUP</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_dropdown('siup_type', array("SIUP KECIL" => "SIUP Kecil", "SIUP MENENGAH" => "SIUP Menengah", "SIUP BESAR" => "SIUP Besar"), $vendor_detail['SIUP_TYPE'], 'disabled="disabled" class"form-control"'); ?>
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
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["SIUP"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['SIUP']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="SIUP">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("SIUP", $vendor_progress)) {
                                                            $reason = $vendor_progress["SIUP"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["TDP"])) {
                                                      if ($vendor_progress["TDP"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["TDP"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">TDP</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["TDP"])) {
                                                            if ($vendor_progress["TDP"]['STATUS'] == 'Approved') {
                                                                  
                                                            };
                                                            if ($vendor_progress["TDP"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["TDP"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_update_legal_data',array('class' => 'form-horizontal general_form')); ?>
                                                <input type="text" class="hidden vendor_id" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                                <div class="form-group">
                                                    <label for="tdp_issued_by" class="col-sm-3 control-label">Dikeluarkan Oleh</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="tdp_issued_by" disabled="disabled" name="tdp_issued_by" value="<?php echo set_value('tdp_issued_by', $vendor_detail["TDP_ISSUED_BY"]); ?>">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <?php
                                                        if (!empty($vendor_detail["TDP_NO_DOC"])) { ?>
                                                            <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Vendor_management')."/viewDok/".$vendor_detail["TDP_NO_DOC"]; ?>" title="File Attachment">File Attachment</a></span></label>
                                                        <?php
                                                        } ?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tdp_no" class="col-sm-3 control-label">Nomor</label>
                                                    <div class="col-sm-3">
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
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["TDP"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['TDP']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="TDP">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("TDP", $vendor_progress)) {
                                                            $reason = $vendor_progress["TDP"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Angka Pengenal Importir"])) {
                                                      if ($vendor_progress["Angka Pengenal Importir"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Angka Pengenal Importir"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Angka Pengenal Importir</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Angka Pengenal Importir"])) {
                                                            if ($vendor_progress["Angka Pengenal Importir"]['STATUS'] == 'Approved') {
                                                                  
                                                            };
                                                            if ($vendor_progress["Angka Pengenal Importir"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Angka Pengenal Importir"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_update_legal_data',array('class' => 'form-horizontal general_form')); ?>
                                                <input type="text" class="hidden vendor_id" disabled="disabled" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
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
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Angka Pengenal Importir"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Angka Pengenal Importir']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Angka Pengenal Importir">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Angka Pengenal Importir", $vendor_progress)) {
                                                            $reason = $vendor_progress["Angka Pengenal Importir"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Dewan Komisaris"])) {
                                                      if ($vendor_progress["Dewan Komisaris"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Dewan Komisaris"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Dewan Komisaris</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Dewan Komisaris"])) {
                                                            if ($vendor_progress["Dewan Komisaris"]['STATUS'] == 'Approved') {
                                                                  
                                                            };
                                                            if ($vendor_progress["Dewan Komisaris"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Dewan Komisaris"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_update_legal_data',array('class' => 'form-horizontal general_form')); ?>
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
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $board['NAME']; ?></td>
                                                            <td class="text-center"><?php echo $board['POS']; ?></td>
                                                            <td class="text-center"><?php echo $board['TELEPHONE_NO']; ?></td>
                                                            <td><?php echo $board['EMAIL_ADDRESS']; ?></td>
                                                            <td class="text-center"><?php if (!empty($board['KTP_FILE'])){ ?> <a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $board['KTP_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $board['KTP_NO']; ?></a> <?php } else {  echo $board['KTP_NO']; } ?></td>
                                                            <td class="text-center"><?php echo vendorfromdate($board['KTP_EXPIRED_DATE']); ?></td>
                                                            <td class="text-center"><?php if (!empty($board['NPWP_FILE'])){ ?> <a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $board['NPWP_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $board['NPWP_NO']; ?></a> <?php } else {  echo $board['NPWP_NO']; } ?></td>
                                                            <!-- <td><?php echo $board['NPWP_NO']; ?></td> -->
                                                        </tr>
                                                            <?php }
                                                        ?>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Dewan Komisaris"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Dewan Komisaris']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Dewan Komisaris">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Dewan Komisaris", $vendor_progress)) {
                                                            $reason = $vendor_progress["Dewan Komisaris"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Dewan Direksi"])) {
                                                      if ($vendor_progress["Dewan Direksi"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Dewan Direksi"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Dewan Direksi</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Dewan Direksi"])) {
                                                            if ($vendor_progress["Dewan Direksi"]['STATUS'] == 'Approved') {
                                                                  
                                                            };
                                                            if ($vendor_progress["Dewan Direksi"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Dewan Direksi"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_insert_akta_pendirian',array('class' => 'form-horizontal general_form')); ?>
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
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $board['NAME']; ?></td>
                                                            <td class="text-center"><?php echo $board['POS']; ?></td>
                                                            <td class="text-center"><?php echo $board['TELEPHONE_NO']; ?></td>
                                                            <td><?php echo $board['EMAIL_ADDRESS']; ?></td>
                                                            <td class="text-center"><?php if (!empty($board['KTP_FILE'])){ ?> <a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $board['KTP_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $board['KTP_NO']; ?></a> <?php } else {  echo $board['KTP_NO']; } ?></td>
                                                            <td class="text-center"><?php echo vendorfromdate($board['KTP_EXPIRED_DATE']); ?></td>
                                                            <td class="text-center"><?php if (!empty($board['NPWP_FILE'])){ ?> <a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $board['NPWP_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $board['NPWP_NO']; ?></a> <?php } else {  echo $board['NPWP_NO']; } ?></td>
                                                            <!-- <td><?php echo $board['NPWP_NO']; ?></td> -->
                                                        </tr>
                                                            <?php }
                                                        ?>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                </div>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Dewan Direksi"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Dewan Direksi']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Dewan Direksi">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Dewan Direksi", $vendor_progress)) {
                                                            $reason = $vendor_progress["Dewan Direksi"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Rekening Bank"])) {
                                                      if ($vendor_progress["Rekening Bank"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Rekening Bank"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Rekening Bank</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                 <?php
                                                
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Rekening Bank"])) {
                                                            if ($vendor_progress["Rekening Bank"]['STATUS'] == 'Approved') {
                                                                  
                                                            };
                                                            if ($vendor_progress["Rekening Bank"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Rekening Bank"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_update_legal_data',array('class' => 'form-horizontal general_form')); ?>
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
                                                            <td class="text-center"><?php if (!empty($bank['REFERENCE_FILE'])){ ?> <a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $bank['REFERENCE_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $bank['REFERENCE_BANK']; ?></a> <?php } else {  echo $bank['REFERENCE_BANK']; } ?></td>

                                                        </tr>
                                                            <?php }
                                                        ?>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Rekening Bank"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Rekening Bank']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Rekening Bank">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Rekening Bank", $vendor_progress)) {
                                                            $reason = $vendor_progress["Rekening Bank"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Modal Sesuai Dengan Akta Terakhir"])) {
                                                      if ($vendor_progress["Modal Sesuai Dengan Akta Terakhir"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Modal Sesuai Dengan Akta Terakhir"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Modal Sesuai Dengan Akta Terakhir</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Modal Sesuai Dengan Akta Terakhir"])) {
                                                            if ($vendor_progress["Modal Sesuai Dengan Akta Terakhir"]['STATUS'] == 'Approved') {
                                                                  
                                                            };
                                                            if ($vendor_progress["Modal Sesuai Dengan Akta Terakhir"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Modal Sesuai Dengan Akta Terakhir"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_update_legal_data',array('class' => 'form-horizontal general_form')); ?>
                                                      <div class="form-group">
                                                            <label for="fin_akta_mdl_dsr_curr" class="col-sm-3 control-label">Modal Dasar</label>
                                                            <div class="col-sm-3">
                                                                  <?php if (!empty($vendor_detail['FIN_AKTA_MDL_DSR_CURR'])) {
                                                                        echo form_dropdown('fin_akta_mdl_dsr_curr', $currency, $vendor_detail["FIN_AKTA_MDL_DSR_CURR"], 'disabled="disabled" class="form-control"'); 
                                                                        } else {
                                                                        echo form_dropdown('disabled="disabled class="form-control"');
                                                                        }
                                                                  ?>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                  <input type="text" class="form-control text-right" id="fin_akta_mdl_dsr" disabled="disabled" name="fin_akta_mdl_dsr" value="<?php echo set_value('fin_akta_mdl_dsr', number_format($vendor_detail["FIN_AKTA_MDL_DSR"])); ?>">
                                                            </div>
                                                      </div>
                                                      <div class="form-group">
                                                            <label for="fin_akta_mdl_str_curr" class="col-sm-3 control-label">Modal Disetor</label>
                                                            <div class="col-sm-3">
                                                                  <?php if (!empty($vendor_detail["FIN_AKTA_MDL_STR_CURR"])) {
                                                                        echo form_dropdown('fin_akta_mdl_str_curr', $currency, $vendor_detail["FIN_AKTA_MDL_STR_CURR"], 'disabled="disabled" class="form-control"'); 
                                                                        } else {
                                                                        echo form_dropdown('disabled="disabled class="form-control"');
                                                                        }
                                                                  ?>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                  <input type="text" class="form-control text-right" id="fin_akta_mdl_str" disabled="disabled" name="fin_akta_mdl_str" value="<?php echo set_value('fin_akta_mdl_str', number_format($vendor_detail["FIN_AKTA_MDL_STR"])); ?>">
                                                            </div>
                                                            </div>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Modal Sesuai Dengan Akta Terakhir"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Modal Sesuai Dengan Akta Terakhir']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Modal Sesuai Dengan Akta Terakhir">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Modal Sesuai Dengan Akta Terakhir", $vendor_progress)) {
                                                            $reason = $vendor_progress["Modal Sesuai Dengan Akta Terakhir"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Informasi Laporan Keuangan"])) {
                                                      if ($vendor_progress["Informasi Laporan Keuangan"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Informasi Laporan Keuangan"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Informasi Laporan Keuangan</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Informasi Laporan Keuangan"])) {
                                                            if ($vendor_progress["Informasi Laporan Keuangan"]['STATUS'] == 'Approved') {
                                                                  
                                                            };
                                                            if ($vendor_progress["Informasi Laporan Keuangan"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Informasi Laporan Keuangan"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_update_legal_data',array('class' => 'form-horizontal general_form')); ?>
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
                                                            <td class="text-center"><?php if (!empty($report['FILE_UPLOAD'])){ ?><a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $report['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $report['FIN_RPT_YEAR']; ?></a><?php } else {  echo $report['FIN_RPT_YEAR']; } ?>
                                                            </td>
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
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Informasi Laporan Keuangan"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Informasi Laporan Keuangan']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Informasi Laporan Keuangan">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Informasi Laporan Keuangan", $vendor_progress)) {
                                                            $reason = $vendor_progress["Informasi Laporan Keuangan"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Barang dan bahan yang bisa dipasok"])) {
                                                      if ($vendor_progress["Barang dan bahan yang bisa dipasok"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Barang dan bahan yang bisa dipasok"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Barang dan bahan yang bisa dipasok</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Barang dan bahan yang bisa dipasok"])) {
                                                            if ($vendor_progress["Barang dan bahan yang bisa dipasok"]['STATUS'] == 'Approved') {
                                                            };
                                                            if ($vendor_progress["Barang dan bahan yang bisa dipasok"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Barang dan bahan yang bisa dipasok"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_insert_good',array('class' => 'form-horizontal general_form')); ?>
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
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $good['PRODUCT_NAME']; ?></td>
                                                            <td><?php echo $good['PRODUCT_SUBGROUP_NAME']; ?></td>
                                                            <td><?php echo $good['PRODUCT_DESCRIPTION']; ?></td>
                                                            <td><?php echo $good['BRAND']; ?></td>
                                                            <td><?php echo $good['SOURCE']; ?></td>
                                                            <td><?php echo $good['TYPE']; ?></td>
                                                            <td> <?php if (!empty($good['FILE_UPLOAD'])){ ?><a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $good['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $good['NO']; ?></a><?php } else {  echo $good["NO"]; } ?> </td>
                                                            <td><?php echo $good['ISSUED_BY']; ?></td>
                                                            <td><?php echo vendorfromdate($good['ISSUED_DATE']); ?></td>
                                                            <td><?php echo vendorfromdate($good['EXPIRED_DATE']); ?></td>
                                                        </tr>
                                                            <?php }
                                                        ?>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Barang dan bahan yang bisa dipasok"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Barang dan bahan yang bisa dipasok']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Barang dan bahan yang bisa dipasok">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Barang dan bahan yang bisa dipasok", $vendor_progress)) {
                                                            $reason = $vendor_progress["Barang dan bahan yang bisa dipasok"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Bahan yang bisa dipasok"])) {
                                                      if ($vendor_progress["Bahan yang bisa dipasok"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Bahan yang bisa dipasok"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Bahan yang bisa dipasok</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Bahan yang bisa dipasok"])) {
                                                            if ($vendor_progress["Bahan yang bisa dipasok"]['STATUS'] == 'Approved') {
                                                            };
                                                            if ($vendor_progress["Bahan yang bisa dipasok"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Barang dan bahan yang bisa dipasok"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_insert_good',array('class' => 'form-horizontal general_form')); ?>
                                                <table class="table table-hover margin-bottom-20" id="goods">
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
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $bhn['PRODUCT_NAME']; ?></td>
                                                            <td><?php echo $bhn['PRODUCT_SUBGROUP_NAME']; ?></td>
                                                            <td><?php echo $bhn['PRODUCT_DESCRIPTION']; ?></td>
                                                            <td><?php echo $bhn['SOURCE']; ?></td>
                                                            <td><?php echo $bhn['TYPE']; ?></td>
                                                            <td><?php echo $bhn['KLASIFIKASI_NAME']; ?></td>
                                                            <td> <?php if (!empty($bhn['FILE_UPLOAD'])){ ?><a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $bhn['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $bhn['NO']; ?></a><?php } else {  echo $bhn["NO"]; } ?> </td>
                                                            <td><?php echo $bhn['ISSUED_BY']; ?></td>
                                                            <td><?php echo vendorfromdate($bhn['ISSUED_DATE']); ?></td>
                                                            <td><?php echo vendorfromdate($bhn['EXPIRED_DATE']); ?></td>
                                                        </tr>
                                                            <?php }
                                                        ?>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Bahan yang bisa dipasok"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Bahan yang bisa dipasok']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Bahan yang bisa dipasok">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Bahan yang bisa dipasok", $vendor_progress)) {
                                                            $reason = $vendor_progress["Bahan yang bisa dipasok"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Jasa yang bisa dipasok"])) {
                                                      if ($vendor_progress["Jasa yang bisa dipasok"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Jasa yang bisa dipasok"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Jasa yang bisa dipasok</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                 <?php
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Jasa yang bisa dipasok"])) {
                                                            if ($vendor_progress["Jasa yang bisa dipasok"]['STATUS'] == 'Approved') {
                                                            };
                                                            if ($vendor_progress["Jasa yang bisa dipasok"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Jasa yang bisa dipasok"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_insert_good',array('class' => 'form-horizontal general_form')); ?>
                                                <table class="table table-hover margin-bottom-20" id="goods">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">No</th>
                                                            <th class="text-center">Group Barang</th>
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
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $service['PRODUCT_NAME']; ?></td>
                                                            <td class="text-center"><?php echo $service['PRODUCT_SUBGROUP_NAME']; ?></td>
                                                            <td class="text-center"><?php echo $service['KLASIFIKASI_NAME']; ?></td>
                                                            <td class="text-center"><?php echo $service['SUBKUALIFIKASI_NAME']; ?></td> 
                                                            <td><?php if (!empty($service['FILE_UPLOAD'])){ ?> <a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $service['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $service['NO']; ?></a> <?php } else {  echo $service['NO']; } ?> </td>
                                                            <td><?php echo $service['ISSUED_BY']; ?></td>
                                                            <td><?php echo vendorfromdate($service['ISSUED_DATE']); ?></td>
                                                            <td><?php echo vendorfromdate($service['EXPIRED_DATE']); ?></td>
                                                        </tr>
                                                            <?php }
                                                        ?>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Jasa yang bisa dipasok"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Jasa yang bisa dipasok']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Jasa yang bisa dipasok">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Jasa yang bisa dipasok", $vendor_progress)) {
                                                            $reason = $vendor_progress["Jasa yang bisa dipasok"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Tenaga Ahli Utama"])) {
                                                      if ($vendor_progress["Tenaga Ahli Utama"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Tenaga Ahli Utama"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Tenaga Ahli Utama</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Tenaga Ahli Utama"])) {
                                                            if ($vendor_progress["Tenaga Ahli Utama"]['STATUS'] == 'Approved') {
                                                                  
                                                            };
                                                            if ($vendor_progress["Tenaga Ahli Utama"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Tenaga Ahli Utama"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_insert_sdm',array('class' => 'form-horizontal general_form')); ?>
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
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $sdm['NAME']; ?></td>
                                                            <td class="text-center"><?php echo $sdm['LAST_EDUCATION']; ?></td>
                                                            <td><?php echo $sdm['MAIN_SKILL']; ?></td>
                                                            <td><?php echo $sdm['YEAR_EXP']; ?> Tahun</td>
                                                            <td><?php echo $sdm['EMP_STATUS']; ?></td>
                                                            <td class="text-center"><?php echo $sdm['EMP_TYPE']; ?></td>
                                                        </tr>
                                                            <?php }
                                                        ?>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Tenaga Ahli Utama"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Tenaga Ahli Utama']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Tenaga Ahli Utama">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Tenaga Ahli Utama", $vendor_progress)) {
                                                            $reason = $vendor_progress["Tenaga Ahli Utama"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Tenaga Ahli Pendukung"])) {
                                                      if ($vendor_progress["Tenaga Ahli Pendukung"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Tenaga Ahli Pendukung"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Tenaga Ahli Pendukung</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Tenaga Ahli Pendukung"])) {
                                                            if ($vendor_progress["Tenaga Ahli Pendukung"]['STATUS'] == 'Approved') {
                                                                  
                                                            };
                                                            if ($vendor_progress["Tenaga Ahli Pendukung"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Tenaga Ahli Pendukung"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_insert_sdm',array('class' => 'form-horizontal general_form')); ?>
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
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $sdm['NAME']; ?></td>
                                                            <td class="text-center"><?php echo $sdm['LAST_EDUCATION']; ?></td>
                                                            <td><?php echo $sdm['MAIN_SKILL']; ?></td>
                                                            <td><?php echo $sdm['YEAR_EXP']; ?> Tahun</td>
                                                            <td><?php echo $sdm['EMP_STATUS']; ?></td>
                                                            <td class="text-center"><?php echo $sdm['EMP_TYPE']; ?></td>
                                                        </tr>
                                                            <?php }
                                                        ?>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Tenaga Ahli Pendukung"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Tenaga Ahli Pendukung']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Tenaga Ahli Pendukung">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Tenaga Ahli Pendukung", $vendor_progress)) {
                                                            $reason = $vendor_progress["Tenaga Ahli Pendukung"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Keterangan Sertifikat"])) {
                                                      if ($vendor_progress["Keterangan Sertifikat"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Keterangan Sertifikat"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Keterangan Sertifikat</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Keterangan Sertifikat"])) {
                                                            if ($vendor_progress["Keterangan Sertifikat"]['STATUS'] == 'Approved') {
                                                                  
                                                            };
                                                            if ($vendor_progress["Keterangan Sertifikat"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Keterangan Sertifikat"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_insert_certifications',array('class' => 'form-horizontal general_form')); ?>
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
                                                            <td><?php echo $no++; ?></td>
                                                            <td>
                                                                <?php
                                                                if (!empty($certifications['TYPE_OTHER'])) {
                                                                    echo $certifications['TYPE_OTHER'];
                                                                }
                                                                else {
                                                                    echo $certificate_type[$certifications['TYPE']];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $certifications['CERT_NAME']; ?></td>
                                                            <td class="text-center">
                                                                <?php if (isset($certifications['CERT_NO_DOC'])) { ?>
                                                                <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $certifications['CERT_NO_DOC']; ?>"><?php echo $certifications['CERT_NO']; ?></a>
                                                                <?php } else {?>
                                                                <?php echo $certifications['CERT_NO']; ?>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?php echo $certifications['ISSUED_BY']; ?></td>
                                                            <td class="text-center"><?php echo vendorfromdate($certifications['VALID_FROM']); ?></td>
                                                            <td class="text-center"><?php echo vendorfromdate($certifications['VALID_TO']); ?></td>
                                                        </tr>
                                                            <?php }
                                                        ?>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Keterangan Sertifikat"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Keterangan Sertifikat']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Keterangan Sertifikat">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Keterangan Sertifikat", $vendor_progress)) {
                                                            $reason = $vendor_progress["Keterangan Sertifikat"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Keterangan Tentang Fasilitas dan Peralatan"])) {
                                                      if ($vendor_progress["Keterangan Tentang Fasilitas dan Peralatan"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Keterangan Tentang Fasilitas dan Peralatan"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Keterangan Tentang Fasilitas / Peralatan</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Keterangan Tentang Fasilitas dan Peralatan"])) {
                                                            if ($vendor_progress["Keterangan Tentang Fasilitas dan Peralatan"]['STATUS'] == 'Approved') {
                                                                  
                                                            };
                                                            if ($vendor_progress["Keterangan Tentang Fasilitas dan Peralatan"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Keterangan Tentang Fasilitas dan Peralatan"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_insert_equipments',array('class' => 'form-horizontal general_form')); ?>
                                                <table class="table table-hover margin-bottom-20" id="equipments">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left">No</th>
                                                            <th class="text-left">Kategori</th>
                                                            <th class="text-left">Nama Peralatan</th>
                                                            <th class="text-left">Spesifikasi</th>
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
                                                            <td class="text-left"><?php echo $no++; ?></td>
                                                            <td class="text-left"><?php echo $tools_category[$equipment['CATEGORY']]; ?></td>
                                                            <td class="text-left"><?php echo $equipment['EQUIP_NAME']; ?></td>
                                                            <td class="text-left"><?php echo $equipment['SPEC']; ?></td>
                                                            <td class="text-center"><?php echo $equipment['QUANTITY']; ?></td>
                                                            <td class="text-center"><?php echo $equipment['YEAR_MADE']; ?></td>
                                                        </tr>
                                                            <?php }
                                                        ?>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Keterangan Tentang Fasilitas dan Peralatan"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Keterangan Tentang Fasilitas dan Peralatan']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Keterangan Tentang Fasilitas dan Peralatan">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Keterangan Tentang Fasilitas dan Peralatan", $vendor_progress)) {
                                                            $reason = $vendor_progress["Keterangan Tentang Fasilitas dan Peralatan"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Pekerjaan"])) {
                                                      if ($vendor_progress["Pekerjaan"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Pekerjaan"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Pengalaman Perusahaan</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Pekerjaan"])) {
                                                            if ($vendor_progress["Pekerjaan"]['STATUS'] == 'Approved') {
                                                                  
                                                            };
                                                            if ($vendor_progress["Pekerjaan"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Pekerjaan"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_insert_experiences',array('class' => 'form-horizontal general_form')); ?>
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
                                                            <td><?php echo $no++; ?></td>
                                                            <td>
                                                                <?php if (isset($experience['CLIENT_NAME_DOC'])) { ?>
                                                                <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $experience['CLIENT_NAME_DOC']; ?>"><?php echo $experience['CLIENT_NAME']; ?></a>
                                                                <?php } else {?>
                                                                <?php echo $experience['CLIENT_NAME']; ?>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?php echo $experience['PROJECT_NAME']; ?></td>
                                                            <td><?php echo $experience['DESCRIPTION']; ?></td>
                                                            <td><?php echo $experience['CURRENCY']; ?></td>
                                                            <td><?php echo number_format($experience['AMOUNT']); ?></td>
                                                            <td><?php echo $experience['CONTRACT_NO']; ?></td>
                                                            <td><?php echo vendorfromdate($experience['START_DATE']); ?></td>
                                                            <td><?php echo vendorfromdate($experience['END_DATE']); ?></td>
                                                            <td><?php echo $experience['CONTACT_PERSON']; ?></td>
                                                            <td><?php echo $experience['CONTACT_NO']; ?></td>
                                                        </tr>
                                                            <?php }
                                                        ?>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Pekerjaan"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Pekerjaan']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Pekerjaan">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Pekerjaan", $vendor_progress)) {
                                                            $reason = $vendor_progress["Pekerjaan"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Principal"])) {
                                                      if ($vendor_progress["Principal"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Principal"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Principal</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Principal"])) {
                                                            if ($vendor_progress["Principal"]['STATUS'] == 'Approved') {
                                                                  
                                                            };
                                                            if ($vendor_progress["Principal"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Principal"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_insert_principal',array('class' => 'form-horizontal general_form')); ?>
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
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $principal['NAME']; ?></td>
                                                            <td><?php echo $principal['ADDRESS']; ?></td>
                                                            <td><?php echo $principal['CITY']; ?></td>
                                                            <td><?php echo $principal['COUNTRY']; ?></td>
                                                            <td><?php echo $principal['POST_CODE']; ?></td>
                                                            <td><?php echo $principal['QUALIFICATION']; ?></td>
                                                            <td><?php echo $principal['RELATIONSHIP']; ?></td>
                                                        </tr>
                                                            <?php }
                                                        ?>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Principal"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Principal']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Principal">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Principal", $vendor_progress)) {
                                                            $reason = $vendor_progress["Principal"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Subkontraktor"])) {
                                                      if ($vendor_progress["Subkontraktor"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Subkontraktor"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Subkontraktor</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Subkontraktor"])) {
                                                            if ($vendor_progress["Subkontraktor"]['STATUS'] == 'Approved') {
                                                                  
                                                            };
                                                            if ($vendor_progress["Subkontraktor"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Subkontraktor"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_insert_subcontractor',array('class' => 'form-horizontal general_form')); ?>
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
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $subcontractor['NAME']; ?></td>
                                                            <td><?php echo $subcontractor['ADDRESS']; ?></td>
                                                            <td><?php echo $subcontractor['CITY']; ?></td>
                                                            <td><?php echo $subcontractor['COUNTRY']; ?></td>
                                                            <td><?php echo $subcontractor['POST_CODE']; ?></td>
                                                            <td><?php echo $subcontractor['QUALIFICATION']; ?></td>
                                                            <td><?php echo $subcontractor['RELATIONSHIP']; ?></td>
                                                        </tr>
                                                            <?php }
                                                        ?>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Subkontraktor"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Subkontraktor']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Subkontraktor">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Subkontraktor", $vendor_progress)) {
                                                            $reason = $vendor_progress["Subkontraktor"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="enar_occ_container">
                                          <?php
                                          $color = '';
                                          if (!empty($vendor_progress)) {
                                                if (isset($vendor_progress["Perusahaan Afiliasi"])) {
                                                      if ($vendor_progress["Perusahaan Afiliasi"]['STATUS'] == 'Approved') {
                                                            $color = 'green';
                                                      };
                                                      if ($vendor_progress["Perusahaan Afiliasi"]['STATUS'] == 'Rejected') {
                                                            $color = 'red';
                                                      };
                                                }
                                          }
                                          ?>
                                          <span class="enar_occ_title <?php echo $color ?>">Perusahaan Afiliasi</span>
                                          <div class="enar_occ_content">
                                                <div class="acc_content">
                                                <?php
                                                
                                                if (!empty($vendor_progress)) {
                                                      if (isset($vendor_progress["Perusahaan Afiliasi"])) {
                                                            if ($vendor_progress["Perusahaan Afiliasi"]['STATUS'] == 'Approved') {
                                                                  
                                                            };
                                                            if ($vendor_progress["Perusahaan Afiliasi"]['STATUS'] == 'Rejected') {
                                                                  echo "<div class='alert alert-warning' role='alert'><strong>Keterangan Reject! </strong>" . $vendor_progress["Perusahaan Afiliasi"]['REASON'] . "</div>";
                                                            };
                                                      }
                                                }
                                                ?>
                                                      <?php echo form_open('Administrative_document/do_insert_affiliation_company',array('class' => 'form-horizontal general_form')); ?>
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
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $affiliation_company['NAME']; ?></td>
                                                            <td><?php echo $affiliation_company['ADDRESS']; ?></td>
                                                            <td><?php echo $affiliation_company['CITY']; ?></td>
                                                            <td><?php echo $affiliation_company['COUNTRY']; ?></td>
                                                            <td><?php echo $affiliation_company['POST_CODE']; ?></td>
                                                            <td><?php echo $affiliation_company['QUALIFICATION']; ?></td>
                                                            <td><?php echo $affiliation_company['RELATIONSHIP']; ?></td>
                                                        </tr>
                                                            <?php }
                                                        ?>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                      <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                  <?php
                                                                  if (!empty($vendor_progress)) {
                                                                        if (isset($vendor_progress["Perusahaan Afiliasi"])) { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan" <?php echo ($vendor_progress['Perusahaan Afiliasi']['STATUS'] == 'Rejected') ? 'selected' : ''?>>Revisi</option>
                                                                        
                                                                  <?php } else { ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }
                                                                  } else {
                                                                  ?>
                                                                              <option value="Infor Perusahaan">Approve</option>
                                                                              <option value="Infor Perusahaan">Revisi</option>
                                                                  <?php }?>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button" type="button" value="Perusahaan Afiliasi">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Perusahaan Afiliasi", $vendor_progress)) {
                                                            $reason = $vendor_progress["Perusahaan Afiliasi"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Alasan Revisi"><?php echo $reason; ?></textarea>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="panel panel-default">
                                          <form id="form_akuntansi" method="post" action="<?php echo base_url()?>Vendor_management/update_approve_staff">
                                                <div class="panel-heading">Input Data Akuntansi</div>
                                                <div class="panel-body">
                                                      <!-- <input type="text" class="hidden vendor_id" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>"> -->
                                                      
                                                    <div class="form-group">
                                                        <label for="contact_name" class="col-sm-3 control-label">Term of Payment<span style="color: #E74C3C">*</span></label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" name="term_payment" id="term_payment">
                                                                <?php
                                                                foreach ($payment_term as $key => $val) {
                                                                ?>
                                                                    <option value="<?php echo $val['CODE_PAYMENT_TERM']?>" <?php echo ($val['CODE_PAYMENT_TERM']=='ZG30') ? 'selected' : '';?>><?php echo $val['CODE_PAYMENT_TERM']?> - <?php echo $val['EXPLANATION'] ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <br>
                                                    <br>
                                                    <div class="form-group">
                                                        <label for="contact_name" class="col-sm-3 control-label">Account Group <span style="color: #E74C3C">*</span></label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" name="account_group" id="account_group">
                                                                <?php
                                                                foreach ($account_group as $key => $val) {
                                                                ?>
                                                                    <option value="<?php echo $val['GROUP']?>"><?php echo $val['ACC_GROUP_ID']?> - <?php echo $val['NAME'] ?> - <?php echo $val['GROUP']?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                          </form>
                                    </div>
                                    <hr>
<!-- KOMENTAR VENDOR -->
                <?php if ($emplo[0]['LEVEL'] == 1) { ?>
                            <div class="panel-group">
                              <div class="panel panel-warning">
                                <div class="panel-heading">
                                  <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#collapse1">Komentar Vendor</a>
                                  </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse"> 
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
                            
                            <div class="panel panel-warning">
                              <div class="panel-heading">Komentar Anda</div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <tr>
                                            <td class="col-md-3">Komentar</td>
                                            <td class="col-md-1 text-right">:</td>
                                            <td><textarea maxlength="1000" class="form-control" name ="vendor_comment" id="vendor_comment" /></textarea></td>

                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr> 
                  <?php } ?>
                                    <div class="panel-group">
                                          <div class="panel panel-default">
                                                <div class="panel-heading">
                                                      <h4 class="panel-title">
                                                      <a data-toggle="collapse" href="#collapse2">Daftar Komentar</a>
                                                      </h4>
                                                </div>

                                                <div id="collapse2" class="panel-collapse collapse"> 
                                                      <table class="table table-hover margin-bottom-20" id="id_comment">
                                                            <thead>
                                                                  <tr>
                                                                        <th class="text-center">No</th>
                                                                        <th class="text-center">Nama</th>
                                                                        <th class="text-center">Aktivitas</th>
                                                                        <th class="text-center">Tanggal</th>
                                                                        <th class="text-center">Komentar</th>
                                                                  </tr>
                                                            </thead>
                                                            <tbody id="tableItem">
                                                                  <?php
                                                                  if (empty($comment)) { ?>
                                                                  <tr id="empty_row">
                                                                        <td colspan="8" class="text-center">- Belum ada komentar -</td>
                                                                  </tr>
                                                                  <?php } else { $no = 1; foreach ($comment as $key => $com) { ?>
                                                                  <tr id="<?php echo $com['ID']; ?>">
                                                                        <td class="text-center"><?php echo $no++; ?></td>
                                                                        <td class="text-center"><?php echo $com['EMP_NAMA']; ?></td>
                                                                        <td class="text-center"><?php echo $com['STATUS_ACTIVITY']; ?></td>
                                                                        <td class="text-center"><?php echo vendorfromdate($com['DATE_COMMENT']); ?></td>
                                                                        <td class="text-center"><?php echo $com['COMMENT']; ?></td>
                                                                  </tr>
                                                                  <?php } } ?>
                                                            </tbody>
                                                      </table>
                                                </div>
                                          </div>
                                    </div>


                                    <div class="panel panel-default">
                                          <div class="panel-heading">Komentar Anda</div>
                                                <div class="panel-body">
                                                      <table class="table table-hover">
                                                            <tr>
                                                                  <td class="col-md-3">Komentar</td>
                                                                  <td class="col-md-1 text-right">:</td>
                                                                  <td><textarea maxlength="1000" class="form-control" name ="vnd_comment" id="vnd_comment" /></textarea></td>
                                                            </tr>
                                                      </table>
                                                </div>
                                    </div> 

                                    <input type="text" class="hidden vendor_id" id="comment" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">

                              </div> <!-- END enar_accordion --> 
                        </div> <!-- END col-md-12 -->                            
                  </div> <!-- END row -->

                              <div class="row">
                                    <div class="col-md-12">
                                          <div class="panel panel-default">
                                                <div class="panel-body text-right">
                                                      <a href="<?php echo base_url(); ?>Vendor_management/job_list" class="main_button small_btn">Cancel</a>
                                                      <input value="<?php echo $emplo[0]['LEVEL']; ?>" id="level" name="level" type="hidden">
                                                      <button id="approve-staff" class="main_button color6 small_btn" type="button">Approve</button>
                                                      <button id="reject" class="main_button color1 small_btn" type="button">Reject</button>
                                                      <?php if ($emplo[0]['LEVEL'] == 1) { ?>
                                                            <button id="route-to-vendor" class="main_button color4 small_btn">Route to Vendor</button>
                                                     <?php } ?>
                                                </div>
                                          </div>
                                    </div>
                              </div>              
            </div> <!-- END  content -->                            
      </div> <!-- END  content_spacer -->
</section>
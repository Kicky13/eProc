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
            <h2><span class="line"><i class="ico-users"></i></span>Data Update Vendor Yang Perlu Persetujuan</h2>
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
                                          } else if ($vendor_progress["Info Perusahaan"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Info Perusahaan"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                  <strong>Data Lama</strong>
                                  <div class="table-responsive">
                                  <table class="table table-hover margin-bottom-20" id="info_perusahaan">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Awalan (Prefix)</th>
                                        <th class="text-center">Nama Perusahaan</th>
                                        <th class="text-center">Akhiran (Suffix)</th>
                                        <th class="text-center">Tipe Vendor</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail_old)) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      $options = array(
                                        'NASIONAL' => 'Nasional',
                                        'INTERNASIONAL' => 'Internasional',
                                        'EXPEDITURE' => 'Expediture',
                                        'PERORANGAN' => 'Perorangan'
                                        );
                                      ?>
                                      <tr>
                                        <td class="text-center"><?php if (isset($prefix[$vendor_detail_old["PREFIX"]])) { echo $prefix[$vendor_detail_old["PREFIX"]]; } ?></td>
                                        <td class="text-center"><?php echo $vendor_detail_old["VENDOR_NAME"]; ?></td>
                                        <td class="text-center"><?php  if (isset($suffix[$vendor_detail_old["SUFFIX"]])) { echo $suffix[$vendor_detail_old["SUFFIX"]]; } ?></td>
                                        <td class="text-center"><?php if($vendor_detail_old["VENDOR_TYPE"]!='NASIONAL'){ echo $options[$vendor_detail_old["VENDOR_TYPE"]]; } else { echo $vendor_detail_old["VENDOR_TYPE"]; } ?></td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>
                                  <hr>

                                  <strong>Data Baru</strong>
                                  <div class="table-responsive">
                                  <table class="table table-hover margin-bottom-20" id="info_perusahaan">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Awalan (Prefix)</th>
                                        <th class="text-center">Nama Perusahaan</th>
                                        <th class="text-center">Akhiran (Suffix)</th>
                                        <th class="text-center">Tipe Vendor</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail)) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      $options = array(
                                        'NASIONAL' => 'Nasional',
                                        'INTERNASIONAL' => 'Internasional',
                                        'EXPEDITURE' => 'Expediture',
                                        'PERORANGAN' => 'Perorangan'
                                        );?>
                                      <tr>
                                        <td class="text-center"><?php if (isset($prefix[$vendor_detail["PREFIX"]])) { echo $prefix[$vendor_detail["PREFIX"]]; } ?></td>
                                        <td class="text-center"><?php echo $vendor_detail["VENDOR_NAME"]; ?></td>
                                        <td class="text-center"><?php if (isset($suffix[$vendor_detail["SUFFIX"]])) { echo $suffix[$vendor_detail["SUFFIX"]]; } ?></td>
                                        <td class="text-center"><?php if($vendor_detail["VENDOR_TYPE"]!='NASIONAL'){ echo $options[$vendor_detail["VENDOR_TYPE"]]; } else { echo $vendor_detail["VENDOR_TYPE"]; } ?></td>
                                      </tr>
                                    <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>
                                  
                                  <?php echo form_close(); ?>
                                  <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Info Perusahaan">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Info Perusahaan", $vendor_progress)) {
                                                            $reason = $vendor_progress["Info Perusahaan"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Alamat Perusahaan"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Alamat Perusahaan"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                  <strong>Data Lama</strong>
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
                                      <?php if (empty($company_address_old)) { ?>
                                      <tr id="empty_row">
                                        <td colspan="11" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      $no = 1;
                                      foreach ($company_address_old as $key => $address) { ?>
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
                                  <hr>
                                  <strong>Data Baru</strong>
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
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Alamat Perusahaan">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Alamat Perusahaan", $vendor_progress)) {
                                                            $reason = $vendor_progress["Alamat Perusahaan"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Kontak Perusahaan"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Kontak Perusahaan"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                  <strong>Data Lama</strong>
                                  <div class="table-responsive">
                                  <table class="table table-hover margin-bottom-20" id="info_perusahaan">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Nama Lengkap</th>
                                        <th class="text-center">Jabatan</th>
                                        <th class="text-center">No. Telp</th>
                                        <th class="text-center">No. HP</th>
                                        <th class="text-center">Email</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail_old["CONTACT_NAME"])) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      $options = array(
                                        'NASIONAL' => 'Nasional',
                                        'INTERNASIONAL' => 'Internasional',
                                        'EXPEDITURE' => 'Expediture',
                                        'PERORANGAN' => 'Perorangan'
                                        );
                                      ?>
                                      <tr>
                                        <td class="text-center"><?php echo $vendor_detail_old["CONTACT_NAME"]?></td>
                                        <td class="text-center"><?php echo $vendor_detail_old["CONTACT_POS"]; ?></td>
                                        <td class="text-center"><?php echo $vendor_detail_old["CONTACT_PHONE_NO"]; ?></td>
                                        <td class="text-center"><?php echo $vendor_detail_old["CONTACT_PHONE_HP"]; ?></td>
                                        <td class="text-center"><?php echo $vendor_detail_old["CONTACT_EMAIL"]?></td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>
                                  <hr>

                                  <strong>Data Baru</strong>
                                  <div class="table-responsive">
                                  <table class="table table-hover margin-bottom-20" id="info_perusahaan">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Nama Lengkap</th>
                                        <th class="text-center">Jabatan</th>
                                        <th class="text-center">No. Telp</th>
                                        <th class="text-center">No. HP</th>
                                        <th class="text-center">Email</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail["CONTACT_NAME"])) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      $options = array(
                                        'NASIONAL' => 'Nasional',
                                        'INTERNASIONAL' => 'Internasional',
                                        'EXPEDITURE' => 'Expediture',
                                        'PERORANGAN' => 'Perorangan'
                                        );
                                      ?>
                                      <tr>
                                        <td class="text-center"><?php echo $vendor_detail["CONTACT_NAME"]?></td>
                                        <td class="text-center"><?php echo $vendor_detail["CONTACT_POS"]; ?></td>
                                        <td class="text-center"><?php echo $vendor_detail["CONTACT_PHONE_NO"]; ?></td>
                                        <td class="text-center"><?php echo $vendor_detail["CONTACT_PHONE_HP"]; ?></td>
                                        <td class="text-center"><?php echo $vendor_detail["CONTACT_EMAIL"]?></td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>

                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Kontak Perusahaan">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Kontak Perusahaan", $vendor_progress)) {
                                                            $reason = $vendor_progress["Kontak Perusahaan"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Akta Pendirian"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else  if ($vendor_progress["Akta Pendirian"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                  <strong>Data Lama</strong>         
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
                                      <?php if (empty($vendor_akta_old)) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      $no = 1;
                                      foreach ($vendor_akta_old as $key => $akta) { ?>
                                      <tr id="<?php echo $akta['AKTA_ID']; ?>">
                                        <td class="text-center"><?php echo $no++; ?></td>
                                        <td class="text-center">
                                            <?php if (!empty($akta["AKTA_NO_DOC"])){ ?>
                                              <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $akta['AKTA_NO_DOC']; ?>"><?php echo $akta['AKTA_NO']; ?> </a>
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
                                                <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $akta['PENGESAHAN_HAKIM_DOC']; ?>"><?php echo vendorfromdate($akta['PENGESAHAN_HAKIM']); ?></a>
                                             <?php } else {   echo vendorfromdate($akta['PENGESAHAN_HAKIM']); } ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (!empty($akta["BERITA_ACARA_NGR_DOC"])){ ?>
                                                <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $akta['BERITA_ACARA_NGR_DOC']; ?>"><?php echo vendorfromdate($akta['BERITA_ACARA_NGR']); ?></a>
                                             <?php } else {  echo vendorfromdate($akta['BERITA_ACARA_NGR']); } ?>
                                        </td>
                                      </tr>
                                      <?php }
                                      ?>

                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>
                                  <hr>
                                  <strong>Data Baru</strong> 
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
                                        <td class="text-center">
                                          <?php if (!empty($akta["AKTA_NO_DOC"])){ ?>
                                              <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $akta['AKTA_NO_DOC']; ?>"><?php echo $akta['AKTA_NO']; ?></a>
                                          <?php } else {   echo $akta["AKTA_NO"]; } ?>
                                        </td>
                                        <td class="text-center"><?php echo $akta['AKTA_TYPE']; ?></td>
                                        <td class="text-center"><?php echo vendorfromdate($akta['DATE_CREATION']); ?></td>
                                        <td class="text-center"><?php echo $akta['NOTARIS_NAME']; ?></td>
                                        <td class="text-center"><?php echo $akta['NOTARIS_ADDRESS']; ?></td>
                                        <td class="text-center">
                                          <?php if (!empty($akta["PENGESAHAN_HAKIM_DOC"])){ ?> 
                                              <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $akta['PENGESAHAN_HAKIM_DOC']; ?>"><?php echo vendorfromdate($akta['PENGESAHAN_HAKIM']); ?></a>
                                          <?php } else {  echo vendorfromdate($akta['PENGESAHAN_HAKIM']); } ?>
                                        </td>
                                        <td class="text-center">
                                          <?php if (!empty($akta["BERITA_ACARA_NGR_DOC"])){ ?> 
                                              <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $akta['BERITA_ACARA_NGR_DOC']; ?>"><?php echo vendorfromdate($akta['BERITA_ACARA_NGR']); ?></a>
                                          <?php } else { echo vendorfromdate($akta['BERITA_ACARA_NGR']); } ?>
                                        </td>
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
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Akta Pendirian">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Akta Pendirian", $vendor_progress)) {
                                                            $reason = $vendor_progress["Akta Pendirian"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Domisili Perusahaan"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Domisili Perusahaan"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                  <strong>Data Lama</strong>
                                  <div class="table-responsive">
                                  <table class="table table-hover margin-bottom-20" id="domisili_perusahaan">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Nomor Domisili</th>
                                        <th class="text-center">Tanggal Domisili</th>
                                        <th class="text-center">Domisili Kadaluarsa</th>
                                        <th class="text-center">Alamat Perusahaan</th>
                                        <?php if ($vendor_detail["ADDRESS_COUNTRY"] == "ID"){ ?>
                                        <th class="text-center">Kota</th>
                                        <th class="text-center">Propinsi</th>
                                        <?php } else { ?>
                                        <th class="text-center">Kota</th>
                                        <?php } ?>
                                        <th class="text-center">Negara</th>
                                        <th class="text-center">Kode Pos</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail_old["ADDRESS_DOMISILI_NO"])) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      ?>
                                      <tr>
                                        <td class="text-center">
                                          <?php if (!empty($vendor_detail_old["DOMISILI_NO_DOC"])){ ?>
                                            <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $vendor_detail_old['DOMISILI_NO_DOC']; ?>"><?php echo $vendor_detail_old["ADDRESS_DOMISILI_NO"];?></a>
                                          <?php } else { ?>
                                            <?php echo $vendor_detail_old["ADDRESS_DOMISILI_NO"];?>
                                          <?php } ?>
                                        </td>
                                        <td class="text-center"><?php echo vendorfromdate($vendor_detail_old["ADDRESS_DOMISILI_DATE"]);?></td>
                                        <td class="text-center"><?php echo vendorfromdate($vendor_detail_old["ADDRESS_DOMISILI_EXP_DATE"]);?></td>
                                        <td class="text-center"><?php echo $vendor_detail_old["ADDRESS_STREET"];?></td>
                                        <?php if ($vendor_detail_old["ADDRESS_COUNTRY"] == "ID"){ ?>
                                        <td class="text-center"><?php echo $city_list[$vendor_detail_old["ADDRESS_CITY"]];?></td>
                                        <td class="text-center"><?php echo $province_list[$vendor_detail_old["ADDRES_PROP"]];?></td>
                                        <td class="text-center"><?php echo $country[$vendor_detail_old["ADDRESS_COUNTRY"]];?></td>
                                        <?php } else { ?>
                                        <td class="text-center"><?php echo $vendor_detail_old["ADDRESS_CITY"];?></td>
                                        <td class="text-center"><?php echo $vendor_detail_old["ADDRESS_COUNTRY"];?></td>
                                        <?php } ?>
                                        <td class="text-center"><?php echo $vendor_detail_old["ADDRESS_POSTCODE"];?></td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>
                                  <hr>
                                  <strong>Data Baru</strong>
                                  <div class="table-responsive">
                                  <table class="table table-hover margin-bottom-20" id="domisili_perusahaan">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Nomor Domisili</th>
                                        <th class="text-center">Tanggal Domisili</th>
                                        <th class="text-center">Domisili Kadaluarsa</th>
                                        <th class="text-center">Alamat Perusahaan</th>
                                        <?php if ($vendor_detail["ADDRESS_COUNTRY"] == "ID"){ ?>
                                        <th class="text-center">Kota</th>
                                        <th class="text-center">Propinsi</th>
                                        <?php } else { ?>
                                        <th class="text-center">Kota</th>
                                        <?php } ?>
                                        <th class="text-center">Negara</th>
                                        <th class="text-center">Kode Pos</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail)) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      ?>
                                      <tr>
                                        <td class="text-center">
                                          <?php if (!empty($vendor_detail["DOMISILI_NO_DOC"])){ ?>
                                            <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $vendor_detail['DOMISILI_NO_DOC']; ?>"><?php echo $vendor_detail["ADDRESS_DOMISILI_NO"];?></a>
                                          <?php } else { ?>
                                            <?php echo $vendor_detail["ADDRESS_DOMISILI_NO"];?>
                                          <?php } ?>
                                        </td>
                                        <td class="text-center"><?php echo vendorfromdate($vendor_detail["ADDRESS_DOMISILI_DATE"]);?></td>
                                        <td class="text-center"><?php echo vendorfromdate($vendor_detail["ADDRESS_DOMISILI_EXP_DATE"]);?></td>
                                        <td class="text-center"><?php echo $vendor_detail["ADDRESS_STREET"];?></td>
                                        <?php if ($vendor_detail["ADDRESS_COUNTRY"] == "ID"){ ?>
                                        <td class="text-center"><?php echo $city_list[$vendor_detail["ADDRESS_CITY"]];?></td>
                                        <td class="text-center"><?php echo $province_list[$vendor_detail["ADDRES_PROP"]];?></td>
                                        <?php } else { ?>
                                        <td class="text-center"><?php echo isset($vendor_detail["ADDRESS_CITY"]) ? $city_list[$vendor_detail["ADDRESS_CITY"]] : '';?></td>
                                        <?php } ?>
                                        <td class="text-center"><?php echo isset($vendor_detail["ADDRESS_COUNTRY"]) ? $country[$vendor_detail["ADDRESS_COUNTRY"]] : '';?></td>
                                        <td class="text-center"><?php echo $vendor_detail["ADDRESS_POSTCODE"];?></td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>
                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Domisili Perusahaan">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Domisili Perusahaan", $vendor_progress)) {
                                                            $reason = $vendor_progress["Domisili Perusahaan"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["NPWP"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["NPWP"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                  <strong>Data Lama</strong>
                                  <div class="table-responsive">
                                  <table class="table table-hover margin-bottom-20" id="NPWP_data">
                                    <thead>
                                      <tr>
                                        <th class="text-center">NPWP No.</th>
                                        <th class="text-center">Alamat (Sesuai NPWP)</th>
                                        <th class="text-center">Kota</th>
                                        <th class="text-center">Propinsi</th>
                                        <th class="text-center">Kode Pos</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail_old["NPWP_NO"])) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      ?>
                                      <tr>
                                        <td class="text-center">
                                          <?php if(!empty($vendor_detail_old["NPWP_NO_DOC"])) { ?>
                                            <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $vendor_detail_old['NPWP_NO_DOC']; ?>"><?php echo $vendor_detail_old["NPWP_NO"];?></a>
                                          <?php } else { 
                                            echo $vendor_detail_old["NPWP_NO"];
                                          }?>

                                        </td>
                                        <td class="text-center"><?php echo $vendor_detail_old["NPWP_ADDRESS"]; ?></td>
                                        <td class="text-center"><?php echo $city_list[$vendor_detail_old["NPWP_CITY"]]; ?></td>
                                        <td class="text-center"><?php echo $province_list[$vendor_detail_old["NPWP_PROP"]]; ?></td>
                                        <td class="text-center"><?php echo $vendor_detail_old["NPWP_POSTCODE"]; ?></td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>
                                  <hr>

                                  <strong>Data Baru</strong>
                                  <div class="table-responsive">
                                  <table class="table table-hover margin-bottom-20" id="NPWP_data">
                                    <thead>
                                      <tr>
                                        <th class="text-center">NPWP No.</th>
                                        <th class="text-center">Alamat (Sesuai NPWP)</th>
                                        <th class="text-center">Kota</th>
                                        <th class="text-center">Propinsi</th>
                                        <th class="text-center">Kode Pos</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail["NPWP_NO"])) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      ?>
                                      <tr>
                                        <td class="text-center">
                                          <?php if(!empty($vendor_detail["NPWP_NO_DOC"])) { ?>
                                            <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $vendor_detail['NPWP_NO_DOC']; ?>"><?php echo $vendor_detail["NPWP_NO"];?></a>
                                          <?php } else { 
                                            echo $vendor_detail["NPWP_NO"];
                                          }?>

                                        </td>
                                        <td class="text-center"><?php echo $vendor_detail["NPWP_ADDRESS"]; ?></td>
                                        <td class="text-center"><?php echo $city_list[$vendor_detail["NPWP_CITY"]]; ?></td>
                                        <td class="text-center"><?php echo $province_list[$vendor_detail["NPWP_PROP"]]; ?></td>
                                        <td class="text-center"><?php echo $vendor_detail["NPWP_POSTCODE"]; ?></td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>
                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="NPWP">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("NPWP", $vendor_progress)) {
                                                            $reason = $vendor_progress["NPWP"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["PKP"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["PKP"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                  <strong>Data Lama</strong>
                                  <div class="table-responsive">
                                  <table class="table table-hover margin-bottom-20" id="info_perusahaan">
                                    <thead>
                                      <tr>
                                        <th class="text-center">PKP</th>
                                        <th class="text-center">Nomor PKP</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail_old['NPWP_PKP_NO'])) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      $pkp_options = array(
                                        'PKP' => 'PKP',
                                        'Bukan PKP' => 'Bukan PKP',
                                        );
                                      ?>
                                      <tr>
                                        <td class="text-center"><?php echo isset($vendor_detail_old["NPWP_PKP"]) ? $vendor_detail_old["NPWP_PKP"] : '';?></td>
                                        <td class="text-center">
                                        <?php if (!empty($vendor_detail_old["PKP_NO_DOC"])) {; ?>
                                          <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $vendor_detail_old['PKP_NO_DOC']; ?>"><?php echo $vendor_detail_old["NPWP_PKP_NO"];?></a>
                                        <?php } else { echo $vendor_detail_old["NPWP_PKP_NO"]; } ?>
                                        </td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>
                                  <hr>

                                  <strong>Data Baru</strong>
                                  <div class="table-responsive">
                                  <table class="table table-hover margin-bottom-20" id="info_perusahaan">
                                    <thead>
                                      <tr>
                                        <th class="text-center">PKP</th>
                                        <th class="text-center">Nomor PKP</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail['NPWP_PKP_NO'])) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      $pkp_options = array(
                                        'PKP' => 'PKP',
                                        'Bukan PKP' => 'Bukan PKP',
                                        );
                                      ?>
                                      <tr>
                                        <td class="text-center"><?php echo isset($vendor_detail["NPWP_PKP"]) ? $vendor_detail["NPWP_PKP"]: '';?></td>
                                        <td class="text-center">
                                        <?php if (!empty($vendor_detail["PKP_NO_DOC"])) {; ?>
                                          <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $vendor_detail['PKP_NO_DOC']; ?>"><?php echo $vendor_detail["NPWP_PKP_NO"];?></a>
                                        <?php } else { echo $vendor_detail["NPWP_PKP_NO"] ;} ?>
                                        </td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>
                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="PKP">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("PKP", $vendor_progress)) {
                                                            $reason = $vendor_progress["PKP"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["SIUP"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["SIUP"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                  <strong>Data Lama</strong>
                                  <div class="table-responsive">
                                  <table class="table table-hover margin-bottom-20" id="info_perusahaan">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Dikeluarkan Oleh</th>
                                        <th class="text-center">Nomor</th>
                                        <th class="text-center">SIUP</th>
                                        <th class="text-center">Berlaku Mulai</th>
                                        <th class="text-center">Sampai</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail_old['SIUP_NO'])) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      ?>
                                      <tr>
                                        <td class="text-center"><?php echo $vendor_detail_old["SIUP_ISSUED_BY"] ?></td>
                                        <td class="text-center">
                                        <?php if (!empty($vendor_detail_old["SIUP_NO_DOC"])){ ?>
                                          <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $vendor_detail_old['SIUP_NO_DOC']; ?>"><?php echo $vendor_detail_old["SIUP_NO"];?></a>
                                        <?php } else {
                                          echo $vendor_detail_old["SIUP_NO"];
                                        } ?>                                        
                                        </td>
                                        <td class="text-center"><?php echo isset($vendor_detail_old['SIUP_TYPE']) ? $vendor_detail_old['SIUP_TYPE'] : '';?></td>
                                        <td class="text-center"><?php echo vendorfromdate($vendor_detail_old["SIUP_FROM"]) ?></td>
                                        <td class="text-center"><?php echo vendorfromdate($vendor_detail_old["SIUP_TO"]) ?></td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>
                                  <hr>

                                  <strong>Data Baru</strong>
                                  <div class="table-responsive">
                                  <table class="table table-hover margin-bottom-20" id="info_perusahaan">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Dikeluarkan Oleh</th>
                                        <th class="text-center">Nomor</th>
                                        <th class="text-center">SIUP</th>
                                        <th class="text-center">Berlaku Mulai</th>
                                        <th class="text-center">Sampai</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail['SIUP_NO'])) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      ?>
                                      <tr>
                                        <td class="text-center"><?php echo $vendor_detail["SIUP_ISSUED_BY"] ?></td>
                                        <td class="text-center">
                                        <?php if (!empty($vendor_detail["SIUP_NO_DOC"])){ ?>
                                          <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $vendor_detail['SIUP_NO_DOC']; ?>"><?php echo $vendor_detail["SIUP_NO"];?></a>
                                        <?php } else {
                                          echo $vendor_detail["SIUP_NO"];
                                        } ?>                                        
                                        </td>
                                        <td class="text-center"><?php echo isset($vendor_detail['SIUP_TYPE']) ? $vendor_detail['SIUP_TYPE'] : '';?></td>
                                        <td class="text-center"><?php echo vendorfromdate($vendor_detail["SIUP_FROM"]) ?></td>
                                        <td class="text-center"><?php echo vendorfromdate($vendor_detail["SIUP_TO"]) ?></td>
                                      </tr>
                                    <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>
                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="SIUP">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("SIUP", $vendor_progress)) {
                                                            $reason = $vendor_progress["SIUP"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["TDP"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["TDP"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                  <strong>Data Lama</strong>
                                  <div class="table-responsive">
                                  <table class="table table-hover margin-bottom-20" id="info_perusahaan">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Dikeluarkan Oleh</th>
                                        <th class="text-center">Nomor</th>                                        
                                        <th class="text-center">Berlaku Mulai</th>
                                        <th class="text-center">Sampai</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail_old['TDP_NO'])) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      ?>
                                      <tr>
                                        <td class="text-center"><?php echo $vendor_detail_old["TDP_ISSUED_BY"] ?></td>
                                        <td class="text-center">
                                        <?php if (!empty($vendor_detail_old["TDP_NO_DOC"])){ ?>
                                          <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $vendor_detail_old['TDP_NO_DOC']; ?>"><?php echo $vendor_detail_old["TDP_NO"];?></a>
                                        <?php } else {
                                          echo $vendor_detail_old["TDP_NO"];
                                        } ?>                                        
                                        </td>
                                        <td class="text-center"><?php echo vendorfromdate($vendor_detail_old["TDP_FROM"]) ?></td>
                                        <td class="text-center"><?php echo vendorfromdate($vendor_detail_old["TDP_TO"]) ?></td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>
                                  <hr>

                                  <strong>Data Baru</strong>
                                  <div class="table-responsive">
                                  <table class="table table-hover margin-bottom-20" id="info_perusahaan">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Dikeluarkan Oleh</th>
                                        <th class="text-center">Nomor</th>                                        
                                        <th class="text-center">Berlaku Mulai</th>
                                        <th class="text-center">Sampai</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail['TDP_NO'])) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      ?>
                                      <tr>
                                        <td class="text-center"><?php echo $vendor_detail["TDP_ISSUED_BY"] ?></td>
                                        <td class="text-center">
                                        <?php if (!empty($vendor_detail["TDP_NO_DOC"])){ ?>
                                          <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $vendor_detail['TDP_NO_DOC']; ?>"><?php echo $vendor_detail["TDP_NO"];?></a>
                                        <?php } else {
                                          echo $vendor_detail["TDP_NO"];
                                        } ?>                                        
                                        </td>
                                        <td class="text-center"><?php echo vendorfromdate($vendor_detail["TDP_FROM"]) ?></td>
                                        <td class="text-center"><?php echo vendorfromdate($vendor_detail["TDP_TO"]) ?></td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>

                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="TDP">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("TDP", $vendor_progress)) {
                                                            $reason = $vendor_progress["TDP"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Angka Pengenal Importir"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Angka Pengenal Importir"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                  <strong>Data Lama</strong>
                                  <div class="table-responsive">
                                  <table class="table table-hover margin-bottom-20" id="info_perusahaan">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Dikeluarkan Oleh</th>
                                        <th class="text-center">Nomor</th>                                        
                                        <th class="text-center">Berlaku Mulai</th>
                                        <th class="text-center">Sampai</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail_old['API_NO'])) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      ?>
                                      <tr>
                                        <td class="text-center"><?php echo $vendor_detail_old["API_ISSUED_BY"] ?></td>
                                        <td class="text-center"><?php echo $vendor_detail_old["API_NO"];?></td>
                                        <td class="text-center"><?php echo vendorfromdate($vendor_detail_old["API_FROM"]) ?></td>
                                        <td class="text-center"><?php echo vendorfromdate($vendor_detail_old["API_TO"]) ?></td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>
                                  <hr>

                                  <strong>Data Baru</strong>
                                  <div class="table-responsive">
                                  <table class="table table-hover margin-bottom-20" id="info_perusahaan">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Dikeluarkan Oleh</th>
                                        <th class="text-center">Nomor</th>                                        
                                        <th class="text-center">Berlaku Mulai</th>
                                        <th class="text-center">Sampai</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail['API_NO'])) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      ?>
                                      <tr>
                                        <td class="text-center"><?php echo $vendor_detail["API_ISSUED_BY"] ?></td>
                                        <td class="text-center"><?php echo $vendor_detail["API_NO"];?></td>
                                        <td class="text-center"><?php echo vendorfromdate($vendor_detail["API_FROM"]) ?></td>
                                        <td class="text-center"><?php echo vendorfromdate($vendor_detail["API_TO"]) ?></td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  </div>
                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Angka Pengenal Importir">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Angka Pengenal Importir", $vendor_progress)) {
                                                            $reason = $vendor_progress["Angka Pengenal Importir"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Dewan Komisaris"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Dewan Komisaris"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                        <strong>Data Lama</strong>
                                        <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="vendor_board_commissioner_old">
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
                                                <?php if (empty($vendor_board_commissioner_old)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($vendor_board_commissioner_old as $key => $board) { ?>
                                                <tr id="<?php echo $board['BOARD_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $board['NAME']; ?></td>
                                                    <td class="text-center"><?php echo $board['POS']; ?></td>
                                                    <td class="text-center"><?php echo $board['TELEPHONE_NO']; ?></td>
                                                    <td class="text-center"><?php echo $board['EMAIL_ADDRESS']; ?></td>
                                                    <td class="text-center"><?php if (!empty($board['KTP_FILE'])){ ?> <a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $board['KTP_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $board['KTP_NO']; ?></a> <?php } else {  echo $board['KTP_NO']; } ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($board['KTP_EXPIRED_DATE']); ?></td>
                                                    <td class="text-center"><?php echo $board['NPWP_NO']; ?></td>
                                                </tr>
                                                    <?php }
                                                ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                        <hr>
                                        <strong>Data Baru</strong>
                                        <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="vendor_board_commissioner_old">
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
                                                    <td class="text-center"><?php if (!empty($board['KTP_FILE'])){ ?> <a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $board['KTP_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $board['KTP_NO']; ?></a> <?php } else {  echo $board['KTP_NO']; } ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($board['KTP_EXPIRED_DATE']); ?></td>
                                                    <td class="text-center"><?php echo $board['NPWP_NO']; ?></td>
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
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Dewan Komisaris">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Dewan Komisaris", $vendor_progress)) {
                                                            $reason = $vendor_progress["Dewan Komisaris"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Dewan Direksi"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Dewan Direksi"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                        <strong>Data Lama</strong>
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
                                                <?php if (empty($vendor_board_director_old)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($vendor_board_director_old as $key => $board) { ?>
                                                <tr id="<?php echo $board['BOARD_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $board['NAME']; ?></td>
                                                    <td class="text-center"><?php echo $board['POS']; ?></td>
                                                    <td class="text-center"><?php echo $board['TELEPHONE_NO']; ?></td>
                                                    <td class="text-center"><?php echo $board['EMAIL_ADDRESS']; ?></td>
                                                    <td class="text-center"><?php if (!empty($board['KTP_FILE'])){ ?> <a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $board['KTP_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $board['KTP_NO']; ?></a> <?php } else {  echo $board['KTP_NO']; } ?></td>

                                                    <td class="text-center"><?php echo vendorfromdate($board['KTP_EXPIRED_DATE']); ?></td>
                                                    <td class="text-center"><?php echo $board['NPWP_NO']; ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                        <hr>
                                        <strong>Data Baru</strong>
                                        <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="vendor_board_director_old">
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
                                                    <td class="text-center"><?php if (!empty($board['KTP_FILE'])){ ?> <a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $board['KTP_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $board['KTP_NO']; ?></a> <?php } else {  echo $board['KTP_NO']; } ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($board['KTP_EXPIRED_DATE']); ?></td>
                                                    <td class="text-center"><?php echo $board['NPWP_NO']; ?></td>
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
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Dewan Direksi">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Dewan Direksi", $vendor_progress)) {
                                                            $reason = $vendor_progress["Dewan Direksi"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Rekening Bank"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Rekening Bank"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                        <strong>Data Lama</strong>
                                        <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="vendor_bank_old">
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
                                                <?php if (empty($vendor_bank_old)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($vendor_bank_old as $key => $bank) { ?>
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
                                        </div>
                                        <hr>
                                        <strong>Data Baru</strong>
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
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
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
                                        </div>
                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Rekening Bank">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Rekening Bank", $vendor_progress)) {
                                                            $reason = $vendor_progress["Rekening Bank"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Modal Sesuai Dengan Akta Terakhir"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Modal Sesuai Dengan Akta Terakhir"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                  <strong>Data Lama</strong>
                                  <table class="table table-hover margin-bottom-20" id="info_perusahaan">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Modal Dasar</th>
                                        <th class="text-center">Currency</th>
                                        <th class="text-center">Modal Disetor</th>
                                        <th class="text-center">Currency</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail_old['FIN_AKTA_MDL_DSR'])) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      ?>
                                      <tr>
                                        <td class="text-center"><?php echo number_format($vendor_detail_old["FIN_AKTA_MDL_DSR"]);?></td>
                                        <td class="text-center"><?php echo $currency[$vendor_detail_old["FIN_AKTA_MDL_DSR_CURR"]]; ?></td>
                                        <td class="text-center"><?php echo number_format($vendor_detail_old["FIN_AKTA_MDL_STR"]); ?></td>
                                        <td class="text-center"><?php echo $currency[$vendor_detail_old["FIN_AKTA_MDL_STR_CURR"]]; ?></td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  <hr>
                                  <strong>Data Baru</strong>
                                  <table class="table table-hover margin-bottom-20" id="info_perusahaan">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Modal Dasar</th>
                                        <th class="text-center">Currency</th>
                                        <th class="text-center">Modal Disetor</th>
                                        <th class="text-center">Currency</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tableItem">
                                      <?php if (empty($vendor_detail['FIN_AKTA_MDL_DSR'])) { ?>
                                      <tr id="empty_row">
                                        <td colspan="9" class="text-center">- Belum ada data -</td>
                                      </tr>
                                      <?php
                                    }
                                    else {
                                      ?>
                                      <tr>
                                        <td class="text-center"><?php echo number_format($vendor_detail["FIN_AKTA_MDL_DSR"]);?></td>
                                        <td class="text-center"><?php echo $currency[$vendor_detail["FIN_AKTA_MDL_DSR_CURR"]]; ?></td>
                                        <td class="text-center"><?php echo number_format($vendor_detail["FIN_AKTA_MDL_STR"]); ?></td>
                                        <td class="text-center"><?php echo $currency[$vendor_detail["FIN_AKTA_MDL_STR_CURR"]]; ?></td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Modal Sesuai Dengan Akta Terakhir">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Modal Sesuai Dengan Akta Terakhir", $vendor_progress)) {
                                                            $reason = $vendor_progress["Modal Sesuai Dengan Akta Terakhir"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Informasi Laporan Keuangan"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Informasi Laporan Keuangan"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                        <strong>Data Lama</strong>
                                        <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="vendor_fin_report_old">
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
                                                <?php if (empty($vendor_fin_report_old)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($vendor_fin_report_old as $key => $report) { ?>
                                                <tr id="<?php echo $report['FIN_RPT_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php if (!empty($report['FILE_UPLOAD'])){ ?><a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $report['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $report['FIN_RPT_YEAR']; ?></a><?php } else {  echo $report['FIN_RPT_YEAR']; } ?>
                                                            </td>
                                                    <td class="text-center"><?php echo $report['FIN_RPT_TYPE']; ?></td>
                                                    <td class="text-center"><?php echo $report['FIN_RPT_CURRENCY']; ?></td>
                                                    <td class="text-right"><?php echo number_format($report['FIN_RPT_ASSET_VALUE']); ?></td>
                                                    <td class="text-right"><?php echo number_format($report['FIN_RPT_HUTANG']); ?></td>
                                                    <td class="text-right"><?php echo number_format($report['FIN_RPT_REVENUE']); ?></td>
                                                    <td class="text-right"><?php echo number_format($report['FIN_RPT_NETINCOME']); ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                        <hr>
                                        <strong>Data Baru</strong>
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
                                                    <td class="text-center"><?php if (!empty($report['FILE_UPLOAD'])){ ?><a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $report['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $report['FIN_RPT_YEAR']; ?></a><?php } else {  echo $report['FIN_RPT_YEAR']; } ?>
                                                            </td>
                                                    <td class="text-center"><?php echo $report['FIN_RPT_TYPE']; ?></td>
                                                    <td class="text-center"><?php echo $report['FIN_RPT_CURRENCY']; ?></td>
                                                    <td class="text-right"><?php echo number_format($report['FIN_RPT_ASSET_VALUE']); ?></td>
                                                    <td class="text-right"><?php echo number_format($report['FIN_RPT_HUTANG']); ?></td>
                                                    <td class="text-right"><?php echo number_format($report['FIN_RPT_REVENUE']); ?></td>
                                                    <td class="text-right"><?php echo number_format($report['FIN_RPT_NETINCOME']); ?></td>
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
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Informasi Laporan Keuangan">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Informasi Laporan Keuangan", $vendor_progress)) {
                                                            $reason = $vendor_progress["Informasi Laporan Keuangan"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Barang dan bahan yang bisa dipasok"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Barang dan bahan yang bisa dipasok"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
                                          };
                                    }
                              }
                              ?>
                              <span class="enar_occ_title <?php echo $color ?>">Barang yang bisa dipasok</span>
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
                                        <strong>Data Lama</strong>
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
                                                <?php if (empty($goods_old)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="11" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($goods_old as $key => $good) { ?>
                                                <tr id="<?php echo $good['PRODUCT_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $good['PRODUCT_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $good['PRODUCT_SUBGROUP_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $good['PRODUCT_DESCRIPTION']; ?></td>
                                                    <td class="text-center"><?php echo $good['BRAND']; ?></td>
                                                    <td class="text-center"><?php echo $good['SOURCE']; ?></td>
                                                    <td class="text-center"><?php echo $good['TYPE']; ?></td>
                                                    <td class="text-center"> <?php if (!empty($good['FILE_UPLOAD'])){ ?><a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $good['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $good['NO']; ?></a><?php } else {  echo $good["NO"]; } ?> </td>
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

                                        <hr>
                                        <strong>Data Baru</strong>
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
                                                    <td class="text-center"> <?php if (!empty($good['FILE_UPLOAD'])){ ?><a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $good['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $good['NO']; ?></a><?php } else {  echo $good["NO"]; } ?> </td>
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
                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Barang dan bahan yang bisa dipasok">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Barang dan bahan yang bisa dipasok", $vendor_progress)) {
                                                            $reason = $vendor_progress["Barang dan bahan yang bisa dipasok"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Bahan yang bisa dipasok"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Bahan yang bisa dipasok"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                  <?php echo form_open('Vendor_management',array('class' => 'form-horizontal general_form')); ?>
                                        <strong>Data Lama</strong>
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
                                                <?php if (empty($bahan_old)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="11" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($bahan_old as $key => $bhn_old) { ?>
                                                <tr id="<?php echo $bhn_old['PRODUCT_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $bhn_old['PRODUCT_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $bhn_old['PRODUCT_SUBGROUP_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $bhn_old['PRODUCT_DESCRIPTION']; ?></td>
                                                    <td class="text-center"><?php echo $bhn_old['SOURCE']; ?></td>
                                                    <td class="text-center"><?php echo $bhn_old['TYPE']; ?></td>
                                                    <td class="text-center"><?php echo $bhn_old['KLASIFIKASI_NAME']; ?></td>
                                                    <td class="text-center"> <?php if (!empty($bhn_old['FILE_UPLOAD'])){ ?><a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $bhn_old['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $bhn_old['NO']; ?></a><?php } else {  echo $bhn_old["NO"]; } ?> </td>
                                                    <td class="text-center"><?php echo $bhn_old['ISSUED_BY']; ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($bhn_old['ISSUED_DATE']); ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($bhn_old['EXPIRED_DATE']); ?></td>
                                                </tr>
                                                    <?php }
                                                ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                        <hr>
                                        <strong>Data Baru</strong>
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
                                                    <td class="text-center"> <?php if (!empty($bhn['FILE_UPLOAD'])){ ?><a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $bhn['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $bhn['NO']; ?></a><?php } else {  echo $bhn["NO"]; } ?> </td>
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
                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Bahan yang bisa dipasok">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Bahan yang bisa dipasok", $vendor_progress)) {
                                                            $reason = $vendor_progress["Bahan yang bisa dipasok"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                              } else if ($vendor_progress["Jasa yang bisa dipasok"]['STATUS'] == 'Rejected') {
                                                    $color = 'red';
                                              } else if ($vendor_progress["Jasa yang bisa dipasok"]['STATUS'] == 'Edited') {
                                                    $color = 'blue';
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
                                        <strong>Data Lama</strong>
                                        <div class="table-responsive">
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
                                                <?php if (empty($services_old)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="11" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php } else {
                                                    $no = 1;
                                                    foreach ($services_old as $key => $service) { ?>
                                                <tr id="<?php echo $service['PRODUCT_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $service['PRODUCT_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $service['PRODUCT_SUBGROUP_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $service['KLASIFIKASI_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $service['SUBKUALIFIKASI_NAME']; ?></td> 
                                                    <td class="text-center"><?php if (!empty($service['FILE_UPLOAD'])){ ?> <a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $service['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $service['NO']; ?></a> <?php } else {  echo $service['NO']; } ?> </td>
                                                    <td class="text-center"><?php echo $service['ISSUED_BY']; ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($service['ISSUED_DATE']); ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($service['EXPIRED_DATE']); ?></td>
                                                </tr>
                                                    <?php } ?> 
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                            <hr>
                                            <strong>Data Baru</strong>
                                        <div class="table-responsive">
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
                                                <?php } else {
                                                    $no = 1;
                                                    foreach ($services as $key => $service) { ?>
                                                <tr id="<?php echo $service['PRODUCT_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php echo $service['PRODUCT_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $service['PRODUCT_SUBGROUP_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $service['KLASIFIKASI_NAME']; ?></td>
                                                    <td class="text-center"><?php echo $service['SUBKUALIFIKASI_NAME']; ?></td> 
                                                    <td class="text-center"><?php if (!empty($service['FILE_UPLOAD'])){ ?> <a href="<?php echo base_url('Vendor_management'); ?>/viewDok/<?php echo $service['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $service['NO']; ?></a> <?php } else {  echo $service['NO']; } ?> </td>
                                                    <td class="text-center"><?php echo $service['ISSUED_BY']; ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($service['ISSUED_DATE']); ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($service['EXPIRED_DATE']); ?></td>
                                                </tr>
                                                    <?php } ?> 
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                              <?php echo form_close(); ?>
                                              <div class="panel-body text-center">
                                              <form class="form-inline">
                                                    <div class="form-group">
                                                          <select class="form-control action-option">
                                                                <option value="Infor Perusahaan">Approve</option>
                                                                <option value="Infor Perusahaan">Reject</option>
                                                          </select>
                                                    </div>
                                                    <button class="main_button color4 small_btn action-button-update" type="button" value="Jasa yang bisa dipasok">Submit</button>
                                              </form>
                                              <?php
                                              $reason = "";
                                              if(array_key_exists("Jasa yang bisa dipasok", $vendor_progress)) {
                                                    $reason = $vendor_progress["Jasa yang bisa dipasok"]["REASON"];
                                              }
                                              ?>
                                              <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Tenaga Ahli Utama"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Tenaga Ahli Utama"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                        <strong>Data Lama</strong>
                                        <div class="table-responsive">
                                        <table class="table table-hover margin-bottom-20" id="main_sdm_old">
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
                                                <?php if (empty($main_sdm_old)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="7" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($main_sdm_old as $key => $sdm) { ?>
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
                                        <hr>
                                        <strong>Data Baru</strong>
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
                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Tenaga Ahli Utama">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Tenaga Ahli Utama", $vendor_progress)) {
                                                            $reason = $vendor_progress["Tenaga Ahli Utama"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Tenaga Ahli Pendukung"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Tenaga Ahli Pendukung"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                        <strong>Data Lama</strong>
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
                                                <?php if (empty($support_sdm_old)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="7" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($support_sdm_old as $key => $sdm) { ?>
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
                                        <hr>
                                        <strong>Data Baru</strong>
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
                                                    <td class="text-center"><?php echo $sdm['YEAR_EXP']; ?>  Tahun</td>
                                                    <td class="text-center"><?php echo $sdm['EMP_STATUS']; ?></td>
                                                    <td class="text-center"><?php echo $sdm['EMP_TYPE']; ?></td>
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
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Tenaga Ahli Pendukung">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Tenaga Ahli Pendukung", $vendor_progress)) {
                                                            $reason = $vendor_progress["Tenaga Ahli Pendukung"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Keterangan Sertifikat"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Keterangan Sertifikat"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                        <strong>Data Lama</strong>
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
                                                <?php if (empty($certifications_old)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($certifications_old as $key => $certifications_old) { 
                                                    if ($certifications_old['TYPE'] != '') { ?>
                                                <tr id="<?php echo $certifications_old['CERT_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center">
                                                        <?php
                                                        if (!empty($certifications_old['TYPE_OTHER'])) {
                                                            echo $certifications_old['TYPE_OTHER'];
                                                        }
                                                        else {
                                                            echo $certificate_type[$certifications_old['TYPE']];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center"><?php echo $certifications_old['CERT_NAME']; ?></td>
                                                    <td class="text-center">
                                                        <?php if (isset($certifications_old['CERT_NO_DOC'])) { ?>
                                                        <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $certifications_old['CERT_NO_DOC']; ?>"><?php echo $certifications_old['CERT_NO']; ?></a>
                                                        <?php } else { ?>
                                                        <?php echo $certifications_old['CERT_NO']; ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-center"><?php echo $certifications_old['ISSUED_BY']; ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($certifications_old['VALID_FROM']); ?></td>
                                                    <td class="text-center"><?php echo vendorfromdate($certifications_old['VALID_TO']); ?></td>
                                                </tr>
                                                    <?php }else{ ?>
                                                <tr id="empty_row">
                                                    <td colspan="7" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                    <?php } } ?>

                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                        <hr>
                                        <strong>Data Baru</strong>
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
                                                <?php $cektp = $certifications[0]['TYPE']; if ($cektp == '') { ?>
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
                                                        if (!empty($certifications['TYPE_OTHER'])) {
                                                            echo $certifications['TYPE_OTHER'];
                                                        }
                                                        else {
                                                            echo $certificate_type[$certifications['TYPE']];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center"><?php echo $certifications['CERT_NAME']; ?></td>
                                                    <td class="text-center">
                                                        <?php if (isset($certifications['CERT_NO_DOC'])) { ?>
                                                        <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $certifications['CERT_NO_DOC']; ?>"><?php echo $certifications['CERT_NO']; ?></a>
                                                        <?php } else { ?>
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
                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Keterangan Sertifikat">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Keterangan Sertifikat", $vendor_progress)) {
                                                            $reason = $vendor_progress["Keterangan Sertifikat"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Keterangan Tentang Fasilitas dan Peralatan"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Keterangan Tentang Fasilitas dan Peralatan"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                        <strong>Data Lama</strong>
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
                                                <?php if (empty($equipments_old)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="7" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($equipments_old as $key => $equipment) { ?>
                                                <tr id="<?php echo $equipment['EQUIP_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center"><?php
                                                        if ($equipment['CATEGORY'] != '') {
                                                            echo $tools_category[$equipment['CATEGORY']]; 
                                                        } ?></td>
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
                                        <hr>
                                        <strong>Data Baru</strong>
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
                                                    <td class="text-center"><?php echo $tools_category[$equipment['CATEGORY']]; ?></td>
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
                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Keterangan Tentang Fasilitas dan Peralatan">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Keterangan Tentang Fasilitas dan Peralatan", $vendor_progress)) {
                                                            $reason = $vendor_progress["Keterangan Tentang Fasilitas dan Peralatan"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Pekerjaan"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Pekerjaan"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                        <strong>Data Lama</strong>
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
                                                <?php if (empty($experiences_old)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="12" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($experiences_old as $key => $experience) { ?>
                                                <tr id="<?php echo $experience['CV_ID']; ?>">
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-center">
                                                        <?php if (isset($experience['CLIENT_NAME_DOC'])) { ?>
                                                        <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $experience['CLIENT_NAME_DOC']; ?>"><?php echo $experience['CLIENT_NAME']; ?></a>
                                                        <?php } else { ?>
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
                                        <hr>
                                        <strong>Data Baru</strong>
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
                                                    <td class="text-center">
                                                        <?php if (isset($experience['CLIENT_NAME_DOC'])) { ?>
                                                        <a target="_blank" href="<?php echo base_url('Vendor_management') ?>/viewDok/<?php echo $experience['CLIENT_NAME_DOC']; ?>"><?php echo $experience['CLIENT_NAME']; ?></a>
                                                        <?php } else { ?>
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
                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Pekerjaan">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Pekerjaan", $vendor_progress)) {
                                                            $reason = $vendor_progress["Pekerjaan"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Principal"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Principal"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                        <strong>Data Lama</strong>
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
                                                <?php if (empty($principals_old)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($principals_old as $key => $principal) { ?>
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
                                        <hr>
                                        <strong>Data Baru</strong>
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
                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Principal">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Principal", $vendor_progress)) {
                                                            $reason = $vendor_progress["Principal"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Subkontraktor"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Subkontraktor"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                        <strong>Data Lama</strong>
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
                                                <?php if (empty($subcontractors_old)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($subcontractors_old as $key => $subcontractor) { ?>
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
                                        <strong>Data Baru</strong>
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
                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Subkontraktor">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Subkontraktor", $vendor_progress)) {
                                                            $reason = $vendor_progress["Subkontraktor"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
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
                                          } else if ($vendor_progress["Perusahaan Afiliasi"]['STATUS'] == 'Rejected') {
                                                $color = 'red';
                                          } else if ($vendor_progress["Perusahaan Afiliasi"]['STATUS'] == 'Edited') {
                                                $color = 'blue';
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
                                        <strong>Data Lama</strong>
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
                                                <?php if (empty($affiliation_companies_old)) { ?>
                                                <tr id="empty_row">
                                                    <td colspan="8" class="text-center">- Belum ada data -</td>
                                                </tr>
                                                <?php
                                                }
                                                else {
                                                    $no = 1;
                                                    foreach ($affiliation_companies_old as $key => $affiliation_company) { ?>
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
                                        <hr>
                                        <strong>Data Baru</strong>
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
                                  <?php echo form_close(); ?>
                                                      <div class="panel-body text-center">
                                                      <form class="form-inline">
                                                            <div class="form-group">
                                                                  <select class="form-control action-option">
                                                                        <option value="Infor Perusahaan">Approve</option>
                                                                        <option value="Infor Perusahaan">Reject</option>
                                                                  </select>
                                                            </div>
                                                            <button class="main_button color4 small_btn action-button-update" type="button" value="Perusahaan Afiliasi">Submit</button>
                                                      </form>
                                                      <?php
                                                      $reason = "";
                                                      if(array_key_exists("Perusahaan Afiliasi", $vendor_progress)) {
                                                            $reason = $vendor_progress["Perusahaan Afiliasi"]["REASON"];
                                                      }
                                                      ?>
                                                      <textarea class="form-control reject-reason" style="visibility: hidden; margin-top: 10px" placeholder="Reject Reason"><?php echo $reason; ?></textarea>
                                                      </div>
                                </div>
                              </div>
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
<!-- KOMENTAR PROCUREMENT -->
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
                            
                            <input type="text" class="hidden vendor_id" id="form_akuntansi" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                            <input type="text" class="hidden vendor_id" id="comment" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                  
                          </div>
                        </div>
                    </div>
                  
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-body text-right">
                  <a href="<?php echo base_url(); ?>Vendor_management/job_list" class="main_button small_btn">Cancel</a>
                  <input value="<?php echo $emplo[0]['LEVEL']; ?>" id="level" name="level" type="hidden">
                  <button id="approve-vendor" class="main_button color6 small_btn" type="button">Approve</button>
                  <?php if ($emplo[0]['LEVEL'] != 1) { ?>
                      <button id="reject-update" class="main_button color1 small_btn" type="button">Reject</button>
                  <?php } else if ($emplo[0]['LEVEL'] == 1) { ?>
                      <button id="route-to-vendor-update" class="main_button color4 small_btn">Route to Vendor</button>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
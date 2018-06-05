<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row"> 
              <div class="form-horizontal">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Form Upload Manual Book</div>
                        <div class="panel-body"> 
                            <form method="post" action="<?php echo base_url('Panduan/insert_panduan') ?>">
                              <div class="form-group">
                                <input type="text" class="hidden" name="id_manual" id="id_manual">

                                    <label for="name_book" class="col-sm-3 control-label">Nama File<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-7"> 
                                        <input type="text" class="form-control" id="name_book" name="name_book">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tipefile" class="col-sm-3 control-label">Tipe File<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-9">
                                      <select id="tipefile" name="tipefile">
                                        <option value='1'>Admin</option>
                                        <option value='2'>User</option>
                                        <option value='3'>Vendor</option>
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name_file" class="col-sm-3 control-label">Upload File<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="hidden" class="form-control" id="name_file" name="name_file">
                                        <button type="button" class="uploadAttachment btn btn-default manual_book">Upload File (10MB Max)</button><span class="filenamespan"></span>
                                        &nbsp;&nbsp;<a class="btn btn-default delete_upload_file_mb glyphicon glyphicon-trash"></a>
                                        <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none; width: 50%">
                                            <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                              <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                  <a class="main_button small_btn bottom_space" href="<?php echo site_url(); ?>">Cancel</a>
                                  <button type="submit" class="main_button color1 small_btn bottom_space">Simpan</button>
                                  <div class="loader" style="margin-left: 10px; display: none;">
                                    <div class="loader-inner ball-pulse">
                                      <div></div>
                                      <div></div>
                                      <div></div>
                                      <div></div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </form>
                          <table class="table table-hover margin-bottom-20" id="tabel_panduan">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-left">Nama</th>
                                        <th class="text-left">Tanggal</th>
                                        <th class="text-left">Tipe File</th>
                                        <th class="text-left">File</th>
                                        <th class="text-left" style="width: 86px">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableItem">
                                    <?php if (empty($panduan)) { ?>
                                    <tr id="empty_row">
                                        <td colspan="8" class="text-center">- Belum ada data -</td>
                                    </tr>
                                    <?php } else { $no = 1; foreach ((array)$panduan as $key => $panduan) { ?>
                                    <tr id="<?php echo $panduan['ID_MANUAL']; ?>">
                                        <td class="text-center"><?php echo $no++; ?></td>
                                        <td><?php echo $panduan['NAMA']; ?></td>
                                        <td><?php echo vendorfromdate($panduan['TANGGAL']); ?></td> 
                                        <td><?php if($panduan['TIPE'] == 1){
                                                      echo "Admin";
                                                  } else if($panduan['TIPE'] == 2) {
                                                      echo "User";
                                                  } else{
                                                      echo "Vendor";
                                                  }
                                            ?></td>
                                        <td id"name_file" value="<?php echo $panduan['NAMA_FILE'];?>"><a href="<?php echo base_url('Panduan') ?>/viewDok/<?php echo $panduan['NAMA_FILE']; ?>" target="_blank" class="button-warning">Lihat File</a></td>
                                        
                                        <td><a title="Hapus" OnClick="deletedata(<?php echo $panduan['ID_MANUAL']?>)" class="btn btn-default btn-sm glyphicon glyphicon-trash delete_data"></a>
                                        </td>

                                    </tr>
                                    <?php  } ?>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
</section>
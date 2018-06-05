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
                      <div class="panel-heading">Form Master Company</div>
                        <div class="panel-body">
                            <form method="post" class="formInitialize" action="">
                              
                              <div class="form-group"> 
                                  <label for="name_book" class="col-sm-3 control-label">Opco<span style="color: #E74C3C">*</span></label>
                                  <input type="text" class="col-sm-2" name="opco" id="opco">
                              </div>

                              <div class="form-group"> 
                                  <label for="name_book" class="col-sm-3 control-label">Company Name<span style="color: #E74C3C">*</span></label>
                                  <input type="text" class="col-sm-4" name="company_name" id="company_name">
                              </div>

                              <div class="form-group"> 
                                  <label for="name_book" class="col-sm-3 control-label">Email Company<span style="color: #E74C3C">*</span></label>
                                  <input type="text" class="col-sm-5" name="email" id="email">
                              </div>

                              <div class="form-group"> 
                                  <label for="name_book" class="col-sm-3 control-label">Alamat Company<span style="color: #E74C3C">*</span></label>
                                  <textarea type="text" class="col-sm-5" name="alamat" id="alamat"></textarea>
                              </div>

                              <div class="form-group"> 
                                  <label for="name_book" class="col-sm-3 control-label">Logo Company<span style="color: #E74C3C">*</span></label>
                                  <div class="col-sm-6">
                                    <input type="hidden" id="logo" name="file_upload">
                                    <button type="button" id="logo1" required class="uploadAttachment logo_upload btn btn-default">Upload File</button><span class="filenamespan logos"></span>
                                        &nbsp;&nbsp;<a id="del_logo" class="btn btn-default delete_upload_file glyphicon glyphicon-trash"></a>
                                    <div class="progress progress-striped logos active" style="margin: 10px 0px 0px; display:none;">
                                        <div class="progress-bar logos progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                    </div><br>
                                    <span style="color: #E74C3C">*Logo Harus ukuran 80 x 80</span>
                                  </div>
                              </div>

                              <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                  <a class="main_button small_btn bottom_space" href="<?php echo site_url(); ?>">Cancel</a>
                                  <button type="reset" class="main_button color2 small_btn bottom_space">Reset</button>
                                  <button type="" id="save" class="main_button color1 small_btn bottom_space">Save</button>
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
                          <table id="tbl_data" class="table table-striped margin-bottom-20">
                            <thead>
                              <tr>
                                <th class="text-center col-md-1">NO</th>
                                <th class="text-center col-md-1">OPCO</th>
                                <th class="text-center col-md-2">COMPANY NAME</th>
                                <th class="text-center col-md-3">EMAIL COMPANY</th>
                                <th class="text-center col-md-4">ALAMAT COMPANY</th>
                                <th class="text-center col-md-2">LOGO</th>
                                <th class="text-center col-md-1">ACTION</th>
                              </tr>
                              <tr>
                                <th class="text-center "></th>
                                <th><input type="text" class="text-center col-xs-12"></th>
                                <th><input type="text" class="col-xs-12"></th>
                                <th><input type="text" class="col-xs-12"></th>
                                <th><input type="text" class="col-xs-12"></th>
                                <th></th>
                                <th></th>
                              </tr>
                            </thead> 
                          </table>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
</section>
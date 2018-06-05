
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
                        <div class="panel-heading">Form Hak Akses Level Vendor</div>
                        <div class="panel-body">
                            <form method="post" class="formInitialize" action="">
                              <div class="form-group"> 
                                  <label for="name_book" class="col-sm-3 control-label">Company<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-4"> 
                                        <label for="company" class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="company" id="company" class="form-control select2">
                                                <option value="" selected="" disabled=""> Pilih Company </option>
                                                <?php foreach ($company as $key => $value) { ?>
                                                    <option value="<?php echo $value["COMPANYID"]; ?>"><?php echo $value["COMPANYNAME"]; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </label>
                                    </div>
                                        <input type="text" class="hidden" name="company_id" id="company_id">

                                </div>
                              <div class="form-group"> 
                                  <label for="name_book" class="col-sm-3 control-label">Nama Pegawai<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-4"> 
                                        <label for="emplo_id" class="custom_select">
                                            <span class="lfc_alert"></span>
                                            <select name="emplo_id" id="emplo_id" class="form-control select2"> 
                                            </select>
                                        </label>
                                    </div>
                                        <input type="text" class="hidden" name="emplo" id="emplo">
                                </div>
                                <div class="form-group">
                                <label for="level" class="col-sm-3 control-label">Level<span style="color: #E74C3C">*</span></label> 
                                    <div class="col-sm-4">
                                      <label for="level" class="custom_select">
                                          <span class="lfc_alert"></span>
                                          <select name="level" id="level" class="form-control select2">
                                              <option value="" selected="" disabled=""> Pilih Level </option>
                                                 <option value="1">KONFIGURASI PERENCANAAN</option>
                                                 <option value="2">KASI PERENCANAAN</option>
                                                 <option value="3">KABIRO PERENCANAAN</option>
                                          </select>
                                      </label>
                                    </div>
                                </div>
                              <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                  <a class="main_button small_btn bottom_space" href="<?php echo site_url(); ?>">Cancel</a>
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
                                <th class="text-center col-md-1">No</th>
                                <th class="text-center col-md-4">NAMA PEGAWAI</th>
                                <th class="text-center col-md-4">LEVEL</th>
                                <th class="text-center col-md-4">COMPANY</th>
                                <th class="text-center col-md-2">ACTION</th>
                              </tr>
                              <tr>
                                <th></th>
                                <th><input type="text" class="col-xs-12"></th>
                                <th><input type="text" class="col-xs-12"></th>
                                <th><input type="text" class="col-xs-12"></th>
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
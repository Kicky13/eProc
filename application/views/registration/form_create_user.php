        <section class="content_section">
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Pembuatan Akun Vendor</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Detail Akses Pengguna</div>
                                <div class="panel-body">
                                    <?php echo form_open('Register/do_create_vendor',array('class' => 'form-horizontal', 'id' => 'formInitialize')); ?>
                                    <div class="form-group">
                                      <label for="companyid" class="col-sm-3 control-label">Perusahaan Mendaftar Ke</label>
                                      <label for="companyid" class="col-sm-9 control-label text-left"><strong><?php echo search_in($selected_company, $company, 'COMPANYNAME'); ?></strong></label>
                                      <input type="text" id="companyid" name="companyid" value="<?php echo $selected_company; ?>" class="hidden">
                                  </div>
                                  <div class="form-group">
                                    <label for="vendor_type" class="col-sm-3 control-label">Tipe Vendor<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-3">
                                        <?php
                                        $options = array(
                                            '' => '- Pilih Tipe Vendor -',
                                            'NASIONAL' => 'NASIONAL',
                                            'INTERNASIONAL' => 'INTERNASIONAL',
                                            'PERORANGAN' => 'PERORANGAN'
                                            );
                                            echo form_dropdown('vendor_type', $options, '', 'class="form-control type_change", id="vendor_type"'); ?>
                                            <input type="text" class="hidden" name="vendor" id="vendor">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="prefix" class="col-sm-3 control-label">Awalan (Prefix)</label>
                                        <div class="col-sm-3">
                                           <select name="prefix" id="prefix" class="form-control"> 
                                           </select>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                    <label for="company_name" class="col-sm-3 control-label">Nama Perusahaan<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="company_name" name="company_name">
                                        <span id="company_name1"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="suffix" class="col-sm-3 control-label">Akhiran (Suffix)</label>
                                    <div class="col-sm-3">
                                        <?php
                                        echo form_dropdown('suffix', $suffix, '', 'class="form-control"'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="username" class="col-sm-3 control-label">Username<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-uppercase" id="username" name="username">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">Alamat Email<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                </div>
                                <div class="form-group npwp_no">
                                    <label for="npwp_no" class="col-sm-3 control-label">No. NPWP<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control npwp_no" id="npwp_no" name="npwp_no">
                                        <span id="npwp1"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-sm-3 control-label">Password<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password2" class="col-sm-3 control-label">Ketik Ulang Password<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="password2" name="password2">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password2" class="col-sm-3 control-label">Captcha<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-9">
                                        <?php echo $captcha['image']; ?>
                                        <input id="captcha" name="captcha" type="text" placeholder="Captcha">
                                        <input type="text" name="captcha2" class="hidden" value="<?php echo $captcha['word']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-sm-offset-3 col-sm-9">
                                     <a class="main_button small_btn bottom_space" href="<?php echo site_url("Login/loadLoginVendor"); ?>">Cancel</a>
                                     <button id="tombol_registration" type="submit" class="main_button color1 small_btn bottom_space">Submit</button>
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
                           <?php echo form_close(); ?>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
</section>
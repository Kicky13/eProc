        <section class="content_section">
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Pembuatan Akun Vendor Aktif</h2>
                    </div>
                    <div class="row">

                        <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Success!</strong> <?php echo $this->session->flashdata('success') ?>
                        </div>
                        <?php endif ?>

                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Detail Akses Pengguna</div>
                                <div class="panel-body">
                                    <?php echo form_open('Vendor_regis_sap/do_create_vendor',array('class' => 'form-horizontal', 'id' => 'formInitializesap')); ?>
                                        <div class="form-group">
                                            <label for="prefix" class="col-sm-3 control-label">Company</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" value="<?php echo $company_name; ?>" disabled>
                                                <input type="hidden" id="company" name="company" class="form-control" value="<?php echo $opco; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="prefix" class="col-sm-3 control-label">Awalan (Prefix)</label>
                                            <div class="col-sm-3">
                                                <?php
                                                echo form_dropdown('prefix', $prefix, '', 'class="form-control"'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="company_name" class="col-sm-3 control-label">Nama Perusahaan<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control text-uppercase" id="company_name" name="company_name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="vendorno" class="col-sm-3 control-label">Nomer Vendor<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control text-uppercase" id="vendorno" name="vendorno">
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
                                            <label for="vendor_type" class="col-sm-3 control-label">Tipe Vendor<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-3">
                                                <?php
                                                $options = array(
                                                        'NASIONAL' => 'NASIONAL',
                                                        'INTERNASIONAL' => 'INTERNASIONAL', 
                                                        'PERORANGAN' => 'PERORANGAN'
                                                    );
                                                echo form_dropdown('vendor_type', $options, '', 'class="form-control"'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="username" class="col-sm-3 control-label">Username<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="username" name="username">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-sm-3 control-label">Alamat Email<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" id="email" name="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-sm-3 control-label">Password<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="password" class="form-control" id="password" name="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password2" class="col-sm-3 control-label">Ketik Ulang Password<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="password" class="form-control" id="password2" name="password2">
                                            </div>
                                        </div> 

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <a class="main_button small_btn bottom_space" href="">Cancel</a>
                                                <button type="submit" class="main_button color1 small_btn bottom_space">Create Account</button>
                                    <?php echo form_close(); ?>
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
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</section>
        <section class="content_section">
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Perubahan Password Vendor</h2>
                    </div>
                    <div class="row">
                        <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
                        </div>
                        <?php endif ?>
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Detail Akses Pengguna</div>
                                <div class="panel-body">
                                    <?php echo form_open('Vendor_change_password/do_change_password',array('class' => 'form-horizontal', 'id' => 'formInitialize')); ?>
                                    	<div class="form-group">
                                            <label for="password_old" class="col-sm-3 control-label">Password Lama<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="hidden" class="form-control" id="vendor_id" name="vendor_id" value="<?php echo $this->session->userdata('VENDOR_ID');?>"/>
                                                <input type="password" class="form-control" id="password_old" name="password_old">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-sm-3 control-label">Password Baru<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="password" name="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password2" class="col-sm-3 control-label">Ketik Ulang Password Baru<span style="color: #E74C3C">*</span></label>
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
                                    			<a class="main_button small_btn bottom_space" href="<?php echo site_url(); ?>">Cancel</a>
                                    			<button type="submit" class="main_button color1 small_btn bottom_space">Submit</button>
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
		<section class="content_section">
			<input type="text" class="hidden" id="base_url" value="<?php echo base_url(); ?>">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Pengaturan Tanggal Pendaftaran Vendor</h2>
					</div>
					<div class="row">
						<div class="col-md-12">
							<?php if($this->session->flashdata('success')) { ?>
							<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
							</div>
							<?php } ?>
							<?php
							$url ="Vendor_registration_management/do_update_registration_date/".$registration_date["COMPANYID"];
							echo form_open($url,array('class' => 'form-horizontal')); ?>
							<div class="panel panel-default">
								<div class="panel-heading">Company Information</div>
								<div class="panel-body">
									<div class="form-group">
										<label for="NPP" class="col-sm-3 control-label">Company ID</label>
										<label for="NPP" class="col-sm-9 control-label text-left"><strong><?php echo $registration_date['COMPANYID']; ?></strong></label>
									</div>
									<div class="form-group">
										<label for="FIRSTNAME" class="col-sm-3 control-label">Company Name</label>
										<label for="FIRSTNAME" class="col-sm-9 control-label text-left"><strong><?php echo $registration_date['company']['COMPANYNAME']; ?></strong></label>
									</div>
									<div class="form-group">
										<label for="FIRSTNAME" class="col-sm-3 control-label">Start Date</label>
										<div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="OPEN_REG" class="form-control" value="<?php echo vendorfromdate($registration_date['OPEN_REG']); ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
									</div>
									<div class="form-group">
										<label for="FIRSTNAME" class="col-sm-3 control-label">End Name</label>
										<div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="CLOSE_REG" class="form-control" value="<?php echo vendorfromdate($registration_date['CLOSE_REG']); ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-footer text-center">
									<a href="<?php echo site_url('Vendor_registration_management/registration_date'); ?>" class="main_button small_btn reset_button">Cancel</a>
									<button class="main_button color1 small_btn" type="submit">Save</button>
								</div>
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</section>
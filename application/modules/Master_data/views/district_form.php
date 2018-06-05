		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Manajemen Kantor</h2>
					</div>
					<div class="row">
						<div class="col-md-12">
							<?php if($this->session->flashdata('success')) { ?>
							<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
							</div>
							<?php } ?>
							<div class="panel panel-default">
								<?php
								$url = ($district) ? "Master_data/do_update_district/".$district["DISTRICT_ID"] : "Master_data/do_create_district";
								echo form_open($url,array('class' => 'form-horizontal')); ?>
								<div class="panel-heading">Detail Kantor</div>
								<div class="panel-body">
									<div class="form-group">
										<label for="DISTRICT_CODE" class="col-sm-3 control-label">Kode Kantor</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="DISTRICT_CODE" name="DISTRICT_CODE" value="<?php if($district) echo $district['DISTRICT_CODE'] ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="DISTRICT_NAME" class="col-sm-3 control-label">Nama Kantor</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="DISTRICT_NAME" name="DISTRICT_NAME" value="<?php if($district) echo $district['DISTRICT_NAME'] ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="city" class="col-sm-3 control-label">Company</label>
										<div class="col-sm-3">
											<label for="COMPANY_ID" class="custom_select">
												<span class="lfc_alert"></span>
												<select name="COMPANY_ID" id="COMPANY_ID" required="">
													<option value="" selected="" disabled="">Company</option>
													<?php foreach ($company as $key => $value) { ?>
														<option value="<?php echo $value["COMPANYID"]; ?>" <?php if($value["COMPANYID"] == $district["COMPANY_ID"]) echo "selected=\"selected\"" ?>><?php echo $value["COMPANYNAME"]; ?></option>
													<?php } ?>
												</select>
											</label>
										</div>
									</div>
								</div>
								<div class="panel-footer text-center">
									<a href="<?php echo site_url('Master_data/district'); ?>" class="main_button small_btn reset_button">Cancel</a>
									<button class="main_button color1 small_btn" type="submit">Save</button>
								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
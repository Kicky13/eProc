		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Manajemen Departemen</h2>
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
								$url = ($department) ? "Master_data/do_update_department/".$department["DEPT_ID"] : "Master_data/do_create_department";
								echo form_open($url,array('class' => 'form-horizontal')); ?>
								<div class="panel-heading">Detail Departemen</div>
								<div class="panel-body">
									<div class="form-group">
										<label for="DEP_CODE" class="col-sm-3 control-label">Kode Departemen</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="DEP_CODE" name="DEP_CODE" value="<?php if($department) echo $department['DEP_CODE'] ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="DEPT_NAME" class="col-sm-3 control-label">Nama Departemen</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="DEPT_NAME" name="DEPT_NAME" value="<?php if($department) echo $department['DEPT_NAME'] ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="city" class="col-sm-3 control-label">Kantor</label>
										<div class="col-sm-4">
											<label for="DISTRICT" class="custom_select">
												<span class="lfc_alert"></span>
												<select name="DISTRICT" id="DISTRICT" required="">
													<option value="" selected="" disabled="">Kantor</option>
													<?php foreach ($district as $key => $value) { ?>
														<option value="<?php echo $value["DISTRICT_ID"].'-'.$value["DISTRICT_NAME"]; ?>" <?php if($value["DISTRICT_ID"] == $department["DISTRICT_ID"]) echo "selected=\"selected\"" ?>><?php echo $value["DISTRICT_NAME"]; ?></option>
													<?php } ?>
												</select>
											</label>
										</div>
									</div>
								</div>
								<div class="panel-footer text-center">
									<a href="<?php echo site_url('Master_data/department'); ?>" class="main_button small_btn reset_button">Cancel</a>
									<button class="main_button color1 small_btn" type="submit">Save</button>
								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<input type="text" class="hidden" id="base_url" value="<?php echo base_url(); ?>">
		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Manajemen Pegawai</h2>
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
							$url = ($employee) ? "User_management/do_update_employee/".$employee["ID"] : "User_management/do_create_employee";
							echo form_open($url,array('class' => 'form-horizontal employeeForm')); ?>
							<div class="panel panel-default">
								<div class="panel-heading">Employee Information</div>
								<div class="panel-body">
									<div class="form-group">
										<label for="NPP" class="col-sm-3 control-label">NPP</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="NPP" name="NPP" value="<?php if($employee) echo $employee['NPP'] ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="FIRSTNAME" class="col-sm-3 control-label">First Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="FIRSTNAME" name="FIRSTNAME" value="<?php if($employee) echo $employee['FIRSTNAME'] ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="LASTNAME" class="col-sm-3 control-label">Last Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="LASTNAME" name="LASTNAME" value="<?php if($employee) echo $employee['LASTNAME'] ?>">
										</div>
									</div>
									<input type="text" class="hidden" name="FULLNAME" id="FULLNAME" id="fullname">
									<div class="form-group">
											<label for="account_no" class="col-sm-3 control-label">Department</label>
											<div class="col-sm-7">
												<label for="DEPT" class="custom_select">
													<span class="lfc_alert"></span>
													<select name="DEPT" id="DEPT" required="">
														<option value="" selected="" disabled="">Department</option>
														<?php foreach ($dept as $key => $value) { ?>
															<option value="<?php echo $value["DEPT_ID"]."-".$value["DEPT_NAME"]; ?>"><?php echo $value["DEPT_NAME"]; ?></option>
														<?php } ?>
													</select>
												</label>
											</div>
										</div>
										<div class="form-group">
											<label for="account_no" class="col-sm-3 control-label">Position</label>
											<div class="col-sm-7">
												<label for="ADM_POS_ID" class="custom_select">
													<span class="lfc_alert"></span>
													<select name="ADM_POS_ID" id="ADM_POS_ID" required="">
														<option value="" selected="" disabled="">Position</option>
													</select>
												</label>
											</div>
										</div>
										<div class="form-group">
											<label for="account_name" class="col-sm-3 control-label">Status</label>
											<div class="col-sm-9">
												<input type="text" class="hidden" name="STATUS" id="STATUS" value="<?php if($employee) echo $employee['STATUS'] ?>">
												<div class="flat-toggle">
													<span>Active</span>
												</div>
											</div>
										</div>
									<div class="form-group">
										<label for="CITY" class="col-sm-3 control-label">Employee Type</label>
										<div class="col-sm-3">
											<label for="EMPLOYEE_TYPE_ID" class="custom_select">
												<span class="lfc_alert"></span>
												<select name="EMPLOYEE_TYPE_ID" id="EMPLOYEE_TYPE_ID" required="">
													<option value="" selected="" disabled="">Employee Type</option>
													<?php foreach ($employee_type as $key => $value) { ?>
														<option value="<?php echo $value["EMPLOYEE_TYPE_ID"]; ?>" <?php if($value["EMPLOYEE_TYPE_ID"] == $employee["EMPLOYEE_TYPE_ID"]) echo "selected=\"selected\"" ?>><?php echo $value["EMPLOYEE_TYPE_NAME"]; ?></option>
													<?php } ?>
												</select>
											</label>
										</div>
										<label for="POSTCODE" class="col-sm-3 control-label">Salutation</label>
										<div class="col-sm-3">
											<label for="ADM_SALUTATION_ID" class="custom_select">
												<span class="lfc_alert"></span>
												<select name="ADM_SALUTATION_ID" id="ADM_SALUTATION_ID" required="">
													<option value="" selected="" disabled="">Salutation</option>
													<?php foreach ($salutation as $key => $value) { ?>
														<option value="<?php echo $value["ADM_SALUTATION_ID"]; ?>" <?php if($value["ADM_SALUTATION_ID"] == $employee["ADM_SALUTATION_ID"]) echo "selected=\"selected\"" ?>><?php echo $value["ADM_SALUTATION_NAME"]; ?></option>
													<?php } ?>
												</select>
											</label>
										</div>
									</div>
									<div class="form-group">
										<label for="ADDRESS" class="col-sm-3 control-label">Address</label>
										<div class="col-sm-9">
											<textarea class="form-control" id="ADDRESS" name="ADDRESS" style="resize: vertical"><?php if($employee) echo $employee['ADDRESS'] ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="CITY" class="col-sm-3 control-label">City</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" id="CITY" name="CITY" value="<?php if($employee) echo $employee['CITY'] ?>">
										</div>
										<label for="POSTCODE" class="col-sm-3 control-label">Postcode</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" id="POSTCODE" name="POSTCODE" value="<?php if($employee) echo $employee['POSTCODE'] ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="COUNTRY" class="col-sm-3 control-label">Country</label>
										<div class="col-sm-3">
											<label for="COUNTRY" class="custom_select">
												<span class="lfc_alert"></span>
												<select name="COUNTRY" id="COUNTRY" required="">
													<option value="" selected="" disabled="">Country</option>
													<?php foreach ($country as $key => $value) { ?>
														<option value="<?php echo $value["COUNTRY_NAME"]; ?>" <?php if($value["COUNTRY_NAME"] == $employee["COUNTRY"]) echo "selected=\"selected\"" ?>><?php echo $value["COUNTRY_NAME"]; ?></option>
													<?php } ?>
												</select>
											</label>
										</div>
									</div>
									<div class="form-group">
										<label for="PHONE" class="col-sm-3 control-label">Phone</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" id="PHONE" name="PHONE" value="<?php if($employee) echo $employee['PHONE'] ?>">
										</div>
										<label for="MOBILEPHONE" class="col-sm-3 control-label">Mobile Phone</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" id="MOBILEPHONE" name="MOBILEPHONE" value="<?php if($employee) echo $employee['MOBILEPHONE'] ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">Company Information</div>
								<div class="panel-body">
									<div class="form-group">
										<label for="EMAIL" class="col-sm-3 control-label">Email Address</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="EMAIL" name="EMAIL" value="<?php if($employee) echo $employee['EMAIL'] ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="OFFICEEXTENSION" class="col-sm-3 control-label">Office Extension</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="OFFICEEXTENSION" name="OFFICEEXTENSION" value="<?php if($employee) echo $employee['OFFICEEXTENSION'] ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-footer text-center">
									<a href="<?php echo site_url('User_management/employee'); ?>" class="main_button small_btn reset_button">Cancel</a>
									<button class="main_button color1 small_btn" id="saveEmployee" type="submit">Save</button>
								</div>
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</section>
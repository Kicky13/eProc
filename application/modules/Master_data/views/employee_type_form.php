		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Manajemen Tipe Pegawai</h2>
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
								$url = ($employee_type) ? "Master_data/do_update_employee_type/".$employee_type["EMPLOYEE_TYPE_ID"] : "Master_data/do_create_employee_type";
								echo form_open($url,array('class' => 'form-horizontal')); ?>
								<div class="panel-heading">Detail Tipe Pegawai</div>
								<div class="panel-body">
									<div class="form-group">
										<label for="EMPLOYEE_TYPE_NAME" class="col-sm-3 control-label">Tipe Pegawai</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="EMPLOYEE_TYPE_NAME" name="EMPLOYEE_TYPE_NAME" value="<?php if($employee_type) echo $employee_type['EMPLOYEE_TYPE_NAME'] ?>">
										</div>
									</div>
								</div>
								<div class="panel-footer text-center">
									<a href="<?php echo site_url('Master_data/employee_type'); ?>" class="main_button small_btn reset_button">Cancel</a>
									<button class="main_button color1 small_btn" type="submit">Save</button>
								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
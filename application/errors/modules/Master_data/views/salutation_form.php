		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Manajemen Panggilan</h2>
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
								$url = ($salutation) ? "Master_data/do_update_salutation/".$salutation["ADM_SALUTATION_ID"] : "Master_data/do_create_salutation";
								echo form_open($url,array('class' => 'form-horizontal')); ?>
								<div class="panel-heading">Detail Panggilan</div>
								<div class="panel-body">
									<div class="form-group">
										<label for="ADM_SALUTATION_NAME" class="col-sm-3 control-label">Panggilan</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="ADM_SALUTATION_NAME" name="ADM_SALUTATION_NAME" value="<?php if($salutation) echo $salutation['ADM_SALUTATION_NAME'] ?>">
										</div>
									</div>
								</div>
								<div class="panel-footer text-center">
									<a href="<?php echo site_url('Master_data/salutation'); ?>" class="main_button small_btn reset_button">Cancel</a>
									<button class="main_button color1 small_btn" type="submit">Save</button>
								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
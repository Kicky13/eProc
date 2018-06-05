		<section class="content_section">
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
							<div class="panel panel-default">
								<div class="panel-heading">
									Pengaturan Tanggal Pendaftaran Vendor
								</div>
								<div class="panel-body">
									<table class="table table-hover" id="registration_date_list">
										<thead>
											<tr>
												<th class="text-center">No</th>
												<th class="text-center">Company Name</th>
												<th class="text-center">Registration Start</th>
												<th class="text-center">Registration End</th>
												<th class="text-center" style="width: 170px">Aksi</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
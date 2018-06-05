		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Administrasi Kantor</h2>
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
									<div class="panel-title pull-left">Administrasi Kantor</div>
									<div class="btn-group pull-right">
										<a href="<?php echo site_url('Master_data/create_district'); ?>" class="btn btn-success btn-sm">Buat Kantor</a>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="panel-body">
									<table class="table table-hover" id="district_list">
										<thead>
											<tr>
												<th class="text-center">No</th>
												<th class="text-center">Kode</th>
												<th class="text-center">Nama Kantor</th>
												<th class="text-center">Company</th>
												<th class="text-center">Aksi</th>
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
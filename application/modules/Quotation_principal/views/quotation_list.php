		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Daftar Penawaran</h2>
					</div>
					<div class="row">
						<div class="col-md-12">
							<?php if($this->session->flashdata('success')) { ?>
							<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>Success!</strong> Data berhasil disimpan.
							</div>
							<?php } ?>
							<?php if($this->session->flashdata('error')) { ?>
							<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>Error!</strong><?php echo $this->session->flashdata('error'); ?>
							</div>
							<?php } ?>
							<div class="panel panel-default">
								<div class="panel-heading">
									Penawaran
								</div>
								<div class="panel-body">
									<table class="table table-hover" id="quotation_lsit">
										<thead>
											<tr>
												<th class="text-center">No</th>
												<th class="text-center">Vendor</th>
												<th class="text-center">Tender Number</th>
												<th class="text-center">No RFQ</th>
												<th class="text-center">Subject of Work</th>
												<th class="text-center">RFQ Date</th>
												<th class="text-center">Quotation Deadline</th>
												<th class="text-center" style="min-width: 120px">Status</th>
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
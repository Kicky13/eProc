		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span><?php echo $title; ?></h2>
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
								<div class="panel-heading">&nbsp;</div>
								<div class="panel-body">
									<table class="table table-hover" id="list_pesan">
										<thead>
											<tr>
												<th class="text-center">No</th>
												<th class="text-center">Tender Number</th>
												<th class="text-center">Subject of Work</th>
												<th class="text-center">Dari</th>
												<th class="text-center">Tanggal</th>
												<th class="text-center">Aksi</th>
											</tr>
											<tr>
							                    <th> </th>
							                    <th><input type="text" class="col-xs-12"></th>
							                    <th><input type="text" class="col-xs-12"></th>
							                    <th><input type="text" class="col-xs-12"></th>
							                    <th><input type="text" class="col-xs-12"></th>
							                    <th></th>
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
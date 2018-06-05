		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
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
									Tender Invitation
								</div>
								<div class="panel-body">
									<table class="table table-hover" id="negotiation_list">
										<thead>
											<tr>
												<th class="text-center">No</th>
												<th class="text-center">Tender Number</th>
												<th class="text-center">Subject of Work</th>
												<th class="text-center">Pembukaan Negosiasi</th>
												<th class="text-center">Penutupan Negosiasi</th>
												<th class="text-center" style="min-width: 120px">Status</th>
												<th class="text-center">Aksi</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
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
									Win Auction List
								</div>
								<div class="panel-body">
									<table class="table table-hover" id="win_negotiation_list">
										<thead>
											<tr>
												<th class="text-center">No</th>
												<th class="text-center">Tender Number</th>
												<th class="text-center">Subject of Work</th>
												<th class="text-center">Pembukaan Negosiasi</th>
												<th class="text-center">Penutupan Negosiasi</th>
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
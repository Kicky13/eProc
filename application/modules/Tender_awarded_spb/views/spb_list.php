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

							<?php if($this->session->flashdata('error')) { ?>
							<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>Success!</strong> <?php echo $this->session->flashdata('danger'); ?>
							</div>
							<?php } ?>


							<div class="panel panel-default">
								<div class="panel-heading">
									Daftar Detail Po
								</div>
								<div class="panel-body">
								<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
									<table class="table table-hover" id="po_detail" width="100%">
										<thead>
											<th class="">Action</th>
											<th class="">PO Number</th>
											<th class="">PO Item</th>
											<th class="">Nomor Material</th>
											<th class="">Detail Material</th>
											<th class="">Satuan</th>
											<th class="">QUANTITY PO</th>
											<th class="">QUANTITY SPB</th>
											<th class="">Quantiti item timbangan</th>
											<th class="">QUANTITY GR</th>
											<th class="">SISA QUANTITY</th>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>

							<div class="panel panel-default">
								<div class="panel-heading">
									Daftar SPB
								</div>
								<div class="panel-body">
								<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
									<table class="table table-hover" id="spb_list" width="100%">
										<thead>
											<th class="">Action</th>
											<th class="">PO Number</th>
											<th class="">PO Item</th>
											<th class="">Nomor Material</th>
											<th class="">Detail Material</th>
											<th class="">PLAT</th>
											<th class="">DRIVER</th>
											<th class="">NOMOR VENDOR</th>
											<th class="">NAMA VENDOR</th>
											<th class="">QUANTITY</th>
											<th class="">TANGGAL</th>
											<th class="">STATUS</th>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</section>
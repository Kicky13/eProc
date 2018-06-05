<section class="content_section">
    <?php $this->load->view('vmi_menuvendor');?>
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span>List Good Issued</h2>
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
						<div class="panel-body">
							<table class="table table-hover" id="vmi_list">
								<thead>
									<tr>
										<th class="text-center">Material</th>
										<th class="text-center">Unit</th>
										<th class="text-center">Plant</th>
										<th class="text-center">Material Doc</th>
										<th class="text-center">Good Issued</th>
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
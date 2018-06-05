<style type="text/css">
    .dt-body-right{
        text-align:right;
    }
</style>
<?php //$this->load->view('vmi_menubar');?>
<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span>Delivery Detail</h2>
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
							<table class="table table-hover" id="vmi_deliv_list">
								<thead>
									<tr>
										<th class="text-center">PO</th>
										<th class="text-center">Plant</th>
										<th class="text-center">Vendor</th>
										<th class="text-center">Material</th>
										<th class="text-center">Date Delivery</th>
										<!--<th class="text-center">Tanggal Kedatangan</th>
										<th class="text-center">Quantity Receive</th>
										<th class="text-center">Lead Time</th>-->
										<th class="text-center">Quantity Delivery</th>
										<th class="text-center">Print SPJ</th>
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
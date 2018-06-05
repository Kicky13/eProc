<!-- load library jquery dan highcharts -->
<script src="<?php echo base_url();?>static/js/pages/highcharts.js"></script>
<!-- end load library -->
<?php
    /* Mengambil query report*/
    // foreach($report as $result){
        // $bulan[] = $result->ID_PLANT; //ambil bulan
        // $value[] = (float) $result->STOCK_VMI; //ambil nilai
    // }
    /* end mengambil query*/
     
?>

<style type="text/css">
    .dt-body-right{
        text-align:right;
    }
</style>
<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span>Prognose</h2>
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
						<!--<div class="panel-heading">
							<div class="panel-title pull-left">List All VMI</div>
							<div class="btn-group pull-right">
							-- <a href="<?php echo site_url(''); ?>" class="btn btn-success btn-sm">Perencanaan</a>  --
							</div>
							<div class="clearfix"></div>
						</div>-->
						<div class="panel-body">
							<table class="table table-hover" id="vmi_cvendor_list">		<!-- Ada di VMI_ALL.js -->
								<thead>
									<tr>
										<th class="text-center">Plant</th>
										<th class="text-center">Vendor</th>
										<th class="text-center">Material</th>
										<th class="text-center">Unit</th>
										<th class="text-center">Stock GR</th>
										<th class="text-center">Stock VMI</th>
										<th class="text-center">Stock Delivery</th>
										<th class="text-center">Stock Principle</th>
										<th class="text-center">Min</th>
										<th class="text-center">Max</th>
										<th class="text-center">Lead Time</th>
										<th class="text-center">No. PO</th>
										<th class="text-center" style="width: 170px">Active Contract</th>
										<th class="text-center" style="width: 170px">End Of Contract</th>
										<th class="text-center" style="width: 170px">Show Grafik</th>
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
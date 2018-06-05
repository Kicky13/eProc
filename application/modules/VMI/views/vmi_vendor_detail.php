<?php //$this->load->view('vmi_menubar');
	// foreach($tabledata as $result){
 //        $qwe[] = $result[12]; //ambil nilai
 //        $asd[] = $result[14]; //ambil nilai
 //    }
	// echo "qwe <br/>";
	// print_r($qwe);
	// echo "<br/>asd <br/>";
	// print_r($asd);
?>
<style>
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 1s;
}

.tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}
</style>
<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span>Vendor Managed Inventory</h2>
			</div>
			<form class="form-horizontal" action="<?=base_url('VMI/Company/filter')?>" method="POST" enctype='multipart/form-data'>
				<div class="form-group">
					<div class="col-sm-2 col-sm-offset-0">
						<label for="inputPlant" class="control-label">Periode Awal</label>
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control" id="NselectPlant2" name="NselectPlant2">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-2 col-sm-offset-0">
						<label for="inputPlant" class="control-label">Periode Akhir</label>
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control" id="NselectPlant2" name="NselectPlant2">
					</div>
				</div>
				<div class="modal-body">
					<button type="submit" class="btn btn-primary">Go</button>
				</div>
			</form>
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
							<div class="panel-title pull-left">List All VMI</div>
							<div class="btn-group pull-right">
							<!-- <a href="<?php echo site_url(''); ?>" class="btn btn-success btn-sm">Perencanaan</a>  -->
							<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal_manual_input">Perencanaan</button>
							<button type="button" class="btn btn-success" data-toggle="modal" data-target=".modal_addVMI" style="margin-left: 10px"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New VMI-Vendor</button>-->
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal_upload" style="margin-left: 10px">Upload Prognose</button>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-body">
							<table class="table table-hover" id="vmi_vendor_detail">		<!-- Ada di VMI_ALL.js -->
								<thead>
									<tr>
										<th class="text-center" title = "">PO</th>
										<th class="text-center" title = "">Material</th>
										<th class="text-center" title = "">Unit</th>
										<th class="text-center" title = "">Transaction</th>
										<th class="text-center" title = "">Quantity</th>
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

<div class="modal fade modal_upload" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Perencanaan</h4>
		  </div>
		<form class="form-horizontal" action="<?=base_url('RFC/Excel/act_berkas_oracle.php')?>" method="POST" enctype='multipart/form-data'>
		  <div class="modal-body">
			<div class="form-group">
				<label for="Upload_file">Upload File</label>
				<input type="file" id="file_prognose" name = "file_prognose" required>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary">Upload</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</form>
		</div>
	</div>
</div>
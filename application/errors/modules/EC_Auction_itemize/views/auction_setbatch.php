<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
// print_r($itemBatch);
// die;

$sisa = count($items) - $itemBatch[0]['JML'];
// print_r($sisa);
// die;
?>
<style>
	.tablee > tbody > tr > td {
		padding: 4px;
	}
	/*@media print {
	 body * {
	 visibility: hidden;
	 }
	 #section-to-print, #section-to-print * {
	 visibility: visible;
	 }
	 #section-to-print {
	 position: absolute;
	 left: 0;
	 top: 0;
	 }
	}*/
</style>
<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
				<input type="hidden" id="notender" name="notender" value="<?php echo $aunction[$i]['NO_TENDER']?>">
			</div>
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading" style="padding-bottom: 20px;">
						List Batch
							<a type="button" href="<?php echo base_url(); ?>EC_Auction_itemize/resetBatch1/<?php echo $notender?>" class="btn btn-danger btn-sm pull-right" aria-label="Left Align">
								<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
							</a>
							<?php if($sisa>0){ ?>
							<button style="margin-right: 20px" type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#tbh-batch">
								Tambah
							</button>
							<?php } else { 
								?>
								<button style="margin-right: 20px" type="button" class="btn btn-warning btn-sm pull-right">
									<b>Item Telah Habis</b>
								</button>
								<?php

							} ?>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<th class="col-md-1">No</th>
										<th>Batch</th>
										<th>Jumlah Item</th>
										<!-- <th>Aksi</th> -->
									</thead>
									<tbody>
										<?php $i=0; foreach ($batch as $value){?> 
										<tr>
											<td><?php echo ++$i?></td>
											<td><?php echo $value['NAME']?></td>
											<td><?php echo $value['QTY_ITEM']?></td>
										</tr>												
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-body text-center">
							<!-- <a href="<?php echo base_url(); ?>Auction/index" class="main_button color7 small_btn">Kembali</a> -->
							<input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar">
						</input>
							<a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>EC_Auction_itemize/" style="font-size: 15px">Kembali</a>
							<a class="btn btn-success btn-xs" onclick="buka(<?php echo $notender?>)" style="font-size: 15px">Open</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="tbh-batch" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="gridSystemModalLabel">Tambah Batch</h4>
				</div>
				<div class="modal-body">
					<?php 
					for ($i=0; $i < sizeof($aunction) ; $i++) {												
						?>
						<form class="form-horizontal" action="<?php echo base_url()?>EC_Auction_itemize/addBatch/<?php echo $aunction[$i]['NO_TENDER']?>" method="POST">
							<?php } ?>
							<div class="form-group">
								<label for="kd_vnd" class="col-sm-3 control-label">Kode Batch</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="nama_batch" id="nama_batch" required="" placeholder="Kode Batch">
								</div>
							</div>
							<div class="form-group">
								<label for="nama_vnd" class="col-sm-3 control-label">Kuantiti Per Batch</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="qty_batch" id="qty_batch" required="" placeholder="Quantiti">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-10">
									<button type="submit" class="btn btn-info">Tambah</button>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="alert alert-warning" role="alert">
										<strong>sisa item <?php echo $sisa ?> / <?php echo count($items); ?></strong>
									</div> 
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>


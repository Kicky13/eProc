<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
			</div>
			<?php if ($this->session->flashdata('success') == 'success'): ?>
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Sukses.</strong> Data berhasil disimpan.
				</div>
			<?php endif ?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">Pilih Vendor untuk Rekap</div>
						<div class="panel-body">
							<table id="table_vendor" class="table table-hover">
								<thead>
									<tr>
										<th>No Vendor</th>
										<th>Nama Vendor</th>
										<th class="text-center col-md-2">Nilai sekarang</th>
										<th class="text-center col-md-1">Detail</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($vendor as $row) { ?>
										<tr>
											<td><?php echo $row['VENDOR_NO'] ?></td>
											<td><?php echo $row['VENDOR_NAME'] ?></td>
											<td class="text-center"><?php echo $row['PERFORMANCE'] ?></td>
											<td class="text-center"><a href="<?php echo base_url('Vendor_performance_management/form_rekap/'.$row['VENDOR_NO']) ?>" class="btn btn-default">Detail</a></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	$(document).ready(function() {
		var table = $('#table_vendor').DataTable({
			"bSort": false,
			"scrollCollapse": true,
			"dom": 'frtip',
		});
	});
</script>
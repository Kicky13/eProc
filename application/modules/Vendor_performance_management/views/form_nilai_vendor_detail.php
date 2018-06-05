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
			<form method="post" action="<?php echo base_url('Vendor_performance_management/insert_nilai_vendor') ?>">
			<div class="row">
				<div class="col-md-12">
					<input type="hidden" name="vendor_no" value="<?php echo $vendor['VENDOR_NO'] ?>">
					<div class="panel panel-default">
						<div class="panel-heading">Data Vendor</div>
						<table class="table table-hover">
							<tr>
								<td></td>
								<td class="col-md-3">No Vendor</td>
								<td><?php echo $vendor['VENDOR_NO'] ?></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td class="col-md-3">Nama Vendor</td>
								<td><?php echo $vendor['VENDOR_NAME'] ?></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td class="col-md-3">Nilai</td>
								<td id="nilai_sekarang"><?php echo $vendor['PERFORMANCE'] ?></td>
								<td></td>
							</tr>
						</table>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">Pilih Kriteria Penilaian</div>
						<div class="panel-body">
							<select id="criteria">
								<?php foreach ($penilaian as $row): ?>
									<option value="<?php echo $row['ID_CRITERIA'] ?>" data-data="<?php echo html_escape(json_encode($row)) ?>">
										<?php echo $row['CRITERIA_NAME'] ?> | <?php echo $row['CRITERIA_DETAIL'] ?> (<?php echo $row['CRITERIA_SCORE_SIGN'] . $row['CRITERIA_SCORE'] ?> Poin)
									</option>
								<?php endforeach ?>
							</select>
							&nbsp;
							<button type="button" class="btn btn-success" onclick="pilih()">Tambah</button>
							<hr>
							<table id="kriteria-pilih" class="table table-hover">
								<thead>
									<tr>
										<th>Kriteria</th>
										<th class="text-center col-md-2">Nilai</th>
										<th class="text-center col-md-1">Hapus</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-body text-center">
							<a href="<?php echo base_url('Vendor_performance_management/form_nilai_vendor') ?>" class="main_button color7 small_btn">Kembali</a>
							<button type="submit" class="formsubmit main_button color6 small_btn">Submit</button>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</section>

<script>
	function pilih() {
		criteria = $("#criteria option:selected").data('data');
		console.log(criteria);

		inputs = '';
		inputs += '<input name="criteria['+criteria.ID_CRITERIA+'][keterangan]" value="' + criteria.CRITERIA_NAME + ' | ' + criteria.CRITERIA_DETAIL + '">';
		inputs += '<input name="criteria['+criteria.ID_CRITERIA+'][criteria_id]" value="' + criteria.ID_CRITERIA + '">';
		inputs += '<input name="criteria['+criteria.ID_CRITERIA+'][sign]" value="' + criteria.CRITERIA_SCORE_SIGN + '">';
		inputs += '<input name="criteria['+criteria.ID_CRITERIA+'][skor]" value="' + criteria.CRITERIA_SCORE + '">';

		tbody = $("#kriteria-pilih").find('tbody');
		tr = $('<tr class="criteria_row">')
			.append('<td class="hidden">' + inputs + '</td>')
			.append('<td>' + criteria.CRITERIA_NAME + ' | ' + criteria.CRITERIA_DETAIL + '</td>')
			.append('<td class="text-center">' + criteria.CRITERIA_SCORE_SIGN + criteria.CRITERIA_SCORE + '</td>')
			.append('<td class="text-center"><button type="button" class="btn btn-danger" onclick="$(this).parent().parent().remove()">Hapus</button></td>')
		tbody.append(tr)
	}

	$(document).ready(function() {
		$("form").submit(function(e) {
			if ($(".criteria_row").length <= 0) {
				alert('Pilih minimal satu kriteria penilaian.');
				e.preventDefault();
			}
		});
	});
</script>
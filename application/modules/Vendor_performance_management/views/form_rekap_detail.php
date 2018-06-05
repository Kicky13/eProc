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
			<form method="post" action="<?php echo base_url('Vendor_performance_management/insert_rekap') ?>">
			<div class="row">
				<div class="col-md-12">
					<input type="hidden" name="vendor_no" value="<?php echo $vendor['VENDOR_NO']; ?>">
					<input type="hidden" name="criteria_id" value="">
					<input type="hidden" name="keterangan" value="Rekap Penilaian">
					<div class="panel panel-default">
						<div class="panel-heading">Data Vendor</div>
						<table class="table table-hover">
							<tr>
								<td></td>
								<td class="col-md-3">No Vendor</td>
								<td><?php echo $vendor['VENDOR_NO']; ?></td>
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
						<div class="panel-heading">Rekap Penilaian</div>
						<div class="panel-body">
							<table class="table table-hover">
								<tr>
									<td>Kriteria</td>
									<td>Rekap Penilaian</td>
								</tr>
								<tr>
									<td>Nilai rekap</td>
									<td>
										<select id="sign" name="sign">
											<option disabled>Tanda</option>
											<option value="+">+</option>
											<option value="-">-</option>
											<option value="=">=</option>
										</select>
										&nbsp;
										<input id="skor" name="skor" type="number" placeholder="Skor" value="0">
									</td>
								</tr>
								<tr>
									<td>Nilai akhir</td>
									<td id="nilai_akhir">-</td>
								</tr>
								<tr>
									<td>Sangsi</td>
									<td id="sangsi">-</td>
								</tr>
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
	function hitung_nilai_akhir() {
		now = Number($('#nilai_sekarang').html());
		sign = $('#sign').val();
		skor = Number($('#skor').val());
		
		if (sign == '+') {
			final = now + skor;
		}
		if (sign == '-') {
			final = now - skor;
		}
		if (sign == '=') {
			final = skor;
		}
		$("#nilai_akhir").html(final);
	}

	$(document).ready(function() {
		hitung_nilai_akhir();
		$("#sign").change(hitung_nilai_akhir);
		$("#skor").change(hitung_nilai_akhir);
	});
</script>

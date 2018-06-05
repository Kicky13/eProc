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
			<form method="post" action="<?php echo base_url('Vendor_performance_management/insert_nilai_tender') ?>">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">Pilih PO &nbsp; &nbsp;
						  <input id="eproc" type="radio" name="radio" value="1" checked> Eproc &nbsp;
						  <input id="non_eproc" type="radio" name="radio" value="2"> Non Eproc 
						</div>
						<div class="panel-body sh_non_peroc">
							<input type="text" id="po_no_man" name="po_no_man" maxlength="10" placeholder="No PO"> &nbsp;
							<select id="vendor" name="vendor" value="" class="col-sm-5 select2">
								<option disabled selected value>Pilih Vendor</option>
							<?php foreach ($vendor_data as $vendor ) :?>
								<option value="<?php echo $vendor['VENDOR_NO'];?>"><?php echo $vendor['VENDOR_NO']." - ".$vendor['VENDOR_NAME'];?></option>
							<?php endforeach ?>
							</select>
							<input id="vendor_no_man" name="vendor_no_man" value="">
							<input id="cek_eproc" name="cek_eproc" value="">
						</div>
						<div class="panel-body sh_eproc">
							<select id="pilih_vendor" name="pilih_vendor">
								<option disabled selected value>Pilih Nomor PO</option>
								<?php foreach ($po as $row): ?>
									<option value="<?php echo $row['PO_NUMBER'] ?>" data-data="<?php echo html_escape(json_encode($row)) ?>">
										<?php echo $row['PO_NUMBER'] ?> - [<?php echo $row['VENDOR_NO'] ?> <?php echo $row['VENDOR_NAME'] ?>]
									</option>
								<?php endforeach ?>
							</select>
							<input type="hidden" name="vendor_no" id="vendor_no" value="">
							<input type="hidden" name="po_no" id="po_no" value="">
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">Pilih Kriteria Penilaian</div>
						<div class="panel-body">
							<div class="col-sm-9">
							<select id="criteria" class="form-control select2">
								<option value="0" selected="selected" disabled="disabled">Select Criteria</option>
								<?php foreach ($penilaian as $row): ?>
									<option value="<?php echo $row['ID_CRITERIA'] ?>" data-value="<?php echo html_escape(json_encode($row)) ?>">
										<?php echo $row['CRITERIA_NAME'] ?> | <?php echo $row['CRITERIA_DETAIL'] ?> (<?php echo $row['CRITERIA_SCORE_SIGN'] . $row['CRITERIA_SCORE'] ?> Poin)
									</option>
								<?php endforeach ?>
							</select>
							</div>
							<div class="col-sm-3">
								<button type="button" class="btn btn-success" onclick="pilih()">Tambah</button>
							</div>
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
							<a href="#!" class="main_button color7 small_btn">Kembali</a>
							<button type="submit" class="main_button color6 small_btn">Submit</button>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</section>

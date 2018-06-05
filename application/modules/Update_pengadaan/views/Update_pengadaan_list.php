<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Daftar Pengadaan</h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                	<?php if ($success): ?>
                		<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Success!</strong> Data berhasil disimpan.
						</div>
                	<?php endif ?>
					<table id="update-pengadaan-list-table" class="table table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th class="col-md-2">Nomor Pengadaan</th>
								<th>Deskripsi</th>
								<th>Status</th>
								<th>Tanggal Aktivitas</th>
								<th class="col-md-2">Aksi</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
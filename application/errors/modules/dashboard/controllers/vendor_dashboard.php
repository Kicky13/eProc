<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span>SELAMAT DATANG</h2>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php if ($success): ?>
						<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Success!</strong> Data berhasil disimpan.
						</div>
					<?php endif ?>
					<div class="panel panel-default">
						<div class="panel-heading">Job Summary</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th class="text-center">Activity</th>
										<th class="text-center">Count</th>
										<th class="text-center">Activity</th>
										<th class="text-center">Count</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Undangan Penawaran</td>
										<td class="text-center"><strong><a href="<?php echo site_url('Tender_invitation'); ?>"><?php echo $total_tender_invitation; ?></a></strong></td>
										<td>Negosiasi</td>
										<td class="text-center"><strong><a href="<?php echo base_url('Nego_invitation') ?>"><?php echo $total_negotiaion ?></a></strong></td>
									</tr>
									<tr>
										<td>Input/Edit Penawaran</td>
										<td class="text-center"><strong><a href="<?php echo site_url('Quotation'); ?>"><?php echo $total_quotation ?></a></strong></td>
										<td>Auction</td>
										<td class="text-center"><strong><a href="<?php echo site_url('Auction_negotiation'); ?>"><?php echo $total_auction_negotiation; ?></a></strong></td>
									</tr>
									<tr>
										<td>Penawaran Terkirim</td>
										<td class="text-center"><strong><a href="<?php echo site_url('Quotation'); ?>/view_submittedQuotation"><?php echo $total_submit_quotation ?></a></strong></td>
										<td>PO</td>
										<td class="text-center"><strong><a href="<?php echo site_url('Tender_awarded'); ?>"><?php echo $total_tender_awarded; ?></a></strong></td>
									</tr>
									<tr>
										<td>Klarifikasi teknis</td>
										<td class="text-center"><strong><a href="<?php echo site_url('Proc_chat_vendor'); ?>/index"><?php echo $tot_chat ?></a></strong></td>
										<?php
										if($showInvoice){
											echo '<tr>';
											echo '<td>Invoice</td>';
											echo '<td class="text-center"><strong><a href="'.site_url('EC_Invoice_Management').'">'.$unbilled_gr.' </a></strong></td>';
									
											echo '<td></td>';
											echo '<td></td>';
											echo '</tr>';
										}
										?>

									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<?php if($needupdate): ?>

					<?php $flag_panel = array(
                              'Info Perusahaan',
                              'Alamat Perusahaan',
                              'Kontak Perusahaan',
                              'Akta Pendirian',
                              'Domisili Perusahaan',
                              'NPWP',
                              'PKP',
                              'SIUP',
                              'TDP',
                              'Angka Pengenal Importir',
                              'Dewan Komisaris',
                              'Dewan Direksi',
                              'Rekening Bank',
                              'Modal Sesuai Dengan Akta Terakhir',
                              'Informasi Laporan Keuangan',
                              'Barang dan bahan yang bisa dipasok',
                              'Jasa yang bisa dipasok',
                              'Tenaga Ahli Utama',
                              'Tenaga Ahli Pendukung',
                              'Keterangan Sertifikat',
                              'Keterangan Tentang Fasilitas dan Peralatan',
                              'Pekerjaan',
                              'Principal',
                              'Subkontraktor',
                              'Perusahaan Afiliasi',
                        ); ?>
			<div class="rows_container clearfix">
		        <div class="col-md-12">
		          <form class="login_form_colored">
		            <div class="lfc_user_row">
		              <span class="lfc_header">List yang Perlu Diperbaiki</span>
		            </div>
		            <div class="lfc_user_row">
		              <table class="table table-hover margin-bottom-20" id="ref_doc">
		                <thead>
		                  <tr>
		                    <th class="text-center">No</th>
		                    <th class="text-left">Persyaratan Administrasi</th>
		                    <th class="text-center" style="width: 300px">Status</th>
		                    <th class="text-left" style="width: 300px">Keterangan</th>
		                  </tr>
		                </thead>
		                <tbody id="tableItem">
		                  <?php if (empty($ref_doc)) { ?>
		                  <tr id="empty_row">
		                    <td colspan="4" class="text-center">- Belum ada data -</td>
		                  </tr>
		                  <?php } else {
		                    $no = 1;
		                    foreach ($flag_panel as $k => $val) {
		                    	foreach ($ref_doc as $key => $doc) { ?>
		                    		<?php if($val == $doc['CONTAINER']){ ?>
					                    <tr class="<?php echo $doc['STATUS'] == 'Rejected' ? 'danger' : '' ?>">
					                      <td class="text-center"><?php echo $no++; ?></td>
					                      <td><?php echo $doc['CONTAINER']; ?></td>
					                      <td class="text-center"><?php if($doc['STATUS'] == 'Rejected') if($doc['REASON'] == "Dokumen Hampir Expired") echo "Approved"; else echo $doc['STATUS']; else echo $doc['STATUS']; ?></td>
					                      <td><?php echo $doc['STATUS'] == 'Rejected' ? $doc['REASON'] : '' ?></td>
					                    </tr>
					                    <?php } ?>
		                  <?php } ?>
	                    	<?php } ?>
		                  <?php } ?>
		                </tbody>
		              </table>
		            </div>
		            <div class="lfc_user_row clearfix text-center">
		              <!-- <a href="<?php echo base_url(); ?>Additional_document/input_summary" class="send_button upper">Continue Edit Profile</a> -->
              			<a href="<?php echo base_url(); ?>Vendor_update_profile/index/data_vendor" class="send_button upper">Continue Edit Profile</a>

		            </div>
		          </form>
		        </div>
		      </div>
		      <br>
		  	<?php endif ?>
			</div>
		</div>
	</div>
</section>

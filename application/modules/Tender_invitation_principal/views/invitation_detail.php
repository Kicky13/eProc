<input type="text" class="hidden" id="base_url" value="<?php echo base_url(); ?>">
<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span>Detail Undangan Penawaran</h2>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php
					$url = "Tender_invitation_principal/do_update_tender_invitation/".$ptv_id;
					echo form_open($url,array('class' => 'form-horizontal tender_invitationForm submit', 'method' => 'POST')); ?>
					<!-- <div class="panel panel-default">
						<div class="panel-heading">Informasi Umum</div>
						<div class="panel-body">
							<div class="form-group">
								<label for="NPP" class="col-sm-3 control-label">Nomor Pengadaan</label>
								<label for="NPP" class="col-sm-9 text-left control-label">
									<strong><?php echo $tender_invitation['PTM_PRATENDER']; ?></strong>
								</label>
							</div>
							<div class="form-group">
								<label for="FIRSTNAME" class="col-sm-3 control-label">Deskripsi Pekerjaan</label>
								<label for="FIRSTNAME" class="col-sm-9 text-left control-label">
									<strong><?php echo $tender_invitation['PTM_SUBJECT_OF_WORK']; ?></strong>
								</label>
							</div>
							<div class="form-group">
								<label for="RFQ" class="col-sm-3 control-label">RFQ No</label>
								<label for="RFQ" class="col-sm-9 text-left control-label">
									<strong><?php echo $tender_invitation['PTV_RFQ_NO']; ?></strong>
								</label>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">Informasi Pengadaan</div>
						<div class="panel-body">
							<div class="form-group">
								<label for="NPP" class="col-sm-3 control-label">Mekanisme Pengadaan</label>
								<label for="NPP" class="col-sm-9 text-left control-label">
									<strong><?php echo $ptp['PTP_JUSTIFICATION'] ?></strong>
								</label>
							</div>
							<div class="form-group">
								<label for="NPP" class="col-sm-3 control-label">Metode Penawaran</label>
								<label for="NPP" class="col-sm-9 text-left control-label">
									<strong><?php echo ($ptp['PTP_IS_ITEMIZE'] == 1 ? 'Itemize' : 'Paket') ?></strong>
								</label>
							</div>
							<div class="form-group">
								<label for="NPP" class="col-sm-3 control-label">Sistem Sampul</label>
								<label for="NPP" class="col-sm-9 text-left control-label">
									<strong><?php echo $ptp['PTP_EVALUATION_METHOD'] ?></strong>
								</label>
							</div>
							<div class="form-group">
								<label for="NPP" class="col-sm-3 control-label">Pembukaan Pendaftaran</label>
								<label for="NPP" class="col-sm-9 text-left control-label">
									<strong><?php echo empty($tender_invitation['PTP_REG_OPENING_DATE']) ? '' : oracledate(oraclestrtotime($tender_invitation['PTP_REG_OPENING_DATE'])) ?></strong>
								</label>
							</div>
							<div class="form-group">
								<label for="FIRSTNAME" class="col-sm-3 control-label">Penutupan Pendaftaran</label>
								<label for="FIRSTNAME" class="col-sm-9 text-left control-label">
									<strong><?php echo empty($tender_invitation['PTP_REG_CLOSING_DATE']) ? '' : oracledate(oraclestrtotime($tender_invitation['PTP_REG_CLOSING_DATE'])) ?></strong>
								</label>
							</div>
							<div class="form-group">
								<label for="FIRSTNAME" class="col-sm-3 control-label">Tanggal Rapat Penjelasan Teknis</label>
								<label for="FIRSTNAME" class="col-sm-9 text-left control-label">
									<strong><?php echo empty($tender_invitation['PTP_PREBID_DATE']) ? '' : oracledate(oraclestrtotime($tender_invitation['PTP_PREBID_DATE'])) ?></strong>
								</label>
							</div>
							<div class="form-group">
								<label for="FIRSTNAME" class="col-sm-3 control-label">Lokasi Rapat Penjelasan Teknis</label>
								<label for="FIRSTNAME" class="col-sm-9 text-left control-label">
									<strong><?php echo empty($tender_invitation['PTP_PREBID_LOCATION']) ? '' : oracledate(oraclestrtotime($tender_invitation['PTP_PREBID_LOCATION'])) ?></strong>
								</label>
							</div>
						</div>
					</div> -->
					<?php echo $detail_ptm ?>
					<?php echo $dokumen_pr ?>
					<?php echo $detail_item_ptm ?>

					<?php if($ptp['PTP_JUSTIFICATION_ORI'] == 5) : ?> <!-- RO -> REPEAT ORDER -->
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            PO
	                        </div>
	                        <div class="panel-body" style="width: 100%; overflow-x: auto;">
	                            <table class="table table-striped">
	                                 <thead>
	                                    <tr>
	                                        <?php foreach ($invitation_tender_items as $val) : ?>
	                                            <th colspan="3" class="text-center"><span style="color:black"><?php echo $val['PPI_ID']; ?></span></th>
	                                        <?php endforeach; ?>
	                                    </tr>
	                                    <tr>
	                                        <?php foreach ($invitation_tender_items as $val) : ?>
	                                            <th class="text-center">No PO</th>
	                                            <th class="text-center">Nilai</th>
	                                            <th class="text-center">Tanggal</th>
	                                        <?php endforeach; ?>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                    <tr>
	                                        <?php foreach ($invitation_tender_items as $val) : ?>
	                                            <td class="text-center"><?php echo $val['NO_PO']; ?></td>
	                                            <td class="text-center"><?php echo $val['NETPR']; ?></td>
	                                            <td class="text-center"><?php echo $val['TGL_PO']; ?></td>
	                                        <?php endforeach; ?>
	                                    </tr>
	                                </tbody>
	                            </table>
	                        </div>
	                    </div>
                    <?php endif; ?>
                    <?php if($tender_invitation['PTV_TENDER_TYPE']==2){?>
					<div class="panel panel-default">
						<div class="panel-heading">Partisipasi</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3">
									<input type="radio" name="PTV_STATUS" value="1" checked onchange="ikut(this)"> Ikut<br>
									<input type="radio" name="PTV_STATUS" value="0" onchange="tidakikut(this)"> Tidak Ikut
								</div>
								<div class="col-md-9">
									<input type="hidden" name="ptm_number" value="<?php echo $ptp['PTM_NUMBER']; ?>">
									<textarea name="alasan" class="col-md-12 form-control form-input alasan" disabled></textarea>
								</div>
							</div>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-body text-center">
							<a href="<?php echo site_url('Tender_invitation_principal'); ?>" class="main_button small_btn reset_button">Kembali</a>&nbsp;
							<input type="hidden" value="Apakah Anda yakin dengan jawaban Anda?" class="subjudul"></input>
							<button class="main_button color6 small_btn formsubmit" type="submit">Simpan</button>
						</div>
					</div>
					<?php } ?>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</section>
<br>
<br>


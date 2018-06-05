<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php
// print_r($tod);
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


<div class="modal fade" id="document_biaya" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Document Biaya</h4>
			</div>
			<div class="modal-body">


				<form class="form-horizontal" enctype="multipart/form-data" method="POST" id="formrooms4">
					<input readonly="readonly" type="hidden" class="form-control NO_PO" name="NO_PO" value="<?php echo $NO_PO; ?>">
					<input readonly="readonly" type="hidden" class="form-control IDBIAYA" name="IDBIAYA">
					<p>
						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Keterangan
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<textarea name="KET_BIAYA" id="KET_BIAYA"></textarea>
								<!-- <input type="text" class="form-control" id="KET" name="KET"> -->
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Total Tagihan (berdasar kontrak)
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control format-koma" id="TOT_TAGIHAN_KONTRAK" name="TOT_TAGIHAN_KONTRAK">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Nilai Ongkos Angkut
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control format-koma" id="NILAI_ONGKOS_ANGKUT" name="NILAI_ONGKOS_ANGKUT">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>


						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Nilai lain (berdasar kontrak)
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control format-koma" id="NILAI_LAIN_KONTRAK" name="NILAI_LAIN_KONTRAK">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>


						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Total Tagihan (at cost)
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control format-koma" id="TOTAL_TAGIHAN_COST" name="TOTAL_TAGIHAN_COST">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Storage
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control format-koma" id="STORAGE" name="STORAGE">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Other
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<textarea name="OTHER" id="OTHER"></textarea>
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Nilai lain (at cost)
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control format-koma" id="NILAI_LAIN" name="NILAI_LAIN">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Fee
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control format-koma" id="FEE" name="FEE">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Biaya Freight
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control format-koma" id="BIAYA_FREIGHT" name="BIAYA_FREIGHT">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Document PPL
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="colm-sm-6">
								<input name="DOC_PPL1" id="DOC_PPL1" onchange="return ValidateFileUploadDOC_PPL1()" accept="application/msword, application/pdf" type="file">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Document Invoice
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="colm-sm-6">
								<input name="DOC_INVOICE1" id="DOC_INVOICE1" onchange="return ValidateFileUploadDOC_INVOICE1()" accept="application/msword, application/pdf" type="file">
							</div>
						</div>


						<div class="form-group">
							<div class="col-sm-3">
							</div>
							<div class="col-sm-3">
								<button type="button" class="btn btn-success save-biaya">Save</button>
							</div>
							<div class="colm-sm-6">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</p>
				</form>

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="document_shipping" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Document Shipping</h4>
			</div>
			<div class="modal-body">

				<form class="form-horizontal" enctype="multipart/form-data" method="POST" id="formrooms2">
					<input readonly="readonly" type="hidden" class="form-control NO_PO" name="NO_PO" value="<?php echo $NO_PO; ?>">
					<input readonly="readonly" type="hidden" class="form-control ID" name="ID">
					<p>
						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								No. PPL Barang
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="NO_PPL_BARANG" name="NO_PPL_BARANG" readonly="readonly">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Jenis Kemasan
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<label for="akta_type" class="custom_select">
									<select name="JENIS_KEMASAN" id="JENIS_KEMASAN" required="">
										<option value="FCL">FCL</option>
										<option value="LCL">LCL</option>
										<option value="BULK">BULK</option>
										<option value="OTHER">OTHER</option>
									</select>
								</label>
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Satuan
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<label for="akta_type" class="custom_select">
									<select name="SATUAN" id="SATUAN" required="">
										<option value="KGM">KGM</option>
										<option value="TNE">TNE</option>
										<option value="EA">EA</option>
										<option value="OTHER">OTHER</option>
									</select>
								</label>
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Document PPL
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="colm-sm-6">
								<input name="DOC_PPL" id="DOC_PPL" onchange="return ValidateFileUploadDOC_PPL()" accept="application/msword, application/pdf" type="file">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Document Shipping
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="colm-sm-6">
								<input name="DOC_SHIPPING" id="DOC_SHIPPING" onchange="return ValidateFileUploadDOC_SHIPPING()" accept="application/msword, application/pdf" type="file">
							</div>
						</div>

						<div class="form-group">
							<label for="date_creation" class="col-sm-3">Tanggal BL
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3 end">
								<div class="input-group date">
									<input type="text" id="TGL_BL" name="TGL_BL" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>

							<label for="date_creation" class="col-sm-3">Tanggal ETA
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3 end">
								<div class="input-group date">
									<input type="text" id="TGL_ETA" name="TGL_ETA" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>
						</div>


						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								No. BL
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="NO_BL" name="NO_BL">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Nama Angkut
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="NAMA_ANGKUT" name="NAMA_ANGKUT">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								POL
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="POL" name="POL">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								POD
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="POD" name="POD">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Negara Asal
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<label for="akta_type" class="custom_select">
									<select name="NEGARA_ASAL" id="NEGARA_ASAL" required="">
										<?php foreach ($country as $c): ?>
											<option value="<?php echo $c['COUNTRY_CODE']; ?>"><?php echo $c['COUNTRY_NAME']; ?> (<?php echo $c['COUNTRY_CODE']; ?>)</option>
										<?php endforeach ?>
									</select>
								</label>
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Nilai Invoice
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control format-koma" id="NILAI_INV" name="NILAI_INV">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Kuantitas BL
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control format-koma" id="KUANTITAS_BL" name="KUANTITAS_BL">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Jumlah container/case
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control format-koma" id="JML_CONTAINER" name="JML_CONTAINER">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3">
							</div>
							<div class="col-sm-3">
								<button type="button" class="btn btn-success save-detail">Save</button>
							</div>
							<div class="colm-sm-6">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</p>
				</form>

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="document_custom" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Document Custom</h4>
			</div>
			<div class="modal-body">

				<form class="form-horizontal" enctype="multipart/form-data" method="POST" id="formrooms3">
					<input readonly="readonly" type="hidden" class="form-control NO_PO" name="NO_PO" value="<?php echo $NO_PO; ?>">
					<input readonly="readonly" type="hidden" class="form-control IDC" name="IDC">
					<p>
						<br>
						<br>
						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								HS Code
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="HS_CODE" name="HS_CODE">
							</div>
							<label for="akta_no" class="col-sm-3">
								Document PPL
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input name="DOC_PPL2" id="DOC_PPL2" onchange="return ValidateFileUploadDOC_PPL2()" accept="application/msword, application/pdf" type="file">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								No. PPL BM
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="NO_PPL_BM" name="NO_PPL_BM">
							</div>
							<label for="akta_no" class="col-sm-3">
								Document Billing
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input name="DOC_BILLING" id="DOC_BILLING" onchange="return ValidateFileUploadDOC_BILLING()" accept="application/msword, application/pdf" type="file">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								No. PPL PDRI
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="NO_PPL_PDRI" name="NO_PPL_PDRI">
							</div>
							<label for="akta_no" class="col-sm-3">
								Document BPN
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input name="DOC_BPN" id="DOC_BPN" onchange="return ValidateFileUploadDOC_BPN()" accept="application/msword, application/pdf" type="file">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								No. PI IP
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="NO_PI_IP" name="NO_PI_IP">
							</div>
							<label for="akta_no" class="col-sm-3">
								Document Manifest
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input name="DOC_MANIFEST" id="DOC_MANIFEST" onchange="return ValidateFileUploadDOC_MANIFEST()" accept="application/msword, application/pdf" type="file">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								No. SPTNP
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="NO_SPTNP" name="NO_SPTNP">
							</div>
							<label for="akta_no" class="col-sm-3">
								Document LS
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input name="DOC_LS" id="DOC_LS" onchange="return ValidateFileUploadDOC_LS()" accept="application/msword, application/pdf" type="file">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								No LS
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="NO_LS" name="NO_LS">
							</div>
							<label for="akta_no" class="col-sm-3">
								Doc Insurance
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input name="DOC_INSURANCE" id="DOC_INSURANCE" onchange="return ValidateFileUploadDOC_INSURANCE()" accept="application/msword, application/pdf" type="file">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								No. Certificate
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="NO_CERT" name="NO_CERT">
							</div>
							<label for="akta_no" class="col-sm-3">
								Document SPPB
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input name="DOC_SPPB" id="DOC_SPPB" onchange="return ValidateFileUploadDOC_SPPB()" accept="application/msword, application/pdf" type="file">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								No. PIB
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="NO_PIB" name="NO_PIB">
							</div>
							<label for="akta_no" class="col-sm-3">
								Document SPTNP
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input name="DOC_SPTNP" id="DOC_SPTNP" onchange="return ValidateFileUploadDOC_SPTNP()" accept="application/msword, application/pdf" type="file">
							</div>
						</div>

						<div class="form-group">
							<label for="date_creation" class="col-sm-3">Tanggal Bayar
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3 end">
								<div class="input-group date">
									<input type="text" id="TGL_BAYAR" name="TGL_BAYAR" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>
							<label for="date_creation" class="col-sm-3">Tanggal Berlaku LS
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3 end">
								<div class="input-group date">
									<input type="text" id="TGL_BERLAKU_LS" name="TGL_BERLAKU_LS" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="date_creation" class="col-sm-3">Tanggal Berlaku
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3 end">
								<div class="input-group date">
									<input type="text" id="TGL_BERLAKU" name="TGL_BERLAKU" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>
							<label for="date_creation" class="col-sm-3">Tanggal SPPB
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3 end">
								<div class="input-group date">
									<input type="text" id="TGL_SPPB" name="TGL_SPPB" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="date_creation" class="col-sm-3">Tanggal SPTNP
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3 end">
								<div class="input-group date">
									<input type="text" id="TGL_SPTNP" name="TGL_SPTNP" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>
							<label for="date_creation" class="col-sm-3">Tanggal Certificate
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3 end">
								<div class="input-group date">
									<input type="text" id="TGL_CERT" name="TGL_CERT" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="date_creation" class="col-sm-3">Tanggal Manifest
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3 end">
								<div class="input-group date">
									<input type="text" id="TGL_MANIFEST" name="TGL_MANIFEST" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>
							<label for="date_creation" class="col-sm-3">Tanggal PIB
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3 end">
								<div class="input-group date">
									<input type="text" id="TGL_PIB" name="TGL_PIB" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="date_creation" class="col-sm-3">Tanggal TA
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3 end">
								<div class="input-group date">
									<input type="text" id="TGL_TA" name="TGL_TA" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>
							<label for="date_creation" class="col-sm-3">Tanggal DO
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3 end">
								<div class="input-group date">
									<input type="text" id="TGL_DO" name="TGL_DO" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Other (NON LARTAS)
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="OTHER_NON_LARTAS" name="OTHER">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Kuota Lartas
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control format-koma" id="KUOTA_LARTAS" name="KUOTA_LARTAS">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Sisa Quota
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control format-koma" id="SISA_KUOTA" name="SISA_KUOTA">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<label for="akta_no" class="col-sm-3">
								Nilai LS
								<span style="color: #FFFFFF">*</span>
							</label>
							<div class="col-sm-3">
								<input type="text" class="form-control format-koma" id="NILAI_LS" name="NILAI_LS">
							</div>
							<div class="colm-sm-6">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3">
							</div>
							<div class="col-sm-3">
								<button type="button" class="btn btn-success save-custom">Save</button>
							</div>
							<div class="colm-sm-6">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</p>
				</form>

			</div>
		</div>
	</div>
</div>
<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
			</div>
			<div class="row">
				<div class="col-md-12">


					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#home">PO</a></li>
						<li><a data-toggle="tab" href="#menu1">Document Shipping</a></li>
						<li><a data-toggle="tab" href="#menu2">Custom</a></li>
						<li><a data-toggle="tab" href="#menu3">Biaya</a></li>
					</ul>

					<div class="tab-content">
						<div id="home" class="tab-pane fade in active">
							<form class="form-horizontal" enctype="multipart/form-data" method="POST" id="formrooms">
								<p>
									<div class="form-group">
										<label for="akta_no" class="col-sm-3">
											Dokumen PO
											<span style="color: #FFFFFF">*</span>
										</label>
										<div class="col-sm-3">
											<input readonly="readonly" type="text" class="form-control NO_PO" name="NO_PO" value="<?php echo $NO_PO; ?>">
										</div>
										<div class="colm-sm-6">
											<input name="DOC_PO" id="DOC_PO" onchange="return ValidateFileUploadDOC_PO()" accept="application/msword, application/pdf" type="file">
										</div>
									</div>

									<div class="form-group">
										<label for="akta_no" class="col-sm-3">
											No. LC
											<span style="color: #FFFFFF">*</span>
										</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" id="NO_LC" name="NO_LC">
										</div>
										<div class="colm-sm-6">
											<input name="DOC_LC" id="DOC_LC" onchange="return ValidateFileUploadDOC_LC()" accept="application/msword, application/pdf" type="file">
										</div>
									</div>

									<div class="form-group">
										<label for="akta_no" class="col-sm-3">
											LSD
											<span style="color: #FFFFFF">*</span>
										</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" id="LSD" name="LSD">
										</div>
										<label for="akta_no" class="col-sm-3">
											Approve Pemenang
											<span style="color: #FFFFFF">*</span>
										</label>
										<div class="col-sm-3">
											<input name="APPROVE_PEMENANG" id="APPROVE_PEMENANG" onchange="return ValidateFileUploadAPPROVE_PEMENANG()" accept="application/msword, application/pdf" type="file">
										</div>
									</div>

									<div class="form-group">
										<label for="akta_no" class="col-sm-3">
											Expiry
											<span style="color: #FFFFFF">*</span>
										</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" id="EXPIRY" name="EXPIRY">
										</div>
										<label for="akta_no" class="col-sm-3">
											Document OK
											<span style="color: #FFFFFF">*</span>
										</label>
										<div class="col-sm-3">
											<input name="DOC_OK" id="DOC_OK" onchange="return ValidateFileUploadDOC_OK()" accept="application/msword, application/pdf" type="file">
										</div>
									</div>

									<div class="form-group">
										<label for="akta_no" class="col-sm-3">
											Forwarder
											<span style="color: #FFFFFF">*</span>
										</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" id="FORWARDER" name="FORWARDER">
										</div>
										<div class="colm-sm-6">
										</div>
									</div>

									<div class="form-group">
										<label for="akta_no" class="col-sm-3">
											Keterangan
											<span style="color: #FFFFFF">*</span>
										</label>
										<div class="col-sm-3">
											<textarea name="KET" id="KET"></textarea>
											<!-- <input type="text" class="form-control" id="KET" name="KET"> -->
										</div>
										<div class="colm-sm-6">
										</div>
									</div>

									<div class="form-group">
										<label for="akta_type" class="col-sm-3">TOP
											<span style="color: #FFFFFF">*</span>
										</label>
										<div class="col-sm-3 end">
											<label for="akta_type" class="custom_select">
												<span class="lfc_alert"></span>
												<select name="TOP" id="TOP" required="">
													<option value="L/C">L/C</option>
													<option value="TT">TT</option>
													<option value="CAD">CAD</option>
												</select>
											</label>
										</div>
									</div>

									<div class="form-group">
										<label for="akta_type" class="col-sm-3">TOD
											<span style="color: #FFFFFF">*</span>
										</label>
										<div class="col-sm-3 end">
											<label for="akta_type" class="custom_select">
												<span class="lfc_alert"></span>
												<select name="TOD" id="TOD" required="">
													<?php foreach ($tod as $t): ?>
														<option value="<?php echo $t['CODE']; ?>"><?php echo $t['DESC']; ?> (<?php echo $t['CODE']; ?>)</option>
													<?php endforeach ?>
												</select>
											</label>
										</div>
									</div>

									<div class="form-group">
										<label for="date_creation" class="col-sm-3">Delivery Date
											<span style="color: #FFFFFF">*</span>
										</label>
										<div class="col-sm-3 end">
											<div class="input-group date">
												<input type="text" id="DELIVERY_DATE" name="DELIVERY_DATE" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
											</div>
										</div>
										<label for="date_creation" class="col-sm-3">Tanggal Nego Forwarding
											<span style="color: #FFFFFF">*</span>
										</label>
										<div class="col-sm-3 end">
											<div class="input-group date">
												<input type="text" id="TGL_NEGO" name="TGL_NEGO" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="date_creation" class="col-sm-3">Tanggal Amend
											<span style="color: #FFFFFF">*</span>
										</label>
										<div class="col-sm-3 end">
											<div class="input-group date">
												<input type="text" id="TGL_AMEND" name="TGL_AMEND" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
											</div>
										</div>
										<label for="akta_no" class="col-sm-3">
											Akhir Nego Forwarding
											<span style="color: #FFFFFF">*</span>
										</label>
										<div class="col-sm-3">
											<div class="input-group date">
												<input type="text" id="AKHIR_NEGO" name="AKHIR_NEGO" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="date_creation" class="col-sm-3">Tanggal Release
											<span style="color: #FFFFFF">*</span>
										</label>
										<div class="col-sm-3 end">
											<div class="input-group date">
												<input type="text" id="TGL_RELEASE" name="TGL_RELEASE" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="akta_no" class="col-sm-3">
											Nilai
											<span style="color: #FFFFFF">*</span>
										</label>
										<div class="col-sm-3">
											<input type="text" class="form-control format-koma" id="NILAI" name="NILAI">
										</div>
										<div class="colm-sm-6">
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-3">
										</div>
										<div class="col-sm-3">
											<button type="button" class="btn btn-success update-detail">Update</button>
										</div>
										<div class="colm-sm-6">
											<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
										</div>
									</div>
								</p>
							</form>

						</div>
						<div id="menu1" class="tab-pane fade">
							<p>
								<div class="panel panel-default">
									<div class="panel-body">
										<button type="button" class="btn btn-success tambahDocShip">Tambah Document Shipping</button>
									</div>
								</div>

								<div class="table-responsive">
									<table id="example2" class="table table-striped table-hover responsive" width="100%" cellspacing="0">
										<thead>
											<tr>
												<th class="no-sort">No</th>
												<th class="col-md-1">Nomor PO</th>
												<th class="col-md-1">Nilai Invoice</th>
												<th class="col-md-2">Negara Asal</th>
												<th class="col-md-2">Tanggal BL</th>
												<th class="col-md-2">Tanggal ETA</th>
												<th class="col-md-2">Document PPL</th>
												<th class="col-md-2">Document Shipping</th>
												<th>Aksi</th>
											</tr>
											<tr>
												<th></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th></th>
											</tr>
										</thead>
										<tbody id="resultDocShip">
										</tbody>
									</table>
								</div>
							</p>
						</div>
						<div id="menu2" class="tab-pane fade">
							<p>
								<div class="panel panel-default">
									<div class="panel-body">
										<button type="button" class="btn btn-success tambahDocCustom">Tambah Document Custom</button>
									</div>
								</div>

								<div class="table-responsive">
									<table id="example3" class="table table-striped table-hover responsive" width="100%" cellspacing="0">
										<thead>
											<tr>
												<th class="no-sort">No</th>
												<th>Nomor PO</th>
												<th>HS Code</th>
												<th>Tanggal DO</th>
												<th>Document PPL</th>
												<th>Document Billing</th>
												<th>Document BPN</th>
												<th>Document Manifest</th>
												<th>Document LS</th>
												<th>Document Insurance</th>
												<th>Document SPPB</th>
												<th>Document SPTNP</th>
												<th>Aksi</th>
											</tr>
											<tr>
												<th></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th></th>
											</tr>
										</thead>
										<tbody id="resultCustom">
										</tbody>
									</table>
								</div>
							</p>
						</div>

						<div id="menu3" class="tab-pane fade">
							
							<p>
								<div class="panel panel-default">
									<div class="panel-body">
										<button type="button" class="btn btn-success tambahBiaya">Tambah Biaya</button>
									</div>
								</div>

								<div class="table-responsive">
									<table id="example4" class="table table-striped table-hover responsive" width="100%" cellspacing="0">
										<thead>
											<tr>

												<th class="no-sort">No</th>
												<th>Nomor PO</th>
												<th>Total Tagihan (berdasar kontrak)</th>
												<th>Nilai Ongkos Angkut</th>
												<th>Nilai lain (berdasar kontrak)</th>
												<th>Total Tagihan (at cost)</th>
												<th>Nilai lain (at cost)</th>
												<th>Storage</th>
												<th>Fee</th>
												<!-- <th>Other</th>
												<th>Keterangan</th> -->
												<th>Document PPL</th>
												<th>Document INVOICE</th>
												<th>Aksi</th>
											</tr>
											<tr>
												<th></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th>
												<!-- <th><input type="text" class="col-xs-12"></th>
												<th><input type="text" class="col-xs-12"></th> -->
												<th></th>
											</tr>
										</thead>
										<tbody id="resultDocBiaya">
										</tbody>
									</table>
								</div>
							</p>

						</div>
					</div>
					<br>

				</div>
			</div>
		</div>
	</div>
</section>
<style type="text/css">
	.border-table{
		border-top: 5px solid #E74C3C;
		border-left: 1px solid #ccc;
		border-right: 1px solid #ccc;
		border-bottom: 1px solid #ccc;
	}
	.padding-list{
		padding-left: 30px; 
		padding-right: 30px; 
		padding-top: 15px;
	}
</style>
<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="row">				
				<div class="col-lg-3">
					<h4>History PO</h4>
				</div>
				<div class="col-lg-9 pull-right">
					<?php echo form_open_multipart('EC_Ecatalog/compares/', array('method' => 'POST', 'class' => 'form-horizontal pull-right')); ?>
					<input type="hidden" id="arr" name="arr[]" />
					<a style="box-shadow: 1px 1px 1px #ccc" href="<?php echo base_url();?>EC_Ecatalog/listCatalog" type="button" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Kembali</a>
					<a style="box-shadow: 1px 1px 1px #ccc" href="<?php echo base_url(); ?>EC_Ecatalog/checkout" type="button" class="btn btn-default" onclick="openChart()"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Cart &nbsp;<span class="badge jml"></span></a>
					<a style="box-shadow: 1px 1px 1px #ccc" href="javascript:void(0)"  data-toggle="modal" data-target="#modalbudget" type="button" class="btn btn-default"><span class="" aria-hidden="true">IDR</span>&nbsp;<span class="budget">Loading...</span></a>
					<button style="box-shadow: 1px 1px 1px #ccc" type="submit"  style="display: none" id="compare" class="btn btn-default">
						Histori
					</button>
					<!-- <a href="<?php echo base_url(); ?>EC_Ecatalog/checkout" type="button" class="btn btn-default" onclick="openChart()"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Chart &nbsp;&nbsp;&nbsp;<span class="badge jml"></span></a> -->
					<a style="box-shadow: 1px 1px 1px #ccc" href="<?php echo base_url(); ?>EC_Ecatalog/perbandingan" type="button" id="compare" class="btn btn-default">
						Compare &nbsp;<span class="badge jmlCompare"></span>
					</a>
					</form>

				</div>
			</div>
			<!-- <br> -->
			<!-- <div class="row border-table" style="height: 250px;">
				<div class="col-lg-12" style="border-bottom: 2px solid #ccc">
					<font style="font-size: 16px;"><strong>NOMOR PO : 4500000289</strong></font>
					<br>
					2016-12-21 09:19:28
					<br>
					<font style="font-size: 16px;"><strong>Total Transaksi : Rp. 190.000</strong></font>
				</div>
				<div class="row">
					
				</div>
				<div class="col-md-2" style="padding: 20px; margin-left: 30px;">
					<img src="<?php //echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>" class="img-responsive"></a>
				</div>
				<div class="col-md-3" style="padding: 20px;">
					<font style="font-size: 16px;"><strong>Total Transaksi : Rp. 190.000</strong></font>					
				</div>
				<div class="row">
					<hr>	
				</div>
				
			</div>
			<br> -->
			<?php										
				for ($i=0; $i < sizeof($po) ; $i++) { 											
			?>
			<div class="row border-table" style="box-shadow: 1px 1px 1px #ccc">
				<div class="col-lg-9">
					<div class="row" style="margin-left: 1px; margin-right: 1px;">
						<font style="font-size: 16px;"><strong>NOMOR PO : <?php echo $po[$i]['PO_NO']?></strong></font>
						<br>	
						Tanggal Transaksi : <?php echo substr($po[$i]['DATE_BUY'], 6, 2).'/'.substr($po[$i]['DATE_BUY'], 4, 2).'/'.substr($po[$i]['DATE_BUY'], 0, 4)?>
						<br>
						<font style="font-size: 16px;"><strong>Total Transaksi : Rp. <?php echo number_format($po[$i]['TOTAL'],0,",",".")?></strong></font>
					</div>					
				</div>				
				<div class="col-lg-3">
					<strong>Vendor</strong>
							<br>
							<?php echo $po[$i]['vendorname']?>
							<br>
							<?php echo $po[$i]['vendorno']?>
				</div>
				<div class="col-lg-12" style="border-bottom: 1px solid #ccc;">
					
				</div>
				<div class="col-lg-12">
					<?php										
						for ($j=0; $j < sizeof($po[$i]['MATERIAL']) ; $j++) { 
						$list = $po[$i]['MATERIAL'];									
					?>
					<div class="row">
						<div class="col-md-2 padding-list">
							<img src="<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>" class="img-responsive"></a>
						</div>
						<div class="col-md-5 padding-list">
							<font style="font-size: 16px;"><strong><?php echo $list[$j]['MAKTX']?></strong></font>
							<br>	
							<?php echo $list[$j]['MATNR']?>
							<br>	
							<?php echo $list[$j]['curr'].' '.number_format($list[$j]['netprice'],0,",",".").'/'.$list[$j]['uom']?>
						</div>
						<!-- <div class="col-md-2 padding-list">
							<strong>Vendor</strong>
							<br>
							<?php //echo $list[$j]['vendorname']?>
							<br>
							<?php //echo $list[$j]['vendorno']?>
						</div> -->
						<div class="col-md-1 padding-list">
							<strong>QTY</strong>
							<br>
							<?php echo $list[$j]['QTY'].' '.$list[$j]['uom']?>
						</div>
						<div class="col-md-2 padding-list">
							<strong>Status</strong>
							<br>
						</div>
						<div class="col-md-2 padding-list">
							<strong>Sub Total</strong>
							<br>
							<?php 
								$sub = $list[$j]['QTY']*$list[$j]['netprice'];
								echo $list[$j]['curr'].' '.number_format($sub,0,",",".")
							?>
						</div>
					</div>
					<hr style="margin: 10px; border-top: 1px solid #ccc;">
					<?php
						}		
					?>	
				</div>
			</div>
			<br>
			<?php
				}
			?>	
			<br><br>
		</div >
	</div >
</section> 

<div class="modal fade" id="cnfrm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h6 class="modal-title" id="myModalLabel">Tiap nomer PO terbit berdasarkan barang dengan nomer kontrak sama</h6>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-4"><h6>PO yang akan terbit</h6></div>
					<div class="col-xs-8">: <a id="jmlPO" >5</a></div>
				</div>
				<div class="row">
					<div class="col-xs-4"><h6>Jumlah barang</h6></div>
					<div class="col-xs-8">: <a id="jmlBrg" >7</a></div>
				</div>
				<div class="row">
					<div class="col-xs-4"><h6>Total biaya</h6></div>
					<div class="col-xs-8">: <a id="totalBiaya" >5.000.000</a></div>
				</div> 				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Cancel
				</button>
				<button type="button" class="btn btn-primary" id="btnCofirmmm" onclick="confirm(this,1)">
					Confirm
				</button>
			</div>
		</div>
	</div>
</div>

<link rel="stylesheet" href="<?php echo base_url()."static/css/pages/EC_miniTable.css"?>" />
<div class="modal fade" id="modalbudget">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>INFORMASI DETAIL BUDGET</u></strong></h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover table-striped" >
					<thead>
						<tr>
							<th>CostCenter</th>
							<th>Description</th>
							<th>GLAccount</th>
							<th>GLDescription</th>
							<th>Current</th>
							<th>Commit</th>
							<th>Actual</th>
							<th>Available</th>
							<th>Cart</th>
						</tr>						
					</thead>
					<tbody id="tbody">						
					</tbody>
				</table>				
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modaldetail">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>INFORMASI PRODUK<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ; ?> --></u></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						Nomor Material
					</div>
					<div class="col-lg-9" id="detail_MATNR"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Teks Pendek
					</div>
					<div class="col-lg-9" id="detail_MAKTX"></div>
				</div>
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						Teks Panjang
					</div>
					<div class="col-lg-9" id="detail_LNGTX"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						UoM
					</div>
					<div class="col-lg-9" id="detail_MEINS"></div>
				</div>
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						Group
					</div>
					<div class="col-lg-9" id="detail_MATKL"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Tipe
					</div>
					<div class="col-lg-9" id="detail_MTART"></div>
				</div>
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						Dibuat
					</div>
					<div class="col-lg-9" id="detail_created"></div>
				</div>
				<div class="row">
					<div class="form-group">
						<label for="picure" class="col-sm-2 control-label">Picure</label>
						<div class="col-sm-offset-3 col-sm-9">
							<img id="pic" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/material_strategis/default_post_img.png'; ?>'"
							src="<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<label for="drawing" class="col-sm-2 control-label">Drawing</label>
						<div class="col-sm-offset-3 col-sm-9">
							<img id="draw" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/material_strategis/default_post_img.png'; ?>'"
							src="<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalpenyedia">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>INFORMASI PENYEDIA<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ; ?> --></u></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row" style="border-bottom: 2px solid #ccc">
					<div class="col-lg-10">
						<h5 id="VENDOR_NAME"></h5>
					</div>
					<div class="col-lg-2">

					</div>
				</div>
				<!-- <div class="row"> -->
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						Alamat
					</div>
					<div class="col-lg-9" id="ADDRESS"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Negara
					</div>
					<div class="col-lg-9" id="ADDRESS_COUNTRY"></div>
				</div>
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						E-mail
					</div>
					<div class="col-lg-9" id="EMAIL_ADDRESS"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Website
					</div>
					<div class="col-lg-9" id="ADDRESS_WEBSITE"></div>
				</div>
				<!-- <div class="row" style="background-color: #e3e9f2">
				<div class="col-lg-3">No. Telp</div>
				<div class="col-lg-9" id="ADDRESS_PHONE_NO"></div>
				</div>
				<div class="row">
				<div class="col-lg-3">No. Fax</div>
				<div class="col-lg-9" id="alamat"></div>
				</div> -->
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						NPWP
					</div>
					<div class="col-lg-9" id="NPWP_NO"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Contact Person
					</div>
					<div class="col-lg-9">
						<div class="row">
							<div class="col-lg-4">
								Nama
							</div>
							<div class="col-lg-3">
								No. Telp
							</div>
							<div class="col-lg-5">
								E-mail
							</div>
						</div>
						<div class="row" style="background-color: #e3e9f2"	>
							<div class="col-lg-4" id="CONTACT_NAME"></div>
							<div class="col-lg-3" id="CONTACT_PHONE_NO"></div>
							<div class="col-lg-5" id="CONTACT_EMAIL"></div>
						</div>
					</div>
				</div>
				<!-- </div> -->
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalprincipal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>INFORMASI PRINCIPAL<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ; ?> --></u></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row" style="border-bottom: 2px solid #ccc; padding-bottom: 10px">
					<div class="col-lg-10">
						<h5 id="PC_NAME"></h5>
					</div>
					<div class="col-lg-2">
						<img src="" id="LOGO" class="img-responsive">
					</div>
				</div>
				<!-- <div class="row"> -->
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						Alamat
					</div>
					<div class="col-lg-9" id="ADDRESS_P"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Negara
					</div>
					<div class="col-lg-9" id="COUNTRY"></div>
				</div>
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						E-mail
					</div>
					<div class="col-lg-9" id="MAIL"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Website
					</div>
					<div class="col-lg-9" id="WEBSITE"></div>
				</div>
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						No. Telp
					</div>
					<div class="col-lg-9" id="PHONE"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						No. Fax
					</div>
					<div class="col-lg-9" id="FAX"></div>
				</div>
				<!-- <div class="row" style="background-color: #e3e9f2">
				<div class="col-lg-3">NPWP</div>
				<div class="col-lg-9" id="NPWP_NO"></div>
				</div> -->
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-12 text-center">
						Partner Bisnis
					</div>
				</div>
				<div class="row" style="background-color: #f2b29b">
					<div class="col-lg-3 text-center">
						Penyedia
					</div>
					<div class="col-lg-1 text-center">
						Negara
					</div>
					<div class="col-lg-2 text-center">
						Website
					</div>
					<div class="col-lg-4 text-center">
						Email
					</div>
					<div class="col-lg-2 text-center">
						No. Telp
					</div>
				</div>
				<div id="divPartner">

				</div>
				<!-- </div> -->
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalPO">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>INFORMASI PO</u></strong></h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover table-striped" >
					<thead>
						<tr>
							<th>PO</th>
							<th>Matrial</th>
							<th>Harga</th>
						</tr>						
					</thead>
					<tbody id="tbodyPO">						
					</tbody>
				</table>				
			</div>
		</div>
	</div>
</div>

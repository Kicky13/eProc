<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<!-- <div class="row">
			<div class="col-lg-12">
			<h5>Shopping Chart</h5>
			</div>
			</div> -->
			<div class="row">
				<div class="col-lg-3">
					<h5>Shopping Cart</h5>
				</div>
				<div class="col-lg-9 pull-right">
					<?php echo form_open_multipart('EC_Ecatalog/compares/', array('method' => 'POST', 'class' => 'form-horizontal pull-right')); ?>
					<input type="hidden" id="arr" name="arr[]" />
					<input type="hidden" id="avl" value=""/>
					<input type="hidden" id="sisa" value=""/>
					<a href="<?php echo base_url(); ?>EC_Ecatalog/listCatalog" type="button" style="box-shadow: 1px 1px 1px #ccc" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Kembali</a>
					<a href="<?php echo base_url(); ?>EC_Ecatalog/history" type="button" style="box-shadow: 1px 1px 1px #ccc" class="btn btn-default"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> History PO</a>
					<a href="javascript:void(0)"  data-toggle="modal" data-target="#modalbudget" style="box-shadow: 1px 1px 1px #ccc; display: none;" type="button" class="btn btn-default"><span class="" aria-hidden="true">IDR</span>&nbsp;<span class="budget">Loading...</span></a>
					<button type="submit"  style="display: none" id="compare" style="box-shadow: 1px 1px 1px #ccc" class="btn btn-default">
						Histori
					</button>
					<!-- <a href="<?php echo base_url(); ?>EC_Ecatalog/checkout" type="button" class="btn btn-default" onclick="openChart()"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Chart &nbsp;&nbsp;&nbsp;<span class="badge jml"></span></a> -->
					<a href="<?php echo base_url(); ?>EC_Ecatalog/perbandingan" style="box-shadow: 1px 1px 1px #ccc" type="button" id="compare" class="btn btn-default"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Compare &nbsp;<span class="badge jmlCompare"></span> </a>
					</form>

				</div>
			</div>
			<div class="row" style="padding-top: 5px">
				<div class="col-lg-9 col-md-9">
					<div class="row" style="border-top: 1px solid #ccc;"></div>
					<br>
					<div id="goods"></div>
				</div>
				<div class="col-lg-3 col-md-3 pull-right" style="border-left: 1px solid #ccc;border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;">
					<?php echo form_open_multipart('EC_Ecatalog/confirm/', array('method' => 'POST', 'class' => 'form-horizontal')); ?>
					<input type="hidden" id="hid_current_budget" />
					<input type="hidden" id="hid_estimated_budget" />
					<div class="form-group">
						<label for="budgett" class="col-sm-4 control-label text-left" hidden="">Budget</label>
						<label id="budgett" class="col-sm-8 control-label pull-right" hidden="">0</label>
						<label for="totall" class="col-sm-4 control-label text-left">Total</label>
						<label id="totall" class="col-sm-8 control-label pull-right">0</label>
						<label for="totalsisa" class="col-sm-4 control-label text-left" hidden="">Sisa Budget</label>
						<label id="totalsisa" class="col-sm-8 control-label pull-right" hidden="">0</label>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<!-- <button type="button" id="btn_confirm"  data-toggle="modal" data-target="#cnfrm" onclick="" class="btn btn-danger disabled">
								Konfirmasi Beli
							</button> -->
							<button type="button" id="btn_confirm" onclick="" class="btn btn-danger disabled">
								Konfirmasi Beli
							</button>
						</div>

						<div class="col-sm-12 text-center">
							<label id="pocreated" class="col-sm-12 control-label text-center"></label>
						</div>

					</div>
					</form>
					<!-- <button type="submit" id="compare" style="width: auto;" class="btn btn-danger">
					Konfirmasi Beli
					</button> -->
					</center>
				</div>
			</div>
		</div >
	</div >
</section>

<div class="modal fade" id="cnfrm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h6 class="modal-title" id="myModalLabel">Tiap nomer PO terbit berdasarkan barang dengan nomer kontrak sama</h6>
			</div>
			<div class="modal-body">
				<div class="row" style="padding: 2px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Company
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="selComp">
                        	<option value='' selected disabled>Select Company</option>
                        	<?php
                        		// var_dump($company);
                        		foreach ($company as $value) { ?>
                        			<option value='<?php echo $value['COMPANYID']?>' <?php //if(substr($value['COMPANYID'],0,1)==substr($data_produk[0]['plant'],0,1)){ echo 'selected';} ?>><?php echo $value['COMPANYNAME']?></option>
                        	<?php
                        		}
                        	?>
                        </select>
                    </div>
                </div>
				<div class="row" style="padding: 2px; margin-top: 15px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Purchasing Organization
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="selOrg">
                        	<option value='' selected disabled>Select Purchasing Organization</option>
                        	<option value='HC01'>HC01 Purchasing Organization SMI</option>
                            <option value='SP01'>SP01 Purc Org SP</option>
                            <option value='ST01'>ST01 Purc Org ST</option>
                            <option value='KS01'>KS01 Purc Org KSO</option>
                            <option value='OP01'>OP01 Purc Org SG</option>           
                        </select>
                    </div>
                </div>
                <div class="row" style="padding: 2px; margin-top: 15px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Purchasing Group
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="selGroup">
                        	<option value='' disabled>Select Purchasing Group</option>
                        	<option value='101' selected>Pembelian Kontrak</option>
                            <option value='P01'>P01 Bahan Baku SP</option>
                            <option value='P02'>P02 Mesin&Suku Cadang SP</option>
                            <option value='T01'>T01 Bahan Baku ST</option>
                            <option value='T02'>T02 Mesin&Suku Cadang ST</option>
                            <option value='K01'>K01 Bahan Baku KSO</option>
                            <option value='K02'>K02 Mesin&Suku Cadang KSO</option>
                            <option value='O01'>O01 Bahan Baku SG</option>
                            <option value='O02'>O02 Mesin&Suku Cadang SG</option>               
                        </select>
                    </div>
                </div>
            	<div class="row" style="padding: 2px; margin-top: 15px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Document Type
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="sel1">
                        	<option value='' selected disabled>Select Document Type</option>
                            <option value='ZG01'>ZG01 PO Stock Lokal SMI</option>
                            <option value='ZG02'>ZG02 PO NonStock Lokal SMI</option>
                            <option value='ZG03'>ZG03 PO Stock Import SMI</option>
                            <option value='ZG04'>ZG04 PO NonStock Import SMI</option>
                            <option value='ZG05'>ZG05 PO Investasi SMI</option>
                            <option value='ZG08'>ZG08 PO Curah Lokal SMI</option>
                            <option value='ZG09'>ZG09 PO Curah Import SMI</option>
                            <option value='ZP01'>ZP01 PO Stock Lokal SP</option>
                            <option value='ZP02'>ZP02 PO NonStock Lokal SP</option>
                            <option value='ZP03'>ZP03 PO Stock Import SP</option>
                            <option value='ZP04'>ZP04 PO NonStock Import SP</option>
                            <option value='ZP05'>ZP05 PO Investasi SP</option>
                            <option value='ZP08'>ZP08 PO Curah Lokal SP</option>
                            <option value='ZP09'>ZP09 PO Curah Import SP</option>                                
                            <option value='ZT01'>ZT01 PO Stock Lokal ST</option>
                            <option value='ZT02'>ZT02 PO NonStock Lokal ST</option>
                            <option value='ZT03'>ZT03 PO Stock Import ST</option>
                            <option value='ZT04'>ZT04 PO NonStock Import ST</option>
                            <option value='ZT05'>ZT05 PO Investasi ST</option>
                            <option value='ZT08'>ZT08 PO Curah Lokal ST</option>
                            <option value='ZT09'>ZT09 PO Curah Import ST</option>                               
                            <option value='ZK01'>ZK01 PO Stock Lokal KSO</option>
                            <option value='ZK02'>ZK02 PO NonStock Lokal KSO</option>
                            <option value='ZK03'>ZK03 PO Stock Import KSO</option>
                            <option value='ZK04'>ZK04 PO NonStock Import KSO</option>
                            <option value='ZK05'>ZK05 PO Investasi KSO</option>
                            <option value='ZK08'>ZK08 PO Curah Lokal KSO</option>
                            <option value='ZK09'>ZK09 PO Curah Import KSO</option>                   
                        </select>
                    </div>
                </div>
                <div class="row" style="padding: 2px; margin-top: 15px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Document Date
                    </div>
                   <!-- <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="text" name="viewtglShipment" id="viewtglShipment" placeholder="Tanggal">
                    </div>-->
                    <div class="col-md-3">
                        <div class="form-group">
                        	<input type="hidden" id="tanggalNow" value="<?php echo $tanggal; ?>" name="">
                            <div class="input-group date"><input readonly id="docdate" type="text" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding: 2px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Delivery Date
                    </div>
                   <!-- <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="text" name="viewtglShipment" id="viewtglShipment" placeholder="Tanggal">
                    </div>-->
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group date"><input readonly id="delivdate" type="text" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>
                        </div>
                    </div>
                </div><hr>
				<div class="row">
					<div class="col-xs-4">
						<h6>PO yang akan terbit</h6>
					</div>
					<div class="col-xs-8">
						: <a id="jmlPO" >5</a>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<h6>Jumlah barang</h6>
					</div>
					<div class="col-xs-8">
						: <a id="jmlBrg" >7</a>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<h6>Total biaya</h6>
					</div>
					<div class="col-xs-8">
						: <a id="totalBiaya" >5.000.000</a>
					</div>
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
					<tbody id="tbody"></tbody>
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
	<div class="modal-dialog modal-lg">
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
							<div class="col-lg-4" id="CONTACT_NAME" style="word-wrap: break-word;"></div>
							<div class="col-lg-3" id="CONTACT_PHONE_NO" style="word-wrap: break-word;"></div>
							<div class="col-lg-5" id="CONTACT_EMAIL" style="word-wrap: break-word;"></div>
						</div>
					</div>
				</div>
				<div class="row">
					<hr>
					<div class="col-lg-3" id="nodata"></div>
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
			<div class="modal-footer">
				<small>Halaman akan otomatis refresh dalam <span id="dtk">15</span> detik....</small>
			</div>
		</div>
	</div>
</div>

<section class="content_section"> 
	<div class="content" style="margin-top: 20px">
		<div class="row">
			<!-- <div class="fixed-title"> -->
			<div class="col-lg-12 fixed-compare" id="headh">
				<div class="row" style="border-bottom: 2px solid #ccc">
					<div class="col-lg-4">
						<h5>Perbandingan Produk</h5>
					</div>
					<div class="col-lg-8 pull-right">
					        	<?php echo form_open_multipart('EC_Ecatalog/compares/', array('method' => 'POST', 'class' => 'form-horizontal pull-right')); ?>
					        		<input type="hidden" id="arr" name="arr[]" />
					        		<a style="box-shadow: 1px 1px 1px #ccc" href="<?php echo base_url();?>EC_Ecatalog/listCatalog" type="button" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Kembali</a>
					        		<a style="box-shadow: 1px 1px 1px #ccc; display: none;" href="javascript:void(0)"  data-toggle="modal" data-target="#modalbudget" type="button" class="btn btn-default"><span class="" aria-hidden="true">IDR</span>&nbsp;<span class="budget">4000</span></a>
					        		<!-- <button style="box-shadow: 1px 1px 1px #ccc" type="submit"  style="display: none"  class="btn btn-default">Histori</button> -->
					        		<a style="box-shadow: 1px 1px 1px #ccc" href="<?php echo base_url();?>EC_Ecatalog/checkout" type="button" class="btn btn-default" onclick="openChart()"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Cart &nbsp;&nbsp;&nbsp;<span class="badge jml"></span></a>	
					        		<!-- <button type="submit" id="compare" class="btn btn-default">Perbandingan</button>				        		 -->
					        	</form>
		        	</div>
				</div>
			</div>
			<!-- </div> -->
		</div>
		<div id="bayangan"></div>
		<div class="row  fixed-compare-gbr" style="padding-top: 5px;">
			<div class="col-xs-12">
			<div class="row">
				<div class="col-lg-2" style="background-color: #ffffff">
					<div class="imgsize">
						testing
					</div>					
				</div>
				<div class="col-xs-10"  id="gbr" style="overflow-x: hidden; overflow-y: hidden;">
					<ul class="list-inline list-inline2 ">
					<?php
						$pic = null;
						for ($i=0; $i < sizeof($compare) ; $i++) { 
							$pic = $compare[$i]['PICTURE']==null ? "default_post_img.png" : $compare[$i]['PICTURE'];
					?>
						<li class="imgsize" style="border-right: 1px solid #ccc">
							<!-- <div class="row" style="padding-left: 10px; padding-right: 10px;"> -->
								<a class="pull-left" href="<?php echo base_url()?>EC_Ecatalog/detail_prod/<?php echo $compare[$i]['contract_no'].'/'.$compare[$i]['MATNR']?>"><span class="glyphicon glyphicon-usd" style="color:#337ab7;"  aria-hidden="true"></span>&nbsp;<span class="add"></span></a>
								<a class="pull-left" href="javascript:void(0)" onclick="addCart(this,'<?php echo $compare[$i]['MATNR']?>','<?php echo $compare[$i]['contract_no']?>')"   ><span class="glyphicon glyphicon-shopping-cart" style="color:#5bc0de;" aria-hidden="true"></span>&nbsp;<span class="add"></span></a>
								<a href="<?php echo base_url()?>EC_Ecatalog/hapus_compare/<?php echo $compare[$i]['MATNR']?>/<?php echo $compare[$i]['contract_no']?>"><i class="glyphicon glyphicon-remove pull-right"></i></a>
							<!-- </div> -->
							<div class="row">
							<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="<?php echo $compare[$i]['MATNR']?>">
								<img src="<?php echo base_url()."upload/EC_material_strategis/".$pic.""; ?>" style="width: 140px; height: 140px;"></a>
							</div>
							
						</li>
					<?php
						}
					?>
					</ul>
					<ul class="list-inline list-inline2 ">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
							
					?>
						<li class="" style="border-right: 1px solid #ccc; width: 150px" >							
							<div class="row" style="padding: 10px">
								<center>
									<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="<?php echo $compare[$i]['MATNR']?>" style="white-space: normal;"><strong><?php echo $compare[$i]['MAKTX']?></strong></a>
								</center>	
							</div>
							<div class="row" style="padding: 10px; margin-top: -20px">
								<div class="col-xs-2">
									<?php
										if($i!=0){
									?>
										<a class="pull-left" href="javascript:void(0)" onclick="geser(this,'<?php echo $compare[$i]['MATNR']?>','<?php echo $compare[$i]['contract_no']?>','-1')"><span class="glyphicon glyphicon-arrow-left" style="color: black;" aria-hidden="true"></span></a>
									<?php
										}
									?>

								</div>
								<div class="col-xs-7">
									<center>Geser</center>
								</div>
								<div class="col-xs-2">
									<?php
										if($i!=sizeof($compare)-1){
									?>
										<a class="pull-right" href="javascript:void(0)" onclick="geser(this,'<?php echo $compare[$i]['MATNR']?>','<?php echo $compare[$i]['contract_no']?>','1')"><span class="glyphicon glyphicon-arrow-right" style="color:black;" aria-hidden="true"></span></a>
									<?php
										}
									?>
								</div>
								
								
								
							</div>
						</li>
					<?php
						}
					?>
					</ul>
				</div>
				</div>
			</div>
		</div>

		<div class="row" id="konten">
			<div class="col-lg-2" id="label" style="overflow-y: hidden; overflow-x: scroll; height: 600px">
				<div id="label-longteks" class="row" style="padding-left:20px;border-top: 1px solid #ccc;">
					Long Teks
				</div> 
				<div id="label-measure" class="row" style="padding-left:20px;border-top: 1px solid #ccc;">
					Base Unit Measure
				</div>
				<div id="label-group" class="row" style="padding-left:20px;border-top: 1px solid #ccc;">
					Material Group
				</div>
				<div id="label-type" class="row" style="padding-left:20px;border-top: 1px solid #ccc;">
					Material Type
				</div>
				<div class="row" style="padding-left:10px; padding-top: 10px; border-top: 1px solid #ccc; background-color: #e3e9f2; height: 40px;">
					<h6>Contract Description</h6>
				</div>
				<div id="label-vendor" class="row" style="padding-left:20px;border-top: 1px solid #ccc;">
					Vendor
				</div>
				<div id="label-principal" class="row" style="padding-left:20px;border-top: 1px solid #ccc;">
					Principal
				</div>
				<div id="label-contractno" class="row" style="padding-left:20px;border-top: 1px solid #ccc;">
					Nomor Kontrak
				</div>
				<div id="label-validprice" class="row" style="padding-left:20px;border-top: 1px solid #ccc;">
					Valid Price
				</div>
				<div id="label-org" class="row" style="padding-left:20px;border-top: 1px solid #ccc;">
					Purchasing Organisasi
				</div>
				<div id="label-plant" class="row" style="padding-left:20px;border-top: 1px solid #ccc;">
					No Plant
				</div>
				<div id="label-contract" class="row" style="padding-left:20px;border-top: 1px solid #ccc;">
					Contract Quantity
				</div>
				<div id="label-price" class="row" style="padding-left:20px;border-top: 1px solid #ccc;">
					Unit Price
				</div>
				<div id="label-gross" class="row" style="padding-left:20px;border-top: 1px solid #ccc;">
					Gross Price
				</div>
				<div id="label-curr" class="row" style="padding-left:20px;border-top: 1px solid #ccc;">
					Currency
				</div>
				<div id="label-tod" class="row" style="padding-left:20px;border-top: 1px solid #ccc;">
					Term of Delivery
				</div>
				<div id="label-top" class="row" style="padding-left:20px;border-top: 1px solid #ccc;">
					Term of Payment
				</div>
				
			</div>
			<!--  id="isi" style=" overflow-x: scroll; overflow-y: scroll;"  style="height: 400px"-->
			<div class="col-lg-10"  id="isi" style=" overflow-x: scroll; overflow-y: scroll;height: 600px">
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li class="li-longteks" style="white-space:normal;vertical-align: top; width: 150px;border-right: 1px solid #ccc;">
							<?php echo $longteks[$i]?>
						</li>
					<?php
						}
					?>
				</ul>
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li class="li-measure" style="white-space:normal;vertical-align: top; width: 150px;border-right: 1px solid #ccc; ">
							<?php echo $compare[$i]['MEINS']?>
						</li>
					<?php
						}
					?>
				</ul>
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li class="li-group" style="white-space:normal;vertical-align: top; width: 150px;border-right: 1px solid #ccc; ">
							<?php echo $compare[$i]['MATKL']?>
						</li>
					<?php
						}
					?>
				</ul>
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li class="li-type" style="white-space:normal;vertical-align: top; width: 150px;border-right: 1px solid #ccc; ">
							<?php echo $compare[$i]['MTART']?>
						</li>
					<?php
						}
					?>
				</ul>
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc; background-color: #e3e9f2; height: 40px;">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li style="white-space:normal;vertical-align: top; width: 150px;">
							<h6>&nbsp;</h6>
						</li>
					<?php
						}
					?>
				
				</ul>
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li class="li-vendor" style="white-space:normal;vertical-align: top; width: 150px;border-right: 1px solid #ccc; ">
							<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalpenyedia" data-vendor="<?php echo $compare[$i]['vendorno']?>"><?php echo $compare[$i]['vendorname']?></a>
						</li>
					<?php
						}
					?>
				</ul>
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li class="li-principal" style="white-space:normal;vertical-align: top; width: 150px;border-right: 1px solid #ccc; ">
							<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalprincipal" data-principal="<?php echo $compare[$i]['PC_CODE']?>"><?php echo $compare[$i]['PC_NAME'].' ('.$compare[$i]['PC_CODE'].')'?></a>
						</li>
					<?php
						}
					?>
				</ul>
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li class="li-contractno" style="white-space:normal;vertical-align: top; width: 150px;border-right: 1px solid #ccc; ">
							<?php echo $compare[$i]['contract_no']?>
						</li>
					<?php
						}
					?>
				</ul>
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li class="li-validdate" style="white-space:normal;vertical-align: top; width: 150px;border-right: 1px solid #ccc; ">
							<?php echo substr($compare[0]['validstart'], 6, 2).'/'.substr($compare[0]['validstart'], 4, 2).'/'.substr($compare[0]['validstart'], 0, 4).' - '.substr($compare[0]['validend'], 6, 2).'/'.substr($compare[0]['validend'], 4, 2).'/'.substr($compare[0]['validend'], 0, 4)?>
						</li>
					<?php
						}
					?>
				</ul>
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li class="li-org" style="white-space:normal;vertical-align: top; width: 150px;border-right: 1px solid #ccc; ">
							<?php echo $compare[$i]['porg']?>
						</li>
					<?php
						}
					?>
				</ul>
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li class="li-plant" style="white-space:normal;vertical-align: top; width: 150px;border-right: 1px solid #ccc; ">
							<?php echo $compare[$i]['plant']==null?"-":$compare[$i]['plant'] ?>
						</li>
					<?php
						}
					?>
				</ul>
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li class="li-uom" style="white-space:normal;vertical-align: top; width: 150px;border-right: 1px solid #ccc; ">
							<?php echo $compare[$i]['t_qty'].' '.$compare[$i]['uom']?>
						</li>
					<?php
						}
					?>
				</ul>
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li class="li-price" style="white-space:normal;vertical-align: top; width: 150px;border-right: 1px solid #ccc; ">
							<?php echo $compare[$i]['netprice'].' per '.$compare[$i]['per'].' '.$compare[$i]['uom']?>
						</li>
					<?php
						}
					?>
				</ul>
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li class="li-gross" style="white-space:normal;vertical-align: top; width: 150px;border-right: 1px solid #ccc; ">
							<?php echo $compare[$i]['grossprice']?>
						</li>
					<?php
						}
					?>
				</ul>
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li class="li-curr" style="white-space:normal;vertical-align: top; width: 150px;border-right: 1px solid #ccc; ">
							<?php echo $compare[$i]['curr']?>
						</li>
					<?php
						}
					?>
				</ul>
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li class="li-tod" style="white-space:normal;vertical-align: top; width: 150px;border-right: 1px solid #ccc; ">
							....
						</li>
					<?php
						}
					?>
				</ul>
				<ul class="list-inline list-inline2" style="border-top: 1px solid #ccc">
					<?php
						for ($i=0; $i < sizeof($compare) ; $i++) { 
					?>
						<li class="li-top" style="white-space:normal;vertical-align: top; width: 150px;border-right: 1px solid #ccc; ">
							....
						</li>
					<?php
						}
					?>
				</ul>				
			</div>
		</div>

		<!-- </div > -->
</section>

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
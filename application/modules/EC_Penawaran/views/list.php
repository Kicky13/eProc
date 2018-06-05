<section class="content_section">
	<div class=""><!--        content_spacer  -->
		<div class="content">
            <br/><br/>
			<div class="main_title centered upper">
		        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
		    </div>
			<div class="row">
				<!-- <div class="col-lg-3"> -->
				<!-- <input type="hidden" id="kodeParent" value="<?php //echo $kode; ?>"/>
				<input type="hidden" id="tag" value="<?php //echo $tag; ?>"/> -->
				<!-- </div> -->
                <div class="col-lg-12 col-md-12">
                    <form id="formsearch" class="">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control" id="txtsearch" placeholder="Cari produk...">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button" id="removeTAG" >
                                    <i class="glyphicon glyphicon-remove"></i>
                                </button>
                            </div>
                        </div>
                        <div class="input-group">
                            <div class="input-group">
                                <small>*untuk berhenti menawarkan barang isi harga menjadi 0</small>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="row">
<!--                        <a href="' + base_url + 'EC_Ecatalog/detail_prod/' + data.data[i][5] + '/' + data.data[i][1] + '" style="font-size:12px;"  class="btn btn-primary pull-right">Simpan All</a>-->
                    </div>
                </div>
			</div>
			<br>
			<div class="row">
                <div class="col-lg-7 col-md-7">
                    <div class="row ">
                        <div id="divAttributes" class="" style="  margin-bottom: 5px; border:2px solid #ccc; border-top: solid 5px #ccc;padding-left: 0px;padding-right: 0px;">

                        </div>
                    </div>
                    <!-- <div class="row">
                        <div id="tes"><input type="text" class="form-control"></div>
                    </div> -->
                </div>
                <div class="col-lg-5 col-md-5">
                    <div class="row fixed-compare">
                        <div id="plant" class="container" style="  margin-bottom: 5px; border:2px solid #ccc; border-top: solid 5px #ccc;padding-left: 0px;padding-right: 0px;">
                            <div class="row">
                                <div class="col-lg-12 col-md-12"><h5>&nbsp;&nbsp;Detail: <strong><u id="namaItem" style="color: blue;">...</u></strong></h5></div>
                                <div class="text-center col-lg-6 col-md-6">
                                    <strong>Destination</strong>
                                </div>
                                <div class="text-center col-lg-2 col-md-2">
                                    <strong>Price</strong>
                                </div>
                                <div class="text-center col-lg-4 col-md-4" style="margin-bottom: 10px">
                                    <strong>Delivery Time</strong>
                                </div>
                                <div class="col-lg-12 col-md-12 tessss" style="padding-left: 0px; overflow-y: auto;max-height: 75vh;">
                                    <!-- <form action="<?php //echo base_url()?>EC_Penawaran/saveDetail" style="white-space: normal" method="post"> -->
                                        <input type="hidden" name="matno" id="matno" value=""/>
                                        <input type="hidden" name="" id="lenghtPlant" value="<?php echo sizeof($plant) ?>"/>
                                        <?php foreach ($plant as $val){ ?>
                                        <div class="row" style="padding-left: 25px">
                                            <div class="col-lg-5 col-md-5">
                                                <strong><?php echo $val['PLANT'] ?> &dash; <?php echo $val['DESC'] ?></strong>
                                                <br/><br/>
                                                Last Update:&nbsp;<strong class="last_<?php echo $val['PLANT'] ?>"><strong><span></span></strong></strong>
                                                <!-- <div class="last_<?php //echo $val['PLANT'] ?>"><span></span></div> -->
                                                <br/>
                                                Next Update:&nbsp;<strong class="next_<?php echo $val['PLANT'] ?>"><strong style="color: green;"><span></span></strong></strong>
                                            </div>
                                            <div class="text-center col-lg-3 col-md-3">
                                                <input type="number" id="harga<?php echo $val['PLANT'] ?>" name="<?php echo $val['PLANT'] ?>[]" value="" class="harga_<?php echo $val['PLANT'] ?> form-control stokUp" placeholder="0" style="width: 100%"/>
                                            </div>
                                            <div class="col-lg-3 col-md-3" style="margin-bottom: 10px" id="parent_<?php echo $val['PLANT'] ?>">
                                                <div class="input-group">
                                                    <input type="number" id="deliv<?php echo $val['PLANT'] ?>" name="<?php echo $val['PLANT'] ?>[]" class="deliv_<?php echo $val['PLANT'] ?> form-control stokUp" placeholder="0" id="">
                                                    <div class="input-group-addon">days</div>           
                                                </div>
                                                <br/>
                                                <span id="btn_<?php echo $val['PLANT'] ?>"></span>
                                                <!-- <button class="btn btn-success pull-right" type="button" id="btn_<?php //echo $val['PLANT'] ?>">Save</button> -->
                                            </div>
                                        </div>
                                        <hr style="margin-bottom: 10px;margin-top: 0px;margin-left: 30px;margin-right: 30px" />
                                        <?php } ?>
                                        <!-- <div class="row" style="padding-right: 55px;padding-bottom: 10px">
                                            <button class="btn btn-success pull-right" type="submit">Save</button>
                                        </div> -->
                                    <!-- </form> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
			<nav aria-label="Page navigation" class="pull-right">
			  <ul class="pagination">
			    <li>
			      <a href="javascript:paginationPrev()" aria-label="Previous">
			        <span aria-hidden="true">&laquo;</span>
			      </a>
			    </li>
			    <!-- 
			    <li><a href="javascript:pagination(0,10)">1</a></li>
			    <li><a href="javascript:pagination(10,20)">2</a></li>
			    <li><a href="#">3</a></li>
			    <li><a href="#">4</a></li>
			    <li><a href="#">5</a></li>
			    <li>
			      <a href="javascript:paginationNext()" aria-label="Next">
			        <span aria-hidden="true">&raquo;</span>
			      </a>
			    </li> -->
			  </ul>
			</nav>
		</div >
	</div >
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
                        Short Text
                    </div>
                    <div class="col-lg-9" id="detail_MAKTX"></div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        Long Text
                    </div>
                    <div class="col-lg-9" id="detail_LNGTX"></div>
                </div>
                <div class="row" style="background-color: #e3e9f2">
                    <div class="col-lg-3">
                        UoM
                    </div>
                    <div class="col-lg-9" id="detail_MEINS"></div>
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
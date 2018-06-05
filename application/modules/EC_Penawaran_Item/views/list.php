<section class="content_section">
	<div class=""><!--        content_spacer  -->
		<div class="content">
            <br/><br/>
			<div class="main_title centered upper">
		        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
		    </div>
			<div class="row">
                <div class="col-lg-5 col-md-5">
                    <div class="row ">
                        <div id="divAttributes" class="" style="  margin-bottom: 5px; border:2px solid #ccc; border-top: solid 5px #ccc;padding-left: 0px;padding-right: 0px;">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">                   
                            <nav aria-label="Page navigation" class="pull-right">
                                <ul class="pagination">
                                    <li>
                                        <a href="javascript:paginationPrev()" aria-label="Previous"> <span aria-hidden="true">&laquo;</span> </a>
                                    </li> 
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div id="tes"><input type="text" class="form-control"></div>
                    </div> -->
                </div>
                <div class="col-lg-7 col-md-7">
                    <div class="row" style="  margin-bottom: 5px; border:2px solid #ccc; border-top: solid 5px #ccc;padding-left: 0px;padding-right: 0px;">
                        <strong style="font-size:16px;">&nbsp;&nbsp;Material : <u id="namaItem" style="color: blue;">...</u></strong>
                    <br>
                    <!-- <div class="row"> -->
                    <div id="Invoiced">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_detail" class="table table-striped nowrap" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center ts1"><a href="javascript:void(0)">Destination</a></th>
                                            <th class="text-center ts2"><a href="javascript:void(0)">Currency</a></th>
                                            <th class="text-center ts3"><a href="javascript:void(0)">Price</a></th>
                                            <th class="text-center ts4"><a href="javascript:void(0)">Delivery Time</a></th>
                                            <th class="text-center ts5"><a href="javascript:void(0)">Last Update</a></th>
                                            <th class="text-center ts6"><a href="javascript:void(0)">Next Update</a></th>
                                            <th class="text-center ts7"><a href="javascript:void(0)">Aksi</a></th>
                                        </tr>
                                        <tr class="sear1">
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th></th>                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
                
            </div>
                </div>
			</div>


			<!-- <nav aria-label="Page navigation" class="pull-right">
			  <ul class="pagination">
			    <li>
			      <a href="javascript:paginationPrev()" aria-label="Previous">
			        <span aria-hidden="true">&laquo;</span>
			      </a>
			    </li> -->
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
			  <!-- </ul>
			</nav> -->
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
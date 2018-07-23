<style>
	.datepicker{z-index:1151 !important;}
	
	.startDate{z-index:1151 !important;}
</style>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php echo form_open_multipart(base_url() . 'Procurement_pratender/get_detail', array('method' => 'POST','class' => 'submit')) ?>            
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Informasi Perencana</div>
                        <table class="table table-hover">
                            <tr>
                                <td>User</td>
                                <td><?php echo $this->session->userdata['FULLNAME'] ?></td>
                            </tr>
                            <tr>
                                <td>Biro / Unit</td>
                                <td><?php echo $this->session->userdata['POS_NAME'] ?></td>
                            </tr> 
                        </table>
                    </div>    					
                    <div class="panel panel-default" style="margin-left: -5%;margin-right: -5%; ">
                        <div class="panel-heading">Pilih item</div>
                        <div class="panel-body" style="overflow: auto;">
                        	<div class="col-lg-3" id="cat" style="overflow-y: auto; background-color: white;box-shadow: 1px 1px 1px 1px #ccc; max-height: 83vh;">
								<ul id="tree1">
	
								</ul>
							</div>
                            <div class="col-lg-9" id="tbl_item">
                                <ul class="nav nav-tabs">
                                    <li id="tab1" class="active"><a href="#tab-1" role="tab" data-toggle="tab">Item List</a></li>
                                    <li id="tab2"><a href="#tab-2" role="tab" data-toggle="tab">Propose Assign</a></li>
                                    <li id="tab3"><a href="#tab-3" role="tab" data-toggle="tab">Item Publish</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" role="tabpanel" id="tab-1">
                                        <div class="col-lg-12">
                                            <ol class="breadcrumb" style="font-size: 13px; margin-bottom: 0px;margin-top: 5px;">
                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <span style="color:#e74c3c;" class="glyphicon glyphicon-home" aria-hidden="true"></span>
                                                        </a><a href="javascript:void(0)">&nbsp;&nbsp;Kategori</a>
                                                </li>
                                                <li>
                                                    <!-- <a href="javascript:void(0)" onclick="setCode('3',this)" data-id="2" data-kode="3" data-desc="Machinery and Spare Part"></a> -->
                                                </li>
                                            </ol>
                                            <table id="table_item" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="col-md-1">Action</th>
                                                        <th class="col-md-1 text-center">Mat Number</th>
                                                        <th class="col-md-2 text-center">Description</th>
                                                        <th class="col-md-1 text-center">UoM</th>
                                                        <th class="col-md-3 text-center">Date Assign</th>                                                          
                                                        <!-- <th class="col-md-3 text-center">End</th>  -->
                                                        <th class="col-md-1 text-center">Detail</th>
                                                    </tr>
                                                    <tr>
                                                        <th><input disabled id="chktbl1" type="checkbox" onchange="chkAllitmNotpublish(this,'items')" />&nbsp;All</th>
                                                        <th><input type="text" class="col-xs-12 srch"></th>
                                                        <th><input type="text" class="col-xs-12 srch"></th>
                                                        <th><input type="text" class="col-xs-12 srch"></th>                                                        
                                                        <!-- <th><input type="text" class="col-xs-12 srch"></th> -->
                                                        <th><input type="text" class="col-xs-12 srch"></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                            <!-- <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;: Sudah dipublish ke Vendor -->
                                        </div>
                                    </div>
                                    <div class="tab-pane active" role="tabpanel" id="tab-3">
                                        <div class="col-lg-12">
                                            <table id="table_item_publish" class="table table-hover" style="width:1200px;">
                                                <thead>
                                                <tr>
                                                    <th class="col-md-1 text-center">No Vendor</th>
                                                    <th class="col-md-2 text-center">Nama Vendor</th>
                                                    <th class="col-md-1 text-center">Material Group</th>
                                                    <!-- <th class="col-md-3 text-center">End</th>  -->
                                                    <th class="col-md-1 text-center">Detail</th>
                                                </tr>
                                                <tr>
                                                    <th><input type="text" class="col-xs-12 srch"></th>
                                                    <th><input type="text" class="col-xs-12 srch"></th>
                                                    <th><input type="text" class="col-xs-12 srch"></th>
<!--                                                    <th><input type="text" class="col-xs-12 srch"></th>-->
                                                    <!-- <th><input type="text" class="col-xs-12 srch"></th> -->
<!--                                                    <th><input type="text" class="col-xs-12 srch"></th>-->
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                            <!-- <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;: Sudah dipublish ke Vendor -->
                                        </div>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" id="tab-2">
                                        <div class="col-lg-12">
                                            <table id="table_propose_assign" class="table table-hover" style="width:1050px;">
                                                <thead>
                                                    <tr>
                                                        <th class="col-md-1">Action</th>
                                                        <th class="col-md-1 text-center">Mat Number</th>
                                                        <th class="col-md-2 text-center">Description</th>
                                                        <th class="col-md-1 text-center">UoM</th>
                                                        <th class="col-md-3 text-center">Date Publish</th>  
                                                        <th class="col-md-3 text-center">Date Assign</th>                                                        
                                                        <!-- <th class="col-md-3 text-center">End</th>  -->
                                                        <th class="col-md-1 text-center">Detail</th>
                                                    </tr>
                                                    <tr>
                                                        <th><input disabled type="checkbox" onchange="chkAll(this,'items')" />&nbsp;All</th>
                                                        <th><input type="text" class="col-xs-12 srch"></th>
                                                        <th><input type="text" class="col-xs-12 srch"></th>
                                                        <th><input type="text" class="col-xs-12 srch"></th>                                                        
                                                        <th><input type="text" class="col-xs-12 srch"></th>                                                        
                                                        <!-- <th><input type="text" class="col-xs-12 srch"></th> -->
                                                        <th><input type="text" class="col-xs-12 srch"></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;: Sudah dipublish ke Vendor
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
							
                        </div>
                    </div> 
					<div class="row" style="margin-bottom: 30px">
						<div class="col-md-1" id="button-publish">
							<button type="button" onclick="publish(1)" class="btnpbls btn btn-primary">Publish</button>
						</div>
						<div class="col-md-1" id="button-unpublish" style="display:none;">
							<button type="button" onclick="publish(0)" class="btnupbls btn btn-danger">Unpublish</button>
						</div>
						<!-- <div class="col-md-1 pull-right">
							<button type="button" class="btn btn-primary">Edit</button>
						</div>
						<div class="col-md-3 pull-right">							
							<input type="text" class="form-control" id="exampleInputName2" placeholder="Date">
						</div> -->
					</div>
					
                <div id="PanelNgisor" style="display: none;">
                    <div class="panel panel-default panelvendor_barang" style="margin-top: 15px">
                        <div class="panel-heading">
                            Pilih Vendor
                            <button class="btn btn-sm btn-default invisible">G</button>
                            <div class="pull-right">
                                <button type="button" class="btn btn-sm btn-default generate_vendor">Generate</button>
                            </div>
                        </div>
                        <div class="panel-body">                            
                            <table id="table_vnd" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Act</th>
                                        <th class="text-center">No Vendor</th>
                                        <th class="text-center">Nama Vendor</th> 
                                        <th class="text-center">Material Group</th>
                                    </tr>
                                    <tr>
                                        <th><input type="checkbox" onchange="chkAll(this,'vnd')" />&nbsp;All</th>
                                        <th><input type="text" class="col-xs-12 srch"></th>
                                        <th><input type="text" class="col-xs-12 srch"></th>
                                        <th><input type="text" class="col-xs-12 srch"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <font color="red"><?php echo form_error('item'); ?></font>
                        </div>
                    </div>
                        
                    <div class="panel panel-default" style="display: none;">
                        <div class="panel-heading">Pilih Tanggal</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    Start Date
                                </div>
                                <div class="col-md-3">
                                    End Date
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group date"><input readonly id="startdate" type="text" value="<?php echo $tanggal ?>" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group date"><input readonly id="enddate" type="text" value="" class="form-control"><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>
                                </div>
                            </div>
                        </div>                        
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Setting Master Update Harga</div>
                        <div class="panel-body">
                        	<div class="row">
                        		<div class="col-md-2">
                        			<label>Currency</label>
                        		</div>
                                <div class="col-md-3">                                	
                                    <select class="form-control" id="activityCurrency">                                  
                                    	<option value="0" selected="selected">Pilih Currency...</option>
                                    	<?php for ($i=0; $i < sizeof($currency) ; $i++) { 
                                    		?> 
                                    		<option <?php if($currency[$i]['CURR_CODE']=='IDR') echo 'selected="selected"'?> value="<?php  echo $currency[$i]['CURR_CODE']?>"><?php echo $currency[$i]['CURR_CODE']?> (<?php echo $currency[$i]['CURR_NAME']?>)</option>
                                    	<?php } ?>   
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                            	<div class="col-md-2">
                            	<label>Jangka Waktu Perubahan Harga dan Delivery Time Vendor</label>
                            	</div>
                                <div class="col-md-2">
                                    <select class="form-control" id="activitySelector">                                  
                                    	<option value="0" selected="selected">Pilih Master...</option>
                                    	<?php for ($i=0; $i < sizeof($master_update) ; $i++) { ?> 
                                    		<option value="<?php  echo $master_update[$i]['KODE_UPDATE']?>"><?php  echo $master_update[$i]['UPDATE_DESC']?></option>
                                    	<?php } ?>   
                                    </select>
                                </div>
                            </div>

                            <div class="row" id="days-row" style="margin-top: 10px;">
                            	<div class="col-md-2">

                            	</div>
                            	<div class="col-md-2">
                            		<input type="text" name="lamahari" id="lamahari" style="width: 40px;"> Days
                            	</div>                            	
                            </div>
                        </div>   
                	</div>

                <!-- <div class="col-md-12"> -->
                    <!-- <div class="panel-group"> -->
                        <div class="panel panel-default">
                            <div class="panel-heading">Master Plant
                                <button type="button" class="btn btn-xs btn-danger pull-right" onclick="syncPlant()">Sap Sync</button>
                            </div>
                            <!-- <div class="panel-heading" style="background-color: #18bbf2;">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#collapse1" style=""><strong>Master Plant</strong></a>
                                    <button type="button" class="btn btn-xs btn-danger pull-right" onclick="syncPlant()">Sap Sync</button>
                                </h4>
                            </div> -->
                            <!-- <div id="collapse1" class="panel-collapse collapse"> -->
                                <div class="panel-body">
                                    <table id="table_plant" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Publish</th>
                                            <th class="text-center">Company</th>
                                            <th class="text-center">Plant</th>
                                            <th class="text-center">Plant Desc</th>
                                            <th class="text-center">Alamat</th>
                                            <th class="text-center">Kode Pos</th>
                                            <th class="text-center">Kota</th>
                                        </tr>
                                        <tr>
                                            <th>
                                                <input disabled type="checkbox" class="text-center" onchange="chkAll(this,'chkPlant')" />
                                                &nbsp;All
                                            </th>
                                            <th>
                                                <input type="text" class="col-xs-12 srch">
                                            </th>
                                            <th>
                                                <input type="text" class="col-xs-12 srch">
                                            </th>
                                            <th>
                                                <input type="text" class="col-xs-12 srch">
                                            </th>
                                            <th>
                                                <input type="text" class="col-xs-12 srch">
                                            </th>
                                            <th>
                                                <input type="text" class="col-xs-12 srch">
                                            </th>
                                            <th>
                                                <input type="text" class="col-xs-12 srch">
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <!-- <div class="panel-footer">Panel Footer</div> -->
                            <!-- </div> -->
                        </div>
                    <!-- </div> -->
                <!-- </div> -->

                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">                          
                            <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                            <button type="button" style="margin-top: 15px" class="btn btn-primary" id="assign">Assign</button>
                        </div>
                    </div>
                </div>
                </div>


            </div>
            <?php echo form_close(); ?>
                
        </div>
    </div>
</section>
<div class="modal fade" id="modalItem">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<strong style="font-size: 20px;">Deskripsi Material : <span id="material"></span></strong>
				<br/>
				<strong>Nomer Material</strong> : <span id="nomaterial"></span>
			</div><input type="hidden" id="matno" />
			<div class="modal-body">
				<div class="row">
					<!-- <div class="col-md-10 col-md-offset-2">
						<form class="form-inline">
						  <div class="form-group">
						    <label for="startEdit">Start</label>
                            <div class="input-group date"><input readonly id="startdatemodal" type="text" value="" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>
						    
						  </div>
						  &nbsp;&nbsp;&nbsp;
						  <div class="form-group">
						    <label for="endEdit">End</label>
                            <div class="input-group date"><input readonly id="enddatemodal" type="text" value="" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>
					 
						  </div>
						</form>
					</div> -->
                    
                    <!-- <hr />  -->
					<div class="col-md-12">
						<table id="table_vnd_2" class="table table-striped">
							<thead>
								<tr> 
									<th>Act</th>
									<th class="text-center">No Vendor</th>
									<th class="text-center">Nama Vendor</th>
									<!--<th class="text-center">Material Group</th>-->
								</tr>
								<tr>
									<th>
									<input type="checkbox" onchange="chkAll(this,'vndEdit')" />
									&nbsp;All</th>
									<th>
									<input type="text" class="col-xs-12 srch">
									</th>
									<th>
									<input type="text" class="col-xs-12 srch">
									</th>
<!--									<th>
									<input type="text" class="col-xs-12 srch">
									</th>-->
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Currency</label>
                        </div>
                        <div class="col-md-3">                                  
                            <select class="form-control" id="activityCurrencyEdit">                                  
                                <option value="0" selected="selected">Pilih Currency...</option>
                                <?php for ($i=0; $i < sizeof($currency) ; $i++) { 
                                    ?> 
                                    <option <?php if($currency[$i]['CURR_CODE']=='IDR') echo 'selected="selected"'?> value="<?php  echo $currency[$i]['CURR_CODE']?>"><?php echo $currency[$i]['CURR_CODE']?> (<?php echo $currency[$i]['CURR_NAME']?>)</option>
                                <?php } ?>   
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-2">
                        <label>jangka Waktu</label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control" id="activitySelectorEdit">                                  
                                <option value="0" selected="selected">Pilih Master...</option>
                                <?php for ($i=0; $i < sizeof($master_update) ; $i++) { ?> 
                                    <option value="<?php echo $master_update[$i]['KODE_UPDATE']?>"><?php  echo $master_update[$i]['UPDATE_DESC']?></option>
                                <?php } ?>   
                            </select>
                        </div>
                    </div>
                    <div class="row" id="days-rowEdit" style="margin-top: 10px;">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="lamahari" id="lamahariEdit" style="width: 40px;"> Days
                        </div>                              
                    </div>
                    <br>
				<div class="panel panel-default">
					<div class="panel-body text-center">
						<button type="button" id="saveItm" class="main_button color2 small_btn">
							Simpan
						</button>
						<button type="button"  data-dismiss="modal"  class="main_button color7 small_btn close-modal">
                            Kembali</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalItemPublish">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong style="font-size: 20px;">Nama Vendor : <span id="namaVendor"></span></strong>
                <br/>
                <strong>Nomor Vendor</strong> : <span id="noVendor"></span>
            </div><input type="hidden" id="vendorno" />
            <div class="modal-body">
                <div class="row">
                    <!-- <div class="col-md-10 col-md-offset-2">
                        <form class="form-inline">
                          <div class="form-group">
                            <label for="startEdit">Start</label>
                            <div class="input-group date"><input readonly id="startdatemodal" type="text" value="" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>

                          </div>
                          &nbsp;&nbsp;&nbsp;
                          <div class="form-group">
                            <label for="endEdit">End</label>
                            <div class="input-group date"><input readonly id="enddatemodal" type="text" value="" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>

                          </div>
                        </form>
                    </div> -->

                    <!-- <hr />  -->
                    <div class="col-md-12">
                        <table id="table_vnd_2" class="table table-striped">
                            <thead>
                            <tr>
                                <th>Act</th>
                                <th class="text-center">Nomor Material</th>
                                <th class="text-center">Deskripsi Material</th>
                                <!--<th class="text-center">Material Group</th>-->
                            </tr>
                            <tr>
                                <th>
                                    <input type="checkbox" onchange="chkAll(this,'vndEdit')" />
                                    &nbsp;All</th>
                                <th>
                                    <input type="text" class="col-xs-12 srch">
                                </th>
                                <th>
                                    <input type="text" class="col-xs-12 srch">
                                </th>
                                <!--									<th>
                                                                    <input type="text" class="col-xs-12 srch">
                                                                    </th>-->
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label>Currency</label>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="activityCurrencyPublish">
                            <option value="0" selected="selected">Pilih Currency...</option>
                            <?php for ($i=0; $i < sizeof($currency) ; $i++) {
                                ?>
                                <option <?php echo ($currency[$i]['CURR_CODE']=='IDR') ? "selected":"" ?> value="<?php  echo $currency[$i]['CURR_CODE']?>"><?php echo $currency[$i]['CURR_CODE']?> (<?php echo $currency[$i]['CURR_NAME']?>)</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <label>jangka Waktu</label>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="activitySelectorPublish">
                            <option value="0" selected="selected">Pilih Master...</option>
                            <?php for ($i=0; $i < sizeof($master_update) ; $i++) { ?>
                                <option value="<?php echo $master_update[$i]['KODE_UPDATE']?>"><?php  echo $master_update[$i]['UPDATE_DESC']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row" id="days-rowPublish" style="margin-top: 10px;">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="lamahari" id="lamahariPublish" style="width: 40px;"> Days
                    </div>
                </div>
                <br>
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        <button type="button" id="saveItmPublish" class="main_button color2 small_btn">
                            Simpan
                        </button>
                        <button type="button"  data-dismiss="modal"  class="main_button color7 small_btn close-modal">
                            Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPublish">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u class="modal-publish-item"></u></strong></h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-striped">
                    <thead>
                     <tr>
                        <th>Material Desc</th>
                        <th>Description</th>
                        <th>UoM</th>
                    </tr> 
                    </thead>
                    <tbody id="tbodyPublish">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <small>Halaman akan otomatis refresh dalam <span id="dtk">15</span> detik....</small>
            </div>
        </div>
    </div>
</div>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php
            if (!empty($brhasil)) {
                if ($brhasil == 1)
                    echo '<div class="alert alert-info"> Nomor Shipment ' . $this->uri->segment(4) . ' has been Created!!</div>';
                else if ($brhasil == 2)
                    echo '<div class="alert alert-warning"> Nomor Shipment ' . $this->uri->segment(4) . ' has been Rejected!! </div>';
            }
            ?>
            <div class="row">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#Unapprove" aria-controls="Unapprove" role="tab" data-toggle="tab">Unapprove</a></li>
    <li role="presentation"><a href="#PORelease" aria-controls="PORelease" role="tab" data-toggle="tab">PO Release</a></li>
    <li role="presentation"><a href="#ShipmentIntransit" aria-controls="ShipmentIntransit" role="tab" data-toggle="tab">Shipment Intransit</a></li>
    <!-- <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li> -->
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="Unapprove">
        <div class="row">
                <!-- <div class="row"> -->
                    <div id="Invoiced">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_Unapprove" class="table table-striped nowrap" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center ts1"><a href="javascript:void(0)">PO Number</a></th>
                                            <th class="text-center ts2"><a href="javascript:void(0)">Line Item</a></th>
                                            <th class="text-center ts3"><a href="javascript:void(0)">Deskripsi</a></th>
                                            <th class="text-center ts4"><a href="javascript:void(0)">QTY Order</a></th>
                                            <th class="text-center ts5"><a href="javascript:void(0)">Net Price</a></th>
                                            <th class="text-center ts6"><a href="javascript:void(0)">Value</a></th>
                                            <th class="text-center ts7"><a href="javascript:void(0)">Currency</a></th>
                                            <th class="text-center ts8"><a href="javascript:void(0)">Ship To</a></th>
                                            <th class="text-center ts9"><a href="javascript:void(0)">Date Order</a></th>
                                            <th class="text-center ts10"><a href="javascript:void(0)">Status</a></th>
                                        </tr>
                                        <tr class="sear1">
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <!-- <th></th>
                                            <th></th> -->
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
                <br><br>
            </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="PORelease">
            <br>
            <div class="row">
                <!-- <button type="button" id="setShipment" class="btn btn-primary pull-right" data-toggle="modal" data-target="#shipment">Shipment</button> -->
                <button type="button" id="setShipment" class="btn btn-primary pull-right">Shipment</button>
            </div>
            <div class="row">
                <!-- <div class="row"> -->
                    <div id="Invoiced">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_inv" class="table table-striped nowrap" width="100%">
                                        <thead>
                                        <tr>
                                            <!-- <th class="text-center ts0"><a href="javascript:void(0)">No.</th> -->
                                            <th class="text-center ts1"><a href="javascript:void(0)">PO Number</a></th>
                                            <th class="text-center ts2"><a href="javascript:void(0)">Detail PO</a></th>
                                            <!-- <th class="text-center ts3"><a href="javascript:void(0)">Deskripsi</a></th> -->
                                            <th class="text-center ts3"><a href="javascript:void(0)">QTY Order</a></th>
                                            <th class="text-center ts4"><a href="javascript:void(0)">QTY Shipment</a></th>
                                            <th class="text-center ts5"><a href="javascript:void(0)">PO Value</a></th>
                                            <th class="text-center ts6"><a href="javascript:void(0)">Currency</a></th>
                                            <th class="text-center ts7"><a href="javascript:void(0)">Approve Date</a></th>
                                            <th class="text-center ts8"><a href="javascript:void(0)">Status</a></th>                                            
                                            <th class="text-center ts10"><a href="javascript:void(0)">Aksi</a></th>
                                            <th class="text-center ts11"><a href="javascript:void(0)">Check List</a></th>                                            
                                        </tr>
                                        <tr class="sear2">
                                            <!-- <th></th> -->
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th></th>
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
                <br><br>
            </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="ShipmentIntransit">
       <div class="row">
                <!-- <div class="row"> -->
                    <div id="Invoiced">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_Intransit" class="table table-striped nowrap" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center ts1"><a href="javascript:void(0)">No Shipment</a></th>
                                            <th class="text-center ts2"><a href="javascript:void(0)">PO Number</a></th>
                                            <th class="text-center ts3"><a href="javascript:void(0)">Line Item</a></th>
                                            <th class="text-center ts4"><a href="javascript:void(0)">Deskripsi</a></th>
                                            <th class="text-center ts5"><a href="javascript:void(0)">QTY Order</a></th>
                                            <th class="text-center ts6"><a href="javascript:void(0)">QTY Intransit</a></th>
                                            <th class="text-center ts7"><a href="javascript:void(0)">UoM</a></th>
                                            <th class="text-center ts8"><a href="javascript:void(0)">Ship To</a></th>
                                            <th class="text-center ts9"><a href="javascript:void(0)">Date Order</a></th>                                            
                                            <th class="text-center ts10"><a href="javascript:void(0)">Expired Date</a></th>
                                            <th class="text-center ts11"><a href="javascript:void(0)">Status</a></th>
                                            <th class="text-center ts12"><a href="javascript:void(0)">Aksi</a></th>
                                        </tr>
                                        <tr class="sear3">                                            
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch4" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch4" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch4" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch4" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch4" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch4" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch4" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch4" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch4" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch4" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch4" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch4" style="margin: 0px"></th>
                                            <!-- <th></th>
                                            <th></th> -->
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
                <br><br>
            </div>
    </div>
    <!-- <div role="tabpanel" class="tab-pane" id="messages">...</div>
    <div role="tabpanel" class="tab-pane" id="settings">...</div> -->
  </div>
            </div>
            
        </div>
    </div>
</section>


<div class="modal fade" id="modalShipment">
    <div class="modal-dialog modal-md" style="width:45%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Shipment Data</u></strong></h4>
            </div>
            <div class="modal-body">
            <input type="hidden" name="costCenter" id="costCenter">
            <input type="hidden" name="setCnf" id="setCnf">
			<!-- <div hidden><input  name="kodeShipment" id="kodeShipment"></div>
			<div hidden><input  name="viewStockCommit" id="viewStockCommit"></div>
			<div hidden><input  name="viewQtyShipmenttotal" id="viewQtyShipmenttotal"></div> -->
            <input type="hidden" name="kodeShipment" id="kodeShipment">
            <input type="hidden" name="viewStockCommit" id="viewStockCommit">
            <input type="hidden" name="viewQtyShipmenttotal" id="viewQtyShipmenttotal">
            
			<div class="row" style="padding: 2px;">
                <div class="col-sm-3 col-md-3 col-lg-3">
                    Tanggal
                </div>
               <!-- <div class="col-sm-4 col-md-4 col-lg-4">
                    <input type="text" name="viewtglShipment" id="viewtglShipment" placeholder="Tanggal">
                </div>-->
				  <div class='col-sm-6'>
					<div class="form-group">
						<div class="input-group date"><input readonly id="viewtglShipment" type="text" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>
					</div>
				</div>
            </div>			
            <div class="row" style="padding: 2px;">
                <div class="col-sm-3 col-md-3 col-lg-3">
                    Qty
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <input type="text" name="viewQtyShipment" id="viewQtyShipment" placeholder="Qty">
                </div>                
            </div>
			
			 <div class="row" style="padding: 2px;">
                <div class="col-sm-3 col-md-3 col-lg-3">
                    
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary pull-right" onclick="simpan_shipment()">Simpan</button>  
                </div>                
            </div> 
            
            <!--<div class="row" style="padding: 5px;">
                <div class="col-sm-3 col-md-3 col-lg-3">
                    Username
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group" id="modalbudget">
                        <select class="form-control CC2" name="viewusername" id="viewusername" style="width: 250px;">
                            <option value="0" selected="">Pilih Username</option>
                            <option value="1687:icuk.hertanto">icuk.hertanto</option>
                            <option value="7300:amin.erfandy">amin.erfandy</option>
                            <option value="1111:ridde">ridde</option>
                            <option value="2222:ramadhan">ramadhan</option> 
                        </select>
                    </div>                    
                </div>                
            </div>-->
            
            
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetailPo">
    <div class="modal-dialog modal-md" style="width:75%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Detail PO</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <table id="tableTrack" class="table table-striped nowrap" width="100%">
                            <thead>
                            <tr>
								<th class="text-center">Line Item</th>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center">QTY</th>
                                <th class="text-center">UoM</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Currency</th>
                                <th class="text-center">Value</th>
                                <th class="text-center">Ship To</th>
                                <th class="text-center">Expired Date</th>
                                <!--<th class="text-center">Ship to</th>
                                <th class="text-center">Est. Date</th>-->
                            </tr>
                            </thead>
                            <tbody id="tableDetailPO">
                            <tr>
                                <td>Loading Data......</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetil">
    <div class="modal-dialog modal-md" style="width:75%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Detail Shipment</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <table id="tableTrack" class="table table-striped nowrap" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center">No Shipment</th>
                                <th class="text-center">PO No</th>
                                <th class="text-center">Line Item</th>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center">QTY Order</th>
                                <th class="text-center">QTY Intransit</th>
                                <th class="text-center">Ship To</th>
                                <th class="text-center">No GR</th>
                                <th class="text-center">GR Year</th>
                                <th class="text-center">Date Send</th>
                                <th class="text-center">Status</th>
<!--                                <th class="text-center"><button type="button" id="deleteShipment" class="btn btn-danger btn-sm">Delete</button></th>-->
                                <!--<th class="text-center">Ship to</th>
                                <th class="text-center">Est. Date</th>-->
                            </tr>
                            </thead>
                            <tbody id="bodyTableDetail">
                            <tr>
                                <td>Loading Data......</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-left">
                        <a href="javascript:void(0)">Estimated Date Arrival dihitung jika Approval Full selesai hari ini.</a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="shipment">
    <div class="modal-dialog modal-md" style="width:75%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Review Shipment</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding: 2px; display: none;" >
                    <div class="col-sm-2 col-md-2 col-lg-2">
                        Kode Shipment
                    </div>
                   <!-- <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="text" name="viewtglShipment" id="viewtglShipment" placeholder="Tanggal">
                    </div>-->
                    <div class="col-md-3">
                        <input type="text" id="shipmentCode" name="">
                    </div>
                </div>
                <div class="row" style="padding: 2px;">
                    <div class="col-sm-2 col-md-2 col-lg-2">
                        Tanggal Shipment
                    </div>
                   <!-- <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="text" name="viewtglShipment" id="viewtglShipment" placeholder="Tanggal">
                    </div>-->
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group date"><input readonly id="tglShipment" type="text" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="reviewShipment">
                    
                </div>
                <!-- <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <table id="tableTrack" class="table table-striped nowrap" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Activity</th>
                                <th class="text-center">User</th>
                            </tr>
                            </thead>
                            <tbody id="bodyTableHistory">
                            </tbody>
                        </table>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" id="saveShipment" class="btn btn-primary pull-right">Shipment</button>        
                    </div>                
                </div>
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
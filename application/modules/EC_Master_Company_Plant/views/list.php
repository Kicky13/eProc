<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    Select Company                    
                </div>
                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                    <select class="form-controls" id="selCompany">
                        <option value="" selected="selected" disabled="">Pilih Company</option>
                        <?php
                            foreach ($company as $value) { ?>
                                <option value="<?php echo $value['COMPANYID']?>"><?php echo $value['COMPANYNAME']?></option>
                        <?php 
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
            <div class="panel panel-default" style="margin-top: 10px;">
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
                                    <div class="row">
                    <div id="Invoiced">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_plant" class="table table-striped nowrap" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Check Plant</th>
                                            <th class="text-center ts0"><a href="javascript:void(0)">Plant</a></th>
                                            <th class="text-center ts1"><a href="javascript:void(0)">Deskripsi</a></th>
                                        </tr>
                                        <tr class="sear1">
                                            <th></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div> 
                                </div>
                                <!-- <div class="panel-footer">Panel Footer</div> -->
                            <!-- </div> -->
                        </div>
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
                                <th class="text-center">QTY</th>
                                <th class="text-center">Ship To</th>
                                <th class="text-center">No GR</th>
                                <th class="text-center">GR Year</th>
                                <th class="text-center">Date Send</th>
                                <th class="text-center">Status</th>
                                <th class="text-center"><button type="button" id="deleteShipment" class="btn btn-danger btn-sm">Delete</button></th>
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
                <div class="row" style="padding: 2px;">
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
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php
                $data = $this->session->flashdata('data');
                $sukses = $this->session->flashdata('sukses');
                if($sukses==1){
                    echo '<div class="alert alert-success">
                            Sukses<hr>';?>  
                <table id="pesan" class="table nowrap" width="100%">
                            <thead>
                            <tr>                                
                                <th class="text-center">PO Number</th>
                                <th class="text-center">Line Item</th>
                                <th class="text-center">GR</th>
                                <th class="text-center">GR YEAR</th>
                            </tr>
                            </thead>
                            <tbody id="">
                                <?php 

                                    foreach ($data as $value) {
                                        echo '<tr>
                                                <td class="text-center">'.$value['PO_NO'].'</td>
                                                <td class="text-center">'.$value['LINE_ITEM'].'</td>
                                                <td class="text-center">'.$value['GR'].'</td>
                                                <td class="text-center">'.$value['GR_YEAR'].'</td>
                                             </tr>';
                                    }
                                    
                                ?>
                            </tbody>
                        </table>
                    
              <?php  
                    echo '</div>';
                }else if($sukses==2){
                        echo '<div class="alert alert-danger">
                            Gagal<hr>'.$data[0][0]['MESSAGE'].'</div>';
                }else if($sukses==3){
                        echo '<div class="alert alert-danger">Rejected<hr>'?>  
                <table id="pesan" class="table nowrap" width="100%">
                            <thead>
                            <tr>                   
                                <th class="text-center">Shipment Number</th>             
                                <th class="text-center">PO Number</th>
                                <th class="text-center">Line Item</th>                                
                            </tr>
                            </thead>
                            <tbody id="">
                                <?php 

                                    foreach ($data as $value) {
                                        echo '<tr>
                                                <td class="text-center">'.$value['NO_SHIPMENT'].'</td>
                                                <td class="text-center">'.$value['PO_NO'].'</td>
                                                <td class="text-center">'.$value['LINE_ITEM'].'</td>
                                             </tr>';
                                    }
                                    
                                ?>
                            </tbody>
                        </table>
                    
              <?php  
                    echo '</div>';
                }
            ?>
            <div class="row">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#Unprocessed" aria-controls="Unprocessed" role="tab" data-toggle="tab">Unprocessed</a></li>
    <li role="presentation"><a href="#Processed" aria-controls="Processed" role="tab" data-toggle="tab">Processed</a></li>
    <!-- <li role="presentation"><a href="#ShipmentIntransit" aria-controls="ShipmentIntransit" role="tab" data-toggle="tab">Shipment Intransit</a></li> -->
    <!-- <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li> -->
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="Unprocessed"> 
        <br>
        <div class="row">
            <form class="form-inline pull-right">
                <div class="form-group">
                    <!-- <button type="button" id="setReceipt" class="btn btn-success" data-toggle="modal" data-target="#receipt">Receipt</button> -->
                    <button type="button" id="setReceipt" class="btn btn-success">Receipt</button>
                    <button type="button" id="setReject" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
        <div class="row">
                <!-- <div class="row"> -->
                    <div id="">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_Unprocessed" class="table table-striped nowrap" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center ts1"><a href="javascript:void(0)">Vendor</a></th>
                                            <th class="text-center ts2"><a href="javascript:void(0)">Shipment Number</a></th>
                                            <th class="text-center ts3"><a href="javascript:void(0)">PO Number</a></th>
                                            <th class="text-center ts4"><a href="javascript:void(0)">Line Item</a></th>
                                            <th class="text-center ts5"><a href="javascript:void(0)">Material</a></th>
                                            <th class="text-center ts6"><a href="javascript:void(0)">Qty Shipment</a></th>
                                            <th class="text-center ts7"><a href="javascript:void(0)">Qty</a></th>
                                            <th class="text-center ts8"><a href="javascript:void(0)">UoM</a></th>
                                            <th class="text-center ts9"><a href="javascript:void(0)">Plant</a></th>
                                            <th class="text-center ts10"><a href="javascript:void(0)">Expired Date</a></th>
                                            <th class="text-center ts11"><a href="javascript:void(0)">Check</a></th>
                                            <th class="text-center ts12"><a href="javascript:void(0)">Aksi</a></th>
                                        </tr>
                                        <tr class="sear1">
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3" style="margin: 0px"></th>
                                            <th></th>
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
                <br><br>
            </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="Processed">
            <br/>
            <div class="row">                
                <a data-hariini="<?php echo date('Ymd') ?>" data-href="<?php echo base_url('EC_Good_Receipt_PL/cetakLaporan') ?>" onclick="cetakLaporan(this); return false" class="btn btn-info pull-right" style="margin: 0 15px 10px 0;">Cetak Laporan</a>                
            </div>
            <div class="row">
                <!-- <div class="row"> -->
                    <div id="">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                                    
                                    <table id="table_processed" class="table table-striped nowrap" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center tts1"><a href="javascript:void(0)">Vendor</a></th>
                                            <th class="text-center tts2"><a href="javascript:void(0)">PO Number</a></th>
                                            <th class="text-center tts3"><a href="javascript:void(0)">Line Item</a></th>
                                            <th class="text-center tts4"><a href="javascript:void(0)">Material</a></th>
                                            <th class="text-center tts5"><a href="javascript:void(0)">QTY Order</a></th>
                                            <th class="text-center tts6"><a href="javascript:void(0)">Qty Receipt</a></th>
                                            <th class="text-center tts7"><a href="javascript:void(0)">UoM</a></th>
                                            <th class="text-center tts8"><a href="javascript:void(0)">Net Price</a></th>
                                            <th class="text-center tts9"><a href="javascript:void(0)">Net Value</a></th>
                                            <th class="text-center tts10"><a href="javascript:void(0)">Currency</a></th>
                                            <th class="text-center tts11"><a href="javascript:void(0)">Plant</a></th>
                                            <th class="text-center tts12"><a href="javascript:void(0)">Expired Date</a></th>
                                            <th class="text-center tts13"><a href="javascript:void(0)">Detail</a></th>
                                            <th class="text-center tts14"><a href="javascript:void(0)">Aksi</a></th>
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

<div class="modal fade" id="modalDetilGR">
    <div class="modal-dialog modal-md" style="width:75%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>History Good Receipt</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_detailGR" class="table table-striped nowrap" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center s1"><a href="javascript:void(0)">Vendor</a></th>
                                            <th class="text-center s2"><a href="javascript:void(0)">Shipment Number</a></th>
                                            <th class="text-center s3"><a href="javascript:void(0)">PO Number</a></th>
                                            <th class="text-center s4"><a href="javascript:void(0)">Line Item</a></th>
                                            <th class="text-center s5"><a href="javascript:void(0)">Material</a></th>
                                            <th class="text-center s6"><a href="javascript:void(0)">Qty</a></th>
                                            <th class="text-center s7"><a href="javascript:void(0)">Status</a></th>
                                            <th class="text-center s8"><a href="javascript:void(0)">Alasan Reject</a></th>
                                            <th class="text-center s9"><a href="javascript:void(0)">UoM</a></th>
                                            <th class="text-center s10"><a href="javascript:void(0)">Plant</a></th>
                                            <th class="text-center s11"><a href="javascript:void(0)">GR Number</a></th>
                                            <th class="text-center s12"><a href="javascript:void(0)">GR Year</a></th>
                                            <th class="text-center s13"><a href="javascript:void(0)">Doc Date</a></th>
                                            <th class="text-center s14"><a href="javascript:void(0)">Post Date</a></th>                                            
                                            <th class="text-center s16"><a href="javascript:void(0)">Created On</a></th>
                                            <th class="text-center s17"><a href="javascript:void(0)">Created By</a></th>
                                        </tr>
                                        <tr class="seargr">
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srchgr" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srchgr" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srchgr" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srchgr" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srchgr" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srchgr" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srchgr" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srchgr" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srchgr" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srchgr" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srchgr" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srchgr" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srchgr" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srchgr" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srchgr" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srchgr" style="margin: 0px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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

<div class="modal fade" id="modalDetilGRold">
    <div class="modal-dialog modal-md" style="width:75%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>History Good Receipt</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="tablegr" class="table table-striped nowrap" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center">Vendor</th>
                                <th class="text-center">Shipment Number</th>
                                <th class="text-center">PO Number</th>
                                <th class="text-center">Line Item</th>
                                <th class="text-center">Material</th>
                                <th class="text-center">QTY</th>
                                <th class="text-center">UoM</th>
                                <th class="text-center">Plant</th>
                                <th class="text-center">No GR</th>
                                <th class="text-center">GR Year</th>
                                <th class="text-center">Doc Date</th>
                                <th class="text-center">Post Date</th>
                                <th class="text-center">Status</th>
                                <!-- <th class="text-center"><button type="button" id="deleteShipment" class="btn btn-danger btn-sm">Delete</button></th> -->
                                <!--<th class="text-center">Ship to</th>
                                <th class="text-center">Est. Date</th>-->
                            </tr>
                            </thead>
                            <tbody id="bodyTableDetailGR">
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

<div class="modal fade" id="receipt">
    <div class="modal-dialog modal-md" style="width:75%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Review Good Receipt</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">                    
                    <div class="col-md-7">                    
                        <div class="row" style="padding: 2px; display: none;" >
                            <div class="col-md-4">
                                Kode Shipment
                            </div>
                           <!-- <div class="col-sm-4 col-md-4 col-lg-4">
                                <input type="text" name="viewtglShipment" id="viewtglShipment" placeholder="Tanggal">
                            </div>-->
                            <div class="col-md-8">
                                <input type="text" id="shipmentCode" name="">
                            </div>
                        </div>
                        <div class="row" style="padding: 2px;">
                            <div class="col-md-4">
                                Document Date
                            </div>
                           <!-- <div class="col-sm-4 col-md-4 col-lg-4">
                                <input type="text" name="viewtglShipment" id="viewtglShipment" placeholder="Tanggal">
                            </div>-->
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="input-group date"><input readonly id="docdate" type="text" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding: 2px;">
                            <div class="col-md-4">
                                Posting Date
                            </div>
                           <!-- <div class="col-sm-4 col-md-4 col-lg-4">
                                <input type="text" name="viewtglShipment" id="viewtglShipment" placeholder="Tanggal">
                            </div>-->
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="input-group date"><input readonly id="postdate" type="text" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding: 2px;">
                            <div class="col-md-4">
                                Feedback
                            </div>
                           <!-- <div class="col-sm-4 col-md-4 col-lg-4">
                                <input type="text" name="viewtglShipment" id="viewtglShipment" placeholder="Tanggal">
                            </div>-->
                            <div class="col-md-8">
                                <input id="rating-input" name="rating-input" type="number"/>
                                <textarea class="form-control" rows="4" id="comment" name="comment"></textarea>
                            </div>
                        </div>
                    </div>                                        
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4 style="text-align:center;text-decoration: underline;margin-top:20px;">Informasi Anggaran</h4>
                        <table class="table table-striped nowrap" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center">Cost Center</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Avalaible Budget</th>
                                <th class="text-center">G/L Acount / Keterangan</th>                                
                            </tr>
                            </thead>
                            <tbody>
                                <?php 
                            foreach ($anggaran as $a){                            
                                echo
                                "<tr>"
                                      . "<td class='text-center'>".$a['FICTR']." </td>"
                                      . "<td class='text-center'>".$a['BESCHR']." </td>"
                                      . "<td class='text-center'> Rp ".ribuan($a['AVAILBUDGET'])." </td>"                                     
                                      . "<td class='text-center'> ".$a['FIPEX']." / ".$a['BEZEI']." </td>"
                               . "</tr>";                                                                            
                            }?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <!-- <div id="reviewShipment">
                    
                </div> -->
                <div class="row">
                    <div class="col-md-12">
                        <h4 style="text-align:center;text-decoration: underline;margin-top:20px;">Informasi Good Reciept (GR)</h4>
                        <table id="tableShipment" class="table table-striped nowrap" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center">Vendor</th>
                                <th class="text-center">PO Number</th>
                                <th class="text-center">Line Item</th>
                                <th class="text-center">Material</th>
                                <th class="text-center">Qty Receipt</th>
                                <th class="text-center">UoM</th>
                                <th class="text-center">Plant</th>
                            </tr>
                            </thead>
                            <tbody id="bodyTableGR">
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" id="receiptShipment" class="btn btn-primary pull-right">Ok</button>        
                    </div>                
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reject">
    <div class="modal-dialog modal-md" style="width:75%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Review Reject</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding: 2px;">
                    <div class="col-sm-2 col-md-2 col-lg-2">
                        Alasan Reject
                    </div> 
                   <!-- <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="text" name="viewtglShipment" id="viewtglShipment" placeholder="Tanggal">
                    </div>-->
                    <div class="col-md-5">
                        <textarea class="form-control" rows="4" id="alasanReject" name="alasanReject"></textarea>
                    </div>
                </div>
                <div class="row" style="padding: 2px;">
                    <div class="col-sm-2 col-md-2 col-lg-2">
                        Feedback
                    </div>
                   <!-- <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="text" name="viewtglShipment" id="viewtglShipment" placeholder="Tanggal">
                    </div>-->
                    <div class="col-md-5">
                        <input id="rating-input2" name="rating-input" type="number"/>                        
                    </div>
                </div>
                <hr>
                <!-- <div id="reviewShipment">
                    
                </div> -->
                <div class="row">
                    <div class="col-md-12">
                        <table id="tableShipment" class="table table-striped nowrap" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center">Vendor</th>
                                <th class="text-center">PO Number</th>
                                <th class="text-center">Line Item</th>
                                <th class="text-center">Material</th>
                                <th class="text-center">Qty Receipt</th>
                                <th class="text-center">UoM</th>
                                <th class="text-center">Plant</th>
                            </tr>
                            </thead>
                            <tbody id="bodyTableReject">
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" id="rejectShipment" class="btn btn-primary pull-right">Ok</button>        
                    </div>                
                </div>
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
                <h4 class="modal-title text-center"><strong><u>INFORMASI GOOD RECEIPT</u></strong></h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-striped">
                    <thead>
                    <!-- <tr>
                        <th>PO</th>
                        <th>Matrial</th>
                        <th>Harga</th>
                    </tr> -->
                    </thead>
                    <tbody id="tbodyPO">
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

<script>
    jQuery(document).ready(function() {
        $("#input-21f").rating({
            starCaptions : function(val) {
                if (val < 3) {
                    return val;
                } else {
                    return 'high';
                }
            },
            starCaptionClasses : function(val) {
                if (val < 3) {
                    return 'label label-danger';
                } else {
                    return 'label label-success';
                }
            },
            hoverOnClear : false
        });

        $('.ratingstar1').rating({
            size : 'xs',
            showClear : false,
            showCaption : false,
            readonly : true
        });

        $('#rating-input').rating({
            min : 0,
            max : 5,
            step : 1,
            size : 'xs',
            showClear : false

        });

        $('#rating-input2').rating({
            min : 0,
            max : 5,
            step : 1,
            size : 'xs',
            showClear : false

        });

        $('#btn-rating-input').on('click', function() {
            $('#rating-input').rating('refresh', {
                showClear : true,
                disabled : !$('#rating-input').attr('disabled')
            });
        });

        $('.btn-danger').on('click', function() {
            $("#kartik").rating('destroy');
        });

        $('.btn-success').on('click', function() {
            $("#kartik").rating('create');
        });

        $('#rating-input').on('rating.change', function() {
            //alert($('#rating-input').val());
            $('#btn-submit').removeAttr('disabled');
        });

        $('.rb-rating').rating({
            'showCaption' : true,
            'stars' : '3',
            'min' : '0',
            'max' : '3',
            'step' : '1',
            'size' : 'xs',
            'starCaptions' : {
                0 : 'status:nix',
                1 : 'status:wackelt',
                2 : 'status:geht',
                3 : 'status:laeuft'
            }
        });
    });
</script>
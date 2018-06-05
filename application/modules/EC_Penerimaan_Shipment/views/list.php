<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php
            if (!empty($brhasil)) {
                if ($brhasil == 1)
                    echo '<div class="alert alert-info"> PO ' . $this->uri->segment(4) . ' has been Released!!<br>Wait for Shipment... </div>';
                else if ($brhasil == 2)
                    echo '<div class="alert alert-warning"> PO ' . $this->uri->segment(4) . ' has been Rejected!! </div>';
            }
            ?>
            <div class="row">
                <div class="row"> 
                    <div id="Invoiced">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_inv" class="table table-striped nowrap" width="100%">
                                        <thead>
                                        <tr>
                                            <!-- <th class="text-center ts0"><a href="javascript:void(0)">No.</th> -->
                                            <th class="text-center ts1"><a href="javascript:void(0)">Matno</a></th>
                                            <th class="text-center ts2"><a href="javascript:void(0)">Date Buy</a></th>
                                            <th class="text-center ts3"><a href="javascript:void(0)">PO Number</a></th>
                                            <th class="text-center ts4"><a href="javascript:void(0)">Status&nbsp;<span class="badge"><?php echo $count ?></span></a></th>
                                            <th class="text-center ts5"><a href="javascript:void(0)">Tanggal Kirim</a></th>
											<th class="text-center ts6"><a href="javascript:void(0)">Quantity</a></th>
                                            <th class="text-center ts7"><a href="javascript:void(0)">GR Number</a></th>
                                            <th class="text-center ts8"><a href="javascript:void(0)">GR Date</a></th>
                                            <th class="text-center ts9"><a href="javascript:void(0)">Aksi</a></th>
                                        </tr>
                                        <tr class="sear">
                                            <!-- <th></th> -->
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
											<th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <!-- <td class="text-center ts0"><a href="javascript:void(0)">No.</td> -->
                                            <td class="text-center ts1"><a href="javascript:void(0)">Matno</a></td>
                                            <td class="text-center ts2"><a href="javascript:void(0)">Date Buy</a></td>
                                            <td class="text-center ts3"><a href="javascript:void(0)">PO Number</a></td>
                                            <td class="text-center ts4"><a href="javascript:void(0)">Status</a></td>
                                            <td class="text-center ts5"><a href="javascript:void(0)">Tanggal Kirim</a></td>
											<td class="text-center ts6"><a href="javascript:void(0)">Quantity</a></td>
                                            <td class="text-center ts7"><a href="javascript:void(0)">GR Number</a></td>
                                            <td class="text-center ts8"><a href="javascript:void(0)">GR Date</a></td>
                                            <td class="text-center ts9">
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- <td class="text-center ts0"><a href="javascript:void(0)">No.</td> -->
                                            <td class="text-center ts1"><a href="javascript:void(0)">Matno</a></td>
                                            <td class="text-center ts2"><a href="javascript:void(0)">Date Buy</a></td>
                                            <td class="text-center ts3"><a href="javascript:void(0)">PO Number</a></td>
                                            <td class="text-center ts4"><a href="javascript:void(0)">Status</a></td>
                                            <td class="text-center ts5"><a href="javascript:void(0)">Tanggal Kirim</a></td>
											<td class="text-center ts6"><a href="javascript:void(0)">Quantity</a></td>
                                            <td class="text-center ts7"><a href="javascript:void(0)">GR Number</a></td>
                                            <td class="text-center ts8"><a href="javascript:void(0)">GR Date</a></td>
                                            <td class="text-center ts9">
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- <td class="text-center ts0"><a href="javascript:void(0)">No.</td> -->
                                            <td class="text-center ts1"><a href="javascript:void(0)">Matno</a></td>
                                            <td class="text-center ts2"><a href="javascript:void(0)">Date Buy</a></td>
                                            <td class="text-center ts3"><a href="javascript:void(0)">PO Number</a></td>
                                            <td class="text-center ts4"><a href="javascript:void(0)">Status</a></td>
                                            <td class="text-center ts5"><a href="javascript:void(0)">Tanggal Kirim</a></td>
											 <td class="text-center ts6"><a href="javascript:void(0)">Tanggal Kirim</a></td>
                                            <td class="text-center ts7"><a href="javascript:void(0)">GR Number</a></td>
                                            <td class="text-center ts8"><a href="javascript:void(0)">GR Date</a></td>
                                            <td class="text-center ts9">
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="modalDetil">
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
                                <th class="text-center">No</th>
                                <th class="text-center">Mat No</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">UoM</th>
                                <th class="text-center">Net Price</th>
                                <th class="text-center">Value</th>
                                <th class="text-center">Curr</th>
                                <th class="text-center">Ship to</th>
                                <th class="text-center">Est. Date</th>
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
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-left">
                        <a href="javascript:void(0)">Estimated Date Arrival dihitung jika Approval Full selesai hari ini.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalHistory">
    <div class="modal-dialog modal-md" style="width:75%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Tracking Invoice</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
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
                </div>
            </div>
        </div>
    </div>
</div>
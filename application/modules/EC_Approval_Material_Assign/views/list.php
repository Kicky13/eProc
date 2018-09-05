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
                                    <div class="pull-right">
                                        <button type="button" id="approveItem" class="btn btn-success">Approve</button> 
                                        <button type="button" id="rejectItem" class="btn btn-danger">Reject</button>
                                    </div>
                                    <table id="table_inv" class="table table-striped nowrap" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center ts0"></th>
                                            <th class="text-center ts1"><a href="javascript:void(0)">Material No</a></th>
                                            <th class="text-center ts2"><a href="javascript:void(0)">Description</a></th>
                                            <th class="text-center ts3"><a href="javascript:void(0)">Category</a></th>
                                            <th class="text-center ts4"><a href="javascript:void(0)">Aksi</a></th>
                                        </tr>
                                        <tr class="sear">
                                            <th></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th>
                                                <input type="checkbox" onchange="chkAll(this, 'actionSelect')" title="Check All">
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-center ts0"> </td>
                                            <td class="text-center ts1"><a href="javascript:void(0)">Material No</a></td>
                                            <td class="text-center ts2"><a href="javascript:void(0)">Description</a></td>
                                            <td class="text-center ts3"><a href="javascript:void(0)">Category</a></td>
                                            <td class="text-center ts4">
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center ts0"><a href="javascript:void(0)"> </td>
                                            <td class="text-center ts1"><a href="javascript:void(0)">Material No</a></td>
                                            <td class="text-center ts2"><a href="javascript:void(0)">Description</a></td>
                                            <td class="text-center ts3"><a href="javascript:void(0)">Category</a></td>
                                            <td class="text-center ts4">
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center ts0"><a href="javascript:void(0)"> </td>
                                            <td class="text-center ts1"><a href="javascript:void(0)">Material No</a></td>
                                            <td class="text-center ts2"><a href="javascript:void(0)">Description</a></td>
                                            <td class="text-center ts3"><a href="javascript:void(0)">Category</a></td>
                                            <td class="text-center ts4">
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
                                <th class="text-center">Line Item</th>
                                <th class="text-center">Mat No</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">UoM</th>
                                <th class="text-center">Net Price</th>
                                <th class="text-center">Value</th>
                                <th class="text-center">Curr</th>
                                <th class="text-center">Ship to</th>
                                <th class="text-center">Dokumen Pendukung</th>
                                <th class="text-center">Est. Date</th>
                                <th class="text-center">Penawaran Vendor</th>
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
<div class="modal fade" id="modalHarga">
    <div class="modal-dialog modal-md" style="width:75%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Harga Penawaran Vendor</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>Material No: <span class="matno-harga"></span></p>
                        <p>Description : <span class="desc-harga"></span></p>
                        <table id="tableTrack" class="table table-striped nowrap" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Vendor</th>
                                <th class="text-center">Vendor Name</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Satuan</th>
                                <th class="text-center">Delivery Time</th>
                            </tr>
                            </thead>
                            <tbody id="bodyTableHarga">
                            <tr>
                                <td>Loading Data......</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-left">
                        <a href="javascript:void(0)">Baris yang di Bold (ditebalkan) adalah vendor yang dipilih user</a>
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
                <h4 class="modal-title text-center"><strong><u>Tracking Approval</u></strong></h4>
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
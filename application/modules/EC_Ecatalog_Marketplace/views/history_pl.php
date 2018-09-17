<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="row">
                    <div id="Invoiced">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_inv" class="table table-striped nowrap" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center ts1"><a href="javascript:void(0)">NO</th>
                                            <th class="text-center ts1"><a href="javascript:void(0)">NO PO</th>
                                            <th class="text-center ts2"><a href="javascript:void(0)">PO Date</a></th>
                                            <th class="text-center ts3"><a href="javascript:void(0)">Material</a></th>
                                            <th class="text-center ts3"><a href="javascript:void(0)">Qty</a></th>
                                            <th class="text-center ts3"><a href="javascript:void(0)">CostCenter</a></th>
                                            <th class="text-center ts5"><a href="javascript:void(0)">Status PO</a></th>
                                            <th class="text-center ts6"><a href="javascript:void(0)">Status Delivery</a></th>
                                            <!--                                            <th class="text-center ts8"><a href="javascript:void(0)">Status</a></th>-->
                                            <th class="text-center ts9"><a href="javascript:void(0)">Tracking</a></th>
                                            <th class="text-center ts7"><a href="javascript:void(0)">Last Edit</a></th>
                                        </tr>
                                        <tr class="sear">
                                            <th></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
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
                <br><br>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="modalTracking">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Tracking PO</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <table id="tableTrack" class="table table-striped nowrap" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Status PO</th>
                                <th class="text-center">Status Delivery</th>
<!--                                <th class="text-center">Posisi</th>-->
                                <th class="text-center">User</th>
                            </tr>
                            </thead>
                            <tbody id="bodyTableTrack">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="row">
                    <div id="">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation"><a class="tab1" href="#List_rr" aria-controls="List_rr" role="tab" data-toggle="tab">List RR</a></li>
                                    <li role="presentation"><a class="tab1" href="#Request" aria-controls="Request" role="tab" data-toggle="tab">Lot Request</a></li>
                                    <li role="presentation"><a class="tab1" href="#Rejected" aria-controls="Rejected" role="tab" data-toggle="tab">Lot Rejected <span class="label label-danger" style="border-radius: 1em;"><?php echo $reject?></span></a></li>
                                    <li role="presentation" class="active"><a class="tab1" href="#Ready" aria-controls="Ready" role="tab" data-toggle="tab">Lot Approved</a></li>
                                </ul>

                                <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active" id="Ready">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="datatable_ajax" class="table table-striped nowrap text-center" width="100%">
                                        <thead>
                                                <tr class="klik_sear">
                                                    <th class="text-center tsb"><a href="javascript:void(0)">NO</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">LOT NO</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">PO NO</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">TIPE PO</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">LOT CREATED BY</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">LOT CREATED AT</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">GR YEAR</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">VENDOR</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">ACTION</a></th>

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
                                                </tr>
                                            </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="Rejected">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="datatable_reject" class="table table-striped nowrap text-center" width="100%">
                                        <thead>
                                                <tr>
                                                    <th class="text-center tsc"><a href="javascript:void(0)">NO</a></th>
                                                    <th class="text-center tsc"><a href="javascript:void(0)">LOT NO</a></th>
                                                    <th class="text-center tsc"><a href="javascript:void(0)">PO NO</a></th>
                                                    <th class="text-center tsc"><a href="javascript:void(0)">TIPE PO</a></th>
                                                    <th class="text-center tsc"><a href="javascript:void(0)">LOT CREATED BY</a></th>
                                                    <th class="text-center tsc"><a href="javascript:void(0)">LOT CREATED AT</a></th>
                                                    <th class="text-center tsc"><a href="javascript:void(0)">GR YEAR</a></th>
                                                    <th class="text-center tsc"><a href="javascript:void(0)">VENDOR</a></th>
                                                    <th class="text-center tsc"><a href="javascript:void(0)">STATUS</a></th>
                                                    <th class="text-center tsc"><a href="javascript:void(0)">ACTION</a></th>

                                                </tr>
                                                <tr class="searc">
                                                    <th></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchc" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchc" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchc" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchc" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchc" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchc" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchc" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchc" style="margin: 0px"></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="Request">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="datatable_request" class="table table-striped nowrap text-center" width="100%">
                                        <thead>
                                                <tr>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">NO</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">LOT NO</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">PO NO</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">TIPE PO</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">LOT CREATED BY</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">LOT CREATED AT</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">GR YEAR</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">VENDOR</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">STATUS</a></th>
                                                    <th class="text-center tsb"><a href="javascript:void(0)">ACTION</a></th>

                                                </tr>
                                                <tr class="searb">
                                                    <th></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchb" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchb" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchb" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchb" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchb" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchb" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchb" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchb" style="margin: 0px"></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="List_rr">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="datatable_rr" class="table table-striped nowrap text-center" width="100%">
                                        <thead>
                                                <tr>
                                                    <th class="text-center tsd"><a href="javascript:void(0)">NO</a></th>
                                                    <th class="text-center tsd"><a href="javascript:void(0)">PO NO</a></th>
                                                    <th class="text-center tsd"><a href="javascript:void(0)">PO ITEM NO</a></th>
                                                    <th class="text-center tsd"><a href="javascript:void(0)">TIPE PO</a></th>
                                                    <th class="text-center tsd"><a href="javascript:void(0)">NO RR</a></th>
                                                    <th class="text-center tsd"><a href="javascript:void(0)">DOC DATE</a></th>
                                                    <th class="text-center tsd"><a href="javascript:void(0)">VENDOR</a></th>
                                                    <th class="text-center tsd"><a href="javascript:void(0)">MATERIAL</a></th>
                                                    <th class="text-center tsd"><a href="javascript:void(0)">LOT NUMBER</a></th>
                                                    <th class="text-center tsd"><a href="javascript:void(0)">ACTION</a></th>

                                                </tr>
                                                <tr class="seard">
                                                    <th></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchd" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchd" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchd" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchd" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchd" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchd" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchd" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchd" style="margin: 0px"></th>
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
                        </div>
                    </div>
                </div>
                <br><br>
            </div>
        </div >
    </div >
</section>

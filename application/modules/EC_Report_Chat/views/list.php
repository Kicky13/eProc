<style>
    /* Important part */
    #modalNego .modal-dialog {
        overflow-y: initial !important
    }

    #modalNego .modal-body {
        height: 400px;
        overflow-y: auto;
    }

    #modalNego .text-right {
        padding-left: 250px;
        word-wrap: break-word;
    }

    #modalNego .text-left {
        padding-right: 250px;
        word-wrap: break-word;
    }
</style>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#negoActive" aria-controls="negoActive" role="tab"
                                                              data-toggle="tab">Active</a></li>
                    <li role="presentation"><a href="#negoArchive" aria-controls="negoArchive" role="tab"
                                               data-toggle="tab">Archive</a></li>
                    <!-- <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li> -->
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="negoActive">
                        <div class="row">
                            <!-- <div class="row"> -->
                            <div id="Invoiced">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="panel-group skrol" id="accordion" role="tablist"
                                         aria-multiselectable="true">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <table id="table_nego_active" class="table table-striped nowrap"
                                                   width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">Created
                                                            Date</a></th>
                                                    <th class="text-center ts2"><a
                                                                href="javascript:void(0)">Material</a></th>
                                                    <th class="text-center ts3"><a href="javascript:void(0)">Plant</a>
                                                    </th>
                                                    <th class="text-center ts4"><a href="javascript:void(0)">Vendor</a>
                                                    </th>
                                                    <th class="text-center ts5"><a href="javascript:void(0)">Last
                                                            Chat</a></th>
                                                    <th class="text-center ts7"><a href="javascript:void(0)">Action</a>
                                                    </th>
                                                </tr>
                                                <tr class="sear1">
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3"
                                                               style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3"
                                                               style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3"
                                                               style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3"
                                                               style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3"
                                                               style="margin: 0px"></th>
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
                    <div role="tabpanel" class="tab-pane" id="negoArchive">
                        <div class="row">
                            <!-- <div class="row"> -->
                            <div id="Invoiced">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="panel-group skrol" id="accordion" role="tablist"
                                         aria-multiselectable="true">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <table id="table_nego_archive" class="table table-striped nowrap"
                                                   width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="text-center ts1"><a
                                                                href="javascript:void(0)">Material</a></th>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">Plant</a>
                                                    </th>
                                                    <th class="text-center ts3"><a href="javascript:void(0)">Vendor</a>
                                                    </th>
                                                    <th class="text-center ts4"><a href="javascript:void(0)">Last
                                                            Chat</a></th>
                                                    <th class="text-center ts5"><a href="javascript:void(0)">Open
                                                            Date</a></th>
                                                    <th class="text-center ts6"><a href="javascript:void(0)">Close
                                                            Date</a></th>
                                                    <th class="text-center ts7"><a href="javascript:void(0)">Action</a>
                                                    </th>
                                                </tr>
                                                <tr class="sear1">
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3"
                                                               style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3"
                                                               style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3"
                                                               style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3"
                                                               style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3"
                                                               style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch3"
                                                               style="margin: 0px"></th>
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
                </div>
            </div>

        </div>
    </div>
</section>


<div class="modal fade" id="modalNego">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong style="font-size: 20px;">Negosiasi </strong>
                <br/>
                <strong>Vendor</strong> : <span id="vendorNego"></span>
                <br/>
                <strong>Material</strong> : <span id="materialNego"></span>
                <br/>
                <strong>Plant</strong> : <span id="plantNego"></span>
            </div>
            <input type="hidden" id="negoidHide"/>
            <input type="hidden" id="plantHide"/>
            <input type="hidden" id="matnoHide"/>
            <input type="hidden" id="vendornoHide"/>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="table_chat" class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center"> Chat</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        <textarea class="col-xs-10" rows="2" placeholder="Enter Your Text Here" id="chatMsg"></textarea>&nbsp;
                        <button type="button" id="sendMsg" title="Send"
                                style="font-size:12px;box-shadow: 1px 1px 1px #ccc" class="btn btn-success"><i
                                    class="glyphicon glyphicon-send"></i>
                        </button>
                        <button type="button" title="Buka Locking Harga"
                                style="font-size:12px;box-shadow: 1px 1px 1px #ccc" class="btn btn-warning"
                                id="openLock"><i class="glyphicon glyphicon-lock"></i>
                        </button>
                    </div>
                    <div class="panel-body text-center">
                        <button type="button" title="Negosiasi Selesai" id="closeNego"
                                style="font-size:12px;box-shadow: 1px 1px 1px #ccc" class="btn btn-danger col-xs-12">
                            Tutup Negosiasi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNegoArchive">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong style="font-size: 20px;">Negosiasi </strong>
                <br/>
                <strong>Vendor</strong> : <span id="vendorNegoArc"></span>
                <br/>
                <strong>Material</strong> : <span id="materialNegoArc"></span>
                <br/>
                <strong>Plant</strong> : <span id="plantNegoArc"></span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="table_chat_archive" class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center"> Chat</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>
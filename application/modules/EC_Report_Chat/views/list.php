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
                <!-- Pane -->
                <div id="Invoiced">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel-group skrol" id="accordion" role="tablist"
                             aria-multiselectable="true">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <table id="table_nego" class="table table-striped nowrap" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center ts1"><a href="javascript:void(0)">Material</a>
                                        </th>
                                        <th class="text-center ts2"><a href="javascript:void(0)">Plant</a></th>
                                        <th class="text-center ts3"><a href="javascript:void(0)">Vendor</a></th>
                                        <th class="text-center ts4"><a href="javascript:void(0)">Last Chat</a>
                                        </th>
                                        <th class="text-center ts5"><a href="javascript:void(0)">Open Date</a>
                                        </th>
                                        <th class="text-center ts6"><a href="javascript:void(0)">Close Date</a>
                                        </th>
                                        <th class="text-center ts7"><a href="javascript:void(0)">Action</a></th>
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
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modalChat">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong style="font-size: 20px;">Negosiasi </strong>
                <br/>
                <strong>Vendor</strong> : <span id="vendorOnChat"></span>
                <br/>
                <strong>Material</strong> : <span id="materialOnChat"></span>
                <br/>
                <strong>Plant</strong> : <span id="plantOnChat"></span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="table_chat" class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center"> Chat</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>
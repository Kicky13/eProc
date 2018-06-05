<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php
            $pesannya = $this->session->flashdata('message');
            if (!empty($pesannya)) {
                echo '<div class="alert alert-info">' . $pesannya . '</div>';
            }
            ?>
            <div class="row">
                <div class="row">
                    <div id="">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                            	<ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation"><a class="tab1" href="#Request" aria-controls="Request" role="tab" data-toggle="tab">BA Request</a></li>
                                    <li role="presentation" class="active"><a class="tab2" href="#Ready" aria-controls="Ready" role="tab" data-toggle="tab">BA Approved</a></li>
                                </ul>

                                <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active" id="Ready">

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="table-responsive">
                                	<table id="datatable_ajax" class="table table-striped nowrap text-center" width="100%" data-urlsource="<?php echo site_url('EC_Approval/Potmut/data/2') ?>">
                                        <thead>
                                                <tr>
                                                    <th class="text-center ts"><a href="javascript:void(0)">NO</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">PO NO</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">PO ITEM NO</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">NO BA</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">PERIODE</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">MATERIAL</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">VENDOR</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">APPROVED AT</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">APPROVED BY</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">ACTION</a></th>

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
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    </div>
                                 </div>
                             	 </div>

                                 <div role="tabpanel" class="tab-pane" id="Request">
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="table-responsive">
                                    <table id="datatable_request" class="table table-striped nowrap text-center" width="100%" data-urlsource="<?php echo site_url('EC_Approval/Potmut/data/1') ?>">
                                        <thead>
                                                <tr>
                                                    <th class="text-center tsr"><a href="javascript:void(0)">NO</a></th>
                                                    <th class="text-center tsr"><a href="javascript:void(0)">PO NO</th>
                                                    <th class="text-center tsr"><a href="javascript:void(0)">PO ITEM NO</th>
                                                    <th class="text-center tsr"><a href="javascript:void(0)">NO BA</th>
                                                    <th class="text-center tsr"><a href="javascript:void(0)">PERIODE</th>
                                                    <th class="text-center tsr"><a href="javascript:void(0)">MATERIAL</th>
                                                    <th class="text-center tsr"><a href="javascript:void(0)">VENDOR</th>
                                                    <th class="text-center tsr"><a href="javascript:void(0)">CREATED AT</th>
                                                    <th class="text-center tsr"><a href="javascript:void(0)">CREATED BY</th>
                                                    <th class="text-center tsr"><a href="javascript:void(0)">STATUS</th>
                                                    <th class="text-center tsr"><a href="javascript:void(0)">ACTION</a></th>

                                                </tr>
                                                <tr class="searr">
                                                    <th></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchr" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchr" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchr" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchr" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchr" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchr" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchr" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchr" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srchr" style="margin: 0px"></th>
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
                </div>
                <br><br>
            </div>
        </div >
    </div >
</section>

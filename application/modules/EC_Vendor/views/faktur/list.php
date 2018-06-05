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
                                <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <div class="col-md-12">
                                            <div id='msg' class='alert alert-info <?php echo !empty($msg) ? "" : "hide"?>' ><?php echo !empty($msg) ? $msg : ""?></div>
                                        
                                                <a href="<?php echo base_url('EC_Vendor/Faktur/ekspedisi') ?>" class="btn btn-info pull-right" style="margin: 0 15px 10px 0;">Ekspedisikan Faktur Pajak</button>
                                        <br></a>
                                        <br>
                                        </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                                    
                                <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active" id="Request">
                                    <table id="datatable_ajax" class="table table-striped nowrap text-center" width="100%" data-urlsource="<?php echo site_url('EC_Vendor/Potmut/data') ?>" data-urlform="<?php echo site_url('EC_Approval/Bapp/detail') ?>">
                                        <thead>
                                                <tr>
                                                    <th class="text-center ts"><a href="javascript:void(0)">NO</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">TANGGAL EKSPEDISI</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">NO EKSPEDISI</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">COMPANY</th>                                                    
                                                    <th class="text-center ts"><a href="javascript:void(0)">ACTION</a></th>

                                                </tr>
                                                <tr class="sear">
                                                    <th></th>
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
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
            </div>
        </div >
    </div >
</section>

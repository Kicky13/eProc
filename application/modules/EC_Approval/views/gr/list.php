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
                                
                                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                    
                                </div>
                                <?php
                                
                                if($levelAcess == 0){
                                    echo "
                                <div class='col-xs-2 col-sm-2 col-md-2 col-lg-2 pull-right'>
                                    <a class='btn btn-warning' href='javascript:void(0)' onClick='createLot()' title='Create Lot'><span class='glyphicon glyphicon-file' aria-hidden='true'> CREATE LOT</span></a>
                                </div>
                                <div class='col-xs-2 col-sm-2 col-md-2 col-lg-2 pull-right'>
                                    <a data-hariini='". date('Ymd'). "' data-href='". base_url('EC_Cronjob/refrshGR_landed') ."' onclick='manualRefreshGR_landed(this); return false' class='btn btn-info'>REFRESH DATA</a>
                                </div>
                                    ";
                                }

                                ?>
                                

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <?php
                                        $id_table = $levelAcess == 0 ? 'datatable_ajax' : 'data_loted';
                                    ?>
                                    <table id="<?php echo $id_table?>" class="table table-striped nowrap text-center" width="100%">
                                        <thead>
                                        <?php 

                                            if($levelAcess == 0 ){
                                                echo '
                                                <tr>
                                                    <th class="text-center ts"><a href="javascript:void(0)">NO</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">PO NO</a></th>                                                    
                                                    <th class="text-center ts"><a href="javascript:void(0)">ITM NO</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">TIPE PO</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">CREATOR BY</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">NO RR</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">DOC DATE</a></th>                                                    
                                                    <th class="text-center ts"><a href="javascript:void(0)">MATERIAL</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">VENDOR</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">ACTION</a></th>

                                                </tr>
                                                <tr class="sear">
                                                    <th></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch dr" readonly style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th></th>
                                                </tr>';
                                            }else{
                                                echo '
                                                <tr>
                                                    <th class="text-center ts"><a href="javascript:void(0)">NO</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">LOT NO</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">PO NO</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">TIPE PO</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">LOT CREATED BY</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">LOT CREATED AT</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">GR YEAR</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">VENDOR</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">ACTION</a></th>

                                                </tr>
                                                <tr class="sear">
                                                    <th><input type="text" class="hide dr"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                </tr>';
                                            }
                                            ?>

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
        </div >
    </div >
</section>

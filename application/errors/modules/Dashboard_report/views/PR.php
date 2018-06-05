<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<section class="content_section">
    <br>
        <div class="content">
            <div class="row">
                <form class="col-md-12" id="filter" name="filter" action="<?php echo base_url('Dashboard_report/PR') ?>" method="POST">
                <div class="panel panel-default">
                    <table class="table table-bordered">
                       
                        <tr>
                            <td>
                            
                            <div class="col-md-6">
                                <div class="col-md-3">
                                <button type="button" class="btn btn-info update_data">Update Data</button>
                                </div>
                                <div class="col-md-4">
                                <select class="form-control select2 opco" placeholder="Pilih OPCO" name="opco[]" multiple >
                                 <option value="2" <?php if(isset($post['opco'])) if(in_array("2",$post['opco'])) echo "selected"; ?>> Semen Gresik</option>
                                 <option value="3" <?php if(isset($post['opco'])) if(in_array("3",$post['opco'])) echo "selected"; ?>> Semen Padang</option>
                                 <option value="4" <?php if(isset($post['opco'])) if(in_array("4",$post['opco'])) echo "selected"; ?>> Semen Tonasa</option>
                                </select>
                                </div>
                                <div class="col-md-5">
                                <select class="form-control select2" id="pgrp" placeholder="Pilih Group Purchasing" name="pgrp[]" multiple >
                                    <?php foreach ($pgrp as $key => $value): ?>
                                        <!-- <option value="<?php echo $value['PURCH_GRP_CODE'] ?>" <?php if(isset($post['pgrp'])) if(in_array($value['PURCH_GRP_CODE'],$post['pgrp'])) echo "selected"; ?>> <?php echo $value['PURCH_GRP_CODE'] ?></option> -->
                                     <?php endforeach ?>
                                     </select>
                                     
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-6">
                                    <select class="form-control select2" placeholder="Pilih Tahun" name="tahun[]" multiple >
                                <?php for ($i = 2009; $i <= Date("Y"); $i++) { ?>
                                    
                                     <option value="<?php echo $i ?>" <?php if(isset($post['tahun'])) if(in_array($i,$post['tahun'])) echo "selected"; ?>> <?php echo $i;?></option>
                                    
                                <?php } ?>
                                </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control select2" placeholder="Pilih Bulan" name="bulan[]" multiple >
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <?php $m = date('m', strtotime("1-$i-2000")); $M = date('M', strtotime("1-$i-2000")); ?>
                                    
                                     <option value="<?php echo $m ?>" <?php if(isset($post['bulan'])) if(in_array($m,$post['bulan'])) echo "selected"; ?>> <?php echo $M ?></option>
                                    
                                <?php endfor ?>
                                </select>
                                </div>
                                <div class="col-md-2">
                                <button type="submit" class="btn btn-success">Search</button>
                                </div>
                                 
                                </div>
                            </td>
                        </tr>
                        <!--tr>
                            <td class="text-center">
                                <button type="submit" class="btn btn-success">Search</button>
                            </td>
                        </tr-->
                    </table>
                </div>
                </form>
                <!-- STYLE FOR CHART style="width: 900px; height: 500px;" -->
                <div class="col-md-6">
                    <div class="well hidden">
                        <ul>
                        <?php foreach ($diffavg as $key => $val): ?>
                            <li><?php echo $key ?>: <span class="reportavg" data-key="<?php echo $key ?>"><?php echo $val ?></span></li>
                        <?php endforeach ?>
                        </ul>
                    </div>
                    <div class="panel panel-default">
                        <!-- <div class="panel-body">
                            <div id="chart_leadtime" style="height: 400px;"></div>
                        </div> -->
                         <div class="panel-body">
                            <div id="chart1d" style="height: 350px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="well hidden">
                        <ul>
                        <?php foreach ($performance as $key => $val): ?>
                            <li><?php echo $key ?>: 
                            <span class="performance" data-key="<?php echo $key ?>">
                                <span class="sub"><?php echo $val['sub'] ?></span>:
                                <span class="total"><?php echo $val['total'] ?></span>
                            </span>
                            </li>
                        <?php endforeach ?>
                        </ul>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div id="chart_performance" style="height: 350px;"></div>

                        </div>
                       
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">Detail</div>
<!-- <div class="panel-group" id="itemAccordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" id="headingOne" role="button" data-toggle="collapse" data-parent="#itemAccordion" href="#itemCollapse" aria-expanded="true" aria-controls="collapseOne">
            <h4 class="panel-title">Detail</h4>
        </div>
        <div id="itemCollapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body"> -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-condensed" id="pr">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>                             
                                        <th class="text-center">Company</th>                     <!-- [COMPANY]         -->
                                        <th class="text-center">PGRP</th>                        <!-- [PPR_PGRP]        -->
                                        <th class="text-center">No PR</th>                       <!-- [PPR_PRNO]        PRC_PURCHASE_REQUISITION-->
                                        <th class="text-center">PR Item</th>                     <!-- [PPI_PRITEM]      PRC_PURCHASE_REQUISITION-->
                                        <th class="text-center">No Mat</th>                      <!-- [PPI_NOMAT]       PRC_PR_ITEM-->
                                        <th class="text-center">Desc</th>                        <!-- [PPI_DECMAT]      PRC_PR_ITEM-->
                                        <th class="text-center">Approval Date</th>               <!-- [APPROVAL]        PRC_PR_ITEM-->
                                        <th class="text-center">Doc Submit Date</th>             <!-- [SUBMIT_DOC]      PRC_PR_ITEM-->
                                        <th class="text-center">No Usulan Pratender</th>         <!-- [SUBPRATENDER]    PRC_TENDER_MAIN-->
                                        <th class="text-center">Usulan Pratender</th>            <!-- [KONFIGURASI]     PRC_TENDER_COMMENT-->
                                        <th class="text-center">No Pratender</th>                <!-- [PRATENDER]       PRC_TENDER_MAIN-->
                                        <th class="text-center">Pratender/RFQ doc date</th>      <!-- [OPENING]         PRC_TENDER_PREP-->
                                        <th class="text-center">Pratender/RFQ created date</th>  <!-- [RFQ_CREATED]     PRC_TENDER_COMMENT-->
                                        <th class="text-center">Quot Deadline</th>               <!-- [CLOSING]         PRC_TENDER_PREP-->
                                        <th class="text-center">Persetujuan Evatek</th>          <!-- [EVATEK_APPROVE]  PRC_TENDER_COMMENT-->
                                        <th class="text-center">Evatek</th>                      <!-- [EVATEK]          PRC_TENDER_COMMENT-->
                                        <th class="text-center">Nego</th>                        <!-- [WIN_AT]          PRC_TENDER_ITEM-->
                                        <th class="text-center">PO Created</th>                  <!-- [PO_CREATED]      PO_HEADER-->
                                        <th class="text-center">PO Released</th>                 <!-- [PO_RELASED]      PO_HEADER-->
                                    </tr>
                                </thead>                                
                            </table>
                        </div>
            <!-- </div>
        </div>
    </div>
</div> -->
                    </div>
                </div>
            </div>
        </div>
</section>
<br><br><br><br><br><br>
<section class="content_section">
  <div class="col-md-offset-2 col-md-10">
    <form class="form form-inline" method="POST">
      <div class="form-group">
        <label class="col-md-2 control-label">Company &nbsp;</label>
        <div class="col-md-10">
          <?php
          foreach($listCompany as $k => $v){
            $checked = in_array($k,$company) ? 'checked' : '';
            echo '<div class="checkbox">
              <label>&nbsp;&nbsp;<input type="checkbox" '.$checked.' name="company[]" value="'.$k.'"> '.$v.'</label>
            </div>';
          }
          ?>
          <button type="submit" class="btn btn-default">Cari</button>
        </div>
      </div>
    </form>
  </div>
    <div class="content_spacer">

        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>

            <div class="row">

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" >
                    <canvas id="Chart"></canvas>
                    <div id="js-legend" class="chart-legend"></div>
                </div>

                <div class="col-lg-6" >
                    <div class="col-lg-12">
                        <table class="table table-striped nowrap" width="100%">
                        <thead>
                            <tr>
                                <td class="text-center" colspan="3">
                                    <h4>Total Data</h4>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center"><strong>Barang</strong></td>
                                <td class="text-center"><strong>Jasa</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>GR/BAPP</strong></td>
                                <td class="text-center"><?php echo isset($Chart[0]['TOTAL']) ? $Chart[0]['TOTAL'] : 0;?></td>
                                <td class="text-center"><?php echo isset($Chart[1]['TOTAL']) ? $Chart[1]['TOTAL'] : 0;?></td>
                            </tr>
                            <tr>
                                <td><strong>GR/BAPP yang diinvoicekan</strong></td>
                                <td class="text-center"><?php echo isset($Inv[0]['JUMLAH']) ? $Inv[0]['JUMLAH'] : 0 ;?></td>
                                <td class="text-center"><?php echo isset($Inv[1]['JUMLAH']) ? $Inv[1]['JUMLAH'] : 0 ;?></td>
                            </tr>
                            <tr>
                                <td><strong>Invoice</strong></td>
                                <td class="text-center"><?php echo isset($Cou[0]['JUMLAH']) ? $Cou[0]['JUMLAH'] : 0 ;?></td>
                                <td class="text-center"><?php echo isset($Cou[1]['JUMLAH']) ? $Cou[1]['JUMLAH'] : 0 ;?></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <div class="col-lg-12">
                        <table class="table table-striped nowrap" width="100%">
                        <thead>
                            <tr>
                                <td class="text-center" colspan="7">
                                    <h4>Status Invoice</h4>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>Total Invoice</strong></td>
                                <td class="text-center"><strong>Draft</strong></td>
                                <td class="text-center"><strong>Submited</strong></td>
                                <td class="text-center"><strong>Approved</strong></td>
                                <td class="text-center"><strong>Rejected</strong></td>
                                <td class="text-center"><strong>Posted</strong></td>
                                <td class="text-center"><strong>Paid</strong></td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <?php
                                    $_jumlah1 = isset($Cou[0]) ? $Cou[0]['JUMLAH'] : 0;
                                    $_jumlah2 = isset($Cou[1]) ? $Cou[1]['JUMLAH'] : 0;
                                    $j_inv =  $_jumlah1 + $_jumlah2;
                                    $data_status = array($j_inv,0,0,0,0,0,0);

                                    for ($i=0; $i < count($Stat) ; $i++) {
                                        if(isset($Stat[$i]['JUMLAH'])){
                                            $data_status[$Stat[$i]['STATUS_HEADER']] = $Stat[$i]['JUMLAH'];
                                        }
                                    }
                                ?>
                                <td class="text-center"><strong><?php echo $data_status[0];?></strong></td>
                                <td class="text-center"><?php echo $data_status[1];?></td>
                                <td class="text-center"><?php echo $data_status[2];?></td>
                                <td class="text-center"><?php echo $data_status[3];?></td>
                                <td class="text-center"><?php echo $data_status[4];?></td>
                                <td class="text-center"><?php echo $data_status[5];?></td>
                                <td class="text-center"><?php echo $data_status[6];?></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="data-chart"
                     data-t_brg="<?php echo isset($Chart[0]['TOTAL']) ? $Chart[0]['TOTAL'] : 0;?>"
                     data-t_jsa="<?php echo isset($Chart[1]['TOTAL']) ? $Chart[1]['TOTAL'] : 0;?>"
                     data-i_brg="<?php echo isset($Cou[0]) ? $Cou[0]['JUMLAH'] : 0;?>"
                     data-i_jsa="<?php echo isset($Cou[1]) ? $Cou[1]['JUMLAH'] : 0;?>">
                    <br/><br/><h4> Data Detail </h4>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div
                            ></div>
                    <table id="table_inv" class="table table-striped nowrap" width="100%">
                        <thead>
                            <tr>
                                <th class="ts0"><a href="javascript:void(0)">No.</th>
                                <th class="ts1"><a href="javascript:void(0)">Vendor</a></th>
                                <th class="ts2"><a href="javascript:void(0)">Jenis</a></th>
                                <th class="ts3"><a href="javascript:void(0)">Jumlah (GR/BAPP)</a></th>
                                <th class="ts4"><a href="javascript:void(0)">Jumlah Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div >
    </div >
</section>

<style>
.chart-legend li span{
    display: inline-block;
    width: 12px;
    height: 12px;
    margin-right: 5px;
}
</style>

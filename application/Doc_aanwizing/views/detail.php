<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <form method="post" action="<?php echo base_url() ?>Proc_verify_entry/save_bidding" enctype="multipart/form-data">
                <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_number ?>">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $detail_ptm_snip ?>
                        <!-- <div class="panel panel-default">
                            <div class="panel-body">
                                <a href="<?php echo base_url('Proc_ubah_tanggal/index/'.$ptm_number) ?>">Update Tanggal Pengadaan</a>
                            </div>
                        </div> -->
                        <?php echo $dokumen_pr ?>
                        <?php echo $vendor_ptm ?>
                        <?php if($ptm['MASTER_ID'] >= 9){
                            echo $evaluasi ;
                        } ?>
                        <?php
                         if ($evaluasi_harga) { ?>
                            <?php if($ptp_r['PTP_IS_ITEMIZE'] == 1) { ?>
                            <?php if($this->session->userdata('GRPAKSES') == 42||$this->session->userdata('GRPAKSES') == 281) {?>
                                    <td></td>
                            <?php }else { ?>
                                    <?php foreach ($tit as $item){ ?>
                                    <div class="panel-group">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="button" data-toggle="collapse" href="#clps" aria-expanded="true">
                                                Evaluasi atas material <strong><?php echo $item['PPI_DECMAT'] ?></strong>
                                            </div>
                                            <div class="panel-collapse collapse in">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-bordered" >
                                                        <thead>
                                                            <th></th>
                                                            <th class="col-md-2 text-center"><strong>HPS</strong></th>
                                                            <?php 
                                                            if(isset($pqi[$item['TIT_ID']])){
                                                                foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                                <th class="text-center"><strong><?php echo $ptv[$key]['VENDOR_NAME'] ?></strong></th>
                                                            <?php } 
                                                            } ?>
                                                        </thead>
                                                        <tbody class="table_evaluasi_harga">
                                                            <tr class="harga">
                                                                <td>Harga Satuan</td>
                                                                <td class="active text-center"><?php echo number_format($item['TIT_PRICE']) ?></td>
                                                                <?php
                                                                if(isset($pqi[$item['TIT_ID']])){
                                                                    $x = array();
                                                                    foreach($pqi[$item['TIT_ID']] as $ky => $val) {
                                                                        $x[$ky] = $pqi[$item['TIT_ID']][$ky]['PQI_PRICE'];
                                                                    }  
                                                                    asort($x);
                                                                    $ur=1;
                                                                    foreach ($x as $k => $val) {
                                                                        if($ur == 1){
                                                                            $terkecil[$item['TIT_ID']][$k]=$val;
                                                                        }
                                                                        $ur++;
                                                                    }

                                                                    foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                                        <td class="text-center <?php 
                                                                            $bg = '';
                                                                            if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > floatval($item['TIT_PRICE']) ){ 
                                                                                $bg = "bg-danger";  
                                                                            }
                                                                            if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) <= floatval($item['TIT_PRICE']) && isset($terkecil[$item['TIT_ID']][$key]) ){
                                                                                $bg = "bg-info";
                                                                            }
                                                                            echo $bg;
                                                                        ?>"
                                                                            style="<?php
                                                                                if($thp2smpl2 && !$pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                                                    echo "background-color:#D2CDCD";
                                                                                }
                                                                            ?>" 
                                                                        >

                                                                        <input type="hidden" class="harga_vnd" value="<?php echo $pqi[$item['TIT_ID']][$key]['PQI_PRICE'] ?>" data-vnd="<?php echo $key ?>">

                                                                        <?php 
                                                                            if(($thp2smpl2 && !$pqi[$item['TIT_ID']][$key]['LULUS_TECH']) || ($thp2smpl2 && $pqi[$item['TIT_ID']][$key]['PTV_STATUS_EVAL']==1)){
                                                                                echo "";
                                                                            }else {
                                                                                echo number_format($pqi[$item['TIT_ID']][$key]['PQI_PRICE']);
                                                                            }
                                                                        ?>
                                                                        </td>
                                                                    <?php else: ?>
                                                                        <td>-</td>
                                                                    <?php endif ?>
                                                                <?php } 
                                                                } ?>
                                                            </tr>
                                                            <tr class="totalharga">
                                                                <td class="warnung">Qty (<?php echo $item['PPI_UOM']; ?>)</td>
                                                                <td class="active text-center"><?php echo $item['TIT_QUANTITY']; ?></td>
                                                                <?php 
                                                                if(isset($pqi[$item['TIT_ID']])) {
                                                                    foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                                        <td class="text-center <?php if (floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY']) < floatval($item['TIT_QUANTITY'])): echo "bg-warning"; endif; ?>"
                                                                            style="<?php
                                                                                if($thp2smpl2 && !$pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                                                    echo "background-color:#D2CDCD";
                                                                                }
                                                                            ?>" 
                                                                        >

                                                                        <?php echo $pqi[$item['TIT_ID']][$key]['PQI_QTY']; ?>
                                                                        </td>
                                                                    <?php else: ?>
                                                                        <td>-</td>
                                                                    <?php endif ?>
                                                                <?php } 
                                                                } ?>
                                                            </tr>
                                                            <tr class="totalharga">
                                                                <td class="warnung">Harga Total</td>
                                                                <td class="active text-center"><?php echo number_format($item['TIT_PRICE'] * $item['TIT_QUANTITY']) ?></td>
                                                                <?php 
                                                                if(isset($pqi[$item['TIT_ID']])) {
                                                                    foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                                        <td class="text-center">

                                                                        <?php 
                                                                            if($thp2smpl2 && !$pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                                                echo "";
                                                                            } else{
                                                                                echo number_format($pqi[$item['TIT_ID']][$key]['PQI_PRICE'] * $pqi[$item['TIT_ID']][$key]['PQI_QTY']);
                                                                            }
                                                                       ?>
                                                                        </td>
                                                                    <?php else: ?>
                                                                        <td>-</td>
                                                                    <?php endif ?>
                                                                <?php } 
                                                                } ?>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <?php }else { ?>
                            <?php if($this->session->userdata('GRPAKSES') == 42||$this->session->userdata('GRPAKSES') == 281) {?>
                                    <td></td>
                            <?php }else { ?>
                            <div class="panel-group">
                                <div class="panel panel-default">                                
                                    <div class="panel-heading" role="button" data-toggle="collapse" href="#clps" aria-expanded="true">
                                        <h4 class="panel-title">
                                            Evaluasi Harga
                                        </h4>
                                    </div>
                                    <div id="clps" class="panel-collapse collapse in">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                    <th class="col-md-2 text-center"><strong>Item</strong></th>
                                                    <th class="col-md-2 text-center"><strong>Price</strong></th>
                                                    <th class="col-md-2 text-center"><strong>Qty</strong></th>
                                                    <th class="col-md-2 text-center"><strong>UoM</strong></th>
                                                    <th class="col-md-2 text-center"><strong>Net Price</strong></th>
                                                    <?php 
                                                    if(isset($pqi[$tit[0]['TIT_ID']])) {
                                                        foreach ($pqi[$tit[0]['TIT_ID']] as $key => $value) {?>
                                                        <th nowrap colspan="2" class="text-center"><strong><?php echo $ptv[$key]['VENDOR_NAME'] ?></strong></th>
                                                    <?php } 
                                                    } ?>
                                                </thead>
                                                <tbody class="table_evaluasi_harga">
                                                    <?php  $total = array(); ?>
                                                        <?php 
                                                        if(isset($pqi[$tit[0]['TIT_ID']])) {
                                                            foreach ($pqi[$tit[0]['TIT_ID']] as $key => $value) {
                                                                $total[$key] = 0;
                                                            }
                                                        }?>
                                                    <?php foreach ($tit as $item): ?>
                                                    <tr class="harga">
                                                        <td nowrap><strong><?php echo $item['PPI_DECMAT'] ?></strong></td>
                                                        <td><?php echo number_format($item['TIT_PRICE']) ?></td>
                                                        <td><?php echo $item['TIT_QUANTITY'] ?></td>
                                                        <td class="text-center"><?php echo $item['PPI_UOM'] ?></td>
                                                        <td class="text-right"><?php echo number_format($item['TIT_PRICE'] * $item['TIT_QUANTITY']) ?></td>
                                                        <?php 
                                                        if(isset($pqi[$item['TIT_ID']])) {
                                                            $x = array();
                                                            foreach($pqi[$item['TIT_ID']] as $ky => $val) {
                                                                if($thp2smpl2){
                                                                    if($val['PTV_STATUS_EVAL']==2){
                                                                        $x[$ky] = $pqi[$item['TIT_ID']][$ky]['PQI_PRICE'];
                                                                    }
                                                                }else{
                                                                    $x[$ky] = $pqi[$item['TIT_ID']][$ky]['PQI_PRICE'];
                                                                }
                                                            }  
                                                            asort($x);
                                                            $ur=1;
                                                            foreach ($x as $k => $val) {
                                                                if($ur == 1){
                                                                    $terkecil[$item['TIT_ID']][$k]=$val;
                                                                }
                                                                $ur++;
                                                            }

                                                            foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                            <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                                <td class="text-center <?php if (floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY']) < floatval($item['TIT_QUANTITY'])): echo "bg-warning"; endif; ?>">
                                                                    <?php echo floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY']); ?>
                                                                </td>
                                                                <!-- <td class="text-right <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']): echo "bg-success";  else: echo "bg-danger"; endif ?>"> -->
                                                                <td class="text-right <?php 
                                                                    $bg = '';
                                                                    if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > floatval($item['TIT_PRICE']) ){ 
                                                                        $bg = "bg-danger";  
                                                                    }
                                                                    if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) <= floatval($item['TIT_PRICE']) && isset($terkecil[$item['TIT_ID']][$key]) ){
                                                                        $bg = "bg-info";
                                                                    }
                                                                    echo $bg;
                                                                ?>" style="<?php
                                                                    if($thp2smpl2 && $pqi[$item['TIT_ID']][$key]['PTV_STATUS_EVAL']==1){
                                                                        echo "background-color:#D2CDCD";
                                                                    }
                                                                ?>">
                                                                    <?php 
                                                                    if($thp2smpl2 && $pqi[$item['TIT_ID']][$key]['PTV_STATUS_EVAL']==1){
                                                                        echo "";
                                                                    }else{
                                                                        echo number_format(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE'])); 
                                                                    }
                                                                    ?>
                                                                    <?php $tot = floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) * floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY']); ?>
                                                                    <?php $total[$key] = floatval($total[$key]) + (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) * floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY'])); ?>
                                                                </td>
                                                            <?php else: ?>
                                                                <td>-</td>
                                                            <?php endif ?>
                                                        <?php } 
                                                        } ?>
                                                    </tr>
                                                    <?php endforeach ?>
                                                    <tr class="totalharga">
                                                        <td colspan="5" class="warnung">Total</td>
                                                        <?php 
                                                        if(isset($pqi[$item['TIT_ID']])) {
                                                            foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                            <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                                <td colspan="2" class="text-center">
                                                                    <input type="hidden" class="harga_vnd" value="<?php echo $total[$key] ?>" data-vnd="<?php echo $key ?>">
                                                                    <?php 
                                                                        if($thp2smpl2 && $pqi[$item['TIT_ID']][$key]['PTV_STATUS_EVAL']==1){
                                                                            echo "";
                                                                        }else{
                                                                            echo number_format($total[$key]) ;
                                                                        }
                                                                    ?>
                                                                </td>
                                                            <?php else: ?>
                                                                <td>-</td>
                                                            <?php endif ?>
                                                        <?php } 
                                                        } ?>
                                                    </tr>                                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php } ?>
                        <?php } ?>
                        <?php //echo $this->snippet->assignment($ptm_number) ?>
                        <div id="history_pesan">
                            <?php echo $pesan; ?>
                        </div>
                        <?php echo $ptm_comment ?>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <a href="<?php echo base_url('Monitoring_prc') ?>" class="main_button color7 small_btn">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
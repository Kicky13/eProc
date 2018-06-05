<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <form name="quotation-form" id="quotation-form" method="post" action="<?php echo base_url() ?>Penentuan_lolos/save_bidding" class="submit">
            <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_number; ?>">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
                        </div>
                    <?php endif ?>
                    <?php echo $detail_ptm ?>
                    <?php echo $vendor_ptm ?>
                    <?php
                         if ($evaluasi_harga) { ?>
                            <?php if($ptp_r['PTP_IS_ITEMIZE'] == 1) { ?>
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
                                                                foreach ($pqi[$item['TIT_ID']] as $key => $value) {
                                                                    if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']) {
                                                                        if ($ptp_r['PTP_EVALUATION_METHOD'] != '2 Tahap 2 Sampul') { //nyo 27022017
                                                                            if ($ptv[$key]['PTV_STATUS'] == '2') {
                                                                                echo '<th class="text-center"><strong>'.$ptv[$key]['VENDOR_NAME'].'</strong></th>';
                                                                            } 
                                                                        } else { 
                                                                            if ($ptv[$key]['PTV_STATUS_EVAL'] == '2') {
                                                                                 echo '<th class="text-center"><strong>'.$ptv[$key]['VENDOR_NAME'].'</strong></th>';
                                                                            } 
                                                                        } 
                                                                    }
                                                                } 
                                                            } ?>
                                                                             
                                                        </thead>
                                                        <tbody class="table_evaluasi_harga">
                                                            <tr class="harga">
                                                                <td>Harga Satuan</td>
                                                                <td class="active text-center"><?php echo number_format($item['TIT_PRICE']) ?></td>
                                                                <?php
                                                                if(isset($pqi[$item['TIT_ID']])){
                                                                    // $x = array();
                                                                    // foreach($pqi[$item['TIT_ID']] as $ky => $val) {
                                                                    //     $x[$ky] = $pqi[$item['TIT_ID']][$ky]['PQI_PRICE'];
                                                                    // }  
                                                                    // asort($x);
                                                                    // $ur=1;
                                                                    // foreach ($x as $k => $val) {
                                                                    //     if($ur == 1){
                                                                    //         $terkecil[$item['TIT_ID']][$k]=$val;
                                                                    //     }
                                                                    //     $ur++;
                                                                    // }

                                                                    /* Cari PQI dengan harga yang paling rendah */ 
                                                                    $price = null;
                                                                    $pqi_id = null;
                                                                    foreach ($pqi[$item['TIT_ID']] as $key => $value) {
                                                                        if($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                                            if (isset($pqi[$item['TIT_ID']][$key])){

                                                                                if ($price == null) {
                                                                                    $price = floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']);
                                                                                    $pqi_id = $pqi[$item['TIT_ID']][$key]['PQI_ID'];
                                                                                }

                                                                                if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) <= floatval($item['TIT_PRICE']) ){
                                                                                    if ($price > floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) && floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                                        $price = floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']);
                                                                                        $pqi_id = $pqi[$item['TIT_ID']][$key]['PQI_ID'];
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    /* end search low PQI. e/nyo 01032017*/

                                                                    foreach ($pqi[$item['TIT_ID']] as $key => $value) {

                                                                    $ptp_cek = false;
                                                                    $ptp_sts = false;
                                                                    if ($ptp_r['PTP_EVALUATION_METHOD'] != '2 Tahap 2 Sampul') {
                                                                        $ptp_cek = $ptp_r['PTP_EVALUATION_METHOD'] != '2 Tahap 2 Sampul';
                                                                        $ptp_sts = $ptv[$key]['PTV_STATUS'];
                                                                    } else {
                                                                        $ptp_cek = $ptp_r['PTP_EVALUATION_METHOD'] == '2 Tahap 2 Sampul';
                                                                        $ptp_sts = $ptv[$key]['PTV_STATUS_EVAL'];
                                                                    }

                                                                        if ($ptp_cek) { 
                                                                            if ($ptp_sts == '2') {
                                                                                if($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){

                                                                                if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                                                <td class="text-center <?php 
                                                                                    $bg = '';
                                                                                    if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > floatval($item['TIT_PRICE']) ){ 
                                                                                        $bg = "bg-danger";  
                                                                                    }

                                                                                    if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) <= floatval($item['TIT_PRICE'])){
                                                                                       if ($pqi_id == $pqi[$item['TIT_ID']][$key]['PQI_ID']) {
                                                                                            $bg = "bg-info";
                                                                                       }
                                                                                        
                                                                                    }
                                                                                    echo $bg;
                                                                                ?>">

                                                                                <input type="hidden" class="harga_vnd" value="<?php echo $pqi[$item['TIT_ID']][$key]['PQI_PRICE'] ?>" data-vnd="<?php echo $key ?>">

                                                                                <?php echo number_format($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) ?>
                                                                                </td>
                                                                            <?php else: ?>
                                                                                <td>-</td>
                                                                            <?php endif ?>
                                                                <?php  } } } }
                                                                } ?>
                                                            </tr>
                                                            <tr class="totalharga">
                                                                <td class="warnung">Qty (<?php echo $item['PPI_UOM']; ?>)</td>
                                                                <td class="active text-center"><?php echo $item['TIT_QUANTITY']; ?></td>
                                                                <?php 

                                                                    if(isset($pqi[$item['TIT_ID']])) {
                                                                        foreach ($pqi[$item['TIT_ID']] as $key => $value) {
                                                                            if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']) {
                                                                                if ($ptp_r['PTP_EVALUATION_METHOD'] != '2 Tahap 2 Sampul') { 
                                                                                    if ($ptv[$key]['PTV_STATUS'] == '2') {
                                                                                        if (isset($pqi[$item['TIT_ID']][$key])){ ?>
                                                                                            <td class="text-center <?php if (floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY']) < floatval($item['TIT_QUANTITY'])): echo "bg-warning"; endif; ?>">
                                                                                                <?php echo $pqi[$item['TIT_ID']][$key]['PQI_QTY']; ?>
                                                                                            </td>
                                                                <?php                   }
                                                                                    }
                                                                                } else {
                                                                                    if ($ptv[$key]['PTV_STATUS_EVAL'] == '2') {
                                                                                        if (isset($pqi[$item['TIT_ID']][$key])){ ?>
                                                                                            <td class="text-center <?php if (floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY']) < floatval($item['TIT_QUANTITY'])): echo "bg-warning"; endif; ?>">
                                                                                                <?php echo $pqi[$item['TIT_ID']][$key]['PQI_QTY']; ?>
                                                                                            </td>
                                                                <?php                   }
                                                                                    }
                                                                                }
                                                                            }
                                                                        } 
                                                                    }
                                                                ?>
                                                            </tr>
                                                            <tr class="totalharga">
                                                                <td class="warnung">Harga Total</td>
                                                                <td class="active text-center"><?php echo number_format($item['TIT_PRICE'] * $item['TIT_QUANTITY']) ?></td>
                                                                <?php 
                                                                    if(isset($pqi[$item['TIT_ID']])) {
                                                                        foreach ($pqi[$item['TIT_ID']] as $key => $value) {
                                                                            if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']) {
                                                                                if ($ptp_r['PTP_EVALUATION_METHOD'] != '2 Tahap 2 Sampul') { 
                                                                                    if ($ptv[$key]['PTV_STATUS'] == '2') {
                                                                                        if (isset($pqi[$item['TIT_ID']][$key])){ ?>
                                                                                            <td class="text-center">
                                                                                            <?php echo number_format($pqi[$item['TIT_ID']][$key]['PQI_PRICE'] * $pqi[$item['TIT_ID']][$key]['PQI_QTY']) ?>
                                                                                        </td>
                                                                <?php                   } 
                                                                                    }
                                                                                } else{
                                                                                    if ($ptv[$key]['PTV_STATUS_EVAL'] == '2') {
                                                                                        if (isset($pqi[$item['TIT_ID']][$key])){ ?>
                                                                                            <td class="text-center">
                                                                                            <?php echo number_format($pqi[$item['TIT_ID']][$key]['PQI_PRICE'] * $pqi[$item['TIT_ID']][$key]['PQI_QTY']) ?>
                                                                                        </td>
                                                                <?php                   } 
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    } 
                                                                ?>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
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
                                                    if(isset($pqi[$tit[0]['TIT_ID']])){
                                                        foreach ($pqi[$tit[0]['TIT_ID']] as $key => $value) {
                                                            if ($pqi[$tit[0]['TIT_ID']][$key]['LULUS_TECH']) {
                                                                if ($ptp_r['PTP_EVALUATION_METHOD'] != '2 Tahap 2 Sampul') { 
                                                                    if ($ptv[$key]['PTV_STATUS'] == '2') {
                                                                        echo '<th class="text-center" nowrap colspan="2"><strong>'.$ptv[$key]['VENDOR_NAME'].'</strong></th>';
                                                                    } 
                                                                } else { 
                                                                    if ($ptv[$key]['PTV_STATUS_EVAL'] == '2' || $ptv[$key]['PTV_STATUS_EVAL'] == '1') {
                                                                         echo '<th class="text-center" nowrap colspan="2"><strong>'.$ptv[$key]['VENDOR_NAME'].'</strong></th>';
                                                                    } 
                                                                } 
                                                            }
                                                        } 
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
                                                            // $x = array();
                                                            // foreach($pqi[$item['TIT_ID']] as $ky => $val) {
                                                            //     $x[$ky] = $pqi[$item['TIT_ID']][$ky]['PQI_PRICE'];
                                                            // }  
                                                            // asort($x);
                                                            // $ur=1;
                                                            // foreach ($x as $k => $val) {
                                                            //     if($ur == 1){
                                                            //         $terkecil[$item['TIT_ID']][$k]=$val;
                                                            //     }
                                                            //     $ur++;
                                                            // }

                                                            /* Cari PQI dengan harga yang paling rendah */ 
                                                            $price = null;
                                                            $pqi_id = null;
                                                            foreach ($pqi[$item['TIT_ID']] as $key => $value) {
                                                                if($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                                    if (isset($pqi[$item['TIT_ID']][$key])){

                                                                        if ($price == null) {
                                                                            $price = floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']);
                                                                            $pqi_id = $pqi[$item['TIT_ID']][$key]['PQI_ID'];
                                                                        }

                                                                        if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) <= floatval($item['TIT_PRICE']) ){
                                                                            if ($price > floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) && floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                                $price = floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']);
                                                                                $pqi_id = $pqi[$item['TIT_ID']][$key]['PQI_ID'];
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            /* end search low PQI. e/nyo 01032017*/

                                                            foreach ($pqi[$item['TIT_ID']] as $key => $value) {
                                                            $ptp_cek = false;
                                                            $ptp_sts = false;
                                                            if ($ptp_r['PTP_EVALUATION_METHOD'] != '2 Tahap 2 Sampul') {
                                                                $ptp_cek = $ptp_r['PTP_EVALUATION_METHOD'] != '2 Tahap 2 Sampul';
                                                                $ptp_sts = $ptv[$key]['PTV_STATUS'];
                                                            } else {
                                                                $ptp_cek = $ptp_r['PTP_EVALUATION_METHOD'] == '2 Tahap 2 Sampul';
                                                                $ptp_sts = $ptv[$key]['PTV_STATUS_EVAL'];
                                                            }

                                                            if ($ptp_cek) { 
                                                                if ($ptp_sts) {
                                                                    if($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){

                                                                        if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                                        <td class="text-center <?php if (floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY']) < floatval($item['TIT_QUANTITY'])): echo "bg-warning"; endif; ?>">
                                                                            <?php echo floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY']); ?>
                                                                        </td>

                                                                        <td class="text-right <?php 
                                                                            $bg = '';
                                                                            if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > floatval($item['TIT_PRICE']) ){ 
                                                                                $bg = "bg-danger";  
                                                                            }

                                                                            if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) <= 0){ 
                                                                                $bg = "bg-warning";  
                                                                            }

                                                                            if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) <= floatval($item['TIT_PRICE'])){
                                                                               if ($pqi_id == $pqi[$item['TIT_ID']][$key]['PQI_ID']) {
                                                                                    $bg = "bg-info";
                                                                               }
                                                                                
                                                                            }
                                                                            echo $bg;
                                                                        ?>">
                                                                            <?php echo number_format(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE'])); ?>
                                                                            <?php $tot = floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) * floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY']); ?>
                                                                            <?php $total[$key] = floatval($total[$key]) + (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) * floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY'])); ?>
                                                                        </td>
                                                                    <?php else: ?>
                                                                        <td>-</td>
                                                                    <?php endif ?>
                                                            <?php } 
                                                        } } }
                                                        } ?>
                                                    </tr>
                                                    <?php endforeach ?>
                                                    <tr class="totalharga">
                                                        <td colspan="5" class="warnung">Total</td>
                                                        <?php 
                                                            if(isset($pqi[$item['TIT_ID']])) {
                                                                foreach ($pqi[$item['TIT_ID']] as $key => $value) {
                                                                    if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']) {
                                                                        if ($ptp_r['PTP_EVALUATION_METHOD'] != '2 Tahap 2 Sampul') { 
                                                                            if ($ptv[$key]['PTV_STATUS'] == '2') {
                                                                                if (isset($pqi[$item['TIT_ID']][$key])){ ?>
                                                                                    <td class="text-center" nowrap colspan="2">
                                                                                    <?php echo number_format($pqi[$item['TIT_ID']][$key]['PQI_PRICE'] * $pqi[$item['TIT_ID']][$key]['PQI_QTY']) ?>
                                                                                </td>
                                                        <?php                   } 
                                                                            }
                                                                        } else{
                                                                            if ($ptv[$key]['PTV_STATUS_EVAL'] == '2' || $ptv[$key]['PTV_STATUS_EVAL'] == '1') {
                                                                                if (isset($pqi[$item['TIT_ID']][$key])){ ?>
                                                                                    <td class="text-center <?php if($ptv[$key]['PTV_STATUS_EVAL'] == '1'): echo $bg = "bg-warning"; endif; ?>" nowrap colspan="2">
                                                                                    <?php echo number_format($pqi[$item['TIT_ID']][$key]['PQI_PRICE'] * $pqi[$item['TIT_ID']][$key]['PQI_QTY']) ?>
                                                                                </td>
                                                        <?php                   } 
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            } 
                                                        ?>
                                                    </tr>                                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        <?php } ?>
                    <?php echo $evaluasi ?>
                    <?php echo $this->snippet->assignment($ptm_number) ?>
                    <div id="history_pesan">
                        <?php echo $pesan; ?>
                    </div>
                    <?php echo $ptm_comment ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Komentar Anda</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-3">Komentar</td>
                                    <td class="col-md-1 text-right">:</td>
                                    <td><textarea maxlength="1000" class="form-control" name ="ptc_comment" id="ptc_comment" /></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <select name="next_process" id="next_process" class="harusmilih_publicjs">
                                <option value="false_public"></option>
                                <!-- <option value="1">Lanjut ke Selanjutnya</option> -->
                                <!-- update 26 mei 2016 -->
                                <option value="1">Lanjut ke Pemilihan Metode Nego</option>
                                <option value="0">Retender</option>
                                <option value="999">Batal</option>
                            </select>
                            <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                            <button type="submit" id="submit_button" class="formsubmit main_button color7 small_btn milihtombol_publicjs" disabled>OK</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</section>

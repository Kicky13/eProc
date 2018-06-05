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
                        <?php if($ptm['PTM_STATUS'] >= 13){
                            echo $evaluasi ;
                        } ?>
                        <?php if ($ptp_r['PTP_IS_ITEMIZE'] != null && (($ptp_r['PTP_EVALUATION_METHOD'] == '1 Tahap 1 Sampul' && ($ptm['PTM_STATUS'] > 8 || $ptm['PTM_STATUS'] == 8 && $name_process == 'Verifikasi Penawaran') ) || ($ptp_r['PTP_EVALUATION_METHOD'] == '2 Tahap 1 Sampul' &&  $ptm['PTM_STATUS'] >= 13) || ($ptp_r['PTP_EVALUATION_METHOD'] == '2 Tahap 2 Sampul' &&  $ptm['PTM_STATUS'] >= 15)) ) { ?>
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
                                                                foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                                <th class="text-center <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']): echo "bg-success";  else: echo "bg-danger"; endif ?>"><strong><?php echo $ptv[$key]['VENDOR_NAME'] ?></strong></th>
                                                            <?php } 
                                                            } ?>
                                                        </thead>
                                                        <tbody class="table_evaluasi_harga">
                                                            <tr class="harga">
                                                                <td>Harga</td>
                                                                <td class="active text-right"><?php echo number_format($item['TIT_PRICE']) ?></td>
                                                                <?php
                                                                if(isset($pqi[$item['TIT_ID']])){
                                                                    foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                                        <td class="text-center <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']): echo "bg-success";  else: echo "bg-danger"; endif ?>">

                                                                        <input type="hidden" class="harga_vnd" value="<?php echo $pqi[$item['TIT_ID']][$key]['PQI_PRICE'] ?>" data-vnd="<?php echo $key ?>">

                                                                        <?php echo number_format($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) ?>
                                                                        </td>
                                                                    <?php else: ?>
                                                                        <td>-</td>
                                                                    <?php endif ?>
                                                                <?php } 
                                                                } ?>
                                                            </tr>
                                                            <tr class="totalharga">
                                                                <td class="warnung">Total Harga (<?php echo $item['TIT_QUANTITY'].' '.$item['PPI_UOM'] ?>)</td>
                                                                <td class="active text-right"><?php echo number_format($item['TIT_PRICE'] * $item['TIT_QUANTITY']) ?></td>
                                                                <?php 
                                                                if(isset($pqi[$item['TIT_ID']])) {
                                                                    foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                                        <td class="text-center <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']): echo "bg-success";  else: echo "bg-danger"; endif ?>">

                                                                        <?php echo number_format($pqi[$item['TIT_ID']][$key]['PQI_PRICE'] * $item['TIT_QUANTITY']) ?>
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
                                                        <th nowrap class="text-center <?php if ($pqi[$tit[0]['TIT_ID']][$key]['LULUS_TECH']): echo "bg-success";  else: echo "bg-danger"; endif ?>"><strong><?php echo $ptv[$key]['VENDOR_NAME'] ?></strong></th>
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
                                                            foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                            <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                                <td class="text-right <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']): echo "bg-success";  else: echo "bg-danger"; endif ?>">

                                                                <?php echo number_format(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) * floatval($item['TIT_QUANTITY'])) ?>
                                                                <?php $tot = (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) * floatval($item['TIT_QUANTITY'])); ?>
                                                                <?php $total[$key] = floatval($total[$key]) + (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) * floatval($item['TIT_QUANTITY'])); ?>
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
                                                                <td class="text-right <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']): echo "bg-success";  else: echo "bg-danger"; endif ?>">
                                                                    <input type="hidden" class="harga_vnd" value="<?php echo $total[$key] ?>" data-vnd="<?php echo $key ?>">
                                                                <?php echo number_format($total[$key]) ?>
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
                        <?php echo $this->snippet->assignment($ptm_number) ?><?php echo $ptm_comment ?>
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
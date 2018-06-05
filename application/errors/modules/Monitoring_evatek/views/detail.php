<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $evaluator ?>
                        <?php echo $evaluasi ?>
                        <?php echo $vendor_ptm ?>
                        <?php foreach ($tit as $item): ?>
                        <div class="panel panel-success">
                            <div class="panel-heading">Evaluasi atas material <strong><?php echo $item['PPI_DECMAT'] ?></strong></div>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="col-md-2"><strong>Evaluasi Teknis</strong></th>
                                            <?php foreach ($ptv as $vnd): ?>
                                                <th><strong><?php echo $vnd['VENDOR_NAME'] ?></strong></th>
                                            <?php endforeach ?>
                                        </tr>
                                        <tr>
                                            <td><strong>Spesifikasi</strong></td>
                                            <?php foreach ($ptv as $vnd): ?>
                                                <td class="text-top">
                                                <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                                                    <?php $thispqi = $pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']]; ?>
                                                    <small><?php echo nl2br($thispqi['PQI_DESCRIPTION']) ?></small>
                                                <?php endif ?>
                                                </td>
                                            <?php endforeach ?>
                                        </tr>
                                        <tr>
                                            <td><strong>Qty (<?php echo $item['PPI_UOM']; ?>)</strong></td>
                                            <?php foreach ($ptv as $vnd): ?>
                                                <td class="text-top">
                                                    <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                                                        <?php $thispqi = $pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']]; ?>
                                                        <?php echo $thispqi['PQI_QTY'] ?>                                
                                                    <?php endif ?>
                                                </td>
                                            <?php endforeach ?>
                                        </tr>
                                        <tr>
                                            <td><strong>Delivery Time</strong></td>
                                            <?php foreach ($ptv as $vnd): ?>
                                                <td class="text-top">
                                                <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                                                    <?php $thispqi = $pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']]; ?>
                                                    <?php echo $thispqi['PQM_DELIVERY_TIME'] ?>
                                                    <?php switch ($thispqi['PQM_DELIVERY_UNIT']) {
                                                        case '1': echo 'Hari'; break;
                                                        case '3': echo 'Minggu'; break;
                                                        case '2': echo 'Bulan'; break;
                                                    } ?>
                                                <?php endif ?>
                                                </td>
                                            <?php endforeach ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(isset($ppd2[$item['TIT_ID']])): ?>
                                        <?php $no=1; foreach($ppd2[$item['TIT_ID']] as $pp): ?>
                                            <tr class="active">
                                                <td>
                                                    <?php echo $pp['ET_NAME'] ?>
                                                    (<span class="weight"><?php echo $pp['ET_WEIGHT'] ?></span>%)
                                                </td>
                                                <?php foreach ($ptv as $vnd): ?>
                                                    <td>
                                                        <?php if (isset($det[$item['TIT_ID']][$pp['ET_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                                                        <?php $val = $det[$item['TIT_ID']][$pp['ET_ID']][$vnd['PTV_VENDOR_CODE']]['DET_TECH_VAL']; ?>
                                                            Total = <span class="det_span"><?php echo $val ?></span>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                                 <?php if(!empty($pef[$vnd['PTV_VENDOR_CODE']]) && $no == 1){ ?>
                                                                    <a href="<?php echo base_url('Quotation'); ?>/viewDok/<?php echo $pef[$vnd['PTV_VENDOR_CODE']]; ?>" target="_blank" title="Download attachment">
                                                                        <i class="glyphicon glyphicon-file"></i>
                                                                    </a>
                                                                <?php } else if($no == 1){ ?>
                                                                    <i class="glyphicon glyphicon-file" title="Tidak ada file"></i>
                                                                <?php } ?>
                                                        <?php endif ?>
                                                    </td>
                                                <?php endforeach; $no++; ?>
                                            </tr>

                                            <?php foreach ($peu[$pp['ET_ID']][$item['TIT_ID']] as $pptu): ?>
                                                <tr>
                                                    <?php
                                                        $pptu_weight = '<span class="weight_detail"></span>';
                                                        if(!empty($pptu['EU_WEIGHT'])) {       
                                                        $pptu_weight = '&nbsp;&nbsp;(<span class="weight_detail" style="color:black">'.$pptu['EU_WEIGHT'].'</span>%)';
                                                        }
                                                    ?>
                                                    <td><?php echo $pptu['EU_NAME'].'&nbsp;&nbsp;'.$pptu_weight ?></td>
                                                    <?php foreach ($ptv as $vnd): ?>
                                                        <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                                                            <?php 
                                                                $val_det = 0;
                                                                if (isset($peu2[$pp['ET_ID']][$item['TIT_ID']][$pptu['EU_NAME']])){
                                                                    foreach ($peu2[$pp['ET_ID']][$item['TIT_ID']][$pptu['EU_NAME']] as $v) {
                                                                        if(isset($deu[$item['TIT_ID']][$pp['ET_ID']][$vnd['PTV_VENDOR_CODE']][$v['EU_ID']])){
                                                                            $va = $deu[$item['TIT_ID']][$pp['ET_ID']][$vnd['PTV_VENDOR_CODE']][$v['EU_ID']]; 
                                                                            $val_det = $va['DEU_TECH_VAL'];
                                                                            
                                                                            $deunya = $deu[$item['TIT_ID']][$pp['ET_ID']][$vnd['PTV_VENDOR_CODE']][$v['EU_ID']]['DEU_ID'];
                                                                        }
                                                                    }
                                                                } 
                                                            ?>
                                                            <td>
                                                                <?php echo $val_det; ?>
                                                            </td>
                                                        <?php else: ?>
                                                            <td></td>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                </tr>
                                            <?php endforeach; ?>                                            
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                        <tr class="danger">
                                            <td>Pass Grade</td>
                                            <?php foreach ($vendor_data as $vnd): ?>
                                                <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                                                    <td>
                                                        <?php echo $vnd['EVT_PASSING_GRADE'] ?>
                                                    </td>
                                                <?php else: ?>
                                                    <td></td>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="info">
                                            <td>Total Nilai</td>
                                            <?php foreach ($ptv as $vnd): ?>
                                                <td>
                                                    <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                                                        <?php $pqii = $pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']]; ?>
                                                        Total = <span class="span_tech"><?php echo $pqii['PQI_TECH_VAL'] == '' ? 0 : $pqii['PQI_TECH_VAL'] ?></span>
                                                    <?php endif ?>
                                                </td>
                                            <?php endforeach ?>
                                        </tr>
                                        <tr class="info">
                                            <td>Catatan</td>
                                            <?php foreach ($ptv as $vnd): ?>
                                                <td>
                                                    <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                                                       <?php echo $pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_NOTE']; ?>
                                                    <?php endif ?>
                                                </td>
                                            <?php endforeach ?>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <?php endforeach ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">Tambahan Dokumen Evaluasi</div>
                            <table class="table">
                                <tr title="Dokumen Evatek">
                                    <td class="col-md-1"></td>
                                    <td class="divfiles">
                                        <?php if (count($dokumentambahan) <= 0): ?>
                                            Tidak ada dokumen tambahan.
                                        <?php else: ?>
                                        <?php foreach ($dokumentambahan as $key => $value): ?>
                                            <a href="<?php echo base_url('Monitoring_prc'); ?>/viewDok/<?php echo $value['FILE']; ?>" target="_blank"><span class="glyphicon glyphicon-file"></span> <?php echo $value['NAME'] == '' ? $value['FILE'] : $value['NAME'] ?></a><br>
                                        <?php endforeach ?>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php echo $pesan; ?>
                        <?php echo $ptm_comment ?>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <a href="<?php echo base_url('Monitoring_evatek') ?>" class="main_button color7 small_btn">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
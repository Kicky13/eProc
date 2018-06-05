<?php foreach ($tit as $item): ?>
    <div class="panel panel-success" data-tit="<?php echo $item['TIT_ID'] ?>">
        <div class="panel-heading">Evaluasi atas material <strong><?php echo $item['PPI_DECMAT'] ?></strong></div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="item-evaluasi-template">
                <thead>
                    <tr>
                        <th class="col-md-2"><strong>Evaluasi Teknis</strong></th>
                        <?php foreach ($ptv as $vnd): ?>
                            <th><strong><?php echo $vnd['VENDOR_NAME'] ?></strong></th>
                        <?php endforeach ?>
                    </tr>
                    <tr>
                        <td>
                            <span class="nomat hidden"><?php echo $item['PPI_NOMAT'] ?></span>
                            <span class="ppi hidden"><?php echo $item['PPI_ID'] ?></span>
                            <strong>Spesifikasi PR<br></strong>
                            <?php echo $item['longtext'][0] ?>
                        </td>
                        <?php foreach ($ptv as $vnd): ?>
                            <td class="text-top">
                                <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                                    <?php $thispqi = $pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']]; ?>
                                    <small><?php echo nl2br($thispqi['PQI_DESCRIPTION']) ?></small>&nbsp;
                                    <?php if(!empty($pef[$vnd['PTV_VENDOR_CODE']][$item['TIT_ID']])): ?>
                                        <a href="<?php echo base_url('Quotation'); ?>/viewDok/<?php echo $pef[$vnd['PTV_VENDOR_CODE']][$item['TIT_ID']]; ?>" target="_blank" title="Download attachment">
                                            <i class="glyphicon glyphicon-file"></i>
                                        </a>
                                    <?php else: ?>
                                        <i class="glyphicon glyphicon-file" title="Tidak ada attachment"></i>
                                    <?php endif ?>
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

                    <?php foreach ($ptd as $val) { ?>
                    <tr class="active new_temp ex_temp">
                        <td>
                            <?php echo $val['PPD_ITEM'] ?>
                            (<span class="weight"><?php echo $val['PPD_WEIGHT']; ?></span>%)
                            <input type="hidden" name="et_name[]" value="<?php echo $val['PPD_ITEM']?>">
                            <input type="hidden" name="et_weight[]" value="<?php echo $val['PPD_WEIGHT']?>">
                            <input type="hidden" name="ppd_id[]" value="<?php echo $val['PPD_ID']?>">
                            <input type="hidden" name="et_tit_id[]" value="<?php echo $item['TIT_ID']?>">
                        </td>
                        <?php foreach ($ptv as $vnd) { ?>
                        <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])){ ?>
                        <td>
                            Total = <span class="det_span">0</span>
                            <input type="hidden" class="det_val" name="det[<?php echo $vnd['PTV_VENDOR_CODE'].']['.$item['TIT_ID'].']['.$val['PPD_ID'] ?>][]">
                            <input type="hidden" class="det_vnd" name="det_vnd[]" value="<?php echo $vnd['PTV_VENDOR_CODE'] ?>">
                            <input type="hidden" class="det_tit" value="<?php echo $item['TIT_ID'] ?>">
                            <input type="hidden" class="det_ppd_id" value="<?php echo $val['PPD_ID'] ?>">
                        </td>
                        <?php } else { ?>
                        <td></td>
                        <?php } ?>
                        <?php } ?>
                    </tr>
                    <?php foreach ($uraian[$val['PPD_ID']] as $pptu) { ?>
                    <?php 
                    $checked='';
                    if(!empty($pptu['PPTU_WEIGHT']) && $val['PPD_MODE']==1) { 
                        $cek = 'hidden';             
                        $checked='checked';
                        $pptu_weight = '&nbsp;&nbsp;(<span class="weight_detail" style="color:black">'.$pptu['PPTU_WEIGHT'].'</span>%)';
                        $eu_weight = $pptu['PPTU_WEIGHT'];
                        ?>
                        <?php } else{ $cek=''; $pptu_weight = '<span class="weight_detail"></span>'; $eu_weight = '';} ?>
                        <tr class="<?php echo $checked==''?'danger':'' ?>" style="display:none;">
                            <td>         

                                <input type="checkbox" class="<?php echo $cek; ?>" <?php echo $checked ?>  onclick="cekaktifdeufunction(this)" name="template_uraian[<?php echo $item['TIT_ID'].']['.$val['PPD_ID']?>][]" value="<?php echo $pptu['PPTU_ID'] ?>">&nbsp;<?php echo $pptu['PPTU_ITEM'].$pptu_weight; ?>
                                <input type="hidden" name="eu_weight<?php echo '['.$item['TIT_ID'].']' ?>[]" value="<?php echo $eu_weight;?>">
                                <input type="hidden" name="eu_item[]" value="<?php echo $pptu['PPTU_ITEM'];?>">
                            </td>
                            <?php foreach ($ptv as $vnd) { ?>
                            <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])){ ?>
                            <td>
                                <input type="text" class="<?php echo $checked==''?'deu_valse':'deu_val' ?>" onkeypress="return angka(event)" onkeyup="hitungTotal(this)" name="deu[<?php echo $vnd['PTV_VENDOR_CODE'].']['.$item['TIT_ID'].']['.$val['PPD_ID'].']['.$pptu['PPTU_ID'].'][]'?>" <?php echo $checked==''?'disabled':'' ?>>
                                <input type="hidden" name="deu_name[]" value="<?php echo $pptu['PPTU_ITEM'] ?>">
                                <input type="hidden" class="deu_vnd" value="<?php echo $vnd['PTV_VENDOR_CODE'] ?>">
                                <input type="hidden" class="deu_id_pptu" value="<?php echo $pptu['PPTU_ID'] ?>">
                                <input type="hidden" class="deu_tit" value="<?php echo $item['TIT_ID']; ?>">
                                <input type="hidden" class="deu_ppd_id" value="<?php echo $val['PPD_ID'] ?>">
                            </td>
                            <?php } else { ?>
                            <td></td>
                            <?php } ?>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                        <tr class="danger new_temp">
                            <td>Pass Grade</td>
                            <?php foreach ($ptv as $vnd): ?>
                                <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                                    <td>
                                        <?php echo $pet[0]['EVT_PASSING_GRADE'] ?>
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
                                        <input type="hidden" class="inpt_tech" name="total[<?php echo $pqii['PQI_ID'] ?>]">
                                        <input type="hidden" class="tech_vnd" value="<?php echo $vnd['PTV_VENDOR_CODE'] ?>">
                                        <input type="hidden" class="tech_tit" value="<?php echo $item['TIT_ID'] ?>">
                                    <?php endif ?>
                                </td>
                            <?php endforeach ?>
                        </tr>
                        <tr class="info">
                            <td>Catatan</td>
                            <?php foreach ($ptv as $vnd): ?>
                                <td>
                                    <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                                        <?php $pqii = $pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']]; ?>
                                        <textarea name="pqi_note[<?php echo $pqii['PQI_ID'] ?>]"><?php echo $pqii['PQI_NOTE']; ?></textarea>
                                    <?php endif ?>
                                </td>
                            <?php endforeach ?>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    <?php endforeach ?>            

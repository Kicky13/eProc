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
                    <td><strong>Spesifikasi</strong></td>
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
              	<?php foreach ($ptd as $val): ?>
                    <tr class="active eva_col ex_eva">
                        <td>                    			
                            <?php 
                            	if (isset($ppd2[$val['PPD_ID']][$item['TIT_ID']])){
                            		$item_prnt = $ppd2[$val['PPD_ID']][$item['TIT_ID']]['ET_NAME'];
                            		$wg_prnt = $ppd2[$val['PPD_ID']][$item['TIT_ID']]['ET_WEIGHT'];
                            		$et_id = $ppd2[$val['PPD_ID']][$item['TIT_ID']]['ET_ID'];
                            	}else{
                            		$item_prnt = $val['PPD_ITEM'] ;
                            		$wg_prnt = $val['PPD_WEIGHT'];
                            		$et_id = 0;
                            	}
                            ?>                        		
                            <?php echo $item_prnt ?>
                            (<span class="weight"><?php echo $wg_prnt; ?></span>%)
                            <input type="hidden" name="et_name[]" value="<?php echo $item_prnt?>">
                            <input type="hidden" name="et_weight[]" value="<?php echo $wg_prnt?>">
                            <input type="hidden" name="ppd_id[]" value="<?php echo $val['PPD_ID']?>">
                            <input type="hidden" name="et_tit_id[]" value="<?php echo $item['TIT_ID']?>">
                        </td>
                        <?php foreach ($ptv as $vnd): ?>
                            <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                                <td>
                                	<?php 
                                		$valPrnt = 0;
                                		if (isset($det[$item['TIT_ID']][$et_id][$vnd['PTV_VENDOR_CODE']])){
                                			$valPrnt = $det[$item['TIT_ID']][$et_id][$vnd['PTV_VENDOR_CODE']]['DET_TECH_VAL'];
                                		}
                                	?>
                                    Total = <span class="det_span"><?php echo $valPrnt ?></span>
                                    <input type="hidden" class="det_val" name="det[<?php echo $vnd['PTV_VENDOR_CODE'].']['.$item['TIT_ID'].']['.$val['PPD_ID'] ?>][]" value="<?php echo $valPrnt ?>">
                                    <input type="hidden" class="det_vnd" value="<?php echo $vnd['PTV_VENDOR_CODE'] ?>">
                                    <input type="hidden" class="det_tit" value="<?php echo $item['TIT_ID'] ?>">
                                    <input type="hidden" class="det_ppd_id" value="<?php echo $val['PPD_ID'] ?>">
                                </td>
                            <?php else: ?>
                                <td></td>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </tr>
                    <?php foreach ($uraian[$val['PPD_ID']] as $pptu): ?>
    	                <tr>
    	                    <td>                                     

            <?php if (isset($peu[$et_id][$item['TIT_ID']][$pptu['PPTU_ITEM']])){
                    $item_child = $peu[$et_id][$item['TIT_ID']][$pptu['PPTU_ITEM']]['EU_NAME'];
                    $cheked = 'checked';
                    $eu_weight_dtl = $peu[$et_id][$item['TIT_ID']][$pptu['PPTU_ITEM']]['EU_WEIGHT'];
                }else{
                    $item_child = $pptu['PPTU_ITEM'];
                    $cheked = '';
                    $eu_weight_dtl = $pptu['PPTU_WEIGHT'];
                } 
            ?>
            <?php //var_dump($peu[$et_id][$item['TIT_ID']]); ?>
            <?php if(!empty($pptu['PPTU_WEIGHT']) && $val['PPD_MODE']==1) { 
                $cek = 'hidden';  
                $cheked = 'checked';           
                $pptu_weight = '&nbsp;&nbsp;(<span class="weight_detail" style="color:black">'.$eu_weight_dtl.'</span>%)';
            ?>
            <?php } else{ $cek=''; $pptu_weight = '<span class="weight_detail"></span>';} ?>
    	                        <input type="checkbox" <?php echo $cheked ?> class="cekaktifdeu <?php echo $cek ?>" onclick="cekaktifdeufunction(this)" name="template_uraian[<?php echo $item['TIT_ID'].']['.$val['PPD_ID']?>][]" value="<?php echo $pptu['PPTU_ID'] ?>">&nbsp;<?php echo $item_child.$pptu_weight; ?>
                                <!-- <input type="text" name="eu_weight[]" value="<?php //echo ;?>"> -->
                                <input type="hidden" name="eu_weight<?php echo '['.$item['TIT_ID'].']' ?>[]" value="<?php echo $pptu['PPTU_WEIGHT'];?>">
                                <input type="hidden" name="eu_item[]" value="<?php echo $pptu['PPTU_ITEM'];?>">
    	                    </td>
    	                    <?php foreach ($ptv as $vnd): ?>
                                <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                                    <?php 
                                        $val_det = 0;
                                        if (isset($peu[$et_id][$item['TIT_ID']][$pptu['PPTU_ITEM']])){
                                            foreach ($peu2[$et_id][$item['TIT_ID']][$pptu['PPTU_ITEM']] as $v) {
                                                if(isset($deu[$item['TIT_ID']][$et_id][$vnd['PTV_VENDOR_CODE']][$v['EU_ID']])){
                                                    $va = $deu[$item['TIT_ID']][$et_id][$vnd['PTV_VENDOR_CODE']][$v['EU_ID']]; 
                                                    $val_det = $va['DEU_TECH_VAL'];
                                                }
                                            }
                                        } 
                                    ?>
        	                        <td>
        	                            <input type="text" class="deu_val" onkeypress="return angka(event)" onkeyup="hitungTotal(this)" name="deu[<?php echo $vnd['PTV_VENDOR_CODE'].']['.$item['TIT_ID'].']['.$val['PPD_ID'].']['.$pptu['PPTU_ID'].'][]'?>" value="<?php echo $val_det ?>">
        	                            <input type="hidden" name="deu_name[]" value="<?php echo $pptu['PPTU_ITEM'] ?>">
        	                            <input type="hidden" class="deu_vnd" value="<?php echo $vnd['PTV_VENDOR_CODE'] ?>">
        	                            <input type="hidden" class="deu_id_pptu" value="<?php echo $pptu['PPTU_ID'] ?>">
        	                            <input type="hidden" class="deu_tit" value="<?php echo $item['TIT_ID']; ?>">
        	                            <input type="hidden" class="deu_ppd_id" value="<?php echo $val['PPD_ID'] ?>">
        	                        </td>
                                <?php else: ?>
                                    <td></td>
                                <?php endif ?>
    	                    <?php endforeach; ?>
    	                </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <tr class="danger eva_col">
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
                        <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                            <td>
                                <?php if (isset($pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']])): ?>
                                    <?php $pqii = $pqi[$item['TIT_ID']][$vnd['PTV_VENDOR_CODE']]; ?>
                                    Total = <span class="span_tech"><?php echo $pqii['PQI_TECH_VAL'] == '' ? 0 : $pqii['PQI_TECH_VAL'] ?></span>
                                    <input type="hidden" class="inpt_tech" name="total[<?php echo $pqii['PQI_ID'] ?>]" value="<?php echo $pqii['PQI_TECH_VAL']; ?>">
                                <input type="hidden" class="tech_vnd" value="<?php echo $vnd['PTV_VENDOR_CODE'] ?>">
                                <input type="hidden" class="tech_tit" value="<?php echo $item['TIT_ID'] ?>">
                                <?php endif ?>
                            </td>
                        <?php else: ?>
                            <td></td>
                        <?php endif ?>
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
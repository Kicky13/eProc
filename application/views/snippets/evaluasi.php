<?php
 if (!$table_only): ?>
<?php if ($show_harga): ?>
<?php if ($ptp['EVT_TYPE'] == '4' && $ptm['MASTER_ID'] >= 13): ?> <!-- khusus tonasa -->
<div class="panel panel-default">
    <div class="panel-heading">
        Rekap Evaluasi Sebelum Interchange
    </div>
    <div class="table-responsive">
        <table class="table">
            <?php $no = 1; foreach ($tits_b as $tit): ?>
                <?php if (count($tit['ptv_b']) <= 0) { continue; } ?>
                <tr>
                    <td rowspan="<?php echo count($ptqi[$tit['TIT_ID']])-1 ?>"><?php echo $tit['PPI_DECMAT'] ?><?php if ($show_harga): ?><br>ECE: <?php echo number_format($tit['TIT_PRICE']) ?><?php endif ?></td>
                    <td><strong>Vendor</strong></td>
                    <td class="text-center" title=""><strong>Nilai Teknis</strong></td>
                    <td class="text-center" title="Passing Grade Evatek"><strong>Pass Grade</strong></td>
                    <td class="text-center" title="Lulus evaluasi teknis"><strong>Lulus Teknis</strong></td>
                    <?php if ($show_harga): ?>
                    <td class="text-center" title=""><strong>Nilai harga</strong></td>
                    <td class="text-center" title="Bobot Teknis:Bobot Harga"><strong>Nilai Bobot</strong></td>
                    <td class="text-center" title="Nilai perhitungan menggunakan bobot"><strong>Nilai total</strong></td>
                    <!-- <td class="text-center" title="Harga penawaran"><strong>Penawaran</strong></td> -->
                    <?php endif ?>
                    <td class="text-center" title=""><strong>Peringkat</strong></td>
                    <!-- <td class="text-center" title="File evaluasi teknis"><strong>Att. Teknis</strong></td> -->
                </tr>
                <?php $peringkat = 1; foreach ($tit['ptv_b'] as $val): ?>
                <?php if (isset($ptqi[$tit['TIT_ID']][$val['PTV_VENDOR_CODE']])): $thisptqi = $ptqi[$tit['TIT_ID']][$val['PTV_VENDOR_CODE']]; ?>
                <tr class="<?php echo $thisptqi['LULUS_TECH'] ? '' : 'danger' ?>">
                    <td nowrap title="VendorNo=<?php echo $val['PTV_VENDOR_CODE'] ?>, RFQ=<?php echo $val['PTV_RFQ_NO'] ?>">
                        <?php echo $val['VENDOR_NAME'] ?>
                    </td>
                    <td class="text-center"><?php echo intval($thisptqi['PQI_TECH_VAL']) ?></td>
                    <td class="text-center"><?php echo $ptp['EVT_PASSING_GRADE'] ?></td>
                    <td class="text-center"><?php echo $thisptqi['LULUS_TECH'] ? 'Lulus' : 'Tidak' ?></td>
                    <?php if ($show_harga): ?>
                    <td class="text-center"><?php echo intval($thisptqi['PQI_PRICE_VAL']) ?></td>
                    <td class="text-center"><?php echo $thisptqi['EVT_TECH_WEIGHT_B'].' : '.$thisptqi['EVT_PRICE_WEIGHT_B'] ?></td>
                    <td class="text-center"><?php echo $thisptqi['NILAI_TOTAL_B']/100 ?></td>
                    <!-- <td class="text-center"><?php echo $thisptqi['EVT_TECH_WEIGHT_B'].' : '.$thisptqi['EVT_PRICE_WEIGHT_B'] ?></td>
                    <td class="text-center"><?php echo $thisptqi['NILAI_TOTAL_B']/100 ?></td>
                    <td class="text-center"><?php echo number_format($thisptqi['PQI_PRICE']) ?></td> -->
                    <?php endif ?>
                    <td class="text-center"><?php echo $thisptqi['LULUS_TECH'] ? $peringkat++ : '-'; ?></td>
                    <!-- <td class="text-center"><a href="#!">Attachment</a></td> -->
                </tr>
                <?php endif ?>
                <?php endforeach ?>
            <?php $no++; endforeach ?>
        </table>
    </div>
</div>
<?php endif ?>
<?php endif ?>

<div class="panel panel-default">
    <?php if (!$table_only): ?>
    <div class="panel-heading">
        <?php if ($input): ?>
        Centang untuk pilih vendor yang lolos ke tahap selanjutnya
        <?php else: ?>
        Rekap Evaluasi Berdasarkan <?php echo ($ptp['PTP_JUSTIFICATION_ORI']!=5)?$ptp['EVT_TYPE_NAME']:''; ?>
        <?php endif ?>
    </div>
    <?php endif ?>
<?php endif ?>
<?php if($view_order == 'item_per_vendor' || $view_order == 'both'):?>
    <div class="table-responsive">        
        <table class="table">
            <?php //var_dump($tits);?>
            <?php
                /*menyimpan peringkat setiap vendor per item*/
                // echo '<pre>';var_dump($tits);echo '<pre>';
                $pakai_nego=false;
                foreach($ptv as $vendor){
                    $sum_nilai[$vendor['PTV_VENDOR_CODE']]=0;
                    $count_item[$vendor['PTV_VENDOR_CODE']]=0;
                    $sum_penawaran[$vendor['PTV_VENDOR_CODE']]=0;
                    $sum_nego[$vendor['PTV_VENDOR_CODE']]=0;                    
                    foreach ($tits as $tit) {                    
                        if (isset($ptqi[$tit['TIT_ID']][$vendor['PTV_VENDOR_CODE']])&&$ptqi[$tit['TIT_ID']][$vendor['PTV_VENDOR_CODE']]['LULUS_TECH']){
                            $thisptqi = $ptqi[$tit['TIT_ID']][$vendor['PTV_VENDOR_CODE']];
                            $sum_nilai[$vendor['PTV_VENDOR_CODE']]+=($thisptqi['NILAI_TOTAL']/100);
                            $count_item[$vendor['PTV_VENDOR_CODE']]++;
                            if($ptp['EVT_TYPE']==5){
                                if(isset($thisptqi['PQI_FINAL_PRICE'])){
                                    $pakai_nego=true;
                                    $sum_nego[$vendor['PTV_VENDOR_CODE']]+=$thisptqi['PQI_FINAL_PRICE'];
                                }else{
                                    $sum_penawaran[$vendor['PTV_VENDOR_CODE']]+=$thisptqi['PQI_PRICE'];
                                }
                                
                            }
                        }
                    }                    
                    if($count_item[$vendor['PTV_VENDOR_CODE']]>0){
                        $avg_nilai[$vendor['PTV_VENDOR_CODE']]=$sum_nilai[$vendor['PTV_VENDOR_CODE']]/$count_item[$vendor['PTV_VENDOR_CODE']];
                        $jum_penawaran[$vendor['PTV_VENDOR_CODE']]=$sum_penawaran[$vendor['PTV_VENDOR_CODE']];
                        $jum_nego[$vendor['PTV_VENDOR_CODE']]=$sum_nego[$vendor['PTV_VENDOR_CODE']];
                    }
                    
                }
                // var_dump($ptp['EVT_TYPE']);
                // var_dump($avg_nilai);
                if($ptp['EVT_TYPE']==5){
                    if($pakai_nego){
                        $jum_penawaran=$jum_nego;
                    }
                    asort($jum_penawaran);
                    $rangking=array();
                    $urut=1;
                    foreach ($jum_penawaran as $key => $value) {
                        $rangking[$key]=$urut;
                        $urut++;
                    }
                }else{
                    if(isset($avg_nilai)){
                        arsort($avg_nilai);
                        $rangking=array();
                        $urut=1;
                        foreach ($avg_nilai as $key => $value) {
                            $rangking[$key]=$urut;
                            $urut++;
                        }
                    }
                }
                                
                
                /*mengubah kolom menjadi baris $ptqi*/
                // var_dump($ptqi);
                $ptqi_t=array();    
                $peringkat=array();              
                foreach ($ptqi as $key_tit => $value) {  
                    foreach ($value as $key_vnd => $val) {
                        $ptqi_t[$key_vnd][$key_tit]=$val;                        
                        $peringkat[$key_vnd][$key_tit]=isset($rangking[$key_vnd])?$rangking[$key_vnd]:'';                        
                        
                    }
                    
                }
                
                foreach ($tit['ptv'] as $vendor){
                    if ($vendor['PTV_STATUS'] == 2 && isset($ptqi_t[$vendor['PTV_VENDOR_CODE']])){
                        $ptvnya[$peringkat[$vendor['PTV_VENDOR_CODE']][$tit['TIT_ID']]] = $vendor;
                    }
                }
                $hasil1 = array();
                for ($i=1; $i < count($ptvnya)+1; $i++) {
                    if(isset($ptvnya[$i]['pqi']['LULUS_TECH'])){
                        $hasil1[] = $ptvnya[$i]; 
                    }
                }
                $hasilUrutan = $hasil1;                
            ?>        
            <?php $no = 1; foreach ($tit['ptv'] as $vendor): ?> 
            <?php if ($vendor['PTV_STATUS'] == 2):?>           
            <?php if (isset($ptqi_t[$vendor['PTV_VENDOR_CODE']])):  ?>
                <tr class="vendor">
                    <td class="hidden">
                        <!-- <input class="evaluasi_tit_id" value="<?php //echo $tit['TIT_ID'] ?>"> -->
                    </td>
                                 
                    <td rowspan="<?php echo count($tits)+1 ?>">
                        <?php if ($input): ?>                 
                        <?php foreach ($ptqi_t[$vendor['PTV_VENDOR_CODE']] as $value) {
                            $pqm_id=$value['PQM_ID'];
                        }?>
                        <input type="checkbox" class="cek_snippet_eval_with_input cek_vendor" name="lanjut[<?php echo $vendor['PTV_VENDOR_CODE'] ?>][<?php echo $pqm_id ?>]" value="<?php echo $vendor['PTV_VENDOR_CODE'] ?>" >
                        <?php endif ?>
                       <?php echo $vendor['VENDOR_NAME']; ?>
                    </td>
                    <td><strong>Item</strong></td>
                    <td class="text-center" title=""><strong>Nilai Teknis</strong></td>
                    <td class="text-center" title="Passing Grade Evatek"><strong>Pass Grade</strong></td>
                    <td class="text-center" title="Lulus evaluasi teknis"><strong>Lulus Teknis</strong></td>
                    <?php if ($show_harga):  $tot_nilai=0;?>
                    <td class="text-center" title=""><strong>Nilai harga</strong></td>
                    <td class="text-center" title="Bobot Teknis:Bobot Harga"><strong>Nilai Bobot</strong></td>
                    <td class="text-center" title="Nilai perhitungan menggunakan bobot"><strong>Nilai total</strong></td>
                    <?php if($batas_penawaran){ $tot_penawaran=0;?>
                    <td class="text-center" title="Harga penawaran"><strong>Penawaran</strong></td>
                    <?php } 
                    if ($show_nego): $tot_nego=0; $tot_prosen=0;?>
                        <td class="text-center" title=""><strong>Nilai ECE</strong></td>
                        <td class="text-center" title=""><strong>Nilai Penawaran</strong></td>
                    <td class="text-center" title="Harga nego"><strong>Nego</strong></td>
                    <td class="text-center" title="((nego-ece)/ece)*100%"><strong>Prosentase</strong></td>
                    <?php endif ?>
                    <?php endif ?>
                    <td class="text-center" title=""><strong>Peringkat</strong></td>
                </tr>
                <?php endif ?>
                <?php foreach ($tits as $tit): ?>
                <?php if (isset($ptqi[$tit['TIT_ID']][$vendor['PTV_VENDOR_CODE']])): $thisptqi = $ptqi[$tit['TIT_ID']][$vendor['PTV_VENDOR_CODE']]; ?>
                <?php ?>
                <tr class="<?php echo $thisptqi['LULUS_TECH'] ? '' : 'danger' ?> <?php echo empty($thisptqi['PQI_PRICE_VAL'])?'warning':'';?>">
                    <td>                        
                        <?php if ($input): ?>
                            <?php if ($lulus_evatek_aja): ?>
                                <?php if ($populate): ?>
                                <?php $is_checked = $thisptqi['LULUS_TECH'] ? '' : 'disabled' ?>
                                <?php $is_checked .= $thisptqi['DAPAT_UNDANGAN'] == 1 ? ' checked' : '' ?>
                                <?php else: ?>
                                <?php $is_checked = $thisptqi['LULUS_TECH'] ? 'checked' : 'disabled' ?>
                                <?php endif ?>
                            <?php else: ?>
                            <?php $is_checked = $thisptqi['LULUS_TECH'] && intval($thisptqi['PQI_PRICE_VAL']) > 0 ? 'checked' : 'disabled' ?>
                            <?php endif ?>  
                            <input type="checkbox" class="cek_snippet_eval_with_input cek_item hidden" name="lanjut[<?php echo $tit['TIT_ID'] ?>][<?php echo $thisptqi['PQI_ID'] ?>]" value="<?php echo $vendor['PTV_VENDOR_CODE'] ?>" <?php echo $is_checked ?> data-tit="<?php echo $tit['TIT_ID'] ?>">
                        <?php endif ?>

                        <?php echo $tit['PPI_DECMAT'] ?>
                        <?php if ($show_harga): ?>
                            <br>
                            ECE: <?php echo number_format($tit['TIT_PRICE']) ?>
                            <br>
                            <?php echo $tit['PPI_PRNO'].' | '.$tit['PPI_PRITEM']; ?>
                        <?php endif ?>
                    </td>
                     <td class="text-center"><?php echo intval($thisptqi['PQI_TECH_VAL']) ?></td>
                    <td class="text-center"><?php echo $ptp['EVT_PASSING_GRADE'] ?></td>
                    <td class="text-center lulus_tech"><?php echo $thisptqi['LULUS_TECH'] ? 'Lulus' : 'Tidak' ?></td>
                    <?php if ($show_harga): ?>
                    <td class="text-center pqi_tech_val_n"><?php echo intval($thisptqi['PQI_PRICE_VAL']) ?></td>
                    <td class="text-center"><?php echo $thisptqi['EVT_TECH_WEIGHT'].' : '.$thisptqi['EVT_PRICE_WEIGHT'] ?></td>
                    <td class="text-center"><?php echo $thisptqi['NILAI_TOTAL']/100; $tot_nilai+=($thisptqi['NILAI_TOTAL']/100); ?></td>
                    <?php $price_status = $thisptqi['PQI_PRICE'] > $tit['TIT_PRICE'] ? 'danger' : ($ptqi[$tit['TIT_ID']]['WIN'] == $vendor['PTV_VENDOR_CODE'] ? 'info' : '') ?>
                    <?php if($batas_penawaran){ ?>
                    <td class="text-center <?php echo $price_status ?>"><?php echo number_format($thisptqi['PQI_PRICE']); $tot_penawaran+=$thisptqi['PQI_PRICE']; ?></td>
                    <?php } 
                    if ($show_nego): ?>
                        <?php $price_status = $thisptqi['PQI_FINAL_PRICE'] == 0 || $thisptqi['PQI_FINAL_PRICE'] > $tit['TIT_PRICE'] ? 'danger' : ($ptqi[$tit['TIT_ID']]['FINALWIN'] == $vendor['PTV_VENDOR_CODE'] ? 'info' : '') ?>
                        <td class="text-center"><?php echo number_format($tit['TIT_PRICE']) ?></td>
                        <td class="text-center"><?php echo number_format($thisptqi['PQI_PRICE']) ?></td>
                        <td class="text-center <?php echo $price_status ?>"><?php echo number_format($thisptqi['PQI_FINAL_PRICE']); $tot_nego+=$thisptqi['PQI_FINAL_PRICE']; ?></td>
                        <?php
                            $prosen = (($thisptqi['PQI_FINAL_PRICE']-$tit['TIT_PRICE'])/$tit['TIT_PRICE'])*100;
                        ?>
                        <td class="text-center"><?php echo number_format($prosen); $tot_prosen+=$prosen; ?></td>
                    <?php endif ?>
                    <?php endif ?>
                    <td class="text-center"><?php echo ($thisptqi['LULUS_TECH'] && !empty($thisptqi['PQI_PRICE_VAL']))?$peringkat[$vendor['PTV_VENDOR_CODE']][$tit['TIT_ID']]:'-'; ?></td>
                </tr>                
                    <?php endif ?>
                <?php endforeach ?>
                 <?php if (isset($ptqi_t[$vendor['PTV_VENDOR_CODE']])):  ?>
                <tr>
                    <td class="text-right bold" colspan="7">Total</td>
                    <td class="text-center bold"><?php echo ($show_harga)?number_format($tot_nilai/(count($tits))):'';?></td>
                    <?php if($batas_penawaran): ?>
                        <td class="text-center bold"><?php echo number_format($tot_penawaran);?></td>
                    <?php endif ?>
                    <td class="text-center bold"><?php echo ($show_nego)?number_format($tot_nego):''; ?></td>
                    <td class="text-center bold"><?php echo ($show_nego)?round($tot_prosen/count($tits),2):''; ?></td>
                    <td></td>
                </tr>
                <?php endif ?>
                <?php endif ?>
            <?php $no++; endforeach ?>
        </table>
        <script type="text/javascript">
        /*javascript tambahan untuk handle checkbox vendor*/
        
        $('.cek_item').each(function(){
             if($(this).is(":checked")){   
                var checkbox=$(this).parent().parent().prev().children().next().find('input');
                checkbox.prop('checked','true');
                // console.log(checkbox.html());           
            }
        });  

        </script>
    </div>
<?php endif ?>
<?php if($view_order == 'vendor_per_item' || $view_order == 'both'):?>
    <div class="table-responsive">
        <table class="table">
            <?php $no = 1; foreach ($tits as $tit): ?>
                <?php if (count($tit['ptv']) <= 0) { continue; } ?>
                <tr>
                    <td class="hidden">
                        <input class="evaluasi_tit_id" value="<?php echo $tit['TIT_ID'] ?>">
                    </td>
                    <td rowspan="<?php echo ($ptp['PTP_IS_ITEMIZE']==1)?count($ptqi[$tit['TIT_ID']])-1 : count($ptqi[$tit['TIT_ID']])-1; ?>">
                        <?php echo $tit['PPI_DECMAT'] ?>
                        <?php if ($show_harga): ?>
                            <br>
                            ECE: <?php echo number_format($tit['TIT_PRICE']) ?>
                            <br>
                            <?php echo $tit['PPI_PRNO'].' | '.$tit['PPI_PRITEM']; ?>
                        <?php endif ?>
                        <br><br>

                       <?php 
                            $ada =0;
                            $kalimat = base_url(uri_string());
                            if(preg_match("/Evaluasi_penawaran/i", $kalimat)) {
                              $ada = 1;
                            } 
                        if ($ptp['EVT_TYPE'] == '4' && $ada==1): //Ipnutan Nilai Bobot di disable ?> <!-- khusus tonasa -->
                        <!-- <div>
                            Nilai Bobot                            
                                <input type="text" style="width:50px; text-align:center" value="<?php echo $tit['TIT_TECH_WEIGHT'] ?>" id="tech_<?php echo $tit['TIT_ID'] ?>" class="r_number" onchange="tech(this.value,<?php echo $tit['TIT_ID'] ?>)" name="tit_tech_weight[<?php echo $tit['TIT_ID'] ?>][]"> :    
                                <input type="text" style="width:50px; text-align:center" value="<?php echo $tit['TIT_PRICE_WEIGHT'] ?>" id="price_<?php echo $tit['TIT_ID'] ?>" class="r_number" onchange="price(this.value,<?php echo $tit['TIT_ID'] ?>)" name="tit_price_weight[<?php echo $tit['TIT_ID'] ?>][]">
                        </div> -->
                        <?php endif; ?>
                        
                    </td>
                    <td><strong>Vendor</strong></td>
                    <td class="text-center" title=""><strong>Nilai Teknis</strong></td>
                    <td class="text-center" title="Passing Grade Evatek"><strong>Pass Grade</strong></td>
                    <td class="text-center" title="Lulus evaluasi teknis"><strong>Lulus Teknis</strong></td>
                    <?php if ($show_harga): ?>
                    <td class="text-center" title=""><strong>Nilai harga</strong></td>
                    <td class="text-center" title="Bobot Teknis:Bobot Harga"><strong>Nilai Bobot</strong></td>
                    <td class="text-center" title="Nilai perhitungan menggunakan bobot"><strong>Nilai total</strong></td>
                    <?php if($batas_penawaran){ ?>
                    <td class="text-center" title="Harga penawaran"><strong>Penawaran</strong></td>
                    <?php }
                    if ($show_nego): ?>
                        <td class="text-center" title=""><strong>Nilai ECE</strong></td>
                        <td class="text-center" title=""><strong>Nilai Penawaran</strong></td>
                        <td class="text-center" title="Harga nego"><strong>Nego</strong></td>
                        <td class="text-center" title="((nego-ece)/ece)*100%"><strong>Prosentase</strong></td>
                    <?php endif ?>
                    <?php endif ?>
                    <td class="text-center" title=""><strong>Peringkat</strong></td>
                    <!-- <td class="text-center" title="File evaluasi teknis"><strong>Att. Teknis</strong></td> -->
                </tr>
                <?php $peringkat = 1; foreach ($tit['ptv'] as $val): ?>
                <?php if (isset($ptqi[$tit['TIT_ID']][$val['PTV_VENDOR_CODE']])): $thisptqi = $ptqi[$tit['TIT_ID']][$val['PTV_VENDOR_CODE']]; ?>
                
                <tr class="<?php echo $thisptqi['LULUS_TECH'] ? '' : 'danger' ?> <?php echo empty($thisptqi['PQI_PRICE_VAL'])?'warning':'';?>">
                    <td nowrap title="VendorNo=<?php echo $val['PTV_VENDOR_CODE'] ?>, RFQ=<?php echo $val['PTV_RFQ_NO'] ?>">
                        <?php if ($input): ?>
                            <?php if ($lulus_evatek_aja): ?>
                                <?php if ($populate): ?>
                                <?php $is_checked = $thisptqi['LULUS_TECH'] ? '' : 'disabled' ?>
                                <?php $is_checked .= $thisptqi['DAPAT_UNDANGAN'] == 1 ? ' checked' : '' ?>
                                <?php else: ?>
                                <?php $is_checked = $thisptqi['LULUS_TECH'] ? 'checked' : 'disabled' ?>
                                <?php endif ?>
                            <?php else: ?>
                            <?php $is_checked = $thisptqi['LULUS_TECH'] && intval($thisptqi['PQI_PRICE_VAL']) > 0 ? 'checked' : 'disabled' ?>
                            <?php endif ?>
                            <input type="checkbox" class="cek_snippet_eval_with_input" name="lanjut[<?php echo $tit['TIT_ID'] ?>][<?php echo $thisptqi['PQI_ID'] ?>]" value="<?php echo $val['PTV_VENDOR_CODE'] ?>" <?php echo $is_checked ?> data-tit="<?php echo $tit['TIT_ID'] ?>">
                        <?php endif ?>
                        <?php echo $val['VENDOR_NAME'] ?>
                    </td>
                    <td class="text-center"><?php echo intval($thisptqi['PQI_TECH_VAL']) ?></td>
                    <td class="text-center"><?php echo $ptp['EVT_PASSING_GRADE'] ?></td>
                    <td class="text-center"><?php echo $thisptqi['LULUS_TECH'] ? 'Lulus' : 'Tidak' ?></td>
                    <?php if ($show_harga): ?>
                    <td class="text-center <?php echo empty($thisptqi['PQI_PRICE_VAL'])?'text-danger':'';?>"><?php echo intval($thisptqi['PQI_PRICE_VAL']) ?></td>
                    <td class="text-center"><?php echo empty($tit['TIT_TECH_WEIGHT'])? $thisptqi['EVT_TECH_WEIGHT'].' : '.$thisptqi['EVT_PRICE_WEIGHT'] :  $tit['TIT_TECH_WEIGHT'].' : '.$tit['TIT_PRICE_WEIGHT']; ?></td>
                    <td class="text-center"><?php echo $thisptqi['NILAI_TOTAL']/100 ?></td>
                    <?php $price_status = empty($thisptqi['PQI_PRICE_VAL'])?'warning':($thisptqi['PQI_PRICE'] > $tit['TIT_PRICE'] ? 'danger' : (($ptqi[$tit['TIT_ID']]['WIN'] == $val['PTV_VENDOR_CODE']) ? 'info' : '')) ?>
                    <?php if($batas_penawaran){ ?>
                    <td class="text-center <?php echo $price_status ?>"><?php echo number_format($thisptqi['PQI_PRICE']) ?></td>
                    <?php }
                    if ($show_nego): ?>
                        <?php $price_status = empty($thisptqi['PQI_PRICE_VAL'])?'warning':($thisptqi['PQI_FINAL_PRICE'] == 0 || $thisptqi['PQI_FINAL_PRICE'] > $tit['TIT_PRICE'] ? 'danger' : (($ptqi[$tit['TIT_ID']]['FINALWIN'] == $val['PTV_VENDOR_CODE']) ? 'info' : '')) ?>
                        <td class="text-center"><?php echo number_format($tit['TIT_PRICE']) ?></td>
                        <td class="text-center"><?php echo number_format($thisptqi['PQI_PRICE']) ?></td>
                        <td class="text-center <?php echo $price_status ?>"><?php echo number_format($thisptqi['PQI_FINAL_PRICE']) ?></td>
                        <?php
                            $prosen = (($thisptqi['PQI_FINAL_PRICE']-$tit['TIT_PRICE'])/$tit['TIT_PRICE'])*100;
                        ?>
                        <td class="text-center"><?php echo number_format($prosen); ?></td>
                    <?php endif ?>
                    <?php endif ?>
                    <td class="text-center"><?php echo $thisptqi['LULUS_TECH']?$peringkat++:'-'; ?></td>
                    <!-- <td class="text-center"><a href="#!">Attachment</a></td> -->
                </tr>
                <?php endif ?>
                <?php endforeach ?>
            <?php $no++; endforeach ?>
        </table>
    </div>
<?php endif ?>
<?php if (!$table_only): ?>
</div>
<?php endif ?>


<?php if ($ptp['PTP_IS_ITEMIZE'] != 1 && @$where_winner): ?>
<script>
    $(document).ready(function() {
        $(".cek_lolos_snippet_evaluasi").change(function() {
           
                checked = $(this).is(':checked');
                value = $(this).val();

                $(".cek_lolos_snippet_evaluasi").each(function() {
                    if ($(this).val() == value) {
                        $(this).prop('checked', checked);
                        // $(this).attr('checked', true);
                    }
                });

            
        });
    });
</script>
<?php endif ?>

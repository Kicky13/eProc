<?php
 if (!$table_only): ?>
<?php if ($show_harga): ?>
<?php if ($ptp['EVT_TYPE'] == '4'): ?> <!-- khusus tonasa -->
<div class="panel panel-default">
    <div class="panel-heading">
        Rekap Evaluasi Sebelum Interchange
    </div>
    <div class="table-responsive">
        <table class="table">
            <?php $no = 1; foreach ($tits as $tit): ?>
                <?php if (count($tit['ptv']) <= 0) { continue; } ?>
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
                    <td class="text-center" title="Harga penawaran"><strong>Penawaran</strong></td>
                    <?php endif ?>
                    <td class="text-center" title=""><strong>Peringkat</strong></td>
                    <!-- <td class="text-center" title="File evaluasi teknis"><strong>Att. Teknis</strong></td> -->
                </tr>
                <?php $peringkat = 1; foreach ($tit['ptv'] as $val): ?>
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
                    <td class="text-center"><?php echo number_format($thisptqi['PQI_PRICE']) ?></td>
                    <?php endif ?>
                    <td class="text-center"><?php echo $peringkat++; ?></td>
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
                // echo "<hr>";
                 // var_dump($ptqi_t);
            ?>        
            <?php $no = 1; foreach ($tit['ptv'] as $vendor): ?> 
            <?php if ($vendor['PTV_STATUS'] == 2):?>           
            <?php if (isset($ptqi_t[$vendor['PTV_VENDOR_CODE']])):  ?>
                <tr class="vendor">
                    <td class="hidden">
                        <!-- <input class="evaluasi_tit_id" value="<?php //echo $tit['TIT_ID'] ?>"> -->
                    </td>
                                 
                    <td rowspan="<?php echo count($ptqi_t[$vendor['PTV_VENDOR_CODE']])+2 ?>">
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

                    if ($show_nego): $tot_nego=0;?>
                    <td class="text-center" title="Harga nego"><strong>Nego</strong></td>
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
                    <td class="text-center <?php echo $price_status ?>"><?php echo number_format($thisptqi['PQI_FINAL_PRICE']); $tot_nego+=$thisptqi['PQI_FINAL_PRICE']; ?></td>
                    <?php endif ?>
                    <?php endif ?>
                    <td class="text-center"><?php echo (intval($thisptqi['PQI_TECH_VAL'])!=0)?$peringkat[$vendor['PTV_VENDOR_CODE']][$tit['TIT_ID']]:'-'; ?></td>
                </tr>                
                    <?php endif ?>
                <?php endforeach ?>
                 <?php if (isset($ptqi_t[$vendor['PTV_VENDOR_CODE']])):  ?>
                <tr>
                    <td class="text-right bold" colspan="6">Total</td>
                    <td class="text-center bold"><?php echo ($show_harga)?number_format($tot_nilai/(count($tits))):'';?></td>
                    <td class="text-center bold"><?php echo ($batas_penawaran)?number_format($tot_penawaran):'';?></td>
                    <td class="text-center bold"><?php echo ($show_nego)?number_format($tot_nego):'';?></td>
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
        <table class="table" style="width:100%">
            <?php $no = 1; foreach ($tits as $tit): ?>
            <?php foreach ($item as $key => $value):?>
            <?php if($tit['PPI_DECMAT'] == $value['POD_DECMAT']): ?>
                <?php if (count($tit['ptv']) <= 0) { continue; } ?>
                <tr>
                    <td width="40%" class="kiri data" rowspan="<?php echo count($ptqi[$tit['TIT_ID']])-1 ?>">
                        <?php echo $tit['PPI_DECMAT'] ?>
                        <?php if ($show_harga): ?>
                            <br>
                            ECE: <?php echo number_format($tit['TIT_PRICE']) ?>
                        <?php endif ?>
                        <br><br>

                       <?php 
                            $ada =0;
                            $kalimat = base_url(uri_string());
                            if(preg_match("/Evaluasi_penawaran/i", $kalimat)) {
                              $ada = 1;
                            } 
                        if ($ptp['EVT_TYPE'] == '4' && $ada==1): ?> <!-- khusus tonasa -->
                        <div>
                            Nilai Bobot                            
                                <input type="text" style="width:50px; text-align:center" value="<?php echo $tit['TIT_TECH_WEIGHT'] ?>" id="tech_<?php echo $tit['TIT_ID'] ?>" class="r_number" onchange="tech(this.value,<?php echo $tit['TIT_ID'] ?>)" name="tit_tech_weight[<?php echo $tit['TIT_ID'] ?>][]"> :    
                                <input type="text" style="width:50px; text-align:center" value="<?php echo $tit['TIT_PRICE_WEIGHT'] ?>" id="price_<?php echo $tit['TIT_ID'] ?>" class="r_number" onchange="price(this.value,<?php echo $tit['TIT_ID'] ?>)" name="tit_price_weight[<?php echo $tit['TIT_ID'] ?>][]">
                        </div>
                        <?php endif; ?>
                        
                    </td>
                    <td width="20%" class="kiri title data">Vendor</td>
                    <td width="10%" class="tengah title data" title="">Nilai Teknis</td>
                    <td width="10%" class="tengah title data" title="Passing Grade Evatek">Pass Grade</td>
                    <td width="10%" class="tengah title data" title="Lulus evaluasi teknis">Lulus Teknis</td>
                    <?php if ($show_harga): ?>
                    <td width="10%" class="tengah title data" title="">Nilai harga</td>
                    <td width="10%" class="tengah title data" title="Bobot Teknis:Bobot Harga">Nilai Bobot</td>
                    <td width="10%" class="tengah title data" title="Nilai perhitungan menggunakan bobot">Nilai total</td>
                    <?php if($batas_penawaran){ ?>
                    <td width="10%" class="tengah title data" title="Harga penawaran">Penawaran</td>
                    <?php }
                    if ($show_nego): ?>
                    <td width="10%" class="tengah title data" title="Harga nego">Nego</td>
                    <?php endif ?>
                    <?php endif ?>
                    <td width="10%" class="tengah title data" title="">Peringkat</td>
                </tr>
                <?php $peringkat = 1; foreach ($tit['ptv'] as $val): ?>
                <?php if (isset($ptqi[$tit['TIT_ID']][$val['PTV_VENDOR_CODE']])): $thisptqi = $ptqi[$tit['TIT_ID']][$val['PTV_VENDOR_CODE']]; ?>
                
                <tr class="<?php echo $thisptqi['LULUS_TECH'] ? '' : 'danger' ?> <?php echo empty($thisptqi['PQI_PRICE_VAL'])?'warning':'';?>">
                    <td class="data kiri" title="VendorNo=<?php echo $val['PTV_VENDOR_CODE'] ?>, RFQ=<?php echo $val['PTV_RFQ_NO'] ?>">
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
                    <td class="data tengah"><?php echo intval($thisptqi['PQI_TECH_VAL']) ?></td>
                    <td class="data tengah"><?php echo $ptp['EVT_PASSING_GRADE'] ?></td>
                    <td class="data tengah"><?php echo $thisptqi['LULUS_TECH'] ? 'Lulus' : 'Tidak' ?></td>
                    <?php if ($show_harga): ?>
                    <td class="data tengah <?php echo empty($thisptqi['PQI_PRICE_VAL'])?'text-danger':'';?>"><?php echo intval($thisptqi['PQI_PRICE_VAL']) ?></td>
                    <td class="data tengah"><?php echo empty($tit['TIT_TECH_WEIGHT'])? $thisptqi['EVT_TECH_WEIGHT'].' : '.$thisptqi['EVT_PRICE_WEIGHT'] :  $tit['TIT_TECH_WEIGHT'].' : '.$tit['TIT_PRICE_WEIGHT']; ?></td>
                    <td class="data tengah"><?php echo $thisptqi['NILAI_TOTAL']/100 ?></td>
                    <?php $price_status = empty($thisptqi['PQI_PRICE_VAL'])?'warning':($thisptqi['PQI_PRICE'] > $tit['TIT_PRICE'] ? 'danger' : (($ptqi[$tit['TIT_ID']]['WIN'] == $val['PTV_VENDOR_CODE']) ? 'info' : '')) ?>
                    <?php if($batas_penawaran){ ?>
                    <td class="data tengah <?php echo $price_status ?>"><?php echo number_format($thisptqi['PQI_PRICE']) ?></td>
                    <?php }
                    if ($show_nego): ?>
                    <?php $price_status = empty($thisptqi['PQI_PRICE_VAL'])?'warning':($thisptqi['PQI_FINAL_PRICE'] == 0 || $thisptqi['PQI_FINAL_PRICE'] > $tit['TIT_PRICE'] ? 'danger' : (($ptqi[$tit['TIT_ID']]['FINALWIN'] == $val['PTV_VENDOR_CODE']) ? 'info' : '')) ?>
                    <td class="data tengah <?php echo $price_status ?>"><?php echo number_format($thisptqi['PQI_FINAL_PRICE']) ?></td>
                    <?php endif ?>
                    <?php endif ?>
                    <td class="data tengah"><?php echo (intval($thisptqi['PQI_TECH_VAL'])!=0)?$peringkat++:'-'; ?></td>
                </tr>
                <?php endif ?>
                <?php endforeach ?>
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

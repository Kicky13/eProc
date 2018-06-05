<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Penunjukan Pemenang</h2>
            </div>
            <form method="post" action="<?php echo base_url() ?>Penunjukan_pemenang/win" class="submit">
                <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_detail['PTM_NUMBER'] ?>">
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($this->session->flashdata('rfc_ft_return') != false): ?>
                            <?php $rfc_ft_return = $this->session->flashdata('rfc_ft_return'); ?>
                            <div class="alert alert-info alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <p>FT_RETURN:</p>
                                <ul>
                                    <?php foreach ($rfc_ft_return as $key => $value): ?>
                                        <li>&nbsp;&nbsp;&nbsp;<?php echo $value['MESSAGE'] ?></li>
                                    <?php endforeach ?>
                                </ul>
                                <div class="hidden hasil rfc">
                                    <?php echo var_dump($rfc_ft_return) ?>
                                </div>
                            </div>
                        <?php endif ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">Pilih Pemenang</div>
                            <?php if (count($tits) <= 0): ?>
                                <div class="panel-body">
                                    Tidak ada item yang terpilih untuk penunjukan pemenang.
                                </div>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <?php if($ptp['PTP_IS_ITEMIZE']==1):?>
                                    <?php $no = 1; foreach ($tits as $tit): ?>
                                    <tr>
                                        <td class="text-right"><?php echo $no ?></td>
                                        <td colspan="2" nowrap=""><strong><?php echo $tit['PPI_DECMAT'] ?></strong> </td>
                                        <td class="text-right">Harga ECE</td>
                                        <td class="text-right">Harga Penawaran</td>
                                        <td class="text-right">Harga Akhir</td>
                                        <td class="text-right">Subtotal</td>
                                    </tr> 
                                        <?php foreach ($pqiall[$tit['TIT_ID']] as $pqi): ?>
                                            <?php $val = $vendor_data[$pqi['PTV_VENDOR_CODE']]; ?>
                                            <tr>
                                                <td class="col-md-1"></td>
                                                <td class="col-md-1 text-right">
                                                    <?php if ($pqi['PQI_FINAL_PRICE'] != 0): ?>
                                                    <input type="radio" class="winradio" name="win[<?php echo $tit['TIT_ID'] ?>]" value="<?php echo $val['PTV_VENDOR_CODE'] ?>">
                                                    <?php endif ?>
                                                </td>
                                                <td><?php echo $val['VENDOR_NAME'] ?> (RFQ <?php echo $val['PTV_RFQ_NO'] ?>) (Qty: <span class="itemqty"><?php echo $pqi['PQI_QTY'] ?></span>)</td>
                                                <td class="col-md-2 text-right"><?php echo number_format($tit['TIT_PRICE']); ?></td>
                                                <td class="col-md-2 text-right"><?php echo number_format($pqi['PQI_PRICE']); ?></td>                                                    
                                                <?php $price_status = $pqi['PQI_FINAL_PRICE'] > $tit['TIT_PRICE'] ? 'danger' : ($pqi['FINALWIN'] == $val['PTV_VENDOR_CODE'] ? 'info' : '') ?>
                                                <td class="col-md-2 text-right <?php echo $price_status; ?>">
                                                    <span class="winprice hidden"><?php echo $pqi['PQI_FINAL_PRICE'] ?></span>
                                                    <span class=""><?php echo number_format($pqi['PQI_FINAL_PRICE']); ?></span>
                                                </td>
                                                <td class="col-md-2 text-right">
                                                    <span class=""><?php echo number_format($pqi['PQI_QTY']*$pqi['PQI_FINAL_PRICE']) ?></span>
                                                    <span class="itemqty hidden"><?php echo $pqi['PQI_QTY']; ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <tr class="tritemprice active hidden">
                                        <td class="col-md-1"></td>
                                        <td colspan="5" class="text-right">Subtotal</td>
                                        <td class="text-right">
                                            <span class="itemprice hidden">0</span>
                                            <span class="itempriceshow">0</span>
                                        </td>
                                    </tr>
                                    <?php $no++; endforeach ?>
                                <?php endif;?>

                                <?php if($ptp['PTP_IS_ITEMIZE']=='0'):?>
                                    <?php  $vnd_final_price = array(); $vendor = array();
                                        foreach ($vendor_data as $val1){
                                            $final_price = 0 ;
                                            foreach ($tits as $tit1){
                                                $pqi1 = @$pqiall[$tit1['TIT_ID']][$val1['PTV_VENDOR_CODE']];
                                                $final_price += $pqi1['PQI_FINAL_PRICE'];
                                            }
                                            $vendor[$val1['PTV_VENDOR_CODE']] = $final_price;
                                            $vnd_final_price[$val1['PTV_VENDOR_CODE']] = $final_price;
                                        }
                                        asort($vendor);
                                        foreach ($vendor_data as $val2){
                                            $vendor[$val2['PTV_VENDOR_CODE']] = $val2;
                                        }
                                    ?> 

                                    <?php $no = 1; foreach ($vendor as $val): ?>
                                        <tr>
                                            <td class="text-right"><?php echo $no ?></td>
                                            <td colspan="2" nowrap="">
                                                <?php if($vnd_final_price[$val['PTV_VENDOR_CODE']] > 0): ?>
                                                    <input type="radio" class="vendorwinradio" name="vendorwin[]" value="<?php echo $val['PTV_VENDOR_CODE'] ?>">
                                                <?php endif ?>
                                                <strong><?php echo $val['VENDOR_NAME'] ?> (RFQ <?php echo $val['PTV_RFQ_NO'] ?>)</strong></td>
                                            <td class="text-right">Harga ECE</td>
                                            <td class="text-right">Harga Penawaran</td>
                                            <td class="text-right">Harga Akhir</td>
                                            <td class="text-right">Subtotal</td>
                                        </tr> 
                                        <?php foreach ($tits as $tit): ?>
                                            <?php 
                                            $pqi = @$pqiall[$tit['TIT_ID']][$val['PTV_VENDOR_CODE']];?>
                                            <tr>
                                                <td class="col-md-1"></td>
                                                <td class="col-md-1 text-right">
                                                    <?php if ($pqi['PQI_FINAL_PRICE'] != 0): ?>
                                                    <input type="radio" class="winradio hidden menang_<?php echo $val['PTV_VENDOR_CODE'] ?>" name="win[<?php echo $tit['TIT_ID'] ?>]" value="<?php echo $val['PTV_VENDOR_CODE'] ?>">
                                                    <?php endif ?>
                                                </td>
                                                <td><?php echo $tit['PPI_DECMAT']  ?> (Qty: <span class="itemqty"><?php echo $pqi['PQI_QTY'] ?></span>)</td>
                                                <td class="col-md-2 text-right"><?php echo number_format($tit['TIT_PRICE']); ?></td>
                                                <td class="col-md-2 text-right"><?php echo number_format($pqi['PQI_PRICE']); ?></td>                                                    
                                                <?php $price_status = $pqi['PQI_FINAL_PRICE'] > $tit['TIT_PRICE'] ? 'danger' : ($pqi['FINALWIN'] == $val['PTV_VENDOR_CODE'] ? 'info' : '') ?>
                                                <td class="col-md-2 text-right <?php echo $price_status; ?>">
                                                    <span class="winprice hidden"><?php echo $pqi['PQI_FINAL_PRICE'] ?></span>
                                                    <span class=""><?php echo number_format($pqi['PQI_FINAL_PRICE']); ?></span>
                                                </td>
                                                <td class="col-md-2 text-right">
                                                    <span class=""><?php echo number_format($pqi['PQI_QTY']*$pqi['PQI_FINAL_PRICE']) ?></span>
                                                    <span class="itemqty hidden"><?php echo $pqi['PQI_QTY']; ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                        <tr class="tritemprice active hidden">
                                            <td class="col-md-1"></td>
                                            <td colspan="5" class="text-right">Subtotal</td>
                                            <td class="text-right">
                                                <span class="itemprice hidden">0</span>
                                                <span class="itempriceshow">0</span>
                                            </td>
                                        </tr>
                                        <?php $no++; endforeach ?>
                                    <tr class="success">
                                        <td colspan="6" class="text-center"><strong>Total</strong></td>
                                        <td id="totalprice" class="text-right text-bold">0</td>
                                    </tr>
                                    <?php endif;?>
                                </table>
                                <input type="hidden" id="itemcount" value="<?php echo count($tits) ?>">
                            </div>
                            <?php endif ?>
                        </div>

<?php if ($ptp['EVT_TYPE'] == '4' && $ptm_detail['MASTER_ID'] >= 13): ?> <!-- khusus tonasa -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Rekap Evaluasi Sebelum Interchange
        </div>
        <div class="table-responsive">
            <table class="table">
                <?php $no = 1; foreach ($tits_b as $tit): ?>
                    <?php if (count($tit['ptv_b']) <= 0) { continue; } ?>
                    <tr>
                        <td rowspan="<?php echo count($ptqi[$tit['TIT_ID']])-1 ?>"><?php echo $tit['PPI_DECMAT'] ?><br>ECE: <?php echo number_format($tit['TIT_PRICE']) ?></td>
                        <td><strong>Vendor</strong></td>
                        <td class="text-center" title=""><strong>Nilai Teknis</strong></td>
                        <td class="text-center" title="Passing Grade Evatek"><strong>Pass Grade</strong></td>
                        <td class="text-center" title="Lulus evaluasi teknis"><strong>Lulus Teknis</strong></td>
                        <td class="text-center" title=""><strong>Nilai harga</strong></td>
                        <td class="text-center" title="Bobot Teknis:Bobot Harga"><strong>Nilai Bobot</strong></td>
                        <td class="text-center" title="Nilai perhitungan menggunakan bobot"><strong>Nilai total</strong></td>
                        <td class="text-center" title=""><strong>Peringkat</strong></td>
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
                        <td class="text-center"><?php echo intval($thisptqi['PQI_PRICE_VAL']) ?></td>
                        <td class="text-center"><?php echo $thisptqi['EVT_TECH_WEIGHT_B'].' : '.$thisptqi['EVT_PRICE_WEIGHT_B'] ?></td>
                        <td class="text-center"><?php echo $thisptqi['NILAI_TOTAL_B']/100 ?></td>
                        <td class="text-center"><?php echo $thisptqi['LULUS_TECH'] ? $peringkat++ : '-'; ?></td>
                    </tr>
                    <?php endif ?>
                    <?php endforeach ?>
                <?php $no++; endforeach ?>
            </table>
        </div>
    </div>
<?php endif ?>

<div class="panel panel-default">
    <div class="panel-heading">
        Rekap Evaluasi Berdasarkan <?php echo ($ptp['PTP_JUSTIFICATION_ORI']!=5)?$ptp['EVT_TYPE_NAME']:''; ?>
    </div>
<?php if($view_order == 'item_per_vendor' || $view_order == 'both'):?>
    <div class="table-responsive">        
        <table class="table">
            <?php
                /*menyimpan peringkat setiap vendor per item*/
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
                $ptqi_t=array();    
                $peringkat=array();              
                foreach ($ptqi as $key_tit => $value) {  
                    foreach ($value as $key_vnd => $val) {
                        $ptqi_t[$key_vnd][$key_tit]=$val;                        
                        $peringkat[$key_vnd][$key_tit]=isset($rangking[$key_vnd])?$rangking[$key_vnd]:'';                        
                        
                    }
                    
                }
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
                    <?php 
                    if ($show_nego): $tot_nego=0; $tot_prosen=0;?>
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
                    <td class="text-center <?php echo $price_status ?>"><?php echo number_format($thisptqi['PQI_PRICE']); $tot_penawaran+=$thisptqi['PQI_PRICE']; ?></td>
                    <?php 
                    if ($show_nego): ?>
                        <?php $price_status = $thisptqi['PQI_FINAL_PRICE'] == 0 || $thisptqi['PQI_FINAL_PRICE'] > $tit['TIT_PRICE'] ? 'danger' : ($ptqi[$tit['TIT_ID']]['FINALWIN'] == $vendor['PTV_VENDOR_CODE'] ? 'info' : '') ?>
                        <td class="text-center <?php echo $price_status ?>"><?php echo number_format($thisptqi['PQI_FINAL_PRICE']); $tot_nego+=$thisptqi['PQI_FINAL_PRICE']; ?></td>
                        <?php
                            $prosen = (($thisptqi['PQI_FINAL_PRICE']-$tit['TIT_PRICE'])/$tit['TIT_PRICE'])*100;
                        ?>
                        <td class="text-center"><?php echo number_format($prosen); $tot_prosen+=$prosen; ?></td>
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
                    <?php if($batas_penawaran): ?>
                        <td class="text-center bold"><?php echo number_format($tot_penawaran);?></td>
                    <?php endif ?>
                    <td class="text-center bold"><?php echo ($show_harga)?number_format($tot_nego):''; ?></td>
                    <td class="text-center bold"><?php echo ($show_harga)?round($tot_prosen/count($tits),2):''; ?></td>
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
            <?php $no = 1; foreach ($tit_new as $tit): ?>
                <?php if (count($tit['ptv']) <= 0) { continue; } ?>
                <tr>
                    <td class="hidden">
                        <input class="evaluasi_tit_id" value="<?php echo $tit['TIT_ID'] ?>">
                    </td>
                    <td rowspan="<?php echo count($ptqi[$tit['TIT_ID']])-1 ?>">
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
                        if ($ptp['EVT_TYPE'] == '4' && $ada==1): ?> 
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
                    <?php
                    if ($show_nego): ?>
                        <td class="text-center" title="Harga nego"><strong>Nego</strong></td>
                        <td class="text-center" title="((nego-ece)/ece)*100%"><strong>Prosentase</strong></td>
                    <?php endif ?>
                    <?php endif ?>
                    <td class="text-center" title=""><strong>Peringkat</strong></td>
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
                    <?php
                    if ($show_nego): ?>
                        <?php $price_status = empty($thisptqi['PQI_PRICE_VAL'])?'warning':($thisptqi['PQI_FINAL_PRICE'] == 0 || $thisptqi['PQI_FINAL_PRICE'] > $tit['TIT_PRICE'] ? 'danger' : (($ptqi[$tit['TIT_ID']]['FINALWIN'] == $val['PTV_VENDOR_CODE']) ? 'info' : '')) ?>
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

                        <?php echo $this->snippet->assignment($ptm_number) ?><?php echo $ptm_comment ?>
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
                                <select name="next_process" id="next_process">
                                    <option value="1">Tunjuk Pemenang</option>
                                    <option value="0">Retender</option>
                                    <option value="999">Batal</option>
                                </select>
                                <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                                <button type="submit" class="formsubmit main_button color4 small_btn submit">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
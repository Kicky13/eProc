<?php /*itemize*/ if ($ptp['PTP_IS_ITEMIZE'] == 1): ?>      
<?php if(isset($titems)&&count($titems)>0){?>                  
    <?php foreach ($titems as $val): ?>                            
    <div class="panel panel-default">
        <div class="panel-heading">Rekap Nego Auction atas Item <strong><?php echo $val['PPI_DECMAT'] ?></strong></div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th><?php echo ($title=='Tahap Negosiasi')?'<label><input type="checkbox" onchange="cekallvendor(this)" title="Pilih semua"/>(Pilih semua)</label>':'';?> Vendor</th>
                    <th>Qty (<?php echo $val['PPI_UOM'] ?>)</th>
                    <th class="text-right">ECE</th>
                    <th class="text-right">Penawaran</th>
                    <th class="text-right">Nego</th>
                    <th>Vnd Qty</th>
                    <th class="text-right"><strong>Total ECE</strong></th>
                    <th class="text-right"><strong>Total Penawaran</strong></th>
                    <th class="text-right"><strong>Total Nego</strong></th>
                </thead>
                <?php if(array_key_exists($val['TIT_ID'],$ptquoitem)){ ?>
                <tbody>                                                      
                                                  
                    <?php foreach ($ptquoitem[$val['TIT_ID']] as $key => $pqi): ?>                                            
                        <tr>
                            <td>
                                <?php echo ($title=='Tahap Negosiasi')?'<label><input type="checkbox" class="cekvendor cekvendor_auction" name="vendor_ikut_auction['.$vendors[$key]['PTV_VENDOR_CODE'].'][]" value="'.$val['TIT_ID'].'" ></label>':'';?>
                                <?php echo '<input type="hidden" name="vendor_item['.$vendors[$key]['PTV_VENDOR_CODE'].'][]" value="'.$val['TIT_ID'].'" >';?>
                                <?php echo $vendors[$key]['VENDOR_NAME'] ?></td>
                            <td><?php echo $val['TIT_QUANTITY'] ?></td>
                            <td class="text-right"><?php echo number_format($val['TIT_PRICE']) ?></td>
                            <td class="text-right"><?php echo number_format($pqi['PQI_PRICE']) ?></td>
                            <td class="text-right"><?php echo number_format($pqi['PQI_FINAL_PRICE']) ?></td>
                            <td><?php echo $pqi['PQI_QTY'] ?></td>
                            <td class="text-right"><strong><?php echo number_format($val['TIT_PRICE'] * $val['TIT_QUANTITY']) ?></strong></td>
                            <td class="text-right"><strong><?php echo number_format($pqi['PQI_PRICE'] * $pqi['PQI_QTY']) ?></strong></td>
                            <td class="text-right"><strong><?php echo number_format($pqi['PQI_FINAL_PRICE'] * $pqi['PQI_QTY']) ?></strong></td>
                        </tr>                                                
                    <?php endforeach ?>
                    
                </tbody>
                <?php }?>
            </table>
        </div>
    </div>
    <?php endforeach ?>
    <?php }?>
<?php /*paket*/ else: ?>
    <?php if(isset($titems)&&count($titems)>0){?> 
    <div class="panel panel-default">
        <div class="panel-heading">Rekap Nego Auction</div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-middle" rowspan="2">Item</th>
                        <th class="text-middle" rowspan="2">Qty</th>
                        <th class="text-middle" rowspan="2">UoM</th>
                        <th class="text-middle" rowspan="2">ECE</th>
                        <?php foreach ($vendors as $key => $val): ?>
                            <th colspan="2" class="text-center"><label>
                                <?php echo '<input type="checkbox" class="cekvendorpaket form-control input-sm" name="vendor_ikut['.$val['PTV_VENDOR_CODE'].']" '.(($title!='Tahap Negosiasi' && $pqi_auction[$val['PTV_VENDOR_CODE']]['PQI_IS_WINNER']==1)?'Checked="checked"':'').' '.($title=='Tahap Negosiasi'?'':'Disabled').' value="'.$val['PTV_VENDOR_CODE'].'" title="Centang untuk membuka nego" >';?>
                                <?php echo $val['VENDOR_NAME'] ?></label></th>
                        <?php endforeach ?>
                    </tr>
                    <tr>
                        <?php foreach ($vendors as $val): ?>
                            <th>Penawaran</th>
                            <th>Nego</th>
                        <?php endforeach ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = array(); $tot_qty_price=0;?>
                    <?php foreach ($titems as $val): ?>
                        <tr>

                            <td><strong><?php echo $val['PPI_DECMAT'] ?></strong></td>
                            <td><?php echo $val['TIT_QUANTITY']; $tot_qty_price+=($val['TIT_QUANTITY']*$val['TIT_PRICE']); ?></td>
                            <td><?php echo $val['PPI_UOM'] ?></td>
                            <td class="text-right"><?php echo number_format($val['TIT_PRICE']) ?></td>
                            <?php foreach ($ptquoitem[$val['TIT_ID']] as $key => $pqi): ?>
                                <td class="text-right" title="Harga Penawaran">
                                    <?php echo ($title=='Tahap Negosiasi')?'<label><input type="checkbox" class="cekvendor_auction hidden" name="vendor_ikut_auction['.$key.'][]" value="'.$val['TIT_ID'].'" ></label>':'';?>
                                    <?php echo number_format($pqi['PQI_PRICE']) ?></td>
                                <td class="text-right" title="Harga Nego"><?php echo number_format($pqi['PQI_FINAL_PRICE']) ?></td>
                                <?php echo ($title=='Tahap Negosiasi')?'<label><input type="hidden" name="vendor_item['.$key.'][]" value="'.$val['TIT_ID'].'" ></label>':'';?>
                                <?php $total[$key]['PENAWARAN'] = isset($total[$key]['PENAWARAN']) ? $total[$key]['PENAWARAN'] + $pqi['PQI_PRICE'] * $val['TIT_QUANTITY'] : $pqi['PQI_PRICE'] * $val['TIT_QUANTITY'] ?>
                                <?php $total[$key]['NEGO'] = isset($total[$key]['NEGO']) ? $total[$key]['NEGO'] + $pqi['PQI_FINAL_PRICE'] * $val['TIT_QUANTITY'] : $pqi['PQI_FINAL_PRICE'] * $val['TIT_QUANTITY'] ?>
                            <?php endforeach ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>
                <tfoot>                   
                   <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td class="text-right"><strong><?php echo number_format($tot_qty_price); ?></strong></td>
                        <?php foreach ($total as $tot): ?>
                            <td class="text-right"><strong><?php echo number_format($tot['PENAWARAN']) ?></strong></td>
                            <td class="text-right"><strong><?php echo number_format($tot['NEGO']) ?></strong></td>
                        <?php endforeach ?>
                    </tr>
                   
                </tfoot>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        $(".cekvendorpaket").change(function(){
            if($(this).prop('checked')==true){
                $("input[name='vendor_ikut_auction["+$(this).val()+"][]']").prop("checked",true);    
            }else{
                $("input[name='vendor_ikut_auction["+$(this).val()+"][]']").prop("checked",false);    
            }
            
        });
    </script>
    <?php }?>
<?php endif ?>
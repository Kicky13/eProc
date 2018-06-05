<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <form name="approval-evatek-form" id="approval-evatek-form" method="post" action="<?php echo base_url() ?>EC_Proc_pengaju_evatek/save_approval" class="submit">
                <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_number; ?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Pengajuan Evaluator</div>
                            <div class="panel-body">
                                <div class="row">
                                <div class="col-xs-4">
                                Evaluator
                                </div>
                                <div class="col-xs-8">
                                <?php echo $evaluator['FULLNAME'] ?> (<?php echo $evaluator['POS_NAME'] ?> | <?php echo $evaluator['DEPT_NAME'] ?>)
                                <input type="hidden" name="id_emp" value="<?php echo $evaluator['ID'] ?>">
                                </div>
                                </div>
                            </div>
                        </div>
                        <?php echo $detail_ptm_snip ?>
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
                                                                foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                                <!-- <th class="text-center <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']): echo "bg-success";  else: echo "bg-danger"; endif ?>"><strong><?php echo $ptv[$key]['VENDOR_NAME'] ?></strong></th> -->
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
                                                                        ?>">

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
                                                                <td class="warnung">Qty (<?php echo $item['PPI_UOM']; ?>)</td>
                                                                <td class="active text-center"><?php echo $item['TIT_QUANTITY']; ?></td>
                                                                <?php 
                                                                if(isset($pqi[$item['TIT_ID']])) {
                                                                    foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                                        <td class="text-center <?php if (floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY']) < floatval($item['TIT_QUANTITY'])): echo "bg-warning"; endif; ?>">

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

                                                                        <?php echo number_format($pqi[$item['TIT_ID']][$key]['PQI_PRICE'] * $pqi[$item['TIT_ID']][$key]['PQI_QTY']) ?>
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
                                                                ?>">
                                                                    <?php echo number_format(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE'])); ?>
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
                        <div class="panel panel-default">
                            <div class="panel-heading">Evaluasi Teknis</div>
                            <div class="panel-body">
                                <div class="">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <th colspan="2"></th>
                                            <?php foreach ($evatek as $key => $value) { ?>                                                
                                            <th class="text-center"><strong><?php echo $ptv[$key]['VENDOR_NAME'] ?></strong></th>
                                            <?php } ?>
                                        </thead>
                                        <tbody id="">
                                            <?php foreach ($template_eval['detail'] as $value) { ?>    
                                                <?php if($value['PRASYARAT']==1) { ?>    
                                                    <tr style="vertical-align: top;"> 
                                                        <td style="vertical-align: top;">
                                                            <strong><?php echo $value['PPD_ITEM']; ?></strong>                                                            
                                                        </td>
                                                        <td>
                                                            <?php foreach ($value['uraian'] as $list) { ?> 
                                                                <div class="row" style="padding: 5px;">
                                                                    <div class="col-sm-12 col-md-12 col-lg-12"><?php echo $list['PPTU_ITEM'];?></div>
                                                                </div>              
                                                            <?php } ?>  
                                                        </td>
                                                        <?php foreach ($evatek as $key => $value2) { ?>
                                                        <td class="text-center">   
                                                        
                                                            <?php foreach ($value['uraian'] as $list) { ?>                                                               
                                                                <div class="row" style="padding: 5px;">                                                                        
                                                                   <div class="col-sm-12 col-md-12 col-lg-12">
                                                                   <?php foreach ($evatek[$key] as $pptu) {                                                       
                                                                    
                                                                        if($list['PPTU_ID']==$pptu['PPTU_ID']){
                                                                            echo $pptu['PQE_RESPON']==null?'-':$pptu['PQE_RESPON'];
                                                                            break;                                      
                                                                        }
                                                                   
                                                                   }?>
                                                                   </div>
                                                                </div>            
                                                            <?php } ?>  
                                                        </td>
                                            <?php } 
                                                 ?>
                                                        
                                                        
                                                    </tr>
                                                <?php } ?>    
                                            <?php } ?>    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php echo $this->snippet->assignment($ptm_number) ?>
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
                                <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                               <!--  <button type="submit" class="main_button color1 small_btn" name="submit" value="0">Reject</button>
                                <button type="submit" class="main_button color6 small_btn" name="submit" value="1">Approve</button> -->
                                <input type="hidden" name="next_process" id="next_process">
                                <input type="button" class="formsubmit_ main_button color1 small_btn milihtombol_publicjs" onclick="reject()" value="Reject">
                                <input type="button" class="formsubmit_ main_button color6 small_btn milihtombol_publicjs" onclick="approve()" value="Approve">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
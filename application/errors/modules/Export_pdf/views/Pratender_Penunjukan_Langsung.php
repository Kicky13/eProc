<style>
    table, th, td {
        padding:5px;
        /*border: 1px solid black;*/
        border-collapse: collapse;
    }
</style>
<div style="width:670px;padding:10px;border: 1px solid black;">
    <div style="width:100%;text-align:center">
        <div style="height:25px;">
            <!-- <div style="width:4%; height:25px; border:1px solid black; float:left;margin-right:5px;">
            </div>

            <div style="padding-top:4px;width:40px; height:25px; float:left; margin-right:5px; overflow:hidden;font-size:12pt;">
                Email
            </div>

            <div style="width:4%; height:25px; border:1px solid black; float:left;margin-right:5px;">
            </div>

            <div style="padding-top:4px;width:25px; height:25px; float:left; margin-right:5px; overflow:hidden;font-size:12pt;">
                Fax
            </div>

            <div style="width:4%; height:25px; border:1px solid black; float:left;margin-right:5px;">
            </div>

            <div style="padding-top:4px;width:40px; height:25px; float:left; margin-right:5px;font-size:12pt;">
                Eproc
            </div>
 -->
            <div>
                <strong>
                    USULAN PENUNJUKAN LANGSUNG KE VENDOR
                </strong>
            </div>
        </div>
        <div style="height:25px;">
            <div>
                <strong>
                    (<?php echo $plant['PLANT_NAME'];?>)
                </strong>
            </div>
        </div>
    </div>
    <br>
    <div style="width:100%;">
        <table border="1" style="width:100%; font-size:8pt;">
            <tr>
                <td style="width:20%" colspan="2"><strong>DATE</strong></td>
                <td  style="width:80%" colspan="5"><?php echo $ptm['PTM_CREATED_DATE']; ?></td>
            </tr>
            <tr>
                <td style="width:20%" colspan="2"><strong>MATERIAL GROUP</strong></td>
                <td colspan="5"><?php $i=1;
                    foreach ($matgrp as $m) {                        
                        echo $m['MAT_GROUP_CODE'].' - '.$m['MAT_GROUP_NAME'];
                        echo ($i++ < count($matgrp))? ', ':'';
                    }
                    ?></td>
                </tr>
               <!--  <tr>
                    <td style="width:20%" colspan="2"><strong>SUB MATERIAL GROUP</strong></td>
                    <td  style="width:80%" colspan="5"><?php echo ''; ?></td>
                </tr> -->
                <tr>
                    <td colspan="2"><strong>REQUISTIONER</strong></td>
                    <?php $reqarray = array(); ?>
                    <?php foreach ($pti as $val): ?>
                        <?php $reqarray[] = $val['PPR_REQUESTIONER'] . (isset($cctr[$val['PPR_REQUESTIONER']]) ? ' '.$cctr[$val['PPR_REQUESTIONER']]['LONG_DESC'] : ''); ?>
                    <?php endforeach ?>
                    <td colspan="5"><?php echo implode(', ', array_unique($reqarray)) ?></td>
                </tr>
                <!-- <tr>
                    <td style="width:20%" colspan="2"><strong>REMARK</strong></td>
                    <td  style="width:80%" colspan="5"><?php echo ''; ?></td>
                </tr> -->
                <!-- <tr>
                    <td style="width:20%" colspan="2"><strong>STATUS PERMINTAAN</strong></td>
                    <td  style="width:80%" colspan="5"><?php echo ''; ?></td>
                </tr> -->
                <?php
                $tot_estimasi=0;
                foreach ($pti as $t) {
                    $nilai = $t['TIT_PRICE']*$t['TIT_QUANTITY'];
                    $tot_estimasi += $nilai;
                }
                $no_pr=array(); $item=array(); $ket=array(); 
                foreach ($ppi as $pi) {
                    $no_pr[$pi['PPI_ID']] = $pi['PPI_PRNO'];
                    $item[$pi['PPI_ID']] = $pi['PPI_PRITEM'];
                    $ket[$pi['PPI_ID']] = $pi['PPI_DECMAT'];
                }
                ?>
                <tr>
                    <td style="width:20%" colspan="2"><strong>ESTIMASI NILAI (Total)</strong></td>
                    <td  style="width:80%" colspan="5"><?php echo number_format($tot_estimasi).' '.$ppi[0]['PPI_CURR']; ?></td>
                </tr>          
                <tr>
                    <td style="width:20%;text-align:center;" colspan="2"><strong>PR. NUMBER</strong></td>
                    <td style="width:35%;text-align:center;"><strong>DESCRIPTION</strong></td>
                    <td  style="width:10%;text-align:center;"><strong>ECE PRICE</strong></td>
                    <td style="width:25%;text-align:center;"><strong>LAST PRC PO / VENDOR</strong></td>
                    <td  style="width:7%;text-align:center;"><strong>QTY</strong></td>
                    <td style="width:3%;text-align:center;"><strong>UOM</strong></td>
                </tr>
                <?php if($ptm['IS_JASA'] == 0) {?>
                <?php foreach ($pti as $p) { ?>
                <tr>
                    <td style="width:15%"><?php 
                        if(isset($no_pr[$p['PPI_ID']])) {
                            echo $no_pr[$p['PPI_ID']]; 
                        }
                        ?></td>
                        <td  style="width:5%; text-align:center"><?php 
                            if(isset($item[$p['PPI_ID']])) {
                                echo $item[$p['PPI_ID']]; 
                            }
                            ?></td>
                            <td style="width:35%"><?php 
                                if(isset($ket[$p['PPI_ID']])) {
                                    echo $ket[$p['PPI_ID']]; 
                                }
                                ?></td>
                                <td  style="width:10%;text-align:right;">
                                    <?php echo number_format($p['TIT_PRICE']); ?></td>
                                    <td style="width:25%"></td>
                                    <td  style="width:7%;text-align:center;"><?php echo $p['TIT_QUANTITY']; ?></td>
                                    <td style="width:3%;text-align:center;"><?php echo $p['PPI_UOM']; ?></td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?> <!-- jika jasa -->
                                <tr>
                                    <td style="width:15%"><?php echo $ppi[0]['PPI_PRNO']; ?></td>
                                    <td  style="width:5%; text-align:center"><?php echo $ppi[0]['PPI_PRITEM']; ?></td>
                                    <td style="width:35%"><?php echo $ppi[0]['PPI_DECMAT']; ?></td>
                                    <td  style="width:10%;text-align:right;"><?php echo number_format($tot_estimasi); ?></td>
                                    <td style="width:25%"></td>
                                    <td  style="width:7%;text-align:center;"><?php echo $ppi[0]['PPI_PRQUANTITY']; ?></td>
                                    <td style="width:3%;text-align:center;"><?php echo $ppi[0]['PPI_UOM']; ?></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>

                        <div style="width:100%;">
                            <table border="1" style="width:100%; font-size:8pt;">
                                <tr>
                                    <td style="width:2%"><strong>No.</strong></td>
                                    <td style="width:18%"><strong>Kode Vendor</strong></td>
                                    <td style="width:40%"><strong>Nama Vendor</strong></td>
                                    <td style="width:10%"><strong>Mat. Grp Vendor</strong></td>
                                    <td style="width:10%"><strong>Status</strong></td>
                                    <td style="width:20%"><strong>Catatan</strong></td>
                                </tr>
                                <?php if(isset($vendor)){
                                    $no=1;
                                    foreach ($vendor as $vd) { ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $vd['PTV_VENDOR_CODE']; ?></td>
                                        <td><?php echo $vd['VENDOR_NAME']; ?></td>
                                        <td></td>
                                        <td><?php //echo $vd['STATUS']; ?></td>
                                        <td><?php //echo $vd['ALASAN']; ?></td>
                                    </tr>
                                    <?php }
                                } ?>
                            </table>
                        </div>

                        <div style="width:100%;">
                            <table style="height:70px;border:1.5px solid black;font-size:8pt;padding:5px;margin:0.8%">
                                <tr>
                                    <td>Alasan :<br><?php echo nl2br(str_replace('  ', '&nbsp;&nbsp;&nbsp;', $ptm_comment)) ?></td>
                                </tr>
                            </table>        
                        </div>
                        <div style="font-size:8pt;padding:5px;margin:0.8%">
                            Gresik, <?php echo date("d F Y"); ?>
                        </div>
                        <div style="width:100%;height:95px;font-size:8pt;padding:5px;margin:0.8%">
                            <div style="width:20%;text-align:center;">
                                Diajukan oleh,
                            </div>
                            <div style="width:20%;text-align:center;height:60px;">
                            </div>
                            <div style="width:20%;text-align:center;">
                                <?php $opco = $this->session->userdata('COMPANYID'); ?>
                                <?php if ($opco == '4000') { ?> <!-- KONDISI UTNUK SEMEN TONASA-->
                                <?php foreach ($diajukan as $key ) {
                                    if ($key['PGRP'] == 'T01' || $key['PGRP'] == 'T02' || $key['PGRP'] == 'T03' || $key['PGRP'] == 'T04' || $key['PGRP'] == 'T05') {
                                        if ($tot_estimasi <= 1000000000) {
                                            if ($key['URUTAN'] == '2') { 
                                                echo "<u>".$emp_kewenangan[$key['EMP_ID']]."</u>"; ?>
                                            </div>
                                            <div style="text-align:center;width:20%;">
                                                <?php echo $key['JABATAN'];?>
                                            </div>
                                            <?php } 
                                        } else if($tot_estimasi > 1000000000) {
                                           if ($key['URUTAN'] == '3') { 
                                            echo "<u>".$emp_kewenangan[$key['EMP_ID']]."</u>"; ?>
                                        </div>
                                        <div style="text-align:center;width:20%;">
                                            <?php echo $key['JABATAN'];?>
                                        </div>
                                        <?php       } 
                                    } ?>

                                    <?php } else if ($key['PGRP'] == 'T06') {
                                        if ($tot_estimasi <= 500000000) {
                                            if ($key['URUTAN'] == '2') { 
                                                echo "<u>".$emp_kewenangan[$key['EMP_ID']]."</u>"; ?>
                                            </div>
                                            <div style="text-align:center;width:20%;">
                                                <?php echo $key['JABATAN'];?>
                                            </div>
                                            <?php } 
                                        } else if($tot_estimasi > 500000000) {
                                           if ($key['URUTAN'] == '3') { 
                                            echo "<u>".$emp_kewenangan[$key['EMP_ID']]."</u>"; ?>
                                        </div>
                                        <div style="text-align:center;width:20%;">
                                            <?php echo $key['JABATAN'];?>
                                        </div>
                                        <?php       } 
                                    } 
                                } ?>

                                <?php } ?> <!-- end foreach-->

                                <?php } else { ?> <!-- SELAIN SEMEN TONASA -->
                                <?php foreach ($diajukan as $key ) {
                                 if ($key['URUTAN'] == '0') { 
                                     echo "<u>".$emp_kewenangan[$key['EMP_ID']]."</u>";
                                     ?>
                                 </div>
                                 <div style="text-align:center;width:20%;">
                                    <?php echo $key['JABATAN'];?>
                                </div>
                                <?php } } }?>
                            </div>
                            <br>
                            <div style="width:100%;">
                                <table border="1" style="width:100%; font-size:8pt;">
                                    <tr>
                                        <td style="text-align:center;">Disetujui oleh,</td>
                                    </tr>
                                    <!-- KONDISI UNTUK SEMEN TONASA -->
                                    <?php 
                                    if ($opco == '4000') { ?>
                                    <tr>
                                        <td style="height:85px;" align="center">
                                            <?php $arr_wdth = array(); 
                                            foreach ($kewenangan as $kw) { 
                                                if (!empty($kw['BATAS_HARGA']) && $kw['BATAS_HARGA']!='NULL') {
                                                    if ($kw['PGRP'] == 'T01' || $kw['PGRP'] == 'T02' || $kw['PGRP'] == 'T03' || $kw['PGRP'] == 'T04' || $kw['PGRP'] == 'T05') {
                                                        if ($tot_estimasi <= 1000000000) {
                                                            $arr_wdth[]='cek ttd';
                                                            break;
                                                        } else if ($tot_estimasi > 1000000000) {
                                                            $arr_wdth[]='cek ttd';
                                                        } else {
                                                            break;
                                                        }
                                                    } else if ($kw['PGRP'] == 'T06') {
                                                     if ($tot_estimasi <= 500000000) {
                                                        $arr_wdth[]='cek ttd';
                                                        break;
                                                    } else if ($tot_estimasi > 500000000) {
                                                        $arr_wdth[]='cek ttd';
                                                    } else {
                                                        break;
                                                    }
                                                }
                                            }
                                        }

                                        if(count($arr_wdth) == 1){
                                            $wdth = 100;
                                        }else{
                                            $wdth = 50;
                                        }

                                        foreach ($kewenangan as $kw) {
                                            ?>
                                            <div style="float:left;margin-top:60px;width:<?php echo $wdth;?>%">
                                                <?php if (!empty($kw['BATAS_HARGA']) && $kw['BATAS_HARGA']!='NULL') { ?>
                                                <?php if ($kw['PGRP'] == 'T01' || $kw['PGRP'] == 'T02' || $kw['PGRP'] == 'T03' || $kw['PGRP'] == 'T04' || $kw['PGRP'] == 'T05') { ?>
                                                <?php if ($tot_estimasi <= 1000000000) { ?>             
                                                <u><?php echo $emp_kewenangan[$kewenangan[2]['EMP_ID']]; ?></u><br> 
                                                <?php echo $kewenangan[2]['JABATAN'];
                                                break;
                                                ?>
                                                <?php } else if($tot_estimasi > 1000000000) { ?>
                                                <?php if($kw['URUTAN'] == '4' || $kw['URUTAN'] == '5') { ?>
                                                <u><?php echo $emp_kewenangan[$kw['EMP_ID']]; ?></u><br> 
                                                <?php echo $kw['JABATAN'];
                                            }
                                        } else {
                                            break;
                                        } 
                                        ?>
                                        <?php } else if($kw['PGRP'] == 'T06') { ?>
                                        <?php if ($tot_estimasi <= 500000000) { ?>                        
                                        <u><?php echo $emp_kewenangan[$kewenangan[2]['EMP_ID']]; ?></u><br> 
                                        <?php echo $kewenangan[2]['JABATAN'];
                                        break;
                                        ?>
                                        <?php } else if($tot_estimasi > 500000000) { ?>
                                        <?php if($kw['URUTAN'] == '4' || $kw['URUTAN'] == '5') { ?>
                                        <u><?php echo $emp_kewenangan[$kw['EMP_ID']]; ?></u><br> 
                                        <?php echo $kw['JABATAN'];}
                                    } else {
                                        break;
                                    }
                                    ?>
                                    <?php } ?>
                                    
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            </td>
                        </tr>

                        <?php  } else { ?>
                        <!-- SELAIN SEMEN TONASA -->

                        <tr>
                            <td style="height:85px" align="center">
                                <?php $arr_wdth = array(); 
                                foreach ($kewenangan as $kw) { 
                                    if (!empty($kw['BATAS_HARGA']) && $kw['BATAS_HARGA']!='NULL') {
                                        if ($tot_estimasi <= $kw['BATAS_HARGA']) {
                                            $arr_wdth[]='cek ttd';
                                            break;
                                        } else if ($tot_estimasi > $kw['BATAS_HARGA']) {
                                            $arr_wdth[]='cek ttd';
                                        } else {
                                            break;
                                        }
                                    }
                                }
                                if(count($arr_wdth) == 1){
                                    $wdth = 100;
                                }else if(count($arr_wdth) == 2){
                                    $wdth = 50;
                                }else if(count($arr_wdth) == 3){
                                    $wdth = 30;
                                }else if(count($arr_wdth) == 4){
                                    $wdth = 25;
                                }else{
                                    $wdth = 21;
                                }

                                foreach ($kewenangan as $kw) {
                                    ?>
                                    <div style="float:left;margin-top:60px;width:<?php echo $wdth;?>%">
                                        <?php if (!empty($kw['BATAS_HARGA']) && $kw['BATAS_HARGA']!='NULL') {?>
                                        <?php if ($tot_estimasi <= $kw['BATAS_HARGA']) { ?>                        
                                        <?php if(isset($emp_kewenangan[$kw['EMP_ID']])) { ?>
                                        <u>
                                            <?php echo $emp_kewenangan[$kw['EMP_ID']]; ?>
                                        </u><br> 
                                        <?php echo $kw['JABATAN'];
                                    }
                                    break;
                                    ?>
                                    <?php } else if($tot_estimasi > $kw['BATAS_HARGA']) { ?>
                                    <?php if(isset($emp_kewenangan[$kw['EMP_ID']])) { ?>
                                    <u>
                                        <?php echo $emp_kewenangan[$kw['EMP_ID']]; ?>
                                    </u><br> 
                                    <?php echo $kw['JABATAN'];
                                }
                            } else {
                                break;
                            }
                            ?>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
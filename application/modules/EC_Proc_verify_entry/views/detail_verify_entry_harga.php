<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <form method="post" action="<?php echo base_url() ?>Proc_verify_entry/save_harga" enctype="multipart/form-data" class="submit">
                <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_number; ?>">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $detail_ptm_snip ?>
                        <?php echo $dokumen_pr ?>
                        <?php if ($vendors != null): ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Status Penawaran Vendor
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Kode Vendor</th>
                                    <th>Nama</th>
                                    <th class="text-center">Nomor RFQ</th>
                                    <th>Status</th>
                                    <!-- <th class="text-center">Sesuai</th> -->
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($vendors as $v) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no; ?></td>
                                        <td class="text-center"><?php echo $v['PTV_VENDOR_CODE'] ?></td>
                                        <td><?php echo $v['VENDOR_NAME']; ?></td>
                                        <td class="text-center"><?php echo $v['PTV_RFQ_NO']; ?></td>
                                        <td>
                                            <?php if ($v['PTV_STATUS_EVAL'] == null) { ?> 
                                                Belum merespon
                                            <?php } else if ($v['PTV_STATUS_EVAL'] == '-1') { ?> 
                                                Tidak diikutkan
                                            <?php } else if ($v['PTV_STATUS_EVAL'] == '0') { ?> 
                                                Merespon tidak ikut
                                            <?php } else if ($v['PTV_STATUS_EVAL'] == '1') { ?>
                                                Belum Memasukkan Penawaran Harga
                                            <?php } else if ($v['PTV_STATUS_EVAL'] == '2') { ?>
                                                Sudah memasukkan penawaran Harga
                                            <?php } ?>
                                        
                                                &nbsp;&nbsp;&nbsp;<button type="button" class="snippet_detail_vendor btn btn-info btn-sm" ptv="<?php echo $v['PTV_ID'] ?>">Lihat penawaran</button>
                                            
                                        </td>
                                    </tr>
                                    <?php $no++; } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif ?>
                        <?php if($ptm['PTM_STATUS'] >= 13){
                            echo $evaluasi ;
                        } ?>
                        <?php if ($evaluasi_harga) {  ?>
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
                                                                $x = array();
                                                                foreach($pqi[$item['TIT_ID']] as $ky => $val) {
                                                                    if ($pqi[$item['TIT_ID']][$ky]['LULUS_TECH']) {  
                                                                        $x[$ky] = $pqi[$item['TIT_ID']][$ky]['PQI_PRICE'];
                                                                    }
                                                                }  
                                                                asort($x);
                                                                $ur=1;
                                                                foreach ($x as $k => $val) {
                                                                    if($ur == 1){
                                                                        $terkecil[$item['TIT_ID']][$k]=$val;
                                                                    }
                                                                    $ur++;
                                                                }

                                                                foreach ($pqi[$item['TIT_ID']] as $key => $value) {
                                                                    if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']) {
                                                                    ?>
                                                                        <th class="text-center"><strong><?php echo $ptv[$key]['VENDOR_NAME'] ?></strong></th>
                                                            <?php } }
                                                            } ?>
                                                        </thead>
                                                        <tbody class="table_evaluasi_harga">
                                                            <tr class="harga">
                                                                <td>Harga Satuan</td>
                                                                <td class="active text-center"><?php echo number_format($item['TIT_PRICE']) ?></td>
                                                                <?php
                                                                if(isset($pqi[$item['TIT_ID']])){

                                                                /* Cari PQI dengan harga yang paling rendah */ 
                                                                $price = null;
                                                                $pqi_id = null;
                                                                foreach ($pqi[$item['TIT_ID']] as $key => $value) {
                                                                    if($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                                        if (isset($pqi[$item['TIT_ID']][$key])){

                                                                            if ($price == null) {
                                                                                $price = floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']);
                                                                                $pqi_id = $pqi[$item['TIT_ID']][$key]['PQI_ID'];
                                                                            }

                                                                            if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) <= floatval($item['TIT_PRICE']) ){
                                                                                if ($price > floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) && floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                                    $price = floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']);
                                                                                    $pqi_id = $pqi[$item['TIT_ID']][$key]['PQI_ID'];
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                /* end search low PQI. e/nyo 28022017*/

                                                                    foreach ($pqi[$item['TIT_ID']] as $key => $value) {
                                                                      if($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                                        if (isset($pqi[$item['TIT_ID']][$key])): 
                                                                            ?>
                                                                        <td class="text-center <?php 
                                                                            $bg = '';
                                                                            if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > floatval($item['TIT_PRICE']) ){ 
                                                                                $bg = "bg-danger";  
                                                                            }

                                                                            if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) <= floatval($item['TIT_PRICE'])){
                                                                               if ($pqi_id == $pqi[$item['TIT_ID']][$key]['PQI_ID']) {
                                                                                    $bg = "bg-info";
                                                                               }
                                                                                
                                                                            }
                                                                            
                                                                            if(floatval($pqi[$item['TIT_ID']][$key]['PTV_STATUS_EVAL']==1)){
                                                                                $bg = "bg-warning";
                                                                            }
                                                                            echo $bg;
                                                                        ?>"
                                                                             style="<?php
                                                                                if(!$pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                                                    echo "background-color:#D2CDCD";
                                                                                }
                                                                            ?>" 
                                                                        >
                                                                        <input type="hidden" class="harga_vnd" value="<?php echo $pqi[$item['TIT_ID']][$key]['PQI_PRICE'] ?>" data-vnd="<?php echo $key ?>">

                                                                        <?php 
                                                                            if($pqi[$item['TIT_ID']][$key]['PTV_STATUS_EVAL']==1 || !$pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                                                echo "";
                                                                            }else{
                                                                                echo number_format($pqi[$item['TIT_ID']][$key]['PQI_PRICE']);
                                                                            }
                                                                        ?>
                                                                        </td>

                                                                    <?php else: ?>
                                                                        <td>-</td>
                                                                    <?php endif ?>
                                                                <?php } }
                                                                } ?>
                                                            </tr>
                                                            <tr class="totalharga">
                                                                <td class="warnung">Qty (<?php echo $item['PPI_UOM']; ?>)</td>
                                                                <td class="active text-center"><?php echo $item['TIT_QUANTITY']; ?></td>
                                                                <?php 
                                                                if(isset($pqi[$item['TIT_ID']])) {
                                                                    foreach ($pqi[$item['TIT_ID']] as $key => $value) {
                                                                        if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']) {
                                                                            if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                                            <td class="text-center <?php if (floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY']) < floatval($item['TIT_QUANTITY'])): echo "bg-warning"; endif; ?>"
                                                                                 style="<?php
                                                                                    if(!$pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                                                        echo "background-color:#D2CDCD";
                                                                                    }
                                                                                ?>" 
                                                                            >

                                                                            <?php echo $pqi[$item['TIT_ID']][$key]['PQI_QTY']; ?>
                                                                            </td>
                                                                        <?php else: ?>
                                                                            <td>-</td>
                                                                        <?php endif ?>
                                                                <?php } }
                                                                } ?>
                                                            </tr>
                                                            <tr class="totalharga">
                                                                <td class="warnung">Harga Total</td>
                                                                <td class="active text-center"><?php echo number_format($item['TIT_PRICE'] * $item['TIT_QUANTITY']) ?></td>
                                                                <?php 
                                                                if(isset($pqi[$item['TIT_ID']])) {
                                                                    foreach ($pqi[$item['TIT_ID']] as $key => $value) {
                                                                        if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']) {
                                                                            if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                                            <td class="text-center">

                                                                            <?php 
                                                                                if($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                                                    echo number_format($pqi[$item['TIT_ID']][$key]['PQI_PRICE'] * $pqi[$item['TIT_ID']][$key]['PQI_QTY']) ;
                                                                                }?>
                                                                            </td>
                                                                        <?php else: ?>
                                                                            <td>-</td>
                                                                        <?php endif ?>
                                                                <?php } }
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
                                                                if($val['PTV_STATUS_EVAL']==2){
                                                                    $x[$ky] = $pqi[$item['TIT_ID']][$ky]['PQI_PRICE'];
                                                                }
                                                            }  
                                                            asort($x);
                                                            $ur=1;
                                                            foreach ($x as $k => $val) {
                                                                if($ur == 1){
                                                                    $terkecil[$item['TIT_ID']][$k]=$val;
                                                                }
                                                                $ur++;
                                                            }

                                                            /* Cari PQI dengan harga yang paling rendah */ 
                                                                $price = null;
                                                                $pqi_id = null;
                                                                foreach ($pqi[$item['TIT_ID']] as $key => $value) {
                                                                    if($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                                        if (isset($pqi[$item['TIT_ID']][$key])){

                                                                            if ($price == null) {
                                                                                $price = floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']);
                                                                                $pqi_id = $pqi[$item['TIT_ID']][$key]['PQI_ID'];
                                                                            }

                                                                            if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) <= floatval($item['TIT_PRICE']) ){
                                                                                if ($price > floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) && floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                                    $price = floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']);
                                                                                    $pqi_id = $pqi[$item['TIT_ID']][$key]['PQI_ID'];
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                /* end search low PQI. e/nyo 28022017*/

                                                            foreach ($pqi[$item['TIT_ID']] as $key => $value) {

                                                            if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                                <td class="text-center <?php if (floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY']) < floatval($item['TIT_QUANTITY'])): echo "bg-warning"; endif; ?>">
                                                                    <?php echo floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY']); ?>
                                                                </td>
                                                                <!-- <td class="text-right <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']): echo "bg-success";  else: echo "bg-danger"; endif ?>"> -->
                                                                <td class="text-right <?php 
                                                                    $bg = '';
                                                                    if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > floatval($item['TIT_PRICE']) ){ 
                                                                        $bg = "bg-danger";  
                                                                    }

                                                                    if(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) <= floatval($item['TIT_PRICE'])){
                                                                       if ($pqi_id == $pqi[$item['TIT_ID']][$key]['PQI_ID']) {
                                                                            $bg = "bg-info";
                                                                       }
                                                                    }

                                                                    if(floatval($pqi[$item['TIT_ID']][$key]['PTV_STATUS_EVAL']==1)){
                                                                        $bg = "bg-warning";
                                                                    }

                                                                    echo $bg;                                                                    
                                                                ?>">
                                                                    <?php 
                                                                    if($pqi[$item['TIT_ID']][$key]['PTV_STATUS_EVAL']==1){
                                                                        echo "";
                                                                    }else{
                                                                        echo number_format(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE'])); 
                                                                    }
                                                                    ?>
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
                                                                <?php 
                                                                    if($pqi[$item['TIT_ID']][$key]['PTV_STATUS_EVAL']==1){
                                                                        echo "";
                                                                    }else{
                                                                        echo number_format($total[$key]) ;
                                                                    }
                                                                ?>
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
                        <?php echo $this->snippet->assignment($ptm_number) ?>
                        <?php echo $ptm_comment ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">Komentar Anda</div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <tr>
                                        <td class="col-md-3">Komentar</td>
                                        <td class="col-md-1 text-right">:</td>
                                        <td><textarea maxlength="1000" class="form-control" name="ptc_comment" id="ptc_comment"></textarea></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <select name="next_process" id="next_process_select" class="harusmilih_publicjs">
                                    <option value="false_public"></option>
                                    <!-- <option value="-1">Pilih proses lanjut</option> -->
                                    <?php if ($should_continue): ?>
                                    <option value="1">Lanjut ke <?php echo $next_process['NAMA_BARU']; ?></option>
                                    <?php endif ?>
                                    <option value="0">Retender</option>
                                </select>
                                <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                                <button type="submit" class="formsubmit main_button color7 small_btn milihtombol_publicjs" disabled title="Diperbolehkan lanjut jika minimal 2 vendor memasukkan penawaran dan waktu melebihi quotation deadline.">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<div class="modal fade" id="modal_detail_vendor_snippet">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Penawaran Vendor</h4>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $modal_vendor = $("#modal_detail_vendor_snippet");
    $modal_vendor.detach();
    $modal_vendor.appendTo('body');

    $(".snippet_detail_vendor").click(function() {
        ptv = $(this).attr('ptv');
        ptm = $("#ptm_number_vendor_ptm_snippet").val();
        show_harga = $("#show_harga_vendor_ptm_snippet").val();
        $.ajax({
            url: $("#base-url").val() + 'Snippet_ajax/tender_vendor',
            type: 'POST',
            dataType: 'html',
            data: {
                ptm: ptm,
                ptv: ptv,
                show_harga: show_harga
            },
        })
        .done(function(data) {
            // console.log(data)
            $("#modal_detail_vendor_snippet").find(".modal-body").html(data);
            $("#modal_detail_vendor_snippet").modal("show");
        })
        .fail(function(data) {
            console.log("error");
            console.log(data);
        });
    });
});
</script>

<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <form method="post" action="<?php echo base_url() ?>Proc_verify_entry/save_bidding" enctype="multipart/form-data" class="submit">
                <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_number; ?>">
                <?php if ($this->session->flashdata('warning')): ?>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Gagal Simpan!</strong> <?php echo $this->session->flashdata('warning') ?>
                    </div>
                <?php endif ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $detail_ptm_snip ?>
                        <?php echo $dokumen_pr ?>
                        <?php if ($vendors != null): ?>
                            <?php if($ptp['PTP_JUSTIFICATION_ORI'] == 5) : ?> <!-- RO -> REPEAT ORDER -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    PO
                                </div>
                                <div class="panel-body" style="width: 100%; overflow-x: auto;">
                                    <table class="table table-striped">
                                         <thead>
                                            <tr>
                                                <th colspan="2" class="text-center"><span style="color:black">VENDOR</span></th>
                                                <?php foreach ($tit as $val) : ?>
                                                    <th colspan="3" class="text-center"><span style="color:black"><?php echo $val['PPI_ID']; ?></span></th>
                                                <?php endforeach; ?>
                                            </tr>
                                            <tr>
                                                <th class="text-center">No Vendor</th>
                                                <th class="text-center">Nama Vendor</th>
                                                <?php foreach ($tit as $val) : ?>
                                                    <th class="text-center">No PO</th>
                                                    <th class="text-center">Nilai</th>
                                                    <th class="text-center">Tanggal</th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($vendors as $v) : ?>
                                            <tr>
                                                <td class="text-center"><?php echo $v['PTV_VENDOR_CODE'] ?></td>
                                                <td class="text-center"><?php echo $v['VENDOR_NAME']; ?></td>
                                                <?php foreach ($tit as $val) : ?>
                                                    <td class="text-center"><?php echo $val['NO_PO']; ?></td>
                                                    <td class="text-center"><?php echo number_format($val['NETPR']); ?></td>
                                                    <td class="text-center"><?php echo $val['TGL_PO']; ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php endif; ?>
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
                                    <th class="text-center">Verifikasi</th>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($vendors as $v) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no; ?></td>
                                        <td class="text-center"><?php echo $v['PTV_VENDOR_CODE'] ?></td>
                                        <td><?php echo $v['VENDOR_NAME']; ?></td>
                                        <td class="text-center"><?php echo $v['PTV_RFQ_NO']; ?></td>
                                        <td>
                                            <?php if ($v['PTV_STATUS'] == null) { ?> 
                                                Belum merespon
                                            <?php } else if ($v['PTV_STATUS'] == '-1') { ?> 
                                                Tidak diikutkan
                                            <?php } else if ($v['PTV_STATUS'] == '0') { ?> 
                                                Merespon tidak ikut
                                            <?php } else if ($v['PTV_STATUS'] == '1') { ?>
                                                Merespon Ikut
                                            <?php } else if ($v['PTV_STATUS'] == '2') { ?>
                                                Sudah memasukkan penawaran
                                                &nbsp;&nbsp;&nbsp;
                                                <?php if ($should_continue): ?>
                                                <?php if($ptp['PTP_EVALUATION_METHOD_ORI']==1){ $showHarga=1; } else { $showHarga=0; }?>
                                                <button type="button" class="open-detail btn btn-info btn-sm" ptv="<?php echo $v['PTV_ID'] ?>" showHarga="<?php echo $showHarga;?>">Lihat penawaran vendor</button>
                                                <?php else: ?>
                                                <button type="button" title="Belum bisa melihat penawaran vendor sebelum quotation deadline" class="btn btn-info btn-sm disabled" ptv="<?php echo $v['PTV_ID'] ?>">Lihat penawaran vendor</button>
                                                <?php endif ?>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($v['PTV_STATUS'] != 2) { ?>
                                            <input type="checkbox" disabled>
                                            <?php } else { ?>
                                            <input type="checkbox" name="check[]" value="<?php echo $v['PTV_VENDOR_CODE'] ?>" checked>
                                            <input type="hidden" name="vendor[]" value="<?php echo $v['PTV_VENDOR_CODE'] ?>">
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php $no++; } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif ?>
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
                                    <?php if ($can_continue && $should_continue): ?>
                                        <option value="1">Lanjut ke <?php echo $next_process['NAMA_BARU']; ?></option>
                                    <?php endif ?>
                                    <?php if ($should_continue): ?>
                                        <option value="0">Retender</option>
                                        <option value="999">Batal</option>
                                    <?php endif ?>
                                </select>
                                <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                                <?php if ($should_continue): ?>
                                <button type="submit" class="formsubmit main_button color7 small_btn milihtombol_publicjs" disabled title="Diperbolehkan lanjut jika minimal 2 vendor memasukkan penawaran dan waktu melebihi quotation deadline.">OK</button>
                                <?php else: ?>
                                <button type="button" class="main_button color7 small_btn" title="Diperbolehkan lanjut jika minimal 2 vendor memasukkan penawaran dan waktu melebihi quotation deadline.">OK</button>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<div class="modal fade" id="detail-vendor">
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
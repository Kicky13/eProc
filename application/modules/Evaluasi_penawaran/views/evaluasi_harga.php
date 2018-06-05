<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_number; ?>">
            <input type="hidden" id="ptm_status" value="<?php echo $ptm['MASTER_ID']; ?>">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif ?>
                    <form name="form_evaluasi_harga" id="form_evaluasi_harga" method="post" action="<?php echo base_url() ?>Evaluasi_penawaran/save_harga" class="submit">
                    <?php echo $detail_ptm ?>
                    <?php echo $vendor_ptm ?>
                    <?php echo $evaluasi ?>
                    <?php foreach ($tit as $item): ?>
                    <div class="panel-group" id="accord<?php echo $item['TIT_ID'] ?>" role="tablist">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="button" data-toggle="collapse" data-parent="#accord<?php echo $item['TIT_ID'] ?>" href="#clps<?php echo $item['TIT_ID'] ?>" aria-expanded="true">
                                Evaluasi atas material <strong><?php echo $item['PPI_DECMAT'] ?></strong>
                            </div>
                            <div id="clps<?php echo $item['TIT_ID'] ?>" class="panel-collapse collapse in">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered" data-tit="<?php echo $item['TIT_ID'] ?>">
                                        <thead>
                                            <th></th>
                                            <th class="col-md-2 text-center"><strong>HPS</strong></th>
                                            <?php foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                <th class="text-center <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                            if (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                echo "bg-success";
                                                            } else{
                                                                echo "bg-warning"; 
                                                            }
                                                        } else {
                                                            echo "bg-danger"; 
                                                        } ?>"
                                                ><strong><?php echo $ptv[$key]['VENDOR_NAME'] ?></strong></th>
                                            <?php } ?>
                                        </thead>
                                        <tbody class="table_evaluasi_harga">
                                            <input type="hidden" name="hps_terendah" class="hps_terendah" value="<?php echo $item['TIT_PRICE']; ?>">

                                            <tr class="harga">
                                                <td>Harga Satuan</td>
                                                <td class="active text-center"><?php echo number_format($item['TIT_PRICE']) ?></td>
                                                <?php foreach ($pqi[$item['TIT_ID']] as $key => $value) {
                                                    ?>
                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                        <td class="text-center <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                            if (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                echo "bg-success";
                                                            } else{
                                                                echo "bg-warning"; 
                                                            }
                                                        } else {
                                                            echo "bg-danger"; 
                                                        }
                                                        ?>">

                                                        <input type="hidden" class="harga_vnd" value="<?php echo $pqi[$item['TIT_ID']][$key]['PQI_PRICE'] ?>" data-vnd="<?php echo $key ?>">

                                                        <?php echo number_format($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>
                                            <tr class="totalharga">
                                                <td class="warnung">Qty (<?php echo $item['PPI_UOM']; ?>)</td>
                                                <td class="active text-center"><?php echo $item['TIT_QUANTITY']; ?></td>
                                                <?php 
                                                if(isset($pqi[$item['TIT_ID']])) {
                                                    foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                         <td class="text-center <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                            if (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                echo "bg-success";
                                                            } else{
                                                                echo "bg-warning"; 
                                                            }
                                                        } else {
                                                            echo "bg-danger"; 
                                                        }
                                                        ?>">
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
                                                <?php foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                        <td class="text-center <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                            if (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                echo "bg-success";
                                                            } else{
                                                                echo "bg-warning"; 
                                                            }
                                                        } else {
                                                            echo "bg-danger"; 
                                                        }
                                                        ?>">

                                                        <?php echo number_format($pqi[$item['TIT_ID']][$key]['PQI_PRICE'] * $pqi[$item['TIT_ID']][$key]['PQI_QTY']) ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>
                                            <tr class="validsampai">
                                                <td class="warnung">Valid Sampai</td>
                                                <td class="active"></td>
                                                <?php foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                        <td class="text-center <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                            if (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                echo "bg-success";
                                                            } else{
                                                                echo "bg-warning"; 
                                                            }
                                                        } else {
                                                            echo "bg-danger"; 
                                                        }
                                                        ?>">

                                                        <?php echo date('d-M-Y', oraclestrtotime($pqi[$item['TIT_ID']][$key]['PQM_VALID_THRU'])) ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>
                                            <tr class="deliverytime">
                                                <td class="warnung">Delivery Time</td>
                                                <td class="active"></td>
                                                <?php foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                        <td class="text-center <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                            if (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                echo "bg-success";
                                                            } else{
                                                                echo "bg-warning"; 
                                                            }
                                                        } else {
                                                            echo "bg-danger"; 
                                                        }
                                                        ?>">

                                                        <?php echo $pqi[$item['TIT_ID']][$key]['PQM_DELIVERY_TIME'] ?>
                                                        <?php switch ($pqi[$item['TIT_ID']][$key]['PQM_DELIVERY_UNIT']) {
                                                            case '1': echo 'Hari'; break;
                                                            case '3': echo 'Minggu'; break;
                                                            case '2': echo 'Bulan'; break;
                                                        } ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>
                                            <tr class="nilai_harga">
                                                <td class="info">Nilai Harga</td>
                                                <td class="active"></td>
                                                <?php foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                        <td class="text-center info data_vnd" data-vnd="<?php echo $key ?>">
                                                            <?php $nilainya = intval($pqi[$item['TIT_ID']][$key]['PQI_PRICE_VAL']); ?>
                                                            <span class="nilai_harga_vnd_span"><?php echo $nilainya ?></span>
                                                            <input type="hidden" class="nilai_harga_vnd" name="pqi[<?php echo $pqi[$item['TIT_ID']][$key]['PQI_ID'] ?>][priceval]" value="<?php echo $nilainya ?>">
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>

                                            <tr class="range_harga">
                                                <td class="info">Range 5%</td>
                                                <td class="active"></td>
                                                <?php foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                        <td class="text-center info data_vnd" data-vnd="<?php echo $key ?>">
                                                            <?php $nilainya = intval($pqi[$item['TIT_ID']][$key]['PQI_PRICE_VAL']); ?>
                                                            <span class="range_harga_vnd_span"><?php echo $nilainya ?></span>
                                                            <input type="hidden" class="range_harga_vnd1" name="pqi1[<?php echo $pqi[$item['TIT_ID']][$key]['PQI_ID'] ?>][priceval]" value="<?php echo $nilainya ?>">
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>

                                            <tr class="penawaran_harga">
                                                <td class="info">penawaran 5%</td>
                                                <td class="active"></td>
                                                <?php foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                        <td class="text-center info data_vnd" data-vnd="<?php echo $key ?>">
                                                            <?php $nilainya = intval($pqi[$item['TIT_ID']][$key]['PQI_PRICE_VAL']); ?>
                                                            <span class="penawaran_harga_vnd_span"><?php echo $nilainya ?></span>
                                                            <input type="hidden" class="penawaran_harga_vnd2" name="pqi2[<?php echo $pqi[$item['TIT_ID']][$key]['PQI_ID'] ?>][priceval]" value="<?php echo $nilainya ?>">
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>

                                            <tr class="catatan">
                                                <td class="info">Catatan</td>
                                                <td class="active"></td>
                                                 <?php foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                        <td class="text-center info data_vnd" data-vnd="<?php echo $key ?>">
                                                            <textarea class="form-control" name="pqi[<?php echo $pqi[$item['TIT_ID']][$key]['PQI_ID'] ?>][note]"><?php echo $pqi[$item['TIT_ID']][$key]['PRICE_NOTE'] ?></textarea>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>
                                            <tr class="validitaspenawaran">
                                                <td class="info">Validitas penawaran</td>
                                                <td class="active text-center"><input type="checkbox" class="checkAll" value="<?php echo $item['TIT_ID'] ?>"></td>
                                                <?php foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                        <td class="text-center info data_vnd" data-vnd="<?php echo $key ?>">
                                                            <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH'] && floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0): ?>
                                                            <input type="checkbox" name="pqi[<?php echo $pqi[$item['TIT_ID']][$key]['PQI_ID'] ?>][validpnawaran]" class="validity form-control check_<?php echo $item['TIT_ID'] ?>" style="height: 1.9em;">
                                                            <?php endif ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <td colspan="<?php echo count($ptv) + 2 ?>" class="text-center">
                                                    <button type="button" class="btn btn-info hitung_nilai">Hitung Nilai</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                    <?php echo $this->snippet->assignment($ptm_number) ?>
                    <div id="history_pesan">
                    <?php echo $pesan; ?>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Klarifikasi Penawaran Vendor</div>
                        <table class="table">
                            <tr>
                                <td class="col-md-3">Pilih Vendor <span style="color: #E74C3C">*</span></td>
                                <td>
                                    <select id="vendor_pesan" class="kosong">
                                        <option value="">--Pilih--</option>
                                        <?php foreach ((array)$vendor as $vnd): ?>
                                            <option value="<?php echo $vnd['PTV_VENDOR_CODE'] ?>"><?php echo $vnd['VENDOR_NAME'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Isi Klarifikasi <span style="color: #E74C3C">*</span></td>
                                <td><textarea class="form-control kosong" id="isi_pesan" /></textarea></td>
                            </tr>
                            <tr>
                                <td class="col-md-4">Lampiran (jika ada)</td>
                                <td>
                                    <input type="hidden" id="file_pesan" class="kosong">  
                                    <button type="button" required class="uploadAttachment btn btn-default">Upload File</button><span class="filenamespan"></span>
                                        &nbsp;&nbsp;
                                        <a class="btn btn-default del_upload_file glyphicon glyphicon-trash"></a>
                                    <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                        <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-left">
                                    <button type="button" id="save_chat" class="btn small_btn btn-success">Kirim</button>
                                </td>
                            </tr>  
                        </table>
                    </div>
                    <?php echo $ptm_comment ?>
                    <input type="hidden" name="ptm_number" value="<?php echo $ptm_number; ?>">
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
                                <select name="next_process" class="harusmilih_publicjs">
                                    <option value="false_public"></option>
                                    <!-- <option value="2">Simpan (tanpa lanjut proses)</option> -->
                                    <!-- update 26 mei 2016 -->
                                    <option value="2">Simpan Draft</option>
                                    <?php if ($can_continue): ?>
                                        <option value="1">Lanjut ke <?php echo $next_process['NAMA_BARU'] ?></option>
                                    <?php endif; ?>
                                    <option value="4">Penawaran Ulang</option>
                                    <option value="0">Retender</option>
                                    <?php if($ptm['SAMPUL'] != 3): ?>
                                        <option value="5">Re Evaluasi</option>
                                    <?php endif; ?>
                                    <option value="999">Batal</option>
                                </select>
                                <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                                <button type="submit" class="formsubmit main_button color7 small_btn milihtombol_publicjs" disabled>OK</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// echo "<pre>";
// print_r($nego);die;

?>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Negosiasi</h2>                
            </div>
            <form enctype="multipart/form-data" name="quotation-form" id="quotation-form" method="post" action="<?php echo base_url() ?>Negosiasi/save_bidding" class="submit">
                <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_detail['PTM_NUMBER'] ?>">
                <input type="hidden" id="nego_id" name="nego_id" value="<?php echo $nego['NEGO_ID'] ?>">
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Success!</strong> Data berhasil disimpan.
                            </div>
                        <?php endif ?>
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
                            </div>
                        <?php endif ?>

                        <?php if ($this->session->flashdata('rfc_ft_return')): ?>
                            <?php $rfc_ft_return = json_decode($this->session->flashdata('rfc_ft_return')); ?>
                            <div class="alert alert-info alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <p>FT_RETURN:</p>
                                <ul>
                                    <?php foreach ($rfc_ft_return as $key => $value): ?>
                                        <li>&nbsp;&nbsp;&nbsp;<?php echo $value->MESSAGE ?></li>
                                    <?php endforeach ?>
                                </ul>
                                <div class="hidden hasil rfc">
                                    <?php echo var_dump($rfc_ft_return) ?>
                                </div>
                            </div>
                        <?php endif ?>

                        <?php echo $detail_ptm_snip ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">Konfigurasi Negosiasi</div>
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-4 form-required">Tanggal Selesai</td>
                                    <td class="col-md-3">
                                        <div class="input-group date">
                                            <input type="text" name="nego_end" value="<?php echo empty($nego['NEGO_END']) ? '' : betteroracledate(oraclestrtotime($nego['NEGO_END'])) ?>" id="nego_end" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                    </td>
                                    <?php if ($status_nego=='process'||$status_nego=='selesai') { ?> 
                                    <td>
                                        <a class="btn btn-info btn-xs" id="update_tgl" style="font-size: 15px">Simpan Perubahan</a>
                                    </td>
                                    <?php } ?>
                                    <td class="col-md-5"> 
                                        <!-- <div class="input-group checkbox">                                            
                                            <label for="is_evaluasi_harga" title="Hasil Negosiasi akan masuk Evaluasi Harga">
                                                <input type="checkbox" name="is_evaluasi_harga" id="is_evaluasi_harga" value="1" <?php echo (isset($IS_EVALUASI_HARGA)&&$IS_EVALUASI_HARGA==1)?'checked':''; ?> <?php echo ($status_nego=='process'||$status_nego=='selesai')?'disabled="disabled"':'';?>/>
                                                Masuk Evaluasi Harga                                                
                                            </label>
                                            
                                        </div> -->
                                    </td>
                                </tr>
                                <?php
                                if(!empty($nego['DOC_NEGO'])){
                                    ?>
                                    <tr>
                                        <td class="col-md-4">Dokumen Nego Lama</td>
                                        <td class="col-md-3" colspan="3">
                                            <a target="_blank" href="<?php echo base_url() ?>upload/doc_nego/<?php echo $nego['DOC_NEGO']; ?>"> <span class="glyphicon glyphicon-file"></span> <?php echo $nego['DOC_NEGO']; ?> </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td class="col-md-4">Upload Dokumen Nego</td>
                                    <td class="col-md-3">
                                        <input type="file" name="DOC_NEGO" id="DOC_NEGO">
                                    </td> 
                                    <td>
                                        <a class="btn btn-info btn-xs" id="update_DOC_NEGO" style="font-size: 15px">Simpan Perubahan</a>
                                    </td>
                                    <td class="col-md-5"> 
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">Pesan Negosiasi</div>
                            <div class="panel-body">
                                <textarea class="form-control" name="pesan_nego" placeholder="Masukkan pesan nego"></textarea>
                            </div>
                        </div>

                        <?php /*itemize*/ if ($ptp['PTP_IS_ITEMIZE'] == 1): ?>                        
                        <?php foreach ($tits as $val): ?>                            
                            <div class="panel panel-default">
                                <div class="panel-heading">Rekap Nego atas Item <strong><?php echo $val['PPI_DECMAT'] ?></strong></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th>Vendor</th>
                                            <th>Qty (<?php echo $val['PPI_UOM'] ?>)</th>
                                            <th class="text-right">ECE</th>
                                            <th class="text-right">Penawaran</th>
                                            <th class="text-right">Nego</th>
                                            <th>Vnd Qty</th>
                                            <th class="text-right"><strong>Total ECE</strong></th>
                                            <th class="text-right"><strong>Total Penawaran</strong></th>
                                            <th class="text-right"><strong>Total Nego</strong></th>
                                        </thead>
                                        <?php if(array_key_exists($val['TIT_ID'],$ptqi)){ ?>
                                        <tbody>                                                      

                                            <?php foreach ($ptqi[$val['TIT_ID']] as $key => $pqi): ?>                                            
                                                <tr>
                                                    <td>
                                                        <?php //echo '<label><input type="checkbox" class="cekvendor" name="vendor_ikut['.$vendors[$key]['PTV_VENDOR_CODE'].']" value="'.$vendors[$key]['PTV_VENDOR_CODE'].'" '.($vendors[$key]['PTV_IS_NEGO']==1?'checked':'').'></label>';?>
                                                        <?php echo $vendors[$key]['VENDOR_NAME'] ?></td>
                                                        <td><?php echo $val['TIT_QUANTITY'] ?></td>
                                                        <td class="text-right"><?php echo number_format($val['TIT_PRICE']) ?></td>
                                                        <td class="text-right"><?php echo number_format($pqi['PQI_PRICE']) ?></td>
                                                        <td class="text-right <?php echo ($status_nego=='process'||$status_nego=='selesai')?($status_vendor[$val['TIT_ID']][$key]=='sudah'?'success':'danger'):'';?>"><?php echo ($status_nego=='process'||$status_nego=='selesai')?$status_vendor[$val['TIT_ID']][$key]: number_format($pqi['PQI_FINAL_PRICE']); ?></td>
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
                            <?php /*paket*/ else: ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">Rekap Nego</div>
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
                                                        <?php  //echo '<input type="checkbox" class="cekvendor form-control input-sm" name="vendor_ikut['.$val['PTV_VENDOR_CODE'].']" value="'.$val['PTV_VENDOR_CODE'].'" title="Centang untuk membuka nego" '.($val['PTV_IS_NEGO']==1?'checked':'').' >';?>
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
                                                <?php $total = array(); ?>
                                                <?php foreach ($tits as $val): ?>
                                                    <tr>
                                                        <td><strong><?php echo $val['PPI_DECMAT'] ?></strong></td>
                                                        <td><?php echo $val['TIT_QUANTITY'] ?></td>
                                                        <td><?php echo $val['PPI_UOM'] ?></td>
                                                        <td class="text-right"><?php echo number_format($val['TIT_PRICE']) ?></td>
                                                        <?php foreach ($ptqi[$val['TIT_ID']] as $key => $pqi): ?>                                                    
                                                            <td class="text-right" title="Harga Penawaran"><?php echo !empty($pqi['PQI_PRICE'])?number_format($pqi['PQI_PRICE']):'' ?></td>
                                                            <td class="text-right <?php echo ($status_nego=='process'||$status_nego=='selesai')?($status_vendor[$val['TIT_ID']][$key]=='sudah'?'success':'danger'):'';?>" title="Harga Nego"><?php if ($status_nego=='process'||$status_nego=='selesai') { echo $status_vendor[$val['TIT_ID']][$key]; } else if (!empty($pqi['PQI_FINAL_PRICE'])) { echo number_format($pqi['PQI_FINAL_PRICE']); }?></td>
                                                            <?php @$total[$key]['PENAWARAN'] = isset($total[$key]['PENAWARAN']) ? $total[$key]['PENAWARAN'] + $pqi['PQI_PRICE'] * $val['TIT_QUANTITY'] : $pqi['PQI_PRICE'] * $val['TIT_QUANTITY'] ?>
                                                            <?php @$total[$key]['NEGO'] = isset($total[$key]['NEGO']) ? $total[$key]['NEGO'] + $pqi['PQI_FINAL_PRICE'] * $val['TIT_QUANTITY'] : $pqi['PQI_FINAL_PRICE'] * $val['TIT_QUANTITY'] ?>
                                                        <?php endforeach ?>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3"><strong>Total</strong></td>
                                                    <td class="text-right"><strong><?php echo number_format($val['TIT_QUANTITY'] * $val['TIT_PRICE']) ?></strong></td>
                                                    <?php foreach ($total as $tot): ?>
                                                        <td class="text-right"><strong><?php echo number_format($tot['PENAWARAN']) ?></strong></td>
                                                        <td class="text-right"><strong><?php echo number_format($tot['NEGO']) ?></strong></td>
                                                    <?php endforeach ?>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            <?php endif ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">Rekap Pesan Negosiasi</div>
                                <table class="table table-hover">
                                    <thead>
                                        <th class="col-md-1 text-center">No</th>
                                        <th class="col-md-2 text-center">Tanggal</th>
                                        <th class="col-md-2">Dari</th>
                                        <th class="">Pesan</th>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach ((array)$nego_msg as $nego) { ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no?></td>
                                            <td class="text-center"><?php echo betteroracledate(oraclestrtotime($nego['PTNS_CREATED_DATE'])) ?></td>
                                            <?php if ($nego['PTNS_CREATED_BY'] != '') { ?>
                                            <td><?php $emp = $this->adm_employee->find($nego['PTNS_CREATED_BY']); echo $emp['FULLNAME']; ?></td>
                                            <?php } else { ?>
                                            <td><?php echo isset($vendors[$nego['PTV_VENDOR_CODE']]) ? $vendors[$nego['PTV_VENDOR_CODE']]['VENDOR_NAME'] : $nego['PTV_VENDOR_CODE'] ?></td>
                                            <?php } ?>
                                            <td><?php echo $nego['PTNS_NEGO_MESSAGE'];?></td>
                                        </tr>
                                        <?php $no++; } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php echo $evaluasi; ?>
                            <?php if($ptp['PTP_JUSTIFICATION_ORI'] == 5) : ?> <!-- Penunjukan Langsung - Repeat Order (RO) -->
                                <?php echo $tit_po; ?>
                            <?php endif; ?>
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
                                    <!-- <tr>
                                        <td class="col-md-3">Attachment</td>
                                        <td class="col-md-1 text-right">:</td>
                                        <td><input type='file' class="form-control" name ="ptc_attachment" id="ptc_attachment" /></td>
                                    </tr> -->
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <a href="<?php echo base_url('Negosiasi') ?>" class="main_button color7 small_btn">Kembali</a>    
                                <?php if($status_nego!='process'):?>
                                    <select name="next_process">
                                        <?php if(!isset($NEGO_END)):?>
                                            <option value="0">Buka Negosiasi</option>
                                            <!-- <option value="2">Lanjutkan analisa kewajaran harga</option> -->
                                        <?php else:?>
                                            <option value="1">Tutup Negosiasi</option>
                                        <?php endif ?>
                                    </select>
                                    <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                                    <button type="submit" class="formsubmit main_button color6 small_btn">OK</button>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
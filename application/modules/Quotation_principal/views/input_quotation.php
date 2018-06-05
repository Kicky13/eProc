<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Input Penawaran</h2>
            </div>
            <input type="hidden" id="is_itemize" value="<?php echo $ptp['PTP_IS_ITEMIZE'] ?>">
            <input type="hidden" id="warning_ori" value="<?php echo $ptp['PTP_WARNING_ORI'] ?>">
            <form id="quoform" method="post" action="<?php echo base_url() ?>Quotation_principal/save_bidding" enctype="multipart/form-data" class="submit">
                <input type="hidden" name="is_itemize" value="<?php echo $is_itemize; ?>" class="is_itemize">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo url_encode($ptm_number) ?>">
                        <input type="hidden" name="tgl_batasPenawaran" value="<?php echo $ptp['PTP_REG_CLOSING_DATE_RG']; ?>">
                        <?php echo $detail_ptm ?>
                        <?php echo $dokumen_pr ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Penawaran
                            </div>
                            <table class="table table-hover">
                                <tr>
                                    <td class=" col-md-3">Surat</td>
                                    <td class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php if(!$viewSubmitted){ ?>
                                                    <input type="text" name="pqm_number" class="form-control" id="pqm_number" value="<?php echo $pqm_id == null ? '' : $pqm['PQM_NUMBER'] ?>" Placeholder="Nomor Surat">
                                                <?php } else { ?>
                                                    <input type="text" name="pqm_number" class="form-control" id="pqm_number" value="<?php echo $pqm_id == null ? '' : $pqm['PQM_NUMBER'] ?>" Placeholder="Nomor Surat" disabled>
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-4">
                                            <?php  
                                                if($pqm_id != null) 
                                                    if($pqm['FILE_SURAT'] != null){
                                            ?>
                                                <input type="hidden" class="delete" name="deletefilesurat" value="0">
                                                <a href="<?php echo base_url('Quotation_principal'); ?>/viewDok/<?php echo $pqm['FILE_SURAT']; ?>" class="previousfile" target="_blank" >
                                                    File Exist
                                                </a>
                                                <a href="#!" onclick="deletefile(this)" class="previousfile"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                            <?php } ?>
                                            <?php if(!$viewSubmitted){ ?>
                                                <input type="file" class="form-control inputfile" name="file_surat" id="file_surat">
                                            <?php } else { ?>
                                                <input type="file" class="form-control inputfile" name="file_surat" id="file_surat" disabled>
                                            <?php } ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php foreach (array('penawaran', 'pelaksanaan', 'pemeliharaan') as $jam): ?>
                                    <?php if ($ptp['PTP_PERSEN_'.strtoupper($jam)] != ''): ?>
                                    <tr>
                                        <td class="">Jaminan <?php echo ucfirst($jam) ?> <?php echo $ptp['PTP_PERSEN_'.strtoupper($jam)] ?>%</td>
                                        <td>
                                            <div class="row" >
                                                <div class="col-md-3">
                                                    <input class="yesrad" type="radio" id="chkYes_<?php echo $jam?>" value="1" name="pqm_<?php echo $jam ?>" onclick="<?php echo $jam?>_ShowHideDiv()" checked>
                                                    Ya
                                                </div>
                                                <div class="col-md-3"> 
                                                    <input class="norad" type="radio" id="chkNo_<?php echo $jam?>" value="0" name="pqm_<?php echo $jam ?>" onclick="<?php echo $jam?>_ShowHideDiv()">
                                                    Tidak
                                                </div>
                                                <div class="col-md-4" id="dvshowme_<?php echo $jam?>">
                                                    <?php if ($pqm_id != null && !empty($pqm['PQM_FILE_'.strtoupper($jam)])): ?>
                                                        <input id="<?php echo $jam?>_k1" type="hidden" class="delete" name="deletejaminan[<?php echo strtoupper($jam) ?>] ?>]" value="0">
                                                        <a href="<?php echo base_url('Quotation_principal'); ?>/viewDok/<?php echo $pqm['PQM_FILE_'.strtoupper($jam)] ?>" class="previousfile" target="_blank" >
                                                            File Exist
                                                        </a>
                                                        <a href="#!" onclick="deletefile(this)" class="previousfile"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                                    <?php endif ?>
                                                    <input id="<?php echo $jam?>_k2" type="file" class="form-control inputfile" value="1" name="file_<?php echo $jam ?>" id="file_<?php echo $jam ?>">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endif ?>
                                <?php endforeach ?>
                                <tr>
                                    <td class="">Kandungan Lokal</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <?php if(!$viewSubmitted){ ?>
                                                        <input type="text" name="pqm_local_content" id="pqm_local_content" class="form-control r_number" value="<?php echo $pqm_id == null ? '' : $pqm['PQM_LOCAL_CONTENT'] ?>">
                                                    <?php } else { ?>
                                                        <input type="text" name="pqm_local_content" id="pqm_local_content" class="form-control r_number" value="<?php echo $pqm_id == null ? '' : $pqm['PQM_LOCAL_CONTENT'] ?>" disabled>
                                                    <?php } ?>
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class=" form-required">Waktu Pengiriman</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <?php if(!$viewSubmitted){ ?>
                                                    <input type="text" name="pqm_delivery_time" class="form-control r_number" id="pqm_delivery_time" value="<?php echo $pqm_id == null ? '' : $pqm['PQM_DELIVERY_TIME'] ?>" required>
                                                <?php } else { ?>
                                                    <input type="text" name="pqm_delivery_time" class="form-control r_number" id="pqm_delivery_time" value="<?php echo $pqm_id == null ? '' : $pqm['PQM_DELIVERY_TIME'] ?>" disabled>
                                                <?php } ?>

                                            </div>
                                            <div class="col-md-2">
                                                <?php if(!$viewSubmitted){ ?>
                                                    <select name="pqm_delivery_unit" id="pqm_delivery_unit" class="form-control">
                                                <?php } else { ?>
                                                    <select name="pqm_delivery_unit" id="pqm_delivery_unit" class="form-control" disabled>
                                                <?php } ?>
                                                        <option value="1" <?php echo $pqm_id != null && $pqm['PQM_DELIVERY_UNIT'] == 1 ? 'selected' : '' ?>>Hari</option>
                                                        <option value="3" <?php echo $pqm_id != null && $pqm['PQM_DELIVERY_UNIT'] == 3 ? 'selected' : '' ?>>Minggu</option>
                                                        <option value="2" <?php echo $pqm_id != null && $pqm['PQM_DELIVERY_UNIT'] == 2 ? 'selected' : '' ?>>Bulan</option>
                                                    </select>
                                            </div>
                                            <div class="col-md-12">
                                                <span class="text-warning">waktu pengiriman dimulai dari tanggal PO dengan perhitungan hari kalender</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-required" title="Tanggal validity harga">Validity Harga Penawaran</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <?php if(!$viewSubmitted){ ?>
                                                    <div class="input-group date">
                                                        <input type="text" name="pqm_valid_thru" id="pqm_valid_thru" class="form-control col-md-3" value="<?php echo $pqm_id == null ? '' : date('Y-m-d', oraclestrtotime($pqm['PQM_VALID_THRU'])) ?>" required><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="input-group">
                                                        <input type="text" name="pqm_valid_thru" id="pqm_valid_thru" class="form-control col-md-3" value="<?php echo $pqm_id == null ? '' : date('Y-m-d', oraclestrtotime($pqm['PQM_VALID_THRU'])) ?>" disabled><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">Catatan</td>
                                    <td>
                                        <?php if(!$viewSubmitted){ ?>
                                            <textarea name="pqm_notes" id="pqm_notes"><?php echo $pqm_id == null ? '' : $pqm['PQM_NOTES'] ?></textarea>
                                        <?php } else { ?>
                                            <textarea name="pqm_notes" id="pqm_notes" disabled><?php echo $pqm_id == null ? '' : $pqm['PQM_NOTES'] ?></textarea>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td class="">Mata Uang</td>
                                    <td>IDR</td>
                                    <input type="hidden" name="pqm_currency" id="pqm_currency" value="IDR">
                                </tr> -->
                                <tr class="hidden">
                                    <td class="">Inco Term</td>
                                    <td>
                                        <select name="pqm_incoterm" id="pqm_incoterm">
                                            <option value="1">FRC</option>
                                            <option value="2">Dunno..</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <input type="hidden" id="justification" value="<?php echo $ptp['PTP_JUSTIFICATION_ORI'] ?>">
                        </div>
                        <?php if($ptp['PTP_JUSTIFICATION_ORI'] == 5) : ?> <!-- Penunjukan Langsung - Repeat Order (RO) -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    PO
                                </div>
                                <div class="panel-body" style="width: 100%; overflow-x: auto;">
                                    <table class="table table-striped">
                                         <thead>
                                            <tr>
                                                <?php foreach ($tits as $val) : ?>
                                                    <th colspan="4" class="text-center"><span style="color:black"><?php echo $val['PPI_ID']; ?></span></th>
                                                <?php endforeach; ?>
                                            </tr>
                                            <tr>
                                                <?php foreach ($tits as $val) : ?>
                                                    <th class="text-center">Kode</th>
                                                    <th class="text-center">No PO</th>
                                                    <th class="text-center">Nilai</th>
                                                    <th class="text-center">Tanggal</th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <?php foreach ($tits as $val) : ?>
                                                    <td class="text-center"><?php echo $val['PPI_NOMAT']; ?></td>
                                                    <td class="text-center"><?php echo $val['NO_PO']; ?></td>
                                                    <td class="text-center"><?php echo number_format($val['NETPR']); ?></td>
                                                    <td class="text-center"><?php echo $val['TGL_PO']; ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">Masukkan Penawaran Item Komersial</div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <th title="Centang untuk memilih item yang ditawarkan">No</th>
                                            <th class="text-center"><?php echo $ptm_detail['IS_JASA']==1? 'No PR' : 'Kode'; ?></th>
                                            <th class="text-center">Spesifikasi</th>
                                            <th class="text-left">Jumlah</th>
                                            <th class="text-center">UoM</th>
                                            <th class="text-center">Spesifikasi Penawaran</th>
                                            <th class="<?php echo $ptp['PTP_EVALUATION_METHOD_ORI'] == 3 ? "hidden" : "" ?>">Harga Satuan</th>
                                            <th class="<?php echo $ptp['PTP_EVALUATION_METHOD_ORI'] == 3 ? "hidden" : "" ?>" nowrap>Sub Total</th>
                                            <th class="<?php echo $ptp['PTP_EVALUATION_METHOD_ORI'] == 3 ? "hidden" : "" ?>">Currency</th>
                                        </thead>
                                        <tbody id="itemtable">
                                            <?php $num=0;foreach ($tits as $row) { ?>
                                            <?php $thispqi = ($pqm_id != null && isset($pqi[$row['TIT_ID']])) ? $pqi[$row['TIT_ID']] : null; ?>
                                            <tr id="tritem<?php echo $row['TIT_ID']; ?>" class="tritem">
                                                <td nowrap>
                                                    <?php if(!$viewSubmitted){ ?>
                                                        <?php $checked = (($pqm_id == null) || ($thispqi != null)) ? 'checked' : ''; ?>
                                                        <input type="checkbox" name="check[]" class="cekitem <?php echo $ptp['PTP_IS_ITEMIZE'] == 0 ? 'hidden' : '' ?>" value="<?php echo $row['TIT_ID'] ?>" <?php echo $checked ?>>
                                                        <?php echo $num + 1 ?>
                                                   <?php } else { ?>
                                                        <?php $checked = (($pqm_id == null) || ($thispqi != null)) ? 'checked' : ''; ?>
                                                        <input type="checkbox" name="check[]" class="cekitem <?php echo $ptp['PTP_IS_ITEMIZE'] == 0 ? 'hidden' : '' ?>" value="<?php echo $row['TIT_ID'] ?>" <?php echo $checked ?> disabled>
                                                        <?php echo $num + 1 ?>
                                                    <?php } ?>

                                                </td>
                                                <td nowrap>
                                                    <?php echo $ptm_detail['IS_JASA']==1? $row['PPI_PRNO']: $row['PPI_NOMAT']; ?>
                                                    <input name="ptqi[<?php echo $row['TIT_ID'] ?>][tit_id]" class="hidden tit_id" value="<?php echo $row['TIT_ID']; ?>">
                                                    <input name="ptqi[<?php echo $row['TIT_ID'] ?>][ppi_id]" class="hidden" value="<?php echo $row['PPI_ID']; ?>">
                                                    <input type="hidden" class="PPI_NOMAT" value="<?php echo $row['PPI_NOMAT']; ?>">
                                                    <input type="hidden" class="PPI_ID" value="<?php echo $row['PPI_ID']; ?>">
                                                    <input type="hidden" class="cek_dordor" value="false">
                                                    <input type="hidden" class="cek_warning">
                                                </td>

                                                <td class="open-material">
                                                    <a href="#!"><?php echo $row['PPI_DECMAT']; ?></a>
                                                </td>

                                                <td>
                                                    <?php if(!$viewSubmitted){
                                                        if ($is_itemize == "1"):?>
                                                            <span><?php echo $row['TIT_QUANTITY'] ?></span>
                                                            <input type="hidden" name="qty[<?php echo $row['TIT_ID']; ?>]" value="<?php echo $thispqi == null ? $row['TIT_QUANTITY'] : $thispqi['PQI_QTY'] ?>" class="pqi_quan text-right qtywow col-xs-12">
                                                        <?php else: ?>
                                                            <span><?php echo $row['TIT_QUANTITY'] ?></span>
                                                            <input type="hidden" name="qty[<?php echo $row['TIT_ID']; ?>]" value="<?php echo $row['TIT_QUANTITY'] ?>" class="pqi_quan text-right qtywow col-xs-12">
                                                        <?php endif ?>
                                                        <input type="hidden" class="defprice" value="<?php echo $row['TIT_QUANTITY'] ?>">
                                                    <?php } else { ?>
                                                        <input type="text" name="qty[<?php echo $row['TIT_ID']; ?>]" value="<?php echo $thispqi == null ? $row['TIT_QUANTITY'] : $thispqi['PQI_QTY'] ?>" class="pqi_quan text-right qtywow col-xs-12" disabled>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <span><?php echo $row['PPI_UOM'] == '10' ? 'D' : $row['PPI_UOM'] ?></span>
                                                </td>
                                                <td>
                                                    <?php if(!$viewSubmitted){ ?>
                                                        <textarea maxlength="2000" name="ptqi[<?php echo $row['TIT_ID'] ?>][pqi_description]" class="pqi_desc form-control pqi_description" maxlength="2000" required <?php echo $checked == ''? 'disabled' : '';?> ><?php echo $thispqi == null ? '' : $thispqi['PQI_DESCRIPTION'] ?></textarea>
                                                    <?php } else { ?>
                                                        <textarea name="ptqi[<?php echo $row['TIT_ID'] ?>][pqi_description]" class="pqi_desc form-control pqi_description" maxlength="2000" disabled <?php echo $checked == ''? 'disabled' : '';?> ><?php echo $thispqi == null ? '' : $thispqi['PQI_DESCRIPTION'] ?></textarea>
                                                    <?php } ?>
                                                </td>
                                                
                                                <td class="<?php echo $ptp['PTP_EVALUATION_METHOD_ORI'] == 3 ? "hidden" : "" ?>">
                                                    <?php if(!$viewSubmitted){ ?>
                                                        <input type="text" name="ptqi[<?php echo $row['TIT_ID'] ?>][pqi_price]" class="pqi_price text-right col-xs-12" value="<?php echo $thispqi == null ? '0' : $thispqi['PQI_PRICE'] ?>" required>                     
                                                    <?php } else { ?>
                                                        <input type="text" name="ptqi[<?php echo $row['TIT_ID'] ?>][pqi_price]" class="pqi_price text-right col-xs-12" value="<?php echo $thispqi == null ? '0' : $thispqi['PQI_PRICE'] ?>" disabled>                     
                                                    <?php } ?>
                                                    <input type="hidden" class="netprice" value="<?php echo $row['NETPR']; ?>">
                                                </td>

                                                <td class="<?php echo $ptp['PTP_EVALUATION_METHOD_ORI'] == 3 ? "hidden" : "" ?> text-right">
                                                    <span class="subtot hidden">0</span><span class="subtot_tampil">0</span>
                                                </td>

                                                <td class="<?php echo $ptp['PTP_EVALUATION_METHOD_ORI'] == 3 ? "hidden" : "" ?>">
                                                    <?php if(!$viewSubmitted){ ?>
                                                        <select name="ptqi[<?php echo $row['TIT_ID'] ?>][pqi_currency]" class="pqi_currency">
                                                    <?php } else { ?>
                                                        <select name="ptqi[<?php echo $row['TIT_ID'] ?>][pqi_currency]" class="pqi_currency" disabled>
                                                    <?php } ?>
                                                        <option <?php echo $thispqi != null && $thispqi['PQI_CURRENCY'] == $ptm_detail['PTM_CURR'] ? 'selected' : '' ?> value="<?php echo $ptm_detail['PTM_CURR'] ?>"><?php echo $ptm_detail['PTM_CURR'] ?></option>
                                                        <?php if($vendor['VENDOR_TYPE'] == 'INTERNASIONAL'): ?>
                                                            <option <?php echo $thispqi != null && $thispqi['PQI_CURRENCY'] == 'USD' ? 'selected' : '' ?> value="USD">USD</option>
                                                            <option <?php echo $thispqi != null && $thispqi['PQI_CURRENCY'] == 'EUR' ? 'selected' : '' ?> value="EUR">EUR</option>
                                                            <option <?php echo $thispqi != null && $thispqi['PQI_CURRENCY'] == 'JPY' ? 'selected' : '' ?> value="JPY">JPY</option>
                                                        <?php endif; ?>
                                                        </select>
                                                </td>

                                            </tr>
                                            <?php $num++; } ?>
                                            <input type="hidden" id="sum_tech_row" name="sum_tech_row" value="<?php echo $num ?>">
                                        </tbody>
                                        <tfoot>
                                            <input type="hidden" id="ptv_status" value="<?php echo $ptv[0]['PTV_STATUS']; ?>"/>
                                            <input type="hidden" id="ptp_ev_met" value="<?php echo $ptp['PTP_EVALUATION_METHOD']; ?>"/>
                                        <?php if($ptv[0]['PTV_STATUS'] == 1 || $ptv[0]['PTV_STATUS'] == 2){
                                                    if($ptp['PTP_EVALUATION_METHOD'] != "2 Tahap 2 Sampul"){?>
                                                <tr>
                                                    <td colspan="7" class="text-right"><strong>Total Sebelum PPN</strong></td>
                                                    <td colspan="2" class="text-right"><strong id="total_before_ppn">0</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" class="text-right"><strong>Total Sesudah PPN</strong></td>
                                                    <td colspan="2" class="text-right"><strong id="total_after_ppn">0</strong></td>
                                                </tr>
                                                    <?php }?>
                                        <?php }else{ ?>
                                                <tr>
                                                    <td colspan="7" class="text-right"><strong>Total Sebelum PPN</strong></td>
                                                    <td colspan="2" class="text-right"><strong id="total_before_ppn">0</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" class="text-right"><strong>Total Sesudah PPN</strong></td>
                                                    <td colspan="2" class="text-right"><strong id="total_after_ppn">0</strong></td>
                                                </tr>
                                        <?php }?>
                                        
                                        </tfoot>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Upload File per Item untuk Evaluasi Teknis</div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                <?php foreach ($template_eval['detail'] as $value) { ?>    
                                                <?php if($value['PRASYARAT']!=1) { ?>    
                                                    <tr style="vertical-align: top;"> 
                                                        <td>
                                                            <strong><?php echo $value['PPD_ITEM']; ?></strong>
                                                            <?php foreach ($value['uraian'] as $list) { ?>                                                                
                                                                <?php if($list['PPTU_TYPE']!=1) { ?>
                                                                    <div class="row" style="padding: 5px;">
                                                                        <div class="col-sm-2 col-md-2 col-lg-2"><?php echo $list['PPTU_ITEM'];?></div>
                                                                        <div class="col-sm-2 col-md-2 col-lg-2">Bobot: <?php echo $list['PPTU_WEIGHT'];?></div>
                                                                    </div>
                                                                <?php } ?> 
                                                            <?php } ?>  
                                                        </td>
                                                    </tr>
                                                <?php } ?>    
                                            <?php } ?> 
                                    <table class="table table-hover">
                                        <tbody>
                                             <?php $no=1; foreach ($tits as $tit): ?>
                                            <tr>
                                                <td width="50px" align="center"><?php echo $no++; ?></td>
                                                <td><?php echo $tit['PPI_NOMAT']; ?></td>
                                                <td><?php echo $tit['PPI_DECMAT']; ?></td>
                                                <td>
                                                    <input type="hidden" id="vendor_no" name="vendor_no" value="<?php echo  $vendorno; ?>">
                                                    <?php if(!empty($pef[$tit['TIT_ID']])) : ?>
                                                        <input type="hidden" id="file_name<?php echo $tit['TIT_ID']; ?>" value="<?php echo $pef[$tit['TIT_ID']]; ?>">
                                                        <div class="col-sm-8" id="fileView">
                                                            <a href="<?php echo base_url('Quotation_principal'); ?>/viewDok/<?php echo $pef[$tit['TIT_ID']]; ?>" target="_blank" >File Exist</a> 
                                                            <?php if(!$viewSubmitted): ?>
                                                                &nbsp;&nbsp;<a class="btn btn-default glyphicon glyphicon-trash" onclick="delete_quotation_upload(<?php echo $tit['TIT_ID']; ?>)"></a>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php else :
                                                            if(!$viewSubmitted): ?>
                                                            <input type="hidden" name="id_tit[]" value="<?php echo $tit['TIT_ID']; ?>">
                                                            <div class="col-sm-8">
                                                                <input type="hidden" name="file_upload[]" class="file_upload">  
                                                                <button type="button" required class="quotation_uploadAttachment btn btn-default jasa">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                                                    &nbsp;&nbsp;<a onclick="delete_quotation_upload(<?php echo $tit['TIT_ID']; ?>)" class="btn btn-default glyphicon glyphicon-trash"></a>
                                                                    <br/>
                                                                <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                                    <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                                                </div>
                                                            </div>
                                                    <?php   else:
                                                                echo "<div class='col-sm-8'><i>tidak ada file upload.</i></div>";
                                                            endif;
                                                    endif;
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="ptp_evaluasi_teknik" name="ptp_evaluasi_teknik" value="<?php echo $ptp['PTP_EVALUASI_TEKNIS']; ?>">
                        <div class="panel panel-default">
                            <div class="panel-heading">Evaluasi Teknis Prasyarat</div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <tbody id="tbl_detail_template">
                                            <?php foreach ($template_eval['detail'] as $value) { ?>    
                                                <?php if($value['PRASYARAT']==1) { ?>    
                                                    <tr style="vertical-align: top;"> 
                                                        <td>
                                                            <strong><?php echo $value['PPD_ITEM']; ?></strong>
                                                            <?php foreach ($value['uraian'] as $list) { ?>
                                                                <?php foreach ($evatek as $ppt) {                                                                    
                                                                    if($ppt['PPTU_ID']==$list['PPTU_ID']){
                                                                        if($ppt['PQE_CHECK']==1){
                                                                            $centang = 'checked';
                                                                            $disabled = '';
                                                                            $rad = $ppt['PQE_RESPON'];
                                                                            break;
                                                                        }else{
                                                                            $centang = '';    
                                                                            $disabled = 'disabled';
                                                                            $rad = $ppt['PQE_RESPON'];
                                                                            break;
                                                                        }                                                                        
                                                                    }
                                                                } ?>
                                                                <?php if($list['PPTU_TYPE']==1) { ?>
                                                                    <div class="row" style="padding: 5px;">
                                                                        <div class="col-sm-1 col-md-1 col-lg-1"><input class="eval_cek" type="checkbox" value="<?php echo $list['PPTU_ID'];?>" name="cek_eval[]" <?php if($pqm_id != null) { echo $centang; }else{echo 'checked';}?>></div>
                                                                        <div class="col-sm-4 col-md-4 col-lg-4"><?php echo $list['PPTU_ITEM'];?></div>
                                                                        <div class="col-sm-3 col-md-3 col-lg-3">
                                                                            <label class="radio-inline"><input type="radio" name="optradio<?php echo $list['PPTU_ID'];?>" value="Ya" <?php echo $disabled;?> <?php if($rad=='Ya'){ echo "checked";}?> >Ya</label>
                                                                            <label class="radio-inline"><input type="radio" name="optradio<?php echo $list['PPTU_ID'];?>" value="Tidak" <?php echo $disabled;?> <?php if($rad=='Tidak'){ echo "checked";}?> >Tidak</label>
                                                                        </div>
                                                                    </div>
                                                                <?php }else if($list['PPTU_TYPE']==2) { ?>      
                                                                    <div class="row" style="padding: 5px;">
                                                                        <div class="col-sm-1 col-md-1 col-lg-1"><input class="eval_cek" type="checkbox" value="<?php echo $list['PPTU_ID'];?>" name="cek_eval[]" <?php if($pqm_id != null) { echo $centang; }else{echo 'checked';}?>></div>
                                                                        <div class="col-sm-4 col-md-4 col-lg-4"><?php echo $list['PPTU_ITEM'];?></div>
                                                                        <div class="col-sm-3 col-md-3 col-lg-3">
                                                                            <textarea class="form-control" rows="1" id="" name="optradio<?php echo $list['PPTU_ID'];?>" <?php echo $disabled;?>><?php if($rad!=null){echo $rad;}?></textarea>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>              
                                                            <?php } ?>  
                                                        </td>
                                                    </tr>
                                                <?php } ?>    
                                            <?php } ?>    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php echo $history_chat ?>

                        <!-- VIEW HISTORY NEGOSIASI -->

                        <div class="panel panel-default">
                            <div class="panel-heading">Pesan Negosiasi</div>
                            <table class="table table-hover">
                                <thead>
                                    <th class="col-md-1 text-center">No</th>
                                    <th class="col-md-2 text-center">Tanggal</th>
                                    <th class="col-md-2">Dari</th>
                                    <th class="">Pesan</th>
                                    <th class=""></th>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach ((array)$negos as $nego) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no?></td>
                                        <td class="text-center"><?php echo betteroracledate(oraclestrtotime($nego['PTNS_CREATED_DATE'])) ?></td>
                                        <?php if ($nego['PTNS_CREATED_BY'] != '') { ?>
                                        <td><?php $emp = $this->adm_employee->find($nego['PTNS_CREATED_BY']); echo $emp['FULLNAME']; ?></td>
                                        <?php } else { ?>
                                        <td>Vendor</td>
                                        <?php } ?>
                                        <td><?php echo $nego['PTNS_NEGO_MESSAGE'];?></td>
                                        <td></td>
                                    </tr>
                                    <?php $no++; } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Item Negosiasi</div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <thead>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center">Jumlah / Kuantitas</th>
                                        <th class="text-right">Harga Penawaran</th>
                                        <th class="text-right">Nego Sebelumnya</th>
                                        <th class="text-right">Harga Nego</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($invitation_tender_items as $key => $value) { 
                                            $nilai_def=$value['PQI_PRICE'];     
                                            if($value['PQI_FINAL_PRICE']!='0'){
                                                $nilai_def=$value['PQI_FINAL_PRICE'];
                                            }
                                            
                                        ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $value['PPI_NOMAT']; ?></td>
                                            <td><?php echo $value['PPI_DECMAT']; ?></td>
                                            <td class="text-center"><?php echo $value['TIT_QUANTITY']." ".$value['PPI_UOM']; ?></td>
                                            <td class="text-right"><?php echo number_format($value['PQI_PRICE']); ?></td>
                                            <td class="text-right"><?php echo number_format($value['PQI_FINAL_PRICE']); ?></td>
                                            <td class="text-right"><?php echo(empty($harga_nego))?'0':number_format($harga_nego[$value['TIT_ID']]); ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">File Negosiasi Harga</div>
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-2"><strong>File Upload</strong></td>
                                    <td id="fileUpload">                                     
                                        <?php if(!empty($FILE_UPLOAD)){?>
                                        <button type="button" class="btn btn-default delete_file" style="float:left;" ><i class="glyphicon glyphicon-remove"></i></button>
                                        <a href="<?php echo site_url('Nego_invitation/download_file/'.$ptnv_id); ?>" target="_blank" class="btn btn-default uploaded_file" style="float:left;" ><?php echo $FILE_UPLOAD;?></a>
                                        <?php }?>
                                    </td>                                    
                                </tr>
                            </table>
                        </div>

                        <!-- END NEGOSIASI -->

                        <!-- PO -->
                        <div class="panel panel-default">
                            <div class="panel-heading">PO</div>
                                <table class="table table-bordered" style="font-size: 10pt">
                                    <thead>
                                        <tr>
                                            <th nowrap class="text-center">Vendor/supplying plant</th>
                                            <th class="text-center">Item</th>
                                            <th class="text-center">PR No</th>
                                            <th class="text-center">Short Text</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">UoM</th>
                                            <th class="text-center">NetPrice</th>
                                            <th class="text-center">Value</th>
                                            <th class="text-center">Curr</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($item as $id => $val): ?>
                                            <?php if($id == 0): ?>
                                                <tr>
                                                    <td rowspan="<?php echo count($item) ?>" nowrap><?php echo $po_header['VND_NAME'] ?></td>
                                                    <td class="text-center"><?php echo $val['EBELP'] ?></td>
                                                    <td rowspan="<?php echo count($item) ?>" class="text-center no_po"><?php echo $val['PPR_PRNO'] ?></td>
                                                    <td nowrap><?php echo $val['POD_DECMAT'] ?><br><?php if(!is_null($val['ITEM_TEXT'])){?><i>Note: <?php echo $val['ITEM_TEXT'] ?></i><?php } ?></td>
                                                    <td class="text-right"><?php echo $val['POD_QTY'] ?></td>
                                                    <td class="text-center"><?php echo $val['UOM'] ?></td>
                                                    <td class="text-right"><?php echo number_format($val['POD_PRICE'],2,",",".") ?></td>
                                                    <td class="text-right"><?php echo number_format((intval($val['POD_PRICE']) * intval($val['POD_QTY'])),2,",",".") ?></td>
                                                    <td class="text-center"><?php echo $val['CURR'] ?></td>
                                                </tr>
                                            <?php else: ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $val['EBELP'] ?></td>
                                                    <td nowrap><?php echo $val['POD_DECMAT'] ?><br><?php if(!is_null($val['ITEM_TEXT'])){?><i>Note: <?php echo $val['ITEM_TEXT'] ?></i><?php } ?></td>
                                                    <td class="text-right"><?php echo $val['POD_QTY'] ?></td>
                                                    <td class="text-center"><?php echo $val['UOM'] ?></td>
                                                    <td class="text-right"><?php echo number_format($val['POD_PRICE'],2,",",".") ?></td>
                                                    <td class="text-right"><?php echo number_format((intval($val['POD_PRICE']) * intval($val['POD_QTY'])),2,",",".") ?></td>
                                                    <td class="text-center"><?php echo $val['CURR'] ?></td>
                                                </tr>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                                <tr>
                                                    <td class="text-right" colspan="7"><strong>TOTAL</strong></td>
                                                    <td class="text-right"><?php echo(empty($po_header))?'': number_format($po_header['TOTAL_HARGA'],2,",",".") ?></td>
                                                    <td class="text-center"><?php echo(empty($item))?'': $val['CURR'] ?></td>
                                                </tr>
                                    </tbody>
                                </table>
                        </div>
                        <!-- END PO -->

                        <input type="hidden" id="technical_item" name="technical_item">
                        <?php if($ptv[0]['PTV_TENDER_TYPE']==2){?>
                            <?php if($pqm_id == null){?>
                        <div class="well well-sm text-center">
                            <?php if(!$viewSubmitted){ ?>
                                <a href="<?php echo base_url('Quotation_principal') ?>" class="main_button color7 small_btn">Kembali</a>
                                <button type="submit" id="save_bidding" class="main_button color6 small_btn">Simpan Penawaran</button>
                            <?php } else {?>
                                <a href="<?php echo base_url('Quotation_principal') ?>/view_submittedQuotation" class="main_button color7 small_btn">Kembali</a>
                            <?php }?>
                        </div>                        
                            <?php }else{?>
                                <div class="well well-sm text-center">                   
                                    <a href="<?php echo base_url('Quotation_principal') ?>" class="main_button color7 small_btn">Kembali</a>                            
                                    <button type="submit" id="save_bidding" class="main_button color6 small_btn">Simpan Penawaran</button>
                                </div>
                            <?php }?>

                        <?php }else{?>
                        <div class="well well-sm text-center">
                            <?php if(!$viewSubmitted){ ?>
                                <a href="<?php echo base_url('Quotation_principal') ?>" class="main_button color7 small_btn">Kembali</a>
                                <?php if($ptv[0]['PTV_APPROVAL']==0){ ?>
                                <button type="submit" id="save_bidding_approve" class="main_button color6 small_btn">Approve Penawaran</button>
                                <?php }else{ ?>
                                <button type="submit" id="save_bidding" class="main_button color6 small_btn">Simpan Penawaran</button>
                                <?php } ?>
                            <?php } else {?>
                                <a href="<?php echo base_url('Quotation_principal') ?>/view_submittedQuotation" class="main_button color7 small_btn">Kembali</a>
                            <?php }?>
                        </div>                        
                        <?php }?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<div class="modal fade" id="detail-material">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detail Material</h4>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

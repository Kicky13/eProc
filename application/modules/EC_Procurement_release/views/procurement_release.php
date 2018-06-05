
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php echo form_open_multipart(base_url('EC_Procurement_release/save_bidding'), array('method' => 'POST','class' => 'submit')); ?>
            <input type="hidden" name="ptm_number" id="ptm_number" value="<?php echo $ptm['PTM_NUMBER'] ?>">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($this->session->flashdata('tambahaninfo')): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $this->session->flashdata('tambahaninfo') ?>
                        </div>
                    <?php endif ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
                        </div>
                    <?php endif ?>
                    <?php if ($this->session->flashdata('create_rfq') != false): ?>
                    <?php $create_rfq = $this->session->flashdata('create_rfq'); ?>
                    <?php $hasil_rfq = $this->session->flashdata('hasil_rfq'); ?>
                    <div class="panel panel-danger">
                        <div class="panel-body">
                            <p>Error create RFQ with message: "<?php echo $hasil_rfq['return']['MESSAGE'] ?>"</p>
                            <p>Input RFQ:</p>
                            <ul>
                                <?php foreach ($create_rfq as $key => $value): ?>
                                    <li><?php echo $key ?>: <?php echo $value ?></li>
                                <?php endforeach ?>
                            </ul>
                            <div class="hidden hasil rfq">
                                <?php echo var_dump($hasil_rfq) ?>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Informasi Pengadaan</div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-3">Creator</td>
                                <td><?php echo $ptm['PTM_REQUESTER_NAME'] ?></td>
                            </tr>
                            <!-- <tr>
                                <td>Biro / Unit</td>
                                <td><?php echo $this->session->userdata['POS_NAME'] ?></td>
                            </tr> -->
                            <tr>
                                <td class="col-md-3">Nama Pengadaan</td>
                                <td>
                                    <?php echo $ptm['PTM_SUBJECT_OF_WORK'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Nomor Usulan Pratender</td>
                                <td>
                                    <?php echo $ptm['PTM_SUBPRATENDER']; ?>
                                </td>
                            </tr>
                            <?php if ($buyer != null): ?>
                            <tr>
                                <td class="col-md-4">Buyer</td>
                                <td><?php echo $buyer['FULLNAME'] ?></td>
                            </tr>
                            <?php endif ?>
                            <tr>
                                <td class="col-md-3">Jenis Pengadaan</td>
                                <td>
                                    <?php echo $ptm['IS_JASA'] == 0 ? 'Barang' : 'Jasa' ?>
                                    <input type="hidden" id="jenis_perencanaan" value="<?php echo $ptm['IS_JASA']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Status</td>
                                <td>
                                    <?php echo $ptm['PROCESS_NAME'] ?>
                                    <input type="text" name="process_name" class="hidden" value="<?php echo $ptm['PROCESS_NAME']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-4">Requestioner</td>
                                <?php $reqarray = array(); ?>
                                <?php foreach ($tit as $val): ?>
                                    <?php $reqarray[] = $val['PPR_REQUESTIONER'] . (isset($cctr[$val['PPR_REQUESTIONER']]) ? ' '.$cctr[$val['PPR_REQUESTIONER']]['LONG_DESC'] : ''); ?>
                                <?php endforeach ?>
                                <td><?php echo implode(', ', array_unique($reqarray)) ?></td>
                            </tr>
                            <?php if(!empty($ptp['PTP_UPLOAD_USULAN_VENDOR'])): ?>
                                <tr>
                                    <td>Upload Usulan Vendor</td>
                                    <td>
                                        <a href="<?php echo base_url('Monitoring_prc'); ?>/viewDok/<?php echo $ptp['PTP_UPLOAD_USULAN_VENDOR']; ?>" target="_blank" title='print usulan vendor'><span class="glyphicon glyphicon-print"></a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                    <?php echo $detail_item_ptm ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Dokumen PR
                        </div>
                        <?php if (count($dokumen) <= 0): ?>
                            <div class="panel-body">Tidak ada dokumen.</div>
                        <?php else: ?>
                        <table class="table table-hover">
                            <thead>
                                <th class="text-center col-md-1">No</th>
                                <th class="col-md-5">Nama Dokumen</th>
                                <th class="col-md-2">Tipe Dokumen</th>
                                <th class="col-md-3 text-center">Share Dokumen</th>
                            </thead>
                            <tbody id="items_table">
                                <?php $no = 0; foreach ($dokumen as $item): ?>
                                <tr>
                                    <td class="text-center"><?php echo ($no + 1) ?></td>
                                    <td>
                                    <li style="list-style-type: none;">
                                        <a href="<?php echo base_url('Procurement_sap'); ?>/viewDok/<?php echo $item['nama']; ?>" target="_blank">
                                        <span class="glyphicon glyphicon-file"></span> <?php echo $item['PPD_DESCRIPTION']; ?></a>
                                    </li>
                                    </td>
                                    <td><?php echo $item['PDC_NAME']; ?></td>
                                    <td>
                                        <?php if($item['PDC_IS_PRIVATE'] == "1") {?>
                                            <div class="col-md-12 text-center">
                                                <label>Not Share</label>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-md-6 text-right">
                                                <input id="itemise_2" type="radio" name="share[<?php echo str_replace(".","_",$item['nama']) ?>]" value="1" <?php echo $item['IS_SHARE'] === '1' ? 'checked' : '' ?> <?php if($item['PDC_IS_PRIVATE'] == "1") echo "hidden";?> > <?php if($item['PDC_IS_PRIVATE'] == "1") echo ""; else echo "Share" ?>
                                            </div>
                                            <div class="col-md-6">
                                                <input id="itemise_3" type="radio" name="share[<?php echo str_replace(".","_",$item['nama']) ?>]" value="0" <?php echo $item['IS_SHARE'] === '0' ? 'checked' : '' ?> <?php if($item['PDC_IS_PRIVATE'] == "1") echo "hidden";?>> <?php if($item['PDC_IS_PRIVATE'] == "1") echo ""; else echo "Not Share" ?>
                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3">
                                    <ul>
                                        <?php foreach ($item['item'] as $key => $value): ?>
                                            <li>
                                                <?php echo $value['NOMAT'];?>
                                                <?php echo $value['DECMAT'];?>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                    </td>
                                </tr>
                                <?php $no++; endforeach ?>
                            </tbody>
                        </table>
                        <?php endif ?>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Tambahan</div>
                        <table class="table">
                            <tr title="Dokumen tambahan yang di share ke vendor, selain dokumen item pr. Menempel pada level pengadaan">
                                <td class="col-md-3">Dokumen pengadaan</td>
                                <td class="divfiles">   
                                    <?php foreach ($dokumentambahan as $key => $value): ?>
                                        <a href="<?php echo base_url('Monitoring_prc') ?>/viewDok/<?php echo $value['FILE']; ?>" target="_blank"><span class="glyphicon glyphicon-file"></span> <?php echo $value['NAME'] == '' ? $value['FILE'] : $value['NAME'] ?></a><br>
                                    <?php endforeach ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Metode Pengadaan</div>
                        <table class="table table-hover">
                            
                            <tr>
                                <td class="col-md-3">Mekanisme Pengadaan</td>
                                <td>
                                    <?php echo $ptp['PTP_JUSTIFICATION'] ?>
                                    <input type="hidden" name="ptp_justification" id="ptp_justification" value="<?php echo $ptp['PTP_JUSTIFICATION_ORI']?>">
                                </td>
                            </tr>
                            <tr id="is_itemize">
                                <td class="col-md-3 form-required">Metode Penawaran</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="radio" value="1" name="is_itemize" class="is_itemize" <?php echo $ptp['PTP_IS_ITEMIZE'] === '1' ? 'checked' : '' ?>> Itemize
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" value="0" name="is_itemize" class="is_itemize" <?php echo $ptp['PTP_IS_ITEMIZE'] === '0' ? 'checked' : '' ?>> Paket
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3 form-required">Sistem Sampul</td>
                                <td>
                                    <select name="ptp_evaluation_method" class="repeat_order_method">
                                        <?php if($ptp['PTP_EVALUATION_METHOD'] == "1 Tahap 1 Sampul"){?>
                                            <option value="1" selected>1 Tahap 1 Sampul</option>
                                            <option value="2">2 Tahap 1 Sampul</option>
                                            <option value="3">2 Tahap 2 Sampul</option>
                                        <?php } else if($ptp['PTP_EVALUATION_METHOD'] == "2 Tahap 1 Sampul"){?>
                                            <option value="1">1 Tahap 1 Sampul</option>
                                            <option value="2" selected>2 Tahap 1 Sampul</option>
                                            <option value="3">2 Tahap 2 Sampul</option>
                                        <?php }else {?>
                                            <option value="1">1 Tahap 1 Sampul</option>
                                            <option value="2">2 Tahap 1 Sampul</option>
                                            <option value="3" selected>2 Tahap 2 Sampul</option>
                                        <?php } ?>

                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3 form-required">Sistem Peringatan pada Penawaran</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select name="ptp_warning" class="repeat_order" id="ptp_warning">
                                                <option value="1" <?php echo $ptp['PTP_WARNING_ORI'] == 1 ? 'selected' : '' ?>>Tidak ada pesan</option>
                                                <option value="2" <?php echo $ptp['PTP_WARNING_ORI'] == 2 ? 'selected' : '' ?>>Warning</option>
                                                <option value="3" <?php echo $ptp['PTP_WARNING_ORI'] == 3 ? 'selected' : '' ?>>Error</option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Prosentase Batas Atas Penawaran ECE/HPS/OE</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="text" name="ptp_batas_penawaran"class="form-control repeat_order" value="<?php echo $ptp['PTP_BATAS_PENAWARAN'] ?>">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Prosentase Batas Bawah Penawaran ECE/HPS/OE</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="text" name="ptp_batas_penawaran_bawah"class="form-control repeat_order" value="<?php echo $ptp['PTP_BAWAH_PENAWARAN'] ?>">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="ro_hide">
                                <td class="col-md-3 form-required">Sistem Peringatan pada Negosiasi</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select name="ptp_warning_nego" id="ptp_warning_nego">
                                                <option value="1" <?php echo $ptp['PTP_WARNING_NEGO_ORI'] == '1' ? 'selected' : '' ?>>Tidak ada pesan</option>
                                                <option value="2" <?php echo $ptp['PTP_WARNING_NEGO_ORI'] == '2' ? 'selected' : '' ?>>Warning</option>
                                                <option value="3" <?php echo $ptp['PTP_WARNING_NEGO_ORI'] == '3' ? 'selected' : '' ?>>Error</option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="ro_hide">
                                <td class="col-md-3">Prosentase Batas Atas Nego ECE/HPS/OE</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="text" name="ptp_batas_nego"class="form-control" value="<?php echo $ptp['PTP_BATAS_NEGO'] ?>">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3 form-required">Tipe RFQ</td>
                                <td>
                                    <select name="ptm_rfq_type">
                                        <?php foreach ($rfq_type as $val): ?>
                                        <option value="<?php echo $val['TYPE'] ?>" <?php echo $ptm['PTM_RFQ_TYPE'] == $val['TYPE'] ? 'selected' : '' ?>><?php echo $val['TYPE'] . ' (' . $val['DESC'] . ')' ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3 form-required">Currency</td>
                                <td>
                                    <select name="ptm_curr">
                                        <option value="IDR" <?php echo $ptm['PTM_CURR'] == 'IDR' ? 'selected' : '' ?>>IDR</option>
                                        <option value="EUR" <?php echo $ptm['PTM_CURR'] == 'EUR' ? 'selected' : '' ?>>EUR</option>
                                        <option value="USD" <?php echo $ptm['PTM_CURR'] == 'USD' ? 'selected' : '' ?>>USD</option>
                                        <option value="AUD" <?php echo $ptm['PTM_CURR'] == 'AUD' ? 'selected' : '' ?>>AUD</option>
                                        <option value="GBP" <?php echo $ptm['PTM_CURR'] == 'GBP' ? 'selected' : '' ?>>GBP</option>
                                        <option value="JPY" <?php echo $ptm['PTM_CURR'] == 'JPY' ? 'selected' : '' ?>>JPY</option>
                                        <option value="SGD" <?php echo $ptm['PTM_CURR'] == 'SGD' ? 'selected' : '' ?>>SGD</option>
                                        <option value="CNY" <?php echo $ptm['PTM_CURR'] == 'CNY' ? 'selected' : '' ?>>CNY</option>
                                        <option value="KRW" <?php echo $ptm['PTM_CURR'] == 'KRW' ? 'selected' : '' ?>>KRW</option>
                                    </select>
                                </td>
                            </tr>
                            <!-- <tr>
                                <td class="col-md-3 form-required">Template Evaluasi</td>
                                <td><?php echo $ptp['EVT_NAME'] ?></td>
                            </tr> -->
                        </table>
                    </div>
                    <!-- <div class="panel panel-default">
                        <div class="panel-heading form-required">
                            Centang item evaluasi teknis yang mandatory
                        </div>
                        <div id="centang_item_mandatory" class="panel-body">
                        </div>
                    </div> -->
                    <div class="panel panel-default">
                        <div class="panel-heading">Jadwal Pengadaan</div>
                        <table class="table">
                            <tr>
                                <td clas="col-md-3">RFQ Date</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group date">
                                                <input type="text" name="ptp_reg_opening_date" id="ptp_reg_opening_date" class="form-control" value="<?php echo betteroracledate(oraclestrtotime($ptp['PTP_REG_OPENING_DATE'])) ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td clas="col-md-3">Quotation Deadline</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group date">
                                                <input type="text" name="ptp_reg_closing_date" id="ptp_reg_closing_date" class="form-control" value="<?php echo betteroracledate(oraclestrtotime($ptp['PTP_REG_CLOSING_DATE'])) ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td clas="col-md-3">Delivery Date</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group date">
                                                <input type="text" name="ptp_delivery_date" id="ptp_delivery_date" class="form-control" value="<?php echo betteroracledate(oraclestrtotime($ptp['PTP_DELIVERY_DATE'])) ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td clas="col-md-3">Tanggal Aanwijing</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group date">
                                                <input type="text" name="ptp_prebid_date" id="ptp_prebid_date" class="form-control" value="<?php echo empty($ptp['PTP_PREBID_DATE']) ? '' : betteroracledate(oraclestrtotime($ptp['PTP_PREBID_DATE'])) ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td clas="col-md-3">Lokasi Aanwijing</td>
                                <td><input type="text" class="form-control" name="ptp_prebid_location" value="<?php echo $ptp['PTP_PREBID_LOCATION'] ?>"></td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Term of Delivery</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select name="ptp_term_delivery"  class="col-md-12">
                                                <option value=""></option>
                                                <option value="FRC" <?php if($ptp['PTP_TERM_DELIVERY'] == "FRC") echo "selected" ?> >FRC</option>
                                                <option value="FCA" <?php if($ptp['PTP_TERM_DELIVERY'] == "FCA") echo "selected" ?> >FCA</option>
                                                <option value="EXW" <?php if($ptp['PTP_TERM_DELIVERY'] == "EXW") echo "selected" ?> >EXW</option>
                                                <option value="CPT" <?php if($ptp['PTP_TERM_DELIVERY'] == "CPT") echo "selected" ?> >CPT</option>
                                                <option value="CIP" <?php if($ptp['PTP_TERM_DELIVERY'] == "CIP") echo "selected" ?> >CIP</option>
                                                <option value="DAT" <?php if($ptp['PTP_TERM_DELIVERY'] == "DAT") echo "selected" ?> >DAT</option>
                                                <option value="DAP" <?php if($ptp['PTP_TERM_DELIVERY'] == "DAP") echo "selected" ?> >DAP</option>
                                                <option value="DDP" <?php if($ptp['PTP_TERM_DELIVERY'] == "DDP") echo "selected" ?> >DDP</option>
                                                <option value="FAS" <?php if($ptp['PTP_TERM_DELIVERY'] == "FAS") echo "selected" ?> >FAS</option>
                                                <option value="FOB" <?php if($ptp['PTP_TERM_DELIVERY'] == "FOB") echo "selected" ?> >FOB</option>
                                                <option value="CFR" <?php if($ptp['PTP_TERM_DELIVERY'] == "CFR") echo "selected" ?> >CFR</option>
                                                <option value="CIF" <?php if($ptp['PTP_TERM_DELIVERY'] == "CIF") echo "selected" ?> >CIF</option>
                                                <option value="DAF" <?php if($ptp['PTP_TERM_DELIVERY'] == "DAF") echo "selected" ?> >DAF</option>
                                                <option value="DES" <?php if($ptp['PTP_TERM_DELIVERY'] == "DES") echo "selected" ?> >DES</option>
                                                <option value="DEQ" <?php if($ptp['PTP_TERM_DELIVERY'] == "DEQ") echo "selected" ?> >DEQ</option>
                                                <option value="DDU" <?php if($ptp['PTP_TERM_DELIVERY'] == "DDU") echo "selected" ?> >DDU</option>
                                            </select>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" name="ptp_delivery_note" class="form-control" placeholder="Term of Delivery Description" maxlength="100" value="<?php echo $ptp['PTP_DELIVERY_NOTE'] ?>">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Term of Payment</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select name="ptp_term_payment" class="col-md-12">
                                                <option value=""></option>
                                                <option value="TT" <?php if($ptp['PTP_TERM_PAYMENT'] == "TT") echo "selected" ?> >TT</option>
                                                <option value="LC" <?php if($ptp['PTP_TERM_PAYMENT'] == "LC") echo "selected" ?> >LC</option>
                                                <option value="COD" <?php if($ptp['PTP_TERM_PAYMENT'] == "COD") echo "selected" ?> >COD</option>
                                            </select>
                                        </div>
                                        <div class="col-md-10">
                                        <input type="text" name="ptp_payment_note" class="form-control" placeholder="Term of Payment Description" maxlength="100" value="<?php echo $ptp['PTP_PAYMENT_NOTE'] ?>">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3 form-required">Tanggal Validity Harga</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group date">
                                                <input type="text" name="ptp_validity_harga" id="ptp_validity_harga" class="form-control" value="<?php echo $ptp['PTP_VALIDITY_HARGA'] ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Jaminan</div>
                        <table class="table">
                            <tr>
                                <td class="col-md-3">Jaminan Penawaran</td>
                                <td class="col-md-3">
                                    <input type="radio" name="jaminan_penawaran" value="1" <?php echo $ptp['PTP_PERSEN_PENAWARAN'] > 0 ? 'selected checked' : '' ?>> Yes
                                    <input type="radio" name="jaminan_penawaran" value="0" <?php echo $ptp['PTP_PERSEN_PENAWARAN'] == 0 ? 'selected checked' : '' ?>> No
                                </td>
                                <td class="col-md-3">Persen Jaminan</td>
                                <td class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" name="persen_penawaran"class="form-control" value="<?php echo $ptp['PTP_PERSEN_PENAWARAN'] ?>">
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Jaminan Pelaksanaan</td>
                                <td class="col-md-3">
                                    <input type="radio" name="jaminan_pelaksanaan" value="1" <?php echo $ptp['PTP_PERSEN_PELAKSANAAN'] > 0 ? 'selected checked' : '' ?>> Yes
                                    <input type="radio" name="jaminan_pelaksanaan" value="0" <?php echo $ptp['PTP_PERSEN_PELAKSANAAN'] == 0 ? 'selected checked' : '' ?>> No
                                </td>
                                <td class="col-md-3">Persen Jaminan</td>
                                <td class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" name="persen_pelaksanaan"class="form-control" value="<?php echo $ptp['PTP_PERSEN_PELAKSANAAN'] ?>">
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Jaminan Pemeliharaan</td>
                                <td class="col-md-3">
                                    <input type="radio" name="jaminan_pemeliharaan" value="1" <?php echo $ptp['PTP_PERSEN_PEMELIHARAAN'] > 0 ? 'selected checked' : '' ?>> Yes
                                    <input type="radio" name="jaminan_pemeliharaan" value="0" <?php echo $ptp['PTP_PERSEN_PEMELIHARAAN'] == 0 ? 'selected checked' : '' ?>> No
                                </td>
                                <td class="col-md-3">Persen Jaminan</td>
                                <td class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" name="persen_pemeliharaan"class="form-control" value="<?php echo $ptp['PTP_PERSEN_PEMELIHARAAN'] ?>">
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Template Evaluasi</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-3 form-required">Template Evaluasi</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-7">
                                                <input type="hidden" name="ptp_template_evaluasi" value="<?php echo $ptp['PTP_EVALUASI_TEKNIS']; ?>">
                                                <select class="form-control" name="" id="ptp_template_evaluasi" disabled="">
                                                    <option value="">-Pilih-</option> 
                                                    <!-- <?php //var_dump($evatek); ?> -->
                                                    <?php foreach ($evatek['data'] as $value) { ?>
                                                        <?php if($ptp['PTP_EVALUASI_TEKNIS']==$value['EVT_ID']) { ?>
                                                            <option value="<?php echo $value['EVT_ID']; ?>" selected><?php echo $value['EVT_NAME']; ?></option>
                                                        <?php } ?>
                                                        <option value="<?php echo $value['EVT_ID']; ?>"><?php echo $value['EVT_NAME']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>                                        
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Detail Template Evatek</div>
                                        <div class="panel-body">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center col-md-1"><strong>No</strong></th>
                                                        <th class="text-center col-md-3"><strong>Nama</strong></th>
                                                        <th class="text-center col-md-1"><strong>Bobot</strong></th>
                                                        <th class="text-center col-md-1"><strong>Mode</strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbl_detail_template">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>            
                                </div>                                    
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Catatan Untuk Vendor</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-3">Catatan</td>
                                    <td>:</td>
                                    <td>
                                        <textarea name="ptp_vendor_note" class="form-control" style="resize:vertical"><?php echo $ptp['PTP_VENDOR_NOTE']; ?></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" id="just" name="kist" value="<?php echo $ptm['JUSTIFICATION'] ?>">
                    <div class="panel panel-default">
                        <div class="panel-heading">Vendor Terpilih</div>
                        <table class="table table-stripped">
                            <thead>
                                <th class="col-md-1"></th>
                                <th>No Vendor</th>
                                <th>Nama Vendor</th>                                
                            </thead>
                            <tbody class="vendor_terpilih"></tbody>
                        </table>
                    </div>
                    <div class="panel panel-default panelvendor_barang">
                        <div class="panel-heading" style="background-color: #96999A;">Vendor Terpilih Non Dirven</div>
                        <table class="table table-stripped" id="table_vendor_terpilih_nonDirven">
                            <thead>
                                <th class="col-md-1"></th>
                                <th>No Vendor</th>
                                <th>Nama Vendor</th>
                                <th>Tender Type</th>
                                <th>Nama Principal</th>
                            </thead>
                            <tbody class="vendor_terpilih_tambahan">
                                <?php if(isset($vendor_tambahan)){
                                        foreach ($vendor_tambahan as $val) { ?>
                                <tr>
                                    <td align="center"><input type="checkbox" class="vnd_terpilih_tambahan" onclick="nocentang_tambahan(this)" name="vendor_tambahan[]" value="<?php echo $val['PTV_VENDOR_CODE']; ?>" checked></td>
                                    <td><?php echo $val['PTV_VENDOR_CODE']; ?></td>
                                    <td><?php echo $val['VENDOR_NAME']; ?></td>
                                    <td>
                                            <input type="hidden" name="type_tender[]" value="<?php echo $val['PTV_VENDOR_CODE'].':'.$val['PTV_TENDER_TYPE']; ?>">
                                            <select class="tender_type" id="tender_type:<?php echo $val['PTV_VENDOR_CODE']; ?>" name="" disabled>
                                            <?php
                                                if($val['PTV_TENDER_TYPE']==1){ ?>
                                                    
                                                    <option value="<?php echo $val['PTV_VENDOR_CODE']; ?>:1" selected>Agen to Principal</option>
                                                    <option value="<?php echo $val['PTV_VENDOR_CODE']; ?>:2">By Principal</option>                                                
                                            <?php }else if($val['PTV_TENDER_TYPE']==2){ ?>
                                                    
                                                    <option value="<?php echo $val['PTV_VENDOR_CODE']; ?>:1">Agen to Principal</option>
                                                    <option value="<?php echo $val['PTV_VENDOR_CODE']; ?>:2" selected>By Principal</option>
                                            <?php }else{ ?>
                                                    
                                                    <option value="<?php echo $val['PTV_VENDOR_CODE']; ?>:1">Agen to Principal</option>
                                                    <option value="<?php echo $val['PTV_VENDOR_CODE']; ?>:2">By Principal</option>
                                            <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="hidden" name="list_principal[]" value="<?php echo $val['PTV_VENDOR_CODE'].':'.$val['PTV_PC_CODE']; ?>">
                                            <select id="list_principal:<?php echo $val['PTV_VENDOR_CODE']; ?>" name="" style="width: 250px;" disabled>
                                                <?php foreach ($val['list_principal'] as $list) { ?>
                                                    <?php if($val['PTV_PC_CODE']==$list['PC_CODE']){ ?>                                                        
                                                        <option value="<?php echo $val['PTV_VENDOR_CODE'].':'.$list['PC_CODE']; ?>" selected><?php echo $list['PC_NAME']; ?></option>
                                                    <?php }else{?>    
                                                        <option value="<?php echo $val['PTV_VENDOR_CODE'].':'.$list['PC_CODE']; ?>"><?php echo $list['PC_NAME']; ?></option>
                                                    <?php }?>
                                                <?php }?>
                                            </select>
                                        </td>
                                </tr>
                                <?php   }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if ($ptm['JUSTIFICATION'] != '5'): ?>
                    <div class="panel panel-default panelvendor_barang pnl_satu hiddenelement">
                        <div class="panel-heading">
                            Pilih Vendor
                        </div>
                        <div class="panel-body">
                            <table id="pr-list-table-vendor" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>No Vendor</th>
                                        <th>Nama Vendor</th>
                                        <th>Mat Grp</th>
                                        <th>Sub Grp</th>
                                        <th>Tipe Vendor</th>
                                        <th>Performance</th>
                                        <th>Kategori Vendor</th>
                                        <th>PO Collected</th>
                                        <th>PO Outstanding</th>
                                    </tr>
                                    <tr>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <font color="red"><?php echo form_error('item'); ?></font>
                        </div>
                    </div>

                    <div class="panel panel-default panel_jasa_tambahan hiddenelement">
                        <div class="panel-heading">Pilih Vendor</div>
                        <div class="panel-body">
                            <table id="table_vendor_jasa" class="table table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Pilih</th>
                                        <th>No Vendor</th>
                                        <th>Nama Vendor</th>
                                        <th>Group</th>
                                        <th>Klasifikasi</th>
                                        <th>Kualifikasi</th>
                                        <th class="text-center">Performance</th>
                                        <th class="text-center">Kategori Vendor</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <font color="red"><?php echo form_error('item'); ?></font>
                        </div>
                    </div>

                    <div class="panel panel-default panelvendor_barang pnl_dua hiddenelement">                    
                        <div class="panel-heading" style="background-color: #96999A;">
                            Pilih Vendor Non Dirven
                            <button class="btn btn-sm btn-default invisible">G</button>
                            <div class="pull-right">
                                <button type="button" class="btn btn-sm btn-default" id="generate_vnd_brg_tmbhn">Generate</button>
                            </div>
                        </div>
                        <div class="panel-body" style="overflow: auto;" id="grdBarang">
                            <table id="table_vendor_barang_tambahan" class="table table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Pilih</th>
                                        <th>No Vendor</th>
                                        <th>Nama Vendor</th>
                                        <th>Mat Grp</th>
                                        <th>Sub Grp</th>
                                        <th>Tipe Vendor</th>
                                        <th>Performance</th>
                                        <th>Kategori Vendor</th>
                                        <th>PO Collected</th>
                                        <th>PO Outstanding</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <font color="red"><?php echo form_error('item'); ?></font>
                        </div>
                    </div>
                    
                    <!-- <div class="panel panel-default form-horizontal panel_jasa_tambahan">
                        <div class="panel-heading" style="background-color: #96999A;">Filter Vendor Non Dirven</div>
                        <div class="panel-body">
                            <tr>
                                <td>  
                                    <div class="form-group">                              
                                        <div class="col-md-10">
                                            <div class="col-md-4">
                                                <select name="group_jasa_id" id="group_jasa_id" class="form-control select2" >
                                                    <option value="" selected="">Pilih Grup Jasa</option>
                                                    <?php foreach ($group_jasa as $key => $value) { ?>
                                                        <option value="<?php echo $value["ID"]; ?>"><?php echo $value["NAMA"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="subGroup_jasa_id" id="subGroup_jasa_id" class="form-control select2">
                                                    <option value="" selected="">Pilih Sub Grup Jasa</option>
                                                </select>                                             
                                            </div>
                                            <div class="col-md-4">
                                                <select name="klasifikasi_jasa_id" id="klasifikasi_jasa_id" class="form-control select2">
                                                    <option value="" selected="">Pilih Klasifikasi</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <div class="col-md-5">
                                                <div id="subKlasifikasi_ganjil"></div>
                                            </div> 
                                            <div class="col-md-5">
                                                <div id="subKlasifikasi_genap"></div>
                                            </div> 
                                        </div>                                   
                                        <div class="col-md-10">
                                            <div class="col-md-2">
                                                <button id="search" class="btn btn-success" type="button">Search</button>
                                            </div>
                                        </div>
                                    </div>                                    
                                </td>
                            </tr>
                        </div>
                    </div>
                    <div class="panel panel-default panel_jasa_tambahan">
                        <div class="panel-heading" style="background-color: #96999A;">
                            Pilih Vendor Non Dirven
                        </div>
                        <div class="panel-body">
                            <table id="table_vendor_jasa_tambahan" class="table table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Pilih</th>
                                        <th>No Vendor</th>
                                        <th>Nama Vendor</th>
                                        <th>Group</th>
                                        <th>Klasifikasi</th>
                                        <th>Kualifikasi</th>
                                        <th class="text-center">Performance</th>
                                        <th class="text-center">Kategori Vendor</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <font color="red"><?php echo form_error('item'); ?></font>
                        </div>
                    </div> -->
                    <?php else: ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Pilih PO</div>
                        <div class="panel-body">
                            <table id="pr-list-table-po" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center col-md-1">No</th>
                                        <th>No Vendor</th><!-- LIFNR -->
                                        <th class="col-md-4">Nama Vendor</th><!-- NAME1 -->
                                        <th class="text-center">No PO</th><!-- EBELN -->
                                        <th>Tgl PO</th><!-- ???? -->
                                        <th>History GR</th><!-- ???? -->
                                    </tr>
                                    <tr>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif ?>
                    <?php echo $ptm_comment ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Komentar Anda</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-6">Komentar</td>
                                    <td>
                                        <textarea maxlength="1000" name="comment" id="comment" class="form-control" style="resize:vertical"></textarea>
                                        <span  style="color:red; padding-left:20px; font-weight:bold;  display:none" id="msg_comment">** Komentar harus diisi</span> 
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <select class="harusmilih_publicjs" name='harus_pilih'>
                                <option value="false_public"></option>
                                <!-- <option>Lanjut ke aproval Subpratender.</option> -->
                                <option value="accept">Lanjut ke <?php echo $next_process['NAMA_BARU']; ?></option>
                                <option value="reject">Reject</option>
                            </select>
                            <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                            <button type="submit" class="main_button color7 small_btn milihtombol_publicjs" disabled>OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>

<div class="modal fade" id="modal_dokumen">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">Informasi Tambahan PR <span class="pr"></span></div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                        <th>Pilih</th>
                        <th>Tipe</th>
                        <th>Nama</th>
                        <th>File</th>
                        <th>Tanggal</th>
                        <th>User</th>
                    </thead>
                    <tbody id="dokumentable">
                    </tbody>
                </table>
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        <button type="button" id="savedoc" class="main_button color2 small_btn">Simpan</button>
                        <button type="button" class="main_button color7 small_btn close-modal">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(e) {
        $("#comment").focusout(function(e){        
            $("#msg_comment").css("display","none");        
        })
    });
</script>
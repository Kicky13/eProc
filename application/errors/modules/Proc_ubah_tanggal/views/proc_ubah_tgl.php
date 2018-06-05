
<section class="content_section">
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" id="templateModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editItemModalLabel">Available Template</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover" id="template-table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nama</th>
                                        <th>Tipe</th>
                                        <th>Lihat</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="collapse" id="detailTemplt">
                                <table class="table table-hover" id="detail-template-table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Mode</th>
                                            <th>Bobot</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="main_button color6" id="updateItem" data-dismiss="modal">Pilih</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php echo form_open_multipart(base_url('Procurement_release/save_bidding'), array('method' => 'POST','class' => 'submit')); ?>
            <input type="hidden" name="ptm_number" id="ptm_number" value="<?php echo $ptm['PTM_NUMBER'] ?>">
            <div class="row">
                <div class="col-md-12">
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
                                <td>Creator</td>
                                <td><?php echo $ptm['PTM_REQUESTER_NAME'] ?></td>
                            </tr>
                            <!-- <tr>
                                <td>Biro / Unit</td>
                                <td><?php echo $this->session->userdata['POS_NAME'] ?></td>
                            </tr> -->
                            <tr>
                                <td>Nama Pengadaan</td>
                                <td>
                                    <?php echo $ptm['PTM_SUBJECT_OF_WORK'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor Usulan Pratender</td>
                                <td>
                                    <?php echo $ptm['PTM_SUBPRATENDER']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis Pengadaan</td>
                                <td>
                                    <?php echo $ptm['IS_JASA'] == 0 ? 'Barang' : 'Jasa' ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php echo $detail_item_ptm ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Dokumen PR
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <th class="text-center col-md-1">No</th>
                                <th>Nama Dokumen</th>
                                <th class="col-md-3 text-center">Share</th>
                            </thead>
                            <tbody id="items_table">
                                <?php $no = 0; foreach ($dokumen as $item): ?>
                                <tr>
                                    <td class="text-center"><?php echo ($no + 1) ?></td>
                                    <td>
                                    <li style="list-style-type: none;">
                                        <span class="glyphicon glyphicon-file"></span>
                                        <a href="<?php echo base_url('Procurement_sap'); ?>/viewDok/<?php echo $item['nama']; ?>" target="_blank"><?php echo $item['PPD_DESCRIPTION'] ?></a>
                                    </li>
                                    </td>
                                    <td>
                                        <div class="col-md-6 text-right">
                                            <input type="radio" name="share[<?php echo str_replace(".","_",$item['nama']) ?>]" value="1" <?php if($item['IS_SHARE'] == '1') echo "selected checked"; ?> <?php if($item['PDC_IS_PRIVATE'] == "1") echo "hidden";?> > <?php if($item['PDC_IS_PRIVATE'] == "1") echo ""; else echo "Share" ?>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="radio" name="share[<?php echo str_replace(".","_",$item['nama']) ?>]" value="0" <?php if($item['IS_SHARE'] == '0') echo "selected checked"; else echo '0' ?> <?php if($item['PDC_IS_PRIVATE'] == "1") echo "hidden";?>> <?php if($item['PDC_IS_PRIVATE'] == "1") echo ""; else echo "Not Share" ?>
                                        </div>
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
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Metode Pengadaan</div>
                        <table class="table table-hover">
                            
                            <tr>
                                <td class="col-md-3">Mekanisme Pengadaan</td>
                                <td>
                                    <?php echo $ptp['PTP_JUSTIFICATION'] ?>
                                    <input type="hidden" id="ptp_justification" value="<?php echo $ptp['PTP_JUSTIFICATION_ORI']?>">
                                </td>
                            </tr>
                            <tr id="is_itemize">
                                <td class="form-required">Metode Penawaran</td>
                                <td>
                                    <div class="row">
                                        <div class="row">
                                        <?php if($ptp['PTP_IS_ITEMIZE'] == 1){?>
                                            <div class="col-md-4">
                                                <input type="radio" value="1" name="is_itemize" checked> Itemize
                                            </div>
                                            <div class="col-md-4">
                                                <input type="radio" value="0" name="is_itemize" disabled> Paket
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-md-4">
                                                <input type="radio" value="1" name="is_itemize" disabled> Itemize
                                            </div>
                                            <div class="col-md-4">
                                                <input type="radio" value="0" name="is_itemize" checked> Paket
                                            </div>
                                        <?php } ?>
                                        </div>
                                    </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="form-required">Sistem Sampul</td>
                                <td>
                                    <select name="ptp_evaluation_method" disabled>
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
                                            <select name="ptp_warning" disabled>
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
                                                <input type="text" name="ptp_batas_penawaran"class="form-control" value="<?php echo $ptp['PTP_BATAS_PENAWARAN'] ?>" disabled>
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
                                                <input type="text" name="ptp_batas_penawaran_bawah"class="form-control" value="<?php echo $ptp['PTP_BAWAH_PENAWARAN'] ?>" disabled>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3 form-required">Sistem Peringatan pada Negosiasi</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select name="ptp_warning_nego" disabled>
                                                <option value="1" <?php echo $ptp['PTP_WARNING_NEGO_ORI'] == '1' ? 'selected' : '' ?>>Tidak ada pesan</option>
                                                <option value="2" <?php echo $ptp['PTP_WARNING_NEGO_ORI'] == '2' ? 'selected' : '' ?>>Warning</option>
                                                <option value="3" <?php echo $ptp['PTP_WARNING_NEGO_ORI'] == '3' ? 'selected' : '' ?>>Error</option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Prosentase Batas Atas Nego ECE/HPS/OE</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="text" name="ptp_batas_nego"class="form-control" value="<?php echo $ptp['PTP_BATAS_NEGO'] ?>" disabled>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="form-required">Template Evaluasi</td>
                                <td><?php echo $ptp['EVT_NAME'] ?></td>
                            </tr>
                            <tr>
                                <td class="form-required">Tipe RFQ</td>
                                <td>
                                    <select name="ptm_rfq_type" disabled>
                                        <?php foreach ($rfq_type as $val): ?>
                                        <option value="<?php echo $val['PDT_TYPE'] ?>" <?php echo $ptm['PTM_RFQ_TYPE'] == $val['PDT_TYPE'] ? 'selected' : '' ?>><?php echo $val['PDT_TYPE'] . ' (' . $val['PDT_NAME'] . ')' ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="form-required">Currency</td>
                                <td>
                                    <select name="ptm_curr">
                                        <option value="IDR" <?php echo $ptm['PTM_CURR'] == 'IDR' ? 'selected' : '' ?>>IDR</option>
                                        <option value="EUR" <?php echo $ptm['PTM_CURR'] == 'EUR' ? 'selected' : '' ?>>EUR</option>
                                        <option value="USD" <?php echo $ptm['PTM_CURR'] == 'USD' ? 'selected' : '' ?>>USD</option>
                                    </select>
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
                                <td clas="col-md-5">RFQ Date</td>
                                <td>
                                    <div class="input-group date">
                                        <input type="text" name="ptp_reg_opening_date" class="form-control" value="<?php echo oracledate(oraclestrtotime($ptp['PTP_REG_OPENING_DATE'])) ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td clas="col-md-5">Quotation Deadline</td>
                                <td>
                                    <div class="input-group date">
                                        <input type="text" name="ptp_reg_closing_date" class="form-control" value="<?php echo oracledate(oraclestrtotime($ptp['PTP_REG_CLOSING_DATE'])) ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td clas="col-md-5">Delivery Date</td>
                                <td>
                                    <div class="input-group date">
                                        <input type="text" name="ptp_delivery_date" class="form-control" value="<?php echo oracledate(oraclestrtotime($ptp['PTP_DELIVERY_DATE'])) ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td clas="col-md-5">Tanggal Aanwijing</td>
                                <td>
                                    <div class="input-group date">
                                        <input type="text" name="ptp_prebid_date" class="form-control" value="<?php echo empty($ptp['PTP_PREBID_DATE']) ? '' : oracledate(oraclestrtotime($ptp['PTP_PREBID_DATE'])) ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td clas="col-md-5">Lokasi Aanwijing</td>
                                <td><?php echo $ptp['PTP_PREBID_LOCATION'] ?></td>
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
                        <div class="panel-heading">Tambahan</div>
                        <table class="table">
                            <tr title="Dokumen tambahan yang di share ke vendor, selain dokumen item pr. Menempel pada level pengadaan">
                                <td class="col-md-3">Dokumen pengadaan</td>
                                <td class="divfiles">   
                                    <?php foreach ($dokumentambahan as $key => $value): ?>
                                        <a href="<?php echo echo base_url('Monitoring_prc'); ?>/viewDok/<?php echo $value['FILE']; ?>" target="_blank"><span class="glyphicon glyphicon-file"></span> <?php echo $value['NAME']; ?></a><br>
                                    <?php endforeach ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel panel-default">
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
                    <?php echo $ptm_comment ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Komentar Anda</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-6">Komentar</td>
                                    <td>
                                        <textarea maxlength="1000" name="comment" class="form-control" style="resize:vertical"></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <select class="harusmilih_publicjs">
                                <option value="false_public"></option>
                                <!-- <option>Lanjut ke aproval Subpratender.</option> -->
                                <option>Lanjut ke <?php echo $next_process['NAMA_BARU']; ?></option>
                            </select>
                            <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                            <button type="submit" class="formsubmit main_button color7 small_btn milihtombol_publicjs" disabled>OK</button>
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
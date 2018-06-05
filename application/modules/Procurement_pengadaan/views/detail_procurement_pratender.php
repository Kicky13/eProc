
<section class="content_section">
    <!-- <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" id="templateModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editItemModalLabel">Available Template</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover" id="template-table" style="width: inherit;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tipe</th>
                                        <th>Lihat</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row" id="nguk">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-default" id="detail-tmp1">
                                <table class="table table-hover" id="detail-template-judul">
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="collapse" id="detailTemplt">
                                <table class="table table-hover table-bordered" id="detail-template-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="40pt"><strong>No</strong></th>
                                            <th class="text-center"><strong>Nama</strong></th>
                                            <th class="text-center"><strong>Mode</strong></th>
                                            <th class="text-center"><strong>Bobot</strong></th>
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
    </div> -->
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php echo form_open_multipart(base_url(uri_string()), array('method' => 'POST','class' => 'submit')); ?>
            <input type="hidden" name="ptm_number" id="ptm_number" value="<?php echo $ptm['PTM_NUMBER'] ?>">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
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
                            <?php if ($buyer != null): ?>
                            <tr>
                                <td class="col-md-4">Buyer</td>
                                <td><?php echo $buyer['FULLNAME'] ?></td>
                            </tr>
                            <?php endif ?>
                            <tr>
                                <td>Jenis Pengadaan</td>
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
                                <td class="col-md-3">Dokumen Pengadaan</td>
                                <input type="hidden" name="numberfiles" class="numberfiles" value="1">
                                <td class="divfiles">  
                                    <div class="row">
                                        <div class="col-md-5">
                                            <input name="add_doc1" type="file" class="form-control">
                                        </div>
                                        <div class="col-md-7">
                                            <input name='name_doc1' type='text' class='form-control' placeholder='Keterangan'>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-right">
                                <button type="submit" class="btn btn-default tambahfile">Tambah File</button>
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
                                <td class="form-required">Metode Penawaran</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="radio" value="1" name="is_itemize" class="is_itemize" <?php echo $ptp['PTP_IS_ITEMIZE'] === '1' ? 'checked' : '' ?>> Itemize
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" value="0" name="is_itemize" class="is_itemize" <?php echo $ptp['PTP_IS_ITEMIZE'] === '0' ? 'checked' : '' ?>> Paket
                                            
                                        </div>
                                        <div class="col-md-4 text-right">
                                            
                                            <input type="hidden" value="<?php echo $ptp['PTP_IS_ITEMIZE']; ?>" id="ub_is_itemize" name="ub_is_itemize" /><span  style="color:red; padding-left:20px; font-weight:bold; display:none" id="msg_is_itemize" name="msg_is_itemize">** Pilih Metode Penawaran</span>
                                        </div>
                                        
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="form-required">Sistem Sampul</td>
                                <td>
                                <div class="row">
                                        <div class="col-md-4">
                                    <select class="form-control repeat_order_method" id="ptp_evaluation_method" name="ptp_evaluation_method">
                                        <?php if($ptp['PTP_EVALUATION_METHOD'] == "1 Tahap 1 Sampul"){?>    
                                        <option value="" selected>-Pilih-</option>
                                            <option value="1" selected>1 Tahap 1 Sampul</option>
                                            <option value="2">2 Tahap 1 Sampul</option>
                                            <option value="3">2 Tahap 2 Sampul</option>
                                        <?php } else if($ptp['PTP_EVALUATION_METHOD'] == "2 Tahap 1 Sampul"){?>
                                         <option value="" selected>-Pilih-</option>
                                            <option value="1">1 Tahap 1 Sampul</option>
                                            <option value="2" selected>2 Tahap 1 Sampul</option>
                                            <option value="3">2 Tahap 2 Sampul</option>
                                        <?php }else {?>
                                          <option value="" selected>-Pilih-</option>
                                            <option value="1">1 Tahap 1 Sampul</option>
                                            <option value="2">2 Tahap 1 Sampul</option>
                                            <option value="3" selected>2 Tahap 2 Sampul</option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                    <div class="col-md-8 text-right">
                                     <input type="hidden" value="<?php echo $ptp['PTP_EVALUATION_METHOD']; ?>" id="ub_ptp_evaluation_method" name="ub_ptp_evaluation_method" /><span  style="color:red; padding-left:20px; font-weight:bold;  display:none" id="msg_ptp_evaluation_method" name="msg_ptp_evaluation_method">** Pilih Sistem Sampul</span>
                                     </div>
                             </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3 form-required">Sistem Peringatan Pada Penawaran</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control repeat_order" id="ptp_warning" name="ptp_warning">
                                            <option value="">-Pilih-</option>
                                                <option value="1" <?php echo $ptp['PTP_WARNING_ORI'] == 1 ? 'selected' : '' ?>>Tidak ada pesan</option>
                                                <option value="2" <?php echo $ptp['PTP_WARNING_ORI'] == 2 ? 'selected' : '' ?>>Warning</option>
                                                <option value="3" <?php echo $ptp['PTP_WARNING_ORI'] == 3 ? 'selected' : '' ?>>Error</option>
                                            </select>
                                        </div>
                                         <div class="col-md-8 text-right">
                                         <input type="hidden" value="<?php echo $ptp['PTP_EVALUATION_METHOD']; ?>" id="ub_ptp_warning" name="ub_ptp_warning" /><span  style="color:red; padding-left:20px; font-weight:bold;  display:none" id="msg_ptp_warning" name="msg_ptp_warning">** Pilih Sistem Peringatan Penawaran</span>
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
                                                <input type="text" id="ptp_batas_penawaran" name="ptp_batas_penawaran"class="form-control repeat_order" value="<?php echo $ptp['PTP_BATAS_PENAWARAN'] ?>" onkeypress="return isNumberKey(event)">
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
                                                <input type="text" id="ptp_batas_penawaran_bawah" name="ptp_batas_penawaran_bawah" class="form-control repeat_order" value="<?php echo $ptp['PTP_BAWAH_PENAWARAN'] ?>" onkeypress="return isNumberKey(event)">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="ro_hide">
                                <td class="col-md-3 form-required">Sistem Peringatan Pada Negosiasi</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select  name="ptp_warning_nego" class="form-control" id="ptp_warning_nego">
                                             <!-- <option value="" >-Pilih-</option> -->
                                                <option value="1" <?php echo $ptp['PTP_WARNING_NEGO_ORI'] == '1' ? 'selected' : '' ?>>Tidak ada pesan</option>
                                                <option value="2" <?php echo $ptp['PTP_WARNING_NEGO_ORI'] == '2' ? 'selected' : '' ?>>Warning</option>
                                                <option value="3" <?php echo $ptp['PTP_WARNING_NEGO_ORI'] == '3' ? 'selected' : '' ?>>Error</option>
                                            </select>
                                        </div>
                                         <div class="col-md-8 text-right">
                                         <input type="hidden" value="<?php echo $ptp['PTP_WARNING_NEGO_ORI']; ?>" id="ub_ptp_warning_nego" name="ub_ptp_warning_nego" /><span  style="color:red; padding-left:20px; font-weight:bold;  display:none" id="msg_ptp_warning_nego" name="msg_ptp_warning_nego">** Pilih Sistem Peringatan Negosiasi </span>
                                         </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="ro_hide">
                                <td class="col-md-3 form-required" id="htmlbatasatasnego">Prosentase Batas Atas Nego ECE/HPS/OE</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input id="batasatasnego" type="text" name="ptp_batas_nego" class="form-control" value="<?php echo $ptp['PTP_BATAS_NEGO']==''?20:$ptp['PTP_BATAS_NEGO'] ?>" onkeypress="return isNumberKey(event)">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    <div class="col-md-9 text-right">
                                     <input type="hidden" value="<?php echo $ptp['PTP_BATAS_NEGO']; ?>" id="ub_batasatasnego" name="ub_batasatasnego" /><span  style="color:red; padding-left:20px; font-weight:bold;  display:none" id="msg_batasatasnego" name="msg_batasatasnego">** Masukkan Batas Nego</span>
                                     </div>
                             </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="form-required">Tipe RFQ</td>
                                <td>
                                <div class="row">
                                <div class="col-md-4">
                                    <select class="form-control" id="ptm_rfq_type" name="ptm_rfq_type">
                                        
                                        <?php foreach ($rfq_type as $val): ?>
                                        <option value="<?php echo $val['TYPE'] ?>" <?php echo $ptm['PTM_RFQ_TYPE'] == $val['TYPE'] ? 'selected' : '' ?>><?php echo $val['TYPE'] . ' (' . $val['DESC'] . ')' ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    </div>
                                    <div class="col-md-8 text-right">
                                     <input type="hidden" value="<?php echo $ptp['PTP_BATAS_NEGO']; ?>" id="ub_ptm_rfq_type" name="ub_ptm_rfq_type" /><span  style="color:red; padding-left:20px; font-weight:bold;  display:none" id="msg_ptm_rfq_type" name="msg_ptm_rfq_type">** Pilih Tipe RFQ</span>
                                     </div>
                             </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="form-required">Currency</td>
                                <td>
                                <div class="row">
                                    <div class="col-md-4">
                                    <select id="ptm_curr" name="ptm_curr">
                                        <option value="IDR">IDR</option>
                                        <option value="EUR">EUR</option>
                                        <option value="USD">USD</option>
                                        <option value="AUD">AUD</option>
                                        <option value="GBP">GBP</option>
                                        <option value="JPY">JPY</option>
                                        <option value="SGD">SGD</option>
                                        <option value="CNY">CNY</option>
                                        <option value="KRW">KRW</option>
                                    </select>
                                    </div>
                                    <div class="col-md-8 text-right">
                                     <input type="hidden" value="<?php echo $ptp['PTP_BATAS_NEGO']; ?>" id="ub_ptm_curr" name="ub_ptm_curr" /><span  style="color:red; padding-left:20px; font-weight:bold;  display:none" id="msg_ptm_curr" name="msg_ptm_curr">** Pilih Mata Uang</span>
                                     </div>
                             </div>
                                </td>
                            </tr>
                            <!-- <tr>
                                <td class="form-required">Template Evaluasi</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Pilih Template Evaluasi" id="eval_id" name="eval_id" value="" disabled>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" id="selectIdTemplate"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-5 text-right">
                                        <input type="hidden" value="<?php echo $ptp['PTP_BATAS_NEGO']; ?>" id="ub_eval_id" name="ub_eval_id" /><span  style="color:red; padding-left:20px; font-weight:bold;  display:none" id="msg_eval_id" name="msg_eval_id">** Pilih Template Evaluasi</span>
                                            <input type="text" id="evt_id" class="hidden" name="evt_id">
                                        </div>
                                    </div>
                                    font color="red"><?php //echo form_error('evt_id'); ?></font
                                </td>
                            </tr> -->
                        </table>
                    </div>
                    <!-- <div class="panel panel-default">
                        <div class="panel-heading form-required">
                            Centang parameter evaluasi teknis. Parameter yang dicentang merupakan mandatori attachment bagi vendor saat memasukkan quotation.
                        </div>
                        <div id="centang_item_mandatory" class="panel-body">
                        </div>
                    </div> -->
                    <div class="panel panel-default">
                        <div class="panel-heading">Jadwal Pengadaan</div>
                        <table class="table">
                            <tr>
                                <td class="col-md-3 form-required">RFQ Date</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group date">
                                                <input required type="text" name="ptp_reg_opening_date" id="ptp_reg_opening_date" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                     <div class="col-md-7 text-right">
                                        <input type="hidden" value="<?php echo $ptp['PTP_BATAS_NEGO']; ?>" id="ub_ptp_reg_opening_date" name="ub_ptp_reg_opening_date" /><span  style="color:red; padding-left:20px; font-weight:bold;  display:none" id="msg_ptp_reg_opening_date" name="msg_ptp_reg_opening_date">** Masukkan RFQ Date</span>
                                           
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        <input type="hidden" name="nyotime" class="nyotime" value="60"><!-- untuk menambah jarak 2 bulan -->
                                <td class="col-md-3 form-required">Quotation Deadline</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group date">
                                                <input required type="text" name="ptp_reg_closing_date" id="ptp_reg_closing_date" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                   <div class="col-md-7 text-right">
                                        <input type="hidden" value="<?php echo $ptp['PTP_BATAS_NEGO']; ?>" id="ub_ptp_reg_closing_date" name="ub_ptp_reg_closing_date" /><span  style="color:red; padding-left:20px; font-weight:bold;  display:none" id="msg_ptp_reg_closing_date" name="msg_ptp_reg_closing_date">** Masukkan Quotation Deadline</span>
                                           
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3 form-required">Delivery Date</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group date">
                                                <input required type="text" name="ptp_delivery_date" id="ptp_delivery_date" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                     <div class="col-md-7 text-right">
                                        <input type="hidden" value="<?php echo $ptp['PTP_BATAS_NEGO']; ?>" id="ub_ptp_delivery_date" name="ub_ptp_delivery_date" /><span  style="color:red; padding-left:20px; font-weight:bold;  display:none" id="msg_ptp_delivery_date" name="msg_ptp_delivery_date">** Masukkan Delivery Date</span>
                                           
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Aanwijzing</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group date">
                                                <input type="text" name="ptp_prebid_date" id="ptp_prebid_date" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Lokasi Aanwijzing</td>
                                <td><input type='text' class="form-control" name="ptp_prebid_location" id="ptp_prebid_location" /></td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Term of Delivery</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="ptp_term_delivery" class="form-control" id="ptp_term_delivery">
                                                <option value="">-Pilih-</option>
                                                <option value="FRC">FRC</option>
                                                <option value="FCA">FCA</option>
                                                <option value="EXW">EXW</option>
                                                <option value="CPT">CPT</option>
                                                <option value="CIP">CIP</option>
                                                <option value="DAT">DAT</option>
                                                <option value="DAP">DAP</option>
                                                <option value="DDP">DDP</option>
                                                <option value="FAS">FAS</option>
                                                <option value="FOB">FOB</option>
                                                <option value="CFR">CFR</option>
                                                <option value="CIF">CIF</option>
                                                <option value="DAF">DAF</option>
                                                <option value="DES">DES</option>
                                                <option value="DEQ">DEQ</option>
                                                <option value="DDU">DDU</option>
                                            </select>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="ptp_delivery_note" id="ptp_term_delivery_note" class="form-control" placeholder="Term of Delivery Description" maxlength="100">

    <input type="hidden" value="<?php echo $ptp['PTP_TERM_DELIVERY']; ?>" id="sny_id_term" name="sny_id_term" /><span  style="color:red; padding-left:20px; font-weight:bold;  display:none" id="msg_term" name="msg_term">** Masukkan Term of Delivery Description </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Term of Payment</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select class="form-control" name="ptp_term_payment" id="ptp_term_payment">
                                                <option value="">-Pilih-</option>
                                                <option value="TT">Telegraphic Transfer</option>
                                                <option value="LC">LC/SKBDN</option>
                                                <option value="COD">COD</option>
                                                <option value="SKBDN">SKBDN</option>
                                            </select>
                                        </div>
                                        <div class="col-md-9">
                                        <!-- <input type="text" name="ptp_payment_note" id="ptp_payment_note" class="form-control" placeholder="Term of Payment Description" maxlength="100" value="45 hari kalender setelah dokumen tagihan dinyatakan lengkap dan benar oleh Seksi Verifikasi"> -->
                                        <input type="text" name="ptp_payment_note" id="ptp_payment_note" class="form-control" placeholder="Term of Payment Description" maxlength="100" value="">
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
                                                <input type="text" name="ptp_validity_harga" id="ptp_validity_harga" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-md-7 text-right">
                                            <input type="hidden" value="<?php echo $ptp['PTP_BATAS_NEGO']; ?>" id="ub_ptp_validity_harga" name="ub_ptp_validity_harga" /><span  style="color:red; padding-left:20px; font-weight:bold;  display:none" id="msg_ptp_validity_harga" name="msg_ptp_validity_harga">** Masukkan Tanggal Validity Harga</span> 
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
                                    <input type="radio" name="jaminan_penawaran" value="1"> Yes
                                    <input type="radio" name="jaminan_penawaran" value="0" selected checked> No
                                </td>
                                <td class="col-md-3">Persen Jaminan</td>
                                <td class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" name="persen_penawaran"class="form-control">
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Jaminan Pelaksanaan</td>
                                <td class="col-md-3">
                                    <input type="radio" name="jaminan_pelaksanaan" value="1"> Yes
                                    <input type="radio" name="jaminan_pelaksanaan" value="0" selected checked> No
                                </td>
                                <td class="col-md-3">Persen Jaminan</td>
                                <td class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" name="persen_pelaksanaan"class="form-control">
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Jaminan Pemeliharaan</td>
                                <td class="col-md-3">
                                    <input type="radio" name="jaminan_pemeliharaan" value="1"> Yes
                                    <input type="radio" name="jaminan_pemeliharaan" value="0" selected checked> No
                                </td>
                                <td class="col-md-3">Persen Jaminan</td>
                                <td class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" name="persen_pemeliharaan"class="form-control">
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Catatan Untuk Vendor</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-3">Catatan</td>
                                    <td>:</td>
                                    <td>
                                        <textarea name="ptp_vendor_note" class="form-control" style="resize:vertical"></textarea>
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
                    <div class="panel panel-default ro_hide">
                        <div class="panel-heading" style="background-color: #96999A;">Vendor Terpilih Non Dirven</div>
                        <table class="table table-stripped">
                            <thead>
                                <th class="col-md-1"></th>
                                <th>No Vendor</th>
                                <th>Nama Vendor</th>
                            </thead>
                            <tbody class="vendor_terpilih_tambahan">
                                <?php if(isset($vendor_tambahan)){
                                        foreach ($vendor_tambahan as $val) { ?>
                                <tr>
                                    <td align="center"><input type="checkbox" class="vnd_terpilih_tambahan" onclick="nocentang_tambahan(this)" name="vendor_tambahan[]" value="<?php echo $val['PTV_VENDOR_CODE']; ?>" checked></td>
                                    <td><?php echo $val['PTV_VENDOR_CODE']; ?></td>
                                    <td><?php echo $val['VENDOR_NAME']; ?></td>
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
                                        <th class="text-center">No Vendor</th>
                                        <th class="text-center">Nama Vendor</th>
                                        <th class="text-center">Mat Grp</th>
                                        <th class="text-center">Sub Grp</th>
                                        <th class="text-center">Tipe Vendor</th>
                                        <th class="text-center">Performance</th>
                                        <th class="text-center">Kategori Vendor</th>
                                        <th class="text-center">PO Collected</th>
                                        <th class="text-center" >PO Outstanding</th>
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
                                <!-- <tfoot>
                                    
                                </tfoot> -->
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
                    </div> -->

                    <!-- <div class="panel panel-default panel_jasa_tambahan">
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

<!-- <div class="modal fade" id="modal_dokumen">
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
</div> -->

<script>
    $(document).ready(function(e) {
        
        $('.is_itemize').click(function(){
            
            $("#msg_is_itemize").css("display","none");
        })
        
        $("#ptp_evaluation_method").change(function(e){
            
            $("#msg_ptp_evaluation_method").css("display","none");
        
        })

        $("#ptp_warning").change(function(e){
        
            $("#msg_ptp_warning").css("display","none");
        
        })

        $("#ptp_warning_nego").change(function(e){
        
            $("#msg_ptp_warning_nego").css("display","none");
        
        })

        $("#ptm_rfq_type").change(function(e){
        
            $("#msg_ptm_rfq_type").css("display","none");
        
        })
        
        $("#ptm_curr").change(function(e){
        
            $("#msg_ptm_curr").css("display","none");
        
        })
        $("#batasatasnego").change(function(e){
        
            $("#msg_batasatasnego").css("display","none");
        
        })
        $("#eval_id").click(function(){
        
            $("#msg_eval_id").css("display","none");
        
        })

        $("#ptp_reg_opening_date").focusout(function(e){
        
            $("#msg_ptp_reg_opening_date").css("display","none");
        
        })

        $("#ptp_reg_closing_date").focusout(function(e){
        
            $("#msg_ptp_reg_closing_date").css("display","none");
        
        })
        $("#ptp_delivery_date").focusout(function(e){
        
            $("#msg_ptp_delivery_date").css("display","none");
        
        })
        $("#ptp_term_delivery_note").change(function(e){
        
            $("#msg_term").css("display","none");
        
        })
        $("#ptp_validity_harga").focusout(function(e){
        
            $("#msg_ptp_validity_harga").css("display","none");
        
        })
        $("#comment").focusout(function(e){        
            $("#msg_comment").css("display","none");        
        })

    });    

</script>
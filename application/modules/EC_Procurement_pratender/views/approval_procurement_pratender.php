
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php echo form_open_multipart(base_url(uri_string()), array('method' => 'POST','class' => 'submit')); ?>
            <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm['PTM_NUMBER'] ?>">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($this->session->flashdata('gagal_subpratender') != false): ?>
                    <?php $gagal_subpratender = $this->session->flashdata('gagal_subpratender'); ?>
                    <?php $detail_gagal_subpratender = $this->session->flashdata('detail_gagal_subpratender'); ?>
                    <div class="panel panel-danger">
                        <div class="panel-body">
                            <p>Error create create SubPratender</p>
                            <p>More Info:</p>
                            <ul>
                                <?php foreach ($gagal_subpratender as $key => $value): ?>
                                    <li><?php echo $key ?>: <?php echo $value ?></li>
                                <?php endforeach ?>
                            </ul>
                            <div class="hidden">
                                <?php var_dump($detail_gagal_subpratender) ?>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Informasi Perencanaan</div>
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
                                <td>Nama Perencanaan</td>
                                <td>
                                    <?php echo $ptm['PTM_SUBJECT_OF_WORK']; ?>
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
                                <td>Jenis Perencanaan</td>
                                <td>
                                    <?php if($ptm['IS_JASA'] == "0") echo "Barang"; else echo "Jasa"; ?>
                                    <input type="hidden" id="jenis_perencanaan" value="<?php echo $ptm['IS_JASA']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Status</td>
                                <td>
                                    <?php echo $ptm['PROCESS_NAME']; ?>
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
                            <tr>
                                <td class="col-md-4">Print Out</td>
                                <td><a href="<?php echo base_url('Export_pdf'); ?>/Print_pdf/<?php echo $ptm['PTM_NUMBER']; ?>" title='print' target="_blank"><span class="glyphicon glyphicon-print"></span></a></td>
                            </tr>
                            <?php if($ptm['PTM_STATUS']==2): ?> <!-- kasi perencanaan -->
                                <tr>
                                    <td class="col-md-4">Upload Usulan Vendor</td>
                                    <td>
                                        <input type="hidden" name="file_upload" id="file_upload">  
                                        <button type="button" required class="uploadAttachment btn btn-default">Upload File</button><span class="filenamespan"></span>
                                            &nbsp;&nbsp;
                                            <a class="btn btn-default del_upload_file glyphicon glyphicon-trash"></a>
                                        <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                            <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if(!empty($ptp['PTP_UPLOAD_USULAN_VENDOR'])): ?>
                                <tr>
                                    <td class="col-md-4">Upload Usulan Vendor</td>
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
                        <div class="panel-heading">Metode Perencanaan</div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-3 form-required">Metode Perencanaan</td>
                                <td>
                                    <?php echo $ptp['PTP_JUSTIFICATION'] ?>
                                    <input type="hidden" id="ptp_justification" value="<?php echo $ptp['PTP_JUSTIFICATION_ORI']?>">
                                </td>
                            </tr>

                            <tr>
                                <td class="col-md-3 form-required">Sistem Peringatan pada Penawaran</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select name="ptp_warning">
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
                                                <input type="text" name="ptp_batas_penawaran_atas" class="form-control r_number" value="<?php echo $ptp['PTP_BATAS_PENAWARAN'] ?>">
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
                                                <input type="text" name="ptp_batas_penawaran_bawah" class="form-control r_number" value="<?php echo $ptp['PTP_BAWAH_PENAWARAN']; ?>">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
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
                                                <select class="form-control" name="ptp_template_evaluasi" id="ptp_template_evaluasi">
                                                    <option value="">-Pilih-</option> 
                                                    <!-- <?php //var_dump($evatek); ?> -->
                                                    <?php foreach ($evatek['data'] as $value) { ?>
                                                        <?php if($ptp['PTP_EVALUASI_TEKNIS']==$value['EVT_ID']) { ?>
                                                            <option value="<?php echo $value['EVT_ID']; ?>" selected><?php echo $value['EVT_NAME']; ?></option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $value['EVT_ID']; ?>"><?php echo $value['EVT_NAME']; ?></option>
                                                        <?php } ?>
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
                    <input type="hidden" id="just" name="kist" value="<?php echo $ptm['JUSTIFICATION'] ?>">
                    
                    <?php if ($ptm['JUSTIFICATION'] != '5'): ?>
                    <div class="panel panel-default panelvendor_barang pnl_satu">
                        <div class="panel-heading">Pilih Vendor</div>
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
                                        <th class="text-center">PO Outstanding</th>
                                    </tr>
                                    <tr class="search">
                                        <th><input class="col-xs-12" type="text"></th>
                                        <th><input class="col-xs-12" type="text"></th>
                                        <th><input class="col-xs-12" type="text"></th>
                                        <th><input class="col-xs-12" type="text"></th>
                                        <th><input class="col-xs-12" type="text"></th>
                                        <th><input class="col-xs-12" type="text"></th>
                                        <th><input class="col-xs-12" type="text"></th>
                                        <th><input class="col-xs-12" type="text"></th>
                                        <th><input class="col-xs-12" type="text"></th>
                                        <th><input class="col-xs-12" type="text"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="panel panel-default panel_jasa_tambahan">
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

                    <div class="panel panel-default panelvendor_barang pnl_dua">                    
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
                        </div>
                    </div>

                    
                    <?php else: ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Pilih PO</div>
                        <div class="panel-body" style="width: 100%; overflow-x: auto;">
                            <table id="pr-list-table-po" class="table table-striped">
                                <!-- <thead>
                                    <tr>
                                        <th class="text-center col-md-1">No</th>
                                        <th>No Vendor</th>
                                        <th class="col-md-4">Nama Vendor</th>
                                        <th class="text-center">No PO</th>
                                        <th>Tgl PO</th>
                                        <th>History GR</th>
                                    </tr>
                                    <tr>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                    </tr>
                                </thead> -->
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif ?>
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
                                            <select class="tender_type" id="tender_type:<?php echo $val['PTV_VENDOR_CODE']; ?>" name="type_tender[]">
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
                                            <select id="list_principal:<?php echo $val['PTV_VENDOR_CODE']; ?>" name="list_principal[]" style="width: 250px;">
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
                            <select class="harusmilih_publicjs" name='harus_pilih'>
                                <option value="false_public"></option>
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

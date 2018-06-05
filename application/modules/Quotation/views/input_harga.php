<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Detail Penawaran</h2>
            </div>
            <input type="hidden" id="is_itemize" value="<?php echo $ptp['PTP_IS_ITEMIZE'] ?>">
            <input type="hidden" id="warning_ori" value="<?php echo $ptp['PTP_WARNING_ORI'] ?>">
            <form id="quohargaform" method="post" action="<?php echo base_url() ?>Quotation/save_harga" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_number; ?>">
                        <input type="hidden" name="tgl_batasPenawaran" value="<?php echo $ptm_detail['BATAS_VENDOR_HARGA_RG']; ?>">
                        <?php echo $detail_ptm ?>
                        <?php echo $dokumen_pr ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Document Aanwijing
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <tr>
                                        <td class=" col-md-3">Surat</td>
                                        <td class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <?php  

                                                    if($ptm_detail['DOC_AANWIZ'] != null){
                                                        ?>
                                                        <input type="hidden" class="delete" name="deletefilesurat" value="0">
                                                        <a href="<?php echo base_url()?>upload/temp/<?php echo $ptm_detail['DOC_AANWIZ'];?>" class="previousfile" target="_blank" >
                                                            File Exist
                                                        </a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        Tidak ada File
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-md-8">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Penawaran
                            </div>
                            <table class="table table-hover">
                                <tr>
                                    <td class=" col-md-3">Surat</td>
                                    <td class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <?php  
                                                if($pqm_id != null) 
                                                    if($pqm['FILE_SURAT'] != null){
                                                        ?>
                                                        <input type="hidden" class="delete" name="deletefilesurat" value="0">
                                                        <a href="<?php echo base_url('Quotation'); ?>/viewDok/<?php echo $pqm['FILE_SURAT']; ?>" class="previousfile" target="_blank" >
                                                            File Exist
                                                        </a>
                                                        <?php } else { ?>
                                                        Tidak ada File
                                                        <?php } ?>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <?php echo $pqm['PQM_NUMBER'] ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php foreach (array('penawaran', 'pelaksanaan', 'pemeliharaan') as $jam): ?>
                                            <?php if ($ptp['PTP_PERSEN_'.strtoupper($jam)] != ''): ?>
                                                <tr>
                                                    <td class="">Jaminan <?php echo ucfirst($jam) ?> <?php echo $ptp['PTP_PERSEN_'.strtoupper($jam)] ?>%</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <?php if ($pqm_id != null && !empty($pqm['PQM_FILE_'.strtoupper($jam)])): ?>
                                                                    <input type="hidden" class="delete" name="deletejaminan[<?php echo strtoupper($jam) ?>] ?>]" value="0">
                                                                    <a href="<?php echo base_url('Quotation'); ?>/viewDok/<?php echo $pqm['PQM_FILE_'.strtoupper($jam)]; ?>" class="previousfile" target="_blank" >
                                                                        File Exist
                                                                    </a>
                                                                    <a href="#!" onclick="deletefile(this)" class="previousfile"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                                                <?php else: ?>
                                                                    Tidak ada file
                                                                <?php endif ?>
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
                                                        <?php echo $pqm_id == null ? '' : $pqm['PQM_LOCAL_CONTENT'].' %' ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">Waktu Pengiriman</td>
                                            <td>
                                                <?php echo $pqm_id == null ? '' : $pqm['PQM_DELIVERY_TIME'] ?>
                                                <?php echo $pqm['PQM_DELIVERY_UNIT'] == 1 ? 'HARI' : '' ?>
                                                <?php echo $pqm['PQM_DELIVERY_UNIT'] == 2 ? 'BULAN' : '' ?>
                                                <?php echo $pqm['PQM_DELIVERY_UNIT'] == 3 ? 'Minggu' : '' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="" title="Tanggal validity harga">Berlaku Hingga</td>
                                            <td>
                                                <?php echo $pqm_id == null ? '' : date('Y-m-d', oraclestrtotime($pqm['PQM_VALID_THRU'])) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">Catatan</td>
                                            <td><?php echo $pqm_id == null ? '' : $pqm['PQM_NOTES'] ?></td>
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
                        <div class="panel panel-default">
                            <div class="panel-heading">Masukkan Penawaran Item Komersial</div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <th title="Centang untuk memilih item yang ditawarkan">No</th>
                                            <th><?php echo $ptm_detail['IS_JASA']==1? 'No PR' : 'Kode'; ?></th>
                                            <th>Deskripsi</th>
                                            <th>Jumlah</th>
                                            <th>UoM</th>
                                            <th>Spesifikasi</th>
                                            <th>Harga Satuan</th>
                                            <th nowrap>Sub Total</th>
                                            <th class="">Currency</th>
                                        </thead>
                                        <tbody id="itemtable">
                                            <?php $num=0;foreach ($tits as $row){ ?>
                                            <?php $thispqi = (isset($pqi[$row['TIT_ID']])) ? $pqi[$row['TIT_ID']] : null; ?>
                                            <?php if ($thispqi != null && $thispqi['DAPAT_UNDANGAN'] == 1): ?>
                                                <tr id="tritem<?php echo $row['TIT_ID']; ?>" class="tritem">
                                                    <td nowrap>
                                                        <input type="hidden" name="check[]" class="cekitem" value="<?php echo $row['TIT_ID'] ?>" checked>
                                                        <?php echo $num + 1 ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $ptm_detail['IS_JASA']==1?$row['PPI_PRNO']:$row['PPI_NOMAT']; ?>
                                                        <input name="ptqi[<?php echo $row['TIT_ID'] ?>][tit_id]" class="hidden tit_id" value="<?php echo $row['TIT_ID']; ?>">
                                                        <input name="ptqi[<?php echo $row['TIT_ID'] ?>][pqi_id]" class="hidden pqi_id" value="<?php echo $thispqi['PQI_ID']; ?>">
                                                        <input type="hidden" class="PPI_NOMAT" value="<?php echo $row['PPI_NOMAT']; ?>">
                                                        <input type="hidden" class="PPI_ID" value="<?php echo $row['PPI_ID']; ?>">
                                                        <input type="hidden" class="cek_dordor" value="false">
                                                        <input type="hidden" class="cek_warning">
                                                    </td>
                                                    <td class="open-material">
                                                        <a href="#!"><?php echo $row['PPI_DECMAT']; ?></a>
                                                    </td>
                                                    <td>
                                                        <span class=""><?php echo $thispqi == null ? $row['TIT_QUANTITY'] : $thispqi['PQI_QTY'] ?></span>
                                                        <input type="hidden" name="qty[<?php echo $row['TIT_ID']; ?>]" value="<?php echo $thispqi == null ? $row['TIT_QUANTITY'] : $thispqi['PQI_QTY'] ?>" class="pqi_quan text-right qtywow col-xs-12">

                                                        <input type="hidden" class="defprice" value="<?php echo $row['TIT_QUANTITY'] ?>">
                                                    </td>
                                                    <td>
                                                        <span><?php echo $row['PPI_UOM'] == '10' ? 'D' : $row['PPI_UOM'] ?></span>
                                                    </td>
                                                    <td>
                                                        <?php echo $thispqi['PQI_DESCRIPTION'] ?>
                                                    </td>
                                                    <td>
                                                        <?php if(!$viewSubmitted){ ?>
                                                        <input type="text" name="ptqi[<?php echo $row['TIT_ID'] ?>][pqi_price]" class="pqi_price text-right col-xs-12" value="<?php echo $thispqi['PQI_PRICE'] ?>" required >
                                                        <?php } else { ?>
                                                        <!-- <div align="center"><?php echo number_format($thispqi['PQI_PRICE']); ?></div> -->
                                                        <input type="text" name="ptqi[<?php echo $row['TIT_ID'] ?>][pqi_price]" class="pqi_price text-right col-xs-12" value="<?php echo $thispqi['PQI_PRICE'] ?>" disabled>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-right">
                                                       <span class="subtot hidden">0</span>
                                                       <span class="subtot_tampil">0</span>
                                                   </td>
                                                   <td class="">
                                                    <?php if(!$viewSubmitted){ ?>
                                                    <select name="ptqi[<?php echo $row['TIT_ID'] ?>][pqi_currency]" class="pqi_currency">
                                                        <option value="<?php echo $ptm_detail['PTM_CURR'] ?>"><?php echo $ptm_detail['PTM_CURR'] ?></option>
                                                    </select>
                                                    <?php } else { ?>
                                                    <div align="center"><?php echo $ptm_detail['PTM_CURR']; ?></div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php $num++; endif ?>
                                            <?php } ?>
                                            <input type="hidden" id="sum_tech_row" name="sum_tech_row" value="<?php echo $num ?>">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7" class="text-right"><strong>Total Sebelum PPN</strong></td>
                                                <td colspan="2" class="text-right"><strong id="total_before_ppn">0</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="7" class="text-right"><strong>Total Sesudah PPN</strong></td>
                                                <td colspan="2" class="text-right"><strong id="total_after_ppn">0</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">File Penawaran Harga</div>
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-4 form-required"><strong>File Upload</strong></td>
                                    <input type="hidden" id="id_ptv" value="<?php echo $vendor_data[0]['PTV_ID']; ?>">  
                                    <input type="hidden" id="fileLama_harga" name="fileLama_harga" value="<?php echo $vendor_data[0]['FILE_HARGA']; ?>"> 
                                    <td id="fileView"><a href="<?php echo base_url('Additional_document'); ?>/viewDok/<?php echo $vendor_data[0]['FILE_HARGA']; ?>" class="previousfile" target="_blank" >
                                        File Exist
                                        <?php if(!$viewSubmitted){ ?>
                                    </a> &nbsp;&nbsp;<a class="btn btn-default delete_upload_file">Delete</a>
                                    <?php } ?>
                                </td>
                                <?php if(!$viewSubmitted){ ?>
                                <td id="fileUpload">                                     
                                    <input type="hidden" id="file_harga" name="file_harga">  
                                    <button type="button" required class="uploadAttachment btn btn-default">Upload File</button><span class="filenamespan"></span>
                                    <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                        <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                    </div>
                                    <span  style="color:red; padding-left:20px; font-weight:bold;  display:none" id="msg_file">** File Upload harus diisi</span> 
                                </td>
                                <?php } else { ?>
                                <td>
                                    <?php echo (empty($vendor_data[0]['FILE_HARGA']))? 'File Not Exist' :''; ?>
                                </td>
                                <?php } ?>
                            </tr>
                        </table>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Upload File per Item untuk Evaluasi Teknis</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                       <?php $no=1; foreach ($tits as $tit): ?>
                                       <tr>
                                        <td width="50px" align="center"><?php echo $no++; ?></td>
                                        <td><?php echo $tit['PPI_NOMAT']; ?></td>
                                        <td><?php echo $tit['PPI_DECMAT']; ?></td>
                                        <td>
                                            <input type="hidden" id="vendor_no" value="<?php echo  $vendorno; ?>">
                                            <?php if(!empty($pef[$tit['TIT_ID']])) : ?>
                                                <input type="hidden" id="file_name<?php echo $tit['TIT_ID']; ?>" value="<?php echo $pef[$tit['TIT_ID']]; ?>">
                                                <div class="col-sm-8" id="fileView">
                                                    <a href="<?php echo base_url('Quotation'); ?>/viewDok/<?php echo $pef[$tit['TIT_ID']]; ?>" target="_blank" >File Exist</a> 
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
                            <td class="text-right"><?php echo(empty($po_header))?'':number_format($po_header['TOTAL_HARGA'],2,",",".") ?></td>
                            <td class="text-center"><?php echo(empty($item))?'': $val['CURR'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- END PO -->
            <input type="hidden" id="technical_item" name="technical_item">
            <div class="well well-sm text-center">
                <?php if(!$viewSubmitted){ ?>
                <a href="<?php echo base_url('Quotation') ?>" class="main_button color7 small_btn">Kembali</a>
                <button type="submit" id="save_bidding" class="main_button color6 small_btn">Simpan Penawaran</button>
                <?php } else {?>
                <a href="<?php echo base_url('Quotation') ?>/view_submittedQuotation" class="main_button color7 small_btn">Kembali</a>
                <?php }?>
            </div>
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
<script type="text/javascript">
    $(document).ready(function(){
        cekFile = $("#fileLama_harga").val();
        if(cekFile.length != 0){
            $("#fileView").show();
            $("#fileUpload").hide();
        }else{
            $("#fileView").hide();
            $("#fileUpload").show();
        }
    });
</script>
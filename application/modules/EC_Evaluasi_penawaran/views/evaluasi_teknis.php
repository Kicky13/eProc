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
                    <form method="post" id="form_assign" action="<?php echo base_url() ?>EC_Evaluasi_penawaran/assign">
                    <input type="hidden" name="ptm_number" value="<?php echo $ptm_number; ?>">
                    <input type="hidden" id="ptp_template_evatek" value="<?php echo $ptp['PTP_EVALUASI_TEKNIS']; ?>">
                    <div class="panel-group" id="accordionfilter" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordionfilter" href="#collapsefilter" aria-expanded="true" aria-controls="collapseOne">
                                        Assign to another user
                                    </a>
                                </h4>
                            </div>
                            <!-- <div id="collapsefilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <select id="deptselect">
                                        <option value="">Pilih Departmen</option>
                                        <?php foreach ($dept as $val): ?>
                                            <option value="<?php echo $val['DEPT_ID'] ?>"><?php echo $val['DEPT_NAME'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <select name="user" id="user">
                                        <option value="">Pilih User</option>
                                    </select>
                                    <button type="submit" class="main_button color6 small_btn" id="assign">Assign</button>
                                </div>
                            </div> -->
                            <div id="collapsefilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="field">
                                                <input type="text" value="" class="caridata form-control" id="nama_company" placeholder="Nama Company" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="field">
                                                <input type="text" value="" id="nama_unit" class="caridata form-control" placeholder="Nama Unit" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="field filterub0">
                                                <input type="text" value="" id="nama_posisi" class="caridata form-control" placeholder="Nama Posisi" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="field filterub0">
                                                <input type="text" value="" id="nama_pegawai" class="caridata form-control" placeholder="Nama Pegawai" />
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button id="search" class="main_button small_btn color2" type="button">Search</button>
                                        </div>
                                    </div>
                                    <br />
                                    <div id="data_assign"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    </form>

                    <form name="quotation-form" id="quotation-form" method="post" action="<?php echo base_url() ?>EC_Evaluasi_penawaran/save_bidding" class="submit" enctype="multipart/form-data">
                    <?php echo $evaluator ?>
                    <?php echo $detail_ptm ?>
                    
                     <div class="panel panel-default">
                        <div class="panel-heading">Tambahan Dokumen Pengadaan</div>
                        <table class="table">
                            <tr title="Dokumen tambahan yang di share ke vendor, selain dokumen item pr. Menempel pada level pengadaan">
                                <td class="col-md-1"></td>
                                <td class="divfiles2">
                                    <?php if (count($dokumen_pr_tam) <= 0): ?>
                                        Tidak ada dokumen tambahan.
                                    <?php else: ?>
                                    <?php foreach ($dokumen_pr_tam as $key => $value): ?>
                                        <a href="<?php echo base_url('Monitoring_prc'); ?>/viewDok/<?php echo $value['FILE']; ?>" target="_blank"><span class="glyphicon glyphicon-file"></span> <?php echo $value['NAME'] == '' ? $value['FILE'] : $value['NAME'] ?></a><br>
                                    <?php endforeach ?>
                                    <?php endif ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <?php echo $vendor_ptm ?>                    
                    <?php //echo $evaluasi ?>
                    <hr>
                    <div class="panel panel-default">
                            <div class="panel-heading">Evaluasi Teknis Prasyarat</div>
                            <div class="panel-body">
                                <div class="">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <th colspan="2"></th>
                                            <?php foreach ($evatek as $key => $value) { ?>                                                
                                            <th class="text-center"><strong><?php echo $ptv[$key]['VENDOR_NAME'] ?></strong></th>
                                            <?php } ?>
                                        </thead>
                                        <tbody id="">
                                            <?php foreach ($template_eval['detail'] as $value) { ?>    
                                                <?php if($value['PRASYARAT']==1) { ?>    
                                                    <tr style="vertical-align: top;"> 
                                                        <td style="vertical-align: top;">
                                                            <strong><?php echo $value['PPD_ITEM']; ?></strong>                                                            
                                                        </td>
                                                        <td>
                                                            <?php foreach ($value['uraian'] as $list) { ?> 
                                                                <div class="row" style="padding: 5px;">
                                                                    <div class="col-sm-12 col-md-12 col-lg-12"><?php echo $list['PPTU_ITEM'];?></div>
                                                                </div>              
                                                            <?php } ?>  
                                                        </td>
                                                        <?php foreach ($evatek as $key => $value2) { ?>
                                                        <td class="text-center">   
                                                        
                                                            <?php foreach ($value['uraian'] as $list) { ?>                                                               
                                                                <div class="row" style="padding: 5px;">                                                                        
                                                                   <div class="col-sm-12 col-md-12 col-lg-12">
                                                                   <?php foreach ($evatek[$key] as $pptu) {                                                       
                                                                    
                                                                        if($list['PPTU_ID']==$pptu['PPTU_ID']){
                                                                            echo $pptu['PQE_RESPON']==null?'-':$pptu['PQE_RESPON'];
                                                                            break;                                      
                                                                        }
                                                                   
                                                                   }?>
                                                                   </div>
                                                                </div>            
                                                            <?php } ?>  
                                                        </td>
                                            <?php } 
                                                 ?>
                                                        
                                                        
                                                    </tr>
                                                <?php } ?>    
                                            <?php } ?>    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <div class="panel panel-danger" style="display: none;">
                        <div class="panel-heading">Template Evaluasi</div>
                        <table class="table table-hover">
                            <tr>
                                <td class="form-required">Template Evaluasi</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Pilih Template Evaluasi" id="eval_id" name="eval_id" value="<?php echo isset($template_name)? $template_name['EVT_NAME'] : ''; ?>" disabled>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" id="selectIdTemplate"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-5 text-right">
                                            <span  style="color:red; padding-left:20px; font-weight:bold;  display:none" id="msg_eval_id" name="msg_eval_id">** Pilih Template Evaluasi</span>
                                            <input type="text" id="evt_id" class="hidden" name="evt_id" value="<?php echo isset($template_name)? $template_name['EVT_ID'] : ''; ?>">
                                        </div>
                                    </div>
                                </td>
                                <?php if(isset($template_name)): ?>
                                    <td> Hasil Evaluasi &nbsp;&nbsp;&nbsp;
                                        <a href="<?php echo base_url('Export_pdf'); ?>/print_evaluasi/<?php echo $ptm_number; ?>" title='print' target="_blank"><span class="glyphicon glyphicon-print"></span></a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        </table>
                    </div>

                    <hr>
                    <div id="template_detail">
                    <?php
                        if($ppd){
                           echo $template_update;
                        }
                    ?>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">List Tambahan Dokumen Evaluasi</div>
                        <table class="table">
                            <tr title="Dokumen tambahan yang di share ke vendor, selain dokumen item pr. Menempel pada level pengadaan">
                                <td class="col-md-1"></td>
                                <td class="divfiles1">
                                    <?php if (count($dokumentambahan) <= 0): ?>
                                        Tidak ada dokumen tambahan.
                                    <?php else: ?>
                                    <?php foreach ($dokumentambahan as $key => $value): ?>
                                        <a href="<?php echo base_url('Monitoring_prc'); ?>/viewDok/<?php echo $value['FILE']; ?>" target="_blank"><span class="glyphicon glyphicon-file"></span> <?php echo $value['NAME'] == '' ? $value['FILE'] : $value['NAME'] ?></a><br>
                                    <?php endforeach ?>
                                    <?php endif ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">Tambah Document</div>
                        <table class="table">
                            <tr title="Dokumen tambahan yang di share ke vendor, selain dokumen item pr. Menempel pada level pengadaan">
                                <!-- <td class="col-md-3">Dokumen Pengadaan</td> -->
                                <!-- update 26 mei 2016 -->
                                <td class="col-md-3">Dokumen Evatek</td>
                                <input type="hidden" name="numberfiles" class="numberfiles" value="1">
                                <td class=" divfiles">  
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
                    
                    <div id="history_pesan">
                    <?php
                        echo $pesan;
                    ?>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Klarifikasi Teknis dan Harga</div>
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

                    <?php echo $this->snippet->assignment($ptm_number) ?><?php echo $ptm_comment ?>
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
                                    <option value="1">Lanjut ke <?php echo $next_process['NAMA_BARU'] ?></option>
                                    <!-- <option value="0">Retender</option> -->
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
                            <input type="hidden" id="id_company" value="<?php echo $this->session->userdata['COMPANYID'] ?>">
                            <select id="companyId">
                                <option value="2000">Gresik</option>
                                <option value="3000">Padang</option>
                                <option value="4000">Tonasa</option>
                                <option value="99">All</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-hover" id="template-table" style="width: inherit;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tipe</th>
                                        <th>Company</th>
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
    </div>
</section>

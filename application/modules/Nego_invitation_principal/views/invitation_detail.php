<input type="text" class="hidden" id="base_url" value="<?php echo base_url(); ?>">
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Success!</strong> Data berhasil disimpan.
                        </div>
                    <?php endif ?>
                    <?php if ($this->session->flashdata('error') != false): ?>
                    <?php $error = $this->session->flashdata('error'); ?>
                    <div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <p>ERROR:</p>
                        <ul>
                            <?php foreach (json_decode($error) as $value): ?>
                                <li>&nbsp;&nbsp;&nbsp;<?php var_dump($value); ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <?php endif ?>
                    <?php
                    $url = "Nego_invitation_principal/do_update_tender_invitation/".$tender_invitation["PTV_ID"]."/".$tender_invitation["PTV_VENDOR_CODE"];
                    echo form_open($url,array('class' => 'form-horizontal tender_invitationForm','id'=>'form_ub','enctype'=>'multipart/form-data')); ?>
                   
                    <div class="panel panel-default">
                        <div class="panel-heading">Informasi Umum</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="NPP" class="col-sm-3 control-label">Nomor Pengadaan</label>
                                <label for="NPP" class="col-sm-9 text-left control-label">
                                    <strong><?php echo $tender_invitation['PTM_PRATENDER']; ?></strong>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="FIRSTNAME" class="col-sm-3 control-label">Deskripsi Pekerjaan</label>
                                <label for="FIRSTNAME" class="col-sm-9 text-left control-label">
                                    <strong><?php echo $tender_invitation['PTM_SUBJECT_OF_WORK']; ?></strong>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Informasi Pengadaan</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="NPP" class="col-sm-3 control-label">Pembukaan Pendaftaran</label>
                                <label for="NPP" class="col-sm-9 text-left control-label">
                                    <strong><?php echo empty($tender_invitation['PTP_REG_OPENING_DATE']) ? '' : betteroracledate(oraclestrtotime($tender_invitation['PTP_REG_OPENING_DATE'])) ?></strong>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="FIRSTNAME" class="col-sm-3 control-label">Penutupan Pendaftaran</label>
                                <label for="FIRSTNAME" class="col-sm-9 text-left control-label">
                                    <strong><?php echo empty($tender_invitation['PTP_REG_CLOSING_DATE']) ? '' : betteroracledate(oraclestrtotime($tender_invitation['PTP_REG_CLOSING_DATE'])) ?></strong>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="FIRSTNAME" class="col-sm-3 control-label">Tanggal Penutupan Negosiasi</label>
                                <label for="FIRSTNAME" class="col-sm-9 text-left control-label">
                                    <strong><?php echo empty($detail_nego['NEGO_END']) ? '' : betteroracledate(oraclestrtotime($detail_nego['NEGO_END'])) ?></strong>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Negosiasi</div>
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
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><textarea name="nego" class="form-control validate[required]" placeholder="Masukkan pesan nego"></textarea></td>
                                     <input id="iniptm" name="iniptm" type="hidden" value="<?php echo $iniptm; ?>" />
                                     <input type="hidden" id="nego_done" name="nego_done" value="<?php echo $detail_nego['NEGO_DONE']; ?>">
                                     <input type="hidden" id="nego_id" name="nego_id" value="<?php echo $detail_nego['NEGO_ID']; ?>">
                                     <input type="hidden" id="ptnv_id" name="ptnv_id" value="<?php echo (!empty($ptnv_id))?$ptnv_id:''; ?>">
                                     <input type="hidden" id="is_jasa" name="is_jasa" value="<?php echo $is_jasa?>">
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Item Pengadaan</div>
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
                                    <th class="text-right"><strong>Input Harga Nego</strong></th>
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
                                        <td class="text-right"><?php echo number_format($harga_nego[$value['TIT_ID']]); ?></td>
                                        <td class="text-right">
                                            <input type="hidden" name="pqi[<?php echo $no ?>][tit]" value="<?php echo $value['TIT_ID'] ?>">
                                            <input type="hidden" name="pqi[<?php echo $no ?>][pqi]" value="<?php echo $value['PQI_ID'] ?>">
                                            <input type="hidden" name="pqi[<?php echo $no ?>][idku]" value="<?php echo 'idku'.$no; ?>">
                                            <input type="hidden" class="input_final_price" name="pqi[<?php echo $no ?>][lm]" value="<?php echo $value['PQI_FINAL_PRICE']; ?>">
                                            <input type="hidden" class="input_pqi_price" name="pqi[<?php echo $no ?>][pen]" value="<?php echo $value['PQI_PRICE']; ?>">
                                            <input type="hidden" class="n_nego" value="<?php echo isset($n_nego[$value['TIT_ID']])?$n_nego[$value['TIT_ID']]:'0';?>">
                                            <input type="hidden" class="nego_end" value="<?php echo betteroracledate(oraclestrtotime($detail_nego['NEGO_END']))?>">

                                            <input type="text" id="<?php echo 'idku'.$no; ?>"  class="must_auto_numeric text-right input_price_value" name="pqi[<?php echo $no ?>][value]" value="<?php echo $nilai_def ;?>">
                                            <input type="hidden" class="cek_warning" value="false">
                                            <input type="hidden" class="cek_status" value="false">
                                            <input type="hidden" class="tit_id" value="<?php echo $value['TIT_ID'] ?>">
                                        </td>
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
                                    <a href="<?php echo site_url('Nego_invitation_principal/download_file/'.$ptnv_id.'/'.$vendorno); ?>" target="_blank" class="btn btn-default uploaded_file" style="float:left;" ><?php echo $FILE_UPLOAD;?></a>
                                    <?php }?>
                                <label class="btn btn-default" style="float: left" for="file_negosiasi">Pilih File</label> 
                                <div style=" width: 500px;height:30px; position: relative;float: left;  overflow: hidden;margin-left: 0px;margin-top:0px;" >                                        
                                    <input type="file" id="file_negosiasi" name="file_negosiasi" style="position: absolute;  left: 0; top: 0; margin-left: -80px; padding: 0px; cursor: pointer;">  
                                </div> 
                                </td>                                    
                            </tr>
                        </table>
                    </div>
					
                    <div class="panel panel-default">
                        <div class="panel-footer text-center">
                        <?php if ($tender_invitation['PTV_TENDER_TYPE']==2): ?>
                            <a href="<?php echo site_url('Nego_invitation_principal'); ?>" class="main_button small_btn reset_button color7">Kembali</a>
                            <?php if (oraclestrtotime($detail_nego['NEGO_END']) < strtotime('now')): ?>
                            &nbsp;<button class="main_button color1 small_btn" type="button" disabled title="Tidak bisa update harga sekarang">Update</button>
                            <?php else: ?>
                            <!-- &nbsp;<button class="main_button color1 small_btn" type="submit">Mengundurkan Diri</button> -->
                            &nbsp;<button id="save_bidding" class="main_button color6 small_btn" type="button">Update</button>
                            <?php endif ?>
                        <?php else: ?> 
                            <?php if ($tender_invitation['PTV_TENDER_TYPE']==1 && $tender_invitation['PTV_APPROVAL']==2): ?>
                                <a href="<?php echo site_url('Nego_invitation_principal'); ?>" class="main_button small_btn reset_button color7">Kembali</a>
                                &nbsp;<button id="save_bidding" class="main_button color6 small_btn" type="button">Approve</button>
                        	<?php elseif ($tender_invitation['PTV_TENDER_TYPE']==1 && $tender_invitation['PTV_APPROVAL']==4): ?>
                                <a href="<?php echo site_url('Nego_invitation_principal'); ?>" class="main_button small_btn reset_button color7">Kembali</a>
                                <?php if (oraclestrtotime($detail_nego['NEGO_END']) < strtotime('now')): ?>
                                &nbsp;<button class="main_button color1 small_btn" type="button" disabled title="Tidak bisa update harga sekarang">Update</button>
                                <?php else: ?>
                                <!-- &nbsp;<button class="main_button color1 small_btn" type="submit">Mengundurkan Diri</button> -->
                                &nbsp;<button id="save_bidding" class="main_button color6 small_btn" type="button">Update</button>
                                <?php endif ?>
                                
                            <?php endif ?>
                        <?php endif ?>
                        </div>
                        <input type="submit" id="ubsub" name="ubsub" style="display:none" value="" />
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<br>
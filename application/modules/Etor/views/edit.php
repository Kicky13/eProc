<?php
// echo "<pre>";
// print_r($tor_data);die;
?>
<style type="text/css">
    input[name="KOMEN"] { 
        height: 250px !important;
    }
</style>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">

            <div class="container">
                <?php
                $disabled = ""; 
                if($tor_data[0]['IS_SUBMIT']==0 || $tor_data[0]['IS_SUBMIT']=="0"){
                } else {
                    $disabled = "disabled=disabled";
                }
                ?>

                <div class="main_title centered upper">
                    <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
                </div>

                <!-- mulai refresh PR -->
                <?php
                if($disabled==""){
                    ?>

                    <div class="panel-group">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Panel Tarik PR</div>
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel-group" id="accordionperbarui" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" id="headingOne" role="button" data-toggle="collapse" data-parent="#accordionperbarui" href="#collapsePerbarui" aria-expanded="true" aria-controls="collapseOne">
                                                    <h4 class="panel-title">Refresh
                                                        &nbsp;&nbsp;&nbsp;<small>Last update: <span id="last_update"></span></small>
                                                    </h4>
                                                </div>
                                                <div id="collapsePerbarui" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <select id="berdasarkan" class="input-sm">
                                                                    <!-- <option value="all">Semua</option> -->
                                                                    <option value="pr">PR</option>
                                                                    <option value="request">Requestioner</option>
                                                                    <option value="mrp">MRPC-Plant</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input id="filter" type="text" class="input-sm" placeholder="Filter" maxlength="10">
                                                                <div id="select_mrp" class="hidden">
                                                                    <?php if (count($mrp) <= 0): ?>
                                                                        <input type="checkbox" class="invisible">Tidak ada MRP
                                                                    <?php endif ?>
                                                                    <?php foreach ($mrp as $val): ?>
                                                                        <div>
                                                                            <input type="checkbox" class="cekmrp" data-mrp="<?php echo $val['MRPC'] ?>" data-plant="<?php echo $val['PLANT'] ?>">
                                                                            <?php echo $val['MRPC'] ?>-<?php echo $val['PLANT'] ?>
                                                                        </div>
                                                                    <?php endforeach ?>
                                                                </div>
                                                                <input id="request" type="hidden" class="input-sm" value="<?php echo $request ?>" maxlength="10">
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button class="btn btn-default" id="renewPR">Refresh</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> 
                    <br>


                    <?php
                    if($prno!=null){
                        ?>
                        <br>
                        <div class="panel-group">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Panel Upload Dokumen</div>
                                <div class="panel-body">
                                    <?php echo form_open_multipart('Etor/store_tor/' . $prno); ?>
                                    <input type="hidden" name="halaman" value="edit">
                                    <input id="doc_cat" type="hidden" value="<?php echo $pr['PPR_DOC_CAT'] ?>">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Dokumen Pengadaan</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="document_file">Kategori</label>
                                                <select name="tipe" class="form-control" id="tipe_select"><option value="1">TOR/RKS/DWG/BQ</option><option value="2">ECE/OE</option><option value="3">LAIN-LAIN</option></select>
                                            </div>
                                            <div class="form-group">
                                                <label for="document_file">Deskripsi</label>
                                                <textarea name="desc" class="form-control" id="desc"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="document_file">File</label>
                                                <input type="file" class="form-control" id="file_input" name="file" placeholder="Pilih file..">
                                            </div>
                                            <div class="form-group">
                                                <label for="document_file">Pilih Item</label>
                                                <div class="panel panel-default">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <th class="text-center" nowrap><input type="checkbox" id="checkAll" title="pilih semua"></th>
                                                                <th class="text-center" nowrap>No</th>
                                                                <th class="text-center" nowrap>PR Item</th>
                                                                <th class="text-center" nowrap>Kode Material</th>
                                                                <th nowrap>Short Text</th>
                                                                <th class="text-center" nowrap>Mat Group</th>
                                                                <th class="text-center" nowrap>Unit</th>
                                                                <th class="text-center" nowrap>PR Qty</th>
                                                                <th class="text-center" nowrap>ECE</th>
                                                                <th class="text-center" nowrap>Value</th>
                                                            </thead>
                                                            <tbody id="items_table">
                                                                <?php $i = 1; foreach ($items as $val): ?>
                                                                <tr>
                                                                    <td class="text-center"><input type="checkbox" class="check-success chek_all" name="items[]" value="<?php echo $val['PPI_ID'] ?>"></td>
                                                                    <td class="text-center"><?php echo $i ?></td>
                                                                    <td class="text-center pritem"><?php echo $val['PPI_PRITEM'] ?></td>
                                                                    <td class="text-center nomat"><?php echo $val['PPI_NOMAT'] ?></td>
                                                                    <td nowrap>
                                                                        <a href="#!" class="decmat" onclick="open_dokumen(this)" data-ppi="<?php echo $val['PPI_ID'] ?>"><?php echo $val['PPI_DECMAT'] ?></a>
                                                                    </td>
                                                                    <td class="text-left matgroup" nowrap><?php echo $val['PPI_MATGROUP'] ?> <?php echo $val['matgrp']['MAT_GROUP_NAME'] ?></td>
                                                                    <td class="text-center uom"><?php echo $val['PPI_UOM'] ?></td>
                                                                    <td class="text-center prquantity"><?php echo $val['PPI_PRQUANTITY'] ?></td>

                                                                    <td class="text-center netprice"><?php echo number_format($val['PPI_NETPRICE'] * 100) ?></td>
                                                                    <td class="text-center netprice"><?php echo number_format(intval($val['PPI_NETPRICE'] * 100) * intval($val['PPI_PRQUANTITY'])); ?></td>
                                                                </tr>
                                                                <?php $i++; endforeach ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <button id="submit-form" type="submit" class="main_button color6 small_btn">Upload</button>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>

                                    <div class="panel panel-default">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <th>PR Item</th>
                                                    <th>Material</th>
                                                    <th>Kategori</th>
                                                    <th>Deskripsi</th>
                                                    <th>File</th>
                                                    <th>Tanggal</th>
                                                    <th>User</th>
                                                </thead>
                                                <tbody>
                                                    <?php if (count($docs) <= 0): ?>
                                                        <tr>
                                                            <td colspan="7">Belum ada dokumen. Silahkan upload dokumen.</td>
                                                        </tr>
                                                    <?php endif ?>
                                                    <?php foreach ($docs as $val): ?>
                                                        <tr>
                                                            <td><?php echo $itemid[$val['PPI_ID']]['PPI_PRITEM'] ?></td>
                                                            <td><?php echo $itemid[$val['PPI_ID']]['PPI_DECMAT'] ?></td>
                                                            <td><?php echo $val['PDC_NAME'] ?></td>
                                                            <td><?php echo $val['PPD_DESCRIPTION'] ?></td>
                                                            <td><a href="<?php echo base_url('Procurement_sap') ?>/viewDok/<?php echo $val['PPD_FILE_NAME']; ?>" target="_blank">Download</a></td>
                                                            <td><?php echo $val['PPD_CREATED_AT'] ?></td>
                                                            <td><?php echo $val['PPD_CREATED_BY'] ?></td>

                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div> 
                        <?php
                    }
                    ?>

                    <?php
                }
                ?>
                <!--end refresh PR  -->

                <form id="etor-form" enctype="multipart/form-data" method="post" action="<?php echo base_url()?>Etor/doUpdateMain">
                    <input type="hidden" name="loaddt" id="loaddt" value="edit">
                    <input type="hidden" name="ID_TOR" id="ID_TOR" value="<?php echo $tor_data[0]['ID_TOR']; ?>">
                    <div class="row">
                        <div class="col-md-4">
                            JUDUL :
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="JENIS_TOR" class="form-control" value="<?php echo $tor_data[0]['JENIS_TOR']; ?>" <?php echo $disabled; ?>>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            Evaluator :<br>
                            <b>*Akan digunakan sebagai evaluator saat pengajuan evaltek</b>
                        </div>
                        <div class="col-md-8">
                            <?php
                            echo (count($emp_evaluator)>0 ? $emp_evaluator[0]['FULLNAME'] : "Belum memilih evaluator");
                            ?>
                            <?php
                            if($tor_data[0]['IS_SUBMIT']==0 || $tor_data[0]['IS_SUBMIT']=="0"){
                                ?>
                                <button class="gantievaluator main_button color1 small_btn" type="button">Ganti</button>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <br>
                    <div class="row gantievaluatorselect">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-8">
                            <select name="PIC" value="" class="form-control select2 pegawai" <?php echo $disabled; ?>>
                                <option disabled value>Pilih PIC</option>
                            </select>
                        </div>
                    </div>
                    <?php
                    if($tor_data[0]['IS_SUBMIT']==0 || $tor_data[0]['IS_SUBMIT']=="0"){
                        ?>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                No PR :
                            </div>
                            <div class="col-md-8">
                                <select name="NO_PR" value="" class="form-control select2">
                                    <option value="">Pilih PR</option>
                                    <?php
                                    if($prno!=null){
                                        ?>
                                        <option value="<?php echo $prno; ?>" selected=selected><?php echo $prno; ?></option>
                                        <?php
                                    }
                                    ?>
                                    <?php foreach ($data_pr['data'] as $dpr ) :?>
                                        <?php
                                        $selected = "";
                                        if($dpr['PPR_PRNO']==$tor_data[0]['NO_PR']){
                                            $selected = "selected=selected";
                                        }
                                        ?>
                                        <option <?php echo $selected; ?> value="<?php echo $dpr['PPR_PRNO'];?>"><?php echo $dpr['PPR_PRNO'].'-'.$dpr['PPR_DOCTYPE'];?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="enar_accordion plus_minus" data-type="toggle">
                                    <div class="enar_occ_container">
                                        <span class="enar_occ_title green">
                                            <input type="checkbox" <?php if($tor_data[0]['IS_SHOW1']==1 || $tor_data[0]['IS_SHOW1']=='1') echo "checked"; ?> value="1" name="IS_SHOW1">
                                            I. PENDAHULUAN
                                        </span>
                                        <div class="enar_occ_content">
                                            <div class="acc_content">
                                                <div class="form-group">
                                                    <!-- <textarea class="form-control" rows="14" id="LATAR_BELAKANG" name="LATAR_BELAKANG"><?php echo $tor_data[0]['LATAR_BELAKANG']; ?></textarea> -->
                                                    <?php echo $this->ckeditor->editor('LATAR_BELAKANG',$tor_data[0]['LATAR_BELAKANG']);?>
                                                    <?php //echo $this->ckeditor->editor('LATAR_BELAKANG',$COBA_LATAR_BELAKANG);?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="enar_accordion plus_minus" data-type="toggle">
                                    <div class="enar_occ_container">
                                        <span class="enar_occ_title green">
                                            <input type="checkbox" <?php if($tor_data[0]['IS_SHOW2']==1 || $tor_data[0]['IS_SHOW2']=='1') echo "checked"; ?> value="1" name="IS_SHOW2">
                                            II. MAKSUD DAN TUJUAN
                                        </span>
                                        <div class="enar_occ_content">
                                            <div class="acc_content">
                                                <!-- <textarea class="form-control" rows="14" id="MAKSUD_TUJUAN" name="MAKSUD_TUJUAN"><?php echo $tor_data[0]['MAKSUD_TUJUAN']; ?></textarea> -->
                                                <?php echo $this->ckeditor->editor('MAKSUD_TUJUAN',$tor_data[0]['MAKSUD_TUJUAN']);?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="enar_accordion plus_minus" data-type="toggle">
                                    <div class="enar_occ_container">
                                        <span class="enar_occ_title green">
                                            <input type="checkbox" <?php if($tor_data[0]['IS_SHOW3']==1 || $tor_data[0]['IS_SHOW3']=='1') echo "checked"; ?> value="1" name="IS_SHOW3">
                                            III. LINGKUP PEKERJAAN & SPESIFIKASI
                                        </span>
                                        <div class="enar_occ_content">
                                            <div class="acc_content">
                                                <!-- <textarea class="form-control" rows="14" id="PENJELASAN_APP" name="PENJELASAN_APP"><?php echo $tor_data[0]['PENJELASAN_APP']; ?></textarea> -->
                                                <?php echo $this->ckeditor->editor('PENJELASAN_APP',$tor_data[0]['PENJELASAN_APP']);?>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="enar_accordion plus_minus" data-type="toggle">
                                    <div class="enar_occ_container">
                                        <span class="enar_occ_title green">
                                            <input type="checkbox" <?php if($tor_data[0]['IS_SHOW4']==1 || $tor_data[0]['IS_SHOW4']=='1') echo "checked"; ?> value="1" name="IS_SHOW4">
                                            IV. WAKTU PELAKSANAAN
                                        </span>
                                        <div class="enar_occ_content">
                                            <div class="acc_content">
                                                <!-- <textarea class="form-control" rows="14" id="RUANG_LINGKUP" name="RUANG_LINGKUP"><?php echo $tor_data[0]['RUANG_LINGKUP']; ?></textarea> -->
                                                <?php echo $this->ckeditor->editor('RUANG_LINGKUP',$tor_data[0]['RUANG_LINGKUP']);?>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="enar_accordion plus_minus" data-type="toggle">
                                    <div class="enar_occ_container">
                                        <span class="enar_occ_title green">
                                            <input type="checkbox" <?php if($tor_data[0]['IS_SHOW5']==1 || $tor_data[0]['IS_SHOW5']=='1') echo "checked"; ?> value="1" name="IS_SHOW5">
                                            V. KRITERIA SDM
                                        </span>
                                        <div class="enar_occ_content">
                                            <div class="acc_content">
                                                <!-- <textarea class="form-control" rows="14" id="PRODUK" name="PRODUK"><?php echo $tor_data[0]['PRODUK']; ?></textarea> -->
                                                <?php echo $this->ckeditor->editor('PRODUK',$tor_data[0]['PRODUK']);?>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="enar_accordion plus_minus" data-type="toggle">
                                    <div class="enar_occ_container">
                                        <span class="enar_occ_title green">
                                            <input type="checkbox" <?php if($tor_data[0]['IS_SHOW6']==1 || $tor_data[0]['IS_SHOW6']=='1') echo "checked"; ?> value="1" name="IS_SHOW6">
                                            VI. DELIVERABLE
                                        </span>
                                        <div class="enar_occ_content">
                                            <div class="acc_content">
                                                <!-- <textarea class="form-control" rows="14" id="KUALIFIKASI" name="KUALIFIKASI"><?php echo $tor_data[0]['KUALIFIKASI']; ?></textarea> -->

                                                <?php echo $this->ckeditor->editor('KUALIFIKASI',$tor_data[0]['KUALIFIKASI']);?>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="enar_accordion plus_minus" data-type="toggle">
                                    <div class="enar_occ_container">
                                        <span class="enar_occ_title green">
                                            <input type="checkbox" <?php if($tor_data[0]['IS_SHOW7']==1 || $tor_data[0]['IS_SHOW7']=='1') echo "checked"; ?> value="1" name="IS_SHOW7">
                                            VII. KETENTUAN LAIN-LAIN
                                        </span>
                                        <div class="enar_occ_content">
                                            <div class="acc_content">
                                                <!-- <textarea class="form-control" rows="14" id="TIME_FRAME" name="TIME_FRAME"><?php echo $tor_data[0]['TIME_FRAME']; ?></textarea> -->
                                                <?php echo $this->ckeditor->editor('TIME_FRAME',$tor_data[0]['TIME_FRAME']);?>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <?php } else {
                            ?>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    No PR :
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="NO_PR" class="form-control" value="<?php echo $tor_data[0]['NO_PR']; ?>" <?php echo $disabled; ?>>
                                </div>
                            </div>
                            <br>
                            <div class="panel-group">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Panel Dokumen TOR</div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a href="<?php echo base_url()?>upload/etor/<?php echo $tor_data[0]['TOR'];?>">ATTACHMENT DOC TOR</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php

                        } ?>

                        <br>
                        <div class="panel-group">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Panel Approval</div>
                                <div class="panel-body">

                                    <?php
                                    if($tor_data[0]['IS_SUBMIT']==0 || $tor_data[0]['IS_SUBMIT']=="0"){
                                        ?>

                                        <div class="row">
                                            <div class="col-md-4">
                                                Approval :
                                            </div>
                                            <div class="col-md-4">
                                                <select id="vendor" name="vendor" value="" class="form-control select2 vnd pegawai">
                                                    <option disabled selected value>Pilih Approval</option>
                                                </select>
                                                <input type="hidden" name="kd_vnd" id="kd_vnd" value="">
                                                <input type="hidden" name="nama_vnd" id="nama_vnd" value="">  
                                            </div>
                                            <div class="col-md-4">
                                                <button class="tambah_approval btn btn-warning" type="button">TAMBAH APPROVAL</button>
                                            </div>
                                        </div>

                                        <?php
                                    }
                                    ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            LIST APPROVAL
                                            <div class="listpeg"></div>
                                            <table id="tbl_group_akses" class="table table-striped" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="col-md-2">Pegawai</th>
                                                        <th class="col-md-2">Approval ke-</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    <tr>
                                                        <th><input type="text" class="col-xs-12"></th>
                                                        <th><input type="text" class="col-xs-12"></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <br>
                        <div class="panel-group">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Panel Komentar</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            LIST KOMENTAR
                                            <div class="listpeg"></div>
                                            <table id="tbl_group_akses_komentar" class="table table-striped" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="col-md-2">Pegawai</th>
                                                        <th class="col-md-2">Komentar</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    <tr>
                                                        <th><input type="text" class="col-xs-12"></th>
                                                        <th><input type="text" class="col-xs-12"></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <br>
                        <?php
                        if($tor_data[0]['IS_SUBMIT']==0 || $tor_data[0]['IS_SUBMIT']=="0"){
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-body text-center">
                                    <div class="row">
                                        <div class="col-md-4">
                                            Komentar :
                                        </div>
                                        <div class="col-md-8">
                                            <!-- <textarea class="form-control" rows="4" id="KOMEN" name="KOMEN" <?php echo $disabled; ?>><?php echo $tor_data[0]['KOMEN'];?></textarea> -->
                                            <?php echo $this->ckeditor->editor('KOMEN',$tor_data[0]['KOMEN']);?>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <center>
                                                <select name="type">
                                                    <option value="0">draft</option>
                                                    <option value="1">submit</option>
                                                </select>
                                                <button class="main_button color4 small_btn action-button">PROSES</button>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>

                            <div class="panel-group">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Panel Dokumen</div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="panel panel-default">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-striped">
                                                            <thead>
                                                                <th>PR Item</th>
                                                                <th>Material</th>
                                                                <th>Kategori</th>
                                                                <th>Deskripsi</th>
                                                                <th>File</th>
                                                                <th>Tanggal</th>
                                                                <th>User</th>
                                                            </thead>
                                                            <tbody>
                                                                <?php if (count($docs) <= 0): ?>
                                                                    <tr>
                                                                        <td colspan="7">Belum ada dokumen. Silahkan upload dokumen.</td>
                                                                    </tr>
                                                                <?php endif ?>
                                                                <?php foreach ($docs as $val): ?>
                                                                    <tr>
                                                                        <td><?php echo $itemid[$val['PPI_ID']]['PPI_PRITEM'] ?></td>
                                                                        <td><?php echo $itemid[$val['PPI_ID']]['PPI_DECMAT'] ?></td>
                                                                        <td><?php echo $val['PDC_NAME'] ?></td>
                                                                        <td><?php echo $val['PPD_DESCRIPTION'] ?></td>
                                                                        <td><a href="<?php echo base_url('Procurement_sap') ?>/viewDok/<?php echo $val['PPD_FILE_NAME']; ?>" target="_blank">Download</a></td>
                                                                        <td><?php echo $val['PPD_CREATED_AT'] ?></td>
                                                                        <td><?php echo $val['PPD_CREATED_BY'] ?></td>

                                                                    </tr>
                                                                <?php endforeach ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-body text-center">
                                    <div class="row">
                                        <div class="col-md-4">
                                            Komentar :
                                        </div>
                                        <div class="col-md-8">
                                            <!-- <?php echo html_entity_decode($tor_data[0]['KOMEN']);?> -->
                                            <?php echo $this->ckeditor->editor('KOMEN',$tor_data[0]['KOMEN']);?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                        <br>
                        <br>
                    </form>

                </div>
            </div>
        </div>
    </section>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

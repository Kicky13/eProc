<?php 
// print_r($tor_data[0]);
?>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="container">
                <div class="main_title centered upper">
                    <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
                </div>

                <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>Etor/doUpdateApprove">
                    <input type="hidden" name="loaddt" id="loaddt" value="approve">
                    <input type="hidden" name="ID_TOR" id="ID_TOR" value="<?php echo $tor_data[0]['ID_TOR']; ?>">
                    <div class="row">
                        <div class="col-md-4">
                            JUDUL :
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="JENIS_TOR" class="form-control" disabled="disabled" value="<?php echo $tor_data[0]['JENIS_TOR']; ?>">
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
<!--                     <br>

                    <div class="panel-group">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Panel Approval</div>
                            <div class="panel-body">

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
                    </div> -->
                    <br>
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
                                    <textarea class="form-control" rows="4" id="KOMEN" name="KOMEN"></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <select name="type">
                                            <option value="1">Approve</option>
                                            <option value="0">Reject</option>
                                        </select>
                                        <button class="main_button color4 small_btn action-button">PROSES</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

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

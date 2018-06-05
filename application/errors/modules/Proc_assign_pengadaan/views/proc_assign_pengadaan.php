<?php if (isset($cheat)): ?>
    <input type="hidden" id="cheat" value="true">
<?php else: ?>
    <input type="hidden" id="cheat" value="false">
<?php endif ?>
<form method="post" action="<?php echo base_url('Proc_assign_pengadaan/update') ?>">
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title; ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php if ($success == 'success'): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Success!</strong> Proses berhasil dipindahtangankan.
                        </div>
                    <?php elseif ($success == 'fail'): ?>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Gagal!</strong> Proses dan/atau user belum dipilih.
                        </div>
                    <?php endif ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Proses</div>
                        <div class="panel-body">
                            <table id="job-list-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="col-md-2">Nomor Pengadaan</th>
                                        <th>Deskripsi</th>
                                        <th>PGRP</th>
                                        <th>Status</th>
                                        <th>Tanggal Aktivitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Assign To</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <label>Assign To</label>
                                    <div class="field">
                                        <input type="hidden" value="" id="tampil" name="tampil">
                                        <?=form_dropdown('assignto', $assignto,'','id="assignto"  class="form-control"')?>
                                        <span class="help-block"></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <button type="submit" class="main_button color6 small_btn">Assign</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</form>
<br>
<br>
<br>
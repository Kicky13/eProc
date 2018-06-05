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
                        <?php if ($this->session->flashdata('rfc_ft_return') != false): ?>
                        <?php $rfc_ft_return = json_decode($this->session->flashdata('rfc_ft_return')); ?>
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <p>FT_RETURN:</p>
                            <ul>
                                <?php foreach ($rfc_ft_return as $key => $value): ?>
                                    <li>&nbsp;&nbsp;&nbsp;<?php echo $value->MESSAGE ?></li>
                                <?php endforeach ?>
                            </ul>
                            <div class="hidden hasil rfc">
                                <?php echo var_dump($rfc_ft_return) ?>
                            </div>
                        </div>
                        <?php endif ?>
                            <table id="job-list-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="col-md-2">Nomor Pengadaan</th>
                                        <th>Deskripsi</th>
                                        <th>Tgl Akhir Nego</th>
                                        <th>Status Nego</th>
                                        <th class="col-md-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
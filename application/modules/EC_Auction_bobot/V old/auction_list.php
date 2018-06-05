<?php if (isset($status)) ?>
<section class="content_section">
    <input type="hidden" id="status" value="<?php echo $status; ?>">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">                        
                        <table id="auction-list-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Usulan Pratender </th>
                                    <th>No Pratender</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Tgl Mulai</th>
                                    <th>Tgl Akhir</th>
                                    <th>Aksi</th>
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
</section>
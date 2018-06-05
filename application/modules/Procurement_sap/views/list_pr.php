<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <span id="istor" class="hidden"><?php echo $istor ?></span>
            <div class="row">
                <div class="col-md-12">
                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Success!</strong> Data berhasil diverifikasi.
                        </div>
                    <?php endif ?>
                    <?php if ($reject): ?>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Success!</strong> Data berhasil ditolak.
                        </div>
                    <?php endif ?>
                    <?php if ($terverifikasi): ?>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Data sudah terverifikasi.
                        </div>
                    <?php endif ?>
                    
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="pr-list-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor PR</th>
                                    <th>Short Text</th>
                                    <th>Doc. Type</th>
                                    <th>Plant</th>
                                    <!-- <th>Purchase Org.</th> -->
                                    <th>Requestioner</th>
                                    <th>Approval Date</th>
                                    <th>Submit Date</th>
                                    <th>Count Date</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                  <th></th>
                                  <th><input type="text" class="col-xs-12"></th>
                                  <th><input type="text" class="col-xs-12"></th>
                                  <th><input type="text" class="col-xs-12"></th>
                                  <th><input type="text" class="col-xs-12"></th>
                                  <th><input type="text" class="col-xs-12"></th>
                                  <th><input type="text" class="col-xs-12"></th>
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
</section>

<div id="curtain" style="display: none; position: fixed; width: 100%; height: 100%; background-color: rgba(255,255,255,.5); z-index: 9999">
    <div class="spinner">
        <div class="sk-dot1"></div><div class="sk-dot2"></div>
        <div class="rect3"></div><div class="rect4"></div>
        <div class="rect5"></div>
    </div>
</div>


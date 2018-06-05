<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <span id="istor" class="hidden"><?php echo $istor ?></span>
            <div class="row">
                <div class="col-md-12" style="margin-bottom:5px;">
                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Success!</strong> Data berhasil disimpan.
                        </div>
                    <?php endif ?>
                    <?php if ($istor == 'true'): ?>
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
                    <?php endif ?>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="pr-list-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor PR</th>
                                    <th>Doc. Type</th>
                                    <!-- <th>Header Text</th> -->
                                    <th>Plant</th>
                                    <th>Requestioner</th>
                                    <th>Approval Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th><input type="text" class="col-xs-12"></th>
                                    <th><input type="text" class="col-xs-12"></th>
                                    <th><input type="text" class="col-xs-12"></th>
                                    <th><input type="text" class="col-xs-12"></th>
                                    <th><input type="text" class="col-xs-12"></th>
                                    <!-- <th><input type="text" class="col-xs-12"></th> -->
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


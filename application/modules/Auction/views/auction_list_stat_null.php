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
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
                            </div>
                        <?php endif ?>
                        <table id="auction-list-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Usulan Pratender </th>
                                    <th>No Pratender</th>
                                    <th>Subject</th>
                                    <th>Requester Name</th>
                                    <th>Status</th>
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
<?php if (isset($status)) ?>
<section class="content_section">
<form method="post" action="<?php echo base_url() ?>Tender_winner/detail/" novalidate>
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <table id="approval-po-list-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <!-- <th>PR No</th>
                                        <th>Ebeln</th> -->
                                        <th>Vendor Name</th>
                                        <th>Description</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <button id="submit-form" type="submit" class="main_button color6 small_btn">Submit</button>
                        <a href="<?php echo current_url(); ?>" class="main_button color7 small_btn">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</section>

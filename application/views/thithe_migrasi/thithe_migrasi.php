<section class="content_section">
    <div class="content row_spacer clearfix" style="padding-top: 40px">
        <div class="rows_container clearfix">
            <div class="col-md-12">
                <div class="main_title centered upper">
                    <h2>
                        <span class="line"><i class="ico-user3"></i></span>
                        Sign
                        <span class="main_title_c1"> in</span>
                    </h2>
                </div>
            </div>
        </div>
        <div class="rows_container clearfix">
            <div class="col-md-4 col-md-offset-4">
                <form class="form-horizontal" action="<?php echo base_url()?>Thithe_migrasi/do_upload" enctype="multipart/form-data" method="POST">
                    <select name="table_gan">
                        <option value="VND_IJIN">VND_IJIN</option>
                        <option value="VND_ADDRESS">VND_ADDRESS</option>
                        <option value="VND_AKTA">VND_AKTA</option>
                        <option value="VND_AGENT">VND_AGENT</option>
                        <option value="VND_BOARD">VND_BOARD</option>
                        <option value="VND_BANK">VND_BANK</option>
                        <option value="HIST_VND_HEADER">HIST_VND_HEADER</option>
                        <option value="VND_PRODUCT_UPDATE">VND_PRODUCT_UPDATE</option>
                    </select>
                    <div class="form-group">
                        <label for="new_pajak" class="col-sm-1 control-label" style="width: auto;">Upload Excel :</label>
                        <div>
                            <input type="file" name="import_excel" required>
                        </div>
                    </div>
                    <div>
                        <button type="submit" style="margin-left: 100px" class="btn btn-success btn-md btn-excel">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
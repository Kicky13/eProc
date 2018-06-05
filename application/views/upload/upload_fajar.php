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
            <div class="col-md-8 col-md-offset-4">
                <form class="form-horizontal" action="<?php echo base_url()?>Do_upload_m/do_upload" enctype="multipart/form-data" method="POST">
                    <div class="form-group">
                        <label for="new_pajak" class="col-sm-1 control-label" style="width: auto;">Select Kategory </label>
                        <select name="table_gan">
                            <option value="LAP_KEU">LAPORAN KEUANGAN</option>
                            <option value="BARANG_DIPASOK">BARANG YANG DI PASOK</option>
                            <option value="JASA_DISUPLAI">JASA YANG DI SUPLAI</option>
                            <option value="SERTIFIKASI">SERTIFIKASI</option>
                            <option value="PENGALAMAN">PENGALAMAN</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="new_pajak" class="col-sm-1 control-label" style="width: auto;">Upload File </label>
                        <div class="col-md-4">
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
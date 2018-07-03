<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php
            $pesannya = $this->session->flashdata('message');
            if (!empty($pesannya)) {
                echo '<div class="alert alert-danger">' . $pesannya . '</div>';
            }
            ?>
          <?php echo form_open_multipart('EC_Invoice_ver/EC_Cancel_Invoice/cancelInvoice/', array('method' => 'POST', 'class' => 'form-horizontal formEdit', 'id' => 'formDetailInvoice')); ?>
            <div class="panel panel-default">
                <div class="panel-heading">Form Cancel Invoice Dengan Status <strong>Park ( belum posting ) </strong></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12 col-lg-12">
                            <div class="form-group">
                                <?php
                                if (isset($pesan) && !empty($pesan)) {
                                    echo '<div class="col-md-12" style="text-align:center;margin:2px auto"><span class="col-md-12 alert alert-danger">' . $pesan . '</span></div>';
                                }
                                ?>
                            </div>

                            <div class="form-group">
                                <label for="Invoice Date" class="col-sm-2 control-label">Nomer Mir</label>
                                <div class="col-sm-3 tgll">
                                    <div class="input-group date startDate">
                                        <input  class="form-control" name="mir"  type="text" required />

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Invoice No" class="col-sm-2 control-label">Tahun</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" maxlength="4" name="tahun">
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="Invoice No" class="col-sm-2 control-label">Nomer PO</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" required maxlength="10" name="po_number">
                                </div>
                            </div>
                            <div class="form-group">
                              <label for="Invoice No" class="col-sm-2 control-label">Alasan</label>
                                <div class="col-sm-10">
                                    <textarea maxlength="300" name="alasan_reject" required class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <button class="btn btn-info" type="reset">Reset</button>
                                    <button class="btn btn-info" type="submit">Simpan</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

          <?php echo form_close() ?>
        </div>
    </div>
</section>

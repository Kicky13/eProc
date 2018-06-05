<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Pembatalan Pengadaan</h2>
            </div>
            <?php echo form_open_multipart('Procurement_pembatalan/batal'); ?>
            <div class="row">
                <div class="col-md-8 col-md-offset-2" id="areyou">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cari Pengadaan</div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-4">Nomor Pengdaan</td>
                                <td>
                                    <input type="text" name="nomor_pengadaan" id="nomor_pengadaan" class="input-sm">
                                    <button class="btn btn-default btn-sm" type="button" id="cari">Cari</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-8 col-md-offset-2 hidden" id="serious">
                    <div class="panel panel-default">
                        <div class="panel-heading">Komentar Anda</div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-4">Komentar</td>
                                <td>
                                    <textarea name="comment" class="form-control" style="resize:vertical"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Attachment</td>
                                <td>
                                    <Input type="file" name="attachment" class="form-control" placeholder="Pilih file.."></Input>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <button type="submit" class="main_button color1 small_btn">Batalkan Pengadaan</button>
                            <button type="button" class="main_button color7 small_btn" id="cancel">Kembali</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>
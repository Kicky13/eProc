<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" id="templateModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editItemModalLabel">Available Template</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover" id="template-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Id</th>
                                    <th>Nama</th>
                                    <th>Tipe</th>
                                    <th>Lihat</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="collapse" id="detailTemplt">
                            <table class="table table-hover" id="detail-template-table">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Mode</th>
                                        <th>Bobot</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="main_button color6" id="updateItem" data-dismiss="modal">Pilih</button>
            </div>
        </div>
    </div>
</div>

<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Konfigurasi Pengadaan</h2>
            </div>
            <?php echo form_open_multipart('Procurement_pratender/get_detail'); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Informasi Pengadaan</div>
                        <table class="table table-hover">
                            <tr>
                                <td>User</td>
                                <td><?php echo $this->session->userdata['FULLNAME'] ?></td>
                            </tr>
                            <tr>
                                <td>Biro / Unit</td>
                                <td><?php echo $this->session->userdata['POS_NAME'] ?></td>
                            </tr>
                            <tr>
                                <td>Deskripsi</td>
                                <td><input type="text" class="form-control" name="subject" placeholder="Deskripsi singkat pengadaan"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Pilih item</div>
                        <div class="panel-body">
                            <table id="pr-list-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor PR</th>
                                        <th>Item</th>
                                        <th>Kode Item</th>
                                        <th>Nama Item</th>
                                        <th>PR Qty</th>
                                        <th>Open Qty</th>
                                        <th>PO Qty</th>
                                        <th>Doc Type</th>
                                        <th>Plant</th>
                                        <th>Release Date</th>
                                        <th>PORG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <font color="red"><?php echo form_error('item'); ?></font>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Item Terpilih
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <th class="text-center col-md-2">PR No</th>
                                    <th class="text-center col-md-1">PR Item</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center col-md-1">Quantity</th>
                                    <th class="text-center col-md-1">Uom</th>
                                    <th class="text-center col-md-1">Harga</th>
                                </thead>
                                <tbody id="tableItem">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Komentar Anda</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-6">Komentar</td>
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
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <select class="harusmilih_publicjs">
                                <option value="false_public"></option>
                                <!-- <option>Lanjut ke aproval Subpratender.</option> -->
                                <option>Lanjut ke <?php echo $next_process['NAMA_BARU']; ?></option>
                            </select>
                            <button type="submit" class="main_button color7 small_btn milihtombol_publicjs" disabled>OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>

<section class="content_section">
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

    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php echo form_open_multipart(base_url('Procurement_reschedule/save_bidding'), array('method' => 'POST','class' => 'submit')); ?>
            <input type="hidden" name="ptm_number" id="ptm_number" value="<?php echo $ptm['PTM_NUMBER'] ?>">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Error!</strong> <?php var_dump($this->session->flashdata('error')); ?>
                        </div>
                    <?php endif ?>
                    <?php if ($this->session->flashdata('create_rfq') != false): ?>
                    <?php $create_rfq = $this->session->flashdata('create_rfq'); ?>
                    <?php $hasil_rfq = $this->session->flashdata('hasil_rfq'); ?>
                    <div class="panel panel-danger">
                        <div class="panel-body">
                            <p>Error create RFQ with message: "<?php echo $hasil_rfq['return']['MESSAGE'] ?>"</p>
                            <p>Input RFQ:</p>
                            <ul>
                                <?php foreach ($create_rfq as $key => $value): ?>
                                    <li><?php echo $key ?>: <?php echo $value ?></li>
                                <?php endforeach ?>
                            </ul>
                            <div class="hidden hasil rfq">
                                <?php echo var_dump($hasil_rfq) ?>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Jadwal Pengadaan</div>
                        <table class="table">
                            <tr>
                                <td clas="col-md-5">RFQ Date</td>
                                <td>
                                    <div class="input-group col-md-12">
                                        <input type="text" name="ptp_reg_opening_date" readonly="true" class="form-control" value="<?php echo betteroracledate(oraclestrtotime($ptp['PTP_REG_OPENING_DATE'])) ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td clas="col-md-5">Quotation Deadline</td>
                                <td>
                                    <!-- <?php //if($ptm['PTM_STATUS'] == '8'){ ?>  status 8 = kirim rfq -->
                                    <?php if($ptm['MASTER_ID'] == '6'){ ?>  <!-- nyo 230217 -->
                                    <input type="hidden" name="ptm_status" value="<?php echo $ptm['PTM_STATUS']?>">
                                    <div class="input-group date">
                                        <input type="text" name="ptp_reg_closing_date" class="form-control" value="<?php echo betteroracledate(oraclestrtotime($ptp['PTP_REG_CLOSING_DATE'])) ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                    <?php }else{ ?>
                                    <div class="input-group col-md-12">
                                        <input type="text" name="ptp_reg_closing_date" readonly="true" class="form-control" value="<?php echo betteroracledate(oraclestrtotime($ptp['PTP_REG_CLOSING_DATE'])) ?>">
                                    </div>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td clas="col-md-5">Delivery Date</td>
                                <td>
                                    <div class="input-group col-md-12">
                                        <input type="text" name="ptp_delivery_date" readonly="true" class="form-control" value="<?php echo betteroracledate(oraclestrtotime($ptp['PTP_DELIVERY_DATE'])) ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td clas="col-md-5 hidden">Tanggal Aanwijing</td>
                                <td>
                                    <div class="input-group date">
                                        <input type="text" name="ptp_prebid_date" class="form-control" value="<?php echo empty($ptp['PTP_PREBID_DATE']) ? '' : betteroracledate(oraclestrtotime($ptp['PTP_PREBID_DATE'])) ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </td>
                            </tr>
                            <?php if($ptp['PTP_EVALUATION_METHOD'] == '2 Tahap 2 Sampul'){ ?>
                            <tr>
                                <td clas="col-md-5">Batas Penawaran Harga</td>
                                <td>
                                <!--  <?php //if($ptm['PTM_STATUS'] == '16'){ ?> Verifikasi Penawaran Harga -->
                                <?php if($ptm['MASTER_ID'] == '12'){ ?> <!-- nyo 230217 -->
                                    <input type="hidden" name="ptm_status" value="<?php echo $ptm['PTM_STATUS']?>">
                                    <div class="input-group date">
                                        <input type="text" name="ptm_batas_vendor" class="form-control" value="<?php echo empty($ptm['BATAS_VENDOR_HARGA'])? '' : betteroracledate(oraclestrtotime($ptm['BATAS_VENDOR_HARGA'])) ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                    <?php }else{ ?>
                                    <div class="input-group col-md-12">
                                        <input type="text" readonly="true" name="ptm_batas_vendor" class="form-control" value="<?php echo empty($ptm['BATAS_VENDOR_HARGA'])? '' : betteroracledate(oraclestrtotime($ptm['BATAS_VENDOR_HARGA'])) ?>">
                                    </div>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                            
                            <a href="<?php echo base_url('Procurement_reschedule/index'); ?>" class="main_button color7 small_btn">Kembali</a>
                            <button type="submit" class="formsubmit main_button color6 small_btn">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>

<div class="modal fade" id="modal_dokumen">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">Informasi Tambahan PR <span class="pr"></span></div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                        <th>Pilih</th>
                        <th>Tipe</th>
                        <th>Nama</th>
                        <th>File</th>
                        <th>Tanggal</th>
                        <th>User</th>
                    </thead>
                    <tbody id="dokumentable">
                    </tbody>
                </table>
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        <button type="button" id="savedoc" class="main_button color2 small_btn">Simpan</button>
                        <button type="button" class="main_button color7 small_btn close-modal">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
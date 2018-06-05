
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Pembuatan Template Evaluasi Pengadaan</h2>
            </div>
            <?php echo form_open_multipart('Procurement_template/',array('class' => 'form-horizontal form_valid')); ?>
            <div class="row">
                <?php if (validation_errors() != '') { ?>
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-danger">
                        <div class="panel-body">
                            <font color="red"><?php echo validation_errors(); ?></font>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Form Template Pengadaan
                        </div>
                        <table class="table">
                            <tr>
                                <td class="col-md-3">Company</td>
                                <td><input type="hidden" class="form-control" name="evt_company" value="<?php echo $this->session->userdata['COMPANYID']; ?>" required>
                                    <input type="text" class="form-control" readonly="readonly" value="<?php echo $this->session->userdata['COMPANYNAME']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Nama</td>
                                <td><input type="text" class="form-control" name="evt_name" value="<?php echo set_value('evt_name'); ?>" id="evt_name" required></td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Jenis</td>
                                <td>
                                    <select id="evt_type" name="evt_type" required>
                                        <option value="2">Evaluasi Kualitas Teknis dan Harga</option>
                                        <option value="1">Evaluasi Kualitas Terbaik</option>
                                        <option value="3">Evaluasi Harga Terendah</option>
                                        <option value="4">Evaluasi Interchangeable (khusus Tonasa)</option>
                                        <option value="5">Sistem Gugur</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Passing Grade Teknis</td>
                                <td><input type="text" class="form-control" name="evt_passing_grade" value="<?php echo set_value('evt_passing_grade') == '' ? 80 : set_value('evt_passing_grade') ?>" id="evt_passing_grade" required></td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Bobot Teknis</td>
                                <td><input type="text" class="form-control" name="evt_tech_weight" value="<?php echo set_value('evt_tech_weight') == '' ? 50 : set_value('evt_tech_weight') ?>" id="evt_tech_weight" required></td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Bobot Harga</td>
                                <td><input type="text" class="form-control" name="evt_price_weight" value="<?php echo set_value('evt_price_weight') == '' ? 50 : set_value('evt_price_weight') ?>" id="evt_price_weight" required></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><label class="control-label"><font color="red"><?php echo form_error('total_cost2'); ?></font></label></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Item Evaluasi Teknis</div>
                        <input type="hidden" name="total_cost" id="total_cost" value="">
                        <input type="hidden" name="total_cost2" id="total_cost2" value="">
                        <input type="hidden" name="list_evt_item" id="list_evt_item" value="">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="container">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Parent Item</div>
                                        <table class="table">
                                            <tr>
                                                <td class="col-md-3">Item</td>
                                                <td><input type="text" class="form-control" name="ppd_item" id="ppd_item"></td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-3">Bobot</td>
                                                <td>
                                                    <input type="text" class="form-control" name="ppd_weight" id="ppd_weight">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-3">Fix</td>
                                                <td>
                                                    <input type="checkbox" id="ppd_mode" name="ppd_mode" value="1" checked>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <button id="buttonAddItem" class="main_button color6 small_btn bottom_space" type="button">Tambah</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="container">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Sub Item</div>
                                        <table class="table">
                                            <tr>
                                                <td class="col-md-3">Parent Item</td>
                                                <td>
                                                    <select name="select_item_det" id="select_item_det" class="form-control">
                                                        <option value="">- Pilih Item -</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-3">Sub Item</td>
                                                <td><input type="text" class="form-control" name="name_item_det" id="name_item_det"></td>
                                            </tr>
                                            <tr id="sub_item_bobot">
                                                <td class="col-md-3">Bobot</td>
                                                <td><input type="text" class="form-control" name="pptu_weight" id="pptu_weight"></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <button id="buttonAddDetail" class="main_button color6 small_btn bottom_space" type="button">Tambah</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <th class="text-center">Item</th>
                                            <th class="text-center col-md-1">Bobot</th>
                                            <th class="text-center col-md-1"></th>
                                        </thead>
                                        <tbody id="tableItem">
                                            <tr>
                                                <td class="text-center" colspan="8" id="firstRow">- Belum ada item -</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body text-center">
                            <button id="buttonResetItem" class="main_button color7 small_btn bottom_space" type="button">Reset</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-md-offset-2 text-center">
                    <button type="submit" id="submit_btn" name="submit_btn" class="main_button color6 small_btn">Simpan</button>
                    <label class="control-label"><font color="red"><?php echo form_error('total_cost'); ?></font></label>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>
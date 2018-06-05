
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <a href="#" id="button_tambah" class="btn btn-success btn-block">Tambah</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table id="table_criteria" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="5%">Company ID</th>
                                        <th class="text-center" width="20%">Nama Kriteria</th>
                                        <th class="text-center" width="10%">Detail Kriteria</th>
                                        <th class="text-center" width="5%">Skor Kriteria</th>
                                        <th class="text-center" width="5%">Tanda Skor Kriteria</th>
                                        <th class="text-center">Criteria Trigger By</th>
                                        <th class="text-center" nowrap>T/V</th>
                                        <th class="text-center" nowrap>R/B</th>
                                        <th class="text-center" nowrap>Sanksi Khusus</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tabelnya">  
                                    <tr><td colspan="8">Tidak ada data.</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<form id="form_edit">
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="edit_modal_label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
                    <h4 class="modal-title" id="edit_modal_label">Edit Vendor Performance Criteria</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 hidden">
                            <input type="hidden" class="form-control" id="modal_edit_id" name="edit_id">
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Kriteria</label>
                                <input type="text" class="form-control" id="modal_edit_criteria_name" name="criteria_name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Detail Kriteria</label>
                                <input type="text" class="form-control" id="modal_edit_criteria_detail" name="criteria_detail">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Skor Kriteria</label>
                                <input type="number" class="form-control" id="modal_edit_criteria_score" name="criteria_score">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" title="0 = System, 1 = Manual">
                                <label>Trigger by</label>                                
                                <select id="modal_edit_criteria_trigger_by" name="criteria_trigger_by">
                                    <option value="">Pilih Trigger By</option>
                                    <?php foreach ($criteria_trigger_by as $key => $val): ?>
                                        <option value="<?php echo $key ?>">
                                            <?php echo $val ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>  
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Score Sign</label>
                                <select id="modal_edit_criteria_score_sign" name="criteria_score_sign">
                                    <option value="">Pilih Criteria Score Sign</option>
                                    <?php foreach ($criteria_score_sign as $key => $val): ?>
                                        <option value="<?php echo $key ?>">
                                            <?php echo $val ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tender / Vendor</label>
                                <select id="modal_edit_t_or_v" name=" t_or_v">
                                    <option value="">Pilih Tender / Vendor</option>
                                    <?php foreach ($t_or_v as $key => $val): ?>
                                        <option value="<?php echo $key ?>">
                                            <?php echo $val ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Req / Buyer</label>
                                <select id="modal_edit_req_or_buyer" name="req_or_buyer">
                                    <option value="">Pilih Req / Buyer</option>
                                    <?php foreach ($req_or_buyer as $key => $val): ?>
                                        <option value="<?php echo $key ?>">
                                            <?php echo $val ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sanksi Khusus</label>
                                <select id="modal_edit_special_sanction" name="special_sanction">
                                    <option value="">Pilih Sanksi Khusus</option>
                                    <?php foreach ($special_sanction as $key => $val): ?>
                                        <option value="<?php echo $key ?>">
                                            <?php echo $val ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company</label>
                                <select id="modal_edit_company" name="company">
                                    <option value="">Pilih Company</option>
                                    <?php foreach ($company as $key => $val): ?>
                                        <option value="<?php echo $key ?>">
                                            <?php echo $val.' ('.$key.')' ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="save_edit">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="form_new">
    <div class="modal fade" id="new_modal" tabindex="-1" role="dialog" aria-labelledby="new_modal_label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
                    <h4 class="modal-title" id="new_modal_label">Tambah Vendor Performance Criteria</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Kriteria</label>
                                <input type="text" class="form-control" id="modal_criteria_name" name="new_criteria_name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Detail Kriteria</label>
                                <input type="text" class="form-control" id="modal_criteria_detail" name="new_criteria_detail">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Skor Kriteria</label>
                                <input type="number" class="form-control" id="modal_criteria_score" name="new_criteria_score">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" title="0 = System, 1 = Manual">
                                <label>Trigger by</label>
                                <select id="modal_new_criteria_trigger_by" name="new_criteria_trigger_by">
                                    <option value="">Pilih Trigger</option>
                                    <?php foreach ($criteria_trigger_by as $key => $val): ?>
                                        <option value="<?php echo $key ?>">
                                            <?php echo $val ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>  
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Score Sign</label>
                                <select id="modal_new_criteria_score_sign" name="new_criteria_score_sign">
                                    <option value="">Pilih Sign</option>
                                    <?php foreach ($criteria_score_sign as $key => $val): ?>
                                        <option value="<?php echo $key ?>">
                                            <?php echo $val ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tender / Vendor</label>
                                <select id="modal_new_t_or_v" name="new_t_or_v">
                                    <option value="">Pilih Tender / Vendor</option>
                                    <?php foreach ($t_or_v as $key => $val): ?>
                                        <option value="<?php echo $key ?>">
                                            <?php echo $val ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Req / Buyer</label>
                                <select id="modal_new_req_or_buyer" name="new_req_or_buyer">
                                    <option value="">Pilih Req / Buyer</option>
                                    <?php foreach ($req_or_buyer as $key => $val): ?>
                                        <option value="<?php echo $key ?>">
                                            <?php echo $val ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sanksi Khusus</label>
                                <select id="modal_new_special_sanction" name="new_special_sanction">
                                    <option value="">Pilih Sanksi Khusus</option>
                                    <?php foreach ($special_sanction as $key => $val): ?>
                                        <option value="<?php echo $key ?>">
                                            <?php echo $val ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company</label>
                                <select id="modal_new_company" name="new_company">
                                    <option value="">Pilih Company</option>
                                    <?php foreach ($company as $key => $val): ?>
                                        <option value="<?php echo $key ?>">
                                            <?php echo $val.' ('.$key.')' ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="save_new">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>


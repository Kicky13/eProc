        <section class="content_section">
            <input type="text" class="hidden" id="vendor_type" name="vendor_type" value="<?php echo set_value('vendor_type', $vendor_detail["VENDOR_TYPE"]); ?>">
            <div class="modal fade" id="updateRekeningModal" tabindex="-1" role="dialog" aria-labelledby="updateRekening">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Rekening Data</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Administrative_document/do_insert_akta_pendirian',array('class' => 'form-horizontal current_edited_bank_financial')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="text" class="hidden" name="bank_id" id="bank_id">
                                <div class="form-group">
                                    <label for="account_no" class="col-sm-3 control-label">No. Rekening<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="account_no_edit" name="account_no">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="account_name" class="col-sm-3 control-label">Pemegang Rekening<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control text-uppercase" id="account_name_edit" name="account_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bank_name" class="col-sm-3 control-label">Nama Bank<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control text-uppercase" id="bank_name_edit" name="bank_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bank_branch" class="col-sm-3 control-label">Cabang Bank<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control text-uppercase" id="bank_branch_edit" name="bank_branch">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="swift_code" class="col-sm-3 control-label">Swift Code<?php if ($vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="swift_code_edit" name="swift_code">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="col-sm-3 control-label">Alamat Bank<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control text-uppercase" id="address_edit" name="address">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bank_postal_code" class="col-sm-3 control-label">Kode Pos Bank<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="bank_postal_code_edit" name="bank_postal_code" maxlength="5">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="currency" class="col-sm-3 control-label">Mata Uang<span style="color: #E74C3C">*</span></label>
                                    <div class="col-sm-3">
                                        <?php
                                        echo form_dropdown('currency', $currency, '', 'id="currency_edit" class="form-control"'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label for="reference" class="col-sm-3 control-label">Reference Bank<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control text-uppercase" id="reference_bank_edit" name="reference_bank">
                                        </div>

                                        <div class="colm-sm-5">
                                            <input type="hidden" name="file_lama" id="file_lama_bank">
                                            <input type="hidden" id="filename" class="file_bank" name="file_bank">
                                            <button type="button" required class="uploadAttachment btn btn-default file">Change File (2MB Max)</button><span class="filenamespan"></span>
                                                &nbsp;&nbsp;<a class="btn btn-default delete_upload_file_ba glyphicon glyphicon-trash"></a>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="col-sm-3 progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_rekening_data_button">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="updateLaporanKeuanganModal" tabindex="-1" role="dialog" aria-labelledby="updateLaporanKeuangan">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Update Laporan Keuangan</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('Administrative_document/do_insert_akta_pendirian',array('class' => 'form-horizontal current_edited_laporan_keuangan')); ?>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <input type="text" class="hidden" name="fin_rpt_id" id="fin_rpt_id">
                                <div class="form-group">
                                        <label for="fin_rpt_year" class="col-sm-3 control-label">Tahun Laporan<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <div class="input-group date year">
                                                <input type="text" name="fin_rpt_year" id="fin_rpt_year_edit" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                        <div class="colm-sm-5">
                                            <input type="hidden" name="file_lama_rpt" id="file_lama_rpt">
                                            <input type="hidden" id="filename" class="file_rpt" name="file_rpt">
                                            <button type="button" required class="uploadAttachment btn btn-default file">Change File (2MB Max)</button><span class="filenamespan"></span>
                                                &nbsp;&nbsp;<a class="btn btn-default delete_upload_file_ba glyphicon glyphicon-trash"></a>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="form-group">
                                        <label for="fin_rpt_type" class="col-sm-3 control-label">Jenis Laporan<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <?php
                                            $report_type = array('AUDIT' => 'AUDIT', 'BUKAN AUDIT' => 'BUKAN AUDIT');
                                            echo form_dropdown('fin_rpt_type', $report_type, '', 'class="form-control" id="fin_rpt_type_edit"'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fin_rpt_currency" class="col-sm-3 control-label">Valuta<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <?php
                                            echo form_dropdown('fin_rpt_currency', $currency, '', 'class="form-control" id="fin_rpt_currency_edit"'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fin_rpt_asset_value" class="col-sm-3 control-label">Nilai Asset<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control must_autonumeric text-right" id="fin_rpt_asset_value_edit" name="fin_rpt_asset_value">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fin_rpt_hutang" class="col-sm-3 control-label">Hutang Perusaaan<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control must_autonumeric text-right" id="fin_rpt_hutang_edit" name="fin_rpt_hutang">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fin_rpt_revenue" class="col-sm-3 control-label">Pendapatan Kotor<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control must_autonumeric text-right" id="fin_rpt_revenue_edit" name="fin_rpt_revenue">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fin_rpt_netincome" class="col-sm-3 control-label">Laba Bersih<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control must_autonumeric text-right" id="fin_rpt_netincome_edit" name="fin_rpt_netincome">
                                        </div>
                                    </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="main_button" data-dismiss="modal">Close</button>
                            <button type="button" class="main_button color1" id="update_laporan_keuangan_data_button">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Bank and Financial Data</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open('Administrative_document',array('class' => 'form-horizontal insert_bank_data', 'autocomplete'=>'off')); ?>
                            <?php $container = 'Rekening Bank' ?>
                            <div class="panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'hidden') ?>">
                                <div class="panel-heading">Rekening Bank</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <?php if(isset($progress_status[$container]) && $progress_status[$container]['STATUS'] == 'Rejected'):?>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="alert alert-warning" role="alert"><strong>Keterangan Revisi! </strong><?php echo $progress_status[$container]['REASON']; ?></div> 
                                            </div>
                                        </div>
                                        <hr>
                                    <?php endif ?>
                                    <div class="form-group">
                                        <label for="account_no" class="col-sm-3 control-label">No. Rekening<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="account_no" name="account_no">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="account_name" class="col-sm-3 control-label">Pemegang Rekening<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control text-uppercase" id="account_name" name="account_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="bank_name" class="col-sm-3 control-label">Nama Bank<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control text-uppercase" id="bank_name" name="bank_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="bank_branch" class="col-sm-3 control-label">Cabang Bank<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control text-uppercase" id="bank_branch" name="bank_branch">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="swift_code" class="col-sm-3 control-label">Swift Code<?php if ($vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="swift_code" name="swift_code">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-3 control-label">Alamat Bank<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control text-uppercase" id="address" name="address">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="bank_postal_code" class="col-sm-3 control-label">Kode Pos Bank<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="bank_postal_code" name="bank_postal_code" maxlength="5">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="currency" class="col-sm-3 control-label">Mata Uang<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                            <?php
                                            echo form_dropdown('currency', $currency, '', 'id="currency" class="form-control"'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="reference" class="col-sm-3 control-label">Reference Bank<span style="color: #E74C3C">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="reference_bank" name="reference_bank">
                                        </div>

                                        <div class="colm-sm-5">
                                            <input type="hidden" id="filename" class="file_bank" name="file_bank">
                                            <button type="button" required class="uploadAttachment btn btn-default bank">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                                &nbsp;&nbsp;<a class="btn btn-default delete_upload_file_ba glyphicon glyphicon-trash"></a>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addBankData" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="table-responsive">
                                <table class="table table-hover margin-bottom-20 <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : '' ?>" id="vendor_bank">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">No. Rekening</th>
                                            <th class="text-center">Pemegang Rekening</th>
                                            <th class="text-center">Nama Bank</th>
                                            <th class="text-center">Cabang Bank</th>
                                            <th class="text-center">Swift Code</th>
                                            <th class="text-center">Alamat Bank</th>
                                            <th class="text-center">Kode Pos Bank</th>
                                            <th class="text-center">Mata Uang</th>
                                            <th class="text-center">Reference Bank</th>
                                            <th class="text-center" style="width: 86px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bankItem">
                                        <?php if (empty($vendor_bank)) { ?>
                                        <tr id="empty_row">
                                            <td colspan="11" class="text-center">- Belum ada data -</td>
                                        </tr>
                                        <?php
                                        }
                                        else {
                                            $no = 1;
                                            foreach ($vendor_bank as $key => $bank) { ?>
                                        <tr id="<?php echo $bank['BANK_ID']; ?>">
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td class="text-center"><?php echo $bank['ACCOUNT_NO']; ?></td>
                                            <td class="text-center"><?php echo $bank['ACCOUNT_NAME']; ?></td>
                                            <td class="text-center"><?php echo $bank['BANK_NAME']; ?></td>
                                            <td class="text-center"><?php echo $bank['BANK_BRANCH']; ?></td>
                                            <td class="text-center"><?php echo $bank['SWIFT_CODE']; ?></td>
                                            <td class="text-center"><?php echo $bank['ADDRESS']; ?></td>
                                            <td class="text-center"><?php echo $bank['BANK_POSTAL_CODE']; ?></td>
                                            <td class="text-center"><?php echo $bank['CURRENCY']; ?></td>
                                            <td class="text-center"><?php if (!empty($bank['REFERENCE_FILE'])){ ?> <a href="<?php echo base_url('Administrative_document'); ?>/viewDok/<?php echo $bank['REFERENCE_FILE']; ?>" class="previousfile" target="_blank" ><?php echo $bank['REFERENCE_BANK']; ?></a> <?php } else {  echo $bank['REFERENCE_BANK']; } ?></td>
                                            <td><button type="button" class="main_button small_btn update_bank_data"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_vendor_bank/'.$bank['BANK_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                        </tr>
                                            <?php }
                                        ?>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php echo form_open('Administrative_document',array('class' => 'form-horizontal insert_financial_report', 'autocomplete'=>'off')); ?>
                            <?php $container = 'Informasi Laporan Keuangan' ?>
                            <div class="panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'hidden') ?>">
                                <div class="panel-heading">Informasi Laporan Keuangan</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <?php if(isset($progress_status[$container]) && $progress_status[$container]['STATUS'] == 'Rejected'):?>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="alert alert-warning" role="alert"><strong>Keterangan Revisi! </strong><?php echo $progress_status[$container]['REASON']; ?></div> 
                                            </div>
                                        </div>
                                        <hr>
                                    <?php endif ?>
                                    <div class="form-group">
                                        <label for="fin_rpt_year" class="col-sm-3 control-label">Tahun Laporan<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <div class="input-group date year">
                                                <input type="text" name="fin_rpt_year" id="fin_rpt_year" class="form-control" readonly=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                        <div class="colm-sm-5">
                                            <input type="hidden" id="filename" class="file_rpt" name="file_rpt">
                                            <button type="button" required class="uploadAttachment btn btn-default rpt">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                                &nbsp;&nbsp;<a class="btn btn-default delete_upload_file_ba glyphicon glyphicon-trash"></a>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="form-group">
                                        <label for="fin_rpt_type" class="col-sm-3 control-label">Jenis Laporan<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <?php
                                            $report_type = array('AUDIT' => 'AUDIT', 'BUKAN AUDIT' => 'BUKAN AUDIT');
                                            echo form_dropdown('fin_rpt_type', $report_type, '', 'class="form-control"'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fin_rpt_currency" class="col-sm-3 control-label">Valuta<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <?php
                                            echo form_dropdown('fin_rpt_currency', $currency, '', 'class="form-control"'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fin_rpt_asset_value" class="col-sm-3 control-label">Nilai Asset<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control must_autonumeric text-right" id="fin_rpt_asset_value" name="fin_rpt_asset_value">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fin_rpt_hutang" class="col-sm-3 control-label">Hutang Perusaaan<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control must_autonumeric text-right" id="fin_rpt_hutang" name="fin_rpt_hutang">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fin_rpt_revenue" class="col-sm-3 control-label">Pendapatan Kotor<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control must_autonumeric text-right" id="fin_rpt_revenue" name="fin_rpt_revenue">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fin_rpt_netincome" class="col-sm-3 control-label">Laba Bersih<?php if ($vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control must_autonumeric text-right" id="fin_rpt_netincome" name="fin_rpt_netincome">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addFinReport" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="table-responsive">
                                <table class="table table-hover margin-bottom-20 <?php echo isset($progress_status[$container]) ? ($progress_status[$container]['STATUS'] == 'Approved' ? 'hidden' : '') : '' ?>" id="vendor_fin_report">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Tahun Laporan</th>
                                            <th class="text-center">Jenis Laporan</th>
                                            <th class="text-center">Valuta</th>
                                            <th class="text-center">Nilai Aset</th>
                                            <th class="text-center">Hutang Perusahaan</th>
                                            <th class="text-center">Pendapatan Kotor</th>
                                            <th class="text-center">Laba Bersih</th>
                                            <th class="text-center" style="width: 86px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="finReportItem">
                                        <?php if (empty($vendor_fin_report)) { ?>
                                        <tr id="empty_row">
                                            <td colspan="9" class="text-center">- Belum ada data -</td>
                                        </tr>
                                        <?php
                                        }
                                        else {
                                            $no = 1;
                                            foreach ($vendor_fin_report as $key => $report) { ?>
                                        <tr id="<?php echo $report['FIN_RPT_ID']; ?>">
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td class="text-center"><?php if (!empty($report['FILE_UPLOAD'])){ ?><a href="<?php echo base_url('Administrative_document'); ?>/viewDok/<?php echo $report['FILE_UPLOAD']; ?>" class="previousfile" target="_blank" ><?php echo $report['FIN_RPT_YEAR']; ?></a><?php } else {  echo $report['FIN_RPT_YEAR']; } ?>
                                            </td>
                                            <td class="text-center"><?php echo $report['FIN_RPT_TYPE']; ?></td>
                                            <td class="text-center"><?php echo $report['FIN_RPT_CURRENCY']; ?></td>
                                            <td class="must_autonumeric text-right"><?php echo $report['FIN_RPT_ASSET_VALUE']; ?></td>
                                            <td class="must_autonumeric text-right"><?php echo $report['FIN_RPT_HUTANG']; ?></td>
                                            <td class="must_autonumeric text-right"><?php echo $report['FIN_RPT_REVENUE']; ?></td>
                                            <td class="must_autonumeric text-right"><?php echo $report['FIN_RPT_NETINCOME']; ?></td>
                                            <td><button type="button" class="main_button small_btn update_fin_report"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_fin_report/'.$report['FIN_RPT_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                        </tr>
                                            <?php }
                                        ?>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php echo form_open('Administrative_document',array('class' => 'form-horizontal update_financial_data')); ?>
                            <?php $container = 'Modal Sesuai Dengan Akta Terakhir' ?>
                            <div class="panel <?php echo !isset($progress_status[$container]) ? 'panel-default' : ($progress_status[$container]['STATUS'] == 'Rejected' ? 'panel-danger' : 'hidden') ?>">
                                <div class="panel-heading">Modal Sesuai Dengan Akta Terakhir</div>
                                <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                <div class="panel-body">
                                    <?php if(isset($progress_status[$container]) && $progress_status[$container]['STATUS'] == 'Rejected'):?>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="alert alert-warning" role="alert"><strong>Keterangan Revisi! </strong><?php echo $progress_status[$container]['REASON']; ?></div> 
                                            </div>
                                        </div>
                                        <hr>
                                    <?php endif ?>
                                    <div class="form-group">
                                        <label for="fin_akta_mdl_dsr_curr" class="col-sm-3 control-label">Modal Dasar<?php if ($vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL" or $vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                                <select name="fin_akta_mdl_dsr_curr" class="form-control">
                                                    <option value="">Pilih Mata Uang</option>
                                                    <?php foreach ($currency as $key => $value): ?>
                                                        <?php if ($key != '" disabled=""disabled" selected="selected'): ?>
                                                            <?php if ($vendor_detail["FIN_AKTA_MDL_DSR_CURR"] == $key): ?>
                                                                <option value="<?php echo $key ?>" selected><?php echo $value ?></option>
                                                            <?php else: ?>
                                                                <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                                            <?php endif ?>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                </select>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control must_autonumeric text-right" id="fin_akta_mdl_dsr" name="fin_akta_mdl_dsr" value="<?php echo set_value('fin_akta_mdl_dsr', $vendor_detail["FIN_AKTA_MDL_DSR"]); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fin_akta_mdl_str_curr" class="col-sm-3 control-label">Modal Disetor<?php if ($vendor_detail["VENDOR_TYPE"] == "INTERNASIONAL" or $vendor_detail["VENDOR_TYPE"] == "NASIONAL" or $vendor_detail["VENDOR_TYPE"] == "EXPEDITURE") { ?><span style="color: #E74C3C">*</span><?php } ?></label>
                                        <div class="col-sm-3">
                                            <select name="fin_akta_mdl_str_curr" class="form-control" placeholder="Pilih Currency">
                                                    <option value="">Pilih Mata Uang</option>
                                                    <?php foreach ($currency as $key => $value): ?>
                                                        <?php if ($key != '" disabled=""disabled" selected="selected'): ?>
                                                            <?php if ($vendor_detail["FIN_AKTA_MDL_STR_CURR"] == $key): ?>
                                                                <option value="<?php echo $key ?>" selected><?php echo $value ?></option>
                                                            <?php else: ?>
                                                                <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                                            <?php endif ?>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                </select>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control must_autonumeric text-right" id="fin_akta_mdl_str" name="fin_akta_mdl_str" value="<?php echo set_value('fin_akta_mdl_str', $vendor_detail["FIN_AKTA_MDL_STR"]); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <?php if($this->session->userdata('STATUS')=='99' || $this->session->userdata('needupdate')==true){?>
                                <div class="panel panel-default">
                                    <div class="panel-body text-right">
                                        <a href="<?php echo base_url(); ?>Additional_document/input_summary" class="main_button small_btn color1">Back</a>
                                        <button id="save_financial_data" class="main_button color1 small_btn" type="button">Save</button>
                                    </div>
                                </div>
                            <?php 
                            } else {
                            ?>
                                <div class="panel panel-default">
                                    <div class="panel-body text-right">
                                        <a href="<?php echo base_url(); ?>" class="main_button small_btn">Cancel</a>
                                        <!-- <a href="#" class="main_button color4 small_btn">Print</a> -->
                                        <a href="<?php echo base_url('Administrative_document/company_board') ?>" class="main_button color7 small_btn">Back</a>
                                        <button id="save_financial_data" class="main_button color1 small_btn" type="button">Save</button>
                                        <button id="saveandcont_financial_data" class="main_button color1 small_btn" type="button">Save & Continue</button>
                                    </div>
                                </div>
                            <?php } ?>
                            
                        </div>
                    </div>
				</div>
			</div>
		</section>
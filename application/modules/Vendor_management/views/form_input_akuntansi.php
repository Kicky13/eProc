		<section class="content_section">
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Vendor Approval</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        	<div class="panel panel-default">
                                <form method="post" action="<?php echo base_url()?>Vendor_management/do_final_approval">
                            		<input type="text" class="hidden" name="vendor_id" value="133">
                                    <div class="panel-heading">Input Data Akuntansi</div>
                                    <div class="panel-body">
                                    	<div class="form-group">
                                            <label for="contact_name" class="col-sm-3 control-label">Account Group<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-9">
                                                <!-- <input type="text" class="form-control" id="contact_name" name="contact_name" value=""> -->
                                                <select class="form-control" name="acc_group" id="acc_group">
                                                    <?php
                                                    foreach ($account_group as $key => $val) {
                                                    ?>
                                                        <option value="<?php echo $val['GROUP']?>"><?php echo $val['NAME']?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact_name" class="col-sm-3 control-label">Bank Key<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-9">
                                                <!-- <input type="text" class="form-control" id="contact_name" name="contact_name" value=""> -->
                                                <select class="form-control" name="bank_key" id="bank_key">
                                                    <?php
                                                    foreach ($bank_key as $key => $val) {
                                                    ?>
                                                        <option value="<?php echo $val['SWIFT_CODE']?>"><?php echo $val['SWIFT_CODE']?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact_name" class="col-sm-3 control-label">Bank Country Key<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-9">
                                                <!-- <input type="text" class="form-control" id="contact_name" name="contact_name" value=""> -->
                                                <select class="form-control" name="bank_country_key" id="bank_country_key">
                                                    <?php
                                                    foreach ($bank_key as $key => $val) {
                                                    ?>
                                                        <option value="<?php echo $val['BANK_KEY']?>"><?php echo $val['BANK_KEY']?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact_name" class="col-sm-3 control-label">Reconciliation Account<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-9">
                                                <!-- <input type="text" class="form-control" id="contact_name" name="contact_name" value=""> -->
                                                <select class="form-control" name="reconc_acc" id="reconc_acc">
                                                    <?php
                                                    foreach ($reconc_account as $key => $val) {
                                                    ?>
                                                        <option value="<?php echo $val['RECONC_ID']?>"><?php echo $val['NAME']?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact_name" class="col-sm-3 control-label">Term of Payment<span style="color: #E74C3C">*</span></label>
                                            <div class="col-sm-9">
                                                <!-- <input type="text" class="form-control" id="contact_name" name="contact_name" value=""> -->
                                                <select class="form-control" name="term_payment" id="term_payment">
                                                    <?php
                                                    foreach ($payment_term as $key => $val) {
                                                    ?>
                                                        <option value="<?php echo $val['CODE_PAYMENT_TERM']?>"><?php echo $val['CODE_PAYMENT_TERM']?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer text-center">
                                        <button class="main_button small_btn reset_button">Reset</button>
                                        <button id="btn_approve" class="main_button color1 small_btn" type="submit">Approve</button>
                                    </div>
                                </form>
                        	</div>
                        </div>
                    </div>
				</div>
			</div>
		</section>
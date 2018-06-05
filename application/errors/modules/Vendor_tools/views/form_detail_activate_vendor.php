		<section class="content_section">
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span>Aktivasi Vendor</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                    <?php echo form_open('Vendor_tools/do_update_activation_data',array('class' => 'form-horizontal general_form')); ?>
                                    <div class="panel-heading">Activation Vendor Area</div>
                                    <div class="panel-body">
                                        <input type="text" class="hidden" name="vendor_id" value="<?php echo set_value('vendor_id', $vendor_detail["VENDOR_ID"]); ?>">
                                        <div class="form-group">
                                            <label for="company_name" class="col-sm-3 control-label">Vendor Name</label>
                                            <div class="col-sm-9">
                                                <label for="company_name" class="control-label"><strong><?php echo set_value('company_name', $vendor_detail["VENDOR_NAME"]); ?></strong></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="company_name" class="col-sm-3 control-label">Address</label>
                                            <div class="col-sm-9">
                                                <label for="company_name" class="control-label"><strong><?php echo set_value('company_name', $vendor_detail["ADDRESS_STREET"]); ?></strong></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="company_name" class="col-sm-3 control-label"></label>
                                            <div class="col-sm-9 radio">
                                                <label>
                                                    <input type="radio" name="reg_isactivate" value="1" <?php echo $vendor_detail["REG_ISACTIVATE"]=='1' ? 'checked="checked"' : '';?>>Active
                                                </label>
                                                <label>
                                                    <input type="radio" name="reg_isactivate" value="0" <?php echo $vendor_detail["REG_ISACTIVATE"]=='0' ? 'checked="checked"' : '';?>>Not Active
                                                </label>
                                            </div>
                                        </div>
                                        <div class="panel-footer text-center">
                                            <a href="<?php echo base_url(); ?>Vendor_tools/activate_vendor/" class="main_button small_btn reset_button">Cancel</a>
                                            <button class="main_button color1 small_btn" type="submit">Save</button>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</section>
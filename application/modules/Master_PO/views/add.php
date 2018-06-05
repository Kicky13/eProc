<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Data Master PO</h2>
            </div>
 
            <div class="row">
                <div class="col-md-12"> 
                    <?php echo form_open('Master_PO/tambah_aksi',array('class' => 'form-horizontal insert_service','autocomplete'=>'off')); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">From Tambah</div> 
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Code<span style="color: #E74C3C">*</span></label>
                                <div class="col-sm-9">
                                <span class="lfc_alert"></span>
                                    <input type="text" class="form-control" id="CODE" name="CODE" required="" value="">
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Description<span style="color: #E74C3C">*</span></label>
                                <div class="col-sm-9">
                                <span class="lfc_alert"></span>
                                    <!-- <textarea class="form-control" name="DESC" id="DESC" value="<?php echo $u->DESC;?>">
                                        <?php echo $u->DESC; ?>
                                    </textarea> -->
                                    <input type="text" class="form-control" id="DESC" name="DESC" required="" value="">
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-center">
                            <a href="<?php echo base_url('Master_PO/view') ?>" class="main_button color2 small_btn" type="button">Back</a>
                            <button id="addServices" class="main_button color1 small_btn" type="submit">Add Data</button>
                        </div>
                    </div>
                    <div class="panel panel-default">
                    <?php echo form_close(); ?>
                     
                    </div>
                </div>
            </div> 
		</div>
	</div>
</section>
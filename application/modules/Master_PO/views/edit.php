<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Data Master PO</h2>
            </div>

            <?php foreach($dataCode as $u){ ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-horizontal">
                        <div class="panel panel-default">
                            <div class="panel-heading">Master PO Information</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="NPP" class="col-sm-3 control-label">CODE</label>
                                    <label for="NPP" class="col-sm-9 control-label text-left"><strong><?php echo $u->CODE; ?></strong></label>
                                </div> 
                                <div class="form-group">
                                    <label for="NPP" class="col-sm-3 control-label">DESCRIPTION</label>
                                    <label for="NPP" class="col-sm-9 control-label text-left"><strong><?php echo $u->DESC; ?></strong></label>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <?php echo form_open('Master_PO/update',array('class' => 'form-horizontal insert_service','autocomplete'=>'off')); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Form Edit</div>
                        <input type="hidden" name="id" id="id" value="<?php echo $u->ID;?>">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Code<span style="color: #E74C3C">*</span></label>
                                <div class="col-sm-9">
                                <span class="lfc_alert"></span>
                                    <input type="text" class="form-control" id="CODE" name="CODE" required="" value="<?php echo $u->CODE; ?>">
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
                                    <input type="text" class="form-control" id="DESC" name="DESC" required="" value="<?php echo $u->DESC; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-center">
                            <a href="<?php echo base_url('Master_PO/view') ?>" class="main_button color2 small_btn" type="button">Back</a>
                            <button id="addServices" class="main_button color1 small_btn" type="submit">Edit Data</button>
                        </div>
                    </div>
                    <div class="panel panel-default">
                    <?php echo form_close(); ?>
                     
                    </div>
                </div>
            </div>
            <?php } ?>
		</div>
	</div>
</section>
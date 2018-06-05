		<section class="content_section">

            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title;?></h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open('Additional_document/do_insert_principal',array('class' => 'form-horizontal insert_principal')); ?>
                            <?php $container = 'Principal'; ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">Document</div>
                                <!-- <input type="text" class="hidden" name="vendor_id" value="<?php  ?>"> -->
                                <div class="panel-body">
                                    <table class="table table-hover margin-bottom-20" id="principals">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Dokumen</th>                        
                                                <th>Tanggal Expired</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableItem">
                                            <?php if (empty($DOC_EXPIRED)) { ?>
                                            <tr id="empty_row">
                                                <td colspan="9" class="text-center">- Belum ada data -</td>
                                            </tr>
                                            <?php
                                            }
                                            else {
                                                $no = 1;
                                                foreach ($PANELS as $key => $panel) { 
                                                    if($DOC_EXPIRED[$panel]){?>
                                            <tr>
                                                
                                                <td class="text-center"><?php echo ($key+1); ?></td>
                                                <td><?php echo $PANEL_TITLE[$panel];?></td>
                                                <td><?php echo date('d-M-y', oraclestrtotime($DATE_EXPIRED[$panel]));?></td>
                                                
                                            </tr>
                                                <?php }
                                                }
                                            ?>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- <div class="panel-footer text-center">
                                    <button class="main_button small_btn reset_button">Reset</button>
                                    <button id="addPrincipal" class="main_button color1 small_btn" type="button">Add Data</button>
                                </div> -->
                            </div>
                            <?php echo form_close(); ?>
                            <div class="panel panel-default">
                                <div class="panel-body text-right">
                                    <a href="<?php echo base_url(); ?>" class="main_button small_btn">Cancel</a>
                                    <a href="<?php echo base_url('Vendor_profile/') ?>" class="main_button color7 small_btn">Back</a>
                                    <!-- <button id="saveandcont_additional_document" class="main_button color1 small_btn" type="button">Save & Continue</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</section>
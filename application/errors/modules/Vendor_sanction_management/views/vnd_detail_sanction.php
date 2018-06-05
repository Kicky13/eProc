<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php if($this->session->flashdata('success')) { ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
					</div>
					<?php } ?>
					<?php if($this->session->flashdata('failed')) { ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Failed!</strong> <?php echo $this->session->flashdata('failed'); ?>
					</div>
					<?php } ?>
					<?php echo form_open("#",array('class' => 'form-horizontal')); ?>
					<div class="panel panel-default">
						<div class="panel-heading">Vendor Information</div>
						<div class="panel-body">
							<div class="form-group">
								<label for="NPP" class="col-sm-3 control-label">Vendor No</label>
								<label for="NPP" class="col-sm-9 control-label text-left"><strong><?php echo $vendor_information['VENDOR_NO']; ?></strong></label>
							</div>
							<div class="form-group">
								<label for="FIRSTNAME" class="col-sm-3 control-label">Vendor Name</label>
								<label for="FIRSTNAME" class="col-sm-9 control-label text-left"><strong><?php echo $vendor_information['VENDOR_NAME']; ?></strong></label>
							</div>
						</div>
					</div>
					<?php echo form_close(); ?>
					<div class="panel panel-default">
						<div class="panel-heading">Sanction History</div>
						<div class="panel-body">
							<table class="table table-hover" id="detail_vendor_sanction_list">
								<thead>
									<tr>										
										<th class="text-center">Nama Sanksi</th>
										<th class="text-left">Alasan Sanksi</th>
										<th class="text-center">Tanggal Mulai</th>
										<th class="text-center">Tanggal Selesai</th>
										<th class="text-center">Lama Sanksi (hari)</th>
										<th class="text-center">Aktif</th>											
									</tr>
								</thead>
							</table>
						</div>
					</div>

					<div class="panel-group">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapse1">Komentar</a>
                          </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse"> 
                          <table class="table table-hover margin-bottom-20" id="id_comment">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Approved By</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Komentar</th>
                                    </tr>
                                </thead>
                                    <tbody id="tableItem">
                                        <?php
                                         if (empty($santion_comment)) { ?>
                                            <tr id="empty_row">
                                                <td colspan="8" class="text-center">- Belum ada komentar -</td>
                                            </tr>
                                        <?php } else { $no = 1; foreach ($santion_comment as $key => $com) { ?>
                                            <tr id="<?php echo $com['ID_SANCTION_APPROVE']; ?>">
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td class="text-center"><?php echo $com['FULLNAME']; ?></td>
                                                <td class="text-center"><?php echo vendorfromdate($com['APPROVED_DATE']); ?></td>
                                                <td class="text-center"><?php echo $com['ALASAN']; ?></td>
                                            </tr>
                                                <?php } } ?>
                                    </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

					<?php echo form_open("Vendor_sanction_management/free_sanction",array('class' => 'form-horizontal form_sanction', 'method'=>'POST')); ?>
					<input type="text" name="vendor_no" class="hidden" id="vendor_no" value="<?php echo $vendor_information['VENDOR_NO']; ?>">
					<input type="text" name="SANCTION_ID" class="hidden" id="SANCTION_ID" value="<?php echo $SANCTION_ID; ?>">
					<div class="panel panel-default">
					<div class="panel-heading">Pembebasan Sanksi</div>	
					<?php if($APPROVED){ ?>							
								<div class="panel-body">Free Sanction Approved</div>						
								<div class="panel-footer text-center">								
									<a href="<?php echo site_url(($level<3)?'Vendor_sanction_management/vendor_sanction':'Vendor_management/job_list'); ?>" class="main_button small_btn color1">Back</a>							
								</div>
					<?php }else{ ?>	
					 	<?php if($is_approving){ ?>
					 			<?php if($level<4){ ?>
								<div class="panel-body">Waiting Approval</div>								
								<div class="panel-footer text-center">								
									<a href="<?php echo site_url(($level<3)?'Vendor_sanction_management/vendor_sanction':'Vendor_management/job_list'); ?>" class="main_button small_btn color1">Back</a>							
								</div>
								<?php } else { ?>
									<div class="panel-body">No Approval</div>
									<div class="panel-footer text-center">								
									<a href="<?php echo site_url(($level<3)?'Vendor_sanction_management/vendor_sanction':'Vendor_management/job_list'); ?>" class="main_button small_btn color1">Back</a>							
								</div>
								<?php } ?>
						<?php }else{ ?>
							<div class="panel-body">
								<textarea name="alasan" id="alasan" class="col-sm-12" placeholder="Alasan"><?php echo (isset($alasan)?$alasan:'');?></textarea>
							</div>			
							<div class="panel-footer text-center">								
								<a href="<?php echo site_url(($level<3)?'Vendor_sanction_management/vendor_sanction':'Vendor_management/job_list'); ?>" class="main_button small_btn color1">Back</a>
								<button class="main_button color6 small_btn simpan" type="button"><?php echo ($level>2)?"Approve":"Bebaskan"?></button>
							</div>
						<?php }?>
					<?php }?>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</section>
        <section class="content_section">
            <!-- <input type="text" class="hidden" id="vendor_type" name="vendor_type" value="<?php //echo set_value('vendor_type', $vendor_detail["VENDOR_TYPE"]); ?>"> -->

            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover margin-bottom-20" id="vendor_board_commissioner">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Nama Lengkap</th>
                                        <th class="text-center">Jabatan</th>
                                        <th class="text-center">Nomor Telepon</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Nomor KTP</th>
                                        <th class="text-center">Masa Berlaku</th>
                                        <th class="text-center">NPWP</th>
                                        <th class="text-center" style="width: 86px">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableItem">
                                    <?php if (empty($vendor_board_commissioner)) { ?>
                                    <tr id="empty_row">
                                        <td colspan="8" class="text-center">- Belum ada data -</td>
                                    </tr>
                                    <?php
                                    }
                                    else {
                                        $no = 1;
                                        foreach ($vendor_board_commissioner as $key => $board) { ?>
                                    <tr id="<?php echo $board['BOARD_ID']; ?>">
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $board['NAME']; ?></td>
                                        <td><?php echo $board['POS']; ?></td>
                                        <td><?php echo $board['TELEPHONE_NO']; ?></td>
                                        <td><?php echo $board['EMAIL_ADDRESS']; ?></td>
                                        <td><?php echo $board['KTP_NO']; ?></td>
                                        <td class="text-center"><?php echo vendorfromdate($board['KTP_EXPIRED_DATE']); ?></td>
                                        <td><?php echo $board['NPWP_NO']; ?></td>
                                        <td><button type="button" class="main_button small_btn update_komisaris_data"><i class="ico-edit no_margin_right"></i></button> <a class="main_button small_btn" href="<?php echo 'do_remove_company_board/'.$board['BOARD_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ico-remove no_margin_right"></i></a></td>
                                    </tr>
                                        <?php }
                                    ?>

                                    <?php } ?>
                                </tbody>
                            </table>

                            <div class="panel panel-default">
                                <div class="panel-body text-right">
                                    <a href="<?php echo base_url(); ?>" class="main_button small_btn">Cancel</a>
                                    <!-- <a href="#" class="main_button color4 small_btn">Print</a> -->
                                    <a href="<?php echo base_url('Administrative_document/legal_data') ?>" class="main_button color7 small_btn">Back</a>
                                    <button id="saveandcont_company_board" class="main_button color1 small_btn" type="button">Continue</button>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</section>
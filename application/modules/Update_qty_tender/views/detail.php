<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <form method="post" action="<?php echo base_url() ?>Update_qty_tender/save_bidding" enctype="multipart/form-data">
                <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_number ?>">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $detail_ptm_snip ?>
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">History Perubahan Quantity Item</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                    <table class="table table-hover" id="list_qty">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>PR No</th>
                                                <th>PR Item</th>
                                                <th>Short Text</th>
                                                <th>Quantity Lama</th>
                                                <th>Quantity Update</th>
                                                <th>Note</th>
                                                <th>User</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1; foreach ($tit_update as $val): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $val['PPI_PRNO']; ?></td>
                                                <td><?php echo $val['PPI_PRITEM']; ?></td>
                                                <td><?php echo $val['PPI_DECMAT']; ?></td>
                                                <td><?php echo $val['TIT_QTY']; ?></td>
                                                <td><?php echo $val['TIT_QTY_UPDATE']; ?></td>
                                                <td><?php echo $val['NOTE']; ?>
                                                    <?php if (!empty($val['UPLOAD_FILE'])): ?>
                                                        <a href="<?php echo base_url('Ece'); ?>/viewDok/<?php echo $val['UPLOAD_FILE']; ?>" target="_blank"><span class="glyphicon glyphicon-file"></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $val['FULLNAME']; ?></td>
                                                <td><?php echo $val['TIME_ACT']; ?></td>
                                                <td>
                                                    <?php
                                                        $cek = $boleh_hapus[$val['TIT_ID']];
                                                        if($cek==$val['TIU_ID']):
                                                    ?>
                                                        <a style="cursor:pointer" class="btn btn-danger btn-xs" title="Mengembalikan Quantity yg Lama" onclick="hapus(<?php echo $val['TIU_ID']; ?>)"><i class="ico-trash no_margin_right"></i></a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo $detail_item ?>                       
                    </div>
                </div>
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="panel panel-default">
	                        <div class="panel-body text-center">
	                        	<input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
	                            <a href="<?php echo base_url('Update_qty_tender') ?>" class="main_button color7 small_btn">Kembali</a>
	                            <button type="submit" class="main_button color6 small_btn">Simpan</button>
	                        </div>
	                    </div>
	                </div>
	            </div>
            </form>
        </div>
    </div>
</section>
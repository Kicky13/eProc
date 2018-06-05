<div class="panel panel-default">
    <div class="panel-heading">
        Dokumen PR
    </div>
    <?php if (count($newdoc) <= 0): ?>
        <div class="panel-body">Tidak ada dokumen.</div>
    <?php else: ?>
        <table class="table table-hover">
            <thead>
                <th class="text-center col-md-1">No</th>
                <th class="col-md-5">Nama Dokumen</th>
                <th class="col-md-2">Tipe Dokumen</th>
                <?php if($this->session->userdata("is_vendor") != 1){ ?>
                <th class="col-md-3 text-center">Share Dokumen</th>
                <?php } ?>
            </thead>
            <tbody id="items_table">
                <?php $no = 0; foreach ($newdoc as $item): ?>
                <?php if($this->session->userdata("is_vendor") == 1){?>
                <?php if($item['PDC_IS_PRIVATE'] == "0") { ?>
                <?php if($item['IS_SHARE'] == 1) { ?>
                <tr>
                    <td class="text-center"><?php echo ($no + 1) ?></td>
                    <td>
                        <li style="list-style-type: none;">
                            <a href="<?php echo base_url('Quotation'); ?>/viewDokppm/<?php echo $item['nama']; ?>" target="_blank">
                                <!-- <a href="<?php echo base_url('upload/ppm_document/'.$item['nama']) ?>" target="_blank"> -->
                                <span class="glyphicon glyphicon-file"></span> <?php echo $item['PPD_DESCRIPTION']; ?></a>
                            </li>
                        </td>
                        <td><?php echo $item['PDC_NAME']; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3">
                            <ul>
                                <?php foreach ($item['item'] as $key => $value): ?>
                                    <li>
                                        <?php echo $value['NOMAT'];?>
                                        <?php echo $value['DECMAT'];?>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </td>
                    </tr>
                    <?php }} ?>
                    <?php } else {?>
                    <tr>
                        <td class="text-center"><?php echo ($no + 1) ?></td>
                        <td>
                            <li style="list-style-type: none;">
                                <!-- <a href="<?php echo base_url('upload/ppm_document/'.$item['nama']) ?>" target="_blank"> -->
                                <a href="<?php echo base_url('Quotation'); ?>/viewDokppm/<?php echo $item['nama']; ?>" target="_blank">
                                    <span class="glyphicon glyphicon-file"></span> <?php echo $item['PPD_DESCRIPTION']; ?></a>
                                </li>
                            </td>
                            <td><?php echo $item['PDC_NAME']; ?></td>
                            <td>
                                <?php if($item['PDC_IS_PRIVATE'] == "1") {?>
                                <div class="col-md-12 text-center">
                                    <label>Not Share</label>
                                </div>
                                <?php } else { ?>
                                <?php if($item['IS_SHARE'] == 1) {?>
                                <div class="col-md-12 text-center">
                                    <label>Share</label>
                                </div>
                                <?php } else { ?>
                                <div class="col-md-12 text-center">
                                    <label>Not Share</label>
                                </div>
                                <?php } }?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="3">
                                <ul>
                                    <?php foreach ($item['item'] as $key => $value): ?>
                                        <li>
                                            <?php echo $value['NOMAT'];?>
                                            <?php echo $value['DECMAT'];?>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php $no++; endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Tambahan Dokumen Pengadaan</div>
            <table class="table">
                <tr title="Dokumen tambahan yang di share ke vendor, selain dokumen item pr. Menempel pada level pengadaan">
                    <td class="col-md-1"></td>
                    <td class="divfiles">
                        <?php
                        if (count($dokumentambahan) <= 0 && empty($dokumentambahan_docpo[0]['DOC_PO']) && empty($dokumentambahan_aanwijing[0]['DOC_AANWIZ']) && empty($dokumentambahan_docpo[0]['DOC_ANALISA_HARGA'])){
                            ?>
                            Tidak ada dokumen tambahan.
                            <?php
                        }else{
                            ?>
                            <?php foreach ($dokumentambahan as $key => $value): ?>
                                <a href="<?php echo base_url('Monitoring_prc') ?>/viewDok/<?php echo $value['FILE']; ?>" target="_blank"><span class="glyphicon glyphicon-file"></span> <?php echo $value['NAME'] == '' ? $value['FILE'] : $value['NAME'] ?></a><br>
                            <?php endforeach ?>
                            <?php
                            if(!empty($dokumentambahan_docpo[0]['DOC_PO'])){
                                ?>
                                <a href="<?php echo base_url() ?>upload/temp/<?php echo $dokumentambahan_docpo[0]['DOC_PO']; ?>" target="_blank"><span class="glyphicon glyphicon-file"></span> Dokumen PO</a><br>
                                <?php
                            }
                            if(!empty($dokumentambahan_docpo[0]['DOC_ANALISA_HARGA'])){
                                ?>
                                <a href="<?php echo base_url() ?>upload/temp/<?php echo $dokumentambahan_docpo[0]['DOC_ANALISA_HARGA']; ?>" target="_blank"><span class="glyphicon glyphicon-file"></span> Dokumen Analisa Harga</a><br>
                                <?php
                            }
                            if(!empty($dokumentambahan_aanwijing[0]['DOC_AANWIZ'])){
                                ?>
                                <a href="<?php echo base_url() ?>upload/temp/<?php echo $dokumentambahan_aanwijing[0]['DOC_AANWIZ']; ?>" target="_blank"><span class="glyphicon glyphicon-file"></span> Dokumen Aanwijing</a><br>
                                <?php
                            }
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
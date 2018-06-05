<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><span id="title"><?php echo $title ?></span></h2>
            </div>
            <form name="quotation-form" id="quotation-form" method="post" action="<?php echo base_url() ?>Tahap_negosiasi/save_approval">
            <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_number; ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Metode negosiasi yang digunakan pada setiap material
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <th><strong>Material</strong></th>
                                <th><strong>Status</strong></th>
                            </thead>
                            <tbody>
                                <?php foreach ($tits as $tit): ?>
                                <tr>
                                    <input type="hidden" class="item" name="item[]" value="<?php echo $tit['TIT_ID'];?>"/>
                                    <input type="hidden" id="item_status_<?php echo $tit['TIT_ID'];?>" name="item_status[<?php echo $tit['TIT_ID'];?>]" value="<?php echo $tit['TIT_STATUS'];?>"/>
                                    <td><?php echo $tit['PPI_PRNO'].' | '.$tit['PPI_PRITEM'].' | '.$tit['PPI_DECMAT'] ?></td>
                                    <td><?php echo $status[$tit['TIT_STATUS']] ?></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>    
                    <div class="panel panel_rekap"></div>               
                    <?php echo ($ptp['PTP_JUSTIFICATION_ORI']!=5)?$evaluasi:'';?>
                    <?php echo $detail_ptm_snip ?>
                    <?php echo $this->snippet->assignment($ptm_number) ?>
                    <?php if($ptp['PTP_JUSTIFICATION_ORI'] == 5) : ?> <!-- Penunjukan Langsung - Repeat Order (RO) -->
                        <?php echo $tit_po; ?>
                    <?php endif; ?>
                    <?php echo $vendor_ptm ?>
                    <?php echo $ptm_comment ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Komentar Anda</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-3">Komentar</td>
                                    <td class="col-md-1 text-right">:</td>
                                    <td><textarea class="form-control" maxlength="1000" name="ptc_comment"></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                            <!-- <button type="button" class="formsubmit_ main_button color1 small_btn milihtombol_publicjs">Reject
                            </button>
                            <button type="button" class="formsubmit_ main_button color6 small_btn milihtombol_publicjs">Approve
                            </button> -->
                                <input type="hidden" name="next_process" id="next_process">
                                <input type="button" class="formsubmit_ main_button color1 small_btn milihtombol_publicjs" onclick="reject()" value="Reject">
                                <input type="button" class="formsubmit_ main_button color6 small_btn milihtombol_publicjs" onclick="approved()" value="Approve">
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</section>

<div class="modal fade" id="att_teknis">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
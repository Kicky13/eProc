<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php foreach ($data_log as $val) : ?>
                        <div class="panel panel-default" style="overflow: auto;">
                            <div class="panel-heading"><?php echo $val['PROCESS']; ?></div>
                            <table class="table">
                                <tr>
                                    <td><strong>Action</strong></td>
                                    <td><?php echo $val['LM_ACTION']; ?></td>
                                </tr>
                                <?php foreach ($detail[$val['LM_ID']] as $dtl) : ?>
                                    <tr>
                                        <td><strong>Data</strong></td>
                                        <td><?php echo $dtl['DATA'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <a href="<?php echo base_url('Log') ?>" class="main_button color7 small_btn">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Detail Template Evaluasi Pengadaan</h2>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default">
                        <table class="table table-hover">
                            <tr>
                                <td><strong>ID</strong></td>
                                <td>:</td>
                                <td><?php echo $eval['EVT_ID']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tipe</strong></td>
                                <td>:</td>
                                <td><?php echo $eval['EVT_TYPE_NAME'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Nama</strong></td>
                                <td>:</td>
                                <td><?php echo $eval['EVT_NAME']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Passing Grade</strong></td>
                                <td>:</td>
                                <td><?php echo $eval['EVT_PASSING_GRADE']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Bobot Teknis</strong></td>
                                <td>:</td>
                                <td><?php echo $eval['EVT_TECH_WEIGHT']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Bobot Harga</strong></td>
                                <td>:</td>
                                <td><?php echo $eval['EVT_PRICE_WEIGHT']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php if ($detail != null) { ?>
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">Detail Template</div>
                        <table class="table table-hover table-bordered">
                            <tr>
                                <th class="text-center"><strong>No</strong></th>
                                <th><strong>Nama</strong></th>
                                <th class="text-center"><strong>Bobot</strong></th>
                                <th class="text-center"><strong>Mode</strong></th>
                            </tr>
                            <?php $no = 1; foreach ($detail as $var) { ?>
                            <tr style="vertical-align: top;">
                                <td class="text-center" style="vertical-align: top;"><?php echo $no; ?></td>
                                <td>
                                    <strong><?php echo $var['PPD_ITEM']; ?></strong>
                                    <ul class="listnya col-md-offset-1 list-circle">
                                        <?php foreach ((array)$var['uraian'] as $urai): ?>
                                            <li><?php echo $urai['PPTU_ITEM']; ?>
                                                <?php echo $urai['PPTU_WEIGHT'] == '' ? '' : '&nbsp;&nbsp;&nbsp; Bobot = '.$urai['PPTU_WEIGHT']; ?>                                                    
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                </td>
                                <td class="text-center" style="vertical-align: top;"><?php echo $var['PPD_WEIGHT']; ?></td>
                                <td class="text-center" style="vertical-align: top;"><?php echo $var['PPD_MODE'] == 1 ? 'Fix' : 'Dinamis'; ?></td>
                            </tr>
                            <?php $no++; } ?>
                        </table>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
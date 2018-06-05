
<div class="panel-group" id="commentAcordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" id="headingOne" role="button" data-toggle="collapse" data-parent="#commentAcordion" href="#commentcollapse" aria-expanded="true" aria-controls="collapseOne">
            <h4 class="panel-title">Daftar Komentar</h4>
        </div>
        <div id="commentcollapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <!-- <th>Posisi</th> -->
                            <th>Nama</th>
                            <th>Aktivitas</th>
                            <th>Tanggal</th>
                            <th>Komentar</th>
                            <!-- <th>Attachment</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ((array)$comments as $key => $row) { ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <!-- <td><?php echo $row["PTC_POSITION"]; ?></td> -->
                            <td><?php echo $row["PTC_NAME"]; ?></td>
                            <td><?php echo $row["PTC_ACTIVITY"]; ?></td>
                            <td><?php echo $row["PTC_END_DATE"]; ?></td>
                            <td><?php echo $row["PTC_COMMENT"]; ?></td>
                            <!-- <td><?php echo $row["PTC_ATTACHMENT"]; ?></td> -->
                        </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="panel-footer">
                <a role="button" data-toggle="collapse" data-parent="#commentAcordion" href="#commentcollapse" aria-expanded="true" aria-controls="collapseOne">Tutup Daftar Komentar</a>
            </div>
        </div>
    </div>
</div>
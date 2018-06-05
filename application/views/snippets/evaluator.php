<div class="panel panel-default">
    <div class="panel-heading">Evaluator</div>
    <div class="panel-body">
        <table class="table table-hover">
            <thead>
                <th>Level</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Dept</th>
            </thead>
            <tbody>
                <?php foreach ($evaluator as $vl): ?>
                    <tr>
                        <td><?php echo $vl['PE_COUNTER'] ?></td>
                        <td><?php echo $vl['FULLNAME'] ?></td>
                        <td><?php echo $vl['POS_NAME'] ?></td>
                        <td><?php echo $vl['DEPT_NAME'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-hover">
        <tbody>
            <?php if($hasil): ?>
                <?php $no=1; foreach ($hasil as $val): ?>
                <tr>
                    <td width="45px"><input type="radio" name="user" value="<?php echo $val['ID']; ?>">&nbsp;<?php echo $no++; ?></td>
                    <td><?php echo $val['COMPANYNAME']; ?></td>
                    <td><?php echo $val['DEPT_NAME']; ?></td>
                    <td><?php echo $val['POS_NAME']; ?></td>
                    <input type="hidden" name="email" value="<?php echo $val['EMAIL']; ?>" >
                    <td><?php echo $val['EMAIL']; ?></td>
                    <td><?php echo $val['FULLNAME']; ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td>Data Tidak Ada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<br />
<button type="submit" class="main_button color6 small_btn" id="assign">Assign</button>
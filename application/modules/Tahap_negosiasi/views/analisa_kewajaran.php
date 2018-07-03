<?php if (count($ece_tit_id)>0) {?>
<div class="panel panel-default">
    <div class="panel-heading">Pilih Evaluator ECE</strong></div>
    <div class="panel-body">
        <table class="table table-hover">
            <tr> 
                <?php if($title=='Tahap Negosiasi') : ?>
                    <td class="col-md-1 text-left">Pilih Evaluator</td>
                <?php else: ?>
                    <td class="col-md-1 text-left">Evaluator</td>
                <?php endif; ?>
                <!-- <td class="col-md-1 text-left">Pilih Evaluator</td> -->
                <td class="col-md-1 text-right">:</td>
                <td>
                    <?php if($title=='Tahap Negosiasi') : ?>
                        <select name="ece_assign" id="ece_assign" required>
                            <option value="">Pilih evaluator</option>
                            <?php foreach ($employees as $val): ?>
                                <option value="<?php echo $val['ID'] ?>"><?php echo $val['FULLNAME'] ?> (<?php echo $val['POS_NAME'] ?> | <?php echo $val['DEPT_NAME'] ?>)</option>
                            <?php endforeach ?>
                        </select>
                    <?php else: ?>
                        <?php echo $evaluator_ece['FULLNAME'] ?> (<?php echo $evaluator_ece['POS_NAME'] ?> | <?php echo $evaluator_ece['DEPT_NAME'] ?>)
                    <?php endif; ?>
                </td>
            </tr>   
        </table>
    </div>
</div>
<?php } ?>


<?php foreach ($titems as $val): ?>                            
    <div class="panel panel-default">
        <div class="panel-heading">Note Evaluasi ECE <strong><?php echo $val['PPI_DECMAT'] ?></strong></div>
        <div class="panel-body">
            <table class="table table-hover">
                <tr>
                    <td class="col-md-1 text-left">Note</td>
                    <td class="col-md-1 text-right">:</td>
                    <td>
                        <?php if($title=='Tahap Negosiasi') : ?>
                        	<textarea class="form-control" name ="tit_note[<?php echo $val['TIT_ID'] ?>]" id="tit_note" /></textarea>
                        <?php else: ?>
                        	<?php echo $val['TIT_NOTE']; ?>
                        <?php endif; ?>
                    </td>
                </tr>  
            </table>
        </div>
    </div>
    <!-- </div> -->
<?php endforeach; ?>  
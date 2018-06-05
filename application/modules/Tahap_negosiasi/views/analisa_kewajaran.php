<?php foreach ($titems as $val): ?>                            
    <div class="panel panel-default">
        <div class="panel-heading">Note Evaluasi ECE <strong><?php echo $val['PPI_DECMAT'] ?></strong></div>
            <div class="panel-body">
                <table class="table table-hover">
                    <tr>
                        <td class="col-md-1 text-right">Note</td>
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
    </div>
<?php endforeach; ?>  
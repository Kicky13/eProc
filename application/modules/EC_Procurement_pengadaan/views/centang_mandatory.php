<?php $no = 0; foreach ($ppd as $detail) { ?>
	<label><input type="checkbox" name="mandatory[]" value="<?php echo $detail['PPD_ITEM']?>"></label> <?php echo $detail['PPD_ITEM']?><br>
	<input type="hidden" name="et_name[]" value="<?php echo $detail['PPD_ITEM']?>">
	<input type="hidden" name="et_weight[]" value="<?php echo $detail['PPD_WEIGHT']?>">
	<input type="hidden" name="ppd_id[]" value="<?php echo $detail['PPD_ID']?>">
<?php } ?>
<?php
// echo "<pre>";
// print_r($asli);
// print_r($vendor);

?>
<?php foreach ($asli['IT_DATA'] as $data) : ?>
    <?php if(isset($vendor[$data['LIFNR']])) : ?>
	<tr>
		<td class="text-center"><input type="checkbox" class="vnd_terpilih" onclick="nocentang(this)" value="<?php echo $data['LIFNR'] ?>" checked></td>
		<td><?php echo $data['LIFNR'] ?></td>
		<td><?php echo $data['NAME1'] ?></td>
	</tr>
	<?php endif; ?>
<?php endforeach; ?>
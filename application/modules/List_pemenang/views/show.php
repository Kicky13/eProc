<div class="panel panel-default">
	<div class="panel-body">
		<table class="table">
			<tr>
				<?php foreach ($ptm[0] as $key => $value): ?>
				<th><?php echo $key?></th>
				<?php endforeach ?>
			</tr>
			<?php foreach ($ptm as $key => $value): ?>
			<tr>
				<?php foreach ($value as $v): ?>
				<td><?php echo $v?></td>
				<?php endforeach ?>
			</tr>
			<?php endforeach ?>
		</table>
	</div>
</div>
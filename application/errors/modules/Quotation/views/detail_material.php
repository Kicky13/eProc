<!-- <div class="panel panel-default">
	<div class="panel-heading">Header</div>
	<div class="panel-body">
		<?php if (isset($isi['HD'])): ?>
			<?php foreach ($isi['HD'] as $var): ?>
				<?php echo $var ?><br>
			<?php endforeach ?>
		<?php else: ?>
		Tidak ada item.
		<?php endif ?>
	</div>
</div> -->
<div class="panel panel-default">
	<div class="panel-heading">Item</div>
	<div class="panel-body">
		<?php if (isset($isi['IT'])): ?>
			<?php foreach ($isi['IT'] as $var): ?>
				<?php echo $var ?><br>
			<?php endforeach ?>
		<?php else: ?>
		Tidak ada item.
		<?php endif ?>
	</div>
</div> 
<div class="panel panel-default">
	<div class="panel-heading">Long Text</div>
	<div class="panel-body">
		<?php if (isset($isi['MT'])): ?>
			<?php foreach ($isi['MT'] as $var): ?>
				<?php echo $var ?><br>
			<?php endforeach ?>
		<?php else: ?>
		Tidak ada item.
		<?php endif ?>
	</div>
</div>
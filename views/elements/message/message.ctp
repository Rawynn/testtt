<div class="message <?php echo $class ?>">
	<span>
		<?php echo $message ?>
	</span>
	
	<?php if (!isset($no_close) || !$no_close): ?>
		<span class="close">
			&times;
		</span>
	<?php endif ?>
</div>
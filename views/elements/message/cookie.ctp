<div class="cookie-message">
	<div class="container">
		<div class="cookie-message-inner">
			<a class="close" href="<?php echo $this->Html->url('/?cookie-accepted=1') ?>" title="<?php echo h(__('Zamknij', true)) ?>">
				&times;
			</a>
			
			<?php echo $message ?>
		</div>
	</div>
</div>
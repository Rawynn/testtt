<ul class="order-steps active-step-<?php echo $step ?>">
	<li class="step-1">
		<?php if ($step >= 1): ?>
			<?php if (!$placed): ?>
				<a href="<?php echo $this->Html->url(getCartUrl(1)) ?>" title="<?php echo h(__('Zawartość koszyka', true)) ?>">
					<?php __('1. Zawartość koszyka') ?>
				</a>
			<?php else: ?>
				<span class="completed">
					<?php __('1. Zawartość koszyka') ?>
				</span>
			<?php endif ?>
			
			<i class="sprite sprite-rightsmall"></i>
			<i class="sprite sprite-rightsmallpink"></i>
		<?php endif ?>
	</li>
	<li class="step-2 step-3">
		<?php if ($step >= 2): ?>
			<?php if (!$placed): ?>
				<a href="<?php echo $this->Html->url(getCartUrl(2)) ?>" title="<?php echo h(__('Dane adresowe', true)) ?>">
					<?php __('2. Dane adresowe') ?>
				</a>
			<?php else: ?>
				<span class="completed">
					<?php __('2. Dane adresowe') ?>
				</span>
			<?php endif ?>
		<?php else: ?>
			<span>
				<?php __('2. Dane adresowe') ?>
			</span>
		<?php endif ?>
		
		<i class="sprite sprite-rightsmall"></i>
		<i class="sprite sprite-rightsmallpink"></i>
	</li>
	<li class="step-4">
		<?php if ($step >= 4): ?>
			<?php if (!$placed): ?>
				<a href="<?php echo $this->Html->url(getCartUrl(4)) ?>" title="<?php echo h(__('Potwierdzenie', true)) ?>">
					<?php __('3. Potwierdzenie') ?>
				</a>
			<?php else: ?>
				<span class="completed">
					<?php __('3. Potwierdzenie') ?>
				</span>
			<?php endif ?>
		<?php else: ?>
			<span>
				<?php __('3. Potwierdzenie') ?>
			</span>
		<?php endif ?>
	</li>
</ul>
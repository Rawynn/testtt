<?php if (!$placed): ?>
<ul class="order-steps active-step-<?php echo $step ?>">
	<li class="step-1">
		<?php if ($step >= 1): ?>
			<?php if (!$placed): ?>
				<a href="<?php echo $this->Html->url(getCartUrl(1)) ?>" title="<?php echo h(__('Koszyk', true)) ?>">
					<span class="numb">1.</span> <span><?php __('Koszyk') ?></span>
				</a>
			<?php else: ?>
				<span class="completed">
					<span class="numb">1.</span> <span><?php __('Koszyk') ?></span>
				</span>
			<?php endif ?>
			
			<i class="fa fa-angle-right"></i>
		<?php endif ?>
	</li>
	<li class="step-2 step-3">
		<?php if ($step >= 2): ?>
			<?php if (!$placed): ?>
				<a href="<?php echo $this->Html->url(getCartUrl(2)) ?>" title="<?php echo h(__('Twoje dane', true)) ?>">
					<span class="numb">2.</span> <span><?php __('Twoje dane') ?></span>
				</a>
			<?php else: ?>
				<span class="completed">
					<span class="numb">2.</span> <span><?php __('Twoje dane') ?></span>
				</span>
			<?php endif ?>
		<?php else: ?>
			<span>
				<span class="numb">2.</span> <span><?php __('Twoje dane') ?></span>
			</span>
		<?php endif ?>
		
		<i class="fa fa-angle-right"></i>
	</li>
	<li class="step-4">
		<?php if ($step >= 4): ?>
			<?php if (!$placed): ?>
				<a href="<?php echo $this->Html->url(getCartUrl(4)) ?>" title="<?php echo h(__('Potwierdzenie zamówienia', true)) ?>">
					<span class="numb">3.</span> <span><?php __('Potwierdzenie zamówienia') ?></span>
				</a>
			<?php else: ?>
				<span class="completed">
					<span class="numb">3.</span> <span><?php __('Potwierdzenie zamówienia') ?></span>
				</span>
			<?php endif ?>
		<?php else: ?>
			<span>
				<span class="numb">3.</span> <span><?php __('Potwierdzenie zamówienia') ?></span>
			</span>
		<?php endif ?>
	</li>
</ul>
<?php endif;?>

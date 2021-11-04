<?php if (module('B2B') && !getCartUserCartOfferId()): ?>
	<div class="clear-cart">
		<a href="<?php echo $this->Html->url(getCartClearUrl()) ?>" data-tooltip-set="true" title="<?php echo h($edit_offer_mode ? __('Wyczyść', true) : __('Wyczyść koszyk', true)) ?>">
			<i class="fa fa fa-trash" aria-hidden="true"></i>
		</a>
	</div>
<?php endif ?>
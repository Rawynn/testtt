<?php if (module('ZAGIEL') && $price >= 100): ?>
	<div class="zagiel-payment <?php echo $show ? '' : 'hide' ?>" data-type="zagiel-toggle">
		<a class="zagiel-btn" data-type="zagiel" data-zagiel-price="<?php echo number_format($price, 2, '.', '') ?>" data-zagiel-shop-nr="<?php echo setting('MODULE_ZAGIEL_SHOP_NUMBER') ?>" data-zagiel-shop-type="<?php echo setting('MODULE_ZAGIEL_SHOP_TYPE') ?>" href="#" title="">
			<?php echo $this->Html->image('layout/'.TEMPLATE_NAME.'/zagiel-oblicz-rate.png') ?>
		</a>
	</div>
<?php endif ?>
<?php if (setting('MODULE_PLATFORMA_FINANSOWA_I_RATY_PAYMENT_METHOD_ID')): ?>
	<div class="platforma-finansowa-payment <?php echo $show ? '' : 'hide' ?>" data-type="platforma-finansowa-toggle">
		<a class="platforma-finansowa-btn btn" href="https://www.platformaratalna.pl/kalkulator/<?php echo setting('MODULE_PLATFORMA_FINANSOWA_PARTNER_ID') ?>/<?php echo number_format($price, 2, '.', '') ?>" data-main-url="https://www.platformaratalna.pl/kalkulator/<?php echo setting('MODULE_PLATFORMA_FINANSOWA_PARTNER_ID') ?>/" data-type="platforma-finansowa" data-platforma-finansowa-price="<?php echo number_format($price, 2, '.', '') ?>" title="<?php echo h(__('Oblicz i-Ratę', true))?>" target="_blank">
			<?php __('Oblicz i-Ratę') ?>
		</a>
	</div>
<?php endif ?>
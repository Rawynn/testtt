<?php if (module('CREDIT_AGRICOLE') ): ?>
	<div class="credit-agricole-payment <?php echo $show ? '' : 'hide' ?>" data-type="credit-agricole-toggle">
		<a class="credit-agricole-btn " data-type="credit-agricole" data-credit-agricole-parner-id="<?php echo setting('MODULE_CREDIT_AGRICOLE_PARTNER_ID') ?>" data-credit-agricole-price="<?php echo number_format($price, 2, '.', '') ?>" href="#" title="<?php echo h(__('Oblicza ratę Credit Agricole', true)) ?>">
			<img src="https://ewniosek.credit-agricole.pl/eWniosek/res/CA_grafika/oblicz_raty_duckblue.png"/>
		</a>
	</div>
<?php endif ?>
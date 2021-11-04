<?php if (module('SYGMA') && $price >= 150): ?>
	<div class="bgz-bnp-paribas-payment <?php echo $show ? '' : 'hide' ?>" data-type="bgz-bnp-paribas-toggle">
		<a class="bgz-bnp-paribas-btn btn" data-type="bgz-bnp-paribas" data-bgz-bnp-paribas-price="<?php echo number_format($price, 2, '.', '') ?>" data-bgz-bnp-paribas-agreement-no="<?php echo setting('MODULE_SYGMA_AGREEMENT_NO') ?>" data-bgz-bnp-paribas-credit-type="<?php echo setting('MODULE_SYGMA_CREDIT_TYPE') ?>" href="#" title="">
			<?php __('Oblicz ratę BGŻ BNP Paribas') ?>
		</a>
	</div>
<?php endif ?>
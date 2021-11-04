<?php if (getCartVoucher() && getCartPriceToPay() > 0): ?>
	<div  class="message error">
		<span><?php __('Twój bon płatniczy nie pokrywa wartości całego zamówienia. Wybierz dodatkową formę płatności') ?>:</span>
	</div>
<?php endif ?>
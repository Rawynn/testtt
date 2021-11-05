<div class="address-invoice" data-type="vat-address-invoice-container">
	<?php if ($invoice == 1): ?>
		<?php
			echo $this->Form->hidden(
				'CurrentAddress.invoice',
				array(
					'value' => 1
				)
			)
		?>

	<?php endif ?>
</div>
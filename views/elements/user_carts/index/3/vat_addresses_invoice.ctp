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
	<?php elseif ($invoice == 2): ?>
		<?php
			$is_checked = (bool) module('B2B');
			
			echo $this->Form->input(
				'CurrentAddress.invoice',
				array(
					'type'      => 'checkbox',
					'data-type' => 'change-vat-address-invoice',
					'div'       => 'invoice-row checkbox form-row',
					'label'     => __('Chcę otrzymać fakturę VAT', true),
					'checked'   => $is_checked
				)
			)
		?>
		
		<div class="nip-row form form-inline <?php echo $is_checked ? '' : 'hide' ?>" data-type="vat-address-invoice-toggle">
			<?php
				echo $this->Form->input(
					'CurrentAddress.nip',
					array(
						'type'        => 'text',
						'data-type'   => 'vat-address-invoice',
						'div'         => 'form-row',
						'label'       => false,
						'placeholder' => __('NIP', true).':',
						'class'       => 'form-control',
						'value'       => getCartVatAddress('nip')
					)
				)
			?>
		</div>
	<?php endif ?>
</div>
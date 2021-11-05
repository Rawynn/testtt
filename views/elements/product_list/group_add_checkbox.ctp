<?php if (module('B2B')): ?>
	<div class="group-add-checkbox">
		<div class="hide" data-type="field-group-add-checkbox-sellable" data-update="toggle">
			<?php if (!$product['Product']['has_combinations']): ?>
				<?php
					echo $this->Form->input(
						'UserCart.'.$product['Product']['id'].'.product_id',
						array(
							'type'      => 'checkbox',
							'div'       => false,
							'label'     => !isset($label) ? false : $label,
							'value'     => $product['Product']['id'],
							'data-type' => 'cart-group-checkbox',
							'title'     => getCartIsOffer() ? __('Dodaj do oferty', true) : __('Dodaj do koszyka', true),
							'name'      => 'data[UserCart]['.$product['Product']['id'].'][product_id]'
						)
					);
					
					echo $this->Form->input(
						'UserCart.'.$product['Product']['id'].'.quantity',
						array(
							'type'      => 'hidden',
							'value'     => 1,
							'data-type' => 'cart-group-quantity',
							'name'      => 'data[UserCart]['.$product['Product']['id'].'][quantity]'
						)
					);
				?>
			<?php else:?>
				<i class="fa fa-info-circle checkbox-group-info" data-toggle="tooltip" data-placement="top" title="<?php echo h(__('Produkt posiada warianty, proszę skorzystać ze standardowej opcji dodawania do koszyka', true)) ?>"></i>
			<?php endif ?>
		</div>
	</div>
<?php endif ?>
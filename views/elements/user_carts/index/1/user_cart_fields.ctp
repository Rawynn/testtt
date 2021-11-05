<?php if ($user_cart_fields): ?>
	<div class="order-section">
		<div class="order-section-header">
			<h2>
				<?php __('Parametry / Słowniki') ?>
			</h2>
		</div>
		
		<div class="order-section-inner user-cart-fields-section-inner">
			<?php
				foreach ($user_cart_fields as $user_cart_field_id => $user_cart_field_name):
					echo $this->Form->input(
						'UserCartField.'.$user_cart_field_id,
						array(
							'type'                    => 'select',
							'div'                     => 'form-row',
							'label'                   => $user_cart_field_name.':',
							'class'                   => 'form-control',
							'options'                 => $user_cart_field_values[$user_cart_field_id],
							'empty'                   => __('-wybierz-', true),
							'value'                   => $selected_user_cart_fields[$user_cart_field_id],
							'data-type'               => 'user-cart-field',
							'data-user-cart-field-id' => $user_cart_field_id,
							'disabled'                => $cart_blocked
						)
					);
				endforeach;
			?>
		</div>
	</div>
	
	<hr>
<?php endif ?>
<?php
	/* Mapka ups Access Point */
	$ups_shipping_method_ids = array();
	
	if (isset($ups_iframe_url)):
		$ups_shipping_method_ids = array_merge(array_merge(explode(',', setting('MODULE_UPS_ACCESS_POINT_METHOD_ID')), explode(',', setting('MODULE_UPS_ACCESS_POINT_EXPRESS_METHOD_ID'))));
	endif;
?>

<?php if (module('UPS') && (isset($ups_iframe_url) || (isset($ups_iframe_url) && !empty($ups_shipping_method_ids)))): ?>
	<?php if ($ups_iframe_url == false): ?>
		<div class="form form-inline" data-type="shipping-options-toggle" data-options-for="<?php echo $shipping_method_id ?>">
			<a data-toggle="modal" href="#Ups" role="button" title="Zmień kraj dostawy" class="btn btn-small btn-primary">
				<?php __('Wyszukaj i wybierz punkt') ?> <i class="fa fa-angle-right"></i>
			</a>
		</div>
	<?php else: ?>
		<div data-type="shipping-options-toggle" data-options-for="<?php echo $shipping_method_id ?>">
			<div class="ups-point-name"><span data-type="shiping-method-option-address"><?php echo (isset($current_shipping_method_option['ShippingMethodOption']['name']))?$current_shipping_method_option['ShippingMethodOption']['name']:'' ?></span></div>
			
			<?php
				echo $this->Form->input(
					'ShippingMethodOption.id',
					array(
						'type'             => 'hidden',
						'data-type'        => 'shipping-options',
						'data-options-for' => getCartShippingMethodId(),
						'value'            => getCartShippingMethodOptionId()
					)
				)
			?>
			
			<iframe width="100%" height="750" align="center" src="<?php echo $ups_iframe_url ?>"></iframe>
		</div>
	<?php endif ?>
<?php elseif ($shipping_method_options): ?>
	<div class="radio shipping-options form form-inline" data-type="shipping-options-toggle" data-options-for="<?php echo $shipping_method_id ?>">
		<?php
			echo $this->Form->input(
				'ShippingMethodOption.id',
				array(
					'type'             => 'select',
					'data-type'        => 'shipping-options',
					'data-options-for' => getCartShippingMethodId(),
					'div'              => 'form-row',
					'label'            => false,
					'class'            => 'form-control',
					'options'          => $shipping_method_options,
					'value'            => getCartShippingMethodOptionId(),
					'empty'            => __('Wybierz punkt odbioru', true),
					'disabled'         => $cart_blocked && !userIsSalesrep() && !getCartUserCartOfferId()
				)
			)
		?>
	</div>
<?php else: ?>
	<div class="radio shipping-options form form-inline hide" data-type="shipping-options-toggle" data-options-for="<?php echo $shipping_method_id ?>"></div>
<?php endif ?>
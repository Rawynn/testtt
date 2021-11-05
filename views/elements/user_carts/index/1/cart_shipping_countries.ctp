<?php
	$shipping_countries     = getCountriesList(true);
	$ups_shipping_countries = array_unique(array_filter(array_merge(explode(',', setting('MODULE_UPS_ACCESS_POINT_METHOD_ID')), explode(',', setting('MODULE_UPS_ACCESS_POINT_EXPRESS_METHOD_ID')))))
?>

<?php if (count($shipping_countries) > 1 || $ups_shipping_countries || setting('MODULE_UPS_CHECK_COSTS')): ?>
	<div class="shipping-country form form-inline">
		<?php if (setting('MODULE_UPS_CHECK_COSTS') || $ups_shipping_countries): ?>
			<?php __('Kraj dostawy') ?>: <strong><?php echo getCurrentCountryName() ?></strong>
			
			<a data-toggle="modal" href="#Ups" role="button" title="<?php echo h(__('Zmień kraj dostawy', true)) ?>" class="ups">
				<?php __('zmień') ?> <i class="fa fa-angle-right"></i>
			</a>
		<?php else: ?>
			<?php
				echo $this->Form->input(
					'Country.id',
					array(
						'type'      => 'select',
						'data-type' => 'change-country',
						'div'       => 'form-row',
						'label'     => __('Kraj dostawy', true).':',
						'class'     => 'form-control',
						'options'   => $shipping_countries,
						'value'     => getSessionValue('Country.id') ? getSessionValue('Country.id') : getCountryDefaultId(),
						'empty'     => false
					)
				)
			?>
		<?php endif ?>
	</div>
<?php else: ?>
	<?php
		echo $this->Form->input(
			'Country.id',
			array(
				'type'  => 'hidden',
				'value' => getSessionValue('Country.id')
			)
		)
	?>
<?php endif ?>
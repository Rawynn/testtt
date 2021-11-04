<?php
	$ups_allow = false;
	
	if (module('UPS')):
		$access_point = array_unique(array_filter(array_merge(explode(',', setting('MODULE_UPS_ACCESS_POINT_METHOD_ID')), explode(',', setting('MODULE_UPS_ACCESS_POINT_EXPRESS_METHOD_ID')))));
		
		if (!empty($access_point)):
			$ups_allow = true;
		endif;
	endif;
?>

<?php if (setting('MODULE_UPS_CHECK_COSTS') || $ups_allow): ?>
	<div class="modal fade" id="Ups" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
					<h2>
						<?php __('UPS') ?>
					</h2>
				</div>
				
				<div class="modal-body">
					<?php
						echo $this->Form->create(
							'UserCart',
							array(
								'url'         => getUserCartChangeShippingDataUrl(),
								'class'       => 'form',
								'data-submit' => 'once',
								'id'          => 'UserCartChangeShippingDataForm'
							)
						)
					?>
						<?php
							echo $this->Form->input(
								'UserCartData.post_code',
								array(
									'type'  => 'text',
									'div'   => 'form-row',
									'label' => __('Kod pocztowy', true).':',
									'class' => 'form-control',
									'value' => getSessionValue('ShippingMethod.post_code')
								)
							);
							
							echo $this->Form->input(
								'UserCartData.country_id',
								array(
									'type'    => 'select',
									'div'     => 'form-row',
									'label'   => __('Kraj', true).':',
									'class'   => 'form-control',
									'value'   => getSessionValue('ShippingMethod.country_id'),
									'options' => getCountriesList(),
									'empty'   => __('-wybierz-', true)
								)
							);
							
							echo $this->Form->input(
								'UserCartData.state_code',
								array(
									'type'  => 'text',
									'div'   => 'form-row',
									'label' => __('Kod stanu', true).':',
									'class' => 'form-control',
									'value' => getSessionValue('ShippingMethod.state_code')
								)
							);
							
							echo $this->Form->input(
								'UserCartData.city',
								array(
									'type'  => 'text',
									'div'   => 'form-row',
									'label' => __('Miasto', true).':',
									'class' => 'form-control',
									'value' => getSessionValue('ShippingMethod.city')
								)
							);
							
							echo $this->Form->input(
								'UserCartData.street',
								array(
									'type'  => 'text',
									'div'   => 'form-row',
									'label' => __('Ulica', true).':',
									'class' => 'form-control',
									'value' => getSessionValue('ShippingMethod.street')
								)
							);
						?>
						
						<div class="form-actions">
							<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zmień', true)) ?>">
						</div>
					<?php echo $this->Form->end() ?>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>
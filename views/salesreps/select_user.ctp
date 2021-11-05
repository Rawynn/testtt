<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				
				<h2>
					<?php __('Wybór kontrahenta') ?>
				</h2>
			</div>
			
			<div class="modal-body">
				<?php __('W systemie istnieje już kontrahent') ?>:<br><br>
				
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'address',
						array(
							'firstname'    => $address['UserAddress']['firstname'],
							'lastname'     => $address['UserAddress']['lastname'],
							'company'      => $address['UserAddress']['company'],
							'nip'          => $address['UserAddress']['nip'],
							'street'       => $address['UserAddress']['street'],
							'street_1'     => $address['UserAddress']['street_number_1'],
							'street_2'     => $address['UserAddress']['street_number_2'],
							'postcode'     => $address['UserAddress']['postcode'],
							'city'         => $address['UserAddress']['city'],
							'state_name'   => $address['State']['name'],
							'country_name' => $address['Country']['name'],
							'phone'        => $address['UserAddress']['phone'],
						)
					)
				?>
			</div>
			
			<div class="modal-footer modal-actions">
				<a class="btn-back btn btn-lg" data-dismiss="modal" href="#" aria-hidden="true">
					<?php __('Ignoruj') ?>
				</a>
				
				<a class="btn btn-primary btn-lg" href="<?php echo $this->Html->url(getSalesrepChangeUserUrl(array('user_id' => $user['User']['id'], 'type' => 0, 'redirect' => 'cart'))) ?>">
					<?php __('Aktywuj') ?>
				</a>
			</div>
		</div>
	</div>
</div>
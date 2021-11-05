<?php if ($user_addresses): ?>
	<div class="user-address-list-page user-page">
		<ul class="user-address-list">
			<?php foreach ($user_addresses as $address): ?>
				<li>
					<div class="row">
						<div class="column-left">
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
						
						<div class="column-right">
							<div class="user-address-options">
								<?php if (!checkCanAddUserAddress(false, $address, 'edit')): ?>
									<a class="btn" href="<?php echo $this->Html->url(getUserAddressesEditUrl($address['UserAddress']['id'])) ?>" title="<?php echo h(__('Edytuj', true)) ?>" disabled="disabled">
										<?php __('Edytuj') ?>
									</a>
								<?php else: ?>
									<?php if (userIsSalesrep() && $this->params['action'] == 'details'): ?>
										<a class="btn" href="<?php echo $this->Html->url(getUserAddressesEditUrl($address['UserAddress']['id'], array('redirect_to' => Router::normalize($this->Html->url(getUserDetailsUrl($id)))))) ?>" title="<?php echo h(__('Edytuj', true)) ?>">
											<?php __('Edytuj') ?>
										</a>
									<?php else: ?>
										<a class="btn" href="<?php echo $this->Html->url(getUserAddressesEditUrl($address['UserAddress']['id'])) ?>" title="<?php echo h(__('Edytuj', true)) ?>">
											<?php __('Edytuj') ?>
										</a>
									<?php endif ?>
								<?php endif ?>
								
								<?php if (!checkCanAddUserAddress(false, $address, 'delete')): ?>
									<a class="btn" href="#DeleteAddress<?php echo $address['UserAddress']['id'] ?>" title="<?php echo h(__('Usuń', true)) ?>" disabled="disabled">
										<?php __('Usuń') ?>
									</a>
								<?php else: ?>
									<a data-toggle="modal" class="btn" href="#DeleteAddress<?php echo $address['UserAddress']['id'] ?>" role="button" title="<?php echo h(__('Usuń', true)) ?>">
										<?php __('Usuń') ?>
									</a>
									
									<div class="modal fade" id="DeleteAddress<?php echo $address['UserAddress']['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button class="close" data-dismiss="modal" aria-hidden="true">
														&times;
													</button>
													
													<h2>
														<?php __('Usuń adres') ?>
													</h2>
												</div>
												
												<div class="modal-body">
													<p class="text-center">
														<?php __('Czy na pewno chcesz usunąć ten adres?') ?>
													</p>
												</div>
												
												<div class="modal-footer modal-actions">
													<a class="btn-back btn btn-lg" data-dismiss="modal" href="#" aria-hidden="true">
														<?php __('Nie') ?>
													</a>
													
													<a class="btn-next btn btn-primary btn-lg" href="<?php echo $this->Html->url(getUserAddressesDeleteUrl($address['UserAddress']['id'], array('redirect_to' => Router::normalize($this->Html->url(getUserDetailsUrl($id))))))?>">
														<?php __('Tak') ?>
													</a>
												</div>
											</div>
										</div>
									</div>
								<?php endif ?>
							</div>
						</div>
					</div>
				</li>
			<?php endforeach ?>
		</ul>
	</div>
<?php else: ?>
	<?php
		echo $this->element(
			TEMPLATE_NAME.DS.'message'.DS.'message',
			array(
				'class'   => 'flat no-items',
				'message' => sprintf(__('Nie znaleziono żadnych adresów klienta.', true))
			)
		)
	?>
<?php endif ?>
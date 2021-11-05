<div class="user-address-list-page user-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php echo $selected_username ? sprintf(__('Adresy klienta "%s"', true), $selected_username) : __('Moje adresy', true) ?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if ($user_addresses): ?>
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
										<a class="btn btn-grey" href="<?php echo $this->Html->url(getUserAddressesEditUrl($address['UserAddress']['id'])) ?>" title="<?php echo h(__('Edytuj', true)) ?>" <?php echo !checkCanAddUserAddress(false, $address, 'edit') ? 'disabled="disabled"' : '' ?>>
											<?php __('Edytuj') ?>
										</a>
										
										<a class="btn btn-primary" href="#DeleteAddress" data-toggle="modal" data-type="delete-address" data-target-url="<?php echo $this->Html->url(getUserAddressesDeleteUrl($address['UserAddress']['id'])) ?>" title="<?php echo h(__('Usuń', true)) ?>" <?php echo !checkCanAddUserAddress(false, $address, 'delete') ? 'disabled="disabled"' : '' ?>>
											<?php __('Usuń') ?>
										</a>
									</div>
									
									<div class="radio">
										<label>
											<input data-type="set-address-invoice" type="radio" name="data[UserAddress][invoice]" value="<?php echo $address['UserAddress']['id'] ?>" <?php echo $address['UserAddress']['invoice'] == 1 ? 'checked="checked"' : '' ?> <?php echo !checkCanAddUserAddress(false, $address, 'set_invoice') ? 'disabled="disabled"' : '' ?>> <?php __('domyślne dane do faktury') ?>
										</label>
									</div>
									
									<div class="radio">
										<label>
											<input data-type="set-address-default" type="radio" name="data[UserAddress][default]" value="<?php echo $address['UserAddress']['id'] ?>" <?php echo $address['UserAddress']['default'] == 1 ? 'checked="checked"' : '' ?> <?php echo !$can_edit ? 'disabled="disabled"' : '' ?>> <?php __('domyślny adres dostawy') ?>
										</label>
									</div>
								</div>
							</div>
						</li>
					<?php endforeach ?>
				</ul>
				
				<div class="modal fade" id="DeleteAddress" tabindex="-1" role="dialog" aria-hidden="true">
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
								<a class="btn-back btn btn-grey btn-lg" data-dismiss="modal" href="#" aria-hidden="true">
									<?php __('Nie') ?>
								</a>
								
								<a class="btn-next btn btn-primary btn-lg" data-type="delete-address-target" href="#">
									<?php __('Tak') ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php else: ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'   => 'flat no-items',
							'message' => sprintf(
								__('Brak adresów. <br>%s aby dodać nowy adres.', true), $this->Html->link(__('Kliknij', true), getUserAddressesEditUrl())
							)
						)
					)
				?>
			<?php endif ?>
		</div>
		
		<div class="page-sidebar">
			<a class="btn btn-primary btn-block" href="<?php echo $this->Html->url(getUserAddressesEditUrl()) ?>" title="<?php echo h(__('Dodaj nowy adres', true)) ?>" <?php echo !$can_edit ? 'disabled="disabled" ': '' ?>>
				<?php __('Dodaj nowy adres') ?> <i class="fa fa-angle-right"></i>
			</a>
			
			<hr>
			
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>
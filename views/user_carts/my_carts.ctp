<?php
	/* Czy zalogowany użytkownik jest handlowcem */
	$is_salesrep = userIsSalesrep()
?>

<div class="cart-list-page cart-page page">
	
	
	<div class="page-header">
		<h1>
			<?php
				__('Zapisane koszyki');
				
				if (!empty($username)):
					echo ' ('.$username.')';
				endif;
			?>
		</h1>
	</div>
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php if ($is_salesrep): ?>
				<?php
					echo $this->Form->create(
						'UserCart',
						array(
							'url'         => getSavedUserCartsUrl(),
							'class'       => 'cart-search-form form form-inline',
							'data-submit' => 'once',
							'data-type'   => 'carts-list-search-form',
							'type'        => 'get'
						)
					)
				?>
					<h2>
						<?php __('Wyszukaj') ?>
					</h2>
					
					<?php
						echo $this->Form->hidden(
							'user_id',
							array(
								'default'   => getPageParamValue('user_id'),
								'data-send' => 'submit',
								'data-type' => 'carts-user-id'
							)
						)
					?>
					
					<div class="form-row username-row username-row-autocompleter-on">
						<label for="UserCartUsername">
							<?php __('Klient') ?>:
						</label>
						
						<?php
							echo $this->Form->input(
								'username',
								array(
									'type'             => 'text',
									'data-type'        => 'autocomplete',
									'data-ac'          => 'true',
									'data-ac-url'      => $this->Html->url(getUsersAutocompleterUrl()),
									'data-ac-handler'  => '[data-type=carts-user-id-container]',
									'data-ac-extended' => 'false',
									'data-ac-copy'     => '[data-type=carts-user-id]',
									'div'              => array(
										'data-type' => 'carts-user-id-container',
										'class'     => 'autocompleter-container'
									),
									'label'            => false,
									'class'            => 'form-control',
									'default'          => getPageParamValue('user_id') ? getPageParamValue('username') : '',
									'placeholder'      => !getPageParamValue('user_id') ? __('Wszyscy', true) : ''
								)
							)
						?>
					</div>
					
					<?php
						echo $this->Form->input(
							'name',
							array(
								'type'      => 'text',
								'div'       => 'form-row',
								'label'     => __('Nazwa', true).':',
								'class'     => 'form-control',
								'value'     => getPageParamValue('name'),
								'data-send' => 'submit'
							)
						)
					?>
					
					<?php if (setting('MODULE_B2B_SALESREP_USER_CARTS_LIST_DEFAULT_SALESREP_FILTER') == 'all'): ?>
						<?php
							echo $this->Form->input(
								'my',
								array(
									'type'      => 'checkbox',
									'div'       => 'form-row checkbox',
									'label'     => __('tylko moje', true),
									'checked'   => (bool) getPageParamValue('my'),
									'data-send' => 'submit'
								)
							)
						?>
					<?php endif ?>
					
					<div class="form-row">
						<input class="btn btn-form-size" type="submit" value="<?php echo h(__('Szukaj', true)) ?>">
					</div>
				<?php echo $this->Form->end() ?>
			<?php endif ?>
			
			<?php if ($carts): ?>
				<table class="cart-list-table table table-striped table-responsive">
					<thead>
						<tr>
							<th>
								<?php __('Nazwa') ?>
							</th>
							
							<?php if ($is_salesrep): ?>
								<th>
									<?php __('Klient') ?>
								</th>
							<?php endif ?>
							
							<th>
								<?php __('Data utworzenia') ?>
							</th>
							<th>
								<?php __('Data ostatniej zmiany') ?>
							</th>
							<th>
								<?php __('Wartość') ?>
							</th>
							<th class="table-options">
								<?php __('Opcje') ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($carts as $cart): ?>
							<tr>
								<td>
									<span class="table-responsive-label">
										<?php __('Nazwa') ?>:
									</span>
									
									<?php echo $cart['UserCart']['name'] ?>
								</td>
								
								<?php if ($is_salesrep): ?>
									<td>
										<span class="table-responsive-label">
											<?php __('Klient') ?>:
										</span>
										
										<?php echo $cart['UserCart']['selected_user_id'] ? $cart['User']['username'] : '-' ?>
									</td>
								<?php endif ?>
								
								<td>
									<span class="table-responsive-label">
										<?php __('Data utworzenia') ?>:
									</span>
									
									<?php echo showDateTime($cart['UserCart']['created']) ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Data ostatniej zmiany') ?>:
									</span>
									
									<?php echo showDateTime($cart['UserCart']['modified']) ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Wartość') ?>:
									</span>
									
									<span class="text-important">
										<?php echo showPrice(getDefaultPricesType() == 'netto' ? $cart['UserCart']['netto_value'] : $cart['UserCart']['value']) ?>
									</span>
								</td>
								<td class="table-options">
									<a href="<?php echo $this->Html->url(getUserCartPreviewUrl($cart['UserCart']['id'])) ?>" title="<?php echo h(__('Podgląd', true)) ?>">
										<i class="fa fa-search"></i>
									</a>
									
									<?php if ($cart['UserCart']['can_activate']): ?>
										<a data-toggle="modal" href="#ActivateCart<?php echo $cart['UserCart']['id'] ?>" role="button" title="<?php echo h(__('Aktywuj koszyk', true)) ?>">
											<i class="fa fa-check-circle"></i>
										</a>
									<?php endif ?>
									
									<a data-toggle="modal" href="#DeleteCart<?php echo $cart['UserCart']['id'] ?>" role="button" title="<?php echo h(__('Usuń koszyk', true)) ?>">
										<i class="fa fa-times"></i>
									</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				
				<?php foreach ($carts as $cart): ?>
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'user_carts'.DS.'my_carts'.DS.'delete_box',
							array(
								'cart' => $cart
							)
						);
						
						echo $this->element(
							TEMPLATE_NAME.DS.'user_carts'.DS.'my_carts'.DS.'activate_box',
							array(
								'cart' => $cart
							)
						);
					?>
				<?php endforeach ?>
			<?php else: ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'   => 'flat no-items',
							'message' => __('Nie znaleziono żadnych zapisanych koszyków.', true)
						)
					)
				?>
			<?php endif ?>
		</div>
		
		<div class="page-sidebar">
			<?php echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'my_carts'.DS.'add_new_cart') ?>
			
			<hr>
			
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>
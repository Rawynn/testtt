<div class="order-list-page order-page list-page text-page page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php
				__('Zamówienia');
				
				if (!empty($username)):
					echo ' ('.$username.')';
				endif;
			?>
		</h1>
	</div>
	
	<div class="page-content">
		<?php if ($count > 0): ?>
			<?php
				echo $this->Form->create(
					'Order',
					array(
						'url'         => getOrdersUrl(),
						'class'       => 'order-search-form form form-user-search',
						'data-submit' => 'once',
						'data-type'   => 'orders-list-search-form',
						'type'        => 'get'
					)
				)
			?>
				<?php
					echo $this->Form->hidden(
						'search',
						array(
							'value'     => 1,
							'data-send' => 'submit'
						)
					)
				?>
				
				<h2>
					<?php __('Wyszukaj') ?>
				</h2>
				
				<?php if (userIsSalesrep()): ?>
					<?php
						echo $this->Form->hidden(
							'user_id',
							array(
								'default'   => getPageParamValue('user_id'),
								'data-send' => 'submit',
								'data-type' => 'orders-user-id'
							)
						)
					?>
					
					<div class="form-row username-row username-row-autocompleter-on">
						<label for="OrderUsername">
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
									'data-ac-handler'  => '[data-type=orders-user-id-container]',
									'data-ac-extended' => 'false',
									'data-ac-copy'     => '[data-type=orders-user-id]',
									'div'              => array(
										'data-type' => 'orders-user-id-container',
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
							'salesrep_id',
							array(
								'type'      => 'select',
								'div'       => 'form-row',
								'label'     => __('Handlowiec', true).':',
								'class'     => 'form-control',
								'default'   => getPageParamValue('salesrep_id'),
								'data-send' => 'submit',
								'empty'     => __('-dowolny-', true),
								'options'   => $salesreps
							)
						);
						
						echo $this->Form->input(
							'users_salesrep_id',
							array(
								'type'      => 'select',
								'div'       => 'form-row',
								'label'     => __('Klienci handlowca', true).':',
								'class'     => 'form-control',
								'default'   => getPageParamValue('users_salesrep_id'),
								'data-send' => 'submit',
								'empty'     => __('-dowolny-', true),
								'options'   => $salesreps
							)
						);
					?>
				<?php endif ?>
				
				<div class="form-row date-from-to">
					<?php
						echo $this->Form->input(
							'date_from',
							array(
								'type'      => 'text',
								'div'       => false,
								'label'     => __('Data od', true).':',
								'class'     => 'form-control datepicker',
								'default'   => getPageParamValue('date_from'),
								'data-send' => 'submit'
							)
						);
						
						echo $this->Form->input(
							'date_to',
							array(
								'type'      => 'text',
								'div'       => false,
								'label'     => __('do', true).':',
								'class'     => 'form-control datepicker',
								'default'   => getPageParamValue('date_to'),
								'data-send' => 'submit'
							)
						);
					?>
				</div>
				
				<?php
					echo $this->Form->input(
						'product_name',
						array(
							'type'      => 'text',
							'div'       => 'form-row product-row',
							'label'     => __('Produkt', true).':',
							'class'     => 'form-control',
							'default'   => getPageParamValue('product_name'),
							'data-send' => 'submit'
						)
					);
					
					echo $this->Form->input(
						'code',
						array(
							'type'      => 'text',
							'div'       => 'form-row product-row',
							'label'     => __('Kod produktu', true).':',
							'class'     => 'form-control',
							'default'   => getPageParamValue('code'),
							'data-send' => 'submit'
						)
					);
					
					if (module('B2B')):
						echo $this->Form->input(
							'status_id',
							array(
								'type'      => 'select',
								'options'   => $order_statuses,
								'div'       => 'form-row status-row',
								'label'     => __('Status', true).':',
								'class'     => 'form-control',
								'empty'     => __('-dowolny-', true),
								'default'   => getPageParamValue('status_id'),
								'data-send' => 'submit'
							)
						);
						
						echo $this->Form->input(
							'invoice',
							array(
								'type'      => 'text',
								'div'       => 'form-row invoice-row',
								'label'     => __('Faktura', true).':',
								'class'     => 'form-control',
								'default'   => getPageParamValue('invoice'),
								'data-send' => 'submit'
							)
						);
						
						echo $this->Form->input(
							'paid',
							array(
								'type'      => 'select',
								'options'   => array(
									'y' => __('tak', true),
									'n' => __('nie', true)
								),
								'div'       => 'form-row paid-row',
								'label'     => __('Opłacone', true).':',
								'class'     => 'form-control',
								'empty'     => __('-wszystkie-', true),
								'default'   => getPageParamValue('paid'),
								'data-send' => 'submit'
							)
						);
						
						if (module('DROPSHIPPING')):
							echo $this->Form->input(
								'dropshipping',
								array(
									'type'      => 'select',
									'options'   => array(
										'y' => __('dropshipping', true),
										'n' => __('hurtowe', true)
									),
									'div'       => 'form-row dropshipping-row',
									'label'     => __('Typ', true).':',
									'class'     => 'form-control',
									'empty'     => __('-wszystkie-', true),
									'default'   => getPageParamValue('dropshipping'),
									'data-send' => 'submit'
								)
							);
						endif;
						
						echo $this->Form->input(
							'comment',
							array(
								'type'      => 'text',
								'div'       => 'form-row',
								'label'     => __('Komentarz', true).':',
								'class'     => 'form-control',
								'default'   => getPageParamValue('comment'),
								'data-send' => 'submit'
							)
						);
					endif
				?>
				
				<div class="form-row pull-right">
					<input class="btn btn-form-size" type="submit" value="<?php echo h(__('Szukaj', true)) ?>">
				</div>
			<?php echo $this->Form->end() ?>
		<?php endif ?>
		
		<?php if ($orders): ?>
			<?php if (setting('OPTIMALIZATION_FRONTEND_ORDERS_LIST_PAGINATION')): ?>
				<?php echo $this->element(TEMPLATE_NAME.DS.'order'.DS.'list') ?>
			<?php else: ?>
				<?php echo $this->element(TEMPLATE_NAME.DS.'order'.DS.'all') ?>
			<?php endif ?>
		<?php else: ?>
			<?php if (!$this->data): ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'   => 'flat no-items',
							'message' => __('Brak zamówień.', true)
						)
					)
				?>
			<?php else: ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'   => 'flat no-items',
							'message' => __('Nie znaleziono żadnych zamówień spełniających kryteria.', true)
						)
					)
				?>
			<?php endif ?>
		<?php endif ?>
	</div>
</div>
<?php
	/* Czy zalogowany jest handlowcem */
	$user_is_salesrep = userIsSalesrep()
?>
<div class="cart-list-page cart-page page">
	
	
	<div class="page-header">
		<h1>
			<?php
				echo $user_is_salesrep ? __('Płatności', true) : __('Moje płatności', true);
				
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
		<div class="page-content page-sidebar-<?php echo $user_is_salesrep ? 'false' : 'true' ?>">
			<?php if ($user_is_salesrep): ?>
				<?php
					echo $this->Form->create(
						'Payment',
						array(
							'url'         => getPaymentsUrl(),
							'class'       => 'user-search-form form form-inline cart-search-form',
							'data-submit' => 'once',
							'type'        => 'get',
							'data-type'   => 'payments-list-search-form'
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
								'data-type' => 'invoices-user-id'
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
									'data-ac-handler'  => '[data-type=invoices-user-id-container]',
									'data-ac-extended' => 'false',
									'data-ac-copy'     => '[data-type=invoices-user-id]',
									'div'              => array(
										'data-type' => 'invoices-user-id-container',
										'class'     => 'autocompleter-container'
									),
									'label'            => false,
									'class'            => 'form-control',
									'default'          => getPageParamValue('username')
								)
							)
						?>
					</div>
					
					<?php
						echo $this->Form->input(
							'order_id',
							array(
								'type'      => 'text',
								'div'       => 'form-row number-row',
								'label'     => __('Id zamówienia', true).':',
								'class'     => 'form-control',
								'default'   => getPageParamValue('order_id'),
								'data-send' => 'submit'
							)
						);
						
						echo $this->Form->input(
							'date_from',
							array(
								'type'      => 'text',
								'div'       => 'form-row from-row',
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
								'div'       => 'form-row to-row',
								'label'     => __('do', true).':',
								'class'     => 'form-control datepicker',
								'default'   => getPageParamValue('date_to'),
								'data-send' => 'submit'
							)
						);
					?>
					
					<div class="form-row pull-right">
						<input class="btn btn-form-size" type="submit" value="<?php echo h(__('Szukaj', true)) ?>">
					</div>
				<?php echo $this->Form->end() ?>
			<?php endif ?>
			
			<?php if ($payments): ?>
				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<th>
								<?php __('Lp.') ?>
							</th>
							<th>
								<?php __('Nr zamówienia') ?>
							</th>
							<th>
								<?php __('Numer faktury') ?>
							</th>
							<th>
								<?php __('Data płatności') ?>
							</th>
							<th>
								<?php __('Kwota') ?>
							</th>
							<th>
								<?php __('Pozostało') ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($payments as $key => $payment): ?>
							<tr>
								<td>
									<span class="table-responsive-label">
										<?php __('Lp.') ?>:
									</span>
									
									<?php echo $key + 1 ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Nr zamówienia') ?>:
									</span>
									
									<?php echo getOrderFullId($payment['Order']['id'], true) ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Numer faktury') ?>:
									</span>
									
									<?php echo !empty($payment['Invoice']['number']) ? $payment['Invoice']['number'] : '-' ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Data płatności') ?>:
									</span>
									
									<?php echo showDate($payment['Payment']['created']) ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Kwota') ?>:
									</span>
									
									<?php
										echo $this->Number->format(
											$payment['Payment']['amount'],
											array(
												'decimals'  => $payment['Order']['currency_separator'],
												'before'    => $payment['Order']['currency_left_symbol'],
												'after'     => $payment['Order']['currency_right_symbol'],
												'places'    => getCurrencyPrecision($payment['Order']['currency_code']),
												'thousands' => ''
											)
										)
									?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Pozostało') ?>:
									</span>
									
									<?php
										echo $this->Number->format(
											$payment['Payment']['paid'] > $payment['Payment']['to_pay'] ? 0 : $payment['Payment']['to_pay'] - $payment['Payment']['paid'],
											array(
												'decimals'  => $payment['Order']['currency_separator'],
												'before'    => $payment['Order']['currency_left_symbol'],
												'after'     => $payment['Order']['currency_right_symbol'],
												'places'    => getCurrencyPrecision($payment['Order']['currency_code']),
												'thousands' => ''
											)
										)
									?>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php else: ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'   => 'flat no-items',
							'message' => __('Nie znaleziono żadnych płatności.', true)
						)
					)
				?>
			<?php endif ?>
		</div>
		
		<?php if (!$user_is_salesrep): ?>
			<div class="page-sidebar">
				<?php
					/* Sidebar */
					echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
				?>
			</div>
		<?php endif ?>
	</div>
</div>
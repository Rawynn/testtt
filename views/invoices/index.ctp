<?php
	/* Czy zalogowany jest handlowcem */
	$user_is_salesrep = userIsSalesrep()
?>

<div class="user-invoices-list-page text-page list-page page invoice-page">
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-header">
		<h1>
			<?php
				echo $user_is_salesrep ? __('Faktury', true) : __('Moje faktury', true);
				
				if (!empty($username)):
					echo ' ('.$username.')';
				endif;
			?>
		</h1>
	</div>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-<?php echo $user_is_salesrep ? 'false' : 'true' ?>">
			<?php
				echo $this->Form->create(
					'Invoice',
					array(
						'url'         => getInvoicesUrl(),
						'class'       => 'user-search-form form form-user-search invoice-search-form',
						'data-submit' => 'once',
						'data-type'   => 'invoices-list-search-form',
						'type'        => 'get'
					)
				)
			?>
				<h2>
					<?php __('Wyszukaj') ?>
				</h2>
				
				<?php if ($user_is_salesrep): ?>
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
				<?php endif ?>
				
				<?php
					echo $this->Form->input(
						'number',
						array(
							'type'      => 'text',
							'div'       => 'form-row number-row',
							'label'     => __('Numer', true).':',
							'class'     => 'form-control',
							'default'   => getPageParamValue('number'),
							'data-send' => 'submit'
						)
					);
					
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
				?>
				
				<div class="form-row date-from-to">
					<?php
						echo $this->Form->input(
							'date_from',
							array(
								'type'      => 'text',
								'div'       => false,
								'label'     => __('Data wystawienia od', true).':',
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
						'type',
						array(
							'type'      => 'select',
							'div'       => 'form-row paid-row',
							'label'     => __('Typ', true).':',
							'class'     => 'form-control',
							'empty'     => __('-wybierz-', true),
							'default'   => getPageParamValue('type'),
							'data-send' => 'submit',
							'options'   => array(
								'vat'  => __('VAT', true),
								'prof' => __('proforma', true),
								'zal'  => __('zaliczkowa', true),
								'kor'  => __('korygująca', true)
							)
						)
					)
				?>
				
				<?php
					echo $this->Form->input(
						'paid',
						array(
							'type'      => 'select',
							'options'   => array(
								'y'      => __('tak', true),
								'n'      => __('nie', true),
								'partly' => __('częściowo', true)
							),
							'div'       => 'form-row paid-row',
							'label'     => __('Opłacone', true).':',
							'class'     => 'form-control',
							'empty'     => __('-wszystkie-', true),
							'default'   => getPageParamValue('paid'),
							'data-send' => 'submit'
						)
					)
				?>
				
				<div class="form-row pull-right">
					<input class="btn btn-form-size" type="submit" value="<?php echo h(__('Szukaj', true)) ?>">
				</div>
			<?php echo $this->Form->end() ?>
			
			<?php if ($invoices): ?>
				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<th>
								<?php __('Lp.') ?>
							</th>
							<th>
								<?php __('Numer') ?>
							</th>
							
							<?php if ($user_is_salesrep): ?>
								<th>
									<?php __('Klient') ?>
								</th>
							<?php endif ?>
							
							<th>
								<?php __('Data wystawienia') ?>
							</th>
							<th>
								<?php __('Typ') ?>
							</th>
							<th>
								<?php __('Do zapłaty') ?>
							</th>
							<th>
								<?php __('Pozostało') ?>
							</th>
							<th class="table-options">
								<?php __('Opcje') ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($invoices as $key => $invoice): ?>
							<tr>
								<td>
									<span class="table-responsive-label">
										<?php __('Lp.') ?>:
									</span>
									
									<?php echo $key + 1 ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Numer') ?>:
									</span>
									
									<?php echo $invoice['Invoice']['number'] ?>
								</td>
								
								<?php if ($user_is_salesrep): ?>
									<td>
										<span class="table-responsive-label">
											<?php __('Klient') ?>:
										</span>
										
										<?php echo $invoice['Username']['value'] ? $invoice['Username']['value'] : $invoice['Order']['username'] ?>
									</td>
								<?php endif ?>
								
								<td>
									<span class="table-responsive-label">
										<?php __('Data wystawienia') ?>:
									</span>
									
									<?php echo showDate($invoice['Invoice']['date_created']) ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Typ') ?>:
									</span>
									
									<?php echo getInvoiceTypeName($invoice['Invoice']['id']) ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Do zapłaty') ?>:
									</span>
									<?php echo showOrderPrice($invoice['Invoice']['to_pay'], $invoice['Invoice']['order_id'], null, $invoice['Invoice']['id']) ?>
								</td>
								<td>
									<span class="table-responsive-label">
										<?php __('Pozostało') ?>:
									</span>
									
									<?php if ($invoice['Invoice']['proforma']): ?>
										-
									<?php else:?>
										<?php echo showOrderPrice($invoice['Invoice']['paid'] > $invoice['Invoice']['to_pay'] ? 0 : $invoice['Invoice']['to_pay'] - $invoice['Invoice']['paid'], $invoice['Invoice']['order_id'], null, $invoice['Invoice']['id']) ?>
									<?php endif ?>
								</td>
								<td class="table-options">
									<?php if (!$user_is_salesrep): ?>
										<?php if (module('COMPLAINTS')): ?>
											<a href="<?php echo $this->Html->url(getComplaintAddUrl($invoice['Order']['id'], $invoice['Order']['code'], $invoice['Invoice']['id'])) ?>" title="<?php echo h(__('Reklamacja', true)) ?>">
												<i class="fa fa-exclamation-triangle"></i>
											</a>
										<?php endif ?>
									<?php endif ?>
									
									<?php if ($invoice['Invoice']['can_download']): ?>
										<a href="<?php echo $this->Html->url(getInvoiceDownloadUrl($invoice['Invoice']['id'])) ?>" title="<?php echo h(__('Pobierz plik PDF', true)) ?>" target="_blank">
											<i class="fa fa-download"></i>
										</a>
									<?php endif ?>
									
									<?php if (!empty($invoice['FileExtensions'])): ?>
										<?php $file_name = Inflector::slug($invoice['Invoice']['number']) ?>
										
										<?php foreach ($invoice['FileExtensions'] as $extension): ?>
											<a href="<?php echo $this->Html->url(getInvoiceDownloadUrl($invoice['Invoice']['id'], $extension)) ?>" title="<?php echo h($file_name.'.'.$extension) ?>" target="_blank">
												<i class="fa fa-download"></i>
											</a>
										<?php endforeach ?>
									<?php endif ?>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				
				<?php if (setting('OPTIMALIZATION_FRONTEND_INVOICES_LIST_PAGINATION')): ?>
					<?php
						/* Stronicowanie */
						echo $this->element(TEMPLATE_NAME.DS.'paginator',
							array(
								'class' => 'list-page-paginator'
							)
						)
					?>
				<?php endif ?>
			<?php else: ?>
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'message'.DS.'message',
						array(
							'class'   => 'flat no-items',
							'message' => __('Nie znaleziono żadnych faktur.', true)
						)
					)
				?>
			<?php endif ?>
		</div>
		
		<?php if (!$user_is_salesrep): ?>
			<div class="page-sidebar">
				<?php
					/* SideBar */
					echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
				?>
			</div>
		<?php endif ?>
	</div>
</div>
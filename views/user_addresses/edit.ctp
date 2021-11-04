<div class="user-address-edit-page user-page page">
	
	<div class="page-header">
		<h1>
			<?php if (userIsSalesrep()):?>
				<?php __('Edycja adresu klienta') ?> "<?php echo $user['User']['first_name'].' '.$user['User']['last_name'] ?>"
			<?php else:?>
				<?php __('Moje adresy') ?>
			<?php endif ?>
		</h1>
	</div>
	
	<?php
		/* Menu */
		echo $this->element(TEMPLATE_NAME.DS.'menu_user_account')
	?>
	
	<div class="page-content-container">
		<div class="page-content page-sidebar-true">
			<?php
				echo $this->Form->create(
					'UserAddress',
					array(
						'url'           => getUserAddressesEditUrl($id),
						'class'         => 'address-form form',
						'data-validate' => 'true',
						'data-submit'   => 'once',
						'escapeInputs'  => false
					)
				)
			?>
				<?php
					/* Wystawianie faktur */
					$invoice_type = getInvoiceType();
				?>
				
				<div class="form-inner form-inner-wider">
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'address_form',
							array(
								'prefix'           => 'UserAddress',
								'address_required' => true,
								'name_validate'    => empty($this->data['UserAddress']['company']) ? 'validate(required)' : '',
								'company_validate' => empty($this->data['UserAddress']['company']) ? '' : 'validate(required)',
								'add_invoice'      => true,
								'add_vat_checkbox' => false,
								'invoice_type'     => $invoice_type,
								'show_user_type'   => true
							)
						)
					?>
					
					<?php
						echo $this->Form->input(
							'invoice',
							array(
								'type'      => 'checkbox',
								'data-type' => 'invoice',
								'div'       => 'form-row checkbox',
								'label'     => $invoice_type == 1 ? __('Ustaw jako domyślne dane do faktury', true) : ($invoice_type == 2 ? __('Ustaw jako domyślne dane do faktury lub rachunku', true) : __('Ustaw jako domyślne dane do rachunku', true)),
								'disabled'  => isset($disable_invoice) && $disable_invoice
							)
						)
					?>
					
					<?php
						if (getPageParamValue('rt') || getPageParamValue('redirect_to') && userIsSalesrep()):
							echo $this->Form->hidden(
								'redirect_to',
								array(
									'value' => getPageParamValue('rt') ? getPageParamValue('rt') : getPageParamValue('redirect_to')
								)
							);
						endif;
					?>
					
					<span class="form-info required-info">
						<?php __('Pola oznaczone (*) są wymagane') ?>
					</span>
					
					<div class="form-actions">
						<a class="btn-back btn btn-pink btn-lg" href="<?php echo $this->Html->url(getPageParamValue('redirect_to') ? getPageParamValue('redirect_to') : getUserAddressesUrl()) ?>" title="<?php echo h(__('Anuluj', true)) ?>">
							<?php __('Anuluj') ?>
						</a>
						
						<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php echo h(__('Zapisz', true)) ?>">
					</div>
				</div>
			<?php echo $this->Form->end() ?>
		</div>
		
		<div class="page-sidebar">
			<?php
				/* Sidebar */
				echo $this->element(TEMPLATE_NAME.DS.'sidebar_page')
			?>
		</div>
	</div>
</div>
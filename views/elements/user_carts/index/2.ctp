<?php $is_address_required = checkCartAddressIsRequired() ?>
<hr>
<div class="row border-holder">
<div class="border-hold"></div>
<div class="order-form left">
	<div class="visible-xs create-account">
		<?php __('Masz już konto?') ?> <span data-type="scroll-to-login-page"><?php __('Zaloguj się') ?></span>.
	</div>
	<div class="order-section-header">
		<h2>
			<?php __('Dane klineta') ?>
		</h2>
	</div>
	
	<?php
		echo $this->Form->create(
			'UserCart',
			array(
				'url'           => getCartUrl($step),
				'class'         => 'address-form form',
				'data-validate' => 'true',
				'data-submit'   => 'once',
				'id'            => 'OrderFormUnlogged',
				'autocomplete'  => 'off'
			)
		)
	?>
		<div class="form-inner">
			<div data-type="vat-address">
				<?php
					echo $this->element(
						TEMPLATE_NAME.DS.'address_form',
						array(
							'prefix'           => 'UserAddress',
							'address_required' => $is_address_required,
							'add_invoice'      => true,
							'add_vat_checkbox' => true,
							'invoice_type'     => $invoice,
							'show_user_type'   => true
						)
					)
				?>
			</div>
			
			<?php
				echo $this->Form->input(
					'NewUser.email',
					array(
						'type'          => 'text',
						'data-validate' => 'validate(email)',
						'data-type'     => 'new-user-email',
						'div'           => 'form-row',
						'label'         => false,
						'placeholder'   => __('E-MAIL', true).':*',
						'class'         => 'form-control',
						'escape'        => false
					)
				);
				
				echo $this->Form->input(
					'OrderHistory.comment',
					array(
						'type'        => 'textarea',
						'class'       => 'comment',
						'div'         => 'form-row',
						'label'       => false,
						'placeholder' => __('KOMENTARZ', true).':',
						'class'       => 'form-control',
						'value'       => getCartOrderComment(),
						'rows'        => 4
					)
				);
			?>
			
			<?php
				if (getCartShippingCommentAvailable()):
					echo $this->Form->input(
						'OrderHistory.shipping_comment',
						array(
							'type'  => 'textarea',
							'class' => 'comment',
							'div'   => 'form-row',
							'label' => __('Uwagi dla kuriera', true).':',
							'class' => 'form-control',
							'value' => getCartShippingComment(),
							'rows'  => 4
						)
					);
				endif;
			?>
			
			<?php if (checkCartAddressIsRequired(false)): ?>
				<?php
					echo $this->Form->input(
						'ShippingAddress.active',
						array(
							'type'      => 'checkbox',
							'data-type' => 'toggle-shipping-address',
							'div'       => 'form-row checkbox',
							'label'     => __('Inny adres dostawy?', true)
						)
					)
				?>
				
				<?php $is_selected = !empty($this->data['ShippingAddress']['active']) && $this->data['ShippingAddress']['active'] == 1 ?>
				
				<div class="<?php echo !$is_selected ? 'hide' : '' ?>" data-type="shipping-address">
					<?php
						echo $this->element(
							TEMPLATE_NAME.DS.'address_form',
							array(
								'prefix'           => 'ShippingAddress',
								'add_invoice'      => false,
								'address_required' => true,
								'show_company'     => true,
								'name_validate'    => $is_selected ? (empty($this->data['ShippingAddress']['company']) ? 'validate(required)' : '') : '',
								'company_validate' => $is_selected ? (empty($this->data['ShippingAddress']['company']) ? '' : 'validate(required)') : '',
								'phone_validate'   => $is_selected ? 'validate(required)' : '',
								'address_validate' => $is_selected ? 'validate(required)' : '',
								'postal_validate'  => $is_selected ? 'validate(required, postal-{code})' : '',
								'disabled'         => $is_selected ? false : true,
								'show_user_type'   => true
							)
						)
					?>
				</div>
			<?php endif ?>
			
			<?php echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'2'.DS.'new_user') ?>
			
			<?php if (setting('GLOBAL_REGISTER_CONDITIONS_CONFIRMATION_REQUIRED')): ?>
				<?php
					echo $this->Form->input(
						'NewUser.regulamin',
						array(
							'type'          => 'checkbox',
							'data-validate' => 'validate(required)',
							'div'           => 'form-row checkbox',
							'label'         => sprintf(
								__('Przeczytałem/am i akceptuję %s.', true),
								$this->Html->link(
									
										__('Regulamin sklepu', true),
									getStaticPageUrl(getStaticPageConditionsId()),
									array(
										'target' => '_blank'
									)
								)
							)
						)
					)
				?>
			<?php endif ?>
			
			<?php if (setting('GLOBAL_REGISTER_PROCESSING_USER_DATA_CONFIRMATION_REQUIRED')): ?>
				<?php
					echo $this->Form->input(
						'NewUser.personal_data',
						array(
							'type'          => 'checkbox',
							'data-validate' => 'validate(required)',
							'div'           => 'form-row checkbox',
							'label'         => sprintf(
								__('Wyrażam zgodę na przetwarzanie moich danych osobowych w celu rejestracji konta i realizacji zamówienia przez sklep internetowy %s prowadzony przez %s z siedzibą w: %s, która jest administratorem danych osobowych. Zgodnie z Ustawą z dnia 29.08.1997 r. każdy Klient ma prawo wglądu do swoich danych, ich poprawiania, zarządzania, zaprzestania przetwarzania oraz zażądania ich usunięcia. Podanie danych jest dobrowolne, ale brak zgody uniemożliwia założenie konta i realizację zamówienia.', true),
								setting('GLOBAL_STORE_NAME'),
								setting('GLOBAL_STORE_COMPANY'),
								setting('GLOBAL_STORE_POSTCODE').' '.setting('GLOBAL_STORE_CITY').', '.setting('GLOBAL_STORE_STREET')
							)
						)
					)
				?>
			<?php endif ?>
			
			<?php if (showOpineoCheckbox()): ?>
				<?php
					echo $this->Form->input(
						'OrderField.opineo_agreement',
						array(
							'type'    => 'checkbox',
							'div'     => 'form-row checkbox',
							'label'   => __('Wyrażam zgodę na przesłanie na mój adres poczty elektronicznej ankiety w ramach programu "System Wiarygodne Opinie" oraz wyrażam zgodę na przetwarzanie i przekazanie moich danych osobowych - adresu e-mail oraz informacji o dokonanym zakupie, spółce Opineo Sp. z o.o. z siedzibą we Wrocławiu, 53-333 Wrocław, ul. Powstańców Śląskich 2-4.', true),
							'checked' => (bool) getCartOrderFieldValue('opineo_agreement')
						)
					)
				?>
			<?php endif ?>
			
			<?php if (showCeneoCheckbox()): ?>
				<?php
					echo $this->Form->input(
						'ModuleCeneo.ceneo_on_demand',
						array(
							'type'  => 'checkbox',
							'div'   => 'form-row checkbox',
							'label' => __('Wyrażam zgodę na przesłanie na mój adres poczty elektronicznej ankiety w ramach programu "Zaufane Opinie" oraz wyrażam zgodę na przetwarzanie i przekazanie moich danych osobowych - adresu e-mail oraz informacji o dokonanym zakupie, spółce Ceneo Sp. z o.o. z siedzibą w Poznaniu, 60-166 Poznań, ul. Grunwaldzka 182.', true)
						)
					)
				?>
			<?php endif ?>
			
			<?php echo $this->element(TEMPLATE_NAME.DS.'user_carts'.DS.'index'.DS.'2'.DS.'newsletter') ?>
		</div>
		
		<div class="form-actions hide">
			<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php __('Złóż zamówienie') ?>">
		</div>
	<?php echo $this->Form->end() ?>
</div>

<div class="login-form order-form right">
	<div class="order-section-header">
		<h2><?php __('Jesteś już klientem?')?></h2>
	</div>
	<?php
		/* Logowanie */
		echo $this->element(TEMPLATE_NAME.DS.'login_page')
	?>
</div>
</div>
<div class="order-actions form-actions link-action">
	<a class="btn-back btn btn-pink btn-lg" href="<?php echo $this->Html->url(getCartUrl(1)) ?>" title="<?php echo h(__('Strona główna', true)) ?>">
		<?php __('Wróć do sklepu') ?>
	</a>
	<input class="btn-next btn btn-primary btn-lg" type="submit" value="<?php __('Złóż zamówienie') ?>">
</div>
<script>
	$('.order-actions.form-actions.link-action input[type=submit]').click(function(){
		$('.address-form .form-actions .btn-next').trigger('click');
	});
</script>
